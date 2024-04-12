<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model','user',true); 
		$this->load->model('Events_modal','obj_events',true);
		if(!isset($_SESSION['userId']))
			redirect('login');
		//print_r($_SERVER['REQUEST_URI']);
		if($_SESSION['trustLogin'] == 1 && $_SERVER['REQUEST_URI'] == "TRUST(TEMPLE)/SLVT/home/logout")
			redirect('Trust');
		//redirect('TrustReceipt/all_trust_receipt');
		$this->db->select()->from('EVENT')->where("ET_ACTIVE!=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
	}
	public function index() {
		redirect('Sevas');
	}
	
	function homePage(){		
		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer_home');
	}
	
	function logout(){
		//echo $_SERVER['REQUEST_URI'];
		//echo "hiii";
		$logout = date('Y-m-d H:i:s');
		$loggedID = $this->session->userdata('loggedHistory');
		$this->session->unset_userdata('loggedHistory');
		if($loggedID){
			
			$datas=array('LOGOUT_TIME'=>$logout);
			$this->db->where(array('LOGIN_ID'=>$loggedID));
			$this->db->update('USER_LOGINS',$datas);
	    }
	    session_destroy();
		redirect('login');
	}
}
