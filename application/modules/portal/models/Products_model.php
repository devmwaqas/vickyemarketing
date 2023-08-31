<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_products()
	{
		$this->db->select("products.*");
		$this->db->select("markets.name as market_name");
		$this->db->select("product_types.name as product_type");
		$this->db->from("products");
		$this->db->join('markets', 'markets.id = products.market_id', 'left');
		$this->db->join('product_types', 'product_types.id = products.product_type_id', 'left');
		if($this->session->userdata('admin_type') == 2)
		{
			$this->db->where('products.status', 1);
		} elseif(!empty($_GET['status'])) {
			if($_GET['status'] == 1) {
				$this->db->where('products.status', 1);
			} else {
				$this->db->where('products.status', 0);
			}
		}
		if(!empty($_GET['target'])) {
			$this->db->where('products.category_id', $_GET['target']);
		}
		if($this->session->userdata('admin_type') == 1) {
			$this->db->where('created_by', $this->session->userdata('admin_id'))	;
		}
		$this->db->order_by('products.id', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_search_products($data) {

		$this->db->select("products.*");
		$this->db->select("markets.name as market_name");
		$this->db->from("products");
		$this->db->join('markets', 'markets.id = products.market_id', 'left');

		if($this->session->userdata('admin_type') == 2)
		{
			$this->db->where('products.status', 1);
		} elseif(!empty($_GET['status'])) {
			if($_GET['status'] == 1) {
				$this->db->where('products.status', 1);
			} else {
				$this->db->where('products.status', 0);
			}
		}

		if(!empty($_GET['target'])) {
			$this->db->where('products.category_id', $_GET['target']);
		}

		if(!empty($data['product_code'])) {
			$this->db->where('products.id', $data['product_code']);
		}

		if(!empty($data['market'])) {
			$this->db->where('products.market_id', $data['market']);
		}

		if(!empty($data['product_type'])) {
			$this->db->where('products.product_type_id', $data['product_type']);
		}

		if(!empty($data['keyword'])) {
			$this->db->like('products.keyword', trim($data['keyword']));
		}

		if(!empty($data['pmm'])) {
			$this->db->where('products.created_by', $data['pmm']);
		}

		if($this->session->userdata('admin_type') == 1) {
			$this->db->where('created_by', $this->session->userdata('admin_id'));
		}


		$this->db->order_by('products.id', 'DESC');
		$query = $this->db->get();
		return $query->result_array();

	}

	public function get_product_details($product_id)
	{
		$this->db->select("products.*");
		$this->db->select("users.first_name as created_first_name");
		$this->db->select("users.last_name as created_last_name");
		$this->db->select("categories.cat_name");
		$this->db->select("product_types.name as product_type");
		$this->db->select("markets.name as market_name");
		$this->db->from("products");
		$this->db->join('categories', 'categories.id = products.category_id', 'left');
		$this->db->join('product_types', 'product_types.id = products.product_type_id', 'left');
		$this->db->join('markets', 'markets.id = products.market_id', 'left');
		$this->db->join('users', 'users.id = products.created_by', 'left');
		$this->db->where('products.id',$product_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function insert_product_detail($data)
	{
		$this->db->set('keyword',$data["keyword"]);
		$this->db->set('category_id',$data["category_id"]);
		$this->db->set('brand_name',$data["brand_name"]);
		$this->db->set('amz_seller',$data["amz_seller"]);
		$this->db->set('referral_link',$data["referral_link"]);
		$this->db->set('chinese_seller',$data["chinese_seller"]);
		$this->db->set('market_id',$data["market_id"]);
		$this->db->set('product_type_id',$data["product_type"]);
		$this->db->set('instruction',$data["instruction"]);
		$this->db->set('refund_conditions',$data["refund_conditions"]);

		$this->db->set('pmm_commission',$data["pmm_commission"]);
		$this->db->set('portal_commission',$data["portal_commission"]);
		$this->db->set('commission_conditions',$data["commission_conditions"]);

		$this->db->set('sale_limit',$data["sale_limit"]);
		$this->db->set('overall_sale_limit',$data["overall_sale_limit"]);
		if(!empty($data["fee_cover"])) {
			$this->db->set('fee_cover',1);
		} else {
			$this->db->set('fee_cover',0);
		}
		if(!empty($data["tax_cover"])) {
			$this->db->set('tax_cover',1);
		} else {
			$this->db->set('tax_cover',0);
		}
		if(!empty($data["picture"])) {
			$this->db->set('picture',$data["picture"]);
		}
		if(!empty($data["amz_picture"])) {
			$this->db->set('amz_picture',$data["amz_picture"]);
		}
		$this->db->set('status', 1);
		$this->db->set('created_by', $this->session->userdata('admin_id'));
		$this->db->set('created_date',date('Y-m-d H:i:s'));
		$query = $this->db->insert('products');
		$product_id = $this->db->insert_id();
		if($product_id > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function update_product_detail($data)
	{
		$this->db->set('keyword',$data["keyword"]);
		$this->db->set('category_id',$data["category_id"]);
		$this->db->set('brand_name',$data["brand_name"]);
		$this->db->set('amz_seller',$data["amz_seller"]);
		$this->db->set('chinese_seller',$data["chinese_seller"]);
		$this->db->set('product_type_id',$data["product_type"]);
		$this->db->set('market_id',$data["market_id"]);
		$this->db->set('instruction',$data["instruction"]);
		$this->db->set('refund_conditions',$data["refund_conditions"]);

		$this->db->set('pmm_commission',$data["pmm_commission"]);
		$this->db->set('portal_commission',$data["portal_commission"]);
		$this->db->set('commission_conditions',$data["commission_conditions"]);

		$this->db->set('sale_limit',$data["sale_limit"]);
		$this->db->set('overall_sale_limit',$data["overall_sale_limit"]);
		$this->db->set('referral_link',$data["referral_link"]);
		if(!empty($data["fee_cover"])) {
			$this->db->set('fee_cover',1);
		} else {
			$this->db->set('fee_cover',0);
		}
		if(!empty($data["tax_cover"])) {
			$this->db->set('tax_cover',1);
		} else {
			$this->db->set('tax_cover',0);
		}
		if(!empty($data["picture"])) {
			$this->db->set('picture',$data["picture"]);
		}
		if(!empty($data["amz_picture"])) {
			$this->db->set('amz_picture',$data["amz_picture"]);
		}
		$this->db->set('updated_by', $this->session->userdata('admin_id'));
		$this->db->set('updated_date',date('Y-m-d H:i:s'));
		$this->db->where('id', $data['product_id']);
		$query = $this->db->update('products');
		$insertdId = $this->db->affected_rows();
		return true;
	}

	public function change_status($product_id, $status)
	{
		$this->db->set('status', $status);
		$this->db->set('updated_by', $this->session->userdata('admin_id'));
		$this->db->set('updated_date',date('Y-m-d H:i:s'));
		$this->db->where('id', $product_id);
		$query = $this->db->update('products');
		return $this->db->affected_rows();
	}

	public function delete_product($product_id)
	{
		$this->db->where('id', $product_id);
		$query = $this->db->delete('products');
		return $this->db->affected_rows();
	}
}