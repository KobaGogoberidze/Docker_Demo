<?

declare(strict_types=1);

namespace App\Models;

use App\Model;

class Customer extends Model
{
    public function all(): array
    {
        $builder = $this->DB->createQueryBuilder();
        $builder
            ->select('*')
            ->from('customers');

        $smt = $builder->executeQuery();

        return $smt->fetchAllAssociative();
    }
}
