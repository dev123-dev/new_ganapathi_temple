<?php
	class Receipt_modal extends CI_Model{
		//TABLE NAME
		var $table = 'INKIND_ITEMS';
		var $table_Event_Receipt = 'EVENT_RECEIPT';
		var $table_Event_Inkind_Offered = 'EVENT_INKIND_OFFERED';
		var $table_Deity_Inkind_Offered = 'DEITY_INKIND_OFFERED';
		var $table_Deity_Receipt = 'DEITY_RECEIPT';
		var $table_deity = "DEITY";
		var $table_event = "EVENT";
		var $table_kanike = "KANIKE_SETTING";
		
		
		public function __Construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		function get_receipt() {
			
		}
		
		function get_daily_report($date="",$start,$num) {
			//$sql="SELECT * FROM deity_receipt INNER JOIN jeernodhara_head ON jeernodhara_head.JH_ID = deity_receipt.JH_ID WHERE deity_receipt.RECEIPT_DATE = '28-05-2019' AND deity_receipt.RECEIPT_ACTIVE = 1"
			$this->db->select()->from('DEITY_RECEIPT');
			$this->db->join('DEITY_RECEIPT_CATEGORY','DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID');
			$this->db->join('USERS','USERS.USER_ID = DEITY_RECEIPT.RECEIPT_ISSUED_BY_ID ');
			$this->db->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date, 'deity_receipt.RECEIPT_ACTIVE'=>1,'deity_receipt.IS_JEERNODHARA'=>1));
			$this->db->order_by('RECEIPT_ID','DESC');
			$this->db->LIMIT($num,$start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		function get_min_date() {
			$this->db->select()->from('DEITY_RECEIPT');
			$this->db->where(array('deity_receipt.RECEIPT_ACTIVE'=>1,'deity_receipt.IS_JEERNODHARA'=>1));
			$this->db->order_by('STR_TO_DATE(RECEIPT_DATE, "%d-%m-%Y")');
			$this->db->LIMIT(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->row()->RECEIPT_DATE;
			} else {
				return array();
			}
		}

		function get_daily_report_count($date="") {
			//$sql="SELECT * FROM deity_receipt INNER JOIN jeernodhara_head ON jeernodhara_head.JH_ID = deity_receipt.JH_ID WHERE deity_receipt.RECEIPT_DATE = '28-05-2019' AND deity_receipt.RECEIPT_ACTIVE = 1"
			$this->db->select()->from('DEITY_RECEIPT');
			$this->db->join('DEITY_RECEIPT_CATEGORY','DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID');
			$this->db->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date, 'deity_receipt.RECEIPT_ACTIVE'=>1,'deity_receipt.IS_JEERNODHARA'=>1));
			$this->db->order_by('RECEIPT_ID','DESC');
						
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->num_rows();
			} else {
				return 0;
			}
		}
		
		//jeernodhara pdf
		function get_daily_reportPdf($condition = array(),$userId, $payMethod, $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_Deity_Receipt);
			if ($condition) {
				$this->db->where($condition);
				$this->db->where('IS_JEERNODHARA',1);
				$this->db->where('RECEIPT_ACTIVE',1);
				
				if($userId > 0) {
					$this->db->where('RECEIPT_ISSUED_BY_ID',$userId);
				}
				
				if($payMethod != "All") {
					$this->db->where('RECEIPT_PAYMENT_METHOD',$payMethod);
				}
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$this->db->join('USERS', 'DEITY_RECEIPT.RECEIPT_ISSUED_BY_ID = USERS.USER_ID');
			$this->db->order_by('RECEIPT_ID', 'asc');
						
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}		
	
		/* function get_daily_reportPdf($date) {
			//$date=date('d-m-Y');,CONCAT('Rs. ',sum(RECEIPT_PRICE),'/-') AS TOTAL
			$this->db->select("RECEIPT_NO,RECEIPT_DATE,RECEIPT_NAME,deity_receipt_category.RECEIPT_CATEGORY_TYPE,RECEIPT_PAYMENT_METHOD,RECEIPT_PRICE")->from('DEITY_RECEIPT');
			$this->db->join('DEITY_RECEIPT_CATEGORY','DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID');
			$this->db->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date, 'deity_receipt.RECEIPT_ACTIVE'=>1,'deity_receipt.IS_JEERNODHARA'=>1));
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		} */
		
		function update_notes_model($table, $condition=array(),$data_array=array()){
			if($condition){
				$this->db->where($condition);
			}
			
			if($this->db->update($table,$data_array)){
				return true;
			} else {
				return false;
			}
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
		
		//FOR GETTING DEITY
		function get_all_field_deity_receipt($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_Deity_Receipt);
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
		
		//INSERT ITEMS FOR INKIND OFFERED FOR EVENT
		function add_receipt_inkind_offered_event_modal($data_array=array()) {
			$this->db->insert($this->table_Event_Inkind_Offered,$data_array);
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
		
		
		function add_receipt_Jeernodhara_modal($data_array=array()) {
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
		
		//FOR GETTING DEITY LIMIT ONE
		function get_all_field_deity_limit($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_deity);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->limit(1);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR GETTING DEITY
		function get_all_field_deity($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_deity);
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

		//FOR GETTING ALL KANIKE NAME
		function get_all_field_kanike_name($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_kanike);
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
				$this->db->like('ET_RECEIPT_NO',$like, 'both');
			
			//$this->db->join('EVENT_SEVA_OFFERED', 'EVENT_RECEIPT.ET_RECEIPT_ID = EVENT_SEVA_OFFERED.ET_RECEIPT_ID');
			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->num_rows();
			} else {
				return 0;
			}
		}
		
		//FOR GETTING COUNT ALL RECEIPT DEITY
		function get_all_receipt_count_deity($condition = array(), $order_by_field = '', $order_by_type = "asc", $like = "") {				
			$this->db->from($this->table_Deity_Receipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			if($like != "")
				$this->db->like('RECEIPT_NO',$like, 'both');
			
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->num_rows();
			} else {
				return 0;
			}
		}
		
		//FOR ALL RECEIPT EVENT
		function get_all_field_all_receipt($condition = array(), $order_by_field = '', $order_by_type = '', $num = 10, $start = 0, $like = "") {
			$this->db->select("EVENT_RECEIPT.ET_RECEIPT_ID,ET_RECEIPT_NO,EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID,ET_RECEIPT_CATEGORY_TYPE,ET_RECEIPT_NAME,IK_APPRX_AMT,IK_ITEM_DESC,ET_RECEIPT_PAYMENT_METHOD,ET_RECEIPT_ISSUED_BY,PAYMENT_STATUS,ET_RECEIPT_PRICE,POSTAGE_PRICE,RECEIPT_ET_NAME,AUTHORISED_STATUS,AUTHORISED_BY_NAME")->from($this->table_Event_Receipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			if($like != "")
				$this->db->like('ET_RECEIPT_NO',$like, 'both');
			
			//$this->db->join('EVENT_SEVA_OFFERED', 'EVENT_RECEIPT.ET_RECEIPT_ID = EVENT_SEVA_OFFERED.ET_RECEIPT_ID');
			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			$this->db->join('event_inkind_offered', 'EVENT_RECEIPT.ET_RECEIPT_ID = event_inkind_offered.ET_RECEIPT_ID','left');
			
			$this->db->limit($num, $start);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		function get_seva_count($date = "", $condition_like = "", $or_condition = "") {
			$this->db->select()->from('DEITY_RECEIPT')
			->join('DEITY_SEVA_OFFERED', 'DEITY_RECEIPT.RECEIPT_ID = DEITY_SEVA_OFFERED.RECEIPT_ID');
				
			if($date != "")
				$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1));
				
			if($condition_like != "")
				$this->db->like($condition_like, false, 'after');

			if($or_condition != "") {
				$this->db->or_like($or_condition, false, 'after');
				if($date != "")
					$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1));
			}
				
			$query = $this->db->get();
			return $query->num_rows();
		}
		
		//FOR ALL RECEIPT DEITY
		function get_all_field_all_receipt_deity($condition = array(), $order_by_field = '', $order_by_type = '', $num = 10, $start = 0, $like = "") {
			$this->db->select("DEITY_RECEIPT.RECEIPT_ID,RECEIPT_NO,DEITY_RECEIPT.RECEIPT_CATEGORY_ID,RECEIPT_CATEGORY_TYPE,RECEIPT_NAME,DY_IK_APPRX_AMT,DY_IK_ITEM_DESC,RECEIPT_PAYMENT_METHOD,RECEIPT_ISSUED_BY,PAYMENT_STATUS,RECEIPT_PRICE,POSTAGE_PRICE")->from($this->table_Deity_Receipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			if($like != "")
				$this->db->like('RECEIPT_NO',$like, 'both');
			
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$this->db->join('deity_inkind_offered', 'DEITY_RECEIPT.RECEIPT_ID = deity_inkind_offered.RECEIPT_ID','left');

			$this->db->limit($num, $start);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//GET ALL INKIND ITEMS
		function get_all_field_inkind_items($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table);
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
		
		
		//Get Deity
		function getDeties() {
			$where = array(
				'DEITY.DEITY_ACTIVE'=>"1"
			);
			$this->db->select()->from('DEITY')->where($where);
			$query = $this->db->get();
			return $query->result('array');
		}
		
		//Get Deity Sevas
		function getDetiesSevas() {
			$where = array(
				'DEITY_SEVA.SEVA_ACTIVE'=>"1", 'DEITY_SEVA.BOOKING !=' => "1"
				); 
			
			$where2 = array(
				'DEITY_SEVA_PRICE.SEVA_PRICE_ACTIVE'=>"1"
			);

			$strq1 = $this->db->select()->from('DEITY_SEVA')
			->join('DEITY_SEVA_PRICE', 'DEITY_SEVA.SEVA_ID = DEITY_SEVA_PRICE.SEVA_ID')
			->where($where)
			->where($where2)
			->where("(SEVA_BELONGSTO = 'Deity' OR SEVA_BELONGSTO = 'Deity/Shashwath')")
			->order_by("SEVA_NAME", "asc");
			$query = $this->db->get();			
			return $query->result('array');
		}
		
		//for booking
		function getDetiesBooking() {
			$where = array(
				'DEITY_SEVA.SEVA_ACTIVE'=>"1",
				'DEITY_SEVA.BOOKING'=>1,
				'DEITY.DEITY_ACTIVE'=>"1"
			);
			
			$this->db->select()->from('DEITY')
			->join('DEITY_SEVA', 'DEITY_SEVA.DEITY_ID = DEITY.DEITY_ID')
			->where($where)
			->where("(SEVA_BELONGSTO = 'Deity' OR SEVA_BELONGSTO = 'Deity/Shashwath')")
			->group_by("DEITY.DEITY_NAME");
			$query = $this->db->get();
			return $query->result('array');
		}
		
		function getDetiesSevasBooking() {
			$where = array(
				'DEITY_SEVA.SEVA_ACTIVE'=>"1",
				'DEITY_SEVA.BOOKING'=>1,
			); 
			
			$this->db->select()->from('DEITY_SEVA')
			->where($where)
			->where("(SEVA_BELONGSTO = 'Deity' OR SEVA_BELONGSTO = 'Deity/Shashwath')")
			->order_by("SEVA_NAME", "asc");
			$query = $this->db->get();
			return $query->result('array');
		}

		//SLAP
		//GET BANK
		function get_banks($condition =" ") {
			$this->db->from('finacial_group_ledger_heads');
			$this->db->join('bank_ledger_allocation', 'finacial_group_ledger_heads.FGLH_ID = bank_ledger_allocation.BANK_FGLH_ID');
			$this->db->where('FGLH_PARENT_ID',9);
			if ($condition) {
				$this->db->where($condition);
			}
			$query = $this->db->get();									   //laz..
			return $query->result();
		}

		function getAllbanks() {
			$this->db->from('finacial_group_ledger_heads');
			$this->db->where('FGLH_PARENT_ID',9);

			$query = $this->db->get();									   //laz..
			return $query->result();
		}

		function getCardbanks($condition =" ") {
			$this->db->from('finacial_group_ledger_heads');
			$this->db->where('FGLH_PARENT_ID',9);
			if ($condition) {
				$this->db->where($condition);
			}
			$query = $this->db->get();									   //laz..
			return $query->result();
		}

	}
?>
