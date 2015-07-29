<?php

namespace App\Action;

use GuzzleHttp\Psr7\StreamWrapper;

class Fetch extends ServicesDependantAction
{
    public function dispatch($request, $response, $args)
    {
        $data = $request->getParsedBody();

        // Attempt to parse the URL
        if ( ! is_array($data) || empty($data['q'])) {
            $this->service['flash']->addMessage('info',
                'You forgot to specify a URL to browse!');

            return $response->withStatus(302)->withHeader('Location',
                $this->service['router']->pathFor('home'));
        }

        // Make sure we suppor the URL scheme
        $scheme = parse_url($data['q'], PHP_URL_SCHEME);

        if ( ! in_array($scheme, ['http', 'https'])) {
           if (empty($scheme)) {
               // Attempt a resonable default if the user failed to provide http://
               $data['q'] = 'http://' . $data['q'];
           }
           else {
               $this->service['flash']->addMessage('info',
                   'Sorry, at this time only http:// and https:// URLs are supported!');

               return $response->withStatus(302)->withHeader('Location',
                   $this->service['router']->pathFor('home'));
           }
        }

        // Ensure that the input provided is reasonably sane
        $url = filter_var($data['q'], FILTER_VALIDATE_URL);

        if ( ! $url) {
            $this->service['flash']->addMessage('danger',
                'The URL provided does not appear to be valid!');

            return $response->withStatus(302)->withHeader('Location',
                $this->service['router']->pathFor('home'));
        }

        // Use the URL fetcher service to obtain HTML source
        $fetcher = $this->service['fetcher'];
        $fetcher->setResource($url);
        $fetcher->fetch();

        // Send the HTML source over to the parser service
        $parser = $this->service['parser'];
        $parser->parse($fetcher->getResponse());

        // Decorate the source for our frontend application
        $source = $this->service['decorator']->decorate(
          $this->service['reader']->getContents()
        );

        // Obtain list of unique document tags and the count of each
        $tags = $parser->getCountByTagName();
        arsort($tags);

        // Render the view to the HTTP response
        $this->service['view']->render($response, 'fetch.html', [
            'csrf_name' => $request->getAttribute('csrf_name'),
            'csrf_value' => $request->getAttribute('csrf_value'),
            'tags' => $tags,
            'html' => $source,
            'url' => $url,
        ]);

        return $response;
    }
}
