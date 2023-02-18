<?

declare(strict_types=1);

namespace App\Enums;

/**
 * The type of instance to use for a given class in the application container
 */
enum InstanceType
{
    /**
     * A scoped instance of a class is created each time it is requested from the container
     */
    case SCOPED;

    /**
     * A singleton instance of a class is created only once and returned on subsequent requests
     */
    case SINGLETON;
}
