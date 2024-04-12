<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class TrustEOD_modal extends CI_Model {
		//TABLE
		var $table = 'TRUST_RECEIPT';
		
		public function __Construct() {
			parent::__construct();
			$this->load->database();
		}
		
		//FOR APPROVE THE AUTHORISE
		function update_authorise($condition=array(),$data_array=array()) {
			if($condition){
				$this->db->where($condition);
			}
			
			if($this->db->update($this->table,$data_array)){
				return true;
			} else {
				return false;
			}
		}
		
		//FOR GETTING TRUST USER
		function get_all_field($fromDate, $toDate) {
			$sql = "SELECT `TUC_ID`, `TUC_BY_ID`, `BANK_BRANCH`, `ACCOUNT_NO`, `BANK_NAME`, `TUC_BY_NAME`, `TUC_EOD_DATE`, `TUC_CREDIT`, `TUC_CASH`, `TUC_CHEQUE`, `TUC_DIRECT_CREDIT`, `TUC_DEBIT_CREDIT_CARD`, `TUC_CASH_CHEQUE`, `TUC_CHEQUE_NO`, `TUC_CHEQUE_DATE`, `TUC_BANK_NAME`, `TUC_BRANCH_NAME`, `TUC_IS_DEPOSITED`, `TUC_DEBIT`, `TUC_CASH_DEPOSIT`, `TUC_CHEQUE_DEPOSIT`, `TUC_BANK_ID`, `TUC_DATE_TIME`, `TUC_DATE` , TUC_EOD_DATE EOD, @RunningBal OpBal, COALESCE(TUC_CASH_CHEQUE,0) Credit,   COALESCE(TUC_DEBIT,0) Debit, @RunningBal:= @RunningBal+COALESCE(TUC_CASH_CHEQUE,0) - COALESCE(TUC_DEBIT,0)  ClBal FROM trust_user_collection LEFT JOIN TRUST_BANK ON TRUST_USER_COLLECTION.TUC_BANK_ID = TRUST_BANK.BANK_ID, ( SELECT @RunningBal:=COALESCE(SUM(TUC_CASH_CHEQUE),0) - COALESCE(SUM(TUC_DEBIT),0)  Balance FROM trust_user_collection WHERE TUC_DATE < '".$fromDate."' ) s WHERE (`TUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') ORDER BY TUC_ID DESC ";
						
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR GETTING TRUST USER
		function count_get_all_field($fromDate, $toDate) {
			// changed the code by adithya 
			$sql = "SELECT `TUC_ID`,  
			               `TUC_BY_ID`, 
						   `TUC_BY_NAME`, 
						   `TUC_EOD_DATE`,
						   `TUC_CHEQUE`,
						   `TUC_CHEQUE_NO`, 
						   `TUC_CHEQUE_DATE`, 
						   `TUC_BANK_NAME`, 
						   `TUC_BRANCH_NAME`, 
						   `TUC_IS_DEPOSITED`,
						   `TUC_LEDGER_ID`,
						   `TUC_DATE_TIME`, 
						   `TUC_DATE`, 
						   TUC_EOD_DATE EOD,
						   trust_user_collection.TUC_RECEIPT_ID,
						   trust_receipt.FH_ID,
						   trust_receipt.FH_NAME,
						   trust_receipt.RECEIPT_NAME,
						   trust_receipt.TR_ID
				FROM trust_user_collection 
				JOIN trust_receipt ON 
				trust_user_collection.TUC_RECEIPT_ID = trust_receipt.TR_ID 
				JOIN financial_head 
				ON trust_receipt.FH_ID = financial_head.FH_ID 
				WHERE (`TUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') 
				AND TUC_IS_DEPOSITED != 1 ORDER BY TUC_ID ASC";

			// $sql = "SELECT `TUC_ID`, 
			//        `TUC_BY_ID`, 
			// 	   `BANK_BRANCH`, 
			// 	   `ACCOUNT_NO`, 
			// 	   `BANK_NAME`, 
			// 	   `TUC_BY_NAME`, 
			// 	   `TUC_EOD_DATE`, 
			// 	   `TUC_CREDIT`, 
			// 	   `TUC_CASH`, 
			// 	   `TUC_CHEQUE`, 
			// 	   `TUC_DIRECT_CREDIT`, 
			// 	   `TUC_DEBIT_CREDIT_CARD`, 
			// 	   `TUC_CASH_CHEQUE`, 
			// 	   `TUC_CHEQUE_NO`, 
			// 	   `TUC_CHEQUE_DATE`, 
			// 	   `TUC_BANK_NAME`, 
			// 	   `TUC_BRANCH_NAME`, 
			// 	   `TUC_IS_DEPOSITED`, 
			// 	   `TUC_DEBIT`, 
			// 	   `TUC_CASH_DEPOSIT`, 
			// 	   `TUC_CHEQUE_DEPOSIT`, 
			// 	   `TUC_BANK_ID`, 
			// 	   `TUC_DATE_TIME`, 
			// 	   `TUC_DATE` , 
			// 	   TUC_EOD_DATE EOD, 
			// 	   @RunningBal OpBal,
			// 	    COALESCE(TUC_CASH_CHEQUE,0) Credit,  
			// 		 COALESCE(TUC_DEBIT,0) Debit,
			// 		  @RunningBal:= @RunningBal+COALESCE(TUC_CASH_CHEQUE,0) - COALESCE(TUC_DEBIT,0) 
			// 		   ClBal FROM trust_user_collection 
			// 		   LEFT JOIN TRUST_BANK ON TRUST_USER_COLLECTION.TUC_BANK_ID = TRUST_BANK.BANK_ID,
			// 		    ( SELECT @RunningBal:=COALESCE(SUM(TUC_CASH_CHEQUE),0) - COALESCE(SUM(TUC_DEBIT),0) 
			// 			 Balance 
			// 			 FROM trust_user_collection WHERE 
			// 			 TUC_DATE < '".$fromDate."' ) s 
			// 			 WHERE (`TUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') ORDER BY TUC_ID DESC ";
						
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//FOR RECEIPT REPORT
		function get_total_amount($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('SUM(FH_AMOUNT) AS PRICE');
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('FINANCIAL_HEAD', 'TRUST_RECEIPT.FH_ID = FINANCIAL_HEAD.FH_ID');
			$this->db->order_by('TR_ID', 'desc');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();
			} else {
				return array();
			}
		}
		
		//FOR GETTING TRUST USER
		function get_all_field_pagination($fromDate, $toDate, $num = 30, $start = 0) {
			$sql = "SELECT `TUC_ID`,  
			               `TUC_BY_ID`, 
						   `TUC_BY_NAME`, 
						   `TUC_EOD_DATE`,
						   `TUC_CHEQUE`,
						   `TUC_CHEQUE_NO`, 
						   `TUC_CHEQUE_DATE`, 
						   `TUC_BANK_NAME`, 
						   `TUC_BRANCH_NAME`, 
						   `TUC_IS_DEPOSITED`,
						   `TUC_LEDGER_ID`,
						   `TUC_DATE_TIME`, 
						   `TUC_DATE`, 
						   TUC_EOD_DATE EOD,
						   trust_user_collection.TUC_RECEIPT_ID,
						   trust_receipt.FH_ID,
						   trust_receipt.FH_NAME,
						   trust_receipt.RECEIPT_NAME,
						   trust_receipt.TR_ID
				FROM trust_user_collection 
				JOIN trust_receipt ON 
				trust_user_collection.TUC_RECEIPT_ID = trust_receipt.TR_ID 
				JOIN financial_head 
				ON trust_receipt.FH_ID = financial_head.FH_ID 
				WHERE 
				(`TUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') 
				AND TUC_IS_DEPOSITED != 1 ORDER BY TUC_ID ASC";	
				// echo $sql;
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		//get fiancial month
		function get_finMth(){
		   $this->db->select('MONTH_IN_NUMBER');
		   $this->db->from('FINANCIAL_YEAR');
		   $query = $this->db->get();
		   if($query->num_rows()>0)
		   return $query->first_row();
		}
		
		//FOR RECEIPT REPORT
		function get_all_field_receipt_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('FINANCIAL_HEAD', 'TRUST_RECEIPT.FH_ID = FINANCIAL_HEAD.FH_ID');
			$this->db->order_by('TR_ID', 'desc');
			$this->db->limit($num, $start);
			
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
			
			$this->db->join('FINANCIAL_HEAD', 'TRUST_RECEIPT.FH_ID = FINANCIAL_HEAD.FH_ID');
			$this->db->order_by('TR_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR EVENT RECEIPT REPORT
		function get_all_field_eod_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$sql = "SELECT `RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, 
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `FH_AMOUNT` ELSE '' END ) AS Cash ,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `FH_AMOUNT` ELSE '' END ) AS Cheque,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `FH_AMOUNT` ELSE '' END ) AS 'Card',
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `FH_AMOUNT` ELSE '' END ) AS 'directCredit',
					SUM(FH_AMOUNT) AS TotalAmount
					FROM TRUST_RECEIPT where ENTERED_BY = '".$_SESSION['userId']."' and TR_ACTIVE = 1
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
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `FH_AMOUNT` ELSE '' END ) AS Cash ,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `FH_AMOUNT` ELSE '' END ) AS Cheque,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `FH_AMOUNT` ELSE '' END ) AS 'Card',
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `FH_AMOUNT` ELSE '' END ) AS 'directCredit',
					SUM(FH_AMOUNT) AS TotalAmount
					FROM TRUST_RECEIPT where ENTERED_BY = '".$_SESSION['userId']."' and TR_ACTIVE = 1
					GROUP BY `RECEIPT_DATE`";
			
			$query = $this->db->query($sql);
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR EVENT RECEIPT REPORT
		function get_all_field_eod_report_admin($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$sql = "SELECT `RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_DATE, EOD_CONFIRMED_BY_NAME, 
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `FH_AMOUNT` ELSE '' END ) AS Cash ,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `FH_AMOUNT` ELSE '' END ) AS Cheque,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `FH_AMOUNT` ELSE '' END ) AS 'CreditDebitCard',
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `FH_AMOUNT` ELSE '' END ) AS 'DirectCredit',
					SUM(FH_AMOUNT) AS TotalAmount
					FROM TRUST_RECEIPT where RECEIPT_CATEGORY_ID!=4 AND TR_ACTIVE = 1 GROUP BY `RECEIPT_DATE` ORDER BY STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') DESC limit $start, $num";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR EVENT SEVA REPORT COUNT
		function count_all_field_eod_report_admin($condition=array(), $order_by_field = '', $order_by_type = "asc"){
				$sql = "SELECT `RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME,EOD_CONFIRMED_DATE, EOD_CONFIRMED_BY_NAME, 
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `FH_AMOUNT` ELSE '' END ) AS Cash ,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `FH_AMOUNT` ELSE '' END ) AS Cheque,
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `FH_AMOUNT` ELSE '' END ) AS 'CreditDebitCard',
					SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `FH_AMOUNT` ELSE '' END ) AS 'DirectCredit',
					SUM(FH_AMOUNT) AS TotalAmount
					FROM TRUST_RECEIPT where TR_ACTIVE = 1 GROUP BY `RECEIPT_DATE`";
			
			$query = $this->db->query($sql);
			$row=$query->num_rows();
			return $row;
		}
	}
