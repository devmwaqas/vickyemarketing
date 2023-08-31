<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Orders extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(admin_controller().'orders_model');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login');
		}
	}

	public function index()
	{
		$data['orders'] = $this->orders_model->get_orders();
		$this->load->view('orders/orders_list' , $data);
	}

	public function search()
	{
		$data = $_GET;
		$data['orders'] = $this->orders_model->get_search_orders($data);
		$this->load->view('orders/orders_list' , $data);
	}

	public function detail($id)
	{
		$data['order_detail'] = $this->orders_model->get_order_details($id);
		if (empty($data['order_detail'])) {
			redirect(admin_url().'orders');
		}
		$this->load->view('orders/order_detail', $data);
	}

	public function edit($id)
	{
		$data['order_detail'] = $this->orders_model->get_order_details($id);
		if (empty($data['order_detail'])) {
			show_admin404();
		}
		$this->load->view('orders/edit_order', $data);
	}

	public function update_order()
	{
		if($_POST) {

			$data = $_POST;

			$this->form_validation->set_rules('order_number','Order Number','trim|required|xss_clean');
			$this->form_validation->set_rules('amz_review_link','AMZ Review Link','trim|xss_clean');
			$this->form_validation->set_rules('remarks','Remarks','trim|xss_clean');


			$data['order_pic'] = '';
			if (!empty($_FILES['order_pic']['name']))
			{
				$config['upload_path']          = FCPATH.'assets/pictures/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				// $config['max_size']             = 2000;
				// $config['max_width']            = 1024;
				// $config['max_height']           = 1024;
				$config['encrypt_name'] 		= TRUE;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('order_pic')) {
					$upload_data = $this->upload->data();
					$data['order_pic'] = $upload_data['file_name'];
				} else {
					$finalResult = array('msg' => 'error', 'response'=> $this->upload->display_errors());
					echo json_encode($finalResult);
					exit;
				}
			}

			$data['review_pic'] = '';
			if (!empty($_FILES['review_pic']['name']))
			{
				$config['upload_path']          = FCPATH.'assets/pictures/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				// $config['max_size']             = 20000;
				// $config['max_width']            = 2024;
				// $config['max_height']           = 2024;
				$config['encrypt_name'] 		= TRUE;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('review_pic')) {
					$upload_data = $this->upload->data();
					$data['review_pic'] = $upload_data['file_name'];
				} else {
					$finalResult = array('msg' => 'error', 'response'=> $this->upload->display_errors());
					echo json_encode($finalResult);
					exit;
				}
			}

			$data['refund_pic'] = '';
			if (!empty($_FILES['refund_pic']['name']))
			{
				$config['upload_path']          = FCPATH.'assets/pictures/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				// $config['max_size']             = 20000;
				// $config['max_width']            = 2024;
				// $config['max_height']           = 2024;
				$config['encrypt_name'] 		= TRUE;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('refund_pic')) {
					$upload_data = $this->upload->data();
					$data['refund_pic'] = $upload_data['file_name'];
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
				$status = $this->orders_model->update_order($data);
				if($status) {
					$finalResult = array('msg' => 'success', 'response'=>"Order successfully updated.");
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

	public function change_status()
	{
		if($_POST){
			$product_id = $_POST['product_id'];
			$status = $_POST['status'];
			$status = $this->orders_model->change_status($product_id, $status);
			if($status > 0){
				$finalResult = array('msg' => 'success', 'response'=>"Product status successfully changed.");
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

	public function submit_report()
	{
		if($_POST){
			$order_id = $_POST['order_id'];
			$issue_type = $_POST['issue_type'];
			$status = $this->orders_model->submit_report($order_id, $issue_type);
			if($status > 0){
				$finalResult = array('msg' => 'success', 'response'=>"Successfully reported.");
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