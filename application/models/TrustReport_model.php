<?php
	class TrustReport_model extends CI_Model {
		//TABLE NAME
		var $table = 'FINANCIAL_HEAD';
		var $tableEvent = 'TRUST_EVENT';
		var $tableEventReceipt = 'TRUST_EVENT_RECEIPT';
		var $tableEventOffered = 'TRUST_EVENT_SEVA_OFFERED';
		var $tableTrustReceipt = 'TRUST_RECEIPT';
		var $tableHallBookingList = 'TRUST_HALL_BOOKING_LIST';
		var $tableAuctionItem = 'TRUST_AUCTION_ITEM_LIST';
		var $tableAuction = 'TRUST_AUCTION_RECEIPT';

		public function __Construct() {
			parent::__construct();
			$this->load->database();
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
			$this->db->join('TRUST_BID_ITEM_LIST', 'TRUST_AUCTION_RECEIPT.BIL_ID = TRUST_BID_ITEM_LIST.BIL_ID');
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}


		//FOR AUCTION REPORT COUNT
		function count_rows_auction_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableAuction);
			if($condition){
				$this->db->where($condition);
			}
			
			$this->db->join('TRUST_BID_ITEM_LIST', 'TRUST_AUCTION_RECEIPT.BIL_ID = TRUST_BID_ITEM_LIST.BIL_ID');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}

		//FOR AUCTION REPORT
		function get_total_amount_payment_mode($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('SUM(AR_BID_PRICE) AS PRICE');
			$this->db->from($this->tableAuction);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('TRUST_BID_ITEM_LIST', 'TRUST_AUCTION_RECEIPT.BIL_ID = TRUST_BID_ITEM_LIST.BIL_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();
			} else {
				return array();
			}
		}

		//FOR AUCTION RECEIPT REPORT COUNT
		function count_rows_auction_item_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableAuctionItem);
			if($condition){
				$this->db->where($condition);
			}
			
			$query = $this->db->get();
			$row = $query->num_rows();
			return $row;
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

		//FOR AUCTION REPORT EXCEL
		function get_auction_report_excel($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableAuction);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			$this->db->join('TRUST_BID_ITEM_LIST', 'TRUST_AUCTION_RECEIPT.BIL_ID = TRUST_BID_ITEM_LIST.BIL_ID');
			
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
		
		//EVENT SUMMARY
		function get_all_field_event_sevas_summary($date,$etId) {
			$sql ="SELECT `TET_SO_SEVA_ID`, `TET_SO_SEVA_NAME`, SUM(TET_SO_QUANTITY) AS QTY, SUM(TET_SO_PRICE  * TET_SO_QUANTITY ) AS AMOUNT FROM `TRUST_EVENT_SEVA_OFFERED` LEFT JOIN `TRUST_EVENT_RECEIPT` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` LEFT JOIN `TRUST_EVENT` ON `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = `TRUST_EVENT`.`TET_ID` WHERE `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_IS_SEVA` = 1 AND `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_DATE` = '$date' AND `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = '$etId' AND `TRUST_EVENT`.TET_ACTIVE = 1 AND (`TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ACTIVE` = 1 OR `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = 0) GROUP BY `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_ID`";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR EVENT SEVA DETAILS SUMMARY
		function get_all_field_event_sevas_summary_details($date,$Id,$num = 10, $start = 0,$eId) {
			$sql = "SELECT `TET_RECEIPT_NO`,`TET_RECEIPT_NAME`,`TET_RECEIPT_PHONE`,`TET_SO_QUANTITY`,`TET_SO_PRICE`, `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` FROM `TRUST_EVENT_SEVA_OFFERED` LEFT JOIN `TRUST_EVENT_RECEIPT` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` LEFT JOIN `TRUST_EVENT` ON `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = `TRUST_EVENT`.`TET_ID` WHERE `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_IS_SEVA` = 1 AND `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_DATE` = '$date' AND `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = '$eId' AND `TRUST_EVENT`.TET_ACTIVE = 1 AND `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_ID` = '$Id' AND (`TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ACTIVE` = 1 OR `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = 0) LIMIT $start,$num";	
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR EVENT SEVA DETAILS SUMMARY PERIOD
		function get_all_field_event_sevas_summary_details_period($fromdate, $todate,$Id,$num = 10, $start = 0,$eId) {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT `TET_RECEIPT_NO`,`TET_RECEIPT_NAME`,`TET_RECEIPT_PHONE`,`TET_SO_QUANTITY`,`TET_SO_PRICE`, `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` FROM `TRUST_EVENT_SEVA_OFFERED` LEFT JOIN `TRUST_EVENT_RECEIPT` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` LEFT JOIN `TRUST_EVENT` ON `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = `TRUST_EVENT`.`TET_ID` WHERE `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_IS_SEVA` = 1 AND STR_TO_DATE(`TRUST_EVENT_SEVA_OFFERED`.`TET_SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = '$eId' AND `TRUST_EVENT`.TET_ACTIVE = 1 AND `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_ID` = '$Id' AND (`TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ACTIVE` = 1 OR `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = 0) LIMIT $start,$num";		
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR EVENT SEVA DETAILS SUMMARY COUNT PERIOD
		function count_event_sevas_summary_details_period($fromdate, $todate,$Id,$eId) {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT `TET_RECEIPT_NO`,`TET_RECEIPT_NAME`,`TET_RECEIPT_PHONE`,`TET_SO_QUANTITY`,`TET_SO_PRICE`, `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` FROM `TRUST_EVENT_SEVA_OFFERED` LEFT JOIN `TRUST_EVENT_RECEIPT` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` LEFT JOIN `TRUST_EVENT` ON `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = `TRUST_EVENT`.`TET_ID` WHERE `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_IS_SEVA` = 1 AND STR_TO_DATE(`TRUST_EVENT_SEVA_OFFERED`.`TET_SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = '$eId' AND `TRUST_EVENT`.TET_ACTIVE = 1 AND `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_ID` = '$Id' AND (`TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ACTIVE` = 1 OR `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = 0)";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//FOR EVENT SEVA DETAILS SUMMARY COUNT
		function count_event_sevas_summary_details($date,$Id,$eId) {
			$sql = "SELECT `TET_RECEIPT_NO`,`TET_RECEIPT_NAME`,`TET_RECEIPT_PHONE`,`TET_SO_QUANTITY`,`TET_SO_PRICE`, `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` FROM `TRUST_EVENT_SEVA_OFFERED` LEFT JOIN `TRUST_EVENT_RECEIPT` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` LEFT JOIN `TRUST_EVENT` ON `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = `TRUST_EVENT`.`TET_ID` WHERE `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_IS_SEVA` = 1 AND `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_DATE` = '$date' AND `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = '$eId' AND `TRUST_EVENT`.TET_ACTIVE = 1 AND `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_ID` = '$Id' AND (`TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ACTIVE` = 1 OR `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = 0)";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//FOR EVENT SEVA DETAILS SUMMARY PERIOD
		function get_all_field_event_sevas_summary_report_period($fromdate, $todate,$eId) {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT `TET_SO_SEVA_ID`, `TET_SO_SEVA_NAME`, SUM(TET_SO_QUANTITY) AS QTY, SUM(TET_SO_PRICE  * TET_SO_QUANTITY ) AS AMOUNT FROM `TRUST_EVENT_SEVA_OFFERED` LEFT JOIN `TRUST_EVENT_RECEIPT` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` LEFT JOIN `TRUST_EVENT` ON `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = `TRUST_EVENT`.`TET_ID` WHERE `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_IS_SEVA` = 1 AND STR_TO_DATE(`TRUST_EVENT_SEVA_OFFERED`.`TET_SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = '$eId' AND `TRUST_EVENT`.TET_ACTIVE = 1 AND (`TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ACTIVE` = 1 OR `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = 0) GROUP BY `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_ID`";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		function get_all_field_event_sevas_summary_details_period_excel($fromdate, $todate,$Id,$eId) {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT `TET_RECEIPT_NO`,`TET_RECEIPT_NAME`,`TET_RECEIPT_PHONE`,`TET_SO_QUANTITY`,`TET_SO_PRICE`, `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` FROM `TRUST_EVENT_SEVA_OFFERED` LEFT JOIN `TRUST_EVENT_RECEIPT` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` LEFT JOIN `TRUST_EVENT` ON `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = `TRUST_EVENT`.`TET_ID` WHERE `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_IS_SEVA` = 1 AND STR_TO_DATE(`TRUST_EVENT_SEVA_OFFERED`.`TET_SO_DATE`,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' AND `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = '$eId' AND `TRUST_EVENT`.TET_ACTIVE = 1 AND `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_ID` = '$Id' AND (`TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ACTIVE` = 1 OR `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = 0)";
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		function get_all_field_event_sevas_summary_details_excel($date,$Id,$eId) {
			$sql = "SELECT `TET_RECEIPT_NO`,`TET_RECEIPT_NAME`,`TET_RECEIPT_PHONE`,`TET_SO_QUANTITY`,`TET_SO_PRICE`, `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` FROM `TRUST_EVENT_SEVA_OFFERED` LEFT JOIN `TRUST_EVENT_RECEIPT` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` LEFT JOIN `TRUST_EVENT` ON `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = `TRUST_EVENT`.`TET_ID` WHERE `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_IS_SEVA` = 1 AND `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_DATE` = '$date' AND `TRUST_EVENT_RECEIPT`.`RECEIPT_TET_ID` = '$eId' AND `TRUST_EVENT`.TET_ACTIVE = 1 AND `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_ID` = '$Id' AND (`TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ACTIVE` = 1 OR `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = 0)";
			$query = $this->db->query($sql);
			return $query->result('array');
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

			$this->db->join('TRUST_EVENT_RECEIPT', 'TRUST_EVENT_SEVA_OFFERED.TET_RECEIPT_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_ID');
			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		function get_all_field_trust_day_book_excel($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc") {
			
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT * FROM
							(SELECT trust_receipt.TR_ID as rId, 
									CONCAT('Trust',IF(HB_ID IS NULL,'',' (Hall)')) as receiptFor,
									TR_NO as rNo, 
									RECEIPT_DATE as rDate, 
									trust_receipt.FH_ID as rCatId,
									(SELECT FH_NAME FROM financial_head WHERE FH_ID = trust_receipt.FH_ID) AS rType, 
									'' as sevaName,
									'' as dtetName,
									RECEIPT_NAME as rName,
									RECEIPT_PAYMENT_METHOD as rPayMethod,
									'' as qty,
									FH_AMOUNT as amt,
									'' as amtPostage,
									FH_AMOUNT as total,
									ENTERED_BY_NAME  as user,
									PAYMENT_STATUS as status, 
									CANCEL_NOTES as cnclNotes,
									trust_receipt.DATE_TIME as dttime ,'-' as sevaQty,TR_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							 FROM trust_receipt WHERE PAYMENT_STATUS != 'Cancelled' AND STR_TO_DATE(RECEIPT_DATE ,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')       
							 UNION ALL   
							 SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate, 
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID  as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   trust_event_seva_offered.TET_SO_QUANTITY as qty, 
								   trust_event_seva_offered.TET_SO_PRICE as amt, 
								   '' as amtPostage, 
								   trust_event_seva_offered.TET_SO_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,TET_SO_QUANTITY as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc  
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID  = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID  = trust_event.TET_ID 
							WHERE PAYMENT_STATUS != 'Cancelled' AND STR_TO_DATE(TET_RECEIPT_DATE ,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 
							UNION ALL 
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,							   
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt, 
								   POSTAGE_PRICE as amtPostage, 
								   POSTAGE_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime ,TET_SO_QUANTITY as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc 
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID 
							WHERE PAYMENT_STATUS != 'Cancelled' AND STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0
							GROUP BY trust_event_receipt.TET_RECEIPT_ID 	
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,	
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   '' as sevaName,
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   TET_RECEIPT_PRICE as amt,
								   POSTAGE_PRICE as amtPostage,
								   (TET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime ,1 as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							FROM trust_event_receipt
							INNER JOIN trust_event ON trust_event.TET_ID = trust_event_receipt.RECEIPT_TET_ID
							WHERE PAYMENT_STATUS != 'Cancelled' AND STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							(trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 2 OR trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 3) 
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime ,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE PAYMENT_STATUS != 'Cancelled' AND STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
			} else  {
				$query = "SELECT * FROM
							(SELECT trust_receipt.TR_ID as rId, 
									CONCAT('Trust',IF(HB_ID IS NULL,'',' (Hall)')) as receiptFor,
									TR_NO as rNo, 
									RECEIPT_DATE as rDate, 
									trust_receipt.FH_ID as rCatId,
									(SELECT FH_NAME FROM financial_head WHERE FH_ID = trust_receipt.FH_ID) AS rType, 
									'' as sevaName,
									'' as dtetName,
									RECEIPT_NAME as rName,
									RECEIPT_PAYMENT_METHOD as rPayMethod,
									'' as qty,
									FH_AMOUNT as amt,
									'' as amtPostage,
									FH_AMOUNT as total,
									ENTERED_BY_NAME  as user,
									PAYMENT_STATUS as status, 
									CANCEL_NOTES as cnclNotes,
									trust_receipt.DATE_TIME as dttime,'-' as sevaQty ,TR_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							 FROM trust_receipt WHERE PAYMENT_STATUS != 'Cancelled' AND STR_TO_DATE(RECEIPT_DATE ,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')
							 UNION ALL   
							 SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate, 
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID  as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   trust_event_seva_offered.TET_SO_QUANTITY as qty,
								   trust_event_seva_offered.TET_SO_PRICE as amt, 
								   '' as amtPostage, 
								   trust_event_seva_offered.TET_SO_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime ,TET_SO_QUANTITY as sevaQty  ,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID  = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID  = trust_event.TET_ID 
							WHERE PAYMENT_STATUS != 'Cancelled' AND STR_TO_DATE(TET_RECEIPT_DATE ,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 
							UNION ALL 
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,							   
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   '' as qty,
								   '' as amt, 
								   POSTAGE_PRICE as amtPostage, 
								   POSTAGE_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime ,TET_SO_QUANTITY as sevaQty ,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID 
							WHERE PAYMENT_STATUS != 'Cancelled' AND STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0
							GROUP BY trust_event_receipt.TET_RECEIPT_ID	
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,	
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   '' as sevaName,
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   TET_RECEIPT_PRICE as amt,
								   POSTAGE_PRICE as amtPostage,
								   (TET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime ,1 as sevaQty ,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							FROM trust_event_receipt
							INNER JOIN trust_event ON trust_event.TET_ID = trust_event_receipt.RECEIPT_TET_ID
							WHERE PAYMENT_STATUS != 'Cancelled' AND STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							(trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 2 OR trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 3) 
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime ,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE PAYMENT_STATUS != 'Cancelled' AND STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
			}		
			
			$resQuery = $this->db->query($query);
			if ($resQuery->num_rows() > 0) {
				return $resQuery->result();
			} else {
				return array();
			}
		}
		
		// Function to get Cash, Cheque, Credit/Debit, Direct Credit
		function get_all_field_trust_day_book_account_summary($fromDate = "", $toDate = "") {
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT (COALESCE((SELECT SUM(FH_AMOUNT) FROM trust_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Cash' AND TR_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM trust_event_receipt WHERE TET_RECEIPT_PAYMENT_METHOD = 'Cash' AND TET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) AS CASH,
								 (COALESCE((SELECT SUM(FH_AMOUNT) FROM trust_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Cheque' AND TR_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM trust_event_receipt WHERE TET_RECEIPT_PAYMENT_METHOD = 'Cheque' AND TET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) AS CHEQUE,
								 (COALESCE((SELECT SUM(FH_AMOUNT) FROM trust_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Direct Credit' AND TR_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM trust_event_receipt WHERE TET_RECEIPT_PAYMENT_METHOD = 'Direct Credit' AND TET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) AS DIRECTCREDIT,
								 (COALESCE((SELECT SUM(FH_AMOUNT) FROM trust_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' AND TR_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM trust_event_receipt WHERE TET_RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' AND TET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) AS CREDITDEBIT,
								 (COALESCE((SELECT SUM(FH_AMOUNT) FROM trust_receipt WHERE TR_ACTIVE = 1 AND  STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM trust_event_receipt WHERE TET_RECEIPT_ACTIVE = 1 AND  STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')),0)) AS GRANDTOTAL";
			} else {
				$query = "SELECT (COALESCE((SELECT SUM(FH_AMOUNT) FROM trust_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Cash' AND TR_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM trust_event_receipt WHERE TET_RECEIPT_PAYMENT_METHOD = 'Cash' AND TET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) AS CASH,
								 (COALESCE((SELECT SUM(FH_AMOUNT) FROM trust_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Cheque' AND TR_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM trust_event_receipt WHERE TET_RECEIPT_PAYMENT_METHOD = 'Cheque' AND TET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) AS CHEQUE,
								 (COALESCE((SELECT SUM(FH_AMOUNT) FROM trust_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Direct Credit' AND TR_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM trust_event_receipt WHERE TET_RECEIPT_PAYMENT_METHOD = 'Direct Credit' AND TET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) AS DIRECTCREDIT,
								 (COALESCE((SELECT SUM(FH_AMOUNT) FROM trust_receipt WHERE RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' AND TR_ACTIVE = 1 AND STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM trust_event_receipt WHERE TET_RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' AND TET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) AS CREDITDEBIT,
								 (COALESCE((SELECT SUM(FH_AMOUNT) FROM trust_receipt WHERE TR_ACTIVE = 1 AND  STR_TO_DATE(`RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) + (COALESCE((SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) FROM trust_event_receipt WHERE TET_RECEIPT_ACTIVE = 1 AND  STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')),0)) AS GRANDTOTAL";
			}
			
			$resQuery = $this->db->query($query);
			
			if ($resQuery->num_rows() > 0) {
				return $resQuery->row();
			} else {
				return array();
			}
			
			return $query;
		}

		//FOR DEITY RECEIPT REPORT
		function get_all_field_trust_day_book($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT * FROM
							(SELECT trust_receipt.TR_ID as rId, 
									CONCAT('Trust',IF(HB_ID IS NULL,'',' (Hall)')) as receiptFor,
									TR_NO as rNo, 
									RECEIPT_DATE as rDate, 
									trust_receipt.FH_ID as rCatId,
									IF(trust_receipt.FH_ID = 0,'Trust Inkind',(SELECT FH_NAME FROM financial_head WHERE FH_ID = trust_receipt.FH_ID)) AS rType,
									'' as sevaName,
									'' as dtetName,
									RECEIPT_NAME as rName,
									RECEIPT_PAYMENT_METHOD as rPayMethod,
									'' as qty,
									FH_AMOUNT as amt,
									'' as amtPostage,
									FH_AMOUNT as total,
									ENTERED_BY_NAME  as user,
									PAYMENT_STATUS as status, 
									CANCEL_NOTES as cnclNotes,
									trust_receipt.DATE_TIME as dttime ,'-' as sevaQty,TR_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							 FROM trust_receipt WHERE STR_TO_DATE(RECEIPT_DATE ,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')       
							 UNION ALL   
							 SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate, 
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID  as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   trust_event_seva_offered.TET_SO_QUANTITY as qty,
								   trust_event_seva_offered.TET_SO_PRICE as amt, 
								   '' as amtPostage, 
								   trust_event_seva_offered.TET_SO_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,TET_SO_QUANTITY as sevaQty ,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID  = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID  = trust_event.TET_ID 
							WHERE STR_TO_DATE(TET_RECEIPT_DATE ,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 
							UNION ALL 
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,							   
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   '' as qty,
								   '' as amt, 
								   POSTAGE_PRICE as amtPostage, 
								   POSTAGE_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime ,TET_SO_QUANTITY as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc 
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID 
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0 
							GROUP BY trust_event_receipt.TET_RECEIPT_ID 	
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,	
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   '' as sevaName,
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   TET_RECEIPT_PRICE as amt,
								   POSTAGE_PRICE as amtPostage,
								   (TET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,1 as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							FROM trust_event_receipt
							INNER JOIN trust_event ON trust_event.TET_ID = trust_event_receipt.RECEIPT_TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							(trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 2 OR trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 3) 
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC limit ".$start.",".$num;
			} else  {
				$query = "SELECT * FROM
							(SELECT trust_receipt.TR_ID as rId, 
									CONCAT('Trust',IF(HB_ID IS NULL,'',' (Hall)')) as receiptFor,
									TR_NO as rNo, 
									RECEIPT_DATE as rDate, 
									trust_receipt.FH_ID as rCatId,
									IF(trust_receipt.FH_ID = 0,'Trust Inkind',(SELECT FH_NAME FROM financial_head WHERE FH_ID = trust_receipt.FH_ID)) AS rType, 
									'' as sevaName,
									'' as dtetName,
									RECEIPT_NAME as rName,
									RECEIPT_PAYMENT_METHOD as rPayMethod,
									'' as qty,
									FH_AMOUNT as amt,
									'' as amtPostage,
									FH_AMOUNT as total,
									ENTERED_BY_NAME  as user,
									PAYMENT_STATUS as status, 
									CANCEL_NOTES as cnclNotes,
									trust_receipt.DATE_TIME as dttime ,'-' as sevaQty,TR_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							 FROM trust_receipt WHERE STR_TO_DATE(RECEIPT_DATE ,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')
							 UNION ALL   
							 SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate, 
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID  as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   trust_event_seva_offered.TET_SO_QUANTITY as qty,
								   trust_event_seva_offered.TET_SO_PRICE as amt, 
								   '' as amtPostage, 
								   trust_event_seva_offered.TET_SO_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,TET_SO_QUANTITY as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc  
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID  = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID  = trust_event.TET_ID 
							WHERE STR_TO_DATE(TET_RECEIPT_DATE ,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 
							UNION ALL 
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,							   
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   '' as qty,
								   '' as amt, 
								   POSTAGE_PRICE as amtPostage, 
								   POSTAGE_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime ,TET_SO_QUANTITY as sevaQty ,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID 
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0  
							GROUP BY trust_event_receipt.TET_RECEIPT_ID 	
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,	
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   '' as sevaName,
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   TET_RECEIPT_PRICE as amt,
								   POSTAGE_PRICE as amtPostage,
								   (TET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,1 as sevaQty ,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,'-' as apprxAmt,'-' as itemDesc
							FROM trust_event_receipt
							INNER JOIN trust_event ON trust_event.TET_ID = trust_event_receipt.RECEIPT_TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							(trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 2 OR trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 3) 
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC limit ".$start.",".$num;
			}		
			
			$resQuery = $this->db->query($query);

			if ($resQuery->num_rows() > 0) {
				return $resQuery->result();
			} else {
				return array();
			}
		}

		//FOR DEITY RECEIPT REPORT
		function count_all_field_trust_day_book($fromDate = "", $toDate = "") {
			
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT COUNT(*) AS CNT_DAY_BOOK FROM
							(SELECT trust_receipt.TR_ID as rId, 
									CONCAT('Trust',IF(HB_ID IS NULL,'',' (Hall)')) as receiptFor,
									TR_NO as rNo, 
									RECEIPT_DATE as rDate, 
									trust_receipt.FH_ID as rCatId,
									IF(trust_receipt.FH_ID = 0,'Trust Inkind',(SELECT FH_NAME FROM financial_head WHERE FH_ID = trust_receipt.FH_ID)) AS rType, 
									'' as sevaName,
									'' as dtetName,
									RECEIPT_NAME as rName,
									RECEIPT_PAYMENT_METHOD as rPayMethod,
									FH_AMOUNT as amt,
									'' as amtPostage,
									FH_AMOUNT as total,
									ENTERED_BY_NAME  as user,
									PAYMENT_STATUS as status, 
									CANCEL_NOTES as cnclNotes,
									trust_receipt.DATE_TIME as dttime 
							 FROM trust_receipt WHERE STR_TO_DATE(RECEIPT_DATE ,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')       
							 UNION ALL   
							 SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate, 
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID  as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   trust_event_seva_offered.TET_SO_PRICE as amt, 
								   '' as amtPostage, 
								   trust_event_seva_offered.TET_SO_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime 
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID  = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID  = trust_event.TET_ID 
							WHERE STR_TO_DATE(TET_RECEIPT_DATE ,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 
							UNION ALL 
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,							   
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   '' as amt, 
								   POSTAGE_PRICE as amtPostage, 
								   POSTAGE_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime 
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID 
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0 
							GROUP BY trust_event_receipt.TET_RECEIPT_ID 	
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,	
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   '' as sevaName,
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   TET_RECEIPT_PRICE as amt,
								   POSTAGE_PRICE as amtPostage,
								   (TET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime 
							FROM trust_event_receipt
							INNER JOIN trust_event ON trust_event.TET_ID = trust_event_receipt.RECEIPT_TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							(trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 2 OR trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 3) 
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime 
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
			} else  {
				$query = "SELECT COUNT(*) AS CNT_DAY_BOOK FROM
							(SELECT trust_receipt.TR_ID as rId, 
									CONCAT('Trust',IF(HB_ID IS NULL,'',' (Hall)')) as receiptFor,
									TR_NO as rNo, 
									RECEIPT_DATE as rDate, 
									trust_receipt.FH_ID as rCatId,
									IF(trust_receipt.FH_ID = 0,'Trust Inkind',(SELECT FH_NAME FROM financial_head WHERE FH_ID = trust_receipt.FH_ID)) AS rType, 
									'' as sevaName,
									'' as dtetName,
									RECEIPT_NAME as rName,
									RECEIPT_PAYMENT_METHOD as rPayMethod,
									FH_AMOUNT as amt,
									'' as amtPostage,
									FH_AMOUNT as total,
									ENTERED_BY_NAME  as user,
									PAYMENT_STATUS as status, 
									CANCEL_NOTES as cnclNotes,
									trust_receipt.DATE_TIME as dttime 
							 FROM trust_receipt WHERE STR_TO_DATE(RECEIPT_DATE ,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y')
							 UNION ALL   
							 SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate, 
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID  as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   trust_event_seva_offered.TET_SO_PRICE as amt, 
								   '' as amtPostage, 
								   trust_event_seva_offered.TET_SO_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime 
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID  = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID  = trust_event.TET_ID 
							WHERE STR_TO_DATE(TET_RECEIPT_DATE ,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 
							UNION ALL 
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId, 
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,							   
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   trust_event_seva.TET_SEVA_NAME as sevaName, 
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod, 
								   '' as amt, 
								   POSTAGE_PRICE as amtPostage, 
								   POSTAGE_PRICE as total, 
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime 
							FROM trust_event_seva_offered  
							INNER JOIN trust_event_receipt ON trust_event_seva_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID 
							INNER JOIN trust_event_seva ON trust_event_seva_offered.TET_SO_SEVA_ID = trust_event_seva.TET_SEVA_ID 
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID 
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 1 AND POSTAGE_PRICE > 0   
							GROUP BY trust_event_receipt.TET_RECEIPT_ID 	
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo, 
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,	
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType, 
								   '' as sevaName,
								   trust_event.TET_NAME as dtetName, 
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   TET_RECEIPT_PRICE as amt,
								   POSTAGE_PRICE as amtPostage,
								   (TET_RECEIPT_PRICE + POSTAGE_PRICE) AS total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime 
							FROM trust_event_receipt
							INNER JOIN trust_event ON trust_event.TET_ID = trust_event_receipt.RECEIPT_TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							(trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 2 OR trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 3) 
							UNION ALL
							SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime 
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
			}
			
			$resQuery = $this->db->query($query);			
			return $resQuery->row()->CNT_DAY_BOOK;
			
		}

		//FOR EVENT SEVA OFFERED REPORT
		function get_all_field_seva_report($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->distinct();
			$this->db->select('TET_SO_SEVA_NAME, TET_SO_SEVA_ID');
			$this->db->from($this->tableEventOffered);
			if ($condition) { 
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->join('TRUST_EVENT_RECEIPT', 'TRUST_EVENT_SEVA_OFFERED.TET_RECEIPT_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_ID');
			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
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

			$this->db->join('TRUST_EVENT_RECEIPT', 'TRUST_EVENT_SEVA_OFFERED.TET_RECEIPT_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_ID');
			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
	
		//FOR EVENT RECEIPT EXCEL
		function get_all_field_event_receipt_excel($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableEventReceipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			$this->db->join('trust_event_inkind_offered', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_ID = trust_event_inkind_offered.TET_RECEIPT_ID','left');
			$this->db->order_by('TRUST_EVENT_RECEIPT.TET_RECEIPT_ID', 'desc');

			// $this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			// $this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			// $this->db->order_by('TET_RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
	
		//FOR APPROVE THE AUTHORISE
		function update_authorise($condition=array(),$data_array=array()){
			if($condition){
				$this->db->where($condition);
			}
			
			if($this->db->update($this->tableEventReceipt,$data_array)){
				return true;
			} else {
				return false;
			}
		}
	
		//FOR EVENT RECEIPT REPORT COUNT
		function count_rows_receipt_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableEventReceipt);
			if($condition){
				$this->db->where($condition);
			}
			
			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			$this->db->join('trust_event_inkind_offered', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_ID = trust_event_inkind_offered.TET_RECEIPT_ID','left');
			$this->db->order_by('TRUST_EVENT_RECEIPT.TET_RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}

		//for cancelled count
		function cancelled_count_rows_receipt_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableEventReceipt);
			if($condition){
				$this->db->where($condition);
			}
			
			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			$this->db->order_by('TET_RECEIPT_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
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
			$this->db->join('TRUST_EVENT_RECEIPT', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_ISSUED_BY_ID = USERS.USER_ID');
			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
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
			
			$this->db->join('TRUST_EVENT_RECEIPT', 'TRUST_EVENT_SEVA_OFFERED.TET_RECEIPT_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_ID');
			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
	
		//FOR EVENT RECEIPT REPORT
		function get_total_amount($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('(SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE');
			$this->db->from($this->tableEventReceipt);
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

		//FOR EVENT RECEIPT REPORT
		function get_total_amount_user_collection($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('(SUM(TET_RECEIPT_PRICE)) AS PRICE');
			$this->db->from($this->tableEventReceipt);
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
	
		//FOR EVENT RECEIPT REPORT
		function get_all_amount($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableEventReceipt);
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
		function get_all_field_event_receipt_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->tableEventReceipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->join('TRUST_EVENT_RECEIPT_CATEGORY', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID');
			$this->db->join('trust_event_inkind_offered', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_ID = trust_event_inkind_offered.TET_RECEIPT_ID','left');

			$this->db->order_by('TRUST_EVENT_RECEIPT.TET_RECEIPT_ID', 'desc');
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		function get_full_field_event_receipt_report($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableEventReceipt);
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
	
		//FOR HALL BOOKING EXCEL
		function get_all_field_hall_booking_excel($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableHallBookingList);
			if ($condition) {
				$this->db->where($condition);
			}
			
			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_HALL_BOOKING_LIST.HB_ID');
			$this->db->join('FUNCTION', 'FUNCTION.FN_ID = TRUST_HALL_BOOKING_LIST.FN_TYPE');
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			$this->db->order_by('H_NAME', 'asc');			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
	
		//FOR GETTING HALL COUNT DETAILS FROM BOOKING LIST
		function count_rows_hall_details_booking_list($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableHallBookingList);
			if($condition){
				$this->db->where($condition);
			}
			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_HALL_BOOKING_LIST.HB_ID');
			$this->db->join('FUNCTION', 'FUNCTION.FN_ID = TRUST_HALL_BOOKING_LIST.FN_TYPE');
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
	
		//FOR GETTING HALL DETAILS FROM BOOKING LIST
		function get_all_field_hall_details_booking_list($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->tableHallBookingList);
			if ($condition) {
				$this->db->where($condition);
			}
			
			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_HALL_BOOKING_LIST.HB_ID');
			$this->db->join('FUNCTION', 'FUNCTION.FN_ID = TRUST_HALL_BOOKING_LIST.FN_TYPE');
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$this->db->order_by('H_NAME', 'asc');
			
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
	
		//FOR GETTING HALL DETAILS FROM BOOKING LIST
		function get_all_field_hall_details($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->distinct();
			$this->db->select('H_NAME, H_ID');
			$this->db->from($this->tableHallBookingList);
			if ($condition) {
				$this->db->where($condition);
			}
			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_HALL_BOOKING_LIST.HB_ID');
			
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
	
		//FOR MIS REPORT
		function get_all_field_mis_report($date) {
			$sql = "SELECT FH_NAME,
			        COUNT(TR_ID) AS QTY,
					 SUM(FH_AMOUNT) AS PRICE
					  FROM `TRUST_RECEIPT` 
					  WHERE `RECEIPT_DATE` = '$date'  GROUP BY FH_ID"; //AND RECEIPT_CATEGORY_ID != 1
			$query = $this->db->query($sql);
			return $query->result('array');
		}

		//FOR MIS REPORT INKIND
		function get_all_field_mis_report_inkind($date) {
			$sql = 'SELECT TRUST_RECEIPT.TR_NO,
			               TRUST_RECEIPT.RECEIPT_NAME,
						   TRUST_RECEIPT.RECEIPT_DATE, 
						   TRUST_INKIND_OFFERED.IK_ITEM_QTY,
						   IK_ITEM_NAME,
						   IK_ITEM_UNIT, 
						   SUM(IK_ITEM_QTY) AS amount 
					FROM TRUST_RECEIPT 
					JOIN `TRUST_INKIND_OFFERED` 
					    ON `TRUST_INKIND_OFFERED`.`T_RECEIPT_ID` = `TRUST_RECEIPT`.`TR_ID` 
						WHERE `TRUST_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" and TR_ACTIVE=1  GROUP BY `TRUST_INKIND_OFFERED`.`IK_ITEM_NAME`'; // AND `TRUST_RECEIPT`.`RECEIPT_CATEGORY_ID` = 1 
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR SEVA DETAILS SUMMARY PERIOD
		function get_all_field_mis_report_period($fromdate, $todate) {
			$fromdate = date('Y-m-d',strtotime($fromdate));
			$todate = date('Y-m-d',strtotime($todate));
			$sql = "SELECT FH_NAME,
			 COUNT(TR_ID) AS QTY,
			  SUM(FH_AMOUNT) AS PRICE 
			  FROM `TRUST_RECEIPT` 
			  WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') BETWEEN '$fromdate' AND '$todate' 
			   GROUP BY FH_ID "; //AND RECEIPT_CATEGORY_ID != 1 EDITED BY ADITHYA
			$query = $this->db->query($sql);
			return $query->result('array');
		}

		//FOR MIS REPORT INKIND
		function get_all_field_mis_report_period_inkind($fromdate, $todate) {
			$sql = 'SELECT TRUST_RECEIPT.TR_NO,
			 TRUST_RECEIPT.RECEIPT_NAME,
			 TRUST_RECEIPT.RECEIPT_DATE, 
			 TRUST_INKIND_OFFERED.IK_ITEM_QTY,
			 IK_ITEM_NAME,IK_ITEM_UNIT, SUM(IK_ITEM_QTY) AS amount FROM 
			 TRUST_RECEIPT JOIN
			  `TRUST_INKIND_OFFERED` ON `TRUST_INKIND_OFFERED`.`T_RECEIPT_ID` = `TRUST_RECEIPT`.`TR_ID` 
			  WHERE STR_TO_DATE(RECEIPT_DATE,"%d-%m-%Y") 
			  BETWEEN STR_TO_DATE("'.$fromdate.'","%d-%m-%Y") AND STR_TO_DATE("'.$todate.'","%d-%m-%Y")   and TR_ACTIVE=1  GROUP BY `TRUST_INKIND_OFFERED`.`IK_ITEM_NAME`'; //AND `TRUST_RECEIPT`.`RECEIPT_CATEGORY_ID` = 1 ADITHYA
			$query = $this->db->query($sql);
			return $query->result('array');
		}
		
		//FOR GETTING FINANCIAL HEAD 
		function get_all_field_financial_head($condition = array(), $order_by_field = '', $order_by_type = "asc") {
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
		
		//FOR TRUST RECEIPT EXCEL
		function get_all_field_trust_receipt_excel($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableTrustReceipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_RECEIPT.HB_ID', "left");
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			$this->db->join('trust_inkind_offered', 'TRUST_RECEIPT.TR_ID = trust_inkind_offered.T_RECEIPT_ID','left');
			$this->db->join('FINANCIAL_HEAD', 'TRUST_RECEIPT.FH_ID = FINANCIAL_HEAD.FH_ID', "left");
			$this->db->order_by('TR_ID', 'asc');
						
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR TRUST RECEIPT REPORT
		function get_all_field_trust_receipt_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->tableTrustReceipt);
			if ($condition) {
				$this->db->where($condition);
			}

			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_RECEIPT.HB_ID', "left");
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			$this->db->join('trust_inkind_offered', 'TRUST_RECEIPT.TR_ID = trust_inkind_offered.T_RECEIPT_ID','left');
			$this->db->join('FINANCIAL_HEAD', 'TRUST_RECEIPT.FH_ID = FINANCIAL_HEAD.FH_ID', "left");
			$this->db->order_by('TR_ID', 'asc');
			
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR TRUST RECEIPT REPORT AMOUNT
		function get_all_amount_trust($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableTrustReceipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_RECEIPT.HB_ID', "left");

			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('FINANCIAL_HEAD', 'TRUST_RECEIPT.FH_ID = FINANCIAL_HEAD.FH_ID');
			$this->db->order_by('TR_ID', 'desc');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR TRUST RECEIPT REPORT
		function get_total_amount_trust($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('SUM(FH_AMOUNT) AS PRICE');
			$this->db->from($this->tableTrustReceipt);
			if ($condition) {
				$this->db->where($condition);
			}
			
			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_RECEIPT.HB_ID', "left");
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
		
		//FOR TRUST RECEIPT REPORT COUNT
		function count_rows_trust_receipt_report($condition=array(), $order_by_field = '', $order_by_type = "asc"){
			$this->db->from($this->tableTrustReceipt);
			if($condition){
				$this->db->where($condition);
			}
			$this->db->join('TRUST_HALL_BOOKING', 'TRUST_HALL_BOOKING.HB_ID = TRUST_RECEIPT.HB_ID', "left");
			$this->db->join('trust_inkind_offered', 'TRUST_RECEIPT.TR_ID = trust_inkind_offered.T_RECEIPT_ID','left');
			$this->db->join('FINANCIAL_HEAD', 'TRUST_RECEIPT.FH_ID = FINANCIAL_HEAD.FH_ID', "left");
			$this->db->order_by('TR_ID', 'desc');
			
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}

		//EVENT INKIND
		function get_all_trust_inkind_report($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {		
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT * FROM
							(SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,CONCAT(TRIM(IK_ITEM_QTY)+0,' ',IK_ITEM_UNIT) as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC limit ".$start.",".$num;
			} else  {
				$query = "SELECT * FROM
							(SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,CONCAT(TRIM(IK_ITEM_QTY)+0,' ',IK_ITEM_UNIT) as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC limit ".$start.",".$num;
			}				
			$resQuery = $this->db->query($query);
			if ($resQuery->num_rows() > 0) {
				return $resQuery->result();
			} else {
				return array();
			}
		}

		function count_get_all_trust_inkind_report($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc") {			
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT COUNT(*) AS CNT_DAY_BOOK FROM
							(SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC ";
			} else  {
				$query = "SELECT COUNT(*) AS CNT_DAY_BOOK FROM
							(SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC ";
			}	
				$resQuery = $this->db->query($query);			
			return $resQuery->row()->CNT_DAY_BOOK;	
			
			
		}

		function get_all_trust_inkind_report_excel($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc") {
			
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT * FROM
							(SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC ";
			} else  {
				$query = "SELECT * FROM
							(SELECT trust_event_receipt.TET_RECEIPT_ID as rId,
								   'Event' as receiptFor,
								   TET_RECEIPT_NO as rNo,
								   TET_RECEIPT_DATE as rDate,
								   trust_event_receipt.TET_RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT TET_RECEIPT_CATEGORY_TYPE FROM trust_event_receipt_category WHERE TET_RECEIPT_CATEGORY_ID = trust_event_receipt.TET_RECEIPT_CATEGORY_ID) AS rType,
								   trust_event_inkind_offered.IK_ITEM_NAME as sevaName,
								   trust_event.TET_NAME as dtetName,
								   TET_RECEIPT_NAME  as rName, 
								   TET_RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   TET_RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_event_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TET_RECEIPT_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_event_inkind_offered 
							INNER JOIN trust_event_receipt ON trust_event_inkind_offered.TET_RECEIPT_ID = trust_event_receipt.TET_RECEIPT_ID
							INNER JOIN trust_event ON trust_event_receipt.RECEIPT_TET_ID = trust_event.TET_ID
							WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							trust_event_receipt.TET_RECEIPT_CATEGORY_ID = 4
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
			}		
			
			$resQuery = $this->db->query($query);

			if ($resQuery->num_rows() > 0) {
				return $resQuery->result();
			} else {
				return array();
			}
		}

		//TRUST INKIND
		function get_all_t_inkind_report($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {		
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT * FROM
							(SELECT trust_receipt.TR_ID as rId,
								   'Trust' as receiptFor,
								   TR_NO as rNo,
								   RECEIPT_DATE as rDate,
								   trust_receipt.RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT T_RECEIPT_CATEGORY_TYPE FROM trust_receipt_category WHERE T_RECEIPT_CATEGORY_ID = trust_receipt.RECEIPT_CATEGORY_ID) AS rType,
								   trust_inkind_offered.IK_ITEM_NAME as sevaName,
								   RECEIPT_NAME  as rName, 
								   RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_receipt.DATE_TIME as dttime,CONCAT(TRIM(IK_ITEM_QTY)+0,' ',IK_ITEM_UNIT) as sevaQty,TR_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_inkind_offered 
							INNER JOIN trust_receipt ON trust_inkind_offered.T_RECEIPT_ID = trust_receipt.TR_ID
							WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') 
							
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC limit ".$start.",".$num; //AND
						// trust_receipt.RECEIPT_CATEGORY_ID = 1 adithya
			} else  {
				$query = "SELECT * FROM
							(SELECT trust_receipt.TR_ID as rId,
								   'Trust' as receiptFor,
								   TR_NO as rNo,
								   RECEIPT_DATE as rDate,
								   trust_receipt.RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT T_RECEIPT_CATEGORY_TYPE FROM trust_receipt_category WHERE T_RECEIPT_CATEGORY_ID = trust_receipt.RECEIPT_CATEGORY_ID) AS rType,
								   trust_inkind_offered.IK_ITEM_NAME as sevaName,
								   RECEIPT_NAME  as rName, 
								   RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_receipt.DATE_TIME as dttime,CONCAT(TRIM(IK_ITEM_QTY)+0,' ',IK_ITEM_UNIT) as sevaQty,TR_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_inkind_offered 
							INNER JOIN trust_receipt ON trust_inkind_offered.T_RECEIPT_ID = trust_receipt.TR_ID
							WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') 
							
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC limit ".$start.",".$num; //AND
						// trust_receipt.RECEIPT_CATEGORY_ID = 1
			}				
			$resQuery = $this->db->query($query);
			if ($resQuery->num_rows() > 0) {
				return $resQuery->result();
			} else {
				return array();
			}
		}

		function count_get_all_t_inkind_report($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc") {			
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT COUNT(*) AS CNT_DAY_BOOK FROM
							(SELECT trust_receipt.TR_ID as rId,
								   'Trust' as receiptFor,
								   TR_NO as rNo,
								   RECEIPT_DATE as rDate,
								   trust_receipt.RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT T_RECEIPT_CATEGORY_TYPE FROM trust_receipt_category WHERE T_RECEIPT_CATEGORY_ID = trust_receipt.RECEIPT_CATEGORY_ID) AS rType,
								   trust_inkind_offered.IK_ITEM_NAME as sevaName,
								   RECEIPT_NAME  as rName, 
								   RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TR_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_inkind_offered 
							INNER JOIN trust_receipt ON trust_inkind_offered.T_RECEIPT_ID = trust_receipt.TR_ID
							WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_receipt.RECEIPT_CATEGORY_ID = 1
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC ";
			} else  {
				$query = "SELECT COUNT(*) AS CNT_DAY_BOOK FROM
							(SELECT trust_receipt.TR_ID as rId,
								   'Trust' as receiptFor,
								   TR_NO as rNo,
								   RECEIPT_DATE as rDate,
								   trust_receipt.RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT T_RECEIPT_CATEGORY_TYPE FROM trust_receipt_category WHERE T_RECEIPT_CATEGORY_ID = trust_receipt.RECEIPT_CATEGORY_ID) AS rType,
								   trust_inkind_offered.IK_ITEM_NAME as sevaName,
								   RECEIPT_NAME  as rName, 
								   RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TR_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_inkind_offered 
							INNER JOIN trust_receipt ON trust_inkind_offered.T_RECEIPT_ID = trust_receipt.TR_ID
							WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							trust_receipt.RECEIPT_CATEGORY_ID = 1
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
			}	
				$resQuery = $this->db->query($query);			
			return $resQuery->row()->CNT_DAY_BOOK;		
		}

		function get_all_t_inkind_report_excel($fromDate = "", $toDate = "", $order_by_field = '', $order_by_type = "asc") {
			
			if($fromDate != "" && $toDate != "") {
				$query = "SELECT * FROM
							(SELECT trust_receipt.TR_ID as rId,
								   'Trust' as receiptFor,
								   TR_NO as rNo,
								   RECEIPT_DATE as rDate,
								   trust_receipt.RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT T_RECEIPT_CATEGORY_TYPE FROM trust_receipt_category WHERE T_RECEIPT_CATEGORY_ID = trust_receipt.RECEIPT_CATEGORY_ID) AS rType,
								   trust_inkind_offered.IK_ITEM_NAME as sevaName,
								   RECEIPT_NAME  as rName, 
								   RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TR_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_inkind_offered 
							INNER JOIN trust_receipt ON trust_inkind_offered.T_RECEIPT_ID = trust_receipt.TR_ID
							WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND
							trust_receipt.RECEIPT_CATEGORY_ID = 1
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC ";
			} else  {
				$query = "SELECT * FROM
							(SELECT trust_receipt.TR_ID as rId,
								   'Trust' as receiptFor,
								   TR_NO as rNo,
								   RECEIPT_DATE as rDate,
								   trust_receipt.RECEIPT_CATEGORY_ID as rCatId,
								   (SELECT T_RECEIPT_CATEGORY_TYPE FROM trust_receipt_category WHERE T_RECEIPT_CATEGORY_ID = trust_receipt.RECEIPT_CATEGORY_ID) AS rType,
								   trust_inkind_offered.IK_ITEM_NAME as sevaName,
								   RECEIPT_NAME  as rName, 
								   RECEIPT_PAYMENT_METHOD as rPayMethod,
								   '' as qty,
								   '' as amt,
								   '' as amtPostage,
								   '' as total,
								   RECEIPT_ISSUED_BY  as user,
								   PAYMENT_STATUS as status, 
								   CANCEL_NOTES as cnclNotes,
								   trust_receipt.DATE_TIME as dttime,CONCAT(IK_ITEM_QTY,' ',IK_ITEM_UNIT) as sevaQty,TR_PAYMENT_METHOD_NOTES as RPMNotes,IK_APPRX_AMT as apprxAmt,IK_ITEM_DESC as itemDesc
							FROM trust_inkind_offered 
							INNER JOIN trust_receipt ON trust_inkind_offered.T_RECEIPT_ID = trust_receipt.TR_ID
							WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND
							trust_receipt.RECEIPT_CATEGORY_ID = 1
						    ) t
						ORDER BY STR_TO_DATE(rDate,'%d-%m-%Y'), dttime ASC";
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
