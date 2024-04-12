<?php
class finance_Model extends CI_Model 
{
	var $table_finance_voucher_counter = 'finance_voucher_counter';
	var $table_finance_prerequisites='finance_prerequisites';

	function getLedger($condition ="",$compId="",$startDate,$endDate) {	//TS
		$sql ="SELECT TBL1.FGLH_ID,TBL1.FGLH_NAME,TBL2.BALANCE,TBL1.TYPE_ID
		FROM (SELECT  `FGLH_NAME`, `finacial_group_ledger_heads`.`FGLH_ID`, `TYPE_ID` 
      	FROM finacial_group_ledger_heads WHERE `LEVELS` = 'LG'  
		and `finacial_group_ledger_heads`.`COMP_ID` LIKE '%$compId%' $condition
	      GROUP BY finacial_group_ledger_heads.FGLH_ID) as tbl1 
	      left join 
		(SELECT  `financial_ledger_transcations`.`FGLH_ID`, 
		  IF(TYPE_ID='A' OR 
		     TYPE_ID='E', 
			 SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)
		    ) AS BALANCE 
		 FROM financial_ledger_transcations 
		 JOIN finacial_group_ledger_heads 
		 ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID 
		 WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		 and TRANSACTION_STATUS != 'Cancelled'
		 and STR_TO_DATE(`financial_ledger_transcations`.`FLT_DATE`,'%d-%m-%Y') 
	    BETWEEN  STR_TO_DATE('$startDate','%d-%m-%Y') AND STR_TO_DATE('$endDate','%d-%m-%Y')
		 and `financial_ledger_transcations`.`COMP_ID` LIKE '%$compId%'  
		 GROUP BY financial_ledger_transcations.FGLH_ID) as tbl2 on tbl1.FGLH_ID = tbl2.FGLH_ID ORDER BY FGLH_NAME";
		 //AND FGLH_PARENT_ID!=8 AND FGLH_PARENT_ID!=9 -- LNO-10
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getToAccount(){
		$sql="SELECT * from bank_ledger_allocation";
		$query = $this->db->query($sql);	
		return $query->result();
	}
                      
	function getAllLedger($condition) {
		$this->db->select()->from('finacial_group_ledger_heads');
		$this->db->where($condition);
		$query = $this->db->get();
		return $query->result();
	}

	function getBankLedgerDetails($condition) {
		$this->db->select()->from('bank_ledger_allocation');
		$this->db->where($condition);
		$query = $this->db->get();
		return $query->row()->BANK_FGLH_ID;
	}
	
	// function getAllLedgerAndGroups($num = 13, $start = 0,$condition,$condsrch = "") {
		// 	$this->db->select()->from('finacial_group_ledger_heads');
		// 	$this->db->where($condition);
		// 	if ($condsrch) {
		// 		$this->db->where($condsrch);
		// 	}
		// 	$this->db->limit($num, $start);
		// 	$query = $this->db->get();
		// 	return $query->result();
	// }

	// function getAllLedgerAndGroups($num = 13, $start = 0,$condition,$condsrch = "") {
		// 	$sql="SELECT TBL1.FGLH_ID,TBL1.FGLH_NAME,TBL2.BALANCE,TBL1.FGLH_PARENT_ID,TBL1.LEVELS,TBL1.IS_JOURNAL_STATUS,TBL1.IS_TERMINAL,TBL1.COMP_ID
		// 	FROM (SELECT  `FGLH_NAME`, `finacial_group_ledger_heads`.`FGLH_ID`,FGLH_PARENT_ID,LEVELS,IS_JOURNAL_STATUS,IS_TERMINAL,COMP_ID
	 	//      	FROM finacial_group_ledger_heads WHERE $condition $condsrch
		//       GROUP BY finacial_group_ledger_heads.FGLH_ID) as tbl1 
		//       left join 
		// 	(SELECT  `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS BALANCE 
		// 	 FROM financial_ledger_transcations 
		// 	 JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID 
		// 	 GROUP BY financial_ledger_transcations.FGLH_ID) as tbl2 on tbl1.FGLH_ID = tbl2.FGLH_ID LIMIT $start, $num";
		// 	$query = $this->db->query($sql);
		// 	return $query->result();
	// }

	// function getAllLedgerAndGroups_count($num = 13, $start = 0,$condition,$condsrch = "") {
		// 	$sql="SELECT TBL1.FGLH_ID,TBL1.FGLH_NAME,TBL2.BALANCE,TBL1.FGLH_PARENT_ID,TBL1.LEVELS,TBL1.IS_JOURNAL_STATUS,TBL1.IS_TERMINAL
		// 	FROM (SELECT  `FGLH_NAME`, `finacial_group_ledger_heads`.`FGLH_ID`,FGLH_PARENT_ID,LEVELS,IS_JOURNAL_STATUS,IS_TERMINAL
	 	//      	FROM finacial_group_ledger_heads WHERE $condition $condsrch
		//       GROUP BY finacial_group_ledger_heads.FGLH_ID) as tbl1 
		//       left join 
		// 	(SELECT  `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS BALANCE 
		// 	 FROM financial_ledger_transcations 
		// 	 JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID 
		// 	 GROUP BY financial_ledger_transcations.FGLH_ID) as tbl2 on tbl1.FGLH_ID = tbl2.FGLH_ID ";
		// 	$query = $this->db->query($sql);
		// 	return $query->num_rows();
	// }

