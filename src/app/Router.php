<?

declare(strict_types=1);

namespace App;

use App\Attributes\Route;
use App\Enums\RequestMethod;
use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = array();

    public function __construct(private Container $container)
    {
    }

    public function register(RequestMethod $method, string $route, callable|array $action)
    {
        $this->routes[$method->value][$route] = $action;

        return $this;
    }

    public function registerControllerRoutes(array $controllers)
    {
        foreach ($controllers as $controller) {
            $reflectionController = new \ReflectionClass($controller);

            foreach ($reflectionController->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $this->register($route->method, $route->route, array($controller, $method->getName()));
                }
            }
        }
    }

    public function get(string $route, callable|array $action)
    {
        return $this->register(RequestMethod::GET, $route, $action);
    }

    public function post(string $route, callable|array $action)
    {
        return $this->register(RequestMethod::POST, $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve(Request $request)
    {
        $route = explode('?', $request->getUri())[0];
        $action = $this->routes[$request->getMethod()->value][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $method] = $action;
            if (class_exists($class)) {
                $instance = $this->container->get($class);

                if (method_exists($instance, $method)) {
                    return call_user_func(array($instance, $method), array());
                }
            }
        }

        throw new RouteNotFoundException();
    }
}
