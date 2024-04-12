<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shashwath extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('string');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Shashwath_Model','obj_shashwath',true);
		$this->load->model('Receipt_modal','obj_receipt',true);
		$this->load->model('finance_model','obj_finance',true);
		$this->load->helper(array('form', 'url'));
		$this->load->helper('date');
		if(!isset($_SESSION['userId']))
			redirect('login');
		if($_SESSION['trustLogin'] == 1)
			redirect('Trust');
	}

	
	// public function index($start=0){
	// 	$_SESSION['shashwathCount'] = $this->obj_shashwath->count_seva_for_date(date("d-m-Y"));
	// 	$data['whichTab'] = 'shashwath';
	// 	$this->load->library('pagination');
		
	// 	if(isset($_POST['generateDate'])) {
	// 		$_SESSION['generateDate'] = $data['date'] = $date = $everyDate = $_POST['generateDate'];
	// 	} else if(isset($_SESSION['generateDate'])) {
	// 		$data['date'] = $date = $everyDate = $_SESSION['generateDate'];
	// 	}
	// 	$selectedSsDate = date($date);
	// 	$oneYrLessSelDate = date("d-m-Y",strtotime($selectedSsDate."-1 year"));

	// 	$data['calendarCheck'] = $thithi_codes = $this->obj_shashwath->getThithiCode($date);  //$thithi_codes to be used before the generate button is clicked
	// 	$data['calendarCheckRoi'] = $thithi_codes_roi = $this->obj_shashwath->getThithiCodeROI($date);

	// 	$data['whichTab'] = 'shashwath';
	// 	unset($_SESSION['name_phone']);
	// 	$name_phone = '';
	// 	$data['maxYear'] = $this->obj_shashwath->getfinyear();	
	// 	$data['monthno'] = $this->obj_shashwath->getfinmonth();	

	// 	$condition = (" IS_TERMINAL = 1");
	// 	$data['bank'] = $this->obj_receipt->getAllbanks();
	// 	$data['terminal'] = $this->obj_receipt->getCardbanks($condition);


	// 	$data['deity'] = $this->obj_shashwath->getDeties();
	// 	$data['sevas'] = json_encode($this->obj_shashwath->getDetiesSevas());

	// 	$data['masa'] =  $this->obj_shashwath->getMasa();
	// 	$data['count_result']= $this->obj_shashwath->count_result($date);
	// 	$data['date'] = $notifyDate = $date;
	// 	$data['mandaliMembers'] = json_encode($this->obj_shashwath->mandali_member_details()); //new_code
	// 	if($data['count_result'] || $this->obj_shashwath->getSevaGeneratedPreviouslyStatus($date)){
	// 		$data['shashwath_Sevas'] = $this->obj_shashwath->getExistingSevas($date,10,$start,$name_phone); 
	// 		$data['total_countSeva'] = $config['total_rows'] = $this->obj_shashwath->getExistingSevasCount($date,$name_phone)? $this->obj_shashwath->getExistingSevasCount($date,$name_phone) : 0;
	// 	} else {
	// 		$thithi_where_condition = '';
	// 		if($thithi_codes_roi){
	// 			$ROI = $thithi_codes_roi[0]->CAL_ROI;
	// 		}
	// 		foreach($thithi_codes as $result) {
	// 			$thithi_where_condition .= "THITHI_CODE = '".$result->THITHI_SHORT_CODE."' OR ";  
	// 			//$ROI = $result->CAL_ROI;
	// 		}   
	// 		$date2 = explode("-",$date);
	// 		$date = $date2[0].'-'.$date2[1];
	// 		$thithi_where_condition .= "ENG_DATE = '".$date."'";

	// 		// //SLAP 29_06
	// 		// $Timestamp = strtotime($everyDate);
	// 		// $dayOfWeek = date("l", $Timestamp);
	// 		// $weekFirst = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 		// if($weekFirst == $everyDate){
	// 		// 	$firstDOW = "First_".$dayOfWeek;
	// 		// 	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."' OR EVERY_WEEK_MONTH = '".$firstDOW."'"; 
	// 		// }else{
	// 		// 	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'"; 
	// 		// }
	// 		// //End

	// 		//EVERY CAL TYPE START
	// 		$Timestamp = strtotime($everyDate);
	// 		$dayOfWeek = date("l", $Timestamp);
	// 		$thisMonth = date("M", $Timestamp);

	// 		$weekFirst  = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 		$weekSecond = date("d-m-Y", strtotime("second ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 		$weekThird  = date("d-m-Y", strtotime("third ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 		$weekFourth = date("d-m-Y", strtotime("fourth ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 		$weekLast   = date("d-m-Y", strtotime("last ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));

	// 		$M_DOW = $Y_DOW = $LM_DOW = $LY_DOW = "";
	// 		if($weekFirst == $everyDate){
	// 			$M_DOW = "First_".$dayOfWeek; 
	// 			$Y_DOW = $thisMonth."_First_".$dayOfWeek; 
	// 		}else if($weekSecond == $everyDate){
	// 			$M_DOW = "Second_".$dayOfWeek;
	// 			$Y_DOW = $thisMonth."_Second_".$dayOfWeek; 
	// 		}else if($weekThird == $everyDate){
	// 			$M_DOW = "Third_".$dayOfWeek; 
	// 			$Y_DOW = $thisMonth."_Third_".$dayOfWeek; 
	// 		}else if($weekFourth == $everyDate){
	// 			$M_DOW = "Fourth_".$dayOfWeek;
	// 			$Y_DOW = $thisMonth."_Fourth_".$dayOfWeek; 
	// 		}
	// 		if($weekLast == $everyDate){
	// 			$LM_DOW = "Last_".$dayOfWeek; 
	// 			$LY_DOW = $thisMonth."_Last_".$dayOfWeek; 
	// 		}

	// 		$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'";
	// 		if ($M_DOW) {
	// 			$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$M_DOW."' OR EVERY_WEEK_MONTH = '".$Y_DOW."'";
	// 		}
	// 		if ($LM_DOW) {
	// 			$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$LM_DOW."' OR EVERY_WEEK_MONTH = '".$LY_DOW."'";
	// 		}
	// 		//EVERY CAL TYPE END

			
	// 		if(isset($ROI)){
	// 			$data['shashwath_Sevas'] = $this->obj_shashwath->getShashwathSevas($date,$thithi_where_condition,$ROI,10,$start,$name_phone,'','',$oneYrLessSelDate);
	// 			$data['total_countSeva'] = $countGenerate = $config['total_rows'] = $this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,'','',$oneYrLessSelDate) ? $this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,'','',$oneYrLessSelDate) : 0;
	// 		}  		
	// 	}

	// 	$config['base_url'] = $data['base_url'] = base_url().'Shashwath/index';
	// 	$config['per_page'] = 10;
	// 	$config['prev_link'] = '&lt;&lt;';
	// 	$config['next_link'] = '&gt;&gt;';
	// 	$config['first_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	$config['first_tag_close'] = '</li>';
	// 	$config['last_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	$config['last_tag_close'] = '</li>';
	// 	$config['next_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	$config['next_tag_close'] = '</li>';
	// 	$config['prev_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	$config['prev_tag_close'] = '</li>';
	// 	$config['cur_tag_open'] = '<li class="active"><a>';
	// 	$config['cur_tag_close'] = '</a></li>';
	// 	$config['num_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	$config['num_tag_close'] = '</li>';
	// 	$config['last_link'] = 'Last';
	// 	$config['first_link'] = 'First';
	// 	$this->pagination->initialize($config);
	// 	$data['pages'] = $this->pagination->create_links();

	// 	$this->load->view('header',$data);
	// 	$this->load->view('Shashwath/shashwathSeva');
	// 	$this->load->view('footer_home');
	// }








