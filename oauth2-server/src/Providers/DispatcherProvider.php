<?php

declare(strict_types=1);

namespace App\Phalcon\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Dispatcher;

class DispatcherProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'dispatcher';
    
    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->set(
            $this->providerName, 
            function () {
                // Create an EventsManager
                $eventsManager = new \Phalcon\Events\Manager();

                // Attach a listener
                $eventsManager->attach(
                    'dispatch',
                    function ($event, $dispatcher, $exception)
                    {
                        // A controller exists but the action not
                        if ($event->getType() == 'beforeNotFountAction') {
                            $dispatcher->forward(
                                [
                                    'namespace' => 'App\Phalcon\Controllers',
                                    'controller' => 'error',
                                    'action'    => 'page404',
                                ]
                            );

                            return false;
                        }
                        
                        // Alternative way, controller or action doesn't exist
                        if ($event->getType() == 'beforeException') {
                            switch ($exception->getCode()) {
                                case \Phalcon\Dispatcher\Exception::EXCEPTION_HANDLER_NOT_FOUND:
                                case \Phalcon\Dispatcher\Exception::EXCEPTION_ACTION_NOT_FOUND:
                                    $dispatcher->forward(array(
                                        'namespace'  => 'App\Phalcon\Controllers',
                                        'controller' => 'error',
                                        'action'     => 'page404'
                                    ));
                                    return false;
                            }
                        }
                    }
                );

                $dispatcher = new Dispatcher();

                $dispatcher->setEventsManager($eventsManager);
                $dispatcher->setDefaultNamespace('App\Phalcon\Controllers');
                return $dispatcher;
            }
        );
    }
}