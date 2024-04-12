<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Auction_model extends CI_Model {
		//TABLE NAME
		
		public function __Construct() {
			parent::__construct();
			$this->load->database();
		}
		
		//INSERT AUCTION RECEIPT
		function add_auction_receipt_modal($table, $data_array=array()) {
			$this->db->insert($table,$data_array);
			return $this->db->insert_id();
		}
		
		//GET COUNT BID ITEM
		function count_rows_bid_item($table, $condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($table);
			if($condition){
				$this->db->where($condition);
			}
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//GET COUNT BID ITEM
		function count_rows_bid_item_like($table, $condition_like=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($table);
			if($condition_like != "")
				$this->db->like($condition_like, false, 'both');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//GET BID ITEM LIST
		function get_bid_item_list_like($table, $condition_like = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($table);
			if($condition_like != "")
				$this->db->like($condition_like, false, 'both');
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//GET BID ITEM LIST
		function get_bid_item_list($table, $condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//GET AUCTION RECEIPT
		function get_auction_receipt($table, $condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//GET DEFAULT BID
		function get_default_bid($table, $condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//GET BID RANGES
		function get_bid_ranges($table, $condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//GET ALL ITEM DETAILS
		function get_item_details($table, $condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//GET ALL AUCTION ITEMS
		function get_auction_model($table, $condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//INSERT AUCTION
		function add_auction_modal($table, $data_array=array()) {
			$this->db->insert($table,$data_array);
			return $this->db->insert_id();
		}
		
		//UPDATE AUCTION
		function update_auction_model($table, $condition=array(),$data_array=array()){
			if($condition){
				$this->db->where($condition);
			}
			
			if($this->db->update($table,$data_array)){
				return true;
			} else {
				return false;
			}
		}
		
		//FOR AUCTION REPORT COUNT
		function count_rows_auction_report($table, $condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($table);
			if($condition){
				$this->db->where($condition);
			}
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
	}
?>