<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    // assign form data to variables
    $fname = htmlentities($_POST['fname']);
    $lname = htmlentities($_POST['lname']);
    $email = htmlentities($_POST['email']);
    $phone = htmlentities($_POST['phone']);
    $address = htmlentities($_POST['address']);
    $status = htmlentities($_POST['status']);
    $assign = htmlentities($_POST['assign']);

    // check if email already exists in accounts table
    $query = "SELECT account_id FROM accounts WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $account_id = $row['account_id'];
        $query2 = "SELECT tech_id FROM technician WHERE account_id = '$account_id'";
        $result2 = mysqli_query($conn, $query2);
        if(mysqli_num_rows($result2) > 0) {
            $row2 = mysqli_fetch_assoc($result2);
            $technician_id = $row2['tech_id'];
            // update technician record
            $query3 = "UPDATE technician SET fname='$fname', lname='$lname', phone='$phone', address='$address', status='$status', assign='$assign' WHERE tech_id = '$technician_id'";
            $result3 = mysqli_query($conn, $query3);
        } else {
            // insert into technician table and get technician_id
            $query3 = "UPDATE technician SET fname='$fname', lname='$lname', phone='$phone', address='$address', status='$status', assign='$assign' WHERE tech_id = '$technician_id'";
            $result3 = mysqli_query($conn, $query3);
            $technician_id = mysqli_insert_id($conn);
        }
    } else {
        // insert new account and get account_id
        $query = "INSERT INTO accounts (email) VALUES ('$email')";
        $result = mysqli_query($conn, $query);
        $account_id = mysqli_insert_id($conn);

        // insert into technician table and get technician_id
        $query3 = "INSERT INTO technician (fname, lname, phone, address, account_id, status, assign) VALUES ('$fname', '$lname', '$phone', '$address', '$account_id', '$status', '$assign')";
        $result3 = mysqli_query($conn, $query3);
        $technician_id = mysqli_insert_id($conn);
    }

    if ($result3) {
        header("location: technicians.php?msg=Record Updated Successfully");
    } else {
        echo "FAILED: " . mysqli_error($conn);
    }
}

?>
