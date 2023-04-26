<?php
//fetch.php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    
    $id = htmlentities($_SESSION['rowid']);
    $sname = $_POST['sname'];
    $pname = $_POST['pname'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $image_contents = '';

    // Check if a file was uploaded
    if (!empty($_FILES['img1']['name'])) {
        $filename = $_FILES['img1']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        $allowedtypes = array('png', 'jpg', 'jpeg', 'gif');
        if (in_array($filetype, $allowedtypes)) {
            $image = $_FILES['img1']['tmp_name'];
            $image_contents = file_get_contents($image);
        }
    }

    // Build the SQL query string
    $sql = "UPDATE package SET ";
    $sql .= "service_id = ?, ";
    $sql .= "name = ?, ";
    $sql .= "price = ?, ";
    $sql .= "descriptions = ?, ";
    $sql .= "status = ? ";

    // Add binary data for uploaded image, if any
    if (!empty($image_contents)) {
        $sql .= ", image = ? ";
    }

    $sql .= "WHERE pkg_id = ?";

   // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters to the statement
    if (!empty($image_contents)) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $sname, $pname, $price, $description, $status, $image_contents, $id);
    } else {
        mysqli_stmt_bind_param($stmt, "sssssi", $sname, $pname, $price, $description, $status, $id);

    }

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    
    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: view-package.php?rowid=" .$id);
    } else {
        echo "FAILED: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>
