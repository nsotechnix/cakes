<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categorization extends CI_Controller
{



	public function __construct()
	{

		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Store_Product_Model');
		// $this->load->model('Admin_Store_Model');
		if (!$this->session->userdata('abStoreName')) {
			redirect('authentication/login');
		}
	}


	public function viewStock()
	{
		// $data['PRODUCTS'] = $this->Crud->ciRead('products', " `id` <> 0");
		$data['PRODUCTS'] = $this->Store_Product_Model->getProducts();
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/view-stocks', $data);
		$this->load->view('layouts/footer');
	}

	public function viewStockbyStore()
	{

		$data['STOCK'] = $this->Store_Product_Model->getStockbystore($this->session->userdata('abStoreId'));
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/view-stocks-by-store', $data);
		$this->load->view('layouts/footer');
	}

	public function addStock()
	{
		if (isset($_POST['addstock'])) {
			extract($_POST);
			$productDetails = $this->Crud->ciRead('products', " `id` = '$product'");
			if ($this->Crud->ciUpdate('products', array(
				'stock' => (int)$productDetails[0]->stock + (int)$quantity
			), " `id` = '$product'")) {
				$this->Crud->ciCreate('stock_records', array(
					'product_id' => $product,
					'previous_stock' => $productDetails[0]->stock,
					'current_stock' => (int)$productDetails[0]->stock + (int)$quantity,
					'store_id' => $this->input->post('store_id'),
					'updated_on' => time()
				));
				$this->session->set_flashdata('success', 'Stock updated successfully');
			} else {
				$this->session->set_flashdata('danger', 'Something went wrong, please try again.');
			}
		}
		redirect('categorization/stock');
	}
}
