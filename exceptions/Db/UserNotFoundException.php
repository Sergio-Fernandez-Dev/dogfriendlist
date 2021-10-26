<?php
namespace Exceptions\Db;

use Exception;

class UserNotFoundException extends Exception {

    public function __construct() {
        parent::__construct("El Usuario no ha sido encontrado en la base de datos");
    }
}

?>