<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    // assign form data to variables
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // check if email already exists in accounts table
    $query = "SELECT account_id FROM accounts WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        // Handle error
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $account_id = $row['account_id'];
            $query2 = "SELECT cust_id FROM customer WHERE account_id = ?";
            $stmt2 = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt2, $query2)) {
                // Handle error
                exit();
            } else {
                mysqli_stmt_bind_param($stmt2, "i", $account_id);
                mysqli_stmt_execute($stmt2);
                $result2 = mysqli_stmt_get_result($stmt2);

                if(mysqli_num_rows($result2) > 0) {
                    $row2 = mysqli_fetch_assoc($result2);
                    $customer_id = $row2['cust_id'];

                    // update customer record
                    $query3 = "UPDATE customer SET fname=?, lname=?, phone=?, address=? WHERE cust_id = ?";
                    $stmt3 = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt3, $query3)) {
                        // Handle error
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt3, "ssssi", $fname, $lname, $phone, $address, $customer_id);
                        mysqli_stmt_execute($stmt3);
                        $result3 = mysqli_stmt_affected_rows($stmt3);
                    }
                } else {
                    // insert into customer table and get customer_id
                    $query3 = "INSERT INTO customer (fname, lname, phone, address, account_id) VALUES (?, ?, ?, ?, ?)";
                    $stmt3 = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt3, $query3)) {
                        // Handle error
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt3, "ssssi", $fname, $lname, $phone, $address, $account_id);
                        mysqli_stmt_execute($stmt3);
                        $result3 = mysqli_stmt_affected_rows($stmt3);
                        $customer_id = mysqli_insert_id($conn);
                    }
                }
            }
        } else {
            // insert new account and get account_id
            $query = "INSERT INTO accounts (email) VALUES (?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $query)) {
                // Handle error
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $account_id = mysqli_insert_id($conn);

                // insert into customer table and get customer_id
                $query3 = "INSERT INTO customer (fname, lname, phone, address, account_id) VALUES (?, ?, ?, ?, ?)";
                $stmt3 = mysqli_stmt_init($conn);
                if (!                mysqli_stmt_prepare($stmt3, $query3)) {
                    // Handle error
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt3, "ssssi", $fname, $lname, $phone, $address, $account_id);
                    mysqli_stmt_execute($stmt3);
                    $result3 = mysqli_stmt_affected_rows($stmt3);
                    $customer_id = mysqli_insert_id($conn);
                }
            }
        }

        if ($result3 > 0) {
            // retrieve the cust_type for the updated/inserted customer record
            $query4 = "SELECT cust_type FROM customer WHERE cust_id = ?";
            $stmt4 = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt4, $query4)) {
                // Handle error
                exit();
            } else {
                mysqli_stmt_bind_param($stmt4, "i", $customer_id);
                mysqli_stmt_execute($stmt4);
                $result4 = mysqli_stmt_get_result($stmt4);

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
                    $_SESSION['msg'] = "Record Updated Successfully";
                    header("location: $href");
                } else {
                    echo "Failed to retrieve cust_type from the database.";
                }
            }
        } else {
            echo "FAILED: " . mysqli_error($conn);
        }    
    }
}


?>