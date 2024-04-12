﻿<?php 
	ini_set('memory_limit', '-1');
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Admin_setting extends CI_Controller {
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
			$this->load->model('Shashwath_Model','obj_shashwath',true);
			$this->load->model('finance_model','obj_finance_model',true);

			//CHECK LOGIN
			if(!isset($_SESSION['userId']))
				redirect('login');
			
			//echo $_SERVER['REQUEST_URI'];
			if($_SESSION['trustLogin'] == 1 && $_SERVER['REQUEST_URI'] != "/SLVT/admin_settings/Admin_setting/reset_password")
			redirect('Trust');

			$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
			$query = $this->db->get();
			$_SESSION['eventActiveCount'] = $query->num_rows();
		}
		
		function index() {

		}
		
		/* function jeernodhara_receipt_setting(){
				$data['jeernodhara_receipt_setting'] = $this->obj_admin_settings->get_jeernodhara_receipt_setting();
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/jeernodhara_receipt_setting');
				$this->load->view('footer_home');
		} */
		
		function deity_special_receipt_price() {
			$data['donationPrice'] = $this->obj_admin_settings->get_deity_donation_special_receipt_price();
			$data['kanikePrice'] = $this->obj_admin_settings->get_deity_kanike_special_receipt_price();
			
			if(isset($_SESSION['Deity_Special_Receipt_Price'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/special_receipt_price');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		function save_donation_special_price() {
			$data = array('PRICE' => $this->input->post('donation_price'));
			$this->obj_admin_settings->edit_price('DEITY_DONATION_SPECIAL_RECEIPT_PRICE',$data);
			$msg = 'Price Updated Successfully.';
			$this->session->set_userdata('msg', $msg);
			redirect('/admin_settings/Admin_setting/deity_special_receipt_price/');
		}
		
		function save_kanike_special_price() {
			$data = array('PRICE' => $this->input->post('kanike_price'));
			$this->obj_admin_settings->edit_price('DEITY_KANIKE_SPECIAL_RECEIPT_PRICE',$data);
			$msg = 'Price Updated Successfully.';
			$this->session->set_userdata('msg', $msg);
			redirect('/admin_settings/Admin_setting/deity_special_receipt_price/');
		}
		
		//UPDATE BID RANGE
		function update_bid_range() {
			$data = array('ITEM_FROM_PRICE' => $this->input->post('bid_value_from'), 'ITEM_TO_PRICE' => $this->input->post('bid_value_to'), 'MIN_BID_VALUE' => $this->input->post('bid_value'));
			$condition = array('IBR_ID' => $this->input->post('IBR_ID'));
			$this->obj_admin_settings->edit_bid_range($condition,$data);
			redirect('/admin_settings/Admin_setting/auction_setting/');
		}
		
		//UPDATE AUCTION ITEM STATUS
		function update_auction_item_status() {
			$data = array('AI_STATUS' => $_POST['status']);
			$condition = array('AI_ID' => $_POST['id']);
			$this->obj_admin_settings->edit_auction_item($condition,$data);
			echo "Success";
		}
		
		//UPDATE DEFAULT ID
		function update_default_bid() {
			$data = array('DEFAULT_BID_VALUE' => $this->input->post('bid_value'));
			$condition = array('IDB_ID' => $this->input->post('auct_Item_Id'));
			$this->obj_admin_settings->edit_default_bid($condition,$data);
			redirect('/admin_settings/Admin_setting/auction_setting/');
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
			$this->obj_admin_settings->add_bid_range_modal($data);
			redirect('/admin_settings/Admin_setting/auction_setting/');
		}
		
		//SAVE DEFAULT BID
		function save_default_bid() {
			if($this->input->post('item') == "2") {
				$condition = array('IDB_AI_ID' => $this->input->post('item'), 'IDB_AIC_ID' => $this->input->post('item_category'));
			} else {
				$condition = array('IDB_AI_ID' => $this->input->post('item'));
			}
			$count = $this->obj_admin_settings->count_rows_default_bid($condition);
			
			if($count == 0) {
				//Adding To Auction Item Default Bid Table
				$data = array('IDB_AI_ID' => $this->input->post('item'),
							  'IDB_AIC_ID' => $this->input->post('item_category'),
							  'DEFAULT_BID_VALUE' => $this->input->post('bid_value'),
							  'USER_ID' => $this->session->userdata('userId'),
							  'DATE_TIME' => date('d-m-Y H:i:s A'),
							  'DATE ' => date('d-m-y'));
				$this->obj_admin_settings->add_auction_item_default_bid_modal($data);
				redirect('/admin_settings/Admin_setting/auction_setting/');
			} else {
				$msg = 'Default Bid value is already added for this item.';
				$this->session->set_userdata('msg', $msg);
				redirect('/admin_settings/Admin_setting/add_default_bid/');
			}
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
			$this->obj_admin_settings->add_auction_item_modal($data);
			redirect('/admin_settings/Admin_setting/auction_setting/');
		}
		
		//EDIT BID RANGE
		function edit_bid_range($id) {
			$condition = array('AI_STATUS' => 1);
			$data['auction_item'] = $this->obj_admin_settings->get_all_field_auction_item($condition, 'AI_ID', 'desc');
			$conditionOne = array('AIC_STATUS' => 1);
			$data['auction_category'] = $this->obj_admin_settings->get_all_field_auction_item_category($conditionOne, 'AIC_STATUS', 'desc');
			$condition = array('IBR_ID' => $id);
			$data['bid_range'] = $this->obj_admin_settings->get_all_field_bid_range($condition);
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/edit_bid_range');
			$this->load->view('footer_home');
		}
		
		//EDIT DEFAULT BID VALUE
		function edit_default_bid($id) {
			$condition = array('AI_STATUS' => 1);
			$data['auction_item'] = $this->obj_admin_settings->get_all_field_auction_item($condition, 'AI_ID', 'desc');
			$conditionOne = array('AIC_STATUS' => 1);
			$data['auction_category'] = $this->obj_admin_settings->get_all_field_auction_item_category($conditionOne, 'AIC_STATUS', 'desc');
			$conditionTwo = array('IDB_ID' => $id);
			$data['default_bid'] = $this->obj_admin_settings->get_all_field_default_bid($conditionTwo); 
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/edit_default_bid');
			$this->load->view('footer_home');
		}
		
		//ADD BID RANGE
		function add_bid_range() {
			$condition = array('AI_STATUS' => 1);
			$data['auction_item'] = $this->obj_admin_settings->get_all_field_auction_item($condition, 'AI_ID', 'desc');
			$conditionOne = array('AIC_STATUS' => 1, 'AIC_ID !=' => 3);
			$data['auction_category'] = $this->obj_admin_settings->get_all_field_auction_item_category($conditionOne, 'AIC_STATUS', 'desc');
			
			$this->load->view('header',$data);        
			$this->load->view('admin_settings/add_bid_range');
			$this->load->view('footer_home');
		}
		
		//ADD DEFAULT BID
		function add_default_bid() {
			$condition = array('AI_STATUS' => 1);
			$data['auction_item'] = $this->obj_admin_settings->get_all_field_auction_item($condition, 'AI_ID', 'desc');
			$conditionOne = array('AIC_STATUS' => 1, 'AIC_ID !=' => 3);
			$data['auction_category'] = $this->obj_admin_settings->get_all_field_auction_item_category($conditionOne, 'AIC_STATUS', 'desc');
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/add_default_bid');
			$this->load->view('footer_home');
		}
		
		//ADD AUCTION ITEMS
		function add_auction_item() {
			if(isset($_SESSION['Add_Auction_Item'])) {
				$this->load->view('header');           
				$this->load->view('admin_settings/add_auction_item');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//AUCTION SETTING
		function auction_setting() {
			$data['auction_item'] = $this->obj_admin_settings->get_all_field_auction_item(null, 'AI_ID', 'desc');
			$data['default_bid'] = $this->obj_admin_settings->get_all_field_default_bid(null, 'IDB_ID', 'desc');
			$data['bid_range'] = $this->obj_admin_settings->get_all_field_bid_range(null,'IBR_ID','desc');
			
			if(isset($_SESSION['Auction_Settings'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/auction_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//POPUP DEITY
		function ViewDeity(){
			$condition = array('RECEIPT_ID' => $this->input->post('id'));
			$deity = $this->obj_admin_settings->get_deity_history($condition);
			echo "<table class='table table-bordered table-hover'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th style='width:30%;'><strong>USER NAME</strong></th>";
			echo "<th style='width:30%;'><strong>DATE TIME</strong></th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach($deity as $result) {
				echo "<tr class='row1'>";
				echo "<td>".$result->USER_FULL_NAME."</td>";
				echo "<td>".$result->DATE_TIME."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}
		
		//POPUP EVENT
		function ViewEvent(){
			$condition = array('RECEIPT_ID' => $this->input->post('id'));
			$event = $this->obj_admin_settings->get_event_history($condition);
			echo "<table class='table table-bordered table-hover'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th style='width:30%;'><strong>USER NAME</strong></th>";
			echo "<th style='width:30%;'><strong>DATE TIME</strong></th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach($event as $result) {
				echo "<tr class='row1'>";
				echo "<td>".$result->USER_FULL_NAME."</td>";
				echo "<td>".$result->DATE_TIME."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}
		
		//GET PRINT COUNT
		function print_event_details($start = 0) {
			$data['print_event'] = $this->obj_admin_settings->get_print_event_details(10,$start);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_setting/print_event_details';
			$config['total_rows'] = $this->obj_admin_settings->count_rows_event();
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
			
			if(isset($_SESSION['Print_Event_Details'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/print_event_details');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//GET PRINT COUNT
		function print_deity_details($start = 0) {
			$data['print_deity'] = $this->obj_admin_settings->get_print_deity_details(10,$start);
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_setting/print_deity_details';
			$config['total_rows'] = $this->obj_admin_settings->count_rows_deity();
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
			
			if(isset($_SESSION['Print_Deity_Details'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/print_deity_details');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//GET INKIND ITEMS
		function inkind_items() {
			$data['inkind_items'] = $this->obj_admin_settings->get_all_field_inkind();
			
			if(isset($_SESSION['Inkind_Items'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/inkind_items');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//REDIRECT TO ADD INKIND
		function add_inkind() {
			$this->load->view('header');           
			$this->load->view('admin_settings/add_inkind');
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
			$this->obj_admin_settings->add_inkind_modal($data);
			redirect('/admin_settings/Admin_setting/inkind_items/');
		}
		
		//REDIRECT TO ADD INKIND
		function edit_inkind($id) {
			$condition = array('INKIND_ITEM_ID' => $id);
			$data['inkind_items'] = $this->obj_admin_settings->get_all_field_inkind($condition);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/edit_inkind');
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
			$this->obj_admin_settings->update_inkind_modal($data,$condition);
			redirect('/admin_settings/Admin_setting/inkind_items/');
		}
		
		//CHANGE PASSWORD
		function change_password($id) {
			$data['id'] = $id;
			$condition = array('USER_ID' => $id); 
			$data['users'] = $this->obj_admin_settings->get_all_field_users($condition);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/change_password');
			$this->load->view('footer_home');
		}
		
		//RESET PASSWORD
		function reset_password(){	
			
			$this->load->view('header');          
			$this->load->view('admin_settings/reset_password');
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
				$this->load->view('admin_settings/reset_password');
				$this->load->view('footer_home');
			} else {
				$condition2 = array('USER_PASSWORD' => $password);
				$condition = array('USER_ID' => $id);
				$this->obj_admin_settings->add_change_password_modal($condition2,$condition);
				$data['msg'] = 'Successfully updated';
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/reset_password');
				$this->load->view('footer_home');
			}
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
			redirect('/admin_settings/Admin_setting/users_setting/');
		}
		
		//SAVE TIME 
		function save_time() {
			$data = array('TIME_FROM' => $this->input->post('timepickerFrom'),
						'TIME_TO' => $this->input->post('timepickerTo'),
						'USER_ID' => $this->session->userdata('userId'));
			$this->obj_admin_settings->add_time_modal($data);
			$_SESSION['time'] = $this->obj_admin_settings->get_time();
			$this->session->set_userdata('msg', 'Update Successfully!!.');
			redirect('admin_settings/Admin_setting/time_setting');
		}
		
		//GET TIME SETTING
		function time_setting() {
			$_SESSION['time'] = $this->obj_admin_settings->get_time();
			
			if(isset($_SESSION['Time_Settings'])) {
				$this->load->view('header');
				$this->load->view('admin_settings/time_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//GET RECEIPT SETTING 123
		function receipt_setting() {
			$condition = "";
			if((isset($_SESSION['Shashwath_Seva']))){
				$condition = "";
			}
			else if((isset($_SESSION['Jeernodhara_Kanike'])) ||
				(isset($_SESSION['Jeernodhara_Hundi'])) || 
				(isset($_SESSION['Jeernodhara_Inkind']))){
					$condition = "";
			}
			else {
			$condition = "deity_receipt_counter.ABBR2 != 'SH' AND deity_receipt_counter.ABBR1 != 'SPJS' ";
			}
			$data['admin_settings_receipt'] = $this->obj_admin_settings->get_deity_receipt_setting($condition);
			$data['admin_settings_receipt_event'] = $this->obj_admin_settings->get_event_receipt_setting();
			
			if(isset($_SESSION['Receipt_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/receipt_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
			}
		
		//EDIT DEITY RECEIPT DETAILS
		function edit_deity_receipt_details($id) {
			$data['id'] = $id;
			$condition = array('RECEIPT_COUNTER_ID' => $id);
			$data['receipt_deity'] = $this->obj_admin_settings->get_deity_receipt_setting($condition);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/edit_deity_receipt');
			$this->load->view('footer_home');
		}
		
		//SAVE DEITY RECEIPT DETAILS
		function save_deity_receipt_details() {
			$data = array('ABBR1' => $_POST['receipt_for'], 'ABBR2' => $_POST['receipt_format']);
			$condition = array('RECEIPT_COUNTER_ID' => $_POST['receiptid']); 
			$this->obj_admin_settings->edit_deity_receipt_counter_modal($condition,$data);
			redirect('/admin_settings/Admin_setting/receipt_setting/');
		}
		
		//EDIT EVENT RECEIPT DETAILS
		function edit_event_receipt_details($id) {
			$data['id'] = $id;
			$condition = array('ET_RECEIPT_COUNTER_ID' => $id);
			$data['receipt_event'] = $this->obj_admin_settings->get_event_receipt_setting($condition);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/edit_event_receipt');
			$this->load->view('footer_home');
		}
		
		//SAVE EVENT RECEIPT DETAILS
		function save_event_receipt_details() {
			$data = array('ET_ABBR1' => $_POST['et_receipt_for'], 'ET_ABBR2' => $_POST['et_receipt_format']);
			$condition = array('ET_RECEIPT_COUNTER_ID' => $_POST['receiptid']); 
			$this->obj_admin_settings->edit_event_receipt_counter_modal($condition,$data);
			redirect('/admin_settings/Admin_setting/receipt_setting/');
		}
		
		//UPDATE DEITY RECEIPT COUNTER
		function update_deity_receipt_counter() {
			$data = array('RECEIPT_COUNTER' => 1);
			$condition = array('RECEIPT_COUNTER_ID' => $_POST['id']); 
			$this->obj_admin_settings->edit_deity_receipt_counter_modal($condition,$data);
			echo "Success";
		}
		
		//UPDATE EVENT RECEIPT COUNTER
		function update_event_receipt_counter() {
			$data = array('ET_RECEIPT_COUNTER' => 1);
			$condition = array('ET_RECEIPT_COUNTER_ID' => $_POST['id']); 
			$this->obj_admin_settings->edit_event_receipt_counter_modal($condition,$data);
			echo "Success";
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
						
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_admin_settings->get_all_field($condition);
			$condtUser = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
			$data['usersCombo'] = $this->obj_admin_settings->get_all_users_on_events($condtUser,'ET_RECEIPT_ISSUED_BY','asc');
			
			//GETTING USERS
			$condition_users = array('USER_ACTIVE' => 1);
			$data['users'] = $this->obj_admin_settings->get_all_users($condition_users);
			//GETTING EVENTS
			$condition_events = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_admin_settings->get_all_events($condition_events);
			//GET EVENT RECEIPT
			$condition_app = array('REFERENCE' => 'App', 'ET_RECEIPT_DATE' => $dateImport);
			$data['app_data'] = $this->obj_admin_settings->get_all_app_data($condition_app,'ET_RECEIPT_ID','desc',10,$start);
			
			if(@$pMethod == "All" && @$users == "All Users") {
				$condition_app = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$data['app_data'] = $this->obj_admin_settings->get_all_app_data($condition_app,'ET_RECEIPT_ID','desc',10,$start);
			} else if(@$pMethod != "All" && @$users != "All Users") {
				$condition_app = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $pMethod, 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$data['app_data'] = $this->obj_admin_settings->get_all_app_data($condition_app,'ET_RECEIPT_ID','desc',10,$start);
			} else if(@$pMethod != "All" && @$users == "All Users") {
				$condition_app = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $pMethod,'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$data['app_data'] = $this->obj_admin_settings->get_all_app_data($condition_app,'ET_RECEIPT_ID','desc',10,$start);
			} else if(@$pMethod == "All" && @$users != "All Users") {
				$condition_app = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_DATE' => $dateImport,'ET_RECEIPT_ACTIVE'=>1);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
				$data['app_data'] = $this->obj_admin_settings->get_all_app_data($condition_app,'ET_RECEIPT_ID','desc',10,$start);
			}
			
			$data['All'] = $this->obj_admin_settings->get_total_amount($condt);
			$data['Cash'] = $this->obj_admin_settings->get_total_amount($condt1);
			$data['Cheque'] = $this->obj_admin_settings->get_total_amount($condt2);
			$data['TotalAmount'] = $this->obj_admin_settings->get_all_amount($condition_app);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/admin_settings/Admin_setting/get_data_on_filter';
			$config['total_rows'] = $this->obj_admin_settings->count_rows_donation($condition_app);
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
			$this->load->view('admin_settings/import_setting');
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
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_admin_settings->get_all_field($condition);
			
			//USER COMBO
			$condtUser = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
			$data['usersCombo'] = $this->obj_admin_settings->get_all_users_on_events($condtUser,'ET_RECEIPT_ISSUED_BY','asc');
			
			$condt = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
			$data['All'] = $this->obj_admin_settings->get_total_amount($condt);
			$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
			$data['Cash'] = $this->obj_admin_settings->get_total_amount($condt1);
			$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
			$data['Cheque'] = $this->obj_admin_settings->get_total_amount($condt2);
			$condt3 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_RECEIPT_DATE' => $dateImport);
			
			//GETTING USERS
			$condition_users = array('USER_ACTIVE' => 1);
			$data['users'] = $this->obj_admin_settings->get_all_users($condition_users);
			//GETTING EVENTS
			$condition_events = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_admin_settings->get_all_events($condition_events);
			//GET EVENT RECEIPT
			$condition_app = array('REFERENCE' => 'App', 'ET_RECEIPT_DATE' => $dateImport);
			$data['app_data'] = $this->obj_admin_settings->get_all_app_data($condition_app,'ET_RECEIPT_ID','desc',10,$start);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/admin_settings/Admin_setting/import_setting/';
			$config['total_rows'] = $this->obj_admin_settings->count_rows_donation($condition_app);
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
			
			if(isset($_SESSION['Import_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/import_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		//For Shashwath calendar Export
		function CalendarReportExcel() {
			$data['whichTab'] = "report";
			$file_ending = "xls";
			$filename = "CalendarReportExcel_".date("d-m-Y");
			$dateStart = $this->input->post('dateStart');
			$dateEnd = $this->input->post('dateEnd');
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			
			$header = "DATE" . ",";
			$header .= "SAMVATSARA" . ",";
			$header .= "MASA" . ",";
			$header .= "SH/BH" . ",";
			$header .= "THITHI" . ",";
			$header .= "CODE" . ",";
			$header .= "NAKSHATRA" . ",";
			$header .= "DAY" . ",";
			$header .= "DUPLICATE" . ",";
			$header .= "DEACTIVE_STATUS" . "\n";

			$result = "";
			$Calendar_report_excel = $this->obj_admin_settings->getCalendarExcelPDFReport( $dateStart,$dateEnd);
			
			$i = 1; $totalLoss = 0; $value2 = "";
			foreach($Calendar_report_excel as $res) {				
				//$value = "";
				//$value = '"'.$i.'"'.",";
				$value = '"' . $res->ENG_DATE.'"'. ",";
				$value .= '"' . $res->SAMVATSARA.'"'. ",";
				$value .= '"' . $res->MASA.'"'. ",";
				$value .= '"' . $res->BASED_ON_MOON.'"'. ",";
				$value .= '"' . $res->THITHI_NAME.'"'. ",";
				$value .= '"' . $res->THITHI_SHORT_CODE.'"'. ",";
				$value .= '"' . $res->STAR.'"'. ",";
				$value .= '"' . $res->DAY.'"'. ",";
				$value .= '"' . $res->DUPLICATE.'"'. ",";
				$value .= '"' . $res->DEACTIVE_STATUS.'"'. "\n";
				$result .= trim($value) . "\n";
				$i++;
			}
			$result = str_replace( "\r" , "" , $result );
			print("$header\n$result"); 
		}

		function getCalendarRecords() {
			if(isset($_POST['calId'])){
				$calId = $_SESSION['cal_id'] = $this->input->post('calId');
				$calStartDate = $_SESSION['cal_start_date'] = $this->input->post('calstDate');
				$calEndDate = $_SESSION['cal_end_date'] = $this->input->post('calEndDate');
				$calRoi = $_SESSION['cal_roi'] = $this->input->post('calRoi');
				$editStatus = $_SESSION['edit_status'] = $this->input->post('editStatus');
 			} else if(isset($_SESSION['cal_id'])){
				$calId = $_SESSION['cal_id'];
				$calStartDate = $_SESSION['cal_start_date'];
				$calEndDate = $_SESSION['cal_end_date'];
				$calRoi = $_SESSION['cal_roi'];
				$editStatus = $_SESSION['edit_status'];
			} 

			if($this->obj_shashwath->count_rows_calendar_breakup($calId) == 0) {
				$calTmpStrtDt = date('d-m-Y',strtotime($calStartDate));
				$calTmpEndDt = date('d-m-Y',strtotime($calEndDate));
				
				$data = array(
						'CAL_ID' => $calId,
						'ENG_DATE' => date('d-m-Y',strtotime($calTmpStrtDt)),
						'DAY' => strtoupper(substr(date('l',strtotime($calTmpStrtDt)),0,3))
				);
				$this->obj_shashwath->InsertFreshCalendarRecords($data);
				while($calTmpStrtDt != $calTmpEndDt) {
					$data = array(
						'CAL_ID' => $calId,
						'ENG_DATE' => date('d-m-Y',strtotime($calTmpStrtDt . ' + 1 day')),
						'DAY' => strtoupper(substr(date('l',strtotime($calTmpStrtDt . ' + 1 day')),0,3))
					);

					$this->obj_shashwath->InsertFreshCalendarRecords($data);

					$calTmpStrtDt = date('d-m-Y',strtotime($calTmpStrtDt . ' + 1 day'));				
				}

				$data['import_cal_setting'] = $this->fetchCalendarRecords($calId);
			} else {
				$data['import_cal_setting'] = $this->fetchCalendarRecords($calId);
			}

			$data['calId'] = $calId;
			$data['calStartDate'] = $calStartDate;
			$data['calEndDate'] = $calEndDate;
			$data['rateOfInterest'] = $calRoi;
			$data['editStatus'] = $editStatus;

			$this->load->view('header',$data);           
			$this->load->view('admin_settings/import_cal_setting');
			$this->load->view('footer_home');
		}
		
		function fetchCalendarRecords($calId) {
			return $this->obj_shashwath->get_calendar_records($calId,15,0);
		}

		function deleteDuplicateDateRecordsBasedOnCalYearId() {
			$condition = array(
							'CAL_ID' => $this->input->post('CalId'),
							'CAL_YEAR_ID' => $this->input->post('CalYearId')
			);


			$this->db->where($condition);
			$this->db->delete('CALENDAR_YEAR_BREAKUP');


			$condition2 = array('CAL_YEAR_ID' => $this->input->post('DupCalYearId'));
			$data = array('DUPLICATE' => 0);
			$this->db->where($condition2);
			$this->db->update('CALENDAR_YEAR_BREAKUP',$data);

			echo "success";
		}

		function duplicateDateRecordsBasedOnCalYearId() {
			//Update Duplicating Record With Duplicate No -1
			$cond = array(
						'CAL_YEAR_ID' => $this->input->post('CalYearId') 
			);

			$data = array(
						'DUPLICATE' => -1
			);

			$this->db->where($cond);
			$this->db->update('CALENDAR_YEAR_BREAKUP', $data);			

			//Insert Duplicate Records
			$data = array(
						'CAL_ID' => trim($this->input->post('CalId')),
						'ENG_DATE' => trim($this->input->post('EngDate')), 
						'SAMVATSARA' => trim($this->input->post('Samvatsara')),
						'THITHI_SHORT_CODE' => trim($this->input->post('TSC')),
						'THITHI_NAME' => trim($this->input->post('Thithi')),
						'BASED_ON_MOON' => trim($this->input->post('Bom')),
						'MASA' => trim($this->input->post('Masa')),
						'STAR' => trim($this->input->post('Star')),
						'DAY' => trim($this->input->post('Day')),
						'DUPLICATE' => trim($this->input->post('CalYearId'))
			);

			$this->db->insert('CALENDAR_YEAR_BREAKUP', $data);

			echo "success";
		}

		// function updateDateRecordsBasedOnCalYearId() {
		// 	$condition = array(
		// 					'CAL_ID' => $this->input->post('CalId'),
		// 					'CAL_YEAR_ID' => $this->input->post('CalYearId')
		// 	);

		// 	$data = array(
		// 				'SAMVATSARA' => $this->input->post('Samvatsara'),
		// 				'THITHI_SHORT_CODE' => $this->input->post('TSC'),
		// 				'THITHI_NAME' => $this->input->post('Thithi'),
		// 				'BASED_ON_MOON' => $this->input->post('Bom'),
		// 				'MASA' => $this->input->post('Masa'),
		// 				'STAR' => $this->input->post('Star')
		// 	);

		// 	$this->db->where($condition);
		// 	$this->db->update('CALENDAR_YEAR_BREAKUP', $data);

		// 	echo "success";
		// }

		function updateDateRecordsBasedOnCalYearId() {
			$engDate = $this->input->post('EngDate'); 
			$date = $engDate;
    		$newdate = date("d-m-Y",strtotime ( '-1 day' , strtotime ( $date ) )) ;
    		$duplicateRecord =  $this->obj_shashwath->getDuplicateRecords($engDate); 
    		$duplicateRecord1 =  $this->obj_shashwath->getDuplicateRecords($newdate); 
			//print_r($newdate);
			$calyid = $this->input->post('CalYearId');
    		$excistingDuplicateRecord =  $this->obj_shashwath->getExcistingDuplicateRecords($calyid); 

			$DID = $excistingDuplicateRecord[0]->DUPLICATE;
			//print_r($DID);
			if($DID!=0){
			$originalRecord = $this->obj_shashwath->getExcistingDuplicateRecords($DID); 	
			$existing =$this->input->post('TSC');
			$originalExisting = $originalRecord[0]->THITHI_SHORT_CODE;
			}
			// print_r($originalRecord);

			// print_r($existing);
			// print_r($originalExisting);
			if($DID != 0 && trim($existing)==trim($originalExisting)) {		
				echo "failed";
			} else {
				$condition = array(
					'CAL_ID' => $this->input->post('CalId'),
					'CAL_YEAR_ID' => $this->input->post('CalYearId')
				);
				$thithiDuplicate = $this->input->post('TSC');
				//print_r($thithiDuplicate);
				$thithiOriginal = $duplicateRecord1[0]->THITHI_SHORT_CODE;
				//print_r($thithiOriginal);
				if(trim($thithiDuplicate)==trim($thithiOriginal)){
					$data = array(
						'SAMVATSARA' => trim($this->input->post('Samvatsara')),
						'THITHI_SHORT_CODE' => trim($thithiDuplicate),
						//'THITHI_SHORT_CODE' => $duplicateRecord[0]->THITHI_SHORT_CODE,
						'THITHI_NAME' => trim($this->input->post('Thithi')),
						'BASED_ON_MOON' => trim($this->input->post('Bom')),
						'MASA' => trim($this->input->post('Masa')),
						'STAR' => trim($this->input->post('Star')),
						'DEACTIVE_STATUS' => 1
					);
				} else {
					$data = array(
						'SAMVATSARA' => trim($this->input->post('Samvatsara')),
						 'THITHI_SHORT_CODE' => trim($thithiDuplicate),
						//'THITHI_SHORT_CODE' => $duplicateRecord[0]->THITHI_SHORT_CODE,
						'THITHI_NAME' => trim($this->input->post('Thithi')),
						'BASED_ON_MOON' => trim($this->input->post('Bom')),
						'MASA' => trim($this->input->post('Masa')),
						'STAR' => trim($this->input->post('Star')),
						'DEACTIVE_STATUS' => 0
					);
				}
				$this->db->where($condition);
				$this->db->update('CALENDAR_YEAR_BREAKUP', $data);
				echo "success";
			}
		}
		
		function import_cal_setting($start=0) {
			if(isset($_POST['calId'])){
				$calId= $this->input->post('calId');
				$calStartDate = $this->input->post('calstDate');
				$calEndDate = $this->input->post('calEndDate');
				$calRoi = $this->input->post('calRoi');
				$editStatus = $this->input->post('editStatus');
				$_SESSION['cal_id'] = $this->input->post('calId');
				$_SESSION['cal_start_date'] = $this->input->post('calstDate');
				$_SESSION['cal_end_date'] = $this->input->post('calEndDate');
				$_SESSION['cal_roi'] = $this->input->post('calRoi');
				$_SESSION['edit_status'] = $this->input->post('editStatus');
				$data['calId'] = $calId;
				$data['calStartDate'] = $calStartDate;
				$data['calEndDate'] = $calEndDate; 
				$data['rateOfInterest'] = $calRoi;
				$data['editStatus'] = $editStatus;
 			} else if(isset($_SESSION['cal_id'])){
				$calId = $_SESSION['cal_id'];
				$calStartDate = $_SESSION['cal_start_date'];
				$calEndDate = $_SESSION['cal_end_date'];
				$calRoi = $_SESSION['cal_roi'];
				$editStatus = $_SESSION['edit_status'];
				$data['calId'] = $calId;
				$data['calStartDate'] = $calStartDate;
				$data['calEndDate'] = $calEndDate; 
				$data['rateOfInterest'] = $calRoi;
				$data['editStatus'] = $editStatus;
			} 
			$this->load->library('pagination');
			$data['import_cal_setting'] = $this->obj_shashwath->get_calendar_records($calId,15,$start); 
			$config['base_url'] = base_url().'admin_settings/Admin_setting/import_cal_setting';
			$config['total_rows']= $this->obj_shashwath->count_rows_calendar_breakup($calId);
			$config['per_page'] = 15;
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
			$this->load->view('admin_settings/import_cal_setting');
			$this->load->view('footer_home');
		}
		//IMPORT EXISTING SHASHWATH DETAILS
		function existing_import_setting($start=0) {
			$data['whichTab'] = 'shashwath';

			$this->load->library('pagination');
			$data['existing_import_setting'] = $this->obj_shashwath->get_existing_shashwath_records(10,$start); 
			$config['base_url'] = base_url().'admin_settings/Admin_setting/existing_import_setting';
			$data['total_rows'] = $config['total_rows']= $this->obj_shashwath->count_rows_existing_shashwath_member();
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
			$this->load->view('admin_settings/existing_import_setting');
			$this->load->view('footer_home');
		}
		
		public function search_existing_shashwath_member($start=0)
		{
			$data['whichTab'] = 'shashwath';
			if(isset($_POST['reciept_no'])){
				$_SESSION['reciept_no'] = $this->input->post('reciept_no');
				$reciept_no = $this->input->post('reciept_no');
				$data['reciept_no'] = $reciept_no;   
			} else if(isset($_SESSION['reciept_no'])) {
				$reciept_no = $_SESSION['reciept_no'];
				$data['reciept_no'] = $reciept_no;
			} else {
				$reciept_no = '';
			}
			$data['existing_import_setting'] = $this->obj_shashwath->count_rows_existing_shashwath_member($reciept_no);
			//$data['records'] = $this->obj_shashwath->get_member_details();
			$this->load->library('pagination');
			$data['existing_import_setting'] = $this->obj_shashwath->get_existing_shashwath_records(10,$start,$reciept_no);
			//$data['memberCount'] = $this->obj_shashwath->count_rows_member();
			$config['base_url'] = base_url().'admin_settings/Admin_setting/search_existing_shashwath_member';
			$data['total_rows'] =$config['total_rows']= $this->obj_shashwath->count_rows_existing_shashwath_member($reciept_no);
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
			$this->load->view('admin_settings/existing_import_setting');
			$this->load->view('footer_home');
		}

		//reciept name
		public function search_existing_shashwath_member_name($start=0)
		{
			$data['whichTab'] = 'shashwath';
			if(isset($_POST['reciept_name'])){
				$_SESSION['reciept_name'] = $this->input->post('reciept_name');
				$reciept_name = $this->input->post('reciept_name');
				$data['reciept_name'] = $reciept_name;   
				}else if(isset($_SESSION['reciept_name'])) {
					$reciept_name = $_SESSION['reciept_name'];
					$data['reciept_name'] = $reciept_name;
				} else {
					$reciept_name = '';
				}
				$data['existing_import_setting'] = $this->obj_shashwath->count_rows_existing_shashwath_member_name($reciept_name);
				//$data['records'] = $this->obj_shashwath->get_member_details();
				$this->load->library('pagination');
				$data['existing_import_setting'] = $this->obj_shashwath->get_existing_shashwath_records_name(10,$start,$reciept_name);
				//$data['memberCount'] = $this->obj_shashwath->count_rows_member();
				$config['base_url'] = base_url().'admin_settings/Admin_setting/search_existing_shashwath_member_name';
				$data['total_rows'] =$config['total_rows']= $this->obj_shashwath->count_rows_existing_shashwath_member_name($reciept_name);
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
				$this->load->view('admin_settings/existing_import_setting');
				$this->load->view('footer_home');
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
				$this->load->view('admin_settings/users_setting');
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
					$receiptNo = $receiptFormat;
				} else {
					$receiptNo = "";
				}
				
				$data_array = array('REFERENCE_NO' => $arr_data[$z][0],
									'ET_RECEIPT_NAME' => $arr_data[$z][1],
									'ET_RECEIPT_PHONE' => $arr_data[$z][2],
									'ET_RECEIPT_PRICE' => $arr_data[$z][3],
									'ET_RECEIPT_EMAIL' => $arr_data[$z][4],
									'ET_RECEIPT_ADDRESS' => $arr_data[$z][5],
									'ET_RECEIPT_PAYMENT_METHOD' => $arr_data[$z][6],
									'CHEQUE_NO' => $arr_data[$z][7],
									'CHEQUE_DATE' => $arr_data[$z][8],
									'BANK_NAME' => $arr_data[$z][9],
									'BRANCH_NAME' => $arr_data[$z][10],
									'ET_RECEIPT_ACTIVE' => $arr_data[$z][11],
									'ET_RECEIPT_PAYMENT_METHOD_NOTES' => $arr_data[$z][12],
									'ET_RECEIPT_DATE' => $arr_data[$z][14],
									'DATE_TIME' => $arr_data[$z][15],
									'ET_RECEIPT_NO' => $receiptNo,
									'ET_RECEIPT_ISSUED_BY' => $userName,
									'ET_RECEIPT_ISSUED_BY_ID' => $userId,
									'RECEIPT_ET_NAME' => $eventName,
									'RECEIPT_ET_ID' => $eventId,
									'ET_RECEIPT_CATEGORY_ID' => 2,
									'PAYMENT_STATUS' => $PaymentStatus,
									'AUTHORISED_STATUS' => "No",
									'CANCEL_NOTES' => $arr_data[$z][13],
									'REFERENCE' => "App");
								
				$this->obj_admin_settings->insert_event_receipt_modal($data_array);
			}
			redirect('/admin_settings/Admin_setting/import_setting/');
		}
		
		//GET GROUP SETTING
		function groups_setting() {
			//$condition_One = array('GROUP_ACTIVE' => 1); 
			if($this->session->userdata('userGroup') != 6) {
				$groupId = explode(",",$this->session->userdata('userGroup'));
				$data['user_group_id'] = $groupId[0];
				$condition_One = array('GROUP_ID !=' =>  6); 
				$data['admin_settings_group_rights'] = $this->obj_admin_settings->get_group_rights_data($condition_One);
			} else {
				$data['user_group_id'] = $this->session->userdata('userGroup');
				$data['admin_settings_group_rights'] = $this->obj_admin_settings->get_group_rights_data();
			}
			
			if(isset($_SESSION['Group_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/groups_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		// 
		function deityChequeRemmittance($start = 0) {
			unset($_SESSION['chequenumber']);
			$cheque_number = '';//please donot remove this line. It is very important(since I have used same model for search)
			// $condition = array('PAYMENT_STATUS' => "Pending",'finacial_group_ledger_heads.FGLH_PARENT_ID'=>9);
			$data['deityCheckRemmittance'] = $this->obj_admin_settings->get_all_deityChequeRemmittance(10,$start,$cheque_number);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_setting/deityChequeRemmittance';
			$data['total_count'] = $config['total_rows'] = $this->obj_admin_settings->get_all_deityChequeRemmittanceCount($cheque_number);
			
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
			if(isset($_SESSION['Deity_Cheque_Remmittance'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/deityCheckRemmittance');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		
		function SearchdeityChequeRemmittance($start = 0) {
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
			$data['deityCheckRemmittance'] = $this->obj_admin_settings->get_all_deityChequeRemmittance(10,$start, $cheque_number,$voucherType);
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_setting/SearchdeityChequeRemmittance';
			$data['total_count'] = $config['total_rows'] = $this->obj_admin_settings->get_all_deityChequeRemmittanceCount($cheque_number,$voucherType);
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
			
			if(isset($_SESSION['Deity_Cheque_Remmittance'])) {
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/deityCheckRemmittance');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		function chequeRemmittance($start = 0) {
			unset($_SESSION['chequeNumber']);
			$cheque_number = '';//please donot remove this line. It is very important(since I have used same model for search)$condition,
			$data['checkRemmittance'] = $this->obj_admin_settings->get_all_chequeRemmittance(10,$start, $cheque_number);
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_setting/chequeRemmittance';
			$data['total_count'] = $config['total_rows'] = $this->obj_admin_settings->get_all_chequeRemmittanceCount($cheque_number);
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
				$this->load->view('admin_settings/checkRemmittance');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		function SearchchequeRemmittance($start = 0) {
			if(isset($_POST['chequeNumber']) || isset($_POST['voucherType'])){
				$_SESSION['chequeNumber'] = $this->input->post('chequeNumber');
				$_SESSION['voucherType'] = $this->input->post('voucherType');
				//the cheque_number is a result from the post call
				$cheque_number = $this->input->post('chequeNumber');
				$voucherType = $this->input->post('voucherType');

				$data['cheque_Number'] = $cheque_number;
				$data['voucherType'] = $voucherType;

			} else if(isset($_SESSION['chequeNumber'])||isset($_SESSION['voucherType'])) {
				$cheque_number = $_SESSION['chequeNumber'];
				$voucherType = $_SESSION['voucherType'];

				$data['cheque_Number'] = $cheque_number;
				$data['voucherType'] = $voucherType;
			} else {
				$cheque_number = '';
				$voucherType = '';
			}

			// $condition = array('ET_RECEIPT_PAYMENT_METHOD' => "Cheque",'ET_RECEIPT_ACTIVE'=>1); 
			$data['checkRemmittance'] = $this->obj_admin_settings->get_all_chequeRemmittance(10,$start,$cheque_number,$voucherType);
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_setting/SearchchequeRemmittance';
			$data['total_count'] = $config['total_rows'] = $this->obj_admin_settings->get_all_chequeRemmittanceCount($cheque_number,$voucherType);
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
				$this->load->view('admin_settings/checkRemmittance');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		function edit_chequeRemmittance() {
			if($_POST) {
				$chequedate = $_POST['chequedate'];
				$receiptId = $_POST['receiptId'];
				$voucherNo = $_POST['voucherNo'];
				$voucherType = $_POST['voucherType'];
				if($voucherType=="Receipt"){
					$this->db->where('ET_RECEIPT_ID',$receiptId);
					$this->db->update('EVENT_RECEIPT', array('PAYMENT_CONFIRMED_BY_NAME'=>$_SESSION['userFullName'],'CHEQUE_CREDITED_DATE'=>$chequedate,'PAYMENT_STATUS'=>'Completed','PAYMENT_CONFIRMED_BY'=>$_SESSION['userId'],'PAYMENT_DATE_TIME'=>date('d-m-Y H:i:s A'),'PAYMENT_DATE'=>date('d-m-Y')));
				}else if($voucherType=="Payment" || $voucherType=="Contra"){
					$this->db->where('VOUCHER_NO',$voucherNo);
					$this->db->update('finance_cheque_detail', array('FCD_STATUS'=>'Reconciled','RECONCILED_DATE'=>$chequedate));
				}
				$this->db->where('VOUCHER_NO',$voucherNo);
				$this->db->update('financial_ledger_transcations', array('CHEQUE_RECONCILED_DATE'=>$chequedate,'RECONCILED_DATE_TIME'=>date('d-m-Y H:i:s A') , 'RECONCILED_BY'=>$_SESSION['userFullName'],'PAYMENT_STATUS'=>'Completed'));
				$this->chequeRemmittance();
			}
		}
		
		function edit_deityChequeRemmittance() {
			if($_POST) {
				$chequedate = $_POST['chequedate'];
				$receiptId = $_POST['receiptId'];
				$voucherNo = $_POST['voucherNo'];
				$voucherType = $_POST['voucherType'];
				if($voucherType=="Receipt"){
					$this->db->where('RECEIPT_ID',$receiptId);
					$this->db->update('DEITY_RECEIPT', array('PAYMENT_CONFIRMED_BY_NAME'=>$_SESSION['userFullName'],'CHEQUE_CREDITED_DATE'=>$chequedate,'PAYMENT_STATUS'=>'Completed','PAYMENT_CONFIRMED_BY'=>$_SESSION['userId'],'PAYMENT_DATE_TIME'=>date('d-m-Y H:i:s A'),'PAYMENT_DATE'=>date('d-m-Y')));
				} else if($voucherType=="Payment" || $voucherType=="Contra"){
					$this->db->where('VOUCHER_NO',$voucherNo);
					$this->db->update('finance_cheque_detail', array('FCD_STATUS'=>'Reconciled','RECONCILED_DATE'=>$chequedate));
				}

				$this->db->where('VOUCHER_NO',$voucherNo);
				$this->db->update('financial_ledger_transcations', array('CHEQUE_RECONCILED_DATE'=>$chequedate,'RECONCILED_DATE_TIME'=>date('d-m-Y H:i:s A') , 'RECONCILED_BY'=>$_SESSION['userFullName'],'PAYMENT_STATUS'=>'Completed'));
				$this->deityChequeRemmittance();
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
			$this->load->view('admin_settings/add_user');
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
			redirect('/admin_settings/Admin_setting/users_setting/');
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
			$this->load->view('admin_settings/edit_user');
			$this->load->view('footer_home');
		}
		
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
			redirect('/admin_settings/Admin_setting/users_setting/');
		}
		
		//UPDATE SEVA EVENT STATUS
		function update_user_status() {
			$condition_One = array('GROUP_ID' => $_POST['gid']); 
			$edit_group = $this->obj_admin_settings->get_group_rights_data($condition_One);
			if($edit_group[0]->GROUP_ACTIVE == 1) {
				$data = array('USER_ACTIVE' => $_POST['status']);
				$condition = array('USER_ID' => $_POST['id']); 
				$this->obj_admin_settings->add_update_user_modal($data,$condition);
				echo "Success";
			} else {
				echo "Failed";
			}
		}
		
		//ADD GROUP RIGHTS
		function add_group_rights() {
			$this->load->view('header');           
			$this->load->view('admin_settings/add_group_rights');
			$this->load->view('footer_home');
		}
		
		//INSERT GROUP
		function insert_group() {
			//Adding To Group Table
			$data = array('GROUP_NAME' => $this->input->post('group_name'),
						'GROUP_DESC' => $this->input->post('group_desc'),
						'GROUP_ACTIVE' => $this->input->post('group_active'));
			$latId = $this->obj_admin_settings->add_group_modal($data);
			
			if(isset($_POST['add'])) {
				$add = 1;
				$dataAdd = array('GROUP_ID' => $latId, 'R_ID' => $add);
				$this->obj_admin_settings->get_insert_rights($dataAdd);
			}
			if(isset($_POST['edit'])) {
				$edit = 2;
				$dataEdit = array('GROUP_ID' => $latId, 'R_ID' => $edit);
				$this->obj_admin_settings->get_insert_rights($dataEdit);
			}
			if(isset($_POST['actDct'])) {
				$actDct = 3;
				$dataActDct = array('GROUP_ID' => $latId, 'R_ID' => $actDct);
				$this->obj_admin_settings->get_insert_rights($dataActDct);
			}
			if(isset($_POST['authorise'])) {
				$auth = 4;
				$dataAuth = array('GROUP_ID' => $latId, 'R_ID' => $auth);
				$this->obj_admin_settings->get_insert_rights($dataAuth);
			}
			
			redirect('/admin_settings/Admin_setting/groups_setting/');
		}
		
		//EDIT GROUP RIGHTS
		function edit_group_rights($id) {
			$condition_One = array('GROUP_ID' => $id); 
			$data['edit_group'] = $this->obj_admin_settings->get_group_rights_data($condition_One);
			
			//print_r($data['edit_group']);
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/edit_group_rights');
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
				$CA = array('GROUP_ID' => $_POST['groupid'], 'R_ID' => $add);
				$addCA = $this->obj_admin_settings->get_groupright_available($CA);
				if($addCA == 0){
					$dataAdd = array('GROUP_ID' => $_POST['groupid'], 'R_ID' => $add);
					$this->obj_admin_settings->get_insert_rights($dataAdd);
				}
			} else if($this->input->post('addId') != "") {
				$conditionAdd = array('GR_ID' => $this->input->post('addId'));
				$this->obj_admin_settings->get_delete_rights($conditionAdd);
			}
			
			if(isset($_POST['edit'])) {
				$edit = 2;
				$CE = array('GROUP_ID' => $_POST['groupid'], 'R_ID' => $edit);
				$editCE = $this->obj_admin_settings->get_groupright_available($CE);
				if($editCE == 0){
					$dataEdit = array('GROUP_ID' => $_POST['groupid'], 'R_ID' => $edit);
					$this->obj_admin_settings->get_insert_rights($dataEdit);
				}
			} else if($this->input->post('editId') != "") {
				$conditionEdit = array('GR_ID' => $this->input->post('editId'));
				$this->obj_admin_settings->get_delete_rights($conditionEdit);
			}

			if(isset($_POST['actDct'])) {
				$actDct = 3;
				$CAD = array('GROUP_ID' => $_POST['groupid'], 'R_ID' => $actDct);
				$actDctCAD = $this->obj_admin_settings->get_groupright_available($CAD);
				if($actDctCAD == 0){
					$dataActDct = array('GROUP_ID' => $_POST['groupid'], 'R_ID' => $actDct);
					$this->obj_admin_settings->get_insert_rights($dataActDct);
				}
			} else if($this->input->post('actDctId') != "") {
				$conditionActDct = array('GR_ID' => $this->input->post('actDctId'));
				$this->obj_admin_settings->get_delete_rights($conditionActDct);
			}
			
			if(isset($_POST['authorise'])) {
				$auth = 4;
				$CAUTH = array('GROUP_ID' => $_POST['groupid'], 'R_ID' => $auth);
				$authCAUTH = $this->obj_admin_settings->get_groupright_available($CAUTH);
				if($authCAUTH == 0){
					$dataAuth = array('GROUP_ID' => $_POST['groupid'], 'R_ID' => $auth);
					$this->obj_admin_settings->get_insert_rights($dataAuth);
				}
			} else if($this->input->post('authoriseId') != "") {
				$conditionAuth = array('GR_ID' => $this->input->post('authoriseId'));
				$this->obj_admin_settings->get_delete_rights($conditionAuth);
			}
			
			if(isset($_POST['notification'])) {
				$notif = 5;
				$CN = array('GROUP_ID' => $_POST['groupid'], 'R_ID' => $notif);
				$CNOTIF = $this->obj_admin_settings->get_groupright_available($CN);
				if($CNOTIF == 0){
					$dataNotif = array('GROUP_ID' => $_POST['groupid'], 'R_ID' => $notif);
					$this->obj_admin_settings->get_insert_rights($dataNotif);
				}
			} else if($this->input->post('notifyId') != "") {
				$conditionNotif = array('GR_ID' => $this->input->post('notifyId'));
				$this->obj_admin_settings->get_delete_rights($conditionNotif);
			}
			
			if(isset($_POST['deitySevas'])) {
				$deitySevas = 1;
				$DS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySevas);
				$deitySevasDS = $this->obj_admin_settings->get_group_menu_right_available($DS);
				if($deitySevasDS == 0){
					$dataDS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySevas, 'M_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDS);
				} else {
					$conditionDS = array('GM_ID' => $deitySevasDS[0]->GM_ID);
					$dataDS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDS,$dataDS);
				}
				
				if(isset($_POST['deitySevas'])){
					$val = 1;	
				} else {
					$val = 0;
				}
				
				$dataCheck = array('P_ID' => $deitySevas, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deitySevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySevas, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deitySevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deitySevasId') != "") {
				$conditionDS = array('GM_ID' => $this->input->post('deitySevasId'));
				$dataDS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDS,$dataDS);
				
				if(isset($_POST['deitySevas'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deitySevas = 1;
				$dataCheck = array('P_ID' => $deitySevas, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deitySevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {		
					$condition = array('P_ID' => $deitySevas, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
				
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deitySevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//shashwath menu
			/*	if(isset($_POST['shashwath'])) {
				$shashwath = 59;
				$SH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwath);
				$shashwathSH = $this->obj_admin_settings->get_group_menu_right_available($SH);
				if($shashwathSH == 0){
					$dataSH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwath, 'M_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataSH);
				} else {
					$conditionSH = array('GM_ID' => $shashwathSH[0]->GM_ID);
					$dataSH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionSH,$dataSH);
				}
				
				if(isset($_POST['shashwath'])){
					$val = 1;	
				} else {
					$val = 0;
				}
				
				$dataCheck = array('P_ID' => $shashwath, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $shashwath, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwath, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $shashwath, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('shashwathId') != "") {
				$conditionSH = array('GM_ID' => $this->input->post('shashwathId'));
				$dataSH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionSH,$dataSH);
				
				if(isset($_POST['shashwathseva'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$shashwath = 59;
				$dataCheck = array('P_ID' => $shashwath, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $shashwath, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {		
					$condition = array('P_ID' => $shashwath, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
				
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $shashwath, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} */
			
			
			//jeernodhara kanike
			if(isset($_POST['jeernodharakanike'])) {
				$jeernodharakanike = 68;
				$JH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $jeernodharakanike);
				$jeernodharakanikeJH = $this->obj_admin_settings->get_group_menu_right_available($JH);
				if($jeernodharakanikeJH == 0){
					$dataSH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $jeernodharakanike, 'M_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataSH);
				} else {
					$conditionJH = array('GM_ID' => $jeernodharakanikeJH[0]->GM_ID);
					$dataJH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionJH,$dataJH);
				}
				
				if(isset($_POST['jeernodharakanike'])){
					$val = 1;	
				} else {
					$val = 0;
				}
				
				$dataCheck = array('P_ID' => $jeernodharakanike, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $jeernodharakanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $jeernodharakanike, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $jeernodharakanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('jeernodharakanikeId') != "") {
				$conditionJH = array('GM_ID' => $this->input->post('jeernodharakanikeId'));
				$dataJH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionJH,$dataJH);
				
				if(isset($_POST['jeernodharakanike'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$jeernodharakanike = 68;
				$dataCheck = array('P_ID' => $jeernodharakanike, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $jeernodharakanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {		
					$condition = array('P_ID' => $jeernodharakanike, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
				
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $jeernodharakanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//jeernodhara hundi
			if(isset($_POST['jeernodharahundi'])) {
				$jeernodharahundi = 69;
				$JH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $jeernodharahundi);
				$jeernodharahundiJH = $this->obj_admin_settings->get_group_menu_right_available($JH);
				if($jeernodharahundiJH == 0){
					$dataSH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $jeernodharahundi, 'M_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataSH);
				} else {
					$conditionJH = array('GM_ID' => $jeernodharahundiJH[0]->GM_ID);
					$dataJH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionJH,$dataJH);
				}
				
				if(isset($_POST['jeernodharahundi'])){
					$val = 1;	
				} else {
					$val = 0;
				}
				
				$dataCheck = array('P_ID' => $jeernodharahundi, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $jeernodharahundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $jeernodharahundi, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $jeernodharahundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('jeernodharahundiId') != "") {
				$conditionJH = array('GM_ID' => $this->input->post('jeernodharahundiId'));
				$dataJH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionJH,$dataJH);
				
				if(isset($_POST['jeernodharahundi'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$jeernodharahundi = 69;
				$dataCheck = array('P_ID' => $jeernodharahundi, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $jeernodharahundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {		
					$condition = array('P_ID' => $jeernodharahundi, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
				
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $jeernodharahundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
				
			//jeernodhara inkind
			if(isset($_POST['jeernodharainkind'])) {
				$jeernodharainkind = 70;
				$JH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $jeernodharainkind);
				$jeernodharainkindJH = $this->obj_admin_settings->get_group_menu_right_available($JH);
				if($jeernodharainkindJH == 0){
					$dataSH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $jeernodharainkind, 'M_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataSH);
				} else {
					$conditionJH = array('GM_ID' => $jeernodharainkindJH[0]->GM_ID);
					$dataJH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionJH,$dataJH);
				}
				
				if(isset($_POST['jeernodharainkind'])){
					$val = 1;	
				} else {
					$val = 0;
				}
				
				$dataCheck = array('P_ID' => $jeernodharainkind, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $jeernodharainkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $jeernodharainkind, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $jeernodharainkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('jeernodharainkindId') != "") {
				$conditionJH = array('GM_ID' => $this->input->post('jeernodharainkindId'));
				$dataJH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionJH,$dataJH);
				
				if(isset($_POST['jeernodharainkind'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$jeernodharainkind = 70;
				$dataCheck = array('P_ID' => $jeernodharainkind, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $jeernodharainkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {		
					$condition = array('P_ID' => $jeernodharainkind, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
				
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $jeernodharainkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			
			
			//jeernodhara daily report
			if(isset($_POST['jeernodharadailyreport'])) {
				$jeernodharadailyreport = 71;
				$JH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $jeernodharadailyreport);
				$jeernodharadailyreportJH = $this->obj_admin_settings->get_group_menu_right_available($JH);
				if($jeernodharadailyreportJH == 0){
					$dataSH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $jeernodharadailyreport, 'M_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataSH);
				} else {
					$conditionJH = array('GM_ID' => $jeernodharadailyreportJH[0]->GM_ID);
					$dataJH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionJH,$dataJH);
				}
				
				if(isset($_POST['jeernodharadailyreport'])){
					$val = 1;	
				} else {
					$val = 0;
				}
				
				$dataCheck = array('P_ID' => $jeernodharadailyreport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $jeernodharadailyreport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $jeernodharadailyreport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $jeernodharadailyreport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('jeernodharadailyreportId') != "") {
				$conditionJH = array('GM_ID' => $this->input->post('jeernodharadailyreportId'));
				$dataJH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionJH,$dataJH);
				
				if(isset($_POST['jeernodharadailyreport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$jeernodharadailyreport = 71;
				$dataCheck = array('P_ID' => $jeernodharadailyreport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $jeernodharadailyreport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {		
					$condition = array('P_ID' => $jeernodharadailyreport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
				
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $jeernodharadailyreport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			

			
			//shashwathseva 
				if(isset($_POST['shashwathseva'])) {
				$shashwathseva = 60;
				$SH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathseva);
				$shashwathsevaSH = $this->obj_admin_settings->get_group_menu_right_available($SH);
				if($shashwathsevaSH == 0){
					$dataSH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathseva, 'M_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataSH);
				} else {
					$conditionSH = array('GM_ID' => $shashwathsevaSH[0]->GM_ID);
					$dataSH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionSH,$dataSH);
				}
				
				if(isset($_POST['shashwathseva'])){
					$val = 1;	
				} else {
					$val = 0;
				}
				
				$dataCheck = array('P_ID' => $shashwathseva, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $shashwathseva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathseva, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $shashwathseva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('shashwathsevaId') != "") {
				$conditionSH = array('GM_ID' => $this->input->post('shashwathsevaId'));
				$dataSH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionSH,$dataSH);
				
				if(isset($_POST['shashwathseva'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$shashwathseva = 60;
				$dataCheck = array('P_ID' => $shashwathseva, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $shashwathseva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {		
					$condition = array('P_ID' => $shashwathseva, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
				
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $shashwathseva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			
			//shashwathlossreport
			if(isset($_POST['shashwathlossreport'])) {
				$shashwathlossreport = 61;
				$SH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathlossreport);
				$shashwathlossreportSH = $this->obj_admin_settings->get_group_menu_right_available($SH);
				if($shashwathlossreportSH == 0){
					$dataSH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathlossreport, 'M_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataSH);
				} else {
					$conditionSH = array('GM_ID' => $shashwathlossreportSH[0]->GM_ID);
					$dataSH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionSH,$dataSH);
				}
				
				if(isset($_POST['shashwathlossreport'])){
					$val = 1;	
				} else {
					$val = 0;
				}
				
				$dataCheck = array('P_ID' => $shashwathlossreport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $shashwathlossreport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathlossreport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $shashwathlossreport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('shashwathlossreportId') != "") {
				$conditionSH = array('GM_ID' => $this->input->post('shashwathlossreportId'));
				$dataSH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionSH,$dataSH);
				
				if(isset($_POST['shashwathlossreport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$shashwathlossreport = 61;
				$dataCheck = array('P_ID' => $shashwathlossreport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $shashwathlossreport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {		
					$condition = array('P_ID' => $shashwathlossreport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
				
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $shashwathlossreport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//shashwathnewmember
			if(isset($_POST['shashwathnewmember'])) {
				$shashwathnewmember = 62;
				$SH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathnewmember);
				$shashwathnewmemberSH = $this->obj_admin_settings->get_group_menu_right_available($SH);
				if($shashwathnewmemberSH == 0){
					$dataSH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathnewmember, 'M_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataSH);
				} else {
					$conditionSH = array('GM_ID' => $shashwathnewmemberSH[0]->GM_ID);
					$dataSH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionSH,$dataSH);
				}
				
				if(isset($_POST['shashwathnewmember'])){
					$val = 1;	
				} else {
					$val = 0;
				}
				
				$dataCheck = array('P_ID' => $shashwathnewmember, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $shashwathnewmember, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathnewmember, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $shashwathnewmember, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('shashwathnewmemberId') != "") {
				$conditionSH = array('GM_ID' => $this->input->post('shashwathnewmemberId'));
				$dataSH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionSH,$dataSH);
				
				if(isset($_POST['shashwathnewmember'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$shashwathnewmember = 62;
				$dataCheck = array('P_ID' => $shashwathnewmember, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $shashwathnewmember, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {		
					$condition = array('P_ID' => $shashwathnewmember, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
				
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $shashwathnewmember, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//shashwath member
				if(isset($_POST['shashwathmember'])) {
				$shashwathmember = 63;
				$SH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathmember);
				$shashwathmemberSH = $this->obj_admin_settings->get_group_menu_right_available($SH);
				if($shashwathmemberSH == 0){
					$dataSH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathmember, 'M_ID' => 1, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataSH);
				} else {
					$conditionSH = array('GM_ID' => $shashwathmemberSH[0]->GM_ID);
					$dataSH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionSH,$dataSH);
				}
				
				if(isset($_POST['shashwathmember'])){
					$val = 1;	
				} else {
					$val = 0;
				}
				
				$dataCheck = array('P_ID' => $shashwathmember, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $shashwathmember, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathmember, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $shashwathmember, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('shashwathmemberId') != "") {
				$conditionSH = array('GM_ID' => $this->input->post('shashwathmemberId'));
				$dataSH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionSH,$dataSH);
				
				if(isset($_POST['shashwathmember'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$shashwathmember = 63;
				$dataCheck = array('P_ID' => $shashwathmember, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $shashwathmember, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {		
					$condition = array('P_ID' => $shashwathmember, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
				
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $shashwathmember, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			

			
			//
			if(isset($_POST['eventSevas'])) {
				$eventSevas = 2;
				$ES = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventSevas);
				$eventSevasES = $this->obj_admin_settings->get_group_menu_right_available($ES);
				if($eventSevasES == 0){
					$dataES = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventSevas, 'M_ID' => 2, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataES);
				} else {
					$conditionES = array('GM_ID' => $eventSevasES[0]->GM_ID);
					$dataES = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionES,$dataES);
				}
				
				if(isset($_POST['eventSevas'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('eventSevasId') != "") {
				$conditionES = array('GM_ID' => $this->input->post('eventSevasId'));
				$dataES = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionES,$dataES);
				
				if(isset($_POST['eventSevas'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventSevas = 2;
				$dataCheck = array('P_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $eventSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['allDeityReceipt'])) {
				$allDeityReceipt = 3;
				$ADR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allDeityReceipt);
				$allDeityReceiptADR = $this->obj_admin_settings->get_group_menu_right_available($ADR);
				if($allDeityReceiptADR == 0){
					$dataADR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allDeityReceipt, 'M_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataADR);
				} else {
					$conditionADR = array('GM_ID' => $allDeityReceiptADR[0]->GM_ID);
					$dataADR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionADR,$dataADR);
				}
				
				if(isset($_POST['allDeityReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $allDeityReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $allDeityReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allDeityReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $allDeityReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('allDeityReceiptId') != "") {
				$conditionADR = array('GM_ID' => $this->input->post('allDeityReceiptId'));
				$dataADR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionADR,$dataADR);
				
				if(isset($_POST['allDeityReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allDeityReceipt = 3;
				$dataCheck = array('P_ID' => $allDeityReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $allDeityReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allDeityReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $allDeityReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['allEventReceipt'])) {
				$allEventReceipt = 4;
				$AER = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allEventReceipt);
				$allEventReceiptAER = $this->obj_admin_settings->get_group_menu_right_available($AER);
				if($allEventReceiptAER == 0){
					$dataAER = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allEventReceipt, 'M_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataAER);
				} else {
					$conditionAER = array('GM_ID' => $allEventReceiptAER[0]->GM_ID);
					$dataAER = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionAER,$dataAER);
				}
				
				if(isset($_POST['allEventReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('allEventReceiptId') != "") {
				$conditionAER = array('GM_ID' => $this->input->post('allEventReceiptId'));
				$dataAER = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionAER,$dataAER);
				
				if(isset($_POST['allEventReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allEventReceipt = 4;
				$dataCheck = array('P_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $allEventReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deitySeva'])) {
				$deitySeva = 5;
				$DS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySeva);
				$deitySevaDS = $this->obj_admin_settings->get_group_menu_right_available($DS);
				if($deitySevaDS == 0){
					$dataDS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySeva, 'M_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDS);
				} else {
					$conditionDS = array('GM_ID' => $deitySevaDS[0]->GM_ID);
					$dataDS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDS,$dataDS);
				}
				
				if(isset($_POST['deitySeva'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deitySeva, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deitySeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySeva, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deitySeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deitySevaId') != "") {
				$conditionDS = array('GM_ID' => $this->input->post('deitySevaId'));
				$dataDS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDS,$dataDS);
				
				if(isset($_POST['deitySeva'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deitySeva = 5;
				$dataCheck = array('P_ID' => $deitySeva, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deitySeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySeva, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deitySeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deityDonation'])) {
				$deityDonation = 6;
				$DD = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityDonation);
				$deityDonationDD = $this->obj_admin_settings->get_group_menu_right_available($DD);
				if($deityDonationDD == 0){
					$dataDD = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityDonation, 'M_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDD);
				} else {
					$conditionDD = array('GM_ID' => $deityDonationDD[0]->GM_ID);
					$dataDD = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDD,$dataDD);
				}
				
				if(isset($_POST['deityDonation'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deityDonation, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deityDonation, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityDonation, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deityDonation, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deityDonationId') != "") {
				$conditionDD = array('GM_ID' => $this->input->post('deityDonationId'));
				$dataDD = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDD,$dataDD);
				
				if(isset($_POST['deityDonation'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deityDonation = 6;
				$dataCheck = array('P_ID' => $deityDonation, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deityDonation, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityDonation, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deityDonation, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deityKanike'])) {
				$deityKanike = 7;
				$DK = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityKanike);
				$deityKanikeDK = $this->obj_admin_settings->get_group_menu_right_available($DK);
				if($deityKanikeDK == 0){
					$dataDK = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityKanike, 'M_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDK);
				} else {
					$conditionDK = array('GM_ID' => $deityKanikeDK[0]->GM_ID);
					$dataDK = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDK,$dataDK);
				}
				
				if(isset($_POST['deityKanike'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deityKanike, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deityKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityKanike, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deityKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deityKanikeId') != "") {
				$conditionDK = array('GM_ID' => $this->input->post('deityKanikeId'));
				$dataDK = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDK,$dataDK);
				
				if(isset($_POST['deityKanike'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deityKanike = 7;
				$dataCheck = array('P_ID' => $deityKanike, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deityKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityKanike, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deityKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['eventSeva'])) {
				$eventSeva = 8;
				$ES = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventSeva);
				$eventSevaES = $this->obj_admin_settings->get_group_menu_right_available($ES);
				if($eventSevaES == 0){
					$dataES = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventSeva, 'M_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataES);
				} else {
					$conditionES = array('GM_ID' => $eventSevaES[0]->GM_ID);
					$dataES = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionES,$dataES);
				}
				
				if(isset($_POST['eventSeva'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('eventSevaId') != "") {
				$conditionES = array('GM_ID' => $this->input->post('eventSevaId'));
				$dataES = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionES,$dataES);
				
				if(isset($_POST['eventSeva'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventSeva = 8;
				$dataCheck = array('P_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $eventSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['eventDonationKanike'])) {
				$eventDonationKanike = 9;
				$EDK = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventDonationKanike);
				$eventDonationKanikeEDK = $this->obj_admin_settings->get_group_menu_right_available($EDK);
				if($eventDonationKanikeEDK == 0){
					$dataEDK = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventDonationKanike, 'M_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataEDK);
				} else {
					$conditionEDK = array('GM_ID' => $eventDonationKanikeEDK[0]->GM_ID);
					$dataEDK = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionEDK,$dataEDK);
				}
				
				if(isset($_POST['eventDonationKanike'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('eventDonationKanikeId') != "") {
				$conditionEDK = array('GM_ID' => $this->input->post('eventDonationKanikeId'));
				$dataEDK = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionEDK,$dataEDK);
				
				if(isset($_POST['eventDonationKanike'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventDonationKanike = 9;
				$dataCheck = array('P_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $eventDonationKanike, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deityEventHundi'])) {
				$deityEventHundi = 10;
				$DEH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityEventHundi);
				$deityEventHundiDEH = $this->obj_admin_settings->get_group_menu_right_available($DEH);
				if($deityEventHundiDEH == 0){
					$dataDEH = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityEventHundi, 'M_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDEH);
				} else {
					$conditionDEH = array('GM_ID' => $deityEventHundiDEH[0]->GM_ID);
					$dataDEH = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDEH,$dataDEH);
				}
				
				if(isset($_POST['deityEventHundi'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deityEventHundiId') != "") {
				$conditionDEH = array('GM_ID' => $this->input->post('deityEventHundiId'));
				$dataDEH = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDEH,$dataDEH);
				
				if(isset($_POST['deityEventHundi'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deityEventHundi = 10;
				$dataCheck = array('P_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deityEventHundi, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deityEventInkind'])) {
				$deityEventInkind = 11;
				$DEI = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityEventInkind);
				$deityEventInkindDEI = $this->obj_admin_settings->get_group_menu_right_available($DEI);
				if($deityEventInkindDEI == 0){
					$dataDEI = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityEventInkind, 'M_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDEI);
				} else {
					$conditionDEI = array('GM_ID' => $deityEventInkindDEI[0]->GM_ID);
					$dataDEI = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDEI,$dataDEI);
				}
				
				if(isset($_POST['deityEventInkind'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deityEventInkindId') != "") {
				$conditionDEI = array('GM_ID' => $this->input->post('deityEventInkindId'));
				$dataDEI = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDEI,$dataDEI);
				
				if(isset($_POST['deityEventInkind'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deityEventInkind = 11;
				$dataCheck = array('P_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deityEventInkind, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deityReceiptReport'])) {
				$deityReceiptReport = 12;
				$DRR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityReceiptReport);
				$deityReceiptReportDRR = $this->obj_admin_settings->get_group_menu_right_available($DRR);
				if($deityReceiptReportDRR == 0){
					$dataDRR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityReceiptReport, 'M_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDRR);
				} else {
					$conditionDRR = array('GM_ID' => $deityReceiptReportDRR[0]->GM_ID);
					$dataDRR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDRR,$dataDRR);
				}
				
				if(isset($_POST['deityReceiptReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deityReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deityReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityReceiptReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deityReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deityReceiptReportId') != "") {
				$conditionDRR = array('GM_ID' => $this->input->post('deityReceiptReportId'));
				$dataDRR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDRR,$dataDRR);
				
				if(isset($_POST['deityReceiptReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deityReceiptReport = 12;
				$dataCheck = array('P_ID' => $deityReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deityReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityReceiptReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deityReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deitySevaReport'])) {
				$deitySevaReport = 13;
				$DSR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySevaReport);
				$deitySevaReportDSR = $this->obj_admin_settings->get_group_menu_right_available($DSR);
				if($deitySevaReportDSR == 0){
					$dataDSR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySevaReport, 'M_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDSR);
				} else {
					$conditionDSR = array('GM_ID' => $deitySevaReportDSR[0]->GM_ID);
					$dataDSR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDSR,$dataDSR);
				}
				
				if(isset($_POST['deitySevaReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deitySevaReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deitySevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySevaReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deitySevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deitySevaReportId') != "") {
				$conditionDSR = array('GM_ID' => $this->input->post('deitySevaReportId'));
				$dataDSR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDSR,$dataDSR);
				
				if(isset($_POST['deitySevaReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deitySevaReport = 13;
				$dataCheck = array('P_ID' => $deitySevaReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deitySevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySevaReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deitySevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deityMISReport'])) {
				$deityMISReport = 14;
				$DMISR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityMISReport);
				$deityMISReportDMISR = $this->obj_admin_settings->get_group_menu_right_available($DMISR);
				if($deityMISReportDMISR == 0){
					$dataDMISR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityMISReport, 'M_ID' =>  4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDMISR);
				} else {
					$conditionDMISR = array('GM_ID' => $deityMISReportDMISR[0]->GM_ID);
					$dataDMISR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDMISR,$dataDMISR);
				}
				
				if(isset($_POST['deityMISReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deityMISReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deityMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityMISReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deityMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deityMISReportId') != "") {
				$conditionDMISR = array('GM_ID' => $this->input->post('deityMISReportId'));
				$dataDMISR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDMISR,$dataDMISR);
				
				if(isset($_POST['deityMISReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deityMISReport = 14;
				$dataCheck = array('P_ID' => $deityMISReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deityMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityMISReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deityMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['currentEventReceiptReport'])) {
				$currentEventReceiptReport = 15;
				$DCERR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $currentEventReceiptReport);
				$currentEventReceiptDCERR = $this->obj_admin_settings->get_group_menu_right_available($DCERR);
				if($currentEventReceiptDCERR == 0){
					$dataDCERR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $currentEventReceiptReport, 'M_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDCERR);
				} else {
					$conditionDCERR = array('GM_ID' => $currentEventReceiptDCERR[0]->GM_ID);
					$dataDCERR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDCERR,$dataDCERR);
				}
				
				if(isset($_POST['currentEventReceiptReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('currentEventReceiptReportId') != "") {
				$conditionDCERR = array('GM_ID' => $this->input->post('currentEventReceiptReportId'));
				$dataDCERR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDCERR,$dataDCERR);
				
				if(isset($_POST['currentEventReceiptReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$currentEventReceiptReport = 15;
				$dataCheck = array('P_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $currentEventReceiptReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['currentEventSevaReport'])) {
				$currentEventSevaReport = 16;
				$DCESR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $currentEventSevaReport);
				$currentEventSevaDCESR = $this->obj_admin_settings->get_group_menu_right_available($DCESR);
				if($currentEventSevaDCESR == 0){
					$dataDCESR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $currentEventSevaReport, 'M_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDCESR);
				} else {
					$conditionDCESR = array('GM_ID' => $currentEventSevaDCESR[0]->GM_ID);
					$dataDCESR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDCESR,$dataDCESR);
				}
				
				if(isset($_POST['currentEventSevaReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('currentEventSevaReportId') != "") {
				$conditionDCESR = array('GM_ID' => $this->input->post('currentEventSevaReportId'));
				$dataDCESR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDCESR,$dataDCESR);
				
				if(isset($_POST['currentEventSevaReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$currentEventSevaReport = 16;
				$dataCheck = array('P_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $currentEventSevaReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//event seva summary
			if(isset($_POST['eventSevaSummary'])) {
				$eventSevaSummary = 72;
				$DCESR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventSevaSummary);
				$eventSevaSummaryDCESR = $this->obj_admin_settings->get_group_menu_right_available($DCESR);
				if($eventSevaSummaryDCESR == 0){
					$dataDCESR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventSevaSummary, 'M_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDCESR);
				} else {
					$conditionDCESR = array('GM_ID' => $eventSevaSummaryDCESR[0]->GM_ID);
					$dataDCESR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDCESR,$dataDCESR);
				}
				
				if(isset($_POST['eventSevaSummary'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('eventSevaSummaryId') != "") {
				$conditionDCESR = array('GM_ID' => $this->input->post('eventSevaSummaryId'));
				$dataDCESR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDCESR,$dataDCESR);
				
				if(isset($_POST['eventSevaSummary'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventSevaSummary = 72;
				$dataCheck = array('P_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $eventSevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			
			
			
			
			
			if(isset($_POST['currentEventMISReport'])) {
				$currentEventMISReport = 17;
				$DCEMISR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $currentEventMISReport);
				$currentEventMISDCEMISR = $this->obj_admin_settings->get_group_menu_right_available($DCEMISR);
				if($currentEventMISDCEMISR == 0){
					$dataDCEMISR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $currentEventMISReport, 'M_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDCEMISR);
				} else {
					$conditionDCEMISR = array('GM_ID' => $currentEventMISDCEMISR[0]->GM_ID);
					$dataDCEMISR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDCEMISR,$dataDCEMISR);
				}
				
				if(isset($_POST['currentEventMISReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('currentEventMISReportId') != "") {
				$conditionDCEMISR = array('GM_ID' => $this->input->post('currentEventMISReportId'));
				$dataDCEMISR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDCEMISR,$dataDCEMISR);
				
				if(isset($_POST['currentEventMISReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$currentEventMISReport = 17;
				$dataCheck = array('P_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $currentEventMISReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['userEventCollectionReport'])) {
				$userEventCollectionReport = 18;
				$UECR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $userEventCollectionReport);
				$userEventCollectionUECR = $this->obj_admin_settings->get_group_menu_right_available($UECR);
				if($userEventCollectionUECR == 0){
					$dataUECR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $userEventCollectionReport, 'M_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataUECR);
				} else {
					$conditionUECR = array('GM_ID' => $userEventCollectionUECR[0]->GM_ID);
					$dataUECR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionUECR,$dataUECR);
				}
				
				if(isset($_POST['userEventCollectionReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('userEventCollectionReportId') != "") {
				$conditionUECR = array('GM_ID' => $this->input->post('userEventCollectionReportId'));
				$dataUECR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionUECR,$dataUECR);
				
				if(isset($_POST['userEventCollectionReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$userEventCollectionReport = 18;
				$dataCheck = array('P_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $userEventCollectionReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['addAuctionItem'])) {
				$addAuctionItem = 19;
				$AAI = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $addAuctionItem);
				$addAuctionItemAAI = $this->obj_admin_settings->get_group_menu_right_available($AAI);
				if($addAuctionItemAAI == 0){
					$dataAAI = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $addAuctionItem, 'M_ID' => 5, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataAAI);
				} else {
					$conditionAAI = array('GM_ID' => $addAuctionItemAAI[0]->GM_ID);
					$dataAAI = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionAAI,$dataAAI);
				}
				
				if(isset($_POST['addAuctionItem'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('addAuctionItemId') != "") {
				$conditionAAI = array('GM_ID' => $this->input->post('addAuctionItemId'));
				$dataAAI = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionAAI,$dataAAI);
				
				if(isset($_POST['addAuctionItem'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$addAuctionItem = 19;
				$dataCheck = array('P_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $addAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['bidAuctionItem'])) {
				$bidAuctionItem = 20;
				$BAI = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $bidAuctionItem);
				$bidAuctionItemBAI = $this->obj_admin_settings->get_group_menu_right_available($BAI);
				if($bidAuctionItemBAI == 0){
					$dataBAI = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $bidAuctionItem, 'M_ID' => 5, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataBAI);
				} else {
					$conditionBAI = array('GM_ID' => $bidAuctionItemBAI[0]->GM_ID);
					$dataBAI = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionBAI,$dataBAI);
				}
				
				if(isset($_POST['bidAuctionItem'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('bidAuctionItemId') != "") {
				$conditionBAI = array('GM_ID' => $this->input->post('bidAuctionItemId'));
				$dataBAI = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionBAI,$dataBAI);
				
				if(isset($_POST['bidAuctionItem'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$bidAuctionItem = 20;
				$dataCheck = array('P_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $bidAuctionItem, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['auctionReceipt'])) {
				$auctionReceipt = 21;
				$AR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $auctionReceipt);
				$auctionReceiptAR = $this->obj_admin_settings->get_group_menu_right_available($AR);
				if($auctionReceiptAR == 0){
					$dataAR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $auctionReceipt, 'M_ID' => 5, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataAR);
				} else {
					$conditionAR = array('GM_ID' => $auctionReceiptAR[0]->GM_ID);
					$dataAR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionAR,$dataAR);
				}
				
				if(isset($_POST['auctionReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('auctionReceiptId') != "") {
				$conditionAR = array('GM_ID' => $this->input->post('auctionReceiptId'));
				$dataAR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionAR,$dataAR);
				
				if(isset($_POST['auctionReceipt'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$auctionReceipt = 21;
				$dataCheck = array('P_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $auctionReceipt, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['sareeOutwardReport'])) {
				$sareeOutwardReport = 22;
				$SOR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $sareeOutwardReport);
				$sareeOutwardReportSOR = $this->obj_admin_settings->get_group_menu_right_available($SOR);
				if($sareeOutwardReportSOR == 0){
					$dataSOR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $sareeOutwardReport, 'M_ID' => 5, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataSOR);
				} else {
					$conditionSOR = array('GM_ID' => $sareeOutwardReportSOR[0]->GM_ID);
					$dataSOR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionSOR,$dataSOR);
				}
				
				if(isset($_POST['sareeOutwardReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('sareeOutwardReportId') != "") {
				$conditionSOR = array('GM_ID' => $this->input->post('sareeOutwardReportId'));
				$dataSOR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionSOR,$dataSOR);
				
				if(isset($_POST['sareeOutwardReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$sareeOutwardReport = 22;
				$dataCheck = array('P_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $sareeOutwardReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['auctionItemReport'])) {
				$auctionItemReport = 23;
				$AIR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $auctionItemReport);
				$auctionitemReportAIR = $this->obj_admin_settings->get_group_menu_right_available($AIR);
				if($auctionitemReportAIR == 0){
					$dataAIR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $auctionItemReport, 'M_ID' => 5, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataAIR);
				} else {
					$conditionAIR = array('GM_ID' => $auctionitemReportAIR[0]->GM_ID);
					$dataAIR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionAIR,$dataAIR);
				}
				
				if(isset($_POST['auctionItemReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('auctionItemReportId') != "") {
				$conditionAIR = array('GM_ID' => $this->input->post('auctionItemReportId'));
				$dataAIR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionAIR,$dataAIR);
				
				if(isset($_POST['auctionItemReport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$auctionItemReport = 23;
				$dataCheck = array('P_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $auctionItemReport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deitySevaSettings'])) {
				$deitySevaSettings = 24;
				$DSS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySevaSettings);
				$deitySevaSettingsDSS = $this->obj_admin_settings->get_group_menu_right_available($DSS);
				if($deitySevaSettingsDSS == 0){
					$dataDSS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySevaSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDSS);
				} else {
					$conditionDSS = array('GM_ID' => $deitySevaSettingsDSS[0]->GM_ID);
					$dataDSS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDSS,$dataDSS);
				}
				
				if(isset($_POST['deitySevaSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deitySevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deitySevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySevaSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deitySevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deitySevaSettingsId') != "") {
				$conditionDSS = array('GM_ID' => $this->input->post('deitySevaSettingsId'));
				$dataDSS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDSS,$dataDSS);
				
				if(isset($_POST['deitySevaSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deitySevaSettings = 24;
				$dataCheck = array('P_ID' => $deitySevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deitySevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySevaSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deitySevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['eventSevaSettings'])) {
				$eventSevaSettings = 25;
				$ESS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventSevaSettings);
				$eventSevaSettingsESS = $this->obj_admin_settings->get_group_menu_right_available($ESS);
				if($eventSevaSettingsESS == 0){
					$dataESS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventSevaSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataESS);
				} else {
					$conditionESS = array('GM_ID' => $eventSevaSettingsESS[0]->GM_ID);
					$dataESS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionESS,$dataESS);
				}
				
				if(isset($_POST['eventSevaSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('eventSevaSettingsId') != "") {
				$conditionESS = array('GM_ID' => $this->input->post('eventSevaSettingsId'));
				$dataESS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionESS,$dataESS);
				
				if(isset($_POST['eventSevaSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventSevaSettings = 25;
				$dataCheck = array('P_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $eventSevaSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['receiptSettings'])) {
				$receiptSettings = 26;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $receiptSettings);
				$receiptSettingsRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($receiptSettingsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $receiptSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $receiptSettingsRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['receiptSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('receiptSettingsId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('receiptSettingsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['receiptSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$receiptSettings = 26;
				$dataCheck = array('P_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $receiptSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			// Voucher Counter
			if(isset($_POST['voucherCounter'])) {
				$voucherCounter = 89;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $voucherCounter);
				$voucherCounterRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($voucherCounterRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $voucherCounter, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $voucherCounterRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['voucherCounter'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('voucherCounterId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('voucherCounterId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['voucherCounter'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$voucherCounter = 89;
				$dataCheck = array('P_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $voucherCounter, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			// Voucher Counter ends

			// Finance Prerequisites
			if(isset($_POST['financePrerequisites'])) {
				$financePrerequisites = 90;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financePrerequisites);
				$financePrerequisitesRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($financePrerequisitesRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financePrerequisites, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $financePrerequisitesRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financePrerequisites'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('financePrerequisitesId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('financePrerequisitesId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financePrerequisites'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financePrerequisites = 90;
				$dataCheck = array('P_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $financePrerequisites, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			// Finance Prerequisites ends

			// Cheque Configuration
			if(isset($_POST['bankChequeConfiguration'])) {
				$bankChequeConfiguration = 91;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $bankChequeConfiguration);
				$bankChequeConfigurationRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($bankChequeConfigurationRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $bankChequeConfiguration, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $bankChequeConfigurationRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['bankChequeConfiguration'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('bankChequeConfigurationId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('bankChequeConfigurationId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['bankChequeConfiguration'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$bankChequeConfiguration = 91;
				$dataCheck = array('P_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $bankChequeConfiguration, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			// Cheque Configuration ends

			// kanikeSettings
			if(isset($_POST['kanikeSettings'])) {
				$kanikeSettings = 77;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $kanikeSettings);
				$kanikeSettingsRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($kanikeSettingsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $kanikeSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $kanikeSettingsRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['kanikeSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $kanikeSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $kanikeSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $kanikeSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $kanikeSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('kanikeSettingsId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('kanikeSettingsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['kanikeSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$kanikeSettings = 77;
				$dataCheck = array('P_ID' => $kanikeSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $kanikeSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $kanikeSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $kanikeSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			if(isset($_POST['timeSettings'])) {
				$timeSettings = 27;
				$TS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $timeSettings);
				$timeSettingsTS = $this->obj_admin_settings->get_group_menu_right_available($TS);
				if($timeSettingsTS == 0){
					$dataTS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $timeSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataTS);
				} else {
					$conditionTS = array('GM_ID' => $timeSettingsTS[0]->GM_ID);
					$dataTS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionTS,$dataTS);
				}
				
				if(isset($_POST['timeSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $timeSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $timeSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $timeSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $timeSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('timeSettingsId') != "") {
				$conditionTS = array('GM_ID' => $this->input->post('timeSettingsId'));
				$dataTS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionTS,$dataTS);
				
				if(isset($_POST['timeSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$timeSettings = 27;
				$dataCheck = array('P_ID' => $timeSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $timeSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $timeSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $timeSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['groupSettings'])) {
				$groupSettings = 28;
				$GS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $groupSettings);
				$groupSettingsGS = $this->obj_admin_settings->get_group_menu_right_available($GS);
				if($groupSettingsGS == 0){
					$dataGS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $groupSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataGS);
				} else {
					$conditionGS = array('GM_ID' => $groupSettingsGS[0]->GM_ID);
					$dataGS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionGS,$dataGS);
				}
				
				if(isset($_POST['groupSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('groupSettingsId') != "") {
				$conditionGS = array('GM_ID' => $this->input->post('groupSettingsId'));
				$dataGS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionGS,$dataGS);
				
				if(isset($_POST['groupSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$groupSettings = 28;
				$dataCheck = array('P_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $groupSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['userSettings'])) {
				$userSettings = 29;
				$US = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $userSettings);
				$userSettingsUS = $this->obj_admin_settings->get_group_menu_right_available($US);
				if($userSettingsUS == 0){
					$dataUS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $userSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataUS);
				} else {
					$conditionUS = array('GM_ID' => $userSettingsUS[0]->GM_ID);
					$dataUS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionUS,$dataUS);
				}
				
				if(isset($_POST['userSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('userSettingsId') != "") {
				$conditionUS = array('GM_ID' => $this->input->post('userSettingsId'));
				$dataUS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionUS,$dataUS);
				
				if(isset($_POST['userSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$userSettings = 29;
				$dataCheck = array('P_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $userSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['importSettings'])) {
				$importSettings = 30;
				$IS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $importSettings);
				$importSettingsIS = $this->obj_admin_settings->get_group_menu_right_available($IS);
				if($importSettingsIS == 0){
					$dataIS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $importSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataIS);
				} else {
					$conditionIS = array('GM_ID' => $importSettingsIS[0]->GM_ID);
					$dataIS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionIS,$dataIS);
				}
				
				if(isset($_POST['importSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $importSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $importSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $importSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $importSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('importSettingsId') != "") {
				$conditionIS = array('GM_ID' => $this->input->post('importSettingsId'));
				$dataIS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionIS,$dataIS);
				
				if(isset($_POST['importSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$importSettings = 30;
				$dataCheck = array('P_ID' => $importSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $importSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $importSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $importSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['auctionSettings'])) {
				$auctionSettings = 31;
				$AS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $auctionSettings);
				$auctionSettingsAS = $this->obj_admin_settings->get_group_menu_right_available($AS);
				if($auctionSettingsAS == 0){
					$dataAS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $auctionSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataAS);
				} else {
					$conditionAS = array('GM_ID' => $auctionSettingsAS[0]->GM_ID);
					$dataAS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionAS,$dataAS);
				}
				
				if(isset($_POST['auctionSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('auctionSettingsId') != "") {
				$conditionAS = array('GM_ID' => $this->input->post('auctionSettingsId'));
				$dataAS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionAS,$dataAS);
				
				if(isset($_POST['auctionSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$auctionSettings = 31;
				$dataCheck = array('P_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $auctionSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			if(isset($_POST['printDeityDetails'])) {
				$printDeityDetails = 32;
				$PDD = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $printDeityDetails);
				$printDeityDetailsPDD = $this->obj_admin_settings->get_group_menu_right_available($PDD);
				if($printDeityDetailsPDD == 0){
					$dataPDD = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $printDeityDetails, 'M_ID' => 7, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataPDD);
				} else {
					$conditionPDD = array('GM_ID' => $printDeityDetailsPDD[0]->GM_ID);
					$dataPDD = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionPDD,$dataPDD);
				}
				
				if(isset($_POST['printDeityDetails'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $printDeityDetails, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $printDeityDetails, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $printDeityDetails, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $printDeityDetails, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('printDeityDetailsId') != "") {
				$conditionPDD = array('GM_ID' => $this->input->post('printDeityDetailsId'));
				$dataPDD = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionPDD,$dataPDD);
				
				if(isset($_POST['printDeityDetails'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$printDeityDetails = 32;
				$dataCheck = array('P_ID' => $printDeityDetails, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $printDeityDetails, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $printDeityDetails, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $printDeityDetails, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['printEventDetails'])) {
				$printEventDetails = 33;
				$PED = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $printEventDetails);
				$printEventDetailsPED = $this->obj_admin_settings->get_group_menu_right_available($PED);
				if($printEventDetailsPED == 0){
					$dataPED = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $printEventDetails, 'M_ID' => 7, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataPED);
				} else {
					$conditionPED = array('GM_ID' => $printEventDetailsPED[0]->GM_ID);
					$dataPED = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionPED,$dataPED);
				}
				
				if(isset($_POST['printEventDetails'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $printEventDetails, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $printEventDetails, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $printEventDetails, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $printEventDetails, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('printEventDetailsId') != "") {
				$conditionPED = array('GM_ID' => $this->input->post('printEventDetailsId'));
				$dataPED = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionPED,$dataPED);
				
				if(isset($_POST['printEventDetails'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$printEventDetails = 33;
				$dataCheck = array('P_ID' => $printEventDetails, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $printEventDetails, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $printEventDetails, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $printEventDetails, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['inkindItems'])) {
				$inkindItems = 34;
				$II = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $inkindItems);
				$inkindItemII = $this->obj_admin_settings->get_group_menu_right_available($II);
				if($inkindItemII == 0){
					$dataII = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $inkindItems, 'M_ID' => 7, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataII);
				} else {
					$conditionII = array('GM_ID' => $inkindItemII[0]->GM_ID);
					$dataII = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionII,$dataII);
				}
				
				if(isset($_POST['inkindItems'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('inkindItemsId') != "") {
				$conditionII = array('GM_ID' => $this->input->post('inkindItemsId'));
				$dataII = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionII,$dataII);
				
				if(isset($_POST['inkindItems'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$inkindItems = 34;
				$dataCheck = array('P_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $inkindItems, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['chequeRemmittance'])) {
				$chequeRemmittance = 35;
				$CR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $chequeRemmittance);
				$chequeRemmittanceCR = $this->obj_admin_settings->get_group_menu_right_available($CR);
				if($chequeRemmittanceCR == 0){
					$dataCR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $chequeRemmittance, 'M_ID' => 7, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataCR);
				} else {
					$conditionCR = array('GM_ID' => $chequeRemmittanceCR[0]->GM_ID);
					$dataCR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionCR,$dataCR);
				}
				
				if(isset($_POST['chequeRemmittance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('chequeRemmittanceId') != "") {
				$conditionCR = array('GM_ID' => $this->input->post('chequeRemmittanceId'));
				$dataCR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionCR,$dataCR);
				
				if(isset($_POST['chequeRemmittance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$chequeRemmittance = 35;
				$dataCheck = array('P_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);

					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $chequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['changeDonation'])) {
				$changeDonation = 36;
				$CD = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $changeDonation);
				$changeDonationCD = $this->obj_admin_settings->get_group_menu_right_available($CD);
				if($changeDonationCD == 0){
					$dataCD = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $changeDonation, 'M_ID' => 7, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataCD);
				} else {
					$conditionCD = array('GM_ID' => $changeDonationCD[0]->GM_ID);
					$dataCD = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionCD,$dataCD);
				}
				
				if(isset($_POST['changeDonation'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $changeDonation, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $changeDonation, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $changeDonation, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $changeDonation, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('changeDonationId') != "") {
				$conditionCD = array('GM_ID' => $this->input->post('changeDonationId'));
				$dataCD = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionCD,$dataCD);
				
				if(isset($_POST['changeDonation'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$changeDonation = 36;
				$dataCheck = array('P_ID' => $changeDonation, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $changeDonation, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $changeDonation, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $changeDonation, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['backUp'])) {
				$backUp = 37;
				$BU = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $backUp);
				$backUpBU = $this->obj_admin_settings->get_group_menu_right_available($BU);
				if($backUpBU == 0){
					$dataBU = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $backUp, 'M_ID' => 7, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataBU);
				} else {
					$conditionBU = array('GM_ID' => $backUpBU[0]->GM_ID);
					$dataBU = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionBU,$dataBU);
				}
				
				if(isset($_POST['backUp'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $backUp, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $backUp, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $backUp, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $backUp, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('backUpId') != "") {
				$conditionBU = array('GM_ID' => $this->input->post('backUpId'));
				$dataBU = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionBU,$dataBU);
				
				if(isset($_POST['backUp'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$backUp = 37;
				$dataCheck = array('P_ID' => $backUp, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $backUp, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $backUp, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $backUp, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['bookSeva'])) {
				$bookSeva = 38;
				$BS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $bookSeva);
				$bookSevaBS = $this->obj_admin_settings->get_group_menu_right_available($BS);
				if($bookSevaBS == 0){
					$dataBS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $bookSeva, 'M_ID' => 8, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataBS);
				} else {
					$conditionBS = array('GM_ID' => $bookSevaBS[0]->GM_ID);
					$dataBS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				}
				
				if(isset($_POST['bookSeva'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $bookSeva, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $bookSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $bookSeva, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $bookSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('bookSevaId') != "") {
				$conditionBS = array('GM_ID' => $this->input->post('bookSevaId'));
				$dataBS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				
				if(isset($_POST['backUp'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$bookSeva = 38;
				$dataCheck = array('P_ID' => $bookSeva, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $bookSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $bookSeva, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $bookSeva, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['allBookedSevas'])) {
				$allBookedSevas = 39;
				$ABS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allBookedSevas);
				$allBookedSevasABS = $this->obj_admin_settings->get_group_menu_right_available($ABS);
				if($allBookedSevasABS == 0){
					$dataABS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allBookedSevas, 'M_ID' => 8, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataABS);
				} else {
					$conditionABS = array('GM_ID' => $allBookedSevasABS[0]->GM_ID);
					$dataABS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionABS,$dataABS);
				}
				
				if(isset($_POST['allBookedSevas'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $allBookedSevas, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $allBookedSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allBookedSevas, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $allBookedSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('allBookedSevasId') != "") {
				$conditionABS = array('GM_ID' => $this->input->post('allBookedSevasId'));
				$dataABS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionABS,$dataABS);
				
				if(isset($_POST['allBookedSevas'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allBookedSevas = 39;
				$dataCheck = array('P_ID' => $allBookedSevas, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $allBookedSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allBookedSevas, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $allBookedSevas, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Suraksha
			if(isset($_POST['bookedPendingReceipts'])) {
				$bookedPendingReceipts = 76;
				$ABS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $bookedPendingReceipts);
				$bookedPendingReceiptsABS = $this->obj_admin_settings->get_group_menu_right_available($ABS);
				if($bookedPendingReceiptsABS == 0){
					$dataABS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $bookedPendingReceipts, 'M_ID' => 8, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataABS);
				} else {
					$conditionABS = array('GM_ID' => $bookedPendingReceiptsABS[0]->GM_ID);
					$dataABS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionABS,$dataABS);
				}
				
				if(isset($_POST['bookedPendingReceipts'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $bookedPendingReceipts, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $bookedPendingReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $bookedPendingReceipts, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $bookedPendingReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('bookedPendingReceiptsId') != "") {
				$conditionABS = array('GM_ID' => $this->input->post('bookedPendingReceiptsId'));
				$dataABS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionABS,$dataABS);
				
				if(isset($_POST['bookedPendingReceipts'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$bookedPendingReceipts = 76;
				$dataCheck = array('P_ID' => $bookedPendingReceipts, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $bookedPendingReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $bookedPendingReceipts, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $bookedPendingReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['financialMonthSettings'])) {
				$financialMonthSettings = 40;
				$FMS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financialMonthSettings);
				$financialMonthSettingsFMS = $this->obj_admin_settings->get_group_menu_right_available($FMS);
				if($financialMonthSettingsFMS == 0){
					$dataFMS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financialMonthSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataFMS);
				} else {
					$conditionFMS = array('GM_ID' => $financialMonthSettingsFMS[0]->GM_ID);
					$dataFMS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionFMS,$dataFMS);
				}
				
				if(isset($_POST['financialMonthSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $financialMonthSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $financialMonthSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financialMonthSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $financialMonthSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('financialMonthSettingsId') != "") {
				$conditionFMS = array('GM_ID' => $this->input->post('financialMonthSettingsId'));
				$dataFMS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionFMS,$dataFMS);
				
				if(isset($_POST['financialMonthSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financialMonthSettings = 40;
				$dataCheck = array('P_ID' => $financialMonthSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $financialMonthSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financialMonthSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $financialMonthSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deityChequeRemmittance'])) {
				$deityChequeRemmittance = 41;
				$DCR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityChequeRemmittance);
				$deityChequeRemmittanceDCR = $this->obj_admin_settings->get_group_menu_right_available($DCR);
				if($deityChequeRemmittanceDCR == 0){
					$dataDCR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityChequeRemmittance, 'M_ID' => 7, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDCR);
				} else {
					$conditionDCR = array('GM_ID' => $deityChequeRemmittanceDCR[0]->GM_ID);
					$dataDCR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDCR,$dataDCR);
				}
				
				if(isset($_POST['deityChequeRemmittance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deityChequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deityChequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityChequeRemmittance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deityChequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deityChequeRemmittanceId') != "") {
				$conditionDCR = array('GM_ID' => $this->input->post('deityChequeRemmittanceId'));
				$dataDCR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDCR,$dataDCR);
				
				if(isset($_POST['deityChequeRemmittance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deityChequeRemmittance = 41;
				$dataCheck = array('P_ID' => $deityChequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deityChequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityChequeRemmittance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deityChequeRemmittance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			if(isset($_POST['deityEOD'])) {
				$deityEOD = 42;
				$EOD = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityEOD);
				$deityEODR = $this->obj_admin_settings->get_group_menu_right_available($EOD);
				if($deityEODR == 0){
					$dataEODR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deityEOD, 'M_ID' => 9, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataEODR);
				} else {
					$conditionEODR = array('GM_ID' => $deityEODR[0]->GM_ID);
					$dataEODR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionEODR,$dataEODR);
				}
				
				if(isset($_POST['deityEOD'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deityEOD, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deityEOD, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityEOD, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deityEOD, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deityEODId') != "") {
				$conditionEODR = array('GM_ID' => $this->input->post('deityEODId'));
				$dataEODR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionEODR,$dataEODR);
				
				if(isset($_POST['deityEOD'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deityEOD = 42;
				$dataCheck = array('P_ID' => $deityEOD, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deityEOD, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deityEOD, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deityEOD, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['bankSettings'])) {
				$bankSettings = 43;
				$BS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $bankSettings);
				$bankSettingsBS = $this->obj_admin_settings->get_group_menu_right_available($BS);
				if($bankSettingsBS == 0){
					$dataBS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $bankSettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataBS);
				} else {
					$conditionBS = array('GM_ID' => $bankSettingsBS[0]->GM_ID);
					$dataBS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				}
				
				if(isset($_POST['bankSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('bankSettingsId') != "") {
				$conditionBS = array('GM_ID' => $this->input->post('bankSettingsId'));
				$dataBS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				
				if(isset($_POST['bankSettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$bankSettings = 43;
				$dataCheck = array('P_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $bankSettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['EODTally'])) {
				$EODTally = 44;
				$EODT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $EODTally);
				$deityEODT = $this->obj_admin_settings->get_group_menu_right_available($EODT);
				if($deityEODT == 0){
					$dataEODT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $EODTally, 'M_ID' => 9, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataEODT);
				} else {
					$conditionEODT = array('GM_ID' => $deityEODT[0]->GM_ID);
					$dataEODT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionEODT,$dataEODT);
				}
				
				if(isset($_POST['EODTally'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $EODTally, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $EODTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $EODTally, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $EODTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('EODTallyId') != "") {
				$conditionEODT = array('GM_ID' => $this->input->post('EODTallyId'));
				$dataEODT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionEODT,$dataEODT);
				
				if(isset($_POST['EODTally'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$EODTally = 44;
				$dataCheck = array('P_ID' => $EODTally, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $EODTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $EODTally, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $EODTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['deitySevaSummary'])) {
				$deitySevaSummary = 45;
				$DSS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySevaSummary);
				$deityDSS = $this->obj_admin_settings->get_group_menu_right_available($DSS);
				if($deityDSS == 0){
					$dataDSS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySevaSummary, 'M_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDSS);
				} else {
					$conditionDSS = array('GM_ID' => $deityDSS[0]->GM_ID);
					$dataDSS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDSS,$dataDSS);
				}
				
				if(isset($_POST['deitySevaSummary'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deitySevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deitySevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySevaSummary, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deitySevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deitySevaSummaryId') != "") {
				$conditionDSS = array('GM_ID' => $this->input->post('deitySevaSummaryId'));
				$dataDSS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDSS,$dataDSS);
				
				if(isset($_POST['deitySevaSummary'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deitySevaSummary = 45;
				$dataCheck = array('P_ID' => $deitySevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deitySevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySevaSummary, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deitySevaSummary, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['eventEOD'])) {
				$eventEOD = 46;
				$EEOD = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventEOD);
				$eventEEOD = $this->obj_admin_settings->get_group_menu_right_available($EEOD);
				if($eventEEOD == 0){
					$dataEEOD = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventEOD, 'M_ID' => 10, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataEEOD);
				} else {
					$conditionEEOD = array('GM_ID' => $eventEEOD[0]->GM_ID);
					$dataEEOD = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionEEOD,$dataEEOD);
				}
				
				if(isset($_POST['eventEOD'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $eventEOD, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $eventEOD, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventEOD, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $eventEOD, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('eventEODId') != "") {
				$conditionEEOD = array('GM_ID' => $this->input->post('eventEODId'));
				$dataEEOD = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionEEOD,$dataEEOD);
				
				if(isset($_POST['eventEOD'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventEOD = 46;
				$dataCheck = array('P_ID' => $eventEOD, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $eventEOD, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventEOD, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $eventEOD, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['eventEODTally'])) {
				$eventEODTally = 47;
				$EEODT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventEODTally);
				$eventEEODT = $this->obj_admin_settings->get_group_menu_right_available($EEODT);
				if($eventEEODT == 0){
					$dataEEODT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $eventEODTally, 'M_ID' => 10, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataEEODT);
				} else {
					$conditionEEODT = array('GM_ID' => $eventEEODT[0]->GM_ID);
					$dataEEODT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionEEODT,$dataEEODT);
				}
				
				if(isset($_POST['eventEODTally'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $eventEODTally, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $eventEODTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventEODTally, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $eventEODTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('eventEODTallyId') != "") {
				$conditionEEODT = array('GM_ID' => $this->input->post('eventEODTallyId'));
				$dataEEODT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionEEODT,$dataEEODT);
				
				if(isset($_POST['eventEODTally'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$eventEODTally = 47;
				$dataCheck = array('P_ID' => $eventEODTally, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $eventEODTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $eventEODTally, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $eventEODTally, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['Temple_Day_Book'])) {
				$Temple_Day_Book = 48;
				$DRR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $Temple_Day_Book);
				$Temple_Day_BookDRR = $this->obj_admin_settings->get_group_menu_right_available($DRR);
				if($Temple_Day_BookDRR == 0){
					$dataDRR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $Temple_Day_Book, 'M_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDRR);
				} else {
					$conditionDRR = array('GM_ID' => $Temple_Day_BookDRR[0]->GM_ID);
					$dataDRR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDRR,$dataDRR);
				}
				
				if(isset($_POST['Temple_Day_Book'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $Temple_Day_Book, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $Temple_Day_Book, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $Temple_Day_Book, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $Temple_Day_Book, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('Temple_Day_Book_Id') != "") {
				$conditionDRR = array('GM_ID' => $this->input->post('Temple_Day_Book_Id'));
				$dataDRR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDRR,$dataDRR);
				
				if(isset($_POST['Temple_Day_Book'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$Temple_Day_Book = 48;
				$dataCheck = array('P_ID' => $Temple_Day_Book, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $Temple_Day_Book, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $Temple_Day_Book, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $Temple_Day_Book, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			if(isset($_POST['srnsFund'])) {
				$SRNS_Fund = 49;
				$DRR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $SRNS_Fund);
				$srnsFundDRR = $this->obj_admin_settings->get_group_menu_right_available($DRR);
				if($srnsFundDRR == 0){
					$dataDRR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $SRNS_Fund, 'M_ID' => 3, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDRR);
				} else {
					$conditionDRR = array('GM_ID' => $srnsFundDRR[0]->GM_ID);
					$dataDRR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDRR,$dataDRR);
				}
				
				if(isset($_POST['srnsFund'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $SRNS_Fund, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $SRNS_Fund, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $SRNS_Fund, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $SRNS_Fund, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('srnsFundId') != "") {
				$conditionDRR = array('GM_ID' => $this->input->post('srnsFundId'));
				$dataDRR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDRR,$dataDRR);
				
				if(isset($_POST['srnsFund'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$SRNS_Fund = 49;
				$dataCheck = array('P_ID' => $SRNS_Fund, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $SRNS_Fund, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $SRNS_Fund, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $SRNS_Fund, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//JEERNODHARA RECEIPT SETTING
				if(isset($_POST['receiptsettings'])) {
				$receiptsettings = 67;
				$JS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $receiptsettings);
				$receiptsettingsJS = $this->obj_admin_settings->get_group_menu_right_available($BS);
				if($receiptsettingsJS == 0){
					$dataBS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $receiptsettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataBS);
				} else {
					$conditionBS = array('GM_ID' => $receiptsettingsJS[0]->GM_ID);
					$dataBS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				}
				
				if(isset($_POST['receiptsettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $receiptsettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $receiptsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $receiptsettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $receiptsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('receiptsettingsId') != "") {
				$conditionBS = array('GM_ID' => $this->input->post('receiptsettingsId'));
				$dataBS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				
				if(isset($_POST['receiptsettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$receiptsettings = 67;
				$dataCheck = array('P_ID' => $receiptsettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $receiptsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $receiptsettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $receiptsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			//SHASHWATH PERIOD SETTING
				if(isset($_POST['shashwathperiodsettings'])) {
				$shashwathperiodsettings = 64;
				$BS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathperiodsettings);
				$shashwathperiodsettingsBS = $this->obj_admin_settings->get_group_menu_right_available($BS);
				if($shashwathperiodsettingsBS == 0){
					$dataBS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathperiodsettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataBS);
				} else {
					$conditionBS = array('GM_ID' => $shashwathperiodsettingsBS[0]->GM_ID);
					$dataBS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				}
				
				if(isset($_POST['shashwathperiodsettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $shashwathperiodsettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $shashwathperiodsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathperiodsettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $shashwathperiodsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('shashwathperiodsettingsId') != "") {
				$conditionBS = array('GM_ID' => $this->input->post('shashwathperiodsettingsId'));
				$dataBS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				
				if(isset($_POST['shashwathperiodsettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$shashwathperiodsettings = 64;
				$dataCheck = array('P_ID' => $shashwathperiodsettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $shashwathperiodsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathperiodsettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $shashwathperiodsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//SHASHWATH CALENDAR SETTING
			if(isset($_POST['shashwathcalendarsettings'])) {
				$shashwathcalendarsettings = 65;
				$BS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathcalendarsettings);
				$shashwathcalendarsettingsBS = $this->obj_admin_settings->get_group_menu_right_available($BS);
				if($shashwathcalendarsettingsBS == 0){
					$dataBS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathcalendarsettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataBS);
				} else {
					$conditionBS = array('GM_ID' => $shashwathcalendarsettingsBS[0]->GM_ID);
					$dataBS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				}
				
				if(isset($_POST['shashwathcalendarsettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $shashwathcalendarsettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $shashwathcalendarsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathcalendarsettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $shashwathcalendarsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('shashwathcalendarsettingsId') != "") {
				$conditionBS = array('GM_ID' => $this->input->post('shashwathcalendarsettingsId'));
				$dataBS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				
				if(isset($_POST['shashwathcalendarsettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$shashwathcalendarsettings = 65;
				$dataCheck = array('P_ID' => $shashwathcalendarsettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $shashwathcalendarsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathcalendarsettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $shashwathcalendarsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			// SHASHWATH FESTIVAL SETTING STARTS SURAKSHA
			if(isset($_POST['shashwathfestivalsettings'])) {
				$shashwathfestivalsettings = 75;
				$BS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathfestivalsettings);
				$shashwathfestivalsettingsBS = $this->obj_admin_settings->get_group_menu_right_available($BS);
				if($shashwathfestivalsettingsBS == 0){
					$dataBS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathfestivalsettings, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataBS);
				} else {
					$conditionBS = array('GM_ID' => $shashwathfestivalsettingsBS[0]->GM_ID);
					$dataBS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				}
				
				if(isset($_POST['shashwathfestivalsettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $shashwathfestivalsettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $shashwathfestivalsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathfestivalsettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $shashwathfestivalsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('shashwathfestivalsettingsId') != "") {
				$conditionBS = array('GM_ID' => $this->input->post('shashwathfestivalsettingsId'));
				$dataBS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				
				if(isset($_POST['shashwathfestivalsettings'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$shashwathfestivalsettings = 65;
				$dataCheck = array('P_ID' => $shashwathfestivalsettings, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $shashwathfestivalsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathfestivalsettings, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $shashwathfestivalsettings, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// SHASHWATH FESTIVAL SETTING ENDS

			
			//SHASHWATH IMPORT
			if(isset($_POST['shashwathexistingimport'])) {
				$shashwathexistingimport = 66;
				$BS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathexistingimport);
				$shashwathexistingimportBS = $this->obj_admin_settings->get_group_menu_right_available($BS);
				if($shashwathexistingimportBS == 0){
					$dataBS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $shashwathexistingimport, 'M_ID' => 15, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataBS);
				} else {
					$conditionBS = array('GM_ID' => $shashwathexistingimportBS[0]->GM_ID);
					$dataBS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				}
				
				if(isset($_POST['shashwathexistingimport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $shashwathexistingimport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $shashwathexistingimport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathexistingimport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $shashwathexistingimport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('shashwathexistingimportId') != "") {
				$conditionBS = array('GM_ID' => $this->input->post('shashwathexistingimportId'));
				$dataBS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionBS,$dataBS);
				
				if(isset($_POST['shashwathexistingimport'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$shashwathexistingimport = 66;
				$dataCheck = array('P_ID' => $shashwathexistingimport, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $shashwathexistingimport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $shashwathexistingimport, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $shashwathexistingimport, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//EVENT TOKEN
			if(isset($_POST['eventToken'])) {
				$ETToken = 50;
				$ETT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $ETToken);
				$etTokenETT = $this->obj_admin_settings->get_group_menu_right_available($ETT);
				if($etTokenETT == 0){
					$dataETT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $ETToken, 'M_ID' => 11, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataETT);
				} else {
					$conditionETT = array('GM_ID' => $etTokenETT[0]->GM_ID);
					$dataETT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionETT,$dataETT);
				}
				
				if(isset($_POST['eventToken'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $ETToken, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $ETToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $ETToken, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $ETToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('eventTokenId') != "") {
				$conditionETT = array('GM_ID' => $this->input->post('eventTokenId'));
				$dataETT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionETT,$dataETT);
				
				if(isset($_POST['eventToken'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$ETToken = 50;
				$dataCheck = array('P_ID' => $ETToken, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $ETToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $ETToken, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $ETToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//DEITY SPECIAL RECEIPT PRICE SETTING
			if(isset($_POST['deitySplRecpPrice'])) {
				$deitySplRecpPrice = 51;
				$DSRP = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySplRecpPrice);
				$deitySRP = $this->obj_admin_settings->get_group_menu_right_available($DSRP);
				if($deitySRP == 0){
					$dataDSRP = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $deitySplRecpPrice, 'M_ID' => 6, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDSRP);
				} else {
					$conditionDSRP = array('GM_ID' => $deitySRP[0]->GM_ID);
					$dataDSRP = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDSRP,$dataDSRP);
				}
				
				if(isset($_POST['deitySplRecpPrice'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $deitySplRecpPrice, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $deitySplRecpPrice, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySplRecpPrice, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $deitySplRecpPrice, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deitySplRecpPriceId') != "") {
				$conditionDSRP = array('GM_ID' => $this->input->post('deitySplRecpPriceId'));
				$dataDSRP = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDSRP,$dataDSRP);
				
				if(isset($_POST['deitySplRecpPrice'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$deitySplRecpPrice = 51;
				$dataCheck = array('P_ID' => $deitySplRecpPrice, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $deitySplRecpPrice, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $deitySplRecpPrice, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $deitySplRecpPrice, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//DEITY TOKEN
			if(isset($_POST['deityToken'])) {
				$DTToken = 52;
				$DTT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $DTToken);
				$dtTokenDTT = $this->obj_admin_settings->get_group_menu_right_available($DTT);
				if($dtTokenDTT == 0){
					$dataDTT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $DTToken, 'M_ID' => 12, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDTT);
				} else {
					$conditionDTT = array('GM_ID' => $dtTokenDTT[0]->GM_ID);
					$dataDTT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDTT,$dataDTT);
				}
				
				if(isset($_POST['deityToken'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $DTToken, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $DTToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $DTToken, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $DTToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('deityTokenId') != "") {
				$conditionDTT = array('GM_ID' => $this->input->post('deityTokenId'));
				$dataDTT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDTT,$dataDTT);
				
				if(isset($_POST['deityToken'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$DTToken = 52;
				$dataCheck = array('P_ID' => $DTToken, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $DTToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $DTToken, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $DTToken, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//POSTAGE
			if(isset($_POST['postage'])) {
				$postage = 53;
				$post = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $postage);
				$postageP = $this->obj_admin_settings->get_group_menu_right_available($post);
				if($postageP == 0){
					$dataDTT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $postage, 'M_ID' => 13, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDTT);
				} else {
					$conditionDTT = array('GM_ID' => $postageP[0]->GM_ID);
					$dataDTT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDTT,$dataDTT);
				}
				
				if(isset($_POST['postage'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('postageId') != "") {
				$conditionDTT = array('GM_ID' => $this->input->post('postageId'));
				$dataDTT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDTT,$dataDTT);
				
				if(isset($_POST['postage'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$postage = 53;
				$dataCheck = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//DISPATCH COLLECTION
			if(isset($_POST['dispatchCollection'])) {
				$dispatchCollection = 54;
				$DC = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $dispatchCollection);
				$dispatchDC = $this->obj_admin_settings->get_group_menu_right_available($DC);
				if($dispatchDC == 0){
					$dataDC = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $dispatchCollection, 'M_ID' => 13, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDC);
				} else {
					$conditionDC = array('GM_ID' => $dispatchDC[0]->GM_ID);
					$dataDC = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDC,$dataDC);
				}
				
				if(isset($_POST['dispatchCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('dispatchCollectionId') != "") {
				$conditionDC = array('GM_ID' => $this->input->post('dispatchCollectionId'));
				$dataDC = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDC,$dataDC);
				
				if(isset($_POST['dispatchCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dispatchCollection = 54;
				$dataCheck = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//ALL POSTAGE COLLECTION
			if(isset($_POST['allPostageCollection'])) {
				$allPostageCollection = 55;
				$APC = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allPostageCollection);
				$allPostCollAPC = $this->obj_admin_settings->get_group_menu_right_available($APC);
				if($allPostCollAPC == 0){
					$dataAPC = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allPostageCollection, 'M_ID' => 13, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataAPC);
				} else {
					$conditionAPC = array('GM_ID' => $allPostCollAPC[0]->GM_ID);
					$dataAPC = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionAPC,$dataAPC);
				}
				
				if(isset($_POST['allPostageCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('allPostageCollectionId') != "") {
				$conditionAPC = array('GM_ID' => $this->input->post('allPostageCollectionId'));
				$dataAPC = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionAPC,$dataAPC);
				
				if(isset($_POST['allPostageCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allPostageCollection = 55;
				$dataCheck = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			//POSTAGE
			if(isset($_POST['postageGroup'])) {
				$postage = 73;
				$post = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $postage);
				$postageP = $this->obj_admin_settings->get_group_menu_right_available($post);
				if($postageP == 0){
					$dataDTT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $postage, 'M_ID' => 13, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDTT);
				} else {
					$conditionDTT = array('GM_ID' => $postageP[0]->GM_ID);
					$dataDTT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDTT,$dataDTT);
				}
				
				if(isset($_POST['postageGroup'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('postageGroupId') != "") {
				$conditionDTT = array('GM_ID' => $this->input->post('postageGroupId'));
				$dataDTT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDTT,$dataDTT);
				
				if(isset($_POST['postageGroup'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$postage = 73;
				$dataCheck = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//EVENT POSTAGE
			if(isset($_POST['eventPostage'])) {
				$postage = 56;
				$post = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $postage);
				$postageP = $this->obj_admin_settings->get_group_menu_right_available($post);
				if($postageP == 0){
					$dataDTT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $postage, 'M_ID' => 14, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDTT);
				} else {
					$conditionDTT = array('GM_ID' => $postageP[0]->GM_ID);
					$dataDTT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDTT,$dataDTT);
				}
				
				if(isset($_POST['eventPostage'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('eventPostageId') != "") {
				$conditionDTT = array('GM_ID' => $this->input->post('eventPostageId'));
				$dataDTT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDTT,$dataDTT);
				
				if(isset($_POST['eventPostage'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$postage = 56;
				$dataCheck = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//EVENT DISPATCH COLLECTION
			if(isset($_POST['eventDispatchCollection'])) {
				$dispatchCollection = 57;
				$DC = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $dispatchCollection);
				$dispatchDC = $this->obj_admin_settings->get_group_menu_right_available($DC);
				if($dispatchDC == 0){
					$dataDC = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $dispatchCollection, 'M_ID' => 14, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDC);
				} else {
					$conditionDC = array('GM_ID' => $dispatchDC[0]->GM_ID);
					$dataDC = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDC,$dataDC);
				}
				
				if(isset($_POST['eventDispatchCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('eventDispatchCollectionId') != "") {
				$conditionDC = array('GM_ID' => $this->input->post('eventDispatchCollectionId'));
				$dataDC = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDC,$dataDC);
				
				if(isset($_POST['eventDispatchCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dispatchCollection = 57;
				$dataCheck = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $dispatchCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//ALL EVENT POSTAGE COLLECTION
			if(isset($_POST['allEventPostageCollection'])) {
				$allPostageCollection = 58;
				$APC = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allPostageCollection);
				$allPostCollAPC = $this->obj_admin_settings->get_group_menu_right_available($APC);
				if($allPostCollAPC == 0){
					$dataAPC = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allPostageCollection, 'M_ID' => 14, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataAPC);
				} else {
					$conditionAPC = array('GM_ID' => $allPostCollAPC[0]->GM_ID);
					$dataAPC = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionAPC,$dataAPC);
				}
				
				if(isset($_POST['allEventPostageCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('allEventPostageCollectionId') != "") {
				$conditionAPC = array('GM_ID' => $this->input->post('allEventPostageCollectionId'));
				$dataAPC = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionAPC,$dataAPC);
				
				if(isset($_POST['allEventPostageCollection'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allPostageCollection = 58;
				$dataCheck = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $allPostageCollection, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}
			
			//SLVT EVENT POSTAGE GROUP
			if(isset($_POST['slvtEvtPostageGroup'])) {
				$postage = 74;
				$post = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $postage);
				$postageP = $this->obj_admin_settings->get_group_menu_right_available($post);
				if($postageP == 0){
					$dataDTT = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $postage, 'M_ID' => 14, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDTT);
				} else {
					$conditionDTT = array('GM_ID' => $postageP[0]->GM_ID);
					$dataDTT = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDTT,$dataDTT);
				}
				
				if(isset($_POST['slvtEvtPostageGroup'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('slvtEvtPostageGroupId') != "") {
				$conditionDTT = array('GM_ID' => $this->input->post('slvtEvtPostageGroupId'));
				$dataDTT = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDTT,$dataDTT);
				
				if(isset($_POST['slvtEvtPostageGroup'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$postage = 74;
				$dataCheck = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $postage, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Finance start
			// Finance Receipts
			if(isset($_POST['financeReceipts'])) {
				$financeReceipts = 78;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeReceipts);
				$financeReceiptsRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($financeReceiptsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeReceipts, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $financeReceiptsRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeReceipts'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('financeReceiptsId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('financeReceiptsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeReceipts'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeReceipts = 78;
				$dataCheck = array('P_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $financeReceipts, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Finance Payments
			if(isset($_POST['financePayments'])) {
				$financePayments = 79;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financePayments);
				$financePaymentsRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($financePaymentsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financePayments, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $financePaymentsRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financePayments'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('financePaymentsId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('financePaymentsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financePayments'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financePayments = 79;
				$dataCheck = array('P_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $financePayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Finance Journal
			if(isset($_POST['financeJournal'])) {
				$financeJournal = 80;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeJournal);
				$financeJournalRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($financeJournalRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeJournal, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $financeJournalRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeJournal'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('financeJournalId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('financeJournalId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeJournal'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeJournal = 80;
				$dataCheck = array('P_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $financeJournal, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Finance Contra
			if(isset($_POST['financeContra'])) {
				$financeContra = 81;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeContra);
				$financeContraRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($financeContraRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeContra, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $financeContraRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeContra'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('financeContraId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('financeContraId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeContra'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeContra = 81;
				$dataCheck = array('P_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $financeContra, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Balance Sheet
			if(isset($_POST['balanceSheet'])) {
				$balanceSheet = 82;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $balanceSheet);
				$balanceSheetRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($balanceSheetRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $balanceSheet, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $balanceSheetRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['balanceSheet'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('balanceSheetId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('balanceSheetId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['balanceSheet'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$balanceSheet = 78;
				$dataCheck = array('P_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $balanceSheet, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Income and Expenditure
			if(isset($_POST['incomeAndExpenditure'])) {
				$incomeAndExpenditure = 83;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $incomeAndExpenditure);
				$incomeAndExpenditureRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($incomeAndExpenditureRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $incomeAndExpenditure, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $incomeAndExpenditureRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['incomeAndExpenditure'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('incomeAndExpenditureId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('incomeAndExpenditureId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['incomeAndExpenditure'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$incomeAndExpenditure = 83;
				$dataCheck = array('P_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $incomeAndExpenditure, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Receipts and Payments
			if(isset($_POST['receiptsAndPayments'])) {
				$receiptsAndPayments = 84;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $receiptsAndPayments);
				$receiptsAndPaymentsRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($receiptsAndPaymentsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $receiptsAndPayments, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $receiptsAndPaymentsRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['receiptsAndPayments'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('receiptsAndPaymentsId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('receiptsAndPaymentsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['receiptsAndPayments'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$receiptsAndPayments = 84;
				$dataCheck = array('P_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $receiptsAndPayments, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Trial Balance
			if(isset($_POST['trialBalance'])) {
				$trialBalance = 85;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $trialBalance);
				$trialBalanceRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($trialBalanceRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $trialBalance, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $trialBalanceRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['trialBalance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('trialBalanceId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('trialBalanceId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['trialBalance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$trialBalance = 85;
				$dataCheck = array('P_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $trialBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Finance Day Book
			if(isset($_POST['financeDayBook'])) {
				$financeDayBook = 92;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeDayBook);
				$financeDayBookRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($financeDayBookRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeDayBook, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $financeDayBookRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeDayBook'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('financeDayBookId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('financeDayBookId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeDayBook'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeDayBook = 92;
				$dataCheck = array('P_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $financeDayBook, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Finance Add Groups
			if(isset($_POST['financeAddGroups'])) {
				$financeAddGroups = 86;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeAddGroups);
				$financeAddGroupsRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($financeAddGroupsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeAddGroups, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $financeAddGroupsRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeAddGroups'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('financeAddGroupsId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('financeAddGroupsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeAddGroups'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeAddGroups = 86;
				$dataCheck = array('P_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $financeAddGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Finance Add Ledgers
			if(isset($_POST['financeAddLedgers'])) {
				$financeAddLedgers = 87;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeAddLedgers);
				$financeAddLedgersRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($financeAddLedgersRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeAddLedgers, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $financeAddLedgersRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeAddLedgers'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('financeAddLedgersId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('financeAddLedgersId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeAddLedgers'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeAddLedgers = 87;
				$dataCheck = array('P_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $financeAddLedgers, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// Finance Add Opening Balance
			if(isset($_POST['financeAddOpeningBalance'])) {
				$financeAddOpeningBalance = 88;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeAddOpeningBalance);
				$financeAddOpeningBalanceRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($financeAddOpeningBalanceRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $financeAddOpeningBalance, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $financeAddOpeningBalanceRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['financeAddOpeningBalance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('financeAddOpeningBalanceId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('financeAddOpeningBalanceId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['financeAddOpeningBalance'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$financeAddOpeningBalance = 88;
				$dataCheck = array('P_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $financeAddOpeningBalance, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			// All Ledgers and Groups
			if(isset($_POST['allLedgersandGroups'])) {
				$allLedgersandGroups = 93;
				$RS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allLedgersandGroups);
				$allLedgersandGroupsRS = $this->obj_admin_settings->get_group_menu_right_available($RS);
				if($allLedgersandGroupsRS == 0){
					$dataRS = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $allLedgersandGroups, 'M_ID' => 17, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataRS);
				} else {
					$conditionRS = array('GM_ID' => $allLedgersandGroupsRS[0]->GM_ID);
					$dataRS = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				}
				
				if(isset($_POST['allLedgersandGroups'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('allLedgersandGroupsId') != "") {
				$conditionRS = array('GM_ID' => $this->input->post('allLedgersandGroupsId'));
				$dataRS = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionRS,$dataRS);
				
				if(isset($_POST['allLedgersandGroups'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$allLedgersandGroups = 93;
				$dataCheck = array('P_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $allLedgersandGroups, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			//Temple Inkind Report
			if(isset($_POST['Temple_Inkind_Report'])) {
				$Temple_Inkind_Report = 94;
				$DRR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $Temple_Inkind_Report);
				$Temple_Inkind_ReportDRR = $this->obj_admin_settings->get_group_menu_right_available($DRR);
				if($Temple_Inkind_ReportDRR == 0){
					$dataDRR = array('GROUP_ID' => $_POST['groupid'], 'P_ID' => $Temple_Inkind_Report, 'M_ID' => 4, 'STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights($dataDRR);
				} else {
					$conditionDRR = array('GM_ID' => $Temple_Inkind_ReportDRR[0]->GM_ID);
					$dataDRR = array('STATUS' => 1);
					$this->obj_admin_settings->get_update_menu_rights($conditionDRR,$dataDRR);
				}
				
				if(isset($_POST['Temple_Inkind_Report'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$dataCheck = array('P_ID' => $Temple_Inkind_Report, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF CHECKED
						$dataHistory = array('P_ID' => $Temple_Inkind_Report, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $Temple_Inkind_Report, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF CHECKED
					$dataHistory = array('P_ID' => $Temple_Inkind_Report, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 1, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			} else if($this->input->post('Temple_Inkind_Report_Id') != "") {
				$conditionDRR = array('GM_ID' => $this->input->post('Temple_Inkind_Report_Id'));
				$dataDRR = array('STATUS' => 0);
				$this->obj_admin_settings->get_update_menu_rights($conditionDRR,$dataDRR);
				
				if(isset($_POST['Temple_Inkind_Report'])){
					$val = 1;
				} else {
					$val = 0;
				}
				$Temple_Inkind_Report = 94;
				$dataCheck = array('P_ID' => $Temple_Inkind_Report, 'GROUP_ID' => $_POST['groupid'], 'ACTIVE_STATUS' => 1, 'ASSIGNED_STATUS' => $val);
				$history = $this->obj_admin_settings->get_all_field_history_latest($dataCheck);
				if($history != "") {
					if($history->ASSIGNED_STATUS != $val) {
						$condition = array('GMH_ID' => $history->GMH_ID);
						$data = array('ACTIVE_STATUS' => 0);
						$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
						
						//SAVING IN THE HISTORY TABLE IF NOT CHECKED
						$dataHistory = array('P_ID' => $Temple_Inkind_Report, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
						$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
					}
				} else {
					$condition = array('P_ID' => $Temple_Inkind_Report, 'GROUP_ID' => $_POST['groupid']);
					$data = array('ACTIVE_STATUS' => 0);
					$this->obj_admin_settings->get_update_menu_rights_history($condition,$data);
					
					//SAVING IN THE HISTORY TABLE IF NOT CHECKED
					$dataHistory = array('P_ID' => $Temple_Inkind_Report, 'GROUP_ID' => $_POST['groupid'], 'ASSIGNED_BY_ID' => $_SESSION['userId'], 'DATE' => date('d-m-y'), 'DATE_TIME' => date('Y-m-d H:i:s'), 'ASSIGNED_STATUS' => 0, 'ACTIVE_STATUS' => 1);
					$this->obj_admin_settings->get_insert_menu_rights_history($dataHistory);
				}
			}

			//Finance end
			redirect('/admin_settings/Admin_setting/groups_setting/');
		}
		
		//BANK SETTING
		function bank_setting() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$data['bank'] = $this->obj_admin_settings->get_all_field_bank_modal();
			$data['eventBank'] = $this->obj_admin_settings->get_all_field_event_bank_modal();
			
			if(isset($_SESSION['Bank_Settings'])) {			
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/bank_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		//SHASHWATH SETTING
		function period_setting() {
			$data['periodDetails'] = $this->obj_admin_settings->get_period_details('PERIOD');
			$this->load->view('header',$data);
			$this->load->view('admin_settings/periodSetting');
			$this->load->view('footer_home');
		}
		//ADD PERIOD
		function add_period() {
			$this->load->view('header');
			$this->load->view('admin_settings/addPeriod');
			$this->load->view('footer_home');
		}
		
		function add_calendar() {
			$data['start_date'] = $this->obj_admin_settings->get_new_start_end_date("CAL_START_DATE");
			$data['end_date'] = $this->obj_admin_settings->get_new_start_end_date("CAL_END_DATE"); 

			$this->load->view('header',$data);
			$this->load->view('admin_settings/add_calendar');
			$this->load->view('footer_home');			
		}
		
		function calendar_display($start=0) {
		$this->load->library('pagination');
			$data['calendar'] = $this->obj_shashwath->get_calendar_details(10,$start);
			$data['calendarCount'] = $this->obj_shashwath->count_rows_calendar();
			$config['base_url'] = base_url().'admin_settings/Admin_setting/calendar_display';
			$config['total_rows']= $this->obj_shashwath->count_rows_calendar();
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
			$this->load->view('admin_settings/calender_setting');
			$this->load->view('footer_home');
		}
		
		function add_calendar_details(){
			$roi = $this->input->post('rateOfInterest');
			$startDate = $this->input->post('startDate');
			$endDate = $this->input->post('endDate');
			$data = array(
				'CAL_ROI' => $roi,
				'CAL_START_DATE' => $startDate,
				'CAL_END_DATE' => $endDate,
				'DATE' => date('d-m-Y'),
				'DATE_TIME' =>date('d-m-Y H:i:s A'),
				'ADDED_BY' =>$_SESSION['userId']
			);
			$this->db->insert('calendar',$data);
			 unset($_SESSION['nullCalendar']);
			redirect('admin_settings/Admin_setting/calendar_display');
		}

		function edit_period_setting() {
			if(isset($_POST)){
			$data['spid'] = $this->input->post('sp_id');
			$data['pname'] = $this->input->post('pname');
			$data['period'] = $this->input->post('period');
			$data['pstatus'] = $this->input->post('pstatus');
			}
			$this->load->view('header',$data);
			$this->load->view('admin_settings/editPeriodSettings');
			$this->load->view('footer_home');
		}

		//festival code start
		function festival_setting() {
			$data['festivalDetails'] = $this->obj_admin_settings->get_festival_details();
			$this->load->view('header',$data);
			$this->load->view('admin_settings/festival_setting');
			$this->load->view('footer_home');
		}
		//festival code end

		//festival code start 


		function add_festival() {
			$data['thithi_shudda'] =  $this->obj_shashwath->getThithi(1);
			$data['thithi_bahula'] =  $this->obj_shashwath->getThithi(2);
			$data['masa'] =  $this->obj_shashwath->getMasa();
			$data['moon'] =  $this->obj_shashwath->getBasedOnMoon();
			//$data['period'] = $this->obj_shashwath->getPeriod();
			$this->load->view('header',$data);
			$this->load->view('admin_settings/addFestival');
			$this->load->view('footer_home');
		}

		
		function edit_festival_setting() {
			$data['thithi_shudda'] =  $this->obj_shashwath->getThithi(1);
			$data['thithi_bahula'] =  $this->obj_shashwath->getThithi(2);
			$data['masa'] =  $this->obj_shashwath->getMasa();
			$data['moon'] =  $this->obj_shashwath->getBasedOnMoon();
			//$data['period'] = $this->obj_shashwath->getPeriod();
			if(isset($_POST)){
				$data['SFS_ID'] = $this->input->post('SFS_ID');
				$data['SFS_NAME'] = $this->input->post('SFS_NAME');
				$data['SFS_THITHI_CODE'] = $this->input->post('SFS_THITHI_CODE');
				$data['SFS_MASA'] = $this->input->post('SFS_MASA');
				$data['SFS_MOON'] = $this->input->post('SFS_MOON');
				$data['SFS_THITHI'] = $this->input->post('SFS_THITHI');

			}
			$this->load->view('header',$data);
			$this->load->view('admin_settings/editFestivalSettings');
			$this->load->view('footer_home');
		}

		//festival code end
		
		//ADD PAGE DISPLAY
		function add_bank($status) {
			$data['status'] = $status;
			if(isset($_SESSION['Bank_Settings'])) {			
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/add_bank');
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
				$this->obj_admin_settings->add_bank_modal($data);
			} else if($_POST['page'] == 2) {
				$data = array('BANK_NAME' => $_POST['bank_name'],'BANK_BRANCH' => $_POST['branch_name'],'ACCOUNT_NO' => $_POST['account_no'],'BANK_IFSC_CODE' => $_POST['ifsc_code']);
				$this->obj_admin_settings->add_event_bank_modal($data);
			}
			$this->session->set_userdata('msg', 'Successfully updated');
			$this->load->view('header');           
			$this->load->view('admin_settings/add_bank');
			$this->load->view('footer_home');
		}
		
		//EDIT PAGE DISPLAY
		function edit_bank($id,$status) {
			$data['status'] = $status;
			if($status == 1) {
				$condition = array('BANK_ID' => $id); 
				$data['bank_details'] = $this->obj_admin_settings->get_all_field_bank_modal($condition);
			} else if($status == 2) {
				$condition = array('BANK_ID' => $id); 
				$data['bank_details'] = $this->obj_admin_settings->get_all_field_event_bank_modal($condition);
			}
			
			if(isset($_SESSION['Bank_Settings'])) {			
				$this->load->view('header',$data);           
				$this->load->view('admin_settings/edit_bank');
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
				$this->obj_admin_settings->update_bank_modal($condition,$data_array);	
			} else if($_POST['page'] == 2) {
				$data_array = array('BANK_NAME' => $this->input->post('bank_name'),
									'BANK_BRANCH' => $this->input->post('branch_name'),
									'ACCOUNT_NO' => $this->input->post('account_no'),
									'BANK_IFSC_CODE' => $this->input->post('ifsc_code'));
				$condition = array('BANK_ID' => $this->input->post('bank_id'));
				$this->obj_admin_settings->update_event_bank_modal($condition,$data_array);	
			}
			redirect('/admin_settings/Admin_setting/bank_setting/');
		}
		
		//FINANCIAL SETTING
		function financial_month_setting() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			$data['fMonth'] = $this->obj_admin_settings->get_financial_month();
			
			if(isset($_SESSION['Financial_Month'])) {			
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/financial_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//SAVE FINANCIAL SETTING
		function save_financial_setting() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$fin_mon = explode("|",$_POST['fin_month']);
			$data = array('MONTH_IN_WORDS' => $fin_mon[1],'MONTH_IN_NUMBER' => $fin_mon[0]);
			//print_r($data);
			$this->obj_admin_settings->update_financial_month($data);
			$data['fMonth'] = $this->obj_admin_settings->get_financial_month();
			
			$this->session->set_userdata('msg', 'Successfully updated');
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/financial_setting');
			$this->load->view('footer_home');
		}
		
		//UPDATE SEVA EVENT STATUS
		function update_group_status() {
			$data = array('GROUP_ACTIVE' => $_POST['status']);
			$condition = array('GROUP_ID' => $_POST['id']); 
			$this->obj_admin_settings->add_update_group_modal($data,$condition);
			
			$data = array('USER_ACTIVE' => $_POST['status']);
			$condition = array('USER_GROUP' => $_POST['id']); 
			$this->obj_admin_settings->add_update_user_modal($data,$condition);
			echo "Success";
		}
		
		//GET ALL EVENTS SETTING
		function events_setting() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$condition = "";
			$data['admin_settings_events'] = $this->obj_admin_settings->get_all_field_event($condition,'ET_ACTIVE',"desc");
			
			$conditionOne = array('ET_ACTIVE' => 1, 'ET_SEVA_PRICE_ACTIVE' => 1); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_all_field_event_seva($conditionOne,'ET_SEVA_ACTIVE','desc');
			
			$conditionTwo = array('ET_ACTIVE' => 1); 
			$data['event'] = $this->obj_admin_settings->get_all_field_event_activate($conditionTwo);
			
			$conditionThree = array('ET_ACTIVE' => 1); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_all_field_limits($conditionThree, 'ET_SL_ID');
			
			if(isset($_SESSION['Event_Seva_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/events_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		function Kanike_setting() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			$data['kanikeDetails'] = $this->obj_admin_settings->get_kanike_details();
			$this->load->view('header', $data );          
			$this->load->view('admin_settings/kanike_Setting');
			$this->load->view('footer_home');
			
		}
		// function Kanike_setting() {
		// 	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		// 	$_SESSION['actual_link'] = $actual_link;
		// 	$data['kanikeDetails'] = $this->obj_admin_settings->get_kanike_details();
		// 	$data['ledger'] =  $this->obj_finance_model->getGroups();
		// 	$this->load->view('header', $data );          
		// 	$this->load->view('admin_settings/testing');
		// 	$this->load->view('footer_home');
			
		// }

		//ADD KANIKE
		function add_kanike() {
			$this->load->view('header');
			$this->load->view('admin_settings/addKanike');
			$this->load->view('footer_home');
		}

		function add_kanike_details(){
			$kanikeName = $this->input->post('kanikeN');
			$kanikeStatus = $this->input->post('kstatus');
			$price = $this->input->post('price');
			$data = array( 
			'KANIKE_NAME' => $kanikeName,
			'KS_STATUS' => $kanikeStatus,
			'PRICE' => $price
			);
			$this->obj_admin_settings->addKanikeDetails($data);
			redirect('admin_settings/Admin_setting/kanike_setting');
		}

		//UPDATE KANIKE STATUS
		function update_kanike_status() {
			$data = array('KS_STATUS' => $_POST['status']);
			$condition = array('KS_ID' => $_POST['id']); 
			$this->obj_admin_settings->edit_kanike_status($condition,$data);
			echo "Success";
		}
		
		function edit_kanike_setting() {
			if(isset($_POST)){
			$data['ksid'] = $this->input->post('ksid');
			$data['kname'] = $this->input->post('kname');
			$data['kstatus'] = $this->input->post('kstatus');
			$data['price'] = $this->input->post('price');
			}
			$this->load->view('header',$data);
			$this->load->view('admin_settings/editKanikeSettings');
			$this->load->view('footer_home');
		}

		function update_kanike_details(){
			$ksid = $this->input->post('ksid');
			$kanikeN = $this->input->post('kanikeN');
			$kStatus = $this->input->post('kStatus');
			$price = $this->input->post('price');
			$data = array(
			'KS_ID' => $ksid,
			'KANIKE_NAME' => $kanikeN,
			'KS_STATUS' => $kStatus,
			'PRICE' => $price
			);
			$this->obj_admin_settings->updateKanikeDetails($data,$ksid);
			redirect('admin_settings/Admin_setting/Kanike_setting');
		}
		
		//GET ALL EVENTS SETTING
		function events_seva_details($id) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$conditionOne = array('EVENT_SEVA.ET_ID' => $id, 'ET_SEVA_PRICE_ACTIVE' => 1); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_all_field_event_seva($conditionOne,'ET_SEVA_NAME');
			
			$conditionTwo = array('EVENT.ET_ID' => $id); 
			$data['event'] = $this->obj_admin_settings->get_all_field_event($conditionTwo);
			
			$this->session->userdata('events_details','events_details');
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/events_seva_details');
			$this->load->view('footer_home');
		}
		
		//ADD EVENT
		function add_event() {
			// $data['whichTab'] = 'Finance';
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
			$data['committee'] =  $this->obj_finance_model->getCommittee();
			// adding the committie dropdown code by adithya on 8-1-24 end
			// print_r($data['committee']);
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/add_event');
			$this->load->view('footer_home');
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
			$data['committee'] =  $this->obj_finance_model->getCommittee();
			// Added the below code by adithya on 8-1-24 start
			$condition = array('ET_ID' => $id);
			$data['admin_settings_events'] = $this->obj_admin_settings->get_all_field_event($condition);
			$data['compId'] =$data['admin_settings_events'][0]->COMP_ID; 
			$this->load->view('header', $data);
			// added the above code by adithya on 8-1-24 end
			$this->load->view('admin_settings/edit_event');
			$this->load->view('footer_home');
		}
		
		//ADD EVENT SEVA
		function add_event_seva($id) {
			$condition = array('ET_ID' => $id);
			$data['admin_settings_events'] = $this->obj_admin_settings->get_all_field_event($condition);
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/add_event_seva');
			$this->load->view('footer_home');
		}
		
		//EDIT EVENT SEVA
		function edit_event_seva($id) {	
			$condition = array('EVENT_SEVA.ET_SEVA_ID' => $id, 'ET_SEVA_PRICE_ACTIVE' => 1);
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_all_field_event_seva($condition);
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/edit_event_seva');
			$this->load->view('footer_home');
		}
		
		//SAVE EVENT
		function save_event() {
			if($this->input->post('event_active') == 1) {
				$condition = array('ET_ACTIVE' => 1); 
				$events = $this->obj_admin_settings->get_all_field_event($condition);
				if(!empty($events)) {
					$this->session->set_userdata('msg', 'An event is already active. Please set '.$events[0]->ET_NAME.' event deactive to save event details.');
					$this->session->set_userdata('EtName',$this->input->post('event_name'));
					$this->session->set_userdata('EtFrom',$this->input->post('todayDateFrom'));
					$this->session->set_userdata('EtTo',$this->input->post('todayDateTo'));
					$this->session->set_userdata('EtStatus',$this->input->post('event_active'));
					$this->session->set_userdata('EtAbbr',$this->input->post('event_abbr1'));
					$this->session->set_userdata('EtSevaAbbr',$this->input->post('event_abbr2'));
					$this->session->set_userdata('EtInkindAbbr',$this->input->post('event_abbr3'));
					$this->load->view('header');           
					$this->load->view('admin_settings/add_event');
					$this->load->view('footer_home');
					return;
				}
			}
			
		$data = array('ET_NAME' => $this->input->post('event_name'),
					'ET_FROM_DATE_TIME' => $this->input->post('todayDateFrom'),
					'ET_TO_DATE_TIME' => $this->input->post('todayDateTo'),
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'),
					'COMP_ID'=>$this->input->post('CommitteeId'),
					'USER_ID' => $this->session->userdata('userId'),
					'ET_ACTIVE' => $this->input->post('event_active'));
			
			$eventId = $this->obj_admin_settings->add_event_modal($data);
			
			//FOR SEVA
			$data_Counter1 = array('ET_ABBR1' => $this->input->post('event_abbr1'),
								  'ET_ABBR2' => $this->input->post('event_abbr2'),
								  'ET_RECEIPT_COUNTER' => 0,
								  'USER_ID' => $this->session->userdata('userId'),
								  'EVENT_ID' => $eventId,
								  'DATE_TIME' => date('d-m-Y H:i:s A'),
								  'DATE' => date('d-m-Y'));
			$sevaId = $this->obj_admin_settings->add_event_counter_modal($data_Counter1);
			
			//FOR INKIND
			$data_Counter2 = array('ET_ABBR1' => $this->input->post('event_abbr1'),
								  'ET_ABBR2' => $this->input->post('event_abbr3'),
								  'ET_RECEIPT_COUNTER' => 0,
								  'USER_ID' => $this->session->userdata('userId'),
								  'EVENT_ID' => $eventId,
								  'DATE_TIME' => date('d-m-Y H:i:s A'),
								  'DATE' => date('d-m-Y'));
			$inkindId = $this->obj_admin_settings->add_event_counter_modal($data_Counter2);
			
			if($this->input->post('event_active') == 1) {
				//UPDATING SEVA COUNTER ID
				$conditionOne = array('ET_RECEIPT_CATEGORY_ID !=' => 4);
				$dataOne = array('ET_ACTIVE_RECEIPT_COUNTER_ID' => $sevaId);
				$this->obj_admin_settings->edit_event_category_modal($conditionOne,$dataOne);
				
				//UPDATING INKIND COUNTER ID
				$conditionTwo = array('ET_RECEIPT_CATEGORY_ID' => 4);
				$dataTwo = array('ET_ACTIVE_RECEIPT_COUNTER_ID' => $inkindId);
				$this->obj_admin_settings->edit_event_category_modal($conditionTwo,$dataTwo);
			}
			
			redirect('/admin_settings/Admin_setting/events_setting/');
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
			$data = array('ET_SEVA_NAME' => $this->input->post('seva_name'),
						'ET_ID' => $this->input->post('event_Id'),
						'ET_SEVA_DESC' => $this->input->post('seva_desc'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'),
						'USER_ID' => $this->session->userdata('userId'),
						'ET_SEVA_ACTIVE' => $this->input->post('seva_active'),
						'ET_SEVA_QUANTITY_CHECKER' => $qtyChecker,
						'IS_SEVA' => $this->input->post('OptRadio'),
						'IS_TOKEN' => $isToken,
						'RESTRICT_DATE' => $restrictDate);
						
			$this->obj_admin_settings->add_event_seva_modal($data);
			
			//Getting Latest Inserted Seva Id
			$event_seva = $this->obj_admin_settings->get_all_field_event_seva_latest();
			
			//Adding To Event Seva Price Table
			$data_One = array('ET_SEVA_PRICE_ACTIVE' => 1,
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'),
						'USER_ID' => $this->session->userdata('userId'), 
						'ET_ID' => $this->input->post('event_Id'),
						'ET_SEVA_ID' => $event_seva->ET_SEVA_ID,
						'ET_SEVA_PRICE' => $this->input->post('seva_price'));
						
			$this->obj_admin_settings->add_event_seva_price_modal($data_One);
			redirect($_SESSION['actual_link']);
		}
		
		//UPDATE EVENT
		function update_event($id) {
			if($this->input->post('event_active') == 1) {
				$condition = array('ET_ACTIVE' => 1, 'ET_ID !=' => $id); 
				$events = $this->obj_admin_settings->get_all_field_event_activate($condition);
				if($events > 0) {
					$this->session->set_userdata('msg', 'An event is already active. Please set '.$events[0]->ET_NAME.' event deactive to save event details.');
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
			
			$data = array('ET_NAME' => $this->input->post('event_name'),
					'ET_FROM_DATE_TIME' => $this->input->post('todayDateFrom'),
					'ET_TO_DATE_TIME' => $this->input->post('todayDateTo'),
					'DATE_TIME' => date('d-m-Y H:i:s A'),
					'DATE' => date('d-m-Y'),
					'COMP_ID'=>$this->input->post('CommitteeId'),
					'USER_ID' => $this->session->userdata('userId'),
					'ET_ACTIVE' => $this->input->post('event_active'));
			
			$condition = array('ET_ID' => $id); 
			$this->obj_admin_settings->edit_event_modal($condition,$data);
			
			if($this->input->post('event_active') == 0) {
				$receipt_category = $this->obj_admin_settings->get_all_field_receipt_category();
				$dfMonth = $this->obj_admin_settings->get_financial_month();				
				$datMonth = $this->get_financial_year($dfMonth);
								
				if($datMonth == date('Y').' - '.(date('Y')+1)) {
					for($i = 0; $i < count($receipt_category); $i++) {
						$conditionCounter = array('ET_RECEIPT_COUNTER_ID' => $receipt_category[$i]->ET_ACTIVE_RECEIPT_COUNTER_ID);
						$dataCounter = array('ET_RECEIPT_COUNTER' => 0);
						$this->obj_admin_settings->get_update_receipt_counter($conditionCounter,$dataCounter);
					}
				}
			} else if($this->input->post('event_active') == 1) {
				$conditionSeva = array('EVENT_ID' => $id);
				$sevaId = $this->obj_admin_settings->get_event_receipt_counter($conditionSeva,'ET_RECEIPT_COUNTER_ID','asc');
				$conditionInkind = array('EVENT_ID' => $id);
				$inkindId = $this->obj_admin_settings->get_event_receipt_counter($conditionInkind,'ET_RECEIPT_COUNTER_ID','desc');
				
				//UPDATING SEVA COUNTER ID
				$conditionOne = array('ET_RECEIPT_CATEGORY_ID !=' => 4);
				$dataOne = array('ET_ACTIVE_RECEIPT_COUNTER_ID' => $sevaId->ET_RECEIPT_COUNTER_ID);
				$this->obj_admin_settings->edit_event_category_modal($conditionOne,$dataOne);
				
				//UPDATING INKIND COUNTER ID
				$conditionTwo = array('ET_RECEIPT_CATEGORY_ID' => 4);
				$dataTwo = array('ET_ACTIVE_RECEIPT_COUNTER_ID' => $inkindId->ET_RECEIPT_COUNTER_ID);
				$this->obj_admin_settings->edit_event_category_modal($conditionTwo,$dataTwo);
			}
			
			$dataEventHistory = array('ET_ID' => $id,
									  'ET_NAME' => $this->input->post('event_name'),
									  'ET_FROM' => $this->input->post('todayDateFrom'),
									  'ET_TO' => $this->input->post('todayDateTo'),
									  'DATE_TIME' => date('d-m-Y H:i:s A'),
									  'DATE' => date('d-m-Y'),
									  'COMP_ID'=>$this->input->post('CommitteeId'),
									  'USER_ID' => $this->session->userdata('userId'),
									  'ET_STATUS' => $this->input->post('event_active'));
			$this->obj_admin_settings->add_event_history_modal($dataEventHistory);
			
			$this->session->set_userdata('msg', 'Successfully updated');
			
			$condition = array('ET_ID' => $id);
			$data['admin_settings_events'] = $this->obj_admin_settings->get_all_field_event($condition);
			
			$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
			$query = $this->db->get();
			$_SESSION['eventActiveCount'] = $query->num_rows();

			$this->load->view('header',$data);           
			$this->load->view('admin_settings/edit_event');
			$this->load->view('footer_home');
		}
		
		//UPDATE SEVA EVENT STATUS
		function update_seva_event_status() {
			$data = array('ET_SEVA_ACTIVE' => $_POST['status']);
			$condition = array('ET_SEVA_ID' => $_POST['id']); 
			$this->obj_admin_settings->edit_event_seva_modal($condition,$data);
			echo "Success";
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
			$condition =  array('ET_SEVA_ID' => $sevaId); 
			
			//Adding To Event Seva Table
			$data = array('ET_SEVA_NAME' => $this->input->post('seva_name'),
						'ET_ID' => $this->input->post('event_Id'),
						'ET_SEVA_DESC' => $this->input->post('seva_desc'),
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'),
						'USER_ID' => $this->session->userdata('userId'),
						'ET_SEVA_ACTIVE' => $this->input->post('seva_active'),
						'ET_SEVA_QUANTITY_CHECKER' => $qtyChecker,
						'IS_SEVA' => $this->input->post('OptRadio'),
						'IS_TOKEN' => $isToken,
						'RESTRICT_DATE' => $restrictDate);
						
			$this->obj_admin_settings->edit_event_seva_modal($condition,$data);
			
			if(($this->input->post('price')) != ($this->input->post('seva_price'))) {
			$data_One = array('ET_SEVA_PRICE_ACTIVE' => 0);
			$conditionOne = array('ET_SEVA_ID'=> $sevaId);
			$this->obj_admin_settings->edit_event_seva_price_modal($conditionOne,$data_One);
				
			//Adding To Event Seva Price Table
			$data_Two = array('ET_SEVA_PRICE_ACTIVE' => 1,
						'DATE_TIME' => date('d-m-Y H:i:s A'),
						'DATE' => date('d-m-Y'),
						'USER_ID' => $this->session->userdata('userId'),
						'ET_ID' => $this->input->post('event_Id'),
						'ET_SEVA_ID' => $sevaId,
						'ET_SEVA_PRICE' => $this->input->post('seva_price'));
							
			$this->obj_admin_settings->add_event_seva_price_modal($data_Two);
			} else {
				$data_Three = array('ET_SEVA_PRICE' => $this->input->post('seva_price'));
				$conditionThree = array('ET_SEVA_PRICE_ID'=> $this->input->post('price_id'));
				$this->obj_admin_settings->edit_event_seva_price_modal($conditionThree,$data_Three);
			}
			
			redirect($_SESSION['actual_link']);
		}
		
		//DISPLAY LIMIT AND Stock
		function get_limit_details($id) {
			$condition = array('EVENT_SEVA.ET_SEVA_ID' => $id); 
			$sevaDetails = $this->obj_admin_settings->get_all_field_event_seva($condition);
			
			$conditionOne = array('EVENT_SEVA.ET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_all_field_event_seva($conditionOne,'ET_SEVA_NAME');
			
			$conditionThree = array('EVENT_SEVA_LIMIT.ET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_all_field_limits($conditionThree, 'ET_SL_ID');
			
			$conditionFour = array('ET_SO_SEVA_ID' => $id, 'ET_SO_IS_SEVA' => $sevaDetails[0]->IS_SEVA);
			$data['laddu_sold'] = $this->obj_admin_settings->get_laddu_stock_sold($conditionFour);
			
			$conditionFive = array('ET_SEVA_ID' => $id, 'ET_IS_SEVA' => $sevaDetails[0]->IS_SEVA);
			$data['laddu_available'] = $this->obj_admin_settings->get_laddu_stock_available($conditionFive);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/limit_details');
			$this->load->view('footer_home');
		}
		
		//GET TOTAL COUNT SEVA OFFERED
		function get_count_seva_offered() {
			$seva = explode('¶', $this->input->post('sevaid'));
			$sevaId = $seva[1];
			$date = $this->input->post('date');
			$condition = array('ET_SO_SEVA_ID' => $sevaId, 'ET_SO_DATE' => $date);
			$count = $this->obj_admin_settings->get_fields_offered($condition);
			echo $count;
		}
		
		//GET TOTAL COUNT SEVA OFFERED
		function get_count_seva_offered_stock() {
			$seva = explode('¶', $this->input->post('sevaid'));
			$sevaId = $seva[1];
			$condition = array('ET_SO_SEVA_ID' => $sevaId);
			$count = $this->obj_admin_settings->get_fields_offered($condition);
			echo $count;
		}
		
		//GET TOTAL COUNT SEVA OFFERED
		function get_count_seva_offered_main() {
			$seva = $this->input->post('sevaid');
			$date = $this->input->post('date');
			$condition = array('ET_SO_SEVA_ID' => $seva, 'ET_SO_DATE' => $date);
			$count = $this->obj_admin_settings->get_fields_offered($condition);
			echo $count;
		}
		
		//EDIT STOCK
		function get_remove_stock() {
			$subStock = $this->input->post('Stock');
			$sevas = explode('¶', $this->input->post('seva_id'));
			
			$condition = array('ET_SEVA_ID' => $sevas[1], 'ET_IS_SEVA' => $sevas[0]);
			$avlStock = $this->obj_admin_settings->get_stock_available($condition);
			
			for($i = 0; $i < count($avlStock); $i++) {
				if($subStock == $avlStock[$i]->ET_SEVA_LIMIT) {
					$condition = array('ET_SL_ID' => $avlStock[$i]->ET_SL_ID);
					$this->obj_admin_settings->get_delete_seva_stock($condition);
					redirect('/admin_settings/Admin_setting/get_limit_details/'.$sevas[1]);
					return;
				} else if($subStock < $avlStock[$i]->ET_SEVA_LIMIT) {
					$stock = (int)($avlStock[$i]->ET_SEVA_LIMIT) - (int)($subStock);
					$data = array('ET_SEVA_LIMIT' => $stock);
					$conditionOne = array('ET_SL_ID' => $avlStock[$i]->ET_SL_ID);
					$this->obj_admin_settings->get_update_seva_stock($conditionOne,$data);
					redirect('/admin_settings/Admin_setting/get_limit_details/'.$sevas[1]);
					return;
				} else if($subStock > $avlStock[$i]->ET_SEVA_LIMIT) {
					$subStock = (int)($subStock) - (int)($avlStock[$i]->ET_SEVA_LIMIT);
					$condition = array('ET_SL_ID' => $avlStock[$i]->ET_SL_ID);
					$this->obj_admin_settings->get_delete_seva_stock($condition);
				}
			}
		}
		
		//ADD LIMIT AND STOCK
		function get_add_limit_stock($id) {
			$sevas = explode('¶', $this->input->post('seva_id'));
			if($id == 1) { //LIMIT
				$condition = array('EVENT_SEVA_LIMIT.ET_SEVA_ID'=> $sevas[1], 'ET_SEVA_DATE' => $this->input->post('todayDateFrom'));
				$Limits = $this->obj_admin_settings->get_field_limits($condition);
				if($Limits > 0) {
					$msg = 'A limit has been set for '.$Limits->ET_SEVA_NAME.' on '.$this->input->post('todayDateFrom');
					$this->session->set_userdata('msg', $msg);
					
					redirect('/admin_settings/Admin_setting/get_limit_details/'.$sevas[1]);
					return;
				}
				
				//Adding To Limit Table
				$data_Limit = array('ET_SEVA_ID' => $sevas[1],
							'DATE_TIME' => date('d-m-Y H:i:s A'),
							'DATE' => date('d-m-Y'),
							'ET_IS_SEVA' => $sevas[0],
							'ET_SEVA_DATE' => $this->input->post('todayDateFrom'),
							'USER_ID' => $this->session->userdata('userId'),
							'ET_SEVA_LIMIT' => $this->input->post('Limit'));
				$this->obj_admin_settings->add_limit_modal($data_Limit);			
			} else if($id = 2) { //STOCK
				//Adding To Limit Table
				$data_Stock = array('ET_SEVA_ID' => $sevas[1],
							'DATE_TIME' => date('d-m-Y H:i:s A'),
							'DATE' => date('d-m-Y'),
							'ET_IS_SEVA' => $sevas[0],
							'USER_ID' => $this->session->userdata('userId'),
							'ET_SEVA_LIMIT' => $this->input->post('Stock'));
				$this->obj_admin_settings->add_limit_modal($data_Stock);	
			}
			$msg = 'Successfully Added';
			$this->session->set_userdata('msg', $msg);
			redirect('/admin_settings/Admin_setting/get_limit_details/'.$sevas[1]);
		}
		
		//EDIT LIMIT
		function get_edit_limit() {
			$id = $this->input->post('id');
			
			$conditionOne = array('EVENT_SEVA.ET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_all_field_event_seva($conditionOne,'ET_SEVA_NAME');
			
			$conditionThree = array('EVENT_SEVA_LIMIT.ET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_all_field_limits($conditionThree, 'ET_SEVA_NAME');
			
			$data = array('ET_SEVA_LIMIT' => $this->input->post('sevalimit'));
			$condition = array('ET_SL_ID' => $id);
			$this->obj_admin_settings->edit_limit_modal($condition,$data);
			
			redirect('/admin_settings/Admin_setting/get_limit_details/'.$this->input->post('seva_id'));
		}
		
		//EDIT STOCK
		function get_edit_stock() {
			$id = $this->input->post('idST');
			
			$conditionOne = array('EVENT_SEVA.ET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_all_field_event_seva($conditionOne,'ET_SEVA_NAME');
			
			$conditionThree = array('EVENT_SEVA_LIMIT.ET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_all_field_limits($conditionThree, 'ET_SEVA_NAME');
			
			$data = array('ET_SEVA_LIMIT' => $this->input->post('sevastock'), 'DATE_TIME' => date('d-m-Y H:i:s A'), 'DATE' => date('d-m-Y'));
			$condition = array('ET_SL_ID' => $id);
			$this->obj_admin_settings->edit_limit_modal($condition,$data);
			
			redirect('/admin_settings/Admin_setting/get_limit_details/'.$this->input->post('seva_idST'));
		}
		
		//EDIT Limit
		function get_edit_limit_main() {
			$id = $this->input->post('id');
			
			$conditionOne = array('EVENT_SEVA.ET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_all_field_event_seva($conditionOne,'ET_SEVA_NAME');
			
			$conditionThree = array('EVENT_SEVA_LIMIT.ET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_all_field_limits($conditionThree, 'ET_SEVA_NAME');
			
			$data = array('ET_SEVA_LIMIT' => $this->input->post('sevalimit'));
			$condition = array('ET_SL_ID' => $id);
			$this->obj_admin_settings->edit_limit_modal($condition,$data);
			
			redirect('/admin_settings/Admin_setting/events_setting/');
		}
		
		//EDIT STOCK
		function get_edit_stock_main() {
			$id = $this->input->post('idST');
			
			$conditionOne = array('EVENT_SEVA.ET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva'] = $this->obj_admin_settings->get_all_field_event_seva($conditionOne,'ET_SEVA_NAME');
			
			$conditionThree = array('EVENT_SEVA_LIMIT.ET_SEVA_ID' => $id); 
			$data['admin_settings_event_seva_limit'] = $this->obj_admin_settings->get_all_field_limits($conditionThree, 'ET_SEVA_NAME');
			
			$data = array('ET_SEVA_LIMIT' => $this->input->post('sevastock'), 'DATE_TIME' => date('d-m-Y H:i:s A'), 'DATE' => date('d-m-Y'));
			$condition = array('ET_SL_ID' => $id);
			$this->obj_admin_settings->edit_limit_modal($condition,$data);
			
			redirect('/admin_settings/Admin_setting/events_setting/');
		}
		
		//POPUP SEVA DETAILS
		function deity_seva_details($id) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$condition = array('DEITY_ID' => $id);
			$data['deity'] = $this->obj_admin_settings->get_all_field_deity($condition); 
			
			$condition =array('SEVA_PRICE_ACTIVE' => 1, 'DEITY_SEVA.DEITY_ID' => $id);
			$data['admin_settings_seva'] = $this->obj_admin_settings->get_all_field_seva($condition);
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/deity_seva_details');
			$this->load->view('footer_home');
		}
		
		//GET ALL DEITY_SEVA_SETTING
		function deity_seva_setting() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			//$condition = array('SEVA_PRICE_ACTIVE' => 1);
			
			//$data['admin_settings_deity'] = $this->obj_admin_settings->get_all_field_deity_count($condition,'DEITY_SEVA.DEITY_ID');
			$data['admin_settings_deity'] = $this->obj_admin_settings->get_all_field_deity_count(); //$condition
			
			$condition_One =array('SEVA_PRICE_ACTIVE' => 1);
			$data['admin_settings_seva'] = $this->obj_admin_settings->get_all_field_seva($condition_One,'DEITY.DEITY_ID');
			if(isset($_SESSION['Deity_Seva_Settings'])) {
				$this->load->view('header', $data);           
				$this->load->view('admin_settings/deity_sevas_setting');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//ADD DEITY
		function add_deity() {
			$this->load->view('header');           
			$this->load->view('admin_settings/add_deity');
			$this->load->view('footer_home');
		}
		
		//SAVE DEITY
		function save_deity() {
			$data_array = array(
								'DEITY_NAME' => $this->input->post('deity_name'),
								'DEITY_ACTIVE' => $this->input->post('deity_active'),
								'DATE_TIME' => date('d-m-Y H:i:s A'),
								'DATE' => date('d-m-Y'),
								'USER_ID' => $this->session->userdata('userId')
							  );
								
			$this->obj_admin_settings->add_deity($data_array);	
			redirect('/admin_settings/Admin_setting/deity_seva_setting/');
		}
		
		
		//EDIT DEITY
		function edit_deity($id) {
			$condition = array('DEITY_ID' => $id);
			$data['deity'] = $this->obj_admin_settings->get_all_field_deity($condition);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/edit_deity');
			$this->load->view('footer_home');
		}
		
		//UPDATE DEITY
		function update_deity() {
			$data_array = array('DEITY_NAME' => $this->input->post('deity_name'),
						'DEITY_ACTIVE' => $this->input->post('deity_active'));
			$condition = array('DEITY_ID' => $this->input->post('deity_id'));
			$this->obj_admin_settings->edit_deity($condition,$data_array);	
			
			$data_history = array('DEITY_ID' => $this->input->post('deity_id'),
								  'DEITY_NAME' => $this->input->post('deity_name'),
								  'DEITY_STATUS' => $this->input->post('deity_active'),
								  'USER_ID' => $this->session->userdata('userId'),
								  'DATE_TIME' => date('d-m-Y H:i:s A'),
								  'DATE' => date('d-m-Y'));
			
			$this->obj_admin_settings->add_deity_history($data_history);	
			redirect('/admin_settings/Admin_setting/deity_seva_setting/');
		}
		
		//ADD SEVA
		function add_seva($deity_id) {
			$condition =array('DEITY_ACTIVE' => 1);
			$data['deity'] = $this->obj_admin_settings->get_all_field_deity($condition);
			$data['id'] = $deity_id;
			$data['edit'] = 1;
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/add_seva');
			$this->load->view('footer_home');
		}
		
		//ADD SEVA
		function add_seva_other() {
			$condition =array('DEITY_ACTIVE' => 1);
			$data['deity'] = $this->obj_admin_settings->get_all_field_deity($condition);
			$data['id'] = "";
			$data['edit'] = 0;
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/add_seva');
			$this->load->view('footer_home');
		}
		
		//SAVE DEITY SEVA
		function save_deity_seva() {
			if(isset($_POST['deity_name']))
				$deityId = $this->input->post('deity_name');
			else
				$deityId = $_POST['deityId'];
			
			//BOOKING CHECKBOX
			if(isset($_POST['booking'])) {
				$booking = 1;
			} else {
				$booking = 0;
			}
			
			//TOKEN CHECKBOX
			if(isset($_POST['token'])) {
				$token = 1;
			} else {
				$token = 0;
			}

			//EXCLUDE OR INCLUDE SHASHWATH SEVA FROM DEITY SEVA REPORT
			if(isset($_POST['Exclude'])) {
				$excludeOrInclude = "Exclude";
			} else {
				$excludeOrInclude = "Include";
			}

			if($this->input->post('OptRadios')!="Deity") {
				$minprice = $this->input->post('minprice');
			} else {
				$minprice = 0;
			}
			

			//SEVA DETAILS
			$data_array = array('SEVA_NAME' => $this->input->post('seva_name'),
								'DEITY_ID' => $deityId,
								'SEVA_DESC' => $this->input->post('seva_desc'),
								'SEVA_ACTIVE' => $this->input->post('seva_active'),
								'IS_SEVA' => $this->input->post('OptRadio'),
								'QUANTITY_CHECKER' => 1,
								'DATE_TIME' => date('d-m-Y H:i:s A'),
								'DATE' => date('d-m-Y'),
								'USER_ID' => $this->session->userdata('userId'),
								'BOOKING' => $booking,
								'IS_TOKEN' => $token,
								'SEVA_TYPE' => $this->input->post('seva_type'),
								'SEVA_BELONGSTO' => $this->input->post('OptRadios'),
								'SEVA_INCL_EXCL' => $excludeOrInclude
								);
			$this->obj_admin_settings->add_seva($data_array);	
			
			//GET LATEST SEVA
			$latestSeva = $this->obj_admin_settings->get_latest_seva();
			
			//CHECK BOX VALUE
			if(isset($_POST['revision'])) {
				$revision = 1;
				$price = $this->input->post('seva_price');
				$revDate = $this->input->post('todayDate');
				$sevaPrice = $this->input->post('price');
			} else {
				$revision = 0;
				$price = 0;
				$revDate = "";
				$sevaPrice = $this->input->post('seva_price');
			}
			
			if($revDate != "") {
				$rev_date = date($revDate);              
				$rev_date_timestamp = strtotime($rev_date);
				$new_date = date('Y-m-d H:i:s', $rev_date_timestamp);  
			} else {
				$new_date = '0000-00-00 00:00:00';
			}
			
			//SEVA_PRICE
			$data_seva = array(
							   'SEVA_ID' => $latestSeva[0]->SEVA_ID,
							   'SEVA_PRICE' => $sevaPrice,
							   'SEVA_PRICE_ACTIVE' => 1,
							   'DATE_TIME' => date('d-m-Y H:i:s A'),
							   'DATE' => date('d-m-Y'),
							   'USER_ID' => $this->session->userdata('userId'),
							   'DEITY_ID' => $deityId,
							   'OLD_PRICE' => $price,
							   'REVISION_DATE' => $revDate,
							   'R_DATE_TIME' => $new_date,
							   'REVISION_STATUS' => $revision,
							   'SHASH_PRICE' => $minprice
							   );
			
			$this->obj_admin_settings->add_seva_price($data_seva);
			redirect($_SESSION['actual_link']);
		}
		
		//EDIT SEVA
		function edit_seva($id) {
			$condition =array('DEITY_ACTIVE' => 1);
			$data['deity'] = $this->obj_admin_settings->get_all_field_deity($condition);
			
			$condition = array('DEITY_SEVA.SEVA_ID' => $id, 'DEITY_SEVA_PRICE.SEVA_PRICE_ACTIVE' => 1);
			$data['deity_seva'] = $this->obj_admin_settings->get_all_field_seva($condition);
			
			$this->load->view('header',$data);           
			$this->load->view('admin_settings/edit_seva');
			$this->load->view('footer_home');
		}
		
		function checkForSeva(){
			$seva_id = $this->input->post('seva_id');
			$sql="SELECT  * from shashwath_seva where SEVA_ID = $seva_id";
			$query = $this->db->query($sql);
			echo $query->num_rows();
		}
		
		//UPDATE SEVA
		function update_deity_seva() {
			//BOOKING CHECKBOX
			if(isset($_POST['booking'])) {
				$booking = 1;
			} else {
				$booking = 0;
			}
			
			//TOKEN CHECKBOX
			if(isset($_POST['token'])) {
				$token = 1;
			} else {
				$token = 0;
			}

			//EXCLUDE OR INCLUDE SHASHWATH SEVA FROM DEITY SEVA REPORT
			if($this->input->post('OptRadios')=="Deity"){
				$excludeOrInclude = "Include";
			} else{
				if(isset($_POST['Exclude'])) {
					$excludeOrInclude = "Exclude";
				} else {
					$excludeOrInclude = "Include";
				}
			}

			if($this->input->post('OptRadios')!="Deity") {
				$minprice = $this->input->post('minprice');
			} else {
				$minprice = 0;
			}
			//SEVA DETAILS
			$condition = array('SEVA_ID' => $this->input->post('seva_id'));
			$data_array = array(
								'SEVA_NAME' => $this->input->post('seva_name'),
								'DEITY_ID' => $this->input->post('deity_id'),
								'SEVA_DESC' => $this->input->post('seva_desc'),
								'SEVA_ACTIVE' => $this->input->post('seva_active'),
								'IS_SEVA' => $this->input->post('OptRadio'),
								'QUANTITY_CHECKER' => 1,
								'DATE_TIME' => date('d-m-Y H:i:s A'),
								'DATE' => date('d-m-Y'),
								'USER_ID' => $this->session->userdata('userId'),
								'BOOKING' => $booking,
								'IS_TOKEN' => $token,
								'SEVA_TYPE' => $this->input->post('seva_type'),
								'SEVA_BELONGSTO' => $this->input->post('OptRadios'),
								'SEVA_INCL_EXCL' => $excludeOrInclude
								);
			
			$this->obj_admin_settings->edit_seva($condition,$data_array);
			
			//CHECK BOX VALUE
			if(isset($_POST['revision'])) {
				$revision = 1;
				$revDate = $this->input->post('todayDate');
				$price = $this->input->post('seva_price');
				$sevaPrice = $this->input->post('revprice');
			} else {
				$revision = 0;
				$revDate = "";
				$price = 0;
				$sevaPrice = $this->input->post('seva_price');
			}
			
			if($revDate != "") {
				$rev_date = date($revDate);              
				$rev_date_timestamp = strtotime($rev_date);
				$new_date = date('Y-m-d H:i:s', $rev_date_timestamp);  
			} else {
				$new_date = '0000-00-00 00:00:00';
			}

			
			//SEVA_PRICE
			if(($this->input->post('price')) != ($this->input->post('seva_price')) || ($this->input->post('revprice')) != ($this->input->post('oldprice')) || ($this->input->post('todayDate')) != ($this->input->post('olddate')) || ($this->input->post('revision')) != ($this->input->post('oldStatus'))) {
				$data_One = array('SEVA_PRICE_ACTIVE' => 0, 'REVISION_STATUS' => 0);
				$conditionOne = array('SEVA_ID'=> $this->input->post('seva_id'));
				$this->obj_admin_settings->edit_seva_price($conditionOne,$data_One);
				
				//SEVA_PRICE
				$data_seva = array('SEVA_ID' => $this->input->post('seva_id'),
								   'SEVA_PRICE' => $sevaPrice,
								   'SEVA_PRICE_ACTIVE' => 1,
								   'DATE_TIME' => date('d-m-Y H:i:s A'),
								   'DATE' => date('d-m-Y'),
								   'USER_ID' => $this->session->userdata('userId'),
								   'DEITY_ID' => $this->input->post('deity_id'),
								   'OLD_PRICE' => $price,
								   'REVISION_DATE' => $revDate,
								   'R_DATE_TIME' => $new_date,
								   'REVISION_STATUS' => $revision,
								   'SHASH_PRICE' => $minprice);
				
				$this->obj_admin_settings->add_seva_price($data_seva);
			} else {
				$conditionThree = array('SEVA_ID' => $this->input->post('seva_id'),'SEVA_PRICE_ACTIVE' => 1);
				$dataTwo = array('SEVA_PRICE' => $sevaPrice);
				$this->obj_admin_settings->edit_seva_price($conditionThree,$dataTwo);
			}
			
			redirect($_SESSION['actual_link']);
		}
		
		//UPDATE SEVA STATUS
		function update_seva_status() {
			$data = array('SEVA_ACTIVE' => $_POST['status']);
			$condition = array('SEVA_ID' => $_POST['id']); 
			$this->obj_admin_settings->edit_seva($condition,$data);
			echo "Success";
		}
		
		public function searchDonation($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
						
			if(@$_POST['name']) {
				unset($_SESSION['name']);
				$data['date'] = $this->input->post('name');
				$name = $this->input->post('name');
			}
			
			if(@$_SESSION['name'] == "") {
				$this->session->set_userdata('name', $this->input->post('name'));
				$data['name'] = $_SESSION['name'];
				$name = $this->input->post('name');
			} else {
				$name = $_SESSION['name'];
				$data['name'] = $_SESSION['name'];
			}
			
			//pagination
			$condition = array('ET_RECEIPT_NAME' => $name);
			$data['donation'] = $this->obj_admin_settings->get_all_field_donation_like($condition, 'ET_RECEIPT_ID', 'desc', 10,$start);
			
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_setting/searchDonation';
			$config['total_rows']= $this->obj_admin_settings->count_rows_donation($condition, 'ET_RECEIPT_ID', 'desc');
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
			$this->load->view('header', $data);           
			$this->load->view('donation_kanike_details');
			$this->load->view('footer_home');
		}
		
		//UPDATE DONATION
		function update_donation() {
			$data = array('ET_RECEIPT_NAME' => $this->input->post('name'));
			$condition = array('ET_RECEIPT_ID' => $this->input->post('id'));
			$this->obj_admin_settings->edit_donation_modal($condition,$data);
			
			redirect('/admin_settings/Admin_setting/donation_kanike_details/');
		}
		
		//EDIT DONATION
		function edit_donation($id) {
			$condition = array('ET_RECEIPT_ID' => $id);
			$data['edit_donation'] = $this->obj_admin_settings->get_all_field_single_donation($condition);
			
			$this->load->view('header', $data);           
			$this->load->view('admin_settings/edit_donation');
			$this->load->view('footer_home');
		}
		
		//DISPLAY DONATION KANIKE DETAILS
		function donation_kanike_details($start = 0) {
			unset($_SESSION['name']);
			$condition = array('ET_RECEIPT_CATEGORY_ID' => 2,'ET_RECEIPT_ACTIVE'=>1);
			$data['donation'] = $this->obj_admin_settings->get_all_field_donation($condition, 'ET_RECEIPT_ID', 'desc', 10,$start);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_settings/Admin_setting/donation_kanike_details';
			$config['total_rows'] = $this->obj_admin_settings->count_rows_donation($condition, 'ET_RECEIPT_ID', 'desc');
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
			
			if(isset($_SESSION['Change_Donation/Kanike'])) {
				$this->load->view('header', $data);           
				$this->load->view('donation_kanike_details');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//DAILY BACKUP
		function backup() {
			
			$connect = new PDO("mysql:host=localhost;dbname=pinnac23_SLVT", "root", "kj1LjQbOhtafIOOD");
			$get_all_table_query = "SHOW TABLES";
			$statement = $connect->prepare($get_all_table_query);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_NUM);
			
			$output = '';
			foreach($result as $table)
			{
				$show_table_query = "SHOW CREATE TABLE " . $table[0] . "";
				$statement = $connect->prepare($show_table_query);
				$statement->execute();
				$show_table_result = $statement->fetchAll();

				foreach($show_table_result as $show_table_row)
				{
					$output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
				}
				
				$show_table_query = "DESCRIBE " . $table[0] . "";
				$statement = $connect->prepare($show_table_query);
				$statement->execute();
				$describe_result = $statement->fetchAll(PDO::FETCH_ASSOC);
						
				$select_query = "SELECT * FROM " . $table[0] . "";
				$statement = $connect->prepare($select_query);
				$statement->execute();
				$total_row = $statement->rowCount();

				for($count=0; $count<$total_row; $count++)
				{
					$single_result = $statement->fetch(PDO::FETCH_ASSOC);
					$table_column_array = array_keys($single_result);
					$table_value_array = array_values($single_result);
					$table_value_array = explode("$",addslashes(implode("$",$table_value_array)));
					
					if($count == 0) {
						$output .= "\nINSERT INTO $table[0] (". implode(", ", $table_column_array) . ") VALUES";
					}
					
					$total_fCount = count($table_value_array);
					$fieldCount = 0;
								
					$output .= "\n(";
					foreach($describe_result as $describe_result_row) {
						//print_r($describe_result_row["Type"]);
						if(explode("(",$describe_result_row["Type"])[0] == "bigint" || explode("(",$describe_result_row["Type"])[0] == "int") {
							$value = $table_value_array[$fieldCount];
							if(empty($value) && $describe_result_row["Null"] == 'YES')
								$output .= (($fieldCount==0)?"":", ") . 'NULL';
							else
								$output .= (($fieldCount==0)?"":", ") . $value;
						} 
						else if(explode("(",$describe_result_row["Type"])[0] == "varchar" || explode("(",$describe_result_row["Type"])[0] == "date" || explode("(",$describe_result_row["Type"])[0] == "mediumtext" || explode("(",$describe_result_row["Type"])[0] == "datetime") {
							$value = $table_value_array[$fieldCount];
							if(empty($value) && $describe_result_row["Null"] == 'YES')
								$output .= (($fieldCount==0)?"":", ") . 'NULL';
							else
								$output .= (($fieldCount==0)?"":", ") . "'" . $value . "'";
						}
						$fieldCount++;	
					}
					$output .= (($count == $total_row-1)?")":"),");
				}
				
				$output .= ";";
			}
			date_default_timezone_set('Asia/Kolkata'); 
			
			// PHP program to delete all  file from a folder
			// Folder path to be flushed 
			$folder_path = "C://xampp//htdocs//manualphp"; 
			// List of name of files inside specified folder
			$files = glob($folder_path.'/*');  
			   
			// Deleting all the files in the list 
			foreach($files as $file) { 
			   if(is_file($file))  
			    	 // Delete the given file 
			        unlink($file);  
			} 

			// Store the cipher method 
			$ciphering = "AES-128-CTR"; 
			  
			// Use OpenSSl Encryption method 
			$iv_length = openssl_cipher_iv_length($ciphering); 
			$options = 0; 
			  
			// Non-NULL Initialization Vector for encryption 
			$encryption_iv = '1234567891011121'; 
			  
			// Store the encryption key 
			$encryption_key = "eX4cB1uQ7pI6rY6p"; 
			  
			// Use openssl_encrypt() function to encrypt the data 
			$encryption = openssl_encrypt($output, $ciphering, 
			            $encryption_key, $options, $encryption_iv); 

			date_default_timezone_set('Asia/Kolkata'); 
			$backup_file_name = 'pinnac23_SLVT_' . date('d_m_Y__H_i_s_A') . '.sql';
			$backup_file_zip = 'pinnac23_SLVT_' . date('d-m-Y__H_i_s_A') . '.zip';

		    $file_handle = fopen("C://xampp//htdocs//manualphp//".$backup_file_name, 'w+');
			fwrite($file_handle, $encryption);
			fclose($file_handle);
			ob_clean();
		    flush();		    

		    /*// Non-NULL Initialization Vector for decryption 
			$decryption_iv = '1234567891011121'; 
			  
			// Store the decryption key 
			$decryption_key = "eX4cB1uQ7pI6rY6p"; 

			$content = file_get_contents("C:/xampp/htdocs/manualphp/".$backup_file_name);
			  
			// Use openssl_decrypt() function to decrypt the data 
			$decryption = openssl_decrypt ($content, $ciphering,  
			        $decryption_key, $options, $decryption_iv); 

			$decrypted_file_name = 'pinnac23_SLVT_1' . date('d_m_Y__H_i_s_A') . '.sql';
			$file_handle = fopen("C://xampp//htdocs//manualphp//".$decrypted_file_name, 'w+');
			fwrite($file_handle, $decryption);
			fclose($file_handle);
		    ob_clean();
		    flush();*/		

		    //Zip sql file 
		    //create the archive
			$zip = new ZipArchive();
			if($zip->open("C:/xampp/htdocs/manualphp/".$backup_file_zip, ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
			
			$zip->addFile("C:/xampp/htdocs/manualphp/".$backup_file_name, $backup_file_name);

			//close the zip -- done!
			$zip->close();

		   echo "success|"."http://192.168.2.130/manualphp/".$backup_file_zip; 
			   
		}
	}

?>

