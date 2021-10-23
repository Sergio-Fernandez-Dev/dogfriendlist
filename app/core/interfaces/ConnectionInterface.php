<?php declare(strict_types = 1);

namespace App\Core\Interfaces;

interface ConnectionInterface
{
    public function connect();
    public function close();
    public function execute(array $query);
}

?>