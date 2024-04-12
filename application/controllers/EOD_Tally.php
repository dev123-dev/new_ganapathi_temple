<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EOD_Tally extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
			$this->load->helper('string');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->helper(array('form', 'url'));
			$this->load->helper('date');
			date_default_timezone_set('Asia/Kolkata');
			$this->load->model('Report_modal','obj_report',true);
			$this->load->model('EOD_modal','obj_eod',true);
		$this->load->model('Receipt_modal','obj_receipt',true);
			$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
			$this->load->model('Events_modal','obj_events',true);
			
		if(!isset($_SESSION['userId']))
			redirect('login');
		
		if($_SESSION['trustLogin'] == 1)
			redirect('Trust');
		
		// $this->output->enable_profiler(true);
		
		$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
	}
	
	public function index($start = 0) {
		$data['whichTab'] = "deityEOD";
		$data['radioOpt'] = "year";
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;

		$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1];
		
		//bank 															
		//$data['bank'] = $this->obj_receipt->get_banks();
		$data['bank'] = $this->obj_receipt->getAllbanks();
		
		$data['eod_tally'] = $this->obj_eod->get_all_field_pagination($fromDate, $toDate, 10, $start);
		
		$arr = array(
			"DUC_IS_DEPOSITED"=>"0"
		);
		
		
		$this->db->from("DEITY_USER_COLLECTION")->where($arr);
		$query = $this->db->get();
		$data['chequeDetails'] = $query->result();
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EOD_Tally/index';
		$config['total_rows'] = $data['total_rows'] = $this->obj_eod->count_get_all_field($fromDate, $toDate);
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		//$this->output->enable_profiler(true);

		if(isset($_SESSION['Deity_EOD'])) {
			$this->load->view('header',$data);
			$this->load->view('deityEod_tally');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	function checkPreviousPendingDate() {
		$toDate = $_POST['date'];
		$sql = "SELECT DUC_EOD_DATE as EODDate FROM `deity_user_collection` WHERE DUC_EOD_DATE < '".$toDate."' and DUC_IS_DEPOSITED != 1 ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) { 
			echo $query->num_rows();
		} else {
			echo "success";
		}
	}

		
	//CREATE EXCEL REPORT
	function eod_tally_report_excel() {
		//FROM DATE AND TO DATE
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDates'])) {
			$fromDates= @$_POST['fromDates'];
			$_SESSION['fromDates'] = $fromDates;
		} else {
			$fromDates = $_SESSION['fromDates'];
		}
		$data['fromDates'] = $fromDates;
		
		if(isset($_POST['toDates'])) {
			$toDates= @$_POST['toDates'];
			$_SESSION['toDates'] = $toDates;
		} else {
			$toDates = $_SESSION['toDates'];
		}
		$data['toDates'] = $toDates;
		
		if(isset($_POST['yCombo'])) {
			$yCombo= @$_POST['yCombo'];
			$_SESSION['yCombo'] = $yCombo;
		} else {
			$yCombo = $_SESSION['yCombo'];
		}
		$data['yCombo'] = $yCombo;
		
		if(isset($_POST['myCombo'])) {
			$myCombo= @$_POST['myCombo'];
			$_SESSION['myCombo'] = $myCombo;
		} else {
			$myCombo = $_SESSION['myCombo'];
		}
		$data['myCombo'] = $myCombo;
		
		if(isset($_POST['mmCombo'])) {
			$mmCombo= @$_POST['mmCombo'];
			$_SESSION['mmCombo'] = $mmCombo;
		} else {
			$mmCombo = $_SESSION['mmCombo'];
		}
		$data['mmCombo'] = $mmCombo;
		
		if($radioOpt == "year") {
			$yr = (explode(" - ",$yCombo));
			$fromDate = $yr[0].'-04-01';
			$toDate = ($yr[1]).'-03-31';
			$title = "(".$yCombo.")";
		} else if($radioOpt == "month") {
			$yr = $myCombo;
			$mnth = (sprintf("%02d", $mmCombo));
			$fromDate = $yr.'-'.$mnth.'-01';
			$toDate = $yr.'-'.$mnth.'-31';
			$dt = DateTime::createFromFormat('!m', $mmCombo);
			$title = "(".$myCombo." - ".$dt->format('F').")";
		} else if($radioOpt == "date") {
			$dOne = (explode("-",$fromDates));
			$dTwo = (explode("-",$toDates));
			$fromDate = $dOne[2].'-'.$dOne[1].'-'.$dOne[0];
			$toDate = $dTwo[2].'-'.$dTwo[1].'-'.$dTwo[0];
			$title = "(".$fromDates." To ".$toDates.")";
		}
		
		$header = "";
		$result = ""; 
		$filename = "EOD_Tally_Report ".$title;  //File Name
		$file_ending = "xls";
		//header info for browser
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$sep = "\t"; //tabbed character 
		
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= "SRI LAKSHMI VENKATESH TEMPLE" . "\n\n";	
		$header .= "SI NO." . "\t";
		$header .= "ENTRY DATE" . "\t";
		$header .= "OP. BAL." . "\t";
		$header .= "CASH" . "\t";
		$header .= "CHEQUE" . "\t";
		$header .= "CREDIT" . "\t";
		$header .= "DEBIT" . "\t";
		$header .= "BALANCE" . "\t";
		$header .= "BANK" . "\t";
		$header .= "DEPOSIT DATE" . "\t";
		$header .= "EOD DATE" . "\t";	
		
		//CREDIT TOTAL
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(DUC_CASH_CHEQUE) AS TCashCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CASH_CHEQUE) AS TCashCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$creditTotal = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(DUC_DEBIT_CREDIT_CARD) AS TCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_DEBIT_CREDIT_CARD) AS TCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$cCash = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(DUC_CHEQUE) AS TCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CHEQUE) AS TCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$cCheque = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(DUC_CASH_DEPOSIT) AS TDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CASH_DEPOSIT) AS TDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$dCash = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(DUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$dCheque = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(DUC_DEBIT) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_DEBIT) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$debitTotal = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(DUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(DUC_DEBIT),0) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(DUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(DUC_DEBIT),0) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$balance = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(DUC_DEBIT_CREDIT_CARD),0) AS BalCreditCash, COALESCE(SUM(DUC_CASH_DEPOSIT),0) AS BalDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(DUC_DEBIT_CREDIT_CARD),0) AS BalCreditCash, COALESCE(SUM(DUC_CASH_DEPOSIT),0) AS BalDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."'AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$balanceCash = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM( DUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(DUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM( DUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(DUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."'AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$balanceCheque = $query->first_row();
		
		//BANK
		$this->db->from('BANK');
		$query = $this->db->get();
		$bank = $query->result();
		
		$conditionOne = array('RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$res = $this->obj_eod->get_all_field($fromDate, $toDate);
		
		for($i = 0; $i < sizeof($res); $i++) {
			$line = '';    
			$value = "";			
			$value .= '"' . ($i+1) . '"' . "\t";
			$value .= '"' . date('d-m-Y',strtotime($res[$i]->DUC_DATE)) . '"' . "\t";
			$value .= '"' . $res[$i]->OpBal . '"' . "\t";
			
			if($res[$i]->DUC_DEBIT_CREDIT_CARD != NULL)
				$value .= '"'.$res[$i]->DUC_DEBIT_CREDIT_CARD .'"' . "\t";
			else
				$value .= '"'.$res[$i]->DUC_CASH_DEPOSIT .'"' . "\t";
			
			if($res[$i]->DUC_CHEQUE != NULL)
				$value .= '"' . $res[$i]->DUC_CHEQUE . '"' . "\t";
			else 
				$value .= '"' . $res[$i]->DUC_CHEQUE_DEPOSIT . '"' . "\t";
			
			if($res[$i]->DUC_CASH_CHEQUE != NULL)
				$value .= '"' . $res[$i]->DUC_CASH_CHEQUE . '"' . "\t";
			else 
				$value .= '" - "' . "\t";
			
			if($res[$i]->DUC_DEBIT != NULL)
				$value .= '"' . $res[$i]->DUC_DEBIT . '"' . "\t";
			else 
				$value .= '" - "' . "\t";
				
			$value .= '"' . $res[$i]->ClBal . '"' . "\t";
			
			if($res[$i]->BANK_NAME != NULL)
				$value .= '"' . $res[$i]->ACCOUNT_NO .", ". $res[$i]->BANK_NAME .", ". $res[$i]->BANK_BRANCH .'"' . "\t";
			else 
				$value .= '" - "' . "\t";
			
			if($res[$i]->DUC_DEBIT != NULL)
				$value .= '"' . $res[$i]->DUC_EOD_DATE . '"' . "\t";
			else 
				$value .= '" - "' . "\t";

			
			if($res[$i]->DUC_DEBIT == NULL)
				$value .= '"' . $res[$i]->DUC_EOD_DATE . '"' . "\t";
			else 
				$value .= '" - "' . "\t";
			
			$line .= $value;
			$result .= trim($line) . "\n";
		}
				
		$result .= "\n"; 
		$value1 = "";
		$value1 .= '"CREDIT "' . "\t";
		$value1 .= $creditTotal->total. "\t";
		$value1 .= '"CASH"'."\t";
		$value1 .= $cCash->cCashTotal. "\t";
		$value1 .= '"CHEQUE"'."\t";
		$value1 .= $cCheque->cChequeTotal. "\t";
		$result .= trim($value1) . "\n";
		
		$value2 = "";
		$value2 .= '"DEBIT "' . "\t";
		$value2 .= $debitTotal->total. "\t";
		$value2 .= '"CASH"'."\t";
		$value2 .= $dCash->dCashTotal. "\t";
		$value2 .= '"CHEQUE"'."\t";
		$value2 .= $dCheque->dChequeTotal. "\t";
		$result .= trim($value2) . "\n";
		
		$value3 = "";
		$value3 .= '"BALANCE "' . "\t";
		$value3 .= $balance->balance. "\t";
		$value3 .= '"CASH"'."\t";
		$value3 .= $balanceCash->bCash. "\t";
		$value3 .= '"CHEQUE"'."\t";
		$value3 .= $balanceCheque->bCheque. "\t";
		$result .= trim($value3) . "\n";
		
		$result = str_replace( "\r" , "" , $result );
		print("$header\n$result"); 
	}
	
	function deactivateCheque() {
		$DUC_ID = $_POST['DUC_ID'];
		$DUC_CHEQUE_ID = $_POST['DUC_CHEQUE_ID'];
		
		$data = array(
			'DUC_IS_DEPOSITED'=>"0"
		);
		
		$where = array(
			'DUC_ID'=>$DUC_CHEQUE_ID
		);
		$this->db->where($where);
		$this->db->update('DEITY_USER_COLLECTION', $data);
		
		
		$this->db->delete('DEITY_USER_COLLECTION', array('DUC_ID' => $DUC_ID));
		
	}
	
	function eodTallySave() {
		$updateId = @$_POST['updateId'];
		$cheque = $_POST['cheque'];
		$total = $_POST['total'];
		$bank = $_POST['bank'];
		$RECEIPT_ID = $_POST['RECEIPT_ID'];
		$dDate = $_POST['depositdate'];		
		$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1];

		$data = array(
			'DUC_BY_ID'=>@$_SESSION['userId'],
			'DUC_BY_NAME'=>@$_SESSION['userFullName'],
			'DUC_DATE_TIME'=>date('d-m-Y h:i:s A'),
			'DUC_DATE'=>date('Y-m-d'),
			'DUC_IS_DEPOSITED'=>1,
			'DUC_LEDGER_ID'=>$bank,
			'DUC_DEPOSIT_DATE'=>date('Y-m-d',strtotime($dDate)),
		);
		
		$where = array(
			'DUC_ID'=>$updateId
		);
		
		$this->db->where($where);
		$this->db->update('DEITY_USER_COLLECTION', $data);
		
		$DEITY_USER_COLLECTION_HISTORY = array(
			'DUC_ID'=>$updateId,
			'DUCH_BY_ID'=>@$_SESSION['userId'],
			'DUCH_BY_NAME'=>@$_SESSION['userFullName'],
			'DUCH_DATE_TIME'=>date('d-m-Y h:i:s A'),
			'DUCH_DATE'=>date('Y-m-d'),
		);
		$this->db->insert('DEITY_USER_COLLECTION_HISTORY',$DEITY_USER_COLLECTION_HISTORY);
		//**************************************************************************************************************************************************************
		$sql = " SELECT RECEIPT_ID,RECEIPT_NAME,RECEIPT_DATE, RECEIPT_CATEGORY_ID, (RECEIPT_PRICE + POSTAGE_PRICE) AS PRICE, RECEIPT_PAYMENT_METHOD, FGLH_ID,RECEIPT_ID,PAYMENT_STATUS,RECEIPT_DEITY_ID FROM `deity_receipt` WHERE RECEIPT_ID = $RECEIPT_ID";    
		$query = $this->db->query($sql);
		$receiptDetails = $query->first_row();

		$CHEQUE_NO = $_POST['DUC_CHEQUE_NO'];
		$BANK_NAME = str_replace("'","\'",$_POST['DUC_BANK_NAME']);
		$BRANCH_NAME = str_replace("'","\'",$_POST['DUC_BRANCH_NAME']);
		$CHEQUE_DATE = $_POST['DUC_CHEQUE_DATE'];


		$dateTime = date('d-m-Y H:i:s A');
		$aidR = $bank;
		$RECEIPT_ID = $receiptDetails->RECEIPT_ID;
		$catId = $receiptDetails->RECEIPT_CATEGORY_ID;
		$amtsR = $receiptDetails->PRICE;
		$tDateR = $receiptDetails->RECEIPT_DATE;
		$deityId = $result->RECEIPT_DEITY_ID;
		$flt_user = $_SESSION['userId'];
		$RECEIPT_PAYMENT_METHOD = $receiptDetails->RECEIPT_PAYMENT_METHOD;
		$PAYMENT_STATUS = $receiptDetails->PAYMENT_STATUS;
		$RECEIPT_NAME = $receiptDetails->RECEIPT_NAME;

