<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  GenerationTrustEventPostageFPDF extends CI_Controller
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

		if(isset($_POST['trustEventPostageGrps']))
			$_SESSION['chosenCategory'] = $slvtPostage = @$_POST['trustEventPostageGrps'];
		else 
			$_SESSION['chosenCategory'] = $slvtPostage = @$_SESSION['chosenCategory'];

		if(isset($_POST['fromDate']) && isset($_POST['toDate'])) {
			$fromDate = @$_POST['fromDate'];
			$toDate = @$_POST['toDate'];
			$_SESSION['fromDate'] = $fromDate;
			$_SESSION['toDate'] = $toDate;
		} else {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
		}

		if(isset($_POST['postageAreaFilter'])){
			$_SESSION['chosenArea'] = $postageAreaFilter = @$_POST['postageAreaFilter'];
		}else{
			$postageAreaFilter = $_SESSION['chosenArea'];
		}


		if($slvtPostage == "All") {
			$condition = "TRUST_EVENT.TET_ACTIVE = 1 AND ADDRESS_LINE1 != '' AND TET_RECEIPT_ACTIVE = 1 ";

		}
		else if($slvtPostage == "Seva") {
			$condition = "TRUST_EVENT.TET_ACTIVE = 1 AND ADDRESS_LINE1 != '' AND TET_RECEIPT_ACTIVE = 1 AND TET_RECEIPT_CATEGORY_ID = 1";
		}	
		else if($slvtPostage == "Donation") {
			$condition = "TRUST_EVENT.TET_ACTIVE = 1 AND ADDRESS_LINE1 != '' AND TET_RECEIPT_ACTIVE = 1 AND TET_RECEIPT_CATEGORY_ID = 2";
			
		} 
		else if($slvtPostage == "Inkind") {
			$condition = "TRUST_EVENT.TET_ACTIVE = 1 AND ADDRESS_LINE1 != '' AND TET_RECEIPT_ACTIVE = 1 AND TET_RECEIPT_CATEGORY_ID = 4";
		
		}

		if($fromDate != "" && $toDate != ""){
			$condition .= " AND STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y')  BETWEEN  STR_TO_DATE('$fromDate','%d-%m-%Y') AND STR_TO_DATE('$toDate','%d-%m-%Y')";
		}

		if($postageAreaFilter == "Udupi"){
			$condition .= " AND TET_RECEIPT_ADDRESS LIKE '%udupi%'";
		}else if ($postageAreaFilter == "Other") {
			$condition .= " AND TET_RECEIPT_ADDRESS NOT LIKE '%udupi%'";
		}
	
		$SelectedReceiptID = @$_SESSION['SelectedReceiptID'];
		if($SelectedReceiptID && count($SelectedReceiptID) > 0) {
			$condition .= " AND ( TET_RECEIPT_ID = ".$SelectedReceiptID[0];
			for($i = 1; $i <= count($SelectedReceiptID) - 1; $i++) {
				$condition .= " OR TET_RECEIPT_ID = ".$SelectedReceiptID[$i];
			}
			$condition .= " ) ";
		}
		
		$query = "SELECT TET_RECEIPT_NO,TET_RECEIPT_DATE,TET_RECEIPT_NAME,TET_RECEIPT_PHONE,REPLACE(REPLACE(TET_RECEIPT_ADDRESS,',,',','),', ,',',') AS TET_RECEIPT_ADDRESS, TET_RECEIPT_PAYMENT_METHOD FROM TRUST_EVENT_RECEIPT INNER JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID WHERE ".$condition."  ORDER BY TET_RECEIPT_ID ASC ";
	
		$result = $this->db->query($query);
		$number_of_digits = $result->num_rows();

		
		//Initialize the 3 columns and the total
		$column_code = "";
		
		//For each row, add the field to the corresponding column
		$i = 0;
		foreach ($result->result() as $row) {
			$arrAddrWrds = explode(' ', strtoupper($row->TET_RECEIPT_ADDRESS));
			$arrNameWrds = explode(' ',strtoupper($row->TET_RECEIPT_NAME));

			$arrResult['receipt_no'] = $row->TET_RECEIPT_NO;
			$arrResult['phone'] = $row->TET_RECEIPT_PHONE;

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
	
			
			/*$arrResult['Add2'] = $add2;
			$arrResult['Add3'] = 
			$arrResult['Add4'] = $city.", ".$ctry.", ".$pin;*/
			$arrLabels[$i] = $arrResult;
			$i++;
		}
		
		$this->pdf = new Pdf();
		$this->pdf->SetFont('Arial', null, 7);
		
		$l = 1;
		$k = 1;
		$x = 20;
		$num = 1;
		$number = 1;
		
		for($rowF = 0; $rowF < $number_of_digits; $rowF++) {
			if($l == 1) {
				$this->pdf->AddPage('P','A4',0);	
			}	
			//$num_padded = sprintf("%0".$number_of_digits."d", $num);
			
			
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
		