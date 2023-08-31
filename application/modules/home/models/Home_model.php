<?php

class Home_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get_product_total()
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_products($limit, $start)
	{
		$this->db->select("products.*");
		$this->db->select("markets.name as market_name");
		$this->db->from("products");
		$this->db->join('markets', 'markets.id = products.market_id', 'left');
		$this->db->where('products.status', 1);
		$this->db->order_by('products.id', 'desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_search_products($data)
	{
		$this->db->select("products.*");
		$this->db->select("markets.name as market_name");
		$this->db->from("products");
		$this->db->join('markets', 'markets.id = products.market_id', 'left');

		if($data['keyword']  != ''){
			$this->db->like('products.keyword', trim($data['keyword']));
		}

		if($data['productId']  != ''){
			$this->db->like('products.id', trim($data['productId']));
		}

		if($data['market']  != ''){
			$this->db->like('products.market_id', trim($data['market']));
		}

		if($data['productType']  != ''){
			$this->db->like('products.market_id', trim($data['market']));
		}
		$this->db->where('products.status', 1);
		$this->db->order_by('products.id', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}

}