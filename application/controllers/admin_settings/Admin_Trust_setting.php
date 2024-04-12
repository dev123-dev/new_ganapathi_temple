<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Admin_Trust_setting extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			$this->load->database();
			$this->load->helper('string');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->helper(array('form', 'url'));
			$this->load->helper('date');
			date_default_timezone_set('Asia/Kolkata');
			$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
			$this->load->model('trust_finance_model','obj_finance',true);  

			
			//CHECK LOGIN
			if(!isset($_SESSION['userId']))
				redirect('login');

			if($_SESSION['trustLogin'] != 1)	
				redirect('Trust');
				
			$this->db->select()->from('TRUST_EVENT')->where("TET_ACTIVE !=","0");
			$query = $this->db->get();
			$_SESSION['eventActiveCount'] = $query->num_rows();
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
			return $fYear;
		}*/


			//RESET PASSWORD
		function reset_password(){	
			$this->load->view('header');           
			$this->load->view('admin_settings/trust/reset_password');
			$this->load->view('footer_home');
		}

		//INSERT RESET PASSWORD
		function insert_reset_password() {
			//Adding To Event Seva Table
			$password1 = $this->input->post('new_pswd');
			$salt = sha1($password1);
        	$password = md5($salt . $password1);
			
			$oldpassword1 = $this->input->post('old_pswd');
			$salt = sha1($oldpassword1);
        	$oldpassword = md5($salt . $oldpassword1);
			
			$id = $_SESSION['userId'];
			$condition4 = array('USER_ID' => $id); 
			$users = $this->obj_admin_settings->get_all_field_users($condition4);
			
			if($oldpassword != $users[0]->USER_PASSWORD) {
				$data['password'] = "Your old Password did not match";
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/reset_password');
				$this->load->view('footer_home');
			} else {
				$condition2 = array('USER_PASSWORD' => $password);
				$condition = array('USER_ID' => $id);
				$this->obj_admin_settings->add_change_password_modal($condition2,$condition);
				$data['msg'] = 'Successfully updated';
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/reset_password');
				$this->load->view('footer_home');
			}
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
			
		//UPDATE BID RANGE
		function update_bid_range() {
			$data = array('ITEM_FROM_PRICE' => $this->input->post('bid_value_from'), 'ITEM_TO_PRICE' => $this->input->post('bid_value_to'), 'MIN_BID_VALUE' => $this->input->post('bid_value'));
			$condition = array('IBR_ID' => $this->input->post('IBR_ID'));
			$this->obj_admin_settings->edit_bid_range_trust($condition,$data);
			redirect('/admin_settings/Admin_Trust_setting/auction_setting/');
		}

		//EDIT BID RANGE
		function edit_bid_range($id) {
			$condition = array('AI_STATUS' => 1);
			$data['auction_item'] = $this->obj_admin_settings->get_all_field_auction_item_trust($condition, 'AI_ID', 'desc');
			$conditionOne = array('AIC_STATUS' => 1);
			$data['auction_category'] = $this->obj_admin_settings->get_all_field_auction_item_category_trust($conditionOne, 'AIC_STATUS', 'desc');
			$condition = array('IBR_ID' => $id);
			$data['bid_range'] = $this->obj_admin_settings->get_all_field_bid_range_trust($condition);
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/trust/edit_bid_range');
			$this->load->view('footer_home');
		}

		//SAVE BID RANGE
		function save_bid_range() {			
			//Adding To Bid Range Table
			$data = array('IBR_AI_ID' => $this->input->post('item'),
						  'IBR_AIC_ID' => $this->input->post('item_category'),
						  'ITEM_FROM_PRICE' => $this->input->post('bid_value_from'),
						  'ITEM_TO_PRICE' => $this->input->post('bid_value_to'),
						  'MIN_BID_VALUE' => $this->input->post('bid_value'),
						  'USER_ID' => $this->session->userdata('userId'),
						  'DATE_TIME' => date('d-m-Y H:i:s A'),
						  'DATE' => date('d-m-y'));
			$this->obj_admin_settings->add_bid_range_modal_trust($data);
			redirect('/admin_settings/Admin_Trust_setting/auction_setting/');
		}

		//ADD BID RANGE
		function add_bid_range() {
			$condition = array('AI_STATUS' => 1);
			$data['auction_item'] = $this->obj_admin_settings->get_all_field_auction_item_trust($condition, 'AI_ID', 'desc');
			$conditionOne = array('AIC_STATUS' => 1, 'AIC_ID !=' => 3);
			$data['auction_category'] = $this->obj_admin_settings->get_all_field_auction_item_category_trust($conditionOne, 'AIC_STATUS', 'desc');
			
			$this->load->view('header',$data);        
			$this->load->view('admin_settings/trust/add_bid_range');
			$this->load->view('footer_home');
		}

		//UPDATE DEFAULT ID
		function update_default_bid() {
			$data = array('DEFAULT_BID_VALUE' => $this->input->post('bid_value'));
			$condition = array('IDB_ID' => $this->input->post('auct_Item_Id'));
			$this->obj_admin_settings->edit_default_bid_trust($condition,$data);
			redirect('/admin_settings/Admin_Trust_setting/auction_setting/');
		}

		//EDIT DEFAULT BID VALUE
		function edit_default_bid($id) {
			$condition = array('AI_STATUS' => 1);
			$data['auction_item'] = $this->obj_admin_settings->get_all_field_auction_item_trust($condition, 'AI_ID', 'desc');
			$conditionOne = array('AIC_STATUS' => 1);
			$data['auction_category'] = $this->obj_admin_settings->get_all_field_auction_item_category_trust($conditionOne, 'AIC_STATUS', 'desc');
			$conditionTwo = array('IDB_ID' => $id);
			$data['default_bid'] = $this->obj_admin_settings->get_all_field_default_bid_trust($conditionTwo); 
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/trust/edit_default_bid');
			$this->load->view('footer_home');
		}

		//SAVE DEFAULT BID
		function save_default_bid() {
			if($this->input->post('item') == "2") {
				$condition = array('IDB_AI_ID' => $this->input->post('item'), 'IDB_AIC_ID' => $this->input->post('item_category'));
			} else {
				$condition = array('IDB_AI_ID' => $this->input->post('item'));
			}
			$count = $this->obj_admin_settings->count_rows_default_bid_trust($condition);
			
			if($count == 0) {
				//Adding To Auction Item Default Bid Table
				$data = array('IDB_AI_ID' => $this->input->post('item'),
							  'IDB_AIC_ID' => $this->input->post('item_category'),
							  'DEFAULT_BID_VALUE' => $this->input->post('bid_value'),
							  'USER_ID' => $this->session->userdata('userId'),
							  'DATE_TIME' => date('d-m-Y H:i:s A'),
							  'DATE ' => date('d-m-y'));
				$this->obj_admin_settings->add_auction_item_default_bid_modal_trust($data);
				redirect('/admin_settings/Admin_Trust_setting/auction_setting/');
			} else {
				$msg = 'Default Bid value is already added for this item.';
				$this->session->set_userdata('msg', $msg);
				redirect('/admin_settings/Admin_Trust_setting/add_default_bid/');
			}
		}

		//ADD DEFAULT BID
		function add_default_bid() {
			$condition = array('AI_STATUS' => 1);
			$data['auction_item'] = $this->obj_admin_settings->get_all_field_auction_item_trust($condition, 'AI_ID', 'desc');
			$conditionOne = array('AIC_STATUS' => 1, 'AIC_ID !=' => 3);
			$data['auction_category'] = $this->obj_admin_settings->get_all_field_auction_item_category_trust($conditionOne, 'AIC_STATUS', 'desc');
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/trust/add_default_bid');
			$this->load->view('footer_home');
		}

		//UPDATE AUCTION ITEM STATUS
		function update_auction_item_status() {
			$data = array('AI_STATUS' => $_POST['status']);
			$condition = array('AI_ID' => $_POST['id']);
			$this->obj_admin_settings->edit_auction_item_trust($condition,$data);
			echo "Success";
		}

		//SAVE AUCTION ITEMS
		function save_auction_item() {
			//Adding To Auction Item Table
			$data = array('AI_NAME' => $this->input->post('item_name'),
						  'AI_PREFIX' => $this->input->post('item_prefix'),
						  'AI_STATUS' => $this->input->post('item_active'),
						  'USER_ID' => $this->session->userdata('userId'),
						  'DATE_TIME' => date('d-m-Y H:i:s A'),
						  'DATE' => date('d-m-y'));
			$this->obj_admin_settings->trust_add_auction_item_modal($data);
			redirect('/admin_settings/Admin_Trust_setting/auction_setting/');
		}

		//ADD AUCTION ITEMS
		function add_auction_item() {
			if(isset($_SESSION['Add_Auction_Item'])) {
				$this->load->view('header');           
				$this->load->view('admin_settings/trust/add_auction_item');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		function auction_setting() {
			$data['auction_item'] = $this->obj_admin_settings->get_all_field_auction_item_trust(null, 'AI_ID', 'desc');
			$data['default_bid'] = $this->obj_admin_settings->get_all_field_default_bid_trust(null, 'IDB_ID', 'desc');
			$data['bid_range'] = $this->obj_admin_settings->get_all_field_bid_range_trust(null,'IBR_ID','desc');
			
			if(isset($_SESSION['Auction_Settings'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/auction_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		//IMPORT EXCEL SAVING 
		function file_import_excel_save() { 
			//POST VALUE
			$eventId = $this->input->post('eventId');
			$eventName = $this->input->post('eventName');
			$userId = $this->input->post('userId');
			$userName = $this->input->post('userName');
		
			// Load the spreadsheet reader library
			$this->load->library('excel');
			$file =  $_FILES["userfile"]["tmp_name"];
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			//get only the Cell Collection
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			//extract to a PHP readable array format
			$i = 0;
			$k = 0;
			$arrAlpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P");
			$arr_data = array();
			foreach ($cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				if($arrAlpha[$k] == $column) {
					$arr_data[$i][$k] = $data_value;
					$k++;
				} else {
					$key = array_search($column,$arrAlpha);
					$start = array_search($arrAlpha[$k],$arrAlpha);
					
					for($j = $start; $j <= $key; $j++) {
						$arr_data[$i][$j] = "";
						$k++;
						$arr_data[$i][$key] = $data_value;
					}
				}
			
				if($column == "P") {
					
					$i++;$k = 0;
				} 
			}
			
			$PaymentStatus = "";
			for($z = 1; $z < count($arr_data); $z++) {
				if($arr_data[$z][6] == "Cheque") {
					$PaymentStatus = "Pending";
				} else if($arr_data[$z][6] == "Cash") {
					$PaymentStatus = "Completed";
				}
				if($arr_data[$z][11] != 2) {
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
					$receiptNo = $receiptFormat;
				} else {
					$receiptNo = "";
				}
				
				$data_array = array('REFERENCE_NO' => $arr_data[$z][0],
									'TET_RECEIPT_NAME' => $arr_data[$z][1],
									'TET_RECEIPT_PHONE' => $arr_data[$z][2],
									'TET_RECEIPT_PRICE' => $arr_data[$z][3],
									'TET_RECEIPT_EMAIL' => $arr_data[$z][4],
									'TET_RECEIPT_ADDRESS' => $arr_data[$z][5],
									'TET_RECEIPT_PAYMENT_METHOD' => $arr_data[$z][6],
									'CHEQUE_NO' => $arr_data[$z][7],
									'CHEQUE_DATE' => $arr_data[$z][8],
									'BANK_NAME' => $arr_data[$z][9],
									'BRANCH_NAME' => $arr_data[$z][10],
									'TET_RECEIPT_ACTIVE' => $arr_data[$z][11],
									'TET_RECEIPT_PAYMENT_METHOD_NOTES' => $arr_data[$z][12],
									'TET_RECEIPT_DATE' => $arr_data[$z][14],
									'DATE_TIME' => $arr_data[$z][15],
									'TET_RECEIPT_NO' => $receiptNo,
									'TET_RECEIPT_ISSUED_BY' => $userName,
									'TET_RECEIPT_ISSUED_BY_ID' => $userId,
									'RECEIPT_TET_NAME' => $eventName,
									'RECEIPT_TET_ID' => $eventId,
									'TET_RECEIPT_CATEGORY_ID' => 2,
									'PAYMENT_STATUS' => $PaymentStatus,
									'AUTHORISED_STATUS' => "No",
									'CANCEL_NOTES' => $arr_data[$z][13],
									'REFERENCE' => "App");
								
				$this->obj_admin_settings->insert_trust_event_receipt_modal($data_array);
			}
			redirect('/admin_settings/Admin_Trust_setting/import_setting/');
		}

		function get_data_on_filter($start=0) {	
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			if(@$_POST['date']) {
				$_SESSION['date'] = $this->input->post('date');
				$data['date'] = $this->input->post('date');
				$dateImport = $this->input->post('date');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('date'));
				$data['date'] = $_SESSION['date'];
				$dateImport = $this->input->post('date');
			} else {
				$dateImport = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['users_id']) {
				$_SESSION['users'] = $this->input->post('users_id');
				$data['user'] = $this->input->post('users_id');
				$users = $this->input->post('users_id');
			}
			
			if(@$_SESSION['users'] == "") {
				$this->session->set_userdata('users', $this->input->post('users_id'));
				$data['user'] = $_SESSION['users'];
				$users = $this->input->post('users_id');
			} else {
				$users = $_SESSION['users'];
				$data['user'] = $_SESSION['users'];
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
						
			$condition = array('TET_ACTIVE' => 1);
			$data['events'] = $this->obj_admin_settings->get_all_field_trust($condition);
			$condtUser = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
			$data['usersCombo'] = $this->obj_admin_settings->get_all_users_on_events_trust($condtUser,'TET_RECEIPT_ISSUED_BY','asc');
			
			//GETTING USERS
			$condition_users = array('USER_ACTIVE' => 1);
			$data['users'] = $this->obj_admin_settings->get_all_users($condition_users);
			//GETTING EVENTS
			$condition_events = array('TET_ACTIVE' => 1);
			$data['events'] = $this->obj_admin_settings->get_all_events_trust($condition_events);
			//GET EVENT RECEIPT
			$condition_app = array('REFERENCE' => 'App', 'TET_RECEIPT_DATE' => $dateImport);
			$data['app_data'] = $this->obj_admin_settings->get_all_app_data_trust($condition_app,'TET_RECEIPT_ID','desc',10,$start);
			
			if(@$pMethod == "All" && @$users == "All Users") {
				$condition_app = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$data['app_data'] = $this->obj_admin_settings->get_all_app_data_trust($condition_app,'TET_RECEIPT_ID','desc',10,$start);
			} else if(@$pMethod != "All" && @$users != "All Users") {
				$condition_app = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $pMethod, 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$data['app_data'] = $this->obj_admin_settings->get_all_app_data_trust($condition_app,'TET_RECEIPT_ID','desc',10,$start);
			} else if(@$pMethod != "All" && @$users == "All Users") {
				$condition_app = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $pMethod,'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$data['app_data'] = $this->obj_admin_settings->get_all_app_data_trust($condition_app,'TET_RECEIPT_ID','desc',10,$start);
			} else if(@$pMethod == "All" && @$users != "All Users") {
				$condition_app = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_DATE' => $dateImport,'TET_RECEIPT_ACTIVE'=>1);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users, 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users, 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
				$data['app_data'] = $this->obj_admin_settings->get_all_app_data_trust($condition_app,'TET_RECEIPT_ID','desc',10,$start);
			}
			
			$data['All'] = $this->obj_admin_settings->get_total_amount_trust($condt);
			$data['Cash'] = $this->obj_admin_settings->get_total_amount_trust($condt1);
			$data['Cheque'] = $this->obj_admin_settings->get_total_amount_trust($condt2);
			$data['TotalAmount'] = $this->obj_admin_settings->get_all_amount_trust($condition_app);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/admin_settings/Admin_Trust_setting/get_data_on_filter';
			$config['total_rows'] = $this->obj_admin_settings->count_rows_donation_trust($condition_app);
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
			$this->load->view('admin_settings/trust/import_setting');
			$this->load->view('footer_home');
		}

		//GET IMPORT SETTING
		function import_setting($start = 0) {
			unset($_SESSION['date']);
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);
			
			$data['date'] = date("d-m-Y");
			$dateImport = date("d-m-Y");
			
			//EVENTS
			$condition = array('TET_ACTIVE' => 1);
			$data['events'] = $this->obj_admin_settings->get_all_field_trust($condition);
			
			//USER COMBO
			$condtUser = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
			$data['usersCombo'] = $this->obj_admin_settings->get_all_users_on_events_trust($condtUser,'TET_RECEIPT_ISSUED_BY','asc');
			
			$condt = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
			$data['All'] = $this->obj_admin_settings->get_total_amount_trust($condt);
			$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
			$data['Cash'] = $this->obj_admin_settings->get_total_amount_trust($condt1);
			$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
			$data['Cheque'] = $this->obj_admin_settings->get_total_amount_trust($condt2);
			$condt3 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $dateImport);
			
			//GETTING USERS
			$condition_users = array('USER_ACTIVE' => 1);
			$data['users'] = $this->obj_admin_settings->get_all_users($condition_users);
			//GETTING EVENTS
			$condition_events = array('TET_ACTIVE' => 1);
			$data['events'] = $this->obj_admin_settings->get_all_events_trust($condition_events);
			//GET EVENT RECEIPT
			$condition_app = array('REFERENCE' => 'App', 'TET_RECEIPT_DATE' => $dateImport);
			$data['app_data'] = $this->obj_admin_settings->get_all_app_data_trust($condition_app,'TET_RECEIPT_ID','desc',10,$start);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/admin_settings/Admin_Trust_setting/import_setting/';
			$config['total_rows'] = $this->obj_admin_settings->count_rows_donation_trust($condition_app);
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
			
			if(isset($_SESSION['Trust_Import_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/trust/import_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		//GET ALL EVENTS SETTING
		function events_setting() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$condition = "";
			$data['admin_settings_events'] = $this->obj_admin_settings->get_trust_all_field_event($condition,'TET_ACTIVE',"desc");
			
			$conditionOne = array('TET_ACTIVE' => 1, 'TET_SEVA_PRICE_ACTIVE' => 1); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_trust_all_field_event_seva($conditionOne,'TET_SEVA_ACTIVE','desc');
			
			$conditionTwo = array('TET_ACTIVE' => 1); 
			$data['event'] = $this->obj_admin_settings->get_trust_all_field_event_activate($conditionTwo);
			
			$conditionThree = array('TET_ACTIVE' => 1); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_trust_all_field_limits($conditionThree, 'TET_SL_ID');
			
			if(isset($_SESSION['Event_Seva_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/trust/events_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//GET ALL EVENTS SETTING
		function events_seva_details($id) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$conditionOne = array('TRUST_EVENT_SEVA.TET_ID' => $id, 'TET_SEVA_PRICE_ACTIVE' => 1); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_trust_all_field_event_seva($conditionOne,'TET_SEVA_NAME');
			
			$conditionTwo = array('TRUST_EVENT.TET_ID' => $id); 
			$data['event'] = $this->obj_admin_settings->get_trust_all_field_event($conditionTwo);
			
			$this->session->userdata('events_details','events_details');
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/trust/events_seva_details');
			$this->load->view('footer_home');
		}
		
		//ADD EVENT
		function add_event() {
			if(@$_POST['CommitteeId']){
				$data['compId'] = $compId = @$_POST['CommitteeId'];
				$data['todayDate'] = $_SESSION['todayDate'] = $_POST['todayDateVal'];
			} else {
				$data['compId'] = $compId = 1;
				$data['todayDate'] = $todayDate = $_SESSION['todayDate'] =date('d-m-Y');
			}
			$this->session->set_userdata('EtName','');
			$this->session->set_userdata('EtFrom','');
			$this->session->set_userdata('EtTo','');
			$this->session->set_userdata('EtStatus','');
			$this->session->set_userdata('EtAbbr','');
			$this->session->set_userdata('EtSevaAbbr','');
			$this->session->set_userdata('EtInkindAbbr','');
				// adding the committie dropdown code by adithya on 8-1-24 start
				$data['committee'] =  $this->obj_admin_settings->getCommittee();
				// adding the committie dropdown code by adithya on 8-1-24 end
				//  print_r($data['committee']);
				$this->load->view('header',$data);               
			$this->load->view('admin_settings/trust/add_event');
			$this->load->view('footer_home');
		}
		
		//SAVE EVENT
		function save_event() {
			if($this->input->post('event_active') == 1) {
				$condition = array('TET_ACTIVE' => 1); 
				$events = $this->obj_admin_settings->get_trust_all_field_event($condition);
				// print_r($events);//below !empty has been entered 
				if(!empty($events)) {
					$this->session->set_userdata('msg', 'An event is already active. Please set '.$events[0]->TET_NAME.' event deactive to save event details.');
					$this->session->set_userdata('EtName',$this->input->post('event_name'));
					$this->session->set_userdata('EtFrom',$this->input->post('todayDateFrom'));
					$this->session->set_userdata('EtTo',$this->input->post('todayDateTo'));
					$this->session->set_userdata('EtStatus',$this->input->post('event_active'));
					$this->session->set_userdata('EtAbbr',$this->input->post('event_abbr1'));
					$this->session->set_userdata('EtSevaAbbr',$this->input->post('event_abbr2'));
					$this->session->set_userdata('EtInkindAbbr',$this->input->post('event_abbr3'));
					
					$this->load->view('header');           
					$this->load->view('admin_settings/trust/add_event');
					$this->load->view('footer_home');
					return;
				}
			}
			
			$data = array('TET_NAME' => $this->input->post('event_name'),
						'TET_FROM_DATE_TIME' => $this->input->post('todayDateFrom'),
						'TET_TO_DATE_TIME' => $this->input->post('todayDateTo'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'),
						'T_COMP_ID'=>$this->input->post('CommitteeId'),
						'USER_ID' => $this->session->userdata('userId'),
						'TET_ACTIVE' => $this->input->post('event_active'));
			
			$eventId = $this->obj_admin_settings->add_trust_event_modal($data);
			
			//FOR SEVA
			$data_Counter1 = array('TET_ABBR1' => $this->input->post('event_abbr1'),
								  'TET_ABBR2' => $this->input->post('event_abbr2'),
								  'TET_RECEIPT_COUNTER' => 0,
								  'USER_ID' => $this->session->userdata('userId'),
								  'EVENT_ID' => $eventId,
								  'DATE_TIME' => date('d-m-Y H:i:s A'),
								  'DATE' => date('d-m-Y'));
			$sevaId = $this->obj_admin_settings->add_trust_event_counter_modal($data_Counter1);
			
			//FOR INKIND
			$data_Counter2 = array('TET_ABBR1' => $this->input->post('event_abbr1'),
								  'TET_ABBR2' => $this->input->post('event_abbr3'),
								  'TET_RECEIPT_COUNTER' => 0,
								  'USER_ID' => $this->session->userdata('userId'),
								  'EVENT_ID' => $eventId,
								  'DATE_TIME' => date('d-m-Y H:i:s A'),
								  'DATE' => date('d-m-Y'));
			$inkindId = $this->obj_admin_settings->add_trust_event_counter_modal($data_Counter2);
			
			if($this->input->post('event_active') == 1) {
				//UPDATING SEVA COUNTER ID
				$conditionOne = array('TET_RECEIPT_CATEGORY_ID !=' => 4);
				$dataOne = array('TET_ACTIVE_RECEIPT_COUNTER_ID' => $sevaId);
				$this->obj_admin_settings->edit_trust_event_category_modal($conditionOne,$dataOne);
				
				//UPDATING INKIND COUNTER ID
				$conditionTwo = array('TET_RECEIPT_CATEGORY_ID' => 4);
				$dataTwo = array('TET_ACTIVE_RECEIPT_COUNTER_ID' => $inkindId);
				$this->obj_admin_settings->edit_trust_event_category_modal($conditionTwo,$dataTwo);
			}
			
			redirect('/admin_settings/Admin_Trust_setting/events_setting/');
		}
		
		//EDIT EVENT
		function edit_event($id) {

			$this->session->set_userdata('EtName','');
			$this->session->set_userdata('EtFrom','');
			$this->session->set_userdata('EtTo','');
			$this->session->set_userdata('EtStatus','');
			$this->session->set_userdata('EtId','');
			$this->session->set_userdata('EtAbbr','');
			$this->session->set_userdata('EtSevaAbbr','');
			$this->session->set_userdata('EtInkindAbbr','');
			
			
			$condition = array('TET_ID' => $id);
			$data['admin_settings_events'] = $this->obj_admin_settings->get_trust_all_field_event($condition);
			$data['committee'] =  $this->obj_admin_settings->getCommittee();
			// Added the below code by adithya on 8-1-24 start
			$data['compId'] =$data['admin_settings_events'][0]->T_COMP_ID; 

			$this->load->view('header', $data);           
			$this->load->view('admin_settings/trust/edit_event');
			$this->load->view('footer_home');
		}
		
		//UPDATE EVENT
		function update_event($id) {
			if($this->input->post('event_active') == 1) {
				$condition = array('TET_ACTIVE' => 1, 'TET_ID !=' => $id); 
				$events = $this->obj_admin_settings->get_trust_all_field_event_activate($condition);
				if($events > 0) {
					$this->session->set_userdata('msg', 'An event is already active. Please set '.$events[0]->TET_NAME.' event deactive to save event details.');
					$this->session->set_userdata('EtName',$this->input->post('event_name'));
					$this->session->set_userdata('EtFrom',$this->input->post('todayDateFrom'));
					$this->session->set_userdata('EtTo',$this->input->post('todayDateTo'));
					$this->session->set_userdata('EtStatus',$this->input->post('event_active'));
					$this->session->set_userdata('EtId',$id);
					
					$this->load->view('header');           
					$this->load->view('admin_settings/edit_event');
					$this->load->view('footer_home');
					return;
				}
			}
			
			$data = array('TET_NAME' => $this->input->post('event_name'),
					'TET_FROM_DATE_TIME' => $this->input->post('todayDateFrom'),
					'TET_TO_DATE_TIME' => $this->input->post('todayDateTo'),
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'),
					'T_COMP_ID'=>$this->input->post('CommitteeId'),
					'USER_ID' => $this->session->userdata('userId'),
					'TET_ACTIVE' => $this->input->post('event_active'));
			
			$condition = array('TET_ID' => $id); 
			$this->obj_admin_settings->edit_trust_event_modal($condition,$data);
			
			if($this->input->post('event_active') == 0) {
				$receipt_category = $this->obj_admin_settings->get_trust_all_field_receipt_category();
				$dfMonth = $this->obj_admin_settings->get_financial_month();				
				$datMonth = $this->get_financial_year($dfMonth);
								
				if($datMonth == date('Y').' - '.(date('Y')+1)) {
					for($i = 0; $i < count($receipt_category); $i++) {
						$conditionCounter = array('TET_RECEIPT_COUNTER_ID' => $receipt_category[$i]->TET_ACTIVE_RECEIPT_COUNTER_ID);
						$dataCounter = array('TET_RECEIPT_COUNTER' => 0);
						$this->obj_admin_settings->get_trust_update_receipt_counter($conditionCounter,$dataCounter);
					}
				}
			} else if($this->input->post('event_active') == 1) {
				$conditionSeva = array('EVENT_ID' => $id);
				$sevaId = $this->obj_admin_settings->get_trust_event_receipt_counter($conditionSeva,'TET_RECEIPT_COUNTER_ID','asc');
				$conditionInkind = array('EVENT_ID' => $id);
				$inkindId = $this->obj_admin_settings->get_trust_event_receipt_counter($conditionInkind,'TET_RECEIPT_COUNTER_ID','desc');
				
				//UPDATING SEVA COUNTER ID
				$conditionOne = array('TET_RECEIPT_CATEGORY_ID !=' => 4);
				$dataOne = array('TET_ACTIVE_RECEIPT_COUNTER_ID' => $sevaId->TET_RECEIPT_COUNTER_ID);
				$this->obj_admin_settings->edit_trust_event_category_modal($conditionOne,$dataOne);
				
				//UPDATING INKIND COUNTER ID
				$conditionTwo = array('TET_RECEIPT_CATEGORY_ID' => 4);
				$dataTwo = array('TET_ACTIVE_RECEIPT_COUNTER_ID' => $inkindId->TET_RECEIPT_COUNTER_ID);
				$this->obj_admin_settings->edit_trust_event_category_modal($conditionTwo,$dataTwo);
			}
			
			$dataEventHistory = array('TET_ID' => $id,
									  'TET_NAME' => $this->input->post('event_name'),
									  'TET_FROM' => $this->input->post('todayDateFrom'),
									  'TET_TO' => $this->input->post('todayDateTo'),
									  'DATE_TIME' => date('d-m-Y H:i:s A'),
									  'DATE' => date('d-m-Y'),
									  'USER_ID' => $this->session->userdata('userId'),
									  'TET_STATUS' => $this->input->post('event_active'));
			$this->obj_admin_settings->add_trust_event_history_modal($dataEventHistory);
			
			$this->session->set_userdata('msg', 'Successfully updated');
			
			$condition = array('TET_ID' => $id);
			$data['admin_settings_events'] = $this->obj_admin_settings->get_trust_all_field_event($condition);
			
			$this->db->select()->from('TRUST_EVENT')->where("TET_ACTIVE !=","0");
			$query = $this->db->get();
			$_SESSION['eventActiveCount'] = $query->num_rows();

			$this->load->view('header',$data);           
			$this->load->view('admin_settings/trust/edit_event');
			$this->load->view('footer_home');
		}
		
		//ADD EVENT SEVA
		function add_event_seva($id) {
			$condition = array('TET_ID' => $id);
			$data['admin_settings_events'] = $this->obj_admin_settings->get_trust_all_field_event($condition);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/trust/add_event_seva');
			$this->load->view('footer_home');
		}
		
		//SAVE EVENT SEVA
		function save_event_seva() {
			if(isset($_POST['qty_checker']))
				$qtyChecker = 1;
			else
				$qtyChecker = 0;
			
			if(isset($_POST['restrict_date']))
				$restrictDate = 1;
			else
				$restrictDate = 0;
			
			if(isset($_POST['token']))
				$isToken = 1;
			else
				$isToken = 0;
			
			//Adding To Event Seva Table
			$data = array('TET_SEVA_NAME' => $this->input->post('seva_name'),
						'TET_ID' => $this->input->post('event_Id'),
						'TET_SEVA_DESC' => $this->input->post('seva_desc'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'),
						'USER_ID' => $this->session->userdata('userId'),
						'TET_SEVA_ACTIVE' => $this->input->post('seva_active'),
						'TET_SEVA_QUANTITY_CHECKER' => $qtyChecker,
						'IS_SEVA' => $this->input->post('OptRadio'),
						'IS_TOKEN' => $isToken,
						'RESTRICT_DATE' => $restrictDate);
						
			$this->obj_admin_settings->add_trust_event_seva_modal($data);
			
			//Getting Latest Inserted Seva Id
			$event_seva = $this->obj_admin_settings->get_trust_all_field_event_seva_latest();
			
			//Adding To Event Seva Price Table
			$data_One = array('TET_SEVA_PRICE_ACTIVE' => 1,
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'),
						'USER_ID' => $this->session->userdata('userId'), 
						'TET_ID' => $this->input->post('event_Id'),
						'TET_SEVA_ID' => $event_seva->TET_SEVA_ID,
						'TET_SEVA_PRICE' => $this->input->post('seva_price'));
						
			$this->obj_admin_settings->add_trust_event_seva_price_modal($data_One);
			redirect($_SESSION['actual_link']);
		}
		
		//EDIT EVENT SEVA
		function edit_event_seva($id) {	
			$condition = array('TRUST_EVENT_SEVA.TET_SEVA_ID' => $id, 'TET_SEVA_PRICE_ACTIVE' => 1);
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_trust_all_field_event_seva($condition);
		
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/trust/edit_event_seva');
			$this->load->view('footer_home');
		}
		
		//UPDATE EVENT SEVA 
		function update_event_seva() {
			if(isset($_POST['qty_checker']))
				$qtyChecker = 1;
			else
				$qtyChecker = 0;
			
			if(isset($_POST['restrict_date']))
				$restrictDate = 1;
			else
				$restrictDate = 0;

			if(isset($_POST['token']))
				$isToken = 1;
			else
				$isToken = 0;
			
			$sevaId = $this->input->post('seva_id');
			$condition =  array('TET_SEVA_ID' => $sevaId); 
			
			//Adding To Event Seva Table
			$data = array('TET_SEVA_NAME' => $this->input->post('seva_name'),
						'TET_ID' => $this->input->post('event_Id'),
						'TET_SEVA_DESC' => $this->input->post('seva_desc'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'),
						'USER_ID' => $this->session->userdata('userId'),
						'TET_SEVA_ACTIVE' => $this->input->post('seva_active'),
						'TET_SEVA_QUANTITY_CHECKER' => $qtyChecker,
						'IS_SEVA' => $this->input->post('OptRadio'),
						'IS_TOKEN' => $isToken,
						'RESTRICT_DATE' => $restrictDate);
						
			$this->obj_admin_settings->edit_trust_event_seva_modal($condition,$data);
			
			if(($this->input->post('price')) != ($this->input->post('seva_price'))) {
				$data_One = array('TET_SEVA_PRICE_ACTIVE' => 0);
				$conditionOne = array('TET_SEVA_ID'=> $sevaId);
				$this->obj_admin_settings->edit_trust_event_seva_price_modal($conditionOne,$data_One);
				
				//Adding To Event Seva Price Table
				$data_Two = array('TET_SEVA_PRICE_ACTIVE' => 1,
							'DATE_TIME' => date('d-m-Y H:i:s A'),
							'DATE' => date('d-m-Y'),
							'USER_ID' => $this->session->userdata('userId'),
							'TET_ID' => $this->input->post('event_Id'),
							'TET_SEVA_ID' => $sevaId,
							'TET_SEVA_PRICE' => $this->input->post('seva_price'));
							
				$this->obj_admin_settings->add_trust_event_seva_price_modal($data_Two);
			} else {
				$data_Three = array('TET_SEVA_PRICE' => $this->input->post('seva_price'));
				$conditionThree = array('TET_SEVA_PRICE_ID'=> $this->input->post('price_id'));
				$this->obj_admin_settings->edit_trust_event_seva_price_modal($conditionThree,$data_Three);
			}
			
			redirect($_SESSION['actual_link']);
		}
		
		//UPDATE SEVA EVENT STATUS
		function update_seva_event_status() {
			$data = array('TET_SEVA_ACTIVE' => $_POST['status']);
			$condition = array('TET_SEVA_ID' => $_POST['id']); 
			$this->obj_admin_settings->edit_trust_event_seva_modal($condition,$data);
			echo "Success";
		}
		
		//DISPLAY LIMIT AND Stock
		function get_limit_details($id) {
			$condition = array('TRUST_EVENT_SEVA.TET_SEVA_ID' => $id); 
			$sevaDetails = $this->obj_admin_settings->get_trust_all_field_event_seva($condition);
			
			$conditionOne = array('TRUST_EVENT_SEVA.TET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_trust_all_field_event_seva($conditionOne,'TET_SEVA_NAME');
			
			$conditionThree = array('TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_trust_all_field_limits($conditionThree, 'TET_SL_ID');
			
			$conditionFour = array('TET_SO_SEVA_ID' => $id, 'TET_SO_IS_SEVA' => $sevaDetails[0]->IS_SEVA);
			$data['laddu_sold'] = $this->obj_admin_settings->get_trust_laddu_stock_sold($conditionFour);
			
			$conditionFive = array('TET_SEVA_ID' => $id, 'TET_IS_SEVA' => $sevaDetails[0]->IS_SEVA);
			$data['laddu_available'] = $this->obj_admin_settings->get_trust_laddu_stock_available($conditionFive);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/trust/limit_details');
			$this->load->view('footer_home');
		}
		
		//GET TOTAL COUNT SEVA OFFERED
		function get_count_seva_offered() {
			$seva = explode('¶', $this->input->post('sevaid'));
			$sevaId = $seva[1];
			$date = $this->input->post('date');
			$condition = array('TET_SO_SEVA_ID' => $sevaId, 'TET_SO_DATE' => $date);
			$count = $this->obj_admin_settings->get_trust_fields_offered($condition);
			echo $count;
		}
		
		//ADD LIMIT AND STOCK
		function get_add_limit_stock($id) {
			$sevas = explode('¶', $this->input->post('seva_id'));
			if($id == 1) { //LIMIT
				$condition = array('TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID'=> $sevas[1], 'TET_SEVA_DATE' => $this->input->post('todayDateFrom'));
				$Limits = $this->obj_admin_settings->get_trust_field_limits($condition);
				if($Limits > 0) {
					$msg = 'A limit has been set for '.$Limits->TET_SEVA_NAME.' on '.$this->input->post('todayDateFrom');
					$this->session->set_userdata('msg', $msg);
					
					redirect('/admin_settings/Admin_Trust_setting/get_limit_details/'.$sevas[1]);
					return;
				}
				
				//Adding To Limit Table
				$data_Limit = array('TET_SEVA_ID' => $sevas[1],
							'DATE_TIME' => date('d-m-Y H:i:s A'),
							'DATE' => date('d-m-Y'),
							'TET_IS_SEVA' => $sevas[0],
							'TET_SEVA_DATE' => $this->input->post('todayDateFrom'),
							'USER_ID' => $this->session->userdata('userId'),
							'TET_SEVA_LIMIT' => $this->input->post('Limit'));
				$this->obj_admin_settings->add_trust_limit_modal($data_Limit);			
			} else if($id = 2) { //STOCK
				//Adding To Limit Table
				$data_Stock = array('TET_SEVA_ID' => $sevas[1],
							'DATE_TIME' => date('d-m-Y H:i:s A'),
							'DATE' => date('d-m-Y'),
							'TET_IS_SEVA' => $sevas[0],
							'USER_ID' => $this->session->userdata('userId'),
							'TET_SEVA_LIMIT' => $this->input->post('Stock'));
				$this->obj_admin_settings->add_trust_limit_modal($data_Stock);	
			}
			$msg = 'Successfully Added';
			$this->session->set_userdata('msg', $msg);
			redirect('/admin_settings/Admin_Trust_setting/get_limit_details/'.$sevas[1]);
		}
		
		//EDIT STOCK
		function get_remove_stock() {
			$subStock = $this->input->post('Stock');
			$sevas = explode('¶', $this->input->post('seva_id'));
			
			$condition = array('TET_SEVA_ID' => $sevas[1], 'TET_IS_SEVA' => $sevas[0]);
			$avlStock = $this->obj_admin_settings->get_trust_stock_available($condition);
			
			for($i = 0; $i < count($avlStock); $i++) {
				if($subStock == $avlStock[$i]->TET_SEVA_LIMIT) {
					$condition = array('TET_SL_ID' => $avlStock[$i]->TET_SL_ID);
					$this->obj_admin_settings->get_trust_delete_seva_stock($condition);
					redirect('/admin_settings/Admin_Trust_setting/get_limit_details/'.$sevas[1]);
					return;
				} else if($subStock < $avlStock[$i]->TET_SEVA_LIMIT) {
					$stock = (int)($avlStock[$i]->TET_SEVA_LIMIT) - (int)($subStock);
					$data = array('TET_SEVA_LIMIT' => $stock);
					$conditionOne = array('TET_SL_ID' => $avlStock[$i]->TET_SL_ID);
					$this->obj_admin_settings->get_trust_update_seva_stock($conditionOne,$data);
					redirect('/admin_settings/Admin_Trust_setting/get_limit_details/'.$sevas[1]);
					return;
				} else if($subStock > $avlStock[$i]->TET_SEVA_LIMIT) {
					$subStock = (int)($subStock) - (int)($avlStock[$i]->TET_SEVA_LIMIT);
					$condition = array('TET_SL_ID' => $avlStock[$i]->TET_SL_ID);
					$this->obj_admin_settings->get_trust_delete_seva_stock($condition);
				}
			}
		}
		
		//EDIT LIMIT
		function get_edit_limit() {
			$id = $this->input->post('id');
			
			$conditionOne = array('TRUST_EVENT_SEVA.TET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_trust_all_field_event_seva($conditionOne,'TET_SEVA_NAME');
			
			$conditionThree = array('TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_trust_all_field_limits($conditionThree, 'TET_SEVA_NAME');
			
			$data = array('TET_SEVA_LIMIT' => $this->input->post('sevalimit'));
			$condition = array('TET_SL_ID' => $id);
			$this->obj_admin_settings->edit_trust_limit_modal($condition,$data);
			
			redirect('/admin_settings/Admin_Trust_setting/get_limit_details/'.$this->input->post('seva_id'));
		}
		
		//EDIT STOCK
		function get_edit_stock() {
			$id = $this->input->post('idST');
			
			$conditionOne = array('TRUST_EVENT_SEVA.TET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_trust_all_field_event_seva($conditionOne,'TET_SEVA_NAME');
			
			$conditionThree = array('TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_trust_all_field_limits($conditionThree, 'TET_SEVA_NAME');
			
			$data = array('TET_SEVA_LIMIT' => $this->input->post('sevastock'), 'DATE_TIME' => date('d-m-Y H:i:s A'), 'DATE' => date('d-m-Y'));
			$condition = array('TET_SL_ID' => $id);
			$this->obj_admin_settings->edit_trust_limit_modal($condition,$data);
			
			redirect('/admin_settings/Admin_Trust_setting/get_limit_details/'.$this->input->post('seva_idST'));
		}
		
		//GET TOTAL COUNT SEVA OFFERED
		function get_count_seva_offered_main() {
			$seva = $this->input->post('sevaid');
			$date = $this->input->post('date');
			$condition = array('TET_SO_SEVA_ID' => $seva, 'TET_SO_DATE' => $date);
			$count = $this->obj_admin_settings->get_trust_fields_offered($condition);
			echo $count;
		}
		
		//EDIT STOCK
		function get_edit_stock_main() {
			$id = $this->input->post('idST');
			
			$conditionOne = array('TRUST_EVENT_SEVA.TET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_trust_all_field_event_seva($conditionOne,'TET_SEVA_NAME');
			
			$conditionThree = array('TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_trust_all_field_limits($conditionThree, 'TET_SEVA_NAME');
			
			$data = array('TET_SEVA_LIMIT' => $this->input->post('sevastock'), 'DATE_TIME' => date('d-m-Y H:i:s A'), 'DATE' => date('d-m-Y'));
			$condition = array('TET_SL_ID' => $id);
			$this->obj_admin_settings->edit_trust_limit_modal($condition,$data);
			
			redirect('/admin_settings/Admin_Trust_setting/events_setting/');
		}
		
		//EDIT Limit
		function get_edit_limit_main() {
			$id = $this->input->post('id');
			
			$conditionOne = array('TRUST_EVENT_SEVA.TET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_trust_all_field_event_seva($conditionOne,'TET_SEVA_NAME');
			
			$conditionThree = array('TRUST_EVENT_SEVA_LIMIT.TET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_trust_all_field_limits($conditionThree, 'TET_SEVA_NAME');
			
			$data = array('TET_SEVA_LIMIT' => $this->input->post('sevalimit'));
			$condition = array('TET_SL_ID' => $id);
			$this->obj_admin_settings->edit_trust_limit_modal($condition,$data);
			
			redirect('/admin_settings/Admin_Trust_setting/events_setting/');
		}
		
		//GET RECEIPT SETTING
		function receipt_setting() {
			$data['admin_settings_receipt_event'] = $this->obj_admin_settings->get_trust_event_receipt_setting();
			
			if(isset($_SESSION['Receipt_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/trust/receipt_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//UPDATE EVENT RECEIPT COUNTER
		function update_event_receipt_counter() {
			$data = array('TET_RECEIPT_COUNTER' => 0);
			$condition = array('TET_RECEIPT_COUNTER_ID' => $_POST['id']); 
			$this->obj_admin_settings->edit_trust_event_receipt_counter_modal($condition,$data);
			echo "Success";
		}
		
		//EDIT EVENT RECEIPT DETAILS
		function edit_event_receipt_details($id) {
			$data['id'] = $id;
			$condition = array('TET_RECEIPT_COUNTER_ID' => $id);
			$data['receipt_event'] = $this->obj_admin_settings->get_trust_event_receipt_setting($condition);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/trust/edit_event_receipt');
			$this->load->view('footer_home');
		}
		
		//SAVE EVENT RECEIPT DETAILS
		function save_event_receipt_details() {
			$data = array('TET_ABBR1' => $_POST['et_receipt_for'], 'TET_ABBR2' => $_POST['et_receipt_format']);
			$condition = array('TET_RECEIPT_COUNTER_ID' => $_POST['receiptid']); 
			$this->obj_admin_settings->edit_trust_event_receipt_counter_modal($condition,$data);
			redirect('/admin_settings/Admin_Trust_setting/receipt_setting/');
		}
		
		//GET INKIND ITEMS
		function inkind_items() {
			$data['inkind_items'] = $this->obj_admin_settings->get_trust_all_field_inkind();
			
			if(isset($_SESSION['Inkind_Items'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/inkind_items');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//REDIRECT TO ADD INKIND
		function add_inkind() {
			$this->load->view('header');           
			$this->load->view('admin_settings/trust/add_inkind');
			$this->load->view('footer_home');
		}
		
		//SAVE INKIND TO TABLE
		function save_inkind() {
			//Adding To Event Seva Table
			$data = array('INKIND_ITEM_NAME' => $this->input->post('item_name'),
						'INKIND_UNIT' => $this->input->post('unit_name'),
						'INKIND_DESC' => $this->input->post('inkind_desc'),
						'CREATED_BY_ID' => $this->session->userdata('userId'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-y'));
			$this->obj_admin_settings->add_trust_inkind_modal($data);
			redirect('/admin_settings/Admin_Trust_setting/inkind_items/');
		}
		
		//REDIRECT TO ADD INKIND
		function edit_inkind($id) {
			$condition = array('INKIND_ITEM_ID' => $id);
			$data['inkind_items'] = $this->obj_admin_settings->get_trust_all_field_inkind($condition);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/trust/edit_inkind');
			$this->load->view('footer_home');
		}
		
		//UPDATE INKIND TO TABLE
		function update_inkind() {
			$id = $this->input->post('inkindId');
			$condition = array('INKIND_ITEM_ID' => $id);
			//Adding To Event Seva Table
			$data = array('INKIND_ITEM_NAME' => $this->input->post('item_name'),
						'INKIND_UNIT' => $this->input->post('unit_name'),
						'INKIND_DESC' => $this->input->post('inkind_desc'),
						'CREATED_BY_ID' => $this->session->userdata('userId'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-y'));
			$this->obj_admin_settings->update_trust_inkind_modal($data,$condition);
			redirect('/admin_settings/Admin_Trust_setting/inkind_items/');
		}

		//GET Function ITEMS
		function function_types() {
			$data['fun'] = $this->db->get("FUNCTION")->result();
			
			if(isset($_SESSION['Function_Types'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/functionType');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		//REDIRECT TO ADD Function
		function functionTypeAdd() {
			$this->load->view('header');           
			$this->load->view('admin_settings/trust/functionTypeAdd');
			$this->load->view('footer_home');
		}
		
		//SAVE Function TO TABLE
		function functionTypeSave() {
			//Adding To Event Seva Table
			$data = array(
						'FN_NAME' => $this->input->post('item_name'),
						'FN_DESC' => $this->input->post('inkind_desc'),
						'CREATED_BY_ID' => $this->session->userdata('userId'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-y')
					);
			$this->db->insert("FUNCTION",$data);
			redirect('/admin_settings/Admin_Trust_setting/function_types/');
		}
		
		//REDIRECT TO ADD Function
		function functionTypeEdit($id) {
			$condition = array('FN_ID' => $id);
			$data['fun'] = $this->db->where($condition)->get("FUNCTION")->result();
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/trust/functionTypeEdit');
			$this->load->view('footer_home');
		}
		
		//UPDATE Function TO TABLE
		function functionTypeUpdate() {
			$id = $this->input->post('inkindId');
			$condition = array('FN_ID' => $id);
			//Adding To Event Seva Table
			$data = array('FN_NAME' => $this->input->post('item_name'),
						'FN_DESC' => $this->input->post('inkind_desc'),
						'CREATED_BY_ID' => $this->session->userdata('userId'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-y'));

						$this->db->where($condition)->update("FUNCTION",$data);
			redirect('/admin_settings/Admin_Trust_setting/function_types/');
		}
		
		//TRUST EVENT CHEQUE REMMITTANCE YYY
		function eventChequeRemmittance($start = 0) {
		$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1];
			// print_r($data['bank']);
			unset($_SESSION['chequeNumber']);
			$cheque_number = '';
			//pagination
			$condition = array('TET_RECEIPT_PAYMENT_METHOD' => "Cheque",'TET_RECEIPT_ACTIVE'=>1); 
			$data['checkRemmittance'] = $this->obj_admin_settings->get_trust_all_chequeRemmittance($fromDate,$toDate,10,$start, $condition,$cheque_number,"PAYMENT_STATUS");
			$data['bank'] = $this->obj_finance->get_banks();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_Trust_setting/eventChequeRemmittance';
			$config['total_rows'] = $this->obj_admin_settings->get_trust_all_chequeRemmittanceCount($condition,$cheque_number,"PAYMENT_STATUS");
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
			
			if(isset($_SESSION['Cheque_Remmittance'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/trust/trustEventCheckRemmittance');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		function SearcheventChequeRemmittance($start = 0) {
		if(isset($_POST['chequeNumber'])){
				$_SESSION['chequeNumber'] = $this->input->post('chequeNumber');
				//the cheque_number is a result from the post call
				$cheque_number = $this->input->post('chequeNumber');
				$data['cheque_Number'] = $cheque_number;
			} else if(isset($_SESSION['chequeNumber'])) {
				$cheque_number = $_SESSION['chequeNumber'];
				$data['cheque_Number'] = $cheque_number;
			} else {
				$cheque_number = '';
			}
			
						//pagination
			$condition = array('TET_RECEIPT_PAYMENT_METHOD' => "Cheque",'TET_RECEIPT_ACTIVE'=>1); 
			$data['checkRemmittance'] = $this->obj_admin_settings->get_trust_all_chequeRemmittance(10,$start, $condition, $cheque_number, "PAYMENT_STATUS");
			$data['bank'] = $this->obj_finance->get_banks();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_Trust_setting/SearcheventChequeRemmittance';
			$config['total_rows'] = $this->obj_admin_settings->get_trust_all_chequeRemmittanceCount($condition, $cheque_number, "PAYMENT_STATUS");
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
			
			if(isset($_SESSION['Cheque_Remmittance'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/trust/trustEventCheckRemmittance');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//TRUST EDIT CHEQUE REMMITTANCE
		function edit_chequeRemmittance() {
		////////////////////////////////////////////////  temple like cheque remmittance start by adithya///////////////////////////
        $updateId = @$_POST['updateId'];
		// $cheque = $_POST['cheque'];
		$total = $_POST['total'];
		$bank = $_POST['bank'];
		$TET_RECEIPT_ID = $_POST['TEUC_RECEIPT_ID'];
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
		//**************************************************************************************************************************************************************

		$sqlFinTrans = "SELECT T_RECEIPT_ID,T_VOUCHER_NO FROM `trust_financial_ledger_transcations` WHERE T_RECEIPT_ID = $TET_RECEIPT_ID";    
		$queryFinTrans = $this->db->query($sqlFinTrans);
		$financialLedgerDetails = $queryFinTrans->first_row();
		$replaceVoucherNo=$financialLedgerDetails->T_VOUCHER_NO;
		if ($queryFinTrans->num_rows() > 0) {
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

			$CHEQUE_NO = $_POST['TUC_CHEQUE_NO'];
			$BANK_NAME = str_replace("'","\'",$_POST['TUC_BANK_NAME']);
			$BRANCH_NAME = str_replace("'","\'",$_POST['TUC_BRANCH_NAME']);
			$CHEQUE_DATE = $_POST['TUC_CHEQUE_DATE'];


			$dateTime = date('d-m-Y H:i:s A');
			$aidR = $bank;
			$RECEIPT_ID = $receiptDetails->TET_RECEIPT_ID;
			$catId = $receiptDetails->TET_RECEIPT_CATEGORY_ID;
			$amtsR = $receiptDetails->PRICE;
			$tDateR = $receiptDetails->TET_RECEIPT_DATE;
			$flt_user = $_SESSION['userId'];
			$RECEIPT_PAYMENT_METHOD = $receiptDetails->TET_RECEIPT_PAYMENT_METHOD;
			$PAYMENT_STATUS = $receiptDetails->PAYMENT_STATUS;
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
		

///////////////////////////////////////////////// temple like cheque remmitance end by adithya/////////////////////////////
                if($_POST) {
                	$chequedate = $_POST['chequedate'];
                	$receiptNo = $_POST['TET_RECEIPT_NO'];
                	$bank = $_POST['bank'];
                }

                $this->db->where('TET_RECEIPT_NO',$receiptNo);
				$this->db->update('TRUST_EVENT_RECEIPT',
				 array('PAYMENT_CONFIRMED_BY_NAME'=>$_SESSION['userFullName'],'PAYMENT_CONFIRMED_BY_NAME'=>$_SESSION['userFullName'],'CHEQUE_CREDITED_DATE'=>$chequedate,'PAYMENT_STATUS'=>'Completed','PAYMENT_CONFIRMED_BY'=>$_SESSION['userId'],'PAYMENT_DATE_TIME'=>date('d-m-Y H:i:s A'),'PAYMENT_DATE'=>date('d-m-Y')));
				$this->eventChequeRemmittance();

			
			redirect("EventEOD_Tally");
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
		
		//GET USERS SETTING
		function users_setting() {
			//$condition = array('USER_ACTIVE' => 1); 
			if($this->session->userdata('userGroup') != 6) {
				$condition_One = array('USER_GROUP !=' =>  6); 
				$data['admin_settings_users'] = $this->obj_admin_settings->get_all_field_users($condition_One);
			} else {
				$data['admin_settings_users'] = $this->obj_admin_settings->get_all_field_users();
			}
			
			if(isset($_SESSION['Users_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/trust/users_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//ADD USER
		function add_user() {
			$groupId = $this->session->userdata('userGroup');
			if($groupId != 6) {
				$condition_One = array('GROUP_ACTIVE' => 1, 'GROUP_ID !=' =>  6); 
			} else {
				$condition_One = array('GROUP_ACTIVE' => 1); 
			}
			$data['groups'] = $this->obj_admin_settings->get_group_rights_data($condition_One);
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/trust/add_user');
			$this->load->view('footer_home');
		}
		
		//EDIT USER
		function edit_user($id) {
			$groupId = $this->session->userdata('userGroup');
			if($groupId != 6) {
				$condition_One = array('GROUP_ACTIVE' => 1, 'GROUP_ID !=' => 6); 
			} else {
				$condition_One = array('GROUP_ACTIVE' => 1); 
			}
			$data['groups'] = $this->obj_admin_settings->get_group_rights_data($condition_One);
			$condition = array('USER_ID' => $id);
			$data['edit_user'] = $this->obj_admin_settings->get_all_field_users($condition);
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/trust/edit_user');
			$this->load->view('footer_home');
		}
		
		//CHANGE PASSWORD
		function change_password($id) {
			$data['id'] = $id;
			$condition = array('USER_ID' => $id); 
			$data['users'] = $this->obj_admin_settings->get_all_field_users($condition);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/trust/change_password');
			$this->load->view('footer_home');
		}
		
		//INSERT USER
		function insert_user() {
			$userGroup = explode('|', $this->input->post('user_group'));
			$password1 = $this->input->post('user_pswd');
			$salt = sha1($password1);
        	$password = md5($salt . $password1);
			//Adding To Event Seva Table
			$data = array('USER_FULL_NAME' => $this->input->post('full_name'),
						'USER_EMAIL' => $this->input->post('user_email'),
						'USER_PHONE' => $this->input->post('user_phone'),
						'USER_ADDRESS' => $this->input->post('user_address'),
						'USER_GROUP' => $userGroup[0],
						'CREATION_TIME' => date('d-m-Y H:i:s A'),
						'CREATED_BY' => $this->session->userdata('userId'),
						'USER_PASSWORD' => $password,
						'USER_LOGIN_NAME' => $this->input->post('user_name'),
						'USER_ACTIVE' => $this->input->post('user_active'),
						'USER_TYPE' => $userGroup[1]);
			$this->obj_admin_settings->add_user_modal($data);
			redirect('/admin_settings/Admin_Trust_setting/users_setting/');
		}
		
		//UPDATE USER
		function update_user() {
			$userGroup = explode('|', $this->input->post('user_group'));
			$condition = array('USER_ID' => $this->input->post('userid'));
			//Adding To Event Seva Table
			$data = array('USER_FULL_NAME' => $this->input->post('full_name'),
						'USER_EMAIL' => $this->input->post('user_email'),
						'USER_PHONE' => $this->input->post('user_phone'),
						'USER_ADDRESS' => $this->input->post('user_address'),
						'USER_GROUP' => $userGroup[0],
						'USER_LOGIN_NAME' => $this->input->post('user_name'),
						'USER_ACTIVE' => $this->input->post('user_active'),
						'USER_TYPE' => $userGroup[1]);
						
			$this->obj_admin_settings->add_update_user_modal($data,$condition);
			redirect('/admin_settings/Admin_Trust_setting/users_setting/');
		}
		
		//INSERT CHANGE PASSWORD
		function insert_change_password() {
			//Adding To Event Seva Table
			$password1 = $this->input->post('user_pswd');
			$salt = sha1($password1);
        	$password = md5($salt . $password1);
			
			$data = array('USER_PASSWORD' => $password);
			$condition = array('USER_ID' => $this->input->post('userid'));
			$this->obj_admin_settings->add_change_password_modal($data,$condition);
			redirect('/admin_settings/Admin_Trust_setting/users_setting/');
		}
		
		//GET GROUP SETTING
		function groups_setting() {
			//$condition_One = array('GROUP_ACTIVE' => 1); 
			if($this->session->userdata('userGroup') != 6) {
				// code added by adithya
				$groupId = explode(",",$this->session->userdata('userGroup'));
				$data['user_group_id'] = $groupId[0];
				// ends here
				$condition_One = array('GROUP_ID !=' =>  6); 
				$data['admin_settings_group_rights'] = $this->obj_admin_settings->get_group_trust_rights_data($condition_One);
			} else {
				$data['user_group_id'] = $this->session->userdata('userGroup');
				$data['admin_settings_group_rights'] = $this->obj_admin_settings->get_group_trust_rights_data();
			}
			
			if(isset($_SESSION['Group_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/trust/groups_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//EDIT GROUP RIGHTS
		function edit_group_rights($id) {
			$condition_One = array('GROUP_ID' => $id); 
			$data['edit_group'] = $this->obj_admin_settings->get_group_trust_rights_data($condition_One);
			//print_r($data['edit_group']);
			$this->load->view('header', $data);          
			$this->load->view('admin_settings/trust/edit_group_rights');
			$this->load->view('footer_home');
		}
		
		//UPDATE GROUP
		function update_group() {
			
			$condition = array('GROUP_ID' => $_POST['groupid']); 
			//Updating To Group Table
			$data = array('GROUP_NAME' => $this->input->post('group_name'),
						'GROUP_DESC' => $this->input->post('group_desc'),
						'GROUP_ACTIVE' => $this->input->post('group_active'));
			$this->obj_admin_settings->add_update_group_modal($data,$condition);
			
			if(isset($_POST['add'])) {
				$add = 1;
				$CA = array('GROUP_ID' => $_POST['groupid'], 'TR_ID' => $add);
				$addCA = $this->obj_admin_settings->get_grouptrustright_available($CA);
				if($addCA == 0){
					$dataAdd = array('GROUP_ID' => $_POST['groupid'], 'TR_ID' => $add);
					$this->obj_admin_settings->get_insert_trust_rights($dataAdd);
				}
			} else if($this->input->post('addId') != "") {
				$conditionAdd = array('GTR_ID' => $this->input->post('addId'));
				$this->obj_admin_settings->get_delete_trust_rights($conditionAdd);
			}
			
			if(isset($_POST['edit'])) {
				$edit = 2;
				$CE = array('GROUP_ID' => $_POST['groupid'], 'TR_ID' => $edit);
				$editCE = $this->obj_admin_settings->get_grouptrustright_available($CE);
				if($editCE == 0){
					$dataEdit = array('GROUP_ID' => $_POST['groupid'], 'TR_ID' => $edit);
					$this->obj_admin_settings->get_insert_trust_rights($dataEdit);
				}
			} else if($this->input->post('editId') != "") {
				$conditionEdit = array('GTR_ID' => $this->input->post('editId'));
				$this->obj_admin_settings->get_delete_trust_rights($conditionEdit);
			}
			
			if(isset($_POST['actDct'])) {
				$actDct = 3;
				$CAD = array('GROUP_ID' => $_POST['groupid'], 'TR_ID' => $actDct);
				$actDctCAD = $this->obj_admin_settings->get_grouptrustright_available($CAD);
				if($actDctCAD == 0){
					$dataActDct = array('GROUP_ID' => $_POST['groupid'], 'TR_ID' => $actDct);
					$this->obj_admin_settings->get_insert_trust_rights($dataActDct);
				}
			} else if($this->input->post('actDctId') != "") {
				$conditionActDct = array('GTR_ID' => $this->input->post('actDctId'));
				$this->obj_admin_settings->get_delete_trust_rights($conditionActDct);
			}
			
			if(isset($_POST['authorise'])) {
				$auth = 4;
				$CAUTH = array('GROUP_ID' => $_POST['groupid'], 'TR_ID' => $auth);
				$authCAUTH = $this->obj_admin_settings->get_grouptrustright_available($CAUTH);
				if($authCAUTH == 0){
					$dataAuth = array('GROUP_ID' => $_POST['groupid'], 'TR_ID' => $auth);
					$this->obj_admin_settings->get_insert_trust_rights($dataAuth);
				}
			} else if($this->input->post('authoriseId') != "") {
				$conditionAuth = array('GTR_ID' => $this->input->post('authoriseId'));
				$this->obj_admin_settings->get_delete_trust_rights($conditionAuth);
			}

			//NOTIFICATION ADITHYA
			if(isset($_POST['notification'])) {
				$notif = 5;
				$CN = array('GROUP_ID' => $_POST['groupid'], 'TR_ID' => $notif);
				$CNOTIF = $this->obj_admin_settings->get_grouptrustright_available($CN);
				if($CNOTIF == 0){
					$dataNotif = array('GROUP_ID' => $_POST['groupid'], 'TR_ID' => $notif);
					$this->obj_admin_settings->get_insert_trust_rights($dataNotif);
				}
			} else if($this->input->post('notifyId') != "") {
				$conditionNotif = array('GR_ID' => $this->input->post('notifyId'));
				$this->obj_admin_settings->get_delete_rights($conditionNotif);
			}
			
			//USER SETTINGS
			if(isset($_POST['userSettings'])) {
				$userSettings = 1;
				$US = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $userSettings);
				$userSettingsUS = $this->obj_admin_settings->get_group_trust_menu_right_available($US);
				if($userSettingsUS == 0){
					$dataUS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $userSettings, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataUS);
				} else {
					$conditionUS = array('GTM_ID' => $userSettingsUS[0]->GTM_ID);
					$dataUS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionUS,$dataUS);
				}
				
				if(isset($_POST['userSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('userSettingsId') != "") {
				$conditionUS = array('GTM_ID' => $this->input->post('userSettingsId'));
				$dataUS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionUS,$dataUS);
				
				if(isset($_POST['userSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$userSettings = 1;
				$dataCheck = array('TP_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//GROUP SETTINGS
			if(isset($_POST['groupSettings'])) {
				$groupSettings = 2;
				$GS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $groupSettings);
				$groupSettingsGS = $this->obj_admin_settings->get_group_trust_menu_right_available($GS);
				if($groupSettingsGS == 0){
					$dataGS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $groupSettings, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataGS);
				} else {
					$conditionGS = array('GTM_ID' => $groupSettingsGS[0]->GTM_ID);
					$dataGS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionGS,$dataGS);
				}
				
				if(isset($_POST['groupSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('groupSettingsId') != "") {
				$conditionGS = array('GTM_ID' => $this->input->post('groupSettingsId'));
				$dataGS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionGS,$dataGS);
				
				if(isset($_POST['groupSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$groupSettings = 2;
				$dataCheck = array('TP_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//HALL SETTINGS
			if(isset($_POST['hallSettings'])) {
				$hallSettings = 3;
				$HS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $hallSettings);
				$hallSettingsHS = $this->obj_admin_settings->get_group_trust_menu_right_available($HS);
				if($hallSettingsHS == 0){
					$dataHS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $hallSettings, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataHS);
				} else {
					$conditionHS = array('GTM_ID' => $hallSettingsHS[0]->GTM_ID);
					$dataHS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionHS,$dataHS);
				}
				
				if(isset($_POST['hallSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $hallSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $hallSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $hallSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $hallSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('hallSettingsId') != "") {
				$conditionHS = array('GTM_ID' => $this->input->post('hallSettingsId'));
				$dataHS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionHS,$dataHS);
				
				if(isset($_POST['hallSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$hallSettings = 3;
				$dataCheck = array('TP_ID' => $hallSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $hallSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $hallSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $hallSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//BOOK HALL
			if(isset($_POST['bookHall'])) {
				$bookHall = 4;
				$HS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $bookHall);
				$bookHallBH = $this->obj_admin_settings->get_group_trust_menu_right_available($HS);
				if($bookHallBH == 0){
					$dataBH = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $bookHall, 'TM_ID' => 2, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataBH);
				} else {
					$conditionBH = array('GTM_ID' => $bookHallBH[0]->GTM_ID);
					$dataBH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionBH,$dataBH);
				}
				
				if(isset($_POST['bookHall'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $bookHall, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $bookHall, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $bookHall, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $bookHall, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('bookHallId') != "") {
				$conditionBH = array('GTM_ID' => $this->input->post('bookHallId'));
				$dataBH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionBH,$dataBH);
				
				if(isset($_POST['bookHall'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$bookHall = 3;
				$dataCheck = array('TP_ID' => $bookHall, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $bookHall, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $bookHall, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $bookHall, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//ALL HALL BOOKINGS
			if(isset($_POST['allHallBooking'])) {
				$allHallBooking = 5;
				$AHB = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $allHallBooking);
				$allHallBookingAHB = $this->obj_admin_settings->get_group_trust_menu_right_available($AHB);
				if($allHallBookingAHB == 0){
					$dataAHB = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $allHallBooking, 'TM_ID' => 2, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataAHB);
				} else {
					$conditionAHB = array('GTM_ID' => $allHallBookingAHB[0]->GTM_ID);
					$dataAHB = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionAHB,$dataAHB);
				}
				
				if(isset($_POST['allHallBooking'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $allHallBooking, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $allHallBooking, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $allHallBooking, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $allHallBooking, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('allHallBookingId') != "") {
				$conditionAHB = array('GTM_ID' => $this->input->post('allHallBookingId'));
				$dataAHB = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionAHB,$dataAHB);
				
				if(isset($_POST['allHallBooking'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allHallBooking = 5;
				$dataCheck = array('TP_ID' => $allHallBooking, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $allHallBooking, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $allHallBooking, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $allHallBooking, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//ALL TRUST RECEIPT
			if(isset($_POST['allTrustReceipt'])) {
				$allTrustReceipt = 6;
				$ATR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $allTrustReceipt);
				$allTrustReceiptATR = $this->obj_admin_settings->get_group_trust_menu_right_available($ATR);
				if($allTrustReceiptATR == 0){
					$dataATR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $allTrustReceipt, 'TM_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataATR);
				} else {
					$conditionATR = array('GTM_ID' => $allTrustReceiptATR[0]->GTM_ID);
					$dataATR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionATR,$dataATR);
				}
				
				if(isset($_POST['allTrustReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $allTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $allTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $allTrustReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $allTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('allTrustReceiptId') != "") {
				$conditionATR = array('GTM_ID' => $this->input->post('allTrustReceiptId'));
				$dataATR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionATR,$dataATR);
				
				if(isset($_POST['allTrustReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allTrustReceipt = 6;
				$dataCheck = array('TP_ID' => $allTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $allTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $allTrustReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $allTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//NEW TRUST RECEIPT
			if(isset($_POST['newTrustReceipt'])) {
				$newTrustReceipt = 7;
				$NTR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $newTrustReceipt);
				$newTrustReceiptNTR = $this->obj_admin_settings->get_group_trust_menu_right_available($NTR);
				if($newTrustReceiptNTR == 0){
					$dataNTR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $newTrustReceipt, 'TM_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataNTR);
				} else {
					$conditionNTR = array('GTM_ID' => $newTrustReceiptNTR[0]->GTM_ID);
					$dataNTR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionNTR,$dataNTR);
				}
				
				if(isset($_POST['newTrustReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $newTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $newTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $newTrustReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $newTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('newTrustReceiptId') != "") {
				$conditionNTR = array('GTM_ID' => $this->input->post('newTrustReceiptId'));
				$dataNTR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionNTR,$dataNTR);
				
				if(isset($_POST['newTrustReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$newTrustReceipt = 7;
				$dataCheck = array('TP_ID' => $newTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $newTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $newTrustReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $newTrustReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//BLOCK DATE SETTINGS
			if(isset($_POST['blockDateSettings'])) {
				$blockDateSettings = 8;
				$BDS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $blockDateSettings);
				$blockDateSettingsBDS = $this->obj_admin_settings->get_group_trust_menu_right_available($BDS);
				if($blockDateSettingsBDS == 0){
					$dataBDS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $blockDateSettings, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataBDS);
				} else {
					$conditionBDS = array('GTM_ID' => $blockDateSettingsBDS[0]->GTM_ID);
					$dataBDS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionBDS,$dataBDS);
				}
				
				if(isset($_POST['blockDateSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $blockDateSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $blockDateSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $blockDateSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $blockDateSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('blockDateSettingsId') != "") {
				$conditionBDS = array('GTM_ID' => $this->input->post('blockDateSettingsId'));
				$dataBDS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionBDS,$dataBDS);
				
				if(isset($_POST['blockDateSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$blockDateSettings = 8;
				$dataCheck = array('TP_ID' => $blockDateSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $blockDateSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $blockDateSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $blockDateSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//TRUST RECEIPT REPORT
			if(isset($_POST['trustReceiptReport'])) {
				$trustReceiptReport = 9;
				$TRR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $trustReceiptReport);
				$trustReceiptReportTRR = $this->obj_admin_settings->get_group_trust_menu_right_available($TRR);
				if($trustReceiptReportTRR == 0){
					$dataTRR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $trustReceiptReport, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataTRR);
				} else {
					$conditionTRR = array('GTM_ID' => $trustReceiptReportTRR[0]->GTM_ID);
					$dataTRR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionTRR,$dataTRR);
				}
				
				if(isset($_POST['trustReceiptReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $trustReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $trustReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $trustReceiptReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trustReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('trustReceiptReportId') != "") {
				$conditionTRR = array('GTM_ID' => $this->input->post('trustReceiptReportId'));
				$dataTRR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionTRR,$dataTRR);
				
				if(isset($_POST['trustReceiptReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$trustReceiptReport = 9;
				$dataCheck = array('TP_ID' => $trustReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $trustReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $trustReceiptReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $trustReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//TRUST MIS REPORT
			if(isset($_POST['trustMISReport'])) {
				$trustMISReport = 10;
				$TMR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $trustMISReport);
				$trustMISReportTMR = $this->obj_admin_settings->get_group_trust_menu_right_available($TMR);
				if($trustMISReportTMR == 0){
					$dataTMR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $trustMISReport, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataTMR);
				} else {
					$conditionTMR = array('GTM_ID' => $trustMISReportTMR[0]->GTM_ID);
					$dataTMR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionTMR,$dataTMR);
				}
				
				if(isset($_POST['trustMISReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $trustMISReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $trustMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $trustMISReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trustMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('trustMISReportId') != "") {
				$conditionTMR = array('GTM_ID' => $this->input->post('trustMISReportId'));
				$dataTMR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionTMR,$dataTMR);
				
				if(isset($_POST['trustMISReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$trustMISReport = 10;
				$dataCheck = array('TP_ID' => $trustMISReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $trustMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $trustMISReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $trustMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			
			//EVENT SEVA SUMMARY
			if(isset($_POST['eventSevaSummary'])) {
				$eventSevaSummary = 45;
				$TMR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventSevaSummary);
				$eventSevaSummaryTMR = $this->obj_admin_settings->get_group_trust_menu_right_available($TMR);
				if($eventSevaSummaryTMR == 0){
					$dataTMR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventSevaSummary, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataTMR);
				} else {
					$conditionTMR = array('GTM_ID' => $eventSevaSummaryTMR[0]->GTM_ID);
					$dataTMR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionTMR,$dataTMR);
				}
				
				if(isset($_POST['eventSevaSummary'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eventSevaSummaryId') != "") {
				$conditionTMR = array('GTM_ID' => $this->input->post('eventSevaSummaryId'));
				$dataTMR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionTMR,$dataTMR);
				
				if(isset($_POST['eventSevaSummary'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventSevaSummary = 45;
				$dataCheck = array('TP_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}			
			
			//TRUST EOD REPORT
			if(isset($_POST['eodReport'])) {
				$eodReport = 11;
				$EODR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eodReport);
				$eodReportEODR = $this->obj_admin_settings->get_group_trust_menu_right_available($EODR);
				if($eodReportEODR == 0){
					$dataEODR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eodReport, 'TM_ID' => 5, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataEODR);
				} else {
					$conditionEODR = array('GTM_ID' => $eodReportEODR[0]->GTM_ID);
					$dataEODR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionEODR,$dataEODR);
				}
				
				if(isset($_POST['eodReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $eodReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $eodReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eodReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $eodReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eodReportId') != "") {
				$conditionEODR = array('GTM_ID' => $this->input->post('eodReportId'));
				$dataEODR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionEODR,$dataEODR);
				
				if(isset($_POST['eodReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eodReport = 11;
				$dataCheck = array('TP_ID' => $eodReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $eodReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eodReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $eodReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//TRUST EOD TALLY
			if(isset($_POST['eodTally'])) {
				$eodTally = 12;
				$EODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eodTally);
				$eodTallyEODT = $this->obj_admin_settings->get_group_trust_menu_right_available($EODT);
				if($eodTallyEODT == 0){
					$dataEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eodTally, 'TM_ID' => 5, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataEODT);
				} else {
					$conditionEODT = array('GTM_ID' => $eodTallyEODT[0]->GTM_ID);
					$dataEODT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionEODT,$dataEODT);
				}
				
				if(isset($_POST['eodTally'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $eodTally, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $eodTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eodTally, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $eodTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eodTallyId') != "") {
				$conditionEODT = array('GTM_ID' => $this->input->post('eodTallyId'));
				$dataEODT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionEODT,$dataEODT);
				
				if(isset($_POST['eodTally'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eodTally = 12;
				$dataCheck = array('TP_ID' => $eodTally, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $eodTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eodTally, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $eodTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//BANK SETTINGS
			if(isset($_POST['bankSettings'])) {
				$bankSettings = 13;
				$BS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $bankSettings);
				$bankSettingsBS = $this->obj_admin_settings->get_group_trust_menu_right_available($BS);
				if($bankSettingsBS == 0){
					$dataBS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $bankSettings, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataBS);
				} else {
					$conditionBS = array('GTM_ID' => $bankSettingsBS[0]->GTM_ID);
					$dataBS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionBS,$dataBS);
				}
				
				if(isset($_POST['bankSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('bankSettingsId') != "") {
				$conditionBS = array('GTM_ID' => $this->input->post('bankSettingsId'));
				$dataBS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionBS,$dataBS);
				
				if(isset($_POST['bankSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$bankSettings = 13;
				$dataCheck = array('TP_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//HALL BOOKINGS REPORT
			if(isset($_POST['hallBookingsReport'])) {
				$hallBookingsReport = 14;
				$HBR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $hallBookingsReport);
				$hallBookingsReportHBR = $this->obj_admin_settings->get_group_trust_menu_right_available($HBR);
				if($hallBookingsReportHBR == 0){
					$dataHBR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $hallBookingsReport, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataHBR);
				} else {
					$conditionHBR = array('GTM_ID' => $hallBookingsReportHBR[0]->GTM_ID);
					$dataHBR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionHBR,$dataHBR);
				}
				
				if(isset($_POST['hallBookingsReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $hallBookingsReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $hallBookingsReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $hallBookingsReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $hallBookingsReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('hallBookingsReportId') != "") {
				$conditionHBR = array('GTM_ID' => $this->input->post('hallBookingsReportId'));
				$dataHBR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionHBR,$dataHBR);
				
				if(isset($_POST['hallBookingsReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$hallBookingsReport = 14;
				$dataCheck = array('TP_ID' => $hallBookingsReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $hallBookingsReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $hallBookingsReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $hallBookingsReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//CHECK REMMITTANCE
			if(isset($_POST['checkRemmittance'])) {
				$checkRemmittance = 15;
				$CR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $checkRemmittance);
				$checkRemmittanceCR = $this->obj_admin_settings->get_group_trust_menu_right_available($CR);
				if($checkRemmittanceCR == 0){
					$dataCR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $checkRemmittance, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataCR);
				} else {
					$conditionCR = array('GTM_ID' => $checkRemmittanceCR[0]->GTM_ID);
					$dataCR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionCR,$dataCR);
				}
				
				if(isset($_POST['checkRemmittance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $checkRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $checkRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $checkRemmittance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $checkRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('checkRemmittanceId') != "") {
				$conditionCR = array('GTM_ID' => $this->input->post('checkRemmittanceId'));
				$dataCR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionCR,$dataCR);
				
				if(isset($_POST['checkRemmittance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$checkRemmittance = 15;
				$dataCheck = array('TP_ID' => $checkRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $checkRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $checkRemmittance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $checkRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['eventSevaSettings'])) {
				$eventSevaSettings = 16;
				$ESS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventSevaSettings);
				$eventSevaSettingsESS = $this->obj_admin_settings->get_group_trust_menu_right_available($ESS);
				if($eventSevaSettingsESS == 0){
					$dataESS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventSevaSettings, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataESS);
				} else {
					$conditionESS = array('GTM_ID' => $eventSevaSettingsESS[0]->GTM_ID);
					$dataESS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionESS,$dataESS);
				}
				
				if(isset($_POST['eventSevaSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eventSevaSettingsId') != "") {
				$conditionESS = array('GTM_ID' => $this->input->post('eventSevaSettingsId'));
				$dataESS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionESS,$dataESS);
				
				if(isset($_POST['eventSevaSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventSevaSettings = 16;
				$dataCheck = array('TP_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['chequeRemmittance'])) {
				$chequeRemmittance = 17;
				$CR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $chequeRemmittance);
				$chequeRemmittanceCR = $this->obj_admin_settings->get_group_trust_menu_right_available($CR);
				if($chequeRemmittanceCR == 0){
					$dataCR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $chequeRemmittance, 'TM_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataCR);
				} else {
					$conditionCR = array('GTM_ID' => $chequeRemmittanceCR[0]->GTM_ID);
					$dataCR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionCR,$dataCR);
				}
				
				if(isset($_POST['chequeRemmittance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('chequeRemmittanceId') != "") {
				$conditionCR = array('GTM_ID' => $this->input->post('chequeRemmittanceId'));
				$dataCR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionCR,$dataCR);
				
				if(isset($_POST['chequeRemmittance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$chequeRemmittance = 17;
				$dataCheck = array('TP_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);

					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['receiptSettings'])) {
				$receiptSettings = 18;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $receiptSettings);
				$receiptSettingsRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($receiptSettingsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $receiptSettings, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $receiptSettingsRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['receiptSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('receiptSettingsId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('receiptSettingsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['receiptSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$receiptSettings = 18;
				$dataCheck = array('TP_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			// adding finance setting page by adithya on 20-12-2023 start
            // Voucher Counter
			if(isset($_POST['voucherCounter'])) {
				$voucherCounter = 62;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $voucherCounter);
				$voucherCounterRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($voucherCounterRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $voucherCounter, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $voucherCounterRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['voucherCounter'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('voucherCounterId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('voucherCounterId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['voucherCounter'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$voucherCounter = 62;
				$dataCheck = array('TP_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			// Voucher Counter ends

			// Finance Prerequisites
			if(isset($_POST['financePrerequisites'])) {
				$financePrerequisites = 61;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financePrerequisites);
				$financePrerequisitesRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($financePrerequisitesRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financePrerequisites, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $financePrerequisitesRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financePrerequisites'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('financePrerequisitesId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('financePrerequisitesId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financePrerequisites'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financePrerequisites = 61;
				$dataCheck = array('TP_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			// Finance Prerequisites ends

			// Cheque Configuration
			if(isset($_POST['bankChequeConfiguration'])) {
				$bankChequeConfiguration = 64;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $bankChequeConfiguration);
				$bankChequeConfigurationRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($bankChequeConfigurationRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $bankChequeConfiguration, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $bankChequeConfigurationRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['bankChequeConfiguration'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('bankChequeConfigurationId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('bankChequeConfigurationId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['bankChequeConfiguration'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$bankChequeConfiguration = 64;
				$dataCheck = array('TP_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			// Cheque Configuration ends
			// adding finance setting page by adithya on 20-12-2023 end
			
			if(isset($_POST['inkindItems'])) {
				$inkindItems = 19;
				$II = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $inkindItems);
				$inkindItemII = $this->obj_admin_settings->get_group_trust_menu_right_available($II);
				if($inkindItemII == 0){
					$dataII = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $inkindItems, 'TM_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataII);
				} else {
					$conditionII = array('GTM_ID' => $inkindItemII[0]->GTM_ID);
					$dataII = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionII,$dataII);
				}
				
				if(isset($_POST['inkindItems'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('inkindItemsId') != "") {
				$conditionII = array('GTM_ID' => $this->input->post('inkindItemsId'));
				$dataII = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionII,$dataII);
				
				if(isset($_POST['inkindItems'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$inkindItems = 19;
				$dataCheck = array('TP_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['eventSevas'])) {
				$eventSevas = 20;
				$ES = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventSevas);
				$eventSevasES = $this->obj_admin_settings->get_group_trust_menu_right_available($ES);
				if($eventSevasES == 0){
					$dataES = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventSevas, 'TM_ID' => 7, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataES);
				} else {
					$conditionES = array('GTM_ID' => $eventSevasES[0]->GTM_ID);
					$dataES = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionES,$dataES);
				}
				
				if(isset($_POST['eventSevas'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eventSevasId') != "") {
				$conditionES = array('GTM_ID' => $this->input->post('eventSevasId'));
				$dataES = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionES,$dataES);
				
				if(isset($_POST['eventSevas'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventSevas = 20;
				$dataCheck = array('TP_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['allEventReceipt'])) {
				$allEventReceipt = 21;
				$AER = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $allEventReceipt);
				$allEventReceiptAER = $this->obj_admin_settings->get_group_trust_menu_right_available($AER);
				if($allEventReceiptAER == 0){
					$dataAER = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $allEventReceipt, 'TM_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataAER);
				} else {
					$conditionAER = array('GTM_ID' => $allEventReceiptAER[0]->GTM_ID);
					$dataAER = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionAER,$dataAER);
				}
				
				if(isset($_POST['allEventReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('allEventReceiptId') != "") {
				$conditionAER = array('GTM_ID' => $this->input->post('allEventReceiptId'));
				$dataAER = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionAER,$dataAER);
				
				if(isset($_POST['allEventReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allEventReceipt = 21;
				$dataCheck = array('TP_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['eventSeva'])) {
				$eventSeva = 22;
				$ES = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventSeva);
				$eventSevaES = $this->obj_admin_settings->get_group_trust_menu_right_available($ES);
				if($eventSevaES == 0){
					$dataES = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventSeva, 'TM_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataES);
				} else {
					$conditionES = array('GTM_ID' => $eventSevaES[0]->GTM_ID);
					$dataES = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionES,$dataES);
				}
				
				if(isset($_POST['eventSeva'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eventSevaId') != "") {
				$conditionES = array('GTM_ID' => $this->input->post('eventSevaId'));
				$dataES = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionES,$dataES);
				
				if(isset($_POST['eventSeva'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventSeva = 22;
				$dataCheck = array('TP_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['eventDonationKanike'])) {
				$eventDonationKanike = 23;
				$EDK = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventDonationKanike);
				$eventDonationKanikeEDK = $this->obj_admin_settings->get_group_trust_menu_right_available($EDK);
				if($eventDonationKanikeEDK == 0){
					$dataEDK = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventDonationKanike, 'TM_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataEDK);
				} else {
					$conditionEDK = array('GTM_ID' => $eventDonationKanikeEDK[0]->GTM_ID);
					$dataEDK = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionEDK,$dataEDK);
				}
				
				if(isset($_POST['eventDonationKanike'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eventDonationKanikeId') != "") {
				$conditionEDK = array('GTM_ID' => $this->input->post('eventDonationKanikeId'));
				$dataEDK = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionEDK,$dataEDK);
				
				if(isset($_POST['eventDonationKanike'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventDonationKanike = 23;
				$dataCheck = array('TP_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deityEventHundi'])) {
				$deityEventHundi = 24;
				$DEH = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $deityEventHundi);
				$deityEventHundiDEH = $this->obj_admin_settings->get_group_trust_menu_right_available($DEH);
				if($deityEventHundiDEH == 0){
					$dataDEH = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $deityEventHundi, 'TM_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataDEH);
				} else {
					$conditionDEH = array('GTM_ID' => $deityEventHundiDEH[0]->GTM_ID);
					$dataDEH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionDEH,$dataDEH);
				}
				
				if(isset($_POST['deityEventHundi'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('deityEventHundiId') != "") {
				$conditionDEH = array('GTM_ID' => $this->input->post('deityEventHundiId'));
				$dataDEH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionDEH,$dataDEH);
				
				if(isset($_POST['deityEventHundi'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deityEventHundi = 24;
				$dataCheck = array('TP_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deityEventInkind'])) {
				$deityEventInkind = 25;
				$DEI = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $deityEventInkind);
				$deityEventInkindDEI = $this->obj_admin_settings->get_group_trust_menu_right_available($DEI);
				if($deityEventInkindDEI == 0){
					$dataDEI = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $deityEventInkind, 'TM_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataDEI);
				} else {
					$conditionDEI = array('GTM_ID' => $deityEventInkindDEI[0]->GTM_ID);
					$dataDEI = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionDEI,$dataDEI);
				}
				
				if(isset($_POST['deityEventInkind'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('deityEventInkindId') != "") {
				$conditionDEI = array('GTM_ID' => $this->input->post('deityEventInkindId'));
				$dataDEI = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionDEI,$dataDEI);
				
				if(isset($_POST['deityEventInkind'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deityEventInkind = 25;
				$dataCheck = array('TP_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['currentEventReceiptReport'])) {
				$currentEventReceiptReport = 26;
				$DCERR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $currentEventReceiptReport);
				$currentEventReceiptDCERR = $this->obj_admin_settings->get_group_trust_menu_right_available($DCERR);
				if($currentEventReceiptDCERR == 0){
					$dataDCERR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $currentEventReceiptReport, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataDCERR);
				} else {
					$conditionDCERR = array('GTM_ID' => $currentEventReceiptDCERR[0]->GTM_ID);
					$dataDCERR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionDCERR,$dataDCERR);
				}
				
				if(isset($_POST['currentEventReceiptReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('currentEventReceiptReportId') != "") {
				$conditionDCERR = array('GTM_ID' => $this->input->post('currentEventReceiptReportId'));
				$dataDCERR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionDCERR,$dataDCERR);
				
				if(isset($_POST['currentEventReceiptReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$currentEventReceiptReport = 26;
				$dataCheck = array('TP_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['currentEventSevaReport'])) {
				$currentEventSevaReport = 27;
				$DCESR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $currentEventSevaReport);
				$currentEventSevaDCESR = $this->obj_admin_settings->get_group_trust_menu_right_available($DCESR);
				if($currentEventSevaDCESR == 0){
					$dataDCESR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $currentEventSevaReport, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataDCESR);
				} else {
					$conditionDCESR = array('GTM_ID' => $currentEventSevaDCESR[0]->GTM_ID);
					$dataDCESR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionDCESR,$dataDCESR);
				}
				
				if(isset($_POST['currentEventSevaReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('currentEventSevaReportId') != "") {
				$conditionDCESR = array('GTM_ID' => $this->input->post('currentEventSevaReportId'));
				$dataDCESR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionDCESR,$dataDCESR);
				
				if(isset($_POST['currentEventSevaReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$currentEventSevaReport = 27;
				$dataCheck = array('TP_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['currentEventMISReport'])) {
				$currentEventMISReport = 28;
				$DCEMISR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $currentEventMISReport);
				$currentEventMISDCEMISR = $this->obj_admin_settings->get_group_trust_menu_right_available($DCEMISR);
				if($currentEventMISDCEMISR == 0){
					$dataDCEMISR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $currentEventMISReport, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataDCEMISR);
				} else {
					$conditionDCEMISR = array('GTM_ID' => $currentEventMISDCEMISR[0]->GTM_ID);
					$dataDCEMISR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionDCEMISR,$dataDCEMISR);
				}
				
				if(isset($_POST['currentEventMISReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('currentEventMISReportId') != "") {
				$conditionDCEMISR = array('GTM_ID' => $this->input->post('currentEventMISReportId'));
				$dataDCEMISR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionDCEMISR,$dataDCEMISR);
				
				if(isset($_POST['currentEventMISReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$currentEventMISReport = 28;
				$dataCheck = array('TP_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['userEventCollectionReport'])) {
				$userEventCollectionReport = 29;
				$UECR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $userEventCollectionReport);
				$userEventCollectionUECR = $this->obj_admin_settings->get_group_trust_menu_right_available($UECR);
				if($userEventCollectionUECR == 0){
					$dataUECR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $userEventCollectionReport, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataUECR);
				} else {
					$conditionUECR = array('GTM_ID' => $userEventCollectionUECR[0]->GTM_ID);
					$dataUECR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionUECR,$dataUECR);
				}
				
				if(isset($_POST['userEventCollectionReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('userEventCollectionReportId') != "") {
				$conditionUECR = array('GTM_ID' => $this->input->post('userEventCollectionReportId'));
				$dataUECR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionUECR,$dataUECR);
				
				if(isset($_POST['userEventCollectionReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$userEventCollectionReport = 29;
				$dataCheck = array('TP_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//TRUST EVENT EOD REPORT
			if(isset($_POST['eventEodReport'])) {
				$eventEodReport = 30;
				$EEODR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventEodReport);
				$eodReportEEODR = $this->obj_admin_settings->get_group_trust_menu_right_available($EEODR);
				if($eodReportEEODR == 0){
					$dataEEODR = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventEodReport, 'TM_ID' => 8, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataEEODR);
				} else {
					$conditionEEODR = array('GTM_ID' => $eodReportEEODR[0]->GTM_ID);
					$dataEEODR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODR,$dataEEODR);
				}
				
				if(isset($_POST['eventEodReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $eventEodReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $eventEodReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventEodReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $eventEodReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eventEodReportId') != "") {
				$conditionEEODR = array('GTM_ID' => $this->input->post('eventEodReportId'));
				$dataEEODR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODR,$dataEEODR);
				
				if(isset($_POST['eventEodReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventEodReport = 30;
				$dataCheck = array('TP_ID' => $eventEodReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $eventEodReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventEodReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $eventEodReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//TRUST EOD TALLY
			if(isset($_POST['eventEodTally'])) {
				$eventEodTally = 31;
				$EEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventEodTally);
				$eodTallyEEODT = $this->obj_admin_settings->get_group_trust_menu_right_available($EEODT);
				if($eodTallyEEODT == 0){
					$dataEEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $eventEodTally, 'TM_ID' => 8, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataEEODT);
				} else {
					$conditionEEODT = array('GTM_ID' => $eodTallyEEODT[0]->GTM_ID);
					$dataEEODT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				}
				
				if(isset($_POST['eventEodTally'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $eventEodTally, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $eventEodTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventEodTally, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $eventEodTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eventEodTallyId') != "") {
				$conditionEEODT = array('GTM_ID' => $this->input->post('eventEodTallyId'));
				$dataEEODT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				
				if(isset($_POST['eventEodTally'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventEodTally = 31;
				$dataCheck = array('TP_ID' => $eventEodTally, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $eventEodTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $eventEodTally, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $eventEodTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//TRUST EOD TALLY
			if(isset($_POST['TrustDayBook'])) {
				$TrustDayBook = 32;
				$EEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $TrustDayBook);
				$eodTallyEEODT = $this->obj_admin_settings->get_group_trust_menu_right_available($EEODT);
				if($eodTallyEEODT == 0){
					$dataEEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $TrustDayBook, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataEEODT);
				} else {
					$conditionEEODT = array('GTM_ID' => $eodTallyEEODT[0]->GTM_ID);
					$dataEEODT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				}
				
				if(isset($_POST['TrustDayBook'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $TrustDayBook, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $TrustDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $TrustDayBook, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $TrustDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('TrustDayBookId') != "") {
				$conditionEEODT = array('GTM_ID' => $this->input->post('TrustDayBookId'));
				$dataEEODT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				
				if(isset($_POST['TrustDayBook'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$TrustDayBook = 32;
				$dataCheck = array('TP_ID' => $TrustDayBook, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $TrustDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $TrustDayBook, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $TrustDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//TRUST EVENT TOKEN
			if(isset($_POST['trustEventToken'])) {
				$trustEventToken = 33;
				$EEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $trustEventToken);
				$eodTallyEEODT = $this->obj_admin_settings->get_group_trust_menu_right_available($EEODT);
				if($eodTallyEEODT == 0){
					$dataEEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $trustEventToken, 'TM_ID' => 9, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataEEODT);
				} else {
					$conditionEEODT = array('GTM_ID' => $eodTallyEEODT[0]->GTM_ID);
					$dataEEODT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				}
				
				if(isset($_POST['trustEventToken'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $trustEventToken, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $trustEventToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $trustEventToken, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trustEventToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('trustEventTokenId') != "") {
				$conditionEEODT = array('GTM_ID' => $this->input->post('trustEventTokenId'));
				$dataEEODT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				
				if(isset($_POST['trustEventToken'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$trustEventToken = 33;
				$dataCheck = array('TP_ID' => $trustEventToken, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $trustEventToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $trustEventToken, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $trustEventToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//TRUST FUNCTION TYPES
			if(isset($_POST['functionType'])) {
				$functionType = 34;
				$funType = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $functionType);
				$funTypeFT = $this->obj_admin_settings->get_group_trust_menu_right_available($funType);
				if($funTypeFT == 0){
					$dataFT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $functionType, 'TM_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataFT);
				} else {
					$conditionFT = array('GTM_ID' => $funTypeFT[0]->GTM_ID);
					$dataFT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionFT,$dataFT);
				}
				
				if(isset($_POST['functionType'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $functionType, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $functionType, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $functionType, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $functionType, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('functionTypeId') != "") {
				$conditionFT = array('GTM_ID' => $this->input->post('functionTypeId'));
				$dataFT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionFT,$dataFT);
				
				if(isset($_POST['functionType'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$functionType = 34;
				$dataCheck = array('TP_ID' => $functionType, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $functionType, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $functionType, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $functionType, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//EVENT POSTAGE
			if(isset($_POST['eventPostage'])) {
				$postage = 35;
				$post = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $postage);
				$postageP = $this->obj_admin_settings->get_group_trust_menu_right_available($post);
				if($postageP == 0){
					$dataDTT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $postage, 'TM_ID' => 10, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataDTT);
				} else {
					$conditionDTT = array('GTM_ID' => $postageP[0]->GTM_ID);
					$dataDTT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionDTT,$dataDTT);
				}
				
				if(isset($_POST['eventPostage'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eventPostageId') != "") {
				$conditionDTT = array('GTM_ID' => $this->input->post('eventPostageId'));
				$dataDTT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionDTT,$dataDTT);
				
				if(isset($_POST['eventPostage'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$postage = 35;
				$dataCheck = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//EVENT DISPATCH COLLECTION
			if(isset($_POST['eventDispatchCollection'])) {
				$dispatchCollection = 36;
				$DC = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $dispatchCollection);
				$dispatchDC = $this->obj_admin_settings->get_group_trust_menu_right_available($DC);
				if($dispatchDC == 0){
					$dataDC = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $dispatchCollection, 'TM_ID' => 10, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataDC);
				} else {
					$conditionDC = array('GTM_ID' => $dispatchDC[0]->GTM_ID);
					$dataDC = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionDC,$dataDC);
				}
				
				if(isset($_POST['eventDispatchCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('eventDispatchCollectionId') != "") {
				$conditionDC = array('GTM_ID' => $this->input->post('eventDispatchCollectionId'));
				$dataDC = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionDC,$dataDC);
				
				if(isset($_POST['eventDispatchCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dispatchCollection = 36;
				$dataCheck = array('TP_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			//ALL EVENT POSTAGE COLLECTION
			if(isset($_POST['allEventPostageCollection'])) {
				$allPostageCollection = 37;
				$APC = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $allPostageCollection);
				$allPostCollAPC = $this->obj_admin_settings->get_group_trust_menu_right_available($APC);
				if($allPostCollAPC == 0){
					$dataAPC = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $allPostageCollection, 'TM_ID' => 10, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataAPC);
				} else {
					$conditionAPC = array('GTM_ID' => $allPostCollAPC[0]->GTM_ID);
					$dataAPC = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionAPC,$dataAPC);
				}
				
				if(isset($_POST['allEventPostageCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('allEventPostageCollectionId') != "") {
				$conditionAPC = array('GTM_ID' => $this->input->post('allEventPostageCollectionId'));
				$dataAPC = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionAPC,$dataAPC);
				
				if(isset($_POST['allEventPostageCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allPostageCollection = 37;
				$dataCheck = array('TP_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			//TRUST EVENT POSTAGE GROUP
			if(isset($_POST['trustEvtPostageGroup'])) {
				$postage = 46;
				$post = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $postage);
				$postageP = $this->obj_admin_settings->get_group_trust_menu_right_available($post);
				if($postageP == 0){
					$dataDTT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $postage, 'TM_ID' => 10, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataDTT);
				} else {
					$conditionDTT = array('GTM_ID' => $postageP[0]->GTM_ID);
					$dataDTT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionDTT,$dataDTT);
				}
				
				if(isset($_POST['trustEvtPostageGroup'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('trustEvtPostageGroupId') != "") {
				$conditionDTT = array('GTM_ID' => $this->input->post('trustEvtPostageGroupId'));
				$dataDTT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionDTT,$dataDTT);
				
				if(isset($_POST['trustEvtPostageGroup'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$postage = 46;
				$dataCheck = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			//Trust Inkind Report
			if(isset($_POST['TrustInkindReport'])) {
				$TrustInkindReport = 47;
				
				$EEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $TrustInkindReport);
				$eodTallyEEODT = $this->obj_admin_settings->get_group_trust_menu_right_available($EEODT);
				//print_r($eodTallyEEODT);
				if($eodTallyEEODT == 0){
					$dataEEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $TrustInkindReport, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataEEODT);
				} else {
					$conditionEEODT = array('GTM_ID' => $eodTallyEEODT[0]->GTM_ID);
					$dataEEODT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				}
				
				if(isset($_POST['TrustInkindReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('TrustInkindReportId') != "") {
				$conditionEEODT = array('GTM_ID' => $this->input->post('TrustInkindReportId'));
				$dataEEODT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				
				if(isset($_POST['TrustInkindReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$TrustInkindReport = 47;
				$dataCheck = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			//TRUST IMPORT SETTINGS
			if(isset($_POST['trustImportSettings'])) {
				$trustImportSettings = 38;
				$impSett = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $trustImportSettings);
				$impSettIS = $this->obj_admin_settings->get_group_trust_menu_right_available($impSett);
				if($impSettIS == 0){
					$dataIS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $trustImportSettings, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataIS);
				} else {
					$conditionIS = array('GTM_ID' => $impSettIS[0]->GTM_ID);
					$dataIS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				}
				
				if(isset($_POST['trustImportSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('trustImportSettingsId') != "") {
				$conditionIS = array('GTM_ID' => $this->input->post('trustImportSettingsId'));
				$dataIS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				
				if(isset($_POST['trustImportSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$trustImportSettings = 38;
				$dataCheck = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			//ADD AUCTION ITEM
			if(isset($_POST['addAuctionItem'])) {
				$addAuctionItem = 39;
				$impSett = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $addAuctionItem);
				$impSettIS = $this->obj_admin_settings->get_group_trust_menu_right_available($impSett);
				if($impSettIS == 0){
					$dataIS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $addAuctionItem, 'TM_ID' => 11, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataIS);
				} else {
					$conditionIS = array('GTM_ID' => $impSettIS[0]->GTM_ID);
					$dataIS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				}
				
				if(isset($_POST['addAuctionItem'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('addAuctionItemId') != "") {
				$conditionIS = array('GTM_ID' => $this->input->post('addAuctionItemId'));
				$dataIS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				
				if(isset($_POST['addAuctionItem'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$addAuctionItem = 39;
				$dataCheck = array('TP_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			//BID AUCTION ITEM
			if(isset($_POST['bidAuctionItem'])) {
				$bidAuctionItem = 40;
				$impSett = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $bidAuctionItem);
				$impSettIS = $this->obj_admin_settings->get_group_trust_menu_right_available($impSett);
				if($impSettIS == 0){
					$dataIS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $bidAuctionItem, 'TM_ID' => 11, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataIS);
				} else {
					$conditionIS = array('GTM_ID' => $impSettIS[0]->GTM_ID);
					$dataIS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				}
				
				if(isset($_POST['bidAuctionItem'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('bidAuctionItemId') != "") {
				$conditionIS = array('GTM_ID' => $this->input->post('bidAuctionItemId'));
				$dataIS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				
				if(isset($_POST['bidAuctionItem'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$bidAuctionItem = 40;
				$dataCheck = array('TP_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			//AUCTION RECEIPT
			if(isset($_POST['auctionReceipt'])) {
				$auctionReceipt = 41;
				$impSett = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $auctionReceipt);
				$impSettIS = $this->obj_admin_settings->get_group_trust_menu_right_available($impSett);
				if($impSettIS == 0){
					$dataIS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $auctionReceipt, 'TM_ID' => 11, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataIS);
				} else {
					$conditionIS = array('GTM_ID' => $impSettIS[0]->GTM_ID);
					$dataIS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				}
				
				if(isset($_POST['auctionReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('auctionReceiptId') != "") {
				$conditionIS = array('GTM_ID' => $this->input->post('auctionReceiptId'));
				$dataIS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				
				if(isset($_POST['auctionReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$auctionReceipt = 41;
				$dataCheck = array('TP_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			//SAREE OUTWARDS REPORT
			if(isset($_POST['sareeOutwardReport'])) {
				$sareeOutwardReport = 42;
				$impSett = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $sareeOutwardReport);
				$impSettIS = $this->obj_admin_settings->get_group_trust_menu_right_available($impSett);
				if($impSettIS == 0){
					$dataIS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $sareeOutwardReport, 'TM_ID' => 11, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataIS);
				} else {
					$conditionIS = array('GTM_ID' => $impSettIS[0]->GTM_ID);
					$dataIS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				}
				
				if(isset($_POST['sareeOutwardReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('sareeOutwardReportId') != "") {
				$conditionIS = array('GTM_ID' => $this->input->post('sareeOutwardReportId'));
				$dataIS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				
				if(isset($_POST['sareeOutwardReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$sareeOutwardReport = 42;
				$dataCheck = array('TP_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			//AUCTION ITEM REPORT
			if(isset($_POST['auctionItemReport'])) {
				$auctionItemReport = 43;
				$impSett = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $auctionItemReport);
				$impSettIS = $this->obj_admin_settings->get_group_trust_menu_right_available($impSett);
				if($impSettIS == 0){
					$dataIS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $auctionItemReport, 'TM_ID' => 11, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataIS);
				} else {
					$conditionIS = array('GTM_ID' => $impSettIS[0]->GTM_ID);
					$dataIS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				}
				
				if(isset($_POST['auctionItemReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('auctionItemReportId') != "") {
				$conditionIS = array('GTM_ID' => $this->input->post('auctionItemReportId'));
				$dataIS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				
				if(isset($_POST['auctionItemReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$auctionItemReport = 43;
				$dataCheck = array('TP_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			//AUCTION SETTINGS
			if(isset($_POST['auctionSettings'])) {
				$auctionSettings = 44;
				$impSett = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $auctionSettings);
				$impSettIS = $this->obj_admin_settings->get_group_trust_menu_right_available($impSett);
				if($impSettIS == 0){
					$dataIS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $auctionSettings, 'TM_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataIS);
				} else {
					$conditionIS = array('GTM_ID' => $impSettIS[0]->GTM_ID);
					$dataIS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				}
				
				if(isset($_POST['auctionSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trustImportSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('auctionSettingsId') != "") {
				$conditionIS = array('GTM_ID' => $this->input->post('auctionSettingsId'));
				$dataIS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionIS,$dataIS);
				
				if(isset($_POST['auctionSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$auctionSettings = 44;
				$dataCheck = array('TP_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			
			// finance part for trust by adithya on 19-12-2023 start 
			// changed the id of all the page which will be reflecting in the table called "group_trust_menu" tp_id
			// Finance start
			// Finance Receipts
			if(isset($_POST['financeReceipts'])) {
				$financeReceipts = 48;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeReceipts);
				$financeReceiptsRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				print_r($financeReceiptsRS);
				if($financeReceiptsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeReceipts, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $financeReceiptsRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeReceipts'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('financeReceiptsId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('financeReceiptsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeReceipts'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeReceipts = 48;
				$dataCheck = array('TP_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			// Finance Payments
			if(isset($_POST['financePayments'])) {
				$financePayments = 49;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financePayments);
				$financePaymentsRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($financePaymentsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financePayments, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $financePaymentsRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financePayments'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('financePaymentsId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('financePaymentsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financePayments'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financePayments = 49;
				$dataCheck = array('TP_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			// Finance Journal
			if(isset($_POST['financeJournal'])) {
				$financeJournal = 50;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeJournal);
				$financeJournalRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($financeJournalRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeJournal, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $financeJournalRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeJournal'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('financeJournalId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('financeJournalId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeJournal'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeJournal = 50;
				$dataCheck = array('TP_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			// Finance Contra
			if(isset($_POST['financeContra'])) {
				$financeContra = 51;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeContra);
				$financeContraRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($financeContraRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeContra, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $financeContraRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeContra'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('financeContraId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('financeContraId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeContra'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeContra = 51;
				$dataCheck = array('TP_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			// Balance Sheet
			if(isset($_POST['balanceSheet'])) {
				$balanceSheet = 52;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $balanceSheet);
				$balanceSheetRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($balanceSheetRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $balanceSheet, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $balanceSheetRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['balanceSheet'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('balanceSheetId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('balanceSheetId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['balanceSheet'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$balanceSheet = 52;
				$dataCheck = array('TP_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			// Income and Expenditure
			if(isset($_POST['incomeAndExpenditure'])) {
				$incomeAndExpenditure = 53;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $incomeAndExpenditure);
				$incomeAndExpenditureRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($incomeAndExpenditureRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $incomeAndExpenditure, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $incomeAndExpenditureRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['incomeAndExpenditure'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('incomeAndExpenditureId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('incomeAndExpenditureId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['incomeAndExpenditure'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$incomeAndExpenditure = 53;
				$dataCheck = array('TP_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			// Receipts and Payments
			if(isset($_POST['receiptsAndPayments'])) {
				$receiptsAndPayments = 54;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $receiptsAndPayments);
				$receiptsAndPaymentsRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($receiptsAndPaymentsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $receiptsAndPayments, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $receiptsAndPaymentsRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['receiptsAndPayments'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('receiptsAndPaymentsId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('receiptsAndPaymentsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['receiptsAndPayments'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$receiptsAndPayments = 54;
				$dataCheck = array('TP_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			// Trial Balance
			if(isset($_POST['trialBalance'])) {
				$trialBalance = 55;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $trialBalance);
				$trialBalanceRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($trialBalanceRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $trialBalance, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $trialBalanceRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['trialBalance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('trialBalanceId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('trialBalanceId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['trialBalance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$trialBalance = 55;
				$dataCheck = array('TP_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			
			// Finance Add Groups
			if(isset($_POST['financeAddGroups'])) {
				$financeAddGroups = 56;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeAddGroups);
				$financeAddGroupsRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($financeAddGroupsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeAddGroups, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $financeAddGroupsRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeAddGroups'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('financeAddGroupsId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('financeAddGroupsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeAddGroups'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeAddGroups = 56;
				$dataCheck = array('TP_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			// Finance Add Ledgers
			if(isset($_POST['financeAddLedgers'])) {
				$financeAddLedgers = 57;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeAddLedgers);
				$financeAddLedgersRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($financeAddLedgersRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeAddLedgers, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $financeAddLedgersRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeAddLedgers'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('financeAddLedgersId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('financeAddLedgersId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeAddLedgers'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeAddLedgers = 57;
				$dataCheck = array('TP_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			// Finance Add Opening Balance
			if(isset($_POST['financeAddOpeningBalance'])) {
				$financeAddOpeningBalance = 58;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeAddOpeningBalance);
				$financeAddOpeningBalanceRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($financeAddOpeningBalanceRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeAddOpeningBalance, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $financeAddOpeningBalanceRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeAddOpeningBalance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('financeAddOpeningBalanceId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('financeAddOpeningBalanceId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeAddOpeningBalance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeAddOpeningBalance = 58;
				$dataCheck = array('TP_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			// Finance Day Book
			if(isset($_POST['financeDayBook'])) {
				$financeDayBook = 59;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeDayBook);
				$financeDayBookRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($financeDayBookRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $financeDayBook, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $financeDayBookRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeDayBook'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('financeDayBookId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('financeDayBookId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeDayBook'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeDayBook = 59;
				$dataCheck = array('TP_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}

			// All Ledgers and Groups
			if(isset($_POST['allLedgersandGroups'])) {
				$allLedgersandGroups = 60;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $allLedgersandGroups);
				$allLedgersandGroupsRS = $this->obj_admin_settings->get_group_trust_menu_right_available($RS);
				if($allLedgersandGroupsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $allLedgersandGroups, 'TM_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataRS);
				} else {
					$conditionRS = array('GTM_ID' => $allLedgersandGroupsRS[0]->GTM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['allLedgersandGroups'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('allLedgersandGroupsId') != "") {
				$conditionRS = array('GTM_ID' => $this->input->post('allLedgersandGroupsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionRS,$dataRS);
				
				if(isset($_POST['allLedgersandGroups'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allLedgersandGroups = 60;
				$dataCheck = array('TP_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			//Finance end 
			//Trust Inkind Report
			if(isset($_POST['TrustInkindReport'])) {
				$TrustInkindReport = 47;
				$EEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $TrustInkindReport);
				$eodTallyEEODT = $this->obj_admin_settings->get_group_trust_menu_right_available($EEODT);
				if($eodTallyEEODT == 0){
					$dataEEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $TrustInkindReport, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataEEODT);
				} else {
					$conditionEEODT = array('GTM_ID' => $eodTallyEEODT[0]->GTM_ID);
					$dataEEODT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				}
				
				if(isset($_POST['TrustInkindReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('TrustInkindReportId') != "") {
				$conditionEEODT = array('GTM_ID' => $this->input->post('TrustInkindReportId'));
				$dataEEODT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				
				if(isset($_POST['TrustInkindReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$TrustInkindReport = 47;
				$dataCheck = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $TrustInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			//Trust Event Inkind Report
			if(isset($_POST['TrustEventInkindReport'])) {
				$TrustEventInkindReport = 64;
				$EEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $TrustEventInkindReport);
				$eodTallyEEODT = $this->obj_admin_settings->get_group_trust_menu_right_available($EEODT);
				if($eodTallyEEODT == 0){
					$dataEEODT = array('GROUP_ID' => $_POST['groupid'], 'TP_ID' => $TrustEventInkindReport, 'TM_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights($dataEEODT);
				} else {
					$conditionEEODT = array('GTM_ID' => $eodTallyEEODT[0]->GTM_ID);
					$dataEEODT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				}
				
				if(isset($_POST['TrustEventInkindReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('TP_ID' => $TrustEventInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('TP_ID' => $TrustEventInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $TrustEventInkindReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('TP_ID' => $TrustEventInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			} else if($this->input->post('TrustEventInkindReportId') != "") {
				$conditionEEODT = array('GTM_ID' => $this->input->post('TrustEventInkindReportId'));
				$dataEEODT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_trust_rights($conditionEEODT,$dataEEODT);
				
				if(isset($_POST['TrustEventInkindReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$TrustEventInkindReport = 64;
				$dataCheck = array('TP_ID' => $TrustEventInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_trust_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GTMH_ID' => $history->GTMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('TP_ID' => $TrustEventInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
					}
				} else {
					$condition = array('TP_ID' => $TrustEventInkindReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_trust_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('TP_ID' => $TrustEventInkindReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_trust_rights_history($dataHistory);
				}
			}
			// finance part for trust by adithya end

			// echo $_POST['groupid'];

			 redirect('/admin_settings/Admin_Trust_setting/groups_setting/');

		}
		
		//HALL SETTING
		function hall_setting() {
			$data['hallSettings'] = $this->obj_admin_settings->get_all_field_hall_details();
			$data['financialSettings'] = $this->obj_admin_settings->get_all_field_financial_details();
			
			if(isset($_SESSION['Hall_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/trust/hall_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//ADD HALL PAGE DISPLAY
		function add_hall_page() {
			if(isset($_SESSION['Hall_Settings'])) {
				$this->load->view('header');           
				$this->load->view('admin_settings/trust/add_hall');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//SAVE ADD HALL PAGE
		function save_add_hall() {
			//Adding Hall To Table
			$data = array('HALL_NAME' => $this->input->post('hall_name'),
						'HALL_ACTIVE' => $this->input->post('hall_active'),
						'HALL_BY_NAME' => $this->session->userdata('userFullName'),
						'HALL_BY_ID' => $this->session->userdata('userId'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'));
			$this->obj_admin_settings->add_hall_modal($data);
			redirect('/admin_settings/Admin_Trust_setting/hall_setting/');
		}
		
		//EDIT HALL PAGE DISPLAY
		function edit_hall_page($id) {
			$condition =array('HALL_ID' => $id);
			$data['hall_details'] = $this->obj_admin_settings->get_all_field_hall_details($condition);
			
			$sql = "SELECT * FROM FINANCIAL_HEAD A2 WHERE A2.FH_ID IN (Select FINANCIAL_HEAD.FH_ID FROM FINANCIAL_HEAD inner join HALL_FINANCIAL_HEAD on FINANCIAL_HEAD.FH_ID = HALL_FINANCIAL_HEAD.FH_ID WHERE HFH_STATUS = 1 AND HALL_FINANCIAL_HEAD.H_ID = ".$id.")";
			$data['financialHeads'] = $this->obj_admin_settings->get_all_field_financial_heads($sql);
			
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Hall_Settings'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/edit_hall');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//UPDATE HALL DETAILS
		function update_hall_details() {
			$data_array = array('HALL_NAME' => $this->input->post('hall_name'),
						'HALL_ACTIVE' => $this->input->post('hall_active'));
			$condition = array('HALL_ID' => $this->input->post('hall_id'));
			$this->obj_admin_settings->edit_hall($condition,$data_array);

			$checkedId = $this->input->post('hfhId');
			$arrRes = explode(",", $checkedId);

			for($i = 0; $i < sizeof($arrRes); $i++) {
				//Adding Hall Financial Head To Table
				$data = array('HFH_STATUS' => 0);
				$condition = array('H_ID' => $this->input->post('hall_id'), 'FH_ID' => $arrRes[$i]);
				$this->obj_admin_settings->edit_hall_financial_head($condition,$data);
			}
			redirect('/admin_settings/Admin_Trust_setting/hall_setting/');
		}
		
		//UPDATE HALL STATUS
		function update_hall_status() {
			$data = array('HALL_ACTIVE' => $_POST['status']);
			$condition = array('HALL_ID' => $_POST['id']); 
			$this->obj_admin_settings->edit_hall($condition,$data);
			echo "Success";
		}
		
		//ADD FINANCIAL HEAD PAGE DISPLAY
		function add_financial_head_page() {
			// adding financil_ledger_heads by adithya
            $condition = "T_LEVELS='LG'";		
		    $data['ledger'] =  $this->obj_finance->getGroups($condition);

			if(isset($_SESSION['Hall_Settings'])) {

            // adding the committie dropdown code by adithya on 8-1-24 start
				$data['committee'] =  $this->obj_admin_settings->getCommittee();
				// adding the committie dropdown code by adithya on 8-1-24 end

				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/add_financial_head');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//SAVE FINANCIAL HEAD
		function save_financial_head() {
			if(@$_POST['ledgerId']){
				$data['ledgerId'] = $ledgerId = @$_POST['ledgerId'];
				$data['todayDate'] = $_SESSION['todayDate'] = $_POST['todayDateVal'];
			} 
			//Adding Financial To Table BY adithya
			$T_FGLH_ID = $this->input->post('ledgerId');
			$T_comp_id = $this->obj_finance->getTFGLH_ID($T_FGLH_ID);
			//echo "$T_comp_id";
			$data = array('FH_NAME' => $this->input->post('financial_name'),
						'FH_ACTIVE' => $this->input->post('financial_active'),
						'FH_BY_NAME' => $this->session->userdata('userFullName'),
						'FH_BY_ID' => $this->session->userdata('userId'),
						'T_FGLH_ID'=>$this->input->post('ledgerId'),
						'T_COMP_ID'=>$T_comp_id[0]->T_COMP_ID,
						'FH_ACTIVE_HEAD_COUNTER_ID' => 1,
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'));
			$this->obj_admin_settings->add_financial_modal($data);
			redirect('/admin_settings/Admin_Trust_setting/hall_setting/');
		}
		
		//EDIT FINANCIAL HEAD PAGE DISPLAY
		function edit_financial_head($id) {
			$condition =array('FH_ID' => $id);
			$data['financial_details'] = $this->obj_admin_settings->get_all_field_financial_details($condition);
			
			// Added the below code by adithya on 8-1-24 start
			$condition = "T_LEVELS='LG'";		
		    $data['ledger'] =  $this->obj_finance->getGroups($condition);
			$data['ledgerId'] = $data['financial_details'][0]->T_FGLH_ID;
			// BY adithya END

				if(isset($_SESSION['Hall_Settings'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/edit_financial_head');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//UPDATE FINANCIAL HEAD DETAILS
		function update_financial_head_details() {

           // added by adithya start
           $T_FGLH_ID = $this->input->post('ledgerId');
           $T_comp_id = $this->obj_finance->getTFGLH_ID($T_FGLH_ID);
           // added by adithya end

			$data_array = array(
				        'FH_NAME' => $this->input->post('financial_name'),
						'T_FGLH_ID'=>$this->input->post('ledgerId'),
						'T_COMP_ID'=>$T_comp_id[0]->T_COMP_ID,
						'FH_ACTIVE' => $this->input->post('financial_active'));
			$condition = array('FH_ID' => $this->input->post('financial_id'));
			$this->obj_admin_settings->edit_financial($condition,$data_array);	
			redirect('/admin_settings/Admin_Trust_setting/hall_setting/');
		}
		
		//UPDATE FINANCIAL HEAD STATUS
		function update_financial_head_status() {
			$data = array('FH_ACTIVE' => $_POST['status']);
			$condition = array('FH_ID' => $_POST['id']); 
			$this->obj_admin_settings->edit_financial($condition,$data);
			echo "Success";
		}
		
		//ADD FINANCIAL HEAD TO HALL
		function add_financial_head_to_hall_page($hallId) {
			$condition = array('HALL_ID' => $hallId);
			$data['hall_details'] = $this->obj_admin_settings->get_all_field_hall_details($condition);
			
			$conditionOne = array('FH_ACTIVE' => 1);
			$data['financialSettings'] = $this->obj_admin_settings->get_all_field_financial_details($conditionOne);
			
			$sql = "SELECT * FROM FINANCIAL_HEAD A2 WHERE A2.FH_ACTIVE = 1 AND A2.FH_ID NOT IN (Select FINANCIAL_HEAD.FH_ID FROM FINANCIAL_HEAD inner join HALL_FINANCIAL_HEAD on FINANCIAL_HEAD.FH_ID = HALL_FINANCIAL_HEAD.FH_ID WHERE HFH_STATUS = 1 AND HALL_FINANCIAL_HEAD.H_ID = ".$hallId.")";
			$data['financialHeads'] = $this->obj_admin_settings->get_all_field_financial_heads($sql);
			
			if(isset($_SESSION['Hall_Settings'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/add_heads_to_hall');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//SAVE FINANCIAL HEAD BASED ON HALL
		function save_financial_head_on_hall() {
			$checkedId = $this->input->post('hfhId');
			$arrRes = explode(",", $checkedId);

			for($i = 0; $i < sizeof($arrRes); $i++) {
				//Adding Hall Financial Head To Table
				$data = array('H_ID' => $this->input->post('hallId'),
							'FH_ID' => $arrRes[$i],
							'HFH_BY_NAME' => $this->session->userdata('userFullName'),
							'HFH_BY' => $this->session->userdata('userId'),
							'HFH_STATUS' => 1,
							'DATE_TIME' => date('d-m-Y H:i:s A'),
							'DATE' => date('d-m-Y'));
				$this->obj_admin_settings->add_hall_financial_head_modal($data);
			}
			redirect('/admin_settings/Admin_Trust_setting/hall_setting/');
		}
		
		//BLOCK DATE SETTING
		function block_date_setting($start = 0) {
			$condition = array('HBL_ID ' => Null);
			$data['block_date_settings'] = $this->obj_admin_settings->get_all_field_block_date_details($condition,'TBDT_ID','desc',10, $start);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_Trust_setting/block_date_setting';
			$config['total_rows'] = $this->obj_admin_settings->count_rows_block_date_details($condition);
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
			
			if(isset($_SESSION['Block_Date_Settings'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/block_date_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//ADD BLOCK DATE DISPLAY
		function add_block_date() {
			$condition =array('HALL_ACTIVE' => 1);
			$data['hall_details'] = $this->obj_admin_settings->get_all_field_hall_details($condition);
			
			if(isset($_SESSION['Block_Date_Settings'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/add_block_date');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//SAVE BLOCK DATE
		function save_block_date() {
			//Adding Financial To Table
			$data = array('TBDT_DATE' => $this->input->post('todayDateFrom'),
						'H_ID' => $this->input->post('hall_name'),
						'TBDT_ACTIVE' => 1,
						'TBDT_BY_NAME' => $this->session->userdata('userFullName'),
						'TBDT_BY_ID' => $this->session->userdata('userId'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'));
			$this->obj_admin_settings->add_block_date_modal($data);
			redirect('/admin_settings/Admin_Trust_setting/block_date_setting/');
		}
		
		//EDIT BLOCK DATE DISPLAY
		function edit_block_date($id) {
			$condition =array('HALL_ACTIVE' => 1);
			$data['hall_details'] = $this->obj_admin_settings->get_all_field_hall_details($condition);
			
			$conditionBlock = array('TBDT_ID' => $id);
			$data['block_date'] = $this->obj_admin_settings->get_all_field_block_date_modal($conditionBlock);
			
			if(isset($_SESSION['Block_Date_Settings'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/edit_block_date');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//UPDATE BLOCK DATE
		function update_block_date() {
			$data = array('TBDT_DATE' => $this->input->post('todayDateFrom'),
						'H_ID' => $this->input->post('hall_name'),
						'TBDT_ACTIVE' => $this->input->post('block_active'),
						'TBDT_BY_NAME' => $this->session->userdata('userFullName'),
						'TBDT_BY_ID' => $this->session->userdata('userId'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'));
			$condition = array('TBDT_ID' => $this->input->post('tbdtId'));
			$this->obj_admin_settings->update_block_date_modal($condition,$data);
			redirect('/admin_settings/Admin_Trust_setting/block_date_setting/');
		}
		
		//UPDATE BLOCK DATE STATUS
		function update_block_date_status() {
			$data = array('TBDT_ACTIVE' => $_POST['status']);
			$condition = array('TBDT_ID' => $_POST['id']); 
			$this->obj_admin_settings->update_block_date_modal($condition,$data);
			echo "Success";
		}
		
		//BANK SETTINGS
		function bank_setting() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$data['bank'] = $this->obj_admin_settings->get_all_field_trust_bank_modal();
			$data['event_bank'] = $this->obj_admin_settings->get_all_field_event_trust_bank_modal();
			
			if(isset($_SESSION['Bank_Settings'])) {			
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/bank_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//ADD PAGE DISPLAY
		function add_bank($status) {
			$data['status'] = $status;
			if(isset($_SESSION['Bank_Settings'])) {			
				$this->load->view('header',$data);          
				$this->load->view('admin_settings/trust/add_bank');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//SAVE BANK DETAILS
		function save_bank_details() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			if($_POST['page'] == 1) {
				$data = array('BANK_NAME' => $_POST['bank_name'],'BANK_BRANCH' => $_POST['branch_name'],'ACCOUNT_NO' => $_POST['account_no'],'BANK_IFSC_CODE' => $_POST['ifsc_code']);
				$this->obj_admin_settings->add_trust_bank_modal($data);
			} else {
				$data = array('BANK_NAME' => $_POST['bank_name'],'BANK_BRANCH' => $_POST['branch_name'],'ACCOUNT_NO' => $_POST['account_no'],'BANK_IFSC_CODE' => $_POST['ifsc_code']);
				$this->obj_admin_settings->add_trust_event_bank_modal($data);
			}
			$this->session->set_userdata('msg', 'Successfully updated');
			
			$this->load->view('header');           
			$this->load->view('admin_settings/trust/add_bank');
			$this->load->view('footer_home');
		}
		
		//EDIT PAGE DISPLAY
		function edit_bank($id,$status) {
			$data['status'] = $status;
			if($status == 1) {
				$condition = array('BANK_ID' => $id); 
				$data['bank_details'] = $this->obj_admin_settings->get_all_field_trust_bank_modal($condition);
			} else {
				$condition = array('BANK_ID' => $id); 
				$data['bank_details'] = $this->obj_admin_settings->get_all_field_event_trust_bank_modal($condition);
			}
			if(isset($_SESSION['Bank_Settings'])) {			
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/edit_bank');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//UPDATE BANK DETAILS
		function update_bank_details() {
			if($_POST['page'] == 1) {
				$data_array = array('BANK_NAME' => $this->input->post('bank_name'),
									'BANK_BRANCH' => $this->input->post('branch_name'),
									'ACCOUNT_NO' => $this->input->post('account_no'),
									'BANK_IFSC_CODE' => $this->input->post('ifsc_code'));
				$condition = array('BANK_ID' => $this->input->post('bank_id'));
				$this->obj_admin_settings->update_trust_bank_modal($condition,$data_array);	
			} else {
				$data_array = array('BANK_NAME' => $this->input->post('bank_name'),
									'BANK_BRANCH' => $this->input->post('branch_name'),
									'ACCOUNT_NO' => $this->input->post('account_no'),
									'BANK_IFSC_CODE' => $this->input->post('ifsc_code'));
				$condition = array('BANK_ID' => $this->input->post('bank_id'));
				$this->obj_admin_settings->update_trust_event_bank_modal($condition,$data_array);	
			}
			redirect('/admin_settings/Admin_Trust_setting/bank_setting/');
		}
		
		//CHECK REMMITTANCE for TRUST
		function check_remmittance($start = 0) {

        // added code by adithya start
        $dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1];
        // added code by adithya end
		$data['bank'] = $this->obj_finance->get_banks();
			unset($_SESSION['chequenumber']);
			$cheque_number = '';
			//pagination
			
			$condition = array('RECEIPT_PAYMENT_METHOD' => "Cheque",'TR_ACTIVE'=>1);
			$data['trustCheckRemmittance'] = $this->obj_admin_settings->get_all_trustChequeRemmittance($fromDate,$toDate,10,$start, $condition,$cheque_number, "PAYMENT_STATUS");
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_Trust_setting/check_remmittance';
			$config['total_rows'] = $this->obj_admin_settings->get_all_trustChequeRemmittanceCount($condition,$cheque_number, "PAYMENT_STATUS");
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
			
			if(isset($_SESSION['Check_Remmittance'])) {			
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/trustCheckRemmittance');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		//CHECK REMMITTANCE
		function Searchcheck_remmittance($start = 0) {
			if(isset($_POST['chequenumber'])){
				$_SESSION['chequenumber'] = $this->input->post('chequenumber');
				//the cheque_number is a result from the post call
				$cheque_number = $this->input->post('chequenumber');
				$data['cheque_Number'] = $cheque_number;
			} else if(isset($_SESSION['chequenumber'])) {
				$cheque_number = $_SESSION['chequenumber'];
				$data['cheque_Number'] = $cheque_number;
			} else {
				$cheque_number = '';
			}
			//pagination
			$condition = array('RECEIPT_PAYMENT_METHOD' => "Cheque",'TR_ACTIVE'=>1); 
			$data['trustCheckRemmittance'] = $this->obj_admin_settings->get_all_trustChequeRemmittance(10,$start, $condition,$cheque_number, "PAYMENT_STATUS");
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_Trust_setting/Searchcheck_remmittance';
			$config['total_rows'] = $this->obj_admin_settings->get_all_trustChequeRemmittanceCount($condition,$cheque_number, "PAYMENT_STATUS");
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
			
			if(isset($_SESSION['Check_Remmittance'])) {			
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/trust/trustCheckRemmittance');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		function edit_trustChequeRemmittance() {
		
		   $TR_ID = @$_POST['tr_id'];
			// $cheque = $_POST['cheque'];
			$total = $_POST['total'];
			$bank = $_POST['bank'];
			$bankName = $_POST['bankName'];
			$TUC_ID = $_POST['tucId'];
			$dDate = $_POST['chequedate2'];
			$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
			$fromDate = explode(":",$dtFuncStr)[0];
			$toDate = explode(":",$dtFuncStr)[1];

			
//////////////////////////// xxx adding event like code by adithya start

		  $data = array(
			'TUC_BY_ID'=>@$_SESSION['userId'],
			'TUC_BY_NAME'=>@$_SESSION['userFullName'],
			'TUC_DATE_TIME'=>date('d-m-Y h:i:s A'),
			'TUC_DATE'=>date('Y-m-d'),
			'TUC_IS_DEPOSITED'=>1,
			'TUC_LEDGER_ID'=>$bank,
			'TUC_DEPOSIT_DATE'=>date('Y-m-d',strtotime($dDate)),
		);
		
		$where = array(
			'TUC_ID'=>$TUC_ID
		);
		
		$this->db->where($where);
		$this->db->update('TRUST_USER_COLLECTION', $data);

		$USER_COLLECTION_HISTORY = array(
			'TUC_ID'=>$TUC_ID,
			'TUCH_BY_ID'=>@$_SESSION['userId'],
			'TUCH_BY_NAME'=>@$_SESSION['userFullName'],
			'TUCH_DATE_TIME'=>date('d-m-Y h:i:s A'),
			'TUCH_DATE'=>date('Y-m-d'),
		);
		$this->db->insert('TRUST_USER_COLLECTION_HISTORY',$USER_COLLECTION_HISTORY);
// *************************************LEDGER TRAN PART START*****************************************/
// **************************************************************************************************************************************************************
               $sqlFinTrans = "SELECT T_RECEIPT_ID,T_VOUCHER_NO FROM `trust_financial_ledger_transcations` WHERE T_RECEIPT_ID = '".$TR_ID."'";    
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

	$sql = "SELECT TR_ID,
				   RECEIPT_NAME,
				   RECEIPT_DATE,
				   FH_AMOUNT,
				   FH_ID,
				   (FH_AMOUNT + POSTAGE_PRICE) AS PRICE,
				   RECEIPT_PAYMENT_METHOD,
				   T_FGLH_ID,
				   PAYMENT_STATUS 
			FROM `trust_receipt`
			WHERE TR_ID = $TR_ID";    
	$query = $this->db->query($sql);
	$receiptDetails = $query->first_row();

	$CHEQUE_NO = $_POST['chequeNo'];
	$BANK_NAME = str_replace("'","\'",$_POST['bank']);
	$BRANCH_NAME = str_replace("'","\'",$_POST['branch']);
	$CHEQUE_DATE = $_POST['chequedate'];


	$dateTime = date('d-m-Y H:i:s A');
	$aidR = $bank;
	$RECEIPT_ID = $receiptDetails->TR_ID;
	$catId = $receiptDetails->FH_ID;
	$amtsR = $receiptDetails->PRICE;
	$tDateR = $receiptDetails->RECEIPT_DATE;
	$flt_user = $_SESSION['userId'];
	$RECEIPT_PAYMENT_METHOD = $receiptDetails->RECEIPT_PAYMENT_METHOD;
	$PAYMENT_STATUS = 'Completed';                     //$receiptDetails->PAYMENT_STATUS;
	$RECEIPT_NAME = $receiptDetails->RECEIPT_NAME;
	// $RECEIPT_TET_ID = $receiptDetails->RECEIPT_TET_ID;
	$this->db->select('T_COMP_ID,T_FGLH_ID')->from('financial_head')->where(array('FH_ID'=> "$catId"));
	$query = $this->db->get();
	$T_DATAS = $query->first_row();
		
	$comp_id = $T_DATAS->T_COMP_ID;
		

	if($catId != 4) {
		// if($catId == 1) {
			$lidR = $T_DATAS->T_FGLH_ID;
		// } else if($catId == 2) {
		// 	$lidR =$T_DATAS->T_FGLH_ID ;
		// }else if($catId == 3) {
		// 	$lidR = $T_DATAS->T_FGLH_ID;
		// }else if($catId == 9){
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

	$this->db->query("INSERT INTO `trust_financial_ledger_transcations`
	(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_RECEIPT_ID`,`T_PAYMENT_METHOD`,	`T_RECEIPT_FAVOURING_NAME`,`T_CHEQUE_NO`,`T_BANK_NAME`,`T_BRANCH_NAME`,`T_CHEQUE_DATE`,`T_FLT_DEPOSIT_PAYMENT_DATE`,`T_PAYMENT_STATUS`,`T_COMP_ID`) 
	VALUES ($lidR,'$countNoR',0,$amtsR,'$tDateR','$dateTime',' ','R1',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$RECEIPT_NAME','$CHEQUE_NO','$BANK_NAME','$BRANCH_NAME','$CHEQUE_DATE','$dDate','$PAYMENT_STATUS',$comp_id)");
	$this->db->query("INSERT INTO `trust_financial_ledger_transcations`(`T_FGLH_ID`,`T_VOUCHER_NO`,`T_FLT_DR`, `T_FLT_CR`, `T_FLT_DATE`,`T_FLT_DATE_TIME`,`T_FLT_NARRATION`,`T_RP_TYPE`,`T_FLT_USER_ID`,`T_RECEIPT_ID`,`T_PAYMENT_METHOD`,	`T_RECEIPT_FAVOURING_NAME`,`T_CHEQUE_NO`,`T_BANK_NAME`,`T_BRANCH_NAME`,`T_CHEQUE_DATE`,`T_FLT_DEPOSIT_PAYMENT_DATE`,`T_PAYMENT_STATUS`,`T_COMP_ID`) 
	VALUES ($aidR,'$countNoR',$amtsR,0,'$tDateR','$dateTime',' ','R2',$flt_user,$RECEIPT_ID,'$RECEIPT_PAYMENT_METHOD','$RECEIPT_NAME','$CHEQUE_NO','$BANK_NAME','$BRANCH_NAME','$CHEQUE_DATE','$dDate','$PAYMENT_STATUS',$comp_id)");

	$this->db->where('trust_finance_voucher_counter.T_FVC_ID',1);
	$this->db->update('trust_finance_voucher_counter', array('T_FVC_COUNTER'=>$counter));


			
}
// *************************************LEDGER PART END**********************************************/

// /////////////////////////// adding event like code by adithya end 
     $chequedate = $_POST['chequedate'];
	 $trNo = $_POST['receiptNo'];
if($_POST) {
	$this->db->where('TR_NO',$trNo);
	$this->db->update('TRUST_RECEIPT',
	 array('PAYMENT_CONFIRMED_BY_NAME'=>$_SESSION['userFullName'],
	 'PAYMENT_CONFIRMED_BY_NAME'=>$_SESSION['userFullName'],
	 'CHEQUE_CREDITED_DATE'=>$chequedate,
	 'PAYMENT_STATUS'=>'Completed',
	 'PAYMENT_CONFIRMED_BY'=>$_SESSION['userId'],
	 'PAYMENT_DATE_TIME'=>date('d-m-Y H:i:s A'),
	 'PAYMENT_DATE'=>date('d-m-Y')));
	$this->check_remmittance();

}	


		}


//////////////////////////////ADDING THE RECEIPT CHEQUE RECONCILATION BY ADITHYA START
function trustChequeRemmittance($start = 0) {
	unset($_SESSION['chequenumber']);
	$cheque_number = '';//please donot remove this line. It is very important(since I have used same model for search)
	// $condition = array('PAYMENT_STATUS' => "Pending",'finacial_group_ledger_heads.FGLH_PARENT_ID'=>9);
	$data['trustCheckRemmittance'] = $this->obj_admin_settings->get_all_TrustChequeReconcilation(10,$start,$cheque_number);
	
	//pagination starts
	$this->load->library('pagination');
	$config['base_url'] = base_url().'admin_settings/Admin_Trust_setting/trustChequeRemmittance';
	$data['total_count'] = $config['total_rows'] = $this->obj_admin_settings->get_all_TrustChequeReconcilationCount($cheque_number);
	
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
	// 
	if(isset($_SESSION['Check_Remmittance'])) {			
		$this->load->view('header',$data);           
		$this->load->view('admin_settings/trust/trustCheckRemmittance');
		$this->load->view('footer_home');
	} else {
		redirect('Home/homePage');
	}
}

function SearchtrustChequeRemmittance($start = 0) {
	//pagination
	if(isset($_POST['chequenumber']) || isset($_POST['voucherType'])){
		$_SESSION['chequenumber'] = $this->input->post('chequenumber');
		$_SESSION['voucherType'] = $this->input->post('voucherType');
		//the cheque_number is a result from the post call
		$cheque_number = $this->input->post('chequenumber');
		$voucherType = $this->input->post('voucherType');

		$data['cheque_Number'] = $cheque_number;
		$data['voucherType'] = $voucherType;

	} else if(isset($_SESSION['chequenumber'])||isset($_SESSION['voucherType'])) {
		$cheque_number = $_SESSION['chequenumber'];
		$voucherType = $_SESSION['voucherType'];

		$data['cheque_Number'] = $cheque_number;
		$data['voucherType'] = $voucherType;
	} else {
		$cheque_number = '';
		$voucherType = '';

	}
	// $condition = array('PAYMENT_STATUS' => "Pending",'finacial_group_ledger_heads.FGLH_PARENT_ID'=>9);
	$data['trustCheckRemmittance'] = $this->obj_admin_settings->get_all_TrustChequeReconcilation(10,$start, $cheque_number,$voucherType);
	$this->load->library('pagination');
	$config['base_url'] = base_url().'admin_settings/Admin_Trust_setting/SearchtrustChequeRemmittance';
	$data['total_count'] = $config['total_rows'] = $this->obj_admin_settings->get_all_TrustChequeReconcilationCount($cheque_number,$voucherType);
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
	
	if(isset($_SESSION['Check_Remmittance'])) {			
		$this->load->view('header',$data);           
		$this->load->view('admin_settings/trust/trustCheckRemmittance');
		$this->load->view('footer_home');
	} else {
		redirect('Home/homePage');
	}
}

function edit_trustChequeReconcilation() {
	
	if($_POST) {
		$chequedate = $_POST['chequedate'];
		$receiptId = $_POST['receiptId'];
		$voucherNo = $_POST['voucherNo'];
		$voucherType = $_POST['voucherType'];

		if($voucherType=="Receipt"){
			$this->db->where('TR_ID',$receiptId);
			$this->db->update('TRUST_RECEIPT', 
			array('PAYMENT_CONFIRMED_BY_NAME'=>$_SESSION['userFullName'],
			      'CHEQUE_CREDITED_DATE'=>$chequedate,
				  'PAYMENT_STATUS'=>'Completed',
				  'PAYMENT_CONFIRMED_BY'=>$_SESSION['userId'],
				  'PAYMENT_DATE_TIME'=>date('d-m-Y H:i:s A'),
				  'PAYMENT_DATE'=>date('d-m-Y')));

		} else if($voucherType=="Payment" || $voucherType=="Contra"){
			$this->db->where('T_VOUCHER_NO',$voucherNo);
			$this->db->update('trust_finance_cheque_detail', 
			array('T_FCD_STATUS'=>'Reconciled',
			      'T_RECONCILED_DATE'=>$chequedate));
		}

		$this->db->where('T_VOUCHER_NO',$voucherNo);
		$this->db->update('trust_financial_ledger_transcations', 
		array('T_CHEQUE_RECONCILED_DATE'=>$chequedate,
		    'T_RECONCILED_DATE_TIME'=>date('d-m-Y H:i:s A') , 
			'T_RECONCILED_BY'=>$_SESSION['userFullName'],
			'T_PAYMENT_STATUS'=>'Completed'));
		$this->trustChequeRemmittance();
	}
}
///////////////////////////// ADDING THE RECEIPT CHEQUE RECONCILATION BY ADITHYA END 


	}
?>