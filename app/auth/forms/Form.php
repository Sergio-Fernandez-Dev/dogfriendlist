<?php 

namespace App\Auth\Forms;

use App\Core\Interfaces\ConnectionInterface;

abstract class Form
{
    /**
     * Filtra los valores introducidos en los campos del formulario
     *para evitar código malicioso.
     * @param array $data
     * 
     * @return array
     */
    private function _filter($data){
        $data = (string) $data;
        $data = trim($data); // Elimina espacios antes y después de los data
        $data = stripslashes($data); // Elimina backslashes \
        $data = htmlspecialchars($data); // Traduce caracteres especiales en entidades HTML
        return $data;
    }

    protected function _getData(array $data)
    {
        $filtered_data = [];

        if(isset($data["submit"])) 
        {
            foreach($data as $key => $value)
            {
                $filtered_data[$key] = $this->_filter($value);
            }
        }

        return $filtered_data;
    }

    abstract public function send(ConnectionInterface $dbh);
}

?>