<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reservations extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login');
		}

		$this->load->model(admin_controller().'reservations_model');
	}

	public function index()
	{
		if(!empty($_GET['target'])) {
			$product_id = $_GET['target'];
		} else {
			$product_id = '';
		}

		$reservations = $this->reservations_model->get_reservations($product_id);
		if(!empty($reservations)) {

			$new_array = array();

			foreach ($reservations as $record) {

				$current_datetime = date('Y-m-d H:i:s');

				$now = date('Y-m-d H:i:s', strtotime($record['created_at']));
				$new_time = date("Y-m-d H:i:s", strtotime('+1 hours', strtotime($now)));
				$date1 = new DateTime($new_time);
				$date2 = new DateTime($current_datetime);

				if ($date1 > $date2) {
					$new_array[] = $record;
				} else {
					$this->db->where('id', $record['id']);
					$query = $this->db->delete('reservations');
				}
			}
			$data['reservations'] = $new_array;
		} else {
			$data['reservations'] = array();
		}

		$this->load->view('reservations/reservations_list' , $data);
	}

	public function add()
	{
		$this->load->view('reservations/add_reservations');
	}

	public function reserve_now()
	{
		if($this->session->userdata('admin_type') != 2) {
			$finalResult = array('msg' => 'error', 'response'=>"Something went wrong.");
			echo json_encode($finalResult);
			exit;
		}

		$data = $_POST;

		if (!empty($data['product_id'])) {

			$product_detail = $this->reservations_model->get_product_details($data['product_id']);
			if(empty($product_detail)) {
				$finalResult = array('msg' => 'error', 'response'=>"Product is not available.");
				echo json_encode($finalResult);
				exit;
			}

			if($product_detail['overall_sale_limit'] == 0) {
				$finalResult = array('msg' => 'error', 'response'=>"Product is not available.");
				echo json_encode($finalResult);
				exit;
			}

			if(today_remaining($data['product_id']) <= $product_detail['sale_limit']) {

				$reserve_id = $this->reservations_model->reserve_now($data['product_id']);
				if($reserve_id > 0) {

					$todayremaining = today_remaining($data['product_id']);
					$totalsold =  total_sold($data['product_id']);

					$finalResult = array('msg' => 'success', 'response'=>"Successfully reserved.", 'todayremaining' => $todayremaining, 'totalsold' => $totalsold, 'reserve_id' => $reserve_id);
					echo json_encode($finalResult);
					exit;

				} else {
					$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
					echo json_encode($finalResult);
					exit;
				}

			} else {
				$finalResult = array('msg' => 'error', 'response'=>"Product is not available for today.");
				echo json_encode($finalResult);
				exit;
			}

		} else {
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}

	}

	public function create_order($id)
	{
		$data['reservation_details'] = $this->reservations_model->get_details($id);
		if (empty($data['reservation_details'])) {
			show_admin404();
		}
		$this->load->view('reservations/create_order', $data);
	}

	public function submit_order()
	{
		if($_POST) {

			$data = $_POST;

			$this->form_validation->set_rules('order_number','Order Number','trim|required|xss_clean');
			$this->form_validation->set_rules('cust_email_id','Customer Email','trim|required|xss_clean|callback_check_email_exist');
			$this->form_validation->set_rules('amz_review_link','AMZ Review Link','trim|xss_clean');
			$this->form_validation->set_rules('user_id','User ID','trim|xss_clean');

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
			} else {
				$finalResult = array('msg' => 'error', 'response'=>"Order Picture is required.");
				echo json_encode($finalResult);
				exit;
			}

			$data['refund_pic'] = '';
			if (!empty($_FILES['refund_pic']['name']))
			{
				$config['upload_path']          = FCPATH.'assets/pictures/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				// $config['max_size']             = 2000;
				// $config['max_width']            = 1024;
				// $config['max_height']           = 1024;
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
				$status = $this->reservations_model->submit_order($data);
				if($status) {
					$finalResult = array('msg' => 'success', 'response'=>"Order successfully created.");
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

	public function check_email_exist($str)
	{
		$data = $_POST;
		$user_email = $this->reservations_model->check_email_exist($data);
		if ($user_email > 0) {
			$this->form_validation->set_message('check_email_exist', 'Email already used for same product.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function change_status()
	{
		if($_POST){
			$product_id = $_POST['product_id'];
			$status = $_POST['status'];
			$status = $this->reservations_model->change_status($product_id, $status);
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

	public function del_reservation()
	{
		if($_POST){
			$id = $_POST['id'];
			$status = $this->reservations_model->del_reservation($id);
			if($status > 0){
				$finalResult = array('msg' => 'success', 'response'=>"Reservation deleted.");
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