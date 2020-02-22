<?php

declare(strict_types=1);

namespace App\Phalcon\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

/**
 * Display the default index page.
 */
class PingController extends Controller
{
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function pingAction()
    {
        $response = new Response();

        $response->setStatusCode(200, 'success');
        $response->setJsonContent(
            [
                'status' => 200,
                'message' => 'pong',
            ],
            JSON_PRETTY_PRINT
        );
        
        return $response;
    }
}