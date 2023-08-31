<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservations_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_reservations($product_id)
	{
		$this->db->select("reservations.id");
		$this->db->select("reservations.created_at");
		$this->db->select("products.id as product_id");
		$this->db->select("products.picture");
		$this->db->select("products.amz_picture");
		$this->db->select("users.first_name");
		$this->db->select("users.last_name");
		$this->db->from("reservations");
		$this->db->join('products', 'products.id = reservations.product_id', 'left');
		$this->db->join('users', 'users.id = reservations.user_id', 'left');
		if(!empty($product_id)) {
			$this->db->where('reservations.product_id', $product_id);
		}

		if($this->session->userdata('admin_type') == 2)
		{
			$this->db->where('reservations.user_id', $this->session->userdata('admin_id'));
		}
		$this->db->order_by('reservations.id', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_product_details($product_id)
	{
		$this->db->select("*");
		$this->db->from("products");
		$this->db->where('id',$product_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_details($id)
	{
		$this->db->select("*");
		$this->db->from("reservations");
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function reserve_now($product_id)
	{

		$current_date = date('Y-m-d');
		$current_datetime = date('Y-m-d H:i:s');

		$this->db->set('product_id',$product_id);
		$this->db->set('user_id', $this->session->userdata('admin_id'));
		$this->db->set('reserve_date',$current_date);
		$this->db->set('created_at', $current_datetime);
		$query = $this->db->insert('reservations');

		$reserve_id = $this->db->insert_id();
		if($reserve_id > 0){
			return $reserve_id;
		} else {
			return false;
		}
	}

	public function check_email_exist($data)
	{
		$this->db->select('*');
		$this->db->where('customer_email',$data['cust_email_id']);
		$this->db->where('product_id',$data['product_id']);
		$query = $this->db->get('orders');
		return $query->num_rows();
	}

	public function submit_order($data)
	{

		$current_date = date('Y-m-d');
		$current_datetime = date('Y-m-d H:i:s');

		$this->db->set('order_number',$data["order_number"]);
		$this->db->set('product_id',$data["product_id"]);
		$this->db->set('customer_email',$data["cust_email_id"]);
		$this->db->set('amz_review_link',$data["amz_review_link"]);
		if(!empty($data["order_pic"])) {
			$this->db->set('order_pic',$data["order_pic"]);
		}

		if(!empty($data["refund_pic"])) {
			$this->db->set('refund_pic',$data["refund_pic"]);
		}

		$this->db->set('user_id', $data["user_id"]);
		$this->db->set('created_by', $this->session->userdata('admin_id'));
		$this->db->set('order_date', $current_date);
		$this->db->set('created_at', $current_datetime);
		$this->db->set('updated_at', $current_datetime);
		$query = $this->db->insert('orders');
		$order_id = $this->db->insert_id();
		if($order_id > 0) {

			$this->db->where('id', $data["id"]);
			$query = $this->db->delete('reservations');

			return true;
		} else {
			return false;
		}
	}

	public function change_status($product_id, $status)
	{
		$this->db->set('status', $status);
		$this->db->set('updated_by', $this->session->userdata('admin_id'));
		$this->db->set('updated_date',date('Y-m-d H:i:s'));
		$this->db->where('id', $product_id);
		$query = $this->db->update('reservations');
		return $this->db->affected_rows();
	}

	public function del_reservation($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete('reservations');
		return $this->db->affected_rows();
	}

}