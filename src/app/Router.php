<?

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes;

    private function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, callable|array $action)
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action)
    {
        return $this->register('post', $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUrl, string $requestMethod)
    {
        $route = explode('?', $requestUrl)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $instance = new $class();

                if (method_exists($instance, $method)) {
                    return call_user_func(array($instance, $method), array());
                }
            }
        }

        throw new RouteNotFoundException();
    }
}
