<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Store_Product_Model extends CI_Model
{

	//Add category Subcategory Product 
	function addcategory($data)
	{


		return $this->db->insert('product_category', $data);
	}

	//update category
	function update_category($update, $id)
	{
		$this->db->where($id);
		$query = $this->db->update('product_category', $update);
		if ($this->db->affected_rows() > 0)
			return true;
		else
			return false;
	}

	function addsubcategory($data)
	{


		return $this->db->insert('product_subcategory', $data);
	}

	function addSpecification($data)
	{


		return $this->db->insert('product_specification', $data);
	}

	function update_specification($update, $id)
	{
		$this->db->where($id);
		$query = $this->db->update('product_specification', $update);
		if ($this->db->affected_rows() > 0)
			return true;
		else
			return false;
	}


	//update subcategory
	function update_subcategory($update, $id)
	{
		$this->db->where($id);
		$query = $this->db->update('subcategories', $update);
		if ($this->db->affected_rows() > 0)
			return true;
		else
			return false;
	}

	public function addproduct($data)
	{
		return $this->db->insert('products', $data);
	}

	public function updateproduct($data1, $product_id)
	{

		return $this->db->set($data1)->where('id', $product_id)->update('products');
	}

	//update category details
	public function updatecategory($data1, $id)
	{

		return $this->db->set($data1)->where('category_id', $id)->update('product_category');
	}

	//update category status
	public function categorystatus($data1, $id)
	{

		return $this->db->set($data1)->where('category_id', $id)->update('categories');
	}

	//update subcategory status
	public function subcategorystatus($data1, $id)
	{

		return $this->db->set($data1)->where('subcategory_id', $id)->update('subcategories');
	}

	//update product status
	public function productstatus($data1, $id)
	{

		return $this->db->set($data1)->where('id', $id)->update('products');
	}


	//Get Stores

	function getstores()
	{

		$this->db->select("store,store_id");
		$this->db->order_by("store_name", "ASC");
		$this->db->where('is_active', '1');
		$query = $this->db->get('store');

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function getcategory()
	{

		$this->db->select("category,category_id");
		$this->db->order_by("category", "ASC");
		$this->db->where('is_active', '1');
		$query = $this->db->get('categories');

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}


	function getsubcategory()
	{

		$query = $this->db->select('*')
			->order_by("subcategory_id", "DESC")

			->where("categories.category_id = subcategories.category_id")
			->from('categories,subcategories')->get();

		return $query->result();
	}


	//Stock view

	function getStockbystore()
	{

		// $query = $this->db->select("
		// stock_records.id, 
		// stock_records.store_id,
		// stock_records.product_id, 
		// products.product_id, 
		// products.id,
		// products.product_name, 

		// stock_records.current_stock 
		// ")
		// 	->from('stock_records,products')
		// 	->where('stock_records.product_id = products.product_id')
		// 	// ->where('stock_records.id')
		// 	// ->in(select max(id) 
		// 	// from("stock_records")
		// 	// group_by("product_id"))
		// 	->order_by("products.id")->get();

		$this->db->select('*');

		$this->db->join("products", "products.id = stock_records.product_id");
		$this->db->join("store", "store.store_id = stock_records.store_id");

		$query = $this->db->get('stock_records');

		return $query->result();
	}

	public function getStockbystore2($id)
	{
		$this->db->join("products", "products.id = stock_records.product_id");
		$this->db->join("store", "store.store_id = stock_records.store_id");
		$this->db->where('store_id', $id);
		$query = $this->db->get('stock_records');
		echo $query->num_rows();
		return $query->result_array();
	}


	//Stock by store alternate

	function getStockbystore1()
	{



		// $this->db->select('store_id, product_id,product_name,  COUNT(store_id) as total');
		$this->db->select('stock_records.store_id, product_id, product_name, productImage, description, added_date');
		$this->db->join("products", "products.id = stock_records.product_id");

		// $this->db->join("store", "store.store_id = stock_records.store_id");
		// $this->db->group_by('product_id');
		$this->db->group_by(array("store_id", "product_id"));
		// $this->db->order_by('total', 'desc');
		$query = $this->db->get('stock_records');
		// if ($query->num_rows() > 0) {
		// 	return $query->result();
		// }

		return $query->result();
	}




	//View product category subcategory 
	public function select_products()
	{
		$query = $this->db->select("
						products.id,
						products.product_name,
						products.category_id,
						products.subcategory_id,
						products.stock,
						products.market_price,
						products.cake_price,
						products.actual_price,
						products.GST_percent,
						products.productImage,
						products.description,
						products.added_date,
						products.added_time,
						products.is_active,

						categories.category_id,
						categories.category,
						subcategories.sub_category,
						subcategories.subcategory_id
						")
			->from('categories,subcategories,products')
			->where('subcategories.id = products.subcategory_id')
			->where('categories.id = products.category_id')->get();

		return $query->result();
	}


	//Get products view ////////////////////////
	function getProducts1()
	{

		$this->db->select('*');
		$this->db->join("categories", "categories.category_id = products.category_id");
		$this->db->join("subcategories", "subcategories.subcategory_id = products.subcategory_id");
		$query = $this->db->get('products');


		return $query->result();
	}

	function getProducts()
	{

		$query = $this->db->select('*')
			->order_by("id", "DESC")

			->where("categories.category_id = products.category_id")

			->where("subcategories.subcategory_id = products.subcategory_id")


			->from('categories,subcategories,products')->get();

		return $query->result();
	}

	//Get sproduct From Product
	function getproduct()
	{

		$this->db->select('*');
		$this->db->where('status', '1');
		$query = $this->db->get('product');

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function getproduct_edit($id)
	{

		$this->db->where('id', $id);
		// $this->db->join("jobcategory","jobcategory.job_category_id = jobdetails.job_category_id");
		// $this->db->join("client","sales.client_id = client.client_id");
		$query = $this->db->get('products');
		if ($query) {

			return $query->row();
		}
	}

	function getproductforspecs()
	{

		$this->db->select('*');
		$this->db->where('product.product_id NOT IN (select product_id from product_specification)', NULL, FALSE);

		$query = $this->db->get('product');

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}


	// Select sales by Date Interval

	// Report of sale by date interval
	public function select_sales_by_date($start_date, $end_date)
	{
		$query = $this->db->select("*")

			->from('sales')

			->where('sales_date >=', $start_date)
			->where('sales_date <=', $end_date)
			->get();


		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	//Show all sale report by default
	public function select_sales_all()
	{
		$query = $this->db->select("*")

			->from('sales')
			// ->join("sales_detail", "sales_detail.sales_no = sales.sales_no")
			// ->join("products", "products.id = sales_detail.product_id")
			->get();


		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function select_today_sales()
	{
		$query = $this->db->select("*")

			->from('sales')
			->where('sales_date BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()')
			->get();


		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	// Report of sale for current date
	function select_sales_today()
	{

		$this->db->select("*");

		$this->db->join("products", "products.id = sales_detail.product_id");
		$this->db->join("sales", "sales.sales_no = sales_detail.sales_no");
		$this->db->where('sales_date BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()');
		$query = $this->db->get('sales_detail');

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}
}
