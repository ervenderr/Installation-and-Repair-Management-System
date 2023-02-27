<?php
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');



if(!empty($_POST["service_id"])) {
    $service_id = mysqli_real_escape_string($conn, $_POST["service_id"]);
    $sql = "SELECT * FROM package WHERE service_id = '$service_id'";
    $result = mysqli_query($conn, $sql);

    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $data[] = array("pkg_id" => $row["pkg_id"], "name" => $row["name"]);
    }

    header('Content-type: application/json');
    echo json_encode($data);
}
?>
