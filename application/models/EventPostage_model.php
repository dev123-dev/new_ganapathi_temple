<?php
	class EventPostage_model extends CI_Model {
		//TABLE NAME
		var $table_Postage = 'POSTAGE';
		var $table_Event_Receipt ='EVENT_RECEIPT';
		public function __Construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		function get_sum_undispatched_counter($condition=array(), $group_by_field = '', $order_by_type = "asc") {
			$this->db->distinct();
			$this->db->select('COUNT(POSTAGE_ID) AS CNT');		
			$this->db->from($this->table_Postage);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($group_by_field) {
				$this->db->group_by($group_by_field, $order_by_type);
			}
			$this->db->join('EVENT_RECEIPT', 'POSTAGE.RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID'); 
			$this->db->join('EVENT','EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		function get_distinct_data_counter($condition=array(), $group_by_field = '', $order_by_type = "asc") {
			$this->db->distinct();
			$this->db->select('LABEL_COUNTER');		
			$this->db->select('COUNT(POSTAGE.RECEIPT_ID) AS TOTAL');			
			$this->db->from($this->table_Postage);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($group_by_field) {
				$this->db->group_by($group_by_field, $order_by_type);
			}
			$this->db->join('EVENT_RECEIPT', 'POSTAGE.RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID'); 
			$this->db->join('EVENT','EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		//FOR COUNT
		function count_rows_dispatch_collection($condition=array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_Postage);
			if($condition){
				$this->db->where($condition);
			}
			$this->db->join('EVENT_RECEIPT', 'POSTAGE.RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID'); 
			$this->db->join('EVENT','EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');

			$query = $this->db->get();
			$row = $query->num_rows();
			return $row;
		}

		//FOR GETTING ALL DATA
		function get_all_fields_data($condition = array(),$or_condition=array(), $order_by_field = '', $order_by_type = "DESC", $num = 10, $start = 0) {
			$this->db->from($this->table_Postage);
			if ($condition) {
				$this->db->where($condition);
			}

			if ($or_condition) {
				$this->db->or_where($or_condition);
			}

			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('EVENT_RECEIPT', 'POSTAGE.RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID'); 
			$this->db->join('EVENT','EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');

			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		//FOR GETTING ALL DATA FOR EXCEL
		function get_all_fields_data_excel($condition = array(),$or_condition=array(), $order_by_field = '', $order_by_type = "DESC") {
			$this->db->from($this->table_Postage);
			if ($condition) {
				$this->db->where($condition);
			}

			if ($or_condition) {
				$this->db->or_where($or_condition);
			}

			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('EVENT_RECEIPT', 'POSTAGE.RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID'); 
			$this->db->join('EVENT','EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//UPDATE DATA
		function update_model($condition=array(),$data_array=array()){
			if($condition){
				$this->db->where($condition);
			}
			
			if($this->db->update($this->table_Postage,$data_array)){
				return true;
			} else {
				return false;
			}
		}
		
		//INSERT DATA
		function add_modal($data_array=array()) {
			$this->db->insert($this->table_Postage,$data_array);
			return $this->db->insert_id();
		}

		function get_slvt_postage_data($condition = array(),$order_by_field = '', $order_by_type = "DESC", $num = 10, $start = 0,$limit = false) {
			$query = "SELECT ET_RECEIPT_ID,ET_RECEIPT_NO,ET_RECEIPT_DATE,ET_RECEIPT_NAME,ET_RECEIPT_PHONE,REPLACE(REPLACE(ET_RECEIPT_ADDRESS,',,',','),', ,',',') AS ET_RECEIPT_ADDRESS, ET_RECEIPT_PAYMENT_METHOD FROM EVENT_RECEIPT WHERE ".$condition."  ORDER BY ".$order_by_field." ".$order_by_type;
			if($limit == true){
				$query .= " limit ".$start.",".$num;
			}
			$result = $this->db->query($query);
			if ($result->num_rows() > 0) {
				return $result->result();
			} else {
				return array();
			}
		}
		//FOR COUNT
		function slvt_postage_rows_collection($condition = array()) {
			$this->db->from($this->table_Event_Receipt);
			if ($condition) {
				$this->db->where($condition);
			}

			$query = $this->db->get();
			$row = $query->num_rows();
			return $row;
		}

	}