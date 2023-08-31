<?php 
class Login_lib {

	function __construct()
	{		
		$this->ci =& get_instance();
		$this->ci->load->model($this->ci->config->item('admin_controller').'login_model');
	}
	public function validate_login($email,$password)
	{	
		$result=$this->ci->login_model->get_login($email,$password);
		if(!empty($result->id))
		{	

			if (password_verify($password, $result->password)) {

				$array=array(
					'admin_id'=>$result->id,
					'admin_username'=>$result->first_name." ".$result->last_name,
					'admin_email'=>$result->email,
					'admin_type'=>$result->user_type,
					'admin_login'=>true,
					'admin_logged_in'=>true
				);

				$this->ci->session->set_userdata($array);
				return true;

			} else {
				return false;
			}

		}else {			
			return false;			
		}
	}
	
}

