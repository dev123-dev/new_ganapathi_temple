<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TrustReceipt extends CI_Controller {
	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('TrustReceipt_modal','obj_receipt',true);
		$this->load->model('TrustEvents_modal','obj_events',true);		
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		$this->load->model('TrustReceipt_modal','trust_receipt_modal',true);  //added by adithya on 5-1-24
		$this->load->model('Shashwath_Model','obj_shashwath',true);	
		if(!isset($_SESSION['userId']))
			redirect('login');
			
		if($_SESSION['trustLogin'] != 1)
			redirect('login');

		$this->db->select()->from('TRUST_EVENT')->where("TET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
		//$this->output->enable_profiler(true);
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
							'TR_ACTIVE' => 0);
		
		$this->db->where('TR_ID',$rId);
		$this->db->update('TRUST_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('TrustReceipt/receipt_newTrustPrint');
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
							'TET_RECEIPT_ACTIVE' => 0);
		
		$this->db->where('TET_RECEIPT_ID',$rId);
		$this->db->update('TRUST_EVENT_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptFormat'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('TrustEvents/printSevaReceipt');
	}
	
	function save_cancel_note_event_hundi() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'TET_RECEIPT_ACTIVE' => 0);
		
		$this->db->where('TET_RECEIPT_ID',$rId);
		$this->db->update('TRUST_EVENT_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptFormat'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('TrustReceipt/receipt_donationPrint');
	}
	
	function save_cancel_note_event_donation() {
		$rId = $_POST['rId'];
		$rNo = $_POST['rNo'];
		$cNote = $_POST['cNote'];
		
		$data_array = array('CANCEL_NOTES'=>$cNote,
							'CANCELLED_BY_ID'=> $_SESSION['userId'],
							'CANCELLED_BY'=> $_SESSION['userFullName'],
							'CANCELLED_DATE_TIME'=> date('d-m-Y H:i:s A'),
							'CANCELLED_DATE'=> date('d-m-Y'),
							'PAYMENT_STATUS' => 'Cancelled',
							'TET_RECEIPT_ACTIVE' => 0);
		
		$this->db->where('TET_RECEIPT_ID',$rId);
		$this->db->update('TRUST_EVENT_RECEIPT', $data_array);
		
		$_SESSION['recFor'] = $rNo;
		$_SESSION['receiptFormat'] = $rNo;
		$_SESSION['receiptId'] = $rId;
		redirect('TrustReceipt/receipt_donationPrint');
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
	
	//SAVE RECEIPT THROUGH TOKEN
	function save_token_receipt() {
		if(@$_SESSION['actual_link'] != "") {
			unset($_SESSION['actual_link']);
			
		} else {
			redirect('TrustEvents/event_token');
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
			$this->db->select()->from('TRUST_EVENT_RECEIPT_CATEGORY')
			->join('TRUST_EVENT_RECEIPT_COUNTER', 'TRUST_EVENT_RECEIPT_CATEGORY.TET_ACTIVE_RECEIPT_COUNTER_ID = TRUST_EVENT_RECEIPT_COUNTER.TET_RECEIPT_COUNTER_ID')
			->where(array('TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID'=>'1'));
			
			$query = $this->db->get();
			$eventCounter = $query->first_row();
			$counter = $eventCounter->TET_RECEIPT_COUNTER;
			$counter += 1;
			
			$this->db->where('TET_RECEIPT_COUNTER_ID',$eventCounter->TET_ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('TRUST_EVENT_RECEIPT_COUNTER', array('TET_RECEIPT_COUNTER'=>$counter));
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			$receiptFormat = $eventCounter->TET_ABBR1 ."/".$datMonth."/".$eventCounter->TET_ABBR2."/".$counter;
			
			$_SESSION['receiptFormat'] = $receiptFormat;
			
			$data = array(
				'TET_RECEIPT_NO'=> $receiptFormat,
				'TET_RECEIPT_DATE'=> date('d-m-Y'),
				'TET_RECEIPT_NAME'=> $this->input->post('uName'),
				'TET_RECEIPT_PAYMENT_METHOD'=> 'Cash',
				'TET_RECEIPT_PRICE'=> $price,
				'RECEIPT_TET_ID'=>$event[0],
				'RECEIPT_TET_NAME'=>$event[1],
				'TET_RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'TET_RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'TET_RECEIPT_ACTIVE'=>1,
				'TET_RECEIPT_CATEGORY_ID'=>1,
				'PAYMENT_STATUS'=> 'Completed', 
				'AUTHORISED_STATUS'=>'No',
				'PRINT_STATUS'=>1
			); 
			$this->db->insert('TRUST_EVENT_RECEIPT', $data);
			$receiptId = $this->db->insert_id();
			$_SESSION['receiptId'] = $receiptId;
			
			if($i == 0) {
				$arr_receiptNo = $receiptId;
			} else {
				$arr_receiptNo .= ",".$receiptId;
			}
			
			// if($this->input->post('is_seva') == 1) {
			// 	$data = array(
			// 		'TET_SO_SEVA_NAME'=>$this->input->post('sevaName'),
			// 		'TET_SO_SEVA_ID'=>$this->input->post('sevaId'),
			// 		'TET_SO_DATE'=>date('d-m-Y'),
			// 		'TET_SO_PRICE'=>$this->input->post('sevaPrice'),
			// 		'TET_RECEIPT_ID'=>$receiptId,
			// 		'TET_SO_IS_SEVA'=>$this->input->post('is_seva'));
			// 	$this->db->insert('TRUST_EVENT_SEVA_OFFERED', $data);
			// 	$sevaOfferedID = $this->db->insert_id();
				
			// } else {
				$data = array(
					'TET_SO_SEVA_NAME'=>$this->input->post('sevaName'),
					'TET_SO_SEVA_ID'=>$this->input->post('sevaId'),
					'TET_SO_DATE'=>date('d-m-Y'),
					'TET_SO_QUANTITY'=>$laddu,
					'TET_SO_PRICE'=>$this->input->post('sevaPrice'),
					'TET_RECEIPT_ID'=>$receiptId,
					'TET_SO_IS_SEVA'=>$this->input->post('is_seva'));
				$this->db->insert('TRUST_EVENT_SEVA_OFFERED', $data);
				$sevaOfferedID = $this->db->insert_id();
			//} 
		}
		
		$strRes = explode(',', $arr_receiptNo);
		
		for($i = 0; $i < count($strRes); $i++) {
			$this->db->select()->from('TRUST_EVENT_RECEIPT')
			->join('TRUST_EVENT_SEVA_OFFERED', 'TRUST_EVENT_SEVA_OFFERED.TET_RECEIPT_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_ID')
			->where(array('TRUST_EVENT_RECEIPT.TET_RECEIPT_ID'=>$strRes[$i]));
			$query = $this->db->get();
			$res[$i] = $query->result("array");
		}

		$data['eventCounter'] = $res;
		
		$data['event'] = $this->obj_events->getEvents();
		$condition = array('IS_TOKEN'=>1, 'TET_ACTIVE' => 1, 'TET_SEVA_PRICE_ACTIVE' => 1);
		$data['eventSevas'] = $this->obj_events->getTokenEventSeva($condition,'TRUST_EVENT_SEVA.TET_SEVA_ID','DESC');
		$data['whichTab'] = "eventToken";
		
		$_SESSION['DataAdded'] = 'Done';
		$_SESSION['eventCounterRes'] = $res;
		redirect('TrustEvents/event_token');
		
		// $this->load->view('header', $data);
		// $this->load->view('trust/event_token');
		// $this->load->view('footer_home');
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
	
	function receipt_donationPrint() {
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		$data['whichTab'] = "hallReceipt";
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
            redirect('TrustReceipt/all_receipt');
			unset($_SESSION['reload']);
		}
		
		$receiptFormat = $_SESSION['receiptFormat'];
		$receiptId = $_SESSION['receiptId'];
		unset($_SESSION['receiptFormat']);
		unset($_SESSION['receiptId']);
		
		$_SESSION['reload'] = 'reload';
		$this->db->select()->from('TRUST_EVENT_RECEIPT')
		->where(array('TRUST_EVENT_RECEIPT.TET_RECEIPT_ID'=>$receiptId));
		
		$query = $this->db->get();
		$data['eventCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();

		$this->load->view('header', $data);
		$this->load->view('trust/receipt_donationPrint');
		$this->load->view('footer_home');
	}

	//RECEIPT FOR INKIND
	function receipt_inkind() { 
		//For Menu Selection
		$data['whichTab'] = "hallReceipt";
		//NOTIFICATION
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		$data['inkind_item'] = $this->obj_receipt->get_all_field_inkind_items();
		
		$condition = array('DEITY_ACTIVE' => 1);
		$data['deity'] = [];//$this->obj_receipt->get_all_field_deity($condition);
		
		$conditionOne = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_receipt->get_all_field_events($conditionOne);
		
		if(isset($_SESSION['Deity/Event_Inkind'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/receipt_inkind');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//RECEIPT FOR INKIND SAVE
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
			$this->db->select()->from('TRUST_EVENT_RECEIPT_CATEGORY')
			->join('TRUST_EVENT_RECEIPT_COUNTER', 'TRUST_EVENT_RECEIPT_CATEGORY.TET_ACTIVE_RECEIPT_COUNTER_ID = TRUST_EVENT_RECEIPT_COUNTER.TET_RECEIPT_COUNTER_ID')
			->where(array('TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID'=>'4'));
			
			$query = $this->db->get();
			$eventCounter = $query->first_row();
			$counter = $eventCounter->TET_RECEIPT_COUNTER;
			$counter += 1;
			
			$this->db->where('TET_RECEIPT_COUNTER_ID',$eventCounter->TET_ACTIVE_RECEIPT_COUNTER_ID);
			$this->db->update('TRUST_EVENT_RECEIPT_COUNTER', array('TET_RECEIPT_COUNTER'=>$counter));
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_financial_year($dfMonth);
			
			$receiptFormat = $eventCounter->TET_ABBR1 ."/".$datMonth."/".$eventCounter->TET_ABBR2."/".$counter;
			
			$_SESSION['receiptFormat'] = $receiptFormat;
			
			$data = array(
				'TET_RECEIPT_NO'=> $receiptFormat,
				'TET_RECEIPT_DATE'=> date('d-m-Y'),
				'TET_RECEIPT_NAME' => $this->input->post('name'),
				'TET_RECEIPT_PHONE' => $this->input->post('number'),
				'TET_RECEIPT_EMAIL' => $this->input->post('email'),
				'TET_RECEIPT_ADHAAR_NO' => $this->input->post('adhaarNo'),
				'TET_RECEIPT_PAN_NO' => $this->input->post('panNo'),
				'TET_RECEIPT_ADDRESS' => $this->input->post('address'),
				'TET_RECEIPT_PAYMENT_METHOD_NOTES' => $this->input->post('paymentNotes'),
				'RECEIPT_TET_ID'=>$event[0],
				'RECEIPT_TET_NAME'=>$event[1],
				'TET_RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'TET_RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'TET_RECEIPT_ACTIVE'=>1,
				'TET_RECEIPT_CATEGORY_ID'=>4,
				'PAYMENT_STATUS'=>'Received',
				'AUTHORISED_STATUS'=>'No',
				'EOD_CONFIRMED_BY_ID'=>0,
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
			$_SESSION['receiptId'] = $receiptId;
			
			if($postage == 1) {
				$dataPostage = array(
					'RECEIPT_ID' => $receiptId,
					'POSTAGE_CATEGORY' => 3,
					'POSTAGE_STATUS' => 0,
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'));
				$this->db->insert('POSTAGE', $dataPostage);
			}
			
			//Getting Latest Inserted Receipt Id
			$insertReceipt = $this->obj_receipt->get_all_field_events_receipt("","TET_RECEIPT_ID","desc");
			
			$tableItemId = json_decode($_POST['tableItemId']);
			$tableItem = json_decode($_POST['tableItem']);
			$tableQty = json_decode($_POST['tableQty']);
			$tablePrice = json_decode($_POST['tablePrice']);
			$tableNotes = json_decode($_POST['tableNotes']);

			
			for($i = 0; $i < count($tableItemId); ++$i) {
				$itemArr = explode(' ', $tableQty[$i]); 
				$data_One = array(
					'TET_RECEIPT_ID'=> $insertReceipt->TET_RECEIPT_ID,
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
			
			$_SESSION['receiptFormatDeity'] = $receiptFormat;
			
			$data = array(
				'RECEIPT_NO'=> $receiptFormat,
				'RECEIPT_DATE'=> date('d-m-Y'),
				'RECEIPT_NAME' => $this->input->post('name'),
				'RECEIPT_PHONE' => $this->input->post('number'),
				'RECEIPT_EMAIL' => $this->input->post('email'),
				'RECEIPT_PAN_NO' => $this->input->post('panNo'),
				'RECEIPT_ADHAAR_NO' => $this->input->post('adhaarNo'),
				'RECEIPT_ADDRESS' => $this->input->post('address'),
				'RECEIPT_PAYMENT_METHOD_NOTES' => $this->input->post('paymentNotes'),
				'RECEIPT_DEITY_ID'=>$deity[0],
				'RECEIPT_DEITY_NAME'=>$deity[1],
				'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'RECEIPT_ACTIVE'=>1,
				'RECEIPT_CATEGORY_ID'=>5,
				'PAYMENT_STATUS'=>'Received',
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
			$_SESSION['receiptId'] = $receiptId;
			
			if($postage == 1) {
				$dataPostage = array(
					'RECEIPT_ID' => $receiptId,
					'POSTAGE_CATEGORY' => 3,
					'POSTAGE_STATUS' => 0,
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'));
				$this->db->insert('POSTAGE', $dataPostage);
			}

			//Getting Latest Inserted Receipt Id
			$insertReceipt = 1;//$this->obj_receipt->get_all_field_deity_receipt("","RECEIPT_ID","desc");
			
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

	function receipt_inkindPrint() {
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		$data['whichTab'] = "hallReceipt";
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
		}  else if(!isset($_SESSION['receiptId']) && isset($_SESSION['reload'])) {
            redirect('TrustReceipt/all_receipt');
			unset($_SESSION['reload']);
		}
		 
		$receiptFormat = @$_SESSION['receiptFormat'];
		$receiptFormatDeity = @$_SESSION['receiptFormatDeity'];
		$receiptId = $_SESSION['receiptId'];
		
		unset($_SESSION['receiptFormat']);
		unset($_SESSION['receiptFormatDeity']);
		unset($_SESSION['receiptId']);
		
		$_SESSION['reload'] = 'reload';
		if(@$receiptFormatDeity != "") {
			$this->db->select()->from('DEITY_INKIND_OFFERED')
			->join('DEITY_RECEIPT', 'DEITY_INKIND_OFFERED.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID')
			->where(array('DEITY_RECEIPT.RECEIPT_ID'=>$receiptId));
			
			$query = $this->db->get();
			$data['deityCounter'] = $query->result('array');
			
			$this->load->view('header', $data);
			$this->load->view('receipt_inkindDeityPrint');
			$this->load->view('footer_home');
		} else {
			$this->db->select()->from('TRUST_EVENT_INKIND_OFFERED')
			->join('TRUST_EVENT_RECEIPT', 'TRUST_EVENT_INKIND_OFFERED.TET_RECEIPT_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_ID')
			->where(array('TRUST_EVENT_RECEIPT.TET_RECEIPT_ID'=>$receiptId));
			
			$query = $this->db->get();
			$data['eventCounter'] = $query->result('array');
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			$this->load->view('header', $data);
			$this->load->view('trust/receipt_inkindPrint');
			$this->load->view('footer_home');
		}
	}

	function receipt_hundiPrint() {
			$data['duplicate'] = @$_SESSION['duplicate'];
			unset($_SESSION['duplicate']);
			$todayDate = date('d-m-Y');
			$dateTime = date('d-m-Y H:i:s A');
			$deviceIP = $this->input->ip_address();
			$data['whichTab'] = "hallReceipt";
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
			} else if(!isset($_SESSION['receiptId']) && isset($_SESSION['reload'])) {
				redirect('TrustReceipt/all_receipt');
				unset($_SESSION['reload']);
			}
			
			$receiptFormat = @$_SESSION['receiptFormat'];
			$receiptFormatDeity = @$_SESSION['receiptFormatDeity'];
			$receiptId = @$_SESSION['receiptId'];
			
			unset($_SESSION['receiptFormat']);
			unset($_SESSION['receiptFormatDeity']);
			unset($_SESSION['receiptId']);
			
			$_SESSION['reload'] = 'reload';//handled for browser reload issue
			$this->db->select()->from('TRUST_EVENT_RECEIPT')
			->where(array('TRUST_EVENT_RECEIPT.TET_RECEIPT_ID'=>$receiptId));
				
			$query = $this->db->get();
			$data['eventCounter'] = $query->result('array');
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
				
			$this->load->view('header', $data);
			$this->load->view('trust/receipt_hundiPrint');
			$this->load->view('footer_home');
	}

	


	//RECEIPT FOR HUNDI
	function receipt_hundi() { 
		//For Menu Selection
		$data['whichTab'] = "hallReceipt";
		//NOTIFICATION
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		
		
		$data['bank'] = $this->trust_receipt_modal->get_banks();
		$condition = ("T_IS_TERMINAL = 1");					
		$data['terminal'] = $this->trust_receipt_modal->getCardBanks($condition);	 

		$condition = array('DEITY_ACTIVE' => 1);
		$data['deity'] = [];
		$conditionOne = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_receipt->get_all_field_events($conditionOne);
		
		if(isset($_SESSION['Deity/Event_Hundi'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/receipt_hundi');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}


	//RECIEPT FOR HUNDI SAVE
	function receipt_hundi_save() {
		$_SESSION['duplicate'] = "no";
		$pan = "";$adhaar="";$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = "";$fglhBank ="";			//laz new; //declaring and initializing variables
		
		if(isset($_POST["transactionId"])) { //checking whether  set
			$transcId = $this->input->post('transactionId');//fetching transaction id from view
		}
		if(isset($_POST["pan"])) { //checking whether  set
			$pan = $this->input->post('pan');//fetching transaction id from view
		}
		if(isset($_POST["adhaar"])) { //checking whether  set
			$adhaar = $this->input->post('adhaar');//fetching transaction id from view
		}
		if(isset($_POST["chequeNo"])) {//checking whether  set
			$chequeNo = $this->input->post('chequeNo');//fetching chequeNo from view
		}
		
		if(isset($_POST["chequeDate"])) {//checking whether  set
			$chequeDate = $this->input->post('chequeDate');//fetching chequeDate from view
		}
		
		if(isset($_POST["bank"])) {//checking whether  set
			$bank = $this->input->post('bank');//fetching bank from view
		}
		
		if(isset($_POST["branch"])) {                                 //checking whether  set
			$branch = $this->input->post('branch');                   //fetching branch from view
		}
			
		if($_POST["tobank"] != 0) {									  //REMOVED from comment by adithya from here till
			$fglhBank = $this->input->post('tobank');
		}															

		if($_POST["DCtobank"] != 0) {								
			$fglhBank = $this->input->post('DCtobank');
		}                                                           //here

																	//LAZ new ..
		if($this->input->post('modeOfPayment') == "Cheque") {      //checking if mode of payment is cheque/cash/(debit/credit)/direct credit
			$paymentStatus = "Pending";                            //if cheque then set payment status as pending 
		} else {
			$paymentStatus = "Completed";                          //else by default set completed
		}
		$event = explode('|', $this->input->post('event'));
		$this->db->select()->from('TRUST_EVENT_RECEIPT_CATEGORY')
		->join('TRUST_EVENT_RECEIPT_COUNTER', 'TRUST_EVENT_RECEIPT_CATEGORY.TET_ACTIVE_RECEIPT_COUNTER_ID = TRUST_EVENT_RECEIPT_COUNTER.TET_RECEIPT_COUNTER_ID')
		->where(array('TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID'=>'3'));
		
		$query = $this->db->get();
		$eventCounter = $query->first_row();
		$counter = $eventCounter->TET_RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('TET_RECEIPT_COUNTER_ID',$eventCounter->TET_ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('TRUST_EVENT_RECEIPT_COUNTER', array('TET_RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		$receiptFormat = $eventCounter->TET_ABBR1 ."/".$datMonth."/".$eventCounter->TET_ABBR2."/".$counter;
		
		$_SESSION['receiptFormat'] = $receiptFormat;
						
		$data = array(
			'TET_RECEIPT_NO'=> $receiptFormat,
			'TET_RECEIPT_DATE'=> date('d-m-Y'),
			'TET_RECEIPT_NAME' => $this->input->post('name1'),
				'TET_RECEIPT_PHONE' => $this->input->post('number'),
				'TET_RECEIPT_EMAIL' => $this->input->post('email'),
				'TET_RECEIPT_ADHAAR_NO' =>$adhaar ,
				'TET_RECEIPT_PAN_NO' => $pan,
				'TET_RECEIPT_ADDRESS' => $this->input->post('addLine1'),
			'TET_RECEIPT_PAYMENT_METHOD'=> $this->input->post('modeOfPayment'),
			'CHEQUE_NO' => $chequeNo,
			'CHEQUE_DATE' => $chequeDate,
			'BANK_NAME' => $bank,
			'BRANCH_NAME' => $branch,
			'TRANSACTION_ID' => $transcId,
			'TET_RECEIPT_PRICE'=> $this->input->post('amount'),
			'TET_RECEIPT_PAYMENT_METHOD_NOTES'=>$this->input->post('paymentNotes'),
			'RECEIPT_TET_ID'=>$event[0],
			'RECEIPT_TET_NAME'=>$event[1],
			'TET_RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'TET_RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'DATE_TIME' => date('d-m-Y H:i:s A'),
			'TET_RECEIPT_ACTIVE'=>1,
			'TET_RECEIPT_CATEGORY_ID'=>3,
			'PAYMENT_STATUS'=>$paymentStatus, 
			'AUTHORISED_STATUS'=>'No',//,
			 'T_FGLH_ID' => $fglhBank							//laz new ..
		); 
		$receiptId = $this->obj_receipt->add_receipt_hundi_event_modal($data);
		$_SESSION['receiptId'] = $receiptId;
		
		redirect('/TrustReceipt/receipt_hundiPrint/');
	}


	//RECEIPT FOR EVENT DONATION
	function receipt_donation()	{
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');
		//For Menu Selection
		$data['whichTab'] = "hallReceipt";
		//NOTIFICATION
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		//bank

		// added by adithya on 5-1-24 start 
		$data['bank'] = $this->trust_receipt_modal->get_banks();
		$condition = ("T_IS_TERMINAL = 1");						    //laz..
        $data['terminal'] = $this->trust_receipt_modal->getCardBanks($condition);
        // added by adithya on 5-1-24 end


		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..
		
		$data['event'] = $this->obj_events->getEvents();
		
		if(isset($_SESSION['Event_Donation/Kanike'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/receipt_event_dk');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	//RECEIPT FOR EVENT DONATION SAVE
	function receipt_dk_save() {
		$_SESSION['duplicate'] = "no";
		$pan="";$adhaar="";$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = ""; $fglhBank ="";			//laz new;
		
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
		
		if($_POST["tobank"] != 0) {									//UNCOMMENTED BY ADITHYA
			$fglhBank = $this->input->post('tobank');
		}															

		if($_POST["DCtobank"] != 0) {								
			$fglhBank = $this->input->post('DCtobank');
		}
																	//TILL HERE
		if(isset($_POST["branch"])) {
			$branch = $this->input->post('branch');
		}
		
		$this->db->select()->from('TRUST_EVENT_RECEIPT_CATEGORY')
			->join('TRUST_EVENT_RECEIPT_COUNTER', 'TRUST_EVENT_RECEIPT_CATEGORY.TET_ACTIVE_RECEIPT_COUNTER_ID = TRUST_EVENT_RECEIPT_COUNTER.TET_RECEIPT_COUNTER_ID')
			->where(array('TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID'=>'2'));
			
		$query = $this->db->get();
		$eventCounter = $query->first_row();
		$counter = $eventCounter->TET_RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('TET_RECEIPT_COUNTER_ID',$eventCounter->TET_ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('TRUST_EVENT_RECEIPT_COUNTER', array('TET_RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		
		$receiptFormat = $eventCounter->TET_ABBR1 ."/".$datMonth."/".$eventCounter->TET_ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;
		
		if($this->input->post('modeOfPayment') == "Cheque") {
			$paymentStatus = "Pending";
		} else {
			$paymentStatus = "Completed";
		}
		$postage = @$_POST['postage'] || 0;
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
			'TET_RECEIPT_NO' => $receiptFormat,
			'TET_RECEIPT_NAME' => $this->input->post('name'),
			'TET_RECEIPT_PHONE' => $this->input->post('number'),
			'TET_RECEIPT_EMAIL' => $this->input->post('email'),
			'TET_RECEIPT_ADDRESS' => $this->input->post('address'),
			'TET_RECEIPT_DATE' => date('d-m-Y'),
			'TET_RECEIPT_PAYMENT_METHOD' => $this->input->post('modeOfPayment'),
			'TET_RECEIPT_PRICE' => $this->input->post('amount'),
			'TET_RECEIPT_PAYMENT_METHOD_NOTES' => $this->input->post('paymentNotes'),
			'RECEIPT_TET_ID' => $this->input->post('eventId'),
			'RECEIPT_TET_NAME' => $this->input->post('eventName'),
			'TET_RECEIPT_ISSUED_BY_ID' =>$_SESSION['userId'],
			'TET_RECEIPT_ISSUED_BY' =>$_SESSION['userFullName'],
			'DATE_TIME' => date('d-m-Y H:i:s A'),
			'TET_RECEIPT_ACTIVE' =>1,
			'TET_RECEIPT_CATEGORY_ID' =>2,
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
			'PINCODE' => $pincode,                                //,
			'T_FGLH_ID' => $fglhBank,
			'TET_RECEIPT_PAN_NO'=>$pan,
			'TET_RECEIPT_ADHAAR_NO'=>$adhaar							//Uncommented by adithya
		); 
		$receiptId = $this->obj_receipt->add_receipt_hundi_event_modal($data);
		$_SESSION['receiptId'] = $receiptId;
		
		if($postage == 1) {
			$dataPostage = array(
				'RECEIPT_ID' => $receiptId,
				'POSTAGE_CATEGORY' => 3,
				'POSTAGE_STATUS' => 0,
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'DATE' => date('d-m-Y'));
			$this->db->insert('POSTAGE', $dataPostage);
		}
		
		redirect('/TrustReceipt/receipt_donationPrint/');
	}


	//GET FINACIAL YEAR
	/*function get_financial_year($month) {
		//Financial Month From Database
		$dMonth = $month->MONTH_IN_NUMBER;
		$fYear = "";
		$day = "";
		$dt = "";
		$prevyear = "";
		$CMonth = date('j');
		$CYear = date('Y');
		
		//Calculate End Date Based On Financial Month
		if($CMonth > $dMonth) {
			@$dt = ($CYear."-".($dMonth - 1)."-11");
			@$day = date("t", strtotime($dt));
			@$endDate = $CYear."-".($dMonth - 1)."-".$day;
		} else {
			@$dt = ((int)($CYear + 1)."-".(int)($dMonth - 1)."-11");
			@$day = date("t", strtotime($dt));
			@$endDate = (int)($CYear + 1)."-".(int)($dMonth - 1)."-".$day;
		}
		
		//Current Date
		$startDate = date('Y-m-d'); 
		
		$ts1 = strtotime($startDate);
		$ts2 = strtotime($endDate);

		$year1 = date('Y', $ts1);
		$year2 = date('Y', $ts2);

		$month1 = date('m', $ts1);
		$month2 = date('m', $ts2);

		//get months
		$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
		$total_years = ($month2 > $dMonth)?ceil($diff/12):floor($diff/12);
		
		while($total_years >= 0) {
			$prevyear = $year1 - 1;
			$fYear = $prevyear.'-'.substr(($prevyear + 1),2);
			$year1 += 1;
			$total_years--;
		}
		
		if(($month1 > sprintf("%02d", $dMonth)) && $prevyear != "") {
			$fYear = ($year1 - 1).'-'.substr(($year1),2);
		} else if($month1 > sprintf("%02d", $dMonth)) {
			$fYear = ($year1).'-'.substr(($year1 + 1),2);
		} else if($month1 == sprintf("%02d", $dMonth) && $prevyear != "") {
			$fYear = ($year1 - 1).'-'.substr(($year1),2);
		} else if($month1 == sprintf("%02d", $dMonth)) {
			$fYear = ($year1).'-'.substr(($year1 + 1),2);
		} else if(($month1 < sprintf("%02d", $dMonth)) && $prevyear != "") {
			$fYear = ($prevyear).'-'.substr(($prevyear + 1),2);
		} else if($month1 < sprintf("%02d", $dMonth)) {
			$fYear = ($year1).'-'.substr(($year1 + 1),2);
		}
		
		$_SESSION['fYear'] = $fYear;
		$_SESSION['prevyear'] = $prevyear;
		$_SESSION['year1'] = $year1;
		$_SESSION['month1'] = $month1;
		$_SESSION['dMonth'] = $dMonth;
		$_SESSION['total_years'] = $total_years;
		$_SESSION['dMonth1'] = sprintf("%02d", $dMonth);
		
		return $fYear;
	}*/
	
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
	
	//DISPLAY PAGE NEW TRUST RECEIPT
	function new_trust_receipt() {
		//For Menu Selection
		$data['whichTab'] = "hallReceipt";

		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks();					    //laz..
		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..
		
		// adding the new bank and terminal by adithya on 8-1-24 start
		$data['bank'] = $this->trust_receipt_modal->get_banks();
		$condition = ("T_IS_TERMINAL = 1");	
		$data['terminal'] = $this->trust_receipt_modal->getCardBanks($condition);
		// adding the new bank and terminal by adithya on 8-1-24 end


		$conditionOne = array('FH_ACTIVE' => 1);
		$data['financialHeads'] = $this->obj_admin_settings->get_all_field_financial_details($conditionOne);
		
		if(isset($_SESSION['New_Trust_Receipt'])) {
			$this->load->view('header',$data);           
			$this->load->view('trust/new_trust_receipt');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	
	function saveTrustPrintHistory(){
		$receiptId = @$_POST['receiptId'];
		$hallBookId= @$_POST['hallBookId'];
		$printstatus = $this->input->post('printStatus');
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		
		$data2 = array(
		'PRINT_STATUS' => $printstatus
		);

		if($_POST['receiptFromHall'] == 1) {
			if(isset($_POST['hallBookId'])) {
				$where = array('HB_ID' => $hallBookId);
				$this->db->where($where);
				$this->db->update('TRUST_RECEIPT',$data2);
			}
			if(isset($_POST['receiptId'])) {
				$where = array('RECEIPT_ID' => $receiptId);
				$this->db->where($where);
				$this->db->update('DEITY_RECEIPT',$data2);
			}
		} else {
				$where = array('TR_ID' => $receiptId);
				$this->db->where($where);
				$this->db->update('TRUST_RECEIPT',$data2);
		}
		
		$dataInsert = array(
			'RECEIPT_ID' => $receiptId,
			'DATE_TIME'=>$dateTime,
			'USER_ID'=>$_SESSION['userId'],
			'DATE'=>$todayDate
		);
		
		$this->db->insert('TRUST_PRINT_HISTORY', $dataInsert);
		$insertId = $this->db->insert_id();	
	}
	
	//SAVE NEW TRUST RECEIPT
	function save_new_trust_receipt() {

		$_SESSION['duplicate'] = "no";
		$pan="";$adhaar="";$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = "";$fglhBank ="";			//laz new;
		
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

	    // adding the condition by adithya start
	    if($this->input->post('modeOfPayment') == "Cash") {
		$FH_ID = $this->input->post('financialHeads');
		$this->db->select('T_FGLH_ID')->from('FINANCIAL_HEAD')
		->where(array('FH_ID'=>explode("|",$FH_ID)[0]));
		$query = $this->db->get();

		$T_FGLH_ID = $query->first_row();
        $fglhBank = $T_FGLH_ID->T_FGLH_ID;
			//print_r($fglhBank);							            //uncommented from here by adithya till
	    }
	    // adding the condition by adithya end


		if($_POST["tobank"] != 0) {									//uncommented from here by adithya till
			$fglhBank = $this->input->post('tobank');
		}															

		if($_POST["DCtobank"] != 0) {								
			$fglhBank = $this->input->post('DCtobank');
		}                                                             //here

		if(isset($_POST["branch"])) {
			$branch = $this->input->post('branch');
		}
		
		if($this->input->post('modeOfPayment') == "Cheque") {
			$paymentStatus = "Pending";
		} else {
			$paymentStatus = "Completed";
		}
		
		$financialHeads = explode('|', $this->input->post('financialHeads'));
		$this->db->select()->from('FINANCIAL_HEAD')
		->join('FINANCIAL_HEAD_COUNTER', 
		       'FINANCIAL_HEAD.FH_ACTIVE_HEAD_COUNTER_ID = FINANCIAL_HEAD_COUNTER.HEAD_COUNTER_ID')
		->where(array('FINANCIAL_HEAD.FH_ID'=>$financialHeads[0]));
		
		$query = $this->db->get();
		$finHeadCounter = $query->first_row();
		$counter = $finHeadCounter->RECEIPT_COUNTER;
		$counter += 1;
		//print_r($finHeadCounter);
		$this->db->where('HEAD_COUNTER_ID',$finHeadCounter->FH_ACTIVE_HEAD_COUNTER_ID);
		$this->db->update('FINANCIAL_HEAD_COUNTER', array('RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		
		$receiptFormat = $finHeadCounter->ABBR1 ."/".$datMonth."/".$finHeadCounter->ABBR2."/".$counter;
		$_SESSION['receiptFormat'] = $receiptFormat;
		
		$data = array(
			'TR_NO'=> $receiptFormat,
			'RECEIPT_DATE'=> date('d-m-Y'),
			'RECEIPT_NAME' => $this->input->post('name'),
			'RECEIPT_NUMBER' => $this->input->post('number'),
			'RECEIPT_EMAIL' => $this->input->post('email'),
			'RECEIPT_ADDRESS' => $this->input->post('address'),
			'RECEIPT_PAYMENT_METHOD'=> $this->input->post('modeOfPayment'),
			'CHEQUE_NO' => $chequeNo,
			'CHEQUE_DATE' => $chequeDate,
			'BANK_NAME' => $bank,
			'BRANCH_NAME' => $branch,
			'TRANSACTION_ID' => $transcId,
			'PAYMENT_STATUS'=>$paymentStatus,
			'FH_AMOUNT'=> $this->input->post('amount'),
			'TR_PAYMENT_METHOD_NOTES'=>$this->input->post('paymentNotes'),
			'FH_ID'=>$financialHeads[0],
			'FH_NAME'=>$financialHeads[1],
			'ENTERED_BY'=>$_SESSION['userId'],
			'ENTERED_BY_NAME'=>$_SESSION['userFullName'],
			'DATE_TIME' => date('d-m-Y H:i:s A'),
			'DATE' => date('d-m-Y'),
			'TR_ACTIVE'=>1,
			'HB_ID'=>0,
			'EOD_CONFIRMED_BY_ID'=>0,
			'AUTHORISED_STATUS '=>'No',//,
			'T_FGLH_ID' => $fglhBank,
			'RECEIPT_PAN_NO'=>$pan,
			'RECEIPT_ADHAAR_NO'=>$adhaar							//laz new ..
		);
		
		$receiptId = $this->obj_receipt->add_receipt_trust_modal($data);
		$_SESSION['receiptId'] = $receiptId;
		redirect('/TrustReceipt/receipt_newTrustPrint/');
			
	}

	
	//NEW TRUST RECEIPT PRINT 
	function receipt_newTrustPrint() {
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		
		//For Menu Selection
		$data['whichTab'] = "hallReceipt";
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
		
		$this->db->select()->from('TRUST_RECEIPT')
		->where(array('TRUST_RECEIPT.TR_ID'=>$receiptId));
		
		$query = $this->db->get();
		$data['trustCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();

		$this->load->view('header', $data);
		$this->load->view('trust/receipt_newTrustPrint');
		$this->load->view('footer_home');
	}
	
	//ALL RECEIPT
	function all_receipt($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');

		$data['whichTab'] = "hallReceipt";
		//unset
		unset($_SESSION['receipt']);
		unset($_SESSION['date']);
		unset($_SESSION['receiptNo']);
		
		$data['date'] = date("d-m-Y");
		$dateReceipt = date("d-m-Y");
		
		$data['whichTab'] = "hallReceipt";
		//NOTIFICATION
		
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		
		if(@$receipt == '') {
			$condition = array('TET_RECEIPT_DATE' => $dateReceipt); //,'TET_RECEIPT_ACTIVE'=>1
			$data['receipts_details'] = $this->obj_receipt->get_all_field_all_receipt($condition,"trust_event_receipt.TET_RECEIPT_ID","desc", 10,$start);
		}
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReceipt/all_receipt';
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
		
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		//pagination ends
		
		if(isset($_SESSION['All_Event_Receipt'])) {
			$this->load->view('header',$data);
			$this->load->view('trust/all_receipt');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function all_receiptSearch($start = 0) {
		$data['whichTab'] = "hallReceipt";
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		
		$data['whichTab'] = "hallReceipt";
		
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
			$condition = array('TET_RECEIPT_DATE' => $dateReceipt); //,'TET_RECEIPT_ACTIVE'=>1
			if($receiptNo != "")
				$like = $receiptNo;
			else
				$like= "";
			$data['receipts_details'] = $this->obj_receipt->get_all_field_all_receipt($condition, "TET_RECEIPT_ID","desc", 10,$start, $like);
		} else {
			if($receiptNo != "")
				$like = $receiptNo;
			else
				$like= "";
			$condition = array('TET_RECEIPT_DATE' => $dateReceipt, 'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID' => $receipt); //,'TET_RECEIPT_ACTIVE'=>1
			$data['receipts_details'] = $this->obj_receipt->get_all_field_all_receipt($condition, "TET_RECEIPT_ID","desc", 10,$start, $like);
		}
				
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReceipt/all_receiptSearch';
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
		
		$this->load->view('header',$data);
		$this->load->view('trust/all_receipt');
		$this->load->view('footer_home');
	}

	function getRashi() {
		$keyword = $_POST['keyword'];
		$this->db->select()->from('RASHI')->like('RASHI_NAME', $keyword, 'after');
		$query = $this->db->get();
		echo json_encode($query->result('array'));
	}
	
	//DISPLAY PAGE ALL TRUST RECEIPT
	function all_trust_receipt($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		// $this->output->enable_profiler(true);
		//For Menu Selection
		$data['whichTab'] = "hallReceipt";
		//unset
		unset($_SESSION['receipt']);
		unset($_SESSION['date']);
		unset($_SESSION['receiptNo']);
		
		$data['date'] = date("d-m-Y");
		$dateReceipt = date("d-m-Y");
		
		//FINANCIAL HEADS
		$conditionOne = array('FH_ACTIVE' => 1);
		$data['financialHeads'] = $this->obj_admin_settings->get_all_field_financial_details($conditionOne);
		
		if(@$receipt == '') {
			$condition = array('RECEIPT_DATE' => $dateReceipt); //,'TR_ACTIVE' => 1
			$data['TotalAmount'] = $this->obj_receipt->get_all_amount_trust($condition);
			$data['trust_details'] = $this->obj_receipt->get_all_field_all_receipt_trust($condition,"TR_ID","desc", 10,$start);
		}
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReceipt/all_trust_receipt';
		$config['total_rows'] = $this->obj_receipt->get_all_receipt_count_trust($condition);
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
		
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		//pagination ends
		
		if(isset($_SESSION['All_Trust_Receipt'])) {
			$this->load->view('header',$data);           
			$this->load->view('trust/all_trust_receipt');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//DISPLAY PAGE ALL TRUST RECEIPT ON FILTER
	function all_receiptSearch_trust($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		
		$data['whichTab'] = "hallReceipt";
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
			$condition = array('RECEIPT_DATE' => $dateReceipt); //,'TR_ACTIVE' => 1
			if($receiptNo != "")
				$like = $receiptNo;
			else
				$like= "";
			$data['TotalAmount'] = $this->obj_receipt->get_all_amount_trust($condition, "", "",$like);
			$data['trust_details'] = $this->obj_receipt->get_all_field_all_receipt_trust($condition, "TR_ID","desc", 10,$start, $like);
		} else {
			if($receiptNo != "")
				$like = $receiptNo;
			else
				$like= "";
			$condition = array('RECEIPT_DATE' => $dateReceipt, 'TRUST_RECEIPT.FH_ID' => $receipt); //,'TR_ACTIVE' => 1
			$data['TotalAmount'] = $this->obj_receipt->get_all_amount_trust($condition, "", "",$like);
			$data['trust_details'] = $this->obj_receipt->get_all_field_all_receipt_trust($condition, "TR_ID","desc", 10,$start, $like);
		}
				
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReceipt/all_receiptSearch_trust';
		$config['total_rows'] = $this->obj_receipt->get_all_receipt_count_trust($condition, '','',$like);
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
		
		$this->load->view('header',$data);
		$this->load->view('trust/all_trust_receipt');
		$this->load->view('footer_home');
	}
	
	public function check_eod_confirm_date_time(){
		$todayDate = date('d-m-Y');
		$this->db->select('EOD_CONFIRMED_DATE_TIME')->from('trust_receipt');
		$this->db->where('RECEIPT_DATE',$todayDate);
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
	//	print_r($data);
	}

	//*************************************** TRUST INKIND START ***************************************\\
	//TRUST_INKIND_CODE
	//RECEIPT FOR TRUST INKIND
	function receipt_inkind_trust() { 
		//For Menu Selection
		$data['whichTab'] = "hallReceipt";
		$data['inkind_item'] = $this->obj_receipt->get_all_field_inkind_items();
		if(isset($_SESSION['Deity/Event_Inkind'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/receipt_inkind_trust');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	//RECEIPT FOR TRUST INKIND SAVE
	function receipt_inkind_save_trust() {
		$_SESSION['duplicate'] = "no";
		
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
		
		$this->db->select()->from('TRUST_RECEIPT_CATEGORY')
		->join('TRUST_RECEIPT_COUNTER', 'TRUST_RECEIPT_CATEGORY.T_ACTIVE_RECEIPT_COUNTER_ID = TRUST_RECEIPT_COUNTER.T_RECEIPT_COUNTER_ID')
		->where(array('TRUST_RECEIPT_CATEGORY.T_RECEIPT_CATEGORY_ID'=>'4')); // here made the T_RECEIPT_CATEGORY_ID as 4 by adithya on 04-01-2024
		
		$query = $this->db->get();
		$trustCounter = $query->first_row();
		$counter = $trustCounter->T_RECEIPT_COUNTER;
		$counter += 1;
		
		$this->db->where('T_RECEIPT_COUNTER_ID',$trustCounter->T_ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('TRUST_RECEIPT_COUNTER', array('T_RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();
		$datMonth = $this->get_financial_year($dfMonth);
		
		$receiptFormat = $trustCounter->T_ABBR1 ."/".$datMonth."/".$trustCounter->T_ABBR2."/".$counter;
		
		$_SESSION['receiptFormat'] = $receiptFormat;
		
		$data = array(
			'TR_NO'=> $receiptFormat,
			'RECEIPT_DATE'=> date('d-m-Y'),
			'RECEIPT_NAME' => $this->input->post('name'),
			'RECEIPT_NUMBER' => $this->input->post('number'),
			'RECEIPT_EMAIL' => $this->input->post('email'),
			'RECEIPT_PAN_NO' => $this->input->post('panNo'),
			'RECEIPT_ADHAAR_NO' => $this->input->post('adhaarNo'),
			'RECEIPT_ADDRESS' => $this->input->post('address'),
			'RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentNotes'),
			'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'DATE_TIME' => date('d-m-Y H:i:s A'),
			'TR_ACTIVE'=>1,
			'RECEIPT_CATEGORY_ID'=>4,  //made this value 4 by adithya before it was 1
			'PAYMENT_STATUS'=>'Received',
			'AUTHORISED_STATUS'=>'No',
			'EOD_CONFIRMED_BY_ID'=>0,
			'POSTAGE_CHECK' => $postage,
			'POSTAGE_PRICE' => $postageAmt,
			'POSTAGE_GROUP_ID' => $postageGroup,
			'ADDRESS_LINE1' => $addressLine1,
			'ADDRESS_LINE2' => $addressLine2,
			'CITY' => $city,
			'COUNTRY' => $country,
			'PINCODE' => $pincode
		); 
		
		$receiptId = $this->obj_receipt->add_receipt_inkind_trust_modal($data);
		$_SESSION['receiptId'] = $receiptId;
		
		if($postage == 1) {
			$dataPostage = array(
				'RECEIPT_ID' => $receiptId,
				'POSTAGE_CATEGORY' => 4,
				'POSTAGE_STATUS' => 0,
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'DATE' => date('d-m-Y'));
			$this->db->insert('POSTAGE', $dataPostage);
		}
		
		//Getting Latest Inserted Receipt Id
		$insertReceipt = $this->obj_receipt->get_all_field_trust_receipt("","TR_ID","desc");
		
		$tableItemId = json_decode($_POST['tableItemId']);
		$tableItem = json_decode($_POST['tableItem']);
		$tableQty = json_decode($_POST['tableQty']);
		$tablePrice = json_decode($_POST['tablePrice']);
		$tableNotes = json_decode($_POST['tableNotes']);

		
		for($i = 0; $i < count($tableItemId); ++$i) {
			$itemArr = explode(' ', $tableQty[$i]); 
			$data_One = array(
				'T_RECEIPT_ID'=> $insertReceipt->TR_ID,
				'IK_ITEM_ID'=> $tableItemId[$i],
				'IK_ITEM_NAME'=> $tableItem[$i],
				'IK_ITEM_UNIT'=> $itemArr[1],
				'IK_ITEM_QTY'=> $itemArr[0],
				'IK_APPRX_AMT'=>$tablePrice[$i],
				'IK_ITEM_DESC'=>$tableNotes[$i]);
		
			$this->obj_receipt->add_receipt_inkind_offered_trust_modal($data_One);
		}
		
		echo "success";
	}

	function receipt_inkindPrint_trust() {
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		$data['whichTab'] = "hallReceipt";
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
		
		if(!isset($_SESSION['receiptId']) && isset($_SESSION['reload'])) {
            redirect('TrustReceipt/all_receipt');
			unset($_SESSION['reload']);
		}
		 
		$receiptFormat = @$_SESSION['receiptFormat'];
		$receiptId = $_SESSION['receiptId'];
		
		unset($_SESSION['receiptFormat']);
		unset($_SESSION['receiptId']);
		
		$_SESSION['reload'] = 'reload';
	
		$this->db->select()->from('TRUST_INKIND_OFFERED')
		->join('TRUST_RECEIPT', 'TRUST_INKIND_OFFERED.T_RECEIPT_ID = TRUST_RECEIPT.TR_ID')
		->where(array('TRUST_RECEIPT.TR_ID'=>$receiptId));
		
		$query = $this->db->get();
		$data['eventCounter'] = $query->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->load->view('header', $data);
		$this->load->view('trust/receipt_inkindPrint_trust');
		$this->load->view('footer_home');
	}
	//TRUST INKIND END
}
?>
