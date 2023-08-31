<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_detail() {
		$this->db->select('*');
		$this->db->where('id', $this->session->userdata('admin_id'));
		$query = $this->db->get('users');
		return $query->row_array();
	}

	public function change_admin_password($data)
	{
		$hash_pass = password_hash($data['new_password'], PASSWORD_BCRYPT);
		$this->db->set('password',$hash_pass);
		$this->db->where('email', $this->session->userdata('admin_email'));
		$this->db->where('id', $this->session->userdata('admin_id'));
		$result = $this->db->update('users');
		return $this->db->affected_rows();
	}

	public function check_old_password($data)
	{
		$this->db->select('*');
		$this->db->where('id', $this->session->userdata('admin_id'));
		$query = $this->db->get('users');
		$user = $query->row_array();
		if (password_verify($data['old_password'], $user['password'])) {
			return true;
		} else {
			return false;
		}
	}

	public function check_new_password($data)
	{
		$hash_pass = password_hash($data['new_password'], PASSWORD_BCRYPT);
		$this->db->select('*');
		$this->db->where('password',$hash_pass);
		$this->db->where('id', $this->session->userdata('admin_id'));
		$query = $this->db->get('users');
		return $query->num_rows();
	}

	public function update_profile($data)
	{
		$this->db->set('first_name', $data['first_name']);
		$this->db->set('last_name', $data['last_name']);
		$this->db->set('mobile', $data['mobile']);
		$this->db->set('bank_name', $data['bank_name']);
		$this->db->set('account_title', $data['account_title']);
		$this->db->set('account_number', $data['account_number']);
		$this->db->set('cnic_number', $data['cnic_number']);
		if(!empty($data['cnic_front_side'])) {
			$this->db->set('cnic_front_side', $data['cnic_front_side']);
		}
		if(!empty($data['cnic_back_side'])) {
			$this->db->set('cnic_back_side', $data['cnic_back_side']);
		}
		$this->db->set('updated_at', date('Y-m-d H:i:s'));
		$this->db->where('id', $this->session->userdata('admin_id'));
		$query = $this->db->update('users');
		return $this->db->affected_rows();
	}
}