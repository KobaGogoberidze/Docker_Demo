<?

declare(strict_types=1);

namespace App\Models;

use App\Model;

class Invoice extends Model
{
    public function all(): array
    {
        $builder = $this->DB->createQueryBuilder();
        $builder
            ->select('*, customer_id as customer')
            ->from('invoices');

        $smt = $builder->executeQuery();

        return $smt->fetchAllAssociative();
    }
}
