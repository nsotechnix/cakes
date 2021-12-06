<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <?php $this->load->view('messages'); ?>
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <!--begin::Form-->
        <form class="kt-form" method="post" action="#" enctype="multipart/form-data">
            <div class="kt-portlet__body">
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" aria-describedby="name" placeholder="Enter product name" name="product_name" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="submit" name="addProduct" class="btn btn-primary px-3">Filter</button>
                            <button type="reset" class="btn btn-warning text-light">Cancel</button>
                        </div>
                    </div>
                </div>
                <h4 class="ml-1">Product Details</h4>
                <hr>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Product Price</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Stock</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Add Quantity</label>
                            <input type="text" class="form-control" placeholder="Enter items">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Discount</label>
                            <input type="text" class="form-control" placeholder="Enter discount">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="text-right">
                            <input type="submit" class="btn btn-outline-info px-4" value="Add to List">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <div class="kt-portlet">
            <div class="col-lg-12 p-5">
                <h2>Product List</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Total Price</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Product Name</td>
                                <td class="text-center">5</td>
                                <td class="text-center">1000.00</td>
                                <td class="text-center">1%</td>
                                <td class="text-right">10000.00</td>
                            </tr>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Product Name</td>
                                <td class="text-center">5</td>
                                <td class="text-center">1000.00</td>
                                <td class="text-center">1%</td>
                                <td class="text-right">10000.00</td>
                            </tr>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Product Name</td>
                                <td class="text-center">5</td>
                                <td class="text-center">1000.00</td>
                                <td class="text-center">1%</td>
                                <td class="text-right">10000.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="border-top-style:ridge;">
                                <td colspan="5" class="text-right"><b>Total Price</b></td>
                                <td class="text-right">10000.00</td>
                            </tr>
                            <tr style="border-bottom-style:double;">
                                <td colspan="5" class="text-right"><b>Total Discount</b></td>
                                <td class="text-right">100.00</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><b>Net Amount</b></td>
                                <td class="text-right">9900.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
</div>

<!--end::Portlet-->
</div>