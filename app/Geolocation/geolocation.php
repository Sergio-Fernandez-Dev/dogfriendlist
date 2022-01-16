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

route::add('/add-to-favs', 'POST',
    function () {

        if ($_POST['marker_id']) {
            session_start();

            $db = new DB();
            $qb = new QueryBuilder();
            $user_id = $_SESSION['user']['id'];
            $spot_id = $_POST['marker_id'];
            $data = [
                'user_id' => $user_id,
                'spot_id' => $spot_id,
            ];

            $qb->setTableName('Favourites');
            $query = $qb->insert($data)->get();
            $db->persist($query);
            $db->disconnect();
        }
    }
);

route::add('/remove-from-favs', 'POST',
    function () {

        if ($_POST['marker_id']) {
            session_start();

            $db = new DB();
            $qb = new QueryBuilder();
            $user_id = $_SESSION['user']['id'];
            $spot_id = $_POST['marker_id'];

            $qb->setTableName('Favourites');
            $query = $qb->delete()
                ->where('spot_id', '=', $spot_id)
                ->andWhere('user_id', '=', $user_id)
                ->get();
            $db->persist($query);
            $db->disconnect();
        }
    }
);

route::add('/check-favs', 'POST',
    function () {

        if ($_POST['marker_id']) {
            session_start();

            $db = new DB();
            $qb = new QueryBuilder();
            $user_id = $_SESSION['user']['id'];
            $spot_id = $_POST['marker_id'];
            $data = [
                'user_id' => $user_id,
                'spot_id' => $spot_id,
            ];

            $qb->setTableName('Favourites');
            $query = $qb->select()
                ->where('spot_id', '=', $spot_id)
                ->andWhere('user_id', '=', $user_id)
                ->get();
            $result = $db->retrieve($query);
            $db->disconnect();

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