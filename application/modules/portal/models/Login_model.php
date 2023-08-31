<?php 
class Login_model extends CI_Model
{
	
	public function get_login($email,$password)
	{
		$this->db->select('id');
		$this->db->select('first_name');
		$this->db->select('last_name');
		$this->db->select('email');
		$this->db->select('password');
		$this->db->select('user_type');
		$this->db->where('email',$email);
		$this->db->where('status',1);
		$query=$this->db->get('users');
		return $query->row();	
	}
	public function check_email($email)
	{
		$this->db->select('*');
		$this->db->where('email',$email);
		$query = $this->db->get('users');
		return $query->num_rows();
	}

	public function update_last_login() {
		$this->db->set('last_login', date('Y-m-d H:i:s'));
		$this->db->where('id', $this->session->userdata('admin_id'));
		$query=$this->db->update('users');
		return $this->db->affected_rows();
	}

	public function get_details($email)
	{
		$this->db->select('first_name');
		$this->db->select('last_name');
		$this->db->select('email');
		$this->db->where('email',$email);
		$query=$this->db->get('users');
		return $query->row();	
	}

	public function set_admin_password($email, $new_password)
	{
		$hash_pass = password_hash($new_password, PASSWORD_BCRYPT);
		$this->db->set('password',$hash_pass);
		$this->db->where('email',$email);
		$query=$this->db->update('users');
		return $this->db->affected_rows();
	}		
}

?>