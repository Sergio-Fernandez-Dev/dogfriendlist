<?php
    namespace App\Auth\Forms;

    use Exceptions\Form\FormException;
use App\Core\Interfaces\ConnectionInterface;

    abstract class Form {

        /**
         * @param ConnectionInterface $dbh
         */
        abstract public function send(ConnectionInterface $dbh);

        /**
         * Extrae los valores del array de entrada y los envía a _filter()
         *
         * @param array $data
         * @return mixed
         */
        protected function _getData(array $data) {
            $filtered_data = [];

            if (isset($data["submit"])) {

                foreach ($data as $key => $value) {
                    $filtered_data[$key] = $this->_filter($value);
                }

            }

            return $filtered_data;
        }

        /**
         * Valida si el email introducido tiene el formato correcto
         *
         * @param $email
         * @throws FormException
         */
        protected function _validateEmail($email) {

            if (!filter_var($email, \FILTER_VALIDATE_EMAIL)) {
                throw new FormException("Introduce una dirección de correo válida");
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
            $data = trim($data); // Elimina espacios antes y después de los data
            $data = stripslashes($data); // Elimina backslashes \
            $data = htmlspecialchars($data); // Traduce caracteres especiales en entidades HTML

            return $data;
        }

    }

?>


