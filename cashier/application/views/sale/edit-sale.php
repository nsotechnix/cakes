<head>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
</head>
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <?php $this->load->view('messages'); ?>
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <!--begin::Form-->
        <form name="myForm" class="kt-form" method="post" action="<?php echo base_url(); ?>sale/insert_sale" onsubmit="return validateForm()" novalidate enctype="multipart/form-data">
            <div class="kt-portlet__body">
                <div class="col-lg-12 mt-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Customer Name</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="Enter Customer Name">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Contact Number</label>
                            <input type="text" name="customer_phone" id="phone" placeholder="Enter Customer Phone" class="form-control">

                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <input type="hidden" name="sales_code" class="form-control input-medium" value="<?php echo $sales_no; ?>" />
                    <input type="hidden" class="form-control" id="no" readonly>
                    <div class="col-md-6">

                        <select name="product_id" class="form-control  " onchange="return get_sale_data(this.value);" id="product_id" required>
                            <option value="">Select Product</option>
                            <?php foreach ($product as $product) : ?>
                                <option value=<?php echo $product->id; ?>><?php echo $product->product_name; ?></option>
                            <?php endforeach ?>
                        </select>

                    </div>
                    <div class="col-md-6">
                        <div class="text-center text-lg-right">
                            <div class="form-group">

                                <a href="<?php echo base_url(); ?>sale/viewSale" class="btn btn-primary m-2 m-sm-0 px-5"><i class="fa fa-file"></i><span class="font-weight-bold"> All Sales</span></a>
                                <a href="<?php echo base_url(); ?>sale/viewSale" class="btn btn-success m-2 m-sm-0 px-5"><i class="fa fa-file-pdf"></i><span class="font-weight-bold"> Last Bill</span></a>

                                <!-- <button type="reset" class="btn btn-warning text-light m-2 m-sm-0 px-5"><i class="fa fa-trash text-danger"></i><span class="font-weight-bold">Cancel</span></button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="data_table">
                                <thead>
                                    <tr class="text-center">
                                        <th>Product Name</th>
                                        <th>Expiry</th>
                                        <th>Stock QTY</th>
                                        <th>QTY</th>
                                        <th>Price</th>
                                        <th>Dis(%)</th>
                                        <th>Dis(&#8377;)</th>
                                        <th>Total</th>

                                </thead>
                                <tbody>

                                    <input type="hidden" name="total_items_added" value="<?php echo count(array($saleproduct)); ?>">
                                    <?php
                                    $count = 0;

                                    foreach ((array) $saleproduct as $rows) {
                                        ++$count;
                                    ?>

                                        <tr id="entry_row_<?= $count; ?>">
                                            <input type="hidden" name="product_id[]" value="<?php echo $rows->id; ?>">
                                            <td class="text-center"><?php echo $rows->product_name; ?></td>

                                            <td class="text-center"><input type="text" name="stock_quantity[]" readonly="readonly" id="stock_quantity_<?= $count; ?>" class="form-control text-center input-number p-0 m-0" style="width:100px; height:30px;" onkeyup="stock_quantity_(<?= $count; ?>)" value="<?php echo $rows->stock_quantity; ?>"></td>

                                            <td class="text-center"><input type="number" name="quantity[]" min="1" id="quantity_<?= $count; ?>" tabindex="1" class="form-control text-center input-number p-0 m-0" style="width:50px; height:30px;" onkeyup="calculate_single_entry_sum(<?= $count; ?>)" value="<?php echo $rows->sales_qty; ?>" onchange="calculate_single_entry_sum(<?= $count; ?>)" required></td>
                                            <td class="text-center"><input type="text" name="unit_price[]" readonly="readonly" id="unit_price_<?= $count; ?>" class="form-control text-center input-number p-0 m-0" style="width:100px; height:30px;" value="<?php echo $rows->product_price; ?>"></td>
                                            <td class="text-center"><input type="number" name="discount1[]" min="0" id="discount_<?= $count; ?>" tabindex="1" min="0" class="form-control text-center input-number p-0 m-0" style="width:50px; height:30px;" onkeyup="calculate_single_entry_sum(<?= $count; ?>)" value="<?php echo $rows->product_discount_percent; ?>" onchange="calculate_single_entry_sum(<?= $count; ?>)"></td>
                                            <td class="text-center"><input type="number" name="discount2[]" min="0" id="discount2_<?= $count; ?>" tabindex="1" min="0" class="form-control text-center input-number p-0 m-0" style="width:50px; height:30px;" onkeyup="calculate_single_entry_sum(<?= $count; ?>)" value="<?php echo $rows->product_discount_amount; ?>" onchange="calculate_single_entry_sum(<?= $count; ?>)"></td>

                                            <td class="text-center"><input type="text" name="sales_amount[]" readonly="readonly" id="single_entry_total_<?= $count; ?>" class="form-control text-center input-number p-0 m-0 subtot" style="width:100px; height:30px;" value="<?php echo $rows->sales_amount; ?>"></td>

                                        </tr>

                                    <?php   } ?>


                                </tbody>


                                <tfoot style="">
                                    <tr style="border-top-style:double;">
                                        <td colspan="7" class="text-right font-weight-bold">Product Total</td>
                                        <td class="text-center" id="grand_totalnew"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="container mt-4" id="bill">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row p-5 m-lg-5">
                                <div class="col-6 p-2 text-center border">
                                    <h4 class="font-weight-bold">Total</h4>
                                    <hr>
                                    <h3 class="text-danger">
                                        <input type="text" class="form-control border-0 text-center text-danger" name="sub_total" style="font-size:25px;" value="" id="sub_total" readonly>
                                    </h3>
                                </div>
                                <div class="col-6 p-2 text-center border">
                                    <h4 class="font-weight-bold">Discount</h4>
                                    <hr>
                                    <h3 class="text-danger">
                                        <input type="text" class="form-control border-0 text-center text-success" name="discount_total" style="font-size:25px;" value="" id="discount" readonly>
                                    </h3>
                                </div>
                                <div class="col-6 p-2 text-center border">
                                    <h4 class="font-weight-bold">Due</h4>
                                    <hr>
                                    <h3 class="text-danger">
                                        <input type="text" class="form-control border-0 text-center text-success" name="due_amount" style="font-size:25px;" value="" id="due_amount" readonly>
                                    </h3>
                                </div>
                                <div class="col-6 p-2 text-center border">
                                    <h4 class="font-weight-bold">Round</h4>
                                    <hr>
                                    <h3 class="text-danger">
                                        <input type="text" class="form-control border-0 text-center text-danger" name="net_payment" style="font-size:25px;" value="" id="net_payment" readonly>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div class="row">
                                <div class="col-4 mt-2">
                                    Discount all items(%):
                                </div>
                                <div class="col-4">
                                    <!-- <input type="text" value="0.00" class="form-control"> -->
                                    <h3 class="text-danger">
                                        <input type="number" class="form-control text-center text-success" style="font-size:15px;" name="round_discount" maxlength="2" min="0" id="round_discount" onchange="calculate_round_total(this.value, 'round_discount');">
                                    </h3>
                                </div>
                                <!-- <div class="col-2">
                                    <button class="btn btn-success">Save</button>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-danger">Clear</button>
                                </div> -->
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <h6>Select your payment methods</h6>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <input name="payment_method" onchange="funR1(this);" class="payment_method" value="Cash" type="checkbox" id="radio_1" />

                                            <label style="font-size: 12pt;" for="radio_1">Cash</label>

                                            <div class="row clearfix mt-2 mb-3" id="cashpayDiv" style="display:none;">
                                                <div class="col-sm-12">

                                                    <input type="number" min="0" name="payment_cash" autocomplete="off" id="cashpay" placeholder="Cash" value="" class="form-control common" onkeyup="CheckPayment(); ResetPay();">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-4">
                                            <input name="payment_method" onchange="funR2(this);" class="payment_method" value="Debit Card" type="checkbox" id="radio_2" />

                                            <label style="font-size: 12pt;" for="radio_2">Debit Card</label>

                                            <div class="row clearfix mt-2 mb-3" id="debitpayDiv" style="display:none;">
                                                <div class="col-sm-12">
                                                    <input type="number" min="0" name="payment_debit_card" autocomplete="off" id="debitpay" placeholder="Debit Card" value="" class="form-control common" onkeyup="CheckPayment(); ResetPay();">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <input name="payment_method" onchange="funR3(this);" class="payment_method" value="Credit Card" type="checkbox" id="radio_3" />

                                            <label style="font-size: 12pt;" for="radio_3">Credit Card</label>

                                            <div class="row clearfix mt-2 mb-3" id="creditpayDiv" style="display:none;">
                                                <div class="col-sm-12">
                                                    <input type="number" min="0" name="payment_credit_card" autocomplete="off" id="creditpay" placeholder="Credit Card" value="" class="form-control common" onkeyup="CheckPayment(); ResetPay();">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <input name="payment_method" onchange="funR4(this);" class="payment_method" value="UPI" type="checkbox" id="radio_4" />

                                            <label style="font-size: 12pt;" for="radio_4">UPI</label>

                                            <div class="row clearfix mt-2 mb-3" id="upipayDiv" style="display:none;">
                                                <div class="col-sm-12">
                                                    <input type="number" min="0" name="payment_upi" autocomplete="off" id="upipay" placeholder="UPI" value="" class="form-control common" onkeyup="CheckPayment(); ResetPay();">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <input name="payment_method" onchange="funR5(this);" class="payment_method" value="Cheque" type="checkbox" id="radio_5" />

                                            <label style="font-size: 12pt;" for="radio_5">Cheque</label>

                                            <div class="row clearfix mt-2 mb-3" id="chequepayDiv" style="display:none;">
                                                <div class="col-sm-12">
                                                    <input type="number" min="0" name="payment_cheque" autocomplete="off" id="chequepay" placeholder="Cheque" value="" class="form-control common" onkeyup="CheckPayment(); ResetPay();">

                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="col-lg-12 mt-3">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5>Total Paid Amount :</h5>
                                                    <p>(combining all payment mode)</p>

                                                </div>
                                                <div class="col-6">

                                                    <h3 class="text-danger">
                                                        <input type="text" class="form-control border-0 text-center text-danger" name="paymentTotal" style="font-size:25px;" onchange="calculate_change_amount()" value="0" id="payment" readonly>
                                                    </h3>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-3">
                                            <div class="row">
                                                <div class="col-9">
                                                    <h5>Note : Customer ledger will be auto generated if the customer have not paid full amount</h5>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Auto Fill Current Date -->
                                        <?php

                                        $month = date('m');
                                        $day = date('d');
                                        $year = date('Y');
                                        $today = $year . '-' . $month . '-' . $day;

                                        ?>
                                        <!-- Auto Fill Current Date -->

                                        <div class="col-lg-12 mt-3">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="">Manual Invoice Id</label>
                                                    <input type="text" class="form-control" placeholder="Enter invoice id">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="">Manual Date</label>
                                                    <input type="date" name="sales_date" value="<?php echo $today; ?>" id="date" class="form-control">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-5">
                        <div class="text-right">
                            <button class="btn btn-success" type="submit">Submit Bill</button>
                            <!-- <a href="" class="btn btn-danger px-5" onclick="funBill()">Submit Bill</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Script For all calculation Begin --  --> -->
<script>
    $(document).ready(function() {
        calculate_grand_total_for_purchase()

    });

    $(document).ready(function() {
        calculate_round_total()

    });

    $(document).ready(function() {
        balance_total()

    });

    $(document).ready(function() {
        calculate_change_amount()

    });
    var total_amount = 0;
    var tot = 0;
    var total_number = 0;

    function get_sale_data(product_id) {
        total_number++;
        var csrf_test_name = $("input[name=csrf_test_name]").val();
        $.ajax({
            url: '<?= base_url(); ?>sale/get_data_for_sale/',
            type: 'POST',
            data: {
                'id': product_id,
                'total': total_number,
                'csrf_test_name': csrf_test_name
            },
            dataType: 'html',
            success: function(response) {

                $('#purchase_entry_holder').append(response);

                calculate_grand_total_for_purchase();


            }
        });
    }

    // single Row product calculation functionality Begin
    function calculate_single_entry_sum(entry_number) {

        var quantity = $("#quantity_" + entry_number).val();
        var discount = $("#discount_" + entry_number).val();
        var discount2 = $("#discount2_" + entry_number).val();

        var purchase_price = $("#unit_price_" + entry_number).val();
        var single_entry_total = (quantity * purchase_price) - ((quantity * purchase_price) / 100 * discount) - (discount2);
        $("#single_entry_total_" + entry_number).val(single_entry_total);
        calculate_grand_total_for_purchase();
        calculate_round_total();
        calculate_change_amount();
        balance_total();

    }

    // Single Row product calculation functionality End


    // Calculate Grand Total Combining all products Begin
    function calculate_grand_total_for_purchase() {

        grand_total = 0;
        for (var i = 1; i <= total_number; i++) {
            grand_total += Number($("#single_entry_total_" + i).val());

        }
        total_amount = grand_total;
        tot = grand_total;
        $("#grand_totalnew").html(grand_total);
        $("#hidden_total").val(grand_total);
        $("#sub_total").val(grand_total);
        $("#net_payment").val(grand_total);
        $("#items").html(total_number);

    }

    // Calculate Grand Total Combining all products End

    // Calculate Round Total For Sale Begin

    function calculate_round_total(value, type) {


        var round_discount = Number($('#round_discount').val()) || 0;

        let answer = total_amount - (round_discount / 100 * total_amount).toFixed(2);
        var discount = (round_discount * (total_amount / 100)).toFixed(2);
        $("#net_payment").val(answer);

        $("#discount").val(discount);

        calculate_change_amount();
        balance_total();

    }

    // Calclulate Round total for sale End


    //Change amount functionality Begin

    function calculate_change_amount() {

        get_grand_total = Number($("#net_payment").val());
        get_payment_amount = Number($("#payment").val());

        if (get_payment_amount > get_grand_total) {

            change_amount = get_payment_amount - get_grand_total;
            change_amount = change_amount.toFixed(2);
            $("#change_amount").attr("value", change_amount);
            get_change_amount = Number($("#change_amount").val());
            net_payable = get_payment_amount - get_change_amount;
            net_payable = net_payable.toFixed(2);
            $("#net_payment").attr("value", net_payable);
            $("#due_amount").attr("value", 0);
        }

        if (get_payment_amount < get_grand_total) {

            $("#change_amount").attr("value", 0);
            $("#net_payment").attr("value", get_payment_amount);
            get_due_amount = get_grand_total - get_payment_amount;
            get_due_amount = get_due_amount.toFixed(2);
            $("#due_amount").attr("value", get_due_amount);
        }

        if (get_payment_amount == get_grand_total) {

            $("#change_amount").attr("value", 0);
            $("#net_payment").attr("value", get_payment_amount);
            $("#due_amount").attr("value", 0);
        }
    }

    // Change amount functionality End

    // Delete Row functionality Begin
    function delete_row(entry_number) {

        $("#entry_row_" + entry_number).remove();

        for (var i = entry_number; i < total_number; i++) {

            $("#serial_" + (i + 1)).attr("id", "serial_" + i);
            $("#serial_" + (i)).html(i);

            $("#quantity_" + (i + 1)).attr("id", "quantity_" + i);
            $("#quantity_" + (i)).attr({
                onkeyup: "calculate_single_entry_sum(" + i + ")",
                onclick: "calculate_single_entry_sum(" + i + ")"

            });



            $("#unit_price_" + (i + 1)).attr("id", "unit_price_" + i);
            $("#unit_price_" + (i)).attr({
                onkeyup: "calculate_single_entry_sum(" + i + ")",
                onclick: "calculate_single_entry_sum(" + i + ")",

            });

            $("#delete_button_" + (i + 1)).attr("id", "delete_button_" + i);
            $("#delete_button_" + (i)).attr("onclick", "delete_row(" + i + ")");

            $("#entry_row_" + (i + 1)).attr("id", "entry_row_" + i);
        }

        total_number--;
        calculate_grand_total_for_purchase();
    }

    // Delete Row functionality End

    // Total Payment Combining all payment method Begin

    $('.common').change(function() {
        $('#payment').val(parseFloat("0" + $('#cashpay').val()) + parseFloat("0" + $('#debitpay').val()) + parseFloat("0" + $('#creditpay').val()) + parseFloat("0" + $('#upipay').val()) + parseFloat("0" + $('#chequepay').val())).change();
    });


    // Total payment method combing all payment method End
</script>

<!-- Calculation End -->

<script type="text/javascript">
    function funR1(checkbox) {

        var textDiv = document.getElementById("cashpayDiv");

        textDiv.style.display = checkbox.checked ? "block" : "none";

        $('#cashpay').focus();

    }

    function funR2(checkbox) {

        var textDiv = document.getElementById("debitpayDiv");

        textDiv.style.display = checkbox.checked ? "block" : "none";

        $('#debitpay').focus();

    }

    function funR3(checkbox) {

        var textDiv = document.getElementById("creditpayDiv");

        textDiv.style.display = checkbox.checked ? "block" : "none";

        $('#creditpay').focus();

    }

    function funR4(checkbox) {

        var textDiv = document.getElementById("upipayDiv");

        textDiv.style.display = checkbox.checked ? "block" : "none";

        $('#upipay').focus();

    }

    function funR5(checkbox) {

        var textDiv = document.getElementById("chequepayDiv");

        textDiv.style.display = checkbox.checked ? "block" : "none";

        $('#chequepay').focus();

    }

    function funBill() {

        document.getElementById("bill").style.display = "block";

    }
</script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
    $(document).ready(function() {

        var quantitiy = 0;
        $('.quantity-right-plus').click(function(e) {

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            $('#quantity').val(quantity + 1);


            // Increment

        });

        $('.quantity-left-minus').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            // Increment
            if (quantity > 0) {
                $('#quantity').val(quantity - 1);
            }
        });

    });
</script>

<script>
    $(document).ready(function() {

        var quantitiyTwo = 0;
        $('.quantity-right-plus-two').click(function(e) {

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantityTwo').val());

            // If is not undefined

            $('#quantity').val(quantityTwo + 1);


            // Increment

        });

        $('.quantity-left-minus-two').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantityTwo').val());

            // If is not undefined

            // Increment
            if (quantity > 0) {
                $('#quantity').val(quantityTwo - 1);
            }
        });

    });
</script>

<!-- Select2 Script -->

<script>
    $('.select2').select2();
</script>