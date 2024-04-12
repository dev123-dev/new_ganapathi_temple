<?php
	
	class InkindReceipt extends CI_Controller
	{
		public function __Controller()
		{
			parent::__construct();
		}
		
		function index()
		{
			$this -> load -> view('InkindReceipt');	
		}
		
		
		
	}

?>