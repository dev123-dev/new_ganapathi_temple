<?php
	class TrustReceipt_modal extends CI_Model {
		//TABLE NAME
		var $table = 'TRUST_RECEIPT';
		var $table2 = 'TRUST_INKIND_ITEMS';
		//TABLE NAME
		var $table_Event_Receipt = 'TRUST_EVENT_RECEIPT';
		var $table_Event_Inkind_Offered = 'TRUST_EVENT_INKIND_OFFERED';
		var $table_Trust_Inkind_Offered = 'TRUST_INKIND_OFFERED';
		var $table_event = "TRUST_EVENT";
		// var $table_trust_financial_group_ledger_heads = "trust_financial_group_ledger_heads"
		
		public function __Construct() {
			parent::__construct();
			$this->load->database();
		}

		//FOR GETTING EVENTS
		function get_all_field_events_receipt($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_Event_Receipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->limit(1);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();
			} else {
				return array();
			}
		}

		//FOR GETTING EVENTS
		function get_all_field_trust_receipt($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->limit(1);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();
			} else {
				return array();
			}
		}

		//GET ALL INKIND ITEMS
		function get_all_field_inkind_items($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table2);
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
			//INSERT ITEMS FOR INKIND OFFERED FOR EVENT
			function add_receipt_inkind_offered_event_modal($data_array=array()) {
				$this->db->insert($this->table_Event_Inkind_Offered,$data_array);
				return $this->db->insert_id();
			}
			
			//INSERT ITEMS FOR INKIND OFFERED FOR TRUST 	TRUST_INKIND_CODE
			function add_receipt_inkind_offered_trust_modal($data_array=array()) {
				$this->db->insert($this->table_Trust_Inkind_Offered,$data_array);
				return $this->db->insert_id();
			}

			//INSERT ITEMS FOR INKIND OFFERED FOR DEITY
			function add_receipt_inkind_offered_deity_modal($data_array=array()) {
				$this->db->insert($this->table_Deity_Inkind_Offered,$data_array);
				return $this->db->insert_id();
			}
			
			//INSERT RECEIPT FOR INKIND FOR EVENT
			function add_receipt_inkind_event_modal($data_array=array()) {
				$this->db->insert($this->table_Event_Receipt,$data_array);
				return $this->db->insert_id();
			}

			//INSERT RECEIPT FOR INKIND FOR TRUST 			TRUST_INKIND_CODE
			function add_receipt_inkind_trust_modal($data_array=array()) {
				$this->db->insert($this->table,$data_array);
				return $this->db->insert_id();
			}
			
			//INSERT RECEIPT FOR INKIND FOR DEITY
			function add_receipt_inkind_deity_modal($data_array=array()) {
				$this->db->insert($this->table_Deity_Receipt,$data_array);
				return $this->db->insert_id();
			}
			
			//INSERT RECEIPT FOR DONATION/KANIKE FOR EVENT
			function add_receipt_dk_event_modal($data_array=array()) {
				$this->db->insert($this->table_Event_Receipt,$data_array);
				return $this->db->insert_id();
			}
			
			//INSERT RECEIPT FOR HUNDI FOR EVENT
			function add_receipt_hundi_event_modal($data_array=array()) {
				$this->db->insert($this->table_Event_Receipt,$data_array);
				return $this->db->insert_id();
			}
			
			//INSERT RECEIPT FOR HUNDI FOR EVENT
			function add_receipt_deity_modal($data_array=array()) {
				$this->db->insert($this->table_Deity_Receipt,$data_array);
				return $this->db->insert_id();
			}
			
			//FOR GETTING EVENTS
			function get_all_field_events($condition = array(), $order_by_field = '', $order_by_type = "asc") {
				$this->db->from($this->table_event);
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

		//FOR GETTING COUNT ALL RECEIPT EVENT
		function get_all_receipt_count($condition = array(), $order_by_field = '', $order_by_type = "asc", $like = "") {				
			$this->db->from($this->table_Event_Receipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			if($like != "")
				$this->db->like('TET_RECEIPT_NO',$like, 'both');
			
			//$this->db->join('EVENT_SEVA_OFFERED', 'EVENT_RECEIPT.ET_RECEIPT_ID = EVENT_SEVA_OFFERED.ET_RECEIPT_ID');
			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->num_rows();
			} else {
				return 0;
			}
		}

		//FOR ALL RECEIPT EVENT
		function get_all_field_all_receipt($condition = array(), $order_by_field = '', $order_by_type = '', $num = 10, $start = 0, $like = "") {
			$this->db->select("TRUST_EVENT_RECEIPT.TET_RECEIPT_ID,TET_RECEIPT_NO,TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID,TET_RECEIPT_CATEGORY_TYPE,TET_RECEIPT_NAME,IK_APPRX_AMT,IK_ITEM_DESC,TET_RECEIPT_PAYMENT_METHOD,TET_RECEIPT_ISSUED_BY,PAYMENT_STATUS,TET_RECEIPT_PRICE,POSTAGE_PRICE,RECEIPT_TET_NAME,AUTHORISED_STATUS,AUTHORISED_BY_NAME")->from($this->table_Event_Receipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			if($like != "")
				$this->db->like('TET_RECEIPT_NO',$like, 'both');
			
			//$this->db->join('EVENT_SEVA_OFFERED', 'EVENT_RECEIPT.ET_RECEIPT_ID = EVENT_SEVA_OFFERED.ET_RECEIPT_ID');
			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			$this->db->join('trust_event_inkind_offered', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_ID = trust_event_inkind_offered.TET_RECEIPT_ID','left');
			

			$this->db->limit($num, $start);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR DEITY RECEIPT REPORT AMOUNT
		function get_all_amount_trust($condition = array(), $order_by_field = '', $order_by_type = "asc", $like = "") {
			$this->db->select('SUM(FH_AMOUNT) AS AMOUNT');
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
			}

			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_RECEIPT.HB_ID', 'left');

			if($like != "") {
				$where = "(TR_NO like \"%$like%\" or TRUST_HALL_BOOKING.HB_NO like \"%$like%\")";
				$this->db->where($where);
				// $this->db->like('TR_NO',$like, 'both');
				// $this->db->or_like('TRUST_HALL_BOOKING.HB_NO',$like, 'both');
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
		
		//INSERT RECEIPT FOR TRUST
		function add_receipt_trust_modal($data_array=array()) {
			$this->db->insert($this->table,$data_array);
			return $this->db->insert_id();
		}
		
		//FOR ALL RECEIPT TRUST
		function get_all_field_all_receipt_trust($condition = array(), $order_by_field = '', $order_by_type = '', $num = 10, $start = 0, $like = "") {
			$this->db->select('TR_ID,TR_NO ,HB_NO,FH_NAME,RECEIPT_NAME,RECEIPT_PAYMENT_METHOD, FH_AMOUNT, trust_receipt.ENTERED_BY, trust_receipt.ENTERED_BY_NAME,PAYMENT_STATUS,RECEIPT_CATEGORY_ID')->from($this->table);
			if ($condition) {
				$this->db->where($condition);
			}

			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_RECEIPT.HB_ID','left');
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			if($like != "") {
				$where = "(TR_NO like \"%$like%\" or TRUST_HALL_BOOKING.HB_NO like \"%$like%\")";
				$this->db->where($where);
				// $this->db->like('TR_NO',$like, 'both');
				// $this->db->or_like('TRUST_HALL_BOOKING.HB_NO',$like, 'both');
			}

			$this->db->limit($num, $start);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR GETTING COUNT ALL RECEIPT TRUST
		function get_all_receipt_count_trust($condition = array(), $order_by_field = '', $order_by_type = "asc", $like = "") {				
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_RECEIPT.HB_ID','left');
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			if($like != "")
				$this->db->like('TR_NO',$like, 'both');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->num_rows();
			} else {
				return 0;
			}
		}

		//SLAP
		//GET BANK
		// added the code by adithya on 05-01-24 start
		function get_banks() {
		//bank 															
			$this->db->from('trust_financial_group_ledger_heads');
			$this->db->where('T_FGLH_PARENT_ID',9);
			$query = $this->db->get();									   
			return $query->result();
		}
		function getCardBanks($condition = ""){
			$this->db->from('trust_financial_group_ledger_heads');
			$this->db->where('T_FGLH_PARENT_ID',9);
			if ($condition) {
				$this->db->where($condition);
			}
			$query = $this->db->get();									   
			return $query->result();
		}
		// added the code by adithya on 05-01-24 end
		
	}
?>
