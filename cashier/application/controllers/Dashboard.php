<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Cashier_Sale_Model');
		if (!$this->session->userdata('abCashierId')) {
			redirect('authenticatiodn/login');
		}
	}

	public function index()
	{


		$data['allproducts'] = $this->Crud->ciCount('products', " `id` != '0'");
		$data['STOCK'] = $this->Crud->ciRead('products', " `id` != '0'");
		// $this->db->where('is_active', '1');
		// $viewproduct = $this->db->get("products");
		// $data['viewproduct'] = $viewproduct->result_array();
		// $data = array();
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('dashboard', $data);
		$this->load->view('layouts/footer');
	}

	public function purchase()
	{
		$data = array();
		if ($this->uri->segment(3)) {
			$userEpin = $this->uri->segment(3);
			if ($this->Crud->ciCount('users', " `epin` = '$userEpin'")) {
				$userDetails = $this->Crud->ciRead('users', " `epin` = '$userEpin'");
				$data['USER'] = $userDetails;
				if ($this->uri->segment(4)) {
					$coupon = $this->uri->segment(4);
					$today = date('Y-m-d');
					$couponDetails = $this->Crud->ciRead('coupon_of_users', " `epin` = '$userEpin' AND `coupon_code` = '$coupon' AND `eligible_from` <= '$today' AND `expiry_date` > '$today' AND `is_used` = '0'");
					if (count(($couponDetails))) {
						// redirect('dashboard/purchase/' . $userEpin . '/' . $coupon);
					} else {
						$this->session->set_flashdata('danger', "Coupon is not valid ot not eligible.");
						redirect('dashboard/purchase/');
					}
				}
			} else {
				$this->session->set_flashdata('danger', "User with this ID not found.");
				redirect('dashboard/purchase');
			}
		}
		$data['COMBOS'] = $this->Crud->ciRead('combos', " `is_active` = '1'");
		if (isset($_POST['repurchaseMe'])) {
			extract($_POST);
			$this->Crud->ciCreate('user_orders', array(
				'user_epin' => $rootEpin,
				'combo_code' => $comboCode,
				'vendor_id' => $this->Crud->ciRead('users', " `epin` = '$rootEpin'")[0]->vendor_id,
				'coupon_used' => $coupon,
				'coupon_discount' => $coupon == '' ? 0 : 100,
				'total_amount' => (int)$this->Crud->ciRead('combos', " `combo_code` = '$comboCode'")[0]->total_price - ($coupon == '' ? 0 : 100),
				'address' => $this->Crud->ciRead('users', " `epin` = '$rootEpin'")[0]->address,
				'delivery_type' => $deliveryType,
				'added_on' => time()
			));
			if ($coupon != '') {
				$this->Crud->ciUpdate('coupon_of_users', array(
					'is_used' => 1,
					'used_on' => time()
				), " `coupon_code` = '$coupon' AND `epin` = '$rootEpin'");
			}
			$this->session->set_flashdata('success', "Repurchase added successfully");
			redirect('dashboard/purchase/');
		}
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('purchase');
		$this->load->view('layouts/footer');
	}

	public function getComboDetails()
	{
		$data['results'] = '<br />';
		if (isset($_POST['comboCode'])) {
			extract($_POST);
			foreach ($this->Crud->ciRead('combo_products', " `combo_code` = '$comboCode'") as $product) {
				$productDetails = $this->Crud->ciRead('products', " `id` = '$product->product_id'");
				$data['results'] .= "- " . $productDetails[0]->product_name . " (&#8377;" . $productDetails[0]->price . ")<br />";
			}
		}
		$data['totalAmount'] = 2000; //update this as per repurchase amount
		$data['results'] .= '<br />';
		echo json_encode($data);
	}



	public function coupons()
	{
		$data = array();
		if (isset($_POST['filter'])) {
			extract($_POST);
			$data['myEpin'] = $rootEpin;
			if ($this->Crud->ciCount('users', " `epin` = '$rootEpin'") == 0) {
				$this->session->set_flashdata('danger', "ID not found");
				redirect('dashboard/coupons');
			} else {
				$userDetails = $this->Crud->ciRead('users', " `epin` = '$rootEpin'");
				if ($userDetails[0]->offer_selected == 'COUPON') {
					$data['COUPONS'] = $this->Crud->ciRead('coupon_of_users', " `epin` = '$rootEpin'");
					$data['userDetails'] = $userDetails;
				} else {
					$this->session->set_flashdata('danger', "No coupons available for this user: " . $rootEpin);
					redirect('dashboard/coupons');
				}
			}
		}
		if (isset($_POST['useCoupon'])) {
			extract($_POST);
			$this->Crud->ciUpdate('coupon_of_users', array(
				'is_used' => 1,
				'used_on' => time()
			), " `coupon_id` = '$coupon_id'");
			$this->session->set_flashdata('success', "Coupon marked as used");
		}
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('coupons', $data);
		$this->load->view('layouts/footer');
	}

	public function logout()
	{

		$data = $this->session->all_userdata();

		foreach ($data as $key => $value) {

			$this->session->unset_userdata($key);
		}

		redirect('authentication/login');
	}
}
