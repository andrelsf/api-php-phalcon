<?php

namespace App\Phalcon\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class ErrorController extends Controller
{
    /**
     * Error 404 (page not found)
     * @return html page error
     */
    public function page404Action()
    {
        $response = new Response;

        $response->setContentType("application/json", "UTF-8");
        $response->setRawHeader("HTTP/1.1 404 Not Found");
        $response->setStatusCode(404, "Not Found");
        $response->setJsonContent(
            array(
                'status'  => '404',
                'message' => 'service not found or unavailable',
                'data'    => '',
            ),
            JSON_PRETTY_PRINT
        );

        return $response;
    }
}