<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('admin_url'))
{
	function admin_url()
	{
		$CI = get_instance();
		return $CI->config->item('admin_url');
	}
}

if (!function_exists('admin_controller'))
{
	function admin_controller()
	{
		$CI = get_instance();
		return $CI->config->item('admin_controller');
	}
}

if (!function_exists('get_admins')) {
	function get_admins() {
		$CI = & get_instance();
		$CI->db->select('id, first_name, last_name');
		$CI->db->from('users');
		$CI->db->where('user_type', 1);
		$query = $CI->db->get();
		return $query->result_array();
	}
}

if (!function_exists('get_categories')) {
	function get_categories() {
		$CI = & get_instance();
		$CI->db->select('*');
		$CI->db->from('categories');
		$CI->db->where('status', 1);
		$CI->db->where('parent_id', 0);
		$CI->db->order_by('cat_name', 'ASC');
		$query = $CI->db->get();
		return $query->result_array();
	}
}

if (!function_exists('get_single_value')) {
	function get_single_value($table, $column, $value) {
		$CI = & get_instance();
		$CI->db->select($value);
		$CI->db->from($table);
		$CI->db->where('id', $column);
		$query = $CI->db->get()->row_array();
		return $query[$value];
	}
}

if (!function_exists('get_subcategories')) {
	function get_subcategories($id) {
		$CI = & get_instance();
		$CI->db->select('*');
		$CI->db->from('categories');
		$CI->db->where('parent_id', $id);
		$CI->db->where('status', 1);
		return $CI->db->get()->result_array();
	}
}

if (!function_exists('get_markets')) {
	function get_markets() {
		$CI = & get_instance();
		$CI->db->select('*');
		$CI->db->from('markets');
		$CI->db->where('status', 1);
		$query = $CI->db->get();
		return $query->result_array();
	}
}

if (!function_exists('get_producttypes')) {
	function get_producttypes() {
		$CI = & get_instance();
		$CI->db->select('*');
		$CI->db->from('product_types');
		$CI->db->where('status', 1);
		$query = $CI->db->get();
		return $query->result_array();
	}
}

if (!function_exists('today_remaining')) {
	function today_remaining($product_id) {

		$current_date = date('Y-m-d');

		$CI = & get_instance();
		$CI->db->select('sale_limit');
		$CI->db->from('products');
		$CI->db->where('id', $product_id);
		$query = $CI->db->get();
		$product = $query->row_array();
		$sale_limit = $product['sale_limit'];

		$CI->db->select('*');
		$CI->db->from('orders');
		$CI->db->where('product_id', $product_id);
		$CI->db->where('order_date', $current_date);
		$query = $CI->db->get();
		$ordered = $query->num_rows();

		if($ordered == 0) {
			$CI->db->select('*');
			$CI->db->from('reservations');
			$CI->db->where('product_id', $product_id);
			$CI->db->where('reserve_date', $current_date);
			$query = $CI->db->get();
			$reserved = $query->num_rows();
			$remaining = $sale_limit - $reserved;
			return $remaining;
		} else {
			$CI->db->select('*');
			$CI->db->from('reservations');
			$CI->db->where('product_id', $product_id);
			$CI->db->where('reserve_date', $current_date);
			$query = $CI->db->get();
			$reserved = $query->num_rows();
			$ordered = $ordered + $reserved;
			$remaining = $sale_limit - $ordered;
			return $remaining;
		}
	}
}

if (!function_exists('total_sold')) {
	function total_sold($product_id) {

		$CI = & get_instance();
		$CI->db->select('overall_sale_limit');
		$CI->db->from('products');
		$CI->db->where('id', $product_id);
		$query = $CI->db->get();
		$product = $query->row_array();
		$overall_sale_limit = $product['overall_sale_limit'];

		$CI->db->select('*');
		$CI->db->from('orders');
		$CI->db->where('product_id', $product_id);
		$query = $CI->db->get();
		$ordered = $query->num_rows();

		$remaining = $overall_sale_limit - $ordered;

		return $remaining;

	}
}

