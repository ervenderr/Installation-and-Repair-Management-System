<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if(isset($_POST['id'])){
    $output = '';
    $_SESSION['id'] = $_POST['id'];
    $query = "SELECT * FROM rprq WHERE id = '".$_POST['id']."'";
    $result = mysqli_query($conn, $query);
    $inventory = mysqli_fetch_assoc($result);
    $selected_technician_id = $inventory['tech_id'];

    $output .= '
    <form method="POST" action="accept-pending.php" enctype="multipart/form-data" onsubmit="return checkLimit()">
          <div class="mb-3">
            <label for="tech" class="form-label">Technician</label>
            <select class="form-select" id="tech" name="tech">
                <option value="None">--- select ---</option>';

            // Query the supplier table
            $sql = "SELECT * FROM technician WHERE status = 'Active'";
            $result2 = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result2) > 0) {
                while ($technician = mysqli_fetch_assoc($result2)) {
                    $tech_id = mysqli_real_escape_string($conn, $technician['tech_id']);
                    $selected = ($tech_id == $selected_technician_id) ? "selected" : "";
                    $output .= "<option value='{$tech_id}' data-limit='" . $technician["limit_per_day"] . "' {$selected}>{$technician['fname']} {$technician['lname']}</option>";
                } 
              }

    $output .= '
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <input name="submit" type="submit" class="btn btn-danger" value="Accept"/>
          </div>
    </form>
    <script>

    function checkLimit() {
        var techSelect = document.getElementById("tech");
        var selectedOption = techSelect.options[techSelect.selectedIndex];
        var limitPerDay = selectedOption.dataset.limit;
      
        if (limitPerDay == 0) {
          var confirmation = confirm("This technician has reached their daily limit. Are you sure you want to assign this technician?");
          if (!confirmation) {
            return false;
          }
        }
        return true;
      }
      
    </script>';

    echo $output;
}


if(isset($_POST['submit'])) {
    $id = htmlentities($_SESSION['id']);
    $techId = htmlentities($_POST['tech']);
    $status = "Diagnosing";


    $query = "UPDATE rprq SET tech_id = '$techId', status = '$status' WHERE id = '$id'";
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