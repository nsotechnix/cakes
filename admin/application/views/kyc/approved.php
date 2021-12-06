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
						<th>Name</th>
						<th>Phone</th>
						<th>Bank Name</th>
						<th>Account Number</th>
						<th>IFSC</th>
						<th>Payee Name</th>
						<th>Approved by</th>
						<th>Passbook</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php foreach ($APPROVED as $key) {
						if ($key->kyc_approved_by_user_type == 'VENDOR') {
							$approvedBy = $this->Crud->ciRead('seller', " `id` = '$key->kyc_approved_by'")[0]->address . ' Branch';
						} else {
							$approvedBy = 'ADMIN';
						}
					?>
						<tr>
							<td><?php echo ++$i; ?></td>
							<td><?php echo $key->epin; ?></td>
							<td><?php echo $key->name; ?></td>
							<td><?php echo $key->phone; ?></td>
							<td><?php echo $key->bank_name; ?></td>
							<td><?php echo $key->account_number; ?></td>
							<td><?php echo $key->ifsc; ?></td>
							<td><?php echo $key->payee_name; ?></td>
							<td><?php echo $approvedBy; ?></td>
							<td><a href="<?= base_url('../user/uploads/kyc/' . $key->passbook); ?>" target="_BLANK">View</a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>