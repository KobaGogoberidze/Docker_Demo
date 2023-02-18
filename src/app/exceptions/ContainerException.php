<?

declare(strict_types=1);

namespace App\Exceptions;

use Psr\Container\ContainerExceptionInterface;

/**
 * Exception thrown when there is an error with the container
 */
class ContainerException extends \Exception implements ContainerExceptionInterface
{
}
