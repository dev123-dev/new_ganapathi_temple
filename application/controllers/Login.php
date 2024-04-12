<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model','user',true); 	
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		$this->load->helper('date');
		$this->load->model('Events_modal','obj_events',true);
		$this->load->model('EventEOD_modal','event_obj_eod',true);
		$this->load->model('Postage_model','obj_postage',true);
		$this->load->model('EventPostage_model','obj_event_postage',true);
		$this->load->model('Shashwath_model','obj_shashwath',true);
		$this->load->model('TrustEventPostage_model','obj_event_trust_postage',true);
		$this->load->model('finance_model','obj_finance',true);
		$this->load->model('TrustEOD_modal','obj_trust_eod',true);
		$this->load->model('trust_finance_model','obj_trust_finance',true);  
		$this->load->model('EOD_modal','obj_eod',true);
		$this->load->model('TrustEventEOD_modal','Trust_Event_obj_eod',true);

		date_default_timezone_set('Asia/Kolkata');

		$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
		
		if(isset($_SESSION['userId']))
			redirect('home');
	}
	
	public function index(){
		$this->load->view('header_home');
		$this->load->view('login');
		$this->load->view('footer_home');
	}
	
	function checkForUser() {
	   $data['error'] = 0;
		
		if($_POST)	{
			$username = $this->input->post('username', true);
			$password1 = $this->input->post('password', true);
			$salt = sha1($password1);
			$password = md5($salt . $password1);
			$user = $this->user->login($username, $password);
		
			if(!$user) {
				$data['error'] = 1;
				echo "failed"; 
			} else {
				//UPDATE REVISION DATA WHICH IS LESS THAN TODAY'S DATE
				$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
				$RDateTime = $date->format('Y-m-d H:i:s');
				$condition = array('REVISION_STATUS' => 1, 'R_DATE_TIME <=' => $RDateTime);
				$data_array = array('REVISION_STATUS' => 0);
				$this->obj_admin_settings->edit_revision_data($condition,$data_array);
				
				$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
				
				$this->session->set_userdata('userId',$user['USER_ID']);
				$this->session->set_userdata('userType',$user['USER_TYPE']);
				$this->session->set_userdata('userName',$user['USER_LOGIN_NAME']);
				$this->session->set_userdata('userFullName',$user['USER_FULL_NAME']);
				$this->session->set_userdata('userGroup',$user['USER_GROUP']);
				$_SESSION['time'] = $this->obj_admin_settings->get_time();
				$browserType = $_SERVER['HTTP_USER_AGENT'];

				$this->load->library('user_agent');
                /*When the User Agent class is initialized it will attempt to determine whether the user agent browsing your site 
				is a web browser, a mobile device, or a robot.It will also gather the platform information if it is available*/
				if ($this->agent->is_browser()) {
					$agent = $this->agent->browser().''.$this->agent->version();
				} elseif ($this->agent->is_robot()) {
					$agent = $this->agent->robot();
				} elseif ($this->agent->is_mobile()) {
					$agent = $this->agent->mobile();
				} else {
					$agent = 'Unidentified User Agent';
				}

				$platform = $this->agent->platform();
				$deviceIP = $this->input->ip_address();		
				$trustLogin = $_POST['trustLogin'];

				$_SESSION['trustLogin'] = $trustLogin;
				
				//insert userAgent
				$loggedIN = date('Y-m-d H:i:s');
				$datas = array ('USER_ID' => $_SESSION['userId'],
					'LOGIN_TIME' => $loggedIN,
					'LOGIN_DEVICE_DETAILS' => $agent,
					'PLATFORM' => $platform,
					'LOGOUT_TIME' => "",
					'DEVICE_IP' => $deviceIP
				);
				
				$this->db->insert('USER_LOGINS', $datas);
				$this->session->set_userdata('loggedHistory', $this->db->insert_id());
				
				//resetting the counters 
				$fMonth = $this->obj_admin_settings->get_financial_month();
				$dt = date('d-m-Y');
				$yr = date('Y');
				$mnth = date('m');
				if((sprintf("%02d", $fMonth->MONTH_IN_NUMBER)) == $mnth && $fMonth->MONTH_IN_YEAR < ($yr+1)) {
					$data = array('MONTH_IN_YEAR' => ($yr+1));
					$this->obj_admin_settings->update_financial_month($data);
					
					$dataDeity = array('RECEIPT_COUNTER' => 0);
					$condition = array('RECEIPT_COUNTER_ID !=' => 3);
					$this->obj_admin_settings->update_reset_deity($condition,$dataDeity);
					
					$dataEvent = array('ET_RECEIPT_COUNTER' => 0);
					$this->obj_admin_settings->update_reset_event($dataEvent);
					
					$dataTrustHead = array('RECEIPT_COUNTER' => 0);
					$this->obj_admin_settings->get_trust_update_financial_head_receipt_counter($condition= '',$dataTrustHead);
					
					$dataTrustEvent = array('TET_RECEIPT_COUNTER' => 0);
					$this->obj_admin_settings->get_trust_update_receipt_counter($condition='',$dataTrustEvent);

					$dataFinanceVoucher = array('FVC_COUNTER' => 0);
					$this->obj_admin_settings->update_reset_finance_voucher($dataFinanceVoucher);

					//RESETTING NO_OF_SEVAS WHERE CAL_TYPE = EVERY
					$maxYear = $this->obj_shashwath->getfinyear();
					$startDate = new DateTime($yr.'-04-01');
					$endDate = new DateTime($maxYear.'-03-31');
					$weekcode=['Sunday','Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
					for($i=0;$i<count($weekcode);$i++){
						$countNOTE = 0;
						$startDate = new DateTime($yr.'-04-01');
						$endDate = new DateTime($maxYear.'-03-31');
						while ($startDate <= $endDate) {
						    if ($startDate->format('l') == $weekcode[$i]) {
						        $countNOTE++;
						    }
						    $startDate->modify('+1 day');
						}
						$sql="UPDATE `shashwath_seva` SET NO_OF_SEVAS= $countNOTE,SEVA_GEN_COUNTER= $countNOTE WHERE CAL_TYPE ='Every' and EVERY_WEEK_MONTH='$weekcode[$i]'";
						$this->db->query($sql);
					}

					$calMonth=['First_','Second_','Third_', 'Fourth_', 'Last_'];
					$calYear=['_First_','_Second_','_Third_', '_Fourth_', '_Last_'];
					for($i=0;$i<count($calMonth);$i++){
						$sql="UPDATE `shashwath_seva` SET NO_OF_SEVAS= 12,SEVA_GEN_COUNTER= 12 WHERE CAL_TYPE ='Every' and EVERY_WEEK_MONTH LIKE '$calMonth[$i]%'";
						$this->db->query($sql);
					}
					for($i=0;$i<count($calYear);$i++){
						$sql="UPDATE `shashwath_seva` SET NO_OF_SEVAS= 1,SEVA_GEN_COUNTER= 1 WHERE CAL_TYPE ='Every' and EVERY_WEEK_MONTH LIKE '%$calYear[$i]%'";
						$this->db->query($sql);
					}
					//END EVERY
				}
				
				
				if($trustLogin == 1) {
					$groupRight = array('GROUP_ID' => $user['USER_GROUP']);
					$grpRights = $this->obj_admin_settings->get_grouptrustright_available($groupRight,'TR_ID','asc');
					if($grpRights != 0) {
						for($i = 0; $i < count($grpRights); $i++) {
							if($grpRights[$i]->TR_ID == 1) {
								$this->session->set_userdata('Add', 'Add_Right');
							} else if($grpRights[$i]->TR_ID == 2) { 
								$this->session->set_userdata('Edit', 'Edit_Right');
							} else if($grpRights[$i]->TR_ID == 3) {
								$this->session->set_userdata('Active_Deactive', 'ActDct_Right');
							} else if($grpRights[$i]->TR_ID == 4) {
								$this->session->set_userdata('Authorise', 'Auth_Right');
							} else if($grpRights[$i]->TR_ID == 5) {
								$this->session->set_userdata('Notification', 'Notif_Right');
							}
						}
					}
				} else {
					$groupRight = array('GROUP_ID' => $user['USER_GROUP']);
					$grpRights = $this->obj_admin_settings->get_groupright_available($groupRight,'R_ID','asc');
					if($grpRights != 0) {
						for($i = 0; $i < count($grpRights); $i++) {
							if($grpRights[$i]->R_ID == 1) {
								$this->session->set_userdata('Add', 'Add_Right');
							} else if($grpRights[$i]->R_ID == 2) { 
								$this->session->set_userdata('Edit', 'Edit_Right');
							} else if($grpRights[$i]->R_ID == 3) {
								$this->session->set_userdata('Active_Deactive', 'ActDct_Right');
							} else if($grpRights[$i]->R_ID == 4) {
								$this->session->set_userdata('Authorise', 'Auth_Right');
							} else if($grpRights[$i]->R_ID == 5) {
								$this->session->set_userdata('Notification', 'Notif_Right');
							}
						}
					}
				}
				
				if($trustLogin == 1) {
					$menuRight = array('GROUP_ID' => $user['USER_GROUP'], 'STATUS' => 1);
					$menuRight = $this->obj_admin_settings->get_group_trust_menu_right_available($menuRight,'GTM_ID','asc');
					
					if($menuRight != 0) {
						$seva = "Trust/homePageTrust";
						for($j = 0; $j < count($menuRight); $j++) { 
							if($menuRight[$j]->TP_ID == 1) {
								$this->session->set_userdata('Users_Settings', 'Users Settings');
							} else if($menuRight[$j]->TP_ID == 2) {
								$this->session->set_userdata('Group_Settings', 'Group Settings');
							} else if($menuRight[$j]->TP_ID == 3) {
								$this->session->set_userdata('Hall_Settings', 'Hall Settings');
							} else if($menuRight[$j]->TP_ID == 4) {
								$this->session->set_userdata('Book_Hall', 'Book Hall');
							} else if($menuRight[$j]->TP_ID == 5) {
								$this->session->set_userdata('All_Hall_Bookings', 'All Hall Bookings');
								$seva = "Trust";
							} else if($menuRight[$j]->TP_ID == 6) {
								$this->session->set_userdata('All_Trust_Receipt', 'All Trust Receipt');
							} else if($menuRight[$j]->TP_ID == 7) {
								$this->session->set_userdata('New_Trust_Receipt', 'New Trust Receipt');
							} else if($menuRight[$j]->TP_ID == 8) {
								$this->session->set_userdata('Block_Date_Settings', 'Block Date Settings');
							} else if($menuRight[$j]->TP_ID == 9) {
								$this->session->set_userdata('Trust_Receipt_Report', 'Trust Receipt Report');
							} else if($menuRight[$j]->TP_ID == 10) {
								$this->session->set_userdata('Trust_MIS_Report', 'Trust MIS Report');
							} else if($menuRight[$j]->TP_ID == 11) {
								$this->session->set_userdata('E.O.D_Report', 'E.O.D Report');
							} else if($menuRight[$j]->TP_ID == 12) {
								$this->session->set_userdata('E.O.D_Tally_Trust', 'E.O.D Tally');
							} else if($menuRight[$j]->TP_ID == 13) {
								$this->session->set_userdata('Bank_Settings', 'Bank Settings');
							} else if($menuRight[$j]->TP_ID == 14) {
								$this->session->set_userdata('Hall_Bookings_Report', 'Hall Bookings Report');
							} else if($menuRight[$j]->TP_ID == 15) {
								$this->session->set_userdata('Check_Remmittance', 'Cheque Remmittance');
							} else if($menuRight[$j]->TP_ID == 16) {
								$this->session->set_userdata('Event_Seva_Settings', 'Event Seva Settings');
							} else if($menuRight[$j]->TP_ID == 17) {
								$this->session->set_userdata('Cheque_Remmittance', 'Event Cheque Remmittance');
							} else if($menuRight[$j]->TP_ID == 18) {
								$this->session->set_userdata('Receipt_Settings', 'Receipt Settings');
							} else if($menuRight[$j]->TP_ID == 19) {
								$this->session->set_userdata('Inkind_Items', 'Inkind Items');
							} else if($menuRight[$j]->TP_ID == 20) {
								$this->session->set_userdata('Event_Sevas', 'Event Sevas');
								$seva = "TrustEvents";
							} else if($menuRight[$j]->TP_ID == 21) {
								$this->session->set_userdata('All_Event_Receipt', 'All Event Receipt');
							} else if($menuRight[$j]->TP_ID == 22) {
								$this->session->set_userdata('Event_Seva', 'Event Seva');
							} else if($menuRight[$j]->TP_ID == 23) {
								$this->session->set_userdata('Event_Donation/Kanike', 'Event Donation/Kanike');
							} else if($menuRight[$j]->TP_ID == 24) {
								$this->session->set_userdata('Deity/Event_Hundi', 'Event Hundi');
							} else if($menuRight[$j]->TP_ID == 25) {
								$this->session->set_userdata('Deity/Event_Inkind', 'Event Inkind');
							} else if($menuRight[$j]->TP_ID == 26) {
								$this->session->set_userdata('Current_Event_Receipt_Report', 'Current Event Receipt Report');
							} else if($menuRight[$j]->TP_ID == 27) {
								$this->session->set_userdata('Current_Event_Seva_Report', 'Current Event Seva Report');
							} else if($menuRight[$j]->TP_ID == 28) {
								$this->session->set_userdata('Current_Event_MIS_Report', 'Current Event MIS Report');
							} else if($menuRight[$j]->TP_ID == 29) {
								$this->session->set_userdata('User_Event_Collection_Report', 'User Event Collection Report');
							} else if($menuRight[$j]->TP_ID == 30) {
								$this->session->set_userdata('Event_E.O.D_Report', 'Event E.O.D. Report');
							} else if($menuRight[$j]->TP_ID == 31) {
								$this->session->set_userdata('Event_E.O.D_Tally', 'Event E.O.D. Tally');
							} else if($menuRight[$j]->TP_ID == 32) {
								$this->session->set_userdata('Trust_Day_Book', 'Trust Day Book');
							} else if($menuRight[$j]->TP_ID == 33) {
								$this->session->set_userdata('Trust_Event_Token', 'Trust Event Token');
							} else if($menuRight[$j]->TP_ID == 34) {
								$this->session->set_userdata('Function_Types', 'Function Types');
							} else if($menuRight[$j]->TP_ID == 35) {
								$this->session->set_userdata('Event_Postage', 'Event Postage');
							} else if($menuRight[$j]->TP_ID == 36) {
								$this->session->set_userdata('Event_Dispatch_Collection', 'Event Dispatch Collection');
							} else if($menuRight[$j]->TP_ID == 37) {
								$this->session->set_userdata('All_Event_Postage_Collection', 'All Event Postage Collection');
							} else if($menuRight[$j]->TP_ID == 38) {
								$this->session->set_userdata('Trust_Import_Settings', 'Trust Import Settings');
							} else if($menuRight[$j]->TP_ID == 39) {
								$this->session->set_userdata('Add_Auction_Item', 'Add Auction Item');
							} else if($menuRight[$j]->TP_ID == 40) {
								$this->session->set_userdata('Bid_Auction_Item', 'Bid Auction Item');
							} else if($menuRight[$j]->TP_ID == 41) {
								$this->session->set_userdata('Auction_Receipt', 'Auction Receipt');
							} else if($menuRight[$j]->TP_ID == 42) {
								$this->session->set_userdata('Saree_Outward_Report', 'Saree Outward Report');
							} else if($menuRight[$j]->TP_ID == 43) {
								$this->session->set_userdata('Auction_Item_Report', 'Auction Item Report');
							} else if($menuRight[$j]->TP_ID == 44) {
								$this->session->set_userdata('Auction_Settings', 'Auction Settings');
							} else if($menuRight[$j]->TP_ID == 45) {
								$this->session->set_userdata('Event_Seva_Summary', 'Event Seva Summary');								
							}  else if($menuRight[$j]->TP_ID == 46) {
								$this->session->set_userdata('Trust_Event_Postage_Group', 'EventPostage Group');
							} else if($menuRight[$j]->TP_ID == 47) {
								$this->session->set_userdata('Trust_Inkind_Report', 'Trust Inkind Report');
							} else if($menuRight[$j]->TP_ID == 48){
								$this->session->set_userdata('Trust_Finance_Receipts', 'Trust Finance Receipts');

							}else if($menuRight[$j]->TP_ID == 49){
								$this->session->set_userdata('Trust_Finance_Payments', 'Trust Finance Payments');

							}else if($menuRight[$j]->TP_ID == 50){
								$this->session->set_userdata('Trust_Finance_Journal', 'Trust Finance Journal');
							}else if($menuRight[$j]->TP_ID == 51){
								$this->session->set_userdata('Trust_Finance_Contra', 'Trust Finance Contra');
							}else if($menuRight[$j]->TP_ID == 52){
								$this->session->set_userdata('Trust_Balance_Sheet', 'Trust Balance Sheet ');
							}else if($menuRight[$j]->TP_ID == 53){
								$this->session->set_userdata('Trust_Income_and_Expenditure', 'Trust Income and Expenditure');
							}else if($menuRight[$j]->TP_ID == 54){
								$this->session->set_userdata('Trust_Receipts_and_Payments', 'Trust Receipts and Payments');
							}else if($menuRight[$j]->TP_ID == 55){
								$this->session->set_userdata('Trust_Trial_Balance', 'Trust Trail Balance');
							}else if($menuRight[$j]->TP_ID == 56){
								$this->session->set_userdata('Trust_Finance_Add_Groups', 'Trust Add Groups');
							}else if($menuRight[$j]->TP_ID == 57){
								$this->session->set_userdata('Trust_Finance_Add_Ledgers', 'Trust Add Ledgers');
							}else if($menuRight[$j]->TP_ID == 58){
								$this->session->set_userdata('Trust_Finance_Add_Opening_Balance', 'Trust Add Opening Balance');
							}else if($menuRight[$j]->TP_ID == 59){
								$this->session->set_userdata('Trust_Finance_Day_Book', 'Trust Day Book');
							}else if($menuRight[$j]->TP_ID == 60){
								$this->session->set_userdata('Trust_All_Ledgers_and_Groups', 'Trust All Ledgers and Groups');
							}
							else if($menuRight[$j]->TP_ID == 61){
								$this->session->set_userdata('Trust_Finance_Prerequisites', 'Finance Prerequisites');	
							}
							else if($menuRight[$j]->TP_ID == 62) {
								$this->session->set_userdata('Trust_Voucher_Counter', 'Voucher Counter');
							}
							else if($menuRight[$j]->TP_ID == 64) {
								$this->session->set_userdata('Trust_Bank_Cheque_Configuration', 'Cheque Configuration');
							}

							///$this->session->set_userdata('Trust_Inkind_Report', 'Trust Inkind Report');
						}
					}
				} else {
					$menuRight = array('GROUP_ID' => $user['USER_GROUP'], 'STATUS' => 1);
					$menuRight = $this->obj_admin_settings->get_group_menu_right_available($menuRight,'GM_ID','asc');
					if($menuRight != 0) {
						$seva = "Home/homePage";
						for($j = 0; $j < count($menuRight); $j++) { 
							if($menuRight[$j]->P_ID == 1) {
								$this->session->set_userdata('Deity_Sevas', 'Deity Sevas');
								$seva = "Sevas";
							} else if($menuRight[$j]->P_ID == 2) {
								$this->session->set_userdata('Event_Sevas', 'Event Sevas');
								$seva = "Events";
								if(isset($_SESSION['Deity_Sevas'])) {
									$seva = "Sevas";
								}
							} else if($menuRight[$j]->P_ID == 3) {
								$this->session->set_userdata('All_Deity_Receipt', 'All Deity Receipt');
							} else if($menuRight[$j]->P_ID == 4) {
								$this->session->set_userdata('All_Event_Receipt', 'All Event Receipt');
							} else if($menuRight[$j]->P_ID == 5) { 
								$this->session->set_userdata('Deity_Seva', 'Deity Seva');
							} else if($menuRight[$j]->P_ID == 6) {
								$this->session->set_userdata('Deity_Donation', 'Deity Donation');
							} else if($menuRight[$j]->P_ID == 7) {
								$this->session->set_userdata('Deity_Kanike', 'Deity Kanike');
							} else if($menuRight[$j]->P_ID == 8) {
								$this->session->set_userdata('Event_Seva', 'Event Seva');
							} else if($menuRight[$j]->P_ID == 9) {
								$this->session->set_userdata('Event_Donation/Kanike', 'Event Donation/Kanike');
							} else if($menuRight[$j]->P_ID == 10) {
								$this->session->set_userdata('Deity/Event_Hundi', 'Deity/Event Hundi');
							} else if($menuRight[$j]->P_ID == 11) {
								$this->session->set_userdata('Deity/Event_Inkind', 'Deity/Event Inkind');
							} else if($menuRight[$j]->P_ID == 12) {
								$this->session->set_userdata('Deity_Receipt_Report', 'Deity Receipt Report');
							} else if($menuRight[$j]->P_ID == 13) {
								$this->session->set_userdata('Deity_Seva_Report', 'Deity Seva Report');
							} else if($menuRight[$j]->P_ID == 14) {
								$this->session->set_userdata('Deity_MIS_Report', 'Deity MIS Report');
							} else if($menuRight[$j]->P_ID == 15) {
								$this->session->set_userdata('Current_Event_Receipt_Report', 'Current Event Receipt Report');
							} else if($menuRight[$j]->P_ID == 16) {
								$this->session->set_userdata('Current_Event_Seva_Report', 'Current Event Seva Report');
							} else if($menuRight[$j]->P_ID == 17) {
								$this->session->set_userdata('Current_Event_MIS_Report', 'Current Event MIS Report');
							} else if($menuRight[$j]->P_ID == 18) {
								$this->session->set_userdata('User_Event_Collection_Report', 'User Event Collection Report');
							} else if($menuRight[$j]->P_ID == 19) {
								$this->session->set_userdata('Add_Auction_Item', 'Add Auction Item');
							} else if($menuRight[$j]->P_ID == 20) {
								$this->session->set_userdata('Bid_Auction_Item', 'Bid Auction Item');
							} else if($menuRight[$j]->P_ID == 21) {
								$this->session->set_userdata('Auction_Receipt', 'Auction Receipt');
							} else if($menuRight[$j]->P_ID == 22) {
								$this->session->set_userdata('Saree_Outward_Report', 'Saree Outward Report');
							} else if($menuRight[$j]->P_ID == 23) {
								$this->session->set_userdata('Auction_Item_Report', 'Auction Item Report');
							} else if($menuRight[$j]->P_ID == 24) {
								$this->session->set_userdata('Deity_Seva_Settings', 'Deity Seva Settings');
							} else if($menuRight[$j]->P_ID == 25) {
								$this->session->set_userdata('Event_Seva_Settings', 'Event Seva Settings');
							} else if($menuRight[$j]->P_ID == 26) {
								$this->session->set_userdata('Receipt_Settings', 'Receipt Settings');
							} else if($menuRight[$j]->P_ID == 27) {
								$this->session->set_userdata('Time_Settings', 'Time Settings');
							} else if($menuRight[$j]->P_ID == 28) {
								$this->session->set_userdata('Group_Settings', 'Group Settings');
							} else if($menuRight[$j]->P_ID == 29) {
								$this->session->set_userdata('Users_Settings', 'Users Settings');
							} else if($menuRight[$j]->P_ID == 30) {
								$this->session->set_userdata('Import_Settings', 'Import Settings');
							} else if($menuRight[$j]->P_ID == 31) {
								$this->session->set_userdata('Auction_Settings', 'Auction Settings');
							} else if($menuRight[$j]->P_ID == 32) {
								$this->session->set_userdata('Print_Deity_Details', 'Print Deity Details');
							} else if($menuRight[$j]->P_ID == 33) {
								$this->session->set_userdata('Print_Event_Details', 'Print Event Details');
							} else if($menuRight[$j]->P_ID == 34) {
								$this->session->set_userdata('Inkind_Items', 'Inkind Items');
							} else if($menuRight[$j]->P_ID == 35) {
								$this->session->set_userdata('Cheque_Remmittance', 'Cheque Remmittance');
							} else if($menuRight[$j]->P_ID == 36) {
								$this->session->set_userdata('Change_Donation/Kanike', 'Change Donation/Kanike');
							} else if($menuRight[$j]->P_ID == 37) {
								$this->session->set_userdata('Back_Up', 'Back Up');
							} else if($menuRight[$j]->P_ID == 38) {
								$this->session->set_userdata('Book_Seva', 'Book Seva');
							} else if($menuRight[$j]->P_ID == 39) {
								$this->session->set_userdata('All_Booked_Sevas', 'All Booked Sevas');
							} else if($menuRight[$j]->P_ID == 40) {
								$this->session->set_userdata('Financial_Month', 'Financial Month Settings');
							} else if($menuRight[$j]->P_ID == 41) {
								$this->session->set_userdata('Deity_Cheque_Remmittance', 'Deity Cheque Remmittance');
							} else if($menuRight[$j]->P_ID == 42) {
								$this->session->set_userdata('Deity_EOD', 'Deity E.O.D');
							} else if($menuRight[$j]->P_ID == 43) {
								$this->session->set_userdata('Bank_Settings', 'Bank Settings');
							} else if($menuRight[$j]->P_ID == 44) {
								$this->session->set_userdata('EOD_Tally', 'E.O.D Tally');
							} else if($menuRight[$j]->P_ID == 45) {
								$this->session->set_userdata('Deity_Seva_Summary', 'Deity Seva Summary');
							} else if($menuRight[$j]->P_ID == 46) {
								$this->session->set_userdata('Event_EOD', 'Event E.O.D');
							} else if($menuRight[$j]->P_ID == 47) {
								$this->session->set_userdata('Event_EOD_Tally', 'Event E.O.D Tally');
							} else if($menuRight[$j]->P_ID == 48) {
								$this->session->set_userdata('Temple_Day_Book', 'Temple Day Book');
							} else if($menuRight[$j]->P_ID == 49) {
								$this->session->set_userdata('SRNS_Fund', 'SRNS Fund');
							} else if($menuRight[$j]->P_ID == 50) {
								$this->session->set_userdata('Event_Token', 'Event Token');
							} else if($menuRight[$j]->P_ID == 51) {
								$this->session->set_userdata('Deity_Special_Receipt_Price', 'Deity Special Receipt Price');
							} else if($menuRight[$j]->P_ID == 52) {
								$this->session->set_userdata('Deity_Token', 'Deity Token');
							} else if($menuRight[$j]->P_ID == 53) {
								$this->session->set_userdata('Postage', 'Postage');
							} else if($menuRight[$j]->P_ID == 54) {
								$this->session->set_userdata('Dispatch_Collection', 'Dispatch Collection');
							} else if($menuRight[$j]->P_ID == 55) {
								$this->session->set_userdata('All_Postage_Collection', 'All Postage Collection');
							} else if($menuRight[$j]->P_ID == 56) {
								$this->session->set_userdata('Event_Postage', 'Event Postage');
							} else if($menuRight[$j]->P_ID == 57) {
								$this->session->set_userdata('Event_Dispatch_Collection', 'Event Dispatch Collection');
								} else if($menuRight[$j]->P_ID == 58) {
								$this->session->set_userdata('All_Event_Postage_Collection', 'All Event Postage Collection');
							} else if($menuRight[$j]->P_ID == 60) {
								$this->session->set_userdata('Shashwath_Seva', 'Shashwath Seva');
							} else if($menuRight[$j]->P_ID == 61) {
								$this->session->set_userdata('Shashwath_Loss_Report', 'Shashwath Loss Report');
							} else if($menuRight[$j]->P_ID == 62) {
								$this->session->set_userdata('Shashwath_New_Member', 'Shashwath New Member');
							} else if($menuRight[$j]->P_ID == 63) {
								$this->session->set_userdata('Shashwath_Member', 'Shashwath Member');
							} else if($menuRight[$j]->P_ID == 64) {
								$this->session->set_userdata('Shashwath_Period_Settings', 'Shashwath Period Settings');
							} else if($menuRight[$j]->P_ID == 65) {
								$this->session->set_userdata('Shashwath_Calendar_Settings', 'Shashwath Calendar Settings');
							} else if($menuRight[$j]->P_ID == 66) {
								$this->session->set_userdata('Shashwath_Existing_Import', 'Shashwath Existing Import');
							} else if($menuRight[$j]->P_ID == 67) {
								$this->session->set_userdata('Receipt_Settings', 'Receipt Settings');
							} else if($menuRight[$j]->P_ID == 68) {
								$this->session->set_userdata('Jeernodhara_Kanike', 'Jeernodhara Kanike');
							} else if($menuRight[$j]->P_ID == 69) {
								$this->session->set_userdata('Jeernodhara_Hundi', 'Jeernodhara Hundi');
							} else if($menuRight[$j]->P_ID == 70) {
								$this->session->set_userdata('Jeernodhara_Inkind', 'Jeernodhara Inkind');
							} else if($menuRight[$j]->P_ID == 71) {
								$this->session->set_userdata('Jeernodhara_Daily_Report', 'Jeernodhara Daily Report');
							} else if($menuRight[$j]->P_ID == 72) {
								$this->session->set_userdata('Event_Seva_Summary', 'Event Seva Summary');
							} else if($menuRight[$j]->P_ID == 73) {
								$this->session->set_userdata('Postage_Group', 'Postage Group');
							} else if($menuRight[$j]->P_ID == 74) {
								$this->session->set_userdata('SLVT_Event_Postage_Group', 'EventPostage Group');
							}   
							//Suraksha shashawath Festival Settings
							else if($menuRight[$j]->P_ID == 75) {
								$this->session->set_userdata('Shashwath_Festival_Settings', 'Shashwath Festival Settings');
							}else if($menuRight[$j]->P_ID == 76) {
								$this->session->set_userdata('Booked_Pending_Receipts', 'Booked Pending Receipts');
							}else if($menuRight[$j]->P_ID == 77) {
								$this->session->set_userdata('Kanike_Settings', 'Kanike Settings');
							}else if($menuRight[$j]->P_ID == 78) {
								$this->session->set_userdata('Finance_Receipts', 'Finance Receipts');
							}else if($menuRight[$j]->P_ID == 79) {
								$this->session->set_userdata('Finance_Payments', 'Finance Payments');
							}else if($menuRight[$j]->P_ID == 80) {
								$this->session->set_userdata('Finance_Journal', 'Finance Journal');
							}else if($menuRight[$j]->P_ID == 81) {
								$this->session->set_userdata('Finance_Contra', 'Finance Contra');
							}else if($menuRight[$j]->P_ID == 82) {
								$this->session->set_userdata('Balance_Sheet', 'Balance Sheet');
							}else if($menuRight[$j]->P_ID == 83) {
								$this->session->set_userdata('Income_and_Expenditure', 'Income and Expenditure');
							}else if($menuRight[$j]->P_ID == 84) {
								$this->session->set_userdata('Receipts_and_Payments', 'Receipts and Payments');
							}else if($menuRight[$j]->P_ID == 85) {
								$this->session->set_userdata('Trial_Balance', 'Trial Balance');
							}else if($menuRight[$j]->P_ID == 86) {
								$this->session->set_userdata('Finance_Add_Groups', 'Finance Add Groups');
							}else if($menuRight[$j]->P_ID == 87) {
								$this->session->set_userdata('Finance_Add_Ledgers', 'Finance Add Ledgers');
							}else if($menuRight[$j]->P_ID == 88) {
								$this->session->set_userdata('Finance_Add_Opening_Balance', 'Finance Add Opening Balance');
							}else if($menuRight[$j]->P_ID == 89) {
								$this->session->set_userdata('Voucher_Counter', 'Voucher Counter');
							}else if($menuRight[$j]->P_ID == 90) {
								$this->session->set_userdata('Finance_Prerequisites', 'Finance Prerequisites');
							}else if($menuRight[$j]->P_ID == 91) {
								$this->session->set_userdata('Bank_Cheque_Configuration', 'Cheque Configuration');
							}else if($menuRight[$j]->P_ID == 92) {
								$this->session->set_userdata('Finance_Day_Book', 'Finance Day Book');
							}else if($menuRight[$j]->P_ID == 93) {
								$this->session->set_userdata('All_Ledgers_and_Groups', 'All Ledgers and Groups');
							}else if($menuRight[$j]->P_ID == 94) {
								$this->session->set_userdata('Temple_Inkind_Report', 'Temple Inkind Report');
							} 
							
						}
					}
				}

				$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
				$query = $this->db->get();
				$_SESSION['eventActiveCount'] = $query->num_rows();
				//DEITY NOTIFICATION
				$conditionTwo = array('POSTAGE_STATUS' => 0,'RECEIPT_ACTIVE' => 1,'POSTAGE_CATEGORY' => 1);
				$_SESSION['dispatchCount'] = $this->obj_postage->get_sum_undispatched_counter($conditionTwo);
				//EVENT NOTIFICATION
				$conditionTwo = array('POSTAGE_STATUS' => 0,'ET_RECEIPT_ACTIVE' => 1,'ET_ACTIVE' => 1,'POSTAGE_CATEGORY' => 2);
				$_SESSION['eventDispatchCount'] = $this->obj_event_postage->get_sum_undispatched_counter($conditionTwo);
				//TRUST EVENT NOTIFICATION
				$conditionTwo = array('POSTAGE_STATUS' => 0,'TET_RECEIPT_ACTIVE' => 1,'TET_ACTIVE' => 1,'POSTAGE_CATEGORY' => 3);
				$_SESSION['trustEventDispatchCount'] = $this->obj_event_trust_postage->get_sum_undispatched_counter($conditionTwo);

				//AUTO CANCELLATION - UPDATING SEVA BOOKING START HERE
				$this->db->select()->from('SEVA_BOOKING')->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID')->where('SB_PAYMENT_STATUS','0');
				$querySB = $this->db->get();
				$sevaBooking = $querySB->result();
				
				//GET BOOKING AUTO CANCELLATION DAYS 
				$this->db->select()->from('BOOKING_AC');
				$queryBAC = $this->db->get();
				$bookingACDays = $queryBAC->result();
				
				//GET USER ID
				$this->db->select()->from('USERS')->where('USER_FULL_NAME','System');
				$queryUser = $this->db->get();
				$user = $queryUser->result();
				
				
				for($i = 0; $i < count($sevaBooking); $i++) {
					$date = "";
					if(@$sevaBooking[$i]->UPDATED_SO_DATE != "") {
						$date = $sevaBooking[$i]->UPDATED_SO_DATE;
					} else {
						$date = $sevaBooking[$i]->SO_DATE;
					}
					
					$date1=date_create(date("Y-m-d"));
					$date2=date_create(date("Y-m-d", strtotime(@$date)));
					$diff=date_diff($date2,$date1);
					
					if($diff->format("%R%a") > $bookingACDays[0]->DAYS) {
						$condition = array('SB_ID' => $sevaBooking[$i]->SB_ID);
						$data_array = array('SB_DEACTIVE_NOTES' => 'Auto Cancellation','SB_ACTIVE' => 0, 'SB_PAYMENT_STATUS' => 3, 'DEACTIVE_DATE_TIME' => date('d-m-Y H:i:s A'), 'DEACTIVE_DATE' => date('d-m-Y'),'SB_DEACTIVE_BY_ID' => $user[0]->USER_ID,'SB_DEACTIVE_BY' => 'System');
						$this->db->where($condition);
						$this->db->update('SEVA_BOOKING',$data_array);
					}
				}//AUTO CANCELLATION - UPDATING SEVA BOOKING ENDS HERE
				
				
				//AUTO CANCELLATION - TRUST HALL BOOKING START HERE (PENDING,PARTIAL,COMPLETED)
				$sql = "SELECT * FROM TRUST_HALL_BOOKING WHERE HB_ACTIVE = 1";
				$query = $this->db->query($sql);
				$trustHallBooking = $query->result('array');
								
				//GET HALL BOOKING AUTO CANCELLATION DAYS FROM BOOKING_HALL TABLE
				$this->db->select()->from('BOOKING_HALL');//15 Days
				$queryBH = $this->db->get();
				$bookingHDays = $queryBH->result();
				
				for($j = 0; $j < count($trustHallBooking); $j++) {
					$sql1 = "SELECT * FROM TRUST_HALL_BOOKING_LIST WHERE HBL_ACTIVE = 1 AND HB_ID = ".$trustHallBooking[$j]['HB_ID'];
					$query1 = $this->db->query($sql1);
					$trustHallBookingList = $query1->result('array');
					$count = 0;
					
					for($k = 0; $k < count($trustHallBookingList); $k++) {
						$date = "";
						$date = $trustHallBookingList[$k]['HB_BOOK_DATE'];
						
						$date1=date_create(date("Y-m-d"));
						$date2=date_create(date("Y-m-d", strtotime(@$date)));
						$diff=date_diff($date2,$date1);
						if($diff->format("%R%a") > $bookingHDays[0]->DAYS) {
							$count++;
						}
					}
					
					if($count == count($trustHallBookingList)) {
						$msg = "";
						if($trustHallBooking[$j]['HB_PAYMENT_STATUS'] == 0) {
							$msg = "Booking auto cancelled, all halls cancelled, no payment was done";
						} else if($trustHallBooking[$j]['HB_PAYMENT_STATUS'] == 1) {
							$msg = "Booking auto cancelled, all halls cancelled, partial payment was done";
						} else if($trustHallBooking[$j]['HB_PAYMENT_STATUS'] == 2) {
							$msg = "Booking auto cancelled, all halls cancelled, full payment was done";
						}
						
						$data_array = array("CANCEL_NOTES"=> $msg,
											"CANCELLED_BY"=>'System',
											"CANCELLED_DATE_TIME"=>date("d-m-Y h:i:s"),
											"CANCELLED_DATE"=>date("d-m-Y"),
											"CANCELLED_BY_ID"=>$user[0]->USER_ID,
											"HB_ACTIVE" => 0);
						$condition = array('HB_ID' => $trustHallBooking[$j]['HB_ID']);
						$this->db->where($condition);
						$this->db->update("TRUST_HALL_BOOKING",$data_array);
						
						$where = array(
						"HB_ID"=>$trustHallBooking[$j]['HB_ID']
						);
						$TRUST_HALL_BOOKING_LIST = array(
							"HBL_ACTIVE"=>0
						);
						
						$sql = "select * from TRUST_HALL_BOOKING_LIST where HB_ID='".$trustHallBooking[$j]['HB_ID']."'";
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
				}
                    
			 	if(isset($_SESSION['Notification'])) {
					 	$date = $everyDate = date('d-m-Y', strtotime(date('d-m-Y'). ' +2 days'));
						$thithi_codes = $this->obj_shashwath->getThithiCode($date);
						$thithi_codes_roi = $this->obj_shashwath->getThithiCodeROI($date);
						$thithi_where_condition = '';

						if($thithi_codes_roi){
							$ROI = $thithi_codes_roi[0]->CAL_ROI;
						} else{
							$_SESSION['nullCalendar']="nullCalendar";
						}

					foreach($thithi_codes as $result){
						$thithi_where_condition .= "THITHI_CODE = '".$result->THITHI_SHORT_CODE."' OR ";  
						// $ROI = $result->CAL_ROI;
					}  
						$date2 = explode("-",$date);
						$date = $date2[0].'-'.$date2[1];
						$thithi_where_condition .= "ENG_DATE = '".$date."'"; 
						$name_phone ='';

						//EVERY CAL TYPE START
						$sql ="SELECT ENG_DATE,THITHI_SHORT_CODE,THITHI_NAME,MASA,based_on_moon,DAY,CAL_ID FROM `calendar_year_breakup` WHERE ENG_DATE='$everyDate'";
			$query = $this->db->query($sql);
			$dataMasa = $query->first_row(); 
			$Masa = $dataMasa->MASA;
			$CALID = $dataMasa->CAL_ID;

			$sql1="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='PADYA' AND based_on_moon='SHUDDHA' AND CAL_ID =$CALID";
			$query1 = $this->db->query($sql1);
			$dataStartDate  = $query1->first_row(); 
			if($dataStartDate){
				$biginingDate =  $dataStartDate->ENG_DATE; 
			}else{
				$biginingDate =  "";
			}
			 

			$sql2="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='AMAVASYA' AND CAL_ID =$CALID ";
			$query2 = $this->db->query($sql2);
			$dataEndtDate  = $query2->first_row(); 
			if($dataEndtDate){
				$endDate =  $dataEndtDate->ENG_DATE; 
			}else{
				$endDate = ""; 
			}
			// $endDate =  $dataEndtDate->ENG_DATE; 
			
			//EVERY CAL TYPE START
			$Timestamp = strtotime($everyDate);
			$dayOfWeek = date("l", $Timestamp);
			$thisMonth = date("F", $Timestamp);
			$strtdateHindu=date($biginingDate);
			$enddateHindu=date($endDate);

			// if($strtdateHindu !='' and $enddateHindu != ''){
				//If it is hindu calender every case	
				$weekFirstHindu  = date('d-m-Y', strtotime('first '.$dayOfWeek.' '.$strtdateHindu));
				$weekSecondHindu = date('d-m-Y', strtotime('second '.$dayOfWeek.' '.$strtdateHindu));
				$weekThirdHindu  = date('d-m-Y', strtotime('third '.$dayOfWeek.' '.$strtdateHindu));
				$weekFourthHindu = date('d-m-Y', strtotime('fourth '.$dayOfWeek.' '.$strtdateHindu));
				$weekLastHindu   = date('d-m-Y', strtotime('last '.$dayOfWeek.' '.$enddateHindu));

				$M_DOW = $LM_DOW = $Y_DOW_HINDU = $LY_DOW_HINDU = "";
				if($weekFirstHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_First_".$dayOfWeek; 
				}else if($weekSecondHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_Second_".$dayOfWeek; 
				}else if($weekThirdHindu == $everyDate){
					$Y_DOW_HINDU = $Masa."_Third_".$dayOfWeek; 
				}else if($weekFourthHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_Fourth_".$dayOfWeek; 
				
				}
		
				if($weekLastHindu == $everyDate){		
					$LY_DOW_HINDU = $Masa."_Last_".$dayOfWeek; 
				
				}
			// }else{
				//If it is gregorian calender every case
				$weekFirst  = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekSecond = date("d-m-Y", strtotime("second ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekThird  = date("d-m-Y", strtotime("third ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekFourth = date("d-m-Y", strtotime("fourth ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekLast   = date("d-m-Y", strtotime("last ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
			

				$M_DOW = $Y_DOW = $LM_DOW = $LY_DOW = "";
				if($weekFirst == $everyDate){
					$M_DOW = "First_".$dayOfWeek; 
					$Y_DOW = $thisMonth."_First_".$dayOfWeek; 
				}else if($weekSecond == $everyDate){
					$M_DOW = "Second_".$dayOfWeek;
					$Y_DOW = $thisMonth."_Second_".$dayOfWeek; 
				}else if($weekThird == $everyDate){
					$M_DOW = "Third_".$dayOfWeek; 
					$Y_DOW = $thisMonth."_Third_".$dayOfWeek; 
				}else if($weekFourth == $everyDate){
					$M_DOW = "Fourth_".$dayOfWeek;
					$Y_DOW = $thisMonth."_Fourth_".$dayOfWeek; 
					
				}

				if($weekLast == $everyDate){
					$LM_DOW = "Last_".$dayOfWeek; 
					$LY_DOW = $thisMonth."_Last_".$dayOfWeek; 
					
				}

			// }

			$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'";
			if ($M_DOW) {
				$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$M_DOW."' OR EVERY_WEEK_MONTH = '".$Y_DOW."'" ;
			}
			if ($LM_DOW) {
				$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$LM_DOW."' OR EVERY_WEEK_MONTH = '".$LY_DOW."' ";
			}

			if ($Y_DOW_HINDU) {
				$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$Y_DOW_HINDU."'";
			}

			if ($LY_DOW_HINDU) {
				$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$LY_DOW_HINDU."'";
			}
						//EVERY CAL TYPE END

					if(isset($ROI)){
						$selectedSsDate = date('d-m-Y', strtotime(date('d-m-Y'). ' +2 days'));
						$oneYrLessSelDate = date("d-m-Y",strtotime($selectedSsDate."-1 year"));
						$datacount = $this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,'','',$oneYrLessSelDate) ? $this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,'','',$oneYrLessSelDate) : 0;
						$_SESSION['countGenerateSeva'] = $datacount;
					}  
					
					$date1 = date('d-m-Y', strtotime(date('d-m-Y'). ' +2 days'));
					$blnShashwathSevaExists = $this->obj_shashwath->count_result($date1);
					if($blnShashwathSevaExists) {
						$_SESSION['blnShashwathSevaExists'] = 'true';	
					} else {
						$_SESSION['blnShashwathSevaExists'] = 'false'; 
					}         
						$date = date('d-m-Y');
						$countLossSeva = $this->obj_shashwath->count_LossReport_Rows($date);
					if($countLossSeva){
						$_SESSION['countLossSeva'] = $countLossSeva;
					}
						$sevaOfferedNoPriceCount =$this->obj_shashwath->seva_Offered_No_Price_Count($date); 
				
					if(isset($sevaOfferedNoPriceCount)){
						$_SESSION['sevaOfferedNoPriceCount'] = $sevaOfferedNoPriceCount;
					} else {
						$_SESSION['sevaOfferedNoPriceCount'] = 0;
					}
					
				}
			//AUTO CANCELLATION - HALL TRUST BOOKING ENDS HERE (PENDING,PARTIAL,COMPLETED)
			$date = date('d-m-Y');
			$startDate =date('01-m-Y');
			$endDate= date('t-m-Y', strtotime($date));
			$result = $this->obj_finance->fd_Exp_Count($startDate,$endDate);
			$_SESSION['fdExpCount'] = $result;

			$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
			$fromDate = explode(":",$dtFuncStr)[0];
			$toDate = explode(":",$dtFuncStr)[1];
			$_SESSION['pending_cheques'] = $this->obj_eod->count_get_all_field($fromDate, $toDate);
			$cheque_number = '';
			$_SESSION['Deity_Cheque_RemmittanceCount'] = $this->obj_admin_settings->get_all_deityChequeRemmittanceCount($cheque_number);
			$_SESSION['Cheque_RemmittanceCount'] =$this->obj_admin_settings->get_all_TrustChequeReconcilationCount($cheque_number);
			$_SESSION['Event_Cheque_RemmittanceCount'] = $this->event_obj_eod->count_get_all_field($fromDate, $toDate);
			$_SESSION['Trust_Event_EOD_Count'] = $this->Trust_Event_obj_eod->count_get_all_field($fromDate, $toDate);
			
			$date = date('d-m-Y');
			$startDate =date('01-m-Y');
			$currentDate = date('d-m-Y');
           // Calculate the fromDate (April 1st of the previous year)
           $fromDATE = date('01-04-Y', strtotime('-1 year', strtotime($currentDate)));
           // Calculate the toDate (March 31st of the current year)
           $toDATE = date('31-03-Y', strtotime($currentDate));
           $_SESSION['res'] =  $this->obj_finance->checkAndInsertToFinancial_Ledger($fromDATE,$toDATE,$Revision = "false");
		   $_SESSION['tru'] = $this->obj_trust_finance->checkAndInsertToFinancial_Ledger($fromDATE,$toDATE,$Revision = "false");
		   $endDate= date('t-m-Y', strtotime($date));
			$result = $this->obj_trust_finance->fd_Exp_Count($startDate,$endDate);
			$_SESSION['fdTrustExpCount'] = $result;

			$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
			$fromDate = explode(":",$dtFuncStr)[0];
			$toDate = explode(":",$dtFuncStr)[1];
			$_SESSION['Trust_pending_cheques'] = $this->obj_trust_eod->count_get_all_field($fromDate, $toDate);
          
			echo "success#".$seva;
			}
		} else 
			echo "error";
	}
}
