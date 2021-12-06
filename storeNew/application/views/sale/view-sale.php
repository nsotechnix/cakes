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
                        <!-- <th>Product Name</th> -->
                        <th>Invoice No</th>
                        <!-- <th>Category</th>
                        <th>Subcategory</th> -->

                        <th>Customer Name</th>
                        <th>Contact</th>
                        <th>Total Amount</th>
                        <th>Discount</th>
                        <th>Paid Amount</th>
                        <th>Balance Amount</th>
                        <th>Invoice</th>
                        <th>Date</th>
                        <td>Time</td>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php if (!empty($sales)) {
                        foreach ($sales as $results) { ?>
                            <tr>
                                <td><?php echo $i++; ?></td>

                                <td><?php echo $results->invoice_no; ?></td>
                                <td><?php echo $results->customer_name; ?></td>
                                <td><?php echo $results->customer_phone ?></td>
                                <td><?php echo $results->sales_round_amount ?></td>
                                <td><?php echo $results->sales_discount_total ?></td>
                                <td><?php echo $results->sales_paid_amount ?></td>
                                <td><?php echo $results->sales_balance_amount ?></td>
                                <td>
                                    <?php if ($results->sales_balance_amount == 0.00) { ?>

                                        <a class="btn btn-primary btn-sm" href="<?php echo base_url('sale/saleInvoice/' . $results->sales_no) ?>">Invoice</a>
                                </td>
                                <?php } else { ?>Payment Pending</td><?php } ?>
                            <td><?php echo date('M d,Y', strtotime($results->sales_date)); ?></td>
                            <td><?php echo date('g:i a.', strtotime($results->sales_time)); ?></td>
                            <!-- <td>
                             
                                <a href="<?php echo base_url('sale/editSale/' . $results->sales_no) ?>" class="btn btn-success m-1"><i class="bx bx-pencil"></i>Edit</a>
                            </td> -->
                            </tr>

                        <?php }
                    } else { ?> <?php } ?>


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