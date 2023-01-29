<?php
require_once 'homeIncludes/dbconfig.php';

if(!empty($_POST["service_id"])){
    $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
    $sql = "SELECT * FROM package WHERE service_id = '$service_id'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        echo '<option value="None">--Select--</option>';
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['pkg_id'] . "'>" . $row['name'] . "</option>";
        }
    }
}

?>