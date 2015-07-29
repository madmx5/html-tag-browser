<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
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
