<style>
    .la_size {
        font-size: 30px;
        cursor: pointer;
    }
</style>

<!-- end:: Header -->
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <!--begin::Portlet-->
        <?php $this->load->view('messages'); ?>

        <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
            <!--begin: Datatable -->
            <div class="wide-block pt-3">
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User ID</th>
                                <th>Combo Code</th>
                                <th>Total Amount</th>
                                <th>Address</th>
                                <th>Delivery Type</th>
                                <th>Status</th>
                                <th>Ordered On</th>
                                <?php if ($this->uri->segment(4) == 'delivered') { ?>
                                    <th>Delivery type</th>
                                    <th>Shipment Number</th>
                                    <th>Delivered On</th>
                                <?php } ?>
                                <?php if ($this->uri->segment(4) == 'cancelled') { ?>
                                    <th>Cancelled On</th>
                                <?php } ?>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php foreach ($ORDERS as $key) {
                                $userEpin = $key->user_epin;
                                $userDetails = $this->Crud->ciRead('users', " `epin` = '$userEpin'");
                            ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                    <td>
                                        - <?php echo $key->user_epin; ?><br />
                                        - <?php echo $userDetails[0]->name; ?><br />
                                        - <?php echo $userDetails[0]->phone; ?><br />
                                    </td>
                                    <td>
                                        <?php echo $key->combo_code; ?>
                                        <br />
                                        <?php
                                        foreach ($this->Crud->ciRead('combo_products', " `combo_code` = '$key->combo_code'") as $product) {
                                            $productDetails = $this->Crud->ciRead('products', " `id` = '$product->product_id'");
                                            echo "- " . $productDetails[0]->product_name . " (&#8377;" . $productDetails[0]->price . ")<br />";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $key->total_amount; ?></td>
                                    <td><?php echo $key->address; ?></td>
                                    <td><?php echo $key->delivery_type; ?></td>
                                    <td>
                                        <?php if ($key->status == 0) { ?>
                                            <span class="badge badge-warning">New Order</span>
                                        <?php } else if ($key->status == 1) { ?>
                                            <span class="badge badge-success">Delivered</span>
                                        <?php } else if ($key->status == 2) { ?>
                                            <span class="badge badge-info">Dispatched</span>
                                        <?php } else if ($key->status == 3) { ?>
                                            <span class="badge badge-danger">Cancelled</span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo date('Y-m-d H:i:s', $key->added_on); ?></td>
                                    <?php if ($this->uri->segment(4) == 'delivered') { ?>
                                        <td><?php echo $key->delivery_type; ?></td>
                                        <td><?php echo $key->shipment_number == '' ? '-' : $key->shipment_number; ?></td>
                                        <td><?php echo date('Y-m-d H:i:s', $key->delivered_on); ?></td>
                                    <?php } ?>
                                    <?php if ($this->uri->segment(4) == 'cancelled') { ?>
                                        <td><?php echo date('Y-m-d H:i:s', $key->cancelled_on); ?></td>
                                    <?php } ?>
                                    <td nowrap>
                                        <?php if ($this->uri->segment(4) == 'pending') { ?>
                                            <?php if ($this->uri->segment(3) == 'takeaway') { ?>
                                                <form action="" method="post">
                                                    <input type="hidden" name="orderId" value="<?php echo $key->order_id; ?>" required>
                                                    <button name="deliver" onclick="return confirm('Are you sure want to deliver this order?')" class="btn btn-info btn-xs">Deliver</button>
                                                </form>
                                            <?php } ?>
                                            <?php if ($this->uri->segment(3) == 'homedelivery') { ?>
                                                <?php if ($key->status == 0) { ?>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="orderId" value="<?php echo $key->order_id; ?>" required>
                                                        <input placeholder="Enter shipment number" type="text" class="form-control" name="shipment_number" required>
                                                        <br />
                                                        <button name="dispatch" class="btn btn-info btn-xs">Dispatch</button>
                                                    </form>
                                                <?php } ?>
                                                <?php if ($key->status == 2) { ?>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="orderId" value="<?php echo $key->order_id; ?>" required>
                                                        <button name="deliver" onclick="return confirm('Are you sure want to deliver this order?')" class="btn btn-info btn-xs">Deliver</button>
                                                    </form>
                                                <?php } ?>
                                            <?php } ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="orderId" value="<?php echo $key->order_id; ?>" required>
                                                <button name="cancel" onclick="return confirm('Are you sure want to cancel this order?')" class="btn btn-danger btn-xs">Cancel</button>
                                            </form>
                                        <?php } else {
                                            echo "-";
                                        } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end: Datatable -->
        </div>
    </div>
</div>