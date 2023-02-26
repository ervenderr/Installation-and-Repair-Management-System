<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    // assign form data to variables
    $pname = htmlentities($_POST['pname']);
    $price = htmlentities($_POST['price']);
    $description = htmlentities($_POST['description']);
    $full = htmlentities($_POST['full']);
    $features = htmlentities($_POST['features']);

    $status = htmlentities("In-Stock");

    $image_contents = array();

    // Loop over each file input field and process any uploaded images
    for ($i = 1; $i <= 3; $i++) {
        if (!empty($_FILES['img'.$i]['name'])) {
            $filename = $_FILES['img'.$i]['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            $allowedtypes = array('png', 'jpg', 'jpeg', 'gif');
            if (in_array($filetype, $allowedtypes)) {
                $image = $_FILES['img'.$i]['tmp_name'];
                $image_contents[$i] = addslashes(file_get_contents($image));
            }
        }
    }

    $sql = "INSERT INTO products (name, price, description, full_descriptions, features, img1, img2, img3, status) 
        VALUES ('$pname', '$price', '$description', '$full', '$features', ";

    // Add binary data for each uploaded image
    for ($i = 1; $i <= 3; $i++) {
        if (!empty($image_contents[$i])) {
            $sql .= "'" . $image_contents[$i] . "', ";
        } else {
            $sql .= "NULL, ";
        }
    }

    // Add the status field and complete the SQL statement
    $sql .= "'$status')";

$result = mysqli_query($conn, $sql);
    
if ($result) {
    header("location: products.php?msg=Record Added Successfully");
} else {
   echo "FAILED: " . mysqli_error($conn);
}
}


?>