<?php
require_once '../vendor/autoload.php';

use App\Core\DB;
use App\Core\QueryBuilder;
use App\Core\Router as route;
use App\Models\Spots\SpotHandler;

route::add('/charge-spots', 'POST',
    function () {

        if (isset($_POST['coords'])) {
            $db = new DB();
            $qb = new QueryBuilder();
            $handler = new SpotHandler($db, $qb);

            $coords = $_POST['coords'];
            $lat = $coords['lat'];
            $lng = $coords['lng'];

            if (isset($_POST['category']) && $_POST['category'] > 1) {
                $spot_list = $handler->findByCategory($_POST['category']);

            } else {
                $spot_list = $handler->findAll();
            }

            foreach ($spot_list as $spot) {
                $result[] = $spot->getProperties(false);
            }

            echo json_encode($result);
        }
    }
);

route::methodNotAllowed(
    function () {

        echo 'no existe el metodo';
    }
);

route::pathNotFound(
    function () {

        echo 'path no encontrado';
    }
);

route::run('/geolocation');