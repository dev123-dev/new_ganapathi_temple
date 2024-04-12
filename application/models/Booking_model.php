<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Booking_model extends CI_Model {
		//TABLE NAME
		var $tableBooking = 'SEVA_BOOKING';
		var $tableDeitySevaOffered = 'DEITY_SEVA_OFFERED';
		
		public function __Construct() {
			parent::__construct();
			$this->load->database();
		}
		
		//COUNT OF BOOKING DATA PAYMENT YES
		function get_booking_count_payment_status($condition=array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->from($this->tableBooking);
			if($condition){
				$this->db->where($condition);
			}
						
			$query = $this->db->get();
			$row=$query->num_rows();
			return $row;
		}
		
		function get_all_bookingRawQuery($condition = "", $order_by_field = 'TRUST_HALL_BOOKING.HB_ID', $order_by_type = "asc", $num=10, $start) {
			$sql = "SELECT * FROM TRUST_HALL_BOOKING 
			        join TRUST_HALL_BOOKING_LIST on TRUST_HALL_BOOKING.HB_ID = TRUST_HALL_BOOKING_LIST.HB_ID ";
			
			if ($condition) {
				$sql .= $condition;
			}
			
			$sql .= " order by ".$order_by_field." ".$order_by_type;
			$sql .= " limit ".$start.", ".$num;

			
			$query = $this->db->query($sql);

			if ($query->num_rows() > 0) {
				return $query->result("array");
			} else {
				return array();
			}
		}

		function get_all_bookingRawQueryCount($condition = "") {
			$sql = "select * from TRUST_HALL_BOOKING join TRUST_HALL_BOOKING_LIST on TRUST_HALL_BOOKING.HB_ID = TRUST_HALL_BOOKING_LIST.HB_ID ";
			
			if ($condition) {
				$sql .= $condition;
			}

			
			$query = $this->db->query($sql);

			return $query->num_rows();
		}

		function get_all_booking($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('*');
			$this->db->from('TRUST_HALL_BOOKING');
			$this->db->join('TRUST_HALL_BOOKING_LIST', 'TRUST_HALL_BOOKING.HB_ID = TRUST_HALL_BOOKING_LIST.HB_ID');
			$this->db->join('FUNCTION', 'FUNCTION.FN_ID = TRUST_HALL_BOOKING_LIST.FN_TYPE');
			
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result("array");
			} else {
				return array();
			}
		}

		function get_all_bookingTrust($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('*');
			$this->db->from('TRUST_HALL_BOOKING');
			$this->db->join('TRUST_RECEIPT', 'TRUST_HALL_BOOKING.HB_ID = TRUST_RECEIPT.HB_ID');
			
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result("array");
			} else {
				return array();
			}
		}

		function get_all_bookingTemple($condition = array(), $order_by_field = '', $order_by_type = "asc") {
			$this->db->select('*');
			$this->db->from('TRUST_HALL_BOOKING');
			$this->db->join('DEITY_RECEIPT', 'TRUST_HALL_BOOKING.HB_ID = DEITY_RECEIPT.RECEIPT_HB_ID');
			
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by($order_by_field, $order_by_type);
			}
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result("array");
			} else {
				return array();
			}
		}

		//COUNT OF BOOKING 
		function get_booking_count($condition=array(), $order_by_field = '', $order_by_type = "asc") 
		{
			$this->db->from($this->tableBooking);
			if($condition){
				$this->db->where($condition);
			}
			
			$this->db->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
			
			$query = $this->db->get();
			
			$row=$query->num_rows();
			return $row;
		}
		
		//FOR BOOKING GET ALL FIELDS
		function get_all_field_booking($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->tableBooking);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by("SB_PAYMENT_STATUS", "asc");
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
			
			$this->db->limit($num, $start);
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR BOOKING GET ALL FIELDS
		function get_all_field_booking_report($condition = array(), $order_by_field = '', $order_by_type = "asc", $num = 10, $start = 0) {
			$this->db->from($this->tableBooking);
			if ($condition) {
				$this->db->where($condition);
			}
			
			if ($order_by_field) {
				$this->db->order_by("SB_PAYMENT_STATUS", "asc");
				$this->db->order_by($order_by_field, $order_by_type);
			}

			$this->db->join('DEITY_SEVA_OFFERED', 'SEVA_BOOKING.SB_ID = DEITY_SEVA_OFFERED.SO_SB_ID');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}
		
		//FOR UPDATE DEITY_SEVA_OFFERED
		function update_deity_seva_offered($condition=array(),$data_array=array()){
			if($condition){
				$this->db->where($condition);
			}
			
			if($this->db->update($this->tableDeitySevaOffered,$data_array)){
				return true;
			} else {
				return false;
			}
		}
		
		//FOR UPDATE BOOKING
		function update_booking($condition=array(),$data_array=array()){
			if($condition){
				$this->db->where($condition);
			}
			
			if($this->db->update($this->tableBooking,$data_array)){
				return true;
			} else {
				return false;
			}
		}

		function get_pending_Receipt($condition = array(),$num = 10, $start = 0) {
			$date = date("d-m-Y");
			$sql="SELECT * FROM `SEVA_BOOKING` JOIN `DEITY_SEVA_OFFERED` ON `SEVA_BOOKING`.`SB_ID` = `DEITY_SEVA_OFFERED`.`SO_SB_ID`  WHERE STR_TO_DATE(SO_DATE,'%d-%m-%Y') < STR_TO_DATE('$date','%d-%m-%Y') AND SB_PAYMENT_STATUS = 0 AND SB_ACTIVE != 0 ";
			if ($condition) {
				$sql .= $condition;
			}
			$sql .= " order by `SO_DATE` ASC, `SB_ID` "; 
			$sql .= " limit ".$start.", ".$num;

			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		function get_all_pending_booking_report($condition = array()) {
			$date = date("d-m-Y");
			$sql = "SELECT * FROM  `SEVA_BOOKING` JOIN `DEITY_SEVA_OFFERED` ON `SEVA_BOOKING`.`SB_ID` = `DEITY_SEVA_OFFERED`.`SO_SB_ID` WHERE STR_TO_DATE(SO_DATE,'%d-%m-%Y') < STR_TO_DATE('$date','%d-%m-%Y') AND SB_PAYMENT_STATUS = 0 AND SB_ACTIVE != 0";

			if ($condition) {
				$sql .= $condition;
			}
			$sql .= " order by `SO_DATE` ASC, `SB_ID` ";
			

			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return array();
			}
		}

		//COUNT OF BOOKED PENDING
		function get_booking_pending_count($condition=array()) 
		{
			$date = date("d-m-Y");
			$sql="SELECT * FROM `SEVA_BOOKING` JOIN `DEITY_SEVA_OFFERED` ON `SEVA_BOOKING`.`SB_ID` = `DEITY_SEVA_OFFERED`.`SO_SB_ID` WHERE STR_TO_DATE(SO_DATE,'%d-%m-%Y') < STR_TO_DATE('$date','%d-%m-%Y') AND SB_PAYMENT_STATUS = 0 AND SB_ACTIVE != 0 ";
			if ($condition) {
				$sql .= $condition;
			}
			$query = $this->db->query($sql);
			$row=$query->num_rows();
			return $row;
		}
	}
