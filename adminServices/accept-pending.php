<?php
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
  <form method="POST" action="accept-pending.php" enctype="multipart/form-data">
      <input type="hidden" name="sreq_id" value="'.$_POST['sreq_id'].'">
      <div class="mb-3">
          <label for="tech" class="form-label">Technician<span class="required">*</span></label>
          <select class="form-select js-example-basic-multiple" id="tech" name="tech[]" multiple="multiple" required>
              <option value="">--- select ---</option>';

              $sql = "SELECT * FROM technician WHERE status = 'Active'";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='" . $row["tech_id"] . "'>" . $row['fname'] . '  ' . $row['lname'] . "</option>";
                  }
              }

  echo '
          </select>
          <div class="invalid-feedback">
              Please select at least one technician.
          </div>
      </div>
      <div class="mb-3">
          <label for="payment" class="form-label">Initial Payment<span class="required">*</span></label>
          <input type="number" class="form-control" id="payment" name="payment" min="0" required>
          <div class="invalid-feedback">
              Please enter a valid payment amount.
          </div>
      </div>
      <div class="mb-3">
          <label for="completed" class="form-label">Expected Completion<span class="required">*</span></label>
          <input type="date" class="form-control" id="completed" name="completed" required>
          <div class="invalid-feedback">
              Please enter a valid date.
          </div>
      </div>
      <button name="submit" type="submit" class="btn btn-danger mb-3">Accept</button>
  </form>';
}


if(isset($_POST['submit'])) {
    $id = htmlentities($_SESSION['sreq_id']);
    $techId = htmlentities($_POST['tech']);
    $completed = htmlentities($_POST['completed']);
    $payment = htmlentities($_POST['payment']);
    $status = "In-progress";


    $query = "UPDATE service_request SET tech_id = '$techId', payment = '$payment', date_completed = '$completed', status = '$status' WHERE sreq_id = '$id'";

    $result = mysqli_query($conn, $query);
    

    if ($result) {
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
        });
    </script>