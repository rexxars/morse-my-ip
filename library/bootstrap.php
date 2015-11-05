<?php
require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$configPath = __DIR__ . '/../config/config.php';
if (file_exists($configPath) && is_readable($configPath)) {
    $config = require $configPath;

    Request::setTrustedProxies($config['trustedProxies']);
}

function getClientIp() {
    $request = Request::createFromGlobals();
    return $request->getClientIp();
}