<style>
    .la_size {
        font-size: 30px;
        cursor: pointer;
    }
</style>

<!-- end:: Header -->
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <!--begin::Portlet-->
        <?php $this->load->view('messages'); ?>
        <h3>Create Combo</h3>
        <br />
        <div class="row">
            <div class="col-sm">
                <form method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-4">
                            <select name="products[]" id="kt_select2_3" class="form-control select2" required multiple>
                                <?php
                                foreach ($PRODUCTS as $product) { ?>
                                    <option value="<?php echo $product->id; ?>"><?php echo $product->product_name . " (&#8377;" . $product->price . ")"; ?></option>
                                <?php }
                                ?>
                            </select>
                        </div><br />
                        <div class="col-sm-4">
                            <input type="text" name="price" placeholder="Total Price" value="2000" id="price" readonly class="form-control" required>
                        </div><br />
                        <div class="col-sm-4">
                            <button type="submit" name="add" class="btn btn-info">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#kt_select2_3').select2({
        placeholder: "Select products",
    });
</script>