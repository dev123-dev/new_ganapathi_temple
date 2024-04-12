<?php
	
	class TempleReceipt extends CI_Controller{
		
		public function __construct()
		{
			parent::__construct();
			$this -> load -> model('TempleReceipt_Model','TReceipt',TRUE);
		}
		
		function index()
		{
			$data['result'] = $this->TReceipt->GetDeityDetail();
			$this -> load -> view('RadioButtonEX',$data);
		}
		
		function GetSevas($val)
		{
			$data['result'] = $this->TReceipt->getDeitySeva($val);
			
			$this -> load -> view('RadioButtonEX',$data);
		}
	}


?>