	function getAllLedgerAndGroups($num = 13, $start = 0,$condition,$condsrch = "") {	//TS
		$sql="SELECT TBL1.FGLH_ID,TBL1.FGLH_NAME,TBL2.BALANCE,TBL1.FGLH_PARENT_ID,TBL1.LEVELS,TBL1.IS_JOURNAL_STATUS,TBL1.IS_TERMINAL,TBL1.COMP_ID,TBL3.CURRENT_BALANCE,TBL4.OPBALANCE,TBL1.IS_FD_STATUS,TBL1.FD_MATURITY_START_DATE,TBL1.FD_MATURITY_END_DATE,TBL1.FD_INTEREST_RATE
		FROM (SELECT  `FGLH_NAME`, `finacial_group_ledger_heads`.`FGLH_ID`,FGLH_PARENT_ID,LEVELS,IS_JOURNAL_STATUS,IS_TERMINAL,IS_FD_STATUS,FD_MATURITY_START_DATE,FD_MATURITY_END_DATE,FD_INTEREST_RATE,COMP_ID
      	FROM finacial_group_ledger_heads WHERE $condition $condsrch
	      GROUP BY finacial_group_ledger_heads.FGLH_ID) as tbl1 
	      left join 
		(SELECT  `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS BALANCE 
		 FROM financial_ledger_transcations 
		 JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID WHERE TRANSACTION_STATUS != 'Cancelled'
		 GROUP BY financial_ledger_transcations.FGLH_ID) as tbl2 on tbl1.FGLH_ID = tbl2.FGLH_ID 
		 left join
		 (SELECT  `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS CURRENT_BALANCE 
		 FROM financial_ledger_transcations 
		 JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID WHERE RP_TYPE!= 'OP' AND TRANSACTION_STATUS != 'Cancelled'
		 GROUP BY financial_ledger_transcations.FGLH_ID) as tbl3 on tbl1.FGLH_ID = tbl3.FGLH_ID 
		  left join

		(SELECT `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS OPBALANCE FROM financial_ledger_transcations JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID where RP_TYPE = 'OP' AND TRANSACTION_STATUS != 'Cancelled' GROUP BY financial_ledger_transcations.FGLH_ID) as tbl4 on tbl1.FGLH_ID = tbl4.FGLH_ID 
		 ";
		 
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getAllLedgerAndGroups_count($num = 13, $start = 0,$condition,$condsrch = "") {		//TS
		$sql="SELECT TBL1.FGLH_ID,TBL1.FGLH_NAME,TBL2.BALANCE,TBL1.FGLH_PARENT_ID,TBL1.LEVELS,TBL1.IS_JOURNAL_STATUS,TBL1.IS_TERMINAL,TBL1.COMP_ID,TBL3.CURRENT_BALANCE,TBL4.OPBALANCE
		FROM (SELECT  `FGLH_NAME`, `finacial_group_ledger_heads`.`FGLH_ID`,FGLH_PARENT_ID,LEVELS,IS_JOURNAL_STATUS,IS_TERMINAL,COMP_ID
      	FROM finacial_group_ledger_heads WHERE $condition $condsrch
	      GROUP BY finacial_group_ledger_heads.FGLH_ID) as tbl1 
	      left join 
		(SELECT  `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS BALANCE 
		 FROM financial_ledger_transcations 
		 JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID 
		 GROUP BY financial_ledger_transcations.FGLH_ID) as tbl2 on tbl1.FGLH_ID = tbl2.FGLH_ID 
		 left join
		 (SELECT  `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS CURRENT_BALANCE 
		 FROM financial_ledger_transcations 
		 JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID WHERE RP_TYPE!= 'OP' AND TRANSACTION_STATUS != 'Cancelled'
		 GROUP BY financial_ledger_transcations.FGLH_ID) as tbl3 on tbl1.FGLH_ID = tbl3.FGLH_ID 
		  left join

		(SELECT `financial_ledger_transcations`.`FGLH_ID`, IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS OPBALANCE FROM financial_ledger_transcations JOIN finacial_group_ledger_heads ON financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID where RP_TYPE = 'OP' AND TRANSACTION_STATUS != 'Cancelled' GROUP BY financial_ledger_transcations.FGLH_ID) 
		as tbl4 on tbl1.FGLH_ID = tbl4.FGLH_ID";
		
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getAssignedBankLedger($LEDGER_FGLH_ID){	//TS
		$sql="SELECT BLA_ID,BANK_FGLH_ID,LEDGER_FGLH_ID,FGLH_NAME as AssignedLedgerName,IF(SUM(FLT_DR)-SUM(FLT_CR)IS NULL,0,SUM(FLT_DR)-SUM(FLT_CR)) AS AMT  FROM `bank_ledger_allocation` JOIN finacial_group_ledger_heads ON bank_ledger_allocation.LEDGER_FGLH_ID = finacial_group_ledger_heads.FGLH_ID LEFT JOIN financial_ledger_transcations ON bank_ledger_allocation.BANK_FGLH_ID = financial_ledger_transcations.PC_PAY_GROUP WHERE BANK_FGLH_ID =$LEDGER_FGLH_ID and financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' GROUP BY LEDGER_FGLH_ID ";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getAccount($condition ="",$compId,$startDate,$endDate) {	//TS
		$sql = "SELECT TBL1.FGLH_ID,TBL1.FGLH_NAME,TBL2.BALANCE,TBL2.COMP_ID, 
		        TBL1.TYPE_ID, TBL1.FGLH_PARENT_ID,TBL1.BANK_NAME,TBL1.BANK_BRANCH 
		FROM 
		(SELECT `FGLH_NAME`, `finacial_group_ledger_heads`.`FGLH_ID`, `TYPE_ID`, `FGLH_PARENT_ID`, `finacial_group_ledger_heads`.`BANK_NAME`, `finacial_group_ledger_heads`.`BANK_BRANCH` 
		FROM finacial_group_ledger_heads 
		WHERE `finacial_group_ledger_heads`.`COMP_ID` LIKE '%$compId%' 
		AND `LEVELS` = 'LG' 
		 AND (`FGLH_PARENT_ID` = 8 OR `FGLH_PARENT_ID` = 9) $condition 
		 GROUP BY finacial_group_ledger_heads.FGLH_ID) as tbl1 
		 left join (SELECT financial_ledger_transcations.FGLH_ID, SUM(FLT_DR-FLT_CR) AS BALANCE,
		 financial_ledger_transcations.COMP_ID 
		 FROM financial_ledger_transcations 
		 WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		 and TRANSACTION_STATUS != 'Cancelled' 
		 and STR_TO_DATE(`financial_ledger_transcations`.`FLT_DATE`,'%d-%m-%Y') 
	    BETWEEN  STR_TO_DATE('$startDate','%d-%m-%Y') AND STR_TO_DATE('$endDate','%d-%m-%Y')
		  and  `financial_ledger_transcations`.`COMP_ID` LIKE '%$compId%' 
		  GROUP BY financial_ledger_transcations.FGLH_ID) as tbl2 
		  on tbl1.FGLH_ID = tbl2.FGLH_ID";
		//   echo "$sql";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function getGroups($condition="") {
		$this->db->select()->from('finacial_group_ledger_heads');
		if ($condition) {
			$this->db->where($condition);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function getBookStatus($FGLH_ID) {
		$this->db->select()->from('finance_cheque_book_details');
		$this->db->where('FGLH_ID',$FGLH_ID);
		$this->db->where('FCBD_STATUS',"Active");
		$query = $this->db->get();
		return $query->num_rows();
	}

	function putChequeDetails($chkbookno,$fromno,$tono,$numberofchk,$chkname,$FGLH_ID,$status) {

		$this->db->query("INSERT INTO `finance_cheque_book_details`(`FGLH_ID`,`CHEQUE_BOOK_NO`,`CHEQUE_BOOK_NAME`, `FROM_NO`, `TO_NO`,`NO_OF_CHEQUE`,`FCBD_STATUS`) VALUES ('$FGLH_ID','$chkbookno','$chkname','$fromno','$tono','$numberofchk','$status')");
	}

	function putOpeningBal($dateTime,$todayDate,$last_id,$opAmt,$naration='',$compId,$userId) {	
		$this->db->select("TYPE_ID")->from('finacial_group_ledger_heads');
		$where = "FGLH_ID = '$last_id'";
		$this->db->where($where);
		$query = $this->db->get()->row()->TYPE_ID;

		$sql ="UPDATE `finacial_group_ledger_heads` SET OP_BAL = 1 WHERE FGLH_ID = $last_id" ; 
		$this->db->query($sql);


		if ($query == 'A' || $query == 'E') {
			
			$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`Flt_Dr`, `Flt_cr`,`RP_TYPE`,`FLT_DATE`,`FLT_DATE_TIME`,`FLT_NARRATION`,`COMP_ID`,`FLT_USER_ID`) VALUES ($last_id,$opAmt,0,'OP','$todayDate','$dateTime','$naration','$compId','$userId')");
		}
		else {
			
			$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`Flt_Dr`, `Flt_cr`, `RP_TYPE`,`FLT_DATE`,`FLT_DATE_TIME`,`FLT_NARRATION`,`COMP_ID`,`FLT_USER_ID`) VALUES ($last_id,0,$opAmt,'OP','$todayDate','$dateTime','$naration','$compId','$userId')");
		}
		return $this->db->insert_id();
	}

	function putReceipt($aidR,$lidR,$countNoR,$amtsR,$todayDate,$dateTime,$naration,$userId,$chequeDate,$receiptmethod,$chkno,$bankName,$branchName,$receivedfrom,$status,$compId) {
		$DrAmt = 0;$CrAmt = $amtsR;
		$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`CHEQUE_DATE`,`PAYMENT_METHOD`,`CHEQUE_NO`,`BANK_NAME`,`BRANCH_NAME`,`RECEIPT_FAVOURING_NAME`,`FLT_DEPOSIT_PAYMENT_DATE`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($lidR,'$countNoR',$DrAmt,$CrAmt,
			'$todayDate','$dateTime','$naration','R1',$userId,'$chequeDate','$receiptmethod','$chkno','$bankName','$branchName','$receivedfrom','$todayDate','$status','$compId')");
		$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`CHEQUE_DATE`,`PAYMENT_METHOD`,`CHEQUE_NO`,`BANK_NAME`,`BRANCH_NAME`,`RECEIPT_FAVOURING_NAME`,`FLT_DEPOSIT_PAYMENT_DATE`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($aidR,'$countNoR',$amtsR,0,
			'$todayDate','$dateTime','$naration','R2',$userId,'$chequeDate','$receiptmethod','$chkno','$bankName','$branchName','$receivedfrom','$todayDate','$status','$compId')");
	}

	function putPayment($aidP,$lidP,$countNoP,$amtsP,$todayDate,$dateTime,$naration,$userId,$chequeDate,$paymentmethod,$chkno,$bankName,$branchName,$favouring,$status,$selectedId,$compId) {
		$this->db->select("TYPE_ID")->from('finacial_group_ledger_heads')->where("FGLH_ID = '$lidP'");
		$TYPE_ID = $this->db->get()->row()->TYPE_ID;
		$DrAmt = $amtsP;$CrAmt = 0;
		$this->db->query("INSERT INTO financial_ledger_transcations(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`CHEQUE_DATE`,`PAYMENT_METHOD`,`CHEQUE_NO`,`BANK_NAME`,`BRANCH_NAME`,`RECEIPT_FAVOURING_NAME`,`FLT_DEPOSIT_PAYMENT_DATE`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($lidP,'$countNoP',$DrAmt,$CrAmt,
			'$todayDate','$dateTime','$naration','P1',$userId,'$chequeDate','$paymentmethod','$chkno','$bankName','$branchName','$favouring','$todayDate','$status','$compId')");
		$this->db->query("INSERT INTO financial_ledger_transcations(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`CHEQUE_DATE`,`PAYMENT_METHOD`,`CHEQUE_NO`,`BANK_NAME`,`BRANCH_NAME`,`RECEIPT_FAVOURING_NAME`,`FLT_DEPOSIT_PAYMENT_DATE`,`PAYMENT_STATUS`,`PC_PAY_GROUP`,`COMP_ID`) VALUES ($aidP,'$countNoP',0,$amtsP,
			'$todayDate','$dateTime','$naration','P2',$userId,'$chequeDate','$paymentmethod','$chkno','$bankName','$branchName','$favouring','$todayDate','$status','$selectedId','$compId')");
		return $this->db->insert_id();
	}

	function putContra($aidC,$acidC,$countNoC,$amtsC,$todayDate,$dateTime,$naration,$userId,$chequeDate,$paymentmethod,$chkno,$bankName,$branchName,$favouring,$status,$pcPay,$compId) {
		$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`CHEQUE_DATE`,`PAYMENT_METHOD`,`CHEQUE_NO`,`BANK_NAME`,`BRANCH_NAME`,`RECEIPT_FAVOURING_NAME`,`FLT_DEPOSIT_PAYMENT_DATE`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($aidC,'$countNoC',0,$amtsC,
			'$todayDate','$dateTime','$naration','C1',$userId,'$chequeDate','$paymentmethod','$chkno','$bankName','$branchName','$favouring','$todayDate','$status','$compId')");
		$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`CHEQUE_DATE`,`PAYMENT_METHOD`,`CHEQUE_NO`,`BANK_NAME`,`BRANCH_NAME`,`RECEIPT_FAVOURING_NAME`,`PC_PAY_GROUP`,`FLT_DEPOSIT_PAYMENT_DATE`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($acidC,'$countNoC',$amtsC,0,
			'$todayDate','$dateTime','$naration','C2',$userId,'$chequeDate','$paymentmethod','$chkno','$bankName','$branchName','$favouring','$pcPay','$todayDate','$status','$compId')");
		return $this->db->insert_id();
	}

	function putJournal($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$userId,$rptype,$compId) {
		$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`FLT_USER_ID`,`RP_TYPE`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($lidJ,'$countNoJ',$firstAmt,$secondAmt,'$tDateJ','$dateTime','$naration',$userId,'$rptype','Completed','$compId')");
		return $this->db->insert_id();
	}

	function putJournalTransfer($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$user,$rptype,$SHASHWATH_RECEIPT,$compId) {
		$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`,`Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`FLT_USER_ID`,`RP_TYPE`,`PAYMENT_STATUS`,RECEIPT_ID,`COMP_ID`
		) VALUES ($lidJ,'$countNoJ',$firstAmt,$secondAmt,'$tDateJ','$dateTime','$naration',$user,'$rptype','Completed',$SHASHWATH_RECEIPT,$compId)");
		return $this->db->insert_id();
	}

	function getAssets($fromRP_OP,$fromDate,$toDate,$compId,$newCondition) {		//TS
		$sql="SELECT tbl1.FGLH_NAME, tbl1.AMT,tbl2.AMT 
		as PBalance ,
		tbl1.LEVELS,tbl1.FGLH_ID,tbl1.FGLH_PARENT_ID,tbl1.FLT_DATE,tbl1.LEDGER_PRIMARY_PARENT_CODE,tbl1.COMP_ID 
		FROM 
		(SELECT GLHeads.FGLH_ID, CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.FGLH_NAME) 
		AS FGLH_NAME, 
		SUM(FLT_DR-FLT_CR) AS AMT,
		GLHeads.LEVELS,GLHeads.PRIMARY_PARENT_CODE,GLHeads.LEDGER_PRIMARY_PARENT_CODE,GLHeads.FGLH_PARENT_ID,FLT_DATE,COMP_ID 
		FROM (SELECT node.FGLH_ID, node.LF_A,node.LEVELS, node.FGLH_NAME, (COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
		 node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE,node.FGLH_PARENT_ID 
		 FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent
		  WHERE node.LEVELS!='MG' and node.TYPE_ID = 'A' AND node.LF_A BETWEEN parent.LF_A AND parent.RG_A 
		  GROUP BY node.FGLH_NAME 
		  ORDER BY node.LF_A)GLHeads 
		  LEFT JOIN financial_ledger_transcations ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
		  where  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
		  BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') AND STR_TO_DATE('$toDate', '%d-%m-%Y'))  
		  OR (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') = STR_TO_DATE('$fromRP_OP', '%d-%m-%Y') AND  RP_TYPE = 'OP' ) 
		  and COMP_ID LIKE '%$compId%' OR GLHeads.LEVELS ='PG' OR GLHeads.LEVELS ='PSG' OR GLHeads.LEVELS ='SG' 
		  GROUP BY GLHeads.FGLH_NAME ORDER BY GLHeads.LF_A) as tbl1,
			(SELECT SUM(FLT_DR-FLT_CR) AS AMT,
			GLHeads.LEDGER_PRIMARY_PARENT_CODE,GLHeads.LEVELS 
			FROM (SELECT node.FGLH_ID, node.LF_A,node.LEVELS, node.FGLH_NAME, (COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
			 node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE 
			 FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent 
			 WHERE node.LEVELS!='MG' and node.TYPE_ID = 'A' AND node.LF_A 
			 BETWEEN parent.LF_A AND parent.RG_A GROUP BY node.FGLH_NAME 
			 ORDER BY node.LF_A) GLHeads LEFT JOIN financial_ledger_transcations 
			 ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			  where  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
			  and TRANSACTION_STATUS != 'Cancelled' 
			  and (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y' ) 
			  BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') 
			  AND STR_TO_DATE('$toDate', '%d-%m-%Y'))
			  OR (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') = STR_TO_DATE('$fromRP_OP', '%d-%m-%Y') AND  RP_TYPE = 'OP' ) 
			 and
			  COMP_ID LIKE '%$compId%'  
			  OR GLHeads.LEVELS ='PG' OR GLHeads.LEVELS ='PSG' OR GLHeads.LEVELS ='SG' 
			  GROUP BY GLHeads.LEDGER_PRIMARY_PARENT_CODE) as tbl2 
			  WHERE tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE";
     	// echo "$sql";
		$query = $this->db->query($sql);	
		return $query->result();
	}
	
	function getCash($fromDate,$toDate,$compId) {	//TS
		$sql="SELECT finacial_group_ledger_heads.FGLH_ID,FGLH_NAME,
		      IF(TYPE_ID='A' OR TYPE_ID='E', SUM(FLT_DR-FLT_CR), SUM(FLT_CR-FLT_DR)) AS CASH,
			  COMP_NAME,finance_committee.COMP_ID 
			  from financial_ledger_transcations 
			  inner join finacial_group_ledger_heads 
			  on financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID 
			  JOIN finance_committee ON financial_ledger_transcations.COMP_ID = finance_committee.COMP_ID 
			  where  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
			  and TRANSACTION_STATUS != 'Cancelled' 
			  and STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') AND STR_TO_DATE('$toDate', '%d-%m-%Y') 
			  and financial_ledger_transcations.COMP_ID LIKE '%$compId%' GROUP BY financial_ledger_transcations.COMP_ID ,
			  financial_ledger_transcations.FGLH_ID ORDER BY finacial_group_ledger_heads.FGLH_ID";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	// function getNewA_L($fromDate,$toDate,$newCondition){
	// 	$sql = "SELECT FLT_ID,FGLH_NAME,
	// 	 financial_ledger_transcations.FGLH_ID,
	// 	 financial_ledger_transcations.COMP_ID,
	// 	 financial_ledger_transcations.VOUCHER_NO,
	// 	 financial_ledger_transcations.Flt_Dr,
	// 	 financial_ledger_transcations.Flt_cr,
	// 	 financial_ledger_transcations.Flt_Date,
	// 	 financial_ledger_transcations.RP_TYPE
	// 	 ,SUM(FLT_DR-FLT_CR) AS AMOUNT ,financial_ledger_transcations.FLT_DR,financial_ledger_transcations.FLT_CR
    //      FROM `financial_ledger_transcations` 
    //      INNER JOIN finacial_group_ledger_heads 
    //      ON financial_ledger_transcations.FGLH_ID=finacial_group_ledger_heads.FGLH_ID 
    //      WHERE 
    //       financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
    //      and 
    //      TRANSACTION_STATUS != 'Cancelled' 
    //      and  
    //      (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
    //      BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') 
    //      AND STR_TO_DATE('$toDate', '%d-%m-%Y')) 
		 
	// 	 and finacial_group_ledger_heads.LEVELS = 'LG'
    //      AND (finacial_group_ledger_heads.TYPE_ID = 'A' OR finacial_group_ledger_heads.TYPE_ID = 'L')
	// 	 $newCondition
    //      AND financial_ledger_transcations.COMP_ID 
    //      LIKE '%%' GROUP BY finacial_group_ledger_heads.FGLH_NAME";
	
	// 	$query = $this->db->query($sql);
	// 	return $query->result();
	// }

	function getLiablities($fromRP_OP,$fromDate,$toDate,$compId,$newCondition) {	//TS
		$sql="SELECT tbl1.FGLH_NAME,tbl1.AMT,tbl2.AMT as PBalanceL ,
		             tbl1.LEVELS,tbl1.FGLH_ID,tbl1.FGLH_PARENT_ID,
					 tbl1.LEDGER_PRIMARY_PARENT_CODE  
			FROM (SELECT GLHeads.FGLH_ID, CONCAT(
				REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.FGLH_NAME) AS FGLH_NAME,
				SUM(FLT_CR-FLT_DR) AS AMT,
				GLHeads.LEVELS,
				GLHeads.PRIMARY_PARENT_CODE,
				GLHeads.LEDGER_PRIMARY_PARENT_CODE,
				GLHeads.FGLH_PARENT_ID 
			FROM (SELECT node.FGLH_ID, node.LF_L, node.FGLH_NAME,node.LEVELS, 
			(COUNT(parent.FGLH_NAME) - 1) AS LEVELD, 
			node.PRIMARY_PARENT_CODE, node.LEDGER_PRIMARY_PARENT_CODE,node.FGLH_PARENT_ID 
			FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent 
			WHERE node.LEVELS!='MG' 
			and node.TYPE_ID = 'L'
			 AND node.LF_L 
			 BETWEEN parent.LF_L 
			 AND parent.RG_L 
			 GROUP BY node.FGLH_NAME 
			 ORDER BY node.LF_L)GLHeads 
			 LEFT JOIN 
			 financial_ledger_transcations ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			where  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
			and TRANSACTION_STATUS != 'Cancelled' 
			and ( STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
			BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') 
			AND STR_TO_DATE('$toDate', '%d-%m-%Y'))
			OR ( STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') = STR_TO_DATE('$fromRP_OP', '%d-%m-%Y') AND RP_TYPE = 'OP') 
			and COMP_ID LIKE '%$compId%'  
			OR GLHeads.LEVELS ='PG' 
			OR GLHeads.LEVELS ='PSG' 
			OR GLHeads.LEVELS ='SG' 
			GROUP BY GLHeads.FGLH_NAME 
			ORDER BY GLHeads.LF_L) as tbl1 ,

		(SELECT SUM(FLT_CR-FLT_DR) AS AMT,
		GLHeads.LEDGER_PRIMARY_PARENT_CODE,
		GLHeads.LEVELS 
		FROM (SELECT node.FGLH_ID, node.LF_L,node.LEVELS,node.FGLH_NAME, (COUNT(parent.FGLH_NAME) - 1)AS 
		LEVELD, node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE 
		FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent 
		WHERE node.LEVELS!='MG' 
		and node.TYPE_ID = 'L' 
		AND node.LF_L 
		BETWEEN parent.LF_L 
		AND parent.RG_L 
		GROUP BY node.FGLH_NAME 
		ORDER BY node.LF_L)GLHeads 
		LEFT JOIN financial_ledger_transcations ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID  
		where  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		and TRANSACTION_STATUS != 'Cancelled' 
		and  (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
		BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') 
		AND STR_TO_DATE('$toDate', '%d-%m-%Y'))
		OR ( STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') = STR_TO_DATE('$fromRP_OP', '%d-%m-%Y') AND RP_TYPE = 'OP') 
		and COMP_ID LIKE '%$compId%'  
		OR GLHeads.LEVELS ='PG' 
		OR GLHeads.LEVELS ='PSG' 
		OR GLHeads.LEVELS ='SG'
		GROUP BY GLHeads.LEDGER_PRIMARY_PARENT_CODE) 
		as tbl2 WHERE tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE";
	// echo "$sql";
	$query = $this->db->query($sql);	
		return $query->result();
	}

	function getDifference($fromDate,$toDate,$compId,$groupBy='') {	//TS
		$sql="SELECT sum(FLT_DR-FLT_CR) as Deficit,
		             sum(FLT_CR-FLT_DR) as Surplus,
					 COMP_NAME 
				from financial_ledger_transcations 
				inner join finacial_group_ledger_heads 
				on financial_ledger_transcations.FGLH_ID = finacial_group_ledger_heads.FGLH_ID 
				JOIN finance_committee ON financial_ledger_transcations.COMP_ID = finance_committee.COMP_ID 
				where financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				and TRANSACTION_STATUS != 'Cancelled' 
				and STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
				BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') 
				AND STR_TO_DATE('$toDate', '%d-%m-%Y') 
				and (TYPE_ID ='I' OR TYPE_ID ='E') 
				and financial_ledger_transcations.COMP_ID LIKE '%$compId%' $groupBy ";
	// echo "$sql";
	$query = $this->db->query($sql);
		return $query->result();
	}

	function getReceipt($fromRP,$toRP,$compId) {	//TS
		$sql="SELECT * FROM 
		      ( SELECT tbl1.FGLH_NAME, tbl1.AMT,tbl2.AMT as PBalance ,
			           tbl1.LEVELS,
					   tbl1.FGLH_ID,
					   tbl1.FGLH_PARENT_ID,
					   tbl1.FLT_DATE,
					   tbl1.LEDGER_PRIMARY_PARENT_CODE 
			  FROM 
			  ( SELECT GLHeads.FGLH_ID, 
			           CONCAT(
						   REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.FGLH_NAME) AS FGLH_NAME, 
					   SUM(FLT_CR) AS AMT,
					   GLHeads.LEVELS,
					   GLHeads.PRIMARY_PARENT_CODE,
					   GLHeads.LEDGER_PRIMARY_PARENT_CODE,
					   GLHeads.FGLH_PARENT_ID,
					   FLT_DATE 
			   FROM 
			   ( SELECT node.FGLH_ID, 
			            node.LF_A,
						node.LEVELS, 
						node.FGLH_NAME, 
						(COUNT(
							 parent.FGLH_NAME) - 1) AS LEVELD, 
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE,
						node.FGLH_PARENT_ID 
				FROM `finacial_group_ledger_heads` node,
				     `finacial_group_ledger_heads` parent 
			    WHERE node.LEVELS!='MG' and node.TYPE_ID = 'A' 
				    AND node.LF_A BETWEEN parent.LF_A AND parent.RG_A 
				GROUP BY node.FGLH_NAME 
				ORDER BY node.LF_A)GLHeads 
			LEFT JOIN financial_ledger_transcations ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			     where financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				 and TRANSACTION_STATUS != 'Cancelled' 
				 and  (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
			BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')
			AND financial_ledger_transcations.RP_TYPE = 'R1') and COMP_ID 
			LIKE '%$compId%' 
			  OR GLHeads.LEVELS ='PG' 
			  OR GLHeads.LEVELS ='PSG' 
			  OR GLHeads.LEVELS ='SG' 
			GROUP BY GLHeads.FGLH_NAME 
			ORDER BY GLHeads.LF_A) as tbl1,

			(SELECT 
			   SUM(FLT_CR) AS AMT,
			   GLHeads.LEDGER_PRIMARY_PARENT_CODE,
			   GLHeads.LEVELS FROM 
			   (SELECT node.FGLH_ID, node.LF_A,node.LEVELS, node.FGLH_NAME,
			    (COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
				 node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE 
				 FROM `finacial_group_ledger_heads` node, 
				 `finacial_group_ledger_heads` parent WHERE 
				 node.LEVELS!='MG' 
				 and node.TYPE_ID = 'A' 
				 AND node.LF_A 
				 BETWEEN parent.LF_A 
				 AND parent.RG_A 
				 GROUP BY node.FGLH_NAME 
				 ORDER BY node.LF_A) GLHeads 
				 LEFT JOIN financial_ledger_transcations 
				 ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
				 where financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				 and TRANSACTION_STATUS != 'Cancelled' 
				 and  (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
				 BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') 
				 AND STR_TO_DATE('$toRP', '%d-%m-%Y')
				 AND financial_ledger_transcations.RP_TYPE = 'R1') 
				 and COMP_ID LIKE '%$compId%' OR GLHeads.LEVELS ='PG' 
				 OR GLHeads.LEVELS ='PSG' OR GLHeads.LEVELS ='SG' 
				 GROUP BY GLHeads.LEDGER_PRIMARY_PARENT_CODE) as tbl2 
				 WHERE tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE) as a

			UNION 

			SELECT * FROM ( 
				SELECT tbl1.FGLH_NAME,tbl1.AMT,tbl2.AMT as PBalanceL ,
				       tbl1.LEVELS,
					   tbl1.FGLH_ID,
					   tbl1.FGLH_PARENT_ID,
					   tbl1.FLT_DATE,tbl1.LEDGER_PRIMARY_PARENT_CODE FROM 
					   (SELECT GLHeads.FGLH_ID, CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.FGLH_NAME) AS FGLH_NAME,
					   SUM(FLT_CR) AS AMT,
					   GLHeads.LEVELS,
					   GLHeads.PRIMARY_PARENT_CODE,
					   GLHeads.LEDGER_PRIMARY_PARENT_CODE,
					   GLHeads.FGLH_PARENT_ID,FLT_DATE 
				FROM (SELECT node.FGLH_ID, node.LF_L, node.FGLH_NAME,node.LEVELS, (COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
				 node.PRIMARY_PARENT_CODE, 
				 node.LEDGER_PRIMARY_PARENT_CODE,
				 node.FGLH_PARENT_ID 
				FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent 
				WHERE node.LEVELS!='MG'                                     
				and node.TYPE_ID = 'L'                                     
				AND node.LF_L                                     
				BETWEEN parent.LF_L                                     
				AND parent.RG_L                                     
				GROUP BY node.FGLH_NAME                                     
				ORDER BY node.LF_L)GLHeads                                     
				LEFT JOIN financial_ledger_transcations
				 ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
				 where financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				 and TRANSACTION_STATUS != 'Cancelled' 
				 and  (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
				 BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') 
				 AND STR_TO_DATE('$toRP', '%d-%m-%Y')
				 AND financial_ledger_transcations.RP_TYPE = 'R1') and COMP_ID 
				 LIKE '%$compId%' OR GLHeads.LEVELS ='PG' 
				 OR GLHeads.LEVELS ='PSG' 
				 OR GLHeads.LEVELS ='SG' 
				 GROUP BY GLHeads.FGLH_NAME ORDER BY GLHeads.LF_L) as tbl1 ,
               
 			(SELECT SUM(FLT_CR) AS AMT,
			            GLHeads.LEDGER_PRIMARY_PARENT_CODE,GLHeads.LEVELS 
				FROM (
					SELECT node.FGLH_ID, 
					       node.LF_L,node.LEVELS,node.FGLH_NAME,
						    (
								COUNT(
									parent.FGLH_NAME) - 1)AS LEVELD,
									 node.PRIMARY_PARENT_CODE,
									 node.LEDGER_PRIMARY_PARENT_CODE
						 FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent 
						 WHERE node.LEVELS!='MG' and node.TYPE_ID = 'L' 
						 AND node.LF_L BETWEEN parent.LF_L AND parent.RG_L 
						 GROUP BY node.FGLH_NAME 
						 ORDER BY node.LF_L)GLHeads 
				    LEFT JOIN financial_ledger_transcations ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
					where financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
					and TRANSACTION_STATUS != 'Cancelled' 
					and (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
					BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') 
					AND STR_TO_DATE('$toRP', '%d-%m-%Y')
					AND financial_ledger_transcations.RP_TYPE = 'R1') 
					and COMP_ID LIKE 
					'%$compId%' 
					OR GLHeads.LEVELS ='PG' 
					OR GLHeads.LEVELS ='PSG'
					 OR GLHeads.LEVELS ='SG'
					 GROUP BY GLHeads.LEDGER_PRIMARY_PARENT_CODE) as tbl2 
					 WHERE tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE) as b
 
 			UNION 

			SELECT * FROM ( 
				            SELECT tbl1.FGLH_NAME,
							       tbl1.AMT,tbl2.AMT  as PBalance,
								   tbl1.LEVELS,
								   tbl1.FGLH_ID,
								   tbl1.FGLH_PARENT_ID,
								   tbl1.FLT_DATE,
								   tbl1.LEDGER_PRIMARY_PARENT_CODE 
							FROM ( 
								   SELECT GLHeads.FGLH_ID,
								   CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.FGLH_NAME) AS FGLH_NAME,
								 SUM(FLT_CR) As AMT ,
								 GLHeads.LEVELS,
								 GLHeads.PRIMARY_PARENT_CODE,GLHeads.LEDGER_PRIMARY_PARENT_CODE,GLHeads.FGLH_PARENT_ID,FLT_DATE FROM (SELECT node.FGLH_ID, node.LF_I, node.FGLH_NAME,node.LEVELS, (COUNT(parent.FGLH_NAME) - 1) AS LEVELD, node.PRIMARY_PARENT_CODE, node.LEDGER_PRIMARY_PARENT_CODE,node.FGLH_PARENT_ID  FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent WHERE node.LEVELS!='MG' and node.TYPE_ID = 'I' AND node.LF_I BETWEEN parent.LF_I AND parent.RG_I GROUP BY node.FGLH_NAME ORDER BY node.LF_I)GLHeads LEFT JOIN financial_ledger_transcations ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID  where financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' and  (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND financial_ledger_transcations.RP_TYPE = 'R1')  and COMP_ID LIKE '%$compId%' OR GLHeads.LEVELS ='PG' OR GLHeads.LEVELS ='PSG' OR GLHeads.LEVELS ='SG' GROUP BY GLHeads.FGLH_NAME ORDER BY GLHeads.LF_I) as tbl1,

			(SELECT  SUM(FLT_CR) As AMT ,GLHeads.LEDGER_PRIMARY_PARENT_CODE,GLHeads.LEVELS 
			FROM (SELECT node.FGLH_ID, node.LF_I,node.LEVELS, node.FGLH_NAME, 
			(COUNT(parent.FGLH_NAME) - 1) AS LEVELD, 
			node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE FROM 
			`finacial_group_ledger_heads` node, 
			`finacial_group_ledger_heads` parent 
			WHERE node.LEVELS!='MG' and node.TYPE_ID = 'I' 
			AND node.LF_I 
			BETWEEN parent.LF_I AND parent.RG_I 
			GROUP BY node.FGLH_NAME 
			ORDER BY node.LF_I)GLHeads 
			LEFT JOIN financial_ledger_transcations 
			ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
			and TRANSACTION_STATUS != 'Cancelled' 
			and (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
			BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') 
			AND STR_TO_DATE('$toRP', '%d-%m-%Y')AND financial_ledger_transcations.RP_TYPE = 'R1')
			 and COMP_ID LIKE '%$compId%' 
			 OR GLHeads.LEVELS ='PG' 
			 OR GLHeads.LEVELS ='PSG'
			  OR GLHeads.LEVELS ='SG'
				GROUP BY GLHeads.LEDGER_PRIMARY_PARENT_CODE) as tbl2 
				WHERE tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE ) AS c";
	
	$query = $this->db->query($sql);
		return $query->result();
	}

	function getPayment($fromRP,$toRP,$compId) {	//TS
		$sql="SELECT * FROM (
			SELECT 
				tbl1.FGLH_NAME, 
				tbl1.AMT,
				tbl2.AMT as PBalance ,
				tbl1.LEVELS,
				tbl1.FGLH_ID,
				tbl1.FGLH_PARENT_ID,
				tbl1.FLT_DATE,
				tbl1.LEDGER_PRIMARY_PARENT_CODE 
			FROM (
				SELECT 
					GLHeads.FGLH_ID, 
					CONCAT(REPEAT(' ', GLHeads.LEVELD),GLHeads.FGLH_NAME) AS FGLH_NAME, 
					SUM(FLT_DR) AS AMT,
					GLHeads.LEVELS,
					GLHeads.PRIMARY_PARENT_CODE,
					GLHeads.LEDGER_PRIMARY_PARENT_CODE,
					GLHeads.FGLH_PARENT_ID,
					FLT_DATE 
				FROM (
					SELECT 
						node.FGLH_ID, 
						node.LF_A,
						node.LEVELS, 
						node.FGLH_NAME, 
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD, 
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE,
						node.FGLH_PARENT_ID 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS!='MG' 
						AND node.TYPE_ID = 'A' 
						AND node.LF_A BETWEEN parent.LF_A AND parent.RG_A 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_A
				) GLHeads 
				LEFT JOIN financial_ledger_transcations 
				ON 
					GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
				WHERE 
					financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
					AND TRANSACTION_STATUS != 'Cancelled' 
					AND (
						STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')
						AND financial_ledger_transcations.RP_TYPE = 'P1'
					) 
					AND COMP_ID LIKE '%$compId%' 
					OR GLHeads.LEVELS ='PG' 
					OR GLHeads.LEVELS ='PSG' 
					OR GLHeads.LEVELS ='SG' 
				GROUP BY 
					GLHeads.FGLH_NAME 
				ORDER BY 
					GLHeads.LF_A
			) as tbl1, 
			(
				SELECT 
					SUM(FLT_DR) AS AMT,
					GLHeads.LEDGER_PRIMARY_PARENT_CODE,
					GLHeads.LEVELS 
				FROM (
					SELECT 
						node.FGLH_ID, 
						node.LF_A,
						node.LEVELS, 
						node.FGLH_NAME, 
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD, 
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS!='MG' 
						AND node.TYPE_ID = 'A' 
						AND node.LF_A BETWEEN parent.LF_A AND parent.RG_A 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_A
				) GLHeads 
				LEFT JOIN financial_ledger_transcations 
				ON 
					GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
				WHERE 
					financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
					AND TRANSACTION_STATUS != 'Cancelled' 
					AND (
						STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')
						AND financial_ledger_transcations.RP_TYPE = 'P1'
					) 
					AND COMP_ID LIKE '%$compId%' 
					OR GLHeads.LEVELS ='PG' 
					OR GLHeads.LEVELS ='PSG' 
					OR GLHeads.LEVELS ='SG' 
				GROUP BY 
					GLHeads.LEDGER_PRIMARY_PARENT_CODE
			) as tbl2 
			WHERE 
				tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE
		) as a 
		
		UNION 
		
		SELECT * FROM (
			SELECT 
				tbl1.FGLH_NAME,
				tbl1.AMT,
				tbl2.AMT as PBalanceL ,
				tbl1.LEVELS,
				tbl1.FGLH_ID,
				tbl1.FGLH_PARENT_ID,
				tbl1.FLT_DATE,
				tbl1.LEDGER_PRIMARY_PARENT_CODE 
			FROM (
				SELECT 
					GLHeads.FGLH_ID, 
					CONCAT(REPEAT(' ', GLHeads.LEVELD),GLHeads.FGLH_NAME) AS FGLH_NAME,
					SUM(FLT_DR) AS AMT,
					GLHeads.LEVELS,
					GLHeads.PRIMARY_PARENT_CODE,
					GLHeads.LEDGER_PRIMARY_PARENT_CODE,
					GLHeads.FGLH_PARENT_ID,
					FLT_DATE 
				FROM (
					SELECT 
						node.FGLH_ID, 
						node.LF_L, 
						node.FGLH_NAME,
						node.LEVELS, 
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD, 
						node.PRIMARY_PARENT_CODE, 
						node.LEDGER_PRIMARY_PARENT_CODE,
						node.FGLH_PARENT_ID 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS!='MG' 
						AND node.TYPE_ID = 'L' 
						AND node.LF_L BETWEEN parent.LF_L AND parent.RG_L 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_L
				) GLHeads 
				LEFT JOIN financial_ledger_transcations 
				ON 
					GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
				WHERE 
					financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
					AND TRANSACTION_STATUS != 'Cancelled' 
					AND (
						STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')
						AND financial_ledger_transcations.RP_TYPE = 'P1'
					) 
					AND COMP_ID LIKE '%$compId%' 
					OR GLHeads.LEVELS ='PG'                                                      
					OR GLHeads.LEVELS ='PSG'                                                      
					OR GLHeads.LEVELS ='SG'                                                      
				GROUP BY 
					GLHeads.FGLH_NAME 
				ORDER BY 
					GLHeads.LF_L
			) as tbl1 , 
			(
				SELECT 
					SUM(FLT_DR) AS AMT,
					GLHeads.LEDGER_PRIMARY_PARENT_CODE,
					GLHeads.LEVELS 
				FROM (
					SELECT 
						node.FGLH_ID, 
						node.LF_L,
						node.LEVELS,
						node.FGLH_NAME, 
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD, 
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS!='MG' 
						AND node.TYPE_ID = 'L' 
						AND node.LF_L BETWEEN parent.LF_L AND parent.RG_L 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_L
				) GLHeads 
				LEFT JOIN financial_ledger_transcations 
				ON 
					GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
				WHERE 
					financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
					AND TRANSACTION_STATUS != 'Cancelled' 
					AND (
						STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')
						AND financial_ledger_transcations.RP_TYPE = 'P1'
					) 
					AND COMP_ID LIKE '%$compId%' 
					OR GLHeads.LEVELS ='PG' 
					OR GLHeads.LEVELS ='PSG' 
					OR GLHeads.LEVELS ='SG' 
				GROUP BY 
					GLHeads.LEDGER_PRIMARY_PARENT_CODE
			) as tbl2 
			WHERE 
				tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE
		) as b 
		
		UNION 
		
		SELECT * FROM(
			SELECT 
				tbl1.FGLH_NAME,
				tbl1.AMT,
				tbl2.AMT as PBalance,
				tbl1.LEVELS,
				tbl1.FGLH_ID,
				tbl1.FGLH_PARENT_ID,
				tbl1.FLT_DATE,
				tbl1.LEDGER_PRIMARY_PARENT_CODE 
			FROM (
				SELECT 
					GLHeads.FGLH_ID,
					CONCAT(REPEAT(' ', GLHeads.LEVELD),GLHeads.FGLH_NAME) AS FGLH_NAME, 
					SUM(FLT_DR) As AMT ,
					GLHeads.PRIMARY_PARENT_CODE,
					GLHeads.LEDGER_PRIMARY_PARENT_CODE,
					GLHeads.LEVELS,
					GLHeads.FGLH_PARENT_ID,
					FLT_DATE 
				FROM (
					SELECT 
						node.FGLH_ID, 
						node.LF_E, 
						node.FGLH_NAME,
						node.LEVELS, 
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD, 
						node.PRIMARY_PARENT_CODE, 
						node.LEDGER_PRIMARY_PARENT_CODE,
						node.FGLH_PARENT_ID 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS!='MG' 
						AND node.TYPE_ID = 'E' 
						AND node.LF_E BETWEEN parent.LF_E AND parent.RG_E 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_E
				) AS GLHeads 
				LEFT JOIN financial_ledger_transcations 
				ON 
					GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
				WHERE 
					financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
					AND TRANSACTION_STATUS != 'Cancelled' 
					AND (
						STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')
						AND financial_ledger_transcations.RP_TYPE = 'P1'
					) 
					AND COMP_ID LIKE '%$compId%' 
					OR GLHeads.LEVELS ='PG' 
					OR GLHeads.LEVELS ='PSG' 
					OR GLHeads.LEVELS ='SG' 
				GROUP BY 
					GLHeads.FGLH_NAME 
				ORDER BY 
					GLHeads.LF_E
			) AS tbl1, 
			(
				SELECT 
					SUM(FLT_DR) As AMT, 
					GLHeads.LEDGER_PRIMARY_PARENT_CODE,
					GLHeads.LEVELS 
				FROM (
					SELECT 
						node.FGLH_ID, 
						node.LF_E,
						node.LEVELS, 
						node.FGLH_NAME, 
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD, 
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS!='MG' 
						AND node.TYPE_ID = 'E' 
						AND node.LF_E BETWEEN parent.LF_E AND parent.RG_E 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_E
				) GLHeads 
				LEFT JOIN financial_ledger_transcations 
				ON 
					GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
				WHERE 
					financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
					AND TRANSACTION_STATUS != 'Cancelled' 
					AND (
						STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')
						AND financial_ledger_transcations.RP_TYPE = 'P1'
					) 
					AND COMP_ID LIKE '%$compId%' 
					OR GLHeads.LEVELS ='PG' 
					OR GLHeads.LEVELS ='PSG' 
					OR GLHeads.LEVELS ='SG' 
				GROUP BY 
					GLHeads.LEDGER_PRIMARY_PARENT_CODE
			) as tbl2 
			WHERE 
				tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE
		) as c";
		// echo "$sql";
		$query = $this->db->query($sql);	
		return $query->result();
	}

//////////////////////////////////FUNCTION added by adithya for fetching the journal entry for R&P
	// function getJournalEntryForR_P($fromRP = '',$toRP = '',$compId = ''){
     
	// 	$sql= "SELECT 
	// 	ledger.FLT_ID,
	// 	HEADS.TYPE_ID,
	// 	HEADS.FGLH_NAME,
	// 	HEADS.FGLH_PARENT_ID,
	// 	ledger.FGLH_ID,
	// 	ledger.VOUCHER_NO,
	// 	 ledger.FLT_DR AS PBalanceDR,
	// 	ledger.FLT_CR AS PBalanceCR,
	// 	ledger.FLT_DATE 
	// FROM 
	// 	financial_ledger_transcations ledger
	// JOIN 
	// 	finacial_group_ledger_heads HEADS ON ledger.FGLH_ID = HEADS.FGLH_ID
	// WHERE 
	// 	HEADS.FGLH_PARENT_ID != 8
	// 	AND HEADS.FGLH_PARENT_ID != 9 
	// 	AND (
	// 		ledger.RP_TYPE = 'J1' OR ledger.RP_TYPE = 'J2'
	// 	)
	// 	AND (
	// 		STR_TO_DATE(ledger.FLT_DATE, '%d-%m-%Y') 
	// 		BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') AND STR_TO_DATE('$toRP', '%d-%m-%Y')
	// 	)
	// 	AND ledger.COMP_ID LIKE '%$compId%'";
	
    //   $query = $this->db->query($sql);
	//   if ($query->num_rows() > 0) {
	// 	  return $query->result();
	//   } else {
	// 	  return array();
	//   }
	// }
/////////////////////////////////////FUNCTION END

	function getIncome($fromIe,$toIe,$compId) {		//TS
		$sql ="SELECT tbl1.FGLH_ID,tbl1.FGLH_NAME,tbl1.FLT_CR,tbl2.FLT_CR  as PBalance,
		tbl1.LEVELS,tbl1.FGLH_PARENT_ID,tbl1.FLT_DATE,tbl1.LEDGER_PRIMARY_PARENT_CODE
		FROM (SELECT GLHeads.FGLH_ID,CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.FGLH_NAME) AS FGLH_NAME, 
		SUM(FLT_DR) As FLT_DR, SUM(FLT_CR) As FLT_CR ,
		GLHeads.PRIMARY_PARENT_CODE,GLHeads.LEDGER_PRIMARY_PARENT_CODE,
		GLHeads.LEVELS,GLHeads.FGLH_PARENT_ID,FLT_DATE FROM 
		(SELECT node.FGLH_ID, node.LF_I, node.FGLH_NAME,node.LEVELS, (COUNT(parent.FGLH_NAME) - 1) 
		AS LEVELD, node.PRIMARY_PARENT_CODE, node.LEDGER_PRIMARY_PARENT_CODE,node.FGLH_PARENT_ID  
		FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent 
		WHERE node.LEVELS!='MG' and 
		node.TYPE_ID = 'I' AND node.LF_I BETWEEN parent.LF_I AND parent.RG_I 
		GROUP BY node.FGLH_NAME ORDER BY node.LF_I)
		GLHeads LEFT JOIN financial_ledger_transcations 
		ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
		WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		and TRANSACTION_STATUS != 'Cancelled' 
		and (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
		BETWEEN STR_TO_DATE('$fromIe', '%d-%m-%Y') AND STR_TO_DATE('$toIe', '%d-%m-%Y')) and COMP_ID LIKE '%$compId%' OR GLHeads.LEVELS ='PG' OR GLHeads.LEVELS ='PSG' OR GLHeads.LEVELS ='SG' 
		GROUP BY GLHeads.FGLH_NAME ORDER BY GLHeads.LF_I) as tbl1,

		(SELECT  SUM(FLT_DR) As FLT_DR, SUM(FLT_CR) As FLT_CR ,
		GLHeads.LEDGER_PRIMARY_PARENT_CODE,GLHeads.LEVELS
		FROM (SELECT node.FGLH_ID, node.LF_I,node.LEVELS, node.FGLH_NAME, (COUNT(parent.FGLH_NAME) - 1) 
		AS LEVELD, node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent WHERE node.LEVELS!='MG' and 
		node.TYPE_ID = 'I' 
		AND node.LF_I 
		BETWEEN parent.LF_I AND parent.RG_I GROUP BY node.FGLH_NAME ORDER BY node.LF_I)
		GLHeads 
		LEFT JOIN financial_ledger_transcations ON 
		GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID WHERE  
		financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		and TRANSACTION_STATUS != 'Cancelled' 
		and (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromIe', '%d-%m-%Y') AND STR_TO_DATE('$toIe', '%d-%m-%Y')) and COMP_ID LIKE '%$compId%' OR GLHeads.LEVELS ='PG' OR GLHeads.LEVELS ='PSG' OR GLHeads.LEVELS ='SG'
		GROUP BY GLHeads.LEDGER_PRIMARY_PARENT_CODE) as tbl2
		WHERE tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE";
		// echo "$sql";
		$query= $this->db->query($sql);
		return $query->result();	
	}

	function getExpence($fromIe,$toIe,$compId) {	//TS
		$sql = "SELECT tbl1.FGLH_ID,tbl1.FGLH_NAME,tbl1.FLT_DR,tbl2.FLT_DR  as PBalance,tbl1.LEVELS,tbl1.FGLH_PARENT_ID,tbl1.FLT_DATE,tbl1.LEDGER_PRIMARY_PARENT_CODE 
		FROM (SELECT GLHeads.FGLH_ID,CONCAT(REPEAT('&nbsp;', GLHeads.LEVELD),GLHeads.FGLH_NAME) AS FGLH_NAME, 
		SUM(FLT_DR) As FLT_DR, SUM(FLT_CR) As FLT_CR ,GLHeads.PRIMARY_PARENT_CODE,GLHeads.LEDGER_PRIMARY_PARENT_CODE,GLHeads.LEVELS,GLHeads.FGLH_PARENT_ID,FLT_DATE
		FROM (SELECT node.FGLH_ID, node.LF_E, node.FGLH_NAME,node.LEVELS, (COUNT(parent.FGLH_NAME) - 1) 
		AS LEVELD, node.PRIMARY_PARENT_CODE, node.LEDGER_PRIMARY_PARENT_CODE,node.FGLH_PARENT_ID FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent WHERE node.LEVELS!='MG' and 
		node.TYPE_ID = 'E' AND node.LF_E BETWEEN parent.LF_E AND parent.RG_E GROUP BY node.FGLH_NAME ORDER BY node.LF_E)
		GLHeads LEFT JOIN financial_ledger_transcations ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' and  (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromIe', '%d-%m-%Y') AND STR_TO_DATE('$toIe', '%d-%m-%Y')) and COMP_ID LIKE '%$compId%' OR GLHeads.LEVELS ='PG' OR GLHeads.LEVELS ='PSG' OR GLHeads.LEVELS ='SG' 
		GROUP BY GLHeads.FGLH_NAME ORDER BY GLHeads.LF_E) AS tbl1,

		(SELECT  SUM(FLT_DR) As FLT_DR, SUM(FLT_CR) As FLT_CR ,
		GLHeads.LEDGER_PRIMARY_PARENT_CODE,GLHeads.LEVELS
		FROM (SELECT node.FGLH_ID, node.LF_E,node.LEVELS, node.FGLH_NAME, (COUNT(parent.FGLH_NAME) - 1) 
		AS LEVELD, node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE FROM `finacial_group_ledger_heads` node, `finacial_group_ledger_heads` parent WHERE node.LEVELS!='MG' and 
		node.TYPE_ID = 'E' AND node.LF_E BETWEEN parent.LF_E AND parent.RG_E GROUP BY node.FGLH_NAME ORDER BY node.LF_E)
		GLHeads LEFT JOIN financial_ledger_transcations ON GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' and (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromIe', '%d-%m-%Y') AND STR_TO_DATE('$toIe', '%d-%m-%Y')) and COMP_ID LIKE '%$compId%' OR GLHeads.LEVELS ='PG' OR GLHeads.LEVELS ='PSG' OR GLHeads.LEVELS ='SG'
		GROUP BY GLHeads.LEDGER_PRIMARY_PARENT_CODE) as tbl2
		WHERE tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function getTrialData($fromTB,$toTB,$compId) {	//TS

		////////////////////////////////////////////////new code start///////////////////////////////////////
		$sql = "SELECT 
		tbl1.FGLH_ID,
		tbl1.FGLH_NAME,
		tbl1.FLT_CR,
		tbl1.FLT_DR,
	  
		tbl2.FLT_CR as PBalance,
		tbl1.LEVELS,
		tbl1.FGLH_PARENT_ID,
		tbl1.FLT_DATE,
		tbl1.LEDGER_PRIMARY_PARENT_CODE,
		tbl1.TYPE_ID,
	   tbl1.Debit,
		 tbl1.Credit
	FROM 
		(
			SELECT 
				GLHeads.FGLH_ID,
				CONCAT(REPEAT(' ', GLHeads.LEVELD), GLHeads.FGLH_NAME) AS FGLH_NAME,
				SUM(FLT_DR) As FLT_DR,
				SUM(FLT_CR) As FLT_CR,
			 SUM(FLT_DR-FLT_CR) AS Debit,
			SUM(FLT_CR-FLT_DR) AS Credit,
				GLHeads.PRIMARY_PARENT_CODE,
				GLHeads.LEDGER_PRIMARY_PARENT_CODE,
				GLHeads.LEVELS,
				GLHeads.FGLH_PARENT_ID,
				FLT_DATE ,
			   GLHeads.TYPE_ID
			FROM 
				(
					SELECT 
						node.FGLH_ID,
						node.LF_I, 
						node.FGLH_NAME,
						node.LEVELS,
						node.TYPE_ID,
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE,
						node.FGLH_PARENT_ID 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS != 'MG' 
						AND node.TYPE_ID = 'I' 
						AND node.LF_I BETWEEN parent.LF_I AND parent.RG_I 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_I
				) GLHeads 
			LEFT JOIN 
				financial_ledger_transcations 
			ON 
				GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			WHERE 
				financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				AND TRANSACTION_STATUS != 'Cancelled' 
				AND (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromTB', '%d-%m-%Y') AND STR_TO_DATE('$toTB', '%d-%m-%Y')) 
				AND COMP_ID LIKE '%$compId%' 
				OR GLHeads.LEVELS = 'PG' 
				OR GLHeads.LEVELS = 'PSG' 
				OR GLHeads.LEVELS = 'SG' 
			GROUP BY 
				GLHeads.FGLH_NAME 
			ORDER BY 
				GLHeads.LF_I
		) AS tbl1, 
		(
			SELECT 
				SUM(FLT_DR) As FLT_DR,
				SUM(FLT_CR) As FLT_CR,
			SUM(FLT_DR-FLT_CR) AS Debit,
			SUM(FLT_CR-FLT_DR) AS Credit,
				GLHeads.LEDGER_PRIMARY_PARENT_CODE,
				GLHeads.LEVELS 
			FROM 
				(
					SELECT 
						node.FGLH_ID,
						node.LF_I,
						node.LEVELS, 
						node.FGLH_NAME, 
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS != 'MG' 
						AND node.TYPE_ID = 'I' 
						AND node.LF_I BETWEEN parent.LF_I AND parent.RG_I 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_I
				) GLHeads 
			LEFT JOIN 
				financial_ledger_transcations 
			ON 
				GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			WHERE 
				financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				AND TRANSACTION_STATUS != 'Cancelled' 
				AND (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromTB', '%d-%m-%Y') AND STR_TO_DATE('$toTB', '%d-%m-%Y')) 
				AND COMP_ID LIKE '%$compId%' 
				OR GLHeads.LEVELS = 'PG' 
				OR GLHeads.LEVELS = 'PSG' 
				OR GLHeads.LEVELS = 'SG' 
			GROUP BY 
				GLHeads.LEDGER_PRIMARY_PARENT_CODE
		) AS tbl2 
	WHERE 
		tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE
		
		 UNION 
	  
	  SELECT 
		tbl1.FGLH_ID,
		tbl1.FGLH_NAME,
		tbl1.FLT_CR,
		tbl1.FLT_DR,
		
		tbl2.FLT_DR as PBalance,
		tbl1.LEVELS,
		tbl1.FGLH_PARENT_ID,
		tbl1.FLT_DATE,
		tbl1.LEDGER_PRIMARY_PARENT_CODE ,
		tbl1.TYPE_ID,
		tbl1.Debit,
		 tbl1.Credit
		
	FROM 
		(
			SELECT 
				GLHeads.FGLH_ID,
				CONCAT(REPEAT(' ', GLHeads.LEVELD), GLHeads.FGLH_NAME) AS FGLH_NAME,
				SUM(FLT_DR) As FLT_DR,
				SUM(FLT_CR) As FLT_CR,
			SUM(FLT_DR-FLT_CR) AS Debit,
			SUM(FLT_CR-FLT_DR) AS Credit,
				GLHeads.PRIMARY_PARENT_CODE,
				GLHeads.LEDGER_PRIMARY_PARENT_CODE,
				GLHeads.LEVELS,
				GLHeads.TYPE_ID,
				GLHeads.FGLH_PARENT_ID,
				FLT_DATE 
			FROM 
				(
					SELECT 
						node.FGLH_ID,
						node.LF_E, 
						node.FGLH_NAME,
						node.LEVELS,
					node.TYPE_ID,
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE,
						node.FGLH_PARENT_ID 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS != 'MG' 
						AND node.TYPE_ID = 'E' 
						AND node.LF_E BETWEEN parent.LF_E AND parent.RG_E 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_E
				) GLHeads 
			LEFT JOIN 
				financial_ledger_transcations 
			ON 
				GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			WHERE 
				financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				AND TRANSACTION_STATUS != 'Cancelled' 
				AND (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromTB', '%d-%m-%Y') AND STR_TO_DATE('$toTB', '%d-%m-%Y')) 
				AND COMP_ID LIKE '%$compId%' 
				OR GLHeads.LEVELS = 'PG' 
				OR GLHeads.LEVELS = 'PSG' 
				OR GLHeads.LEVELS = 'SG' 
			GROUP BY 
				GLHeads.FGLH_NAME 
			ORDER BY 
				GLHeads.LF_E
		) AS tbl1, 
		(
			SELECT 
				SUM(FLT_DR) As FLT_DR,
				SUM(FLT_CR) As FLT_CR,
			SUM(FLT_DR-FLT_CR) AS Debit,
			SUM(FLT_CR-FLT_DR) AS Credit,
				GLHeads.LEDGER_PRIMARY_PARENT_CODE,
				GLHeads.LEVELS 
			FROM 
				(
					SELECT 
						node.FGLH_ID,
						node.LF_E,
						node.LEVELS, 
						node.FGLH_NAME, 
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS != 'MG' 
						AND node.TYPE_ID = 'E' 
						AND node.LF_E BETWEEN parent.LF_E AND parent.RG_E 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_E
				) GLHeads 
			LEFT JOIN 
				financial_ledger_transcations 
			ON 
				GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			WHERE 
				financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				AND TRANSACTION_STATUS != 'Cancelled' 
				AND (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromTB', '%d-%m-%Y') AND STR_TO_DATE('$toTB', '%d-%m-%Y')) 
				AND COMP_ID LIKE '%$compId%' 
				OR GLHeads.LEVELS = 'PG' 
				OR GLHeads.LEVELS = 'PSG' 
				OR GLHeads.LEVELS = 'SG' 
			GROUP BY 
				GLHeads.LEDGER_PRIMARY_PARENT_CODE
		) AS tbl2 
	WHERE 
		tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE
		
			UNION 
	  
	  SELECT 
		tbl1.FGLH_ID,
		tbl1.FGLH_NAME,
		tbl1.FLT_CR,
		tbl1.FLT_DR,
	  
		tbl2.FLT_DR as PBalance,
		tbl1.LEVELS,
		tbl1.FGLH_PARENT_ID,
		tbl1.FLT_DATE,
		tbl1.LEDGER_PRIMARY_PARENT_CODE,
		tbl1.TYPE_ID,
		 tbl1.Debit,
		 tbl1.Credit
	   
	FROM 
		(
			SELECT 
				GLHeads.FGLH_ID,
				CONCAT(REPEAT(' ', GLHeads.LEVELD), GLHeads.FGLH_NAME) AS FGLH_NAME,
				SUM(FLT_DR) As FLT_DR,
				SUM(FLT_CR) As FLT_CR,
		   SUM(FLT_DR-FLT_CR) AS Debit,
			SUM(FLT_CR-FLT_DR) AS Credit,
				GLHeads.PRIMARY_PARENT_CODE,
				GLHeads.LEDGER_PRIMARY_PARENT_CODE,
				GLHeads.LEVELS,
			GLHeads.TYPE_ID,
				GLHeads.FGLH_PARENT_ID,
				FLT_DATE 
			FROM 
				(
					SELECT 
						node.FGLH_ID,
						node.LF_A, 
						node.FGLH_NAME,
						node.LEVELS,
					node.TYPE_ID,
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE,
						node.FGLH_PARENT_ID 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS != 'MG' 
						AND node.TYPE_ID = 'A' 
						AND node.LF_A BETWEEN parent.LF_A AND parent.RG_A 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_A
				) GLHeads 
			LEFT JOIN 
				financial_ledger_transcations 
			ON 
				GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			WHERE 
				financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				AND TRANSACTION_STATUS != 'Cancelled' 
				AND (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromTB', '%d-%m-%Y') AND STR_TO_DATE('$toTB', '%d-%m-%Y')) 
				AND COMP_ID LIKE '%$compId%' 
				OR GLHeads.LEVELS = 'PG' 
				OR GLHeads.LEVELS = 'PSG' 
				OR GLHeads.LEVELS = 'SG' 
			GROUP BY 
				GLHeads.FGLH_NAME 
			ORDER BY 
				GLHeads.LF_A
		) AS tbl1, 
		(
			SELECT 
				SUM(FLT_DR) As FLT_DR,
				SUM(FLT_CR) As FLT_CR,
			SUM(FLT_DR-FLT_CR) AS Debit,
			SUM(FLT_CR-FLT_DR) AS Credit,
				GLHeads.LEDGER_PRIMARY_PARENT_CODE,
				GLHeads.LEVELS 
			FROM 
				(
					SELECT 
						node.FGLH_ID,
						node.LF_A,
						node.LEVELS, 
						node.FGLH_NAME, 
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS != 'MG' 
						AND node.TYPE_ID = 'A' 
						AND node.LF_A BETWEEN parent.LF_A AND parent.RG_A 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_A
				) GLHeads 
			LEFT JOIN 
				financial_ledger_transcations 
			ON 
				GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			WHERE 
				financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				AND TRANSACTION_STATUS != 'Cancelled' 
				AND (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromTB', '%d-%m-%Y') AND STR_TO_DATE('$toTB', '%d-%m-%Y')) 
				AND COMP_ID LIKE '%$compId%' 
				OR GLHeads.LEVELS = 'PG' 
				OR GLHeads.LEVELS = 'PSG' 
				OR GLHeads.LEVELS = 'SG' 
			GROUP BY 
				GLHeads.LEDGER_PRIMARY_PARENT_CODE
		) AS tbl2 
	WHERE 
		tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE
		  
		 UNION 
	  
	  SELECT 
		tbl1.FGLH_ID,
		tbl1.FGLH_NAME,
		tbl1.FLT_CR,
		tbl1.FLT_DR,
	   
		tbl2.FLT_CR as PBalance,
		tbl1.LEVELS,
		tbl1.FGLH_PARENT_ID,
		tbl1.FLT_DATE,
		tbl1.LEDGER_PRIMARY_PARENT_CODE,
		tbl1.TYPE_ID,
		 tbl1.Debit,
		 tbl1.Credit
	FROM 
		(
			SELECT 
				GLHeads.FGLH_ID,
				CONCAT(REPEAT(' ', GLHeads.LEVELD), GLHeads.FGLH_NAME) AS FGLH_NAME,
				SUM(FLT_DR) As FLT_DR,
				SUM(FLT_CR) As FLT_CR,
			SUM(FLT_DR-FLT_CR) AS Debit,
			SUM(FLT_CR-FLT_DR) AS Credit,
				GLHeads.PRIMARY_PARENT_CODE,
				GLHeads.LEDGER_PRIMARY_PARENT_CODE,
				GLHeads.LEVELS,
			GLHeads.TYPE_ID,
				GLHeads.FGLH_PARENT_ID,
				FLT_DATE 
			FROM 
				(
					SELECT 
						node.FGLH_ID,
						node.LF_L, 
						node.FGLH_NAME,
						node.LEVELS,
					node.TYPE_ID,
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE,
						node.FGLH_PARENT_ID 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS != 'MG' 
						AND node.TYPE_ID = 'L' 
						AND node.LF_L BETWEEN parent.LF_L AND parent.RG_L 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_L
				) GLHeads 
			LEFT JOIN 
				financial_ledger_transcations 
			ON 
				GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			WHERE 
				financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				AND TRANSACTION_STATUS != 'Cancelled' 
				AND (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromTB', '%d-%m-%Y') AND STR_TO_DATE('$toTB', '%d-%m-%Y')) 
				AND COMP_ID LIKE '%$compId%' 
				OR GLHeads.LEVELS = 'PG' 
				OR GLHeads.LEVELS = 'PSG' 
				OR GLHeads.LEVELS = 'SG' 
			GROUP BY 
				GLHeads.FGLH_NAME 
			ORDER BY 
				GLHeads.LF_L
		) AS tbl1, 
		(
			SELECT 
				SUM(FLT_DR) As FLT_DR,
				SUM(FLT_CR) As FLT_CR,
			 SUM(FLT_DR-FLT_CR) AS Debit,
			SUM(FLT_CR-FLT_DR) AS Credit,
				GLHeads.LEDGER_PRIMARY_PARENT_CODE,
				GLHeads.LEVELS 
			FROM 
				(
					SELECT 
						node.FGLH_ID,
						node.LF_L,
						node.LEVELS, 
						node.FGLH_NAME, 
						(COUNT(parent.FGLH_NAME) - 1) AS LEVELD,
						node.PRIMARY_PARENT_CODE,
						node.LEDGER_PRIMARY_PARENT_CODE 
					FROM 
						`finacial_group_ledger_heads` node, 
						`finacial_group_ledger_heads` parent 
					WHERE 
						node.LEVELS != 'MG' 
						AND node.TYPE_ID = 'L' 
						AND node.LF_L BETWEEN parent.LF_L AND parent.RG_L 
					GROUP BY 
						node.FGLH_NAME 
					ORDER BY 
						node.LF_L
				) GLHeads 
			LEFT JOIN 
				financial_ledger_transcations 
			ON 
				GLHeads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
			WHERE 
				financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
				AND TRANSACTION_STATUS != 'Cancelled' 
				AND (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromTB', '%d-%m-%Y') AND STR_TO_DATE('$toTB', '%d-%m-%Y')) 
				AND COMP_ID LIKE '%$compId%' 
				OR GLHeads.LEVELS = 'PG' 
				OR GLHeads.LEVELS = 'PSG' 
				OR GLHeads.LEVELS = 'SG' 
			GROUP BY 
				GLHeads.LEDGER_PRIMARY_PARENT_CODE
		) AS tbl2 
	WHERE 
		tbl1.PRIMARY_PARENT_CODE = tbl2.LEDGER_PRIMARY_PARENT_CODE";

//echo "$sql1";

///////////////////////////////////old code start///////////////////////////////////////
		// $sql="SELECT finacial_group_ledger_heads.FGLH_ID,FGLH_NAME,LEVELS, 
		// SUM(FLT_DR-FLT_CR) AS Debit,
		// SUM(FLT_CR-FLT_DR) AS Credit,TYPE_ID
		// FROM `finacial_group_ledger_heads` 
		// INNER JOIN financial_ledger_transcations 
		// ON finacial_group_ledger_heads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
		// WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		//  and TRANSACTION_STATUS != 'Cancelled' 
		//    and  finacial_group_ledger_heads.LEVELS='LG' 
		//     AND STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
		// BETWEEN STR_TO_DATE('$fromTB', '%d-%m-%Y') 
		//  AND STR_TO_DATE('$toTB', '%d-%m-%Y') 
		//   AND financial_ledger_transcations.COMP_ID 
		// LIKE '%$compId%' 
		// GROUP BY finacial_group_ledger_heads.FGLH_ID 
		// ORDER BY
		// finacial_group_ledger_heads.TYPE_ID ";
		// " ;

		

	$query = $this->db->query($sql);
		return $query->result();
	}

	function getOpening($fromRP,$toRP,$compId,$newCondition) {	//TS
		$sql="SELECT FLT_ID,FGLH_NAME,SUM(FLT_DR-FLT_CR) AS AMOUNT 
		FROM `financial_ledger_transcations` 
		INNER JOIN finacial_group_ledger_heads 
		ON financial_ledger_transcations.FGLH_ID=finacial_group_ledger_heads.FGLH_ID 
		WHERE 
		 financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		and 
		TRANSACTION_STATUS != 'Cancelled' 
		and  
		(STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
		BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') 
		AND STR_TO_DATE('$toRP', '%d-%m-%Y')) 
		AND  
		(finacial_group_ledger_heads.FGLH_PARENT_ID=9 
		OR finacial_group_ledger_heads.FGLH_PARENT_ID=8) 
		$newCondition 
		AND financial_ledger_transcations.COMP_ID 
		LIKE '%$compId%' GROUP BY finacial_group_ledger_heads.FGLH_NAME";
		
		// AND (RP_TYPE='OP') 
		// echo "$sql";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getClosing($fromRP_OP,$fromRP,$toRP,$compId) {	//TS
		// $sql ="SELECT FLT_ID,FGLH_NAME,SUM(FLT_DR-FLT_CR) AS AMOUNT 
		// FROM `financial_ledger_transcations` 
		// INNER JOIN finacial_group_ledger_heads 
		// ON financial_ledger_transcations.FGLH_ID=finacial_group_ledger_heads.FGLH_ID 
		// WHERE  
		// financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		// and 
		// TRANSACTION_STATUS != 'Cancelled' 
		// and  
		// (STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
		// BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') 
		// AND STR_TO_DATE('$toRP', '%d-%m-%Y') )
		// AND ( finacial_group_ledger_heads.FGLH_PARENT_ID=9 
		// OR finacial_group_ledger_heads.FGLH_PARENT_ID=8 ) 
		// AND financial_ledger_transcations.COMP_ID 
		// LIKE '%$compId%' GROUP BY finacial_group_ledger_heads.FGLH_NAME";

		$sql = "SELECT 
		FLT_ID,
		FGLH_NAME,
		SUM(FLT_DR-FLT_CR) AS AMOUNT 
	FROM 
		financial_ledger_transcations 
	INNER JOIN 
		finacial_group_ledger_heads 
	ON 
		financial_ledger_transcations.FGLH_ID=finacial_group_ledger_heads.FGLH_ID 
	WHERE  
		financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		AND TRANSACTION_STATUS != 'Cancelled' 
		AND (
			(STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
			BETWEEN STR_TO_DATE('$fromRP', '%d-%m-%Y') 
			AND STR_TO_DATE('$toRP', '%d-%m-%Y'))
			OR
			(
			STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') = STR_TO_DATE('$fromRP_OP', '%d-%m-%Y')
			AND RP_TYPE = 'OP'
			)
		)
		AND (finacial_group_ledger_heads.FGLH_PARENT_ID=9 
			OR finacial_group_ledger_heads.FGLH_PARENT_ID=8) 
		AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' 
	GROUP BY 
		finacial_group_ledger_heads.FGLH_NAME";
		// echo "$sql";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function putNewLedger($group,$nameL,$lft,$rgt,$accountno,$ifsccode,$bankname,$branch,$location,$parentLevel,$jouranalyes,$committeeAssigned,$terminalyes,$fdyes,$maturitystart,$maturityend,$intrestrate,$fdBankName,$fdNumber,$fdBankId) {
		$sql1 ="SELECT @myLeft := ".$lft.", @pId :=FGLH_ID, @type_id :=TYPE_ID,@acronym :=PRIMARY_PARENT_CODE,@subAcronym :=LEDGER_PRIMARY_PARENT_CODE FROM finacial_group_ledger_heads WHERE FGLH_ID = '$group'";
		
		$sql2 ="UPDATE finacial_group_ledger_heads SET ".$rgt." = ".$rgt." + 2 WHERE ".$rgt." > @myLeft";
		$sql3 ="UPDATE finacial_group_ledger_heads SET ".$lft." = ".$lft." + 2 WHERE ".$lft." > @myLeft";

		if($parentLevel == 'PG'){
			$sql4 ="INSERT INTO finacial_group_ledger_heads(FGLH_NAME,FGLH_PARENT_ID,LEDGER_PRIMARY_PARENT_CODE,TYPE_ID, ".$lft.", ".$rgt.",LEVELS,BANK_NAME,ACCOUNT_NO,BANK_BRANCH,BANK_LOCATION,BANK_IFSC_CODE,IS_JOURNAL_STATUS,COMP_ID,IS_TERMINAL,IS_FD_STATUS,FD_MATURITY_START_DATE,FD_MATURITY_END_DATE,FD_INTEREST_RATE,FD_BANK_NAME,FD_NUMBER,FD_BANK_ID) VALUES('$nameL',@pId,@acronym,@type_id, @myLeft + 1, @myLeft + 2,'LG','$bankname','$accountno','$branch','$location','$ifsccode',$jouranalyes,'$committeeAssigned',$terminalyes,$fdyes,'$maturitystart','$maturityend','$intrestrate','$fdBankName','$fdNumber','$fdBankId')";
		}else{
			$sql4 ="INSERT INTO finacial_group_ledger_heads(FGLH_NAME,FGLH_PARENT_ID,LEDGER_PRIMARY_PARENT_CODE,TYPE_ID, ".$lft.", ".$rgt.",LEVELS ,BANK_NAME ,ACCOUNT_NO ,BANK_BRANCH ,BANK_LOCATION ,BANK_IFSC_CODE,IS_JOURNAL_STATUS,COMP_ID,IS_TERMINAL,IS_FD_STATUS,FD_MATURITY_START_DATE,FD_MATURITY_END_DATE,FD_INTEREST_RATE,FD_BANK_NAME,FD_NUMBER,FD_BANK_ID) VALUES('$nameL',@pId,@subAcronym,@type_id, @myLeft + 1, @myLeft + 2,'LG','$bankname','$accountno','$branch','$location','$ifsccode',$jouranalyes,'$committeeAssigned',$terminalyes,$fdyes,'$maturitystart','$maturityend','$intrestrate','$fdBankName','$fdNumber','$fdBankId')";	
		}
		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);
		return $query1->result();
	}

	function putNewGroup($group,$nameG,$lft,$rgt,$levels,$parentLevel) {
		$sql1 ="SELECT @myLeft := ".$lft.",@pId :=FGLH_ID, @type_id :=TYPE_ID , @parentAcronym := PRIMARY_PARENT_CODE ,@subAcronym :=LEDGER_PRIMARY_PARENT_CODE  FROM finacial_group_ledger_heads WHERE FGLH_ID = '$group'";

		$sql2 ="UPDATE finacial_group_ledger_heads SET ".$rgt." = ".$rgt." + 2 WHERE ".$rgt." > @myLeft";
		$sql3 ="UPDATE finacial_group_ledger_heads SET ".$lft." = ".$lft." + 2 WHERE ".$lft." > @myLeft";

		if($levels == 'PG'){
			$sql4 ="INSERT INTO finacial_group_ledger_heads(FGLH_NAME,FGLH_PARENT_ID,TYPE_ID, ".$lft.", ".$rgt.",LEVELS) VALUES('$nameG',@pId,@type_id, @myLeft + 1, @myLeft + 2,'$levels')";
		}else{
			if($parentLevel == 'PG'){
				$sql4 ="INSERT INTO finacial_group_ledger_heads(FGLH_NAME,FGLH_PARENT_ID,LEDGER_PRIMARY_PARENT_CODE,TYPE_ID, ".$lft.", ".$rgt.",LEVELS) VALUES('$nameG',@pId,@parentAcronym,@type_id, @myLeft + 1, @myLeft + 2,'$levels')";
			}
			else{
				$sql4 ="INSERT INTO finacial_group_ledger_heads(FGLH_NAME,FGLH_PARENT_ID,LEDGER_PRIMARY_PARENT_CODE,TYPE_ID, ".$lft.", ".$rgt.",LEVELS) VALUES('$nameG',@pId,@subAcronym,@type_id, @myLeft + 1, @myLeft + 2,'$levels')";
			}

		}
		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);
		return $query1->result();
	}

	function getType1($group1) {
		$this->db->select('TYPE_ID');
		$this->db->from('finacial_group_ledger_heads');
		$this->db->where('FGLH_ID',$group1);
		return $this->db->get()->row()->TYPE_ID;
	}
	
	function getParentLevel($group1) {
		$this->db->select('LEVELS');
		$this->db->from('finacial_group_ledger_heads');
		$this->db->where('FGLH_ID',$group1);
		return $this->db->get()->row()->LEVELS;
	}

	function getMainGroups($condition="") {
		$this->db->select("FGLH_NAME,FGLH_ID")->from('finacial_group_ledger_heads');
		$where = "LEVELS='MG'";
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

	//GET FINACIAL MONTH 
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

	function getledgerdate() { 
		$this->db->select("FP_BOOKS_BEGIN_DATE")->from('finance_prerequisites');
		return $this->db->get()->row()->FP_BOOKS_BEGIN_DATE;
	}

	function get_chequeConfiguartion_details($num,$start){
		// $sql ="SELECT * FROM(SELECT finacial_group_ledger_heads.FGLH_ID,FGLH_NAME,COUNT(FCBD_STATUS) AS CurrChequeBooks,BANK_NAME,ACCOUNT_NO,BANK_BRANCH,BANK_LOCATION,BANK_IFSC_CODE FROM `finacial_group_ledger_heads` LEFT JOIN finance_cheque_book_details ON finance_cheque_book_details.FGLH_ID = finacial_group_ledger_heads.FGLH_ID WHERE finacial_group_ledger_heads.FGLH_PARENT_ID = 9 AND (FCBD_STATUS = 'Active' OR FCBD_STATUS = 'Available') GROUP BY finacial_group_ledger_heads.FGLH_ID
		// UNION
		// SELECT finacial_group_ledger_heads.FGLH_ID,FGLH_NAME,COUNT(FCBD_STATUS) as CurrChequeBooks,BANK_NAME,ACCOUNT_NO,BANK_BRANCH,BANK_LOCATION,BANK_IFSC_CODE FROM `finacial_group_ledger_heads` LEFT JOIN finance_cheque_book_details ON finance_cheque_book_details.FGLH_ID = finacial_group_ledger_heads.FGLH_ID WHERE finacial_group_ledger_heads.FGLH_PARENT_ID = 9 AND FCBD_STATUS IS NULL GROUP BY finacial_group_ledger_heads.FGLH_ID) as A ORDER BY FGLH_ID LIMIT $start, $num";
		$sql ="SELECT finacial_group_ledger_heads.FGLH_ID,FGLH_NAME,COUNT(FCBD_STATUS) AS CurrChequeBooks,BANK_NAME,ACCOUNT_NO,BANK_BRANCH,BANK_LOCATION,BANK_IFSC_CODE FROM `finacial_group_ledger_heads` LEFT JOIN finance_cheque_book_details ON finance_cheque_book_details.FGLH_ID = finacial_group_ledger_heads.FGLH_ID WHERE finacial_group_ledger_heads.FGLH_PARENT_ID = 9 GROUP BY finacial_group_ledger_heads.FGLH_ID  ORDER BY FGLH_ID LIMIT $start, $num";
		
		$query= $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	//to get number of rows of finacial_group_ledger_heads table
	function count_rows_chequeConfiguartion() {
		$this->db->select()->from('finacial_group_ledger_heads');
		$this->db->where('FGLH_PARENT_ID',9);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_cheque_details($num,$start,$id) {
		$this->db->select()->from('finance_cheque_book_details');
		$this->db->where('FGLH_ID',$id);
		$this->db->order_by('FCBD_STATUS','ASC');

		$this->db->limit($num, $start);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function count_rows_cheque_details($id) {
		$this->db->select()->from('finance_cheque_book_details');
		$this->db->where('FGLH_ID',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function insert($data) {
		$this->db->insert_batch('finance_cheque_detail', $data);
	}

	function get_ind_cheque_details($num,$start,$id) {
		$this->db->select()->from('finance_cheque_detail');
		$this->db->join('finance_cheque_book_details','finance_cheque_detail.FCBD_ID = finance_cheque_book_details.FCBD_ID');
		$this->db->where('finance_cheque_detail.FCBD_ID',$id);
		$this->db->order_by('CHEQUE_NO','ASC');

		$this->db->limit($num, $start);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function count_rows_ind_cheque_details($id) {
		$this->db->select('CHEQUE_NO')->from('finance_cheque_detail');
		$this->db->distinct();
		$this->db->where('FCBD_ID',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	// function count_rows_ind_cheque_details($id) {
		// 	$this->db->select()->from('finance_cheque_detail');
		// 	$this->db->where('FCBD_ID',$id);
		// 	$query = $this->db->get();
		// 	return $query->num_rows();
	// }
	
	function getrange() {
		$this->db->select()->from('finance_cheque_detail');
		$this->db->join('finance_cheque_book_details','finance_cheque_detail.FCBD_ID = finance_cheque_book_details.FCBD_ID');
		$where = '( finance_cheque_book_details.FCBD_STATUS = "Active" and finance_cheque_detail.FCD_STATUS="Available")order by CHEQUE_NO';
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	function putPaymentandContraCheque($todayDate,$countNo,$chequeDate,$favouring,$FCD_ID,$acFGLH_ID,$fcbdId) {
  		$sql ="UPDATE `finance_cheque_detail` SET FLT_DATE='$todayDate',VOUCHER_NO='$countNo',CHEQUE_DATE='$chequeDate',FAVOURING_NAME='$favouring',FCD_STATUS='Unreconciled' WHERE FCD_ID = $FCD_ID" ; 
  		$this->db->query($sql);

  		$sql1 ="SELECT COUNT(FCD_ID) as getCount FROM `finance_cheque_detail` JOIN finance_cheque_book_details ON finance_cheque_detail.FCBD_ID=finance_cheque_book_details.FCBD_ID WHERE FGLH_ID=$acFGLH_ID AND FCD_STATUS='Available' AND FCBD_STATUS='Active' AND finance_cheque_detail.FCBD_ID = $fcbdId";
		$query = $this->db->query($sql1);
		$AvailChequescount =  $query->row()->getCount;
		if($AvailChequescount==0){
			$sql2 ="SELECT FCBD_ID FROM `finance_cheque_book_details` WHERE FGLH_ID=$acFGLH_ID AND FCBD_STATUS='Available'";
			$query2 = $this->db->query($sql2);
			if($query2->num_rows()>0){
				$FRISTFCBD_ID =  $query2->row()->FCBD_ID;
			}else{$FRISTFCBD_ID ="";}
			$sql3 ="UPDATE `finance_cheque_book_details` SET FCBD_STATUS='Expired' WHERE FGLH_ID=$acFGLH_ID AND FCBD_STATUS='Active' AND FCBD_ID = $fcbdId" ; 
  			$this->db->query($sql3);
  			if($FRISTFCBD_ID){
  				$sql4 ="UPDATE `finance_cheque_book_details` SET FCBD_STATUS='Active' WHERE FCBD_ID=$FRISTFCBD_ID" ; 
  				$this->db->query($sql4);
  			}
		}
  	}

  	function get_all_payment_method_details(){
  		$sql ="SELECT * FROM `deity_receipt` JOIN deity_receipt_category ON deity_receipt.RECEIPT_CATEGORY_ID = deity_receipt_category.RECEIPT_CATEGORY_ID where STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') >= STR_TO_DATE('01-04-2021','%d-%m-%Y') and (RECEIPT_PAYMENT_METHOD='Direct Credit' OR RECEIPT_PAYMENT_METHOD='Credit / Debit Card') AND FGLH_ID = 0 AND PAYMENT_STATUS != 'Cancelled' ORDER BY STR_TO_DATE(`deity_receipt`.`RECEIPT_DATE`,'%d-%m-%Y') ASC";
  		$query= $this->db->query($sql);
		return $query->result();
  	}

  	function get_all_event_payment_method_details(){
  		$sql ="SELECT * FROM `event_receipt`  JOIN event_receipt_category ON event_receipt.ET_RECEIPT_CATEGORY_ID = event_receipt_category.ET_RECEIPT_CATEGORY_ID where STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') >= STR_TO_DATE('01-04-2021','%d-%m-%Y') and (ET_RECEIPT_PAYMENT_METHOD='Direct Credit' OR ET_RECEIPT_PAYMENT_METHOD='Credit / Debit Card') AND FGLH_ID = 0 AND PAYMENT_STATUS != 'Cancelled' ORDER BY STR_TO_DATE(`event_receipt`.`ET_RECEIPT_DATE`,'%d-%m-%Y')  ASC";
  		$query= $this->db->query($sql);
		return $query->result();
  	}

  	function get_banks() {
		//bank 															//laz
		$this->db->from('finacial_group_ledger_heads');
		$this->db->where('FGLH_PARENT_ID',9);
		$query = $this->db->get();									   //laz..
		return $query->result();
	}

	function update_all_payment_method_bank_details($RECEIPT_ID,$tobank){
		$sql ="UPDATE `deity_receipt` SET FGLH_ID = '$tobank'  WHERE RECEIPT_ID = $RECEIPT_ID" ; 
  		$this->db->query($sql);
	}

	function update_all_event_payment_method_bank_details($RECEIPT_ID,$tobank){
		$sql ="UPDATE `event_receipt` SET FGLH_ID = '$tobank'  WHERE ET_RECEIPT_ID = $RECEIPT_ID" ; 
  		$this->db->query($sql);
	}

	function count_rows_bank_details() {
		$sql="SELECT * FROM `deity_receipt` where STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') >= STR_TO_DATE('01-04-2021','%d-%m-%Y') and (RECEIPT_PAYMENT_METHOD='Direct Credit' OR RECEIPT_PAYMENT_METHOD='Credit / Debit Card') AND FGLH_ID = 0 AND PAYMENT_STATUS != 'Cancelled' ORDER BY `deity_receipt`.`RECEIPT_DATE` ASC";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getAccountOpBal($condition ="",$compId,$fromDate = "") {	//TS
		$sql = "SELECT TBL1.FGLH_ID,TBL1.FGLH_NAME,TBL2.BALANCE,TBL2.COMP_ID, TBL1.TYPE_ID, TBL1.FGLH_PARENT_ID,TBL1.BANK_NAME,TBL1.BANK_BRANCH 
		FROM (SELECT `FGLH_NAME`, `finacial_group_ledger_heads`.`FGLH_ID`, `TYPE_ID`, `FGLH_PARENT_ID`, `finacial_group_ledger_heads`.`BANK_NAME`, `finacial_group_ledger_heads`.`BANK_BRANCH`
		 FROM finacial_group_ledger_heads 
		 WHERE `finacial_group_ledger_heads`.`COMP_ID` LIKE '%$compId%' AND 
		 `LEVELS` = 'LG' AND (`FGLH_PARENT_ID` = 8 OR `FGLH_PARENT_ID` = 9) $condition 
		 GROUP BY finacial_group_ledger_heads.FGLH_ID) as tbl1 
		 left join (SELECT financial_ledger_transcations.FGLH_ID, SUM(FLT_DR-FLT_CR) 
		 AS BALANCE,financial_ledger_transcations.COMP_ID FROM financial_ledger_transcations 
		 WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled'
		  and  `financial_ledger_transcations`.`COMP_ID` LIKE '%$compId%' 
		  AND STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') < STR_TO_DATE('".$fromDate."','%d-%m-%Y') 
		  GROUP BY financial_ledger_transcations.FGLH_ID) as tbl2 on tbl1.FGLH_ID = tbl2.FGLH_ID";
		// echo "$sql";
		  $query = $this->db->query($sql);	
		return $query->result();
	}

	function getAccountClosingBal($condition ="",$compId,$Date = "") {	//TS
		$sql = "SELECT TBL1.FGLH_ID,TBL1.FGLH_NAME,TBL2.BALANCE,TBL2.COMP_ID, TBL1.TYPE_ID, TBL1.FGLH_PARENT_ID,TBL1.BANK_NAME,TBL1.BANK_BRANCH 
		FROM (SELECT `FGLH_NAME`, `finacial_group_ledger_heads`.`FGLH_ID`, `TYPE_ID`, `FGLH_PARENT_ID`, 
		     `finacial_group_ledger_heads`.`BANK_NAME`, `finacial_group_ledger_heads`.`BANK_BRANCH` 
			 FROM finacial_group_ledger_heads 
			 WHERE `finacial_group_ledger_heads`.`COMP_ID` 
			 LIKE '%$compId%' AND `LEVELS` = 'LG' 
			 AND (`FGLH_PARENT_ID` = 8 OR `FGLH_PARENT_ID` = 9) $condition 
			 GROUP BY finacial_group_ledger_heads.FGLH_ID) as tbl1 
			 left join (SELECT financial_ledger_transcations.FGLH_ID, 
			 SUM(FLT_DR-FLT_CR) AS BALANCE,financial_ledger_transcations.COMP_ID 
			 FROM financial_ledger_transcations 
			 WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
			 and TRANSACTION_STATUS != 'Cancelled' 
			 and  `financial_ledger_transcations`.`COMP_ID` LIKE '%$compId%' 
			 AND STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') <= STR_TO_DATE('".$Date."','%d-%m-%Y') 
			 GROUP BY financial_ledger_transcations.FGLH_ID) as tbl2 on tbl1.FGLH_ID = tbl2.FGLH_ID";
		$query = $this->db->query($sql);	
		return $query->result();
	}
	
	function get_dayBook_details($fromDate = "", $toDate = "", $num=10,$start,$compId,$voucherType='',$paymentType=""){
		if ($voucherType != '') {
			$condition = "AND RP_TYPE = '$voucherType'";
		}else{
			$condition = "";
		}
		if ($paymentType != '' && $voucherType =='P1' ) {
			$condition1 = "AND VOUCHER_NO like '%$paymentType%'";
		}else{
			$condition1 = "";
		}
 		if($fromDate != "" && $toDate != "") {
			$sql ="SELECT VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, (CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P1' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' WHEN `RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,TRANSACTION_STATUS,RECEIPT_ID FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and  STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE!='OP' $condition $condition1 GROUP BY VOUCHER_NO  ORDER BY FLT_ID DESC,STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') DESC LIMIT $start, $num";
		}else{
			$sql="SELECT VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, (CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P1' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' WHEN `RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,TRANSACTION_STATUS,RECEIPT_ID FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and  STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE!='OP'  $condition $condition1  GROUP BY VOUCHER_NO  ORDER BY FLT_ID DESC,STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') DESC LIMIT $start, $num";
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
			$condition = "AND RP_TYPE = '$voucherType'";
		}else{
			$condition = "";
		}

		if ($paymentType != ''  && $voucherType =='P1') {
			$condition1 = "AND VOUCHER_NO like '%$paymentType%'";
		}else{
			$condition1 = "";
		}

		if($fromDate != "" && $toDate != "") {
		$sql ="SELECT COUNT(*) AS COUNNT_DAY_BOOK FROM(SELECT VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, (CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P1' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' WHEN `RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and  STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE!='OP' $condition $condition1 GROUP BY VOUCHER_NO  ORDER BY STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') DESC) as bookcount";
		}else{
		$sql ="SELECT COUNT(*) AS COUNNT_DAY_BOOK FROM(SELECT VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, (CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P1' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' WHEN `RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and  STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE!='OP' $condition $condition1  GROUP BY VOUCHER_NO  ORDER BY STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') DESC) as bookcount";
		}
		$query = $this->db->query($sql);
		return $query->row()->COUNNT_DAY_BOOK;
	}

