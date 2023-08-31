<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('home_model');
	}

	public function index()
	{

		$limit_per_page = 15;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		if($start_index != 0) {
			$start_index = ($start_index * $limit_per_page) - $limit_per_page;
		}

		$total_records = $this->home_model->get_product_total();

		if ($total_records > 0)
		{

			$config['base_url'] = base_url() . 'home/index';
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = 3;

			$config['num_links'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = TRUE;

			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';

			$config['first_link'] = 'First';
			$config['first_tag_open'] = '<li class="page-item">';
			$config['first_tag_close'] = '</li>';

			$config['last_link'] = 'Last';
			$config['last_tag_open'] = '<li class="page-item">';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = 'Next';
			$config['next_tag_open'] = '<li class="page-item">';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = 'Previous';
			$config['prev_tag_open'] = '<li class="page-item">';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active page-item"><a href="#" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';

			$this->pagination->initialize($config);

            // build paging links
			$data["links"] = $this->pagination->create_links();

			$data['products'] = $this->home_model->get_products($limit_per_page, $start_index);

		} else {
			$data['products'] = array();
		}

		$this->load->view('index', $data);

	}

	public function products()
	{
		$data = $this->input->get();
		if(empty($data)) {
			redirect(base_url() ,'refresh');
		}
		$data['products'] = $this->home_model->get_search_products($data);
		$this->load->view('index', $data);
	}

}