<?php

foreach ($SELLER_DETAILS as $seller) {

    $thisId = $seller->id;
    $name = $seller->name;
    $email = $seller->email;
    $phone = $seller->phone;
    $address = $seller->address;
}

?>
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <?php $this->load->view('messages'); ?>
        <h5 class="hk-sec-title">EDIT SELLER: <?php echo strtoupper($name); ?></h5>
        <!-- <p class="mb-25">Place an icon inside add-on on either side of an input. You may also place one on right side of an input.</p> -->
        <div class="row">
            <div class="col-sm">
                <form autocomplete="off" class="needs-validation" novalidate action="<?php echo site_url('seller/editSeller/' . $this->uri->segment(3)); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="thisId" value="<?php echo $thisId; ?>">

                    <div class="row">
                        <div class="col-sm-4">

                            <div class="form-group">
                                <label class="control-label mb-10" for="exampleInputuname_1">Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="name" id="exampleInputuname_1" value="<?php echo $name; ?>" placeholder="Full name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label mb-10" for="exampleInputEmail_1">Email address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-envelope-open"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail_1" value="<?php echo $email; ?>" placeholder="Enter email">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label mb-10" for="phone">Contact</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-envelope-open"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" maxlength="10" pattern="[6789][0-9]{9}" id="phone" placeholder="Enter contact number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label mb-10" for="address">Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-location-pin"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo $address; ?>" name="address" id="address" placeholder="Enter seller address" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" class="form-control" name="account_number" value="<?php echo $SELLER_DETAILS[0]->account_number; ?>" placeholder="Enter Account Number" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>IFSC</label>
                                <input type="text" class="form-control" placeholder="Enter IFSC" value="<?php echo $SELLER_DETAILS[0]->ifsc; ?>" name="ifsc" required>
                            </div>
                        </div>
                    </div>



                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Bank Name</label>
                                <input type="text" class="form-control" id="" placeholder="Enter bank name" value="<?php echo $SELLER_DETAILS[0]->bank_name; ?>" name="bank_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Payee Name</label>
                                <input type="text" class="form-control" name="payee_name" value="<?php echo $SELLER_DETAILS[0]->payee_name; ?>" id="" placeholder="Enter payee name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-last">
                                <label for="exampleTextarea">PAN Card</label>
                                <input type="text" pattern="[a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}" maxlength="10" class="form-control" name="pan" id="" placeholder="Enter PAN" required value="<?php echo $SELLER_DETAILS[0]->pan; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" id="dob" onchange="checkDOB(this)" required value="<?php echo $SELLER_DETAILS[0]->dob; ?>">
                            </div>
                        </div>
                    </div>



                    <button type="submit" name="submit" class="btn btn-primary mr-10">Save Changes</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
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

    function checkPassword(val, elem) {
        if (val == $('#password').val()) {
            return true;
        } else {
            $(elem).val('');
            alert('Passwords not matching');
            $(elem).focus();
        }
    }

    function getPincodes(elem, val) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("getPincodes"); ?>',
            dataType: 'text',
            data: {
                'district_id': val
            },
            success: function(data) {
                $('#pincodesDiv').html(data)
            }
        });
    }


    const checkDOB = (elem) => {
        let dob = $(elem).val()
        if (_calculateAge(new Date(dob)) < 18) {
            alert("Distributor needs to be 18 years or older in order to registration.", )
            $(elem).val('')
        }
    }

    function _calculateAge(birthday) {
        var ageDifMs = Date.now() - birthday.getTime();
        var ageDate = new Date(ageDifMs);
        return Math.abs(ageDate.getUTCFullYear() - 1970);
    }
</script>