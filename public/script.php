<?php
$coords = [];
if (isset($_POST['lat']) && isset($_POST['lng'])) {
    $coords['lat'] = $_POST['lat'];
    $coords['lng'] = $_POST['lng'];
}
$coords['city'] = 'Oviedo';
echo json_encode($coords);
?>