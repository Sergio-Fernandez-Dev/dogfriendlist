<?php 

namespace App\Interfaces;

interface EntityInterface
{
    public function getId();
    public function setId($id);
    public function getClassParams();
    public function setClassParams(array $data, bool $override);
}

?>