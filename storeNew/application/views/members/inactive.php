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
						<th>Name</th>
						<th>Phone</th>
						<th>Offer Selected</th>
						<th>Email</th>
						<th>Address</th>
						<th>Last Login</th>
						<th>Joined Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php foreach ($INACTIVE_MEMBERS as $key) {
					?>
						<tr>
							<td><?php echo ++$i; ?></td>
							<td><?php echo $key->epin; ?></td>
							<td><?php echo $key->referral_code; ?></td>
							<td><?php echo $key->name; ?></td>
							<td><?php echo $key->phone; ?></td>
							<td><?= $key->offer_selected; ?></td>
							<td><?php echo $key->email; ?></td>
							<td><?php echo $key->address; ?></td>
							<td><?php echo $key->last_login; ?></td>
							<td><?php echo date('Y-m-d', $key->joined_on); ?></td>
							<td><a href="<?= site_url('members/changeStatus/users/1/' . $key->id); ?>" class="btn btn-success" onclick="return confirm('Are you sure want to unblock this user?')">Unblock</a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>