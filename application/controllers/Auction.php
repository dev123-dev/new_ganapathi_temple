<?php defined('BASEPATH') OR exit('No direct script access allowed');
	class Auction extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->load->helper('string');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->helper(array('form', 'url'));
			$this->load->helper('date');
			date_default_timezone_set('Asia/Kolkata');
			$this->load->model('Auction_model','obj_auction',true);
			$this->load->model('admin_settings/Admin_setting_model','obj_admin_settings',true);	
			$this->load->model('Events_modal','obj_events',true);
			$this->load->model('Receipt_modal','obj_receipt',true);	
			$this->load->model('Shashwath_Model','obj_shashwath',true);
			//CHECK LOGIN
			if(!isset($_SESSION['userId']))
				redirect('login');
			
			if($_SESSION['trustLogin'] == 1)
				redirect('Trust');

			$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
			$query = $this->db->get();
			$_SESSION['eventActiveCount'] = $query->num_rows();
		}
		
		//TO VIEW THE BIDDER DETAILS
		function View(){
			$name = $this->input->post('name');
			$phone = $this->input->post('number');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
			
			echo "<h6 style='font-size:16px; line-height:16px;'><b>Name : </b> ".$name."</h6>" ;  
			echo "<h6 style='font-size:16px; line-height:16px;'><b>Phone : </b> ".$phone."</h6>" ; 
			if($email)
				echo "<h6 style='font-size:16px; line-height:16px;'><b>Email : </b> ".$email."</h6>" ; 
			if($address)
				echo "<h6 style='font-size:16px; line-height:16px;'><b>Address : </b> ".str_replace("'","\'",$address)."</h6>" ; 
		}
		
		//FOR PRINT
		function get_saree_details() { 
			$id = $_POST['id'];
			$condition = array('AIL_ID' => $id);
			$auctItemList = $this->obj_auction->get_item_details("AUCTION_ITEM_LIST",$condition); 
			$condtBidRange = array('IBR_AI_ID' =>$auctItemList[0]->AIL_ITEM_ID,'IBR_AIC_ID' =>$auctItemList[0]->AIL_AIC_ID);
			$bidRange = $this->obj_auction->get_bid_ranges("AUCTION_ITEM_BID_RANGE",$condtBidRange);
			$condtDefBidRange = array('IDB_AI_ID' =>$auctItemList[0]->AIL_ITEM_ID,'IDB_AIC_ID' =>$auctItemList[0]->AIL_AIC_ID);
			$defaultBidRange = $this->obj_auction->get_default_bid("AUCTION_ITEM_DEFAULT_BID",$condtDefBidRange);
			
			$j = 0;
			$BigAmount = 0;
			for($i = 0; $i < count($bidRange); $i++) {
				$rangeStart = $bidRange[$i]->ITEM_FROM_PRICE;
				$rangeEnd = $bidRange[$i]->ITEM_TO_PRICE;
				$itemPrice = $auctItemList[0]->AIL_ITEM_PRICE;
				if(($rangeStart <= $itemPrice) && ($rangeEnd >= $itemPrice)) {
					echo $bidRange[$i]->MIN_BID_VALUE."|".$auctItemList[0]->AIL_ITEM_DETAILS;
					$j = 1;
				}
				
				if($rangeEnd < $itemPrice){
					$j = 2;
					$BigAmount = $bidRange[$i]->MIN_BID_VALUE;
				}
			}
			
			if($j == 2) {
				echo $BigAmount."|".$auctItemList[0]->AIL_ITEM_DETAILS;
			}
			
			if($j == 0) {
				if($defaultBidRange) {
					echo $defaultBidRange[0]->DEFAULT_BID_VALUE."|".$auctItemList[0]->AIL_ITEM_DETAILS;
				} 
			}
		}
		
		//FOR ADD AUCTION ITEM
		function add_auction_item_list() {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			$data['whichTab'] = 'auction';
			$data['event'] = $this->obj_events->getEvents();
			$this->db->select()->from('AUCTION_ITEM')
			->where(array('AUCTION_ITEM.AI_STATUS'=>1));
			
			$query = $this->db->get();
			$data['items'] = $query->result();
			
			$this->db->select()->from('AUCTION_ITEM_CATEGORY')
			->where(array('AUCTION_ITEM_CATEGORY.AIC_STATUS'=>1));
			$query = $this->db->get();
			$data['saree'] = $query->result();
			
			$conditionTwo = array('EVENT.ET_ACTIVE' => 1); 
			$data['activeDate'] = $this->obj_admin_settings->get_all_field_event($conditionTwo); 
			
			if(isset($_SESSION['Add_Auction_Item'])) {
				$this->load->view('header',$data);
				$this->load->view('auction/add_auction_item');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FOR BID AUCTION ITEM
		function bid_auction_item() {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			$data['whichTab'] = 'auction';
			$data['event'] = $this->obj_events->getEvents();
			
			$this->db->select('*');
			$this->db->from('AUCTION_ITEM_LIST');
			$this->db->where('AUCTION_ITEM_LIST.AIL_ITEM_STATUS', 1);
			$this->db->group_by('AIL_ITEM_NAME');
			
			$query = $this->db->get();
			$data['items'] = $query->result();
			
			$this->db->select()->from('AUCTION_ITEM_LIST')
			->where(array('AUCTION_ITEM_LIST.AIL_ITEM_STATUS'=>1))->order_by('AIL_AIC_ID','asc');
			$this->db->order_by('AIC_SEVA_DATE', 'asc'); 
			
			$query = $this->db->get();
			$data['itemsLists'] = $query->result();
			
			if(isset($_SESSION['Bid_Auction_Item'])) {
				$_SESSION['From_Bid_Auction_Item'] = 1;
				$this->load->view('header',$data);
				$this->load->view('auction/bid_auction_item');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
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
		
		//FOR ISSUE AUCTION RECEIPT SAVE
		//FOR ISSUE AUCTION RECEIPT SAVE
	//FOR ISSUE AUCTION RECEIPT SAVE xxx
		function issue_auction_receipt_save() {
			$modeOfPayment = $this->input->post('modeOfPayment');
			if($modeOfPayment == "Cheque") {
				$chequeNo = $this->input->post('chequeNo');
				$chequeDate = $this->input->post('chequeDate');
				$bank = $this->input->post('bank');
				$branch = $this->input->post('branch');
				$transactionId = "";
				$fglhBank = "";
			} else if($modeOfPayment == "Credit / Debit Card") {
				$transactionId = $this->input->post('transactionId');
				$chequeNo = "";
				$chequeDate = "";
				$bank = "";
				$fglhBank = $this->input->post('DCtobank');	
								//laz new
				$branch = "";
			} else if($modeOfPayment == "Direct Credit") {					
				$transactionId = "";
				$chequeNo = "";
				$chequeDate = "";
				$bank = "";
				$fglhBank = $this->input->post('tobank');
					
				$branch = "";
			} else {
				$transactionId = "";
				$chequeNo = "";
				$chequeDate = "";
				$bank = "";
				$branch = "";
				$fglhBank = "";
			}
			
			if($modeOfPayment == "Cheque") {
				$paymentStatus = "Pending";
			} else {
				$paymentStatus = "Completed";
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
			
			$data_event_receipt = array('ET_RECEIPT_NO' => $receiptFormat,
										'ET_RECEIPT_NAME' => $this->input->post('name'),
										'ET_RECEIPT_PHONE' => $this->input->post('number'),
										'ET_RECEIPT_EMAIL' => $this->input->post('email'),
										'ET_RECEIPT_ADDRESS' => $this->input->post('address'),
										'ET_RECEIPT_DATE' => date('d-m-Y'),
										'ET_RECEIPT_PAYMENT_METHOD' => $modeOfPayment,
										'ET_RECEIPT_PRICE' => $this->input->post('bidPrice'),
										'ET_RECEIPT_PAYMENT_METHOD_NOTES' => $this->input->post('bilRefNo'),
										'RECEIPT_ET_ID' => $this->input->post('eventId'),
										'RECEIPT_ET_NAME' => $this->input->post('eventName'),
										'ET_RECEIPT_ISSUED_BY_ID' =>$_SESSION['userId'],
										'ET_RECEIPT_ISSUED_BY' =>$_SESSION['userFullName'],
										'DATE_TIME' => date('d-m-Y H:i:s A'),
										'ET_RECEIPT_ACTIVE' =>1,
										'ET_RECEIPT_CATEGORY_ID' =>2,
										'CHEQUE_NO' => $chequeNo,
										'CHEQUE_DATE' => $chequeDate,
										'BANK_NAME' => $bank,
										'BRANCH_NAME' => $branch,
										'TRANSACTION_ID' => $transactionId,
										'PAYMENT_STATUS'=>$paymentStatus,
										'AUTHORISED_STATUS'=>'No',							//laz new		
										'FGLH_ID' => $fglhBank	);						//laz new ..
			$receiptId = $this->obj_receipt->add_receipt_hundi_event_modal($data_event_receipt);
			
			$data_array = array('BIL_ID' => $this->input->post('bilId'),
								'AR_RECEIPT_NO' => $receiptFormat,
								'AR_ITEM_ID' => $this->input->post('itemId'),
								'AR_ITEM_NAME' => $this->input->post('item'),
								'AR_ITEM_DETAILS' => $this->input->post('itemDetails'),
								'AR_EVENT_NAME' => $this->input->post('eventName'),
								'AR_EVENT_ID' => $this->input->post('eventId'),
								'AR_NAME' => $this->input->post('name'),
								'AR_NUMBER' => $this->input->post('number'),
								'AR_EMAIL' => $this->input->post('email'),
								'AR_ADDRESS' => $this->input->post('address'),
								'AR_BID_PRICE' => $this->input->post('bidPrice'),
								'AR_PAYMENT_MODE' => $modeOfPayment,
								'AR_CHEQUE_NO' => $chequeNo,
								'AR_CHEQUE_DATE' => $chequeDate,
								'AR_BANK_NAME' => $bank,
								'AR_BRANCH_NAME' => $branch,
								'AR_TRANSACTION_ID' => $transactionId,
								'USER_ID' => $_SESSION['userId'],
								'DATE_TIME' => date('d-m-Y H:i:s A'),
								'AR_RECEIPT_DATE' => date('d-m-Y'),
								'ET_RECEIPT_ID' => $receiptId);
			$id = $this->obj_auction->add_auction_receipt_modal('AUCTION_RECEIPT',$data_array);
			
			redirect('/Auction/issue_receipt_print/'.$id);
		}


		
		//FOR ISSUE AUCTION RECEIPT
		function issue_auction_receipt($id) {
			$_SESSION['duplicate'] = "no";
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link1'] = $actual_link;
			
			//SLAP
			//bank 															
			// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
			// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..	

			$condition = (" IS_TERMINAL = 1");														
			// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
			// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
			$data['bank'] = $this->obj_receipt->getAllbanks();
			$data['terminal'] = $this->obj_receipt->getCardbanks($condition);

			$data['fromAllReceipt'] = "1";
			$_SESSION['duplicate'] = "no";
			$data['event'] = $this->obj_events->getEvents();
			$condition = array('BIL_ID' => $id);
			$data['auction_receipt'] = $this->obj_auction->get_auction_receipt('BID_ITEM_LIST',$condition);
			
			$this->load->view('header',$data); 
			$this->load->view('auction/issue_auction_receipt');
			$this->load->view('footer_home');
		}

		
		//FOR ISSUE AUCTION RECEIPT PRINT
		function issue_receipt_print($id) {
			$data['duplicate'] = @$_SESSION['duplicate'];
			unset($_SESSION['duplicate']);
			
			if(@$_SESSION['actual_link1'] != "") {
				$data['duplicate'] = "no";
				unset($_SESSION['actual_link1']);
			} else unset($_SESSION['actual_link1']);
			
			
			$data['fromAllReceipt'] = "1";
			$data['event'] = $this->obj_events->getEvents();
			$condition = array('AR_ID' => $id);
			$data['auction_receipt'] = $this->obj_auction->get_auction_receipt('AUCTION_RECEIPT',$condition);
			
			$condition = array('ET_RECEIPT_ID' => $data['auction_receipt'][0]->ET_RECEIPT_ID);
			$data['notes'] = $this->obj_auction->get_auction_receipt('EVENT_RECEIPT',$condition);
			
			$condition = array('USER_ID' => $data['auction_receipt'][0]->USER_ID);
			$data['issuedBy'] = $this->obj_auction->get_auction_receipt('USERS',$condition);
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			
			$this->load->view('header',$data); 
			$this->load->view('auction/issue_receipt_print');
			$this->load->view('footer_home');
		}
		
		function AuctionPrintStatus(){
			$receiptId = @$_POST['receiptId'];
			$printstatus = $this->input->post('printStatus');
			$data2 = array(
			'PRINT_STATUS' => $printstatus
			);
			$where = array('AR_ID' => $receiptId);
			$this->db->where($where);
			$this->db->update('AUCTION_RECEIPT',$data2);
		}
		
		//FOR SEARCH ISSUE AUCTION
		function SearchAuctionReceipt($start = 0) {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$data['whichTab'] = 'auction';
			if(@$_POST['searchName']) {
				$_SESSION['name'] = $this->input->post('searchName');
				$searchName = $this->input->post('searchName');
				$data['name'] = $this->input->post('searchName');
			}
			
			if(@$_SESSION['name'] == "") {
				$this->session->set_userdata('name', $this->input->post('searchName'));
				$data['name'] = $_SESSION['name'];
				$searchName = $this->input->post('searchName');
			} else {
				$searchName = $_SESSION['name'];
				$data['name'] = $_SESSION['name'];
			}
			
			if(@$_POST['searchBidNo']) {
				$_SESSION['bidNo'] = $this->input->post('searchBidNo');
				$searchBidNo = $this->input->post('searchBidNo');
				$data['bidNo'] = $this->input->post('searchBidNo');
			}
			
			if(@$_SESSION['bidNo'] == "") {
				$this->session->set_userdata('bidNo', $this->input->post('searchBidNo'));
				$searchBidNo = $this->input->post('searchBidNo');
				$data['bidNo'] = $_SESSION['bidNo'];
			} else {
				$searchBidNo = $_SESSION['bidNo'];
				$data['bidNo'] = $_SESSION['bidNo'];
			}
			
			if($searchName != "") {
				$condition = array('BIL_NAME' => $searchName);
			} else if($searchBidNo != "") {
				$condition = array('BID_REF_NO' => $searchBidNo);
			} else {
				$condition = "";
			}
			
			$data['event'] = $this->obj_events->getEvents();
			$data['auction_receipt'] = $this->obj_auction->get_auction_receipt('AUCTION_RECEIPT');
			$data['bid_item_list'] = $this->obj_auction->get_bid_item_list_like('BID_ITEM_LIST',$condition,"","",10,$start);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Auction/SearchAuctionReceipt';
			$config['total_rows'] = $this->obj_auction->count_rows_bid_item_like('BID_ITEM_LIST',$condition);
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
			$this->load->view('auction/issue_auction');
			$this->load->view('footer_home');
		}
		
		//FOR ISSUE AUCTION
		function issue_auction($start = 0) {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			$_SESSION['duplicate'] = "yes";
			$data['whichTab'] = 'auction';
			$data['event'] = $this->obj_events->getEvents();
			$data['auction_receipt'] = $this->obj_auction->get_auction_receipt('AUCTION_RECEIPT');
			$data['bid_item_list'] = $this->obj_auction->get_bid_item_list('BID_ITEM_LIST',"","","",10,$start);
			$data['name'] = "";
			$data['bidNo'] = "";
			unset($_SESSION['name']);
			unset($_SESSION['bidNo']);
				
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Auction/issue_auction';
			$config['total_rows'] = $this->obj_auction->count_rows_bid_item('BID_ITEM_LIST');
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
			
			if(isset($_SESSION['Auction_Receipt'])) {
				$this->load->view('header',$data);
				$this->load->view('auction/issue_auction');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		function checkSareeDate() {
			$AIC_ID = $_POST['sareeType'];
			
			if($AIC_ID == 1) {
				$this->db->select()->from('AUCTION_ITEM_LIST')
				->where(array('AUCTION_ITEM_LIST.AIL_EVENT_ID'=>$_POST['event_name'], 'AIL_AIC_ID'=>$AIC_ID,'AIC_SEVA_DATE'=>$_POST['sevadate']));
				$query = $this->db->get();
				$num = $query->num_rows();
				
				if($num > 0) {
					echo json_encode($query->first_row('array'));
					
				}else {
					echo $num;
					
				}
				
			}
		}
		function updateSareeDate() {
			$newDate = $_POST['sevadate'];
			$itemId = $_POST['itemId'];
			
			$todayDate = date('d-m-Y');
			$dateTime = date('d-m-Y H:i:s A');
			
			if(isset($_POST['swapDate'])) {
				$swapDate = $_POST['swapDate'];
				$refno = $_POST['refno'];
				
				$updateActionItem = array('AIC_SEVA_DATE'=>$_POST['swapDate']);
				$condition = array('AIL_ID'=>$_POST['itemId']);
				$this->obj_auction->update_auction_model("AUCTION_ITEM_LIST", $condition, $updateActionItem);
				
				$updateActionItem = array('AIC_SEVA_DATE'=>$newDate);
				$condition = array('ITEM_REF_NO'=>$_POST['refno']);
				$this->obj_auction->update_auction_model("AUCTION_ITEM_LIST", $condition, $updateActionItem);
				echo "Success";
			}else {
				$updateActionItem = array('AIC_SEVA_DATE'=>$newDate);
				$condition = array('AIL_ID'=>$_POST['itemId']);
				$this->obj_auction->update_auction_model("AUCTION_ITEM_LIST", $condition, $updateActionItem);
				echo "Success";
			}
			
		}
		//CONDITION TO CHECK EXISTS OR NOT
		function checkHarivanaExist() {
			$data['event'] = $this->obj_events->getEvents();
			$data['item'] = explode( "|", $_POST['item']);
			$AI_ID = $data['item'][0];
			$data['sareeFor'] = explode( "|", $_POST['sareeFor']);
			$AIC_ID = $data['sareeFor'][0];
			$num = 0;
			if($AI_ID != 2) {
				$this->db->select()->from('AUCTION_ITEM_LIST')
				->where(array('AUCTION_ITEM_LIST.AIL_EVENT_ID'=>$data['event']['ET_ID'], 'AIL_ITEM_ID'=>$AI_ID));
				$query = $this->db->get();
				$num = $query->num_rows();
			} else if($AIC_ID == 3) {
				$this->db->select()->from('AUCTION_ITEM_LIST')
				->where(array('AUCTION_ITEM_LIST.AIL_EVENT_ID'=>$data['event']['ET_ID'], 'AIL_AIC_ID'=>$AIC_ID));
				$query = $this->db->get();
				$num = $query->num_rows();
			} else if($AIC_ID == 1) {
				$this->db->select()->from('AUCTION_ITEM_LIST')
				->where(array('AUCTION_ITEM_LIST.AIL_EVENT_ID'=>$data['event']['ET_ID'], 'AIL_AIC_ID'=>$AIC_ID,'AIC_SEVA_DATE'=>$_POST['sevadate']));
				$query = $this->db->get();
				$num = $query->num_rows();
			}else if($AIC_ID == 4) {
				$this->db->select()->from('AUCTION_ITEM_LIST')
				->where(array('AUCTION_ITEM_LIST.AIL_EVENT_ID'=>$data['event']['ET_ID'], 'AIL_AIC_ID'=>$AIC_ID));
				$query = $this->db->get();
				$num = $query->num_rows();
			}
			
			if($num != 0) {
				echo "failed";
			} else 
				echo "success";
		}
		
		//BID AUCTION PREVIEW
		function bid_auction_preview() {
			$data['whichTab'] = 'auction';
			$data['event'] = $this->obj_events->getEvents(); 
			$data['name'] = $_POST['name'];
			$data['phone'] = $_POST['phone'];
			$data['email'] = $_POST['email'];
			$data['address'] = $_POST['address'];
			$data['itemDet'] = $_POST['itemDet'];
			$data['bidPrice'] = $_POST['bidPrice'];
			
			if(isset($_POST['bidRefNoView'])) {
				$data2 = array(
				'PRINT_STATUS' => 1
				);
				$where = array('BID_REF_NO' => $_POST['bidRefNoView']);
				$this->db->where($where);
				$this->db->update('BID_ITEM_LIST',$data2);
			}
			
			if(isset($_SESSION['item']) || isset($_SESSION['itemRef']) || isset($_SESSION['bidRefNo'])) {
				$data['item'] = $_SESSION['item'];
				$data['itemRef'] = $_SESSION['itemRef'];
				$data['bidRefNo'] = $_SESSION['bidRefNo'];
			}
			
			if(isset($_SESSION['From_Bid_Auction_Item'])){
				$item = explode("|", $_POST['item']);
				$data['item'] = $item[2];
				$_SESSION['item'] = $item[2];
				
				$itemRef = explode("|", $_POST['itemRef']);
				$data['itemRef'] = $itemRef[7];
				$_SESSION['itemRef'] = $itemRef[7];
				
				$todayDate = date('d-m-Y');
				$dateTime = date('d-m-Y H:i:s A');
				
				$this->db->select()->from('BID_REFERENCE_COUNTER')
				->where(array('BID_REFERENCE_COUNTER.BRC_ID'=>1));
				$query = $this->db->get();
				$res = $query->first_row();
				$bidNo = $res->BRC_COUNTER;
				$bidRefNo = "B-".++$bidNo;
				$data['bidRefNo'] = $bidRefNo;
				$_SESSION['bidRefNo'] = $bidRefNo;
				
				$dataInsert = array(
					'BID_REF_NO'=>$bidRefNo,
					'AIL_ID'=>$itemRef[0],
					'ITEM_REF_NO'=>$itemRef[7],
					'BIL_ITEM_ID'=>$item[0],
					'BIL_ITEM_NAME'=>$item[2],
					'BIL_ITEM_DETAILS'=>$data['itemDet'],
					'BIL_EVENT_NAME'=>$data['event']['ET_NAME'],
					'BIL_EVENT_ID'=>$data['event']['ET_ID'],
					'BIL_NAME'=>$data['name'],
					'BIL_NUMBER'=>$data['phone'],
					'BIL_EMAIL'=>$data['email'],
					'BIL_ADDRESS'=>$data['address'],
					'BIL_BID_PRICE'=>$data['bidPrice'],
					'USER_ID'=>$_SESSION['userId'],
					'DATE_TIME'=>$dateTime,
					'DATE'=>$todayDate
				);
				
				$insertId = $this->obj_auction->add_auction_modal("BID_ITEM_LIST", $dataInsert);
				
				if($insertId != "") {
					$updateActionItem = array('BRC_COUNTER'=>$bidNo);
					$this->obj_auction->update_auction_model("BID_REFERENCE_COUNTER", "", $updateActionItem);
					$updateActionItem = array('AIL_ITEM_STATUS'=>2);
					$condition = array('ITEM_REF_NO'=>$itemRef[7]);
					$this->obj_auction->update_auction_model("AUCTION_ITEM_LIST", $condition, $updateActionItem);
				}
				unset($_SESSION['From_Bid_Auction_Item']);
			}
			
			$this->db->select('PRINT_STATUS')->from('BID_ITEM_LIST')
			->where(array('BID_ITEM_LIST.BID_REF_NO'=>$_SESSION['bidRefNo']));
			$query = $this->db->get();
			$data['printStatus'] = $query->first_row();
			
			$condition = array('USER_ID' => $_SESSION['userId']);
			$data['issuedBy'] = $this->obj_auction->get_auction_receipt('USERS',$condition);
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();

			$this->load->view('header',$data);
			$this->load->view('auction/bid_auction_preview');
			$this->load->view('footer_home');
		}
		
		//FOR ADDING AUCTION ITEM DETAILS
		function auction_item_details() {
			$data['whichTab'] = 'auction';
			$data['event'] = $this->obj_events->getEvents();
			
			$this->db->select()->from('AUCTION_ITEM')
			->where(array('AUCTION_ITEM.AI_STATUS'=>1));
			
			$query = $this->db->get();
			$data['items'] = $query->result();
			
			$this->db->select()->from('AUCTION_ITEM_CATEGORY')
			->where(array('AUCTION_ITEM_CATEGORY.AIC_STATUS'=>1));
			$query = $this->db->get();
			$data['saree'] = $query->result();
			
			$data['name'] = $_POST['name'];
			$data['number'] = $_POST['number'];
			$data['email'] = @$_POST['email'];
			$data['price'] = $_POST['price'];
			
			//From table auction item table selected item combobox
			$data['item'] = explode( "|", $_POST['item']);
			$AI_ID = $data['item'][0];
			$AI_NAME = $data['item'][1];
			$AI_PREFIX = $data['item'][2];
			$AI_STATUS = $data['item'][3];
			$AI_COUNTER = $data['item'][4];
			$USER_ID = $data['item'][5];
			
			$data['AI_ID'] = $AI_ID;
			$data['AI_NAME'] = $AI_NAME;
			
			//From table auction category table selected saree for combobox
			$data['itemDetails'] = trim(@$_POST['sareeDetails']);
			
			$data['sareeFor'] = explode( "|", $_POST['sareeFor']);
			$AIC_ID = @$data['sareeFor'][0];
			$AIC_NAME = @$data['sareeFor'][1];
			$AIC_STATUS = @$data['sareeFor'][3];
			
			$data['AIC_ID'] = $AIC_ID;
			$data['AIC_NAME'] = $AIC_NAME;
			
			$sevaDate = @$_POST['sevadate'];
			$data['sevadate'] = @$_POST['sevadate'];
			$data['address'] = trim(@$_POST['address']);
			
			$todayDate = date('d-m-Y');
			$dateTime = date('d-m-Y H:i:s A');
			
			if($AI_ID != 2) { 
				$date = "";
			} else 
				$date = $todayDate;
			
			$refNo = $AI_PREFIX. "-".++$AI_COUNTER;
			$data['refNo'] = $refNo;
			$addAuctionItems = array(
				"AIL_NAME"=>$data['name'],
				"AIL_NUMBER"=>$data['number'],
				"AIL_EMAIL"=>$data['email'],
				"AIL_ADDRESS"=>$data['address'],
				"AIL_EVENT_NAME"=>$data['event']['ET_NAME'],
				"AIL_EVENT_ID"=>$data['event']['ET_ID'],
				"ITEM_REF_NO"=>$refNo,
				"AIL_ITEM_STATUS"=>$AI_STATUS,
				"AIL_ITEM_ID"=>$AI_ID,
				"AIL_ITEM_NAME"=>$AI_NAME,
				"AIL_AIC_ID"=>$AIC_ID,
				"AIL_AIC_NAME"=>$AIC_NAME,
				"AIC_SEVA_DATE"=>$sevaDate,
				"AIL_ITEM_DETAILS"=>$data['itemDetails'],
				"AIL_ITEM_PRICE"=>$data['price'],
				"USER_ID"=>$_SESSION['userId'],
				"DATE_TIME"=>$dateTime,
				"DATE"=>$todayDate);
			
			$insertId = $this->obj_auction->add_auction_modal("AUCTION_ITEM_LIST", $addAuctionItems);
			
			if($insertId != "") {
				$condition = array('AI_ID'=>$AI_ID);
				$updateActionItem = array('AI_COUNTER'=>$AI_COUNTER);
				$this->obj_auction->update_auction_model("AUCTION_ITEM", $condition, $updateActionItem);
			}
			
		
			$this->load->view('header',$data);
			$this->load->view('auction/auction_item_details');
			$this->load->view('footer_home');
		}
	}
