<?php

// Add the CSRF middleware to DIC
$app->add(new \Slim\Csrf\Guard);

// This needs to be our last Middleware which searches for a
// Bad Request method response from the Csrf\Guard Middleware
// It will then redirect the user back home with a nice error
$app->add(
    new App\Middleware\BadRequest(
        $app->getContainer()
    )
);
