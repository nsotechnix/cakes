<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <?php $this->load->view('messages'); ?>
        <h5 class="hk-sec-title">MANAGE ACTIVE CASHIERS</h5>
        <div class="row">
            <div class="col-sm">
                <div class="table-wrap">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Store</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>DOB</th>
                                <th>Gender</th>
                                <th>Blood Group</th>
                                <th>PAN</th>
                                <th>PAN Image</th>
                                <th>Bank Details</th>
                                <th>Passbook Image</th>
                                <th>Current Address</th>
                                <th>Permanent Address</th>
                                <th>Joined date</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($CASHIERS as $cashier) {

                                $store_name = $this->Crud->Ciread('store', "`store_id`=$cashier->store_id")
                            ?>
                                <tr>
                                    <td><?php echo ++$i ?></td>
                                    <td><?php echo $store_name[0]->store_name; ?></td>

                                    <td><?php echo $cashier->name; ?></td>
                                    <td><?php echo $cashier->email; ?></td>
                                    <td><?php echo $cashier->phone; ?></td>
                                    <td><?php echo $cashier->dob; ?></td>
                                    <td><?php echo $cashier->gender; ?></td>
                                    <td><?php echo $cashier->blood_group; ?></td>
                                    <td><?php echo $cashier->pan; ?></td>
                                    <td><a href="#" target="_BLANK"><img src="<?php echo base_url('uploads/cashier/' . $cashier->pan_proof) ?>" alt="image" style="height: 100px; width: 100px;" /></a></td>
                                    <td>
                                        Bank Name: <?php echo $cashier->bank_name; ?><br />
                                        Account Number: <?php echo $cashier->account_number; ?><br />
                                        IFSC: <?php echo $cashier->ifsc; ?><br />
                                        Account Holder Name: <?php echo $cashier->payee_name; ?>
                                    </td>
                                    <td><a href="#" target="_BLANK"><img src="<?php echo base_url('uploads/cashier/' . $cashier->bank_proof) ?>" alt="image" style="height: 100px; width: 100px;" /></a></td>
                                    <td><?php echo $cashier->address; ?></td>
                                    <td><?php echo $cashier->present_address; ?></td>

                                    <td><?php echo $cashier->added_date . ' - ' . $cashier->added_time; ?></td>
                                    <td>Not Fetch</td>
                                    <td><?php echo ($cashier->is_active == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('cashier/edit/' . $cashier->id); ?>" class="btn btn-info btn-xs">Edit</a>

                                        <?php if ($cashier->is_active == 1) { ?>
                                            <a href="<?php echo site_url('cashier/block_cashier/' . $cashier->id); ?>" class="btn btn-danger btn-xs">Inactive</a>
                                        <?php } else { ?>
                                            <a href="<?php echo site_url('cashier/unblock_cashier/' . $cashier->id); ?>" class="btn btn-success btn-xs">Active</a>
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