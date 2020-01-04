<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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

// } catch (Exception $e) {
//     echo $e->getMessage(), '<br>';
//     echo nl2br(htmlentities($e->getTraceAsString()));
// }
} catch (\Phalcon\Mvc\Application\Exception $e) {
    print "APP_ERROR: " . $e->getTraceAsString();
    echo nl2br(htmlentities($e->getTraceAsString()));
} catch (Phalcon\Mvc\Dispatcher\Exception $e) {
    print "APP_ERROR: " . $e->getTraceAsString();
    echo nl2br(htmlentities($e->getTraceAsString()));
}