<?php 
	ini_set('memory_limit', '-1');
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class dateex1 extends CI_Controller {
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
	}	
			
	function index() {
		$dtFuncStr = $this->obj_admin_settings->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1];
		$fromDate1 = date('Y')."-04-01";
		$toDate2 = (date('Y')+1)."-03-31";
		echo $fromDate.'our<br/>';
		echo $toDate.'our<br/>';
		echo $fromDate1.'old<br/>';
		echo $toDate2.'old<br/>';
	}

	function getDate2() {	 
		$fromDate = date('Y')."-04-01";
		$toDate = date('Y-m-d', strtotime('28-03-2019'));
		echo $fromDate.'from<br/>';
		echo $toDate.'to<br/>';
	}
	
		/* var currentTime = new Date()
		var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
		var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); */

}