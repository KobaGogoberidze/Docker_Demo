<?

declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{
    /**
     * @var string $view File name of the view
     * @var array $params Parameters, that will be accesible in view file
     */

    public function __construct(
        protected string $view = 'index',
        protected array $params = array()
    ) {
    }

    /**
     * Generates view from file
     * 
     * @return string
     */
    public function render(): string
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';

        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        foreach ($this->params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include VIEW_PATH . '/' . $this->view . '.php';

        return (string) ob_get_clean();
    }

    /**
     * Instantiates view object
     * 
     * @param string $view File name of the view
     * @param array $params Parameters, that will be accesible in view file
     * 
     * @return View
     */
    public static function make(string $view, array $params = array()): View
    {
        return new static($view, $params);
    }
    
    /**
     * Returns a string representation of view object
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Get parameters
     * 
     * @param string $name
     * 
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->params[$name] ?? null;
    }
}
