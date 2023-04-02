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
  <form method="POST" action="update-status.php" enctype="multipart/form-data">';

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
  elec_brand.*,
  electronics.*,
  rp_brand_parts.*,
  brand_parts.*,
  defects.*,
  invoice.*,
  customer.*
  FROM rprq
  LEFT JOIN technician ON rprq.tech_id = technician.tech_id
  LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
  LEFT JOIN elec_brand ON electronics.elec_id = elec_brand.elec_id
  LEFT JOIN brand_parts ON elec_brand.eb_id = brand_parts.eb_id
  LEFT JOIN rp_brand_parts ON brand_parts.bp_id = rp_brand_parts.bp_id
  LEFT JOIN defects ON rprq.defect_id = defects.defect_id
  LEFT JOIN customer ON rprq.cust_id = customer.cust_id
  LEFT JOIN accounts ON customer.account_id = accounts.account_id
  LEFT JOIN invoice ON rprq.id = invoice.rprq_id
        WHERE rprq.id = '" . $_POST['id'] . "';";
  $result6 = mysqli_query($conn, $query6);

  // Check if the query was successful and output the data
  if (mysqli_num_rows($result6) > 0) {
      $row6 = mysqli_fetch_assoc($result6);
  }
 $elec_id = $row6['elec_id'];


  $output .= '
    <div class="mb-3">
    <label for="comrep" class="form-label">Repair/Replacement Needed<span class="required">*</span></label>
    <select class="form-select js-example-basic-multiple" id="comrep" name="comrep[]" multiple="multiple">';

    // Get the selected common repairs
$selected_comrep_query = "SELECT comrep_id FROM rp_labor WHERE rprq_rl_id = ?";
$selected_comrep_stmt = mysqli_prepare($conn, $selected_comrep_query);
mysqli_stmt_bind_param($selected_comrep_stmt, 'i', $_POST['id']); // Assuming $_POST['id'] is the rprq ID you want to check
mysqli_stmt_execute($selected_comrep_stmt);
$selected_comrep_result = mysqli_stmt_get_result($selected_comrep_stmt);

$selected_comrep_ids = array();
while ($selected_comrep = mysqli_fetch_assoc($selected_comrep_result)) {
    $selected_comrep_ids[] = $selected_comrep['comrep_id'];
}

$sql = "SELECT * FROM common_repairs WHERE elec_id = $elec_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $selected = in_array($row["comrep_id"], $selected_comrep_ids) ? 'selected' : '';
        $output .= "<option value='" . $row["comrep_id"] . "' $selected>" . $row['comrep_name'] . "</option>";
    }
}
    $output .= '
        </select>
    </div>

    <div class="card">
    <div class="card-body partsbody">
      <div class="row mb-3 ">
      <div class="col-7 partscol">
          <label for="parts" class="form-label">Parts Needed<span class="required">*</span></label>
          <select class="form-select" id="parts" name="parts[]">
          <option value="None">--- Select ---</option>';
          
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
      <div class="col-3 partscol">
      <label for="partqty" class="form-label">Quantity</label>
      <input type="number" class="form-control" id="partqty" name="partqty" value="">
      </div>
      <div class="col-2 partscolx">
      <td><input type="button" value="+" class="btn btn-primary btn-sm partscolxx" id="btn-add-row">
            </td>
      </div>
      </div>
      </div>
      </div>
      <div class="row">
      <div class="col-6">
      <div class="mb-3">
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
      <div class="mb-3">
          <label for="remarks" class="form-label">Remarks</label>
          <textarea class="form-control" id="remarks" name="remarks">' . $row6['remarks'] . '</textarea>
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
  $status = htmlentities('In-progress'); 
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

// Calculate rp_labor grandtotal
$rp_labor_total = 0;
foreach ($comrep as $comrep_id) {
    $sql = "SELECT comrep_cost FROM common_repairs WHERE comrep_id = '$comrep_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $rp_labor_total += $row['labor_rate'];
}

// Calculate rp_brand_parts grandtotal
$rp_brand_parts_total = 0;
foreach ($parts as $part) {
    $sql = "SELECT bp_cost FROM brand_parts WHERE bp_id = '$part'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $rp_brand_parts_total += ($row['price'] * $partqty);
}

// Calculate the grandtotal
$grandtotal = $rp_labor_total + $rp_brand_parts_total;
$invquery = "INSERT INTO invoice (rprq_id, invoice_number, grand_total) VALUES ('$id', '$rp_labor_total', '$rp_brand_parts_total')";


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

    // Add row
  $('#btn-add-row').on('click', function () {
    let newRow = `
      <div class="row mb-3 parts-row">
        <div class="col-7 partscol">
          <select class="form-select" name="parts[]">
          <option value="None">--- Select ---</option>
<?php
$sql = "SELECT * FROM brand_parts WHERE eb_id = $elec_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row["bp_id"] . "'>" . $row['bp_name'] ."</option>";
  }
}
?>
          </select>
        </div>
        <div class="col-3 partscol">
          <input type="number" class="form-control partscols" id="partqty" name="partqty" value="1">
        </div>
        <div class="col-2 partscolx">
          <input type="button" value="x" class="btn btn-danger btn-sm btn-row-remove">
        </div>
      </div>
    `;

    $('.partsbody').append(newRow);
  });

  // Remove row
  $('.partsbody').on('click', '.btn-row-remove', function () {
    $(this).closest('.parts-row').remove();
  });
});


</script>
