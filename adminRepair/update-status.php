<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if (isset($_POST['id'])) {
    $output = '';
    $_SESSION['id'] = $_POST['id'];
    $query = "SELECT * FROM rprq WHERE id = '" . $_POST['id'] . "'";
    $result = mysqli_query($conn, $query);
    $inventory = mysqli_fetch_assoc($result); // Fetch the data from the result set

    $currentStatus = $inventory['status'];
    $stat ='';
    if($inventory['shipping'] == 'Deliver'){
      $stat ='To Deliver';
    }else{
      $stat ='To Pickup';
    }
    $output .= '
    <form method="POST" action="update-status.php" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="Pending"' . ($currentStatus == "Pending" ? " selected" : "") . '>Pending</option>
                <option value="In-progress"' . ($currentStatus == "In-progress" ? " selected" : "") . '>In-progress</option>
                <option value="Repairing"' . ($currentStatus == "Repairing" ? " selected" : "") . '>Repairing</option>
                <option value="'. $stat .'"' . ($currentStatus == "$stat" ? " selected" : "") . '>'. $stat .'</option>
                <option value="Completed"' . ($currentStatus == "Completed" ? " selected" : "") . '>Completed</option>
                <option value="Cancelled"' . ($currentStatus == "Cancelled" ? " selected" : "") . '>Cancelled</option>
                <option value="Parts Needed"' . ($currentStatus == "Parts Needed" ? " selected" : "") . '>Parts Needed</option>
                <option value="Waiting for parts"' . ($currentStatus == "Waiting for parts" ? " selected" : "") . '>Waiting for parts</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <input name="submit" type="submit" class="btn btn-danger" value="Update"/>
          </div>
    </form>';

    echo $output;
}




if(isset($_POST['submit'])) {
    $id = htmlentities($_SESSION['id']);
    $status = htmlentities($_POST['status']);


    $query = "UPDATE rprq SET status = '$status', date_completed = NOW() WHERE id = '$id'";
    $tquery = "INSERT INTO rp_timeline (rprq_id, tm_date, tm_time, tm_status) VALUES ('$id', NOW(), NOW(), '$status');";

    $result = mysqli_query($conn, $query);
    $tresult = mysqli_query($conn, $tquery);


    if ($result) {
        $_SESSION['techId'] = $techId;
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: view-transaction.php?rowid=" . $id . "");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>