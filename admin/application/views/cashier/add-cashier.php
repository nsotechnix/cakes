<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <?php $this->load->view('messages'); ?>
        <h5 class="hk-sec-title">ADD NEW CASHIER</h5>
        <p class="mb-25">Email will be used to login for Cashier.</p>
        <div class="row">
            <div class="col-sm">
                <form autocomplete="off" class="needs-validation" novalidate action="<?php echo site_url('cashier/addCashier'); ?>" method="post" enctype="multipart/form-data">
                    <h4 class="mt-3">Store Details</h4>
                    <hr>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Select Store</label>
                            <select name="store_id" id="" class="form-control">
                                <option value="" selected disabled>Select Store</option>
                                <?php foreach ($STORES as $key) { ?>
                                    <option value="<?php echo $key->store_id; ?>"><?php echo $key->store_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <h4 class="mt-3">Personal Details</h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label mb-10" for="exampleInputuname_1">Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="exampleInputuname_1" placeholder="Full name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label mb-10" for="exampleInputEmail_1">Email address</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail_1" placeholder="Enter email" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label mb-10" for="phone">Contact</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="phone" maxlength="10" pattern="[6789][0-9]{9}" id="phone" placeholder="Enter contact number" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" id="dob" onchange="checkDOB(this)" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Gender</label>
                                <select name="gender" class="form-control" id="gender">
                                    <option value="" selected disabled>Select your gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Blood Group</label>
                                <select name="blood_group" class="form-control" id="blood">
                                    <option value="" selected disabled>Select your blood group</option>
                                    <option value="O positive">O positive</option>
                                    <option value="O negative">O negative</option>
                                    <option value="A positive">A positive</option>
                                    <option value="A negative">A negative</option>
                                    <option value="B positive">B positive</option>
                                    <option value="B negative">B negative</option>
                                    <option value="AB positive">AB positive</option>
                                    <option value="AB negative">AB negative</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <h4>Contact Details</h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label mb-10" for="address">Current Address</label>
                                <div class="input-group">
                                    <textarea type="text" class="form-control" name="present_address" id="staff_permenent_address" placeholder="Enter cashier current address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label mb-10" for="address">Permanent Address</label>
                                <div class="input-group">
                                    <textarea type="text" class="form-control" name="address" id="staff_present_address" placeholder="Enter cashier permanent address" required></textarea>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="homepostalcheck">
                                    <label class="form-check-label" for="exampleCheck1">Same as current address</label>
                                </div>
                            </div>
                        </div>
                    </div>




                    <h4>Upload KYC</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" class="form-control" name="account_number" placeholder="Enter Account Number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>IFSC</label>
                                <input type="text" class="form-control" placeholder="Enter IFSC" name="ifsc">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Bank Name</label>
                                <input type="text" class="form-control" id="" placeholder="Enter bank name" name="bank_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Payee Name</label>
                                <input type="text" class="form-control" name="payee_name" id="" placeholder="Enter payee name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-last">
                                <label for="exampleTextarea">Upload Passbook</label>
                                <input type="file" class="form-control mt-1" name="bank_proof" id="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-last">
                                <label for="exampleTextarea">PAN Card</label>
                                <input type="text" pattern="[a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}" maxlength="10" class="form-control" name="pan" id="" placeholder="Enter PAN">
                                <input type="file" class="form-control mt-1" name="pan_proof" id="">
                            </div>
                        </div>

                    </div>



                    <h4>Create Account</h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label mb-10" for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label mb-10" for="confirmPassword">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" onchange="checkPassword(this.value, this);" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="text-right">
                            <button type="submit" name="submit" class="btn btn-primary mr-10">Save &amp; Proceed</button>
                            <button type="reset" class="btn btn-warning">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/js/address.js') ?>"></script>
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


    function setstaff_present_address() {
        if ($("#homepostalcheck").is(":checked")) {
            $('#staff_present_address').val($('#staff_permenent_address').val());
            $('#staff_present_address').attr('enable', 'enable');
        } else {
            $('#staff_present_address').removeAttr('enable');
        }
    }

    $('#homepostalcheck').click(function() {
        setstaff_present_address();
    })
</script>