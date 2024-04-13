<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trust extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model','user',true);
		$this->load->model('TrustReceipt_modal','booking',true);
		$this->load->model('Events_modal','obj_events',true);		
		$this->load->model('Deity_model','obj_sevas',true); 
		$this->load->model('Receipt_modal','obj_receipt',true);	
		$this->load->model('Booking_model','obj_booking',true);	
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		$this->load->model('Shashwath_Model','obj_shashwath',true);	
		$this->load->model('TrustReceipt_modal','trust_receipt_modal',true);  //added by adithya on 5-1-24

		if(!isset($_SESSION['userId']))
			redirect('login');
		
		if($_SESSION['trustLogin'] != 1)
			redirect('login');

		$this->db->select()->from('TRUST_EVENT')->where("TET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
		//$this->output->enable_profiler(true);
	}
	
	function homePageTrust() {		
		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer_home');
	}
	
	//CHECK FOR IS DONE IN HALL BOOKING LIST
	function check_is_done_hall_booking_list() {
		$HBID = $_POST['HB_ID'];	
		$sql = "SELECT * FROM TRUST_HALL_BOOKING_LIST WHERE HB_ID = ".$HBID." ORDER BY IS_DONE DESC";
		$query = $this->db->query($sql);
		$res = $query->result('array');
		$count = 0;
		
		for($i = 0; $i < count($res); $i++) {
			if($res[$i]['IS_DONE'] == "0" || $res[$i]['IS_DONE'] == "1" || $res[$i]['IS_DONE'] != ""|| $res[$i]['IS_DONE'] == NULL ) { //  ADDED $res[$i]['IS_DONE'] == "null" by adithya on 05-01-2024
				$count = 1;
			} else {
				$count = 0;
			}
		}
		
		if($count > 0) {
			echo "success";
		} else {
			echo "failed";
		}
	}
	
	function deactivateEditBooking() {
		$id = $_POST['HBL_ID'];
		$cancelReason = $_POST['cancelReason'];
		$where = array("HBL_ID"=>$id);
		// $this->output->enable_profiler(true);
		$TRUST_BLOCK_DATE_TIME = array(
			'TBDT_ACTIVE'=>'0'
		);

		$this->db->where($where);
		$this->db->update("TRUST_BLOCK_DATE_TIME",$TRUST_BLOCK_DATE_TIME);

		$TRUST_HALL_BOOKING_LIST = array(
			'HBL_ACTIVE'=>'0',
			'FN_CANCEL_NOTES'=>$cancelReason,
			'CANCELLED_BY_ID'=>$_SESSION['userId'],
			'CANCELLED_BY'=>$_SESSION['userFullName'],
			'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
			'CANCELLED_DATE'=>date('d-m-Y')
		);
		$where = array("HBL_ID"=>$id);
		$this->db->where($where);
		$this->db->update("TRUST_HALL_BOOKING_LIST",$TRUST_HALL_BOOKING_LIST);
	}

	public function index($start = 0) {
		
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
								
		//Radio Option
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
		$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		$data['name_phone'] = '';
		
		//Unset Session
		unset($_SESSION['date']);
		unset($_SESSION['name_phone']);
		unset($_SESSION['reload']);//this line is neccessary do not remove this
		
		$data['whichTab'] = "hallBooking";
		$data['date'] = date("d-m-Y");
		
		$condition = "where TRUST_HALL_BOOKING_LIST.HBL_ACTIVE='1' and TRUST_HALL_BOOKING.HB_ACTIVE='1' and HB_BOOK_DATE = '" .date("d-m-Y"). "'";

		$data['hallBooking'] = $this->obj_booking->get_all_bookingRawQuery($condition,"TRUST_HALL_BOOKING.HB_ID","DESC", 10, $start);

		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'Trust/index';
		$config['total_rows'] = $this->obj_booking->get_all_bookingRawQueryCount($condition);
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
				
		if(isset($_SESSION['All_Hall_Bookings'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/index');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function bookHall() {
		//For Menu Selection
		$data['whichTab'] = "hallBooking";

		$condition = (" IS_TERMINAL = 1");				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);

		$data['bank_trust']= $this->trust_receipt_modal->get_banks();
		$condition = ("T_IS_TERMINAL = 1");					
		$data['terminal_trust'] = $this->trust_receipt_modal->getCardBanks($condition);	 
		
		// // adding the new code for temple and trust both by adithya on 11-1-24 end
		$condition = ["HALL_ACTIVE"=>"1"];
		$data['hall'] = $this->obj_admin_settings->get_all_field_hall_details($condition);
		
		// $this->output->enable_profiler(true);
		$data['fun'] = $this->db->get("FUNCTION")->result();
		
		$query = $this->db->where("TBDT_ACTIVE","1")->get("TRUST_BLOCK_DATE_TIME");
		$data['TRUST_BLOCK_DATE_TIME'] = json_encode($query->result_array());
		$data['sevas'] = json_encode($this->obj_receipt->getDetiesSevasBooking()); 
		
		$this->load->view('header', $data);
		$this->load->view('trust/bookHall');
		$this->load->view('footer_home');
	}

	function hallBookingSave() {
		
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$pymtType = $_POST['pymtType'];
		$pan = $_POST['pan'];
		$adhaar = $_POST['adhaar'];

		$hellComboId = json_decode($_POST['hellComboId']);
		$hallComboName = json_decode($_POST['hallComboName']);

		$funComboId = json_decode($_POST['funComboId']);
		$funComboName = json_decode($_POST['funComboName']);

		$timepickerFrom = json_decode($_POST['timepickerFrom']);
		$timepickerTo = json_decode($_POST['timepickerTo']);
		$date = json_decode($_POST['date']);

		$idTempleHeads = json_decode($_POST['idTempleHeads']);
		// var_dump($idTempleHeads);
		// return;
		$nameTempleHeads = json_decode($_POST['nameTempleHeads']);
		$amtTemple = json_decode($_POST['amtTemple']);
		$branchTemple = json_decode($_POST['branchTemple']);
		$modeOfPaymentTemple = json_decode($_POST['modeOfPaymentTemple']);
		$chequeNoTemple = json_decode($_POST['chequeNoTemple']);
		$bankTemple = json_decode($_POST['bankTemple']);
		$transactionIdTemple = json_decode($_POST['transactionIdTemple']);
		$chequeDateTemple = json_decode($_POST['chequeDateTemple']);
		$pymtNotesTemple = json_decode($_POST['pymtNotesTemple']);
		$fglhBankTemple = json_decode($_POST['fglhBankTemple']);				//laz

		$idTrustHeads = json_decode($_POST['idTrustHeads']);
		$nameTrustHeads = json_decode($_POST['nameTrustHeads']);
		$amtTrust = json_decode($_POST['amtTrust']);
		$transactionIdTrust = json_decode($_POST['transactionIdTrust']);
		$branchTrust = json_decode($_POST['branchTrust']);
		$modeOfPaymentTrust = json_decode($_POST['modeOfPaymentTrust']);
		$chequeNoTrust = json_decode($_POST['chequeNoTrust']);
		$chequeDateTrust = json_decode($_POST['chequeDateTrust']);
		$bankTrust = json_decode($_POST['bankTrust']);
		$pymtNotesTrust = json_decode($_POST['pymtNotesTrust']);
		$fglhBankTrust = json_decode($_POST['fglhBankTrust']);

		$todayDate = date('Y-m-d');
		$todayDateTime = date('Y-m-d H:i:s A');

		$todayDateDMY = date('d-m-Y');
		$todayDateTimeDMY = date('d-m-Y H:i:s A');

		$HB_PAYMENT_STATUS = "";

		if($pymtType == "noPayment") {
			$HB_PAYMENT_STATUS = 0;
			$_SESSION['PAYMENT_STATUS'] = "noPayment" ;
		}else {
			$HB_PAYMENT_STATUS = 1;
		}

		//TRUST_HALL_BOOKING saving name phone and address
		$SQL = "select * from TRUST_BOOKING_COUNTER";
		$query = $this->db->query($SQL);
		$TRUSTBOOKINGCOUNTER = $query->first_row();

				$counter = (int)$TRUSTBOOKINGCOUNTER->BOOKING_COUNTER;
				$counter++;

				$receiptFormat = $TRUSTBOOKINGCOUNTER->ABBR1 ."/".$TRUSTBOOKINGCOUNTER->ABBR2."/".$counter;

				$TRUST_BOOKING_COUNTER = array(
					"BOOKING_COUNTER" => $counter
				);

				$where = array(
					"COUNTER_ID"=>$TRUSTBOOKINGCOUNTER->COUNTER_ID
				);

				$this->db->where($where);
				$this->db->update("TRUST_BOOKING_COUNTER", $TRUST_BOOKING_COUNTER);

		$TRUST_HALL_BOOKING = array(
			'HB_DATE' => $todayDate,
			'HB_NAME'=>$name,
			'HB_NO'=>$receiptFormat,
			'HB_NUMBER'=>$phone,
			'HB_ADDRESS'=>$address,
			'HB_PAYMENT_STATUS'=>$HB_PAYMENT_STATUS,
			'HB_ACTIVE'=>1,
			'HB_NOTES'=>"",
			'ENTERED_BY'=>$_SESSION['userId'],
			'ENTERED_BY_NAME'=>$_SESSION['userFullName'],
			'DATE'=>$todayDate
		);
		
		$this->db->insert('TRUST_HALL_BOOKING', $TRUST_HALL_BOOKING);
		$TRUST_HALL_BOOKING_ID = $this->db->insert_id();

		$_SESSION['TRUST_HALL_BOOKING_ID'] = $TRUST_HALL_BOOKING_ID;

		//TRUST_HALL_BOOKING_LIST saving hall booking table
		for($i = 0; $i < count($hellComboId); ++$i) {

			$TRUST_HALL_BOOKING_LIST = array(
				'H_ID' => $hellComboId[$i],
				'H_NAME'=>$hallComboName[$i],
				'HB_ID'=>$TRUST_HALL_BOOKING_ID,
				'HB_BOOK_DATE'=>$date[$i],
				'HB_BOOK_TIME_FROM'=>$timepickerFrom[$i],
				'HB_BOOK_TIME_TO'=>$timepickerTo[$i],
				'HBL_ACTIVE'=>1,
				'ENTERED_BY'=>$_SESSION['userId'],
				'ENTERED_BY_NAME'=>$_SESSION['userFullName'],
				'DATE'=>$todayDate,
				'FN_TYPE' => $funComboId[$i]
			);
			
			$this->db->insert('TRUST_HALL_BOOKING_LIST', $TRUST_HALL_BOOKING_LIST);
			$TRUST_HALL_BOOKING_LIST_ID = $this->db->insert_id();

			//TRUST_BLOCK_DATE_TIME
			$TRUST_BLOCK_DATE_TIME = array(
				'H_ID' => $hellComboId[$i],
				'TBDT_DATE'=>$date[$i],
				'HBL_ID'=>$TRUST_HALL_BOOKING_LIST_ID,
				'TBDT_FROM_TIME'=>$timepickerFrom[$i],
				'TBDT_TO_TIME'=>$timepickerTo[$i],
				'TBDT_NOTES'=>"",                                                                  
				'TBDT_ACTIVE'=>1,                                                                  
				'TBDT_BY_ID'=>$_SESSION['userId'],
				'TBDT_BY_NAME'=>$_SESSION['userFullName'],
				'DATE'=>$todayDateDMY,
				'DATE_TIME'=>$todayDateTimeDMY
			);
			
			$this->db->insert('TRUST_BLOCK_DATE_TIME', $TRUST_BLOCK_DATE_TIME);
			$TRUST_BLOCK_DATE_TIME_ID = $this->db->insert_id();
		}

			//temple
			if($pymtType != "noPayment") {
				for($j = 0; $j < count($idTempleHeads); ++$j) {
				
				$id = $idTempleHeads[$j];
				$where = " DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = '".$id."'";
				$SQL = "select * from DEITY_RECEIPT_CATEGORY join DEITY_RECEIPT_COUNTER on DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID = DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID where".$where." group by DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID";
				
				$PAYMENT_STATUS = "";

				if($modeOfPaymentTemple[$j] == "Cheque") {
					$PAYMENT_STATUS = "Pending";
				}else {
					$PAYMENT_STATUS = "Completed";
				}
				
				$dfMonth = $this->obj_admin_settings->get_financial_month();
				$datMonth = $this->get_financial_year($dfMonth);
				
				$query = $this->db->query($SQL);
				$deityCounter = $query->first_row();

				$counter = (int)$deityCounter->RECEIPT_COUNTER;
				$counter++;

				$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
				$_SESSION['receiptFormat'] = $receiptFormat;

				$DEITY_RECEIPT_COUNTER = array(
					"RECEIPT_COUNTER" => $counter
				);

				$where = array(
					"RECEIPT_COUNTER_ID"=>$deityCounter->RECEIPT_COUNTER_ID
				);

				$this->db->where($where);
				$this->db->update("DEITY_RECEIPT_COUNTER", $DEITY_RECEIPT_COUNTER);

				$query = $this->db->from("DEITY")->where("DEITY_ID","1")->get();
				$res = $query->first_row();
				if($id == 3){
					$kanike_for = 1;
				}else{
					$kanike_for = 0;
				}

				$DEITY_RECEIPT = array(
					'RECEIPT_NO' => $receiptFormat,
					'RECEIPT_DATE'=>$todayDateDMY,
					'RECEIPT_NAME'=>$name,
					'RECEIPT_PHONE'=>$phone,
					'RECEIPT_ADDRESS'=>$address,
					'RECEIPT_DEITY_NAME'=>$res->DEITY_NAME,
					'RECEIPT_DEITY_ID'=>"1",
					'RECEIPT_PRICE'=>$amtTemple[$j],
					'RECEIPT_PAYMENT_METHOD'=>$modeOfPaymentTemple[$j],
					'CHEQUE_DATE'=>$chequeDateTemple[$j],
					'CHEQUE_NO'=>$chequeNoTemple[$j],
					'BANK_NAME'=>$bankTemple[$j],
					'BRANCH_NAME'=>$branchTemple[$j],
					'TRANSACTION_ID'=>$transactionIdTemple[$j],
					'RECEIPT_PAYMENT_METHOD_NOTES'=>$pymtNotesTemple[$j],
					'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
					'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
					'RECEIPT_ACTIVE'=>1,
					'DATE_TIME'=>$todayDateTimeDMY,
					'RECEIPT_CATEGORY_ID'=>$idTempleHeads[$j],
					'PAYMENT_STATUS'=>$PAYMENT_STATUS,
					'AUTHORISED_STATUS'=>"No",
					'EOD_CONFIRMED_BY_ID'=>0,
					'IS_TRUST'=>1,
					'RECEIPT_HB_ID'=>$TRUST_HALL_BOOKING_ID,
					'FGLH_ID' => $fglhBankTemple[$j],
					'KANIKE_FOR' => $kanike_for	,
					'RECEIPT_PAN_NO'=>$pan,
					'RECEIPT_ADHAAR_NO'=>$adhaar							//laz new ..
				);
				
				$this->db->insert('DEITY_RECEIPT', $DEITY_RECEIPT);
				$DEITY_RECEIPT_ID = $this->db->insert_id();
			}

			//trust
			for($k = 0; $k < count($idTrustHeads); ++$k) {
				$id = $idTrustHeads[$k];
				$where = " FINANCIAL_HEAD.FH_ID = '".$id."'";
				$SQL = "select * from FINANCIAL_HEAD join FINANCIAL_HEAD_COUNTER on FINANCIAL_HEAD_COUNTER.HEAD_COUNTER_ID = FINANCIAL_HEAD.FH_ACTIVE_HEAD_COUNTER_ID where".$where." group by FINANCIAL_HEAD.FH_ID";
				
				$PAYMENT_STATUS = "";

				if($modeOfPaymentTrust[$k] == "Cheque") {
					$PAYMENT_STATUS = "Pending";
				}else {
					$PAYMENT_STATUS = "Completed";
				}
				
				$dfMonth = $this->obj_admin_settings->get_financial_month();
				$datMonth = $this->get_financial_year($dfMonth);
				
				$query = $this->db->query($SQL);
				$deityCounter = $query->first_row();

				$counter = (int)$deityCounter->RECEIPT_COUNTER;
				$counter++;

				$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
				$_SESSION['receiptFormat'] = $receiptFormat;

				$FINANCIAL_HEAD_COUNTER = array(
					"RECEIPT_COUNTER" => $counter
				);

				$where = array(
					"HEAD_COUNTER_ID"=>$deityCounter->HEAD_COUNTER_ID
				);

				$this->db->where($where);
				$this->db->update("FINANCIAL_HEAD_COUNTER", $FINANCIAL_HEAD_COUNTER);

				$TRUST_RECEIPT = array(
					'TR_NO' => $receiptFormat,
					'RECEIPT_DATE'=>$todayDateDMY,
					'RECEIPT_NAME'=>$name,
					'RECEIPT_NUMBER'=>$phone,
					'RECEIPT_ADDRESS'=>$address,
					'RECEIPT_PAYMENT_METHOD'=>$modeOfPaymentTrust[$k],
					'CHEQUE_DATE'=>$chequeDateTrust[$k],
					'CHEQUE_NO'=>$chequeNoTrust[$k],
					'BANK_NAME'=>$bankTrust[$k],
					'BRANCH_NAME'=>$branchTrust[$k],
					'TRANSACTION_ID'=>$transactionIdTrust[$k],
					'PAYMENT_STATUS'=>$PAYMENT_STATUS,
					'TR_PAYMENT_METHOD_NOTES'=>$pymtNotesTrust[$k],
					'HB_ID'=>$TRUST_HALL_BOOKING_ID,
					'FH_ID'=>$idTrustHeads[$k],
					'FH_NAME'=>$nameTrustHeads[$k],
					// 'RECEIPT_CATEGORY_ID'=>$idTrustHeads[$k],
					'FH_AMOUNT'=>$amtTrust[$k],
					'TR_ACTIVE'=>1,
					'ENTERED_BY'=>$_SESSION['userId'],
					'ENTERED_BY_NAME'=>$_SESSION['userFullName'],
					'DATE'=>$todayDate,
					'DATE_TIME'=>$todayDateTimeDMY,
					'EOD_CONFIRMED_BY_ID'=>0,
					'AUTHORISED_STATUS'=>"No",//,
					'T_FGLH_ID' => $fglhBankTrust[$k],
					'RECEIPT_PAN_NO'=>$pan,
					'RECEIPT_ADHAAR_NO'=>$adhaar						//edited by adithya itwas in comment before
				);
				
				$this->db->insert('TRUST_RECEIPT', $TRUST_RECEIPT);
				$TRUST_RECEIPT_ID = $this->db->insert_id();
			}
		}
	}

	function editHallBookingSave() {
		$hellComboId = json_decode($_POST['hellComboId']);
		$hallComboName = json_decode($_POST['hallComboName']);

		$funComboId = json_decode($_POST['funComboId']);
		$funComboName = json_decode($_POST['funComboName']);

		$timepickerFrom = json_decode($_POST['timepickerFrom']);
		$timepickerTo = json_decode($_POST['timepickerTo']);
		$date = json_decode($_POST['date']);

		$todayDate = date('Y-m-d');
		$todayDateTime = date('Y-m-d H:i:s A');

		$todayDateDMY = date('d-m-Y');
		$todayDateTimeDMY = date('d-m-Y H:i:s A');
		
		$TRUST_HALL_BOOKING_ID = $_POST['HB_ID'];

		// $_SESSION['TRUST_HALL_BOOKING_ID'] = $TRUST_HALL_BOOKING_ID;

		//TRUST_HALL_BOOKING_LIST saving hall booking table
		for($i = 0; $i < count($hellComboId); ++$i) {

			$TRUST_HALL_BOOKING_LIST = array(
				'H_ID' => $hellComboId[$i],
				'H_NAME'=>$hallComboName[$i],
				'HB_ID'=>$TRUST_HALL_BOOKING_ID,
				'HB_BOOK_DATE'=>$date[$i],
				'HB_BOOK_TIME_FROM'=>$timepickerFrom[$i],
				'HB_BOOK_TIME_TO'=>$timepickerTo[$i],
				'HBL_ACTIVE'=>1,
				'ENTERED_BY'=>$_SESSION['userId'],
				'ENTERED_BY_NAME'=>$_SESSION['userFullName'],
				'DATE'=>$todayDate,
				'FN_TYPE' => $funComboId[$i]
			);
			
			$this->db->insert('TRUST_HALL_BOOKING_LIST', $TRUST_HALL_BOOKING_LIST);
			$TRUST_HALL_BOOKING_LIST_ID = $this->db->insert_id();

			//TRUST_BLOCK_DATE_TIME
			$TRUST_BLOCK_DATE_TIME = array(
				'H_ID' => $hellComboId[$i],
				'TBDT_DATE'=>$date[$i],
				'HBL_ID'=>$TRUST_HALL_BOOKING_LIST_ID,
				'TBDT_FROM_TIME'=>$timepickerFrom[$i],
				'TBDT_TO_TIME'=>$timepickerTo[$i],
				'TBDT_NOTES'=>"",
				'TBDT_ACTIVE'=>1,
				'TBDT_BY_ID'=>$_SESSION['userId'],
				'TBDT_BY_NAME'=>$_SESSION['userFullName'],
				'DATE'=>$todayDateDMY,
				'DATE_TIME'=>$todayDateTimeDMY
			);
			
			$this->db->insert('TRUST_BLOCK_DATE_TIME', $TRUST_BLOCK_DATE_TIME);
			$TRUST_BLOCK_DATE_TIME_ID = $this->db->insert_id();
		}
	}

	function addHeadsPrint() {
		$data['whichTab'] = "hallBooking";
		
		if(isset($_SESSION['reload'])) {
		 redirect('Trust/');
		}
		
		$DEITY_RECEIPT_arr = $_SESSION['DEITY_RECEIPT_arr'];
		$TRUST_RECEIPT_arr = $_SESSION['TRUST_RECEIPT_arr'];

		if(count($TRUST_RECEIPT_arr) > 0) {
			$where = " where (";
			for($i = 0; $i < count($TRUST_RECEIPT_arr); ++$i) {
				$where.="TR_ID=".$TRUST_RECEIPT_arr[$i]." or ";
				if($i == (count($TRUST_RECEIPT_arr)-1))
					$where.="TR_ID=".$TRUST_RECEIPT_arr[$i].")";
			}
			$sql = "select * from TRUST_RECEIPT ".$where;
			$query = $this->db->query($sql);
			$data['hallBookingTrust']  = $query->result("array");
		}else {
			$data['hallBookingTrust'] = [];
		}

		if(count($DEITY_RECEIPT_arr) > 0) {
			//temple
			$where = " where (";
			for($i = 0; $i < count($DEITY_RECEIPT_arr); ++$i) {
				$where.="RECEIPT_ID=".$DEITY_RECEIPT_arr[$i]." or ";
				if($i == (count($DEITY_RECEIPT_arr)-1))
					$where.="RECEIPT_ID=".$DEITY_RECEIPT_arr[$i].")";
			}
			$sql = "select * from DEITY_RECEIPT ".$where;
			$query = $this->db->query($sql);
			$data['hallBookingTemple']  = $query->result("array");
		}else {
			$data['hallBookingTemple'] = [];
		}

		$data['whichTab'] = "hallBooking";
		$id = @$_SESSION['TRUST_HALL_BOOKING_ID'];
		
		unset($_SESSION['TRUST_HALL_BOOKING_ID']);
		
		$condition = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id,
			"TRUST_HALL_BOOKING_LIST.HBL_ACTIVE"=>1
		);

		$conditionTrust = array(
		"TRUST_HALL_BOOKING.HB_ID" => $id,
			"TRUST_RECEIPT.TR_ACTIVE"=>1
		);

		$conditionTemple = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id,
			"DEITY_RECEIPT.RECEIPT_ACTIVE"=>1
		);
		
		$data['hallBooking'] = $this->obj_booking->get_all_booking($condition,"","");
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();	
		//$this->output->enable_profiler(true);  
		$this->session->set_userdata('reload',1);
		$this->load->view('header', $data);
		$this->load->view('trust/addHeadsPrint');
		$this->load->view('footer_home');
	}

	function addHallBookingSave() {
		$phone = $_POST["phone"];
		$name = $_POST["name"];
		$address = $_POST["address"];
		$TRUST_HALL_BOOKING_ID = $_POST['HB_ID'];
		$_SESSION['TRUST_HALL_BOOKING_ID'] = $TRUST_HALL_BOOKING_ID;
		$idTempleHeads = json_decode($_POST['idTempleHeads']);
		$nameTempleHeads = json_decode($_POST['nameTempleHeads']);
		$amtTemple = json_decode($_POST['amtTemple']);
		$branchTemple = json_decode($_POST['branchTemple']);
		$modeOfPaymentTemple = json_decode($_POST['modeOfPaymentTemple']);
		$chequeNoTemple = json_decode($_POST['chequeNoTemple']);
		$bankTemple = json_decode($_POST['bankTemple']);
		$transactionIdTemple = json_decode($_POST['transactionIdTemple']);
		$chequeDateTemple = json_decode($_POST['chequeDateTemple']);
		$pymtNotesTemple = json_decode($_POST['pymtNotesTemple']);
		$fglhBankTemple = json_decode($_POST['fglhBankTemple']);				//laz

		$idTrustHeads = json_decode($_POST['idTrustHeads']);
		$nameTrustHeads = json_decode($_POST['nameTrustHeads']);
		$amtTrust = json_decode($_POST['amtTrust']);
		$transactionIdTrust = json_decode($_POST['transactionIdTrust']);
		$branchTrust = json_decode($_POST['branchTrust']);
		$modeOfPaymentTrust = json_decode($_POST['modeOfPaymentTrust']);
		$chequeNoTrust = json_decode($_POST['chequeNoTrust']);
		$chequeDateTrust = json_decode($_POST['chequeDateTrust']);
		$bankTrust = json_decode($_POST['bankTrust']);
		$pymtNotesTrust = json_decode($_POST['pymtNotesTrust']);
		//$fglhBankTrust = json_decode($_POST['fglhBankTrust']);

		$todayDate = date('Y-m-d');
		$todayDateTime = date('Y-m-d H:i:s A');

		$todayDateDMY = date('d-m-Y');
		$todayDateTimeDMY = date('d-m-Y H:i:s A');

		$HB_PAYMENT_STATUS = 1;

		$TRUST_HALL_BOOKING = array(
			'HB_PAYMENT_STATUS'=>$HB_PAYMENT_STATUS
		);
		
		$this->db->where("TRUST_HALL_BOOKING.HB_ID",$TRUST_HALL_BOOKING_ID);
		$this->db->update('TRUST_HALL_BOOKING', $TRUST_HALL_BOOKING);

		$DEITY_RECEIPT_arr = [];

		for($j = 0; $j < count($idTempleHeads); ++$j) {
				
			$id = $idTempleHeads[$j];
			$where = " DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = '".$id."'";
			$SQL = "select * from DEITY_RECEIPT_CATEGORY join DEITY_RECEIPT_COUNTER on DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID = DEITY_RECEIPT_CATEGORY.ACTIVE_RECEIPT_COUNTER_ID where".$where." group by DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID";
			
			$PAYMENT_STATUS = "";

			if($modeOfPaymentTemple[$j] == "Cheque") {
				$PAYMENT_STATUS = "Pending";
			}else {
				$PAYMENT_STATUS = "Completed";
			}
			
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			
			$query = $this->db->query($SQL);
			$deityCounter = $query->first_row();

			$counter = (int)$deityCounter->RECEIPT_COUNTER;
			$counter++;

			$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
			$_SESSION['receiptFormat'] = $receiptFormat;

			$DEITY_RECEIPT_COUNTER = array(
				"RECEIPT_COUNTER" => $counter
			);

			$where = array(
				"RECEIPT_COUNTER_ID"=>$deityCounter->RECEIPT_COUNTER_ID
			);

			$this->db->where($where);
			$this->db->update("DEITY_RECEIPT_COUNTER", $DEITY_RECEIPT_COUNTER);

			$query = $this->db->from("DEITY")->where("DEITY_ID","1")->get();
			$res = $query->first_row();

			if($id == 3){
				$kanike_for = 1;
			}else{
				$kanike_for = 0;
			}

			$DEITY_RECEIPT = array(
				'RECEIPT_NO' => $receiptFormat,
				'RECEIPT_DATE'=>$todayDateDMY,
				'RECEIPT_NAME'=>$name,
				'RECEIPT_PHONE'=>$phone,
				'RECEIPT_ADDRESS'=>$address,
				'RECEIPT_DEITY_NAME'=>$res->DEITY_NAME,
				'RECEIPT_DEITY_ID'=>"1",
				'RECEIPT_PRICE'=>$amtTemple[$j],
				'RECEIPT_PAYMENT_METHOD'=>$modeOfPaymentTemple[$j],
				'CHEQUE_DATE'=>$chequeDateTemple[$j],
				'CHEQUE_NO'=>$chequeNoTemple[$j],
				'BANK_NAME'=>$bankTemple[$j],
				'BRANCH_NAME'=>$branchTemple[$j],
				'TRANSACTION_ID'=>$transactionIdTemple[$j],
				'RECEIPT_PAYMENT_METHOD_NOTES'=>$pymtNotesTemple[$j],
				'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'RECEIPT_ACTIVE'=>1,
				'DATE_TIME'=>$todayDateTimeDMY,
				'RECEIPT_CATEGORY_ID'=>$idTempleHeads[$j],
				'PAYMENT_STATUS'=>$PAYMENT_STATUS,
				'AUTHORISED_STATUS'=>"No",
				'IS_TRUST'=>1,
				'EOD_CONFIRMED_BY_ID'=>0,
				'RECEIPT_HB_ID'=>$TRUST_HALL_BOOKING_ID,
				'FGLH_ID' => $fglhBankTemple[$j],
				'KANIKE_FOR' => $kanike_for					
			);
			
			$this->db->insert('DEITY_RECEIPT', $DEITY_RECEIPT);
			$DEITY_RECEIPT_ID = $this->db->insert_id();

			array_push($DEITY_RECEIPT_arr, $DEITY_RECEIPT_ID);
		}

		$_SESSION['DEITY_RECEIPT_arr'] = $DEITY_RECEIPT_arr;

		//trust
		$TRUST_RECEIPT_arr = [];
		
		for($k = 0; $k < count($idTrustHeads); ++$k) {
			$id = $idTrustHeads[$k];
			$where = " FINANCIAL_HEAD.FH_ID = '".$id."'";
			$SQL = "select * from FINANCIAL_HEAD join FINANCIAL_HEAD_COUNTER on FINANCIAL_HEAD_COUNTER.HEAD_COUNTER_ID = FINANCIAL_HEAD.FH_ACTIVE_HEAD_COUNTER_ID where".$where." group by FINANCIAL_HEAD.FH_ID";
			
			$PAYMENT_STATUS = "";

			if($modeOfPaymentTrust[$k] == "Cheque") {
				$PAYMENT_STATUS = "Pending";
			}else {
				$PAYMENT_STATUS = "Completed";
			}
			
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			
			$query = $this->db->query($SQL);
			$deityCounter = $query->first_row();

			$counter = (int)$deityCounter->RECEIPT_COUNTER;
			$counter++;

			$receiptFormat = $deityCounter->ABBR1 ."/".$datMonth."/".$deityCounter->ABBR2."/".$counter;
			$_SESSION['receiptFormat'] = $receiptFormat;

			$FINANCIAL_HEAD_COUNTER = array(
				"RECEIPT_COUNTER" => $counter
			);

			$where = array(
				"HEAD_COUNTER_ID"=>$deityCounter->HEAD_COUNTER_ID
			);

			$this->db->where($where);
			$this->db->update("FINANCIAL_HEAD_COUNTER", $FINANCIAL_HEAD_COUNTER);

			$TRUST_RECEIPT = array(
				'TR_NO' => $receiptFormat,
				'RECEIPT_DATE'=>$todayDateDMY,
				'RECEIPT_NAME'=>$name,
				'RECEIPT_NUMBER'=>$phone,
				'RECEIPT_ADDRESS'=>$address,
				'RECEIPT_PAYMENT_METHOD'=>$modeOfPaymentTrust[$k],
				'CHEQUE_DATE'=>$chequeDateTrust[$k],
				'CHEQUE_NO'=>$chequeNoTrust[$k],
				'BANK_NAME'=>$bankTrust[$k],
				'BRANCH_NAME'=>$branchTrust[$k],
				'TRANSACTION_ID'=>$transactionIdTrust[$k],
				'PAYMENT_STATUS'=>$PAYMENT_STATUS,
				'TR_PAYMENT_METHOD_NOTES'=>$pymtNotesTrust[$k],
				'HB_ID'=>$TRUST_HALL_BOOKING_ID,
				'FH_ID'=>$idTrustHeads[$k],
				'FH_NAME'=>$nameTrustHeads[$k],
				'FH_AMOUNT'=>$amtTrust[$k],
				'TR_ACTIVE'=>1,
				'ENTERED_BY'=>$_SESSION['userId'],
				'ENTERED_BY_NAME'=>$_SESSION['userFullName'],
				'DATE'=>$todayDate,
				'DATE_TIME'=>$todayDateTimeDMY,
				'EOD_CONFIRMED_BY_ID'=>0,
				'AUTHORISED_STATUS'=>"No"//,
				// 'FGLH_ID' => $fglhBankTrust[$k]						//laz new ..
			);
			
			$this->db->insert('TRUST_RECEIPT', $TRUST_RECEIPT);
			$TRUST_RECEIPT_ID = $this->db->insert_id();
			array_push($TRUST_RECEIPT_arr, $TRUST_RECEIPT_ID);
		}

		$_SESSION['TRUST_RECEIPT_arr'] = $TRUST_RECEIPT_arr;
		
	}

	function ActivateBooking() {
		$id = $_POST["HB_ID"];
		$where = array("HB_ID"=>$id);
		$TRUST_HALL_BOOKING = array("HB_PAYMENT_STATUS"=>2);
		$this->db->where($where);
		$this->db->update("TRUST_HALL_BOOKING",$TRUST_HALL_BOOKING);
	}

	function DeleteBooking() {
		$id = $_POST["HB_ID"];
		$cancelNotes = $_POST["cancelNotes"];
		$where = array(
			"HB_ID"=>$id
		);

		$TRUST_HALL_BOOKING = array(
			"HB_PAYMENT_STATUS"=>3,
			"HB_ACTIVE"=>0,
			"CANCEL_NOTES"=>$cancelNotes,
			"CANCELLED_BY"=>$_SESSION['userFullName'],
			"CANCELLED_DATE_TIME"=>date("d-m-Y h:i:s"),
			"CANCELLED_DATE"=>date("d-m-Y"),
			"CANCELLED_BY_ID"=>$_SESSION['userId']
		);

		$this->db->where($where);
		$this->db->update("TRUST_HALL_BOOKING",$TRUST_HALL_BOOKING);

		//TRUST_HALL_BOOKING_LIST
		$where = array(
			"HB_ID"=>$id
		);

		$TRUST_HALL_BOOKING_LIST = array(
			"HBL_ACTIVE"=>0
		);

		$this->db->where($where);
		$this->db->update("TRUST_HALL_BOOKING_LIST",$TRUST_HALL_BOOKING_LIST);

		$sql = "select * from TRUST_HALL_BOOKING_LIST where HB_ID='".$id."'";
		$query = $this->db->query($sql);
		$TRUST_HALL_BOOKING_LIST = $query->result();

		foreach($TRUST_HALL_BOOKING_LIST as $res) {
			$id = $res->HBL_ID;

			$where = array(
				"HBL_ID"=>$id
			);
	
			$TRUST_BLOCK_DATE_TIME = array(
				"TBDT_ACTIVE"=>0
			);
	
			$this->db->where($where);
			$this->db->update("TRUST_BLOCK_DATE_TIME",$TRUST_BLOCK_DATE_TIME);
		}
	}

	


	function search_booking_receipt($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDate'])) {
				$fromDate = @$_POST['fromDate'];
				$toDate = @$_POST['toDate'];
				$_SESSION['fromDate'] = $fromDate;
				$_SESSION['toDate'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDate'];
				$toDate = $_SESSION['toDate'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			$data['whichTab'] = "hallBooking";
			if(@$_SESSION['date'] == "") { 
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['name_phone']) {
				unset($_SESSION['name_phone']);
				$data['name_phone'] = $this->input->post('name_phone');
				$name_phone = $this->input->post('name_phone');
			}
			
			if(@$_SESSION['name_phone'] == "") {
				$this->session->set_userdata('name_phone', $this->input->post('name_phone'));
				$data['name_phone'] = $_SESSION['name_phone'];
				$name_phone = $this->input->post('name_phone');
			} else {
				$name_phone = $_SESSION['name_phone'];
				$data['name_phone'] = $_SESSION['name_phone'];
			}

			$condition = "";
			
			if(@$_SESSION['radioOpt'] == "date") {
				if($_SESSION['name_phone']) {
					$name_phone = "%".$_SESSION['name_phone']."%";
					$condition = "where (HB_NAME like \"$name_phone\" or HB_NUMBER like \"$name_phone\") and TRUST_HALL_BOOKING_LIST.HBL_ACTIVE='1' and TRUST_HALL_BOOKING.HB_ACTIVE='1' and HB_BOOK_DATE = '" .$_SESSION["date"]. "'";
				} else {
					$condition = "where TRUST_HALL_BOOKING_LIST.HBL_ACTIVE='1' and TRUST_HALL_BOOKING.HB_ACTIVE='1' and HB_BOOK_DATE = '" .$_SESSION["date"]. "'";
				}
				
			} else {
				if($_SESSION['name_phone']) {
					$name_phone = "%".$_SESSION['name_phone']."%";
					$fromDate = date("Y-m-d",strtotime($_SESSION['fromDate']));
					$toDate = date("Y-m-d",strtotime($_SESSION['toDate']));
					$condition = "where (HB_NAME like \"$name_phone\" or HB_NUMBER like \"$name_phone\") and TRUST_HALL_BOOKING_LIST.HBL_ACTIVE='1' and TRUST_HALL_BOOKING.HB_ACTIVE='1' and STR_TO_DATE(HB_BOOK_DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."'";
				} else {
					$fromDate = date("Y-m-d",strtotime($_SESSION['fromDate']));
					$toDate = date("Y-m-d",strtotime($_SESSION['toDate']));
					$condition = "where TRUST_HALL_BOOKING_LIST.HBL_ACTIVE='1' and STR_TO_DATE(HB_BOOK_DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."' and TRUST_HALL_BOOKING.HB_ACTIVE='1'";
				}
			}
			
			$data['hallBooking'] = $this->obj_booking->get_all_bookingRawQuery($condition,"TRUST_HALL_BOOKING.HB_ID","DESC", 10, $start);
			//$this->output->enable_profiler(true);
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Trust/search_booking_receipt/';
			$config['total_rows'] = $this->obj_booking->get_all_bookingRawQueryCount($condition);
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
						
			if(isset($_SESSION['All_Hall_Bookings'])) {
				$this->load->view('header',$data);
				$this->load->view('trust/index');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
	}

	function addHeads() {
		$condition = ["HALL_ACTIVE"=>"1"];
		$data['hall'] = $this->obj_admin_settings->get_all_field_hall_details($condition);
		
		//$this->output->enable_profiler(true);
		//slap
		//bank 															
		$condition = (" IS_TERMINAL = 1");									//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);

		$query = $this->db->where("TBDT_ACTIVE","1")->get("TRUST_BLOCK_DATE_TIME");
		$data['TRUST_BLOCK_DATE_TIME'] = json_encode($query->result_array());
		$data['sevas'] = json_encode($this->obj_receipt->getDetiesSevasBooking()); 

		$id= $_POST["HB_ID"];

		$data["HB_ID"] = $id;

		$condition = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id
		);

		$conditionTrust = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id,
			"TR_ACTIVE"=>1
		);

		$conditionTemple = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id,
			"RECEIPT_ACTIVE"=>1
		);
		
		$data['hallBooking'] = $this->obj_booking->get_all_booking($condition,"","");
		$data['hallBookingTemple'] = $this->obj_booking->get_all_bookingTemple($conditionTemple,"","");
		$data['hallBookingTrust'] = $this->obj_booking->get_all_bookingTrust($conditionTrust,"","");
		$this->load->view('header', $data);
		$this->load->view('trust/add_heads');
		$this->load->view('footer_home');
	}


	function editBooking() {
		$condition = ["HALL_ACTIVE"=>"1"];
		$data['hall'] = $this->obj_admin_settings->get_all_field_hall_details($condition);
		
		//$this->output->enable_profiler(true);
		
		$data['fun'] = $this->db->get("FUNCTION")->result();

		$query = $this->db->where("TBDT_ACTIVE","1")->get("TRUST_BLOCK_DATE_TIME");
		$data['TRUST_BLOCK_DATE_TIME'] = json_encode($query->result_array());
		$data['sevas'] = json_encode($this->obj_receipt->getDetiesSevasBooking()); 

		$id= $_POST["HB_ID"];

		$data["HB_ID"] = $id;

		$condition = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id
		);

		$conditionTrust = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id
		);

		$conditionTemple = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id
		);
		
		$data['hallBooking'] = $this->obj_booking->get_all_booking($condition,"","");
		$data['hallBookingTemple'] = $this->obj_booking->get_all_bookingTemple($conditionTemple,"","");
		$data['hallBookingTrust'] = $this->obj_booking->get_all_bookingTrust($conditionTrust,"","");
		$this->load->view('header', $data);
		$this->load->view('trust/editBookHall');
		$this->load->view('footer_home');
	}

	function printHallBooking() {

		$data['whichTab'] = "hallBooking";
		$id = $_SESSION['TRUST_HALL_BOOKING_ID'];
		// $id = 27;
		//unset($_SESSION['TRUST_HALL_BOOKING_ID']);
		// $_SESSION['TRUST_HALL_BOOKING_ID']
		$condition = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id,
			"TRUST_HALL_BOOKING_LIST.HBL_ACTIVE"=>"1"
		);

		$conditionTrust = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id,
			"TRUST_RECEIPT.TR_ACTIVE"=>"1"
		);

		$conditionTemple = array(
			"TRUST_HALL_BOOKING.HB_ID" => $id,
			"DEITY_RECEIPT.RECEIPT_ACTIVE"=>"1"
		);
		
		if(isset($_SESSION['PAYMENT_STATUS'])) {
			$data['PAYMENT_STATUS'] = $_SESSION['PAYMENT_STATUS'];
			unset($_SESSION['PAYMENT_STATUS']);
		}
		
		$data['hallBooking'] = $this->obj_booking->get_all_booking($condition,"","");
		$data['hallBookingTemple'] = $this->obj_booking->get_all_bookingTemple($conditionTemple,"","");
		$data['hallBookingTrust'] = $this->obj_booking->get_all_bookingTrust($conditionTrust,"","");
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		//$this->output->enable_profiler(true);
		
		$this->load->view('header', $data);
		$this->load->view('trust/printBookHall');
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
	
	function getFinancialHeads() {
		$hallId = json_decode($_POST['hallId']);

		$where = " (";
		$i = 0;
		foreach($hallId as $id) {
			if($i == 0) {
				$where .= "HALL_FINANCIAL_HEAD.H_ID = '".$id."'";
				++$i;
			}else {
				$where .= " or HALL_FINANCIAL_HEAD.H_ID = '".$id."'";
			}	
		}

		$where.=") and HALL_FINANCIAL_HEAD.HFH_STATUS='1'";

		$SQL = "select * from HALL_FINANCIAL_HEAD join FINANCIAL_HEAD on FINANCIAL_HEAD.FH_ID = HALL_FINANCIAL_HEAD.FH_ID where".$where." group by FINANCIAL_HEAD.FH_ID";
		
		$query = $this->db->query($SQL);

		echo json_encode($query->result('array'));
	}
	
	function test() {
		$data['whichTab'] = "hallBooking";
		
		$condition = ["HALL_ACTIVE"=>"1"];
		$data['hall'] = $this->obj_admin_settings->get_all_field_hall_details($condition);
		
		// $this->output->enable_profiler(true);
		
		$query = $this->db->where("TBDT_ACTIVE","1")->get("TRUST_BLOCK_DATE_TIME");
		$data['TRUST_BLOCK_DATE_TIME'] = json_encode($query->result_array());
		$data['sevas'] = json_encode($this->obj_receipt->getDetiesSevasBooking()); 
		
		$this->load->view('header', $data);
		$this->load->view('trust/test');
		$this->load->view('footer_home');
	}
}
