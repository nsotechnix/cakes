<?php
$start = microtime(true);
?>
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">

    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <!--begin::Portlet-->
        <?php $this->load->view('messages'); ?>
        <h5>Search by position</h5>
        <br />
        <form action="" method="post">
            <div class="row">
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="epin" placeholder="Enter ID" required>
                </div>
                <div class="col-sm-4">
                    <select name="position" id="position" class="form-control" required>
                        <option value="ALL">ALL</option>
                        <option value="LEFT">LEFT</option>
                        <option value="RIGHT">RIGHT</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <button type="submit" name="filter" class="btn btn-info">Show</button>
                </div>
            </div>
        </form>
        <br />
        <?php if (isset($_POST['filter'])) { ?>
            <?php
            $myEpin = $_POST['epin'];
            ?>
            <div class="wide-block pt-3">
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Product</th>
                                <th>Sponsor</th>
                                <th>Depth</th>
                                <th>Joined on</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $rootEpin = $_POST['epin'];
                            $myLevel = $this->Crud->ciRead('users', " `epin` = '$rootEpin'")[0]->level_from_top;
                            function getMembers($epin) {
                                $ci = &get_instance();
                                global $i, $myEpin, $rootEpin, $myLevel;
                                if ($i == 0) {
                                    $rootEpin = $_POST['epin'];
                                    $myLevel = $ci->Crud->ciRead('users', " `epin` = '$rootEpin'")[0]->level_from_top;
                                }
                                $position = $_POST['position'];
                                // echo "<script>alert('$position')</script>";
                                if ($position == 'ALL') {
                                    $referrals = $ci->Crud->ciRead('users', " `position_under` = '$epin'");
                                } else {
                                    if ($epin == $_POST['epin']) {
                                        $referrals = $ci->Crud->ciRead('users', " `position_under` = '$epin' AND `position` = '$position'");
                                    } else {
                                        $referrals = $ci->Crud->ciRead('users', " `position_under` = '$epin'");
                                    }
                                }
                                foreach ($referrals as $key) {
                                    global $rootEpin, $myLevel;
                                    $productDetails = $ci->Crud->ciRead('products', " `id` = '$key->product_id'");
                                    getMembers($key->epin);
                                    if (((int)$key->level_from_top - 20) <= $myLevel) {
                            ?>
                                        <tr>
                                            <td><?php echo ++$i; ?></td>
                                            <td><?php echo $key->epin; ?></td>
                                            <td>
                                                Name: <?php echo $key->name; ?><br />
                                                Position under: <?php echo $key->position_under; ?><br />
                                                Address: <?php echo $key->address; ?><br />
                                                Member since: <?php echo date('Y-m-d', $key->joined_on); ?>
                                            </td>
                                            <td><?= $productDetails[0]->product_name . ", Price: &#8377;" . $productDetails[0]->price; ?></td>
                                            <td><?php echo strlen($key->referral_code) < 8 ? $ci->Crud->ciRead('seller', " `id` = '$key->referral_code'")[0]->name : $ci->Crud->ciRead('users', " `epin` = '$key->referral_code'")[0]->name; ?></td>
                                            <td><?php echo $key->level_from_top; ?></td>
                                            <td><?php echo date('d-M-Y', $key->joined_on); ?></td>
                                            <td></td>
                                        </tr>
                            <?php }
                                }
                            }
                            getMembers($myEpin);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php
$end = microtime(true);
$timeElapsed = $end - $start;
// echo "execution time: " . $timeElapsed;
?>