<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login');
		}
		$this->load->model(admin_controller().'products_model');
		$this->load->model(admin_controller().'cron_model');
	}

	public function index()
	{
		$this->cron_model->dlt_timeout_reservations();
		$data['products'] = $this->products_model->get_products();
		$this->load->view('products/products_list' , $data);
	}

	public function search()
	{
		$data = $_GET;
		$this->cron_model->dlt_timeout_reservations();
		$data['products'] = $this->products_model->get_search_products($data);
		$this->load->view('products/products_list' , $data);
	}

	public function detail($id)
	{
		$data['product_detail'] = $this->products_model->get_product_details($id);
		if (empty($data['product_detail'])) {
			redirect(admin_url().'products');
		}
		$this->load->view('products/product_detail', $data);
	}

	public function add()
	{
		if($this->session->userdata('admin_type') == 2)
		{
			redirect(admin_url().'dashboard');
		}

		$this->load->view('products/add_products');
	}

	public function add_new_product()
	{
		if($_POST) {

			$data = $_POST;

			$this->form_validation->set_rules('keyword','Keyword','trim|required|xss_clean');
			$this->form_validation->set_rules('brand_name','Brand Name','trim|required|xss_clean');
			$this->form_validation->set_rules('amz_seller','AMZ Seller','trim|xss_clean');
			$this->form_validation->set_rules('referral_link','Referral Link','trim|xss_clean');
			$this->form_validation->set_rules('chinese_seller','Chinese Seller','trim|xss_clean');
			$this->form_validation->set_rules('market_id','Market','trim|required|xss_clean');
			$this->form_validation->set_rules('category_id','Category','trim|required|xss_clean');
			$this->form_validation->set_rules('product_type','Product Type','trim|required|xss_clean');

			$this->form_validation->set_rules('fee_cover','Fee Cover','trim|xss_clean');
			$this->form_validation->set_rules('tax_cover','Tax Cover','trim|xss_clean');

			$this->form_validation->set_rules('instruction','Instruction','trim|required|xss_clean');
			$this->form_validation->set_rules('refund_conditions','Refund Conditions','trim|required|xss_clean');

			$this->form_validation->set_rules('pmm_commission','PM Commission','trim|required|xss_clean');
			$this->form_validation->set_rules('portal_commission','Portal Commission','trim|required|xss_clean');
			$this->form_validation->set_rules('commission_conditions','Commission Conditions','trim|required|xss_clean');


			$this->form_validation->set_rules('sale_limit','Sale Limit','trim|required|xss_clean');
			$this->form_validation->set_rules('overall_sale_limit','Overall Sale Limit','trim|required|xss_clean');

			$data['picture'] = '';
			if (!empty($_FILES['picture']['name']))
			{
				$config['upload_path']          = FCPATH.'assets/pictures/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				// $config['max_size']             = 20000;
				// $config['max_width']            = 2024;
				// $config['max_height']           = 2024;
				$config['encrypt_name'] 		= TRUE;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('picture')) {
					$upload_data = $this->upload->data();
					$data['picture'] = $upload_data['file_name'];
				} else {
					$finalResult = array('msg' => 'error', 'response'=> $this->upload->display_errors());
					echo json_encode($finalResult);
					exit;
				}
			}

			$data['amz_picture'] = '';
			if (!empty($_FILES['amz_picture']['name']))
			{
				$config['upload_path']          = FCPATH.'assets/pictures/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				// $config['max_size']             = 20000;
				// $config['max_width']            = 2024;
				// $config['max_height']           = 2024;
				$config['encrypt_name'] 		= TRUE;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('amz_picture')) {
					$upload_data = $this->upload->data();
					$data['amz_picture'] = $upload_data['file_name'];
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
				$status = $this->products_model->insert_product_detail($data);
				if($status) {
					$finalResult = array('msg' => 'success', 'response'=>"Successfully added.");
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

	public function edit($id)
	{
		if($this->session->userdata('admin_type') == 2)
		{
			redirect(admin_url().'dashboard');
		}

		$data['product_detail'] = $this->products_model->get_product_details($id);
		if (empty($data['product_detail'])) {
			show_admin404();
		}
		$this->load->view('products/edit_products', $data);
	}

	public function update_product()
	{
		if($_POST) {
			$data = $_POST;

			$data['picture'] = '';
			if (!empty($_FILES['picture']['name']))
			{
				$config['upload_path']          = FCPATH.'assets/pictures/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				// $config['max_size']             = 20000;
				// $config['max_width']            = 2024;
				// $config['max_height']           = 2024;
				$config['encrypt_name'] 		= TRUE;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('picture')) {
					$upload_data = $this->upload->data();
					$data['picture'] = $upload_data['file_name'];
				} else {
					$finalResult = array('msg' => 'error', 'response'=> $this->upload->display_errors());
					echo json_encode($finalResult);
					exit;
				}
			}

			$data['amz_picture'] = '';
			if (!empty($_FILES['amz_picture']['name']))
			{
				$config['upload_path']          = FCPATH.'assets/pictures/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				// $config['max_size']             = 20000;
				// $config['max_width']            = 2024;
				// $config['max_height']           = 2024;
				$config['encrypt_name'] 		= TRUE;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('amz_picture')) {
					$upload_data = $this->upload->data();
					$data['amz_picture'] = $upload_data['file_name'];
				} else {
					$finalResult = array('msg' => 'error', 'response'=> $this->upload->display_errors());
					echo json_encode($finalResult);
					exit;
				}
			}

			$this->form_validation->set_rules('keyword','Keyword','trim|required|xss_clean');
			$this->form_validation->set_rules('brand_name','Brand Name','trim|required|xss_clean');
			$this->form_validation->set_rules('amz_seller','AMZ Seller','trim|xss_clean');
			$this->form_validation->set_rules('chinese_seller','Chinese Seller','trim|xss_clean');
			$this->form_validation->set_rules('market_id','Market','trim|required|xss_clean');
			$this->form_validation->set_rules('category_id','Category','trim|required|xss_clean');
			$this->form_validation->set_rules('product_type','Product Type','trim|required|xss_clean');
			$this->form_validation->set_rules('instruction','Instruction','trim|required|xss_clean');
			$this->form_validation->set_rules('refund_conditions','Refund Conditions','trim|required|xss_clean');

			$this->form_validation->set_rules('pmm_commission','PM Commission','trim|required|xss_clean');
			$this->form_validation->set_rules('portal_commission','Portal Commission','trim|required|xss_clean');
			$this->form_validation->set_rules('commission_conditions','Commission Conditions','trim|required|xss_clean');

			$this->form_validation->set_rules('sale_limit','Sale Limit','trim|required|xss_clean');
			$this->form_validation->set_rules('overall_sale_limit','Overall Sale Limit','trim|required|xss_clean');


			if ($this->form_validation->run($this) == FALSE)
			{
				$finalResult = array('msg' => 'error', 'response'=>validation_errors());
				echo json_encode($finalResult);
				exit;
			} else {
				$status = $this->products_model->update_product_detail($data);
				if($status) {
					$finalResult = array('msg' => 'success', 'response'=>"Successfully updated.");
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

			$status = $this->products_model->change_status($product_id, $status);
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

	public function delete_product()
	{
		if($_POST){

			if($this->session->userdata('admin_type') != 0) {
				$finalResult = array('msg' => 'error', 'response'=>"Only super admin can delete product.");
				echo json_encode($finalResult);
				exit;
			}

			$product_id = $_POST['product_id'];
			$status = $this->products_model->delete_product($product_id);
			if($status > 0){
				$finalResult = array('msg' => 'success', 'response'=>"Product successfully deleted.");
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