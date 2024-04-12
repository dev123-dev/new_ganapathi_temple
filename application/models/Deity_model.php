<?php header('Access-Control-Allow-Origin: *'); ?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Deity_model extends CI_Model {
	
	public function __construct() { 
	parent::__construct();
	$this->load->helper('date');
	date_default_timezone_set('Asia/Kolkata');
	}
	
	function getTokenDeitySeva($condition = array(), $order_by_field = '', $order_by_type = "asc") {
	$this->db->from('DEITY_SEVA');
	if ($condition) {
	$this->db->where($condition);
	}

	if ($order_by_field) {
		$this->db->order_by($order_by_field, $order_by_type);
		$this->db->order_by('DEITY_SEVA.SEVA_NAME', 'ASC');
    }

	$this->db->join('DEITY', 'DEITY_SEVA.DEITY_ID = DEITY.DEITY_ID');
	$this->db->join('DEITY_SEVA_PRICE', 'DEITY_SEVA.SEVA_ID = DEITY_SEVA_PRICE.SEVA_ID');
	$query = $this->db->get();
	if ($query->num_rows() > 0) {
	return $query->result();
	} else {
	return array();
    }
 }
	
	function get_seva_count($date = "", $condition_like = "", $or_condition = "", $bookCondition = "", $bookorCondition = "") {
	$this->db->select()->from('DEITY_RECEIPT')
	->join('DEITY_SEVA_OFFERED', 'DEITY_RECEIPT.RECEIPT_ID = DEITY_SEVA_OFFERED.RECEIPT_ID');
		
	if($date != "")
	$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1,'DEITY_SEVA_OFFERED.RECEIPT_CATEGORY_ID !=' =>7));
		
	if($condition_like != "")
    $this->db->like($condition_like, false, 'after');

	if($or_condition != "") {
	$this->db->or_like($or_condition, false, 'after');
	if($date != "")
	$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1,'DEITY_SEVA_OFFERED.RECEIPT_CATEGORY_ID !=' =>7));
	}
	
		// $query = $this->db->get();
		// return $query->num_rows();
		$query = $this->db->get();
		$arr = count($query->result_array());
		$this->db->select()->from('SEVA_BOOKING')
		->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
		
		if($date != "")
		$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0, 'SB_ACTIVE' => 1));
		
		if($bookCondition != "")
			$this->db->like($bookCondition, false, 'after');

		if($bookorCondition != "") {
			$this->db->or_like($bookorCondition, false, 'after');
			if($date != "")
			$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'SB_ACTIVE' => 1));
		}
		$query = $this->db->get();
		$arr1 = count($query->result_array());
		return ($arr1+$arr);
	}
	
	function get_seva($num = 10, $start = 0, $date, $condition_like = "", $or_condition = "", $bookCondition = "", $bookorCondition = "") {
	$this->db->select()->from('DEITY_RECEIPT')
	->join('DEITY_SEVA_OFFERED', 'DEITY_RECEIPT.RECEIPT_ID = DEITY_SEVA_OFFERED.RECEIPT_ID');
		
		if($date != "")	
			$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1,'DEITY_SEVA_OFFERED.RECEIPT_CATEGORY_ID !=' =>7));
		// 
		if($condition_like != "")
			$this->db->like($condition_like, false, 'both');
		
		if($or_condition != "") {
			$this->db->or_like($or_condition, false, 'after');
			if($date != "")
			$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1,'DEITY_SEVA_OFFERED.RECEIPT_CATEGORY_ID !=' =>7));
		}

		$this->db->order_by('DEITY_RECEIPT.RECEIPT_ID', 'desc');//->limit($num, $start);
		$query = $this->db->get();
		$arr = $query->result_array();
		
		//BOOKING
		$this->db->select()->from('SEVA_BOOKING')
		->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
		
		if($date != "")
			$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0, 'SB_ACTIVE' => 1));
		
		if($bookCondition != "")
		   $this->db->like($bookCondition, false, 'after');

		if($bookorCondition != "") {
			$this->db->or_like($bookorCondition, false, 'after');
			if($date != "")
			$this->db->where(array('DEITY_SEVA_OFFERED.SO_DATE'=>$date, 'DEITY_SEVA_OFFERED.SO_IS_SEVA'=>1, 'SB_ACTIVE' => 1));
		}
	
		$this->db->order_by('SEVA_BOOKING.SB_ID', 'desc');//->limit($num, $start);
		
		$query = $this->db->get();
		$arr1 = $query->result_array();
		
		$arr2 = array_merge($arr,$arr1);
		//echo count($arr2);
		$arr3 = [];
		if(($start+10) <= count($arr2)) {
			for($i=$start; $i<($start+10);++$i) {
				$arr3[$i] = $arr2[$i];
			}
		} else {
			for($i=$start; $i<count($arr2);++$i) {
				$arr3[$i] = $arr2[$i];
			}
		}
		return $arr3;
	}
	
	function getEvents() {
		$where = array(
			'DEITY_ACTIVE'=>"1"
		); 
		
		$this->db->select()->from('DEITY')->where($where);
		$query = $this->db->get();
		return $query->first_row('array');
	}
}