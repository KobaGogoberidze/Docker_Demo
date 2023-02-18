<?

use App\App;
use App\Controllers;

require_once '../vendor/autoload.php';
require_once '../app/Bootstrap.php';


$app = new App($container);
$app->getRouter()
    ->registerControllerRoutes(array(
        Controllers\HomeController::class
    ));

$app->run();
