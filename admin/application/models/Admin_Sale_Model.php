<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_Sale_Model extends CI_Model
{

    function get_product()
    {

        $query = $this->db->select('*')
            ->from('products')
            ->WHERE('stock > 0')->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function bps_table($table, $pr_key)
    {


        $this->_table_name = $table;
        $this->_primary_key = $pr_key;
    }


    // get max sales no
    public function get_sales_max()
    {
        $this->db->select_max('sales_no');
        $q = $this->db->get('sales');
        $data = $q->row();
        return $data;
    }

    // get all sales

    function select_sales()
    {

        $this->db->select("*");

        $this->db->join("cashier", "cashier.id = sales.cashier_id");
        // $this->db->join("products", "products.id = sales.cashier_id");
        $this->db->order_by("sales_no", "DESC");

        $query = $this->db->get('sales');

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }


    //Get Sales by Today




    function select_all_product()
    {

        $this->db->select("*");


        $query = $this->db->get('products');

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


    // Report of sale by date interval alt
    function select_sales_by_date1($id, $start_date, $end_date)
    {

        $this->db->select("*");

        $this->db->where('cashier_id', $id);
        $this->db->where('sales_date >=', $start_date);
        $this->db->where('sales_date >=', $end_date);
        $query = $this->db->get('sales');

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    // Report of sale by date interval
    public function select_sales_by_date($id, $start_date, $end_date)
    {
        $query = $this->db->select("*

        ")
            ->from('sales')
            ->where('cashier_id', $id)
            // ->join("sales_detail", "sales_detail.sales_no = sales.sales_no")
            // ->join("products", "products.id = sales_detail.product_id")
            ->where('sales_date >=', $start_date)
            ->where('sales_date <=', $end_date)
            ->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    //Show all report by default
    public function select_sales_all($id)
    {
        $query = $this->db->select("*

        ")
            ->from('sales')
            ->where('cashier_id', $id)
            // ->join("sales_detail", "sales_detail.sales_no = sales.sales_no")
            // ->join("products", "products.id = sales_detail.product_id")
            ->get();


        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }


    // get Sale product by id
    public function get_sales($product_id)
    {
        $sql = $this->db->query("SELECT
                 id,
                 product_name,
                 market_price,
                 added_date,
                 cake_price,
                 actual_price,
                 expiry_date,
                 stock,
                 category_id
              
                 
                 FROM
                 products
                
                
                 WHERE id=$product_id
                 ");
        return $sql->row();
    }


    // get maximum sales no
    public function get_sale_max()
    {
        $this->db->select_max('sales_no');
        $q = $this->db->get('sales');
        $data = $q->row();
        return $data;
    }

    // get max sale id
    public function get_sale_max1()
    {
        $this->db->select_max('sales_id');
        $q = $this->db->get('sales_detail');
        $data = $q->row();
        return $data;
    }

    // get stock quantity
    public function get_stock_qty($item, $category = '')
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('id', $item);
        if ($category != '') :
            $this->db->where('category_id', $category);
        endif;
        $query = $this->db->get();
        return $query->row();
    }

    // check stock 
    public function check_stock_record($item, $category)
    {
        $query = $this->db->select('*');
        $this->db->from('products');
        $this->db->where('id', $item);
        $this->db->where('category_id', $category);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // add record
    function add_record($table, $array_data)
    {
        $query = $this->db->insert($table, $array_data);
        if ($query == 1)
            return $query;
        else
            return false;
    }

    //update record
    function update_record($table, $update, $id)
    {
        $this->db->where($id);
        $query = $this->db->update($table, $update);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }



    function update_sales($update, $id)
    {
        $this->db->where($id);
        $query = $this->db->update('sales', $update);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    function update_sales_detail($update, $id)
    {
        $this->db->where($id);
        $query = $this->db->update('sales_detail', $update);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    //Update Ledger record
    function update_sales_ledger($update, $id)
    {
        $this->db->where($id);
        $query = $this->db->update('sales_ledger', $update);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    //update sales record
    function update_sales_ledger1($update, $id)
    {
        $this->db->where($id);
        $query = $this->db->update('sales', $update);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    // get history of Sales
    public function get_salesHistory($saleNO)
    {
        $this->db->select('sales_detail.sales_no,
            sales_detail.sales_qty,
            sales_detail.sales_amount,

            categories.id,
            categories.category,
            subcategories.id,
            subcategories.subcategory,
			products.id,
			products.product_name,
            products.stock,
			
			sales_detail.sales_id,
			sales_detail.sales_qty,
			sales_detail.sales_amount,
			sales_detail.product_price,
            sales_detail.product_discount_percent,
			sales_detail.product_discount_amount,
            
			sales.customer_name,
            sales.customer_phone,
            sales.sales_date,
			sales.sales_time,
			sales.sales_paid_amount,
			
			`sales`.`sales_balance_amount`,
			`sales`.`grand_total`')
            ->from('products,sales_detail,sales,categories,subcategories')
            ->where('products.id = sales_detail.product_id')
            ->where('products.category_id = categories.id')
            ->where('products.subcategory_id = subcategories.id')
            ->where('sales.sales_no = sales_detail.sales_no')
            ->where('sales_detail.sales_no', $saleNO);
        $query = $this->db->get();

        // echo $query->num_rows();
        // return $query->result_array();

        $afftectedRows = $this->db->affected_rows();
        if ($afftectedRows == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Get ledger receipt

    public function get_ledgerReceipt($saleNO)
    {

        $this->db->where('sales.sales_no', $saleNO);
        $this->db->join("sales", "sales.sales_no = sales_ledger.sales_no");
        $query = $this->db->get('sales_ledger');
        echo $query->num_rows();
        return $query->result_array();
    }

    //Get sales receipt
    public function get_saleInvoice($saleNO)
    {

        $this->db->where('sales.sales_no', $saleNO);
        $this->db->join("sales", "sales.sales_no = sales_detail.sales_no");
        $this->db->join("products", "products.id = sales_detail.product_id");
        $query = $this->db->get('sales_detail');
        echo $query->num_rows();
        return $query->result_array();
    }
    public function saleReceipt($saleNO)
    {

        $this->db->join("products", "products.id = sales_detail.product_id");
        $this->db->join("products", "products.id = sales_detail.product_id");
        $this->db->where('client_status', 1);
        $this->db->where('branch_id', $id);
        $query = $this->db->get('client');
        echo $query->num_rows();
        return $query->result_array();
    }

    public function deletesale($id)
    {
        return $this->db->delete('sales', ['sales_no' => $id]);
    }

    public function salestatus($data1, $id)
    {

        return $this->db->set($data1)->where('sales_no', $id)->update('sales');
    }


    public function fetchsaledetails($id)
    {

        $this->db->where('sales_no', $id);
        // $this->db->join("client", "sales.client_id = client.client_id");
        $query = $this->db->get('sales');
        if ($query) {

            return $query->row();
        }
    }
    // get sales detail by sales no
    public function sales_detail($sales_no)
    {
        $query = $this->db->select()->from('sales_detail as sd,product as p, stock as s')
            ->where('sd.product_id = p.product_id')
            ->where('s.product_id = p.product_id')
            ->where($sales_no)
            ->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    //Select Pending Ledger 
    public function select_pending_ledger()
    {
        $query = $this->db->select("
        sales_ledger.ledger_id,
        sales_ledger.sales_no,
        sales_ledger.ledger_no,
        sales_ledger.ledger_date,
        sales_ledger.ledger_time,
        sales_ledger.GST_percent,
        sales_ledger.sales_round_amount,
        sales_ledger.sales_paid_amount,
        sales_ledger.due_amount,
        sales_ledger.last_payment_date,
        sales_ledger.grand_total,
        sales_ledger.cashier_id,
        cashier.name")
            ->from('sales_ledger', 'cashier')
            ->join('cashier', 'cashier.id = sales_ledger.cashier_id')
            ->order_by("sales_no", "DESC")
            ->where('sales_ledger.due_amount !=', 0.00)
            ->get();
        return $query->result();
    }

    //Select Completed Ledger 
    public function select_complete_ledger()
    {
        $query = $this->db->select("
        sales_ledger.ledger_id,
        sales_ledger.sales_no,
        sales_ledger.ledger_no,
        sales_ledger.ledger_date,
        sales_ledger.ledger_time,
        sales_ledger.GST_percent,
        sales_ledger.sales_round_amount,
        sales_ledger.sales_paid_amount,
        sales_ledger.due_amount,
        sales_ledger.last_payment_date,
       
        sales_ledger.grand_total,
        sales_ledger.cashier_id,
        cashier.name")
            ->from('sales_ledger', 'cashier')
            ->join('cashier', 'cashier.id = sales_ledger.cashier_id')
            ->order_by("sales_no", "DESC")
            ->where('sales_ledger.due_amount', 0.00)
            ->get();
        return $query->result();
    }
}
