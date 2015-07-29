<?php

$app->get('/', 'App\Action\Home:dispatch')
    ->setName('home');

$app->post('/', 'App\Action\Fetch:dispatch')
    ->setName('fetch');
