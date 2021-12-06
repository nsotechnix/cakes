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
        <form action="" method="post">
            <?php echo form_open('report/saleReport', array('method' => 'post')) ?>
            <div class="row">
                <div class="col-lg-4">
                    <label for="">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo $start ?>">
                </div>
                <div class="col-lg-4">
                    <label for="">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo date('Y-m-d') ?>">
                </div>
                <div class="col-sm-4">
                    </br>
                    <input type="hidden" name="Action" value="Search">
                    <button type="submit" class="btn btn-success">Show Report</button>


                </div>
            </div>
        </form>



        <div class="table-responsive">


            <!-- begin: Datatable -->

            <?php if (isset($_REQUEST['Action']) == "Search") { ?>

                <h4>Sales Report from: <?php echo date('d M,Y', strtotime($start)); ?> to
                    <?php echo date('d M,Y', strtotime($end)); ?>
                </h4>
                <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice-No</th>
                            <!-- <th>Customer Name</th>
                            <th>Contact</th> -->
                            <th>Particulars</th>
                            <th>Total Amount</th>
                            <!-- <th>Discount</th> -->
                            <th>Paid Amount</th>
                            <th>Balance Amount</th>
                            <!-- <th>Invoice</th> -->
                            <th>Date</th>
                            <th>Time</th>

                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $k = 1 ?>
                        <?php if (!empty($salesreport)) : foreach ($salesreport as $report) : ?>
                                <tr>
                                    <td><?php echo $k++ ?></td>
                                    <td><?php echo $report->invoice_no ?></td>
                                    <!-- <td><?php echo $report->customer_name ?></td>
                                    <td><?php echo $report->customer_phone ?></td> -->
                                    <td></td>
                                    <td><?php echo $report->sales_round_amount ?></td>
                                    <!-- <td><?php echo $report->sales_discount_total ?></td> -->
                                    <td><?php echo $report->sales_paid_amount ?></td>
                                    <!-- <td><?php echo $report->sales_balance_amount ?></td> -->
                                    <td>
                                        <?php if ($report->sales_balance_amount != 0.00) { ?>
                                            <?php echo $report->sales_balance_amount ?>
                                            <?php } else { ?>Fully Paid<?php } ?>

                                    </td>
                                    <td><?php echo date('M d,Y', strtotime($report->sales_date)); ?></td>
                                    <td><?php echo date('g:i,a', strtotime($report->sales_time)); ?></td>
                                </tr>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
                <!--end: Datatable -->
            <?php } else { ?>

                <h4>Showing All Sales
                </h4>

                <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice-No</th>
                            <!-- <th>Customer Name</th>
                            <th>Contact</th> -->
                            <th>Particulars</th>
                            <th>Total Amount</th>
                            <!-- <th>Discount</th> -->
                            <th>Paid Amount</th>
                            <th>Balance Amount</th>
                            <!-- <th>Invoice</th> -->
                            <th>Date</th>
                            <th>Time</th>

                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $k = 1 ?>
                        <?php if (!empty($salesreportall)) : foreach ($salesreportall as $report) : ?>
                                <tr>
                                    <td><?php echo $k++ ?></td>
                                    <td><?php echo $report->invoice_no ?></td>
                                    <!-- <td><?php echo $report->customer_name ?></td>
                                    <td><?php echo $report->customer_phone ?></td> -->
                                    <td></td>
                                    <td><?php echo $report->sales_round_amount ?></td>
                                    <!-- <td><?php echo $report->sales_discount_total ?></td> -->
                                    <td><?php echo $report->sales_paid_amount ?></td>
                                    <!-- <td><?php echo $report->sales_balance_amount ?></td> -->
                                    <td>
                                        <?php if ($report->sales_balance_amount != 0.00) { ?>
                                            <?php echo $report->sales_balance_amount ?>
                                            <?php } else { ?>Fully Paid<?php } ?>

                                    </td>
                                    <td><?php echo date('M d,Y', strtotime($report->sales_date)); ?></td>
                                    <td><?php echo date('g:i,a', strtotime($report->sales_time)); ?></td>
                                </tr>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>

            <?php } ?>
        </div>

    </div>
</div>
<script>
    $('#totalAmountSpan').html('Total Sale: &#8377;' + 0);
</script>