<?php
class trust_finance_Model extends CI_Model 
{
	var $table_finance_voucher_counter = 'trust_finance_voucher_counter';
	var $table_finance_prerequisites = 'trust_finance_prerequisites';

	function getLedger($condition ="",$compId="") {	//TS
		$sql ="SELECT TBL1.T_FGLH_ID,TBL1.T_FGLH_NAME,TBL2.BALANCE,TBL1.T_TYPE_ID
		FROM (SELECT  `T_FGLH_NAME`, `trust_financial_group_ledger_heads`.`T_FGLH_ID`, `T_TYPE_ID` 
      	FROM trust_financial_group_ledger_heads WHERE `T_LEVELS` = 'LG'  and `trust_financial_group_ledger_heads`.`T_COMP_ID` LIKE '%$compId%' $condition
	      GROUP BY trust_financial_group_ledger_heads.T_FGLH_ID) as tbl1 
	      left join 
		(SELECT  `trust_financial_ledger_transcations`.`T_FGLH_ID`, IF(T_TYPE_ID='A' OR T_TYPE_ID='E', SUM(T_FLT_DR-T_FLT_CR), SUM(T_FLT_CR-T_FLT_DR)) AS BALANCE 
		 FROM trust_financial_ledger_transcations 
		 JOIN trust_financial_group_ledger_heads ON trust_financial_ledger_transcations.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID 
		 WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and `trust_financial_ledger_transcations`.`T_COMP_ID` LIKE '%$compId%'  
		 GROUP BY trust_financial_ledger_transcations.T_FGLH_ID) as tbl2 on tbl1.T_FGLH_ID = tbl2.T_FGLH_ID ORDER BY T_FGLH_NAME";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getToAccount() {
		$sql="SELECT * from trust_bank_ledger_allocation";
		$query = $this->db->query($sql);	
		return $query->result();
	}
                      
	function getAllLedger($condition) {		// (TF)
		$this->db->select()->from('trust_financial_group_ledger_heads');
		$this->db->where($condition);
		$query = $this->db->get();
		return $query->result();
	}

	function getBankLedgerDetails($condition) {
		$this->db->select()->from('trust_bank_ledger_allocation');
		$this->db->where($condition);
		$query = $this->db->get();
		return $query->row()->T_BANK_FGLH_ID;
	}

	function getAllLedgerAndGroups($num = 13, $start = 0,$condition,$condsrch = "") {	//TS  (TF)
		$sql="SELECT TBL1.T_FGLH_ID,TBL1.T_FGLH_NAME,TBL2.T_BALANCE,TBL1.T_FGLH_PARENT_ID,TBL1.T_LEVELS,TBL1.T_IS_JOURNAL_STATUS,TBL1.T_IS_TERMINAL,TBL1.T_COMP_ID,TBL3.T_CURRENT_BALANCE,TBL4.T_OPBALANCE,TBL1.T_IS_FD_STATUS,TBL1.T_FD_MATURITY_START_DATE,TBL1.T_FD_MATURITY_END_DATE,TBL1.T_FD_INTEREST_RATE
		FROM (SELECT  `T_FGLH_NAME`, `trust_financial_group_ledger_heads`.`T_FGLH_ID`,T_FGLH_PARENT_ID,T_LEVELS,T_IS_JOURNAL_STATUS,T_IS_TERMINAL,T_IS_FD_STATUS,T_FD_MATURITY_START_DATE,T_FD_MATURITY_END_DATE,T_FD_INTEREST_RATE,T_COMP_ID
      	FROM trust_financial_group_ledger_heads WHERE $condition $condsrch
	      GROUP BY trust_financial_group_ledger_heads.T_FGLH_ID) as tbl1 
	      left join 
		(SELECT  `trust_financial_ledger_transcations`.`T_FGLH_ID`, IF(T_TYPE_ID='A' OR T_TYPE_ID='E', SUM(T_FLT_DR-T_FLT_CR), SUM(T_FLT_CR-T_FLT_DR)) AS T_BALANCE 
		 FROM trust_financial_ledger_transcations 
		 JOIN trust_financial_group_ledger_heads ON trust_financial_ledger_transcations.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID WHERE T_TRANSACTION_STATUS != 'Cancelled'
		 GROUP BY trust_financial_ledger_transcations.T_FGLH_ID) as tbl2 on tbl1.T_FGLH_ID = tbl2.T_FGLH_ID 
		 left join
		 (SELECT  `trust_financial_ledger_transcations`.`T_FGLH_ID`, IF(T_TYPE_ID='A' OR T_TYPE_ID='E', SUM(T_FLT_DR-T_FLT_CR), SUM(T_FLT_CR-T_FLT_DR)) AS T_CURRENT_BALANCE 
		 FROM trust_financial_ledger_transcations 
		 JOIN trust_financial_group_ledger_heads ON trust_financial_ledger_transcations.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID WHERE T_RP_TYPE!= 'OP' AND T_TRANSACTION_STATUS != 'Cancelled'
		 GROUP BY trust_financial_ledger_transcations.T_FGLH_ID) as tbl3 on tbl1.T_FGLH_ID = tbl3.T_FGLH_ID 
		  left join
		(SELECT `trust_financial_ledger_transcations`.`T_FGLH_ID`, IF(T_TYPE_ID='A' OR T_TYPE_ID='E', SUM(T_FLT_DR-T_FLT_CR), SUM(T_FLT_CR-T_FLT_DR)) AS T_OPBALANCE FROM trust_financial_ledger_transcations JOIN trust_financial_group_ledger_heads ON trust_financial_ledger_transcations.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID where T_RP_TYPE = 'OP' AND T_TRANSACTION_STATUS != 'Cancelled' GROUP BY trust_financial_ledger_transcations.T_FGLH_ID) as tbl4 on tbl1.T_FGLH_ID = tbl4.T_FGLH_ID 
		  ";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getAllLedgerAndGroups_count($num = 13, $start = 0,$condition,$condsrch = "") {		//TS    (TF)
		$sql="SELECT TBL1.T_FGLH_ID,TBL1.T_FGLH_NAME,TBL2.T_BALANCE,TBL1.T_FGLH_PARENT_ID,TBL1.T_LEVELS,TBL1.T_IS_JOURNAL_STATUS,TBL1.T_IS_TERMINAL,TBL1.T_COMP_ID,TBL3.T_CURRENT_BALANCE,TBL4.T_OPBALANCE,TBL1.T_IS_FD_STATUS,TBL1.T_FD_MATURITY_START_DATE,TBL1.T_FD_MATURITY_END_DATE,TBL1.T_FD_INTEREST_RATE
		FROM (SELECT  `T_FGLH_NAME`, `trust_financial_group_ledger_heads`.`T_FGLH_ID`,T_FGLH_PARENT_ID,T_LEVELS,T_IS_JOURNAL_STATUS,T_IS_TERMINAL,T_IS_FD_STATUS,T_FD_MATURITY_START_DATE,T_FD_MATURITY_END_DATE,T_FD_INTEREST_RATE,T_COMP_ID
      	FROM trust_financial_group_ledger_heads WHERE $condition $condsrch
	      GROUP BY trust_financial_group_ledger_heads.T_FGLH_ID) as tbl1 
	      left join 
		(SELECT  `trust_financial_ledger_transcations`.`T_FGLH_ID`, IF(T_TYPE_ID='A' OR T_TYPE_ID='E', SUM(T_FLT_DR-T_FLT_CR), SUM(T_FLT_CR-T_FLT_DR)) AS T_BALANCE 
		 FROM trust_financial_ledger_transcations 
		 JOIN trust_financial_group_ledger_heads ON trust_financial_ledger_transcations.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID WHERE T_TRANSACTION_STATUS != 'Cancelled'
		 GROUP BY trust_financial_ledger_transcations.T_FGLH_ID) as tbl2 on tbl1.T_FGLH_ID = tbl2.T_FGLH_ID 
		 left join
		 (SELECT  `trust_financial_ledger_transcations`.`T_FGLH_ID`, IF(T_TYPE_ID='A' OR T_TYPE_ID='E', SUM(T_FLT_DR-T_FLT_CR), SUM(T_FLT_CR-T_FLT_DR)) AS T_CURRENT_BALANCE 
		 FROM trust_financial_ledger_transcations 
		 JOIN trust_financial_group_ledger_heads ON trust_financial_ledger_transcations.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID WHERE T_RP_TYPE!= 'OP' AND T_TRANSACTION_STATUS != 'Cancelled'
		 GROUP BY trust_financial_ledger_transcations.T_FGLH_ID) as tbl3 on tbl1.T_FGLH_ID = tbl3.T_FGLH_ID 
		  left join
		(SELECT `trust_financial_ledger_transcations`.`T_FGLH_ID`, IF(T_TYPE_ID='A' OR T_TYPE_ID='E', SUM(T_FLT_DR-T_FLT_CR), SUM(T_FLT_CR-T_FLT_DR)) AS T_OPBALANCE FROM trust_financial_ledger_transcations JOIN trust_financial_group_ledger_heads ON trust_financial_ledger_transcations.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID where T_RP_TYPE = 'OP' AND T_TRANSACTION_STATUS != 'Cancelled' GROUP BY trust_financial_ledger_transcations.T_FGLH_ID) as tbl4 on tbl1.T_FGLH_ID = tbl4.T_FGLH_ID ";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getAssignedBankLedger($LEDGER_FGLH_ID){	//TS   (TF)
		$sql="SELECT T_BLA_ID,T_BANK_FGLH_ID,T_LEDGER_FGLH_ID,T_FGLH_NAME as AssignedLedgerName,IF(SUM(T_FLT_DR)-SUM(T_FLT_CR)IS NULL,0,SUM(T_FLT_DR)-SUM(T_FLT_CR)) AS AMT  FROM `trust_bank_ledger_allocation` JOIN trust_financial_group_ledger_heads ON trust_bank_ledger_allocation.T_LEDGER_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID LEFT JOIN trust_financial_ledger_transcations ON trust_bank_ledger_allocation.T_BANK_FGLH_ID = trust_financial_ledger_transcations.T_PC_PAY_GROUP WHERE T_BANK_FGLH_ID = $LEDGER_FGLH_ID and trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' GROUP BY T_LEDGER_FGLH_ID ";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getAccount($condition ="",$compId) {	//TS
		$sql = "SELECT TBL1.T_FGLH_ID,TBL1.T_FGLH_NAME,TBL2.BALANCE,TBL2.T_COMP_ID, 
		                TBL1.T_TYPE_ID, TBL1.T_FGLH_PARENT_ID,TBL1.T_BANK_NAME,TBL1.T_BANK_BRANCH 
		FROM 
		(SELECT `T_FGLH_NAME`, `trust_financial_group_ledger_heads`.`T_FGLH_ID`, 
		         `T_TYPE_ID`, `T_FGLH_PARENT_ID`, `trust_financial_group_ledger_heads`.`T_BANK_NAME`, 
				  `trust_financial_group_ledger_heads`.`T_BANK_BRANCH` 
		FROM trust_financial_group_ledger_heads WHERE `trust_financial_group_ledger_heads`.`T_COMP_ID` 
		LIKE '%$compId%' 
		AND `T_LEVELS` = 'LG' 
		AND (`T_FGLH_PARENT_ID` = 8 OR `T_FGLH_PARENT_ID` = 9) $condition 
		GROUP BY trust_financial_group_ledger_heads.T_FGLH_ID) as tbl1 
		left join 
		(SELECT trust_financial_ledger_transcations.T_FGLH_ID, SUM(T_FLT_DR-T_FLT_CR) 
		AS BALANCE,trust_financial_ledger_transcations.T_COMP_ID 
		FROM trust_financial_ledger_transcations 
		WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
		and T_TRANSACTION_STATUS != 'Cancelled' 
		and  `trust_financial_ledger_transcations`.`T_COMP_ID` 
		LIKE '%$compId%' 
		GROUP BY trust_financial_ledger_transcations.T_FGLH_ID) 
		as tbl2 on tbl1.T_FGLH_ID = tbl2.T_FGLH_ID";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getGroups($condition="") {		//(TF)
		$this->db->select()->from('trust_financial_group_ledger_heads');
		if ($condition) {
			$this->db->where($condition);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function getTFGLH_ID($T_FGLH_ID){
		// $this->db->select()->from('');
		// $this->db->where();
		$sql = "SELECT T_COMP_ID FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = $T_FGLH_ID";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getBookStatus($FGLH_ID) {
		$this->db->select()->from('trust_finance_cheque_book_details');
		$this->db->where('T_FGLH_ID',$FGLH_ID);
		$this->db->where('T_FCBD_STATUS',"Active");
		$query = $this->db->get();
		return $query->num_rows();
	}

	function putChequeDetails($chkbookno,$fromno,$tono,$numberofchk,$chkname,$FGLH_ID,$status) {
		$this->db->query("INSERT INTO `trust_finance_cheque_book_details`(`T_FGLH_ID`,`T_CHEQUE_BOOK_NO`,`T_CHEQUE_BOOK_NAME`, `T_FROM_NO`, `T_TO_NO`,`T_NO_OF_CHEQUE`,`T_FCBD_STATUS`) VALUES ('$FGLH_ID','$chkbookno','$chkname','$fromno','$tono','$numberofchk','$status')");
	}

	function putOpeningBal($dateTime,$todayDate,$last_id,$opAmt,$naration='',$compId,$userId) {	
		$this->db->select("T_TYPE_ID")->from('trust_financial_group_ledger_heads');
		$where = "T_FGLH_ID = '$last_id'";
		$this->db->where($where);
		$query = $this->db->get()->row()->T_TYPE_ID;
		$sql ="UPDATE `trust_financial_group_ledger_heads` SET T_OP_BAL = 1 WHERE T_FGLH_ID = $last_id" ; 
		$this->db->query($sql);
		if ($query == 'A' || $query == 'E') {
			$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_FLT_DR`, `T_FLT_CR`,`T_RP_TYPE`,`T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_COMP_ID`,`T_FLT_USER_ID`) VALUES ('$last_id',$opAmt,0,'OP','$todayDate','$dateTime','$naration','$compId','$userId')");
		}
		else {
			$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_FLT_DR`, `T_FLT_CR`, `T_RP_TYPE`,`T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_COMP_ID`,`T_FLT_USER_ID`) VALUES ($last_id,0,$opAmt,'OP','$todayDate','$dateTime','$naration','$compId','$userId')");
		}
		return $this->db->insert_id();
	}

	function putReceipt($aidR,$lidR,$countNoR,$amtsR,$todayDate,$dateTime,$naration,$userId,$chequeDate,$receiptmethod,$chkno,$bankName,$branchName,$receivedfrom,$status,$compId) {
		$DrAmt = 0;$CrAmt = $amtsR;
		$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_CHEQUE_DATE`,`T_PAYMENT_METHOD`,`T_CHEQUE_NO`,`T_BANK_NAME`,`T_BRANCH_NAME`,`T_RECEIPT_FAVOURING_NAME`,`T_FLT_DEPOSIT_PAYMENT_DATE`,`T_PAYMENT_STATUS`,`T_COMP_ID`) VALUES ($lidR,'$countNoR',$DrAmt,$CrAmt,
			'$todayDate','$dateTime','$naration','R1',$userId,'$chequeDate','$receiptmethod','$chkno','$bankName','$branchName','$receivedfrom','$todayDate','$status','$compId')");
		$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_CHEQUE_DATE`,`T_PAYMENT_METHOD`,`T_CHEQUE_NO`,`T_BANK_NAME`,`T_BRANCH_NAME`,`T_RECEIPT_FAVOURING_NAME`,`T_FLT_DEPOSIT_PAYMENT_DATE`,`T_PAYMENT_STATUS`,`T_COMP_ID`) VALUES ($aidR,'$countNoR',$amtsR,0,
			'$todayDate','$dateTime','$naration','R2',$userId,'$chequeDate','$receiptmethod','$chkno','$bankName','$branchName','$receivedfrom','$todayDate','$status','$compId')");
	}

	function putPayment($aidP,$lidP,$countNoP,$amtsP,$todayDate,$dateTime,$naration,$userId,$chequeDate,$paymentmethod,$chkno,$bankName,$branchName,$favouring,$status,$selectedId,$compId) {
		$this->db->select("T_TYPE_ID")->from('trust_financial_group_ledger_heads')->where("T_FGLH_ID = '$lidP'");
		$TYPE_ID = $this->db->get()->row()->T_TYPE_ID;
		$DrAmt = $amtsP;$CrAmt = 0;
		$this->db->query("INSERT INTO trust_financial_ledger_transcations(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_CHEQUE_DATE`,`T_PAYMENT_METHOD`,`T_CHEQUE_NO`,`T_BANK_NAME`,`T_BRANCH_NAME`,`T_RECEIPT_FAVOURING_NAME`,`T_FLT_DEPOSIT_PAYMENT_DATE`,`T_PAYMENT_STATUS`,`T_COMP_ID`) VALUES ($lidP,'$countNoP',$DrAmt,$CrAmt,
			'$todayDate','$dateTime','$naration','P1',$userId,'$chequeDate','$paymentmethod','$chkno','$bankName','$branchName','$favouring','$todayDate','$status','$compId')");
		$this->db->query("INSERT INTO trust_financial_ledger_transcations(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_CHEQUE_DATE`,`T_PAYMENT_METHOD`,`T_CHEQUE_NO`,`T_BANK_NAME`,`T_BRANCH_NAME`,`T_RECEIPT_FAVOURING_NAME`,`T_FLT_DEPOSIT_PAYMENT_DATE`,`T_PAYMENT_STATUS`,`T_PC_PAY_GROUP`,`T_COMP_ID`) VALUES ($aidP,'$countNoP',0,$amtsP,
			'$todayDate','$dateTime','$naration','P2',$userId,'$chequeDate','$paymentmethod','$chkno','$bankName','$branchName','$favouring','$todayDate','$status','$selectedId','$compId')");
		return $this->db->insert_id();
	}

	function putContra($aidC,$acidC,$countNoC,$amtsC,$todayDate,$dateTime,$naration,$userId,$chequeDate,$paymentmethod,$chkno,$bankName,$branchName,$favouring,$status,$pcPay,$compId) {
		$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_CHEQUE_DATE`,`T_PAYMENT_METHOD`,`T_CHEQUE_NO`,`T_BANK_NAME`,`T_BRANCH_NAME`,`T_RECEIPT_FAVOURING_NAME`,`T_FLT_DEPOSIT_PAYMENT_DATE`,`T_PAYMENT_STATUS`,`T_COMP_ID`) VALUES ($aidC,'$countNoC',0,$amtsC,
			'$todayDate','$dateTime','$naration','C1',$userId,'$chequeDate','$paymentmethod','$chkno','$bankName','$branchName','$favouring','$todayDate','$status','$compId')");
		$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_CHEQUE_DATE`,`T_PAYMENT_METHOD`,`T_CHEQUE_NO`,`T_BANK_NAME`,`T_BRANCH_NAME`,`T_RECEIPT_FAVOURING_NAME`,`T_PC_PAY_GROUP`,`T_FLT_DEPOSIT_PAYMENT_DATE`,`T_PAYMENT_STATUS`,`T_COMP_ID`) VALUES ($acidC,'$countNoC',$amtsC,0,
			'$todayDate','$dateTime','$naration','C2',$userId,'$chequeDate','$paymentmethod','$chkno','$bankName','$branchName','$favouring','$pcPay','$todayDate','$status','$compId')");
		return $this->db->insert_id();
	}

	function putJournal($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$userId,$rptype,$compId) {
		$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_FLT_USER_ID`,`T_RP_TYPE`,`T_PAYMENT_STATUS`,`T_COMP_ID`) VALUES ($lidJ,'$countNoJ',$firstAmt,$secondAmt,'$tDateJ','$dateTime','$naration',$userId,'$rptype','Completed','$compId')");
		return $this->db->insert_id();
	}

	function putJournalTransfer($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$user,$rptype,$SHASHWATH_RECEIPT,$compId) {
		$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`,`T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_FLT_USER_ID`,`T_RP_TYPE`,`T_PAYMENT_STATUS`,TR_ID,`T_COMP_ID`
		) VALUES ($lidJ,'$countNoJ',$firstAmt,$secondAmt,'$tDateJ','$dateTime','$naration',$user,'$rptype','Completed',$SHASHWATH_RECEIPT,$compId)");
		return $this->db->insert_id();
	}

