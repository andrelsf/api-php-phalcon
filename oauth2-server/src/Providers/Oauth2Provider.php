<?php

declare(strict_types=1);

namespace App\Phalcon\Providers;

//require_once __DIR__ . '/../../oauth2/src/OAuth2/Autoloader.php';
//require_once __DIR__ . '/../../oauth2/src/OAuth2/Storage/Pdo.php';

use App\OAuth2\Autoloader;
use App\Oauth2\Storage\Pdo;
use App\Phalcon\Application;
use OAuth2\GrantType\ClientCredentials;
use App\OAuth2\Server;
use \Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class Oauth2Provider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'oauth2';

    /**
     * @var string
     */
    private static $dsn;
    private static $user;
    private static $pass;

    /**
     * @param DiInterface $di
     * 
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var Application $application */
        $application = $di->getShared(Application::APPLICATION_PROVIDER);

        /** @var array $config */
        $config = $di->getShared('config')->get('oauth2');
        $di->set(
            $this->providerName,
            function () use ($config) {
                autoloader::register();
                
                self::$user = $config['username'];
                self::$pass = $config['password'];
                self::$dsn = $config['adapter'] . ":host=" . $config['host'] . ";dbname=" . $config['dbname'] . ";port=" . $config['port'];

                $storage = new Pdo(self::$dsn, self::$user, self::$pass);
                
                $server = new Server($storage);
                $server->addGrantType(new ClientCredentials($storage));
            }
        );
    }
}