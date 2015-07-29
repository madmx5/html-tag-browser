<?php

namespace App\Action;

use Interop\Container\ContainerInterface;

abstract class ServicesDependantAction
{
    protected $service;

    public function __construct(ContainerInterface $service)
    {
        // Allows injecting of a service container to an action
        $this->service = $service;
    }
}
