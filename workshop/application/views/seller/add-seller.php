<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <?php $this->load->view('messages'); ?>
        <h5 class="hk-sec-title">ADD NEW VENDOR</h5>
        <p class="mb-25">Email will be used to login for vendor.</p>
        <div class="row">
            <div class="col-sm">
                <form autocomplete="off" class="needs-validation" novalidate action="<?php echo site_url('seller/addSeller'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label mb-10" for="exampleInputuname_1">Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="name" id="exampleInputuname_1" placeholder="Full name" required>
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
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail_1" placeholder="Enter email">
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
                                    <input type="text" class="form-control" name="phone" maxlength="10" pattern="[6789][0-9]{9}" id="phone" placeholder="Enter contact number" required>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label mb-10" for="password">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label mb-10" for="confirmPassword">Confirm Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" onchange="checkPassword(this.value, this);" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label mb-10" for="address">Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-location-pin"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Enter seller address" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" class="form-control" name="account_number" placeholder="Enter Account Number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>IFSC</label>
                                <input type="text" class="form-control" placeholder="Enter IFSC" name="ifsc" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Bank Name</label>
                                <input type="text" class="form-control" id="" placeholder="Enter bank name" name="bank_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Payee Name</label>
                                <input type="text" class="form-control" name="payee_name" id="" placeholder="Enter payee name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-last">
                                <label for="exampleTextarea">PAN Card</label>
                                <input type="text" pattern="[a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}" maxlength="10" class="form-control" name="pan" id="" placeholder="Enter PAN" required>
                                <input type="file" class="form-control mt-1" name="pan_proof" id="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" id="dob" onchange="checkDOB(this)" required>
                            </div>
                        </div>
                    </div>


                    <button type="submit" name="submit" class="btn btn-primary mr-10">Save &amp; Proceed</button>
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
            alert("Distributor needs to be 18 years or older in order to registration.",)
            $(elem).val('')
        }
    }

    function _calculateAge(birthday) {
        var ageDifMs = Date.now() - birthday.getTime();
        var ageDate = new Date(ageDifMs);
        return Math.abs(ageDate.getUTCFullYear() - 1970);
    }
</script>