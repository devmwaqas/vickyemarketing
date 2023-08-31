<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_jobs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('cron_model');
	}

	public function dlt_timeout_reservations()
	{
		$this->cron_model->dlt_timeout_reservations();
		echo "Done";
		exit;
	}
}
