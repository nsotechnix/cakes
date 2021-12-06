<script src="https://code.jquery.com/jquery-1.12.4.min.js"> </script>



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

        <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Expiry Date</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Market Price</th>
                        <th>Selling Price</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Added on</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($PRODUCTS as $key) { ?>
                        <tr>
                            <td><?php echo ++$i; ?></td>
                            <td><?php echo $key->product_name; ?></td>
                            <td><?php echo date('d M,Y', strtotime($key->expiry_date)); ?></td>
                            <td><?php echo $key->category; ?></td>
                            <td><?php echo $key->sub_category; ?></td>
                            <td><?php echo $key->market_price; ?></td>
                            <td><?php echo $key->cake_price; ?></td>
                            <!--  -->
                            <td><a href="<?php echo base_url('uploads/products/' . $key->productImage); ?>" target="_BLANK"><img src="<?php echo base_url('uploads/products/' . $key->productImage); ?>" alt="image" id="productImage" GFG="250" style="height: 100px; width: 100px;" /></a></td>
                            <td><button data-description="<?php echo $key->description; ?>" class="btn btn-info descriptionCls" data-toggle="modal" data-target="#descriptionModal">View Description</button></td>
                            <td><?php echo date('d M,Y', strtotime($key->added_date)); ?></td>

                            <td nowrap>
                                <a href="<?php echo site_url('categorization/editProduct/' . $key->id); ?>" class="btn btn-info btn-xs">Edit</a>
                                <?php if ($key->is_active == 1) { ?>

                                    <!-- <a href="<?php echo base_url(); ?>categorization/block_product/<?php echo $key->id; ?>" class="btn btn-danger btn-xs">Block</a> -->
                                    <a href="<?php echo site_url('categorization/block_product/' . $key->id); ?>" class="btn btn-danger btn-xs">Block</a>

                                <?php } else { ?>
                                    <a href="<?php echo site_url('categorization/unblock_product/' . $key->id); ?>" class="btn btn-success btn-xs">Unblock</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>

<div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><span id="descriptionSpan"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', ".descriptionCls", function(e) {
        $('#descriptionSpan').html($(this).data('description'))
    })
</script>



<script type="text/javascript">
    function zoomin() {
        var GFG = document.getElementById("productImage");
        var currWidth = GFG.clientWidth;
        GFG.style.width = (currWidth + 100) + "px";
    }

    function zoomout() {
        var GFG = document.getElementById("productImage");
        var currWidth = GFG.clientWidth;
        GFG.style.width = (currWidth - 100) + "px";
    }
</script>