<?

declare(strict_types=1);

namespace App;

use App\Attributes\Route;
use App\Enums\RequestMethod;
use App\Exceptions\RouteNotFoundException;

/**
 * Router class, responsible for handling incoming HTTP requests and routing them to their corresponding actions
 */
class Router
{
    /**
     * @var array The registered routes for each request method
     */
    private array $routes = array();

    /**
     * @var Container $container The application container
     */
    public function __construct(private Container $container)
    {
    }

    /**
     * Registers a route with the given HTTP request method and URI and associates it with the given action
     *
     * @param RequestMethod $method The HTTP request method to register the route for
     * @param string $route The URI pattern to register the route for
     * @param callable|array $action The action to associate with the route
     *
     * @return Router This router instance
     */
    public function register(RequestMethod $method, string $route, callable|array $action)
    {
        $this->routes[$method->value][$route] = $action;

        return $this;
    }

    /**
     * Registers routes for the given array of controllers by scanning their methods for the Route attribute
     *
     * @param array $controllers The array of controller classes to register routes for
     *
     * @return void
     */
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

    /**
     * Registers a GET route with the given URI and associates it with the given action
     *
     * @param string $route The URI pattern to register the route for
     * @param callable|array $action The action to associate with the route
     *
     * @return Router This router instance
     */
    public function get(string $route, callable|array $action)
    {
        return $this->register(RequestMethod::GET, $route, $action);
    }

    /**
     * Registers a POST route with the given URI and associates it with the given action
     *
     * @param string $route The URI pattern to register the route for
     * @param callable|array $action The action to associate with the route
     *
     * @return Router This router instance
     */
    public function post(string $route, callable|array $action)
    {
        return $this->register(RequestMethod::POST, $route, $action);
    }

    /**
     * Returns the registered routes for each request method
     *
     * @return array The registered routes for each request method
     */
    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * Resolves the given HTTP request by routing it to its corresponding action
     *
     * @param Request $request The HTTP request to resolve
     *
     * @return mixed The response returned by the routed action
     *
     * @throws RouteNotFoundException If the given request URI does not match any registered routes
     */
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
