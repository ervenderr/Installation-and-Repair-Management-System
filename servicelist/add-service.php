<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    // assign form data to variables
    $pname = $_POST['sname'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $status = 'Active';

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

    $sql = "INSERT INTO services (service_name, description, img, status) 
        VALUES (?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle error
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ssss", $pname, $description, $image_contents[1], $status);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['msg'] = "Record Added Successfully";
            header("location: servicelist.php");
        } else {
            echo "FAILED: " . mysqli_error($conn);
        }
    }
}
?>
