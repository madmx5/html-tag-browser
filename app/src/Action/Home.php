<?php

namespace App\Action;

class Home extends ServicesDependantAction
{
    public function dispatch($request, $response, $args)
    {
        // Render the home page to the HTTP response
        $this->service['view']->render($response, 'index.html', [
            'csrf_name'  => $request->getAttribute('csrf_name'),
            'csrf_value' => $request->getAttribute('csrf_value'),
            'messages' => $this->service['flash']->getMessages(),
        ]);

        return $response;
    }
}
