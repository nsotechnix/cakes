<?php
$start = microtime(true);
?>
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">

    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <!--begin::Portlet-->
        <?php $this->load->view('messages'); ?>
        <h5>Search by ID</h5>
        <br />
        <div class="row">
            <div class="col-sm-4">
                <input type="text" placeholder="Enter ID (*)" name="rootEpin" id="rootEpin" class="form-control" value="<?= $this->uri->segment(3); ?>">
            </div>
            <div class="col-sm-4">
                <input type="text" placeholder="Enter Coupon Code" name="coupon" id="coupon" class="form-control" value="<?= $this->uri->segment(4); ?>">
            </div>
            <div class="col-sm-4">
                <button name="purchase" id="purchase" class="btn btn-info">Purchase</button>
            </div>
        </div>
        <br />
        <?php if ($this->uri->segment(3)) { ?>
            <form action="" class="needs-validation" novalidate method="post">
                <div class="wide-block pt-3">
                    <input type="hidden" name="rootEpin" class="form-control" value="<?= $this->uri->segment(3); ?>">
                    <input type="hidden" name="coupon" class="form-control" value="<?= $this->uri->segment(4); ?>">
                    <div class="row">
                        <div class="col-md-6" id="comboBox">
                            <div class="form-group">
                                <label for="">Choose combo</label>
                                <select name="comboCode" id="comboCode" class="form-control" onchange="selectCombo()" required>
                                    <option value="" selected disabled>--select combo--</option>
                                    <?php foreach ($COMBOS as $combo) { ?>
                                        <option value="<?= $combo->combo_code; ?>"><?= $combo->combo_code; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="deliveryTypeBox">
                            <div class="form-group">
                                <label for="">Delivery type</label>
                                <select name="deliveryType" id="deliveryType" class="form-control" required>
                                    <option value="Home Delivery">Home Delivery</option>
                                    <option value="Take away">Take away</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span id="comboResults"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <fieldset>
                                <center>
                                    <b><span>Total Amount: &#8377;<span id="totalAmount">0</span></span><br /></b>
                                    <b><span>Coupon discount: &#8377;<span id="couponDiscount">0</span></span><br /></b>
                                    <b><span>Grand Total: &#8377;<span id="pay">0</span></span></b>
                                    <br />
                                    <br />
                                    <button type="submit" name="repurchaseMe" class="btn btn-success">Repurchase</button>
                                </center>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        <?php } ?>
    </div>
</div>

<script>
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()

    $(document).on('click', '#purchase', function(e) {
        let rootEpin = $('#rootEpin').val()
        let coupon = $('#coupon').val()
        if (rootEpin == '') {
            alert('Please enter ID')
        } else {
            window.location.assign('<?= base_url('dashboard/purchase/'); ?>' + rootEpin + '/' + coupon)
        }
    });

    const offerUpdate = (elem) => {
        if ($(elem).val() == 'COMBO') {
            $('#comboBox').removeAttr('hidden', true)
            $('#comboCode').attr('required', true)
            $('#deliveryTypeBox').removeAttr('hidden', true)
            $('#deliveryType').attr('required', true)
        } else if ($(elem).val() == 'COUPON') {
            $('#comboBox').attr('hidden', true)
            $('#comboCode').removeAttr('required', true)
                .val('')
                .change()
            $('#deliveryTypeBox').attr('hidden', true)
            $('#deliveryType').removeAttr('required', true)
                .val('')
                .change()
        }
    };

    const selectCombo = () => {
        let val = $('#comboCode :selected').val()
        let coupon = $('#coupon').val()
        $('#comboResults').html('loading...')
        $.ajax({
            url: '<?= base_url('dashboard/getComboDetails'); ?>',
            method: 'post',
            dataType: 'json',
            data: {
                comboCode: val
            },
            success: function(response) {
                $('#comboResults').html(response.results)
                if (coupon == '') {
                    $('#totalAmount').html(String(response.totalAmount))
                    $('#pay').html(String(response.totalAmount))
                } else {
                    $('#totalAmount').html(String(response.totalAmount))
                    $('#couponDiscount').html(100)
                    $('#pay').html(Number(response.totalAmount) - 100)
                }
            }
        })
    };
</script>