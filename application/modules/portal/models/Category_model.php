<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_category()
	{
		$this->db->select("*");
		$this->db->from("categories");
		$query = $this->db->get();
		return $query->result_array();
	}

	public function insert_category($data)
	{
		$this->db->set('cat_name', $data["category_name"]);
		$this->db->set('parent_id', $data["parent_id"]);

		if(isset($data["status"])) {
			$this->db->set('status', 1);
		} else {
			$this->db->set('status', 0);
		}
		$this->db->set('created_at', date('Y-m-d H:i:s'));
		$query = $this->db->insert('categories');
		$inserted_id = $this->db->insert_id();
		return true;
	}

	public function get_category_by_id($category_id)
	{
		$this->db->select("*");
		$this->db->from("categories");
		$this->db->where('id', $category_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function update_category($data)
	{
		$this->db->set('cat_name', $data["category_name"]);
		$this->db->set('parent_id', $data["parent_id"]);

		if(isset($data["status"])) {
			$this->db->set('status', 1);
		} else {
			$this->db->set('status', 0);
		}
		$this->db->set('updated_at',date('Y-m-d H:i:s'));
		$this->db->where('id' , $data['category_id']);
		$query = $this->db->update('categories');
		$insertdId = $this->db->affected_rows();
		return true;
	}

	public function delete_category($category_id)
	{
		$this->db->select("*");
		$this->db->from("products");
		$this->db->where('category_id', $category_id);
		$products_result = $this->db->get();
		$products_result->row_array();
		if($products_result->num_rows() > 0) {
			return "products_exist";
		}else{
			$this->db->where('id', $category_id);
			$query = $this->db->delete('categories');
			return $this->db->affected_rows();
		}
	}

}