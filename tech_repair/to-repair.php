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
  <form method="POST" action="to-repair.php" enctype="multipart/form-data">';

  // Query the supplier table
  $query6 = "SELECT rprq.*, 
  technician.fname AS tech_fname, 
  technician.lname AS tech_lname, 
  technician.phone AS tech_phone,
  technician.status AS tech_status, 
  customer.fname AS cust_fname, 
  customer.lname AS cust_lname, 
  customer.phone AS cust_phone,
  rprq.status AS rprq_status,
  rprq.elec_id AS rprq_elec,
  accounts.*,
  technician.*,
  electronics.*,
  rp_timeline.*,
  elec_brand.*,
  defects.*,
  customer.*
  FROM rprq
  LEFT JOIN technician ON rprq.tech_id = technician.tech_id
  LEFT JOIN rp_timeline ON rprq.id = rp_timeline.rprq_id
  LEFT JOIN elec_brand ON rprq.eb_id = elec_brand.eb_id
  LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
  LEFT JOIN defects ON rprq.defect_id = defects.defect_id
  LEFT JOIN customer ON rprq.cust_id = customer.cust_id
  LEFT JOIN accounts ON customer.account_id = accounts.account_id
        WHERE rprq.id = '" . $_POST['id'] . "';";
  $result6 = mysqli_query($conn, $query6);

  // Check if the query was successful and output the data
  if (mysqli_num_rows($result6) > 0) {
      $row6 = mysqli_fetch_assoc($result6);
  }
 $elec_id = $row6['rprq_elec'];
 $eb_id = $row6['eb_id'];

  $output .= '
  <div class="row">
  <div class="col-6">
  <div class="mb-3">
  <input type="type" class="form-control" id="status" name="status" value="Repairing" hidden>
    <label for="from" class="form-label">Estimated Completion (from)</label>
    <input type="date" class="form-control" id="from" name="from" value="' . $row6['date_from'] . '">
  </div>
  </div>
  <div class="col-6">
  <div class="mb-3">
    <label for="to" class="form-label">(to)</label>
    <input type="date" class="form-control" id="to" name="to" value="' . $row6['date_to'] . '">
    </div>
    </div>
  </div>
  </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <input name="submit" type="submit" class="btn btn-success" value="Update"/>
        </div>';
        $output .= '<input type="hidden" id="hiddenInput" name="tech_id" value="' . $row6['tech_id'] . '">';
        $output .= '<input type="hidden" id="hiddenInput" name="transaction_code" value="' . $row6['transaction_code'] . '">

  </form>';

  echo $output;
}

if (isset($_POST['submit'])) {
    $id = htmlentities($_SESSION['id']);
    $status = htmlentities($_POST['status']); 
    $from = htmlentities($_POST['from']); 
    $to = htmlentities($_POST['to']); 
  
    $elec_id = // Get the elec_id from your data source
    $rprq_id = htmlentities($_SESSION['id']);
    $comrep = $_POST['comrep'];
    $parts = $_POST['parts'];
    

    $query = "UPDATE rprq SET date_from = '$from', date_to = '$to', status = '$status' WHERE id = '$id'";
    $tquery = "INSERT INTO rp_timeline (rprq_id, tm_date, tm_time, tm_status) VALUES ('$id', NOW(), NOW(), '$status');";

  $result = mysqli_query($conn, $query);
  $tresult = mysqli_query($conn, $tquery);


  if ($result) {
      $_SESSION['msg'] = "Record Updated Successfully";
      header("location: ../tech_repair/view-transaction.php?transaction_code=" . $transaction_code . "&rowid=" . $id);
  } else {
      echo "FAILED: " . mysqli_error($conn);
  }
}
?>