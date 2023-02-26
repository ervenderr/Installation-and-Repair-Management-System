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

    if ($result3) {
        // retrieve the cust_type for the updated/inserted customer record
        $query4 = "SELECT cust_type FROM customer WHERE cust_id = '$customer_id'";
        $result4 = mysqli_query($conn, $query4);
        if(mysqli_num_rows($result4) > 0) {
            $row4 = mysqli_fetch_assoc($result4);
            $cust_type = $row4['cust_type'];

            // Check the customer type and set the $href variable accordingly
            if ($cust_type == 'walk-in') {
                $href = "walk-in.php";
            } elseif ($cust_type == 'online') {
                $href = "online.php";
            }

            // Redirect to the appropriate page with a success message
            header("location: $href?msg=Record Updated Successfully");
        } else {
            echo "Failed to retrieve cust_type from the database.";
        }
    } else {
        echo "FAILED: " . mysqli_error($conn);
    }    
}
?>