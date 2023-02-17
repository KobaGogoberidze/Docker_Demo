<?

declare(strict_types=1);

namespace App;

use App\Config;
use App\Exceptions\RouteNotFoundException;

class App
{
    private static DB $db;

    public function __construct(protected Router $router, protected array $request, protected Config $config)
    {
        static::$db = new DB($config->db ?? array());
    }

    public static function db()
    {
        return static::$db;
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}
