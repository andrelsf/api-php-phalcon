<?php

use App\Phalcon\Application;

error_reporting(E_ALL);

$rootPath = dirname(__DIR__);

try {
    require_once $rootPath . '/vendor/autoload.php';
    
    /**
     * Load .env configurations
     */
    Dotenv\Dotenv::create($rootPath)->load();
    
    /**
     * Run APP!
     */
    echo (new Application($rootPath))->run();

} catch (\Phalcon\Mvc\Application\Exception $e) {
    print "APP_ERROR: " . $e->getTraceAsString();
    echo nl2br(htmlentities($e->getTraceAsString()));
} catch (Phalcon\Mvc\Dispatcher\Exception $e) {
    print "APP_ERROR: " . $e->getTraceAsString();
    echo nl2br(htmlentities($e->getTraceAsString()));
}