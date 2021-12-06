<?php
$start = microtime(true);
?>
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor card">

	<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
		<!--begin::Portlet-->
		<?php $this->load->view('messages'); ?>
		<h5>Search by position</h5>
		<br />
		<form action="" method="post">
			<div class="row">
				<div class="col-sm-4">
					<input type="text" placeholder="Enter ID" name="rootEpin" class="form-control">
				</div>
				<div class="col-sm-4">
					<select name="position" id="position" class="form-control" required>
						<option value="ALL">ALL</option>
						<option value="1">Level 1</option>
						<option value="2">Level 2</option>
						<option value="3">Level 3</option>
						<option value="4">Level 4</option>
						<option value="5">Level 5</option>
						<option value="6">Level 6</option>
						<option value="7">Level 7</option>
						<option value="8">Level 8</option>
					</select>
				</div>
				<div class="col-sm-4">
					<button type="submit" name="filter" class="btn btn-info">Show</button>
				</div>
			</div>
		</form>
		<br />
		<?php if (isset($_POST['filter'])) { ?>
			<div class="wide-block pt-3">
				<div class="table-responsive">
					<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
						<thead>
							<tr>
								<th>#</th>
								<th>ID</th>
								<th>Name</th>
								<th>Offer Selected</th>
								<th>Sponsor</th>
								<th>Depth</th>
								<th>Joined on</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							function getMembers($epin) {
								global $i, $level;
								$ci = &get_instance();
								$showThis = false;
								$rootEpin = $_POST['rootEpin'];
								$level = $ci->Crud->ciRead('users', " `epin` = '$rootEpin'")[0]->level_from_top;
								$position = $_POST['position'];
								$referrals = $ci->Crud->ciRead('users', " `position_under` = '$epin'");
								foreach ($referrals as $key) {
									getMembers($key->epin);
									if ($position == 'ALL') {
										$showThis = true;
									} else {
										if ((int)$key->level_from_top - (int)$position ==  (int)$level) {
											$showThis = true;
										}
									}
									if ($showThis) {
							?>
										<tr>
											<td><?php echo ++$i; ?></td>
											<td><?php echo $key->epin; ?></td>
											<td>
												Name: <?php echo $key->name; ?><br />
												Position under: <?php echo $key->position_under; ?><br />
												Address: <?php echo $key->address; ?><br />
												Member since: <?php echo date('Y-m-d', $key->joined_on); ?>
											</td>
											<td><?= $key->offer_selected; ?></td>
											<td><?php echo strlen($key->referral_code) < 8 ? $ci->Crud->ciRead('seller', " `id` = '$key->referral_code'")[0]->name : $ci->Crud->ciRead('users', " `epin` = '$key->referral_code'")[0]->name; ?></td>
											<td><?= $key->level_from_top; ?></td>
											<td><?php echo date('d-M-Y', $key->joined_on); ?></td>
											<td></td>
										</tr>
							<?php }
								}
							}
							getMembers($myEpin);
							?>
						</tbody>
					</table>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<?php
$end = microtime(true);
$timeElapsed = $end - $start;
// echo "execution time: " . $timeElapsed;
?>