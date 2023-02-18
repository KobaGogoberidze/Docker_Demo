<?

declare(strict_types=1);

namespace App\Enums;

/**
 * An enumeration of supported HTTP request methods
 */
enum RequestMethod: string
{
    /**
     * Represents the HTTP POST method
     */
    case POST = 'POST';

    /**
     * Represents the HTTP GET method
     */
    case GET = 'GET';

    /**
     * Represents the HTTP PUT method
     */
    case PUT = 'PUT';
}