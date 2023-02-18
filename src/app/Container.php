<?

declare(strict_types=1);

namespace App;

use App\Enums\InstanceType;
use Psr\Container\ContainerInterface;
use App\Exceptions\ContainerException;
use App\Exceptions\InstanceNotFoundException;

class Container implements ContainerInterface
{
    private array $entries = array();

    public function get(string $class)
    {
        if ($this->has($class)) {
            $entry = $this->entries[$class];

            if (is_object($entry)) {
                return $entry;
            }

            if (is_callable($entry)) {
                return $entry($this);
            }

            $class = $entry;
        }

        return $this->resolve($class);

        throw new InstanceNotFoundException("Instance for {$class} not found");
    }

    public function has(string $class): bool
    {
        return isset($this->entries[$class]);
    }

    public function set(string $class, callable|string $provider, InstanceType $type = InstanceType::SCOPED)
    {
        if ($type == InstanceType::SINGLETON) {
            if (is_callable($provider)) {
                $this->entries[$class] = $provider($this);
            } else {
                $this->entries[$class] = $this->resolve($provider);
            }
        } else {
            $this->entries[$class] = $provider;
        }

        return $this;
    }

    private function resolve(string $class)
    {
        $reflectionClass = new \ReflectionClass($class);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("Class {$class} is not instantiable");
        }

        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $class;
        }

        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return new $class;
        }

        $dependencies = array_map(function (\ReflectionParameter $parameter) use ($class) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if (!$type) {
                throw new ContainerException("Failed to resolve {$class} class. Param: {$name} is missing type hint");
            }

            if ($type instanceof \ReflectionUnionType) {
                throw new ContainerException("Failed to resolve {$class} class. Param: {$name} is union type");
            }

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                return $this->get($type->getName());
            }

            throw new ContainerException("Failed to resolve {$class} class. Param: {$name} is invalid");
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}
