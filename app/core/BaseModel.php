<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Interfaces\iConnection;

/**
 * la clase BaseModel proporciona las funcionalidades
 * básicas a los modelos.
 */
abstract class BaseModel
{
    private $table;
    protected $dbh;
    protected $conn;
    protected $order;
    protected $order_by;
    protected $last_order_by;

    /**
     * Método constructor
     *
     * @param string $table
     */
    public function __construct(string $table, iConnection $dbh)
    {
        $this->table = $table;
        $this->$dbh = $dbh;
        $this->order = 'ASC';
    }

    private function _connect()
    {
        $this->conn = $this->dbh->connect();
    }

    private function _disconect()
    {
        $this->conn = $this->dbh->close();
    }    
    /**
     * Establece el orden en el que se mostrán los elementos
     * de la base de datos. Por defecto será 'Id' y ascendente.
     *
     * @return void
     */
    private function _orderBy() 
    {
        
        if(isset($_GET['orderBy'])) 
        {
            $order_by = $_GET['orderBy'];  

            if ($order_by == $this->last_order_by) 
            {
                if ($this->order == 'ASC') 
                {
                    $this->order = 'DESC';
                }
                else 
                {
                    $this->order = 'ASC';
                }
            }
            else
            {
                $this->last_order_by = $this->order_by;
            }
        } 
    }

    /**
     * Obtiene todos los elementos de una tabla
     *
     * @return array
     * 
     * @throws PDOException si no consigue conectarse a la BBDD
     */
    public function getAll()
    {
        try
        {
            $this->_connect();

            $query = $this->conn->prepare("SELECT * FROM :table ORDER BY ':order_by' :order");
            $query->execute(
                array(
                    ':table'=>$this->table,
                    ':order_by'=>$this->order_by,
                    ':order'=>$this->order
                )
            );

            while($row = $query->fetch_object())
            {
                $result[] = $row; 
            }

            $this->_disconect();

            return $result;
        }
        catch(PDOException $e) 
        {
            echo "Query failed: " . $e->getMessage();
        }
    }

    /**
     * Obtiene el elemento correspondiente a la 'Id' 
     * pasada como parámetro.
     *
     * @param int $id
     * 
     * @return array|null|void 
     * 
     * @throws PDOException si no consigue conectarse a la BBDD
     */
    public function getById($id)
    {
        try
        {
            $this->_connect();

            $query = $this->conn->prepare("SELECT * FROM :table WHERE Id=:id");
            $query->execute(
                array(
                    ':table'=>$this->table, 
                    ':id'=>$id
                )
            );

            if($row = $query->fetch_object())
            {
                $this->_disconect();

                return $row;
            }
        }
        catch(PDOException $e) 
        {
            echo "Query failed: " . $e->getMessage();
        }
    }

    /**
     * Obtiene los elementos correspondientes a la 
     * propiedad y valor pasados por parámetro.
     *
     * @param string $property
     * @param mixed $value
     * 
     * @return array|null|void 
     * 
     * @throws PDOException si no consigue conectarse a la BBDD.
     */
    public function getBy($property, $value)
    {
        try
        {
            $this->_connect();

            $query=$this->conn->prepare("SELECT * FROM :table WHERE :property = ':value'");
            $query->execute(
                array(
                    ':table'=>$this->table, 
                    ':property'=>$property, 
                    ':value'=>$value
                )
            );      
            
            if($row = $query->fetch_object())
            {
                $this->_disconect();

                return $row;
            }
        }
        catch(PDOException $e)
        {
            echo "Query failed: " . $e->getMessage();
        }
    }

    /**
     * Borra el elemento correspondiente a la 'Id'
     * pasada como parámetro.
     * 
     * @param int $id
     * 
     * @return array|null|void 
     * 
     * @throws PDOException si no consigue conectarse a la BBDD.
     */
    public function deleteById($id)
    {
        try
        {
            $this->_connect();

            $query = $this->conn->prepare("DELETE * FROM :table WHERE Id=:id");
            $query->execute(array(':table'=>$this->table, ':id'=>$id));

            $this->_disconect();
        }
        catch(PDOException $e) 
        {
            echo "Query failed: " . $e->getMessage();
        }
    }

    /**
     * Borra los elementos correspondientes a la 
     * propiedad y valor pasados por parámetro.
     * 
     * @param string $property
     * @param mixed $value
     * 
     * @return void
     * 
     * @throws PDOException si no consigue conectarse a la BBDD.
     */
    public function deleteBy($property, $value)
    {
        try
        {
            $this->_connect();

            $query=$this->conn->prepare("DELETE * FROM :table WHERE :property = ':value'");
            $query->execute(array(':table'=>$this->table, ':property'=>$property, ':value'=>$value));       

            $this->_disconect();
        }
        catch(PDOException $e)
        {
            echo "Query failed: " . $e->getMessage();
        }
    }

    protected abstract function getClassParams();
    protected abstract function setClassParams();
}

?>