<?php
require __DIR__ . '/../library/bootstrap.php';

$clientIp = getClientIp();
$wavFile = (new Morse\Wav())->generate($clientIp);
$contentLength = strlen($wavFile);

header('Content-Type: audio/wav');
header('X-Pad: avoid browser bug');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Accept-Ranges: bytes');

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$seekStart = 0;
$seekEnd = $contentLength;

if (isset($_SERVER['HTTP_RANGE'])) {
    list($sizeUnit, $rangeOrig) = explode('=', $_SERVER['HTTP_RANGE'], 2);

    $range = '';
    if ($sizeUnit == 'bytes') {
        // Multiple ranges could be specified at the same time,
        // but for simplicity only serve the first range
        $ranges = explode(',', $rangeOrig, 2);
        $range = reset($ranges);
    }

    // Figure out download piece from range (if set)
    if (preg_match('#^\-\d+$#', $range)) {
        $seek = (int) preg_replace('#[^\d]#', '', $range);
        $seekStart = $contentLength - $seek;
        $seekEnd = $contentLength;
    } else if (preg_match('#^\d+\-$#', $range)) {
        $seekStart = (int) $range;
        $seekEnd = $contentLength;
    } else if (preg_match('#^\d+\-\d+$#', $range)) {
        list($seekStart, $seekEnd) = explode('-', $range);
    }
}

// Set start and end based on range (if set), else set defaults. Also, check for invalid ranges.
$seekEnd = (empty($seekEnd)) ? ($contentLength - 1) : min(abs(intval($seekEnd)), ($contentLength - 1));
$seekStart = (empty($seekStart) || $seekEnd < abs(intval($seekStart))) ? 0 : max(abs(intval($seekStart)), 0);

// Only send partial content header if downloading a piece of the file (IE workaround)
if ($seekStart > 0 || $seekEnd < ($contentLength - 1)) {
    header('HTTP/1.1 206 Partial Content');
}

$chunk = substr($wavFile, $seekStart, $seekEnd - $seekStart);

header('Accept-Ranges: bytes');
header('Content-Range: bytes ' . $seekStart . '-' . $seekEnd . '/' . $contentLength);
header('Content-Length: ' . strlen($chunk));

echo $chunk;
