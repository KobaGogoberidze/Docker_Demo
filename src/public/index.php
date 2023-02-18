<?

use App\App;
use App\Config;
use App\Router;
use App\Request;
use App\Container;
use App\Controllers;
use App\Enums\InstanceType;
use App\Services\EmailService;
use App\Interfaces\CommunicationInterface;

require_once '../vendor/autoload.php';
require_once '../app/Bootstrap.php';

$container = new Container();
$container
    ->set(Container::class, fn (Container $container) => $container, InstanceType::SINGLETON)
    ->set(Config::class, fn () => new Config($_ENV), InstanceType::SINGLETON)
    ->set(Request::class, fn () => new Request($_SERVER), InstanceType::SINGLETON)
    ->set(Router::class, Router::class, InstanceType::SINGLETON)
    ->set(CommunicationInterface::class, EmailService::class);

$app = new App($container);
$app->getRouter()
    ->registerControllerRoutes(array(
        Controllers\HomeController::class
    ));

$app->run();
