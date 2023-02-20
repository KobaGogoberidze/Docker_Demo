<?php

declare(strict_types=1);

namespace App;

use App\Enums\InstanceType;
use Psr\Container\ContainerInterface;
use App\Exceptions\ContainerException;
use App\Exceptions\InstanceNotFoundException;

/**
 * A simple container that allows for dependency injection and lazy instantiation of classes and their dependencies
 */
class Container implements ContainerInterface
{
    private array $entries = array();

    /**
     * Retrieves an entry of the container by its identifier
     *
     * @param string $class The identifier of the entry to look for
     *
     * @return mixed The entry.
     *
     * @throws InstanceNotFoundException If no entry was found for this identifier
     * @throws ContainerException If there is an error while resolving the entry
     */
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
    }

    /**
     * Checks if an entry exists for the given identifier
     *
     * @param string $class The identifier of the entry to check for
     *
     * @return bool True if the container has the identifier, false otherwise
     */
    public function has(string $class): bool
    {
        return isset($this->entries[$class]);
    }

    /**
     * Registers an entry with the container
     *
     * @param string $class The identifier of the entry to register
     * @param callable|string $provider A factory function or class name that provides the entry
     * @param InstanceType $type The type of the entry to register (either singleton or scoped)
     *
     * @return Container This container
     * 
     * @throws InstanceNotFoundException If no entry was found for this identifier
     * @throws ContainerException If there is an error while resolving the class or its dependencies
     */
    public function set(string $class, callable|string $provider, InstanceType $type = InstanceType::SCOPED): Container
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

    /**
     * Resolves a class and its dependencies from the container
     *
     * @param string $class The name of the class to resolve
     *
     * @return mixed An instance of the resolved class
     *
     * @throws InstanceNotFoundException If no entry was found for this identifier
     * @throws ContainerException If there is an error while resolving the class or its dependencies
     */
    private function resolve(string $class)
    {
        try {
            $reflectionClass = new \ReflectionClass($class);
        } catch (\ReflectionException $ex) {
            throw new InstanceNotFoundException("Instance for {$class} not found");
        }

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
