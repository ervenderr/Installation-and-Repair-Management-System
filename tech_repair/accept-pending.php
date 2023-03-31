<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if(isset($_POST['id'])){
    $output = '';
    $user_id = $_SESSION['logged_id'];
    $_SESSION['id'] = $_POST['id'];
    $query = "SELECT * FROM rprq WHERE id = '".$_POST['id']."'";
    $result = mysqli_query($conn, $query);
    $inventory = mysqli_fetch_assoc($result); // Fetch the data from the result set

    $output .= '
    <form method="POST" action="accept-pending.php" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="tech" class="form-label">Technician</label>
            <select class="form-select" id="tech" name="tech">';

            // Query the supplier table
            $sql = "SELECT * 
            FROM technician 
            INNER JOIN accounts ON technician.account_id = accounts.account_id
            WHERE status = 'Active' AND accounts.account_id = '$user_id'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $output .= "<option value='" . $row["tech_id"] . "'>" . $row['fname'] . '  ' . $row['lname'] . "</option>";
                }
              }

    $output .= '
            </select>
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
    $status = "In-progress";


    $query = "UPDATE rprq SET tech_id = '$techId', status = '$status' WHERE id = '$id'";

    $result = mysqli_query($conn, $query);
    

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: transaction.php");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>
