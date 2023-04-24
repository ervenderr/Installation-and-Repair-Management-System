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

    $image_contents = array();

    // Loop over each file input field and process any uploaded images
    for ($i = 1; $i <= 3; $i++) {
        if (!empty($_FILES['img'.$i]['name'])) {
            $filename = $_FILES['img'.$i]['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            $allowedtypes = array('png', 'jpg', 'jpeg', 'gif');
            if (in_array($filetype, $allowedtypes)) {
                $image = $_FILES['img'.$i]['tmp_name'];
                $image_contents[$i] = file_get_contents($image);
            }
        }
    }


    // Build the SQL query string
    $sql = "UPDATE package SET ";
    $sql .= "service_id = ?, ";
    $sql .= "name = ?, ";
    $sql .= "price = ?, ";
    $sql .= "descriptions = ?, ";
    $sql .= "status = ? ";


    // Add binary data for each uploaded image
    if (!empty($image_contents[1])) {
        $sql .= ", img = ? ";
    }

    $sql .= "WHERE pkg_id = ?";

   // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters to the statement
    if (!empty($image_contents[1])) {
        mysqli_stmt_bind_param($stmt, "sssssbi", $sname, $pname, $price, $description, $status, $image_contents[1], $id);
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