<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifications extends CI_Controller
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

		// $this->load->library('upload');

		if (!$this->session->userdata('abAdminId')) {
			redirect('authentication/login');
		}
	}

	public function newNotification()
	{
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('notifications/new');
		$this->load->view('layouts/footer');
	}

	public function insertNotification()
	{
		if (isset($_POST['addNotification'])) {
			extract($_POST);
			$data = [
				'notification' => $notification,
				'show_until' => $show_until,
				'added_date' => date('Y-m-d'),
				'added_time' => date('H:i:s')
			];
			if ($this->Crud->ciCreate('notifications', $data)) {
				$notificationData = [
					'is_notification' => 1
				];
				$this->Crud->ciUpdate('users', $notificationData, " `is_active` = '1'");
				$this->session->set_flashdata('success', "Notification added and shared to customers");
			} else {
				$this->session->set_flashdata('danger', "Something went wrong, please try again");
			}
		}
		redirect('notifications/newNotification');
	}

	public function active()
	{
		$today = date('Y-m-d');
		$data['NOTIFICATIONS'] = $this->Crud->ciRead('notifications', " `show_until` >= '$today' AND `status` = '1'");
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('notifications/active', $data);
		$this->load->view('layouts/footer');
	}

	public function inactive()
	{
		$today = date('Y-m-d');
		$data['NOTIFICATIONS'] = $this->Crud->ciRead('notifications', " `show_until` < '$today' OR `status` = '0'");
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('notifications/inactive', $data);
		$this->load->view('layouts/footer');
	}

	public function disableNotification()
	{
		if ($this->uri->segment(3)) {
			$id = $this->uri->segment(3);
			$data = [
				'status' => 0
			];
			$this->Crud->ciUpdate('notifications', $data, " `id` = '$id'");
			$this->session->set_flashdata('success', "Success");
		}
		redirect('notifications/active');
	}
}
