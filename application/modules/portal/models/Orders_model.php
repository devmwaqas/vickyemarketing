<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_orders()
	{
		$this->db->select("orders.*");
		$this->db->select("orders.id as order_id");
		$this->db->select("orders.status as order_status");
		$this->db->select("products.*");
		$this->db->select("products.id as product_id");
		$this->db->select("users.first_name");
		$this->db->select("users.last_name");
		$this->db->select("categories.cat_name");
		$this->db->select("product_types.name as product_type");
		$this->db->select("markets.name as market_name");
		$this->db->from("orders");
		$this->db->join('products', 'products.id = orders.product_id', 'left');
		$this->db->join('users', 'users.id = orders.user_id', 'left');
		$this->db->join('categories', 'categories.id = products.category_id', 'left');
		$this->db->join('product_types', 'product_types.id = products.product_type_id', 'left');
		$this->db->join('markets', 'markets.id = products.market_id', 'left');
		if($this->session->userdata('admin_type') == 2)
		{
			$this->db->where('orders.user_id', $this->session->userdata('admin_id'));
		}

		if(!empty($_GET['target'])) {
			($_GET['target'] == 10) ? $target = 0 : $target = $_GET['target'];
			$this->db->where('orders.status', $target);
		}

		if($this->session->userdata('admin_type') == 1)
		{
			$this->db->where('products.created_by', $this->session->userdata('admin_id'));
		}

		$this->db->order_by('orders.updated_at', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_search_orders($data)
	{
		$this->db->select("orders.*");
		$this->db->select("orders.id as order_id");
		$this->db->select("orders.status as order_status");
		$this->db->select("products.*");
		$this->db->select("products.id as product_id");
		$this->db->select("users.first_name");
		$this->db->select("users.last_name");
		$this->db->select("categories.cat_name");
		$this->db->select("product_types.name as product_type");
		$this->db->select("markets.name as market_name");
		$this->db->from("orders");
		$this->db->join('products', 'products.id = orders.product_id', 'left');
		$this->db->join('users', 'users.id = orders.user_id', 'left');
		$this->db->join('categories', 'categories.id = products.category_id', 'left');
		$this->db->join('product_types', 'product_types.id = products.product_type_id', 'left');
		$this->db->join('markets', 'markets.id = products.market_id', 'left');
		if($this->session->userdata('admin_type') == 2)
		{
			$this->db->where('orders.user_id', $this->session->userdata('admin_id'));
		}

		if(!empty($data['cust_email_id'])) {
			$this->db->where('orders.customer_email', trim(xss_clean($data['cust_email_id'])));
		}

		if(!empty($data['product_id'])) {
			$this->db->where('orders.product_id', trim(xss_clean($data['product_id'])));
		}

		if(!empty($data['order_number'])) {
			$this->db->where('orders.order_number', trim(xss_clean($data['order_number'])));
		}

		if($this->session->userdata('admin_type') == 1)
		{
			$this->db->where('products.created_by', $this->session->userdata('admin_id'));
		}

		$this->db->order_by('orders.updated_at', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_order_details($id)
	{
		$this->db->select("orders.*");
		$this->db->select("orders.id as order_id");
		$this->db->select("orders.status as order_status");
		$this->db->select("products.*");
		$this->db->select("products.id as product_id");
		$this->db->select("users.first_name");
		$this->db->select("users.last_name");
		$this->db->select("categories.cat_name");
		$this->db->select("product_types.name as product_type");
		$this->db->select("markets.name as market_name");
		$this->db->from("orders");
		$this->db->join('products', 'products.id = orders.product_id', 'left');
		$this->db->join('users', 'users.id = orders.user_id', 'left');
		$this->db->join('categories', 'categories.id = products.category_id', 'left');
		$this->db->join('product_types', 'product_types.id = products.product_type_id', 'left');
		$this->db->join('markets', 'markets.id = products.market_id', 'left');
		$this->db->where('orders.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function update_order($data)
	{
		$this->db->set('order_number',$data["order_number"]);
		$this->db->set('amz_review_link',$data["amz_review_link"]);
		$this->db->set('remarks',$data["remarks"]);

		if(!empty($data["order_pic"])) {
			$this->db->set('order_pic',$data["order_pic"]);
		}

		if(!empty($data["review_pic"])) {
			$this->db->set('review_pic',$data["review_pic"]);
		}

		if(!empty($data["refund_pic"])) {
			$this->db->set('refund_pic',$data["refund_pic"]);
		}
		$this->db->set('status', $data["status"]);
		$this->db->set('updated_by', $this->session->userdata('admin_id'));
		$this->db->set('order_date',date('Y-m-d'));
		$this->db->set('updated_at',date('Y-m-d H:i:s'));
		$this->db->where('id', $data["id"]);
		$query = $this->db->update('orders');
		return $this->db->affected_rows();
	}

	public function change_status($order_id, $status)
	{
		$this->db->set('status', $status);
		$this->db->set('updated_by', $this->session->userdata('admin_id'));
		$this->db->set('updated_date',date('Y-m-d H:i:s'));
		$this->db->where('id', $order_id);
		$query = $this->db->update('orders');
		return $this->db->affected_rows();
	}

	public function submit_report($order_id, $issue_type)
	{
		$this->db->set('order_id', $order_id);
		$this->db->set('issue_id', $issue_type);
		$this->db->set('user_id', $this->session->userdata('admin_id'));
		$this->db->set('created_at',date('Y-m-d H:i:s'));
		$query = $this->db->insert('reports');

		if($this->db->insert_id() > 0) {

			$this->db->set('status', 2);
			$this->db->set('updated_by', $this->session->userdata('admin_id'));
			$this->db->set('updated_at',date('Y-m-d H:i:s'));
			$this->db->where('id', $order_id);
			$query = $this->db->update('orders');
			return $this->db->affected_rows();

		} else {
			return false;
		}

	}

}