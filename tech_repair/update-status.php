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
  <form method="POST" action="update-status.php" enctype="multipart/form-data" id="form">';

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
    <div class="mb-3">
    <label for="comrep" class="form-label">Repair/Replacement Needed<span class="required">*</span></label>
    <select class="form-select js-example-basic-multiple" id="comrep" name="comrep[]" multiple="multiple">';

    // Get the selected common repairs
$selected_comrep_query = "SELECT comrep_id FROM rp_labor WHERE rprq_rl_id = ?";
$selected_comrep_stmt = mysqli_prepare($conn, $selected_comrep_query);
mysqli_stmt_bind_param($selected_comrep_stmt, 'i', $_POST['id']);
mysqli_stmt_execute($selected_comrep_stmt);
$selected_comrep_result = mysqli_stmt_get_result($selected_comrep_stmt);

$selected_comrep_ids = array();
while ($selected_comrep = mysqli_fetch_assoc($selected_comrep_result)) {
    $selected_comrep_ids[] = $selected_comrep['comrep_id'];
}

$sql = "SELECT * FROM common_repairs 
LEFT JOIN brand_parts ON common_repairs.brand_parts = brand_parts.bp_id
WHERE common_repairs.elec_id = $elec_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $selected = in_array($row["comrep_id"], $selected_comrep_ids) ? 'selected' : '';
    $output .= "<option value='" . $row["comrep_id"] . "' data-brand-part-id='" . $row["bp_id"] . "' data-brand-part-name='" . $row["bp_name"] . "' $selected>" . $row['comrep_name'] . "</option>";
}
}
    $output .= '
        </select>
        <span class="error"></span>
    </div>

    <div class="card">
    <div class="card-body partsbody">
      <div class="row mb-3 ">
      <div class="col-7 partscol">
          <label for="parts" class="form-label">Parts Needed<span class="required">*</span></label>
      </div>
      <div class="col-3 partscol">
      <td><input type="button" value="+" class="btn btn-primary btn-sm" id="btn-add-row">
            </td>
      </div>
      <div class="col-2 partscolx">
      
      </div>
      </div>
      </div>
      </div>
      <div class="row">
      <div class="col-6">
      <div class="mb-3 ">
        <label for="days" class="form-label">Estimated Completion </label>
        <span>(day)</span>
        <input type="number" class="form-control" id="days" name="days" min="1" value="1">
        <span class="error"></span>
      </div>
      </div>
      
      </div>
      </div>
      <div class="mb-3">
          <label for="remarks" class="form-label">Remarks</label>
          <textarea class="form-control" id="remarks" name="remarks">' . $row6['remarks'] . '</textarea>
          <span class="error"></span>
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
  $days = htmlentities($_POST['days']); 

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

$lquery = "SELECT *
    FROM rprq
    INNER JOIN customer ON rprq.Cust_id = customer.Cust_id
    INNER JOIN rp_labor ON rprq.id = rp_labor.rprq_rl_id
    INNER JOIN common_repairs ON rp_labor.comrep_id = common_repairs.comrep_id
    WHERE rprq.id = $id";
$lresult = mysqli_query($conn, $lquery);

$labor_subtotal = 0;

while ($lrow = mysqli_fetch_assoc($lresult)) {
    $labor_subtotal += $lrow['comrep_cost'];
}

$lquery = "SELECT *
FROM rprq
INNER JOIN customer ON rprq.Cust_id = customer.Cust_id
INNER JOIN rp_brand_parts ON rprq.id = rp_brand_parts.rprq_id
INNER JOIN brand_parts ON rp_brand_parts.bp_id = brand_parts.bp_id
WHERE rprq.id = $id";
$lresult = mysqli_query($conn, $lquery);
$part_subtotal = 0;

while ($lrow = mysqli_fetch_assoc($lresult)) {
    $partqty  = $lrow['bp_cost'] * $lrow['quantity'];
    $part_subtotal += $partqty;
}

$grand_total = $part_subtotal + $labor_subtotal;

  $query = "UPDATE rprq SET payment = '$grand_total', date_day = '$days', status = '$status', remarks = '$remarks' WHERE id = '$id'";
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

<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2({});

    // Add row function
    function addRow(brandPartId, brandPartName) {
        let newRow = `
        <div class="row mb-3 parts-row">
            <div class="col-7 partscol">
                <select class="form-select" name="parts[]">
                    <option value="${brandPartId}" selected>${brandPartName}</option>
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
    }

    // Listen for common repairs change
    $('#comrep').on('change', function() {
        $('.parts-row').remove(); // Remove all existing rows
        let selectedComrep = $(this).val();
        if (selectedComrep.length > 0) {
            $.each(selectedComrep, function(index, comrep_id) {
                let brandPartId = $("option[value='" + comrep_id + "']").data('brand-part-id');
                let brandPartName = $("option[value='" + comrep_id + "']").data(
                    'brand-part-name');
                if (brandPartId && brandPartName) {
                    addRow(brandPartId, brandPartName);
                }
            });
        }
    });

    // Add row
    $('#btn-add-row').on('click', function() {
        let newRow = `
      <div class="row mb-3 parts-row">
        <div class="col-7 partscol">
          <select class="form-select" name="parts[]">
          <option value="None">--- Select ---</option>
<?php
$sql = "SELECT * FROM brand_parts WHERE eb_id = $eb_id";
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
    $('.partsbody').on('click', '.btn-row-remove', function() {
        $(this).closest('.parts-row').remove();
    });

    $('#form').submit(function(event) {
        // Check if the form inputs are not empty
        if ($.trim($('#comrep').val()) == '' || $.trim($('#remarks').val()) == '' || $.trim($('#days')
                .val()) == '') {
            event.preventDefault();
            $('.error').empty(); // Clear any previous error messages
            if ($.trim($('#comrep').val()) == '') {
                $('#comrep').siblings('.error').text('This field is required.');
            }
            if ($.trim($('#remarks').val()) == '') {
                $('#remarks').siblings('.error').text('Start of Service field is required.');
            }
            if ($.trim($('#days').val()) == '') {
                $('#days').siblings('.error').text('This field is required..');
            }
        }

        // Validate number input for Estimated Completion field
        if (!$.isNumeric($('#days').val())) {
            event.preventDefault();
            $('#days').siblings('.error').text('Estimated Completion must be a number.');
        }
    });
});
</script>