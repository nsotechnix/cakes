<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <!--begin::Form-->
        <div class="row p-5">
            <div class="col-lg-4">
                <div class="card text-center p-4 shadow border-0 bg-success text-light">
                    <h4>TODAY'S SALE</h4>
                    <h3>&#8377; 3,000</h3>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-center p-4 shadow border-0 bg-info text-light">
                    <h4>Monthly Sale</h4>
                    <h3>&#8377; 50,000</h3>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-center p-4 shadow border-0 bg-danger text-light">
                    <h4>PRODUCTS</h4>
                    <h3>5</h3>
                </div>
            </div>
        </div>
        <div class="container mb-5">
            <h3 class="text-center font-weight-bold">All Products</h3>
            <div class="row">
                <?php foreach ($STOCK as $product) { ?>

                    <div class="col-lg-4">

                        <div class="card shadow">
                            <img src="<?php echo base_url('uploads/products/' . $product->productImage); ?>" alt="" style="width:100%; height:300px;">
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6 text-center">
                                            <div class="p-2 bg-success text-light">
                                                <span class="font-weight-bold">Market price</span><br /> <?php echo $product->market_price ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 text-center">
                                            <div class="p-2 bg-success text-light">
                                                <span class="font-weight-bold">Cake's price</span><br /> <?php echo $product->cake_price ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <h3>Available Stock : <?php echo $product->stock ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                <?php } ?>
            </div>
        </div>

        <!--end::Form-->
    </div>
</div>

<!--end::Portlet-->