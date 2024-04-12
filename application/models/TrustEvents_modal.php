<?php header('Access-Control-Allow-Origin: *'); ?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class TrustEvents_modal extends CI_Model {
	
	public function __construct() { 
		parent::__construct();
		$this->load->helper('date');
		date_default_timezone_set('Asia/Kolkata');
			
	}
	
	function getEvents() {
		$where = array(
			'TET_ACTIVE'=>"1"
		); 
		
		$this->db->select()->from('TRUST_EVENT')->where($where);
		$query = $this->db->get();
		return $query->first_row('array');
	}
	
	function getTokenEventSeva($condition = array(), $order_by_field = '', $order_by_type = "asc") {
		$this->db->from('TRUST_EVENT_SEVA');
		if ($condition) {
			$this->db->where($condition);
		}
		
		if ($order_by_field) {
			$this->db->order_by($order_by_field, $order_by_type);
		}
		
		$this->db->join('TRUST_EVENT', 'TRUST_EVENT_SEVA.TET_ID = TRUST_EVENT.TET_ID');
		$this->db->join('TRUST_EVENT_SEVA_PRICE', 'TRUST_EVENT_SEVA.TET_SEVA_ID = TRUST_EVENT_SEVA_PRICE.TET_SEVA_ID');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}
	
	function getEventSeva() {
		$where = array(
			'TRUST_EVENT.TET_ACTIVE'=>"1"
		); 
		
		$where2 = array(
			'TRUST_EVENT_SEVA_PRICE.TET_SEVA_PRICE_ACTIVE'=>"1"
		);

		$where3 = array(
			'TRUST_EVENT_SEVA.TET_SEVA_ACTIVE'=>"1"
		);
		
		$this->db->select()->from('TRUST_EVENT')
		->join('TRUST_EVENT_SEVA', 'TRUST_EVENT.TET_ID = TRUST_EVENT_SEVA.TET_ID')
		->join('TRUST_EVENT_SEVA_PRICE', 'TRUST_EVENT_SEVA.TET_SEVA_ID = TRUST_EVENT_SEVA_PRICE.TET_SEVA_ID')
		->where($where)->where($where2)->where($where3);
		
		$query = $this->db->get();
		return $query->result('array');
	}
	
	function get_seva($num = 10, $start = 0, $date, $condition_like = "", $or_condition = "") {
		$this->db->select()->from('TRUST_EVENT_RECEIPT')
		->join('TRUST_EVENT_SEVA_OFFERED', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_ID = TRUST_EVENT_SEVA_OFFERED.TET_RECEIPT_ID')
		->join('TRUST_EVENT','TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');

		if($date != "")	
			$this->db->where(array('TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE'=>$date, 'TRUST_EVENT_SEVA_OFFERED.TET_SO_IS_SEVA'=>1));
		
		if($condition_like != "")
			$this->db->like($condition_like, false, 'both');
		
		if($or_condition != "") {
			$this->db->or_like($or_condition, false, 'after');
			if($date != "")
					$this->db->where(array('TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE'=>$date, 'TRUST_EVENT_SEVA_OFFERED.TET_SO_IS_SEVA'=>1));
		}
		
		$this->db->where(array('TRUST_EVENT.TET_ACTIVE'=>1));
		$this->db->order_by('TRUST_EVENT_RECEIPT.TET_RECEIPT_ID', 'desc')->limit($num, $start);
			
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_seva_count($date = "", $condition_like = "", $or_condition = "") {
			$this->db->select()->from('TRUST_EVENT_RECEIPT')
			->join('TRUST_EVENT_SEVA_OFFERED', 'TRUST_EVENT_RECEIPT.TET_RECEIPT_ID = TRUST_EVENT_SEVA_OFFERED.TET_RECEIPT_ID')
			->join('TRUST_EVENT','TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID');
			
			if($date != "")
				$this->db->where(array('TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE'=>$date, 'TRUST_EVENT_SEVA_OFFERED.TET_SO_IS_SEVA'=>1));
			
			if($condition_like != "")
				$this->db->like($condition_like, false, 'after');

			if($or_condition != "") {
				$this->db->or_like($or_condition, false, 'after');
				if($date != "")
					$this->db->where(array('TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE'=>$date, 'TRUST_EVENT_SEVA_OFFERED.TET_SO_IS_SEVA'=>1));
			}
			
			$this->db->where(array('TRUST_EVENT.TET_ACTIVE'=>1));
			$query = $this->db->get();
			return $query->num_rows();
	}
	
	function getSevaLimit($where) {
		$fromDate = date('Y')."-04-01";
		$toDate = (date('Y')+1)."-03-31";
		$this->db->select()->from('TRUST_EVENT_SEVA_LIMIT')->where($where)->where("STR_TO_DATE(TRUST_EVENT_SEVA_LIMIT.DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."'")->order_by('TET_SEVA_DATE','asc');
		$query = $this->db->get();
		return $query->result('array');
	}
	
	function getSevaOffered($where) {
		$this->db->select()->from('TRUST_EVENT_SEVA_OFFERED')->where($where)->order_by('TET_SO_DATE','asc');
		$query = $this->db->get();
		return $query->result('array');
	}
	
	function getStock($where) {
		$fromDate = date('Y')."-04-01";
		$toDate = (date('Y')+1)."-03-31";
		
		$this->db->select()->from('TRUST_EVENT_SEVA_OFFERED')->where("STR_TO_DATE(TET_SO_DATE,'%d-%m-%Y') BETWEEN '".$fromDate."' AND '".$toDate."'")->where($where)->order_by('TET_SO_DATE','asc');
		$query = $this->db->get();
		return $query->result('array');
	}

	//SLAP
	//GET BANK
	function get_banks() {
	//bank 															//laz
		$this->db->from('finacial_group_ledger_heads');
		$this->db->where('FGLH_PARENT_ID',9);
		$query = $this->db->get();									   //laz..
		return $query->result();
	}
}
