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
    $expertise = htmlentities($_POST['expert']);
    $password = htmlentities($_POST['password']);
    $status = htmlentities($_POST['status']);
    $limit = htmlentities($_POST['limit']);

    $image_contents = '';

    // Check if a file was uploaded
    if (!empty($_FILES['img']['name'])) {
        $filename = $_FILES['img']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        $allowedtypes = array('png', 'jpg', 'jpeg', 'gif');
        if (in_array($filetype, $allowedtypes)) {
            $image = $_FILES['img']['tmp_name'];
            $image_contents = file_get_contents($image);
        }
    }

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
            if (!empty($image_contents)){
                $image_contents = mysqli_real_escape_string($conn, $image_contents);
                $query3 = "UPDATE technician SET fname='$fname', lname='$lname', phone='$phone', address='$address', status='$status', expertise='$expertise', tech_img='$image_contents', limit_per_day='$limit' WHERE tech_id = '$technician_id'";
            } else {
                $query3 = "UPDATE technician SET fname='$fname', lname='$lname', phone='$phone', address='$address', status='$status', expertise='$expertise', limit_per_day='$limit' WHERE tech_id = '$technician_id'";
            }            
            $result3 = mysqli_query($conn, $query3);
        } else {
            // insert into technician table and get technician_id
            if (!empty($image_contents)){
                $image_contents = mysqli_real_escape_string($conn, $image_contents);
                $query3 = "UPDATE technician SET fname='$fname', lname='$lname', phone='$phone', address='$address', status='$status', expertise='$expertise', tech_img='$image_contents', limit_per_day='$limit' WHERE tech_id = '$technician_id'";
            } else {
                $query3 = "UPDATE technician SET fname='$fname', lname='$lname', phone='$phone', address='$address', status='$status', expertise='$expertise', limit_per_day='$limit' WHERE tech_id = '$technician_id'";
            }            
            $result3 = mysqli_query($conn, $query3);
            $technician_id = mysqli_insert_id($conn);
        }
    } else {
        // insert new account and get account_id
        $query = "INSERT INTO accounts (email) VALUES ('$email')";
        $result = mysqli_query($conn, $query);
        $account_id = mysqli_insert_id($conn);

        // insert into technician table and get technician_id
        if (!empty($image_contents)){
            $query3 = "INSERT INTO technician (fname, lname, phone, address, account_id, status, expertise, limit_per_day, tech_img) VALUES ('$fname', '$lname', '$phone', '$address', '$account_id','$status', '$expertise', '$limit', '$image_contents')";
        } else{
            $query3 = "INSERT INTO technician (fname, lname, phone, address, account_id, status, expertise, limit_per_day) VALUES ('$fname', '$lname', '$phone', '$address', '$account_id','$status', '$expertise', '$limit')";
        }
        
        $result3 = mysqli_query($conn, $query3);
        $technician_id = mysqli_insert_id($conn);
    }

    if ($result3) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: view-technician.php?&rowid=" . $technician_id);
    } else {
        echo "FAILED: " . mysqli_error($conn);
    }
}

?>
