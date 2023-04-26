<!-- repairs -->
<div class="modal fade " id="addRepairsModal" tabindex="-1" aria-labelledby="addPartsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPartsModalLabel">Create New</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="add-repairs.php" enctype="multipart/form-data"
                    onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="repairname" class="form-label">Repair Service Name</label>
                        <input type="text" class="form-control" name="repairname" id="repairname">
                        <span class="error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="electronic" class="form-label">Electronic Type</label>
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
                        <label for="electronic_part" class="form-label">Electronic Part (if applicanle) </label>
                        <select name="electronic_part" id="electronic_part" class="form-select">
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

<div class="modal fade " id="editRepairsModal" tabindex="-1" aria-labelledby="editPartsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartsModalLabel">Update Repair service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body suppbody">
            </div>
        </div>
    </div>
</div>


