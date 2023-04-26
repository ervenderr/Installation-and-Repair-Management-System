<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if (isset($_POST['id'])) {
    $output = '';
    $user_id = $_SESSION['logged_id'];
    $_SESSION['id'] = $_POST['id'];
    $query = "SELECT * FROM elec_brand
    WHERE eb_id = '" . $_POST['id'] . "'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    

    $output .= '
<form method="POST" action="update-brand.php" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="brandname" class="form-label">Brand Name</label>
        <input type="text" class="form-control" name="brandname" id="brandname" value="'. $row['eb_name'] .'">
        <span class="error"></span>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <input name="submit" type="submit" class="btn btn-danger" value="Submit" />
    </div>
</form>';



    echo $output;
}



if (isset($_POST['submit'])) {
    $id = htmlentities($_SESSION['id']);
    $brandname = htmlentities($_POST['brandname']);

    $query = "UPDATE elec_brand SET eb_name = '$brandname' WHERE eb_id = '$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: parts.php");
    } else {
        echo "FAILED: " . mysqli_error($conn);
    }
}
?>