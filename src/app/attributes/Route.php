<?

declare(strict_types=1);

namespace App\Attributes;

use Attribute;
use App\Enums\RequestMethod;

/**
 * Attribute class used to annotate controller methods that should handle HTTP requests
 *
 * @Annotation
 * @Target({"METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Route
{
    /**
     * Create a new HTTP route
     *
     * @var string $route The route pattern
     * @var string $method HTTP method
     */
    public function __construct(public string $route, public RequestMethod $method)
    {
    }
}
