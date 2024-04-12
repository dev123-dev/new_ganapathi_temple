<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GenerationPostageGroupFPDF extends CI_Controller
{
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
		$this->load->model('Postage_model','obj_postage',true);
		
        $this->load->add_package_path( APPPATH . 'third_party/fpdf');
        $this->load->library('pdf');
    }

	public function index() {
		if(isset($_POST['slvtPostageGrps']) && isset($_POST['postageCriteria']) && isset($_POST['postageCriteria'])) {
			$_SESSION['chosenCategory'] = $slvtPostage = @$_POST['slvtPostageGrps'];
			$_SESSION['chosenCriteria'] = $postageCriteria = @$_POST['postageCriteria'];
			$_SESSION['chosenArea'] = $postageAreaFilter = @$_POST['postageAreaFilter'];
		}
		else {
			$_SESSION['chosenCategory'] = $slvtPostage = @$_SESSION['chosenCategory'];
			$_SESSION['chosenCriteria'] = $postageCriteria = @$_SESSION['chosenCriteria'];
			$_SESSION['chosenArea'] = $postageAreaFilter = @$_SESSION['chosenArea'];
		}

		$areaCondition = "";
		if($postageAreaFilter == "Udupi"){
			$areaCondition = " AND RECEIPT_ADDRESS LIKE '%udupi%'";
		}elseif ($postageAreaFilter == "Other") {
			$areaCondition = " AND RECEIPT_ADDRESS NOT LIKE '%udupi%'";
		}

		//echo $slvtPostage;
		if($slvtPostage == "All Category") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 $areaCondition";

		}
		else if($slvtPostage == "Seva") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 1 $areaCondition";
		}	
		else if($slvtPostage == "Donation") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 2 $areaCondition";
			
		} 
		else if($slvtPostage == "Kanike") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 3 $areaCondition";
		
		}
		else if($slvtPostage == "Inkind") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 5 $areaCondition";
		
		}
		else if($slvtPostage == "SRNS") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 6 $areaCondition";
		
		}
		else if($slvtPostage == "Shashwath") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 7 $areaCondition";
		
		}
		else if($slvtPostage == "Jeernodhara") {
			if($postageCriteria == "1")
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND (RECEIPT_CATEGORY_ID = 10 OR RECEIPT_CATEGORY_ID = 8)  $areaCondition";
			else if($postageCriteria == "2")
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 8 AND RECEIPT_PRICE < 25000  $areaCondition";
			else if($postageCriteria == "3")
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 8 AND RECEIPT_PRICE >= 25000  $areaCondition";
			else 
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 10  $areaCondition";				
		}

		$SelectedReceiptID = @$_SESSION['SelectedReceiptID'];
		if($SelectedReceiptID && count($SelectedReceiptID) > 0) {
			$condition .= " AND ( RECEIPT_ID = ".$SelectedReceiptID[0];
			for($i = 1; $i <= count($SelectedReceiptID) - 1; $i++) {
				$condition .= " OR RECEIPT_ID = ".$SelectedReceiptID[$i];
			}
			$condition .= " ) ";
		}

		$query = "SELECT RECEIPT_NO,RECEIPT_DATE,RECEIPT_NAME,RECEIPT_PHONE,REPLACE(REPLACE(RECEIPT_ADDRESS,',,',','),', ,',',') AS RECEIPT_ADDRESS, RECEIPT_PAYMENT_METHOD FROM DEITY_RECEIPT WHERE ".$condition." ORDER BY RECEIPT_ID ASC ";

		$result = $this->db->query($query);
		$number_of_digits = $result->num_rows();

		
		//Initialize the 3 columns and the total
		$column_code = "";
		
		//For each row, add the field to the corresponding column
		$i = 0;
		foreach ($result->result() as $row) {
			$arrAddrWrds = explode(' ', strtoupper($row->RECEIPT_ADDRESS));
			$arrNameWrds = explode(' ',strtoupper($row->RECEIPT_NAME));

			$arrResult['receipt_no'] = $row->RECEIPT_NO;
			$arrResult['phone'] = $row->RECEIPT_PHONE;

			$arrResult['Name1'] = "";
			if(count($arrNameWrds) > 5) {
				for($k=0; $k < 5; $k++)
					$arrResult['Name1'] .= trim($arrNameWrds[$k])." ";
			} else {
				for($k=0; $k < count($arrNameWrds); $k++)
					$arrResult['Name1'] .= trim($arrNameWrds[$k])." ";
			}
			$arrResult['Name2'] = "";
			if(count($arrNameWrds) > 10) {
				for($k=5; $k < count($arrNameWrds); $k++)
					$arrResult['Name2'] .= trim($arrNameWrds[$k])." ";
			} else {
				for($k=5; $k < count($arrNameWrds); $k++)
					$arrResult['Name2'] .= trim($arrNameWrds[$k])." ";
			}

			$arrResult['Add1'] = "";
			if(count($arrAddrWrds) > 4) {
				for($j=0; $j < 4; $j++)
					$arrResult['Add1'] .= trim($arrAddrWrds[$j])." ";
			} else {
				for($j=0; $j < count($arrAddrWrds); $j++)
					$arrResult['Add1'] .= trim($arrAddrWrds[$j])." ";
			}

			$arrResult['Add2'] = "";
			if(count($arrAddrWrds) > 8) {
				for($j=4; $j < 8; $j++)
					$arrResult['Add2'] .= trim($arrAddrWrds[$j])." ";
			} else {
				for($j=4; $j < count($arrAddrWrds); $j++)
					$arrResult['Add2'] .= trim($arrAddrWrds[$j])." ";
			}

			$arrResult['Add3'] = "";
			if(count($arrAddrWrds) > 12) {
				for($j=8; $j < 12; $j++)
					$arrResult['Add3'] .= trim($arrAddrWrds[$j])." ";
			} else {
				for($j=8; $j < count($arrAddrWrds); $j++)
					$arrResult['Add3'] .= trim($arrAddrWrds[$j])." ";
			}

			$arrResult['Add4'] = "";
			if(count($arrAddrWrds) > 16) {
				for($j=12; $j < 16; $j++)
					$arrResult['Add4'] .= trim($arrAddrWrds[$j])." ";
			} else {
				for($j=12; $j < count($arrAddrWrds); $j++)
					$arrResult['Add4'] .= trim($arrAddrWrds[$j])." ";
			}

			$arrResult['Add5'] = "";
			if(count($arrAddrWrds) > 20) {
				for($j=16; $j < 20; $j++)
					$arrResult['Add5'] .= trim($arrAddrWrds[$j])." ";
			} else {
				for($j=16; $j < count($arrAddrWrds); $j++)
					$arrResult['Add5'] .= trim($arrAddrWrds[$j])." ";
			}
	
			
			$arrLabels[$i] = $arrResult;
			$i++;
		}
		
		$this->pdf = new Pdf();
		$this->pdf->SetFont('Arial', null, 7);
		
		$l = 1;
		$k = 1;
		$x = 20;
		$num = 1;
		$number = $_GET['startFrom'];

		if($number == 2 || $number == 3) {
			$x = 20;
		} else if($number == 4 || $number == 5 || $number == 6) {
			$x = 54;
		} else if($number == 7 || $number == 8 || $number == 9) {	
			$x = 88;
		} else if($number == 10 || $number == 11 || $number == 12) {
			$x = 122;
		} else if($number == 13 || $number == 14 || $number == 15) {	
			$x = 156;
		} else if($number == 16 || $number == 17 || $number == 18) {	
			$x = 190;
		} else if($number == 19 || $number == 20 || $number == 21) {	
			$x = 224;
		} else if($number == 22 || $number == 23 || $number == 24) {	
			$x = 258;
		} 
		
		if($number == 4 || $number == 7 || $number == 10 || $number == 13 || $number == 16 || $number == 19 || $number == 22) {
			$k = 1;
			$l = $number;
			$this->pdf->AddPage('P','A4',0);
		} else if($number == 2 || $number == 5 || $number == 8 || $number == 11 || $number == 14 || $number == 17 || $number == 20 || $number == 23) {
			$k = 2;
			$l = $number;
			$this->pdf->AddPage('P','A4',0);
		} else if($number == 3 || $number == 6 || $number == 9 || $number == 12 || $number == 15 || $number == 18 || $number == 21 || $number == 24) {
			$k = 3;
			$l = $number;
			$this->pdf->AddPage('P','A4',0);
		}
		
		for($rowF = 0; $rowF < $number_of_digits; $rowF++) {
			if($l == 1) {
				$this->pdf->AddPage('P','A4',0);	
			}
			
			$ADDRESS1 = "";
			if($arrLabels[$rowF]['Add1'] != "") 
				$ADDRESS1 = $arrLabels[$rowF]['Add1'];

			if($arrLabels[$rowF]['Add2'] != "") 
				$ADDRESS1 .= "\n".$arrLabels[$rowF]['Add2'];

			if($arrLabels[$rowF]['Add3'] != "") 
				$ADDRESS1 .= "\n".$arrLabels[$rowF]['Add3'];			

			if($arrLabels[$rowF]['Add4'] != "") 
				$ADDRESS1 .= "\n".$arrLabels[$rowF]['Add4'];

			if($arrLabels[$rowF]['Add5'] != "") 
				$ADDRESS1 .= "\n".$arrLabels[$rowF]['Add5'];						


			if($arrLabels[$rowF]['phone'] != "" && $arrLabels[$rowF]['Name2'] != "" ) {
				@$column_code = $num.". ".$arrLabels[$rowF]['Name1']."\n".$arrLabels[$rowF]['Name2']."\n".$ADDRESS1."\nPh: ".$arrLabels[$rowF]['phone'];
			}else if ($arrLabels[$rowF]['phone'] != "" && $arrLabels[$rowF]['Name2'] == "") {
				@$column_code = $num.". ".$arrLabels[$rowF]['Name1']."\n".$ADDRESS1."\nPh: ".$arrLabels[$rowF]['phone'];
			}else if ($arrLabels[$rowF]['phone'] == ""  && $arrLabels[$rowF]['Name2'] != "") {
				@$column_code = $num.". ".$arrLabels[$rowF]['Name1']."\n".$arrLabels[$rowF]['Name2']."\n".$ADDRESS1;
			}
			else if ($arrLabels[$rowF]['phone'] == ""  && $arrLabels[$rowF]['Name2'] == "") {
				@$column_code = $num.". ".$arrLabels[$rowF]['Name1']."\n".$ADDRESS1;
			}
		
			if($k == 1) {
				$this->pdf->SetXY(7,$x);
				$this->pdf->MultiCell(0, 3, $column_code, 0);
			}
			
			if($k == 2) {
				$this->pdf->SetXY(75,$x);
				$this->pdf->MultiCell(0, 3, $column_code, 0);
			}
			
			if($k == 3) {
				$this->pdf->SetXY(142,$x);
				$this->pdf->MultiCell(0, 3, $column_code, 0);
				$x = $x + 34;
			}
			
			if($k == 3) {
				$k = 0;
			}
			
			$k++; 
			$l++;
			if($l == 25) {
				$x = 20;
				$l = 1;
			}
			$num++;
		}
        
        $this->pdf->Output( 'Label_Generation.pdf' , 'I' );
	}
}


		
		
		
		
		
	
		