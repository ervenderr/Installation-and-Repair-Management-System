<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if (isset($_POST['id'])) {
  $output = '';
  $user_id = $_SESSION['logged_id'];
  $_SESSION['id'] = $_POST['id'];
  $query = "SELECT * FROM rprq WHERE id = '" . $_POST['id'] . "'";
  $result = mysqli_query($conn, $query);
  $inventory = mysqli_fetch_assoc($result); // Fetch the data from the result set

  $output .= '
  <form method="POST" action="update-status.php" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="status" class="form-label">Technician</label>
          <select class="form-select" id="status" name="status">';

  // Query the supplier table
  $query6 = "SELECT rprq.*, 
          customer.fname AS cust_fname, 
          customer.lname AS cust_lname, 
          technician.fname AS tech_fname, 
          technician.lname AS tech_lname, 
          technician.status AS tech_status, 
          rprq.status AS rprq_status, 
          accounts.*,
          technician.*,
          customer.*
        FROM rprq
        LEFT JOIN technician ON rprq.tech_id = technician.tech_id
        LEFT JOIN customer ON rprq.cust_id = customer.cust_id
        LEFT JOIN accounts ON customer.account_id = accounts.account_id
        WHERE rprq.id = '" . $_POST['id'] . "';";
  $result6 = mysqli_query($conn, $query6);

  // Check if the query was successful and output the data
  if (mysqli_num_rows($result6) > 0) {
      $row6 = mysqli_fetch_assoc($result6);
  }
  $output .= '<option value="Pending"';
  $output .= ($row6['rprq_status'] == 'Pending') ? ' selected' : '';
  $output .= '>Pending</option>';
  $output .= '<option value="Accepted"';
  $output .= ($row6['rprq_status'] == 'Accepted') ? ' selected' : '';
  $output .= '>Accepted</option>';
  $output .= '<option value="In-progress"';
  $output .= ($row6['rprq_status'] == 'In-progress') ? ' selected' : '';
  $output .= '>In-progress</option>';
  $output .= '<option value="Done"';
  $output .= ($row6['rprq_status'] == 'Done') ? ' selected' : '';
  $output .= '>Done</option>';
  $output .= '<option value="Completed"';
  $output .= ($row6['rprq_status'] == 'Completed') ? ' selected' : '';
  $output .= '>Completed</option>';

  $output .= '
          </select>
        </div>
        <div class="mb-3">
        <label for="completed" class="form-label">Expected Completion</label>
        <input type="date" class="form-control" id="completed" name="completed">
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <input name="submit" type="submit" class="btn btn-danger" value="Accept"/>
        </div>
  </form>';

  echo $output;
}



if (isset($_POST['submit'])) {
  $id = htmlentities($_SESSION['id']);
  $techId = htmlentities($_POST['tech']);
  $payment = htmlentities($_POST['payment']);
  $completed = htmlentities($_POST['completed']);
  $status = htmlentities($_POST['status']); // Get the value of the status

  $query = "UPDATE rprq SET tech_id = '$techId', date_completed = '$completed', status = '$status' WHERE id = '$id'";

  $result = mysqli_query($conn, $query);

  // Determine the technician's status based on the rprq status
  $techStatus = '';
  if ($status == 'In-progress') {
      $techStatus = 'Unavailable';
  } else if (in_array($status, ['Pending', 'Accepted', 'Done', 'Completed'])) {
      $techStatus = 'Active';
  }

  // Update the technician's status
  if (!empty($techStatus)) {
      $query2 = "UPDATE technician SET status = '$techStatus' WHERE tech_id = '$techId'";
      $result2 = mysqli_query($conn, $query2);
  }

  if ($result) {
      $_SESSION['msg'] = "Record Updated Successfully";
      header("location: transaction.php");
  } else {
      echo "FAILED: " . mysqli_error($conn);
  }
}


?>
