<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if(isset($_POST['id'])){
    $output = '';
    $_SESSION['id'] = $_POST['id'];
    $query = "SELECT * FROM rprq WHERE id = '".$_POST['id']."'";
    $result = mysqli_query($conn, $query);
    $inventory = mysqli_fetch_assoc($result); // Fetch the data from the result set

    $output .= '
    <form method="POST" action="accept-pending.php" enctype="multipart/form-data">
          <div class="mb-3">
          <label for="payment" class="form-label">Initial Payment</label>
          <input type="number" class="form-control" id="payment" name="payment">
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <input name="submit" type="submit" class="btn btn-danger" value="Accept"/>
          </div>
    </form>';

    echo $output;
}


if(isset($_POST['submit'])) {
    $id = htmlentities($_SESSION['id']);
    $techId = htmlentities($_POST['tech']);
    $payment = htmlentities($_POST['payment']);
    $completed = htmlentities($_POST['completed']);
    $status = "Accepted";


    $query = "UPDATE rprq SET payment = '$payment', status = '$status' WHERE id = '$id'";

    $result = mysqli_query($conn, $query);
    

    if ($result) {
        $_SESSION['msg'] = "Initial Payment recorded";
        header("location: accepted.php");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>