// ///////////////////////////////////////////////////////////////////////old code start/////////////////////////////////
public function index($start=0){
	$_SESSION['shashwathCount'] = $this->obj_shashwath->count_seva_for_date(date("d-m-Y"));
	$data['whichTab'] = 'shashwath';
	$this->load->library('pagination');
	
	if(isset($_POST['generateDate'])) {
		$_SESSION['generateDate'] = $data['date'] = $date = $everyDate =  $_POST['generateDate'];
	} else if(isset($_SESSION['generateDate'])) {
		$data['date'] = $date = $everyDate = $_SESSION['generateDate'];
	}
	$selectedSsDate = date($date);
	$oneYrLessSelDate = date("d-m-Y",strtotime($selectedSsDate."-1 year"));

	$data['calendarCheck'] = $thithi_codes = $this->obj_shashwath->getThithiCode($date);  //$thithi_codes to be used before the generate button is clicked
	$data['calendarCheckRoi'] = $thithi_codes_roi = $this->obj_shashwath->getThithiCodeROI($date);

	$data['maxYear'] = $this->obj_shashwath->getfinyear();	
	$data['monthno'] = $this->obj_shashwath->getfinmonth();	
	$data['deity'] = $this->obj_shashwath->getDeties();
	$data['sevas'] = json_encode($this->obj_shashwath->getDetiesSevas());
	
	$data['whichTab'] = 'shashwath';
	unset($_SESSION['name_phone']);
	$name_phone = '';
	$data['count_result']= $this->obj_shashwath->count_result($date);
	$data['masa'] =  $this->obj_shashwath->getMasa();
	$data['date'] = $notifyDate = $date;
	$data['mandaliMembers'] = json_encode($this->obj_shashwath->mandali_member_details()); //new_code
	if($data['count_result'] || $this->obj_shashwath->getSevaGeneratedPreviouslyStatus($date)){
		$data['shashwath_Sevas'] = $this->obj_shashwath->getExistingSevas($date,10,$start,$name_phone); 
		$data['total_countSeva'] = $config['total_rows'] = $this->obj_shashwath->getExistingSevasCount($date,$name_phone)? $this->obj_shashwath->getExistingSevasCount($date,$name_phone) : 0;
	} else {
		$thithi_where_condition = '';
		if($thithi_codes_roi){
			$ROI = $thithi_codes_roi[0]->CAL_ROI;
		}
		foreach($thithi_codes as $result) {
			$thithi_where_condition .= "THITHI_CODE = '".$result->THITHI_SHORT_CODE."' OR ";  
		}   
		$date2 = explode("-",$date);
		$date = $date2[0].'-'.$date2[1];
		$thithi_where_condition .= "ENG_DATE = '".$date."'"; 
		

		$sql ="SELECT ENG_DATE,THITHI_SHORT_CODE,THITHI_NAME,MASA,based_on_moon,DAY,CAL_ID FROM `calendar_year_breakup` WHERE ENG_DATE='$everyDate'";
		$query = $this->db->query($sql);
		$dataMasa = $query->first_row(); 
		$Masa = $dataMasa->MASA;
		$CALID = $dataMasa->CAL_ID;

		$sql1="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='PADYA' AND based_on_moon='SHUDDHA' AND CAL_ID =$CALID";
		$query1 = $this->db->query($sql1);
		$dataStartDate  = $query1->first_row(); 
		$biginingDate =  $dataStartDate->ENG_DATE; 

		$sql2="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='AMAVASYA' AND CAL_ID =$CALID ";
		// echo $sql2;
		$query2 = $this->db->query($sql2);
		$dataEndtDate  = $query2->first_row(); 
		$endDate =  $dataEndtDate->ENG_DATE; 


			$Timestamp = strtotime($everyDate);
		$dayOfWeek = date("l", $Timestamp);
		$thisMonth = date("F", $Timestamp);
		$strtdateHindu=date($biginingDate);
		$enddateHindu=date($endDate);

		// if($strtdateHindu !='' and $enddateHindu != ''){
			//If it is hindu calender every case	
			$weekFirstHindu  = date('d-m-Y', strtotime('first '.$dayOfWeek.' '.$strtdateHindu));
			$weekSecondHindu = date('d-m-Y', strtotime('second '.$dayOfWeek.' '.$strtdateHindu));
			$weekThirdHindu  = date('d-m-Y', strtotime('third '.$dayOfWeek.' '.$strtdateHindu));
			$weekFourthHindu = date('d-m-Y', strtotime('fourth '.$dayOfWeek.' '.$strtdateHindu));
			$weekLastHindu   = date('d-m-Y', strtotime('last '.$dayOfWeek.' '.$enddateHindu));

			$M_DOW = $LM_DOW = $Y_DOW_HINDU = $LY_DOW_HINDU = "";
			if($weekFirstHindu == $everyDate){	
				$Y_DOW_HINDU = $Masa."_First_".$dayOfWeek; 
			}else if($weekSecondHindu == $everyDate){	
				$Y_DOW_HINDU = $Masa."_Second_".$dayOfWeek; 
			}else if($weekThirdHindu == $everyDate){
				$Y_DOW_HINDU = $Masa."_Third_".$dayOfWeek; 
			}else if($weekFourthHindu == $everyDate){	
				$Y_DOW_HINDU = $Masa."_Fourth_".$dayOfWeek; 
			
			}
	
			if($weekLastHindu == $everyDate){		
				$LY_DOW_HINDU = $Masa."_Last_".$dayOfWeek; 
			
			}
		// }else{
			//If it is gregorian calender every case
			$weekFirst  = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
			$weekSecond = date("d-m-Y", strtotime("second ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
			$weekThird  = date("d-m-Y", strtotime("third ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
			$weekFourth = date("d-m-Y", strtotime("fourth ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
			$weekLast   = date("d-m-Y", strtotime("last ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
		

			$M_DOW = $Y_DOW = $LM_DOW = $LY_DOW = "";
			if($weekFirst == $everyDate){
				$M_DOW = "First_".$dayOfWeek; 
				$Y_DOW = $thisMonth."_First_".$dayOfWeek; 
			}else if($weekSecond == $everyDate){
				$M_DOW = "Second_".$dayOfWeek;
				$Y_DOW = $thisMonth."_Second_".$dayOfWeek; 
			}else if($weekThird == $everyDate){
				$M_DOW = "Third_".$dayOfWeek; 
				$Y_DOW = $thisMonth."_Third_".$dayOfWeek; 
			}else if($weekFourth == $everyDate){
				$M_DOW = "Fourth_".$dayOfWeek;
				$Y_DOW = $thisMonth."_Fourth_".$dayOfWeek; 
				
			}
			
			if($weekLast == $everyDate){
				$LM_DOW = "Last_".$dayOfWeek; 
				$LY_DOW = $thisMonth."_Last_".$dayOfWeek; 
				
			}

		// }

		$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'";
		if ($M_DOW) {
			$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$M_DOW."' OR EVERY_WEEK_MONTH = '".$Y_DOW."'" ;
		}
		if ($LM_DOW) {
			$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$LM_DOW."' OR EVERY_WEEK_MONTH = '".$LY_DOW."' ";
		}

		if ($Y_DOW_HINDU) {
			$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$Y_DOW_HINDU."'";
		}

		if ($LY_DOW_HINDU) {
			$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$LY_DOW_HINDU."'";
		}
		//EVERY CAL TYPE END
		
		if(isset($ROI)){
			$data['shashwath_Sevas'] = $this->obj_shashwath->getShashwathSevas($date,$thithi_where_condition,$ROI,10,$start,$name_phone,'','',$oneYrLessSelDate);
			 $data['total_countSeva'] = $countGenerate = $config['total_rows'] = $this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,'','',$oneYrLessSelDate) ? $this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,'','',$oneYrLessSelDate) : 0;
		}  		
	}

	$config['base_url'] = $data['base_url'] =  base_url().'Shashwath/index';
	$config['per_page'] = 10;
	$config['prev_link'] = '&lt;&lt;';
	$config['next_link'] = '&gt;&gt;';
	$config['first_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	$config['first_tag_close'] = '</li>';
	$config['last_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	$config['last_tag_close'] = '</li>';
	$config['next_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	$config['next_tag_close'] = '</li>';
	$config['prev_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	$config['prev_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active"><a>';
	$config['cur_tag_close'] = '</a></li>';
	$config['num_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	$config['num_tag_close'] = '</li>';
	$config['last_link'] = 'Last';
	$config['first_link'] = 'First';
	$this->pagination->initialize($config);
	$data['pages'] = $this->pagination->create_links();
				
	$this->load->view('header',$data);
	$this->load->view('Shashwath/shashwathSeva');
	$this->load->view('footer_home');
}



// ///////////////////////////////////////////////////////////////////////old code end //////////////////////////////
	// public function index($start=0){
	// 	$_SESSION['shashwathCount'] = $this->obj_shashwath->count_seva_for_date(date("d-m-Y"));
	// 	$data['whichTab'] = 'shashwath';
	// 	$this->load->library('pagination');
		
	// 	if(isset($_POST['generateDate'])) {
	// 		$_SESSION['generateDate'] = $data['date'] = $date = $everyDate =  $_POST['generateDate'];
	// 	} else if(isset($_SESSION['generateDate'])) {
	// 		$data['date'] = $date = $everyDate = $_SESSION['generateDate'];
	// 	}
	// 	$selectedSsDate = date($date);
	// 	$oneYrLessSelDate = date("d-m-Y",strtotime($selectedSsDate."-1 year"));

	// 	$data['calendarCheck'] = $thithi_codes = $this->obj_shashwath->getThithiCode($date);  //$thithi_codes to be used before the generate button is clicked
	// 	$data['calendarCheckRoi'] = $thithi_codes_roi = $this->obj_shashwath->getThithiCodeROI($date);

	// 	$data['maxYear'] = $this->obj_shashwath->getfinyear();	
	// 	$data['monthno'] = $this->obj_shashwath->getfinmonth();	
	// 	$data['deity'] = $this->obj_shashwath->getDeties();
	// 	$data['sevas'] = json_encode($this->obj_shashwath->getDetiesSevas());
		
	// 	$data['whichTab'] = 'shashwath';
	// 	unset($_SESSION['name_phone']);
	// 	$name_phone = '';
	// 	$data['count_result']= $this->obj_shashwath->count_result($date);
	// 	$data['masa'] =  $this->obj_shashwath->getMasa();
	// 	$data['date'] = $notifyDate = $date;
	// 	$data['mandaliMembers'] = json_encode($this->obj_shashwath->mandali_member_details()); //new_code
	// 	if($data['count_result'] || $this->obj_shashwath->getSevaGeneratedPreviouslyStatus($date)){
	// 		$data['shashwath_Sevas'] = $this->obj_shashwath->getExistingSevas($date,10,$start,$name_phone); 
	// 		$data['total_countSeva'] = $config['total_rows'] = $this->obj_shashwath->getExistingSevasCount($date,$name_phone)? $this->obj_shashwath->getExistingSevasCount($date,$name_phone) : 0;
	// 	} else {
	// 		$thithi_where_condition = '';
	// 		if($thithi_codes_roi){
	// 			$ROI = $thithi_codes_roi[0]->CAL_ROI;
	// 		}
	// 		foreach($thithi_codes as $result) {
	// 			$thithi_where_condition .= "THITHI_CODE = '".$result->THITHI_SHORT_CODE."' OR ";  
	// 		}   
	// 		$date2 = explode("-",$date);
	// 		$date = $date2[0].'-'.$date2[1];
	// 		$thithi_where_condition .= "ENG_DATE = '".$date."'"; 
			
    //        // print_r($everyDate);
           
	// 		$sql ="SELECT ENG_DATE,THITHI_SHORT_CODE,THITHI_NAME,MASA,based_on_moon,DAY,CAL_ID FROM `calendar_year_breakup` WHERE ENG_DATE='$everyDate'";
	// 		$query = $this->db->query($sql);
	// 		$dataMasa = $query->first_row(); 
            
    //         if($dataMasa){
	// 			$Masa = $dataMasa->MASA;
	// 			$CALID = $dataMasa->CAL_ID;
	
	// 			$sql1="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='PADYA' AND based_on_moon='SHUDDHA' AND CAL_ID =$CALID";
	// 			$query1 = $this->db->query($sql1);
	// 			if($query1->num_rows() > 0) {
	// 				$dataStartDate  = $query1->first_row(); 
	// 				$biginingDate =  $dataStartDate->ENG_DATE;	
	// 			} else {
	// 				$biginingDate = "";
	// 			}
	// 			$sql2="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='AMAVASYA' AND CAL_ID =$CALID ";
	// 		    $query2 = $this->db->query($sql2);
	// 		    if($query1->num_rows() > 0) {
	// 		    	$dataEndtDate  = $query2->first_row(); 
	// 		    	$endDate =  $dataEndtDate->ENG_DATE; 	
	// 		    } else {
	// 		    	$endDate = "";
	// 		    }
	// 		    $Timestamp = strtotime($everyDate);
	// 		    $dayOfWeek = date("l", $Timestamp);
	// 		    $thisMonth = date("F", $Timestamp);
	// 		    $strtdateHindu=date($biginingDate);
	// 		    $enddateHindu=date($endDate);
    
	// 		    // if($strtdateHindu !='' and $enddateHindu != ''){
	// 		    //If it is hindu calender every case	
	// 		    $weekFirstHindu  = date('d-m-Y', strtotime('first '.$dayOfWeek.' '.$strtdateHindu));
	// 		    $weekSecondHindu = date('d-m-Y', strtotime('second '.$dayOfWeek.' '.$strtdateHindu));
	// 		    $weekThirdHindu  = date('d-m-Y', strtotime('third '.$dayOfWeek.' '.$strtdateHindu));
	// 		    $weekFourthHindu = date('d-m-Y', strtotime('fourth '.$dayOfWeek.' '.$strtdateHindu));
	// 		    $weekLastHindu   = date('d-m-Y', strtotime('last '.$dayOfWeek.' '.$enddateHindu));
	// 		    $M_DOW = $LM_DOW = $Y_DOW_HINDU = $LY_DOW_HINDU = "";
	// 		    if($weekFirstHindu == $everyDate){	
	// 		    	$Y_DOW_HINDU = $Masa."_First_".$dayOfWeek; 
	// 		    }else if($weekSecondHindu == $everyDate){	
	// 		    	$Y_DOW_HINDU = $Masa."_Second_".$dayOfWeek; 
	// 		    }else if($weekThirdHindu == $everyDate){
	// 		    	$Y_DOW_HINDU = $Masa."_Third_".$dayOfWeek; 
	// 		    }else if($weekFourthHindu == $everyDate){	
	// 		    	$Y_DOW_HINDU = $Masa."_Fourth_".$dayOfWeek; 
			    
	// 		    }
	// 		    if($weekLastHindu == $everyDate){		
	// 		    	$LY_DOW_HINDU = $Masa."_Last_".$dayOfWeek; 
			    
	// 		    }
	// 		    // }else{
	// 		    //If it is gregorian calender every case
	// 		    $weekFirst  = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 		    $weekSecond = date("d-m-Y", strtotime("second ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 		    $weekThird  = date("d-m-Y", strtotime("third ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 		    $weekFourth = date("d-m-Y", strtotime("fourth ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
	// 		    $weekLast   = date("d-m-Y", strtotime("last ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
			    
	// 		    $M_DOW = $Y_DOW = $LM_DOW = $LY_DOW = "";
	// 		    if($weekFirst == $everyDate){
	// 		    	$M_DOW = "First_".$dayOfWeek; 
	// 		    	$Y_DOW = $thisMonth."_First_".$dayOfWeek; 
	// 		    }else if($weekSecond == $everyDate){
	// 		    	$M_DOW = "Second_".$dayOfWeek;
	// 		    	$Y_DOW = $thisMonth."_Second_".$dayOfWeek; 
	// 		    }else if($weekThird == $everyDate){
	// 		    	$M_DOW = "Third_".$dayOfWeek; 
	// 		    	$Y_DOW = $thisMonth."_Third_".$dayOfWeek; 
	// 		    }else if($weekFourth == $everyDate){
	// 		    	$M_DOW = "Fourth_".$dayOfWeek;
	// 		    	$Y_DOW = $thisMonth."_Fourth_".$dayOfWeek; 
			    	
	// 		    }
	// 		    if($weekLast == $everyDate){
	// 			$LM_DOW = "Last_".$dayOfWeek; 
	// 			$LY_DOW = $thisMonth."_Last_".$dayOfWeek; 
				
	// 	        }

	// 	        $thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'";
	// 	        if ($M_DOW) {
	// 	        	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$M_DOW."' OR EVERY_WEEK_MONTH = '".$Y_DOW."'" ;
	// 	        }
	// 	        if ($LM_DOW) {
	// 	        	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$LM_DOW."' OR EVERY_WEEK_MONTH = '".$LY_DOW."' ";
	// 	        }

	// 	        if ($Y_DOW_HINDU) {
	// 	        	$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$Y_DOW_HINDU."'";
	// 	        }

	// 	        if ($LY_DOW_HINDU) {
	// 	        	$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$LY_DOW_HINDU."'";
	// 	        }
	// 		    //EVERY CAL TYPE END
			    
	// 		    if(isset($ROI)){
	// 		    	$data['shashwath_Sevas'] = $this->obj_shashwath->getShashwathSevas($date,$thithi_where_condition,$ROI,10,$start,$name_phone,'','',$oneYrLessSelDate);
	// 		    	 $data['total_countSeva'] = $countGenerate = $config['total_rows'] = $this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,'','',$oneYrLessSelDate) ? $this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,'','',$oneYrLessSelDate) : 0;
	// 		    } 
	// 		    $config['base_url'] = $data['base_url'] =  base_url().'Shashwath/index';
	// 	        $config['per_page'] = 10;
	// 	        $config['prev_link'] = '&lt;&lt;';
	// 	        $config['next_link'] = '&gt;&gt;';
	// 	        $config['first_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	        $config['first_tag_close'] = '</li>';
	// 	        $config['last_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	        $config['last_tag_close'] = '</li>';
	// 	        $config['next_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	        $config['next_tag_close'] = '</li>';
	// 	        $config['prev_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	        $config['prev_tag_close'] = '</li>';
	// 	        $config['cur_tag_open'] = '<li class="active"><a>';
	// 	        $config['cur_tag_close'] = '</a></li>';
	// 	        $config['num_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	        $config['num_tag_close'] = '</li>';
	// 	        $config['last_link'] = 'Last';
	// 	        $config['first_link'] = 'First';
	// 	        $this->pagination->initialize($config);
	// 	        $data['pages'] = $this->pagination->create_links();
		        			
	// 	        $this->load->view('header',$data);
	// 	        $this->load->view('Shashwath/shashwathSeva');
	// 	        $this->load->view('footer_home'); 		
				 
	// 		}
	// 		else{
	// 	          $config['base_url'] = $data['base_url'] =  base_url().'Shashwath/index';
	// 	          $config['per_page'] = 10;
	// 	          $config['prev_link'] = '&lt;&lt;';
	// 	          $config['next_link'] = '&gt;&gt;';
	// 	          $config['first_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	          $config['first_tag_close'] = '</li>';
	// 	          $config['last_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	          $config['last_tag_close'] = '</li>';
	// 	          $config['next_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	          $config['next_tag_close'] = '</li>';
	// 	          $config['prev_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	          $config['prev_tag_close'] = '</li>';
	// 	          $config['cur_tag_open'] = '<li class="active"><a>';
	// 	          $config['cur_tag_close'] = '</a></li>';
	// 	          $config['num_tag_open'] = '<li onclick="getStartedSpinnerOnPaginatedDataClick()">';
	// 	          $config['num_tag_close'] = '</li>';
	// 	          $config['last_link'] = 'Last';
	// 	          $config['first_link'] = 'First';
	// 	          $this->pagination->initialize($config);
	// 	          $data['pages'] = $this->pagination->create_links();
		          			
	// 	          $this->load->view('header',$data); 
	// 	          $this->load->view('Shashwath/shashwathSeva');
	// 	          $this->load->view('footer_home');

	// 		}	
	// 	}	
	// }


	public function changeShashwathSevaOfferedDate() {
		$thithi_codes =$everyDate = $this->obj_shashwath->getThithiCode($_POST['newDate']);
		$thithi_codes_roi = $this->obj_shashwath->getThithiCodeROI($_POST['newDate']);
		$thithi_where_condition = '';
		$selectedSsDate = date($_POST['newDate']);	//NEW3
		$oneYrLessSelDate = date("d-m-Y",strtotime($selectedSsDate."-1 year"));
		
		if($thithi_codes_roi){
				$ROI = $thithi_codes_roi[0]->CAL_ROI;
			}
		foreach($thithi_codes as $result) {
			$thithi_where_condition .= "THITHI_CODE = '".$result->THITHI_SHORT_CODE."' OR ";  
			// $ROI = $result->CAL_ROI;
		}   
		$date2 = explode("-",$_POST['newDate']);
		$date = $date2[0].'-'.$date2[1];
		$thithi_where_condition .= "ENG_DATE = '".$date."'";
		// //SLAP 29_06
		// $Timestamp = strtotime($_POST['newDate']);
		// $dayOfWeek = date("l", $Timestamp);
		// $weekFirst = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
		// if($weekFirst == $_POST['newDate']){
		// 	$firstDOW = "First_".$dayOfWeek;
		// 	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."' OR EVERY_WEEK_MONTH = '".$firstDOW."'"; 
		// }else{
		// 	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'"; 
		// }
		// //End

		//EVERY CAL TYPE START
			$sql ="SELECT ENG_DATE,THITHI_SHORT_CODE,THITHI_NAME,MASA,based_on_moon,DAY,CAL_ID FROM `calendar_year_breakup` WHERE ENG_DATE='everyDate'";
			$query = $this->db->query($sql);
			$dataMasa = $query->first_row(); 
			$Masa = $dataMasa->MASA;
			$CALID = $dataMasa->CAL_ID;

			$sql1="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='PADYA' AND based_on_moon='SHUDDHA' AND CAL_ID =$CALID";
			$query1 = $this->db->query($sql1);
			$dataStartDate  = $query1->first_row(); 
			$biginingDate =  $dataStartDate->ENG_DATE; 

			$sql2="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='AMAVASYA' AND CAL_ID =$CALID ";
			$query2 = $this->db->query($sql2);
			$dataEndtDate  = $query2->first_row(); 
			$endDate =  $dataEndtDate->ENG_DATE; 
			
			//EVERY CAL TYPE START
			$Timestamp = strtotime($everyDate);
			$dayOfWeek = date("l", $Timestamp);
			$thisMonth = date("F", $Timestamp);
			$strtdateHindu=date($biginingDate);
			$enddateHindu=date($endDate);

			// if($strtdateHindu !='' and $enddateHindu != ''){
				//If it is hindu calender every case	
				$weekFirstHindu  = date('d-m-Y', strtotime('first '.$dayOfWeek.' '.$strtdateHindu));
				$weekSecondHindu = date('d-m-Y', strtotime('second '.$dayOfWeek.' '.$strtdateHindu));
				$weekThirdHindu  = date('d-m-Y', strtotime('third '.$dayOfWeek.' '.$strtdateHindu));
				$weekFourthHindu = date('d-m-Y', strtotime('fourth '.$dayOfWeek.' '.$strtdateHindu));
				$weekLastHindu   = date('d-m-Y', strtotime('last '.$dayOfWeek.' '.$enddateHindu));

				$M_DOW = $LM_DOW = $Y_DOW_HINDU = $LY_DOW_HINDU = "";
				if($weekFirstHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_First_".$dayOfWeek; 
				}else if($weekSecondHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_Second_".$dayOfWeek; 
				}else if($weekThirdHindu == $everyDate){
					$Y_DOW_HINDU = $Masa."_Third_".$dayOfWeek; 
				}else if($weekFourthHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_Fourth_".$dayOfWeek; 
				
				}
		
				if($weekLastHindu == $everyDate){		
					$LY_DOW_HINDU = $Masa."_Last_".$dayOfWeek; 
				
				}
			// }else{
				//If it is gregorian calender every case
				$weekFirst  = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekSecond = date("d-m-Y", strtotime("second ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekThird  = date("d-m-Y", strtotime("third ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekFourth = date("d-m-Y", strtotime("fourth ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekLast   = date("d-m-Y", strtotime("last ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
			

				$M_DOW = $Y_DOW = $LM_DOW = $LY_DOW = "";
				if($weekFirst == $everyDate){
					$M_DOW = "First_".$dayOfWeek; 
					$Y_DOW = $thisMonth."_First_".$dayOfWeek; 
				}else if($weekSecond == $everyDate){
					$M_DOW = "Second_".$dayOfWeek;
					$Y_DOW = $thisMonth."_Second_".$dayOfWeek; 
				}else if($weekThird == $everyDate){
					$M_DOW = "Third_".$dayOfWeek; 
					$Y_DOW = $thisMonth."_Third_".$dayOfWeek; 
				}else if($weekFourth == $everyDate){
					$M_DOW = "Fourth_".$dayOfWeek;
					$Y_DOW = $thisMonth."_Fourth_".$dayOfWeek; 
					
				}
				
				if($weekLast == $everyDate){
					$LM_DOW = "Last_".$dayOfWeek; 
					$LY_DOW = $thisMonth."_Last_".$dayOfWeek; 
					
				}

			// }

			$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'";
			if ($M_DOW) {
				$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$M_DOW."' OR EVERY_WEEK_MONTH = '".$Y_DOW."'" ;
			}
			if ($LM_DOW) {
				$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$LM_DOW."' OR EVERY_WEEK_MONTH = '".$LY_DOW."' ";
			}

			if ($Y_DOW_HINDU) {
				$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$Y_DOW_HINDU."'";
			}

			if ($LY_DOW_HINDU) {
				$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$LY_DOW_HINDU."'";
			}
		//EVERY CAL TYPE END

		if($this->obj_shashwath->count_result($_POST['newDate']) || ($this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,"",'','',$oneYrLessSelDate) == 0)) { 
			$data = array('SO_DATE' => $_POST['newDate'], 
				'UPDATED_SO_DATE' => $_POST['newDate'],
				'UPDATED_BY_ID' => $_SESSION['userId']);

			$this->db->where('SO_ID',$_POST['soId']);
			$this->db->update('deity_seva_offered',$data);
			
			$_SESSION['generateDate'] = $_POST['setDate'];
			echo "success";
		} else {
			echo "No Generation";
		}
	}

	public function searchShashwathSeva($start=0){ 
		$data['whichTab'] = 'shashwath';
		$this->load->library('pagination');

		// $combo = $this->input->post('deityCombo1');
		// print_r($combo);
		$data['maxYear'] = $this->obj_shashwath->getfinyear();	
		$data['monthno'] = $this->obj_shashwath->getfinmonth();	
		$data['deity'] = $this->obj_shashwath->getDeties();
		$data['sevas'] = json_encode($this->obj_shashwath->getDetiesSevas());
		if(isset($_POST['generateDate'])) {
			$_SESSION['generateDate'] = $data['date'] = $date = $everyDate = $_POST['generateDate'];
		} else if(isset($_SESSION['generateDate'])) {
			$data['date'] = $date = $everyDate = $_SESSION['generateDate'];
		}
		$selectedSsDate = date($date);
		$oneYrLessSelDate = date("d-m-Y",strtotime($selectedSsDate."-1 year"));

		$data['calendarCheck'] = $thithi_codes = $this->obj_shashwath->getThithiCode($date);
		$data['calendarCheckRoi'] = $thithi_codes_roi = $this->obj_shashwath->getThithiCodeROI($date);
		
		if(isset($_POST['name_phone'])) 
			$_SESSION['name_phone'] = $name_phone = $data['name_phone'] = $this->input->post('name_phone');			
		else if(isset($_SESSION['name_phone'])) 
			$name_phone = $data['name_phone'] = $_SESSION['name_phone'];
		else 
			$name_phone = '';


		if(isset($_POST['deityCombo1'])) 
			$combo = $data['combo'] = $this->input->post('deityCombo1');			
		else {
			$combo = '';$sevaCombo = '';
		}


		if(isset($_POST['sevaCombo'])){
			if($_POST['sevaCombo']!=""){
				$getSevaCombo=explode("|", $this->input->post('sevaCombo'));
				$sevaCombo = $data['sevaCombo'] =$getSevaCombo[1];
			} else {
				$sevaCombo = "";
			}
		} else 
		$sevaCombo = "";
		
		$data['masa'] =  $this->obj_shashwath->getMasa();
		$data['count_result']= $this->obj_shashwath->count_result($date);
		$data['date'] = $notifyDate = $date;
		$data['mandaliMembers'] = json_encode($this->obj_shashwath->mandali_member_details()); //new_code
		if($data['count_result']){
			$data['shashwath_Sevas'] = $this->obj_shashwath->getExistingSevas($date,10,$start,$name_phone,$combo,$sevaCombo); 
			$data['total_countSeva'] = $config['total_rows'] = $this->obj_shashwath->getExistingSevasCount($date,$name_phone,$combo,$sevaCombo)? $this->obj_shashwath->getExistingSevasCount($date,$name_phone,$combo,$sevaCombo) : 0;
		} else {
			$thithi_where_condition = '';
			if($thithi_codes_roi){
				$ROI = $thithi_codes_roi[0]->CAL_ROI;
			}
			foreach($thithi_codes as $result){
				$thithi_where_condition .= "THITHI_CODE = '".$result->THITHI_SHORT_CODE."' OR ";  
				//$ROI = $result->CAL_ROI;
			} 	$date2 = explode("-",$date);
			$date = $date2[0].'-'.$date2[1];
			$thithi_where_condition .= "ENG_DATE = '".$date."'"; 

			// //SLAP 29_06
			// $Timestamp = strtotime($everyDate);
			// $dayOfWeek = date("l", $Timestamp);
			// $weekFirst = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
			// if($weekFirst == $everyDate){
			// 	$firstDOW = "First_".$dayOfWeek;
			// 	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."' OR EVERY_WEEK_MONTH = '".$firstDOW."'"; 
			// }else{
			// 	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'"; 
			// }
			// //End

			//EVERY CAL TYPE START
			
			$sql ="SELECT ENG_DATE,THITHI_SHORT_CODE,THITHI_NAME,MASA,based_on_moon,DAY,CAL_ID FROM `calendar_year_breakup` WHERE ENG_DATE='$everyDate'";
			$query = $this->db->query($sql);
			$dataMasa = $query->first_row(); 
			$Masa = $dataMasa->MASA;
			$CALID = $dataMasa->CAL_ID;

			$sql1="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='PADYA' AND based_on_moon='SHUDDHA' AND CAL_ID =$CALID";
			$query1 = $this->db->query($sql1);
			$dataStartDate  = $query1->first_row(); 
			$biginingDate =  $dataStartDate->ENG_DATE; 

			$sql2="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='AMAVASYA' AND CAL_ID =$CALID ";
			$query2 = $this->db->query($sql2);
			$dataEndtDate  = $query2->first_row(); 
			$endDate =  $dataEndtDate->ENG_DATE; 
			
			//EVERY CAL TYPE START
			$Timestamp = strtotime($everyDate);
			$dayOfWeek = date("l", $Timestamp);
			$thisMonth = date("F", $Timestamp);
			$strtdateHindu=date($biginingDate);
			$enddateHindu=date($endDate);

			// if($strtdateHindu !='' and $enddateHindu != ''){
				//If it is hindu calender every case	
				$weekFirstHindu  = date('d-m-Y', strtotime('first '.$dayOfWeek.' '.$strtdateHindu));
				$weekSecondHindu = date('d-m-Y', strtotime('second '.$dayOfWeek.' '.$strtdateHindu));
				$weekThirdHindu  = date('d-m-Y', strtotime('third '.$dayOfWeek.' '.$strtdateHindu));
				$weekFourthHindu = date('d-m-Y', strtotime('fourth '.$dayOfWeek.' '.$strtdateHindu));
				$weekLastHindu   = date('d-m-Y', strtotime('last '.$dayOfWeek.' '.$enddateHindu));

				$M_DOW = $LM_DOW = $Y_DOW_HINDU = $LY_DOW_HINDU = "";
				if($weekFirstHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_First_".$dayOfWeek; 
				}else if($weekSecondHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_Second_".$dayOfWeek; 
				}else if($weekThirdHindu == $everyDate){
					$Y_DOW_HINDU = $Masa."_Third_".$dayOfWeek; 
				}else if($weekFourthHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_Fourth_".$dayOfWeek; 
				
				}
		
				if($weekLastHindu == $everyDate){		
					$LY_DOW_HINDU = $Masa."_Last_".$dayOfWeek; 
				
				}
			// }else{
				//If it is gregorian calender every case
				$weekFirst  = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekSecond = date("d-m-Y", strtotime("second ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekThird  = date("d-m-Y", strtotime("third ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekFourth = date("d-m-Y", strtotime("fourth ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekLast   = date("d-m-Y", strtotime("last ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
			

				$M_DOW = $Y_DOW = $LM_DOW = $LY_DOW = "";
				if($weekFirst == $everyDate){
					$M_DOW = "First_".$dayOfWeek; 
					$Y_DOW = $thisMonth."_First_".$dayOfWeek; 
				}else if($weekSecond == $everyDate){
					$M_DOW = "Second_".$dayOfWeek;
					$Y_DOW = $thisMonth."_Second_".$dayOfWeek; 
				}else if($weekThird == $everyDate){
					$M_DOW = "Third_".$dayOfWeek; 
					$Y_DOW = $thisMonth."_Third_".$dayOfWeek; 
				}else if($weekFourth == $everyDate){
					$M_DOW = "Fourth_".$dayOfWeek;
					$Y_DOW = $thisMonth."_Fourth_".$dayOfWeek; 
					
				}
				
				if($weekLast == $everyDate){
					$LM_DOW = "Last_".$dayOfWeek; 
					$LY_DOW = $thisMonth."_Last_".$dayOfWeek; 
					
				}

			// }

			$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'";
			if ($M_DOW) {
				$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$M_DOW."' OR EVERY_WEEK_MONTH = '".$Y_DOW."'" ;
			}
			if ($LM_DOW) {
				$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$LM_DOW."' OR EVERY_WEEK_MONTH = '".$LY_DOW."' ";
			}

			if ($Y_DOW_HINDU) {
				$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$Y_DOW_HINDU."'";
			}

			if ($LY_DOW_HINDU) {
				$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$LY_DOW_HINDU."'";
			}
			//EVERY CAL TYPE END


			if(isset($ROI)){
				$data['shashwath_Sevas'] = $this->obj_shashwath->getShashwathSevas($date,$thithi_where_condition,$ROI,10,$start,$name_phone,$combo,$sevaCombo,$oneYrLessSelDate);
				$data['total_countSeva'] = $countGenerate = $config['total_rows'] = $this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,$combo,$sevaCombo,$oneYrLessSelDate) ? $this->obj_shashwath->getShashwathSevasCount($date,$thithi_where_condition,$ROI,$name_phone,$combo,$sevaCombo,$oneYrLessSelDate) : 0;
				// $_SESSION['countGenerateSeva'] = $countGenerate;
			} else {
				// $_SESSION['countGenerateSeva'] = 0;
			} 
		}
		
		// print_r($data['shashwath_Sevas']);		
		$resut1 = $this->obj_shashwath->getExistingSevasCount($date,$name_phone);
		$config['base_url'] =  $data['base_url'] = base_url().'Shashwath/searchShashwathSeva';
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);
		$this->load->view('Shashwath/shashwathSeva');
		$this->load->view('footer_home');
	}
	
	public function priceAdd(){
		$data = $this->input->post('indexVal');
		$memberData = $this->obj_shashwath->priceAdd($data);
		print_r($memberData[0]->SM_NAME.'$'.$memberData[0]->SO_SEVA_NAME.'$'.$memberData[0]->SO_ID);

	}
	public function priceSubmit(){
		if(isset($_POST['selectedDate'])){
			$date = $_POST['selectedDate'];
		}
		$soId = $this->input->post('id');
		$price = $this->input->post('price');
		$this->obj_shashwath->priceSubmit($price,$soId); 
		$_SESSION['date1'] = $date;
		if(isset($_POST['fromAddSevaPrice'])){
			redirect('Shashwath/addSevaPrice');
		} else {
			redirect('Shashwath/index');
		}

	}
	public function addSevaPrice($start=0){
		$date = date('d-m-Y');
		$data['date'] = $date;
		$result = $this->obj_shashwath->seva_Offered_No_Price_Count($date);
		$_SESSION['sevaOfferedNoPriceCount'] = $result;
		//$data['shashwath_Sevas'] = $this->obj_shashwath->addSevaPrice($date); 
		$this->load->library('pagination');
		$data['shashwath_Sevas'] = $this->obj_shashwath->addSevaPrice($date,10,$start); 
		$config['base_url'] = base_url().'Shashwath/addSevaPrice';
		$config['total_rows'] = $this->obj_shashwath->seva_Offered_No_Price_Count($date);
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);           
		$this->load->view('Shashwath/addSevaPrice');
		$this->load->view('footer_home');
	}

	public function generateSeva(){
		if(isset($_POST['generateDate'])){
			$date = $everyDate = $_POST['generateDate'];
			$dateMonth = explode('-',$date);
			$searchDate = $dateMonth[0].'-'.$dateMonth[1];
		}	
		$selectedSsDate = date($date);
		$oneYrLessSelDate = date("d-m-Y",strtotime($selectedSsDate."-1 year"));	
		$data = $this->obj_shashwath->getThithiCode($date);
		$thithi_codes_roi = $this->obj_shashwath->getThithiCodeROI($date);
		$thithi_where_condition = '';
		if($thithi_codes_roi){
				$ROI = $thithi_codes_roi[0]->CAL_ROI;
			}
		foreach($data as $result){
			$thithi_where_condition .= "THITHI_CODE = '".$result->THITHI_SHORT_CODE."' OR ";  
			// $ROI = $result->CAL_ROI;
		}
		$dateTime = date('d-m-Y H:i:s A');
		$todayDate = date('d-m-Y');
		$userId= $_SESSION['userId'];	
		$thithi_where_condition .= "ENG_DATE = '".$searchDate."'"; 
		
		// //SLAP 29_06
		// $Timestamp = strtotime($everyDate);
		// $dayOfWeek = date("l", $Timestamp);
		// $weekFirst = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
		// if($weekFirst == $everyDate){
		// 	$firstDOW = "First_".$dayOfWeek;
		// 	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."' OR EVERY_WEEK_MONTH = '".$firstDOW."'"; 
		// }else{
		// 	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'"; 
		// }
		// //End

		//EVERY CAL TYPE START
		
			$sql ="SELECT ENG_DATE,THITHI_SHORT_CODE,THITHI_NAME,MASA,based_on_moon,DAY,CAL_ID FROM `calendar_year_breakup` WHERE ENG_DATE='$everyDate'";
			$query = $this->db->query($sql);
			$dataMasa = $query->first_row(); 
			$Masa = $dataMasa->MASA;
			$CALID = $dataMasa->CAL_ID;

			$sql1="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='PADYA' AND based_on_moon='SHUDDHA' AND CAL_ID =$CALID";
			$query1 = $this->db->query($sql1);
			$dataStartDate  = $query1->first_row(); 
			$biginingDate =  $dataStartDate->ENG_DATE; 

			$sql2="SELECT ENG_DATE FROM `calendar_year_breakup` where Masa ='$Masa' and THITHI_NAME ='AMAVASYA' AND CAL_ID =$CALID ";
			$query2 = $this->db->query($sql2);
			$dataEndtDate  = $query2->first_row(); 
			$endDate =  $dataEndtDate->ENG_DATE; 
			
			//EVERY CAL TYPE START
			$Timestamp = strtotime($everyDate);
			$dayOfWeek = date("l", $Timestamp);
			$thisMonth = date("F", $Timestamp);
			$strtdateHindu=date($biginingDate);
			$enddateHindu=date($endDate);

			// if($strtdateHindu !='' and $enddateHindu != ''){
				//If it is hindu calender every case	
				$weekFirstHindu  = date('d-m-Y', strtotime('first '.$dayOfWeek.' '.$strtdateHindu));
				$weekSecondHindu = date('d-m-Y', strtotime('second '.$dayOfWeek.' '.$strtdateHindu));
				$weekThirdHindu  = date('d-m-Y', strtotime('third '.$dayOfWeek.' '.$strtdateHindu));
				$weekFourthHindu = date('d-m-Y', strtotime('fourth '.$dayOfWeek.' '.$strtdateHindu));
				$weekLastHindu   = date('d-m-Y', strtotime('last '.$dayOfWeek.' '.$enddateHindu));

				$M_DOW = $LM_DOW = $Y_DOW_HINDU = $LY_DOW_HINDU = "";
				if($weekFirstHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_First_".$dayOfWeek; 
				}else if($weekSecondHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_Second_".$dayOfWeek; 
				}else if($weekThirdHindu == $everyDate){
					$Y_DOW_HINDU = $Masa."_Third_".$dayOfWeek; 
				}else if($weekFourthHindu == $everyDate){	
					$Y_DOW_HINDU = $Masa."_Fourth_".$dayOfWeek; 
				
				}
		
				if($weekLastHindu == $everyDate){		
					$LY_DOW_HINDU = $Masa."_Last_".$dayOfWeek; 
				
				}
			// }else{
				//If it is gregorian calender every case
				$weekFirst  = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekSecond = date("d-m-Y", strtotime("second ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekThird  = date("d-m-Y", strtotime("third ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekFourth = date("d-m-Y", strtotime("fourth ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
				$weekLast   = date("d-m-Y", strtotime("last ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
			

				$M_DOW = $Y_DOW = $LM_DOW = $LY_DOW = "";
				if($weekFirst == $everyDate){
					$M_DOW = "First_".$dayOfWeek; 
					$Y_DOW = $thisMonth."_First_".$dayOfWeek; 
				}else if($weekSecond == $everyDate){
					$M_DOW = "Second_".$dayOfWeek;
					$Y_DOW = $thisMonth."_Second_".$dayOfWeek; 
				}else if($weekThird == $everyDate){
					$M_DOW = "Third_".$dayOfWeek; 
					$Y_DOW = $thisMonth."_Third_".$dayOfWeek; 
				}else if($weekFourth == $everyDate){
					$M_DOW = "Fourth_".$dayOfWeek;
					$Y_DOW = $thisMonth."_Fourth_".$dayOfWeek; 
					
				}
				
				if($weekLast == $everyDate){
					$LM_DOW = "Last_".$dayOfWeek; 
					$LY_DOW = $thisMonth."_Last_".$dayOfWeek; 
					
				}

			// }

			$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'";
			if ($M_DOW) {
				$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$M_DOW."' OR EVERY_WEEK_MONTH = '".$Y_DOW."'" ;
			}
			if ($LM_DOW) {
				$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$LM_DOW."' OR EVERY_WEEK_MONTH = '".$LY_DOW."' ";
			}

			if ($Y_DOW_HINDU) {
				$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$Y_DOW_HINDU."'";
			}

			if ($LY_DOW_HINDU) {
				$thithi_where_condition .= " OR EVERY_WEEK_MONTH = '".$LY_DOW_HINDU."'";
			}
		//EVERY CAL TYPE END

		$this->obj_shashwath->generateSeva($date,$thithi_where_condition,$ROI,$dateTime,$todayDate,$userId,$oneYrLessSelDate);
		$_SESSION['generateDate'] = $date;
		$plus2date = date('d-m-Y', strtotime(date('d-m-Y'). ' + 2 days'));
		if($plus2date == $date)
			unset($_SESSION['blnShashwathSevaExists']);
		redirect('Shashwath/index');		  
	}
	
	public function shashwath_member($start=0){
		unset($_SESSION['member_actual_link']);
		$member_actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['member_actual_link'] = $member_actual_link;
		$data['masa'] =  $this->obj_shashwath->getMasa();
		$data['maxYear'] = $this->obj_shashwath->getfinyear();	
		$data['monthno'] = $this->obj_shashwath->getfinmonth();	
		$data['whichTab'] = 'shashwath';
		unset($_SESSION['name_phone']);
		$name_phone = '';
		$data['ShashwathMemberCount'] = $this->obj_shashwath->count_rows_member();
		$data['ShashwathUnverifedCount'] = $this->obj_shashwath->count_unverifed_rows();
		$data['ShashwathUnverifedMemberCount'] = $this->obj_shashwath->count_unverifed_member_rows();
		
		//$data['records'] = $this->obj_shashwath->get_member_details();
		$this->load->library('pagination');
		$data['ShashwathMember'] = $this->obj_shashwath->get_member_details(10,$start,$name_phone);
		$data['ShashwathMemberName'] = $this->obj_shashwath->membermerge_details();

		
		//	$data['memberCount'] = $this->obj_shashwath->count_rows_member();
		$config['base_url'] = base_url().'Shashwath/shashwath_member';
		$config['total_rows']= $this->obj_shashwath->count_rows_member($name_phone);
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);           
		$this->load->view('Shashwath/memberDetails');
		$this->load->view('footer_home');
	}
	
	public function search_shashwath_member($start=0){
		unset($_SESSION['member_actual_link']);
		$member_actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['member_actual_link'] = $member_actual_link;

		$data['whichTab'] = 'shashwath';
		if(isset($_POST['name_phone'])){
			$_SESSION['name_phone'] = $this->input->post('name_phone');
			$name_phone = $this->input->post('name_phone');
			$data['name_phone'] = $name_phone;   
		} else if(isset($_SESSION['name_phone'])) {
			$name_phone = $_SESSION['name_phone'];
			$data['name_phone'] = $name_phone;
		} else {
			$name_phone = '';
		}

		$data['masa'] =  $this->obj_shashwath->getMasa();
		$data['maxYear'] = $this->obj_shashwath->getfinyear();	
		$data['monthno'] = $this->obj_shashwath->getfinmonth();	
		$data['ShashwathMemberCount'] = $this->obj_shashwath->count_rows_member($name_phone);
		$data['ShashwathUnverifedCount'] = $this->obj_shashwath->count_unverifed_rows();
		$data['ShashwathUnverifedMemberCount'] = $this->obj_shashwath->count_unverifed_member_rows();

		//$data['records'] = $this->obj_shashwath->get_member_details();
		$this->load->library('pagination');
		$data['ShashwathMember'] = $this->obj_shashwath->get_member_details(10,$start,$name_phone);
		$data['ShashwathMemberName'] = $this->obj_shashwath->membermerge_details();

		//$data['memberCount'] = $this->obj_shashwath->count_rows_member();
		$config['base_url'] = base_url().'Shashwath/search_shashwath_member';
		$config['total_rows']= $this->obj_shashwath->count_rows_member($name_phone);
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		
		$this->load->view('header',$data);           
		$this->load->view('Shashwath/memberDetails');
		$this->load->view('footer_home');
	}
	
	public function member_seva_details(){
		$data['whichTab'] = 'shashwath';
		$this->load->view('header',$data);
		$this->load->view('Shashwath/memberSevaDetails');
		$this->load->view('footer_home');
	}
	
	function addMember() {
		//$bomid = $this->input->post('bm');
		$data1['whichTab'] = 'shashwath';
		$data1['deity'] = $this->obj_shashwath->getDeties();

		//slap
		//bank 															
		// $data1['bank'] = $this->obj_receipt->get_banks("false");				//laz new..
		// $data1['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..

        $startDate  ="";
        $endDate  ="";
		$condition = (" IS_TERMINAL = 1");																									
		// $data1['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data1['terminal'] = $this->obj_receipt->get_banks($condition);
		$data1['bank'] = $this->obj_receipt->getAllbanks();
		$data1['terminal'] = $this->obj_receipt->getCardbanks($condition);
		$condition1 = ("and finacial_group_ledger_heads.TYPE_ID = 'L' or finacial_group_ledger_heads.TYPE_ID = 'I'");	
		$data1['ledger'] =  $this->obj_finance->getLedger($condition1,$compId = "",$startDate,$endDate);

		$data1['sevas'] = json_encode($this->obj_shashwath->getDetiesSevas());
		//$data1['thithi'] =  $this->obj_shashwath->getThithi($bomid);
		$data1['thithi_shudda'] =  $this->obj_shashwath->getThithi(1);
		$data1['thithi_bahula'] =  $this->obj_shashwath->getThithi(2);
		$data1['masa'] =  $this->obj_shashwath->getMasa();
		$data1['moon'] =  $this->obj_shashwath->getBasedOnMoon();
		$data1['period'] = $this->obj_shashwath->getPeriod();
		$data1['festival'] =  $this->obj_shashwath->getFestival();	//festival
		if(isset($_SESSION['Deity_Seva'])) {
			$this->load->view('header', $data1);
			$this->load->view('Shashwath/shashwathMember');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
		//print_r($data);
	}

	
	public function get_corpus_history(){
		$ssId = @$_POST['ss_id'];
		echo "success|".json_encode($this->obj_shashwath->corpus_raise_details($ssId));
	}
	
	public function edit_shashwath_member(){
		$data['whichTab'] = 'shashwath';
		$data['deity'] = $this->obj_shashwath->getDeties();
		$data['deityEdit'] = json_encode($this->obj_shashwath->getDeties());

		$condition = (" IS_TERMINAL = 1");
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);

		$data['sevas'] = json_encode($this->obj_shashwath->getDetiesSevas());
		//$data['thithi'] =  $this->obj_shashwath->getThithi1();
		$data['thithi_shudda'] =  $this->obj_shashwath->getThithi(1);
		$data['thithi_shudda_edit'] =  json_encode($this->obj_shashwath->getThithi(1));

		$data['thithi_bahula'] =  $this->obj_shashwath->getThithi(2); 
		$data['thithi_bahula_edit'] =  json_encode($this->obj_shashwath->getThithi(2)); 
		
		$data['masa'] =  $this->obj_shashwath->getMasa();
		$data['masaEdit'] =  json_encode($this->obj_shashwath->getMasa());

		$data['moon'] =  $this->obj_shashwath->getBasedOnMoon();
		$data['moonEdit'] =  json_encode($this->obj_shashwath->getBasedOnMoon());

		$data['period'] = $this->obj_shashwath->getPeriod();
		$data['periodEdit'] = json_encode($this->obj_shashwath->getPeriod());

		$data['festival'] =  $this->obj_shashwath->getFestival();	//festival
		$data['festivalEdit'] =  json_encode($this->obj_shashwath->getFestival());
		//$data1 = $_SESSION['memberId'];
		//$data1 = $this->input->post('memberId');
		if(@$_POST['memberId']){
			$data['memberId'] = @$_SESSION['memberId'] = $data1 = @$_POST['memberId'];
			$data['afterDelete'] = "";
		} else if(@$_SESSION['memberId']) {
			$data['memberId'] = $data['afterDelete'] = $data1 = @$_SESSION['memberId'];
		}
		//$_SESSION['id'] = $data1;
		$data['members'] = $this->obj_shashwath->member_details($data1);
		$data['mandaliMembers'] = $this->obj_shashwath->mandali_member_details($data1); 
		$data['calendarCheck'] = $thithi_codes = $this->obj_shashwath->getThithiCode(date("d-m-Y"));
		$condition1 = ("and finacial_group_ledger_heads.TYPE_ID = 'L' or finacial_group_ledger_heads.TYPE_ID = 'I'");	
		$data['ledger'] =  $this->obj_finance->getLedger($condition1,$compId = "",$startDate="",$endDate="");
		$data['base_url'] = base_url().'Shashwath/edit_shashwath_member';
		//print_r($data1);
		if(isset($_SESSION['Deity_Seva'])) {
			$this->load->view('header', $data);
			$this->load->view('Shashwath/editShashwathDetails');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
		
	}

	public function shaswathaddcorpusdetails(){
		$data['whichTab'] = 'shashwath';
		$condition = (" IS_TERMINAL = 1");
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);
		if(@$_POST['smID']){
			$data['smID'] = @$_SESSION['smID'] = $data1 = @$_POST['smID'];
		} else if(@$_SESSION['memberId']) {
			$data['smID'] = $data1 = @$_SESSION['smID'];
		}
		$data['members'] = $this->obj_shashwath->member_details($data1);
		$data['mandaliMembers'] = $this->obj_shashwath->mandali_member_details($data1); 
		$condition1 = ("and finacial_group_ledger_heads.TYPE_ID = 'L' or finacial_group_ledger_heads.TYPE_ID = 'I'");
		$data['ledger'] =  $this->obj_finance->getLedger($condition1,$compId = "",$startDate="",$endDate="");
		$data['smphone'] = $smphone = @$_POST['smphone'];
		$data['cpin'] = $cpin = @$_POST['cpin'];
		$data['addr1'] = $addr1 = @$_POST['addr1'];
		$data['addr2'] = $addr2 = @$_POST['addr2'];
		$data['sccity'] = $sccity = @$_POST['sccity'];
		$data['ssstate'] = $ssstate = @$_POST['ssstate'];
		$data['sccountry'] = $sccountry = @$_POST['sccountry'];
		$data['deityIdName'] = $deityIdName = @$_POST['deityIdName'];
		$data['sevaname'] = $sevaname = @$_POST['sevaname'];
		$data['receipt_number'] = $receipt_number = @$_POST['receipt_number'];
		$data['nameph'] = $nameph = @$_POST['nameph'];
		$data['corpusraiseamt'] = $corpusraiseamt = @$_POST['corpusraiseamt'];
		$data['seseva'] = $seseva = @$_POST['seseva'];
		$data['shashid'] = $ssid = @$_POST['ssid'];
		$data['corpusCallFrom'] = $corpusCallFrom = @$_POST['corpusCallFrom'];

		$data['base_url'] = $baseurl = $this->input->post('baseurl');
		
		$this->load->view('header', $data);
		$this->load->view('Shashwath/shaswathaddcorpus');
		$this->load->view('footer_home');	
	}

	// public function shashwathAddlCorpusMerge() {
	// 	$data['whichTab'] = 'shashwath';
	// 	$data['call'] = $_POST['call'];
	// 	// $thithiCondition = $_POST['selectedThithiCode'];
	// 	$selectedMembersSearchItems  = $data['selectedMembersSearchItems'] = $_POST['selectedMembersSearchItems'];
	// 	// print_r($selectedMembersSearchItems);
	// 	$selectedMembersSearchSsId = $data['selectedMembersSearchSsId']  = $_POST['selectedMembersSearchSsId'];

	// 	if($selectedMembersSearchItems!=""){
	// 		$selectedItems = $data['selectedItems'] = json_decode($selectedMembersSearchItems);
	// 		$selectedSsId = $data['selectedSsId']= json_decode($selectedMembersSearchSsId);
	// 		// print_r($selectedItems);
	// 		$mergeCondition = "AND((shashwath_members.SM_ID = $selectedItems[0] AND shashwath_seva.SS_ID = $selectedSsId[0])";
	// 		for($i = 1; $i < count($selectedItems); ++$i) {
	// 			$mergeCondition.= " OR (shashwath_members.SM_ID = $selectedItems[$i] AND shashwath_seva.SS_ID = $selectedSsId[$i])";	
	// 		}
	// 		$mergeCondition.= ")";
	// 	}else{
	// 		$mergeCondition="";
	// 	}

	// 	$data['members'] = $members =$this->obj_shashwath->member_details_for_corpus_issue($mergeCondition);
	// 	$data['membersTotalCorpus'] = $membersTotalCorpus =$this->obj_shashwath->member_details_for_totalCorpus($mergeCondition);

	// 	if(isset($_SESSION['Deity_Seva'])) {
	// 		$this->load->view('header', $data);
	// 		$this->load->view('Shashwath/shashwathAddlCorpusMerge');
	// 		$this->load->view('footer_home');
	// 	} else {
	// 		redirect('Home/homePage');
	// 	}
	// }

	public function shashwathAddlCorpusMerge() {
		$data['whichTab'] = 'shashwath';
		$data['call'] = $_POST['call'];
		$selectedMembersSearchItems  = $data['selectedMembersSearchItems'] = $_POST['selectedMembersSearchItems'];
		$selectedMembersSearchSsId = $data['selectedMembersSearchSsId']  = $_POST['selectedMembersSearchSsId'];

		if($selectedMembersSearchItems!=""){
			$selectedItems = $data['selectedItems'] = json_decode($selectedMembersSearchItems);
			$selectedSsId = $data['selectedSsId']= json_decode($selectedMembersSearchSsId);
			$mergeCondition = "AND((shashwath_members.SM_ID = $selectedItems[0] AND shashwath_seva.SS_ID = $selectedSsId[0])";
			for($i = 1; $i < count($selectedItems); ++$i) {
				$mergeCondition.= " OR (shashwath_members.SM_ID = $selectedItems[$i] AND shashwath_seva.SS_ID = $selectedSsId[$i])";	
			}
			$mergeCondition.= ")";
		}else{
			$mergeCondition="";
		}

		$conditionSmId = "SM_ID = $selectedItems[0]";
		for($j = 1; $j < count($selectedItems); ++$j) {
			$conditionSmId.= " OR SM_ID = $selectedItems[$j]";
		}

		$sqlMandliMem ="SELECT SM_ID FROM `shashwath_members` WHERE ($conditionSmId) AND IS_MANDALI=1";
		$queryMandaliMem = $this->db->query($sqlMandliMem);
		$membermandali = $queryMandaliMem->first_row();
		$mandlimembers ='';
		if ($queryMandaliMem->num_rows() > 0) {
			$data['MMCount'] =1;
			$conditionMandaliSmId ="SM_ID = $membermandali->SM_ID" ;
			$data['mandlimembers'] = $mandlimembers= $this->obj_shashwath->mandali_members_details($conditionMandaliSmId);
		}else{
			$data['MMCount']=0;
		}

		$data['members'] = $members =$this->obj_shashwath->member_details_for_corpus_issue($mergeCondition);
		$data['membersTotalCorpus'] = $membersTotalCorpus =$this->obj_shashwath->member_details_for_totalCorpus($mergeCondition);
		if (isset($_SESSION['secTab'])) {
			$data['secondTab'] = $_SESSION['secTab'];
		}else{
			$data['secondTab'] = 'No';
		}
		

		if(isset($_SESSION['Deity_Seva'])) {
			$this->load->view('header', $data);
			$this->load->view('Shashwath/shashwathAddlCorpusMerge');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}


	public function shashwathAddlCorpusMergeSave() {
		$data['whichTab'] = 'shashwath';
		$this->session->unset_userdata('secTab');
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');

		$shashMinId = @$_POST['shashMinId'];
		// $shashThithiCode = @$_POST['shashThithiCode'];
		$shashMinSsId = @$_POST['shashMinSsId'];
		$shashMembId = json_decode(@$_POST['shashMembId']);
		$shashSsId = json_decode(@$_POST['shashSsId']);

		$addrline1 =strtoupper($this->input->post('addrline1'));
		$addrline2 = strtoupper($this->input->post('addrline2'));
		$smcity = strtoupper($this->input->post('smcity'));
		$smstate = strtoupper($this->input->post('smstate'));
		$smcountry = strtoupper($this->input->post('smcountry'));
		$smpin = strtoupper($this->input->post('smpin'));	

		$membData = array (		
			'SM_NAME' => strtoupper($this->input->post('name')),
			'SM_PHONE' => $this->input->post('number'),
			'SM_PHONE2' => $this->input->post('number2'),
			'SM_RASHI' => $this->input->post('rashi'),
			'SM_NAKSHATRA' => $this->input->post('nakshatra'),
			'SM_GOTRA' => $this->input->post('gotra'),
			'SM_ADDR1' => $addrline1,
			'SM_ADDR2' => $addrline2,
			'SM_CITY' => $smcity,
			'SM_STATE' => $smstate,
			'SM_COUNTRY' => $smcountry,
			'SM_PIN' => $smpin,
			'REMARKS' => $this->input->post('smremarks') 
		);


		$sm_address = (($addrline1 != "")?$addrline1.", ":"").(($addrline2 != "")?$addrline2.", ":"").(($smcity != "")?$smcity." ":"").(($smstate != "")?$smstate." ":"").(($smcountry != "")?$smcountry." - ":"").(($smpin != "")?$smpin:"");
		$adrs = str_replace("'","\'",$sm_address);
		
		//lathesh code start
		$receiptLine1 = $this->input->post('receiptLine1');
		//lathesh code end

		//To get the result set of the min ssId
		$this ->db->select('shashwath_seva.SS_ID,SS_REF,shashwath_members.SM_ID,shashwath_members.SM_REF,deity_receipt.RECEIPT_ID,deity_receipt.RECEIPT_NO,SS_RECEIPT_NO')->from('shashwath_seva')-> join('shashwath_members','shashwath_members.SM_ID = shashwath_seva.SM_ID')->join('deity_receipt','deity_receipt.SS_ID = shashwath_seva.SS_ID')
		->where(array('shashwath_seva.SM_ID'=> $shashMinId))
		->where('shashwath_seva.SS_ID',$shashMinSsId);
		// ->where('THITHI_CODE',$shashThithiCode);  
		$queryMinShashRefIds = $this->db->get();
		$MinShashRefIds = $queryMinShashRefIds->first_row();

		$data = array (		
			'SS_RECEIPT_NO_REF'=> $MinShashRefIds->SS_RECEIPT_NO,
		);
		$this->db->where('RECEIPT_ID',$MinShashRefIds->RECEIPT_ID);
		$this->db->update('deity_receipt',$data);

		//To get the reference details
		$this->db->select()->from('SHASHWATH_MEMBER_SEVA_REFERENCE');	
		$query1 = $this->db->get();
		$rowResult = $query1->first_row();
		$memberReceiptFormat1 = $rowResult->SM_ABBR1.$MinShashRefIds->SM_REF."/".$rowResult->SS_ABBR1.$MinShashRefIds->SS_REF."/";

		//To loop All SM_ID
		if (count($shashMembId) > 0) {
			$i = 0;
			foreach($shashMembId as $ShashSeva) {
				//to store the member details in shashwath member history table
				$smId =$ShashSeva; 

				$sqlSM="SELECT * FROM shashwath_members where SM_ID = $smId ";
				$querySM = $this->db->query($sqlSM);
				$dataSM = $querySM->first_row(); 
				$adres = ($dataSM->SM_PHONE.",").($dataSM->SM_ADDR2.",").($dataSM->SM_CITY.",").($dataSM->SM_STATE.",").($dataSM->SM_COUNTRY.",").($dataSM->SM_PIN);

				$dataSmDelete = array (	
					'SM_ID' => $dataSM->SM_ID,
					'SM_NAME' => $dataSM->SM_NAME,
					'SM_PHONE' =>  $dataSM->SM_PHONE,
					'SM_ADDR' => $adres,
					'SM_REMARK' => $dataSM->REMARKS,
					'DELETED_BY'=> $_SESSION['userId'],
					'DELETED_DATE_TIME' => $dateTime
				);
				
				//To Upadte the member details for all the SM_ID of shash member
				$this->db->where('SM_ID',$smId);
				$this->db->update('shashwath_members',$membData);


				$sql="UPDATE deity_receipt a JOIN shashwath_seva b ON a.SS_ID = b.SS_ID JOIN shashwath_members c ON b.SM_ID =c.SM_ID
				SET  a.RECEIPT_NAME = c.SM_NAME, a.RECEIPT_PHONE = c.SM_PHONE, a.RECEIPT_RASHI = c.SM_RASHI, a.RECEIPT_NAKSHATRA = c.SM_NAKSHATRA, a.RECEIPT_ADDRESS = '$adrs'  where c.SM_ID = '$smId'";
				$this->db->query($sql);

				$ssId =	$shashSsId[$i];
				if($smId != $shashMinId){
					$this ->db->select('shashwath_seva.SS_ID,SS_REF,SS_RECEIPT_NO, shashwath_members.SM_ID, shashwath_members.SM_REF, deity_receipt.RECEIPT_ID, deity_receipt.RECEIPT_NO,SS_RECEIPT_NO_REF, shashwath_seva.SEVA_ID,shashwath_seva.DEITY_ID, SEVA_QTY, SEVA_TYPE, CAL_TYPE, RECEIPT_DATE, RECEIPT_PRICE, ENG_DATE, THITHI_CODE')->from('shashwath_seva')-> join('shashwath_members','shashwath_members.SM_ID = shashwath_seva.SM_ID')->join('deity_receipt','deity_receipt.SS_ID = shashwath_seva.SS_ID')
					->where('shashwath_seva.SM_ID', $smId)
					->where('shashwath_seva.SS_ID', $ssId);
					// ->where('THITHI_CODE',$shashThithiCode);  
					$query4 = $this->db->get();
					$refnums = $query4->result();

					if ($query4->num_rows() > 0) {
						foreach($refnums as $ShashAddlSeva) {
							$sql5="SELECT RECEIPT_NO, LEFT(RECEIPT_NO,13) as leftRno,SUBSTRING_INDEX(RECEIPT_NO,'/',-1) as rightRno FROM deity_receipt where  RECEIPT_ID = $ShashAddlSeva->RECEIPT_ID ";
							$query5 = $this->db->query($sql5);
							$receiptFormat = $query5->first_row(); 

							$RnoFormat = $receiptFormat->leftRno.$memberReceiptFormat1.$receiptFormat->rightRno;

							if($ShashAddlSeva->SS_RECEIPT_NO_REF==""){
								$ssRecNoRef = $ShashAddlSeva->SS_RECEIPT_NO;
							}else{
								$ssRecNoRef = $ShashAddlSeva->SS_RECEIPT_NO_REF;
							}

							$deleteShashData = array (		
							'SS_ID' =>  $ShashAddlSeva->SS_ID,
							'SM_ID' => $ShashAddlSeva->SM_ID,
							'SS_REF' => $ShashAddlSeva->SS_REF,
							'SS_RECEIPT_NO' => $ShashAddlSeva->SS_RECEIPT_NO,
							'SEVA_ID' =>  $ShashAddlSeva->SEVA_ID,
							'DEITY_ID' => $ShashAddlSeva->DEITY_ID,
							'QTY' => $ShashAddlSeva->SEVA_QTY,
							'SEVA_TYPE' => $ShashAddlSeva->SEVA_TYPE,
							'CAL_TYPE' => $ShashAddlSeva->CAL_TYPE,
							'THITHI_CODE_ENG_DATE' => ($ShashAddlSeva->ENG_DATE!="" ? $ShashAddlSeva->ENG_DATE : $ShashAddlSeva->THITHI_CODE),
							'RECEIPT_ID' => $ShashAddlSeva->RECEIPT_ID,
							'RECEIPT_NO' => $ShashAddlSeva->RECEIPT_NO,
							'RECEIPT_DATE' => $ShashAddlSeva->RECEIPT_DATE,
							'RECEIPT_PRICE' => $ShashAddlSeva->RECEIPT_PRICE,
							'DELETE_REASON' => "Additional Corpus Merge",
							'DELETED_DATE_TIME' => $dateTime,
							'DELETED_BY' => $_SESSION['userId'],
							);

							$data = array (		
								'SS_ID' => $shashMinSsId,
								'SS_RECEIPT_NO_REF'=> $ssRecNoRef,
								'RECEIPT_NO' => $RnoFormat,
							);

							$this->db->where('RECEIPT_ID',$ShashAddlSeva->RECEIPT_ID);
							$this->db->update('deity_receipt',$data);	

							//To Fetch Count Of deity Receipt corresponding to the deleting ss_id
							$sql6 ="SELECT RECEIPT_ID FROM deity_receipt where SS_ID = $ShashAddlSeva->SS_ID";
							$query6 = $this->db->query($sql6);


							if($query6->num_rows() <= 0) {
								$sql7 = "DELETE FROM shashwath_seva where SS_ID = $ShashAddlSeva->SS_ID ";
								$query7 = $this->db->query($sql7);
								$this->db->insert('shashwath_seva_delete_history',$deleteShashData);
							}

							//To Fetch Count Of deity Receipt corresponding to the deleting sm_id
							$sql8 ="SELECT SS_ID FROM shashwath_seva  where SM_ID = $ShashAddlSeva->SM_ID";
							$query8 = $this->db->query($sql8);
							// print_r($ShashAddlSeva->SM_ID);
							$sql10 ="UPDATE shashwath_seva set MERGE_STATUS = 1  where SS_ID = $shashMinSsId";
							$query10 = $this->db->query($sql10);

							if($query8->num_rows() < 1) {
								$sql11="SELECT MM_ID,SM_ID FROM shashwath_mandali_member_details WHERE SM_ID=$ShashAddlSeva->SM_ID";
								$query11 = $this->db->query($sql11);
								if($query11->num_rows() >0) {
									$sql12="UPDATE shashwath_mandali_member_details set SM_ID=$shashMinId WHERE SM_ID=$ShashAddlSeva->SM_ID AND MM_NAME!='Mandali Sevadhar'";
									$query12 = $this->db->query($sql12);
									$sql13="DELETE FROM shashwath_mandali_member_details WHERE SM_ID=$ShashAddlSeva->SM_ID AND MM_NAME = 'Mandali Sevadhar'";
									$query13 = $this->db->query($sql13);
								}
								$sql9 = "DELETE FROM shashwath_members where SM_ID = $ShashAddlSeva->SM_ID";
								$query9 = $this->db->query($sql9);

								$this->db->insert('shashwath_member_delete_history',$dataSmDelete);
							}
						}
					}	
				} else {
					$this ->db->select('shashwath_seva.SS_ID,SS_REF,SS_RECEIPT_NO,shashwath_members.SM_ID,shashwath_members.SM_REF, deity_receipt.RECEIPT_ID, deity_receipt.RECEIPT_NO,SS_RECEIPT_NO_REF, shashwath_seva.SEVA_ID,shashwath_seva.DEITY_ID, SEVA_QTY, SEVA_TYPE,CAL_TYPE,RECEIPT_DATE, RECEIPT_PRICE, ENG_DATE, THITHI_CODE')->from('shashwath_seva')-> join('shashwath_members','shashwath_members.SM_ID = shashwath_seva.SM_ID')->join('deity_receipt','deity_receipt.SS_ID = shashwath_seva.SS_ID')
					->where('shashwath_seva.SM_ID', $smId)
					->where('shashwath_seva.SS_ID', $ssId);
					// ->where('THITHI_CODE',$shashThithiCode);  
					$query4 = $this->db->get();
					$data['refnums'] = $refnums = $query4->result();

					if ($query4->num_rows() > 0) {
						foreach($refnums as $ShashAddlSeva) {
							$sql5="SELECT RECEIPT_NO, LEFT(RECEIPT_NO,13) as leftRno,SUBSTRING_INDEX(RECEIPT_NO,'/',-1) as rightRno FROM deity_receipt where  RECEIPT_ID = $ShashAddlSeva->RECEIPT_ID ";
							$query5 = $this->db->query($sql5);
							$receiptFormat = $query5->first_row(); 

							$RnoFormat = $receiptFormat->leftRno.$memberReceiptFormat1.$receiptFormat->rightRno;

							if($ShashAddlSeva->SS_RECEIPT_NO_REF==""){
								$ssRecNoRef = $ShashAddlSeva->SS_RECEIPT_NO;
							}else{
								$ssRecNoRef = $ShashAddlSeva->SS_RECEIPT_NO_REF;
							}

							$deleteShashData = array (		
							'SS_ID' =>  $ShashAddlSeva->SS_ID,
							'SM_ID' => $ShashAddlSeva->SM_ID,
							'SS_REF' => $ShashAddlSeva->SS_REF,
							'SS_RECEIPT_NO' => $ShashAddlSeva->SS_RECEIPT_NO,
							'SEVA_ID' =>  $ShashAddlSeva->SEVA_ID,
							'DEITY_ID' => $ShashAddlSeva->DEITY_ID,
							'QTY' => $ShashAddlSeva->SEVA_QTY,
							'SEVA_TYPE' => $ShashAddlSeva->SEVA_TYPE,
							'CAL_TYPE' => $ShashAddlSeva->CAL_TYPE,
							'THITHI_CODE_ENG_DATE' => ($ShashAddlSeva->ENG_DATE!="" ? $ShashAddlSeva->ENG_DATE : $ShashAddlSeva->THITHI_CODE),
							'RECEIPT_ID' => $ShashAddlSeva->RECEIPT_ID,
							'RECEIPT_NO' => $ShashAddlSeva->RECEIPT_NO,
							'RECEIPT_DATE' => $ShashAddlSeva->RECEIPT_DATE,
							'RECEIPT_PRICE' => $ShashAddlSeva->RECEIPT_PRICE,
							'DELETE_REASON' => "Additional Corpus Merge",
							'DELETED_DATE_TIME' => $dateTime,
							'DELETED_BY' => $_SESSION['userId'],
							);

							$data = array (		
								'SS_ID' => $shashMinSsId,
								'SS_RECEIPT_NO_REF'=> $ssRecNoRef,
								'RECEIPT_NO' => $RnoFormat,
							);

							$this->db->where('RECEIPT_ID',$ShashAddlSeva->RECEIPT_ID);
							$this->db->update('deity_receipt',$data);	

							//To Fetch Count Of deity Receipt corresponding to the deleting ss_id
							$sql6 ="SELECT RECEIPT_ID FROM deity_receipt where SS_ID = $ShashAddlSeva->SS_ID";
							$query6 = $this->db->query($sql6);


							if($query6->num_rows() <= 0) {
								$sql7 = "DELETE FROM shashwath_seva where SS_ID = $ShashAddlSeva->SS_ID ";
								$query7 = $this->db->query($sql7);
								$this->db->insert('shashwath_seva_delete_history',$deleteShashData);
							}

							//To Fetch Count Of deity Receipt corresponding to the deleting sm_id
							$sql8 ="SELECT SS_ID FROM shashwath_seva  where SM_ID = $ShashAddlSeva->SM_ID";
							$query8 = $this->db->query($sql8);
							// print_r($ShashAddlSeva->SM_ID);
							$sql10 ="UPDATE shashwath_seva set MERGE_STATUS = 1  where SS_ID = $shashMinSsId";
							$query10 = $this->db->query($sql10);

							// if($query8->num_rows() < 1) {
							// 	if(count($shashMinId) > 1){
							// 		if($refnums->SEVA_ID >1 && $refnums->DEITY_ID >1){
							// 			$sql9 = "DELETE MAX(SS_Id) FROM shashwath_seva where SM_ID =shashMinId";
							// 			$query9 = $this->db->query($sql9);
							// 			$this->db->insert('shashwath_seva_delete_history',$deleteShashData);
							// 		}
							// 	}
							// 	// $sql9 = "DELETE FROM shashwath_members where SM_ID = $ShashAddlSeva->SM_ID";
							// 	// $query9 = $this->db->query($sql9);

							// 	//$this->db->insert('shashwath_member_delete_history',$dataSmDelete);

							// }
						}
					}	
				}
				$i++;
			}

		}
		
		echo "success";
	}

	
	public function delete_shashwath_member(){
		$data['whichTab'] = 'shashwath';
		$data['deity'] = $this->obj_shashwath->getDeties();
		$data['deityEdit'] = json_encode($this->obj_shashwath->getDeties());

		$data1 = $this->input->post('memberDeleteId');
		//$_SESSION['id'] = $data1;
		$data['members'] = $this->obj_shashwath->member_details($data1);

		//print_r($data1);
		if(isset($_SESSION['Deity_Seva'])) {
			$this->load->view('header', $data);
			$this->load->view('Shashwath/shashwathMemberDelete');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
		
	}

	public function delete_shashwath_member_submit(){
		$data['whichTab'] = 'shashwath';
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		
		$smId = @$_POST['memberDeleteId'];
		$deleteReason = @$_POST['deleteReason'];

		// $this ->db->select('shashwath_seva.SS_ID, shashwath_members.SM_ID, deity_receipt.RECEIPT_ID')->from('shashwath_seva')-> join('shashwath_members','shashwath_members.SM_ID = shashwath_seva.SM_ID')->join('deity_receipt','deity_receipt.SS_ID = shashwath_seva.SS_ID')
		$this ->db->select('shashwath_members.SM_ID, shashwath_seva.SS_ID, RECEIPT_ID, SM_NAME, SM_PHONE, SM_ADDR1, SM_ADDR2, SM_CITY, SM_STATE, SM_COUNTRY, SM_PIN, REMARKS, SS_REF, SS_RECEIPT_NO, shashwath_seva.SEVA_ID, shashwath_seva.DEITY_ID, SEVA_QTY, SEVA_TYPE, CAL_TYPE, ENG_DATE, THITHI_CODE, RECEIPT_NO, RECEIPT_DATE, RECEIPT_PRICE')->from('shashwath_seva')-> join('shashwath_members','shashwath_members.SM_ID = shashwath_seva.SM_ID')->join('deity_receipt','deity_receipt.SS_ID = shashwath_seva.SS_ID')
		->where('shashwath_seva.SM_ID', $smId);

		$query4 = $this->db->get();
		$refnums = $query4->result();


		if ($query4->num_rows() > 0) {
			foreach($refnums as $ShashAddlSeva) {
				$adres = ($ShashAddlSeva->SM_ADDR1.",").($ShashAddlSeva->SM_ADDR2.",").($ShashAddlSeva->SM_CITY.",").($ShashAddlSeva->SM_STATE.",").($ShashAddlSeva->SM_COUNTRY.",").($ShashAddlSeva->SM_PIN);
				$dataSmDelete = array (	
					'SM_ID' => $ShashAddlSeva->SM_ID,
					'SM_NAME' => $ShashAddlSeva->SM_NAME,
					'SM_PHONE' =>  $ShashAddlSeva->SM_PHONE,
					'SM_ADDR' => $adres,
					'SM_REMARK' => $ShashAddlSeva->REMARKS,
					'DELETED_BY'=> $_SESSION['userId'],
					'DELETED_DATE_TIME' => $dateTime
				);

				$deleteShashData = array (		
					'SS_ID' =>  $ShashAddlSeva->SS_ID,
					'SM_ID' => $ShashAddlSeva->SM_ID,
					'SS_REF' => $ShashAddlSeva->SS_REF,
					'SS_RECEIPT_NO' => $ShashAddlSeva->SS_RECEIPT_NO,
					'SEVA_ID' =>  $ShashAddlSeva->SEVA_ID,
					'DEITY_ID' => $ShashAddlSeva->DEITY_ID,
					'QTY' => $ShashAddlSeva->SEVA_QTY,
					'SEVA_TYPE' => $ShashAddlSeva->SEVA_TYPE,
					'CAL_TYPE' => $ShashAddlSeva->CAL_TYPE,
					'THITHI_CODE_ENG_DATE' => ($ShashAddlSeva->ENG_DATE!="" ? $ShashAddlSeva->ENG_DATE : $ShashAddlSeva->THITHI_CODE) ,
					'RECEIPT_ID' => $ShashAddlSeva->RECEIPT_ID,
					'RECEIPT_NO' => $ShashAddlSeva->RECEIPT_NO,
					'RECEIPT_DATE' => $ShashAddlSeva->RECEIPT_DATE,
					'RECEIPT_PRICE' => $ShashAddlSeva->RECEIPT_PRICE,
					'DELETE_REASON' => $deleteReason,
					'DELETED_DATE_TIME' => $dateTime,
					'DELETED_BY' => $_SESSION['userId'],
				);

				$sql2 = "DELETE FROM deity_receipt where SS_ID = $ShashAddlSeva->SS_ID";
				$query2 = $this->db->query($sql2);

				//To Fetch Count Of deity Receipt corresponding to the deleting ss_id
				$sql6 ="SELECT RECEIPT_ID FROM deity_receipt where SS_ID = $ShashAddlSeva->SS_ID";
				$query6 = $this->db->query($sql6);
				$this->db->insert('shashwath_seva_delete_history',$deleteShashData);

				if($query6->num_rows() <= 0) {
					$sql7 = "DELETE FROM shashwath_seva where SS_ID = $ShashAddlSeva->SS_ID ";
					$query7 = $this->db->query($sql7);
				}

				//To Fetch Count Of deity Receipt corresponding to the deleting sm_id
				$sql8 ="SELECT SS_ID FROM shashwath_seva  where SM_ID = $ShashAddlSeva->SM_ID";
				$query8 = $this->db->query($sql8);
				// print_r($ShashAddlSeva->SM_ID);

				if($query8->num_rows() < 1) {
					$sql9 = "DELETE FROM shashwath_members where SM_ID = $ShashAddlSeva->SM_ID";
					$query9 = $this->db->query($sql9);

					$this->db->insert('shashwath_member_delete_history',$dataSmDelete);
				}
			}
		}	
		redirect('Shashwath/shashwath_member');

	}
	public function edit_existing_shashwath_member() {
		$data['whichTab'] = 'shashwath';
		$data['deity'] = $this->obj_shashwath->getDeties();
		$data['sevas'] = json_encode($this->obj_shashwath->getDetiesSevas());

		//slap
		//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..

		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);


		//$data['thithi'] =  $this->obj_shashwath->getThithi1();
		$data['thithi_shudda'] =  $this->obj_shashwath->getThithi(1);
		$data['thithi_bahula'] =  $this->obj_shashwath->getThithi(2); 
		$data['masa'] =  $this->obj_shashwath->getMasa();
		$data['moon'] =  $this->obj_shashwath->getBasedOnMoon();
		$data['period'] = $this->obj_shashwath->getPeriod();
		$data['festival'] =  $this->obj_shashwath->getFestival();	//festival
		//$data1 = $_SESSION['memberId'];
		$data1 = $this->input->post('memberId');
		//$_SESSION['id'] = $data1;
		$data['members'] = $this->obj_shashwath->existing_member_details($data1);

		//print_r($data1);
		if(isset($_SESSION['Deity_Seva'])) {
			$this->load->view('header', $data);
			$this->load->view('Shashwath/editExistingShashwathDetails');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}
	

	public function lossReport($start = 0){
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		$data['whichTab'] = 'shashwath';
		if(isset($_POST['date'])){
			$date = $_POST['date'];
		} else if($start != 0){
			// $date = $_SESSION['losspageDate'];
			// $this->session->unset_userdata('losspageDate');
		} else {
			$date = '';
		}


		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getAllbanks();


		$data['whichTab'] = 'shashwath';
		unset($_SESSION['name_phone']);
		$name_phone = '';

		$countLossSeva = $this->obj_shashwath->count_LossReport_Rows($name_phone);
		//$data['date'] = $date;
		$this->load->library('pagination');
		$data['mainLoss'] = $this->obj_shashwath->getMainLossdetails(10,$start,$name_phone);
		$data['TotalAccumulatedLoss'] = $this->obj_shashwath->getTotalAccumulatedLoss($name_phone);
		$config['base_url'] = base_url().'Shashwath/lossReport';
		$config['total_rows'] = $this->obj_shashwath->count_LossReport_Rows($name_phone);
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		//print_r($data['mainLoss']);
		$this->load->view('header',$data);
		$this->load->view('Shashwath/Loss_report');
		$this->load->view('footer_home');
	}

	// public function lossReport($start = 0){
	// 	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	// 	$_SESSION['actual_link'] = $actual_link;
	// 	$data['whichTab'] = 'shashwath';
	// 	if(isset($_POST['date'])){
	// 		$date = $_POST['date'];
	// 	} else if($start != 0){
			
	// 	} else {
	// 		$date = date('d-m-Y');
	// 	}
		
	// 	$data['bank'] = $this->obj_receipt->getAllbanks();
	// 	$data['terminal'] = $this->obj_receipt->getAllbanks();


	// 	$data['whichTab'] = 'shashwath';
	// 	unset($_SESSION['name_phone']);
	// 	$name_phone = '';

	// 	$countLossSeva = $this->obj_shashwath->count_LossReport_Rows($date,$name_phone);
	// 	$this->load->library('pagination');
	// 	$data['mainLoss'] = $this->obj_shashwath->getMainLossdetails(10,$start,$name_phone);
	// 	$data['TotalAccumulatedLoss'] = $this->obj_shashwath->getTotalAccumulatedLoss($date,$name_phone);
	// 	$config['base_url'] = base_url().'Shashwath/lossReport';
	// 	$config['total_rows'] = $this->obj_shashwath->count_LossReport_Rows($date,$name_phone);
	// 	$config['per_page'] = 10;
	// 	$config['prev_link'] = '&lt;&lt;';
	// 	$config['next_link'] = '&gt;&gt;';
	// 	$config['first_tag_open'] = '<li>';
	// 	$config['first_tag_close'] = '</li>';
	// 	$config['last_tag_open'] = '<li>';
	// 	$config['last_tag_close'] = '</li>';
	// 	$config['next_tag_open'] = '<li>';
	// 	$config['next_tag_close'] = '</li>';
	// 	$config['prev_tag_open'] = '<li>';
	// 	$config['prev_tag_close'] = '</li>';
	// 	$config['cur_tag_open'] = '<li class="active"><a>';
	// 	$config['cur_tag_close'] = '</a></li>';
	// 	$config['num_tag_open'] = '<li>';
	// 	$config['num_tag_close'] = '</li>';
	// 	$config['last_link'] = 'Last';
	// 	$config['first_link'] = 'First';
	// 	$this->pagination->initialize($config);
	// 	$data['pages'] = $this->pagination->create_links();
	// 	$this->load->view('header',$data);
	// 	$this->load->view('Shashwath/Loss_report');
	// 	$this->load->view('footer_home');
	// }

	
	public function search_lossReport($start = 0) {
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		$data['whichTab'] = 'shashwath';
		if(isset($_POST['date'])){
			$date = $_POST['date'];
		} else if($start != 0){
			// $date = $_SESSION['losspageDate'];
			// $this->session->unset_userdata('losspageDate');
		} else {
			$date = date('d-m-Y');
		} 

		if(isset($_POST['date'])) {
			$_SESSION['date'] = $data['date'] = $date = $everyDate = $_POST['date'];
		} else if(isset($_SESSION['date'])) {
			$data['date'] = $date = $everyDate = $_SESSION['date'];
		}
		
		if(isset($_POST['name_phone'])){
			$_SESSION['name_phone'] = $this->input->post('name_phone');
			$name_phone = $this->input->post('name_phone');
			$data['name_phone'] = $name_phone;   
		} else if(isset($_SESSION['name_phone'])) {
			$name_phone = $_SESSION['name_phone'];
			$data['name_phone'] = $name_phone;
		} else {
			$name_phone = '';
		} 
		
		//$countLossSeva = $this->obj_shashwath->count_LossReport_Rows($date,$name_phone);
		//print_r($countLossSeva);
		//$_SESSION['countLossSeva'] = $countLossSeva;
		$data['date'] = $date;
		$this->load->library('pagination');
		$data['mainLoss'] = $this->obj_shashwath->getMainLoss($date,10,$start,$name_phone);
		$config['base_url'] = base_url().'Shashwath/search_lossReport';
		$data['TotalAccumulatedLoss'] = $this->obj_shashwath->getTotalAccumulatedLoss($date,$name_phone);
		$config['total_rows']= $this->obj_shashwath->count_LossReport_Rows($date,$_SESSION['name_phone']);
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		//print_r($data['mainLoss']);
		$this->load->view('header',$data);
		$this->load->view('Shashwath/Loss_report');
		$this->load->view('footer_home');
	}
	
	function lossDetail($start = 0) {
		$data['whichTab'] = 'shashwath';

		if(isset($_POST['searchDate'])){
			//$total = $_POST['total'];
			if($_POST['searchDate']!=""){
				$date = @$_POST['searchDate'];
			}else{
				$date = date('d-m-Y');
			}
			$ssId = @$_POST['ssVal'];
			$soId = @$_POST['soVal'];
			//$_SESSION['total']	= $total;	
			$_SESSION['searchDate']	= $date;	
			$_SESSION['ssVal']	= $ssId;
		}
		//$data['total']  = $_SESSION['total'];
		$date = $_SESSION['searchDate'];
		$ssId = $_SESSION['ssVal'];
		$soId = isset($_SESSION['soVal']);

		$this->load->library('pagination');
		//bank 															
		//$data['bank'] = $this->obj_receipt->get_banks();					    //laz..
				//bank 															
		// $data['bank'] = $this->obj_receipt->get_banks("false");					 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks("true");				//laz new ..

		$todayDate=date('d-m-Y');
		$condition = (" IS_TERMINAL = 1");														
		// $data['bank'] = $this->obj_receipt->get_banks($condition);							 //laz new..
		// $data['terminal'] = $this->obj_receipt->get_banks($condition);				//laz new ..
		$data['bank'] = $this->obj_receipt->getAllbanks();
		$data['terminal'] = $this->obj_receipt->getCardbanks($condition);
		if(@$_POST['memberId']){
			$data['memberId'] = @$_SESSION['memberId'] = $data1 = @$_POST['memberId'];
			$data['afterDelete'] = "";
		} else if(@$_SESSION['memberId']) {
			$data['memberId'] = $data['afterDelete'] = $data1 = @$_SESSION['memberId'];
		}
		//$_SESSION['id'] = $data1;
		$data['members'] = $this->obj_shashwath->member_details($data1);
		$data['mandaliMembers'] = $this->obj_shashwath->mandali_member_details($data1); 
		$data['lossDetail'] = $this->obj_shashwath->getDetailedLoss($date,$ssId,10,$start,$soId,$todayDate);
		$lossPaid = $data['lossPaid'] = $this->obj_shashwath->getLossPaid($ssId);
		$data['lossHistory'] = $this->obj_shashwath->loss_pay_details($ssId);
		$config['base_url'] = $data['base_url'] = base_url().'Shashwath/lossDetail';
		$config['total_rows']= $this->obj_shashwath->getDetailedLoss_Rows($date,$ssId);
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);
		$this->load->view('Shashwath/LossDetail');
		$this->load->view('footer_home');
	}

	
	//Settings Part
	function add_period_details(){
		$periodName = $this->input->post('pname');
		$period = $this->input->post('period');
		$periodStatus = $this->input->post('pstatus');
		$data = array( 
			'PERIOD_NAME' => $periodName,
			'PERIOD' => $period,
			'P_STATUS' => $periodStatus
		);
		$this->obj_shashwath->addPeriodDetails($data);
		redirect('admin_settings/Admin_setting/period_setting');
	}

	
	//Settings Part
	function update_period_details(){
		$shashwathPeriodId = $this->input->post('sPid');
		$shashwathPeriodName = $this->input->post('periodN');
		$shashwathPeriod = $this->input->post('period');
		$shashwathPeriodStatus = $this->input->post('pStatus');
		$data = array(
			'SP_ID' => $shashwathPeriodId,
			'PERIOD_NAME' => $shashwathPeriodName,
			'PERIOD' => $shashwathPeriod,
			'P_STATUS' => $shashwathPeriodStatus
		);
		$this->obj_shashwath->updatePeriodDetails($data,$shashwathPeriodId);
		redirect('admin_settings/Admin_setting/period_setting');
	}
	
	//festival code start
	function add_festival_details(){
		$festivalName = $this->input->post('festivalN');
		$code = $this->input->post('tcode');
		$masa = $this->input->post('sfsMasa');
		$bomcode = $this->input->post('sfsBasedOnMoon');
		$thithiName = $this->input->post('sfsThithi');

		$data = array( 
			'SFS_NAME' => $festivalName,
			'SFS_THITHI_CODE' => $code,
			'SFS_MASA' => $masa,
			'SFS_MOON' => $bomcode,
			'SFS_THITHI' => $thithiName
		);
		$this->obj_shashwath->addFestivalDetails($data);
		redirect('admin_settings/Admin_setting/festival_setting');
	}

	function update_festival_details(){
		$SFS_ID = $this->input->post('SFS_ID');
		$SFS_NAME = $this->input->post('festivalN');
		$SFS_THITHI_CODE = $this->input->post('tcode');
		$masa = $this->input->post('sfsMasa');
		$bomcode = $this->input->post('sfsBasedOnMoon');
		$thithiName = $this->input->post('sfsThithi');
		
		$data = array(
			'SFS_ID' => $SFS_ID,
			'SFS_NAME' => $SFS_NAME,
			'SFS_THITHI_CODE' => $SFS_THITHI_CODE,
			'SFS_MASA' => $masa,
			'SFS_MOON' => $bomcode,
			'SFS_THITHI' => $thithiName
		);
		$this->obj_shashwath->updateFestivalDetails($data,$SFS_ID);
		redirect('admin_settings/Admin_setting/festival_setting');
	}
	//festival code end

	function editCalendar(){
		if(isset($_POST)){
			$data['calId'] = $this->input->post('calId');
			$data['calStartDate'] = $this->input->post('calstDate');
			$data['calEndDate'] = $this->input->post('calEndDate');
			$data['calRoi'] = $this->input->post('calRoi');
			//print_r($_POST);
		}
		$this->load->view('header',$data);
		$this->load->view('admin_settings/edit_calendar');
		$this->load->view('footer_home');	
	}
	
	function update_Calendar_details() {
		$calId = $this->input->post('calendarId');
		$calStartDate = $this->input->post('calendarStartDate');
		$calEndDate = $this->input->post('calendarEndDate');
		$calRoi = $this->input->post('rateOfInterest');
		//print_r($_POST);
		$data = array(
			'CAL_START_DATE' => $calStartDate ,
			'CAL_END_DATE' => $calEndDate,
			'CAL_ROI' => $calRoi
		);
		$this->obj_shashwath->updateCalendarDetails($data,$calId);
		redirect('admin_settings/Admin_setting/calendar_display');
	}
	
	function updateMember() {
		$id = $this->input->post('id');
		$data1 = array (		
			'SM_NAME' => strtoupper($this->input->post('name')),
			'SM_PHONE' => $this->input->post('number'),
			'SM_PHONE2' => $this->input->post('number2'),
			'SM_RASHI' => $this->input->post('rashi'),
			'SM_NAKSHATRA' => $this->input->post('nakshatra'),
			'SM_GOTRA' => $this->input->post('gotra'),
			'SM_ADDR1' => strtoupper($this->input->post('addrline1')),
			'SM_ADDR2' => strtoupper($this->input->post('addrline2')),
			'SM_CITY' => strtoupper($this->input->post('smcity')),
			'SM_STATE' => strtoupper($this->input->post('smstate')),
			'SM_COUNTRY' => strtoupper($this->input->post('smcountry')),
			'SM_PIN' => $this->input->post('smpin'),
			'REMARKS' => $this->input->post('smremarks') 
		);
		$addrline1 =strtoupper($this->input->post('addrline1'));
		$addrline2 = strtoupper($this->input->post('addrline2'));
		$smcity = strtoupper($this->input->post('smcity'));
		$smstate = strtoupper($this->input->post('smstate'));
		$smcountry = strtoupper($this->input->post('smcountry'));
		$smpin = strtoupper($this->input->post('smpin'));	

		$sm_address = (($addrline1 != "")?$addrline1.", ":"").(($addrline2 != "")?$addrline2.", ":"").(($smcity != "")?$smcity." ":"").(($smstate != "")?$smstate." ":"").(($smcountry != "")?$smcountry." - ":"").(($smpin != "")?$smpin:"");
		$adrs = str_replace("'","\'",$sm_address);  
		//lathesh code start
		$receiptLine1 = $this->input->post('receiptLine1');
		//lathesh code end
		
		$this->db->where('SM_ID',$id);
		$this->db->update('shashwath_members',$data1);

		//abhiPra code 22-04-21
		$sql="UPDATE deity_receipt a JOIN shashwath_seva b ON a.SS_ID = b.SS_ID JOIN shashwath_members c ON b.SM_ID =c.SM_ID
		SET  a.RECEIPT_NAME = c.SM_NAME, a.RECEIPT_PHONE = c.SM_PHONE, a.RECEIPT_RASHI = c.SM_RASHI, a.RECEIPT_NAKSHATRA = c.SM_NAKSHATRA, a.RECEIPT_ADDRESS = '$adrs'  where c.SM_ID = '$id'";
		$this->db->query($sql);
		//abhiPra code 22-04-21

		if(isset($_SESSION['Authorise'])) {
			if($_SESSION['Authorise'] == 'Auth_Right') {
				$dataSSID = array('SM_ID' => $id,
					'SS_VERIFICATION' => 0);

				$this->db->select('SS_ID');
				$this->db->from('SHASHWATH_SEVA');
				$this->db->where($dataSSID);
				
				$query = $this->db->get();
				if ($query->num_rows() > 0) {
					foreach($query->result() as $ShashSeva) {
						$data = array (		
							'SS_VERIFICATION' => 1,
							'SS_VERIFICATION_BY_ID' => $_SESSION['userId'],
							'SS_VERIFICATION_DATE_TIME' => date('d-m-Y H:i:s A'),
							'SS_VERIFICATION_DATE' => date('d-m-Y')
						);

						$this->db->where('SS_ID',$ShashSeva->SS_ID);
						$this->db->update('shashwath_seva',$data);	
					}
				}

				// $dataReceiptId = array('RECEIPT_CATEGORY_ID' => 7,
				// 	'AUTHORISED_STATUS' => 'No',
				// 	'SS_VERIFICATION' => 1);

				// $this->db->select('RECEIPT_ID');
				// $this->db->from('DEITY_RECEIPT');
				// $this->db->join('SHASHWATH_SEVA','DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID');
				// $this->db->where($dataReceiptId);
				// $query1 = $this->db->get();

				// if ($query1->num_rows() > 0) {
				// 	foreach($query1->result() as $Receipts) {
				// 		//lathesh code
				// 		if($receiptLine1 != "") {
				// 		 		//lathesh code end
				// 			$data = array (		
				// 				'AUTHORISED_STATUS'=> 'Yes',
				// 				'AUTHORISED_BY' => $_SESSION['userId'],
				// 				'AUTHORISED_BY_NAME' => $_SESSION['userFullName'],
				// 				'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'),
				// 				'AUTHORISED_DATE' => date('d-m-Y'),
				// 				'EOD_CONFIRMED_BY_ID' => $_SESSION['userId'],
				// 				'EOD_CONFIRMED_BY_NAME' => $_SESSION['userFullName'],
				// 				'EOD_CONFIRMED_DATE_TIME' => date('d-m-Y H:i:s A'),
				// 				'EOD_CONFIRMED_DATE' => date('d-m-Y')
				// 			);
				// 			//lathesh code start
				// 		}else{
				// 			$data = array (		
				// 				'AUTHORISED_STATUS'=> 'Yes');
				// 		}
						
				// 		//lathesh code end
				// 		$this->db->where('RECEIPT_ID',$Receipts->RECEIPT_ID);
				// 		$this->db->update('DEITY_RECEIPT',$data);	
				// 	}
				// }
			}
		}
	} 

	function updateShashwathSevaDetails() {
		//Every -> Number of Sevas Count Calculation

		$calType = @$_POST['calType'];
		$weekcode = @$_POST['everyweekMonth'];
		$verificationStatus = @$_POST['verificationStatus'];

		if($calType == "Every"){
			$maxYear = $this->obj_shashwath->getfinyear();
			$startDate = new DateTime();
			$endDate = new DateTime($maxYear.'-03-31');
			$countNOS = 0;
			if (count(explode("_",$weekcode))==1){
				while ($startDate <= $endDate) {
				    if ($startDate->format('l') == $weekcode) {
				        $countNOS++;
				    }
				    $startDate->modify('+1 day');
				}
			}else if (count(explode("_",$weekcode))==2){
				while ($startDate <= $endDate) {
				    $stringDate = $startDate->format('Y-m-d H:i:s');
				    $Timestamp = strtotime($stringDate);
					$weekFirst = date("d-m-Y", strtotime(explode("_",$weekcode)[0]."".explode("_",$weekcode)[1]." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
					if(date("d-m-Y",$Timestamp)==$weekFirst){
						$countNOS++;
					}
				    $startDate->modify('+1 day');
				}
			} else if (count(explode("_",$weekcode))==3){
				$countNOS = 1;
			}
		} else {
			$countNOS = 1;
		}
		//Calculation End
		
		if(isset($_POST['rId'])) {
			$data = array (
				'DEITY_ID' => $this->input->post('deityId'),
				'SEVA_ID' => $this->input->post('sevaId'),
				'SEVA_QTY' => $this->input->post('sevaQty'),
				'SEVA_TYPE' => $this->input->post('sevaType'),
				'CAL_TYPE' => $this->input->post('calType'),
				'THITHI_CODE' => $this->input->post('thithiCode'),
				'ENG_DATE' => $this->input->post('engDate'),
				'EVERY_WEEK_MONTH' => $this->input->post('everyweekMonth'),
				'SP_ID' => $this->input->post('spId'),
				'MASA' => $this->input->post('masa'),
				'BASED_ON_MOON' => $this->input->post('bom'),
				'THITHI_NAME' => $this->input->post('thithi'), 
				'SEVA_NOTES' => $this->input->post('purpose'),
				'SS_ENTERED_BY_ID'=>$_SESSION['userId'],
				'SS_ENTERED_DATE_TIME'=>date('d-m-Y H:i:s A'),
				'SS_ENTERED_DATE' =>date('d-m-Y'),
				'NO_OF_SEVAS' => $countNOS,
				'SEVA_GEN_COUNTER' => $countNOS
			);

			$this->db->where('SS_ID',$this->input->post('ssId'));
			$this->db->update('shashwath_seva',$data);

			if($verificationStatus == 0){
				$data1 = array (
					'SS_RECEIPT_NO' => $this->input->post('ss_receipt_no'),
					'SS_RECEIPT_DATE' => $this->input->post('ss_receipt_date')
				);
				$this->db->where('SS_ID',$this->input->post('ssId'));
				$this->db->update('shashwath_seva',$data1);
			}

			// =========================================================

			$data = array (	
				'RECEIPT_PRICE' => $this->input->post('corpus')
			);
			$this->db->where('RECEIPT_ID',$this->input->post('rId'));
			$this->db->update('deity_receipt',$data);

			if($verificationStatus == 0){
				$data2 = array (		
					'RECEIPT_DATE' => $this->input->post('ss_receipt_date'),
					'SS_RECEIPT_NO_REF' => $this->input->post('ss_receipt_no')
				);
				$this->db->where('RECEIPT_ID',$this->input->post('rId'));
				$this->db->update('deity_receipt',$data2);
			}
			// =========================================================

			$data = $this->input->post('smId');

			echo "success|".json_encode($this->obj_shashwath->member_details($data));
		}
	}

	// public function allSevasMasaMonth($start=0) {
	// 	$data['whichTab'] = 'shashwath';
	// 	$this->session->unset_userdata('secTab');
	// 	$member_actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	// 	$_SESSION['member_actual_link'] = $member_actual_link;

	// 	$date = date('d-m-Y');
	// 	if(isset($_POST['masa'])) {
	// 		$_SESSION['masa'] = $data['masa'] = $masa = $_POST['masa'];
	// 	} else if(isset($_SESSION['masa'])) {
	// 		$data['masa'] = $masa = $_SESSION['masa'];
	// 	}

	// 	if(isset($_POST['month'])) {
	// 		$_SESSION['month'] = $data['month'] = $month = $_POST['month'];
	// 	} else if(isset($_SESSION['month'])) {
	// 		$data['month'] = $month = $_SESSION['month'];
	// 	}

	// 	//$data['month_name'] = $month_name = date("F", mktime(0, 0, 0, substr($month,1), 10));

	// 	if($masa != ''){ 
	// 		$filter = "shashwath_seva.MASA LIKE '$masa%'";
	// 	} else {	
	// 		$filter = "shashwath_seva.ENG_DATE LIKE '%$month'";
	// 	}

	// 	$nameCondition='';
	// 	$data['masa1'] =  $this->obj_shashwath->getMasa();
	// 	$sql ="SELECT CAL_TYPE,ENG_DATE FROM `shashwath_seva` WHERE CAL_TYPE='Gregorian' AND ENG_DATE LIKE '%$month' GROUP BY ENG_DATE";
	// 	//$sql1 ="SELECT THITHI_CODE FROM `shashwath_seva` WHERE MASA LIKE '$masa' GROUP BY THITHI_CODE";
	// 	$sql1 ="SELECT distinct THITHI_CODE ,LEFT(THITHI_CODE,5) as leftRno FROM `shashwath_seva` WHERE MASA LIKE '$masa' ORDER BY leftRno DESC,THITHI_CODE asc";
	// 	$query= $this->db->query($sql);
	// 	$query1= $this->db->query($sql1);
	// 	$data['engDates'] =  $query->result();
	// 	$data['masaThithiCode'] =  $query1->result();

	// 	$data['thithi_shudda'] =  $this->obj_shashwath->getThithi(1);
	// 	$data['thithi_bahula'] =  $this->obj_shashwath->getThithi(2);
	// 	$data['moon'] =  $this->obj_shashwath->getBasedOnMoon();
	// 	$this->load->library('pagination');
	// 	$data['masaMonthDetail'] = json_encode($this->obj_shashwath->get_masa_month(10,$start,$filter,$masa,$nameCondition));
	// 	$data['searchMasaMonthDetail'] = $this->obj_shashwath->get_masa_month_search($filter,$masa);
	// 	$config['base_url'] = $base_url = base_url().'Shashwath/allSevasMasaMonth';
	// 	$data['base_url'] = 'Shashwath/allSevasMasaMonth';
	// 	$config['total_rows'] = $data['total_rows']=  $this->obj_shashwath->get_masa_month_count($filter,$masa,$nameCondition);
	// 	$config['per_page'] = 10;
	// 	$config['prev_link'] = '&lt;&lt;';
	// 	$config['next_link'] = '&gt;&gt;';
	// 	$config['first_tag_open'] = '<li>';
	// 	$config['first_tag_close'] = '</li>';
	// 	$config['last_tag_open'] = '<li>';
	// 	$config['last_tag_close'] = '</li>';
	// 	$config['next_tag_open'] = '<li>';
	// 	$config['next_tag_close'] = '</li>';
	// 	$config['prev_tag_open'] = '<li>';
	// 	$config['prev_tag_close'] = '</li>';
	// 	$config['cur_tag_open'] = '<li class="active"><a>';
	// 	$config['cur_tag_close'] = '</a></li>';
	// 	$config['num_tag_open'] = '<li>';
	// 	$config['num_tag_close'] = '</li>';
	// 	$config['last_link'] = 'Last';
	// 	$config['first_link'] = 'First';
	// 	$this->pagination->initialize($config);
	// 	$data['pages'] = $this->pagination->create_links();
	// 	$this->load->view('header',$data);           
	// 	$this->load->view('Shashwath/shashwathSevaMonthMasaWise');
	// 	$this->load->view('footer_home');
	// }

	// public function allSevasMasaMonthFilter($start=0) {
	// 	$data['whichTab'] = 'shashwath';
	// 	$this->session->unset_userdata('secTab');
	// 	$date = date('d-m-Y');
	// 	if(isset($_POST['masa'])) {
	// 		$_SESSION['masa'] = $data['masa'] = $masa = $_POST['masa'];
	// 	} else if(isset($_SESSION['masa'])) {
	// 		$data['masa'] = $masa = $_SESSION['masa'];
	// 	}

	// 	if(isset($_POST['month'])) {
	// 		$_SESSION['month'] = $data['month'] = $month = $_POST['month'];
	// 	} else if(isset($_SESSION['month'])) {
	// 		$data['month'] = $month = $_SESSION['month'];
	// 	}

	// 	if (isset($_POST['selDate'])) {
	// 		$data['selDate'] = $selDate = $_SESSION['selDate'] = $_POST['selDate'];
	// 	} else if(isset($_SESSION['selDate'])) {
	// 		$data['selDate'] = $selDate = $_SESSION['selDate'];
	// 	} else {
	// 		$selDate = '';
	// 	}
		
	// 	if(isset($_POST['thithiMasaCode'])) {
	// 		$_SESSION['thithiMasaCode'] = $data['thithiMasaCode'] = $thithiMasaCode = $_POST['thithiMasaCode'];
	// 	} else if(isset($_SESSION['thithiMasaCode'])) {
	// 		$data['thithiMasaCode'] = $thithiMasaCode = $_SESSION['thithiMasaCode'];
	// 	}else{
	// 		$data['thithiMasaCode'] = $thithiMasaCode = "";
	// 		$thithiMasaCode = $_SESSION['thithiMasaCode'];
	// 	}

	// 	//$data['month_name'] = $month_name = date("F", mktime(0, 0, 0, substr($month,1), 10));

	// 	if($masa != ''){ 
	// 		$filter = " shashwath_seva.MASA LIKE '$masa%'";
	// 		if($thithiMasaCode != ""){
	// 			$filter .= "AND shashwath_seva.THITHI_CODE = '$thithiMasaCode'";
	// 		}
	// 	} else {	
	// 		$filter = "shashwath_seva.ENG_DATE LIKE '%$month'";
	// 		if($selDate!=""){
	// 			$filter.="AND shashwath_seva.ENG_DATE='$selDate'";
	// 		}
	// 	}

	// 	$condsrch = "";
		
	// 	if(isset($_POST['searchName'])) {
	// 		unset($_SESSION['searchName']);
	// 		$data['searchName'] = $_SESSION['searchName'] = $_POST['searchName'];
	// 		$condsrch = "AND SM_NAME LIKE '%".str_replace("'","''",$_SESSION['searchName'])."%'";
	// 	} 
	// 	if(isset($_POST['callFromGroup'])) {
	// 		$data['callFrom'] = "nameSearch";
	// 	} else {
	// 		$data['callFrom'] = "";
	// 	}

	// 	if(isset($_POST['selectedNames'])) {
	// 		$_SESSION['selectedNames'] = $data['selectedNames'] = $selectedNames = $_POST['selectedNames'];
	// 	} else if(isset($_SESSION['selectedNames'])) {
	// 		$data['selectedNames'] = $selectedNames = $_SESSION['selectedNames'];
	// 	}
	// 	if($selectedNames!=""){
	// 		$selectedMemNames = json_decode($selectedNames);
	// 		$nameCondition = "AND(SM_NAME LIKE '%".str_replace("'","''",trim($selectedMemNames[0]))."%'";
	// 		for($i = 1; $i < count($selectedMemNames); ++$i) {
	// 			$nameCondition.= " OR SM_NAME LIKE '%".str_replace("'","''",trim($selectedMemNames[$i]))."%' ";	
	// 		}
	// 		$nameCondition.= ")";
	// 	}else{
	// 		$nameCondition="";
	// 	}

	// 	$data['masa1'] =  $this->obj_shashwath->getMasa();
	// 	$sql ="SELECT CAL_TYPE,ENG_DATE FROM `shashwath_seva` WHERE CAL_TYPE='Gregorian' AND ENG_DATE LIKE '%$month' GROUP BY ENG_DATE";
	// 	$query= $this->db->query($sql);
	// 	$data['engDates'] =  $query->result();

	// 	//$sql1 ="SELECT THITHI_CODE FROM `shashwath_seva` WHERE MASA LIKE '$masa' GROUP BY THITHI_CODE";
	// 	$sql1 ="SELECT distinct THITHI_CODE ,LEFT(THITHI_CODE,5) as leftRno FROM `shashwath_seva` WHERE MASA LIKE '$masa' ORDER BY leftRno DESC,THITHI_CODE asc";
	// 	$query1= $this->db->query($sql1);
	// 	$data['masaThithiCode'] =  $query1->result();


	// 	$data['thithi_shudda'] =  $this->obj_shashwath->getThithi(1);
	// 	$data['thithi_bahula'] =  $this->obj_shashwath->getThithi(2);
	// 	$data['moon'] =  $this->obj_shashwath->getBasedOnMoon();
	// 	$this->load->library('pagination');
	// 	$data['masaMonthDetail'] = json_encode($this->obj_shashwath->get_masa_month(10,$start,$filter,$masa,$nameCondition));
	// 	$data['searchMasaMonthDetail'] = $this->obj_shashwath->get_masa_month_search($filter,$masa,$condsrch);
	// 	$config['base_url'] = base_url().'Shashwath/allSevasMasaMonthFilter';
	// 	$data['base_url'] = 'Shashwath/allSevasMasaMonthFilter';
	// 	$config['total_rows'] = $data['total_rows']=  $this->obj_shashwath->get_masa_month_count($filter,$masa,$nameCondition);
	// 	$config['per_page'] = 10;
	// 	$config['prev_link'] = '&lt;&lt;';
	// 	$config['next_link'] = '&gt;&gt;';
	// 	$config['first_tag_open'] = '<li>';
	// 	$config['first_tag_close'] = '</li>';
	// 	$config['last_tag_open'] = '<li>';
	// 	$config['last_tag_close'] = '</li>';
	// 	$config['next_tag_open'] = '<li>';
	// 	$config['next_tag_close'] = '</li>';
	// 	$config['prev_tag_open'] = '<li>';
	// 	$config['prev_tag_close'] = '</li>';
	// 	$config['cur_tag_open'] = '<li class="active"><a>';
	// 	$config['cur_tag_close'] = '</a></li>';
	// 	$config['num_tag_open'] = '<li>';
	// 	$config['num_tag_close'] = '</li>';
	// 	$config['last_link'] = 'Last';
	// 	$config['first_link'] = 'First';
	// 	$this->pagination->initialize($config);
	// 	$data['pages'] = $this->pagination->create_links();
	// 	$this->load->view('header',$data);           
	// 	$this->load->view('Shashwath/shashwathSevaMonthMasaWise');
	// 	$this->load->view('footer_home');
	// }
	public function allSevasMasaMonth($start=0) {
		$data['whichTab'] = 'shashwath';
		$this->session->unset_userdata('secTab');
		$member_actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['member_actual_link'] = $member_actual_link;

		$date = date('d-m-Y');
		if(isset($_POST['masa'])) {
			$_SESSION['masa'] = $data['masa'] = $masa = $_POST['masa'];
		} else if(isset($_SESSION['masa'])) {
			$data['masa'] = $masa = $_SESSION['masa'];
		}

		if(isset($_POST['month'])) {
			$_SESSION['month'] = $data['month'] = $month = $_POST['month'];
		} else if(isset($_SESSION['month'])) {
			$data['month'] = $month = $_SESSION['month'];
		}

		if(isset($_POST['every'])) {
			$_SESSION['every'] = $data['every'] = $every = $_POST['every'];
		} else if(isset($_SESSION['every'])) {
			$data['every'] = $every = $_SESSION['every'];
		}
		
		if($masa != ''){ 
			$filter = "shashwath_seva.MASA LIKE '$masa%'";
		} else if ($month != '') {
			$filter = "shashwath_seva.ENG_DATE LIKE '%$month%'";
		}
		if($every !=''){
			if($every =='Year'){
				$filter = "shashwath_seva.EVERY_WEEK_MONTH LIKE '%_First_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Second_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Third_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Fourth_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Last_%'";
			}
			if($every =='Month'){
				$filter = "shashwath_seva.EVERY_WEEK_MONTH LIKE 'First_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Second_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Third_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Fourth_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Last_%'";
			}
			if($every =='Week'){
				$filter = "shashwath_seva.EVERY_WEEK_MONTH ='Monday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Tuesday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Wednesday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Thursday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Friday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Saturday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Sunday' ";
			}
		}
		$nameCondition='';
		$data['masa1'] =  $this->obj_shashwath->getMasa();
		$sql ="SELECT CAL_TYPE,ENG_DATE FROM `shashwath_seva` WHERE CAL_TYPE='Gregorian' AND ENG_DATE LIKE '%$month' GROUP BY ENG_DATE";
		$sql1 ="SELECT distinct THITHI_CODE ,LEFT(THITHI_CODE,5) as leftRno FROM `shashwath_seva` WHERE MASA LIKE '$masa' ORDER BY leftRno DESC,THITHI_CODE asc";
		$sql2 ="SELECT CAL_TYPE,EVERY_WEEK_MONTH FROM `shashwath_seva` WHERE CAL_TYPE='EVERY' AND $filter GROUP BY EVERY_WEEK_MONTH";
		$query= $this->db->query($sql);
		$query1= $this->db->query($sql1);
		$query2= $this->db->query($sql2);
		$data['engDates'] =  $query->result();
		$data['masaThithiCode'] =  $query1->result();
		$data['everyCode'] =  $query2->result();

		$data['thithi_shudda'] =  $this->obj_shashwath->getThithi(1);
		$data['thithi_bahula'] =  $this->obj_shashwath->getThithi(2);
		$data['moon'] =  $this->obj_shashwath->getBasedOnMoon();
		$this->load->library('pagination');
		$data['masaMonthDetail'] = json_encode($this->obj_shashwath->get_masa_month(10,$start,$filter,$masa,$nameCondition));
		$data['searchMasaMonthDetail'] = $this->obj_shashwath->get_masa_month_search($filter,$masa);
		$config['base_url'] = $base_url = base_url().'Shashwath/allSevasMasaMonth';
		$data['base_url'] = 'Shashwath/allSevasMasaMonth';
		$config['total_rows'] = $data['total_rows']=  $this->obj_shashwath->get_masa_month_count($filter,$masa,$nameCondition);
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);           
		$this->load->view('Shashwath/shashwathSevaMonthMasaWise');
		$this->load->view('footer_home');
	}
	
	public function allSevasMasaMonthFilter($start=0) {
		$data['whichTab'] = 'shashwath';
		$this->session->unset_userdata('secTab');
		$date = date('d-m-Y');
		if(isset($_POST['masa'])) {
			$_SESSION['masa'] = $data['masa'] = $masa = $_POST['masa'];
		} else if(isset($_SESSION['masa'])) {
			$data['masa'] = $masa = $_SESSION['masa'];
		}

		if(isset($_POST['month'])) {
			$_SESSION['month'] = $data['month'] = $month = $_POST['month'];
		} else if(isset($_SESSION['month'])) {
			$data['month'] = $month = $_SESSION['month'];
		}

		if(isset($_POST['every'])) {
			$_SESSION['every'] = $data['every'] = $every = $_POST['every'];
		} else if(isset($_SESSION['every'])) {
			$data['every'] = $every = $_SESSION['every'];
		}

		if (isset($_POST['selDate'])) {
			$data['selDate'] = $selDate = $_SESSION['selDate'] = $_POST['selDate'];
		} else if(isset($_SESSION['selDate'])) {
			$data['selDate'] = $selDate = $_SESSION['selDate'];
		} else {
			$selDate = '';
		}

		if (isset($_POST['selEvery'])) {
			$data['selEvery'] = $selEvery = $_SESSION['selEvery'] = $_POST['selEvery'];
		} else if(isset($_SESSION['selEvery'])) {
			$data['selEvery'] = $selEvery = $_SESSION['selEvery'];
		} else {
			$selEvery = '';
		}
		
		if(isset($_POST['thithiMasaCode'])) {
			$_SESSION['thithiMasaCode'] = $data['thithiMasaCode'] = $thithiMasaCode = $_POST['thithiMasaCode'];
		} else if(isset($_SESSION['thithiMasaCode'])) {
			$data['thithiMasaCode'] = $thithiMasaCode = $_SESSION['thithiMasaCode'];
		}else{
			$data['thithiMasaCode'] = $thithiMasaCode = "";
			$thithiMasaCode = $_SESSION['thithiMasaCode'];
		}

		//$data['month_name'] = $month_name = date("F", mktime(0, 0, 0, substr($month,1), 10));

		if($masa != ''){ 
			$filter = " shashwath_seva.MASA LIKE '$masa%'";
			if($thithiMasaCode != ""){
				$filter .= "AND shashwath_seva.THITHI_CODE = '$thithiMasaCode'";
			}
		} else if($month !=''){	
			$filter = "shashwath_seva.ENG_DATE LIKE '%$month'";
			if($selDate!=""){
				$filter.="AND shashwath_seva.ENG_DATE='$selDate'";
			}
		}
		if($every =='Year'){
			$filter = "(shashwath_seva.EVERY_WEEK_MONTH LIKE '%_First_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Second_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Third_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Fourth_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Last_%')";
			if($selEvery !=""){	
				$filter .= " AND shashwath_seva.EVERY_WEEK_MONTH='$selEvery'";
			}
		}
		if($every =='Month'){
			$filter = "(shashwath_seva.EVERY_WEEK_MONTH LIKE 'First_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Second_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Third_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Fourth_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Last_%')";
			if($selEvery !=""){
				$filter .= " AND shashwath_seva.EVERY_WEEK_MONTH='$selEvery'";
			}	
		}
		if($every =='Week'){
			$filter = "(shashwath_seva.EVERY_WEEK_MONTH ='Monday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Tuesday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Wednesday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Thursday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Friday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Saturday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Sunday')";
			if($selEvery != ""){
				$filter .= " AND shashwath_seva.EVERY_WEEK_MONTH='$selEvery' ";
			}
		}
		$condsrch = "";
		
		if(isset($_POST['searchName'])) {
			unset($_SESSION['searchName']);
			$data['searchName'] = $_SESSION['searchName'] = $_POST['searchName'];
			$condsrch = "AND SM_NAME LIKE '%".str_replace("'","''",$_SESSION['searchName'])."%'";
		} 
		if(isset($_POST['callFromGroup'])) {
			$data['callFrom'] = "nameSearch";
		} else {
			$data['callFrom'] = "";
		}

		if(isset($_POST['selectedNames'])) {
			$_SESSION['selectedNames'] = $data['selectedNames'] = $selectedNames = $_POST['selectedNames'];
		} else if(isset($_SESSION['selectedNames'])) {
			$data['selectedNames'] = $selectedNames = $_SESSION['selectedNames'];
		}
		if($selectedNames!=""){
			$selectedMemNames = json_decode($selectedNames);
			$nameCondition = "AND(SM_NAME LIKE '%".str_replace("'","''",trim($selectedMemNames[0]))."%'";
			for($i = 1; $i < count($selectedMemNames); ++$i) {
				$nameCondition.= " OR SM_NAME LIKE '%".str_replace("'","''",trim($selectedMemNames[$i]))."%' ";	
			}
			$nameCondition.= ")";
		}else{
			$nameCondition="";
		}
		if($every != ''){ 
			if($every =='Year'){
				$filter1 = "shashwath_seva.EVERY_WEEK_MONTH LIKE '%_First_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Second_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Third_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Fourth_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Last_%'";
			}
			if($every =='Month'){
				$filter1 = "shashwath_seva.EVERY_WEEK_MONTH LIKE 'First_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Second_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Third_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Fourth_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Last_%'";
			}
			if($every =='Week'){
				$filter1 = "shashwath_seva.EVERY_WEEK_MONTH ='Monday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Tuesday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Wednesday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Thursday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Friday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Saturday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Sunday' ";
			}
		}

		$data['masa1'] =  $this->obj_shashwath->getMasa();
		$sql ="SELECT CAL_TYPE,ENG_DATE FROM `shashwath_seva` WHERE CAL_TYPE='Gregorian' AND ENG_DATE LIKE '%$month' GROUP BY ENG_DATE";
		$query= $this->db->query($sql);
		$data['engDates'] =  $query->result();

		//$sql1 ="SELECT THITHI_CODE FROM `shashwath_seva` WHERE MASA LIKE '$masa' GROUP BY THITHI_CODE";
		$sql1 ="SELECT distinct THITHI_CODE ,LEFT(THITHI_CODE,5) as leftRno FROM `shashwath_seva` WHERE MASA LIKE '$masa' ORDER BY leftRno DESC,THITHI_CODE asc";
		$query1= $this->db->query($sql1);
		$data['masaThithiCode'] =  $query1->result();

		if($every != ''){ 
			$sql2 ="SELECT CAL_TYPE,EVERY_WEEK_MONTH FROM `shashwath_seva` WHERE CAL_TYPE='EVERY' AND $filter1 GROUP BY EVERY_WEEK_MONTH";
			$query2= $this->db->query($sql2);
			$data['everyCode'] =  $query2->result();
		}

		$data['thithi_shudda'] =  $this->obj_shashwath->getThithi(1);
		$data['thithi_bahula'] =  $this->obj_shashwath->getThithi(2);
		$data['moon'] =  $this->obj_shashwath->getBasedOnMoon();
		$this->load->library('pagination');
		$data['masaMonthDetail'] = json_encode($this->obj_shashwath->get_masa_month(10,$start,$filter,$masa,$nameCondition));
		$data['searchMasaMonthDetail'] = $this->obj_shashwath->get_masa_month_search($filter,$masa,$condsrch);
		$config['base_url'] = base_url().'Shashwath/allSevasMasaMonthFilter';
		$data['base_url'] = 'Shashwath/allSevasMasaMonthFilter';
		$config['total_rows'] = $data['total_rows']=  $this->obj_shashwath->get_masa_month_count($filter,$masa,$nameCondition);
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);           
		$this->load->view('Shashwath/shashwathSevaMonthMasaWise');
		$this->load->view('footer_home');
	}

	// public function masaMonthFilterSearch() {
	// 	$date = date('d-m-Y');
	// 	$data['masa'] = $masa = @$_POST['masa'];
	// 	$data['month'] = $month = @$_POST['month'];
	// 	$data['thithiMasaCode'] = $thithiMasaCode = @$_POST['thithiMasaCode'];
	// 	$data['selDate'] = $selDate = @$_POST['selDate'];

	// 	//$month_name = date("F", mktime(0, 0, 0, substr($month,1), 10));

	// 	if($masa != ''){ 
	// 		$filter = "shashwath_seva.MASA LIKE '$masa%'";
	// 		if($thithiMasaCode != ""){
	// 			$filter .= "AND shashwath_seva.THITHI_CODE = '$thithiMasaCode'";
	// 		}
	// 	} else {	
	// 		$filter = "shashwath_seva.ENG_DATE LIKE '%$month'";
	// 		if($selDate!=""){
	// 			$filter.="AND shashwath_seva.ENG_DATE='$selDate'";
	// 		}
	// 	}

	// 	$data['searchName'] = $_SESSION['searchName'] = @$_POST['searchName'];
	// 	$condsrch = "AND SM_NAME LIKE '%".str_replace("'","''",@$_POST['searchName'])."%'";
		
	// 	echo json_encode($this->obj_shashwath->get_masa_month_search($filter,$masa,$condsrch));
	// }
		public function masaMonthFilterSearch() {
		$date = date('d-m-Y');
		$data['masa'] = $masa = @$_POST['masa'];
		$data['month'] = $month = @$_POST['month'];
		$data['every'] = $every = @$_POST['every'];
		$data['thithiMasaCode'] = $thithiMasaCode = @$_POST['thithiMasaCode'];
		$data['selDate'] = $selDate = @$_POST['selDate'];
		$data['selEvery'] = $selEvery = @$_POST['selEvery'];
		//$month_name = date("F", mktime(0, 0, 0, substr($month,1), 10));

		if($masa != ''){ 
			$filter = "shashwath_seva.MASA LIKE '$masa%'";
			if($thithiMasaCode != ""){
				$filter .= "AND shashwath_seva.THITHI_CODE = '$thithiMasaCode'";
			}
		} else if($month !='') {	
			$filter = "shashwath_seva.ENG_DATE LIKE '%$month'";
			if($selDate!=""){
				$filter.="AND shashwath_seva.ENG_DATE='$selDate'";
			}
		} 
		 if($every !=''){
			if($every =='Year'){
				$filter = "(shashwath_seva.EVERY_WEEK_MONTH LIKE '%_First_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Second_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Third_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Fourth_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE '%_Last_%')";
				if($selEvery != ""){
					$filter .= "AND shashwath_seva.EVERY_WEEK_MONTH = '$selEvery'";
				}
			}
			if($every =='Month'){
				$filter = "(shashwath_seva.EVERY_WEEK_MONTH LIKE 'First_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Second_%' OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Third_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Fourth_%'  OR shashwath_seva.EVERY_WEEK_MONTH LIKE 'Last_%')";
				if($selEvery != ""){
					$filter .= "AND shashwath_seva.EVERY_WEEK_MONTH = '$selEvery'";
				}
			}
			if($every =='Week'){
				$filter = "(shashwath_seva.EVERY_WEEK_MONTH ='Monday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Tuesday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Wednesday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Thursday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Friday'  OR shashwath_seva.EVERY_WEEK_MONTH = 'Saturday' OR shashwath_seva.EVERY_WEEK_MONTH = 'Sunday')";
				if($selEvery != ""){
					$filter .= "AND shashwath_seva.EVERY_WEEK_MONTH = '$selEvery'";
				}
			}
		}

		$data['searchName'] = $_SESSION['searchName'] = @$_POST['searchName'];
		$condsrch = "AND SM_NAME LIKE '%".str_replace("'","''",@$_POST['searchName'])."%'";
		
		echo json_encode($this->obj_shashwath->get_masa_month_search($filter,$masa,$condsrch));
	}
	function deleteShashwathSeva() {
		$deleteSSID = $this->input->post('deleteSSID');
		$deleteReceiptId = $this->input->post('deleteReceiptId');
		$deleteSeavaReason = $this->input->post('deleteSeavaReason');
		$dateTime = date('d-m-Y H:i:s A');
		$userId= $_SESSION['userId'];
		$this->obj_shashwath->deletingShashwathSeva($deleteSSID,$deleteReceiptId,$deleteSeavaReason,$dateTime,$userId);
		redirect('Shashwath/edit_shashwath_member');
	}

	public function isSevaGenarated() {
		$ssId = $this->input->post('ssId');
		$sql="SELECT * FROM `deity_seva_offered` WHERE SS_ID=$ssId";
		$query = $this->db->query($sql);
		echo $query->num_rows();
	}

	public function smRefIssue($start = 0){
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION['actual_link'] = $actual_link;
		$data['whichTab'] = 'shashwath';
		if(isset($_POST['date'])){
			$date = $_POST['date'];
		} else if($start != 0){
			$date = $_SESSION['losspageDate'];
			$this->session->unset_userdata('losspageDate');
		} else {
			$date = date('d-m-Y');
		}

		$data['whichTab'] = 'shashwath';
		unset($_SESSION['name_phone']);
		$name_phone = '';

		$data['smReferenceIssue'] = $smReferenceIssue = $this->obj_shashwath->getSmReferenceIssue();
		$this->load->view('header',$data);
		$this->load->view('Shashwath/smRefIssue');
		$this->load->view('footer_home');
	}

	function updateMemRefDetails(){

		$sql ="(SELECT SM_ID,SM_REF,SM_NAME FROM shashwath_members) as tbl1 join
		(SELECT shashwath_members.SM_ID,shashwath_seva.SS_ID,SM_REF,SS_REF,@myLeft  := SUBSTRING_INDEX(RECEIPT_NO,'M',-1)as rno,SUBSTRING_INDEX(@myLeft ,'/S',1) as smRefID,shashwath_seva.SS_RECEIPT_NO,SS_ENTERED_BY_ID,SS_ENTERED_DATE_TIME,RECEIPT_NO,RECEIPT_ID FROM `shashwath_seva` JOIN shashwath_members on shashwath_members.SM_ID = shashwath_seva.SM_ID JOIN deity_receipt on deity_receipt.SS_ID = shashwath_seva.SS_ID )as tbl2
		on tbl1.SM_ID = tbl2.SM_ID where tbl1.SM_REF != tbl2.smRefID 
		ORDER BY STR_TO_DATE(`tbl2`.`SS_ENTERED_DATE_TIME`, '%d-%m-%Y') ASC";

		$query4 = $this->db->get($sql);
		$refnums = $query4->result();

		if ($query4->num_rows() > 0) {
			foreach($refnums as $ShashAddlSeva) {
				$memberReceiptFormat1 = $ShashAddlSeva->SM_REF.'/S';
				$sql5="SELECT RECEIPT_NO, LEFT(RECEIPT_NO,14) as leftRno,SUBSTRING_INDEX(RECEIPT_NO,'/S',-1) as rightRno FROM deity_receipt where  RECEIPT_ID = $ShashAddlSeva->RECEIPT_ID ";
				$query5 = $this->db->query($sql5);
				$receiptFormat = $query5->first_row(); 

				$RnoFormat = $receiptFormat->leftRno.$memberReceiptFormat1.$receiptFormat->rightRno;

				$data = array (		
					'RECEIPT_NO' => $RnoFormat,
				);

				$this->db->where('RECEIPT_ID',$ShashAddlSeva->RECEIPT_ID);
				$this->db->update('deity_receipt',$data);		
			}
		}
		redirect('Shashwath/smRefIssue');
	}

	public function allSevasMemberFilter($start=0) {
		$data['whichTab'] = 'shashwath';
		$date = date('d-m-Y');

		if(isset($_POST['selectedNames'])) {
			$_SESSION['selectedNames'] = $data['selectedNames'] = $selectedNames = $_POST['selectedNames'];
		} else if(isset($_SESSION['selectedNames'])) {
			$data['selectedNames'] = $selectedNames = $_SESSION['selectedNames'];
		}
		if($selectedNames!=""){
			$selectedMemNames = json_decode($selectedNames);
			$nameCondition = "(SM_NAME LIKE '%".str_replace("'","''",trim($selectedMemNames[0]))."%'";
			for($i = 1; $i < count($selectedMemNames); ++$i) {
				$nameCondition.= " OR SM_NAME LIKE '%".str_replace("'","''",trim($selectedMemNames[$i]))."%' ";	
			}
			$nameCondition.= ")";
		}else{
			$nameCondition="";
		}
		$this->load->library('pagination');
		$data['base_url'] = 'Shashwath/allSevasMemberFilter';
		$data['nameDetails']= $nameDetails  = json_encode($this->obj_shashwath->get_filter_member(10,$start,$nameCondition));
		$config['base_url'] = base_url().'Shashwath/allSevasMemberFilter';
		$config['total_rows'] = $data['total_rows']=  $this->obj_shashwath->get_filter_member_count($nameCondition);
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$this->load->view('header',$data);           
		$this->load->view('Shashwath/shashwathMemberFilter');
		$this->load->view('footer_home');
	}

	public function shashwathAddlMemberMerge() {
		$data['whichTab'] = 'shashwath';
		$data['call'] = $_POST['call'];
		$selectedMembersSearchItems  = $data['selectedMembersSearchItems'] = $_POST['selectedMembersSearchItems'];

		if($selectedMembersSearchItems!=""){
			$selectedItems = $data['selectedItems'] = json_decode($selectedMembersSearchItems);
			$mergeCondition = "AND((shashwath_members.SM_ID = $selectedItems[0])";
			for($i = 1; $i < count($selectedItems); ++$i) {
				$mergeCondition.= " OR (shashwath_members.SM_ID = $selectedItems[$i])";	
			}
			$mergeCondition.= ")";
		}else{
			$mergeCondition="";
		}

		$data['memberMerge'] = $members =$this->obj_shashwath->member_details_for_member_merge($mergeCondition);
		$data['members'] = $members =$this->obj_shashwath->member_details_for_member_seva($mergeCondition);
		$data['membersTotalCorpus'] = $membersTotalCorpus =$this->obj_shashwath->member_details_for_totalCorpus($mergeCondition);

		if(isset($_SESSION['Deity_Seva'])) {
			$this->load->view('header', $data);
			$this->load->view('Shashwath/shashwathAddlMemberMerge');
			$this->load->view('footer_home');
		} else {
			redirect('Home/homePage');
		}
	}

	public function shashwathAddlMemberMergeSave() {
		$data['whichTab'] = 'shashwath';
		$todayDate = date('d-m-Y');
		$dateTime = date('d-m-Y H:i:s A');
		$shashMinId = @$_POST['shashMinId'];
		
		$shashMembId = json_decode(@$_POST['shashMembId']);
		$shashSsId = json_decode(@$_POST['shashSsId']);

		$addrline1 =strtoupper($this->input->post('addrline1'));
		$addrline2 = strtoupper($this->input->post('addrline2'));
		$smcity = strtoupper($this->input->post('smcity'));
		$smstate = strtoupper($this->input->post('smstate'));
		$smcountry = strtoupper($this->input->post('smcountry'));
		$smpin = strtoupper($this->input->post('smpin'));	

		$sm_address = (($addrline1 != "")?$addrline1.", ":"").(($addrline2 != "")?$addrline2.", ":"").(($smcity != "")?$smcity." ":"").(($smstate != "")?$smstate." ":"").(($smcountry != "")?$smcountry." - ":"").(($smpin != "")?$smpin:"");

		$membData = array (		
			'SM_NAME' => strtoupper($this->input->post('name')),
			'SM_PHONE' => $this->input->post('number'),
			'SM_PHONE2' => $this->input->post('number2'),
			'SM_RASHI' => $this->input->post('rashi'),
			'SM_NAKSHATRA' => $this->input->post('nakshatra'),
			'SM_GOTRA' => $this->input->post('gotra'),
			'SM_ADDR1' => $addrline1,
			'SM_ADDR2' => $addrline2,
			'SM_CITY' => $smcity,
			'SM_STATE' => $smstate,
			'SM_COUNTRY' => $smcountry,
			'SM_PIN' => $smpin,
			'REMARKS' => $this->input->post('smremarks') 
		);

		if (count($shashMembId) > 0) {
			$i = 0;
			foreach($shashMembId as $ShashSeva) {
				//to store the member details in shashwath member history table
				$smId =$ShashSeva; 

				$sqlSM="SELECT * FROM shashwath_members where  SM_ID = $smId ";
				$querySM = $this->db->query($sqlSM);
				$dataSM = $querySM->first_row(); 
				$minSmRef = $dataSM->SM_ADDR1;
				$adres = ($dataSM->SM_ADDR1.",").($dataSM->SM_ADDR2.",").($dataSM->SM_CITY.",").($dataSM->SM_STATE.",").($dataSM->SM_COUNTRY.",").($dataSM->SM_PIN);

				$dataSmDelete = array (	
					'SM_ID' => $dataSM->SM_ID,
					'SM_NAME' => $dataSM->SM_NAME,
					'SM_PHONE' =>  $dataSM->SM_PHONE,
					'SM_ADDR' => $adres,
					'SM_REMARK' => $dataSM->REMARKS,
					'DELETED_BY'=> $_SESSION['userId'],
					'DELETED_DATE_TIME' => $dateTime
				);
								
				//To Upadte the member details for all the SM_ID of shash member
				$this->db->where('SM_ID',$smId);
				$this->db->update('shashwath_members',$membData);

				$sqlSMID="SELECT * FROM shashwath_members where  SM_ID = $shashMinId ";
				$querySMID = $this->db->query($sqlSMID);
				$dataSMID = $querySMID->first_row(); 
				$minSmRef = $dataSMID->SM_REF;


				$sql="UPDATE deity_receipt a JOIN shashwath_seva b ON a.SS_ID = b.SS_ID JOIN shashwath_members c ON b.SM_ID =c.SM_ID
				SET  a.RECEIPT_NAME = c.SM_NAME, a.RECEIPT_PHONE = c.SM_PHONE, a.RECEIPT_RASHI = c.SM_RASHI, a.RECEIPT_NAKSHATRA = c.SM_NAKSHATRA, a.RECEIPT_ADDRESS = '$sm_address'  where c.SM_ID = '$smId'";
				$this->db->query($sql);
				
				$ssId =	$shashSsId[$i];
				$memberReceiptFormat1 = $minSmRef.'/S';
				// print_r($minSmRef);
				if($smId != $shashMinId){
					$this ->db->select('shashwath_seva.SS_ID,SS_REF,SS_RECEIPT_NO, shashwath_members.SM_ID, shashwath_members.SM_REF, deity_receipt.RECEIPT_ID, deity_receipt.RECEIPT_NO')->from('shashwath_seva')-> join('shashwath_members','shashwath_members.SM_ID = shashwath_seva.SM_ID')->join('deity_receipt','deity_receipt.SS_ID = shashwath_seva.SS_ID')
					->where('shashwath_seva.SM_ID', $smId);
					$query4 = $this->db->get();
					$refnums = $query4->result();

					if ($query4->num_rows() > 0) {
						foreach($refnums as $ShashAddlSeva) {
							// print_r($minSmRef);	
							$sql5="SELECT RECEIPT_NO, LEFT(RECEIPT_NO,14) as leftRno,SUBSTRING_INDEX(RECEIPT_NO,'/S',-1) as rightRno FROM deity_receipt where  RECEIPT_ID = $ShashAddlSeva->RECEIPT_ID ";
							$query5 = $this->db->query($sql5);
							$receiptFormat = $query5->first_row(); 

							$RnoFormat = $receiptFormat->leftRno.$memberReceiptFormat1.$receiptFormat->rightRno;

							$data = array (		
								'RECEIPT_NO' => $RnoFormat,
							);
							$this->db->where('RECEIPT_ID',$ShashAddlSeva->RECEIPT_ID);
							$this->db->update('deity_receipt',$data);	

							//to update SM_ID to the Shashwath_seva table
							$sql6 ="SELECT RECEIPT_ID FROM deity_receipt where SS_ID = $ShashAddlSeva->SS_ID";
							$query6 = $this->db->query($sql6);

							if($query6->num_rows() > 0) {
								$sql7 = "UPDATE shashwath_seva set SM_ID =$shashMinId  where SS_ID = $ShashAddlSeva->SS_ID ";
								$query7 = $this->db->query($sql7);
							}

							//To Fetch Count Of deity Receipt corresponding to the deleting sm_id
							$sql8 ="SELECT SS_ID FROM shashwath_seva  where SM_ID = $ShashAddlSeva->SM_ID";
							$query8 = $this->db->query($sql8);
							
							if($query8->num_rows() < 1) {
								$sql9 = "DELETE FROM shashwath_members where SM_ID = $ShashAddlSeva->SM_ID";
								$query9 = $this->db->query($sql9);
								$this->db->insert('shashwath_member_delete_history',$dataSmDelete);
							}
							$sql10 = "UPDATE shashwath_members set SM_MERGE_STATUS =1  where SM_ID = $shashMinId";
							$query10 = $this->db->query($sql10);
						}
					}	
				}
				$i++;
			}

		}
		echo "success";
	}

	public function memberFilterSearch() {
		$date = date('d-m-Y');
		$data['masa'] = $masa = @$_POST['masa'];
		$data['month'] = $month = @$_POST['month'];
		$data['thithiMasaCode'] = $thithiMasaCode = @$_POST['thithiMasaCode'];
		$data['selDate'] = $selDate = @$_POST['selDate'];

		//$data['thithiName'] = $thithiName = ($SHBH=="Shuddha" ? @$_POST['thithiCode'] : @$_POST['thithiCode1']);
		$month_name = date("F", mktime(0, 0, 0, substr($month,1), 10));

		if($masa != ''){ 
			$filter = "(STR_TO_DATE('$date','%d-%m-%Y') BETWEEN STR_TO_DATE(CAL_START_DATE,'%d-%m-%Y') AND STR_TO_DATE(CAL_END_DATE,'%d-%m-%Y')) AND shashwath_seva.MASA LIKE '$masa%'";
			if($thithiMasaCode != ""){
				$filter .= "AND shashwath_seva.THITHI_CODE = '$thithiMasaCode'";
			}
		} else {	
			$filter = "shashwath_seva.ENG_DATE LIKE '%$month'";
			if($selDate!=""){
				$filter.="AND shashwath_seva.ENG_DATE='$selDate'";
			}
		}

		$data['nameSearch'] =$nameSearch = $_SESSION['nameSearch'] = @$_POST['nameSearch'];
		$condsrch = " SM_NAME LIKE '%".str_replace("'","''",@$_POST['nameSearch'])."%'";
		echo json_encode($this->obj_shashwath->get_member_filter_search($filter,$masa,$condsrch));
	}

	function shashwathMergeSearch() {
		$data['whichTab'] = 'shashwath';
		$data['ShashwathMemberName'] = $this->obj_shashwath->membermerge_details();
		$this->load->view('header');
		$this->load->view('Shashwath/smMergeSearchPage',$data);
		$this->load->view('footer_home');
	}

	public function updateAppearence() {
		if(isset($_POST)){
			$SM_ID = $this->input->post('SM_ID');
		}
		$sql="UPDATE shashwath_members SET SM_APPEAR_STATUS = 1  where SM_ID = $SM_ID";
		$this->db->query($sql);
		echo "success";
	}

	//NEW_CODE_START
	public function newMandalimemberinsert(){
		$_SESSION['duplicate'] = "no";
		$dateTime = date('d-m-Y H:i:s A');
		$name = json_decode(@$_POST['name']);
		$number = json_decode(@$_POST['number']);
		$number2 =json_decode( @$_POST['number2']);
		$rashi = json_decode(@$_POST['rashi']);
		$gotra = json_decode(@$_POST['gotra']);
		$nakshatra = json_decode(@$_POST['nakshatra']);
		$addressLine1 = json_decode(@$_POST['addressLine1']);
		$addressLine2 = json_decode(@$_POST['addressLine2']);
		$city = json_decode(@$_POST['city']);
		$state = json_decode(@$_POST['state']);
		$country = json_decode(@$_POST['country']);
		$pincode = json_decode(@$_POST['pincode']);
		$remarks = json_decode(@$_POST['remarks']);
		$smIdVal = @$_POST['smIdVal'];
		
		for($i = 0; $i < count($name); ++$i) { 
			$shashwathMMData = array(
			    'SM_ID'   =>$smIdVal,
				'MM_NAME'  =>$name[$i],
			    'MM_PHONE' =>$number[$i],
			    'MM_PHONE2' =>$number2[$i],
				'MM_RASHI' =>$rashi[$i],
				'MM_NAKSHATRA'=>$nakshatra[$i],
				'MM_GOTRA' =>$gotra[$i],
				'MM_ADDR1' =>$addressLine1[$i],
				'MM_ADDR2' =>$addressLine2[$i],
				'MM_CITY'  =>$city[$i],
				'MM_STATE' =>$state[$i],
				'MM_COUNTRY'=>$country[$i],
				'MM_PIN'    =>$pincode[$i],
				'MM_REMARKS'  =>$remarks[$i]
		    );  
			$this->db->insert('shashwath_mandali_member_details', $shashwathMMData); 
		}
		echo "success";
	}

	public function mandalimemberDelete(){
		$SM_ID_VAL = @$_POST['SM_ID_VAL'];
		$MM_ID_VAL = @$_POST['MM_ID_VAL'];
		$sql="UPDATE shashwath_mandali_member_details SET MM_ACTIVE_STATUS=0 WHERE MM_ID = $MM_ID_VAL";
		$this->db->query($sql);
		echo "success";
	}

	public function updateMandaliMember(){
		$name = strtoupper(@$_POST['MMname']);
		$number = @$_POST['MMphone'];
		$number2 = @$_POST['MMphone2'];
		$rashi = strtoupper(@$_POST['MMrashi']);
		$gotra = strtoupper(@$_POST['MMGotra']);
		$nakshatra = strtoupper(@$_POST['MMnakshatra']);
		$addressLine1 = strtoupper(@$_POST['MMaddLine1']);
		$addressLine2 = strtoupper(@$_POST['MMaddLine2']);
		$city = strtoupper(@$_POST['MMcity']);
		$state = strtoupper(@$_POST['MMstate']);
		$country = strtoupper(@$_POST['MMcountry']);
		$pincode = @$_POST['MMpincode'];
		$remarks = strtoupper(@$_POST['MMremarks']);
		$MMID = @$_POST['MMID'];
		$smIdVal = @$_POST['smIdVal'];
		$shashMMData = array(
			'MM_NAME'  =>$name,
		    'MM_PHONE' =>$number,
		    'MM_PHONE2' =>$number2,
			'MM_RASHI' =>$rashi,
			'MM_NAKSHATRA'=>$nakshatra,
			'MM_GOTRA' =>$gotra,
			'MM_ADDR1' =>$addressLine1,
			'MM_ADDR2' =>$addressLine2,
			'MM_CITY'  =>$city,
			'MM_STATE' =>$state,
			'MM_COUNTRY'=>$country,
			'MM_PIN'    =>$pincode,
			'MM_REMARKS'  =>$remarks
	    ); 
	    $this->db->where('MM_ID',$MMID); 
		$this->db->update('shashwath_mandali_member_details', $shashMMData); 
		echo "success|".json_encode($this->obj_shashwath->mandali_member_details($smIdVal));
	}
	//NEW_CODE_END

	public function mandalimemberinsert(){
		$_SESSION['duplicate'] = "no";

		$name1 = json_decode(@$_POST['name1']);
		$number1 = json_decode(@$_POST['number1']);
		$number21 =json_decode( @$_POST['number21']);
		$rashi1 = json_decode(@$_POST['rashi1']);
		$gotra1 = json_decode(@$_POST['gotra1']);
		$nakshatra1 = json_decode(@$_POST['nakshatra1']);
		
		$addressLine11 = json_decode(@$_POST['addressLine11']);
		$addressLine21 = json_decode(@$_POST['addressLine21']);
		$city1 = json_decode(@$_POST['city1']);
		$state1 = json_decode(@$_POST['state1']);
		$country1 = json_decode(@$_POST['country1']);
		$pincode1 = json_decode(@$_POST['pincode1']);
		//$price1 = json_decode(@$_POST['price1']);
		$remarks1 = json_decode(@$_POST['remarks1']);
		$ispostage = json_decode(@$_POST['ispostage']);
		$smId = @$_POST['smId'];

		$mandaliName =  strtoupper(@$_POST['memmanname']);
		$mandaliPhone = @$_POST['memmannumber'];
		$mandliPhone2 = @$_POST['memmannumber2'];
		$mandliAddrline1 = strtoupper(@$_POST['memmanaddr1']);
		$mandliAddrline2= strtoupper(@$_POST['memmanaddr2']);
		$mandlicity = strtoupper(@$_POST['memmancity']);
		$mandliState = strtoupper(@$_POST['memmanstate']);
		$mandliCountry =strtoupper(@$_POST['memmancountry']);
		$mandliPin = @$_POST['memmanpin'];
		$mandliRemarks =  @$_POST['memmanremarks'];
		// if($ispostage==""){
		// 	$ispostage=0;
		// }
	
		$shashwathNullData = array(
		    'SM_ID'   =>$smId,
			'MM_NAME'  =>'Mandali Sevadhar',
		    'MM_PHONE' =>$mandaliPhone,
		    'MM_PHONE2' =>$mandliPhone2,
			'MM_ADDR1' =>$mandliAddrline1,
			'MM_ADDR2' =>$mandliAddrline2,
			'MM_CITY'  =>$mandlicity,
			'MM_STATE' =>$mandliState,
			'MM_COUNTRY'=>$mandliCountry,
			'MM_PIN'    =>$mandliPin,
			'MM_REMARKS'  =>$mandliRemarks,
			'MM_POSTAGE' =>0,
		);  
		$this->db->insert('shashwath_mandali_member_details', $shashwathNullData); 
		if( count($name1) >= 0){
		// $this->db->insert('shashwath_mandali_member_details', $shashwathDatanull);
			for($i = 0; $i < count($name1); ++$i) { 
				$shashwathData = array(
				    'SM_ID'   =>$smId,
					'MM_NAME'  =>$name1[$i],
				    'MM_PHONE' =>$number1[$i],
				    'MM_PHONE2' =>$number21[$i],
					'MM_RASHI' =>$rashi1[$i],
					'MM_NAKSHATRA'=>$nakshatra1[$i],
					'MM_GOTRA' =>$gotra1[$i],
					'MM_ADDR1' =>$addressLine11[$i],
					'MM_ADDR2' =>$addressLine21[$i],
					'MM_CITY'  =>$city1[$i],
					'MM_STATE' =>$state1[$i],
					'MM_COUNTRY'=>$country1[$i],
					'MM_PIN'    =>$pincode1[$i],
					'MM_REMARKS'  =>$remarks1[$i],
					'MM_POSTAGE' => (($ispostage[$i] == "YES")?1:0),
			    );  
			  $this->db->insert('shashwath_mandali_member_details', $shashwathData); 
			}

			
		}	
		echo "success";	
	}

	function updateMandaliMemDetails() {
		$RECEIPT_ID = @$_POST['rcpid'];
		$mmId = @$_POST['mmId'];
		$this->obj_shashwath->update_manadli_member_details($RECEIPT_ID,$mmId);
		$_SESSION['secTab'] = "Yes";
		echo "success";
	}
}