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
						<th>ePin</th>
						<th>From</th>
						<th>To</th>
						<th>Date</th>
						<th>Time</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php foreach ($REPORT as $key) {
						$vendorDetails = $this->Crud->ciRead('seller', " `id` = '$key->transfered_to'");
					?>
						<tr>
							<td><?php echo ++$i; ?></td>
							<td><?php echo $key->epin; ?></td>
							<td><?php echo $key->transfered_from; ?></td>
							<td><?php echo $vendorDetails[0]->name . ' - ' . $vendorDetails[0]->phone; ?></td>
							<td><?php echo $key->transfered_date; ?></td>
							<td><?php echo $key->transfered_time; ?></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>