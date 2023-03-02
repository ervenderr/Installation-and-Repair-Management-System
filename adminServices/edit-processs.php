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
    $stype = htmlentities($_POST['stype']);
    $package = htmlentities($_POST['package']);
    $other = htmlentities($_POST['other']);
    $technician = htmlentities($_POST['technician']);
    $date = htmlentities($_POST['date']);
    $completed = htmlentities($_POST['completed']);
    $payment = htmlentities($_POST['payment']);

    $accountid = $_SESSION['account_id'];
    $rowid = $_SESSION['rowid'];
    $transaction_code = $_SESSION['transaction_code'];

    // check if email already exists in accounts table
    $query = "SELECT account_id FROM accounts WHERE account_id = '$accountid'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $account_id = $row['account_id'];
        $query2 = "SELECT cust_id FROM customer WHERE account_id = '$account_id'";
        $result2 = mysqli_query($conn, $query2);
        if(mysqli_num_rows($result2) > 0) {
            $row2 = mysqli_fetch_assoc($result2);
            $customer_id = $row2['cust_id'];
            // update customer record
            $query3 = "UPDATE customer SET fname='$fname', lname='$lname', phone='$phone', address='$address' WHERE cust_id = '$customer_id'";
            $result3 = mysqli_query($conn, $query3);
        } else {
            // insert into customer table and get customer_id
            $query3 = "INSERT INTO customer (fname, lname, phone, address, account_id) VALUES ('$fname', '$lname', '$phone', '$address', '$account_id')";
            $result3 = mysqli_query($conn, $query3);
            $customer_id = mysqli_insert_id($conn);
        }
    } else {
        // insert new account and get account_id
        $query = "INSERT INTO accounts (email) VALUES ('$email')";
        $result = mysqli_query($conn, $query);
        $account_id = mysqli_insert_id($conn);

        // insert into customer table and get customer_id
        $query3 = "INSERT INTO customer (fname, lname, phone, address, account_id) VALUES ('$fname', '$lname', '$phone', '$address', '$account_id')";
        $result3 = mysqli_query($conn, $query3);
        $customer_id = mysqli_insert_id($conn);
    }

    // update service_request table with new values
    $query4 = "UPDATE service_request SET service_id='$stype', pkg_id='$package', other='$other', date_req='$date', date_completed='$completed', cust_id='$customer_id', status='$status', tech_id='$technician' WHERE transaction_code='$transaction_code'";
    $result4 = mysqli_query($conn, $query4);

    if ($result4) {
        header("location: view-transactions.php?msg=Record updated Successfully.&transaction_code=" . $transaction_code . "&rowid=" . $row['id']);
    } else {
        echo "FAILED: " . mysqli_error($conn);
    }
}

?>