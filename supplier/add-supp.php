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

    // insert into technician table and get technician_id
    $query3 = "INSERT INTO supplier (fname, lname, phone, email, address) VALUES ('$fname', '$lname', '$phone', '$email', '$address')";
    $result3 = mysqli_query($conn, $query3);
    $tech_id = mysqli_insert_id($conn);

    if ($result3) {
        header("location: supplier.php?msg=Record Added Successfully");
    } else {
        echo "FAILED: " . mysqli_error($conn);
    }
}
?>
