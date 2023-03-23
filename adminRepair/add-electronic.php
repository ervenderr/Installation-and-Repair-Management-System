<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])){
    $electronic = $_POST['electronic'];
    $cost = $_POST['cost'];

    $sql = "INSERT INTO electronics (elec_name, cost) VALUES (?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle error
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $electronic, $cost);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['msg'] = "Record Added Successfully";
            header("location: transaction.php");
        } else {
            echo "FAILED: " . mysqli_error($conn);
        }
    }
}

?>