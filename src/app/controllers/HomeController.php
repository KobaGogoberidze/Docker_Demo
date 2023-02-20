<?

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Attributes\Get;
use App\Interfaces\CommunicationInterface;
use App\Models\Invoice;

class HomeController
{
    public function __construct(protected CommunicationInterface $emailService)
    {
    }

    #[Get('/')]
    #[Get('/invoices')]
    public function index(): View
    {
        $invoice = new Invoice();

        return View::make('invoice/index', array(
            'invoices' => $invoice->all()
        ), 'layout');
    }
}
