<?php
session_start();

require_once '../homeIncludes/dbconfig.php';


if (isset($_POST['id'])) {
    $output = '';
    $user_id = $_SESSION['logged_id'];
    $_SESSION['id'] = $_POST['id'];
    $query = "SELECT * FROM brand_electronics
    LEFT JOIN electronics ON brand_electronics.electronic_id = electronics.elec_id
    LEFT JOIN elec_brand ON brand_electronics.brand_id = elec_brand.eb_id
    WHERE elec_id = '" . $_POST['id'] . "'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $selected_warranty_unit = $row['warranty_unit'];

    $selected_brands_query = "SELECT brand_id FROM brand_electronics WHERE electronic_id = ?";
    $selected_brands_stmt = mysqli_prepare($conn, $selected_brands_query);
    mysqli_stmt_bind_param($selected_brands_stmt, 'i', $_POST['id']);
    mysqli_stmt_execute($selected_brands_stmt);
    $selected_brands_result = mysqli_stmt_get_result($selected_brands_stmt);

    $selected_brands = [];
    while ($selected_brand = mysqli_fetch_assoc($selected_brands_result)) {
        $selected_brands[] = $selected_brand['brand_id'];
    }

    $output .= '
    <form method="POST" action="update-electronics.php" enctype="multipart/form-data">
                        <div class="mb-3">
                        <label for="elecname" class="form-label">Electronic Name</label>
                        <input type="text" class="form-control" name="elecname" id="elecnameUpdate" value="'. $row['elec_name'] .'">
                        <span class="error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="warranty" class="form-label">Warranty</label>
                        <div class="d-flex">
                            <input type="number" min="1" class="form-control me-2" name="warranty_number"
                                id="warranty_numberUpdate" value="'. $row['warranty_num'] .'">
                            <span class="error"></span>
                            <select class="form-select" name="warranty_unit" id="warranty_unit">
                                <option value="day(s)" ' . ($selected_warranty_unit == "day(s)" ? "selected" : "") . '>Day(s)</option>
                                <option value="week(s)" ' . ($selected_warranty_unit == "week(s)" ? "selected" : "") . '>Week(s)</option>
                                <option value="month(s)" ' . ($selected_warranty_unit == "month(s)" ? "selected" : "") . '>Month(s)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brands</label>
                        <select name="brands[]" id="brandsUpdate" class="form-select js-example-basic-multiple" multiple="multiple">';
                        $sql = "SELECT * FROM elec_brand";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $isSelected = in_array($row['eb_id'], $selected_brands) ? "selected" : "";
                            $output .= '<option value="' . $row['eb_id'] . '" ' . $isSelected . '>' . $row['eb_name'] . '</option>';
                        }
                                $output .= '
                        </select>
                        <span class="error"></span>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <input name="submit" type="submit" class="btn btn-danger" value="Submit" />
                    </div>
                </form>';

    echo $output;
}



if (isset($_POST['submit'])) {
    $id = htmlentities($_SESSION['id']);
    $elecname = htmlentities($_POST['elecname']);
    $warranty_number = htmlentities($_POST['warranty_number']);
    $warranty_unit = htmlentities($_POST['warranty_unit']);
    $brands = $_POST['brands'];

    $query = "UPDATE electronics SET elec_name = '$elecname', warranty_num = '$warranty_number', warranty_unit = '$warranty_unit' WHERE elec_id = '$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Delete old associations
        $delete_associations_query = "DELETE FROM brand_electronics WHERE electronic_id = ?";
        $delete_associations_stmt = mysqli_prepare($conn, $delete_associations_query);
        mysqli_stmt_bind_param($delete_associations_stmt, 'i', $id);
        mysqli_stmt_execute($delete_associations_stmt);

        // Insert new associations
        foreach ($brands as $brand_id) {
            $association_query = "INSERT INTO brand_electronics (electronic_id, brand_id) VALUES ('$id', '$brand_id')";
            mysqli_query($conn, $association_query);
        }

        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: parts.php");
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