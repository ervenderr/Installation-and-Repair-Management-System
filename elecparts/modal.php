<!-- parts -->
<div class="modal fade " id="addPartsModal" tabindex="-1" aria-labelledby="addPartsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPartsModalLabel">Create New</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="add-parts.php" enctype="multipart/form-data" class="form-sample">
                    <div class="mb-3">
                        <label for="partname" class="form-label">Part Name</label>
                        <input type="text" class="form-control" name="partname" id="partname">
                        <span class="error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="electronic_type" class="form-label">Electronic Type</label>
                        <select name="electronic_type" id="electronic_type" class="form-select">
                            <option value="None">--- Select ---</option>
                            <?php
                                $sql = "SELECT * FROM electronics";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['elec_id'] . "'>" . $row['elec_name'] . "</option>";
                                }
                                ?>
                        </select>
                        <span class="error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="categname" class="form-label">Subcategory</label>
                        <select name="categname" id="categname" class="form-select">
                            <option value="None">--- Select ---</option>
                            
                        </select>
                        <span class="error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="electronic_brand" class="form-label">Electronic Brand</label>
                        <select name="electronic_brand" id="electronic_brand" class="form-select">
                            <option value="None">--- Select ---</option>
                            
                        </select>
                        <span class="error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" id="price">
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

<div class="modal fade " id="editPartsModal" tabindex="-1" aria-labelledby="editPartsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartsModalLabel">Update Parts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body suppbody">

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

<!-- subcategory -->
<div class="modal fade " id="addsubcategModal" tabindex="-1" aria-labelledby="addsubcategModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addsubcategModalLabel">Create New Subcategory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="add-subcategory.php" enctype="multipart/form-data" class="form-sample">
                    <div class="mb-3">
                        <label for="electronic_type" class="form-label">Electronic Type</label>
                        <select name="electronic_type" id="electronic_type" class="form-select">
                            <option value="None">--- Select ---</option>
                            <?php
                                $sql = "SELECT * FROM electronics";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['elec_id'] . "'>" . $row['elec_name'] . "</option>";
                                }
                                ?>
                        </select>
                        <span class="error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="subname" class="form-label">SubCategory Name</label>
                        <input type="text" class="form-control" name="subname" id="subname">
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

<div class="modal fade " id="editcategModal" tabindex="-1" aria-labelledby="editcategModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editcategModalLabel">Update Subcategory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body suppbody">

            </div>
        </div>
    </div>
</div>


