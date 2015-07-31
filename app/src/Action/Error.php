<?php

namespace App\Action;

class Error extends ServicesDependantAction
{
    public function dispatch($request, $response, $exception)
    {
        if ($exception instanceof \GuzzleHttp\Exception\ConnectException) {
            $message = 'There was an error connecting to the specified URL or the request timed out!';
        }
        else if ($exception instanceof \GuzzleHttp\Exception\ClientException) {
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
            $this->service['logger']->log('error', 'Failed to browse URL due to exception', [
                'q' => $data['q'],
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

        $this->service['flash']->addMessage('danger', $message);

        return $response->withStatus(302)->withHeader('Location',
            $this->service['router']->pathFor('home'));
    }
}
