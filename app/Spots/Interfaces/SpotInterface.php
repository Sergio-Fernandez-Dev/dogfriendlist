<?php
namespace App\Spots\Interfaces;

use App\Core\Interfaces\EntityInterface;

interface SpotInterface extends EntityInterface {

    public function getTitle();

    public function getDescription();

    public function getAddress();

    public function getCreatedAt();

    /**
     * @param string $title
     */
    public function setTitle(string $title);

    /**
     * @param string $description
     */
    public function setDescription(string $description);

    /**
     * @param string $address
     */
    public function setAddress(string $address);

}

?>
