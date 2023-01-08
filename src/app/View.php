<?

declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(
        protected string $view = 'index',
        protected array $params = []
    ) {
    }

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

    public static function make(string $view, array $params = []): View
    {
        return new static($view, $params);
    }

    public function __toString()
    {
        return $this->render();
    }

    public function __get($name)
    {
        return $this->params[$name] ?? null;
    }
}
