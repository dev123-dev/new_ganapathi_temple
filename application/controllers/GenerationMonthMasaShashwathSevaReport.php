<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class GenerationMonthMasaShashwathSevaReport extends CI_Controller
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
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$date = date('d-m-Y');
		$month = $this->input->post('month');

		$month_name = date("F", mktime(0, 0, 0, substr($month,1), 10));

		$masa = $this->input->post('masa');
		
		if($masa != ''){ 
			$filter = "(STR_TO_DATE('$date','%d-%m-%Y') BETWEEN STR_TO_DATE(CAL_START_DATE,'%d-%m-%Y') AND STR_TO_DATE(CAL_END_DATE,'%d-%m-%Y')) AND shashwath_seva.MASA LIKE '$masa%'";

		} else {	
			$filter = "shashwath_seva.ENG_DATE LIKE '%$month'";
		}
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");
		
		
		$html .= '<h3>SHASHWATH SEVA DETAILS '.(($masa != "")?"(Masa: <u>".$masa."</u>)":"(Month: <u>".$month_name."</u>)").'</h3>';	
		$sql = "SELECT 
			    (ROW_NUMBER() OVER(ORDER BY ".(($masa != "")?"STR_TO_DATE(calendar_year_breakup.ENG_DATE,'%d-%m-%Y')":"shashwath_seva.ENG_DATE").")) AS SERIAL_NO,
			    shashwath_members.SM_NAME, 
			    IF((shashwath_members.SM_PHONE != ''),CONCAT(shashwath_members.SM_NAME,' (',shashwath_members.SM_PHONE,')') ,shashwath_members.SM_NAME) AS NAME_PHONE,
			    CONCAT(SM_ADDR1,' ',SM_ADDR2,' ',SM_CITY,' ',SM_PIN) AS Address,
			    SM_CITY As PLACE,
			    THITHI_CODE, ";

		$sql .= (($masa != "")?"calendar_year_breakup.ENG_DATE,":"shashwath_seva.ENG_DATE, "); 
		
		$sql .=	" deity.DEITY_NAME, 
			    DEITY_SEVA.SEVA_NAME,
			    SEVA_QTY,
			    SUM(RECEIPT_PRICE) AS CORPUS
			    FROM shashwath_members JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID 
                       JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID 
                       JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID 
                       JOIN SHASHWATH_PERIOD_SETTING ON SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID 
                       INNER JOIN deity_receipt ON deity_receipt.SS_ID = shashwath_seva.SS_ID ";

        $sql .= (($masa != "")?"JOIN calendar_year_breakup ON calendar_year_breakup.THITHI_SHORT_CODE = shashwath_seva.THITHI_CODE INNER JOIN CALENDAR ON calendar_year_breakup.CAL_ID = calendar.CAL_ID":"");
                       
		$sql .= " WHERE ".$filter." AND shashwath_seva.SS_STATUS = 1 GROUP BY shashwath_seva.SS_ID
				ORDER BY ".(($masa != "")?"STR_TO_DATE(calendar_year_breakup.ENG_DATE,'%d-%m-%Y')":"shashwath_seva.ENG_DATE");			

		$query = $this->db->query($sql);

		$data['sevaDet'] = $query->result('array');
		$html .= '<table style="font-weight:600;font-size:11px;">
		          	<thead>
		          		<tr>
		          			<th style="padding:5px;">SNo</th>
		          			<th style="padding:5px;">Eng Date</th>'.
		          			(($masa != "")?'<th style="padding:5px;">Thithi Code</th>':'').
		          			'<th style="padding:5px;">Name (Phone)</th>
		          			<th style="padding:5px;">Place</th>
		          			<th style="padding:5px;">Deity Name</th>
		          			<th style="padding:5px;">Seva Name</th>
		          			<th style="padding:5px;">Corpus</th>
		          			<th style="padding:5px;">Seva Qty</th>
		          		</tr>
		          	</thead><tbody>';
		foreach($data['sevaDet'] as $result) {	
			$html .= "<tr>";	
			$html .= "<td style='padding:5px;'><center>".$result['SERIAL_NO']."</center></td>";
			$html .= "<td style='padding:5px;'><center>".$result['ENG_DATE']."</center></td>";
			$html .= (($masa != "")?"<td style='padding:5px;'><center>".$result['THITHI_CODE']."</center></td>":"");
			$html .= "<td style='padding:5px;'>".$result['NAME_PHONE']."</td>";
			$html .= "<td style='padding:5px;'>".$result['PLACE']."</td>";
			$html .= "<td style='padding:5px;'>".$result['DEITY_NAME']."</td>";
			$html .= "<td style='padding:5px;'>".$result['SEVA_NAME']."</td>";
			$html .= "<td style='padding:5px;'>".$result['CORPUS']."</td>";
			$html .= "<td style='padding:5px;'><center>".$result['SEVA_QTY']."</center></td>";			
		
			$html .= "</tr>";				
		}
		$html .= "</table>";	
		$html .= "<h5>Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>";
		$i++;
			
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		// Set a simple Footer including the page number
		$pdf->setFooter('{PAGENO}');
		$stylesheet = file_get_contents($bootstrap); // external css

		$pdf->AddPage('L', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            15, // margin bottom
		            18, // margin header
		            12);
		$pdf->WriteHTML($stylesheet,1);
		// $pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		
		$pdf->Output('UnVerified Shashwath.pdf','I');


	}
}