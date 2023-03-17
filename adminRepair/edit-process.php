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
    $etype = htmlentities($_POST['etype']);
    $technician = htmlentities($_POST['technician']);
    $defective = htmlentities($_POST['defective']);
    $shipping = htmlentities($_POST['shipping']);
    $date = htmlentities($_POST['date']);
    $completed = htmlentities($_POST['completed']);
    $initial_payment = htmlentities($_POST['initial_payment']);
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


        $query4 = "UPDATE rprq SET etype='$etype', defective='$defective', shipping='$shipping', date_req='$date', date_completed='$completed', cust_id='$customer_id', status='$status', tech_id='$technician', payment='$payment', initial_payment='$initial_payment' WHERE transaction_code='$transaction_code'";
        $result4 = mysqli_query($conn, $query4);
        
        $techStatus = '';
        if ($status == 'In-progress') {
            $techStatus = 'Unavailable';
        } else if (in_array($status, ['Pending', 'Accepted', 'Done', 'Completed'])) {
            $techStatus = 'Active';
        }

          // Update the technician's status
  if (!empty($techStatus)) {
    $query5 = "UPDATE technician SET status = '$techStatus' WHERE tech_id = '$technician'";
    $result5 = mysqli_query($conn, $query5);
}
        

    if ($result5) {
        header("location: view-transaction.php?msg=Record updated Successfully.&transaction_code=" . $transaction_code . "&rowid=" . $row['id']);
    } else {
        echo "FAILED: " . mysqli_error($conn);
    }
}

?>