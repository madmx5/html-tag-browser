<?php

// Add the CSRF middleware to DIC
$app->add(new \Slim\Csrf\Guard);
