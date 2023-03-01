<?php
session_start();

if (isset($_SESSION['cust_id'])) {
    // retrieve the cust_id value
    $cust_id = $_SESSION['cust_id'];
    // use the cust_id value in your code
    echo "The cust_id is: " . $cust_id;
} else {
    // the cust_id value is not set
    echo "The cust_id is not set";
}
?>