	function get_day_Book_details($VOUCHER_NO,$FLT_DATE = "") {
		// $sql="SELECT VOUCHER_NO,FLT_DATE,
		//       finacial_group_ledger_heads.FGLH_NAME,
		//       (CASE WHEN SUBSTR(RP_TYPE,2,1) = 1 THEN 'From:' WHEN SUBSTR(RP_TYPE,2,1) = 2 THEN 'To:' END ) AS Account,financial_ledger_transcations.RP_TYPE,(CASE WHEN SUBSTR(`RP_TYPE`,1,1) = 'R' THEN 'Receipt' WHEN SUBSTR(`RP_TYPE`,1,1) = 'P' THEN 'Payment' WHEN SUBSTR(`RP_TYPE`,1,1) = 'C' THEN 'Contra' WHEN SUBSTR(`RP_TYPE`,1,1) = 'J' THEN 'Journal' ELSE 'Unknown' END ) as VOUCHER_TYPE,FLT_NARRATION,FLT_DR,FLT_CR FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y')) AND RP_TYPE!='Op' AND VOUCHER_NO ='$VOUCHER_NO'";
		$sql="SELECT VOUCHER_NO,FLT_DATE,
		      finacial_group_ledger_heads.FGLH_NAME,PAYMENT_METHOD,RECEIPT_FAVOURING_NAME,financial_ledger_transcations.BANK_NAME,
		      (CASE WHEN RP_TYPE ='P2' THEN 'From:' WHEN RP_TYPE ='P1' THEN 'To:' WHEN SUBSTR(RP_TYPE,2,1) = 1 THEN 'From:' WHEN SUBSTR(RP_TYPE,2,1) = 2 THEN 'To:' END ) AS Account,financial_ledger_transcations.RP_TYPE,(CASE WHEN SUBSTR(`RP_TYPE`,1,1) = 'R' THEN 'Receipt' WHEN SUBSTR(`RP_TYPE`,1,1) = 'P' THEN 'Payment' WHEN SUBSTR(`RP_TYPE`,1,1) = 'C' THEN 'Contra' WHEN SUBSTR(`RP_TYPE`,1,1) = 'J' THEN 'Journal' ELSE 'Unknown' END ) as VOUCHER_TYPE,FLT_NARRATION,FLT_DR,FLT_CR,RECEIPT_ID,RP_TYPE,financial_ledger_transcations.FGLH_ID ,TRANSACTION_STATUS FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y')) AND RP_TYPE!='Op' AND VOUCHER_NO ='$VOUCHER_NO'";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function get_day_Book_details_narration($VOUCHER_NO,$FLT_DATE = "") {
		$sql="SELECT VOUCHER_NO,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,(CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P2' THEN 'Payment' WHEN `RP_TYPE`='1' THEN 'Journal' ELSE 'notfound' END )as VOUCHER_TYPE,FLT_NARRATION FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y'))AND RP_TYPE!='Op' AND VOUCHER_NO ='$VOUCHER_NO'";
		$query= $this->db->query($sql);
		return $query->row()->FLT_NARRATION;
	}

