<?php declare(strict_types = 1);

namespace App\Core\Interfaces;

interface ConnectionInterface
{
    public function connect(): array;
    public function close(): void;
}

?>