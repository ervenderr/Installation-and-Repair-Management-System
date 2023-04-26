<!-- parts -->
<div class="modal fade" id="viewModal">
    <div class="modal-dialog sermodals">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartsModalLabel">View Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body viewmodals">
            </div>
        </div>
    </div>
</div>

<div class="modal fade " id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog sermodals">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Update Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body viewmodals">

            </div>
        </div>
    </div>
</div>


<!-- electronics -->
<div class="modal fade " id="addelectronicModal" tabindex="-1" aria-labelledby="addelectronicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addelectronicModalLabel">Create New</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="add-electronics.php" enctype="multipart/form-data"
                    onsubmit="return validateFormTwo()">
                    <div class="mb-3">
                        <label for="elecname" class="form-label">Electronic Name</label>
                        <input type="text" class="form-control" name="elecname" id="elecname">
                        <span class="error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="warranty" class="form-label">Warranty</label>
                        <div class="d-flex">
                            <input type="number" min="1" class="form-control me-2" name="warranty_number"
                                id="warranty_number" placeholder="Number">
                            <span class="error"></span>
                            <select class="form-select" name="warranty_unit" id="warranty_unit">
                                <option value="day">Day(s)</option>
                                <option value="week">Week(s)</option>
                                <option value="month">Month(s)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brands</label>
                        <select name="brands[]" id="brands" class="form-select js-example-basic-multiple" multiple="multiple">
                            <?php
                                $sql = "SELECT * FROM elec_brand";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['eb_id'] . "'>" . $row['eb_name'] . "</option>";
                                }
                            ?>
                        </select>
                        <span class="error"></span>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <input name="submit" type="submit" class="btn btn-danger" value="Submit" />
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade " id="editelectronicsModal" tabindex="-1" aria-labelledby="editelectronicsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editelectronicsModalLabel">Update Electronic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body elecbody">

            </div>
        </div>
    </div>
</div>

<!-- brands -->
<div class="modal fade " id="addeBrandModal" tabindex="-1" aria-labelledby="addeBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addeBrandModalLabel">Create New</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="POST" action="add-brand.php" enctype="multipart/form-data"
                    onsubmit="return validateFormThree()">
                    <div class="mb-3">
                        <label for="brandname" class="form-label">Brand Name</label>
                        <input type="text" class="form-control" name="brandname" id="brandname">
                        <span class="error"></span>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <input name="submit" type="submit" class="btn btn-danger" value="Submit" />
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade " id="editbrandsModal" tabindex="-1" aria-labelledby="editbrandsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editbrandsModalLabel">Update Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body brandbody">

            </div>
        </div>
    </div>
</div>