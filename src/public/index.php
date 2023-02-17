<?

use App\App;
use App\Router;
use App\Config;
use App\Container;
use App\Controllers;

require_once '../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('STORAGE_PATH', __DIR__ . '/../uploads');
define('VIEW_PATH', __DIR__ . '/../views');

$config = new Config($_ENV);
$request = array('uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']);

$container = new Container();

$router = new Router($container);
$router->get('/', array(Controllers\HomeController::class, 'index'));

$app = new App($router, $request, $config);
$app->run();
