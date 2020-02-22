<?php

declare(strict_types=1);

/**
 * @var $router Router
 */

$router->removeExtraSlashes(true);

$router->setDefaults([
    'controller' => 'error',
    'action'     => 'page404',
]);

$router->addGet('/ping', [
    'controller' => 'ping',
    'action'     => 'ping',
]);

/**
 * Method GET:
 * Endpoint: /api/robots
 * @request curl -i -X GET http://localhost/api/robots
 */
$router->addGet('/oauth', [
    'controller' => 'oauth2',
    'action'     => 'getToken'
]);

// /**
//  * Method GET
//  * Endpoint: /api/robots/search/{name}
//  * @request curl -i -X GET http://localhost/api/robots/search/PO
//  */
// $router->addGet(
//     '/api/robots/search/{name}',
//     [
//         'controller'    => 'robots',
//         'action'        => 'searchRobots'
//     ]
// );

// /**
//  * Method GET
//  * Endpoint: /api/robots/1
//  * @request curl -i -X GET http://localhost/api/robots/1
//  */
// $router->addGet(
//     '/api/robots/{id:[0-9]+}',
//     [
//         'controller'    => 'robots',
//         'action'        => 'getById'
//     ]
// );

// /**
//  * Method POST: /api/robots
//  * @request curl -i -X POST \
//  *          -H 'Content-Type: application/json' \
//  *          -d '{"name":"C-3PO","type":"droid","year":1977}' \
//  *          http://localhost/api/robots
//  */
// $router->addPost(
//     '/api/robots',
//     [
//         'controller' => 'robots',
//         'action'     => 'createRobot',
//     ]
// );

// /**
//  * Method PUT
//  * Endpoint: /api/robots/{id:}
//  * @request curl -i -X PUT \
//  *          -H 'Content-Type: application/json' \
//  *          -d '{"name":"CryBot-1","type":"virtual","year":2020}' \
//  *          http://localhost/api/robots/3
//  */
// $router->addPut(
//     '/api/robots/{id:[0-9]+}',
//     [
//         'controller' => 'robots',
//         'action'     => 'updateRobot',
//     ]
// );

// /**
//  * Method DELETE
//  * Endpoint: /api/robots/{id:}
//  * @request curl -i -X DELETE http://localhost/api/robots/8
//  */
// $router->addDelete(
//     '/api/robots/{id:[0-9]+}',
//     [
//         'controller' => 'robots',
//         'action'     => 'deleteRobot'
//     ]
// );
