<?php
namespace App\Auth\Forms;

use Exceptions\Form\FormException;
use App\Users\Interfaces\UserManagerInterface;

class LoginForm extends Form {

    /**
     * @var string
     */
    private $identification;

    /**
     * @var mixed
     */
    private $password;

    /**
     * @var mixed
     */
    private $remember_me;

    /**
     * @param array $data
     * @param UserManagerInterface $manager
     */
    public function __construct(array $data, UserManagerInterface $manager) {

        parent::__construct($manager);

        $data = $this->_getData($data);

        isset($data['identification']) ? $this->identification = $data['identification'] : $this->identification = null;
        isset($data['password']) ? $this->password = \md5($data['password']) : $this->password = null;
        isset($data['remember_me']) ? $this->remember_me = (bool) $data['remember_me'] : $this->remember_me = false;

    }

    /**
     * @return mixed
     */
    public function send() {

        if (null == $this->identification || null == $this->password) {
            throw new FormException('Debes rellenar todos los campos.');
        }

        $q_builder = $this->manager->getQueryBuilder();

        $query = $q_builder->select()
            ->where('email', '=', $this->identification)
            ->orWhere('username', '=', $this->identification)
            ->get();

        $user = $this->manager->raw($query, 'retrieve');

        if (null == $user->getEmail() && null == $user->getUsername()) {
            throw new FormException('La dirección de correo o el usuario no existe.');
        }

        if ($user->getPassword() != $this->password) {
            $pass = $user->getPassword();
            $nick = $user->getUsername();
            throw new FormException('La contraseña no es correcta');
        }

        if (0 == $user->getRole()) {
            throw new FormException('Tu cuenta no está activada, comprueba tu correo');
        }

        return $user;
    }

    /**
     * @return mixed
     */
    public function getRememberMe() {

        return $this->remember_me;
    }

}

?>