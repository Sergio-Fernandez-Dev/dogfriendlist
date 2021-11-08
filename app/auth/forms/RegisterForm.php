<?php
namespace App\Auth\Forms;

use App\Auth\Forms\Form;
use Exceptions\Form\FormException;
use App\Core\Interfaces\EntityInterface;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;
use App\Users\Interfaces\UserManagerInterface;

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
     * @param array $data
     * @param QueryBuilderInterface $qb
     */
    public function __construct(array $data, UserManagerInterface $manager) {

        parent::__construct($manager);

        $data = $this->_getData($data);

        isset($data['nickname']) ? $this->nickname = $data['nickname'] : $this->nickname = null;
        isset($data['email']) ? $this->email = $data['email'] : $this->email = null;
        isset($data['password']) ? $this->password = \md5($data['password']) : $this->password = null;
        isset($data['password2']) ? $this->password2 = \md5($data['password2']) : $this->password2 = null;

    }

    /**
     * Envía el formulario a la base de datos y filtra la respuesta
     *
     * @param GatewayInterface $db
     * @return EntityInterface
     *
     * @throws FormException
     */
    public function send() {

        $this->_validateEmail($this->email);

        $user = $this->manager->findByEmail($this->email);

        if (null != $user->getEmail()) {
            throw new FormException('La dirección de correo ya ha sido registrada anteriormente');
        }

        $user = $this->manager->findByNickname($this->nickname);

        if (null != $user->getNickname()) {
            throw new FormException('El nombre de usuario ya existe');
        }

        $this->_checkPassword();

        return $user;
    }

    /**
     * Devuelve los campos necesarios para registrar un nuevo usuario.
     *
     * @return array
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