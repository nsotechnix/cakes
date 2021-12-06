<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cashier extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

		$this->load->library('form_validation');

		$this->load->library('upload');

		$this->load->library('encryption');

		$this->load->model('Admin_Store_Model');

		$this->load->model('Admin_Cashier_Model');

		$this->load->model('Crud');

		if (!$this->session->userdata('abAdminId')) {
			redirect('authentication/login');
		}
	}

	public function newCashier()
	{

		$data['STORES'] = $this->Admin_Store_Model->getstores();

		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('cashier/add-cashier', $data);
		$this->load->view('layouts/footer');
	}

	public function addCashier()
	{

		$this->form_validation->set_rules('name', 'Name', 'required|trim');

		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

		$this->form_validation->set_rules('phone', 'Phone', 'required');

		$this->form_validation->set_rules('confirmPassword', 'Confirmation password', 'required');

		$this->form_validation->set_rules('address', 'Address', 'required|trim');

		if ($this->form_validation->run()) {

			$phone = $this->input->post('phone');

			$isPhone = $this->Crud->ciCount('cashier', " `phone` = '$phone'");

			if ($isPhone < 1) {

				$config['upload_path'] = FCPATH . 'uploads/cashier/';
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

				//Bank Proof
				$config1['upload_path'] = FCPATH . 'uploads/cashier/';
				$config1['allowed_types'] = '*';
				$config1['encrypt_name'] = TRUE;
				$this->load->library('image_lib');
				$this->load->library('upload', $config1);
				$this->upload->initialize($config1);
				$bankProof = '';
				if (!$this->upload->do_upload('bank_proof')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('warning', $this->upload->display_errors());
				} else {
					$image_metadata = $this->upload->data();
					$configer =  array(
						'image_library'   => 'gd2',
						'source_image'    =>  $image_metadata['full_path'],
						'maintain_ratio'  =>  TRUE,
						'width'           =>  800,
						'height'          =>  800,
					);
					$this->image_lib->clear();
					$this->image_lib->initialize($configer);
					$bankProof = $image_metadata['file_name'];
				}
				//Bank Proof

				//Generate Cashier Code
				$str_result = '0123456789';
				$cashier_name = $this->input->post('name');
				$cashier_code = "CASH" . substr(strtoupper($cashier_name), 0, 4) . substr(str_shuffle($str_result), 0, 4);


				$cashierData = [

					'store_id' => $this->input->post('store_id'),

					'name' => $cashier_name,

					'cashier_code' => $cashier_code,

					'email' => $this->input->post('email'),

					'phone' => $this->input->post('phone'),

					'password' => $this->encryption->encrypt($this->input->post('password')),

					'gender' => $this->input->post('gender'),
					'blood_group' => $this->input->post('blood_group'),

					'address' => $this->input->post('address'),
					'present_address' => $this->input->post('present_address'),
					'account_number' => $this->input->post('account_number'),
					'ifsc' => $this->input->post('ifsc'),
					'bank_name' => $this->input->post('bank_name'),
					'payee_name' => $this->input->post('payee_name'),
					'pan' => $this->input->post('pan'),
					'dob' => $this->input->post('dob'),
					'pan_proof' => $mainImage,
					'bank_proof' => $bankProof,
					'added_date' => date('Y-m-d'),

					'added_time' => date('H:i:s')

				];

				$add = $this->Crud->ciCreate('cashier', $cashierData);

				if ($add === false) {

					$this->session->set_flashdata('danger', 'Something went wrong, please try again');
				} else {

					$this->session->set_flashdata('success', 'Cashier Registered');

					redirect('cashier/newCashier');
				}
			} else {

				$this->session->set_flashdata('warning', 'Phone number already in use with another vendor');
			}

			redirect('cashier/newCashier');
		} else {

			$this->newCashier();
		}
	}

	public function view()
	{

		// $data['CASHIERS'] = $this->Crud->ciRead('cashier', " `is_active` = '1'");


		$data['CASHIERS'] = $this->Admin_Cashier_Model->getcashier();




		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('cashier/manage-cashier', $data);
		$this->load->view('layouts/footer');
	}

	public function inactiveCashiers()
	{

		$data['CASHIERS'] = $this->Crud->ciRead('cashier', " `is_active` = '0'");

		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('cashier/inactiveCashiers', $data);
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

		redirect('cashier/' . $referer);
	}

	public function edit()
	{

		$cashierId = $this->uri->segment(3);

		$isExists = $this->Crud->ciCount('cashier', " `id` = '$cashierId'");

		if ($isExists < 1) {

			$this->session->set_flashdata('danger', "No cashiers found");

			redirect('cashier/view');
		} else {

			$data['CASHIER_DETAILS'] = $this->Crud->ciRead('cashier', " `id` = '$cashierId'");
		}

		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('cashier/edit-cashier', $data);
		$this->load->view('layouts/footer');
	}

	public function editCashier()
	{

		$cashierId = $this->uri->segment(3);

		$this->form_validation->set_rules('name', 'Name', 'required|trim');

		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

		$this->form_validation->set_rules('phone', 'Phone', 'required');

		$this->form_validation->set_rules('address', 'Address', 'required|trim');

		if ($this->form_validation->run()) {

			//Edit Pan Image

			$new_photo = NULL;
			$photo = $_FILES['pan_proof']['name'];
			if ($photo != '') {
				$photoExt1 = @end(explode('.', $photo));
				$phototest1 = strtolower($photoExt1);
				$new_photo = time() . '.' . $phototest1;
				$photo_path = './uploads/cashier/' . $new_photo;

				move_uploaded_file($_FILES['pan_proof']['tmp_name'], $photo_path);
			}
			//Edit Pan Image

			//Edit Bank Passbook
			// $new_photo1 = NULL;
			// 	$photo1 = $_FILES['bank_proof']['name'];
			// 	if($photo1 != ''){
			// 		$photoExt1 = @end(explode('.', $photo1));
			// 		$phototest1 = strtolower($photoExt1);
			// 		$new_photo = time().'.'.$phototest1;
			// 		$photo_path = './uploads/cashier/'.$new_photo1;

			// 		move_uploaded_file($_FILES['bank_proof']['tmp_name'], $photo_path);

			// 	}

			// Edit Bank Passbook

			$phone = $this->input->post('phone');

			$isPhone = $this->Crud->ciCount('cashier', " `phone` = '$phone'");

			if ($isPhone < 2) {

				$cashierData = [

					'name' => $this->input->post('name'),

					'email' => $this->input->post('email'),

					'phone' => $this->input->post('phone'),
					'dob' => $this->input->post('dob'),

					'gender' => $this->input->post('gender'),
					'blood_group' => $this->input->post('blood_group'),

					'address' => $this->input->post('address'),
					'present_address' => $this->input->post('present_address'),

					'account_number' => $this->input->post('account_number'),
					'ifsc' => $this->input->post('ifsc'),
					'bank_name' => $this->input->post('bank_name'),
					'payee_name' => $this->input->post('payee_name'),
					'pan' => $this->input->post('pan'),


					'last_updated_date' => date('Y-m-d'),

					'last_updated_time' => date('H:i:s'),

					'last_updated_remote' => $_SERVER['REMOTE_ADDR']

				];

				$update = $this->Crud->ciUpdate('cashier', $cashierData, " `id` = '$cashierId'");
				if ($new_photo != NULL) {

					$cashierData = array(


						'pan_proof' => $new_photo,
					);
					$update = $this->Crud->ciUpdate('cashier', $cashierData, " `id` = '$cashierId'");
				}

				//Bank Pasbook

				// else if($new_photo1 != NULL){

				// 	$cashierData = array(


				// 					'bank_proof' => $new_photo1,
				// 				);
				// $update = $this->Crud->ciUpdate('cashier', $cashierData, " `id` = '$cashierId'");
				// 			}
				//Bank Passbook

				if ($update === false) {

					$this->session->set_flashdata('danger', 'Something went wrong, please try again');

					redirect('cashier/view');
				} else {

					$this->session->set_flashdata('success', 'Cashier details updated successfully!');

					redirect('cashier/view');
				}
			} else {

				$this->session->set_flashdata('warning', 'Phone number already in use with another cashier');
			}
		} else {

			$this->session->set_flashdata('warning', 'Invalid form data entered!' . $cashierId);

			redirect('cashier/view');
		}
	}



	//Upda


	public function logout()
	{

		$data = $this->session->all_userdata();

		foreach ($data as $key => $value) {

			$this->session->unset_userdata($key);
		}

		redirect('authentication/login');
	}


	//Cashier status management by admin
	//Suspend Cashier by admin

	public function block_cashier()
	{
		$id = $this->uri->segment(3);

		$result = $this->Admin_Cashier_Model->cashierstatus([


			'is_active' => 0, //Block already active  cashier


		], $id);

		if ($result) {
			$this->session->set_flashdata('success', "Success! Changes saved");
		}

		return redirect('cashier/view');
	}

	//UnBlock Cashier by admin

	public function unblock_cashier()
	{
		$id = $this->uri->segment(3);

		$result = $this->Admin_Cashier_Model->cashierstatus([


			'is_active' => 1, //Unblock cashier

		], $id);

		if ($result) {
			$this->session->set_flashdata('success', "Success! Changes saved");
		}

		return redirect('cashier/view');
	}
}
