<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jeernodhara extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('string');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Receipt_modal','obj_receipt',true);	
		//$this->load->model('Jeernodhara_Model','obj_Jeernodhara',true);
		$this->load->helper(array('form', 'url'));
		$this->load->helper('date');
		if(!isset($_SESSION['userId']))
		redirect('login');
		if($_SESSION['trustLogin'] == 1)
		redirect('Trust');
	}
	
	function Jeernodhara_Kanike(){
		$data['whichTab'] = 'Jeernodhara';
		$_SESSION['back_link'] = uri_string();

		//slap
		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..

		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);
		$_SESSION['actual_link'] = base_url().'Receipt/daily_report';


		$_SESSION['actual_link'] = base_url().'Receipt/daily_report';

		$this->load->view('header',$data);
		$this->load->view('Jeernodhara/receipt_jeernodhara_kanike');
		$this->load->view('footer_home');
	}
	function Jeernodhara_Hundi(){
		$data['whichTab'] = 'Jeernodhara';
		$_SESSION['back_link'] = uri_string();

		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..

		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);
		
		$_SESSION['actual_link'] = base_url().'Receipt/daily_report';

		$this->load->view('header',$data);
		$this->load->view('Jeernodhara/receipt_jeernodhara_Hundi');
		$this->load->view('footer_home');

	}
	
	function Jeernodhara_Inkind(){
		$data['whichTab'] = 'Jeernodhara';
		$_SESSION['back_link'] = uri_string();

		$_SESSION['actual_link'] = base_url().'Receipt/daily_report';
		
		$data['inkind_item'] = $this->obj_receipt->get_all_field_inkind_items();
		$this->load->view('header',$data);
		$this->load->view('Jeernodhara/receipt_jeernodhara_Inkind');
		$this->load->view('footer_home');
	}
	

}