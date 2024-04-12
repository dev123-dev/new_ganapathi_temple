<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class EOD extends CI_Controller {
		
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
			$this->load->model('EOD_modal','obj_eod',true);
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
		unset($_SESSION['selectedDate']);
		unset($_SESSION['receiptType']);

		if(@$_SESSION['userGroup'] == 1 || @$_SESSION['userGroup'] == 6 || @$_SESSION['userGroup'] == 2)
			redirect('EOD/eod_admin');
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		
		//For Menu Selection
		$data['whichTab'] = "deityEOD";
		
		$conditionOne = array('RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$data['eod_receipt_report'] = $this->obj_eod->get_all_field_eod_report($conditionOne,'RECEIPT_DATE','desc', 10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EOD/index';
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
		
		if(isset($_SESSION['Deity_EOD'])) {
			$this->load->view('header', $data);
			$this->load->view('deityEod');
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
			$dateFilter = "AND RECEIPT_DATE = '$dateSelected'";
			$data['dateFeild'] = $dateSelected;
		}else{
			$dateFilter = "";
			$data['dateFeild'] = date('d-m-Y');
		}
		
		$sql = "SELECT STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') as ReceiptDate FROM `DEITY_RECEIPT` WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."' and (AUTHORISED_STATUS='No' and RECEIPT_CATEGORY_ID != '5')";

		$query = $this->db->query($sql);

		unset($_SESSION['selectedDate']);
		unset($_SESSION['receiptType']);
		
		if(@$_SESSION['userGroup'] == 1 || @$_SESSION['userGroup'] == 6 || @$_SESSION['userGroup'] == 2) {
		
		} else {
			redirect('EOD');
		}
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		 
		//For Menu Selection
		$data['whichTab'] = "deityEOD";
		   
		$this->db->from('EOD_TIME_SETTING');
		$query = $this->db->get();
	        
		$data['timeSettings'] = $query->first_row('array');
		// var_dump($data['timeSettings']);
		$conditionOne = array('RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$data['eod_receipt_report'] = $this->obj_eod->get_all_field_eod_report_admin($conditionOne,'RECEIPT_DATE','desc', 10,$start,$dateFilter);
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EOD/eod_admin';
		$config['total_rows'] = $this->obj_eod->count_all_field_eod_report_admin($conditionOne,$dateFilter);
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
		
		if(isset($_SESSION['Deity_EOD'])) {
			$this->load->view('header', $data);
			$this->load->view('deityEod_admin');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	// function deityEod_onDate() {	
	// 	unset($_SESSION['all_users']);
		
	// 	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	// 	$_SESSION['actual_link2'] = $actual_link;

	// 	$data['whichTab'] = "deityEOD";
	// 	$data['selectedDate'] = $_POST['eodDate'];
	// 	$_SESSION['selectedDate'] = $_POST['eodDate'];
	// 	$data['receiptType'] = $_POST['receiptType'];
	// 	$_SESSION['receiptType'] = $_POST['receiptType'];
		
	// 	//TIME SETTINGS
	// 	$this->db->from('EOD_TIME_SETTING');
	// 	$query = $this->db->get();
	// 	$data['timeSettings'] = $query->first_row('array');

	// 	$sqlAlredyGeneratedCount="SELECT * FROM deity_receipt where `RECEIPT_DATE`= '".$_POST['eodDate']."' and RECEIPT_CATEGORY_ID != 5 and RECEIPT_ACTIVE = 1 and EOD_CONFIRMED_BY_ID != 0";
	// 	$queryAlredyGeneratedCount = $this->db->query($sqlAlredyGeneratedCount);
	// 	$data['alredyGeneratedCount'] = $queryAlredyGeneratedCount->num_rows();
	// 	$sqlRegeneratePending="SELECT * FROM deity_receipt where `RECEIPT_DATE`= '".$_POST['eodDate']."' and RECEIPT_CATEGORY_ID != 5 and RECEIPT_ACTIVE = 1 and EOD_CONFIRMED_BY_ID = 0";
	// 	$queryRegeneratePending = $this->db->query($sqlRegeneratePending);
	// 	$data['regeneratePending'] = $queryRegeneratePending->num_rows();


		
	// 	$sql = "SELECT `RECEIPT_DATE`,`RECEIPT_ISSUED_BY`,`RECEIPT_ISSUED_BY_ID`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, (SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
	// 	(SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount, 
	// 	(SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `POSTAGE_PRICE` ELSE '' END )) AS 'AUTHORISED_STATUS'  FROM DEITY_RECEIPT where `RECEIPT_DATE`= '".$_POST['eodDate']."' and RECEIPT_CATEGORY_ID != 5 and RECEIPT_ACTIVE = 1 GROUP BY `RECEIPT_ISSUED_BY`";
		
	// 	$query = $this->db->query($sql);
	// 	$data['eod_receipt_report'] = $query->result();
		
	// 	if(isset($_SESSION['Deity_EOD'])) {
	// 		$this->load->view('header',$data);
	// 		$this->load->view('deityEod_onDate');
	// 		$this->load->view('footer_home');
	// 	} else {
	// 		redirect('Home/homePage');
	// 	}
	// }

	function deityEod_onDate() {	
		unset($_SESSION['all_users']);
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link2'] = $actual_link;

		$data['whichTab'] = "deityEOD";
		// $eodDate= $data['selectedDate'] = $_POST['eodDate'];
		// $eodDate=$_SESSION['selectedDate'] = $_POST['eodDate'];
		// $data['receiptType'] = $_POST['receiptType'];
		// $_SESSION['receiptType'] = $_POST['receiptType'];

		if(@$_POST['eodDate']){
			$data['selectedDate'] = $_SESSION['selectedDate'] = $eodDate = $_POST['eodDate'];
			$data['receiptType'] = $_SESSION['receiptType'] = $_POST['receiptType'];
		} else {
			$data['selectedDate'] = $eodDate = $_SESSION['selectedDate'];
			$data['receiptType'] = $_SESSION['receiptType'];
		}
		
		//TIME SETTINGS
		$this->db->from('EOD_TIME_SETTING');
		$query = $this->db->get();
		$data['timeSettings'] = $query->first_row('array');

		$sqlAlredyGeneratedCount="SELECT * FROM deity_receipt where `RECEIPT_DATE`= '".$eodDate."' and RECEIPT_CATEGORY_ID != 5 and RECEIPT_ACTIVE = 1 and EOD_CONFIRMED_BY_ID != 0";
		$queryAlredyGeneratedCount = $this->db->query($sqlAlredyGeneratedCount);
		$data['alredyGeneratedCount'] = $queryAlredyGeneratedCount->num_rows();
		$sqlRegeneratePending="SELECT * FROM deity_receipt where `RECEIPT_DATE`= '".$eodDate."' and RECEIPT_CATEGORY_ID != 5 and RECEIPT_ACTIVE = 1 and EOD_CONFIRMED_BY_ID = 0";
		$queryRegeneratePending = $this->db->query($sqlRegeneratePending);
		$data['regeneratePending'] = $queryRegeneratePending->num_rows();


		
		$sql = "SELECT `RECEIPT_DATE`,`RECEIPT_ISSUED_BY`,`RECEIPT_ISSUED_BY_ID`,`RECEIPT_PAYMENT_METHOD`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, 
		(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `RECEIPT_PRICE` ELSE '' END ) + 
		SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,
		(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `RECEIPT_PRICE` ELSE '' END ) + 
		SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,
		(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `RECEIPT_PRICE` ELSE '' END ) + 
		SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'CreditDebitCard',
		(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `RECEIPT_PRICE` ELSE '' END ) + 
		SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'DirectCredit',
		(SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount, 
		(SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `RECEIPT_PRICE` ELSE '' END ) + 
		SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `POSTAGE_PRICE` ELSE '' END )) AS 'AUTHORISED_STATUS'  
		FROM DEITY_RECEIPT where `RECEIPT_DATE`= '".$eodDate."' and RECEIPT_CATEGORY_ID != 5 and RECEIPT_ACTIVE = 1 and `RECEIPT_PAYMENT_METHOD` != 'Transfer' GROUP BY `RECEIPT_ISSUED_BY`";
		
		$query = $this->db->query($sql);
		$data['eod_receipt_report'] = $query->result();
		// $data1['eod_transfer'] = json_encode($this->obj_eod->getTransfer($eodDate));
		$data['eod_transfer'] = $eod_transfer = json_encode($this->obj_eod->getTransfer($eodDate));
		$sql1 = "SELECT * FROM `deity_receipt` inner join financial_ledger_transcations on deity_receipt.RECEIPT_ID = financial_ledger_transcations.RECEIPT_ID JOIN deity_receipt_category on deity_receipt.RECEIPT_CATEGORY_ID=deity_receipt_category.RECEIPT_CATEGORY_ID where RECEIPT_PAYMENT_METHOD ='Transfer' and RECEIPT_DATE ='".$eodDate."' GROUP BY `deity_receipt`.RECEIPT_ID" ;
		$query1 = $this->db->query($sql1);
		$data['eod_transfer_report'] =$query1->result();
		$config['base_url'] = $data['base_url'] =  base_url().'EOD/deityEod_onDate';
		if(isset($_SESSION['Deity_EOD'])) {
			$this->load->view('header',$data);
			$this->load->view('deityEod_onDate',$data);
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function deityEod_save() {   
		$selectedDate = $_POST['selectedDate'];

		$sql = "SELECT 	RECEIPT_ID,RECEIPT_DATE, RECEIPT_CATEGORY_ID,SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE) AS PRICE, RECEIPT_PAYMENT_METHOD , FGLH_ID,RECEIPT_ID,PAYMENT_STATUS,RECEIPT_DEITY_ID FROM `deity_receipt` WHERE RECEIPT_DATE = '$selectedDate'  AND RECEIPT_PAYMENT_METHOD = 'Cash' and RECEIPT_ACTIVE=1 AND (RECEIPT_DEITY_ID!=6 OR RECEIPT_DEITY_ID IS NULL)  GROUP BY RECEIPT_PAYMENT_METHOD, RECEIPT_CATEGORY_ID 
		UNION
			SELECT 	RECEIPT_ID,RECEIPT_DATE, RECEIPT_CATEGORY_ID,SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE) AS PRICE, RECEIPT_PAYMENT_METHOD , FGLH_ID,RECEIPT_ID,PAYMENT_STATUS,RECEIPT_DEITY_ID FROM `deity_receipt` WHERE RECEIPT_DATE = '$selectedDate'  AND RECEIPT_PAYMENT_METHOD = 'Cash' and RECEIPT_ACTIVE=1 AND RECEIPT_DEITY_ID=6 GROUP BY RECEIPT_PAYMENT_METHOD, RECEIPT_CATEGORY_ID 
		UNION
			 SELECT RECEIPT_ID,RECEIPT_DATE, RECEIPT_CATEGORY_ID, (RECEIPT_PRICE + POSTAGE_PRICE)  AS PRICE, RECEIPT_PAYMENT_METHOD, FGLH_ID,RECEIPT_ID,PAYMENT_STATUS,RECEIPT_DEITY_ID FROM `deity_receipt` WHERE RECEIPT_DATE = '$selectedDate' AND RECEIPT_PAYMENT_METHOD = 'Direct Credit' and RECEIPT_ACTIVE=1 
		UNION
			SELECT 	RECEIPT_ID,RECEIPT_DATE, RECEIPT_CATEGORY_ID, (RECEIPT_PRICE + POSTAGE_PRICE)  AS PRICE, RECEIPT_PAYMENT_METHOD, FGLH_ID,RECEIPT_ID,PAYMENT_STATUS ,RECEIPT_DEITY_ID FROM `deity_receipt` WHERE RECEIPT_DATE = '$selectedDate' AND RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' and RECEIPT_ACTIVE=1 ORDER BY RECEIPT_PAYMENT_METHOD,RECEIPT_CATEGORY_ID";
		$query = $this->db->query($sql);
		$receiptDetails = $query->result();
		$dateTime = date('d-m-Y H:i:s A');

		foreach($receiptDetails as $result) { 

			if($result->RECEIPT_PAYMENT_METHOD == "Cash") {
				$aidR = 21;
				$RECEIPT_ID = $result->RECEIPT_ID;
			} else { 
				$aidR = $result->FGLH_ID;
				$RECEIPT_ID = $result->RECEIPT_ID;
			}
			$catId = $result->RECEIPT_CATEGORY_ID;
			$amtsR = $result->PRICE;
			$tDateR = $result->RECEIPT_DATE;
			$deityId = $result->RECEIPT_DEITY_ID;
			$naration = "";
			$flt_user = $_SESSION['userId'];
			$RECEIPT_PAYMENT_METHOD = $result->RECEIPT_PAYMENT_METHOD;
			$PAYMENT_STATUS = $result->PAYMENT_STATUS;
// ADDED BY ADITHYA
	$this->db->select('FGLH_ID')->from('deity_receipt_category')->where(array('RECEIPT_CATEGORY_ID'=> "$catId"));
	$query = $this->db->get();
	$T_DATAS = $query->first_row();

			if($catId != 5 || $catId != 10) {
					// if($catId == 1) {
						$lidR = $T_DATAS->FGLH_ID ;
					// } else if($catId == 2) {
					// 	$lidR = 18;
					// }else if($catId == 3) {
					// 	$lidR = 19;
					} if($catId == 4) {  //else if
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


				
			$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`RECEIPT_ID`,`PAYMENT_METHOD`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($lidR,'$countNoR',0,$amtsR,
				'$tDateR','$dateTime','$naration','R1',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS','$compId')");
			$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`RECEIPT_ID`,`PAYMENT_METHOD`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($aidR,'$countNoR',$amtsR,0,
					'$tDateR','$dateTime','$naration','R2',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS','$compId')");

			$this->db->where('finance_voucher_counter.FVC_ID',1);
			$this->db->update('finance_voucher_counter', array('FVC_COUNTER'=>$counter));

		}
		
		$deity_receipt = array(
			"EOD_CONFIRMED_BY_ID"=>$_SESSION['userId'],
			"EOD_CONFIRMED_BY_NAME"=>$_SESSION['userFullName'],
			"EOD_CONFIRMED_DATE_TIME"=>date('d-m-Y h:i:s A'),
			"EOD_CONFIRMED_DATE"=>date('d-m-Y')
		);
		
		$this->db->where(array(
			'RECEIPT_DATE'=>$_POST['selectedDate'],
			'RECEIPT_ACTIVE' => 1
		));
		
		$this->db->update('DEITY_RECEIPT', $deity_receipt);

		$where_inkind = " WHERE RECEIPT_ACTIVE = 1 AND STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') <= STR_TO_DATE('".$_POST['selectedDate']."','%d-%m-%Y') AND EOD_CONFIRMED_BY_ID = 0 AND RECEIPT_CATEGORY_ID = 5";
		if($this->obj_eod->get_all_Inkind_which_are_not_authorised($where_inkind) > 0){
			//UPDATE CODE
			$query = $this->obj_eod->Update_All_Inkind_which_are_not_authorised($where_inkind);
		}
					
		$where = array(
			"RECEIPT_DATE"=>$_POST['selectedDate'],
			"RECEIPT_ACTIVE"=>"1",
			"RECEIPT_PAYMENT_METHOD"=>"Cheque"
		);
		
		$this->db->from("DEITY_RECEIPT")->where($where);
		$query = $this->db->get();
		$chequeDetails = $query->result();
		
		foreach($chequeDetails as $result) {
			$PRICE = $result->RECEIPT_PRICE + $result->POSTAGE_PRICE;
			$data = array(
				'DUC_BY_ID'=>@$_SESSION['userId'],
				'DUC_BY_NAME'=>@$_SESSION['userFullName'],
				'DUC_EOD_DATE'=>date('Y-m-d', strtotime($_POST['selectedDate'])),
				'RECEIPT_ID'=>$result->RECEIPT_ID,
				'DUC_CHEQUE'=>$PRICE,
				'DUC_DATE_TIME'=>date('d-m-Y h:i:s A'),
				'DUC_DATE'=>date('Y-m-d'),
				'DUC_CHEQUE_NO'=>$result->CHEQUE_NO,
				'DUC_CHEQUE_DATE'=>$result->CHEQUE_DATE,
				'DUC_BANK_NAME'=>$result->BANK_NAME,
				'DUC_BRANCH_NAME'=>$result->BRANCH_NAME,
				'DUC_IS_DEPOSITED'=>"0"
			);
			
			// echo json_encode($data);
			$this->db->insert('DEITY_USER_COLLECTION',$data);
			$id = $this->db->insert_id();
			
			$DEITY_USER_COLLECTION_HISTORY = array(
				'DUC_ID'=>$id,
				'DUCH_BY_ID'=>@$_SESSION['userId'],
				'DUCH_BY_NAME'=>@$_SESSION['userFullName'],
				'DUCH_DATE_TIME'=>date('d-m-Y h:i:s A'),
				'DUCH_DATE'=>date('Y-m-d'),
			);
			
			$this->db->insert('DEITY_USER_COLLECTION_HISTORY',$DEITY_USER_COLLECTION_HISTORY);
		}
		
		echo "success";
	}

	function deityRegenerateEod_save() {
		$selectedDate = $_POST['selectedDate'];

		
		$sql = "SELECT 	RECEIPT_ID,RECEIPT_DATE, RECEIPT_CATEGORY_ID,SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE) AS PRICE, RECEIPT_PAYMENT_METHOD , FGLH_ID,RECEIPT_ID,PAYMENT_STATUS,RECEIPT_DEITY_ID FROM `deity_receipt` WHERE RECEIPT_DATE = '$selectedDate' AND RECEIPT_PAYMENT_METHOD = 'Cash' and RECEIPT_ACTIVE=1 and EOD_CONFIRMED_BY_ID=0 AND (RECEIPT_DEITY_ID!=6 OR RECEIPT_DEITY_ID IS NULL)   GROUP BY RECEIPT_PAYMENT_METHOD, RECEIPT_CATEGORY_ID 
		UNION
			SELECT 	RECEIPT_ID,RECEIPT_DATE, RECEIPT_CATEGORY_ID,SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE) AS PRICE, RECEIPT_PAYMENT_METHOD , FGLH_ID,RECEIPT_ID,PAYMENT_STATUS,RECEIPT_DEITY_ID FROM `deity_receipt` WHERE RECEIPT_DATE = '$selectedDate'  AND RECEIPT_PAYMENT_METHOD = 'Cash' and RECEIPT_ACTIVE=1 AND RECEIPT_DEITY_ID=6 GROUP BY RECEIPT_PAYMENT_METHOD, RECEIPT_CATEGORY_ID 
		UNION
			 SELECT RECEIPT_ID,RECEIPT_DATE, RECEIPT_CATEGORY_ID, (RECEIPT_PRICE + POSTAGE_PRICE)  AS PRICE, RECEIPT_PAYMENT_METHOD, FGLH_ID,RECEIPT_ID,PAYMENT_STATUS,RECEIPT_DEITY_ID FROM `deity_receipt` WHERE RECEIPT_DATE = '$selectedDate' AND RECEIPT_PAYMENT_METHOD = 'Direct Credit' and RECEIPT_ACTIVE=1  and EOD_CONFIRMED_BY_ID=0
			 UNION
		SELECT 	RECEIPT_ID,RECEIPT_DATE, RECEIPT_CATEGORY_ID, (RECEIPT_PRICE + POSTAGE_PRICE)  AS PRICE, RECEIPT_PAYMENT_METHOD, FGLH_ID,RECEIPT_ID,PAYMENT_STATUS,RECEIPT_DEITY_ID FROM `deity_receipt` WHERE RECEIPT_DATE = '$selectedDate' AND RECEIPT_PAYMENT_METHOD = 'Credit / Debit Card' and RECEIPT_ACTIVE=1 and EOD_CONFIRMED_BY_ID=0 ORDER BY RECEIPT_PAYMENT_METHOD,RECEIPT_CATEGORY_ID";
		$query = $this->db->query($sql);
		$receiptDetails = $query->result();
		$dateTime = date('d-m-Y H:i:s A');

		foreach($receiptDetails as $result) { 

			if($result->RECEIPT_PAYMENT_METHOD == "Cash") {
				$aidR = 21;
				$RECEIPT_ID = $result->RECEIPT_ID;
			} else { 
				$aidR = $result->FGLH_ID;
				$RECEIPT_ID = $result->RECEIPT_ID;
			}
			$catId = $result->RECEIPT_CATEGORY_ID;
			$amtsR = $result->PRICE;
			$tDateR = $result->RECEIPT_DATE;
			$deityId = $result->RECEIPT_DEITY_ID;
			$naration = "";
			$flt_user = $_SESSION['userId'];
			$RECEIPT_PAYMENT_METHOD = $result->RECEIPT_PAYMENT_METHOD;
			$PAYMENT_STATUS = $result->PAYMENT_STATUS;

			if($catId != 5 || $catId != 10){
					if($catId == 1) {
						$lidR = 17;
					} else if($catId == 2) {
						$lidR = 18;
					}else if($catId == 3) {
						$lidR = 19;
					}else if($catId == 4) {
						if($deityId==6){
							$lidR = 77;				//Tirupati Devara Hundi Kanike ONLY FOR SLVT
						} else {
							$lidR = 20;
						}
					}else if($catId == 6) {
						$lidR = 26;
					}else if($catId == 7) {
						$lidR = 25;
					}else if($catId == 8) {
						$lidR = 22;
					}else if($catId == 9) {
						$lidR = 23;
					}
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


				
			$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`RECEIPT_ID`,`PAYMENT_METHOD`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($lidR,'$countNoR',0,$amtsR,
				'$tDateR','$dateTime','$naration','R1',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS','$compId')");
			$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`RECEIPT_ID`,`PAYMENT_METHOD`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($aidR,'$countNoR',$amtsR,0,
					'$tDateR','$dateTime','$naration','R2',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS','$compId')");

			$this->db->where('finance_voucher_counter.FVC_ID',1);
			$this->db->update('finance_voucher_counter', array('FVC_COUNTER'=>$counter));

		}
		
		$deity_receipt = array(
			"EOD_CONFIRMED_BY_ID"=>$_SESSION['userId'],
			"EOD_CONFIRMED_BY_NAME"=>$_SESSION['userFullName'],
			"EOD_CONFIRMED_DATE_TIME"=>date('d-m-Y h:i:s A'),
			"EOD_CONFIRMED_DATE"=>date('d-m-Y')
		);
		
		$this->db->where(array(
			'RECEIPT_DATE'=>$_POST['selectedDate'],
			'RECEIPT_ACTIVE' => 1,
			'EOD_CONFIRMED_BY_ID'=>0
		));
		
		$this->db->update('DEITY_RECEIPT', $deity_receipt);
			
		$where = array(
			"RECEIPT_DATE"=>$_POST['selectedDate'],
			"EOD_CONFIRMED_DATE"=>date('d-m-Y'),
			"RECEIPT_ACTIVE"=>"1",
			"RECEIPT_PAYMENT_METHOD"=>"Cheque"
		);
		
		$this->db->from("DEITY_RECEIPT")->where($where);
		$query = $this->db->get();
		$chequeDetails = $query->result();
		
		foreach($chequeDetails as $result) {
			$PRICE = $result->RECEIPT_PRICE + $result->POSTAGE_PRICE;
			$data = array(
				'DUC_BY_ID'=>@$_SESSION['userId'],
				'DUC_BY_NAME'=>@$_SESSION['userFullName'],
				'DUC_EOD_DATE'=>date('Y-m-d', strtotime($_POST['selectedDate'])),
				'RECEIPT_ID'=>$result->RECEIPT_ID,
				'DUC_CHEQUE'=>$PRICE,
				'DUC_DATE_TIME'=>date('d-m-Y h:i:s A'),
				'DUC_DATE'=>date('Y-m-d'),
				'DUC_CHEQUE_NO'=>$result->CHEQUE_NO,
				'DUC_CHEQUE_DATE'=>$result->CHEQUE_DATE,
				'DUC_BANK_NAME'=>$result->BANK_NAME,
				'DUC_BRANCH_NAME'=>$result->BRANCH_NAME,
				'DUC_IS_DEPOSITED'=>"0"
			);
			
			// echo json_encode($data);
			$this->db->insert('DEITY_USER_COLLECTION',$data);
			$id = $this->db->insert_id();
			
			$DEITY_USER_COLLECTION_HISTORY = array(
				'DUC_ID'=>$id,
				'DUCH_BY_ID'=>@$_SESSION['userId'],
				'DUCH_BY_NAME'=>@$_SESSION['userFullName'],
				'DUCH_DATE_TIME'=>date('d-m-Y h:i:s A'),
				'DUCH_DATE'=>date('Y-m-d'),
			);
			
			$this->db->insert('DEITY_USER_COLLECTION_HISTORY',$DEITY_USER_COLLECTION_HISTORY);
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
	function get_unset_session()  {
		unset($_SESSION['all_users']);
		unset($_SESSION['PM']);
		unset($_SESSION['UID']);
	}
	
	function checkPreviousPendingDate() {
		$toDate = $_POST['date'];
		$sql = "SELECT RECEIPT_DATE as ReceiptDate FROM `DEITY_RECEIPT` WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') < STR_TO_DATE('".$toDate."','%d-%m-%Y') and RECEIPT_ACTIVE = 1 and EOD_CONFIRMED_BY_ID = 0 ORDER BY STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y')";
		$query = $this->db->query($sql);
		//$this->output->enable_profiler(true);	
		if ($query->num_rows() > 0) { 
			echo $query->first_row()->ReceiptDate;
		} else {
			echo "success";
		}
	}

	function deityEod_usercollection($start=0) {
		//whichTab
		$data['whichTab'] = "deityEOD";
		
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
		
		$condt = array('AUTHORISED_STATUS' => 'No','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$condt1 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$condt2 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$condt3 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$condt4 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		$conditionOne = array('AUTHORISED_STATUS' => 'No','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['receipt_report'] =  json_encode($this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start));
		$data['all_receipt_report'] =  json_encode($this->obj_eod->get_full_field_receipt_report($conditionOne,'',''));
		$data['countEodRows'] = $this->obj_eod->count_rows_receipt_report($conditionOne);
		//pagination starts

		$this->load->library('pagination');
		$config['base_url'] = base_url().'EOD/deityEod_usercollection';
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
		
		if(isset($_SESSION['Deity_EOD'])) {
			$this->load->view('header',$data);
			$this->load->view('deityEod_usercollection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//for admin view button click in deityEod_onDate
	function getDataOnFilter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "deityEOD";
				
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
				
				$conditionOne = array('RECEIPT_ISSUED_BY_ID' => $users,'RECEIPT_ACTIVE'=>1,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
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
			$conditionOne = array('RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		} else if(@$pMethod != "All") {
			$conditionOne = array('RECEIPT_PAYMENT_METHOD' => $pMethod,'RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EOD/getDataOnFilter/'.$id;
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
		$this->load->view('deityEodUsercollection');
		$this->load->view('footer_home');
	}
	
	function deityEodUsercollection($start=0) {
		//whichTab
		$data['whichTab'] = "deityEOD";
		
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
		
		$condt = array('RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		$conditionOne = array('RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EOD/deityEodUsercollection';
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
		
		if(isset($_SESSION['Deity_EOD'])) {
			$this->load->view('header',$data);
			$this->load->view('deityEodUsercollection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//EOD for Logged in user
	function deityEod_collection($start=0) {
		
		//whichTab
		$data['whichTab'] = "deityEOD";
		
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
		
		$condt = array('RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		$conditionOne = array('RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EOD/deityEod_collection';
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
		
		if(isset($_SESSION['Deity_EOD'])) {
			$this->load->view('header',$data);
			$this->load->view('deityEod_collection');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function get_data_on_filter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "deityEOD";
				
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
				
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_ISSUED_BY_ID' => $users,'RECEIPT_ACTIVE'=>1,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
				$data['receipt_report'] =  json_encode($this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start));
				$data['all_receipt_report'] =  json_encode($this->obj_eod->get_full_field_receipt_report($conditionOne,'',''));
				if(count($receipt_report) == 0) {
					$users = "All Users";
				}
			}
		} else {
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);
		}
		
		if(@$pMethod == "All") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			$data['receipt_report'] =  json_encode($this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start));
			$data['all_receipt_report'] =  json_encode($this->obj_eod->get_full_field_receipt_report($conditionOne,'',''));
		} else if(@$pMethod != "All") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => $pMethod,'RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			$data['receipt_report'] =  json_encode($this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start));
			$data['all_receipt_report'] =  json_encode($this->obj_eod->get_full_field_receipt_report($conditionOne,'',''));
		} 
		//CONDITION FOR AMOUNT
		$condt = array('AUTHORISED_STATUS' => 'No','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt1 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt2 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt3 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt4 = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EOD/get_data_on_filter/'.$id;
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
		$this->load->view('deityEod_usercollection');
		$this->load->view('footer_home');
	}
	
	//EOD for Logged in user
	function get_data_on_userFilter($id,$start=0) {
		//For Menu Selection
		$data['whichTab'] = "deityEOD";
		
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
				
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_ISSUED_BY_ID' => $users,'RECEIPT_ACTIVE'=>1,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
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
			$conditionOne = array('RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		} else if(@$pMethod != "All") {
			$conditionOne = array('RECEIPT_PAYMENT_METHOD' => $pMethod,'RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			$data['receipt_report'] = $this->obj_eod->get_all_field_receipt_report($conditionOne,'','', 10,$start);
		} 
		//CONDITION FOR AMOUNT
		$condt = array('RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
		$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$userId,'RECEIPT_DATE'=>$userDate,'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			
		$data['All'] = $this->obj_eod->get_total_amount($condt);
		$data['Cash'] = $this->obj_eod->get_total_amount($condt1);
		$data['Cheque'] = $this->obj_eod->get_total_amount($condt2);
		$data['Credit_Debit'] = $this->obj_eod->get_total_amount($condt3);
		$data['Direct'] = $this->obj_eod->get_total_amount($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'EOD/get_data_on_userFilter/'.$id;
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
		$this->load->view('deityEod_collection');
		$this->load->view('footer_home');
	}
	
	//APPROVE THE DATA
	function approve_Submit() {
		$data['whichTab'] = "deityEOD";	
		
		//VALUE OF CHECKBOX SELECTED OR NOT SELECTED
		$selCondition = $this->input->post('checkVal');
		if($selCondition == "all_users") { //ALL_USERS CHECKBOX
			if(@$this->input->post('paymentApprove') == "All") {
				$condition = array('AUTHORISED_STATUS' => 'No','RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk'],'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			}  else if(@$this->input->post('paymentApprove') != "All" ) {
				$condition = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'),'RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk'],'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
			} 
			//UPDATE CODE 
			$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'),'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE'=>1);
			$this->obj_eod->update_authorise($condition,$data);
		} else if($selCondition == "this_page") { //THIS_PAGE CHECKBOX
			$selectedId = $this->input->post('selectApprove');
			$arrSelect = explode(',' ,$selectedId);
			for($i = 0; $i <= count($arrSelect) - 1; $i++) {
				if(@$this->input->post('paymentApprove') == "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_ID' => $arrSelect[$i],'RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk'],'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
				} else if(@$this->input->post('paymentApprove') != "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'RECEIPT_ID' => $arrSelect[$i],'RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk'],'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
				} 
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE'=>1);
				$this->obj_eod->update_authorise($condition,$data);
			}
		} else { //WITHOUT CHECKBOX
			$selectedId = $this->input->post('selectApprove');
			$arrSelect = explode(',' ,$selectedId);
			for($i = 0; $i <= count($arrSelect) - 1; $i++) {
				if(@$this->input->post('paymentApprove') == "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_ID' => $arrSelect[$i],'RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk'],'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
				} else if(@$this->input->post('paymentApprove') != "All") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'RECEIPT_ID' => $arrSelect[$i],'RECEIPT_ACTIVE'=>1,'RECEIPT_ISSUED_BY_ID'=>$_POST['userIdChk'],'RECEIPT_DATE'=>$_POST['dateChk'],'DEITY_RECEIPT.RECEIPT_CATEGORY_ID !=' => 5);
				} 
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE'=>1);
				$this->obj_eod->update_authorise($condition,$data);
			}
		}
		$this->session->set_userdata('PM', $this->input->post('paymentApprove'));
		redirect('/EOD/deityEod_usercollection'); //get_data_on_filter/0
	}


	function temporaryGenerate() {	
		$sql = "SELECT 	RECEIPT_ID,RECEIPT_DATE, RECEIPT_CATEGORY_ID,SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE) AS PRICE, RECEIPT_PAYMENT_METHOD , FGLH_ID,RECEIPT_ID,PAYMENT_STATUS,RECEIPT_DEITY_ID FROM `deity_receipt` WHERE STR_TO_DATE(RECEIPT_DATE,'%d-%m-%Y') > STR_TO_DATE('11-07-2022','%d-%m-%Y') AND RECEIPT_PAYMENT_METHOD = 'Cash' and RECEIPT_ACTIVE=1 AND RECEIPT_DEITY_ID IS NULL AND EOD_CONFIRMED_BY_ID!=0 GROUP BY RECEIPT_DATE,RECEIPT_PAYMENT_METHOD, RECEIPT_CATEGORY_ID";
		$query = $this->db->query($sql);
		$receiptDetails = $query->result();
		$dateTime = date('d-m-Y H:i:s A');

		foreach($receiptDetails as $result) { 

			if($result->RECEIPT_PAYMENT_METHOD == "Cash") {
				$aidR = 21;
				$RECEIPT_ID = $result->RECEIPT_ID;
			} else { 
				$aidR = $result->FGLH_ID;
				$RECEIPT_ID = $result->RECEIPT_ID;
			}
			$catId = $result->RECEIPT_CATEGORY_ID;
			$amtsR = $result->PRICE;
			$tDateR = $result->RECEIPT_DATE;
			$deityId = $result->RECEIPT_DEITY_ID;
			$naration = "";
			$flt_user = $_SESSION['userId'];
			$RECEIPT_PAYMENT_METHOD = $result->RECEIPT_PAYMENT_METHOD;
			$PAYMENT_STATUS = $result->PAYMENT_STATUS;

			if($catId != 5 || $catId != 10){
					if($catId == 1) {
						$lidR = 17;
					} else if($catId == 2) {
						$lidR = 18;
					}else if($catId == 3) {
						$lidR = 19;
					}else if($catId == 4) {
						if($deityId==6){
							$lidR = 77;				//Tirupati Devara Hundi Kanike ONLY FOR SLVT
						} else {
							$lidR = 20;
						}
					}else if($catId == 6) {
						$lidR = 26;
					}else if($catId == 7) {
						$lidR = 25;
					}else if($catId == 8) {
						$lidR = 22;
					}else if($catId == 9) {
						$lidR = 23;
					}
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


				
			$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`RECEIPT_ID`,`PAYMENT_METHOD`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($lidR,'$countNoR',0,$amtsR,
				'$tDateR','$dateTime','$naration','R1',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS','$compId')");
			$this->db->query("INSERT INTO `financial_ledger_transcations`(`Fglh_Id`,`VOUCHER_NO`,`Flt_Dr`, `Flt_cr`, `Flt_Date`,`Flt_Date_Time`,`Flt_Narration`,`RP_TYPE`,`FLT_USER_ID`,`RECEIPT_ID`,`PAYMENT_METHOD`,`PAYMENT_STATUS`,`COMP_ID`) VALUES ($aidR,'$countNoR',$amtsR,0,
					'$tDateR','$dateTime','$naration','R2',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$PAYMENT_STATUS','$compId')");

			$this->db->where('finance_voucher_counter.FVC_ID',1);
			$this->db->update('finance_voucher_counter', array('FVC_COUNTER'=>$counter));
		}

		redirect('/Sevas');
	}
}
 