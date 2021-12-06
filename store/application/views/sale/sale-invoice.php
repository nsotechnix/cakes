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
        <div class="col-6">
            <div class="card">
                <div id="invoice" class="p-4">
                    <div class="row">
                        <div class="col-12">
                            <h1 style="font-size:45px;" class="mt-1 text-center">Cake.in</h1>
                            <h5>INVOICE NO : <?php echo ($amount->invoice_no); ?></h5>
                            <h5>INVOICE Date : <?php echo date('d M,Y', strtotime($amount->sales_date)); ?></h5>
                        </div>
                        <div class="col-12 mt-2">
                            <h5><u>Our Address</u></h5>
                            <p>S Chowdhury Rd, Athgaon Guwahati, Assam 781001<br />
                                Contact NO :+91 70026-58626</p>
                        </div>
                    </div>
                    <div class="">
                        <h5><u>Customer Details: </u></h5>
                        <p><b>Name : </b> <?php echo ($amount->customer_name); ?><br />
                            <b>Contact No : </b><?php echo ($amount->customer_phone); ?>
                        </p>
                    </div>
                    <div class="mt-5">
                        <table class="table table-bordered">
                            <thead>
                                <th>Product Name</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Discount</th>
                                <th class="text-right">Total</th>
                            </thead>
                            <tbody>
                                <?php $n = 1;
                                foreach ((array) $invoice as $rows) {
                                ?>
                                    <tr>
                                        <td><?php echo $rows['product_name']; ?></td>
                                        <td class="text-center"><?php echo $rows['sales_qty']; ?></td>
                                        <td class="text-right"><?php echo $rows['product_price']; ?></td>
                                        <td class="text-right"><?php echo (($rows['product_price'] * $rows['sales_qty']) - ($rows['sales_amount'])); ?></td>
                                        <td class="text-right"><?php echo $rows['sales_amount'] ?></td>
                                    </tr>
                                <?php   } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">Overall Discount : </td>
                                    <td class="text-right"><?php echo $rows['sales_discount_total'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><b>Total Amount : </b></td>
                                    <td class="text-right"><b><?php echo $rows['sales_round_amount'] ?></b></td>
                                </tr>

                            </tfoot>
                        </table>
                    </div>
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