	function get_day_Book_details_chequeno($VOUCHER_NO,$FLT_DATE = "") {
		$sql="SELECT VOUCHER_NO,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,CHEQUE_NO,(CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P2' THEN 'Payment' WHEN `RP_TYPE`='1' THEN 'Journal' ELSE 'notfound' END )as VOUCHER_TYPE,FLT_NARRATION FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y'))AND RP_TYPE!='Op' AND VOUCHER_NO ='$VOUCHER_NO'";
		$query= $this->db->query($sql);
		return $query->row()->CHEQUE_NO;
	}

	function get_day_Book_details_chequedate($VOUCHER_NO,$FLT_DATE = "") {
		$sql="SELECT VOUCHER_NO,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,CHEQUE_NO,CHEQUE_DATE,(CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P2' THEN 'Payment' WHEN `RP_TYPE`='1' THEN 'Journal' ELSE 'notfound' END )as VOUCHER_TYPE,FLT_NARRATION FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y'))AND RP_TYPE!='Op' AND VOUCHER_NO ='$VOUCHER_NO'";
		$query= $this->db->query($sql);
		return $query->row()->CHEQUE_DATE;
	}

	function get_day_Book_details_vouchertype($VOUCHER_NO,$FLT_DATE = "") {
		$sql="SELECT VOUCHER_NO,FLT_DATE,(CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P1' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' WHEN `RP_TYPE`='J1' THEN 'Journal' ELSE 'notfound' END )as VOUCHER_TYPE,FLT_NARRATION FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$FLT_DATE."','%d-%m-%Y')) AND RP_TYPE!='Op' AND VOUCHER_NO ='$VOUCHER_NO'";
		$query= $this->db->query($sql);
		return $query->row()->VOUCHER_TYPE;
	}

