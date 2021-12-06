<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <?php $this->load->view('messages'); ?>
        <h5 class="hk-sec-title">Active Notifications</h5>
        <div class="row">
            <div class="col-sm">
                <div class="table-wrap">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Show until</th>
                                <th>Location</th>
                                <th>Added on</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($NOTIFICATIONS as $notification) {
                            ?>
                                <tr>
                                    <td><?php echo $notification->id; ?></td>
                                    <td><?php echo $notification->notification; ?></td>
                                    <td><?php echo $notification->show_until; ?></td>
                                    <td><?php echo $notification->added_date . ' - ' . $notification->added_time; ?></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td><a href="<?php echo site_url('notifications/disableNotification/' . $notification->id); ?>" class="btn btn-info btn-xs">Disable</a>
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