<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GenTrustEventPostageLetterGroupFPDF extends CI_Controller
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
		$this->load->model('Shashwath_Model','obj_shashwath',true);
        $this->load->add_package_path( APPPATH . 'third_party/fpdf');
        $this->load->library('pdf');
    }
// 
    public function ConvertRsToWords($num) {
    	$no = floor($num);
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'one', '2' => 'two',
		'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
		'7' => 'seven', '8' => 'eight', '9' => 'nine',
		'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
		'13' => 'thirteen', '14' => 'fourteen',
		'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
		'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
		'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
		'60' => 'sixty', '70' => 'seventy',
		'80' => 'eighty', '90' => 'ninety');
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_1) {
		 $divider = ($i == 2) ? 10 : 100;
		 $number = floor($no % $divider);
		 $no = floor($no / $divider);
		 $i += ($divider == 10) ? 1 : 2;
		 if ($number) {
		    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
		    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
		    $str [] = ($number < 21) ? $words[$number] .
		        " " . $digits[$counter] . $plural . " " . $hundred
		        :
		        $words[floor($number / 10) * 10]
		        . " " . $words[$number % 10] . " "
		        . $digits[$counter] . $plural . " " . $hundred;
		 } else $str[] = null;
		}
		$str = array_reverse($str);
		$result = implode('', $str);
		return trim(ucfirst($result))." only";
    }

	public function index() {
		if(isset($_POST['fromDate']) && isset($_POST['toDate'])) {
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

		if(isset($_POST['postageAreaFilter'])){
			$_SESSION['chosenArea'] = $postageAreaFilter = @$_POST['postageAreaFilter'];
		}else{
			$postageAreaFilter = $_SESSION['chosenArea'];
		}
		$data['chosenArea'] = $postageAreaFilter;



		if(isset($_POST['trustEventPostageGrps']))
			$_SESSION['chosenCategory'] = $slvtPostage = @$_POST['trustEventPostageGrps'];
		else 
			$_SESSION['chosenCategory'] = $slvtPostage = @$_SESSION['chosenCategory'];

		//echo $slvtPostage;
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
			$condition .= " AND ( trust_event_receipt.TET_RECEIPT_ID = ".$SelectedReceiptID[0];
			for($i = 1; $i <= count($SelectedReceiptID) - 1; $i++) {
				$condition .= " OR trust_event_receipt.TET_RECEIPT_ID = ".$SelectedReceiptID[$i];
			}
			$condition .= " ) ";
		}

		if($slvtPostage != "Inkind") {
			$query = "SELECT TET_RECEIPT_ID,TET_RECEIPT_NO,TET_RECEIPT_DATE,TET_RECEIPT_NAME,TET_RECEIPT_NAME,REPLACE(REPLACE(TET_RECEIPT_ADDRESS,',,',','),', ,',',') AS TET_RECEIPT_ADDRESS, TET_RECEIPT_PAYMENT_METHOD, TET_RECEIPT_PRICE,CHEQUE_NO,CHEQUE_DATE,BANK_NAME,BRANCH_NAME,TRANSACTION_ID,RECEIPT_TET_NAME FROM trust_event_receipt INNER JOIN TRUST_EVENT ON TRUST_EVENT.TET_ID = TRUST_EVENT_RECEIPT.RECEIPT_TET_ID WHERE ".$condition." ORDER BY TET_RECEIPT_ID ASC";	
		} else {
			$query = "SELECT trust_event_receipt.TET_RECEIPT_ID,TET_RECEIPT_NO,TET_RECEIPT_DATE,TET_RECEIPT_NAME,TET_RECEIPT_NAME,REPLACE(REPLACE(TET_RECEIPT_ADDRESS,',,',','),', ,',',') AS TET_RECEIPT_ADDRESS, TET_RECEIPT_PAYMENT_METHOD, GROUP_CONCAT(CONCAT(IK_ITEM_NAME,' ',TRIM(IK_ITEM_QTY)+0,' ',CONCAT(UCASE(LEFT(IK_ITEM_UNIT, 1)),SUBSTRING(IK_ITEM_UNIT, 2)))) AS TET_RECEIPT_PRICE,'' AS CHEQUE_NO,'' AS CHEQUE_DATE,'' AS BANK_NAME,'' AS BRANCH_NAME,TRANSACTION_ID,RECEIPT_TET_NAME

			FROM trust_event_receipt 
			INNER JOIN TRUST_EVENT ON TRUST_EVENT.TET_ID = TRUST_EVENT_RECEIPT.RECEIPT_TET_ID 
			INNER JOIN trust_event_inkind_offered ON trust_event_receipt.TET_RECEIPT_ID = trust_event_inkind_offered.TET_RECEIPT_ID 
			WHERE ".$condition." GROUP BY trust_event_inkind_offered.TET_RECEIPT_ID ORDER BY trust_event_receipt.TET_RECEIPT_ID ASC";
		}
		//echo "$query";
			$result = $this->db->query($query);
		

		$this->pdf = new Pdf('p','mm','A4');
		$this->pdf->SetFont('Arial', null, 12);
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		foreach ($result->result() as $row) {
			$this->pdf->AddPage();
			$this->pdf->SetLeftMargin(13);
			$this->pdf->SetXY(175,50);
			$this->pdf->Write(0,date('d-m-Y'));
			$this->pdf->SetXY(13,65);
			$this->pdf->Write(10,'To: ');
			$this->pdf->Ln();
			$this->pdf->SetXY(15,72);
			$this->pdf->Write(12,$row->TET_RECEIPT_NAME);
			$this->pdf->Ln();
			$this->pdf->Write(8,'Dear Sir,');
			$this->pdf->Ln();
			$txt = $row->RECEIPT_TET_NAME;
			$str= preg_replace('/\W\w+\s*(\W*)$/', '$1', $txt);
			$this->pdf->Write(8,'SUBJECT: Your contribution for '.$str.' Celebrations.');
			$event = strtoupper($row->RECEIPT_TET_NAME);
			$this->pdf->Ln();
			
			// if (strpos($row->TET_RECEIPT_NO,'IK' ) === false) {
			// 	if($row->TET_RECEIPT_PAYMENT_METHOD == "Cheque") {
			// 		$this->pdf->Justify('We acknowledge with thanks the receipt of your contribution vide Cheque No '.$row->CHEQUE_NO.' dated '.$row->TET_RECEIPT_DATE.' for Rs. '.$row->TET_RECEIPT_PRICE.'/- (Rupees '.$this->ConvertRsToWords($row->TET_RECEIPT_PRICE).')  for '.$str.' celebrations',195,7);	
			// 	} else if($row->TET_RECEIPT_PAYMENT_METHOD ==  "Credit / Debit Card" ) {
			// 		$this->pdf->Justify('We acknowledge with thanks the receipt of your contribution vide Credit / Debit Card No '.$row->TRANSACTION_ID.' dated '.$row->TET_RECEIPT_DATE.' for Rs. '.$row->TET_RECEIPT_PRICE.'/- (Rupees '.$this->ConvertRsToWords($row->TET_RECEIPT_PRICE).')  for '.$str.' celebrations',195,7);
			// 	} else if($row->TET_RECEIPT_PAYMENT_METHOD ==  "Direct Credit" ) {
			// 		$this->pdf->Justify('We acknowledge with thanks the receipt of your contribution vide Direct Credit dated '.$row->TET_RECEIPT_DATE.' for Rs. '.$row->TET_RECEIPT_PRICE.'/- (Rupees '.$this->ConvertRsToWords($row->TET_RECEIPT_PRICE).')  for '.$str.' celebrations',195,7);
			// 	}else{
			// 		$this->pdf->Justify('We acknowledge with thanks the receipt of your contribution vide Cash dated '.$row->TET_RECEIPT_DATE.' for Rs. '.$row->TET_RECEIPT_PRICE.'/- (Rupees '.$this->ConvertRsToWords($row->TET_RECEIPT_PRICE).')  for '.$str.' celebrations',195,7);
			// 	}
			// }



			if (strpos($row->TET_RECEIPT_NO,'IK' ) === false) {
				if($row->TET_RECEIPT_PAYMENT_METHOD == "Cheque") {
					$this->pdf->Justify('We acknowledge with thanks the receipt of your contribution vide Cheque. No '.$row->CHEQUE_NO.' dated '.$row->TET_RECEIPT_DATE.' for Rs. '.$row->TET_RECEIPT_PRICE.'/- (Rupees '.$this->ConvertRsToWords($row->TET_RECEIPT_PRICE).')  for '.$str.' celebrations',195,7);
				}else if($row->TET_RECEIPT_PAYMENT_METHOD == "Credit / Debit Card" || $row->TET_RECEIPT_PAYMENT_METHOD == "Direct Credit" || $row->TET_RECEIPT_PAYMENT_METHOD == "Cash") {
					$this->pdf->Justify('We acknowledge with thanks the receipt of your contribution vide '.$row->TET_RECEIPT_PAYMENT_METHOD.' dated '.$row->TET_RECEIPT_DATE.' for Rs. '.$row->TET_RECEIPT_PRICE.'/- (Rupees '.$this->ConvertRsToWords($row->TET_RECEIPT_PRICE).')  for '.$str.' celebrations',195,7);
				} 
			} else {
				$this->pdf->Justify('It is our pleasure to acknowledge with gratitude by making available Articles of utility ('.$row->TET_RECEIPT_PRICE.') too have been accepted and are of much use and utilised opportunity. We express our thankfulness for your active involvement.',195,7);
			}

			$this->pdf->Ln(2);
			$this->pdf->Justify('We are enclosing herewith Receipt No: '.$row->TET_RECEIPT_NO.' dated '.$row->TET_RECEIPT_DATE.' for '.$row->TET_RECEIPT_PRICE.' for the same.',195,7);
		
			$this->pdf->Ln(2);
			$this->pdf->Justify("We are pleased to inform you that entire Bhajana Sapthaha Mahotsava celebrations went off smoothly by the Grace of God.",195,7);
			
			$this->pdf->Ln(2);
			$this->pdf->Justify('We have offered prayers to Lord for all round growth and prosperity of your family/Institution and Holy prasadam is enclosed.',195,7);
			$this->pdf->Ln();
			$this->pdf->Write(9,'Thanking you');
			$this->pdf->Ln();
			$this->pdf->Write(9,'Yours faithfully,');
			$this->pdf->Ln();
			$this->pdf->Write(9,'For ' .$event.',');
			$this->pdf->Ln(18);
			$this->pdf->Write(9,'SRI P.V.SHENOY');
			$this->pdf->Ln(10);
			$this->pdf->Write(8,'MANAGING TRUSTEE AND PRESIDENT');
			$this->pdf->Ln();
			$this->pdf->Write(6,'Encl: Prasad');
			$this->pdf->Ln();
		}
        $this->pdf->Output( 'Letter_Generation.pdf' , 'I' );
	}
}