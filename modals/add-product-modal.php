<!-- Add service Transaction - The modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add new product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-sample" action="add-product.php" method="POST" enctype="multipart/form-data">
                    <p class="card-description"> Product info </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="pname">Product Name</label>
                                <div class="">
                                    <input type="text" name="pname" class="form-control" placeholder="" />
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="price">Price</label>
                                <div class="">
                                    <input type="number" name="price" step=".01" class="form-control" placeholder="" />
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="description" class="col-form-label">Description</label>
                                <div class="">
                                    <input name="description" class="form-control" type="text" placeholder="">
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="img1">Image 1</label>
                                <div class="">
                                    <input type="file" class="form-control" id="img1" name="img1" />
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="img2">Image 2</label>
                                <div class="">
                                    <input type="file" class="form-control" id="img2" name="img2" />
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label" for="img3">Image 3</label>
                                <div class="">
                                    <input type="file" class="form-control" id="img3" name="img3" />
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="features" class="col-form-label">Features</label>
                                <div class="">
                                    <textarea class="form-control" name="features" rows="10"></textarea>
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="full" class="col-form-label">Full Descriptions</label>
                                <div class="">
                                    <textarea class="form-control" name="full" rows="10"></textarea>
                                    <span class="error-input"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input name="submit" type="submit" class="btn btn-primary" value="Add Product" />

                        </div>
                </form>
            </div>
        </div>

    </div>
</div>
</div>