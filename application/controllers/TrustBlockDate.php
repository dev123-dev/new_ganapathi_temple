<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TrustBlockDate extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model','user',true); 	
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		$this->load->helper('date');
		$this->load->model('Events_modal','obj_events',true);
		$this->load->model('Postage_model','obj_postage',true);
		$this->load->model('EventPostage_model','obj_event_postage',true);
		$this->load->model('TrustEventPostage_model','obj_event_trust_postage',true);
		date_default_timezone_set('Asia/Kolkata');
	}
	
	public function index(){
		//AUTO CANCELLATION - TRUST HALL BOOKING START HERE (PENDING,PARTIAL,COMPLETED)
		$sql = "SELECT * FROM TRUST_HALL_BOOKING WHERE HB_ACTIVE = 1";
		$query = $this->db->query($sql);
		$trustHallBooking = $query->result('array');
						
		//GET HALL BOOKING AUTO CANCELLATION DAYS 
		$this->db->select()->from('BOOKING_HALL');//15 Days
		$queryBH = $this->db->get();
		$bookingHDays = $queryBH->result();
		for($j = 0; $j < count($trustHallBooking); $j++) {
			$sql1 = "SELECT * FROM TRUST_HALL_BOOKING_LIST WHERE HBL_ACTIVE = 1 AND HB_ID = ".$trustHallBooking[$j]['HB_ID'];
			$query1 = $this->db->query($sql1);
			$trustHallBookingList = $query1->result('array');
			$count = 0;
			for($k = 0; $k < count($trustHallBookingList); $k++) {
				$date = "";
				$date = $trustHallBookingList[$k]['HB_BOOK_DATE'];
				
				$date1=date_create(date("Y-m-d"));
				$date2=date_create(date("Y-m-d", strtotime(@$date)));
				$diff=date_diff($date2,$date1);
				if($diff->format("%R%a") > $bookingHDays[0]->DAYS) {
					$count++;
				}
			}
			
			if($count == count($trustHallBookingList)) {
				$msg = "";
				if($trustHallBooking[$j]['HB_PAYMENT_STATUS'] == 0) {
					$msg = "Booking auto cancelled , all hall were cancelled and no payment was done";
				} else if($trustHallBooking[$j]['HB_PAYMENT_STATUS'] == 1) {
					$msg = "Booking auto cancelled , all hall were cancelled and partial payment was done";
				} else if($trustHallBooking[$j]['HB_PAYMENT_STATUS'] == 2) {
					$msg = "Booking auto cancelled , all hall were cancelled and full payment was done";
				}
				
				$data_array = array("CANCEL_NOTES"=> $msg,
									"CANCELLED_BY"=>'System',
									"CANCELLED_DATE_TIME"=>date("d-m-Y h:i:s"),
									"CANCELLED_DATE"=>date("d-m-Y"),
									"HB_ACTIVE" => 0);
				$condition = array('HB_ID' => $trustHallBooking[$j]['HB_ID']);
				$this->db->where($condition);
				$this->db->update("TRUST_HALL_BOOKING",$data_array);
				
				
				$where1 = array('HB_ID' => $trustHallBooking[$j]['HB_ID']);
				$this->db->where($where1);
				$this->db->select('HBL_ID')->from('trust_hall_booking_list');
				$query = $this->db->get();
				
													
				$where = array('HBL_ID' => $query->HBL_ID);
				$TRUST_BLOCK_DATE_TIME = array(
				'TBDT_ACTIVE'=>'0'
				);
				$this->db->where($where);
				$this->db->update("TRUST_BLOCK_DATE_TIME",$TRUST_BLOCK_DATE_TIME);
			}
		}
	}

}