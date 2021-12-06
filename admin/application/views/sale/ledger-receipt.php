<style>
    @page {
        margin: 0;
    }

    #invoice {
        font-size: 14px;
    }

    table tr td {
        font-size: 14px;
    }

    table th {
        border-bottom: none;
    }
</style>

<!-- end:: Header -->
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="col-12">
            <div class="card">
                <div id="invoice" class="p-4">
                    <div class="row">
                        <div class="col-6">
                            <h1 style="font-size:45px;" class="mt-1">Cake.in</h1>
                        </div>
                        <div class="col-6 text-right">
                            <h5><u>Our Address</u></h5>
                            <p>S Chowdhury Rd, Athgaon Guwahati, Assam 781001<br />
                                Contact NO :+91 70026-58626</p>
                        </div>
                    </div>
                    <?php foreach ($invoice as $rows) {
                    ?>
                        <div class="">
                            <h5><u>Customer Details: </u></h5>
                            <p><b>Name : </b> <?php echo $rows['customer_name'] ?><br />
                                <b>Contact No : </b><?php echo $rows['customer_phone'] ?>
                            </p>
                        </div>
                        <div class="mt-5">
                            <table class="table table-bordered">
                                <thead>
                                    <th>Invoice No</th>
                                    <th class="text-center">Total Price</th>
                                    <th class="text-center">Paid Amount</th>
                                    <th class="text-center">Pending Amount</th>
                                    <th class="text-center">Last Payment date</th>
                                </thead>
                                <tbody>


                                    <td><?php echo $rows['ledger_no'] ?></td>
                                    <td class="text-center"><?php echo $rows['sales_round_amount'] ?></td>
                                    <td class="text-center"><?php echo $rows['sales_paid_amount'] ?></td>

                                    <td class="text-center">
                                        <?php if ($rows['due_amount'] == 0.00) { ?>
                                            Fully Paid</td>
                                <?php } else { ?> <?php echo $rows['due_amount'] ?></td><?php } ?>

                                <td class="text-center"><?php echo date('M d,Y', strtotime($rows['last_payment_date'])); ?></td>

                                </tbody>
                            </table>
                        </div>
                    <?php   } ?>
                    <footer>
                        <div class="col-12">
                            <div><b>Terms &amp; Conditions :</b></div>
                            <div class="notice">1. </div>
                        </div>
                        <div class="col-12 border-top mt-3">
                            <p class="text-center">Invoice was created on a computer and is valid without the signature and seal.</p>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="toolbar hidden-print mt-2">
                <div class="text-right">
                    <button type="button" onclick="printDiv('invoice')" class="btn btn-dark"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        document.getElementById('header').style.display = 'none';
    }
</script>