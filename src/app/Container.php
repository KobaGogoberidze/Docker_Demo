<?

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;
use App\Exceptions\InstanceNotFoundException;

class Container implements ContainerInterface
{
    private array $instances = array();

    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new InstanceNotFoundException("Instance for {$id} not found");
        }

        $instance = $this->instances[$id];

        return $instance($this);
    }

    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    public function set(string $id, callable $instanceProvider)
    {
        $this->instances[$id] = $instanceProvider;
    }
}
