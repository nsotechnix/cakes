<style>
	.la_size {
		font-size: 30px;
		cursor: pointer;
	}
</style>

<!-- end:: Header -->
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

	<!-- end:: Content Head -->
	<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
		<?php $this->load->view('messages'); ?>
		<!--begin::Portlet-->
		<div class="kt-portlet">
			<!--begin::Form-->
			<form class="kt-form" method="POST" action="<?php echo base_url('epin/generator/'); ?>">
				<div class="kt-portlet__body">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Value</label>
								<input type="text" class="form-control" aria-describedby="epin" placeholder="2000" readonly value="599">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Quantity</label>
								<input type="text" maxlength="3" class="form-control" name="epins" aria-describedby="quantity" placeholder="Enter epin quantity">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="kt-portlet__foot">
								<div class="kt-form__actions">
									<button type="submit" name="generate" class="btn btn-primary">Generate</button>
									<button type="reset" class="btn btn-secondary">Cancel</button>
								</div>
							</div>
						</div>
					</div>
			</form>

			<!--end::Form-->
		</div>
	</div>
	<!--end::Portlet-->
</div>

<!-- end:: Page -->
