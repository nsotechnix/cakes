<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <?php $this->load->view('messages'); ?>
        <h5 class="hk-sec-title">MANAGE ACTIVE VENDORS</h5>
        <div class="row">
            <div class="col-sm">
                <div class="table-wrap">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                            <tr>
                                <th>Vendor ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>PAN</th>
                                <th>Bank Details</th>
                                <th>DOB</th>
                                <th>Address</th>
                                <th>Joined date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($SELLERS as $seller) {
                            ?>
                                <tr>
                                    <td><?php echo $seller->id; ?></td>
                                    <td><?php echo $seller->name; ?></td>
                                    <td><?php echo $seller->email; ?></td>
                                    <td><?php echo $seller->phone; ?></td>
                                    <td><?php echo $seller->pan; ?></td>
                                    <td>
                                    Bank Name: <?php echo $seller->bank_name; ?><br />
                                    Account Number: <?php echo $seller->account_number; ?><br />
                                    IFSC: <?php echo $seller->ifsc; ?><br />
                                    Account Holder Name: <?php echo $seller->payee_name; ?>
                                    </td>
                                    <td><?php echo $seller->dob; ?></td>
                                    <td><?php echo $seller->address; ?></td>

                                    <td><?php echo $seller->added_date . ' - ' . $seller->added_time; ?></td>
                                    <td><?php echo ($seller->is_active == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('seller/edit/' . $seller->id); ?>" class="btn btn-info btn-xs">Edit</a>

                                        <?php if ($seller->is_active == 1) { ?>
                                            <a href="<?php echo site_url('seller/changeStatus/seller/0/' . $seller->id); ?>" class="btn btn-danger btn-xs">Inactive</a>
                                        <?php } else { ?>
                                            <a href="<?php echo site_url('seller/changeStatus/seller/1/' . $seller->id); ?>" class="btn btn-success btn-xs">Active</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('change', '.sellerBadge', function(e) {
        let selectedValue = $(this).val()
        let seller = $(this).data('seller')
        if (confirm('Are you sure want to change badge for this seller?')) {
            $.ajax({
                url: '<?php echo site_url('seller/changeSellerBadge'); ?>',
                dataType: 'text',
                method: 'post',
                data: {
                    val: selectedValue,
                    id: seller
                },
                success: function(data) {
                    alert(data)
                }
            });
        }
    });
</script>