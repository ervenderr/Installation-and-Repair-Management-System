<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if (isset($_POST['id'])) {
    $output = '';
    $user_id = $_SESSION['logged_id'];
    $_SESSION['id'] = $_POST['id'];
    $query = "SELECT *
    FROM brand_parts bp
    LEFT JOIN elec_brand eb ON bp.eb_id = eb.eb_id
    LEFT JOIN electronics e ON bp.elec_id = e.elec_id
    LEFT JOIN elec_sub_categ esc ON bp.subcateg_id = esc.elec_sub_categ_id
    WHERE bp_id = '" . $_POST['id'] . "'";
$result = mysqli_query($conn, $query);
$parts = mysqli_fetch_assoc($result);
 // Fetch the data from the result set

    $output .= '
    <form method="POST" action="update-parts.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="partname" class="form-label">Part Name</label>
                            <input type="text" class="form-control" name="partname" id="partname" value="'. $parts['bp_name']. '">
                            <span class="error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="electronic" class="form-label">Electronic Type</label>
                            <select name="electronic" id="electronic" class="form-select">
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
                            <label for="subname" class="form-label">Subcategory</label>
                            <select name="subname" id="subname" class="form-select">
                                <option value="None">--- Select ---</option>';
                                $sql = "SELECT * FROM elec_sub_categ";
                                $elec_result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($elec_result)) {
                                    $selected = ($row['elec_sub_categ_id'] == $parts['elec_sub_categ_id']) ? 'selected' : '';
                                    $output .= "<option value='" . $row['elec_sub_categ_id'] . "' $selected>" . $row['subcateg_name'] . "</option>";
                                }
                                
    $output .= '      </select>
                            <span class="error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <select name="brand" id="brand" class="form-select">
                                <option value="None">--- Select ---</option>';
                                $sql = "SELECT * FROM elec_brand";
                                $brand_result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($brand_result)) {
                                    $selected = ($row['eb_id'] == $parts['eb_id']) ? 'selected' : '';
                                    $output .= "<option value='" . $row['eb_id'] . "' $selected>" . $row['eb_name'] . "</option>";
                                }
                                
    $output .= '      </select>
                            <span class="error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" id="price" value="'. $parts['bp_cost']. '">
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
    $partname = htmlentities($_POST['partname']);
    $electronic = htmlentities($_POST['electronic']);
    $subname = htmlentities($_POST['subname']);
    $brand = htmlentities($_POST['brand']);
    $price = htmlentities($_POST['price']);


    $query = "UPDATE brand_parts SET bp_name = '$partname', elec_id = '$electronic', subcateg_id = '$subname', eb_id = '$brand', bp_cost = '$price' WHERE bp_id = '$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: parts.php");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>