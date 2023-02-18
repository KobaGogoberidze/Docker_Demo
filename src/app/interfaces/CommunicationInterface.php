<?

declare(strict_types=1);

namespace App\Interfaces;

interface CommunicationInterface
{
    public function send(array $to, string $template): bool;
}
