<!-- end:: Header -->
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

	<!-- begin:: Content Head -->
	<div class="kt-subheader   kt-grid__item" id="kt_subheader">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">Dashboard</h3>
			<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		</div>
		<div class="kt-subheader__toolbar">
			<div class="kt-subheader__wrapper">
				<a href="#" class="btn kt-subheader__btn-daterange" id="" data-toggle="kt-tooltip" title="" data-placement="left">
					<span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">Today</span>&nbsp;
					<span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date"><?php echo date('d M Y') ?></span>
					<i class="flaticon2-calendar-1"></i>
				</a>

			</div>
		</div>
	</div>

	<!-- end:: Content Head -->



	<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
		<div class="row mb-4">
			<div class="col-lg-3">
				<div class="card text-center p-4 shadow border-0 bg-success text-light">
					<h4>TODAY'S SALE</h4>

					<h3><?php echo ($todaysale); ?></h3>
				</div>
			</div>
			<!-- <div class="col-lg-3">
				<div class="card text-center p-4 shadow border-0 bg-warning text-light">
					<h4>TODAY'S JOIN</h4>
					<h3><?= $todayjoin ?></h3>
				</div>
			</div> -->
			<div class="col-lg-3">
				<div class="card text-center p-4 shadow border-0 bg-info text-light">
					<h4>TOTAL CASHIER</h4>
					<h3><?= $allcashier ?></h3>
				</div>
			</div>

			<div class="col-lg-3">
				<div class="card text-center p-4 shadow border-0 bg-danger text-light">
					<h4>PRODUCTS</h4>
					<h3><?= $allproducts ?></h3>
				</div>
			</div>
		</div>
		<!--Begin::Dashboard 3-->
		<div class="row mb-3">
			<div class="col-lg-4">
				<div class="card">
					<div class="card-body" style="height:170px;">
						<div class="text-center">
							<i class="fa fa-th text-success" style="font-size:50px;"></i>
							<h4 class="mt-3">Stock</h4>
							<a onclick="window.location.assign('<?= base_url('categorization/stock/'); ?>')" class="btn btn-success btn-sm text-light" style="cursor:pointer;">Add Stock</a>
							<a onclick="window.location.assign('<?= base_url('categorization/viewProduct/'); ?>')" class="btn btn-info btn-sm text-light" style="cursor:pointer;">View Stock</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card" style="height:170px;">
					<div class="card-body">
						<div class="text-center">
							<i class="fa fa-user text-danger" style="font-size:50px;"></i>
							<h4 class="mt-3">Cashier</h4>
							<a onclick="window.location.assign('<?php echo site_url('cashier/newCashier/'); ?>')" class="btn btn-success btn-sm text-light" style="cursor:pointer;">Add Cashier</a>
							<a onclick="window.location.assign('<?php echo site_url('cashier/view/'); ?>')" class="btn btn-info btn-sm text-light" style="cursor:pointer;">View Cashier</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card" style="height:170px;">
					<div class="card-body">
						<a onclick="window.location.assign('<?= base_url('categorization/addProduct/'); ?>')" style="cursor:pointer;">
							<div class="text-center">
								<i class="fa fa-shopping-cart text-warning" style="font-size:50px;"></i>
								<h4 class="mt-3">Products</h4>
								<a onclick="window.location.assign('<?= base_url('categorization/addProduct/'); ?>')" class="btn btn-success btn-sm text-light" style="cursor:pointer;">Add Product</a>
								<a onclick="window.location.assign('<?= base_url('categorization/viewProduct/'); ?>')" class="btn btn-info btn-sm text-light" style="cursor:pointer;">View Products</a>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<!--Begin::Section-->
		<div class="row">

			<!-- Stock table -->
			<div class="col-xl-4">

				<!--begin:: Widgets/New Users-->

				<div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
					<h4 class="pt-3 pl-4">Available Stock</h4>
					<div class="kt-portlet__head">
						<div class="kt-portlet__head-label">
							<h3 class="kt-portlet__head-title">
								Product Name
							</h3>
						</div>
						<div class="kt-portlet__head-toolbar">
							<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#kt_widget4_tab1_content" role="tab">
										Stock
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="kt-portlet__body">
						<div class="tab-content">
							<div class="tab-pane active" id="kt_widget4_tab1_content">
								<div class="kt-widget4">
									<?php foreach ($STOCK as $product) { ?>
										<div class="kt-widget4__item">
											<div class="kt-widget4__info">
												<p class="kt-widget4__text">
													<?= $product->product_name; ?>
												</p>
											</div>
											<p class="badge badge-success"><?= $product->stock; ?></p>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>



				<!--end:: Widgets/New Users-->
			</div>
			<!-- Stock table end -->
			<div class="col-xl-4">

				<!--begin:: Widgets/Last Updates-->
				<div class="kt-portlet kt-portlet--height-fluid">
					<div class="kt-portlet__head">
						<div class="kt-portlet__head-label">
							<h3 class="kt-portlet__head-title">
								Total Sold Items
							</h3>
						</div>
					</div>
					<div class="kt-portlet__body">

						<!--begin::widget 12-->
						<div class="kt-widget4">
							<?php foreach ($STOCK as $product) { ?>
								<div class="kt-widget4__item">
									<div class="kt-widget4__info">
										<p class="kt-widget4__text">
											<?= $product->product_name; ?>
										</p>
									</div>
									<?php $totalSold = $this->Crud->ciCount('sales_detail', " `product_id` = '$product->id'"); ?>
									<p class="badge badge-success">Total Sold: <?= $totalSold; ?></p>
								</div>
							<?php } ?>
						</div>

						<!--end::Widget 12-->
					</div>
				</div>

				<!--end:: Widgets/Last Updates-->
			</div>
		</div>

		<!--End::Section-->



		<!--Begin::Section-->
		<div class="row">
			<div class="col-xl-4">

				<!--begin:: Widgets/Sales States-->
				<div class="kt-portlet kt-portlet--height-fluid">
					<div class="kt-portlet__head">
						<div class="kt-portlet__head-label">
							<h3 class="kt-portlet__head-title">
								Sales of The Month
							</h3>
						</div>
					</div>
					<div class="kt-portlet__body">
						<div class="kt-widget6">
							<div class="kt-widget6__head">
								<div class="kt-widget6__item">
									<span>Last updated</span>
									<span>Count</span>
									<span>Amount</span>
								</div>
							</div>
							<div class="kt-widget6__body">
								<div class="kt-widget6__item">
									<span><?= date('Y-m-d'); ?></span>
									<span><?= $TOTAL_SOLD_THIS_MONTH; ?></span>
									<span class="kt-font-success kt-font-bold">Rs. <?= $TOTAL_SOLD_THIS_MONTH * 1000; ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--end:: Widgets/Sales States-->
			</div>
		</div>

		<!--End::Section-->

		<!--End::Dashboard 3-->
	</div>

	<!-- end:: Content -->
</div>



<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
	var KTAppOptions = {
		"colors": {
			"state": {
				"brand": "#5d78ff",
				"dark": "#282a3c",
				"light": "#ffffff",
				"primary": "#5867dd",
				"success": "#34bfa3",
				"info": "#36a3f7",
				"warning": "#ffb822",
				"danger": "#fd3995"
			},
			"base": {
				"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
				"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
			}
		}
	};
</script>

<!-- end::Global Config -->