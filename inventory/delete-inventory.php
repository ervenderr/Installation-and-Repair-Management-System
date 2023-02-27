<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['inv_id'])) {
    $_SESSION['inv_id'] = $_POST['inv_id'];
    $output = '';
    $output .= '
    <form method="POST" action="delete-inventory.php" enctype="multipart/form-data">
    Are you sure you want to delete this record?
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <input name="submit" type="submit" class="btn btn-danger" value="Delete"/>
          </div>
        </form>
    </form>';
    echo $output;

}
if(isset($_POST['submit'])) {
    $productId = htmlentities($_SESSION['rowid']);
    $invId = htmlentities($_SESSION['inv_id']);
    $query = "DELETE FROM inventory WHERE inv_id = '$invId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Return a success message
        header("location: view-inventory.php?msg2=Record deleted Successfully.&prod_id=" . $productId);
    } else {
        // Return an error message
        echo "Failed to delete record: " . mysqli_error($conn);
    }
}
