<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sevas extends CI_Controller {
  function __construct()
  {
	parent::__construct();
	$this->load->model('Users_model','user',true);
	$this->load->model('Events_modal','obj_events',true);		
	$this->load->model('Deity_model','obj_sevas',true);
	$this->load->model('Shashwath_Model','obj_shashwath',true); 
	if(!isset($_SESSION['userId']))
	redirect('login');
	if($_SESSION['trustLogin'] == 1)
	redirect('Trust');
	$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
	$query = $this->db->get();
	$_SESSION['eventActiveCount'] = $query->num_rows();
	//$this->output->enable_profiler(true);
  }
  
    public function index($start = 0)
    {
    	
		$data['whichTab'] = "sevas";
		$condition = "";
		$dateReceipt = date('d-m-Y');
		$or_condition = "";
		$bookCondition = "";
		$bookorCondition = "";
		$data['date'] = $dateReceipt;
		$_SESSION['deityCount'] = $this->obj_sevas->get_seva_count(date("d-m-Y"));
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		$_SESSION['shashwathCount'] = $this->obj_shashwath->count_seva_for_date($dateReceipt);
				
		unset($_SESSION['dateReceipt']);
		unset($_SESSION['name_phone']);
		//pagination
		$data['deitySeva'] = $this->obj_sevas->get_seva(10,$start, $dateReceipt, $condition, $or_condition, $bookCondition, $bookorCondition);
		$this->load->library('pagination');
		$config['base_url'] = base_url().'Sevas/index';
		$data['total_countSeva'] = $config['total_rows']=$this->obj_sevas->get_seva_count($dateReceipt, $condition, $or_condition, $bookCondition, $bookorCondition);
		//echo $this->obj_sevas->get_seva_count($dateReceipt, $condition, $or_condition, $bookCondition, $bookorCondition); 
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
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;	
		$data['deity'] = $this->obj_sevas->getEvents();
		if(isset($_SESSION['Deity_Sevas'])) {
		$this->load->view('header', $data);
		$this->load->view('sevas');
		$this->load->view('footer_home');
	    } else {
		redirect('Home/homePage');
	   }
    }
	function deity_token() {
	    //pagination ends
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		$data['deity'] = $this->obj_sevas->getEvents();
		$condition = array('IS_TOKEN'=>1, 'SEVA_ACTIVE' => 1, 'SEVA_PRICE_ACTIVE' => 1);
		$data['deitySevas'] = $this->obj_sevas->getTokenDeitySeva($condition,'DEITY_SEVA.DEITY_ID','ASC');
		$data['whichTab'] = "deityToken";	
		if(isset($_SESSION['eventCounterRes'])) {
			$data['deityCounter'] = $_SESSION['eventCounterRes'];
			unset($_SESSION['eventCounterRes']);
		}	
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();	
		if(isset($_SESSION['Deity_Token'])) {
			$this->load->view('header',$data);
			$this->load->view('deity_token');
			$this->load->view('footer_home');	
		} else {
			redirect('Home/homePage');
	   }
	}
	public function searchSeva($start = 0) {
		$_SESSION['deityCount'] = $this->obj_sevas->get_seva_count(date("d-m-Y"));
		$_SESSION['sevaCount'] = $this->obj_events->get_seva_count(date("d-m-Y"));
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		$condition = "";
		$dateReceipt = date('d-m-Y');
		$or_condition = "";
		$bookorCondition = "";
		$bookCondition = "";
		if(@$_POST['name_phone'] != "" && @$_POST['date'] != "") {
			unset($_SESSION['dateReceipt']);
			unset($_SESSION['name_phone']);
			$name_phone = $_POST['name_phone'];
			$dateReceipt = $_POST['date'];
			$condition = array(
			'DEITY_RECEIPT.RECEIPT_NAME'=>$name_phone
		    );
			$bookCondition = array(
			'SEVA_BOOKING.SB_NAME'=>$name_phone
		    );
			$bookorCondition = array(
			'SEVA_BOOKING.SB_PHONE'=>$name_phone
            );
			$data['name_phone'] = $name_phone;
	    }   else if(@$_POST['name_phone'] != "") {
			unset($_SESSION['dateReceipt']);
			unset($_SESSION['name_phone']);
			$name_phone = $_POST['name_phone'];
			$condition = array(
			'DEITY_RECEIPT.RECEIPT_NAME'=>$name_phone
		);
			
		$or_condition = array(
			'DEITY_RECEIPT.RECEIPT_PHONE'=>$name_phone
		);
			$bookCondition = array(
			'SEVA_BOOKING.SB_NAME'=>$name_phone
		);
			$bookorCondition = array(
			'SEVA_BOOKING.SB_PHONE'=>$name_phone
		);
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
			$condition = array(
				'DEITY_RECEIPT.RECEIPT_NAME'=>$name_phone
			);
			$or_condition = array(
				'DEITY_RECEIPT.RECEIPT_PHONE'=>$name_phone
			);
			$bookCondition = array(
				'SEVA_BOOKING.SB_NAME'=>$name_phone
			);
			$bookorCondition = array(
				'SEVA_BOOKING.SB_PHONE'=>$name_phone
			);
		}
		if(@$_SESSION['name_phone'] != "" && @$_SESSION['dateReceipt'] != "") {
			$name_phone = $_SESSION['name_phone'];
			$dateReceipt = $_SESSION['dateReceipt'];
			$condition = array(
				'DEITY_RECEIPT.RECEIPT_NAME'=>$name_phone
			);
			
			$or_condition = array(
				'DEITY_RECEIPT.RECEIPT_PHONE'=>$name_phone
			);
			$bookCondition = array(
				'SEVA_BOOKING.SB_NAME'=>$name_phone
			);
			$bookorCondition = array(
				'SEVA_BOOKING.SB_PHONE'=>$name_phone
			);
			$data['name_phone'] = $name_phone;
		}
		// pagination
		$data['deitySeva'] = $this->obj_sevas->get_seva(10,$start, $dateReceipt, $condition, $or_condition, $bookCondition, $bookorCondition);
		$this->load->library('pagination');
		$config['base_url'] = base_url().'Sevas/searchSeva';
		$data['total_countSeva'] =$config['total_rows']=$this->obj_sevas->get_seva_count($dateReceipt, $condition, $or_condition, $bookCondition, $bookorCondition);
		// echo $this->obj_sevas->get_seva_count($dateReceipt, $condition, $or_condition, $bookCondition, $bookorCondition); 
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
		// pagination ends
		$data['deity'] = $this->obj_sevas->getEvents();
		$data['whichTab'] = "sevas";
		$this->load->view('header',$data);
		$this->load->view('sevas');
		$this->load->view('footer_home');
	}
// 
	public function calendar() {
		$data['cal'] = $this->db->from("CALENDAR")->join("CALENDAR_YEAR_BREAKUP",'CALENDAR.CAL_ID = CALENDAR_YEAR_BREAKUP.CAL_ID')->get()->result();
		$this->load->view('header',$data);
		$this->load->view('calendar');
		$this->load->view('footer_home');
	}
}
//End of file Sevas.php
