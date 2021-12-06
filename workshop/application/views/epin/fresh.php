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
		<div class="kt-portlet">
			<!--begin::Form-->
			<form class="kt-form" method="post" action="<?php echo base_url('epin/transferer/'); ?>">
				<div class="kt-portlet__body">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Transfer to Vendor</label>
								<!-- <input id="transfer-to" name="transfer_to" onchange="checkEpin(this.value, this);" style="text-transform: uppercase;" type="text" class="form-control " placeholder="Enter ePin" required> -->
								<select name="transfer_to" id="transfer_to" class="form-control" required>
									<option value="">--select vendor--</option>
									<?php foreach ($VENDORS AS $vendor) { ?>
										<option value="<?= $vendor->id; ?>"><?= $vendor->name.' - '.$vendor->phone; ?></option>
									<?php } ?>
								</select>
								<i><span id="validatorName"></span></i>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Value</label>
								<input type="text" class="form-control" aria-describedby="epin" value="599" readonly placeholder="Enter ePin value">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Quantity</label>
								<input id="transfer-quantity" name="transfer_quantity" type="number" class="form-control " placeholder="Enter quantity" onkeyup="checkMax(this.value, this);" required>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="kt-portlet__foot">
								<div class="kt-form__actions">
									<button type="submit" name="transfer" class="btn btn-primary" onclick="return confirm('Are you sure?');">Transfer</button>
									<button type="reset" class="btn btn-secondary">Cancel</button>
								</div>
							</div>
						</div>
					</div>
			</form>
			<!--end::Form-->
		</div>

		<!--end::Portlet-->

		<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
			<h4><?php echo $this->session->userdata('umMyEpin') == 'ADMIN' ? "FRESH EPIN (" . $freshCount . " IN TOTAL)&emsp;" : ""; ?>&emsp;UNSOLD EPIN (<?php echo $freshCountAvailable; ?> IN TOTAL)</h4>
			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>ePin</th>
						<th>Belongs to</th>
						<th>Generated date</th>
						<th>Generated time</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php foreach ($EPINS as $key) { ?>
						<tr>
							<td><?php echo ++$i; ?></td>
							<td><?php echo $key->epin; ?></td>
							<td><?php echo $key->owner; ?></td>
							<td><?php echo $key->generated_date; ?></td>
							<td><?php echo $key->generated_time; ?></td>
							<td></td>
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
	<input type="hidden" name="" id="max-epin" value="<?php echo $freshCountAvailable; ?>">
</div>



<script>
	function checkMax(val, elem) {
		var maxim = $('#max-epin').val();
		maxim = maxim.replace(/\,/g, '');
		maxim = Number(maxim);
		if (val > maxim) {
			alert('You have ' + maxim + ' epins available');
			$(elem).val('');
		}
	}

	function checkEpin(val, elem) {
		$('#validatorName').html('Fetching name...');
		$.ajax({
			url: '<?php echo base_url('epin/validateEpin'); ?>',
			method: 'POST',
			dataType: 'json',
			data: {
				val: val
			},
			success: function(response) {
				if (response.err == 'NOT_FOUND') {
					alert('Invalid EPIN');
					$('#validatorName').html('');
					$(elem).val('').focus();
				} else if (response.err == 'FOUND') {
					$('#validatorName').html(response.user);
				} else {
					alert('Something went wrong, please try again');
					window.location.reload();
					$('#validatorName').html('');
				}
			}
		});
	}
</script>