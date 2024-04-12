<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_Recover_controller extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		
	}
	public function index() {
		$result_query = $this->db->query("SELECT * FROM shashwath_seva INNER JOIN shashwath_members ON shashwath_seva.SM_ID = shashwath_members.SM_ID WHERE SS_ID > 975")->result();
		$counter = 772;
		foreach($result_query as $result) {
			$dfMonth = $this->obj_admin_settings->get_financial_month();
			$datMonth = $this->get_shashwath_financial_year($dfMonth,$result->SS_RECEIPT_DATE);


			$RECEIPT_NO = "SLVT/".$datMonth."/M".$result->SM_REF."/SS".$result->SS_REF."/".++$counter;
			$RECEIPT_ADDRESS = $result->SM_ADDR1." ".$result->SM_ADDR2." ".$result->SM_CITY." ".$result->SM_STATE." ".$result->SM_COUNTRY." ".$result->SM_PIN;
			$RECEIPT_ADDRESS = str_replace("'","''",$RECEIPT_ADDRESS);
			/*echo $RECEIPT_NO."<br/>";
			echo $result->SS_RECEIPT_DATE."<br/>";
			echo $result->SM_NAME."<br/>";
			echo (($result->SM_PHONE != "0")? $result->SM_PHONE : "")."<br/>";*/
			$SM_PHONE = (($result->SM_PHONE != "0")? $result->SM_PHONE : "");
			/*echo $RECEIPT_ADDRESS."<br/>";
			echo $result->SM_RASHI."<br/>";
			echo $result->SM_NAKSHATRA."<br/>";
			echo "0<br/>";
			echo "Cash<br/>";
			echo "A. Vittaldas Nayak<br/>";
			echo $result->SS_ENTERED_BY_ID."<br/>";
			echo $result->SS_ENTERED_DATE_TIME."<br/>";
			echo "1<br/>";
			echo "7<br/>";
			echo "Completed<br/>";
			echo "Yes<br/>";
			echo "33<br/>";
			echo "C. Suresh Bhat<br/>";
			echo $result->SS_ENTERED_DATE_TIME."<br/>";
			echo $result->SS_ENTERED_DATE."<br/>";
			echo "33<br/>";
			echo "C. Suresh Bhat<br/>";
			echo $result->SS_ENTERED_DATE_TIME."<br/>";
			echo $result->SS_ENTERED_DATE."<br/>";
			echo "1<br/>";
			echo $result->SS_ID."<br/>";
			echo "0<br/>";*/
			
			/*$this->db->query("INSERT INTO `deity_receipt`(`RECEIPT_NO`, `RECEIPT_DATE`, `RECEIPT_NAME`, `RECEIPT_PHONE`, `RECEIPT_ADDRESS`, `RECEIPT_RASHI`, `RECEIPT_NAKSHATRA`, `RECEIPT_PRICE`, `RECEIPT_PAYMENT_METHOD`,`RECEIPT_ISSUED_BY`, `RECEIPT_ISSUED_BY_ID`, `DATE_TIME`, `RECEIPT_ACTIVE`,   `RECEIPT_CATEGORY_ID`, `PAYMENT_STATUS`,  `AUTHORISED_STATUS`, `AUTHORISED_BY`, `AUTHORISED_BY_NAME`, `AUTHORISED_DATE_TIME`, `AUTHORISED_DATE`,  `EOD_CONFIRMED_BY_ID`, `EOD_CONFIRMED_BY_NAME`, `EOD_CONFIRMED_DATE_TIME`, `EOD_CONFIRMED_DATE`, `POSTAGE_GROUP_ID`, `SS_ID`, `PRINT_STATUS`) VALUES ('$RECEIPT_NO','$result->SS_RECEIPT_DATE','$result->SM_NAME','$SM_PHONE', '$RECEIPT_ADDRESS','$result->SM_RASHI','$result->SM_NAKSHATRA',0,'Cash','A. Vittaldas Nayak',$result->SS_ENTERED_BY_ID,'$result->SS_ENTERED_DATE_TIME',1,7,'Completed','Yes',33,'C. Suresh Bhat','$result->SS_ENTERED_DATE_TIME','$result->SS_ENTERED_DATE',33,'C. Suresh Bhat','$result->SS_ENTERED_DATE_TIME','$result->SS_ENTERED_DATE',1,$result->SS_ID,0)");
			echo $this->db->insert_id();*/

		}

	}

	function get_shashwath_financial_year($month,$ssdate) {
		$dbFinMth = $month->MONTH_IN_NUMBER; //getting value from the database for start financial month 
		$currFinMth = date('n',strtotime($ssdate));
		if($dbFinMth == 1) {
			$fYear = date('Y',strtotime($ssdate));
		} else {
			if($currFinMth >= $dbFinMth && $currFinMth <= 12) {
				$year1 = date('Y',strtotime($ssdate));
				$year2 = $year1 + 1; 
			}
			if($currFinMth >= 1 && $currFinMth <= $dbFinMth - 1) {
				$year1 = date('Y',strtotime($ssdate))-1;
				$year2 = date('Y',strtotime($ssdate));
				}
			$fYear = $year1.'-'.substr($year2,2,2);
			}
			return $fYear;
	}
	
	
}
