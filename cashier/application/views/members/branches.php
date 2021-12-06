<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <?php $this->load->view('messages'); ?>
        <h5 class="hk-sec-title">SELECT BRANCH TO VIEW GENEALOGY</h5>
        <div class="row">
            <div class="col-sm">
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Depth</th>
                                <th>Downline</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($BRANCHES as $seller) {
                                $idOrEpin = isset($seller->epin) ? $seller->epin : $seller->id;
                            ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                    <td><a href="<?= isset($seller->epin) ? base_url('members/branches/' . $seller->epin) : base_url('members/branches/' . $seller->id); ?>"><?php echo $seller->name . ' (' . $idOrEpin . ')'; ?></a></td>
                                    <td><?= isset($seller->epin) ? $seller->level_from_top : 'Branch - 0'; ?></td>
                                    <td><?= $this->Crud->ciCount('users', " `position_under` = '$idOrEpin'"); ?></td>
                                    <td><?php echo $seller->email; ?></td>
                                    <td><?php echo $seller->phone; ?></td>
                                    <td><?php echo $seller->address; ?></td>
                                    <td><a href="<?= isset($seller->epin) ? base_url('members/treeView/' . $seller->epin) : base_url('members/treeView/' . $seller->id); ?>" class="btn btn-success btn-xs">Show Genealogy</a></td>
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