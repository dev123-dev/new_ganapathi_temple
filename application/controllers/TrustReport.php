<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TrustReport extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Events_modal','obj_events',true);
		$this->load->model('TrustReport_model','obj_report',true);	
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		$this->load->model('TrustEvents_modal','obj_trust_events',true);
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
	
	    //FOR AUCTION REPORT EXCEL
	    function event_auction_report_excel() {
		//For Menu Selection
		$data['whichTab'] = "trustAuction";
		
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
		
		$header = "";
		$result = "";
		$filename = "Saree_Outward_Report_".$date;  //File Name
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
		$header .= "SRI LAKSHMI VENKATESH TEMPLE" . "\n\n";		
		$header .= "SI NO." . "\t";
		$header .= "NAME" . "\t";
		$header .= "CATEGORY" . "\t";
		$header .= "PHONE" . "\t";
		$header .= "REFERENCE NO." . "\t";
		$header .= "SAREE DETAILS" . "\t";
		
		$conditionOne = array('AIC_SEVA_DATE' => $date);
		$res = $this->obj_report->get_auction_item_reports($conditionOne);
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$line = '';    
			$value = "";			
			$value .= '"' . ($i+1) . '"' . "\t";
			$value .= '"' . $res[$i]->AIL_NAME . '"' . "\t";
			$value .= '"' . $res[$i]->AIL_AIC_NAME . '"' . "\t";
			$value .= '"' . $res[$i]->AIL_NUMBER . '"' . "\t";
			$value .= '"' . $res[$i]->ITEM_REF_NO . '"' . "\t";
			$value .= '"' . $res[$i]->AIL_ITEM_DETAILS . '"' . "\t";
				
			$line .= $value;
			$result .= trim($line) . "\n";
		}
		$result = str_replace( "\r" , "" , $result );
		   
		print("$header\n$result"); 
	    }
	    //FOR AUCTION REPORT EXCEL
	    function auction_report_excel() {
		//For Menu Selection
		$data['whichTab'] = "trustAuction";
		
		if(@$_POST['paymentMethod']) {
			unset($_SESSION['paymentMethod']);
			$data['PMode'] = $this->input->post('payMode');
			$paymentMode = $this->input->post('payMode');
		}
		
		if(@$_SESSION['paymentMethod'] == "") {
			$this->session->set_userdata('paymentMethod', $this->input->post('payMode'));
			$data['PMode'] = $_SESSION['paymentMethod'];
			$paymentMode = $this->input->post('payMode');
		} else {
			$paymentMode = $_SESSION['paymentMethod'];
			$data['PMode'] = $_SESSION['paymentMethod'];
		}
		
		if($paymentMode == "All") {
			$conditionOne = array();
			$res = $this->obj_report->get_auction_report_excel($conditionOne);
		} else {
			$conditionOne = array('AR_PAYMENT_MODE' => $paymentMode);
			$res = $this->obj_report->get_auction_report_excel($conditionOne);
		}
		
		$header = "";
		$result = "";
		$filename = "Auction_Report_".date('d-m-y');  //File Name
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
		$header .= "SRI LAKSHMI VENKATESH TEMPLE" . "\n\n";		
		$header .= "SI NO." . "\t";
		$header .= "BID REF. NO." . "\t";
		$header .= "ITEM REF. NO." . "\t";
		$header .= "ITEM DETAILS" . "\t";
		$header .= "BIDDER DETAILS" . "\t";
		$header .= "PAYMENT MODE" . "\t";
		$header .= "BID PRICE" . "\t";
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$line = '';    
			$value = "";			
			$value .= '"' . ($i+1) . '"' . "\t";
			$value .= '"' . $res[$i]->BID_REF_NO . '"' . "\t";
			$value .= '"' . $res[$i]->ITEM_REF_NO . '"' . "\t";
			$value .= '"' . $res[$i]->AR_ITEM_DETAILS . '"' . "\t";
			$value .= '"' . $res[$i]->BIL_ITEM_DETAILS . '"' . "\t";
			$value .= '"' . $res[$i]->AR_PAYMENT_MODE . '"' . "\t";
			$value .= '"' . $res[$i]->AR_BID_PRICE . '"' . "\t";
				
			$line .= $value;
			$result .= trim($line) . "\n";
		}
		$result = str_replace( "\r" , "" , $result );
		   
		print("$header\n$result"); 
	    }
	    //FOR DATEFIELD AUCTION REPORT
	    function get_change_datefield($start = 0) {
		//For Menu Selection
		$data['whichTab'] = "auction";
		$conditionTwo = array('TRUST_EVENT.TET_ACTIVE' => 1); 
		$data['activeDate'] = $this->obj_admin_settings->get_trust_all_field_event($conditionTwo);
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
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		
		$conditionOne = array('AIC_SEVA_DATE' => $date);
		$data['auction_item_report'] = $this->obj_report->get_all_field_auction_item_report($conditionOne,'AIL_AIC_ID','', 10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/get_change_datefield';
		$config['total_rows'] = $this->obj_report->count_rows_auction_item_report($conditionOne);
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
		$this->load->view('trust/auction/saree_outward_report');
		$this->load->view('footer_home');
	    }
	    //FOR AUCTION REPORT
	    function saree_outward_report($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');

		//Unset Session
		unset($_SESSION['date']);
		$conditionTwo = array('TRUST_EVENT.TET_ACTIVE' => 1); 
		$data['activeDate'] = $this->obj_admin_settings->get_trust_all_field_event($conditionTwo);
		//For Menu Selection
		$data['whichTab'] = "trustAuction";
		$data['date'] = date('d-m-Y');
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		
		$conditionOne = array('AIC_SEVA_DATE' => date('d-m-Y'));
		$data['auction_item_report'] = $this->obj_report->get_all_field_auction_item_report($conditionOne,'AIL_AIC_ID','', 10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/saree_outward_report';
		$config['total_rows'] = $this->obj_report->count_rows_auction_item_report($conditionOne);
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
		
		if(isset($_SESSION['Saree_Outward_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/auction/saree_outward_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	    }
	    //FOR AUCTION REPORT ON MODE CHANGE
	    function auction_report_payment_mode($start = 0) {
		//For Menu Selection
		$data['whichTab'] = "trustAuction";
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		
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
		
		if($paymentMode == "All") {
			$conditionOne = array();
			$data['auction_report'] = $this->obj_report->get_auction_report($conditionOne,'','', 10,$start);
		} else {
			$conditionOne = array('AR_PAYMENT_MODE' => $paymentMode);
			$data['auction_report'] = $this->obj_report->get_auction_report($conditionOne,'','', 10,$start);
		}

		//FOR PRICE DISPLAY IN COMBOBOX
		$condt = array();
		$condt1 = array('AR_PAYMENT_MODE' => 'Cash');
		$condt2 = array('AR_PAYMENT_MODE' => 'Cheque');
		$condt3 = array('AR_PAYMENT_MODE' => 'Credit / Debit Card');
		$condt4 = array('AR_PAYMENT_MODE' => 'Direct Credit');
		
		$data['All'] = $this->obj_report->get_total_amount_payment_mode($condt);
		$data['Cash'] = $this->obj_report->get_total_amount_payment_mode($condt1);
		$data['Cheque'] = $this->obj_report->get_total_amount_payment_mode($condt2);
		$data['Credit_Debit'] = $this->obj_report->get_total_amount_payment_mode($condt3);
		$data['Direct'] = $this->obj_report->get_total_amount_payment_mode($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/auction_report_payment_mode';
		$config['total_rows'] = $this->obj_report->count_rows_auction_report($conditionOne);
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
		$this->load->view('trust/auction/auction_report');
		$this->load->view('footer_home');
	    }
	    //FOR AUCTION REPORT
	    function auction_report($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');

		//UNSET SESSION
		unset($_SESSION['paymentMethod']);
		
		//For Menu Selection
		$data['whichTab'] = "trustAuction";
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		
		$conditionOne = array();
		$data['auction_report'] = $this->obj_report->get_auction_report($conditionOne,'','', 10,$start);
		
		//FOR PRICE DISPLAY IN COMBOBOX
		$condt = array();
		$condt1 = array('AR_PAYMENT_MODE' => 'Cash');
		$condt2 = array('AR_PAYMENT_MODE' => 'Cheque');
		$condt3 = array('AR_PAYMENT_MODE' => 'Credit / Debit Card');
		$condt4 = array('AR_PAYMENT_MODE' => 'Direct Credit');
		
		$data['All'] = $this->obj_report->get_total_amount_payment_mode($condt);
		$data['Cash'] = $this->obj_report->get_total_amount_payment_mode($condt1);
		$data['Cheque'] = $this->obj_report->get_total_amount_payment_mode($condt2);
		$data['Credit_Debit'] = $this->obj_report->get_total_amount_payment_mode($condt3);
		$data['Direct'] = $this->obj_report->get_total_amount_payment_mode($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/auction_report';
		$config['total_rows'] = $this->obj_report->count_rows_auction_report($conditionOne);
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
		
		if(isset($_SESSION['Auction_Item_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/auction/auction_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	    }
	    //TRUST RECEIPT REPORT
	    function trust_receipt_report($start = 0) {
		//Radio Option
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		
		//Unset Session
		unset($_SESSION['date']);
		unset($_SESSION['financialHeadId']);
		unset($_SESSION['paymentMethod']);
		
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		$data['date'] = date('d-m-Y');
		
		$condition = array('FH_ACTIVE' => 1);
		$data['financialHead'] = $this->obj_report->get_all_field_financial_head($condition);
		
		$conditionOne = array('RECEIPT_DATE' => date('d-m-Y'),'TR_ACTIVE' => 1);
		$data['trust_receipt_report'] = $this->obj_report->get_all_field_trust_receipt_report($conditionOne,'','', 10,$start);
		
		$conditionTwo = array('RECEIPT_DATE' => date('d-m-Y'),'TR_ACTIVE' => 1);
		$data['TotalAmount'] = $this->obj_report->get_all_amount_trust($conditionTwo);
		
		//For Count
		$data['Count'] = $this->obj_report->count_rows_trust_receipt_report($conditionOne);
		
		//FOR PRICE IN COMBOBOX
		$condt = array('RECEIPT_DATE' => date('d-m-Y'),'TR_ACTIVE' => 1);
		$data['All'] = $this->obj_report->get_total_amount_trust($condt);
		$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash' ,'RECEIPT_DATE' => date('d-m-Y'),'TR_ACTIVE' => 1);
		$data['Cash'] = $this->obj_report->get_total_amount_trust($condt1);
		$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque' ,'RECEIPT_DATE' => date('d-m-Y'),'TR_ACTIVE' => 1);
		$data['Cheque'] = $this->obj_report->get_total_amount_trust($condt2);
		$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card' ,'RECEIPT_DATE' => date('d-m-Y'),'TR_ACTIVE' => 1);
		$data['Credit_Debit'] = $this->obj_report->get_total_amount_trust($condt3);
		$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit' ,'RECEIPT_DATE' => date('d-m-Y'),'TR_ACTIVE' => 1);
		$data['Direct'] = $this->obj_report->get_total_amount_trust($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/trust_receipt_report';
		$config['total_rows'] = $this->obj_report->count_rows_trust_receipt_report($conditionOne);
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
		
		if(isset($_SESSION['Trust_Receipt_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trust_receipt_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	    }
	    //EVENT SEVA SUMMARY
	    function summary_sevas_on_event() {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;

		$this->db->select('*')->from('trust_event');
		$this->db->where('TET_ACTIVE',1);
		$query = $this->db->get();
		$etId= $query->result('array');
		$eId = $etId[0]['TET_ID'];
		
		//For Menu Selection
		$data['whichTab'] = "report";
		$data['date'] = date('d-m-Y');
		
		//Radio Option
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		
		$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary(date('d-m-Y'),$eId);
		
		if(isset($_SESSION['Event_Seva_Summary'])) {
			$this->load->view('header', $data);
			$this->load->view('Trust/summary_sevas_on_event');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	    }
	    //FOR DISPLAY EVENT SEVA DETAILS
		function event_sevas_summary_details($start=0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link3'] = $actual_link;
			
			$this->db->select('*')->from('trust_event');
			$this->db->where('TET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['TET_ID'];
			
			//For Menu Selection
			$data['whichTab'] = "report";
			if(@$_POST['refresh'] == "") {			
				//Radio Option
				if(isset($_POST['radioOpt'])) {
					$radioOpt = @$_POST['radioOpt'];
					$_SESSION['radioOpt'] = $radioOpt;
				} else {
					$radioOpt = $_SESSION['radioOpt'];
				}
				
				$data['radioOpt'] = $radioOpt;
				
				if(isset($_POST['fromDates'])) {
					$fromDate = @$_POST['fromDates'];
					$toDate = @$_POST['toDates'];
					$_SESSION['fromDates'] = $fromDate;
					$_SESSION['toDates'] = $toDate;
				} else {
					$fromDate = $_SESSION['fromDates'];
					$toDate = $_SESSION['toDates'];
				}
				
				$data['fromDate'] = $fromDate;
				$data['toDate'] = $toDate;
			}  else {
				$_SESSION['radioOpt'] = "date";
				unset($_SESSION['fromDates']);
				unset($_SESSION['toDates']);
				$data['radioOpt'] = "date";
				$radioOpt = "date";
				$_POST['tdate'] = date('d-m-Y');
			}
			
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
			
			if(@$_POST['sevaId']) {
				unset($_SESSION['sevaId']);
				$data['sevaId'] = $this->input->post('sevaId');
				$sevaId = $this->input->post('sevaId');
			}
			
			if(@$_SESSION['sevaId'] == "") {
				$this->session->set_userdata('sevaId', $this->input->post('sevaId'));
				$data['sevaId'] = $_SESSION['sevaId'];
				$sevaId = $this->input->post('sevaId');
			} else {
				$sevaId = $_SESSION['sevaId'];
				$data['sevaId'] = $_SESSION['sevaId'];
			}
			
			if(@$_POST['sevaName']) {
				unset($_SESSION['sevaName']);
				$data['sevaName'] = $this->input->post('sevaName');
				$sevaName = $this->input->post('sevaName');
			}
			
			if(@$_SESSION['sevaName'] == "") {
				$this->session->set_userdata('sevaName', $this->input->post('sevaName'));
				$data['sevaName'] = $_SESSION['sevaName'];
				$sevaName = $this->input->post('sevaName');
			} else {
				$sevaName = $_SESSION['sevaName'];
				$data['sevaName'] = $_SESSION['sevaName'];
			}
			
			if(@$radioOpt == "multiDate") {
				$data['Count'] = $this->obj_report->count_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,$eId);
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,10,$start,$eId);
			} else {
				$data['fromDate'] = "";
				$data['toDate'] = "";
				$data['Count'] = $this->obj_report->count_event_sevas_summary_details($date,$sevaId,$eId);
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_details($date,$sevaId,10,$start,$eId);
			}
			//print_r($data['report_details']);
			//pagination starts
			$this->load->library('pagination');
			if(@$radioOpt == "multiDate") {
				$config['base_url'] = base_url().'TrustReport/get_filter_change_sevas_details';
				$config['total_rows'] = $this->obj_report->count_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,$eId);
			} else {
				$config['base_url'] = base_url().'TrustReport/event_sevas_summary_details';
				$config['total_rows'] = $this->obj_report->count_event_sevas_summary_details($date,$sevaId,$eId);
			}
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
			
			if(isset($_SESSION['Event_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('Trust/event_sevas_summary_details');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		//FOR EVENT SEVA SUMMARY FILTER
		function get_filter_change_event() {
	
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$this->db->select('*')->from('trust_event');
			$this->db->where('TET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['TET_ID'];
			
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = @$_SESSION['fromDates'];
				$toDate = @$_SESSION['toDates'];
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
			
			if(@$radioOpt == "multiDate") {
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_report_period($fromDate,$toDate,$eId);
			} else {
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary($date,$eId);
			}
			
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Event_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('Trust/summary_sevas_on_event');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		
		}
	//DEITY RECEIPT REPORT ON CHANGE OF FIELD
	function trust_report_on_change_date($start = 0) {
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		
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
		
		if(@$_POST['financialHeadId']) {
			unset($_SESSION['financialHeadId']);
			$financialHeadId = $this->input->post('financialHead');
			$data['financialHeadId'] = $financialHeadId;
		}
		
		if(@$_SESSION['financialHeadId'] == "") {
			$this->session->set_userdata('financialHeadId', $this->input->post('financialHead'));
			$data['financialHeadId'] = $_SESSION['financialHeadId'];
			$financialHeadId = $this->input->post('financialHead');
		} else {
			$financialHeadId = $_SESSION['financialHeadId'];
			$data['financialHeadId'] = $_SESSION['financialHeadId'];
		}
		
		$condition = array('FH_ACTIVE' => 1);
		$data['financialHead'] = $this->obj_report->get_all_field_financial_head($condition);
		if(@$paymentMode != 'All' || @$financialHeadId != "All Financial Head") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						if(@$paymentMode != 'All' && @$financialHeadId != "All Financial Head") {
							$queryString .= " (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and TR_ACTIVE = 1)";
							$queryString1 .= " (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and TR_ACTIVE = 1)";
						} else if(@$paymentMode != 'All') {
							$queryString .= " (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and TR_ACTIVE = 1)";
							$queryString1 .= " (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and TR_ACTIVE = 1)";
						} else if(@$financialHeadId != "All Financial Head") {
							$queryString .= " (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and TR_ACTIVE = 1)";
							$queryString1 .= " (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and TR_ACTIVE = 1)";
						}	
					} else {
						if(@$paymentMode != 'All' && @$financialHeadId != "All Financial Head")  {
							$queryString .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and TR_ACTIVE = 1)";
							$queryString1 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and TR_ACTIVE = 1)";
						} else if(@$paymentMode != 'All') {
							$queryString .= " or (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and TR_ACTIVE = 1)";
							$queryString1 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and TR_ACTIVE = 1)";
						} else if(@$financialHeadId != "All Financial Head") {
							$queryString .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and TR_ACTIVE = 1)";
							$queryString1 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and TR_ACTIVE = 1)";
						}
					}
				}
				$conditionOne = $queryString;
				$conditionTwo = $queryString1;
			} else {
				if(@$paymentMode != 'All' && @$financialHeadId != "All Financial Head") {
					$conditionOne = array('TRUST_RECEIPT.FH_ID' => $financialHeadId,'RECEIPT_PAYMENT_METHOD' => $paymentMode,'RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$conditionTwo = array('TRUST_RECEIPT.FH_ID' => $financialHeadId,'RECEIPT_PAYMENT_METHOD' => $paymentMode,'RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
				} else if(@$paymentMode != 'All') {
					$conditionOne = array('RECEIPT_PAYMENT_METHOD' => $paymentMode,'RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$conditionTwo = array('RECEIPT_PAYMENT_METHOD' => $paymentMode,'RECEIPT_DATE' => $date,'TR_ACTIVE' =>1);
				} else if(@$financialHeadId != "All Financial Head") {
					$conditionOne = array('TRUST_RECEIPT.FH_ID' => $financialHeadId,'RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$conditionTwo = array('TRUST_RECEIPT.FH_ID' => $financialHeadId,'RECEIPT_DATE' => $date,'TR_ACTIVE' =>1);
				}
			}
			
			$data['trust_receipt_report'] = $this->obj_report->get_all_field_trust_receipt_report($conditionOne,'','', 10,$start);
			//For Count
			$data['Count'] = $this->obj_report->count_rows_trust_receipt_report($conditionOne);
			
			//FOR PRICE DISPLAY IN COMBOBOX
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				$queryString2 = "";
				$queryString3 = "";
				$queryString4 = "";
				
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						if(@$paymentMode != 'All' && @$financialHeadId != "All Financial Head") {
							$queryString .= " (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and TR_ACTIVE = 1)";
							$queryString1 .= " (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='Cash' and TR_ACTIVE = 1)";
							$queryString2 .= " (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='Cheque' and TR_ACTIVE = 1)";
							$queryString3 .= " (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and TR_ACTIVE = 1)";
							$queryString4 .= " (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='Direct Credit' and TR_ACTIVE = 1)";
						} else {
							$queryString .= " (RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1)";
							$queryString1 .= " (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cash' and TR_ACTIVE = 1)";
							$queryString2 .= " (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cheque' and TR_ACTIVE = 1)";
							$queryString3 .= " (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and TR_ACTIVE = 1)";
							$queryString4 .= " (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Direct Credit' and TR_ACTIVE = 1)";
						}
					} else {
						if(@$paymentMode != 'All' && @$financialHeadId != "All Financial Head") {
							$queryString .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and TR_ACTIVE = 1)";
							$queryString1 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='Cash' and TR_ACTIVE = 1)";
							$queryString2 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='Cheque' and TR_ACTIVE = 1)";
							$queryString3 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and TR_ACTIVE = 1)";
							$queryString4 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TRUST_RECEIPT.FH_ID = ".$financialHeadId." and RECEIPT_PAYMENT_METHOD='Direct Credit' and TR_ACTIVE = 1)";
						} else {
							$queryString .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1)";
							$queryString1 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cash' and TR_ACTIVE = 1)";
							$queryString2 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cheque' and TR_ACTIVE = 1)";
							$queryString3 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and TR_ACTIVE = 1)";
							$queryString4 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Direct Credit' and TR_ACTIVE = 1)";
						}
					}
				}
				$condt = $queryString;
				$condt1 = $queryString1;
				$condt2 = $queryString2;
				$condt3 = $queryString3;
				$condt4 = $queryString4;
			} else {
				if(@$paymentMode != 'All' && @$financialHeadId != "All Financial Head") {
					$condt = array('TRUST_RECEIPT.FH_ID' => $financialHeadId , 'RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$condt1 = array('TRUST_RECEIPT.FH_ID' => $financialHeadId ,'RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$condt2 = array('TRUST_RECEIPT.FH_ID' => $financialHeadId ,'RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$condt3 = array('TRUST_RECEIPT.FH_ID' => $financialHeadId ,'RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$condt4 = array('TRUST_RECEIPT.FH_ID' => $financialHeadId ,'RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
				} else {
					$condt = array('RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
					$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_DATE' => $date,'TR_ACTIVE' =>1);
				}
			}
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= " (RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1)";
						$queryString1 .= " (RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1)";
					} else {
						$queryString .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1)";
						$queryString1 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1)";
					}
				}
				$conditionOne = $queryString;
				$conditionTwo = $queryString1;
			} else {
				$conditionOne = array('RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
				$conditionTwo = array('RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
			}
			// print_r($conditionOne);
			$data['trust_receipt_report'] = $this->obj_report->get_all_field_trust_receipt_report($conditionOne,'','', 10,$start);
			//For Count
			$data['Count'] = $this->obj_report->count_rows_trust_receipt_report($conditionOne);
			
			//FOR PRICE DISPLAY IN COMBOBOX
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				$queryString2 = "";
				$queryString3 = "";
				$queryString4 = "";
				
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= " (RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1)";
						$queryString1 .= " (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cash' and TR_ACTIVE = 1)";
						$queryString2 .= " (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cheque' and TR_ACTIVE = 1)";
						$queryString3 .= " (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and TR_ACTIVE = 1)";
						$queryString4 .= " (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Direct Credit' and TR_ACTIVE = 1)";
					} else {
						$queryString .= " or (RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1)";
						$queryString1 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cash' and TR_ACTIVE = 1)";
						$queryString2 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cheque' and TR_ACTIVE = 1)";
						$queryString3 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and TR_ACTIVE = 1)";
						$queryString4 .= " or (RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Direct Credit' and TR_ACTIVE = 1)";
					}
				}
				$condt = $queryString;
				$condt1 = $queryString1;
				$condt2 = $queryString2;
				$condt3 = $queryString3;
				$condt4 = $queryString4;
			} else {
				//FOR PRICE DISPLAY IN COMBOBOX
				$condt = array('RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
				$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_DATE' => $date,'TR_ACTIVE'=>1);
				$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
				$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_DATE' => $date,'TR_ACTIVE' => 1);
				$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_DATE' => $date,'TR_ACTIVE'=>1);
			}
		}
		
		$data['All'] = $this->obj_report->get_total_amount_trust($condt);
		$data['Cash'] = $this->obj_report->get_total_amount_trust($condt1);
		$data['Cheque'] = $this->obj_report->get_total_amount_trust($condt2);
		$data['Credit_Debit'] = $this->obj_report->get_total_amount_trust($condt3);
		$data['Direct'] = $this->obj_report->get_total_amount_trust($condt4);
		
		$data['TotalAmount'] = $this->obj_report->get_all_amount_trust($conditionTwo);
		//$this->output->enable_profiler(true);
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/trust_report_on_change_date';
		$config['total_rows'] = $this->obj_report->count_rows_trust_receipt_report($conditionOne);
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
		
		if(isset($_SESSION['Trust_Receipt_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trust_receipt_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//DISPLAY IN POPUP FOR CHEQUE AND CREDIT/DEBIT CARD
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
	
	//DISPLAY IN POPUP FOR CANCELLED
	function ViewCancelled(){
		$cancelled = $this->input->post('cancelNotes');
		echo "<h6 style='font-size:16px; line-height:16px;'><b>Cancelled Notes : </b> ".str_replace("'","\'",$cancelled)."</h6>" ;   
	}
	
	//FOR EXCEL FOR TRUST RECEIPT
	function trust_receipt_report_excel() {
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}

		if(isset($_POST['allDates'])) {
			$allDates = @$_POST['allDates'];
		} else {
			$allDates = $_SESSION['allDates'];
		}
		
		$header = "";
		$result = ""; 
		// $result .= "\n"; 
		if(@$radioOpt == "multiDate")
			$filename = "Trust_Receipt_Report_from ".$_SESSION['fromDate']." to ".$_SESSION['toDate'];  //File Name
		else
			$filename = "Trust_Receipt_Report_".$_POST['dateField'];  //File Name
		
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
		$header .= $templename[0]["TRUST_NAME"]. "\n\n";
		$header .= "SI NO." . "\t";
		$header .= "RECEIPT NO." . "\t";
		$header .= "TYPE" . "\t";
		$header .= "BOOKING NO." . "\t";
		$header .= "RECEIPT DATE" . "\t";
		$header .= "RECEIPT TYPE" . "\t";
		$header .= "NAME" . "\t";
		$header .= "PAYMENT MODE" . "\t";
		$header .= "AMOUNT" . "\t";
		$header .= "PAYMENT STATUS" . "\t";
		$header .= "ESTIMATED AMT" . "\t";
		$header .= "DESC" . "\t";
		$header .= "QUANTITY" . "\t";
		$header .= "PAYMENT NOTES" . "\t";
		$header .= "AUTHORIZED STATUS" . "\t";
		
		if($_POST['dateField'] != "" && $_POST['payMode'] == "All") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 0"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 0"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('RECEIPT_DATE' => $_POST['dateField'],'TR_ACTIVE' => 1); //'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
				$conditionOne= array('RECEIPT_DATE' => $_POST['dateField'],'TR_ACTIVE' => 0); //'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
			}
			$res = $this->obj_report->get_all_field_trust_receipt_excel($condition);
			$res1 = $this->obj_report->get_all_field_trust_receipt_excel($conditionOne);
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and TR_ACTIVE = 1"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and TR_ACTIVE = 0"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and TR_ACTIVE = 1"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and TR_ACTIVE = 0"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'RECEIPT_DATE' => $_POST['dateField'],'TR_ACTIVE'=>1); //'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
				$conditionOne= array('RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'RECEIPT_DATE' => $_POST['dateField'],'TR_ACTIVE'=>0); //'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
			}
			$res = $this->obj_report->get_all_field_trust_receipt_excel($condition);
			$res1 = $this->obj_report->get_all_field_trust_receipt_excel($conditionOne);
		}
			
		for($i = 0; $i < sizeof($res); $i++)
		{
			$line = '';    
			$value = "";	
			$value .= '"' . ($i+1) . '"' . "\t";
			$value .= '"' . $res[$i]->TR_NO . '"' . "\t";
			if($res[$i]->RECEIPT_CATEGORY_ID==1){
				$value .= '"Inkind"' . "\t";
			}else{
				$value .= '"Trust Receipt"' . "\t";
			}
			
			$value .= '"' . $res[$i]->HB_NO . '"' . "\t";
			$value .= '"' . $res[$i]->RECEIPT_DATE . '"' . "\t";
			$value .= '"' . $res[$i]->FH_NAME . '"' . "\t";
			$value .= '"' . $res[$i]->RECEIPT_NAME . '"' . "\t";
			$value .= '"' . $res[$i]->RECEIPT_PAYMENT_METHOD . '"' . "\t";
			$value .= '"' . $res[$i]->FH_AMOUNT . '"' . "\t";
			$value .= '"' . $res[$i]->PAYMENT_STATUS . '"' . "\t";
			$value .= '"' . $res[$i]->IK_APPRX_AMT . '"' . "\t";
			$value .= '"' . $res[$i]->IK_ITEM_DESC . '"' . "\t";
			$value .= '"' . $res[$i]->IK_ITEM_QTY . '"' . $res[$i]->IK_ITEM_UNIT . '"' . "\t";
			$value .= '"' . $res[$i]->TR_PAYMENT_METHOD_NOTES . '"' . "\t";
			$value .= '"' . $res[$i]->AUTHORISED_STATUS . '"' . "\t";
				
			$line .= $value;
			$result .= trim($line) . "\n";
		}
		$result .= "\n";
		
		$result .= "Cancelled Receipt:";
		
		$result .= "\n";
		
		$result .= "SI NO." . "\t";
		$result .= "RECEIPT NO." . "\t";
		$result .= "BOOKING NO." . "\t";
		$result .= "RECEIPT DATE" . "\t";
		$result .= "RECEIPT TYPE" . "\t";
		$result .= "NAME" . "\t";
		$result .= "PAYMENT MODE" . "\t";
		$result .= "AMOUNT" . "\t";	
		$result .= "PAYMENT STATUS" . "\t";	
		$result .= "\n";
		
		for($i = 0; $i < sizeof($res1); $i++)
		{
			$line = '';    
			$value = "";		
			$value .= '"' . ($i+1) . '"' . "\t";
			$value .= '"' . $res1[$i]->TR_NO . '"' . "\t";
			$value .= '"' . $res1[$i]->HB_NO . '"' . "\t";
			$value .= '"' . $res1[$i]->RECEIPT_DATE . '"' . "\t";
			$value .= '"' . $res1[$i]->FH_NAME . '"' . "\t";
			$value .= '"' . $res1[$i]->RECEIPT_NAME . '"' . "\t";
			$value .= '"' . $res1[$i]->RECEIPT_PAYMENT_METHOD . '"' . "\t";
			$value .= '"' . $res1[$i]->FH_AMOUNT . '"' . "\t";
			$value .= '"' . $res1[$i]->PAYMENT_STATUS . '"' . "\t";
				
			$line .= $value;
			$result .= trim($line) . "\n";
		}
		
		$result = str_replace( "\r" , "" , $result );
		   
		print("$header\n$result"); 
	}
	
	//TRUST MIS REPORT
	function trust_mis_report() {
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		$data['date'] = date('d-m-Y');
			
		//Radio Option
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		
		$data['report_details'] = $this->obj_report->get_all_field_mis_report(date('d-m-Y'));
		$data['inkind_report_details'] = $this->obj_report->get_all_field_mis_report_inkind(date('d-m-Y'));
			
		if(isset($_SESSION['Trust_MIS_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trust_mis_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//TRUST MIS FILTER CHANGE
	function get_filter_change() {
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDates'])) {
			$fromDate = @$_POST['fromDates'];
			$toDate = @$_POST['toDates'];
			$_SESSION['fromDates'] = $fromDate;
			$_SESSION['toDates'] = $toDate;
		} else {
			$fromDate = @$_SESSION['fromDates'];
			$toDate = @$_SESSION['toDates'];
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
		
		if(@$radioOpt == "multiDate") {
			$data['report_details'] = $this->obj_report->get_all_field_mis_report_period($fromDate,$toDate);
			$data['inkind_report_details'] = $this->obj_report->get_all_field_mis_report_period_inkind($fromDate,$toDate);
		} else {
			$data['report_details'] = $this->obj_report->get_all_field_mis_report($date);
			$data['inkind_report_details'] = $this->obj_report->get_all_field_mis_report_inkind($date);
		}
		
		if(isset($_SESSION['Trust_MIS_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trust_mis_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//FOR EXCEL FOR TRUST MIS REPORT
	function trust_mis_report_excel() {
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		
		if(isset($_POST['fromDates'])) {
			$fromDate = @$_POST['fromDates'];
			$toDate = @$_POST['toDates'];
			$_SESSION['fromDates'] = $fromDate;
			$_SESSION['toDates'] = $toDate;
		} else {
			$fromDate = $_SESSION['fromDates'];
			$toDate = $_SESSION['toDates'];
		}
		
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
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_mis_report_period($fromDate,$toDate);
			$res_inkind = $this->obj_report->get_all_field_mis_report_period_inkind($fromDate,$toDate);
		} else {
			$res = $this->obj_report->get_all_field_mis_report($date);
			$res_inkind = $this->obj_report->get_all_field_mis_report_inkind($date);

		}
		
		$header = "";
		$result = "";
		
		if(@$radioOpt == "multiDate")
			$filename = "Trust_MIS_Report_from ".$fromDate." to ".$toDate;  //File Name
		else
			$filename = "Trust_MIS_Report_".$_POST['dateField'];  //File Name
		
		$file_ending = "xls";
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		//header info for browser
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$sep = "\t"; //tabbed character
		
		$header .= "\t";
		$header .= $templename[0]["TRUST_NAME"]. "\n\n";
		$header .= "SI NO." . "\t";
		$header .= "FINANCIAL HEAD" . "\t";
		$header .= "QUANTITY" . "\t";
		$header .= "AMOUNT" . "\t";
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$line = '';    
			$value = "";			
			$value .= ($i+1). "\t";
			$value .= '"' . $res[$i]['FH_NAME'] . '"' . "\t";
			$value .= '"' . $res[$i]['QTY'] . '"' . "\t";
			$value .= '"' . $res[$i]['PRICE'] . '"' . "\t";
			
			$line .= $value;
			$result .= trim($line) . "\n";
		}
		$result = str_replace( "\r" , "" , $result ). "\n";
		
		$line = '';   
		$value = "";    
		$value .= "\t";
		$value .= "SI NO." . "\t";
		$value .= "RECEIPT NO." . "\t";
		$value .= "NAME" . "\t";
		$value .= "ITEM NAME" . "\t";
		$value .= "QUANTITY" . "\t";
		$line .= $value;
		$result .= trim($line) . "\n";

		for($i = 0; $i < sizeof($res_inkind); $i++)
		{
			$line = '';    
			$value = "";	
			$value .= ($i+1). "\t";		
			$value .= '"' . $res_inkind[$i]['TR_NO'] . '"' . "\t";
			$value .= '"' . $res_inkind[$i]['RECEIPT_NAME'] . '"' . "\t";
			$value .= '"' . $res_inkind[$i]['IK_ITEM_NAME'] . '"' . "\t";
			$value .= '"' . $res_inkind[$i]['amount'] . '"' . $res_inkind[$i]['IK_ITEM_UNIT'] . "\t";
			
			$line .= $value;
			$result .= trim($line) . "\n";
		}
		$result = str_replace( "\r" , "" , $result );

		print("$header\n$result"); 
	}
	
	//HALL BOOKINGS REPORT
	function hall_bookings_report($start = 0) {
		//Radio Option
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		
		//Unset Session
		unset($_SESSION['date']);
		unset($_SESSION['hallId']);
		
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		$data['date'] = date('d-m-Y');
		
		$condition = array('HB_BOOK_DATE' => date('d-m-Y'), 'HBL_ACTIVE' => 1);
		$data['hall_details'] = $this->obj_report->get_all_field_hall_details($condition);
		
		$data['Count'] = $this->obj_report->count_rows_hall_details_booking_list($condition);
		$data['hall_booking_reports'] = $this->obj_report->get_all_field_hall_details_booking_list($condition,'HB_BOOK_DATE','desc',10,$start);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/hall_bookings_report';
		$config['total_rows'] = $this->obj_report->count_rows_hall_details_booking_list($condition);
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
		
		if(isset($_SESSION['Hall_Bookings_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/hall_bookings_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//HALL BOOKING REPORT ON CHANGE OF FIELD
	function hall_booking_report_on_change_date($start = 0) {
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		
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
		
		if(@$_POST['hall']) {
			unset($_SESSION['hallId']);
			$hallId = $this->input->post('hallId');
			$data['hallId'] = $hallId;
		}
		
		if(@$_SESSION['hallId'] == "") {
			$this->session->set_userdata('hallId', $this->input->post('hall'));
			$data['hallId'] = $_SESSION['hallId'];
			$hallId = $this->input->post('hall');
		} else {
			$hallId = $_SESSION['hallId'];
			$data['hallId'] = $_SESSION['hallId'];
		}
		
		if(@$hallId != "All Hall") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "HB_BOOK_DATE='".$allDates1[$i]."' and H_ID = ".$hallId." and HBL_ACTIVE = 1";
						$queryString1 .= "HB_BOOK_DATE='".$allDates1[$i]."' and H_ID = ".$hallId." and HBL_ACTIVE = 1"; 	
					} else {
						$queryString .= " or HB_BOOK_DATE='".$allDates1[$i]."' and H_ID = ".$hallId." and HBL_ACTIVE = 1";
						$queryString1 .= " or HB_BOOK_DATE='".$allDates1[$i]."' and H_ID = ".$hallId." and HBL_ACTIVE = 1";
					}
				}
				$conditionOne = $queryString;
				$conditionTwo = $queryString1;
			} else {
				$conditionOne = array('H_ID' => $hallId,'HB_BOOK_DATE' => $date,'HBL_ACTIVE' => 1);
				$conditionTwo = array('H_ID' => $hallId,'HB_BOOK_DATE' => $date,'HBL_ACTIVE' => 1);
			}
			
			$data['hall_details'] = $this->obj_report->get_all_field_hall_details($conditionTwo);
			$data['hall_booking_reports'] = $this->obj_report->get_all_field_hall_details_booking_list($conditionOne,'HB_BOOK_DATE','desc', 10,$start);
			$data['Count'] = $this->obj_report->count_rows_hall_details_booking_list($conditionOne);
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1";
						$queryString1 .= "HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1";
					} else {
						$queryString .= " or HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1";
						$queryString1 .= " or HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1";
					}
				}
				$conditionOne = $queryString;
				$conditionTwo = $queryString1;
			} else {
				$conditionOne = array('HB_BOOK_DATE' => $date,'HBL_ACTIVE' => 1);
				$conditionTwo = array('HB_BOOK_DATE' => $date,'HBL_ACTIVE' => 1);
			}
			
			$data['hall_details'] = $this->obj_report->get_all_field_hall_details($conditionTwo);
			$data['hall_booking_reports'] = $this->obj_report->get_all_field_hall_details_booking_list($conditionOne,'HB_BOOK_DATE','desc', 10,$start);
			$data['Count'] = $this->obj_report->count_rows_hall_details_booking_list($conditionOne);
		}
	
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/hall_booking_report_on_change_date';
		$config['total_rows'] = $this->obj_report->count_rows_hall_details_booking_list($conditionOne);
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
		
		if(isset($_SESSION['Hall_Bookings_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/hall_bookings_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//HALL BOOKING REPORT EXCEL
	function hall_booking_report_excel() {
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}

		if(isset($_POST['allDates'])) {
			$allDates = @$_POST['allDates'];
		} else {
			$allDates = $_SESSION['allDates'];
		}
		
		if(isset($_POST['hallId'])) {
			$hallId = @$_POST['hallId'];
		} else {
			$hallId = $_SESSION['hallId'];
		}
		
		$header = "";
		$result = ""; 
		// $result .= "\n"; 
		if(@$radioOpt == "multiDate")
			$filename = "Hall_Booking_Report_from ".$_SESSION['fromDate']." to ".$_SESSION['toDate'];  //File Name
		else
			$filename = "Hall_Booking_Report_".$_POST['dateField'];  //File Name
		
		$file_ending = "xls";
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		//header info for browser
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$sep = "\t"; //tabbed character
			
		$header .= "SI NO." . "\t";
		$header .= "NAME" . "\t";
		$header .= "FUNCTION TYPE" . "\t";
		$header .= "BOOKING NO." . "\t";
		$header .= "BOOKING DATE" . "\t";
		$header .= "FROM TIME" . "\t";
		$header .= "TO TIME" . "\t";
		$header .= "HOURS" . "\t";
		
		if($hallId != "All Hall") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1 and H_ID = ".$hallId."";
					} else {
						$queryString .= " or HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1 and H_ID = ".$hallId."";
					}
				}
				$condition= $queryString;
			} else {
				$condition= array('HB_BOOK_DATE' => $_POST['dateField'],'HBL_ACTIVE' => 1,'H_ID' => $hallId);
			}
			$res = $this->obj_report->get_all_field_hall_booking_excel($condition,'HB_BOOK_DATE','desc');
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1"; 
					} else {
						$queryString .= " or HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1"; 
					}
				}
				$condition= $queryString;
			} else {
				$condition= array('HB_BOOK_DATE' => $_POST['dateField'],'HBL_ACTIVE'=>1);
			}
			$res = $this->obj_report->get_all_field_hall_booking_excel($condition,'HB_BOOK_DATE','desc');
		}
		$firstHall = "\t";
		$firstHall .= "\t";
		$firstHall .= $templename[0]["TRUST_NAME"]. "\n\n";		
		$firstHall .= "Hall: ".@$res[0]->H_NAME;
		$name = "";$z = 0;$j = 0;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$line = '';    
			$value = "";
			$fromTime = strtotime($res[$i]->HB_BOOK_TIME_FROM);
			$toTime = strtotime($res[$i]->HB_BOOK_TIME_TO);
			$diff = $toTime - $fromTime;
			$time = $diff; 
			$days = floor($time / (60 * 60 * 24));
			$time -= $days * (60 * 60 * 24);

			$hours = floor($time / (60 * 60));
			$time -= $hours * (60 * 60);

			$minutes = floor($time / 60);
			$time -= $minutes * 60;

			$seconds = floor($time);
			$time -= $seconds;
			
			if($name == $res[$i]->H_NAME) {
				$value .= '"' . ($j+1) . '"' . "\t";
				$value .= '"' . $res[$i]->HB_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->FN_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->HB_NO . '"' . "\t";
				$value .= '"' . $res[$i]->HB_BOOK_DATE . '"' . "\t";
				$value .= '"' . date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_FROM)) . '"' . "\t";
				$value .= '"' . date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_TO)) . '"' . "\t";
				$value .= '"'. $hours."h ".$minutes."m" .'"'. "\t";
					
				$line .= $value;
				$result .= trim($line) . "\n";
			} else {
				$name = $res[$i]->H_NAME;
				if($z != 0) {
					$line .= $value;
					$result .= trim($line) . "\n";
					$value .= '"Hall: ' . $res[$i]->H_NAME . '"' . "\n";
					$value .= "SI NO." . "\t";
					$value .= "NAME" . "\t";
					$value .= "FUNCTION TYPE" . "\t";
					$value .= "BOOKING NO." . "\t";
					$value .= "FROM TIME" . "\t";
					$value .= "To TIME" . "\t";
					$value .= "HOURS" . "\n";
					$j = 0;
				}
				$value .= '"' . ($j+1) . '"' . "\t";
				$value .= '"' . $res[$i]->HB_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->FN_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->HB_NO . '"' . "\t";
				$value .= '"' . $res[$i]->HB_BOOK_DATE . '"' . "\t";
				$value .= '"' . date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_FROM)) . '"' . "\t";
				$value .= '"' . date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_TO)) . '"' . "\t";
				$value .= '"'. $hours."h ".$minutes."m" .'"'. "\t";
					
				$line .= $value;
				$result .= trim($line) . "\n";
				$z++;
			}
			$j++;
		}
		$result .= "\n";
		
		$result = str_replace( "\r" , "" , $result );
		   
		print("$firstHall\n$header\n$result"); 
	}

	//DEITY RECEIPT REPORT ON CHANGE OF FIELD
	function trust_day_book_on_change_date($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		
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
		
		if(@$_SESSION['date'] == "") {
			$this->session->set_userdata('date', $this->input->post('tdate'));
			$data['date'] = $_SESSION['date'];
			$date = $this->input->post('tdate');
		} else {
			$date = $_SESSION['date'];
			$data['date'] = $_SESSION['date'];
		}

		$this->load->library('pagination');
		if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
			$data['trust_day_book'] = $this->obj_report->get_all_field_trust_day_book($_SESSION['fromDate'],$_SESSION['toDate'],'','', 10,$start);
			$data['trust_day_bookTotal'] = $this->obj_report->get_all_field_trust_day_book_account_summary($_SESSION['fromDate'],$_SESSION['toDate'],'','');
			$config['total_rows'] = $this->obj_report->count_all_field_trust_day_book($_SESSION['fromDate'],$_SESSION['toDate']);
		}else {
			$data['trust_day_book'] = $this->obj_report->get_all_field_trust_day_book($_SESSION['date'],'','','', 10,$start);
			$data['trust_day_bookTotal'] = $this->obj_report->get_all_field_trust_day_book_account_summary($_SESSION['date'],'','','');
			$config['total_rows'] = $this->obj_report->count_all_field_trust_day_book($_SESSION['date'],'');

		}
		
		//print_r($data['trust_day_bookTotal']);
		// $this->output->enable_profiler(true);
		//pagination starts
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$config['base_url'] = base_url().'TrustReport/trust_day_book_on_change_date';
		
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
		
		
		if(isset($_SESSION['Trust_Day_Book'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trustDayBook');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	function trust_day_book_excel() {
		$data['whichTab'] = "hallReport";
		if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
			$trust_day_book = $this->obj_report->get_all_field_trust_day_book_excel($_SESSION['fromDate'],$_SESSION['toDate'],'','');
			$trust_day_bookTotal = $this->obj_report->get_all_field_trust_day_book_account_summary($_SESSION['fromDate'],$_SESSION['toDate']);
			$filename = "Trust_Day_Book_from ".$_SESSION['fromDate']. " to ".$_SESSION['toDate']; //File Name
		} else if(@$_SESSION['date']){
			$trust_day_book = $this->obj_report->get_all_field_trust_day_book_excel($_SESSION['date'],'','','');
			$trust_day_bookTotal = $this->obj_report->get_all_field_trust_day_book_account_summary($_SESSION['date'],'');
			$filename = "Trust_Day_Book_".$_SESSION['date']; //File Name
		} else {
			$trust_day_book = $this->obj_report->get_all_field_trust_day_book_excel(date("d-m-Y"),'','','');
			$trust_day_bookTotal = $this->obj_report->get_all_field_trust_day_book_account_summary(date("d-m-Y"),'');
			$filename = "Trust_Day_Book_".date("d-m-Y"); //File Name
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$file_ending = "xls";
	
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$sep = "\t"; //tabbed character
		$header = "";
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= $templename[0]["TRUST_NAME"]. "\n\n";
		$header .= "SI NO." . "\t";
		$header .= "Receipt No." . "\t";
		$header .= "Receipt Date" . "\t";
		$header .= "Receipt For" . "\t";
		$header .= "Receipt Type" . "\t";
		$header .= "Event Seva" . "\t";
		$header .= "Event" . "\t";
		$header .= "Name" . "\t";
		$header .= "Estimated Price" . "\t";
		$header .= "Description" . "\t";
		$header .= "Payment Mode" . "\t";
		$header .= "Qty" . "\t";
		$header .= "Amount" . "\t";
		$header .= "Postage" . "\t";
		$header .= "Grand Total" . "\t";
		$header .= "Payment Notes" . "\t";
		// $header .= "User" . "\t";
		$header .= "Payment Status" . "\t";
		$header .= "Cancelled Notes" . "\t";

		$result = "";
		
		$amount = 0; $cash = 0; $cheque = 0; $debitCredit = 0; $directCredit = 0; $i = 0;
		$cash = $trust_day_bookTotal->CASH;
		$cheque = $trust_day_bookTotal->CHEQUE;
		$directCredit = $trust_day_bookTotal->DIRECTCREDIT;
		$debitCredit = $trust_day_bookTotal->CREDITDEBIT;
		$amount = $trust_day_bookTotal->GRANDTOTAL;
		foreach($trust_day_book as $res) {
			if($res->qty != ""){
				$amt = intval($res->amt)*intval($res->qty);
				$total =intval($res->total)*intval($res->qty);
			}else{
				$amt = $res->amt;
				$total = $res->total;
			}

			$value = "";
			if($res->rType != "") {
				$value .= '"' . (++$i) . '"' . "\t";			
				$value .= '"' . $res->rNo . '"' . "\t";
				$value .= '"' . $res->rDate . '"' . "\t";
			} else {
				$value .= '"' . "" . '"' . "\t";			
				$value .= '"' . "" . '"' . "\t";
				$value .= '"' . "" . '"' . "\t";
			}	
			$value .= '"' . $res->receiptFor .'"'. "\t";
			$value .= '"' . $res->rType .'"'. "\t";
			$value .= '"' . $res->sevaName .'"'. "\t";
			$value .= '"' . $res->dtetName .'"'. "\t";
			$value .= '"' . $res->rName . '"' . "\t";
			$value .= '"' . $res->apprxAmt . '"' . "\t";
			$value .= '"' . $res->itemDesc . '"' . "\t";
			$value .= '"' . $res->rPayMethod . '"' . "\t";
			if($res->rCatId == "4") {
					$value .= '"' . $res->sevaQty . '"' . "\t";
				} else  {
					$value .= '"' . "" . '"' . "\t";
				}
			$value .= '"' . $amt . '"' . "\t";
			if($res->rType == "Seva") {
				$value .= '"' . $res->amtPostage . '"' . "\t";
			} else  {
				$value .= '"' . "" . '"' . "\t";
			}
			$value .= '"' . $total . '"' . "\t";
			$value .= '"' . $res->RPMNotes . '"' . "\t";
			// $value .= '"' . $res->user . '"' . "\t";
			$value .= '"' . $res->status . '"' . "\t";
			$value .= '"' . $res->cnclNotes . '"' . "\t";
			$result .= trim($value) . "\n";
		}
		$result .= "\n";
		
		$value = "\n";
		$value .= '"Grand Total "' . "\t";
		$value .= $amount. "\t";
		$result .= trim($value) . "\n";
		
		$result .= "\n";
		
		$value7 = "";
		$value7 .= "CASH" . "\t";
		$value7 .= "CHEQUE" . "\t";
		$value7 .= "CREDIT/DEBIT CARD" . "\t";
		$value7 .= "DIRECT CREDIT" . "\t";
		$result .= trim($value7) . "\n";
		$value8 = "";
		
		$value8 .= '"' . $cash . '"' . "\t";
		$value8 .= '"' .$cheque . '"' . "\t";
		$value8 .= '"' . $debitCredit . '"' . "\t";
		$value8 .= '"' . $directCredit . '"' . "\t";
		
		$result .= trim($value8) . "\n";	
		
		$result = str_replace( "\r" , "" , $result );
		print("$header\n$result"); 
	}
	
	function trust_day_book($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		//Radio Option
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		
		//Unset Session
		unset($_SESSION['date']);
		unset($_SESSION['deityId']);
		unset($_SESSION['paymentMethod']);
		unset($_SESSION['fromDate']);
		unset($_SESSION['toDate']);
		
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		$data['date'] = date('d-m-Y');
		
		$conditionOne = "";
		$fromDate = date("d-m-Y");
		
		$data['trust_day_book'] = $this->obj_report->get_all_field_trust_day_book($fromDate,'','','', 10,$start);
		$data['trust_day_bookTotal'] = $this->obj_report->get_all_field_trust_day_book_account_summary($fromDate,'','','');
		
		//print_r($data['trust_day_bookTotal']);
		// $this->output->enable_profiler(true);
		//print_r($data['trust_day_book']);
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/trust_day_book';
		$config['total_rows'] = $this->obj_report->count_all_field_trust_day_book($fromDate,'');
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
		
		if(isset($_SESSION['Trust_Day_Book'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trustDayBook');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//USER COLLECTION REPORT FOR EVENT IN TRUST FOR OTHER USER
	function user_collection_report($start=0) {
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		
		$conditionOne = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
		
		$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
		
		$condt = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['All'] = $this->obj_report->get_total_amount_user_collection($condt);
		$condt1 = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['Cash'] = $this->obj_report->get_total_amount_user_collection($condt1);
		$condt2 = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['Cheque'] = $this->obj_report->get_total_amount_user_collection($condt2);
		$condt3 = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['Credit_Debit'] = $this->obj_report->get_total_amount_user_collection($condt3);
		$condt4 = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['Direct'] = $this->obj_report->get_total_amount_user_collection($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/user_collection_report';
		$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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

		if(isset($_SESSION['User_Event_Collection_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/user_collection_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//USER COLLECTION REPORT FOR EVENT IN TRUST FOR OTHER USER ON PAYMENT FILTER
	function get_data_on_payment($start=0) {
		//UNSET SESSION CHECKBOX
		unset($_SESSION['all_users']);
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		
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
		
		if(@$pMethod == "All") {
			$conditionOne = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			//CONDITION FOR AMOUNT
			$condt = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt3 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt4 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
		} else if(@$pMethod != "All") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'TET_RECEIPT_PAYMENT_METHOD' => $pMethod,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			//CONDITION FOR AMOUNT
			$condt = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt3 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt4 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
		}
		
		
		$data['All'] = $this->obj_report->get_total_amount_user_collection($condt);
		$data['Cash'] = $this->obj_report->get_total_amount_user_collection($condt1);
		$data['Cheque'] = $this->obj_report->get_total_amount_user_collection($condt2);
		$data['Credit_Debit'] = $this->obj_report->get_total_amount_user_collection($condt3);
		$data['Direct'] = $this->obj_report->get_total_amount_user_collection($condt4);
		$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
		
		$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/get_data_on_payment';
		$config['total_rows'] = $this->obj_report->count_rows_seva_report($conditionOne);
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
		$this->load->view('trust/user_collection_report');
		$this->load->view('footer_home');
	}
	
	//SET THE SESSION OF CHECKBOX
	function get_set_session() {
		$this->session->set_userdata('all_users',$this->input->post('select'));
	}
	
	//UNSET THE SESSION OF CHECKBOX
	function get_unset_session() {
		unset($_SESSION['all_users']);
		unset($_SESSION['PM']);
		unset($_SESSION['UID']);
	}
	
	//USER COLLECTION REPORT FOR EVENT IN TRUST FOR ADMIN USER
	function user_collection_report_admin($start=0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');

		//UNSET SESSION
		unset($_SESSION['users']);
		unset($_SESSION['paymentMethod']);
		unset($_SESSION['PM']);
		unset($_SESSION['UID']);
	
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		
		$condtUser = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1);
		$data['users'] = $this->obj_report->get_all_users_on_events($condtUser,'TET_RECEIPT_ISSUED_BY','asc');
		
		$conditionOne = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['event_receipt_report'] = json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
		$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
		$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
		
		$condt = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['All'] = $this->obj_report->get_total_amount_user_collection($condt);
		$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['Cash'] = $this->obj_report->get_total_amount_user_collection($condt1);
		$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['Cheque'] = $this->obj_report->get_total_amount_user_collection($condt2);
		$condt3 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['Credit_Debit'] = $this->obj_report->get_total_amount_user_collection($condt3);
		$condt4 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
		$data['Direct'] = $this->obj_report->get_total_amount_user_collection($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/user_collection_report_admin';
		$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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

		if(isset($_SESSION['User_Event_Collection_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/user_collection_report_admin');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}	
	}
	
	
	//USER COLLECTION REPORT FOR EVENT IN TRUST FOR ADMIN USER ON FILTER
	function get_data_on_filter($id,$start=0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');

		//UNSET SESSION CHECKBOX
		//UNSET($_SESSION['all_users']);
		
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		
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
				
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
				$event_receipt_report = json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
				$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
				if(count($event_receipt_report) == 0) {
					$users = "All Users";
				}
			}
		} else {
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);
		}
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		$condtUser = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1);
		$data['users'] = $this->obj_report->get_all_users_on_events($condtUser,'TET_RECEIPT_ISSUED_BY','asc');
		
		if(@$pMethod == "All" && @$users == "All Users") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			//CONDITION FOR AMOUNT
			$condt = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt3 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt4 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$data['event_receipt_report'] = json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
			$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
		} else if(@$pMethod != "All" && @$users != "All Users") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $pMethod, 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			//CONDITION FOR AMOUNT
			$condt = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt3 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt4 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$data['event_receipt_report'] = json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
			$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
		} else if(@$pMethod != "All" && @$users == "All Users") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $pMethod,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			//CONDITION FOR AMOUNT
			$condt = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt3 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt4 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$data['event_receipt_report'] = json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
			$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
		} else if(@$pMethod == "All" && @$users != "All Users") {
			$conditionOne = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			//CONDITION FOR AMOUNT
			$condt = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt1 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users, 'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt2 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users, 'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt3 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users, 'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$condt4 = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $users, 'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_ACTIVE'=>1,'TET_ACTIVE' => 1);
			$data['event_receipt_report'] = json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
			$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
		}
		
		$data['All'] = $this->obj_report->get_total_amount_user_collection($condt);
		$data['Cash'] = $this->obj_report->get_total_amount_user_collection($condt1);
		$data['Cheque'] = $this->obj_report->get_total_amount_user_collection($condt2);
		$data['Credit_Debit'] = $this->obj_report->get_total_amount_user_collection($condt3);
		$data['Direct'] = $this->obj_report->get_total_amount_user_collection($condt4);
		$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/get_data_on_filter/'.$id;
		$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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
		
		//$this->output->enable_profiler(true);

		$this->load->view('header', $data);
		$this->load->view('trust/user_collection_report_admin');
		$this->load->view('footer_home');
	}
	
	//APPROVE THE DATA USER COLLECTION
	function approve_Submit() {
		$data['whichTab'] = "hallReport";
		//VALUE OF CHECKBOX SELECTED OR NOT SELECTED
		$selCondition = $this->input->post('checkVal');
		
		if($selCondition == "all_users") { //ALL_USERS CHECKBOX
			if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') == "All Users") {
				$condition = array('AUTHORISED_STATUS' => 'No','TET_RECEIPT_ACTIVE'=>1);
			} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') != "All Users") {
				$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'TET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'),'TET_RECEIPT_ACTIVE'=>1);
			} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') == "All Users") {
				$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'),'TET_RECEIPT_ACTIVE'=>1);
			} else if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') != "All Users") {
				$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'),'TET_RECEIPT_ACTIVE'=>1);
			}
			//UPDATE CODE
			$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'),'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
			$this->obj_report->update_authorise($condition,$data);
		} else if($selCondition == "this_page") { //THIS_PAGE CHECKBOX
			$selectedId = $this->input->post('selectApprove');
			$arrSelect = explode(',' ,$selectedId);
			for($i = 0; $i <= count($arrSelect) - 1; $i++) {
				if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') == "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1);
				} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') != "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'TET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'), 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1);
				} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') == "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1);
				} else if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') != "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'), 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1);
				}
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
				$this->obj_report->update_authorise($condition,$data);
			}
		} else { //WITHOUT CHECKBOX
			$selectedId = $this->input->post('selectApprove');
			$arrSelect = explode(',' ,$selectedId);
			for($i = 0; $i <= count($arrSelect) - 1; $i++) {
				if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') == "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1);
				} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') != "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'TET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'), 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1);
				} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') == "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1);
				} else if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') != "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'TET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'), 'TET_RECEIPT_ID' => $arrSelect[$i],'TET_RECEIPT_ACTIVE'=>1);
				}
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
				$this->obj_report->update_authorise($condition,$data);
			}
		}
		$this->session->set_userdata('PM', $this->input->post('paymentApprove'));
		$this->session->set_userdata('UID', $this->input->post('userApprove'));
		redirect('/TrustReport/user_collection_report_admin'); //get_data_on_filter/0
	}
	
	//EVENT RECEIPT REPORT	
	//above code commented while merging interns code
	function event_receipt_report($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
		redirect('login');
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		
		//unset
		unset($_SESSION['date']);
		unset($_SESSION['paymentMethod']);
		
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		$data['date'] = date('d-m-Y');
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		//pratheeksha condition
		$condtUser = array('TET_RECEIPT_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
		$_SESSION['users'] = '';
		$data['users'] = $this->obj_report->get_all_users_on_events($condtUser,'TET_RECEIPT_ISSUED_BY','asc');

		//till here
		$conditionOne = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => date('d-m-Y')); //,'TET_RECEIPT_ACTIVE'=>1
		$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
		
		$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
		
		//For Count
		$data['Count'] = $this->obj_report->count_rows_receipt_report($conditionOne);
		//for cancelled count
		$conditiontwo = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => date('d-m-Y'),'PAYMENT_STATUS'=>'Cancelled');
		$data['CancelledCount'] = $this->obj_report->cancelled_count_rows_receipt_report($conditiontwo);
		
		//FOR PRICE IN COMBOBOX
		$condt = array('TET_ACTIVE' => 1,'TET_RECEIPT_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
		$data['All'] = $this->obj_report->get_total_amount($condt);
		$condt1 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Cash' ,'TET_RECEIPT_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
		$data['Cash'] = $this->obj_report->get_total_amount($condt1);
		$condt2 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque' ,'TET_RECEIPT_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
		$data['Cheque'] = $this->obj_report->get_total_amount($condt2);
		$condt3 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card' ,'TET_RECEIPT_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
		$data['Credit_Debit'] = $this->obj_report->get_total_amount($condt3);
		$condt4 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit' ,'TET_RECEIPT_DATE' => date('d-m-Y'),'TET_RECEIPT_ACTIVE'=>1);
		$data['Direct'] = $this->obj_report->get_total_amount($condt4);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/event_receipt_report';
		$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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
		
		if(isset($_SESSION['Current_Event_Receipt_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/event_receipt_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	
	
		function get_filter_change_event_sevas_details($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link3'] = $actual_link;

			$this->db->select('*')->from('trust_event');
			$this->db->where('TET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['TET_ID'];
			
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
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
			
			if(@$_POST['sevaId']) {
				unset($_SESSION['sevaId']);
				$data['sevaId'] = $this->input->post('sevaId');
				$sevaId = $this->input->post('sevaId');
			}
			
			if(@$_SESSION['sevaId'] == "") {
				$this->session->set_userdata('sevaId', $this->input->post('sevaId'));
				$data['sevaId'] = $_SESSION['sevaId'];
				$sevaId = $this->input->post('sevaId');
			} else {
				$sevaId = $_SESSION['sevaId'];
				$data['sevaId'] = $_SESSION['sevaId'];
			}
			
			if(@$_POST['sevaName']) {
				unset($_SESSION['sevaName']);
				$data['sevaName'] = $this->input->post('sevaName');
				$sevaName = $this->input->post('sevaName');
			}
			
			if(@$_SESSION['sevaName'] == "") {
				$this->session->set_userdata('sevaName', $this->input->post('sevaName'));
				$data['sevaName'] = $_SESSION['sevaName'];
				$sevaName = $this->input->post('sevaName');
			} else {
				$sevaName = $_SESSION['sevaName'];
				$data['sevaName'] = $_SESSION['sevaName'];
			}
			
			if(@$radioOpt == "multiDate") {
				$data['Count'] = $this->obj_report->count_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,$eId);
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,10,$start,$eId);
			} else {
				$data['Count'] = $this->obj_report->count_event_sevas_summary_details($date,$sevaId,$eId);
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_details($date,$sevaId,10,$start,$eId);
			}
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'TrustReport/get_filter_change_sevas_details';
			if(@$radioOpt == "multiDate") {
				$config['total_rows'] = $this->obj_report->count_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,$eId);
			} else {
				$config['total_rows'] = $this->obj_report->count_event_sevas_summary_details($date,$sevaId,$eId);
			}
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
			
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Event_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('trust/event_sevas_summary_details');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
	
	
		//FOR DISPLAY SUMMARY SEVAS DETAILS ON FILTER
		function get_filter_change_sevas_details($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link3'] = $actual_link;
			
			$this->db->select('*')->from('trust_event');
			$this->db->where('TET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['TET_ID'];
			
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
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
			
			if(@$_POST['sevaId']) {
				unset($_SESSION['sevaId']);
				$data['sevaId'] = $this->input->post('sevaId');
				$sevaId = $this->input->post('sevaId');
			}
			
			if(@$_SESSION['sevaId'] == "") {
				$this->session->set_userdata('sevaId', $this->input->post('sevaId'));
				$data['sevaId'] = $_SESSION['sevaId'];
				$sevaId = $this->input->post('sevaId');
			} else {
				$sevaId = $_SESSION['sevaId'];
				$data['sevaId'] = $_SESSION['sevaId'];
			}
			
			if(@$_POST['sevaName']) {
				unset($_SESSION['sevaName']);
				$data['sevaName'] = $this->input->post('sevaName');
				$sevaName = $this->input->post('sevaName');
			}
			
			if(@$_SESSION['sevaName'] == "") {
				$this->session->set_userdata('sevaName', $this->input->post('sevaName'));
				$data['sevaName'] = $_SESSION['sevaName'];
				$sevaName = $this->input->post('sevaName');
			} else {
				$sevaName = $_SESSION['sevaName'];
				$data['sevaName'] = $_SESSION['sevaName'];
			}
			
			if(@$radioOpt == "multiDate") {
				$data['Count'] = $this->obj_report->count_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,$eId);
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,10,$start,$eId);
			} else {
				$data['Count'] = $this->obj_report->count_event_sevas_summary_details($date,$sevaId,$eId);
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_details($date,$sevaId,10,$start,$eId);
			}
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'TrustReport/get_filter_change_sevas_details';
			if(@$radioOpt == "multiDate") {
				$config['total_rows'] = $this->obj_report->count_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,$eId);
			} else {
				$config['total_rows'] = $this->obj_report->count_event_sevas_summary_details($date,$sevaId,$eId);
			}
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
			
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Event_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('trust/event_sevas_summary_details');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
	
	//FOR EXCEL FOR EVENT SEVA SUMMARY
		function event_sevas_summary_report_excel() {
			
			$this->db->select('*')->from('trust_event');
			$this->db->where('TET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['TET_ID'];
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
			}
			
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
			
			$header = "";
			$result = "";
			if(@$radioOpt == "multiDate")
				$filename = "Trust Event_Seva_Summary_Report_from ".$fromDate." to ".$toDate;  //File Name
			else
				$filename = "Trust Event_Seva_Summary_Report_".$_POST['dateField'];  //File Name
			
			$file_ending = "xls";
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= "SRI LAKSHMI VENKATESH TEMPLE" . "\n\n";		
			$header .= "SI NO." . "\t";
			$header .= "EVENT SEVA" . "\t";
			$header .= "SEVAS QUANTITY" . "\t";
			$header .= "AMOUNT" . "\t";
			
			if(@$radioOpt == "multiDate") {
				$res = $this->obj_report->get_all_field_event_sevas_summary_report_period($fromDate,$toDate,$eId);
			} else {
				$res = $this->obj_report->get_all_field_event_sevas_summary($date,$eId);
			}
			
			for($i = 0; $i < sizeof($res); $i++)
			{
					$line = '';    
					$value = "";			
					$value .= ($i+1). "\t";
					$value .= '"' . $res[$i]['TET_SO_SEVA_NAME'] . '"' . "\t";
					$value .= '"' . $res[$i]['QTY'] . '"' . "\t";
					$value .= '"' . $res[$i]['AMOUNT'] . '"' . "\t";
					
					$line .= $value;
					$result .= trim($line) . "\n";
			
			}
			$result = str_replace( "\r" , "" , $result );
			   
			print("$header\n$result"); 
		}
	
	
	
	
	//FOR EXCEL FOR EVENT SEVA SUMMARY DETAILS
		function event_sevas_summary_report_details_excel() {
			
			$this->db->select('*')->from('trust_event');
			$this->db->where('TET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['TET_ID'];
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			if(isset($_POST['fromDates'])) { 
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
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
			
			if(@$_POST['sevaId']) {
				unset($_SESSION['sevaId']);
				$data['sevaId'] = $this->input->post('sevaId');
				$sevaId = $this->input->post('sevaId');
			}
			
			if(@$_SESSION['sevaId'] == "") {
				$this->session->set_userdata('sevaId', $this->input->post('sevaId'));
				$data['sevaId'] = $_SESSION['sevaId'];
				$sevaId = $this->input->post('sevaId');
			} else {
				$sevaId = $_SESSION['sevaId'];
				$data['sevaId'] = $_SESSION['sevaId'];
			}
			
			if(@$_POST['sevaName']) {
				unset($_SESSION['sevaName']);
				$data['sevaName'] = $this->input->post('sevaName');
				$sevaName = $this->input->post('sevaName');
			}
			
			if(@$_SESSION['sevaName'] == "") {
				$this->session->set_userdata('sevaName', $this->input->post('sevaName'));
				$data['sevaName'] = $_SESSION['sevaName'];
				$sevaName = $this->input->post('sevaName');
			} else {
				$sevaName = $_SESSION['sevaName'];
				$data['sevaName'] = $_SESSION['sevaName'];
			}
			
			$header = "";
			$result = "";
			if(@$radioOpt == "multiDate")
				$filename = "Sevas_Summary_Details_Report_ from ".$fromDate." to ".$toDate;  //File Name
			else
				$filename = "Sevas_Summary_Details_Report_".$_POST['dateField'];  //File Name
			$file_ending = "xls";
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= "\t";
			$header .= "SRI LAKSHMI VENKATESH TEMPLE" . "\n\n";				
			$header .= "SI NO." . "\t";
			$header .= "RECEIPT NO." . "\t";
			$header .= "NAME" . "\t";
			$header .= "PHONE NO." . "\t";
			$header .= "QUANTITY" . "\t";
			$header .= "AMOUNT" . "\t";
			
			if(@$radioOpt == "multiDate") {
				$res = $this->obj_report->get_all_field_event_sevas_summary_details_period_excel($fromDate,$toDate,$sevaId,$eId);
			} else {
				$res = $this->obj_report->get_all_field_event_sevas_summary_details_excel($date,$sevaId,$eId);
			}
			
			for($i = 0; $i < sizeof($res); $i++)
			{
				
					$line = '';    
					$value = "";			
					$value .= ($i+1). "\t";
						$value .= '"' . $res[$i]['TET_RECEIPT_NO'] . '"' . "\t";
						$value .= '"' . $res[$i]['TET_RECEIPT_NAME'] . '"' . "\t";
						$value .= '"' . $res[$i]['TET_RECEIPT_PHONE'] . '"' . "\t";
						$value .= '"' . $res[$i]['TET_SO_QUANTITY'] . '"' . "\t";
						$value .= '"' . $res[$i]['TET_SO_PRICE'] * $res[$i]['TET_SO_QUANTITY']. '"' . "\t";				
					$line .= $value;
					$result .= trim($line) . "\n";
				
			}
			$result = str_replace( "\r" , "" , $result );
			   
			print("$header\n$result"); 
		}
	
	//EVENT RECEIPT REPORT ON CHANGE OF DATEFIELD
	//Above fn() code comments while merging interns code 
	function event_report_on_change_date($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');

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
		
		//For Menu Selection
		$data['whichTab'] = "hallReport";
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

		// For Loading Users
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
		//
		
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
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		if(@$paymentMode != 'All') {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0){
						$queryString .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$condtUser = "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1";		
						$conditiontwo = "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:""). " and TET_RECEIPT_ACTIVE=0";
					} else {
						$queryString .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'"  . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$condtUser .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1";
							$conditiontwo .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'"  . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:""). " and TET_RECEIPT_ACTIVE=0";
					}
				}
				$conditionOne = $queryString;
			} else {				
				if($users != "All Users") {
					$conditionOne = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE' => 1, 'TET_ACTIVE' => 1,'TET_RECEIPT_PAYMENT_METHOD' => $paymentMode,'TET_RECEIPT_DATE' => $date);
					$condtUser = array('TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1, 'TET_ACTIVE'=>1);//'TET_RECEIPT_ISSUED_BY_ID' => $users,
					$conditiontwo = array('TET_RECEIPT_ISSUED_BY_ID' => $users, 'TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>0,'TET_RECEIPT_PAYMENT_METHOD' => $paymentMode);
				} else {
					$conditionOne = array('TET_RECEIPT_ACTIVE' => 1,'TET_ACTIVE' => 1,'TET_RECEIPT_PAYMENT_METHOD' => $paymentMode,'TET_RECEIPT_DATE' => $date);
					$condtUser = array('TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1, 'TET_ACTIVE'=>1);
					$conditiontwo = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>0,'TET_RECEIPT_PAYMENT_METHOD' => $paymentMode);
				}					
			}
			
			$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
			//For Count
			$data['Count'] = $this->obj_report->count_rows_receipt_report($conditionOne);
			
			//for cancelled count
			$data['CancelledCount'] = $this->obj_report->cancelled_count_rows_receipt_report($conditiontwo);

			//FOR PRICE DISPLAY IN COMBOBOX
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				$queryString2 = "";
				$queryString3 = "";
				$queryString4 = "";
				
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString1 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Cash'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString2 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Cheque'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString3 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Credit / Debit Card'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString4 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Direct Credit'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
					} else {
						$queryString .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString1 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Cash'"  . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString2 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Cheque'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString3 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Credit / Debit Card'". (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString4 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Direct Credit'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
					}
				}
				$condt = $queryString;
				$condt1 = $queryString1;
				$condt2 = $queryString2;
				$condt3 = $queryString3;
				$condt4 = $queryString4;
			} else {
				if($users != "All Users") {
					$condt = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_ACTIVE' => 1 , 'TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt1 = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt2 = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt3 = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
						$condt4 = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
				} else {
					$condt = array('TET_ACTIVE' => 1 , 'TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt1 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt2 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt3 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt4 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);				
				}
			}
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0){
						$queryString .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$condtUser = "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1";
						$conditiontwo = "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1". (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:""). " AND TET_RECEIPT_ACTIVE=0";						
					}
					else {
						$queryString .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$condtUser .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1";
						$conditiontwo .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:""). " and TET_RECEIPT_ACTIVE=0";
					}
				}
				$conditionOne = $queryString;
			} else {
				if($users != "All Users") {
					$conditionOne = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_RECEIPT_ACTIVE'=>1, 'TET_ACTIVE' => 1,'TET_RECEIPT_DATE' => $date);
					$condtUser = array('TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1, 'TET_ACTIVE'=>1);//'TET_RECEIPT_ISSUED_BY_ID' => $users,
					$conditiontwo = array('TET_RECEIPT_ISSUED_BY_ID' => $users, 'TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>0);
				}
				else {
					$conditionOne = array('TET_ACTIVE' => 1,'TET_RECEIPT_ACTIVE'=>1,'TET_RECEIPT_DATE' => $date);
					$condtUser = array('TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1, 'TET_ACTIVE'=>1);
					$conditiontwo = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>0);
				}					
			}
			$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
			//For Count
			$data['Count'] = $this->obj_report->count_rows_receipt_report($conditionOne);
			$data['CancelledCount'] = $this->obj_report->cancelled_count_rows_receipt_report($conditiontwo);
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				$queryString2 = "";
				$queryString3 = "";
				$queryString4 = "";
				
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString1 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Cash'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString2 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Cheque'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString3 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Credit / Debit Card'"  . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString4 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Direct Credit'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
					} else {
						$queryString .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString1 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Cash'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString2 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Cheque'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString3 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Credit / Debit Card'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						$queryString4 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='Direct Credit'" . (($users != "All Users")?" AND TET_RECEIPT_ISSUED_BY_ID = ".$users:"");
					}
				}
				$condt = $queryString;
				$condt1 = $queryString1;
				$condt2 = $queryString2;
				$condt3 = $queryString3;
				$condt4 = $queryString4;
			} else {
				//FOR PRICE DISPLAY IN COMBOBOX
				if($users != "All Users") {
					$condt = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt1 = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt2 = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt3 = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt4 = array('TET_RECEIPT_ISSUED_BY_ID' => $users,'TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
				}else {
					$condt = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt1 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Cash','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt2 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Cheque','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt3 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);
					$condt4 = array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','TET_RECEIPT_DATE' => $date,'TET_RECEIPT_ACTIVE'=>1);	
				}
			}
		}

		//Load Users in Receipt Report
		$data['users'] = $this->obj_report->get_all_users_on_events($condtUser,'TET_RECEIPT_ISSUED_BY','asc');

		$data['All'] = $this->obj_report->get_total_amount($condt);
		$data['Cash'] = $this->obj_report->get_total_amount($condt1);
		$data['Cheque'] = $this->obj_report->get_total_amount($condt2);
		$data['Credit_Debit'] = $this->obj_report->get_total_amount($condt3);
		$data['Direct'] = $this->obj_report->get_total_amount($condt4);
		
		$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/event_report_on_change_date';
		$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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
		$this->load->view('trust/event_receipt_report');
		$this->load->view('footer_home');
	}

	//FOR EXCEL FOR RECEIPT
	//Above code commented while merging interns code
	function event_receipt_report_excel() {
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
		
		if(isset($_POST['payMode'])) {
			$paymentMode= @$_POST['payMode'];
		} else {
			$paymentMode = $_SESSION['payMode'];
		}
		
		$header = "";
		$result = "";
		if(@$radioOpt == "multiDate")
			$filename = "Current_Event_Receipt_Report from ".$_SESSION['fromDate']." to ".$_SESSION['toDate'];  //File Name
		else
			$filename = "Current_Event_Receipt_Report_".$_POST['dateField'];  //File Name
		$file_ending = "xls";
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		//header info for browser
		$data['event'] = $this->obj_trust_events->getEvents();
		$_SESSION['event'] = $data['event']['TET_NAME'];
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$sep = "\t"; //tabbed character
		
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= $templename[0]["TRUST_NAME"]. "\n\n";
		$header .= "$_SESSION[event]" ."\n";
		$header .= "SI NO." . "\t";
		$header .= "RECEIPT NO." . "\t";
		$header .= "RT DATE" . "\t";
		$header .= "RT TYPE" . "\t";
		$header .= "NAME" . "\t";
		$header .= "ESTIMATED PRICE" . "\t";
		$header .= "DESCRIPTION" . "\t";
		$header .= "QUANTITY" . "\t";
		$header .= "MODE" . "\t";
		$header .= "AMOUNT" . "\t";	
		$header .= "POSTAGE" . "\t";	
		$header .= "TOTAL" . "\t";
		$header .= "PAYMENT NOTES" . "\t";		
		$header .= "STATUS" . "\t";	
		$header .= "AUTHORIZED STATUS" . "\t";
		$header .= "ENTERED BY" . "\t";	
		
		if($_POST['dateField'] != "" && $_POST['payMode'] == "All") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1";
						$queryString1 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=0";
					} else {
						$queryString .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1";
						$queryString1 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=0";
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $_POST['dateField'],'TET_RECEIPT_ACTIVE'=>1);
				$conditionOne= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $_POST['dateField'],'TET_RECEIPT_ACTIVE'=>0);
			}
			$res = $this->obj_report->get_all_field_event_receipt_excel($condition);
			$res1 = $this->obj_report->get_all_field_event_receipt_excel($conditionOne);
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						$queryString1 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=0 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
					} else {
						$queryString .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1  and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						$queryString1 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1  and TET_RECEIPT_ACTIVE=0 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'TET_RECEIPT_DATE' => $_POST['dateField'],'TET_RECEIPT_ACTIVE'=>1);
				$conditionOne= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'TET_RECEIPT_DATE' => $_POST['dateField'],'TET_RECEIPT_ACTIVE'=>0);
			}
			$res = $this->obj_report->get_all_field_event_receipt_excel($condition);
			$res1 = $this->obj_report->get_all_field_event_receipt_excel($conditionOne);
		}
			
		for($i = 0; $i < sizeof($res); $i++)
		{
			$sum = ($res[$i]->TET_RECEIPT_PRICE) + ($res[$i]->POSTAGE_PRICE);
			$line = '';    
			$value = "";			
			$value .= '"' . ($i+1) . '"' . "\t";
			$value .= '"' . $res[$i]->TET_RECEIPT_NO . '"' . "\t";
			$value .= '"' . $res[$i]->TET_RECEIPT_DATE . '"' . "\t";
			$value .= '"' . $res[$i]->TET_RECEIPT_CATEGORY_TYPE . '"' . "\t";
			$value .= '"' . $res[$i]->TET_RECEIPT_NAME . '"' . "\t";
			$value .= '"' . $res[$i]->IK_APPRX_AMT . '"' . "\t";
			$value .= '"' . $res[$i]->IK_ITEM_DESC . '"' . "\t";
     		 $value .= '"' . $res[$i]->IK_ITEM_QTY . '"' .'' . $res[$i]->IK_ITEM_UNIT . '' . "\t";
			$value .= '"' . $res[$i]->TET_RECEIPT_PAYMENT_METHOD . '"' . "\t";
			if($res[$i]->TET_RECEIPT_CATEGORY_TYPE == "Inkind") {
				$value .= '' . "\t";
			} else {
				$value .= '"' . $res[$i]->TET_RECEIPT_PRICE . '"' . "\t";
			}
			$value .= '"' . $res[$i]->POSTAGE_PRICE . '"' . "\t";
			$value .= '"' . $sum . '"' . "\t";
			$value .= '"' . $res[$i]->TET_RECEIPT_PAYMENT_METHOD_NOTES . '"' . "\t";
			$value .= '"' . $res[$i]->PAYMENT_STATUS . '"' . "\t";
			$value .= '"' . $res[$i]->AUTHORISED_STATUS . '"' . "\t";
			$value .= '"' . $res[$i]->TET_RECEIPT_ISSUED_BY . '"' . "\t";
				
			$line .= $value;
			$result .= trim($line) . "\n";
		}
		
		$result .= "\n";
		$result .= "Cancelled Receipt:";
		$result .= "\n";
		
		$result .= "SI NO." . "\t";
		$result .= "RECEIPT NO." . "\t";
		$result .= "RT DATE" . "\t";
		$result .= "RT TYPE" . "\t";
		$result .= "NAME" . "\t";
		$result .= "MODE" . "\t";
		$result .= "AMOUNT" . "\t";	
		$result .= "STATUS" . "\t";	
		$result .= "AUTHORIZED STATUS" . "\t";
		$result .= "ENTERED BY" . "\t";
		$result .= "\n";
		
		for($i = 0; $i < sizeof($res1); $i++)
		{
			$line = '';    
			$value = "";			
			$value .= '"' . ($i+1) . '"' . "\t";
			$value .= '"' . $res1[$i]->TET_RECEIPT_NO . '"' . "\t";
			$value .= '"' . $res1[$i]->TET_RECEIPT_DATE . '"' . "\t";
			$value .= '"' . $res1[$i]->TET_RECEIPT_CATEGORY_TYPE . '"' . "\t";
			$value .= '"' . $res1[$i]->TET_RECEIPT_NAME . '"' . "\t";
			$value .= '"' . $res1[$i]->TET_RECEIPT_PAYMENT_METHOD . '"' . "\t";
			if($res1[$i]->TET_RECEIPT_CATEGORY_TYPE == "Inkind") {
				$value .= '' . "\t";
			} else {
				$value .= '"' . $res1[$i]->TET_RECEIPT_PRICE . '"' . "\t";
			}
			$value .= '"' . $res1[$i]->PAYMENT_STATUS . '"' . "\t";
			$value .= '"' . $res1[$i]->AUTHORISED_STATUS . '"' . "\t";
			$value .= '"' . $res1[$i]->TET_RECEIPT_ISSUED_BY . '"' . "\t";

			$line .= $value;
			$result .= trim($line) . "\n";
		}
		
		$result = str_replace( "\r" , "" , $result );
		   
		print("$header\n$result"); 
	}
	//EVENT SEVA REPORT
	function event_seva_report($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');

		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		
		//unset
		unset($_SESSION['date']);
		unset($_SESSION['sevaid']);
		
		//For Menu Selection
		$data['whichTab'] = "hallReport";
		$data['date'] = date('d-m-Y');
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		
		$conditionTwo = array('TET_ACTIVE' => 1,'TET_SO_IS_SEVA'=>1,'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => date('d-m-Y'));
		$data['events_seva'] = $this->obj_report->get_all_field_seva_report($conditionTwo);
		
		$conditionTwo = array('TET_ACTIVE' => 1,'TET_RECEIPT_ACTIVE' => 1,'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => date('d-m-Y'));
		$data['seva_report'] = $this->obj_report->get_all_field_event_seva_report($conditionTwo,'','', 10,$start);
		
		$data['Count'] = $this->obj_report->count_rows_seva_report($conditionTwo); 
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/event_seva_report';
		$config['total_rows'] = $this->obj_report->count_rows_seva_report($conditionTwo);
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
		
		if(isset($_SESSION['Current_Event_Seva_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/event_sevas_report');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//EVENT SEVA REPORT ON CHANGE OF COMBO
	function event_date_change_report($start = 0) {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');

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
		
		//For Menu Selection
		$data['whichTab'] = "hallReport";
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
		
		if(@$_POST['sevaid']) {
			unset($_SESSION['sevaid']);
			$data['sevaId'] = $this->input->post('sevaid');
			$sevaid = $this->input->post('sevaid');
		}
		
		if(@$_SESSION['sevaid'] == "") {
			$this->session->set_userdata('sevaid', $this->input->post('sevaid'));
			$data['sevaId'] = $_SESSION['sevaid'];
			$sevaid = $this->input->post('sevaid');
		} else {
			$sevaid = $_SESSION['sevaid'];
			$data['sevaId'] = $_SESSION['sevaid'];
		}
		
		$condition = array('TET_ACTIVE' => 1);
		$data['events'] = $this->obj_report->get_all_field_event($condition);
		
		if(@$radioOpt == "multiDate") {
			$allDates1 = explode("|",$allDates);
			$queryString = "";
			for($i = 0; $i < count($allDates1); ++$i) {
				if($i == 0)
					$queryString .= "TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."' and TET_SO_IS_SEVA = 1";
				else
					$queryString .= " or TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."' and TET_SO_IS_SEVA = 1";
			}
			$conditionOne = $queryString;
		} else {
			$conditionOne = array('TET_RECEIPT_ACTIVE' =>1,'TET_SO_IS_SEVA'=>1,'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => $date);
		}
		
		$data['events_seva'] = $this->obj_report->get_all_field_seva_report($conditionOne);
		
		if($sevaid != 'All') {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0)
						$queryString .= "TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."' and TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID='".$sevaid."'";
					else
						$queryString .= " or TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."' and TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID='".$sevaid."'";
				}
				$conditionTwo = $queryString;
			} else
				$conditionTwo = array('TET_RECEIPT_ACTIVE' =>1,'TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID' => $sevaid, 'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => $date);
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0)
						$queryString .= "TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."'";
					else
						$queryString .= " or TET_RECEIPT_ACTIVE = 1 and  TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."'";
				}	
				$conditionTwo = $queryString;
			} else
				$conditionTwo = array('TET_RECEIPT_ACTIVE' =>1,'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => $date);
		}
		$data['seva_report'] = $this->obj_report->get_all_field_event_seva_report($conditionTwo,'','',10,$start);
		$data['Count'] = $this->obj_report->count_rows_seva_report($conditionTwo);
		
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/event_date_change_report';
		$config['total_rows'] = $this->obj_report->count_rows_seva_report($conditionTwo);
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
		$this->load->view('trust/event_sevas_report');
		$this->load->view('footer_home');
	}
	
	//FOR EXCEL FOR RECEIPT
	function event_sevas_report_excel() {
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		
		$header = "";
		$result = "";
		if(@$radioOpt == "multiDate")
			$filename = "Current_Event_Receipt_Report_ from ".$_SESSION['fromDate']." to ".$_SESSION['toDate'];  //File Name
		else
			$filename = "Current_Event_Receipt_Report_".$_POST['dateField'];  //File Name
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
		$header .= $templename[0]["TRUST_NAME"]. "\n\n";
		$header .= "SI NO." . "\t";
		$header .= "SEVA" . "\t";
		$header .= "NAME" . "\t";
		$header .= "CONTACT NUMBER" . "\t";
		$header .= "RECEIPT NO." . "\t";
		
		if(isset($_POST['allDates'])) {
			$allDates= @$_POST['allDates'];
		} else {
			$allDates = $_SESSION['allDates'];
		}
		
		if(@$radioOpt == "multiDate" && $this->input->post('SId') == "All") {
			$allDates1 = explode("|",$allDates);
			$queryString = "";
			for($i = 0; $i < count($allDates1); ++$i) {
				if($i == 0)
					$queryString .= "TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."'";
				else
					$queryString .= " or TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."'";
			}
			$condition = $queryString;
			$res = $this->obj_report->get_all_field_event_seva_excel($condition);
		} else if(@$radioOpt == "multiDate"){	
			$allDates1 = explode("|",$allDates);
			$queryString = "";
			for($i = 0; $i < count($allDates1); ++$i) {
				if($i == 0)
					$queryString .= "TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."' and TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID='".$this->input->post('SId')."'";
				else
					$queryString .= " or TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."' and TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID='".$this->input->post('SId')."'";
			}
				
			$condition = $queryString;
			$res = $this->obj_report->get_all_field_event_seva_excel($condition);
		} else {
			if(($this->input->post('dateField')) != "" && ($this->input->post('SId') == "All")) {
				$condition = array('TET_RECEIPT_ACTIVE' => 1, 'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => $this->input->post('dateField'));
				$res = $this->obj_report->get_all_field_event_seva_excel($condition);
			} else {
				$condition = array('TET_RECEIPT_ACTIVE' => 1, 'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => $this->input->post('dateField'), 'TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID' => $this->input->post('SId'));
				$res = $this->obj_report->get_all_field_event_seva_excel($condition);
			}
		}
			
		for($i = 0; $i < sizeof($res); $i++)
		{
			$line = '';    
			$value = "";			
			$value .= ($i+1). "\t";			
			$value .= '"' . $res[$i]->TET_SO_SEVA_NAME . '"' . "\t";
			$value .= '"' . $res[$i]->TET_RECEIPT_NAME . '"' . "\t";
			$value .= '"' . $res[$i]->TET_RECEIPT_PHONE . '"' . "\t";
			$value .= '"' . $res[$i]->TET_RECEIPT_NO . '"' . "\t";
				
			$line .= $value;
			$result .= trim($line) . "\n";
		}
		$result = str_replace( "\r" , "" , $result );
		   
		print("$header\n$result"); 
	}
	
	//MIS REPORT FOR EVENT
	//Above code commented while merging intern Lathesh code

	function misReport() {
		if(@$_SESSION['eventActiveCount'] == 0)
			redirect('login');
		
		$data['whichTab'] = "hallReport";
		if(isset($_POST['date'])) {
			$date = $_POST['date']; 
		} else {
			$date = date('d-m-Y');
		}
		
		$data['date'] = $date;
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		
		$fromDate = @$_POST['fromDate'];
		$toDate = @$_POST['toDate'];
		
		$data['fromDate'] = $fromDate;
		$data['toDate'] = $toDate;
		
		// Start Of Donation Receipts Single Date & Multidate
		/*if(@$_POST['allDates'] != "") {
			$allDates = explode("|",$_POST['allDates']);
			$queryString = "";
			for($i = 0; $i < count($allDates); ++$i) {
				if($i == 0)
					$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."'  and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID=2";
				else
					$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID=2";
			}
		}
		
		if(@$radioOpt == "multiDate") {
			$this->db->select()->from('TRUST_EVENT_RECEIPT')->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID')->where($queryString);
		} else {
			//donation kanika
			$this->db->select()->from('TRUST_EVENT_RECEIPT')->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID')->where(array('TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE'=>$date,'TET_RECEIPT_CATEGORY_ID'=>2,'TET_RECEIPT_ACTIVE'=>1));
		}
		
		$query = $this->db->get();
		$data['donation'] = $query->result("array");
		$_SESSION['donation'] = $data['donation'];
		
		if(@$radioOpt == "multiDate") {
			$sqlDKC = 'SELECT COUNT(TET_RECEIPT_ID) FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE '.$queryString.'';
		} else {
			//Count Of Donation Kanike			
			$sqlDKC = 'SELECT COUNT(TET_RECEIPT_ID) FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE TET_ACTIVE = 1 and `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_DATE` = "'.$date.'" AND `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_CATEGORY_ID` = 2 and `TET_RECEIPT_ACTIVE`=1';
		}
		
		$queryDKC = $this->db->query($sqlDKC);
		$row=$query->num_rows();
		$data['donationCount'] = $row;
		$_SESSION['donationCount'] = $data['donationCount'];*/
		// End Of Donation Receipts Single Date & Multidate

		// 1: SEVA Start Of Seva Receipts Single Date & Multidate
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."'  and TET_RECEIPT_ACTIVE = 1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID=1";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE = 1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID=1";
				}
			}
			
			$sql  = 'SELECT if(TET_SO_QUANTITY > 1, SUM(POSTAGE_PRICE), SUM(DISTINCT(POSTAGE_PRICE))) AS POSTAGE_PRICE, TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE, count(TET_SO_SEVA_NAME), SUM(TET_SO_QUANTITY),TET_SO_SEVA_NAME, SUM(TET_SO_PRICE), SUM(TET_SO_QUANTITY*TET_SO_PRICE) FROM TRUST_EVENT_RECEIPT JOIN `TRUST_EVENT_SEVA_OFFERED` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE '.$queryString.' GROUP BY `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_NAME`';
		} else {
			//SEVA
			$sql  = 'SELECT if(TET_SO_QUANTITY > 1, SUM(POSTAGE_PRICE), SUM(DISTINCT(POSTAGE_PRICE))) AS POSTAGE_PRICE, TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE, count(TET_SO_SEVA_NAME), SUM(TET_SO_QUANTITY) ,TET_SO_SEVA_NAME, SUM(TET_SO_PRICE), SUM(TET_SO_QUANTITY*TET_SO_PRICE) FROM TRUST_EVENT_RECEIPT JOIN `TRUST_EVENT_SEVA_OFFERED` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE TET_ACTIVE = 1 and `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_DATE` = "'.$date.'" AND `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_CATEGORY_ID` = 1 and TET_RECEIPT_ACTIVE = 1 GROUP BY `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_NAME`';
		}
		$query = $this->db->query($sql);
		$data['seva'] = $query->result("array");
		$_SESSION['seva'] = $data['seva'];
		// print_r($data['seva']);
		// End Of Seva Receipts Single Date & Multidate
		
		// Start Of Cancelled Seva Receipts Single Date & Multidate
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."'  and TET_RECEIPT_ACTIVE = 0  and TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID=1";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE = 0  and TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID=1";
				}
			}
			
			$sql  = 'SELECT if(TET_SO_QUANTITY > 1, SUM(POSTAGE_PRICE), SUM(DISTINCT(POSTAGE_PRICE))) AS POSTAGE_PRICE,TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE, count(TET_SO_SEVA_NAME), SUM(TET_SO_QUANTITY) ,TET_SO_SEVA_NAME, SUM(TET_SO_PRICE), SUM(TET_SO_QUANTITY*TET_SO_PRICE) FROM TRUST_EVENT_RECEIPT JOIN `TRUST_EVENT_SEVA_OFFERED` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE '.$queryString.' GROUP BY `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_NAME`';
		} else {
			//CANCELLED SEVA
			$sql  = 'SELECT if(TET_SO_QUANTITY > 1, SUM(POSTAGE_PRICE), SUM(DISTINCT(POSTAGE_PRICE))) AS POSTAGE_PRICE, TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE, count(TET_SO_SEVA_NAME), SUM(TET_SO_QUANTITY) ,TET_SO_SEVA_NAME,SUM(TET_SO_PRICE), SUM(TET_SO_QUANTITY*TET_SO_PRICE),CANCEL_NOTES FROM TRUST_EVENT_RECEIPT JOIN `TRUST_EVENT_SEVA_OFFERED` ON `TRUST_EVENT_SEVA_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE TET_ACTIVE = 1 and `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_DATE` = "'.$date.'" AND `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_CATEGORY_ID` = 1 and TET_RECEIPT_ACTIVE = 0 GROUP BY `TRUST_EVENT_SEVA_OFFERED`.`TET_SO_SEVA_NAME`';
		}
		$query = $this->db->query($sql);
		$data['cancelledSeva'] = $query->result("array");
		$_SESSION['cancelledSeva'] = $data['cancelledSeva'];
		// End Of Cancelled Seva Receipts Single Date & Multidate

		// 2: DONATION Start Of Donation Receipts Single Date & Multidate
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID=2";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID=2";
				}
			}
			
			$sqlDK = 'SELECT * FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE '.$queryString.'';
		} else {
			//DONATION/KANIKE
			$sqlDK = 'SELECT * FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE TET_ACTIVE = 1 and `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_DATE` = "'.$date.'" AND `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_CATEGORY_ID` = 2 and TET_RECEIPT_ACTIVE=1';
		}
		$queryDK = $this->db->query($sqlDK);
		$data['donation_details'] = $queryDK->result('array');
		$_SESSION['donation_details'] = $data['donation_details'];
		// 2: End Of Donation Receipts Single Date & Multidate


		// Start Of Cancelled Donation Receipts Single Date & Multidate
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=0  and TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID=2";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=0  and TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID=2";
				}
			}
			
			$sqlDK = 'SELECT * FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE '.$queryString.'';
		} else {
			//DONATION/KANIKE
			$sqlDK = 'SELECT * FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE TET_ACTIVE = 1 and `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_DATE` = "'.$date.'" AND `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_CATEGORY_ID` = 2 and TET_RECEIPT_ACTIVE=0';
		}
		$queryDK = $this->db->query($sqlDK);
		$data['cancelled_donation_details'] = $queryDK->result('array');
		$_SESSION['cancelled_donation_details'] = $data['cancelled_donation_details'];
		// End Of Cancelled Donation Receipts Single Date & Multidate
		
		// Start Of Hundi Receipts Single Date & Multidate
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_CATEGORY_ID=3";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."'  and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_CATEGORY_ID=3";
				}
			}
			
			$this->db->select()->from('TRUST_EVENT_RECEIPT')->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->where($queryString);
		} else { 
			//hundi
			$this->db->select()->from('TRUST_EVENT_RECEIPT')->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID')
			->where(array('TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE'=>$date,'TET_RECEIPT_CATEGORY_ID'=>3,'TET_RECEIPT_ACTIVE'=>1));
		}
		$query = $this->db->get();
		$data['hundi'] = $query->result("array");
		$_SESSION['hundi'] = $data['hundi'];
		$_SESSION['hundinew'] = $data['hundi']; // duplicate session variable becouse above value is getting re assigned to empty
		// End Of Hundi Receipts Single Date & Multidate

		// Start Of Cancelled Hundi Receipts Single Date & Multidate
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=0 and TET_RECEIPT_CATEGORY_ID=3";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."'  and TET_RECEIPT_ACTIVE=0 and TET_RECEIPT_CATEGORY_ID=3";
				}
			}
			
			$this->db->select()->from('TRUST_EVENT_RECEIPT')->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			$this->db->where($queryString);
		} else { 
			//hundi
			$this->db->select()->from('TRUST_EVENT_RECEIPT')->join('TRUST_EVENT', 'TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID')
			->where(array('TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE'=>$date,'TET_RECEIPT_CATEGORY_ID'=>3,'TET_RECEIPT_ACTIVE'=>0));
		}
		$query = $this->db->get();
		$data['hundicancelled'] = $query->result("array");
		$_SESSION['hundicancelled'] = $data['hundicancelled'];
		// End Of Cancelled Hundi Receipts Single Date & Multidate

		// Start Of Inkind Receipts Single Date & Multidate
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) { 
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_CATEGORY_ID=4";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_CATEGORY_ID=4";
				}
			}
			// Suraksha Code
			$sql  = 'SELECT TRUST_EVENT_RECEIPT.TET_RECEIPT_NO, TRUST_EVENT_RECEIPT.TET_RECEIPT_NAME,TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE, TRUST_EVENT_INKIND_OFFERED.IK_ITEM_QTY,IK_ITEM_NAME,IK_ITEM_UNIT, SUM(IK_ITEM_QTY) AS amount FROM TRUST_EVENT_RECEIPT JOIN `TRUST_EVENT_INKIND_OFFERED` ON `TRUST_EVENT_INKIND_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE '.$queryString.' GROUP BY TRUST_EVENT_INKIND_OFFERED.IK_ITEM_NAME';
		} else {
			//inkind
			// Suraksha Code
			$sql  = 'SELECT TRUST_EVENT_RECEIPT.TET_RECEIPT_NO, TRUST_EVENT_RECEIPT.TET_RECEIPT_NAME,TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE, TRUST_EVENT_INKIND_OFFERED.IK_ITEM_QTY,IK_ITEM_NAME,IK_ITEM_UNIT, SUM(IK_ITEM_QTY) AS amount FROM TRUST_EVENT_RECEIPT JOIN `TRUST_EVENT_INKIND_OFFERED` ON `TRUST_EVENT_INKIND_OFFERED`.`TET_RECEIPT_ID` = `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_ID` JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE TET_ACTIVE = 1 and `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_DATE` = "'.$date.'" AND `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_CATEGORY_ID` = 4  and TET_RECEIPT_ACTIVE=1  GROUP BY `TRUST_EVENT_INKIND_OFFERED`.`IK_ITEM_NAME`';
		}
		$query = $this->db->query($sql);
		$data['inkind'] = $query->result("array");
		$_SESSION['inkind'] = $data['inkind'];
		// End Of InKind Receipts Single Date & Multidate
		
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_PAYMENT_METHOD=\"Cash\"";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_PAYMENT_METHOD=\"Cash\"";
				}
			}
			
			$sqlPayCash = 'SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE '.$queryString.'';
		} else {
			//PAYMENT MODE
			$sqlPayCash = 'SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE TET_ACTIVE = 1 and `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_DATE` = "'.$date.'" AND `TRUST_EVENT_RECEIPT`.TET_RECEIPT_PAYMENT_METHOD = "Cash" and TET_RECEIPT_ACTIVE=1';
		}
		$queryPayCash = $this->db->query($sqlPayCash);
		$data['PayCash'] = $queryPayCash->first_row()->PRICE;
		$_SESSION['PayCash'] = $data['PayCash'];
		
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_PAYMENT_METHOD=\"Cheque\"";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_PAYMENT_METHOD=\"Cheque\"";
				}
			}
			
			$sqlPayCheque = 'SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE '.$queryString.'';
		} else {
			$sqlPayCheque = 'SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE TET_ACTIVE = 1 and `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_DATE` = "'.$date.'" AND `TRUST_EVENT_RECEIPT`.TET_RECEIPT_PAYMENT_METHOD = "Cheque" and TET_RECEIPT_ACTIVE=1';
		}
		$queryPayCheque = $this->db->query($sqlPayCheque);
		$data['PayCheque'] = $queryPayCheque->first_row()->PRICE;
		$_SESSION['PayCheque'] = $data['PayCheque'];
		
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_PAYMENT_METHOD=\"Direct Credit\"";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_PAYMENT_METHOD=\"Direct Credit\"";
				}
			}
			
			$sqlPayDirect = 'SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE '.$queryString.'';
		} else {
			$sqlPayDirect = 'SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE TET_ACTIVE = 1 and `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_DATE` = "'.$date.'" AND `TRUST_EVENT_RECEIPT`.TET_RECEIPT_PAYMENT_METHOD = "Direct Credit" and TET_RECEIPT_ACTIVE=1';
		}
		
		$queryPayDirect = $this->db->query($sqlPayDirect);
		$data['PayDirect'] = $queryPayDirect->first_row()->PRICE;
		$_SESSION['PayDirect'] = $data['PayDirect'];
		
		if(@$radioOpt == "multiDate") {
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_PAYMENT_METHOD=\"Credit / Debit Card\"";
					else
						$queryString .= " or TET_ACTIVE = 1 and TRUST_EVENT_RECEIPT.TET_RECEIPT_DATE='".$allDates[$i]."' and TET_RECEIPT_ACTIVE=1  and TRUST_EVENT_RECEIPT.TET_RECEIPT_PAYMENT_METHOD=\"Credit / Debit Card\"";
				}
			}
			$sqlPayCredit = 'SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE '.$queryString.'';
		} else {
			$sqlPayCredit = 'SELECT (SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM TRUST_EVENT_RECEIPT JOIN TRUST_EVENT_RECEIPT_CATEGORY ON TRUST_EVENT_RECEIPT_CATEGORY.TET_RECEIPT_CATEGORY_ID = TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE TET_ACTIVE = 1 and `TRUST_EVENT_RECEIPT`.`TET_RECEIPT_DATE` = "'.$date.'" and TET_RECEIPT_ACTIVE=1 AND `TRUST_EVENT_RECEIPT`.TET_RECEIPT_PAYMENT_METHOD = "Credit / Debit Card"';
		}
		$queryPayCredit = $this->db->query($sqlPayCredit);
		$data['PayCredit'] = $queryPayCredit->first_row()->PRICE;
		$_SESSION['PayCredit'] = $data['PayCredit'];

		//for tab name
		$this->db->select()->from('TRUST_EVENT_RECEIPT_CATEGORY');
		$query = $this->db->get();
		$data['eventReceiptCategory'] = $query->result("array");
		$_SESSION['eventReceiptCategory'] = $data['eventReceiptCategory'];
		//for event name
		$data['event'] = $this->obj_trust_events->getEvents();
		$_SESSION['event'] = $data['event']['TET_NAME'];
		
		if(isset($_SESSION['Current_Event_MIS_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/misReport');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	
	//FOR EXCEL FOR REPORT OF EVENT
	
	//Above code commented while merging intern Lathesh code
	function event_mis_report_excel() {
		$radioOpt = @$_POST['radioOpt'];
		$header = "";
		$result = "";
		$totAmt = 0;
		$totCanAmt = 0;
		if($radioOpt == "multiDate")
			$filename = "Current_MIS_Event_Report_from ".$_POST['fromDate']. " to ".$_POST['toDate']; //File Name
		else
			$filename = "Current_MIS_Event_Report_".$_POST['todayDate']; //File Name
		$file_ending = "xls";
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		//header info for browser
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$sep = "\t"; //tabbed character
		
		$totalDonation = intval($_SESSION['donation']);
		$totalHundi = intval($_SESSION['hundi']);
		
		$header .= "\t";
		$header .= $templename[0]["TRUST_NAME"]. "\n\n";
		$header .= "SEVA NAME" . "\t";
		$header .= "SEVAS QTY" . "\t";
		$header .= "AMOUNT" . "\t";
		$header .= "POSTAGE" . "\t";
		$header .= "TOTAL" . "\t";// Lathish code 
			
		for($i = 0; $i < count($_SESSION['seva']); $i++) { 
			$value = "";			
			$value .= '"' . $_SESSION['seva'][$i]['TET_SO_SEVA_NAME'] . '"' . "\t";
			$value .= '"' . $_SESSION['seva'][$i]['SUM(TET_SO_QUANTITY)'] . '"' . "\t";
			$value .= '"' . $_SESSION['seva'][$i]['SUM(TET_SO_QUANTITY*TET_SO_PRICE)'] . '"' . "\t";
			$value .= '"' . $_SESSION['seva'][$i]['POSTAGE_PRICE'] . '"' . "\t";

			$lineTotal=0; 
			$lineTotal = $_SESSION['seva'][$i]['SUM(TET_SO_QUANTITY*TET_SO_PRICE)'] + $_SESSION['seva'][$i]

			['POSTAGE_PRICE'];
			$value .= '"' . $lineTotal . '"' . "\t";

			$totAmt = $totAmt + $_SESSION['seva'][$i]['SUM(TET_SO_QUANTITY*TET_SO_PRICE)'] + $_SESSION['seva'][$i]['POSTAGE_PRICE'];
			$result .= trim($value) . "\n";
		}
		$result .= "\n";
		
		$value = "\n";
		$value .= '"TOTAL SEVA AMOUNT "' . "\t";
		$value .= $totAmt. "\t";
		$result .= trim($value) . "\n";
		$result .= "\n";
		$valSeva = "";
			
		$valSeva .= "Cancelled Sevas:" . "\n\n";						
		$valSeva .= "SEVA NAME" . "\t";
		$valSeva .= "SEVAS QTY" . "\t";
		$valSeva .= "AMOUNT" . "\t";
		$valSeva .= "POSTAGE" . "\t";// Lathish code 
		$valSeva .= "TOTAL" . "\t";// Lathish code 
		$result .= trim($valSeva) . "\n";
		
		for($i = 0; $i < count($_SESSION['cancelledSeva']); $i++) { 
			$value = "";			
			$value .= '"' . $_SESSION['cancelledSeva'][$i]['TET_SO_SEVA_NAME'] . '"' . "\t";
			$value .= '"' . $_SESSION['cancelledSeva'][$i]['SUM(TET_SO_QUANTITY)'] . '"' . "\t";
			$value .= '"' . $_SESSION['cancelledSeva'][$i]['SUM(TET_SO_QUANTITY*TET_SO_PRICE)'] . '"' . "\t";
			
			// Lathish code Starts
			$value .= '"' . $_SESSION['seva'][$i]['POSTAGE_PRICE'] . '"' . "\t";

			$lineTotal = $_SESSION['cancelledSeva'][$i]['SUM(TET_SO_QUANTITY*TET_SO_PRICE)'] + $_SESSION['cancelledSeva'][$i]['POSTAGE_PRICE'];
				$value .= '"' . $lineTotal . '"' . "\t";

			// Lathish code Ends

			//changes
			$totCanAmt = $totCanAmt + $_SESSION['cancelledSeva'][$i]['SUM(TET_SO_QUANTITY*TET_SO_PRICE)'] ;


			$result .= trim($value) . "\n";
		}
		$result .= "\n";
		$value = "\n";
		$value .= '"TOTAL CANCELLED SEVA AMOUNT "' . "\t";
		$value .= $totCanAmt. "\t";
		$result .= trim($value) . "\n";
		$result .= "\n";
		$valSeva = "";
			//end changes

		
		//donation
		$valDon = "";
		$totDonAmt = 0;
		$valDon .= "DONATION / KANIKE:" . "\n";						
		$valDon .= "Receipt No" . "\t";
		$valDon .= "Payment Mode" . "\t";
		$valDon .= "Payment Notes" . "\t";
		$valDon .= "Amount" . "\t";
		$result .= trim($valDon) . "\n";
		
		for($i = 0; $i < count($_SESSION['donation_details']); $i++) { 
			$value = "";			
			$value .= '"' . $_SESSION['donation_details'][$i]['TET_RECEIPT_NO'] . '"' . "\t";
			$value .= '"' . $_SESSION['donation_details'][$i]['TET_RECEIPT_PAYMENT_METHOD'] . '"' . "\t";
			$value .= '"' . $_SESSION['donation_details'][$i]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] . '"' . "\t";
			$value .= '"' . $_SESSION['donation_details'][$i]['TET_RECEIPT_PRICE'] . '"' . "\t";
			//changes
			$totDonAmt = $totDonAmt + $_SESSION['donation_details'][$i]['TET_RECEIPT_PRICE'] ;
			$result .= trim($value) . "\n";
		}
		$value = '"Total Donation / Kanike Amount "' . "\t";
		$value .= "\t";
		$value .= "\t";
		$value .= $totDonAmt. "\t";
		$result .= trim($value) . "\n";
		$result .= "\n";
		//END DONATION		
		
		//CANCEL donation
		$valDon = "";
		$totCanDonAmt = 0;
		$valDon .= "CANCELLED DONATION / KANIKE:" . "\n";						
		$valDon .= "Receipt No" . "\t";
		$valDon .= "Payment Mode" . "\t";
		$valDon .= "Payment Notes" . "\t";
		$valDon .= "Amount" . "\t";
		$result .= trim($valDon) . "\n";
		
		for($i = 0; $i < count($_SESSION['cancelled_donation_details']); $i++) { 
			$value = "";			
			$value .= '"' . $_SESSION['cancelled_donation_details'][$i]['TET_RECEIPT_NO'] . '"' . "\t";
			$value .= '"' . $_SESSION['cancelled_donation_details'][$i]['TET_RECEIPT_PAYMENT_METHOD'] . '"' . "\t";
			$value .= '"' . $_SESSION['cancelled_donation_details'][$i]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] . '"' . "\t";
			$value .= '"' . $_SESSION['cancelled_donation_details'][$i]['TET_RECEIPT_PRICE'] . '"' . "\t";
			//changes
			$totCanDonAmt = $totCanDonAmt + $_SESSION['cancelled_donation_details'][$i]['TET_RECEIPT_PRICE'] ;
			$result .= trim($value) . "\n";
		}
		$value = '"Total Donation / Kanike Amount "' . "\t";
		$value .= "\t";
		$value .= "\t";
		$value .= $totCanDonAmt. "\t";
		$result .= trim($value) . "\n";
		$result .= "\n";
		//END DONATION		


		//Hundi
		$valHundi = "";
		$totHundiAmt = 0;
		$valHundi .= "Hundi:" . "\n";						
		$valHundi .= "Receipt No" . "\t";
		$valHundi .= "Payment Mode" . "\t";
		$valHundi .= "Payment Notes" . "\t";
		$valHundi .= "Amount" . "\t";
		$result .= trim($valHundi) . "\n";
		
		for($i = 0; $i < count($_SESSION['hundinew']); $i++) { 
			$value = "";			
			$value .= '"' . $_SESSION['hundinew'][$i]['TET_RECEIPT_NO'] . '"' . "\t";
			$value .= '"' . $_SESSION['hundinew'][$i]['TET_RECEIPT_PAYMENT_METHOD'] . '"' . "\t";
			$value .= '"' . $_SESSION['hundinew'][$i]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] . '"' . "\t";
			$value .= '"' . $_SESSION['hundinew'][$i]['TET_RECEIPT_PRICE'] . '"' . "\t";
			//changes
			$totHundiAmt = $totHundiAmt + $_SESSION['hundinew'][$i]['TET_RECEIPT_PRICE'] ;
			$result .= trim($value) . "\n";
		}
		$value = '"Total Hundi Amount "' . "\t";
		$value .= "\t";
		$value .= "\t";
		$value .= $totHundiAmt. "\t";
		$result .= trim($value) . "\n";
		$result .= "\n";
		//END Hundi		
		
		//CANCEL Hundi
		$valDon = "";
		$totHundiCanAmt = 0;
		$valHundi = "";
		$valHundi .= "Cancelled Hundi:" . "\n";						
		$valHundi .= "Receipt No" . "\t";
		$valHundi .= "Payment Mode" . "\t";
		$valHundi .= "Payment Notes" . "\t";
		$valHundi .= "Amount" . "\t";
		$result .= trim($valHundi) . "\n";
		
		for($i = 0; $i < count($_SESSION['hundinew']); $i++) { 
			$value = "";		
			$value .= '"' . $_SESSION['hundinew'][$i]['TET_RECEIPT_NO'] . '"' . "\t";
			$value .= '"' . $_SESSION['hundinew'][$i]['TET_RECEIPT_PAYMENT_METHOD'] . '"' . "\t";
			$value .= '"' . $_SESSION['hundinew'][$i]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] . '"' . "\t";
			$value .= '"' . $_SESSION['hundinew'][$i]['TET_RECEIPT_PRICE'] . '"' . "\t";
			//changes
			$totHundiCanAmt = $totHundiCanAmt + $_SESSION['hundinew'][$i]['TET_RECEIPT_PRICE'] ;
			$result .= trim($value) . "\n";
		}
		$value = '"Total Hundi Amount "' . "\t";
		$value .= "\t";
		$value .= "\t";
		$value .= $totHundiCanAmt. "\t";
		$result .= trim($value) . "\n";
		$result .= "\n";
		//END Hundi		

		//inkind
		if(!empty($_SESSION['inkind'])) {
			$value3 = "";
			$value3 .= "Inkind:" . "\n";
			// Suraksha Code
			$value3 .= "RECEIPT NO" . "\t";
			$value3 .= "NAME" . "\t";
			$value3 .= "ITEM NAME" . "\t";
			$value3 .= "QUANTITY" . "\t";
			$result .= trim($value3) . "\n";
			for($j = 0; $j < count($_SESSION['inkind']); $j++) {
				$value4 = "";
				// Suraksha Code
				$value4 .= '"' . $_SESSION['inkind'][$j]['TET_RECEIPT_NO'] . '"' . "\t";
				$value4 .= '"' . $_SESSION['inkind'][$j]['TET_RECEIPT_NAME'] . '"' . "\t";
				$value4 .= '"' . $_SESSION['inkind'][$j]['IK_ITEM_NAME'] . '"' . "\t";
				$value4 .= '"' . $_SESSION['inkind'][$j]['amount']." ".$_SESSION['inkind'][$j]['IK_ITEM_UNIT'] . '"' . "\t";
				$result .= trim($value4) . "\n";
			}

		}
		//end inkind
		//Transaction Summary
        $result .= "\n";
		$totAmount =0;
		$value7 = "";
		$value7 = "Transaction Summary:"."\n";
		$value7 .= "CASH" . "\t";
		$value7 .= "CHEQUE" . "\t";
		$value7 .= "DIRECT CREDIT" . "\t";
		$value7 .= "CREDIT/DEBIT CARD" . "\t";
		$value7 .= "GRAND TOTAL" . "\t";
		$result .= trim($value7) . "\n";
		$value8 = "";
		if(!empty($_SESSION['PayCash'])){	
			$value8 .= '"' . $_SESSION['PayCash'] . '"' . "\t";
			$totAmount = $totAmount + $_SESSION['PayCash'];
		} else {
			$value8 .= '"0"' . "\t";
		}
		if(!empty($_SESSION['PayCheque'])){	
			$value8 .= '"' . $_SESSION['PayCheque'] . '"' . "\t";
			$totAmount = $totAmount + $_SESSION['PayCheque'];
		} else {
			$value8 .= '"0"' . "\t";
		}
		if(!empty($_SESSION['PayDirect'])){	
			$value8 .= '"' . $_SESSION['PayDirect'] . '"' . "\t";
			$totAmount = $totAmount + $_SESSION['PayDirect'];
		} else {
			$value8 .= '"0"' . "\t";
		}
		if(!empty($_SESSION['PayCredit'])){	
			$value8 .= '"' . $_SESSION['PayCredit'] . '"' . "\t";
			$totAmount = $totAmount + $_SESSION['PayCredit'];
		} else {
			$value8 .= '"0"' . "\t";
		}
		$value8 .= '"' . $totAmount . '"' . "\t";
		$result .= trim($value8) . "\n";	
		$result = str_replace( "\r" , "" , $result );
		print("$header\n$result"); 
		//end Transaction Summary
	}

	//CURRENT EVENT INKIND START
	function trust_inkind_report($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		//Radio Option
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		
		//Unset Session
		unset($_SESSION['date']);
		unset($_SESSION['deityId']);
		unset($_SESSION['paymentMethod']);
		unset($_SESSION['fromDate']);
		unset($_SESSION['toDate']);
		
		//For Menu Selection
		$data['whichTab'] = "report";
		$data['date'] = date('d-m-Y');
		
		$conditionOne = "";
		$fromDate = date("d-m-Y");
		$data['trust_inkind'] = $this->obj_report->get_all_trust_inkind_report($fromDate,'','','', 10,$start);
		$data['trust_inkind_count'] = $this->obj_report->count_get_all_trust_inkind_report($fromDate,'','','');

		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/trust_inkind_report';
		$data['total_rows'] =$config['total_rows'] = $this->obj_report->count_all_field_trust_day_book($fromDate,'','','');
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
		
		if(isset($_SESSION['Trust_Receipt_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trustInkindReport');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	function trust_inkind_report_on_change_date($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		//For Menu Selection
		$data['whichTab'] = "report";
		
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
		
		if(@$_SESSION['date'] == "") {
			$this->session->set_userdata('date', $this->input->post('tdate'));
			$data['date'] = $_SESSION['date'];
			$date = $this->input->post('tdate');
		} else {
			$date = $_SESSION['date'];
			$data['date'] = $_SESSION['date'];
		}

		$this->load->library('pagination');
		if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
			$data['trust_inkind'] = $this->obj_report->get_all_trust_inkind_report($_SESSION['fromDate'],$_SESSION['toDate'],'','', 10,$start);
			$data['total_rows'] = $config['total_rows'] = $this->obj_report->count_get_all_trust_inkind_report($_SESSION['fromDate'],$_SESSION['toDate'],'','');
			
		} else {
			$data['trust_inkind'] = $this->obj_report->get_all_trust_inkind_report($_SESSION['date'],'','','', 10,$start);
			$data['total_rows'] = $config['total_rows'] = $this->obj_report->count_get_all_trust_inkind_report($_SESSION['date'],'','','');
		}
		//$this->output->enable_profiler(true);
		//pagination starts
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$config['base_url'] = base_url().'TrustReport/trust_inkind_report_on_change_date';
		
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
		
		
		if(isset($_SESSION['Trust_Receipt_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/trustInkindReport');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}	

	function trust_inkind_report_excel() {
		$data['whichTab'] = "hallReport";
		if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
			$trust_inkind = $this->obj_report->get_all_trust_inkind_report_excel($_SESSION['fromDate'],$_SESSION['toDate'],'','');
			$filename = "Trust_Inkind_Report_from ".$_SESSION['fromDate']. " to ".$_SESSION['toDate']; //File Name
		} else if(@$_SESSION['date']){
			$trust_inkind = $this->obj_report->get_all_trust_inkind_report_excel($_SESSION['date'],'','','');
			$filename = "Trust_Inkind_Report_from".$_SESSION['date']; //File Name
		} else {
			$trust_inkind = $this->obj_report->get_all_trust_inkind_report_excel(date("d-m-Y"),'','','');
			$filename = "Trust_Inkind_Report_from".date("d-m-Y"); //File Name
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$file_ending = "xls";
	
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$sep = "\t"; //tabbed character
		$header = "";
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= $templename[0]["TRUST_NAME"]. "\n\n";
		$header .= "SI NO." . "\t";
		$header .= "Receipt No." . "\t";
		$header .= "Receipt Date" . "\t";
		$header .= "Receipt For" . "\t";
		$header .= "Receipt Type" . "\t";
		$header .= "Event Seva" . "\t";
		$header .= "Event" . "\t";
		$header .= "Name" . "\t";
		$header .= "Estimated Price" . "\t";
		$header .= "Description" . "\t";
		$header .= "Payment Mode" . "\t";
		$header .= "Qty" . "\t";
		$header .= "Amount" . "\t";
		$header .= "Postage" . "\t";
		$header .= "Grand Total" . "\t";
		$header .= "Payment Notes" . "\t";
		// $header .= "User" . "\t";
		$header .= "Payment Status" . "\t";
		$header .= "Cancelled Notes" . "\t";

		$result = "";
		
		$amount = 0; $cash = 0; $cheque = 0; $debitCredit = 0; $directCredit = 0; $i = 0;
		foreach($trust_inkind as $res) {
			if($res->qty != ""){
				$amt = intval($res->amt)*intval($res->qty);
				$total =intval($res->total)*intval($res->qty);
			}else{
				$amt = $res->amt;
				$total = $res->total;
			}

			$value = "";
			if($res->rType != "") {
				$value .= '"' . (++$i) . '"' . "\t";			
				$value .= '"' . $res->rNo . '"' . "\t";
				$value .= '"' . $res->rDate . '"' . "\t";
			} else {
				$value .= '"' . "" . '"' . "\t";			
				$value .= '"' . "" . '"' . "\t";
				$value .= '"' . "" . '"' . "\t";
			}	
			$value .= '"' . $res->receiptFor .'"'. "\t";
			$value .= '"' . $res->rType .'"'. "\t";
			$value .= '"' . $res->sevaName .'"'. "\t";
			$value .= '"' . $res->dtetName .'"'. "\t";
			$value .= '"' . $res->rName . '"' . "\t";
			$value .= '"' . $res->apprxAmt . '"' . "\t";
			$value .= '"' . $res->itemDesc . '"' . "\t";
			$value .= '"' . $res->rPayMethod . '"' . "\t";
			if($res->rCatId == "4") {
					$value .= '"' . $res->sevaQty . '"' . "\t";
				} else  {
					$value .= '"' . "" . '"' . "\t";
				}
			$value .= '"' . $amt . '"' . "\t";
			if($res->rType == "Seva") {
				$value .= '"' . $res->amtPostage . '"' . "\t";
			} else  {
				$value .= '"' . "" . '"' . "\t";
			}
			$value .= '"' . $total . '"' . "\t";
			$value .= '"' . $res->RPMNotes . '"' . "\t";
			// $value .= '"' . $res->user . '"' . "\t";
			$value .= '"' . $res->status . '"' . "\t";
			$value .= '"' . $res->cnclNotes . '"' . "\t";
			$result .= trim($value) . "\n";
		}
		$result .= "\n";
		
		
		$result = str_replace( "\r" , "" , $result );
		print("$header\n$result"); 
	}
	//CURRENT EVENT INKIND END

	//TRUST INKIND START
	function t_inkind_report($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		//Radio Option
		$radioOpt = @$_POST['radioOpt'];
		if($radioOpt == "")
			$radioOpt = "date";
		
		$data['radioOpt'] = $radioOpt;
		
		//Unset Session
		unset($_SESSION['date']);
		unset($_SESSION['deityId']);
		unset($_SESSION['paymentMethod']);
		unset($_SESSION['fromDate']);
		unset($_SESSION['toDate']);
		
		//For Menu Selection
		$data['whichTab'] = "report";
		$data['date'] = date('d-m-Y');
		
		$conditionOne = "";
		$fromDate = date("d-m-Y");
		$data['trust_inkind'] = $this->obj_report->get_all_t_inkind_report($fromDate,'','','', 10,$start);
		$data['trust_inkind_count'] = $this->obj_report->count_get_all_t_inkind_report($fromDate,'','','');
     
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$this->load->library('pagination');
		$config['base_url'] = base_url().'TrustReport/trust_inkind_report';
		$data['total_rows'] =$config['total_rows'] = $this->obj_report->count_get_all_t_inkind_report($fromDate,'','','');
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

		//print_r($data);
	
		if(isset($_SESSION['Trust_Inkind_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/tInkindReport');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	function t_inkind_report_on_change_date($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		//For Menu Selection
		$data['whichTab'] = "report";
		
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
		
		if(@$_SESSION['date'] == "") {
			$this->session->set_userdata('date', $this->input->post('tdate'));
			$data['date'] = $_SESSION['date'];
			$date = $this->input->post('tdate');
		} else {
			$date = $_SESSION['date'];
			$data['date'] = $_SESSION['date'];
		}

		$this->load->library('pagination');
		if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
			$data['trust_inkind'] = $this->obj_report->get_all_t_inkind_report($_SESSION['fromDate'],$_SESSION['toDate'],'','', 10,$start);
			$data['total_rows'] = $config['total_rows'] = $this->obj_report->count_get_all_t_inkind_report($_SESSION['fromDate'],$_SESSION['toDate'],'','');
			
		} else {
			$data['trust_inkind'] = $this->obj_report->get_all_t_inkind_report($_SESSION['date'],'','','', 10,$start);
			$data['total_rows'] = $config['total_rows'] = $this->obj_report->count_get_all_t_inkind_report($_SESSION['date'],'','','');
		}
		//$this->output->enable_profiler(true);
		//pagination starts
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$config['base_url'] = base_url().'TrustReport/t_inkind_report_on_change_date';
		
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
		
		
		if(isset($_SESSION['Trust_Receipt_Report'])) {
			$this->load->view('header', $data);
			$this->load->view('trust/tInkindReport');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}	

	function t_inkind_report_excel() {
		$data['whichTab'] = "hallReport";
		if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
			$trust_inkind = $this->obj_report->get_all_t_inkind_report_excel($_SESSION['fromDate'],$_SESSION['toDate'],'','');
			$filename = "Trust_Inkind_Report_from ".$_SESSION['fromDate']. " to ".$_SESSION['toDate']; //File Name
		} else if(@$_SESSION['date']){
			$trust_inkind = $this->obj_report->get_all_t_inkind_report_excel($_SESSION['date'],'','','');
			$filename = "Trust_Inkind_Report_from".$_SESSION['date']; //File Name
		} else {
			$trust_inkind = $this->obj_report->get_all_t_inkind_report_excel(date("d-m-Y"),'','','');
			$filename = "Trust_Inkind_Report_from".date("d-m-Y"); //File Name
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$file_ending = "xls";
	
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$sep = "\t"; //tabbed character
		$header = "";
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= "\t";
		$header .= $templename[0]["TRUST_NAME"]. "\n\n";
		$header .= "SI NO." . "\t";
		$header .= "Receipt No." . "\t";
		$header .= "Receipt Date" . "\t";
		$header .= "Receipt For" . "\t";
		$header .= "Receipt Type" . "\t";
		$header .= "Event Seva" . "\t";
		$header .= "Name" . "\t";
		$header .= "Estimated Price" . "\t";
		$header .= "Description" . "\t";
		$header .= "Payment Mode" . "\t";
		$header .= "Qty" . "\t";
		$header .= "Amount" . "\t";
		$header .= "Postage" . "\t";
		$header .= "Grand Total" . "\t";
		$header .= "Payment Notes" . "\t";
		// $header .= "User" . "\t";
		$header .= "Payment Status" . "\t";
		$header .= "Cancelled Notes" . "\t";

		$result = "";
		
		$amount = 0; $cash = 0; $cheque = 0; $debitCredit = 0; $directCredit = 0; $i = 0;
		foreach($trust_inkind as $res) {
			if($res->qty != ""){
				$amt = intval($res->amt)*intval($res->qty);
				$total =intval($res->total)*intval($res->qty);
			}else{
				$amt = $res->amt;
				$total = $res->total;
			}

			$value = "";
			if($res->rType != "") {
				$value .= '"' . (++$i) . '"' . "\t";			
				$value .= '"' . $res->rNo . '"' . "\t";
				$value .= '"' . $res->rDate . '"' . "\t";
			} else {
				$value .= '"' . "" . '"' . "\t";			
				$value .= '"' . "" . '"' . "\t";
				$value .= '"' . "" . '"' . "\t";
			}	
			$value .= '"' . $res->receiptFor .'"'. "\t";
			$value .= '"' . $res->rType .'"'. "\t";
			$value .= '"' . $res->sevaName .'"'. "\t";
			$value .= '"' . $res->rName . '"' . "\t";
			$value .= '"' . $res->apprxAmt . '"' . "\t";
			$value .= '"' . $res->itemDesc . '"' . "\t";
			$value .= '"' . $res->rPayMethod . '"' . "\t";
			if($res->rCatId == "4") {
					$value .= '"' . $res->sevaQty . '"' . "\t";
				} else  {
					$value .= '"' . "" . '"' . "\t";
				}
			$value .= '"' . $amt . '"' . "\t";
			if($res->rType == "Seva") {
				$value .= '"' . $res->amtPostage . '"' . "\t";
			} else  {
				$value .= '"' . "" . '"' . "\t";
			}
			$value .= '"' . $total . '"' . "\t";
			$value .= '"' . $res->RPMNotes . '"' . "\t";
			// $value .= '"' . $res->user . '"' . "\t";
			$value .= '"' . $res->status . '"' . "\t";
			$value .= '"' . $res->cnclNotes . '"' . "\t";
			$result .= trim($value) . "\n";
		}
		$result .= "\n";
		
		
		$result = str_replace( "\r" , "" , $result );
		print("$header\n$result"); 
	}
	//TRUST INKIND END
}
?>
