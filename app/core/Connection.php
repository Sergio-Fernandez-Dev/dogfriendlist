<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * La clase Connection se encarga de establecer las conexiones a la base de datos
 * en base a la configuración pasada como parámetro de su método constructor.
 */

class Connection 
{
    private $conn;
    private $driver;
    private $host;
    private $user;
    private $pass;
    private $name;
    private $charset;

    /**
     * Se construye un objeto Conexión con los parámetros
     * obtenidos a través del array de configuración.
     * 
     * @param array $db_config Idealmente contendrá los parámetros de las variables de entorno.
     */
    public function __construct(array $db_config)
    {

        $this->driver = $db_config['driver'];
        $this->host = $db_config['host'];
        $this->user = $db_config['user'];
        $this->pass = $db_config['pass'];
        $this->name = $db_config['name'];
        $this->charset = $db_config['charset'];
    }


    /**
     * Establece la conexión a la base de datos.
     *
     * @return array|null|void 
     */
    public function connect()
    {
        try
        {
            $this->conn = new PDO("$this->driver:host=$this->host;dbname=$this->name", $this->user, $this->pass);
            $this->conn->exec('SET NAMES '.$this->charset);
            return $this->conn;
        }
        catch (PDOException $e) 
        {
            die("Could not connect to the database:" . $e->getMessage());
        }     
    }

    /**
     * Cierra la conexión con la base de datos
     *
     * @return null
     */
    public function close()
    {
        return $this->conn = null;
    }
}

?>