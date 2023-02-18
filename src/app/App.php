<?

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

class App
{
    private static Container $container;

    public function __construct(Container $container)
    {
        static::$container = $container;
    }

    public static function getContainer()
    {
        return static::$container;
    }

    public static function getDB()
    {
        return static::getContainer()->get(DB::class);
    }

    public static function getRequest()
    {
        return static::getContainer()->get(Request::class);
    }

    public static function getRouter()
    {
        return static::getContainer()->get(Router::class);
    }

    public function run()
    {
        try {
            echo static::getRouter()->resolve(static::getRequest());
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}
