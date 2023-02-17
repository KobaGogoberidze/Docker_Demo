<?

declare(strict_types=1);

namespace App\Controllers;

use App\Services\EmailService;
use App\Services\SmsService;
use App\View;

class HomeController
{
    public function __construct(protected EmailService $emailService, protected SmsService $smsService)
    {
    }

    public function index(): View
    {
        $this->emailService->send(array('Jacobs'), 'Hey Jacobs');

        return View::make('index');
    }
}