// ADDED BY ADITHYA
$this->db->select('FGLH_ID')->from('deity_receipt_category')->where(array('RECEIPT_CATEGORY_ID'=> "$catId"));
	$query = $this->db->get();
	$T_DATAS = $query->first_row();

		if($catId != 5 || $catId != 10){
				// if($catId == 1) {
					$lidR = $T_DATAS->FGLH_ID;
				// } else if($catId == 2) {
				// 	$lidR = 18;
				// }else if($catId == 3) {
				// 	$lidR = 19;
				} if($catId == 4) {
					if($deityId==6){
						$lidR = 77;				//Tirupati Devara Hundi Kanike ONLY FOR SLVT
					} else {
						$lidR = $T_DATAS->FGLH_ID;
					}
				// }else if($catId == 6) {
				// 	$lidR = 26;
				// }else if($catId == 7) {
				// 	$lidR = 25;
				// }else if($catId == 8) {
				// 	$lidR = 22;
				// }else if($catId == 9) {
				// 	$lidR = 23;
				// }
		}

		if($catId == 8 || $catId == 9){
			$compId = 2;
		} else {
			$compId = 1;
		}

		$this->db->select()->from('finance_voucher_counter')
		->where(array('finance_voucher_counter.FVC_ID'=>'1'));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->FVC_COUNTER+1;
		
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$countNoR = $deityCounter->FVC_ABBR1 ."/".$datMonth."/".$deityCounter->FVC_ABBR2."/".$counter;

		$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`RECEIPT_ID`,`PAYMENT_METHOD`,	`RECEIPT_FAVOURING_NAME`,`CHEQUE_NO`,`BANK_NAME`,`BRANCH_NAME`,`CHEQUE_DATE`,`FLT_DEPOSIT_PAYMENT_DATE`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($lidR,'$countNoR',0,$amtsR,'$tDateR','$dateTime','','R1',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$RECEIPT_NAME','$CHEQUE_NO','$BANK_NAME','$BRANCH_NAME','$CHEQUE_DATE','$dDate','$PAYMENT_STATUS','$compId')");
		$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`RECEIPT_ID`,`PAYMENT_METHOD`,	`RECEIPT_FAVOURING_NAME`,`CHEQUE_NO`,`BANK_NAME`,`BRANCH_NAME`,`CHEQUE_DATE`,`FLT_DEPOSIT_PAYMENT_DATE`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($aidR,'$countNoR',$amtsR,0,'$tDateR','$dateTime','','R2',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$RECEIPT_NAME','$CHEQUE_NO','$BANK_NAME','$BRANCH_NAME','$CHEQUE_DATE','$dDate','$PAYMENT_STATUS','$compId')");

		$this->db->where('finance_voucher_counter.FVC_ID',1);
		$this->db->update('finance_voucher_counter', array('FVC_COUNTER'=>$counter));

		redirect("EOD_Tally");
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
}