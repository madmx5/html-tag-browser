<?php

namespace App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class BadRequest implements ServiceProviderInterface
{
    protected $container;

    protected $defaults = [
            'route' => 'home',
            'flash' => 'warning',
            'message' => 'Your request can not be completed at this time, please try again.',
        ];

    public function __construct(\Pimple\Container $container, array $options = [])
    {
        $this->container = $container;
        $this->options = array_merge($this->defaults, $options);
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $response = $next($request, $response);

        if ($response->getStatusCode() != 400) {
            return $response;
        }

        $this->container['flash']->addMessage($this->options['flash'],
            $this->options['message']
        );

        return $response->withHeader('Location',
            $this->container['router']->pathFor($this->options['route'])
        );
    }

    public function register(Container $container)
    {
        $container['badrequest'] = $this;
    }

    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }
}
