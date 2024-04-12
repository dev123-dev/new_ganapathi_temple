<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GenerationFPDF extends CI_Controller
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
		$selected = explode(',',$_POST['selPostChk']);
		$where = "";
		for($a = 0; $a < count($selected); $a++) {
			if($selected[$a] != "") {
				$res = explode('_',$selected[$a]);
				if($a == 0) {
					$where = "LABEL_COUNTER = ".$res[1];
				} else {
					$where .= " OR LABEL_COUNTER = ".$res[1];
				}
			}
		}
		
		if($_POST['posSearch'] != "") {
			$where .= " AND RECEIPT_NAME = '".$_POST['posSearch']."' OR RECEIPT_PHONE = '".$_POST['posSearch']."'";
		}
		
		if($_POST['posDate'] != "") {
			$where .= " AND DATE = '".$_POST['posDate']."'";
		}
		
		$query = "SELECT * FROM POSTAGE INNER JOIN DEITY_RECEIPT ON POSTAGE.RECEIPT_ID = DEITY_RECEIPT.RECEIPT_ID WHERE ".$where; 
		$result = $this->db->query($query);
		$number_of_products = $result->num_rows();
		
		function count_digit($number) {
			return strlen((string) $number);
		}
		$number_of_digits = count_digit($number_of_products); //this is call :)	
		
		//Initialize the 3 columns and the total
		$column_code = "";
		
		//For each row, add the field to the corresponding column
		$i = 0;
		foreach ($result->result() as $row) {
			//FOR UPDATEING LABEL COUNTER STARTS HERE
			$lCount = ((int)($row->LABEL_COUNTER) + 1);
			$data = array('LABEL_COUNTER' => $lCount);
			$condition = array('POSTAGE_ID' => $row->POSTAGE_ID);
			$this->obj_postage->update_model($condition,$data);
			//FOR UPDATEING LABEL COUNTER ENDS HERE HERE

			$code = 0001;
			$name = strtoupper($row->RECEIPT_NAME);
			$exp_date = date('dMY', strtotime($row->RECEIPT_DATE));
			$add1 = strtoupper($row->ADDRESS_LINE1);
			$add2 = strtoupper($row->ADDRESS_LINE2); 	
			$city = strtoupper($row->CITY); 	
			$add3 = strtoupper($row->COUNTRY); 			
			$add4 = $row->PINCODE; 	
					
			$arrResult['PlanCode'] = "";
			$arrResult['ExpDate'] = $exp_date;
			$arrResult['Name'] = $name;
			$arrResult['Add1'] = $add1;
			$arrResult['Add2'] = $add2;
			$arrResult['Add3'] = $city.", ".$add3;
			$arrResult['Add4'] = $add4;
			$arrLabels[$i] = $arrResult;
			$i++;
		}
		
		$this->pdf = new Pdf();
		$this->pdf->SetFont('Arial', null, 8);
		
		$l = 1;
		$k = 1;
		$x = 20;
		$num = sprintf("%0".$number_of_digits."d", 1);
		$number = $_POST['start'];
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
		
		for($rowF = 0; $rowF < $number_of_products; $rowF++) {
			if($l == 1) {
				$this->pdf->AddPage('P','A4',0);	
			}	
			$num_padded = sprintf("%0".$number_of_digits."d", $num);
			
			if($arrLabels[$rowF]['Add3'] != "" && $arrLabels[$rowF]['Add4'] != "") {
				@$column_code = $num_padded."              ".$arrLabels[$rowF]['PlanCode']."              ".$arrLabels[$rowF]['ExpDate']."\n".$arrLabels[$rowF]['Name']."\n".$arrLabels[$rowF]['Add1']."\n".$arrLabels[$rowF]['Add2']."\n".$arrLabels[$rowF]['Add3']."-".$arrLabels[$rowF]['Add4'];
			} else if ($arrLabels[$rowF]['Add3'] == "" && $arrLabels[$rowF]['Add4'] != "") {
				@$column_code = $num_padded."              ".$arrLabels[$rowF]['PlanCode']."              ".$arrLabels[$rowF]['ExpDate']."\n".$arrLabels[$rowF]['Name']."\n".$arrLabels[$rowF]['Add1']."\n".$arrLabels[$rowF]['Add2']."\n".$arrLabels[$rowF]['Add4'];
			} else if ($arrLabels[$rowF]['Add3'] != "" && $arrLabels[$rowF]['Add4'] == "") {
				@$column_code = $num_padded."              ".$arrLabels[$rowF]['PlanCode']."              ".$arrLabels[$rowF]['ExpDate']."\n".$arrLabels[$rowF]['Name']."\n".$arrLabels[$rowF]['Add1']."\n".$arrLabels[$rowF]['Add2']."\n".$arrLabels[$rowF]['Add3'];
			} else if ($arrLabels[$rowF]['Add3'] == "" && $arrLabels[$rowF]['Add4'] == "") {
				@$column_code = $num_padded."              ".$arrLabels[$rowF]['PlanCode']."              ".$arrLabels[$rowF]['ExpDate']."\n".$arrLabels[$rowF]['Name']."\n".$arrLabels[$rowF]['Add1']."\n".$arrLabels[$rowF]['Add2'];
			}
		
			if($k == 1) {
				$this->pdf->SetXY(12,$x);
				$this->pdf->MultiCell(0, 3, $column_code, 0);
			}
			
			if($k == 2) {
				$this->pdf->SetXY(79,$x);
				$this->pdf->MultiCell(0, 3, $column_code, 0);
			}
			
			if($k == 3) {
				$this->pdf->SetXY(144,$x);
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
