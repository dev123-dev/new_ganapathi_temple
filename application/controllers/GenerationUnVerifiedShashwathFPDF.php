<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class GenerationUnVerifiedShashwathFPDF extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('date');
		$this->load->helper('string');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->helper('date');
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('Postage_model','obj_postage',true);	
		$this->load->model('Shashwath_Model','obj_shashwath',true);
         // $this->load->add_package_path( APPPATH . 'third_party/fpdf');
        // $this->load->library('pdf');
	}

	public function index() {

		ini_set("memory_limit","2G");		
		$bootstrap = base_url().'css/pdf.css';
		$start = $_GET['startFrom']-1;
		$sqlDK = 'SELECT shashwath_members.SM_ID,SM_NAME,SM_REF, SM_PHONE, SM_ADDR1, SM_ADDR2, SM_CITY, SM_STATE, SM_COUNTRY, SM_PIN, SM_RASHI, SM_NAKSHATRA, SM_GOTRA, REMARKS FROM SHASHWATH_MEMBERS JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID JOIN DEITY_RECEIPT ON DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID WHERE DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 AND DEITY_RECEIPT.RECEIPT_ACTIVE =1 AND SHASHWATH_SEVA.SS_VERIFICATION= 0 GROUP BY shashwath_members.SM_ID ORDER BY SHASHWATH_SEVA.SS_RECEIPT_NO ASC limit '.$start.' , 500';
		$queryDK = $this->db->query($sqlDK);
		$data['membersDet'] = $queryDK->result('array');
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");
		
		$i = $_GET['startFrom'] ;
		if(!empty($data['membersDet'])) {
			$html .= '<h3>SHASHWATH MEMBER DETAILS</h3>';
			foreach($data['membersDet'] as $result) {
				$condition = $result['SM_ID'];
				$sqlDK1 = "SELECT SM_REF, SHASHWATH_SEVA.SS_ID, SS_REF, SHASHWATH_SEVA.SM_ID, SS_RECEIPT_NO, SS_RECEIPT_DATE, SHASHWATH_SEVA.DEITY_ID, SHASHWATH_SEVA.SEVA_ID, SEVA_QTY, SHASHWATH_SEVA.SEVA_TYPE, CAL_TYPE, THITHI_CODE, ENG_DATE, SHASHWATH_SEVA.SP_ID, SHASHWATH_SEVA.SP_COUNTER, SS_STATUS, MASA, BASED_ON_MOON, THITHI_NAME, SHASHWATH_SEVA.SEVA_NOTES, SHASHWATH_SEVA.SS_VERIFICATION, DEITY.DEITY_ID, DEITY_CODE, DEITY_NAME, DEITY.DATE_TIME, DEITY.DATE, DEITY.USER_ID, DEITY_ACTIVE, DEITY_SEVA.SEVA_ID, SEVA_CODE, SEVA_NAME, DEITY_SEVA.DEITY_ID, SEVA_DESC, DEITY_SEVA.DATE_TIME, DEITY_SEVA.DATE, DEITY_SEVA.USER_ID, SEVA_ACTIVE, QUANTITY_CHECKER, IS_SEVA, BOOKING, IS_TOKEN, DEITY_SEVA.SEVA_TYPE, SEVA_BELONGSTO, DEITY_RECEIPT.RECEIPT_ID, RECEIPT_NO, RECEIPT_DATE, RECEIPT_NAME, RECEIPT_PHONE, RECEIPT_EMAIL, RECEIPT_ADDRESS, RECEIPT_RASHI, RECEIPT_NAKSHATRA, RECEIPT_DEITY_NAME, RECEIPT_DEITY_ID, SUM(RECEIPT_PRICE) as RECEIPT_PRICE, RECEIPT_PAYMENT_METHOD, CHEQUE_NO, CHEQUE_DATE, BANK_NAME, BRANCH_NAME, TRANSACTION_ID, RECEIPT_PAYMENT_METHOD_NOTES, RECEIPT_ISSUED_BY, RECEIPT_ISSUED_BY_ID, DEITY_RECEIPT.DATE_TIME, RECEIPT_ACTIVE, RECEIPT_CATEGORY_ID, PAYMENT_STATUS, PAYMENT_CONFIRMED_BY_NAME, PAYMENT_CONFIRMED_BY, PAYMENT_DATE_TIME, PAYMENT_DATE,  CHEQUE_CREDITED_DATE, DATE_TYPE, IS_BOOKING, RECEIPT_SB_ID, IS_TRUST, RECEIPT_HB_ID, POSTAGE_CHECK, POSTAGE_PRICE, POSTAGE_GROUP_ID, ADDRESS_LINE1, ADDRESS_LINE2, CITY, STATE, COUNTRY, PINCODE, DEITY_RECEIPT.SS_ID, PRINT_STATUS, IS_JEERNODHARA, SHASHWATH_PERIOD_SETTING.SP_ID, PERIOD_NAME, PERIOD, P_STATUS, COUNT(*) as CORPUS_CNT FROM shashwath_members JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID JOIN DEITY_RECEIPT ON DEITY_RECEIPT.SS_ID = SHASHWATH_SEVA.SS_ID JOIN SHASHWATH_PERIOD_SETTING ON SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID WHERE SHASHWATH_SEVA.SM_ID = ".$condition." AND DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 AND DEITY_RECEIPT.RECEIPT_ACTIVE = 1 GROUP BY DEITY_RECEIPT.SS_ID";

				$queryDK1 = $this->db->query($sqlDK1);
				$countSeva = $queryDK1->num_rows();
				$data1['membersSeva'] = $queryDK1->result('array');

			
				$html .= "<table style='margin-top:5px;width:100%' ><tr >";
				
				$html .= "<td colspan=3 style='padding:5px;'><b>Name</b> :".$i.". ".$result['SM_NAME']."</td>";
				$html .= "<td colspan=5 style='padding:5px;'><b>Addr</b> : ".$result['SM_ADDR1']."  ".$result['SM_ADDR2']."</td>";
				$html .= "</tr>";

				$html .= "<tr>";
				$html .= "<td colspan=3 style='padding:5px;'><b>Phone</b> : ".$result['SM_PHONE']."</td>";
				$html .= "<td colspan=5 style='padding:5px;'><b>Addr2</b> : ".$result['SM_CITY']."  ".$result['SM_STATE']."  ".$result['SM_COUNTRY']."  ".$result['SM_PIN']."</td>";					
				$html .= "</tr>";

				

				$html .= '<tr><th colspan=8 style="padding:5px;">SEVA DETAILS</th></tr><tr><th style="padding:5px;">Old RNo</th><th style="padding:5px;">ReceiptDate</th><th style="padding:5px;">Deity Name.</th><th style="padding:5px;">Seva Name</th><th colspan=1>Qty</th><th style="padding:5px;">Corpus</th><th style="padding:5px;">Date/Thithi</th><th style="padding:5px;">Purpose</th></tr>';
				
				foreach($data1['membersSeva'] as $result2) {
					$html .= "<tr>";	
					$html .= "<td style='padding:5px;'>".$result2['SS_RECEIPT_NO']."</td>";
					$html .= "<td style='padding:5px;'>".$result2['SS_RECEIPT_DATE']."</td>";

					$html .= "<td style='padding:5px;'>".$result2['DEITY_NAME']."</td>";
					$html .= "<td style='padding:5px;'>".$result2['SEVA_NAME']."</td>";
					$html .= "<td>".$result2['SEVA_QTY']."</td>";
					$html .= "<td style='padding:5px;'>".$result2['RECEIPT_PRICE']."</td>";

					$html .= "<td style='padding:5px;'>".$result2['ENG_DATE']." ".$result2['THITHI_CODE']."</td>";
					$html .= "<td style='padding:5px;'>".$result2['SEVA_NOTES']."</td>";
				
					$html .= "</tr>";
				
				}

				$html .= "</table>";	
				$html .= "<h5>Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>";

				// exit(0);
					$i++;
			}
			
		}

		unset($_SESSION['membersDet']);
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->AddPage('L', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            10, // margin bottom
		            18, // margin header
		            12);
		$pdf->WriteHTML($stylesheet,1);
		// $pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		
		$pdf->Output('UnVerified Shashwath.pdf','I');

	}
}