<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    // assign form data to variables
    $category = $_POST['category'];
    $pname = $_POST['pname'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $full = $_POST['full'];
    $features = $_POST['features'];

    // Generate SKU based on product name and random number/letter
    $prefix = substr($pname, 0, 6);
    $suffix = mt_rand(1000, 9999) . chr(mt_rand(65, 90));
    $sku = $prefix . $suffix;



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

    $sql = "INSERT INTO products (sku, categ_id, name, price, description, full_descriptions, features, img1, img2, img3) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle error
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ssssssssss", $sku, $category, $pname, $price, $description, $full, $features, $image_contents[1], $image_contents[2], $image_contents[3]);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['msg'] = "Record Added Successfully";
            header("location: products.php");
        } else {
            echo "FAILED: " . mysqli_error($conn);
        }
    }
}
?>
