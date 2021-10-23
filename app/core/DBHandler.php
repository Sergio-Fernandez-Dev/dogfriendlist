<?php

namespace App\Core;

require_once '../app/core/interfaces/ConnectionInterface.php';

use App\Core\Interfaces\ConnectionInterface;
use PDO;
use PDOException;

/**
 * La clase DBHandler se encarga de establecer las conexiones a la base de datos
 * y de ejecutar las consultas.
 */

class DBHandler implements ConnectionInterface
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
    public function __construct()
    {
        $db_config = require \DB_CONFIG;

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
            die("No se ha podido conectar ala base de datos:" . $e->getMessage());
        }     
    }

    /**
     * Cierra la conexión con la base de datos
     *
     * @return null
     */
    public function close()
    {
        $this->conn;
        return null;
    }

    /**
     * Ejecuta las consultas a la base de datos
     *
     * @param array $query
     * 
     * @return array|object 
     */
    public function execute(array $query)
    {
        if(!isset($this->conn)) {$this->connect();}

        try
        {
            $stmt = $this->conn->prepare($query['query']);
            $stmt->execute($query['values']); 
        }
        catch (PDOException $e) 
        {
            die("No se ha podido ejecutar la consulta:" . $e->getMessage());
        }     

        if($stmt->rowCount() > 1)
        {
            while($row = $stmt->fetch_object()) 
            {
                $result[] = $row;
            }
        }
        elseif($stmt->rowCount() == 1)
        {
            if($row = $stmt->fetch_object()) 
            {
                $result = $row;
            }
        }

        return $result;
    }
}

?>