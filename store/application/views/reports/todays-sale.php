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

        <div class="table-responsive">
            <center>
                <h4 id="totalAmountSpan"></h4>
            </center>
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                <thead>
                    <tr>
                        <th>#</th>

                        <th>Item Name</th>
                        <th>Product Price</th>
                        <th>Quantity</th>
                        <th>Discount</th>
                        <th>Total Price</th>
                        <th>Date & Time</th>


                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php if (!empty($todaysales)) {
                        foreach ($todaysales as $results) { ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $results->product_name; ?></td>
                                <td><?php echo $results->product_price; ?></td>
                                <td><?php echo $results->sales_qty; ?></td>
                                <td><?php echo (($results->product_price * $results->sales_qty) - ($results->sales_amount)); ?></td>
                                <td><?php echo $results->sales_amount ?></td>
                                <td><?php echo date('d M ,Y', strtotime($results->sales_date)); ?>; <?php echo date('g:i a.', strtotime($results->sales_time)); ?></td>

                            </tr>
                        <?php }
                    } else { ?> <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $('#totalAmountSpan').html('Total Sale: &#8377;' + 0);
</script>