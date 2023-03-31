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
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status">';

  // Query the supplier table
  $query6 = "SELECT rprq.*, 
  customer.fname AS cust_fname, 
  customer.lname AS cust_lname, 
  technician.fname AS tech_fname, 
  technician.lname AS tech_lname, 
  technician.status AS tech_status_new_name, 
  rprq.status AS rprq_status, 
  accounts.*,
  technician.*,
  electronics.*,
  defects.*,
  invoice.*,
  customer.*
  FROM rprq
  LEFT JOIN technician ON rprq.tech_id = technician.tech_id
  LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
  LEFT JOIN defects ON rprq.defect_id = defects.defect_id
  LEFT JOIN customer ON rprq.cust_id = customer.cust_id
  LEFT JOIN accounts ON customer.account_id = accounts.account_id
  LEFT JOIN invoice ON rprq.invoice_id = invoice.invoice_id
        WHERE rprq.id = '" . $_POST['id'] . "';";
  $result6 = mysqli_query($conn, $query6);

  // Check if the query was successful and output the data
  if (mysqli_num_rows($result6) > 0) {
      $row6 = mysqli_fetch_assoc($result6);
  }
 $elec_id = $row6['elec_id'];

  $output .= '<option value="Pending"';
  $output .= ($row6['rprq_status'] == 'Pending') ? ' selected' : '';
  $output .= '>Pending</option>';
  $output .= '<option value="Accepted"';
  $output .= ($row6['rprq_status'] == 'Repairing') ? ' selected' : '';
  $output .= '>Accepted</option>';
  $output .= '<option value="In-progress"';
  $output .= ($row6['rprq_status'] == 'In-progress') ? ' selected' : '';
  $output .= '>In-progress</option>';
  $output .= '<option value="Done"';
  $output .= ($row6['rprq_status'] == 'Cancelled') ? ' selected' : '';
  $output .= '>Done</option>';
  $output .= '<option value="Completed"';
  $output .= ($row6['rprq_status'] == 'Completed') ? ' selected' : '';
  $output .= '>Completed</option>';

  $output .= '
  </select>
    </div>
    <div class="mb-3">
        <label for="comrep" class="form-label">Repair/Replacement Needed<span class="required">*</span></label>
        <select class="form-select js-example-basic-multiple" id="comrep" name="comrep[]" multiple="multiple" required>';

$sql = "SELECT * FROM common_repairs WHERE elec_id = $elec_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $output .= "<option value='" . $row["comrep_id"] . "'>" . $row['comrep_name'] ."</option>";
    }
}

$output .= '
        </select>
    </div>
    <div class="row mb-3">
    <div class="col-8">
        <label for="parts" class="form-label">Parts Needed<span class="required">*</span></label>
        <select class="form-select js-example-basic-multiple" id="parts" name="parts[]" multiple="multiple">';

$sql = "SELECT * FROM brand_parts WHERE eb_id = $elec_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $output .= "<option value='" . $row["bp_id"] . "'>" . $row['bp_name'] ."</option>";
    }
}

$output .= '
        </select>
    </div>
    <div class="col-4">
        <label for="partqty" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="partqty" name="partqty">
        </div>
    </div>
        <div class="mb-3">
          <label for="remarks" class="form-label">Remarks</label>
          <textarea class="form-control" id="remarks" name="remarks">' . $row6['remarks'] . '</textarea>
        </div>
        <div class="mb-3">
        <label for="from" class="form-label">Estimated Completion (from)</label>
        <input type="date" class="form-control" id="from" name="from">
        <label for="to" class="form-label">Estimated Completion (to)</label>
        <input type="date" class="form-control" id="to" name="to">
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
  $transaction_code = htmlentities($_POST['transaction_code']);
  $status = htmlentities($_POST['status']); 
  $remarks = htmlentities($_POST['remarks']);
  $partqty = htmlentities($_POST['partqty']);
  $from = htmlentities($_POST['from']); 
  $to = htmlentities($_POST['to']); 

  $elec_id = // Get the elec_id from your data source
  $rprq_id = htmlentities($_SESSION['id']);
  $comrep = $_POST['comrep'];
  $parts = $_POST['parts'];

  // Insert data into rp_labor table
  foreach ($comrep as $comrep_id) {
    $sql = "INSERT INTO rp_labor (comrep_id, rprq_rl_id) VALUES ('$comrep_id', '$rprq_id')";
    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Insert data into rp_brand_parts table
foreach ($parts as $part) {
    $sql = "INSERT INTO rp_brand_parts (bp_id, rprq_id, quantity) VALUES ('$part', '$rprq_id', '$partqty')";
    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

  $query = "UPDATE rprq SET date_from = '$from', date_to = '$to', status = '$status', remarks = '$remarks' WHERE id = '$id'";

  $result = mysqli_query($conn, $query);


  if ($result) {
      $_SESSION['msg'] = "Record Updated Successfully";
      header("location: ../tech_repair/view-transaction.php?transaction_code=" . $transaction_code . "&rowid=" . $id);
  } else {
      echo "FAILED: " . mysqli_error($conn);
  }
}


?>

<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2({});
});
</script>