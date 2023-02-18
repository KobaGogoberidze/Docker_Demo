<?

declare(strict_types=1);

namespace App\Enums;

enum RequestMethod: string
{
    case POST = 'POST';
    case GET = 'GET';
    case PUT = 'PUT';
}
