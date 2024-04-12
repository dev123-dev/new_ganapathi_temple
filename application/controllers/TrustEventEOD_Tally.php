<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TrustEventEOD_Tally extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('string');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->helper('date');
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('Report_modal','obj_report',true);
		$this->load->model('TrustEventEOD_modal','obj_eod',true);
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		$this->load->model('Events_modal','obj_events',true);
		$this->load->model('Shashwath_Model','obj_shashwath',true);		
		$this->load->model('TrustReceipt_modal','trust_receipt_modal',true);  //added by adithya on 5-1-24

		if(!isset($_SESSION['userId']))
			redirect('login');
		
		if($_SESSION['trustLogin'] != 1)
			redirect('Trust');
		
		// $this->output->enable_profiler(true);
		
		$this->db->select()->from('TRUST_EVENT')->where("TET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
	}
	
	public function index($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');

		$data['whichTab'] = "hallEventEODReport";
		$data['radioOpt'] = "year";
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;

		$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1];
		/* $fromDate = date('Y').'-04-01';
		$toDate = (date('Y')+1).'-03-31'; */
		
		// OLD CODE IS IN NOTEPAD ++
        $data['bank'] = $this->trust_receipt_modal->get_banks();
		$data['eod_tally'] = $this->obj_eod->get_all_field_pagination($fromDate, $toDate, 10, $start);

		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEventEOD_Tally/index';
		$config['total_rows'] = $this->obj_eod->count_get_all_field($fromDate, $toDate);
		$config['per_page'] = 30;
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

		if(isset($_SESSION['Event_E.O.D_Tally'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/trustEventEod_tally');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	
	function checkPreviousPendingDate() {
		$toDate = $_POST['date'];
		$sql = "SELECT TEUC_EOD_DATE as EODDate FROM `trust_event_user_collection` WHERE TEUC_EOD_DATE < '".$toDate."' and TEUC_IS_DEPOSITED != 1 ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) { 
			echo $query->num_rows();
		} else {
			echo "success";
		}
	}

	//ON FILTER CHANGE (YEARWISE. MONTHWISE, DATEWISE)
	function get_change_on_filters($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');

		$data['whichTab'] = "hallEventEODReport";
		$arr = array(
			"TEUC_IS_DEPOSITED"=>"0"
		);
		$this->db->from("TRUST_EVENT_USER_COLLECTION")->where($arr);
		$query = $this->db->get();
		$data['chequeDetails'] = $query->result();
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		
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
		} else if($radioOpt == "month") {
			$yr = $myCombo; 
			$mnth = (sprintf("%02d", $mmCombo));
			$fromDate = $yr.'-'.$mnth.'-01';
			$toDate = $yr.'-'.$mnth.'-31';
		} else if($radioOpt == "date") {
			$dOne = (explode("-",$fromDates));
			$dTwo = (explode("-",$toDates));
			$fromDate = $dOne[2].'-'.$dOne[1].'-'.$dOne[0];
			$toDate = $dTwo[2].'-'.$dTwo[1].'-'.$dTwo[0];
		}
		
		$or_arr = array(
			"TEUC_IS_DEPOSITED"=>"1"
		);
		
		$this->db->from("TRUST_EVENT_USER_COLLECTION")->where($arr)->or_where($or_arr);
		$query = $this->db->get();
		$data['chequeDetails_or'] = $query->result();
		
		//CREDIT TOTAL
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(TEUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$data['creditTotal'] = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(TEUC_CASH) AS TCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH) AS TCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$data['cCash'] = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(TEUC_CHEQUE) AS TCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CHEQUE) AS TCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$data['cCheque'] = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(TEUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$data['dCash'] = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(TEUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$data['dCheque'] = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(TEUC_DEBIT) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_DEBIT) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$data['debitTotal'] = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(TEUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TEUC_DEBIT),0) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(TEUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TEUC_DEBIT),0) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$data['balance'] = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(TEUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TEUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TEUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TEUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."'AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$data['balanceCash'] = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM(TEUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TEUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TEUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TEUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."'AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$data['balanceCheque'] = $query->first_row();
		
		//BANK
		$this->db->from('TRUST_EVENT_BANK');
		$query = $this->db->get();
		$data['bank'] = $query->result();
		
		$data['eod_tally'] = $this->obj_eod->get_all_field_pagination($fromDate, $toDate, 30, $start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEventEOD_Tally/get_change_on_filters';
		$config['total_rows'] = $this->obj_eod->count_get_all_field($fromDate, $toDate);
		$config['per_page'] = 30;
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
		//pagination ends
		//$this->output->enable_profiler(true);
		
		if(isset($_SESSION['Event_E.O.D_Tally'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/trustEventEod_tally');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
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
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
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
		$header .= $templename[0]["TRUST_NAME"]. "\n\n";
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
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(TEUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$creditTotal = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(TEUC_CASH) AS TCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH) AS TCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$cCash = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(TEUC_CHEQUE) AS TCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CHEQUE) AS TCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$cCheque = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(TEUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$dCash = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(TEUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$dCheque = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(TEUC_DEBIT) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_DEBIT) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$debitTotal = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(TEUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TEUC_DEBIT),0) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(TEUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TEUC_DEBIT),0) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$balance = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(TEUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TEUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TEUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TEUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."'AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$balanceCash = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM(TEUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TEUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TEUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TEUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."'AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$balanceCheque = $query->first_row();
		
		//BANK
		$this->db->from('TRUST_EVENT_BANK');
		$query = $this->db->get();
		$bank = $query->result();
		
		$conditionOne = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$res = $this->obj_eod->get_all_field($fromDate, $toDate);
		
		for($i = 0; $i < sizeof($res); $i++) {
			$line = '';    
			$value = "";			
			$value .= '"' . ($i+1) . '"' . "\t";
			$value .= '"' . date('d-m-Y',strtotime($res[$i]->TEUC_DATE)) . '"' . "\t";
			$value .= '"' . $res[$i]->OpBal . '"' . "\t";
			
			if($res[$i]->TEUC_CASH != NULL)
				$value .= '"'.$res[$i]->TEUC_CASH .'"' . "\t";
			else
				$value .= '"'.$res[$i]->TEUC_CASH_DEPOSIT .'"' . "\t";
			
			if($res[$i]->TEUC_CHEQUE != NULL)
				$value .= '"' . $res[$i]->TEUC_CHEQUE . '"' . "\t";
			else 
				$value .= '"' . $res[$i]->TEUC_CHEQUE_DEPOSIT . '"' . "\t";
			
			if($res[$i]->TEUC_CASH_CHEQUE != NULL)
				$value .= '"' . $res[$i]->TEUC_CASH_CHEQUE . '"' . "\t";
			else 
				$value .= '" - "' . "\t";
			
			if($res[$i]->TEUC_DEBIT != NULL)
				$value .= '"' . $res[$i]->TEUC_DEBIT . '"' . "\t";
			else 
				$value .= '" - "' . "\t";
				
			$value .= '"' . $res[$i]->ClBal . '"' . "\t";
			
			if($res[$i]->BANK_NAME != NULL)
				$value .= '"' . $res[$i]->ACCOUNT_NO .", ". $res[$i]->BANK_NAME .", ". $res[$i]->BANK_BRANCH .'"' . "\t";
			else 
				$value .= '" - "' . "\t";
			
			if($res[$i]->TEUC_DEBIT != NULL)
				$value .= '"' . $res[$i]->TEUC_EOD_DATE . '"' . "\t";
			else 
				$value .= '" - "' . "\t";

			
			if($res[$i]->TEUC_DEBIT == NULL)
				$value .= '"' . $res[$i]->TEUC_EOD_DATE . '"' . "\t";
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
		$EUC_ID = $_POST['DUC_ID'];
		$EUC_CHEQUE_ID = $_POST['DUC_CHEQUE_ID'];
		
		$data = array(
			'TEUC_IS_DEPOSITED'=>"0"
		);
		
		$where = array(
			'TEUC_ID'=>$EUC_CHEQUE_ID
		);
		$this->db->where($where);
		$this->db->update('TRUST_EVENT_USER_COLLECTION', $data);
		
		$this->db->delete('TRUST_EVENT_USER_COLLECTION', array('TEUC_ID' => $EUC_ID));
	}
	
	function eodTallySave() {
		// old code is in notepad++ 
///////////////////////////////////// new code by adithya start
$updateId = @$_POST['TEUC_ID'];
// $cheque = $_POST['cheque'];
$total = $_POST['total'];
$bank = $_POST['bank'];
$TET_RECEIPT_ID = $_POST['TET_RECEIPT_ID'];
$dDate = $_POST['chequedate'];
$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
$fromDate = explode(":",$dtFuncStr)[0];
$toDate = explode(":",$dtFuncStr)[1];


$data = array(
	'TEUC_BY_ID'=>@$_SESSION['userId'],
	'TEUC_BY_NAME'=>@$_SESSION['userFullName'],
	'TEUC_DATE_TIME'=>date('d-m-Y h:i:s A'),
	'TEUC_DATE'=>date('Y-m-d'),
	'TEUC_IS_DEPOSITED'=>1,
	'TEUC_LEDGER_ID'=>$bank,
	'TEUC_DEPOSIT_DATE'=>date('Y-m-d',strtotime($dDate)),
);

$where = array(
	'TEUC_ID'=>$updateId
);

$this->db->where($where);
$this->db->update('TRUST_EVENT_USER_COLLECTION', $data);

$EVENT_USER_COLLECTION_HISTORY = array(
	'TEUC_ID'=>$updateId,
	'TEUCH_BY_ID'=>@$_SESSION['userId'],
	'TEUCH_BY_NAME'=>@$_SESSION['userFullName'],
	'TEUCH_DATE_TIME'=>date('d-m-Y h:i:s A'),
	'TEUCH_DATE'=>date('Y-m-d'),
);
$this->db->insert('TRUST_EVENT_USER_COLLECTION_HISTORY',$EVENT_USER_COLLECTION_HISTORY);
// // **************************************************************************************************************************************************************

$sqlFinTrans = "SELECT T_RECEIPT_ID,T_VOUCHER_NO FROM `trust_financial_ledger_transcations` WHERE T_RECEIPT_ID = $TET_RECEIPT_ID";    
$queryFinTrans = $this->db->query($sqlFinTrans);

if ($queryFinTrans->num_rows() > 0) {
	$financialLedgerDetails = $queryFinTrans->first_row();
$replaceVoucherNo=$financialLedgerDetails->T_VOUCHER_NO;
		$sql1="UPDATE trust_financial_ledger_transcations
		 SET T_FLT_DEPOSIT_PAYMENT_DATE='$dDate',
		  `T_PAYMENT_STATUS` = 'Completed'
		   where T_VOUCHER_NO = '$replaceVoucherNo'";
		$this->db->query($sql1);
		
		$sql1="UPDATE trust_financial_ledger_transcations 
		 SET T_FGLH_ID='$bank'
		  where 
		 T_VOUCHER_NO = '$replaceVoucherNo' 
		 AND T_RP_TYPE ='R2'" ;
		$this->db->query($sql1);
} else {

	$sql = "SELECT TET_RECEIPT_ID,
				    TET_RECEIPT_NAME,
				    TET_RECEIPT_DATE,
				    TET_RECEIPT_CATEGORY_ID,
				    (TET_RECEIPT_PRICE + POSTAGE_PRICE) AS PRICE,
				    TET_RECEIPT_PAYMENT_METHOD,
				    T_FGLH_ID,
				    PAYMENT_STATUS,
				    RECEIPT_TET_ID 
			 FROM `trust_event_receipt`
			 WHERE TET_RECEIPT_ID = $TET_RECEIPT_ID";    
	$query = $this->db->query($sql);
	$receiptDetails = $query->first_row();

	$CHEQUE_NO = $_POST['TEUC_CHEQUE_NO'];
	$BANK_NAME = str_replace("'","\'",$_POST['TEUC_BANK_NAME']);
	$BRANCH_NAME = str_replace("'","\'",$_POST['TEUC_BRANCH_NAME']);
	$CHEQUE_DATE = $_POST['TEUC_CHEQUE_DATE'];


	$dateTime = date('d-m-Y H:i:s A');
	$aidR = $bank;
	$RECEIPT_ID = $receiptDetails->TET_RECEIPT_ID;
	$catId = $receiptDetails->TET_RECEIPT_CATEGORY_ID;
	$amtsR = $receiptDetails->PRICE;
	$tDateR = $receiptDetails->TET_RECEIPT_DATE;
	$flt_user = $_SESSION['userId'];
	$RECEIPT_PAYMENT_METHOD = $receiptDetails->TET_RECEIPT_PAYMENT_METHOD;
	$PAYMENT_STATUS = "Completed";                                      //$receiptDetails->PAYMENT_STATUS;
	$RECEIPT_NAME = $receiptDetails->TET_RECEIPT_NAME;
	$RECEIPT_TET_ID = $receiptDetails->RECEIPT_TET_ID;

	$this->db->select('T_FGLH_ID')->from('trust_event_receipt_category')->where(array('TET_RECEIPT_CATEGORY_ID'=> "$catId"));
	$query = $this->db->get();
	$T_DATAS = $query->first_row();
		
	// $comp_id = $T_DATAS->T_COMP_ID;


	if($catId != 4) {
		// if($catId == 1) {
			$lidR = $T_DATAS->T_FGLH_ID;
		// } else if($catId == 2) {
			// $lidR = $T_DATAS->T_FGLH_ID;
		// }else if($catId == 3) {
			// $lidR = $T_DATAS->T_FGLH_ID;
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

	$sql ="SELECT T_COMP_ID FROM `trust_event` where TET_ID =$RECEIPT_TET_ID";
	$query = $this->db->query($sql);
	$compId =$query->row()->T_COMP_ID;

	$this->db->query("INSERT INTO `trust_financial_ledger_transcations`
	 (`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_RECEIPT_ID`,`T_PAYMENT_METHOD`,	`T_RECEIPT_FAVOURING_NAME`,`T_CHEQUE_NO`,`T_BANK_NAME`,`T_BRANCH_NAME`,`T_CHEQUE_DATE`,`T_FLT_DEPOSIT_PAYMENT_DATE`,`T_PAYMENT_STATUS`,`T_COMP_ID`) 
	 VALUES ($lidR,'$countNoR',0,$amtsR,'$tDateR','$dateTime',' ','R1',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$RECEIPT_NAME','$CHEQUE_NO','$BANK_NAME','$BRANCH_NAME','$CHEQUE_DATE','$dDate','$PAYMENT_STATUS',$compId)");
	$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_RECEIPT_ID`,`T_PAYMENT_METHOD`,	`T_RECEIPT_FAVOURING_NAME`,`T_CHEQUE_NO`,`T_BANK_NAME`,`T_BRANCH_NAME`,`T_CHEQUE_DATE`,`T_FLT_DEPOSIT_PAYMENT_DATE`,`T_PAYMENT_STATUS`,`T_COMP_ID`) 
	 VALUES ($aidR,'$countNoR',$amtsR,0,'$tDateR','$dateTime',' ','R2',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$RECEIPT_NAME','$CHEQUE_NO','$BANK_NAME','$BRANCH_NAME','$CHEQUE_DATE','$dDate','$PAYMENT_STATUS',$compId)");

	$this->db->where('trust_finance_voucher_counter.T_FVC_ID',1);
	$this->db->update('trust_finance_voucher_counter', array('T_FVC_COUNTER'=>$counter));
}


///////////////////////////////////////////// temple like cheque remmitance end by adithya/////////////////////////////
		if($_POST) {
			$chequedate = $_POST['chequedate'];
			$receiptNo = $_POST['TET_RECEIPT_NO'];
			$bank = $_POST['bank'];
		}

		$this->db->where('TET_RECEIPT_NO',$receiptNo);
		$this->db->update('TRUST_EVENT_RECEIPT',
		 array('PAYMENT_CONFIRMED_BY_NAME'=>$_SESSION['userFullName'],
			   'CHEQUE_CREDITED_DATE'=>$chequedate,
			   'PAYMENT_STATUS'=>'Completed',
			   'PAYMENT_CONFIRMED_BY'=>$_SESSION['userId'],
			   'PAYMENT_DATE_TIME'=>date('d-m-Y H:i:s A'),
			   'PAYMENT_DATE'=>date('d-m-Y')));
		// $this->eventChequeRemmittance();

	
/////////////////////////////// new code end by adithya
		redirect("TrustEventEOD_Tally");
	}
	function get_financial_year($month) {
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
