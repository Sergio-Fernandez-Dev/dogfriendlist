<?php 

namespace App\Interfaces;

interface iConnection
{
    public function connect();
    public function close();
}

?>