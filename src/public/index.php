<?

use App\View;

require_once '../vendor/autoload.php';

session_start();

define('STORAGE_PATH', __DIR__ . '/../uploads');
define('VIEW_PATH', __DIR__ . '/../views');

try {

    $router = new App\Router();

    $router
        ->get('/', [App\Controllers\HomeController::class, 'index'])
        ->post('/upload', [App\Controllers\HomeHomeController::class, 'upload'])
        ->get('/invoices', [App\Controllers\InvoicesController::class, 'index'])
        ->get('/invoices/create', [App\Controllers\InvoicesController::class, 'create'])
        ->post('/invoices/create', [App\Controllers\InvoicesController::class, 'store']);

    echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
} catch (App\Exceptions\RouteNotFoundException $e) {
    http_response_code(404);
    echo View::make('error/404');
}
