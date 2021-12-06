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
        <h3>Add stock</h3>
        <div class="row">
            <div class="col-sm">
                <form method="post" autocomplete="off" action="<?php echo site_url('categorization/addStock'); ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">

                                <select name="store_id" id="" class="form-control">
                                    <option value="" selected disabled>Select Store</option>
                                    <?php foreach ($STORES as $key) { ?>
                                        <option value="<?php echo $key->store_id; ?>"><?php echo $key->store_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">

                            <select name="product" id="" class="form-control" required>
                                <option value="" disabled selected>--select product--</option>
                                <?php
                                foreach ($PRODUCTS as $product) { ?>
                                    <option value="<?php echo $product->id; ?>"><?php echo $product->product_name; ?></option>
                                <?php }
                                ?>
                            </select>

                        </div><br />

                        <div class="col-sm-4">

                            <input type="number" name="quantity" placeholder="Enter stock quantity" value="0" id="" class="form-control" required>

                        </div><br />

                        <div class="col-sm-4">

                            <button type="submit" name="addstock" class="btn btn-info">Proceed</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>