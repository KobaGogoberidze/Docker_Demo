<?

declare(strict_types=1);

use App\Config;
use App\Router;
use App\Request;
use App\Container;
use Dotenv\Dotenv;
use App\Enums\InstanceType;
use App\Services\EmailService;
use App\Interfaces\CommunicationInterface;

define('VIEW_PATH', __DIR__ . '/../views');
define('STORAGE_PATH', __DIR__ . '/../uploads');

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$container = new Container();
$container
    ->set(Config::class, fn () => new Config($_ENV), InstanceType::SINGLETON)
    ->set(Request::class, fn () => new Request($_SERVER), InstanceType::SINGLETON)
    ->set(Router::class, fn () => new Router($container), InstanceType::SINGLETON)
    ->set(CommunicationInterface::class, EmailService::class);
