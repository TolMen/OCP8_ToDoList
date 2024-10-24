<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ErrorHandler\Debug; // Utilisez le composant ErrorHandler
use Symfony\Component\ErrorHandler\ErrorHandler;
use App\Kernel;

// Use the following line if you need to configure permissions (optional)
// umask(0000);

// Prevent access to the dev front controller from outside (optional, you can adjust the IPs as needed)
if (
    isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || php_sapi_name() === 'cli-server')
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check ' . basename(__FILE__) . ' for more information.');
}

// Load the autoloader
require dirname(__DIR__) . '/vendor/autoload.php';

// Enable the Debug component
Debug::enable(); // Active le mode de débogage

// Create the kernel instance for the 'dev' environment
$kernel = new Kernel('dev', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
