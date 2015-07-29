<?php

// Fetch DI Container
$container = $app->getContainer();

// Define a custom error handler for our application
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        if ($exception instanceof GuzzleHttp\Exception\ConnectException) {
            $message = 'There was an error connecting to the specified URL or the request timed out!';
        }
        else if ($exception instanceof GuzzleHttp\Exception\ClientException) {
            if ($exception->getCode()) {
                $message = 'Unable to fetch the specified URL, the web server returned status ' . $exception->getCode() . '!';
            }
            else {
                $message = 'There was an error connecting to the specified URL!';
            }
        }
        else {
            $message = 'Something went wrong, but we\'re looking into it. Please try your request again.';
        }

        $data = $request->getParsedBody();

        // Attempt to log the error for debugging purposes
        if (is_array($data) && ! empty($data['q'])) {
            $c['logger']->log('error', 'Failed to browse URL due to exception', [
                'q' => $data['q'],
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

        $c['flash']->addMessage('danger', $message);
        return $c['response']->withStatus(302)->withHeader('Location', $c['router']->pathFor('home'));
    };
};

// Instantiate and add Slim specific extension
$view = new \Slim\Views\Twig(
    realpath(__DIR__ . '/templates'),
    [
        'cache' => realpath(__DIR__ . '/../cache/twig'),
        'debug' => false,
    ]
);
$view->addExtension(new \Slim\Views\TwigExtension(
    $container->get('router'),
    $container->get('request')->getUri()
));
// Uncomment the following if you wish to use Twig dump function
// Note that Twig must also be initialized with debug = true (above)
$view->addExtension(new Twig_Extension_Debug());

// Register Twig View helper
$container->register($view);

// Register logger
$container['logger'] = function ($c) {
    $log = new \Monolog\Logger('app');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log', \Monolog\Logger::DEBUG));
    return $log;
};

// Register provider
$container->register(new \Slim\Flash\Messages());

// Register URL fetcher service
$container['fetcher'] = function ($c) {
    $client = new \GuzzleHttp\Client([ 'timeout' => 2.0 ]);
    return new App\Fetcher\Guzzle($client);
};

// Register Http Response reader service
$container['reader'] = function ($c) {
    return new App\Reader\GuzzleHttpPsr7Response();
};

// Register Document parser service
$container['parser'] = function ($c) {
    return new App\Parser\DOMDocument($c['reader']);
};

// Register decorator service
$container['decorator'] = function ($c) {
    return new App\Decorator\SourceTag();
};

// Register application Home action
$container['App\Action\Home'] = function ($c) {
    return new App\Action\Home($c);
};

// Register application Fetch action
$container['App\Action\Fetch'] = function ($c) {
    return new App\Action\Fetch($c);
};
