<?php

declare(strict_types=1);

namespace App\Phalcon\Controllers;

use OAuth2\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

/**
 * Display the default index page.
 */
class Oauth2Controller extends Controller
{
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function getTokenAction()
    {
        
        $this->oauth2->handleTokenRequest(Request::createFromGlobals())->send();
        //var_dump($this->oauth2);
        
    }
}