<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login/');
		}
		$this->load->model(admin_controller().'admin_model');
	}

	public function index()
	{
		$data['profile_detail'] = $this->admin_model->get_detail();
		$this->load->view('profile', $data);
	}

	public function update_profile()
	{
		$data = $_POST;
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('account_title', 'Account Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
		$this->form_validation->set_rules('cnic_number', 'CNIC Number', 'trim|required|xss_clean');

		$data['cnic_front_side'] = '';
		if (!empty($_FILES['cnic_front_side']['name']))
		{
			$config['upload_path']          = FCPATH.'assets/pictures/cards/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2000;
			$config['max_width']            = 1024;
			$config['max_height']           = 1024;
			$config['encrypt_name']         = TRUE;
			$this->load->library('upload', $config);
			if($this->upload->do_upload('cnic_front_side')) {
				$upload_data = $this->upload->data();
				$data['cnic_front_side'] = $upload_data['file_name'];
			} else {
				$finalResult = array('msg' => 'error', 'response'=> $this->upload->display_errors());
				echo json_encode($finalResult);
				exit;
			}
		}

		$data['cnic_back_side'] = '';
		if (!empty($_FILES['cnic_back_side']['name']))
		{
			$config['upload_path']          = FCPATH.'assets/pictures/cards/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2000;
			$config['max_width']            = 1024;
			$config['max_height']           = 1024;
			$config['encrypt_name']         = TRUE;
			$this->load->library('upload', $config);
			if($this->upload->do_upload('cnic_back_side')) {
				$upload_data = $this->upload->data();
				$data['cnic_back_side'] = $upload_data['file_name'];
			} else {
				$finalResult = array('msg' => 'error', 'response'=> $this->upload->display_errors());
				echo json_encode($finalResult);
				exit;
			}
		}

		if ($this->form_validation->run($this) == FALSE)
		{
			$finalResult = array('msg' => 'error', 'response'=>validation_errors());
			echo json_encode($finalResult);
			exit;
		} else {

			$status = $this->admin_model->update_profile($data);
			if($status){
				$finalResult = array('msg' => 'success', 'response'=>'<p>Successfully updated.</p>');
				echo json_encode($finalResult);
				exit;
			}else{
				$finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
				echo json_encode($finalResult);
				exit;
			}
		}
	}

}