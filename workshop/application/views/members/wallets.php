<style>
	.la_size {
		font-size: 30px;
		cursor: pointer;
	}
</style>

<!-- end:: Header -->
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

	<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
		<br />
		<span class="float-right"><a href="<?= site_url('members/paymentRequests'); ?>" class="btn btn-info p-2">Payment Requests</a></span>
		<br />
		<br />
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
						<th>Current Balance</th>
						<th>Joined Date</th>
						<th>KYC</th>
						<th>Pay</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php foreach ($WALLETS as $key) {
						$userDetails = $this->Crud->ciRead('users', " `epin` = '$key->epin'");
					?>
						<tr>
							<td><?php echo ++$i; ?></td>
							<td><?php echo $key->epin; ?></td>
							<td><?php echo $userDetails[0]->name; ?></td>
							<td><?php echo $userDetails[0]->phone; ?></td>
							<td>&#8377;<?php echo $key->available; ?></td>
							<td><?php echo date('Y-m-d', $userDetails[0]->joined_on); ?></td>
							<td><span class="badge <?= $userDetails[0]->bank_details_given == 1 ? 'badge-success' : 'badge-danger'; ?>"><?= $userDetails[0]->bank_details_given == 1 ? 'Approved' : 'Not Approved'; ?></span></td>
							<td>
								<?php if ($userDetails[0]->bank_details_given != 1) { ?>
									<a onclick="alert('Bank details not approved for this user!')" class="btn btn-danger text-white">Pay</a>
								<?php } else if ($key->available <= MIN_WITHDRAWL_AMOUNT) { ?>
									<a onclick="alert('Minimum withdrawal balance is: &#8377;<?= MIN_WITHDRAWL_AMOUNT; ?>')" class="btn btn-danger text-white">Pay</a>
								<?php } else { ?>
									<a class="btn btn-success text-white paymentModal" data-user="<?= $userDetails[0]->id; ?>" data-bankname="<?= $userDetails[0]->bank_name; ?>" data-accountnumber="<?= $userDetails[0]->account_number; ?>" data-ifsc="<?= $userDetails[0]->ifsc; ?>" data-payeename="<?= $userDetails[0]->payee_name; ?>" data-pan="<?= $userDetails[0]->pan; ?>" data-branch_name="<?= $userDetails[0]->branch_name; ?>" data-epin="<?= $userDetails[0]->epin; ?>" data-vendorid="<?= $userDetails[0]->vendor_id; ?>" data-amount="<?= $key->available; ?>" data-toggle="modal" data-target="#paymentModal">Pay</a>
								<?php } ?>
							</td>
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



<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Pay</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="kt-form" method="post" action="<?php echo site_url('members/withdraw'); ?>" onsubmit="return showAlert(this)">
					<div class="kt-portlet__body">
						<div class="row">
							<input type="hidden" name="user_id" id="user_id" required>
							<input type="hidden" name="user_epin" id="user_epin" required>
							<input type="hidden" name="vendor_id" id="vendor_id" required>
							<div class="col-md-6">
								<div class="form-group">
									<label>Account Number</label>
									<input type="text" class="form-control" name="account_number" id="account_number" readonly placeholder="Enter Account Number" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>IFSC</label>
									<input type="text" class="form-control" readonly placeholder="Enter IFSC" name="ifsc" id="ifsc" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Bank Name</label>
									<input type="text" class="form-control" id="bank_name" readonly placeholder="Enter bank name" name="bank_name" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Payee Name</label>
									<input type="text" class="form-control" name="payee_name" readonly id="payee_name" placeholder="Enter payee name" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">Branch Name</label>
									<input type="text" class="form-control" name="branch_name" readonly id="branch_name" placeholder="Branch name">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">PAN</label>
									<input type="text" class="form-control" name="pan" readonly id="pan" placeholder="Enter PAN number">
									<span id="panMessage"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Amount</label>
									<input type="number" class="form-control" name="amount" required id="amount" placeholder="Enter amount to be paid">
									<span id="amountMessage"></span>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" id="tempAmount">
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="pay" id="pay" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(e) {
			$(document).on('click', '.paymentModal', function(e) {
				let amount = $(this).data('amount')
				$('#tempAmount').val(amount)
				$('#amount').val(amount)
				$('#user_id').val($(this).data('user'))
				$('#user_epin').val($(this).data('epin'))
				$('#vendor_id').val($(this).data('vendorid'))
				$('#account_number').val($(this).data('accountnumber'))
				$('#ifsc').val($(this).data('ifsc'))
				$('#bank_name').val($(this).data('bankname'))
				$('#payee_name').val($(this).data('payeename'))
				$('#pan').val($(this).data('pan'))
				$('#branch_name').val($(this).data('branch_name'))
				$('#amount').focus().attr('min', <?= MIN_WITHDRAWL_AMOUNT; ?>).attr('max', amount)
				$('#amountMessage').html('Please enter an amount between &#8377;<?= MIN_WITHDRAWL_AMOUNT; ?> - &#8377;' + amount)
				if ($(this).data('pan') == '') {
					$('#panMessage').html('<?= TDS_CHARGE_PERCENTAGE_PAN_INVALID; ?>% TDS &amp; 10% Admin Charge will be deducted from paid amount.')
				} else {
					$('#panMessage').html('<?= TDS_CHARGE_PERCENTAGE_PAN_VALID; ?>% TDS &amp; 10% Admin Charge will be deducted from paid amount.')
				}
			})
		});

		function showAlert(elem) {
			return confirm(
				'Total balance: ' + $('#tempAmount').val() + ', ' +
				'Paying: ' + $('#amount').val() + ', ' +
				'Charge: ' + Number($('#amount').val()) * .15 + ', ' +
				'Amount after deduction: ' + ($('#amount').val() - Number($('#amount').val()) * .15)
			)
		}
	</script>