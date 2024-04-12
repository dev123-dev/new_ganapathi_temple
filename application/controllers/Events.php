<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Events extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Events_modal','obj_events',true);
		$this->load->model('admin_settings/Admin_setting_model','obj_admin_settings',true);		
		$this->load->model('Deity_model','obj_sevas',true);
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		$this->load->model('Receipt_modal','obj_receipt',true);
		$this->load->model('Shashwath_Model','obj_shashwath',true);
		$this->load->helper('date');
		date_default_timezone_set('Asia/Kolkata');

		if(!isset($_SESSION['userId']))
			redirect('login');

		if($_SESSION['trustLogin'] == 1)
			redirect('Trust');
		
		$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
    }
	
	public function index($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
		redirect('login');
       	$condition = "";
		$dateReceipt = date('d-m-Y');
		$or_condition = "";
		$data['date'] = $dateReceipt;
		$_SESSION['deityCount'] = $this->obj_sevas->get_seva_count(date("d-m-Y"));
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		unset($_SESSION['dateReceipt']);
		unset($_SESSION['name_phone']);
		
		//pagination
		$data['eventSeva'] = $this->obj_events->get_seva(10,$start, $dateReceipt, $condition, $or_condition);
		$this->load->library('pagination');
		$config['base_url'] = base_url().'Events/index';
		$config['total_rows']=$this->obj_events->get_seva_count($dateReceipt, $condition, $or_condition);
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
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		
		$data['event'] = $this->obj_events->getEvents();
		$data['whichTab'] = "eventSevas";
		
		if(isset($_SESSION['Event_Sevas'])) {
			$this->load->view('header',$data);
			$this->load->view('events');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function event_token() {
		//pagination ends
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		$data['event'] = $this->obj_events->getEvents();
		$condition = array('IS_TOKEN'=>1, 'ET_ACTIVE' => 1, 'ET_SEVA_PRICE_ACTIVE' => 1);
		$data['eventSevas'] = $this->obj_events->getTokenEventSeva($condition,'EVENT_SEVA.ET_SEVA_ID','DESC');
		$data['whichTab'] = "eventToken";
		if(isset($_SESSION['eventCounterRes'])) {
			$data['eventCounter'] = $_SESSION['eventCounterRes'];
			unset($_SESSION['eventCounterRes']);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(isset($_SESSION['Event_Token'])) {
			$this->load->view('header',$data);
			$this->load->view('event_token');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
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
	
	public function searchSeva($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		$condition = "";
		$dateReceipt = date('d-m-Y');
		$or_condition = "";
		
		if(@$_POST['name_phone'] != "" && @$_POST['date'] != "") {
			unset($_SESSION['dateReceipt']);
			unset($_SESSION['name_phone']);
			
			$name_phone = $_POST['name_phone'];
			$dateReceipt = $_POST['date'];
			$condition = array('EVENT_RECEIPT.ET_RECEIPT_NAME'=>$name_phone);
			$or_condition = array('EVENT_RECEIPT.ET_RECEIPT_PHONE'=>$name_phone);
			
			$data['name_phone'] = $name_phone;
			
		} else if(@$_POST['name_phone'] != "") {
			unset($_SESSION['dateReceipt']);
			unset($_SESSION['name_phone']);
			
			$name_phone = $_POST['name_phone'];
			$condition = array('EVENT_RECEIPT.ET_RECEIPT_NAME'=>$name_phone);
			$or_condition = array('EVENT_RECEIPT.ET_RECEIPT_PHONE'=>$name_phone);
			$data['name_phone'] = $name_phone;
		} else if(isset($_POST['date'])){
			unset($_SESSION['dateReceipt']);
			unset($_SESSION['name_phone']);
			$dateReceipt = $_POST['date'];
		}
		
		$data['date'] = $dateReceipt;
		if(@$_SESSION['dateReceipt'] == "") {
			$_SESSION['dateReceipt'] = @$dateReceipt;
			$data['date'] = $dateReceipt;
		} else {
			$dateReceipt = $_SESSION['dateReceipt'];
			$data['date'] = $dateReceipt;
		}
		
		if(@$_SESSION['name_phone'] == ""){
			$_SESSION['name_phone'] = @$name_phone;
		} else {
			$name_phone = @$_SESSION['name_phone'];
			$data['name_phone'] = $_SESSION['name_phone'];
			$condition = array('EVENT_RECEIPT.ET_RECEIPT_NAME'=>$name_phone);
			$or_condition = array('EVENT_RECEIPT.ET_RECEIPT_PHONE'=>$name_phone);
		}
		
		if(@$_SESSION['name_phone'] != "" && @$_SESSION['dateReceipt'] != "") {
			$name_phone = $_SESSION['name_phone'];
			$dateReceipt = $_SESSION['dateReceipt'];
			$condition = array('EVENT_RECEIPT.ET_RECEIPT_NAME'=>$name_phone);
			$or_condition = array('EVENT_RECEIPT.ET_RECEIPT_PHONE'=>$name_phone);
			$data['name_phone'] = $name_phone;
		}
		
		//pagination
		$data['eventSeva'] = $this->obj_events->get_seva(10,$start, $dateReceipt, $condition, $or_condition);
		$this->load->library('pagination');
		$config['base_url'] = base_url().'Events/searchSeva';
		$config['total_rows']=$this->obj_events->get_seva_count($dateReceipt, $condition, $or_condition);
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
		
		$data['event'] = $this->obj_events->getEvents();
		$data['whichTab'] = "eventSevas";
		
		$this->load->view('header',$data);
		$this->load->view('events');
		$this->load->view('footer_home');
	}
	
	public function event_receipt() {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		if(@$_SESSION['eventActiveCount'] == 0)
		   redirect('login');
		//SLAP
		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..
		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);

		//NOTIFICATION
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		$data['event'] = $this->obj_events->getEvents();
		$data['eventSeva'] = $this->obj_events->getEventSeva();
		$conditionTwo = array('EVENT.ET_ACTIVE' => 1); 
		$data['activeDate'] = $this->obj_admin_settings->get_all_field_event($conditionTwo); 
		$data['whichTab'] = "receipt";
		
		if(isset($_SESSION['Event_Seva'])) {
			$this->load->view('header',$data);
			$this->load->view('event_receipt');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	public function generateSevaReceipt() {
		$_SESSION['duplicate'] = "no";//Prevents duplicate sessions
		$name = $_POST['name'];//name of the sevadhaar
		$modeOfPayment = $_POST['modeOfPayment'];//cash/cheque/Debit or Credit/Direct credit
		$branch = $_POST['branch'];//
		$chequeNo = $_POST['chequeNo'];//First six digits in the bottom-left 
		$bank = $_POST['bank'];//bank of sevadhaar where cheque belongs to
		$chequeDate = $_POST['chequeDate'];//Date of payment
		$transactionId = $_POST['transactionId'];//16 digit no. in POS slip
		$fglhBank = @$_POST['fglhBank'];							//slap //laz new
		$tableSevaCombo = json_decode($_POST['tableSevaCombo']);//Event seva name,  Jason encoded because to group all, if quantity is more than 1
		$tableQty = json_decode($_POST['tableQty']);//Quantity
		$tableDate = json_decode($_POST['tableDate']);//Date on receipt
		$tablePrice = json_decode($_POST['tablePrice']);//Seva Amount
		$tableAmt = json_decode($_POST['tableAmt']);//not specified
		$hiddenEventId = json_decode($_POST['hiddenEventId']);//Event ID
		$hiddenIsSeva = json_decode($_POST['hiddenIsSeva']);//if seva is set to 1, if prasad set to 0 
		$number = $_POST['number'];//Phone number of sevadhaar
		$totalAmt = $_POST['totalAmt'];//Total amount of number of all quantity of sevas(or Total seva amount)
		$rashi = $_POST['rashi'];//rashi of sevadhaar 
		$nakshatra = $_POST['nakshatra'];//nakshatra of sevadhaar
		$etId = $_POST['etId'];//event id 
		$etName = $_POST['etName'];//event name 
		$paymentNotes = $_POST['paymentNotes'];//any notes about payment
		$todayDate = date('d-m-Y');//current date
		$dateTime = date('d-m-Y H:i:s A');//current date and time
		$matchedDate = "";
		$totalSevaLimit = 0;
		$limitStock = 0;
		$sevaLimitStock = 0;
		
		$this->db->select()->from('EVENT_RECEIPT_CATEGORY')
		->join('EVENT_RECEIPT_COUNTER', 'EVENT_RECEIPT_CATEGORY.ET_ACTIVE_RECEIPT_COUNTER_ID = EVENT_RECEIPT_COUNTER.ET_RECEIPT_COUNTER_ID')
		->where(array('EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID'=>'1'));//The above query is to get ET_ABBR1 & ET_ABBR2 (In order to generate Receipt Number).
		
		$query = $this->db->get();
		$eventCounter = $query->first_row();
		$counter = $eventCounter->ET_RECEIPT_COUNTER;//counter value is 94
		$counter += 1;//counter value is 95
		$this->db->where('ET_RECEIPT_COUNTER_ID',$eventCounter->ET_ACTIVE_RECEIPT_COUNTER_ID);
		$this->db->update('EVENT_RECEIPT_COUNTER', array('ET_RECEIPT_COUNTER'=>$counter));
		$dfMonth = $this->obj_admin_settings->get_financial_month();//getting Financial month
		$datMonth = $this->get_financial_year($dfMonth);//getting financial year
		$receiptFormat = $eventCounter->ET_ABBR1 ."/".$datMonth."/".$eventCounter->ET_ABBR2."/".$counter;//generate receipt number
		$_SESSION['receiptFormat'] = $receiptFormat;
		
	for($i = 0; $i < count($tableSevaCombo);++$i) {
		if(intval(trim($tableQty[$i])) != "" && trim($tableDate[$i]) != ""){//json encoded values are trimmed 
		    $where = array(
				'ET_SO_SEVA_ID'=>trim($hiddenEventId[$i]),//json encoded values are trimmed 
				'ET_SO_DATE'=>trim($tableDate[$i])//json encoded values are trimmed 
		    );
			$sevaOffered = $this->obj_events->getSevaOffered($where);//returns a database row pertaining to the $tableDate
			$sevaOfferedLength = count($sevaOffered);//Count all elements in an array (database table is returned as an array)
			$where = array(
			    'ET_SEVA_ID'=>trim($hiddenEventId[$i])//EVENT_SEVA_ID is equated with event id
			);
			$sevaLimit = $this->obj_events->getSevaLimit($where);//query not working
			if(count($sevaLimit) > 0) {//true
				for($j = 0; $j < count($sevaLimit); ++$j) {//
				    if($sevaLimit[$j]['ET_SEVA_DATE'] == trim($tableDate[$i])) {
						$totalSevaLimit = (intval($sevaLimit[$j]['ET_SEVA_LIMIT']) - intval($sevaOfferedLength) - intval(trim($tableQty[$i])));
						$matchedDate.=$sevaLimit[$j]['ET_SEVA_DATE'];	/*Example: concatenation assignment  $txt1 = "Hello"; $txt2 = "world!"; $txt1.= $txt2;  echo $txt1; Result: Hello World!*/
						break;
					}
				}
		    }
		    if($totalSevaLimit < 0) {
					echo "limit|".$tableSevaCombo[$i]."|".$tableDate[$i]; 
					exit;
			}
		} else {		
			$isSeva = intval(trim($hiddenIsSeva[$i]));
			if($isSeva != 1) {
						$where = array(
							'ET_SEVA_ID'=>trim($hiddenEventId[$i]),
							'ET_IS_SEVA'=>$isSeva
						);
			} else {			
					$where = array(
					'ET_SEVA_ID'=>trim($hiddenEventId[$i])
				);
			}
			$sevaLimit = $this->obj_events->getSevaLimit($where);
			//var_dump($sevaLimit);
			if(count($sevaLimit) > 0) {
				for($j = 0; $j < count($sevaLimit); ++$j) {
				$limitStock = (intval($limitStock) + intval($sevaLimit[$j]['ET_SEVA_LIMIT']));
				}
			}
			if($isSeva != 1) {
				$where = array(
					'ET_SO_SEVA_ID'=>trim($hiddenEventId[$i]),
					'ET_SO_IS_SEVA'=>$isSeva
					); 
			} else {
					$where = array(
					'ET_SO_SEVA_ID'=>trim($hiddenEventId[$i])
				); 
			}
					
			$sevaStock = $this->obj_events->getStock($where);
			//var_dump($sevaStock);
			if(count($sevaStock) > 0) {
				for($j = 0; $j < count($sevaStock); ++$j) {
				$sevaLimitStock = (intval($sevaLimitStock) + intval($sevaStock[$j]['ET_SO_QUANTITY'])); 
				}
			}
			$totalStock = (intval($limitStock) - intval($sevaLimitStock));
			$totalStock = (intval($totalStock) - intval(trim($tableQty[$i])));
						
			if($totalStock < 0)/*if($totalStock==0)*/ {
				echo "stock|".$tableSevaCombo[$i];
				exit;
			}
		}
	}
		if($modeOfPayment == "Cheque") {
			$paymentStatus = "Pending";
		} else {
		  $paymentStatus = "Completed";
		}
		
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
		$address = $_POST['address'];
		
		$data = array(
			'ET_RECEIPT_NAME'=>$name,
			'ET_RECEIPT_NO'=>$receiptFormat,
			'ET_RECEIPT_DATE'=>$todayDate,
			'ET_RECEIPT_PHONE'=>$number,
			'ET_RECEIPT_PAYMENT_METHOD'=>$modeOfPayment,
			'BRANCH_NAME'=>$branch,
			'CHEQUE_NO'=>$chequeNo,
			'BANK_NAME'=>$bank,
			'CHEQUE_DATE'=>$chequeDate,
			'ET_RECEIPT_PRICE'=>$totalAmt,
			'TRANSACTION_ID'=>$transactionId,
			'ET_RECEIPT_PAYMENT_METHOD_NOTES'=>$paymentNotes,
			'ET_RECEIPT_RASHI'=>$rashi,
			'ET_RECEIPT_NAKSHATRA'=>$nakshatra,
			'RECEIPT_ET_ID'=>$etId,
			'RECEIPT_ET_NAME'=>$etName,
			'ET_RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
			'ET_RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
			'EOD_CONFIRMED_BY_ID'=>0,
			'DATE_TIME' => $dateTime,
			'ET_RECEIPT_ACTIVE'=>1,
			'ET_RECEIPT_CATEGORY_ID'=>1,
			'PAYMENT_STATUS'=>$paymentStatus,
			'AUTHORISED_STATUS'=>'No',
			'ET_RECEIPT_ADDRESS' => $address,
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
		
		$this->db->insert('EVENT_RECEIPT', $data);
		$EVENT_RECEIPT = $this->db->insert_id();
		
		$dataPostage = array(
				'RECEIPT_ID' => $EVENT_RECEIPT,
				'POSTAGE_CATEGORY' => 2,
				'POSTAGE_STATUS' => 0,
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'DATE' => date('d-m-Y'));
		$this->db->insert('POSTAGE', $dataPostage);
		
		for($i = 0; $i < count($tableSevaCombo); ++$i) {
		    if(intval(trim($tableQty[$i])) != "" && trim($tableDate[$i]) != "") {
				$data = array(
					'ET_SO_SEVA_NAME'=>$tableSevaCombo[$i],
					'ET_SO_SEVA_ID'=>$hiddenEventId[$i],
					'ET_SO_DATE'=>$tableDate[$i],
					'ET_SO_PRICE'=>$tablePrice[$i],
					'ET_RECEIPT_ID'=>$EVENT_RECEIPT,
					'ET_SO_IS_SEVA'=>$hiddenIsSeva[$i]
				);
				
				for($j = 0; $j < intval(trim($tableQty[$i])); ++$j) {
					$this->db->insert('EVENT_SEVA_OFFERED', $data);
					$sevaOfferedID = $this->db->insert_id();
				}
			} else {
				$data = array(
					'ET_SO_SEVA_NAME'=>$tableSevaCombo[$i],
					'ET_SO_SEVA_ID'=>$hiddenEventId[$i],
					'ET_SO_QUANTITY'=>$tableQty[$i],
					'ET_SO_PRICE'=>$tablePrice[$i],
					'ET_RECEIPT_ID'=>$EVENT_RECEIPT,
					'ET_SO_IS_SEVA'=>$hiddenIsSeva[$i]
				);
				
				$this->db->insert('EVENT_SEVA_OFFERED', $data);
				$sevaOfferedID = $this->db->insert_id();
			} 
		}
		
		$_SESSION['deityCount'] = $this->obj_sevas->get_seva_count(date("d-m-Y"));
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		
		echo "success|1";
		
	}
	
	public function getSevaLimit() {
		$idName = $_POST['idName']; 
		
		if(isset($_POST['fromEditReceiptPrint'])) {
			$where = array(
				'ET_SEVA_ID'=>$idName
			);
		} else {
			$isSeva = @$_POST['stock'];
			$where = array(
				'ET_SEVA_ID'=>$idName,
				'ET_IS_SEVA'=>$isSeva
			);
		} 
		
		$sevaLimit = $this->obj_events->getSevaLimit($where);
		
		echo json_encode($sevaLimit);
		
	}
	
	public function getSevaOffered() {
		$id = $_POST['id']; 
		$sevadate = $_POST['sevadate'];
		
		$where = array(
			'ET_SO_SEVA_ID'=>$id,
			'ET_SO_DATE'=>$sevadate
		);

		$sevaOffered = $this->obj_events->getSevaOffered($where);

		echo json_encode($sevaOffered);
		
	}
	
	public function getStock() {
		$id = $_POST['id']; 
		$isSeva = $_POST['stock']; 
		
		
		$where = array(
			'ET_SO_SEVA_ID'=>$id,
			'ET_SO_IS_SEVA'=>$isSeva
		); 
		
		$sevaStock = $this->obj_events->getStock($where);

		echo json_encode($sevaStock);
	}
	
	public function saveEventPrintHistory() {
		$receiptId = @$_POST['receiptId'];
		$printstatus = $this->input->post('printStatus');
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$deviceIP = $this->input->ip_address();
		
		/*I put these lines which are required 
		to show reprint*/
		$data2 = array(
		'PRINT_STATUS' => $printstatus
		);
		
		$where = array('ET_RECEIPT_ID' => $receiptId);
		$this->db->where($where);
		$this->db->update('EVENT_RECEIPT',$data2);

		$dataInsert = array(
			'RECEIPT_ID' => $receiptId,
			'DATE_TIME'=>$dateTime,
			'USER_ID'=>$_SESSION['userId'],
			'DATE'=>$todayDate
		);
		$this->db->insert('EVENT_PRINT_HISTORY', $dataInsert);
		$insertId = $this->db->insert_id();
	}
	
	public function printSevaReceipt($receiptNo = "") {
		$data['whichTab'] = "receipt";
		$data['duplicate'] = @$_SESSION['duplicate'];
		unset($_SESSION['duplicate']);
		
		if(isset($_SESSION['receiptFormat'])) {
			$receiptNo = $_SESSION['receiptFormat'];
			unset($_SESSION['receiptFormat']);
		} else if(isset($_POST['receiptNo'])) {
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_POST['receiptNo'];
		} else if(isset($_POST['receiptFormat2'])) {
			$data['fromAllReceipt'] = "1";
			$receiptNo = $_POST['receiptFormat2'];
		} else { 
			redirect("Events");
		}
		
		//$this->output->enable_profiler(true);
		$this->db->select()->from('EVENT_RECEIPT')
		->join('EVENT_SEVA_OFFERED', 'EVENT_SEVA_OFFERED.ET_RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID')
		->where(array('EVENT_RECEIPT.ET_RECEIPT_NO'=>$receiptNo));
		
		$query = $this->db->get();
		$data['eventCounter'] = $query->result("array");
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->load->view('header',$data);
		$this->load->view('printSevaReceipt');
		$this->load->view('footer_home');
	}
	
	public function editReceipt($id = "BSM/2017-18/SN/220") {
	//pagination ends
		if(isset($_POST['receiptNo'])){
			$id = $_POST['receiptNo'];
		}
		$this->db->select()->from('EVENT_RECEIPT')
		->join('EVENT_SEVA_OFFERED', 'EVENT_SEVA_OFFERED.ET_RECEIPT_ID = EVENT_RECEIPT.ET_RECEIPT_ID')
		->where(array('EVENT_RECEIPT.ET_RECEIPT_NO'=>$id));
		
		$query = $this->db->get();
		$data['eventCounter'] = $query->result("array");
		
		$conditionTwo = array('EVENT.ET_ACTIVE' => 1); 
		$data['activeDate'] = $this->obj_admin_settings->get_all_field_event($conditionTwo); 
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->load->view('header',$data);
		$this->load->view('editReceipt');
		$this->load->view('footer_home');
	}
	
	public function updateReceipt() {
		
		if(isset($_POST['updateId'])) {
			$id = $_POST['updateId'];
		}
		
		if(isset($_POST['multiDatehidden'])) {
			$multiDate = $_POST['multiDatehidden'];
		}
		
		$this->db->where('ET_SO_ID',$id);
		$this->db->update('EVENT_SEVA_OFFERED', array('ET_UPDATED_SO_DATE'=>$multiDate,'ET_SO_DATE'=>$multiDate,'ET_UPDATED_BY_ID'=>$_SESSION['userId']));
		
		echo "success";
	}
	
	public function check_event_eod_confirm_time(){
		$todayDate = date('d-m-Y');
		$this->db->select('EOD_CONFIRMED_DATE_TIME')->from('EVENT_RECEIPT');
		$this->db->where('ET_RECEIPT_DATE',$todayDate);
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