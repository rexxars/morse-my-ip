<?php
require __DIR__ . '/../library/bootstrap.php';

$clientIp = getClientIp();
$morsedIp = (new Morse\Text())->toMorse($clientIp);

header('Content-Type: text/html; charset=utf-8');
header('X-Your-IP: ' . $clientIp);
header('X-Your-IP-Morse: ' . $morsedIp);

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>
<!doctype html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>What is my IP-address - Morse my IP.</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <link href="css/morsemyip.css?v2" rel="stylesheet" type="text/css">
</head>
<body>

<div class="splash-container">
    <div class="splash">
        <h2>Your IP-address is:</h2>
        <h1 class="splash-head">
            <?php echo $clientIp; ?>
            <div class="morse">
            <?php
            $blocks = explode(' ', $morsedIp);
            echo '<span>' . implode('</span> <span>', $blocks) . '</span>';
            ?>
            </div>
        </h1>
        <p>
            Turn on your speakers for the best experience ;-)
        </p>

        <div id="audio-controls"></div>

        <!--[if lte IE 7 ]>
        <script>
        window.morseMyIp = window.morseMyIp || {};
        window.morseMyIp.isOldIE = true;
        </script>
        <bgsound src="morse.php">
        <![endif]-->
    </div>
</div>

<script>
window.morseMyIp = window.morseMyIp || {};
window.morseMyIp.clientIP = <?php echo json_encode($clientIp); ?>
</script>

<div class="content-wrapper">
    <div class="footer">
        Created by Espen Hovlandsdal (<a href="http://twitter.com/rexxars">@rexxars</a>)<br />
        <a href="http://espen.codes/">espen.codes</a>
    </div>
</div>

<script src="js/bundle.js?v2"></script>

</body>
</html>