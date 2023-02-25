<?php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    $productId = htmlentities($_SESSION['productId']);
    $invId = htmlentities($_SESSION['invId']);
    $supplierId = htmlentities($_POST['supplierSelect']);
    $quantityInput = htmlentities($_POST['quantityInput']);
    $stockInDateInput = htmlentities($_POST['stockInDateInput']);

    $query ="INSERT INTO `inventory`(`product_id`, `supplier_id`, `stock_in`, `stock_in_date`) 
    VALUES ('$productId','$supplierId','$quantityInput','$stockInDateInput')";
    $result = mysqli_query($conn, $query);
    

    if ($result) {
        header("location: view-inventory.php?msg=Record Added Successfully.&rowid=" . $productId);
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>
