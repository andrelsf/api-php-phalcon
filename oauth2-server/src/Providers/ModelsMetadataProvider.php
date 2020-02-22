<?php

declare(strict_types=1);

namespace App\Phalcon\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Model\Metadata\Stream as MetaDataAdapter;

class ModelsMetadataProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'modelsMetadata';
    
    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var string $cacheDir */
        $cacheDir = $di->getShared('config')->path('application.cacheDir');
        $di->set($this->providerName, function () use ($cacheDir) {
            return new MetaDataAdapter([
                'metaDataDir' => $cacheDir . 'metaData/',
            ]);
        });
    }
}