<?php 

abstract class Form
{


    private function _filter($data){
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
                $filtered_data[$key] = $this->_filter($data[$key]);
            }
        }

        return $filtered_data;
    }

    abstract protected function _prepare();
}

?>