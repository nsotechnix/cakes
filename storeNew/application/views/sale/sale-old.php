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
                            <input type="text" class="form-control" aria-describedby="name" placeholder="Search product" name="product_name" required>
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
                            <label for="">Market Price</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Cake's Price</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">GST(%)</label>
                            <input type="text" class="form-control" value="including GST - 5%" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Available Stock</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Add Quantity</label>
                            <input type="number" class="form-control" placeholder="Enter items">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Discount (in &#8377; or %)</label>
                            <select name="" id="discount" class="form-control" onclick="fundiscount()">
                                <option value="" selected disabled>Select</option>
                                <option value="In Rupees">In Rupees(&#8377;)</option>
                                <option value="In Percentage">In Percentage(%)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4" id="per">
                        <div class="form-group">
                            <label for="">Add Discount(in %)</label>
                            <input type="number" class="form-control" placeholder="Enter discount">
                        </div>
                    </div>
                    <div class="col-lg-4" id="rs">
                        <div class="form-group">
                            <label for="">Add Discount(in &#8377;)</label>
                            <input type="number" class="form-control" placeholder="Enter discount">
                        </div>
                    </div>
                    <div class="col-lg-4" id="all">
                        <div class="form-group">
                            <label for="">Add Discount(in &#8377; or %)</label>
                            <input type="number" class="form-control" placeholder="Discount amount or Percentage" disabled>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Net Price</label>
                            <input type="number" class="form-control" placeholder="Total amount" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="text-right">
                            <input type="submit" class="btn btn-outline-info px-4 shadow" value="Add to List">
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
                <form action="">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <th>Action</th>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>GST</th>
                                <th>Discount (In &#8377; or %)</th>
                                <th>Total Price</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><i class="fa fa-trash text-danger" style="cursor:pointer;"></i></td>
                                    <td class="text-center">1</td>
                                    <td>Product Name</td>
                                    <td class="text-center">5</td>
                                    <td class="text-center">1000.00</td>
                                    <td class="text-center">5%</td>
                                    <td class="text-center">1%</td>
                                    <td class="text-right">10000.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr style="border-top-style:ridge;">
                                    <td colspan="7" class="text-right"><b>Total Price</b></td>
                                    <td class="text-right">10000.00</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right"><b>GST Amount</b></td>
                                    <td class="text-right">100.00</td>
                                </tr>
                                <tr style="border-bottom-style:double;">
                                    <td colspan="7" class="text-right"><b>Discount Amount</b></td>
                                    <td class="text-right">100.00</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right"><b>Net Amount</b></td>
                                    <td class="text-right">9900.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-right">
                                <input type="submit" value="Generate Bill" class="btn btn-info px-5 shadow">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>


<script type="text/javascript">
    $('#rs').hide();
    $('#per').hide();
    $('#all').show();

    function fundiscount() {
        var option = $('#discount option:selected').val();
        if (option == 'In Rupees') {
            $('#rs').show();
            $('#per').hide();
            $('#all').hide();
        }
        if (option == 'In Percentage') {
            $('#rs').hide();
            $('#per').show();
            $('#all').hide();
        }

    }
</script>