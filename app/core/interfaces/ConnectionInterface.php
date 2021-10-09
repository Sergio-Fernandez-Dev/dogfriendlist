<?php 

namespace App\Interfaces;

interface ConnectionInterface
{
    public function connect();
    public function close();
}

?>