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
    $technician = htmlentities($_POST['technician']);

    if(isset($_POST['etype'])){
    $etype = $_POST['etype'];
    }
    $defective = htmlentities($_POST['defective']);
    $other_defective = htmlentities($_POST['other_defective']);
    $other_brand = htmlentities($_POST['other_brand']);
    $ebrand = htmlentities($_POST['ebrand']);
    $shipping = $_POST['shipping'];
    

    // generate transaction code
    $transaction_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 11);
    $status = htmlentities("Diagnosing");
    $user_type = htmlentities('customer');
    $cust_type = htmlentities('Walk-in');

    // check if email already exists in accounts table
    $query = "SELECT account_id FROM accounts WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $account_id = $row['account_id'];
        $query2 = "SELECT cust_id FROM customer WHERE account_id = '$account_id'";
        $result2 = mysqli_query($conn, $query2);
        if(mysqli_num_rows($result2) > 0) {
            $row2 = mysqli_fetch_assoc($result2);
            $customer_id = $row2['cust_id'];
        } else {
            // insert into customer table and get customer_id
            $query3 = "INSERT INTO customer (fname, lname, phone, address, account_id, cust_type) VALUES ('$fname', '$lname', '$phone', '$address', '$account_id','$cust_type')";
            $result3 = mysqli_query($conn, $query3);
            $customer_id = mysqli_insert_id($conn);
        }
    } else {
        // insert new account and get account_id
        $query = "INSERT INTO accounts (email, user_type) VALUES ('$email', '$user_type')";
        $result = mysqli_query($conn, $query);
        $account_id = mysqli_insert_id($conn);

        // insert into customer table and get customer_id
        $query3 = "INSERT INTO customer (fname, lname, phone, address, account_id, cust_type) VALUES ('$fname', '$lname', '$phone', '$address', '$account_id','$cust_type')";
        $result3 = mysqli_query($conn, $query3);
        $customer_id = mysqli_insert_id($conn);
    }

    if ($defective === "other"){

        $query = "INSERT INTO rprq (cust_id, transaction_code, elec_id, eb_id, other_defects, shipping, status, tech_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
    
        mysqli_stmt_bind_param($stmt, "isssssss", $customer_id, $transaction_code, $etype, $ebrand, $other_defective, $shipping, $status, $technician);
        mysqli_stmt_execute($stmt);
        
    }elseif ($ebrand === "other"){
    
        $query = "INSERT INTO rprq (cust_id, transaction_code, elec_id, other_brand, defect_id, shipping, status, tech_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
    
        mysqli_stmt_bind_param($stmt, "isssssss", $customer_id, $transaction_code, $etype, $other_brand, $defective, $shipping, $status, $technician);
        mysqli_stmt_execute($stmt);
        
    }elseif ($ebrand === "other" && $defective === "other"){
    
        $query = "INSERT INTO rprq (cust_id, transaction_code, elec_id, other_brand, other_defects, shipping, status, tech_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
    
        mysqli_stmt_bind_param($stmt, "isssssss", $customer_id, $transaction_code, $etype, $other_brand, $other_defective, $shipping, $status, $technician);
        mysqli_stmt_execute($stmt);
        
    }else{
    
        $query = "INSERT INTO rprq (cust_id, transaction_code, elec_id, eb_id, defect_id, shipping, status, tech_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
    
        mysqli_stmt_bind_param($stmt, "isssssss", $customer_id, $transaction_code, $etype, $ebrand, $defective, $shipping, $status, $technician);
        mysqli_stmt_execute($stmt);
    }

    // Get the ID of the newly inserted row
    $newly_inserted_id = mysqli_insert_id($conn);
    $tquery = "INSERT INTO rp_timeline (rprq_id, tm_date, tm_time, tm_status) VALUES ('$newly_inserted_id', NOW(), NOW(), '$status');";
    $tresult = mysqli_query($conn, $tquery);

    if ($tresult) {
        $_SESSION['msg'] = "Record Added Successfully";
        header("location: transaction.php");
    } else {
    echo "FAILED: " . mysqli_error($conn);
    }

}


    
?>