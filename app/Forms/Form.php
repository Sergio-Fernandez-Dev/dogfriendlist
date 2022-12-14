<?php
namespace App\Forms;

use Exceptions\Form\FormException;
use App\Models\Interfaces\EntityHandlerInterface;

abstract class Form {

    /**
     * @var mixed
     */
    protected $handler;

    abstract public function send();

    /**
     * @param EntityHandlerInterface $handler
     */
    public function __construct(EntityHandlerInterface $handler) {

        $this->handler = $handler;
    }

    /**
     * Extrae los valores del array de entrada y los envía a _filter()
     *
     * @param array $data
     * @return mixed
     */
    protected function _getData(array $data) {

        $filtered_data = [];

        foreach ($data as $key => $value) {
            $filtered_data[$key] = $this->_filter($value);
        }

        return $filtered_data;
    }

    /**
     * Valida si el email introducido tiene el formato correcto.
     *
     * @param string $email
     * @throws FormException
     */
    protected function _validateEmail($email) {

        $pattern = "#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$#";

        if (!\preg_match($pattern, $email)) {
            throw new FormException("Introduce una dirección de correo válida");
        }
    }

    /**
     * Valida si el password introducido tiene el formato correcto.
     * @param string $password
     */
    protected function _validatePassword($password) {

        $pattern = '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&\#.$($)$-$_])[A-Za-z\d$@$!%*?&\#.$($)$-$_]{8,15}$';

        if (!\preg_match('#' . $pattern . '#', $password)) {
            throw new FormException("El password debe tener entre 8 y 15 caracteres y debe contener mayúsculas, minúsculas y al menos un número y un caracter especial");
        }
    }

    /**
     * Valida si el password introducido tiene el formato correcto.
     * @param string $password
     */
    protected function _validateUsername($username) {

        $pattern = '^([0-9A-Za-z_-]{3,15})$';

        if (!\preg_match('#' . $pattern . '#', $username)) {
            throw new FormException("El nombre de usuario solo puede contener números, letras y guiones, y debe tener entre 3 y 15 caracteres");
        }
    }

    /**
     * Filtra los valores introducidos en los campos del formulario
     * para evitar código malicioso.
     *
     * @param array $data
     *
     * @return array
     */
    private function _filter($data) {

        $data = (string) $data;
        $data = trim($data); // Elimina espacios antes y después de los datos
        $data = stripslashes($data); // Elimina backslashes \
        $data = htmlspecialchars($data); // Traduce caracteres especiales en entidades HTML

        return $data;
    }
}

?>