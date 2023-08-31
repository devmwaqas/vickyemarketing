<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_orders($start_date, $end_date, $status)
	{
		$this->db->select("orders.created_at as creation_date");
		$this->db->select("CONCAT((users.first_name),(' '),(users.last_name)) as 'PM Name'");
		$this->db->select("orders.id as order_id");
		$this->db->select("orders.order_number");
		$this->db->select("orders.customer_email");
		$this->db->select("orders.amz_review_link as AMZ_review_link");
		$this->db->select("CONCAT((users.first_name),(' '),(users.last_name)) as 'Seller'");
		$this->db->select("products.keyword as product_name");
		$this->db->select("products.chinese_seller");
		$this->db->select("markets.name as Market");
		$this->db->select("orders.status as order_status");

		$this->db->select("orders.order_pic as Order_SS_URL");
		$this->db->select("orders.review_pic as Review_SS_URL");
		$this->db->select("orders.refund_pic as Refund_SS_URL");
		$this->db->select("orders.refund_date as Refund_Date");
		$this->db->select("orders.review_date as Review_Date");

		$this->db->from("orders");
		$this->db->join('products', 'products.id = orders.product_id', 'left');
		$this->db->join('users', 'users.id = orders.user_id', 'left');
		$this->db->join('markets', 'markets.id = products.market_id', 'left');
		$this->db->where('orders.order_date >=', $start_date);
		$this->db->where('orders.order_date <=', $end_date);
		if($status != '')
		{
			$this->db->where('orders.status', $status);
		}
		$this->db->order_by('orders.order_date', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
}