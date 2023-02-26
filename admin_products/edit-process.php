<?php
session_start();
require_once '../homeIncludes/dbconfig.php';



if (isset($_POST['submit'])) {
    // assign form data to variables
    $rowid = $_GET['rowid'];
    $pname = htmlentities($_POST['pname']);
    $price = htmlentities($_POST['price']);
    $description = htmlentities($_POST['description']);
    $full = htmlentities($_POST['full']);
    $features = htmlentities($_POST['features']);

    $status = htmlentities("In-Stock");

    $image_contents = array();

    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
    $row2 = mysqli_fetch_assoc($result);
    $product_id = $row2['product_id'];

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

    // Build the SQL query string
    $sql = "UPDATE products SET ";
    $sql .= "name = '$pname', ";
    $sql .= "price = $price, ";
    $sql .= "description = '$description', ";
    $sql .= "full_descriptions = '$full', ";
    $sql .= "features = '$features', ";
    
    // Add binary data for each uploaded image
    if (!empty($image_contents[1])) {
        $sql .= "img1 = '" . $image_contents[1] . "', ";
    }
    if (!empty($image_contents[2])) {
        $sql .= "img2 = '" . $image_contents[2] . "', ";
    }
    if (!empty($image_contents[3])) {
        $sql .= "img3 = '" . $image_contents[3] . "', ";
    }

    $sql .= "status = '$status' ";
    $sql .= "WHERE product_id = '$rowid'";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        header("location: products.php?msg=Record Updated Successfully");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}


?>