<?php declare(strict_types = 1);

namespace App\Core\Interfaces;

interface ConnectionInterface
{
    public function connect(): object;
    public function close(): null;
}

?>