<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Report_modal extends CI_Model{
		//TABLE NAME
		var $table = 'EVENT_RECEIPT';
		var $tableEvent = 'EVENT';
		var $tableEventSeva = 'EVENT_SEVA';
		var $tableEventOffered = 'EVENT_SEVA_OFFERED';
		var $tableUser = "USERS";
		var $tableDeity = 'DEITY';
		var $tableDeityReceipt = 'DEITY_RECEIPT';
		var $tableDeitySeva = 'DEITY_SEVA';
		var $tableDeitySevaOffered = 'DEITY_SEVA_OFFERED';
		var $tableAuctionItem = 'AUCTION_ITEM_LIST';
		var $tableAuction = 'AUCTION_RECEIPT';
		
		public function __Construct() {
			parent::__construct();
			$this->load->database();
		}
		
		function get_total_amount_user_collection_for_jeernodhara_change($condition = array(), $userId, $payMethod) {
			$this->db->select('(SUM(RECEIPT_PRICE ) + SUM(POSTAGE_PRICE)) AS PRICE');
			$this->db->from($this->tableDeityReceipt);
			if ($condition) {
				$this->db->where($condition);
				$this->db->where(array('IS_JEERNODHARA'=>1,'RECEIPT_ACTIVE'=>1));
				if($userId > 0) $this->db->where('RECEIPT_ISSUED_BY_ID',$userId);
				if($payMethod != "All") $this->db->where('RECEIPT_PAYMENT_METHOD',$payMethod);
			}
			
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$this->db->join('USERS','DEITY_RECEIPT.RECEIPT_ISSUED_BY_ID = USERS.USER_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();
			} else {
				return array();
			}
		}
		
		function get_all_users_on_jeernodhara_change($condition=array(), $userId, $order_by_field = '', $order_by_type = "asc") {
			$this->db->distinct();
			$this->db->select('USER_ID, USER_FULL_NAME');
			$this->db->from('users');
			if ($condition) {
				$this->db->where($condition);
				$this->db->where(array('IS_JEERNODHARA'=>1,'RECEIPT_ACTIVE'=>1));
				if($userId > 0) {
					$this->db->where(array('DEITY_RECEIPT.RECEIPT_ISSUED_BY_ID'=>$userId));
				}
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			$this->db->join('DEITY_RECEIPT', 'DEITY_RECEIPT.RECEIPT_ISSUED_BY_ID = USERS.USER_ID');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		function get_all_users_on_jeernodhara($condition=array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->distinct();
			$this->db->select('USER_ID, USER_FULL_NAME');
			$this->db->from('users');
			if ($condition) {
				$this->db->where($condition);
				
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			$this->db->join('DEITY_RECEIPT', 'DEITY_RECEIPT.RECEIPT_ISSUED_BY_ID = USERS.USER_ID');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR JEERNODHARA RECEIPT REPORT
		function get_total_amount_user_collection_for_jeernodhara($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('(SUM(RECEIPT_PRICE ) + SUM(POSTAGE_PRICE)) AS PRICE');
			$this->db->from($this->tableDeityReceipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$this->db->order_by('RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();
			} else {
				return array();
			}
		}
		
		//FOR EVENT RECEIPT REPORT COUNT
		function count_rows_auction_item_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableAuctionItem);
			if($condition){
				$this->db->where($condition);
			}
			
			$query = $this->db->get();
			$row = $query->num_rows();
			return $row;
		}
		
		//FOR EVENT RECEIPT REPORT
		function get_total_amount_payment_mode($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('SUM(AR_BID_PRICE) AS PRICE');
			$this->db->from($this->tableAuction);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('BID_ITEM_LIST', 'AUCTION_RECEIPT.BIL_ID = BID_ITEM_LIST.BIL_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();
			} else {
				return array();
			}
		}
		
		//FOR EVENT RECEIPT REPORT COUNT
		function count_rows_auction_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableAuction);
			if($condition){
				$this->db->where($condition);
			}
			
			$this->db->join('BID_ITEM_LIST', 'AUCTION_RECEIPT.BIL_ID = BID_ITEM_LIST.BIL_ID');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR AUCTION REPORT
		function get_auction_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->tableAuction);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			$this->db->join('BID_ITEM_LIST', 'AUCTION_RECEIPT.BIL_ID = BID_ITEM_LIST.BIL_ID');
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR AUCTION REPORT EXCEL
		function get_auction_report_excel($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableAuction);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			$this->db->join('BID_ITEM_LIST', 'AUCTION_RECEIPT.BIL_ID = BID_ITEM_LIST.BIL_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR AUCTION ITEM REPORT
		function get_all_field_auction_item_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->tableAuctionItem);
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
		
		//FOR AUCTION ITEM REPORT
		function get_auction_item_reports($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableAuctionItem);
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
		
		//FOR DEITY SEVAS REPORT
		function get_all_field_deity_seva_excel1($condition = array(), $order_by_field = '', $order_by_type = "asc", $bookCondition = "",$excludeIncludeCondition= "") {
						
			//BOOKING
			//Joel Sir 19/04/21
			$this->db->select('SO_DEITY_ID');
			$this->db->select('SO_SEVA_ID');
			$this->db->select('SB_NO');
			$this->db->select('SO_DEITY_NAME AS DEITY_NAME');
			$this->db->select('SO_SEVA_NAME');
			$this->db->select('deity_seva_offered.RECEIPT_CATEGORY_ID');
			$this->db->select('COUNT(SO_SEVA_NAME) AS SEVA_QTY');
			$this->db->select('SO_QUANTITY AS SO_SEVA_QTY');
			$this->db->select('SB_NO');
			$this->db->select('SB_DATE');
			$this->db->select('SB_NAME');
			$this->db->select('SB_PHONE');
			$this->db->from('SEVA_BOOKING')
			//Joel Sir 19/04/21
			->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
			$this->db->join('DEITY', 'DEITY_SEVA_OFFERED.SO_DEITY_ID = DEITY.DEITY_ID');
			$this->db->join('deity_seva', 'DEITY_SEVA_OFFERED.SO_SEVA_ID = deity_seva.SEVA_ID');
			
			if($bookCondition) $date = "";
			else $date = date('d-m-Y');
			
			if($date != "")
				$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1));
			
			if($bookCondition){
				$this->db->where($bookCondition);
			}

			if ($excludeIncludeCondition) {
				$this->db->where($excludeIncludeCondition);
			}
			
			//Joel Sir 19/04/21
			$this->db->group_by('SO_DEITY_NAME');
			$this->db->group_by('SO_SEVA_NAME');
			$this->db->group_by('SB_NO');
			$this->db->group_by('SB_NAME');	
			//Joel Sir 19/04/21

			//Joel Sir 21/04/21	
			$this->db->order_by('SO_DEITY_ID', 'ASC');
			$this->db->order_by('SO_SEVA_ID', 'ASC');
			//Joel Sir 21/04/21	
				
			$query = $this->db->get();
			$arr1 = $query->result_array();
			
			return $arr1;
		}
		
		//FOR DEITY SEVAS REPORT
		function get_all_field_deity_seva_excel($condition = array(), $order_by_field = '', $order_by_type = "asc", $bookCondition = "",$excludeIncludeCondition= "") {
			
			$this->db->select('SO_DEITY_ID');
			$this->db->select('SO_SEVA_ID');
			$this->db->select('deity_receipt.RECEIPT_NO');
			$this->db->select('deity_receipt.RECEIPT_DATE');
			$this->db->select('SO_DEITY_NAME AS DEITY_NAME');
			$this->db->select('SO_SEVA_NAME');
			$this->db->select('deity_seva_offered.RECEIPT_CATEGORY_ID');
			$this->db->select('COUNT(SO_SEVA_NAME) AS SEVA_QTY');
			$this->db->select('SO_QUANTITY AS SO_SEVA_QTY');
			$this->db->select('CONCAT(deity_receipt.RECEIPT_NO," (", deity_receipt.RECEIPT_DATE,")") as RECEIPT_NO_DATE');
			$this->db->select('deity_receipt.RECEIPT_NAME');
			$this->db->select('deity_receipt.RECEIPT_PHONE');

			$this->db->from($this->tableDeitySevaOffered);

			if ($condition) {
				$this->db->where($condition);
			}

			if ($excludeIncludeCondition) {
				$this->db->where($excludeIncludeCondition);
			}
			

			$this->db->join('DEITY_RECEIPT', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID');			
			$this->db->join('DEITY', 'DEITY_SEVA_OFFERED.SO_DEITY_ID = DEITY.DEITY_ID');
			$this->db->join('deity_seva', 'DEITY_SEVA_OFFERED.SO_SEVA_ID = deity_seva.SEVA_ID');
			
			$this->db->group_by('SO_DEITY_NAME');
			$this->db->group_by('SO_SEVA_NAME');
			$this->db->group_by('deity_receipt.RECEIPT_NO');
			$this->db->group_by('deity_receipt.RECEIPT_NAME');

			$this->db->order_by('deity.DEITY_ID', 'ASC');
			//Joel Sir 21/04/21
			$this->db->order_by('SO_SEVA_ID', 'ASC');
			//Joel Sir 21/04/21
			
			$query = $this->db->get();
			$arr = $query->result_array();

			return $arr;
		}

		
		function get_all_field_event_sevas_summary_details_period_excel($fromdate, $todate,$Id,$eId) {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT `ET_RECEIPT_NO`,`ET_RECEIPT_NAME`,`ET_RECEIPT_PHONE`,`ET_SO_PRICE`, `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` FROM `EVENT_SEVA_OFFERED` LEFT JOIN `EVENT_RECEIPT` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` LEFT JOIN `EVENT` ON `EVENT_RECEIPT`.`RECEIPT_ET_ID` = `EVENT`.`ET_ID` WHERE `EVENT_SEVA_OFFERED`.`ET_SO_IS_SEVA` = 1 AND STR_TO_DATE(`EVENT_SEVA_OFFERED`.`ET_SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `EVENT_RECEIPT`.`RECEIPT_ET_ID` = '$eId' AND `EVENT`.ET_ACTIVE = 1 AND `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_ID` = '$Id' AND (`EVENT_RECEIPT`.`ET_RECEIPT_ACTIVE` = 1 OR `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = 0)";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		
		
		function get_all_field_event_sevas_summary_details_excel($date,$Id,$eId) {
			$sql = "SELECT `ET_RECEIPT_NO`,`ET_RECEIPT_NAME`,`ET_RECEIPT_PHONE`,`ET_SO_PRICE`, `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` FROM `EVENT_SEVA_OFFERED` LEFT JOIN `EVENT_RECEIPT` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` LEFT JOIN `EVENT` ON `EVENT_RECEIPT`.`RECEIPT_ET_ID` = `EVENT`.`ET_ID` WHERE `EVENT_SEVA_OFFERED`.`ET_SO_IS_SEVA` = 1 AND `EVENT_SEVA_OFFERED`.`ET_SO_DATE` = '$date' AND `EVENT_RECEIPT`.`RECEIPT_ET_ID` = '$eId' AND `EVENT`.ET_ACTIVE = 1 AND `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_ID` = '$Id' AND (`EVENT_RECEIPT`.`ET_RECEIPT_ACTIVE` = 1 OR `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = 0)";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR SEVA DETAILS SUMMARY EXCEL
		function get_all_field_sevas_summary_details_period_excel($fromdate, $todate,$Id,$condition="") {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT SB_ACTIVE, `SB_NO`, `SB_NAME`, `SB_PHONE`, `DEITY_SEVA_OFFERED`.`RECEIPT_ID`, `SO_IS_BOOKING`, `SO_DEITY_ID`, `RECEIPT_NO`, `RECEIPT_NAME`, `RECEIPT_PHONE`, `SO_PRICE` FROM `DEITY_SEVA_OFFERED` LEFT JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` LEFT JOIN `SEVA_BOOKING` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` WHERE `DEITY_SEVA_OFFERED`.`SO_IS_SEVA` = 1 AND STR_TO_DATE(`DEITY_SEVA_OFFERED`.`SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `DEITY_SEVA_OFFERED`.`SO_SEVA_ID` = '$Id'  AND (`DEITY_RECEIPT`.`RECEIPT_ACTIVE` = 1 OR `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = 0) $condition";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR SEVA DETAILS SUMMARY EXCEL
		function get_all_field_sevas_summary_details_excel($date,$Id,$condition="") {
			$sql = "SELECT SB_ACTIVE, `SB_NO`, `SB_NAME`, `SB_PHONE`, `DEITY_SEVA_OFFERED`.`RECEIPT_ID`, `SO_IS_BOOKING`, `SO_DEITY_ID`, `RECEIPT_NO`, `RECEIPT_NAME`, `RECEIPT_PHONE`, `SO_PRICE` FROM `DEITY_SEVA_OFFERED` LEFT JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` LEFT JOIN `SEVA_BOOKING` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` WHERE `DEITY_SEVA_OFFERED`.`SO_IS_SEVA` = 1 AND `DEITY_SEVA_OFFERED`.`SO_DATE` = '$date' AND `DEITY_SEVA_OFFERED`.`SO_SEVA_ID` = '$Id'  AND (`DEITY_RECEIPT`.`RECEIPT_ACTIVE` = 1 OR `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = 0) $condition";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR SEVA DETAILS SUMMARY
		function get_all_field_sevas_summary_details_period($fromdate, $todate,$Id,$num = 10, $start = 0,$condition="") {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT SB_ACTIVE, `SB_NO`, `SB_NAME`, `SB_PHONE`, `DEITY_SEVA_OFFERED`.`RECEIPT_ID`, `SO_IS_BOOKING`, `SO_DEITY_ID`, `RECEIPT_NO`, `RECEIPT_NAME`, `RECEIPT_PHONE`, `SO_PRICE`,`DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID`,`DEITY_RECEIPT`.`SS_ID` FROM `DEITY_SEVA_OFFERED` LEFT JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` LEFT JOIN `SEVA_BOOKING` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` WHERE `DEITY_SEVA_OFFERED`.`SO_IS_SEVA` = 1 AND STR_TO_DATE(`DEITY_SEVA_OFFERED`.`SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `DEITY_SEVA_OFFERED`.`SO_SEVA_ID` = '$Id'  AND (`DEITY_RECEIPT`.`RECEIPT_ACTIVE` = 1 OR `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = 0) $condition LIMIT $start,$num";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR EVENT SEVA DETAILS SUMMARY PERIOD
		function get_all_field_event_sevas_summary_details_period($fromdate, $todate,$Id,$num = 10, $start = 0,$eId) {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT `ET_RECEIPT_NO`,`ET_RECEIPT_NAME`,`ET_RECEIPT_PHONE`,`ET_SO_PRICE`, `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` FROM `EVENT_SEVA_OFFERED` LEFT JOIN `EVENT_RECEIPT` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` LEFT JOIN `EVENT` ON `EVENT_RECEIPT`.`RECEIPT_ET_ID` = `EVENT`.`ET_ID` WHERE `EVENT_SEVA_OFFERED`.`ET_SO_IS_SEVA` = 1 AND STR_TO_DATE(`EVENT_SEVA_OFFERED`.`ET_SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `EVENT_RECEIPT`.`RECEIPT_ET_ID` = '$eId' AND `EVENT`.ET_ACTIVE = 1 AND `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_ID` = '$Id' AND (`EVENT_RECEIPT`.`ET_RECEIPT_ACTIVE` = 1 OR `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = 0) LIMIT $start,$num";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR SEVA DETAILS SUMMARY
		function get_all_field_sevas_summary_details($date,$Id,$num = 10, $start = 0,$condition="") {
			$sql = "SELECT SB_ACTIVE, `SB_NO`, `SB_NAME`, `SB_PHONE`, `DEITY_SEVA_OFFERED`.`RECEIPT_ID`, `SO_IS_BOOKING`, `SO_DEITY_ID`, `RECEIPT_NO`, `RECEIPT_NAME`, `RECEIPT_PHONE`, `SO_PRICE`,`DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID`,`DEITY_RECEIPT`.`SS_ID` FROM `DEITY_SEVA_OFFERED` LEFT JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` LEFT JOIN `SEVA_BOOKING` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` WHERE `DEITY_SEVA_OFFERED`.`SO_IS_SEVA` = 1 AND `DEITY_SEVA_OFFERED`.`SO_DATE` = '$date' AND `DEITY_SEVA_OFFERED`.`SO_SEVA_ID` = '$Id'  AND (`DEITY_RECEIPT`.`RECEIPT_ACTIVE` = 1 OR `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = 0) $condition LIMIT $start,$num";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR EVENT SEVA DETAILS SUMMARY
		function get_all_field_event_sevas_summary_details($date,$Id,$num = 10, $start = 0,$eId) {
			$sql = "SELECT `ET_RECEIPT_NO`,`ET_RECEIPT_NAME`,`ET_RECEIPT_PHONE`,`ET_SO_PRICE`, `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` FROM `EVENT_SEVA_OFFERED` LEFT JOIN `EVENT_RECEIPT` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` LEFT JOIN `EVENT` ON `EVENT_RECEIPT`.`RECEIPT_ET_ID` = `EVENT`.`ET_ID` WHERE `EVENT_SEVA_OFFERED`.`ET_SO_IS_SEVA` = 1 AND `EVENT_SEVA_OFFERED`.`ET_SO_DATE` = '$date' AND `EVENT_RECEIPT`.`RECEIPT_ET_ID` = '$eId' AND `EVENT`.ET_ACTIVE = 1 AND `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_ID` = '$Id' AND (`EVENT_RECEIPT`.`ET_RECEIPT_ACTIVE` = 1 OR `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = 0) LIMIT $start,$num";	
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR SEVA DETAILS SUMMARY
		function count_sevas_summary_details_period($fromdate, $todate,$Id,$condition="") {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT SB_ACTIVE, `RECEIPT_NO`, `RECEIPT_NAME`, `RECEIPT_PHONE`, `SO_PRICE` FROM `DEITY_SEVA_OFFERED` LEFT JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` LEFT JOIN `SEVA_BOOKING` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` WHERE `DEITY_SEVA_OFFERED`.`SO_IS_SEVA` = 1 AND STR_TO_DATE(`DEITY_SEVA_OFFERED`.`SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `DEITY_SEVA_OFFERED`.`SO_SEVA_ID` = '$Id'  AND (`DEITY_RECEIPT`.`RECEIPT_ACTIVE` = 1 OR `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = 0) $condition";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//FOR EVENT SEVA DETAILS SUMMARY COUNT PERIOD
		function count_event_sevas_summary_details_period($fromdate, $todate,$Id,$eId) {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT `ET_RECEIPT_NO`,`ET_RECEIPT_NAME`,`ET_RECEIPT_PHONE`,`ET_SO_PRICE`, `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` FROM `EVENT_SEVA_OFFERED` LEFT JOIN `EVENT_RECEIPT` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` LEFT JOIN `EVENT` ON `EVENT_RECEIPT`.`RECEIPT_ET_ID` = `EVENT`.`ET_ID` WHERE `EVENT_SEVA_OFFERED`.`ET_SO_IS_SEVA` = 1 AND STR_TO_DATE(`EVENT_SEVA_OFFERED`.`ET_SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `EVENT_RECEIPT`.`RECEIPT_ET_ID` = '$eId' AND `EVENT`.ET_ACTIVE = 1 AND `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_ID` = '$Id' AND (`EVENT_RECEIPT`.`ET_RECEIPT_ACTIVE` = 1 OR `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = 0)";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//FOR SEVA DETAILS SUMMARY COUNT
		function count_sevas_summary_details($date,$Id,$condition="") {
			$sql = "SELECT SB_ACTIVE, `RECEIPT_NO`, `RECEIPT_NAME`, `RECEIPT_PHONE`, `SO_PRICE` FROM `DEITY_SEVA_OFFERED` LEFT JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` LEFT JOIN `SEVA_BOOKING` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` WHERE `DEITY_SEVA_OFFERED`.`SO_IS_SEVA` = 1 AND `DEITY_SEVA_OFFERED`.`SO_DATE` = '$date' AND `DEITY_SEVA_OFFERED`.`SO_SEVA_ID` = '$Id'  AND (`DEITY_RECEIPT`.`RECEIPT_ACTIVE` = 1 OR `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = 0) $condition";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//FOR EVENT SEVA DETAILS SUMMARY COUNT
		function count_event_sevas_summary_details($date,$Id,$eId) {
			$sql = "SELECT `ET_RECEIPT_NO`,`ET_RECEIPT_NAME`,`ET_RECEIPT_PHONE`,`ET_SO_PRICE`, `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` FROM `EVENT_SEVA_OFFERED` LEFT JOIN `EVENT_RECEIPT` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` LEFT JOIN `EVENT` ON `EVENT_RECEIPT`.`RECEIPT_ET_ID` = `EVENT`.`ET_ID` WHERE `EVENT_SEVA_OFFERED`.`ET_SO_IS_SEVA` = 1 AND `EVENT_SEVA_OFFERED`.`ET_SO_DATE` = '$date' AND `EVENT_RECEIPT`.`RECEIPT_ET_ID` = '$eId' AND `EVENT`.ET_ACTIVE = 1 AND `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_ID` = '$Id' AND (`EVENT_RECEIPT`.`ET_RECEIPT_ACTIVE` = 1 OR `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = 0)";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//FOR SEVA DETAILS SUMMARY PERIOD
		function get_all_field_sevas_summary_report_period($fromdate, $todate,$Id,$condition="") {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT SB_ACTIVE, `SO_DEITY_ID`, `SO_DEITY_NAME`, `SO_SEVA_ID`, `SO_SEVA_NAME`, count(SO_DEITY_ID) AS QTY, SUM(SO_PRICE) AS AMOUNT FROM `DEITY_SEVA_OFFERED` LEFT JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` LEFT JOIN `SEVA_BOOKING` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` WHERE `DEITY_SEVA_OFFERED`.`SO_IS_SEVA` = 1 AND STR_TO_DATE(`DEITY_SEVA_OFFERED`.`SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `DEITY_SEVA_OFFERED`.`SO_DEITY_ID` = $Id AND (`DEITY_RECEIPT`.`RECEIPT_ACTIVE` = 1 OR `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = 0) $condition GROUP BY `DEITY_SEVA_OFFERED`.`SO_SEVA_ID`";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
	
		//FOR SEVAS DETAILS SUMMARY 
		function get_all_field_sevas_summary($date,$Id,$condition="") {
			$sql = "SELECT SB_ACTIVE, `SO_DEITY_NAME`, `SO_SEVA_ID`, `SO_SEVA_NAME`, count(SO_DEITY_ID) AS QTY, SUM(SO_PRICE) AS AMOUNT FROM `DEITY_SEVA_OFFERED` LEFT JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` LEFT JOIN `SEVA_BOOKING` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` WHERE `DEITY_SEVA_OFFERED`.`SO_IS_SEVA` = 1 AND `DEITY_SEVA_OFFERED`.`SO_DATE` = '$date' AND `DEITY_SEVA_OFFERED`.`SO_DEITY_ID` = $Id AND (`DEITY_RECEIPT`.`RECEIPT_ACTIVE` = 1 OR `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = 0) $condition GROUP BY `DEITY_SEVA_OFFERED`.`SO_SEVA_ID`";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR EVENT SEVA DETAILS SUMMARY
		function get_all_field_event_sevas_summary($date,$etId) {
			$sql ="SELECT `ET_SO_SEVA_ID`, `ET_SO_SEVA_NAME`, count(ET_SO_SEVA_ID) AS QTY, SUM(ET_SO_PRICE) AS AMOUNT FROM `EVENT_SEVA_OFFERED` LEFT JOIN `EVENT_RECEIPT` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` LEFT JOIN `EVENT` ON `EVENT_RECEIPT`.`RECEIPT_ET_ID` = `EVENT`.`ET_ID` WHERE `EVENT_SEVA_OFFERED`.`ET_SO_IS_SEVA` = 1 AND `EVENT_SEVA_OFFERED`.`ET_SO_DATE` = '$date' AND `EVENT_RECEIPT`.`RECEIPT_ET_ID` = '$etId' AND `EVENT`.ET_ACTIVE = 1 AND (`EVENT_RECEIPT`.`ET_RECEIPT_ACTIVE` = 1 OR `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = 0) GROUP BY `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_ID`";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
				
		//FOR EVENT SEVA DETAILS SUMMARY PERIOD
		function get_all_field_event_sevas_summary_report_period($fromdate, $todate,$eId) {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT `ET_SO_SEVA_ID`, `ET_SO_SEVA_NAME`, count(ET_SO_SEVA_ID) AS QTY, SUM(ET_SO_PRICE) AS AMOUNT FROM `EVENT_SEVA_OFFERED` LEFT JOIN `EVENT_RECEIPT` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` LEFT JOIN `EVENT` ON `EVENT_RECEIPT`.`RECEIPT_ET_ID` = `EVENT`.`ET_ID` WHERE `EVENT_SEVA_OFFERED`.`ET_SO_IS_SEVA` = 1 AND STR_TO_DATE(`EVENT_SEVA_OFFERED`.`ET_SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `EVENT_RECEIPT`.`RECEIPT_ET_ID` = '$eId' AND `EVENT`.ET_ACTIVE = 1 AND (`EVENT_RECEIPT`.`ET_RECEIPT_ACTIVE` = 1 OR `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = 0) GROUP BY `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_ID`";
			$query = $this->db->query($sql);
			return $query->result('array');
		}

		
		//FOR SEVA SUMMARY REPORT PERIOD
		function get_all_field_deity_seva_summary_report_period($fromdate, $todate ,$condition="") {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT SB_ACTIVE, DEITY_NAME, `SO_DEITY_ID`, `SO_DEITY_NAME`, count(SO_DEITY_ID) AS QTY, SUM(SO_PRICE) AS AMOUNT FROM `DEITY_SEVA_OFFERED` LEFT JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` LEFT JOIN `SEVA_BOOKING` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` LEFT JOIN DEITY ON `DEITY_SEVA_OFFERED`.SO_DEITY_ID = DEITY.DEITY_ID WHERE `DEITY_SEVA_OFFERED`.`SO_IS_SEVA` = 1 AND  (`SEVA_BOOKING`.`SB_ACTIVE` IS NULL OR `SEVA_BOOKING`.`SB_ACTIVE` = 1) AND STR_TO_DATE(`DEITY_SEVA_OFFERED`.`SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND (`DEITY_RECEIPT`.`RECEIPT_ACTIVE` = 1 OR `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = 0) $condition GROUP BY `DEITY_SEVA_OFFERED`.`SO_DEITY_ID`";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR SEVA SUMMARY REPORT
		function get_all_field_deity_seva_summary_report($date,$condition="") {
			$sql = "SELECT SB_ACTIVE, DEITY_NAME, `SO_DEITY_ID`, `SO_DEITY_NAME`, count(SO_DEITY_ID) AS QTY, SUM(SO_PRICE) AS AMOUNT FROM `DEITY_SEVA_OFFERED` LEFT JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` LEFT JOIN `SEVA_BOOKING` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` LEFT JOIN DEITY ON `DEITY_SEVA_OFFERED`.SO_DEITY_ID = DEITY.DEITY_ID WHERE `DEITY_SEVA_OFFERED`.`SO_IS_SEVA` = 1 AND (`SEVA_BOOKING`.`SB_ACTIVE` IS NULL OR `SEVA_BOOKING`.`SB_ACTIVE` = 1) AND `DEITY_SEVA_OFFERED`.`SO_DATE` = '$date' AND (`DEITY_RECEIPT`.`RECEIPT_ACTIVE` = 1 OR `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = 0) $condition GROUP BY `DEITY_SEVA_OFFERED`.`SO_DEITY_ID`";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR GETTING SEVA OF BOOKING AND NORMAL
		function get_all_deity_seva_report($conditionOne = array(),$conditionTwo = array()) {
			$this->db->distinct();
			$this->db->select('SO_SEVA_NAME, SO_SEVA_ID, SO_DEITY_ID');
			$this->db->from($this->tableDeitySevaOffered);
			if($conditionOne) {
				$this->db->where($conditionOne);
			}
			
			$this->db->join('DEITY_RECEIPT', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID');
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');            
			
			$query = $this->db->get();
			$arr = $query->result_array();
			
			if($conditionTwo) $date = "";
			else $date = date('d-m-Y');
			
			//BOOKING
			$this->db->distinct()->select('SO_SEVA_NAME, SO_SEVA_ID, SO_DEITY_ID')->from('SEVA_BOOKING')->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
			
			if($date != "")
				$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1));
			
			if($conditionTwo) {
				$this->db->where($conditionTwo);
			}
		
			$this->db->order_by('SEVA_BOOKING.SB_ID', 'desc');			
				
			$query = $this->db->get();
			$arr1 = $query->result_array();
			
			$arr2 = array_merge($arr,$arr1);
			
			$arr2 = array_unique($arr2, SORT_REGULAR);
			
			return $arr2;
		}
		
		//FOR DEITY SEVA REPORT
		function get_all_field_deity_seva_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0, $bookCondition = "") {
			//Joel Sir Changes
			$this->db->select('SO_DEITY_ID');
			$this->db->select('SO_SEVA_ID');
			$this->db->select('deity_receipt.RECEIPT_NO');
			$this->db->select('SO_DEITY_NAME AS DEITY_NAME');
			$this->db->select('SO_SEVA_NAME');
			$this->db->select('deity_seva_offered.RECEIPT_CATEGORY_ID');
			$this->db->select('COUNT(SO_SEVA_NAME) AS SEVA_QTY');
			$this->db->select('SO_QUANTITY AS SO_SEVA_QTY');
			$this->db->select('CONCAT(deity_receipt.RECEIPT_NO," (", deity_receipt.RECEIPT_DATE,")") as RECEIPT_NO_DATE');
			$this->db->select('deity_receipt.RECEIPT_NAME');
			$this->db->select('deity_receipt.RECEIPT_PHONE');
			//Joel Sir Changes
			$this->db->from($this->tableDeitySevaOffered);
			if ($condition) {
				$this->db->where($condition);
			}
			
			$this->db->join('DEITY_RECEIPT', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID');			
			$this->db->join('DEITY', 'DEITY_SEVA_OFFERED.SO_DEITY_ID = DEITY.DEITY_ID');
			
			$this->db->group_by('SO_DEITY_NAME');
			$this->db->group_by('SO_SEVA_NAME');
			$this->db->group_by('deity_receipt.RECEIPT_NO');
			$this->db->group_by('deity_receipt.RECEIPT_NAME');

			$this->db->order_by('deity.DEITY_ID', 'ASC');
			
			$query = $this->db->get();
			$arr = $query->result_array();
			
			if($bookCondition) $date = "";
			else $date = date('d-m-Y');
			
			//BOOKING
			//Joel Sir 19/04/21
			$this->db->select('SO_DEITY_ID');
			$this->db->select('SO_SEVA_ID');
			$this->db->select('SB_NO');
			$this->db->select('SO_DEITY_NAME AS DEITY_NAME');
			$this->db->select('SO_SEVA_NAME');
			$this->db->select('deity_seva_offered.RECEIPT_CATEGORY_ID');
			$this->db->select('COUNT(SO_SEVA_NAME) AS SEVA_QTY');
			$this->db->select('SO_QUANTITY AS SO_SEVA_QTY');
			$this->db->select('SB_NO');
			$this->db->select('SB_DATE');
			$this->db->select('SB_NAME');
			$this->db->select('SB_PHONE');
			$this->db->from('SEVA_BOOKING')
			//Joel Sir 19/04/21
			->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
			$this->db->join('DEITY', 'DEITY_SEVA_OFFERED.SO_DEITY_ID = DEITY.DEITY_ID');
			
			if($date != "")
				$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1));
			
			if($bookCondition){
				$this->db->where($bookCondition);
			}
		
			//Joel Sir 19/04/21
			$this->db->group_by('SO_DEITY_NAME');
			$this->db->group_by('SO_SEVA_NAME');
			$this->db->group_by('SB_NO');
			$this->db->group_by('SB_NAME');
			//Joel Sir 19/04/21
			$this->db->order_by('SEVA_BOOKING.SB_ID', 'desc');
				
			$query = $this->db->get();
			$arr1 = $query->result_array();
			
			$arr2 = array_merge($arr,$arr1);
			//Joel Sir 21/04/21
			
			// usort($arr2, function($a,$b) {
			// 	$dataOne = (int) $a['SO_DEITY_ID'];
			// 	$dataTwo = (int) $b['SO_DEITY_ID'];		
			// 	return $dataOne < $dataTwo ?-1:1;
			// });

			$DeityId = array();
			$SevaId = array();

			for ($i = 0; $i < count($arr2); $i++) {
			  $DeityId[] = $arr2[$i]['SO_DEITY_ID'];
			  $SevaId[] = $arr2[$i]['SO_SEVA_ID'];  
			}

			// now apply sort
			array_multisort($DeityId, SORT_ASC, SORT_NUMERIC, $SevaId, SORT_ASC,$arr2);
			//Joel Sir 21/04/21
			
			$arr3 = [];
			if(($start+10) <= count($arr2)) {
				for($i=$start; $i<($start+10);++$i) {
					$arr3[$i] = $arr2[$i];
				}
			} else {
				for($i=$start; $i<count($arr2);++$i) {
					$arr3[$i] = $arr2[$i];
				}
			}
			return $arr3;
		}
		
		//FOR DEITY SEVA REPORT DETAILS 
		function deity_seva_report_details($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableDeitySevaOffered);
			if($condition){
				$this->db->where($condition);
			}
			$this->db->join('DEITY_RECEIPT', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID');
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//JOEL SIR 1/4
		//FOR DEITY SEVA REPORT ACTUAL COUNT OF SEVAS
		function count_actual_sevas_for_deity_seva_report($condition, $order_by_field = '', $order_by_type = "asc", $bookCondition="") {
			
			$query = $this->db->query("SELECT SUM(d.TOTAL_SEVAS)+SUM(d.TOT_SHASH_SEVAS) AS TOT_SUM_SEVAS FROM (SELECT IF(DEITY_SEVA_OFFERED.RECEIPT_CATEGORY_ID!=7,COUNT(SO_SEVA_NAME),0) AS TOTAL_SEVAS, SUM(SO_QUANTITY) AS TOT_SHASH_SEVAS,DEITY_SEVA_OFFERED.RECEIPT_CATEGORY_ID FROM `DEITY_SEVA_OFFERED` JOIN `DEITY_RECEIPT` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` JOIN `DEITY` ON `DEITY_SEVA_OFFERED`.`SO_DEITY_ID` = `DEITY`.`DEITY_ID` WHERE ".$condition." GROUP BY `SO_DEITY_NAME`, `SO_SEVA_NAME`, `deity_receipt`.`RECEIPT_NO`, `deity_receipt`.`RECEIPT_NAME` ORDER BY `deity`.`DEITY_ID` ASC) d");
			$arrSevaCount = $query->row()->TOT_SUM_SEVAS;
			
			if($bookCondition) $date = "";
			else $date = date('d-m-Y');
			
			$this->db->select()->from('SEVA_BOOKING')
			->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
			$this->db->join('DEITY', 'DEITY_SEVA_OFFERED.SO_DEITY_ID = DEITY.DEITY_ID');
			
			if($date != "")
				$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1));
			
			if($bookCondition){
				$this->db->where($bookCondition);
			}
			
			$query = $this->db->get();
			$arrSevaBookingCnt = count($query->result_array());
			
			return ($arrSevaCount+$arrSevaBookingCnt);
		}

		//FOR DEITY SEVA REPORT COUNT
		function count_rows_deity_seva_report($condition=array(), $order_by_field = '', $order_by_type = "asc", $bookCondition=""){
			
			$this->db->from($this->tableDeitySevaOffered);
			if($condition){
				$this->db->where($condition);
			}
			
			$this->db->join('DEITY_RECEIPT', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID');			
			$this->db->join('DEITY', 'DEITY_SEVA_OFFERED.SO_DEITY_ID = DEITY.DEITY_ID');
			
			$this->db->group_by('SO_DEITY_NAME');
			$this->db->group_by('SO_SEVA_NAME');
			$this->db->group_by('deity_receipt.RECEIPT_NO');
			$this->db->group_by('deity_receipt.RECEIPT_NAME');

			$this->db->order_by('deity.DEITY_ID', 'ASC');	
			
			$query = $this->db->get();
			$arrSevaCount = count($query->result_array());
			
			if($bookCondition) $date = "";
			else $date = date('d-m-Y');
			
			$this->db->select()->from('SEVA_BOOKING')
			->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
			$this->db->join('DEITY', 'DEITY_SEVA_OFFERED.SO_DEITY_ID = DEITY.DEITY_ID');
			
			if($date != "")
				$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1));
			
			if($bookCondition){
				$this->db->where($bookCondition);
			}
			
			$query = $this->db->get();
			$arrSevaBookingCnt = count($query->result_array());
			
			return ($arrSevaBookingCnt+$arrSevaCount);
		}
		
		//FOR GETTING DEITY SEVA
		function get_all_field_deity_seva($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableDeitySeva);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->join('DEITY_SEVA_PRICE', 'DEITY_SEVA.SEVA_ID = DEITY_SEVA_PRICE.SEVA_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		//FOR GETTING SEVAS ON DEITY 
		function get_deity_sevas() {
			$where = array('DEITY_SEVA.SEVA_ACTIVE'=>"1"); 
			$where2 = array('DEITY_SEVA_PRICE.SEVA_PRICE_ACTIVE'=>"1"); 
			
			$this->db->select()->from('DEITY_SEVA')
				->join('DEITY_SEVA_PRICE', 'DEITY_SEVA.SEVA_ID = DEITY_SEVA_PRICE.SEVA_ID')
				->where($where)
				->where($where2)
				->order_by("SEVA_NAME", "asc");
			$query = $this->db->get();
			return $query->result('array');
		}
		
		//FOR DEITY SEVA OFFERED REPORT
		function get_deity_seva_report($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->distinct();
			$this->db->select('SO_SEVA_NAME, SO_SEVA_ID, SO_DEITY_ID');
			$this->db->from($this->tableDeitySevaOffered);
			if ($condition) { 
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->join('DEITY_RECEIPT', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR DEITY RECEIPT EXCEL
		function get_all_field_deity_receipt_excel($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableDeityReceipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$this->db->join('deity_inkind_offered', 'DEITY_RECEIPT.RECEIPT_ID = deity_inkind_offered.RECEIPT_ID','left');
			$this->db->order_by('DEITY_RECEIPT.RECEIPT_ID', 'asc');
						
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR GETTING DEITY 
		function get_all_field_deity($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableDeity);
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
		
		//FOR GETTING DEITY IN REPORT
		function get_all_deity_on_report($conditionOne = array(),$conditionTwo = array()) {
			$this->db->distinct();
			$this->db->select('SO_DEITY_NAME, SO_DEITY_ID');
			$this->db->from($this->tableDeitySevaOffered);
			if($conditionOne) {
				$this->db->where($conditionOne);
			}
			
			if ($order_by_field) {
				$this->db->order_by('DEITY_SEVA_OFFERED.SO_DEITY_ID', 'ASC');
			}
			
			$this->db->join('DEITY_RECEIPT', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID');
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			
			$query = $this->db->get();
			$arr = $query->result_array();
			
			if($conditionTwo) $date = "";
			else $date = date('d-m-Y');
			
			//BOOKING
			$this->db->distinct()->select('SO_DEITY_NAME, SO_DEITY_ID')->from('SEVA_BOOKING')->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
			
			if($date != "")
				$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0));
			
			if($conditionTwo) {
				$this->db->where($conditionTwo);
			}
		
			$this->db->order_by('SEVA_BOOKING.SB_ID', 'desc');
				
			$query = $this->db->get();
			$arr1 = $query->result_array();
			
			$arr2 = array_merge($arr,$arr1);
					
			return array_unique($arr2);
		}
		
		//FOR DEITY RECEIPT REPORT
		function get_all_field_deity_receipt_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->tableDeityReceipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			//$this->db->join('DEITY', 'DEITY_RECEIPT.RECEIPT_DEITY_ID = DEITY.DEITY_ID');  
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$this->db->join('deity_inkind_offered', 'DEITY_RECEIPT.RECEIPT_ID = deity_inkind_offered.RECEIPT_ID','left');
			//$this->db->join('DEITY_SEVA_OFFERED', 'DEITY_RECEIPT.RECEIPT_ID = DEITY_SEVA_OFFERED.RECEIPT_ID','right');
			$this->db->order_by('DEITY_RECEIPT.RECEIPT_ID', 'asc');
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		
		//FOR DEITY RECEIPT REPORT
		function get_all_field_jeernodhara_receipt_report($condition = '',$userId,$payMethod, $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->tableDeityReceipt);
			if ($condition) {
				$this->db->where($condition);
				
				if($userId > 0) $this->db->where('RECEIPT_ISSUED_BY_ID',$userId);
				
				if($payMethod != "All") $this->db->where('RECEIPT_PAYMENT_METHOD',$payMethod); 
				
				$this->db->where('IS_JEERNODHARA',1);
				$this->db->where('RECEIPT_ACTIVE',1);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->join('USERS','DEITY_RECEIPT.RECEIPT_ISSUED_BY_ID = USERS.USER_ID');  
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			
			$this->db->order_by('RECEIPT_ID', 'DESC');
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		function get_all_field_temple_day_book_excel($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc",$receiptCat){
			$catCondition = "";
			if($receiptCat!="" && $receiptCat!='0')
				$catCondition = "WHERE rCatId=$receiptCat";

			if($fromDate != "" && $toDate != "") {
				$query = "SELECT * FROM
						(SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_seva_offered.SO_PRICE as amt,
							   '' as amtPostage,
							   deity_seva_offered.SO_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY AS sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   '' as amt,
							   POSTAGE_PRICE as amtPostage,
							   POSTAGE_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY AS sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1 AND POSTAGE_PRICE > 0
						GROUP BY deity_receipt.RECEIPT_ID
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   \"\" as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SEVA_QTY as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM shashwath_seva 
						INNER JOIN deity_receipt ON shashwath_seva.SS_ID = deity_receipt.SS_ID
						INNER JOIN deity ON shashwath_seva.DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON shashwath_seva.SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 7
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_receipt 
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 8 OR deity_receipt.`RECEIPT_CATEGORY_ID` = 9 )
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_receipt JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10 )
						UNION ALL
						SELECT RECEIPT_ID as rId,
							   CONCAT('Deity',IF(deity_receipt.IS_TRUST = 0,'',' (Hall)')) as receiptFor,
							   RECEIPT_NO as rNo, 
							   RECEIPT_DATE as rDate, 
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM `deity_receipt`
						INNER JOIN deity ON deity.DEITY_ID = deity_receipt.RECEIPT_DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(`RECEIPT_CATEGORY_ID` = 2 OR `RECEIPT_CATEGORY_ID` = 3 OR `RECEIPT_CATEGORY_ID` = 4 OR `RECEIPT_CATEGORY_ID` = 6) 
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5)
						UNION ALL    
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
							   \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate, 
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   event_seva_offered.ET_SO_PRICE as amt, 
							   '' as amtPostage, 
							   event_seva_offered.ET_SO_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status, 
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime ,ET_SO_QUANTITY as sevaQty ,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 
						UNION ALL 
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
							   \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,							   
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   '' as amt, 
							   POSTAGE_PRICE as amtPostage, 
							   POSTAGE_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user, 
							   PAYMENT_STATUS as status, 
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,ET_SO_QUANTITY as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc 
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0
						GROUP BY event_receipt.ET_RECEIPT_ID
						UNION ALL
						SELECT ET_RECEIPT_ID as rId,
							   \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   ET_RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (ET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,1 as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM event_receipt
						INNER JOIN event ON event.ET_ID = event_receipt.RECEIPT_ET_ID
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(ET_RECEIPT_CATEGORY_ID = 2 OR ET_RECEIPT_CATEGORY_ID = 3) 
						UNION ALL
						SELECT event_receipt.ET_RECEIPT_ID as rId,
							   \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(event_receipt.ET_RECEIPT_CATEGORY_ID = 4)
						) t $catCondition
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
			} else {
				$query = "SELECT * FROM
						(SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_seva_offered.SO_PRICE as amt,
							   '' as amtPostage,
							   deity_seva_offered.SO_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY AS sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1 
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   '' as amt,
							   POSTAGE_PRICE as amtPostage,
							   POSTAGE_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY AS sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1 AND POSTAGE_PRICE > 0
						GROUP BY deity_receipt.RECEIPT_ID
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   \"\" as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SEVA_QTY as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM shashwath_seva 
						INNER JOIN deity_receipt ON shashwath_seva.SS_ID = deity_receipt.SS_ID
						INNER JOIN deity ON shashwath_seva.DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON shashwath_seva.SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 7
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_receipt 
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 8 OR deity_receipt.`RECEIPT_CATEGORY_ID` = 9 )
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10 )
						UNION ALL
						SELECT RECEIPT_ID as rId,
							   CONCAT('Deity',IF(deity_receipt.IS_TRUST = 0,'',' (Hall)')) as receiptFor,
							   RECEIPT_NO as rNo, 
							   RECEIPT_DATE as rDate, 
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM `deity_receipt`
						INNER JOIN deity ON deity.DEITY_ID = deity_receipt.RECEIPT_DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(`RECEIPT_CATEGORY_ID` = 2 OR `RECEIPT_CATEGORY_ID` = 3 OR `RECEIPT_CATEGORY_ID` = 4 OR `RECEIPT_CATEGORY_ID` = 6) 
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5)
						UNION ALL    
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
							   \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate, 
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   event_seva_offered.ET_SO_PRICE as amt, 
							   '' as amtPostage, 
							   event_seva_offered.ET_SO_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status, 
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime ,ET_SO_QUANTITY as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc 
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 
						UNION ALL 
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
							   \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,							   
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   '' as amt, 
							   POSTAGE_PRICE as amtPostage, 
							   POSTAGE_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user, 
							   PAYMENT_STATUS as status, 
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime ,ET_SO_QUANTITY as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc 
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0
						GROUP BY event_receipt.ET_RECEIPT_ID
						UNION ALL
						SELECT ET_RECEIPT_ID as rId,
							   \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   ET_RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (ET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,1 as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM event_receipt
						INNER JOIN event ON event.ET_ID = event_receipt.RECEIPT_ET_ID
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(ET_RECEIPT_CATEGORY_ID = 2 OR ET_RECEIPT_CATEGORY_ID = 3) 
						UNION ALL
						SELECT event_receipt.ET_RECEIPT_ID as rId,
							   \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(event_receipt.ET_RECEIPT_CATEGORY_ID = 4)
						) t $catCondition
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
			}				

			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$resQuery = $this->db->query($query);
			
			if ($resQuery->num_rows() > 0) {
				return $resQuery->result();
			} else {
				return array();
			}			
		}
		
		// Function to get Cash, Cheque, Credit/Debit, Direct Credit
		function get_all_field_temple_day_book_account_summary($fromDate = "", $toDate = "",$receiptCat) {
			$catCondition = $catConditionET= "";
			if($receiptCat!="" && $receiptCat!='0'){
				$catCondition = "AND RECEIPT_CATEGORY_ID=$receiptCat";
				$catConditionET = "AND ET_RECEIPT_CATEGORY_ID=$receiptCat";
			}

			if($fromDate != "" && $toDate != "") {
				$query = "SELECT (COALESCE((SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM deity_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Cash' $catCondition AND RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM event_receipt WHERE ET_RECEIPT_PAYMENT_METHOD = 'Cash' $catConditionET AND ET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) AS CASH,
								 (COALESCE((SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM deity_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Cheque' $catCondition AND RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM event_receipt WHERE ET_RECEIPT_PAYMENT_METHOD = 'Cheque' $catConditionET AND ET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) AS CHEQUE,
                                 (COALESCE((SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM deity_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Direct Credit' $catCondition AND RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM event_receipt WHERE ET_RECEIPT_PAYMENT_METHOD = 'Direct Credit' $catConditionET AND ET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) AS DIRECTCREDIT,
                                 (COALESCE((SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM deity_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' $catCondition AND RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM event_receipt WHERE ET_RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' $catConditionET AND ET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) AS CREDITDEBIT,
                                 (COALESCE((SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM deity_receipt WHERE RECEIPT_ACTIVE = 1 $catCondition AND  STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM event_receipt WHERE ET_RECEIPT_ACTIVE = 1 $catConditionET AND  STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) AS GRANDTOTAL";
			} else {
				$query = "SELECT (COALESCE((SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM deity_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Cash' $catCondition AND RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM event_receipt WHERE ET_RECEIPT_PAYMENT_METHOD = 'Cash' $catConditionET AND ET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) AS CASH,
								 (COALESCE((SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM deity_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Cheque' $catCondition AND RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM event_receipt WHERE ET_RECEIPT_PAYMENT_METHOD = 'Cheque' $catConditionET AND ET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) AS CHEQUE,
                                 (COALESCE((SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM deity_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Direct Credit' $catCondition AND RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM event_receipt WHERE ET_RECEIPT_PAYMENT_METHOD = 'Direct Credit' $catConditionET AND ET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) AS DIRECTCREDIT,
                                 (COALESCE((SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM deity_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' $catCondition AND RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM event_receipt WHERE ET_RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' $catConditionET AND ET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) AS CREDITDEBIT,
                                 (COALESCE((SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM deity_receipt WHERE RECEIPT_ACTIVE = 1 $catCondition AND  STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM event_receipt WHERE ET_RECEIPT_ACTIVE = 1 $catConditionET AND  STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) AS GRANDTOTAL";
			}
			
			$resQuery = $this->db->query($query);
			
			if ($resQuery->num_rows() > 0) {
				return $resQuery->row();
			} else {
				return array();
			}
		}

		//FOR DEITY RECEIPT REPORT
		function get_all_field_temple_day_book($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0,$receiptCat) {
			$catCondition = "";
			if($receiptCat!="" && $receiptCat!='0')
				$catCondition = "WHERE rCatId=$receiptCat";

			if($fromDate != "" && $toDate != "") {
				$query = "SELECT * FROM
						(SELECT deity_receipt.RECEIPT_ID as rId,
						       'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_seva_offered.SO_PRICE as amt,
							   '' as amtPostage,
							   deity_seva_offered.SO_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   '' as amt,
							   POSTAGE_PRICE as amtPostage,
							   POSTAGE_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1 AND POSTAGE_PRICE > 0
						GROUP BY deity_receipt.RECEIPT_ID
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   \"\" as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SEVA_QTY as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM shashwath_seva 
						INNER JOIN deity_receipt ON shashwath_seva.SS_ID = deity_receipt.SS_ID
						INNER JOIN deity ON shashwath_seva.DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON shashwath_seva.SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 7
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_receipt 
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 8 OR deity_receipt.`RECEIPT_CATEGORY_ID` = 9 )
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10)
						UNION ALL
						SELECT RECEIPT_ID as rId,
							   CONCAT('Deity',IF(deity_receipt.IS_TRUST = 0,'',' (Hall)')) as receiptFor,
							   RECEIPT_NO as rNo, 
							   RECEIPT_DATE as rDate, 
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM `deity_receipt`
						INNER JOIN deity ON deity.DEITY_ID = deity_receipt.RECEIPT_DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(`RECEIPT_CATEGORY_ID` = 2 OR `RECEIPT_CATEGORY_ID` = 3 OR `RECEIPT_CATEGORY_ID` = 4 OR `RECEIPT_CATEGORY_ID` = 6) 
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5)
						UNION ALL     
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
							   'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate, 
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   event_seva_offered.ET_SO_PRICE as amt, 
							   '' as amtPostage, 
							   event_seva_offered.ET_SO_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status, 
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,ET_SO_QUANTITY as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 
						UNION ALL 
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
							   'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,							   
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   '' as amt, 
							   POSTAGE_PRICE as amtPostage, 
							   POSTAGE_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user, 
							   PAYMENT_STATUS as status, 
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,ET_SO_QUANTITY as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0 
						GROUP BY event_receipt.ET_RECEIPT_ID
						UNION ALL
						SELECT ET_RECEIPT_ID as rId,
							   'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   ET_RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (ET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,1 as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM event_receipt
						INNER JOIN event ON event.ET_ID = event_receipt.RECEIPT_ET_ID
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(ET_RECEIPT_CATEGORY_ID = 2 OR ET_RECEIPT_CATEGORY_ID = 3) 
						UNION ALL
						SELECT event_receipt.ET_RECEIPT_ID as rId,
							   'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 4
						) t $catCondition
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC limit ".$start.",".$num;
			} else {
				$query = "SELECT * FROM
						(SELECT deity_receipt.RECEIPT_ID as rId,
							   'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_seva_offered.SO_PRICE as amt,
							   '' as amtPostage,
							   deity_seva_offered.SO_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   '' as amt,
							   POSTAGE_PRICE as amtPostage,
							   POSTAGE_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1 AND POSTAGE_PRICE > 0
						GROUP BY deity_receipt.RECEIPT_ID
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   \"\" as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SEVA_QTY AS sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM shashwath_seva 
						INNER JOIN deity_receipt ON shashwath_seva.SS_ID = deity_receipt.SS_ID
						INNER JOIN deity ON shashwath_seva.DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON shashwath_seva.SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 7
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM deity_receipt 
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 8 OR deity_receipt.`RECEIPT_CATEGORY_ID` = 9 )
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10 )
						UNION ALL
						SELECT RECEIPT_ID as rId,
							   CONCAT('Deity',IF(deity_receipt.IS_TRUST = 0,'',' (Hall)')) as receiptFor,
							   RECEIPT_NO as rNo, 
							   RECEIPT_DATE as rDate, 
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM `deity_receipt`
						INNER JOIN deity ON deity.DEITY_ID = deity_receipt.RECEIPT_DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(`RECEIPT_CATEGORY_ID` = 2 OR `RECEIPT_CATEGORY_ID` = 3 OR `RECEIPT_CATEGORY_ID` = 4 OR `RECEIPT_CATEGORY_ID` = 6) 
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
						       'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5)
						UNION ALL    
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
						       'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate, 
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   event_seva_offered.ET_SO_PRICE as amt, 
							   '' as amtPostage, 
							   event_seva_offered.ET_SO_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status, 
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,ET_SO_QUANTITY as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc 
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 
						UNION ALL 
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
						       'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,							   
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   '' as amt, 
							   POSTAGE_PRICE as amtPostage, 
							   POSTAGE_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user, 
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,							   
							   event_receipt.DATE_TIME as dttime,ET_SO_QUANTITY as sevaQty ,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0	
						GROUP BY event_receipt.ET_RECEIPT_ID
						UNION ALL
						SELECT ET_RECEIPT_ID as rId,
							   'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   ET_RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (ET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,1 as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
						FROM event_receipt
						INNER JOIN event ON event.ET_ID = event_receipt.RECEIPT_ET_ID
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(ET_RECEIPT_CATEGORY_ID = 2 OR ET_RECEIPT_CATEGORY_ID = 3) 
						UNION ALL
						SELECT event_receipt.ET_RECEIPT_ID as rId,
						       'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(event_receipt.ET_RECEIPT_CATEGORY_ID = 4)
						) t $catCondition
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC limit ".$start.",".$num;
			}			
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$resQuery = $this->db->query($query);
			
			if ($resQuery->num_rows() > 0) {
				return $resQuery->result();
			} else {
				return array();
			}
		}

		//FOR DEITY RECEIPT REPORT
		function count_all_field_temple_day_book($fromDate = "", $toDate = "",$receiptCat) {
			$catCondition = "";
			if($receiptCat!="" && $receiptCat!='0')
				$catCondition = "WHERE rCatId=$receiptCat";

			if($fromDate != "" && $toDate != "") {
				$query = "SELECT COUNT(*) AS CNT_DAY_BOOK FROM
						(SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_seva_offered.SO_PRICE as amt,
							   '' as amtPostage,
							   deity_seva_offered.SO_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY AS sevaQty
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1 
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
						       \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   '' as amt,
							   POSTAGE_PRICE as amtPostage,
							   POSTAGE_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY AS sevaQty
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1 AND POSTAGE_PRICE > 0
						GROUP BY deity_receipt.RECEIPT_ID
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   \"\" as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SEVA_QTY as sevaQty
						FROM shashwath_seva 
						INNER JOIN deity_receipt ON shashwath_seva.SS_ID = deity_receipt.SS_ID
						INNER JOIN deity ON shashwath_seva.DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON shashwath_seva.SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 7
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty
						FROM deity_receipt 
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 8 OR deity_receipt.`RECEIPT_CATEGORY_ID` = 9 )
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10 )

						UNION ALL
						SELECT RECEIPT_ID as rId,
						       CONCAT('Deity',IF(deity_receipt.IS_TRUST = 0,'',' (Hall)')) as receiptFor,
							   RECEIPT_NO as rNo, 
							   RECEIPT_DATE as rDate, 
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty
						FROM `deity_receipt`
						INNER JOIN deity ON deity.DEITY_ID = deity_receipt.RECEIPT_DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(`RECEIPT_CATEGORY_ID` = 2 OR `RECEIPT_CATEGORY_ID` = 3 OR `RECEIPT_CATEGORY_ID` = 4 OR `RECEIPT_CATEGORY_ID` = 6) 
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
						       \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5)
						UNION ALL    
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
						       \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate, 
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   event_seva_offered.ET_SO_PRICE as amt, 
							   '' as amtPostage, 
							   event_seva_offered.ET_SO_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status, 
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,ET_SO_QUANTITY as sevaQty 
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 
						UNION ALL 
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
						       \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,							   
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   '' as amt, 
							   POSTAGE_PRICE as amtPostage, 
							   POSTAGE_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user, 
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,							   
							   event_receipt.DATE_TIME as dttime,ET_SO_QUANTITY as sevaQty 
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0
						GROUP BY event_receipt.ET_RECEIPT_ID
						UNION ALL
						SELECT ET_RECEIPT_ID as rId,
						       \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   ET_RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (ET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,1 as sevaQty
						FROM event_receipt
						INNER JOIN event ON event.ET_ID = event_receipt.RECEIPT_ET_ID
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(ET_RECEIPT_CATEGORY_ID = 2 OR ET_RECEIPT_CATEGORY_ID = 3) 
						UNION ALL
						SELECT event_receipt.ET_RECEIPT_ID as rId,
						       \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 4
						) t $catCondition
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
			} else {
				$query = "SELECT COUNT(*) AS CNT_DAY_BOOK FROM
						(SELECT deity_receipt.RECEIPT_ID as rId,
						       \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_seva_offered.SO_PRICE as amt,
							   '' as amtPostage,
							   deity_seva_offered.SO_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY AS sevaQty
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
						       \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   '' as amt,
							   POSTAGE_PRICE as amtPostage,
							   POSTAGE_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SO_QUANTITY AS sevaQty
						FROM deity_seva_offered 
						INNER JOIN deity_receipt ON deity_seva_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_seva_offered.SO_DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON deity_seva_offered.SO_SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 1 AND POSTAGE_PRICE > 0
						GROUP BY deity_receipt.RECEIPT_ID
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_seva.SEVA_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   \"\" as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,SEVA_QTY as sevaQty
						FROM shashwath_seva 
						INNER JOIN deity_receipt ON shashwath_seva.SS_ID = deity_receipt.SS_ID
						INNER JOIN deity ON shashwath_seva.DEITY_ID = deity.DEITY_ID
						INNER JOIN deity_seva ON shashwath_seva.SEVA_ID = deity_seva.SEVA_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						deity_receipt.`RECEIPT_CATEGORY_ID` = 7
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty
						FROM deity_receipt 
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 8 OR deity_receipt.`RECEIPT_CATEGORY_ID` = 9 )	
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						( deity_receipt.`RECEIPT_CATEGORY_ID` = 10)					
						UNION ALL						
						SELECT RECEIPT_ID as rId,
						       CONCAT('Deity',IF(deity_receipt.IS_TRUST = 0,'',' (Hall)')) as receiptFor,
							   RECEIPT_NO as rNo, 
							   RECEIPT_DATE as rDate, 
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,1 as sevaQty
						FROM `deity_receipt`
						INNER JOIN deity ON deity.DEITY_ID = deity_receipt.RECEIPT_DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(`RECEIPT_CATEGORY_ID` = 2 OR `RECEIPT_CATEGORY_ID` = 3 OR `RECEIPT_CATEGORY_ID` = 4 OR `RECEIPT_CATEGORY_ID` = 6) 
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
						       \"Deity\" as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5)
						UNION ALL    
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
						       \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate, 
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   event_seva_offered.ET_SO_PRICE as amt, 
							   '' as amtPostage, 
							   event_seva_offered.ET_SO_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status, 
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,ET_SO_QUANTITY as sevaQty
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 
						UNION ALL 
						SELECT event_receipt.ET_RECEIPT_ID as rId, 
						       \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,							   
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType, 
							   event_seva.ET_SEVA_NAME as sevaName, 
							   event.ET_NAME as dtetName, 
							   ET_RECEIPT_NAME as rName, 
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
							   '' as amt, 
							   POSTAGE_PRICE as amtPostage, 
							   POSTAGE_PRICE as total, 
							   ET_RECEIPT_ISSUED_BY as user, 
							   PAYMENT_STATUS as status, 
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,ET_SO_QUANTITY as sevaQty
						FROM event_seva_offered  
						INNER JOIN event_receipt ON event_seva_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID 
						INNER JOIN event_seva ON event_seva_offered.ET_SO_SEVA_ID = event_seva.ET_SEVA_ID 
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID 
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0
						GROUP BY event_receipt.ET_RECEIPT_ID
						UNION ALL
						SELECT ET_RECEIPT_ID as rId,
						       \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo, 
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   '' as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   ET_RECEIPT_PRICE as amt,
							   POSTAGE_PRICE as amtPostage,
							   (ET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,1 as sevaQty
						FROM event_receipt
						INNER JOIN event ON event.ET_ID = event_receipt.RECEIPT_ET_ID
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(ET_RECEIPT_CATEGORY_ID = 2 OR ET_RECEIPT_CATEGORY_ID = 3) 
						UNION ALL
						SELECT event_receipt.ET_RECEIPT_ID as rId,
						       \"Event\" as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 4
						) t $catCondition
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
			}
			
			$resQuery = $this->db->query($query);			
			return $resQuery->row()->CNT_DAY_BOOK;
			
		}
		
		//FOR DEITY RECEIPT REPORT
		function get_total_amount_deity($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('(SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE');
			$this->db->from($this->tableDeityReceipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			//$this->db->join('DEITY', 'DEITY_RECEIPT.RECEIPT_DEITY_ID = DEITY.DEITY_ID');
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			//$this->db->join('DEITY_SEVA_OFFERED', 'DEITY_RECEIPT.RECEIPT_ID = DEITY_SEVA_OFFERED.RECEIPT_ID','right');
			$this->db->order_by('RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();
			} else {
				return array();
			}
		}
		
		//FOR DEITY RECEIPT REPORT AMOUNT
		function get_all_amount_deity($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableDeityReceipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			//$this->db->join('DEITY', 'DEITY_RECEIPT.RECEIPT_DEITY_ID = DEITY.DEITY_ID');
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			//$this->db->join('DEITY_SEVA_OFFERED', 'DEITY_RECEIPT.RECEIPT_ID = DEITY_SEVA_OFFERED.RECEIPT_ID','right');
			$this->db->order_by('RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR EVENT RECEIPT REPORT COUNT
		function count_rows_deity_receipt_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableDeityReceipt);
			if($condition){
				$this->db->where($condition);
			}
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$this->db->join('deity_inkind_offered', 'DEITY_RECEIPT.RECEIPT_ID = deity_inkind_offered.RECEIPT_ID','left');

			//$this->db->join('DEITY_SEVA_OFFERED', 'DEITY_RECEIPT.RECEIPT_ID = DEITY_SEVA_OFFERED.RECEIPT_ID','right');
			$this->db->order_by('DEITY_RECEIPT.RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR JEERNODHARA REPORT COUNT
		function count_rows_jeernodhara_receipt_report($condition=array(), $userId, $payMethod, $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableDeityReceipt);
			if($condition){
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
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$this->db->join('USERS', 'USERS.USER_ID = DEITY_RECEIPT.RECEIPT_ISSUED_BY_ID');
			$this->db->order_by('RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR APPROVE THE AUTHORISE
		function update_authorise($condition=array(),$data_array=array()){
			if($condition){
				$this->db->where($condition);
			}
			
			if($this->db->update($this->table,$data_array)){
				return true;
			} else {
				return false;
			}
		}
		
		//GETTING ALL USERS
		function get_all_users_on_events($condition=array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->distinct();
			$this->db->select('USERS.USER_ID, USER_FULL_NAME');
			$this->db->from('users');
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			$this->db->join('EVENT_RECEIPT', 'EVENT_RECEIPT.ET_RECEIPT_ISSUED_BY_ID = USERS.USER_ID');
			//SIR'S CODE
			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			} 
		}
		
		//FOR EVENT SEVA REPORT COUNT
		function count_rows_seva_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableEventOffered);
			if($condition){
				$this->db->where($condition);
			}
			
			$this->db->join('EVENT_RECEIPT', 'EVENT_SEVA_OFFERED.ET_RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID');
			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR EVENT SEVA REPORT
		function get_all_field_event_seva_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->tableEventOffered);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('EVENT_RECEIPT', 'EVENT_SEVA_OFFERED.ET_RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID');
			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR EVENT SEVA REPORT
		function get_all_field_event_seva_excel($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableEventOffered);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('EVENT_RECEIPT', 'EVENT_SEVA_OFFERED.ET_RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID');
			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR EVENT SEVA OFFERED REPORT
		function get_all_field_seva_report($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->distinct();
			$this->db->select('ET_SO_SEVA_NAME, ET_SO_SEVA_ID');
			$this->db->from($this->tableEventOffered);
			if ($condition) { 
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->join('EVENT_RECEIPT', 'EVENT_SEVA_OFFERED.ET_RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID');
			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR GETTING EVENT 
		function get_all_field_event($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableEvent);
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
		
		//FOR GETTING EVENT SEVA
		function get_all_field_event_seva($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableEventSeva);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->join('EVENT', 'EVENT_SEVA.ET_ID = EVENT.ET_ID');
			$this->db->join('EVENT_SEVA_PRICE', 'EVENT_SEVA.ET_SEVA_ID = EVENT_SEVA_PRICE.ET_SEVA_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR EVENT RECEIPT REPORT COUNT
		function count_rows_receipt_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->table);
			if($condition){
				$this->db->where($condition);
			}
			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			$this->db->order_by('ET_RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}

		//for cancelled count
		function cancelled_count_rows_receipt_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->table);
			if($condition){
				$this->db->where($condition);
			}
			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			$this->db->join('USERS', 'EVENT_RECEIPT.ET_RECEIPT_ISSUED_BY_ID = USERS.USER_ID');			
			$this->db->order_by('ET_RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR EVENT RECEIPT REPORT
		function get_all_field_event_receipt_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			$this->db->join('event_inkind_offered', 'event_receipt.ET_RECEIPT_ID = event_inkind_offered.ET_RECEIPT_ID','left');
			$this->db->order_by('EVENT_RECEIPT.ET_RECEIPT_ID', 'desc');
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		//FOR EVENT RECEIPT REPORT
		function get_full_field_event_receipt_report($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table);
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
		function get_all_amount($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table);
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
		function get_total_amount($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('(SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE');
			$this->db->from($this->table);
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
		function get_total_amount_user_collection($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('(SUM(ET_RECEIPT_PRICE)) AS PRICE');
			$this->db->from($this->table);
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
		
		//FOR EVENT RECEIPT EXCEL
		function get_all_field_event_receipt_excel($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			$this->db->join('event_inkind_offered', 'event_receipt.ET_RECEIPT_ID = event_inkind_offered.ET_RECEIPT_ID','left');
			$this->db->order_by('EVENT_RECEIPT.ET_RECEIPT_ID', 'desc');
						
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		function get_all_temple_inkind_report($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0,$inkindType) {
			if($inkindType != ""){
				$inkindTypeCond = "AND (`DEITY_INKIND_OFFERED`.`DY_IK_ITEM_NAME` = '".$inkindType."' ) ";
				$eventInkindTypeCond = "AND (`event_inkind_offered`.`IK_ITEM_NAME` = '".$inkindType."' ) ";
			}else{
				$inkindTypeCond = "";
				$eventInkindTypeCond ="";
			}

			if($fromDate != "" && $toDate != "") {
				$query = "SELECT * FROM
						(SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(TRIM(DY_IK_ITEM_QTY)+0,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10) $inkindTypeCond 
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(TRIM(DY_IK_ITEM_QTY)+0,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5) $inkindTypeCond 
						UNION ALL     
						SELECT event_receipt.ET_RECEIPT_ID as rId,
							   'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,TRIM(IK_ITEM_QTY)+0 as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 4 $eventInkindTypeCond
						) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC limit ".$start.",".$num;
			} else {
				$query = "SELECT * FROM
						(
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(TRIM(DY_IK_ITEM_QTY)+0,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10 )  $inkindTypeCond
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
						       'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(TRIM(DY_IK_ITEM_QTY)+0,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5) $inkindTypeCond
						 
						UNION ALL
						SELECT event_receipt.ET_RECEIPT_ID as rId,
						       'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,CONCAT(TRIM(IK_ITEM_QTY)+0,' ',IK_ITEM_UNIT) as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(event_receipt.ET_RECEIPT_CATEGORY_ID = 4) $eventInkindTypeCond
						) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC limit ".$start.",".$num;
			}			
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$resQuery = $this->db->query($query);
			
			if ($resQuery->num_rows() > 0) {
				return $resQuery->result();
			} else {
				return array();
			}
		}

		function count_get_all_temple_inkind_report($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc",$inkindType) {
			if($inkindType != ""){
				$inkindTypeCond = "AND (`DEITY_INKIND_OFFERED`.`DY_IK_ITEM_NAME` = '".$inkindType."' ) ";
				$eventInkindTypeCond = "AND (`event_inkind_offered`.`IK_ITEM_NAME` = '".$inkindType."' ) ";
			}else{
				$inkindTypeCond = "";
				$eventInkindTypeCond ="";
			}
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT COUNT(*) AS CNT_DAY_BOOK FROM
						(SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10) $inkindTypeCond
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5) $inkindTypeCond
						UNION ALL     
						SELECT event_receipt.ET_RECEIPT_ID as rId,
							   'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,IK_ITEM_QTY as sevaQty
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 4 $eventInkindTypeCond
						) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC  ";
			} else {
				$query = "SELECT COUNT(*) AS CNT_DAY_BOOK FROM
						(
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10 ) $inkindTypeCond
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
						       'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5) $inkindTypeCond
						 
						UNION ALL
						SELECT event_receipt.ET_RECEIPT_ID as rId,
						       'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(event_receipt.ET_RECEIPT_CATEGORY_ID = 4) $eventInkindTypeCond
						) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC ";
			}			
			$resQuery = $this->db->query($query);			
			return $resQuery->row()->CNT_DAY_BOOK;
		}

		function get_all_temple_inkind_report_excel($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc",$inkindType) {
			if($inkindType != ""){
				$inkindTypeCond = "AND (`DEITY_INKIND_OFFERED`.`DY_IK_ITEM_NAME` = '".$inkindType."' ) ";
				$eventInkindTypeCond = "AND (`event_inkind_offered`.`IK_ITEM_NAME` = '".$inkindType."' ) ";
			}else{
				$inkindTypeCond = "";
				$eventInkindTypeCond ="";
			}
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT * FROM
						(SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10) $inkindTypeCond
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5) $inkindTypeCond
						UNION ALL     
						SELECT event_receipt.ET_RECEIPT_ID as rId,
							   'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
						event_receipt.ET_RECEIPT_CATEGORY_ID = 4  $eventInkindTypeCond
						) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC  ";
			} else {
				$query = "SELECT * FROM
						(
						SELECT deity_receipt.RECEIPT_ID as rId,
							   'Jeernodhara' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   '' as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   deity_receipt.RECEIPT_PRICE as amt,
							   '' as amtPostage,
							   deity_receipt.RECEIPT_PRICE as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_receipt  JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID`
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 10 ) $inkindTypeCond
						UNION ALL
						SELECT deity_receipt.RECEIPT_ID as rId,
						       'Deity' as receiptFor,
							   RECEIPT_NO as rNo,
							   RECEIPT_DATE as rDate,
							   deity_receipt.RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT RECEIPT_CATEGORY_TYPE FROM deity_receipt_category WHERE RECEIPT_CATEGORY_ID = deity_receipt.RECEIPT_CATEGORY_ID) AS rType,
							   deity_inkind_offered.DY_IK_ITEM_NAME as sevaName,
							   deity.DEITY_NAME as dtetName,
							   RECEIPT_NAME as rName,
							   RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   deity_receipt.DATE_TIME as dttime,CONCAT(DY_IK_ITEM_QTY,' ',DY_IK_ITEM_UNIT) as sevaQty,RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,DY_IK_APPRX_AMT as apprxAmt,DY_IK_ITEM_DESC as itemDesc
						FROM deity_inkind_offered 
						INNER JOIN deity_receipt ON deity_inkind_offered.RECEIPT_ID = deity_receipt.RECEIPT_ID
						INNER JOIN deity ON deity_receipt.RECEIPT_DEITY_ID = deity.DEITY_ID
						WHERE STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(deity_receipt.`RECEIPT_CATEGORY_ID` = 5) $inkindTypeCond
						 
						UNION ALL
						SELECT event_receipt.ET_RECEIPT_ID as rId,
						       'Event' as receiptFor,
							   ET_RECEIPT_NO as rNo,
							   ET_RECEIPT_DATE as rDate,
							   event_receipt.ET_RECEIPT_CATEGORY_ID as rCatId,
							   (SELECT ET_RECEIPT_CATEGORY_TYPE FROM event_receipt_category WHERE ET_RECEIPT_CATEGORY_ID = event_receipt.ET_RECEIPT_CATEGORY_ID) AS rType,
							   event_inkind_offered.IK_ITEM_NAME as sevaName,
							   event.ET_NAME as dtetName,
							   ET_RECEIPT_NAME as rName,
							   ET_RECEIPT_PAYMENT_METHOD as rPayMethod,
							   \"\" as amt,
							   \"\" as amtPostage,
							   \"\" as total,
							   ET_RECEIPT_ISSUED_BY as user,
							   PAYMENT_STATUS as status,
							   CANCEL_NOTES as cnclNotes,
							   event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,ET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
						FROM event_inkind_offered 
						INNER JOIN event_receipt ON event_inkind_offered.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID
						INNER JOIN event ON event_receipt.RECEIPT_ET_ID = event.ET_ID
						WHERE STR_TO_DATE(`ET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
						(event_receipt.ET_RECEIPT_CATEGORY_ID = 4)  $eventInkindTypeCond
						) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC ";
			}			
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$resQuery = $this->db->query($query);
			
			if ($resQuery->num_rows() > 0) {
				return $resQuery->result();
			} else {
				return array();
			}
		}
	}
?>
