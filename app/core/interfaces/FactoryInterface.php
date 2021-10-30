<?php
namespace App\Core\Interfaces;

interface FactoryInterface {

    /**
     * @param array $data
     */
    public static function make(array $data);
}

?>

