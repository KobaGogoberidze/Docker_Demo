<?

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Attributes\Get;
use App\Attributes\Post;
use App\Interfaces\CommunicationInterface;

class HomeController
{
    public function __construct(protected CommunicationInterface $emailService)
    {
    }

    #[Get('/')]
    public function index(): View
    {
        $this->emailService->send(array('Jacobs'), 'Hey Jacobs');

        return View::make('index');
    }

    #[Post('/store')]
    public function store()
    {
        return [];
    }
}
