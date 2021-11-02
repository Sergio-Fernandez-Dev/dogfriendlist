<?php
namespace App\Core;

use PDO;
use PDOException;
use UnderflowException;
use App\Core\Interfaces\GatewayInterface;

/**
 * La clase DB se encarga de establecer las conexiones a la base de datos
 * y de ejecutar las consultas.
 */

class DB implements GatewayInterface {
    /**
     * @var string
     */
    private $driver;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var string
     */
    private $charset;

    /**
     * @var PDO
     */
    private $conn;

    /**
     * Se construye un objeto Conexión con los parámetros
     * obtenidos a través del array de configuración.
     *
     * @param array $db_config Idealmente contendrá los parámetros de las variables de entorno.
     */
    public function __construct() {
        $db_config = require_once \DB_CONFIG;

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
    public function connect() {
        try
        {
            $this->conn = new PDO("$this->driver:host=$this->host;dbname=$this->name", $this->user, $this->pass);
            $this->conn->exec('SET NAMES ' . $this->charset);

            return $this->conn;
        } catch (PDOException $e) {
            die("No se ha podido conectar a la base de datos:" . $e->getMessage());
        }

    }

    /**
     * Cierra la conexión con la base de datos
     *
     * @return null
     */
    public function disconnect() {

        $this->conn = null;

        return null;
    }

    /**
     * Almacena un objeto en nuestra base de datos.
     * @param array $query
     */
    public function persist(array $query) {

        $this->_execute($query);

        return true;
    }

    /**
     * Devuelve un array correspondiente a todas las filas encontradas en la db
     * para la consulta realizada.
     *
     * @param mixed $query
     * @return mixed
     */
    public function retrieve($query) {

        $stmt = $this->_execute($query);

        if ($stmt->rowCount() > 1) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }

        } elseif ($stmt->rowCount() == 1) {

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result = $row;
            }

        } else {
            throw new UnderflowException('La tabla a la que se intenta acceder está vacía.');
        }

        return $result;

    }

    /**
     * Ejecuta las consultas a la base de datos
     *
     * @param mixed $query
     *
     * @return mixed
     */
    private function _execute($query) {

        if (!isset($this->conn)) {$this->connect();}

        try
        {
            $stmt = $this->conn->prepare($query['query']);
            $stmt->execute($query['values']);

            return $stmt;

        } catch (PDOException $e) {
            die("No se ha podido ejecutar la consulta:" . $e->getMessage());
        }

    }

}

?>