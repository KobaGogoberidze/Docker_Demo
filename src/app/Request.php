<?

namespace App;

use App\Enums\RequestMethod;

class Request
{
    private string $uri;
    private RequestMethod $method;

    public function __construct(array $server)
    {
        $this->uri = $server['REQUEST_URI'];
        $this->method = RequestMethod::from($server['REQUEST_METHOD']);
    }

    public function isGet()
    {
        return $this->getMethod() == RequestMethod::GET;
    }

    public function isPost()
    {
        return $this->getMethod() == RequestMethod::POST;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }
}
