<?php
require_once '../vendor/autoload.php';

use App\Core\DB;
use App\Core\QueryBuilder;
use App\Core\Router as route;
use App\Models\Spots\SpotHandler;

route::add('/charge-near-spots', 'POST',
    function () {

        if (isset($_POST['coords'])) {
            $db = new DB();
            $qb = new QueryBuilder();
            $handler = new SpotHandler($db, $qb);

            $coords = $_POST['coords'];
            $lat = $coords['lat'];
            $lng = $coords['lng'];

            $spot_list = $handler->findByCloseness($lat, $lng, 10);

            foreach ($spot_list as $spot) {
                $result[] = $spot->getClassParams(false);
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