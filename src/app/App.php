<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

/**
 * Application class responsible for managing the application lifecycle
 */
class App
{
    /**
     * The container instance
     *
     * @var Container
     */
    private static Container $container;

    /**
     * App constructor
     *
     * @param Container $container The container instance
     */
    public function __construct(Container $container)
    {
        static::$container = $container;
    }

    /**
     * Get the container instance
     *
     * @return Container The container instance
     */
    public static function getContainer(): Container
    {
        return static::$container;
    }

    /**
     * Get the database connection instance
     *
     * @return DB The database connection instance
     */
    public static function getDB(): DB
    {
        return static::getContainer()->get(DB::class);
    }

    /**
     * Get the current request instance
     *
     * @return Request The current request instance
     */
    public static function getRequest(): Request
    {
        return static::getContainer()->get(Request::class);
    }

    /**
     * Get the router instance
     *
     * @return Router The router instance
     */
    public static function getRouter(): Router
    {
        return static::getContainer()->get(Router::class);
    }

    /**
     * Run the application
     *
     * @return void
     */
    public function run(): void
    {
        try {
            $response = static::getRouter()->resolve(static::getRequest());

            echo $response;
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}
