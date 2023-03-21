<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if (isset($_POST['submit'])) {
    $id = htmlentities($_POST['sreq_id']);
    $custid = htmlentities($_SESSION['cust_id']);
    $fname = htmlentities($_POST['fname']);
    $lname = htmlentities($_POST['lname']);
    $email = htmlentities($_POST['email']);
    $phone = htmlentities($_POST['phone']);
    $address = htmlentities($_POST['address']);
    $status = htmlentities($_POST['status']);
    $stype = htmlentities($_POST['stype']);
    $package = htmlentities($_POST['package']);
    $other = htmlentities($_POST['other']);
    $date = htmlentities($_POST['date']);
    $completed = htmlentities($_POST['completed']);
    $initial_payment = htmlentities($_POST['initial_payment']);
    $payment = htmlentities($_POST['payment']);

    $techIds = $_POST['technician'];

    // Update the service_request table with new values
    $query = "UPDATE service_request SET service_id=?, pkg_id=?, other=?, date_req=?, date_completed=?, cust_id=?, status=?, payment=?, initial_payment=? WHERE sreq_id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iisssisssi', $stype, $package, $other, $date, $completed, $custid, $status, $payment, $initial_payment, $id);
    mysqli_stmt_execute($stmt);

    // Remove any existing technicians assigned to this service request
    $delete_query = "DELETE FROM service_request_technicians WHERE sreq_id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($delete_stmt, 'i', $id);
    mysqli_stmt_execute($delete_stmt);

    // Assign the new technicians to the service request and set their status to "Unavailable"
    foreach ($techIds as $techId) {
        $insert_query = "INSERT INTO service_request_technicians (sreq_id, tech_id) VALUES (?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, 'ii', $id, $techId);
        mysqli_stmt_execute($insert_stmt);

        // Update the technician status
        $techStatus = '';
        if ($status == 'In-progress') {
            $techStatus = 'Unavailable';
        } else if (in_array($status, ['Pending', 'Accepted', 'Done', 'Completed'])) {
            $techStatus = 'Active';
        }

        if (!empty($techStatus)) {
            $tech_update_query = "UPDATE technician SET status = ? WHERE tech_id = ?";
            $tech_update_stmt = mysqli_prepare($conn, $tech_update_query);
            mysqli_stmt_bind_param($tech_update_stmt, 'si', $tech_status, $techId);
            mysqli_stmt_execute($tech_update_stmt);
        }


    }

    if (mysqli_stmt_errno($stmt) == 0) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: transactions.php");
    } else {
        echo "FAILED: " . mysqli_error($conn);
    }
    
}
?>
