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
    #[Get('/home')]
    public function index(): View
    {
        $this->emailService->send(array('Jacobs'), 'Hey Jacobs');

        return View::make('index', array(), 'layout');
    }

    #[Post('/store')]
    public function store()
    {
        return [];
    }
}
