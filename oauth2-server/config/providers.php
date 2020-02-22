<?php

declare(strict_types=1);

use App\Phalcon\Providers\ConfigProvider;
use App\Phalcon\Providers\CryptProvider;
use App\Phalcon\Providers\Oauth2Provider;
use App\Phalcon\Providers\DbProvider;
use App\Phalcon\Providers\DispatcherProvider;
use App\Phalcon\Providers\ModelsMetadataProvider;
use App\Phalcon\Providers\RouterProvider;
use App\Phalcon\Providers\UrlProvider;
use App\Phalcon\Providers\ViewProvider;

return [
    ConfigProvider::class,
    // CryptProvider::class,
    Oauth2Provider::class,
    DbProvider::class,
    DispatcherProvider::class,
    ModelsMetadataProvider::class,
    RouterProvider::class,
    UrlProvider::class,
    ViewProvider::class,
];