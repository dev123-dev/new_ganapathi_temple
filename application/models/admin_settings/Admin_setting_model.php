<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Admin_setting_model extends CI_Model {
		//TABLE NAME
		var $table = 'DEITY';
		var $table_History = 'DEITY_HISTORY';
		var $table_Seva = 'DEITY_SEVA';
		var $table_Seva_Price = 'DEITY_SEVA_PRICE';
		var $table_deity_receipt_category = 'DEITY_RECEIPT_CATEGORY';
		var $table_deity_receipt_counter = 'DEITY_RECEIPT_COUNTER';
		var $table_Event = 'EVENT';
		var $table_Trust_Event = 'TRUST_EVENT';
		var $table_Event_Seva = 'EVENT_SEVA';
		var $table_Trust_Event_Seva = 'TRUST_EVENT_SEVA';
		var $table_Event_Seva_Price = 'EVENT_SEVA_PRICE';
		var $table_Trust_Event_Seva_Price = 'TRUST_EVENT_SEVA_PRICE';
		var $table_Event_Seva_Limit = 'EVENT_SEVA_LIMIT';
		var $table_Trust_Event_Seva_Limit = 'TRUST_EVENT_SEVA_LIMIT';
		var $table_Event_Seva_Offered = 'EVENT_SEVA_OFFERED';
		var $table_Trust_Event_Seva_Offered = 'TRUST_EVENT_SEVA_OFFERED';
		var $table_Users = 'USERS';
		var $table_Groups = 'USER_GROUPS';
		var $chequeRemmittance = 'EVENT_RECEIPT';
	 	var $calendar_breakup = 'CALENDAR_YEAR_BREAKUP';
		var $trustChequeRemmittance = 'TRUST_EVENT_RECEIPT';
		var $deityChequeRemmittance = 'DEITY_RECEIPT';
		var $table_Rights = 'USER_RIGHTS';
		var $table_Group_Rights = 'GROUP_RIGHTS';
		var $table_Group_Trust_Rights = 'GROUP_TRUST_RIGHTS';
		var $table_Group_Menu = 'GROUP_MENU';
		var $table_Group_Trust_Menu = 'GROUP_TRUST_MENU';
		var $table_Group_Menu_History = 'GROUP_MENU_HISTORY';
		var $table_Group_Trust_Menu_History = 'GROUP_TRUST_MENU_HISTORY';
		var $table_Group_Inkind_Items = 'INKIND_ITEMS';
		var $table_Trust_Group_Inkind_Items = 'TRUST_INKIND_ITEMS';
		var $table_event_receipt_category = 'EVENT_RECEIPT_CATEGORY';
		var $table_trust_event_receipt_category = 'TRUST_EVENT_RECEIPT_CATEGORY';
		var $table_event_receipt_counter = 'EVENT_RECEIPT_COUNTER';
		var $table_finance_voucher_counter = 'finance_voucher_counter';
		var $table_trust_event_receipt_counter = 'TRUST_EVENT_RECEIPT_COUNTER';
		var $table_Event_History = 'EVENT_HISTORY';
		var $table_Trust_Event_History = 'TRUST_EVENT_HISTORY';
		var $table_Time_Setting = 'TIME_SETTING';
		var $table_Deity_Receipt = 'DEITY_RECEIPT';
		var $table_Deity_Print_History = 'DEITY_PRINT_HISTORY';
		var $table_Event_Receipt = 'EVENT_RECEIPT';
		var $table_Event_Print_History = 'EVENT_PRINT_HISTORY';
		var $table_Auction_Item = 'AUCTION_ITEM';
		var $table_Auction_Item_Trust = 'TRUST_AUCTION_ITEM';
		var $table_Auction_Item_Default_Bid = 'AUCTION_ITEM_DEFAULT_BID';
		var $table_Auction_Item_Default_Bid_Trust = 'TRUST_AUCTION_ITEM_DEFAULT_BID';
		var $table_Auction_Item_Bid_Range = 'AUCTION_ITEM_BID_RANGE';
		var $table_Auction_Item_Bid_Range_Trust = 'TRUST_AUCTION_ITEM_BID_RANGE';
		var $table_Auction_Item_Category = 'AUCTION_ITEM_CATEGORY';
		var $table_Auction_Item_Category_Trust = 'TRUST_AUCTION_ITEM_CATEGORY';
		var $table_Financial = 'FINANCIAL_YEAR';
		var $table_Bank_Setting = 'BANK';
		var $table_Event_Bank_Setting = 'EVENT_BANK';
		var $table_Trust_Bank_Setting = 'TRUST_BANK';
		var $table_Trust_Event_Bank_Setting = 'TRUST_EVENT_BANK';
		var $table_Trust_Receipt = 'TRUST_RECEIPT';
		var $table_Hall_Setting = 'HALL';
		var $table_Financial_Setting = 'FINANCIAL_HEAD';
		var $table_Hall_Financial_Head = 'HALL_FINANCIAL_HEAD';
		var $table_Trust_Financial_Head_Counter = 'FINANCIAL_HEAD_COUNTER';
		var $table_block_date_details = 'TRUST_BLOCK_DATE_TIME';
		var $table_Period = 'SHASHWATH_PERIOD_SETTING';
		var $table_Kanike = "KANIKE_SETTING";
		var $table_trust_finance_committee = "trust_finance_committee";

		public function __construct() {
			parent::__construct();
			$this->load->database();
		}
		
		//ADD AUCTION ITEMS DEFAULT BID
		function add_auction_item_default_bid_modal_trust($data_array=array()) {
			$this->db->insert($this->table_Auction_Item_Default_Bid_Trust,$data_array);
			return $this->db->insert_id();
		}

		//FOR EDIT AUCTION ITEM
		function edit_auction_item_trust($condition=array(),$data_array=array()){
			if($condition){
				$this->db->where($condition);
			}
			
			if($this->db->update($this->table_Auction_Item_Trust,$data_array)){
				return true;
			} else {
				return false;
			}
		}	

		//ADD AUCTION ITEMS
		function trust_add_auction_item_modal($data_array=array()) {
			$this->db->insert($this->table_Auction_Item_Trust,$data_array);
			return $this->db->insert_id();
		}

		//FOR GETTING BID RANGE
		function get_all_field_bid_range_trust($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_Auction_Item_Bid_Range_Trust);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->join('TRUST_AUCTION_ITEM', 'TRUST_AUCTION_ITEM_BID_RANGE.IBR_AI_ID = TRUST_AUCTION_ITEM.AI_ID');
			$this->db->join('TRUST_AUCTION_ITEM_CATEGORY', 'TRUST_AUCTION_ITEM_BID_RANGE.IBR_AIC_ID = TRUST_AUCTION_ITEM_CATEGORY.AIC_ID','left');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		//FOR GETTING DEFAULT BID
		function get_all_field_default_bid_trust($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_Auction_Item_Default_Bid_Trust);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->join('TRUST_AUCTION_ITEM', 'TRUST_AUCTION_ITEM_DEFAULT_BID.IDB_AI_ID = TRUST_AUCTION_ITEM.AI_ID');
			$this->db->join('TRUST_AUCTION_ITEM_CATEGORY', 'TRUST_AUCTION_ITEM_DEFAULT_BID.IDB_AIC_ID = TRUST_AUCTION_ITEM_CATEGORY.AIC_ID','left');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		//FOR GETTING AUCTION ITEMS
		function get_all_field_auction_item_trust($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_Auction_Item_Trust);
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

		/******EVENTS (ADD, EDIT, DISPLAY, DELETE)******/
		//FOR BID RANGE
		function edit_price($table,$data_array=array()){
						
			if($this->db->update($table,$data_array)){
				return true;
			} else {
				return false;
			}
		}
		
		function get_deity_donation_special_receipt_price($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('PRICE');
			$this->db->from('DEITY_DONATION_SPECIAL_RECEIPT_PRICE');
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
				return 0;
			}
		}
		
		function get_deity_kanike_special_receipt_price($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('PRICE');
			$this->db->from('DEITY_KANIKE_SPECIAL_RECEIPT_PRICE');
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
				return 0;
			}
		}
		
		//FOR DISPLAY EVENTS
		function get_trust_all_field_event($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_Trust_Event);
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
				// it was return 0 before changed it to array by adithya it was giving error before
				return array();
			}
		}
		
		//FOR DISPLAY EVENTS
		function get_trust_all_field_event_activate($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table_Trust_Event);
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
				return 0;
			}
		}
		
		function get_trust_event_receipt_counter($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('TET_RECEIPT_COUNTER_ID');
			$this->db->from($this->table_trust_event_receipt_counter);
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
				return 0;
			}
		}
				
		//FOR EDIT EVENT
		function edit_trust_event_modal($condition=array(),$data_array=array()){
			if($condition){
				$this->db->where($condition);
			}
			
			if($this->db->update($this->table_Trust_Event,$data_array)){
				return true;
			} else {
				return false;
			}
		}
		
		//start and end date of financial year
	function get_financial_frmto_date() {
		$Mth = $this->get_finMth();
		$dbFinMth = $Mth->MONTH_IN_NUMBER;
		$currFinMth = date('n');
		if($dbFinMth == 1) {
			$dtString = date('Y')."-01-01:".date('Y')."-12-31";
		} else {
		if($currFinMth >= $dbFinMth && $currFinMth <= 12 ) {
			$dtString = date('Y')."-".(($dbFinMth < 10)?"0".$dbFinMth:$dbFinMth)."-01:".(date('Y') + 1)."-".(($dbFinMth-1)<10?"0".($dbFinMth-1):($dbFinMth-1))."-".$this->find_no_days_normal_leap($dbFinMth-1,date('Y')+1);
			}
			if($currFinMth >= 1 && $currFinMth <= $dbFinMth - 1) {
			$dtString = (date('Y')-1)."-".(($dbFinMth < 10)?"0".$dbFinMth:$dbFinMth)."-01:".date('Y')."-".(($dbFinMth-1)<10?"0".($dbFinMth-1):($dbFinMth-1))."-".$this->find_no_days_normal_leap($dbFinMth-1,date('Y'));
			} 
		}
		return $dtString;
	}
	
	function find_no_days_normal_leap($chkMth,$year) {
		if( (0 == date('Y') % 4) and (0 != date('Y') % 100) or (0 == date('Y') % 400) ) {
			if($chkMth == 2 || $chkMth == "02") {
				$noDays = 29;
			} else {
				$noDays = date("t",strtotime($year."-".$chkMth."-20"));
			}
		} else {
			$noDays = date("t",strtotime($year."-".$chkMth."-20"));
		}
		return $noDays;
	}
	
	function get_finMth(){
	  $this->db->select('MONTH_IN_NUMBER');
	  $this->db->from('FINANCIAL_YEAR');
	  $query = $this->db->get();
	  if($query->num_rows()>0)
	  return $query->first_row();
	}
		
		
		
	//FOR GETTING RECEIPT CATEGORY
	function get_trust_all_field_receipt_category($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->distinct();
		$this->db->select('TET_ACTIVE_RECEIPT_COUNTER_ID');
		$this->db->from($this->table_trust_event_receipt_category);
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

	/******EVENTS ENDS HERE (ADD, EDIT, DISPLAY, DELETE)******/

	function get_all_trustChequeRemmittanceCount($condition = array(),$cheque_number = '', $order_by_field = '', $order_by_type = "desc") {
		$this->db->from($this->table_Trust_Receipt);
		if ($condition) {
			$this->db->where($condition);
		}
		if($cheque_number !='' || $cheque_number == 0){
			$this->db->like('CHEQUE_NO',$cheque_number, 'after');
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
			
		}
		
		$this->db->order_by("PAYMENT_DATE_TIME", "desc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return $query->num_rows();
		}
	}

	//TRUST CHECK REMMITTANCE 
function get_all_trustChequeRemmittance($fromDate,$toDate,$num = 10, $start = 0, $condition = array(),$cheque_number = '', $order_by_field = '', $order_by_type = "desc") {
		
////////////////////////// adding temple like code for trust cheque remmittence by adithya start
$sql = "SELECT 
         TUC_ID,
         TUC_BY_ID,
         TR_NO,
         TUC_BY_NAME,
         TUC_EOD_DATE,
         RECEIPT_NAME,
         TUC_CHEQUE,
         TUC_CHEQUE_NO,
         TUC_CHEQUE_DATE,
         TUC_BANK_NAME,
         TUC_BRANCH_NAME,
         TUC_IS_DEPOSITED,
         TUC_LEDGER_ID,
         TUC_DATE_TIME,
         TUC_DATE,
         TUC_EOD_DATE AS EOD,
         trust_receipt.TR_NO,
         trust_receipt.TR_ID,
         trust_user_collection.TUC_RECEIPT_ID,
         trust_receipt.PAYMENT_STATUS,
         trust_receipt.FH_ID 
         FROM 
         trust_user_collection 
         JOIN 
         trust_receipt ON trust_user_collection.TUC_RECEIPT_ID = trust_receipt.TR_ID 
         JOIN 
         financial_head ON trust_receipt.FH_ID = financial_head.FH_ID 
         WHERE 
         (TUC_DATE BETWEEN '".$fromDate."' AND '".$toDate."') 
         AND TUC_IS_DEPOSITED != 1 
         ORDER BY 
         TUC_ID ASC 
         LIMIT 
         ".$start.",".$num."";
         
         $query = $this->db->query($sql);
        //  print_r($sql);
         if ($query->num_rows() > 0) {
         return $query->result();
         } else {
         return array();
         }
         
         ///////////////////////// adding temple like code for trust cheque remmittence by adithya end
		
		// $this->db->from($this->table_Trust_Receipt);
		// if ($condition) {
		// 	$this->db->where($condition);
		// }
		// if($cheque_number !='' || $cheque_number == 0){
		// 	$this->db->like('CHEQUE_NO',$cheque_number, 'after');
		// }
		
		// if ($order_by_field) {
		// 	$this->db->order_by($order_by_field, $order_by_type);
		// 	$this->db->order_by("PAYMENT_DATE_TIME", "desc");
		// }
		
		// $this->db->limit($num, $start);		
		
		// $query = $this->db->get();
		// if ($query->num_rows() > 0) {
		// 	return $query->result();
		// } else {
		// 	return array();
		// }
	}

	//UPDATE BLOCK DATE
	function update_block_date_modal($condition, $data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_block_date_details,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR ADDING BLOCK DATE
	function add_block_date_modal($data_array=array()) {
		$this->db->insert($this->table_block_date_details,$data_array);
		return $this->db->insert_id();
	}

	//FOR GETTING BLOCK DATE DETAILS
	function get_all_field_block_date_modal($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_block_date_details);
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

	//UPDATE TRUST BANK
	function update_trust_bank_modal($condition, $data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Trust_Bank_Setting,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//UPDATE TRUST EVENT BANK
	function update_trust_event_bank_modal($condition, $data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Trust_Event_Bank_Setting,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//ADD TRUST BANK
	function add_trust_bank_modal($data_array=array()) {
		$this->db->insert($this->table_Trust_Bank_Setting,$data_array);
		return $this->db->insert_id();
	}

	//ADD TRUST EVENT BANK
	function add_trust_event_bank_modal($data_array=array()) {
		$this->db->insert($this->table_Trust_Event_Bank_Setting,$data_array);
		return $this->db->insert_id();
	}

	//FOR GETTING BANK DETAILS FOR TRUST
	function get_all_field_trust_bank_modal($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Trust_Bank_Setting);
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

	//FOR GETTING EVENT BANK DETAILS FOR TRUST
	function get_all_field_event_trust_bank_modal($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Trust_Event_Bank_Setting);
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

	//FOR EDIT HALL AND FINANCIAL HEAD
	function edit_hall_financial_head($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Hall_Financial_Head,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR EVENT RECEIPT REPORT COUNT
	function count_rows_block_date_details($condition=array(), $order_by_field = '', $order_by_type = "asc"){
		$this->db->from($this->table_block_date_details);
		if($condition){
			$this->db->where($condition);
		}
		
		$query = $this->db->get();
		$row=$query->num_rows();
		return $row;
	}

	//FOR GETTING BLOCK DATE DETAILS
	function get_all_field_block_date_details($condition = array(), $order_by_field = '', $order_by_type = "", $num = 10, $start = 0) {
		$this->db->from($this->table_block_date_details);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('HALL', 'TRUST_BLOCK_DATE_TIME.H_ID = HALL.HALL_ID');
		$this->db->limit($num, $start);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR ADDING HALL FINANCIAL HEAD
	function add_hall_financial_head_modal($data_array=array()) {
		$this->db->insert($this->table_Hall_Financial_Head,$data_array);
		return $this->db->insert_id();
	}

	//FOR GETTING FINANCIAL HEADS BASED ON HALL
	function get_all_field_financial_heads($sql) {
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR GETTING FINANCIAL DETAILS
	function get_all_field_financial_details($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Financial_Setting);
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

	//FOR ADDING FINANCIAL
	function add_financial_modal($data_array=array()) {
		$this->db->insert($this->table_Financial_Setting,$data_array);
		return $this->db->insert_id();
	}

	//FOR EDIT FINANCIAL
	function edit_financial($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Financial_Setting,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR GETTING HALL DETAILS
	function get_all_field_hall_details($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Hall_Setting);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$queryHall = $this->db->get();
		$hall = $queryHall->result();
		foreach($hall as &$row) {
			$this->db->join('FINANCIAL_HEAD', 'HALL_FINANCIAL_HEAD.FH_ID = FINANCIAL_HEAD.FH_ID');
			$hall_id = $row->HALL_ID;
			$condition = array('H_ID' => $hall_id, 'HFH_STATUS' => 1);
			$this->db->where($condition);
			$this->db->from($this->table_Hall_Financial_Head);
			$query = $this->db->get();
			$hname = "";
			if ($query->num_rows() > 1) {
				$queryOne = $query->result();
				for($i = 0; $i < $query->num_rows(); $i++) {
					if($i == 0) {
						$hname = $queryOne[$i]->FH_NAME;
					} else {
						$hname .= ", ".$queryOne[$i]->FH_NAME;
					}
				}
			} else {
				@$hname =  $query->row()->FH_NAME;
			}
			$row->FH_NAME = $hname;
		}
		return $hall;
	}

	//FOR ADDING HALL
	function add_hall_modal($data_array=array()) {
		$this->db->insert($this->table_Hall_Setting,$data_array);
		return $this->db->insert_id();
	}

	//FOR EDIT HALL
	function edit_hall($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Hall_Setting,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR GETTING BANK DETAILS FOR EVENT
	function get_all_field_event_bank_modal($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Event_Bank_Setting);
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

	//EVENT ADD BANK
	function add_event_bank_modal($data_array=array()) {
		$this->db->insert($this->table_Event_Bank_Setting,$data_array);
		return $this->db->insert_id();
	}

	//EVENT UPDATE BANK
	function update_event_bank_modal($condition, $data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Event_Bank_Setting,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR GETTING BANK DETAILS FOR DEITY
	function get_all_field_bank_modal($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Bank_Setting);
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

	//ADD BANK
	function add_bank_modal($data_array=array()) {
		$this->db->insert($this->table_Bank_Setting,$data_array);
		return $this->db->insert_id();
	}

	//UPDATE BANK
	function update_bank_modal($condition, $data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Bank_Setting,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//UPDATE REVISION DATA
	function edit_revision_data($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Seva_Price,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//GET FINACIAL MONTH 
	function get_financial_month($condition = array(), $order_by_field = '', $order_by_type = "desc") {
		$this->db->from($this->table_Financial);
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

	//UPDATE FINANCIAL MONTH
	function update_financial_month($data_array=array()) {
		if($this->db->update($this->table_Financial,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//RESET COUNTER DEITY
	function update_reset_deity($condition=array(),$data_array=array()) {
		if ($condition) {
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_deity_receipt_counter,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//RESET COUNTER DEITY
	function update_reset_event($data_array=array()) {
		if($this->db->update($this->table_event_receipt_counter,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//RESET COUNTER FINANCIAL VOUCHER
	function update_reset_finance_voucher($data_array=array()) {
		if($this->db->update($this->table_finance_voucher_counter,$data_array)){
			return true;
		} else {
			return false;
		}
	}


	//COUNT OF DEFAULT BID
	function count_rows_default_bid_trust($condition=array(), $order_by_field = '', $order_by_type = "asc"){
		$this->db->from($this->table_Auction_Item_Default_Bid_Trust);
		if($condition){
			$this->db->where($condition);
		}
		
		$query = $this->db->get();
		$row=$query->num_rows();
		return $row;
	}

	//COUNT OF DEFAULT BID
	function count_rows_default_bid($condition=array(), $order_by_field = '', $order_by_type = "asc"){
		$this->db->from($this->table_Auction_Item_Default_Bid);
		if($condition){
			$this->db->where($condition);
		}
		
		$query = $this->db->get();
		$row=$query->num_rows();
		return $row;
	}

	//FOR BID RANGE
	function edit_bid_range_trust($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Auction_Item_Bid_Range_Trust,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR BID RANGE
	function edit_bid_range($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Auction_Item_Bid_Range,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR EDIT AUCTION ITEM
	function edit_auction_item($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Auction_Item,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR DEFAULT AUCTION BID
	function edit_default_bid_trust($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Auction_Item_Default_Bid_Trust,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR DEFAULT AUCTION BID
	function edit_default_bid($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Auction_Item_Default_Bid,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//ADD AUCTION ITEMS
	function add_bid_range_modal_trust($data_array=array()) {
		$this->db->insert($this->table_Auction_Item_Bid_Range_Trust,$data_array);
		return $this->db->insert_id();
	}

	//ADD AUCTION ITEMS
	function add_bid_range_modal($data_array=array()) {
		$this->db->insert($this->table_Auction_Item_Bid_Range,$data_array);
		return $this->db->insert_id();
	}

	//ADD AUCTION ITEMS DEFAULT BID
	function add_auction_item_default_bid_modal($data_array=array()) {
		$this->db->insert($this->table_Auction_Item_Default_Bid,$data_array);
		return $this->db->insert_id();
	}

	//ADD AUCTION ITEMS
	function add_auction_item_modal($data_array=array()) {
		$this->db->insert($this->table_Auction_Item,$data_array);
		return $this->db->insert_id();
	}

	//FOR GETTING BID RANGE
	function get_all_field_bid_range($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Auction_Item_Bid_Range);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('AUCTION_ITEM', ' AUCTION_ITEM_BID_RANGE.IBR_AI_ID = AUCTION_ITEM.AI_ID');
		$this->db->join('AUCTION_ITEM_CATEGORY', ' AUCTION_ITEM_BID_RANGE.IBR_AIC_ID = AUCTION_ITEM_CATEGORY.AIC_ID','left');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR GETTING DEFAULT BID
	function get_all_field_default_bid($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Auction_Item_Default_Bid);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('AUCTION_ITEM', 'AUCTION_ITEM_DEFAULT_BID.IDB_AI_ID = AUCTION_ITEM.AI_ID');
		$this->db->join('AUCTION_ITEM_CATEGORY', 'AUCTION_ITEM_DEFAULT_BID.IDB_AIC_ID = AUCTION_ITEM_CATEGORY.AIC_ID','left');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR GETTING AUCTION ITEM CATEGORY
	function get_all_field_auction_item_category_trust($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Auction_Item_Category_Trust);
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

	//FOR GETTING AUCTION ITEM CATEGORY
	function get_all_field_auction_item_category($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Auction_Item_Category);
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

	//FOR GETTING AUCTION ITEMS
	function get_all_field_auction_item($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Auction_Item);
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

	//FOR GETTING EVENT 
	function get_all_field($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Event);
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

	//FOR GETTING TRUST EVENT 
	function get_all_field_trust($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Trust_Event);
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

	//GETTING ALL USERS
	function get_all_users_on_events($condition=array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->distinct();
		$this->db->select('ET_RECEIPT_ISSUED_BY_ID, ET_RECEIPT_ISSUED_BY');
		$this->db->from($this->table_Event_Receipt);
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

	//GETTING ALL USERS
	function get_all_users_on_events_trust($condition=array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->distinct();
		$this->db->select('TET_RECEIPT_ISSUED_BY_ID, TET_RECEIPT_ISSUED_BY');
		$this->db->from($this->trustChequeRemmittance);
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

	//FOR EVENT RECEIPT REPORT
	function get_all_amount($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Event_Receipt);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}

		$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
		$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
		$this->db->order_by('ET_RECEIPT_ID', 'desc');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR EVENT RECEIPT REPORT
	function get_all_amount_trust($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->trustChequeRemmittance);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}

		$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
		$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
		$this->db->order_by('TET_RECEIPT_ID', 'desc');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR EVENT RECEIPT REPORT
	function get_total_amount($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->select('SUM(ET_RECEIPT_PRICE) AS PRICE');
		$this->db->from($this->table_Event_Receipt);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}

		$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
		$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
		$this->db->order_by('ET_RECEIPT_ID', 'desc');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->first_row();
		} else {
			return array();
		}
	}

	//FOR EVENT RECEIPT REPORT
	function get_total_amount_trust($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->select('SUM(TET_RECEIPT_PRICE) AS PRICE');
		$this->db->from($this->trustChequeRemmittance);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}

		$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
		$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
		$this->db->order_by('TET_RECEIPT_ID', 'desc');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->first_row();
		} else {
			return array();
		}
	}

	function get_all_app_data($condition=array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
		$this->db->from($this->table_Event_Receipt);
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

	function get_all_app_data_trust($condition=array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
		$this->db->from($this->trustChequeRemmittance);
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

	function get_all_users($condition=array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Users);
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

	function get_all_events($condition=array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Event);
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

	function get_all_events_trust($condition=array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Trust_Event);
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

	function insert_event_receipt_modal($data_array=array(),$condition=array()) {
		$this->db->insert($this->table_Event_Receipt,$data_array);
		return $this->db->insert_id();
	}

	function insert_trust_event_receipt_modal($data_array=array(),$condition=array()) {
		$this->db->insert($this->trustChequeRemmittance,$data_array);
		return $this->db->insert_id();
	}

	function get_deity_history($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Deity_Print_History);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('USERS', 'DEITY_PRINT_HISTORY.USER_ID = USERS.USER_ID'); 
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function get_event_history($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Event_Print_History);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('USERS', 'EVENT_PRINT_HISTORY.USER_ID = USERS.USER_ID'); 
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function count_rows_deity($condition=array(), $order_by_field = '', $order_by_type = "asc"){
		$this->db->from($this->table_Deity_Receipt);
		if($condition){
			$this->db->where($condition);
		}
		
		$query = $this->db->get();
		$row=$query->num_rows();
		return $row;
	}

	function get_print_deity_details($num = 10, $start = 0) {
		$this->db->limit($num, $start);	
		$this->db->where('RECEIPT_ACTIVE',1);
		$this->db->order_by('RECEIPT_ID', 'ASC');
		$deity = $this->db->get('DEITY_RECEIPT')->result();
		$count = 0;
		foreach ($deity as &$row) {
			$receipt_id = $row->RECEIPT_ID;
			$this->db->select('COUNT(DPH_ID) AS DEITY_COUNT');
			$this->db->from('DEITY_PRINT_HISTORY');
			$this->db->where('RECEIPT_ID',$receipt_id);
			$row->PRINT_COUNT = $this->db->get()->row()->DEITY_COUNT;
		}
		return $deity;
	}

	function count_rows_event($condition=array(), $order_by_field = '', $order_by_type = "asc"){
		$this->db->from($this->table_Event_Receipt);
		if($condition){
			$this->db->where($condition);
		}
		
		$query = $this->db->get();
		$row=$query->num_rows();
		return $row;
	}

	function get_print_event_details($num = 10, $start = 0) {
		$this->db->limit($num, $start);	
		$this->db->where('ET_RECEIPT_ACTIVE',1);
		$this->db->order_by('ET_RECEIPT_ID', 'ASC');
		$event = $this->db->get('EVENT_RECEIPT')->result();
		$count = 0;
		foreach ($event as &$row) {
			$receipt_id = $row->ET_RECEIPT_ID;
			$this->db->select('COUNT(EPH_ID) AS EVENT_COUNT');
			$this->db->from('EVENT_PRINT_HISTORY');
			$this->db->where('RECEIPT_ID',$receipt_id);
			$row->PRINT_COUNT = $this->db->get()->row()->EVENT_COUNT;
		}
		return $event;
	}

	function add_time_modal($data_array=array()) {
		$this->db->insert($this->table_Time_Setting,$data_array);
		return $this->db->insert_id();
	}

	function get_time($condition = array(), $order_by_field = '', $order_by_type = "desc") {
		if ($condition) {
			$this->db->where($condition);
		}
		
		$this->db->order_by('TIME_ID', 'desc');
		
		$this->db->limit(1);
		$time = $this->db->get('TIME_SETTING')->result();
		return $time;
	}

	/*****RECEIPT SETTING*****/
	//GET DEITY RECEIPT SETTING
	function get_deity_receipt_setting($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_deity_receipt_counter);
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

	//GET TRUST EVENT RECEIPT SETTING
	function get_trust_event_receipt_setting($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_trust_event_receipt_counter);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT_COUNTER.EVENT_ID = TRUST_EVENT.TET_ID');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//GET EVENT RECEIPT SETTING
	function get_event_receipt_setting($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_event_receipt_counter);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('EVENT', 'EVENT_RECEIPT_COUNTER.EVENT_ID = EVENT.ET_ID');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function edit_trust_event_receipt_counter_modal($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_trust_event_receipt_counter,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	function edit_event_receipt_counter_modal($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_event_receipt_counter,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	function edit_deity_receipt_counter_modal($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_deity_receipt_counter,$data_array)){
			return true;
		} else {
			return false;
		}
	}
	/*****RECEIPT SETTING ENDS HERE*****/

	/*****DONATION/KANIKE*****/
	//FOR EDIT DONATION
	function edit_donation_modal($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->chequeRemmittance,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR DISPLAY DONATION/KANIKE
	function get_all_field_single_donation($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->chequeRemmittance);
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

	function get_all_field_donation($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
		$this->db->from($this->chequeRemmittance);
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

	function get_all_field_donation_like($condition_like = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
		$this->db->from($this->chequeRemmittance);
		if($condition_like != "") {
			$this->db->like($condition_like, false, 'both');
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

	function count_rows_donation($condition=array(), $order_by_field = '', $order_by_type = "asc"){
		$this->db->from($this->chequeRemmittance);
		if($condition){
			$this->db->where($condition);
		}
		
		$query = $this->db->get();
		$row=$query->num_rows();
		return $row;
	}

	/* function count_rows_cal($condition=array(), $order_by_field = '', $order_by_type = "asc"){
		$this->db->from($this->calendar_breakup);
		if($condition){
			$this->db->where($condition);
		}
		
		$query = $this->db->get();
		$row=$query->num_rows();
		return $row;
	} */

	function count_rows_donation_trust($condition=array(), $order_by_field = '', $order_by_type = "asc"){
		$this->db->from($this->trustChequeRemmittance);
		if($condition){
			$this->db->where($condition);
		}
		
		$query = $this->db->get();
		$row=$query->num_rows();
		return $row;
	}
	/*****DONATION/KANIKE ENDS HERE*****/

	/******INKIND (ADD, EDIT, DISPLAY, DELETE)******/
	//FOR DISPLAY INKIND ITEMS
	function get_all_field_inkind($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Group_Inkind_Items);
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

	//FOR DISPLAY INKIND ITEMS
	function get_trust_all_field_inkind($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Trust_Group_Inkind_Items);
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

	//FOR ADD INKIND
	function add_inkind_modal($data_array=array()) {
		$this->db->insert($this->table_Group_Inkind_Items,$data_array);
		return $this->db->insert_id();
	}

	//FOR ADD INKIND
	function add_trust_inkind_modal($data_array=array()) {
		$this->db->insert($this->table_Trust_Group_Inkind_Items,$data_array);
		return $this->db->insert_id();
	}

	//FOR UPDATE INKIND
	function update_inkind_modal($data_array=array(),$condition=array()) {
		if ($condition) {
			$this->db->where($condition);
		}
		if ($this->db->update($this->table_Group_Inkind_Items, $data_array)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//FOR UPDATE INKIND
	function update_trust_inkind_modal($data_array=array(),$condition=array()) {
		if ($condition) {
			$this->db->where($condition);
		}
		if ($this->db->update($this->table_Trust_Group_Inkind_Items, $data_array)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	/******INKIND ENDS HERE (ADD, EDIT, DISPLAY, DELETE)******/

	/******USERS (ADD, EDIT, DISPLAY, DELETE)******/
	//FOR ADD CHANGE PASSWORD
	function add_change_password_modal($data_array=array(),$condition=array()) {
		if ($condition) {
			$this->db->where($condition);
		}
		if ($this->db->update($this->table_Users, $data_array)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//FOR UPDATE USER
	function add_update_user_modal($data_array=array(),$condition=array()) {
		if ($condition) {
			$this->db->where($condition);
		}
		if ($this->db->update($this->table_Users, $data_array)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//FOR UPDATE GROUP
	function add_update_group_modal($data_array=array(),$condition=array()) {
		if ($condition) {
			$this->db->where($condition);
		}
		if ($this->db->update($this->table_Groups, $data_array)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//FOR ADD USER
	function add_user_modal($data_array=array()) {
		$this->db->insert($this->table_Users,$data_array);
		return $this->db->insert_id();
	}

	//FOR ADD GROUP
	function add_group_modal($data_array=array()) {
		$this->db->insert($this->table_Groups,$data_array);
		return $this->db->insert_id();
	}

	//FOR DISPLAY USERS
	function get_all_field_users($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Users);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('USER_GROUPS', 'USERS.USER_GROUP = USER_GROUPS.GROUP_ID'); 
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR DISPLAY GROUP
	function get_all_field_group($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Groups);
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

	// function get_all_deityChequeRemmittance($num = 10, $start = 0, $condition = array(),$cheque_number ='', $order_by_field = '', $order_by_type = "desc") {
	// 	$this->db->from($this->deityChequeRemmittance);
	// 	if ($condition) {
	// 		$this->db->where($condition);
	// 	}
		
	// 	if($cheque_number !='' || $cheque_number == 0){
	// 		$this->db->like('CHEQUE_NO',$cheque_number, 'after');
	// 	}
		
	// 	if ($order_by_field) {
	// 		$this->db->order_by($order_by_field, $order_by_type);
	// 		$this->db->order_by("PAYMENT_DATE_TIME", "desc");
	// 	}
		
	// 	$this->db->limit($num, $start);		
		
	// 	$query = $this->db->get();
	// 	if ($query->num_rows() > 0) {
	// 		return $query->result();
	// 	} else {
	// 		return array();
	// 	}
	// }

	// function get_all_deityChequeRemmittanceCount($condition = array(),$cheque_number ='', $order_by_field = '', $order_by_type = "desc") {
	// 	$this->db->from($this->deityChequeRemmittance);
	// 	if ($condition) {
	// 		$this->db->where($condition);
	// 	}
		
	// 	if($cheque_number != '' || $cheque_number == 0){
	// 		$this->db->like('CHEQUE_NO',$cheque_number, 'after');
	// 	}
		
	// 	if ($order_by_field) {
	// 		$this->db->order_by($order_by_field, $order_by_type);
			
	// 	}
		
	// 	$this->db->order_by("PAYMENT_DATE_TIME", "desc");
	// 	$query = $this->db->get();
	// 	if ($query->num_rows() > 0) {
	// 		return $query->num_rows();
	// 	} else {
	// 		return $query->num_rows();
	// 	}
	// }

	function get_all_deityChequeRemmittance($num = 10, $start = 0,$cheque_number ='',$voucherType='') {
		if ($voucherType != '') {
			$condition = "AND RP_TYPE = '$voucherType'";
		}else{
			$condition = "";
		}
		$sql="SELECT `VOUCHER_NO`,
		     (CASE WHEN `RP_TYPE`='R2' 
			           THEN 'Receipt' 
					WHEN `RP_TYPE`='P2' 
					   THEN 'Payment' 
					WHEN `RP_TYPE`='C1' 
					    THEN 'Contra' 
					ELSE 'notfound' END )as VOUCHER_TYPE,
			`RECEIPT_FAVOURING_NAME`,
			 IF(`RP_TYPE`='R2', `FLT_DR`, FLT_CR) as AMT,
			`CHEQUE_NO`, 
			`CHEQUE_DATE`, 
			`financial_ledger_transcations`.`BANK_NAME` as `BANK_NAME`, 
			`BRANCH_NAME`, 
			`PAYMENT_STATUS`, 
			`RECEIPT_ID`, 
			`FLT_DEPOSIT_PAYMENT_DATE`,
			(SELECT FGLH_NAME 
			       FROM finacial_group_ledger_heads 
				   WHERE FGLH_ID = financial_ledger_transcations.FGLH_ID) AS DEPOSITED_BANK  
			FROM `financial_ledger_transcations` 
			JOIN `finacial_group_ledger_heads` 
			    ON `financial_ledger_transcations`.`FGLH_ID` = `finacial_group_ledger_heads`.`FGLH_ID` 
			WHERE `PAYMENT_STATUS` = 'Pending' 
			and TRANSACTION_STATUS != 'Cancelled' 
			AND (`financial_ledger_transcations`.`RP_TYPE` = 'R2' OR `financial_ledger_transcations`.`RP_TYPE` = 'P2') 
			AND (`financial_ledger_transcations`.`COMP_ID` = 1 OR `financial_ledger_transcations`.`COMP_ID` = 2) 
			AND `CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!' $condition
			union
			SELECT `VOUCHER_NO`, (CASE WHEN `RP_TYPE`='R2' THEN 'Receipt' WHEN `RP_TYPE`='P2' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' ELSE 'notfound' END )as VOUCHER_TYPE, `RECEIPT_FAVOURING_NAME`, IF(`RP_TYPE`='R2', `FLT_DR`, FLT_CR) as AMT, `CHEQUE_NO`, `CHEQUE_DATE`, `financial_ledger_transcations`.`BANK_NAME` as `BANK_NAME`, `BRANCH_NAME`, `PAYMENT_STATUS`, `RECEIPT_ID`, `FLT_DEPOSIT_PAYMENT_DATE`,(SELECT FGLH_NAME FROM finacial_group_ledger_heads WHERE FGLH_ID = financial_ledger_transcations.FGLH_ID)  AS DEPOSITED_BANK  FROM `financial_ledger_transcations` JOIN `finacial_group_ledger_heads` ON `financial_ledger_transcations`.`FGLH_ID` = `finacial_group_ledger_heads`.`FGLH_ID` WHERE `PAYMENT_STATUS` = 'Pending' and TRANSACTION_STATUS != 'Cancelled' AND `financial_ledger_transcations`.`RP_TYPE` = 'C1' AND (`financial_ledger_transcations`.`COMP_ID` = 1 OR `financial_ledger_transcations`.`COMP_ID` = 2)  AND `CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!'  $condition
			 ORDER BY STR_TO_DATE(FLT_DEPOSIT_PAYMENT_DATE, '%d-%m-%Y') LIMIT $start, $num";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}
	function get_all_deityChequeRemmittanceCount($cheque_number ='',$voucherType='') {
		if ($voucherType != '') {
			$condition = "AND RP_TYPE = '$voucherType'";
		}else{
			$condition = "";
		}
		$sql="SELECT `VOUCHER_NO`, (CASE WHEN `RP_TYPE`='R2' THEN 'Receipt' WHEN `RP_TYPE`='P2' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' ELSE 'notfound' END )as VOUCHER_TYPE, `RECEIPT_FAVOURING_NAME`, IF(`RP_TYPE`='R2', `FLT_DR`, FLT_CR) as AMT, `CHEQUE_NO`, `CHEQUE_DATE`, `financial_ledger_transcations`.`BANK_NAME` as `BANK_NAME`, `BRANCH_NAME`, `PAYMENT_STATUS`, `RECEIPT_ID`, `FLT_DEPOSIT_PAYMENT_DATE` FROM `financial_ledger_transcations` JOIN `finacial_group_ledger_heads` ON `financial_ledger_transcations`.`FGLH_ID` = `finacial_group_ledger_heads`.`FGLH_ID` WHERE `PAYMENT_STATUS` = 'Pending' and TRANSACTION_STATUS != 'Cancelled' AND (`financial_ledger_transcations`.`RP_TYPE` = 'R2' OR `financial_ledger_transcations`.`RP_TYPE` = 'P2') AND (`financial_ledger_transcations`.`COMP_ID` = 1 OR `financial_ledger_transcations`.`COMP_ID` = 2)  AND  `CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!' $condition

			union

			SELECT `VOUCHER_NO`, (CASE WHEN `RP_TYPE`='R2' THEN 'Receipt' WHEN `RP_TYPE`='P2' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' ELSE 'notfound' END )as VOUCHER_TYPE, `RECEIPT_FAVOURING_NAME`, IF(`RP_TYPE`='R2', `FLT_DR`, FLT_CR) as AMT, `CHEQUE_NO`, `CHEQUE_DATE`, `financial_ledger_transcations`.`BANK_NAME` as `BANK_NAME`, `BRANCH_NAME`, `PAYMENT_STATUS`, `RECEIPT_ID`, `FLT_DEPOSIT_PAYMENT_DATE` FROM `financial_ledger_transcations` JOIN `finacial_group_ledger_heads` ON `financial_ledger_transcations`.`FGLH_ID` = `finacial_group_ledger_heads`.`FGLH_ID` WHERE `PAYMENT_STATUS` = 'Pending' and TRANSACTION_STATUS != 'Cancelled' AND (`financial_ledger_transcations`.`COMP_ID` = 1 OR `financial_ledger_transcations`.`COMP_ID` = 2)  AND `financial_ledger_transcations`.`RP_TYPE` = 'C1' AND `CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!' $condition
			 ORDER BY STR_TO_DATE(FLT_DEPOSIT_PAYMENT_DATE, '%d-%m-%Y')";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return $query->num_rows();
		}
	}
///////////////////////////TRUST RECONCILATION CODE START BY ADITHYA START
    function get_all_TrustChequeReconcilation($num = 10, $start = 0,$cheque_number ='',$voucherType='') {
	if ($voucherType != '') {
		$condition = "AND T_RP_TYPE = '$voucherType'";
	}else{
		$condition = "";
	}
	$sql="SELECT `T_VOUCHER_NO`,
		 (CASE WHEN `T_RP_TYPE`='R2' 
				   THEN 'Receipt' 
				WHEN `T_RP_TYPE`='P2' 
				   THEN 'Payment' 
				WHEN `T_RP_TYPE`='C1' 
					THEN 'Contra' 
				ELSE 'notfound' END )as T_VOUCHER_TYPE,
		`T_RECEIPT_FAVOURING_NAME`,
		 IF(`T_RP_TYPE`='R2', `T_FLT_DR`, T_FLT_CR) as AMT,
		`T_CHEQUE_NO`, 
		`T_CHEQUE_DATE`, 
		`trust_financial_ledger_transcations`.`T_BANK_NAME` as `T_BANK_NAME`, 
		`T_BRANCH_NAME`, 
		`T_PAYMENT_STATUS`, 
		`T_RECEIPT_ID`, 
		`T_FLT_DEPOSIT_PAYMENT_DATE`,
		(SELECT T_FGLH_NAME 
			   FROM trust_financial_group_ledger_heads 
			   WHERE T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID) AS T_DEPOSITED_BANK  
		FROM `trust_financial_ledger_transcations` 
		JOIN `trust_financial_group_ledger_heads` 
			ON `trust_financial_ledger_transcations`.`T_FGLH_ID` = `trust_financial_group_ledger_heads`.`T_FGLH_ID` 
		WHERE `T_PAYMENT_STATUS` = 'Pending' 
		and T_TRANSACTION_STATUS != 'Cancelled' 
		AND (`trust_financial_ledger_transcations`.`T_RP_TYPE` = 'R2' OR `trust_financial_ledger_transcations`.`T_RP_TYPE` = 'P2') 
		AND (`trust_financial_ledger_transcations`.`T_COMP_ID` = 1 OR `trust_financial_ledger_transcations`.`T_COMP_ID` = 2) 
		AND `T_CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!' $condition
		union
		SELECT `T_VOUCHER_NO`, 
		(CASE WHEN `T_RP_TYPE`='R2' 
		THEN 'Receipt' WHEN `T_RP_TYPE`='P2' 
		THEN 'Payment' WHEN `T_RP_TYPE`='C1' 
		THEN 'Contra' ELSE 'notfound' END )as VOUCHER_TYPE,
		 `T_RECEIPT_FAVOURING_NAME`, IF(`T_RP_TYPE`='R2', `T_FLT_DR`, T_FLT_CR) as AMT, 
		 `T_CHEQUE_NO`, `T_CHEQUE_DATE`, `trust_financial_ledger_transcations`.`T_BANK_NAME` as `BANK_NAME`,
		  `T_BRANCH_NAME`, `T_PAYMENT_STATUS`, `T_RECEIPT_ID`, `T_FLT_DEPOSIT_PAYMENT_DATE`,
		  (SELECT T_FGLH_NAME 
		     FROM trust_financial_group_ledger_heads 
			  WHERE T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID)  AS DEPOSITED_BANK  
		      FROM `trust_financial_ledger_transcations` 
			  JOIN `trust_financial_group_ledger_heads` 
			  ON `trust_financial_ledger_transcations`.`T_FGLH_ID` = `trust_financial_group_ledger_heads`.`T_FGLH_ID` 
			  WHERE `T_PAYMENT_STATUS` = 'Pending' 
			  and T_TRANSACTION_STATUS != 'Cancelled' 
			  AND `trust_financial_ledger_transcations`.`T_RP_TYPE` = 'C1' 
			  AND (`trust_financial_ledger_transcations`.`T_COMP_ID` = 1 
			  OR `trust_financial_ledger_transcations`.`T_COMP_ID` = 2)  
			  AND `T_CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!'  $condition
		 ORDER BY STR_TO_DATE(T_FLT_DEPOSIT_PAYMENT_DATE, '%d-%m-%Y') LIMIT $start, $num";
	
	$query = $this->db->query($sql);
	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return array();
	}
    }

	function get_all_TrustChequeReconcilationCount($cheque_number ='',$voucherType='') {
		if ($voucherType != '') {
			$condition = "AND T_RP_TYPE = '$voucherType'";
		}else{
			$condition = "";
		}
		$sql="SELECT `T_VOUCHER_NO`, 
		      (CASE WHEN `T_RP_TYPE`='R2' 
			        THEN 'Receipt' 
					WHEN `T_RP_TYPE`='P2' 
					THEN 'Payment' 
					WHEN `T_RP_TYPE`='C1' 
					THEN 'Contra' 
				ELSE 'notfound' END )as T_VOUCHER_TYPE, `T_RECEIPT_FAVOURING_NAME`, 
				IF(`T_RP_TYPE`='R2', `T_FLT_DR`, T_FLT_CR) as AMT, 
				  `T_CHEQUE_NO`, 
				  `T_CHEQUE_DATE`, 
				  `trust_financial_ledger_transcations`.`T_BANK_NAME` as `T_BANK_NAME`, 
				  `T_BRANCH_NAME`, 
				  `T_PAYMENT_STATUS`, 
				  `T_RECEIPT_ID`, 
				  `T_FLT_DEPOSIT_PAYMENT_DATE` 
		FROM `trust_financial_ledger_transcations` 
		JOIN `trust_financial_group_ledger_heads` ON 
		`trust_financial_ledger_transcations`.`T_FGLH_ID` = `trust_financial_group_ledger_heads`.`T_FGLH_ID`
			WHERE `T_PAYMENT_STATUS` = 'Pending' and 
			T_TRANSACTION_STATUS != 'Cancelled' AND 
			(`trust_financial_ledger_transcations`.`T_RP_TYPE` = 'R2' 
			  OR `trust_financial_ledger_transcations`.`T_RP_TYPE` = 'P2') AND 
			    (`trust_financial_ledger_transcations`.`T_COMP_ID` = 1 OR 
				  `trust_financial_ledger_transcations`.`T_COMP_ID` = 2)  AND  
				  `T_CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!' $condition

			union

			SELECT `T_VOUCHER_NO`, 
			(CASE WHEN `T_RP_TYPE`='R2' 
			      THEN 'Receipt' 
				  WHEN `T_RP_TYPE`='P2' 
				  THEN 'Payment' 
				  WHEN `T_RP_TYPE`='C1' 
				  THEN 'Contra' 
			ELSE 'notfound' END )as T_VOUCHER_TYPE, `T_RECEIPT_FAVOURING_NAME`, 
			IF(`T_RP_TYPE`='R2', `T_FLT_DR`, T_FLT_CR) as AMT, 
			`T_CHEQUE_NO`, 
			`T_CHEQUE_DATE`, 
			`trust_financial_ledger_transcations`.`T_BANK_NAME` as `T_BANK_NAME`, 
			`T_BRANCH_NAME`, 
			`T_PAYMENT_STATUS`, 
			`T_RECEIPT_ID`, 
			`T_FLT_DEPOSIT_PAYMENT_DATE` 
		FROM `trust_financial_ledger_transcations` 
		JOIN `trust_financial_group_ledger_heads` ON 
		      `trust_financial_ledger_transcations`.`T_FGLH_ID` = `trust_financial_group_ledger_heads`.`T_FGLH_ID` 
		    WHERE `T_PAYMENT_STATUS` = 'Pending' and 
			T_TRANSACTION_STATUS != 'Cancelled' AND 
			(`trust_financial_ledger_transcations`.`T_COMP_ID` = 1 OR 
			`trust_financial_ledger_transcations`.`T_COMP_ID` = 2)  AND 
			`trust_financial_ledger_transcations`.`T_RP_TYPE` = 'C1' AND 
			`T_CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!' $condition
			 ORDER BY STR_TO_DATE(T_FLT_DEPOSIT_PAYMENT_DATE, '%d-%m-%Y')";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return $query->num_rows();
		}
	}
//////////////////////////TRUST RECONCILATION CODE START BY ADITHYA END

	//EVENT
	function get_all_chequeRemmittance($num = 10, $start = 0, $cheque_number = '',$voucherType='') {
		if ($voucherType != '') {
			$condition = "AND RP_TYPE = '$voucherType'";
		}else{
			$condition = "";
		}
		$sql="SELECT `VOUCHER_NO`, 
		(CASE WHEN `RP_TYPE`='R2' 
		      THEN 'Receipt' 
			  WHEN `RP_TYPE`='P2' 
			  THEN 'Payment' 
			  WHEN `RP_TYPE`='C1' 
			  THEN 'Contra' 
			  ELSE 'notfound' END )as VOUCHER_TYPE, 
			`RECEIPT_FAVOURING_NAME`, 
		IF(`RP_TYPE`='R2', `FLT_DR`, FLT_CR) as AMT, 
		  `CHEQUE_NO`, 
		  `CHEQUE_DATE`, 
		  `financial_ledger_transcations`.`BANK_NAME` as `BANK_NAME`, 
		  `BRANCH_NAME`, 
		  `PAYMENT_STATUS`, 
		  `RECEIPT_ID`, 
		  `FLT_DEPOSIT_PAYMENT_DATE` 
		FROM `financial_ledger_transcations` 
		JOIN `finacial_group_ledger_heads` 
		ON `financial_ledger_transcations`.`FGLH_ID` = `finacial_group_ledger_heads`.`FGLH_ID` 
		WHERE `PAYMENT_STATUS` = 'Pending' 
		and TRANSACTION_STATUS != 'Cancelled' 
		AND `finacial_group_ledger_heads`.FGLH_PARENT_ID = 9 
		AND (`financial_ledger_transcations`.`RP_TYPE` = 'R2' 
		     OR `financial_ledger_transcations`.`RP_TYPE` = 'P2') 
		AND (`financial_ledger_transcations`.`COMP_ID` != 1 
		and `financial_ledger_transcations`.`COMP_ID` != 2) 
		AND `CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!' $condition
			union
			SELECT `VOUCHER_NO`, 
			(CASE WHEN `RP_TYPE`='R2' 
			      THEN 'Receipt' 
				  WHEN `RP_TYPE`='P2' 
				  THEN 'Payment' 
				  WHEN `RP_TYPE`='C1' 
				  THEN 'Contra' ELSE 'notfound' END )as VOUCHER_TYPE, 
				  `RECEIPT_FAVOURING_NAME`, 
				  IF(`RP_TYPE`='R2', `FLT_DR`, FLT_CR) as AMT, 
				  `CHEQUE_NO`, 
				  `CHEQUE_DATE`, 
				  `financial_ledger_transcations`.`BANK_NAME` as `BANK_NAME`, 
				  `BRANCH_NAME`, 
				  `PAYMENT_STATUS`, 
				  `RECEIPT_ID`, 
				  `FLT_DEPOSIT_PAYMENT_DATE` 
				  FROM `financial_ledger_transcations` 
				  JOIN `finacial_group_ledger_heads` ON 
				  `financial_ledger_transcations`.`FGLH_ID` = `finacial_group_ledger_heads`.`FGLH_ID` 
				  WHERE `finacial_group_ledger_heads`.FGLH_PARENT_ID = 9 
				  and `PAYMENT_STATUS` = 'Pending' 
				  and TRANSACTION_STATUS != 'Cancelled' 
				  AND (`financial_ledger_transcations`.`COMP_ID` != 1 
				  and `financial_ledger_transcations`.`COMP_ID` != 2)  
				  AND `financial_ledger_transcations`.`RP_TYPE` = 'C1' 
				  AND `CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!' $condition
			 ORDER BY STR_TO_DATE(FLT_DEPOSIT_PAYMENT_DATE, '%d-%m-%Y') LIMIT $start, $num";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}	
	}

	//TRUST EVENT
	function get_trust_all_chequeRemmittance($fromDate,$toDate,$num = 10, $start = 0, $condition = array(),$cheque_number = '', $order_by_field = '', $order_by_type = "desc") {
      ////////////////////////////////Temple like code by adithya start/////////////////////////////////////////////////////
               $sql = "SELECT
               `TEUC_ID`,
               `TEUC_BY_ID`,
               `TEUC_BY_NAME`,
               `TEUC_EOD_DATE`,
               `TET_RECEIPT_NAME`,
               `TEUC_CHEQUE`,
               `TEUC_CHEQUE_NO`,
               `TEUC_CHEQUE_DATE`,
               `TEUC_BANK_NAME`,
               `TEUC_BRANCH_NAME`,
               `TEUC_IS_DEPOSITED`,
               `TEUC_LEDGER_ID`,
               `TEUC_DATE_TIME`,
               `TEUC_DATE`,
               `TEUC_EOD_DATE` AS EOD,
			   trust_event_receipt.TET_RECEIPT_NO,
               trust_event_user_collection.TEUC_RECEIPT_ID,
               TET_RECEIPT_CATEGORY_TYPE,
               trust_event_receipt.TET_RECEIPT_CATEGORY_ID
               FROM 
               trust_event_user_collection
               JOIN 
               trust_event_receipt ON trust_event_user_collection.TEUC_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID 
               JOIN 
               trust_event_receipt_category ON trust_event_receipt.TET_RECEIPT_CATEGORY_ID = trust_event_receipt_category.TET_RECEIPT_CATEGORY_ID 
               WHERE 
               (`TEUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') 
               AND TEUC_IS_DEPOSITED != 1 
               ORDER BY 
               TEUC_ID ASC 
               LIMIT 
               ".$start.",".$num;
               
               $query = $this->db->query($sql);

               if ($query->num_rows() > 0) {
                  return $query->result();
               } else {
                  return array();
               }
           // ///////////////////////////Temple like code by adithya end//////////////////////////////////////////////////////////
		
		
		// $this->db->from($this->trustChequeRemmittance); 
		// if ($condition) {
		// 	$this->db->where($condition);
		// }
		// if($cheque_number !='' || $cheque_number == 0){
		// 	$this->db->like('CHEQUE_NO',$cheque_number, 'after');
		// }
		
		// if ($order_by_field) {
		// 	$this->db->order_by($order_by_field, $order_by_type);
		// 	$this->db->order_by("PAYMENT_DATE_TIME", "desc");
		// }
		
		// $this->db->limit($num, $start);		
		
		// $query = $this->db->get();
		// if ($query->num_rows() > 0) {
		// 	return $query->result();
		// } else {
		// 	return array();
		// }
	}

	//EVENT COUNT
	function get_all_chequeRemmittanceCount($cheque_number = '',$voucherType='') {
		if ($voucherType != '') {
			$condition = "AND RP_TYPE = '$voucherType'";
		}else{
			$condition = "";
		}
		$sql="SELECT `VOUCHER_NO`, (CASE WHEN `RP_TYPE`='R2' THEN 'Receipt' WHEN `RP_TYPE`='P2' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' ELSE 'notfound' END )as VOUCHER_TYPE, `RECEIPT_FAVOURING_NAME`, IF(`RP_TYPE`='R2', `FLT_DR`, FLT_CR) as AMT, `CHEQUE_NO`, `CHEQUE_DATE`, `financial_ledger_transcations`.`BANK_NAME` as `BANK_NAME`, `BRANCH_NAME`, `PAYMENT_STATUS`, `RECEIPT_ID`, `FLT_DEPOSIT_PAYMENT_DATE` FROM `financial_ledger_transcations` JOIN `finacial_group_ledger_heads` ON `financial_ledger_transcations`.`FGLH_ID` = `finacial_group_ledger_heads`.`FGLH_ID` WHERE `PAYMENT_STATUS` = 'Pending' and TRANSACTION_STATUS != 'Cancelled' AND `finacial_group_ledger_heads`.FGLH_PARENT_ID = 9 AND (`financial_ledger_transcations`.`RP_TYPE` = 'R2' OR `financial_ledger_transcations`.`RP_TYPE` = 'P2') AND (`financial_ledger_transcations`.`COMP_ID` != 1 and `financial_ledger_transcations`.`COMP_ID` != 2)  AND `CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!' $condition

			union

			SELECT `VOUCHER_NO`, (CASE WHEN `RP_TYPE`='R2' THEN 'Receipt' WHEN `RP_TYPE`='P2' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' ELSE 'notfound' END )as VOUCHER_TYPE, `RECEIPT_FAVOURING_NAME`, IF(`RP_TYPE`='R2', `FLT_DR`, FLT_CR) as AMT, `CHEQUE_NO`, `CHEQUE_DATE`, `financial_ledger_transcations`.`BANK_NAME` as `BANK_NAME`, `BRANCH_NAME`, `PAYMENT_STATUS`, `RECEIPT_ID`, `FLT_DEPOSIT_PAYMENT_DATE` FROM `financial_ledger_transcations` JOIN `finacial_group_ledger_heads` ON `financial_ledger_transcations`.`FGLH_ID` = `finacial_group_ledger_heads`.`FGLH_ID` WHERE `finacial_group_ledger_heads`.FGLH_PARENT_ID = 9 and `PAYMENT_STATUS` = 'Pending' and TRANSACTION_STATUS != 'Cancelled' AND (`financial_ledger_transcations`.`COMP_ID` != 1 and `financial_ledger_transcations`.`COMP_ID` != 2)  AND `financial_ledger_transcations`.`RP_TYPE` = 'C1' AND `CHEQUE_NO` LIKE '$cheque_number%' ESCAPE '!' $condition
			 ORDER BY STR_TO_DATE(FLT_DEPOSIT_PAYMENT_DATE, '%d-%m-%Y') ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return $query->num_rows();
		}
	}
	
	//TRUST EVENT COUNT
	function get_trust_all_chequeRemmittanceCount($condition = array(),$cheque_number = '', $order_by_field = '', $order_by_type = "desc") {
		$this->db->from($this->trustChequeRemmittance);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if($cheque_number !='' || $cheque_number == 0){
			$this->db->like('CHEQUE_NO',$cheque_number, 'after');
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->order_by("PAYMENT_DATE_TIME", "desc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return $query->num_rows();
		}
	}

	//FOR DISPLAY RIGHT
	function get_all_field_rights($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Rights);
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

	//FOR DISPLAY GROUP RIGHTS
	function get_all_field_group_rights($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Group_Rights);
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

	//GET LATEST ADDED GROUP
	function get_group_latest($condition = array()) {
		if ($condition) {
			$this->db->where($condition);
		}
		
		$this->db->order_by('GROUP_ID', 'desc');
		
		$this->db->limit(1);
		$groups = $this->db->get('USER_GROUPS')->result();
		return $groups;
	}

	//GET INSERT RIGHTS
	function get_insert_rights($data=array()) {
		$this->db->insert($this->table_Group_Rights,$data);
		return $this->db->insert_id();
	}

	//GET INSERT TRUST RIGHTS
	function get_insert_trust_rights($data=array()) {
		$this->db->insert($this->table_Group_Trust_Rights,$data);
		return $this->db->insert_id();
	}

	//FOR UPDATE RIGHTS
	function get_update_rights($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		if($this->db->update($this->table_Group_Rights,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR DELETE RIGHTS
	function get_delete_rights($condition=array()) {
		$this->db->where($condition);
		$this->db->delete($this->table_Group_Rights);
	}

	//FOR DELETE TRUST RIGHTS
	function get_delete_trust_rights($condition=array()) {
		$this->db->where($condition);
		$this->db->delete($this->table_Group_Trust_Rights);
	}

	//FOR GETTING GROUPRIGHTS AVAILABLE
	function get_groupright_available($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Group_Rights);
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
			return 0;
		}
	}

	//FOR GETTING GROUPTRUSTRIGHTS AVAILABLE
	function get_grouptrustright_available($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Group_Trust_Rights);
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
			return 0;
		}
	}

	//FOR GETTING GROUP MENU AVAILABLE
	function get_group_menu_right_available($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Group_Menu);
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
			return 0;
		}
	}

	//FOR GETTING GROUP TRSUT MENU AVAILABLE
	function get_group_trust_menu_right_available($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Group_Trust_Menu);
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
			return 0;
		}
	}

	//GET INSERT RIGHTS
	function get_insert_menu_rights($data=array()) {
		$this->db->insert($this->table_Group_Menu,$data);
		return $this->db->insert_id();
	}

	//GET INSERT TRUST RIGHTS
	function get_insert_menu_trust_rights($data=array()) {
		$this->db->insert($this->table_Group_Trust_Menu,$data);
		return $this->db->insert_id();
	}

	//FOR DELETE TRUST RIGHTS
	function get_delete_menu_trust_rights($condition=array()) {
		$this->db->where($condition);
		$this->db->delete($this->table_Group_Trust_Menu);
	}

	//FOR DELETE RIGHTS
	function get_delete_menu_rights($condition=array()) {
		$this->db->where($condition);
		$this->db->delete($this->table_Group_Menu);
	}

	//FOR UPDATE TRUST RIGHTS
	function get_update_menu_trust_rights($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		if($this->db->update($this->table_Group_Trust_Menu,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR UPDATE RIGHTS
	function get_update_menu_rights($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		if($this->db->update($this->table_Group_Menu,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR UPDATE TRUST RIGHTS
	function get_update_menu_trust_rights_history($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		if($this->db->update($this->table_Group_Trust_Menu_History,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR UPDATE RIGHTS
	function get_update_menu_rights_history($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		if($this->db->update($this->table_Group_Menu_History,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//GET INSERT MENU TRUST RIGHTS HISTORY
	function get_insert_menu_trust_rights_history($data=array()) {
		$this->db->insert($this->table_Group_Trust_Menu_History,$data);
		return $this->db->insert_id();
	}

	//GET INSERT MENU RIGHTS HISTORY
	function get_insert_menu_rights_history($data=array()) {
		$this->db->insert($this->table_Group_Menu_History,$data);
		return $this->db->insert_id();
	}

	//GET ALL MENU TRUST RIGHTS HISTORY
	function get_all_field_trust_history_latest($condition = array(), $order_by_field = 'GTMH_ID', $order_by_type = "desc") {
		$this->db->from($this->table_Group_Trust_Menu_History);
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
			return "";
		}
	}

	//GET ALL MENU RIGHTS HISTORY
	function get_all_field_history_latest($condition = array(), $order_by_field = 'GMH_ID', $order_by_type = "desc") {
		$this->db->from($this->table_Group_Menu_History);
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
			return "";
		}
	}

	//DISPLAY GROUP_TRUST_RIGHTS
	function get_group_trust_rights_data($condition = array()) {
		if ($condition) {
			$this->db->where($condition);
		}
		$groups = $this->db->get('USER_GROUPS')->result();
		foreach ($groups as &$row) {
			//RIGHTS DISPLAY
			$this->db->join('USER_RIGHTS', 'GROUP_TRUST_RIGHTS.TR_ID = USER_RIGHTS.R_ID');
			$group_id = $row->GROUP_ID;
			$condition = array('GROUP_ID' => $group_id);
			$this->db->where($condition);
			$this->db->from($this->table_Group_Trust_Rights);
			$query = $this->db->get();
			$rname = "";
			$rId = "";
			if ($query->num_rows() > 1) {
				$queryOne = $query->result();
				for($i = 0; $i < $query->num_rows(); $i++) {
					if($i == 0) {
						$rname = $queryOne[$i]->R_NAME;
						$rId = $queryOne[$i]->GTR_ID;
					} else {
						$rname .= ", ".$queryOne[$i]->R_NAME;
						$rId .= ", ".$queryOne[$i]->GTR_ID;
					}
				}
			} else {
				@$rname =  $query->row()->R_NAME;
				@$rId = $query->row()->GTR_ID;
			}
			$row->R_NAME = $rname;
			$row->GTR_ID = $rId;
			
			//TRUST PAGES DISPLAY
			$this->db->join('TRUST_PAGES', 'GROUP_TRUST_MENU.TP_ID = TRUST_PAGES.TP_ID');
			$conditionOne = array('GROUP_ID' => $group_id, 'STATUS' => 1);
			$this->db->where($conditionOne);
			$this->db->order_by("GROUP_TRUST_MENU.TP_ID", "asc");
			$this->db->from($this->table_Group_Trust_Menu);
			$queryTwo = $this->db->get();
			$pname = "";
			$pId = "";
			if ($queryTwo->num_rows() > 1) {
				$queryThree = $queryTwo->result();
				for($i = 0; $i < $queryTwo->num_rows(); $i++) {
					if($i == 0) {
						$pname = $queryThree[$i]->TP_NAME;
						$pId = $queryThree[$i]->GTM_ID;
					} else {
						$pname .= " , ".$queryThree[$i]->TP_NAME;
						$pId .= ", ".$queryThree[$i]->GTM_ID;
					}
				}
			} else {
				@$pname =  $queryTwo->row()->TP_NAME;
				@$pId = $queryTwo->row()->GTM_ID;
			}
			$row->TP_NAME = $pname;
			$row->GTM_ID = $pId;
		}
		
		return $groups;
	}

	//DISPLAY GROUP_RIGHTS
	function get_group_rights_data($condition = array()) {
		if ($condition) {
			$this->db->where($condition);
		}
		$groups = $this->db->get('USER_GROUPS')->result();
		foreach ($groups as &$row) {
			//RIGHTS DISPLAY
			$this->db->join('USER_RIGHTS', 'GROUP_RIGHTS.R_ID = USER_RIGHTS.R_ID');
			$group_id = $row->GROUP_ID;
			$condition = array('GROUP_ID' => $group_id);
			$this->db->where($condition);
			$this->db->from($this->table_Group_Rights);
			$query = $this->db->get();
			$rname = "";
			$rId = "";
			if ($query->num_rows() > 1) {
				$queryOne = $query->result();
				for($i = 0; $i < $query->num_rows(); $i++) {
					if($i == 0) {
						$rname = $queryOne[$i]->R_NAME;
						$rId = $queryOne[$i]->GR_ID;
					} else {
						$rname .= ", ".$queryOne[$i]->R_NAME;
						$rId .= ", ".$queryOne[$i]->GR_ID;
					}
				}
			} else {
				@$rname =  $query->row()->R_NAME;
				@$rId = $query->row()->GR_ID;
			}
			$row->R_NAME = $rname;
			$row->GR_ID = $rId;
			
			//PAGES DISPLAY
			$this->db->join('PAGES', 'GROUP_MENU.P_ID = PAGES.P_ID');
			$conditionOne = array('GROUP_ID' => $group_id, 'STATUS' => 1);
			$this->db->where($conditionOne);
			$this->db->order_by("GROUP_MENU.P_ID", "asc");
			$this->db->from($this->table_Group_Menu);
			$queryTwo = $this->db->get();
			$pname = "";
			$pId = "";
			if ($queryTwo->num_rows() > 1) {
				$queryThree = $queryTwo->result();
				for($i = 0; $i < $queryTwo->num_rows(); $i++) {
					if($i == 0) {
						$pname = $queryThree[$i]->P_NAME;
						$pId = $queryThree[$i]->GM_ID;
					} else {
						$pname .= " , ".$queryThree[$i]->P_NAME;
						$pId .= ", ".$queryThree[$i]->GM_ID;
					}
				}
			} else {
				@$pname =  $queryTwo->row()->P_NAME;
				@$pId = $queryTwo->row()->GM_ID;
			}
			$row->P_NAME = $pname;
			$row->GM_ID = $pId;
		}
		
		return $groups;
	}

	/******USERS ENDS HERE(ADD, EDIT, DISPLAY, DELETE)******/

	/******EVENT SEVA (ADD, EDIT, DISPLAY, DELETE)******/
	//FOR DISPLAY EVENT SEVA 
	function get_all_field_event_seva($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Event_Seva);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('EVENT', 'EVENT_SEVA.ET_ID = EVENT.ET_ID');
		$this->db->join('EVENT_SEVA_PRICE','EVENT_SEVA.ET_SEVA_ID = EVENT_SEVA_PRICE.ET_SEVA_ID');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR DISPLAY EVENT SEVA 
	function get_trust_all_field_event_seva($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Trust_Event_Seva);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('TRUST_EVENT', 'TRUST_EVENT_SEVA.TET_ID = TRUST_EVENT.TET_ID');
		$this->db->join('TRUST_EVENT_SEVA_PRICE', 'TRUST_EVENT_SEVA.TET_SEVA_ID = TRUST_EVENT_SEVA_PRICE.TET_SEVA_ID');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR GETTING LATEST INSERTED EVENT SEVA
	function get_all_field_event_seva_latest($condition = array(), $order_by_field = 'ET_SEVA_ID', $order_by_type = "desc") {
		$this->db->from($this->table_Event_Seva);
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

	//FOR GETTING LATEST INSERTED EVENT SEVA
	function get_trust_all_field_event_seva_latest($condition = array(), $order_by_field = 'TET_SEVA_ID', $order_by_type = "desc") {
		$this->db->from($this->table_Trust_Event_Seva);
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

	//FOR ADD EVENT
	function add_event_seva_modal($data_array=array()) {
		$this->db->insert($this->table_Event_Seva,$data_array);
		return $this->db->insert_id();
	}

	//FOR ADD EVENT
	function add_trust_event_seva_modal($data_array=array()) {
		$this->db->insert($this->table_Trust_Event_Seva,$data_array);
		return $this->db->insert_id();
	}

	//FOR INSERT EVENT HISTORY
	function add_event_history_modal($data_array=array()) {
		$this->db->insert($this->table_Event_History,$data_array);
		return $this->db->insert_id();
	}

	//FOR INSERT EVENT HISTORY
	function add_trust_event_history_modal($data_array=array()) {
		$this->db->insert($this->table_Trust_Event_History,$data_array);
		return $this->db->insert_id();
	}

	//FOR ADD EVENT PRICE
	function add_event_seva_price_modal($data_array=array()) {
		$this->db->insert($this->table_Event_Seva_Price,$data_array);
		return $this->db->insert_id();
	}

	//FOR ADD EVENT PRICE
	function add_trust_event_seva_price_modal($data_array=array()) {
		$this->db->insert($this->table_Trust_Event_Seva_Price,$data_array);
		return $this->db->insert_id();
	}

	//FOR EDIT EVENT SEVA
	function edit_event_seva_modal($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Event_Seva,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR EDIT EVENT SEVA
	function edit_trust_event_seva_modal($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Trust_Event_Seva,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR EDIT EVENT SEVA PRICE
	function edit_event_seva_price_modal($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Event_Seva_Price,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR EDIT EVENT SEVA PRICE
	function edit_trust_event_seva_price_modal($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Trust_Event_Seva_Price,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR DISPLAY LIMITS WITH SEVA YYY
	function get_trust_all_field_limits($condition = array(), $order_by_field = '', $order_by_type = "asc") {

		// COMMENTED THE WHOLE CODE BY ADITHYA BCZ IT WAS GIVING SOME ERROR IN THE OLDER CODE
		// $this->db->select('TET_SL_ID, 
		//                    TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID,
		// 				    TET_IS_SEVA, TET_SEVA_DATE, 
		// 					TET_SEVA_LIMIT, 
		// 					TET_SEVA_COUNTER, 
		// 					TRUST_EVENT_SEVA_LIMIT.DATE_TIME AS ESTDATETIME, 
		// 					TRUST_EVENT_SEVA_LIMIT.DATE AS ESTDATE, 
		// 					TRUST_EVENT_SEVA_LIMIT.USER_ID, 
		// 					TRUST_EVENT_SEVA.TET_SEVA_ID, 
		// 					TET_SEVA_CODE, 
		// 					TET_SEVA_NAME, 
		// 					TRUST_EVENT_SEVA.TET_ID, 
		// 					TET_SEVA_FROM_DATE_TIME, 
		// 					TET_SEVA_TO_DATE_TIME, 
		// 					TET_SEVA_DESC, 
		// 					TRUST_EVENT_SEVA.DATE_TIME, 
		// 					TRUST_EVENT_SEVA.DATE, 
		// 					TRUST_EVENT_SEVA.USER_ID, 
		// 					TET_SEVA_ACTIVE, 
		// 					TET_SEVA_QUANTITY_CHECKER, 
		// 					IS_SEVA, 
		// 					TRUST_EVENT.TET_ID, 
		// 					TET_CODE, 
		// 					TET_NAME, 
		// 					TET_FROM_DATE_TIME, 
		// 					TET_TO_DATE_TIME, 
		// 					TRUST_EVENT.DATE_TIME, 
		// 					TRUST_EVENT.DATE, 
		// 					TRUST_EVENT.USER_ID, 
		// 					TET_ACTIVE,USERS.USER_ID, 
		// 					USER_FULL_NAME, 
		// 					USER_EMAIL, 
		// 					USER_PHONE, 
		// 					USER_ADDRESS, 
		// 					USER_GROUP, 
		// 					CREATION_TIME, 
		// 					CREATED_BY, 
		// 					USER_PASSWORD, 
		// 					USER_LOGIN_NAME, 
		// 					USER_ACTIVE, 
		// 					USER_TYPE');
		// $this->db->from($this->table_Trust_Event_Seva_Limit);
		
		 $dtFuncStr = $this->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1]; 

		$fromDateReversed = DateTime::createFromFormat('Y-m-d', $fromDate)->format('d-m-Y');
        $toDateReversed = DateTime::createFromFormat('Y-m-d', $toDate)->format('d-m-Y');
		
		// // $fromDate = date('Y')."-04-01";
		// // $toDate = (date('Y')+1)."-03-31"; 
		
		// if ($condition) {
		// 	$this->db->where($condition);
		// 	$this->db->where("STR_TO_DATE(TRUST_EVENT_SEVA_LIMIT.DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromDateReversed', '%d-%m-%Y') AND STR_TO_DATE('$toDateReversed', '%d-%m-%Y')");
		// }
		
		// if ($order_by_field != '') {
		// 	$this->db->order_by($order_by_field, $order_by_type);
		// 	$this->db->order_by('TET_SEVA_DATE', 'asc');
		// } else 
		// 	$this->db->order_by('TET_SEVA_DATE', 'desc');
		
		// $this->db->join('TRUST_EVENT_SEVA', 'TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID = TRUST_EVENT_SEVA.TET_SEVA_ID');
		// $this->db->join('TRUST_EVENT', 'TRUST_EVENT_SEVA.TET_ID = TRUST_EVENT.TET_ID');
		// $this->db->join('USERS', 'TRUST_EVENT_SEVA_LIMIT.USER_ID = USERS.USER_ID');
	 $sql = "SELECT
			TET_SL_ID, 
			TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID,
			TET_IS_SEVA, 
			TET_SEVA_DATE, 
			TET_SEVA_LIMIT, 
			TET_SEVA_COUNTER, 
			TRUST_EVENT_SEVA_LIMIT.DATE_TIME AS ESTDATETIME, 
			TRUST_EVENT_SEVA_LIMIT.DATE AS ESTDATE, 
			TRUST_EVENT_SEVA_LIMIT.USER_ID, 
			TRUST_EVENT_SEVA.TET_SEVA_ID, 
			TET_SEVA_CODE, 
			TET_SEVA_NAME, 
			TRUST_EVENT_SEVA.TET_ID, 
			TET_SEVA_FROM_DATE_TIME, 
			TET_SEVA_TO_DATE_TIME, 
			TET_SEVA_DESC, 
			TRUST_EVENT_SEVA.DATE_TIME, 
			TRUST_EVENT_SEVA.DATE, 
			TRUST_EVENT_SEVA.USER_ID, 
			TET_SEVA_ACTIVE, 
			TET_SEVA_QUANTITY_CHECKER, 
			IS_SEVA, 
			TRUST_EVENT.TET_ID, 
			TET_CODE, 
			TET_NAME, 
			TET_FROM_DATE_TIME, 
			TET_TO_DATE_TIME, 
			TRUST_EVENT.DATE_TIME, 
			TRUST_EVENT.DATE, 
			TRUST_EVENT.USER_ID, 
			TET_ACTIVE,
			USERS.USER_ID, 
			USER_FULL_NAME, 
			USER_EMAIL, 
			USER_PHONE, 
			USER_ADDRESS, 
			USER_GROUP, 
			CREATION_TIME, 
			CREATED_BY, 
			USER_PASSWORD, 
			USER_LOGIN_NAME, 
			USER_ACTIVE, 
			USER_TYPE
		FROM 
			TRUST_EVENT_SEVA_LIMIT
		JOIN 
			TRUST_EVENT_SEVA ON TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID = TRUST_EVENT_SEVA.TET_SEVA_ID
		JOIN 
			TRUST_EVENT ON TRUST_EVENT_SEVA.TET_ID = TRUST_EVENT.TET_ID
		JOIN 
			USERS ON TRUST_EVENT_SEVA_LIMIT.USER_ID = USERS.USER_ID
		WHERE 
			STR_TO_DATE(TRUST_EVENT_SEVA_LIMIT.DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromDateReversed', '%d-%m-%Y') AND STR_TO_DATE('$toDateReversed', '%d-%m-%Y') 
			AND TRUST_EVENT_SEVA.TET_SEVA_ACTIVE = 1
		ORDER BY 
			TET_SEVA_DATE DESC";


// echo $this->db->query($sql);
// Your existing code
     $query = $this->db->query($sql);		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR DISPLAY LIMITS WITH SEVA adithya
	function get_all_field_limits($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		// $this->db->select('ET_SL_ID, 
		//                    EVENT_SEVA_LIMIT.ET_SEVA_ID, 
		// 				   ET_IS_SEVA, 
		// 				   ET_SEVA_DATE, 
		// 				   ET_SEVA_LIMIT, 
		// 				   ET_SEVA_COUNTER, 
		// 				   EVENT_SEVA_LIMIT.DATE_TIME AS ESTDATETIME, 
		// 				   EVENT_SEVA_LIMIT.DATE AS ESTDATE, 
		// 				   EVENT_SEVA_LIMIT.USER_ID, 
		// 				   EVENT_SEVA.ET_SEVA_ID, 
		// 				   ET_SEVA_CODE, ET_SEVA_NAME, 
		// 				   EVENT_SEVA.ET_ID, 
		// 				   ET_SEVA_FROM_DATE_TIME, 
		// 				   ET_SEVA_TO_DATE_TIME, 
		// 				   ET_SEVA_DESC, 
		// 				   EVENT_SEVA.DATE_TIME, 
		// 				   EVENT_SEVA.DATE, 
		// 				   EVENT_SEVA.USER_ID, 
		// 				   ET_SEVA_ACTIVE, 
		// 				   ET_SEVA_QUANTITY_CHECKER, 
		// 				   IS_SEVA, 
		// 				   EVENT.ET_ID, 
		// 				   ET_CODE, ET_NAME, 
		// 				   ET_FROM_DATE_TIME, 
		// 				   ET_TO_DATE_TIME, 
		// 				   EVENT.DATE_TIME, 
		// 				   EVENT.DATE, 
		// 				   EVENT.USER_ID, 
		// 				   ET_ACTIVE,
		// 				   USERS.USER_ID, 
		// 				   USER_FULL_NAME, 
		// 				   USER_EMAIL, 
		// 				   USER_PHONE, 
		// 				   USER_ADDRESS, 
		// 				   USER_GROUP, 
		// 				   CREATION_TIME, 
		// 				   CREATED_BY, 
		// 				   USER_PASSWORD, 
		// 				   USER_LOGIN_NAME, 
		// 				   USER_ACTIVE, 
		// 				   USER_TYPE');
		// $this->db->from($this->table_Event_Seva_Limit);
		
		 $dtFuncStr = $this->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1]; 
		// $fromDate = date('Y')."-04-01";
		// $toDate = (date('Y')+1)."-03-31";
		$fromDateReversed = DateTime::createFromFormat('Y-m-d', $fromDate)->format('d-m-Y');
        $toDateReversed = DateTime::createFromFormat('Y-m-d', $toDate)->format('d-m-Y');

		// if ($condition) {
		// 	$this->db->where($condition);
		// 	$this->db->where("STR_TO_DATE(EVENT_SEVA_LIMIT.DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."'");
		// }
		
		// if ($order_by_field != '') {
		// 	$this->db->order_by($order_by_field, $order_by_type);
		// 	$this->db->order_by('ET_SEVA_DATE', 'asc');
		// } else 
		// 	$this->db->order_by('ET_SEVA_DATE', 'desc');
		
		// $this->db->join('EVENT_SEVA', 'EVENT_SEVA_LIMIT.ET_SEVA_ID = EVENT_SEVA.ET_SEVA_ID');
		// $this->db->join('EVENT', 'EVENT_SEVA.ET_ID = EVENT.ET_ID');
		// $this->db->join('USERS', 'EVENT_SEVA_LIMIT.USER_ID = USERS.USER_ID');


////////////////////////////////////////new code added by adithya start /////////////////////////
$sql = "SELECT
    ET_SL_ID,
    EVENT_SEVA_LIMIT.ET_SEVA_ID,
    ET_IS_SEVA,
    ET_SEVA_DATE,
    ET_SEVA_LIMIT,
    ET_SEVA_COUNTER,
    EVENT_SEVA_LIMIT.DATE_TIME AS ESTDATETIME,
    EVENT_SEVA_LIMIT.DATE AS ESTDATE,
    EVENT_SEVA_LIMIT.USER_ID,
    EVENT_SEVA.ET_SEVA_ID,
    ET_SEVA_CODE,
    ET_SEVA_NAME,
    EVENT_SEVA.ET_ID,
    ET_SEVA_FROM_DATE_TIME,
    ET_SEVA_TO_DATE_TIME,
    ET_SEVA_DESC,
    EVENT_SEVA.DATE_TIME,
    EVENT_SEVA.DATE,
    EVENT_SEVA.USER_ID,
    ET_SEVA_ACTIVE,
    ET_SEVA_QUANTITY_CHECKER,
    IS_SEVA,
    EVENT.ET_ID,
    ET_CODE,
    ET_NAME,
    ET_FROM_DATE_TIME,
    ET_TO_DATE_TIME,
    EVENT.DATE_TIME,
    EVENT.DATE,
    EVENT.USER_ID,
    ET_ACTIVE,
    USERS.USER_ID,
    USER_FULL_NAME,
    USER_EMAIL,
    USER_PHONE,
    USER_ADDRESS,
    USER_GROUP,
    CREATION_TIME,
    CREATED_BY,
    USER_PASSWORD,
    USER_LOGIN_NAME,
    USER_ACTIVE,
    USER_TYPE
FROM
    event_Seva_Limit
JOIN
    EVENT_SEVA ON EVENT_SEVA_LIMIT.ET_SEVA_ID = EVENT_SEVA.ET_SEVA_ID
JOIN
    EVENT ON EVENT_SEVA.ET_ID = EVENT.ET_ID
JOIN
    USERS ON EVENT_SEVA_LIMIT.USER_ID = USERS.USER_ID
WHERE
    ET_ACTIVE = 1
    AND STR_TO_DATE(EVENT_SEVA_LIMIT.DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromDate', '%Y-%m-%d') AND STR_TO_DATE('$toDate', '%Y-%m-%d')
ORDER BY
    ET_SEVA_DATE DESC, ET_SEVA_DATE ASC";

/////////////////////////////////////// new code added by adithya end /////////////////////////
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR GETTING LADDU SOLD
	function get_laddu_stock_sold($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->select('SUM(ET_SO_QUANTITY) AS SOLD_QTY');
		$this->db->from($this->table_Event_Seva_Offered);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->first_row();
		} else {
			return 0;
		}
	}

	//FOR GETTING LADDU SOLD
	function get_trust_laddu_stock_sold($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$fromDate = date('Y')."-04-01";
		$toDate = (date('Y')+1)."-03-31";

		$this->db->select('SUM(TET_SO_QUANTITY) AS SOLD_QTY');
		$this->db->from($this->table_Trust_Event_Seva_Offered)->where("STR_TO_DATE(TET_SO_DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."'");
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->first_row();
		} else {
			return 0;
		}
	}

	//FOR GETTING LADDU AVAILABLE
	function get_trust_laddu_stock_available($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$fromDate = date('Y')."-04-01";
		$toDate = (date('Y')+1)."-03-31";

		$this->db->select('SUM(TET_SEVA_LIMIT) AS AVA_QTY');
		$this->db->from($this->table_Trust_Event_Seva_Limit)->where("STR_TO_DATE(TRUST_EVENT_SEVA_LIMIT.DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."'");
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->first_row();
		} else {
			return 0;
		}
	}

	//FOR GETTING LADDU AVAILABLE
	function get_laddu_stock_available($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->select('SUM(ET_SEVA_LIMIT) AS AVA_QTY');
		$this->db->from($this->table_Event_Seva_Limit);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->first_row();
		} else {
			return 0;
		}
	}

	//FOR DELETE SEVA STOCK
	function get_delete_seva_stock($condition = array()) {
		$this->db->where($condition);
		$this->db->delete($this->table_Event_Seva_Limit);
	}

	//FOR DELETE SEVA STOCK
	function get_trust_delete_seva_stock($condition = array()) {
		$this->db->where($condition);
		$this->db->delete($this->table_Trust_Event_Seva_Limit);
	}

	//FOR UPDATE SEVA STOCK
	function get_trust_update_seva_stock($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		if($this->db->update($this->table_Trust_Event_Seva_Limit,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR UPDATE SEVA STOCK
	function get_update_seva_stock($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		if($this->db->update($this->table_Event_Seva_Limit,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR GETTING LADDU AVAILABLE
	function get_stock_available($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Event_Seva_Limit);
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
			return 0;
		}
	}

	//FOR GETTING LADDU AVAILABLE
	function get_trust_stock_available($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$fromDate = date('Y')."-04-01";
		$toDate = (date('Y')+1)."-03-31";
		
		$this->db->from($this->table_Trust_Event_Seva_Limit)->where("STR_TO_DATE(TRUST_EVENT_SEVA_LIMIT.DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."'");
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
			return 0;
		}
	}

	//FOR GETTING DATA FROM SEVA OFFERED ON CONDITION
	function get_fields_offered($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		//$this->db->select('Count(*) AS COUNTER');
		$this->db->from($this->table_Event_Seva_Offered);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}

	//FOR GETTING DATA FROM SEVA OFFERED ON CONDITION
	function get_trust_fields_offered($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		//$this->db->select('Count(*) AS COUNTER');
		$this->db->from($this->table_Trust_Event_Seva_Offered);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}

	//FOR DISPLAY LIMITS
	function get_field_limits($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Event_Seva_Limit);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('EVENT_SEVA', 'EVENT_SEVA_LIMIT.ET_SEVA_ID = EVENT_SEVA.ET_SEVA_ID');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->first_row();
		} else {
			return 0;
		}
	}

	//FOR DISPLAY LIMITS
	function get_trust_field_limits($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Trust_Event_Seva_Limit);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('TRUST_EVENT_SEVA', 'TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID = TRUST_EVENT_SEVA.TET_SEVA_ID');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->first_row();
		} else {
			return 0;
		}
	}

	//FOR ADD LIMIT
	function add_limit_modal($data_array=array()) {
		$this->db->insert($this->table_Event_Seva_Limit,$data_array);
		return $this->db->insert_id();
	}

	//FOR ADD LIMIT
	function add_trust_limit_modal($data_array=array()) {
		$this->db->insert($this->table_Trust_Event_Seva_Limit,$data_array);
		return $this->db->insert_id();
	}

	//FOR EDIT LIMIT
	function edit_limit_modal($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Event_Seva_Limit,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR EDIT LIMIT
	function edit_trust_limit_modal($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Trust_Event_Seva_Limit,$data_array)){
			return true;
		} else {
			return false;
		}
	}
	/******EVENT SEVA ENDS HERE(ADD, EDIT, DISPLAY, DELETE)******/

	/******EVENTS (ADD, EDIT, DISPLAY, DELETE)******/
	//FOR DISPLAY EVENTS
	function get_all_field_event($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Event);
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

	//FOR DISPLAY EVENTS
	function get_all_field_event_activate($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Event);
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
			return 0;
		}
	}

	function get_event_receipt_counter($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->select('ET_RECEIPT_COUNTER_ID');
		$this->db->from($this->table_event_receipt_counter);
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
			return 0;
		}
	}

	//FOR EDIT EVENT
	function edit_event_category_modal($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_event_receipt_category,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR EDIT EVENT
	function edit_trust_event_category_modal($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_trust_event_receipt_category,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR ADD EVENT
	function add_event_counter_modal($data_array=array()) {
		$this->db->insert($this->table_event_receipt_counter,$data_array);
		return $this->db->insert_id();
	}

	//FOR ADD EVENT
	function add_trust_event_counter_modal($data_array=array()) {
		$this->db->insert($this->table_trust_event_receipt_counter,$data_array);
		return $this->db->insert_id();
	}

	//FOR ADD EVENT
	function add_event_modal($data_array=array()) {
		$this->db->insert($this->table_Event,$data_array);
		return $this->db->insert_id();
	}

	//FOR TRUST ADD EVENT
	function add_trust_event_modal($data_array=array()) {
		$this->db->insert($this->table_Trust_Event,$data_array);
		return $this->db->insert_id();
	}

	//FOR EDIT EVENT
	function edit_event_modal($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Event,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR COUNTER UPDATE FOR EVENT
	function get_update_receipt_counter($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_event_receipt_counter,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR COUNTER UPDATE FOR TRUST EVENT
	function get_trust_update_receipt_counter($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_trust_event_receipt_counter,$data_array)){
			return true;
		} else {
			return false;
		}
	}
	
	//For Resetting Financial Head COUNTER
	function get_trust_update_financial_head_receipt_counter($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Trust_Financial_Head_Counter,$data_array)){
			return true;
		} else {
			return false;
		}
	}
	
	//FOR GETTING RECEIPT CATEGORY
	function get_all_field_receipt_category($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->distinct();
		$this->db->select('ET_ACTIVE_RECEIPT_COUNTER_ID');
		$this->db->from($this->table_event_receipt_category);
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


	// For Shashwath Export Calendar
	function  getCalendarExcelPDFReport( $dateStart, $dateEnd ){
		$this->db->select();
			$this->db->from('CALENDAR_YEAR_BREAKUP');
			$this->db->where("date_format(STR_TO_DATE(CALENDAR_YEAR_BREAKUP.ENG_DATE,'%d-%m-%Y'),'%Y-%m-%d') <= date_format(STR_TO_DATE('$dateEnd','%d-%m-%Y'),'%Y-%m-%d') and date_format(STR_TO_DATE(CALENDAR_YEAR_BREAKUP.ENG_DATE,'%d-%m-%Y'),'%Y-%m-%d') >= date_format(STR_TO_DATE('$dateStart','%d-%m-%Y'),'%Y-%m-%d')");
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
		    }   	
	}


	/******EVENTS ENDS HERE (ADD, EDIT, DISPLAY, DELETE)******/


	/******DEITY (ADD, EDIT, DISPLAY, DELETE)******/
	//FOR DISPLAY DEITY

	function get_all_field_deity($condition = array(), $order_by_field = '', $order_by_type = "asc") {
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

	function get_all_field_deity_count() {
		$query = $this->db->query('SELECT d.*, (SELECT count(*) FROM deity_seva INNER JOIN deity_seva_price ON deity_seva.SEVA_ID = deity_seva_price.SEVA_ID WHERE deity_seva.DEITY_ID = d.DEITY_ID AND SEVA_PRICE_ACTIVE = 1) AS SEVACOUNT FROM DEITY d WHERE d.DEITY_ACTIVE = 1 ');
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}		
	}

	//FOR EDIT DEITY
	function edit_deity($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR DELETE DEITY
	function delete_deity($condition=array(),$data_array=array(),$id){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR ADD DEITY HISTORY
	function add_deity_history($data_array=array()) {
		$this->db->insert($this->table_History,$data_array);
		return $this->db->insert_id();
	}

	//FOR ADD DEITY
	function add_deity($data_array=array()) {
		$this->db->insert($this->table,$data_array);
		return $this->db->insert_id();
	}
	/******DEITY ENDS HERE (ADD, EDIT, DISPLAY, DELETE)******/

	/******SEVA (ADD, EDIT, DISPLAY, DELETE)******/
	//FOR DISPLAY SEVA
	function get_all_field_seva($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->select()->from($this->table_Seva);
		if ($condition) {
			$this->db->where($condition);
		}
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		$this->db->order_by('SEVA_NAME', 'asc'); 
		$this->db->join('DEITY_SEVA_PRICE','DEITY_SEVA.SEVA_ID = DEITY_SEVA_PRICE.SEVA_ID');
		$this->db->join('DEITY', 'DEITY_SEVA.DEITY_ID = DEITY.DEITY_ID');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR DISPLAY SEVA
	function get_latest_seva($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_Seva);
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->order_by('DEITY_SEVA.SEVA_ID', 'desc'); 
		$this->db->limit(1);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//FOR ADD SEVA
	function add_seva($data_array=array()) {
		$this->db->insert($this->table_Seva,$data_array);
		return $this->db->insert_id();
	}

	//FOR ADD SEVA PRICE
	function add_seva_price($data_array=array()) {
		$this->db->insert($this->table_Seva_Price,$data_array);
		return $this->db->insert_id();
	}

	//FOR EDIT SEVA
	function edit_seva($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Seva,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	//FOR EDIT SEVA PRICE
	function edit_seva_price($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Seva_Price,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//FOR DELETE SEVA
	function delete_seva($condition=array(),$data_array=array(),$id){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Seva,$data_array)){
			return true;
		} else {
			return false;
		}
	}
	/******SEVA ENDS HERE(ADD, EDIT, DISPLAY, DELETE)******/
	function get_period_details($order_by_field = '',$order_by_type = "asc"){
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->select()->from($this->table_Period);
		$rows = $this->db->get();
		
		return $rows->result();
	}

	//festival code start
	function get_festival_details(){
		$this->db->select()->from('shashwath_festival_setting');
		$rows = $this->db->get();	
		return $rows->result();
	}
	//festival code end

	function get_new_start_end_date($colname) {
		$query = $this->db->query("SELECT DATE_FORMAT(DATE_ADD(STR_TO_DATE(".$colname.",'%d-%m-%Y'), INTERVAL 1 YEAR),'%d-%m-%Y') AS TDATE FROM `calendar` ORDER BY CAL_ID DESC LIMIT 1");		
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row->TDATE;
			}
		} else {
			$currMth = date('n');
			if($colname =="CAL_START_DATE") {
				if($currMth >= 1 && $currMth <= 3) {
					$dt='01-04-'.(date('Y')-1) ;
				}
				else if($currMth >= 4 && $currMth <= 12){
					$dt='01-04-'.date('Y') ;
				}
				return $dt;
			}
			else if($colname =="CAL_END_DATE") {
				if($currMth >= 1 && $currMth <= 3) {
					$dt='31-03-'.date('Y') ;
				}
				else if($currMth >= 4 && $currMth <= 12){
					$dt='31-03-'.(date('Y')+1);
				}
				return $dt;
			}
		}
	}

	function get_kanike_details($order_by_field = '',$order_by_type = "asc"){
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->select()->from($this->table_Kanike);
		$rows = $this->db->get();
		
		return $rows->result();
	}

	function addKanikeDetails($data = array()){
			$this->db->insert($this->table_Kanike,$data);
			return $this->db->insert_id();
	}

	//FOR EDIT KANIKE STATUS
	function edit_kanike_status($condition=array(),$data_array=array()){
		if($condition){
			$this->db->where($condition);
		}
		
		if($this->db->update($this->table_Kanike,$data_array)){
			return true;
		} else {
			return false;
		}
	}	

	function updateKanikeDetails($data = array(),$id){
		
			$this->db->where('KS_ID',$id);
			$this->db->update($this->table_Kanike,$data);
	}

	// added this code by  adithya on 8-1-24
	function getCommittee(){
		$this->db->select()->from($this->table_trust_finance_committee);
		$rows = $this->db->get();
		return $rows->result();
	}
	// function getTrustCommittee(){
		
	// }
}
?>