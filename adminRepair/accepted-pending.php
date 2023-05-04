<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if (isset($_POST['id'])) {
  $output = '';
  $_SESSION['id'] = $_POST['id'];
  $id = $_POST['id'];

  // Labor Subtotal Query
  $lquery = "SELECT SUM(common_repairs.comrep_cost) as labor_subtotal
      FROM rprq
      INNER JOIN rp_labor ON rprq.id = rp_labor.rprq_rl_id
      INNER JOIN common_repairs ON rp_labor.comrep_id = common_repairs.comrep_id
      WHERE rprq.id = $id";

  $lresult = mysqli_query($conn, $lquery);
  $lrow = mysqli_fetch_assoc($lresult);
  $labor_subtotal = $lrow['labor_subtotal'];

  // Part Subtotal Query
  $pquery = "SELECT SUM(brand_parts.bp_cost * rp_brand_parts.quantity) as part_subtotal
      FROM rprq
      INNER JOIN rp_brand_parts ON rprq.id = rp_brand_parts.rprq_id
      INNER JOIN brand_parts ON rp_brand_parts.bp_id = brand_parts.bp_id
      WHERE rprq.id = $id";

  $presult = mysqli_query($conn, $pquery);
  $prow = mysqli_fetch_assoc($presult);
  $part_subtotal = $prow['part_subtotal'];

  $grand_total = $part_subtotal + $labor_subtotal;
  $half_grand_total = $grand_total / 2;

  $output .= '
  <form method="POST" action="accepted-pending.php" enctype="multipart/form-data" id="form">
        <input type="type" class="form-control" id="status" name="status" value="For repair" hidden>
        <div class="mb-3">
          <label for="initpay" class="form-label">Initial Payment</label>
          <input type="number" class="form-control" id="days" name="initpay" value="'. $half_grand_total.'" step="0.01" min="0">
          <span class="error"></span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <input name="submit" type="submit" class="btn btn-success" value="Update"/>
        </div>
  </form>';

  echo $output;
}

if(isset($_POST['submit'])) {
    $id = htmlentities($_SESSION['id']);
    $initpay = htmlentities($_POST['initpay']);
    $status = htmlentities($_POST['status']);


    $query = "UPDATE rprq SET status = '$status', initial_payment = '$initpay' WHERE id = '$id'";
    $tquery = "INSERT INTO rp_timeline (rprq_id, tm_date, tm_time, tm_status) VALUES ('$id', NOW(), NOW(), '$status');";

    $result = mysqli_query($conn, $query);
    $tresult = mysqli_query($conn, $tquery);
    

    if ($result) {
      $_SESSION['msg'] = "Record Updated Successfully";
      header("location: view-transaction.php?rowid=" . $id . "");
  } else {
      echo "FAILED: " . mysqli_error($conn);
  }
}

?>

<script>
$(document).ready(function() {
  $('.js-example-basic-multiple').select2({});

    $('#days').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numbers
    });

    $('#form').submit(function(event) {
        // Check if the form inputs are not empty
        if ($.trim($('#days').val()) == '') {
            event.preventDefault();
            $('.error').empty(); // Clear any previous error messages
            
            if ($.trim($('#days').val()) == '') {
                $('#days').siblings('.error').text('This field is required.');
            }
        }
    });
});
</script>