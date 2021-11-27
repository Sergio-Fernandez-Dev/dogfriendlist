<?php
namespace App\Models\Spots\Interfaces;

use App\Core\Interfaces\EntityHandlerInterface;

interface SpotHandlerInterface extends EntityHandlerInterface {

    /**
     * @param int $user_id
     */
    public function findByUser(int $user_id);

    /**
     * @param string $address
     */
    public function findByAddress(string $address);

    /**
     * @param string $city
     */
    public function findByCity(string $city);

    /**
     * @param string $country
     */
    public function findByCountry(string $country);

    /**
     * @param int $category_id
     */
    public function findByCategory(int $category_id);

    /**
     * @param float $long
     * @param float $lat
     */
    public function findByCloseness(float $long, float $lat);

}

?>



