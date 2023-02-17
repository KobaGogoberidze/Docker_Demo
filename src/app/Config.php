<?

declare(strict_types=1);

namespace App;

class Config
{
    protected array $config = array();

    public function __construct(array $env)
    {
        $this->config = array(
            'db' => array(
                'host' => $env['DB_HOST'],
                'user' => $env['DB_USER'],
                'pass' => $env['DB_PASS'],
                'database' => $env['DB_DATABASE'],
                'driver' => $env['DB_DRIVER']
            )
        );
    }

    public function __get($name)
    {
        return $this->config[$name] ?? null;
    }
}