	function get_dayBook_details_excel($fromDate = "", $toDate = "", $num=10,$start, $compId,$voucherType="",$paymentType=""){	//TS R
		if ($voucherType != '') {
			$condition = "AND RP_TYPE = '$voucherType'";
		}else{
			$condition = "";
		}

		if ($paymentType != ''  && $voucherType =='P1') {
			$condition1 = "AND VOUCHER_NO like '%$paymentType%'";
		}else{
			$condition1 = "";
		}
		if($fromDate != "" && $toDate != "") {
		$sql ="SELECT VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, (CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P1' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' WHEN `RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,TRANSACTION_STATUS FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')) AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE != 'OP' GROUP BY VOUCHER_NO ";
		}else {
			$sql ="SELECT VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, (CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P1' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' WHEN `RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,TRANSACTION_STATUS FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and ( STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y'))  AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE != 'OP'GROUP BY VOUCHER_NO  ";
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
			$condition = "AND RP_TYPE = '$voucherType'";
		}else{
			$condition = "";
		}

		if ($paymentType != ''  && $voucherType =='P1') {
			$condition1 = "AND VOUCHER_NO like '%$paymentType%'";
		}else{
			$condition1 = "";
		}

		$sql ="SELECT VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, (CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P1' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' WHEN `RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,TRANSACTION_STATUS FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and (STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y')) AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE!='OP' $condition $condition1 GROUP BY VOUCHER_NO";		
			$query = $this->db->query($sql);
			return $query->result('array');
	}
	
