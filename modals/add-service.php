<div class="modal fade" id="addserviceModal" tabindex="-1" aria-labelledby="addserviceModalLabel" aria-hidden="true">
    <div class="modal-dialog sermodals">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addserviceModalLabel">Create new Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="update-form" class="form-sample" action="add-service.php" method="POST"
                    enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="sname">Service Name</label>
                                <div class="">
                                    <input type="text" id="sname" name="sname" class="form-control" placeholder="" />
                                    <span class="error-input" id="sname-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="img1">Image</label>
                                <div class="">
                                    <input type="file" class="form-control" id="img" name="img1" />
                                    <span class="error-input" id="img-error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="description" class="col-form-label">Description</label>
                                <div class="">
                                    <textarea name="description" class="form-control" type="text" rows="5"
                                        placeholder=""></textarea>
                                    <span class="error-input" id="description-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input name="service_id" type="hidden" id="service_id" class="btn btn-primary" />
                                <button type="submit" id="update" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>