	function getAssets($fromDate,$toDate,$compId,$newCondition) {		//TS
		$sql="SELECT tbl1.T_FGLH_NAME, tbl1.AMT,tbl2.AMT as PBalance ,
		      tbl1.T_LEVELS,tbl1.T_FGLH_ID,tbl1.T_FGLH_PARENT_ID,tbl1.T_FLT_DATE,tbl1.T_LEDGER_PRIMARY_PARENT_CODE,tbl1.T_COMP_ID 
			  FROM (SELECT GLHeads.T_FGLH_ID, 
			  CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.T_FGLH_NAME) AS T_FGLH_NAME,
			   SUM(T_FLT_DR-T_FLT_CR) AS AMT,
			   GLHeads.T_LEVELS,GLHeads.T_PRIMARY_PARENT_CODE,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_FGLH_PARENT_ID,T_FLT_DATE,T_COMP_ID 
			   FROM (SELECT node.T_FGLH_ID, node.T_LF_A,node.T_LEVELS, node.T_FGLH_NAME, 
			   (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD,
			    node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID 
				FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent 
				WHERE node.T_LEVELS!='MG' 
				and node.T_TYPE_ID = 'A' 
				AND node.T_LF_A 
				BETWEEN parent.T_LF_A AND parent.T_RG_A 
				GROUP BY node.T_FGLH_NAME 
				ORDER BY node.T_LF_A)GLHeads 
				LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID 
				where  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
				and T_TRANSACTION_STATUS != 'Cancelled' 
				and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') 
				BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') AND STR_TO_DATE('$toDate', '%d-%m-%Y')$newCondition)and T_COMP_ID 
				LIKE '%$compId%' 
				OR GLHeads.T_LEVELS ='PG' 
				OR GLHeads.T_LEVELS ='PSG' 
				OR GLHeads.T_LEVELS ='SG' 
				GROUP BY GLHeads.T_FGLH_NAME 
				ORDER BY GLHeads.T_LF_A) as tbl1,
			(SELECT SUM(T_FLT_DR-T_FLT_CR) AS AMT,
			GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS 
			FROM (SELECT node.T_FGLH_ID, node.T_LF_A,node.T_LEVELS, node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1)
			 AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE 
			 FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent 
			 WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'A' 
			 AND node.T_LF_A BETWEEN parent.T_LF_A AND parent.T_RG_A
			  GROUP BY node.T_FGLH_NAME 
			  ORDER BY node.T_LF_A) GLHeads 
			  LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID  
			  where  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
			  and T_TRANSACTION_STATUS != 'Cancelled' 
			  and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') 
			  BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') AND STR_TO_DATE('$toDate', '%d-%m-%Y')$newCondition) 
			  and T_COMP_ID LIKE '%$compId%'  
			  OR GLHeads.T_LEVELS ='PG' 
			  OR GLHeads.T_LEVELS ='PSG' 
			  OR GLHeads.T_LEVELS ='SG' 
			  GROUP BY GLHeads.T_LEDGER_PRIMARY_PARENT_CODE) as tbl2 
			  WHERE tbl1.T_PRIMARY_PARENT_CODE = tbl2.T_LEDGER_PRIMARY_PARENT_CODE";
		