	function get_dayBook_report1($date,  $compId,$voucherType="",$paymentType=""){		//TS R
			if ($voucherType != '') {
				$condition = "AND RP_TYPE = '$voucherType'";
			}else{
				$condition = "";
			}

			if ($paymentType != ''  && $voucherType =='P1') {
				$condition1 = "AND VOUCHER_NO like '%$paymentType%'";
			}else{
				$condition1 = "";
			}
		 	$sql ="SELECT VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, (CASE WHEN `RP_TYPE`='R1' THEN 'Receipt' WHEN `RP_TYPE`='P1' THEN 'Payment' WHEN `RP_TYPE`='C1' THEN 'Contra' WHEN `RP_TYPE`='J1' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,TRANSACTION_STATUS FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and  FLT_DATE = '$date' AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE!='OP' $condition $condition1 GROUP BY VOUCHER_NO";
			$query = $this->db->query($sql);
			return $query->result('array');
	}

	/*function getCashReceipts(){
		 	$sql ="SELECT financial_ledger_transcations.FGLH_ID,finacial_group_ledger_heads.FGLH_NAME,SUM(FLT_CR) as AMOUNT from financial_ledger_transcations JOIN finacial_group_ledger_heads on financial_ledger_transcations.FGLH_ID=finacial_group_ledger_heads.FGLH_ID WHERE RP_TYPE='R1' and financial_ledger_transcations.PAYMENT_METHOD ='Cash' AND CASH_DEPOSITED_STATUS='' group BY FGLH_ID";
			$query = $this->db->query($sql);
			return $query->result();
	}*/

	function getCashReceipts(){	//TS
	 	$sql ="SELECT FGLH_ID,FGLH_NAME,AMOUNT,BankLedgerId 
		        FROM
			   (SELECT financial_ledger_transcations.FGLH_ID,finacial_group_ledger_heads.FGLH_NAME,SUM(FLT_CR) 
			    as AMOUNT 
				from financial_ledger_transcations 
				INNER JOIN finacial_group_ledger_heads 
				on financial_ledger_transcations.FGLH_ID =  finacial_group_ledger_heads.FGLH_ID
				WHERE RP_TYPE='R1' 
				and financial_ledger_transcations.PAYMENT_METHOD ='Cash' 
				AND CASH_DEPOSITED_STATUS='' 
				and TRANSACTION_STATUS != 'Cancelled'
				group BY FGLH_ID) as CashTrans 
				LEFT JOIN 
				(SELECT bank_ledger_allocation.LEDGER_FGLH_ID, GROUP_CONCAT(bank_ledger_allocation.BANK_FGLH_ID) 
				AS BankLedgerId 
				FROM finacial_group_ledger_heads 
				LEFT JOIN bank_ledger_allocation 
				ON bank_ledger_allocation.LEDGER_FGLH_ID = finacial_group_ledger_heads.FGLH_ID 
				GROUP BY FGLH_ID) as ReceiptLedgersBank
				ON CashTrans.FGLH_ID = ReceiptLedgersBank.LEDGER_FGLH_ID";
	// echo"$sql";
	$query = $this->db->query($sql);
		return $query->result();
	}

	function getIndividualCashReceipts(){	//TS
	 	$sql ="SELECT FGLH_ID,FGLH_NAME,AMOUNT,BankLedgerId,FLT_DATE,FLT_ID 
		       FROM
			   (SELECT financial_ledger_transcations.FGLH_ID,finacial_group_ledger_heads.FGLH_NAME,
   				FLT_CR as AMOUNT ,
				FLT_DATE,FLT_ID 
				from financial_ledger_transcations 
				INNER JOIN finacial_group_ledger_heads 
				on financial_ledger_transcations.FGLH_ID =  finacial_group_ledger_heads.FGLH_ID
				WHERE RP_TYPE='R1' 
				and financial_ledger_transcations.PAYMENT_METHOD ='Cash' 
				 AND CASH_DEPOSITED_STATUS='' 
				  and TRANSACTION_STATUS != 'Cancelled') 
				  as CashTrans 
				INNER JOIN 
				(SELECT bank_ledger_allocation.LEDGER_FGLH_ID, GROUP_CONCAT(bank_ledger_allocation.BANK_FGLH_ID) 
				AS BankLedgerId 
				FROM finacial_group_ledger_heads 
				INNER JOIN bank_ledger_allocation 
				ON bank_ledger_allocation.LEDGER_FGLH_ID = finacial_group_ledger_heads.FGLH_ID 
				GROUP BY FGLH_ID) as ReceiptLedgersBank
				ON CashTrans.FGLH_ID = ReceiptLedgersBank.LEDGER_FGLH_ID 
				ORDER BY  STR_TO_DATE(FLT_DATE, '%d-%m-%Y')";
				// echo $sql;
		$query = $this->db->query($sql);
		return $query->result();
	}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
	function putCashReceipt($fId,$todayDate) {
		$sql ="UPDATE financial_ledger_transcations SET CASH_DEPOSITED_STATUS = 'Done' , CASH_DEPOSITED_DATE='$todayDate' WHERE RP_TYPE='R1' and financial_ledger_transcations.PAYMENT_METHOD ='Cash' AND CASH_DEPOSITED_STATUS='' AND financial_ledger_transcations.FLT_ID=$fId" ; 
  			$this->db->query($sql);
	}

	function getAllocationHeads(){
		 	$sql ="SELECT TBL2.FGLH_NAME,TBL2.FGLH_ID FROM (SELECT FGLH_PARENT_ID FROM finacial_group_ledger_heads WHERE LEVELS='LG' ) AS TBL1, (SELECT FGLH_ID,FGLH_NAME FROM finacial_group_ledger_heads) AS TBL2 WHERE TBL2.FGLH_ID=TBL1.FGLH_PARENT_ID AND TBL1.FGLH_PARENT_ID!=8 AND TBL1.FGLH_PARENT_ID!=9 GROUP BY TBL2.FGLH_NAME";
			$query = $this->db->query($sql);
			return $query->result();
	}

	function getAllocationLedgers(){
		 	$sql ="SELECT FGLH_PARENT_ID,FGLH_ID,FGLH_NAME,COMP_ID FROM finacial_group_ledger_heads WHERE LEVELS='LG' AND FGLH_PARENT_ID!=8 AND FGLH_PARENT_ID!=9";
			$query = $this->db->query($sql);
			return $query->result();
	}

	function putAllocatedLedger($last_id,$ledgerFglhId) {
		$this->db->query("INSERT INTO `bank_ledger_allocation`(`BANK_FGLH_ID`,`LEDGER_FGLH_ID`) VALUES ($last_id,$ledgerFglhId)");
		return $this->db->insert_id();
	}

	function getPettyCashData($compId){	//TS
		$sql="SELECT TBL1.FGLH_ID, TBL1.FGLH_NAME, TBL1.AMOUNT, IF(GROUP_CONCAT(TBL2.LEDGER_FGLH_ID) IS NULL,'',GROUP_CONCAT(TBL2.LEDGER_FGLH_ID)) AS OTHER_LEDGER_ID,
			IF(GROUP_CONCAT(TBL2.FGLH_NAME) IS NULL,'',GROUP_CONCAT(TBL2.FGLH_NAME)) AS OTHER_LEDGER_NAME,TBL1.COMP_ID
			FROM (SELECT finacial_group_ledger_heads.FGLH_ID,finacial_group_ledger_heads.FGLH_NAME, SUM(FLT_DR)-SUM(FLT_CR) AS AMOUNT,finacial_group_ledger_heads.COMP_ID
			FROM `financial_ledger_transcations` 
			INNER JOIN finacial_group_ledger_heads ON finacial_group_ledger_heads.FGLH_ID = financial_ledger_transcations.PC_PAY_GROUP
			WHERE PC_PAY_GROUP != '' AND financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled'
			GROUP BY finacial_group_ledger_heads.FGLH_NAME) AS TBL1 LEFT JOIN 
			(SELECT bank_ledger_allocation.BANK_FGLH_ID, bank_ledger_allocation.LEDGER_FGLH_ID, finacial_group_ledger_heads.FGLH_NAME FROM bank_ledger_allocation INNER JOIN finacial_group_ledger_heads ON finacial_group_ledger_heads.FGLH_ID = bank_ledger_allocation.LEDGER_FGLH_ID) AS TBL2 
			ON TBL1.FGLH_ID = TBL2.BANK_FGLH_ID WHERE TBL1.COMP_ID LIKE '%$compId%'
			GROUP BY TBL1.FGLH_ID";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function incrementVoucherCounter($fvcId) {
		$this->db->select()->from('finance_voucher_counter')
		->where(array('finance_voucher_counter.FVC_ID'=>$fvcId));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->FVC_COUNTER+1;
		$this->db->where('finance_voucher_counter.FVC_ID',$fvcId);
		$this->db->update('finance_voucher_counter', array('FVC_COUNTER'=>$counter));
	}

	function getReceiptFormat($voucherCategoryNo) {
		$this->db->select()->from('finance_voucher_counter')
		->where(array('finance_voucher_counter.FVC_ID'=>$voucherCategoryNo));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->FVC_COUNTER+1;
		
		$dfMonth = $this->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$receiptFormat = $deityCounter->FVC_ABBR1 ."/".$datMonth."/".$deityCounter->FVC_ABBR2."/".$counter;
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

	// function putGroupLedgerHistory($last_id,$name,$userId,$operation,$levels,$date,$dateTime,$compId="",$oldBalance="") {
		// 	$this->db->query("INSERT INTO `finnancial_heads_history`(`FGLH_ID`,`FGLH_NAME`,`USER_ID`,`OPERATION`,`LEVELS`,`DATE`,`DATE_TIME`,`COMP_ID`,`OLD_OP_BAL`) VALUES ($last_id,'$name',$userId,'$operation','$levels','$date','$dateTime','$compId','$oldBalance')");
		// 	return $this->db->insert_id();
	// }

	function putGroupLedgerHistory($last_id,$name,$userId,$operation,$levels,$date,$dateTime,$oldLedgerParentId="") {
		$this->db->query("INSERT INTO `finnancial_heads_history`(`FGLH_ID`,`FGLH_NAME`,`USER_ID`,`OPERATION`,`LEVELS`,`DATE`,`DATE_TIME`,`OLD_FGLH_PARENT_ID`) VALUES ($last_id,'$name',$userId,'$operation','$levels','$date','$dateTime','$oldLedgerParentId')");
		return $this->db->insert_id();
	}

	function get_ledger_breakup_details($FGLH_ID,$num=10,$start=0,$from,$to,$compId){	//TS
		$sql ="SELECT * from(SELECT FLT_ID,VOUCHER_NO,
		                finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE,
						(CASE WHEN `RP_TYPE`='R1' 
						or `RP_TYPE`='R2' 
						THEN 'Receipt' 
						WHEN `RP_TYPE`='P1' 
						or `RP_TYPE`='P2' 
						THEN 'Payment' 
						WHEN `RP_TYPE`='C1' 
						or `RP_TYPE`='C2' 
						THEN 'Contra' 
						WHEN `RP_TYPE`='J1' or `RP_TYPE`='J2' THEN 'Journal' 
						 WHEN `RP_TYPE`='OP' THEN 'Openning Balance' ELSE 'Unknown' END )as
						 VOUCHER_TYPE FROM finacial_group_ledger_heads 
						 inner JOIN financial_ledger_transcations 
						 on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID 
						 where financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled'
						 
						  and TRANSACTION_STATUS != 'Cancelled' 
						  and  finacial_group_ledger_heads.FGLH_ID =$FGLH_ID and  
						  STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
						  BETWEEN STR_TO_DATE('$from', '%d-%m-%Y') AND STR_TO_DATE('$to', '%d-%m-%Y') 
						  AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' 
						  GROUP BY VOUCHER_NO ORDER BY financial_ledger_transcations.FLT_DATE) as TBL1,
			(SELECT FLT_ID,IF(RP_TYPE!='OP',FGLH_NAME,'') as Particular,VOUCHER_NO ,TYPE_ID 
			FROM finacial_group_ledger_heads 
			inner JOIN financial_ledger_transcations on
			 finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID ) 
			 AS TBL2 WHERE TBL1.VOUCHER_NO = TBL2.VOUCHER_NO AND TBL2.FLT_ID!= TBL1.FLT_ID 
			 group by TBL1.VOUCHER_NO order by  STR_TO_DATE(TBL1.FLT_DATE, '%d-%m-%Y') ";
		$query= $this->db->query($sql);
		return $query->result();
	}//EDITED THE order by clause to STR_TO_DATE(TBL1.FLT_DATE, '%d-%m-%Y')  which was order by TBL1.FLT_DATE before adithya

