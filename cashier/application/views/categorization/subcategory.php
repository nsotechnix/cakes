<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

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
        <h3>Add new subcategory</h3>
        <div class="row">
            <div class="col-sm">
                <form method="post" autocomplete="off" action="<?php echo site_url('categorization/newSubCategory'); ?>">
                    <div class="row">

                        <div class="col-sm-4">

                            <select name="category_id" id="" class="form-control" required>
                                <option value="" disabled selected>--select category--</option>
                                <?php
                                foreach ($CATEGORIES as $category) { ?>
                                    <option value="<?php echo $category->category_id; ?>"><?php echo $category->category; ?></option>
                                <?php }
                                ?>
                            </select>

                        </div><br />

                        <div class="col-sm-4">

                            <input type="text" name="subcategory" placeholder="Enter sub-category name here" id="" class="form-control" required>

                        </div><br />

                        <div class="col-sm-4">

                            <button type="submit" name="add" class="btn btn-info">ADD</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Sub-Category</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $i = 1; ?>
                    <?php
                    foreach ($SUBCATEGORIES as $subcategory) {
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>

                            <td><?php echo $subcategory->category; ?></td>

                            <td><?php echo $subcategory->sub_category; ?></td>
                            <td><?php echo $subcategory->added_date . ' - ' . $subcategory->added_time; ?></td>
                            <td><?php echo ($subcategory->is_active == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?></td>
                            <td>
                                <!-- <button data-toggle="modal" data-id="<?php echo $subcategory->id; ?>" data-text="<?php echo $subcategory->sub_category; ?>" data-category="<?php echo $subcategory->category; ?>" data-target="#editSubCategory" class="btn btn-info btn-xs editButton">Edit</button> -->

                                <?php if ($subcategory->is_active == 1) { ?>
                                    <a href="<?php echo site_url('categorization/block_subcategory/' . $subcategory->subcategory_id); ?>" class="btn btn-danger btn-xs">Inactive</a>
                                <?php } else if ($subcategory->is_active == 0) { ?>
                                    <a href="<?php echo site_url('categorization/unblock_subcategory/' . $subcategory->subcategory_id); ?>" class="btn btn-success btn-xs">Active</a>
                                <?php } ?>


                                <!-- Edit user button Json -->
                                <button data-toggle="modal" data-target="#editSubCategory" data-id="<?php echo $subcategory->subcategory_id; ?>" data-category="<?php echo $subcategory->category_id; ?>" data-text="<?php echo $subcategory->sub_category; ?>" class="btn btn-info btn-xs editor">Edit
                                </button>




                            </td>


                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>

<div class="modal fade" id="editSubCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDITING <span id="editingSubCategory"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo site_url('categorization/editSubCategory'); ?>" autocomplete="off">
                    <input type="hidden" id="editSubCategoryId" name="editSubCategoryId">
                    <input type="hidden" id="editCategoryId" name="editCategoryId">
                    <input type="text" id="editSubCategoryText" class="form-control" name="editSubCategoryText" required>
                    <!-- <input type="hidden" id="subcategory_id" name="id">

                    <input type="text" id="sub_category" name="sub_category"> -->
            </div>
            <div class="modal-footer">
                <button type="submit" name="changeCategory" class="btn btn-primary">Save changes</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    // $('#datable_1').dataTable({
    //     "autoWidth": true,
    //     searching: true,
    //     responsive: true
    // });

    // $('.editButton').on('click', function(e) {

    $(document).on('click touch', '.editButton', function() {

        var id = $(this).data('id');

        var text = $(this).data('text');

        var category = $(this).data('category');

        $('#editSubCategoryId').val(id);

        $('#editSubCategoryText').val(text);

        $('#editCategoryText').val(category);

        $('#editingSubCategory').html(text.toUpperCase());

    });
</script>


<script>
    $(document).on('click touch', '.editor', function() {

        var id = $(this).data('id');

        var text = $(this).data('text');

        var category = $(this).data('category');

        $('#editSubCategoryId').val(id);

        $('#editSubCategoryText').val(text);

        $('#editCategoryId').val(category);

        $('#editingSubCategory').html(text.toUpperCase());

    });
</script>