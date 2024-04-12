<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class EOD_modal extends CI_Model{
		//TABLE
		var $table = 'DEITY_RECEIPT';
		var $table_User = 'DEITY_RECEIPT';
		
		public function __Construct() {
			parent::__construct();
			$this->load->database();
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

		//Retrieve all Inkind which are not authorised for this particular date 
		function get_all_Inkind_which_are_not_authorised($condition = "") {
			$sql = "SELECT * FROM DEITY_RECEIPT".$condition;
						
			$query = $this->db->query($sql);
			return $query->num_rows();
		}

		//Retrieve all Inkind which are not authorised for this particular date 
		function Update_All_Inkind_which_are_not_authorised($condition = "") {
			$sql = "UPDATE DEITY_RECEIPT SET EOD_CONFIRMED_BY_ID = ".$_SESSION['userId'].",EOD_CONFIRMED_BY_NAME = '".$_SESSION['userFullName']."', EOD_CONFIRMED_DATE_TIME = '".date('d-m-Y h:i:s A')."', EOD_CONFIRMED_DATE = '".date('d-m-Y')."'".$condition;
						
			$this->db->query($sql);
			return $sql;
		}
		
		//FOR GETTING DEITY  USER
		function get_all_field($fromDate, $toDate) {
			$sql = "SELECT `DUC_ID`, `DUC_BY_ID`, `BANK_BRANCH`, `ACCOUNT_NO`, `BANK_NAME`, `DUC_BY_NAME`, `DUC_EOD_DATE`, `DUC_CHEQUE`, `DUC_CHEQUE_NO`, `DUC_CHEQUE_DATE`, `DUC_BANK_NAME`, `DUC_BRANCH_NAME`, `DUC_IS_DEPOSITED`, `DUC_BANK_ID`, `DUC_DATE_TIME`, `DUC_DATE` , DUC_EOD_DATE EOD FROM deity_user_collection LEFT JOIN BANK ON DEITY_USER_COLLECTION.DUC_BANK_ID = BANK.BANK_ID WHERE (`DUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') ORDER BY DUC_ID DESC ";
			
						
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array(); 
			}
		}
		
		//FOR GETTING DEITY  USER
		function count_get_all_field($fromDate, $toDate) {
			$sql = "SELECT `DUC_ID`,  
			       `DUC_BY_ID`, 
				   `DUC_BY_NAME`, 
				   `DUC_EOD_DATE`,
				   `DUC_CHEQUE`, 
				   `DUC_CHEQUE_NO`, 
				   `DUC_CHEQUE_DATE`, 
				   `DUC_BANK_NAME`, 
				   `DUC_BRANCH_NAME`, 
				   `DUC_IS_DEPOSITED`,
				   `DUC_LEDGER_ID`, 
				   `DUC_DATE_TIME`, 
				   `DUC_DATE` , 
				   DUC_EOD_DATE EOD 
				   FROM deity_user_collection 
				   WHERE (`DUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') 
				   AND DUC_IS_DEPOSITED != 1 ORDER BY DUC_ID ";
						
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//FOR RECEIPT REPORT
		function get_total_amount($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->select('(SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE');
		$this->db->from($this->table);
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
		
		//FOR GETTING DEITY  USER
		function get_all_field_pagination($fromDate, $toDate, $num = 10, $start = 0) {
			$sql = "SELECT `DUC_ID`,  
			               `DUC_BY_ID`, 
						   `DUC_BY_NAME`, 
						   `DUC_EOD_DATE`,
						   `RECEIPT_NAME`,
						   `DUC_CHEQUE`, 
						   `DUC_CHEQUE_NO`, 
						   `DUC_CHEQUE_DATE`, 
						   `DUC_BANK_NAME`, 
						   `DUC_BRANCH_NAME`, 
						   `DUC_IS_DEPOSITED`,
						   `DUC_LEDGER_ID`, 
						   `DUC_DATE_TIME`, 
						   `DUC_DATE` , 
						   DUC_EOD_DATE EOD, 
						   deity_user_collection.RECEIPT_ID,
						   RECEIPT_CATEGORY_TYPE,
						   deity_receipt.RECEIPT_CATEGORY_ID 
						   FROM deity_user_collection 
						   JOIN deity_receipt 
						   ON deity_user_collection.RECEIPT_ID = deity_receipt.RECEIPT_ID 
						   JOIN deity_receipt_category 
						   ON deity_receipt.RECEIPT_CATEGORY_ID = deity_receipt_category.RECEIPT_CATEGORY_ID 
						   WHERE (`DUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') 
						   AND DUC_IS_DEPOSITED != 1 ORDER BY DUC_ID ASC LIMIT ".$start.",".$num;
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		//
		//FOR RECEIPT REPORT
		function get_all_field_receipt_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$this->db->order_by('RECEIPT_ID', 'desc');
			$this->db->limit($num, $start);
			$query = $this->db->get();
			if ($query->num_rows() > 0) { 
				return $query->result();
			} else {
				return array();
			}
		}

		//FOR RECEIPT REPORT
		function get_full_field_receipt_report($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->table);
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
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR RECEIPT REPORT COUNT
		function count_rows_receipt_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->table);
			if($condition){
				$this->db->where($condition);
			}
			
			$this->db->join('DEITY_RECEIPT_CATEGORY', 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID = DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID');
			$this->db->order_by('RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR EVENT RECEIPT REPORT
		function get_all_field_eod_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$sql = "SELECT `RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, 
					(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,
					(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,
					(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',
					(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
					(SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount
					FROM DEITY_RECEIPT where RECEIPT_ISSUED_BY_ID = '".$_SESSION['userId']." and RECEIPT_CATEGORY_ID != 5' and RECEIPT_ACTIVE = 1
					GROUP BY `RECEIPT_DATE` ORDER BY STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') DESC limit $start, $num";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR EVENT SEVA REPORT COUNT
		function count_all_field_eod_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
				$sql = "SELECT `RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME,  
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `RECEIPT_PRICE` ELSE '' END ) AS Cash ,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `RECEIPT_PRICE` ELSE '' END ) AS Cheque,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `RECEIPT_PRICE` ELSE '' END ) AS 'Card',
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `RECEIPT_PRICE` ELSE '' END ) AS 'directCredit',
					SUM(RECEIPT_PRICE) AS TotalAmount
					FROM DEITY_RECEIPT where RECEIPT_ISSUED_BY_ID = '".$_SESSION['userId']." and RECEIPT_CATEGORY_ID != 5' and RECEIPT_ACTIVE = 1
					GROUP BY `RECEIPT_DATE`";
			
			$query = $this->db->query($sql);
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR EVENT RECEIPT REPORT
		function get_all_field_eod_report_admin($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0,$dateFilter='') {
			$sql = "SELECT `RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_DATE, EOD_CONFIRMED_BY_NAME, 
					(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,
					(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,
					(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',
					(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
					(SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount
					FROM DEITY_RECEIPT where RECEIPT_CATEGORY_ID != 5 and RECEIPT_ACTIVE = 1 $dateFilter GROUP BY `RECEIPT_DATE` ORDER BY STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') DESC limit $start, $num";
					// and (STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') >= STR_TO_DATE('01-04-2021','%d-%m-%Y')) 
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR EVENT SEVA REPORT COUNT
		function count_all_field_eod_report_admin($condition=array(),$dateFilter=''){
				$sql = "SELECT `RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME,EOD_CONFIRMED_DATE, EOD_CONFIRMED_BY_NAME, 
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `RECEIPT_PRICE` ELSE '' END ) AS Cash ,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `RECEIPT_PRICE` ELSE '' END ) AS Cheque,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `RECEIPT_PRICE` ELSE '' END ) AS 'CreditDebitCard',
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `RECEIPT_PRICE` ELSE '' END ) AS 'DirectCredit',
					SUM(RECEIPT_PRICE) AS TotalAmount
					FROM DEITY_RECEIPT where RECEIPT_CATEGORY_ID != 5 and RECEIPT_ACTIVE = 1 $dateFilter GROUP BY `RECEIPT_DATE`";
			
			$query = $this->db->query($sql);
			$row=$query->num_rows();
			return $row;
		}

		function getTransfer($eodDate){
			$sql = "SELECT `RECEIPT_PAYMENT_METHOD` FROM DEITY_RECEIPT where  `RECEIPT_DATE`= '".$eodDate."' " ;
			$query = $this->db->query($sql);
			return $query->result();
		}
		
	}