	function get_ledger_breakup_details_RP($FGLH_ID,$num=10,$start=0,$from,$to,$compId){	//TS
		$sql ="SELECT * from(SELECT FLT_ID,VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, (CASE WHEN `RP_TYPE`='R1' or `RP_TYPE`='R2' THEN 'Receipt' WHEN `RP_TYPE`='P1' or `RP_TYPE`='P2' THEN 'Payment' WHEN `RP_TYPE`='C1' or `RP_TYPE`='C2' THEN 'Contra' WHEN `RP_TYPE`='J1' or `RP_TYPE`='J2' THEN 'Journal'  WHEN `RP_TYPE`='OP' THEN 'Openning Balance' ELSE 'Unknown' END )as VOUCHER_TYPE FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID where financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' and  finacial_group_ledger_heads.FGLH_ID =25 and  STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$from', '%d-%m-%Y') AND STR_TO_DATE('$to', '%d-%m-%Y')AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' and RP_TYPE !='OP' GROUP BY VOUCHER_NO ORDER BY FLT_DATE) as TBL1,
			(SELECT FLT_ID,FGLH_NAME as Particular,VOUCHER_NO FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID ) AS TBL2 WHERE TBL1.VOUCHER_NO = TBL2.VOUCHER_NO AND TBL2.FLT_ID!= TBL1.FLT_ID group by TBL1.VOUCHER_NO order by TBL1.FLT_DATE LIMIT $start, $num";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function get_ledger_closing_details($FGLH_ID,$from,$firstFrom,$compId){		//TS
		$sql ="SELECT finacial_group_ledger_heads.FGLH_ID,sum(FLT_DR-FLT_CR) as amount 
		FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations 
		on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID 
		where financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		and TRANSACTION_STATUS != 'Cancelled' 
		and finacial_group_ledger_heads.FGLH_ID = $FGLH_ID 
		and  STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') >= STR_TO_DATE('$from', '%d-%m-%Y') 
		AND STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') < STR_TO_DATE('$firstFrom', '%d-%m-%Y') AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' ";
		$query= $this->db->query($sql);
		return $query->row()->amount;
	}

	function get_ledger_breakup_details_count($FGLH_ID,$from,$to,$compId){	//TS
		$sql ="SELECT * from(SELECT FLT_ID,VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, (CASE WHEN `RP_TYPE`='R1' or `RP_TYPE`='R2' THEN 'Receipt' WHEN `RP_TYPE`='P1' or `RP_TYPE`='P2' THEN 'Payment' WHEN `RP_TYPE`='C1' or `RP_TYPE`='C2' THEN 'Contra' WHEN `RP_TYPE`='J1' or `RP_TYPE`='J2' THEN 'Journal'  WHEN `RP_TYPE`='OP' THEN 'Openning Balance' ELSE 'Unknown' END )as VOUCHER_TYPE FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID where financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' and  finacial_group_ledger_heads.FGLH_ID =$FGLH_ID and  STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$from', '%d-%m-%Y') AND STR_TO_DATE('$to', '%d-%m-%Y') AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' GROUP BY VOUCHER_NO ORDER BY FLT_DATE) as TBL1,
			(SELECT FLT_ID,FGLH_NAME as Particular,VOUCHER_NO FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID ) AS TBL2 WHERE TBL1.VOUCHER_NO = TBL2.VOUCHER_NO AND TBL2.FLT_ID!= TBL1.FLT_ID group by TBL1.VOUCHER_NO order by TBL1.FLT_DATE ";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function get_legder_grid_breakup_details($FGLH_ID,$from,$to,$num=10,$start=0){	//TS
		$sql ="SELECT sum(tbl1.RECEIPT_PRICE) as AMOUNT,tbl1.SEVA_NAME,tbl1.SEVA_ID
		FROM (SELECT deity_receipt.Receipt_ID,RECEIPT_NO,RECEIPT_DATE,shashwath_seva.SS_ID,shashwath_seva.SEVA_ID,SEVA_NAME,RECEIPT_PRICE,EOD_CONFIRMED_DATE,FLT_DATE,financial_ledger_transcations.FGLH_ID FROM `deity_receipt`
		inner join shashwath_seva on deity_receipt.SS_ID = shashwath_seva.SS_ID
		INNER JOIN deity_seva ON deity_seva.SEVA_ID = shashwath_seva.SEVA_ID
		JOIN financial_ledger_transcations ON deity_receipt.RECEIPT_DATE = financial_ledger_transcations.FLT_DATE
		where deity_receipt.RECEIPT_CATEGORY_ID =7 and STR_TO_DATE(deity_receipt.RECEIPT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$from', '%d-%m-%Y') AND STR_TO_DATE('$to', '%d-%m-%Y') and deity_receipt.EOD_CONFIRMED_DATE !='' and TRANSACTION_STATUS != 'Cancelled' GROUP BY deity_receipt.Receipt_ID) as tbl1  GROUP BY tbl1.SEVA_ID";
		$query= $this->db->query($sql);
		return $query->result();
	}
	
	function get_ledger_breakup_details_grid_count($FGLH_ID,$from,$to){		//TS
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
		$this->db->select()->from('finance_committee');
		$query = $this->db->get();
		return $query->result();
	}

	function getAssignedCommittee($condition,$LEDGER_FGLH_ID) {
		$sql ="SELECT finance_committee.COMP_ID,
		       COMP_NAME, 
			   IF(TYPE_ID='A' OR TYPE_ID='E', FLT_DR, FLT_CR)   AS 
			   BALANCE,
			   FLT_ID FROM `finance_committee`  
			   JOIN financial_ledger_transcations 
			   on finance_committee.COMP_ID = financial_ledger_transcations.COMP_ID 
			   JOIN finacial_group_ledger_heads 
			   ON financial_ledger_transcations.FGLH_ID=finacial_group_ledger_heads.FGLH_ID 
			   where ($condition) 
			   AND (financial_ledger_transcations.FGLH_ID=$LEDGER_FGLH_ID AND RP_TYPE='OP')";
			
		$query= $this->db->query($sql);
		return $query->result();
	}

	function getAllCommittee() {
		$sql ="SELECT * FROM `finance_committee`";
		$query= $this->db->query($sql);
		return $query->result();
	}

	function putCommitteeDetails($committeename) {
		$this->db->query("INSERT INTO `finance_committee`(`COMP_NAME`) VALUES ('$committeename')");
		return $this->db->insert_id();
	}

	function discardLedger($name,$ledgerId,$lft,$rgt,$parentLevel) {
		$sql1 = "SELECT @myLeft  := ".$lft.", @myRight  := ".$rgt." , @myWidth := ".$rgt." -  ".$lft." + 1 FROM finacial_group_ledger_heads WHERE FGLH_ID = '$ledgerId'";

		$sql2 = "DELETE FROM finacial_group_ledger_heads WHERE ".$lft." BETWEEN @myLeft AND @myRight";

		$sql3 = "UPDATE finacial_group_ledger_heads SET ".$rgt."  = ".$rgt."  - @myWidth WHERE ".$rgt."  > @myRight";
		$sql4 =  "UPDATE finacial_group_ledger_heads SET ".$lft." = ".$lft." - @myWidth WHERE ".$lft." > @myRight";

		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);
		return $query1->result();
	}

	function discardGroup($underId,$name,$lft,$rgt,$groupId) {
		$sql1 = "SELECT @myLeft := ".$lft.", @myRight := ".$rgt.", @myWidth := ".$rgt." -  ".$lft." + 1 FROM finacial_group_ledger_heads WHERE FGLH_ID = '$groupId'";

		$sql2 = "DELETE FROM finacial_group_ledger_heads WHERE ".$lft." BETWEEN @myLeft AND @myRight";

		$sql3 = "UPDATE finacial_group_ledger_heads SET ".$rgt."  = ".$rgt." - @myWidth WHERE ".$rgt." > @myRight";
		$sql4 = "UPDATE finacial_group_ledger_heads SET ".$lft." = ".$lft." - @myWidth WHERE ".$lft." > @myRight";

		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);
		return $query1->result();
	}

	function putTransferLedger($transferLedgerId,$transferLedgerparentId,$lft,$rgt,$parentLevel,$lftParent,$rgtParent,$checkType,$checkTypeParent) {
		$sql1 = "SELECT @myLeft  := $lft , @myRight := $rgt, @myWidth := $rgt - $lft + 1  FROM finacial_group_ledger_heads WHERE FGLH_ID = $transferLedgerId";
		$sql2 = "UPDATE finacial_group_ledger_heads SET $rgt = $rgt - @myWidth WHERE $rgt > @myRight";
		$sql3 = "UPDATE finacial_group_ledger_heads SET $lft = $lft - @myWidth WHERE $lft > @myRight";
		$sql4 = "UPDATE finacial_group_ledger_heads SET $lft = 0 ,$rgt = 0 WHERE FGLH_ID = $transferLedgerId";
		if($checkType != $checkTypeParent){
			$sql5 ="SELECT @DR:=FLT_DR,@CR:=FLT_CR FROM `financial_ledger_transcations` WHERE FGLH_ID= $transferLedgerId and RP_TYPE ='OP'";
			$sql6 ="UPDATE `financial_ledger_transcations` SET FLT_DR=@CR,FLT_CR=@DR  WHERE FGLH_ID= $transferLedgerId and RP_TYPE ='OP'";
		}

		$sql7 = "SELECT @myLeft := $lftParent, @pId :=FGLH_ID, @type_id :=TYPE_ID,@acronym :=PRIMARY_PARENT_CODE,@subAcronym :=LEDGER_PRIMARY_PARENT_CODE FROM finacial_group_ledger_heads WHERE FGLH_ID = $transferLedgerparentId ";
		$sql8 = "UPDATE finacial_group_ledger_heads SET  $rgtParent=  $rgtParent + 2 WHERE  $rgtParent > @myLeft";
		$sql9 = "UPDATE finacial_group_ledger_heads SET  $lftParent =  $lftParent + 2 WHERE  $lftParent > @myLeft";

		if($parentLevel == 'PG'){
			$sql10 = "UPDATE  finacial_group_ledger_heads SET  $lftParent = @myLeft + 1, $rgtParent = @myLeft + 2, FGLH_PARENT_ID=@pId ,TYPE_ID=@type_id,LEDGER_PRIMARY_PARENT_CODE = @acronym  WHERE  FGLH_ID= $transferLedgerId";
		}else{
			$sql10 = "UPDATE  finacial_group_ledger_heads SET  $lftParent = @myLeft + 1, $rgtParent = @myLeft + 2, FGLH_PARENT_ID=@pId ,TYPE_ID=@type_id,LEDGER_PRIMARY_PARENT_CODE = @subAcronym WHERE  FGLH_ID= $transferLedgerId";
		}

		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);	
		$query3 = $this->db->query($sql3);
		$query4 = $this->db->query($sql4);
		if($checkType != $checkTypeParent){
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
		$sql1="INSERT INTO finance_cheque_detail(FCBD_ID,CHEQUE_NO,FCD_STATUS,IS_MULTI_PAYMENT) VALUES($fcbid,$chequeno,'Available',1)";	
		$query1 = $this->db->query($sql1);

		$sql2 ="SELECT FCBD_ID FROM `finance_cheque_detail` WHERE FCD_STATUS='Available' and FCBD_ID= $fcbid ";
		$query2 = $this->db->query($sql2);
			if($query2->num_rows()>0){
					$sql3 ="UPDATE `finance_cheque_book_details` SET FCBD_STATUS='Active' where FCBD_ID= $fcbid " ; 
	  				$this->db->query($sql3);
				}
	}	

	function deletemultiPaymentCheque($fcdidno) {
		$sql1="DELETE From finance_cheque_detail where FCD_ID= $fcdidno";	
		$query1 = $this->db->query($sql1);
	}

