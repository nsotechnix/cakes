        <!-- begin:: Content -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
            <?php $this->load->view('messages'); ?>
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <form class="kt-form needs-validation" enctype="multipart/form-data" novalidate method="post" action="<?php echo site_url('kyc/kycUpdate'); ?>">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ID</label>
                                    <input type="text" class="form-control" name="epin" placeholder="Enter ID" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="account_number" placeholder="Enter Account Number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>IFSC</label>
                                    <input type="text" class="form-control" placeholder="Enter IFSC" name="ifsc" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Bank Name</label>
                                    <input type="text" class="form-control" id="" placeholder="Enter bank name" name="bank_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Payee Name</label>
                                    <input type="text" class="form-control" name="payee_name" id="" placeholder="Enter payee name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Branch Name</label>
                                    <input type="text" class="form-control" name="branch_name" id="" placeholder="Enter branch name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">PAN</label>
                                    <input type="text" class="form-control" pattern="[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}" maxlength="10" name="pan" id="" placeholder="Enter Permanent Identification Number" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <button type="submit" name="update" id="update" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
        <!--end::Portlet-->
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
        </script>