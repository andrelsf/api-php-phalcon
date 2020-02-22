<?php

declare(strict_types=1);

namespace App\Phalcon\Providers;

use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

class ViewProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'view';

    /**
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        /** @var Config $config */
        $config = $di->getShared('config');
        /** @var string $viewsDir */
        $viewsDir = $config->path('application.viewsDir');
        /** @var string $cacheDir */
        $cacheDir = $config->path('application.cacheDir');

        $di->setShared($this->providerName, function () use ($viewsDir, $cacheDir, $di) {
            $view = new View();
            $view->setViewsDir($viewsDir);
            $view->registerEngines([
                '.volt' => function (View $view) use ($cacheDir, $di) {
                    $volt = new Volt($view, $di);
                    $volt->setOptions([
                        'path'      => $cacheDir . 'volt/',
                        'separator' => '_',
                    ]);

                    return $volt;
                },
            ]);

            return $view;
        });
    }
}