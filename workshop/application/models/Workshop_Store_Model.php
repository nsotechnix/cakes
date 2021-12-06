<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Workshop_Store_Model extends CI_Model
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
}
