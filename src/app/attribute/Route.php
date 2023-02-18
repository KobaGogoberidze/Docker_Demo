<?

declare(strict_types=1);

namespace App\Attributes;

use Attribute;
use App\Enums\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Route
{
    public function __construct(public string $route, public RequestMethod $method)
    {
    }
}