<?php

declare(strict_types=1);

namespace App\Phalcon\Providers;

use Phalcon\Crypt;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class CryptProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'crypt';
    
    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var string $cryptSalt */
        $cryptSalt = $di->getShared('config')->path('application.cryptSalt');
        $di->set($this->providerName, function () use ($cryptSalt) {
            $crypt = new Crypt();
            $crypt->setKey($cryptSalt);
            return $crypt;
        });
    }
}