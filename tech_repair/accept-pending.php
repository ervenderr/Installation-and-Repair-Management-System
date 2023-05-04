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
    $_SESSION['transaction_code'] = $inventory['transaction_code'];

    $output .= '
    <form method="POST" action="accept-pending.php" enctype="multipart/form-data" onsubmit="return checkLimit()">';

            // Query the supplier table
            $sql = "SELECT * 
            FROM technician 
            INNER JOIN accounts ON technician.account_id = accounts.account_id
            WHERE status = 'Active' AND accounts.account_id = '$user_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $_SESSION['tech_ids'] = $row['tech_id'];
            $_SESSION['set_limit'] = $row['set_limit'];
            $_SESSION['limit_per_day'] = $row['limit_per_day'];

    $output .= '
          <div class="modal-footer">
          <input name="tech_id" type="hidden" id="tech" class="btn btn-danger" value="'. $row["tech_id"] .'" data-limit="'.$row["set_limit"].'"/>
          <input name="tech_id2" type="hidden" id="tech2" class="btn btn-danger" value="'. $row["tech_id"] .'" data-limits="'.$row["limit_per_day"].'"/>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <input name="submit" type="submit" class="btn btn-danger" value="Accept"/>
          </div>
    </form>
    <script>
        function checkLimit() {
            var techSelect = document.getElementById("tech");
            var techSelect2 = document.getElementById("tech2");

            var limitPerDay = techSelect.dataset.limit;
            var limitPerDay2 = techSelect2.dataset.limit;

            if (limitPerDay >= limitPerDay2) {
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
    $transaction_code = htmlentities($_SESSION['transaction_code']);
    $tech_ids = htmlentities($_SESSION['tech_ids']);
    $techId = htmlentities($_POST['tech_id']);
    $payment = htmlentities($_POST['payment']);
    $completed = htmlentities($_POST['completed']);
    $status = "Diagnosing";


    $query = "UPDATE rprq SET tech_id = '$techId', status = '$status' WHERE id = '$id'";
    $tquery = "INSERT INTO rp_timeline (rprq_id, tm_date, tm_time, tm_status) VALUES ('$id', NOW(), NOW(), '$status');";
    $techquery = "UPDATE technician SET set_limit = set_limit + 1 WHERE tech_id = '$tech_ids'";


    $result = mysqli_query($conn, $query);
    $tresult = mysqli_query($conn, $tquery);
    $techresult = mysqli_query($conn, $techquery);

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: view-transaction.php?transaction_code=" . $transaction_code . "&rowid=" . $id);
    }else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>

<script>
function checkLimit() {
    var limit = "<?php echo $_SESSION['limit_per_day']; ?>";
    var set_limit = "<?php echo $_SESSION['set_limit']; ?>";
    if (limit >= set_limit) {
        if(confirm("You have reached your daily limit. Are you sure you still want to accept this request?")) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}
</script>

