<?

declare(strict_types=1);

namespace App;

use App\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;
use App\Exceptions\InstanceNotFoundException;
use ReflectionClass;

class Container implements ContainerInterface
{
    private array $instances = array();

    public function get(string $id)
    {
        if ($this->has($id)) {
            $instance = $this->instances[$id];

            if (is_callable($instance)) {
                return $instance($this);
            }

            $id = $instance;
        }

        return $this->resolve($id);

        throw new InstanceNotFoundException("Instance for {$id} not found");
    }

    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    public function set(string $id, callable|string $instanceProvider)
    {
        $this->instances[$id] = $instanceProvider;
    }

    private function resolve(string $id)
    {
        $reflectionClass = new \ReflectionClass($id);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("Class {$id} is not instantiable");
        }

        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $id;
        }

        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return new $id;
        }

        $dependencies = array_map(function (\ReflectionParameter $parameter) use ($id) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if (!$type) {
                throw new ContainerException("Failed to resolve {$id} class. Param: {$name} is missing type hint");
            }

            if ($type instanceof \ReflectionUnionType) {
                throw new ContainerException("Failed to resolve {$id} class. Param: {$name} is union type");
            }

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                return $this->get($type->getName());
            }

            throw new ContainerException("Failed to resolve {$id} class. Param: {$name} is invalid");
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}
