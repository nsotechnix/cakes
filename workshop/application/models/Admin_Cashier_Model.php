<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_Cashier_Model extends CI_Model
{


	//Get Stores

	function getstores()
	{

		$this->db->select("*");
		$this->db->order_by("store_name", "ASC");
		$this->db->where('is_active', '1');
		$query = $this->db->get('store');

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}


	//Get products view ////////////////////////
	function getCashier()
	{

		$this->db->select('*');
		$this->db->where('cashier.is_active', '1');
		$this->db->join("store", "store.store_id = cashier.store_id");
		$query = $this->db->get('cashier');


		return $query->result();
	}

	//update client status
	public function cashierstatus($data1, $id)
	{

		return $this->db->set($data1)->where('id', $id)->update('cashier');
	}
}
