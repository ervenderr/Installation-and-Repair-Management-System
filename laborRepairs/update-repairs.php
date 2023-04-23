<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if (isset($_POST['id'])) {
    $output = '';
    $user_id = $_SESSION['logged_id'];
    $_SESSION['id'] = $_POST['id'];
    $query = "SELECT * FROM common_repairs
    LEFT JOIN brand_parts ON common_repairs.brand_parts = brand_parts.bp_id
    LEFT JOIN electronics ON common_repairs.elec_id = electronics.elec_id
    WHERE comrep_id = '" . $_POST['id'] . "'";
    $result = mysqli_query($conn, $query);
    $parts = mysqli_fetch_assoc($result); // Fetch the data from the result set

    $output .= '
    <form method="POST" action="update-repairs.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="repairname" class="form-label">Repair Service Name</label>
                            <input type="text" class="form-control" name="repairname" id="repairname" value="'. $parts['comrep_name']. '">
                            <span class="error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="electronic" class="form-label">Electronic Type</label>
                            <select name="electronic_type" id="electronic_type" class="form-select">
                                <option value="None">--- Select ---</option>';
                                $sql = "SELECT * FROM electronics";
                                $elec_result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($elec_result)) {
                                    $selected = ($row['elec_id'] == $parts['elec_id']) ? 'selected' : '';
                                    $output .= "<option value='" . $row['elec_id'] . "' $selected>" . $row['elec_name'] . "</option>";
                                }
                                
    $output .= '      </select>
                            <span class="error"></span>
                        </div>
                        <div class="mb-3">
    <label for="electronic_part" class="form-label">Electronic Part</label>
    <select name="electronic_part" id="electronic_part" class="form-select">
        <option value="None">--- Select ---</option>';

        $sql = "SELECT DISTINCT bp_name, bp_id FROM brand_parts WHERE elec_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $parts['elec_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $selected = ($row['bp_id'] == $parts['brand_parts']) ? 'selected' : '';
            $output .= "<option value='" . $row['bp_id'] . "' $selected>" . $row['bp_name'] . "</option>";
        }
                                
    $output .= '  </select>
    <span class="error"></span>
</div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" id="price" value="'. $parts['comrep_cost']. '">
                            <span class="error"></span>
                        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <input name="submit" type="submit" class="btn btn-danger" value="Update"/>
          </div>
    </form>';

    echo $output;
}



if(isset($_POST['submit'])) {
    $id = htmlentities($_SESSION['id']);
    $repairname = htmlentities($_POST['repairname']);
    $electronic = htmlentities($_POST['electronic_type']);
    $electronic_part = htmlentities($_POST['electronic_part']);
    $price = htmlentities($_POST['price']);


    $query = "UPDATE common_repairs SET comrep_name = '$repairname', elec_id = '$electronic', brand_parts = '$electronic_part', comrep_cost = '$price' WHERE comrep_id = '$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: repairs.php");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>