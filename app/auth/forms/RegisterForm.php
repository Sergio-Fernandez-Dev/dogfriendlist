<?php

use App\Core\Interfaces\ConnectionInterface;
use App\Core\Interfaces\QueryBuilderInterface;

class RegisterForm extends Form
{
    private $nickname;
    private $email;
    private $password;

    private $qb;

    public function __construct(array $data, QueryBuilderInterface $qb)
    {
        $data = $this->_getData($data);
        isset($data['nickname']) ? $this->nickname = $data['nickname'] : $this->nickname = null;
        isset($data['email']) ? $this->email = $data['email'] : $this->email = null;
        isset($data['password']) ? $this->password = $data['password'] : $this->password = null;

        $this->qb = $qb;
    }

    protected function _prepare()
    {
        $query = $this->qb->select(['nickname', 'email'])
                        ->from('Users')
                        ->where('Nickname','=',$this->nickname)
                        ->andWhere('Email','=',$this->email)
                        ->get();
        
        return $query;
    }

    public function send(ConnectionInterface $conn)
    {
        //TODO ejecutar la consulta a traves del objeto de conexion
        return $this->_prepare();
    }


}

?>