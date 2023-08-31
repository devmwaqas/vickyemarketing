<?php

class Users_model extends CI_Model
{

    public function get_users()
    {
        $this->db->select('users.*, CONCAT(user.first_name, " ", user.last_name) as create_by');
        $this->db->from('users');
        $this->db->join('users as user', 'users.created_by = user.created_by', 'left');
        $this->db->where('users.status !=', 2);
        $this->db->where('users.user_type !=', 0);
        $this->db->group_by('users.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_detail($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_user($user_id) {
        $this->db->set('status', 2);
        $this->db->set('deleted_at', date('Y-m-d H:i:s'));
        $this->db->where('id', $user_id);
        $query = $this->db->update('users');
        return $this->db->affected_rows();
    }

    public function check_email_exist($data)
    {
        $this->db->select('*');
        $this->db->where('email',$data['email']);
        $this->db->where('status !=',2);
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    public function create_user($data)
    {
        $hash_pass = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->db->set('first_name', $data['first_name']);
        $this->db->set('last_name', $data['last_name']);
        $this->db->set('email', $data['email']);
        $this->db->set('password',$hash_pass);
        $this->db->set('mobile', $data['mobile']);
        $this->db->set('bank_name', $data['bank_name']);
        $this->db->set('account_title', $data['account_title']);
        $this->db->set('account_number', $data['account_number']);
        $this->db->set('cnic_number', $data['cnic_number']);
        if(!empty($data['cnic_front_side'])) {
            $this->db->set('cnic_front_side', $data['cnic_front_side']);
        }

        if(!empty($data['cnic_back_side'])) {
            $this->db->set('cnic_back_side', $data['cnic_back_side']);
        }

        $this->db->set('user_type', $data['user_type']);
        $this->db->set('created_by', $this->session->userdata('admin_id'));
        $this->db->set('created_at', date('Y-m-d H:i:s'));
        $query = $this->db->insert('users');
        if($this->db->insert_id() > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function check_update_email_exist($data)
    {
        $this->db->select('*');
        $this->db->where('email',$data['email']);
        $this->db->where('id !=',$data['user_id']);
        $this->db->where('status !=',2);
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    public function update_user($data)
    {
        if(!empty($data['password'])) {
            $hash_pass = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        $this->db->set('first_name', $data['first_name']);
        $this->db->set('last_name', $data['last_name']);
        $this->db->set('email', $data['email']);
        if(!empty($data['password'])) {
            $this->db->set('password',$hash_pass);
        }
        $this->db->set('mobile', $data['mobile']);

        $this->db->set('bank_name', $data['bank_name']);
        $this->db->set('account_title', $data['account_title']);
        $this->db->set('account_number', $data['account_number']);
        $this->db->set('cnic_number', $data['cnic_number']);

        if(!empty($data['cnic_front_side'])) {
            $this->db->set('cnic_front_side', $data['cnic_front_side']);
        }

        if(!empty($data['cnic_back_side'])) {
            $this->db->set('cnic_back_side', $data['cnic_back_side']);
        }

        $this->db->set('user_type', $data['user_type']);
        $this->db->set('updated_at', date('Y-m-d H:i:s'));
        $this->db->where('id', $data['user_id']);
        $query = $this->db->update('users');
        return $this->db->affected_rows();
    }
}