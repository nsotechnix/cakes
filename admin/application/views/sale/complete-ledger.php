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

                        <th>Sale Date</th>
                        <th>Cashier</th>
                        <th>Invoice No</th>

                        <th>Total Amount</th>
                        <th>Last Payment Date</th>
                        <th>Gross Amount</th>
                        <th>Paid Amount</th>

                        <th>Receipt</th>
                        <!-- 
                        <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($ledger as $results) {
                        $id = $results->sales_no; ?>
                        <tr>
                            <td><?php echo $i; ?></td>

                            <td><?php echo date('M d,Y', strtotime($results->ledger_date)); ?></td>
                            <td><?php echo $results->name; ?></td>
                            <!-- <td class="text-center"><button class="btn btn-warning btn-sm" id="payButton"><a href='#productModal<?php echo $results->sales_no; ?>' data-toggle='modal' data-target="#productModal<?php echo $results->sales_no; ?>">View Products</button></a></td> -->
                            <td><?php echo $results->ledger_no; ?></td>

                            <td><?php echo $results->grand_total; ?></td>


                            <td><?php echo date('M d,Y', strtotime($results->last_payment_date)); ?></td>
                            <td><?php echo $results->sales_round_amount; ?></td>

                            <td><?php echo $results->sales_paid_amount; ?></td>



                            <td class="text-center"><a class="btn btn-success btn-sm" href="<?php echo base_url('sale/saleReceipt/' . $results->sales_no) ?>"><i class="fa fa-file-pdf-o" style="font-size:20px; color:red;"></i>Receipt</a></td>
                            <!-- <td>
                                
                            </td> -->
                        </tr>
                    <?php $i++;
                    } ?>


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