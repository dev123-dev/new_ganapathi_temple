<?php defined('BASEPATH') OR exit('No direct script access allowed');
   //ini_set('memory_limit', '-1');
ini_set('memory_limit', '20000M');
ini_set('max_execution_time', 300);
class Report extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('string');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->helper('date');
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('Report_modal','obj_report',true);
		$this->load->model('Receipt_modal','obj_receipt',true);
		$this->load->model('Shashwath_Model','obj_shashwath',true);
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		$this->load->model('Events_modal','obj_events',true);

			//CHECK LOGIN
		if(!isset($_SESSION['userId']))
			redirect('login');

		if($_SESSION['trustLogin'] == 1) 
			redirect('Trust');
		$this->db->select()->from('EVENT')->where("ET_ACTIVE !=","0");
		$query = $this->db->get();
		$_SESSION['eventActiveCount'] = $query->num_rows();
			//$this->output->enable_profiler(true);
	}

		//FOR EXCEL FOR RECEIPT
	function deity_receipt_report_excel() {
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}

		if(isset($_POST['allDates'])) {
			$allDates= @$_POST['allDates'];
		} else {
			$allDates = $_SESSION['allDates'];
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$header = "";
		$result = ""; 
		if(@$radioOpt == "multiDate")
				$filename = "Deity_Receipt_Report from ".$_SESSION['fromDate']." to ".$_SESSION['toDate'];  //File Name
			else
				$filename = "Deity_Receipt_Report_".$_POST['dateField'];  //File Name
			$file_ending = "xls";
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";
			$header .= "SI NO." . "\t";
			$header .= "RECEIPT NO." . "\t";
			$header .= "RECEIPT DATE" . "\t";
			$header .= "RECEIPT TYPE" . "\t";
			$header .= "NAME" . "\t";
			$header .= "Estimated Price" . "\t";
			$header .= "Description" . "\t";
			$header .= "QUANTITY" . "\t";
			$header .= "PAYMENT MODE" . "\t";
			$header .= "AMOUNT" . "\t";	
			$header .= "POSTAGE" . "\t";	
			$header .= "GRAND TOTAL" . "\t";
			$header .= "CHEQUE NO." . "\t";
			$header .= "BANK NAME" . "\t";	
			$header .= "CHEQUE DATE." . "\t";
			$header .= "PAYMENT NOTES" . "\t";	
			$header .= "PAYMENT STATUS" . "\t";	
			
			if($_POST['dateField'] != "" && $_POST['payMode'] == "All") {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
							$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 0"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						} else {
							$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
							$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 0"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						}
					}
					$condition= $queryString;
					$conditionOne= $queryString1;
				} else {
					$condition= array('RECEIPT_DATE' => $_POST['dateField'],'RECEIPT_ACTIVE' => 1); //'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
					$conditionOne= array('RECEIPT_DATE' => $_POST['dateField'],'RECEIPT_ACTIVE' => 0); //'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
				}
				$res = $this->obj_report->get_all_field_deity_receipt_excel($condition);
				$res1 = $this->obj_report->get_all_field_deity_receipt_excel($conditionOne);
			} else {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and RECEIPT_ACTIVE = 1"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
							$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and RECEIPT_ACTIVE = 0"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						} else {
							$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and RECEIPT_ACTIVE = 1"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
							$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and RECEIPT_ACTIVE = 0"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						}
					}
					$condition= $queryString;
					$conditionOne= $queryString1;
				} else {
					$condition= array('RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'RECEIPT_DATE' => $_POST['dateField'],'RECEIPT_ACTIVE'=>1); //'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
					$conditionOne= array('RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'RECEIPT_DATE' => $_POST['dateField'],'RECEIPT_ACTIVE'=>0); //'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
				}
				$res = $this->obj_report->get_all_field_deity_receipt_excel($condition);
				$res1 = $this->obj_report->get_all_field_deity_receipt_excel($conditionOne);
			}

			for($i = 0; $i < sizeof($res); $i++)
			{
				$line = '';    
				$value = "";
				$sum = ($res[$i]->RECEIPT_PRICE) + ($res[$i]->POSTAGE_PRICE);
				$value .= '"' . ($i+1) . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_NO . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_DATE . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_CATEGORY_TYPE . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->DY_IK_APPRX_AMT . '"' . "\t";
				$value .= '"' . $res[$i]->DY_IK_ITEM_DESC . '"' . "\t";
				// $value .= '"' . $res[$i]->DY_IK_ITEM_QTY . '"' . "\t";
     		    $value .= '"' . $res[$i]->DY_IK_ITEM_QTY . '"' .'' . $res[$i]->DY_IK_ITEM_UNIT . '' . "\t";

				$value .= '"' . $res[$i]->RECEIPT_PAYMENT_METHOD . '"' . "\t";
				if($res[$i]->RECEIPT_CATEGORY_TYPE == "Inkind") {
					$value .= '' . "\t";
				} else {
					$value .= '"' . $res[$i]->RECEIPT_PRICE . '"' . "\t";
				}
				$value .= '"' . $res[$i]->POSTAGE_PRICE . '"' . "\t";
				$value .= '"' . $sum . '"' . "\t";

				$value .= '"' . $res[$i]->CHEQUE_NO . '"' . "\t";
				$value .= '"' . $res[$i]->BANK_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->CHEQUE_DATE . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_PAYMENT_METHOD_NOTES . '"' . "\t";

				$value .= '"' . $res[$i]->PAYMENT_STATUS . '"' . "\t";

				$line .= $value;
				$result .= trim($line) . "\n";
			}
			$result .= "\n";
			
			$result .= "Cancelled Receipt:";
			
			$result .= "\n";
			
			$result .= "SI NO." . "\t";
			$result .= "RECEIPT NO." . "\t";
			$result .= "RECEIPT DATE" . "\t";
			$result .= "RECEIPT TYPE" . "\t";
			$result .= "NAME" . "\t";
			$result .= "PAYMENT MODE" . "\t";
			$result .= "AMOUNT" . "\t";	
			$result .= "POSTAGE" . "\t";	
			$result .= "GRAND TOTAL" . "\t";
			$result .= "CHEQUE NO." . "\t";
			$result .= "BANK NAME" . "\t";	
			$result .= "CHEQUE DATE." . "\t";
			$result .= "PAYMENT STATUS" . "\t";	
			$result .= "\n";
			
			for($i = 0; $i < sizeof($res1); $i++)
			{
				$line = '';    
				$value = "";		
				$sum = ($res1[$i]->RECEIPT_PRICE) + ($res1[$i]->POSTAGE_PRICE);
				$value .= '"' . ($i+1) . '"' . "\t";
				$value .= '"' . $res1[$i]->RECEIPT_NO . '"' . "\t";
				$value .= '"' . $res1[$i]->RECEIPT_DATE . '"' . "\t";
				$value .= '"' . $res1[$i]->RECEIPT_CATEGORY_TYPE . '"' . "\t";
				$value .= '"' . $res1[$i]->RECEIPT_NAME . '"' . "\t";
				$value .= '"' . $res1[$i]->RECEIPT_PAYMENT_METHOD . '"' . "\t";
				if($res1[$i]->RECEIPT_CATEGORY_TYPE == "Inkind") {
					$value .= '' . "\t";
				} else {
					$value .= '"' . $res1[$i]->RECEIPT_PRICE . '"' . "\t";
				}
				$value .= '"' . $res1[$i]->POSTAGE_PRICE . '"' . "\t";
				$value .= '"' . $sum . '"' . "\t";

				$value .= '"' . $res1[$i]->CHEQUE_NO . '"' . "\t";
				$value .= '"' . $res1[$i]->BANK_NAME . '"' . "\t";
				$value .= '"' . $res1[$i]->CHEQUE_DATE . '"' . "\t";

				$value .= '"' . $res1[$i]->PAYMENT_STATUS . '"' . "\t";

				$line .= $value;
				$result .= trim($line) . "\n";
			}
			
			$result = str_replace( "\r" , "" , $result );

			print("$header\n$result"); 
		}

		//DEITY RECEIPT REPORT ON CHANGE OF FIELD
		function deity_report_on_change_date($start = 0) {
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['allDates'])) {
				$allDates= @$_POST['allDates'];
				$_SESSION['allDates'] = $allDates;
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			$data['radioOpt'] = $radioOpt;
			$data['allDates'] = $allDates;
			
			if(isset($_POST['fromDate'])) {
				$fromDate = @$_POST['fromDate'];
				$toDate = @$_POST['toDate'];
				$_SESSION['fromDate'] = $fromDate;
				$_SESSION['toDate'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDate'];
				$toDate = $_SESSION['toDate'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['paymentMethod']) {
				unset($_SESSION['paymentMethod']);
				$data['PMode'] = $this->input->post('paymentMethod');
				$paymentMode = $this->input->post('paymentMethod');
			}
			
			if(@$_SESSION['paymentMethod'] == "") {
				$this->session->set_userdata('paymentMethod', $this->input->post('paymentMethod'));
				$data['PMode'] = $_SESSION['paymentMethod'];
				$paymentMode = $this->input->post('paymentMethod');
			} else {
				$paymentMode = $_SESSION['paymentMethod'];
				$data['PMode'] = $_SESSION['paymentMethod'];
			}
			
			if(@$_POST['deity']) {
				unset($_SESSION['deityId']);
				$deityId = $this->input->post('deity');
				$data['deityId'] = $deityId;
			}
			
			if(@$_SESSION['deityId'] == "") {
				$this->session->set_userdata('deityId', $this->input->post('deity'));
				$data['deityId'] = $_SESSION['deityId'];
				$deityId = $this->input->post('deity');
			} else {
				$deityId = $_SESSION['deityId'];
				$data['deityId'] = $_SESSION['deityId'];
			}
			
			$condition = array('DEITY_ACTIVE' => 1);
			$data['deity'] = $this->obj_report->get_all_field_deity($condition);
			if(@$paymentMode != 'All' || @$deityId != "All Deity") {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							if(@$paymentMode != 'All' && @$deityId != "All Deity") {
								$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
								$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and RECEIPT_ACTIVE = 1";
							} else if(@$paymentMode != 'All') {
								$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
								$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and RECEIPT_ACTIVE = 1";
							} else if(@$deityId != "All Deity") {
								$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId."";
								$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_ACTIVE = 1";
							}	
						} else {
							if(@$paymentMode != 'All' && @$deityId != "All Deity")  {
								$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
								$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and RECEIPT_ACTIVE = 1";
							} else if(@$paymentMode != 'All') {
								$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
								$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$paymentMode."' and RECEIPT_ACTIVE = 1";
							} else if(@$deityId != "All Deity") {
								$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId."";
								$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_ACTIVE = 1";
							}
						}
					}
					$conditionOne = $queryString;
					$conditionTwo = $queryString1;
				} else {
					if(@$paymentMode != 'All' && @$deityId != "All Deity") {
						$conditionOne = array('RECEIPT_DEITY_ID' => $deityId,'RECEIPT_PAYMENT_METHOD' => $paymentMode,'RECEIPT_DATE' => $date);
						$conditionTwo = array('RECEIPT_DEITY_ID' => $deityId,'RECEIPT_PAYMENT_METHOD' => $paymentMode,'RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
					} else if(@$paymentMode != 'All') {
						$conditionOne = array('RECEIPT_PAYMENT_METHOD' => $paymentMode,'RECEIPT_DATE' => $date);
						$conditionTwo = array('RECEIPT_PAYMENT_METHOD' => $paymentMode,'RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' =>1);
					} else if(@$deityId != "All Deity") {
						$conditionOne = array('RECEIPT_DEITY_ID' => $deityId,'RECEIPT_DATE' => $date);
						$conditionTwo = array('RECEIPT_DEITY_ID' => $deityId,'RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' =>1);
					}
				}
				
				$data['deity_receipt_report'] = $this->obj_report->get_all_field_deity_receipt_report($conditionOne,'','', 10,$start);
				//For Count
				$data['Count'] = $this->obj_report->count_rows_deity_receipt_report($conditionOne);
				
				//FOR PRICE DISPLAY IN COMBOBOX
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					$queryString2 = "";
					$queryString3 = "";
					$queryString4 = "";
					
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							if(@$paymentMode != 'All' && @$deityId != "All Deity") {
								$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_ACTIVE = 1";
								$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='Cash' and RECEIPT_ACTIVE = 1";
								$queryString2 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='Cheque' and RECEIPT_ACTIVE = 1";
								$queryString3 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and RECEIPT_ACTIVE = 1";
								$queryString4 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='Direct Credit' and RECEIPT_ACTIVE = 1";
							} else {
								$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1";
								$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cash' and RECEIPT_ACTIVE = 1";
								$queryString2 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cheque' and RECEIPT_ACTIVE = 1";
								$queryString3 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and RECEIPT_ACTIVE = 1";
								$queryString4 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Direct Credit' and RECEIPT_ACTIVE = 1";
							}
						} else {
							if(@$paymentMode != 'All' && @$deityId != "All Deity") {
								$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_ACTIVE = 1";
								$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='Cash' and RECEIPT_ACTIVE = 1";
								$queryString2 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='Cheque' and RECEIPT_ACTIVE = 1";
								$queryString3 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and RECEIPT_ACTIVE = 1";
								$queryString4 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_DEITY_ID = ".$deityId." and RECEIPT_PAYMENT_METHOD='Direct Credit' and RECEIPT_ACTIVE = 1";
							} else {
								$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1";
								$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cash' and RECEIPT_ACTIVE = 1";
								$queryString2 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cheque' and RECEIPT_ACTIVE = 1";
								$queryString3 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and RECEIPT_ACTIVE = 1";
								$queryString4 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Direct Credit' and RECEIPT_ACTIVE = 1";
							}
						}
					}
					$condt = $queryString;
					$condt1 = $queryString1;
					$condt2 = $queryString2;
					$condt3 = $queryString3;
					$condt4 = $queryString4;
				} else {
					if(@$paymentMode != 'All' && @$deityId != "All Deity") {
						$condt = array('RECEIPT_DEITY_ID' => $deityId , 'RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
						$condt1 = array('RECEIPT_DEITY_ID' => $deityId ,'RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
						$condt2 = array('RECEIPT_DEITY_ID' => $deityId ,'RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
						$condt3 = array('RECEIPT_DEITY_ID' => $deityId ,'RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
						$condt4 = array('RECEIPT_DEITY_ID' => $deityId ,'RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
					} else {
						$condt = array('RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
						$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
						$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
						$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
						$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' =>1);
					}
				}
			} else {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "RECEIPT_DATE='".$allDates1[$i]."'";
							$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1";
						} else {
							$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."'";
							$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1";
						}
					}
					$conditionOne = $queryString;
					$conditionTwo = $queryString1;
				} else {
					$conditionOne = array('RECEIPT_DATE' => $date);
					$conditionTwo = array('RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
				}
				$data['deity_receipt_report'] = $this->obj_report->get_all_field_deity_receipt_report($conditionOne,'','', 10,$start);

				//For Count
				$data['Count'] = $this->obj_report->count_rows_deity_receipt_report($conditionOne);
				
				//FOR PRICE DISPLAY IN COMBOBOX
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					$queryString2 = "";
					$queryString3 = "";
					$queryString4 = "";
					
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1";
							$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cash' and RECEIPT_ACTIVE = 1";
							$queryString2 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cheque' and RECEIPT_ACTIVE = 1";
							$queryString3 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and RECEIPT_ACTIVE = 1";
							$queryString4 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Direct Credit' and RECEIPT_ACTIVE = 1";
						} else {
							$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1";
							$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cash' and RECEIPT_ACTIVE = 1";
							$queryString2 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Cheque' and RECEIPT_ACTIVE = 1";
							$queryString3 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Credit / Debit Card' and RECEIPT_ACTIVE = 1";
							$queryString4 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='Direct Credit' and RECEIPT_ACTIVE = 1";
						}
					}
					$condt = $queryString;
					$condt1 = $queryString1;
					$condt2 = $queryString2;
					$condt3 = $queryString3;
					$condt4 = $queryString4;
				} else {
					//FOR PRICE DISPLAY IN COMBOBOX
					$condt = array('RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
					$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE'=>1);
					$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
					$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE' => 1);
					$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit','RECEIPT_DATE' => $date,'RECEIPT_ACTIVE'=>1);
				}
			}
			
			$data['All'] = $this->obj_report->get_total_amount_deity($condt);
			$data['Cash'] = $this->obj_report->get_total_amount_deity($condt1);
			$data['Cheque'] = $this->obj_report->get_total_amount_deity($condt2);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount_deity($condt3);
			$data['Direct'] = $this->obj_report->get_total_amount_deity($condt4);
			
			$data['TotalAmount'] = $this->obj_report->get_all_amount_deity($conditionTwo);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/deity_report_on_change_date';
			$config['total_rows'] = $this->obj_report->count_rows_deity_receipt_report($conditionOne);
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
			
			$this->load->view('header', $data);
			$this->load->view('deity_receipt_report');
			$this->load->view('footer_home');
		}
		
		//DEITY RECEIPT REPORT
		function deity_receipt_report($start = 0) {			
			//Radio Option
			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			//Unset Session
			unset($_SESSION['date']);
			unset($_SESSION['deityId']);
			unset($_SESSION['paymentMethod']);
			
			//For Menu Selection
			$data['whichTab'] = "report";
			$data['date'] = date('d-m-Y');
			
			$condition = array('DEITY_ACTIVE' => 1);
			$data['deity'] = $this->obj_report->get_all_field_deity($condition);
			
			$conditionOne = array('RECEIPT_DATE' => date('d-m-Y'));
			$data['deity_receipt_report'] = $this->obj_report->get_all_field_deity_receipt_report($conditionOne,'','', 10,$start);
			//print_r($data['deity_receipt_report']);
			$conditionTwo = array('RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE' => 1);
			$data['TotalAmount'] = $this->obj_report->get_all_amount_deity($conditionTwo);
			
			//For Count
			$data['Count'] = $this->obj_report->count_rows_deity_receipt_report($conditionOne);
			
			//FOR PRICE IN COMBOBOX
			$condt = array('RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE' => 1);
			$data['All'] = $this->obj_report->get_total_amount_deity($condt);
			$condt1 = array('RECEIPT_PAYMENT_METHOD' => 'Cash' ,'RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE' => 1);
			$data['Cash'] = $this->obj_report->get_total_amount_deity($condt1);
			$condt2 = array('RECEIPT_PAYMENT_METHOD' => 'Cheque' ,'RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE' => 1);
			$data['Cheque'] = $this->obj_report->get_total_amount_deity($condt2);
			$condt3 = array('RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card' ,'RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE' => 1);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount_deity($condt3);
			$condt4 = array('RECEIPT_PAYMENT_METHOD' => 'Direct Credit' ,'RECEIPT_DATE' => date('d-m-Y'),'RECEIPT_ACTIVE' => 1);
			$data['Direct'] = $this->obj_report->get_total_amount_deity($condt4);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/deity_receipt_report';
			$config['total_rows'] = $this->obj_report->count_rows_deity_receipt_report($conditionOne);
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
			
			if(isset($_SESSION['Deity_Receipt_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('deity_receipt_report');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FOR EXCEL FOR DEITY SEVA
		function deity_sevas_report_excel() {
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			// $this->output->enable_profiler(true);
			
			if(isset($_POST['radioAllOpt'])) {
				$radioAllOpt = @$_POST['radioAllOpt'];
			} else {
				$radioAllOpt = $_SESSION['radioAllOpt'];
			}

			if($_POST['excludeOrInclude']=="Exclude") {
				$excludeIncludeCondition = " deity_seva.SEVA_INCL_EXCL != 'Exclude' ";
			} else {
				$excludeIncludeCondition ="";
			}
			
			$header = "";
			$result = "";
			if(@$radioOpt == "multiDate")
				$filename = "Deity_Seva_Receipt_Report_ from ".$_SESSION['fromDate']." to ".$_SESSION['toDate'];  //File Name
			else
				$filename = "Deity_Seva_Receipt_Report_".$_POST['dateField'];  //File Name
			$file_ending = "xls";

			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			//Joel Sir 19/04/21
			// $header .= "SI NO." . "\t";
			// $header .= "SEVA NAME" . "\t";
			// $header .= "SEVA QTY" . "\t";
			// $header .= "NAME" . "\t";	
			// $header .= "CONTACT NUMBER" . "\t";		
			// $header .= "RECEIPT NO. (DATE)" . "\t";
			//Joel Sir 19/04/21
			
			if(isset($_POST['allDates'])) {
				$allDates= @$_POST['allDates'];
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			if(@$radioAllOpt == "allDeity") {
				if(@$radioOpt == "multiDate"){	
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$bookQueryString = "";
					$bookCondition = "";

						$queryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
						$bookQueryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE = 1";

					$condition = $queryString;
					$bookCondition = $bookQueryString;
					$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition);
					$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);
				} else {
					$condition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
					$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'),'DEITY_SEVA_OFFERED.RECEIPT_ID' =>0,'SB_ACTIVE'=>1);
					$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition);
					$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);
				}
			} else {
				if(@$radioOpt == "multiDate"){	
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$bookQueryString = "";
					$bookCondition = "";

							if($this->input->post('SId') != "All") {
								$queryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_SEVA_ID ='".$this->input->post('SId')."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
								$bookQueryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_SEVA_ID ='".$this->input->post('SId')."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE = 1";
							} else {
								$queryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$this->input->post('DId')."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
								$bookQueryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$this->input->post('DId')."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE = 1";
							}
							
					$condition = $queryString;
					$bookCondition = $bookQueryString;
					$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition);
					$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);
				} else {
					if(($this->input->post('dateField')) != "" && ($this->input->post('SId') == "All")) {
						$condition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_SEVA_OFFERED.SO_DEITY_ID' =>$this->input->post('DId'), 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
						$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_SEVA_OFFERED.SO_DEITY_ID' =>$this->input->post('DId'), 'DEITY_SEVA_OFFERED.RECEIPT_ID' =>0,'SB_ACTIVE'=>1);
						$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition);
						$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);
					} else {
						$condition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_SEVA_OFFERED.SO_SEVA_ID' => $this->input->post('SId'), 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
						$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_SEVA_OFFERED.SO_SEVA_ID' => $this->input->post('SId'),'DEITY_SEVA_OFFERED.RECEIPT_ID' =>0,'SB_ACTIVE'=>1);
						$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition);
						$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);
					}
				}
			}
			$firstDeity = "\t";
			$firstDeity .= "\t";
			$firstDeity .= $templename[0]["TEMPLE_NAME"]. "\n\n";	//Joel Sir 19/04/21
			// $firstDeity .= "Deity: ".$res[0]['DEITY_NAME'];//Joel Sir 19/04/21

			//Joel Sir 19/04/21
			$name = ""; $z = 0; $j = 0;
			for($i = 0; $i < sizeof($res1); $i++)
			{
				$line = '';    
				$value = "";
				if($name != $res1[$i]['DEITY_NAME']) {
					$name = $res1[$i]['DEITY_NAME'];					
					$line .= $value;
					$result .= trim($line) . "\n";
					$value .= '"Deity: ' . $res1[$i]['DEITY_NAME'] . '" (Booking)' . "\n";
					
					$value .= "SI NO." . "\t";
					$value .= "SEVA NAME" . "\t";
					$value .= "SEVA QTY" . "\t";
					$value .= "NAME" . "\t";
					$value .= "CONTACT NUMBER" . "\t";
					$value .= "BOOKING NO. (DATE)" . "\n";
					$j = 0;					
				}
				
				$value .= ($j+1). "\t";
				$value .= '"' . $res1[$i]['SO_SEVA_NAME'] . '"' . "\t";
				$value .= '"' . @$res1[$i]['SEVA_QTY'] . '"' . "\t";
				$value .= '"' . @$res1[$i]['RECEIPT_NAME'] . @$res1[$i]['SB_NAME'] . '"' . "\t";
				$value .= '"' . @$res1[$i]['RECEIPT_PHONE'] . @$res1[$i]['SB_PHONE'] . '"' . "\t";
				$value .= '"' . @$res1[$i]['RECEIPT_NO'] . @$res1[$i]['SB_NO'] . " (".@$res1[$i]['SB_DATE'].") " .'"' . "\t";				
				
				$line .= $value;
				$result .= trim($line) . "\n";
				$z++;
				$j++;
			}
			$result = str_replace( "\r" , "" , $result);

			$name = ""; $z = 0; $j = 0;			
			for($i = 0; $i < sizeof($res); $i++) {
				$line = '';    
				$value = "";
				if($name != $res[$i]['DEITY_NAME']) {
					$name = $res[$i]['DEITY_NAME'];
					$line .= $value;
					$result .= trim($line) . "\n";
					$value .= '"Deity: ' . $res[$i]['DEITY_NAME'] . '"' . "\n";
					
					$value .= "SI NO." . "\t";
					$value .= "SEVA NAME" . "\t";
					$value .= "SEVA QTY" . "\t";
					$value .= "NAME" . "\t";
					$value .= "CONTACT NUMBER" . "\t";
					$value .= "RECEIPT NO. (DATE)" . "\n";
					$j = 0;
				}

				$value .= ($j+1). "\t";
				$value .= '"' . $res[$i]['SO_SEVA_NAME'] . '"' . "\t";

				if(@$res[$i]['RECEIPT_CATEGORY_ID'] == 7) {	
					$value .= '"' . @$res[$i]['SO_SEVA_QTY'] . '"' . "\t";
				} else {
					$value .= '"' . @$res[$i]['SEVA_QTY'] . '"' . "\t";
				}

				$value .= '"' . @$res[$i]['RECEIPT_NAME'] . @$res[$i]['SB_NAME'] . '"' . "\t";
				$value .= '"' . @$res[$i]['RECEIPT_PHONE'] . @$res[$i]['SB_PHONE'] . '"' . "\t";
				
				if(@$res[$i]['RECEIPT_NO']) {
					$value .= '"' . @$res[$i]['RECEIPT_NO'] . @$res[$i]['SB_NO'] . " (". @$res[$i]['RECEIPT_DATE'] .") " . '"' . "\t";
				} else {
					$value .= '"' . @$res[$i]['RECEIPT_NO'] . @$res[$i]['SB_NO'] . " (".@$res[$i]['SB_DATE'].") " .'"' . "\t";
				}
				
				$line .= $value;
				$result .= trim($line) . "\n";
				$z++;
				$j++;
			}
			$result = str_replace( "\r" , "" , $result);
			//Joel Sir 19/04/21

			print("$firstDeity\n$result"); 
		}
		
		//SEVA REPORT CHANGE OF COMBO AND DATEFIELD
		function deity_seva_date_change_report($start = 0) {
			//For Menu Selection
			$data['whichTab'] = "report";
			$data['Filter'] = "Yes";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['radioAllOpt'])) {
				$radioAllOpt = @$_POST['radioAllOpt'];
				$_SESSION['radioAllOpt'] = $radioAllOpt;
			} else {
				$radioAllOpt = $_SESSION['radioAllOpt'];
			}
			
			$data['radioAllOpt'] = $radioAllOpt;
			
			if(isset($_POST['allDates'])) {
				$allDates= @$_POST['allDates'];
				$_SESSION['allDates'] = $allDates;
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			$data['allDates'] = $allDates;
			
			if(isset($_POST['fromDate'])) {
				$fromDate = @$_POST['fromDate'];
				$toDate = @$_POST['toDate'];
				$_SESSION['fromDate'] = $fromDate;
				$_SESSION['toDate'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDate'];
				$toDate = $_SESSION['toDate'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['sevaid']) {
				unset($_SESSION['sevaid']);
				$data['sevaId'] = $this->input->post('sevaid');
				$sevaid = $this->input->post('sevaid');
			}
			
			if(@$_SESSION['sevaid'] == "") {
				$this->session->set_userdata('sevaid', $this->input->post('sevaid'));
				$data['sevaId'] = $_SESSION['sevaid'];
				$sevaid = $this->input->post('sevaid');
			} else {
				$sevaid = $_SESSION['sevaid'];
				$data['sevaId'] = $_SESSION['sevaid'];
			}
			
			if(@$_POST['deityid']) {
				unset($_SESSION['deityId']);
				$data['deityid'] = $this->input->post('deityid');
				$deityid = $this->input->post('deityid');
			}
			
			if(@$_SESSION['deityId'] == "") {
				$this->session->set_userdata('deityId', $this->input->post('deityid'));
				$data['deityid'] = $_SESSION['deityId'];
				$deityid = $this->input->post('deityid');
			} else {
				$deityid = $_SESSION['deityId'];
				$data['deityid'] = $_SESSION['deityId'];
			}
			
			$condCnt2 = "";//JOEL SIR 1/4
			if(@$radioAllOpt == "allDeity") {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryStringOne = "";
					$bookQueryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
							$bookQueryString .= "DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE=1";
							$queryStringOne .= "DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
						} else {
							$queryString .= " or DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
							$bookQueryString .= " or DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE=1";
							$queryStringOne .= " or DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
						}
					}
					$conditionTwo = $queryString;
					$condCnt2 = $queryString;//JOEL SIR 1/4
					$bookCondition = $bookQueryString;
					$conditionThree = $queryStringOne;
				} else {
					$conditionTwo = array('DEITY_SEVA_OFFERED.SO_DATE' => $date, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
					$condCnt2 = " DEITY_SEVA_OFFERED.SO_DATE = '".$date."' AND DEITY_RECEIPT.RECEIPT_ACTIVE = 1 ";//JOEL SIR 1/4
					$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => $date, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1);
					$conditionThree = array('DEITY_SEVA_OFFERED.SO_DATE' => $date, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
				}
			} else {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryStringOne = "";
					$bookQueryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							if($sevaid != "All") {
								$queryString .= "DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_SEVA_ID ='".$sevaid."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
								$bookQueryString .= "DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_SEVA_ID ='".$sevaid."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE=1";
								$queryStringOne .= "DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$deityid."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
							} else {
								$queryString .= "DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$deityid."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
								$bookQueryString .= "DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$deityid."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE=1";
								$queryStringOne .= "DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$deityid."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
							}
						} else {
							if($sevaid != "All") {
								$queryString .= " or DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_SEVA_ID ='".$sevaid."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
								$bookQueryString .= " or DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_SEVA_ID ='".$sevaid."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE=1";
								$queryStringOne .= " or DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$deityid."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
							} else {
								$queryString .= " or DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$deityid."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
								$bookQueryString .= " or DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$deityid."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE=1";
								$queryStringOne .= " or DEITY_SEVA_OFFERED.SO_DATE='".$allDates1[$i]."' and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$deityid."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
							}
						}
					}
					$conditionTwo = $queryString;
					$condCnt2 = $queryString;//JOEL SIR 1/4
					$bookCondition = $bookQueryString;
					$conditionThree = $queryStringOne;
				} else {
					if($sevaid != "All") {
						$conditionTwo = array('DEITY_SEVA_OFFERED.SO_SEVA_ID' => $sevaid, 'DEITY_SEVA_OFFERED.SO_DATE' => $date, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
						$condCnt2 = " DEITY_SEVA_OFFERED.SO_SEVA_ID = ".$sevaid." AND DEITY_SEVA_OFFERED.SO_DATE = '".$date."' AND DEITY_RECEIPT.RECEIPT_ACTIVE = 1 ";//JOEL SIR 1/4
						$bookCondition = array('DEITY_SEVA_OFFERED.SO_SEVA_ID' => $sevaid, 'DEITY_SEVA_OFFERED.SO_DATE' => $date, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1);
						$conditionThree = array('DEITY_SEVA_OFFERED.SO_DEITY_ID' => $deityid, 'DEITY_SEVA_OFFERED.SO_DATE' => $date, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
					} else {
						$conditionTwo = array('DEITY_SEVA_OFFERED.SO_DEITY_ID' => $deityid, 'DEITY_SEVA_OFFERED.SO_DATE' => $date, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
						$condCnt2 = " DEITY_SEVA_OFFERED.SO_DEITY_ID = ".$deityid." AND DEITY_SEVA_OFFERED.SO_DATE = '".$date."' AND DEITY_RECEIPT.RECEIPT_ACTIVE = 1 ";//JOEL SIR 1/4
						$bookCondition = array('DEITY_SEVA_OFFERED.SO_DEITY_ID' => $deityid, 'DEITY_SEVA_OFFERED.SO_DATE' => $date, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1);
						$conditionThree = array('DEITY_SEVA_OFFERED.SO_DEITY_ID' => $deityid, 'DEITY_SEVA_OFFERED.SO_DATE' => $date, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
					}
				}
			}
			
			//Get Deity
			$condition = array('DEITY_ACTIVE' => 1); 
			$data['deity'] = $this->obj_report->get_all_field_deity($condition);
			
			//Get Sevas On Deity
			$data['sevas'] = json_encode($this->obj_report->get_all_deity_seva_report($conditionThree,$bookCondition));
			$data['report_details'] = $this->obj_report->get_all_field_deity_seva_report($conditionTwo,'','',10,$start, $bookCondition);
			$data['Count'] = $this->obj_report->count_actual_sevas_for_deity_seva_report($condCnt2,"","",$bookCondition); //JOEL SIR 1/4
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/deity_seva_date_change_report';
			$config['total_rows'] = $this->obj_report->count_rows_deity_seva_report($conditionTwo,"","",$bookCondition);
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
			//$this->output->enable_profiler(true);
			
			$this->load->view('header', $data);
			$this->load->view('deity_sevas_report');
			$this->load->view('footer_home');
		}
		
		//SEVA REPORT
		function deity_sevas_report($start = 0) { 
			//Unset Session
			unset($_SESSION['date']);
			unset($_SESSION['deityId']);
			unset($_SESSION['sevaid']);
			//Radio Option
			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			//Radio Option For Deity
			$radioAllOpt = @$_POST['radioAllOpt'];
			if($radioAllOpt == "")
				$radioAllOpt = "allDeity";
			
			$data['radioAllOpt'] = $radioAllOpt;
			
			//For Menu Selection
			$data['whichTab'] = "report";
			$data['date'] = date('d-m-Y');
			$data['Filter'] = "No";
			
			//Get Deity
			$condition = array('DEITY_ACTIVE' => 1); 
			$data['deity'] = $this->obj_report->get_all_field_deity($condition);
			
			//Get Sevas On Deity
			$conditionOne = array('SO_IS_SEVA'=>1,'DEITY_SEVA_OFFERED.SO_DATE' => date('d-m-Y'), 'DEITY_SEVA_OFFERED.SO_DEITY_ID' => $data['deity'][0]->DEITY_ID, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
			$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => date('d-m-Y'), 'DEITY_SEVA_OFFERED.RECEIPT_ID'=> 0,'SB_ACTIVE'=>1); 
			$data['sevas'] = json_encode($this->obj_report->get_all_deity_seva_report($conditionOne,$bookCondition));
			
			//Condition To Get Data
			if($radioAllOpt == "allDeity") {
				$conditionTwo = array('DEITY_SEVA_OFFERED.SO_DATE' => date('d-m-Y'), 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1); 
				
				$cntCond2 = " DEITY_SEVA_OFFERED.SO_DATE = '".date('d-m-Y')."' AND DEITY_RECEIPT.RECEIPT_ACTIVE = 1 ";

				$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => date('d-m-Y'), 'DEITY_SEVA_OFFERED.RECEIPT_ID'=> 0,'SB_ACTIVE'=>1); 
			} else {
				$conditionTwo = array('DEITY_SEVA_OFFERED.SO_DATE' => date('d-m-Y'), 'DEITY_SEVA_OFFERED.SO_DEITY_ID' => $data['deity'][0]->DEITY_ID, 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
				
				$cntCond2 = " DEITY_SEVA_OFFERED.SO_DATE = '".date('d-m-Y')."' AND DEITY_SEVA_OFFERED.SO_DEITY_ID = ".$data['deity'][0]->DEITY_ID."  AND DEITY_RECEIPT.RECEIPT_ACTIVE = 1 "; 

				$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => date('d-m-Y'), 'DEITY_SEVA_OFFERED.SO_DEITY_ID' => $data['deity'][0]->DEITY_ID, 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1);
			}
			$data['report_details'] = $this->obj_report->get_all_field_deity_seva_report($conditionTwo,'','',10,$start,$bookCondition);
			
			$data['Count'] = $this->obj_report->count_actual_sevas_for_deity_seva_report($cntCond2,"","",$bookCondition); 
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/deity_sevas_report';
			$config['total_rows'] = $this->obj_report->count_rows_deity_seva_report($conditionTwo,"","",$bookCondition);
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
			
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Deity_Seva_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('deity_sevas_report');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FOR DISPLAY SUMMARY SEVAS DETAILS ON FILTER
		function get_filter_change_sevas_details($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link3'] = $actual_link;
			
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['sevaId']) {
				unset($_SESSION['sevaId']);
				$data['sevaId'] = $this->input->post('sevaId');
				$sevaId = $this->input->post('sevaId');
			}
			
			if(@$_SESSION['sevaId'] == "") {
				$this->session->set_userdata('sevaId', $this->input->post('sevaId'));
				$data['sevaId'] = $_SESSION['sevaId'];
				$sevaId = $this->input->post('sevaId');
			} else {
				$sevaId = $_SESSION['sevaId'];
				$data['sevaId'] = $_SESSION['sevaId'];
			}
			
			if(@$_POST['sevaName']) {
				unset($_SESSION['sevaName']);
				$data['sevaName'] = $this->input->post('sevaName');
				$sevaName = $this->input->post('sevaName');
			}
			
			if(@$_SESSION['sevaName'] == "") {
				$this->session->set_userdata('sevaName', $this->input->post('sevaName'));
				$data['sevaName'] = $_SESSION['sevaName'];
				$sevaName = $this->input->post('sevaName');
			} else {
				$sevaName = $_SESSION['sevaName'];
				$data['sevaName'] = $_SESSION['sevaName'];
			}

			if(@$_POST['summaryType']) {
				$summaryType =  $this->input->post('summaryType');
				$_SESSION['summaryType'] = $summaryType;
			} else {
				$summaryType = @$_SESSION['summaryType'];
			}
			$data['summaryTypeVal'] = $summaryType;
			if($summaryType == "onlyNormalSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID != 7 OR SEVA_BOOKING.SB_CATEGORY_ID != 7)";
			} else if ($summaryType == "onlyShashwathSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 OR SEVA_BOOKING.SB_CATEGORY_ID = 7)";
			} else {
				$summaryCondition = "";
			}
			
			if(@$radioOpt == "multiDate") {
				$data['Count'] = $this->obj_report->count_sevas_summary_details_period($fromDate,$toDate,$sevaId,$summaryCondition );
				$data['report_details'] = $this->obj_report->get_all_field_sevas_summary_details_period($fromDate,$toDate,$sevaId,10,$start,$summaryCondition );
			} else {
				$data['Count'] = $this->obj_report->count_sevas_summary_details($date,$sevaId,$summaryCondition );
				$data['report_details'] = $this->obj_report->get_all_field_sevas_summary_details($date,$sevaId,10,$start,$summaryCondition );
			}
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/get_filter_change_sevas_details';
			if(@$radioOpt == "multiDate") {
				$config['total_rows'] = $this->obj_report->count_sevas_summary_details_period($fromDate,$toDate,$sevaId,$summaryCondition );
			} else {
				$config['total_rows'] = $this->obj_report->count_sevas_summary_details($date,$sevaId,$summaryCondition);
			}
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
			//pagination ends
			
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Deity_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('sevas_summary_details');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		
		//FOR DISPLAY SUMMARY EVENT SEVAS DETAILS ON FILTER
		function get_filter_change_event_sevas_details($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link3'] = $actual_link;

			$this->db->select('*')->from('event');
			$this->db->where('ET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['ET_ID'];
			
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['sevaId']) {
				unset($_SESSION['sevaId']);
				$data['sevaId'] = $this->input->post('sevaId');
				$sevaId = $this->input->post('sevaId');
			}
			
			if(@$_SESSION['sevaId'] == "") {
				$this->session->set_userdata('sevaId', $this->input->post('sevaId'));
				$data['sevaId'] = $_SESSION['sevaId'];
				$sevaId = $this->input->post('sevaId');
			} else {
				$sevaId = $_SESSION['sevaId'];
				$data['sevaId'] = $_SESSION['sevaId'];
			}
			
			if(@$_POST['sevaName']) {
				unset($_SESSION['sevaName']);
				$data['sevaName'] = $this->input->post('sevaName');
				$sevaName = $this->input->post('sevaName');
			}
			
			if(@$_SESSION['sevaName'] == "") {
				$this->session->set_userdata('sevaName', $this->input->post('sevaName'));
				$data['sevaName'] = $_SESSION['sevaName'];
				$sevaName = $this->input->post('sevaName');
			} else {
				$sevaName = $_SESSION['sevaName'];
				$data['sevaName'] = $_SESSION['sevaName'];
			}
			
			if(@$radioOpt == "multiDate") {
				$data['Count'] = $this->obj_report->count_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,$eId);
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,10,$start,$eId);
			} else {
				$data['Count'] = $this->obj_report->count_event_sevas_summary_details($date,$sevaId,$eId);
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_details($date,$sevaId,10,$start,$eId);
			}
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/get_filter_change_sevas_details';
			if(@$radioOpt == "multiDate") {
				$config['total_rows'] = $this->obj_report->count_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,$eId);
			} else {
				$config['total_rows'] = $this->obj_report->count_event_sevas_summary_details($date,$sevaId,$eId);
			}
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
			//pagination ends
			
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Event_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('event_sevas_summary_details');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		//FOR DISPLAY SUMMARY SEVAS DETAILS
		function sevas_summary_details($start=0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link3'] = $actual_link;
			
			//For Menu Selection
			$data['whichTab'] = "report";
			if(@$_POST['refresh'] == "") {			
				//Radio Option
				if(isset($_POST['radioOpt'])) {
					$radioOpt = @$_POST['radioOpt'];
					$_SESSION['radioOpt'] = $radioOpt;
				} else {
					$radioOpt = $_SESSION['radioOpt'];
				}
				
				$data['radioOpt'] = $radioOpt;
				
				if(isset($_POST['fromDates'])) {
					$fromDate = @$_POST['fromDates'];
					$toDate = @$_POST['toDates'];
					$_SESSION['fromDates'] = $fromDate;
					$_SESSION['toDates'] = $toDate;
				} else {
					$fromDate = $_SESSION['fromDates'];
					$toDate = $_SESSION['toDates'];
				}
				
				$data['fromDate'] = $fromDate;
				$data['toDate'] = $toDate;
			}  else {
				$_SESSION['radioOpt'] = "date";
				unset($_SESSION['fromDates']);
				unset($_SESSION['toDates']);
				$data['radioOpt'] = "date";
				$radioOpt = "date";
				$_POST['tdate'] = date('d-m-Y');
			}
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['sevaId']) {
				unset($_SESSION['sevaId']);
				$data['sevaId'] = $this->input->post('sevaId');
				$sevaId = $this->input->post('sevaId');
			}
			
			if(@$_SESSION['sevaId'] == "") {
				$this->session->set_userdata('sevaId', $this->input->post('sevaId'));
				$data['sevaId'] = $_SESSION['sevaId'];
				$sevaId = $this->input->post('sevaId');
			} else {
				$sevaId = $_SESSION['sevaId'];
				$data['sevaId'] = $_SESSION['sevaId'];
			}
			
			if(@$_POST['sevaName']) {
				unset($_SESSION['sevaName']);
				$data['sevaName'] = $this->input->post('sevaName');
				$sevaName = $this->input->post('sevaName');
			}
			
			if(@$_SESSION['sevaName'] == "") {
				$this->session->set_userdata('sevaName', $this->input->post('sevaName'));
				$data['sevaName'] = $_SESSION['sevaName'];
				$sevaName = $this->input->post('sevaName');
			} else {
				$sevaName = $_SESSION['sevaName'];
				$data['sevaName'] = $_SESSION['sevaName'];
			}

			if(@$_POST['summaryType']) {
				$summaryType =  $this->input->post('summaryType');
				$_SESSION['summaryType'] = $summaryType;
			} else {
				$summaryType = @$_SESSION['summaryType'];
			}
			$data['summaryTypeVal'] = $summaryType;
			if($summaryType == "onlyNormalSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID != 7 OR SEVA_BOOKING.SB_CATEGORY_ID != 7)";
			} else if ($summaryType == "onlyShashwathSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 OR SEVA_BOOKING.SB_CATEGORY_ID = 7)";
			} else {
				$summaryCondition = "";
			}
			
			if(@$radioOpt == "multiDate") {
				$data['Count'] = $this->obj_report->count_sevas_summary_details_period($fromDate,$toDate,$sevaId,$summaryCondition);
				$data['report_details'] = $this->obj_report->get_all_field_sevas_summary_details_period($fromDate,$toDate,$sevaId,10,$start,$summaryCondition);
			} else {
				$data['fromDate'] = "";
				$data['toDate'] = "";
				$data['Count'] = $this->obj_report->count_sevas_summary_details($date,$sevaId,$summaryCondition);
				$data['report_details'] = $this->obj_report->get_all_field_sevas_summary_details($date,$sevaId,10,$start,$summaryCondition);
			}
			
			//pagination starts
			$this->load->library('pagination');
			if(@$radioOpt == "multiDate") {
				$config['base_url'] = base_url().'Report/get_filter_change_sevas_details';
				$config['total_rows'] = $this->obj_report->count_sevas_summary_details_period($fromDate,$toDate,$sevaId,$summaryCondition);
			} else {
				$config['base_url'] = base_url().'Report/sevas_summary_details';
				$config['total_rows'] = $this->obj_report->count_sevas_summary_details($date,$sevaId,$summaryCondition);
			}
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
			//pagination ends
			
			if(isset($_SESSION['Deity_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('sevas_summary_details');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		
		//FOR DISPLAY EVENT SEVA DETAILS
		function event_sevas_summary_details($start=0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link3'] = $actual_link;
			
			$this->db->select('*')->from('event');
			$this->db->where('ET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['ET_ID'];
			
			//For Menu Selection
			$data['whichTab'] = "report";
			if(@$_POST['refresh'] == "") {			
				//Radio Option
				if(isset($_POST['radioOpt'])) {
					$radioOpt = @$_POST['radioOpt'];
					$_SESSION['radioOpt'] = $radioOpt;
				} else {
					$radioOpt = $_SESSION['radioOpt'];
				}
				
				$data['radioOpt'] = $radioOpt;
				
				if(isset($_POST['fromDates'])) {
					$fromDate = @$_POST['fromDates'];
					$toDate = @$_POST['toDates'];
					$_SESSION['fromDates'] = $fromDate;
					$_SESSION['toDates'] = $toDate;
				} else {
					$fromDate = $_SESSION['fromDates'];
					$toDate = $_SESSION['toDates'];
				}
				
				$data['fromDate'] = $fromDate;
				$data['toDate'] = $toDate;
			}  else {
				$_SESSION['radioOpt'] = "date";
				unset($_SESSION['fromDates']);
				unset($_SESSION['toDates']);
				$data['radioOpt'] = "date";
				$radioOpt = "date";
				$_POST['tdate'] = date('d-m-Y');
			}
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['sevaId']) {
				unset($_SESSION['sevaId']);
				$data['sevaId'] = $this->input->post('sevaId');
				$sevaId = $this->input->post('sevaId');
			}
			
			if(@$_SESSION['sevaId'] == "") {
				$this->session->set_userdata('sevaId', $this->input->post('sevaId'));
				$data['sevaId'] = $_SESSION['sevaId'];
				$sevaId = $this->input->post('sevaId');
			} else {
				$sevaId = $_SESSION['sevaId'];
				$data['sevaId'] = $_SESSION['sevaId'];
			}
			
			if(@$_POST['sevaName']) {
				unset($_SESSION['sevaName']);
				$data['sevaName'] = $this->input->post('sevaName');
				$sevaName = $this->input->post('sevaName');
			}
			
			if(@$_SESSION['sevaName'] == "") {
				$this->session->set_userdata('sevaName', $this->input->post('sevaName'));
				$data['sevaName'] = $_SESSION['sevaName'];
				$sevaName = $this->input->post('sevaName');
			} else {
				$sevaName = $_SESSION['sevaName'];
				$data['sevaName'] = $_SESSION['sevaName'];
			}
			
			if(@$radioOpt == "multiDate") {
				$data['Count'] = $this->obj_report->count_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,$eId);
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,10,$start,$eId);
			} else {
				$data['fromDate'] = "";
				$data['toDate'] = "";
				$data['Count'] = $this->obj_report->count_event_sevas_summary_details($date,$sevaId,$eId);
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_details($date,$sevaId,10,$start,$eId);
			}
			
			//pagination starts
			$this->load->library('pagination');
			if(@$radioOpt == "multiDate") {
				$config['base_url'] = base_url().'Report/get_filter_change_sevas_details';
				$config['total_rows'] = $this->obj_report->count_event_sevas_summary_details_period($fromDate,$toDate,$sevaId,$eId);
			} else {
				$config['base_url'] = base_url().'Report/sevas_summary_details';
				$config['total_rows'] = $this->obj_report->count_event_sevas_summary_details($date,$sevaId,$eId);
			}
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
			//pagination ends
			
			if(isset($_SESSION['Event_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('event_sevas_summary_details');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FOR DISPLAY SUMMARY SEVA
		function summary_sevas_on_deity() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link2'] = $actual_link;
			
			//For Menu Selection
			$data['whichTab'] = "report";
			if(@$_POST['refresh'] == "") {
				//Radio Option
				if(isset($_POST['radioOpt'])) {
					$radioOpt = @$_POST['radioOpt'];
					$_SESSION['radioOpt'] = $radioOpt;
				} else {
					$radioOpt = $_SESSION['radioOpt'];
				}
				
				$data['radioOpt'] = $radioOpt;
				
				if(isset($_POST['fromDates'])) {
					$fromDate = @$_POST['fromDates'];
					$toDate = @$_POST['toDates'];
					$_SESSION['fromDates'] = $fromDate;
					$_SESSION['toDates'] = $toDate;
				} else {
					$fromDate = @$_SESSION['fromDates'];
					$toDate = @$_SESSION['toDates'];
				}
				
				$data['fromDate'] = $fromDate;
				$data['toDate'] = $toDate;
			} else {
				$_SESSION['Ref'] = "Refresh";
				$_SESSION['radioOpt'] = "date";
				unset($_SESSION['fromDates']);
				unset($_SESSION['toDates']);
				$radioOpt = "date";
				$data['radioOpt'] = "date";
				$_POST['tdate'] = date('d-m-Y');
			}	
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['deityId']) {
				unset($_SESSION['deityId']);
				$data['deityId'] = $this->input->post('deityId');
				$deityId = $this->input->post('deityId');
			}
			
			if(@$_SESSION['deityId'] == "") {
				$this->session->set_userdata('deityId', $this->input->post('deityId'));
				$data['deityId'] = $_SESSION['deityId'];
				$deityId = $this->input->post('deityId');
			} else {
				$deityId = $_SESSION['deityId'];
				$data['deityId'] = $_SESSION['deityId'];
			}
			
			if(@$_POST['deityName']) {
				unset($_SESSION['deityName']);
				$data['deityName'] = $this->input->post('deityName');
				$deityName = $this->input->post('deityName');
			}
			
			if(@$_SESSION['deityName'] == "") {
				$this->session->set_userdata('deityName', $this->input->post('deityName'));
				$data['deityName'] = $_SESSION['deityName'];
				$deityName = $this->input->post('deityName');
			} else {
				$deityName = $_SESSION['deityName'];
				$data['deityName'] = $_SESSION['deityName'];
			}

			if(@$_POST['summaryType']) {
				$summaryType =  $this->input->post('summaryType');
				$_SESSION['summaryType'] = $summaryType;
			} else {
				$summaryType = @$_SESSION['summaryType'];
			}
			$data['summaryTypeVal'] = $summaryType;
			if($summaryType == "onlyNormalSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID != 7 OR SEVA_BOOKING.SB_CATEGORY_ID != 7)";
			} else if ($summaryType == "onlyShashwathSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 OR SEVA_BOOKING.SB_CATEGORY_ID = 7)";
			} else {
				$summaryCondition = "";
			}
			
			if(@$radioOpt == "multiDate") {
				$data['report_details'] = $this->obj_report->get_all_field_sevas_summary_report_period($fromDate,$toDate,$deityId,$summaryCondition);
			} else {
				$data['fromDate'] = "";
				$data['toDate'] = "";
				$data['report_details'] = $this->obj_report->get_all_field_sevas_summary($date,$deityId,$summaryCondition);
			}
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Deity_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('summary_sevas_on_deity');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//EVENT SEVA SUMMARY
		function summary_sevas_on_event() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;

			$this->db->select('*')->from('event');
			$this->db->where('ET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['ET_ID'];
			
			//For Menu Selection
			$data['whichTab'] = "report";
			$data['date'] = date('d-m-Y');
			
			//Radio Option
			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary(date('d-m-Y'),$eId);
			
			if(isset($_SESSION['Event_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('summary_sevas_on_event');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FOR DEITY SEVA SUMMARY FILTER
		function get_filter_change_sevas() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link2'] = $actual_link;
			
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = @$_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = @$_SESSION['fromDates'];
				$toDate = @$_SESSION['toDates'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = @$_SESSION['date'];
				$data['date'] = @$_SESSION['date'];
			}
			
			if(@$_POST['deityId']) {
				unset($_SESSION['deityId']);
				$data['deityId'] = $this->input->post('deityId');
				$deityId = $this->input->post('deityId');
			}
			
			if(@$_SESSION['deityId'] == "") {
				$this->session->set_userdata('deityId', $this->input->post('deityId'));
				$data['deityId'] = $_SESSION['deityId'];
				$deityId = $this->input->post('deityId');
			} else {
				$deityId = @$_SESSION['deityId'];
				$data['deityId'] = @$_SESSION['deityId'];
			}
			
			if(@$_POST['deityName']) {
				unset($_SESSION['deityName']);
				$data['deityName'] = $this->input->post('deityName');
				$deityName = $this->input->post('deityName');
			}
			
			if(@$_SESSION['deityName'] == "") {
				$this->session->set_userdata('deityName', $this->input->post('deityName'));
				$data['deityName'] = $_SESSION['deityName'];
				$deityName = $this->input->post('deityName');
			} else {
				$deityName = @$_SESSION['deityName'];
				$data['deityName'] = @$_SESSION['deityName'];
			}

			if(@$_POST['summaryType']) {
				$summaryType =  $this->input->post('summaryType');
				$_SESSION['summaryType'] = $summaryType;
			} else {
				$summaryType = @$_SESSION['summaryType'];
			}
			$data['summaryTypeVal'] = $summaryType;
			if($summaryType == "onlyNormalSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID != 7 OR SEVA_BOOKING.SB_CATEGORY_ID != 7)";
			} else if ($summaryType == "onlyShashwathSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 OR SEVA_BOOKING.SB_CATEGORY_ID = 7)";
			} else {
				$summaryCondition = "";
			}
			
			if(@$radioOpt == "multiDate") {
				$data['report_details'] = $this->obj_report->get_all_field_sevas_summary_report_period($fromDate,$toDate,$deityId,$summaryCondition);
			} else {
				$data['report_details'] = $this->obj_report->get_all_field_sevas_summary($date,$deityId,$summaryCondition);
			}
			
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Deity_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('summary_sevas_on_deity');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		
		
		//FOR EVENT SEVA SUMMARY FILTER
		function get_filter_change_event() {

			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			$this->db->select('*')->from('event');
			$this->db->where('ET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['ET_ID'];
			
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = @$_SESSION['fromDates'];
				$toDate = @$_SESSION['toDates'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$radioOpt == "multiDate") {
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary_report_period($fromDate,$toDate,$eId);
			} else {
				$data['report_details'] = $this->obj_report->get_all_field_event_sevas_summary($date,$eId);
			}
			
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Event_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('summary_sevas_on_event');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}

		}
		
		//FOR EXCEL FOR DEITY SEVA SUMMARY
		function deity_sevas_summary_excel() {
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['deityId']) {
				unset($_SESSION['deityId']);
				$data['deityId'] = $this->input->post('deityId');
				$deityId = $this->input->post('deityId');
			}
			
			if(@$_SESSION['deityId'] == "") {
				$this->session->set_userdata('deityId', $this->input->post('deityId'));
				$data['deityId'] = $_SESSION['deityId'];
				$deityId = $this->input->post('deityId');
			} else {
				$deityId = $_SESSION['deityId'];
				$data['deityId'] = $_SESSION['deityId'];
			}
			
			if(@$_POST['deityName']) {
				unset($_SESSION['deityName']);
				$data['deityName'] = $this->input->post('deityName');
				$deityName = $this->input->post('deityName');
			}
			
			if(@$_SESSION['deityName'] == "") {
				$this->session->set_userdata('deityName', $this->input->post('deityName'));
				$data['deityName'] = $_SESSION['deityName'];
				$deityName = $this->input->post('deityName');
			} else {
				$deityName = $_SESSION['deityName'];
				$data['deityName'] = $_SESSION['deityName'];
			}

			if(@$_POST['summaryType']) {
				$summaryType =  $this->input->post('summaryType');
				$_SESSION['summaryType'] = $summaryType;
			} else {
				$summaryType = @$_SESSION['summaryType'];
			}
			$data['summaryTypeVal'] = $summaryType;
			if($summaryType == "onlyNormalSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID != 7 OR SEVA_BOOKING.SB_CATEGORY_ID != 7)";
			} else if ($summaryType == "onlyShashwathSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 OR SEVA_BOOKING.SB_CATEGORY_ID = 7)";
			} else {
				$summaryCondition = "";
			}
			
			$header = "";
			$result = "";
			if(@$radioOpt == "multiDate")
				$filename = "Sevas_Summary_Report_ from ".$fromDate." to ".$toDate;  //File Name
			else
				$filename = "Sevas_Summary_Report_".$_POST['dateField'];  //File Name
			$file_ending = "xls";
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";			
			$header .= "SI NO." . "\t";
			$header .= "SEVAS NAME" . "\t";
			$header .= "QUANTITY" . "\t";
			$header .= "AMOUNT" . "\t";
			
			if(@$radioOpt == "multiDate") {
				$res = $this->obj_report->get_all_field_sevas_summary_report_period($fromDate,$toDate,$deityId,$summaryCondition);
			} else {
				$res = $this->obj_report->get_all_field_sevas_summary($date,$deityId,$summaryCondition);
			}
			$Count = 0;$Amount=0;
			for($i = 0; $i < sizeof($res); $i++)
			{
				if($res[$i]['SB_ACTIVE'] != "0") {
					$line = '';    
					$value = "";			
					$value .= ($i+1). "\t";
					$value .= '"' . $res[$i]['SO_SEVA_NAME'] . '"' . "\t";
					$value .= '"' . $res[$i]['QTY'] . '"' . "\t";
					$value .= '"' . $res[$i]['AMOUNT'] . '"' . "\t";
					$Count += $res[$i]['QTY'];
					$Amount += $res[$i]['AMOUNT'];
					$line .= $value;
					$result .= trim($line) . "\n";
				}
			}
			$line = '';  
			$value = "";
			$result .= "\n\t";	
			$value .= "Total \t";
			$value .= '"' . $Count . '"' . "\t";
			$value .= '"' . $Amount . '"' . "\t";
			$line .= $value;
			$result .= trim($line) . "\n";
			$result = str_replace( "\r" , "" , $result );

			print("$header\n$result"); 
		}
		
		//FOR EXCEL FOR DEITY SEVA SUMMARY
		function deity_sevas_summary_report_excel() {
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
			}
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['summaryType']) {
				$summaryType =  $this->input->post('summaryType');
				$_SESSION['summaryType'] = $summaryType;
			} else {
				$summaryType = @$_SESSION['summaryType'];
			}
			$data['summaryTypeVal'] = $summaryType;
			if($summaryType == "onlyNormalSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID != 7 OR SEVA_BOOKING.SB_CATEGORY_ID != 7)";
				$typeVal = "Normal";
			} else if ($summaryType == "onlyShashwathSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 OR SEVA_BOOKING.SB_CATEGORY_ID = 7)";
				$typeVal = "Shashwath";
			} else {
				$summaryCondition = "";
				$typeVal = "All";
			}
			$header = "";
			$result = "";
			if(@$radioOpt == "multiDate")
				$filename = "Deity_Seva_Summary_Report_from ".$_SESSION['fromDates']." to ".$_SESSION['toDates'];  //File Name
			else
				$filename = "Deity_Seva_Summary_Report_".$_POST['dateField'];  //File Name
			
			$file_ending = "xls";
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";	
			$header .= "SI NO." . "\t";
			$header .= "DEITY" . "\t";
			$header .= "SEVAS QUANTITY" . "\t";
			$header .= "AMOUNT" . "\t";
			
			if(@$radioOpt == "multiDate") {
				$res = $this->obj_report->get_all_field_deity_seva_summary_report_period($fromDate,$toDate,$summaryCondition);
			} else {
				$res = $this->obj_report->get_all_field_deity_seva_summary_report($date,$summaryCondition);
			}
			$Count = 0;$Amount=0;
			for($i = 0; $i < sizeof($res); $i++)
			{
				if($res[$i]['SB_ACTIVE'] != "0") {
					$line = '';    
					$value = "";			
					$value .= ($i+1). "\t";
					$value .= '"' . $res[$i]['DEITY_NAME'] . '"' . "\t";
					$value .= '"' . $res[$i]['QTY'] . '"' . "\t";
					$value .= '"' . $res[$i]['AMOUNT'] . '"' . "\t";
					
					$line .= $value;
					$result .= trim($line) . "\n";
					$Count += $res[$i]['QTY'];
					$Amount += $res[$i]['AMOUNT'];
				}
			}
			$line = '';  
			$value = "";
			$result .= "\n\t";	
			$value .= "Total \t";
			$value .= '"' . $Count . '"' . "\t";
			$value .= '"' . $Amount . '"' . "\t";
			$line .= $value;
			$result .= trim($line) . "\n";
			$result = str_replace( "\r" , "" , $result );

			print("$header\n$result"); 
		}
		
		//FOR EXCEL FOR EVENT SEVA SUMMARY
		function event_sevas_summary_report_excel() {
			
			$this->db->select('*')->from('event');
			$this->db->where('ET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['ET_ID'];
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
			}
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			$header = "";
			$result = "";
			if(@$radioOpt == "multiDate")
				$filename = "Event_Seva_Summary_Report_from ".$fromDate." to ".$toDate;  //File Name
			else
				$filename = "Event_Seva_Summary_Report_".$_POST['dateField'];  //File Name
			
			$file_ending = "xls";
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";	
			$header .= "SI NO." . "\t";
			$header .= "EVENT SEVA" . "\t";
			$header .= "SEVAS QUANTITY" . "\t";
			$header .= "AMOUNT" . "\t";
			
			if(@$radioOpt == "multiDate") {
				$res = $this->obj_report->get_all_field_event_sevas_summary_report_period($fromDate,$toDate,$eId);
			} else {
				$res = $this->obj_report->get_all_field_event_sevas_summary($date,$eId);
			}
			
			for($i = 0; $i < sizeof($res); $i++)
			{
				$line = '';    
				$value = "";			
				$value .= ($i+1). "\t";
				$value .= '"' . $res[$i]['ET_SO_SEVA_NAME'] . '"' . "\t";
				$value .= '"' . $res[$i]['QTY'] . '"' . "\t";
				$value .= '"' . $res[$i]['AMOUNT'] . '"' . "\t";

				$line .= $value;
				$result .= trim($line) . "\n";

			}
			$result = str_replace( "\r" , "" , $result );

			print("$header\n$result"); 
		}
		
		//FOR EXCEL FOR DEITY SEVA SUMMARY DETAILS
		function sevas_summary_report_excel() {
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			if(isset($_POST['fromDates'])) { 
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['sevaId']) {
				unset($_SESSION['sevaId']);
				$data['sevaId'] = $this->input->post('sevaId');
				$sevaId = $this->input->post('sevaId');
			}
			
			if(@$_SESSION['sevaId'] == "") {
				$this->session->set_userdata('sevaId', $this->input->post('sevaId'));
				$data['sevaId'] = $_SESSION['sevaId'];
				$sevaId = $this->input->post('sevaId');
			} else {
				$sevaId = $_SESSION['sevaId'];
				$data['sevaId'] = $_SESSION['sevaId'];
			}
			
			if(@$_POST['sevaName']) {
				unset($_SESSION['sevaName']);
				$data['sevaName'] = $this->input->post('sevaName');
				$sevaName = $this->input->post('sevaName');
			}
			
			if(@$_SESSION['sevaName'] == "") {
				$this->session->set_userdata('sevaName', $this->input->post('sevaName'));
				$data['sevaName'] = $_SESSION['sevaName'];
				$sevaName = $this->input->post('sevaName');
			} else {
				$sevaName = $_SESSION['sevaName'];
				$data['sevaName'] = $_SESSION['sevaName'];
			}

			if(@$_POST['summaryType']) {
				$summaryType =  $this->input->post('summaryType');
				$_SESSION['summaryType'] = $summaryType;
			} else {
				$summaryType = @$_SESSION['summaryType'];
			}
			$data['summaryTypeVal'] = $summaryType;
			if($summaryType == "onlyNormalSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID != 7 OR SEVA_BOOKING.SB_CATEGORY_ID != 7)";
			} else if ($summaryType == "onlyShashwathSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 OR SEVA_BOOKING.SB_CATEGORY_ID = 7)";
			} else {
				$summaryCondition = "";
			}
			
			$header = "";
			$result = "";
			if(@$radioOpt == "multiDate")
				$filename = "Sevas_Summary_Details_Report_ from ".$fromDate." to ".$toDate;  //File Name
			else
				$filename = "Sevas_Summary_Details_Report_".$_POST['dateField'];  //File Name
			$file_ending = "xls";
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";			
			$header .= "SI NO." . "\t";
			$header .= "RECEIPT NO." . "\t";
			$header .= "NAME" . "\t";
			$header .= "PHONE NO." . "\t";
			$header .= "AMOUNT" . "\t";
			
			if(@$radioOpt == "multiDate") {
				$res = $this->obj_report->get_all_field_sevas_summary_details_period_excel($fromDate,$toDate,$sevaId,$summaryCondition);
			} else {
				$res = $this->obj_report->get_all_field_sevas_summary_details_excel($date,$sevaId,$summaryCondition);
			}
			$Count = 0;$Amount=0;
			for($i = 0; $i < sizeof($res); $i++)
			{
				if($res[$i]['SB_ACTIVE'] != "0") {
					$line = '';    
					$value = "";			
					$value .= ($i+1). "\t";
					
					if(($res[$i]['SO_IS_BOOKING'] == 0) && ($res[$i]['RECEIPT_ID'] != 0)) {
						$value .= '"' . $res[$i]['RECEIPT_NO'] . '"' . "\t";
						$value .= '"' . $res[$i]['RECEIPT_NAME'] . '"' . "\t";
						$value .= '"' . $res[$i]['RECEIPT_PHONE'] . '"' . "\t";
						$value .= '"' . $res[$i]['SO_PRICE'] . '"' . "\t";
					} else if(($res[$i]['SO_IS_BOOKING'] == 1) && ($res[$i]['RECEIPT_ID'] != 0)) {
						$value .= '"' . $res[$i]['RECEIPT_NO'] . '"' . "\t";
						$value .= '"' . $res[$i]['RECEIPT_NAME'] . '"' . "\t";
						$value .= '"' . $res[$i]['RECEIPT_PHONE'] . '"' . "\t";
						$value .= '"' . $res[$i]['SO_PRICE'] . '"' . "\t";
					} else {
						$value .= '"' . $res[$i]['SB_NO'] . '"' . "\t";
						$value .= '"' . $res[$i]['SB_NAME'] . '"' . "\t";
						$value .= '"' . $res[$i]['SB_PHONE'] . '"' . "\t";
						$value .= '"' . $res[$i]['SO_PRICE'] . '"' . "\t";
					}
					$Count ++;
					$Amount += $res[$i]['SO_PRICE'];
					$line .= $value;
					$result .= trim($line) . "\n";
				}
			}
			$line = '';  
			$value = "";
			$result .= "\n\t\t\t";	
			$value .= "Total \t";
			$value .= '"' . $Amount . '"' . "\t";
			$line .= $value;
			$result .= trim($line) . "\n";
			$result = str_replace( "\r" , "" , $result );

			print("$header\n$result"); 
		}
		
		//FOR EXCEL FOR EVENT SEVA SUMMARY DETAILS
		function event_sevas_summary_report_details_excel() {
			
			$this->db->select('*')->from('event');
			$this->db->where('ET_ACTIVE',1);
			$query = $this->db->get();
			$etId= $query->result('array');
			$eId = $etId[0]['ET_ID'];
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			if(isset($_POST['fromDates'])) { 
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDates'];
				$toDate = $_SESSION['toDates'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['sevaId']) {
				unset($_SESSION['sevaId']);
				$data['sevaId'] = $this->input->post('sevaId');
				$sevaId = $this->input->post('sevaId');
			}
			
			if(@$_SESSION['sevaId'] == "") {
				$this->session->set_userdata('sevaId', $this->input->post('sevaId'));
				$data['sevaId'] = $_SESSION['sevaId'];
				$sevaId = $this->input->post('sevaId');
			} else {
				$sevaId = $_SESSION['sevaId'];
				$data['sevaId'] = $_SESSION['sevaId'];
			}
			
			if(@$_POST['sevaName']) {
				unset($_SESSION['sevaName']);
				$data['sevaName'] = $this->input->post('sevaName');
				$sevaName = $this->input->post('sevaName');
			}
			
			if(@$_SESSION['sevaName'] == "") {
				$this->session->set_userdata('sevaName', $this->input->post('sevaName'));
				$data['sevaName'] = $_SESSION['sevaName'];
				$sevaName = $this->input->post('sevaName');
			} else {
				$sevaName = $_SESSION['sevaName'];
				$data['sevaName'] = $_SESSION['sevaName'];
			}
			
			$header = "";
			$result = "";
			if(@$radioOpt == "multiDate")
				$filename = "Sevas_Summary_Details_Report_ from ".$fromDate." to ".$toDate;  //File Name
			else
				$filename = "Sevas_Summary_Details_Report_".$_POST['dateField'];  //File Name
			$file_ending = "xls";
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";		
			$header .= "SI NO." . "\t";
			$header .= "RECEIPT NO." . "\t";
			$header .= "NAME" . "\t";
			$header .= "PHONE NO." . "\t";
			$header .= "AMOUNT" . "\t";
			
			if(@$radioOpt == "multiDate") {
				$res = $this->obj_report->get_all_field_event_sevas_summary_details_period_excel($fromDate,$toDate,$sevaId,$eId);
			} else {
				$res = $this->obj_report->get_all_field_event_sevas_summary_details_excel($date,$sevaId,$eId);
			}
			
			for($i = 0; $i < sizeof($res); $i++)
			{
				
				$line = '';    
				$value = "";			
				$value .= ($i+1). "\t";
				$value .= '"' . $res[$i]['ET_RECEIPT_NO'] . '"' . "\t";
				$value .= '"' . $res[$i]['ET_RECEIPT_NAME'] . '"' . "\t";
				$value .= '"' . $res[$i]['ET_RECEIPT_PHONE'] . '"' . "\t";
				$value .= '"' . $res[$i]['ET_SO_PRICE'] . '"' . "\t";				
				$line .= $value;
				$result .= trim($line) . "\n";
				
			}
			$result = str_replace( "\r" , "" , $result );

			print("$header\n$result"); 
		}
		
		
		
		
		
		
		
		
		
		
		
		//FOR DEITY SEVA SUMMARY
		function deity_seva_summary() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			//For Menu Selection
			$data['whichTab'] = "report";
			$data['date'] = date('d-m-Y');
			
			//Radio Option
			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			$data['report_details'] = $this->obj_report->get_all_field_deity_seva_summary_report(date('d-m-Y'));
			
			if(isset($_SESSION['Deity_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('deity_seva_summary');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FOR DEITY SEVA SUMMARY WITHOUT REFRESH
		function deity_seva_summary_Without_Refresh() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = @$_SESSION['fromDates'];
				$toDate = @$_SESSION['toDates'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}

			if(@$_POST['summaryType']) {
				$summaryType =  $this->input->post('summaryType');
				$_SESSION['summaryType'] = $summaryType;
			} else {
				$summaryType = @$_SESSION['summaryType'];
			}
			$data['summaryTypeVal'] = $summaryType;
			if($summaryType == "onlyNormalSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID != 7 OR SEVA_BOOKING.SB_CATEGORY_ID != 7)";
			} else if ($summaryType == "onlyShashwathSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 OR SEVA_BOOKING.SB_CATEGORY_ID = 7)";
			} else {
				$summaryCondition = "";
			}
			
			if(@$radioOpt == "multiDate") {
				$data['report_details'] = $this->obj_report->get_all_field_deity_seva_summary_report_period($fromDate,$toDate,$summaryCondition);
			} else {
				$data['fromDate'] = "";
				$data['toDate'] = "";
				$data['report_details'] = $this->obj_report->get_all_field_deity_seva_summary_report($date,$summaryCondition);
			}
			
			if(isset($_SESSION['Deity_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('deity_seva_summary');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FOR DEITY SEVA SUMMARY FILTER
		function get_filter_change() {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDates'])) {
				$fromDate = @$_POST['fromDates'];
				$toDate = @$_POST['toDates'];
				$_SESSION['fromDates'] = $fromDate;
				$_SESSION['toDates'] = $toDate;
			} else {
				$fromDate = @$_SESSION['fromDates'];
				$toDate = @$_SESSION['toDates'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}

			if(@$_POST['summaryType']) {
				$summaryType =  $this->input->post('summaryType');
				$_SESSION['summaryType'] = $summaryType;
			} else {
				$summaryType = @$_SESSION['summaryType'];
			}
			$data['summaryTypeVal'] = $summaryType;
			if($summaryType == "onlyNormalSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID != 7 OR SEVA_BOOKING.SB_CATEGORY_ID != 7)";
			} else if ($summaryType == "onlyShashwathSeva"){
				$summaryCondition = "AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 OR SEVA_BOOKING.SB_CATEGORY_ID = 7)";
			} else {
				$summaryCondition = "";
			}
				
			if(@$radioOpt == "multiDate") {
				$data['report_details'] = $this->obj_report->get_all_field_deity_seva_summary_report_period($fromDate,$toDate,$summaryCondition);
			} else {
				$data['report_details'] = $this->obj_report->get_all_field_deity_seva_summary_report($date,$summaryCondition);
			}
			
			//$this->output->enable_profiler(true);
			
			if(isset($_SESSION['Deity_Seva_Summary'])) {
				$this->load->view('header', $data);
				$this->load->view('deity_seva_summary');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FOR EXCEL FOR RECEIPT
		//Above code commented while merging interns code
		function event_receipt_report_excel() {
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}

			if(isset($_POST['allDates'])) {
				$allDates= @$_POST['allDates'];
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			if(isset($_POST['payMode'])) {
				$paymentMode= @$_POST['payMode'];
			} else {
				$paymentMode = $_SESSION['payMode'];
			}
			
			$header = "";
			$result = "";
			if(@$radioOpt == "multiDate")
				$filename = "Current_Event_Receipt_Report from ".$_SESSION['fromDate']." to ".$_SESSION['toDate'];  //File Name
			else
				$filename = "Current_Event_Receipt_Report_".$_POST['dateField'];  //File Name
			$file_ending = "xls";
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			//header info for browser
			$data['event'] = $this->obj_events->getEvents();
			$_SESSION['event'] = $data['event']['ET_NAME'];
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";	
			$header .= "$_SESSION[event]" ."\n";						
			$header .= "SI NO." . "\t";
			$header .= "RECEIPT NO." . "\t";
			$header .= "RT DATE" . "\t";
			$header .= "RT TYPE" . "\t";
			$header .= "NAME" . "\t";
			$header .= "ESTIMATED PRICE" . "\t";
			$header .= "DESCRIPTION" . "\t";
			$header .= "QUANTITY" . "\t";
			$header .= "MODE" . "\t";
			$header .= "AMOUNT" . "\t";	
			$header .= "POSTAGE" . "\t";	
			$header .= "TOTAL" . "\t";	
			$header .= "STATUS" . "\t";	
			$header .= "Payment Notes" . "\t";	
			$header .= "AUTHORIZED STATUS" . "\t";	
			$header .= "ENTERED BY" . "\t";

			if($_POST['dateField'] != "" && $_POST['payMode'] == "All") {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1";
							$queryString1 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=0";
						} else {
							$queryString .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1";
							$queryString1 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=0";
						}
					}
					$condition = $queryString;
					$conditionOne = $queryString1;
				} else {
					$condition= array('ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $_POST['dateField'],'ET_RECEIPT_ACTIVE'=>1);
					$conditionOne= array('ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $_POST['dateField'],'ET_RECEIPT_ACTIVE'=>0);
				}
				$res = $this->obj_report->get_all_field_event_receipt_excel($condition);
				$res1 = $this->obj_report->get_all_field_event_receipt_excel($conditionOne);
			} else {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
							$queryString1 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=0 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						} else {
							$queryString .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1  and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
							$queryString1 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1  and ET_RECEIPT_ACTIVE=0 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						}
					}
					$condition= $queryString;
					$conditionOne= $queryString1;
				} else {
					$condition= array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'ET_RECEIPT_DATE' => $_POST['dateField'],'ET_RECEIPT_ACTIVE'=>1);
					$conditionOne= array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'ET_RECEIPT_DATE' => $_POST['dateField'],'ET_RECEIPT_ACTIVE'=>0);
				}
				$res = $this->obj_report->get_all_field_event_receipt_excel($condition);
				$res1 = $this->obj_report->get_all_field_event_receipt_excel($conditionOne);
			}

			for($i = 0; $i < sizeof($res); $i++)
			{
				$sum = ($res[$i]->ET_RECEIPT_PRICE) + ($res[$i]->POSTAGE_PRICE);
				$line = '';    
				$value = "";			
				$value .= '"' . ($i+1) . '"' . "\t";
				$value .= '"' . $res[$i]->ET_RECEIPT_NO . '"' . "\t";
				$value .= '"' . $res[$i]->ET_RECEIPT_DATE . '"' . "\t";
				$value .= '"' . $res[$i]->ET_RECEIPT_CATEGORY_TYPE . '"' . "\t";
				$value .= '"' . $res[$i]->ET_RECEIPT_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->IK_APPRX_AMT . '"' . "\t";
				$value .= '"' . $res[$i]->IK_ITEM_DESC . '"' . "\t";
				// $value .= '"' . $res[$i]->IK_ITEM_QTY . '"' . "\t";
     		 $value .= '"' . $res[$i]->IK_ITEM_QTY . '"' .'' . $res[$i]->IK_ITEM_UNIT . '' . "\t";

				$value .= '"' . $res[$i]->ET_RECEIPT_PAYMENT_METHOD . '"' . "\t";
				if($res[$i]->ET_RECEIPT_CATEGORY_TYPE == "Inkind") {
					$value .= '' . "\t";
				} else {
					$value .= '"' . $res[$i]->ET_RECEIPT_PRICE . '"' . "\t";
				}
				$value .= '"' . $res[$i]->POSTAGE_PRICE . '"' . "\t";
				$value .= '"' . $sum . '"' . "\t";
				$value .= '"' . $res[$i]->PAYMENT_STATUS . '"' . "\t";
				$value .= '"' . $res[$i]->ET_RECEIPT_PAYMENT_METHOD_NOTES . '"' . "\t";
				$value .= '"' . $res[$i]->AUTHORISED_STATUS . '"' . "\t";
				$value .= '"' . $res[$i]->ET_RECEIPT_ISSUED_BY . '"' . "\t";

				$line .= $value;
				$result .= trim($line) . "\n";
			}
			
			$result .= "\n";
			$result .= "Cancelled Receipt:";
			$result .= "\n";
			
			$result .= "SI NO." . "\t";
			$result .= "RECEIPT NO." . "\t";
			$result .= "RT DATE" . "\t";
			$result .= "RT TYPE" . "\t";
			$result .= "NAME" . "\t";
			$result .= "MODE" . "\t";
			$result .= "AMOUNT" . "\t";	
			$result .= "POSTAGE" . "\t";	
			$result .= "TOTAL" . "\t";	
			$result .= "STATUS" . "\t";	
			$result .= "AUTHORIZED STATUS" . "\t";
			$result .= "ENTERED BY" . "\t";
			$result .= "\n";
			
			for($i = 0; $i < sizeof($res1); $i++)
			{
				$sum = ($res1[$i]->ET_RECEIPT_PRICE) + ($res1[$i]->POSTAGE_PRICE);
				$line = '';    
				$value = "";			
				$value .= '"' . ($i+1) . '"' . "\t";
				$value .= '"' . $res1[$i]->ET_RECEIPT_NO . '"' . "\t";
				$value .= '"' . $res1[$i]->ET_RECEIPT_DATE . '"' . "\t";
				$value .= '"' . $res1[$i]->ET_RECEIPT_CATEGORY_TYPE . '"' . "\t";
				$value .= '"' . $res1[$i]->ET_RECEIPT_NAME . '"' . "\t";
				$value .= '"' . $res1[$i]->ET_RECEIPT_PAYMENT_METHOD . '"' . "\t";
				if($res1[$i]->ET_RECEIPT_CATEGORY_TYPE == "Inkind") {
					$value .= '' . "\t";
				} else {
					$value .= '"' . $res1[$i]->ET_RECEIPT_PRICE . '"' . "\t";
				}
				$value .= '"' . $res1[$i]->POSTAGE_PRICE . '"' . "\t";
				$value .= '"' . $sum . '"' . "\t";
				$value .= '"' . $res1[$i]->PAYMENT_STATUS . '"' . "\t";
				$value .= '"' . $res1[$i]->AUTHORISED_STATUS . '"' . "\t";
				$value .= '"' . $res1[$i]->ET_RECEIPT_ISSUED_BY . '"' . "\t";
				$line .= $value;
				$result .= trim($line) . "\n";
			}
			
			$result = str_replace( "\r" , "" , $result );

			print("$header\n$result"); 
		}
		
		//FOR AUCTION REPORT EXCEL
		function event_auction_report_excel() {
			//For Menu Selection
			$data['whichTab'] = "auction";
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			$header = "";
			$result = "";
			$filename = "Saree_Outward_Report_".$date;  //File Name
			$file_ending = "xls";
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";
			$header .= "SI NO." . "\t";
			$header .= "NAME" . "\t";
			$header .= "CATEGORY" . "\t";
			$header .= "PHONE" . "\t";
			$header .= "REFERENCE NO." . "\t";
			$header .= "SAREE DETAILS" . "\t";
			
			$conditionOne = array('AIC_SEVA_DATE' => $date);
			$res = $this->obj_report->get_auction_item_reports($conditionOne);
			
			for($i = 0; $i < sizeof($res); $i++)
			{
				$line = '';    
				$value = "";			
				$value .= '"' . ($i+1) . '"' . "\t";
				$value .= '"' . $res[$i]->AIL_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->AIL_AIC_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->AIL_NUMBER . '"' . "\t";
				$value .= '"' . $res[$i]->ITEM_REF_NO . '"' . "\t";
				$value .= '"' . $res[$i]->AIL_ITEM_DETAILS . '"' . "\t";

				$line .= $value;
				$result .= trim($line) . "\n";
			}
			$result = str_replace( "\r" , "" , $result );

			print("$header\n$result"); 
		}
		
		//FOR AUCTION REPORT EXCEL
		function auction_report_excel() {
			//For Menu Selection
			$data['whichTab'] = "auction";
			
			if(@$_POST['paymentMethod']) {
				unset($_SESSION['paymentMethod']);
				$data['PMode'] = $this->input->post('payMode');
				$paymentMode = $this->input->post('payMode');
			}
			
			if(@$_SESSION['paymentMethod'] == "") {
				$this->session->set_userdata('paymentMethod', $this->input->post('payMode'));
				$data['PMode'] = $_SESSION['paymentMethod'];
				$paymentMode = $this->input->post('payMode');
			} else {
				$paymentMode = $_SESSION['paymentMethod'];
				$data['PMode'] = $_SESSION['paymentMethod'];
			}
			
			if($paymentMode == "All") {
				$conditionOne = array();
				$res = $this->obj_report->get_auction_report_excel($conditionOne);
			} else {
				$conditionOne = array('AR_PAYMENT_MODE' => $paymentMode);
				$res = $this->obj_report->get_auction_report_excel($conditionOne);
			}
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			$header = "";
			$result = "";
			$filename = "Auction_Report_".date('d-m-y');  //File Name
			$file_ending = "xls";
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";		
			$header .= "SI NO." . "\t";
			$header .= "BID REF. NO." . "\t";
			$header .= "ITEM REF. NO." . "\t";
			$header .= "ITEM DETAILS" . "\t";
			$header .= "BIDDER DETAILS" . "\t";
			$header .= "PAYMENT MODE" . "\t";
			$header .= "BID PRICE" . "\t";
			
			for($i = 0; $i < sizeof($res); $i++)
			{
				$line = '';    
				$value = "";			
				$value .= '"' . ($i+1) . '"' . "\t";
				$value .= '"' . $res[$i]->BID_REF_NO . '"' . "\t";
				$value .= '"' . $res[$i]->ITEM_REF_NO . '"' . "\t";
				$value .= '"' . $res[$i]->AR_ITEM_DETAILS . '"' . "\t";
				$value .= '"' . $res[$i]->BIL_ITEM_DETAILS . '"' . "\t";
				$value .= '"' . $res[$i]->AR_PAYMENT_MODE . '"' . "\t";
				$value .= '"' . $res[$i]->AR_BID_PRICE . '"' . "\t";

				$line .= $value;
				$result .= trim($line) . "\n";
			}
			$result = str_replace( "\r" , "" , $result );

			print("$header\n$result"); 
		}
		
		//FOR DATEFIELD AUCTION REPORT
		function get_change_datefield($start = 0) {
			//For Menu Selection
			$data['whichTab'] = "auction";
			$conditionTwo = array('EVENT.ET_ACTIVE' => 1); 
			$data['activeDate'] = $this->obj_admin_settings->get_all_field_event($conditionTwo);
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			$conditionOne = array('AIC_SEVA_DATE' => $date);
			$data['auction_item_report'] = $this->obj_report->get_all_field_auction_item_report($conditionOne,'AIL_AIC_ID','', 10,$start);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/get_change_datefield';
			$config['total_rows'] = $this->obj_report->count_rows_auction_item_report($conditionOne);
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
			
			$this->load->view('header', $data);
			$this->load->view('auction/saree_outward_report');
			$this->load->view('footer_home');
		}
		
		//FOR AUCTION REPORT
		function saree_outward_report($start = 0) {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			//Unset Session
			unset($_SESSION['date']);
			$conditionTwo = array('EVENT.ET_ACTIVE' => 1); 
			$data['activeDate'] = $this->obj_admin_settings->get_all_field_event($conditionTwo);
			//For Menu Selection
			$data['whichTab'] = "auction";
			$data['date'] = date('d-m-Y');
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			$conditionOne = array('AIC_SEVA_DATE' => date('d-m-Y'));
			$data['auction_item_report'] = $this->obj_report->get_all_field_auction_item_report($conditionOne,'AIL_AIC_ID','', 10,$start);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/saree_outward_report';
			$config['total_rows'] = $this->obj_report->count_rows_auction_item_report($conditionOne);
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
			
			if(isset($_SESSION['Saree_Outward_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('auction/saree_outward_report');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FOR AUCTION REPORT ON MODE CHANGE
		function auction_report_payment_mode($start = 0) {
			//For Menu Selection
			$data['whichTab'] = "auction";
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			if(@$_POST['paymentMethod']) {
				unset($_SESSION['paymentMethod']);
				$data['PMode'] = $this->input->post('paymentMethod');
				$paymentMode = $this->input->post('paymentMethod');
			}
			
			if(@$_SESSION['paymentMethod'] == "") {
				$this->session->set_userdata('paymentMethod', $this->input->post('paymentMethod'));
				$data['PMode'] = $_SESSION['paymentMethod'];
				$paymentMode = $this->input->post('paymentMethod');
			} else {
				$paymentMode = $_SESSION['paymentMethod'];
				$data['PMode'] = $_SESSION['paymentMethod'];
			}
			
			if($paymentMode == "All") {
				$conditionOne = array();
				$data['auction_report'] = $this->obj_report->get_auction_report($conditionOne,'','', 10,$start);
			} else {
				$conditionOne = array('AR_PAYMENT_MODE' => $paymentMode);
				$data['auction_report'] = $this->obj_report->get_auction_report($conditionOne,'','', 10,$start);
			}

			//FOR PRICE DISPLAY IN COMBOBOX
			$condt = array();
			$condt1 = array('AR_PAYMENT_MODE' => 'Cash');
			$condt2 = array('AR_PAYMENT_MODE' => 'Cheque');
			$condt3 = array('AR_PAYMENT_MODE' => 'Credit / Debit Card');
			$condt4 = array('AR_PAYMENT_MODE' => 'Direct Credit');
			
			$data['All'] = $this->obj_report->get_total_amount_payment_mode($condt);
			$data['Cash'] = $this->obj_report->get_total_amount_payment_mode($condt1);
			$data['Cheque'] = $this->obj_report->get_total_amount_payment_mode($condt2);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount_payment_mode($condt3);
			$data['Direct'] = $this->obj_report->get_total_amount_payment_mode($condt4);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/auction_report_payment_mode';
			$config['total_rows'] = $this->obj_report->count_rows_auction_report($conditionOne);
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
			
			$this->load->view('header', $data);
			$this->load->view('auction/auction_report');
			$this->load->view('footer_home');
		}
		
		//FOR AUCTION REPORT
		function auction_report($start = 0) {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			//UNSET SESSION
			unset($_SESSION['paymentMethod']);
			
			//For Menu Selection
			$data['whichTab'] = "auction";
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			$conditionOne = array();
			$data['auction_report'] = $this->obj_report->get_auction_report($conditionOne,'','', 10,$start);
			
			//FOR PRICE DISPLAY IN COMBOBOX
			$condt = array();
			$condt1 = array('AR_PAYMENT_MODE' => 'Cash');
			$condt2 = array('AR_PAYMENT_MODE' => 'Cheque');
			$condt3 = array('AR_PAYMENT_MODE' => 'Credit / Debit Card');
			$condt4 = array('AR_PAYMENT_MODE' => 'Direct Credit');
			
			$data['All'] = $this->obj_report->get_total_amount_payment_mode($condt);
			$data['Cash'] = $this->obj_report->get_total_amount_payment_mode($condt1);
			$data['Cheque'] = $this->obj_report->get_total_amount_payment_mode($condt2);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount_payment_mode($condt3);
			$data['Direct'] = $this->obj_report->get_total_amount_payment_mode($condt4);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/auction_report';
			$config['total_rows'] = $this->obj_report->count_rows_auction_report($conditionOne);
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
			
			if(isset($_SESSION['Auction_Item_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('auction/auction_report');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//EVENT RECEIPT REPORT
		//Above code commented while merging interns code
		function event_receipt_report($start = 0) {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');
			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			//unset
			unset($_SESSION['date']);
			unset($_SESSION['paymentMethod']);
			
			//For Menu Selection
			$data['whichTab'] = "report";
			$data['date'] = date('d-m-Y');
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			$condtUser = array('ET_RECEIPT_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
			$_SESSION['users'] = '';
			$data['users'] = $this->obj_report->get_all_users_on_events($condtUser,'ET_RECEIPT_ISSUED_BY','asc');
			
			$conditionOne = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => date('d-m-Y')); //,'ET_RECEIPT_ACTIVE'=>1
			$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
			
			$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
			
			//For Count
			$data['Count'] = $this->obj_report->count_rows_receipt_report($conditionOne);
			
			//for cancelled count
			$conditiontwo = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => date('d-m-Y'),'PAYMENT_STATUS'=>'Cancelled');
			$data['CancelledCount'] = $this->obj_report->cancelled_count_rows_receipt_report($conditiontwo);

			//FOR PRICE IN COMBOBOX
			$condt = array('ET_ACTIVE' => 1,'ET_RECEIPT_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
			$data['All'] = $this->obj_report->get_total_amount($condt);
			$condt1 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cash' ,'ET_RECEIPT_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
			$data['Cash'] = $this->obj_report->get_total_amount($condt1);
			$condt2 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque' ,'ET_RECEIPT_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
			$data['Cheque'] = $this->obj_report->get_total_amount($condt2);
			$condt3 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card' ,'ET_RECEIPT_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount($condt3);
			$condt4 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit' ,'ET_RECEIPT_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
			$data['Direct'] = $this->obj_report->get_total_amount($condt4);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/event_receipt_report';
			$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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
			
			if(isset($_SESSION['Current_Event_Receipt_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('event_receipt_report');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		
		//EVENT RECEIPT REPORT ON CHANGE OF PAYMENT MODE
		function event_report_on_change_payment($start = 0) {
			//For Menu Selection
			$data['whichTab'] = "report";
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['paymentMethod']) {
				unset($_SESSION['paymentMethod']);
				$data['PMode'] = $this->input->post('paymentMethod');
				$paymentMode = $this->input->post('paymentMethod');
			}
			
			if(@$_SESSION['paymentMethod'] == "") {
				$this->session->set_userdata('paymentMethod', $this->input->post('paymentMethod'));
				$data['PMode'] = $_SESSION['paymentMethod'];
				$paymentMode = $this->input->post('paymentMethod');
			} else {
				$paymentMode = $_SESSION['paymentMethod'];
				$data['PMode'] = $_SESSION['paymentMethod'];
			}
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			if($paymentMode != 'All') {
				$conditionOne = array('ET_ACTIVE' => 1,'ET_RECEIPT_PAYMENT_METHOD' => $paymentMode,'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
				$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
				//For Count
				$data['Count'] = $this->obj_report->count_rows_receipt_report($conditionOne);
				
				//FOR PRICE DISPLAY IN COMBOBOX
				$condt = array('ET_ACTIVE' => 1 , 'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
				$condt1 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
				$condt2 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
				$condt3 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
				$condt4 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
			} else {
				$conditionOne = array('ET_ACTIVE' => 1,'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
				$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
				//For Count
				$data['Count'] = $this->obj_report->count_rows_receipt_report($conditionOne);
				
				//FOR PRICE DISPLAY IN COMBOBOX
				$condt = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
				$condt1 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
				$condt2 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
				$condt3 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
				$condt4 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
			}
			
			$data['All'] = $this->obj_report->get_total_amount($condt);
			$data['Cash'] = $this->obj_report->get_total_amount($condt1);
			$data['Cheque'] = $this->obj_report->get_total_amount($condt2);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount($condt3);
			$data['Direct'] = $this->obj_report->get_total_amount($condt4);
			
			$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/event_report_on_change_payment';
			$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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
			
			$this->load->view('header', $data);
			$this->load->view('event_receipt_report');
			$this->load->view('footer_home');
		}
		
		//EVENT RECEIPT REPORT ON CHANGE OF DATEFIELD
		//Above code commented while merging interns code
		function event_report_on_change_date($start = 0) {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['allDates'])) {
				$allDates= @$_POST['allDates'];
				$_SESSION['allDates'] = $allDates;
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			$data['radioOpt'] = $radioOpt;
			$data['allDates'] = $allDates;
			
			if(isset($_POST['fromDate'])) {
				$fromDate = @$_POST['fromDate'];
				$toDate = @$_POST['toDate'];
				$_SESSION['fromDate'] = $fromDate;
				$_SESSION['toDate'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDate'];
				$toDate = $_SESSION['toDate'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			//For Menu Selection
			$data['whichTab'] = "report";
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			//for loading users
			if(@$_POST['users_id']) {
				$_SESSION['users'] = $this->input->post('users_id');
				$data['user'] = $this->input->post('users_id');
				$users = $this->input->post('users_id');
			} 
			
			if(@$_SESSION['users'] == "") {
				$this->session->set_userdata('users', $this->input->post('users_id'));
				$data['user'] = $_SESSION['users'];
				$users = $this->input->post('users_id');
			} else {
				$users = $_SESSION['users'];
				$data['user'] = $_SESSION['users'];
			}
			
			if(@$_POST['paymentMethod']) {
				unset($_SESSION['paymentMethod']);
				$data['PMode'] = $this->input->post('paymentMethod');
				$paymentMode = $this->input->post('paymentMethod');
			}
			
			if(@$_SESSION['paymentMethod'] == "") {
				$this->session->set_userdata('paymentMethod', $this->input->post('paymentMethod'));
				$data['PMode'] = $_SESSION['paymentMethod'];
				$paymentMode = $this->input->post('paymentMethod');
			} else {
				$paymentMode = $_SESSION['paymentMethod'];
				$data['PMode'] = $_SESSION['paymentMethod'];
			}
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			if(@$paymentMode != 'All') {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$condtUser = "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1";
							$conditiontwo = "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:""). " and ET_RECEIPT_ACTIVE=0";
						}
						else {
							$queryString .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$condtUser .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1";
							$conditiontwo .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'"  . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:""). " and ET_RECEIPT_ACTIVE=0";
						}
					}
					$conditionOne = $queryString;
				} else {
					if($users != "All Users"){
						$conditionOne = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1,'ET_RECEIPT_PAYMENT_METHOD' => $paymentMode,'ET_RECEIPT_DATE' => $date);
						$condtUser = array('ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1, 'ET_ACTIVE'=>1);//'ET_RECEIPT_ISSUED_BY_ID' => $users,
						$conditiontwo = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>0,'ET_RECEIPT_PAYMENT_METHOD' => $paymentMode);
					} else{
						$conditionOne = array('ET_ACTIVE' => 1,'ET_RECEIPT_PAYMENT_METHOD' => $paymentMode,'ET_RECEIPT_DATE' => $date);
						$condtUser = array('ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1, 'ET_ACTIVE'=>1);
						$conditiontwo = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>0,'ET_RECEIPT_PAYMENT_METHOD' => $paymentMode);
					}
				}
				
				$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
				//For Count
				$data['Count'] = $this->obj_report->count_rows_receipt_report($conditionOne);

				//for cancelled count
				$data['CancelledCount'] = $this->obj_report->cancelled_count_rows_receipt_report($conditiontwo);

				
				//FOR PRICE DISPLAY IN COMBOBOX
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					$queryString2 = "";
					$queryString3 = "";
					$queryString4 = "";
					
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString1 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Cash'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString2 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Cheque'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString3 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Credit / Debit Card'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString4 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Direct Credit'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						} else {
							$queryString .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString1 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Cash'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString2 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Cheque'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString3 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Credit / Debit Card'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString4 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Direct Credit'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						}
					}
					$condt = $queryString;
					$condt1 = $queryString1;
					$condt2 = $queryString2;
					$condt3 = $queryString3;
					$condt4 = $queryString4;
				} else {
					if($users != "All Users") {
						$condt = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 , 'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt1 = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt2 = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt3 = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt4 = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
					} else {
						$condt = array('ET_ACTIVE' => 1 , 'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt1 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt2 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt3 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt4 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);				
					}
				}
			} else {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$condtUser = "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1";
							$conditiontwo = "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1". (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:""). " AND ET_RECEIPT_ACTIVE=0";	
						}
						else {
							$queryString .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$condtUser .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1";
							$conditiontwo .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:""). " and ET_RECEIPT_ACTIVE=0";
						}
					}
					$conditionOne = $queryString;
				} else {
					if($users != "All Users"){
						$conditionOne = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1,'ET_RECEIPT_DATE' => $date);
						$condtUser = array('ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1, 'ET_ACTIVE'=>1);//'ET_RECEIPT_ISSUED_BY_ID' => $users,
						$conditiontwo = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>0);
					}
					else{
						$conditionOne = array('ET_ACTIVE' => 1,'ET_RECEIPT_DATE' => $date);
						$condtUser = array('ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1, 'ET_ACTIVE'=>1);
						$conditiontwo = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>0);
					}
				}
				$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
				//For Count
				$data['Count'] = $this->obj_report->count_rows_receipt_report($conditionOne);
				$data['CancelledCount'] = $this->obj_report->cancelled_count_rows_receipt_report($conditiontwo);
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					$queryString2 = "";
					$queryString3 = "";
					$queryString4 = "";
					
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString1 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Cash'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString2 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Cheque'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString3 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Credit / Debit Card'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString4 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Direct Credit'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						} else {
							$queryString .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString1 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Cash'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString2 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Cheque'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString3 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Credit / Debit Card'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
							$queryString4 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='Direct Credit'" . (($users != "All Users")?" AND ET_RECEIPT_ISSUED_BY_ID = ".$users:"");
						}
					}
					$condt = $queryString;
					$condt1 = $queryString1;
					$condt2 = $queryString2;
					$condt3 = $queryString3;
					$condt4 = $queryString4;
				} else {
					//FOR PRICE DISPLAY IN COMBOBOX
					if($users != "All Users") {
						$condt = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt1 = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt2 = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt3 = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt4 = array('ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
					} else {
						$condt = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt1 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt2 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt3 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);
						$condt4 = array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_DATE' => $date,'ET_RECEIPT_ACTIVE'=>1);	
					}
				}
			}

			//Load Users in Receipt Report
			$data['users'] = $this->obj_report->get_all_users_on_events($condtUser,'ET_RECEIPT_ISSUED_BY','asc');
			
			$data['All'] = $this->obj_report->get_total_amount($condt);
			$data['Cash'] = $this->obj_report->get_total_amount($condt1);
			$data['Cheque'] = $this->obj_report->get_total_amount($condt2);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount($condt3);
			$data['Direct'] = $this->obj_report->get_total_amount($condt4);
			
			$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/event_report_on_change_date';
			$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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
			
			$this->load->view('header', $data);
			$this->load->view('event_receipt_report');
			$this->load->view('footer_home');
		}
		
		
		//EVENT SEVA REPORT
		function event_seva_report($start = 0) {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			//unset
			unset($_SESSION['date']);
			unset($_SESSION['sevaid']);
			
			//For Menu Selection
			$data['whichTab'] = "report";
			$data['date'] = date('d-m-Y');
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			$conditionTwo = array('ET_ACTIVE' => 1,'ET_SO_IS_SEVA'=>1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => date('d-m-Y'));
			$data['events_seva'] = $this->obj_report->get_all_field_seva_report($conditionTwo);
			
			$conditionTwo = array('ET_ACTIVE' => 1,'ET_RECEIPT_ACTIVE' => 1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => date('d-m-Y'));
			$data['seva_report'] = $this->obj_report->get_all_field_event_seva_report($conditionTwo,'','', 10,$start);
			
			$data['Count'] = $this->obj_report->count_rows_seva_report($conditionTwo); 
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/event_seva_report';
			$config['total_rows'] = $this->obj_report->count_rows_seva_report($conditionTwo);
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
			
			if(isset($_SESSION['Current_Event_Seva_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('event_sevas_report');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//FOR EXCEL FOR RECEIPT
		function event_sevas_report_excel() {
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$header = "";
			$result = "";
			if(@$radioOpt == "multiDate")
				$filename = "Current_Event_Receipt_Report_ from ".$_SESSION['fromDate']." to ".$_SESSION['toDate'];  //File Name
			else
				$filename = "Current_Event_Receipt_Report_".$_POST['dateField'];  //File Name
			$file_ending = "xls";
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$header .= "\t";
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";						
			$header .= "SI NO." . "\t";
			$header .= "SEVA" . "\t";
			$header .= "NAME" . "\t";
			$header .= "CONTACT NUMBER" . "\t";
			$header .= "RECEIPT NO." . "\t";
			
			if(isset($_POST['allDates'])) {
				$allDates= @$_POST['allDates'];
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			if(@$radioOpt == "multiDate" && $this->input->post('SId') == "All") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0)
						$queryString .= "ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."'";
					else
						$queryString .= " or ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."'";
				}
				$condition = $queryString;
				$res = $this->obj_report->get_all_field_event_seva_excel($condition);
			} else if(@$radioOpt == "multiDate"){	
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0)
						$queryString .= "ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."' and EVENT_SEVA_OFFERED.ET_SO_SEVA_ID='".$this->input->post('SId')."'";
					else
						$queryString .= " or ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."' and EVENT_SEVA_OFFERED.ET_SO_SEVA_ID='".$this->input->post('SId')."'";
				}

				$condition = $queryString;
				$res = $this->obj_report->get_all_field_event_seva_excel($condition);
			} else {
				if(($this->input->post('dateField')) != "" && ($this->input->post('SId') == "All")) {
					$condition = array('ET_RECEIPT_ACTIVE' => 1, 'EVENT_SEVA_OFFERED.ET_SO_DATE' => $this->input->post('dateField'));
					$res = $this->obj_report->get_all_field_event_seva_excel($condition);
				} else {
					$condition = array('ET_RECEIPT_ACTIVE' => 1, 'EVENT_SEVA_OFFERED.ET_SO_DATE' => $this->input->post('dateField'), 'EVENT_SEVA_OFFERED.ET_SO_SEVA_ID' => $this->input->post('SId'));
					$res = $this->obj_report->get_all_field_event_seva_excel($condition);
				}
			}

			for($i = 0; $i < sizeof($res); $i++)
			{
				$line = '';    
				$value = "";			
				$value .= ($i+1). "\t";			
				$value .= '"' . $res[$i]->ET_SO_SEVA_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->ET_RECEIPT_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->ET_RECEIPT_PHONE . '"' . "\t";
				$value .= '"' . $res[$i]->ET_RECEIPT_NO . '"' . "\t";

				$line .= $value;
				$result .= trim($line) . "\n";
			}
			$result = str_replace( "\r" , "" , $result );

			print("$header\n$result"); 
		}
		
		//EVENT SEVA REPORT ON CHANGE OF COMBO
		function event_seva_change_report($start = 0) {
			//For Menu Selection
			$data['whichTab'] = "report";			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['sevaid']) {
				unset($_SESSION['sevaid']);
				$data['sevaId'] = $this->input->post('sevaid');
				$sevaid = $this->input->post('sevaid');
			}
			
			if(@$_SESSION['sevaid'] == "") {
				$this->session->set_userdata('sevaid', $this->input->post('sevaid'));
				$data['sevaId'] = $_SESSION['sevaid'];
				$sevaid = $this->input->post('sevaid');
			} else {
				$sevaid = $_SESSION['sevaid'];
				$data['sevaId'] = $_SESSION['sevaid'];
			}
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			$conditionOne = array('ET_ACTIVE' => 1,'ET_SO_IS_SEVA'=>1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => $date);
			$data['events_seva'] = $this->obj_report->get_all_field_seva_report($conditionOne);
			if($sevaid != 'All') {
				$conditionTwo = array('ET_ACTIVE' => 1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => $date, 'EVENT_SEVA_OFFERED.ET_SO_SEVA_ID' => $sevaid);
			} else {
				$conditionTwo = array('ET_ACTIVE' => 1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => $date);
			}
			$data['seva_report'] = $this->obj_report->get_all_field_event_seva_report($conditionTwo,'','',10,$start);
			$data['Count'] = $this->obj_report->count_rows_seva_report($conditionTwo);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/event_seva_change_report';
			$config['total_rows'] = $this->obj_report->count_rows_seva_report($conditionTwo);
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
			
			$this->load->view('header', $data);
			$this->load->view('event_sevas_report');
			$this->load->view('footer_home');
		}
		
		
		
		
		//JEERNODHARA RECEIPT REPORT ON CHANGE OF DATEFIELD
		function Jeernodhara_report_on_change_date($start = 0) {
			//For Menu Selection
			$data['whichTab'] = "Jeernodhara";
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['allDates'])) {
				$allDates= @$_POST['allDates'];
				$_SESSION['allDates'] = $allDates;
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			$data['radioOpt'] = $radioOpt;
			$data['allDates'] = $allDates;
			
			if(isset($_POST['fromDate'])) {
				$fromDate = @$_POST['fromDate'];
				$toDate = @$_POST['toDate'];
				$_SESSION['fromDate'] = $fromDate;
				$_SESSION['toDate'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDate'];
				$toDate = $_SESSION['toDate'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(isset($_POST['users_id'])) {
				$data['user'] = $this->input->post('users_id');
				$userId = $this->input->post('users_id');
				$this->session->set_userdata('Jeerno_User_Id', $this->input->post('users_id'));
			} else if(@$_SESSION['Jeerno_User_Id']) {
				$data['user'] = $_SESSION['Jeerno_User_Id'];
				$userId = $_SESSION['Jeerno_User_Id'];
			} else {
				$data['user'] = 0;
				$userId = 0;
				$_SESSION['Jeerno_User_Id'] = 0;
			}
			
			if(@$_POST['paymentMethod']) {
				$data['PMode'] = $this->input->post('paymentMethod');
				$payMethod = $this->input->post('paymentMethod');
				$this->session->set_userdata('PMode', $this->input->post('paymentMethod'));
			} else if(@$_SESSION['PMode']) {
				$data['PMode'] = $_SESSION['PMode'];
				$payMethod = $_SESSION['PMode'];
			}
			
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."'";
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."'";
					}
				}
				$conditionOne = '('.$queryString.')';
			} else {
				$conditionOne = array('RECEIPT_DATE' => $date);
			}
			
			$_SESSION['actual_link'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
			$data['daily_report'] = $this->obj_report->get_all_field_jeernodhara_receipt_report($conditionOne,$userId,$payMethod,'','', 10,$start);
			
			$data['users'] = $this->obj_report->get_all_users_on_jeernodhara_change($conditionOne,0,'RECEIPT_ISSUED_BY','asc');

			
			$data['All'] = $this->obj_report->get_total_amount_user_collection_for_jeernodhara_change($conditionOne,$userId,"All");
			$data['Cash'] = $this->obj_report->get_total_amount_user_collection_for_jeernodhara_change($conditionOne,$userId,"Cash");
			$data['Cheque'] = $this->obj_report->get_total_amount_user_collection_for_jeernodhara_change($conditionOne,$userId,"Cheque");
			$data['Credit_Debit'] = $this->obj_report->get_total_amount_user_collection_for_jeernodhara_change($conditionOne,$userId,"Credit / Debit Card");
			$data['Direct'] = $this->obj_report->get_total_amount_user_collection_for_jeernodhara_change($conditionOne,$userId,"Direct Credit");
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/Jeernodhara_report_on_change_date';
			$config['total_rows'] = $data['Count'] = $this->obj_report->count_rows_jeernodhara_receipt_report($conditionOne, $userId, $payMethod);
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
			
			//print_r($_POST);
			
			$this->load->view('header', $data);
			$this->load->view('Jeernodhara/jeernodhara_daily_report');
			$this->load->view('footer_home');
		}
		
		//EVENT SEVA REPORT ON CHANGE OF COMBO
		function event_date_change_report($start = 0) {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['allDates'])) {
				$allDates= @$_POST['allDates'];
				$_SESSION['allDates'] = $allDates;
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			$data['radioOpt'] = $radioOpt;
			$data['allDates'] = $allDates;
			
			if(isset($_POST['fromDate'])) {
				$fromDate = @$_POST['fromDate'];
				$toDate = @$_POST['toDate'];
				$_SESSION['fromDate'] = $fromDate;
				$_SESSION['toDate'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDate'];
				$toDate = $_SESSION['toDate'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			//For Menu Selection
			$data['whichTab'] = "report";
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}
			
			if(@$_POST['sevaid']) {
				unset($_SESSION['sevaid']);
				$data['sevaId'] = $this->input->post('sevaid');
				$sevaid = $this->input->post('sevaid');
			}
			
			if(@$_SESSION['sevaid'] == "") {
				$this->session->set_userdata('sevaid', $this->input->post('sevaid'));
				$data['sevaId'] = $_SESSION['sevaid'];
				$sevaid = $this->input->post('sevaid');
			} else {
				$sevaid = $_SESSION['sevaid'];
				$data['sevaId'] = $_SESSION['sevaid'];
			}
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0)
						$queryString .= "ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."' and ET_SO_IS_SEVA = 1";
					else
						$queryString .= " or ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."' and ET_SO_IS_SEVA = 1";
				}
				$conditionOne = $queryString;
			} else {
				$conditionOne = array('ET_RECEIPT_ACTIVE' =>1,'ET_SO_IS_SEVA'=>1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => $date);
			}
			
			$data['events_seva'] = $this->obj_report->get_all_field_seva_report($conditionOne);
			
			if($sevaid != 'All') {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0)
							$queryString .= "ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."' and EVENT_SEVA_OFFERED.ET_SO_SEVA_ID='".$sevaid."'";
						else
							$queryString .= " or ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."' and EVENT_SEVA_OFFERED.ET_SO_SEVA_ID='".$sevaid."'";
					}
					$conditionTwo = $queryString;
				} else
				$conditionTwo = array('ET_RECEIPT_ACTIVE' =>1,'EVENT_SEVA_OFFERED.ET_SO_SEVA_ID' => $sevaid, 'EVENT_SEVA_OFFERED.ET_SO_DATE' => $date);
			} else {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0)
							$queryString .= "ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."'";
						else
							$queryString .= " or ET_RECEIPT_ACTIVE = 1 and  EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."'";
					}	
					$conditionTwo = $queryString;
				} else
				$conditionTwo = array('ET_RECEIPT_ACTIVE' =>1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => $date);
			}
			$data['seva_report'] = $this->obj_report->get_all_field_event_seva_report($conditionTwo,'','',10,$start);
			$data['Count'] = $this->obj_report->count_rows_seva_report($conditionTwo);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/event_date_change_report';
			$config['total_rows'] = $this->obj_report->count_rows_seva_report($conditionTwo);
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
			
			$this->load->view('header', $data);
			$this->load->view('event_sevas_report');
			$this->load->view('footer_home');
		}
		
		function View(){
			$id = $this->input->post('id');
			$cheqNo = $this->input->post('cheqNo');
			$cheqDate = $this->input->post('cheqDate');
			$Bank = $this->input->post('Bank');
			$Branch = $this->input->post('Branch');
			$TransactionId = $this->input->post('TransactionId');
			
			if($id == '1') {
				echo "<h6 style='font-size:16px; line-height:16px;'><b>Cheque No : </b> ".$cheqNo."</h6>" ;  
				echo "<h6 style='font-size:16px; line-height:16px;'><b>Cheque Date : </b> ".$cheqDate."</h6>" ; 
				echo "<h6 style='font-size:16px; line-height:16px;'><b>Bank : </b> ".str_replace("\'","'",$Bank)."</h6>" ; 
				echo "<h6 style='font-size:16px; line-height:16px;'><b>Branch : </b> ".str_replace("\'","'",$Branch)."</h6>" ; 
			} else if($id == '2'){
				echo "<h6 style='font-size:16px; line-height:16px;'><b>Transaction Id : </b> ".$TransactionId."</h6>" ;  
			}
		}
		
		function ViewCancelled(){
			$cancelled = $this->input->post('cancelNotes');
			echo "<h6 style='font-size:16px; line-height:16px;'><b>Cancelled Notes : </b> ".str_replace("'","\'",$cancelled)."</h6>" ;   
		}
		
		//USER REPORT
		function user_collection_report($start=0) {
			//For Menu Selection
			$data['whichTab'] = "report";
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			$conditionOne = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No','ET_ACTIVE' => 1);
			$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
			
			$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
			
			$condt = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No','ET_ACTIVE' => 1);
			$data['All'] = $this->obj_report->get_total_amount_user_collection($condt);
			$condt1 = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_ACTIVE' => 1);
			$data['Cash'] = $this->obj_report->get_total_amount_user_collection($condt1);
			$condt2 = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_ACTIVE' => 1);
			$data['Cheque'] = $this->obj_report->get_total_amount_user_collection($condt2);
			$condt3 = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_ACTIVE' => 1);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount_user_collection($condt3);
			$condt4 = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_ACTIVE' => 1);
			$data['Direct'] = $this->obj_report->get_total_amount_user_collection($condt4);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/user_collection_report';
			$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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
			
			if(isset($_SESSION['User_Event_Collection_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('user_collection_report');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		function get_data_on_payment($start=0) {
			//UNSET SESSION CHECKBOX
			unset($_SESSION['all_users']);
			//For Menu Selection
			$data['whichTab'] = "report";
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			if(@$_POST['paymentMethod'] != "") {
				unset($_SESSION['paymentMethod']);
				$_SESSION['receipt'] = $this->input->post('paymentMethod');
				$pMethod = $this->input->post('paymentMethod');
				$data['payMethod'] = $this->input->post('paymentMethod');
			}
			
			if(@$_SESSION['paymentMethod'] == "") {
				$this->session->set_userdata('paymentMethod', $this->input->post('paymentMethod'));
				$pMethod = $this->input->post('paymentMethod');
				$data['payMethod'] = $_SESSION['paymentMethod'];
			} else {
				$pMethod = $_SESSION['paymentMethod'];
				$data['payMethod'] = $_SESSION['paymentMethod'];
			}
			
			if(@$pMethod == "All") {
				$conditionOne = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'AUTHORISED_STATUS' => 'No','ET_ACTIVE' => 1);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'ET_ACTIVE' => 1);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'ET_ACTIVE' => 1);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'ET_ACTIVE' => 1);
				$condt3 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'ET_ACTIVE' => 1);
				$condt4 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'ET_ACTIVE' => 1);
				$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
			} else if(@$pMethod != "All") {
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'ET_RECEIPT_PAYMENT_METHOD' => $pMethod,'ET_ACTIVE' => 1);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'),'ET_ACTIVE' => 1);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_ACTIVE' => 1);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_ACTIVE' => 1);
				$condt3 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_ACTIVE' => 1);
				$condt4 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'), 'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_ACTIVE' => 1);
				$data['event_receipt_report'] = $this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start);
			}
			
			
			$data['All'] = $this->obj_report->get_total_amount_user_collection($condt);
			$data['Cash'] = $this->obj_report->get_total_amount_user_collection($condt1);
			$data['Cheque'] = $this->obj_report->get_total_amount_user_collection($condt2);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount_user_collection($condt3);
			$data['Direct'] = $this->obj_report->get_total_amount_user_collection($condt4);
			$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
			
			$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/get_data_on_payment';
			$config['total_rows'] = $this->obj_report->count_rows_seva_report($conditionOne);
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
			
			$this->load->view('header', $data);
			$this->load->view('user_collection_report');
			$this->load->view('footer_home');
		}
		
		//SET THE SESSION OF CHECKBOX
		function get_set_session() {
			$this->session->set_userdata('all_users',$this->input->post('select'));
		}
		
		//UNSET THE SESSION OF CHECKBOX
		function get_unset_session() {
			unset($_SESSION['all_users']);
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);
		}

		//USER REPORT
		function user_collection_report_admin($start=0) {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			//UNSET SESSION
			unset($_SESSION['users']);
			unset($_SESSION['paymentMethod']);
			unset($_SESSION['PM']);
			unset($_SESSION['UID']);

			//For Menu Selection
			$data['whichTab'] = "report";
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			
			$condtUser = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1);
			$data['users'] = $this->obj_report->get_all_users_on_events($condtUser,'ET_RECEIPT_ISSUED_BY','asc');
			
			$conditionOne = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
			$data['event_receipt_report'] = json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
			$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
			$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
			
			$condt = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
			$data['All'] = $this->obj_report->get_total_amount_user_collection($condt);
			$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
			$data['Cash'] = $this->obj_report->get_total_amount_user_collection($condt1);
			$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
			$data['Cheque'] = $this->obj_report->get_total_amount_user_collection($condt2);
			$condt3 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount_user_collection($condt3);
			$condt4 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
			$data['Direct'] = $this->obj_report->get_total_amount_user_collection($condt4);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/user_collection_report_admin';
			$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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
			
			if(isset($_SESSION['User_Event_Collection_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('user_collection_report_admin');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}	
		}
		
		
		function get_data_on_filter($id,$start=0) {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');

			//UNSET SESSION CHECKBOX
			//UNSET($_SESSION['all_users']);
			
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(@$_POST['users_id']) {
				$_SESSION['users'] = $this->input->post('users_id');
				$data['user'] = $this->input->post('users_id');
				$users = $this->input->post('users_id');
			}
			
			if(@$_SESSION['users'] == "") {
				$this->session->set_userdata('users', $this->input->post('users_id'));
				$data['user'] = $_SESSION['users'];
				$users = $this->input->post('users_id');
			} else {
				$users = $_SESSION['users'];
				$data['user'] = $_SESSION['users'];
			}
			
			if(@$_POST['paymentMethod'] != "") {
				unset($_SESSION['paymentMethod']);
				$_SESSION['receipt'] = $this->input->post('paymentMethod');
				$pMethod = $this->input->post('paymentMethod');
				$data['payMethod'] = $this->input->post('paymentMethod');
			}
			
			if(@$_SESSION['paymentMethod'] == "") {
				$this->session->set_userdata('paymentMethod', $this->input->post('paymentMethod'));
				$pMethod = $this->input->post('paymentMethod');
				$data['payMethod'] = $_SESSION['paymentMethod'];
			} else {
				$pMethod = $_SESSION['paymentMethod'];
				$data['payMethod'] = $_SESSION['paymentMethod'];
			}
			
			if($id == 0) {
				//SESSION OF APPROVE
				if(isset($_SESSION['PM'])) {
					$pMethod = $_SESSION['PM'];
					$data['payMethod'] = $_SESSION['PM'];
				}
				
				//SESSION OF APPROVE
				if(isset($_SESSION['UID'])) {
					$users = $_SESSION['UID'];
					$data['user'] = $_SESSION['UID'];
					
					$conditionOne = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
					$event_receipt_report =  json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
					$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
					if(count($event_receipt_report) == 0) {
						$users = "All Users";
					}
				}
			} else {
				unset($_SESSION['PM']);
				unset($_SESSION['UID']);
			}
			
			$condition = array('ET_ACTIVE' => 1);
			$data['events'] = $this->obj_report->get_all_field_event($condition);
			$condtUser = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1);
			$data['users'] = $this->obj_report->get_all_users_on_events($condtUser,'ET_RECEIPT_ISSUED_BY','asc');
			
			if(@$pMethod == "All" && @$users == "All Users") {
				$conditionOne = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt3 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt4 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$data['event_receipt_report'] =  json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
				$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
			} else if(@$pMethod != "All" && @$users != "All Users") {
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $pMethod, 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt3 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt4 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$data['event_receipt_report'] =  json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
				$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
			} else if(@$pMethod != "All" && @$users == "All Users") {
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $pMethod,'ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt3 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt4 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$data['event_receipt_report'] =  json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
				$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
			} else if(@$pMethod == "All" && @$users != "All Users") {
				$conditionOne = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				//CONDITION FOR AMOUNT
				$condt = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users,'ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt1 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_RECEIPT_PAYMENT_METHOD' => 'Cash','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt2 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_RECEIPT_PAYMENT_METHOD' => 'Cheque','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt3 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_RECEIPT_PAYMENT_METHOD' => 'Credit / Debit Card','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$condt4 = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $users, 'ET_RECEIPT_PAYMENT_METHOD' => 'Direct Credit','ET_RECEIPT_ACTIVE'=>1,'ET_ACTIVE' => 1);
				$data['event_receipt_report'] =  json_encode($this->obj_report->get_all_field_event_receipt_report($conditionOne,'','', 10,$start));
				$data['all_event_receipt_report'] =  json_encode($this->obj_report->get_full_field_event_receipt_report($conditionOne,'',''));
			}
			
			$data['All'] = $this->obj_report->get_total_amount_user_collection($condt);
			$data['Cash'] = $this->obj_report->get_total_amount_user_collection($condt1);
			$data['Cheque'] = $this->obj_report->get_total_amount_user_collection($condt2);
			$data['Credit_Debit'] = $this->obj_report->get_total_amount_user_collection($condt3);
			$data['Direct'] = $this->obj_report->get_total_amount_user_collection($condt4);
			$data['TotalAmount'] = $this->obj_report->get_all_amount($conditionOne);
			
			//pagination starts
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/get_data_on_filter/'.$id;
			$config['total_rows'] = $this->obj_report->count_rows_receipt_report($conditionOne);
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
			
			$this->load->view('header', $data);
			$this->load->view('user_collection_report_admin');
			$this->load->view('footer_home');
		}
		
		//APPROVE THE DATA
		function approve_Submit() {
			$data['whichTab'] = "report";
			//VALUE OF CHECKBOX SELECTED OR NOT SELECTED
			$selCondition = $this->input->post('checkVal');
			
			if($selCondition == "all_users") { //ALL_USERS CHECKBOX
				if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') == "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No','ET_RECEIPT_ACTIVE'=>1);
				} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') != "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'ET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'),'ET_RECEIPT_ACTIVE'=>1);
				} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') == "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'),'ET_RECEIPT_ACTIVE'=>1);
				} else if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') != "All Users") {
					$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'),'ET_RECEIPT_ACTIVE'=>1);
				}
				//UPDATE CODE
				$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'),'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
				$this->obj_report->update_authorise($condition,$data);
			} else if($selCondition == "this_page") { //THIS_PAGE CHECKBOX
				$selectedId = $this->input->post('selectApprove');
				$arrSelect = explode(',' ,$selectedId);
				for($i = 0; $i <= count($arrSelect) - 1; $i++) {
					if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') == "All Users") {
						$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1);
					} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') != "All Users") {
						$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'ET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'), 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1);
					} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') == "All Users") {
						$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1);
					} else if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') != "All Users") {
						$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'), 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1);
					}
					//UPDATE CODE
					$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
					$this->obj_report->update_authorise($condition,$data);
				}
			} else { //WITHOUT CHECKBOX
				$selectedId = $this->input->post('selectApprove');
				$arrSelect = explode(',' ,$selectedId);
				for($i = 0; $i <= count($arrSelect) - 1; $i++) {
					if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') == "All Users") {
						$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1);
					} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') != "All Users") {
						$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'ET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'), 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1);
					} else if(@$this->input->post('paymentApprove') != "All" && @$this->input->post('userApprove') == "All Users") {
						$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_PAYMENT_METHOD' => $this->input->post('paymentApprove'), 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1);
					} else if(@$this->input->post('paymentApprove') == "All" && @$this->input->post('userApprove') != "All Users") {
						$condition = array('AUTHORISED_STATUS' => 'No', 'ET_RECEIPT_ISSUED_BY_ID' => $this->input->post('userApprove'), 'ET_RECEIPT_ID' => $arrSelect[$i],'ET_RECEIPT_ACTIVE'=>1);
					}
					//UPDATE CODE
					$data = array('AUTHORISED_STATUS' => 'Yes', 'AUTHORISED_BY_NAME' => $this->session->userdata('userFullName'), 'AUTHORISED_BY' => $this->session->userdata('userId'), 'AUTHORISED_DATE_TIME' => date('d-m-Y H:i:s A'), 'AUTHORISED_DATE' => date('d-m-Y'),'ET_RECEIPT_ACTIVE'=>1);
					$this->obj_report->update_authorise($condition,$data);
				}
			}
			$this->session->set_userdata('PM', $this->input->post('paymentApprove'));
			$this->session->set_userdata('UID', $this->input->post('userApprove'));
			redirect('/Report/user_collection_report_admin'); //get_data_on_filter/0
		}
		
		//MIS REPORT FOR DEITY
		function deity_mis_report() {
			//For Menu Selection
			$data['whichTab'] = "report";
			if(isset($_POST['date'])) {
				$date = $_POST['date']; 
			} else {
				$date = date('d-m-Y');
			}
			
			$data['date'] = $date;
			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			$fromDate = @$_POST['fromDate'];
			$toDate = @$_POST['toDate'];
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			//DONATION
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 2 and RECEIPT_ACTIVE = 1";
					else
						$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 2 and RECEIPT_ACTIVE = 1";
				}
			}
			
			if(@$radioOpt == "multiDate") {
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else {
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 2,'RECEIPT_ACTIVE' => 1));
			}
			
			$query = $this->db->get();
			$data['donation'] = $query->result("array");
			$_SESSION['donation'] = $data['donation'];
			
			//COUNT OF DONATION
			if(@$radioOpt == "multiDate") {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 2  and RECEIPT_ACTIVE = 1';
			}
			
			$queryDKC = $this->db->query($sqlDKC);
			$row=$query->num_rows();
			$data['donationCount'] = $row;
			$_SESSION['donationCount'] = $data['donationCount'];
			
			//DONATION ALL DETAILS
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 2 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 2 and RECEIPT_ACTIVE = 1";
					}
				}
				
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 2 and RECEIPT_ACTIVE = 1';
			}
			$queryDK = $this->db->query($sqlDK);
			$data['donation_details'] = $queryDK->result('array');
			$_SESSION['donation_details'] = $data['donation_details'];
			
			//CANCELLED DONATION
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 2 and RECEIPT_ACTIVE = 0";
					else
						$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 2 and RECEIPT_ACTIVE = 0";
				}
			}
			
			if(@$radioOpt == "multiDate") {
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else {
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 2,'RECEIPT_ACTIVE' => 0));
			}
			
			$query = $this->db->get();
			$data['cancelledDonation'] = $query->result("array");
			$_SESSION['cancelledDonation'] = $data['cancelledDonation'];
			
			//COUNT OF CANCELLED DONATION
			if(@$radioOpt == "multiDate") {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 2  and RECEIPT_ACTIVE = 0';
			}
			
			$queryDKC = $this->db->query($sqlDKC);
			$row=$queryDKC->num_rows();
			$data['cancelledDonationCount'] = $row;
			$_SESSION['cancelledDonationCount'] = $data['cancelledDonationCount'];
			
			//CANCELLED DONATION ALL DETAILS
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 2 and RECEIPT_ACTIVE = 0";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 2 and RECEIPT_ACTIVE = 0";
					}
				}
				
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 2 and RECEIPT_ACTIVE = 0';
			}
			$queryDK = $this->db->query($sqlDK);
			$data['cancelled_donation_details'] = $queryDK->result('array');
			$_SESSION['cancelled_donation_details'] = $data['cancelled_donation_details'];
			
			/*********** START JEERNODHARA KANIKE ***********/
			//JEERNODHARA KANIKE
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 8 and RECEIPT_ACTIVE = 1";
					else
						$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 8 and RECEIPT_ACTIVE = 1";
				}
			}
			
			if(@$radioOpt == "multiDate") {
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else {
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 8,'RECEIPT_ACTIVE'=>1));
			}
			
			$query = $this->db->get();
			$data['jeernokanike'] = $query->result("array");
			$_SESSION['jeernokanike'] = $data['jeernokanike'];
			
			//COUNT OF JEERNODHARA KANIKE
			if(@$radioOpt == "multiDate") {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 8 and RECEIPT_ACTIVE = 1';
			}
			
			$queryDKC = $this->db->query($sqlDKC);
			$row=$query->num_rows();
			$data['jeernokanikeCount'] = $row;
			$_SESSION['jeernokanikeCount'] = $data['jeernokanikeCount'];
			
			//KANIKE ALL DETAILS
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 8 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 8 and RECEIPT_ACTIVE = 1";
					}
				}
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 8 and RECEIPT_ACTIVE = 1';
			}
			$queryDK = $this->db->query($sqlDK);
			$data['jeerno_kanike_details'] = $queryDK->result('array');
			$_SESSION['jeerno_kanike_details'] = $data['jeerno_kanike_details'];
			
			//CANCELLED JEERNODHARA KANIKE
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 8 and RECEIPT_ACTIVE = 0";
					else
						$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 8 and RECEIPT_ACTIVE = 0";
				}
			}
			
			if(@$radioOpt == "multiDate") {
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else {
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 8,'RECEIPT_ACTIVE'=>0));
			}
			
			$query = $this->db->get();
			$data['cancelledJeernoKanike'] = $query->result("array");
			$_SESSION['cancelledJeernoKanike'] = $data['cancelledJeernoKanike'];
			
			//COUNT OF KANIKE
			if(@$radioOpt == "multiDate") {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 8 and RECEIPT_ACTIVE = 0';
			}
			
			$queryDKC = $this->db->query($sqlDKC);
			$row=$query->num_rows();
			$data['cancelledJeernoKanikeCount'] = $row;
			$_SESSION['cancelledJeernoKanikeCount'] = $data['cancelledJeernoKanikeCount'];
			
			//KANIKE ALL DETAILS
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 8 and RECEIPT_ACTIVE = 0";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 8 and RECEIPT_ACTIVE = 0";
					}
				}
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 8 and RECEIPT_ACTIVE = 0';
			}
			$queryDK = $this->db->query($sqlDK);
			$data['cancelled_jeerno_kanike_details'] = $queryDK->result('array');
			$_SESSION['cancelled_jeerno_kanike_details'] = $data['cancelled_jeerno_kanike_details'];			
			/*********** END JEERNODHARA KANIKE ***********/
			
			//KANIKE
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 3 and RECEIPT_ACTIVE = 1";
					else
						$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 3 and RECEIPT_ACTIVE = 1";
				}
			}
			
			if(@$radioOpt == "multiDate") {
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else {
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 3,'RECEIPT_ACTIVE'=>1));
			}
			
			$query = $this->db->get();
			$data['kanike'] = $query->result("array");
			$_SESSION['kanike'] = $data['kanike'];
			
			//COUNT OF KANIKE
			if(@$radioOpt == "multiDate") {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 3 and RECEIPT_ACTIVE = 1';
			}
			
			$queryDKC = $this->db->query($sqlDKC);
			$row=$query->num_rows();
			$data['kanikeCount'] = $row;
			$_SESSION['kanikeCount'] = $data['kanikeCount'];

			//LAZ 
			$this->db->select()->from('kanike_setting');/*->where(array('KS_STATUS'=> 1));*/
			$query = $this->db->get();
			$data['allActiveKanike'] = $query->result("array");
			$_SESSION['allActiveKanike'] = $data['allActiveKanike'];
			
			//KANIKE ALL DETAILS
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 3 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 3 and RECEIPT_ACTIVE = 1";
					}
				}
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 3 and RECEIPT_ACTIVE = 1';
			}
			$queryDK = $this->db->query($sqlDK);
			$data['kanike_details'] = $queryDK->result('array');
			$_SESSION['kanike_details'] = $data['kanike_details'];
			
			//CANCELLED KANIKE
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 3 and RECEIPT_ACTIVE = 0";
					else
						$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 3 and RECEIPT_ACTIVE = 0";
				}
			}
			
			if(@$radioOpt == "multiDate") {
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else {
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 3,'RECEIPT_ACTIVE'=>0));
			}
			
			$query = $this->db->get();
			$data['cancelledKanike'] = $query->result("array");
			$_SESSION['cancelledKanike'] = $data['cancelledKanike'];
			
			//COUNT OF KANIKE
			if(@$radioOpt == "multiDate") {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlDKC = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 3 and RECEIPT_ACTIVE = 0';
			}
			
			$queryDKC = $this->db->query($sqlDKC);
			$row=$query->num_rows();
			$data['cancelledKanikeCount'] = $row;
			$_SESSION['cancelledKanikeCount'] = $data['cancelledKanikeCount'];
			
			//KANIKE ALL DETAILS
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 3 and RECEIPT_ACTIVE = 0";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 3 and RECEIPT_ACTIVE = 0";
					}
				}
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID JOIN kanike_setting on deity_receipt.KANIKE_FOR = kanike_setting.KS_ID  WHERE '.$queryString.'';
			} else {
				$sqlDK = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID JOIN kanike_setting on deity_receipt.KANIKE_FOR = kanike_setting.KS_ID  WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 3 and RECEIPT_ACTIVE = 0';
			}
			$queryDK = $this->db->query($sqlDK);
			$data['cancelled_kanike_details'] = $queryDK->result('array');
			$_SESSION['cancelled_kanike_details'] = $data['cancelled_kanike_details'];
			
			//***********    START JEERNODHARA HUNDI    *************
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 9 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 9 and RECEIPT_ACTIVE = 1";
					}
				}
				
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else { 
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 9,'RECEIPT_ACTIVE' =>1));
			}
			$query = $this->db->get();
			$data['jeernohundi'] = $query->result("array");
			$_SESSION['jeernohundi'] = $data['jeernohundi'];
			
			// Jeernohundi cancelled
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 9 and RECEIPT_ACTIVE = 0";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 9 and RECEIPT_ACTIVE = 0";
					}
				}
				
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else { 
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 9,'RECEIPT_ACTIVE' =>0));
			}
			$query = $this->db->get();
			$data['jeernohundicancelled'] = $query->result("array");
			$_SESSION['jeernohundicancelled'] = $data['jeernohundicancelled'];
			
			$row=$query->num_rows();
			$data['cancelledJeernoHundiCount'] = $row;
			$_SESSION['cancelledJeernoHundiCount'] = $data['cancelledJeernoHundiCount'];
			//***********    END JEERNODHARA HUNDI    *************
			
			//HUNDI
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 4 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 4 and RECEIPT_ACTIVE = 1";
					}
				}
				
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else { 
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 4,'RECEIPT_ACTIVE' =>1));
			}
			$query = $this->db->get();
			$data['hundi'] = $query->result("array");
			$_SESSION['hundi'] = $data['hundi'];
			
			//COUNT OF HUNDI
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 4 and RECEIPT_ACTIVE = 0";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 4 and RECEIPT_ACTIVE = 0";
					}
				}
				
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else { 
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 4,'RECEIPT_ACTIVE' =>0));
			}
			$query = $this->db->get();
			
			$row=$query->num_rows();
			$data['cancelledHundiCount'] = $row;
			$_SESSION['cancelledHundiCount'] = $data['cancelledHundiCount'];
			
			// Hundi Cancelled
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 4 and RECEIPT_ACTIVE = 0";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 4 and RECEIPT_ACTIVE = 0";
					}
				}
				
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else { 
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 4,'RECEIPT_ACTIVE' =>0));
			}
			$query = $this->db->get();
			$data['hundicancelled'] = $query->result("array");
			$_SESSION['hundicancelled'] = $data['hundicancelled'];
			// Hundi Cancelled End
			
			//******** START JEERNODHARA INKIND ********
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 10 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 10 and RECEIPT_ACTIVE = 1";
					}
				}
				$sql  = 'SELECT DEITY_RECEIPT.RECEIPT_DEITY_NAME,DEITY_INKIND_OFFERED.RECEIPT_ID, DEITY_RECEIPT.RECEIPT_DATE, DEITY_INKIND_OFFERED.DY_IK_ITEM_QTY,DY_IK_ITEM_NAME,DY_IK_ITEM_UNIT, SUM(DY_IK_ITEM_QTY) AS amount FROM DEITY_RECEIPT JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE '.$queryString.' GROUP BY DEITY_RECEIPT.RECEIPT_DEITY_ID, DEITY_INKIND_OFFERED.DY_IK_ITEM_ID';
			} else {
				$sql  = 'SELECT DEITY_RECEIPT.RECEIPT_DEITY_NAME,DEITY_INKIND_OFFERED.RECEIPT_ID, DEITY_RECEIPT.RECEIPT_DATE, DEITY_INKIND_OFFERED.DY_IK_ITEM_QTY,DY_IK_ITEM_NAME,DY_IK_ITEM_UNIT, SUM(DY_IK_ITEM_QTY) AS amount FROM DEITY_RECEIPT JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 10 and RECEIPT_ACTIVE = 1 GROUP BY DEITY_RECEIPT.RECEIPT_DEITY_ID, DEITY_INKIND_OFFERED.DY_IK_ITEM_ID';
			}
			$query = $this->db->query($sql);
			$data['jeernoinkind'] = $query->result("array");
			$_SESSION['jeernoinkind'] = $data['jeernoinkind'];
			//********* END JEERNODHARA INKIND **********
			
			//INKIND
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 5 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE = '".$allDates[$i]."' and RECEIPT_CATEGORY_ID = 5 and RECEIPT_ACTIVE = 1";
					}
				}
				$sql  = 'SELECT DEITY_RECEIPT.RECEIPT_DEITY_NAME,DEITY_INKIND_OFFERED.RECEIPT_ID, DEITY_RECEIPT.RECEIPT_DATE, DEITY_INKIND_OFFERED.DY_IK_ITEM_QTY,DY_IK_ITEM_NAME,DY_IK_ITEM_UNIT, SUM(DY_IK_ITEM_QTY) AS amount FROM DEITY_RECEIPT JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE '.$queryString.' GROUP BY DEITY_RECEIPT.RECEIPT_DEITY_ID, DEITY_INKIND_OFFERED.DY_IK_ITEM_ID';
			} else {
				$sql  = 'SELECT DEITY_RECEIPT.RECEIPT_DEITY_NAME,DEITY_INKIND_OFFERED.RECEIPT_ID, DEITY_RECEIPT.RECEIPT_DATE, DEITY_INKIND_OFFERED.DY_IK_ITEM_QTY,DY_IK_ITEM_NAME,DY_IK_ITEM_UNIT, SUM(DY_IK_ITEM_QTY) AS amount FROM DEITY_RECEIPT JOIN `DEITY_INKIND_OFFERED` ON `DEITY_INKIND_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 5 and RECEIPT_ACTIVE = 1 GROUP BY DEITY_RECEIPT.RECEIPT_DEITY_ID, DEITY_INKIND_OFFERED.DY_IK_ITEM_ID';
			}
			$query = $this->db->query($sql);
			$data['inkind'] = $query->result("array");
			$_SESSION['inkind'] = $data['inkind'];
			
			//SEVA
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					$queryString .= "STR_TO_DATE(DEITY_RECEIPT.RECEIPT_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates[count($allDates)-1]."','%d-%m-%Y')";
				}
				
				$sql  = 'SELECT if(SO_QUANTITY > 1, SUM(POSTAGE_PRICE), SUM(DISTINCT(POSTAGE_PRICE))) AS POSTAGE_PRICE, SO_DEITY_NAME, DEITY_RECEIPT.RECEIPT_DATE, if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY)) ,SO_SEVA_NAME, if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE)) FROM DEITY_RECEIPT JOIN `DEITY_SEVA_OFFERED` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE '.$queryString.' AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 1 and RECEIPT_ACTIVE = 1) GROUP BY `DEITY_SEVA_OFFERED`.`SO_SEVA_ID` ORDER BY `DEITY_SEVA_OFFERED`.`SO_DEITY_ID`, `DEITY_SEVA_OFFERED`.`SO_SEVA_NAME` ASC';

				$sql2  = 'SELECT POSTAGE_PRICE FROM DEITY_RECEIPT WHERE '.$queryString.'AND (DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 1 and RECEIPT_ACTIVE = 1)';
			} else {
				$sql  = 'SELECT if(SO_QUANTITY > 1, SUM(POSTAGE_PRICE), SUM(DISTINCT(POSTAGE_PRICE))) AS POSTAGE_PRICE, SO_DEITY_NAME, DEITY_RECEIPT.RECEIPT_DATE, if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY)) ,SO_SEVA_NAME, if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE)) FROM DEITY_RECEIPT JOIN `DEITY_SEVA_OFFERED` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 1 and RECEIPT_ACTIVE = 1 GROUP BY `DEITY_SEVA_OFFERED`.`SO_SEVA_ID` ORDER BY `DEITY_SEVA_OFFERED`.`SO_DEITY_ID`, `DEITY_SEVA_OFFERED`.`SO_SEVA_NAME` ASC ';

				$sql2  = 'SELECT POSTAGE_PRICE FROM DEITY_RECEIPT WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 1 and RECEIPT_ACTIVE = 1';
			}
			$query = $this->db->query($sql);
			$data['seva'] = $query->result("array");
			$_SESSION['seva'] = $data['seva'];

			$query2 = $this->db->query($sql2);
			$data['sevaPostage'] = $query2->result("array");
			$_SESSION['sevaPostage'] = $data['sevaPostage'];
			
			//CANCELLED
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 1 and RECEIPT_ACTIVE = 0";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 1 and RECEIPT_ACTIVE = 0";
					}
				}
				
				$sql  = 'SELECT SO_DEITY_NAME, DEITY_RECEIPT.RECEIPT_DATE, if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY)) ,SO_SEVA_NAME, if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE)) FROM DEITY_RECEIPT JOIN `DEITY_SEVA_OFFERED` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE '.$queryString.' GROUP BY `DEITY_SEVA_OFFERED`.`SO_SEVA_ID` ORDER BY `DEITY_SEVA_OFFERED`.`SO_DEITY_ID`, `DEITY_SEVA_OFFERED`.`SO_SEVA_NAME` ASC';
			} else {
				$sql  = 'SELECT SO_DEITY_NAME, DEITY_RECEIPT.RECEIPT_DATE, if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY)) ,SO_SEVA_NAME, if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE)) FROM DEITY_RECEIPT JOIN `DEITY_SEVA_OFFERED` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 1 and RECEIPT_ACTIVE = 0 GROUP BY `DEITY_SEVA_OFFERED`.`SO_SEVA_ID` ORDER BY `DEITY_SEVA_OFFERED`.`SO_DEITY_ID`, `DEITY_SEVA_OFFERED`.`SO_SEVA_NAME` ASC';
			}
			$query = $this->db->query($sql);
			$data['cancelled'] = $query->result("array");
			$_SESSION['cancelled'] = $data['cancelled'];

			//BOOKING CANCELLED
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "SEVA_BOOKING.DEACTIVE_DATE='".$allDates[$i]."' and SB_ACTIVE = 0 and SB_PAYMENT_STATUS = 3";
						else
							$queryString .= " or SEVA_BOOKING.DEACTIVE_DATE='".$allDates[$i]."' and SB_ACTIVE = 0 and SB_PAYMENT_STATUS = 3";
					}
				}
				
				$sql  = 'SELECT * FROM SEVA_BOOKING JOIN `DEITY_SEVA_OFFERED` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` WHERE '.$queryString.' ORDER BY `DEITY_SEVA_OFFERED`.`SO_DEITY_ID`, `DEITY_SEVA_OFFERED`.`SO_SEVA_NAME` ASC';
			} else {
				$sql  = 'SELECT * FROM SEVA_BOOKING JOIN `DEITY_SEVA_OFFERED` ON `DEITY_SEVA_OFFERED`.`SO_SB_ID` = `SEVA_BOOKING`.`SB_ID` WHERE SEVA_BOOKING.DEACTIVE_DATE="'.$date.'" and SB_ACTIVE = 0 and SB_PAYMENT_STATUS = 3 ORDER BY `DEITY_SEVA_OFFERED`.`SO_DEITY_ID`, `DEITY_SEVA_OFFERED`.`SO_SEVA_NAME` ASC';
			}
			$query = $this->db->query($sql);
			$data['bookingCancelled'] = $query->result("array");
			$_SESSION['bookingCancelled'] = $data['bookingCancelled'];
			
			//PAYMENT MODE
			//CASH TOTAL
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_PAYMENT_METHOD=\"Cash\" and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_PAYMENT_METHOD=\"Cash\" and RECEIPT_ACTIVE = 1";
					}
				}
				
				$sqlPayCash = 'SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlPayCash = 'SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.RECEIPT_PAYMENT_METHOD = "Cash" and RECEIPT_ACTIVE = 1';
			}
			$queryPayCash = $this->db->query($sqlPayCash);
			$data['PayCash'] = $queryPayCash->first_row()->PRICE;
			$_SESSION['PayCash'] = $data['PayCash'];
			
			//CHEQUE TOTAL
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_PAYMENT_METHOD=\"Cheque\" and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_PAYMENT_METHOD=\"Cheque\" and RECEIPT_ACTIVE = 1";
					}
				}
				
				$sqlPayCheque = 'SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlPayCheque = 'SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.RECEIPT_PAYMENT_METHOD = "Cheque" and RECEIPT_ACTIVE = 1';
			}
			$queryPayCheque = $this->db->query($sqlPayCheque);
			$data['PayCheque'] = $queryPayCheque->first_row()->PRICE;
			$_SESSION['PayCheque'] = $data['PayCheque'];
			
			//DIRECT CARD TOTAL
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_PAYMENT_METHOD=\"Direct Credit\" and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_PAYMENT_METHOD=\"Direct Credit\" and RECEIPT_ACTIVE = 1";
					}
				}
				
				$sqlPayDirect = 'SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlPayDirect = 'SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.RECEIPT_PAYMENT_METHOD = "Direct Credit" and RECEIPT_ACTIVE = 1';
			}
			
			$queryPayDirect = $this->db->query($sqlPayDirect);
			$data['PayDirect'] = $queryPayDirect->first_row()->PRICE;
			$_SESSION['PayDirect'] = $data['PayDirect'];
			
			//CREDIT CARD TOTAL
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_PAYMENT_METHOD=\"Credit / Debit Card\" and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_PAYMENT_METHOD=\"Credit / Debit Card\" and RECEIPT_ACTIVE = 1";
					}
				}
				$sqlPayCredit = 'SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlPayCredit = 'SELECT (SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.RECEIPT_PAYMENT_METHOD = "Credit / Debit Card" and RECEIPT_ACTIVE = 1';
			}
			$queryPayCredit = $this->db->query($sqlPayCredit);
			$data['PayCredit'] = $queryPayCredit->first_row()->PRICE;
			$_SESSION['PayCredit'] = $data['PayCredit'];

			//FOR TAB NAME
			$queryString = "";
			//$queryString .= "DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID!= 8 and DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID!= 9 AND DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID!= 10";
			$this->db->select()->from('DEITY_RECEIPT_CATEGORY');
			//$this->db->where($queryString);
			$query = $this->db->get();
			$data['deityReceiptCategory'] = $query->result("array");
			$_SESSION['deityReceiptCategory'] = $data['deityReceiptCategory'];
			//FOR EVENT NAME
			$data['event'] = $this->obj_events->getEvents();
			$_SESSION['event'] = $data['event']['ET_NAME'];
			
			//FOR REVISION
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 1 AND REVISION_PRICE_CHECKER=1 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 1 AND REVISION_PRICE_CHECKER=1 and RECEIPT_ACTIVE = 1";
					}
				}
				
				$sql  = 'SELECT POSTAGE_PRICE, SO_DEITY_NAME, DEITY_RECEIPT.RECEIPT_DATE, if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY)) ,SO_SEVA_NAME, if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE)) FROM DEITY_RECEIPT JOIN `DEITY_SEVA_OFFERED` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE '.$queryString.' GROUP BY `DEITY_SEVA_OFFERED`.`SO_SEVA_NAME`';
			} else {
				$sql  = 'SELECT POSTAGE_PRICE, SO_DEITY_NAME, DEITY_RECEIPT.RECEIPT_DATE, if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY)) ,SO_SEVA_NAME, if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE)) FROM DEITY_RECEIPT JOIN `DEITY_SEVA_OFFERED` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 1 AND REVISION_PRICE_CHECKER=1 and RECEIPT_ACTIVE = 1 GROUP BY `DEITY_SEVA_OFFERED`.`SO_SEVA_NAME`';
			}
			$query = $this->db->query($sql);
			$data['revision'] = $query->result("array");
			$_SESSION['revision'] = $data['revision'];
			
			//BOOKING
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 1 AND SO_IS_BOOKING=1 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 1 AND SO_IS_BOOKING=1 and RECEIPT_ACTIVE = 1";
					}
				}
				
				$sql  = 'SELECT SO_DEITY_NAME, DEITY_RECEIPT.RECEIPT_DATE, if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY)) ,SO_SEVA_NAME, if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE)) FROM DEITY_RECEIPT JOIN `DEITY_SEVA_OFFERED` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE '.$queryString.' GROUP BY `DEITY_SEVA_OFFERED`.`SO_SEVA_NAME`';
			} else {
				$sql  = 'SELECT SO_DEITY_NAME, DEITY_RECEIPT.RECEIPT_DATE, if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY)) ,SO_SEVA_NAME, if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE)) FROM DEITY_RECEIPT JOIN `DEITY_SEVA_OFFERED` ON `DEITY_SEVA_OFFERED`.`RECEIPT_ID` = `DEITY_RECEIPT`.`RECEIPT_ID` WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 1 AND SO_IS_BOOKING = 1 and RECEIPT_ACTIVE = 1 GROUP BY `DEITY_SEVA_OFFERED`.`SO_SEVA_NAME`';
			}
			
			$query = $this->db->query($sql);
			$data['booking'] = $query->result("array");
			$_SESSION['booking'] = $data['booking'];
			
			//SRNS
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 6 and RECEIPT_ACTIVE = 1";
					else
						$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 6 and RECEIPT_ACTIVE = 1";
				}
			}
			
			if(@$radioOpt == "multiDate") {
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else {
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 6,'RECEIPT_ACTIVE' => 1));
			}
			
			$query = $this->db->get();
			$data['srns'] = $query->result("array");
			$_SESSION['srns'] = $data['srns'];
			
			//COUNT OF SRNS
			if(@$radioOpt == "multiDate") {
				$sqlSRNS = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlSRNS = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 6  and RECEIPT_ACTIVE = 1';
			}
			
			$queryDKC = $this->db->query($sqlSRNS);
			$row=$query->num_rows();
			$data['srnsCount'] = $row;
			$_SESSION['srnsCount'] = $data['srnsCount'];
			
			//SRNS ALL DETAILS
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 6 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 6 and RECEIPT_ACTIVE = 1";
					}
				}
				
				$sqlSRNS = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlSRNS = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 6 and RECEIPT_ACTIVE = 1';
			}
			$querySRNS = $this->db->query($sqlSRNS);
			$data['srns_details'] = $querySRNS->result('array');
			$_SESSION['srns_details'] = $data['srns_details'];
			
			//CANCELLED SRNS
			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i) {
					if($i == 0)
						$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 6 and RECEIPT_ACTIVE = 0";
					else
						$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 6 and RECEIPT_ACTIVE = 0";
				}
			}
			
			if(@$radioOpt == "multiDate") {
				$this->db->select()->from('DEITY_RECEIPT');
				$this->db->where($queryString);
			} else {
				$this->db->select()->from('DEITY_RECEIPT')
				->where(array('DEITY_RECEIPT.RECEIPT_DATE'=>$date,'RECEIPT_CATEGORY_ID'=> 6,'RECEIPT_ACTIVE' => 0));
			}
			
			$query = $this->db->get();
			$data['cancelledSRNS'] = $query->result("array");
			$_SESSION['cancelledSRNS'] = $data['cancelledSRNS'];
			
			//COUNT OF CANCELLED SRNS
			if(@$radioOpt == "multiDate") {
				$sqlSRNS = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlSRNS = 'SELECT COUNT(RECEIPT_ID) FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 6  and RECEIPT_ACTIVE = 0';
			}
			
			$querySRNS = $this->db->query($sqlSRNS);
			$row=$querySRNS->num_rows();
			$data['cancelledSRNSCount'] = $row;
			$_SESSION['cancelledSRNSCount'] = $data['cancelledSRNSCount'];
			
			//CANCELLED SRNS ALL DETAILS
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 6 and RECEIPT_ACTIVE = 0";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 6 and RECEIPT_ACTIVE = 0";
					}
				}
				
				$sqlSRNS = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE '.$queryString.'';
			} else {
				$sqlSRNS = 'SELECT * FROM DEITY_RECEIPT JOIN DEITY_RECEIPT_CATEGORY ON DEITY_RECEIPT_CATEGORY.RECEIPT_CATEGORY_ID = DEITY_RECEIPT.RECEIPT_CATEGORY_ID WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 6 and RECEIPT_ACTIVE = 0';
			}
			$querySRNS = $this->db->query($sqlSRNS);
			$data['cancelled_srns_details'] = $querySRNS->result('array');
			$_SESSION['cancelled_srns_details'] = $data['cancelled_srns_details'];
			
			//SHASHWATH
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 and RECEIPT_ACTIVE = 1";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 and RECEIPT_ACTIVE = 1";
					}
				}
				
				$sql  = 'SELECT DEITY_NAME,SEVA_NAME,SEVA_NOTES,COUNT(SEVA_NAME) AS QTY,SUM(RECEIPT_PRICE) AS TOTAL FROM `SHASHWATH_SEVA` JOIN `DEITY_RECEIPT` ON `DEITY_RECEIPT`.`SS_ID` = `SHASHWATH_SEVA`.`SS_ID` JOIN 		`DEITY_SEVA` ON `DEITY_SEVA`.`SEVA_ID` = `SHASHWATH_SEVA`.`SEVA_ID` JOIN `DEITY` ON `DEITY`.`DEITY_ID` = `SHASHWATH_SEVA`.`DEITY_ID` WHERE '.$queryString.' AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 7 AND RECEIPT_ACTIVE = 1 GROUP BY SEVA_NAME';
			} else {
				$sql  = 'SELECT DEITY_NAME,SEVA_NAME,SEVA_NOTES,COUNT(SEVA_NAME) AS QTY,SUM(RECEIPT_PRICE) AS TOTAL FROM `SHASHWATH_SEVA` JOIN `DEITY_RECEIPT` ON `DEITY_RECEIPT`.`SS_ID` = `SHASHWATH_SEVA`.`SS_ID` JOIN `DEITY_SEVA` ON `DEITY_SEVA`.`SEVA_ID` = `SHASHWATH_SEVA`.`SEVA_ID` JOIN `DEITY` ON `DEITY`.`DEITY_ID` = `SHASHWATH_SEVA`.`DEITY_ID` WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 7 AND `RECEIPT_ACTIVE` = 1 GROUP BY SEVA_NAME';
			}
			$query = $this->db->query($sql);
			$data['shashwath'] = $query->result("array");
			$_SESSION['shashwath'] = $data['shashwath'];
			
			// SHASHWATH CANCELLED
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 and RECEIPT_ACTIVE = 0";
						else
							$queryString .= " or DEITY_RECEIPT.RECEIPT_DATE='".$allDates[$i]."' and DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 and RECEIPT_ACTIVE = 0";
					}
				}
				
				$sql  = 'SELECT * FROM `SHASHWATH_SEVA` JOIN `DEITY_RECEIPT` ON `DEITY_RECEIPT`.`SS_ID` = `SHASHWATH_SEVA`.`SS_ID` JOIN `DEITY_SEVA` ON `DEITY_SEVA`.`SEVA_ID` = `SHASHWATH_SEVA`.`SEVA_ID` JOIN `DEITY` ON `DEITY`.`DEITY_ID` = `SHASHWATH_SEVA`.`DEITY_ID` WHERE '.$queryString.' AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 7 AND RECEIPT_ACTIVE = 0';
			} else {
				$sql  = 'SELECT * FROM `SHASHWATH_SEVA` JOIN `DEITY_RECEIPT` ON `DEITY_RECEIPT`.`SS_ID` = `SHASHWATH_SEVA`.`SS_ID` JOIN `DEITY_SEVA` ON `DEITY_SEVA`.`SEVA_ID` = `SHASHWATH_SEVA`.`SEVA_ID` JOIN `DEITY` ON `DEITY`.`DEITY_ID` = `SHASHWATH_SEVA`.`DEITY_ID` WHERE `DEITY_RECEIPT`.`RECEIPT_DATE` = "'.$date.'" AND `DEITY_RECEIPT`.`RECEIPT_CATEGORY_ID` = 7 AND RECEIPT_ACTIVE = 0';
			}
			$query = $this->db->query($sql);
			$data['cancelled_shashwath'] = $query->result("array");
			$_SESSION['cancelled_shashwath'] = $data['cancelled_shashwath']; 
			

			if(isset($_SESSION['Deity_MIS_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('deity_mis_report');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}
		
		//MIS REPORT FOR EVENT
		//Above code commented while merging intern Lathesh code
		function misReport() {
			if(@$_SESSION['eventActiveCount'] == 0)
				redirect('login');
			
			$data['whichTab'] = "report";
			if(isset($_POST['date'])) {
				$date = $_POST['date']; 
			} else {
				$date = date('d-m-Y');
			}
			
			$data['date'] = $date;
			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			$fromDate = @$_POST['fromDate'];
			$toDate = @$_POST['toDate'];
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			

			if(@$_POST['allDates'] != "") {
				$allDates = explode("|",$_POST['allDates']);
				$queryString = "";
				for($i = 0; $i < count($allDates); ++$i){
					if($i == 0)
						$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."'  and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID=2";
					else
						$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID=2";
				}
			}
			

			if(@$radioOpt == "multiDate") {
				$this->db->select()->from('EVENT_RECEIPT')->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID')->where($queryString);
			} else {
				//donation kanika
				$this->db->select()->from('EVENT_RECEIPT')->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID')->where(array('EVENT_RECEIPT.ET_RECEIPT_DATE'=>$date,'ET_RECEIPT_CATEGORY_ID'=>2,'ET_RECEIPT_ACTIVE'=>1));
			}
			
			$query = $this->db->get();
			$data['donation'] = $query->result("array");
			$_SESSION['donation'] = $data['donation'];


			
			if(@$radioOpt == "multiDate") {
				$sqlDKC = 'SELECT COUNT(ET_RECEIPT_ID) FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE '.$queryString.'';
			} else {
				//Count Of Donation Kanike			
				$sqlDKC = 'SELECT COUNT(ET_RECEIPT_ID) FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE ET_ACTIVE = 1 and `EVENT_RECEIPT`.`ET_RECEIPT_DATE` = "'.$date.'" AND `EVENT_RECEIPT`.`ET_RECEIPT_CATEGORY_ID` = 2 and ET_RECEIPT_ACTIVE=1';
			}
			
			$queryDKC = $this->db->query($sqlDKC);
			$row=$query->num_rows();
			$data['donationCount'] = $row;
			$_SESSION['donationCount'] = $data['donationCount'];


			// Start Of Cancelled Donation Receipts Single Date & Multidate
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=0  and EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID=2";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=0  and EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID=2";
					}
				}

				$sqlDK = 'SELECT * FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE '.$queryString.'';
			} else {
			//DONATION/KANIKE
				$sqlDK = 'SELECT * FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE ET_ACTIVE = 1 and `EVENT_RECEIPT`.`ET_RECEIPT_DATE` = "'.$date.'" AND `EVENT_RECEIPT`.`ET_RECEIPT_CATEGORY_ID` = 2 and ET_RECEIPT_ACTIVE=0';
			}
			$queryDK = $this->db->query($sqlDK);
			$data['cancelled_donation_details'] = $queryDK->result('array');
			$_SESSION['cancelled_donation_details'] = $data['cancelled_donation_details'];
		// End Of Cancelled Donation Receipts Single Date & Multidate



			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_CATEGORY_ID=3";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."'  and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_CATEGORY_ID=3";
					}
				}
				
				$this->db->select()->from('EVENT_RECEIPT')->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
				$this->db->where($queryString);
			} else { 
				//hundi
				$this->db->select()->from('EVENT_RECEIPT')->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID')
				->where(array('EVENT_RECEIPT.ET_RECEIPT_DATE'=>$date,'ET_RECEIPT_CATEGORY_ID'=>3,'ET_RECEIPT_ACTIVE'=>1));
			}
			$query = $this->db->get();
			$data['hundi'] = $query->result("array");
			$_SESSION['hundi'] = $data['hundi'];
			$_SESSION['hundinew'] = $data['hundi']; // duplicate session variable becouse above value is getting re assigned to empty
			

			// Start Of Cancelled Hundi Receipts Single Date & Multidate
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=0 and ET_RECEIPT_CATEGORY_ID=3";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."'  and ET_RECEIPT_ACTIVE=0 and ET_RECEIPT_CATEGORY_ID=3";
					}
				}

				$this->db->select()->from('EVENT_RECEIPT')->join('EVENT', 'EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID');
				$this->db->where($queryString);
			} else { 
			//hundi
				$this->db->select()->from('EVENT_RECEIPT')->join('EVENT','EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID')
				->where(array('EVENT_RECEIPT.ET_RECEIPT_DATE'=>$date,'ET_RECEIPT_CATEGORY_ID'=>3,'ET_RECEIPT_ACTIVE'=>0));
			}
			$query = $this->db->get();
			$data['hundicancelled'] = $query->result("array");
			$_SESSION['hundicancelled'] = $data['hundicancelled'];
			// End Of Cancelled Hundi Receipts Single Date & Multidate

			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) { 
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_CATEGORY_ID=4";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_CATEGORY_ID=4";
					}
				}
				// Suraksha code
				$sql  = 'SELECT EVENT_RECEIPT.ET_RECEIPT_NO, EVENT_RECEIPT.ET_RECEIPT_NAME,EVENT_RECEIPT.ET_RECEIPT_DATE, EVENT_INKIND_OFFERED.IK_ITEM_QTY,IK_ITEM_NAME,IK_ITEM_UNIT, SUM(IK_ITEM_QTY) AS amount FROM EVENT_RECEIPT JOIN `EVENT_INKIND_OFFERED` ON `EVENT_INKIND_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE '.$queryString.' GROUP BY EVENT_INKIND_OFFERED.IK_ITEM_NAME';
			} else {
				//inkind
				// Suraksha Code
				$sql  = 'SELECT EVENT_RECEIPT.ET_RECEIPT_NO, EVENT_RECEIPT.ET_RECEIPT_NAME,EVENT_RECEIPT.ET_RECEIPT_DATE, EVENT_INKIND_OFFERED.IK_ITEM_QTY,IK_ITEM_NAME,IK_ITEM_UNIT, SUM(IK_ITEM_QTY) AS amount FROM EVENT_RECEIPT JOIN `EVENT_INKIND_OFFERED` ON `EVENT_INKIND_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE ET_ACTIVE = 1 and `EVENT_RECEIPT`.`ET_RECEIPT_DATE` = "'.$date.'" AND `EVENT_RECEIPT`.`ET_RECEIPT_CATEGORY_ID` = 4  and ET_RECEIPT_ACTIVE=1  GROUP BY `EVENT_INKIND_OFFERED`.`IK_ITEM_NAME`';
			}
			$query = $this->db->query($sql);
			$data['inkind'] = $query->result("array");
			$_SESSION['inkind'] = $data['inkind'];
			
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."'  and ET_RECEIPT_ACTIVE = 1  and EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID=1";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE = 1  and EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID=1";
					}
				}
				
				$sql  = 'SELECT if(ET_SO_QUANTITY > 1, SUM(POSTAGE_PRICE), SUM(DISTINCT(POSTAGE_PRICE))) AS POSTAGE_PRICE, EVENT_RECEIPT.ET_RECEIPT_DATE, if(ET_SO_IS_SEVA = 1, count(ET_SO_SEVA_NAME), SUM(ET_SO_QUANTITY)) ,ET_SO_SEVA_NAME, if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE)) FROM EVENT_RECEIPT JOIN `EVENT_SEVA_OFFERED` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE '.$queryString.' GROUP BY `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_NAME`';
			} else {
				//SEVA
				$sql  = 'SELECT if(ET_SO_QUANTITY > 1, SUM(POSTAGE_PRICE), SUM(DISTINCT(POSTAGE_PRICE))) AS POSTAGE_PRICE, EVENT_RECEIPT.ET_RECEIPT_DATE, if(ET_SO_IS_SEVA = 1, count(ET_SO_SEVA_NAME), SUM(ET_SO_QUANTITY)) ,ET_SO_SEVA_NAME, if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE)) FROM EVENT_RECEIPT JOIN `EVENT_SEVA_OFFERED` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE ET_ACTIVE = 1 and `EVENT_RECEIPT`.`ET_RECEIPT_DATE` = "'.$date.'" AND `EVENT_RECEIPT`.`ET_RECEIPT_CATEGORY_ID` = 1 and ET_RECEIPT_ACTIVE = 1 GROUP BY `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_NAME`';
			}
			$query = $this->db->query($sql);
			$data['seva'] = $query->result("array");
			$_SESSION['seva'] = $data['seva'];
			
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."'  and ET_RECEIPT_ACTIVE = 0  and EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID=1";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE = 0  and EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID=1";
					}
				}
				
				$sql  = 'SELECT if(ET_SO_QUANTITY > 1, SUM(POSTAGE_PRICE), SUM(DISTINCT(POSTAGE_PRICE))) AS POSTAGE_PRICE,EVENT_RECEIPT.ET_RECEIPT_DATE, if(ET_SO_IS_SEVA = 1, count(ET_SO_SEVA_NAME), SUM(ET_SO_QUANTITY)) ,ET_SO_SEVA_NAME, if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE)) FROM EVENT_RECEIPT JOIN `EVENT_SEVA_OFFERED` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE '.$queryString.' GROUP BY `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_NAME`';
			} else {
				//CANCELLED SEVA
				$sql  = 'SELECT if(ET_SO_QUANTITY > 1, SUM(POSTAGE_PRICE), SUM(DISTINCT(POSTAGE_PRICE))) AS POSTAGE_PRICE,EVENT_RECEIPT.ET_RECEIPT_DATE, if(ET_SO_IS_SEVA = 1, count(ET_SO_SEVA_NAME), SUM(ET_SO_QUANTITY)) ,ET_SO_SEVA_NAME, if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE)) FROM EVENT_RECEIPT JOIN `EVENT_SEVA_OFFERED` ON `EVENT_SEVA_OFFERED`.`ET_RECEIPT_ID` = `EVENT_RECEIPT`.`ET_RECEIPT_ID` JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE ET_ACTIVE = 1 and `EVENT_RECEIPT`.`ET_RECEIPT_DATE` = "'.$date.'" AND `EVENT_RECEIPT`.`ET_RECEIPT_CATEGORY_ID` = 1 and ET_RECEIPT_ACTIVE = 0 GROUP BY `EVENT_SEVA_OFFERED`.`ET_SO_SEVA_NAME`';
			}
			$query = $this->db->query($sql);
			$data['cancelledSeva'] = $query->result("array");
			$_SESSION['cancelledSeva'] = $data['cancelledSeva'];
			
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID=2";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID=2";
					}
				}
				
				$sqlDK = 'SELECT * FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE '.$queryString.'';
			} else {
				//DONATION/KANIKE
				$sqlDK = 'SELECT * FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE ET_ACTIVE = 1 and `EVENT_RECEIPT`.`ET_RECEIPT_DATE` = "'.$date.'" AND `EVENT_RECEIPT`.`ET_RECEIPT_CATEGORY_ID` = 2 and ET_RECEIPT_ACTIVE=1';
			}
			$queryDK = $this->db->query($sqlDK);
			$data['donation_details'] = $queryDK->result('array');
			$_SESSION['donation_details'] = $data['donation_details'];
			
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_PAYMENT_METHOD=\"Cash\"";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_PAYMENT_METHOD=\"Cash\"";
					}
				}
				
				$sqlPayCash = 'SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE '.$queryString.'';
			} else {
				//PAYMENT MODE
				$sqlPayCash = 'SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE ET_ACTIVE = 1 and `EVENT_RECEIPT`.`ET_RECEIPT_DATE` = "'.$date.'" AND `EVENT_RECEIPT`.ET_RECEIPT_PAYMENT_METHOD = "Cash" and ET_RECEIPT_ACTIVE=1';
			}
			$queryPayCash = $this->db->query($sqlPayCash);
			$data['PayCash'] = $queryPayCash->first_row()->PRICE;
			$_SESSION['PayCash'] = $data['PayCash'];
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_PAYMENT_METHOD=\"Cheque\"";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_PAYMENT_METHOD=\"Cheque\"";
					}
				}
				
				$sqlPayCheque = 'SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE '.$queryString.'';
			} else {
				$sqlPayCheque = 'SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE ET_ACTIVE = 1 and `EVENT_RECEIPT`.`ET_RECEIPT_DATE` = "'.$date.'" AND `EVENT_RECEIPT`.ET_RECEIPT_PAYMENT_METHOD = "Cheque" and ET_RECEIPT_ACTIVE=1';
			}
			$queryPayCheque = $this->db->query($sqlPayCheque);
			$data['PayCheque'] = $queryPayCheque->first_row()->PRICE;
			$_SESSION['PayCheque'] = $data['PayCheque'];
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_PAYMENT_METHOD=\"Direct Credit\"";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_PAYMENT_METHOD=\"Direct Credit\"";
					}
				}
				
				$sqlPayDirect = 'SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE '.$queryString.'';
			} else {
				$sqlPayDirect = 'SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE ET_ACTIVE = 1 and `EVENT_RECEIPT`.`ET_RECEIPT_DATE` = "'.$date.'" AND `EVENT_RECEIPT`.ET_RECEIPT_PAYMENT_METHOD = "Direct Credit" and ET_RECEIPT_ACTIVE=1';
			}
			
			$queryPayDirect = $this->db->query($sqlPayDirect);
			$data['PayDirect'] = $queryPayDirect->first_row()->PRICE;
			$_SESSION['PayDirect'] = $data['PayDirect'];
			if(@$radioOpt == "multiDate") {
				if(@$_POST['allDates'] != "") {
					$allDates = explode("|",$_POST['allDates']);
					$queryString = "";
					for($i = 0; $i < count($allDates); ++$i) {
						if($i == 0)
							$queryString .= "ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_PAYMENT_METHOD=\"Credit / Debit Card\"";
						else
							$queryString .= " or ET_ACTIVE = 1 and EVENT_RECEIPT.ET_RECEIPT_DATE='".$allDates[$i]."' and ET_RECEIPT_ACTIVE=1  and EVENT_RECEIPT.ET_RECEIPT_PAYMENT_METHOD=\"Credit / Debit Card\"";
					}
				}
				$sqlPayCredit = 'SELECT (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE '.$queryString.'';
			} else {
				$sqlPayCredit = 'SELECT(SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS PRICE FROM EVENT_RECEIPT JOIN EVENT_RECEIPT_CATEGORY ON EVENT_RECEIPT_CATEGORY.ET_RECEIPT_CATEGORY_ID = EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID WHERE ET_ACTIVE = 1 and `EVENT_RECEIPT`.`ET_RECEIPT_DATE` = "'.$date.'" and ET_RECEIPT_ACTIVE=1 AND `EVENT_RECEIPT`.ET_RECEIPT_PAYMENT_METHOD = "Credit / Debit Card"';
			}
			$queryPayCredit = $this->db->query($sqlPayCredit);
			$data['PayCredit'] = $queryPayCredit->first_row()->PRICE;
			$_SESSION['PayCredit'] = $data['PayCredit'];

			//for tab name
			$this->db->select()->from('EVENT_RECEIPT_CATEGORY');
			$query = $this->db->get();
			$data['eventReceiptCategory'] = $query->result("array");
			$_SESSION['eventReceiptCategory'] = $data['eventReceiptCategory'];
			//for event name
			$data['event'] = $this->obj_events->getEvents();
			$_SESSION['event'] = $data['event']['ET_NAME'];
			
			if(isset($_SESSION['Current_Event_MIS_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('misReport');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		//DEITY RECEIPT REPORT ON CHANGE OF FIELD
		function temple_day_book_on_change_date($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDate'])) {
				$fromDate = @$_POST['fromDate'];
				$toDate = @$_POST['toDate'];
				$_SESSION['fromDate'] = $fromDate;
				$_SESSION['toDate'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDate'];
				$toDate = $_SESSION['toDate'];
			}
			
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}

			//NEWCODE_28-03_START
			if(isset($_POST['receiptCat'])) {
				$data['receiptCat'] = $receiptCat = @$_POST['receiptCat'];
				$_SESSION['receiptCat'] = $receiptCat;
			} else {
				$data['receiptCat'] = $receiptCat = $_SESSION['receiptCat'];
			}
			//NEWCODE_28-03_END

			$this->load->library('pagination');
			if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
				$data['temple_day_book'] = $this->obj_report->get_all_field_temple_day_book($_SESSION['fromDate'],$_SESSION['toDate'],'','', 10,$start,$receiptCat);
				$data['temple_day_bookTotal'] = $this->obj_report->get_all_field_temple_day_book_account_summary($_SESSION['fromDate'],$_SESSION['toDate'],$receiptCat);
				$data['total_rows'] = $config['total_rows'] = $this->obj_report->count_all_field_temple_day_book($_SESSION['fromDate'],$_SESSION['toDate'],$receiptCat);
				
			} else {
				$data['temple_day_book'] = $this->obj_report->get_all_field_temple_day_book($_SESSION['date'],'','','', 10,$start,$receiptCat);
				$data['temple_day_bookTotal'] = $this->obj_report->get_all_field_temple_day_book_account_summary($_SESSION['date'],'',$receiptCat);
				$data['total_rows'] = $config['total_rows'] = $this->obj_report->count_all_field_temple_day_book($_SESSION['date'],'',$receiptCat);
			}
			//print_r($data['temple_day_book']);
			//$this->output->enable_profiler(true);
			//pagination starts
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			$config['base_url'] = base_url().'Report/temple_day_book_on_change_date';
			
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
			
			
			if(isset($_SESSION['Temple_Day_Book'])) {
				$this->load->view('header', $data);
				$this->load->view('templeDayBook');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		function temple_day_book_excel() {
			$data['whichTab'] = "report";
			if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
				$temple_day_book = $this->obj_report->get_all_field_temple_day_book_excel($_SESSION['fromDate'],$_SESSION['toDate'],'','',$_SESSION['receiptCat']);
				$temple_day_bookTotal = $this->obj_report->get_all_field_temple_day_book_account_summary($_SESSION['fromDate'],$_SESSION['toDate'],$_SESSION['receiptCat']);
				$filename = "Temple_Day_Book_from_".$_SESSION['fromDate']. "_to_".$_SESSION['toDate']; //File Name
			} else if(@$_SESSION['date']){
				$temple_day_book = $this->obj_report->get_all_field_temple_day_book_excel($_SESSION['date'],'','','',$_SESSION['receiptCat']);
				$temple_day_bookTotal = $this->obj_report->get_all_field_temple_day_book_account_summary($_SESSION['date'],'',$_SESSION['receiptCat']);
				$filename = "Temple_Day_Book_".$_SESSION['date']; //File Name
			} else {
				$temple_day_book = $this->obj_report->get_all_field_temple_day_book_excel(date("d-m-Y"),'','','',$_SESSION['receiptCat']);
				$temple_day_bookTotal = $this->obj_report->get_all_field_temple_day_book_account_summary(date("d-m-Y"),'',$_SESSION['receiptCat']);
				$filename = "Temple_Day_Book_".date("d-m-Y"); //File Name
			}

			$file_ending = "xls";
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			$header = "";
			
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";
			$header .= "SI NO." . "\t";
			$header .= "Receipt No" . "\t";
			$header .= "Receipt Date" . "\t";
			$header .= "Receipt For" . "\t";
			$header .= "Receipt Type" . "\t";
			$header .= "Seva Name" . "\t";
			$header .= "Deity/Event" . "\t";
			$header .= "Name" . "\t";
			$header .= "Estimated Price" . "\t";
			$header .= "Description" . "\t";
			$header .= "Payment Mode" . "\t";
			$header .= "Qty" . "\t";
			$header .= "Amount" . "\t";
			$header .= "Postage" . "\t";
			$header .= "Grand Total" . "\t";
			$header .= "Payment Notes" . "\t";
			// $header .= "User" . "\t";
			$header .= "Payment Status" . "\t";
			$header .= "Cancelled Notes" . "\t";
			$result = "";
			
			$amount = 0; $cash = 0; $cheque = 0; $debitCredit = 0; $directCredit = 0; $i = 0;
			$cash = $temple_day_bookTotal->CASH;
			$cheque = $temple_day_bookTotal->CHEQUE;
			$directCredit = $temple_day_bookTotal->DIRECTCREDIT;
			$debitCredit = $temple_day_bookTotal->CREDITDEBIT;
			$amount = $temple_day_bookTotal->GRANDTOTAL;
			
			foreach($temple_day_book as $res) {				
				$value = "";
				if($res->rType != "") {
					$value .= '"' . (++$i) . '"' . "\t";			
					$value .= '"' . $res->rNo . '"' . "\t";
					$value .= '"' . $res->rDate . '"' . "\t";
				} else {
					$value .= '"' . "" . '"' . "\t";			
					$value .= '"' . "" . '"' . "\t";
					$value .= '"' . "" . '"' . "\t";
				}	
				$value .= '"' . $res->receiptFor .'"'. "\t";
				$value .= '"' . $res->rType .'"'. "\t";
				$value .= '"' . $res->sevaName .'"'. "\t";
				$value .= '"' . $res->dtetName .'"'. "\t";
				$value .= '"' . $res->rName . '"' . "\t";
				$value .= '"' . $res->apprxAmt . '"' . "\t";
				$value .= '"' . $res->itemDesc . '"' . "\t";
				$value .= '"' . $res->rPayMethod . '"' . "\t";
				if($res->rType == "Inkind" || $res->rType == "Jeernodhara-Inkind") {
					$value .= '"' . $res->sevaQty . '"' . "\t";
				} else  {
					$value .= '"' . "" . '"' . "\t";
				}
				$value .= '"' . $res->amt . '"' . "\t";
				
				if($res->rType == "Seva") {
					$value .= '"' . $res->amtPostage . '"' . "\t";
				} else  {
					$value .= '"' . "" . '"' . "\t";
				}
				
				$value .= '"' . $res->total . '"' . "\t";
				$value .= '"' . $res->RPMNotes . '"' . "\t";
				// $value .= '"' . $res->user . '"' . "\t";
				$value .= '"' . $res->status . '"' . "\t";
				$value .= '"' . $res->cnclNotes . '"' . "\t";
				$result .= trim($value) . "\n";
			}
			$result .= "\n";
			
			$value = "\n";
			$value .= '"Grand Total "' . "\t";
			$value .= $amount. "\t";
			$result .= trim($value) . "\n";
			
			$result .= "\n";
			
			$value7 = "";
			$value7 .= "CASH" . "\t";
			$value7 .= "CHEQUE" . "\t";
			$value7 .= "CREDIT/DEBIT CARD" . "\t";
			$value7 .= "DIRECT CREDIT" . "\t";
			$result .= trim($value7) . "\n";
			$value8 = "";
			
			$value8 .= '"' . $cash . '"' . "\t";
			$value8 .= '"' . $cheque . '"' . "\t";
			$value8 .= '"' . $debitCredit . '"' . "\t";
			$value8 .= '"' . $directCredit . '"' . "\t";
			
			$result .= trim($value8) . "\n";	
			
			$result = str_replace( "\r" , "" , $result );
			print("$header\n$result"); 
		}
		
		function temple_inkind_report_excel() {
			$data['whichTab'] = "report";
			if(isset($_POST['inkindType'])) {
				$data['inkindType'] = $inkindType = @$_POST['modeOfInkind'];
				$_SESSION['inkindType'] = $inkindType;
			} else {
				$data['inkindType'] = $inkindType = $_SESSION['inkindType'];
			}

			if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
				$temple_day_book = $this->obj_report->get_all_temple_inkind_report_excel($_SESSION['fromDate'],$_SESSION['toDate'],'','',$inkindType);
				$filename = "Temple_Inkind_Report_from".$_SESSION['fromDate']. "_to_".$_SESSION['toDate']; //File Name
			} else if(@$_SESSION['date']){
				$temple_day_book = $this->obj_report->get_all_temple_inkind_report_excel($_SESSION['date'],'','','',$inkindType);
				$filename = "Temple_Inkind_Report_from".$_SESSION['date']; //File Name
			} else {
				$temple_day_book = $this->obj_report->get_all_temple_inkind_report_excel(date("d-m-Y"),'','','',$inkindType);
				$filename = "Temple_Inkind_Report_from".date("d-m-Y"); //File Name
			}

			$file_ending = "xls";
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			$header = "";
			
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";
			$header .= "SI NO." . "\t";
			$header .= "Receipt No" . "\t";
			$header .= "Receipt Date" . "\t";
			$header .= "Receipt For" . "\t";
			$header .= "Receipt Type" . "\t";
			$header .= "Seva Name" . "\t";
			$header .= "Deity/Event" . "\t";
			$header .= "Name" . "\t";
			$header .= "Estimated Price" . "\t";
			$header .= "Description" . "\t";
			$header .= "Payment Mode" . "\t";
			$header .= "Qty" . "\t";
			// $header .= "Postage" . "\t";
			// $header .= "Payment Notes" . "\t";
			// $header .= "User" . "\t";
			$header .= "Payment Status" . "\t";
			$result = "";
			
			$amount = 0; $cash = 0; $cheque = 0; $debitCredit = 0; $directCredit = 0; $i = 0;
			
			foreach($temple_day_book as $res) {				
				$value = "";
				if($res->rType != "") {
					$value .= '"' . (++$i) . '"' . "\t";			
					$value .= '"' . $res->rNo . '"' . "\t";
					$value .= '"' . $res->rDate . '"' . "\t";
				} else {
					$value .= '"' . "" . '"' . "\t";			
					$value .= '"' . "" . '"' . "\t";
					$value .= '"' . "" . '"' . "\t";
				}	
				$value .= '"' . $res->receiptFor .'"'. "\t";
				$value .= '"' . $res->rType .'"'. "\t";
				$value .= '"' . $res->sevaName .'"'. "\t";
				$value .= '"' . $res->dtetName .'"'. "\t";
				$value .= '"' . $res->rName . '"' . "\t";
				$value .= '"' . $res->apprxAmt . '"' . "\t";
				$value .= '"' . $res->itemDesc . '"' . "\t";
				$value .= '"' . $res->rPayMethod . '"' . "\t";
				if($res->rType == "Inkind" || $res->rType == "Jeernodhara-Inkind") {
					$value .= '"' . $res->sevaQty . '"' . "\t";
				} else  {
					$value .= '"' . "" . '"' . "\t";
				}
				
				// if($res->rType == "Seva") {
				// 	$value .= '"' . $res->amtPostage . '"' . "\t";
				// } else  {
				// 	$value .= '"' . "" . '"' . "\t";
				// }
				// $value .= '"' . $res->RPMNotes . '"' . "\t";
				// $value .= '"' . $res->user . '"' . "\t";
				$value .= '"' . $res->status . '"' . "\t";
				$result .= trim($value) . "\n";
			}
			$result .= "\n";
			
			$result = str_replace( "\r" , "" , $result );
			print("$header\n$result"); 
		}
		
		function Jeernodhara_report_excel() {
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = $_POST['radioOpt'];
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			if(isset($_POST['allDates'])) {
				$allDates= $_POST['allDates'];
			} else {
				$allDates = $_SESSION['allDates'];
			}
			
			if(isset($_POST['jeerno_users_id'])) {
				$userId = $this->input->post('jeerno_users_id');
				$this->session->set_userdata('Jeerno_User_Id', $this->input->post('jeerno_users_id'));
			} else if(@$_SESSION['Jeerno_User_Id']) {
				$userId = $_SESSION['Jeerno_User_Id'];
			}
			
			if(@$_POST['jeernoPayMethod']) {
				$payMethod = $this->input->post('jeernoPayMethod');
				$this->session->set_userdata('PMode', $this->input->post('jeernoPayMethod'));
			} else if(@$_SESSION['PMode']) {
				$payMethod = $_SESSION['PMode'];
			}
			
			$header = "";
			$result = ""; 
			
			if($radioOpt == "multiDate") {
				$filename = "Jeernodhara_daily_report_from_".$_SESSION['fromDate']."_to_".$_SESSION['toDate'].".xls";  //File Name
			}
			else {
				$filename = "Jeernodhara_daily_report_".$_POST['dateField'].".xls";
			}
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			$header = "";
			$header .= "\t";
			$header .= "\t";
			
			$header .= "SUTHU PAULI JEERNODHARA SAMITHI" . "\n\n";	
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";
			$header .= "SI NO." . "\t";
			$header .= "Receipt No" . "\t";
			$header .= "Receipt Date" . "\t";
			$header .= "Name" . "\t";
			$header .= "Phone" . "\t";
			$header .= "Address" . "\t";
			$header .= "Category" . "\t";
			$header .= "Payment Mode" . "\t";
			$header .= "Amount" . "\t";
			$header .= "Cheque No" . "\t";
			$header .= "Bank" . "\t";
			$header .= "Cheque Date" . "\t";
			$result = "";
			
			print_r($_POST['dateField']);
			if($_POST['dateField'] != "") {
				if(@$radioOpt == "multiDate") {
					$allDates1 = explode("|",$allDates);
					$queryString = "";
					$queryString1 = "";
					for($i = 0; $i < count($allDates1); ++$i) {
						if($i == 0) {
							$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1"; 
						} else {
							$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1"; 
						}
					}
					$condition= "(".$queryString.")";
				} else {
					$condition= array('RECEIPT_DATE' => $_POST['dateField'],'RECEIPT_ACTIVE' => 1); 
				}
				$res = $this->obj_receipt->get_daily_reportPdf($condition, $userId, $payMethod);
			}
			
			$totAmount = 0;
			for($i = 0; $i < sizeof($res); $i++)
			{
				$line = '';    
				$value = "";
				$value .= '"' . ($i+1) . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_NO . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_DATE . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_PHONE . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_ADDRESS . '"' . "\t";

				$value .= '"' . $res[$i]->RECEIPT_CATEGORY_TYPE . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_PAYMENT_METHOD . '"' . "\t";
				if($res[$i]->RECEIPT_CATEGORY_TYPE == "Inkind") {
					$value .= '' . "\t";
				} else {
					$value .= '"' . $res[$i]->RECEIPT_PRICE . '"' . "\t";
					$totAmount = $totAmount + $res[$i]->RECEIPT_PRICE;
				}	
				$value .= '"' . $res[$i]->CHEQUE_NO . '"' . "\t";
				$value .= '"' . $res[$i]->BANK_NAME . '"' . "\t";
				$value .= '"' . $res[$i]->RECEIPT_PAYMENT_METHOD . '"' . "\t";
				$line .= $value;
				$result .= trim($line) . "\n";
			}
			$result .= ''."\t".''."\t".''."\t".''."\t".''."\t".'Total'."\t".'"'.$totAmount.'"'."\t";
			$result .= "\n";
			$result = str_replace( "\r" , "" , $result );
			print("$header\n$result");	
		}
		
		function shashwath_report_excel() {
			$data['whichTab'] = "report";
			$file_ending = "xls";
			$filename = "Shashwath_loss_report_".date("d-m-Y");
			$date = $this->input->post('date');
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
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			$header = "";
			$header .= "\t";
			$header .= "\t";
			
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";
			$header .= "SI NO." . "\t";
			$header .= "Receipt No." . "\t";
			$header .= "Name(Phone)" . "\t";
			$header .= "Deity Name" . "\t";
			$header .= "Seva Name" . "\t";
			$header .= "ACCUMULATE LOSS" . "\t";
			$result = "";
			$loss_report_excel = $this->obj_shashwath->getMainLossExcelPDFReport($date,$name_phone);
			$i = 1; $totalLoss = 0; $value2 = "";
			foreach($loss_report_excel as $res) {				
				$value = "";
				$value = '"'.$i.'"'."\t";
				$value .= '"' . $res->SS_RECEIPT_NO.'"'. "\t";
				$value .= '"' . $res->NAME_PHONE.'"'. "\t";
				$value .= '"' . $res->DEITY_NAME.'"'. "\t";
				$value .= '"' . $res->SEVA_NAME .'"'. "\t";
				$value .= '"' . $res->ACCUMULATED_LOSS .'"'. "\t";
				$result .= trim($value) . "\n";
				$i++;
				$ACCUMULATED_LOSS = explode(' ',$res->ACCUMULATED_LOSS)[1];
				$totalLoss += explode('/',$ACCUMULATED_LOSS)[0];
			}
			$result .= "\n\t\t\t\t";
			$value2 .= "TotalLoss\t";
			$value2 .= '"Rs. ' . $totalLoss .'/-"'. "\t";
			$result .= trim($value2) . "\n";
			$result = str_replace( "\r" , "" , $result );
			print("$header\n$result"); 
		}

		function temple_day_book($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			//Radio Option
			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			//Unset Session
			unset($_SESSION['date']);
			unset($_SESSION['deityId']);
			unset($_SESSION['paymentMethod']);
			unset($_SESSION['fromDate']);
			unset($_SESSION['toDate']);
			
			//For Menu Selection
			$data['whichTab'] = "report";
			$data['date'] = date('d-m-Y');
			
			$conditionOne = "";
			$fromDate = date("d-m-Y");
			$data['temple_day_book'] = $this->obj_report->get_all_field_temple_day_book($fromDate,'','','', 10,$start,'');
			$data['temple_day_bookTotal'] = $this->obj_report->get_all_field_temple_day_book_account_summary($fromDate,'','');
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/temple_day_book';
			$data['total_rows'] =$config['total_rows'] = $this->obj_report->count_all_field_temple_day_book($fromDate,'','');
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
			
			if(isset($_SESSION['Temple_Day_Book'])) {
				$this->load->view('header', $data);
				$this->load->view('templeDayBook');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		function temple_inkind_report($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			//Radio Option
			$radioOpt = @$_POST['radioOpt'];
			if($radioOpt == "")
				$radioOpt = "date";
			
			$data['radioOpt'] = $radioOpt;
			
			//Unset Session
			unset($_SESSION['date']);
			unset($_SESSION['deityId']);
			unset($_SESSION['paymentMethod']);
			unset($_SESSION['fromDate']);
			unset($_SESSION['toDate']);
			
			//For Menu Selection
			$data['whichTab'] = "report";
			$data['date'] = date('d-m-Y');
			
			$conditionOne = "";
			$fromDate = date("d-m-Y");
			$data['temple_inkind'] = $this->obj_report->get_all_temple_inkind_report($fromDate,'','','', 10,$start,'');
			$data['temple_inkind_count'] = $this->obj_report->count_get_all_temple_inkind_report($fromDate,'','','','','');

			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'Report/temple_inkind_report';
			$data['total_rows'] =$config['total_rows'] = $this->obj_report->count_get_all_temple_inkind_report($fromDate,'','','','');
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
			
			if(isset($_SESSION['Temple_Inkind_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('templeInkindReport');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		function temple_inkind_report_on_change_date($start = 0) {
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION['actual_link'] = $actual_link;
			//For Menu Selection
			$data['whichTab'] = "report";
			
			if(isset($_POST['radioOpt'])) {
				$radioOpt = @$_POST['radioOpt'];
				$_SESSION['radioOpt'] = $radioOpt;
			} else {
				$radioOpt = $_SESSION['radioOpt'];
			}
			
			$data['radioOpt'] = $radioOpt;
			
			if(isset($_POST['fromDate'])) {
				$fromDate = @$_POST['fromDate'];
				$toDate = @$_POST['toDate'];
				$_SESSION['fromDate'] = $fromDate;
				$_SESSION['toDate'] = $toDate;
			} else {
				$fromDate = $_SESSION['fromDate'];
				$toDate = $_SESSION['toDate'];
			}
			$data['fromDate'] = $fromDate;
			$data['toDate'] = $toDate;
			
			if(@$_POST['tdate']) {
				unset($_SESSION['date']);
				$data['date'] = $this->input->post('tdate');
				$date = $this->input->post('tdate');
			}
			
			if(@$_SESSION['date'] == "") {
				$this->session->set_userdata('date', $this->input->post('tdate'));
				$data['date'] = $_SESSION['date'];
				$date = $this->input->post('tdate');
			} else {
				$date = $_SESSION['date'];
				$data['date'] = $_SESSION['date'];
			}

			if(isset($_POST['inkindType'])) {
				$data['inkindType'] = $inkindType = @$_POST['inkindType'];
				$_SESSION['inkindType'] = $inkindType;
			} else {
				$data['inkindType'] = $inkindType = $_SESSION['inkindType'];
			}
			// print_r($inkindType);

			$this->load->library('pagination');
			if(@$_SESSION['fromDate'] && @$_SESSION['toDate']) {
				$data['temple_inkind'] = $this->obj_report->get_all_temple_inkind_report($_SESSION['fromDate'],$_SESSION['toDate'],'','', 10,$start, $inkindType);
				$data['total_rows'] = $config['total_rows'] = $this->obj_report->count_get_all_temple_inkind_report($_SESSION['fromDate'],$_SESSION['toDate'],'','',$data['inkindType']);
				
			} else {
				$data['temple_inkind'] = $this->obj_report->get_all_temple_inkind_report($_SESSION['date'],'','','', 10,$start,$inkindType);
				$data['total_rows'] = $config['total_rows'] = $this->obj_report->count_get_all_temple_inkind_report($_SESSION['date'],'','','',$data['inkindType']);
			}
			//$this->output->enable_profiler(true);
			//pagination starts
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			$config['base_url'] = base_url().'Report/temple_inkind_report_on_change_date';
			
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
			
			
			if(isset($_SESSION['Temple_Inkind_Report'])) {
				$this->load->view('header', $data);
				$this->load->view('templeInkindReport');
				$this->load->view('footer_home');
			} else {
				redirect('Home/homePage');
			}
		}

		//FOR EXCEL FOR REPORT OF DEITY
		function deity_mis_report_excel() {
			$radioOpt = @$_POST['radioOpt'];
			$header = "";
			$result = "";
			$totAmt = 0;
			$totAmt1 = 0;
			$totAmt2 = 0;
			$totAmt3 = 0;
			$totAmt4 = 0;
			$totalAmt = 0;
			$totalAmt1 = 0;
			$totSevaPostageAmt =0;
			
			if($radioOpt == "multiDate")
				$filename = "Deity_MIS_Report_from ".$_POST['fromDate']. " to ".$_POST['toDate']; //File Name
			else
				$filename = "Deity_MIS_Report_".$_POST['todayDate']; //File Name
			$file_ending = "xls";
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$totalDonation = intval($_SESSION['donation']);
			$cancelledTotalDonation = intval($_SESSION['CancelledDonation']);
			$totalKanike = intval($_SESSION['kanike']);
			$cancelledTotalKanike = intval($_SESSION['CancelledKanike']);
			$totalSRNS = intval($_SESSION['srns']);
			$cancelledTotalSRNS = intval($_SESSION['CancelledSRNS']);
			$totalHundi = intval($_SESSION['hundi']);
			$cancelledTotalHundi = intval($_SESSION['cancelledTotalHundi']);
			
			$totalJeernoKanike = intval($_SESSION['totjeernokanike']);
			$cancelledTotalJeernoKanike = intval($_SESSION['CancelledJeernoKanike']);
			
			$totalJeernoHundi = intval($_SESSION['totjeernohundi']);		
			$cancelledTotalJeernoHundi = intval($_SESSION['cancelledtotjeernohundi']);
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";
			$header .= "Deity MIS Report:" . "\n\n";
			$header .= "DEITY NAME" . "\t";
			$header .= "SEVA NAME" . "\t";
			$header .= "SEVAS QTY" . "\t";
			$header .= "AMOUNT" . "\t";
			// $header .= "POSTAGE" . "\t";

			for($i = 0; $i < count($_SESSION['seva']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['seva'][$i]['SO_DEITY_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['seva'][$i]['SO_SEVA_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['seva'][$i]['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))'] . '"' . "\t";
				$value .= '"' . $_SESSION['seva'][$i]['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'] . '"' . "\t";
				// $value .= '"' . $_SESSION['seva'][$i]['POSTAGE_PRICE'] . '"' . "\t";
				$totAmt = $totAmt + $_SESSION['seva'][$i]['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'];// + $_SESSION['seva'][$i]['POSTAGE_PRICE'];
				$result .= trim($value) . "\n";
			}
			$result .= "\n";
			
			$value = "\n";
			$value .= '"TOTAL SEVA AMOUNT "' . "\t";
			$value .= $totAmt. "\t";
			$result .= trim($value) . "\n";
			
			for($i = 0; $i < count($_SESSION['sevaPostage']); $i++) { 
				$totSevaPostageAmt = $totSevaPostageAmt + $_SESSION['sevaPostage'][$i]['POSTAGE_PRICE'] ;
			}

			$value = "\n";
			$value .= '"TOTAL SEVA POSTAGE AMOUNT "' . "\t";
			
			$value .= $totSevaPostageAmt. "\t";
			$result .= trim($value) . "\n";

			$result .= "\n";
			$val = "";
			
			$val .= "Revision:" . "\n";
			$val .= "DEITY NAME" . "\t";
			$val .= "SEVA NAME" . "\t";
			$val .= "SEVAS QTY" . "\t";
			$val .= "AMOUNT" . "\t";
			$val .= "POSTAGE" . "\t";
			$result .= trim($val) . "\n";
			
			for($i = 0; $i < count($_SESSION['revision']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['revision'][$i]['SO_DEITY_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['revision'][$i]['SO_SEVA_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['revision'][$i]['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))'] . '"' . "\t";
				$value .= '"' . $_SESSION['revision'][$i]['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'] . '"' . "\t";
				$value .= '"' . $_SESSION['revision'][$i]['POSTAGE_PRICE'] . '"' . "\t";
				$totAmt1 = $totAmt1 + $_SESSION['revision'][$i]['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'];
				$result .= trim($value) . "\n";
			}
			$result .= "\n";
			
			$value = "\n";
			$value .= '"TOTAL SEVA AMOUNT "' . "\t";
			$value .= $totAmt1. "\t";
			$result .= trim($value) . "\n\n";
			
			$result .= "\n";
			$val = "";
			
			$val .= "Booking:" . "\n";
			$val .= "DEITY NAME" . "\t";
			$val .= "SEVA NAME" . "\t";
			$val .= "SEVAS QTY" . "\t";
			$val .= "AMOUNT" . "\t";
			$result .= trim($val) . "\n";
			
			for($i = 0; $i < count($_SESSION['booking']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['booking'][$i]['SO_DEITY_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['booking'][$i]['SO_SEVA_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['booking'][$i]['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))'] . '"' . "\t";
				$value .= '"' . $_SESSION['booking'][$i]['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'] . '"' . "\t";
				$totAmt2 = $totAmt2 + $_SESSION['booking'][$i]['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'];
				$result .= trim($value) . "\n";
			}
			$result .= "\n";

			$value = "\n";
			$value .= '"TOTAL BOOKING AMOUNT "' . "\t";
			$value .= $totAmt2. "\t";
			$result .= trim($value) . "\n\n";
			
			$result .= "\n";

			if($totalDonation != 0) {
				$value1 = "\n";
				$value1 .= '"DONATION AMOUNT :"' . "\t";
				$value1 .= '"' . $totalDonation . '"' . "\n";
				$value1 .= '"RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['donationCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
			}
			
			//LAZ
			if($totalKanike != 0) {
				$value1 = "\n\n";
				$value1 .= '"KANIKE :"' . "\n";
				for($i = 0; $i < count($_SESSION['allActiveKanike']); $i++) { 
					$indTotal = 0;
					$indCount = 0;
					for($j = 0; $j < count($_SESSION['kanike_details']); $j++) { 
						if($_SESSION['allActiveKanike'][$i]['KS_ID'] == $_SESSION['kanike_details'][$j]['KANIKE_FOR']){
							$indTotal += (intval($_SESSION['kanike_details'][$j]['RECEIPT_PRICE']) + intval($_SESSION['kanike_details'][$j]['POSTAGE_PRICE']));
							$indCount +=1;
						}
					}
					if($indTotal > 0) {
						$value1 .= '"' . $_SESSION['allActiveKanike'][$i]['KANIKE_NAME'] . '"' . "\t";
						$value1 .= '"' . $indTotal . '"' . "\n";
						$value1 .= '" COUNT :"' . "\t";
						$value1 .= '"' . $indCount . '"' . "\n";
					}
				}
				$value1 .= "\n";
				$value1 .= '"KANIKE TOTAL AMOUNT :"' . "\t";
				$value1 .= '"' . $totalKanike . '"' . "\n";
				$value1 .= '"TOTAL RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['kanikeCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
				
			}			
			//LAZ..			
			
			if($totalHundi != 0) {
				$value2 = "";
				$value2 .= "Hundi:" . "\n";
				$value2 .= "RECEIPT NO." . "\t";
				$value2 .= "DEITY NAME" . "\t";
				$value2 .= "AMOUNT" . "\t";
				$result .= trim($value2) . "\n";
				for($j = 0; $j < count($_SESSION['hundiOne']); $j++) {
					$value2 = "";
					$value2 .= '"' . $_SESSION['hundiOne'][$j]['RECEIPT_NO'] . '"' . "\t";
					$value2 .= '"' . $_SESSION['hundiOne'][$j]['RECEIPT_DEITY_NAME'] . '"' . "\t";
					$value2 .= '"' . $_SESSION['hundiOne'][$j]['RECEIPT_PRICE'] . '"' . "\t";
					
					$result .= trim($value2) . "\n";
				}
				
				$value2 = "";
				$value2 .= '' . "\t";
				$value2 .= '"TOTAL HUNDI AMOUNT"' . "\t";
				$value2 .= '"' . $totalHundi . '"' . "\t";
				$result .= trim($value2) . "\n\n";
			}
			
			if(!empty($_SESSION['inkind'])) {
				$value3 = "";
				$value3 .= "DEITY NAME" . "\t";
				$value3 .= "ITEM NAME" . "\t";
				$value3 .= "QUANTITY" . "\t";
				$result .= trim($value3) . "\n";
				for($j = 0; $j < count($_SESSION['inkind']); $j++) {
					$value4 = "";
					$value4 .= '"' . $_SESSION['inkind'][$j]['RECEIPT_DEITY_NAME'] . '"' . "\t";
					$value4 .= '"' . $_SESSION['inkind'][$j]['DY_IK_ITEM_NAME'] . '"' . "\t";
					$value4 .= '"' . $_SESSION['inkind'][$j]['amount']." ".$_SESSION['inkind'][$j]['DY_IK_ITEM_UNIT'] . '"' . "\t";
					
					$result .= trim($value4) . "\n";
				}
			}
			$result .= "\n";
			
			if($totalSRNS != 0) {
				$value1 = "\n";
				$value1 .= '"SRNS AMOUNT :"' . "\t";
				$value1 .= '"' . $totalSRNS . '"' . "\n";
				$value1 .= '"RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['srnsCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
			}
			
			//shashwath
			$val = "";
			$val .= "Shashwath Seva:" . "\n";
			$val .= "DEITY NAME" . "\t";
			$val .= "SEVA NAME" . "\t";
			$val .= "SEVAS QTY" . "\t";
			$val .= "CORPUS" . "\t";
			//$val .= "POSTAGE" . "\t";
			$result .= trim($val) . "\n";
			for($i = 0; $i < count($_SESSION['shashwath']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['shashwath'][$i]['DEITY_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['shashwath'][$i]['SEVA_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['shashwath'][$i]['QTY'] . '"' . "\t";
				//$value .= '"' . $_SESSION['shashwath'][$i]['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'] . '"' . "\t";
				$value .= '"' . $_SESSION['shashwath'][$i]['TOTAL'] . '"' . "\t";
				$totalAmt = $totalAmt + $_SESSION['shashwath'][$i]['TOTAL'];
				$result .= trim($value) . "\n";
			}
			$result .= "\n";
			
			$value = "\n";
			$value .= '"TOTAL SHASHWATH AMOUNT "' . "\t";
			$value .= $totalAmt. "\t";
			$result .= trim($value) . "\n";
			
			$result .= "\n";
			$val = "";
			
			if($totalJeernoKanike != 0) {
				$value1 = "\n";
				$value1 .= '"JEERNODHARA KANIKE AMOUNT :"' . "\t";
				$value1 .= '"' . $totalJeernoKanike . '"' . "\n";
				$value1 .= '"RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['cancelledJeernoKanikeCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
			}
			
			if($totalJeernoHundi != 0) {
				$value1 = "\n";
				$value1 .= '"JEERNODHARA HUNDI AMOUNT :"' . "\t";
				$value1 .= '"' . $totalJeernoHundi . '"' . "\n";
				$value1 .= '"RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['cancelledJeernoHundiCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
			}

			if(!empty($_SESSION['jeernoinkind'])) {
				$value3 = "";
				$value3 .= '"JEERNODHARA INKIND:"' . "\n";
				$value3 .= "ITEM NAME" . "\t";
				$value3 .= "QUANTITY" . "\t";
				$result .= trim($value3) . "\n";
				for($j = 0; $j < count($_SESSION['jeernoinkind']); $j++) {
					$value4 = "";
					$value4 .= '"' . $_SESSION['jeernoinkind'][$j]['DY_IK_ITEM_NAME'] . '"' . "\t";
					$value4 .= '"' . $_SESSION['jeernoinkind'][$j]['amount']." ".$_SESSION['jeernoinkind'][$j]['DY_IK_ITEM_UNIT'] . '"' . "\t";
					
					$result .= trim($value4) . "\n";
				}
			}
			$result .= "\n";
			
			$value7 = "";
			$value7 .= "CASH" . "\t";
			$value7 .= "CHEQUE" . "\t";
			$value7 .= "DIRECT CREDIT" . "\t";
			$value7 .= "CREDIT/DEBIT CARD" . "\t";
			$value7 .= "TOTAL AMOUNT" . "\t";
			$result .= trim($value7) . "\n";
			$value8 = "";
			$totAmount = 0;
			if(!empty($_SESSION['PayCash'])){	
				$value8 .= '"' . $_SESSION['PayCash'] . '"' . "\t";
				$totAmount = $totAmount + $_SESSION['PayCash'];
			} else {
				$value8 .= '"0"' . "\t";
			}
			if(!empty($_SESSION['PayCheque'])){	
				$value8 .= '"' . $_SESSION['PayCheque'] . '"' . "\t";
				$totAmount = $totAmount + $_SESSION['PayCheque'];
			} else {
				$value8 .= '"0"' . "\t";
			}
			if(!empty($_SESSION['PayDirect'])){	
				$value8 .= '"' . $_SESSION['PayDirect'] . '"' . "\t";
				$totAmount = $totAmount + $_SESSION['PayDirect'];
			} else {
				$value8 .= '"0"' . "\t";
			}
			if(!empty($_SESSION['PayCredit'])){	
				$value8 .= '"' . $_SESSION['PayCredit'] . '"' . "\t";
				$totAmount = $totAmount + $_SESSION['PayCredit'];
			} else {
				$value8 .= '"0"' . "\t";
			}
			$value8 .= '"' . $totAmount . '"' . "\t";
			$result .= trim($value8) . "\n";

			$result .= "\n";
			$val = "";
			
			$val .= "Cancelled Sevas:" . "\n\n";
			$val .= "DEITY NAME" . "\t";
			$val .= "SEVA NAME" . "\t";
			$val .= "SEVAS QTY" . "\t";
			$val .= "AMOUNT" . "\t";
			$result .= trim($val) . "\n";
			
			for($i = 0; $i < count($_SESSION['cancelled']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['cancelled'][$i]['SO_DEITY_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['cancelled'][$i]['SO_SEVA_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['cancelled'][$i]['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))'] . '"' . "\t";
				$value .= '"' . $_SESSION['cancelled'][$i]['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'] . '"' . "\t";
				$totAmt3 = $totAmt3 + $_SESSION['cancelled'][$i]['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'];
				$result .= trim($value) . "\n";
			}
			$result .= "\n";
			
			$value = "\n";
			$value .= '"TOTAL SEVA AMOUNT "' . "\t";
			$value .= $totAmt3. "\t";
			$result .= trim($value) . "\n";
			
			$result .= "\n";
			$val = "";
			
			$val .= "Booking Cancelled:"."\n\n";
			$val .= "BOOKING DATE (BOOKING NO.)"."\t";
			$val .= "DEITY NAME"."\t";
			$val .= "SEVA NAME"."\t";
			$val .= "CANCELLED TYPE"."\t";
			$val .= "CANCELLED BY"."\t";
			$result .= trim($val) . "\n";
			
			for($i = 0; $i < count($_SESSION['bookingCancelled']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['bookingCancelled'][$i]['SB_DATE'] . '"'." ("."". $_SESSION['bookingCancelled'][$i]['SB_NO'] ."".")" . "\t";
				$value .= '"' . $_SESSION['bookingCancelled'][$i]['SO_DEITY_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['bookingCancelled'][$i]['SO_SEVA_NAME'] . '"' . "\t";
				if($_SESSION['bookingCancelled'][$i]['SB_DEACTIVE_BY'] == "System") {
					$value .= 'Auto' . "\t";
				} else {
					$value .= 'Manual' . "\t";
				}
				$value .= '"' . $_SESSION['bookingCancelled'][$i]['SB_DEACTIVE_BY'] . '"' . "\t";
				$totAmt4 = $totAmt4 + $_SESSION['bookingCancelled'][$i]['SO_PRICE'];
				$result .= trim($value) . "\n";
			}
			$result .= "\n";			

			if($cancelledTotalDonation != 0) {
				$value1 = "\n";
				$value1 .= "Cancelled Donation:" . "\n\n";
				$value1 .= '"DONATION AMOUNT :"' . "\t";
				$value1 .= '"' . $cancelledTotalDonation . '"' . "\n";
				$value1 .= '"RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['cancelledDonationCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
			}
			$result .= "\n";
			
			if($cancelledTotalKanike != 0) {
				$value1 = "\n";
				$value1 .= "Cancelled Kanike:" . "\n\n";
				$value1 .= '"KANIKE AMOUNT :"' . "\t";
				$value1 .= '"' . $cancelledTotalKanike . '"' . "\n";
				$value1 .= '"RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['cancelledKanikeCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
			}
			
			if($cancelledTotalHundi != 0) {
				$value1 = "\n";
				$value1 .= "Cancelled Hundi:" . "\n\n";
				$value1 .= '"HUNDI AMOUNT :"' . "\t";
				$value1 .= '"' . $cancelledTotalHundi . '"' . "\n";
				$value1 .= '"RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['cancelledHundiCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
			}
			
			if($cancelledTotalSRNS != 0) {
				$value1 = "\n";
				$value1 .= "Cancelled SRNS:" . "\n\n";
				$value1 .= '"SRNS AMOUNT :"' . "\t";
				$value1 .= '"' . $cancelledTotalSRNS . '"' . "\n";
				$value1 .= '"RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['cancelledSRNSCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
			}
			
			$result .= "\n";
			
			//shashwath cancelled
			$val = "";
			$val .= "Cancelled Shashwath:" . "\n\n";
			$val .= "DEITY NAME" . "\t";
			$val .= "SEVA NAME" . "\t";
			//$val .= "SEVAS QTY" . "\t";
			$val .= "CORPUS" . "\t";
			$result .= trim($val) . "\n";
			for($i = 0; $i < count($_SESSION['cancelled_shashwath']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['cancelled_shashwath'][$i]['DEITY_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['cancelled_shashwath'][$i]['SEVA_NAME'] . '"' . "\t";
				//$value .= '"' . $_SESSION['cancelled_shashwath'][$i]['QTY'] . '"' . "\t";
				//$value .= '"' . $_SESSION['shashwath'][$i]['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'] . '"' . "\t";
				$value .= '"' . $_SESSION['cancelled_shashwath'][$i]['RECEIPT_PRICE'] . '"' . "\t";
				$totalAmt1 = $totalAmt1 + $_SESSION['cancelled_shashwath'][$i]['RECEIPT_PRICE'];
				$result .= trim($value) . "\n";
			}
			$result .= "\n";
			
			$value = "\n";
			$value .= '"TOTAL SHASHWATH AMOUNT "' . "\t";
			$value .= $totalAmt1. "\t";
			$result .= trim($value) . "\n";
			
			$result .= "\n";
			$val = "";
			
			if($cancelledTotalJeernoKanike != 0) {
				$value1 = "\n";
				$value1 .= "Cancelled Jeernodhara Kanike:" . "\n\n";
				$value1 .= '"JEERNODHARA KANIKE AMOUNT :"' . "\t";
				$value1 .= '"' . $cancelledTotalJeernoKanike . '"' . "\n";
				$value1 .= '"RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['cancelledJeernoKanikeCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
			}
			
			if($cancelledTotalJeernoHundi != 0) {
				$value1 = "\n";
				$value1 .= "Cancelled Jeerrnodhara Hundi:" . "\n\n";
				$value1 .= '"JEERNODHARA HUNDI AMOUNT :"' . "\t";
				$value1 .= '"' . $cancelledTotalJeernoHundi . '"' . "\n";
				$value1 .= '"RECEIPT COUNT :"' . "\t";
				$value1 .= '"' . intval($_SESSION['cancelledJeernoHundiCount']) . '"' . "\t";
				$result .= trim($value1) . "\n\n";
			}
			
			$result = str_replace( "\r" , "" , $result );
			print("$header\n$result"); 
		}
		
		//FOR EXCEL FOR REPORT OF EVENT
		
		//Above code commented while merging intern Lathesh code
		function event_mis_report_excel() {
			$radioOpt = @$_POST['radioOpt'];
			$header = "";
			$result = "";
			$totAmt = 0;
			if($radioOpt == "multiDate")
				$filename = "Current_MIS_Event_Report_from ".$_POST['fromDate']. " to ".$_POST['toDate']; //File Name
			else
				$filename = "Current_MIS_Event_Report_".$_POST['todayDate']; //File Name
			$file_ending = "xls";
			$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
			//header info for browser
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=$filename.xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$sep = "\t"; //tabbed character
			
			$totalDonation = intval($_SESSION['donation']);
			$totalHundi = intval($_SESSION['hundi']);
			
			$header .= "\t";
			$header .= $templename[0]["TEMPLE_NAME"]. "\n\n";					
			$header .= "SEVA NAME" . "\t";
			$header .= "SEVAS QTY" . "\t";
			$header .= "AMOUNT" . "\t";
			$header .= "POSTAGE" . "\t";
			$header .= "TOTAL" . "\t";

			for($i = 0; $i < count($_SESSION['seva']); $i++) { 
				$lineTotal=0;
				$value = "";			
				$value .= '"' . $_SESSION['seva'][$i]['ET_SO_SEVA_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['seva'][$i]['if(ET_SO_IS_SEVA = 1, count(ET_SO_SEVA_NAME), SUM(ET_SO_QUANTITY))'] . '"' . "\t";
				$value .= '"' . $_SESSION['seva'][$i]['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))'] . '"' . "\t";
				$value .= '"' . $_SESSION['seva'][$i]['POSTAGE_PRICE'] . '"' . "\t";
				
				//Lathish code Start
				$lineTotal = $_SESSION['seva'][$i]['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))'] + $_SESSION['seva'][$i]['POSTAGE_PRICE'];
				
				$value .= '"' . $lineTotal . '"' . "\t";
				//Lathish code End

				$totAmt = $totAmt + $_SESSION['seva'][$i]['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))'] + $_SESSION['seva'][$i]['POSTAGE_PRICE'];
				$result .= trim($value) . "\n";
			}

			
			$result .= "\n";
			
			$value = "\n";
			$value .= '"TOTAL SEVA AMOUNT "' . "\t";
			$value .= $totAmt. "\t";
			$result .= trim($value) . "\n";
			$result .= "\n";
			$valSeva = "";


			$valSeva .= "Cancelled Sevas:" . "\n\n";						
			$valSeva .= "SEVA NAME" . "\t";
			$valSeva .= "SEVAS QTY" . "\t";
			$valSeva .= "AMOUNT" . "\t";
			// Lathish code Starts
			$valSeva .= "POSTAGE" . "\t";
			$valSeva .= "TOTAL" . "\t";
			// Lathish code Ends
			$totCanAmt=0;

			$result .= trim($valSeva) . "\n";
			
			for($i = 0; $i < count($_SESSION['cancelledSeva']); $i++) { 
				$lineTotal = 0;//Lathish Code
				$value = "";			
				$value .= '"' . $_SESSION['cancelledSeva'][$i]['ET_SO_SEVA_NAME'] . '"' . "\t";
				$value .= '"' . $_SESSION['cancelledSeva'][$i]['if(ET_SO_IS_SEVA = 1, count(ET_SO_SEVA_NAME), SUM(ET_SO_QUANTITY))'] . '"' . "\t";
				$value .= '"' . $_SESSION['cancelledSeva'][$i]['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))'] . '"' . "\t";
				// Lathish code Starts
				$value .= '"' . $_SESSION['cancelledSeva'][$i]['POSTAGE_PRICE'] . '"' . "\t";
				$lineTotal = $_SESSION['cancelledSeva'][$i]['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))'] + $_SESSION['cancelledSeva'][$i]['POSTAGE_PRICE'];
				$value .= '"' . $lineTotal . '"' . "\t";
				$totCanAmt = $totCanAmt + $_SESSION['cancelledSeva'][$i]['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))'] + $_SESSION['cancelledSeva'][$i]['POSTAGE_PRICE'];
				// Lathish code Ends
				$result .= trim($value) . "\n";
			}
			
			$result .= "\n";
			// Lathish code Starts
			$value = "\n";
			$value .= '"TOTAL CANCELLED SEVA AMOUNT "' . "\t\t\t\t";
			$value .= $totCanAmt. "\t";
			$result .= trim($value) . "\n";
			$result .= "\n";
			$valSeva = "";
			// Lathish code Ends

			//donation
			$valDon = "";
			$totDonAmt = 0;
			$valDon .= "DONATION / KANIKE:" . "\n";						
			$valDon .= "Receipt No" . "\t";
			$valDon .= "Payment Mode" . "\t";
			$valDon .= "Payment Notes" . "\t";
			$valDon .= "Amount" . "\t";
			$result .= trim($valDon) . "\n";
			
			for($i = 0; $i < count($_SESSION['donation_details']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['donation_details'][$i]['ET_RECEIPT_NO'] . '"' . "\t";
				$value .= '"' . $_SESSION['donation_details'][$i]['ET_RECEIPT_PAYMENT_METHOD'] . '"' . "\t";
				$value .= '"' . $_SESSION['donation_details'][$i]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] . '"' . "\t";
				$value .= '"' . $_SESSION['donation_details'][$i]['ET_RECEIPT_PRICE'] . '"' . "\t";
				//changes
				$totDonAmt = $totDonAmt + $_SESSION['donation_details'][$i]['ET_RECEIPT_PRICE'] ;
				$result .= trim($value) . "\n";
			}
			$value = '"Total Donation / Kanike Amount "' . "\t";
			$value .= "\t";
			$value .= "\t";
			$value .= $totDonAmt. "\t";
			$result .= trim($value) . "\n";
			$result .= "\n";
			//END DONATION		


			//CANCEL donation
			$valDon = "";
			$totCanDonAmt = 0;
			$valDon .= "CANCELLED DONATION / KANIKE:" . "\n";						
			$valDon .= "Receipt No" . "\t";
			$valDon .= "Payment Mode" . "\t";
			$valDon .= "Payment Notes" . "\t";
			$valDon .= "Amount" . "\t";
			$result .= trim($valDon) . "\n";
			
			for($i = 0; $i < count($_SESSION['cancelled_donation_details']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['cancelled_donation_details'][$i]['ET_RECEIPT_NO'] . '"' . "\t";
				$value .= '"' . $_SESSION['cancelled_donation_details'][$i]['ET_RECEIPT_PAYMENT_METHOD'] . '"' . "\t";
				$value .= '"' . $_SESSION['cancelled_donation_details'][$i]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] . '"' . "\t";
				$value .= '"' . $_SESSION['cancelled_donation_details'][$i]['ET_RECEIPT_PRICE'] . '"' . "\t";
				//changes
				$totCanDonAmt = $totCanDonAmt + $_SESSION['cancelled_donation_details'][$i]['ET_RECEIPT_PRICE'] ;
				$result .= trim($value) . "\n";
			}
			$value = '"Total Donation / Kanike Amount "' . "\t";
			$value .= "\t";
			$value .= "\t";
			$value .= $totCanDonAmt. "\t";
			$result .= trim($value) . "\n";
			$result .= "\n";
			//END DONATION		
			//Hundi
			$valHundi = "";
			$totHundiAmt = 0;
			$valHundi .= "Hundi:" . "\n";						
			$valHundi .= "Receipt No" . "\t";
			$valHundi .= "Payment Mode" . "\t";
			$valHundi .= "Payment Notes" . "\t";
			$valHundi .= "Amount" . "\t";
			$result .= trim($valHundi) . "\n";
			
			for($i = 0; $i < count($_SESSION['hundinew']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['hundinew'][$i]['ET_RECEIPT_NO'] . '"' . "\t";
				$value .= '"' . $_SESSION['hundinew'][$i]['ET_RECEIPT_PAYMENT_METHOD'] . '"' . "\t";
				$value .= '"' . $_SESSION['hundinew'][$i]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] . '"' . "\t";
				$value .= '"' . $_SESSION['hundinew'][$i]['ET_RECEIPT_PRICE'] . '"' . "\t";
				//changes
				$totHundiAmt = $totHundiAmt + $_SESSION['hundinew'][$i]['ET_RECEIPT_PRICE'] ;
				$result .= trim($value) . "\n";
			}
			$value = '"Total Hundi Amount "' . "\t";
			$value .= "\t";
			$value .= "\t";
			$value .= $totHundiAmt. "\t";
			$result .= trim($value) . "\n";
			$result .= "\n";
			//END Hundi		

			//CANCEL Hundi
			$valDon = "";
			$totHundiCanAmt = 0;
			$valHundi = "";
			$valHundi .= "Cancelled Hundi:" . "\n";						
			$valHundi .= "Receipt No" . "\t";
			$valHundi .= "Payment Mode" . "\t";
			$valHundi .= "Payment Notes" . "\t";
			$valHundi .= "Amount" . "\t";
			$result .= trim($valHundi) . "\n";
			
			for($i = 0; $i < count($_SESSION['hundinew']); $i++) { 
				$value = "";			
				$value .= '"' . $_SESSION['hundinew'][$i]['ET_RECEIPT_NO'] . '"' . "\t";
				$value .= '"' . $_SESSION['hundinew'][$i]['ET_RECEIPT_PAYMENT_METHOD'] . '"' . "\t";
				$value .= '"' . $_SESSION['hundinew'][$i]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] . '"' . "\t";
				$value .= '"' . $_SESSION['hundinew'][$i]['ET_RECEIPT_PRICE'] . '"' . "\t";
				//changes
				$totHundiCanAmt = $totHundiCanAmt + $_SESSION['hundinew'][$i]['ET_RECEIPT_PRICE'] ;
				$result .= trim($value) . "\n";
			}
			$value = '"Total Hundi Amount "' . "\t";
			$value .= "\t";
			$value .= "\t";
			$value .= $totHundiCanAmt. "\t";
			$result .= trim($value) . "\n";
			$result .= "\n";
			//END Hundi		

			//inkind
			if(!empty($_SESSION['inkind'])) {
				$value3 = "";
				$value3 .= "Inkind:" . "\n";
				// Suraksha Code
				$value3 .= "RECEIPT NO" . "\t";
				$value3 .= "NAME" . "\t";
				$value3 .= "ITEM NAME" . "\t";
				$value3 .= "QUANTITY" . "\t";
				$result .= trim($value3) . "\n";
				for($j = 0; $j < count($_SESSION['inkind']); $j++) {
					$value4 = "";
					// Suraksha Code
					$value4 .= '"' . $_SESSION['inkind'][$j]['ET_RECEIPT_NO'] . '"' . "\t";
					$value4 .= '"' . $_SESSION['inkind'][$j]['ET_RECEIPT_NAME'] . '"' . "\t";
					$value4 .= '"' . $_SESSION['inkind'][$j]['IK_ITEM_NAME'] . '"' . "\t";
					$value4 .= '"' . $_SESSION['inkind'][$j]['amount']." ".$_SESSION['inkind'][$j]['IK_ITEM_UNIT'] . '"' . "\t";
					$result .= trim($value4) . "\n";
				}

			}
			//end inkind

				//Transaction Summary
			$result .= "\n";
			$totAmount =0;
			$value7 = "";
			$value7 = "Transaction Summary:"."\n";
			$value7 .= "CASH" . "\t";
			$value7 .= "CHEQUE" . "\t";
			$value7 .= "DIRECT CREDIT" . "\t";
			$value7 .= "CREDIT/DEBIT CARD" . "\t";
			$value7 .= "GRAND TOTAL" . "\t";
			$result .= trim($value7) . "\n";
			$value8 = "";
			if(!empty($_SESSION['PayCash'])){	
				$value8 .= '"' . $_SESSION['PayCash'] . '"' . "\t";
				$totAmount = $totAmount + $_SESSION['PayCash'];
			} else {
				$value8 .= '"0"' . "\t";
			}
			if(!empty($_SESSION['PayCheque'])){	
				$value8 .= '"' . $_SESSION['PayCheque'] . '"' . "\t";
				$totAmount = $totAmount + $_SESSION['PayCheque'];
			} else {
				$value8 .= '"0"' . "\t";
			}
			if(!empty($_SESSION['PayDirect'])){	
				$value8 .= '"' . $_SESSION['PayDirect'] . '"' . "\t";
				$totAmount = $totAmount + $_SESSION['PayDirect'];
			} else {
				$value8 .= '"0"' . "\t";
			}
			if(!empty($_SESSION['PayCredit'])){	
				$value8 .= '"' . $_SESSION['PayCredit'] . '"' . "\t";
				$totAmount = $totAmount + $_SESSION['PayCredit'];
			} else {
				$value8 .= '"0"' . "\t";
			}
			$value8 .= '"' . $totAmount . '"' . "\t";
			$result .= trim($value8) . "\n";	
			$result = str_replace( "\r" , "" , $result );
			print("$header\n$result"); 
		//end Transaction Summary
		}
	}
	?>
