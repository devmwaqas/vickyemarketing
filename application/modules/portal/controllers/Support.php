<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Support extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(admin_controller().'support_model');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login');
		}
	}

	public function index()
	{
		$data['reports'] = $this->support_model->get_reports();
		$this->load->view('support/reports_list' , $data);
	}

	public function detail($id)
	{
		$data['report_detail'] = $this->support_model->get_report_details($id);
		if (empty($data['report_detail'])) {
			redirect(admin_url().'support');
		}
		$data['messages'] = $this->support_model->get_report_messages($id);
		$this->load->view('support/report_detail', $data);
	}

	public function submit_message()
	{
		if($_POST) {

			$data = $_POST;

			$this->form_validation->set_rules('message','Message','trim|required|xss_clean');

			$data['attachment'] = '';
			if (!empty($_FILES['attachment']['name']))
			{
				$config['upload_path']          = FCPATH.'assets/pictures/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				$config['max_size']             = 2000;
				$config['max_width']            = 1024;
				$config['max_height']           = 1024;
				$config['encrypt_name'] 		= TRUE;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('attachment')) {
					$upload_data = $this->upload->data();
					$data['attachment'] = $upload_data['file_name'];
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
				$status = $this->support_model->submit_message($data);
				if($status) {
					$finalResult = array('msg' => 'success', 'response'=>"Successfully submitted.");
					echo json_encode($finalResult);
					exit;
				} else {
					$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
					echo json_encode($finalResult);
					exit;
				}
			}
		} else {
			show_admin404();
		}
	}

	public function mark_resolved()
	{
		if($_POST){
			$report_id = $_POST['report_id'];
			$status = $this->support_model->mark_resolved($report_id);
			if($status > 0){

				$this->db->set('status', 5);
				$this->db->set('updated_by', $this->session->userdata('admin_id'));
				$this->db->set('updated_date',date('Y-m-d H:i:s'));
				$this->db->where('order_number', $_POST['order_number']);
				$query = $this->db->update('orders');

				$finalResult = array('msg' => 'success', 'response'=>"Successfully resolved.");
				echo json_encode($finalResult);
				exit;
			} else {
				$finalResult = array('msg' => 'error', 'response'=>"Something went wrong please try again.");
				echo json_encode($finalResult);
				exit;
			}
		} else {
			show_admin404();
		}
	}

}