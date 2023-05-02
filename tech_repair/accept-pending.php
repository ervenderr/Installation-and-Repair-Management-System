<?php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['id'])){
    $output = '';
    $user_id = $_SESSION['logged_id'];
    $_SESSION['id'] = $_POST['id'];
    $query = "SELECT * FROM rprq WHERE id = '".$_POST['id']."'";
    $result = mysqli_query($conn, $query);
    $inventory = mysqli_fetch_assoc($result); // Fetch the data from the result set

    $output .= '
    <form method="POST" action="#" enctype="multipart/form-data" onsubmit="return checkLimit()">';

            // Query the supplier table
            $sql = "SELECT * 
            FROM technician 
            INNER JOIN accounts ON technician.account_id = accounts.account_id
            WHERE status = 'Active' AND accounts.account_id = '$user_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

    $output .= '
          <div class="modal-footer">
          <input name="tech_id" type="hidden" id="tech" class="btn btn-danger" value="'. $row["tech_id"] .'" data-limit="'.$row["limit_per_day"].'"/>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <input name="submit" type="submit" class="btn btn-danger" value="Accept"/>
          </div>
    </form>
    <script>
        function checkLimit() {
            var techSelect = document.getElementById("tech");
            var limitPerDay = techSelect.dataset.limit;

            if (limitPerDay == 0) {
              var confirmation = confirm("You have reached your daily limit. Are you sure you still want to accept this request?");
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
    $payment = htmlentities($_POST['payment']);
    $completed = htmlentities($_POST['completed']);
    $status = "Diagnosing";


    $query = "UPDATE rprq SET tech_id = '$techId', status = '$status' WHERE id = '$id'";
    $tquery = "INSERT INTO rp_timeline (rprq_id, tm_date, tm_time, tm_status) VALUES ('$id', NOW(), NOW(), '$status');";

    $result = mysqli_query($conn, $query);
    $tresult = mysqli_query($conn, $tquery);

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: transaction.php");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>

<script>
function checkLimit() {
    var limit = "<?php echo $inventory['limit_per_day']; ?>";
    if (limit == 0) {
        if(confirm("Are you sure you want to accept this request?")) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}
</script>