<?php

declare(strict_types=1);

use function App\Phalcon\root_path;

return [
    'application' => [
        'baseUri'         => getenv('APP_BASE_URI'),
        'viewsDir'        => root_path('themes/appphalcon/'),
        'cacheDir'        => root_path('var/cache/'),
        'sessionSavePath' => root_path('var/cache/session/'),
    ],
    'database'    => [
        'adapter'  => getenv('DB_ADAPTER'),
        'host'     => getenv('MYSQL_HOST'),
        'port'     => getenv('MYSQL_TCP_PORT'),
        'username' => getenv('MYSQL_USER'),
        'password' => getenv('MYSQL_PASSWORD'),
        'dbname'   => getenv('MYSQL_DATABASE'),
    ]
];