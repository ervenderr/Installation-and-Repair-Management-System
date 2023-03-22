<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if (isset($_POST['submit'])) {
    $product_id = $_SESSION['rowid'];
    // assign form data to variables
    $category = $_POST['category'];
    $pname = $_POST['pname'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $full = $_POST['full'];
    $features = $_POST['features'];

    $status = "In-Stock";

    $image_contents = array();

    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
    $row2 = mysqli_fetch_assoc($result);

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
    $sql .= "categ_id = ?, ";
    $sql .= "name = ?, ";
    $sql .= "price = ?, ";
    $sql .= "description = ?, ";
    $sql .= "full_descriptions = ?, ";
    $sql .= "features = ?, ";

    // Add binary data for each uploaded image
    if (!empty($image_contents[1])) {
        $sql .= "img1 = ?, ";
    }
    if (!empty($image_contents[2])) {
        $sql .= "img2 = ?, ";
    }
    if (!empty($image_contents[3])) {
        $sql .= "img3 = ?, ";
    }

    $sql .= "status = ? ";
    $sql .= "WHERE product_id = ?";

   // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters to the statement
    if (!empty($image_contents[1]) && !empty($image_contents[2]) && !empty($image_contents[3])) {
        mysqli_stmt_bind_param($stmt, "ssdssssssssb", $category, $pname, $price, $description, $full, $features, $image_contents[1], $image_contents[2], $image_contents[3], $status, $product_id);
    } else if (!empty($image_contents[1]) && !empty($image_contents[2])) {
        mysqli_stmt_bind_param($stmt, "ssdsssssssb", $category, $pname, $price, $description, $full, $features, $image_contents[1], $image_contents[2], $status, $product_id);
    } else if (!empty($image_contents[1]) && !empty($image_contents[3])) {
        mysqli_stmt_bind_param($stmt, "ssdsssssbbs", $category, $pname, $price, $description, $full, $features, $image_contents[1], $status, $image_contents[3], $product_id);
    } else if (!empty($image_contents[2]) && !empty($image_contents[3])) {
        mysqli_stmt_bind_param($stmt, "ssdssssbssb", $category, $pname, $price, $description, $full, $features, $status, $image_contents[2], $image_contents[3], $product_id);
    } else if (!empty($image_contents[1])) {
        mysqli_stmt_bind_param($stmt, "ssdsssssb", $category, $pname, $price, $description, $full, $features, $image_contents[1], $status, $product_id);
    } else if (!empty($image_contents[2])) {
        mysqli_stmt_bind_param($stmt, "ssdssssb", $category, $pname, $price, $description, $full, $features, $image_contents[2], $status, $product_id);
    } else if (!empty($image_contents[3])) {
        mysqli_stmt_bind_param($stmt, "ssdsssb", $category, $pname, $price, $description, $full, $features, $image_contents[3], $status, $product_id);
    } else {
        mysqli_stmt_bind_param($stmt, "ssdssssi", $category, $pname, $price, $description, $full, $features, $status, $product_id);
    }

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    
    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: view-product.php?rowid=" .  $product_id);
    } else {
        echo "FAILED: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

?>
