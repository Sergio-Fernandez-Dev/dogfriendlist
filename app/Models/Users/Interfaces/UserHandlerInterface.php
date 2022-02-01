<?php
namespace App\Models\Users\Interfaces;

use App\Models\Interfaces\EntityHandlerInterface;

Interface UserHandlerInterface extends EntityHandlerInterface {
    /**
     * @param int $id
     */
    public function findByEmail(string $email);

    /**
     * @param string $username
     */
    public function findByUsername(string $username);

}

?>
