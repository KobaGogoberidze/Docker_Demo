<?

declare(strict_types=1);

namespace App;

use PDO;

/**
 * Class for creating and managing a PDO connection to a database
 */
class DB
{
    /**
     * The PDO connection.
     *
     * @var PDO
     */
    private PDO $pdo;

    /**
     * DB constructor
     *
     * @param array $config Configuration options for the database connection
     *                      - driver: The database driver (e.g. "mysql")
     *                      - host: The database host
     *                      - database: The database name
     *                      - user: The database username
     *                      - pass: The database password
     *                      - options (optional): Additional PDO options for the database connection
     *
     * @throws \PDOException if there is an error connecting to the database
     */
    public function __construct(array $config)
    {
        $defaultOptions = array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        try {
            $this->pdo = new PDO(
                "{$config['driver']}:host={$config['host']};dbname={$config['database']}",
                $config['user'],
                $config['pass'],
                array_merge($defaultOptions, $config['options'] ?? array())
            );
        } catch (\PDOException $ex) {
            throw new \PDOException($ex->getMessage(), (int)$ex->getCode());
        }
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
        return call_user_func_array(array($this->pdo, $name), $arguments);
    }

    /**
     * Get default additional options for the PDO instance
     *
     * @return array
     */
    public static function getDefaultOptions()
    {
        return array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        );
    }
}
