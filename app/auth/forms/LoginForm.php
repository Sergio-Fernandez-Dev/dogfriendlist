<?php
namespace App\Auth\Forms;

use Exceptions\Form\FormException;
use App\Users\Interfaces\UserManagerInterface;

class LoginForm extends Form {

    /**
     * @var mixed
     */
    private $identification;

    /**
     * @var mixed
     */
    private $password;

    /**
     * @param array $data
     * @param UserManagerInterface $manager
     */
    public function __construct(array $data, UserManagerInterface $manager) {

        parent::__construct($manager);

        $data = $this->_getData($data);

        isset($data['identification']) ? $this->identification = $data['identification'] : $this->identification = null;
        isset($data['password']) ? $this->password = md5($data['password']) : $this->password = null;

    }

    /**
     * @return mixed
     */
    public function send() {

        $q_builder = $this->manager->getQueryBuilder();

        $query = $q_builder->select()
            ->where('email', '=', $this->identification)
            ->orWhere('nickname', '=', $this->identification)
            ->get();

        $user = $this->manager->raw($query, 'retrieve');

        if (null == $user->getEmail() && null == $user->getNickname()) {
            throw new FormException('La dirección de correo o el usuario no existe.');
        }

        if ($user->getPassword() != $this->password) {
            throw new FormException('El password no es correcto.');
        }

        if (0 == $user->getRole()) {
            throw new FormException('Tu cuenta no está activada, comprueba tu correo');
        }

        return $user;
    }

}

?>