		$query = $this->db->query($sql);	
		return $query->result();
	}
	
	function getCash($fromDate,$toDate,$compId) {	//TS
		$sql="SELECT trust_financial_group_ledger_heads.T_FGLH_ID,T_FGLH_NAME,IF(T_TYPE_ID='A' OR T_TYPE_ID='E', SUM(T_FLT_DR-T_FLT_CR), SUM(T_FLT_CR-T_FLT_DR)) AS CASH,T_COMP_NAME,trust_finance_committee.T_COMP_ID from trust_financial_ledger_transcations inner join trust_financial_group_ledger_heads on trust_financial_ledger_transcations.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID JOIN trust_finance_committee ON trust_financial_ledger_transcations.T_COMP_ID = trust_finance_committee.T_COMP_ID where  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') AND STR_TO_DATE('$toDate', '%d-%m-%Y') and trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' GROUP BY trust_financial_ledger_transcations.T_COMP_ID ,trust_financial_ledger_transcations.T_FGLH_ID ORDER BY trust_financial_group_ledger_heads.T_FGLH_ID";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getLiablities($fromDate,$toDate,$compId) {	//TS
		$sql="SELECT tbl1.T_FGLH_NAME,tbl1.AMT,tbl2.AMT as PBalanceL ,tbl1.T_LEVELS,tbl1.T_FGLH_ID,tbl1.T_FGLH_PARENT_ID,tbl1.T_LEDGER_PRIMARY_PARENT_CODE  FROM (SELECT GLHeads.T_FGLH_ID, CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.T_FGLH_NAME) AS T_FGLH_NAME,SUM(T_FLT_CR-T_FLT_DR) AS AMT,GLHeads.T_LEVELS,GLHeads.T_PRIMARY_PARENT_CODE,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_FGLH_PARENT_ID FROM (SELECT node.T_FGLH_ID, node.T_LF_L, node.T_FGLH_NAME,node.T_LEVELS, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE, node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'L' AND node.T_LF_L BETWEEN parent.T_LF_L AND parent.T_RG_L GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_L)GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID   where  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and ( STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') AND STR_TO_DATE('$toDate', '%d-%m-%Y')) and T_COMP_ID LIKE '%$compId%'  OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_FGLH_NAME ORDER BY GLHeads.T_LF_L) as tbl1 ,
		(SELECT SUM(T_FLT_CR-T_FLT_DR) AS AMT,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS FROM (SELECT node.T_FGLH_ID, node.T_LF_L,node.T_LEVELS,node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1)AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'L' AND node.T_LF_L BETWEEN parent.T_LF_L AND parent.T_RG_L GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_L)GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID  where  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') AND STR_TO_DATE('$toDate', '%d-%m-%Y')) and T_COMP_ID LIKE '%$compId%'  OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_LEDGER_PRIMARY_PARENT_CODE) as tbl2 WHERE tbl1.T_PRIMARY_PARENT_CODE = tbl2.T_LEDGER_PRIMARY_PARENT_CODE";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getDifference($fromDate,$toDate,$compId,$groupBy='') {	//TS
		$sql="SELECT sum(T_FLT_DR-T_FLT_CR) as Deficit,sum(T_FLT_CR-T_FLT_DR) as Surplus,T_COMP_NAME from trust_financial_ledger_transcations inner join trust_financial_group_ledger_heads on trust_financial_ledger_transcations.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID JOIN trust_finance_committee ON trust_financial_ledger_transcations.T_COMP_ID = trust_finance_committee.T_COMP_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') AND STR_TO_DATE('$toDate', '%d-%m-%Y') and (T_TYPE_ID ='I' OR T_TYPE_ID ='E') and trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' $groupBy ";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getReceipt($fromRP,$toRP,$compId) {	//TS
		$sql="SELECT * FROM ( SELECT tbl1.T_FGLH_NAME, tbl1.AMT,tbl2.AMT as PBalance ,tbl1.T_LEVELS,tbl1.T_FGLH_ID,tbl1.T_FGLH_PARENT_ID,tbl1.T_FLT_DATE,tbl1.T_LEDGER_PRIMARY_PARENT_CODE FROM (SELECT GLHeads.T_FGLH_ID, CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.T_FGLH_NAME) AS T_FGLH_NAME, SUM(T_FLT_CR) AS AMT,GLHeads.T_LEVELS,GLHeads.T_PRIMARY_PARENT_CODE,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_FGLH_PARENT_ID,T_FLT_DATE FROM (SELECT node.T_FGLH_ID, node.T_LF_A,node.T_LEVELS, node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'A' AND node.T_LF_A BETWEEN parent.T_LF_A AND parent.T_RG_A GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_A)GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'R1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_FGLH_NAME ORDER BY GLHeads.T_LF_A) as tbl1,
		(SELECT SUM(T_FLT_CR) AS AMT,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS FROM (SELECT node.T_FGLH_ID, node.T_LF_A,node.T_LEVELS, node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'A' AND node.T_LF_A BETWEEN parent.T_LF_A AND parent.T_RG_A GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_A) GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'R1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_LEDGER_PRIMARY_PARENT_CODE) as tbl2 WHERE tbl1.T_PRIMARY_PARENT_CODE = tbl2.T_LEDGER_PRIMARY_PARENT_CODE) as a
		UNION 
		SELECT * FROM ( SELECT tbl1.T_FGLH_NAME,tbl1.AMT,tbl2.AMT as PBalanceL ,tbl1.T_LEVELS,tbl1.T_FGLH_ID,tbl1.T_FGLH_PARENT_ID,tbl1.T_FLT_DATE,tbl1.T_LEDGER_PRIMARY_PARENT_CODE FROM (SELECT GLHeads.T_FGLH_ID, CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.T_FGLH_NAME) AS T_FGLH_NAME,SUM(T_FLT_CR) AS AMT,GLHeads.T_LEVELS,GLHeads.T_PRIMARY_PARENT_CODE,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_FGLH_PARENT_ID,T_FLT_DATE FROM (SELECT node.T_FGLH_ID, node.T_LF_L, node.T_FGLH_NAME,node.T_LEVELS, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE, node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'L' AND node.T_LF_L BETWEEN parent.T_LF_L AND parent.T_RG_L GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_L)GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'R1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_FGLH_NAME ORDER BY GLHeads.T_LF_L) as tbl1 ,    
		 (SELECT SUM(T_FLT_CR) AS AMT,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS FROM (SELECT node.T_FGLH_ID, node.T_LF_L,node.T_LEVELS,node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1)AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'L' AND node.T_LF_L BETWEEN parent.T_LF_L AND parent.T_RG_L GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_L)GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'R1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG'GROUP BY GLHeads.T_LEDGER_PRIMARY_PARENT_CODE) as tbl2 WHERE tbl1.T_PRIMARY_PARENT_CODE = tbl2.T_LEDGER_PRIMARY_PARENT_CODE) as b
		 UNION 
		SELECT * FROM ( SELECT tbl1.T_FGLH_NAME,tbl1.AMT,tbl2.AMT  as PBalance,tbl1.T_LEVELS,tbl1.T_FGLH_ID,tbl1.T_FGLH_PARENT_ID,tbl1.T_FLT_DATE,tbl1.T_LEDGER_PRIMARY_PARENT_CODE FROM (SELECT GLHeads.T_FGLH_ID,CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.T_FGLH_NAME) AS T_FGLH_NAME, SUM(T_FLT_CR) As AMT ,GLHeads.T_LEVELS,GLHeads.T_PRIMARY_PARENT_CODE,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_FGLH_PARENT_ID,T_FLT_DATE FROM (SELECT node.T_FGLH_ID, node.T_LF_I, node.T_FGLH_NAME,node.T_LEVELS, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE, node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID  FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'I' AND node.T_LF_I BETWEEN parent.T_LF_I AND parent.T_RG_I GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_I)GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID  where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'R1')  and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_FGLH_NAME ORDER BY GLHeads.T_LF_I) as tbl1,
		(SELECT  SUM(T_FLT_CR) As AMT ,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS FROM (SELECT node.T_FGLH_ID, node.T_LF_I,node.T_LEVELS, node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'I' AND node.T_LF_I BETWEEN parent.T_LF_I AND parent.T_RG_I GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_I)GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'R1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG'
			GROUP BY GLHeads.T_LEDGER_PRIMARY_PARENT_CODE) as tbl2 WHERE tbl1.T_PRIMARY_PARENT_CODE = tbl2.T_LEDGER_PRIMARY_PARENT_CODE ) AS c";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getPayment($fromRP,$toRP,$compId) {	//TS
		$sql="SELECT * FROM ( SELECT tbl1.T_FGLH_NAME, tbl1.AMT,tbl2.AMT as PBalance ,tbl1.T_LEVELS,tbl1.T_FGLH_ID,tbl1.T_FGLH_PARENT_ID,tbl1.T_FLT_DATE,tbl1.T_LEDGER_PRIMARY_PARENT_CODE FROM (SELECT GLHeads.T_FGLH_ID, CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.T_FGLH_NAME) AS T_FGLH_NAME, SUM(T_FLT_DR) AS AMT,GLHeads.T_LEVELS,GLHeads.T_PRIMARY_PARENT_CODE,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_FGLH_PARENT_ID,T_FLT_DATE FROM (SELECT node.T_FGLH_ID, node.T_LF_A,node.T_LEVELS, node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'A' AND node.T_LF_A BETWEEN parent.T_LF_A AND parent.T_RG_A GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_A)GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'P1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_FGLH_NAME ORDER BY GLHeads.T_LF_A) as tbl1,  
 			(SELECT SUM(T_FLT_DR) AS AMT,
			GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS FROM (SELECT node.T_FGLH_ID, node.T_LF_A,node.T_LEVELS, node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'A' AND node.T_LF_A BETWEEN parent.T_LF_A AND parent.T_RG_A GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_A) GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'P1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_LEDGER_PRIMARY_PARENT_CODE) as tbl2 WHERE tbl1.T_PRIMARY_PARENT_CODE = tbl2.T_LEDGER_PRIMARY_PARENT_CODE) as a 
			UNION
			SELECT * FROM ( SELECT tbl1.T_FGLH_NAME,tbl1.AMT,tbl2.AMT as PBalanceL ,tbl1.T_LEVELS,tbl1.T_FGLH_ID,tbl1.T_FGLH_PARENT_ID,tbl1.T_FLT_DATE,tbl1.T_LEDGER_PRIMARY_PARENT_CODE FROM (SELECT GLHeads.T_FGLH_ID, CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.T_FGLH_NAME) AS T_FGLH_NAME,SUM(T_FLT_DR) AS AMT,GLHeads.T_LEVELS,GLHeads.T_PRIMARY_PARENT_CODE,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_FGLH_PARENT_ID,T_FLT_DATE  FROM (SELECT node.T_FGLH_ID, node.T_LF_L, node.T_FGLH_NAME,node.T_LEVELS, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE, node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'L' AND node.T_LF_L BETWEEN parent.T_LF_L AND parent.T_RG_L GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_L)GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'P1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_FGLH_NAME ORDER BY GLHeads.T_LF_L) as tbl1 ,
			(SELECT SUM(T_FLT_DR) AS AMT,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS FROM (SELECT node.T_FGLH_ID, node.T_LF_L,node.T_LEVELS,node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1)AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'L' AND node.T_LF_L BETWEEN parent.T_LF_L AND parent.T_RG_L GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_L)GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID where  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'P1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG'GROUP BY GLHeads.T_LEDGER_PRIMARY_PARENT_CODE) as tbl2 WHERE tbl1.T_PRIMARY_PARENT_CODE = tbl2.T_LEDGER_PRIMARY_PARENT_CODE) as b 
			UNION
			SELECT * FROM(SELECT tbl1.T_FGLH_NAME,tbl1.AMT,tbl2.AMT as PBalance,tbl1.T_LEVELS,tbl1.T_FGLH_ID,tbl1.T_FGLH_PARENT_ID,tbl1.T_FLT_DATE,tbl1.T_LEDGER_PRIMARY_PARENT_CODE FROM (SELECT GLHeads.T_FGLH_ID,CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.T_FGLH_NAME) AS T_FGLH_NAME, SUM(T_FLT_DR) As AMT ,GLHeads.T_PRIMARY_PARENT_CODE,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS,GLHeads.T_FGLH_PARENT_ID,T_FLT_DATE FROM (SELECT node.T_FGLH_ID, node.T_LF_E, node.T_FGLH_NAME,node.T_LEVELS, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE, node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'E' AND node.T_LF_E BETWEEN parent.T_LF_E AND parent.T_RG_E GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_E) GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'P1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_FGLH_NAME ORDER BY GLHeads.T_LF_E) AS tbl1,
			(SELECT SUM(T_FLT_DR) As AMT, GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS FROM (SELECT node.T_FGLH_ID, node.T_LF_E,node.T_LEVELS, node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and node.T_TYPE_ID = 'E' AND node.T_LF_E BETWEEN parent.T_LF_E AND parent.T_RG_E GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_E) GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_RP_TYPE = 'P1') and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' GROUP BY GLHeads.T_LEDGER_PRIMARY_PARENT_CODE) as tbl2 WHERE tbl1.T_PRIMARY_PARENT_CODE = tbl2.T_LEDGER_PRIMARY_PARENT_CODE)as c";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getIncome($fromIe,$toIe,$compId) {		//TS
		$sql ="SELECT tbl1.T_FGLH_ID,tbl1.FGLH_NAME,tbl1.FLT_CR,tbl2.FLT_CR  as PBalance,tbl1.T_LEVELS,tbl1.T_FGLH_PARENT_ID,tbl1.T_FLT_DATE,tbl1.T_LEDGER_PRIMARY_PARENT_CODE
		FROM (SELECT GLHeads.T_FGLH_ID,CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.T_FGLH_NAME) AS FGLH_NAME, 
		SUM(T_FLT_DR) As FLT_DR, SUM(T_FLT_CR) As FLT_CR ,GLHeads.T_PRIMARY_PARENT_CODE,GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS,GLHeads.T_FGLH_PARENT_ID,T_FLT_DATE FROM 
		(SELECT node.T_FGLH_ID, node.T_LF_I, node.T_FGLH_NAME,node.T_LEVELS, (COUNT(parent.T_FGLH_NAME) - 1) 
		AS LEVELD, node.T_PRIMARY_PARENT_CODE, node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID  FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and 
		node.T_TYPE_ID = 'I' AND node.T_LF_I BETWEEN parent.T_LF_I AND parent.T_RG_I GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_I)
		GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromIe', '%d-%m-%Y') AND STR_TO_DATE('$toIe', '%d-%m-%Y')) and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG' 
		GROUP BY GLHeads.T_FGLH_NAME ORDER BY GLHeads.T_LF_I) as tbl1,
		(SELECT  SUM(T_FLT_DR) As FLT_DR, SUM(T_FLT_CR) As FLT_CR ,
		GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,GLHeads.T_LEVELS
		FROM (SELECT node.T_FGLH_ID, node.T_LF_I,node.T_LEVELS, node.T_FGLH_NAME, (COUNT(parent.T_FGLH_NAME) - 1) 
		AS LEVELD, node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE FROM `trust_financial_group_ledger_heads` node, `trust_financial_group_ledger_heads` parent WHERE node.T_LEVELS!='MG' and 
		node.T_TYPE_ID = 'I' AND node.T_LF_I BETWEEN parent.T_LF_I AND parent.T_RG_I GROUP BY node.T_FGLH_NAME ORDER BY node.T_LF_I)
		GLHeads LEFT JOIN trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromIe', '%d-%m-%Y') AND STR_TO_DATE('$toIe', '%d-%m-%Y')) and T_COMP_ID LIKE '%$compId%' OR GLHeads.T_LEVELS ='PG' OR GLHeads.T_LEVELS ='PSG' OR GLHeads.T_LEVELS ='SG'
		GROUP BY GLHeads.T_LEDGER_PRIMARY_PARENT_CODE) as tbl2
		WHERE tbl1.T_PRIMARY_PARENT_CODE = tbl2.T_LEDGER_PRIMARY_PARENT_CODE";
		
		// echo "$sql";
		$query= $this->db->query($sql);
		return $query->result();	
	}

	function getExpence($fromIe,$toIe,$compId) {	//TS
		$sql = "SELECT 
		tbl1.T_FGLH_ID,
		tbl1.FGLH_NAME,
		tbl1.FLT_DR,
		tbl2.FLT_DR as PBalance,
		tbl1.T_LEVELS,
		tbl1.T_FGLH_PARENT_ID,
		tbl1.T_FLT_DATE,
		tbl1.T_LEDGER_PRIMARY_PARENT_CODE 
	FROM 
		(SELECT 
			GLHeads.T_FGLH_ID,
			CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD), GLHeads.T_FGLH_NAME) AS FGLH_NAME, 
			SUM(T_FLT_DR) As FLT_DR, 
			SUM(T_FLT_CR) As FLT_CR ,
			GLHeads.T_PRIMARY_PARENT_CODE,
			GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,
			GLHeads.T_LEVELS,
			GLHeads.T_FGLH_PARENT_ID,
			T_FLT_DATE
		FROM 
			(SELECT 
				node.T_FGLH_ID,
				node.T_LF_E,
				node.T_FGLH_NAME,
				node.T_LEVELS,
				(COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, 
				node.T_PRIMARY_PARENT_CODE,
				node.T_LEDGER_PRIMARY_PARENT_CODE,
				node.T_FGLH_PARENT_ID 
			FROM 
				`trust_financial_group_ledger_heads` node,
				`trust_financial_group_ledger_heads` parent 
			WHERE 
				node.T_LEVELS != 'MG' 
				AND node.T_TYPE_ID = 'E' 
				AND node.T_LF_E BETWEEN parent.T_LF_E AND parent.T_RG_E 
			GROUP BY 
				node.T_FGLH_NAME 
			ORDER BY 
				node.T_LF_E) GLHeads 
		LEFT JOIN 
			trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID 
		WHERE  
			trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
			AND T_TRANSACTION_STATUS != 'Cancelled' 
			AND (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromIe', '%d-%m-%Y') AND STR_TO_DATE('$toIe', '%d-%m-%Y')) 
			AND T_COMP_ID LIKE '%$compId%' 
			OR GLHeads.T_LEVELS ='PG' 
			OR GLHeads.T_LEVELS ='PSG' 
			OR GLHeads.T_LEVELS ='SG' 
		GROUP BY 
			GLHeads.T_FGLH_NAME 
		ORDER BY 
			GLHeads.T_LF_E) AS tbl1,
		(SELECT  
			SUM(T_FLT_DR) As FLT_DR, 
			SUM(T_FLT_CR) As FLT_CR ,
			GLHeads.T_LEDGER_PRIMARY_PARENT_CODE,
			GLHeads.T_LEVELS
		FROM 
			(SELECT 
				node.T_FGLH_ID,
				node.T_LF_E,
				node.T_LEVELS, 
				node.T_FGLH_NAME, 
				(COUNT(parent.T_FGLH_NAME) - 1) AS LEVELD, 
				node.T_PRIMARY_PARENT_CODE,
				node.T_LEDGER_PRIMARY_PARENT_CODE 
			FROM 
				`trust_financial_group_ledger_heads` node, 
				`trust_financial_group_ledger_heads` parent 
			WHERE 
				node.T_LEVELS != 'MG' 
				AND node.T_TYPE_ID = 'E' 
				AND node.T_LF_E BETWEEN parent.T_LF_E AND parent.T_RG_E 
			GROUP BY 
				node.T_FGLH_NAME 
			ORDER BY 
				node.T_LF_E) GLHeads 
		LEFT JOIN 
			trust_financial_ledger_transcations ON GLHeads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID 
		WHERE  
			trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
			AND T_TRANSACTION_STATUS != 'Cancelled' 
			AND (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromIe', '%d-%m-%Y') AND STR_TO_DATE('$toIe', '%d-%m-%Y')) 
			AND T_COMP_ID LIKE '%$compId%' 
			OR GLHeads.T_LEVELS ='PG' 
			OR GLHeads.T_LEVELS ='PSG' 
			OR GLHeads.T_LEVELS ='SG'
		GROUP BY 
			GLHeads.T_LEDGER_PRIMARY_PARENT_CODE) as tbl2
	WHERE 
		tbl1.T_PRIMARY_PARENT_CODE = tbl2.T_LEDGER_PRIMARY_PARENT_CODE
	";
		// echo "$sql";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function getTrialData($fromTB,$toTB,$compId) {	//TS
		$sql="SELECT trust_financial_group_ledger_heads.T_FGLH_ID,T_FGLH_NAME,T_LEVELS, 
		SUM(T_FLT_DR-T_FLT_CR) AS Debit,
		 SUM(T_FLT_CR-T_FLT_DR) 
		 AS Credit,T_TYPE_ID  
		 FROM `trust_financial_group_ledger_heads` 
		 INNER JOIN trust_financial_ledger_transcations 
		 ON trust_financial_group_ledger_heads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID 
		 WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
		 and T_TRANSACTION_STATUS != 'Cancelled' 
		 and  trust_financial_group_ledger_heads.T_LEVELS='LG' 
		 AND STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') 
		 BETWEEN STR_TO_DATE('$fromTB', '%d-%m-%Y') 
		 AND STR_TO_DATE('$toTB', '%d-%m-%Y') 
		 AND trust_financial_ledger_transcations.T_COMP_ID 
		 LIKE '%$compId%' 
		 GROUP BY trust_financial_group_ledger_heads.T_FGLH_ID 
		 ORDER BY trust_financial_group_ledger_heads.T_TYPE_ID";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getOpening($fromRP,$toRP,$compId,$newCondition ) {	//TS
		$sql="SELECT T_FLT_ID,T_FGLH_NAME,SUM(T_FLT_DR-T_FLT_CR) AS AMOUNT
		 FROM `trust_financial_ledger_transcations` 
		 INNER JOIN trust_financial_group_ledger_heads 
		 ON trust_financial_ledger_transcations.T_FGLH_ID=trust_financial_group_ledger_heads.T_FGLH_ID 
		 WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
		 and T_TRANSACTION_STATUS != 'Cancelled' 
		 and  (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') 
		 BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') 
		 AND STR_TO_DATE('$toRP', '%d-%m-%Y')) 
		 AND  (trust_financial_group_ledger_heads.T_FGLH_PARENT_ID=9 
		 OR trust_financial_group_ledger_heads.T_FGLH_PARENT_ID=8) 
		 $newCondition 
		 AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' 
		 GROUP BY trust_financial_group_ledger_heads.T_FGLH_NAME";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getClosing($fromRP_OP,$fromRP,$toRP,$compId) {	//TS
		// $sql ="SELECT T_FLT_ID,T_FGLH_NAME,SUM(T_FLT_DR-T_FLT_CR) 
		// AS AMOUNT 
		// FROM `trust_financial_ledger_transcations` 
		// INNER JOIN trust_financial_group_ledger_heads 
		// ON trust_financial_ledger_transcations.T_FGLH_ID=trust_financial_group_ledger_heads.T_FGLH_ID 
		// WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
		// and T_TRANSACTION_STATUS != 'Cancelled' 
		// and (STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') 
		// BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') 
		// AND STR_TO_DATE('$toRP', '%d-%m-%Y') )
		// AND ( trust_financial_group_ledger_heads.T_FGLH_PARENT_ID=9 
		// OR trust_financial_group_ledger_heads.T_FGLH_PARENT_ID=8 )
		//  AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' 
		//  GROUP BY trust_financial_group_ledger_heads.T_FGLH_NAME";

		$sql = "SELECT 
		T_FLT_ID,
		T_FGLH_NAME,
		SUM(T_FLT_DR-T_FLT_CR) AS AMOUNT 
	FROM 
		trust_financial_ledger_transcations 
	INNER JOIN 
	trust_financial_group_ledger_heads 
	ON 
		trust_financial_ledger_transcations.T_FGLH_ID=trust_financial_group_ledger_heads.T_FGLH_ID 
	WHERE  
		trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
		AND T_TRANSACTION_STATUS != 'Cancelled' 
		AND (
			(STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') 
			BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') 
			AND STR_TO_DATE('$toRP', '%d-%m-%Y'))
			OR
			(
			STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') = STR_TO_DATE('$fromRP_OP', '%d-%m-%Y')
			AND T_RP_TYPE = 'OP'
			)
		)
		AND (trust_financial_group_ledger_heads.T_FGLH_PARENT_ID=9 
			OR trust_financial_group_ledger_heads.T_FGLH_PARENT_ID=8) 
		AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%%' 
	GROUP BY 
	trust_financial_group_ledger_heads.T_FGLH_NAME";

	// echo "$sql";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function putNewLedger($group,$nameL,$lft,$rgt,$accountno,$ifsccode,$bankname,$branch,$location,$parentLevel,$jouranalyes,$committeeAssigned,$terminalyes,$fdyes,$maturitystart,$maturityend,$intrestrate,$fdBankName,$fdNumber,$fdBankId) {
		$sql1 ="SELECT @myLeft := ".$lft.", @pId :=T_FGLH_ID, @type_id :=T_TYPE_ID,@acronym :=T_PRIMARY_PARENT_CODE,@subAcronym :=T_LEDGER_PRIMARY_PARENT_CODE FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = '$group'";
		$sql2 ="UPDATE trust_financial_group_ledger_heads SET ".$rgt." = ".$rgt." + 2 WHERE ".$rgt." > @myLeft";
		$sql3 ="UPDATE trust_financial_group_ledger_heads SET ".$lft." = ".$lft." + 2 WHERE ".$lft." > @myLeft";
		if($parentLevel == 'PG') {
			$sql4 ="INSERT INTO 
			trust_financial_group_ledger_heads
			(
			T_FGLH_NAME,
			T_FGLH_PARENT_ID,
			T_LEDGER_PRIMARY_PARENT_CODE,
			T_TYPE_ID,
			 ".$lft.",
			  ".$rgt.",
			  T_LEVELS,
			  T_BANK_NAME,
			  T_ACCOUNT_NO,
			  T_BANK_BRANCH,
			  T_BANK_LOCATION,
			  T_BANK_IFSC_CODE,
			  T_IS_JOURNAL_STATUS,
			  T_COMP_ID,
			  T_IS_TERMINAL,
			  T_IS_FD_STATUS,
			  T_FD_MATURITY_START_DATE,
			  T_FD_MATURITY_END_DATE,
			  T_FD_INTEREST_RATE,
			  FD_BANK_NAME,
			  FD_NUMBER,
			  FD_BANK_ID
			  )
			  VALUES
			  (
				'$nameL',
				@pId,
				@acronym,
				@type_id,
				 @myLeft + 1,
				  @myLeft + 2,
				  'LG',
				  '$bankname',
				  '$accountno',
				  '$branch',
				  '$location',
				  '$ifsccode',
				  $jouranalyes,
				  '$committeeAssigned',
				  $terminalyes,$fdyes,
				  '$maturitystart',
				  '$maturityend',
				  '$intrestrate',
				  '$fdBankName',
				  '$fdNumber',
				  '$fdBankId'
				  )";
		}else {
			$sql4 ="INSERT INTO 
			trust_financial_group_ledger_heads
			(
			T_FGLH_NAME,
			T_FGLH_PARENT_ID,
			T_LEDGER_PRIMARY_PARENT_CODE,
			T_TYPE_ID,
			 ".$lft.",
			  ".$rgt.",
			  T_LEVELS ,
			  T_BANK_NAME ,
			  T_ACCOUNT_NO,
			  T_BANK_BRANCH,
			  T_BANK_LOCATION,
			  T_BANK_IFSC_CODE,
			  T_IS_JOURNAL_STATUS,
			  T_COMP_ID,
			  T_IS_TERMINAL,
			  T_IS_FD_STATUS,
			  T_FD_MATURITY_START_DATE,
			  T_FD_MATURITY_END_DATE,
			  T_FD_INTEREST_RATE,
			  FD_BANK_NAME,
			  FD_NUMBER,
			  FD_BANK_ID
			  )
			 VALUES
			 (
				'$nameL',
				@pId,
				@subAcronym,
				@type_id,
				 @myLeft + 1,
				  @myLeft + 2,
				  'LG',
				  '$bankname',
				  '$accountno',
				  '$branch',
				  '$location',
				  '$ifsccode',
				  $jouranalyes,
				  '$committeeAssigned',
				  $terminalyes,
				  $fdyes,
				  '$maturitystart',
				  '$maturityend',
				  '$intrestrate',
				  '$fdBankName',
				  '$fdNumber',
				  '$fdBankId'
				  )";	
		}
		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);
		return $query1->result();
	}

	function putNewGroup($group,$nameG,$lft,$rgt,$levels,$parentLevel) {	//(TF)
		$sql1 ="SELECT @myLeft := ".$lft.",@pId :=T_FGLH_ID, @type_id :=T_TYPE_ID , @parentAcronym := T_PRIMARY_PARENT_CODE ,@subAcronym :=T_LEDGER_PRIMARY_PARENT_CODE  FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = '$group'";
		$sql2 ="UPDATE trust_financial_group_ledger_heads SET ".$rgt." = ".$rgt." + 2 WHERE ".$rgt." > @myLeft";
		$sql3 ="UPDATE trust_financial_group_ledger_heads SET ".$lft." = ".$lft." + 2 WHERE ".$lft." > @myLeft";
		if($levels == 'PG') {
			$sql4 ="INSERT INTO trust_financial_group_ledger_heads(T_FGLH_NAME,T_FGLH_PARENT_ID,T_TYPE_ID, ".$lft.", ".$rgt.",T_LEVELS) VALUES('$nameG',@pId,@type_id, @myLeft + 1, @myLeft + 2,'$levels')";
		}else {
			if($parentLevel == 'PG') {
				$sql4 ="INSERT INTO trust_financial_group_ledger_heads(T_FGLH_NAME,T_FGLH_PARENT_ID,T_LEDGER_PRIMARY_PARENT_CODE,T_TYPE_ID, ".$lft.", ".$rgt.",T_LEVELS) VALUES('$nameG',@pId,@parentAcronym,@type_id, @myLeft + 1, @myLeft + 2,'$levels')";
			}
			else {
				$sql4 ="INSERT INTO trust_financial_group_ledger_heads(T_FGLH_NAME,T_FGLH_PARENT_ID,T_LEDGER_PRIMARY_PARENT_CODE,T_TYPE_ID, ".$lft.", ".$rgt.",T_LEVELS) VALUES('$nameG',@pId,@subAcronym,@type_id, @myLeft + 1, @myLeft + 2,'$levels')";
			}
		}
		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);
		return $query1->result();
	}

	function getType1($group1) {	//(TF)
		$this->db->select('T_TYPE_ID');
		$this->db->from('trust_financial_group_ledger_heads');
		$this->db->where('T_FGLH_ID',$group1);
		return $this->db->get()->row()->T_TYPE_ID;
	}
	
	function getParentLevel($group1) {	//(TF)
		$this->db->select('T_LEVELS');
		$this->db->from('trust_financial_group_ledger_heads');
		$this->db->where('T_FGLH_ID',$group1);
		return $this->db->get()->row()->T_LEVELS;
	}

	function getMainGroups($condition="") {		//(TF)
		$this->db->select("T_FGLH_NAME,T_FGLH_ID")->from('trust_financial_group_ledger_heads');
		$where = "T_LEVELS='MG'";
		$this->db->where($where);
		if ($condition) {
			$this->db->where($condition);
		}
		$query = $this->db->get();
		return $query->result();
	}

	/*****VOUCHER SETTING*****/
	//GET FINANCE VOUCHER SETTING
	function get_finance_voucher_counter_setting($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from($this->table_finance_voucher_counter);
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

	function edit_finance_voucher_counter_modal($condition=array(),$data_array=array()) {
		if($condition){
			$this->db->where($condition);
		}
		if($this->db->update($this->table_finance_voucher_counter,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	//GET FINACIAL MONTH (TF)
	function get_finance_prerequisites($condition = array(), $order_by_field = '', $order_by_type = "desc") {
		$this->db->from($this->table_finance_prerequisites);
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
	function update_finance_prerequisites($data_array=array()) {
		if($this->db->update($this->table_finance_prerequisites,$data_array)){
			return true;
		} else {
			return false;
		}
	}

	function getledgerdate() { 	//(TF)
		$this->db->select("T_FP_BOOKS_BEGIN_DATE")->from('trust_finance_prerequisites');
		return $this->db->get()->row()->T_FP_BOOKS_BEGIN_DATE;
	}

	// added by adithya
	function getTypeId($fglhId){
		$sql = "SELECT T_TYPE_ID FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = $fglhId";
		
		$query= $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return 0;
		}
	}

	function get_chequeConfiguartion_details($num,$start){
		$sql ="SELECT trust_financial_group_ledger_heads.T_FGLH_ID,T_FGLH_NAME,COUNT(T_FCBD_STATUS) AS CurrChequeBooks,T_BANK_NAME,T_ACCOUNT_NO,T_BANK_BRANCH,T_BANK_LOCATION,T_BANK_IFSC_CODE FROM `trust_financial_group_ledger_heads` LEFT JOIN trust_finance_cheque_book_details ON trust_financial_group_ledger_heads.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID WHERE trust_financial_group_ledger_heads.T_FGLH_PARENT_ID = 9 GROUP BY trust_financial_group_ledger_heads.T_FGLH_ID  ORDER BY T_FGLH_ID LIMIT $start, $num";
		$query= $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//to get number of rows of finacial_group_ledger_heads table
	function count_rows_chequeConfiguartion() {
		$this->db->select()->from('trust_financial_group_ledger_heads');
		$this->db->where('T_FGLH_PARENT_ID',9);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_cheque_details($num,$start,$id) {
		$this->db->select()->from('trust_finance_cheque_book_details');
		$this->db->where('T_FGLH_ID',$id);
		$this->db->order_by('T_FCBD_STATUS','ASC');
		$this->db->limit($num, $start);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function count_rows_cheque_details($id) {
		$this->db->select()->from('trust_finance_cheque_book_details');
		$this->db->where('T_FGLH_ID',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function insert($data) {
		$this->db->insert_batch('trust_finance_cheque_detail', $data);
	}

	function get_ind_cheque_details($num,$start,$id) {
		$this->db->select()->from('trust_finance_cheque_detail');
		$this->db->join('trust_finance_cheque_book_details','trust_finance_cheque_detail.T_FCBD_ID = trust_finance_cheque_book_details.T_FCBD_ID');
		$this->db->where('trust_finance_cheque_detail.T_FCBD_ID',$id);
		$this->db->order_by('T_CHEQUE_NO','ASC');
		$this->db->limit($num, $start);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {   
			return array()   ; 
		}
	}

	function count_rows_ind_cheque_details($id) {
		$this->db->select('T_CHEQUE_NO')->from('trust_finance_cheque_detail');
		$this->db->distinct();
		$this->db->where('T_FCBD_ID',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function getrange() {
		$this->db->select()->from('trust_finance_cheque_detail');
		$this->db->join('trust_finance_cheque_book_details','trust_finance_cheque_detail.T_FCBD_ID = trust_finance_cheque_book_details.T_FCBD_ID');
		$where = '( trust_finance_cheque_book_details.T_FCBD_STATUS = "Active" and trust_finance_cheque_detail.T_FCD_STATUS="Available")order by T_CHEQUE_NO';
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function putPaymentandContraCheque($todayDate,$countNo,$chequeDate,$favouring,$FCD_ID,$acFGLH_ID,$fcbdId) {
  		$sql ="UPDATE `trust_finance_cheque_detail` SET T_FLT_DATE='$todayDate',T_VOUCHER_NO='$countNo',T_CHEQUE_DATE='$chequeDate',T_FAVOURING_NAME='$favouring',T_FCD_STATUS='Unreconciled' WHERE T_FCD_ID = $FCD_ID" ; 
  		$this->db->query($sql);
  		$sql1 ="SELECT COUNT(T_FCD_ID) as getCount FROM `trust_finance_cheque_detail` JOIN trust_finance_cheque_book_details ON trust_finance_cheque_detail.T_FCBD_ID=trust_finance_cheque_book_details.T_FCBD_ID WHERE T_FGLH_ID=$acFGLH_ID AND T_FCD_STATUS='Available' AND T_FCBD_STATUS='Active' AND trust_finance_cheque_detail.T_FCBD_ID = $fcbdId";
		$query = $this->db->query($sql1);
		$AvailChequescount =  $query->row()->getCount;
		if($AvailChequescount == 0) {
			$sql2 ="SELECT T_FCBD_ID FROM `trust_finance_cheque_book_details` WHERE T_FGLH_ID=$acFGLH_ID AND T_FCBD_STATUS='Available'";
			$query2 = $this->db->query($sql2);
			if($query2->num_rows()>0){
				$FRISTFCBD_ID =  $query2->row()->T_FCBD_ID;
			} else {
				$FRISTFCBD_ID ="";
			}
			$sql3 ="UPDATE `trust_finance_cheque_book_details` SET T_FCBD_STATUS='Expired' WHERE T_FGLH_ID=$acFGLH_ID AND T_FCBD_STATUS='Active' AND T_FCBD_ID = $fcbdId" ; 
  			$this->db->query($sql3);
  			if($FRISTFCBD_ID) {
  				$sql4 ="UPDATE `trust_finance_cheque_book_details` SET T_FCBD_STATUS='Active' WHERE T_FCBD_ID=$FRISTFCBD_ID" ; 
  				$this->db->query($sql4);
  			}
		}
  	}

  	function get_all_payment_method_details() {
  		$sql ="SELECT * FROM `trust_receipt` where STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') >= STR_TO_DATE('01-04-2021','%d-%m-%Y') and (RECEIPT_PAYMENT_METHOD='Direct Credit' OR RECEIPT_PAYMENT_METHOD='Credit / Debit Card') AND T_FGLH_ID = 0 AND PAYMENT_STATUS != 'Cancelled' ORDER BY STR_TO_DATE(`trust_receipt`.`RECEIPT_DATE`,'%d-%m-%Y') ASC";
  		$query= $this->db->query($sql);
		return $query->result();
  	}

  	function get_all_event_payment_method_details() {
  		$sql ="SELECT * FROM `trust_event_receipt` where STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') >= STR_TO_DATE('01-04-2021','%d-%m-%Y') and (TET_RECEIPT_PAYMENT_METHOD='Direct Credit' OR TET_RECEIPT_PAYMENT_METHOD='Credit / Debit Card') AND T_FGLH_ID = 0 AND PAYMENT_STATUS != 'Cancelled' ORDER BY STR_TO_DATE(`TET_RECEIPT_DATE`,'%d-%m-%Y')  ASC";
  		$query= $this->db->query($sql);
		return $query->result();
  	}

  	function get_banks() {
		//bank 															//laz
		$this->db->from('trust_financial_group_ledger_heads');
			$this->db->where('T_FGLH_PARENT_ID',9);

			$query = $this->db->get();		
			// echo "$query";							   //laz..
			return $query->result();
	}

	function update_all_payment_method_bank_details($RECEIPT_ID,$tobank) {
		$sql ="UPDATE `trust_receipt` SET T_FGLH_ID = '$tobank'  WHERE RECEIPT_ID = $RECEIPT_ID" ; 
  		$this->db->query($sql);
	}

	function update_all_event_payment_method_bank_details($RECEIPT_ID,$tobank) {
		$sql ="UPDATE `event_receipt` SET T_FGLH_ID = '$tobank'  WHERE TET_RECEIPT_ID = $RECEIPT_ID" ; 
  		$this->db->query($sql);
	}

	function count_rows_bank_details() {
		$sql="SELECT * FROM `trust_receipt` where STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') >= STR_TO_DATE('01-04-2021','%d-%m-%Y') and (RECEIPT_PAYMENT_METHOD='Direct Credit' OR RECEIPT_PAYMENT_METHOD='Credit / Debit Card') AND T_FGLH_ID = 0 AND PAYMENT_STATUS != 'Cancelled' ORDER BY `trust_receipt`.`RECEIPT_DATE` ASC";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getAccountOpBal($condition ="",$compId,$fromDate = "") {	//TS
		$sql = "SELECT TBL1.T_FGLH_ID,TBL1.T_FGLH_NAME,TBL2.BALANCE,TBL2.T_COMP_ID, TBL1.T_TYPE_ID, TBL1.T_FGLH_PARENT_ID,TBL1.T_BANK_NAME,TBL1.T_BANK_BRANCH FROM (SELECT `T_FGLH_NAME`, `trust_financial_group_ledger_heads`.`T_FGLH_ID`, `T_TYPE_ID`, `T_FGLH_PARENT_ID`, `trust_financial_group_ledger_heads`.`T_BANK_NAME`, `trust_financial_group_ledger_heads`.`T_BANK_BRANCH` FROM trust_financial_group_ledger_heads WHERE `trust_financial_group_ledger_heads`.`T_COMP_ID` LIKE '%$compId%' AND `T_LEVELS` = 'LG' AND (`T_FGLH_PARENT_ID` = 8 OR `T_FGLH_PARENT_ID` = 9) $condition GROUP BY trust_financial_group_ledger_heads.T_FGLH_ID) as tbl1 left join (SELECT trust_financial_ledger_transcations.T_FGLH_ID, SUM(T_FLT_DR-T_FLT_CR) AS BALANCE,trust_financial_ledger_transcations.T_COMP_ID FROM trust_financial_ledger_transcations WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  `trust_financial_ledger_transcations`.`T_COMP_ID` LIKE '%$compId%' AND STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') < STR_TO_DATE('".$fromDate."','%d-%m-%Y') GROUP BY trust_financial_ledger_transcations.T_FGLH_ID) as tbl2 on tbl1.T_FGLH_ID = tbl2.T_FGLH_ID";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getAccountClosingBal($condition ="",$compId,$Date = "") {	//TS
		$sql = "SELECT TBL1.T_FGLH_ID,TBL1.T_FGLH_NAME,TBL2.BALANCE,TBL2.T_COMP_ID, TBL1.T_TYPE_ID, TBL1.T_FGLH_PARENT_ID,TBL1.T_BANK_NAME,TBL1.T_BANK_BRANCH FROM (SELECT `T_FGLH_NAME`, `trust_financial_group_ledger_heads`.`T_FGLH_ID`, `T_TYPE_ID`, `T_FGLH_PARENT_ID`, `trust_financial_group_ledger_heads`.`T_BANK_NAME`, `trust_financial_group_ledger_heads`.`T_BANK_BRANCH` FROM trust_financial_group_ledger_heads WHERE `trust_financial_group_ledger_heads`.`T_COMP_ID` LIKE '%$compId%' AND `T_LEVELS` = 'LG' AND (`T_FGLH_PARENT_ID` = 8 OR `T_FGLH_PARENT_ID` = 9) $condition GROUP BY trust_financial_group_ledger_heads.T_FGLH_ID) as tbl1 left join (SELECT trust_financial_ledger_transcations.T_FGLH_ID, SUM(T_FLT_DR-T_FLT_CR) AS BALANCE,trust_financial_ledger_transcations.T_COMP_ID FROM trust_financial_ledger_transcations WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  `trust_financial_ledger_transcations`.`T_COMP_ID` LIKE '%$compId%' AND STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') <= STR_TO_DATE('".$Date."','%d-%m-%Y') GROUP BY trust_financial_ledger_transcations.T_FGLH_ID) as tbl2 on tbl1.T_FGLH_ID = tbl2.T_FGLH_ID";
		$query = $this->db->query($sql);	
		return $query->result();
	}
	
	function get_dayBook_details($fromDate = "", $toDate = "", $num=10,$start,$compId,$voucherType='',$paymentType=""){
		if ($voucherType != '') {
			$condition = "AND T_RP_TYPE = '$voucherType'";
		}else {
			$condition = "";
		}
		if ($paymentType != '' && $voucherType =='P1' ) {
			$condition1 = "AND T_VOUCHER_NO like '%$paymentType%'";
		}else {
			$condition1 = "";
		}
 		if($fromDate != "" && $toDate != "") {
			$sql ="SELECT T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' THEN 'Payment' WHEN `T_RP_TYPE`='C1' THEN 'Contra' WHEN `T_RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,T_TRANSACTION_STATUS,T_RECEIPT_ID FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and  STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE!='OP' $condition $condition1 GROUP BY T_VOUCHER_NO  ORDER BY T_FLT_ID DESC,STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') DESC LIMIT $start, $num";
		} else {
			$sql="SELECT T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' THEN 'Payment' WHEN `T_RP_TYPE`='C1' THEN 'Contra' WHEN `T_RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,T_TRANSACTION_STATUS,T_RECEIPT_ID FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and  STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE!='OP'  $condition $condition1  GROUP BY T_VOUCHER_NO ORDER BY T_FLT_ID DESC,STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') DESC LIMIT $start, $num";
		}
		$query= $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function count_rows_dayBook($fromDate = "", $toDate = "",$compId,$voucherType="",$paymentType="") {
		if ($voucherType != '') {
			$condition = "AND T_RP_TYPE = '$voucherType'";
		}else {
			$condition = "";
		}
		if ($paymentType != ''  && $voucherType =='P1') {
			$condition1 = "AND T_VOUCHER_NO like '%$paymentType%'";
		}else {
			$condition1 = "";
		}
		if($fromDate != "" && $toDate != "") {
		$sql ="SELECT COUNT(*) AS COUNNT_DAY_BOOK FROM(SELECT T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' THEN 'Payment' WHEN `T_RP_TYPE`='C1' THEN 'Contra' WHEN `T_RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and  STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE!='OP' $condition $condition1 GROUP BY T_VOUCHER_NO  ORDER BY STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') DESC) as bookcount";
		} else {
		$sql ="SELECT COUNT(*) AS COUNNT_DAY_BOOK FROM(SELECT T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' THEN 'Payment' WHEN `T_RP_TYPE`='C1' THEN 'Contra' WHEN `T_RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and  STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE!='OP' $condition $condition1 GROUP BY T_VOUCHER_NO  ORDER BY STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') DESC) as bookcount";
		}
		$query = $this->db->query($sql);
		return $query->row()->COUNNT_DAY_BOOK;
	}

	function get_day_Book_details($VOUCHER_NO,$FLT_DATE = "") {
		$sql="SELECT T_VOUCHER_NO,T_FLT_DATE,
		      trust_financial_ledger_transcations.T_FLT_DATE,
			  T_PAYMENT_METHOD,T_RECEIPT_FAVOURING_NAME,
		      (CASE WHEN T_RP_TYPE ='P2' 
			        THEN 'From:' 
					WHEN T_RP_TYPE ='P1' 
					THEN 'To:' 
					WHEN SUBSTR(T_RP_TYPE,2,1) = 1 
					THEN 'From:' 
					WHEN SUBSTR(T_RP_TYPE,2,1) = 2 
					THEN 'To:' END ) 
					AS Account,trust_financial_ledger_transcations.T_RP_TYPE,
					(CASE WHEN SUBSTR(`T_RP_TYPE`,1,1) = 'R' 
					THEN 'Receipt' 
					WHEN SUBSTR(`T_RP_TYPE`,1,1) = 'P' 
					THEN 'Payment' WHEN SUBSTR(`T_RP_TYPE`,1,1) = 'C' 
					THEN 'Contra' WHEN SUBSTR(`T_RP_TYPE`,1,1) = 'J' 
					THEN 'Journal' ELSE 'Unknown' END ) as VOUCHER_TYPE,
					T_FLT_NARRATION,T_FLT_DR,T_FLT_CR,
					T_RECEIPT_ID,T_RP_TYPE,
					trust_financial_ledger_transcations.T_FGLH_ID ,
					T_FGLH_NAME,
					T_TRANSACTION_STATUS,
					T_CHEQUE_NO
					FROM trust_financial_group_ledger_heads 
					inner JOIN trust_financial_ledger_transcations 
					on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID 
					WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
					and (STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y')) AND T_RP_TYPE!='OP' AND T_VOUCHER_NO ='$VOUCHER_NO'";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function get_day_Book_details_narration($VOUCHER_NO,$FLT_DATE = "") {
		$sql="SELECT T_VOUCHER_NO,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,(CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P2' THEN 'Payment' WHEN `T_RP_TYPE`='1' THEN 'Journal' ELSE 'notfound' END )as VOUCHER_TYPE,T_FLT_NARRATION FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y'))AND T_RP_TYPE!='OP' AND T_VOUCHER_NO ='$VOUCHER_NO'";
		$query= $this->db->query($sql);
		return $query->row()->T_FLT_NARRATION;
	}

	function get_day_Book_details_chequeno($VOUCHER_NO,$FLT_DATE = "") {
		$sql="SELECT T_VOUCHER_NO,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_CHEQUE_NO,(CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P2' THEN 'Payment' WHEN `T_RP_TYPE`='1' THEN 'Journal' ELSE 'notfound' END )as VOUCHER_TYPE,T_FLT_NARRATION FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y'))AND T_RP_TYPE!='OP' AND T_VOUCHER_NO ='$VOUCHER_NO'";
		$query= $this->db->query($sql);
		return $query->row()->T_CHEQUE_NO;
	}

	function get_day_Book_details_chequedate($VOUCHER_NO,$FLT_DATE = "") {
		$sql="SELECT T_VOUCHER_NO,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_CHEQUE_NO,T_CHEQUE_DATE,(CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P2' THEN 'Payment' WHEN `T_RP_TYPE`='1' THEN 'Journal' ELSE 'notfound' END )as VOUCHER_TYPE,T_FLT_NARRATION FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y'))AND T_RP_TYPE!='OP' AND T_VOUCHER_NO ='$VOUCHER_NO'";
		$query= $this->db->query($sql);
		return $query->row()->T_CHEQUE_DATE;
	}

	function get_day_Book_details_vouchertype($VOUCHER_NO,$FLT_DATE = "") {
		$sql="SELECT T_VOUCHER_NO,T_FLT_DATE,(CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' THEN 'Payment' WHEN `T_RP_TYPE`='C1' THEN 'Contra' WHEN `T_RP_TYPE`='J1' THEN 'Journal' ELSE 'notfound' END )as VOUCHER_TYPE,T_FLT_NARRATION FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y')) AND T_RP_TYPE!='OP' AND T_VOUCHER_NO ='$VOUCHER_NO'";
		$query= $this->db->query($sql);
		return $query->row()->VOUCHER_TYPE;
	}

	function get_dayBook_details_excel($fromDate = "", $toDate = "", $num=10,$start, $compId,$voucherType="",$paymentType="") {	//TS R
		if ($voucherType != '') {
			$condition = "AND T_RP_TYPE = '$voucherType'";
		}else {
			$condition = "";
		}
		if ($paymentType != ''  && $voucherType =='P1') {
			$condition1 = "AND T_VOUCHER_NO like '%$paymentType%'";
		}else {
			$condition1 = "";
		}
		if($fromDate != "" && $toDate != "") {
		$sql ="SELECT T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' THEN 'Payment' WHEN `T_RP_TYPE`='C1' THEN 'Contra' WHEN `T_RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,T_TRANSACTION_STATUS FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')) AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE != 'OP' GROUP BY T_VOUCHER_NO ";
		} else {
			$sql ="SELECT T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' THEN 'Payment' WHEN `T_RP_TYPE`='C1' THEN 'Contra' WHEN `T_RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,T_TRANSACTION_STATUS FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and ( STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y'))  AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE != 'OP'GROUP BY T_VOUCHER_NO  ";
		}
		$query= $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function get_dayBook_report($fromDate = "", $toDate = "", $num=10,$start, $compId,$voucherType="",$paymentType=""){		//TS R
		if ($voucherType != '') {
			$condition = "AND T_RP_TYPE = '$voucherType'";
		} else {
			$condition = "";
		}
		if ($paymentType != ''  && $voucherType =='P1') {
			$condition1 = "AND T_VOUCHER_NO like '%$paymentType%'";
		} else {
			$condition1 = "";
		}
		$sql ="SELECT T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' THEN 'Payment' WHEN `T_RP_TYPE`='C1' THEN 'Contra' WHEN `T_RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,T_TRANSACTION_STATUS FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')) AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE!='OP' $condition $condition1 GROUP BY T_VOUCHER_NO";		
		$query = $this->db->query($sql);
		return $query->result('array');
	}
	
	function get_dayBook_report1($date,  $compId,$voucherType="",$paymentType=""){		//TS R
		if ($voucherType != '') {
			$condition = "AND T_RP_TYPE = '$voucherType'";
		}else{
			$condition = "";
		}
		if ($paymentType != ''  && $voucherType =='P1') {
			$condition1 = "AND T_VOUCHER_NO like '%$paymentType%'";
		}else {
			$condition1 = "";
		}
	 	$sql ="SELECT T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE`='R1' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' THEN 'Payment' WHEN `T_RP_TYPE`='C1' THEN 'Contra' WHEN `T_RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,T_TRANSACTION_STATUS FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and  T_FLT_DATE = '$date' AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE!='OP' $condition $condition1 GROUP BY T_VOUCHER_NO";
		$query = $this->db->query($sql);
		return $query->result('array');
	}

	function getCashReceipts() {	//TS
	 	$sql ="SELECT T_FGLH_ID,T_FGLH_NAME,AMOUNT,BankLedgerId FROM
			   (SELECT trust_financial_ledger_transcations.T_FGLH_ID,trust_financial_group_ledger_heads.T_FGLH_NAME,
   				SUM(T_FLT_CR) as AMOUNT from trust_financial_ledger_transcations INNER JOIN trust_financial_group_ledger_heads on trust_financial_ledger_transcations.T_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID
				WHERE T_RP_TYPE='R1' and trust_financial_ledger_transcations.T_PAYMENT_METHOD ='Cash' AND T_CASH_DEPOSITED_STATUS='' and T_TRANSACTION_STATUS != 'Cancelled'
				group BY T_FGLH_ID) as CashTrans LEFT JOIN (SELECT trust_bank_ledger_allocation.T_LEDGER_FGLH_ID, GROUP_CONCAT(trust_bank_ledger_allocation.T_BANK_FGLH_ID) AS BankLedgerId FROM trust_financial_group_ledger_heads LEFT JOIN trust_bank_ledger_allocation ON trust_bank_ledger_allocation.T_LEDGER_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID GROUP BY T_FGLH_ID) as ReceiptLedgersBank
				ON CashTrans.T_FGLH_ID = ReceiptLedgersBank.T_LEDGER_FGLH_ID";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getIndividualCashReceipts() {	//TS
	 	$sql ="SELECT T_FGLH_ID,T_FGLH_NAME,AMOUNT,BankLedgerId,T_FLT_DATE,T_FLT_ID FROM
			   (SELECT trust_financial_ledger_transcations.T_FGLH_ID,trust_financial_group_ledger_heads.T_FGLH_NAME,
   				T_FLT_CR as AMOUNT ,T_FLT_DATE,T_FLT_ID from trust_financial_ledger_transcations INNER JOIN trust_financial_group_ledger_heads on trust_financial_ledger_transcations.T_FGLH_ID =  trust_financial_group_ledger_heads.T_FGLH_ID
				WHERE T_RP_TYPE='R1' and trust_financial_ledger_transcations.T_PAYMENT_METHOD ='Cash' AND T_CASH_DEPOSITED_STATUS='' and T_TRANSACTION_STATUS != 'Cancelled'
				) as CashTrans INNER JOIN (SELECT trust_bank_ledger_allocation.T_LEDGER_FGLH_ID, GROUP_CONCAT(trust_bank_ledger_allocation.T_BANK_FGLH_ID) AS BankLedgerId FROM trust_financial_group_ledger_heads INNER JOIN trust_bank_ledger_allocation ON trust_bank_ledger_allocation.T_LEDGER_FGLH_ID = trust_financial_group_ledger_heads.T_FGLH_ID GROUP BY T_FGLH_ID) as ReceiptLedgersBank
				ON CashTrans.T_FGLH_ID = ReceiptLedgersBank.T_LEDGER_FGLH_ID ORDER BY  STR_TO_DATE(T_FLT_DATE, '%d-%m-%Y')";
		$query = $this->db->query($sql);
		return $query->result();
	}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
	function putCashReceipt($fId,$todayDate) {
		$sql ="UPDATE trust_financial_ledger_transcations SET T_CASH_DEPOSITED_STATUS = 'Done' , T_CASH_DEPOSITED_DATE='$todayDate' WHERE T_RP_TYPE='R1' and trust_financial_ledger_transcations.T_PAYMENT_METHOD ='Cash' AND T_CASH_DEPOSITED_STATUS='' AND trust_financial_ledger_transcations.T_FLT_ID=$fId" ; 
  		$this->db->query($sql);
	}

	function getAllocationHeads() {		// (TF)
	 	$sql ="SELECT TBL2.T_FGLH_NAME,TBL2.T_FGLH_ID FROM (SELECT T_FGLH_PARENT_ID FROM trust_financial_group_ledger_heads WHERE T_LEVELS='LG' ) AS TBL1, (SELECT T_FGLH_ID,T_FGLH_NAME FROM trust_financial_group_ledger_heads) AS TBL2 WHERE TBL2.T_FGLH_ID=TBL1.T_FGLH_PARENT_ID AND TBL1.T_FGLH_PARENT_ID!=8 AND TBL1.T_FGLH_PARENT_ID!=9 GROUP BY TBL2.T_FGLH_NAME";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getAllocationLedgers(){		// (TF)
		 $sql ="SELECT T_FGLH_PARENT_ID,T_FGLH_ID,T_FGLH_NAME,T_COMP_ID FROM trust_financial_group_ledger_heads WHERE T_LEVELS='LG' AND T_FGLH_PARENT_ID!=8 AND T_FGLH_PARENT_ID!=9";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function putAllocatedLedger($last_id,$ledgerFglhId) {
		$this->db->query("INSERT INTO `trust_bank_ledger_allocation`(`T_BANK_FGLH_ID`,`T_LEDGER_FGLH_ID`) VALUES ($last_id,$ledgerFglhId)");
		return $this->db->insert_id();
	}

	function getPettyCashData($compId){	//TS
		$sql="SELECT TBL1.T_FGLH_ID, TBL1.T_FGLH_NAME, TBL1.AMOUNT, IF(GROUP_CONCAT(TBL2.T_LEDGER_FGLH_ID) IS NULL,'',GROUP_CONCAT(TBL2.T_LEDGER_FGLH_ID)) AS OTHER_LEDGER_ID,
			IF(GROUP_CONCAT(TBL2.T_FGLH_NAME) IS NULL,'',GROUP_CONCAT(TBL2.T_FGLH_NAME)) AS OTHER_LEDGER_NAME,TBL1.T_COMP_ID
			FROM (SELECT trust_financial_group_ledger_heads.T_FGLH_ID,trust_financial_group_ledger_heads.T_FGLH_NAME, SUM(T_FLT_DR)-SUM(T_FLT_CR) AS AMOUNT,trust_financial_group_ledger_heads.T_COMP_ID
			FROM `trust_financial_ledger_transcations` 
			INNER JOIN trust_financial_group_ledger_heads ON trust_financial_group_ledger_heads.T_FGLH_ID = trust_financial_ledger_transcations.T_PC_PAY_GROUP
			WHERE T_PC_PAY_GROUP != '' AND trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled'
			GROUP BY trust_financial_group_ledger_heads.T_FGLH_NAME) AS TBL1 LEFT JOIN 
			(SELECT trust_bank_ledger_allocation.T_BANK_FGLH_ID, trust_bank_ledger_allocation.T_LEDGER_FGLH_ID, trust_financial_group_ledger_heads.T_FGLH_NAME FROM trust_bank_ledger_allocation INNER JOIN trust_financial_group_ledger_heads ON trust_financial_group_ledger_heads.T_FGLH_ID = trust_bank_ledger_allocation.T_LEDGER_FGLH_ID) AS TBL2 
			ON TBL1.T_FGLH_ID = TBL2.T_BANK_FGLH_ID WHERE TBL1.T_COMP_ID LIKE '%$compId%'
			GROUP BY TBL1.T_FGLH_ID";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function incrementVoucherCounter($fvcId) {
		$this->db->select()->from('trust_finance_voucher_counter')
		->where(array('trust_finance_voucher_counter.T_FVC_ID'=>$fvcId));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->T_FVC_COUNTER+1;
		$this->db->where('trust_finance_voucher_counter.T_FVC_ID',$fvcId);
		$this->db->update('trust_finance_voucher_counter', array('T_FVC_COUNTER'=>$counter));
	}

	function getReceiptFormat($voucherCategoryNo) {
		$this->db->select()->from('trust_finance_voucher_counter')
		->where(array('trust_finance_voucher_counter.T_FVC_ID'=>$voucherCategoryNo));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->T_FVC_COUNTER+1;	
		$dfMonth = $this->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$receiptFormat = $deityCounter->T_FVC_ABBR1 ."/".$datMonth."/".$deityCounter->T_FVC_ABBR2."/".$counter;
		return $receiptFormat;
	}

	//GET FINACIAL MONTH 
	function get_financial_month($condition = array(), $order_by_field = '', $order_by_type = "desc") {
		$this->db->from('FINANCIAL_YEAR');
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

	public function get_financial_year($month) {
		$dbFinMth = $month->MONTH_IN_NUMBER; //getting value from the database for start financial month 
		$currFinMth = date('n');
		if($dbFinMth == 1) {
			$fYear = date('Y');
		} else {
			if($currFinMth >= $dbFinMth && $currFinMth <= 12) {
				$year1 = date('Y');
				$year2 = $year1 + 1; 
			}
			if($currFinMth >= 1 && $currFinMth <= $dbFinMth - 1) {
				$year1 = date('Y')-1;
				$year2 = date('Y');
			}
			$fYear = $year1.'-'.substr($year2,2,2);
		}
		return $fYear;
	}

	function putGroupLedgerHistory($last_id,$name,$userId,$operation,$levels,$date,$dateTime,$oldLedgerParentId="") {	//(TF)
		$this->db->query("INSERT INTO `trust_finnancial_heads_history`(`T_FGLH_ID`,`T_FGLH_NAME`,`T_USER_ID`,`T_OPERATION`,`T_LEVELS`,`T_DATE`,`T_DATE_TIME`,`T_OLD_FGLH_PARENT_ID`) VALUES ($last_id,'$name',$userId,'$operation','$levels','$date','$dateTime','$oldLedgerParentId')");
		return $this->db->insert_id();
	}

	function get_ledger_breakup_details($FGLH_ID,$num=10,$start=0,$from,$to,$compId) {	//TS
		$sql ="SELECT * from(SELECT T_FLT_ID,T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE,(CASE WHEN `T_RP_TYPE`='R1' or `T_RP_TYPE`='R2' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' or `T_RP_TYPE`='P2' THEN 'Payment' WHEN `T_RP_TYPE`='C1' or `T_RP_TYPE`='C2' THEN 'Contra' WHEN `T_RP_TYPE`='J1' or `T_RP_TYPE`='J2' THEN 'Journal'  WHEN `T_RP_TYPE`='OP' THEN 'Openning Balance' ELSE 'Unknown' END )as VOUCHER_TYPE FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  trust_financial_group_ledger_heads.T_FGLH_ID =$FGLH_ID and  STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$from', '%d-%m-%Y') AND STR_TO_DATE('$to', '%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' GROUP BY T_VOUCHER_NO ORDER BY T_FLT_DATE) as TBL1,
			(SELECT T_FLT_ID,IF(T_RP_TYPE!='OP',T_FGLH_NAME,'') as Particular,T_VOUCHER_NO ,T_TYPE_ID FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID ) AS TBL2 WHERE TBL1.T_VOUCHER_NO = TBL2.T_VOUCHER_NO AND TBL2.T_FLT_ID!= TBL1.T_FLT_ID group by TBL1.T_VOUCHER_NO order by TBL1.T_FLT_ID LIMIT $start, $num";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function get_ledger_breakup_details_RP($FGLH_ID,$num=10,$start=0,$from,$to,$compId) {	//TS
		$sql ="SELECT * from(SELECT T_FLT_ID,T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE`='R1' or `T_RP_TYPE`='R2' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' or `T_RP_TYPE`='P2' THEN 'Payment' WHEN `T_RP_TYPE`='C1' or `T_RP_TYPE`='C2' THEN 'Contra' WHEN `T_RP_TYPE`='J1' or `T_RP_TYPE`='J2' THEN 'Journal'  WHEN `T_RP_TYPE`='OP' THEN 'Openning Balance' ELSE 'Unknown' END )as VOUCHER_TYPE FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  trust_financial_group_ledger_heads.T_FGLH_ID =25 and  STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$from', '%d-%m-%Y') AND STR_TO_DATE('$to', '%d-%m-%Y')AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' and T_RP_TYPE !='OP' GROUP BY T_VOUCHER_NO ORDER BY T_FLT_DATE) as TBL1,
			(SELECT T_FLT_ID,T_FGLH_NAME as Particular,T_VOUCHER_NO FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID ) AS TBL2 WHERE TBL1.T_VOUCHER_NO = TBL2.T_VOUCHER_NO AND TBL2.T_FLT_ID!= TBL1.T_FLT_ID group by TBL1.T_VOUCHER_NO order by TBL1.T_FLT_DATE LIMIT $start, $num";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function get_ledger_closing_details($FGLH_ID,$from,$firstFrom,$compId) {		//TS
		$sql ="SELECT trust_financial_group_ledger_heads.T_FGLH_ID,sum(T_FLT_DR-T_FLT_CR) as amount FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and trust_financial_group_ledger_heads.T_FGLH_ID = $FGLH_ID and  STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') >= STR_TO_DATE('$from', '%d-%m-%Y') AND STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') < STR_TO_DATE('$firstFrom', '%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' ";
		$query= $this->db->query($sql);
		return $query->row()->amount;
	}

	function get_ledger_breakup_details_count($FGLH_ID,$from,$to,$compId) {	//TS
		$sql ="SELECT * from(SELECT T_FLT_ID,T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE`='R1' or `T_RP_TYPE`='R2' THEN 'Receipt' WHEN `T_RP_TYPE`='P1' or `T_RP_TYPE`='P2' THEN 'Payment' WHEN `T_RP_TYPE`='C1' or `T_RP_TYPE`='C2' THEN 'Contra' WHEN `T_RP_TYPE`='J1' or `T_RP_TYPE`='J2' THEN 'Journal'  WHEN `T_RP_TYPE`='OP' THEN 'Openning Balance' ELSE 'Unknown' END )as VOUCHER_TYPE FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID where trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  trust_financial_group_ledger_heads.T_FGLH_ID =$FGLH_ID and  STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$from', '%d-%m-%Y') AND STR_TO_DATE('$to', '%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' GROUP BY T_VOUCHER_NO ORDER BY T_FLT_DATE) as TBL1,
			(SELECT T_FLT_ID,T_FGLH_NAME as Particular,T_VOUCHER_NO FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID ) AS TBL2 WHERE TBL1.T_VOUCHER_NO = TBL2.T_VOUCHER_NO AND TBL2.T_FLT_ID!= TBL1.T_FLT_ID group by TBL1.T_VOUCHER_NO order by TBL1.T_FLT_DATE ";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function get_legder_grid_breakup_details($FGLH_ID,$from,$to,$num=10,$start=0) {	//TS
		$sql ="SELECT sum(tbl1.RECEIPT_PRICE) as AMOUNT,tbl1.SEVA_NAME,tbl1.SEVA_ID
		FROM (SELECT deity_receipt.Receipt_ID,RECEIPT_NO,RECEIPT_DATE,shashwath_seva.SS_ID,shashwath_seva.SEVA_ID,SEVA_NAME,RECEIPT_PRICE,EOD_CONFIRMED_DATE,T_FLT_DATE,trust_financial_ledger_transcations.T_FGLH_ID FROM `deity_receipt`
		inner join shashwath_seva on deity_receipt.SS_ID = shashwath_seva.SS_ID
		INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
		JOIN trust_financial_ledger_transcations ON deity_receipt.RECEIPT_DATE = trust_financial_ledger_transcations.T_FLT_DATE
		where deity_receipt.RECEIPT_CATEGORY_ID =7 and STR_TO_DATE(deity_receipt.RECEIPT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$from', '%d-%m-%Y') AND STR_TO_DATE('$to', '%d-%m-%Y') and deity_receipt.EOD_CONFIRMED_DATE !='' and T_TRANSACTION_STATUS != 'Cancelled' GROUP BY deity_receipt.Receipt_ID) as tbl1  GROUP BY tbl1.SEVA_ID LIMIT $start, $num";
		$query= $this->db->query($sql);
		return $query->result();
	}
	
	function get_ledger_breakup_details_grid_count($FGLH_ID,$from,$to) {		//TS
		$sql ="SELECT sum(tbl1.RECEIPT_PRICE) as AMOUNT,tbl1.SEVA_NAME,tbl1.SEVA_ID
		FROM (SELECT deity_receipt.Receipt_ID,RECEIPT_NO,RECEIPT_DATE,shashwath_seva.SS_ID,shashwath_seva.SEVA_ID,SEVA_NAME,RECEIPT_PRICE,EOD_CONFIRMED_DATE,FLT_DATE,financial_ledger_transcations.FGLH_ID FROM `deity_receipt`
		inner join shashwath_seva on deity_receipt.SS_ID = shashwath_seva.SS_ID
		INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
		JOIN financial_ledger_transcations ON deity_receipt.RECEIPT_DATE = financial_ledger_transcations.FLT_DATE
		where deity_receipt.RECEIPT_CATEGORY_ID =7 and STR_TO_DATE(deity_receipt.RECEIPT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$from', '%d-%m-%Y') AND STR_TO_DATE('$to', '%d-%m-%Y') and deity_receipt.EOD_CONFIRMED_DATE !='' and TRANSACTION_STATUS != 'Cancelled' GROUP BY deity_receipt.Receipt_ID) as tbl1  GROUP BY tbl1.SEVA_ID";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getCommittee() {
		$this->db->select()->from('trust_finance_committee');
		$query = $this->db->get();
		return $query->result();
	}

	function getAssignedCommittee($condition,$LEDGER_FGLH_ID) {
		$sql ="SELECT trust_finance_committee.T_COMP_ID,
		       T_COMP_NAME, IF(T_TYPE_ID='A' OR T_TYPE_ID='E', T_FLT_DR, T_FLT_CR) AS BALANCE,
			   T_FLT_ID FROM `trust_finance_committee` 
			    JOIN trust_financial_ledger_transcations 
				on trust_finance_committee.T_COMP_ID = trust_financial_ledger_transcations.T_COMP_ID 
				JOIN trust_financial_group_ledger_heads 
				ON trust_financial_ledger_transcations.T_FGLH_ID=trust_financial_group_ledger_heads.T_FGLH_ID 
				where ($condition ) 
				AND (trust_financial_ledger_transcations.T_FGLH_ID=$LEDGER_FGLH_ID AND T_RP_TYPE='OP')";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function getAllCommittee() {
		$sql ="SELECT * FROM `trust_finance_committee`";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function putCommitteeDetails($committeename) {
		$this->db->query("INSERT INTO `trust_finance_committee`(`T_COMP_NAME`) VALUES ('$committeename')");
		return $this->db->insert_id();
	}

	function discardLedger($name,$ledgerId,$lft,$rgt,$parentLevel) {
		$sql1 = "SELECT @myLeft  := ".$lft.", @myRight  := ".$rgt." , @myWidth := ".$rgt." -  ".$lft." + 1 FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = '$ledgerId'";
		$sql2 = "DELETE FROM trust_financial_group_ledger_heads WHERE ".$lft." BETWEEN @myLeft AND @myRight";
		$sql3 = "UPDATE trust_financial_group_ledger_heads SET ".$rgt."  = ".$rgt."  - @myWidth WHERE ".$rgt."  > @myRight";
		$sql4 =  "UPDATE trust_financial_group_ledger_heads SET ".$lft." = ".$lft." - @myWidth WHERE ".$lft." > @myRight";
		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);
		return $query1->result();
	}

	function discardGroup($underId,$name,$lft,$rgt,$groupId) {
		$sql1 = "SELECT @myLeft := ".$lft.", @myRight := ".$rgt.", @myWidth := ".$rgt." -  ".$lft." + 1 FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = '$groupId'";
		$sql2 = "DELETE FROM trust_financial_group_ledger_heads WHERE ".$lft." BETWEEN @myLeft AND @myRight";
		$sql3 = "UPDATE trust_financial_group_ledger_heads SET ".$rgt."  = ".$rgt." - @myWidth WHERE ".$rgt." > @myRight";
		$sql4 = "UPDATE trust_financial_group_ledger_heads SET ".$lft." = ".$lft." - @myWidth WHERE ".$lft." > @myRight";
		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);
		return $query1->result();
	}

	function putTransferLedger($transferLedgerId,$transferLedgerparentId,$lft,$rgt,$parentLevel,$lftParent,$rgtParent,$checkType,$checkTypeParent) {
		$sql1 = "SELECT @myLeft  := $lft , @myRight := $rgt, @myWidth := $rgt - $lft + 1  FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = $transferLedgerId";
		$sql2 = "UPDATE trust_financial_group_ledger_heads SET $rgt = $rgt - @myWidth WHERE $rgt > @myRight";
		$sql3 = "UPDATE trust_financial_group_ledger_heads SET $lft = $lft - @myWidth WHERE $lft > @myRight";
		$sql4 = "UPDATE trust_financial_group_ledger_heads SET $lft = 0 ,$rgt = 0 WHERE T_FGLH_ID = $transferLedgerId";
		if($checkType != $checkTypeParent) {
			$sql5 ="SELECT @DR:=T_FLT_DR,@CR:=T_FLT_CR FROM `trust_financial_ledger_transcations` WHERE T_FGLH_ID= $transferLedgerId and T_RP_TYPE ='OP'";
			$sql6 ="UPDATE `trust_financial_ledger_transcations` SET T_FLT_DR=@CR,T_FLT_CR=@DR  WHERE T_FGLH_ID= $transferLedgerId and T_RP_TYPE ='OP'";
		}
		$sql7 = "SELECT @myLeft := $lftParent, @pId :=T_FGLH_ID, @type_id :=T_TYPE_ID,@acronym :=T_PRIMARY_PARENT_CODE,@subAcronym :=T_LEDGER_PRIMARY_PARENT_CODE FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = $transferLedgerparentId ";
		$sql8 = "UPDATE trust_financial_group_ledger_heads SET  $rgtParent=  $rgtParent + 2 WHERE  $rgtParent > @myLeft";
		$sql9 = "UPDATE trust_financial_group_ledger_heads SET  $lftParent =  $lftParent + 2 WHERE  $lftParent > @myLeft";
		if($parentLevel == 'PG') {
			$sql10 = "UPDATE  trust_financial_group_ledger_heads SET  $lftParent = @myLeft + 1, $rgtParent = @myLeft + 2, T_FGLH_PARENT_ID=@pId ,T_TYPE_ID=@type_id,T_LEDGER_PRIMARY_PARENT_CODE = @acronym  WHERE  T_FGLH_ID= $transferLedgerId";
		} else {
			$sql10 = "UPDATE  trust_financial_group_ledger_heads SET  $lftParent = @myLeft + 1, $rgtParent = @myLeft + 2, T_FGLH_PARENT_ID=@pId ,T_TYPE_ID=@type_id,T_LEDGER_PRIMARY_PARENT_CODE = @subAcronym WHERE  T_FGLH_ID= $transferLedgerId";
		}
		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);
		if($checkType != $checkTypeParent) {
			$query5 = $this->db->query($sql5);
			$query6 = $this->db->query($sql6);
		}	
		$query7 = $this->db->query($sql7);
		$query8 = $this->db->query($sql8);
		$query9 = $this->db->query($sql9);
		$query10 = $this->db->query($sql10);
		return $query1->result();
	}

	function putmultiPaymentCheque($fcbid,$chequestatus,$chequeno) {
		$sql1="INSERT INTO trust_finance_cheque_detail(T_FCBD_ID,T_CHEQUE_NO,T_FCD_STATUS,T_IS_MULTI_PAYMENT) VALUES($fcbid,$chequeno,'Available',1)";	
		$query1 = $this->db->query($sql1);
		$sql2 ="SELECT T_FCBD_ID FROM `trust_finance_cheque_detail` WHERE T_FCD_STATUS='Available' and T_FCBD_ID= $fcbid ";
		$query2 = $this->db->query($sql2);
		if($query2->num_rows()>0) {
			$sql3 ="UPDATE `trust_finance_cheque_book_details` SET T_FCBD_STATUS='Active' where T_FCBD_ID= $fcbid " ; 
	  		$this->db->query($sql3);
		}
	}	

	function deletemultiPaymentCheque($fcdidno) {
		$sql1="DELETE From trust_finance_cheque_detail where T_FCD_ID= $fcdidno";	
		$query1 = $this->db->query($sql1);
	}

	function putTransferGroup($transferGroupId,$transferGroupParentId,$lft,$rgt,$parentLevel,$lftParent,$rgtParent,$checkType,$checkTypeParent) {
		$sql1 = "SELECT @myLeft  := $lft , @myRight := $rgt, @myWidth := $rgt - $lft + 1  FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = $transferGroupId";
		$sql2 = "UPDATE trust_financial_group_ledger_heads SET $rgt = $rgt - @myWidth WHERE $rgt > @myRight";
		$sql3 = "UPDATE trust_financial_group_ledger_heads SET $lft = $lft - @myWidth WHERE $lft > @myRight";
		$sql4 = "UPDATE trust_financial_group_ledger_heads SET $lft = 0 ,$rgt = 0 WHERE T_FGLH_ID = $transferGroupId";
		$sql7 = "SELECT @myParentLeft := $lftParent, @pId :=T_FGLH_ID, @type_id :=T_TYPE_ID,@acronym :=T_PRIMARY_PARENT_CODE,@subAcronym :=T_LEDGER_PRIMARY_PARENT_CODE,  @myParentWidth := $rgtParent - $lftParent + 1 FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = $transferGroupParentId ";
		$sql8 = "UPDATE trust_financial_group_ledger_heads SET $rgtParent = $rgtParent + @myWidth WHERE $rgtParent > @myParentLeft";
		$sql9 = "UPDATE trust_financial_group_ledger_heads SET $lftParent = $lftParent + @myWidth WHERE $lftParent > @myParentLeft";
		if($parentLevel == 'PG') {
			$sql10 = "UPDATE  trust_financial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, T_FGLH_PARENT_ID=@pId ,T_TYPE_ID=@type_id,T_LEDGER_PRIMARY_PARENT_CODE = @acronym ,T_PRIMARY_PARENT_CODE = '',T_LEVELS='SG' WHERE T_FGLH_ID= $transferGroupId";
		} else if($parentLevel == 'MG') {
			$sql10 = "UPDATE  trust_financial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, T_FGLH_PARENT_ID=@pId ,T_TYPE_ID=@type_id,T_PRIMARY_PARENT_CODE = $transferGroupId,T_LEDGER_PRIMARY_PARENT_CODE = '',T_LEVELS='PG' WHERE T_FGLH_ID= $transferGroupId";
		} else {
			$sql10 = "UPDATE  trust_financial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, T_FGLH_PARENT_ID=@pId ,T_TYPE_ID=@type_id,T_LEDGER_PRIMARY_PARENT_CODE = @subAcronym,T_PRIMARY_PARENT_CODE = '',T_LEVELS='SG' WHERE T_FGLH_ID= $transferGroupId";
		}
		$query1 = $this->db->query($sql1);
		$sql11 = "SELECT T_FGLH_ID,T_FGLH_PARENT_ID,T_LEVELS FROM trust_financial_group_ledger_heads WHERE $lft > @myLeft AND $lft < @myRight";
		$query11 = $this->db->query($sql11);
		$res = $query11->result();
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);	
		$query7 = $this->db->query($sql7);
		$query8 = $this->db->query($sql8);
		$query9 = $this->db->query($sql9);
		$query10 = $this->db->query($sql10);	
		foreach ($res as $row) {
			$fglhId = $row->T_FGLH_ID;
			$parentId = $row->T_FGLH_PARENT_ID;
			$levels = $row->T_LEVELS;
			$sqlRow1 = "SELECT @myWidth := $rgt - $lft + 1  FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = $fglhId";
			$sqlRow2 = "UPDATE trust_financial_group_ledger_heads SET $lft = 0 ,$rgt = 0 WHERE T_FGLH_ID = $fglhId";
			$sqlRow3 = "SELECT @myParentLeft := $lftParent,@myParentRgt := $rgtParent, @pId :=T_FGLH_ID, @type_id :=T_TYPE_ID,@acronym :=T_PRIMARY_PARENT_CODE,@subAcronym :=T_LEDGER_PRIMARY_PARENT_CODE FROM trust_financial_group_ledger_heads WHERE T_FGLH_ID = $parentId";
			$sqlRow8 = "UPDATE trust_financial_group_ledger_heads SET  $rgtParent =  $rgtParent +  @myWidth WHERE  $rgtParent > @myParentLeft AND 
					$rgtParent < @myParentRgt";
			$sqlRow9 = "UPDATE trust_financial_group_ledger_heads SET  $lftParent =  $lftParent +  @myWidth WHERE  $lftParent > @myParentLeft AND 
					$lftParent < @myParentRgt";
			$parentLevelRow =  $this->obj_finance->getParentLevel($parentId);
			if($parentLevelRow == 'PG') {
				$sqlRow4 = "UPDATE  trust_financial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, T_FGLH_PARENT_ID=@pId ,T_TYPE_ID=@type_id,T_LEDGER_PRIMARY_PARENT_CODE = @acronym ,T_PRIMARY_PARENT_CODE = '',T_LEVELS='SG' WHERE T_FGLH_ID= $fglhId";
			} else if($parentLevelRow == 'MG') {
				$sqlRow4 = "UPDATE  trust_financial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, T_FGLH_PARENT_ID=@pId ,T_TYPE_ID=@type_id,T_PRIMARY_PARENT_CODE = $fglhId,T_LEDGER_PRIMARY_PARENT_CODE = '',T_LEVELS='PG' WHERE T_FGLH_ID= $fglhId";
			} else {
				$sqlRow4 = "UPDATE trust_financial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, T_FGLH_PARENT_ID=@pId ,T_TYPE_ID=@type_id,T_LEDGER_PRIMARY_PARENT_CODE = @subAcronym,T_PRIMARY_PARENT_CODE = '',T_LEVELS='SG' WHERE T_FGLH_ID= $fglhId";
			}
			$queryRow1 = $this->db->query($sqlRow1);
			$queryRow2 = $this->db->query($sqlRow2);
			$queryRow3 = $this->db->query($sqlRow3);
			$queryRow8 = $this->db->query($sqlRow8);
			$queryRow9 = $this->db->query($sqlRow9);
			$queryRow4 = $this->db->query($sqlRow4);
			if($levels == 'LG') {
				$sqlRow5 = "UPDATE trust_financial_group_ledger_heads SET T_LEVELS='LG' WHERE T_FGLH_ID= $fglhId";
				$queryRow5 = $this->db->query($sqlRow5);
				if($checkType != $checkTypeParent) {
					$sqlRow6 ="SELECT @DR:=T_FLT_DR,@CR:=T_FLT_CR FROM `trust_financial_ledger_transcations` WHERE T_FGLH_ID= $fglhId and T_RP_TYPE ='OP'";
					$sqlRow7 ="UPDATE `trust_financial_ledger_transcations` SET T_FLT_DR=@CR,T_FLT_CR=@DR  WHERE T_FGLH_ID= $fglhId and T_RP_TYPE ='OP'";
					$queryRow6 = $this->db->query($sqlRow6);
					$queryRow7 = $this->db->query($sqlRow7);
				}
			}
		}	
	}

	function fd_Exp_Count($startDate,$endDate) {
		$sql ="SELECT T_FGLH_NAME,
		       T_FD_MATURITY_START_DATE,
			   T_FD_MATURITY_END_DATE,
			   T_OP_BAL,
			   T_FLT_DR,
			   T_FLT_CR 
			   from 
			   trust_financial_group_ledger_heads 
			   INNER JOIN 
			   trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID  
			   where STR_TO_DATE(T_FD_MATURITY_END_DATE, '%d-%m-%Y')  
			   BETWEEN STR_TO_DATE('$startDate', '%d-%m-%Y')  
			   AND  STR_TO_DATE('$endDate', '%d-%m-%Y')";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function fd_Exp_Current_Month($startDate,$endDate) {
		$sql ="SELECT trust_financial_group_ledger_heads.T_FGLH_NAME,
		trust_financial_group_ledger_heads.T_FGLH_PARENT_ID,
		trust_financial_group_ledger_heads.T_IS_JOURNAL_STATUS,
		trust_financial_group_ledger_heads.T_IS_TERMINAL,
		trust_financial_group_ledger_heads.T_IS_FD_STATUS,
		trust_financial_group_ledger_heads.T_FD_MATURITY_START_DATE,
		trust_financial_group_ledger_heads.T_FD_MATURITY_END_DATE,
		trust_financial_group_ledger_heads.T_FD_INTEREST_RATE,
		trust_financial_group_ledger_heads.T_FGLH_ID,
		trust_financial_group_ledger_heads.FD_NUMBER,
		trust_financial_group_ledger_heads.FD_BANK_NAME,
		trust_financial_group_ledger_heads.FD_BANK_ID,
		             T_FD_MATURITY_START_DATE,
					 T_FD_MATURITY_END_DATE,
					 T_FD_INTEREST_RATE,
					 T_OP_BAL,T_FLT_DR,T_FLT_CR 
					 from trust_financial_group_ledger_heads 
					 INNER JOIN trust_financial_ledger_transcations 
					 on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID 
					 where T_IS_FD_STATUS =1 
					 AND STR_TO_DATE(T_FD_MATURITY_END_DATE, '%d-%m-%Y')  BETWEEN STR_TO_DATE('$startDate', '%d-%m-%Y')  
					 AND  STR_TO_DATE('$endDate', '%d-%m-%Y')";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function fd_All_Exp($startDate,$endDate,$start, $num) {
		$sql ="SELECT T_FGLH_NAME,T_FD_MATURITY_START_DATE,T_FD_MATURITY_END_DATE,T_FD_INTEREST_RATE,T_OP_BAL,T_FLT_DR,T_FLT_CR from trust_financial_group_ledger_heads  INNER JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID where T_IS_FD_STATUS =1 and STR_TO_DATE(T_FD_MATURITY_END_DATE, '%d-%m-%Y')  < STR_TO_DATE('$startDate', '%d-%m-%Y') LIMIT $start, $num"; 
		$query= $this->db->query($sql);
		return $query->result();
	}

	function fd_All_Exp_Count($startDate,$endDate) {
		$sql ="SELECT T_FGLH_NAME,T_FD_MATURITY_START_DATE,T_FD_MATURITY_END_DATE,T_FD_INTEREST_RATE,T_OP_BAL,T_FLT_DR,T_FLT_CR from trust_financial_group_ledger_heads  INNER JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID where T_IS_FD_STATUS =1 and STR_TO_DATE(T_FD_MATURITY_END_DATE, '%d-%m-%Y')  < STR_TO_DATE('$startDate', '%d-%m-%Y') "; 
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getAllLedgerList() {
		$sql="SELECT * FROM(SELECT CONCAT( REPEAT( '&emsp;&emsp;&emsp;', (COUNT(parent.T_FGLH_NAME) - 1) ), node.T_FGLH_NAME) AS T_FGLH_NAME,node.T_FGLH_ID,node.T_LEVELS,node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID,node.T_TYPE_ID
			FROM trust_financial_group_ledger_heads AS node,
			trust_financial_group_ledger_heads AS parent
			WHERE node.T_LF_A BETWEEN parent.T_LF_A AND parent.T_RG_A AND node.T_TYPE_ID = 'A'
			GROUP BY node.T_FGLH_NAME
			ORDER BY node.T_LF_A) ASSET
			UNION
			SELECT * FROM(SELECT CONCAT( REPEAT( '&emsp;&emsp;&emsp;', (COUNT(parent.T_FGLH_NAME) - 1) ), node.T_FGLH_NAME) AS T_FGLH_NAME,node.T_FGLH_ID,node.T_LEVELS,node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID,node.T_TYPE_ID
			FROM trust_financial_group_ledger_heads AS node,
			trust_financial_group_ledger_heads AS parent
			WHERE node.T_LF_L BETWEEN parent.T_LF_L AND parent.T_RG_L AND node.T_TYPE_ID = 'L'
			GROUP BY node.T_FGLH_NAME
			ORDER BY node.T_LF_L) LIAB
			UNION
			SELECT * FROM(SELECT CONCAT( REPEAT( '&emsp;&emsp;&emsp;', (COUNT(parent.T_FGLH_NAME) - 1) ), node.T_FGLH_NAME) AS T_FGLH_NAME,node.T_FGLH_ID,node.T_LEVELS,node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID,node.T_TYPE_ID
			FROM trust_financial_group_ledger_heads AS node,
			trust_financial_group_ledger_heads AS parent
			WHERE node.T_LF_I BETWEEN parent.T_LF_I AND parent.T_RG_I AND node.T_TYPE_ID = 'I'
			GROUP BY node.T_FGLH_NAME
			ORDER BY node.T_LF_I) INCOME
			UNION
			SELECT * FROM(SELECT CONCAT( REPEAT( '&emsp;&emsp;&emsp;', (COUNT(parent.T_FGLH_NAME) - 1) ), node.T_FGLH_NAME) AS T_FGLH_NAME,node.T_FGLH_ID,node.T_LEVELS,node.T_PRIMARY_PARENT_CODE,node.T_LEDGER_PRIMARY_PARENT_CODE,node.T_FGLH_PARENT_ID,node.T_TYPE_ID
			FROM trust_financial_group_ledger_heads AS node,
			trust_financial_group_ledger_heads AS parent
			WHERE node.T_LF_E BETWEEN parent.T_LF_E AND parent.T_RG_E AND node.T_TYPE_ID = 'E'
			GROUP BY node.T_FGLH_NAME
			ORDER BY node.T_LF_E) EXP";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function get_ledger_transactions($fromDate = "", $toDate = "", $compId,$num=10,$start,$FGLH_ID) {	//TS
 		if($fromDate != "" && $toDate != "") {
			$sql ="SELECT T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE, (CASE WHEN `T_RP_TYPE` LIKE 'R%' THEN 'Receipt' WHEN `T_RP_TYPE` LIKE 'P%' THEN 'Payment' WHEN `T_RP_TYPE` LIKE 'C%' THEN 'Contra' WHEN `T_RP_TYPE` LIKE 'J%' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,T_TRANSACTION_STATUS FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE!='OP' AND trust_financial_ledger_transcations.T_FGLH_ID=$FGLH_ID GROUP BY T_VOUCHER_NO ORDER BY T_FLT_ID DESC,STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') DESC LIMIT $start, $num";
		} else {
			$sql="SELECT T_VOUCHER_NO,trust_financial_group_ledger_heads.T_FGLH_ID,T_FLT_DATE,T_FGLH_NAME,T_FLT_DR,T_FLT_CR,T_RP_TYPE,(CASE WHEN `T_RP_TYPE` LIKE 'R%' THEN 'Receipt' WHEN `T_RP_TYPE` LIKE 'P%' THEN 'Payment' WHEN `T_RP_TYPE` LIKE 'C%' THEN 'Contra' WHEN `T_RP_TYPE` LIKE 'J%' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,T_TRANSACTION_STATUS FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE!='OP' AND trust_financial_ledger_transcations.T_FGLH_ID=$FGLH_ID GROUP BY T_VOUCHER_NO  ORDER BY T_FLT_ID DESC,STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') DESC LIMIT $start, $num";
		}
		$query= $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function count_rows_ledger_transactions($fromDate = "", $toDate = "",$compId,$FGLH_ID) {		//TS
		if($fromDate != "" && $toDate != "") {
			$sql ="SELECT COUNT(*) AS COUNT_TRANSACTON  FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE  trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE!='OP' AND trust_financial_ledger_transcations.T_FGLH_ID=$FGLH_ID GROUP BY T_VOUCHER_NO";
		} else {
			$sql="SELECT COUNT(*) AS COUNT_TRANSACTON FROM trust_financial_group_ledger_heads inner JOIN trust_financial_ledger_transcations on trust_financial_group_ledger_heads.T_FGLH_ID=trust_financial_ledger_transcations.T_FGLH_ID WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' and T_TRANSACTION_STATUS != 'Cancelled' and  STR_TO_DATE(`T_FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%$compId%' AND T_RP_TYPE!='OP' AND trust_financial_ledger_transcations.T_FGLH_ID=$FGLH_ID GROUP BY T_VOUCHER_NO";
		}
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function cancel_finance_transaction($VOUCHER_NO,$FLT_DATE,$chequeno,$voucherType){
		$sql ="UPDATE `trust_financial_ledger_transcations` SET T_TRANSACTION_STATUS = 'Cancelled' WHERE T_VOUCHER_NO = '$VOUCHER_NO' AND T_FLT_DATE = '$FLT_DATE'" ; 
  		$this->db->query($sql);
  		if($chequeno != "" && ($voucherType=="Contra" || $voucherType=="Payment")){
			$sql1 ="SELECT T_FCBD_ID FROM `trust_finance_cheque_detail` WHERE T_VOUCHER_NO = '$VOUCHER_NO' AND T_FLT_DATE='$FLT_DATE' AND T_CHEQUE_NO='$chequeno'";
			$query = $this->db->query($sql1);
			$FCBD_ID_VAL =  $query->row()->T_FCBD_ID;
			$sql2 ="UPDATE `trust_finance_cheque_book_details` SET T_FCBD_STATUS='Active' WHERE T_FCBD_ID = $FCBD_ID_VAL" ; 
	  		$this->db->query($sql2);	
	  		$sqlCheque ="UPDATE `trust_finance_cheque_detail` SET T_FLT_DATE='',T_VOUCHER_NO='',T_CHEQUE_DATE='',T_FAVOURING_NAME='',T_FCD_STATUS='Available' WHERE T_VOUCHER_NO = '$VOUCHER_NO' AND T_FLT_DATE = '$FLT_DATE' AND T_CHEQUE_NO='$chequeno'" ; 
	  		$this->db->query($sqlCheque);
  		}
	}

	// ADDED BY ADITHYA START
	function getBankDetails(){
		$sql = "SELECT T_FGLH_ID,T_FGLH_NAME 
		        FROM trust_financial_group_ledger_heads WHERE T_FGLH_PARENT_ID = 9";
		$query = $this->db->query($sql);
		return $query->result();
	}
	// ADDED BY ADITHYA END

	// ADDED BY ADITHYA START
	function addFDDetails($fglh_id,$bank,$fd_bank_name,$fd_number,$fd_bank_id,$fd_interest_date,$fd_interest,$updatedById,$updatedByDate,$UpdatedDateTime){
	
		$this->db->query("INSERT INTO `trust_fd_details`(`FGLH_ID`, `FD_NUMBER`, `FD_BANK_ID`,`FD_INT_DATE`, `FD_INTEREST`, `UPDATEDBYID`, `UPDATEDBYDATETIME`, `UPDATEDBYDATE`) VALUES ('$fglh_id','$fd_number','$fd_bank_id','$fd_interest_date','$fd_interest','$updatedById','$UpdatedDateTime','$updatedByDate')");
	}

function getFDDetails($fglh_id){
	$sql ="SELECT trust_financial_group_ledger_heads.T_FGLH_NAME,
					  trust_fd_details.FD_NUMBER,
					  trust_fd_details.FD_INTEREST,
					  trust_financial_ledger_transcations.T_FLT_DR,
					  trust_financial_ledger_transcations.T_FLT_CR,
					  trust_fd_details.FD_INT_DATE 
		FROM trust_fd_details 
		INNER JOIN trust_financial_group_ledger_heads ON trust_financial_group_ledger_heads.T_FGLH_ID = trust_fd_details.FGLH_ID  
		INNER JOIN trust_financial_ledger_transcations on trust_financial_ledger_transcations.T_FGLH_ID = trust_fd_details.FGLH_ID 
		WHERE trust_fd_details.FGLH_ID =$fglh_id";
		// echo "$sql";
		$query= $this->db->query($sql);
		return $query->result();
}

function getJournalEntryForR_P($fromRP = '',$toRP = '',$compId = ''){
  $sql= "SELECT 
		ledger.T_FLT_ID,
		HEADS.T_TYPE_ID,
		HEADS.T_FGLH_NAME,
		HEADS.T_FGLH_PARENT_ID,
		ledger.T_FGLH_ID,
		ledger.T_VOUCHER_NO,
		 ledger.T_FLT_DR AS PBalanceDR,
		ledger.T_FLT_CR AS PBalanceCR,
		ledger.T_FLT_DATE 
	FROM 
		trust_financial_ledger_transcations ledger
	JOIN 
	trust_financial_group_ledger_heads HEADS ON ledger.T_FGLH_ID = HEADS.T_FGLH_ID
	WHERE 
		HEADS.T_FGLH_PARENT_ID != 8
		AND HEADS.T_FGLH_PARENT_ID != 9 
		AND (
			ledger.T_RP_TYPE = 'J1' OR ledger.T_RP_TYPE = 'J2'
		)
		AND (
			STR_TO_DATE(ledger.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')
		)";
	
      $query = $this->db->query($sql);
	  if ($query->num_rows() > 0) {
		  return $query->result();
		//echo $sql;
	  } else {
		  return array();
	  }
	}

	// code for getting ledger Details start by adithya
function getLedgerDetails($fromRP_OP,$toRP_OP,$fromDate,$toDate,$fglh_id,$newCondition){
	$sqlOpeningBalance  = "";
	$result2 = array();
	if($fromRP_OP != "" && $toRP_OP != ""){
		$sqlOpeningBalance = "SELECT 'OP' AS T_RP_TYPE, 
		'Opening Balance' AS VOUCHER_TYPE, 
		0 AS FLT_ID, 0 AS VOUCHER_NO, 
		T_FGLH_NAME, 0 AS T_TYPE_ID,
		SUM(T_FLT_DR) as T_FLT_DR, SUM(T_FLT_CR) AS T_FLT_CR ,
		
		CASE WHEN SUM(T_FLT_DR) > SUM(T_FLT_CR)
			 THEN SUM(T_FLT_DR - T_FLT_CR)
			 WHEN SUM(T_FLT_CR) > SUM(T_FLT_DR)
			 THEN SUM(T_FLT_CR - T_FLT_DR)
			 ELSE 0
		END AS TOTAL
		FROM trust_financial_group_ledger_heads INNER JOIN trust_financial_ledger_transcations 
		ON trust_financial_group_ledger_heads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID 
		WHERE trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
		AND T_TRANSACTION_STATUS != 'Cancelled' AND trust_financial_group_ledger_heads.T_FGLH_ID =$fglh_id 
		AND STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') 
		BETWEEN STR_TO_DATE('$fromRP_OP', '%d-%m-%Y') AND STR_TO_DATE('$toRP_OP', '%d-%m-%Y') 
		AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%%'";
	
	
	$query2 = $this->db->query($sqlOpeningBalance);
	$result2 = $query2->result();
	}
	/////////////////////////////////////////////////////////
		$sql = "SELECT 
		TBL1.*, 
		TBL2.Particular,
		TBL2.T_TYPE_ID
	FROM (
		SELECT 
			T_FLT_ID,
			T_VOUCHER_NO,
			trust_financial_group_ledger_heads.T_FGLH_ID,
			T_FLT_DATE,
			T_FGLH_NAME,
			T_FLT_DR,
			T_FLT_CR,
			T_RP_TYPE,
			(
				CASE 
					WHEN `T_RP_TYPE` IN ('R1', 'R2') THEN 'Receipt' 
					WHEN `T_RP_TYPE` IN ('P1', 'P2') THEN 'Payment' 
					WHEN `T_RP_TYPE` IN ('C1', 'C2') THEN 'Contra' 
					WHEN `T_RP_TYPE` IN ('J1', 'J2') THEN 'Journal' 
					WHEN `T_RP_TYPE` = 'OP' THEN 'Opening Balance' 
					ELSE 'Unknown' 
				END
			) AS T_VOUCHER_TYPE 
		FROM 
			trust_financial_group_ledger_heads 
			INNER JOIN trust_financial_ledger_transcations 
			ON trust_financial_group_ledger_heads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID 
		WHERE 
			trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled'
			AND T_TRANSACTION_STATUS != 'Cancelled' 
			AND trust_financial_group_ledger_heads.T_FGLH_ID = $fglh_id
			AND STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') AND STR_TO_DATE('$toDate', '%d-%m-%Y') 
			AND trust_financial_ledger_transcations.T_COMP_ID LIKE '%%' 
			$newCondition
		ORDER BY 
			STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y')
	) AS TBL1
	INNER JOIN (
		SELECT 
			T_FLT_ID,
			IF(T_RP_TYPE != 'OP', T_FGLH_NAME, '') AS Particular,
			T_VOUCHER_NO,
			T_TYPE_ID 
		FROM 
			trust_financial_group_ledger_heads 
			INNER JOIN trust_financial_ledger_transcations 
			ON trust_financial_group_ledger_heads.T_FGLH_ID = trust_financial_ledger_transcations.T_FGLH_ID
	) AS TBL2 ON TBL1.T_VOUCHER_NO = TBL2.T_VOUCHER_NO AND TBL1.T_FLT_ID != TBL2.T_FLT_ID
	GROUP BY 
		TBL1.T_VOUCHER_NO, TBL1.T_FLT_ID 
	ORDER BY 
		STR_TO_DATE(TBL1.T_FLT_DATE, '%d-%m-%Y')";
		
		$query = $this->db->query($sql);
		$result1 = $query->result();
		$mergedResult = array_merge($result1, $result2);
		return $mergedResult;
	
	}

	function checkAndInsertToFinancial_Ledger($fromDate,$toDate,$Revision){
        $YEAR = explode('-',$toDate)[2];
		$OpYear = "01-04-".$YEAR;
		$currentDate = date("d-m");
		$dateTime = date('d-m-Y');
 //  QUERY TO COUNT THE NUMBER OF RECORDS IN PREVIOUS YEAR START
		$sql="SELECT T_FLT_ID,T_FGLH_NAME,
		trust_financial_ledger_transcations.T_FGLH_ID,
		trust_financial_ledger_transcations.T_COMP_ID,
		trust_financial_ledger_transcations.T_VOUCHER_NO,
		trust_financial_ledger_transcations.T_FLT_DATE,
		trust_financial_ledger_transcations.T_RP_TYPE,
		trust_financial_group_ledger_heads.T_TYPE_ID,
		SUM(
        CASE 
            WHEN T_TYPE_ID = 'A' THEN T_FLT_DR - T_FLT_CR
            WHEN T_TYPE_ID = 'L' THEN T_FLT_CR - T_FLT_DR
            ELSE 0
        END
    ) AS AMOUNT
		FROM `trust_financial_ledger_transcations` 
		INNER JOIN trust_financial_group_ledger_heads 
		ON trust_financial_ledger_transcations.T_FGLH_ID=trust_financial_group_ledger_heads.T_FGLH_ID 
		WHERE 
		 trust_financial_ledger_transcations.T_PAYMENT_STATUS != 'Cancelled' 
		and 
		T_TRANSACTION_STATUS != 'Cancelled' 
		and  
		(STR_TO_DATE(trust_financial_ledger_transcations.T_FLT_DATE, '%d-%m-%Y') 
		BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') 
		AND STR_TO_DATE('$toDate', '%d-%m-%Y')) 
		AND trust_financial_group_ledger_heads.T_LEVELS = 'LG'
		AND  (trust_financial_group_ledger_heads.T_TYPE_ID = 'A' OR trust_financial_group_ledger_heads.T_TYPE_ID = 'L')  
		AND trust_financial_ledger_transcations.T_COMP_ID 
		LIKE '%%' GROUP BY trust_financial_group_ledger_heads.T_FGLH_NAME";
	   $query = $this->db->query($sql);
	   $result = $query->result();
	   $op = "OP";

	//    TO CHECK WHETHER RECORD HAS BEEN INSERTED ALREADY
	$RecordCheck = "SELECT * FROM trust_financial_ledger_transcations WHERE T_RP_TYPE = 'OP' AND T_FLT_DATE = '$OpYear' ";
	$num = $this->db->query($RecordCheck);
	
		if($Revision == "True"){
		 try {
			     foreach ($result as $value) {
			     	if($value->T_TYPE_ID == 'A'){
					$updateSql = "UPDATE trust_financial_ledger_transcations 
                                  SET T_FGLH_ID = {$value->T_FGLH_ID},
                                      T_FLT_DR = {$value->AMOUNT}, 
                                      T_FLT_CR = 0,
                                      T_COMP_ID = {$value->T_COMP_ID}
                                  WHERE T_RP_TYPE = '{$op}'
                                  AND T_FGLH_ID = {$value->T_FGLH_ID}
                                  AND T_FLT_DATE = '{$OpYear}'";
		            $query = $this->db->query($updateSql); 
				}
				else {
					$updateSql = "UPDATE trust_financial_ledger_transcations 
                                  SET T_FGLH_ID = {$value->T_FGLH_ID},
                                      T_FLT_DR = 0, 
                                      T_FLT_CR = {$value->AMOUNT},
                                      T_COMP_ID = {$value->T_COMP_ID}
                                WHERE T_RP_TYPE = '{$op}'
                                AND T_FGLH_ID = {$value->T_FGLH_ID}
                                AND T_FLT_DATE = '{$OpYear}'";
                    $query = $this->db->query($updateSql);  
				}
            
			 }
		 } catch (\Throwable $th) {
				throw $th;
			}
		}
		else {
			try {
				// return $num->count ;
			 foreach ($result as $value) {
				
				if($num->num_rows() == 0){
					if( $currentDate == "01-04"){
						
						if($value->T_TYPE_ID =='A'){
							$sql1 =  "INSERT INTO trust_financial_ledger_transcations (T_FGLH_ID,T_FLT_DR,T_FLT_CR ,T_FLT_DATE,T_FLT_DATE_TIME,T_RP_TYPE,T_COMP_ID) 
														 VALUES ($value->T_FGLH_ID,$value->AMOUNT,0,'$dateTime','$dateTime','OP',$value->T_COMP_ID)";						
							$res =  $this->db->query($sql1);	
						}else{
							$sql1 =  "INSERT INTO trust_financial_ledger_transcations (T_FGLH_ID,T_FLT_DR,T_FLT_CR ,T_FLT_DATE,T_FLT_DATE_TIME,T_RP_TYPE,T_COMP_ID) 
													 VALUES ($value->T_FGLH_ID,0,$value->AMOUNT,'$dateTime','$dateTime','OP',$value->T_COMP_ID)";						
						$res =  $this->db->query($sql1);	
						}
						
					  }
				}

			 
			}
		} catch (\Throwable $th) {
				throw $th;
			}
		} 
	}








	//CODE FOR FINANCIAL YEAR FETCHING
public function getFinYearBasedOnDate($dateString) {		
	$date = new DateTime($dateString);
	$currentMonth = (int)$date->format('m');
	$currentYear = (int)$date->format('Y');

	// Financial year typically starts from April
	if ($currentMonth >= 4) {
		// If current month is April or later, financial year is from April of current year to March of next year
		$startYear = $currentYear;
		$endYear = $currentYear + 1;
	} else {
		// If current month is earlier than April, financial year is from April of previous year to March of current year
		$startYear = $currentYear - 1;
		$endYear = $currentYear;
	}

	$financialYear = $startYear . '-' . $endYear;
	return $financialYear;
}

}