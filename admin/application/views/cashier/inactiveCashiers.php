<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <?php $this->load->view('messages'); ?>
        <h5 class="hk-sec-title">MANAGE INACTIVE CASHIERS</h5>
        <div class="row">
            <div class="col-sm">
                <div class="table-wrap">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Joined date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($CASHIERS as $cashier) {
                            ?>
                                <tr>
                                    <td><?php echo $cashier->id; ?></td>
                                    <td><?php echo $cashier->name; ?></td>
                                    <td><?php echo $cashier->email; ?></td>
                                    <td><?php echo $cashier->phone; ?></td>
                                    <td><?php echo $cashier->address; ?></td>

                                    <td><?php echo $cashier->added_date . ' - ' . $cashier->added_time; ?></td>
                                    <td><?php echo ($cashier->is_active == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('cashier/edit/' . $cashier->id); ?>" class="btn btn-info btn-xs">Edit</a>

                                        <?php if ($cashier->is_active == 1) { ?>
                                            <a href="<?php echo site_url('cashier/changeStatus/cashier/0/' . $cashier->id); ?>" class="btn btn-danger btn-xs">Inactive</a>
                                        <?php } else { ?>
                                            <a href="<?php echo site_url('cashier/changeStatus/cashier/1/' . $cashier->id); ?>" class="btn btn-success btn-xs">Active</a>
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