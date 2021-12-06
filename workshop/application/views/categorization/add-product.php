<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <?php $this->load->view('messages'); ?>
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <!--begin::Form-->
        <form class="kt-form" method="post" action="<?php echo site_url('categorization/addProduct'); ?>" enctype="multipart/form-data">

            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" aria-describedby="name" placeholder="Enter product name" name="product_name" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" id="catid" class="form-control" required>
                                <option value="" selected disabled>Select Category</option>
                                <?php foreach ($CATEGORIES as $key) { ?>
                                    <option value="<?php echo $key->category_id; ?>"><?php echo $key->category; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4 mb-3">
                        <label for="validationCustom01">Subcategory</label>
                        <select name="subcategory_id" class="form-control" id="sub_category" required>

                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Market Price</label>
                            <input type="number" class="form-control" aria-describedby="market-price" placeholder="Enter product market price" name="market_price" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cake's Price</label>
                            <input type="number" class="form-control" aria-describedby="our price" onchange="calculate_excluding_gstpercent(this.value, 'cake_price');" placeholder="Enter price" name="cake_price" id="cake_price" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">GST</label>
                            <select id="gstSelect" class="form-control " onchange="iddetails()" name="gstSelect">
                                <option selected value="" disabled>Select GST</option>
                                <option value="Including GST">Including GST</option>
                                <option value="Excluding GST">Excluding GST</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 p-3 mb-4" id="gst">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>GST (%)</label>
                                    <select name="GST_percent" id="gstpercent" onchange="calculate_excluding_gstpercent(this.value, 'gstpercent');" class="form-control">
                                        <option value="" selected disabled>Select GST(%)</option>
                                        <option value="5">5%</option>
                                        <option value="12">12%</option>
                                        <option value="18">18%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>CGST Amount</label>
                                    <input type="number" class="form-control" aria-describedby="our price" placeholder="cgst_amount" name="cgst_amount" id="cgst_amount" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>SGST Amount</label>
                                    <input type="number" class="form-control" aria-describedby="our price" placeholder="sgst_amount" name="sgst_amount" id="sgst_amount" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Actual Price</label>
                                    <input type="number" class="form-control" aria-describedby="our price" placeholder="price" name="actual_price" id="actual_price" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Product Image</label>
                            <div></div>
                            <div class="">
                                <input type="file" class="form-control" id="" name="productImage">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Initial Stock</label>
                            <div></div>
                            <div class="custom-file">
                                <input type="number" class="form-control" id="" value="0" name="stock" placeholder="Enter stock(By Default 0)">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Product Description</label>
                            <textarea name="description" id="" cols="" rows="3" class="form-control" placeholder="Enter product description" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Expiry Date</label>
                            <div></div>
                            <div class="custom-file">
                                <input type="date" class="form-control" id="" value="0" name="expiry_date" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" name="addProduct" class="btn btn-primary">Add Product</button>
                            <button type="reset" class="btn btn-warning text-light">Cancel</button>
                        </div>
                    </div>
                </div>
        </form>

        <!--end::Form-->
    </div>
</div>

<!--end::Portlet-->


</div>
<script type="text/javascript">
    $(document).ready(function() {
        iddetails()

    });

    $(document).ready(function() {
        calculate_gstpercent()

    });
    $('#gst').hide();

    function iddetails() {
        var option = $('#gstSelect option:selected').val();

        if (option == 'Including GST') {

            $('#gst').show();
        }
        if (option == 'Excluding GST') {
            $('#gst').show();
        }

    }

    function calculate_excluding_gstpercent(id) {

        var gstpercent = Number($('#gstpercent').val()) || 0;
        var cake_price = Number($('#cake_price').val()) || 0;

        amount = 0;
        amount = cake_price;
        gstpercent = (id / 100) * amount;
        cgstpercent = ((id / 100) * amount) / 2;
        var actual_price = Number(amount) + Number(gstpercent);
        let answer = ((amount + ((gstpercent) / 100 * amount))).toFixed(2) //New Line added

        $("#actual_price").val(actual_price);
        $("#cgst_amount").val(cgstpercent);
        $("#sgst_amount").val(cgstpercent);
    }
</script>



<script>
    $('#catid').change(function() {

        category_id = $('#catid').val();

        $.ajax({
            url: '<?= base_url('categorization/getsubcat/') ?>' + category_id,
            type: "POST",
            data: {
                category_id: category_id
            },
            success: function(subcategory) {

                $("#sub_category").html(subcategory);
            }

        })

    });
</script>