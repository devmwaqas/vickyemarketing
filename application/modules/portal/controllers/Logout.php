<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();			
	}

	public function index()
	{
		$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value) {
			$this->session->unset_userdata($key);
		}
		redirect(base_url());
	}

}
