<?php

declare(strict_types=1);

namespace App;

/**
 * Configuration class that reads the environment variables and provides access to them
 */
class Config
{
    /**
     * Array of configuration values
     * 
     * @var array
     */
    protected array $config;

    /**
     * Config constructor
     *
     * @param array $env The array of environment variables
     */
    public function __construct(array $env)
    {
        $this->config = array(
            'db' => array(
                'dbname' => $env['DB_DATABASE'],
                'user' => $env['DB_USER'],
                'password' => $env['DB_PASS'],
                'host' => $env['DB_HOST'],
                'driver' => $env['DB_DRIVER']
            )
        );
    }

    /**
     * Magic method to get configuration values
     *
     * @param string $name The name of the configuration value
     * @return mixed|null The configuration value, or null if it doesn't exist
     */
    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
