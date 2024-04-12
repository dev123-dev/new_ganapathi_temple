<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GenerationPostageLetterGroupFPDF extends CI_Controller
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

		if(isset($_POST['slvtPostageGrps']) && isset($_POST['postageCriteria'])) {
			$_SESSION['chosenCategory'] = $slvtPostage = @$_POST['slvtPostageGrps'];
			$_SESSION['chosenCriteria'] = $postageCriteria = @$_POST['postageCriteria'];
		}
		else {
			$_SESSION['chosenCategory'] = $slvtPostage = @$_SESSION['chosenCategory'];
			$_SESSION['chosenCriteria'] = $postageCriteria = @$_SESSION['chosenCriteria'];
		}

		if($slvtPostage == "All Category") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 ";

		}
		else if($slvtPostage == "Seva") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 1";
		}	
		else if($slvtPostage == "Donation") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 2";
			
		} 
		else if($slvtPostage == "Kanike") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 3";
		
		}
		else if($slvtPostage == "Inkind") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 5";
		
		}
		else if($slvtPostage == "SRNS") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 6";
		
		}
		else if($slvtPostage == "Shashwath") {
			$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 7";
		
		}
		else if($slvtPostage == "Jeernodhara") {
			if($postageCriteria == "1") {
				$condition1 = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 8";
				$condition2 = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 10";			
			} 
			else if($postageCriteria == "2")
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 8 AND RECEIPT_PRICE < 25000";
			else if($postageCriteria == "3")
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 8 AND RECEIPT_PRICE >= 25000";
			else 
				$condition = "ADDRESS_LINE1 != '' AND RECEIPT_ACTIVE = 1 AND RECEIPT_CATEGORY_ID = 10";
		}	

		$SelectedReceiptID = @$_SESSION['SelectedReceiptID'];
		if($SelectedReceiptID && count($SelectedReceiptID) > 0) {
			if($slvtPostage == "Jeernodhara" && $postageCriteria == "1") {
				$condition1 .= " AND ( RECEIPT_ID = ".$SelectedReceiptID[0];
				$condition2 .= " AND ( DEITY_RECEIPT.RECEIPT_ID = ".$SelectedReceiptID[0];
				for($i = 1; $i <= count($SelectedReceiptID) - 1; $i++) {
					$condition1 .= " OR RECEIPT_ID = ".$SelectedReceiptID[$i];
					$condition2 .= " OR DEITY_RECEIPT.RECEIPT_ID = ".$SelectedReceiptID[$i];
				}
				$condition1 .= " ) ";
				$condition2 .= " ) ";
			}else{
				$condition .= " AND ( DEITY_RECEIPT.RECEIPT_ID = ".$SelectedReceiptID[0];
				for($i = 1; $i <= count($SelectedReceiptID) - 1; $i++) {
					$condition .= " OR DEITY_RECEIPT.RECEIPT_ID = ".$SelectedReceiptID[$i];
				}
				$condition .= " ) ";
			}
		}

		if($slvtPostage != "Jeernodhara" && $slvtPostage != "Inkind") {
			$query = "SELECT RECEIPT_NO,RECEIPT_DATE,RECEIPT_NAME,RECEIPT_PHONE,REPLACE(REPLACE(RECEIPT_ADDRESS,',,',','),', ,',',') AS RECEIPT_ADDRESS, RECEIPT_PAYMENT_METHOD, RECEIPT_PRICE,CHEQUE_NO,CHEQUE_DATE,BANK_NAME,BRANCH_NAME FROM DEITY_RECEIPT WHERE ".$condition." ORDER BY RECEIPT_ID ASC";	
		} else {
			if($slvtPostage == "Jeernodhara") {
				if($postageCriteria == "1") 
					$query = "SELECT * FROM (SELECT RECEIPT_ID,RECEIPT_NO,RECEIPT_DATE,RECEIPT_NAME,RECEIPT_PHONE,REPLACE(REPLACE(RECEIPT_ADDRESS,',,',','),', ,',',') AS RECEIPT_ADDRESS, RECEIPT_PAYMENT_METHOD, RECEIPT_PRICE,CHEQUE_NO,CHEQUE_DATE,BANK_NAME,BRANCH_NAME FROM DEITY_RECEIPT WHERE ".$condition1." UNION SELECT DEITY_RECEIPT.RECEIPT_ID,RECEIPT_NO,RECEIPT_DATE,RECEIPT_NAME,RECEIPT_PHONE,REPLACE(REPLACE(RECEIPT_ADDRESS,',,',','),', ,',',') AS RECEIPT_ADDRESS, RECEIPT_PAYMENT_METHOD, GROUP_CONCAT(CONCAT(DY_IK_ITEM_NAME,' ',TRIM(DY_IK_ITEM_QTY)+0,' ',CONCAT(UCASE(LEFT(DY_IK_ITEM_UNIT, 1)),SUBSTRING(DY_IK_ITEM_UNIT, 2)))) AS RECEIPT_PRICE,'' AS CHEQUE_NO,'' AS CHEQUE_DATE,'' AS BANK_NAME,'' AS BRANCH_NAME FROM DEITY_RECEIPT INNER JOIN deity_inkind_offered ON DEITY_RECEIPT.RECEIPT_ID = deity_inkind_offered.RECEIPT_ID WHERE ".$condition2." GROUP BY deity_inkind_offered.RECEIPT_ID) t ORDER BY t.RECEIPT_ID ASC";
				else if($postageCriteria == 2 || $postageCriteria == 3)
					$query = "SELECT RECEIPT_ID,RECEIPT_NO,RECEIPT_DATE,RECEIPT_NAME,RECEIPT_PHONE,REPLACE(REPLACE(RECEIPT_ADDRESS,',,',','),', ,',',') AS RECEIPT_ADDRESS, RECEIPT_PAYMENT_METHOD, RECEIPT_PRICE,CHEQUE_NO,CHEQUE_DATE,BANK_NAME,BRANCH_NAME FROM DEITY_RECEIPT WHERE ".$condition." ORDER BY RECEIPT_ID ASC";	
				else 
					$query = "SELECT DEITY_RECEIPT.RECEIPT_ID,RECEIPT_NO,RECEIPT_DATE,RECEIPT_NAME,RECEIPT_PHONE,REPLACE(REPLACE(RECEIPT_ADDRESS,',,',','),', ,',',') AS RECEIPT_ADDRESS, RECEIPT_PAYMENT_METHOD, GROUP_CONCAT(CONCAT(DY_IK_ITEM_NAME,' ',TRIM(DY_IK_ITEM_QTY)+0,' ',CONCAT(UCASE(LEFT(DY_IK_ITEM_UNIT, 1)),SUBSTRING(DY_IK_ITEM_UNIT, 2)))) AS RECEIPT_PRICE,'' AS CHEQUE_NO,'' AS CHEQUE_DATE,'' AS BANK_NAME,'' AS BRANCH_NAME FROM DEITY_RECEIPT INNER JOIN deity_inkind_offered ON DEITY_RECEIPT.RECEIPT_ID = deity_inkind_offered.RECEIPT_ID WHERE ".$condition." GROUP BY deity_inkind_offered.RECEIPT_ID ORDER BY DEITY_RECEIPT.RECEIPT_ID ASC";
			} else {
				$query= "SELECT DEITY_RECEIPT.RECEIPT_ID,RECEIPT_NO,RECEIPT_DATE,RECEIPT_NAME,RECEIPT_PHONE,REPLACE(REPLACE(RECEIPT_ADDRESS,',,',','),', ,',',') AS RECEIPT_ADDRESS, RECEIPT_PAYMENT_METHOD, GROUP_CONCAT(CONCAT(DY_IK_ITEM_NAME,' ',TRIM(DY_IK_ITEM_QTY)+0,' ',CONCAT(UCASE(LEFT(DY_IK_ITEM_UNIT, 1)),SUBSTRING(DY_IK_ITEM_UNIT, 2)))) AS RECEIPT_PRICE,'' AS CHEQUE_NO,'' AS CHEQUE_DATE,'' AS BANK_NAME,'' AS BRANCH_NAME FROM DEITY_RECEIPT INNER JOIN deity_inkind_offered ON DEITY_RECEIPT.RECEIPT_ID = deity_inkind_offered.RECEIPT_ID WHERE ".$condition." GROUP BY deity_inkind_offered.RECEIPT_ID ORDER BY DEITY_RECEIPT.RECEIPT_ID ASC";
;
			}
		}		
		// echo "$query";
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
			$this->pdf->Write(12,$row->RECEIPT_NAME);
			$this->pdf->Ln();
			$this->pdf->Write(8,'Respected Samaj Bhandhav,');
			$this->pdf->Ln();
			$this->pdf->Justify('It gives us immense pleasure to inform you that, on completion of Renovation work (Suthu Pauli Jeernodhara) and the Punar Prathistha Mahotsava of Parivara Deities (Consecration ceremony) has been celebrated with all pomp and grandeur.',195,7);
			
			$this->pdf->Ln(2);
			$this->pdf->Justify('We are experiencing a sense of fulfilment owing to that active participation in this unique event.',195,7);

			$this->pdf->Ln(2);
			
			if (strpos($row->RECEIPT_NO,'IK' ) === false) {
				if($row->RECEIPT_PAYMENT_METHOD == "Cheque") {
					$this->pdf->Justify('It is our pleasure to acknowledge with gratitude your active participation; in the form of contribution/donation/kanika of Rs. '.$row->RECEIPT_PRICE.'/- (Rupees '.$this->ConvertRsToWords($row->RECEIPT_PRICE).') by Cheque/DD No: '.$row->CHEQUE_NO.', Date: '.$row->CHEQUE_DATE.', Bank: '.$row->BANK_NAME.' Branch: '.$row->BRANCH_NAME.' vide Receipt No: '.$row->RECEIPT_NO.', Receipt Date: '.$row->RECEIPT_DATE.' which has been already issued to you',195,7);	
				} else if($row->RECEIPT_PAYMENT_METHOD == "Credit / Debit Card" || $row->RECEIPT_PAYMENT_METHOD == "Direct Credit" || $row->RECEIPT_PAYMENT_METHOD == "Cash") {
					$this->pdf->Justify('It is our pleasure to acknowledge with gratitude your active participation; in the form of contribution/donation/kanika of Rs. '.$row->RECEIPT_PRICE.'/- (Rupees '.$this->ConvertRsToWords($row->RECEIPT_PRICE).') by '.$row->RECEIPT_PAYMENT_METHOD.' vide Receipt No: '.$row->RECEIPT_NO.', Receipt Date: '.$row->RECEIPT_DATE.' which has been already issued to you',195,7);
				} 
			} else {
				$this->pdf->Justify('It is our pleasure to acknowledge with gratitude by making available Articles of utility ('.$row->RECEIPT_PRICE.') too have been accepted and are of much use and utilised opportunity. We express our thankfulness for your active involvement.',195,7);
			}
			
			$this->pdf->Ln(2);
			$this->pdf->Justify("Prayers are offered at the Lotus feet of Shri Lakshmi Venkatesha Swamy and Parivara  Deva's to confer the divine grace on you and yours for Health, Happiness, peaceful  living  and alround prosperity on your day to day life.",195,7);
			
			$this->pdf->Ln(2);
			$this->pdf->Justify('May you are involved in such religious and philanthropic activities resulting in the sense of fulfilment leading to the tranquillity in future is prayed and Holy Prasadam is enclosed.',195,7);

			$this->pdf->Ln(2);
			$this->pdf->Justify(' Once again the Members of the Managing committee and Suthu Pauli Jeernodhara Committee express their gratitude.',195,7);
			$this->pdf->Ln();
			$this->pdf->Write(9,'Thanking you');
			$this->pdf->Ln();
			$this->pdf->Write(9,'Sincerely Yours.');
			$this->pdf->Ln();
			$this->pdf->Write(9,'For '.$templename[0]["TEMPLE_NAME"].',');
			$this->pdf->Ln(18);
			$this->pdf->Write(8,'MANAGING TRUSTEE');
			$this->pdf->Ln();
			$this->pdf->Write(6,'Encl: Prasad');
			$this->pdf->Ln();
		}
        
        $this->pdf->Output( 'Letter_Generation.pdf' , 'I' );
	}
}	