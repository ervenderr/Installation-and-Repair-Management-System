<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if (isset($_GET['id'])) {
    $output = '';
    $_SESSION['id'] = $_GET['id'];
    $id = $_GET['id'];
    $query = "SELECT * FROM rprq WHERE id = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $query);
    $inventory = mysqli_fetch_assoc($result); // Fetch the data from the result set

    $currentStatus = $inventory['status'];
    $stat ='';
    if($inventory['shipping'] == 'Deliver'){
      $status ='To Deliver';
    }else{
      $status ='To Pickup';
    }

    $query = "UPDATE rprq SET status = '$status' WHERE id = '$id'";
    $tquery = "INSERT INTO rp_timeline (rprq_id, tm_date, tm_time, tm_status) VALUES ('$id', NOW(), NOW(), '$status');";

    $result = mysqli_query($conn, $query);
    $tresult = mysqli_query($conn, $tquery);


    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: view-transaction.php?rowid=" . $id . "");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}



// if(isset($_POST['submit'])) {
//     $id = htmlentities($_SESSION['id']);
//     $status = htmlentities($_POST['status']);


//     $query = "UPDATE rprq SET status = '$status' WHERE id = '$id'";
//     $tquery = "INSERT INTO rp_timeline (rprq_id, tm_date, tm_time, tm_status) VALUES ('$id', NOW(), NOW(), '$status');";

//     $result = mysqli_query($conn, $query);
//     $tresult = mysqli_query($conn, $tquery);


//     if ($result) {
//         $_SESSION['techId'] = $techId;
//         $_SESSION['msg'] = "Record Updated Successfully";
//         header("location: view-transaction.php?rowid=" . $id . "");
//     } else {
//        echo "FAILED: " . mysqli_error($conn);
//     }
// }

?>