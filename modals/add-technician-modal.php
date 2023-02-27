<!-- Add service Transaction - The modal -->
<div class="modal fade" id="addTechnicianModal" tabindex="-1" aria-labelledby="addTechnicianModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTechnicianModalLabel">Create new Technician</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-sample" action="add-technician.php" method="POST" enctype="multipart/form-data">
                    <p class="card-description"> Personal info </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="fname">First Name</label>
                                <div class="">
                                    <input type="text" name="fname" class="form-control" placeholder="ex. Erven" />
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="lname">Last Name</label>
                                <div class="">
                                    <input type="text" name="lname" class="form-control" placeholder="ex. Idjad"/>
                                    <span class="error-input"></span>
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
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="phone" class="col-form-label">Phone</label>
                                <div class="">
                                    <input name="phone" class="form-control" type="tel" placeholder="ex. 09123456789"/>
                                    <span class="error-input"></span>
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
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input name="submit" type="submit" class="btn btn-primary" value="Add Transaction" />
                        
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
    </div>
