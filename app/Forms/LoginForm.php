<?php
namespace App\Forms;

use Exceptions\Form\FormException;
use App\Models\Users\Interfaces\UserHandlerInterface;

class LoginForm extends Form {

    /**
     * @var string
     */
    private $identification;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $remember_me;

    /**
     * @param array $data
     * @param UserHandlerInterface $handler
     */
    public function __construct(array $data, UserHandlerInterface $handler) {

        parent::__construct($handler);

        $data = $this->_getData($data);

        isset($data['identification']) ? $this->identification = $data['identification'] : $this->identification = null;
        isset($data['password']) ? $this->password = \md5($data['password']) : $this->password = null;
        isset($data['remember_me']) ? $this->remember_me = (bool) $data['remember_me'] : $this->remember_me = false;

    }

    /**
     * Envía el formulario a la base de datos y filtra la respuesta
     *
     * @return EntityInterface
     *
     * @throws FormException
     */
    public function send() {

        if (null == $this->identification || null == $this->password) {
            throw new FormException('Debes rellenar todos los campos.');
        }

        $q_builder = $this->handler->getQueryBuilder();

        $query = $q_builder->select()
            ->where('email', '=', $this->identification)
            ->orWhere('username', '=', $this->identification)
            ->get();

        $user_list = $this->handler->raw($query, 'retrieve');
        $user = $user_list[0];

        if (null == $user->getEmail() && null == $user->getUsername()) {
            throw new FormException('La dirección de correo o el usuario no existe.');
        }

        if ($user->getPassword() != $this->password) {
            throw new FormException('La contraseña no es correcta');
        }

        if (0 == $user->getRole()) {
            throw new FormException('Tu cuenta no está activada, comprueba tu correo');
        }

        return $user;
    }

    /**
     * @return bool
     */
    public function getRememberMe() {

        return $this->remember_me;
    }

}

?>