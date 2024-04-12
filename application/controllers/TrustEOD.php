<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TrustEOD extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
			$this->load->helper('string');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->helper(array('form', 'url'));
			$this->load->helper('date');
			$this->load->database();
			date_default_timezone_set('Asia/Kolkata');
			$this->load->model('TrustReport_model','obj_report',true);
			$this->load->model('TrustEOD_modal','obj_eod',true);
			$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
			$this->load->model('Events_modal','obj_events',true);
			
		if(!isset($_SESSION['userId']))
			redirect('login');
		
		if($_SESSION['trustLogin'] != 1)
			redirect('Trust');
		
		$this->db->select()->from('TRUST_EVENT')->where("TET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
		// $this->output->enable_profiler(true);
	}
	
	public function index($start = 0) {
	    //if(@$_SESSION['eventActiveCount'] == 0)
	    //redirect('login');
		unset($_SESSION['selectedDate']);
		unset($_SESSION['receiptType']);

		if(@$_SESSION['userGroup'] == 1 || @$_SESSION['userGroup'] == 6 || @$_SESSION['userGroup'] == 2)
		redirect('TrustEOD/eod_admin');
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		
		//For Menu Selection
		$data['whichTab'] = "hallEODReport";
		
		$conditionOne = array('ENTERED_BY' => $this->session->userdata('userId'));
		$data['eod_receipt_report'] = $this->obj_eod->get_all_field_eod_report($conditionOne,'RECEIPT_DATE','desc', 10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEOD/index';
		$config['total_rows'] = $this->obj_eod->count_all_field_eod_report($conditionOne);
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
		
		if(isset($_SESSION['E.O.D_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trustEod');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function eod_admin($start=0) {
		//print_r($this->session);

		$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1];
		
		//$fromDate = date('Y')."-04-01";
		//$toDate =(date('Y')+1)."-03-31";

		$sql = "SELECT STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') as ReceiptDate FROM `TRUST_RECEIPT` WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."' and (AUTHORISED_STATUS='No'and RECEIPT_CATEGORY_ID != '4')";

		$query = $this->db->query($sql);

		unset($_SESSION['selectedDate']);
		unset($_SESSION['receiptType']);
		
		if(@$_SESSION['userGroup'] == 1 || @$_SESSION['userGroup'] == 6 || @$_SESSION['userGroup'] == 2) {
			
		} else {
			redirect('TrustEOD');
		}
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		
		//For Menu Selection
		$data['whichTab'] = "hallEODReport";
		
		$this->db->from('TRUST_EOD_TIME_SETTING');
		$query = $this->db->get();
		$data['timeSettings'] = $query->first_row('array');
		// var_dump($data['timeSettings']);
		$conditionOne = array('ENTERED_BY' => $this->session->userdata('userId'));
		$data['eod_receipt_report'] = $this->obj_eod->get_all_field_eod_report_admin($conditionOne,'RECEIPT_DATE','desc', 10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEOD/eod_admin';
		$config['total_rows'] = $this->obj_eod->count_all_field_eod_report_admin($conditionOne);
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
		
		if(isset($_SESSION['E.O.D_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trustEod_admin');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function trustEod_onDate() {	
		unset($_SESSION['all_users']);
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link2'] = $actual_link;

		$data['whichTab'] = "hallEODReport";
		$data['selectedDate'] = $_POST['eodDate'];
		$_SESSION['selectedDate'] = $_POST['eodDate'];
		$data['receiptType'] = $_POST['receiptType'];
		$_SESSION['receiptType'] = $_POST['receiptType'];
		
		//TIME SETTINGS
		$this->db->from('TRUST_EOD_TIME_SETTING');
		$query = $this->db->get();
		$data['timeSettings'] = $query->first_row('array');
		
		$sql = "SELECT `RECEIPT_DATE`,`ENTERED_BY_NAME`,`ENTERED_BY`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `FH_AMOUNT` ELSE '' END ) AS Cash , SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `FH_AMOUNT` ELSE '' END ) AS Cheque, SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `FH_AMOUNT` ELSE '' END ) AS 'Card', SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `FH_AMOUNT` ELSE '' END ) AS 'directCredit', SUM(FH_AMOUNT) AS TotalAmount, SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `FH_AMOUNT` ELSE '' END ) AS 'AUTHORISED_STATUS' FROM TRUST_RECEIPT where `RECEIPT_DATE`= '".$_POST['eodDate']."' and TR_ACTIVE = 1  and RECEIPT_CATEGORY_ID!=1   GROUP BY `ENTERED_BY`";
		
		$query = $this->db->query($sql);
		$data['eod_receipt_report'] = $query->result();
		
		if(isset($_SESSION['E.O.D_Report'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/trustEod_onDate');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function trustEod_save() {
//////////////////////// Adding the temple like code by adithya on 12-1-24 start
        $selectedDate = @$_POST['selectedDate'];
        $sql = "SELECT 	TR_ID,RECEIPT_DATE, 
                FH_ID,SUM(FH_AMOUNT) + SUM(POSTAGE_PRICE) 
                AS PRICE,
                RECEIPT_PAYMENT_METHOD , T_FGLH_ID,TR_ID,PAYMENT_STATUS 
        FROM `trust_receipt` 
        WHERE RECEIPT_DATE = '$selectedDate'  
        AND RECEIPT_PAYMENT_METHOD = 'Cash' 
        and TR_ACTIVE=1 
        GROUP BY RECEIPT_PAYMENT_METHOD, FH_ID 
        UNION
		SELECT 	TR_ID,RECEIPT_DATE, 
                FH_ID,SUM(FH_AMOUNT) + SUM(POSTAGE_PRICE) 
                AS PRICE,
                RECEIPT_PAYMENT_METHOD , T_FGLH_ID,TR_ID,PAYMENT_STATUS 
        FROM `trust_receipt` 
        WHERE RECEIPT_DATE = '$selectedDate'  
        AND RECEIPT_PAYMENT_METHOD = 'Direct Credit' 
        and TR_ACTIVE=1
		GROUP BY RECEIPT_PAYMENT_METHOD, FH_ID  
		UNION
		SELECT 	TR_ID,RECEIPT_DATE, 
                FH_ID,SUM(FH_AMOUNT) + SUM(POSTAGE_PRICE) 
                AS PRICE,
                RECEIPT_PAYMENT_METHOD , T_FGLH_ID,TR_ID,PAYMENT_STATUS 
        FROM `trust_receipt` 
        WHERE RECEIPT_DATE = '$selectedDate'  
        AND RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' 
        and TR_ACTIVE=1
		GROUP BY RECEIPT_PAYMENT_METHOD, FH_ID 
        ORDER BY RECEIPT_PAYMENT_METHOD,FH_ID";

        $query = $this->db->query($sql);
		$receiptDetails = $query->result();
		$dateTime = date('d-m-Y H:i:s A');

///////////////////////// foreach start
foreach($receiptDetails as $result) { 

	if($result->RECEIPT_PAYMENT_METHOD == "Cash") {
		$aidR = 44;
		$RECEIPT_ID = $result->TR_ID;
	} else { 
		$aidR = $result->T_FGLH_ID;
		$RECEIPT_ID = $result->TR_ID;
	}
	$catId = $result->FH_ID;
   // ADDED BY ADITHYA 
	$this->db->select('T_COMP_ID,T_FGLH_ID')->from('financial_head')
	->where(array('FH_ID'=>$catId));
	
	$query = $this->db->get();
	$firstRow = $query->first_row();
	$T_comp_id = $firstRow->T_COMP_ID;
	$lidR = $firstRow->T_FGLH_ID;
    

  // ADDED BY ADITHYA ABOVE
	$amtsR = $result->PRICE;
	$tDateR = $result->RECEIPT_DATE;
	$naration = "";
	$flt_user = $_SESSION['userId'];
	$RECEIPT_PAYMENT_METHOD = $result->RECEIPT_PAYMENT_METHOD;
	$PAYMENT_STATUS = $result->PAYMENT_STATUS;
	// if($catId != 5 || $catId != 10) {
			// if($catId == 1) {
				
			// } else if($catId == 2) {
			// 	$lidR = $firstRow->T_FGLH_ID;
			// }else if($catId == 3) {
			// 	$lidR = $firstRow->T_FGLH_ID;
			// }else if($catId == 9) {
			// 		$lidR =$firstRow->T_FGLH_ID;
			// 	}
			// else if($catId == 4) {
			// 	if($deityId==6){
			// 		$lidR = 77;				//Tirupati Devara Hundi Kanike ONLY FOR SLVT
			// 	} else {
			// 		$lidR = 20;
			// 	}
			// }else if($catId == 6) {
			// 	$lidR = 26;
			// }else if($catId == 7) {
			// 	$lidR = 25;
			// }else if($catId == 8) {
			// 	$lidR = 22;
			// }else if($catId == 9) {
			// 	$lidR = 23;
			// }
	// }


	// if($catId == 8 || $catId == 9){
	// 	$compId = 2;
	// } else {
	// 	$compId = 1;
	// }

	$this->db->select()->from('trust_finance_voucher_counter')
	->where(array('trust_finance_voucher_counter.T_FVC_ID'=>'1'));
	$query = $this->db->get();
	$deityCounter = $query->first_row();
	$counter = $deityCounter->T_FVC_COUNTER+1;
	
	$dfMonth = $this->obj_admin_settings->get_financial_month();
	$datMonth = $this->get_financial_year($dfMonth);
	$countNoR = $deityCounter->T_FVC_ABBR1 ."/".$datMonth."/".$deityCounter->T_FVC_ABBR2."/".$counter;

	$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_RECEIPT_ID`,`T_PAYMENT_METHOD`,`T_PAYMENT_STATUS`,`T_COMP_ID`) 
	VALUES ($lidR,'$countNoR',0,$amtsR,'$tDateR','$dateTime','$naration','R1',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS','$T_comp_id')");
	$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_RECEIPT_ID`,`T_PAYMENT_METHOD`,`T_PAYMENT_STATUS`,`T_COMP_ID`) 
	VALUES ($aidR,'$countNoR',$amtsR,0,'$tDateR','$dateTime','$naration','R2',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS','$T_comp_id')");

	$this->db->where('trust_finance_voucher_counter.T_FVC_ID',1);
	$this->db->update('trust_finance_voucher_counter', array('T_FVC_COUNTER'=>$counter));
}
// // //////////////////////// foreach end
// // /////////////////////// Adding the temple like code by adithya on 12-1-24 end
		
		$where = array(
			"RECEIPT_DATE"=>@$_POST['selectedDate'],
			"TR_ACTIVE"=>"1",
			"RECEIPT_PAYMENT_METHOD"=>"Cheque"
		);
		
		$this->db->from("TRUST_RECEIPT")->where($where);
		$query = $this->db->get();
		$chequeDetails = $query->result();
		foreach($chequeDetails as $result) {			
			$data = array(
				'TUC_BY_ID'=>@$_SESSION['userId'],
				'TUC_BY_NAME'=>@$_SESSION['userFullName'],
				'TUC_EOD_DATE'=>date('Y-m-d', strtotime($_POST['selectedDate'])),
				'TUC_CREDIT'=>$result->FH_AMOUNT,
				'TUC_DIRECT_CREDIT'=>"0",
				'TUC_DEBIT_CREDIT_CARD'=>"0",
				'TUC_DEBIT_CREDIT_CARD'=>"0",
				'TUC_CREDIT'=>$result->FH_AMOUNT,
				'TUC_CASH_CHEQUE'=>$result->FH_AMOUNT,
				'TUC_CASH'=>"0",
				'TUC_LEDGER_ID'=>$result->T_FGLH_ID,
				'TUC_RECEIPT_ID'=> $result->TR_ID,
				'TUC_CHEQUE'=>$result->FH_AMOUNT,
				'TUC_DATE_TIME'=>date('d-m-Y h:i:s A'),
				'TUC_DATE'=>date('Y-m-d'),
				'TUC_CHEQUE_NO'=>$result->CHEQUE_NO,
				'TUC_CHEQUE_DATE'=>$result->CHEQUE_DATE,
				'TUC_BANK_NAME'=>$result->BANK_NAME,
				'TUC_BRANCH_NAME'=>$result->BRANCH_NAME,
				'TUC_IS_DEPOSITED'=>"0"
			);
			
			// echo json_encode($data);
			$this->db->insert('TRUST_USER_COLLECTION',$data);
			$id = $this->db->insert_id();
			
			// $TRUST_USER_COLLECTION_HISTORY = array(
			// 	'TUC_ID'=>$id,
			// 	'TUCH_BY_ID'=>@$_SESSION['userId'],
			// 	'TUCH_BY_NAME'=>@$_SESSION['userFullName'],
			// 	'TUCH_DATE_TIME'=>date('d-m-Y h:i:s A'),
			// 	'TUCH_DATE'=>date('Y-m-d'));
			
			// $this->db->insert('TRUST_USER_COLLECTION_HISTORY',$TRUST_USER_COLLECTION_HISTORY);
		}
		
		$trust_receipt = array(
			"EOD_CONFIRMED_BY_ID"=>$_SESSION['userId'],
			"EOD_CONFIRMED_BY_NAME"=>$_SESSION['userFullName'],
			"EOD_CONFIRMED_DATE_TIME"=>date('d-m-Y h:i:s A'),
			"EOD_CONFIRMED_DATE"=>date('d-m-Y')
		);
		$this->db->where(array(
			'RECEIPT_DATE'=>@$_POST['selectedDate'],
			'TR_ACTIVE' => 1
		));
		$this->db->update('TRUST_RECEIPT', $trust_receipt);

		// BECAUSE OF THIS 2 RECORDS ARE INSERTED IN TRUST USER COLLECTION TABLE 1 FOR CHEQUE ANOTHER FOR REST OF PAYMENT METHOD
		$totalCashAmt = ((int)@$_POST['cash']);
		$data = array(
			'TUC_BY_ID'=>@$_SESSION['userId'],
			'TUC_BY_NAME'=>@$_SESSION['userFullName'],
			'TUC_EOD_DATE'=>date('Y-m-d', strtotime(@$_POST['selectedDate'])),
			'TUC_CREDIT'=>((int)@$_POST['totalAmt'] - (int)@$_POST['cheque']),
			'TUC_CASH'=>@$_POST['cash'],
			'TUC_CHEQUE'=>"0",
			'TUC_DIRECT_CREDIT'=>@$_POST['directCredit'],
			'TUC_DEBIT_CREDIT_CARD'=>@$_POST['card'],
			'TUC_CASH_CHEQUE'=>@$totalCashAmt,
			'TUC_DATE_TIME'=>date('d-m-Y h:i:s A'),
			'TUC_DATE'=>date('Y-m-d')
		);
		$this->db->insert('TRUST_USER_COLLECTION',$data);
		$id = $this->db->insert_id();
		
		// TILL HERE ADITHYA
		
		// $TRUST_USER_COLLECTION_HISTORY = array(
		// 	'TUC_ID'=>$id,
		// 	'TUCH_BY_ID'=>@$_SESSION['userId'],
		// 	'TUCH_BY_NAME'=>@$_SESSION['userFullName'],
		// 	'TUCH_DATE_TIME'=>date('d-m-Y h:i:s A'),
		// 	'TUCH_DATE'=>date('Y-m-d'),
		// );
		// $this->db->insert('TRUST_USER_COLLECTION_HISTORY',$TRUST_USER_COLLECTION_HISTORY);
		
		
		echo "success";
	
}


	// ADDED BY ADITHYA START
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
	// ADDED BY ADITHYA END
	
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
		$sql = "SELECT STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') as ReceiptDate FROM `TRUST_RECEIPT` WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') < STR_TO_DATE('".$toDate."','%d-%m-%Y') and TR_ACTIVE = 1 and (EOD_CONFIRMED_BY_ID IS NULL OR EOD_CONFIRMED_BY_ID = 0)";
		
		$query = $this->db->query($sql);	
		if ($query->num_rows() > 0) { 
			echo $query->num_rows();
		} else {
			echo "success";
		}
	}

	function trustEod_usercollection($start=0) {
		//whichTab
		$data['whichTab'] = "hallEODReport";
		
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
		
		$condt = array('AUTHORISED_STATUS' => 'No','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$condt1 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Cash','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$condt2 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Cheque','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$condt3 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$condt4 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		$conditionOne = array('AUTHORISED_STATUS' => 'No','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEOD/trustEod_usercollection';
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne);
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
		
		if(isset($_SESSION['E.O.D_Report'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/trustEod_usercollection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//for admin view button click in trustEod_onDate
	function getDataOnFilter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "hallEODReport";
				
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
				
				$conditionOne = array('ENTERED_BY' => $users,'TR_ACTIVE'=>1);
				$receipt_report = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
				if(count($receipt_report) == 0) {
					$users = "All Users";
				}
			}
		} else {
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);
		}
		
		if(@$pMethod == "All") {
			$conditionOne = array('TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		} else if(@$pMethod != "All") {
			$conditionOne = array('RECEIPT_PAYMENT_METHOD' => $pMethod,'TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEOD/getDataOnFilter/'.$id;
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne);
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
		$this->load->view('trust/trustEodUsercollection');
		$this->load->view('footer_home');
	}
	
	function trustEodUsercollection($start=0) {
		//whichTab
		$data['whichTab'] = "hallEODReport";
		
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
		
		$condt = array('TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		$conditionOne = array('TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEOD/trustEodUsercollection';
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne);
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
		
		if(isset($_SESSION['E.O.D_Report'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/trustEodUsercollection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//EOD for Logged in user
	function trustEod_collection($start=0) {
		//whichTab
		$data['whichTab'] = "hallEODReport";
		
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
		
		$condt = array('TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		$conditionOne = array('TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEOD/trustEod_collection';
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne);
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
		
		if(isset($_SESSION['E.O.D_Report'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/trustEod_collection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function get_data_on_filter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "hallEODReport";
				
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
				
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'ENTERED_BY' => $users,'TR_ACTIVE'=>1);
				$receipt_report = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
				if(count($receipt_report) == 0) {
					$users = "All Users";
				}
			}
		} else {
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);
		}
		
		if(@$pMethod == "All") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		} else if(@$pMethod != "All") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => $pMethod,'TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('AUTHORISED_STATUS' => 'No','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt1 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Cash','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt2 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Cheque','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt3 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt4 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEOD/get_data_on_filter/'.$id;
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne);
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
		$this->load->view('trust/trustEod_usercollection');
		$this->load->view('footer_home');
	}
	
	//EOD for Logged in user
	function get_data_on_userFilter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "hallEODReport";
		
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
				
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'ENTERED_BY' => $users,'TR_ACTIVE'=>1);
				$receipt_report = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
				if(count($receipt_report) == 0) {
					$users = "All Users";
				}
			}
		} else {
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);
		}
		
		if(@$pMethod == "All") {
			$conditionOne = array('TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		} else if(@$pMethod != "All") {
			$conditionOne = array('RECEIPT_PAYMENT_METHOD' => $pMethod,'TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
		$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TR_ACTIVE'=>1,'ENTERED_BY'=>$userId,'RECEIPT_DATE'=>$userDate);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustEOD/get_data_on_userFilter/'.$id;
		$config['total_rows'] = $this->obj_eod->count_rows_receipt_report($conditionOne);
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
		$this->load->view('trust/trustEod_collection');
		$this->load->view('footer_home');
	}
	
	//APPROVE THE DATA
	function approve_Submit() {
		$data['whichTab'] = "hallEODReport";	
		//VALUE OF CHECKBOX SELECTED OR NOT SELECTED
		$selCondition = $this->input->post('checkVal');
		if($selCondition == "all_users") { //ALL_USERS CHECKBOX
			if(@$this->input->post('paymentApprove') == "All") {
				$condition = array('AUTHORISED_STATUS' => 'No','TR_ACTIVE'=>1,'ENTERED_BY'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk']);
			}  else if(@$this->input->post('paymentApprove') != "All" ) {
				$condition = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'),'TR_ACTIVE'=>1,'ENTERED_BY'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk']);
			} 
			//UPDATE CODE
			$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'),'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'TR_ACTIVE'=>1);
			$this->obj_eod->update_authorise($condition,$data);
		} else if($selCondition == "this_page") { //THIS_PAGE CHECKBOX
			$selectedId = $this->input->post('selectApprove');
			$arrSelect = explode(',' ,$selectedId);
			for($i = 0; $i <= count($arrSelect) - 1; $i++) {
				if(@$this->input->post('paymentApprove') == "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TR_ID' => $arrSelect[$i],'TR_ACTIVE'=>1,'ENTERED_BY'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk']);
				} else if(@$this->input->post('paymentApprove') != "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'TR_ID' => $arrSelect[$i],'TR_ACTIVE'=>1,'ENTERED_BY'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk']);
				} 
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'TR_ACTIVE'=>1);
				$this->obj_eod->update_authorise($condition,$data);
			}
		} else { //WITHOUT CHECKBOX
			$selectedId = $this->input->post('selectApprove');
			$arrSelect = explode(',' ,$selectedId);
			for($i = 0; $i <= count($arrSelect) - 1; $i++) {
				if(@$this->input->post('paymentApprove') == "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TR_ID' => $arrSelect[$i],'TR_ACTIVE'=>1,'ENTERED_BY'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk']);
				} else if(@$this->input->post('paymentApprove') != "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'TR_ID' => $arrSelect[$i],'TR_ACTIVE'=>1,'ENTERED_BY'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk']);
				} 
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'TR_ACTIVE'=>1);
				$this->obj_eod->update_authorise($condition,$data);
			}
		}
		$this->session->set_userdata('PM', $this->input->post('paymentApprove'));
		redirect('/TrustEOD/trustEod_usercollection'); //get_data_on_filter/0
	}
}
 