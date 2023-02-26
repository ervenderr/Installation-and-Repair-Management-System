<?php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    $productId = htmlentities($_SESSION['productId']);
    $invId = htmlentities($_SESSION['invId']);
    $supplierId = htmlentities($_POST['supplierSelect']);
    $quantityInput = htmlentities($_POST['quantityInput']);
    $stockInDateInput = htmlentities($_POST['stockInDateInput']);

    $query = "UPDATE inventory SET 
              product_id = '$productId', 
              supplier_id = '$supplierId', 
              stock_in = '$quantityInput', 
              stock_in_date = '$stockInDateInput'
          WHERE inv_id = '$invId'";

    $result = mysqli_query($conn, $query);
    

    if ($result) {
        header("location: view-inventory.php?msg=Record updated Successfully.&rowid=" . $productId);
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>
