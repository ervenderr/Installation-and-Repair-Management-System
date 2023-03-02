<!-- Add service Transaction - The modal -->
<?php

$sql = "SELECT * FROM services";
$result = mysqli_query($conn, $sql);

?>

<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Create Service Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="form-sample" name="myForm" action="add-transactions.php" method="POST" enctype="multipart/form-data">
                    <p class="card-description"> Personal info </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="fname">First Name</label>
                                <div class="">
                                    <input type="text" name="fname" class="form-control" placeholder="ex. Erven" />
                                    <span id="fname_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="lname">Last Name</label>
                                <div class="">
                                    <input type="text" name="lname" class="form-control" placeholder="ex. Idjad"/>
                                    <span id="lname_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="email" class="col-form-label">Email</label>
                                <div class="">
                                    <input name="email" class="form-control" type="email" placeholder="ex. ervenidjad12@gmail.com">
                                    <span id="email_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="phone" class="col-form-label">Phone</label>
                                <div class="">
                                    <input name="phone" class="form-control" type="tel" placeholder="ex. 09123456789"/>
                                    <span id="phone_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="address" class="col-form-label">Address</label>
                                <div class="">
                                    <input name="address" class="form-control" type="text" placeholder="ex. Recodo, Zamboanga City">
                                    <span id="address_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="stype" class="col-form-label">Service Type</label>
                                <div class="">
                                <select name="stype" id="stype" class="form-control" onchange="getPackageType(this.value)">
                                        <option value="None">--- Select ---</option>
                                        <?php
                                        
                                        while($row = mysqli_fetch_assoc($result)) { 
                                            echo "<option value='" . $row['service_id'] . "'>" . $row['service_name'] . "</option>";
                                        }
                                    ?>
                                    </select>
                                    <span id="stype_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="package" class="col-form-label">Package Type</label>
                                <div class="">
                                    <select name="package" id="package" class="form-control">
                                        <option value="None">--- Select ---</option>
                                    </select>
                                    <span id="package_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="other" class="col-form-label">Other concern</label>
                                <div class="">
                                    <input name="other" id="other" type="text" class="form-control" />
                                    <span id="other_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="electrician" class="col-form-label">Assigned Electrician</label>
                                <div class="">
                                    <select name="electrician" class="form-control">
                                        <option value="None">--- Select ---</option>
                                        <option value="John Kevin">John Kevin</option>
                                        <option value="Robin Junior">Robin Junior</option>
                                        <option value="Aming Alyasher">Aming Alyasher</option>
                                        <option value="Farren Smith">Farren Smith</option>
                                    </select>
                                    <span id="electrician_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="date" class="col-form-label">Date</label>
                                <div class="">
                                    <input name="date" type="date" class="form-control" placeholder="dd/mm/yyyy" />
                                    <span id="date_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="completed" class="col-form-label">Date Completed</label>
                                <div class="">
                                    <input name="completed" type="date" class="form-control" placeholder="dd/mm/yyyy" />
                                    <span id="completed_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="payment" class="col-form-label">Payment</label>
                                <div class="">
                                    <input name="payment" class="form-control" type="text" value="$ " />
                                    <span id="payment_error" class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input name="submit" type="submit" class="btn btn-primary" value="Add Transaction" />
                        
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
function getPackageType(serviceId) {
    if (serviceId !== "None") {
        $.ajax({
            type: "POST",
            url: "get-packages.php",
            data: { service_id: serviceId },
            dataType: "json",
            success: function (response) {
                var len = response.length;
                $("#package").empty();
                $("#package").append("<option value='None'>--- Select ---</option>"); // add default option
                for (var i = 0; i < len; i++) {
                    var id = response[i]["pkg_id"];
                    var name = response[i]["name"];
                    $("#package").append("<option value='" + id + "'>" + name + "</option>");
                }
            },
        });
    } else {
        $("#package").empty();
        $("#package").append("<option value='None'>--Select--</option>");
    }
}

</script>
