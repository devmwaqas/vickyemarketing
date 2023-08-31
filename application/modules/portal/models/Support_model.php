<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_reports()
	{
		$this->db->select("reports.*");
		$this->db->select("issue_types.name as issue_type");
		$this->db->select("orders.order_number");
		$this->db->from("reports");
		$this->db->join('issue_types', 'issue_types.id = reports.issue_id', 'left');
		$this->db->join('orders', 'orders.id = reports.order_id', 'left');
		$this->db->join('products', 'products.id = orders.product_id', 'left');
		if($this->session->userdata('admin_type') == 2)
		{
			$this->db->where('reports.user_id', $this->session->userdata('admin_id'));
		}

		if($this->session->userdata('admin_type') == 1)
		{
			$this->db->where('products.created_by', $this->session->userdata('admin_id'));
		}

		$this->db->where('reports.status', 0);

		$this->db->order_by('reports.id', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_report_details($id)
	{
		$this->db->select("reports.*");
		$this->db->select("CONCAT((users.first_name),(' '),(users.last_name)) as username");
		$this->db->select("orders.order_number");
		$this->db->select("issue_types.name as issue_type");
		$this->db->from("reports");
		$this->db->join('users', 'users.id = reports.user_id', 'left');
		$this->db->join('orders', 'orders.id = reports.order_id', 'left');
		$this->db->join('products', 'products.id = orders.product_id', 'left');
		$this->db->join('issue_types', 'issue_types.id = reports.issue_id', 'left');

		if($this->session->userdata('admin_type') == 2)
		{
			$this->db->where('reports.user_id', $this->session->userdata('admin_id'));
		}

		if($this->session->userdata('admin_type') == 1)
		{
			$this->db->where('products.created_by', $this->session->userdata('admin_id'));
		}
		$this->db->where('reports.status', 0);
		$this->db->where('reports.id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_report_messages($id)
	{
		$this->db->select("report_messages.*");
		$this->db->select("CONCAT((users.first_name),(' '),(users.last_name)) as username");
		$this->db->from("report_messages");
		$this->db->join('users', 'users.id = report_messages.sender_id', 'left');
		$this->db->where('report_messages.report_id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function submit_message($data)
	{
		$this->db->set('report_id', $data["report_id"]);
		$this->db->set('message',$data["message"]);
		$this->db->set('sender_id', $this->session->userdata('admin_id'));
		if(!empty($data["attachment"])) {
			$this->db->set('attachment',$data["attachment"]);
		}
		$this->db->set('created_at',date('Y-m-d H:i:s'));
		$this->db->insert('report_messages');
		return $this->db->insert_id();
	}

	public function mark_resolved($report_id)
	{
		$this->db->set('status', 1);
		$this->db->set('updated_by', $this->session->userdata('admin_id'));
		$this->db->set('updated_at',date('Y-m-d H:i:s'));
		$this->db->where('id', $report_id);
		$query = $this->db->update('reports');
		return $this->db->affected_rows();
	}

}