<?

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Attributes\Get;
use App\Models\Customer;

class CustomerController
{
    public function __construct()
    {
    }

    #[Get('/customers')]
    public function index(): View
    {
        $customer = new Customer();

        return View::make('customer/index', array(
            'customers' => $customer->all()
        ), 'layout');
    }
}
