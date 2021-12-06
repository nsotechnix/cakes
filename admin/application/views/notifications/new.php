<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <?php $this->load->view('messages'); ?>
        <div class="hk-pg-header">
            <h5 class="hk-pg-title">Add new Notification</h5>
        </div>
        <form method="post" autocomplete="off" action="<?php echo site_url('notifications/insertNotification'); ?>">
            <div class="row">
                <div class="col-xl-4">
                    <label for="notification">Notification (*)</label>
                    <input type="text" name="notification" class="form-control" placeholder="Notification" id="notification" required>
                </div>

                <div class="col-xl-4">
                    <label for="show_until">Show Until (*)</label>
                    <input type="date" min="<?php echo date('Y-m-d'); ?>" name="show_until" class="form-control" id="show_until" required>
                </div>
            </div><br />
            <div class="row">
                <div class="col-xl-12">
                    <button style="float: right;" type="submit" class="btn btn-success" name="addNotification">Add Notification</button>
                </div>
            </div>
        </form>
    </div>
</div>