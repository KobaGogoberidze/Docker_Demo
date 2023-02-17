<?

declare(strict_types=1);

namespace App;

use App\Config;
use App\Exceptions\RouteNotFoundException;
use App\Services\EmailService;
use App\Services\SmsService;

class App
{
    private static DB $db;
    private static Container $container;

    public function __construct(protected Router $router, protected array $request, protected Config $config)
    {
        static::$db = new DB($config->db ?? array());
        static::$container = new Container();

        static::$container->set(EmailService::class, fn () => new EmailService());
        static::$container->set(SmsService::class, fn () => new SmsService());
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
