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
            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Combo Code</th>
                        <th>Products</th>
                        <th>Added on</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($COMBOS as $key) { ?>
                        <tr>
                            <td><?php echo ++$i; ?></td>
                            <td><?php echo $key->combo_code; ?></td>
                            <td>
                                <?php
                                foreach ($this->Crud->ciRead('combo_products', " `combo_code` = '$key->combo_code'") as $product) {
                                    $productDetails = $this->Crud->ciRead('products', " `id` = '$product->product_id'");
                                    echo "- ".$productDetails[0]->product_name . " (&#8377;" . $productDetails[0]->price . ")<br />";
                                }
                                ?>
                            </td>
                            <td><?php echo date('Y-m-d H:i:sa', $key->added_on); ?></td>
                            <td>
                                <?php if ($key->is_active == 1) { ?>
                                    <span class="badge badge-success">Active</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php } ?>
                            </td>
                            <td nowrap>
                                <?php if ($key->is_active == 1) { ?>
                                    <a href="<?php echo site_url('categorization/changeStatusCombo/combos/0/' . $key->combo_id); ?>" class="btn btn-danger btn-xs">Disable</a>
                                <?php } else { ?>
                                    <a href="<?php echo site_url('categorization/changeStatusCombo/combos/1/' . $key->combo_id); ?>" class="btn btn-success btn-xs">Enable</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>