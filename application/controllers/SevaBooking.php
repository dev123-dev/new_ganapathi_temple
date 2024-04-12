<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class SevaBooking extends CI_Controller {
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('Users_model','user',true);
			$this->load->model('Events_modal','obj_events',true);		
			$this->load->model('Deity_model','obj_sevas',true); 
			$this->load->model('Receipt_modal','obj_receipt',true);	
			$this->load->model('Booking_model','obj_booking',true);	
			$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);	
			$this->load->model('Shashwath_Model','obj_shashwath',true);
			if(!isset($_SESSION['userId']))
				redirect('login');
			
			if($_SESSION['trustLogin'] == 1)
				redirect('Trust');

			$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
			$query = $this->db->get();
			$_SESSION['eventActiveCount'] = $query->num_rows();
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
			unset($_SESSION['paymentMethod']);
			
			$data['whichTab'] = "booking";
			$data['date'] = date("d-m-Y");
			
			$condition = array('SO_DATE' => date("d-m-Y"));
			$data['getBooking'] = $this->obj_booking->get_all_field_booking($condition,'SB_ID','DESC', 10,$start);
			
			$data['Count'] = $this->obj_booking->get_booking_count($condition);
			
			//FOR TOTAL IN COMBOBOX
			$condt = array('SO_DATE' => date("d-m-Y"));
			$data['All'] = $this->obj_booking->get_booking_count($condt);
			$condt1 = array('SB_PAYMENT_STATUS' => 0 ,'SO_DATE' => date("d-m-Y"));
			$data['Pending'] = $this->obj_booking->get_booking_count($condt1);
			$condt2 = array('SB_PAYMENT_STATUS' => 1 ,'SO_DATE' => date("d-m-Y"));
			$data['Completed'] = $this->obj_booking->get_booking_count($condt2);
			$condt3 = array('SB_PAYMENT_STATUS' => 3 ,'SO_DATE' => date("d-m-Y"));
			$data['Cancelled'] = $this->obj_booking->get_booking_count($condt3);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'SevaBooking/index/';
			$config['total_rows'] = $this->obj_booking->get_booking_count($condition);
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
			
			if(isset($_SESSION['All_Booked_Sevas'])) {
				$this->load->view('header',$data);
				$this->load->view('seva_booking');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		public function BookedPendingReceipt($start=0)
		{
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			$data['name_phone'] = '';
			unset($_SESSION['name_phone']);
			$data['whichTab'] = "booking";

			$data['Count'] = $this->obj_booking->get_booking_pending_count();
			$condition="";
			$data['PendingReceipt'] = $this->obj_booking->get_pending_Receipt($condition,10,$start); 
			$this->load->library('pagination');
			$config['base_url'] = base_url().'SevaBooking/BookedPendingReceipt/';
			$config['total_rows']= $this->obj_booking->get_booking_pending_count(); 
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


			//$data['PendingReceipt'] = $this->obj_booking->get_pending_Receipt();
			$this->load->view('header',$data);           
			$this->load->view('Booked_Pending_Receipt');
			$this->load->view('footer_home');
		}

		public function BookedPendingOnSearch($start=0){
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;

			$data['whichTab'] = "booking";
			
			if(@$_POST['name_phone'] || @$_POST['name_phone'] == "") {
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

			if($name_phone != "") {
				$queryString = "and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
					$condition = $queryString;
			} else{
				$condition = "";
			}
			$data['Count'] = $this->obj_booking->get_booking_pending_count($condition);
			$this->load->library('pagination');
			$data['PendingReceipt'] = $this->obj_booking->get_pending_Receipt($condition,10,$start); 
			$config['base_url'] = base_url().'SevaBooking/BookedPendingReceipt/';
			$config['total_rows']= $this->obj_booking->get_booking_pending_count($condition); 
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
			$this->load->view('Booked_Pending_Receipt');
			$this->load->view('footer_home');
		}

		//FOR EXCEL FOR BOOKING PENDING
		function create_pendingBooking_Excel() {
			
			$header = "";
			$result = ""; 
			$filename = "Seva_Booked_Pending_Report";  //File Name
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
			$header .= "SEVA DATE" . "\t";
			$header .= "BOOKING NO." . "\t";
			$header .= "NAME" . "\t";
			$header .= "ADDRESS" . "\t";
			$header .= "DEITY" . "\t";
			$header .= "SEVA" . "\t";	
			$header .= "AMOUNT" . "\t";	
			$header .= "DATE" . "\t";	
			$header .= "PAYMENT STATUS" . "\t";	
			
			
			if($_POST['namephone'] != "") {
				$queryString = " AND (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; 
				$condition = $queryString; 
				$res = $this->obj_booking->get_all_pending_booking_report($condition);
			} else {
				$res = $this->obj_booking->get_all_pending_booking_report();
			}

			for($i = 0; $i < sizeof($res); $i++)
			{
				$line = '';    
				$value = "";			
				$value .= '"' . ($i+1) . '"' . "\t";
				$value .= '"' . $res[$i]->SO_DATE . '"' . "\t";
				$value .= '"' . $res[$i]->SB_NO . '"' . "\t";
				$value .= '"' . $res[$i]->SB_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->SB_ADDRESS . '"' . "\t";
				$value .= '"' . $res[$i]->SO_DEITY_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->SO_SEVA_NAME . '"' . "\t";
				if($res[$i]->SO_PRICE == "0") {
					$value .= '' . "\t";
				} else {
					$value .= '"' . $res[$i]->SO_PRICE . '"' . "\t";
				}
				$value .= '"' . $res[$i]->SB_DATE . '"' . "\t";
				if($res[$i]->SB_PAYMENT_STATUS == "0") {
					$value .= 'Pending' . "\t";
				} else if($res[$i]->SB_PAYMENT_STATUS == "1") {
					$value .= 'Completed' . "\t";
				} else if($res[$i]->SB_PAYMENT_STATUS == "3") {
					$value .= 'Cancelled' . "\t";
				}

				
				$line .= $value;
				$result .= trim($line) . "\n";
			}
			$result = str_replace( "\r" , "" , $result );
			   
			print("$header\n$result"); 
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
		
		//FOR EXCEL FOR RECEIPT
		function seva_booking_report_excel() {
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}

			if(isset($_POST['allDates'])) {
				$allDates= @$_POST['allDates'];
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			$header = "";
			$result = ""; 
			if(@$radioOpt == "multiDate")
				$filename = "Seva_Booking_Report from ".$_SESSION['fromDate']." to ".$_SESSION['toDate'];  //File Name
			else
				$filename = "Seva_Booking_Report_".$_POST['dateField'];  //File Name
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
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";
			$header .= "SI NO." . "\t";
			$header .= "SEVA DATE" . "\t";
			$header .= "BOOKING NO." . "\t";
			$header .= "NAME" . "\t";
			$header .= "ADDRESS" . "\t";
			$header .= "DEITY" . "\t";
			$header .= "SEVA" . "\t";	
			$header .= "AMOUNT" . "\t";	
			$header .= "DATE" . "\t";	
			$header .= "PAYMENT STATUS" . "\t";	
			
			if($_POST['payMode'] == 'Pending') {
				$paymentMode = 0;
			} else if($_POST['payMode'] == 'Completed') {
				$paymentMode = 1;
			} else if($_POST['payMode'] == 'All') {
				$paymentMode = 2;
			} else if($_POST['payMode'] == 'Cancelled') {
				$paymentMode = 3;
			}
			
			if($_POST['dateField'] != "" && $paymentMode == "2" && $_POST['namephone'] == "") {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0)
							$queryString .= "SO_DATE='".$allDates1[$i]."'";
						else
							$queryString .= " or SO_DATE='".$allDates1[$i]."'";
					}
					$condition= $queryString;
				} else {
					$condition= array('SO_DATE' => $_POST['dateField']);
				}
				$res = $this->obj_booking->get_all_field_booking_report($condition);
			} else if($_POST['dateField'] != "" && $paymentMode != "2" && $_POST['namephone'] != "") {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0)
							$queryString .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS='".$paymentMode."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						else
							$queryString .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS='".$paymentMode."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					}
					$condition= $queryString;
				} else {
					$queryString = " SO_DATE='".$_POST['dateField']."' and SB_PAYMENT_STATUS ='".$paymentMode."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; 
					$condition = $queryString; 
				}
				$res = $this->obj_booking->get_all_field_booking_report($condition);
			} else if($_POST['dateField'] != "" && $_POST['namephone'] != "" && $paymentMode == "2") {	
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0)
							$queryString .= "SO_DATE='".$allDates1[$i]."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; 
						else
							$queryString .= " or SO_DATE='".$allDates1[$i]."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; 
					}
					$condition = $queryString;
				} else {
					$queryString = " SO_DATE='".$_POST['dateField']."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; 
					$condition = $queryString;
				}
				$res = $this->obj_booking->get_all_field_booking_report($condition);
			} else if($_POST['dateField'] != "" && $paymentMode != "2" && $_POST['namephone'] == "") {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0)
							$queryString .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS='".$paymentMode."'";
						else
							$queryString .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS='".$paymentMode."'";
					}
					$condition= $queryString;
				} else {
					$condition= array('SB_PAYMENT_STATUS' => $paymentMode,'SO_DATE' => $_POST['dateField']);
				}
				$res = $this->obj_booking->get_all_field_booking_report($condition);
			}
						
			for($i = 0; $i < sizeof($res); $i++)
			{
				$line = '';    
				$value = "";			
				$value .= '"' . ($i+1) . '"' . "\t";
				$value .= '"' . $res[$i]->SO_DATE . '"' . "\t";
				$value .= '"' . $res[$i]->SB_NO . '"' . "\t";
				$value .= '"' . $res[$i]->SB_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->SB_ADDRESS . '"' . "\t";
				$value .= '"' . $res[$i]->SO_DEITY_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->SO_SEVA_NAME . '"' . "\t";
				if($res[$i]->SO_PRICE == "0") {
					$value .= '' . "\t";
				} else {
					$value .= '"' . $res[$i]->SO_PRICE . '"' . "\t";
				}
				$value .= '"' . $res[$i]->SB_DATE . '"' . "\t";
				if($res[$i]->SB_PAYMENT_STATUS == "0") {
					$value .= 'Pending' . "\t";
				} else if($res[$i]->SB_PAYMENT_STATUS == "1") {
					$value .= 'Completed' . "\t";
				} else if($res[$i]->SB_PAYMENT_STATUS == "3") {
					$value .= 'Cancelled' . "\t";
				}

				
				$line .= $value;
				$result .= trim($line) . "\n";
			}
			$result = str_replace( "\r" , "" , $result );
			   
			print("$header\n$result"); 
		}
		
		//ON DATEFIELD CHANGE AND SEARCH 
		function seva_booking_on_change_date($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			//SESSION UNSET
			unset($_SESSION['name_phone']);
			
			//For Menu Selection
			$data['whichTab'] = "booking";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['allDates'])) {
				$allDates= @$_POST['allDates'];
				$_SESSION['allDates'] = $allDates;
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			$data['radioOpt'] = $radioOpt;
			$data['allDates'] = $allDates;
			
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
			
			if(@$_POST['paymentMethod']) {
				unset($_SESSION['paymentMethod']);
				$data['PMode'] = $this->input->post('paymentMethod');
				$paymentMode = $this->input->post('paymentMethod');
			}
			
			if(@$_SESSION['paymentMethod'] == "") {
				$this->session->set_userdata('paymentMethod', $this->input->post('paymentMethod'));
				$data['PMode'] = $_SESSION['paymentMethod'];
				$paymentMode = $this->input->post('paymentMethod');
			} else {
				$paymentMode = $_SESSION['paymentMethod'];
				$data['PMode'] = $_SESSION['paymentMethod'];
			}
			
			if($paymentMode == 'Pending') {
				$paymentMode = 0;
			} else if($paymentMode == 'Completed') {
				$paymentMode = 1;
			} else if($paymentMode == 'All') {
				$paymentMode = 2;
			} else if($paymentMode == 'Cancelled') {
				$paymentMode = 3;
			}
			
			if(($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3) && $name_phone != "") {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							if(($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3) && $name_phone != "") {
								$queryString .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS=".$paymentMode." and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
							} else {
								$queryString .= "SO_DATE='".$allDates1[$i]."'";
							}
						} else {
							if(($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3) && $name_phone != "") {
								$queryString .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS=".$paymentMode." and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
							} else {
								$queryString .= " or SO_DATE='".$allDates1[$i]."'";
							}
						}
					}
					$condition = $queryString;
				} else {
					$queryString = "";
					if(($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3) && $name_phone != "") {
						$queryString .= "SO_DATE='".$date."' and SB_PAYMENT_STATUS=".$paymentMode." and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
					} else {
						$queryString .= "SO_DATE='".$date."'";
					}
					$condition = $queryString;
				}
				
				//FOR PRICE DISPLAY IN COMBOBOX
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					$queryString2 = "";
					$queryString3 = "";
					
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							if(($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3) && $name_phone != "") {
								$queryString .= "SO_DATE='".$allDates1[$i]."' and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString1 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString2 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString3 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
							} else {
								$queryString .= "SO_DATE='".$allDates1[$i]."'";
								$queryString1 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0";
								$queryString2 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1";
								$queryString3 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3";
							}
						} else {
							if(($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3) && $name_phone != "") {
								$queryString .= " or SO_DATE='".$allDates1[$i]."' and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString1 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString2 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString3 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
							} else {
								$queryString .= " or SO_DATE='".$allDates1[$i]."'";
								$queryString1 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0";
								$queryString2 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1";
								$queryString3 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3";
							}
						}
					}
					$condt = $queryString;
					$condt1 = $queryString1;
					$condt2 = $queryString2;
					$condt3 = $queryString3;
				} else {
					if(($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3) && $name_phone != "") {
						$condt = "SO_DATE='".$date."' and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
						$condt1 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 0 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
						$condt2 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 1 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
						$condt3 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 3 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
					} else {
						$condt = "SO_DATE='".$date."'";
						$condt1 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 0";
						$condt2 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 1";
						$condt3 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 3";
					}
				}
			} else if($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3) {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							if(($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3)) {
								$queryString .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS=".$paymentMode."";
							} else {
								$queryString .= "SO_DATE='".$allDates1[$i]."'";
							}
						} else {
							if(($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3)) {
								$queryString .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS=".$paymentMode."";
							} else {
								$queryString .= " or SO_DATE='".$allDates1[$i]."'";
							}
						}
					}
					$condition = $queryString;
				} else {
					$queryString = "";
					if(($paymentMode == 0 || $paymentMode == 1 || $paymentMode == 3)) {
						$queryString .= "SO_DATE='".$date."' and SB_PAYMENT_STATUS=".$paymentMode."";
					} else {
						$queryString .= "SO_DATE='".$date."'";
					}
					$condition = $queryString;
				}
				
				//FOR PRICE DISPLAY IN COMBOBOX
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					$queryString2 = "";
					$queryString3 = "";
					
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "SO_DATE='".$allDates1[$i]."'";
							$queryString1 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0";
							$queryString2 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1";
							$queryString3 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3";
						} else {
							$queryString .= " or SO_DATE='".$allDates1[$i]."'";
							$queryString1 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0";
							$queryString2 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1";
							$queryString3 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3";
						}
					}
					$condt = $queryString;
					$condt1 = $queryString1;
					$condt2 = $queryString2;
					$condt3 = $queryString3;
				} else {
					$condt = "SO_DATE='".$date."'";
					$condt1 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 0";
					$condt2 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 1";
					$condt3 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 3";
				}
			} else if($name_phone != "") {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							if($name_phone != "") {
								$queryString .= "SO_DATE='".$allDates1[$i]."' and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
							} else {
								$queryString .= "SO_DATE='".$allDates1[$i]."'";
							}
						} else {
							if($name_phone != "") {
								$queryString .= " or SO_DATE='".$allDates1[$i]."' and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
							} else {
								$queryString .= " or SO_DATE='".$allDates1[$i]."'";
							}
						}
					}
					$condition = $queryString;
				} else {
					$queryString = "";
					if($name_phone != "") {
						$queryString .= "SO_DATE='".$date."' and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
					} else {
						$queryString .= "SO_DATE='".$date."'";
					}
					$condition = $queryString;
				}
				
				//FOR PRICE DISPLAY IN COMBOBOX
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					$queryString2 = "";
					$queryString3 = "";
					
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							if($name_phone != "") {
								$queryString .= "SO_DATE='".$allDates1[$i]."' and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString1 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString2 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString3 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
							} else {
								$queryString .= "SO_DATE='".$allDates1[$i]."'";
								$queryString1 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0";
								$queryString2 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1";
								$queryString3 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3";
							}
						} else {
							if($name_phone != "") {
								$queryString .= " or SO_DATE='".$allDates1[$i]."' and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString1 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString2 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
								$queryString3 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
							} else {
								$queryString .= " or SO_DATE='".$allDates1[$i]."'";
								$queryString1 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0";
								$queryString2 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1";
								$queryString3 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3";
							}
						}
					}
					$condt = $queryString;
					$condt1 = $queryString1;
					$condt2 = $queryString2;
					$condt3 = $queryString3;
				} else {
					if($name_phone != "") {
						$condt = "SO_DATE='".$date."' and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
						$condt1 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 0 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
						$condt2 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 1 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
						$condt3 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 3 and (SB_NAME LIKE '%".$name_phone."%' OR SB_PHONE LIKE '%".$name_phone."%')";
					} else {
						$condt = "SO_DATE='".$date."'";
						$condt1 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 0";
						$condt2 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 1";
						$condt3 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 3";
					}
				}
			} else {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0)
							$queryString .= "SO_DATE='".$allDates1[$i]."'";
						else
							$queryString .= " or SO_DATE='".$allDates1[$i]."'";
					}
					$condition = $queryString;
				} else {
					$condition = array('SO_DATE' => $date);
				}
				
				//FOR PRICE DISPLAY IN COMBOBOX
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					$queryString2 = "";
					$queryString3 = "";
					
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "SO_DATE='".$allDates1[$i]."'";
							$queryString1 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0";
							$queryString2 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1";
							$queryString3 .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3";
						} else {
							$queryString .= " or SO_DATE='".$allDates1[$i]."'";
							$queryString1 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 0";
							$queryString2 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 1";
							$queryString3 .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS= 3";
						}
					}
					$condt = $queryString;
					$condt1 = $queryString1;
					$condt2 = $queryString2;
					$condt3 = $queryString3;
				} else {
					$condt = "SO_DATE='".$date."'";
					$condt1 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 0";
					$condt2 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 1";
					$condt3 = "SO_DATE='".$date."' and SB_PAYMENT_STATUS= 3";
				}
			}
			
			$data['getBooking'] = $this->obj_booking->get_all_field_booking($condition,'SB_ID','DESC', 10,$start);
			$data['Count'] = $this->obj_booking->get_booking_count($condition);
			
			//FOR TOTAL IN COMBOBOX
			$data['All'] = $this->obj_booking->get_booking_count($condt);
			$data['Pending'] = $this->obj_booking->get_booking_count($condt1);
			$data['Completed'] = $this->obj_booking->get_booking_count($condt2);
			$data['Cancelled'] = $this->obj_booking->get_booking_count($condt3);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'SevaBooking/seva_booking_on_change_date/';
			$config['total_rows'] = $this->obj_booking->get_booking_count($condition);
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
			
			if(isset($_SESSION['All_Booked_Sevas'])) {
				$this->load->view('header',$data);
				$this->load->view('seva_booking');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//ON CLICK IN OPERATION FOR EDIT BOOKING
		function edit_book_seva() {
			if($_POST) {
				$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$_SESSION['actual_link'] = $actual_link;
				
				$date = $_POST['editsevadate2'];
				$SOID = $_POST['soId'];
				$this->db->where('SO_ID',$SOID);
				$this->db->update('DEITY_SEVA_OFFERED', array('SO_DATE' => $date, 'UPDATED_SO_DATE' => $date, 'UPDATED_BY_ID' => $_SESSION['userId']));
				$this->index();
			}
		}
		
		//ON CLICK IN OPERATION FOR ADD BOOKING
		function add_book_seva($id) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			//For Menu Selection
			$data['whichTab'] = "booking";
			//SLAP
			//bank 															
			// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
			// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..

			$condition = (" IS_TERMINAL = 1");														
			// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
			// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
			$data['bank'] = $this->obj_receipt->getAllbanks();
			$data['terminal'] = $this->obj_receipt->getCardbanks($condition);

			$condition = array('SB_ID' => $id);
			$data['getBooking'] = $this->obj_booking->get_all_field_booking($condition);
			
			if(isset($_SESSION['Book_Seva'])) {
				$this->load->view('header',$data);
				$this->load->view('book_seva_static');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//ADD BOOKING SAVE
		function add_book_Seva_Save() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$data['whichTab'] = "booking";
			$_SESSION['duplicate'] = "no";
			$transcId = "";$chequeNo = "";$chequeDate = "";$bank = "";$branch = "";$fglhBank ="";			//laz new
			
			if(isset($_POST["transactionId"])) {
				$transcId = $this->input->post('transactionId');
			}

			if(isset($_POST["chequeNo"])) {
				$chequeNo = $this->input->post('chequeNo');
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
			
			if(!$branch && !$bank && !$chequeNo) {
				$chequeNo = "";$chequeDate = "";$bank = "";$branch = "";
			}
			
			if($this->input->post('modeOfPayment') == "Cheque") {					//LAZ
				$paymentStatus = "Pending";
				
				if(isset($_POST["chequeDate"])) {
					$chequeDate = $this->input->post('chequeDate');
				}
			} else {																//LAZ							
				$paymentStatus = "Completed";
			}
			
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
				'RECEIPT_NO'=> $receiptFormat,
				'RECEIPT_DATE'=> date('d-m-Y'),
				'RECEIPT_NAME' => $this->input->post('sbname'),
				'RECEIPT_PHONE' => $this->input->post('sbphone'),
				'RECEIPT_ADDRESS' => $this->input->post('sbaddress'),
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
				'RECEIPT_DEITY_ID'=>$this->input->post('sbdeityid'),
				'RECEIPT_DEITY_NAME'=>$this->input->post('sbdeityname'),
				'RECEIPT_ISSUED_BY_ID'=>$_SESSION['userId'],
				'RECEIPT_ISSUED_BY'=>$_SESSION['userFullName'],
				'EOD_CONFIRMED_BY_ID'=>0,
				'DATE_TIME' => date('d-m-Y H:i:s A'),
				'RECEIPT_ACTIVE'=>1,
				'RECEIPT_CATEGORY_ID'=>1,
				'IS_BOOKING' => 1,
				'RECEIPT_SB_ID' => $this->input->post('sbid'),							//laz new		
				'FGLH_ID' => $fglhBank													//laz new ..
			); 
			
			$receiptId = $this->obj_receipt->add_receipt_deity_modal($data);
			$_SESSION['receiptId'] = $receiptId;
			$_SESSION['bookingSeva'] = "BookingSeva";
			
			//UPDATE TO SEVA_BOOKING
			$condtBooking = array('SB_ID' => $this->input->post('sbid'));
			$dataBooking = array('SB_PAYMENT_STATUS' => 1, 'SB_PAYMENT_DATE' => date('Y-m-d H:i:s'));
			$this->obj_booking->update_booking($condtBooking, $dataBooking);
			
			//UPDATE TO DEITY_SEVA_OFFERED
			$condtSevaOff = array('SO_ID' => $this->input->post('soid'));
			$dataSevaOff = array('SO_PRICE' => $this->input->post('amount'), 'RECEIPT_ID' => $receiptId);
			$this->obj_booking->update_deity_seva_offered($condtSevaOff, $dataSevaOff);
			//$this->output->enable_profiler(TRUE);
			$_SESSION['receiptFormat'] = 'RECEIPT_NO'; //Please note this is dummy just to enter the if condition of the Print Deity Receipt
			$_SESSION['deityReceiptId'] = $receiptId;
			redirect('/Receipt/printDeityReceipt/');
		}

		
		function book_Seva() 
		{
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			//For Menu Selection
			$data['whichTab'] = "booking";
			
			$data['deity'] = $this->obj_receipt->getDetiesBooking();
			$data['sevas'] = json_encode($this->obj_receipt->getDetiesSevasBooking()); 
			
			if(isset($_SESSION['Book_Seva'])) {
				$this->load->view('header',$data);
				$this->load->view('book_seva');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		public function checkSevaBookingPayment(){
			$sbId = $_POST['sbId'];
			$condition = array('SB_ID' => $sbId,'SB_PAYMENT_STATUS' => 0);
			$rowCount = $this->obj_booking->get_booking_count_payment_status($condition);
			
			if($rowCount == 0) {
				echo "failed";
			} else {
				echo "success";
			}
		}
		
		public function generateBookingReceipt() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$_SESSION['duplicate'] = "no";
			$todayDate = date('d-m-Y');
			$dateTime = date('d-m-Y H:i:s A');
			
			$name = $_POST['name'];
			$number = $_POST['number'];
			$address = $_POST['address'];
			
			$sevaName = json_decode($_POST['sevaName']);
			$date1 = json_decode($_POST['date']);
			$sevaId = json_decode($_POST['sevaId']);
			$userId = json_decode($_POST['userId']);
			$deityId = json_decode($_POST['deityId']);
			$deityName = json_decode($_POST['deityName']);
			$isSeva = json_decode($_POST['isSeva']);
			
			
			$this->db->select()->from('DEITY_RECEIPT_COUNTER')
			->where(array('DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID'=>'3'))
			->order_by("DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER", "desc");
			$query = $this->db->get();
			$deityCounter = $query->first_row();
			if($deityCounter) {
				$counter = intval($deityCounter->RECEIPT_COUNTER);
				$counter += 1;
			} else {
				$counter = 1;
			}
			
			$receiptFormat = $deityCounter->ABBR1 ."/".$deityCounter->ABBR2."/".$counter;
			
			$data = array(
				"SB_NO"=>$receiptFormat,
				"SB_DATE"=>$todayDate,
				"SB_NAME"=>$name,
				"SB_PHONE"=>$number,
				"SB_ADDRESS"=>$address,
				"SB_ISSUED_BY_ID"=>@$_SESSION['userId'],
				"SB_ISSUED_BY"=>@$_SESSION['userFullName'],
				"SB_CATEGORY_ID"=>1,
				"SB_ACTIVE"=>1,
				"SB_PAYMENT_STATUS"=>0
			); 
			
			$this->db->insert('SEVA_BOOKING', $data);
			$DEITY_RECEIPT = $this->db->insert_id();
			
			for($i = 0; $i < count($sevaName); ++$i) { 
				$data = array(
					'SO_SEVA_NAME'=>$sevaName[$i],
					'SO_SEVA_ID'=>$sevaId[$i],
					'SO_DEITY_ID'=>$deityId[$i],
					'SO_DEITY_NAME'=>$deityName[$i],
					'SO_IS_SEVA'=>$isSeva[$i],
					'REVISION_PRICE_CHECKER'=>0,
					'SO_SB_ID'=>$DEITY_RECEIPT,
					'SO_IS_BOOKING'=>1,
					'SO_DATE'=>$date1[$i]
				);
				
				$this->db->insert('DEITY_SEVA_OFFERED', $data);
				$deityOfferedID = $this->db->insert_id();
			}
			
			$data = array(
				'RECEIPT_COUNTER'=>$counter
			);
			
			// $this->db->update('DEITY_RECEIPT_COUNTER',$data)
			// ->where(array('DEITY_RECEIPT_COUNTER.RECEIPT_COUNTER_ID'=>'3'));
			
			$this->db->where('RECEIPT_COUNTER_ID',3);
			$this->db->update('DEITY_RECEIPT_COUNTER', array('RECEIPT_COUNTER'=>$counter));
					
			// $_SESSION['deityCount'] = $this->obj_sevas->get_seva_count(date("d-m-Y"));
			// $_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
			
			echo "success";
			$_SESSION['receiptFormat'] = $receiptFormat;
		}
		
		public function printBookingReceipt() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$data['whichTab'] = "booking";

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
			} else redirect("SevaBooking");
			
			$this->db->select()->from('SEVA_BOOKING')
			->join('DEITY_SEVA_OFFERED', 'DEITY_SEVA_OFFERED.SO_SB_ID = SEVA_BOOKING.SB_ID')
			->where(array('SEVA_BOOKING.SB_NO'=>$receiptNo));
			
			$query = $this->db->get();
			$data['deityCounter'] = $query->result("array");
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			$this->load->view('header',$data);
			$this->load->view('printBookingReceipt');
			//$this->output->enable_profiler(TRUE);
			$this->load->view('footer_home');
		}
		
		function shashwath_Seva() 
		{
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			//For Menu Selection
			$data['whichTab'] = "shashwath";
			$data['deity'] = $this->obj_receipt->getDetiesBooking();
			$data['sevas'] = json_encode($this->obj_receipt->getDetiesSevasBooking()); 
			
			if(isset($_SESSION['Book_Seva'])) {
				$this->load->view('header',$data);
				$this->load->view('book_seva');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
	}
?>
