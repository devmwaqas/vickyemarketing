<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		if($this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'dashboard/');
		}
		$this->load->model(admin_controller().'login_model');
	}
	public function index()
	{
		$this->load->view('forgot_password');
	}
	public function retrieve_password()
	{
		if($_POST) {
			$data = $_POST;
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|callback_email_exist');

			if ($this->form_validation->run($this) == FALSE)
			{
				$finalResult = array('msg' => 'error', 'response'=>validation_errors());
				echo json_encode($finalResult);
				exit;
			}else{
				$this->load->helper('string');
				$data['password'] = random_string('alnum',8);
				$status = $this->login_model->set_admin_password($data['email'] , $data['password']);
				if($status){
					$data['admin_details'] = $this->login_model->get_details($data['email']);
					$htmlresponse = $this->load->view('recover_pass_email', $data, TRUE);
					$this->send_confirmation_email( $data['email'] , $htmlresponse);    
					$finalResult = array('msg' => 'success', 'response'=>'Password updated please check your email inbox!');
					echo json_encode($finalResult);
					exit;
				} else {
					$finalResult = array('msg' => 'error', 'response'=>'Something went wrong !');
					echo json_encode($finalResult);
					exit;
				}
			}
		} else {
			show_admin404();
		}
	}
	public function email_exist($email)
	{
		$email = $this->login_model->check_email($email);
		if ($email > 0)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('email_exist', 'This email is not exist.');
			return FALSE;
		}
	}

	public function send_confirmation_email($user_email , $email_body)
	{
		$to = $user_email;
		$subject = 'Forgot Password';
		$body = $email_body;
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <no-reply@vicky-marketing.com>' . "\r\n";
		@mail($to,$subject,$body,$headers);
	}
}
