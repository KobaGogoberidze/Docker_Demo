<?

declare(strict_types=1);

use Dotenv\Dotenv;

define('VIEW_PATH', __DIR__ . '/../views');
define('LAYOUT_PATH', __DIR__ . '/../views');
define('STORAGE_PATH', __DIR__ . '/../uploads');

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
