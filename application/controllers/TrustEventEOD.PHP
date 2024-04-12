<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TrustEventEOD extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
			$this->load->helper('string');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->helper(array('form', 'url'));
			$this->load->helper('date');
			date_default_timezone_set('Asia/Kolkata');
			$this->load->model('Events_modal','obj_events',true);
			$this->load->model('Report_modal','obj_report',true);
			$this->load->model('TrustEventEOD_modal','obj_eod',true);
			$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
			
		if(!isset($_SESSION['userId']))
			redirect('login');
		
		if($_SESSION['trustLogin'] != 1)
			redirect('Trust');
		
		$this->db->select()->from('TRUST_EVENT')->where("TET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
		//$this->output->enable_profiler(true);
	}
	
	public function index($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');
			
		unset($_SESSION['selectedDate']);
		unset($_SESSION['receiptType']);

		if(@$_SESSION['userGroup'] == 1 || @$_SESSION['userGroup'] == 6 || @$_SESSION['userGroup'] == 2)
			redirect('EventEOD/eod_admin');
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		
		//For Menu Selection
		$data['whichTab'] = "hallEventEODReport";
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getTrustEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		
		$conditionOne = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$data['eod_receipt_report'] = $this->obj_eod->get_all_field_eod_report($conditionOne,'TET_RECEIPT_DATE','desc', 10,$start,$fDate,$tDate);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEventEOD/index';
		$config['total_rows'] = $this->obj_eod->count_all_field_eod_report($conditionOne,$fDate,$tDate);
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
		
		if(isset($_SESSION['Event_E.O.D_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trustEventEod');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	function eod_admin($start=0) {
		$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1];
		//$fromDate = date('Y')."-04-01";
		//$toDate = (date('Y')+1)."-03-31";

		$sql = "SELECT STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') as ReceiptDate FROM `TRUST_EVENT_RECEIPT` WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."' and (AUTHORISED_STATUS='No' and TET_RECEIPT_CATEGORY_ID != '5')";

		$query = $this->db->query($sql);

		unset($_SESSION['selectedDate']);
		unset($_SESSION['receiptType']);
		
		if(@$_SESSION['userGroup'] == 1 || @$_SESSION['userGroup'] == 6 || @$_SESSION['userGroup'] == 2) {
			
		} else {
			redirect('EventEOD');
		}
		
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');
           
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		
		//For Menu Selection
		$data['whichTab'] = "hallEventEODReport";
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getTrustEvents();
		
		$this->db->from('TRUST_EVENT_EOD_TIME_SETTING');
		$query = $this->db->get();
		$data['timeSettings'] = $query->first_row('array');
		// var_dump($data['timeSettings']);
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		
		$conditionOne = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$data['eod_receipt_report'] = $this->obj_eod->get_all_field_eod_report_admin($conditionOne,'TET_RECEIPT_DATE','desc', 10,$start,$fDate,$tDate);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEventEOD/eod_admin';
		$config['total_rows'] = $this->obj_eod->count_all_field_eod_report_admin($conditionOne,$fDate,$tDate);
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
		
		if(isset($_SESSION['Event_E.O.D_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trustEventEod_admin');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function eventEod_onDate() {	
		unset($_SESSION['all_users']);
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link2'] = $actual_link;

		$data['whichTab'] = "eventEOD";
		$data['selectedDate'] = $_POST['eodDate'];
		$_SESSION['selectedDate'] = $_POST['eodDate'];
		$data['receiptType'] = $_POST['receiptType'];
		$_SESSION['receiptType'] = $_POST['receiptType'];
		
		//TIME SETTINGS
		$this->db->from('TRUST_EVENT_EOD_TIME_SETTING');
		$query = $this->db->get();
		$data['timeSettings'] = $query->first_row('array');
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getTrustEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		
		$sql = "SELECT `TET_RECEIPT_DATE`,`TET_RECEIPT_ISSUED_BY`,`TET_RECEIPT_ISSUED_BY_ID`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, 
		(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `TET_RECEIPT_PRICE` ELSE '' END ) 
		+ SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,
		(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `TET_RECEIPT_PRICE` ELSE '' END ) 
		+ SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) 
		AS Cheque,(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `TET_RECEIPT_PRICE` ELSE '' END ) 
		+ SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',
		(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `TET_RECEIPT_PRICE` ELSE '' END ) 
		+ SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
		(SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount, 
		SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `TET_RECEIPT_PRICE` ELSE '' END ) AS 'AUTHORISED_STATUS' 
		FROM TRUST_EVENT_RECEIPT 
		INNER JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID 
		where TET_ACTIVE = 1 
		and `TET_RECEIPT_DATE`= '".$_POST['eodDate']."' and TET_RECEIPT_CATEGORY_ID != 4 and TET_RECEIPT_ACTIVE = 1 and STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."' GROUP BY `TET_RECEIPT_ISSUED_BY`";
		$query = $this->db->query($sql);
		$data['eod_receipt_report'] = $query->result();
		
		if(isset($_SESSION['Event_E.O.D_Report'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/trustEventEod_onDate');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function eventEod_save() {
		// ADDING TO FINANCIAL_LEDGER_TRAN START ADITHYA
		$selectedDate = $_POST['selectedDate'];
		$sql = "SELECT
            TET_RECEIPT_ID,
            TET_RECEIPT_DATE,
            TET_RECEIPT_CATEGORY_ID,
            SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE) AS PRICE,
            TET_RECEIPT_PAYMENT_METHOD,
            T_FGLH_ID,
            RECEIPT_TET_NAME,
            PAYMENT_STATUS,
            RECEIPT_TET_ID
        FROM
            `trust_event_receipt`
        WHERE
            TET_RECEIPT_DATE = '$selectedDate'
            AND TET_RECEIPT_PAYMENT_METHOD = 'Cash'
            AND TET_RECEIPT_ACTIVE = 1
        GROUP BY
            TET_RECEIPT_PAYMENT_METHOD,
            TET_RECEIPT_CATEGORY_ID 
        
        UNION
        
        SELECT
            TET_RECEIPT_ID,
            TET_RECEIPT_DATE,
            TET_RECEIPT_CATEGORY_ID,
            (TET_RECEIPT_PRICE + POSTAGE_PRICE) AS PRICE,
            TET_RECEIPT_PAYMENT_METHOD,
            T_FGLH_ID,
            RECEIPT_TET_NAME,
            PAYMENT_STATUS,
            RECEIPT_TET_ID
        FROM
            `trust_event_receipt`
        WHERE
            TET_RECEIPT_DATE = '$selectedDate'
            AND TET_RECEIPT_PAYMENT_METHOD = 'Direct Credit'
            AND TET_RECEIPT_ACTIVE = 1
        
        UNION
        
        SELECT
            TET_RECEIPT_ID,
            TET_RECEIPT_DATE,
            TET_RECEIPT_CATEGORY_ID,
            (TET_RECEIPT_PRICE + POSTAGE_PRICE) AS PRICE,
            TET_RECEIPT_PAYMENT_METHOD,
            T_FGLH_ID,
            RECEIPT_TET_NAME,
            PAYMENT_STATUS,
            RECEIPT_TET_ID
        FROM
            `trust_event_receipt`
        WHERE
            TET_RECEIPT_DATE = '$selectedDate'
            AND TET_RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card'
            AND TET_RECEIPT_ACTIVE = 1
        ORDER BY
            TET_RECEIPT_PAYMENT_METHOD,
            TET_RECEIPT_CATEGORY_ID";
        
        $query = $this->db->query($sql);

		$eventReceiptDetails = $query->result();
		//echo json_encode($query->result());

		$dateTime = date('d-m-Y H:i:s A');

		foreach($eventReceiptDetails as $result) { 
       
			if($result->TET_RECEIPT_PAYMENT_METHOD == "Cash") {
				$aidR = 21;
				$TET_RECEIPT_ID = $result->TET_RECEIPT_ID;
			} else { 
				$aidR = $result->T_FGLH_ID;
				$TET_RECEIPT_ID = $result->TET_RECEIPT_ID;
			}
			$catId = $result->TET_RECEIPT_CATEGORY_ID;
			$amtsR = $result->PRICE;
			$tDateR = $result->TET_RECEIPT_DATE;
			$naration = "";
			$flt_user = $_SESSION['userId'];
			$RECEIPT_PAYMENT_METHOD = $result->TET_RECEIPT_PAYMENT_METHOD;
			$PAYMENT_STATUS = $result->PAYMENT_STATUS;
			$RECEIPT_TET_ID = $result->RECEIPT_TET_ID;

			$this->db->select('T_FGLH_ID')->from('trust_event_receipt_category')->where(array('TET_RECEIPT_CATEGORY_ID'=> "$catId"));
	        $query = $this->db->get();
	        $T_DATAS = $query->first_row();
             
			if($catId != 4) {
				// if($catId == 1) {
					$lidR = $T_DATAS->T_FGLH_ID;
				// } else if($catId == 2) {
				// 	$lidR = $T_DATAS->T_FGLH_ID;
				// }else if($catId == 3) {
				// 	$lidR = $T_DATAS->T_FGLH_ID;
				// }
			}

			$this->db->select()->from('trust_finance_voucher_counter')
			->where(array('trust_finance_voucher_counter.T_FVC_ID'=>'1'));
			$query = $this->db->get();
			$deityCounter = $query->first_row();
			$counter = $deityCounter->T_FVC_COUNTER+1;
			
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			$countNoR = $deityCounter->T_FVC_ABBR1 ."/".$datMonth."/".$deityCounter->T_FVC_ABBR2."/".$counter;

			$sql ="SELECT T_COMP_ID FROM `trust_event` where TET_ID = $RECEIPT_TET_ID";
			$query = $this->db->query($sql);
			$compId =$query->row()->T_COMP_ID;
				
			$this->db->query(
			"INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_RECEIPT_ID`,`T_PAYMENT_METHOD`,`T_PAYMENT_STATUS`,`T_COMP_ID`) 
			                                     VALUES ($lidR,'$countNoR',0,$amtsR,'$tDateR','$dateTime','$naration','R1',$flt_user,$TET_RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS',$compId)");
			$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_RECEIPT_ID`,`T_PAYMENT_METHOD`,`T_PAYMENT_STATUS`,`T_COMP_ID`) 
			VALUES ($aidR,'$countNoR',$amtsR,0,'$tDateR','$dateTime','$naration','R2',$flt_user,$TET_RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS',$compId)");

			$this->db->where('trust_finance_voucher_counter.T_FVC_ID',1);
			$this->db->update('trust_finance_voucher_counter', array('T_FVC_COUNTER'=>$counter));

		}

		// ADDING TO FINANCIAL LEDGER TRAN END BY ADITHYA
		

		// $this->db->select()->from('FINANCIAL_YEAR');
		// $query = $this->db->get();
		// $finYear = $query->first_row();
		// // $fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		// // $tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		
		
		// removed this line by adihtya on 9-1-24
		// $whereOne = "STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		
		// $totalCashAmt = ((int)$_POST['cash']);
		// commented by adithya start 

		// $data = array(
		// 	'TEUC_BY_ID'=>@$_SESSION['userId'],
		// 	'TEUC_BY_NAME'=>@$_SESSION['userFullName'],
		// 	'TEUC_EOD_DATE'=>date('Y-m-d', strtotime($_POST['selectedDate'])),
		// 	'TEUC_CREDIT'=>((int)$_POST['totalAmt'] - (int)$_POST['cheque']),
		// 	'TEUC_CASH'=>@$_POST['cash'],
		// 	'TEUC_CHEQUE'=>"0",
		// 	'TEUC_DIRECT_CREDIT'=>@$_POST['directCredit'],
		// 	'TEUC_DEBIT_CREDIT_CARD'=>@$_POST['card'],
		// 	'TEUC_CASH_CHEQUE'=>$totalCashAmt,
		// 	'TEUC_DATE_TIME'=>date('d-m-Y h:i:s A'),
		// 	'TEUC_DATE'=>date('Y-m-d'));

		// comment enD
		
		// removed this line by adithya on 16-1-24
		// $this->db->$whereOne = "STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		
		$this->db->select()->from('TRUST_EVENT')->where(array('TET_ACTIVE'=>'1'));
		$query = $this->db->get();
		$event = $query->first_row();
		
		$this->db->where(array(
			'TET_RECEIPT_DATE'=>$_POST['selectedDate'],
			'TET_RECEIPT_CATEGORY_ID!='=>5,
			'TET_RECEIPT_ACTIVE' => 1,
			'RECEIPT_TET_ID' => $event->TET_ID
		));

		$event_receipt = array(
			"EOD_CONFIRMED_BY_ID"=>$_SESSION['userId'],
			"EOD_CONFIRMED_BY_NAME"=>$_SESSION['userFullName'],
			"EOD_CONFIRMED_DATE_TIME"=>date('d-m-Y h:i:s A'),
			"EOD_CONFIRMED_DATE"=>date('d-m-Y')
		);

		$this->db->update('TRUST_EVENT_RECEIPT', $event_receipt);
		
		// $this->db->insert('TRUST_EVENT_USER_COLLECTION',$data);
		// $id = $this->db->insert_id();
		
		// $TRUST_EVENT_USER_COLLECTION_HISTORY = array(
		// 	'TEUC_ID'=>$id,
		// 	'TEUCH_BY_ID'=>@$_SESSION['userId'],
		// 	'TEUCH_BY_NAME'=>@$_SESSION['userFullName'],
		// 	'TEUCH_DATE_TIME'=>date('d-m-Y h:i:s A'),
		// 	'TEUCH_DATE'=>date('Y-m-d'),
		// );
		// $this->db->insert('TRUST_EVENT_USER_COLLECTION_HISTORY',$TRUST_EVENT_USER_COLLECTION_HISTORY);

		$where = array(
			"TET_RECEIPT_DATE"=>@$_POST['selectedDate'],
			"TET_RECEIPT_ACTIVE"=>"1",
			"TET_RECEIPT_PAYMENT_METHOD"=>"Cheque",
			"TET_ACTIVE" => "1"
		);
		$this->db->from("TRUST_EVENT_RECEIPT")->join("TRUST_EVENT","TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID")->where($where); //->where($whereOne)
		$query = $this->db->get();
		$chequeDetails = $query->result();

		foreach($chequeDetails as $result) {			
			$data = array(
				'TEUC_BY_ID'=>@$_SESSION['userId'],
				'TEUC_BY_NAME'=>@$_SESSION['userFullName'],
				'TEUC_EOD_DATE'=>date('Y-m-d', strtotime($_POST['selectedDate'])),
				'TEUC_RECEIPT_ID'=>$result->TET_RECEIPT_ID,
				'TEUC_CREDIT'=>$result->TET_RECEIPT_PRICE,
				'TEUC_DIRECT_CREDIT'=>"0",
				'TEUC_DEBIT_CREDIT_CARD'=>"0",
				'TEUC_DEBIT_CREDIT_CARD'=>"0",
				'TEUC_CREDIT'=>$result->TET_RECEIPT_PRICE,
				'TEUC_CASH_CHEQUE'=>$result->TET_RECEIPT_PRICE,
				'TEUC_CASH'=>"0",
				'TEUC_CHEQUE'=>$result->TET_RECEIPT_PRICE,
				'TEUC_DATE_TIME'=>date('d-m-Y h:i:s A'),
				'TEUC_DATE'=>date('Y-m-d'),
				'TEUC_CHEQUE_NO'=>$result->CHEQUE_NO,
				'TEUC_CHEQUE_DATE'=>$result->CHEQUE_DATE,
				'TEUC_BANK_NAME'=>$result->BANK_NAME,
				'TEUC_BRANCH_NAME'=>$result->BRANCH_NAME,
				'TEUC_IS_DEPOSITED'=>"0"
			);
			
			$this->db->insert('TRUST_EVENT_USER_COLLECTION',$data);
			$id = $this->db->insert_id();
			
			$TRUST_EVENT_USER_COLLECTION_HISTORY = array(
				'TEUC_ID'=>$id,
				'TEUCH_BY_ID'=>@$_SESSION['userId'],
				'TEUCH_BY_NAME'=>@$_SESSION['userFullName'],
				'TEUCH_DATE_TIME'=>date('d-m-Y h:i:s A'),
				'TEUCH_DATE'=>date('Y-m-d'),
			);
			
			$this->db->insert('TRUST_EVENT_USER_COLLECTION_HISTORY',$TRUST_EVENT_USER_COLLECTION_HISTORY);
		}
		
		echo "success";
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
	

	
	function View(){
		$id = $this->input->post('id');
		$cheqNo = $this->input->post('cheqNo');
		$cheqDate = $this->input->post('cheqDate');
		$Bank = $this->input->post('Bank');
		$Branch = $this->input->post('Branch');
		$TransactionId = $this->input->post('TransactionId');
		
		if($id == '1') {
			echo "<h6 style='font-size:16px; line-height:16px;'><b>Cheque No : </b> ".$cheqNo."</h6>" ;  
			echo "<h6 style='font-size:16px; line-height:16px;'><b>Cheque Date : </b> ".$cheqDate."</h6>" ; 
			echo "<h6 style='font-size:16px; line-height:16px;'><b>Bank : </b> ".str_replace("'","\'",$Bank)."</h6>" ; 
			echo "<h6 style='font-size:16px; line-height:16px;'><b>Branch : </b> ".str_replace("'","\'",$Branch)."</h6>" ; 
		} else if($id == '2'){
			echo "<h6 style='font-size:16px; line-height:16px;'><b>Transaction Id : </b> ".$TransactionId."</h6>" ;  
		}
	}
	
	//SET THE SESSION OF CHECKBOX
	function get_set_session() {
		$this->session->set_userdata('all_users',$this->input->post('select'));
	}
	
	//UNSET THE SESSION OF CHECKBOX
	function get_unset_session() {
		unset($_SESSION['all_users']);
		unset($_SESSION['PM']);
		unset($_SESSION['UID']);
	}
	
	function checkPreviousPendingDate() {
		$toDate = $_POST['date'];
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		
		/* $sql = "SELECT STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') as ReceiptDate FROM `TRUST_EVENT_RECEIPT` WHERE STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') < STR_TO_DATE('".$toDate."','%d-%m-%Y') and TET_RECEIPT_ACTIVE = 1 and EOD_CONFIRMED_BY_ID = 0"; */
		$sql = "SELECT STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') as ReceiptDate FROM `TRUST_EVENT_RECEIPT` 
				INNER JOIN trust_event ON trust_event.TET_ID = trust_event_receipt.RECEIPT_TET_ID WHERE  STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') > STR_TO_DATE(TET_FROM_DATE_TIME,'%d-%m-%Y') AND TET_RECEIPT_ACTIVE = 1  and TET_ACTIVE = 1 and (EOD_CONFIRMED_BY_ID IS NULL OR EOD_CONFIRMED_BY_ID = 0) AND STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') < STR_TO_DATE('".$toDate."','%d-%m-%Y') and STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) { 
			echo $query->num_rows();
		} else {
			echo "success";
		}
	}

	function eventEod_usercollection($start=0) {
		//whichTab
		$data['whichTab'] = "hallEventEODReport";
		
		//UNSET SESSION
		unset($_SESSION['paymentMethod']);
		unset($_SESSION['PM']);
		unset($_SESSION['UID']);
		
		//Date
		if(@$_POST['date']) {
			$_SESSION['UserDate'] = $this->input->post('date');
			$data['UserDate'] = $this->input->post('date');
			$userDate = $this->input->post('date');
		}
		
		if(@$_SESSION['UserDate'] == "") {
			$this->session->set_userdata('UserDate', $this->input->post('date'));
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate = $this->input->post('date');
		} else {
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate =  $_SESSION['UserDate'];
		}
		
		//Username
		if(@$_POST['userName']) {
			$_SESSION['UserName'] = $this->input->post('userName');
			$data['UserName'] = $this->input->post('userName');
			$userName = $this->input->post('userName');
		}
		
		if(@$_SESSION['UserName'] == "") {
			$this->session->set_userdata('UserName', $this->input->post('userName'));
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $this->input->post('userName');
		} else {
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $_SESSION['UserName'];
		}
		
		//UserId
		if(@$_POST['userId']) {
			$_SESSION['UserId'] = $this->input->post('userId');
			$data['UserId'] = $this->input->post('userId');
			$userId = $this->input->post('userId');
		}
		
		if(@$_SESSION['UserId'] == "") {
			$this->session->set_userdata('UserId', $this->input->post('userId'));
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $this->input->post('userId');
		} else {
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $_SESSION['UserId'];
		}
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getTrustEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		$condt = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$condt3 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$condt4 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
				
		$conditionOne = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEventEOD/eventEod_usercollection';
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne,$whereOne);
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
		
		if(isset($_SESSION['Event_E.O.D_Report'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/trustEventEod_usercollection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//for admin view button click in eventEod_onDate
	function getDataOnFilter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "hallEventEODReport";
				
		//Date
		if(@$_POST['date']) {
			$_SESSION['UserDate'] = $this->input->post('date');
			$data['UserDate'] = $this->input->post('date');
			$userDate = $this->input->post('date');
		}
		
		if(@$_SESSION['UserDate'] == "") {
			$this->session->set_userdata('UserDate', $this->input->post('date'));
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate = $this->input->post('date');
		} else {
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate =  $_SESSION['UserDate'];
		}
		
		//Username
		if(@$_POST['userName']) {
			$_SESSION['UserName'] = $this->input->post('userName');
			$data['UserName'] = $this->input->post('userName');
			$userName = $this->input->post('userName');
		}
		
		if(@$_SESSION['UserName'] == "") {
			$this->session->set_userdata('UserName', $this->input->post('userName'));
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $this->input->post('userName');
		} else {
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $_SESSION['UserName'];
		}
		
		//UserId
		if(@$_POST['userId']) {
			$_SESSION['UserId'] = $this->input->post('userId');
			$data['UserId'] = $this->input->post('userId');
			$userId = $this->input->post('userId');
		}
		
		if(@$_SESSION['UserId'] == "") {
			$this->session->set_userdata('UserId', $this->input->post('userId'));
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $this->input->post('userId');
		} else {
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $_SESSION['UserId'];
		}
				
		if(@$_POST['paymentMethod'] != "") {
			unset($_SESSION['paymentMethod']);
			$_SESSION['receipt'] = $this->input->post('paymentMethod');
			$pMethod = $this->input->post('paymentMethod');
			$data['payMethod'] = $this->input->post('paymentMethod');
		}
		
		if(@$_SESSION['paymentMethod'] == "") {
			$this->session->set_userdata('paymentMethod', $this->input->post('paymentMethod'));
			$pMethod = $this->input->post('paymentMethod');
			$data['payMethod'] = $_SESSION['paymentMethod'];
		} else {
			$pMethod = $_SESSION['paymentMethod'];
			$data['payMethod'] = $_SESSION['paymentMethod'];
		}
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getTrustEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		if($id == 0) {
			//SESSION OF APPROVE
			if(isset($_SESSION['PM'])) {
				$pMethod = $_SESSION['PM'];
				$data['payMethod'] = $_SESSION['PM'];
			}
			
			//SESSION OF APPROVE
			if(isset($_SESSION['UID'])) {
				$users = $_SESSION['UID'];
				$data['user'] = $_SESSION['UID'];
				
				$conditionOne = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
				$receipt_report = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
				if(count($receipt_report) == 0) {
					$users = "All Users";
				}
			}
		} else {
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);
		}
		
		if(@$pMethod == "All") {
			$conditionOne = array('TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} else if(@$pMethod != "All") {
			$conditionOne = array('TET_RECEIPT_PAYMENT_METHOD' => $pMethod,'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt1 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt2 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt3 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt4 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEventEOD/getDataOnFilter/'.$id;
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne,$whereOne);
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
		
		$this->load->view('header', $data);
		$this->load->view('trust/trustEventEodUsercollection');
		$this->load->view('footer_home');
	}
	
	function eventEodUsercollection($start=0) {
		//whichTab
		$data['whichTab'] = "hallEventEODReport";
		
		//UNSET SESSION
		unset($_SESSION['paymentMethod']);
		unset($_SESSION['PM']);
		unset($_SESSION['UID']);
		
		//Date
		if(@$_POST['date']) {
			$_SESSION['UserDate'] = $this->input->post('date');
			$data['UserDate'] = $this->input->post('date');
			$userDate = $this->input->post('date');
		}
		
		if(@$_SESSION['UserDate'] == "") {
			$this->session->set_userdata('UserDate', $this->input->post('date'));
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate = $this->input->post('date');
		} else {
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate =  $_SESSION['UserDate'];
		}
		
		//Username
		if(@$_POST['userName']) {
			$_SESSION['UserName'] = $this->input->post('userName');
			$data['UserName'] = $this->input->post('userName');
			$userName = $this->input->post('userName');
		}
		
		if(@$_SESSION['UserName'] == "") {
			$this->session->set_userdata('UserName', $this->input->post('userName'));
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $this->input->post('userName');
		} else {
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $_SESSION['UserName'];
		}
		
		//UserId
		if(@$_POST['userId']) {
			$_SESSION['UserId'] = $this->input->post('userId');
			$data['UserId'] = $this->input->post('userId');
			$userId = $this->input->post('userId');
		}
		
		if(@$_SESSION['UserId'] == "") {
			$this->session->set_userdata('UserId', $this->input->post('userId'));
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $this->input->post('userId');
		} else {
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $_SESSION['UserId'];
		}
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getTrustEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		$condt = array('TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$condt1 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$condt2 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$condt3 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$condt4 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
		
		$conditionOne = array('TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEventEOD/eventEodUsercollection';
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne,$whereOne);
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
		
		if(isset($_SESSION['Event_E.O.D_Report'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/trustEventEodUsercollection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//EOD for Logged in user
	function eventEod_collection($start=0) {
		//whichTab
		$data['whichTab'] = "hallEventEODReport";
		
		//UNSET SESSION
		unset($_SESSION['paymentMethod']);
		unset($_SESSION['PM']);
		unset($_SESSION['UID']);
		
		//Date
		if(@$_POST['date']) {
			$_SESSION['UserDate'] = $this->input->post('date');
			$data['UserDate'] = $this->input->post('date');
			$userDate = $this->input->post('date');
		}
		
		if(@$_SESSION['UserDate'] == "") {
			$this->session->set_userdata('UserDate', $this->input->post('date'));
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate = $this->input->post('date');
		} else {
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate =  $_SESSION['UserDate'];
		}
		
		//Username
		if(@$_POST['userName']) {
			$_SESSION['UserName'] = $_SESSION['userFullName'];
			$data['UserName'] = $this->input->post('userFullName');
			$userName = $this->input->post('userFullName');
		}
		
		if(@$_SESSION['UserName'] == "") {
			$this->session->set_userdata('UserName', $_SESSION['userFullName']);
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $_SESSION['userFullName'];
		} else {
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $_SESSION['UserName'];
		}
		
		//UserId
		if(@$_POST['userId']) {
			$_SESSION['UserId'] = $_SESSION['userId'];
			$data['UserId'] = $_SESSION['userId'];
			$userId = $_SESSION['userId'];
		}
		
		if(@$_SESSION['UserId'] == "") {
			$this->session->set_userdata('UserId', $_SESSION['userId']);
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $_SESSION['userId'];
		} else {
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $_SESSION['UserId'];
		}
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getTrustEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		$condt = array('TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$condt1 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$condt2 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$condt3 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$condt4 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
		
		$conditionOne = array('TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEventEOD/eventEod_collection';
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne,$whereOne);
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
		
		if(isset($_SESSION['Event_E.O.D_Report'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/trustEventEod_collection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function get_data_on_filter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "hallEventEODReport";
				
		//Date
		if(@$_POST['date']) {
			$_SESSION['UserDate'] = $this->input->post('date');
			$data['UserDate'] = $this->input->post('date');
			$userDate = $this->input->post('date');
		}
		
		if(@$_SESSION['UserDate'] == "") {
			$this->session->set_userdata('UserDate', $this->input->post('date'));
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate = $this->input->post('date');
		} else {
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate =  $_SESSION['UserDate'];
		}
		
		//Username
		if(@$_POST['userName']) {
			$_SESSION['UserName'] = $this->input->post('userName');
			$data['UserName'] = $this->input->post('userName');
			$userName = $this->input->post('userName');
		}
		
		if(@$_SESSION['UserName'] == "") {
			$this->session->set_userdata('UserName', $this->input->post('userName'));
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $this->input->post('userName');
		} else {
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $_SESSION['UserName'];
		}
		
		//UserId
		if(@$_POST['userId']) {
			$_SESSION['UserId'] = $this->input->post('userId');
			$data['UserId'] = $this->input->post('userId');
			$userId = $this->input->post('userId');
		}
		
		if(@$_SESSION['UserId'] == "") {
			$this->session->set_userdata('UserId', $this->input->post('userId'));
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $this->input->post('userId');
		} else {
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $_SESSION['UserId'];
		}
				
		if(@$_POST['paymentMethod'] != "") {
			unset($_SESSION['paymentMethod']);
			$_SESSION['receipt'] = $this->input->post('paymentMethod');
			$pMethod = $this->input->post('paymentMethod');
			$data['payMethod'] = $this->input->post('paymentMethod');
		}
		
		if(@$_SESSION['paymentMethod'] == "") {
			$this->session->set_userdata('paymentMethod', $this->input->post('paymentMethod'));
			$pMethod = $this->input->post('paymentMethod');
			$data['payMethod'] = $_SESSION['paymentMethod'];
		} else {
			$pMethod = $_SESSION['paymentMethod'];
			$data['payMethod'] = $_SESSION['paymentMethod'];
		}
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getTrustEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		if($id == 0) {
			//SESSION OF APPROVE
			if(isset($_SESSION['PM'])) {
				$pMethod = $_SESSION['PM'];
				$data['payMethod'] = $_SESSION['PM'];
			}
			
			//SESSION OF APPROVE
			if(isset($_SESSION['UID'])) {
				$users = $_SESSION['UID'];
				$data['user'] = $_SESSION['UID'];
				
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
				$receipt_report = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
				if(count($receipt_report) == 0) {
					$users = "All Users";
				}
			}
		} else {
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);
		}
		
		if(@$pMethod == "All") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} else if(@$pMethod != "All") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $pMethod,'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt3 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt4 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEventEOD/get_data_on_filter/'.$id;
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne,$whereOne);
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
		
		$this->load->view('header', $data);
		$this->load->view('trust/trustEventEod_usercollection');
		$this->load->view('footer_home');
	}
	
	//EOD for Logged in user
	function get_data_on_userFilter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "hallEventEODReport";
		
		//Date
		if(@$_POST['date']) {
			$_SESSION['UserDate'] = $this->input->post('date');
			$data['UserDate'] = $this->input->post('date');
			$userDate = $this->input->post('date');
		}
		
		if(@$_SESSION['UserDate'] == "") {
			$this->session->set_userdata('UserDate', $this->input->post('date'));
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate = $this->input->post('date');
		} else {
			$data['UserDate'] = $_SESSION['UserDate'];
			$userDate =  $_SESSION['UserDate'];
		}
		
		//Username
		if(@$_POST['userName']) {
			$_SESSION['UserName'] = $this->input->post('userName');
			$data['UserName'] = $this->input->post('userName');
			$userName = $this->input->post('userName');
		}
		
		if(@$_SESSION['UserName'] == "") {
			$this->session->set_userdata('UserName', $this->input->post('userName'));
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $this->input->post('userName');
		} else {
			$data['UserName'] = $_SESSION['UserName'];
			$userName = $_SESSION['UserName'];
		}
		
		//UserId
		if(@$_POST['userId']) {
			$_SESSION['UserId'] = $this->input->post('userId');
			$data['UserId'] = $this->input->post('userId');
			$userId = $this->input->post('userId');
		}
		
		if(@$_SESSION['UserId'] == "") {
			$this->session->set_userdata('UserId', $this->input->post('userId'));
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $this->input->post('userId');
		} else {
			$data['UserId'] = $_SESSION['UserId'];
			$userId = $_SESSION['UserId'];
		}
				
		if(@$_POST['paymentMethod'] != "") {
			unset($_SESSION['paymentMethod']);
			$_SESSION['receipt'] = $this->input->post('paymentMethod');
			$pMethod = $this->input->post('paymentMethod');
			$data['payMethod'] = $this->input->post('paymentMethod');
		}
		
		if(@$_SESSION['paymentMethod'] == "") {
			$this->session->set_userdata('paymentMethod', $this->input->post('paymentMethod'));
			$pMethod = $this->input->post('paymentMethod');
			$data['payMethod'] = $_SESSION['paymentMethod'];
		} else {
			$pMethod = $_SESSION['paymentMethod'];
			$data['payMethod'] = $_SESSION['paymentMethod'];
		}
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getTrustEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		if($id == 0) {
			//SESSION OF APPROVE
			if(isset($_SESSION['PM'])) {
				$pMethod = $_SESSION['PM'];
				$data['payMethod'] = $_SESSION['PM'];
			}
			
			//SESSION OF APPROVE
			if(isset($_SESSION['UID'])) {
				$users = $_SESSION['UID'];
				$data['user'] = $_SESSION['UID'];
				
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
				$receipt_report = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
				if(count($receipt_report) == 0) {
					$users = "All Users";
				}
			}
		} else {
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);
		}
		
		if(@$pMethod == "All") {
			$conditionOne = array('TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} else if(@$pMethod != "All") {
			$conditionOne = array('TET_RECEIPT_PAYMENT_METHOD' => $pMethod,'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt1 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt2 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt3 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
		$condt4 = array('TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$userId,'TET_RECEIPT_DATE'=>$userDate,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEventEOD/get_data_on_userFilter/'.$id;
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne,$whereOne);
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
		
		$this->load->view('header', $data);
		$this->load->view('trust/trustEventEod_collection');
		$this->load->view('footer_home');
	}
	
	//APPROVE THE DATA
	function approve_Submit() {
		$data['whichTab'] = "hallEventEODReport";	
		
		//VALUE OF CHECKBOX SELECTED OR NOT SELECTED
		$selCondition = $this->input->post('checkVal');
		
		//GET EVENT ID
		$this->db->select()->from('TRUST_EVENT')->where(array('TET_ACTIVE'=>'1'));
		$query = $this->db->get();
		$event = $query->first_row();
		
		//GET FINANCIAL_YEAR DATE
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		if($selCondition == "all_users") { //ALL_USERS CHECKBOX
			if(@$this->input->post('paymentApprove') == "All") {
				$condition = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'TET_RECEIPT_DATE'=>$_POST['dateChk'],'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'RECEIPT_TET_ID' => $event->TET_ID);
			}  else if(@$this->input->post('paymentApprove') != "All" ) {
				$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'),'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'TET_RECEIPT_DATE'=>$_POST['dateChk'],'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'RECEIPT_TET_ID' => $event->TET_ID);
			} 
			//UPDATE CODE
			$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'),'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
			$this->obj_eod->update_authorise($condition,$data,$whereOne);
		} else if($selCondition == "this_page") { //THIS_PAGE CHECKBOX
			$selectedId = $this->input->post('selectApprove');
			$arrSelect = explode(',' ,$selectedId);
			for($i = 0; $i <= count($arrSelect) - 1; $i++) {
				if(@$this->input->post('paymentApprove') == "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'TET_RECEIPT_DATE'=>$_POST['dateChk'],'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'RECEIPT_TET_ID' => $event->TET_ID);
				} else if(@$this->input->post('paymentApprove') != "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'TET_RECEIPT_DATE'=>$_POST['dateChk'],'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'TET_ACTIVE' => 1);
				} 
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'RECEIPT_TET_ID' => $event->TET_ID);
				$this->obj_eod->update_authorise($condition,$data,$whereOne);
			}
		} else { //WITHOUT CHECKBOX
			$selectedId = $this->input->post('selectApprove');
			$arrSelect = explode(',' ,$selectedId);
			for($i = 0; $i <= count($arrSelect) - 1; $i++) {
				if(@$this->input->post('paymentApprove') == "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'TET_RECEIPT_DATE'=>$_POST['dateChk'],'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'RECEIPT_TET_ID' => $event->TET_ID);
				} else if(@$this->input->post('paymentApprove') != "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'TET_RECEIPT_DATE'=>$_POST['dateChk'],'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID !=' => 5,'RECEIPT_TET_ID' => $event->TET_ID);
				} 
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
				$this->obj_eod->update_authorise($condition,$data,$whereOne);
			}
		}
		$this->session->set_userdata('PM', $this->input->post('paymentApprove'));
		redirect('/TrustEventEOD/eventEod_usercollection'); //get_data_on_filter/0
	}
}