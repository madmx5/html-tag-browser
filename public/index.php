<?php

if (PHP_SAPI == 'cli-server') {
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require '../vendor/autoload.php';

session_start();

$app = new \Slim\App();

// Load middlewares
require '../app/middlewares.php';

// Inject service dependencies
require '../app/services.php';

// Load the application routes
require '../app/routes.php';

// Run the app
$app->run();
