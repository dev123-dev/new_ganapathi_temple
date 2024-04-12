<?php header('Access-Control-Allow-Origin: *'); ?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Events_modal extends CI_Model {
	
    	public function __construct() { 
		parent::__construct();
		$this->load->helper('date');
		$this->load->database();
		date_default_timezone_set('Asia/Kolkata');
			
	}
	
	function getEvents() {
		$where = array(
			'ET_ACTIVE'=>"1"
		); 
		
		$this->db->select()->from('EVENT')->where($where);
		$query = $this->db->get();
		return $query->first_row('array');
	}
	
	function getTokenEventSeva($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from('EVENT_SEVA');
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('EVENT', 'EVENT_SEVA.ET_ID = EVENT.ET_ID');
		$this->db->join('EVENT_SEVA_PRICE', 'EVENT_SEVA.ET_SEVA_ID = EVENT_SEVA_PRICE.ET_SEVA_ID');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}
	
	function getTrustEvents() {
		$where = array(
			'TET_ACTIVE'=>"1"
		); 
		
		$this->db->select()->from('TRUST_EVENT')->where($where);
		$query = $this->db->get();
		return $query->first_row('array');
	}
	
	function getEventSeva() {
		$where = array(
			'EVENT.ET_ACTIVE'=>"1"
		); 
		
		$where2 = array(
			'EVENT_SEVA_PRICE.ET_SEVA_PRICE_ACTIVE'=>"1"
		);

		$where3 = array(
			'EVENT_SEVA.ET_SEVA_ACTIVE'=>"1"
		);
		
		$this->db->select()->from('EVENT')
		->join('EVENT_SEVA', 'EVENT.ET_ID = EVENT_SEVA.ET_ID')
		->join('EVENT_SEVA_PRICE', 'EVENT_SEVA.ET_SEVA_ID = EVENT_SEVA_PRICE.ET_SEVA_ID')
		->where($where)->where($where2)->where($where3);
		
		$query = $this->db->get();
		return $query->result('array');
	}
	
	function get_seva($num = 10, $start = 0, $date, $condition_like = "", $or_condition = "") {
		$this->db->select()->from('EVENT_RECEIPT')
		->join('EVENT_SEVA_OFFERED', 'EVENT_RECEIPT.ET_RECEIPT_ID = EVENT_SEVA_OFFERED.ET_RECEIPT_ID')
		->join('EVENT','EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');

		if($date != "")	
			$this->db->where(array('EVENT_SEVA_OFFERED.ET_SO_DATE'=>$date, 'EVENT_SEVA_OFFERED.ET_SO_IS_SEVA'=>1));
		
		if($condition_like != "")
			$this->db->like($condition_like, false, 'both');
		
		if($or_condition != "") {
			$this->db->or_like($or_condition, false, 'after');
			if($date != "")
					$this->db->where(array('EVENT_SEVA_OFFERED.ET_SO_DATE'=>$date, 'EVENT_SEVA_OFFERED.ET_SO_IS_SEVA'=>1));
		}
		
		$this->db->where(array('EVENT.ET_ACTIVE'=>1));
		$this->db->order_by('EVENT_RECEIPT.ET_RECEIPT_ID', 'desc')->limit($num, $start);
			
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_seva_count($date = "", $condition_like = "", $or_condition = "") {
			$this->db->select()->from('EVENT_RECEIPT')
			->join('EVENT_SEVA_OFFERED', 'EVENT_RECEIPT.ET_RECEIPT_ID = EVENT_SEVA_OFFERED.ET_RECEIPT_ID')
			->join('EVENT','EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
			
			if($date != "")
				$this->db->where(array('EVENT_SEVA_OFFERED.ET_SO_DATE'=>$date, 'EVENT_SEVA_OFFERED.ET_SO_IS_SEVA'=>1));
			
			if($condition_like != "")
				$this->db->like($condition_like, false, 'after');

			if($or_condition != "") {
				$this->db->or_like($or_condition, false, 'after');
				if($date != "")
					$this->db->where(array('EVENT_SEVA_OFFERED.ET_SO_DATE'=>$date, 'EVENT_SEVA_OFFERED.ET_SO_IS_SEVA'=>1));
			}
			
			$this->db->where(array('EVENT.ET_ACTIVE'=>1));
			$query = $this->db->get();
			return $query->num_rows();
	}
	function get_finMth(){
	   $this->db->select('MONTH_IN_NUMBER');
	   $this->db->from('FINANCIAL_YEAR');
	   $query = $this->db->get();
	   if($query->num_rows()>0)
	   return $query->first_row();
	}
	
	function get_financial_frmto_date() {
		$Mth = $this->get_finMth();
		$dbFinMth = $Mth->MONTH_IN_NUMBER;
		$currFinMth = date('n');
		if($dbFinMth == 1) {
			$dtString = date('Y')."-01-01:".date('Y')."-12-31";
		} else {
		if($currFinMth >= $dbFinMth && $currFinMth <= 12 ) {
			  $dtString = date('Y')."-".(($dbFinMth < 10)?"0".$dbFinMth:$dbFinMth)."-01:".(date('Y') + 1)."-".(($dbFinMth-1)<10?"0".($dbFinMth-1):($dbFinMth-1))."-".$this->find_no_days_normal_leap($dbFinMth-1,date('Y')+1);
			}
			if($currFinMth >= 1 && $currFinMth <= $dbFinMth - 1) {
			  $dtString = (date('Y')-1)."-".(($dbFinMth < 10)?"0".$dbFinMth:$dbFinMth)."-01:".date('Y')."-".(($dbFinMth-1)<10?"0".($dbFinMth-1):($dbFinMth-1))."-".$this->find_no_days_normal_leap($dbFinMth-1,date('Y'));
			} 
		}
		return $dtString;
	}
	
	function find_no_days_normal_leap($chkMth,$year) {
		if( (0 == date('Y') % 4) and (0 != date('Y') % 100) or (0 == date('Y') % 400) ) {
			if($chkMth == 2 || $chkMth == "02") {
				$noDays = 29;
			} else {
				$noDays = date("t",strtotime($year."-".$chkMth."-20"));
			}
		} else {
			$noDays = date("t",strtotime($year."-".$chkMth."-20"));
		}
		return $noDays;
	}
	
	
	function getSevaLimit($where) {
		$dtFuncStr = $this->get_financial_frmto_date();
		$fromDate = explode(":",$dtFuncStr)[0];
		$toDate = explode(":",$dtFuncStr)[1];
		//$fromDate = date('Y')."-04-01";
		//$toDate = (date('Y')+1)."-03-31";
		$this->db->select()->from('EVENT_SEVA_LIMIT')->where($where)->where("STR_TO_DATE(EVENT_SEVA_LIMIT.DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."'")->order_by('ET_SEVA_DATE','asc');
		$query = $this->db->get();
		return $query->result('array');
	}
	
	function getSevaOffered($where) {
		$this->db->select()->from('EVENT_SEVA_OFFERED')->where($where)->order_by('ET_SO_DATE','asc');
		$query = $this->db->get();
		return $query->result('array');
	}
	
	function getStock($where){
		$this->db->select()->from('EVENT_SEVA_OFFERED')->where($where)->order_by('ET_SO_DATE','asc');
		$query = $this->db->get();
		return $query->result('array');
    }
}
