<?php

namespace App;

use App\Enums\RequestMethod;

/**
 * Represents an HTTP request
 */
class Request
{
    /**
     * @var string The requested URI
     */
    private string $uri;

    /**
     * @var RequestMethod The HTTP request method
     */
    private RequestMethod $method;

    /**
     * Creates a new Request object
     *
     * @param array $server An array of server variables
     * @throws \InvalidArgumentException if the URI or request method is invalid
     */
    public function __construct(array $server)
    {
        $this->uri = $server['REQUEST_URI'];
        $this->method = RequestMethod::tryFrom($server['REQUEST_METHOD']);

        if (!$this->uri || !$this->method) {
            throw new \InvalidArgumentException('Invalid server variables for request');
        }
    }

    /**
     * Checks if the request method is GET
     *
     * @return bool True if the request method is GET, false otherwise
     */
    public function isGet(): bool
    {
        return $this->getMethod() === RequestMethod::GET;
    }

    /**
     * Checks if the request method is POST
     *
     * @return bool True if the request method is POST, false otherwise
     */
    public function isPost(): bool
    {
        return $this->getMethod() === RequestMethod::POST;
    }

    /**
     * Returns the HTTP request method
     *
     * @return RequestMethod The request method
     */
    public function getMethod(): RequestMethod
    {
        return $this->method;
    }

    /**
     * Returns the requested URI
     *
     * @return string The requested URI
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
