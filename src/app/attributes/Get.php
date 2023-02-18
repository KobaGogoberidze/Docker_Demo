<?

declare(strict_types=1);

namespace App\Attributes;

use Attribute;
use App\Enums\RequestMethod;

/**
 * Attribute class used to annotate controller methods that should handle GET requests
 *
 * @Annotation
 * @Target({"METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Get extends Route
{
    /**
     * Create a new GET route
     *
     * @param string $route The route pattern
     */
    public function __construct(string $route)
    {
        parent::__construct($route, RequestMethod::GET);
    }
}
