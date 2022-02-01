<?php
namespace App\Models\Spots\Interfaces;

use App\Models\Interfaces\EntityHandlerInterface;

interface SpotHandlerInterface extends EntityHandlerInterface {

    /**
     * @param string $address
     */
    public function findByAddress(string $address);

    /**
     * @param int $category_id
     */
    public function findByCategory(int $category_id);

    /**
     * @param float $long
     * @param float $lat
     */
    public function findByCloseness(float $long, float $lat, float $distance);

}

?>
