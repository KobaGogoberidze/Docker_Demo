<?

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * Class for creating and managing a PDO connection to a database
 */
class DB
{
    /**
     * The PDO connection.
     *
     * @var Connection
     */
    private Connection $connection;

    /**
     * DB constructor
     *
     * @param array $config Configuration options for the database connection
     *                      - dbname: The database name
     *                      - user: The database username
     *                      - pass: The database password
     *                      - host: The database host
     *                      - driver: The database driver (e.g. "pdo_mysql")
     */
    public function __construct(array $config)
    {
        $this->connection = DriverManager::getConnection($config);
    }

    /**
     * Magic method to call PDO methods on the DB object
     *
     * @param string $name The name of the PDO method to call
     * @param array $arguments The arguments to pass to the PDO method
     * @return mixed The result of the PDO method call
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array(array($this->connection, $name), $arguments);
    }
}
