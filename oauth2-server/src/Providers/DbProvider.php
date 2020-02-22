<?php

declare(strict_types=1);

namespace App\Phalcon\Providers;

use Oauth2\Storage\Pdo;
use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo as PdoPhalcon;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use RuntimeException;

use function App\Phalcon\root_path;

class DbProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'db';
    
    /**
     * Class map of database adapters, indexed by PDO::ATTR_DRIVER_NAME.
     *
     * @var array
     */
    protected $adapters = [
        'mysql'  => Pdo::class,//Pdo\Mysql::class,
        'pgsql'  => PdoPhalcon\Postgresql::class,
        'sqlite' => PdoPhalcon\Sqlite::class,
    ];
    
    /**
     * @param DiInterface $di
     *
     * @return void
     * @throws RuntimeException
     */
    public function register(DiInterface $di): void
    {
        /** @var Config $config */
        $config = $di->getShared('config')->get('oauth2');
        $class  = $this->getClass($config);
        $config = $this->createConfig($config);
        $di->set(
            $this->providerName,
            function () use ($class, $config) {
                return new $class($config);
            }
        );
    }

    /**
     * Get an adapter class by name.
     *
     * @param Config $config
     *
     * @return string
     * @throws RuntimeException
     */
    private function getClass(Config $config): string
    {
        $name = $config->get('adapter', 'Unknown');
        if (empty($this->adapters[$name])) {
            throw new RuntimeException(
                sprintf(
                    'Adapter "%s" has not been registered',
                    $name
                )
            );
        }
        return $this->adapters[$name];
    }

    private function createConfig(Config $config): array
    {
        // To prevent error: SQLSTATE[08006] [7] invalid connection option "adapter"
        $dbConfig = $config->toArray();
        unset($dbConfig['adapter']);
        $name = $config->get('adapter');
        switch ($this->adapters[$name]) {
            case PdoPhalcon\Sqlite::class:
                // Resolve database path
                $dbConfig = ['dbname' => root_path("db/{$config->get('dbname')}.sqlite3")];
                break;
            case PdoPhalcon\Postgresql::class:
                // Postgres does not allow the charset to be changed in the DSN.
                unset($dbConfig['charset']);
                break;
        }
        return $dbConfig;
    }
}