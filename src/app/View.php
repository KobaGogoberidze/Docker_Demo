<?

declare(strict_types=1);

namespace App;

use App\Exceptions\LayoutNotFoundException;
use App\Exceptions\ViewNotFoundException;

class View
{
    /**
     * @var string $view File name of the view
     * @var array $params Parameters, that will be accesible in view file
     */

    public function __construct(
        protected string $view = 'index',
        protected array $params = array(),
        protected string $layout = ''
    ) {
    }

    /**
     * Generates view from file with layout
     * 
     * @param string|null $layout File name of the layout or null if no layout is used
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
        include $viewPath;
        $viewOutput = ob_get_clean();

        if ($this->layout) {
            $layoutPath = LAYOUT_PATH . '/' . $this->layout . '.php';
            if (!file_exists($layoutPath)) {
                throw new LayoutNotFoundException();
            }

            ob_start();
            include $layoutPath;
            $layoutOutput = ob_get_clean();

            return str_replace('{{ content }}', $viewOutput, $layoutOutput);
        }

        return $viewOutput;
    }

    /**
     * Instantiates view object
     * 
     * @param string $view File name of the view
     * @param array $params Parameters, that will be accesible in view file
     * 
     * @return View
     */
    public static function make(string $view, array $params = array(), string $layout = ''): View
    {
        return new static($view, $params, $layout);
    }

    /**
     * Returns a string representation of view object
     * 
     * @return string
     */
    public function __toString(): string
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
    public function __get(string $name): string|null
    {
        return $this->params[$name] ?? null;
    }
}
