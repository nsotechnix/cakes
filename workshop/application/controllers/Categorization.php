<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categorization extends CI_Controller
{



	public function __construct()
	{

		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Workshop_Product_Model');
		$this->load->model('Workshop_Store_Model');
		if (!$this->session->userdata('abWorkshopId')) {
			redirect('authentication/login');
		}
	}

	public function category()
	{

		$data['CATEGORIES'] = $this->Crud->ciRead('categories', " `category_id` != '0'");
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/category', $data);
		$this->load->view('layouts/footer');
	}


	//Get subcategory by selcting category at product add page
	public function getsubcat($catid = 0)
	{

		$subcategory = $this->db->where(array('category_id' => $catid))->get('subcategories')->result_array();
		foreach ($subcategory as $subcat) {

			echo '<option value="' . $subcat['subcategory_id'] . '" >' . $subcat['sub_category'] . '</option>';
		}
	}

	public function newCategory()
	{

		$this->form_validation->set_rules('category', 'Category', 'required|trim');

		if ($this->form_validation->run()) {

			$category = $this->input->post('category');

			$isExists = $this->Crud->ciCount('categories', " `category` = '$category'");

			if ($isExists > 0) {

				$this->session->set_flashdata('warning', "Category already exists");
			} else {

				// $config['upload_path'] = FCPATH . 'uploads/categories/';

				// $config['allowed_types'] = 'gif|jpg|png';

				// $config['max_size'] = 2000;

				// $config['max_width'] = 1500;

				// $config['encrypt_name'] = TRUE;

				// $config['max_height'] = 1500;

				// $this->upload->initialize($config);

				// $categoryFileName = '';

				// if (!$this->upload->do_upload('categoryImage')) {

				// 	$error = array('error' => $this->upload->display_errors());

				// 	$this->session->set_flashdata('warning', $this->upload->display_errors());
				// } else {

				// $image_metadata = $this->upload->data();

				// $categoryFileName = $image_metadata['file_name'];


				$data = [

					'category' => $this->input->post('category'),

					// 'file_name' => $categoryFileName,

					'added_date' => date('Y-m-d'),

					'added_time' => date('H:i:s')

				];

				if ($this->Crud->ciCreate('categories', $data))

					$this->session->set_flashdata('success', "Category added");

				else

					$this->session->set_flashdata('danger', "Something went wrong");
			}

			redirect('categorization/category');
		} else {

			$this->category();
		}
	}

	public function editCategory()
	{

		$this->form_validation->set_rules('editCategoryText', 'Category', 'required|trim');

		if ($this->form_validation->run()) {

			$category = $this->input->post('editCategoryText');

			$categoryId = $this->input->post('editCategoryId');

			$isExists = $this->Crud->ciCount('categories', " `category` = '$category'");

			if ($isExists > 1) {

				$this->session->set_flashdata('warning', "Another category with this name already exists");
			} else {

				if (isset($_FILES['categoryImageModal']) && is_uploaded_file($_FILES['categoryImageModal']['tmp_name'])) {

					$config['upload_path'] = FCPATH . 'uploads/categories/';

					$config['allowed_types'] = 'gif|jpg|png';

					$config['max_size'] = 2000;

					$config['max_width'] = 1500;

					$config['encrypt_name'] = TRUE;

					$config['max_height'] = 1500;

					$this->upload->initialize($config);

					if (!$this->upload->do_upload('categoryImageModal')) {

						$error = array('error' => $this->upload->display_errors());

						$this->session->set_flashdata('warning', $this->upload->display_errors());

						redirect('categorization/category');
					} else {

						$image_metadata = $this->upload->data();

						$categoryFileName = $image_metadata['file_name'];
					}

					$data = [

						'category' => $this->input->post('editCategoryText'),

						'file_name' => $categoryFileName

					];
				} else {

					$data = [

						'category' => $this->input->post('editCategoryText')

					];
				}

				if ($this->Crud->ciUpdate('categories', $data, " `category_id` = '$categoryId'"))

					$this->session->set_flashdata('success', "Changes saved");

				else

					$this->session->set_flashdata('danger', "Something went wrong");
			}

			redirect('categorization/category');
		} else {

			$this->category();
		}
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

		if ($this->Crud->ciUpdate($tableName, $data, $condition))

			$this->session->set_flashdata('success', "Success! Changes saved");

		else

			$this->session->set_flashdata('danger', "Something went wrong");

		$referer = basename($_SERVER['HTTP_REFERER']);

		redirect('categorization/' . $referer);
	}

	public function changecategoryStatus()
	{

		$tableName = $this->uri->segment(3);

		$status = $this->uri->segment(4);

		$conditionId = $this->uri->segment(5);

		$condition = " `category_id` = '$conditionId'";

		$data = [

			'is_active' => $status

		];

		if ($this->Crud->ciUpdate($tableName, $data, $condition))

			$this->session->set_flashdata('success', "Success! Changes saved");

		else

			$this->session->set_flashdata('danger', "Something went wrong");

		$referer = basename($_SERVER['HTTP_REFERER']);

		redirect('categorization/' . $referer);
	}

	public function subcategory()
	{

		// $data['SUBCATEGORIES'] = $this->Crud->ciRead('subcategories', " `subcategory_id` != '0'");

		// $data['CATEGORIES'] = $this->Crud->ciRead('categories', " `is_active` = '1'");

		$data['SUBCATEGORIES'] = $this->Workshop_Product_Model->getsubcategory();

		$data['CATEGORIES'] = $this->Workshop_Product_Model->getcategory();



		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/subcategory', $data);
		$this->load->view('layouts/footer');
	}

	public function newSubCategory()
	{

		$this->form_validation->set_rules('category_id', 'Category', 'required|trim');

		$this->form_validation->set_rules('subcategory', 'Sub-Category', 'required|trim');



		if ($this->form_validation->run()) {

			$category = $this->input->post('category_id');



			$subcategory = $this->input->post('subcategory');

			$isExists = $this->Crud->ciCount('subcategories', " `category` = '$category' AND `sub_category` = '$subcategory'");

			if ($isExists > 0) {

				$this->session->set_flashdata('warning', "Sub-Category with this category already exists");
			} else {

				$data = [

					'category_id' => $this->input->post('category_id'),

					// 'category' => $this->input->post('category'),

					'sub_category' => $this->input->post('subcategory'),

					'added_date' => date('Y-m-d'),

					'added_time' => date('H:i:s')

				];

				if ($this->Crud->ciCreate('subcategories', $data))

					$this->session->set_flashdata('success', "Sub-Category added");

				else

					$this->session->set_flashdata('danger', "Something went wrong");
			}

			redirect('categorization/subcategory');
		} else {

			$this->subcategory();
		}
	}

	// Edit subcqategory old



	// Edit subcategory Old

	public function editSubCategory()
	{

		$this->form_validation->set_rules('editSubCategoryText', 'Sub-Category', 'required|trim');

		if ($this->form_validation->run()) {

			$subCategory = $this->input->post('editSubCategoryText');

			$category = $this->input->post('editCategoryId');

			$subCategoryId = $this->input->post('editSubCategoryId');

			$isExists = $this->Crud->ciCount('subcategories', " `sub_category` = '$subCategory'");

			if ($isExists > 0) {

				$this->session->set_flashdata('warning', "Another category with this name already exists");
			} else {

				$data = [

					'sub_category' => $this->input->post('editSubCategoryText')

				];

				if ($this->Crud->ciUpdate('subcategories', $data, " `subcategory_id` = '$subCategoryId'"))

					$this->session->set_flashdata('success', "Changes saved");

				else

					$this->session->set_flashdata('danger', "Something went wrong");
			}

			redirect('categorization/subcategory');
		} else {

			$this->subcategory();
		}
	}


	// Update Subcategory alternate

	public function update_subcategory()
	{
		$cat_id = $this->input->post('editSubCategoryId');

		$subcategory = array(
			//  'category_id' => $this->input->post('category_id'),
			'sub_category' => $this->input->post('editSubCategoryText'),
		);
		$where = array('id' => $cat_id);
		$this->load->model('Workshop_Product_Model');
		$response = $this->Workshop_Product_Model->update_subcategory($subcategory, $where);
		if ($response) {
			$this->session->set_flashdata('info', 'SubCategory Updated Successfully..!');
			redirect('categorization/subcategory');
		} else {
			$this->session->set_flashdata('info', 'subCategory Name Updated Successfully..!');
			redirect('categorization/subcategory');
		}
	}

	//Update Subcategory alternate



	public function addProduct()
	{
		$this->load->helper('sms');
		// $data['SUBCATEGORIES'] = $this->Crud->ciRead('subcategories', " `id` != '0'");
		// $data['CATEGORIES'] = $this->Crud->ciRead('categories', " `is_active` = '1'");

		$data['CATEGORIES'] = $this->Workshop_Product_Model->getcategory();
		$data['SUBCATEGORIES'] = $this->Workshop_Product_Model->getsubcategory();
		if (isset($_POST['addProduct'])) {
			extract($_POST);
			if ($this->Crud->ciCount('products', " `product_name` = '$product_name'") > 0) {
				$this->session->set_flashdata('warning', 'Another product with this name already exists!');
			} else {
				$config['upload_path'] = FCPATH . 'uploads/products/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_width'] = 1500;
				$config['max_height'] = 1500;
				$config['encrypt_name'] = TRUE;
				$this->load->library('image_lib');
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$mainImage = '';
				if (!$this->upload->do_upload('productImage')) {
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
					$mainImage = $image_metadata['file_name'];


					$this->Crud->ciCreate('products', array(



						'product_name' => $this->input->post('product_name'),
						'category_id' => $this->input->post('category_id'),
						'subcategory_id' => $this->input->post('subcategory_id'),
						'market_price' => $this->input->post('market_price'),
						'actual_price' => $this->input->post('actual_price'),
						'GST_percent' => $this->input->post('GST_percent'),
						'cake_price' => $this->input->post('cake_price'),
						'productImage' => $mainImage,
						'description' => $this->input->post('description'),
						'stock' => $this->input->post('stock'),
						'added_date' => date('Y-m-d'),
						'expiry_date' => date('Y-m-d'),

						'added_time' => date('H:i:s')

					));

					/**
					 * adding combo starts
					 */
					$comboCode = generateComboCode();
					$this->Crud->ciCreate('combos', array(
						'combo_code' => $comboCode,
						'total_price' => 2000,
						'added_on' => time()
					));
					$this->Crud->ciCreate('combo_products', array(
						'combo_code' => $comboCode,
						'product_id' => $this->Crud->ciRead('products', " `id` <> '0' ORDER BY `id` DESC LIMIT 1")[0]->id,
						'added_on' => time()
					));
					/**
					 * adding combo ends
					 */
					$this->session->set_flashdata('success', 'Product added successfully');
				}
			}
		}
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/add-product', $data);
		$this->load->view('layouts/footer');
	}



	//Product add By Admin



	// Product add by admin

	public function viewProduct()
	{
		// $data['PRODUCTS'] = $this->Crud->ciRead('products', " `id` <> 0");
		$data['PRODUCTS'] = $this->Workshop_Product_Model->getProducts();

		// $this->db->join("categories", "categories.category_id = products.category_id");
		// $this->db->join("subcategories", "subcategories.subcategory_id = products.subcategory_id");
		// $PRODUCTS = $this->db->get("products");
		// $data['PRODUCTS'] = $PRODUCTS->result_array();
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/view-product', $data);
		$this->load->view('layouts/footer');
	}

	public function stock()
	{
		$data['STORES'] = $this->Workshop_Store_Model->getstores();

		$data['PRODUCTS'] = $this->Crud->ciRead('products', " `id` <> 0");
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/add-stock', $data);
		$this->load->view('layouts/footer');
	}

	public function viewStock()
	{
		// $data['PRODUCTS'] = $this->Crud->ciRead('products', " `id` <> 0");
		$data['PRODUCTS'] = $this->Workshop_Product_Model->getProducts();
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/view-stocks', $data);
		$this->load->view('layouts/footer');
	}

	public function viewStockbyStore()
	{

		// 	$query = $this->db->query("select s.id, 
		// 	p.product_id, 
		// 	p.id,
		// 	p.product_name, 
		// 	s.current_stock 
		// from stock_records a
		// inner join products p on s.product_id = p.product_id
		// where s.id in 

		// (
		// 	select max(id) from stock_records 
		// 	group by product_id
		// )
		// order by p.id
		// ");
		// 	$data = array();
		// 	if ($query !== FALSE && $query->num_rows() > 0) {
		// 		foreach ($query->result_array() as $row) {
		// 			$data["STOCK"] = $row;
		// 		}
		// 	}

		// 	return $data;
		// $data['STOCK'] = $query->row();

		$data['STOCK'] = $this->Workshop_Product_Model->getStockbystore();
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

					'store_id' => $this->session->userdata('abWorkshopId'),
					'product_id' => $product,
					'previous_stock' => $productDetails[0]->stock,
					'current_stock' => (int)$productDetails[0]->stock + (int)$quantity,
					'updated_on' => time()
				));
				$this->session->set_flashdata('success', 'Stock updated successfully');
			} else {
				$this->session->set_flashdata('danger', 'Something went wrong, please try again.');
			}
		}
		redirect('categorization/stock');
	}

	//Edit Product page View
	public function editProduct()
	{
		$productKey = $this->uri->segment(3);
		$isExists = $this->Crud->ciCount('products', " `id` = '$productKey'");
		if ($isExists < 1) {
			$this->session->set_flashdata('danger', "Product not found");
			redirect('categorization/viewProduct');
		} else {
			// $data['PRODUCT_DETAILS'] = $this->Crud->ciRead('products', " `id` = '$productKey'");
			$data['PRODUCT_DETAILS'] = $this->Workshop_Product_Model->getProducts();
		}
		// $data['CATEGORIES'] = $this->Crud->ciRead('categories', " `is_active` = '1'");
		// $data['SUB_CATEGORIES'] = $this->Crud->ciRead('subcategories', " `is_active` = '1'");

		$data['CATEGORIES'] = $this->Workshop_Product_Model->getcategory();
		$data['SUBCATEGORIES'] = $this->Workshop_Product_Model->getsubcategory();

		$data['PRODUCTS'] = $this->Crud->ciRead('products', " `id` <> 0");
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/edit-product', $data);
		$this->load->view('layouts/footer');
	}

	//edit product

	public function editProduct_new($id)
	{


		$data['PRODUCT_DETAILS'] = $this->Workshop_Product_Model->getproduct_edit($id);

		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/edit-product', $data);
		$this->load->view('layouts/footer');
	}
	//edit product


	//Edit Product Method
	public function editThisProduct()
	{
		$productKey = $this->uri->segment(3);
		$isExists = $this->Crud->ciCount('products', " `id` = '$productKey'");
		if ($isExists < 1) {
			$this->session->set_flashdata('danger', "Product not found");
			redirect('categorization/viewProduct');
		}
		if (isset($_POST['editProduct'])) {
			extract($_POST);
			$this->Crud->ciUpdate('products', array(
				'product_name' => $this->input->post('product_name'),
				'category_id' => $this->input->post('category_id'),
				'subcategory_id' => $this->input->post('subcategory_id'),
				'market_price' => $this->input->post('market_price'),
				'actual_price' => $this->input->post('actual_price'),
				'GST_percent' => $this->input->post('GST_percent'),
				'cake_price' => $this->input->post('cake_price'),
				'description' => $this->input->post('description'),
				'stock' => $this->input->post('stock'),
			), " `id` = '$productKey'");
			$config['upload_path'] = FCPATH . 'uploads/products/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_width'] = 1500;
			$config['max_height'] = 1500;
			$config['encrypt_name'] = TRUE;
			$this->load->library('image_lib');
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (isset($_FILES['productImage']) && is_uploaded_file($_FILES['productImage']['tmp_name'])) {
				$image_metadata = $this->upload->data();
				if (!$this->upload->do_upload('productImage')) {
					$this->session->set_flashdata('warning', 'Product image error: ' . $this->upload->display_errors());
				} else {
					$configer =  array(
						'image_library' => 'gd2',
						'source_image' =>  $image_metadata['full_path'],
						'maintain_ratio' =>  TRUE,
						'width' =>  400,
						'height' =>  400,
					);
					$this->image_lib->clear();
					$this->image_lib->initialize($configer);
					$this->image_lib->resize();
					$dataCover = [
						'productImage' => $image_metadata['file_name']
					];
					$this->Crud->ciUpdate('products', $dataCover, " `id` = '$productKey'");
				}
			}
			$this->session->set_flashdata('success', "Product details updated");
			redirect('categorization/viewProduct');
		}
	}

	//Update Product Details Alternate KK Begin

	public function update_product()
	{
		$product_id = $this->uri->segment(3);
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');

		if ($this->form_validation->run()) {
			$new_photo = NULL;
			$photo = $_FILES['productImage']['name'];
			if ($photo != '') {
				$photoExt1 = @end(explode('.', $photo));
				$phototest1 = strtolower($photoExt1);
				$new_photo = time() . '.' . $phototest1;
				$photo_path = FCPATH . 'uploads/products/' . $new_photo;

				move_uploaded_file($_FILES['productImage']['tmp_name'], $photo_path);
			}

			$product = array(
				'product_name' => $this->input->post('product_name'),
				'category_id' => $this->input->post('category_id'),
				'subcategory_id' => $this->input->post('subcategory_id'),
				'market_price' => $this->input->post('market_price'),
				'cake_price' => $this->input->post('cake_price'),
				'actual_price' => $this->input->post('actual_price'),
				'GST_percent' => $this->input->post('GST_percent'),
				'cake_price' => $this->input->post('cake_price'),
				'description' => $this->input->post('description'),
				'stock' => $this->input->post('stock'),

			);
			$addproduct = new Workshop_Product_Model;
			$checking = $addproduct->updateproduct($product, $product_id);
			if ($new_photo != NULL) {

				$product = array(


					'productImage' => $new_photo,
				);
				$addproduct->updateproduct($product, $product_id);
			}
			if ($checking) {
				$this->session->set_flashdata('info', 'Product Details updated Successfully..!');
				redirect('categorization/viewProduct');
			} else {
				$this->session->set_flashdata('status', 'Category Not Added');
				redirect('categorization/viewProduct');
			}
		}
	}

	//Update Product Details alternate KK End

	public function createCombo()
	{
		$data['PRODUCTS'] = $this->Crud->ciRead('products', " `is_active` = '1'");
		if (isset($_POST['add'])) {
			$this->load->helper('sms');
			extract($_POST);
			if (count($products) > 0) {
				$comboCode = generateComboCode();
				$this->Crud->ciCreate('combos', array(
					'combo_code' => $comboCode,
					'total_price' => $price,
					'added_on' => time()
				));
				foreach ($products as $key => $value) {
					$this->Crud->ciCreate('combo_products', array(
						'combo_code' => $comboCode,
						'product_id' => $value,
						'added_on' => time()
					));
				}
				$this->session->set_flashdata('success', "Combo Created");
			} else {
				$this->session->set_flashdata('danger', "Please select products");
			}
			redirect('categorization/createCombo');
		}
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/create-combo', $data);
		$this->load->view('layouts/footer');
	}

	public function viewCombos()
	{
		$data['COMBOS'] = $this->Crud->ciRead('combos', " `combo_id` <> '1'");
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/view-combos', $data);
		$this->load->view('layouts/footer');
	}

	public function changeStatusCombo()
	{

		$tableName = $this->uri->segment(3);

		$status = $this->uri->segment(4);

		$conditionId = $this->uri->segment(5);

		$condition = " `combo_id` = '$conditionId'";

		$data = [

			'is_active' => $status

		];

		if ($this->Crud->ciUpdate($tableName, $data, $condition))

			$this->session->set_flashdata('success', "Success! Changes saved");

		else

			$this->session->set_flashdata('danger', "Something went wrong");

		$referer = basename($_SERVER['HTTP_REFERER']);

		redirect('categorization/' . $referer);
	}

	public function orders()
	{
		if ($this->uri->segment(3) && $this->uri->segment(4)) {
			$s3 = $this->uri->segment(3);
			$s4 = $this->uri->segment(4);
			if ($s3 == 'takeaway' && $s4 == 'pending') {
				$data['ORDERS'] = $this->Crud->ciRead('user_orders', " `delivery_type` = 'Take away' AND (`status` = '0' OR `status` = '2')");
			}
			if ($s3 == 'homedelivery' && $s4 == 'pending') {
				$data['ORDERS'] = $this->Crud->ciRead('user_orders', " `delivery_type` = 'Home Delivery' AND (`status` = '0' OR `status` = '2')");
			}
			if ($s3 == 'all' && $s4 == 'delivered') {
				$data['ORDERS'] = $this->Crud->ciRead('user_orders', " `status` = '1'");
			}
			if ($s3 == 'all' && $s4 == 'cancelled') {
				$data['ORDERS'] = $this->Crud->ciRead('user_orders', " `status` = '3'");
			}
			if (isset($_POST['cancel'])) {
				extract($_POST);
				$this->Crud->ciUpdate('user_orders', array(
					'status' => 3,
					'cancelled_on' => time()
				), " `order_id` = '$orderId'");
				$this->session->set_flashdata('success', "Order cancelled with order number: ", $orderId);
				redirect('categorization/orders/' . $s3 . '/' . $s4);
			}
			if (isset($_POST['deliver'])) {
				extract($_POST);
				$this->Crud->ciUpdate('user_orders', array(
					'status' => 1,
					'delivered_on' => time()
				), " `order_id` = '$orderId'");
				$this->session->set_flashdata('success', "Order delivered with order number: ", $orderId);
				redirect('categorization/orders/' . $s3 . '/' . $s4);
			}
			if (isset($_POST['dispatch'])) {
				extract($_POST);
				$this->Crud->ciUpdate('user_orders', array(
					'status' => 2,
					'shipment_number' => $shipment_number
				), " `order_id` = '$orderId'");
				$this->session->set_flashdata('success', "Order dispatched with order number: ", $orderId);
				redirect('categorization/orders/' . $s3 . '/' . $s4);
			}
		} else {
			redirect('dashboard');
		}
		$this->load->view('layouts/header');
		$this->load->view('layouts/bar');
		$this->load->view('layouts/sub-header');
		$this->load->view('layouts/nav');
		$this->load->view('categorization/orders', $data);
		$this->load->view('layouts/footer');
	}


	//Suspend Subcategory by admin

	public function block_subcategory()
	{
		$id = $this->uri->segment(3);

		$result = $this->Workshop_Product_Model->subcategorystatus([


			'is_active' => 0, //Block already active  category


		], $id);

		if ($result) {

			$this->session->set_flashdata('success', "Sub Category Blocked");
		}

		return redirect('categorization/subcategory');
	}

	//UnBlock Subcategory by admin

	public function unblock_subcategory()
	{
		$id = $this->uri->segment(3);

		$result = $this->Workshop_Product_Model->subcategorystatus([


			'is_active' => 1, //Unblock Subcategory

		], $id);

		if ($result) {
			$this->session->set_flashdata('success', "Sub Category Unblock Successfully");
		}

		return redirect('categorization/subcategory');
	}


	//Suspend product by admin

	public function block_product()
	{
		$id = $this->uri->segment(3);

		$result = $this->Workshop_Product_Model->productstatus([


			'is_active' => 0, //Block already active  product


		], $id);

		if ($result) {
			$this->session->set_flashdata('warning', "Product Blocked Successfully");
		}

		return redirect('categorization/viewProduct');
	}

	//UnBlock product by admin

	public function unblock_product()
	{
		$id = $this->uri->segment(3);

		$result = $this->Workshop_Product_Model->productstatus([


			'is_active' => 1, //Reopen   product

		], $id);

		if ($result) {
			$this->session->set_flashdata('success', "Product Unblocked Successfully");
		}

		return redirect('categorization/viewProduct');
	}
}
