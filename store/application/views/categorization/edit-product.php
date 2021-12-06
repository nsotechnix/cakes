<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <?php $this->load->view('messages'); ?>
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <!--begin::Form-->
        <form class="kt-form" method="post" action="<?php echo site_url('categorization/update_product/' . $this->uri->segment(3)); ?>" enctype="multipart/form-data">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" value="<?= $PRODUCT_DETAILS[0]->product_name; ?>" aria-describedby="name" placeholder="Enter product name" name="product_name" required>
                        </div>
                    </div>


                    <div class="col-md-4 mb-3">
                        <label for="category">Category</label>

                        <select name="category_id" class="form-control" onchange="" id="catid" required>
                            <option value=<?= $PRODUCT_DETAILS[0]->category_id; ?>><?= $PRODUCT_DETAILS[0]->category; ?></option>
                            <?php foreach ($CATEGORIES as $cat) { ?>

                                <option value=<?php echo $cat->category_id ?>><?php echo $cat->category ?></option>

                            <?php } ?>
                        </select>
                    </div>
                    <!-- <div class="col-md-4 mb-3">
                        <label for="validationCustom01">Subcategory</label>
                        <select name="subcategory_id" class="form-control" id="sub_category">

                        </select>
                    </div> -->

                    <div class="col-md-4 mb-3">
                        <label for="category">Subcategory</label>

                        <select name="subcategory_id" class="form-control" id="sub_category" required>


                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Market Price</label>
                            <input type="number" class="form-control" value="<?= $PRODUCT_DETAILS[0]->market_price; ?>" aria-describedby="market-price" placeholder="Enter product market price" name="market_price" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cake's Price</label>
                            <input type="number" class="form-control" value="<?= $PRODUCT_DETAILS[0]->cake_price; ?>" aria-describedby="our price" placeholder="Enter our price" name="cake_price" required>
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
                                    <select name="GST_percent" id="gstpercent" onchange="calculate_excluding_gstpercent(this.value);" class="form-control">
                                        <option value="<?= $PRODUCT_DETAILS[0]->GST_percent; ?>" selected><?= $PRODUCT_DETAILS[0]->GST_percent; ?></option>
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
                                    <input type="number" class="form-control" aria-describedby="our price" placeholder="price" value="<?= $PRODUCT_DETAILS[0]->actual_price; ?>" name="actual_price" id="actual_price" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Initial Stock</label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="number" class="form-control" id="" value="0" name="stock" value="<?= $PRODUCT_DETAILS[0]->stock; ?>" placeholder="Enter stock(By Default 0)">
                                    </div>
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
                                <img src="<?php echo base_url('uploads/products/' . $PRODUCT_DETAILS[0]->productImage); ?>" alt="product image" height="100" width="100">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Product Description</label>
                            <textarea name="description" id="" cols="" rows="3" class="form-control" placeholder="Enter product description" required><?= $PRODUCT_DETAILS[0]->description; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" name="editProduct" class="btn btn-primary">Edit Product</button>
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

        var amount = $("#cake_price").val();
        gstpercent = (id / 100) * amount;
        cgstpercent = ((id / 100) * amount) / 2;
        var actual_price = Number(amount) + Number(gstpercent);
        $("#actual_price").val(actual_price);
        $("#cgst_amount").val(cgstpercent);
        $("#sgst_amount").val(cgstpercent);
    }
</script>


<script>
    $('#catid').change(function() {

        category = $('#catid').val();

        $.ajax({
            url: '<?= base_url('categorization/getsubcat/') ?>' + category,
            type: "POST",
            data: {
                category: category
            },
            success: function(subcategory) {

                $("#sub_category").html(subcategory);
            }

        })

    });
</script>