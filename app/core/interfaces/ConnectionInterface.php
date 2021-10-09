<?php 

namespace App\Core\Interfaces;

interface ConnectionInterface
{
    public function connect();
    public function close();
}

?>