<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Postage extends CI_Controller {
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
			$this->load->model('Postage_model','obj_postage',true);		
			$this->load->model('Shashwath_Model','obj_shashwath',true);
			
			$this->load->add_package_path( APPPATH . 'third_party/fpdf17');

			//CHECK LOGIN
			if(!isset($_SESSION['userId']))
				redirect('login');
			
			if($_SESSION['trustLogin'] == 1) 
				redirect('Trust');

			$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
			$query = $this->db->get();
			$_SESSION['eventActiveCount'] = $query->num_rows();
		}
		
		//DISPATCH PENDING
		function dispatch_collection($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$data['whichTab'] = "postage";
			
			//Unset Session
			unset($_SESSION['date']);
			unset($_SESSION['lblCounter']);
			unset($_SESSION['name_phone']);
			
			$data['date'] = date('d-m-Y');
			$data['lblCounter'] = "";

			$condition = array('POSTAGE_STATUS' => 0,'DATE' => date('d-m-Y'),'RECEIPT_ACTIVE' => 1,'POSTAGE_CATEGORY' => 1);
			$data['dispatchData'] = $this->obj_postage->get_all_fields_data($condition,'','POSTAGE_ID','DESC',10, $start);
			
			$conditionOne = array('DATE' => date('d-m-Y'),'POSTAGE_CATEGORY' => 1);
			$data['labelCounter'] = $this->obj_postage->get_distinct_data_counter($conditionOne,'LABEL_COUNTER');

			$conditionTwo = array('POSTAGE_STATUS' => 0,'RECEIPT_ACTIVE' => 1,'POSTAGE_CATEGORY' => 1);
			$_SESSION['dispatchCount'] = $this->obj_postage->get_sum_undispatched_counter($conditionTwo);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Postage/dispatch_collection';
			$config['total_rows'] = $this->obj_postage->count_rows_dispatch_collection($condition,'','',10, $start);
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

			//$this->output->enable_profiler(TRUE);
			
			if(isset($_SESSION['Dispatch_Collection'])) {
				$this->load->view('header',$data);
				$this->load->view('dispatch_collection');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FILTER DATA DISPATCH PENDING
		function get_filter_data($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;

			$data['whichTab'] = "postage";
			//Date Field
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
			//Combo Box Label Counter
			if(isset($_POST['labelCounter'])) {
				unset($_SESSION['lblCounter']);
				$lblCounter = $this->input->post('labelCounter');
				$data['lblCount'] = $lblCounter;
			}
			
			if(@$_SESSION['lblCounter'] == "") {
				$this->session->set_userdata('lblCounter', $this->input->post('labelCounter'));
				$data['lblCount'] = $_SESSION['lblCounter'];
				$lblCounter = $this->input->post('labelCounter');
			} else {
				$lblCounter = $_SESSION['lblCounter'];
				$data['lblCount'] = $_SESSION['lblCounter'];
			}
			//Search Box Name And Phone
			if(@$_POST['name_phone']) {
				unset($_SESSION['name_phone']);
				$name_phone = $this->input->post('name_phone');
				$data['name_phone'] = $name_phone;
			}
			
			if(@$_SESSION['name_phone'] == "") {
				$this->session->set_userdata('name_phone', $this->input->post('name_phone'));
				$data['name_phone'] = $_SESSION['name_phone'];
				$name_phone = $this->input->post('name_phone');
			} else {
				$name_phone = $_SESSION['name_phone'];
				$data['name_phone'] = $_SESSION['name_phone'];
			}
			
			if($name_phone != "" && $lblCounter != "All") {
				$condition = array('POSTAGE_STATUS' => 0,'POSTAGE_CATEGORY' => 1,'LABEL_COUNTER' => $lblCounter,'DATE' => $date,'RECEIPT_ACTIVE' => 1,'RECEIPT_NAME' => $name_phone);
				$or_condition = array('RECEIPT_PHONE' => $name_phone);
			} else if($name_phone != "" && $lblCounter == "All") {
				$condition = array('POSTAGE_STATUS' => 0,'POSTAGE_CATEGORY' => 1,'DATE' => $date,'RECEIPT_ACTIVE' => 1,'RECEIPT_NAME' => $name_phone);			
				$or_condition = array('RECEIPT_PHONE' => $name_phone);
			} else if($name_phone == "" && $lblCounter != "All") {
				$condition = array('POSTAGE_STATUS' => 0,'POSTAGE_CATEGORY' => 1,'LABEL_COUNTER' => $lblCounter,'DATE' => $date,'RECEIPT_ACTIVE' => 1);			
				$or_condition = array();
			} else {
				$condition = array('POSTAGE_STATUS' => 0,'POSTAGE_CATEGORY' => 1,'DATE' => $date,'RECEIPT_ACTIVE' => 1);			
				$or_condition = array();
			}

			$conditionOne = array('DATE' => $date,'RECEIPT_ACTIVE' => 1,'POSTAGE_CATEGORY' => 1);
			$data['dispatchData'] = $this->obj_postage->get_all_fields_data($condition,$or_condition,'POSTAGE_ID','DESC',10, $start);
			$data['labelCounter'] = $this->obj_postage->get_distinct_data_counter($conditionOne,'LABEL_COUNTER');
			$conditionTwo = array('POSTAGE_STATUS' => 0,'RECEIPT_ACTIVE' => 1,'POSTAGE_CATEGORY' => 1);
			$_SESSION['dispatchCount'] = $this->obj_postage->get_sum_undispatched_counter($conditionTwo);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Postage/get_filter_data';
			$config['total_rows'] = $this->obj_postage->count_rows_dispatch_collection($condition,'','',10, $start);
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

			//$this->output->enable_profiler(TRUE);
			
			if(isset($_SESSION['Dispatch_Collection'])) {
				$this->load->view('header',$data);
				$this->load->view('dispatch_collection');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//SAVE DISPATCH DETAILS
		function save_dispatch_details() {
			$postId = $_POST['post_id'];
			$postCmpName = $_POST['post_comp_name'];
			$postActAmt = $_POST['post_actual_amt'];
			$postTrackNo = $_POST['post_track_no'];

			$condition = array("POSTAGE_ID" => $postId);
			$data_array = array("REVISED_PRICE" => $postActAmt, "POSTAGE_COMPANY" => $postCmpName, "POSTAGE_TRACKING" => $postTrackNo);
			$this->obj_postage->update_model($condition,$data_array);
			redirect($_SESSION['actual_link']);
		}

		//GENERATE EXCEL REPORT
		function get_excel_report() {
			$header = "";
			$result = ""; 
			$filename = "Postage_Report - ".date('d-m-Y');  //File Name
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
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";
			$header .= "SI NO." . "\t";
			$header .= "RECEIPT NO." . "\t";
			$header .= "NAME" . "\t";
			$header .= "PHONE" . "\t";
			$header .= "ADDRESS LINE1" . "\t";
			$header .= "ADDRESS LINE2" . "\t";
			$header .= "CITY" . "\t";
			$header .= "COUNTRY" . "\t";
			$header .= "PINCODE" . "\t";
			$header .= "POSTAGE AMOUNT" . "\t";
			$header .= "ACTUAL AMOUNT" . "\t";
			$header .= "COMPANY" . "\t";
			$header .= "TRACKING NO." . "\t";

			//Date Field
			$date = $this->input->post('tdate');
			
			//Combo Box Label Counter
			$lblCounter = $this->input->post('labelCounter');
			
			//Search Box Name And Phone
			$name_phone = $this->input->post('name_phone');
			
			if($name_phone != "" && $lblCounter != "All") {
				$condition = array('POSTAGE_STATUS' => 0,'POSTAGE_CATEGORY' => 1,'LABEL_COUNTER' => $lblCounter,'DATE' => $date,'RECEIPT_ACTIVE' => 1,'RECEIPT_NAME' => $name_phone);
				$or_condition = array('RECEIPT_PHONE' => $name_phone);
			} else if($name_phone != "" && $lblCounter == "All") {
				$condition = array('POSTAGE_STATUS' => 0,'POSTAGE_CATEGORY' => 1,'DATE' => $date,'RECEIPT_ACTIVE' => 1,'RECEIPT_NAME' => $name_phone);			
				$or_condition = array('RECEIPT_PHONE' => $name_phone);
			} else if($name_phone == "" && $lblCounter != "All") {
				$condition = array('POSTAGE_STATUS' => 0,'POSTAGE_CATEGORY' => 1,'LABEL_COUNTER' => $lblCounter,'DATE' => $date,'RECEIPT_ACTIVE' => 1);			
				$or_condition = array();
			} else {
				$condition = array('POSTAGE_STATUS' => 0,'POSTAGE_CATEGORY' => 1,'DATE' => $date,'RECEIPT_ACTIVE' => 1);			
				$or_condition = array();
			}

			$resultPostage = $this->obj_postage->get_all_fields_data_excel($condition,$or_condition,'POSTAGE_ID','DESC');

			for($i = 0; $i < sizeof($resultPostage); $i++)
			{
				$line = '';    
				$value = "";		

				$value .= '"' . ($i+1) . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->RECEIPT_NO . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->RECEIPT_NAME . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->RECEIPT_PHONE . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->ADDRESS_LINE1 . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->ADDRESS_LINE2 . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->CITY . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->COUNTRY . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->PINCODE . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->POSTAGE_PRICE . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->REVISED_PRICE . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->POSTAGE_COMPANY . '"' . "\t";
				$value .= '"' . $resultPostage[$i]->POSTAGE_TRACKING . '"' . "\t";

				$line .= $value;
				$result .= trim($line) . "\n";
			}
			
			$result = str_replace( "\r" , "" , $result );
			   
			print("$header\n$result"); 
		}

		//ALL POSTAGE COLLECTION
		function all_postage_collection($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;

			$data['whichTab'] = "postage";
			$condition = array('RECEIPT_ACTIVE' => 1,'POSTAGE_CATEGORY' => 1);
			$or_condition = array();
			$data['allCollection'] = $this->obj_postage->get_all_fields_data($condition,$or_condition,'POSTAGE_ID','DESC',10, $start);

			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Postage/all_postage_collection';
			$config['total_rows'] = $this->obj_postage->count_rows_dispatch_collection($condition,'','',10, $start);
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

			//$this->output->enable_profiler(TRUE);


			if(isset($_SESSION['All_Postage_Collection'])) {
				$this->load->view('header',$data);
				$this->load->view('all_postage_collection');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}


		function postage_group($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			$data['whichTab'] = "postage";

            if(isset($_POST['date'])) {
				$date = $_POST['date']; 
			} 
			else {
				$date = '';
			}
			
			$data['date'] = $date;

			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;

			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 ";
			$data['allCollection'] = json_encode($this->obj_postage->get_slvt_postage_data($condition,'RECEIPT_ID','ASC',10, $start,true));
			$data['fullCollection'] = json_encode($this->obj_postage->get_slvt_postage_data($condition,'RECEIPT_ID','ASC',10, $start,false));

			$_SESSION['chosenCategory'] = "All Category";
			$_SESSION['chosenCriteria'] = "1";
			$_SESSION['chosenArea'] = "All";

			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Postage/postage_group';
			$data['total_rows'] = $config['total_rows'] = $this->obj_postage->slvt_postage_rows_collection($condition,'RECEIPT_ID','ASC',10, $start);
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

			if(isset($_SESSION['Postage_Group'])) {
				$this->load->view('header',$data);
				$this->load->view('postage_group');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}


		function postage_address_edit() {
			if(isset($_POST)){
				$data['RECEIPT_ID'] = $ReceiptId= $this->input->post('RECEIPT_ID');
			}
			$data['postageAdrs'] = $this->obj_postage->get_postage_address($ReceiptId);
			$this->load->view('header',$data);
			$this->load->view('editPostageAddress');
			$this->load->view('footer_home');
		}

		function update_postage_adrs_details(){
		$RECEIPT_ID = $this->input->post('RECEIPT_ID');

		$addLine1 = $this->input->post('addLine1');
		$addLine2 = $this->input->post('addLine2');
		$city = $this->input->post('city');
		$country = $this->input->post('country');
		$pincode = $this->input->post('pincode');
		$address = $this->input->post('address');

		
		$data = array(
			'ADDRESS_LINE1' => $addLine1,
			'ADDRESS_LINE2' => $addLine2,
			'CITY' => $city,
			'COUNTRY' => $country,
			'PINCODE' => $pincode,
			'RECEIPT_ADDRESS' => $address
		);
		$this->obj_postage->updatePostageAddressDetails($data,$RECEIPT_ID);
		redirect('Postage/postage_group');
	}

		
	//FILTER POSTAGE GROUPS
	function slvt_postage_data($start = 0) {

	       if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
        $data['radioOpt'] = $radioOpt;

	       if(isset($_POST['date'])) {
				$date= @$_POST['date'];
		    }
		    else {
		    	$date = @$_POST['date'];
		    } 
			
		$data['date'] = $date;

			if(isset($_POST['fromDate'])) 
			{
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

		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;

			if($radioOpt == "date") {
	                if($start > 0) {
	                  $fromDate = $date;
					  $toDate = $date;	
	                }
	                 else {
		               $fromDate = @$_POST['todayDate'];
					   $toDate = @$_POST['todayDate'];
	                 }	
				}
			else {
	            if($start > 0){
	            	$fromDate = $_SESSION['fromDate'];
	            	$toDate = $_SESSION['toDate'];
	            }
	            else {
	            	$fromDate = $_POST['fromDate'];
				    $toDate = $_POST['toDate'];
	            }
			}
	
		$data['whichTab'] = "postage";

		if(isset($_POST['slvtPostageGrps']) && isset($_POST['postageCriteria'])) {
			$_SESSION['chosenCategory'] = $slvtPostage = @$_POST['slvtPostageGrps'];
			$_SESSION['chosenCriteria'] = $postageCriteria = @$_POST['postageCriteria'];
			$_SESSION['chosenArea'] = $postageAreaFilter = @$_POST['postageAreaFilter'];
		}
		else {
			$_SESSION['chosenCategory'] = $slvtPostage = @$_SESSION['chosenCategory'];
			$_SESSION['chosenCriteria'] = $postageCriteria = @$_SESSION['chosenCriteria'];
			$_SESSION['chosenArea'] = $postageAreaFilter = @$_SESSION['chosenArea'];
		}

		$areaCondition = "";
		if($postageAreaFilter == "Udupi"){
			$areaCondition = " AND RECEIPT_ADDRESS LIKE '%udupi%'";
		}elseif ($postageAreaFilter == "Other") {
			$areaCondition = " AND RECEIPT_ADDRESS NOT LIKE '%udupi%'";
		}	

		if($slvtPostage == "All Category") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 $areaCondition ";
		}
		else if($slvtPostage == "Seva") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 1 $areaCondition";
		}	
		else if($slvtPostage == "Donation") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 2 $areaCondition";
		} 
		else if($slvtPostage == "Kanike") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 3 $areaCondition";
		}
		else if($slvtPostage == "Inkind") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 5 $areaCondition";
		}
		else if($slvtPostage == "SRNS") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 6 $areaCondition";
		}
		else if($slvtPostage == "Shashwath") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 7 $areaCondition";
		}
		else if($slvtPostage == "Jeernodhara") {
			if($postageCriteria == "1")
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND (RECEIPT_CATEGORY_ID = 10 OR RECEIPT_CATEGORY_ID = 8) $areaCondition";
			else if($postageCriteria == "2")
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 8 AND RECEIPT_PRICE < 25000 $areaCondition";
			else if($postageCriteria == "3")
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 8 AND RECEIPT_PRICE >= 25000 $areaCondition";
			else 
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 10 $areaCondition";				
		}

		$dateCondition = "";
		if($fromDate != '' || $toDate !=''){
           $dateCondition = " AND STR_TO_DATE(RECEIPT_DATE, '%d-%m-%Y') >= STR_TO_DATE('".$fromDate."', '%d-%m-%Y') AND STR_TO_DATE(RECEIPT_DATE, '%d-%m-%Y') <= STR_TO_DATE('".$toDate."', '%d-%m-%Y') ";
		}
		
		$condition .= $dateCondition;

		/*$data['slvtPostageGrps'] = $slvtPostage;
		$data['postageCriteria'] = $postageCriteria;*/
		$data['allCollection'] =  json_encode($this->obj_postage->get_slvt_postage_data($condition,'RECEIPT_ID','ASC',10, $start,true));
		$data['fullCollection'] = json_encode($this->obj_postage->get_slvt_postage_data($condition,'RECEIPT_ID','ASC',10, $start,false));
		//pagination starts
		$this->load->library('pagination');
		$config['base_url'] = base_url().'Postage/slvt_postage_data';
		$data['total_rows'] = $config['total_rows'] = $this->obj_postage->slvt_postage_rows_collection($condition,'RECEIPT_ID','ASC',10, $start);
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

		if(isset($_SESSION['Postage_Group'])) {
			$this->load->view('header',$data);
			$this->load->view('postage_group');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	function unset_session_postage()  {
		$_SESSION['SelectedReceiptID'] = @$_POST['SelectedReceiptID'];
	}
}