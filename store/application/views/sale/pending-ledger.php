<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
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
                        <!-- <th>Order item/Product</th> -->
                        <th>Invoice No</th>

                        <th>Total Amount</th>
                        <th>Last Payment Date</th>
                        <th>Gross Amount</th>
                        <th>Paid Amount</th>
                        <th>Pending Amount</th>
                        <th>Pay Outstanding</th>
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
                            <!-- <td class="text-center"><button class="btn btn-warning btn-sm" id="payButton"><a href='#productModal<?php echo $results->sales_no; ?>' data-toggle='modal' data-target="#productModal<?php echo $results->sales_no; ?>">View Products</button></a></td> -->
                            <td><?php echo $results->ledger_no; ?></td>

                            <td><?php echo $results->grand_total; ?></td>


                            <td><?php echo date('M d,Y', strtotime($results->last_payment_date)); ?></td>
                            <td><?php echo $results->sales_round_amount; ?></td>

                            <td><?php echo $results->sales_paid_amount; ?></td>
                            <td><?php echo $results->due_amount; ?></td>
                            <td class="text-center">
                                <?php if ($results->due_amount == 0.00) {
                                ?>
                                    <button class="btn btn-primary btn-sm" disabled>Paid</button>
                            </td>
                        <?php } else { ?>
                            <a data-toggle='modal' data-target="#salesModal" data-id="<?= $results->sales_no; ?>" ; data-totalamount="<?= $results->sales_round_amount; ?>" ; data-amountpaid="<?= $results->sales_paid_amount; ?>" ; data-amountdue="<?= $results->due_amount; ?>" ; class="btn btn-success btn-sm editor">Pay</a></td>
                        <?php } ?>
                        <td class="text-center"><a class="btn btn-warning btn-sm" href="<?php echo base_url('sale/saleReceipt/' . $results->sales_no) ?>"><i class="fa fa-file-pdf-o" style="font-size:20px; color:red;"></i>View Receipt</a></td>
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

<!--Sale Ledger Modal -->

<div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Payment Outstanding</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" name="saleUpdateForm" method="post" onsubmit="return validateForm()" action="<?php echo base_url(); ?>sale/update_sales_ledger" novalidate enctype="multipart/form-data">
                    <div class="form-row">
                        <input type='hidden' name="sales_no" id='sales_no'>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Total Amount:</label>
                                <!-- <input type="text" name="sales_round_amount" id="sales_round_amount" class="form-control" disabled> -->
                                <h3 class="text-danger">
                                    <input type="text" class="form-control border-0 text-center text-success" name="sales_round_amount" id="sales_round_amount" style="font-size:20px;" value="" readonly>
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Amount Paid:</label>
                                <!-- <input type="text" name="sales_paid_amount" id="sales_paid_amount" class="form-control" readonly> -->
                                <h3 class="text-danger">
                                    <input type="text" class="form-control border-0 text-center text-success" name="sales_paid_amount" id="sales_paid_amount" style="font-size:20px;" value="" readonly>
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Amount Due:</label>
                                <!-- <input type="text" name="due_amount" id="due_amount" class="form-control" readonly> -->
                                <h3 class="text-danger">
                                    <input type="text" class="form-control border-0 text-center text-danger" name="due_amount" id="due_amount" style="font-size:20px;" value="" readonly>
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Pay Due:</label>
                                <!-- <input type="text" name="last_payment_amount" id="last_payment_amount" placeholder="Enter pay amount" class="form-control maxamount" required> -->
                                <h3 class="text-danger">
                                    <input type="text" class="form-control text-center text-danger maxamount" name="last_payment_amount" id="last_payment_amount" style="font-size:20px;" value="">
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="submit" name="pay" class="btn btn-block btn-info shadow" value="pay">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Sale Ledger Modal End -->

<script>
    $(document).on('click', ".descriptionCls", function(e) {
        $('#descriptionSpan').html($(this).data('description'))
    })
</script>

<script>
    function validateForm() {
        let x = document.forms["saleUpdateForm"]["last_payment_amount"].value;
        if (x == "") {
            alert("Please Enter any Amount to pay ");
            return false;
        }
    }
</script>

<script>
    document.getElementsByClassName('maxamount')[0].oninput = function() {
        var max = parseInt(this.max);

        if (parseInt(this.value) > max) {
            this.value = max;
        }
    }
</script>
<script>
    $(document).on('click', '.editor', function() {
        $('#sales_no').val($(this).data('id'))
        $('#sales_round_amount').val($(this).data('totalamount'))
        $('#sales_paid_amount').val($(this).data('amountpaid'))
        $('#due_amount').val($(this).data('amountdue'))
        $('#last_payment_amount').attr('max', $(this).data('amountdue'))

    })
</script>