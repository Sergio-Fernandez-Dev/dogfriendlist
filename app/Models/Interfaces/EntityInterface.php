<?php
namespace App\Models\Interfaces;

interface EntityInterface {
    /**
     * @param bool $only_valuated
     */
    public function getProperties(bool $only_valuated = true);

    /**
     * @param array $data
     * @param bool $override
     */
    public function setProperties(array $data, bool $override = true);

    public function getId();

    /**
     * @param int $id
     */
    public function setId(int $id);
}

?>
