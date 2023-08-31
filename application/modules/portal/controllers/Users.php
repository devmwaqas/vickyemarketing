<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('admin_logged_in'))
        {
            redirect(admin_url().'login');
        }

        if($this->session->userdata('admin_type') != 0)
        {
            redirect(admin_url().'dashboard');
        }

        $this->load->model('users_model');
    }

    public function index()
    {
        $data['users'] = $this->users_model->get_users();
        $this->load->view('users', $data);
    }

    public function add() {
        $this->load->view('add_user');
    }

    public function submit_user()
    {
        $data = $_POST;
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|callback_check_email_exist');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|xss_clean');
        if ($data['password'] != $data['c_password']) {
            $finalResult = array('msg' => 'error', 'response'=>'<p>Password and Confirm password must be same.</p>');
            echo json_encode($finalResult);
            exit;
        }
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_type', 'Role', 'trim|required|xss_clean');

        $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('account_title', 'Account Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cnic_number', 'CNIC Number', 'trim|required|xss_clean');

        $data['cnic_front_side'] = '';
        if (!empty($_FILES['cnic_front_side']['name']))
        {
            $config['upload_path']          = FCPATH.'assets/pictures/cards/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            // $config['max_size']             = 20000;
            // $config['max_width']            = 2024;
            // $config['max_height']           = 2024;
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
        } else {
            $finalResult = array('msg' => 'error', 'response'=>'<p>CNIC Front Side field is required.</p>');
            echo json_encode($finalResult);
            exit;
        }

        $data['cnic_back_side'] = '';
        if (!empty($_FILES['cnic_back_side']['name']))
        {
            $config['upload_path']          = FCPATH.'assets/pictures/cards/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            // $config['max_size']             = 20000;
            // $config['max_width']            = 2024;
            // $config['max_height']           = 2024;
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
        } else {
            $finalResult = array('msg' => 'error', 'response'=>'<p>CNIC Back Side field is required.</p>');
            echo json_encode($finalResult);
            exit;
        }


        if ($this->form_validation->run($this) == FALSE)
        {
            $finalResult = array('msg' => 'error', 'response'=>validation_errors());
            echo json_encode($finalResult);
            exit;
        } else {
            $status = $this->users_model->create_user($data);
            if($status){
                $finalResult = array('msg' => 'success', 'response'=>'<p>Successfully created.</p>');
                echo json_encode($finalResult);
                exit;
            }else{
                $finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
                echo json_encode($finalResult);
                exit;
            }
        }
    }

    public function check_email_exist($str)
    {
        $data = $_POST;
        $user_email = $this->users_model->check_email_exist($data);
        if ($user_email > 0) {
            $this->form_validation->set_message('check_email_exist', 'Email already associated with another account.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function edit($id)
    {
        $data['user_detail'] = $this->users_model->get_user_detail($id);
        if(empty($data['user_detail'])) {
            show_admin404();
        }
        $this->load->view('edit_user', $data);
    }

    public function update_user()
    {
        $data = $_POST;
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|callback_check_update_email_exist');
        if(!empty($data['password'])) {
            $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|xss_clean');
            if ($data['password'] != $data['c_password']) {
                $finalResult = array('msg' => 'error', 'response'=>'<p>Password and Confirm password must be same.</p>');
                echo json_encode($finalResult);
                exit;
            }
        }

        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_type', 'Role', 'trim|required|xss_clean');

        $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('account_title', 'Account Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cnic_number', 'CNIC Number', 'trim|required|xss_clean');

        $data['cnic_front_side'] = '';
        if (!empty($_FILES['cnic_front_side']['name']))
        {
            $config['upload_path']          = FCPATH.'assets/pictures/cards/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            // $config['max_size']             = 20000;
            // $config['max_width']            = 2024;
            // $config['max_height']           = 2024;
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
            // $config['max_size']             = 20000;
            // $config['max_width']            = 2024;
            // $config['max_height']           = 2024;
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
            if(empty($data['user_id'])) {
                $finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
                echo json_encode($finalResult);
                exit;
            }
            $status = $this->users_model->update_user($data);
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

    public function check_update_email_exist($str)
    {
        $data = $_POST;
        $user_email = $this->users_model->check_update_email_exist($data);
        if ($user_email > 0) {
            $this->form_validation->set_message('check_update_email_exist', 'Email already associated with another account.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_record() {
        if($_POST){
            $user_id = $_POST['record_id'];
            $status = $this->users_model->delete_user($user_id);
            if($status > 0){
                $finalResult = array('msg' => 'success', 'response'=>"User successfully deleted.");
                echo json_encode($finalResult);
                exit;
            } else {
                $finalResult = array('msg' => 'error', 'response'=>"Something went wrong please try again.");
                echo json_encode($finalResult);
                exit;
            }
        }else{
            show_admin404();
        }
    }
}