<?php

// if you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);


// Add your own regular expression IP match here
$ips = array();
$ips[] = '127\.0\.0\.1';            // Local host
$ips[] = '::1';
$ips[] = '192\.168\.\d+\.\d+';      // 192.168.x.x

$allowed = false;
foreach ($ips as $ip) {
    if (preg_match("/^".$ip."$/", @$_SERVER['REMOTE_ADDR'])) {
        $allowed = true;
    }
}

if (! $allowed) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

use Symfony\Component\HttpFoundation\Request;

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$kernel->handle(Request::createFromGlobals())->send();
