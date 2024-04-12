<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class EventEOD extends CI_Controller {
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
			$this->load->model('EventEOD_modal','obj_eod',true);
			$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
			$this->load->model('Events_modal','obj_events',true);
			
		if(!isset($_SESSION['userId']))
			redirect('login');
		
		if($_SESSION['trustLogin'] == 1)
			redirect('Trust');
		
		$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
		// $this->output->enable_profiler(true);
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
		$data['whichTab'] = "eventEOD";
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		
		$conditionOne = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$data['eod_receipt_report'] = $this->obj_eod->get_all_field_eod_report($conditionOne,'ET_RECEIPT_DATE','desc', 10,$start,$fDate,$tDate);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EventEOD/index';
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
		
		if(isset($_SESSION['Event_EOD'])) {
			$this->load->view('header', $data);
			$this->load->view('eventEod');
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
		//$toDate =(date('Y')+1)."-03-31";
		if(@$_POST['todayDate'] != "") {
			$dateSelected = $_POST['todayDate'];
			$dateFilter = "AND ET_RECEIPT_DATE = '$dateSelected'";
			$data['dateFeild'] = $dateSelected;
		}else{
			$dateFilter = "";
			$data['dateFeild'] = date('d-m-Y');
		}

		$sql = "SELECT STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') as ReceiptDate FROM `EVENT_RECEIPT` WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."' and (AUTHORISED_STATUS='No' and ET_RECEIPT_CATEGORY_ID != '5')";

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
		$data['whichTab'] = "eventEOD";
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getEvents();
		
		$this->db->from('EVENT_EOD_TIME_SETTING');
		$query = $this->db->get();
		$data['timeSettings'] = $query->first_row('array');
		// var_dump($data['timeSettings']);
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		
		$conditionOne = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$data['eod_receipt_report'] = $this->obj_eod->get_all_field_eod_report_admin($conditionOne,'ET_RECEIPT_DATE','desc', 10,$start,$fDate,$tDate,$dateFilter);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EventEOD/eod_admin';
		$config['total_rows'] = $this->obj_eod->count_all_field_eod_report_admin($conditionOne,$fDate,$tDate,$dateFilter);
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
		
		if(isset($_SESSION['Event_EOD'])) {
			$this->load->view('header', $data);
			$this->load->view('eventEod_admin');
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
		$this->db->from('EVENT_EOD_TIME_SETTING');
		$query = $this->db->get();
		$data['timeSettings'] = $query->first_row('array');
		
		//GET ACTIVE EVENT
		$data['event'] = $this->obj_events->getEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		
		$sql = "SELECT `ET_RECEIPT_DATE`,`ET_RECEIPT_ISSUED_BY`,`ET_RECEIPT_ISSUED_BY_ID`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, (SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash , (SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque, (SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard', (SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit', (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount, SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `ET_RECEIPT_PRICE` ELSE '' END ) AS 'AUTHORISED_STATUS' FROM EVENT_RECEIPT INNER JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID where ET_ACTIVE = 1 and `ET_RECEIPT_DATE`= '".$_POST['eodDate']."' and ET_RECEIPT_CATEGORY_ID != 5 and ET_RECEIPT_ACTIVE = 1 and STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."' GROUP BY `ET_RECEIPT_ISSUED_BY`";
		
		$query = $this->db->query($sql);
		$data['eod_receipt_report'] = $query->result();
		if(isset($_SESSION['Event_EOD'])) {
			$this->load->view('header',$data);
			$this->load->view('eventEod_onDate');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function eventEod_save() {
		//******************************************************Laz Start********************************************************************
		$selectedDate = $_POST['selectedDate'];
		$sql = "SELECT 	ET_RECEIPT_ID,ET_RECEIPT_DATE, ET_RECEIPT_CATEGORY_ID, SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE) AS PRICE, ET_RECEIPT_PAYMENT_METHOD , FGLH_ID,ET_RECEIPT_ID,PAYMENT_STATUS,RECEIPT_ET_ID FROM `event_receipt` WHERE ET_RECEIPT_DATE = '$selectedDate'  AND ET_RECEIPT_PAYMENT_METHOD = 'Cash' and ET_RECEIPT_ACTIVE=1 GROUP BY ET_RECEIPT_PAYMENT_METHOD, ET_RECEIPT_CATEGORY_ID 
		UNION
			 SELECT ET_RECEIPT_ID,ET_RECEIPT_DATE, ET_RECEIPT_CATEGORY_ID, (ET_RECEIPT_PRICE + POSTAGE_PRICE)  AS PRICE, ET_RECEIPT_PAYMENT_METHOD, FGLH_ID,ET_RECEIPT_ID,PAYMENT_STATUS,RECEIPT_ET_ID FROM `event_receipt` WHERE ET_RECEIPT_DATE = '$selectedDate' AND ET_RECEIPT_PAYMENT_METHOD = 'Direct Credit' and ET_RECEIPT_ACTIVE=1 
			 UNION
		SELECT 	ET_RECEIPT_ID,ET_RECEIPT_DATE, ET_RECEIPT_CATEGORY_ID, (ET_RECEIPT_PRICE + POSTAGE_PRICE)  AS PRICE, ET_RECEIPT_PAYMENT_METHOD, FGLH_ID,ET_RECEIPT_ID,PAYMENT_STATUS,RECEIPT_ET_ID FROM `event_receipt` WHERE ET_RECEIPT_DATE = '$selectedDate' AND ET_RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' and ET_RECEIPT_ACTIVE=1 ORDER BY ET_RECEIPT_PAYMENT_METHOD,ET_RECEIPT_CATEGORY_ID";
		$query = $this->db->query($sql);
		$eventReceiptDetails = $query->result();
		$dateTime = date('d-m-Y H:i:s A');

		foreach($eventReceiptDetails as $result) { 

			if($result->ET_RECEIPT_PAYMENT_METHOD == "Cash") {
				$aidR = 21;
				$RECEIPT_ID =$result->ET_RECEIPT_ID;
			} else { 
				$aidR = $result->FGLH_ID;
				$RECEIPT_ID = $result->ET_RECEIPT_ID;
			}
			$catId = $result->ET_RECEIPT_CATEGORY_ID;
			$amtsR = $result->PRICE;
			$tDateR = $result->ET_RECEIPT_DATE;
			$naration = "";
			$flt_user = $_SESSION['userId'];
			$RECEIPT_PAYMENT_METHOD = $result->ET_RECEIPT_PAYMENT_METHOD;
			$PAYMENT_STATUS = $result->PAYMENT_STATUS;
			$RECEIPT_ET_ID = $result->RECEIPT_ET_ID;
			
            // ADDED BY ADITHYA
			$this->db->select('ET_FGLH_ID')->from('event_receipt_category')->where(array('ET_RECEIPT_CATEGORY_ID'=> "$catId"));
	        $query = $this->db->get();
	        $T_DATAS = $query->first_row();
			if($catId != 4) {
				// if($catId == 1) {
					$lidR = $T_DATAS->ET_FGLH_ID ;
				// } else if($catId == 2) {
				// 	$lidR = 30;
				// }else if($catId == 3) {
				// 	$lidR = 31;
				// }
			}

			$this->db->select()->from('finance_voucher_counter')
			->where(array('finance_voucher_counter.FVC_ID'=>'1'));
			$query = $this->db->get();
			$deityCounter = $query->first_row();
			$counter = $deityCounter->FVC_COUNTER+1;
			
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			$countNoR = $deityCounter->FVC_ABBR1 ."/".$datMonth."/".$deityCounter->FVC_ABBR2."/".$counter;

			$sql ="SELECT COMP_ID FROM `event` where ET_ID = $RECEIPT_ET_ID";
			$query = $this->db->query($sql);
			$compId =$query->row()->COMP_ID;
				
			$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`RECEIPT_ID`,`PAYMENT_METHOD`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($lidR,'$countNoR',0,$amtsR,
				'$tDateR','$dateTime','$naration','R1',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS',$compId)");
			$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`RECEIPT_ID`,`PAYMENT_METHOD`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($aidR,'$countNoR',$amtsR,0,
					'$tDateR','$dateTime','$naration','R2',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS',$compId)");

			$this->db->where('finance_voucher_counter.FVC_ID',1);
			$this->db->update('finance_voucher_counter', array('FVC_COUNTER'=>$counter));

		}
			
		//******************************************************Laz End**********************************************************************

		$event_receipt = array(
			"EOD_CONFIRMED_BY_ID"=>$_SESSION['userId'],
			"EOD_CONFIRMED_BY_NAME"=>$_SESSION['userFullName'],
			"EOD_CONFIRMED_DATE_TIME"=>date('d-m-Y h:i:s A'),
			"EOD_CONFIRMED_DATE"=>date('d-m-Y')
		);

		$this->db->where(array(
			'ET_RECEIPT_DATE'=>$_POST['selectedDate'],
			'ET_RECEIPT_ACTIVE' => 1
		));
		
		$this->db->update('EVENT_RECEIPT', $event_receipt);

		$where_inkind = " WHERE ET_RECEIPT_ACTIVE = 1 AND STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') <= STR_TO_DATE('".$_POST['selectedDate']."','%d-%m-%Y') AND EOD_CONFIRMED_BY_ID = 0 AND ET_RECEIPT_CATEGORY_ID = 4";
		if($this->obj_eod->get_all_event_Inkind_which_are_not_authorised($where_inkind) > 0){
			//UPDATE CODE
			$query = $this->obj_eod->Update_All_event_Inkind_which_are_not_authorised($where_inkind);
		}

		$where = array(
			"ET_RECEIPT_DATE"=>$_POST['selectedDate'],
			"ET_RECEIPT_ACTIVE"=>"1",
			"ET_RECEIPT_PAYMENT_METHOD"=>"Cheque"
		);
		
		$this->db->from("EVENT_RECEIPT")->where($where);
		$query = $this->db->get();
		$chequeDetails = $query->result();
		
		foreach($chequeDetails as $result) {
			$PRICE = $result->ET_RECEIPT_PRICE + $result->POSTAGE_PRICE;
			$data = array(
				'EUC_BY_ID'=>@$_SESSION['userId'],
				'EUC_BY_NAME'=>@$_SESSION['userFullName'],
				'EUC_EOD_DATE'=>date('Y-m-d', strtotime($_POST['selectedDate'])),
				'ET_RECEIPT_ID'=>$result->ET_RECEIPT_ID,
				'EUC_CHEQUE'=>$PRICE,
				'EUC_DATE_TIME'=>date('d-m-Y h:i:s A'),
				'EUC_DATE'=>date('Y-m-d'),
				'EUC_CHEQUE_NO'=>$result->CHEQUE_NO,
				'EUC_CHEQUE_DATE'=>$result->CHEQUE_DATE,
				'EUC_BANK_NAME'=>$result->BANK_NAME,
				'EUC_BRANCH_NAME'=>$result->BRANCH_NAME,
				'EUC_IS_DEPOSITED'=>"0"
			);
			
			// echo json_encode($data);
			$this->db->insert('EVENT_USER_COLLECTION',$data);
			$id = $this->db->insert_id();

			$EVENT_USER_COLLECTION_HISTORY = array(
				'EUC_ID'=>$id,
				'EUCH_BY_ID'=>@$_SESSION['userId'],
				'EUCH_BY_NAME'=>@$_SESSION['userFullName'],
				'EUCH_DATE_TIME'=>date('d-m-Y h:i:s A'),
				'EUCH_DATE'=>date('Y-m-d'),
			);
			
			$this->db->insert('EVENT_USER_COLLECTION_HISTORY',$EVENT_USER_COLLECTION_HISTORY);
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
		//$fromDate = date('Y')."-04-01";
		$toDate = $_POST['date'];
		$sql = "SELECT STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') as ReceiptDate FROM `EVENT_RECEIPT` WHERE STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') < STR_TO_DATE('".$toDate."','%d-%m-%Y') and ET_RECEIPT_ACTIVE = 1 and EOD_CONFIRMED_BY_ID = 0";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) { 
			echo $query->num_rows();
		} else {
			echo "success";
		}
	}

	function eventEod_usercollection($start=0) {
		//whichTab
		$data['whichTab'] = "eventEOD";
		
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
		$data['event'] = $this->obj_events->getEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		$condt = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$condt3 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$condt4 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
				
		$conditionOne = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EventEOD/eventEod_usercollection';
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
		
		if(isset($_SESSION['Event_EOD'])) {
			$this->load->view('header',$data);
			$this->load->view('eventEod_usercollection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//for admin view button click in eventEod_onDate
	function getDataOnFilter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "eventEOD";
				
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
		$data['event'] = $this->obj_events->getEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
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
				
				$conditionOne = array('ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
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
			$conditionOne = array('ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} else if(@$pMethod != "All") {
			$conditionOne = array('ET_RECEIPT_PAYMENT_METHOD' => $pMethod,'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt1 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt2 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt3 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt4 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EventEOD/getDataOnFilter/'.$id;
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
		$this->load->view('eventEodUsercollection');
		$this->load->view('footer_home');
	}
	
	function eventEodUsercollection($start=0) {
		//whichTab
		$data['whichTab'] = "eventEOD";
		
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
		$data['event'] = $this->obj_events->getEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		$condt = array('ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$condt1 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$condt2 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$condt3 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$condt4 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
		
		$conditionOne = array('ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'ET_ACTIVE' => 1);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EventEOD/eventEodUsercollection';
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
		
		if(isset($_SESSION['Event_EOD'])) {
			$this->load->view('header',$data);
			$this->load->view('eventEodUsercollection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//EOD for Logged in user
	function eventEod_collection($start=0) {
		//whichTab
		$data['whichTab'] = "eventEOD";
		
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
		$data['event'] = $this->obj_events->getEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		$condt = array('ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$condt1 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$condt2 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$condt3 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$condt4 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
		
		$conditionOne = array('ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EventEOD/eventEod_collection';
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
		
		if(isset($_SESSION['Event_EOD'])) {
			$this->load->view('header',$data);
			$this->load->view('eventEod_collection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function get_data_on_filter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "eventEOD";
				
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
		$data['event'] = $this->obj_events->getEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
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
				
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
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
			$conditionOne = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} else if(@$pMethod != "All") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $pMethod,'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt3 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt4 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EventEOD/get_data_on_filter/'.$id;
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
		$this->load->view('eventEod_usercollection');
		$this->load->view('footer_home');
	}
	
	//EOD for Logged in user
	function get_data_on_userFilter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "eventEOD";
		
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
		$data['event'] = $this->obj_events->getEvents();
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
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
				
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
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
			$conditionOne = array('ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} else if(@$pMethod != "All") {
			$conditionOne = array('ET_RECEIPT_PAYMENT_METHOD' => $pMethod,'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start,$whereOne);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt1 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt2 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt3 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
		$condt4 = array('ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$userId,'ET_RECEIPT_DATE'=>$userDate,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt,$whereOne);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1,$whereOne);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2,$whereOne);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3,$whereOne);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4,$whereOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EventEOD/get_data_on_userFilter/'.$id;
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
		$this->load->view('eventEod_collection');
		$this->load->view('footer_home');
	}
	
	//APPROVE THE DATA
	function approve_Submit() {
		$data['whichTab'] = "eventEOD";	
		
		//VALUE OF CHECKBOX SELECTED OR NOT SELECTED
		$selCondition = $this->input->post('checkVal');
		
		//GET EVENT ID
		$this->db->select()->from('EVENT')->where(array('ET_ACTIVE'=>'1'));
		$query = $this->db->get();
		$event = $query->first_row();
		
		//GET FINANCIAL_YEAR DATE
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$whereOne = "STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."'";
		
		if($selCondition == "all_users") { //ALL_USERS CHECKBOX
			if(@$this->input->post('paymentApprove') == "All") {
				$condition = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'ET_RECEIPT_DATE'=>$_POST['dateChk'],'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'RECEIPT_ET_ID' => $event->ET_ID);
			}  else if(@$this->input->post('paymentApprove') != "All" ) {
				$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'),'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'ET_RECEIPT_DATE'=>$_POST['dateChk'],'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'RECEIPT_ET_ID' => $event->ET_ID);
			} 
			//UPDATE CODE
			$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'),'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
			$this->obj_eod->update_authorise($condition,$data,$whereOne);
		} else if($selCondition == "this_page") { //THIS_PAGE CHECKBOX
			$selectedId = $this->input->post('selectApprove');
			$arrSelect = explode(',' ,$selectedId);
			for($i = 0; $i <= count($arrSelect) - 1; $i++) {
				if(@$this->input->post('paymentApprove') == "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'ET_RECEIPT_DATE'=>$_POST['dateChk'],'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'RECEIPT_ET_ID' => $event->ET_ID);
				} else if(@$this->input->post('paymentApprove') != "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'ET_RECEIPT_DATE'=>$_POST['dateChk'],'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'ET_ACTIVE' => 1);
				} 
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'RECEIPT_ET_ID' => $event->ET_ID);
				$this->obj_eod->update_authorise($condition,$data,$whereOne);
			}
		} else { //WITHOUT CHECKBOX
			$selectedId = $this->input->post('selectApprove');
			$arrSelect = explode(',' ,$selectedId);
			for($i = 0; $i <= count($arrSelect) - 1; $i++) {
				if(@$this->input->post('paymentApprove') == "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'ET_RECEIPT_DATE'=>$_POST['dateChk'],'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'RECEIPT_ET_ID' => $event->ET_ID);
				} else if(@$this->input->post('paymentApprove') != "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'ET_RECEIPT_DATE'=>$_POST['dateChk'],'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID !=' => 4,'RECEIPT_ET_ID' => $event->ET_ID);
				} 
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
				$this->obj_eod->update_authorise($condition,$data,$whereOne);
			}
		}
		$this->session->set_userdata('PM', $this->input->post('paymentApprove'));
		redirect('/EventEOD/eventEod_usercollection'); //get_data_on_filter/0
	}
}