<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if (isset($_POST['id'])) {
    $output = '';
    $user_id = $_SESSION['logged_id'];
    $_SESSION['id'] = $_POST['id'];
    $query = "SELECT * FROM elec_sub_categ
    INNER JOIN electronics ON electronics.elec_id = elec_sub_categ.elec_id
    WHERE elec_sub_categ_id = '" . $_POST['id'] . "'";
    $result = mysqli_query($conn, $query);
    $parts = mysqli_fetch_assoc($result); 

    $output .= '
    <form method="POST" action="update-categ.php" enctype="multipart/form-data" id="form" class="form-sample">
                        <div class="mb-3">
                            <label for="electronic_type" class="form-label">Electronic Type</label>
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
                            <label for="subname" class="form-label">SubCategory Name</label>
                            <input type="type" class="form-control" name="subname" id="subname" value="'. $parts['subcateg_name']. '">
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
    $subname = htmlentities($_POST['subname']);
    $electronic_type = htmlentities($_POST['electronic_type']);


    $query = "UPDATE elec_sub_categ SET subcateg_name = '$subname', elec_id = '$electronic_type' WHERE elec_sub_categ_id = '$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: sub-category.php");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>

<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2({});
    
    $('#form').submit(function(event) {
        // Check if the form inputs are not empty
        if ($.trim($('#subname').val()) == '' || $.trim($('#electronic_type').val()) == 'None') {
            event.preventDefault();

            $('.error').empty(); // Clear any previous error messages
            if ($.trim($('#subname').val()) == '') {
                $('#subname').siblings('.error').text('This field is required.');
            }
            if ($.trim($('#electronic_type').val()) == 'None') {
                $('#electronic_type').siblings('.error').text('Start of Service field is required.');
            }
        }
    });
});
</script>