<?

declare(strict_types=1);

namespace App\Attributes;

use Attribute;
use App\Enums\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Get extends Route
{
    public function __construct(string $route)
    {
        parent::__construct($route, RequestMethod::GET);
    }
}
