<?php
// accepted-pending.php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['sreq_id'])){
  $_SESSION['sreq_id'] = $_POST['sreq_id'];
  $query = "SELECT * FROM service_request WHERE sreq_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'i', $_POST['sreq_id']);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $inventory = mysqli_fetch_assoc($result);

  echo '
  <form method="POST" action="accept-pending.php" enctype="multipart/form-data" id="form">
      <input type="hidden" name="sreq_id" value="'.$_POST['sreq_id'].'">
      <div class="mb-3">
          <label for="tech" class="form-label">Technician<span class="required">*</span></label>
          <select class="form-select js-example-basic-multiple" id="tech" name="tech[]" multiple="multiple">';

              $sql = "SELECT * FROM technician WHERE status = 'Active'";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='" . $row["tech_id"] . "'>" . $row['fname'] . '  ' . $row['lname'] . "</option>";
                  }
              }

  echo '
          </select>
          <span class="error"></span>
      </div>
      <div class="mb-3 ">
        <label for="days" class="form-label">Estimated Completion </label>
        <span>(day)</span>
        <input type="number" class="form-control" id="days" name="days" value="' . $row6['date_day'] . '" pattern="[0-9]*">
        <span class="error"></span>
      </div>
      <div class="mb-3">
      <label for="start" class="form-label">Start of Service<span class="required">*</span></label>
      <input type="date" min="'. date('Y-m-d').'" class="form-control" id="start" name="start">
      <span class="error"></span>
      </div>
      <button name="submit" type="submit" class="btn btn-danger mb-3">Accept</button>
  </form>';
}


if (isset($_POST['submit'])) {
    $id = htmlentities($_SESSION['sreq_id']);
    $techIds = $_POST['tech'];
    $days = htmlentities($_POST['days']);
    $start = htmlentities($_POST['start']);
    $status = "In-progress";

    // Update the service_request table
    $query = "UPDATE service_request SET dat_date = ?, date_from = ?, status = ? WHERE sreq_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'issi', $days, $start, $status, $id);
    mysqli_stmt_execute($stmt);

    // Remove any existing technicians assigned to this service request
    $delete_query = "DELETE FROM service_request_technicians WHERE sreq_id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($delete_stmt, 'i', $id);
    mysqli_stmt_execute($delete_stmt);

    foreach ($techIds as $techId) {
        $insert_query = "INSERT INTO service_request_technicians (sreq_id, tech_id) VALUES (?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, 'ii', $id, $techId);
        mysqli_stmt_execute($insert_stmt);

        
    }
    $newly_inserted_id = mysqli_insert_id($conn);
    $tquery = "INSERT INTO sr_timeline (sreq_id, tm_date, tm_time, tm_status) VALUES ('$id', NOW(), NOW(), '$status');";
    $tresult = mysqli_query($conn, $tquery);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: transactions.php");
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
        if ($.trim($('#tech').val()) == '' || $.trim($('#start').val()) == '' || $.trim($('#days')
                .val()) == '') {
            event.preventDefault();
            $('.error').empty(); // Clear any previous error messages
            if ($.trim($('#tech').val()) == '') {
                $('#tech').siblings('.error').text('Technician field is required.');
            }
            if ($.trim($('#start').val()) == '') {
                $('#start').siblings('.error').text('Start of Service field is required.');
            }
            if ($.trim($('#days').val()) == '') {
                $('#days').siblings('.error').text('Estimated Completion field is required.');
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