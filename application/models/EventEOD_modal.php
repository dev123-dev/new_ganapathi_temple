<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class EventEOD_modal extends CI_Model{
		//TABLE
		var $table = 'EVENT_RECEIPT';
		
		public function __Construct() {
			parent::__construct();
			$this->load->database();
		}
		
		//FOR APPROVE THE AUTHORISE
		function update_authorise($condition=array(),$data_array=array(),$whereOne){
			if($condition){
				$this->db->where($condition);
				$this->db->where($whereOne);
			}
			
			if($this->db->update($this->table,$data_array)){
				return true;
			} else {
				return false;
			}
		}
		
		//FOR GETTING EVENT  USER
		function get_all_field($fromDate, $toDate) {
			$sql = "SELECT `EUC_ID`, `EUC_BY_ID`, `BANK_BRANCH`, `ACCOUNT_NO`, `BANK_NAME`, `EUC_BY_NAME`, `EUC_EOD_DATE`, `EUC_CREDIT`, `EUC_CASH`, `EUC_CHEQUE`, `EUC_DIRECT_CREDIT`, `EUC_DEBIT_CREDIT_CARD`, `EUC_CASH_CHEQUE`, `EUC_CHEQUE_NO`, `EUC_CHEQUE_DATE`, `EUC_BANK_NAME`, `EUC_BRANCH_NAME`, `EUC_IS_DEPOSITED`, `EUC_DEBIT`, `EUC_CASH_DEPOSIT`, `EUC_CHEQUE_DEPOSIT`, `EUC_BANK_ID`, `EUC_DATE_TIME`, `EUC_DATE` , EUC_EOD_DATE EOD, @RunningBal OpBal, COALESCE(EUC_CASH_CHEQUE,0) Credit, COALESCE(EUC_DEBIT,0) Debit, @RunningBal:= @RunningBal+COALESCE(EUC_CASH_CHEQUE,0) - COALESCE(EUC_DEBIT,0)  ClBal FROM event_user_collection LEFT JOIN EVENT_BANK ON EVENT_USER_COLLECTION.EUC_BANK_ID = EVENT_BANK.BANK_ID, ( SELECT @RunningBal:=COALESCE(SUM(EUC_CASH_CHEQUE),0) - COALESCE(SUM(EUC_DEBIT),0)  Balance FROM event_user_collection WHERE EUC_DATE < '".$fromDate."' ) s WHERE (`EUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') ORDER BY EUC_ID DESC ";
						
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR GETTING EVENT  USER
		function count_get_all_field($fromDate, $toDate) {
			$sql = "SELECT `EUC_ID`, `EUC_BY_ID`,  `EUC_BY_NAME`, `EUC_EOD_DATE`,`EUC_CHEQUE`, `EUC_CHEQUE_NO`, `EUC_CHEQUE_DATE`,`EUC_BANK_NAME`, `EUC_BRANCH_NAME`, `EUC_IS_DEPOSITED`, `EUC_DATE_TIME`, `EUC_DATE` , EUC_EOD_DATE EOD FROM event_user_collection  WHERE (`EUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') ORDER BY EUC_ID DESC";
						
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//FOR RECEIPT REPORT
		function get_total_amount($condition = array(),$whereOne, $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('(SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE');
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
				$this->db->where($whereOne);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$this->db->order_by('ET_RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();
			} else {
				return array();
			}
		}

		//Retrieve all Inkind which are not authorised for this particular date 
		function get_all_event_Inkind_which_are_not_authorised($condition = "") {
			$sql = "SELECT * FROM EVENT_RECEIPT".$condition;
						
			$query = $this->db->query($sql);
			return $query->num_rows();
		}

		//Retrieve all Inkind which are not authorised for this particular date 
		function Update_All_event_Inkind_which_are_not_authorised($condition = "") {
			$sql = "UPDATE EVENT_RECEIPT SET EOD_CONFIRMED_BY_ID = ".$_SESSION['userId'].",EOD_CONFIRMED_BY_NAME = '".$_SESSION['userFullName']."', EOD_CONFIRMED_DATE_TIME = '".date('d-m-Y h:i:s A')."', EOD_CONFIRMED_DATE = '".date('d-m-Y')."'".$condition;
						
			$this->db->query($sql);
			return $sql;
		}
		
		//FOR GETTING EVENT  USER
		function get_all_field_pagination($fromDate, $toDate, $num = 30, $start = 0) {
			$sql = "SELECT `EUC_ID`,  `EUC_BY_ID`, `EUC_BY_NAME`, `EUC_EOD_DATE`,`ET_RECEIPT_NAME`,`EUC_CHEQUE`, `EUC_CHEQUE_NO`, `EUC_CHEQUE_DATE`, `EUC_BANK_NAME`, `EUC_BRANCH_NAME`, `EUC_IS_DEPOSITED`,`EUC_LEDGER_ID`, `EUC_DATE_TIME`, `EUC_DATE` , EUC_EOD_DATE EOD, event_user_collection.ET_RECEIPT_ID,ET_RECEIPT_CATEGORY_TYPE,event_receipt.ET_RECEIPT_CATEGORY_ID  FROM event_user_collection JOIN event_receipt ON event_user_collection.ET_RECEIPT_ID = event_receipt.ET_RECEIPT_ID JOIN event_receipt_category ON event_receipt.ET_RECEIPT_CATEGORY_ID = event_receipt_category.ET_RECEIPT_CATEGORY_ID WHERE (`EUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') AND EUC_IS_DEPOSITED != 1 ORDER BY EUC_ID ASC LIMIT ".$start.",".$num;
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR RECEIPT REPORT
		function get_all_field_receipt_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0,$whereOne) {
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
				$this->db->where($whereOne);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$this->db->order_by('ET_RECEIPT_ID', 'desc');
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		function get_finMth(){
		   $this->db->select('MONTH_IN_NUMBER');
		   $this->db->from('FINANCIAL_YEAR');
		   $query = $this->db->get();
		   if($query->num_rows()>0)
		   return $query->first_row();
		}
		
		//FOR RECEIPT REPORT COUNT
		function count_rows_receipt_report($condition=array(),$whereOne, $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->table);
			if($condition){
				$this->db->where($condition);
				$this->db->where($whereOne);
			}
			
			$this->db->join('EVENT_RECEIPT_CATEGORY', 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID');
			$this->db->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			$this->db->order_by('ET_RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR EVENT RECEIPT REPORT
		function get_all_field_eod_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0,$fDate,$tDate) {
			$sql = "SELECT `ET_RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, 
					(SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,
					(SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,
					(SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',
					(SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
					(SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount
					FROM EVENT_RECEIPT INNER JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID where ET_ACTIVE = 1 and ET_RECEIPT_ISSUED_BY_ID = '".$_SESSION['userId']." and ET_RECEIPT_CATEGORY_ID != 5' and ET_RECEIPT_ACTIVE = 1 and STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'
					GROUP BY `ET_RECEIPT_DATE` ORDER BY STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') DESC limit $start, $num";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR EVENT SEVA REPORT COUNT
		function count_all_field_eod_report($condition=array(), $fDate, $tDate, $order_by_field = '', $order_by_type = "asc"){
				$sql = "SELECT `ET_RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME,  
					SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `ET_RECEIPT_PRICE` ELSE '' END ) AS Cash ,
					SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `ET_RECEIPT_PRICE` ELSE '' END ) AS Cheque,
					SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `ET_RECEIPT_PRICE` ELSE '' END ) AS 'Card',
					SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `ET_RECEIPT_PRICE` ELSE '' END ) AS 'directCredit',
					SUM(ET_RECEIPT_PRICE) AS TotalAmount
					FROM EVENT_RECEIPT INNER JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID where ET_ACTIVE = 1 and ET_RECEIPT_ISSUED_BY_ID = '".$_SESSION['userId']." and ET_RECEIPT_CATEGORY_ID != 5' and ET_RECEIPT_ACTIVE = 1 and STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'
					GROUP BY `ET_RECEIPT_DATE`";
			
			$query = $this->db->query($sql);
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR EVENT RECEIPT REPORT
		function get_all_field_eod_report_admin($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0, $fDate, $tDate,$dateFilter='') {
			$sql = "SELECT `ET_RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_DATE, EOD_CONFIRMED_BY_NAME, 
					(SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,
					(SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,
					(SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',
					(SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
					(SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount
					FROM EVENT_RECEIPT INNER JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID where ET_ACTIVE = 1 and ET_RECEIPT_CATEGORY_ID != 4 and ET_RECEIPT_ACTIVE = 1  and STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."' $dateFilter GROUP BY `ET_RECEIPT_DATE` ORDER BY STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') DESC limit $start, $num";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR EVENT SEVA REPORT COUNT
		function count_all_field_eod_report_admin($condition=array(), $fDate, $tDate, $order_by_field = '', $order_by_type = "asc",$dateFilter=''){
				$sql = "SELECT `ET_RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME,EOD_CONFIRMED_DATE, EOD_CONFIRMED_BY_NAME, 
					SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `ET_RECEIPT_PRICE` ELSE '' END ) AS Cash ,
					SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `ET_RECEIPT_PRICE` ELSE '' END ) AS Cheque,
					SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `ET_RECEIPT_PRICE` ELSE '' END ) AS 'CreditDebitCard',
					SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `ET_RECEIPT_PRICE` ELSE '' END ) AS 'DirectCredit',
					SUM(ET_RECEIPT_PRICE) AS TotalAmount
					FROM EVENT_RECEIPT INNER JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID where ET_ACTIVE = 1 and ET_RECEIPT_CATEGORY_ID != 5 and ET_RECEIPT_ACTIVE = 1  and STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."' $dateFilter GROUP BY `ET_RECEIPT_DATE`";
			
			$query = $this->db->query($sql);
			$row=$query->num_rows();
			return $row;
		}
	}
