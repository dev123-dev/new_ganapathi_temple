<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Receipt extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('string');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		
		$this->load->helper('date');
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('Events_modal','obj_events',true);
		$this->load->model('Receipt_modal','obj_receipt',true);
        $this->load->model('Report_modal','obj_report',true);		
		$this->load->model('Deity_model','obj_sevas',true); 
		$this->load->model('Shashwath_Model','obj_shashwath',true);
		$this->load->model('finance_model','obj_finance',true);
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		if(!isset($_SESSION['userId']))
			redirect('login');
		
		if($_SESSION['trustLogin'] == 1)
			redirect('Trust');
		
		$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
	}
	
	function daily_report($start = 0) {
		    $_SESSION['back_link'] = uri_string(); //For Navigation
		    //Radio Option
			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			//Unset Session
			unset($_SESSION['date']);
			unset($_SESSION['deityId']);
			unset($_SESSION['paymentMethod']);
			
			//For Menu Selection
			$data['date'] = date('d-m-Y');
			$data['whichTab'] = "Jeernodhara";
			$data['daily_report'] = $this->obj_receipt->get_daily_report(date("d-m-Y"),$start,10);
			$data['min_date'] = $this->obj_receipt->get_min_date(date("d-m-Y"),$start,10);
			
			$condtUser = array('IS_JEERNODHARA'=>1,'RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE'=>1);
			$data['users'] = $this->obj_report->get_all_users_on_jeernodhara($condtUser,'RECEIPT_ISSUED_BY','asc');
			
			$_SESSION['Jeerno_User_Id'] = $data['user'] = 0;
			$_SESSION['PMode'] = $data['PMode'] = "All";
			
			$_SESSION['actual_link'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
			$data['All'] = $this->obj_report->get_total_amount_user_collection_for_jeernodhara($condtUser);
			
			$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','IS_JEERNODHARA'=>1,'RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE'=>1);
			$data['Cash'] = $this->obj_report->get_total_amount_user_collection_for_jeernodhara($condt1);
			$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','IS_JEERNODHARA'=>1,'RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE'=>1);
			$data['Cheque'] = $this->obj_report->get_total_amount_user_collection_for_jeernodhara($condt2);
			$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','IS_JEERNODHARA'=>1,'RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE'=>1);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount_user_collection_for_jeernodhara($condt3);
			$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','IS_JEERNODHARA'=>1,'RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE'=>1);
			$data['Direct'] = $this->obj_report->get_total_amount_user_collection_for_jeernodhara($condt4);
			
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Receipt/daily_report';
			$config['total_rows'] = $data['Count'] = $this->obj_receipt->get_daily_report_count(date("d-m-Y"));
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
		$this->load->view('header',$data);
		$this->load->view('Jeernodhara/jeernodhara_daily_report');
		$this->load->view('footer_home'); 	
	}
		
	function receipt($receiptNo = "") {
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$data['whichTab'] = "receipt";
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
					
		if(isset($_SESSION['Receipt'])) {
			$receiptNo = $_SESSION['Receipt'];
			unset($_SESSION['Receipt']);
		}  else if(isset($_POST['receiptNo'])) {
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_POST['receiptNo'];
		} else if(isset($_POST['receiptFormat2'])) {
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_POST['receiptFormat2'];
		} else if(isset($_SESSION['recFor'])) { 
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_SESSION['recFor'];
			unset($_SESSION['recFor']);
		} //else redirect("Sevas");
		
		/* if(isset($_SESSION['reloading'])) {
			redirect('Receipt/all_receipt_deity');
		} */
		
		$smId = $this->input->post('identity');
		$this->db->select()->from('DEITY_RECEIPT')
	 	->join('SHASHWATH_SEVA', 'SHASHWATH_SEVA.SS_ID = DEITY_RECEIPT.SS_ID')
		->join('DEITY', 'DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID')
		->join('DEITY_SEVA', 'DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID')
		->join('SHASHWATH_MEMBERS', 'SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID')
		->join('SHASHWATH_PERIOD_SETTING', 'SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID')
		->where(array('SHASHWATH_MEMBERS.SM_ID'=>$smId,'DEITY_RECEIPT.RECEIPT_ACTIVE'=>1,'PRINT_STATUS' => 0));
		
		/*->$this->db->order_by("SHASHWATH_SEVA.SS_ID", "desc")
		->$this->db->limit(1); */
		//$this->output->enable_profiler(true);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 0) {
		  redirect('Receipt/all_receipt_deity');
		}
		//print_r($query);
		$data['deityCounter'] = $query->result("array");
		//print_r($data);
		//$this->session->unset_userdata('sm_id');
		//$_SESSION['reloading'] = 'reload';
		$this->load->view('header',$data);
		$this->load->view('Shashwath/shashwath_Receipt');
		$this->load->view('footer_home'); 
	
	}
	
	function shashwathReceipt($receiptNo = "") {
		$data['whichTab'] = "receipt";
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		
		/*if(isset($_SESSION['reload'])) {
		redirect('Receipt/all_receipt_deity');
		}*/
		
		if(isset($_SESSION['shashwathReceipt'])) {
			$receiptNo = $_SESSION['shashwathReceipt'];
			unset($_SESSION['shashwathReceipt']);
		}  else if(isset($_POST['receiptNo'])) {
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_POST['receiptNo'];
		} else if(isset($_POST['receiptFormat2'])) {
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_POST['receiptFormat2'];
		} else if(isset($_SESSION['recFor'])) { 
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_SESSION['recFor'];
			unset($_SESSION['recFor']);
		}
		
 		$SM_ID ="";
			
		if(isset($_SESSION['sm_id'])) {	
			$SM_ID = $_SESSION['sm_id'];
			//unset($_SESSION['sm_id']);
		} 
		
		//echo $SM_ID;
		//$_SESSION['reload'] = 'reload';
		$this->db->select()->from('DEITY_RECEIPT')
	 	->join('SHASHWATH_SEVA', 'SHASHWATH_SEVA.SS_ID = DEITY_RECEIPT.SS_ID')
		->join('DEITY', 'DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID')
		->join('DEITY_SEVA', 'DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID')
		->join('SHASHWATH_MEMBERS', 'SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID')
		->join('SHASHWATH_PERIOD_SETTING', 'SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID')
		->where(array('SHASHWATH_MEMBERS.SM_ID'=>$SM_ID,'DEITY_RECEIPT.RECEIPT_ACTIVE'=>1,'PRINT_STATUS' => 0)); 
		
		$query = $this->db->get();
		
		if($query->num_rows() == 0) {
		  redirect('Receipt/all_receipt_deity');
		}
		
		$data['deityCounter'] = $query->result("array");
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		//print_r($data);
		$this->load->view('header',$data);
		$this->load->view('Shashwath/shashwath_Receipt');
		$this->load->view('footer_home');
	}

	function shashwathExistingReceipt($receiptNo = "") {
		$data['whichTab'] = "receipt";
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		
		/*if(isset($_SESSION['reload'])) {
		redirect('Receipt/all_receipt_deity');
		}*/
		
		if(isset($_SESSION['shashwathReceipt'])) {
			$receiptNo = $_SESSION['shashwathReceipt'];
			unset($_SESSION['shashwathReceipt']);
		}  else if(isset($_POST['receiptNo'])) {
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_POST['receiptNo'];
		} else if(isset($_POST['receiptFormat2'])) {
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_POST['receiptFormat2'];
		} else if(isset($_SESSION['recFor'])) { 
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_SESSION['recFor'];
			unset($_SESSION['recFor']);
		}
		
 		$SM_ID ="";
			
		if(isset($_SESSION['sm_id'])) {	
			$SM_ID = $_SESSION['sm_id'];
			//unset($_SESSION['sm_id']);
		} 
		
		$this->db->select()->from('DEITY_RECEIPT')
	 	->join('SHASHWATH_SEVA', 'SHASHWATH_SEVA.SS_ID = DEITY_RECEIPT.SS_ID')
		->join('DEITY', 'DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID')
		->join('DEITY_SEVA', 'DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID')
		->join('SHASHWATH_MEMBERS', 'SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID')
		->join('SHASHWATH_PERIOD_SETTING', 'SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID')
		->where(array('SHASHWATH_MEMBERS.SM_ID'=>$SM_ID,'DEITY_RECEIPT.RECEIPT_ACTIVE'=>1,'PRINT_STATUS' => 0)); 
		
		$query = $this->db->get();
		
		if($query->num_rows() == 0) {
		  redirect('Receipt/all_receipt_deity');
		}
		
		$data['deityCounter'] = $query->result("array");
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->load->view('header',$data);
		$this->load->view('Shashwath/shashwath_Existing_Receipt');
		$this->load->view('footer_home');
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

	function get_shashwath_financial_year($month,$ssdate) {
		$dbFinMth = $month->MONTH_IN_NUMBER; //getting value from the database for start financial month 
		$currFinMth = date('n',strtotime($ssdate));
		if($dbFinMth == 1) {
			$fYear = date('Y',strtotime($ssdate));
		} else {
			if($currFinMth >= $dbFinMth && $currFinMth <= 12) {
				$year1 = date('Y',strtotime($ssdate));
				$year2 = $year1 + 1; 
			}
			if($currFinMth >= 1 && $currFinMth <= $dbFinMth - 1) {
				$year1 = date('Y',strtotime($ssdate))-1;
				$year2 = date('Y',strtotime($ssdate));
				}
			$fYear = $year1.'-'.substr($year2,2,2);
			}
			return $fYear;
	}
	//SAVE FUNCTION DETAILS OF POPUP
	function save_function_details() {
		$postValue = $_POST['postVal'];
		$data_array = array();
		//FIRST VALUE SPLIT WITH '#'
		$splitValue = explode("#",$postValue);
		for($i = 0; $i < count($splitValue); $i++) {
			//SECOND VALUE SPLIT WITH '$'
			$splitValueTwo = explode("$",$splitValue[$i]);
			if(@$splitValueTwo[1] == "1") {
				$data_array = array('IS_DONE' =>$splitValueTwo[1]);
			} else if(@$splitValueTwo[1] == "0") {
				$data_array = array('IS_DONE' =>$splitValueTwo[1],
						'FN_CANCEL_NOTES'=>$splitValueTwo[2],
						'CANCELLED_BY_ID'=> $_SESSION['userId'],
						'CANCELLED_BY'=> $_SESSION['userFullName'],
						'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
						'CANCELLED_DATE'=> date('d-m-Y'));
			}
			$condition = array('HBL_ID'=>$splitValueTwo[0]);
			$this->db->where($condition);
			$this->db->update('TRUST_HALL_BOOKING_LIST',$data_array);		
		}
		echo "success";
	}
	
	//TO GET THE DATA OF FUNCTION NOT Done
	function get_function_details() {
		$date = $_POST['date'];
		
		$sql = "SELECT * FROM `TRUST_HALL_BOOKING` INNER JOIN TRUST_HALL_BOOKING_LIST ON TRUST_HALL_BOOKING.HB_ID = TRUST_HALL_BOOKING_LIST.HB_ID LEFT JOIN (select HB_ID, sum(FH_AMOUNT) as AMOUNT from TRUST_RECEIPT group by HB_ID) TRUST_RECEIPT ON TRUST_HALL_BOOKING.HB_ID = TRUST_RECEIPT.HB_ID LEFT JOIN (select RECEIPT_HB_ID, sum(RECEIPT_PRICE) as PRICE from DEITY_RECEIPT group by RECEIPT_HB_ID) DEITY_RECEIPT ON TRUST_HALL_BOOKING.HB_ID = DEITY_RECEIPT.RECEIPT_HB_ID WHERE STR_TO_DATE(HB_BOOK_DATE,'%d-%m-%Y') < '".$date."' and IS_DONE IS NULL and HBL_ACTIVE = 1";

		$query = $this->db->query($sql);
		echo json_encode($query->result('array'));
	}
	
	//UPDATE RECEIPT
	function updateKanike() {
		$data['whichTab'] = "booking";
		$_SESSION['duplicate'] = "no"; 
		
		$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = "";
		
		if(isset($_POST["transactionId"])) {
			$transcId = $this->input->post('transactionId');
		}

		if(isset($_POST["chequeNo"])) {
			$chequeNo = $this->input->post('chequeNo');
		}
		
		if(isset($_POST["chequeDate"])) {
			$chequeDate = $this->input->post('chequeDate');
		}
		
		if(isset($_POST["bank"])) {
			$bank = $this->input->post('bank');
		}
		
		if(isset($_POST["branch"])) {
			$branch = $this->input->post('branch');
		}
		
		if($this->input->post('modeOfPayment') == "Cheque") {
			$paymentStatus = "Pending";
		} else {
			$paymentStatus = "Completed";
		}
		
		$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'3'));
		
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		
		$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;
		
		$data = array(
			'RECEIPT_NO'=> $receiptFormat,
			'RECEIPT_DATE'=> date('d-m-Y'),
			'RECEIPT_NAME' => $this->input->post('receiptName'),
			'RECEIPT_PHONE' => $this->input->post('receiptPhone'),
			'RECEIPT_PAYMENT_METHOD'=> $this->input->post('modeOfPayment'),
			'CHEQUE_NO' => $chequeNo,
			'CHEQUE_DATE' => $chequeDate,
			'BANK_NAME' => $bank,
			'BRANCH_NAME' => $branch,
			'TRANSACTION_ID' => $transcId,
			'PAYMENT_STATUS'=>$paymentStatus,
			'AUTHORISED_STATUS'=>'No',
			'RECEIPT_PRICE'=> $this->input->post('amount'),
			'RECEIPT_PAYMENT_METHOD_NOTES'=>$this->input->post('paymentNotes'),
			'RECEIPT_DEITY_ID'=> $this->input->post('deityId'),
			'RECEIPT_DEITY_NAME'=> $this->input->post('deityName'),
			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'DATE_TIME' => date('d-m-Y H:i:s A'),
			'RECEIPT_ACTIVE'=>1,
			'RECEIPT_CATEGORY_ID'=>3
		); 
		
		$receiptId = $this->obj_receipt->add_receipt_deity_modal($data);
		$condt = array('RECEIPT_NO' => $this->input->post('receiptNo'));
		$res = $this->obj_receipt->get_all_field_deity_receipt($condt);
		$receiptNote = $res->RECEIPT_PAYMENT_METHOD_NOTES;
		
		$con = array('RECEIPT_NO' => $this->input->post('receiptNo'));
		$dataNote = array('RECEIPT_PAYMENT_METHOD_NOTES' => $receiptNote." ".$receiptFormat);
		$this->obj_receipt->update_notes_model('DEITY_RECEIPT', $con, $dataNote);
		
		$_SESSION['receiptId'] = $receiptId;
		$_SESSION['receiptNo'] = $this->input->post('receiptNo');
		$_SESSION['bookingKanike'] = "BookingKanike";
		//redirect('/Receipt/receipt_donationKanikePrint/');
	}
	
	//ALL RECEIPT
	function all_receipt($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');
		//unset
		unset($_SESSION['receipt']);
		unset($_SESSION['date']);
		unset($_SESSION['receiptNo']);
		
		$data['date'] = date("d-m-Y");
		$dateReceipt = date("d-m-Y");
		
		$data['whichTab'] = "receipt";
		//NOTIFICATION
		$_SESSION['deityCount'] = $this->obj_sevas->get_seva_count(date("d-m-Y"));
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		
		if(@$receipt == '') {
			$condition = array('ET_RECEIPT_DATE' => $dateReceipt); //,'ET_RECEIPT_ACTIVE'=>1
			$data['receipts_details'] = $this->obj_receipt->get_all_field_all_receipt($condition,"EVENT_RECEIPT.ET_RECEIPT_ID","desc", 10,$start);
		}
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'Receipt/all_receipt';
		$config['total_rows'] = $this->obj_receipt->get_all_receipt_count($condition);
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
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		// 
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		//pagination ends
		
		if(isset($_SESSION['All_Event_Receipt'])) {
			$this->load->view('header',$data);
			$this->load->view('all_receipt');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//ALL RECEIPT
	function all_receipt_deity($start = 0) {
		//unset
		unset($_SESSION['receipt']);
		unset($_SESSION['date']);
		unset($_SESSION['receiptNo']);
		unset($_SESSION['reloading']);
		$data['date'] = date("d-m-Y");
		$dateReceipt = date("d-m-Y");
		
		$data['whichTab'] = "receipt";
		//NOTIFICATION
		$_SESSION['deityCount'] = $this->obj_sevas->get_seva_count(date("d-m-Y"));
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		
		if(@$receipt == '') {
			$condition = array('RECEIPT_DATE' => $dateReceipt);
			$data['receipts_details'] = $this->obj_receipt->get_all_field_all_receipt_deity($condition,"DEITY_RECEIPT.RECEIPT_ID","desc", 10,$start);
		}
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'Receipt/all_receipt_deity';
		$config['total_rows'] = $this->obj_receipt->get_all_receipt_count_deity($condition);
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
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;

		//For Navigation Purpose In Sync With JEERNODHARA
		$_SESSION['back_link'] = uri_string();

		//print_r($_SESSION);
		
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		//pagination ends
		
		if(isset($_SESSION['All_Deity_Receipt'])) {
			$this->load->view('header',$data);
			$this->load->view('all_receipt_deity');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function all_receiptSearch($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		
		$data['whichTab'] = "receipt";
		//$_SESSION['receiptNo'] = "";
		if(@$_POST['date']) {
			$_SESSION['date'] = $this->input->post('date');
			$data['date'] = $this->input->post('date');
			$dateReceipt = $this->input->post('date');
		}
		
		if(@$_SESSION['date'] == "") {
			$this->session->set_userdata('date', $this->input->post('date'));
			$data['date'] = $_SESSION['date'];
			$dateReceipt = $this->input->post('date');
		} else {
			$dateReceipt = $_SESSION['date'];
			$data['date'] = $_SESSION['date'];
		}
		
		if(@$_POST['receipt'] != "") {
			unset($_SESSION['receipt']);
			$_SESSION['receipt'] = $this->input->post('receipt');
			$receipt = $this->input->post('receipt');
			$data['Receipt'] = $this->input->post('receipt');
		}
		
		if(@$_SESSION['receipt'] == "") {
			$this->session->set_userdata('receipt', $this->input->post('receipt'));
			$receipt = $this->input->post('receipt');
			$data['Receipt'] = $_SESSION['receipt'];
		} else {
			$receipt = $_SESSION['receipt'];
			$data['Receipt'] = $_SESSION['receipt'];
		}
		
		if(@$_POST['receiptNo'] != "") {
			unset($_SESSION['receiptNo']);
			$_SESSION['receiptNo'] = $this->input->post('receiptNo');
			$receiptNo = $this->input->post('receiptNo');
			$data['receiptNo'] = $this->input->post('receiptNo');
		}
		
		if(@$_SESSION['receiptNo'] == "") {
			$this->session->set_userdata('receiptNo', $this->input->post('receiptNo'));
			$receiptNo = $this->input->post('receiptNo');
			$data['receiptNo'] = $_SESSION['receiptNo'];
		} else {
			$receiptNo = $_SESSION['receiptNo'];
			$data['receiptNo'] = $_SESSION['receiptNo'];
		}
		
		if(@$receipt == 0) {
			$condition = array('ET_RECEIPT_DATE' => $dateReceipt); //,'ET_RECEIPT_ACTIVE'=>1
			if($receiptNo != "")
				$like = $receiptNo;
			else
				$like= "";
			$data['receipts_details'] = $this->obj_receipt->get_all_field_all_receipt($condition, "EVENT_RECEIPT.ET_RECEIPT_ID","desc", 10,$start, $like);
		} else {
			if($receiptNo != "")
				$like = $receiptNo;
			else
				$like= "";
			$condition = array('ET_RECEIPT_DATE' => $dateReceipt, 'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID' => $receipt); //'ET_RECEIPT_ACTIVE'=>1,
			$data['receipts_details'] = $this->obj_receipt->get_all_field_all_receipt($condition, "EVENT_RECEIPT.ET_RECEIPT_ID","desc", 10,$start, $like);
		}
				
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'Receipt/all_receiptSearch';
		$config['total_rows'] = $this->obj_receipt->get_all_receipt_count($condition, '','',$like);
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
		//pagination ends
		
		unset($_SESSION['receiptNo']);
		
		$this->load->view('header',$data);
		$this->load->view('all_receipt');
		$this->load->view('footer_home');
	}
	
	function all_receiptSearch_deity($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		$data['whichTab'] = "receipt";
		
		if(@$_POST['date'] != "") {
			$_SESSION['date'] = $this->input->post('date');
			$data['date'] = $this->input->post('date');
			$dateReceipt = $this->input->post('date');
		}
		
		if(@$_SESSION['date'] == "") {
			$this->session->set_userdata('date', $this->input->post('date'));
			$data['date'] = $_SESSION['date'];
			$dateReceipt = $this->input->post('date');
		} else {
			$dateReceipt = $_SESSION['date'];
			$data['date'] = $_SESSION['date'];
		}
		
		if(@$_POST['receipt'] != "") {
			unset($_SESSION['receipt']);
			$_SESSION['receipt'] = $this->input->post('receipt');
			$receipt = $this->input->post('receipt');
			$data['Receipt'] = $this->input->post('receipt');
		}
		
		if(@$_SESSION['receipt'] == "") {
			$this->session->set_userdata('receipt', $this->input->post('receipt'));
			$receipt = $this->input->post('receipt');
			$data['Receipt'] = $_SESSION['receipt'];
		} else {
			$receipt = $_SESSION['receipt'];
			$data['Receipt'] = $_SESSION['receipt'];
		}
		
		if(@$_POST['receiptNo'] != "") {
			unset($_SESSION['receiptNo']);
			$_SESSION['receiptNo'] = $this->input->post('receiptNo');
			$receiptNo = $this->input->post('receiptNo');
			$data['receiptNo'] = $this->input->post('receiptNo');
		}
		
		if(@$_SESSION['receiptNo'] == "") {
			$this->session->set_userdata('receiptNo', $this->input->post('receiptNo'));
			$receiptNo = $this->input->post('receiptNo');
			$data['receiptNo'] = $_SESSION['receiptNo'];
		} else {
			$receiptNo = $_SESSION['receiptNo'];
			$data['receiptNo'] = $_SESSION['receiptNo'];
		}
				
		if(@$receipt == 0) {
			$condition = array('RECEIPT_DATE' => $dateReceipt);
			if($receiptNo != "")
				$like = $receiptNo;
			else
				$like= "";
			$data['receipts_details'] = $this->obj_receipt->get_all_field_all_receipt_deity($condition, "DEITY_RECEIPT.RECEIPT_ID","desc", 10,$start, $like);
		} else {
			if($receiptNo != "")
				$like = $receiptNo;
			else
				$like= "";
			$condition = array('RECEIPT_DATE' => $dateReceipt, 'DEITY_RECEIPT.RECEIPT_CATEGORY_ID' => $receipt);
			$data['receipts_details'] = $this->obj_receipt->get_all_field_all_receipt_deity($condition, "DEITY_RECEIPT.RECEIPT_ID","desc", 10,$start, $like);
		}
				
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'Receipt/all_receiptSearch_deity';
		$config['total_rows'] = $this->obj_receipt->get_all_receipt_count_deity($condition, '','',$like);
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
		
		//pagination ends
		//if(isset($_SESSION['receiptNo']))
		//echo "<br>".$_SESSION['receiptNo']."<br>";	
		//echo "<br>Hello2".$receiptNo;
		
		unset($_SESSION['receiptNo']);
		$this->load->view('header',$data);
		$this->load->view('all_receipt_deity');
		$this->load->view('footer_home');
	}
	
	//RECEIPT FOR EVENT DONATION
	function receipt_donation()	{
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');
		//For Menu Selection
		$data['whichTab'] = "receipt";
		//NOTIFICATION
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		//SLAP
		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..

		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);
		$data['event'] = $this->obj_events->getEvents();
		
		if(isset($_SESSION['Event_Donation/Kanike'])) {
			$this->load->view('header', $data);
			$this->load->view('receipt_event_dk');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//RECEIPT FOR EVENT DONATION SAVE
	function receipt_dk_save() {
		$_SESSION['duplicate'] = "no";
		$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = "";$fglhBank ="";			//laz new
		
		if(isset($_POST["transactionId"])) {
			$transcId = $this->input->post('transactionId');
		}

		if(isset($_POST["chequeNo"])) {
			$chequeNo = $this->input->post('chequeNo');
		}
		
		if(isset($_POST["chequeDate"])) {
			$chequeDate = $this->input->post('chequeDate');
		}
		
		if(isset($_POST["bank"])) {
			$bank = $this->input->post('bank');
		}

		if($_POST["tobank"] != 0) {									//LAZ new
			$fglhBank = $this->input->post('tobank');
		}															

		if($_POST["DCtobank"] != 0) {								
			$fglhBank = $this->input->post('DCtobank');
		}															//LAZ new ..
		
		if(isset($_POST["branch"])) {
			$branch = $this->input->post('branch');
		}
		
		$this->db->select()->from('EVENT_RECEIPT_CATEGORY')
			->join('EVENT_RECEIPT_COUNTER', 'EVENT_RECEIPT_CATEGORY.ET_ACTIVE_RECEIPT_COUNTER_ID = EVENT_RECEIPT_COUNTER.ET_RECEIPT_COUNTER_ID')
			->where(array('EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID'=>'2'));
			
		$query = $this->db->get();
		$eventCounter = $query->first_row();
		$counter = $eventCounter->ET_RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('ET_RECEIPT_COUNTER_ID',$eventCounter->ET_ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('EVENT_RECEIPT_COUNTER', array('ET_RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		
		$receiptFormat = $eventCounter->ET_ABBR1 ."/".$datMonth."/".$eventCounter->ET_ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;
		
		if($this->input->post('modeOfPayment') == "Cheque") {
			$paymentStatus = "Pending";
		} else {
			$paymentStatus = "Completed";
		}
		
		$postage = $this->input->post('postage') || 0;
		$postageAmt = $_POST['postageAmt'];
		if($_POST['postageAmt'] == 0) {
			$postageGroup = 0;
		} else {
			$postageGroup = 1;
		}
		$addressLine1 = $_POST['addLine1'];
		$addressLine2 = $_POST['addLine2'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$pincode = $_POST['pincode'];
		
		$data = array(
			'ET_RECEIPT_NO' => $receiptFormat,
			'ET_RECEIPT_NAME' => $this->input->post('name'),
			'ET_RECEIPT_PHONE' => $this->input->post('number'),
			'ET_RECEIPT_EMAIL' => $this->input->post('email'),
			'ET_RECEIPT_ADDRESS' => $this->input->post('address'),
			'ET_RECEIPT_DATE' => date('d-m-Y'),
			'ET_RECEIPT_PAYMENT_METHOD' => $this->input->post('modeOfPayment'),
			'ET_RECEIPT_PRICE' => $this->input->post('amount'),
			'ET_RECEIPT_PAYMENT_METHOD_NOTES' => $this->input->post('paymentNotes'),
			'RECEIPT_ET_ID' => $this->input->post('eventId'),
			'RECEIPT_ET_NAME' => $this->input->post('eventName'),
			'ET_RECEIPT_ISSUED_BY_ID' =>$_SESSION['userId'],
			'ET_RECEIPT_ISSUED_BY' =>$_SESSION['userFullName'],
			'EOD_CONFIRMED_BY_ID' =>0,
			'DATE_TIME' => date('d-m-Y H:i:s A'),
			'ET_RECEIPT_ACTIVE' =>1,
			'ET_RECEIPT_CATEGORY_ID' =>2,
			'CHEQUE_NO' => $chequeNo,
			'CHEQUE_DATE' => $chequeDate,
			'BANK_NAME' => $bank,
			'BRANCH_NAME' => $branch,
			'TRANSACTION_ID' => $transcId,
			'PAYMENT_STATUS'=>$paymentStatus,
			'AUTHORISED_STATUS'=>'No',
			'POSTAGE_CHECK' => $postage,
			'POSTAGE_PRICE' => $postageAmt,
			'POSTAGE_GROUP_ID' => $postageGroup,
			'ADDRESS_LINE1' => $addressLine1,
			'ADDRESS_LINE2' => $addressLine2,
			'CITY' => $city,
			'COUNTRY' => $country,
			'PINCODE' => $pincode,							//laz new		
			'FGLH_ID' => $fglhBank							//laz new ..
		); 
		$receiptId = $this->obj_receipt->add_receipt_hundi_event_modal($data);
		$_SESSION['receiptId'] = $receiptId;
		
		if($postage == 1) {
			$dataPostage = array(
				'RECEIPT_ID' => $receiptId,
				'POSTAGE_CATEGORY' => 2,
				'POSTAGE_STATUS' => 0,
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'DATE' => date('d-m-Y'));
			$this->db->insert('POSTAGE', $dataPostage);
		}
		redirect('/Receipt/receipt_donationPrint/');
	}

	
	function receipt_donationPrint() {
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		$data['whichTab'] = "receipt";
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		if(isset($_POST['receiptFormat'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
		} else if(isset($_POST['receiptFormat1'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		} else if(!isset($_SESSION['receiptId']) && isset($_SESSION['reload'])){
            redirect('Receipt/all_receipt');
			unset($_SESSION['reload']);
		}
				
		$receiptFormat = $_SESSION['receiptFormat'];
		$receiptId = $_SESSION['receiptId'];
		
		//Commented code UnCommented
		unset($_SESSION['receiptFormat']);
		unset($_SESSION['receiptId']);
		
		$_SESSION['reload'] = 'reload';
		$this->db->select()->from('EVENT_RECEIPT')
		->where(array('EVENT_RECEIPT.ET_RECEIPT_ID'=>$receiptId));
		
		$query = $this->db->get();
		$data['eventCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->load->view('header', $data);
		$this->load->view('receipt_donationPrint');
		$this->load->view('footer_home');
	}
	
	//RECEIPT FOR DEITY KANIKE
	function receipt_deity_kanike() {		
		//For Menu Selection
		$data['whichTab'] = "receipt";
		//NOTIFICATION
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));

		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks();					    //laz..

		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");		

				//laz new ..
		
		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);

		//GET DEITY
		$condition = array('DEITY_ACTIVE' => 1);
		$data['deity'] = $this->obj_receipt->get_all_field_deity($condition);

		$condition1 = array('KS_STATUS' => 1);
		$data['kanikeFor'] = $this->obj_receipt->get_all_field_kanike_name($condition1);
		
		if(isset($_SESSION['Deity_Kanike'])) {
			$this->load->view('header', $data);
			$this->load->view('receipt_deity_kanike');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	
	//SAVE KANIKE RECEIPT
	function receipt_deity_kanike_save() {
		$data['whichTab'] = "receipt"; 
		$_SESSION['duplicate'] = "no"; 
		$pan="";$adhaar="";$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = "";$fglhBank ="";			//laz new;
		
		if(isset($_POST["transactionId"])) { 
			$transcId = $this->input->post('transactionId');
		}

		if(isset($_POST["chequeNo"])) {
			$chequeNo = $this->input->post('chequeNo');
		}
		if(isset($_POST["pan"])) {
			$pan = $this->input->post('pan');
		}
		if(isset($_POST["adhaar"])) {
			$adhaar = $this->input->post('adhaar');
		}
		
		if(isset($_POST["chequeDate"])) {
			$chequeDate = $this->input->post('chequeDate');
		}
		
		if(isset($_POST["bank"])) {
			$bank = $this->input->post('bank');
		}
		
		if(isset($_POST["branch"])) {
			$branch = $this->input->post('branch');
		}

		if($_POST["tobank"] != 0) {									//LAZ new
			$fglhBank = $this->input->post('tobank');
		}															

		if($_POST["DCtobank"] != 0) {								
			$fglhBank = $this->input->post('DCtobank');

		}															//LAZ new ..
		
		if($this->input->post('modeOfPayment') == "Cheque") { 
			$paymentStatus = "Pending";
		} else {
			$paymentStatus = "Completed"; 
		}
		
		$deity = explode('|', $this->input->post('deity'));
		$kanikeFor	 = explode('|', $this->input->post('kanikeFor'));//Suraksha
		$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'3'));
		
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		
		$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;
		
		$postage = $this->input->post('postage') || 0; 
		$postageAmt = $_POST['postageAmt'];
		if($_POST['postageAmt'] == 0) {
			$postageGroup = 0;
		} else {
			$postageGroup = 1;
		}
		$addressLine1 = $_POST['addLine1'];
		$addressLine2 = $_POST['addLine2'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$pincode = $_POST['pincode'];
		
		$data = array( 
			'RECEIPT_NO'=> $receiptFormat,
			'RECEIPT_DATE'=> date('d-m-Y'),
			'RECEIPT_NAME' => $this->input->post('name'),
			'RECEIPT_PHONE' => $this->input->post('number'),
			'RECEIPT_EMAIL' => $this->input->post('email'),
			'RECEIPT_ADDRESS' => $this->input->post('address'),
			'RECEIPT_PAYMENT_METHOD'=> $this->input->post('modeOfPayment'),
			'CHEQUE_NO' => $chequeNo,
			'CHEQUE_DATE' => $chequeDate,
			'BANK_NAME' => $bank,
			'BRANCH_NAME' => $branch,
			'TRANSACTION_ID' => $transcId,
			'PAYMENT_STATUS'=>$paymentStatus,
			'AUTHORISED_STATUS'=>'No',
			'RECEIPT_PRICE'=> $this->input->post('amount'),
			'RECEIPT_PAYMENT_METHOD_NOTES'=>$this->input->post('paymentNotes'),
			'RECEIPT_DEITY_ID'=>$deity[0],
			'RECEIPT_DEITY_NAME'=>$deity[1],
			'KANIKE_FOR' => $kanikeFor[0], //Suraksha
			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'DATE_TIME' => date('d-m-Y H:i:s A'),
			'RECEIPT_ACTIVE'=>1,
			'RECEIPT_CATEGORY_ID'=>3,
			'POSTAGE_CHECK' => $postage,
			'POSTAGE_PRICE' => $postageAmt,
			'POSTAGE_GROUP_ID' => $postageGroup,
			'ADDRESS_LINE1' => $addressLine1,
			'ADDRESS_LINE2' => $addressLine2,
			'CITY' => $city,
			'COUNTRY' => $country,
			'PINCODE' => $pincode,
			'FGLH_ID' => $fglhBank	,
			'RECEIPT_PAN_NO'=>$pan,
			'RECEIPT_ADHAAR_NO'=>$adhaar						//laz new ..

		); 
		
		$receiptId = $this->obj_receipt->add_receipt_deity_modal($data);//inserting values of data array to deity_Receipt
		$_SESSION['receiptId'] = $receiptId;//setting receipt id as session variable
		
		if($postage == 1) {// if postage is checked then store following values in POSTAGE table
			$dataPostage = array(
					'RECEIPT_ID' => $receiptId,
					'POSTAGE_CATEGORY' => 1,
					'POSTAGE_STATUS' => 0,
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'));
			$this->db->insert('POSTAGE', $dataPostage);//insert satatement
		}
		redirect('/Receipt/receipt_donationKanikePrint/');// redirect to function 'receipt_donationKanikePrint' within receipt controller
	}

	
	function addCorpusReceipt(){
		
		$dateTime = date('d-m-Y H:i:s A');
		$phone = @$_POST['smphone'];
		$name = @$_POST['namePhone'];
		$todayDate = date('d-m-Y');
        $sevaName = @$_POST['sevaname'];
        $deityName = @$_POST['deityIdName'];
        $corpus = @$_POST['corpus'];
      
        $bookreceiptno = @$_POST['bookreceiptno'];
        $corpCallFrom = @$_POST['corpusCallFrom'];
		$checkdate = @$_POST['checkdate'];
		$chequeNo = @$_POST['chequeNo'];
		$bank = @$_POST['bank'];
		$branch = @$_POST['branch'];        
		$transactionId = @$_POST['transactionId'];						        
		$flghBank = "";						
        $modeOfPayment = @$_POST['modeOfPayment'];				
        $adlCrpBookDate = @$_POST['adlCrpBookDate'];
        $paidBy = "";

        $addrline1 = strtoupper(@$_POST['addr1']);
		$addrline2 = strtoupper(@$_POST['addr2']);
		$smcity = strtoupper(@$_POST['sccity']);
		$smstate = strtoupper(@$_POST['ssstate']);
		$smcountry = strtoupper(@$_POST['sccountry']);
		$smpin = @$_POST['cpin'];
		
		
		$sm_address = (($addrline1 != "")?$addrline1.", ":"").(($addrline2 != "")?$addrline2.", ":"").(($smcity != "")?$smcity." ":"").(($smstate != "")?$smstate." ":"").(($smcountry != "")?$smcountry." - ":"").(($smpin != "")?$smpin:"");

        if (isset($_POST['paidBy'])) {
        	$paidBy = $_POST['paidBy'];
        }else{
        	$paidBy = "";
        }

        if($modeOfPayment == "Direct Credit")
        {
        	$flghBank = @$_POST['tobank'];
        }
        else if($modeOfPayment == "Credit / Debit Card"){
        	$flghBank = @$_POST['DCtobank'];
        }															
        $paymentNotes = @$_POST['paymentNotes'];
        $ssId = @$_POST['ssId']; 
		 $this ->db->select('SS_REF,shashwath_members.SM_REF')->from('shashwath_seva')-> join('shashwath_members','shashwath_members.SM_ID = shashwath_seva.SM_ID')
		->where(array('shashwath_seva.SS_ID'=>$ssId ));  
		$query = $this->db->get();
		$refnums = $query->result();
		$this->db->select()->from('SHASHWATH_MEMBER_SEVA_REFERENCE');	
		$query = $this->db->get();
		$rowResult = $query->first_row();					
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$format = $rowResult->SMR_ABBR1.'/'.$datMonth.'/'.$rowResult->SM_ABBR1.$refnums[0]->SM_REF.'/'.$rowResult->SS_ABBR1.$refnums[0]->SS_REF;
		$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=> 7 ));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->RECEIPT_COUNTER;
		$counter += 1;
		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		$Ref = $counter;				
		$receiptFormat = $format.'/'.$Ref;
		
		$receiptData = array(
			'SS_ID'   =>$ssId,
			'RECEIPT_NAME'=>$name,
			'RECEIPT_PHONE'=>$phone,
			'RECEIPT_ADDRESS'=>$sm_address,
			'RECEIPT_DEITY_NAME'=>$deityName,
			'RECEIPT_NO'=>$receiptFormat,
			'RECEIPT_DATE'=>$adlCrpBookDate,
			'RECEIPT_PRICE'    =>$corpus,
			'CHEQUE_NO' => $chequeNo,
			'CHEQUE_DATE' => $checkdate,
			'BANK_NAME' => $bank,
			'BRANCH_NAME' => $branch,
			'TRANSACTION_ID' =>	$transactionId,						
			'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,
			'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,
			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'RECEIPT_ACTIVE'=>1,
			'RECEIPT_CATEGORY_ID'=>7,
			'PAYMENT_STATUS'=>'Completed',
			'AUTHORISED_STATUS'=>'No',
			'FGLH_ID' => $flghBank,
			'SS_RECEIPT_NO_REF' => $bookreceiptno,
			'ADDL_MM_PAID_BY' => $paidBy,
			'DATE_TIME'=>date('d-m-Y H:i:s A')
		); 
						
		$this->db->insert('DEITY_RECEIPT', $receiptData);
		$SHASHWATH_RECEIPT = $this->db->insert_id();

		if($modeOfPayment=='Transfer'){

		$this->db->select()->from('finance_voucher_counter')
		->where(array('finance_voucher_counter.FVC_ID'=>'5'));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->FVC_COUNTER+1;
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$countNoJ = $deityCounter->FVC_ABBR1 ."/".$datMonth."/".$deityCounter->FVC_ABBR2."/".$counter;
		$naration = str_replace("'","\'",@$_POST['naration']);
		$type = json_decode(@$_POST['type']);
		$ledgers = json_decode(@$_POST['ledgers']);
		$amount = json_decode(@$_POST['amount']);
		$tDateJ =date('d-m-Y');
		$user= $_SESSION['userId'];
		for($i = 0; $i < count($amount); ++$i) {
			$lidJ = $ledgers[$i];

			if($type[$i]=="from")
			{
				$firstAmt = 0;
				$secondAmt = $amount[$i];
				$rptype = "J1";
				$this->obj_finance->putJournalTransfer($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$user,$rptype,$SHASHWATH_RECEIPT);
			 } 
		}
		$lidJ = 25;
		$firstAmt =$corpus;
		$secondAmt = 0;
		$rptype = "J2";
		$this->obj_finance->putJournalTransfer($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$user,$rptype,$SHASHWATH_RECEIPT);

		$this->db->where('finance_voucher_counter.FVC_ID',5);
		$this->db->update('finance_voucher_counter', array('FVC_COUNTER'=>$counter));
	}

        echo "success";

        $_SESSION['CorpusReceiptId'] = $SHASHWATH_RECEIPT;
        $_SESSION['CorpusCallFrom'] = $corpCallFrom;
     
	}
		//SAVE JEERNODHARA KANIKE RECEIPT
	function receipt_Jeernodhara_kanike_save() {
		$data['whichTab'] = "receipt"; 
		$_SESSION['duplicate'] = "no"; 
		$adhaar = "";$pan = "";$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = "";$fglhBank ="";			//laz new
		
		if(isset($_POST["transactionId"])) { 
			$transcId = $this->input->post('transactionId');
		}

		if(isset($_POST["chequeNo"])) {
			$chequeNo = $this->input->post('chequeNo');
		}
		
		if(isset($_POST["chequeDate"])) {
			$chequeDate = $this->input->post('chequeDate');
		}
		
		if(isset($_POST["bank"])) {
			$bank = $this->input->post('bank');
		}

		if($_POST["tobank"] != 0) {									//LAZ new
			$fglhBank = $this->input->post('tobank');
		}															

		if($_POST["DCtobank"] != 0) {								
			$fglhBank = $this->input->post('DCtobank');
		}															//LAZ new ..
		
		if(isset($_POST["branch"])) {
			$branch = $this->input->post('branch');
		}
		if(isset($_POST["pan"])){
			$pan = $this->input->post('pan');
		}
		if(isset($_POST["adhaar"])){
			$adhaar = $this->input->post('adhaar');
		}
		
		if($this->input->post('modeOfPayment') == "Cheque") { 
			$paymentStatus = "Pending";
		} else {
			$paymentStatus = "Completed"; 
		}
		
		$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'8'));
		
		
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		
		$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;
		
		
		/* $query = $this->db->get();
		$JHCounter = $query->first_row();
		$JH_ID = $JHCounter->JH_ID;
		$counter = $JHCounter->RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('HEAD_COUNTER_ID',$JHCounter->JH_ACTIVE_COUNTER_HEAD_ID);
		$this->db->update('jeernodhara_head_counter', array('RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		
		$receiptFormat = $JHCounter->ABBR1 ."/".$datMonth."/".$JHCounter->ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat; */
		//print_r($receiptFormat);
		$postage = $this->input->post('postage') || 0; 
		$postageAmt = $_POST['postageAmt'];
		if($_POST['postageAmt'] == 0) {
			$postageGroup = 0;
		} else {
			$postageGroup = 1;
		}
		$addressLine1 = $_POST['addLine1'];
		$addressLine2 = $_POST['addLine2'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$pincode = $_POST['pincode'];
		
		 $data = array( 
			'RECEIPT_NO'=> $receiptFormat,
			'RECEIPT_DATE'=> date('d-m-Y'),
			'RECEIPT_NAME' => $this->input->post('name'),
			'RECEIPT_PHONE' => $this->input->post('number'),
			'RECEIPT_EMAIL' => $this->input->post('email'),
			'RECEIPT_ADDRESS' => $this->input->post('address'),
			'RECEIPT_PAYMENT_METHOD'=> $this->input->post('modeOfPayment'),
			'CHEQUE_NO' => $chequeNo,
			'CHEQUE_DATE' => $chequeDate,
			'BANK_NAME' => $bank,
			'BRANCH_NAME' => $branch,
			'TRANSACTION_ID' => $transcId,
			'PAYMENT_STATUS'=>$paymentStatus,
			'AUTHORISED_STATUS'=>'No',
			'RECEIPT_PRICE'=> $this->input->post('amount'),
			'RECEIPT_PAYMENT_METHOD_NOTES'=>$this->input->post('paymentNotes'),
			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'DATE_TIME' => date('d-m-Y H:i:s A'),
			'RECEIPT_ACTIVE'=>1,
			'RECEIPT_CATEGORY_ID'=>8,
			'IS_JEERNODHARA' => 1,
			'POSTAGE_CHECK' => $postage,
			'POSTAGE_PRICE' => $postageAmt,
			'POSTAGE_GROUP_ID' => $postageGroup,
			'ADDRESS_LINE1' => $addressLine1,
			'ADDRESS_LINE2' => $addressLine2,
			'CITY' => $city,
			'COUNTRY' => $country,
			'PINCODE' => $pincode,							//laz new		
			'FGLH_ID' => $fglhBank,
			'RECEIPT_ADHAAR_NO'=>$adhaar,
			'RECEIPT_PAN_NO'=>$pan					//laz new ..

		); 
		
		$receiptId = $this->obj_receipt->add_receipt_Jeernodhara_modal($data);//inserting values of data array to deity_Receipt
		$_SESSION['receiptId'] = $receiptId;//setting receipt id as session variable
		
		if($postage == 1) {// if postage is checked then store following values in POSTAGE table
			$dataPostage = array(
					'RECEIPT_ID' => $receiptId,
					'POSTAGE_CATEGORY' => 1,
					'POSTAGE_STATUS' => 0,
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'));
			$this->db->insert('POSTAGE', $dataPostage);//insert satatement
		}
		redirect('Receipt/jeernodhara_kanikePrint/');// redirect to function 'receipt_donationKanikePrint' within receipt controller */
	}		
	
	function jeernodhara_kanikePrint() {
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);

		/*if($_SESSION['actual_link'] == site_url() . 'Receipt/daily_report/')
			$data['whichTab'] = "Jeernodhara";
		else 
			$data['whichTab'] = "receipt";
		$data['fromAllReceipt'] = "1";*/
		if($_SESSION['back_link'] == 'Jeernodhara/Jeernodhara_Kanike' || $_SESSION['back_link'] == 'Receipt/daily_report') {
			$data['whichTab'] = "Jeernodhara";
			$_SESSION['back_link'] = site_url().'Receipt/daily_report';
		} else {
			$data['whichTab'] = "receipt";
			$_SESSION['back_link'] = site_url().$_SESSION['back_link'];
		}

		//print_r($_SESSION);

		if(isset($_POST['receiptId'])) {
			$_SESSION['receiptId'] = $_POST['receiptId'];
		}
		
		$receiptId = $_SESSION['receiptId'];
		
		$this->db->select()->from('DEITY_RECEIPT')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));// selecting row from deity receipt with respect to receipt id
		
		$query = $this->db->get();
		$data['deityCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		
		$this->load->view('header',$data);	
		$this->load->view('Jeernodhara/jeernodhara_kanikePrint');
		$this->load->view('footer_home');
	}
	
	
	function receipt_donationKanikePrint() {
		$todayDate = date('d-m-Y');//current date
		$dateTime = date('d-m-Y H:i:s A'); //current date, current time with AM or PM
		$deviceIP = $this->input->ip_address();
		
		$data['duplicate'] = @$_SESSION['duplicate'];//to print whether the receipt is duplicate or not
		unset($_SESSION['duplicate']);
		
		$data['whichTab'] = "receipt";//in menu which tab should be highlighted
		 if(isset($_POST['receiptFormatDeity1'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormatDeity1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		} else if(isset($_POST['receiptFormat'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
		}else if(isset($_SESSION['recFor'])) {
			$_SESSION['receiptFormat'] = $_SESSION['recFor'];
			$_SESSION['receiptId'] = $_SESSION['receiptId'];
			$data['fromAllReceipt'] = "1";
		} 
		
		$receiptFormat = $_SESSION['receiptFormat'];
		$receiptId = $_SESSION['receiptId'];
		// unset($_SESSION['receiptFormat']);
		// unset($_SESSION['receiptId']);

		$this->db->select()->from('DEITY_RECEIPT')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));// selecting row from deity receipt with respect to receipt id
		$this->db->join('KANIKE_SETTING','KANIKE_SETTING.KS_ID = DEITY_RECEIPT.KANIKE_FOR');
		
		$query = $this->db->get();
		$data['deityCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		
		$this->db->select()->from('DEITY_KANIKE_SPECIAL_RECEIPT_PRICE');
		
		$query = $this->db->get();
		$data['DEITY_KANIKE_SPECIAL_RECEIPT_PRICE'] = $query->row();
		
		$this->load->view('header', $data);
		$this->load->view('receipt_deity_kanikePrint');
		$this->load->view('footer_home');
	}
	
	//RECEIPT FOR SRNS FUND
	function receipt_srns_fund() {
		//For Menu Selection
		$data['whichTab'] = "receipt";
		//NOTIFICATION
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));

		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks();					    //laz..


		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..

		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);
		
		//GET DEITY
		$condition = array('DEITY_ACTIVE' => 1);
		$data['deity'] = $this->obj_receipt->get_all_field_deity_limit($condition);
		
		if(isset($_SESSION['SRNS_Fund'])) {
			$this->load->view('header', $data);
			$this->load->view('receipt_srns_fund');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	
	//SAVE SRNS FUND RECEIPT
	function receipt_srns_fund_save() {
		$_SESSION['duplicate'] = "no"; 
		$pan="";$adhaar="";$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = "";$fglhBank ="";			//laz new;
		

		if(isset($_POST["pan"])){
			$pan = $this->input->post('pan');
		}
		if(isset($_POST["adhaar"])){
			$adhaar = $this->input->post('adhaar');
		}

		if(isset($_POST["transactionId"])) { 
			$transcId = $this->input->post('transactionId'); 
		}

		if(isset($_POST["chequeNo"])) { 
			$chequeNo = $this->input->post('chequeNo'); 
		}
		
		if(isset($_POST["chequeDate"])) {
			$chequeDate = $this->input->post('chequeDate'); 
		}
		
		if(isset($_POST["bank"])) { 
			$bank = $this->input->post('bank');
		}
		
	
		if($_POST["tobank"] != 0) {									//LAZ new
			$fglhBank = $this->input->post('tobank');
		}															

		if($_POST["DCtobank"] != 0) {								
			$fglhBank = $this->input->post('DCtobank');
		}
																	//LAZ new ..
		if(isset($_POST["branch"])) { 
			$branch = $this->input->post('branch');
		}
		
		if($this->input->post('modeOfPayment') == "Cheque") { 
			$paymentStatus = "Pending"; 
		} else {
			$paymentStatus = "Completed";
		}
		
		$deity = explode('|', $this->input->post('deity'));
		$this->db->select()->from('DEITY_RECEIPT_CATEGORY') 
		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'6')); 
		
		$query = $this->db->get(); 
		$deityCounter = $query->first_row();
		$counter = $deityCounter->RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter)); 
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;
		
		$postage = $this->input->post('postage') || 0;
		$postageAmt = $_POST['postageAmt'];
		if($_POST['postageAmt'] == 0) { 
			$postageGroup = 0;
		} else {
			$postageGroup = 1; 
		}
		$addressLine1 = $_POST['addLine1'];
		$addressLine2 = $_POST['addLine2'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$pincode = $_POST['pincode']; 
		
		$data = array( 
			'RECEIPT_NO'=> $receiptFormat,
			'RECEIPT_DATE'=> date('d-m-Y'),
			'RECEIPT_NAME' => $this->input->post('name'),
			'RECEIPT_PHONE' => $this->input->post('number'),
			'RECEIPT_EMAIL' => $this->input->post('email'),
			'RECEIPT_ADDRESS' => $this->input->post('address'),
			'RECEIPT_PAYMENT_METHOD'=> $this->input->post('modeOfPayment'),
			'CHEQUE_NO' => $chequeNo,
			'CHEQUE_DATE' => $chequeDate,
			'BANK_NAME' => $bank,
			'BRANCH_NAME' => $branch,
			'TRANSACTION_ID' => $transcId,
			'PAYMENT_STATUS'=>$paymentStatus,
			'AUTHORISED_STATUS'=>'No',
			'RECEIPT_PRICE'=> $this->input->post('amount'),
			'RECEIPT_PAYMENT_METHOD_NOTES'=>$this->input->post('paymentNotes'),
			'RECEIPT_DEITY_ID'=>$deity[0],
			'RECEIPT_DEITY_NAME'=>$deity[1],
			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'DATE_TIME' => date('d-m-Y H:i:s A'),
			'RECEIPT_ACTIVE'=>1,
			'RECEIPT_CATEGORY_ID'=>6,
			'POSTAGE_CHECK' => $postage,
			'POSTAGE_PRICE' => $postageAmt,
			'POSTAGE_GROUP_ID' => $postageGroup,
			'ADDRESS_LINE1' => $addressLine1,
			'ADDRESS_LINE2' => $addressLine2,
			'CITY' => $city,
			'COUNTRY' => $country,
			'PINCODE' => $pincode,
			'FGLH_ID' => $fglhBank,
			'RECEIPT_ADHAAR_NO'=>$adhaar,
			'RECEIPT_PAN_NO'=>$pan					//laz new ..
						//laz new ..
		); 
		
		$receiptId = $this->obj_receipt->add_receipt_deity_modal($data);
		$_SESSION['receiptId'] = $receiptId;

		if($postage == 1) {
			$dataPostage = array(
				'RECEIPT_ID' => $receiptId,
				'POSTAGE_CATEGORY' => 1,
				'POSTAGE_STATUS' => 0,
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'DATE' => date('d-m-Y'));
			$this->db->insert('POSTAGE', $dataPostage);
		}
		redirect('/Receipt/receipt_SRNSDeityPrint/');
	}

	
	//SRNS FUND PRINT
	function receipt_SRNSDeityPrint() {
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		
		$data['whichTab'] = "receipt";
		if(isset($_POST['receiptFormat'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
		} else if(isset($_POST['receiptFormatDeity1'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormatDeity1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		} else if(isset($_SESSION['recFor'])) {
			$_SESSION['receiptFormat'] = $_SESSION['recFor'];
			$_SESSION['receiptId'] = $_SESSION['receiptId'];
			$data['fromAllReceipt'] = "1";
		}
		
		$receiptFormat = $_SESSION['receiptFormat'];
		$receiptId = $_SESSION['receiptId'];
		
		// unset($_SESSION['receiptFormat']);
		// unset($_SESSION['receiptId']);
		
		$this->db->select()->from('DEITY_RECEIPT')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
		
		$query = $this->db->get();
		$data['deityCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->load->view('header', $data);
		$this->load->view('receipt_SRNSDeityPrint');
		$this->load->view('footer_home');
	}
	
	
	//print Shashwath Receipt from all deity
	function receipt_ShaswathPrint() {
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		$data['whichTab'] = "receipt";
		if(isset($_POST['receiptFormat'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
		} else if(isset($_POST['receiptFormatDeity1'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormatDeity1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		} else if(isset($_SESSION['recFor'])) {
			$_SESSION['receiptFormat'] = $_SESSION['recFor'];
			$_SESSION['receiptId'] = $_SESSION['receiptId'];
			$data['fromAllReceipt'] = "1";
		} else if(isset($_SESSION['recFor']))
		
		$receiptFormat = $_SESSION['receiptFormat'];
		$receiptId = $_SESSION['receiptId'];
		$this->db->select('RECEIPT_ID,SS_RECEIPT_NO,shashwath_members.SM_RASHI,shashwath_members.SM_NAKSHATRA,shashwath_members.SM_GOTRA,shashwath_members.SM_CITY, shashwath_seva.SM_ID,TRANSACTION_ID ,deity_seva.SEVA_NAME,RECEIPT_NO,RECEIPT_NAME,RECEIPT_DATE,RECEIPT_ADDRESS,RECEIPT_PHONE,RECEIPT_PRICE,DEITY_NAME,POSTAGE_PRICE,RECEIPT_PAYMENT_METHOD,CHEQUE_NO,CHEQUE_DATE,BANK_NAME,BRANCH_NAME,RECEIPT_PAYMENT_METHOD_NOTES,RECEIPT_ACTIVE,AUTHORISED_STATUS,PRINT_STATUS,RECEIPT_ADDRESS,RECEIPT_ISSUED_BY,SEVA_NOTES,BASED_ON_MOON,MASA,THITHI_NAME,RECEIPT_RASHI,RECEIPT_NAKSHATRA,ENG_DATE')->from('DEITY_RECEIPT')->join('shashwath_seva', 'shashwath_seva.SS_ID = DEITY_RECEIPT.SS_ID')->join('DEITY', 'shashwath_seva.DEITY_ID = DEITY.DEITY_ID')->join('deity_seva', 'deity_seva.SEVA_ID = shashwath_seva.SEVA_ID')->join('shashwath_members','shashwath_seva.SM_ID =shashwath_members.SM_ID')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
		$query =  $this->db->get();
		$data['deityCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->load->view('header', $data);
		$this->load->view('receipt_shashwathPrint');
		$this->load->view('footer_home');
	}

    function receipt_corpusTopup_print() {
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		if(isset($_SESSION['CorpusReceiptId'])) {
			$receiptId = $_SESSION['CorpusReceiptId'];
			$corpusCallFrom = $_SESSION['CorpusCallFrom'];
		}
		$data['fromAllReceipt'] = "7";
		
		if($corpusCallFrom == "LossDetail") 
			$this->db->select('deity_Receipt.RECEIPT_ID,shashwath_members.SM_CITY,shashwath_members.SM_RASHI,shashwath_members.SM_NAKSHATRA,shashwath_members.SM_GOTRA,shashwath_seva.SS_ID,SO_ID,shashwath_seva.SM_ID,deity_seva.SEVA_NAME,RECEIPT_NO,RECEIPT_NAME,RECEIPT_DATE,RECEIPT_ADDRESS,RECEIPT_PHONE,RECEIPT_PRICE,DEITY_NAME,POSTAGE_PRICE,RECEIPT_PAYMENT_METHOD,RECEIPT_PAYMENT_METHOD_NOTES,RECEIPT_ACTIVE,AUTHORISED_STATUS,PRINT_STATUS,RECEIPT_ADDRESS,RECEIPT_ISSUED_BY,CHEQUE_NO,CHEQUE_DATE,BANK_NAME,BRANCH_NAME,TRANSACTION_ID,ENG_DATE,SEVA_NOTES,BASED_ON_MOON,THITHI_NAME,MASA,RECEIPT_RASHI,RECEIPT_NAKSHATRA')->from('DEITY_RECEIPT')->join('shashwath_seva', 'shashwath_seva.SS_ID = DEITY_RECEIPT.SS_ID')->join('DEITY', 'shashwath_seva.DEITY_ID = DEITY.DEITY_ID')->join('deity_seva', 'deity_seva.SEVA_ID = shashwath_seva.SEVA_ID')->join('shashwath_members','shashwath_seva.SM_ID =shashwath_members.SM_ID')->join('deity_seva_offered', 'deity_seva_offered.SS_ID = shashwath_seva.SS_ID')->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
		else 
			$this->db->select('deity_Receipt.RECEIPT_ID,shashwath_members.SM_CITY,shashwath_members.SM_RASHI,shashwath_members.SM_NAKSHATRA,shashwath_members.SM_GOTRA,shashwath_seva.SS_ID, "0" AS SO_ID,shashwath_seva.SM_ID,deity_seva.SEVA_NAME,RECEIPT_NO,RECEIPT_NAME,RECEIPT_DATE,RECEIPT_ADDRESS,RECEIPT_PHONE,RECEIPT_PRICE,DEITY_NAME,POSTAGE_PRICE,RECEIPT_PAYMENT_METHOD,RECEIPT_PAYMENT_METHOD_NOTES,RECEIPT_ACTIVE,AUTHORISED_STATUS,PRINT_STATUS,RECEIPT_ADDRESS,RECEIPT_ISSUED_BY,CHEQUE_NO,CHEQUE_DATE,BANK_NAME,BRANCH_NAME,TRANSACTION_ID,ENG_DATE,SEVA_NOTES,BASED_ON_MOON,THITHI_NAME,MASA,RECEIPT_RASHI,RECEIPT_NAKSHATRA')->from('DEITY_RECEIPT')->join('shashwath_seva', 'shashwath_seva.SS_ID = DEITY_RECEIPT.SS_ID')->join('DEITY', 'shashwath_seva.DEITY_ID = DEITY.DEITY_ID')->join('shashwath_members','shashwath_seva.SM_ID =shashwath_members.SM_ID')->join('deity_seva', 'deity_seva.SEVA_ID = shashwath_seva.SEVA_ID')->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));

		$query = $this->db->get();
		$data['deityCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->load->view('header', $data);
		$this->load->view('receipt_shashwathCorpusPrint');
		$this->load->view('footer_home');
	}
	
	//RECEIPT FOR DEITY DONATION
	function receipt_deity_donation() {
		//For Menu Selection
		$data['whichTab'] = "receipt";
		//NOTIFICATION
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));

		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..


		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);
		
		
		//GET DEITY
		$condition = array('DEITY_ACTIVE' => 1);
		$data['deity'] = $this->obj_receipt->get_all_field_deity($condition);
		
		if(isset($_SESSION['Deity_Donation'])) {
			$this->load->view('header', $data);
			$this->load->view('receipt_deity_donation');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	
	//SAVE DONATION RECEIPT xxx
	function receipt_deity_donation_save() {
		$_SESSION['duplicate'] = "no";
		$pan="";$adhaar="";$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = ""; $fglhBank ="";			//laz new
		
		if(isset($_POST["transactionId"])) {
			$transcId = $this->input->post('transactionId');
		}
		if(isset($_POST["pan"])) {
			$pan = $this->input->post('pan');
		}
		if(isset($_POST["adhaar"])) {
			$adhaar = $this->input->post('adhaar');
		}

		if(isset($_POST["chequeNo"])) {
			$chequeNo = $this->input->post('chequeNo');
		}
		
		if(isset($_POST["chequeDate"])) {
			$chequeDate = $this->input->post('chequeDate');
		}
		
		if(isset($_POST["bank"])) {
			$bank = $this->input->post('bank');
		}

		if($_POST["tobank"] != 0) {									//LAZ new
			$fglhBank = $this->input->post('tobank');
		}															

		if($_POST["DCtobank"] != 0) {								
			$fglhBank = $this->input->post('DCtobank');
		}															//LAZ new ..
		
		if(isset($_POST["branch"])) {
			$branch = $this->input->post('branch');
		}
		
		if($this->input->post('modeOfPayment') == "Cheque") {
			$paymentStatus = "Pending";
		} else {
			$paymentStatus = "Completed";
		}
		
		$postage =  0;
		$postageAmt = $_POST['postageAmt'];
		if($_POST['postageAmt'] == 0) {
			$postageGroup = 0;
		} else {
			$postageGroup = 1;
		}
		$addressLine1 = $_POST['addLine1'];
		$addressLine2 = $_POST['addLine2'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$pincode = $_POST['pincode'];
		
		$deity = explode('|', $this->input->post('deity'));
		$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'2'));
		
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		
		$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;
		
		$data = array(
			'RECEIPT_NO'=> $receiptFormat,
			'RECEIPT_DATE'=> date('d-m-Y'),
			'RECEIPT_NAME' => $this->input->post('name'),
			'RECEIPT_PHONE' => $this->input->post('number'),
			'RECEIPT_EMAIL' => $this->input->post('email'),
			'RECEIPT_ADDRESS' => $this->input->post('address'),
			'RECEIPT_PAYMENT_METHOD'=> $this->input->post('modeOfPayment'),
			'CHEQUE_NO' => $chequeNo,
			'CHEQUE_DATE' => $chequeDate,
			'BANK_NAME' => $bank,
			'BRANCH_NAME' => $branch,
			'TRANSACTION_ID' => $transcId,
			'PAYMENT_STATUS'=>$paymentStatus,
			'AUTHORISED_STATUS'=>'No',
			'RECEIPT_PRICE'=> $this->input->post('amount'),
			'RECEIPT_PAYMENT_METHOD_NOTES'=>$this->input->post('paymentNotes'),
			'RECEIPT_DEITY_ID'=>$deity[0],
			'RECEIPT_DEITY_NAME'=>$deity[1],
			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'DATE_TIME' => date('d-m-Y H:i:s A'),
			'RECEIPT_ACTIVE'=>1,
			'RECEIPT_CATEGORY_ID'=>2,
			'POSTAGE_CHECK' => $postage,
			'POSTAGE_PRICE' => $postageAmt,
			'POSTAGE_GROUP_ID' => $postageGroup,
			'ADDRESS_LINE1' => $addressLine1,
			'ADDRESS_LINE2' => $addressLine2,
			'CITY' => $city,
			'COUNTRY' => $country,
			'PINCODE' => $pincode,							//laz new		
			'FGLH_ID' => $fglhBank,
			'RECEIPT_PAN_NO'=>$pan,
			'RECEIPT_ADHAAR_NO'=>$adhaar						//laz new ..
		); 
		
		$receiptId = $this->obj_receipt->add_receipt_deity_modal($data);
		$_SESSION['receiptId'] = $receiptId;
		
		if($postage == 1) {
			$dataPostage = array(
					'RECEIPT_ID' => $receiptId,
					'POSTAGE_CATEGORY' => 1,
					'POSTAGE_STATUS' => 0,
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'));
			$this->db->insert('POSTAGE', $dataPostage);
		}
		
		redirect('/Receipt/receipt_donationDeityPrint/');
	}

	
	function receipt_donationDeityPrint() {
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		$data['whichTab'] = "receipt";
		$data['duplicate'] = $this->session->duplicate;
		unset($_SESSION['duplicate']);
		if(isset($_POST['receiptFormat'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
		} else if(isset($_POST['receiptFormatDeity1'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormatDeity1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		} else if(isset($_SESSION['recFor'])) {
			$_SESSION['receiptFormat'] = $_SESSION['recFor'];
			$_SESSION['receiptId'] = $_SESSION['receiptId'];
			$data['fromAllReceipt'] = "1";
		}
		
		$receiptFormat = $_SESSION['receiptFormat'];
		$receiptId = $_SESSION['receiptId'];
		
		// unset($_SESSION['receiptFormat']);
		// unset($_SESSION['receiptId']);
		
		$this->db->select()->from('DEITY_RECEIPT')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
		
		$query = $this->db->get();
		$data['deityCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->db->select()->from('DEITY_DONATION_SPECIAL_RECEIPT_PRICE');
		
		$query = $this->db->get();
		$data['DEITY_DONATION_SPECIAL_RECEIPT_PRICE'] = $query->row();

		$this->load->view('header', $data);
		$this->load->view('receipt_donationDeityPrint');
		$this->load->view('footer_home');
	}
	
	//RECEIPT FOR INKIND
	function receipt_inkind() { 
		//For Menu Selection
		$data['whichTab'] = "receipt";
		//NOTIFICATION
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		$data['inkind_item'] = $this->obj_receipt->get_all_field_inkind_items();
		
		$condition = array('DEITY_ACTIVE' => 1);
		$data['deity'] = $this->obj_receipt->get_all_field_deity($condition);
		
		$conditionOne = array('ET_ACTIVE' => 1);
		$data['events'] = $this->obj_receipt->get_all_field_events($conditionOne);
		
		if(isset($_SESSION['Deity/Event_Inkind'])) {
			$this->load->view('header', $data);
			$this->load->view('receipt_inkind');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//RECEIPT FOR INKIND SAVE
	// function receipt_inkind_save() {
	// 	$_SESSION['duplicate'] = "no";
	// 	$selOpt = $this->input->post('selRadio');
		
	// 	$postage = $_POST['postage'] || 0;
	// 	$postageAmt = $_POST['postageAmt'];
	// 	if($_POST['postageAmt'] == 0) {
	// 		$postageGroup = 0;
	// 	} else {
	// 		$postageGroup = 1;
	// 	}
	// 	$addressLine1 = $_POST['addressLine1'];
	// 	$addressLine2 = $_POST['addressLine2'];
	// 	$city = $_POST['city'];
	// 	$country = $_POST['country'];
	// 	$pincode = $_POST['pincode'];
		
	// 	if($selOpt == 2) {
	// 		$event = explode('|', $this->input->post('event'));
	// 		$this->db->select()->from('EVENT_RECEIPT_CATEGORY')
	// 		->join('EVENT_RECEIPT_COUNTER', 'EVENT_RECEIPT_CATEGORY.ET_ACTIVE_RECEIPT_COUNTER_ID = EVENT_RECEIPT_COUNTER.ET_RECEIPT_COUNTER_ID')
	// 		->where(array('EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID'=>'4'));
			
	// 		$query = $this->db->get();
	// 		$eventCounter = $query->first_row();
	// 		$counter = $eventCounter->ET_RECEIPT_COUNTER;
	// 		$counter += 1;
			
	// 		$this->db->where('ET_RECEIPT_COUNTER_ID',$eventCounter->ET_ACTIVE_RECEIPT_COUNTER_ID);
	// 		$this->db->update('EVENT_RECEIPT_COUNTER', array('ET_RECEIPT_COUNTER'=>$counter));
	// 		$dfMonth = $this->obj_admin_settings->get_financial_month();
	// 		$datMonth = $this->get_financial_year($dfMonth);
			
	// 		$receiptFormat = $eventCounter->ET_ABBR1 ."/".$datMonth."/".$eventCounter->ET_ABBR2."/".$counter;
			
	// 		$data = array(
	// 			'ET_RECEIPT_NO'=> $receiptFormat,
	// 			'ET_RECEIPT_DATE'=> date('d-m-Y'),
	// 			'ET_RECEIPT_NAME' => $this->input->post('name'),
	// 			'ET_RECEIPT_PHONE' => $this->input->post('number'),
	// 			'ET_RECEIPT_EMAIL' => $this->input->post('email'),
	// 			'ET_RECEIPT_ADDRESS' => $this->input->post('address'),
	// 			'ET_RECEIPT_PAYMENT_METHOD_NOTES' => $this->input->post('paymentNotes'),
	// 			'RECEIPT_ET_ID'=>$event[0],
	// 			'RECEIPT_ET_NAME'=>$event[1],
	// 			'ET_RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
	// 			'ET_RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
	// 			'EOD_CONFIRMED_BY_ID'=>0,
	// 			'DATE_TIME' => date('d-m-Y H:i:s A'),
	// 			'ET_RECEIPT_ACTIVE'=>1,
	// 			'ET_RECEIPT_CATEGORY_ID'=>4,
	// 			'PAYMENT_STATUS'=>'Received',
	// 			'AUTHORISED_STATUS'=>'No',
	// 			'POSTAGE_CHECK' => $postage,
	// 			'POSTAGE_PRICE' => $postageAmt,
	// 			'POSTAGE_GROUP_ID' => $postageGroup,
	// 			'ADDRESS_LINE1' => $addressLine1,
	// 			'ADDRESS_LINE2' => $addressLine2,
	// 			'CITY' => $city,
	// 			'COUNTRY' => $country,
	// 			'PINCODE' => $pincode
	// 		); 
			
	// 		$receiptId = $this->obj_receipt->add_receipt_inkind_event_modal($data);
	// 		$_SESSION['selOpt'] = 2;
	// 		$_SESSION['receiptId'] = $receiptId;
			
	// 		if($postage == 1) {
	// 			$dataPostage = array(
	// 				'RECEIPT_ID' => $receiptId,
	// 				'POSTAGE_CATEGORY' => 2,
	// 				'POSTAGE_STATUS' => 0,
	// 				'DATE_TIME' => date('d-m-Y H:i:s A'),
	// 				'DATE' => date('d-m-Y'));
	// 			$this->db->insert('POSTAGE', $dataPostage);
	// 		}

	// 		//Getting Latest Inserted Receipt Id
	// 		$insertReceipt = $this->obj_receipt->get_all_field_events_receipt("","ET_RECEIPT_ID","desc");
			
	// 		$tableItemId = json_decode($_POST['tableItemId']);
	// 		$tableItem = json_decode($_POST['tableItem']);
	// 		$tableQty = json_decode($_POST['tableQty']);
			
	// 		for($i = 0; $i < count($tableItemId); ++$i) {
	// 			$itemArr = explode(' ', $tableQty[$i]); 
	// 			$data_One = array(
	// 				'ET_RECEIPT_ID'=> $insertReceipt->ET_RECEIPT_ID,
	// 				'IK_ITEM_ID'=> $tableItemId[$i],
	// 				'IK_ITEM_NAME'=> $tableItem[$i],
	// 				'IK_ITEM_UNIT'=> $itemArr[1],
	// 				'IK_ITEM_QTY'=> $itemArr[0]
	// 				);
			
	// 			$this->obj_receipt->add_receipt_inkind_offered_event_modal($data_One);
				
	// 		}
	// 	} else if($selOpt == 1) {
	// 		$deity = explode('|', $this->input->post('deity'));
	// 		$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
	// 		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
	// 		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'5'));
			
	// 		$query = $this->db->get();
	// 		$deityCounter = $query->first_row();
	// 		$counter = $deityCounter->RECEIPT_COUNTER;
	// 		$counter += 1;
			
	// 		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
	// 		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
	// 		$dfMonth = $this->obj_admin_settings->get_financial_month();
	// 		$datMonth = $this->get_financial_year($dfMonth);
			
	// 		$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
						
	// 		$data = array(
	// 			'RECEIPT_NO'=> $receiptFormat,
	// 			'RECEIPT_DATE'=> date('d-m-Y'),
	// 			'RECEIPT_NAME' => $this->input->post('name'),
	// 			'RECEIPT_PHONE' => $this->input->post('number'),
	// 			'RECEIPT_EMAIL' => $this->input->post('email'),
	// 			'RECEIPT_ADDRESS' => $this->input->post('address'),
	// 			'RECEIPT_PAYMENT_METHOD_NOTES' => $this->input->post('paymentNotes'),
	// 			'RECEIPT_DEITY_ID'=>$deity[0],
	// 			'RECEIPT_DEITY_NAME'=>$deity[1],
	// 			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
	// 			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
	// 			'DATE_TIME' => date('d-m-Y H:i:s A'),
	// 			'AUTHORISED_STATUS'=> 'Yes',
	// 						'AUTHORISED_BY' => $_SESSION['userId'],
	// 						'AUTHORISED_BY_NAME' => $_SESSION['userFullName'],
	// 						'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'),
	// 						'AUTHORISED_DATE' => date('d-m-Y'),
	// 			'RECEIPT_ACTIVE'=>1,
	// 			'RECEIPT_CATEGORY_ID'=>5,
	// 			'PAYMENT_STATUS'=>'Received',
	// 			'AUTHORISED_STATUS'=>'No',
	// 			'POSTAGE_CHECK' => $postage,
	// 			'POSTAGE_PRICE' => $postageAmt,
	// 			'POSTAGE_GROUP_ID' => $postageGroup,
	// 			'ADDRESS_LINE1' => $addressLine1,
	// 			'ADDRESS_LINE2' => $addressLine2,
	// 			'CITY' => $city,
	// 			'COUNTRY' => $country,
	// 			'PINCODE' => $pincode
	// 		); 
			
	// 		$receiptId = $this->obj_receipt->add_receipt_inkind_deity_modal($data);
	// 		$_SESSION['selOpt'] = 1;
	// 		$_SESSION['receiptId'] = $receiptId;
			
	// 		if($postage == 1) {
	// 			$dataPostage = array(
	// 				'RECEIPT_ID' => $receiptId,
	// 				'POSTAGE_CATEGORY' => 1,
	// 				'POSTAGE_STATUS' => 0,
	// 				'DATE_TIME' => date('d-m-Y H:i:s A'),
	// 				'DATE' => date('d-m-Y'));
	// 			$this->db->insert('POSTAGE', $dataPostage);
	// 		}
	// 		//Getting Latest Inserted Receipt Id
	// 		$insertReceipt = $this->obj_receipt->get_all_field_deity_receipt("","RECEIPT_ID","desc");
			
	// 		$tableItemId = json_decode($_POST['tableItemId']);
	// 		$tableItem = json_decode($_POST['tableItem']);
	// 		$tableQty = json_decode($_POST['tableQty']);
			
	// 		for($i = 0; $i < count($tableItemId); ++$i) {
	// 			$itemArr = explode(' ', $tableQty[$i]); 
	// 			$data_One = array(
	// 				'RECEIPT_ID'=> $insertReceipt->RECEIPT_ID,
	// 				'DY_IK_ITEM_ID'=> $tableItemId[$i],
	// 				'DY_IK_ITEM_NAME'=> $tableItem[$i],
	// 				'DY_IK_ITEM_UNIT'=> $itemArr[1],
	// 				'DY_IK_ITEM_QTY'=> $itemArr[0]);
			
	// 			$this->obj_receipt->add_receipt_inkind_offered_deity_modal($data_One);
	// 		}
	// 	}
	// 	echo "success";
	// }
	
	function receipt_inkind_save() {
		$_SESSION['duplicate'] = "no";
		$selOpt = $this->input->post('selRadio');
		
		$postage = $_POST['postage'] || 0;
		$postageAmt = $_POST['postageAmt'];
		if($_POST['postageAmt'] == 0) {
			$postageGroup = 0;
		} else {
			$postageGroup = 1;
		}
		$addressLine1 = $_POST['addressLine1'];
		$addressLine2 = $_POST['addressLine2'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$pincode = $_POST['pincode'];
		
		if($selOpt == 2) {
			$event = explode('|', $this->input->post('event'));
			$this->db->select()->from('EVENT_RECEIPT_CATEGORY')
			->join('EVENT_RECEIPT_COUNTER', 'EVENT_RECEIPT_CATEGORY.ET_ACTIVE_RECEIPT_COUNTER_ID = EVENT_RECEIPT_COUNTER.ET_RECEIPT_COUNTER_ID')
			->where(array('EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID'=>'4'));
			
			$query = $this->db->get();
			$eventCounter = $query->first_row();
			$counter = $eventCounter->ET_RECEIPT_COUNTER;
			$counter += 1;
			
			$this->db->where('ET_RECEIPT_COUNTER_ID',$eventCounter->ET_ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('EVENT_RECEIPT_COUNTER', array('ET_RECEIPT_COUNTER'=>$counter));
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			
			$receiptFormat = $eventCounter->ET_ABBR1 ."/".$datMonth."/".$eventCounter->ET_ABBR2."/".$counter;
			
			$data = array(
				'ET_RECEIPT_NO'=> $receiptFormat,
				'ET_RECEIPT_DATE'=> date('d-m-Y'),
				'ET_RECEIPT_NAME' => $this->input->post('name'),
				'ET_RECEIPT_PHONE' => $this->input->post('number'),
				'ET_ADHAAR_NO' => $this->input->post('adhaarNo'),
				'ET_PAN_NO' => $this->input->post('panNo'),
				'ET_RECEIPT_EMAIL' => $this->input->post('email'),
				'ET_RECEIPT_ADDRESS' => $this->input->post('address'),
				'ET_RECEIPT_PAYMENT_METHOD_NOTES' => $this->input->post('paymentNotes'),
				'RECEIPT_ET_ID'=>$event[0],
				'RECEIPT_ET_NAME'=>$event[1],
				'ET_RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'ET_RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'EOD_CONFIRMED_BY_ID'=>0,
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'ET_RECEIPT_ACTIVE'=>1,
				'ET_RECEIPT_CATEGORY_ID'=>4,
				'PAYMENT_STATUS'=>'Received',
				'AUTHORISED_STATUS'=>'No',
				'POSTAGE_CHECK' => $postage,
				'POSTAGE_PRICE' => $postageAmt,
				'POSTAGE_GROUP_ID' => $postageGroup,
				'ADDRESS_LINE1' => $addressLine1,
				'ADDRESS_LINE2' => $addressLine2,
				'CITY' => $city,
				'COUNTRY' => $country,
				'PINCODE' => $pincode
			); 
			
			$receiptId = $this->obj_receipt->add_receipt_inkind_event_modal($data);
			$_SESSION['selOpt'] = 2;
			$_SESSION['receiptId'] = $receiptId;
			
			if($postage == 1) {
				$dataPostage = array(
					'RECEIPT_ID' => $receiptId,
					'POSTAGE_CATEGORY' => 2,
					'POSTAGE_STATUS' => 0,
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'));
				$this->db->insert('POSTAGE', $dataPostage);
			}

			//Getting Latest Inserted Receipt Id
			$insertReceipt = $this->obj_receipt->get_all_field_events_receipt("","ET_RECEIPT_ID","desc");
			
			$tableItemId = json_decode($_POST['tableItemId']);
			$tableItem = json_decode($_POST['tableItem']);
			$tableQty = json_decode($_POST['tableQty']);
			$tablePrice = json_decode($_POST['tablePrice']);
			$tableNotes = json_decode($_POST['tableNotes']);
			
			for($i = 0; $i < count($tableItemId); ++$i) {
				$itemArr = explode(' ', $tableQty[$i]); 
				$data_One = array(
					'ET_RECEIPT_ID'=> $insertReceipt->ET_RECEIPT_ID,
					'IK_ITEM_ID'=> $tableItemId[$i],
					'IK_ITEM_NAME'=> $tableItem[$i],
					'IK_ITEM_UNIT'=> $itemArr[1],
					'IK_ITEM_QTY'=> $itemArr[0],
					'IK_APPRX_AMT'=>$tablePrice[$i],
					'IK_ITEM_DESC'=>$tableNotes[$i]);
			
				$this->obj_receipt->add_receipt_inkind_offered_event_modal($data_One);
				
			}
		} else if($selOpt == 1) {
			$deity = explode('|', $this->input->post('deity'));
			$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
			->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
			->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'5'));
			
			$query = $this->db->get();
			$deityCounter = $query->first_row();
			$counter = $deityCounter->RECEIPT_COUNTER;
			$counter += 1;
			
			$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			
			$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
						
			$data = array(
				'RECEIPT_NO'=> $receiptFormat,
				'RECEIPT_DATE'=> date('d-m-Y'),
				'RECEIPT_NAME' => $this->input->post('name'),
				'RECEIPT_PHONE' => $this->input->post('number'),
				'RECEIPT_ADHAAR_NO' => $this->input->post('adhaarNo'),
				'RECEIPT_PAN_NO' => $this->input->post('panNo'),
				'RECEIPT_EMAIL' => $this->input->post('email'),
				'RECEIPT_ADDRESS' => $this->input->post('address'),
				'RECEIPT_PAYMENT_METHOD_NOTES' => $this->input->post('paymentNotes'),
				'RECEIPT_DEITY_ID'=>$deity[0],
				'RECEIPT_DEITY_NAME'=>$deity[1],
				'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'AUTHORISED_STATUS'=> 'Yes',
				'AUTHORISED_BY' => $_SESSION['userId'],
				'AUTHORISED_BY_NAME' => $_SESSION['userFullName'],
				'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'),
				'AUTHORISED_DATE' => date('d-m-Y'),
				'RECEIPT_ACTIVE'=>1,
				'RECEIPT_CATEGORY_ID'=>5,
				'PAYMENT_STATUS'=>'Received',
				'AUTHORISED_STATUS'=>'No',
				'POSTAGE_CHECK' => $postage,
				'POSTAGE_PRICE' => $postageAmt,
				'POSTAGE_GROUP_ID' => $postageGroup,
				'ADDRESS_LINE1' => $addressLine1,
				'ADDRESS_LINE2' => $addressLine2,
				'CITY' => $city,
				'COUNTRY' => $country,
				'PINCODE' => $pincode
			); 
			
			$receiptId = $this->obj_receipt->add_receipt_inkind_deity_modal($data);
			$_SESSION['selOpt'] = 1;
			$_SESSION['receiptId'] = $receiptId;
			
			if($postage == 1) {
				$dataPostage = array(
					'RECEIPT_ID' => $receiptId,
					'POSTAGE_CATEGORY' => 1,
					'POSTAGE_STATUS' => 0,
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'));
				$this->db->insert('POSTAGE', $dataPostage);
			}
			//Getting Latest Inserted Receipt Id
			$insertReceipt = $this->obj_receipt->get_all_field_deity_receipt("","RECEIPT_ID","desc");
			
			$tableItemId = json_decode($_POST['tableItemId']);
			$tableItem = json_decode($_POST['tableItem']);
			$tableQty = json_decode($_POST['tableQty']);
			$tablePrice = json_decode($_POST['tablePrice']);
			$tableNotes = json_decode($_POST['tableNotes']);
			
			for($i = 0; $i < count($tableItemId); ++$i) {
				$itemArr = explode(' ', $tableQty[$i]); 
				$data_One = array(
					'RECEIPT_ID'=> $insertReceipt->RECEIPT_ID,
					'DY_IK_ITEM_ID'=> $tableItemId[$i],
					'DY_IK_ITEM_NAME'=> $tableItem[$i],
					'DY_IK_ITEM_UNIT'=> $itemArr[1],
					'DY_IK_ITEM_QTY'=> $itemArr[0],
					'DY_IK_APPRX_AMT'=>$tablePrice[$i],
					'DY_IK_ITEM_DESC'=>$tableNotes[$i]);
			
				$this->obj_receipt->add_receipt_inkind_offered_deity_modal($data_One);
			}
		}
		echo "success";
	}
	
	
	
	//JEERNODHARA INKIND RECEIPT SAVE
	function receipt_jeernodhara_inkind_save() {
		$_SESSION['duplicate'] = "no";
		$postage = $_POST['postage'] || 0;
		$addressLine1 = $_POST['addressLine1'];
		$addressLine2 = $_POST['addressLine2'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$pincode = $_POST['pincode'];
		 $this->db->select()->from('DEITY_RECEIPT_CATEGORY')
		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'10'));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->RECEIPT_COUNTER;
		$counter += 1;
		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;
		 		
			$data = array(
				'RECEIPT_NO'=> $receiptFormat,
				'RECEIPT_DATE'=> date('d-m-Y'),
				'RECEIPT_NAME' => $this->input->post('name'),
				'RECEIPT_PHONE' => $this->input->post('number'),
				'RECEIPT_ADHAAR_NO' => $this->input->post('adhaarNo'),
				'RECEIPT_PAN_NO' => $this->input->post('panNo'),
				'RECEIPT_EMAIL' => $this->input->post('email'),
				'RECEIPT_ADDRESS' => $this->input->post('address'),
				'RECEIPT_PAYMENT_METHOD_NOTES' => $this->input->post('paymentNotes'),
				'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'RECEIPT_ACTIVE'=>1,
				'PAYMENT_STATUS'=>'Received',
				'AUTHORISED_STATUS'=>'No',
				'POSTAGE_CHECK' => $postage,
				'ADDRESS_LINE1' => $addressLine1,
				'ADDRESS_LINE2' => $addressLine2,
				'CITY' => $city,
				'RECEIPT_CATEGORY_ID'=>10,
				'IS_JEERNODHARA'=> 1,
				'COUNTRY' => $country,
				'PINCODE' => $pincode
			); 
			
			$receiptId = $this->obj_receipt->add_receipt_inkind_deity_modal($data);
			
			$_SESSION['receiptId'] = $receiptId;
			
			if($postage == 1) {
				$dataPostage = array(
					'RECEIPT_ID' => $receiptId,
					'POSTAGE_CATEGORY' => 1,
					'POSTAGE_STATUS' => 0,
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'));
				$this->db->insert('POSTAGE', $dataPostage);
			}
			//Getting Latest Inserted Receipt Id
			$insertReceipt = $this->obj_receipt->get_all_field_deity_receipt("","RECEIPT_ID","desc");
			
			$tableItemId = json_decode($_POST['tableItemId']);
			$tableItem = json_decode($_POST['tableItem']);
			$tableQty = json_decode($_POST['tableQty']);
			$tablePrice = json_decode($_POST['tablePrice']);
			$tableNotes = json_decode($_POST['tableNotes']);
			
			for($i = 0; $i < count($tableItemId); ++$i) {
				$itemArr = explode(' ', $tableQty[$i]); 
				$data_One = array(
					'RECEIPT_ID'=> $insertReceipt->RECEIPT_ID,
					'DY_IK_ITEM_ID'=> $tableItemId[$i],
					'DY_IK_ITEM_NAME'=> $tableItem[$i],
					'DY_IK_ITEM_UNIT'=> $itemArr[1],
					'DY_IK_ITEM_QTY'=> $itemArr[0],
					'DY_IK_APPRX_AMT'=>$tablePrice[$i],
					'DY_IK_ITEM_DESC'=>$tableNotes[$i]);
				$this->obj_receipt->add_receipt_inkind_offered_deity_modal($data_One);
			}
		
		echo "success";
		
	}
	
	function jeernodhara_inkindPrint() {
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		
		/*if($_SESSION['actual_link'] == site_url() . 'Receipt/daily_report/')
			$data['whichTab'] = "Jeernodhara";
		else 
			$data['whichTab'] = "receipt";
		$data['fromAllReceipt'] = "1";*/

		if($_SESSION['back_link'] == 'Jeernodhara/Jeernodhara_Inkind ' || $_SESSION['back_link'] == 'Receipt/daily_report') {
			$data['whichTab'] = "Jeernodhara";
			$_SESSION['back_link'] = site_url().'Receipt/daily_report';
		} else {
			$data['whichTab'] = "receipt";
			$_SESSION['back_link'] = site_url().$_SESSION['back_link'];
		}

		//print_r($_SESSION);
		
		if(isset($_POST['receiptId'])) {
			$_SESSION['receiptId'] = $_POST['receiptId'];
		}
		
		
		$receiptId = $_SESSION['receiptId'];
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();	
		$this->db->select()->from('DEITY_INKIND_OFFERED')
		->join('DEITY_RECEIPT', 'DEITY_INKIND_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
		$query = $this->db->get();
		if($query->result('array')) {
		$data['deityCounter'] = $query->result('array');
		
		$this->load->view('header', $data);
		$this->load->view('jeernodhara/jeernodhara_inkindPrint');
		$this->load->view('footer_home');
		}
	}
	
	function receipt_inkindPrint() {
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		$data['whichTab'] = "receipt";
		if(isset($_POST['receiptFormat'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
				
		} else if(isset($_POST['receiptFormat1'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		}
		
		if(isset($_POST['receiptFormatDeity'])) {
			$_SESSION['receiptFormatDeity'] = $_POST['receiptFormatDeity'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			
		} else if(isset($_POST['receiptFormatDeity1'])) {
			$_SESSION['receiptFormatDeity'] = $_POST['receiptFormatDeity1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		}
		
		$receiptFormat = @$_SESSION['receiptFormat'];
		$receiptFormatDeity = @$_SESSION['receiptFormatDeity'];
		$receiptId = $_SESSION['receiptId'];
		unset($_SESSION['receiptFormat']);
		unset($_SESSION['receiptFormatDeity']);
			
		$this->db->select()->from('DEITY_INKIND_OFFERED')
		->join('DEITY_RECEIPT', 'DEITY_INKIND_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
		$query = $this->db->get();
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if($query->result('array')) {
			$data['deityCounter'] = $query->result('array');
			$this->load->view('header', $data);
			$this->load->view('receipt_inkindDeityPrint');
			$this->load->view('footer_home');
		} else {
			$this->db->select()->from('EVENT_INKIND_OFFERED')
			->join('EVENT_RECEIPT', 'EVENT_INKIND_OFFERED.ET_RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID')
			->where(array('EVENT_RECEIPT.ET_RECEIPT_ID'=>$receiptId));
			
			$query = $this->db->get();
			$data['eventCounter'] = $query->result('array');
			
			$this->load->view('header', $data);
			$this->load->view('receipt_inkindPrint');
			$this->load->view('footer_home');
		}
	}
	
	public function updateReceipt() {
		if(isset($_POST['updateId'])) {
			$id = $_POST['updateId'];
		}
		
		if(isset($_POST['multiDatehidden'])) {
			$multiDate = $_POST['multiDatehidden'];
		}
		
		$this->db->where('SO_ID',$id);
		$this->db->update('DEITY_SEVA_OFFERED', array('UPDATED_SO_DATE'=>$multiDate,'SO_DATE'=>$multiDate,'UPDATED_BY_ID'=>$_SESSION['userId']));
		
		echo "success";
	}
	
	public function updateBookingReceipt() {
		if(isset($_POST['updateId'])) {
			$id = $_POST['updateId'];
		}
		
		if(isset($_POST['multiDatehidden'])) {
			$multiDate = $_POST['multiDatehidden'];
		}
		
		$this->db->where('SO_ID',$id);
		$this->db->update('DEITY_SEVA_OFFERED', array('UPDATED_SO_DATE'=>$multiDate,'SO_DATE'=>$multiDate,'UPDATED_BY_ID'=>$_SESSION['userId']));
		
		echo "success";
	}
	
	public function getRevision() {
		if($_POST) {
			$sevaId = $_POST['sevaId'];
			$this->db->select()->from('DEITY_SEVA_PRICE')
			->where(array('DEITY_SEVA_PRICE.SEVA_ID'=>$sevaId,'SEVA_PRICE_ACTIVE'=>1));
			$query = $this->db->get();
			echo json_encode($query->result("array"));
		}
	}
	
	public function editReceipt($id = "") {
		//pagination ends
		
		if(isset($_SESSION['receiptNo'])){
			$id = $_SESSION['receiptNo'];
			unset($_SESSION['receiptNo']);
		}
		if(isset($_POST['receiptNo'])) {
			$id = $_POST['receiptNo'];
		}
		
		$this->db->select()->from('DEITY_RECEIPT')
		->join('DEITY_SEVA_OFFERED', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID')
		->where(array('DEITY_RECEIPT.RECEIPT_NO'=>$id));
		
		$query = $this->db->get();
		$data['deityCounter'] = $query->result("array");
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		
		$this->load->view('header',$data);
		$this->load->view('editDeityReceipt');
		$this->load->view('footer_home');
	}
	
	public function editBookingReceipt($id = "") {
		//pagination ends
		if(isset($_SESSION['receiptNo'])){
			$id = $_SESSION['receiptNo'];
			unset($_SESSION['receiptNo']);
		}
		
		if(isset($_POST['receiptNo'])) {
			$id = $_POST['receiptNo'];
		}
		
		$this->db->select()->from('SEVA_BOOKING')
		->join('DEITY_SEVA_OFFERED', 'DEITY_SEVA_OFFERED.SO_SB_ID = SEVA_BOOKING.SB_ID')
		->where(array('SEVA_BOOKING.SB_NO'=>$id));
		
		$query = $this->db->get();
		$data['deityCounter'] = $query->result("array");
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		
		$this->load->view('header',$data);
		$this->load->view('editBookingReceipt');
		$this->load->view('footer_home');
	}
	
	//RECEIPT FOR HUNDI
	function receipt_hundi() { 
		//For Menu Selection
		$data['whichTab'] = "receipt";
		//NOTIFICATION
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));

		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks();					    //laz..
		
		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..

		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);

		$condition = array('DEITY_ACTIVE' => 1);
		$data['deity'] = $this->obj_receipt->get_all_field_deity($condition);
		$conditionOne = array('ET_ACTIVE' => 1);
		$data['events'] = $this->obj_receipt->get_all_field_events($conditionOne);
		
		if(isset($_SESSION['Deity/Event_Hundi'])) {
			$this->load->view('header', $data);
			$this->load->view('receipt_hundi');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	
	//SAVE RECEIPT THROUGH TOKEN FOR DEITY
	function save_token_receipt_deity() {
		if(@$_SESSION['actual_link'] != "") {
			unset($_SESSION['actual_link']);
		} else {
			redirect('Sevas/deity_token');
		}
		
		if($_POST['deity'])
		$arr_receiptNo = "";
		$deity = explode('|', $this->input->post('deity'));
		// if($this->input->post('is_seva') == 1) {
		// 	$qty = $this->input->post('sevaQty');
		// 	$price = $this->input->post('sevaPrice');
		// } else {
			$laddu = $this->input->post('sevaQty');
			$price = ($this->input->post('sevaPrice') * $laddu);
			$qty = 1;
		//}
		
		for($i = 0; $i < $qty; $i++) {
			$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
			->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
			->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'1'));
			
			$query = $this->db->get();
			$deityCounter = $query->first_row();
			$counter = $deityCounter->RECEIPT_COUNTER;
			$counter += 1;
			
			$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
				
			$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
			$_SESSION['receiptFormat'] = $receiptFormat;
			
			$data = array(
				'RECEIPT_NAME'=> $this->input->post('uName'),
				'RECEIPT_NO'=> $receiptFormat,
				'RECEIPT_DATE'=> date('d-m-Y'),
				'RECEIPT_PAYMENT_METHOD'=> 'Cash',
				'RECEIPT_DEITY_ID'=>$this->input->post('deityIdVal'),
				'RECEIPT_DEITY_NAME'=>$this->input->post('deityNameVal'),
				'RECEIPT_PRICE'=> $price,
				'RECEIPT_ISSUED_BY_ID'=> $_SESSION['userId'],
				'RECEIPT_ISSUED_BY'=> $_SESSION['userFullName'],
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'RECEIPT_ACTIVE'=> 1,
				'RECEIPT_CATEGORY_ID'=> 1,
				'PAYMENT_STATUS'=> 'Completed',
				'AUTHORISED_STATUS'=>'No',
				'PRINT_STATUS' => 1
			); 
			
			$this->db->insert('DEITY_RECEIPT', $data);
			$receiptId = $this->db->insert_id();
			
			$_SESSION['receiptId'] = $receiptId;
			
			if($i == 0) {
				$arr_receiptNo = $receiptId;
			} else {
				$arr_receiptNo .= ",".$receiptId;
			}
			
			// if($this->input->post('is_seva') == 1) {
			// 	$data = array(
			// 		'SO_SEVA_NAME'=>$this->input->post('sevaName'),
			// 		'SO_SEVA_ID'=>$this->input->post('sevaId'),
			// 		'SO_DEITY_ID'=>$this->input->post('deityId'),
			// 		'SO_DEITY_NAME'=>$this->input->post('deityName'),
			// 		'SO_DATE'=>date('d-m-Y'),
			// 		'SO_PRICE'=>$this->input->post('sevaPrice'),
			// 		'RECEIPT_ID'=>$receiptId,
			// 		'SO_IS_SEVA'=>$this->input->post('is_seva'));
			// 	$this->db->insert('DEITY_SEVA_OFFERED', $data);
			// 	$sevaOfferedID = $this->db->insert_id();
			// } else {
				$data = array(
					'SO_DEITY_ID'=>$this->input->post('deityId'),
					'SO_DEITY_NAME'=>$this->input->post('deityName'),
					'SO_SEVA_NAME'=>$this->input->post('sevaName'),
					'SO_SEVA_ID'=>$this->input->post('sevaId'),
					'SO_QUANTITY'=>$laddu,
					'SO_PRICE'=>$this->input->post('sevaPrice'),
					'RECEIPT_ID'=>$receiptId,
					'SO_IS_SEVA'=>$this->input->post('is_seva'));
				$this->db->insert('DEITY_SEVA_OFFERED', $data);
				$sevaOfferedID = $this->db->insert_id();
			//}
		}
		
		$strRes = explode(',', $arr_receiptNo);
		
		for($i = 0; $i < count($strRes); $i++) {
			$this->db->select()->from('DEITY_RECEIPT')
			->join('DEITY_SEVA_OFFERED', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID')
			->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$strRes[$i]));
			$query = $this->db->get();
			$res[$i] = $query->result("array");
		}
		
		$data['deityCounter'] = $res;
		
		$data['deity'] = $this->obj_sevas->getEvents();
		$condition = array('IS_TOKEN'=>1, 'SEVA_ACTIVE' => 1, 'SEVA_PRICE_ACTIVE' => 1);
		$data['deitySevas'] = $this->obj_sevas->getTokenDeitySeva($condition,'DEITY_SEVA.DEITY_ID','ASC');
		$data['whichTab'] = "deityToken";
		
		$_SESSION['DataAdded'] = 'Done';
		$_SESSION['eventCounterRes'] = $res;
		redirect('Sevas/deity_token');
	}
	
	//SAVE RECEIPT THROUGH TOKEN
	function save_token_receipt() {
		if(@$_SESSION['actual_link'] != "") {
			unset($_SESSION['actual_link']);
		} else {
			redirect('events/event_token');
		}
			
		if($_POST['event'])
		$arr_receiptNo = "";
		$event = explode('|', $this->input->post('event'));
		// if($this->input->post('is_seva') == 1) {
		// 	$qty = $this->input->post('sevaQty');
		// 	$price = $this->input->post('sevaPrice');
		// } else {
			$laddu = $this->input->post('sevaQty');
			$price = ($this->input->post('sevaPrice') * $laddu);
			$qty = 1;
		//}
		for($i = 0; $i < $qty; $i++) {
			$this->db->select()->from('EVENT_RECEIPT_CATEGORY')
			->join('EVENT_RECEIPT_COUNTER', 'EVENT_RECEIPT_CATEGORY.ET_ACTIVE_RECEIPT_COUNTER_ID = EVENT_RECEIPT_COUNTER.ET_RECEIPT_COUNTER_ID')
			->where(array('EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID'=>'1'));
			
			$query = $this->db->get();
			$eventCounter = $query->first_row();
			$counter = $eventCounter->ET_RECEIPT_COUNTER;
			$counter += 1;
			
			$this->db->where('ET_RECEIPT_COUNTER_ID',$eventCounter->ET_ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('EVENT_RECEIPT_COUNTER', array('ET_RECEIPT_COUNTER'=>$counter));
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			$receiptFormat = $eventCounter->ET_ABBR1 ."/".$datMonth."/".$eventCounter->ET_ABBR2."/".$counter;
			
			$_SESSION['receiptFormat'] = $receiptFormat;
			
			$data = array(
				'ET_RECEIPT_NO'=> $receiptFormat,
				'ET_RECEIPT_DATE'=> date('d-m-Y'),
				'ET_RECEIPT_NAME'=> $this->input->post('uName'),
				'ET_RECEIPT_PAYMENT_METHOD'=> 'Cash',
				'ET_RECEIPT_PRICE'=> $price,
				'RECEIPT_ET_ID'=>$event[0],
				'RECEIPT_ET_NAME'=>$event[1],
				'ET_RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'ET_RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'EOD_CONFIRMED_BY_ID'=>0,
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'ET_RECEIPT_ACTIVE'=>1,
				'ET_RECEIPT_CATEGORY_ID'=>1,
				'PAYMENT_STATUS'=> 'Completed', 
				'AUTHORISED_STATUS'=>'No',
				'PRINT_STATUS'=>1
				); 
			$this->db->insert('EVENT_RECEIPT', $data);
			$receiptId = $this->db->insert_id();
			$_SESSION['receiptId'] = $receiptId;
			
			if($i == 0) {
				$arr_receiptNo = $receiptId;
			} else {
				$arr_receiptNo .= ",".$receiptId;
			}
			
			// if($this->input->post('is_seva') == 1) {
			// 	$data = array(
			// 		'ET_SO_SEVA_NAME'=>$this->input->post('sevaName'),
			// 		'ET_SO_SEVA_ID'=>$this->input->post('sevaId'),
			// 		'ET_SO_DATE'=>date('d-m-Y'),
			// 		'ET_SO_PRICE'=>$this->input->post('sevaPrice'),
			// 		'ET_RECEIPT_ID'=>$receiptId,
			// 		'ET_SO_IS_SEVA'=>$this->input->post('is_seva'));
			// 	$this->db->insert('EVENT_SEVA_OFFERED', $data);
			// 	$sevaOfferedID = $this->db->insert_id();
				
			// } else {
				$data = array(
					'ET_SO_SEVA_NAME'=>$this->input->post('sevaName'),
					'ET_SO_SEVA_ID'=>$this->input->post('sevaId'),
					'ET_SO_QUANTITY'=>$laddu,
					'ET_SO_PRICE'=>$this->input->post('sevaPrice'),
					'ET_RECEIPT_ID'=>$receiptId,
					'ET_SO_IS_SEVA'=>$this->input->post('is_seva'));
				$this->db->insert('EVENT_SEVA_OFFERED', $data);
				$sevaOfferedID = $this->db->insert_id();
			//} 
		}
		
		$strRes = explode(',', $arr_receiptNo);
		
		for($i = 0; $i < count($strRes); $i++) {
			$this->db->select()->from('EVENT_RECEIPT')
			->join('EVENT_SEVA_OFFERED', 'EVENT_SEVA_OFFERED.ET_RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID')
			->where(array('EVENT_RECEIPT.ET_RECEIPT_ID'=>$strRes[$i]));
			$query = $this->db->get();
			$res[$i] = $query->result("array");
		}

		$data['eventCounter'] = $res;
		
		$data['event'] = $this->obj_events->getEvents();
		$condition = array('IS_TOKEN'=>1, 'ET_ACTIVE' => 1,'ET_SEVA_PRICE_ACTIVE' => 1);
		$data['eventSevas'] = $this->obj_events->getTokenEventSeva($condition,'EVENT_SEVA.ET_SEVA_ID','DESC');
		$data['whichTab'] = "eventToken";
		
		$_SESSION['DataAdded'] = 'Done';
		$_SESSION['eventCounterRes'] = $res;
		redirect('Events/event_token');
	}
	
	//RECIEPT FOR HUNDI SAVE yyy
	function receipt_hundi_save() {
		$data['whichTab'] = "receipt";
		$_SESSION['duplicate'] = "no";
		$pan="";$adhaar="";$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = "";$fglhBank ="";			//laz new;  //declaring and initializing variables
		$selOpt = $this->input->post('selRadio');
		
		if(isset($_POST["transactionId"])) {
			$transcId = $this->input->post('transactionId');
		}

		if(isset($_POST["pan"])) {
			$pan = $this->input->post('pan');
		}
		if(isset($_POST["adhaar"])) {
			$adhaar = $this->input->post('adhaar');
		}
		
		if(isset($_POST["chequeNo"])) {
			$chequeNo = $this->input->post('chequeNo');
		}
		
		if(isset($_POST["chequeDate"])) {
			$chequeDate = $this->input->post('chequeDate');
		}
		
		if(isset($_POST["bank"])) {
			$bank = $this->input->post('bank');
		}
		
		if($_POST["tobank"] != 0) {									//LAZ new
			$fglhBank = $this->input->post('tobank');
		}															

		if($_POST["DCtobank"] != 0) {								
			$fglhBank = $this->input->post('DCtobank');
		}
																	//LAZ new ..
		if(isset($_POST["branch"])) {
			$branch = $this->input->post('branch');
		}
		
		if($this->input->post('modeOfPayment') == "Cheque") {
			$paymentStatus = "Pending";
		} else {
			$paymentStatus = "Completed";
		}
		
		if($selOpt == 2) {
			$event = explode('|', $this->input->post('event'));
			$this->db->select()->from('EVENT_RECEIPT_CATEGORY')
			->join('EVENT_RECEIPT_COUNTER', 'EVENT_RECEIPT_CATEGORY.ET_ACTIVE_RECEIPT_COUNTER_ID = EVENT_RECEIPT_COUNTER.ET_RECEIPT_COUNTER_ID')
			->where(array('EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID'=>'3'));
			
			$query = $this->db->get();
			$eventCounter = $query->first_row();
			$counter = $eventCounter->ET_RECEIPT_COUNTER;
			$counter += 1;
			
			$this->db->where('ET_RECEIPT_COUNTER_ID',$eventCounter->ET_ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('EVENT_RECEIPT_COUNTER', array('ET_RECEIPT_COUNTER'=>$counter));
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			$receiptFormat = $eventCounter->ET_ABBR1 ."/".$datMonth."/".$eventCounter->ET_ABBR2."/".$counter;
									
			$data = array(
				'ET_RECEIPT_NO'=> $receiptFormat,
				'ET_RECEIPT_DATE'=> date('d-m-Y'),
				'ET_RECEIPT_NAME' => $this->input->post('name1'),
			    'ET_RECEIPT_PHONE' => $this->input->post('number'),
			    'ET_RECEIPT_EMAIL' => $this->input->post('email'),
			    'ET_RECEIPT_ADDRESS' => $this->input->post('address'),
				'ET_RECEIPT_PAYMENT_METHOD'=> $this->input->post('modeOfPayment'),
				'CHEQUE_NO' => $chequeNo,
				'CHEQUE_DATE' => $chequeDate,
				'BANK_NAME' => $bank,
			    'BRANCH_NAME' => $branch,
				'TRANSACTION_ID' => $transcId,	
				'ET_RECEIPT_PRICE'=> $this->input->post('amount'),
				'ET_RECEIPT_PAYMENT_METHOD_NOTES'=>$this->input->post('paymentNotes'),
				'RECEIPT_ET_ID'=>$event[0],
				'RECEIPT_ET_NAME'=>$event[1],
				'ET_RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'ET_RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'EOD_CONFIRMED_BY_ID'=>0,
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'ET_RECEIPT_ACTIVE'=>1,
				'ET_RECEIPT_CATEGORY_ID'=>3,
				'PAYMENT_STATUS'=>$paymentStatus, 
				'AUTHORISED_STATUS'=>'No',
				'FGLH_ID' => $fglhBank,
				'ET_PAN_NO'=>$pan,
			    'ET_ADHAAR_NO'=>$adhaar								//laz new ..
			); 
			$receiptId = $this->obj_receipt->add_receipt_hundi_event_modal($data);
			$_SESSION['selOpt'] = 2;
			$_SESSION['receiptId'] = $receiptId;
			
		} else if($selOpt == 1) {
			$deity = explode('|', $this->input->post('deity'));
			$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
			->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
			->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'4'));
			
			$query = $this->db->get();
			$deityCounter = $query->first_row();
			$counter = $deityCounter->RECEIPT_COUNTER;
			$counter += 1;
			
			$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			
			$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
			
			$data = array(
				'RECEIPT_NO'=> $receiptFormat,
				'RECEIPT_DATE'=> date('d-m-Y'),
				'RECEIPT_NAME' => $this->input->post('name1'),
			    'RECEIPT_PHONE' => $this->input->post('number'),
			    'RECEIPT_EMAIL' => $this->input->post('email'),
			    'RECEIPT_ADDRESS' => $this->input->post('address'),
				'RECEIPT_PRICE'=> $this->input->post('amount'),
				'RECEIPT_PAYMENT_METHOD_NOTES'=>$this->input->post('paymentNotes'),
				'RECEIPT_PAYMENT_METHOD'=> $this->input->post('modeOfPayment'),
				'CHEQUE_NO' => $chequeNo,
				'CHEQUE_DATE' => $chequeDate,
				'BANK_NAME' => $bank,
			    'BRANCH_NAME' => $branch,
				'TRANSACTION_ID' => $transcId,				
				'RECEIPT_DEITY_ID'=>$deity[0],
				'RECEIPT_DEITY_NAME'=>$deity[1],
				'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'RECEIPT_ACTIVE'=>1,
				'RECEIPT_CATEGORY_ID'=>4,
				'PAYMENT_STATUS'=>$paymentStatus,
				'AUTHORISED_STATUS'=>'No',
				'FGLH_ID' => $fglhBank,
				'RECEIPT_PAN_NO'=>$pan,
			    'RECEIPT_ADHAAR_NO'=>$adhaar								//laz new ..
			); 
			
			$receiptId = $this->obj_receipt->add_receipt_deity_modal($data);
			$_SESSION['selOpt'] = 1;
			$_SESSION['receiptId'] = $receiptId;
		}
		redirect('/Receipt/receipt_hundiPrint/');
	}

	
	//receipt_jeernodhara_hundi_save
	
	function receipt_jeernodhara_hundi_save() {
		$data['whichTab'] = "receipt";
		$_SESSION['duplicate'] = "no";
		$addressLine2 ="";
		$city="";
		$country="";
		$pincode ="";
		$addressLine1="";
		$adhaar="";
		$pan="";
		$email="";
		$number="";
		$transcId = "";
		$chequeNo = "";
		$chequeDate = "";
		$bank = "";
		$branch = ""; 
		$fglhBank ="";      //declaring and initializing //laz new variables
		
	if(isset($_POST["number"])){
		$number = $this->input->post('number');
	  }
	  if(isset($_POST["email"])){
		$email = $this->input->post('email');
	  }
	  if(isset($_POST["pan"])){
		$pan = $this->input->post('pan');
	  }
	  if(isset($_POST["adhaar"])){
		$adhaar = $this->input->post('adhaar');
	  }
	  if(isset($_POST["addLine1"])){
       $addressLine1 = $this->input->post('addLine1');
	  }
	  if(isset($_POST["addLine2"])){
		$addressLine2 = $this->input->post('addLine2');
	   }
	   if(isset($_POST["city"])){
		$city = $this->input->post('city');
	   }
	   if(isset($_POST["country"])){
		$country = $this->input->post('country');
	   }
	   if(isset($_POST["pincode"])){
		$pincode = $this->input->post('pincode');
	   }

		if(isset($_POST["transactionId"])) {
			$transcId = $this->input->post('transactionId');
		}
		
		if(isset($_POST["chequeNo"])) {
			$chequeNo = $this->input->post('chequeNo');
		}
		
		if(isset($_POST["chequeDate"])) {
			$chequeDate = $this->input->post('chequeDate');
		}
		
		if(isset($_POST["bank"])) {
			$bank = $this->input->post('bank');
		}
		
		if($_POST["tobank"] != 0) {									//LAZ new
			$fglhBank = $this->input->post('tobank');
		}															

		if($_POST["DCtobank"] != 0) {								
			$fglhBank = $this->input->post('DCtobank');
		}															//LAZ new ..

		if(isset($_POST["branch"])) {
			$branch = $this->input->post('branch');
		}
		
		if($this->input->post('modeOfPayment') == "Cheque") {
			$paymentStatus = "Pending";
		} else {
			$paymentStatus = "Completed";
		}
		
        $this->db->select()->from('DEITY_RECEIPT_CATEGORY')
		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'9'));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->RECEIPT_COUNTER;
		$counter += 1;
		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;		
			
			
			
			/* $this->db->select()->from('jeernodhara_head')
			->join('jeernodhara_head_counter', 'jeernodhara_head.JH_ACTIVE_COUNTER_HEAD_ID = jeernodhara_head_counter.HEAD_COUNTER_ID')
			->where(array('jeernodhara_head.JH_ID'=>'2'));
			
			$query = $this->db->get();
			$JHCounter = $query->first_row();
			$counter = $JHCounter->RECEIPT_COUNTER;
			$JH_ID = $JHCounter->JH_ID;
			$counter += 1;
			
			$this->db->where('HEAD_COUNTER_ID',$JHCounter->ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('jeernodhara_head_counter', array('RECEIPT_COUNTER'=>$counter));
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			
			$receiptFormat = $JHCounter->ABBR1 ."/".$datMonth."/".$JHCounter->ABBR2."/".$counter; */
			
			$data = array(
				'RECEIPT_NO'=> $receiptFormat,
				'RECEIPT_NAME' => $this->input->post('name'),
			    'RECEIPT_PHONE' => $this->input->post('number'),
			    'RECEIPT_EMAIL' => $this->input->post('email'),
			    'RECEIPT_ADDRESS' => $this->input->post('address'),
				'RECEIPT_DATE'=> date('d-m-Y'),
				'RECEIPT_PRICE'=> $this->input->post('amount'),
				'RECEIPT_PAYMENT_METHOD_NOTES'=>$this->input->post('paymentNotes'),
				'RECEIPT_PAYMENT_METHOD'=> $this->input->post('modeOfPayment'),
				'CHEQUE_NO' => $chequeNo,
				'CHEQUE_DATE' => $chequeDate,
				'BANK_NAME' => $bank,
			    'BRANCH_NAME' => $branch,
				'TRANSACTION_ID' => $transcId,				
				'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'RECEIPT_ACTIVE'=>1,
				'RECEIPT_CATEGORY_ID'=>9,
				'IS_JEERNODHARA' =>1,
				'PAYMENT_STATUS'=>$paymentStatus,
				'AUTHORISED_STATUS'=>'No',							//laz new		
				'FGLH_ID' => $fglhBank,
				'ADDRESS_LINE1' => $addressLine1,
			    'ADDRESS_LINE2' => $addressLine2,
			    'CITY' => $city,
			    'COUNTRY' => $country,
			    'PINCODE' => $pincode,							//laz new		
			    'RECEIPT_ADHAAR_NO'=>$adhaar,
			    'RECEIPT_PAN_NO'=>$pan										//laz new ..
			); 
			
			$receiptId = $this->obj_receipt->add_receipt_deity_modal($data);
			$_SESSION['receiptId'] = $receiptId;
		redirect('Receipt/jeernodhara_hundiPrint/');		
	}

	
	function jeernodhara_hundiPrint(){
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		
		/*if($_SESSION['actual_link'] == site_url() . 'Receipt/daily_report/')
			$data['whichTab'] = "Jeernodhara";
		else 
			$data['whichTab'] = "receipt";
		
		$data['fromAllReceipt'] = "1"; //All Deity Receipt Page */

		if($_SESSION['back_link'] == 'Jeernodhara/Jeernodhara_Hundi' || $_SESSION['back_link'] == 'Receipt/daily_report') {
			$data['whichTab'] = "Jeernodhara";
			$_SESSION['back_link'] = site_url().'Receipt/daily_report';
		} else {
			$data['whichTab'] = "receipt";
			$_SESSION['back_link'] = site_url().$_SESSION['back_link'];
		}

		//print_r($_SESSION);

		if(isset($_POST['receiptId'])) {
			$_SESSION['receiptId'] = $_POST['receiptId'];
		}
		
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$receiptId = $_SESSION['receiptId'];
			
		$this->db->select()->from('DEITY_RECEIPT')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
		
		$query = $this->db->get();
		if($query->result('array')) {
			$data['deityCounter'] = $query->result('array');
			$this->load->view('header', $data);
			$this->load->view('jeernodhara/jeernodhara_hundiPrint');
			$this->load->view('footer_home');
		}
	}
	
	function receipt_all_hundiPrint() {
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		$data['whichTab'] = "receipt";
		if(isset($_POST['receiptFormat'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
		} else if(isset($_POST['receiptFormat1'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		}
		
		if(isset($_POST['receiptFormatDeity'])) {
			$_SESSION['receiptFormatDeity'] = $_POST['receiptFormatDeity'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
		} else if(isset($_POST['receiptFormatDeity1'])) {
			$_SESSION['receiptFormatDeity'] = $_POST['receiptFormatDeity1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		}
			
		$receiptFormat = @$_SESSION['receiptFormat'];
		$receiptFormatDeity = @$_SESSION['receiptFormatDeity'];
		$receiptId = @$_SESSION['receiptId'];
		unset($_SESSION['receiptFormat']);
		unset($_SESSION['receiptFormatDeity']);
			
		$this->db->select()->from('DEITY_RECEIPT')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
		
		$query = $this->db->get();
		if($query->result('array')) {
			$data['deityCounter'] = $query->result('array');
			$this->load->view('header', $data);
			$this->load->view('receipt_hundiDeityPrint');
			$this->load->view('footer_home');
		}	else {
				$this->db->select()->from('EVENT_RECEIPT')
				->where(array('EVENT_RECEIPT.ET_RECEIPT_ID'=>$receiptId));
				$query = $this->db->get();
				$data['eventCounter'] = $query->result('array');
				$this->load->view('header', $data);
				$this->load->view('receipt_hundiPrint');
				$this->load->view('footer_home');
		}
	}
	
	function receipt_hundiPrint() {
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		$data['whichTab'] = "receipt";
		if(isset($_POST['receiptFormat'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
		} else if(isset($_POST['receiptFormat1'])) {
			$_SESSION['receiptFormat'] = $_POST['receiptFormat1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		}
		
		if(isset($_POST['receiptFormatDeity'])) {
			$_SESSION['receiptFormatDeity'] = $_POST['receiptFormatDeity'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
		} else if(isset($_POST['receiptFormatDeity1'])) {
			$_SESSION['receiptFormatDeity'] = $_POST['receiptFormatDeity1'];
			$_SESSION['receiptId'] = $_POST['receiptId'];
			$data['fromAllReceipt'] = "1";
		}
			
		$receiptFormat = @$_SESSION['receiptFormat'];
		$receiptFormatDeity = @$_SESSION['receiptFormatDeity'];
		$receiptId = @$_SESSION['receiptId'];
		unset($_SESSION['receiptFormat']);
		unset($_SESSION['receiptFormatDeity']);
			
		$this->db->select()->from('DEITY_RECEIPT')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		// print_r($receiptId);
		$query = $this->db->get();
		if($_SESSION['selOpt'] == 1) {
			$data['deityCounter'] = $query->result('array');
			$this->load->view('header', $data);
			$this->load->view('receipt_hundiDeityPrint');
			$this->load->view('footer_home');
		}	else {
				$this->db->select()->from('EVENT_RECEIPT')
				->where(array('EVENT_RECEIPT.ET_RECEIPT_ID'=>$receiptId));
				$query = $this->db->get();
				$data['eventCounter'] = $query->result('array');
				$this->load->view('header', $data);
				$this->load->view('receipt_hundiPrint');
				$this->load->view('footer_home');
		}
	}

	function deitySevaReceipt() {
		//SLAP
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..

		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);

		//For Menu Selection
		$data['whichTab'] = "receipt";
		$data['deity'] = $this->obj_receipt->getDeties();
		$data['sevas'] = json_encode($this->obj_receipt->getDetiesSevas());
		if(isset($_SESSION['Deity_Seva'])) {
			$this->load->view('header', $data);
			$this->load->view('deitySevaReceipt');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	
	function getRashi() {
		$keyword = $_POST['keyword'];
		$this->db->select()->from('RASHI')->like('RASHI_NAME', $keyword, 'after');
		$query = $this->db->get();
		echo json_encode($query->result('array'));
	}
	
	function getNakshatra() {
		$keyword = $_POST['keyword'];
		$id = $_POST['id'];
		$this->db->select()->from('RASHI_NAKSHATRA_GROUP')
		->join('NAKSHATRA', 'RASHI_NAKSHATRA_GROUP.NAKSHATRA_ID = NAKSHATRA.NAKSHATRA_ID')
		->where('RASHI_NAKSHATRA_GROUP.RASHI_ID',$id)->like('NAKSHATRA.NAKSHATRA_NAME', $keyword, 'after');
		$query = $this->db->get();
		echo json_encode($query->result('array'));
	}

	function getLedgers() {
		$keyword = $_POST['keyword'];
		$this->db->select('FGLH_NAME')->from('finacial_group_ledger_heads')->like('finacial_group_ledger_heads.FGLH_NAME', $keyword, 'after');
		$query = $this->db->get();
		echo json_encode($query->result('array'));
	}
	
	function generateDeityReceipt() {
		$_SESSION['duplicate'] = "no";
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		
		$name = @$_POST['name'];
		$number = @$_POST['number'];
		$rashi = @$_POST['rashi'];
		$nakshatra = @$_POST['nakshatra'];
		
		$date_type = @$_POST['date_type'];
		
		$sevaName = json_decode(@$_POST['sevaName']);
		$qty = json_decode(@$_POST['qty']);
		$date = json_decode(@$_POST['date']);
		$price = json_decode(@$_POST['price']);
		$amt = json_decode(@$_POST['amt']);
		$sevaId = json_decode(@$_POST['sevaId']);
		$userId = json_decode(@$_POST['userId']);
		$quantityChecker = json_decode(@$_POST['quantityChecker']);
		$deityId = json_decode(@$_POST['deityId']);
		$deityName = json_decode(@$_POST['deityName']);
		$isSeva = json_decode(@$_POST['isSeva']);
		$revFlag = json_decode(@$_POST['revFlag']);
		$total = @$_POST['total'];
		
		$modeOfPayment = @$_POST['modeOfPayment'];
		$branch = @$_POST['branch'];
		$chequeNo = @$_POST['chequeNo'];
		$bank = @$_POST['bank'];
		$chequeDate = @$_POST['chequeDate'];
		$transactionId = @$_POST['transactionId'];

		$fglhBank = @$_POST['fglhBank'];							//slap //laz new
		$paymentNotes = @$_POST['paymentNotes'];
		
		$postage = @$_POST['postage'] || 0;
		$postageAmt = @$_POST['postageAmt'];
		if($postageAmt == 0) {
			$postageGroup = 0;
		} else {
			$postageGroup = 1;
		}
		$addressLine1 = @$_POST['addressLine1'];
		$addressLine2 = @$_POST['addressLine2'];
		$city = @$_POST['city'];
		$country = @$_POST['country'];
		$pincode = @$_POST['pincode'];
		$address = @$_POST['address'];
				
		$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'1'));
		
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		
		if($modeOfPayment == "Cheque") {
			$paymentStatus = "Pending";
		} else {
			$paymentStatus = "Completed";
		}
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
			
		$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
		
		$data = array(
			'RECEIPT_NAME'=>$name,
			'RECEIPT_NO'=>$receiptFormat,
			'RECEIPT_DATE'=>$todayDate,
			'RECEIPT_PHONE'=>$number,
			'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,
			'BRANCH_NAME'=>$branch,
			'CHEQUE_NO'=>$chequeNo,
			'BANK_NAME'=>$bank,
			'CHEQUE_DATE'=>$chequeDate,
			'RECEIPT_PRICE'=>$total,
			'TRANSACTION_ID'=>$transactionId,
			'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,
			'RECEIPT_RASHI'=>$rashi,
			'RECEIPT_NAKSHATRA'=>$nakshatra,
			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'DATE_TIME' => $dateTime,
			'RECEIPT_ACTIVE'=>1,
			'RECEIPT_CATEGORY_ID'=>1,
			'PAYMENT_STATUS'=>$paymentStatus,
			'AUTHORISED_STATUS'=>'No',
			'DATE_TYPE'=>$date_type,
			'RECEIPT_ADDRESS' => $address,
			'POSTAGE_CHECK' => $postage,
			'POSTAGE_PRICE' => $postageAmt,
			'POSTAGE_GROUP_ID' => $postageGroup,
			'ADDRESS_LINE1' => $addressLine1,
			'ADDRESS_LINE2' => $addressLine2,
			'CITY' => $city,
			'COUNTRY' => $country,
			'PINCODE' => $pincode ,							//laz new		
			'FGLH_ID' => $fglhBank							//laz new ..
		); 
		
		$this->db->insert('DEITY_RECEIPT', $data);
		$DEITY_RECEIPT = $this->db->insert_id();
		
		if($postage == 1) {
			$dataPostage = array(
							'RECEIPT_ID' => $DEITY_RECEIPT,
							'POSTAGE_CATEGORY' => 1,
							'POSTAGE_STATUS' => 0,
							'DATE_TIME' => date('d-m-Y H:i:s A'),
							'DATE' => date('d-m-Y'));
			$this->db->insert('POSTAGE', $dataPostage);
		}
		for($i = 0; $i < count($sevaName); ++$i) { 
			if($isSeva[$i] == 1) {
				$data = array(
					'SO_SEVA_NAME'=>$sevaName[$i],
					'SO_SEVA_ID'=>$sevaId[$i],
					'SO_DEITY_ID'=>$deityId[$i],
					'SO_DEITY_NAME'=>$deityName[$i],
					//'SO_QUANTITY'=>$qty[$i],
					'SO_DATE'=>$date[$i],
					'SO_PRICE'=>$price[$i],
					'RECEIPT_ID'=>$DEITY_RECEIPT,
					'SO_IS_SEVA'=>1,
					'REVISION_PRICE_CHECKER'=>$revFlag[$i]
				);
				
				for($j = 0; $j < intval(trim($qty[$i])); ++$j) {
					$this->db->insert('DEITY_SEVA_OFFERED', $data);
					$deityOfferedID = $this->db->insert_id();
				}
			} else {
				$data = array(
					'SO_SEVA_NAME'=>$sevaName[$i],
					'SO_SEVA_ID'=>$sevaId[$i],
					'SO_DEITY_ID'=>$deityId[$i],
					'SO_DEITY_NAME'=>$deityName[$i],
					'SO_QUANTITY'=>$qty[$i],
					'SO_PRICE'=>$price[$i],
					'RECEIPT_ID'=>$DEITY_RECEIPT,
					'SO_IS_SEVA'=>0,
					'REVISION_PRICE_CHECKER'=>$revFlag[$i]

				);
				$this->db->insert('DEITY_SEVA_OFFERED', $data);
				$deityOfferedID = $this->db->insert_id();
				// for($j = 0; $j < intval(trim($qty[$i])); ++$j) {
					// $this->db->insert('DEITY_SEVA_OFFERED', $data);
					// $deityOfferedID = $this->db->insert_id();
				// }
			}
		}
		$_SESSION['deityCount'] = $this->obj_sevas->get_seva_count(date("d-m-Y"));
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		
		echo "success";
		$_SESSION['receiptFormat'] = $receiptFormat;
		$_SESSION['deityReceiptId'] = $DEITY_RECEIPT;
	}

	//Lathesh code
	//Add Shashwath Existing Receipt
	// function generateShashwathReceipt() {
	// 	$_SESSION['duplicate'] = "no";
		
	// 	$dateTime = date('d-m-Y H:i:s A');
		
	// 	$name = strtoupper(@$_POST['name']);
	// 	$number = @$_POST['number'];
	// 	$number2 = @$_POST['number2'];
	// 	$rashi = @$_POST['rashi'];
	// 	$gotra = @$_POST['gotra'];
	// 	$nakshatra = @$_POST['nakshatra'];
	// 	$temp_sm_id = @$_POST['temp_sm_id'];
		
	// 	$date_type = @$_POST['date_type'];
	// 	$sevaType = @$_POST['sevaType'];
	//     $sevaName = json_decode(@$_POST['sevaName']);
	// 	$qty = json_decode(@$_POST['qty']);
	// 	$date = json_decode(@$_POST['date']);
	// 	$price = json_decode(@$_POST['price']);
	// 	$amt = json_decode(@$_POST['amt']);

	// 	$sevaId = json_decode(@$_POST['sevaId']);
	// 	$sevaQty = json_decode(@$_POST['sevaQty']);
	// 	$thithi = json_decode(@$_POST['thithi']);
	// 	$corpus = json_decode(@$_POST['corpus']);
	// 	$purpose = json_decode(@$_POST['purpose']);
	// 	$userId = json_decode(@$_POST['userId']);
	// 	$quantityChecker = json_decode(@$_POST['quantityChecker']);
	// 	$deityId = json_decode(@$_POST['deityId']);
	// 	$deityName = json_decode(@$_POST['deityName']);
	// 	$isSeva = json_decode(@$_POST['isSeva']);
	// 	$revFlag = json_decode(@$_POST['revFlag']);
	// 	$masa = json_decode(@$_POST['masa1']);
	// 	$bomcode = json_decode(@$_POST['bomcode1']);
	// 	$thithiName = json_decode(@$_POST['thithiName1']);
	// 	$weekcode = json_decode(@$_POST['everyweekMonth']);

	// 	//manual entry for receipt number and date
	// 	$ss_receipt_no =  @$_POST['ss_receipt_no'];
	// 	$ss_receipt_date =  @$_POST['ss_receipt_date'];
		
	// 	$total = @$_POST['total'];
		
	// 	$modeOfPayment = @$_POST['modeOfPayment'];
	// 	$branch = @$_POST['branch'];
	// 	$chequeNo = @$_POST['chequeNo'];
	// 	$bank = @$_POST['bank'];
	// 	$chequeDate = @$_POST['chequeDate'];
	// 	$transactionId = @$_POST['transactionId'];
	// 	$fglhBank = @$_POST['fglhBank'];							 //laz new
	// 	$paymentNotes = @$_POST['paymentNotes'];
		
	// 	$postage = json_decode(@$_POST['postage']);
		
	// 	$addressLine1 = json_decode(@$_POST['addressLine1']);
	// 	$addressLine2 = json_decode(@$_POST['addressLine2']);
	// 	$city = json_decode(@$_POST['city']);
	// 	$state = json_decode(@$_POST['state']);
	// 	$country = json_decode(@$_POST['country']);
	// 	$pincode = json_decode(@$_POST['pincode']);
	// 	$address = json_decode(@$_POST['address']);
		
	// 	$addrline1 = strtoupper(@$_POST['addrline1']);
	// 	$addrline2 = strtoupper(@$_POST['addrline2']);
	// 	$smcity = strtoupper(@$_POST['smcity']);
	// 	$smstate = strtoupper(@$_POST['smstate']);
	// 	$smcountry = strtoupper(@$_POST['smcountry']);
	// 	$smpin = @$_POST['smpin'];
	// 	$smremarks = @$_POST['smremarks'];
				
	// 	$calType = json_decode(@$_POST['calType1']);
	// 	$periodId = json_decode(@$_POST['periodId']);
	// 	//member reference number
		
	// 	$sm_address = (($addrline1 != "")?$addrline1.", ":"").(($addrline2 != "")?$addrline2.", ":"").(($smcity != "")?$smcity." ":"").(($smstate != "")?$smstate." ":"").(($smcountry != "")?$smcountry." - ":"").(($smpin != "")?$smpin:"");
		
	// 	$this->db->select()->from('SHASHWATH_MEMBER_SEVA_REFERENCE');	
	// 	$query = $this->db->get();
	// 	$rowResult = $query->first_row();
	// 	$counter = $rowResult->SM_REF;
	// 	$counter += 1;
		
	// 	$this->db->update('SHASHWATH_MEMBER_SEVA_REFERENCE', array('SM_REF'=>$counter));
		
	// 	$dfMonth = $this->obj_admin_settings->get_financial_month();
	// 	if ($ss_receipt_no == "") {
	// 		$todayDate = date('d-m-Y'); // $todayDate takes todays date when manual receipt checker is OFF
	// 		$datMonth = $this->get_financial_year($dfMonth);
	// 	}
	// 	else {
	// 		$todayDate = $ss_receipt_date;  // $todayDate takes Receipt Date when manual receipt checker is ON
	// 		$datMonth = $this->get_shashwath_financial_year($dfMonth,$ss_receipt_date);
	// 	}

	// 	$shashwathData = array(
	// 		'SM_REF'   =>$counter,
	// 		'SM_NAME'  =>$name,
	// 		'SM_PHONE' =>$number,
	// 		'SM_PHONE2' =>$number2,
	// 		'SM_RASHI' =>$rashi,
	// 		'SM_NAKSHATRA'=>$nakshatra,
	// 		'SM_GOTRA' =>$gotra,
	// 		'SM_ADDR1' =>$addrline1,
	// 		'SM_ADDR2' =>$addrline2,
	// 		'SM_CITY'  =>$smcity,
	// 		'SM_STATE' =>$smstate,
	// 		'SM_COUNTRY'=>$smcountry,
	// 		'SM_PIN'    =>$smpin,
	// 		'REMARKS'  =>$smremarks
	//     );  
		
	// 	$this->db->insert('shashwath_members', $shashwathData); 
	// 	$SM_ID = $this->db->insert_id();
	// 	$_SESSION['sm_id'] = $SM_ID;
		
	// 	for($i = 0; $i < count($sevaName); ++$i) { 

	// 		//Every -> Number of Sevas Count Calculation
	// 		if($calType[$i]=="Every"){
	// 			$maxYear = $this->obj_shashwath->getfinyear();
	// 			$startDate = new DateTime();
	// 			$endDate = new DateTime($maxYear.'-03-31');
	// 			$countNOS = 0;
	// 			if (count(explode("_",$weekcode[$i]))==1){
	// 				while ($startDate <= $endDate) {
	// 				    if ($startDate->format('l') == $weekcode[$i]) {
	// 				        $countNOS++;
	// 				    }
	// 				    $startDate->modify('+1 day');
	// 				}
	// 			}else {
	// 				while ($startDate <= $endDate) {
	// 				    $stringDate = $startDate->format('Y-m-d H:i:s');
	// 				    $Timestamp = strtotime($stringDate);
	// 					$weekFirst = date("d-m-Y", strtotime("first ".explode("_",$weekcode[$i])[1]." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 					if(date("d-m-Y",$Timestamp)==$weekFirst){
	// 						$countNOS++;
	// 					}
	// 				    $startDate->modify('+1 day');
	// 				}
	// 			}
	// 		} else {
	// 			$countNOS = 1;
	// 		}
	// 		//Calculation End

	// 		//Receipt Number
	// 		$this->db->select()->from('SHASHWATH_MEMBER_SEVA_REFERENCE');	
	// 		$query = $this->db->get();
	// 		$rowResult = $query->first_row();
	// 		$counter1 = $rowResult->SM_REF;
	// 		$counter2 = $rowResult->SS_REF;
	// 		$counter2 += 1;
	// 		$this->db->update('SHASHWATH_MEMBER_SEVA_REFERENCE', array('SS_REF'=>$counter2));

	// 		$memberReceiptFormat1 = $rowResult->SMR_ABBR1 ."/".$datMonth."/".$rowResult->SM_ABBR1.$counter1."/".$rowResult->SS_ABBR1.$counter2;

	// 		$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
	// 		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
	// 		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=> 7 ));
			
	// 		$query = $this->db->get();
	// 		$deityCounter = $query->first_row();
	// 		$counter = $deityCounter->RECEIPT_COUNTER;
	// 		$counter += 1;
			
	// 		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
	// 		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
			
	// 		$Ref = $counter;

	// 		$shashwathReceipt = $memberReceiptFormat1."/".$Ref;
			
	// 		$this->db->select()->from('DEITY_SEVA')->where(array('SEVA_ID'=>$sevaId[$i]));
	// 		$query = $this->db->get();
	// 		$deitySeva = $query->first_row();
	// 		$sevaType = $deitySeva->SEVA_TYPE;
			 
	// 		$sevaData = array(
	// 			'SM_ID'  =>$SM_ID,
	// 			'SS_REF' =>$counter2,
	// 			'SS_RECEIPT_NO' =>$ss_receipt_no,
	// 			'SS_RECEIPT_DATE' =>$todayDate,
	// 			'DEITY_ID' =>$deityId[$i],
	// 			'SEVA_ID' =>$sevaId[$i],
	// 			'SEVA_QTY' =>$sevaQty[$i],
	// 			'THITHI_CODE'=>$thithi[$i],
	// 			'ENG_DATE' =>$date[$i],
	// 			'SEVA_TYPE' => $sevaType,
	// 			'CAL_TYPE' => $calType[$i],
	// 			 'MASA'	   => $masa[$i],
	// 			'BASED_ON_MOON'=>$bomcode[$i],
	// 			'THITHI_NAME' =>$thithiName[$i], 
	// 			'SP_ID'   => $periodId[$i],
	// 			'SEVA_NOTES' => $purpose[$i],
	// 			'SP_COUNTER' => 0,
	// 			'SS_STATUS'  => 1,
	// 			'SS_VERIFICATION' => 0,
	// 			'SS_ENTERED_BY_ID' => $_SESSION['userId'],
	// 			'SS_ENTERED_DATE_TIME'=>date('d-m-Y H:i:s A'),
	// 			'SS_ENTERED_DATE' =>date('d-m-Y'),
	// 			'EVERY_WEEK_MONTH' => $weekcode[$i],
	// 			'NO_OF_SEVAS' => $countNOS
	// 		);
					
	// 		$this->db->insert('shashwath_seva', $sevaData); 
	// 		$SS_ID = $this->db->insert_id();

	// 		if($modeOfPayment == "Cheque") {
	// 			$paymentStatus = "Pending";
	// 		} else {
	// 			$paymentStatus = "Completed";
	// 		}
			
	// 		if($ss_receipt_no == "") {	
	// 		 $receiptData = array(
	// 			'SS_ID'   =>$SS_ID,											
	// 			'RECEIPT_NAME'=>$name,											
	// 			'RECEIPT_NO'=>$shashwathReceipt,											
	// 			'RECEIPT_DATE'=>$todayDate,											
	// 			'RECEIPT_PHONE'=>$number,											
	// 			'RECEIPT_PRICE'    => $corpus[$i],											
	// 			'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,											
	// 			'BRANCH_NAME'=>$branch,											
	// 			'CHEQUE_NO'=>$chequeNo,											
	// 			'BANK_NAME'=>$bank,											
	// 			'CHEQUE_DATE'=>$chequeDate,											
	// 			'TRANSACTION_ID'=>$transactionId,											
	// 			'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,											
	// 			'RECEIPT_RASHI'=>$rashi,											
	// 			'RECEIPT_NAKSHATRA'=>$nakshatra,


	// 			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],											
	// 			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],											
	// 			'DATE_TIME' => $dateTime,											
	// 			'RECEIPT_ACTIVE'=>1,											
	// 			'RECEIPT_CATEGORY_ID'=>7,											
	// 			'PAYMENT_STATUS'=>$paymentStatus,											
	// 			'AUTHORISED_STATUS'=> 'No',											
	// 	/*				'EOD_CONFIRMED_BY_ID' => 33,											
	// 			'EOD_CONFIRMED_BY_NAME' => 'C. Suresh Bhat',											
	// 			'EOD_CONFIRMED_DATE_TIME' => date('d-m-Y H:i:s A'),											
	// 			'EOD_CONFIRMED_DATE' => date('d-m-Y'),*/											
	// 			'DATE_TYPE'=>$date_type,											
	// 			'RECEIPT_ADDRESS' => $sm_address,											
	// 			'POSTAGE_CHECK' => (($postage[$i] == "YES")?1:0),											
	// 			'POSTAGE_GROUP_ID' => 1,											
	// 			'ADDRESS_LINE1' => strtoupper($addressLine1[$i]),											
	// 			'ADDRESS_LINE2' => strtoupper($addressLine2[$i]),											
	// 			'CITY' => strtoupper($city[$i]),											
	// 			'STATE' => strtoupper($state[$i]),											
	// 			'COUNTRY' => strtoupper($country[$i]),											
	// 			'PINCODE' => $pincode[$i],
	// 			'FGLH_ID' => $fglhBank,							//laz new ..
	// 			'SS_RECEIPT_NO_REF' => $ss_receipt_no
	// 		); 
	// 		}
	// 		else
	// 		{
	// 			$receiptData = array(
	// 			'SS_ID'   =>$SS_ID,
	// 			'RECEIPT_NAME'=>$name,
	// 			'RECEIPT_NO'=>$shashwathReceipt,
	// 			'RECEIPT_DATE'=>$todayDate,
	// 			'RECEIPT_PHONE'=>$number,
	// 			'RECEIPT_PRICE'    => $corpus[$i],
	// 			'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,
	// 			'BRANCH_NAME'=>$branch,
	// 			'CHEQUE_NO'=>$chequeNo,
	// 			'BANK_NAME'=>$bank,
	// 			'CHEQUE_DATE'=>$chequeDate,
	// 			'TRANSACTION_ID'=>$transactionId,
	// 			'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,
	// 			'RECEIPT_RASHI'=>$rashi,
	// 			'RECEIPT_NAKSHATRA'=>$nakshatra,
	// 			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
	// 			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
	// 			'DATE_TIME' => $dateTime,
	// 			'RECEIPT_ACTIVE'=>1,
	// 			'RECEIPT_CATEGORY_ID'=>7,
	// 			'PAYMENT_STATUS'=>$paymentStatus,
	// 			'AUTHORISED_STATUS'=> 'Yes',
	// 			'AUTHORISED_BY' => 33,
	// 			'AUTHORISED_BY_NAME' => 'C. Suresh Bhat',
	// 			'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'),
	// 			'AUTHORISED_DATE' => date('d-m-Y'),
	// 			'EOD_CONFIRMED_BY_ID' => 33,
	// 			'EOD_CONFIRMED_BY_NAME' => 'C. Suresh Bhat',
	// 			'EOD_CONFIRMED_DATE_TIME' => date('d-m-Y H:i:s A'),
	// 			'EOD_CONFIRMED_DATE' => date('d-m-Y'),
	// 			'DATE_TYPE'=>$date_type,
	// 			'RECEIPT_ADDRESS' => $sm_address,
	// 			'POSTAGE_CHECK' => (($postage[$i] == "YES")?1:0),
	// 			'POSTAGE_GROUP_ID' => 1,
	// 			'ADDRESS_LINE1' => strtoupper($addressLine1[$i]),
	// 			'ADDRESS_LINE2' => strtoupper($addressLine2[$i]),
	// 			'CITY' => strtoupper($city[$i]),
	// 			'STATE' => strtoupper($state[$i]),
	// 			'COUNTRY' => strtoupper($country[$i]),
	// 			'PINCODE' => $pincode[$i],
	// 			'FGLH_ID' => $fglhBank,						//laz new ..
	// 			'SS_RECEIPT_NO_REF' => $ss_receipt_no 
	// 		); 
	// 		}
			
	// 		$this->db->insert('DEITY_RECEIPT', $receiptData);
	// 		$SHASHWATH_RECEIPT = $this->db->insert_id();

	// 		$this->db->where('sm_id', $temp_sm_id);
	// 		$this->db->update('shashwath_member_import', array('sm_status'=>1));
			
	// 		if($postage == 1) {
	// 			$dataPostage = array(
	// 							'RECEIPT_ID' => $SHASHWATH_RECEIPT,
	// 							'POSTAGE_CATEGORY' => 1, //1 = Deity, 2 = Event, 3 = Trust Event
	// 							'POSTAGE_STATUS' => 0,
	// 							'DATE_TIME' => date('d-m-Y H:i:s A'),
	// 							'DATE' => date('d-m-Y'));
	// 			$this->db->insert('POSTAGE', $dataPostage);
	// 		}    
	// 	} 

	// 	echo "success";
	// 	$_SESSION['shashwathReceipt'] = $shashwathReceipt; 
	// }
	
	function generateShashwathReceipt() {
		$financeBookBeginDate = date('31-03-2021'); 
		$_SESSION['duplicate'] = "no";
		
		$dateTime = date('d-m-Y H:i:s A');

		$name = strtoupper(@$_POST['memmanname']);
		$number = @$_POST['memmannumber'];
		$number2 = @$_POST['memmannumber2'];
		$rashi = @$_POST['rashi'];
		$gotra = @$_POST['gotra'];
		$nakshatra = @$_POST['nakshatra'];
		$temp_sm_id = @$_POST['temp_sm_id'];
		
		$date_type = @$_POST['date_type'];
		$sevaType = @$_POST['sevaType'];
	    $sevaName = json_decode(@$_POST['sevaName']);
		$qty = json_decode(@$_POST['qty']);
		$date = json_decode(@$_POST['date']);
		$price = json_decode(@$_POST['price']);
		$amt = json_decode(@$_POST['amt']);

		$sevaId = json_decode(@$_POST['sevaId']);
		$sevaQty = json_decode(@$_POST['sevaQty']);
		$thithi = json_decode(@$_POST['thithi']);
		$corpus = json_decode(@$_POST['corpus']);
		$purpose = json_decode(@$_POST['purpose']);
		$userId = json_decode(@$_POST['userId']);
		$quantityChecker = json_decode(@$_POST['quantityChecker']);
		$deityId = json_decode(@$_POST['deityId']);
		$deityName = json_decode(@$_POST['deityName']);
		$isSeva = json_decode(@$_POST['isSeva']);
		$revFlag = json_decode(@$_POST['revFlag']);
		$masa = json_decode(@$_POST['masa1']);
		$bomcode = json_decode(@$_POST['bomcode1']);
		$thithiName = json_decode(@$_POST['thithiName1']);
		$weekcode = json_decode(@$_POST['everyweekMonth']);

		//manual entry for receipt number and date
		$ss_receipt_no =  @$_POST['ss_receipt_no'];
		$ss_receipt_date =  @$_POST['ss_receipt_date'];
		
		$total = @$_POST['total'];
		
		$modeOfPayment = @$_POST['modeOfPayment'];
		$branch = @$_POST['branch'];
		$chequeNo = @$_POST['chequeNo'];
		$bank = @$_POST['bank'];
		$chequeDate = @$_POST['chequeDate'];
		$transactionId = @$_POST['transactionId'];
		$fglhBank = @$_POST['fglhBank'];							 //laz new
		$paymentNotes = @$_POST['paymentNotes'];
		
		$postage = json_decode(@$_POST['postage']);
		
		$addressLine1 = json_decode(@$_POST['addressLine1']);
		$addressLine2 = json_decode(@$_POST['addressLine2']);
		$city = json_decode(@$_POST['city']);
		$state = json_decode(@$_POST['state']);
		$country = json_decode(@$_POST['country']);
		$pincode = json_decode(@$_POST['pincode']);
		$address = json_decode(@$_POST['address']);
		$pan = json_decode(@$_POST['pan']);
		$adhaar = json_decode(@$_POST['adhaar']);
		
		$addrline1 = strtoupper(@$_POST['memmanaddr1']);
		$addrline2 = strtoupper(@$_POST['memmanaddr2']);
		$smcity = strtoupper(@$_POST['memmancity']);
		$smstate = strtoupper(@$_POST['memmanstate']);
		$smcountry = strtoupper(@$_POST['memmancountry']);
		$smpin = @$_POST['memmanpin'];
		$smremarks = @$_POST['memmanremarks'];
		$memmanismandli = @$_POST['memmanismandli'];		
		$calType = json_decode(@$_POST['calType1']);
		$periodId = json_decode(@$_POST['periodId']);
		//member reference number
		
		$sm_address = (($addrline1 != "")?$addrline1.", ":"").(($addrline2 != "")?$addrline2.", ":"").(($smcity != "")?$smcity." ":"").(($smstate != "")?$smstate." ":"").(($smcountry != "")?$smcountry." - ":"").(($smpin != "")?$smpin:"");
		
		$this->db->select()->from('SHASHWATH_MEMBER_SEVA_REFERENCE');	
		$query = $this->db->get();
		$rowResult = $query->first_row();
		$counter = $rowResult->SM_REF;
		$counter += 1;
		
		$this->db->update('SHASHWATH_MEMBER_SEVA_REFERENCE', array('SM_REF'=>$counter));
		
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		if ($ss_receipt_no == "") {
			$todayDate = date('d-m-Y'); // $todayDate takes todays date when manual receipt checker is OFF
			$datMonth = $this->get_financial_year($dfMonth);
		}
		else {
			$todayDate = $ss_receipt_date;  // $todayDate takes Receipt Date when manual receipt checker is ON
			$datMonth = $this->get_shashwath_financial_year($dfMonth,$ss_receipt_date);
		}

		$shashwathData = array(
			'SM_REF'   =>$counter,
			'SM_NAME'  =>$name,
			'SM_PHONE' =>$number,
			'SM_PHONE2' =>$number2,
			'SM_RASHI' =>$rashi,
			'SM_NAKSHATRA'=>$nakshatra,
			'SM_GOTRA' =>$gotra,
			'SM_ADDR1' =>$addrline1,
			'SM_ADDR2' =>$addrline2,
			'SM_CITY'  =>$smcity,
			'SM_STATE' =>$smstate,
			'SM_COUNTRY'=>$smcountry,
			'SM_PIN'    =>$smpin,
			'REMARKS'  =>$smremarks,
			'IS_MANDALI' => $memmanismandli
	    );  
		
		$this->db->insert('shashwath_members', $shashwathData); 
		$SM_ID = $this->db->insert_id();
		$_SESSION['sm_id'] = $SM_ID;
		
		for($i = 0; $i < count($sevaName); ++$i) { 

			//Every -> Number of Sevas Count Calculation
			if($calType[$i]=="Every"){
				$maxYear = $this->obj_shashwath->getfinyear();
				$startDate = new DateTime();
				$endDate = new DateTime($maxYear.'-03-31');
				$countNOS = 0;
				if (count(explode("_",$weekcode[$i]))==1){
					while ($startDate <= $endDate) {
					    if ($startDate->format('l') == $weekcode[$i]) {
					        $countNOS++;
					    }
					    $startDate->modify('+1 day');
					}
				} else if (count(explode("_",$weekcode[$i]))==2){
					while ($startDate <= $endDate) {
					    $stringDate = $startDate->format('Y-m-d H:i:s');
					    $Timestamp = strtotime($stringDate);
						$weekFirst = date("d-m-Y", strtotime(explode("_",$weekcode[$i])[0]." ".explode("_",$weekcode[$i])[1]." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
						if(date("d-m-Y",$Timestamp)==$weekFirst){
							$countNOS++;
						}
					    $startDate->modify('+1 day');
					}
				} else if (count(explode("_",$weekcode[$i]))==3){
					$countNOS = 1;
				}
			} else {
				$countNOS = 1;
			}
			//Calculation End

			//Receipt Number
			$this->db->select()->from('SHASHWATH_MEMBER_SEVA_REFERENCE');	
			$query = $this->db->get();
			$rowResult = $query->first_row();
			$counter1 = $rowResult->SM_REF;
			$counter2 = $rowResult->SS_REF;
			$counter2 += 1;
			$this->db->update('SHASHWATH_MEMBER_SEVA_REFERENCE', array('SS_REF'=>$counter2));

			$memberReceiptFormat1 = $rowResult->SMR_ABBR1 ."/".$datMonth."/".$rowResult->SM_ABBR1.$counter1."/".$rowResult->SS_ABBR1.$counter2;

			$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
			->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
			->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=> 7 ));
			
			$query = $this->db->get();
			$deityCounter = $query->first_row();
			$counter = $deityCounter->RECEIPT_COUNTER;
			$counter += 1;
			
			$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
			
			$Ref = $counter;

			$shashwathReceipt = $memberReceiptFormat1."/".$Ref;
			
			$this->db->select()->from('DEITY_SEVA')->where(array('SEVA_ID'=>$sevaId[$i]));
			$query = $this->db->get();
			$deitySeva = $query->first_row();
			$sevaType = $deitySeva->SEVA_TYPE;
			 
			$sevaData = array(
				'SM_ID'  =>$SM_ID,
				'SS_REF' =>$counter2,
				'SS_RECEIPT_NO' =>$ss_receipt_no,
				'SS_RECEIPT_DATE' =>$todayDate,
				'DEITY_ID' =>$deityId[$i],
				'SEVA_ID' =>$sevaId[$i],
				'SEVA_QTY' =>$sevaQty[$i],
				'THITHI_CODE'=>$thithi[$i],
				'ENG_DATE' =>$date[$i],
				'SEVA_TYPE' => $sevaType,
				'CAL_TYPE' => $calType[$i],
				 'MASA'	   => $masa[$i],
				'BASED_ON_MOON'=>$bomcode[$i],
				'THITHI_NAME' =>$thithiName[$i], 
				'SP_ID'   => $periodId[$i],
				'SEVA_NOTES' => $purpose[$i],
				'SP_COUNTER' => 0,
				'SS_STATUS'  => 1,
				'SS_VERIFICATION' => 0,
				'SS_ENTERED_BY_ID' => $_SESSION['userId'],
				'SS_ENTERED_DATE_TIME'=>date('d-m-Y H:i:s A'),
				'SS_ENTERED_DATE' =>date('d-m-Y'),
				'EVERY_WEEK_MONTH' => $weekcode[$i],
				'NO_OF_SEVAS' => $countNOS,
				'SEVA_GEN_COUNTER' => $countNOS
			);
					
			$this->db->insert('shashwath_seva', $sevaData); 
			$SS_ID = $this->db->insert_id();

			if($modeOfPayment == "Cheque") {
				$paymentStatus = "Pending";
			} else {
				$paymentStatus = "Completed";
			}
			
			if(strtotime($todayDate) > strtotime($financeBookBeginDate)) {	
			 	$receiptData = array(
					'SS_ID'   =>$SS_ID,											
					'RECEIPT_NAME'=>$name,											
					'RECEIPT_NO'=>$shashwathReceipt,											
					'RECEIPT_DATE'=>$todayDate,											
					'RECEIPT_PHONE'=>$number,											
					'RECEIPT_PRICE'    => $corpus[$i],											
					'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,											
					'BRANCH_NAME'=>$branch,											
					'CHEQUE_NO'=>$chequeNo,											
					'BANK_NAME'=>$bank,											
					'CHEQUE_DATE'=>$chequeDate,											
					'TRANSACTION_ID'=>$transactionId,											
					'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,											
					'RECEIPT_RASHI'=>$rashi,											
					'RECEIPT_NAKSHATRA'=>$nakshatra,
					'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],											
					'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],											
					'DATE_TIME' => $dateTime,											
					'RECEIPT_ACTIVE'=>1,											
					'RECEIPT_CATEGORY_ID'=>7,											
					'PAYMENT_STATUS'=>$paymentStatus,											
					'AUTHORISED_STATUS'=> 'No',											
			/*		'EOD_CONFIRMED_BY_ID' => 33,											
					'EOD_CONFIRMED_BY_NAME' => 'C. Suresh Bhat',											
					'EOD_CONFIRMED_DATE_TIME' => date('d-m-Y H:i:s A'),											
					'EOD_CONFIRMED_DATE' => date('d-m-Y'),*/											
					'DATE_TYPE'=>$date_type,											
					'RECEIPT_ADDRESS' => $sm_address,											
					'POSTAGE_CHECK' => (($postage[$i] == "YES")?1:0),											
					'POSTAGE_GROUP_ID' => 1,											
					'ADDRESS_LINE1' => strtoupper($addressLine1[$i]),											
					'ADDRESS_LINE2' => strtoupper($addressLine2[$i]),											
					'CITY' => strtoupper($city[$i]),											
					'STATE' => strtoupper($state[$i]),											
					'COUNTRY' => strtoupper($country[$i]),											
					'PINCODE' => $pincode[$i],
					'FGLH_ID' => $fglhBank,							//laz new ..
					'SS_RECEIPT_NO_REF' => $ss_receipt_no,
					'RECEIPT_PAN_NO'=>$pan,
			    'RECEIPT_ADHAAR_NO'=>$adhaar		

				); 
			}
			else {
				$receiptData = array(
				'SS_ID'   =>$SS_ID,
				'RECEIPT_NAME'=>$name,
				'RECEIPT_NO'=>$shashwathReceipt,
				'RECEIPT_DATE'=>$todayDate,
				'RECEIPT_PHONE'=>$number,
				'RECEIPT_PRICE'    => $corpus[$i],
				'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,
				'BRANCH_NAME'=>$branch,
				'CHEQUE_NO'=>$chequeNo,
				'BANK_NAME'=>$bank,
				'CHEQUE_DATE'=>$chequeDate,
				'TRANSACTION_ID'=>$transactionId,
				'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,
				'RECEIPT_RASHI'=>$rashi,
				'RECEIPT_NAKSHATRA'=>$nakshatra,
				'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'DATE_TIME' => $dateTime,
				'RECEIPT_ACTIVE'=>1,
				'RECEIPT_CATEGORY_ID'=>7,
				'PAYMENT_STATUS'=>$paymentStatus,
				'AUTHORISED_STATUS'=> 'Yes',
				'AUTHORISED_BY' => 33,
				'AUTHORISED_BY_NAME' => 'C. Suresh Bhat',
				'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'),
				'AUTHORISED_DATE' => date('d-m-Y'),
				'EOD_CONFIRMED_BY_ID' => 33,
				'EOD_CONFIRMED_BY_NAME' => 'C. Suresh Bhat',
				'EOD_CONFIRMED_DATE_TIME' => date('d-m-Y H:i:s A'),
				'EOD_CONFIRMED_DATE' => date('d-m-Y'),
				'DATE_TYPE'=>$date_type,
				'RECEIPT_ADDRESS' => $sm_address,
				'POSTAGE_CHECK' => (($postage[$i] == "YES")?1:0),
				'POSTAGE_GROUP_ID' => 1,
				'ADDRESS_LINE1' => strtoupper($addressLine1[$i]),
				'ADDRESS_LINE2' => strtoupper($addressLine2[$i]),
				'CITY' => strtoupper($city[$i]),
				'STATE' => strtoupper($state[$i]),
				'COUNTRY' => strtoupper($country[$i]),
				'PINCODE' => $pincode[$i],
				'FGLH_ID' => $fglhBank,						//laz new ..
				'SS_RECEIPT_NO_REF' => $ss_receipt_no ,
				'RECEIPT_PAN_NO'=>$pan,
			    'RECEIPT_ADHAAR_NO'=>$adhaar		
			); 
			}
			
			$this->db->insert('DEITY_RECEIPT', $receiptData);
			$SHASHWATH_RECEIPT = $this->db->insert_id();

			$this->db->where('sm_id', $temp_sm_id);
			$this->db->update('shashwath_member_import', array('sm_status'=>1));
			


			if($postage == 1) {
				$dataPostage = array(
								'RECEIPT_ID' => $SHASHWATH_RECEIPT,
								'POSTAGE_CATEGORY' => 1, //1 = Deity, 2 = Event, 3 = Trust Event
								'POSTAGE_STATUS' => 0,
								'DATE_TIME' => date('d-m-Y H:i:s A'),
								'DATE' => date('d-m-Y'));
				$this->db->insert('POSTAGE', $dataPostage);
			}    
		}


	if($modeOfPayment =='Transfer' ){

		$this->db->select()->from('finance_voucher_counter')
		->where(array('finance_voucher_counter.FVC_ID'=>'5'));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->FVC_COUNTER+1;
		
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$countNoJ = $deityCounter->FVC_ABBR1 ."/".$datMonth."/".$deityCounter->FVC_ABBR2."/".$counter;
		$naration = str_replace("'","\'",@$_POST['naration']);
		$type = json_decode(@$_POST['type']);
		$ledgers = json_decode(@$_POST['ledgers']);
		$amount = json_decode(@$_POST['amount']);
		$tDateJ =date('d-m-Y');
		$user= $_SESSION['userId'];
		$corpustot =  @$_POST['corpustot'];
		$compId = 1;	
		for($i = 0; $i < count($amount); ++$i) {
			$lidJ = $ledgers[$i];

			if($type[$i]=="from")
			{
				$firstAmt = $amount[$i];
				$secondAmt = 0;
				$rptype = "J1";
				$this->obj_finance->putJournalTransfer($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$user,$rptype,$SHASHWATH_RECEIPT,$compId);
			 } 
		}
		$lidJ = 25;
		$firstAmt = 0;
		$secondAmt = $corpustot;
		$rptype = "J2";
		$this->obj_finance->putJournalTransfer($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$user,$rptype,$SHASHWATH_RECEIPT,$compId);

		$this->db->where('finance_voucher_counter.FVC_ID',5);
		$this->db->update('finance_voucher_counter', array('FVC_COUNTER'=>$counter));
	}
		echo "success";
		echo "|".$SM_ID;
		$_SESSION['shashwathReceipt'] = $shashwathReceipt; 
	}

	


	
	function payLossReceipt(){
		$namePhone = explode('(',$_POST['namePhone']);
		$name = $namePhone[0];
		$phone = preg_replace('/\D/', '', $namePhone[1]);
		$todayDate = date('d-m-Y');
		$seva_name = $_POST['seva_name'];
		$deityName = $_POST['deityName'];
		//$sevaLoss =array();
		$sevaLoss = explode(",",$_POST['sevaLoss']);
		//print_r($sevaLoss);
		$ssId = $_POST['ssId'];
		$soId = explode(",",$_POST['soId']);
		$lossAmount = $_POST['Loss_Amount'];
		$modeOfPayment = $_POST['modeOfPayment'];
		$paymentNotes = $_POST['paymentNotes'];
		$chequeNo = $_POST['chequeNo'];
		$Chequedate = $_POST['Chequedate'];
		$bank1 = $_POST['bank1'];
		$branch1 = $_POST['branch1'];
		$transactionId1 = $_POST['transactionId1'];
		$corpusCallFrom = $_POST['corpusCallFrom'];
		
		// $this ->db->select('SS_REF,shashwath_members.SM_REF')->from('shashwath_seva')-> join('shashwath_members','shashwath_members.SM_ID = shashwath_seva.SM_ID')
		// ->where(array('shashwath_seva.SS_ID'=> $ssId ));  
		// $query = $this->db->get();
		// $refnums = $query->result();
		// $this->db->select()->from('SHASHWATH_MEMBER_SEVA_REFERENCE');	
		// $query = $this->db->get();
		// $rowResult = $query->first_row();					
		// $dfMonth = $this->obj_admin_settings->get_financial_month();
		// $datMonth = $this->get_financial_year($dfMonth);
		// $format = $rowResult->SMR_ABBR1.'/'.$datMonth.'/'.$rowResult->SM_ABBR1.$refnums[0]->SM_REF.'/'.$rowResult->SS_ABBR1.$refnums[0]->SS_REF;
		// $this->db->select()->from('DEITY_RECEIPT_CATEGORY')
		// ->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		// ->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=> 7 ));
		// $query = $this->db->get();
		// $deityCounter = $query->first_row();
		// $counter = $deityCounter->RECEIPT_COUNTER;
		// $counter += 1;
		// $this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		// $this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		// $Ref = $counter;				
		// $receiptFormat = $format.'/'.$Ref;

			$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=>'3'));
		
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		
		$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;


		$receiptData = array(
			'SS_ID'   =>$ssId,
			'RECEIPT_NAME'=>$name,
			'RECEIPT_PHONE'=>$phone,
			'RECEIPT_DEITY_NAME'=>$deityName,
			'RECEIPT_NO'=>$receiptFormat,
			'RECEIPT_DATE'=>$todayDate,
			'RECEIPT_PRICE' =>$lossAmount,
			'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,
			'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,
			'CHEQUE_NO' => $chequeNo,
			'CHEQUE_DATE' => $Chequedate,
			'BANK_NAME' => $bank1,
			'BRANCH_NAME' => $branch1,
			'TRANSACTION_ID' =>	$transactionId1,	
			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'RECEIPT_ACTIVE'=>1,
			'RECEIPT_CATEGORY_ID'=>3,
			'PAYMENT_STATUS'=>'Completed',
			'AUTHORISED_STATUS'=>'No',
			'KANIKE_FOR' => 2
		); 
						
		$this->db->insert('DEITY_RECEIPT', $receiptData);
		$SHASHWATH_RECEIPT_ID = $this->db->insert_id();
        $_SESSION['payLossReceiptId'] = $SHASHWATH_RECEIPT_ID;

			for($i = 0; $i <= count($sevaLoss)-1; $i++){
				if($sevaLoss[$i] <= $lossAmount && $sevaLoss[$i] != ""){
					$result = ($lossAmount - $sevaLoss[$i]);
					$lossAmount = $result;
					$this->db->where('SO_ID',$soId[$i]);
					//update deity offered table
					$this->db->update('DEITY_SEVA_OFFERED', array('LOSS_BALANCE'=> 0, 'SEVA_LOSS_CONFIRMED' => 1));
					//insert record to loss paid table
					$losspaid =array('SO_ID' => $soId[$i],'RECEIPT_ID'=>$SHASHWATH_RECEIPT_ID,'AMOUNT'=>$sevaLoss[$i],'SLP_SS_ID'=>$ssId);
					$this->db->insert('shashwath_loss_paid',$losspaid);
				} else if($sevaLoss[$i] > $lossAmount && $sevaLoss[$i] != ""){
					$result = ($sevaLoss[$i]-$lossAmount );
					$this->db->where('SO_ID',$soId[$i]);
					//update deity offered table
					$this->db->update('DEITY_SEVA_OFFERED', array('LOSS_BALANCE'=>$result));
					$losspaid =array('SO_ID' => $soId[$i],'RECEIPT_ID'=>$SHASHWATH_RECEIPT_ID,'AMOUNT'=>$lossAmount,'SLP_SS_ID'=>$ssId);
					$this->db->insert('shashwath_loss_paid',$losspaid);	
					$lossAmount = 0;
				} 
			}
		$countLossSeva = $this->obj_shashwath->count_LossReport_Rows($todayDate);
		$_SESSION['countLossSeva'] = $countLossSeva;
		$_SESSION['CorpusCallFrom'] = $corpusCallFrom;
		redirect('Receipt/receipt_payLoss_print');  
		 
	}
	 function receipt_payLoss_print() {
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		if(isset($_SESSION['payLossReceiptId'])) {
		$receiptId = $_SESSION['payLossReceiptId'];
		}
		$data['fromAllReceipt'] = "7";
		
		//$receiptFormat = $_SESSION['receiptFormat'];
		$this->db->select('deity_Receipt.RECEIPT_ID,shashwath_seva.SM_ID,shashwath_seva.SS_ID,SO_ID,deity_seva.SEVA_NAME,RECEIPT_NO,RECEIPT_NAME,RECEIPT_DATE,RECEIPT_ADDRESS,RECEIPT_PHONE,RECEIPT_PRICE,DEITY_NAME,POSTAGE_PRICE,RECEIPT_PAYMENT_METHOD,RECEIPT_PAYMENT_METHOD_NOTES,RECEIPT_ACTIVE,AUTHORISED_STATUS,PRINT_STATUS,RECEIPT_ADDRESS,RECEIPT_ISSUED_BY,CHEQUE_NO,CHEQUE_DATE,BRANCH_NAME,BANK_NAME,TRANSACTION_ID,RECEIPT_RASHI,RECEIPT_NAKSHATRA,BASED_ON_MOON,THITHI_NAME,MASA,ENG_DATE,SEVA_NOTES')->from('DEITY_RECEIPT')->join('shashwath_seva', 'shashwath_seva.SS_ID = DEITY_RECEIPT.SS_ID')->join('DEITY', 'shashwath_seva.DEITY_ID = DEITY.DEITY_ID')->join('deity_seva', 'deity_seva.SEVA_ID = shashwath_seva.SEVA_ID')->join('deity_seva_offered', 'deity_seva_offered.SS_ID = shashwath_seva.SS_ID')
		->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
		$query = $this->db->get();
		$data['deityCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		//print_r($data['deityCounter']);
		$this->load->view('header', $data);
		$this->load->view('receipt_shashwathCorpusPrint');
		$this->load->view('footer_home');
	}

	// function generateReceipt() {
	// 	$financeBookBeginDate = date('31-03-2021');

	// 	$_SESSION['duplicate'] = "no";
	// 	$todayDate = date('d-m-Y');
	// 	$dateTime = date('d-m-Y H:i:s A');
		
	// 	$name =strtoupper(@$_POST['name']) ;
	// 	$number = @$_POST['number'];
	// 	$number2 = @$_POST['number2'];
	// 	$rashi = @$_POST['rashi'];
	// 	$gotra = @$_POST['gotra'];
	// 	$nakshatra = @$_POST['nakshatra'];
		
	// 	$date_type = @$_POST['date_type'];
	// 	$sevaType = @$_POST['sevaType'];
	//     $sevaName = json_decode(@$_POST['sevaName']);
	// 	$date = json_decode(@$_POST['date']);
	// 	$price = json_decode(@$_POST['price']);
	// 	$amt = json_decode(@$_POST['amt']);
	// 	$sevaId = json_decode(@$_POST['sevaId']);
	// 	$sevaQty = json_decode(@$_POST['sevaQty']);
	// 	$thithi = json_decode(@$_POST['thithi']);
	// 	$corpus = json_decode(@$_POST['corpus']);
	// 	$sevaNotes = json_decode(@$_POST['purpose']);
	// 	$userId = json_decode(@$_POST['userId']);
	// 	$quantityChecker = json_decode(@$_POST['quantityChecker']);
	// 	$deityId = json_decode(@$_POST['deityId']);
	// 	$deityName = json_decode(@$_POST['deityName']);
	// 	$isSeva = json_decode(@$_POST['isSeva']);
	// 	$revFlag = json_decode(@$_POST['revFlag']);
	// 	$masa = json_decode(@$_POST['masa1']);
	// 	$bomcode = json_decode(@$_POST['bomcode1']);
	// 	$thithiName = json_decode(@$_POST['thithiName1']);
	// 	$weekcode = json_decode(@$_POST['everyweekMonth']);

	// 	//manual entry for receipt number and date
	// 	$ss_receipt_no = json_decode(@$_POST['ss_receipt_no']);
	// 	$ss_receipt_date = json_decode(@$_POST['ss_receipt_date']);
		
	// 	$total = @$_POST['total'];
		

	// 	$modeOfPayment = @$_POST['modeOfPayment'];
	// 	$branch = @$_POST['branch'];
	// 	$chequeNo = @$_POST['chequeNo'];
	// 	$bank = @$_POST['bank'];
	// 	$chequeDate = @$_POST['chequeDate'];
	// 	$transactionId = @$_POST['transactionId'];
	// 	$fglhBank = @$_POST['fglhBank'];							 //laz new
	// 	$paymentNotes = @$_POST['paymentNotes'];
		
	// 	$postage = json_decode(@$_POST['postage']);
		
	// 	$addressLine1 = json_decode(@$_POST['addressLine1']);
	// 	$addressLine2 = json_decode(@$_POST['addressLine2']);
	// 	$city = json_decode(@$_POST['city']);
	// 	$state = json_decode(@$_POST['state']);
	// 	$country = json_decode(@$_POST['country']);
	// 	$pincode = json_decode(@$_POST['pincode']);
	// 	$address = json_decode(@$_POST['address']);
		
	// 	$addrline1 = strtoupper(@$_POST['addrline1']);
	// 	$addrline2 = strtoupper(@$_POST['addrline2']);
	// 	$smcity = strtoupper(@$_POST['smcity']);
	// 	$smstate = strtoupper(@$_POST['smstate']);
	// 	$smcountry = strtoupper(@$_POST['smcountry']);
	// 	$smpin = @$_POST['smpin'];
	// 	$smremarks = @$_POST['smremarks'];
	// 	$calType = json_decode(@$_POST['calType1']);
	// 	$periodId = json_decode(@$_POST['periodId']);
	// 	$smId = @$_POST['sm_id'];
		
	// 	$sm_address = (($addrline1 != "")?$addrline1.", ":"").(($addrline2 != "")?$addrline2.", ":"").(($smcity != "")?$smcity." ":"").(($smstate != "")?$smstate." ":"").(($smcountry != "")?$smcountry." - ":"").(($smpin != "")?$smpin:"");
		
	// 	for($i = 0; $i < count($sevaName); ++$i) { 
	// 		//Every -> Number of Sevas Count Calculation
	// 		if($calType[$i]=="Every"){
	// 			$maxYear = $this->obj_shashwath->getfinyear();
	// 			$startDate = new DateTime();
	// 			$endDate = new DateTime($maxYear.'-03-31');
	// 			$countNOS = 0;
	// 			if (count(explode("_",$weekcode[$i]))==1){
	// 				while ($startDate <= $endDate) {
	// 				    if ($startDate->format('l') == $weekcode[$i]) {
	// 				        $countNOS++;
	// 				    }
	// 				    $startDate->modify('+1 day');
	// 				}
	// 			}else {
	// 				while ($startDate <= $endDate) {
	// 				    $stringDate = $startDate->format('Y-m-d H:i:s');
	// 				    $Timestamp = strtotime($stringDate);
	// 					$weekFirst = date("d-m-Y", strtotime("first ".explode("_",$weekcode[$i])[1]." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 					if(date("d-m-Y",$Timestamp)==$weekFirst){
	// 						$countNOS++;
	// 					}
	// 				    $startDate->modify('+1 day');
	// 				}
	// 			}
	// 		} else {
	// 			$countNOS = 1;
	// 		}
	// 		//Calculation End
	// 		$this->db->select()->from('SHASHWATH_MEMBER_SEVA_REFERENCE');	
	// 		$query = $this->db->get();
	// 		$rowResult = $query->first_row();

	// 		$this->db->select()->from('shashwath_members');
	// 		$this->db->where('SM_ID',$smId);	
	// 		$query1 = $this->db->get();
	// 		$rowResult1 = $query1->first_row();

	// 		$counter1 = $rowResult1->SM_REF;
	// 		$counter2 = $rowResult->SS_REF;
	// 		$counter2 += 1;
	// 		$this->db->update('SHASHWATH_MEMBER_SEVA_REFERENCE', array('SS_REF'=>$counter2));
				
	// 		$dfMonth = $this->obj_admin_settings->get_financial_month();
	// 		if ($ss_receipt_no[$i] == "") {
	// 			$todayDate = date('d-m-Y'); // $todayDate takes todays date when manual receipt checker is OFF
	// 			$datMonth = $this->get_financial_year($dfMonth);
	// 		}
	// 		else {
	// 			$todayDate = $ss_receipt_date[$i];  // $todayDate takes Receipt Date when manual receipt checker is ON
	// 			$datMonth = $this->get_shashwath_financial_year($dfMonth,$ss_receipt_date[$i]);
	// 		}			

	// 		$memberReceiptFormat1 = $rowResult->SMR_ABBR1 ."/".$datMonth."/".$rowResult->SM_ABBR1.$counter1."/".$rowResult->SS_ABBR1.$counter2;
	// 		$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
	// 		->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
	// 		->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=> 7 ));
			
	// 		$query = $this->db->get();
	// 		$deityCounter = $query->first_row();
	// 		$counter = $deityCounter->RECEIPT_COUNTER;
	// 		$counter += 1;
				
	// 		$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
	// 		$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
			
	// 		if($modeOfPayment == "Cheque") {
	// 			$paymentStatus = "Pending";
	// 		} else {
	// 			$paymentStatus = "Completed";
	// 		}
				
	// 		$Ref = $counter;				
	// 		$Receipt = $memberReceiptFormat1."/".$Ref; 			

	// 		$this->db->select()->from('DEITY_SEVA')->where(array('SEVA_ID'=>$sevaId[$i]));
	// 		$query = $this->db->get();
	// 		$deitySeva = $query->first_row();
	// 		$sevaType = $deitySeva->SEVA_TYPE;
			
	// 		$sevaData = array(
	// 			'SM_ID'  =>$smId,
	// 			'SS_REF' =>$counter2,
	// 			'SS_RECEIPT_NO' =>$ss_receipt_no[$i],
	// 			'SS_RECEIPT_DATE' =>$todayDate,
	// 			'DEITY_ID' =>$deityId[$i],
	// 			'SEVA_ID' =>$sevaId[$i],
	// 			'SEVA_QTY' => $sevaQty[$i],
	// 			'THITHI_CODE'=>$thithi[$i],
	// 			'ENG_DATE' =>$date[$i],
	// 			'SEVA_TYPE' => $sevaType,
	// 			'CAL_TYPE' => $calType[$i],
	// 			 'MASA'	   => $masa[$i],
	// 			'BASED_ON_MOON'=>$bomcode[$i],
	// 			'THITHI_NAME' =>$thithiName[$i], 
	// 			'SP_ID'   => $periodId[$i],
	// 			'SEVA_NOTES' => $sevaNotes[$i],
	// 			'SP_COUNTER' => 0,
	// 			'SS_STATUS'  => 1,
	// 			'SS_VERIFICATION' => ((isset($_SESSION['Authorise']))?1:0),
	// 			'SS_VERIFICATION_BY_ID' => ((isset($_SESSION['Authorise']))?$_SESSION['userId']:0),
	// 			'SS_VERIFICATION_DATE_TIME' => ((isset($_SESSION['Authorise']))?date('d-m-Y H:i:s A'):""),
	// 			'SS_VERIFICATION_DATE' => ((isset($_SESSION['Authorise']))?date('d-m-Y'):""),
	// 			'SS_ENTERED_BY_ID' => $_SESSION['userId'],
	// 			'SS_ENTERED_DATE_TIME'=>date('d-m-Y H:i:s A'),
	// 			'SS_ENTERED_DATE' =>date('d-m-Y'),
	// 			'EVERY_WEEK_MONTH' => $weekcode[$i],
	// 			'NO_OF_SEVAS' => $countNOS

	// 		);
	// 		$this->db->insert('shashwath_seva', $sevaData); 
	// 		$SS_ID = $this->db->insert_id();
			
	// 		//Receipt Number
	// 		if(strtotime($todayDate) > strtotime($financeBookBeginDate)) {
	// 			$receiptData = array(
	// 				'SS_ID'   =>$SS_ID,
	// 				'RECEIPT_NAME'=>$name,
	// 				'RECEIPT_NO'=>$Receipt,
	// 				'RECEIPT_DATE'=>$todayDate,
	// 				'RECEIPT_PHONE'=>$number,
	// 				'RECEIPT_PRICE'    => $corpus[$i],
	// 				'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,
	// 				'BRANCH_NAME'=>$branch,
	// 				'CHEQUE_NO'=>$chequeNo,
	// 				'BANK_NAME'=>$bank,
	// 				'CHEQUE_DATE'=>$chequeDate,
	// 				'TRANSACTION_ID'=>$transactionId,
	// 				'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,
	// 				'RECEIPT_RASHI'=>$rashi,
	// 				'RECEIPT_NAKSHATRA'=>$nakshatra,
	// 				'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
	// 				'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
	// 				'DATE_TIME' => $dateTime,
	// 				'RECEIPT_ACTIVE'=>1,
	// 				'RECEIPT_CATEGORY_ID'=>7,
	// 				'PAYMENT_STATUS'=>$paymentStatus,
	// 				'AUTHORISED_STATUS'=>'No',	
					
	// 				'DATE_TYPE'=>$date_type,
	// 				'RECEIPT_ADDRESS' => $sm_address,
	// 				'POSTAGE_CHECK' => (($postage[$i] == "YES")?1:0),
	// 				'POSTAGE_GROUP_ID' => 1,
	// 				'ADDRESS_LINE1' => strtoupper($addressLine1[$i]),
	// 				'ADDRESS_LINE2' => strtoupper($addressLine2[$i]),
	// 				'CITY' => strtoupper($city[$i]),
	// 				'STATE' => strtoupper($state[$i]),
	// 				'COUNTRY' => strtoupper($country[$i]),
	// 				'PINCODE' => $pincode[$i],
	// 				'FGLH_ID' => $fglhBank,							//laz new ..
	// 				'SS_RECEIPT_NO_REF' =>$ss_receipt_no[$i] 
	// 			);
	// 		}else{
	// 			$receiptData = array(
	// 				'SS_ID'   =>$SS_ID,
	// 				'RECEIPT_NAME'=>$name,
	// 				'RECEIPT_NO'=>$Receipt,
	// 				'RECEIPT_DATE'=>$todayDate,
	// 				'RECEIPT_PHONE'=>$number,
	// 				'RECEIPT_PRICE'    => $corpus[$i],
	// 				'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,
	// 				'BRANCH_NAME'=>$branch,
	// 				'CHEQUE_NO'=>$chequeNo,
	// 				'BANK_NAME'=>$bank,
	// 				'CHEQUE_DATE'=>$chequeDate,
	// 				'TRANSACTION_ID'=>$transactionId,
	// 				'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,
	// 				'RECEIPT_RASHI'=>$rashi,
	// 				'RECEIPT_NAKSHATRA'=>$nakshatra,
	// 				'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
	// 				'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
	// 				'DATE_TIME' => $dateTime,
	// 				'RECEIPT_ACTIVE'=>1,
	// 				'RECEIPT_CATEGORY_ID'=>7,
	// 				'PAYMENT_STATUS'=>$paymentStatus,
	// 				'AUTHORISED_STATUS'=> (($_SESSION['Authorise'] == "Auth_Right")?'Yes':'No'),
	// 				'AUTHORISED_BY' => (($_SESSION['Authorise'] == "Auth_Right")?$_SESSION['userId']:0),
	// 				'AUTHORISED_BY_NAME' => (($_SESSION['Authorise'] == "Auth_Right")?$_SESSION['userFullName']:""),
	// 				'AUTHORISED_DATE_TIME' => (($_SESSION['Authorise'] == "Auth_Right")?date('d-m-Y H:i:s A'):""),
	// 				'AUTHORISED_DATE' => (($_SESSION['Authorise'] == "Auth_Right")?date('d-m-Y'):""),
	// 				'EOD_CONFIRMED_BY_ID' => (($_SESSION['Authorise'] == "Auth_Right")?$_SESSION['userId']:0),
	// 				'EOD_CONFIRMED_BY_NAME' => (($_SESSION['Authorise'] == "Auth_Right")?$_SESSION['userFullName']:""),
	// 				'EOD_CONFIRMED_DATE_TIME' => (($_SESSION['Authorise'] == "Auth_Right")?date('d-m-Y H:i:s A'):""),
	// 				'EOD_CONFIRMED_DATE' => (($_SESSION['Authorise'] == "Auth_Right")?date('d-m-Y'):""),
	// 				'DATE_TYPE'=>$date_type,
	// 				'RECEIPT_ADDRESS' => $sm_address,
	// 				'POSTAGE_CHECK' => (($postage[$i] == "YES")?1:0),
	// 				'POSTAGE_GROUP_ID' => 1,
	// 				'ADDRESS_LINE1' => strtoupper($addressLine1[$i]),
	// 				'ADDRESS_LINE2' => strtoupper($addressLine2[$i]),
	// 				'CITY' => strtoupper($city[$i]),
	// 				'STATE' => strtoupper($state[$i]),
	// 				'COUNTRY' => strtoupper($country[$i]),
	// 				'PINCODE' => $pincode[$i],
	// 				'FGLH_ID' => $fglhBank,						//laz new ..
	// 				'SS_RECEIPT_NO_REF' =>$ss_receipt_no[$i] 
	// 			);
	// 		}
					
	// 		$this->db->insert('DEITY_RECEIPT', $receiptData);
	// 		$SHASHWATH_RECEIPT = $this->db->insert_id();
			
	// 		if($postage == 1) {
	// 			$dataPostage = array(
	// 							'RECEIPT_ID' => $SHASHWATH_RECEIPT,
	// 							'POSTAGE_CATEGORY' => 1,
	// 							'POSTAGE_STATUS' => 0,
	// 							'DATE_TIME' => date('d-m-Y H:i:s A'),
	// 							'DATE' => date('d-m-Y'));
	// 			$this->db->insert('POSTAGE', $dataPostage);
	// 		} 
	// 	}
	// 	if(isset($_SESSION['Authorise'])) {
	// 		if($_SESSION['Authorise'] == 'Auth_Right') {
	// 			$dataSSID = array('SM_ID' => $smId,
	// 				 			  'SS_VERIFICATION' => 0);

	// 			$this->db->select('SS_ID');
	// 			$this->db->from('SHASHWATH_SEVA');
	// 			$this->db->where($dataSSID);
				
	// 			$query = $this->db->get();
	// 			if ($query->num_rows() > 0) {
	// 				foreach($query->result() as $ShashSeva) {
	// 					$data = array (		
	// 						'SS_VERIFICATION' => 1,
	// 						'SS_VERIFICATION_BY_ID' => $_SESSION['userId'],
	// 						'SS_VERIFICATION_DATE_TIME' => date('d-m-Y H:i:s A'),
	// 						'SS_VERIFICATION_DATE' => date('d-m-Y')
	// 					);

	// 					$this->db->where('SS_ID',$ShashSeva->SS_ID);
	// 					$this->db->update('shashwath_seva',$data);	
	// 				}
	// 			}

	// 			// $dataReceiptId = array('RECEIPT_CATEGORY_ID' => 7,
	// 			// 	 			  'AUTHORISED_STATUS' => 'No',
	// 			// 				  'SS_VERIFICATION' => 1);

	// 			// $this->db->select('RECEIPT_ID');
	// 			// $this->db->from('DEITY_RECEIPT');
	// 			// $this->db->join('SHASHWATH_SEVA','DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID');
	// 			// $this->db->where($dataReceiptId);
	// 			// $query1 = $this->db->get();
				
	// 			// if ($query1->num_rows() > 0) {
	// 			// 	foreach($query1->result() as $Receipts) {
	// 			// 		$data = array (		
	// 			// 			'AUTHORISED_STATUS'=> 'Yes',
	// 			// 			'AUTHORISED_BY' => $_SESSION['userId'],
	// 			// 			'AUTHORISED_BY_NAME' => $_SESSION['userFullName'],
	// 			// 			'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'),
	// 			// 			'AUTHORISED_DATE' => date('d-m-Y'),
	// 			// 			'EOD_CONFIRMED_BY_ID' => $_SESSION['userId'],
	// 			// 			'EOD_CONFIRMED_BY_NAME' => $_SESSION['userFullName'],
	// 			// 			'EOD_CONFIRMED_DATE_TIME' => date('d-m-Y H:i:s A'),
	// 			// 			'EOD_CONFIRMED_DATE' => date('d-m-Y')
	// 			// 		);

	// 			// 		$this->db->where('RECEIPT_ID',$Receipts->RECEIPT_ID);
	// 			// 		$this->db->update('DEITY_RECEIPT',$data);	
	// 			// 	}
	// 			// }
	// 		}
	// 	}

	// 	echo "success";
	// 	$_SESSION['Receipt'] = $Receipt; 
	// }


	function generateReceipt() {
		$financeBookBeginDate = date('31-03-2021');

		$_SESSION['duplicate'] = "no";
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		
		$name =strtoupper(@$_POST['name']) ;
		$number = @$_POST['number'];
		$number2 = @$_POST['number2'];
		$rashi = @$_POST['rashi'];
		$gotra = @$_POST['gotra'];
		$nakshatra = @$_POST['nakshatra'];
		
		$date_type = @$_POST['date_type'];
		$sevaType = @$_POST['sevaType'];
	    $sevaName = json_decode(@$_POST['sevaName']);
		$date = json_decode(@$_POST['date']);
		$price = json_decode(@$_POST['price']);
		$amt = json_decode(@$_POST['amt']);
		$sevaId = json_decode(@$_POST['sevaId']);
		$sevaQty = json_decode(@$_POST['sevaQty']);
		$thithi = json_decode(@$_POST['thithi']);
		$corpus = json_decode(@$_POST['corpus']);
		$sevaNotes = json_decode(@$_POST['purpose']);
		$userId = json_decode(@$_POST['userId']);
		$quantityChecker = json_decode(@$_POST['quantityChecker']);
		$deityId = json_decode(@$_POST['deityId']);
		$deityName = json_decode(@$_POST['deityName']);
		$isSeva = json_decode(@$_POST['isSeva']);
		$revFlag = json_decode(@$_POST['revFlag']);
		$masa = json_decode(@$_POST['masa1']);
		$bomcode = json_decode(@$_POST['bomcode1']);
		$thithiName = json_decode(@$_POST['thithiName1']);
		$weekcode = json_decode(@$_POST['everyweekMonth']);

		//manual entry for receipt number and date
		$ss_receipt_no = json_decode(@$_POST['ss_receipt_no']);
		$ss_receipt_date = json_decode(@$_POST['ss_receipt_date']);
		
		$total = @$_POST['total'];
		

		$modeOfPayment = @$_POST['modeOfPayment'];
		$branch = @$_POST['branch'];
		$chequeNo = @$_POST['chequeNo'];
		$bank = @$_POST['bank'];
		$chequeDate = @$_POST['chequeDate'];
		$transactionId = @$_POST['transactionId'];
		$fglhBank = @$_POST['fglhBank'];							 //laz new
		$paymentNotes = @$_POST['paymentNotes'];
		
		$postage = json_decode(@$_POST['postage']);
		
		$addressLine1 = json_decode(@$_POST['addressLine1']);
		$addressLine2 = json_decode(@$_POST['addressLine2']);
		$city = json_decode(@$_POST['city']);
		$state = json_decode(@$_POST['state']);
		$country = json_decode(@$_POST['country']);
		$pincode = json_decode(@$_POST['pincode']);
		$address = json_decode(@$_POST['address']);
		
		$addrline1 = strtoupper(@$_POST['addrline1']);
		$addrline2 = strtoupper(@$_POST['addrline2']);
		$smcity = strtoupper(@$_POST['smcity']);
		$smstate = strtoupper(@$_POST['smstate']);
		$smcountry = strtoupper(@$_POST['smcountry']);
		$smpin = @$_POST['smpin'];
		$smremarks = @$_POST['smremarks'];
		$calType = json_decode(@$_POST['calType1']);
		$periodId = json_decode(@$_POST['periodId']);
		$smId = @$_POST['sm_id'];
		
		$sm_address = (($addrline1 != "")?$addrline1.", ":"").(($addrline2 != "")?$addrline2.", ":"").(($smcity != "")?$smcity." ":"").(($smstate != "")?$smstate." ":"").(($smcountry != "")?$smcountry." - ":"").(($smpin != "")?$smpin:"");
		
		for($i = 0; $i < count($sevaName); ++$i) { 
			//Every -> Number of Sevas Count Calculation
			if($calType[$i]=="Every"){
				$maxYear = $this->obj_shashwath->getfinyear();
				$startDate = new DateTime();
				$endDate = new DateTime($maxYear.'-03-31');
				$countNOS = 0;
				if (count(explode("_",$weekcode[$i]))==1){
					while ($startDate <= $endDate) {
					    if ($startDate->format('l') == $weekcode[$i]) {
					        $countNOS++;
					    }
					    $startDate->modify('+1 day');
					}
				} else if (count(explode("_",$weekcode[$i]))==2){
					while ($startDate <= $endDate) {
					    $stringDate = $startDate->format('Y-m-d H:i:s');
					    $Timestamp = strtotime($stringDate);
						$weekFirst = date("d-m-Y", strtotime(explode("_",$weekcode[$i])[0]." ".explode("_",$weekcode[$i])[1]." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
						if(date("d-m-Y",$Timestamp)==$weekFirst){
							$countNOS++;
						}
					    $startDate->modify('+1 day');
					}
				} else if (count(explode("_",$weekcode[$i]))==3){
					$countNOS = 1;
				}
			} else {
				$countNOS = 1;
			}
			//Calculation End
			$this->db->select()->from('SHASHWATH_MEMBER_SEVA_REFERENCE');	
			$query = $this->db->get();
			$rowResult = $query->first_row();

			$this->db->select()->from('shashwath_members');
			$this->db->where('SM_ID',$smId);	
			$query1 = $this->db->get();
			$rowResult1 = $query1->first_row();

			$counter1 = $rowResult1->SM_REF;
			$counter2 = $rowResult->SS_REF;
			$counter2 += 1;
			$this->db->update('SHASHWATH_MEMBER_SEVA_REFERENCE', array('SS_REF'=>$counter2));
				
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			if ($ss_receipt_no[$i] == "") {
				$todayDate = date('d-m-Y'); // $todayDate takes todays date when manual receipt checker is OFF
				$datMonth = $this->get_financial_year($dfMonth);
			}
			else {
				$todayDate = $ss_receipt_date[$i];  // $todayDate takes Receipt Date when manual receipt checker is ON
				$datMonth = $this->get_shashwath_financial_year($dfMonth,$ss_receipt_date[$i]);
			}			

			$memberReceiptFormat1 = $rowResult->SMR_ABBR1 ."/".$datMonth."/".$rowResult->SM_ABBR1.$counter1."/".$rowResult->SS_ABBR1.$counter2;
			$this->db->select()->from('DEITY_RECEIPT_CATEGORY')
			->join('DEITY_RECEIPT_COUNTER', 'DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID = DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID')
			->where(array('DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID'=> 7 ));
			
			$query = $this->db->get();
			$deityCounter = $query->first_row();
			$counter = $deityCounter->RECEIPT_COUNTER;
			$counter += 1;
				
			$this->db->where('RECEIPT_COUNTER_ID',$deityCounter->ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
			
			if($modeOfPayment == "Cheque") {
				$paymentStatus = "Pending";
			} else {
				$paymentStatus = "Completed";
			}
				
			$Ref = $counter;				
			$Receipt = $memberReceiptFormat1."/".$Ref; 			

			$this->db->select()->from('DEITY_SEVA')->where(array('SEVA_ID'=>$sevaId[$i]));
			$query = $this->db->get();
			$deitySeva = $query->first_row();
			$sevaType = $deitySeva->SEVA_TYPE;
			
			$sevaData = array(
				'SM_ID'  =>$smId,
				'SS_REF' =>$counter2,
				'SS_RECEIPT_NO' =>$ss_receipt_no[$i],
				'SS_RECEIPT_DATE' =>$todayDate,
				'DEITY_ID' =>$deityId[$i],
				'SEVA_ID' =>$sevaId[$i],
				'SEVA_QTY' => $sevaQty[$i],
				'THITHI_CODE'=>$thithi[$i],
				'ENG_DATE' =>$date[$i],
				'SEVA_TYPE' => $sevaType,
				'CAL_TYPE' => $calType[$i],
				 'MASA'	   => $masa[$i],
				'BASED_ON_MOON'=>$bomcode[$i],
				'THITHI_NAME' =>$thithiName[$i], 
				'SP_ID'   => $periodId[$i],
				'SEVA_NOTES' => $sevaNotes[$i],
				'SP_COUNTER' => 0,
				'SS_STATUS'  => 1,
				'SS_VERIFICATION' => ((isset($_SESSION['Authorise']))?1:0),
				'SS_VERIFICATION_BY_ID' => ((isset($_SESSION['Authorise']))?$_SESSION['userId']:0),
				'SS_VERIFICATION_DATE_TIME' => ((isset($_SESSION['Authorise']))?date('d-m-Y H:i:s A'):""),
				'SS_VERIFICATION_DATE' => ((isset($_SESSION['Authorise']))?date('d-m-Y'):""),
				'SS_ENTERED_BY_ID' => $_SESSION['userId'],
				'SS_ENTERED_DATE_TIME'=>date('d-m-Y H:i:s A'),
				'SS_ENTERED_DATE' =>date('d-m-Y'),
				'EVERY_WEEK_MONTH' => $weekcode[$i],
				'NO_OF_SEVAS' => $countNOS,
				'SEVA_GEN_COUNTER' => $countNOS

			);
			$this->db->insert('shashwath_seva', $sevaData); 
			$SS_ID = $this->db->insert_id();
			
			//Receipt Number
			if(strtotime($todayDate) > strtotime($financeBookBeginDate)) {
				$receiptData = array(
					'SS_ID'   =>$SS_ID,
					'RECEIPT_NAME'=>$name,
					'RECEIPT_NO'=>$Receipt,
					'RECEIPT_DATE'=>$todayDate,
					'RECEIPT_PHONE'=>$number,
					'RECEIPT_PRICE'    => $corpus[$i],
					'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,
					'BRANCH_NAME'=>$branch,
					'CHEQUE_NO'=>$chequeNo,
					'BANK_NAME'=>$bank,
					'CHEQUE_DATE'=>$chequeDate,
					'TRANSACTION_ID'=>$transactionId,
					'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,
					'RECEIPT_RASHI'=>$rashi,
					'RECEIPT_NAKSHATRA'=>$nakshatra,
					'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
					'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
					'DATE_TIME' => $dateTime,
					'RECEIPT_ACTIVE'=>1,
					'RECEIPT_CATEGORY_ID'=>7,
					'PAYMENT_STATUS'=>$paymentStatus,
					'AUTHORISED_STATUS'=>'No',	
					
					'DATE_TYPE'=>$date_type,
					'RECEIPT_ADDRESS' => $sm_address,
					'POSTAGE_CHECK' => (($postage[$i] == "YES")?1:0),
					'POSTAGE_GROUP_ID' => 1,
					'ADDRESS_LINE1' => strtoupper($addressLine1[$i]),
					'ADDRESS_LINE2' => strtoupper($addressLine2[$i]),
					'CITY' => strtoupper($city[$i]),
					'STATE' => strtoupper($state[$i]),
					'COUNTRY' => strtoupper($country[$i]),
					'PINCODE' => $pincode[$i],
					'FGLH_ID' => $fglhBank,							//laz new ..
					'SS_RECEIPT_NO_REF' =>$ss_receipt_no[$i] 
				);
			}else{
				$receiptData = array(
					'SS_ID'   =>$SS_ID,
					'RECEIPT_NAME'=>$name,
					'RECEIPT_NO'=>$Receipt,
					'RECEIPT_DATE'=>$todayDate,
					'RECEIPT_PHONE'=>$number,
					'RECEIPT_PRICE'    => $corpus[$i],
					'RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,
					'BRANCH_NAME'=>$branch,
					'CHEQUE_NO'=>$chequeNo,
					'BANK_NAME'=>$bank,
					'CHEQUE_DATE'=>$chequeDate,
					'TRANSACTION_ID'=>$transactionId,
					'RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,
					'RECEIPT_RASHI'=>$rashi,
					'RECEIPT_NAKSHATRA'=>$nakshatra,
					'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
					'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
					'DATE_TIME' => $dateTime,
					'RECEIPT_ACTIVE'=>1,
					'RECEIPT_CATEGORY_ID'=>7,
					'PAYMENT_STATUS'=>$paymentStatus,
					'AUTHORISED_STATUS'=> (($_SESSION['Authorise'] == "Auth_Right")?'Yes':'No'),
					'AUTHORISED_BY' => (($_SESSION['Authorise'] == "Auth_Right")?$_SESSION['userId']:0),
					'AUTHORISED_BY_NAME' => (($_SESSION['Authorise'] == "Auth_Right")?$_SESSION['userFullName']:""),
					'AUTHORISED_DATE_TIME' => (($_SESSION['Authorise'] == "Auth_Right")?date('d-m-Y H:i:s A'):""),
					'AUTHORISED_DATE' => (($_SESSION['Authorise'] == "Auth_Right")?date('d-m-Y'):""),
					'EOD_CONFIRMED_BY_ID' => (($_SESSION['Authorise'] == "Auth_Right")?$_SESSION['userId']:0),
					'EOD_CONFIRMED_BY_NAME' => (($_SESSION['Authorise'] == "Auth_Right")?$_SESSION['userFullName']:""),
					'EOD_CONFIRMED_DATE_TIME' => (($_SESSION['Authorise'] == "Auth_Right")?date('d-m-Y H:i:s A'):""),
					'EOD_CONFIRMED_DATE' => (($_SESSION['Authorise'] == "Auth_Right")?date('d-m-Y'):""),
					'DATE_TYPE'=>$date_type,
					'RECEIPT_ADDRESS' => $sm_address,
					'POSTAGE_CHECK' => (($postage[$i] == "YES")?1:0),
					'POSTAGE_GROUP_ID' => 1,
					'ADDRESS_LINE1' => strtoupper($addressLine1[$i]),
					'ADDRESS_LINE2' => strtoupper($addressLine2[$i]),
					'CITY' => strtoupper($city[$i]),
					'STATE' => strtoupper($state[$i]),
					'COUNTRY' => strtoupper($country[$i]),
					'PINCODE' => $pincode[$i],
					'FGLH_ID' => $fglhBank,						//laz new ..
					'SS_RECEIPT_NO_REF' =>$ss_receipt_no[$i] 
				);
			}
					
			$this->db->insert('DEITY_RECEIPT', $receiptData);
			$SHASHWATH_RECEIPT = $this->db->insert_id();
			
			if($postage == 1) {
				$dataPostage = array(
								'RECEIPT_ID' => $SHASHWATH_RECEIPT,
								'POSTAGE_CATEGORY' => 1,
								'POSTAGE_STATUS' => 0,
								'DATE_TIME' => date('d-m-Y H:i:s A'),
								'DATE' => date('d-m-Y'));
				$this->db->insert('POSTAGE', $dataPostage);
			} 
		}
		if(isset($_SESSION['Authorise'])) {
			if($_SESSION['Authorise'] == 'Auth_Right') {
				$dataSSID = array('SM_ID' => $smId,
					 			  'SS_VERIFICATION' => 0);

				$this->db->select('SS_ID');
				$this->db->from('SHASHWATH_SEVA');
				$this->db->where($dataSSID);
				
				$query = $this->db->get();
				if ($query->num_rows() > 0) {
					foreach($query->result() as $ShashSeva) {
						$data = array (		
							'SS_VERIFICATION' => 1,
							'SS_VERIFICATION_BY_ID' => $_SESSION['userId'],
							'SS_VERIFICATION_DATE_TIME' => date('d-m-Y H:i:s A'),
							'SS_VERIFICATION_DATE' => date('d-m-Y')
						);

						$this->db->where('SS_ID',$ShashSeva->SS_ID);
						$this->db->update('shashwath_seva',$data);	
					}
				}

				
			}
		}
		$this->db->select()->from('finance_voucher_counter')
		->where(array('finance_voucher_counter.FVC_ID'=>'5'));
		$query = $this->db->get();
		$deityCounter = $query->first_row();
		$counter = $deityCounter->FVC_COUNTER+1;
		
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$countNoJ = $deityCounter->FVC_ABBR1 ."/".$datMonth."/".$deityCounter->FVC_ABBR2."/".$counter;
		$naration = str_replace("'","\'",@$_POST['naration']);
		$type = json_decode(@$_POST['type']);
		$ledgers = json_decode(@$_POST['ledgers']);
		$amount = json_decode(@$_POST['amount']);
		$tDateJ =date('d-m-Y');
		$user= $_SESSION['userId'];
		$corpustot =  @$_POST['corpustot'];
		for($i = 0; $i < count($amount); ++$i) {
			$lidJ = $ledgers[$i];
			if($type[$i]=="from") {
				$firstAmt = $amount[$i];
				$secondAmt = 0;
				$rptype = "J1";
				$this->obj_finance->putJournalTransfer($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$user,$rptype,$SHASHWATH_RECEIPT);
			 } 
		}
		$lidJ = 25;
		$firstAmt = 0;
		$secondAmt = $corpustot;
		$rptype = "J2";
		$this->obj_finance->putJournalTransfer($lidJ,$countNoJ,$firstAmt,$secondAmt,$tDateJ,$dateTime,$naration,$user,$rptype,$SHASHWATH_RECEIPT);

		$this->db->where('finance_voucher_counter.FVC_ID',5);
		$this->db->update('finance_voucher_counter', array('FVC_COUNTER'=>$counter));
		
		echo "success";
		$_SESSION['Receipt'] = $Receipt; 
	}
	
	public function saveDeityPrintHistory() {
		$receiptId = @$_POST['receiptId'];
		$printstatus = $this->input->post('printStatus');
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		
		if(isset($_POST['ShashwathReceiptId'])) {
			$ShashwathReceiptId = $this->input->post('ShashwathReceiptId');
			for($i=0;$i<count(explode(',',$ShashwathReceiptId));$i++) {
				$data2 = array(
					'PRINT_STATUS' => 1
				);
		
				$where = array('RECEIPT_ID' => explode(',',$ShashwathReceiptId)[$i]);
				$this->db->where($where);
				$this->db->update('DEITY_RECEIPT',$data2);
		
				$dataInsert = array(
					'RECEIPT_ID' => explode(',',$ShashwathReceiptId)[$i],
					'DATE_TIME'=>$dateTime,
					'USER_ID'=>$_SESSION['userId'],
					'DATE'=>$todayDate
				);
		
				$this->db->insert('DEITY_PRINT_HISTORY', $dataInsert);
				$insertId = $this->db->insert_id();
			}
		} else {		
			$data2 = array(
			'PRINT_STATUS' => $printstatus
			);
			
			$where = array('RECEIPT_ID' => $receiptId);
			$this->db->where($where);
			$this->db->update('DEITY_RECEIPT',$data2);
			
			$dataInsert = array(
				'RECEIPT_ID' => $receiptId,
				'DATE_TIME'=>$dateTime,
				'USER_ID'=>$_SESSION['userId'],
				'DATE'=>$todayDate
			);
			
			$this->db->insert('DEITY_PRINT_HISTORY', $dataInsert);
			$insertId = $this->db->insert_id();
		}
	}
	
	public function printDeityReceipt($receiptNo = "") {
		$data['whichTab'] = "receipt";
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		
		if(isset($_POST['receiptFormat2'])) {
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_POST['receiptFormat2'];
			$receiptId = $_POST['deityReceiptId'];
			$this->db->select()->from('DEITY_RECEIPT')
			->join('DEITY_SEVA_OFFERED', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID')
			->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId))->order_by("SO_ID", "asc");

		} else if(isset($_SESSION['receiptFormat'])) {//Seva Booking
			$receiptNo = $_SESSION['receiptFormat'];
			$receiptId = $_SESSION['deityReceiptId'];
			unset($_SESSION['receiptFormat']);
			unset($_SESSION['deityReceiptId']);

			$this->db->select()->from('DEITY_RECEIPT')
			->join('DEITY_SEVA_OFFERED', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID')
			->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId))->order_by("SO_ID", "asc");

		} else if(isset($_POST['receiptNo'])) {
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_POST['receiptNo'];

			$this->db->select()->from('DEITY_RECEIPT')
			->join('DEITY_SEVA_OFFERED', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID')
			->where(array('DEITY_RECEIPT.RECEIPT_NO'=>$receiptNo))->order_by("SO_ID", "asc");

		}else if(isset($_SESSION['recFor'])) { 
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_SESSION['recFor'];
			unset($_SESSION['recFor']);

			$this->db->select()->from('DEITY_RECEIPT')
			->join('DEITY_SEVA_OFFERED', 'DEITY_SEVA_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID')
			->where(array('DEITY_RECEIPT.RECEIPT_NO'=>$receiptNo))->order_by("SO_ID", "asc");

		} else redirect('Receipt/all_receipt_deity');

		$query = $this->db->get();
		$data['deityCounter'] = $query->result("array");
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();

		$this->load->view('header',$data);
		$this->load->view('printDeityReceipt');
		$this->load->view('footer_home');
	}
	
	public function save_cancel_note_event() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],                         
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'ET_RECEIPT_ACTIVE' => 0);
		
		$this->db->where('ET_RECEIPT_ID',$rId);
		$this->db->update('EVENT_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptFormat'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Events/printSevaReceipt');
	}
	
	public function save_cancel_note_event_hundi() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'ET_RECEIPT_ACTIVE' => 0);
		
		$this->db->where('ET_RECEIPT_ID',$rId);
		$this->db->update('EVENT_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptFormat'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Receipt/receipt_hundiPrint');
	}
	
	public function save_cancel_note_event_donation() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'ET_RECEIPT_ACTIVE' => 0);
		
		$this->db->where('ET_RECEIPT_ID',$rId);
		$this->db->update('EVENT_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptFormat'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Receipt/receipt_donationPrint');
	}
	
	public function save_cancel_note_event_inkind() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'ET_RECEIPT_ACTIVE' => 0);
		
		$this->db->where('ET_RECEIPT_ID',$rId);
		$this->db->update('EVENT_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptFormat'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Receipt/receipt_inkindPrint');
	}
	
	public function save_cancel_note() {		
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];

		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'RECEIPT_ACTIVE' => 0);
		$this->db->where('RECEIPT_ID',$rId);
		$this->db->update('DEITY_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		redirect('Receipt/printDeityReceipt');
	}
	public function shashwath_cancel_note() {		
		$rId = @$_POST['rId'];
		$rNo = @$_POST['rNo'];
		$cNote = @$_POST['cNote'];
		$smId = @$_POST['smId'];

		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'RECEIPT_ACTIVE' => 0);
		$this->db->where('RECEIPT_ID',$rId);
		$this->db->update('DEITY_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['sm_id'] = $smId; 
		redirect('Receipt/shashwathReceipt');
	}
	
	public function shashwath_Daybook_cancel_note() {		
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		$smId = $_POST['smId'];

		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'RECEIPT_ACTIVE' => 0);
		$this->db->where('RECEIPT_ID',$rId);
		$this->db->update('DEITY_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['sm_id'] = $smId; 
		$_SESSION['receiptId'] = $_POST['rId'];
		redirect('Receipt/receipt_ShaswathPrint');
	}
	
	public function save_cancel_note_booking() {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link3'] = $actual_link;
		
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('SB_DEACTIVE_NOTES'=>$cNote,
							'SB_DEACTIVE_BY_ID'=> $_SESSION['userId'],
							'SB_DEACTIVE_BY'=> $_SESSION['userFullName'],
							'DEACTIVE_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'DEACTIVE_DATE'=> date('d-m-Y'),
							'SB_PAYMENT_STATUS' => 3,
							'SB_ACTIVE' => 0);
		
		$this->db->where('SB_ID',$rId);
		$this->db->update('SEVA_BOOKING', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('SevaBooking');
	}
	
	public function save_cancel_note_donation() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'RECEIPT_ACTIVE' => 0);
		
		$this->db->where('RECEIPT_ID',$rId);
		$this->db->update('DEITY_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Receipt/receipt_donationDeityPrint');
	}
	
	public function save_cancel_note_jeernodhara_kanike() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'RECEIPT_ACTIVE' => 0);
		
		$this->db->where('RECEIPT_ID',$rId);
		$this->db->update('DEITY_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Receipt/jeernodhara_kanikePrint');
	}
	
	public function save_cancel_note_kanike() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'RECEIPT_ACTIVE' => 0);
		
		$this->db->where('RECEIPT_ID',$rId);
		$this->db->update('DEITY_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Receipt/receipt_donationKanikePrint');
	}
	
	public function save_cancel_note_jeernodhara_hundi() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'RECEIPT_ACTIVE' => 0);
		
		$this->db->where('RECEIPT_ID',$rId);
		$this->db->update('DEITY_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Receipt/jeernodhara_hundiPrint');
	}
	
	public function save_cancel_note_hundi() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'RECEIPT_ACTIVE' => 0);
		
		$this->db->where('RECEIPT_ID',$rId);
		$this->db->update('DEITY_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Receipt/receipt_hundiPrint');
	}
	
	public function save_cancel_note_inkind() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'RECEIPT_ACTIVE' => 0);
		
		$this->db->where('RECEIPT_ID',$rId);
		$this->db->update('DEITY_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Receipt/receipt_inkindPrint');
	}
	
	public function save_cancel_note_srns() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'RECEIPT_ACTIVE' => 0);
		
		$this->db->where('RECEIPT_ID',$rId);
		$this->db->update('DEITY_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('Receipt/receipt_SRNSDeityPrint');
	}
	public function check_eod_confirm_time(){
		$todayDate = date('d-m-Y');
		$this->db->select('EOD_CONFIRMED_DATE_TIME')->from('DEITY_RECEIPT');
		$this->db->where('RECEIPT_DATE',$todayDate);
		$this->db->where('RECEIPT_ACTIVE',1);
		$query = $this->db->get();
		$rowResult = $query->result();
		$data = '';
		if(!empty($rowResult)){
		if($rowResult[0]->EOD_CONFIRMED_DATE_TIME == ''){
			$data = 0;
		} else {
			$data = 1;
		}
		} else {
			$data = 0;
		}
		print_r($data);
	}
}
