<?php
$start = microtime(true);
?>
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">

    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <!--begin::Portlet-->
        <?php $this->load->view('messages'); ?>
        <h5>Search by ID</h5>
        <br />
        <form action="" method="post">
            <div class="row">
                <div class="col-sm-4">
                    <input type="text" placeholder="Enter ID" name="rootEpin" class="form-control">
                </div>
                <div class="col-sm-4">
                    <button type="submit" name="filter" class="btn btn-info">Show</button>
                </div>
            </div>
        </form>
        <br />
        <?php if (isset($_POST['filter'])) { ?>
            <div class="wide-block pt-3">
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Coupon Code</th>
                                <th>Eligible from</th>
                                <th>Expiry Date</th>
                                <th>Is Used</th>
                                <th>Actions</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($COUPONS as $key) {
                            ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                    <td>
                                        - <?php echo $key->epin; ?><br />
                                        Name: <?php echo $userDetails[0]->name; ?><br />
                                        Position under: <?php echo $userDetails[0]->position_under; ?><br />
                                        Address: <?php echo $userDetails[0]->address; ?><br />
                                        Member since: <?php echo date('Y-m-d', $userDetails[0]->joined_on); ?>
                                    </td>
                                    <td><?= $key->coupon_code; ?></td>
                                    <td><?php echo $key->eligible_from; ?></td>
                                    <td><?php echo $key->expiry_date; ?></td>
                                    <td><?= ($key->is_used == 1) ? "Used on: " . date('d-M-Y', $key->used_on) : "Not used"; ?></td>
                                    <td>
                                        <?php if ($key->is_used == 1) { ?>
                                            <span class="badge badge-success">Used</span>
                                        <?php } else if (date('Y-m-d') >= $key->eligible_from && date('Y-m-d') < $key->expiry_date) { ?>
                                            <!-- <form action="" method="post">
                                                <input type="hidden" name="coupon_id" id="coupon_id" value="<?= $key->coupon_id; ?>">
                                                <button class="btn btn-success btn-xs" name="useCoupon">Use</button>
                                            </form> -->
                                            <a href="<?= base_url('dashboard/purchase/' . $key->epin . '/' . $key->coupon_code); ?>"></a>
                                        <?php } else if (date('Y-m-d') >= $key->expiry_date) { ?>
                                            <span class="badge badge-danger">Expired</span>
                                        <?php } else { ?>
                                            <span class="badge badge-info">Not eligible</span>

                                        <?php } ?>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>