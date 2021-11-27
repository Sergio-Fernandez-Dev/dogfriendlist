<?php
namespace App\Forms;

use App\Forms\Form;
use Exceptions\Form\FormException;
use App\Core\Interfaces\EntityInterface;

class SpotForm extends Form {
    /**
     * @var string
     */
    private $title;

    /**
     * @var float
     */
    private $lat;

    /**
     * @var float
     */
    private $lng;

    /**
     * @var string
     */
    private $description;

    /**
     * @param array $data
     * @param UserHandlerInterface $handler
     */
    public function __construct(array $data, UserHandlerInterface $handler) {

        parent::__construct($handler);

        $data = $this->_getData($data);

        isset($data['title']) ? $this->title = $data['title'] : $this->title = null;
        isset($data['lat']) ? $this->lat = $data['lat'] : $this->lat = null;
        isset($data['lng']) ? $this->lng = $data['lng'] : $this->lng = null;
        isset($data['description']) ? $this->description = $data['description'] : $this->description = null;

    }

    /**
     * Envía el formulario a la base de datos y filtra la respuesta
     *
     * @return EntityInterface
     *
     * @throws FormException
     */
    public function send() {

        $this->_validateEmail($this->email);

        $user = $this->handler->findByEmail($this->email);

        if (null != $user->getEmail()) {
            throw new FormException('La dirección de correo ya ha sido registrada anteriormente.');
        }

        $user = $this->handler->findByUsername($this->username);

        if (null != $user->getUsername()) {
            throw new FormException('El nombre de usuario ya existe.');
        }

        $this->_checkPassword();
        $this->_validatePassword($this->password);

        return $user;
    }

    /**
     * Devuelve los campos necesarios para registrar un nuevo usuario.
     *
     * @return array
     */
    public function getFields() {
        $fields = [
            'username' => $this->username,
            'email'    => $this->email,
            'password' => \md5($this->password),
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