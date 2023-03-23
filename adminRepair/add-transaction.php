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
    $etype = htmlentities($_POST['etype']);
    $technician = htmlentities($_POST['technician']);
    $defective = htmlentities($_POST['defective']);
    $shipping = htmlentities($_POST['shipping']);
    $date = htmlentities($_POST['date']);
    $completed = htmlentities($_POST['completed']);
    $inipayment = htmlentities($_POST['inipayment']);
    $other_defective = htmlentities($_POST['other_defective']);
    

    // generate transaction code
    $transaction_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 11);
    $status = htmlentities("In-progress");
    $user_type = htmlentities('customer');
    $cust_type = htmlentities('walk-in');

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

        $query4 = "INSERT INTO rprq (transaction_code, elec_id, other_defects, shipping, status, cust_id, initial_payment, tech_id, date_completed) VALUES ('$transaction_code', '$etype', '$other_defective', '$shipping', '$status', '$customer_id', '$inipayment', '$technician','$completed')";
        $result4 = mysqli_query($conn, $query4);

        if ($result4) {
            $_SESSION['msg'] = "Record Added Successfully";
            header("location: transaction.php?msg=Record Added Successfully");
        } else {
        echo "FAILED: " . mysqli_error($conn);
        }
    }else{

        $query4 = "INSERT INTO rprq (transaction_code, elec_id, defect_id, shipping, status, cust_id, initial_payment, tech_id, date_completed) VALUES ('$transaction_code', '$etype', '$defective', '$shipping', '$status', '$customer_id', '$inipayment', '$technician', $completed)";
        $result4 = mysqli_query($conn, $query4);

        if ($result4) {
            $_SESSION['msg'] = "Record Added Successfully";
            header("location: transaction.php");
        } else {
        echo "FAILED: " . mysqli_error($conn);
        }
    }

}

?>