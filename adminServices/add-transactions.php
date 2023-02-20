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
    $stype = htmlentities($_POST['stype']);
    $package = htmlentities($_POST['package']);
    $other = htmlentities($_POST['other']);
    $electrician = htmlentities($_POST['electrician']);
    $date = htmlentities($_POST['date']);
    $completed = htmlentities($_POST['completed']);
    $payment = htmlentities($_POST['payment']);

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

    // insert into service_request table with customer_id
    $query4 = "INSERT INTO service_request (transaction_code, service_id, pkg_id, other, status, cust_id) VALUES ('$transaction_code', '$stype', '$package', '$other', '$status', '$customer_id')";
    $result4 = mysqli_query($conn, $query4);

    if ($result4) {
        header("location: transactions.php?msg=Record Added Successfully");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>