	function putTransferGroup($transferGroupId,$transferGroupParentId,$lft,$rgt,$parentLevel,$lftParent,$rgtParent,$checkType,$checkTypeParent) {
		$sql1 = "SELECT @myLeft  := $lft , @myRight := $rgt, @myWidth := $rgt - $lft + 1  FROM finacial_group_ledger_heads WHERE FGLH_ID = $transferGroupId";
		$sql2 = "UPDATE finacial_group_ledger_heads SET $rgt = $rgt - @myWidth WHERE $rgt > @myRight";
		$sql3 = "UPDATE finacial_group_ledger_heads SET $lft = $lft - @myWidth WHERE $lft > @myRight";
		$sql4 = "UPDATE finacial_group_ledger_heads SET $lft = 0 ,$rgt = 0 WHERE FGLH_ID = $transferGroupId";
		
		$sql7 = "SELECT @myParentLeft := $lftParent, @pId :=FGLH_ID, @type_id :=TYPE_ID,@acronym :=PRIMARY_PARENT_CODE,@subAcronym :=LEDGER_PRIMARY_PARENT_CODE,  @myParentWidth := $rgtParent - $lftParent + 1 FROM finacial_group_ledger_heads WHERE FGLH_ID = $transferGroupParentId ";
		$sql8 = "UPDATE finacial_group_ledger_heads SET  $rgtParent=  $rgtParent +  @myWidth WHERE  $rgtParent > @myParentLeft";
		$sql9 = "UPDATE finacial_group_ledger_heads SET  $lftParent =  $lftParent +  @myWidth WHERE  $lftParent > @myParentLeft";

		if($parentLevel == 'PG'){
			$sql10 = "UPDATE  finacial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, FGLH_PARENT_ID=@pId ,TYPE_ID=@type_id,LEDGER_PRIMARY_PARENT_CODE = @acronym ,PRIMARY_PARENT_CODE = '',LEVELS='SG' WHERE  FGLH_ID= $transferGroupId";
		} else if($parentLevel == 'MG'){
			$sql10 = "UPDATE  finacial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, FGLH_PARENT_ID=@pId ,TYPE_ID=@type_id,PRIMARY_PARENT_CODE = $transferGroupId,LEDGER_PRIMARY_PARENT_CODE = '',LEVELS='PG' WHERE  FGLH_ID= $transferGroupId";
		} else{
			$sql10 = "UPDATE  finacial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, FGLH_PARENT_ID=@pId ,TYPE_ID=@type_id,LEDGER_PRIMARY_PARENT_CODE = @subAcronym,PRIMARY_PARENT_CODE = '',LEVELS='SG' WHERE  FGLH_ID= $transferGroupId";
		}

		$query1 = $this->db->query($sql1);
		$sql11 = "SELECT FGLH_ID,FGLH_PARENT_ID,LEVELS FROM finacial_group_ledger_heads WHERE $lft > @myLeft AND $lft < @myRight";
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
			$fglhId = $row->FGLH_ID;
			$parentId = $row->FGLH_PARENT_ID;
			$levels = $row->LEVELS;
			$sqlRow1 = "SELECT @myWidth := $rgt - $lft + 1  FROM finacial_group_ledger_heads WHERE FGLH_ID = $fglhId";
			$sqlRow2 = "UPDATE finacial_group_ledger_heads SET $lft = 0 ,$rgt = 0 WHERE FGLH_ID = $fglhId";
			$sqlRow3 = "SELECT @myParentLeft := $lftParent,@myParentRgt := $rgtParent, @pId :=FGLH_ID, @type_id :=TYPE_ID,@acronym :=PRIMARY_PARENT_CODE,@subAcronym :=LEDGER_PRIMARY_PARENT_CODE FROM finacial_group_ledger_heads WHERE FGLH_ID = $parentId";

			$sqlRow8 = "UPDATE finacial_group_ledger_heads SET  $rgtParent =  $rgtParent +  @myWidth WHERE  $rgtParent > @myParentLeft AND 
					$rgtParent < @myParentRgt";
			$sqlRow9 = "UPDATE finacial_group_ledger_heads SET  $lftParent =  $lftParent +  @myWidth WHERE  $lftParent > @myParentLeft AND 
					$lftParent < @myParentRgt";

			$parentLevelRow =  $this->obj_finance->getParentLevel($parentId);
			if($parentLevelRow == 'PG'){
				$sqlRow4 = "UPDATE  finacial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, FGLH_PARENT_ID=@pId ,TYPE_ID=@type_id,LEDGER_PRIMARY_PARENT_CODE = @acronym ,PRIMARY_PARENT_CODE = '',LEVELS='SG' WHERE  FGLH_ID= $fglhId";
			} else if($parentLevelRow == 'MG'){
				$sqlRow4 = "UPDATE  finacial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, FGLH_PARENT_ID=@pId ,TYPE_ID=@type_id,PRIMARY_PARENT_CODE = $fglhId,LEDGER_PRIMARY_PARENT_CODE = '',LEVELS='PG' WHERE  FGLH_ID= $fglhId";
			} else{
				$sqlRow4 = "UPDATE  finacial_group_ledger_heads SET  $lftParent = @myParentLeft + 1, $rgtParent = @myParentLeft + @myWidth, FGLH_PARENT_ID=@pId ,TYPE_ID=@type_id,LEDGER_PRIMARY_PARENT_CODE = @subAcronym,PRIMARY_PARENT_CODE = '',LEVELS='SG' WHERE  FGLH_ID= $fglhId";
			}
			$queryRow1 = $this->db->query($sqlRow1);
			$queryRow2 = $this->db->query($sqlRow2);
			$queryRow3 = $this->db->query($sqlRow3);
			$queryRow8 = $this->db->query($sqlRow8);
			$queryRow9 = $this->db->query($sqlRow9);
			$queryRow4 = $this->db->query($sqlRow4);
			if($levels == 'LG') {
				$sqlRow5 = "UPDATE finacial_group_ledger_heads SET LEVELS='LG' WHERE  FGLH_ID= $fglhId";
				$queryRow5 = $this->db->query($sqlRow5);
				if($checkType != $checkTypeParent) {
					$sqlRow6 ="SELECT @DR:=FLT_DR,@CR:=FLT_CR FROM `financial_ledger_transcations` WHERE FGLH_ID= $fglhId and RP_TYPE ='OP'";
					$sqlRow7 ="UPDATE `financial_ledger_transcations` SET FLT_DR=@CR,FLT_CR=@DR  WHERE FGLH_ID= $fglhId and RP_TYPE ='OP'";
					$queryRow6 = $this->db->query($sqlRow6);
					$queryRow7 = $this->db->query($sqlRow7);
				}
			}
	
		}	
	}

	function fd_Exp_Count($startDate,$endDate){
		$sql ="SELECT FGLH_NAME,FD_MATURITY_START_DATE,FD_MATURITY_END_DATE,OP_BAL,FLT_DR,FLT_CR from finacial_group_ledger_heads INNER JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID  where STR_TO_DATE(FD_MATURITY_END_DATE, '%d-%m-%Y')  BETWEEN STR_TO_DATE('$startDate', '%d-%m-%Y')  AND  STR_TO_DATE('$endDate', '%d-%m-%Y')";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
// EDITED BY ADITHYA ON 14-2-24
	function fd_Exp_Current_Month($startDate,$endDate){
		$sql ="SELECT 
					  FGLH_NAME,
					  FD_MATURITY_START_DATE,
					  FD_MATURITY_END_DATE,
					  FD_INTEREST_RATE,
					  OP_BAL,
					  FLT_DR,
					  FLT_CR ,
					  FD_BANK_NAME,
					  FD_BANK_ID,
					  finacial_group_ledger_heads.FGLH_ID,
					  finacial_group_ledger_heads.IS_TERMINAL,
					  finacial_group_ledger_heads.FGLH_NAME,
		              finacial_group_ledger_heads.FGLH_PARENT_ID,
		              finacial_group_ledger_heads.IS_JOURNAL_STATUS,
					  finacial_group_ledger_heads.IS_FD_STATUS,
					  finacial_group_ledger_heads.FD_MATURITY_START_DATE,
					  finacial_group_ledger_heads.FD_MATURITY_END_DATE,
					  finacial_group_ledger_heads.FD_INTEREST_RATE,
					  FD_NUMBER
		       from finacial_group_ledger_heads 
			   INNER JOIN financial_ledger_transcations 
			   on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID  
			   where IS_FD_STATUS =1 AND STR_TO_DATE(FD_MATURITY_END_DATE, '%d-%m-%Y') 
			    BETWEEN STR_TO_DATE('$startDate', '%d-%m-%Y')  AND  STR_TO_DATE('$endDate', '%d-%m-%Y')";
		$query= $this->db->query($sql);
		return $query->result();
	}

	// ADDED BY ADITHYA START
	// function addFDDetails($fglh_id,$bank,$fd_bank_name,$fd_number,$fd_bank_id,$fd_interest_date,$fd_interest,$updatedById,$updatedByDate,$UpdatedDateTime){
	
	// 	$this->db->query("INSERT INTO `fd_details`(`FGLH_ID`, `FD_NUMBER`, `FD_BANK_ID`,`FD_INT_DATE`, `FD_INTEREST`, `UPDATEDBYID`, `UPDATEDBYDATETIME`, `UPDATEDBYDATE`) VALUES ('$fglh_id','$fd_number','$fd_bank_id','$fd_interest_date','$fd_interest','$updatedById','$UpdatedDateTime','$updatedByDate')");
	// }

	// function getFDDetails($fglh_id){
	// 	$sql ="SELECT finacial_group_ledger_heads.FGLH_NAME,
	// 				  fd_details.FD_NUMBER,
	// 				  fd_details.FD_INTEREST,
	// 				  financial_ledger_transcations.FLT_DR,
	// 				  financial_ledger_transcations.FLT_CR,
	// 				  fd_details.FD_INT_DATE 
	// 	FROM fd_details 
	// 	INNER JOIN finacial_group_ledger_heads ON finacial_group_ledger_heads.FGLH_ID = fd_details.FGLH_ID  
	// 	INNER JOIN financial_ledger_transcations on financial_ledger_transcations.FGLH_ID = fd_details.FGLH_ID 
	// 	WHERE fd_details.FGLH_ID =$fglh_id";
	// 	$query= $this->db->query($sql);
	// 	return $query->result();
	// }
	// ADDED BY ADITHYA END

	function fd_All_Exp($startDate,$endDate,$start, $num){
		$sql ="SELECT FGLH_NAME,FD_MATURITY_START_DATE,FD_MATURITY_END_DATE,FD_INTEREST_RATE,OP_BAL,FLT_DR,FLT_CR from finacial_group_ledger_heads  INNER JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID where IS_FD_STATUS =1 and STR_TO_DATE(FD_MATURITY_END_DATE, '%d-%m-%Y')  < STR_TO_DATE('$startDate', '%d-%m-%Y') LIMIT $start, $num"; 
		$query= $this->db->query($sql);
		return $query->result();
	}

	function fd_All_Exp_Count($startDate,$endDate){
		$sql ="SELECT FGLH_NAME,FD_MATURITY_START_DATE,FD_MATURITY_END_DATE,FD_INTEREST_RATE,OP_BAL,FLT_DR,FLT_CR from finacial_group_ledger_heads  INNER JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID where IS_FD_STATUS =1 and STR_TO_DATE(FD_MATURITY_END_DATE, '%d-%m-%Y')  < STR_TO_DATE('$startDate', '%d-%m-%Y') "; 
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getAllLedgerList() {
		$sql="SELECT * FROM(SELECT CONCAT( REPEAT( '&emsp;&emsp;&emsp;', (COUNT(parent.FGLH_NAME) - 1) ), node.FGLH_NAME) AS FGLH_NAME,node.FGLH_ID,node.LEVELS,node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE,node.FGLH_PARENT_ID,node.TYPE_ID
			FROM finacial_group_ledger_heads AS node,
			finacial_group_ledger_heads AS parent
			WHERE node.LF_A BETWEEN parent.LF_A AND parent.RG_A AND node.TYPE_ID = 'A'
			GROUP BY node.FGLH_NAME
			ORDER BY node.LF_A) ASSET
			UNION
			SELECT * FROM(SELECT CONCAT( REPEAT( '&emsp;&emsp;&emsp;', (COUNT(parent.FGLH_NAME) - 1) ), node.FGLH_NAME) AS FGLH_NAME,node.FGLH_ID,node.LEVELS,node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE,node.FGLH_PARENT_ID,node.TYPE_ID
			FROM finacial_group_ledger_heads AS node,
			finacial_group_ledger_heads AS parent
			WHERE node.LF_L BETWEEN parent.LF_L AND parent.RG_L AND node.TYPE_ID = 'L'
			GROUP BY node.FGLH_NAME
			ORDER BY node.LF_L) LIAB
			UNION
			SELECT * FROM(SELECT CONCAT( REPEAT( '&emsp;&emsp;&emsp;', (COUNT(parent.FGLH_NAME) - 1) ), node.FGLH_NAME) AS FGLH_NAME,node.FGLH_ID,node.LEVELS,node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE,node.FGLH_PARENT_ID,node.TYPE_ID
			FROM finacial_group_ledger_heads AS node,
			finacial_group_ledger_heads AS parent
			WHERE node.LF_I BETWEEN parent.LF_I AND parent.RG_I AND node.TYPE_ID = 'I'
			GROUP BY node.FGLH_NAME
			ORDER BY node.LF_I) INCOME
			UNION
			SELECT * FROM(SELECT CONCAT( REPEAT( '&emsp;&emsp;&emsp;', (COUNT(parent.FGLH_NAME) - 1) ), node.FGLH_NAME) AS FGLH_NAME,node.FGLH_ID,node.LEVELS,node.PRIMARY_PARENT_CODE,node.LEDGER_PRIMARY_PARENT_CODE,node.FGLH_PARENT_ID,node.TYPE_ID
			FROM finacial_group_ledger_heads AS node,
			finacial_group_ledger_heads AS parent
			WHERE node.LF_E BETWEEN parent.LF_E AND parent.RG_E AND node.TYPE_ID = 'E'
			GROUP BY node.FGLH_NAME
			ORDER BY node.LF_E) EXP
			";
		$query = $this->db->query($sql);	
		return $query->result();
	}

	function get_ledger_transactions($fromDate = "", $toDate = "", $compId,$num=10,$start,$FGLH_ID){	//TS
 		if($fromDate != "" && $toDate != "") {
			$sql ="SELECT VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE, 
			      (CASE WHEN `RP_TYPE` LIKE 'R%' 
				        THEN 'Receipt' WHEN `RP_TYPE` LIKE 'P%' 
						THEN 'Payment' WHEN `RP_TYPE` LIKE 'C%' 
						THEN 'Contra' WHEN `RP_TYPE` LIKE 'J%' 
						THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,
						TRANSACTION_STATUS FROM finacial_group_ledger_heads 
						inner JOIN financial_ledger_transcations 
						on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID 
						WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' 
						and  STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') 
						BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' 
						AND RP_TYPE!='OP' AND financial_ledger_transcations.FGLH_ID=$FGLH_ID GROUP BY VOUCHER_NO  ORDER BY FLT_ID DESC,STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') DESC LIMIT $start, $num";
		}else{
			$sql="SELECT VOUCHER_NO,finacial_group_ledger_heads.FGLH_ID,FLT_DATE,FGLH_NAME,FLT_DR,FLT_CR,RP_TYPE,(CASE WHEN `RP_TYPE` LIKE 'R%' THEN 'Receipt' WHEN `RP_TYPE` LIKE 'P%' THEN 'Payment' WHEN `RP_TYPE` LIKE 'C%' THEN 'Contra' WHEN `RP_TYPE` LIKE 'J%' THEN 'Journal' ELSE 'Unknown' END )as VOUCHER_TYPE,TRANSACTION_STATUS FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' and  STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE!='OP' AND financial_ledger_transcations.FGLH_ID=$FGLH_ID GROUP BY VOUCHER_NO  ORDER BY FLT_ID DESC,STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') DESC LIMIT $start, $num";
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
			$sql ="SELECT COUNT(*) AS COUNT_TRANSACTON  FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE  financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' and  STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND STR_TO_DATE('".$toDate."','%d-%m-%Y') AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE!='OP' AND financial_ledger_transcations.FGLH_ID=$FGLH_ID GROUP BY VOUCHER_NO";
		}else{
			$sql="SELECT COUNT(*) AS COUNT_TRANSACTON FROM finacial_group_ledger_heads inner JOIN financial_ledger_transcations on finacial_group_ledger_heads.FGLH_ID=financial_ledger_transcations.FGLH_ID WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' and TRANSACTION_STATUS != 'Cancelled' and  STR_TO_DATE(`FLT_DATE`,'%d-%m-%Y') = STR_TO_DATE('".$fromDate."','%d-%m-%Y') AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' AND RP_TYPE!='OP' AND financial_ledger_transcations.FGLH_ID=$FGLH_ID GROUP BY VOUCHER_NO";
		}
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getTypeId($fglhId){
		$sql = "SELECT TYPE_ID FROM finacial_group_ledger_heads WHERE FGLH_ID = $fglhId";
		
		$query= $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return 0;
		}
	}

	function getBankDetails(){
		$sql = "SELECT FGLH_ID,FGLH_NAME FROM finacial_group_ledger_heads WHERE FGLH_PARENT_ID = 9";
		$query = $this->db->query($sql);
		return $query->result();
		// echo "hiii";
	}

	function cancel_finance_transaction($VOUCHER_NO,$FLT_DATE,$chequeno,$voucherType){
		$sql ="UPDATE `financial_ledger_transcations` SET TRANSACTION_STATUS = 'Cancelled' WHERE VOUCHER_NO = '$VOUCHER_NO' AND FLT_DATE = '$FLT_DATE'" ; 
  		$this->db->query($sql);
  		if($chequeno != "" && ($voucherType=="Contra" || $voucherType=="Payment")){
			$sql1 ="SELECT FCBD_ID FROM `finance_cheque_detail` WHERE VOUCHER_NO = '$VOUCHER_NO' AND FLT_DATE='$FLT_DATE' AND CHEQUE_NO='$chequeno'";
			$query = $this->db->query($sql1);
			$FCBD_ID_VAL =  $query->row()->FCBD_ID;
			$sql2 ="UPDATE `finance_cheque_book_details` SET FCBD_STATUS='Active' WHERE FCBD_ID = $FCBD_ID_VAL" ; 
	  		$this->db->query($sql2);	
	  		$sqlCheque ="UPDATE `finance_cheque_detail` SET FLT_DATE='',VOUCHER_NO='',CHEQUE_DATE='',FAVOURING_NAME='',FCD_STATUS='Available' WHERE VOUCHER_NO = '$VOUCHER_NO' AND FLT_DATE = '$FLT_DATE' AND CHEQUE_NO='$chequeno'" ; 
	  		$this->db->query($sqlCheque);
  		}
		
	}

	function checkAndInsertToFinancial_Ledger($fromDate,$toDate,$Revision){
        $YEAR = explode('-',$toDate)[2];
		$OpYear = "01-04-".$YEAR;
		$currentDate = date("d-m");
		$dateTime = date('d-m-Y');
 //  QUERY TO COUNT THE NUMBER OF RECORDS IN PREVIOUS YEAR START
		$sql="SELECT FLT_ID,FGLH_NAME,
		financial_ledger_transcations.FGLH_ID,
		financial_ledger_transcations.COMP_ID,
		financial_ledger_transcations.VOUCHER_NO,
		financial_ledger_transcations.Flt_Date,
		finacial_group_ledger_heads.TYPE_ID,
		SUM(
        CASE 
            WHEN TYPE_ID = 'A' THEN FLT_DR - FLT_CR
            WHEN TYPE_ID = 'L' THEN FLT_CR - FLT_DR
            ELSE 0
        END
    ) AS AMOUNT
		FROM `financial_ledger_transcations` 
		INNER JOIN finacial_group_ledger_heads 
		ON financial_ledger_transcations.FGLH_ID=finacial_group_ledger_heads.FGLH_ID 
		WHERE 
		 financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
		and 
		TRANSACTION_STATUS != 'Cancelled' 
		and  
		(STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
		BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') 
		AND STR_TO_DATE('$toDate', '%d-%m-%Y')) 
		AND finacial_group_ledger_heads.LEVELS = 'LG'
		AND  (finacial_group_ledger_heads.TYPE_ID = 'A' OR finacial_group_ledger_heads.TYPE_ID = 'L')  
		AND financial_ledger_transcations.COMP_ID 
		LIKE '%%' GROUP BY finacial_group_ledger_heads.FGLH_NAME";
	   $query = $this->db->query($sql);
	   $result = $query->result();
	   $op = "OP";

	//    TO CHECK WHETHER RECORD HAS BEEN INSERTED ALREADY
	$RecordCheck = "SELECT * FROM financial_ledger_transcations WHERE RP_TYPE = 'OP' AND FLT_DATE = '$OpYear' ";
	$num = $this->db->query($RecordCheck);

		if($Revision == "True"){
		 try {
			     foreach ($result as $value) {
			     	if($value->TYPE_ID == 'A'){
					$updateSql = "UPDATE financial_ledger_transcations 
                                  SET FGLH_ID = {$value->FGLH_ID},
                                      FLT_DR = {$value->AMOUNT}, 
                                      FLT_CR = 0,
                                      COMP_ID = {$value->COMP_ID}
                                  WHERE RP_TYPE = '{$op}'
                                  AND FGLH_ID = {$value->FGLH_ID}
                                  AND FLT_DATE = '{$OpYear}'";
		            $query = $this->db->query($updateSql); 
				}
				else {
					$updateSql = "UPDATE financial_ledger_transcations 
                                  SET FGLH_ID = {$value->FGLH_ID},
                                      FLT_DR = 0, 
                                      FLT_CR = {$value->AMOUNT},
                                      COMP_ID = {$value->COMP_ID}
                                WHERE RP_TYPE = '{$op}'
                                AND FGLH_ID = {$value->FGLH_ID}
                                AND FLT_DATE = '{$OpYear}'";
                    $query = $this->db->query($updateSql);  
				}
            
			 }
		 } catch (\Throwable $th) {
				throw $th;
			}
		}
		else {
			try {
			 foreach ($result as $value) {
				if($num->num_rows() == 0){
                 
					if( $currentDate == "01-04"){

						if($value->TYPE_ID =='A'){
							$sql1 =  "INSERT INTO financial_ledger_transcations (FGLH_ID,FLT_DR,FLT_CR ,FLT_DATE,FLT_DATE_TIME,RP_TYPE,COMP_ID) 
														 VALUES ($value->FGLH_ID,$value->AMOUNT,0,'$dateTime','$dateTime','OP',$value->COMP_ID)";						
							$res =  $this->db->query($sql1);	
						}else{
							$sql1 =  "INSERT INTO financial_ledger_transcations (FGLH_ID,FLT_DR,FLT_CR ,FLT_DATE,FLT_DATE_TIME,RP_TYPE,COMP_ID) 
													 VALUES ($value->FGLH_ID,0,$value->AMOUNT,'$dateTime','$dateTime','OP',$value->COMP_ID)";						
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


// code for getting ledger Details start by adithya
function getLedgerDetails($fromRP_OP,$toRP_OP,$fromDate,$toDate,$fglh_id,$newCondition, $compId){
// ////////////////////////////////////////////////////////
$sqlOpeningBalance  = "";
$result2 = array();
if($fromRP_OP != "" && $toRP_OP != ""){
	$sqlOpeningBalance = "SELECT 'OP' AS RP_TYPE, 
	'Opening Balance' AS VOUCHER_TYPE, 
	0 AS FLT_ID, 0 AS VOUCHER_NO, 
	FGLH_NAME, 0 AS TYPE_ID,
	SUM(FLT_DR) as FLT_DR, SUM(FLT_CR) AS FLT_CR ,
	
	CASE WHEN SUM(FLT_DR) > SUM(FLT_CR)
		 THEN SUM(FLT_DR - FLT_CR)
		 WHEN SUM(FLT_CR) > SUM(FLT_DR)
		 THEN SUM(FLT_CR - FLT_DR)
		 ELSE 0
	END AS TOTAL
	FROM finacial_group_ledger_heads INNER JOIN financial_ledger_transcations ON finacial_group_ledger_heads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
	WHERE financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled' 
	AND TRANSACTION_STATUS != 'Cancelled' AND finacial_group_ledger_heads.FGLH_ID =$fglh_id 
	AND STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') 
	BETWEEN STR_TO_DATE('$fromRP_OP', '%d-%m-%Y') AND STR_TO_DATE('$toRP_OP', '%d-%m-%Y') 
	AND financial_ledger_transcations.COMP_ID LIKE '%$compId%'
	GROUP BY finacial_group_ledger_heads.FGLH_NAME";


$query2 = $this->db->query($sqlOpeningBalance);
$result2 = $query2->result();
}
/////////////////////////////////////////////////////////
	$sql = "SELECT 
    TBL1.*, 
    TBL2.Particular,
    TBL2.TYPE_ID
FROM (
    SELECT 
        FLT_ID,
        VOUCHER_NO,
        finacial_group_ledger_heads.FGLH_ID,
        FLT_DATE,
        FGLH_NAME,
        FLT_DR,
        FLT_CR,
        RP_TYPE,
		-- SUM(FLT_DR - FLT_CR) AS AMOUNT,

        (
            CASE 
                WHEN `RP_TYPE` IN ('R1', 'R2') THEN 'Receipt' 
                WHEN `RP_TYPE` IN ('P1', 'P2') THEN 'Payment' 
                WHEN `RP_TYPE` IN ('C1', 'C2') THEN 'Contra' 
                WHEN `RP_TYPE` IN ('J1', 'J2') THEN 'Journal' 
                WHEN `RP_TYPE` = 'OP' THEN 'Opening Balance' 
                ELSE 'Unknown' 
            END 
        ) AS VOUCHER_TYPE 
    FROM 
        finacial_group_ledger_heads 
        INNER JOIN financial_ledger_transcations 
        ON finacial_group_ledger_heads.FGLH_ID = financial_ledger_transcations.FGLH_ID 
    WHERE 
        financial_ledger_transcations.PAYMENT_STATUS != 'Cancelled'
        AND TRANSACTION_STATUS != 'Cancelled' 
        AND finacial_group_ledger_heads.FGLH_ID = $fglh_id
        AND STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y') BETWEEN STR_TO_DATE('$fromDate', '%d-%m-%Y') AND STR_TO_DATE('$toDate', '%d-%m-%Y') 
        AND financial_ledger_transcations.COMP_ID LIKE '%$compId%' 
		$newCondition
    ORDER BY 
        STR_TO_DATE(financial_ledger_transcations.FLT_DATE, '%d-%m-%Y')
) AS TBL1
INNER JOIN (
    SELECT 
        FLT_ID,
        IF(RP_TYPE != 'OP', FGLH_NAME, '') AS Particular,
        VOUCHER_NO,
		FGLH_NAME,
        TYPE_ID
    FROM 
        finacial_group_ledger_heads 
        INNER JOIN financial_ledger_transcations 
        ON finacial_group_ledger_heads.FGLH_ID = financial_ledger_transcations.FGLH_ID
) AS TBL2 ON TBL1.VOUCHER_NO = TBL2.VOUCHER_NO AND TBL1.FLT_ID != TBL2.FLT_ID
GROUP BY 
--    TBL1.FGLH_NAME
TBL1.VOUCHER_NO, TBL1.FLT_ID
ORDER BY 
    STR_TO_DATE(TBL1.FLT_DATE, '%d-%m-%Y')";
//    echo "$sql";
	$query = $this->db->query($sql);
	$result1 = $query->result();
    $mergedResult = array_merge($result1, $result2);
	return $mergedResult;

	// -- TBL1.VOUCHER_NO, TBL1.FLT_ID ADD THIS TO GROUP BY
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