<?php
require_once '../homeIncludes/dbconfig.php';


if (isset($_POST['rprq_id'])) {
    $rprq_id = $_POST["rprq_id"];

    $query = "UPDATE rprq SET rp_isread = 1";
    mysqli_query($conn, $query);
}

?>