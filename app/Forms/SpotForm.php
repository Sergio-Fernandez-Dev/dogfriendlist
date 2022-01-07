<?php
namespace App\Forms;

use App\Forms\Form;
use Exceptions\Form\FormException;
use App\Models\Interfaces\EntityInterface;
use App\Models\Spots\Interfaces\SpotHandlerInterface;

class SpotForm extends Form {
    /**
     * @var int
     */
    private $user_id;

    /**
     * @var int
     */
    private $category_id;

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
    private $address;

    /**
     * @var string
     */
    private $description;

    /**
     * @param array $data
     * @param SpotHandlerInterface $handler
     */
    public function __construct(array $data, SpotHandlerInterface $handler) {

        parent::__construct($handler);

        $data = $this->_getData($data);

        isset($data['user_id']) ? $this->user_id = $data['user_id'] : $this->user_id = null;
        isset($data['category']) ? $this->category_id = (int) $data['category'] : $this->category_id = null;
        isset($data['title']) ? $this->title = $data['title'] : $this->title = null;
        isset($data['lat']) ? $this->lat = (float) $data['lat'] : $this->lat = null;
        isset($data['lng']) ? $this->lng = (float) $data['lng'] : $this->lng = null;
        isset($data['address']) ? $this->address = $data['address'] : $this->address = null;
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

        $spot_list = $this->handler->findByAddress($this->address);

        if (!empty($spot_list)) {
            throw new FormException('Ya existe un spot en la misma dirección');
        }

        return $spot_list;
    }

    /**
     * Devuelve los campos necesarios para registrar un nuevo spot.
     *
     * @return array
     */
    public function getFields() {

        $fields = [
            'user_id'     => $this->user_id,
            'category_id' => $this->category_id,
            'title'       => $this->title,
            'lat'         => $this->lat,
            'lng'         => $this->lng,
            'address'     => $this->address,
            'description' => $this->description,
        ];

        return $fields;
    }
}

?>