if (!function_exists('get_issue_types')) {
	function get_issue_types() {
		$CI = & get_instance();
		$CI->db->select('*');
		$CI->db->from('issue_types');
		$CI->db->where('status', 0);
		$query = $CI->db->get();
		return $query->result_array();
	}
}

if (!function_exists('get_totals')) {
	function get_totals($status = '') {

		$CI = & get_instance();
		$CI->db->select('orders.*');
		$CI->db->from('orders');
		$CI->db->join('products', 'products.id = orders.product_id', 'left');
		if($status != '') {
			$CI->db->where('orders.status', $status);
		}
		if($CI->session->userdata('admin_type') == 2) {
			$CI->db->where('orders.user_id', $CI->session->userdata('admin_id'));
		}

		if($CI->session->userdata('admin_type') == 1)
		{
			$CI->db->where('products.created_by', $CI->session->userdata('admin_id'));
		}

		$query = $CI->db->get();
		return $query->num_rows();
	}
}

if (!function_exists('has_reservation')) {
	function has_reservation($id) {
		$CI = & get_instance();
		$CI->db->select('*');
		$CI->db->from('reservations');
		$CI->db->where('user_id', $CI->session->userdata('admin_id'));
		$CI->db->where('product_id', $id);
		$query = $CI->db->get();
		return $query->row_array();
	}
}


if (!function_exists('past_month_orders')) {
	function past_month_orders() {

		$CI = & get_instance();
		$orders = array();
		$begin = new DateTime(date("Y-m-d", strtotime("first day of previous month")));
		$end = new DateTime(date("Y-m-d", strtotime("last day of previous month")));

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
		foreach ($period as $dt) {
			$date = $dt->format("Y-m-d");
			$CI->db->select('orders.*');
			$CI->db->from('orders');
			$CI->db->join('products', 'products.id = orders.product_id', 'left');
			if($CI->session->userdata('admin_type') == 2) {
				$CI->db->where('orders.user_id', $CI->session->userdata('admin_id'));
			}

			if($CI->session->userdata('admin_type') == 1)
			{
				$CI->db->where('products.created_by', $CI->session->userdata('admin_id'));
			}
			$CI->db->where('orders.order_date', $date);
			$CI->db->where('orders.status', 5);
			$query = $CI->db->get();
			$numrows = $query->num_rows();

			if($numrows == 0) {
				$numrows = 0;
			}

			$orders[] = $numrows;
		}

		return $orders;

	}
}

if (!function_exists('current_month_orders')) {
	function current_month_orders() {

		$CI = & get_instance();
		$orders = array();
		$begin = new DateTime(date("Y-m-d", strtotime("first day of this month")));
		$end = new DateTime(date("Y-m-d", strtotime("last day of this month")));
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
		foreach ($period as $dt) {

			$date = $dt->format("Y-m-d");
			$CI->db->select('orders.*');
			$CI->db->from('orders');
			$CI->db->join('products', 'products.id = orders.product_id', 'left');
			if($CI->session->userdata('admin_type') == 2) {
				$CI->db->where('orders.user_id', $CI->session->userdata('admin_id'));
			}

			if($CI->session->userdata('admin_type') == 1)
			{
				$CI->db->where('products.created_by', $CI->session->userdata('admin_id'));
			}
			$CI->db->where('orders.order_date', $date);
			$CI->db->where('orders.status', 5);
			$query = $CI->db->get();
			$numrows = $query->num_rows();

			if($numrows == 0) {
				$numrows = 0;
			}

			$orders[] = $numrows;
		}

		return $orders;

	}
}


if (!function_exists('change_to_inactive')) {
	function change_to_inactive($product_id) {

		$CI = & get_instance();
		$CI->db->set('status', 0);
		$CI->db->where('id', $product_id);
		$query = $CI->db->update('products');
		return $CI->db->affected_rows();

	}
}