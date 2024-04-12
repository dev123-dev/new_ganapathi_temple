<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller { 
	function __construct()
	{
		parent::__construct();
		$this->load->model('Events_modal','obj_events',true);
		$this->load->model('admin_settings/Admin_setting_model','obj_admin_settings',true);		
		$this->load->model('Deity_model','obj_sevas',true);
		$this->load->helper('date');
		date_default_timezone_set('Asia/Kolkata');
		if(!isset($_SESSION['userId']))
			redirect('login');
	}
	
	public function index($start = 0) { 
		
	}
	
	public function table12() {
		//TRUST EVENT RECEIPT INSERT
		$result = "SELECT * FROM EVENT_RECEIPT";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TET_RECEIPT_ID' => $row[$i]['ET_RECEIPT_ID'], 
				'TET_RECEIPT_NO' => $row[$i]['ET_RECEIPT_NO'], 
				'TET_RECEIPT_DATE' => $row[$i]['ET_RECEIPT_DATE'], 
				'TET_RECEIPT_NAME' => $row[$i]['ET_RECEIPT_NAME'],
				'TET_RECEIPT_PHONE' => $row[$i]['ET_RECEIPT_PHONE'],
				'TET_RECEIPT_EMAIL' => $row[$i]['ET_RECEIPT_EMAIL'],
				'TET_RECEIPT_ADDRESS' => $row[$i]['ET_RECEIPT_ADDRESS'],
				'TET_RECEIPT_RASHI' => $row[$i]['ET_RECEIPT_RASHI'],
				'TET_RECEIPT_NAKSHATRA' => $row[$i]['ET_RECEIPT_NAKSHATRA'],
				'RECEIPT_TET_NAME' => $row[$i]['RECEIPT_ET_NAME'],
				'RECEIPT_TET_ID' => $row[$i]['RECEIPT_ET_ID'],
				'TET_RECEIPT_PRICE' => $row[$i]['ET_RECEIPT_PRICE'],
				'TET_RECEIPT_PAYMENT_METHOD' => $row[$i]['ET_RECEIPT_PAYMENT_METHOD'],
				'CHEQUE_NO' => $row[$i]['CHEQUE_NO'],
				'CHEQUE_DATE' => $row[$i]['CHEQUE_DATE'],
				'BANK_NAME' => $row[$i]['BANK_NAME'],
				'BRANCH_NAME' => $row[$i]['BRANCH_NAME'],
				'TRANSACTION_ID' => $row[$i]['TRANSACTION_ID'],
				'TET_RECEIPT_PAYMENT_METHOD_NOTES' => $row[$i]['ET_RECEIPT_PAYMENT_METHOD_NOTES'],
				'TET_RECEIPT_ISSUED_BY' => $row[$i]['ET_RECEIPT_ISSUED_BY'],
				'TET_RECEIPT_ISSUED_BY_ID' => $row[$i]['ET_RECEIPT_ISSUED_BY_ID'],
				'DATE_TIME' => $row[$i]['DATE_TIME'],
				'TET_RECEIPT_ACTIVE' => $row[$i]['ET_RECEIPT_ACTIVE'],
				'TET_RECEIPT_CATEGORY_ID' => $row[$i]['ET_RECEIPT_CATEGORY_ID'],
				'PAYMENT_STATUS' => $row[$i]['PAYMENT_STATUS'],
				'PAYMENT_CONFIRMED_BY_NAME' => $row[$i]['PAYMENT_CONFIRMED_BY_NAME'],
				'PAYMENT_CONFIRMED_BY' => $row[$i]['PAYMENT_CONFIRMED_BY'],
				'PAYMENT_DATE_TIME' => $row[$i]['PAYMENT_DATE_TIME'],
				'PAYMENT_DATE' => $row[$i]['PAYMENT_DATE'],
				'CHEQUE_CREDITED_DATE' => $row[$i]['CHEQUE_CREDITED_DATE'],
				'AUTHORISED_STATUS' => $row[$i]['AUTHORISED_STATUS'],
				'AUTHORISED_BY' => $row[$i]['AUTHORISED_BY'],
				'AUTHORISED_BY_NAME' => $row[$i]['AUTHORISED_BY_NAME'],
				'AUTHORISED_DATE_TIME' => $row[$i]['AUTHORISED_DATE_TIME'],
				'AUTHORISED_DATE' => $row[$i]['AUTHORISED_DATE'],
				'EOD_CONFIRMED_BY_ID' => $row[$i]['EOD_CONFIRMED_BY_ID'],
				'EOD_CONFIRMED_BY_NAME' => $row[$i]['EOD_CONFIRMED_BY_NAME'],
				'EOD_CONFIRMED_DATE_TIME' => $row[$i]['EOD_CONFIRMED_DATE_TIME'],
				'EOD_CONFIRMED_DATE' => $row[$i]['EOD_CONFIRMED_DATE'],
				'REFERENCE' => $row[$i]['REFERENCE'], 'REFERENCE_NO' => $row[$i]['REFERENCE_NO'],
				'CANCEL_NOTES' => $row[$i]['CANCEL_NOTES']
			);
			$this->db->insert('TRUST_EVENT_RECEIPT',$data);
			$i++;
		}
		echo "TRUST_EVENT_RECEIPT Successfully ".$i++." Entered Data!!!";
	}
	
	public function table11() {
		//TRUST EVENT INKIND OFFERED INSERT
		$result = "SELECT * FROM EVENT_INKIND_OFFERED";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TET_IKO_ID' => $row[$i]['ET_IKO_ID'], 
				'TET_RECEIPT_ID' => $row[$i]['ET_RECEIPT_ID'], 
				'IK_ITEM_ID' => $row[$i]['IK_ITEM_ID'],
				'IK_ITEM_NAME' => $row[$i]['IK_ITEM_NAME'],
				'IK_ITEM_UNIT' => $row[$i]['IK_ITEM_UNIT'],
				'IK_ITEM_QTY' => $row[$i]['IK_ITEM_QTY']
			);
			$this->db->insert('TRUST_EVENT_INKIND_OFFERED',$data);
			$i++;
		}
		echo "TRUST_EVENT_INKIND_OFFERED Successfully ".$i++." Entered Data!!!";
	}
	
	public function table10() {
		//TRUST EVENT SEVA OFFERED INSERT
		$result = "SELECT * FROM EVENT_SEVA_OFFERED";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TET_SO_ID' => $row[$i]['ET_SO_ID'], 
				'TET_SO_SEVA_NAME' => $row[$i]['ET_SO_SEVA_NAME'], 
				'TET_SO_SEVA_ID' => $row[$i]['ET_SO_SEVA_ID'],
				'TET_SO_IS_SEVA' => $row[$i]['ET_SO_IS_SEVA'],
				'TET_SO_DATE' => $row[$i]['ET_SO_DATE'],
				'TET_SO_QUANTITY' => $row[$i]['ET_SO_QUANTITY'],
				'TET_SO_PRICE' => $row[$i]['ET_SO_PRICE'],
				'TET_RECEIPT_ID' => $row[$i]['ET_RECEIPT_ID'],
				'TET_UPDATED_SO_DATE' => $row[$i]['ET_UPDATED_SO_DATE'],
				'TET_UPDATED_BY_ID' => $row[$i]['ET_UPDATED_BY_ID']
			);
			$this->db->insert('TRUST_EVENT_SEVA_OFFERED',$data);
			$i++;
		}
		echo "TRUST_EVENT_SEVA_OFFERED Successfully ".$i++." Entered Data!!!";
	}
	
	public function table9() {
		//TRUST EVENT SEVA PRICE INSERT
		$result = "SELECT * FROM EVENT_SEVA_PRICE";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TET_SEVA_PRICE_ID' => $row[$i]['ET_SEVA_PRICE_ID'], 
				'TET_SEVA_PRICE_ACTIVE' => $row[$i]['ET_SEVA_PRICE_ACTIVE'], 
				'DATE_TIME' => $row[$i]['DATE_TIME'],
				'DATE' => $row[$i]['DATE'],
				'USER_ID' => $row[$i]['USER_ID'],
				'TET_ID' => $row[$i]['ET_ID'],
				'TET_SEVA_ID' => $row[$i]['ET_SEVA_ID'],
				'TET_SEVA_PRICE' => $row[$i]['ET_SEVA_PRICE'],
			);
			$this->db->insert('TRUST_EVENT_SEVA_PRICE',$data);
			$i++;
		}
		echo "TRUST_EVENT_SEVA_PRICE Successfully ".$i++." Entered Data!!!";
	}
	
	public function table8() {
		//TRUST EVENT PRINT HISTORY INSERT
		$result = "SELECT * FROM EVENT_PRINT_HISTORY";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TEPH_ID' => $row[$i]['EPH_ID'], 
				'RECEIPT_ID' => $row[$i]['RECEIPT_ID'], 
				'DATE_TIME' => $row[$i]['DATE_TIME'],
				'USER_ID' => $row[$i]['USER_ID'],
				'DATE' => $row[$i]['DATE']
			);
			$this->db->insert('TRUST_EVENT_PRINT_HISTORY',$data);
			$i++;
		}
		echo "TRUST_EVENT_PRINT_HISTORY Successfully ".$i++." Entered Data!!!";
	}
	
	public function table7() {
		//TRUST EVENT HISTORY INSERT
		$result = "SELECT * FROM EVENT_HISTORY";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TEH_ID' => $row[$i]['EH_ID'], 
				'TET_ID' => $row[$i]['ET_ID'], 
				'TET_NAME' => $row[$i]['ET_NAME'],
				'TET_FROM' => $row[$i]['ET_FROM'],
				'TET_TO' => $row[$i]['ET_TO'],
				'TET_STATUS' => $row[$i]['ET_STATUS'],
				'USER_ID' => $row[$i]['USER_ID'],
				'DATE_TIME' => $row[$i]['DATE_TIME'],
				'DATE' => $row[$i]['DATE']
			);
			$this->db->insert('TRUST_EVENT_HISTORY',$data);
			$i++;
		}
		echo "TRUST_EVENT_HISTORY Successfully ".$i++." Entered Data!!!";
	}
	
	public function table6() {
		//TRUST EVENT RECEIPT CATEGORY INSERT
		$result = "SELECT * FROM EVENT_RECEIPT_CATEGORY";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TET_RECEIPT_CATEGORY_ID' => $row[$i]['ET_RECEIPT_CATEGORY_ID'], 
				'TET_RECEIPT_CATEGORY_TYPE' => $row[$i]['ET_RECEIPT_CATEGORY_TYPE'], 
				'TET_ACTIVE_RECEIPT_COUNTER_ID' => $row[$i]['ET_ACTIVE_RECEIPT_COUNTER_ID']
			);
			$this->db->insert('TRUST_EVENT_RECEIPT_CATEGORY',$data);
			$i++;
		}
		echo "TRUST_EVENT_RECEIPT_CATEGORY Successfully ".$i++." Entered Data!!!";
	}
	
	public function table5() {
		//TRUST EVENT RECEIPT COUNTER INSERT
		$result = "SELECT * FROM EVENT_RECEIPT_COUNTER";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TET_RECEIPT_COUNTER_ID' => $row[$i]['ET_RECEIPT_COUNTER_ID'], 
				'TET_ABBR1' => $row[$i]['ET_ABBR1'], 
				'TET_ABBR2' => $row[$i]['ET_ABBR2'], 
				'TET_RECEIPT_COUNTER' => $row[$i]['ET_RECEIPT_COUNTER'], 
				'USER_ID' => $row[$i]['USER_ID'], 
				'EVENT_ID' => $row[$i]['EVENT_ID'], 
				'DATE_TIME' => $row[$i]['DATE_TIME'],
				'DATE' => $row[$i]['DATE']
			);
			$this->db->insert('TRUST_EVENT_RECEIPT_COUNTER',$data);
			$i++;
		}
		echo "TRUST_EVENT_RECEIPT_COUNTER Successfully ".$i++." Entered Data!!!";
	}
	
	public function table4() {
		//TRUST EVENT SEVA INSERT
		$result = "SELECT * FROM EVENT_SEVA";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TET_SEVA_ID' => $row[$i]['ET_SEVA_ID'], 
				'TET_SEVA_CODE' => $row[$i]['ET_SEVA_CODE'], 
				'TET_SEVA_NAME' => $row[$i]['ET_SEVA_NAME'], 
				'TET_ID' => $row[$i]['ET_ID'], 
				'TET_SEVA_FROM_DATE_TIME' => $row[$i]['ET_SEVA_FROM_DATE_TIME'], 
				'TET_SEVA_TO_DATE_TIME' => $row[$i]['ET_SEVA_TO_DATE_TIME'], 
				'TET_SEVA_DESC' => $row[$i]['ET_SEVA_DESC'],
				'DATE_TIME' => $row[$i]['DATE_TIME'],
				'DATE' => $row[$i]['DATE'],
				'USER_ID' => $row[$i]['USER_ID'],
				'TET_SEVA_ACTIVE' => $row[$i]['ET_SEVA_ACTIVE'],
				'TET_SEVA_QUANTITY_CHECKER' => $row[$i]['ET_SEVA_QUANTITY_CHECKER'],
				'IS_SEVA' => $row[$i]['IS_SEVA'],
				'RESTRICT_DATE' => $row[$i]['RESTRICT_DATE']
			);
			$this->db->insert('TRUST_EVENT_SEVA',$data);
			$i++;
		}
		echo "TRUST_EVENT_SEVA Successfully ".$i++." Entered Data!!!";
	}
	
	public function table3() {
		//TRUST EVENT LIMIT INSERT
		$result = "SELECT * FROM EVENT_SEVA_LIMIT";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TET_SL_ID' => $row[$i]['ET_SL_ID'], 
				'TET_SEVA_ID' => $row[$i]['ET_SEVA_ID'], 
				'TET_IS_SEVA' => $row[$i]['ET_IS_SEVA'], 
				'TET_SEVA_DATE' => $row[$i]['ET_SEVA_DATE'], 
				'TET_SEVA_LIMIT' => $row[$i]['ET_SEVA_LIMIT'], 
				'TET_SEVA_COUNTER' => $row[$i]['ET_SEVA_COUNTER'], 
				'DATE_TIME' => $row[$i]['DATE_TIME'],
				'DATE' => $row[$i]['DATE'],
				'USER_ID' => $row[$i]['USER_ID']
			);
			$this->db->insert('TRUST_EVENT_SEVA_LIMIT',$data);
			$i++;
		}
		echo "TRUST_EVENT_SEVA_LIMIT Successfully ".$i++." Entered Data!!!";
	}
	
	public function table2() {
		//TRUST EVENT INSERT
		$result = "SELECT * FROM EVENT";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TET_ID' => $row[$i]['ET_ID'], 
				'TET_CODE' => $row[$i]['ET_CODE'], 
				'TET_NAME' => $row[$i]['ET_NAME'], 
				'TET_FROM_DATE_TIME' => $row[$i]['ET_FROM_DATE_TIME'], 
				'TET_TO_DATE_TIME' => $row[$i]['ET_TO_DATE_TIME'], 
				'DATE_TIME' => $row[$i]['DATE_TIME'],
				'DATE' => $row[$i]['DATE'],
				'USER_ID' => $row[$i]['USER_ID'],
				'TET_ACTIVE' => $row[$i]['ET_ACTIVE']
			);
			$this->db->insert('TRUST_EVENT',$data);
			$i++;
		}
		echo "TRUST_EVENT Successfully ".$i++." Entered Data!!!";
	}
	
	public function table1() {
		//TRUST EOD  INSERT
		$result = "SELECT * FROM EVENT_EOD_TIME_SETTING";
		$strResult = $this->db->query($result); 
		
		$i = 0;
		@$row = $strResult->result_array();
		while($i < count($row)){
			$data = array(
				'TIME_ID' => $row[$i]['TIME_ID'], 
				'TIME_FROM' => $row[$i]['TIME_FROM'], 
				'TIME_TO' => $row[$i]['TIME_TO'], 
				'USER_ID' => $row[$i]['USER_ID']
			);
			$this->db->insert('TRUST_EOD_TIME_SETTING',$data);
			$i++;
		}
		echo "TRUST_EOD_TIME_SETTING Successfully ".$i++." Entered Data!!!";
	}
	
	public function ajaxsearch() {
		if(@$this->input->post('search') != "") {

			$data['Infotable']=$this->obj_events->getEvents(); 
			if(count($data['Infotable']) > 0) {
				$this->load->view('view_result',$data); 
			}else {
				$data['dataNotFound'] = "No data Found";
				$this->load->view('view_result',$data);
			} 
		}
	}
}