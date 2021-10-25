<?php
namespace App\Auth\Forms;

use App\Auth\Forms\Form;
use App\Core\Interfaces\ConnectionInterface;
use App\Core\Interfaces\QueryBuilderInterface;
use Exceptions\Form\NotAvailableEmailException;
use Exceptions\Form\NotAvailableNicknameException;

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

    private function _checkNickname()
    {
        $query = $this->qb->select(['*'])
                        ->from('Users')
                        ->where('Nickname','=',$this->nickname)
                        ->get();
                        
        return $query;
    }
    
    private function _checkEmail()
    {
        $query = $this->qb->select(['*'])
                        ->from('Users')
                        ->where('EMAIL','=',$this->email)
                        ->get();
                        
        return $query;
    }


    public function send(ConnectionInterface $dbh)
    {
        $query = $this->_checkEmail();
        $result = $dbh->execute($query);
        $dbh->close();

        if(null != ($result)) 
        {
            throw new NotAvailableEmailException('La dirección de correo ya ha sido registrada anteriormente');
        }

        $query = $this->_checkNickname();
        $dbh->connect();
        $result = $dbh->execute($query);
        
        if(null != ($result)) 
        {
            throw new NotAvailableNicknameException('El nombre de usuario ya existe');
        }

        return $result;
    }


}

?>