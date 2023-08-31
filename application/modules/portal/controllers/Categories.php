<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('admin_logged_in')) {
			redirect(admin_url().'login');
		}

		if($this->session->userdata('admin_type') != 0)
        {
            redirect(admin_url().'dashboard');
        }

        $this->load->model(admin_controller().'category_model');
	}

	public function index()
	{
		$data['category'] = $this->category_model->get_category();
		$this->load->view('categories/category_list', $data);
	}

	public function add_category()
	{
		if($_POST) {
			$data = $_POST;
			$this->form_validation->set_rules('category_name','Title','trim|required|xss_clean');
			if ($this->form_validation->run($this) == FALSE){
				$finalResult = array('msg' => 'error', 'response'=>validation_errors());
				echo json_encode($finalResult);
				exit;
			} else {
				$status = $this->category_model->insert_category($data);
				if($status) {
					$finalResult = array('msg' => 'success', 'response'=>"Category successfully added.");
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

	public function edit()
	{
		$category_id = $_POST['id'];
		$data['category'] = $this->category_model->get_category_by_id($category_id);
		$htmlresult = $this->load->view('categories/edit_category_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$htmlresult);
		echo json_encode($finalResult);
		exit;
	}


	public function update_category()
	{
		if($_POST) {
			$data = $_POST;
			$this->form_validation->set_rules('category_name','Title','trim|required|xss_clean');
			if ($this->form_validation->run($this) == FALSE){
				$finalResult = array('msg' => 'error', 'response'=>validation_errors());
				echo json_encode($finalResult);
				exit;
			} else {
				$status = $this->category_model->update_category($data);
				if($status) {
					$finalResult = array('msg' => 'success', 'response'=>"Category successfully updated.");
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

	public function delete_category()
	{
		$category_id = $_POST['id'];
		$status = $this->category_model->delete_category($category_id);
		if($status > 0){
			$finalResult = array('msg' => 'success', 'response'=>"Category successfully deleted.");
			echo json_encode($finalResult);
			exit;
		}elseif ($status == "products_exist") {
			$finalResult = array('msg' => 'error', 'response'=>"This category has poroducts. please delete products first.");
			echo json_encode($finalResult);
			exit;
		}
		else {
			$finalResult = array('msg' => 'error', 'response'=>"Something went wrong please try again.");
			echo json_encode($finalResult);
			exit;
		}
	}

}