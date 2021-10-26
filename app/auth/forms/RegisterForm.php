<?php
namespace App\Auth\Forms;

use App\Auth\Forms\Form;
use Exceptions\Form\FormException;
use App\Core\Interfaces\ConnectionInterface;
use App\Core\Interfaces\QueryBuilderInterface;

class RegisterForm extends Form {
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $password2;

    /**
     * @var QueryBuilderInterface
     */
    private $qb;

    /**
     * @param array $data
     * @param QueryBuilderInterface $qb
     */
    public function __construct(array $data, QueryBuilderInterface $qb) {

        $data = $this->_getData($data);

        isset($data['nickname']) ? $this->nickname = $data['nickname'] : $this->nickname = null;
        isset($data['email']) ? $this->email = $data['email'] : $this->email = null;
        isset($data['password']) ? $this->password = $data['password'] : $this->password = null;
        isset($data['password2']) ? $this->password2 = $data['password2'] : $this->password2 = null;

        $this->qb = $qb;
    }

    /**
     * Envía el formulario a la base de datos y filtra la respuesta
     *
     * @param ConnectionInterface $dbh
     * @return mixed
     *
     * @throws FormException
     */
    public function send(ConnectionInterface $dbh) {
        $this->_validateEmail($this->email);

        $query = $this->_checkEmail();
        $result = $dbh->execute($query);
        $dbh->close();

        if (null != ($result)) {
            throw new FormException('La dirección de correo ya ha sido registrada anteriormente');
        }

        $query = $this->_checkNickname();
        $dbh->connect();
        $result = $dbh->execute($query);

        if (null != ($result)) {
            throw new FormException('El nombre de usuario ya existe');
        }

        $this->_checkPassword();

        return $result;
    }

    /**
     * Comprueba si el email ya ha sido registrado
     *
     * @return mixed
     */
    private function _checkEmail() {
        $query = $this->qb->select(['*'])
            ->from('Users')
            ->where('EMAIL', '=', $this->email)
            ->get();

        return $query;
    }

    /**
     * Comprueba si el nombre de usuario ya ha sido registrado
     *
     * @return mixed
     */
    private function _checkNickname() {
        $query = $this->qb->select(['*'])
            ->from('Users')
            ->where('Nickname', '=', $this->nickname)
            ->get();

        return $query;
    }

    /**
     * Comprueba que las contraseñas no estén vacías y que conincidan
     *
     * @return void
     */
    private function _checkPassword() {

        if (!isset($this->password) || !isset($this->password2) || $this->password != $this->password2) {
            throw new FormException('Las contraseñas no coinciden');
        }

    }

}

?>