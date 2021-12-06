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

		<div class="table-responsive">
			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>ID</th>
						<th>Sponsor ID</th>
						<th>User Details</th>
						<th>Started on</th>
						<th>Total Repurchase Needed</th>
						<th>Total Repurchase Done</th>
						<th>File</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php foreach ($HELD_MEMBERS as $key) {
						// $productDetails = $this->Crud->ciRead('products', " `id` = '$key->product_id'");
						$pendingStartedDate = strtotime($key->pending_started_date);
						$totalRepurchaseDone = 0;
						foreach ($this->Crud->ciRead('user_orders', " `user_epin` = '$key->epin' AND `added_on` >= '$pendingStartedDate' AND `status` != '3'") as $order) {
							$totalRepurchaseDone += ($order->coupon_discount + $order->total_amount);
						}
					?>
						<tr>
							<td><?php echo ++$i; ?></td>
							<td><?php echo $key->epin; ?></td>
							<td><?php echo $key->referral_code; ?></td>
							<td>
								<?php echo $key->name; ?><br />
								<?php echo $key->phone; ?><br />
								<?php echo $key->email; ?><br />
								<?php echo $key->address; ?>
							</td>
							<td><?php echo $key->pending_started_date; ?></td>
							<td>&#8377;<?php echo diffInMonths($key->pending_started_date, date('Y-m-d')) * $key->pending_per_month_purchase; ?></td>
							<td>&#8377;<?= $totalRepurchaseDone; ?></td>
							<td><a href="<?php echo base_url('user/uploads/file/' . $key->pending_unblock_uploaded_file_link); ?>" target="_BLANK" class="btn">File</a></td>
							<td nowrap>
								<a style="cursor: pointer;" data-toggle="modal" data-target="#editor" class="btn btn-success editor" data-id="<?= $key->id; ?>" data-phone="<?= $key->phone; ?>" data-name="<?= $key->name; ?>">Edit</a>&ensp;
								<a style="cursor: pointer;" class="btn btn-info passwordViewer" data-id="<?= $key->id; ?>">Credentials</a>&ensp;
								<a href="<?= site_url('members/changeStatus/users/1/' . $key->id); ?>" class="btn btn-warning" onclick="return confirm('Are you sure want to unblock this user?')">Unlock</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>

<div class="modal fade" id="editor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit user</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('members/editMember'); ?>" method="post">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<label for="nameEdit">Name</label>
							<input type="text" name="name" id="nameEdit" class="form-control" required>
						</div>
						<div class="col-sm-6">
							<label for="phoneEdit">Phone</label>
							<input type="text" name="phone" maxlength="10" id="phoneEdit" class="form-control" required>
						</div>
						<div class="col-sm-4">
							<input type="hidden" name="id" id="idEdit" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Save changes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).on('click', '.editor', function(e) {
		$('#nameEdit').val($(this).data('name'))
		$('#phoneEdit').val($(this).data('phone'))
		$('#idEdit').val($(this).data('id'))
	});

	$(document).on('click', '.passwordViewer', function(e) {
		let id = $(this).data('id')
		id && $.ajax({
			url: '<?= site_url('members/returnCredentials'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				id: id
			},
			success: function(response) {
				if (response.status == 200) {
					alert('Phone: ' + response.phone + ", Password: " + response.password)
				} else {
					alert(response.message)
				}
			}
		})
	});
</script>