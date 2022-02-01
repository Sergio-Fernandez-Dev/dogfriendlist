<?php
namespace App\Core\Interfaces;

interface GatewayInterface {

    public function connect();

    public function disconnect();

    /**
     * @param mixed $data
     */
    public function persist($data);

    /**
     * @param mixed $data
     */
    public function retrieve($data);
}

?>
