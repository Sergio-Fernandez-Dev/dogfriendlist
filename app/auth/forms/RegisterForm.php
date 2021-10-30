<?php
namespace App\Auth\Forms;

use App\Auth\Forms\Form;
use Exceptions\Form\FormException;
use App\Core\Interfaces\GatewayInterface;
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
    public function __construct(array $data, QueryBuilderInterface $qb, GatewayInterface $dbh) {

        parent::__construct($dbh);

        $data = $this->_getData($data);

        isset($data['nickname']) ? $this->nickname = $data['nickname'] : $this->nickname = null;
        isset($data['email']) ? $this->email = $data['email'] : $this->email = null;
        isset($data['password']) ? $this->password = \md5($data['password']) : $this->password = null;
        isset($data['password2']) ? $this->password2 = \md5($data['password2']) : $this->password2 = null;

        $this->qb = $qb;
    }

    /**
     * Envía el formulario a la base de datos y filtra la respuesta
     *
     * @param GatewayInterface $dbh
     * @return mixed
     *
     * @throws FormException
     */
    public function send() {

        $this->_validateEmail($this->email);

        $query = $this->_checkEmail();
        $result = $this->_execute($query);

        if (null != ($result)) {
            throw new FormException('La dirección de correo ya ha sido registrada anteriormente');
        }

        $query = $this->_checkNickname();
        $result = $this->_execute($query);

        if (null != ($result)) {
            throw new FormException('El nombre de usuario ya existe');
        }

        $this->_checkPassword();

        return $result;
    }

    /**
     * @return mixed
     */
    public function getFields() {
        $fields = [
            'nickname'  => $this->nickname,
            'email'     => $this->email,
            'pass_hash' => $this->password,
        ];

        return $fields;
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