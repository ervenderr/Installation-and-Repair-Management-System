<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if (isset($_GET['id'])) {
    $output = '';
    $_SESSION['id'] = $_GET['id'];
    $id = $_GET['id'];
    $query = "SELECT * FROM rprq
    LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
    LEFT JOIN rp_warranty ON rprq.id = rp_warranty.rpwarranty_id
    WHERE id = '" . $_GET['id'] . "'";
    $result = mysqli_query($conn, $query);
    $inventory = mysqli_fetch_assoc($result); // Fetch the data from the result set

    

    $currentStatus = $inventory['status'];
    $warranty_num = $inventory['warranty_num'];
    $warranty_unit = $inventory['warranty_unit'];
    $warranty_end_date = $inventory['warranty_end_date'];

    $rpid = $_GET['id'];
    $warranty_status = 'Under warranty';

    // Convert warranty_num to days
switch ($warranty_unit) {
  case 'day(s)':
      $days = $warranty_num;
      break;
  case 'month(s)':
      $days = $warranty_num * 30;
      break;
  case 'year(s)':
      $days = $warranty_num * 365;
      break;
  default:
      $days = 0;
      break;
}

// Calculate warranty_end_date
$warranty_start_date = new DateTime();
$warranty_end_date = $warranty_start_date->add(new DateInterval("P{$days}D"))->format('Y-m-d');

echo $warranty_end_date;
    
    $status ='Completed';

    $query = "UPDATE rprq SET status = '$status' WHERE id = '$id'";
    $tquery = "INSERT INTO rp_timeline (rprq_id, tm_date, tm_time, tm_status) VALUES ('$id', NOW(), NOW(), '$status');";
    $wquery = "INSERT INTO rp_warranty (warranty_start_date, warranty_end_date, warranty_status, rpwarranty_id) VALUES (NOW(), '{$warranty_end_date}', '{$warranty_status}', $rpid)";

    $result = mysqli_query($conn, $query);
    $tresult = mysqli_query($conn, $tquery);
    $wresult = mysqli_query($conn, $wquery);


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