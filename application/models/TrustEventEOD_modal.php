<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class TrustEventEOD_modal extends CI_Model{
		//TABLE
		var $table = 'TRUST_EVENT_RECEIPT';
		
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
			$sql = "SELECT `TEUC_ID`, `TEUC_BY_ID`, `BANK_BRANCH`, `ACCOUNT_NO`, `BANK_NAME`, `TEUC_BY_NAME`, `TEUC_EOD_DATE`, `TEUC_CREDIT`, `TEUC_CASH`, `TEUC_CHEQUE`, `TEUC_DIRECT_CREDIT`, `TEUC_DEBIT_CREDIT_CARD`, `TEUC_CASH_CHEQUE`, `TEUC_CHEQUE_NO`, `TEUC_CHEQUE_DATE`, `TEUC_BANK_NAME`, `TEUC_BRANCH_NAME`, `TEUC_IS_DEPOSITED`, `TEUC_DEBIT`, `TEUC_CASH_DEPOSIT`, `TEUC_CHEQUE_DEPOSIT`, `TEUC_BANK_ID`, `TEUC_DATE_TIME`, `TEUC_DATE` , TEUC_EOD_DATE EOD, @RunningBal OpBal, COALESCE(TEUC_CASH_CHEQUE,0) Credit, COALESCE(TEUC_DEBIT,0) Debit, @RunningBal:= @RunningBal+COALESCE(TEUC_CASH_CHEQUE,0) - COALESCE(TEUC_DEBIT,0)  ClBal FROM trust_event_user_collection LEFT JOIN TRUST_EVENT_BANK ON TRUST_EVENT_USER_COLLECTION.TEUC_BANK_ID = TRUST_EVENT_BANK.BANK_ID, ( SELECT @RunningBal:=COALESCE(SUM(TEUC_CASH_CHEQUE),0) - COALESCE(SUM(TEUC_DEBIT),0)  Balance FROM trust_event_user_collection WHERE TEUC_DATE < '".$fromDate."' ) s WHERE (`TEUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') ORDER BY TEUC_ID DESC ";
						
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR GETTING EVENT  USER
		function count_get_all_field($fromDate, $toDate) {
		// changed the query by adithya
			// $sql = "SELECT `TEUC_ID`, 
			//                `TEUC_BY_ID`, 
			// 			   `BANK_BRANCH`, 
			// 			   `ACCOUNT_NO`, 
			// 			   `BANK_NAME`, 
			// 			   `TEUC_BY_NAME`, 
			// 			   `TEUC_EOD_DATE`, 
			// 			   `TEUC_CREDIT`, 
			// 			   `TEUC_CASH`, 
			// 			   `TEUC_CHEQUE`, 
			// 			   `TEUC_DIRECT_CREDIT`, 
			// 			   `TEUC_DEBIT_CREDIT_CARD`, 
			// 			   `TEUC_CASH_CHEQUE`, 
			// 			   `TEUC_CHEQUE_NO`, 
			// 			   `TEUC_CHEQUE_DATE`, 
			// 			   `TEUC_BANK_NAME`, 
			// 			   `TEUC_BRANCH_NAME`, 
			// 			   `TEUC_IS_DEPOSITED`, 
			// 			   `TEUC_DEBIT`, 
			// 			   `TEUC_CASH_DEPOSIT`, 
			// 			   `TEUC_CHEQUE_DEPOSIT`, 
			// 			   `TEUC_BANK_ID`, 
			// 			   `TEUC_DATE_TIME`, 
			// 			   `TEUC_DATE` , 
			// 			   TEUC_EOD_DATE EOD, @RunningBal OpBal, 
			// 			   COALESCE(TEUC_CASH_CHEQUE,0) Credit, 
			// 			   COALESCE(TEUC_DEBIT,0) Debit, 
			// 			   @RunningBal:= @RunningBal+COALESCE(TEUC_CASH_CHEQUE,0) - COALESCE(TEUC_DEBIT,0)  ClBal 
			// 			   FROM trust_event_user_collection 
			// 			   LEFT JOIN TRUST_EVENT_BANK ON 
			// 			   TRUST_EVENT_USER_COLLECTION.TEUC_BANK_ID = TRUST_EVENT_BANK.BANK_ID, ( 
			// 				SELECT @RunningBal:=COALESCE(SUM(TEUC_CASH_CHEQUE),0) - COALESCE(SUM(TEUC_DEBIT),0)  Balance 
			// 				FROM trust_event_user_collection WHERE 
			// 				TEUC_DATE < '".$fromDate."' ) s 
			// 				WHERE (`TEUC_DATE` BETWEEN '".$fromDate."' AND '".$toDate."') ORDER BY TEUC_ID DESC ";
        	// changed the query by adithya
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
			TEUC_EOD_DATE AS EOD,
			-- trust_event_user_collection.TEUC_RECEIPT_ID,
			trust_event_receipt.TET_RECEIPT_CATEGORY_ID,
			trust_event_receipt.TET_RECEIPT_NO,
			trust_event_receipt.TET_RECEIPT_NAME,
			trust_event_user_collection.TEUC_RECEIPT_ID,
			trust_event_receipt_category.TET_RECEIPT_CATEGORY_TYPE
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
			TEUC_ID ASC ";
			$query = $this->db->query($sql);
			return $query->num_rows();
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
		function get_total_amount($condition = array(),$whereOne, $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('(SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE');
			$this->db->from($this->table);
			if ($condition) {
				$this->db->where($condition);
				$this->db->where($whereOne);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->order_by('TET_RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();
			} else {
				return array();
			}
		}
		
		//FOR GETTING EVENT  USER
		function get_all_field_pagination($fromDate, $toDate, $num = 30, $start = 0) {
			$sql ="SELECT 
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
			TEUC_EOD_DATE AS EOD,
			-- trust_event_user_collection.TEUC_RECEIPT_ID,
			trust_event_receipt.TET_RECEIPT_CATEGORY_ID,
			trust_event_receipt.TET_RECEIPT_NO,
			trust_event_receipt.TET_RECEIPT_NAME,
			trust_event_user_collection.TEUC_RECEIPT_ID,
			trust_event_receipt_category.TET_RECEIPT_CATEGORY_TYPE
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

			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->order_by('TET_RECEIPT_ID', 'desc');
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR RECEIPT REPORT COUNT
		function count_rows_receipt_report($condition=array(),$whereOne, $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->table);
			if($condition){
				$this->db->where($condition);
				$this->db->where($whereOne);
			}
			
			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->order_by('TET_RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR EVENT RECEIPT REPORT
		function get_all_field_eod_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0,$fDate,$tDate) {
			$sql = "SELECT `TET_RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, 
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
					(SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount
					FROM TRUST_EVENT_RECEIPT INNER JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID where TET_ACTIVE = 1 and TET_RECEIPT_ISSUED_BY_ID = '".$_SESSION['userId']." and TET_RECEIPT_CATEGORY_ID != 4' and TET_RECEIPT_ACTIVE = 1 and STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'
					GROUP BY `TET_RECEIPT_DATE` ORDER BY STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') DESC limit $start, $num";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR EVENT SEVA REPORT COUNT
		function count_all_field_eod_report($condition=array(), $fDate, $tDate, $order_by_field = '', $order_by_type = "asc"){
				$sql = "SELECT `TET_RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME,  
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
					(SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount
					FROM TRUST_EVENT_RECEIPT INNER JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID where TET_ACTIVE = 1 and TET_RECEIPT_ISSUED_BY_ID = '".$_SESSION['userId']." and TET_RECEIPT_CATEGORY_ID != 4' and TET_RECEIPT_ACTIVE = 1 and STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'
					GROUP BY `TET_RECEIPT_DATE`";
			// echo $sql;
			$query = $this->db->query($sql);
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR EVENT RECEIPT REPORT
		function get_all_field_eod_report_admin($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0, $fDate, $tDate) {
			$sql = "SELECT `TET_RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_DATE, EOD_CONFIRMED_BY_NAME, 
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
					(SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount
					FROM TRUST_EVENT_RECEIPT INNER JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID where TET_ACTIVE = 1 and TET_RECEIPT_CATEGORY_ID != 4 and TET_RECEIPT_ACTIVE = 1  and STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."' GROUP BY `TET_RECEIPT_DATE` ORDER BY STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') DESC limit $start, $num";
			// echo $sql;
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			} 
		}
		
		//FOR EVENT SEVA REPORT COUNT
		function count_all_field_eod_report_admin($condition=array(), $fDate, $tDate, $order_by_field = '', $order_by_type = "asc"){
				$sql = "SELECT `TET_RECEIPT_DATE`, EOD_CONFIRMED_DATE_TIME,EOD_CONFIRMED_DATE, EOD_CONFIRMED_BY_NAME, 
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',
					(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
					(SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount
					FROM TRUST_EVENT_RECEIPT INNER JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID where TET_ACTIVE = 1 and TET_RECEIPT_CATEGORY_ID != 4 and TET_RECEIPT_ACTIVE = 1  and STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."' GROUP BY `TET_RECEIPT_DATE`";
			
			$query = $this->db->query($sql);
			$row=$query->num_rows();
			return $row;
		}
	}
