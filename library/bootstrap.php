<?php
require __DIR__ . '/../vendor/autoload.php';

function getClientIp() {
    $request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
    return $request->getClientIp();
}