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

                        <!-- <th>Item Name</th>
                        <th>Product Price</th>
                        <th>Quantity</th>
                        <th>Discount</th>
                        <th>Total Price</th>
                        <th>Date & Time</th> -->

                        <th>Invoice-No</th>

                        <th>Total Amount</th>

                        <th>Paid Amount</th>
                        <th>Payment Terms</th>
                        <th>Balance Amount</th>
                        <!-- <th>Invoice</th> -->
                        <th>Date</th>
                        <th>Time</th>


                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php if (!empty($todaysales)) {
                        foreach ($todaysales as $report) { ?>
                            <tr>

                                <td><?php echo $i++ ?></td>
                                <td><?php echo $report->invoice_no ?></td>

                                <td><?php echo $report->sales_round_amount ?></td>
                                <!-- <td><?php echo $report->sales_discount_total ?></td> -->
                                <td><?php echo $report->sales_paid_amount ?></td>
                                <td><?php if ($report->payment_cash != NULL) { ?>
                                        Cash = <?php echo $report->payment_cash ?>
                                    <?php } else { ?></td><?php } ?>
                            <?php if ($report->payment_debit_card != NULL) { ?>
                                </br>
                                Deb Card = <?php echo $report->payment_debit_card ?>
                            <?php } else { ?></td><?php } ?>
                            <?php if ($report->payment_credit_card != NULL) { ?>
                                </br>
                                Credit Card = <?php echo $report->payment_credit_card ?>
                            <?php } else { ?></td><?php } ?>

                            <?php if ($report->payment_upi != NULL) { ?>
                                </br>
                                UPI = <?php echo $report->payment_upi ?>
                            <?php } else { ?></td><?php } ?>

                            <?php if ($report->payment_cheque != NULL) { ?>
                                </br>
                                Cheque = <?php echo $report->payment_cheque ?>
                            <?php } else { ?></td><?php } ?>


                            </td>
                            <td>
                                <?php if ($report->sales_balance_amount != 0.00) { ?>
                                    <?php echo $report->sales_balance_amount ?>
                                    <?php } else { ?>Fully Paid<?php } ?>

                            </td>


                            <td><?php echo date('M d,Y', strtotime($report->sales_date)); ?></td>
                            <td><?php echo date('g:i,a', strtotime($report->sales_time)); ?></td>
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