<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seller extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{

		parent::__construct();

		$this->load->library('form_validation');

		$this->load->library('upload');

		$this->load->library('encryption');

		$this->load->model('Crud');

		if (!$this->session->userdata('abAdminId')) {
			redirect('authentication/login');
		}
	}

	public function newSeller()
	{

		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('seller/add-seller');
		$this->load->view('layouts/footer');
	}

	public function newFranchise()
	{

		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('seller/add-franchise');
		$this->load->view('layouts/footer');
	}

	public function addSeller()
	{

		$this->form_validation->set_rules('name', 'Name', 'required|trim');

		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

		$this->form_validation->set_rules('phone', 'Phone', 'required');

		$this->form_validation->set_rules('confirmPassword', 'Confirmation password', 'required');

		$this->form_validation->set_rules('address', 'Address', 'required|trim');

		if ($this->form_validation->run()) {

			$phone = $this->input->post('phone');

			$isPhone = $this->Crud->ciCount('seller', " `phone` = '$phone'");

			if ($isPhone < 1) {

				$config['upload_path'] = FCPATH . 'uploads/vendors/';
				$config['allowed_types'] = '*';
				$config['encrypt_name'] = TRUE;
				$this->load->library('image_lib');
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$mainImage = '';
				if (!$this->upload->do_upload('pan_proof')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('warning', $this->upload->display_errors());
				} else {
					$image_metadata = $this->upload->data();
					$configer =  array(
						'image_library'   => 'gd2',
						'source_image'    =>  $image_metadata['full_path'],
						'maintain_ratio'  =>  TRUE,
						'width'           =>  400,
						'height'          =>  400,
					);
					$this->image_lib->clear();
					$this->image_lib->initialize($configer);
					$mainImage = $image_metadata['file_name'];
				}

				$sellerData = [

					'name' => $this->input->post('name'),

					'email' => $this->input->post('email'),

					'phone' => $this->input->post('phone'),

					'password' => $this->encryption->encrypt($this->input->post('password')),

					'address' => $this->input->post('address'),
					'account_number' => $this->input->post('account_number'),
					'ifsc' => $this->input->post('ifsc'),
					'bank_name' => $this->input->post('bank_name'),
					'payee_name' => $this->input->post('payee_name'),
					'pan' => $this->input->post('pan'),
					'dob' => $this->input->post('dob'),
					'pan_proof' => $mainImage,
					'added_date' => date('Y-m-d'),

					'added_time' => date('H:i:s')

				];

				$add = $this->Crud->ciCreate('seller', $sellerData);

				if ($add === false) {

					$this->session->set_flashdata('danger', 'Something went wrong, please try again');
				} else {

					$this->session->set_flashdata('success', 'Vendor Registered');

					redirect('seller/newSeller');
				}
			} else {

				$this->session->set_flashdata('warning', 'Phone number already in use with another vendor');
			}

			redirect('seller/newSeller');
		} else {

			$this->newSeller();
		}
	}

	public function view()
	{

		$data['SELLERS'] = $this->Crud->ciRead('seller', " `is_active` = '1'");

		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('seller/manage-seller', $data);
		$this->load->view('layouts/footer');
	}

	public function inactiveSellers()
	{

		$data['SELLERS'] = $this->Crud->ciRead('seller', " `is_active` = '0'");

		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('seller/inactiveSellers', $data);
		$this->load->view('layouts/footer');
	}

	public function changeStatus()
	{

		$tableName = $this->uri->segment(3);

		$status = $this->uri->segment(4);

		$conditionId = $this->uri->segment(5);

		$condition = " `id` = '$conditionId'";

		$data = [

			'is_active' => $status

		];

		if ($this->Crud->ciUpdate($tableName, $data, $condition)) {

			$this->Crud->ciUpdate('products', $data, " `the_creator` = '$conditionId' AND `is_active_backup` = '1'");

			$this->session->set_flashdata('success', "Success! Changes saved");
		} else {

			$this->session->set_flashdata('danger', "Something went wrong");
		}
		$referer = basename($_SERVER['HTTP_REFERER']);

		redirect('seller/' . $referer);
	}

	public function edit()
	{

		$sellerId = $this->uri->segment(3);

		$isExists = $this->Crud->ciCount('seller', " `id` = '$sellerId'");

		if ($isExists < 1) {

			$this->session->set_flashdata('danger', "No sellers found");

			redirect('seller/view');
		} else {

			$data['SELLER_DETAILS'] = $this->Crud->ciRead('seller', " `id` = '$sellerId'");
		}

		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('seller/edit-seller', $data);
		$this->load->view('layouts/footer');
	}

	public function editSeller()
	{

		$sellerId = $this->uri->segment(3);

		$this->form_validation->set_rules('name', 'Name', 'required|trim');

		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

		$this->form_validation->set_rules('phone', 'Phone', 'required');

		$this->form_validation->set_rules('address', 'Address', 'required|trim');

		if ($this->form_validation->run()) {

			$phone = $this->input->post('phone');

			$isPhone = $this->Crud->ciCount('seller', " `phone` = '$phone'");

			if ($isPhone < 2) {

				$sellerData = [

					'name' => $this->input->post('name'),

					'email' => $this->input->post('email'),

					'phone' => $this->input->post('phone'),

					'address' => $this->input->post('address'),

					'account_number' => $this->input->post('account_number'),
					'ifsc' => $this->input->post('ifsc'),
					'bank_name' => $this->input->post('bank_name'),
					'payee_name' => $this->input->post('payee_name'),
					'pan' => $this->input->post('pan'),
					'dob' => $this->input->post('dob'),

					'last_updated_date' => date('Y-m-d'),

					'last_updated_time' => date('H:i:s'),

					'last_updated_remote' => $_SERVER['REMOTE_ADDR']

				];

				$update = $this->Crud->ciUpdate('seller', $sellerData, " `id` = '$sellerId'");

				if ($update === false) {

					$this->session->set_flashdata('danger', 'Something went wrong, please try again');

					redirect('seller/view');
				} else {

					$this->session->set_flashdata('success', 'Seller details updated successfully!');

					redirect('seller/view');
				}
			} else {

				$this->session->set_flashdata('warning', 'Phone number already in use with another seller');
			}
		} else {

			$this->session->set_flashdata('warning', 'Invalid form data entered!' . $sellerId);

			redirect('seller/view');
		}
	}

	public function logout()
	{

		$data = $this->session->all_userdata();

		foreach ($data as $key => $value) {

			$this->session->unset_userdata($key);
		}

		redirect('authentication/login');
	}

	public function changeSellerBadge()
	{
		if (!empty($_POST)) {
			extract($_POST);
			$data = [
				'badge' => $val
			];
			if ($this->Crud->ciUpdate('seller', $data, " `id` = '$id'")) {
				echo "Saved successfully";
			} else {
				echo "Something went wrong, please refresh this page and try again";
			}
		}
	}

	public function payment()
	{
		$data['SELLERS'] = $this->Crud->ciRead('seller', " `id` != '0'");
		if (isset($_POST['filter'])) {
			extract($_POST);
			$sellerData = $this->Crud->ciRead('seller', " `id` = '$sellers'");
			$data['sellerDetails'] = $sellerData[0]->name . " (" . $sellerData[0]->phone . ")";
			$data['start'] = $startDate;
			$data['end'] = $endDate;
			$data['TOTAL_SALES'] = 0;
			$data['SALES_LIST'] = $this->Crud->ciRead('cart', " `the_creator` = '$sellers' AND `is_ordered` = '1' AND `added_date` BETWEEN '$startDate' AND '$endDate'");
			foreach ($this->Crud->ciRead('cart', " `the_creator` = '$sellers' AND `is_ordered` = '1' AND `added_date` BETWEEN '$startDate' AND '$endDate'") as $key) {
				if ($this->Crud->ciCount('orders', " `ukey` = '$key->order_id' AND `current_status` = '3'") > 0) {
					$data['TOTAL_SALES'] += $key->total;
				}
			}
		}

		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('seller/payment', $data);
		$this->load->view('layouts/footer');
	}
}
