<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class generatePDF extends CI_Controller {
    function __construct()
    {
        parent::__construct();
		$this->load->helper('date');
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('Report_modal','obj_report',true);
		$this->load->model('Events_modal','obj_events',true);
		$this->load->model('Receipt_modal','obj_receipt',true);
		$this->load->model('TrustReport_model','obj_trust_report',true);
		$this->load->model('Booking_model','obj_booking',true);	
		$this->load->model('EOD_modal','obj_eod',true);
		$this->load->model('TrustEOD_modal','obj_trust_eod',true);
		$this->load->model('EventEOD_modal','obj_event_eod',true);
		$this->load->model('Shashwath_Model','obj_shashwath',true);
		$this->load->model('TrustEventEOD_modal','obj_trust_event_eod',true);
		$this->load->model('TrustEvents_modal','obj_trust_events',true);
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		$this->load->model('finance_model','obj_finance',true);
		// added by adithya on 27-12-23 start
		$this->load->model('trust_finance_model','obj_trust_finance',true);
		// added by adithya on 27-12-23 end

    }
	
	//TRUST EVENT SEVA REPORT PDF
	public function create_trustSevaReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate" && $this->input->post('SId') == "All") {
			$allDates1 = explode("|",$allDates);
			$queryString = "";
			for($i = 0; $i < count($allDates1); ++$i) {
				if($i == 0)
					$queryString .= "TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."'";
				else
					$queryString .= " or TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."'";
			}					
			$condition = $queryString;
			$res = $this->obj_trust_report->get_all_field_event_seva_excel($condition);
		} else if(@$radioOpt == "multiDate"){
			$allDates1 = explode("|",$allDates);
			$queryString = "";
			for($i = 0; $i < count($allDates1); ++$i) {
				if($i == 0)
					$queryString .= "TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."' and TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID='".$this->input->post('SId')."'";
				else
					$queryString .= " or TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."' and TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID='".$this->input->post('SId')."'";
			}
			$condition = $queryString;
			$res = $this->obj_trust_report->get_all_field_event_seva_excel($condition);
		} else {
			if(($this->input->post('dateField')) != "" && ($this->input->post('SId') == "All")) {
				$condition = array('TET_RECEIPT_ACTIVE' =>1,'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => $this->input->post('dateField'));
				$res = $this->obj_trust_report->get_all_field_event_seva_excel($condition);
			} else {
				$condition = array('TET_RECEIPT_ACTIVE' =>1,'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => $this->input->post('dateField'), 'TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID' => $this->input->post('SId'));
				$res = $this->obj_trust_report->get_all_field_event_seva_excel($condition);
			}
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Event Sevas Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVA</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">RECEIPT NO.</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".$j."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_SO_SEVA_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_NAME."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_PHONE."</td>";				
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_NO."</td>";
			$html .= '</tr>';
			$j++;
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Event Sevas Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else
			$pdf->Output('Event Sevas Report ('.$_POST['dateField'].').pdf','D');
    }
	
	
	//active event address pdf
	/* public function create_eventaddresspdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		$this->db->select('*');
		$this->db->from('EVENT_RECEIPT');
		$this->db->join('event','event.ET_ID = EVENT_RECEIPT.RECEIPT_ET_ID');
		$where =array('event.ET_ACTIVE'=>1,'EVENT_RECEIPT.ET_RECEIPT_ACTIVE'=>1,'EVENT_RECEIPT.ET_RECEIPT_CATEGORY_ID!='=>3,'event_receipt.POSTAGE_CHECK' =>1);
		/* $this->db->where('event.ET_ACTIVE',1); 
		$this->db->where($where);
		$query = $this->db->get();
		$res = $query->result();

		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>Sri Lakshmi Venkatesh Temple</strong></center>";
		$hDate = $today = date("F j, Y, g:i a");   
		//$html .= "<center><strong>Event Address ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>"; 
		//$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">ADDRESS</th></tr></thead><tbody>';
		//$html .= '<table><thead><tr></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			//$html .= "<td style='padding:5px;'>".$j."</td>";			
			//$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_NAME."</td>";			
			//$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_PHONE."</td>";		
			//$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_EMAIL."</td>";				
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_ADDRESS."</td>";
			$html .= '</tr> <br/>';
			//$j++;
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		//$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Event Address ('.$hDate.').pdf','D');
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		/* if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Event Sevas Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else
			$pdf->Output('Event Sevas Report ('.$_POST['dateField'].').pdf','D'); 
    } */
	
	
	/* public function create_trusteventaddresspdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		$this->db->select('*');
		$this->db->from('TRUST_EVENT_RECEIPT');
		$this->db->join('trust_event','trust_event.TET_ID = TRUST_EVENT_RECEIPT.RECEIPT_TET_ID');
		$where =array('trust_event.TET_ACTIVE'=>1,'TRUST_EVENT_RECEIPT.TET_RECEIPT_ACTIVE'=>1,'TRUST_EVENT_RECEIPT.TET_RECEIPT_CATEGORY_ID!='=>3,'trust_event_receipt.POSTAGE_CHECK' =>1);
		/* $this->db->where('event.ET_ACTIVE',1); 
		$this->db->where($where);
		$query = $this->db->get();
		$res = $query->result();

		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>Sri Lakshmi Venkatesh Temple</strong></center>";
		$hDate = $today = date("F j, Y, g:i a");   
		//$html .= "<center><strong>Event Address ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>"; 
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">ADDRESS</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".$j."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_PHONE."</td>";		
			//$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_EMAIL."</td>";				
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_ADDRESS."</td>";
			$html .= '</tr>';
			$j++;
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		//$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Trust Event Address ('.$hDate.').pdf','D');
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		/* if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Event Sevas Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else
			$pdf->Output('Event Sevas Report ('.$_POST['dateField'].').pdf','D'); 
    } */
	
	
	//HALL BOOKING PRINT
	public function create_hallBookingPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(isset($_POST['hallId'])) {
			$hallId = @$_POST['hallId'];
		} else {
			$hallId = $_SESSION['hallId'];
		}
		
		if(isset($_POST['dateField'])) {
			$date = $this->input->post('dateField');
		} else {
			$date = $_SESSION['date'];
		}
		
		if($hallId != "All Hall") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1 and H_ID = ".$hallId."";
					} else {
						$queryString .= " or HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1 and H_ID = ".$hallId."";
					}
				}
				$condition= $queryString;
			} else {
				$condition= array('HB_BOOK_DATE' => $date,'HBL_ACTIVE' => 1,'H_ID' => $hallId);
			}
			$res = $this->obj_trust_report->get_all_field_hall_booking_excel($condition,'HB_BOOK_DATE','desc');
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1"; 
					} else {
						$queryString .= " or HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1";
					}
				}
				$condition= $queryString;
			} else {
				$condition= array('HB_BOOK_DATE' => $date,'HBL_ACTIVE' => 1);
			}
			$res = $this->obj_trust_report->get_all_field_hall_booking_excel($condition,'HB_BOOK_DATE','desc');
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_SESSION['dateField'].")";
		}
		
		//unset($_SESSION['dateField']);
		//unset($_SESSION['hallId']); 
		//unset($_SESSION['radioOpt']); 
		//unset($_SESSION['allDates']); 
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Hall Booking Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$j = 1;
		$name = ""; 
		$z = 0;
		$arr = [];
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html);
		$html = "";
		for($i = 0; $i < sizeof($res); $i++)
		{
			$fromTime = strtotime($res[$i]->HB_BOOK_TIME_FROM);
			$toTime = strtotime($res[$i]->HB_BOOK_TIME_TO);
			$diff = $toTime - $fromTime;
			$time = $diff; 
			$days = floor($time / (60 * 60 * 24));
			$time -= $days * (60 * 60 * 24);

			$hours = floor($time / (60 * 60));
			$time -= $hours * (60 * 60);

			$minutes = floor($time / 60);
			$time -= $minutes * 60;

			$seconds = floor($time);
			$time -= $seconds;
			
			if($name == $res[$i]->H_NAME) {
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".($i+1)."</td>";  					
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_NAME."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]->FN_NAME."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_NO."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_BOOK_DATE."</td>";			
				$html .= "<td style='padding:5px;'>".date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_FROM))."</td>";			
				$html .= "<td style='padding:5px;'>".date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_TO))."</td>";		
				$html .= "<td style='padding:5px;'>".$hours."h ".$minutes."m"."</td>";				
				$html .= '</tr>';
			} else {
				if($i != 0) {
					$html .="</tbody></table><br/>";
					$pdf->WriteHTML($html);
					$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
				}
				$html = "<center><strong>Hall: ".$res[$i]->H_NAME."</strong></center>";
				$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Name</th><th style="padding:5px;">Function Type</th><th style="padding:5px;">Booking No.</th><th style="padding:5px;">Booking Date</th><th style="padding:5px;">From Time</th><th style="padding:5px;">To Time</th><th style="padding:5px;">Hours</th></tr></thead><tbody>';
				
				$name = $res[$i]->H_NAME;
				if($z != 0) {
					$html .= "<tr><td colspan='5'></td></tr>";
				}
				array_push($arr,trim($res[$i]->H_NAME));
				
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".($i+1)."</td>";  		
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_NAME."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]->FN_NAME."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_NO."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_BOOK_DATE."</td>";			
				$html .= "<td style='padding:5px;'>".date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_FROM))."</td>";			
				$html .= "<td style='padding:5px;'>".date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_TO))."</td>";		
				$html .= "<td style='padding:5px;'>".$hours."h ".$minutes."m"."</td>";				
				$html .= '</tr>';
			}
			$j++;
		}
		
		$html .="</tbody></table><br>";		
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		
		if(@$radioOpt == "multiDate") {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
			
			$pdf->Output("Hall Booking Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Hall Booking Report ('.$_POST['dateField'].').pdf','I');
    }
	
	//FOR PRINT HALL BOOKING
	public function create_hallBookingSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['date'] = $_POST['dateField'];
		$_SESSION['hallId'] = $_POST['hallId'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['allDates'] = @$_POST['allDates'];
		echo 1;
	}
	
	//HALL BOOKING PDF
	public function create_hallBookingpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(isset($_POST['hallId'])) {
			$hallId = @$_POST['hallId'];
		} else {
			$hallId = $_SESSION['hallId'];
		}
		
		if($hallId != "All Hall") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1 and H_ID = ".$hallId."";
					} else {
						$queryString .= " or HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1 and H_ID = ".$hallId."";
					}
				}
				$condition= $queryString;
			} else {
				$condition= array('HB_BOOK_DATE' => $_POST['dateField'],'HBL_ACTIVE' => 1,'H_ID' => $hallId);
			}
			$res = $this->obj_trust_report->get_all_field_hall_booking_excel($condition,'HB_BOOK_DATE','desc');
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1"; 
					} else {
						$queryString .= " or HB_BOOK_DATE='".$allDates1[$i]."' and HBL_ACTIVE = 1";
					}
				}
				$condition= $queryString;
			} else {
				$condition= array('HB_BOOK_DATE' => $_POST['dateField'],'HBL_ACTIVE'=>1);
			}
			$res = $this->obj_trust_report->get_all_field_hall_booking_excel($condition,'HB_BOOK_DATE','desc');
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Hall Booking Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$j = 1;
		$name = ""; 
		$z = 0;
		
		$arr = [];
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html);
		$html = "";
		for($i = 0; $i < sizeof($res); $i++)
		{	
			$fromTime = strtotime($res[$i]->HB_BOOK_TIME_FROM);
			$toTime = strtotime($res[$i]->HB_BOOK_TIME_TO);
			$diff = $toTime - $fromTime;
			$time = $diff; 
			$days = floor($time / (60 * 60 * 24));
			$time -= $days * (60 * 60 * 24);

			$hours = floor($time / (60 * 60));
			$time -= $hours * (60 * 60);

			$minutes = floor($time / 60);
			$time -= $minutes * 60;

			$seconds = floor($time);
			$time -= $seconds;
			
			if($name == $res[$i]->H_NAME) {
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";  			
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_NAME."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]->FN_NAME."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_NO."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_BOOK_DATE."</td>";			
				$html .= "<td style='padding:5px;'>".date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_FROM))."</td>";			
				$html .= "<td style='padding:5px;'>".date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_TO))."</td>";				
				$html .= "<td style='padding:5px;'>".$hours."h ".$minutes."m"."</td>";				
				$html .= '</tr>';
			} else {
				if($i != 0) {
					$html .="</tbody></table><br/>";
					$pdf->WriteHTML($html);
					$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
				}
				$html = "<center><strong>Hall: ".$res[$i]->H_NAME."</strong></center>";
				$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Name </th><th style="padding:5px;">Function Type </th><th style="padding:5px;">Booking No. </th><th style="padding:5px;">Booking Date</th><th style="padding:5px;">From Time</th><th style="padding:5px;">To Time</th><th style="padding:5px;">Hours</th></tr></thead><tbody>';
				
				$name = $res[$i]->H_NAME;
				if($z != 0) {
					$html .= "<tr><td colspan='5'></td></tr>";
				}
				
				array_push($arr,trim($res[$i]->H_NAME));
				
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";  				
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_NAME."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]->FN_NAME."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_NO."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]->HB_BOOK_DATE."</td>";			
				$html .= "<td style='padding:5px;'>".date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_FROM))."</td>";			
				$html .= "<td style='padding:5px;'>".date('g:i a', strtotime($res[$i]->HB_BOOK_TIME_TO))."</td>";				
				$html .= "<td style='padding:5px;'>".$hours."h ".$minutes."m"."</td>";				
				$html .= '</tr>';
			}
			$j++;
		}
		$html .="</tbody></table><br>";
		
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Hall Booking Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else
			$pdf->Output('Hall Booking Report ('.$_POST['dateField'].').pdf','D');
    }
	
	//FOR TRUST MIS PRINT
	public function create_trustMISPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_trust_report->get_all_field_mis_report_period($fromDate,$toDate);
			$res_inkind = $this->obj_trust_report->get_all_field_mis_report_period_inkind($fromDate,$toDate);
		} else {
			$res = $this->obj_trust_report->get_all_field_mis_report($date);
			$res_inkind = $this->obj_trust_report->get_all_field_mis_report_inkind($date);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Trust MIS Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">FINANCIAL HEAD</th><th style="padding:5px;">QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".$j."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]['FH_NAME']."</td>";			
			$html .= "<td style='padding:5px;text-align:center;'>".$res[$i]['QTY']."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['PRICE']."</td>";		
			$html .= '</tr>';
			$j++;
		}
		
		$html .="</tbody></table><br>";

		$html .= '<table><thead><tr><th>Receipt No</th><th>Name</th><th>Item Name</th><th>Quantity</th></tr></thead><tbody>';
		$j = 1;
		for($i = 0; $i < sizeof($res_inkind); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".$res_inkind[$i]['TR_NO']."</td>";		
			$html .= "<td style='padding:5px;'>".$res_inkind[$i]['RECEIPT_NAME']."</td>";			
			$html .= "<td style='padding:5px;'>".$res_inkind[$i]['IK_ITEM_NAME']."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res_inkind[$i]['amount']." ".$res_inkind[$i]['IK_ITEM_UNIT']."</td>";		
			$html .= '</tr>';
			$j++;
		}
		
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Trust MIS Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Trust MIS Report ('.$_POST['dateField'].').pdf','I');
	}
	
	//FOR TRUST MIS PRINT SESSION
	public function create_trustMISSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['date'] = $_POST['dateField'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		echo 1;	
	}

	//FOR TRUST MIS PDF
	public function create_trustMISpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
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
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_trust_report->get_all_field_mis_report_period($fromDate,$toDate);
			$res_inkind = $this->obj_trust_report->get_all_field_mis_report_period_inkind($fromDate,$toDate);
		} else {
			$res = $this->obj_trust_report->get_all_field_mis_report($date);
			$res_inkind = $this->obj_trust_report->get_all_field_mis_report_inkind($date);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Trust MIS Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">FINANCIAL HEAD</th><th style="padding:5px;">QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".$j."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]['FH_NAME']."</td>";			
			$html .= "<td style='padding:5px;text-align:center;'>".$res[$i]['QTY']."</td>";		
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['PRICE']."</td>";		
			$html .= '</tr>';
			$j++;
		}
		$html .="</tbody></table><br>";

		$html .= '<table><thead><tr><th>Receipt No</th><th>Name</th><th>Item Name</th><th>Quantity</th></tr></thead><tbody>';
		$j = 1;
		for($i = 0; $i < sizeof($res_inkind); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".$res_inkind[$i]['TR_NO']."</td>";		
			$html .= "<td style='padding:5px;'>".$res_inkind[$i]['RECEIPT_NAME']."</td>";			
			$html .= "<td style='padding:5px;'>".$res_inkind[$i]['IK_ITEM_NAME']."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res_inkind[$i]['amount']." ".$res_inkind[$i]['IK_ITEM_UNIT']."</td>";		
			$html .= '</tr>';
			$j++;
		}
		
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Deity Sevas Summmary Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Deity Sevas Summmary Report ('.$_POST['dateField'].').pdf','D');
		}
	}
	//TRUST EOD TALLY PDF
	public function create_trustEodTallypdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		//FROM DATE AND TO DATE
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDates'])) {
			$fromDates= @$_POST['fromDates'];
			$_SESSION['fromDates'] = $fromDates;
		} else {
			$fromDates = $_SESSION['fromDates'];
		}
		$data['fromDates'] = $fromDates;
		
		if(isset($_POST['toDates'])) {
			$toDates= @$_POST['toDates'];
			$_SESSION['toDates'] = $toDates;
		} else {
			$toDates = $_SESSION['toDates'];
		}
		$data['toDates'] = $toDates;
		
		if(isset($_POST['yCombo'])) {
			$yCombo= @$_POST['yCombo'];
			$_SESSION['yCombo'] = $yCombo;
		} else {
		$yCombo = $_SESSION['yCombo'];
		}
		$data['yCombo'] = $yCombo;
		
		if(isset($_POST['myCombo'])) {
			$myCombo= @$_POST['myCombo'];
			$_SESSION['myCombo'] = $myCombo;
		} else {
			$myCombo = $_SESSION['myCombo'];
		}
		$data['myCombo'] = $myCombo;
		
		if(isset($_POST['mmCombo'])) {
			$mmCombo= @$_POST['mmCombo'];
			$_SESSION['mmCombo'] = $mmCombo;
		} else {
			$mmCombo = $_SESSION['mmCombo'];
		}
		$data['mmCombo'] = $mmCombo;
		
		if($radioOpt == "year") {
			$yr = (explode(" - ",$_POST['yCombo']));
			$fromDate = $yr[0].'-04-01';
			$toDate = ($yr[1]).'-03-31';
			$title = "(".$yCombo.")";
		} else if($radioOpt == "month") {
			$yr = $_POST['myCombo'];
			$mnth = (sprintf("%02d", $_POST['mmCombo']));
			$fromDate = $yr.'-'.$mnth.'-01';
			$toDate = $yr.'-'.$mnth.'-31';
			$dt = DateTime::createFromFormat('!m', $mmCombo);
			$title = "(".$myCombo." - ".$dt->format('F').")";
		} else if($radioOpt == "date") {
			$dOne = (explode("-",$_POST['fromDates']));
			$dTwo = (explode("-",$_POST['toDates']));
			$fromDate = $dOne[2].'-'.$dOne[1].'-'.$dOne[0];
			$toDate = $dTwo[2].'-'.$dTwo[1].'-'.$dTwo[0];
			$title = "(".$fromDates." To ".$toDates.")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Trust EOD Tally Report ".$title."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Entry Date</th><th style="padding:5px;">Op.Bal.</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Credit</th><th style="padding:5px;">Debit</th><th style="padding:5px;">Balance</th><th style="padding:5px;">Bank</th><th style="padding:5px;">Deposit Date</th><th style="padding:5px;">Eod Date</th></tr></thead><tbody>';
		
		//CREDIT TOTAL
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(TUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$creditTotal = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(TUC_CASH) AS TCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_CASH) AS TCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$cCash = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(TUC_CHEQUE) AS TCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_CHEQUE) AS TCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$cCheque = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(TUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$dCash = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(TUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$dCheque = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(TUC_DEBIT) AS TDebit FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_DEBIT) AS TDebit FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$debitTotal = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(TUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TUC_DEBIT),0) AS TDebit FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(TUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TUC_DEBIT),0) AS TDebit FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$balance = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(TUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."'AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$balanceCash = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM(TUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."'AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$balanceCheque = $query->first_row();
		
		//BANK
		$this->db->from('BANK');
		$query = $this->db->get();
		$bank = $query->result();
		
		$conditionOne = array('ENTERED_BY' => $this->session->userdata('userId'));
		$res = $this->obj_trust_eod->get_all_field($fromDate, $toDate);
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".date('d-m-Y',strtotime($res[$i]->TUC_DATE))."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->OpBal."</td>";			
			
			if($res[$i]->TUC_CASH != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_CASH."</td>";			
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_CASH_DEPOSIT."</td>";			
			
			if($res[$i]->TUC_CHEQUE != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_CHEQUE."</td>";		
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_CHEQUE_DEPOSIT."</td>";			
				
			if($res[$i]->TUC_CASH_CHEQUE != NULL)	
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_CASH_CHEQUE."</td>";
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";		

			if($res[$i]->TUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_DEBIT ."</td>";		
			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->ClBal ."</td>";	

			if($res[$i]->BANK_NAME != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->ACCOUNT_NO .", ". $res[$i]->BANK_NAME .", ". $res[$i]->BANK_BRANCH ."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->TUC_DEBIT != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->TUC_EOD_DATE."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->TUC_DEBIT == NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->TUC_EOD_DATE."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";

		$html .= '<table><thead><tr><th style="padding:5px;">CREDIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr></thead><tbody>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$creditTotal->total.'</td><td style="padding:5px;text-align:right;">'.$cCash->cCashTotal.'</td><td style="padding:5px;text-align:right;">'.$cCheque->cChequeTotal.'</td></tr>';
		$html .= '<tr><th style="padding:5px;">DEBIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$debitTotal->total.'</td><td style="padding:5px;text-align:right;">'.$dCash->dCashTotal.'</td><td style="padding:5px;text-align:right;">'.$dCheque->dChequeTotal.'</td></tr>';	
		$html .= '<tr><th style="padding:5px;">BALANCE</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;text-align:right;">'.$balance->balance.'</td><td style="padding:5px;text-align:right;">'.$balanceCash->bCash.'</td><td style="padding:5px;text-align:right;">'.$balanceCheque->bCheque.'</td></tr>';
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Trust EOD Tally Report '.$title.'.pdf','D');
	}
	
	//TRUST EVENT EOD TALLY PDF
	public function create_trustEventEodTallypdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		//FROM DATE AND TO DATE
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDates'])) {
			$fromDates= @$_POST['fromDates'];
			$_SESSION['fromDates'] = $fromDates;
		} else {
			$fromDates = $_SESSION['fromDates'];
		}
		$data['fromDates'] = $fromDates;
		
		if(isset($_POST['toDates'])) {
			$toDates= @$_POST['toDates'];
			$_SESSION['toDates'] = $toDates;
		} else {
			$toDates = $_SESSION['toDates'];
		}
		$data['toDates'] = $toDates;
		
		if(isset($_POST['yCombo'])) {
			$yCombo= @$_POST['yCombo'];
			$_SESSION['yCombo'] = $yCombo;
		} else {
			$yCombo = $_SESSION['yCombo'];
		}
		$data['yCombo'] = $yCombo;
		
		if(isset($_POST['myCombo'])) {
			$myCombo= @$_POST['myCombo'];
			$_SESSION['myCombo'] = $myCombo;
		} else {
			$myCombo = $_SESSION['myCombo'];
		}
		$data['myCombo'] = $myCombo;
		
		if(isset($_POST['mmCombo'])) {
			$mmCombo= @$_POST['mmCombo'];
			$_SESSION['mmCombo'] = $mmCombo;
		} else {
			$mmCombo = $_SESSION['mmCombo'];
		}
		$data['mmCombo'] = $mmCombo;
		
		if($radioOpt == "year") {
			$yr = (explode(" - ",$_POST['yCombo']));
			$fromDate = $yr[0].'-04-01';
			$toDate = ($yr[1]).'-03-31';
			$title = "(".$yCombo.")";
		} else if($radioOpt == "month") {
			$yr = $_POST['myCombo'];
			$mnth = (sprintf("%02d", $_POST['mmCombo']));
			$fromDate = $yr.'-'.$mnth.'-01';
			$toDate = $yr.'-'.$mnth.'-31';
			$dt = DateTime::createFromFormat('!m', $mmCombo);
			$title = "(".$myCombo." - ".$dt->format('F').")";
		} else if($radioOpt == "date") {
			$dOne = (explode("-",$_POST['fromDates']));
			$dTwo = (explode("-",$_POST['toDates']));
			$fromDate = $dOne[2].'-'.$dOne[1].'-'.$dOne[0];
			$toDate = $dTwo[2].'-'.$dTwo[1].'-'.$dTwo[0];
			$title = "(".$fromDates." To ".$toDates.")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>EOD Tally Report ".$title."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Entry Date</th><th style="padding:5px;">Op.Bal.</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Credit</th><th style="padding:5px;">Debit</th><th style="padding:5px;">Balance</th><th style="padding:5px;">Bank</th><th style="padding:5px;">Deposit Date</th><th style="padding:5px;">Eod Date</th></tr></thead><tbody>';
		
		//CREDIT TOTAL
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(TEUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$creditTotal = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(TEUC_CASH) AS TCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH) AS TCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$cCash = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(TEUC_CHEQUE) AS TCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CHEQUE) AS TCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$cCheque = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(TEUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$dCash = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(TEUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$dCheque = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(TEUC_DEBIT) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_DEBIT) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$debitTotal = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(TEUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TEUC_DEBIT),0) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(TEUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TEUC_DEBIT),0) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$balance = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(TEUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TEUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TEUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TEUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."'AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$balanceCash = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM(TEUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TEUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TEUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TEUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."'AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$balanceCheque = $query->first_row();
		
		//BANK
		$this->db->from('TRUST_EVENT_BANK');
		$query = $this->db->get();
		$bank = $query->result();
		
		$conditionOne = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$res = $this->obj_trust_event_eod->get_all_field($fromDate, $toDate);
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".date('d-m-Y',strtotime($res[$i]->TEUC_DATE))."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->OpBal."</td>";			
			
			if($res[$i]->TEUC_CASH != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_CASH."</td>";			
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_CASH_DEPOSIT."</td>";			
			
			if($res[$i]->TEUC_CHEQUE != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_CHEQUE."</td>";		
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_CHEQUE_DEPOSIT."</td>";			
				
			if($res[$i]->TEUC_CASH_CHEQUE != NULL)	
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_CASH_CHEQUE."</td>";
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";		

			if($res[$i]->TEUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_DEBIT ."</td>";		
			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->ClBal ."</td>";	

			if($res[$i]->BANK_NAME != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->ACCOUNT_NO .", ". $res[$i]->BANK_NAME .", ". $res[$i]->BANK_BRANCH ."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->TEUC_DEBIT != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->TEUC_EOD_DATE."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->TEUC_DEBIT == NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->TEUC_EOD_DATE."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";

		$html .= '<table><thead><tr><th style="padding:5px;">CREDIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr></thead><tbody>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$creditTotal->total.'</td><td style="padding:5px;text-align:right;">'.$cCash->cCashTotal.'</td><td style="padding:5px;text-align:right;">'.$cCheque->cChequeTotal.'</td></tr>';
		$html .= '<tr><th style="padding:5px;">DEBIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$debitTotal->total.'</td><td style="padding:5px;text-align:right;">'.$dCash->dCashTotal.'</td><td style="padding:5px;text-align:right;">'.$dCheque->dChequeTotal.'</td></tr>';	
		$html .= '<tr><th style="padding:5px;">BALANCE</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;text-align:right;">'.$balance->balance.'</td><td style="padding:5px;text-align:right;">'.$balanceCash->bCash.'</td><td style="padding:5px;text-align:right;">'.$balanceCheque->bCheque.'</td></tr>';
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('EOD Tally Report '.$title.'.pdf','D');
	}
	
	//EVENT EOD TALLY PDF
	public function create_eventEodTallypdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		//FROM DATE AND TO DATE
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDates'])) {
			$fromDates= @$_POST['fromDates'];
			$_SESSION['fromDates'] = $fromDates;
		} else {
			$fromDates = $_SESSION['fromDates'];
		}
		$data['fromDates'] = $fromDates;
		
		if(isset($_POST['toDates'])) {
			$toDates= @$_POST['toDates'];
			$_SESSION['toDates'] = $toDates;
		} else {
			$toDates = $_SESSION['toDates'];
		}
		$data['toDates'] = $toDates;
		
		if(isset($_POST['yCombo'])) {
			$yCombo= @$_POST['yCombo'];
			$_SESSION['yCombo'] = $yCombo;
		} else {
			$yCombo = $_SESSION['yCombo'];
		}
		$data['yCombo'] = $yCombo;
		
		if(isset($_POST['myCombo'])) {
			$myCombo= @$_POST['myCombo'];
			$_SESSION['myCombo'] = $myCombo;
		} else {
			$myCombo = $_SESSION['myCombo'];
		}
		$data['myCombo'] = $myCombo;
		
		if(isset($_POST['mmCombo'])) {
			$mmCombo= @$_POST['mmCombo'];
			$_SESSION['mmCombo'] = $mmCombo;
		} else {
			$mmCombo = $_SESSION['mmCombo'];
		}
		$data['mmCombo'] = $mmCombo;
		
		if($radioOpt == "year") {
			$yr = (explode(" - ",$_POST['yCombo']));
			$fromDate = $yr[0].'-04-01';
			$toDate = ($yr[1]).'-03-31';
			$title = "(".$yCombo.")";
		} else if($radioOpt == "month") {
			$yr = $_POST['myCombo'];
			$mnth = (sprintf("%02d", $_POST['mmCombo']));
			$fromDate = $yr.'-'.$mnth.'-01';
			$toDate = $yr.'-'.$mnth.'-31';
			$dt = DateTime::createFromFormat('!m', $mmCombo);
			$title = "(".$myCombo." - ".$dt->format('F').")";
		} else if($radioOpt == "date") {
			$dOne = (explode("-",$_POST['fromDates']));
			$dTwo = (explode("-",$_POST['toDates']));
			$fromDate = $dOne[2].'-'.$dOne[1].'-'.$dOne[0];
			$toDate = $dTwo[2].'-'.$dTwo[1].'-'.$dTwo[0];
			$title = "(".$fromDates." To ".$toDates.")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>EOD Tally Report ".$title."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Entry Date</th><th style="padding:5px;">Op.Bal.</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Credit</th><th style="padding:5px;">Debit</th><th style="padding:5px;">Balance</th><th style="padding:5px;">Bank</th><th style="padding:5px;">Deposit Date</th><th style="padding:5px;">Eod Date</th></tr></thead><tbody>';
		
		//CREDIT TOTAL
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(EUC_CASH_CHEQUE) AS TCashCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_CASH_CHEQUE) AS TCashCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$creditTotal = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(EUC_CASH) AS TCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_CASH) AS TCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$cCash = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(EUC_CHEQUE) AS TCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_CHEQUE) AS TCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$cCheque = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(EUC_CASH_DEPOSIT) AS TDebitCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_CASH_DEPOSIT) AS TDebitCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$dCash = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(EUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$dCheque = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(EUC_DEBIT) AS TDebit FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_DEBIT) AS TDebit FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$debitTotal = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(EUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(EUC_DEBIT),0) AS TDebit FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(EUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(EUC_DEBIT),0) AS TDebit FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$balance = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(EUC_CASH),0) AS BalCreditCash, COALESCE(SUM(EUC_CASH_DEPOSIT),0) AS BalDebitCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(EUC_CASH),0) AS BalCreditCash, COALESCE(SUM(EUC_CASH_DEPOSIT),0) AS BalDebitCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."'AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$balanceCash = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM(EUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(EUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(EUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(EUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."'AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$balanceCheque = $query->first_row();
		
		//BANK
		$this->db->from('EVENT_BANK');
		$query = $this->db->get();
		$bank = $query->result();
		
		$conditionOne = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$res = $this->obj_event_eod->get_all_field($fromDate, $toDate);
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".date('d-m-Y',strtotime($res[$i]->EUC_DATE))."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->OpBal."</td>";			
			
			if($res[$i]->EUC_CASH != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_CASH."</td>";			
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_CASH_DEPOSIT."</td>";			
			
			if($res[$i]->EUC_CHEQUE != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_CHEQUE."</td>";		
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_CHEQUE_DEPOSIT."</td>";			
				
			if($res[$i]->EUC_CASH_CHEQUE != NULL)	
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_CASH_CHEQUE."</td>";
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";		

			if($res[$i]->EUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_DEBIT ."</td>";		
			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->ClBal ."</td>";	

			if($res[$i]->BANK_NAME != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->ACCOUNT_NO .", ". $res[$i]->BANK_NAME .", ". $res[$i]->BANK_BRANCH ."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->EUC_DEBIT != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->EUC_EOD_DATE."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->EUC_DEBIT == NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->EUC_EOD_DATE."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";

		$html .= '<table><thead><tr><th style="padding:5px;">CREDIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr></thead><tbody>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$creditTotal->total.'</td><td style="padding:5px;text-align:right;">'.$cCash->cCashTotal.'</td><td style="padding:5px;text-align:right;">'.$cCheque->cChequeTotal.'</td></tr>';
		$html .= '<tr><th style="padding:5px;">DEBIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$debitTotal->total.'</td><td style="padding:5px;text-align:right;">'.$dCash->dCashTotal.'</td><td style="padding:5px;text-align:right;">'.$dCheque->dChequeTotal.'</td></tr>';	
		$html .= '<tr><th style="padding:5px;">BALANCE</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;text-align:right;">'.$balance->balance.'</td><td style="padding:5px;text-align:right;">'.$balanceCash->bCash.'</td><td style="padding:5px;text-align:right;">'.$balanceCheque->bCheque.'</td></tr>';
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('EOD Tally Report '.$title.'.pdf','D');
	}
	
	//EOD TALLY PDF
	public function create_eodTallypdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		//FROM DATE AND TO DATE
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDates'])) {
			$fromDates= @$_POST['fromDates'];
			$_SESSION['fromDates'] = $fromDates;
		} else {
			$fromDates = $_SESSION['fromDates'];
		}
		$data['fromDates'] = $fromDates;
		
		if(isset($_POST['toDates'])) {
			$toDates= @$_POST['toDates'];
			$_SESSION['toDates'] = $toDates;
		} else {
			$toDates = $_SESSION['toDates'];
		}
		$data['toDates'] = $toDates;
		
		if(isset($_POST['yCombo'])) {
			$yCombo= @$_POST['yCombo'];
			$_SESSION['yCombo'] = $yCombo;
		} else {
			$yCombo = $_SESSION['yCombo'];
		}
		$data['yCombo'] = $yCombo;
		
		if(isset($_POST['myCombo'])) {
			$myCombo= @$_POST['myCombo'];
			$_SESSION['myCombo'] = $myCombo;
		} else {
			$myCombo = $_SESSION['myCombo'];
		}
		$data['myCombo'] = $myCombo;
		
		if(isset($_POST['mmCombo'])) {
			$mmCombo= @$_POST['mmCombo'];
			$_SESSION['mmCombo'] = $mmCombo;
		} else {
			$mmCombo = $_SESSION['mmCombo'];
		}
		$data['mmCombo'] = $mmCombo;
		
		if($radioOpt == "year") {
			$yr = (explode(" - ",$_POST['yCombo']));
			$fromDate = $yr[0].'-04-01';
			$toDate = ($yr[1]).'-03-31';
			$title = "(".$yCombo.")";
		} else if($radioOpt == "month") {
			$yr = $_POST['myCombo'];
			$mnth = (sprintf("%02d", $_POST['mmCombo']));
			$fromDate = $yr.'-'.$mnth.'-01';
			$toDate = $yr.'-'.$mnth.'-31';
			$dt = DateTime::createFromFormat('!m', $mmCombo);
			$title = "(".$myCombo." - ".$dt->format('F').")";
		} else if($radioOpt == "date") {
			$dOne = (explode("-",$_POST['fromDates']));
			$dTwo = (explode("-",$_POST['toDates']));
			$fromDate = $dOne[2].'-'.$dOne[1].'-'.$dOne[0];
			$toDate = $dTwo[2].'-'.$dTwo[1].'-'.$dTwo[0];
			$title = "(".$fromDates." To ".$toDates.")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>EOD Tally Report ".$title."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Entry Date</th><th style="padding:5px;">Op.Bal.</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Credit</th><th style="padding:5px;">Debit</th><th style="padding:5px;">Balance</th><th style="padding:5px;">Bank</th><th style="padding:5px;">Deposit Date</th><th style="padding:5px;">Eod Date</th></tr></thead><tbody>';
		
		//CREDIT TOTAL
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(DUC_CASH_CHEQUE) AS TCashCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CASH_CHEQUE) AS TCashCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$creditTotal = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(DUC_DEBIT_CREDIT_CARD) AS TCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_DEBIT_CREDIT_CARD) AS TCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$cCash = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(DUC_CHEQUE) AS TCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CHEQUE) AS TCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$cCheque = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(DUC_CASH_DEPOSIT) AS TDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CASH_DEPOSIT) AS TDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$dCash = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(DUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$dCheque = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(DUC_DEBIT) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_DEBIT) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$debitTotal = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(DUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(DUC_DEBIT),0) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(DUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(DUC_DEBIT),0) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$balance = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(DUC_DEBIT_CREDIT_CARD),0) AS BalCreditCash, COALESCE(SUM(DUC_CASH_DEPOSIT),0) AS BalDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(DUC_DEBIT_CREDIT_CARD),0) AS BalCreditCash, COALESCE(SUM(DUC_CASH_DEPOSIT),0) AS BalDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."'AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$balanceCash = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM( DUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(DUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM( DUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(DUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."'AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$balanceCheque = $query->first_row();
		
		//BANK
		$this->db->from('BANK');
		$query = $this->db->get();
		$bank = $query->result();
		
		$conditionOne = array('RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$res = $this->obj_eod->get_all_field($fromDate, $toDate);
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".date('d-m-Y',strtotime($res[$i]->DUC_DATE))."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->OpBal."</td>";			
			
			if($res[$i]->DUC_DEBIT_CREDIT_CARD != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_DEBIT_CREDIT_CARD."</td>";			
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_CASH_DEPOSIT."</td>";			
			
			if($res[$i]->DUC_CHEQUE != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_CHEQUE."</td>";		
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_CHEQUE_DEPOSIT."</td>";			
				
			if($res[$i]->DUC_CASH_CHEQUE != NULL)	
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_CASH_CHEQUE."</td>";
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";		

			if($res[$i]->DUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_DEBIT ."</td>";		
			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->ClBal ."</td>";	

			if($res[$i]->BANK_NAME != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->ACCOUNT_NO .", ". $res[$i]->BANK_NAME .", ". $res[$i]->BANK_BRANCH ."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->DUC_DEBIT != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->DUC_EOD_DATE."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->DUC_DEBIT == NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->DUC_EOD_DATE."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";

		$html .= '<table><thead><tr><th style="padding:5px;">CREDIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr></thead><tbody>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$creditTotal->total.'</td><td style="padding:5px;text-align:right;">'.$cCash->cCashTotal.'</td><td style="padding:5px;text-align:right;">'.$cCheque->cChequeTotal.'</td></tr>';
		$html .= '<tr><th style="padding:5px;">DEBIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$debitTotal->total.'</td><td style="padding:5px;text-align:right;">'.$dCash->dCashTotal.'</td><td style="padding:5px;text-align:right;">'.$dCheque->dChequeTotal.'</td></tr>';	
		$html .= '<tr><th style="padding:5px;">BALANCE</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;text-align:right;">'.$balance->balance.'</td><td style="padding:5px;text-align:right;">'.$balanceCash->bCash.'</td><td style="padding:5px;text-align:right;">'.$balanceCheque->bCheque.'</td></tr>';
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('EOD Tally Report '.$title.'.pdf','D');
	}

	//FOR TRUST EOD TALLT PRINT
	public function create_trustEodTallySession() { 
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['yCombo'] = @$_POST['yCombo'];
		$_SESSION['myCombo'] = @$_POST['myCombo'];
		$_SESSION['mmCombo'] = @$_POST['mmCombo'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		echo 1;	
	}
	
	//FOR EOD TALLT PRINT
	public function create_eodTallySession() { 
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['yCombo'] = @$_POST['yCombo'];
		$_SESSION['myCombo'] = @$_POST['myCombo'];
		$_SESSION['mmCombo'] = @$_POST['mmCombo'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		echo 1;	
	}
	
	//FOR EVENT EOD TALLT PRINT
	public function create_eventEodTallySession() { 
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['yCombo'] = @$_POST['yCombo'];
		$_SESSION['myCombo'] = @$_POST['myCombo'];
		$_SESSION['mmCombo'] = @$_POST['mmCombo'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		echo 1;	
	}
	
	//FOR TRUST EVENT EOD TALLT PRINT
	public function create_trustEventEodTallySession() { 
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['yCombo'] = @$_POST['yCombo'];
		$_SESSION['myCombo'] = @$_POST['myCombo'];
		$_SESSION['mmCombo'] = @$_POST['mmCombo'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		echo 1;	
	}
	
	//TRUST EOD TALLY PRINT
	public function create_trustEodTallyPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		//FROM DATE AND TO DATE
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDates'])) {
			$fromDates= @$_POST['fromDates'];
			$_SESSION['fromDates'] = $fromDates;
		} else {
			$fromDates = $_SESSION['fromDates'];
		}
		$data['fromDates'] = $fromDates;
		
		if(isset($_POST['toDates'])) {
			$toDates= @$_POST['toDates'];
			$_SESSION['toDates'] = $toDates;
		} else {
			$toDates = $_SESSION['toDates'];
		}
		$data['toDates'] = $toDates;
		
		if(isset($_POST['yCombo'])) {
			$yCombo= @$_POST['yCombo'];
			$_SESSION['yCombo'] = $yCombo;
		} else {
			$yCombo = $_SESSION['yCombo'];
		}
		$data['yCombo'] = $yCombo;
		
		if(isset($_POST['myCombo'])) {
			$myCombo= @$_POST['myCombo'];
			$_SESSION['myCombo'] = $myCombo;
		} else {
			$myCombo = $_SESSION['myCombo'];
		}
		$data['myCombo'] = $myCombo;
		
		if(isset($_POST['mmCombo'])) {
			$mmCombo= @$_POST['mmCombo'];
			$_SESSION['mmCombo'] = $mmCombo;
		} else {
			$mmCombo = $_SESSION['mmCombo'];
		}
		$data['mmCombo'] = $mmCombo;
		
		if($radioOpt == "year") {
			$yr = (explode(" - ",$yCombo));
			$fromDate = $yr[0].'-04-01';
			$toDate = ($yr[1]).'-03-31';
			$title = "(".$yCombo.")";
		} else if($radioOpt == "month") {
			$yr = $_POST['myCombo'];
			$mnth = (sprintf("%02d", $mmCombo));
			$fromDate = $yr.'-'.$mnth.'-01';
			$toDate = $yr.'-'.$mnth.'-31';
			$dt = DateTime::createFromFormat('!m', $mmCombo);
			$title = "(".$myCombo." - ".$dt->format('F').")";
		} else if($radioOpt == "date") {
			$dOne = (explode("-",$fromDates));
			$dTwo = (explode("-",$toDates));
			$fromDate = $dOne[2].'-'.$dOne[1].'-'.$dOne[0];
			$toDate = $dTwo[2].'-'.$dTwo[1].'-'.$dTwo[0];
			$title = "(".$fromDates." To ".$toDates.")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Trust EOD Tally Report ".$title."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Entry Date</th><th style="padding:5px;">Op.Bal.</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Credit</th><th style="padding:5px;">Debit</th><th style="padding:5px;">Balance</th><th style="padding:5px;">Bank</th><th style="padding:5px;">Deposit Date</th><th style="padding:5px;">Eod Date</th></tr></thead><tbody>';
		
		//CREDIT TOTAL
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(TUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$creditTotal = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(TUC_CASH) AS TCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_CASH) AS TCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$cCash = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(TUC_CHEQUE) AS TCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_CHEQUE) AS TCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$cCheque = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(TUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$dCash = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(TUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$dCheque = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(TUC_DEBIT) AS TDebit FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TUC_DEBIT) AS TDebit FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$debitTotal = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(TUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TUC_DEBIT),0) AS TDebit FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(TUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TUC_DEBIT),0) AS TDebit FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."' AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$balance = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(TUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."'AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$balanceCash = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM(TUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_USER_COLLECTION WHERE TUC_DATE >= '".$fromDate."'AND TUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$balanceCheque = $query->first_row();
		
		//BANK
		$this->db->from('TRUST_BANK');
		$query = $this->db->get();
		$bank = $query->result();
		
		$conditionOne = array('ENTERED_BY' => $this->session->userdata('userId'));
		$res = $this->obj_trust_eod->get_all_field($fromDate, $toDate);
		
		unset($_SESSION['radioOpt']);
		unset($_SESSION['yCombo']);
		unset($_SESSION['myCombo']);
		unset($_SESSION['mmCombo']);
		unset($_SESSION['fromDates']);
		unset($_SESSION['toDates']);
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".date('d-m-Y',strtotime($res[$i]->TUC_DATE))."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->OpBal."</td>";			
			
			if($res[$i]->TUC_CASH != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_CASH."</td>";			
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_CASH_DEPOSIT."</td>";			
			
			if($res[$i]->TUC_CHEQUE != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_CHEQUE."</td>";		
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_CHEQUE_DEPOSIT."</td>";			
				
			if($res[$i]->TUC_CASH_CHEQUE != NULL)	
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_CASH_CHEQUE."</td>";
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";		

			if($res[$i]->TUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TUC_DEBIT ."</td>";		
			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->ClBal ."</td>";	

			if($res[$i]->BANK_NAME != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->ACCOUNT_NO .", ". $res[$i]->BANK_NAME .", ". $res[$i]->BANK_BRANCH ."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->TUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;'>".$res[$i]->TUC_EOD_DATE ."</td>";	
			
			if($res[$i]->TUC_DEBIT != NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;'>".$res[$i]->TUC_EOD_DATE ."</td>";	
			
			$html .= '</tr>';
		}
				
		$html .="</tbody></table><br/>";

		$html .= '<table><thead><tr><th style="padding:5px;">CREDIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr></thead><tbody>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$creditTotal->total.'</td><td style="padding:5px;text-align:right;">'.$cCash->cCashTotal.'</td><td style="padding:5px;text-align:right;">'.$cCheque->cChequeTotal.'</td></tr>';	
		$html .= '<tr><th style="padding:5px;">DEBIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$debitTotal->total.'</td><td style="padding:5px;text-align:right;">'.$dCash->dCashTotal.'</td><td style="padding:5px;text-align:right;">'.$dCheque->dChequeTotal.'</td></tr>';
		$html .= '<tr><th style="padding:5px;">BALANCE</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$balance->balance.'</td><td style="padding:5px;text-align:right;">'.$balanceCash->bCash.'</td><td style="padding:5px;text-align:right;">'.$balanceCheque->bCheque.'</td></tr>';
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Trust EOD Tally Report '.$title.'.pdf','I');
	}
	
	//TRUST EVENT EOD TALLY PRINT
	public function create_eodTrustEventTallyPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		//FROM DATE AND TO DATE
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDates'])) {
			$fromDates= @$_POST['fromDates'];
			$_SESSION['fromDates'] = $fromDates;
		} else {
			$fromDates = $_SESSION['fromDates'];
		}
		$data['fromDates'] = $fromDates;
		
		if(isset($_POST['toDates'])) {
			$toDates= @$_POST['toDates'];
			$_SESSION['toDates'] = $toDates;
		} else {
			$toDates = $_SESSION['toDates'];
		}
		$data['toDates'] = $toDates;
		
		if(isset($_POST['yCombo'])) {
			$yCombo= @$_POST['yCombo'];
			$_SESSION['yCombo'] = $yCombo;
		} else {
			$yCombo = $_SESSION['yCombo'];
		}
		$data['yCombo'] = $yCombo;
		
		if(isset($_POST['myCombo'])) {
			$myCombo= @$_POST['myCombo'];
			$_SESSION['myCombo'] = $myCombo;
		} else {
			$myCombo = $_SESSION['myCombo'];
		}
		$data['myCombo'] = $myCombo;
		
		if(isset($_POST['mmCombo'])) {
			$mmCombo= @$_POST['mmCombo'];
			$_SESSION['mmCombo'] = $mmCombo;
		} else {
			$mmCombo = $_SESSION['mmCombo'];
		}
		$data['mmCombo'] = $mmCombo;
		
		if($radioOpt == "year") {
			$yr = (explode(" - ",$yCombo));
			$fromDate = $yr[0].'-04-01';
			$toDate = ($yr[1]).'-03-31';
			$title = "(".$yCombo.")";
		} else if($radioOpt == "month") {
			$yr = $_POST['myCombo'];
			$mnth = (sprintf("%02d", $mmCombo));
			$fromDate = $yr.'-'.$mnth.'-01';
			$toDate = $yr.'-'.$mnth.'-31';
			$dt = DateTime::createFromFormat('!m', $mmCombo);
			$title = "(".$myCombo." - ".$dt->format('F').")";
		} else if($radioOpt == "date") {
			$dOne = (explode("-",$fromDates));
			$dTwo = (explode("-",$toDates));
			$fromDate = $dOne[2].'-'.$dOne[1].'-'.$dOne[0];
			$toDate = $dTwo[2].'-'.$dTwo[1].'-'.$dTwo[0];
			$title = "(".$fromDates." To ".$toDates.")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>EOD Tally Report ".$title."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Entry Date</th><th style="padding:5px;">Op.Bal.</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Credit</th><th style="padding:5px;">Debit</th><th style="padding:5px;">Balance</th><th style="padding:5px;">Bank</th><th style="padding:5px;">Deposit Date</th><th style="padding:5px;">Eod Date</th></tr></thead><tbody>';
		
		//CREDIT TOTAL
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(TEUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH_CHEQUE) AS TCashCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$creditTotal = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(TEUC_CASH) AS TCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH) AS TCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$cCash = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(TEUC_CHEQUE) AS TCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CHEQUE) AS TCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$cCheque = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(TEUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CASH_DEPOSIT) AS TDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$dCash = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(TEUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$dCheque = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(TEUC_DEBIT) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(TEUC_DEBIT) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$debitTotal = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(TEUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TEUC_DEBIT),0) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(TEUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(TEUC_DEBIT),0) AS TDebit FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."' AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$balance = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(TEUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TEUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TEUC_CASH),0) AS BalCreditCash, COALESCE(SUM(TEUC_CASH_DEPOSIT),0) AS BalDebitCash FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."'AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$balanceCash = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM(TEUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TEUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(TEUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(TEUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM TRUST_EVENT_USER_COLLECTION WHERE TEUC_DATE >= '".$fromDate."'AND TEUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$balanceCheque = $query->first_row();
		
		//BANK
		$this->db->from('TRUST_EVENT_BANK');
		$query = $this->db->get();
		$bank = $query->result();
		
		$conditionOne = array('TET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$res = $this->obj_trust_event_eod->get_all_field($fromDate, $toDate);
		
		unset($_SESSION['radioOpt']);
		unset($_SESSION['yCombo']);
		unset($_SESSION['myCombo']);
		unset($_SESSION['mmCombo']);
		unset($_SESSION['fromDates']);
		unset($_SESSION['toDates']);
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".date('d-m-Y',strtotime($res[$i]->TEUC_DATE))."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->OpBal."</td>";			
			
			if($res[$i]->TEUC_CASH != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_CASH."</td>";			
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_CASH_DEPOSIT."</td>";			
			
			if($res[$i]->TEUC_CHEQUE != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_CHEQUE."</td>";		
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_CHEQUE_DEPOSIT."</td>";			
				
			if($res[$i]->TEUC_CASH_CHEQUE != NULL)	
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_CASH_CHEQUE."</td>";
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";		

			if($res[$i]->TEUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TEUC_DEBIT ."</td>";		
			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->ClBal ."</td>";	

			if($res[$i]->BANK_NAME != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->ACCOUNT_NO .", ". $res[$i]->BANK_NAME .", ". $res[$i]->BANK_BRANCH ."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->TEUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;'>".$res[$i]->TEUC_EOD_DATE ."</td>";	
			
			if($res[$i]->TEUC_DEBIT != NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;'>".$res[$i]->TEUC_EOD_DATE ."</td>";	
			
			$html .= '</tr>';
		}
				
		$html .="</tbody></table><br/>";

		$html .= '<table><thead><tr><th style="padding:5px;">CREDIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr></thead><tbody>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$creditTotal->total.'</td><td style="padding:5px;text-align:right;">'.$cCash->cCashTotal.'</td><td style="padding:5px;text-align:right;">'.$cCheque->cChequeTotal.'</td></tr>';	
		$html .= '<tr><th style="padding:5px;">DEBIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$debitTotal->total.'</td><td style="padding:5px;text-align:right;">'.$dCash->dCashTotal.'</td><td style="padding:5px;text-align:right;">'.$dCheque->dChequeTotal.'</td></tr>';
		$html .= '<tr><th style="padding:5px;">BALANCE</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$balance->balance.'</td><td style="padding:5px;text-align:right;">'.$balanceCash->bCash.'</td><td style="padding:5px;text-align:right;">'.$balanceCheque->bCheque.'</td></tr>';
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('EOD Tally Report '.$title.'.pdf','I');
	}
	
	//EVENT EOD TALLY PRINT
	public function create_eodEventTallyPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		//FROM DATE AND TO DATE
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDates'])) {
			$fromDates= @$_POST['fromDates'];
			$_SESSION['fromDates'] = $fromDates;
		} else {
			$fromDates = $_SESSION['fromDates'];
		}
		$data['fromDates'] = $fromDates;
		
		if(isset($_POST['toDates'])) {
			$toDates= @$_POST['toDates'];
			$_SESSION['toDates'] = $toDates;
		} else {
			$toDates = $_SESSION['toDates'];
		}
		$data['toDates'] = $toDates;
		
		if(isset($_POST['yCombo'])) {
			$yCombo= @$_POST['yCombo'];
			$_SESSION['yCombo'] = $yCombo;
		} else {
			$yCombo = $_SESSION['yCombo'];
		}
		$data['yCombo'] = $yCombo;
		
		if(isset($_POST['myCombo'])) {
			$myCombo= @$_POST['myCombo'];
			$_SESSION['myCombo'] = $myCombo;
		} else {
			$myCombo = $_SESSION['myCombo'];
		}
		$data['myCombo'] = $myCombo;
		
		if(isset($_POST['mmCombo'])) {
			$mmCombo= @$_POST['mmCombo'];
			$_SESSION['mmCombo'] = $mmCombo;
		} else {
			$mmCombo = $_SESSION['mmCombo'];
		}
		$data['mmCombo'] = $mmCombo;
		
		if($radioOpt == "year") {
			$yr = (explode(" - ",$yCombo));
			$fromDate = $yr[0].'-04-01';
			$toDate = ($yr[1]).'-03-31';
			$title = "(".$yCombo.")";
		} else if($radioOpt == "month") {
			$yr = $_POST['myCombo'];
			$mnth = (sprintf("%02d", $mmCombo));
			$fromDate = $yr.'-'.$mnth.'-01';
			$toDate = $yr.'-'.$mnth.'-31';
			$dt = DateTime::createFromFormat('!m', $mmCombo);
			$title = "(".$myCombo." - ".$dt->format('F').")";
		} else if($radioOpt == "date") {
			$dOne = (explode("-",$fromDates));
			$dTwo = (explode("-",$toDates));
			$fromDate = $dOne[2].'-'.$dOne[1].'-'.$dOne[0];
			$toDate = $dTwo[2].'-'.$dTwo[1].'-'.$dTwo[0];
			$title = "(".$fromDates." To ".$toDates.")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>EOD Tally Report ".$title."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Entry Date</th><th style="padding:5px;">Op.Bal.</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Credit</th><th style="padding:5px;">Debit</th><th style="padding:5px;">Balance</th><th style="padding:5px;">Bank</th><th style="padding:5px;">Deposit Date</th><th style="padding:5px;">Eod Date</th></tr></thead><tbody>';
		
		//CREDIT TOTAL
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(EUC_CASH_CHEQUE) AS TCashCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_CASH_CHEQUE) AS TCashCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$creditTotal = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(EUC_CASH) AS TCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_CASH) AS TCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$cCash = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(EUC_CHEQUE) AS TCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_CHEQUE) AS TCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$cCheque = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(EUC_CASH_DEPOSIT) AS TDebitCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_CASH_DEPOSIT) AS TDebitCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$dCash = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(EUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$dCheque = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(EUC_DEBIT) AS TDebit FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(EUC_DEBIT) AS TDebit FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$debitTotal = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(EUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(EUC_DEBIT),0) AS TDebit FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(EUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(EUC_DEBIT),0) AS TDebit FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."' AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$balance = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(EUC_CASH),0) AS BalCreditCash, COALESCE(SUM(EUC_CASH_DEPOSIT),0) AS BalDebitCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(EUC_CASH),0) AS BalCreditCash, COALESCE(SUM(EUC_CASH_DEPOSIT),0) AS BalDebitCash FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."'AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$balanceCash = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM(EUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(EUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(EUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(EUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM EVENT_USER_COLLECTION WHERE EUC_DATE >= '".$fromDate."'AND EUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$balanceCheque = $query->first_row();
		
		//BANK
		$this->db->from('EVENT_BANK');
		$query = $this->db->get();
		$bank = $query->result();
		
		$conditionOne = array('ET_RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$res = $this->obj_event_eod->get_all_field($fromDate, $toDate);
		
		unset($_SESSION['radioOpt']);
		unset($_SESSION['yCombo']);
		unset($_SESSION['myCombo']);
		unset($_SESSION['mmCombo']);
		unset($_SESSION['fromDates']);
		unset($_SESSION['toDates']);
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".date('d-m-Y',strtotime($res[$i]->EUC_DATE))."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->OpBal."</td>";			
			
			if($res[$i]->EUC_CASH != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_CASH."</td>";			
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_CASH_DEPOSIT."</td>";			
			
			if($res[$i]->EUC_CHEQUE != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_CHEQUE."</td>";		
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_CHEQUE_DEPOSIT."</td>";			
				
			if($res[$i]->EUC_CASH_CHEQUE != NULL)	
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_CASH_CHEQUE."</td>";
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";		

			if($res[$i]->EUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->EUC_DEBIT ."</td>";		
			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->ClBal ."</td>";	

			if($res[$i]->BANK_NAME != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->ACCOUNT_NO .", ". $res[$i]->BANK_NAME .", ". $res[$i]->BANK_BRANCH ."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->EUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;'>".$res[$i]->EUC_EOD_DATE ."</td>";	
			
			if($res[$i]->EUC_DEBIT != NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;'>".$res[$i]->EUC_EOD_DATE ."</td>";	
			
			$html .= '</tr>';
		}
				
		$html .="</tbody></table><br/>";

		$html .= '<table><thead><tr><th style="padding:5px;">CREDIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr></thead><tbody>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$creditTotal->total.'</td><td style="padding:5px;text-align:right;">'.$cCash->cCashTotal.'</td><td style="padding:5px;text-align:right;">'.$cCheque->cChequeTotal.'</td></tr>';	
		$html .= '<tr><th style="padding:5px;">DEBIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$debitTotal->total.'</td><td style="padding:5px;text-align:right;">'.$dCash->dCashTotal.'</td><td style="padding:5px;text-align:right;">'.$dCheque->dChequeTotal.'</td></tr>';
		$html .= '<tr><th style="padding:5px;">BALANCE</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$balance->balance.'</td><td style="padding:5px;text-align:right;">'.$balanceCash->bCash.'</td><td style="padding:5px;text-align:right;">'.$balanceCheque->bCheque.'</td></tr>';
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('EOD Tally Report '.$title.'.pdf','I');
	}
	
	//EOD TALLY PRINT
	public function create_eodTallyPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		//FROM DATE AND TO DATE
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
			$_SESSION['radioOpt'] = $radioOpt;
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		$data['radioOpt'] = $radioOpt;
		
		if(isset($_POST['fromDates'])) {
			$fromDates= @$_POST['fromDates'];
			$_SESSION['fromDates'] = $fromDates;
		} else {
			$fromDates = $_SESSION['fromDates'];
		}
		$data['fromDates'] = $fromDates;
		
		if(isset($_POST['toDates'])) {
			$toDates= @$_POST['toDates'];
			$_SESSION['toDates'] = $toDates;
		} else {
			$toDates = $_SESSION['toDates'];
		}
		$data['toDates'] = $toDates;
		
		if(isset($_POST['yCombo'])) {
			$yCombo= @$_POST['yCombo'];
			$_SESSION['yCombo'] = $yCombo;
		} else {
			$yCombo = $_SESSION['yCombo'];
		}
		$data['yCombo'] = $yCombo;
		
		if(isset($_POST['myCombo'])) {
			$myCombo= @$_POST['myCombo'];
			$_SESSION['myCombo'] = $myCombo;
		} else {
			$myCombo = $_SESSION['myCombo'];
		}
		$data['myCombo'] = $myCombo;
		
		if(isset($_POST['mmCombo'])) {
			$mmCombo= @$_POST['mmCombo'];
			$_SESSION['mmCombo'] = $mmCombo;
		} else {
			$mmCombo = $_SESSION['mmCombo'];
		}
		$data['mmCombo'] = $mmCombo;
		
		if($radioOpt == "year") {
			$yr = (explode(" - ",$yCombo));
			$fromDate = $yr[0].'-04-01';
			$toDate = ($yr[1]).'-03-31';
			$title = "(".$yCombo.")";
		} else if($radioOpt == "month") {
			$yr = $_POST['myCombo'];
			$mnth = (sprintf("%02d", $mmCombo));
			$fromDate = $yr.'-'.$mnth.'-01';
			$toDate = $yr.'-'.$mnth.'-31';
			$dt = DateTime::createFromFormat('!m', $mmCombo);
			$title = "(".$myCombo." - ".$dt->format('F').")";
		} else if($radioOpt == "date") {
			$dOne = (explode("-",$fromDates));
			$dTwo = (explode("-",$toDates));
			$fromDate = $dOne[2].'-'.$dOne[1].'-'.$dOne[0];
			$toDate = $dTwo[2].'-'.$dTwo[1].'-'.$dTwo[0];
			$title = "(".$fromDates." To ".$toDates.")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>EOD Tally Report ".$title."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Entry Date</th><th style="padding:5px;">Op.Bal.</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Credit</th><th style="padding:5px;">Debit</th><th style="padding:5px;">Balance</th><th style="padding:5px;">Bank</th><th style="padding:5px;">Deposit Date</th><th style="padding:5px;">Eod Date</th></tr></thead><tbody>';
		
		//CREDIT TOTAL
		$creditStatement = "SUM(TCashCheque) as total FROM (SELECT SUM(DUC_CASH_CHEQUE) AS TCashCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CASH_CHEQUE) AS TCashCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($creditStatement);
		$query = $this->db->get();
		$creditTotal = $query->first_row();
		
		//CREDIT CASH
		$creditCashStatement = "SUM(TCash) as cCashTotal FROM (SELECT SUM(DUC_DEBIT_CREDIT_CARD) AS TCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_DEBIT_CREDIT_CARD) AS TCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($creditCashStatement);
		$query = $this->db->get();
		$cCash = $query->first_row();
		
		//CREDIT CHEQUE
		$creditChequeStatement = "SUM(TCheque) as cChequeTotal FROM (SELECT SUM(DUC_CHEQUE) AS TCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CHEQUE) AS TCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($creditChequeStatement);
		$query = $this->db->get();
		$cCheque = $query->first_row();
		
		//DEPOSIT CASH
		$debitCashStatement = "SUM(TDebitCash) as dCashTotal FROM (SELECT SUM(DUC_CASH_DEPOSIT) AS TDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CASH_DEPOSIT) AS TDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($debitCashStatement);
		$query = $this->db->get();
		$dCash = $query->first_row();
		
		//DEPOSIT CHEQUE
		$debitChequeStatement = "SUM(TDebitCheque) as dChequeTotal FROM (SELECT SUM(DUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_CHEQUE_DEPOSIT) AS TDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($debitChequeStatement);
		$query = $this->db->get();
		$dCheque = $query->first_row();
		
		//DEBIT TOTAL
		$debitStatement = "SUM(TDebit) as total FROM (SELECT SUM(DUC_DEBIT) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT SUM(DUC_DEBIT) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($debitStatement);
		$query = $this->db->get();
		$debitTotal = $query->first_row();

		//BALANCE
		$balance = "(SUM(TCashCheque) - SUM(TDebit)) AS balance FROM (SELECT COALESCE(SUM(DUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(DUC_DEBIT),0) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."'UNION ALL SELECT COALESCE(SUM(DUC_CASH_CHEQUE),0) AS TCashCheque, COALESCE(SUM(DUC_DEBIT),0) AS TDebit FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."' AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($balance);
		$query = $this->db->get();
		$balance = $query->first_row();

		//BALANCE CASH
		$balanceCash = "(SUM(BalCreditCash) - SUM(BalDebitCash)) as bCash FROM (SELECT COALESCE(SUM(DUC_DEBIT_CREDIT_CARD),0) AS BalCreditCash, COALESCE(SUM(DUC_CASH_DEPOSIT),0) AS BalDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM(DUC_DEBIT_CREDIT_CARD),0) AS BalCreditCash, COALESCE(SUM(DUC_CASH_DEPOSIT),0) AS BalDebitCash FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."'AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCash);
		$query = $this->db->get();
		$balanceCash = $query->first_row();
		
		//BALANCE CHEQUE
		$balanceCheque = "(SUM(BalCreditCheque) - SUM(BalDebitCheque)) as bCheque FROM (SELECT COALESCE(SUM( DUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(DUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE < '".$fromDate."' UNION ALL SELECT COALESCE(SUM( DUC_CHEQUE),0) AS BalCreditCheque, COALESCE(SUM(DUC_CHEQUE_DEPOSIT),0) AS BalDebitCheque FROM DEITY_USER_COLLECTION WHERE DUC_DATE >= '".$fromDate."'AND DUC_DATE <= '".$toDate."')a";
		$this->db->select($balanceCheque);
		$query = $this->db->get();
		$balanceCheque = $query->first_row();
		
		//BANK
		$this->db->from('BANK');
		$query = $this->db->get();
		$bank = $query->result();
		
		$conditionOne = array('RECEIPT_ISSUED_BY_ID' => $this->session->userdata('userId'));
		$res = $this->obj_eod->get_all_field($fromDate, $toDate);
		
		unset($_SESSION['radioOpt']);
		unset($_SESSION['yCombo']);
		unset($_SESSION['myCombo']);
		unset($_SESSION['mmCombo']);
		unset($_SESSION['fromDates']);
		unset($_SESSION['toDates']);
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".date('d-m-Y',strtotime($res[$i]->DUC_DATE))."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->OpBal."</td>";			
			
			if($res[$i]->DUC_DEBIT_CREDIT_CARD != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_DEBIT_CREDIT_CARD."</td>";			
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_CASH_DEPOSIT."</td>";			
			
			if($res[$i]->DUC_CHEQUE != NULL)
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_CHEQUE."</td>";		
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_CHEQUE_DEPOSIT."</td>";			
				
			if($res[$i]->DUC_CASH_CHEQUE != NULL)	
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_CASH_CHEQUE."</td>";
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";		

			if($res[$i]->DUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->DUC_DEBIT ."</td>";		
			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->ClBal ."</td>";	

			if($res[$i]->BANK_NAME != NULL)
				$html .= "<td style='padding:5px;'>".$res[$i]->ACCOUNT_NO .", ". $res[$i]->BANK_NAME .", ". $res[$i]->BANK_BRANCH ."</td>";		
			else
				$html .= "<td style='padding:5px;'><center> - </center></td>";	
			
			if($res[$i]->DUC_DEBIT == NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;'>".$res[$i]->DUC_EOD_DATE ."</td>";	
			
			if($res[$i]->DUC_DEBIT != NULL)	
				$html .= "<td style='padding:5px;'><center> - </center></td>";
			else
				$html .= "<td style='padding:5px;'>".$res[$i]->DUC_EOD_DATE ."</td>";	
			
			$html .= '</tr>';
		}
				
		$html .="</tbody></table><br/>";

		$html .= '<table><thead><tr><th style="padding:5px;">CREDIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr></thead><tbody>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$creditTotal->total.'</td><td style="padding:5px;text-align:right;">'.$cCash->cCashTotal.'</td><td style="padding:5px;text-align:right;">'.$cCheque->cChequeTotal.'</td></tr>';	
		$html .= '<tr><th style="padding:5px;">DEBIT</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$debitTotal->total.'</td><td style="padding:5px;text-align:right;">'.$dCash->dCashTotal.'</td><td style="padding:5px;text-align:right;">'.$dCheque->dChequeTotal.'</td></tr>';
		$html .= '<tr><th style="padding:5px;">BALANCE</th><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th></tr>';
		$html .= '<tr><td style="padding:5px;text-align:right;">'.$balance->balance.'</td><td style="padding:5px;text-align:right;">'.$balanceCash->bCash.'</td><td style="padding:5px;text-align:right;">'.$balanceCheque->bCheque.'</td></tr>';
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('EOD Tally Report '.$title.'.pdf','I');
	}
	
	//FOR SEVAS SUMMARY DETAILS PRINT
	public function create_SevasSummaryDetailsPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
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
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_sevas_summary_details_period_excel($fromDate,$toDate,$sevaId,$summaryCondition);
		} else {
			$res = $this->obj_report->get_all_field_sevas_summary_details_excel($date,$sevaId,$summaryCondition);
		}
		
		//unset($_SESSION['dateField']);
		//unset($_SESSION['radioOpt']);
		//unset($_SESSION['fromDates']);
		//unset($_SESSION['toDates']);
		//unset($_SESSION['sevaId']);
		//unset($_SESSION['sevaName']);
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Deity ".$typeVal." Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= "<center><strong>Deity - ".$sevaName."</strong></center><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">RECEIPT NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE NO.</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		$j = 1;$Count = 0;$Amount=0;
		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]['SB_ACTIVE'] != "0") {
				$html .= '<tr>';    
				$html .= "<td style='padding:5px;'>".$j."</td>";
				if(($res[$i]['SO_IS_BOOKING'] == 0) && ($res[$i]['RECEIPT_ID'] != 0)) {
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NO']."</td>";			
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NAME']."</td>";		
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_PHONE']."</td>";		
					$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['SO_PRICE']."</td>";	
				} else if(($res[$i]['SO_IS_BOOKING'] == 1) && ($res[$i]['RECEIPT_ID'] != 0)) {
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NO']."</td>";			
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NAME']."</td>";			
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_PHONE']."</td>";		
					$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['SO_PRICE']."</td>";	
				} else {
					$html .= "<td style='padding:5px;'>".$res[$i]['SB_NO']."</td>";			
					$html .= "<td style='padding:5px;'>".$res[$i]['SB_NAME']."</td>";			
					$html .= "<td style='padding:5px;'>".$res[$i]['SB_PHONE']."</td>";		
					$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['SO_PRICE']."</td>";	
				}			
				$html .= '</tr>';
				$Count ++;
				$Amount += $res[$i]['SO_PRICE'];
				$j++;
			}
		}
		$html .="</tbody></table>";
		$html .= "<h4 style='text-align:right'>Total Amount:".$Amount."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Sevas:".$Count."</h4>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Sevas Summary Details Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Sevas Summary Details Report ('.$_POST['dateField'].').pdf','I');
	}
	
	//FOR EVENT SEVAS SUMMARY DETAILS PRINT
	public function create_eventSevasSummaryDetailsPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_event_sevas_summary_details_period_excel($fromDate,$toDate,$sevaId,$eId);
		} else {
			$res = $this->obj_report->get_all_field_event_sevas_summary_details_excel($date,$sevaId,$eId);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Event Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= "<center><strong>".$sevaName."</strong></center><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">RECEIPT NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE NO.</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
				$html .= '<tr>';    
				$html .= "<td style='padding:5px;'>".$j."</td>";
				$html .= "<td style='padding:5px;'>".$res[$i]['ET_RECEIPT_NO']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['ET_RECEIPT_NAME']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['ET_RECEIPT_PHONE']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['ET_SO_PRICE']."</td>";
				$html .= '</tr>';
				$j++;
		}
		$html .="</tbody></table>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Event Sevas Summary Details Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Event Sevas Summary Details Report ('.$_POST['dateField'].').pdf','I');
	}
	
	
	//FOR EVENT SEVAS SUMMARY DETAILS PRINT
	public function create_trusteventSevasSummaryDetailsPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		$this->db->select('*')->from('trust_event');
		$this->db->where('TET_ACTIVE',1);
		$query = $this->db->get();
		$etId= $query->result('array');
		$eId = $etId[0]['TET_ID'];
			
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_trust_report->get_all_field_event_sevas_summary_details_period_excel($fromDate,$toDate,$sevaId,$eId);
		} else {
			$res = $this->obj_trust_report->get_all_field_event_sevas_summary_details_excel($date,$sevaId,$eId);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Event Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= "<center><strong>".$sevaName."</strong></center><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">RECEIPT NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE NO.</th><th style="padding:5px;">Quantity</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
				$html .= '<tr>';    
				$html .= "<td style='padding:5px;'>".$j."</td>";
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_RECEIPT_NO']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_RECEIPT_NAME']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_RECEIPT_PHONE']."</td>";
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_SO_QUANTITY']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_SO_PRICE'] *  $res[$i]['TET_SO_QUANTITY']."</td>";
				$html .= '</tr>';
				$j++;
		}
		$html .="</tbody></table>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Event Sevas Summary Details Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Event Sevas Summary Details Report ('.$_POST['dateField'].').pdf','I');
	}
	
	
	//FOR SEVAS SUMMARY PRINT
	public function create_SevasSummaryReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
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
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_sevas_summary_report_period($fromDate,$toDate,$deityId,$summaryCondition);
		} else {
			$res = $this->obj_report->get_all_field_sevas_summary($date,$deityId,$summaryCondition);
		}
		
		//unset($_SESSION['dateField']);
		//unset($_SESSION['radioOpt']);
		//unset($_SESSION['fromDates']);
		//unset($_SESSION['toDates']);
		//unset($_SESSION['deityId']);
		//unset($_SESSION['deityName']);
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Deity ".$typeVal." Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= "<center><strong>Deity - ".$deityName."</strong></center><br/>";
		$html .= '<table width="100%"><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVAS NAME</th><th style="padding:5px;">QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		$j = 1;$Count = 0;$Amount=0;
		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]['SB_ACTIVE'] != "0") {
				$html .= '<tr>';    
				$html .= "<td style='padding:5px;'>".$j."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['SO_SEVA_NAME']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['QTY']."</td>";			
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['AMOUNT']."</td>";		
				$html .= '</tr>';
				$Count += $res[$i]['QTY'];
				$Amount += $res[$i]['AMOUNT'];
				$j++;
			}
		}
		
		$html .="</tbody></table>";
		$html .= "<h4 style='text-align:right'>Total Amount:".$Amount."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Sevas:".$Count."</h4>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Sevas Summary Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Sevas Summary Report ('.$_POST['dateField'].').pdf','I');
	}
	
	//FOR DEITY SEVA SUMMARY Print
	public function create_deitySevaSummaryReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
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
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_deity_seva_summary_report_period($fromDate,$toDate,$summaryCondition);
		} else {
			$res = $this->obj_report->get_all_field_deity_seva_summary_report($date,$summaryCondition);
		}
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Deity ".$typeVal." Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table  width="100%"><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">DEITY NAME</th><th style="padding:5px;">SEVAS QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		$j = 1;$Count = 0;$Amount=0;
		for($i = 0; $i < sizeof($res); $i++) 
		{
			if($res[$i]['SB_ACTIVE'] != "0") {
				$html .= '<tr>';    
				$html .= "<td style='padding:5px;'>".$j."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['DEITY_NAME']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['QTY']."</td>";			
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['AMOUNT']."</td>";		
				$html .= '</tr>';
				$Count += $res[$i]['QTY'];
				$Amount += $res[$i]['AMOUNT'];
				$j++;
			}
		}
		
		$html .="</tbody></table>";
		$html .= "<h4 style='text-align:right'>Total Amount:".$Amount."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Sevas:".$Count."</h4>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Deity Sevas Summary Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Deity Sevas Summary Report ('.$_POST['dateField'].').pdf','I');
	}
	

	//FOR PAYMENT Print
	public function create_PaymentPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
			
		$aid = $_SESSION['aidP'];
		$lidP = str_replace("\'","'",$_SESSION['lidP']);
		$countNoP = $_SESSION['countNoP'];
		$transactionDate = $_SESSION['transactionDate'];
		$favouring = $_SESSION['favouring'];
		$naration = $_SESSION['naration'];
		$paymentmethod = $_SESSION['paymentmethod'];
		$chequeDate = $_SESSION['chequeDate'];
		$chkno = $_SESSION['chkno'];
		$bankName = str_replace("\'","'",$_SESSION['bankName']);
		$branchName = str_replace("\'","'",$_SESSION['branchName']);
		$amtsP = $_SESSION['amtsP'];
		$rupee = explode('.',$amtsP);
		$amtInWord = $this->financeAmountInWords($amtsP);   
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:11px;margin-bottom:.3em;text-align:center;'><strong>|| Sri Lakshmi Venkatesh Prasanna ||</strong></center>";
		$html .= "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$html .= "<center style='font-size:14px;margin-bottom:.3em;text-align:center;'>V.T. Road , Thenkapete - Udupi</center>";  
		//$html .= "<table><tbody><tr><td>Number : </td><td><div style='font-size:10px;float:right'>Date: ".$today."</div></td></tr>" ;
		$html .= "<div style='padding-top:30px;'><span style='font-weight:600;font-size:15px;'><b>Voucher Number :  </b>".$countNoP."</span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span style='text-align: right;'><b>Date:</b>&nbsp;".$transactionDate."</span></div><br>";
		$html .= "<div><b>To Account :  </b>".$lidP."</div><br>";
		$html .= "<div><b>Favouring To :  </b>".$favouring."</div><br>";
		$html .= "<div><b>Purpose :  </b>".$naration."</div><br>";

		$html .= "<div><span style='padding_left:100px;padding_right:100px;'><b>Rs.  </b>".$rupee[0]."</span>";
		if($rupee[1])
			$html .="<span style='width:100px;'>&emsp;<b>Ps.  </b>".$rupee[1]."</span>";
		$html .="<span>&emsp;<b>Rupees:  </b>".$amtInWord."</span></div><br>";
		if($paymentmethod == "Cheque")
			$html .= "<div><b>Cheque Number :  </b>".$chkno."&emsp;<b>Cheque Date :  </b>".$chequeDate."&emsp;<b>Bank :  </b>".$bankName."&nbsp;".$branchName."</div><br>";

		$html .="<div style='top:45%;position: fixed;'><span style='font-weight:600;font-size:14px;'>Managing Trustee: ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Manager :  ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recipient Signature : ________________</span></div>";
		


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		// $pdf->AddPage('P','A4',0);
		
		
		$pdf->WriteHTML($stylesheet,1);
		
		$pdf->AddPage('P', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            10, // margin bottom
		            12, // margin header
		            12);
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Finance Payment ('.$countNoP.').pdf','I');
	}
	// added by adithya on 28-12-23 start
	public function create_TrustPaymentPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
			
		$aid = $_SESSION['aidP'];
		$lidP = str_replace("\'","'",$_SESSION['lidP']);
		$countNoP = $_SESSION['countNoP'];
		$transactionDate = $_SESSION['transactionDate'];
		$favouring = $_SESSION['favouring'];
		$naration = $_SESSION['naration'];
		$paymentmethod = $_SESSION['paymentmethod'];
		$chequeDate = $_SESSION['chequeDate'];
		$chkno = $_SESSION['chkno'];
		$bankName = str_replace("\'","'",$_SESSION['bankName']);
		$branchName = str_replace("\'","'",$_SESSION['branchName']);
		$amtsP = $_SESSION['amtsP'];
		$rupee = explode('.',$amtsP);
		$amtInWord = $this->financeAmountInWords($amtsP);   
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:11px;margin-bottom:.3em;text-align:center;'><strong>|| Sri Lakshmi Venkatesh Prasanna ||</strong></center>";
		$html .= "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$html .= "<center style='font-size:14px;margin-bottom:.3em;text-align:center;'>V.T. Road , Thenkapete - Udupi</center>";  
		//$html .= "<table><tbody><tr><td>Number : </td><td><div style='font-size:10px;float:right'>Date: ".$today."</div></td></tr>" ;
		$html .= "<div style='padding-top:30px;'><span style='font-weight:600;font-size:15px;'><b>Voucher Number :  </b>".$countNoP."</span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span style='text-align: right;'><b>Date:</b>&nbsp;".$transactionDate."</span></div><br>";
		$html .= "<div><b>To Account :  </b>".$lidP."</div><br>";
		$html .= "<div><b>Favouring To :  </b>".$favouring."</div><br>";
		$html .= "<div><b>Purpose :  </b>".$naration."</div><br>";

		$html .= "<div><span style='padding_left:100px;padding_right:100px;'><b>Rs.  </b>".$rupee[0]."</span>";
		if($rupee[1])
			$html .="<span style='width:100px;'>&emsp;<b>Ps.  </b>".$rupee[1]."</span>";
		$html .="<span>&emsp;<b>Rupees:  </b>".$amtInWord."</span></div><br>";
		if($paymentmethod == "Cheque")
			$html .= "<div><b>Cheque Number :  </b>".$chkno."&emsp;<b>Cheque Date :  </b>".$chequeDate."&emsp;<b>Bank :  </b>".$bankName."&nbsp;".$branchName."</div><br>";

		$html .="<div style='top:45%;position: fixed;'><span style='font-weight:600;font-size:14px;'>Managing Trustee: ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Manager :  ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recipient Signature : ________________</span></div>";
		


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		// $pdf->AddPage('P','A4',0);
		
		
		$pdf->WriteHTML($stylesheet,1);
		
		$pdf->AddPage('P', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            10, // margin bottom
		            12, // margin header
		            12);
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Finance Payment ('.$countNoP.').pdf','I');
	}

// added bty adithya on 28-12-23 end
	//FOR CONTRA Print
	public function create_ContraPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
			
		$aidC = $_SESSION['aidC'];
		$acidC = str_replace("\'","'",$_SESSION['acidC']);
		$countNoC = $_SESSION['countNoC'];
		$transactionDate = $_SESSION['transactionDate'];
		$favouring = $_SESSION['favouring'];
		$committeeSelectedName = $_SESSION['committeeSelectedName'];
		$naration = $_SESSION['naration'];
		$paymentmethod = $_SESSION['paymentmethod'];
		$chequeDate = $_SESSION['chequeDate'];
		$chkno = $_SESSION['chkno'];
		// $bankmm = str_replace("'","\'",$bankName);
		$bankName = str_replace("\'","'",$_SESSION['bankName']);
		$branchName = str_replace("\'","'",$_SESSION['branchName']);
		$amtsC = $_SESSION['amtsC'];
		$rupee = explode('.',$amtsC);
		$amtInWord = $this->financeAmountInWords($amtsC);   
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:11px;margin-bottom:.3em;text-align:center;'><strong>|| Sri Lakshmi Venkatesh Prasanna ||</strong></center>";
		$html .= "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$html .= "<center style='font-size:14px;margin-bottom:.3em;text-align:center;'>V.T. Road , Thenkapete - Udupi</center>";  
		//$html .= "<table><tbody><tr><td>Number : </td><td><div style='font-size:10px;float:right'>Date: ".$today."</div></td></tr>" ;
		$html .= "<div style='padding-top:30px;'><span style='font-weight:600;font-size:15px;'><b>Voucher Number :  </b>".$countNoC."</span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span style='text-align: right;'><b>Date:</b>&nbsp;".$transactionDate."</span></div><br>";
		$html .= "<div><b>Account :  </b>".$acidC."</div><br>";
		$html .= "<div><b>Favouring To :  </b>".$favouring."</div><br>";
		$html .= "<div><b>Committee :  </b>".$committeeSelectedName."</div><br>";
		$html .= "<div><b>Purpose :  </b>".$naration."</div><br>";

		$html .= "<div><span style='padding_left:100px;padding_right:100px;'><b>Rs.  </b>".$rupee[0]."</span>";
		if($rupee[1])
			$html .="<span style='width:100px;'>&emsp;<b>Ps.  </b>".$rupee[1]."</span>";
		$html .="<span>&emsp;<b>Rupees:  </b>".$amtInWord."</span></div><br>";
		if($paymentmethod == "Cheque")
			$html .= "<div><b>Cheque Number :  </b>".$chkno."&emsp;<b>Cheque Date :  </b>".$chequeDate."&emsp;<b>Bank :  </b>".$bankName."&nbsp;".$branchName."</div><br>";

		$html .="<div style='top:45%;position: fixed;'><span style='font-weight:600;font-size:14px;'>Managing Trustee: ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Manager :  ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recipient Signature : ________________</span></div>";
		


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		// $pdf->AddPage('P','A4',0);
		
		
		$pdf->WriteHTML($stylesheet,1);
		
		$pdf->AddPage('P', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            10, // margin bottom
		            12, // margin header
		            12);
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Finance Contra Print ('.$countNoC.').pdf','I');
	}

	public function create_JournalPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
			
		$type = $_SESSION['type'];
		$ledgers = $_SESSION['ledgers'];
		$countNoJ = $_SESSION['countNoJ'];
		$todayDate = $_SESSION['todayDate'];
		$favouring = $_SESSION['favouring'];
		$committeeSelectedName = $_SESSION['committeeSelectedName'];
		$naration = $_SESSION['naration'];
		$toLedgerName = $_SESSION['toLedgerName'];
		$amount = $_SESSION['amount'];
		$floatAmt = array_map('floatval', json_decode($amount, true));
		$totAmt = (array_sum($floatAmt)/2);
		$rupee = explode('.',$totAmt);
		$amtInWord = $this->financeAmountInWords($totAmt);   
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:11px;margin-bottom:.3em;text-align:center;'><strong>|| Sri Lakshmi Venkatesh Prasanna ||</strong></center>";
		$html .= "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$html .= "<center style='font-size:14px;margin-bottom:.3em;text-align:center;'>V.T. Road , Thenkapete - Udupi</center>";  
		//$html .= "<table><tbody><tr><td>Number : </td><td><div style='font-size:10px;float:right'>Date: ".$today."</div></td></tr>" ;
		$html .= "<div style='padding-top:30px;'><span style='font-weight:600;font-size:15px;'><b>Voucher Number :  </b>".$countNoJ."</span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span style='text-align: right;'><b>Date:</b>&nbsp;".$todayDate."</span></div><br>";
		$html .= "<div><b>Account :  </b>".$toLedgerName."</div><br>";
		$html .= "<div><b>Committee :  </b>".$committeeSelectedName."</div><br>";
		$html .= "<div><b>Purpose :  </b>".$naration."</div><br>";

		$html .= "<div><span style='padding_left:100px;padding_right:100px;'><b>Rs.  </b>".$rupee[0]."</span>";
		if($rupee[1])
			$html .="<span style='width:100px;'>&emsp;<b>Ps.  </b>".$rupee[1]."</span>";
		$html .="<span>&emsp;<b>Rupees:  </b>".$amtInWord."</span></div><br>";
		
		$html .="<div style='top:45%;position: fixed;'><span style='font-weight:600;font-size:14px;'>Managing Trustee: ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Manager :  ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recipient Signature : ________________</span></div>";
		


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		// $pdf->AddPage('P','A4',0);
		
		
		$pdf->WriteHTML($stylesheet,1);
		
		$pdf->AddPage('P', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            10, // margin bottom
		            12, // margin header
		            12);
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Finance Journal Print ('.$countNoJ.').pdf','I');
	}

	public function financeAmountInWords(float $amount) {
	   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
	   // Check if there is any number after decimal
	   $amt_hundred = null;
	   $count_length = strlen($num);
	   $x = 0;
	   $string = array();
	   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
	     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
	     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
	     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
	     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
	     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
	     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
	     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
	     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
	    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
	    while( $x < $count_length ) {
	      $get_divider = ($x == 2) ? 10 : 100;
	      $amount = floor($num % $get_divider);
	      $num = floor($num / $get_divider);
	      $x += $get_divider == 10 ? 1 : 2;
	      if ($amount) {
	       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
	       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
	       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
	        }
	   else $string[] = null;
	   }
	   $implode_to_Rupees = implode('', array_reverse($string));
	   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " " . $change_words[$amount_after_decimal % 10]) . ' Paise Only' : '';
	   // return ($implode_to_Rupees ?  $implode_to_Rupees . 'Rupees Only' : '') ;
	    if($implode_to_Rupees )
	   {
	   	if($get_paise)
	   		return ($implode_to_Rupees . 'Rupees '.$get_paise) ;
	   	else
	   		return ($implode_to_Rupees . 'Rupees Only') ;
	   }
	}
	
	
	
	//FOR EVENT SEVA SUMMARY Print
	public function create_eventSevaSummaryReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_event_sevas_summary_report_period($fromDate,$toDate,$eId);
		} else {
			$res = $this->obj_report->get_all_field_event_sevas_summary($date,$eId);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Event Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">EVENT SEVA NAME</th><th style="padding:5px;">SEVAS QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++) 
		{
				$html .= '<tr>';    
				$html .= "<td style='padding:5px;'>".$j."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['ET_SO_SEVA_NAME']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['QTY']."</td>";			
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['AMOUNT']."</td>";		
				$html .= '</tr>';
				$j++;
		}
		
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Event Sevas Summary Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Event Sevas Summary Report ('.$_POST['dateField'].').pdf','I');
	}
	
	
	
	//FOR TRUST EVENT SEVA SUMMARY Print
	public function create_trusteventSevaSummaryReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		$this->db->select('*')->from('trust_event');
		$this->db->where('TET_ACTIVE',1);
		$query = $this->db->get();
		$etId= $query->result('array');
		$eId = $etId[0]['TET_ID'];
		
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_trust_report->get_all_field_event_sevas_summary_report_period($fromDate,$toDate,$eId);
		} else {
			$res = $this->obj_trust_report->get_all_field_event_sevas_summary($date,$eId);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Trust Event Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">EVENT SEVA NAME</th><th style="padding:5px;">SEVAS QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++) 
		{
				$html .= '<tr>';    
				$html .= "<td style='padding:5px;'>".$j."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_SO_SEVA_NAME']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['QTY']."</td>";			
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['AMOUNT']."</td>";		
				$html .= '</tr>';
				$j++;
		}
		
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Trust Event Sevas Summary Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Trust Event Sevas Summary Report ('.$_POST['dateField'].').pdf','I');
	}
	
	//FOR DEITY SEVA PRINT
	public function create_deitySevaReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		
		if(isset($_POST['radioAllOpt'])) {
			$radioAllOpt = @$_POST['radioAllOpt'];
		} else {
			$radioAllOpt = $_SESSION['radioAllOpt'];
		}

		if(isset($_POST['allDates'])) {
			$allDates= @$_POST['allDates'];
		} else {
			$allDates = $_SESSION['allDates'];
		}

		if($_SESSION['sevaExcludeOrInclude']=="Exclude") {
			$excludeIncludeCondition = " deity_seva.SEVA_INCL_EXCL != 'Exclude' ";
		} else {
			$excludeIncludeCondition ="";
		}

		if(@$radioAllOpt == "allDeity" || @$radioAllOpt == "" ) {
			if(@$radioOpt == "multiDate"){
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				$bookQueryString = "";
						$queryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
						$bookQueryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE = 1";
				$condition = $queryString;
				$bookCondition = $bookQueryString;
				$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookQueryString,$excludeIncludeCondition); // Normal Sevas
				$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookQueryString,$excludeIncludeCondition);// Booking Sevas
			} else {
				$condition = array('DEITY_SEVA_OFFERED.SO_DATE' => $_SESSION['dateField'], 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
				$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => $_SESSION['dateField'], 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1);
				$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition); // Normal Sevas
				$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);// Booking Sevas
			}
		} else {
			if(@$radioOpt == "multiDate"){
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				$bookQueryString = "";
				
						if($_SESSION['SId'] != "All") {
							$queryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_SEVA_ID = '".$_SESSION['SId']."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
							$bookQueryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_SEVA_ID = '".$_SESSION['SId']."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE = 1";
						} else {
							$queryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_DEITY_ID = '".$_SESSION['DId']."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1";
							
							$bookQueryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_DEITY_ID = '".$_SESSION['DId']."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE = 1";
						}
					
				$condition = $queryString;
				$bookCondition = $bookQueryString;
				$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookQueryString,$excludeIncludeCondition); // Normal Sevas
				$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookQueryString,$excludeIncludeCondition);// Booking Sevas
			} else {
				if($_SESSION['dateField'] != "" && $_SESSION['SId'] == "All") {
					$condition = array('DEITY_SEVA_OFFERED.SO_DATE' => $_SESSION['dateField'], 'DEITY_SEVA_OFFERED.SO_DEITY_ID' => $_SESSION['DId'], 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
				
					$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => $_SESSION['dateField'], 'DEITY_SEVA_OFFERED.SO_DEITY_ID' => $_SESSION['DId'], 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1);
					$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition); // Normal Sevas
					$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition1,"","",$bookCondition,$excludeIncludeCondition);// Booking Sevas
				} else {
					$condition = array('DEITY_SEVA_OFFERED.SO_DATE' => $_SESSION['dateField'], 'DEITY_SEVA_OFFERED.SO_SEVA_ID' => $_SESSION['SId'], 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
					
					$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => $_SESSION['dateField'], 'DEITY_SEVA_OFFERED.SO_SEVA_ID' => $_SESSION['SId'], 'DEITY_SEVA_OFFERED.RECEIPT_ID'=>0,'SB_ACTIVE'=>1);
					$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition); // Normal Sevas
					$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);// Booking Sevas
				}
			}
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_SESSION['dateField'].")";
		}
		
		unset($_SESSION['dateField']);
		unset($_SESSION['SId']);
		unset($_SESSION['DId']);
		unset($_SESSION['radioOpt']);
		unset($_SESSION['radioAllOpt']);
		unset($_SESSION['allDates']);
		unset($_SESSION['sevaExcludeOrInclude']);
				
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Deity Sevas Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";

		//Joel Sir 19/04/21
		$j = 0;
		$name = "";		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html);
		$html = "";	

		if((sizeof($res1))!= 0) {
			$name1 = "";
			for($l = 0; $l < sizeof($res1); $l++) {				
				if($name1 != $res1[$l]['DEITY_NAME']) {
					if($l != 0) {
						$html .="</tbody></table><br/>";
						$pdf->WriteHTML($html);
						$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
						$k = 0;
					}
					$html .= "<center><strong>Deity Name: ".$res1[$l]['DEITY_NAME']." ".$hDate." (Booking)</strong></center>";
					$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVA NAME</th><th style="padding:5px;">SEVA QTY</th><th style="padding:5px;">NAME</th><th style="padding:5px;">NAKSHATRA</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">BOOKING NO. (DATE)</th></tr></thead><tbody>';
				}
				$name1 = $res1[$l]['DEITY_NAME'];
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".($k+1)."</td>";				
				$html .= "<td style='padding:5px;'>".$res1[$l]['SO_SEVA_NAME']."</td>";	
				$html .= "<td style='padding:5px;'><center>".$res1[$l]['SEVA_QTY']."</center></td>";
				$html .= "<td style='padding:5px;'>".$res1[$l]['RECEIPT_NAME'].$res1[$l]['SB_NAME']."</td>";	
				$html .= "<td style='padding:5px;'>".$res1[$l]['RECEIPT_NAKSHATRA']."</td>";		
				$html .= "<td style='padding:5px;'>".$res1[$l]['RECEIPT_PHONE'].$res1[$l]['SB_PHONE']."</td>";							
				$html .= "<td style='padding:5px;'>".$res1[$l]['RECEIPT_NO'].$res1[$l]['SB_NO']." (".@$res1[$l]['SB_DATE'].") "."</td>";
				$html .= '</tr>';
				$k++;
			}

			$html .="</tbody></table><br/>";
			$pdf->WriteHTML($html);
			$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
		}

		for($i=0; $i<sizeof($res);$i++) {	
			if($name != $res[$i]['DEITY_NAME']) {
				if($i != 0) {
					$html .="</tbody></table><br/>";
					$pdf->WriteHTML($html);
					$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
					$j = 0;
				}
				
				if(!@$res[$i]['RECEIPT_NO'])
					$html = "<center><strong>Deity Name: ".$res[$i]['DEITY_NAME']." ".$hDate." (Booking)</strong></center>";
				else
					$html = "<center><strong>Deity Name: ".$res[$i]['DEITY_NAME']." ".$hDate."</strong></center>";
				
				$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVA NAME</th>
                    <th style="padding:5px;">SEVA QTY</th><th style="padding:5px;">NAME</th>
				    <th style="padding:5px;">NAKSHATRA</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">RECEIPT NO. (DATE)</th></tr></thead><tbody>';
			}

			$name = $res[$i]['DEITY_NAME'];
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($j+1)."</td>";				
			$html .= "<td style='padding:5px;'>".$res[$i]['SO_SEVA_NAME']."</td>";	
			
			if($res[$i]['RECEIPT_CATEGORY_ID'] == 7) {	
				$html .= "<td style='padding:5px;'><center>".$res[$i]['SO_SEVA_QTY']."</center></td>";
			} else{
				$html .= "<td style='padding:5px;'><center>".$res[$i]['SEVA_QTY']."</center></td>";
			}	

			$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NAME'].$res[$i]['SB_NAME']."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NAKSHATRA']."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_PHONE'].$res[$i]['SB_PHONE']."</td>";
			if(@$res[$i]['RECEIPT_NO']) {							
				$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NO'].$res[$i]['SB_NO']." (". @$res[$i]['RECEIPT_DATE'] .") "."</td>";
			}else {
				$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NO'].$res[$i]['SB_NO']." (".@$res[$i]['SB_DATE'].") "."</td>";
			}
			$html .= '</tr>';
			$j++;
		}
		//Joel Sir 19/04/21

		$html .="</tbody></table><br/>";
		$pdf->WriteHTML($html);
		$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Deity Sevas Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Deity Sevas Report ('.$_POST['dateField'].').pdf','I');
    }
	
	//FOR SEVAS SUMMARY DETAILS Print
	public function create_SevasSummaryDetailsSession() {
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['date'] = $_POST['dateField'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		$_SESSION['sevaId'] = @$_POST['sevaId'];
		$_SESSION['sevaName'] = @$_POST['sevaName'];
		$_SESSION['summaryType'] = @$_POST['summaryType'];
		echo 1;	
	}
	
	//FOR EVENT SEVAS SUMMARY DETAILS Print
	public function create_eventSevasSummaryDetailsSession() {
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['date'] = $_POST['dateField'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		$_SESSION['sevaId'] = @$_POST['sevaId'];
		$_SESSION['sevaName'] = @$_POST['sevaName'];
		echo 1;	
	}
	
	//FOR TRUST EVENT SEVAS SUMMARY DETAILS Print
	public function create_trusteventSevasSummaryDetailsSession() {
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['date'] = $_POST['dateField'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		$_SESSION['sevaId'] = @$_POST['sevaId'];
		$_SESSION['sevaName'] = @$_POST['sevaName'];
		echo 1;	
	}
	
	//FOR SEVAS SUMMARY PRINT
	public function create_SevasSummaryReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['date'] = $_POST['dateField'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		$_SESSION['deityId'] = @$_POST['deityId'];
		$_SESSION['deityName'] = @$_POST['deityName'];
		$_SESSION['summaryType'] = @$_POST['summaryType'];
		echo 1;	
	}
	
	//FOR DEITY SEVA SUMMARY PRINT
	public function create_deitySevaSummaryReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['date'] = $_POST['dateField'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		$_SESSION['summaryType'] = @$_POST['summaryType'];
		echo 1;	
	}

	//FOR PAYMENT PRINT
	public function create_PaymentSession() { 
		$_SESSION['aidP'] = $_POST['aidP'];
		$_SESSION['lidP'] = $_POST['lidP'];
		$_SESSION['countNoP'] = @$_POST['countNoP'];
		$_SESSION['transactionDate'] = @$_POST['todayDate'];
		$_SESSION['favouring'] = @$_POST['favouring'];
		$_SESSION['naration'] = @$_POST['naration'];
		$_SESSION['amtsP'] = @$_POST['amtsP'];
		$_SESSION['paymentmethod'] = @$_POST['paymentmethod'];
		$_SESSION['chequeDate'] = @$_POST['chequeDate'];
		$_SESSION['chkno'] = @$_POST['chkno'];
		$_SESSION['bankName'] = @$_POST['bankName'];
		$_SESSION['branchName'] = @$_POST['branchName'];
		//$_SESSION['committeeSelectedName'] = @$_POST['committeeSelectedName'];
		echo 1;	
	}

	//FOR CONTRA PRINT
	public function create_ContraSession() { 
		$_SESSION['aidC'] = $_POST['aidC'];
		$_SESSION['acidC'] = $_POST['acidC'];
		$_SESSION['countNoC'] = @$_POST['countNoC'];
		$_SESSION['transactionDate'] = @$_POST['todayDate'];
		$_SESSION['favouring'] = @$_POST['favouring'];
		$_SESSION['naration'] = @$_POST['naration'];
		$_SESSION['amtsC'] = @$_POST['amtsC'];
		$_SESSION['paymentmethod'] = @$_POST['paymentmethod'];
		$_SESSION['chequeDate'] = @$_POST['chequeDate'];
		$_SESSION['chkno'] = @$_POST['chkno'];
		$_SESSION['bankName'] = @$_POST['bankName'];
		$_SESSION['branchName'] = @$_POST['branchName'];
		$_SESSION['committeeSelectedName'] = @$_POST['committeeSelectedName'];
		echo 1;	
	}

	//FOR JOURNAL PRINT
	public function create_JournalSession() { 
		$_SESSION['type'] = $_POST['type'];
		$_SESSION['ledgers'] = $_POST['ledgers'];
		$_SESSION['countNoJ'] = @$_POST['countNoJ'];
		$_SESSION['todayDate'] = @$_POST['todayDate'];
		$_SESSION['favouring'] = @$_POST['favouring'];
		$_SESSION['naration'] = @$_POST['naration'];
		$_SESSION['amount'] = @$_POST['amount'];
		$_SESSION['committeeSelectedName'] = @$_POST['committeeSelectedName'];
		$_SESSION['toLedgerName'] = @$_POST['toLedgerName'];
		echo 1;
	}

	public function create_eventSevaSummaryReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['date'] = $_POST['dateField'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		echo 1;	
	}
	
	public function create_trusteventSevaSummaryReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['date'] = $_POST['dateField'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['fromDates'] = @$_POST['fromDates'];
		$_SESSION['toDates'] = @$_POST['toDates'];
		echo 1;	
	}
	
	//FOR DEITY SEVA PRINT
	public function create_deitySevaReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['SId'] = $_POST['SId'];
		$_SESSION['DId'] = $_POST['DId'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['radioAllOpt'] = @$_POST['radioAllOpt'];
		$_SESSION['allDates'] = @$_POST['allDates'];
		$_SESSION['sevaExcludeOrInclude'] = @$_POST['sevaExcludeOrInclude'];
		echo 1;	
	}
	public function create_PaymentSessiondaybook() { 
		$_SESSION['VOU_CHER_TYPE'] = $_POST['VOU_CHER_TYPE'];	
		$_SESSION['VOUCHER_NUMBER'] = $_POST['VOUCHER_NUMBER'];
		$_SESSION['CHEQUE_NO'] = $_POST['CHEQUE_NO'];
		$_SESSION['paymentmethod'] = $_POST['PAYMENT_METHOD'];
		$_SESSION['chequedate'] = $_POST['chequedate'];
		$_SESSION['naration'] = $_POST['naration'];
		$_SESSION['FLT_DATE'] = $_POST['FLT_DATE'];
		$_SESSION['FLT_CR'] = $_POST['FLT_CR'];
		$_SESSION['TONAME'] = $_POST['TONAME'];
		$_SESSION['FROMNAME'] = $_POST['FROMNAME'];
		$_SESSION['RECEIPT_FAVOURING_NAME'] = $_POST['RECEIPT_FAVOURING_NAME'];
		$_SESSION['BANK_NAME'] = $_POST['BANK_NAME'];
		echo 1;	
	}


	public function create_Sessiondaybook() { 
		$_SESSION['VOU_CHER_TYPE'] = $_POST['VOU_CHER_TYPE'];
	
		$_SESSION['VOUCHER_NUMBER'] = $_POST['VOUCHER_NUMBER'];
		$_SESSION['CHEQUE_NO'] = $_POST['CHEQUE_NO'];
		$_SESSION['chequedate'] = $_POST['chequedate'];
		$_SESSION['naration'] = $_POST['naration'];
		$_SESSION['FLT_DATE'] = $_POST['FLT_DATE'];
		$_SESSION['FLTDR'] = $_POST['FLTDR'];
		$_SESSION['TONAME'] = $_POST['TONAME'];
		$_SESSION['FROMNAME'] = $_POST['FROMNAME'];
		
		echo 1;	
	}

	

	public function create_PaymentPrintdaybook() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		//$FLT_CR = $_SESSION['FLT_CR'];
		$TONAME = $_SESSION['TONAME'];
		$FROMNAME = $_SESSION['FROMNAME'];
		$VOU_CHER_TYPE = $_SESSION['VOU_CHER_TYPE'];
		$RECEIPTFAVOURINGNAME = $_SESSION['RECEIPT_FAVOURING_NAME'];
		// print_r($FROMNAME);
		$BANK_NAME = $_SESSION['BANK_NAME'];
		// $acidC = str_replace("\'","'",$_SESSION['acidC']);
		$countNoC = $_SESSION['VOUCHER_NUMBER'];
		$transactionDate = $_SESSION['FLT_DATE'];
		//$favouring = $_SESSION['favouring'];
		//$committeeSelectedName = $_SESSION['committeeSelectedName'];
		$naration = $_SESSION['naration'];
		$paymentmethod = $_SESSION['paymentmethod'];
		$chequeDate = $_SESSION['chequedate'];
		$chkno = $_SESSION['CHEQUE_NO'];
		// $bankName = str_replace("\'","'",$_SESSION['bankName']);
		// $branchName = str_replace("\'","'",$_SESSION['branchName']);
		 
		$FLT_CR = $_SESSION['FLT_CR'];
		$rupee = explode('.',$FLT_CR);
		echo "$FLT_CR";
		$amtInWord = $this->financeAmountInWords($FLT_CR);   
		$html = "<center style='font-size:11px;margin-bottom:.3em;text-align:center;'><strong>|| Sri Lakshmi Venkatesh Prasanna ||</strong></center>";
		$html .= "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>Sri Lakshmi Venkatesh Temple</strong></center>";
		$html .= "<center style='font-size:14px;margin-bottom:.3em;text-align:center;'>V.T. Road , Thenkapete - Udupi</center>";  
		//$html .= "<table><tbody><tr><td>Number : </td><td><div style='font-size:10px;float:right'>Date: ".$today."</div></td></tr>" ;
		$html .= "<div style='padding-top:30px;'><span style='font-weight:600;font-size:15px;'><b>Voucher Number :  </b>".$countNoC."</span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span style='text-align: right;'><b>Date:</b>&nbsp;".$transactionDate."</span></div><br>";
		$html .= "<div><b>Account :  </b>".$TONAME."</div><br>";
		$html .= "<div><b>Favouring To :  </b>".$RECEIPTFAVOURINGNAME."</div><br>";
		$html .= "<div><b>Voucher Type :  </b>".$VOU_CHER_TYPE."</div><br>";
		//$html .= "<div><b>Favouring To :  </b>".$favouring."</div><br>";
		//$html .= "<div><b>Committee :  </b>".$committeeSelectedName."</div><br>";
		$html .= "<div><b>Purpose :  </b>".$naration."</div><br>";

		$html .= "<div><span style='padding_left:100px;padding_right:100px;'><b>Rs.  </b>".$FLT_CR."</span>";
		if($rupee[1])
			$html .="<span style='width:100px;'>&emsp;<b>Ps.  </b>".$rupee[1]."</span>";
		$html .="<span>&emsp;<b>Rupees:  </b>".$amtInWord."</span></div><br>";
		if($paymentmethod == "Cheque")
		$html .= "<div><b>Cheque Number :  </b>".$chkno."&emsp;<b>Cheque Date :  </b>".$chequeDate."&emsp;<b>Bank Name : </b>".$BANK_NAME."</div><br>";
		// $html .= "<div><b>Cheque Number :  </b>".$chkno."&emsp;<b>Cheque Date :  </b>".$chequeDate."&emsp;<b>Bank :  </b>".$bankName."&nbsp;".$branchName."</div><br>";

		$html .="<div style='top:45%;position: fixed;'><span style='font-weight:600;font-size:14px;'>Managing Trustee: ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Manager :  ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recipient Signature : ________________</span></div>";
		


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle('SLVT');  //123
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		// $pdf->AddPage('P','A4',0);
		
		
		$pdf->WriteHTML($stylesheet,1);
		
		$pdf->AddPage('P', // L - landscape, P - portrait
					'', '', '', '',
					10, // margin_left
					10, // margin right
					10, // margin top
					10, // margin bottom
					12, // margin header
					12);
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Finance Contra Print ('.$countNoC.').pdf','I');
	}


	//FOR SEVAS SUMMARY DETAILS PDF
	public function create_SevaSummaryDetailspdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
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
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_sevas_summary_details_period_excel($fromDate,$toDate,$sevaId,$summaryCondition);
		} else {
			$res = $this->obj_report->get_all_field_sevas_summary_details_excel($date,$sevaId,$summaryCondition);
		}
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Deity ".$typeVal." Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= "<center><strong>Deity - ".$sevaName."</strong></center><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">RECEIPT NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE NO.</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;$Count = 0;$Amount=0;
		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]['SB_ACTIVE'] != "0") {
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";	
				if(($res[$i]['SO_IS_BOOKING'] == 0) && ($res[$i]['RECEIPT_ID'] != 0)) {
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NO']."</td>";			
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NAME']."</td>";		
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_PHONE']."</td>";		
					$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['SO_PRICE']."</td>";	
				} else if(($res[$i]['SO_IS_BOOKING'] == 1) && ($res[$i]['RECEIPT_ID'] != 0)) {
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NO']."</td>";			
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NAME']."</td>";		
					$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_PHONE']."</td>";		
					$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['SO_PRICE']."</td>";	
				} else {
					$html .= "<td style='padding:5px;'>".$res[$i]['SB_NO']."</td>";			
					$html .= "<td style='padding:5px;'>".$res[$i]['SB_NAME']."</td>";		
					$html .= "<td style='padding:5px;'>".$res[$i]['SB_PHONE']."</td>";		
					$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['SO_PRICE']."</td>";	
				}			
				$html .= '</tr>';
				$Count ++;
				$Amount += $res[$i]['SO_PRICE'];
				$j++;
			}
		}
		
		$html .="</tbody></table><br/>";
		$html .= "<h4 style='text-align:right'>Total Amount:".$Amount."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Sevas:".$Count."</h4>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Sevas Summmary Details Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Sevas Summmary Details Report ('.$date.').pdf','D');
		}
	}
	
	
	//FOR EVENT SEVAS SUMMARY DETAILS PDF
	public function create_eventSevaSummaryDetailspdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_event_sevas_summary_details_period_excel($fromDate,$toDate,$sevaId,$eId);
		} else {
			$res = $this->obj_report->get_all_field_event_sevas_summary_details_excel($date,$sevaId,$eId);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= "<center><strong>".$sevaName."</strong></center><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">RECEIPT NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE NO.</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]['ET_RECEIPT_NO']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['ET_RECEIPT_NAME']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['ET_RECEIPT_PHONE']."</td>";
				$html .= "<td style='padding:5px;'>".$res[$i]['ET_SO_PRICE']."</td>";						
				$html .= '</tr>';
				$j++;		
		}
		
		$html .="</tbody></table><br/>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Event Sevas Summmary Details Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Event Sevas Summmary Details Report ('.$date.').pdf','D');
		}
	}
	
	
	//FOR TRUST EVENT SEVAS SUMMARY DETAILS PDF
	public function create_trusteventSevaSummaryDetailspdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		$this->db->select('*')->from('trust_event');
		$this->db->where('TET_ACTIVE',1);
		$query = $this->db->get();
		$etId= $query->result('array');
		$eId = $etId[0]['TET_ID'];
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_trust_report->get_all_field_event_sevas_summary_details_period_excel($fromDate,$toDate,$sevaId,$eId);
		} else {
			$res = $this->obj_trust_report->get_all_field_event_sevas_summary_details_excel($date,$sevaId,$eId);
		}
		
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= "<center><strong>".$sevaName."</strong></center><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">RECEIPT NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE NO.</th><th style="padding:5px;">QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_RECEIPT_NO']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_RECEIPT_NAME']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_RECEIPT_PHONE']."</td>";
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_SO_QUANTITY']."</td>";
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_SO_PRICE'] * $res[$i]['TET_SO_QUANTITY']."</td>";						
				$html .= '</tr>';
				$j++;		
		}
		
		$html .="</tbody></table><br/>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Event Sevas Summmary Details Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Event Sevas Summmary Details Report ('.$date.').pdf','D');
		}
	}

	
	
	//FOR SEVAS SUMMARY PDF
	public function create_SevaSummaryReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
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
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails(); 
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_sevas_summary_report_period($fromDate,$toDate,$deityId,$summaryCondition);
		} else {
			$res = $this->obj_report->get_all_field_sevas_summary($date,$deityId,$summaryCondition);
		}
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Deity ".$typeVal." Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= "<center><strong>Deity - ".$deityName."</strong></center><br/>";
		$html .= '<table width="100%"><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVAS NAME</th><th style="padding:5px;">QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;$Count = 0;$Amount=0;
		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]['SB_ACTIVE'] != "0") {
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['SO_SEVA_NAME']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['QTY']."</td>";		
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['AMOUNT']."</td>";		
				$html .= '</tr>';
				$Count += $res[$i]['QTY'];
				$Amount += $res[$i]['AMOUNT'];
				$j++;
			}
		}
		
		$html .="</tbody></table><br/>";
		$html .= "<h4 style='text-align:right'>Total Amount:".$Amount."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Sevas:".$Count."</h4>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Sevas Summmary Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Sevas Summmary Report ('.$date.').pdf','D');
		}
	}
	
	//FOR DEITY SEVA SUMMARY PDF
	public function create_deitySevaSummaryReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDates']." to ".$_SESSION['toDates'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
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
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_deity_seva_summary_report_period($fromDate,$toDate,$summaryCondition);
		} else {
			$res = $this->obj_report->get_all_field_deity_seva_summary_report($date,$summaryCondition);
		}
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Deity ".$typeVal." Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= '<table width="100%"><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">DEITY NAME</th><th style="padding:5px;">SEVAS QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;$Count = 0;$Amount=0;
		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]['SB_ACTIVE'] != "0") {
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['DEITY_NAME']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['QTY']."</td>";		
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['AMOUNT']."</td>";		
				$html .= '</tr>';
				$Count += $res[$i]['QTY'];
				$Amount += $res[$i]['AMOUNT'];
				$j++;
			}
		}
		
		$html .="</tbody></table><br/>";
		$html .= "<h4 style='text-align:right'>Total Amount:".$Amount."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Sevas:".$Count."</h4>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDates'];
			$toDate=$_SESSION['toDates'];
			$pdf->Output("Deity Sevas Summmary Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Deity Sevas Summmary Report ('.$_POST['dateField'].').pdf','D');
		}
	}
	
	//FOR EVENT SEVA SUMMARY PDF
	public function create_eventSevaSummaryReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_report->get_all_field_event_sevas_summary_report_period($fromDate,$toDate,$eId);
		} else {
			$res = $this->obj_report->get_all_field_event_sevas_summary($date,$eId);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Event Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">EVENT SEVA NAME</th><th style="padding:5px;">SEVAS QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['ET_SO_SEVA_NAME']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['QTY']."</td>";		
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['AMOUNT']."</td>";		
				$html .= '</tr>';
				$j++;
		
		}
		
		$html .="</tbody></table><br/>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Event Sevas Summmary Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Event Sevas Summmary Report ('.$_POST['dateField'].').pdf','D');
		}
	}
	
	
	
	
	//FOR  TRUST EVENT SEVA SUMMARY PDF
	public function create_trusteventSevaSummaryReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		$this->db->select('*')->from('trust_event');
		$this->db->where('TET_ACTIVE',1);
		$query = $this->db->get();
		$etId= $query->result('array');
		$eId = $etId[0]['TET_ID'];
		
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
		
		// if(@$radioOpt == "multiDate") {
		// 	$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		// } else {
		// 	$hDate = "(".$_POST['dateField'].")";
		// }
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$fromDate." to ".$toDate.")";
		} else {
			$hDate = "(".$date.")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_trust_report->get_all_field_event_sevas_summary_report_period($fromDate,$toDate,$eId);
		} else {
			$res = $this->obj_trust_report->get_all_field_event_sevas_summary($date,$eId);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong> Trust Event Sevas Summary Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">EVENT SEVA NAME</th><th style="padding:5px;">SEVAS QUANTITY</th><th style="padding:5px;">AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['TET_SO_SEVA_NAME']."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['QTY']."</td>";		
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]['AMOUNT']."</td>";		
				$html .= '</tr>';
				$j++;
		
		}
		
		$html .="</tbody></table><br/>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Trust Event Sevas Summmary Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Trust Event Sevas Summmary Report ('.$_POST['dateField'].').pdf','D');
		}
	}

	//For Shashawath Seva Report PDF for Temple Priests
	public function createShashwathSevaReportPDF() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';

		if(isset($_SESSION['name_phone'])) 
			$name_phone = $data['name_phone'] = $_SESSION['name_phone'];
		else 
			$name_phone = '';

		if(isset($_SESSION['generateDateForPDFReport']))
			$date = $_SESSION['generateDateForPDFReport'];

		if($_SESSION['excludeOrInclude']=="Exclude") {
			$excludeIncludeCondition = "and deity_seva.SEVA_INCL_EXCL != 'Exclude' ";
		} else {
			$excludeIncludeCondition ="";
		}

		$arrShashReports = $this->obj_shashwath->getShashwathDetailsForGeneratingShaswathSevaReport($date, $name_phone,$excludeIncludeCondition);
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Shashwath Sevas Report ".$date."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html);
		$name = "";
		$html = "";		
		
		for($i = 0; $i < sizeof($arrShashReports); $i++) {
			if($name != $arrShashReports[$i]['DEITY_NAME']) {
				if($i != 0) {
					$html .="</tbody></table><br/>";
					$pdf->WriteHTML($html);
					$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
					$html = "";
					$k = 0;
				}
				$html .= "<center><strong>Deity Name: ".$arrShashReports[$i]['DEITY_NAME']."</strong></center>";
				$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVA NAME</th><th style="padding:5px;">NAME</th><th style="padding:5px;">NAKSHATRA</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">THITHI CODE</th></tr></thead><tbody>';
			}

			$name = $arrShashReports[$i]['DEITY_NAME'];
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($k+1)."</td>";				
			$html .= "<td style='padding:5px;'>".$arrShashReports[$i]['SEVA_NAME']."</td>";			
			$html .= "<td style='padding:5px;'>".$arrShashReports[$i]['SM_NAME']."</td>";		
			$html .= "<td style='padding:5px;'>".$arrShashReports[$i]['SM_NAKSHATRA']."</td>";		
			$html .= "<td style='padding:5px;'>".$arrShashReports[$i]['SM_PHONE']."</td>";						
			$html .= "<td style='padding:5px;'>".$arrShashReports[$i]['THITHI_CODE']."</td>";
			$html .= '</tr>';
			$k++;
		}

		$html .="</tbody></table><br/>";			
		$pdf->WriteHTML($html);
	
		$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");

		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		 
		$pdf->Output('Shashwath Sevas Report ('.$date.').pdf','I');
	}
	
	//FOR DEITY SEVA PDF
	public function create_deitySevaReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		if(isset($_POST['radioOpt'])) {
			$radioOpt = @$_POST['radioOpt'];
		} else {
			$radioOpt = $_SESSION['radioOpt'];
		}
		
		if(isset($_POST['radioAllOpt'])) {
			$radioAllOpt = @$_POST['radioAllOpt'];
		} else {
			$radioAllOpt = $_SESSION['radioAllOpt'];
		}
		
		if(isset($_POST['allDates'])) {
			$allDates= @$_POST['allDates'];
		} else {
			$allDates = $_SESSION['allDates'];
		}

		if($_POST['excludeOrInclude']=="Exclude") {
			$excludeIncludeCondition = " deity_seva.SEVA_INCL_EXCL != 'Exclude' ";
		} else {
			$excludeIncludeCondition ="";
		}

		$dispdate = "";
		if(@$radioAllOpt == "allDeity") {
			if(@$radioOpt == "multiDate"){
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				$bookQueryString = "";

					$queryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_RECEIPT.RECEIPT_ACTIVE = 1 ";
					$bookQueryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE = 1 ";
					
				$condition = $queryString;
				$bookCondition = $bookQueryString;
				$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition);
				$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);
				$No = (count($allDates1) - 1);
				$dispdate = $allDates1[0]." To ".$allDates1[$No];
			} else {
				$condition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
				$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_SEVA_OFFERED.RECEIPT_ID' =>0,'SB_ACTIVE'=>1);
				$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition);
				$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);
				$dispdate = $this->input->post('dateField');
			}
		} else {
			if(@$radioOpt == "multiDate"){
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				$bookQueryString = "";

					if($this->input->post('SId') != "All") {
						$queryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_SEVA_ID ='".$this->input->post('SId')."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1 ";
						$bookQueryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_SEVA_ID ='".$this->input->post('SId')."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE = 1 ";
					} else {
						$queryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$this->input->post('DId')."' and DEITY_RECEIPT.RECEIPT_ACTIVE = 1 ";
						$bookQueryString .= "STR_TO_DATE(DEITY_SEVA_OFFERED.SO_DATE,'%d-%m-%Y') BETWEEN STR_TO_DATE('".$allDates1[0]."','%d-%m-%Y') AND STR_TO_DATE('".$allDates1[count($allDates1)-1]."','%d-%m-%Y') and DEITY_SEVA_OFFERED.SO_DEITY_ID ='".$this->input->post('DId')."' and DEITY_SEVA_OFFERED.RECEIPT_ID=0 and SB_ACTIVE = 1 ";
					}

				$condition = $queryString;
				$bookCondition = $bookQueryString;
				$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition);
				$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);
				$No = (count($allDates1) - 1);
				$dispdate = $allDates1[0]." To ".$allDates1[$No];
			} else {
				if(($this->input->post('dateField')) != "" && ($this->input->post('SId') == "All")) {
					$condition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_SEVA_OFFERED.SO_DEITY_ID' => $this->input->post('DId'), 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
					$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_SEVA_OFFERED.SO_DEITY_ID' => $this->input->post('DId'), 'DEITY_SEVA_OFFERED.RECEIPT_ID' =>0,'SB_ACTIVE'=>1);
					$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition);
					$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition);
				} else {
					$condition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_SEVA_OFFERED.SO_SEVA_ID' => $this->input->post('SId'), 'DEITY_RECEIPT.RECEIPT_ACTIVE' => 1);
					$bookCondition = array('DEITY_SEVA_OFFERED.SO_DATE' => $this->input->post('dateField'), 'DEITY_SEVA_OFFERED.SO_SEVA_ID' => $this->input->post('SId'), 'DEITY_SEVA_OFFERED.RECEIPT_ID' =>0,'SB_ACTIVE'=>1);
					$res = $this->obj_report->get_all_field_deity_seva_excel($condition,"","",$bookCondition,$excludeIncludeCondition); //Normal Sevas
					$res1 = $this->obj_report->get_all_field_deity_seva_excel1($condition,"","",$bookCondition,$excludeIncludeCondition); // Sevas Booking
				}
				$dispdate = $this->input->post('dateField');
			}
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Deity Sevas Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$j = 0;
		$name = ""; 
		$z = 0;
		
		$arr = [];
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html);
		$html = "";	
		//Joel Sir 19/04/21	
		
		if((sizeof($res1))!= 0) {
			$name1 = "";
			for($l = 0; $l < sizeof($res1); $l++) {				
				if($name1 != $res1[$l]['DEITY_NAME']) {
					if($l != 0) {
						$html .="</tbody></table><br/>";
						$pdf->WriteHTML($html);
						$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
						$k = 0;
					}
					$html .= "<center><strong>Deity Name: ".$res1[$l]['DEITY_NAME']." ".$hDate." (Booking)</strong></center>";
					$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVA NAME</th><th style="padding:5px;">SEVA QTY</th><th style="padding:5px;">NAME</th><th style="padding:5px;">NAKSHATRA</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">BOOKING NO. (DATE)</th></tr></thead><tbody>';
				}
				$name1 = $res1[$l]['DEITY_NAME'];
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".($k+1)."</td>";				
				$html .= "<td style='padding:5px;'>".$res1[$l]['SO_SEVA_NAME']."</td>";	
				$html .= "<td style='padding:5px;'><center>".$res1[$l]['SEVA_QTY']."</center></td>";
				$html .= "<td style='padding:5px;'>".$res1[$l]['RECEIPT_NAME'].$res1[$l]['SB_NAME']."</td>";	
				$html .= "<td style='padding:5px;'>".$res1[$l]['RECEIPT_NAKSHATRA']."</td>";		
				$html .= "<td style='padding:5px;'>".$res1[$l]['RECEIPT_PHONE'].$res1[$l]['SB_PHONE']."</td>";							
				$html .= "<td style='padding:5px;'>".$res1[$l]['RECEIPT_NO'].$res1[$l]['SB_NO']." (".@$res1[$l]['SB_DATE'].") "."</td>";
				$html .= '</tr>';
				$k++;
			}

			$html .="</tbody></table><br/>";
			$pdf->WriteHTML($html);
			$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
		}

		for($i=0; $i<sizeof($res);$i++) {	
			if($name != $res[$i]['DEITY_NAME']) {
				if($i != 0) {
					$html .="</tbody></table><br/>";
					$pdf->WriteHTML($html);
					$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
					$j = 0;
				}
				
				if(!@$res[$i]['RECEIPT_NO'])
					$html = "<center><strong>Deity Name: ".$res[$i]['DEITY_NAME']." ".$hDate." (Booking)</strong></center>";
				else
					$html = "<center><strong>Deity Name: ".$res[$i]['DEITY_NAME']." ".$hDate."</strong></center>";
				
				$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVA NAME</th>
                    <th style="padding:5px;">SEVA QTY</th><th style="padding:5px;">NAME</th>
				    <th style="padding:5px;">NAKSHATRA</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">RECEIPT NO. (DATE)</th></tr></thead><tbody>';
			}


			$name = $res[$i]['DEITY_NAME'];
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($j+1)."</td>";				
			$html .= "<td style='padding:5px;'>".$res[$i]['SO_SEVA_NAME']."</td>";	
			
			if($res[$i]['RECEIPT_CATEGORY_ID'] == 7) {	
				$html .= "<td style='padding:5px;'><center>".$res[$i]['SO_SEVA_QTY']."</center></td>";
			} else{
				$html .= "<td style='padding:5px;'><center>".$res[$i]['SEVA_QTY']."</center></td>";
			}	

			$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NAME'].$res[$i]['SB_NAME']."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NAKSHATRA']."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_PHONE'].$res[$i]['SB_PHONE']."</td>";
			if(@$res[$i]['RECEIPT_NO']) {							
				$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NO'].$res[$i]['SB_NO']." (". @$res[$i]['RECEIPT_DATE'] .") "."</td>";
			}else {
				$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NO'].$res[$i]['SB_NO']." (".@$res[$i]['SB_DATE'].") "."</td>";
			}
			$html .= '</tr>';
			$j++;
		}
		//Joel Sir 19/04/21	
		
		$html .="</tbody></table><br/>";
		
		$pdf->WriteHTML($html);
		$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		 // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Deity Sevas Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Deity Sevas Report ('.$_POST['dateField'].').pdf','D');
		}
    }
	
	//FOR PRINT DEITY
	public function create_deityReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['payMode'] = $_POST['payMode'];
		$_SESSION['deityId'] = $_POST['deityId'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['allDates'] = @$_POST['allDates'];
		echo 1;
	}
	
	
	//FOR JEERNODHARA PRINT
	public function create_jeernodharaSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['allDates'] = @$_POST['allDates'];
		echo 1;
	}

	public function create_shashwathLossReportSession() { 
		$_SESSION['dateField'] = @$_POST['dateField'];
		echo 1;
	}
	
	//FOR PRINT LOSS REPORT
	public function create_LossReportSession() { 
		$_SESSION['date'] = @$_POST['date'];
		echo 1;
	}
	
	//FOR PRINT DEITY
	public function create_trustReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['payMode'] = $_POST['payMode'];
		$_SESSION['financialHeadId'] = $_POST['financialHeadId'];
		$_SESSION['radioOpt'] = @$_POST['radioOpt'];
		$_SESSION['allDates'] = @$_POST['allDates'];
		echo 1;
	}
 
	//TRUST RECEIPT PRINT
	public function create_trustReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if($_SESSION['dateField'] != "" && $_SESSION['payMode'] == "All") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
						$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
						$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('RECEIPT_DATE' => $_SESSION['dateField'],'TR_ACTIVE'=>1); // 'RECEIPT_DEITY_ID' => $_SESSION['deityId'] ,
				$conditionOne= array('RECEIPT_DATE' => $_SESSION['dateField'],'TR_ACTIVE'=>0); // 'RECEIPT_DEITY_ID' => $_SESSION['deityId'] ,
			}
			$res = $this->obj_trust_report->get_all_field_trust_receipt_excel($condition);
			$res1 = $this->obj_trust_report->get_all_field_trust_receipt_excel($conditionOne);
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_SESSION['payMode']."' and TR_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
						$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_SESSION['payMode']."' and TR_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_SESSION['payMode']."' and TR_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
						$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_SESSION['payMode']."' and TR_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('RECEIPT_PAYMENT_METHOD' => $_SESSION['payMode'],'RECEIPT_DATE' => $_SESSION['dateField'],'TR_ACTIVE'=>1); // 'RECEIPT_DEITY_ID' => $_SESSION['deityId'] ,
				$conditionOne= array('RECEIPT_PAYMENT_METHOD' => $_SESSION['payMode'],'RECEIPT_DATE' => $_SESSION['dateField'],'TR_ACTIVE'=>0); // 'RECEIPT_DEITY_ID' => $_SESSION['deityId'] ,
			}
			$res = $this->obj_trust_report->get_all_field_trust_receipt_excel($condition);
			$res1 = $this->obj_trust_report->get_all_field_trust_receipt_excel($conditionOne);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_SESSION['dateField'].")";
		}
		
		unset($_SESSION['dateField']);
		unset($_SESSION['payMode']);
		unset($_SESSION['financialHeadId']); 
		unset($_SESSION['radioOpt']); 
		unset($_SESSION['allDates']); 
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Trust Receipt Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th>
			<th style="padding:5px;">Type</th>
			<th style="padding:5px;">Booking No.</th>
			<th style="padding:5px;">Receipt Date</th>
			<th style="padding:5px;">Receipt Type</th>
			<th style="padding:5px;">Name</th>
			<th style="padding:5px;">Payment Mode</th>
			<th style="padding:5px;">Amount</th>
			<th style="padding:5px;">Payment Status</th>
			<th style="padding:5px;">Estimated Price</th>
			<th style="padding:5px;">Description</th>
			<th style="padding:5px;">Quantity</th>
			<th style="padding:5px;">Payment Notes</th>
			<th style="padding:5px;">Authorized Status</th>
			</tr></thead><tbody>';
		$total = 0;

		$cash = 0;
		$card = 0;
		$direct = 0;
		$cheque = 0;

		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]->RECEIPT_PAYMENT_METHOD == "Cash") {
				$cash += $res[$i]->FH_AMOUNT;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Cheque") {
				$cheque += $res[$i]->FH_AMOUNT;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Direct Credit") {
				$direct += $res[$i]->FH_AMOUNT;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Credit / Debit Card") {
				$card += $res[$i]->FH_AMOUNT;
			}

			$total += $res[$i]->FH_AMOUNT;
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res[$i]->TR_NO."</td>";	
			if($res[$i]->RECEIPT_CATEGORY_ID==1){
				$html .= "<td style='padding:5px;'>Inkind</td>";	
			}else{
				$html .= "<td style='padding:5px;'>Trust Receipt</td>";	
			}		
			$html .= "<td style='padding:5px;'>".$res[$i]->HB_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->FH_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PAYMENT_METHOD."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->FH_AMOUNT."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]->PAYMENT_STATUS ."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_APPRX_AMT ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_DESC ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_QTY ." ".$res[$i]->IK_ITEM_UNIT ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->TR_PAYMENT_METHOD_NOTES ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->AUTHORISED_STATUS ."</td>";
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'><b>Total</b></td><td style='padding:5px;text-align:right;'><b>".$total ."</b></td><td style='padding:5px;'></td></tr>";
		$html .="</tbody></table><br>";

		$html .= '<table><thead><tr><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th><th style="padding:5px;">DIRECT CREDIT</th><th style="padding:5px;">CREDIT/DEBIT CARD</th><th style="padding:5px;">TOTAL</th></tr></thead><tbody>';

		$html .= '<tr>';
		$html .= "<td style='padding:5px;text-align:right;'>".$cash."</td>";    
		$html .= "<td style='padding:5px;text-align:right;'>".$cheque."</td>";			
		$html .= "<td style='padding:5px;text-align:right;'>".$direct."</td>";			
		$html .= "<td style='padding:5px;text-align:right;'>".$card."</td>";
		$html .= "<td style='padding:5px;text-align:right;'>".($cash + $cheque + $direct + $card)."</td>";
		$html .= '</tr>';
		$html .="</tbody></table><br/>";
		
		$html .= '<table><thead><tr><th colspan=8>Cancelled Receipts</th></tr><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Receipt Date</th><th style="padding:5px;">Receipt Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Payment Status</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res1); $i++)
		{
			$total += $res1[$i]->FH_AMOUNT;
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res1[$i]->TR_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->HB_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->FH_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_PAYMENT_METHOD."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->FH_AMOUNT."</td>";		
			$html .= "<td style='padding:5px;'>".$res1[$i]->PAYMENT_STATUS ."</td>";				
			$html .= '</tr>';
		}
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		//$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
			
			$pdf->Output("Trust Receipt Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Trust Receipt Report ('.$_POST['dateField'].').pdf','I');
    }
	
	
	public function create_JeernodharaDailyReportprint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
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
		
		if($_SESSION['dateField'] != "") {
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
				$condition= array('RECEIPT_DATE' => $_SESSION['dateField'],'RECEIPT_ACTIVE'=>1); 
			}
			$res = $this->obj_receipt->get_daily_reportPdf($condition,$userId,$payMethod);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_SESSION['dateField'].")";
		}

		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Jeernodhara Daily Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">S No.</th><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Name</th><th style="padding:5px;">Phone</th><th style="padding:5px;">Address</th><th style="padding:5px;">Receipt Category</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Payment method</th><th style="padding:5px;">Payment Notes</th></tr></thead><tbody>';

		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_NO."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PHONE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_ADDRESS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_CATEGORY_TYPE."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PRICE."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PAYMENT_METHOD."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PAYMENT_METHOD_NOTES."</td>";			
			$html .= '</tr>'; 
		}
		$html .="</tbody></table>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF		
		if(@$radioOpt == "multiDate") {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
			
			$pdf->Output("Jeernodhara Period Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Jeernodhara Daily Report ('.$_POST['dateField'].').pdf','I');
	}
 
	//DEITY RECEIPT PRINT
	public function create_ShashwathLossReportPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		$date = $this->input->post('dateField');
		$res = $this->obj_shashwath->getMainLossExcelPDFReport($date);

		unset($_SESSION['dateField']);
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();	
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Deity Receipt Report ".$date."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Name (Phone)</th><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Accumulated Loss</th></tr></thead><tbody>';
	
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->NAME_PHONE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->DEITY_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SEVA_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ACCUMULATED_LOSS."</td>";		
			$html .= '</tr>';
			$ACCUMULATED_LOSS = explode(' ',$res[$i]->ACCUMULATED_LOSS)[1];
			$totalLoss += explode('/',$ACCUMULATED_LOSS)[0];
		}
		$html .="</tbody></table>";
		$html .= '<tr>';
		$html .= "<th style='padding:5px;text-align:left;' colspan='4'>Total Loss</th>";
		$html .= "<td style='padding:5px;'>Rs. ".$totalLoss."/- </td>";
		$html .= '</tr>';
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
				
		$pdf->Output('Shashwath Loss Report ('.$_POST['dateField'].').pdf','I');
    }
	
	//DEITY RECEIPT PRINT
	public function create_deityReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if($_SESSION['dateField'] != "" && $_SESSION['payMode'] == "All") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
						$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
						$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('RECEIPT_DATE' => $_SESSION['dateField'],'RECEIPT_ACTIVE'=>1); // 'RECEIPT_DEITY_ID' => $_SESSION['deityId'] ,
				$conditionOne= array('RECEIPT_DATE' => $_SESSION['dateField'],'RECEIPT_ACTIVE'=>0); // 'RECEIPT_DEITY_ID' => $_SESSION['deityId'] ,
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
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_SESSION['payMode']."' and RECEIPT_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
						$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_SESSION['payMode']."' and RECEIPT_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_SESSION['payMode']."' and RECEIPT_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
						$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_SESSION['payMode']."' and RECEIPT_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_SESSION['deityId']."
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('RECEIPT_PAYMENT_METHOD' => $_SESSION['payMode'],'RECEIPT_DATE' => $_SESSION['dateField'],'RECEIPT_ACTIVE'=>1); // 'RECEIPT_DEITY_ID' => $_SESSION['deityId'] ,
				$conditionOne= array('RECEIPT_PAYMENT_METHOD' => $_SESSION['payMode'],'RECEIPT_DATE' => $_SESSION['dateField'],'RECEIPT_ACTIVE'=>0); // 'RECEIPT_DEITY_ID' => $_SESSION['deityId'] ,
			}
			$res = $this->obj_report->get_all_field_deity_receipt_excel($condition);
			$res1 = $this->obj_report->get_all_field_deity_receipt_excel($conditionOne);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_SESSION['dateField'].")";
		}
		
		unset($_SESSION['dateField']);
		unset($_SESSION['payMode']);
		unset($_SESSION['deityId']); 
		unset($_SESSION['radioOpt']); 
		unset($_SESSION['allDates']); 
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Deity Receipt Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Receipt Date</th><th style="padding:5px;">Receipt Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Estimated Price</th><th style="padding:5px;">Description</th><th style="padding:5px;">Quantity</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Grand Total</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Payment Status</th></tr></thead><tbody>';
		$total = 0;

		$cash = 0;
		$card = 0;
		$direct = 0;
		$cheque = 0;

		for($i = 0; $i < sizeof($res); $i++)
		{
			$sum = ($res[$i]->RECEIPT_PRICE) + ($res[$i]->POSTAGE_PRICE);
			if($res[$i]->RECEIPT_PAYMENT_METHOD == "Cash") {
				$cash += $res[$i]->RECEIPT_PRICE;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Cheque") {
				$cheque += $res[$i]->RECEIPT_PRICE;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Direct Credit") {
				$direct += $res[$i]->RECEIPT_PRICE;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Credit / Debit Card") {
				$card += $res[$i]->RECEIPT_PRICE;
			}

			$total += $res[$i]->RECEIPT_PRICE;
			$total += $res[$i]->POSTAGE_PRICE;
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_NAME."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->DY_IK_APPRX_AMT."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]->DY_IK_ITEM_DESC."</td>";		
	
			// $html .= "<td style='padding:5px;'>".$res[$i]->DY_IK_ITEM_QTY."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->DY_IK_ITEM_QTY." ".$res[$i]->DY_IK_ITEM_UNIT."</td>";						
										
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PAYMENT_METHOD."</td>";			
			if($res[$i]->RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->RECEIPT_PRICE."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->POSTAGE_PRICE."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$sum."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PAYMENT_METHOD_NOTES."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->PAYMENT_STATUS ."</td>";				
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'><td style='padding:5px;'><td style='padding:5px;'><b>Total</b></td><td style='padding:5px;text-align:right;'><b>".$total ."</b></td><td style='padding:5px;'></td></tr>";
		$html .="</tbody></table><br>";

		$html .= '<table><thead><tr><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th><th style="padding:5px;">DIRECT CREDIT</th><th style="padding:5px;">CREDIT/DEBIT CARD</th><th style="padding:5px;">TOTAL</th></tr></thead><tbody>';

		$html .= '<tr>';
		$html .= "<td style='padding:5px;text-align:right;'>".$cash."</td>";    
		$html .= "<td style='padding:5px;text-align:right;'>".$cheque."</td>";			
		$html .= "<td style='padding:5px;text-align:right;'>".$direct."</td>";			
		$html .= "<td style='padding:5px;text-align:right;'>".$card."</td>";
		$html .= "<td style='padding:5px;text-align:right;'>".($cash + $cheque + $direct + $card)."</td>";
		$html .= '</tr>';
		$html .="</tbody></table><br/>";
		
		$html .= '<table><thead><tr><th colspan=8>Cancelled Receipts</th></tr><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Receipt Date</th><th style="padding:5px;">Receipt Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Grand Total</th><th style="padding:5px;">Payment Status</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res1); $i++)
		{
			$sum = ($res1[$i]->RECEIPT_PRICE) + ($res1[$i]->POSTAGE_PRICE);
			$total += $res1[$i]->RECEIPT_PRICE;
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_PAYMENT_METHOD."</td>";			
			if($res1[$i]->RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->RECEIPT_PRICE."</td>";		
			$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->POSTAGE_PRICE."</td>";		
			$html .= "<td style='padding:5px;text-align:right;'>".$sum."</td>";		
			$html .= "<td style='padding:5px;'>".$res1[$i]->PAYMENT_STATUS ."</td>";				
			$html .= '</tr>';
		}
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		//$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
			
			$pdf->Output("Deity Receipt Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Deity Receipt Report ('.$_POST['dateField'].').pdf','I');
    }
 
	//FOR SEVA BOOKING PRINT
	public function create_sevaBookingPDF() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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

		if($_POST['payMode'] == 'Pending') {
			$paymentMode = 0;
		} else if($_POST['payMode'] == 'Completed') {
			$paymentMode = 1;
		} else if($_POST['payMode'] == 'All') {
			$paymentMode = 2;
		} else if($_POST['payMode'] == 'Cancelled') {
			$paymentMode = 3;
		}
		
		if($_POST['dateField'] != "" && $paymentMode == "2" && $_POST['namephone'] == "") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0)
						$queryString .= "SO_DATE='".$allDates1[$i]."'";
					else
						$queryString .= " or SO_DATE='".$allDates1[$i]."'";
				}
				$condition= $queryString;
			} else {
				$condition= array('SO_DATE' => $_POST['dateField']);
			}
			$res = $this->obj_booking->get_all_field_booking_report($condition);
		} else if($_POST['dateField'] != "" && $paymentMode != "2" && $_POST['namephone'] != "") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0)
						$queryString .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS='".$paymentMode."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					else
						$queryString .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS='".$paymentMode."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; //and RECEIPT_DEITY_ID = ".$_POST['deityId']."
				}
				$condition= $queryString;
			} else {
				$queryString = " SO_DATE='".$_POST['dateField']."' and SB_PAYMENT_STATUS = '".$paymentMode."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; 
				$condition = $queryString; 
			}
			$res = $this->obj_booking->get_all_field_booking_report($condition);
		} else if($_POST['dateField'] != "" && $_POST['namephone'] != "" && $paymentMode == "2") {	
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0)
						$queryString .= "SO_DATE='".$allDates1[$i]."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; 
					else
						$queryString .= " or SO_DATE='".$allDates1[$i]."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; 
				}
				$condition = $queryString;
			} else {
				$queryString = " SO_DATE='".$_POST['dateField']."' and (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; 
				$condition = $queryString;
			}
			$res = $this->obj_booking->get_all_field_booking_report($condition);
		} else if($_POST['dateField'] != "" && $paymentMode != "2" && $_POST['namephone'] == "") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0)
						$queryString .= "SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS='".$paymentMode."'";
					else
						$queryString .= " or SO_DATE='".$allDates1[$i]."' and SB_PAYMENT_STATUS='".$paymentMode."'";
				}
				$condition= $queryString;
			} else {
				$condition= array('SB_PAYMENT_STATUS' => $paymentMode,'SO_DATE' => $_POST['dateField']);
			}
			$res = $this->obj_booking->get_all_field_booking_report($condition);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}

		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Seva Booking Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";

		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">SEVA DATE</th><th style="padding:5px;">BOOKING NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">ADDRESS</th><th style="padding:5px;">DEITY</th><th style="padding:5px;">SEVA</th><th style="padding:5px;">AMOUNT</th><th style="padding:5px;">DATE</th><th style="padding:5px;">PAYMENT STATUS</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res[$i]->SO_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SB_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SB_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SB_ADDRESS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SO_DEITY_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SO_SEVA_NAME."</td>";			
			if($res[$i]->SO_PRICE == "0")
				$html .= "<td></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->SO_PRICE."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]->SB_DATE ."</td>";	
			if($res[$i]->SB_PAYMENT_STATUS == "0") {
				$html .= "<td style='padding:5px;'>Pending</td>";	
			} else if($res[$i]->SB_PAYMENT_STATUS == "1") {
				$html .= "<td style='padding:5px;'>Completed</td>";	
			} else if($res[$i]->SB_PAYMENT_STATUS == "3") {
				$html .= "<td style='padding:5px;'>Cancelled</td>";	
			}
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions = false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		
		if(@$radioOpt == "multiDate") {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
			$pdf->Output("Seva Booking Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Seva Booking Report ('.$_POST['dateField'].').pdf','D');
		}
	}
 
	//AUCTION REPORT PDF
	public function create_trustAuctionreportpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		$date = date('d-m-Y');
		
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
			$res = $this->obj_trust_report->get_auction_report_excel($conditionOne);
		} else {
			$conditionOne = array('AR_PAYMENT_MODE' => $paymentMode);
			$res = $this->obj_trust_report->get_auction_report_excel($conditionOne);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Auction Report ".$date."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SL NO.</th><th style="padding:5px;">BID REF. NO.</th><th style="padding:5px;">ITEM REF. NO.</th><th style="padding:5px;">ITEM DETAILS</th><th style="padding:5px;">BIDDER DETAILS</th><th style="padding:5px;">PAYMENT MODE</th><th style="padding:5px;">BID PRICE</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->BID_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ITEM_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AR_ITEM_DETAILS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->BIL_ITEM_DETAILS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AR_PAYMENT_MODE."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->AR_BID_PRICE."</td>";				
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Auction Report ('.$date.').pdf','D');
    }

	//AUCTION REPORT PDF
	public function create_auctionreportpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		$date = date('d-m-y');
		
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
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Auction Report ".$date."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SL NO.</th><th style="padding:5px;">BID REF. NO.</th><th style="padding:5px;">ITEM REF. NO.</th><th style="padding:5px;">ITEM DETAILS</th><th style="padding:5px;">BIDDER DETAILS</th><th style="padding:5px;">PAYMENT MODE</th><th style="padding:5px;">BID PRICE</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->BID_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ITEM_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AR_ITEM_DETAILS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->BIL_ITEM_DETAILS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AR_PAYMENT_MODE."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->AR_BID_PRICE."</td>";				
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Auction Report ('.$date.').pdf','D');
    }
	
	
 	
	//TRUST RECEIPT PDF
	public function create_trustReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if($_POST['dateField'] != "" && $_POST['payMode'] == "All") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and TR_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('RECEIPT_DATE' => $_POST['dateField'],'TR_ACTIVE' => 1); //'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
				$conditionOne= array('RECEIPT_DATE' => $_POST['dateField'],'TR_ACTIVE' => 0); //'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
			}
			$res = $this->obj_trust_report->get_all_field_trust_receipt_excel($condition);
			$res1 = $this->obj_trust_report->get_all_field_trust_receipt_excel($conditionOne);
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates); 
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and TR_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and TR_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and TR_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and TR_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'RECEIPT_DATE' => $_POST['dateField'],'TR_ACTIVE' => 1); // 'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
				$conditionOne= array('RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'RECEIPT_DATE' => $_POST['dateField'],'TR_ACTIVE' => 0); // 'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
			}
			$res = $this->obj_trust_report->get_all_field_trust_receipt_excel($condition);
			$res1 = $this->obj_trust_report->get_all_field_trust_receipt_excel($conditionOne);
		} 
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Trust Receipt Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Type</th><th style="padding:5px;">Booking No.</th><th style="padding:5px;">Receipt Date</th><th style="padding:5px;">Receipt Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Payment Status</th><th style="padding:5px;">Estimated Price</th>
			<th style="padding:5px;">Description</th><th style="padding:5px;">Quantity</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Authorized Status</th></tr></thead><tbody>';
		
		$total = 0;
		$cash = 0;
		$card = 0;
		$direct = 0;
		$cheque = 0;

		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]->RECEIPT_PAYMENT_METHOD == "Cash") {
				$cash += $res[$i]->FH_AMOUNT;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Cheque") {
				$cheque += $res[$i]->FH_AMOUNT;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Direct Credit") {
				$direct += $res[$i]->FH_AMOUNT;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Credit / Debit Card") {
				$card += $res[$i]->FH_AMOUNT;
			}
			
			$total += $res[$i]->FH_AMOUNT;
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->TR_NO."</td>";	
			if($res[$i]->RECEIPT_CATEGORY_ID==1){
				$html .= "<td style='padding:5px;'>Inkind</td>";	
			}else{
				$html .= "<td style='padding:5px;'>Trust Receipt</td>";	
			}		
			$html .= "<td style='padding:5px;'>".$res[$i]->HB_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->FH_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PAYMENT_METHOD."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->FH_AMOUNT."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->PAYMENT_STATUS ."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_APPRX_AMT ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_DESC ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_QTY ." ".$res[$i]->IK_ITEM_UNIT ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->TR_PAYMENT_METHOD_NOTES ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->AUTHORISED_STATUS ."</td>";				
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'><b>Total</b></td><td style='padding:5px;text-align:right;'><b>".$total ."</b></td><td style='padding:5px;'></td></tr>";
		$html .="</tbody></table><br>";

		$html .= '<table><thead><tr><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th><th style="padding:5px;">DIRECT CREDIT</th><th style="padding:5px;">CREDIT/DEBIT CARD</th><th style="padding:5px;">TOTAL</th></tr></thead><tbody>';

		$html .= '<tr>';
		$html .= "<td style='padding:5px;text-align:right;'>".$cash."</td>";    
		$html .= "<td style='padding:5px;text-align:right;'>".$cheque."</td>";			
		$html .= "<td style='padding:5px;text-align:right;'>".$direct."</td>";			
		$html .= "<td style='padding:5px;text-align:right;'>".$card."</td>";
		$html .= "<td style='padding:5px;text-align:right;'>".($cash + $cheque + $direct + $card)."</td>";
		$html .= '</tr>';
		$html .="</tbody></table><br/>";
		
		$html .= '<br/><table><thead><tr><th colspan=8>Cancelled Receipts</th></tr><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Booking No.</th><th style="padding:5px;">Receipt Date</th><th style="padding:5px;">Receipt Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Payment Status</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res1); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res1[$i]->TR_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->HB_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->FH_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_PAYMENT_METHOD."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->FH_AMOUNT."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->PAYMENT_STATUS ."</td>";					
			$html .= '</tr>';
		}
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Trust Receipt Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else
			$pdf->Output('Trust Receipt Report ('.$_POST['dateField'].').pdf','D');
    }
 
	//DEITY RECEIPT PDF
	public function create_deityReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if($_POST['dateField'] != "" && $_POST['payMode'] == "All") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
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
						$queryString .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and RECEIPT_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= "RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and RECEIPT_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					} else {
						$queryString .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and RECEIPT_ACTIVE = 1"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
						$queryString1 .= " or RECEIPT_DATE='".$allDates1[$i]."' and RECEIPT_PAYMENT_METHOD='".$_POST['payMode']."' and RECEIPT_ACTIVE = 0"; // and RECEIPT_DEITY_ID = ".$_POST['deityId']."
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'RECEIPT_DATE' => $_POST['dateField'],'RECEIPT_ACTIVE' => 1); // 'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
				$conditionOne= array('RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'RECEIPT_DATE' => $_POST['dateField'],'RECEIPT_ACTIVE' => 0); // 'RECEIPT_DEITY_ID' => $_POST['deityId'] ,
			}
			$res = $this->obj_report->get_all_field_deity_receipt_excel($condition);
			$res1 = $this->obj_report->get_all_field_deity_receipt_excel($conditionOne);
		} 
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Deity Receipt Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px">Receipt No.</th><th style="padding:5px;">Receipt Date</th><th style="padding:5px;">Receipt Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Estimated Price</th><th style="padding:5px;">Description</th><th style="padding:5px;">Quantity</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Grand Total</th><th style="padding:5px;">Payment Notes</th><th>Cheque No.</th><th>Bank Name</th><th>Cheque Date</th><th style="padding:5px;">Payment Status</th></tr></thead><tbody>';
		
		$total = 0;
		$cash = 0;
		$card = 0;
		$direct = 0;
		$cheque = 0;

		for($i = 0; $i < sizeof($res); $i++)
		{
			$sum = ($res[$i]->RECEIPT_PRICE) + ($res[$i]->POSTAGE_PRICE);
			if($res[$i]->RECEIPT_PAYMENT_METHOD == "Cash") {
				$cash += $res[$i]->RECEIPT_PRICE;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Cheque") {
				$cheque += $res[$i]->RECEIPT_PRICE;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Direct Credit") {
				$direct += $res[$i]->RECEIPT_PRICE;
			} else if($res[$i]->RECEIPT_PAYMENT_METHOD == "Credit / Debit Card") {
				$card += $res[$i]->RECEIPT_PRICE;
			}
			
			$total += $res[$i]->RECEIPT_PRICE;
			$total += $res[$i]->POSTAGE_PRICE;
			
			if($res[$i]->POSTAGE_PRICE != ""){
				$postage += $res[$i]->POSTAGE_PRICE;
			} else{
				$postage = 0;
			}
			
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_NAME."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->DY_IK_APPRX_AMT."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]->DY_IK_ITEM_DESC."</td>";		
		
			// $html .= "<td style='padding:5px;'>".$res[$i]->DY_IK_ITEM_QTY."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->DY_IK_ITEM_QTY." ".$res[$i]->DY_IK_ITEM_UNIT."</td>";						

			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PAYMENT_METHOD."</td>";
			if($res[$i]->RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td style='padding:5px;'></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->RECEIPT_PRICE."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->POSTAGE_PRICE."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$sum."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PAYMENT_METHOD_NOTES ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->CHEQUE_NO ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->BANK_NAME ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->CHEQUE_DATE ."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->PAYMENT_STATUS ."</td>";	

			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'><td style='padding:5px;'><td style='padding:5px;'><b>Total</b></td><td style='padding:5px;text-align:right;'><b>".$total ."</b></td><td style='padding:5px;'></td></tr>";
		$html .="</tbody></table><br>";

		$html .= '<table><thead><tr><th style="padding:5px;">CASH</th><th style="padding:5px;">CHEQUE</th><th style="padding:5px;">DIRECT CREDIT</th><th style="padding:5px;">CREDIT/DEBIT CARD</th><th style="padding:5px;">POSTAGE</th><th style="padding:5px;">TOTAL</th></tr></thead><tbody>';

		$html .= '<tr>';
		$html .= "<td style='padding:5px;text-align:right;'>".$cash."</td>";    
		$html .= "<td style='padding:5px;text-align:right;'>".$cheque."</td>";			
		$html .= "<td style='padding:5px;text-align:right;'>".$direct."</td>";			
		$html .= "<td style='padding:5px;text-align:right;'>".$card."</td>";
		$html .= "<td style='padding:5px;text-align:right;'>".$postage."</td>";
		$html .= "<td style='padding:5px;text-align:right;'>".($cash + $cheque + $direct + $card + $postage)."</td>";
		$html .= '</tr>';
		$html .="</tbody></table><br/>";
		
		$html .= '<br/><table><thead><tr><th colspan=13>Cancelled Receipts</th></tr><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Receipt Date</th><th style="padding:5px;">Receipt Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Grand Total</th><th>Cheque No.</th><th>Bank Name</th><th>Cheque Date</th><th style="padding:5px;">Payment Status</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res1); $i++)
		{
			$sum = ($res1[$i]->RECEIPT_PRICE) + ($res1[$i]->POSTAGE_PRICE);
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->RECEIPT_PAYMENT_METHOD."</td>";
			if($res1[$i]->RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td style='padding:5px;'></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->RECEIPT_PRICE."</td>";		
			$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->POSTAGE_PRICE."</td>";		
			$html .= "<td style='padding:5px;text-align:right;'>".$sum."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->CHEQUE_NO ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->BANK_NAME ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->CHEQUE_DATE ."</td>";	
			$html .= "<td style='padding:5px;'>".$res1[$i]->PAYMENT_STATUS ."</td>";
								
			$html .= '</tr>';
		}
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		 
		$pdf->WriteHTML($stylesheet,1);
		$orient = 'L';
		if($orient == 'L') {
			$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>    Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    Authorized By: _______________</span>");

			$pdf->AddPage('L', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            20, // margin bottom
		            18, // margin header
		            12);
		}
		else {
			$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
			$pdf->AddPage('P', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            20, // margin bottom
		            18, // margin header
		            12);
		}
		
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Deity Receipt Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else
			$pdf->Output('Deity Receipt Report ('.$_POST['dateField'].').pdf','D');
    }
	
	public function create_trustAuctionItemPDF() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		$conditionOne = array('AIC_SEVA_DATE' => $date);
		$res = $this->obj_trust_report->get_auction_item_reports($conditionOne);
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Auction Item Report ".$date."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SL NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">CATEGORY</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">REFERENCE NO.</th><th style="padding:5px;">SAREE DETAILS</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_AIC_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_NUMBER."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ITEM_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_ITEM_DETAILS."</td>";		
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Saree Outward Report ('.$date.').pdf','D');
    }

	public function create_auctionItemPDF() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		$conditionOne = array('AIC_SEVA_DATE' => $date);
		$res = $this->obj_report->get_auction_item_reports($conditionOne);
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Auction Item Report ".$date."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SL NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">CATEGORY</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">REFERENCE NO.</th><th style="padding:5px;">SAREE DETAILS</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_AIC_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_NUMBER."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ITEM_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_ITEM_DETAILS."</td>";		
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Saree Outward Report ('.$date.').pdf','D');
    }
	
	//TRUST EVENT RECEIPT REPORT
	//Above code commented while merging interns code
    public function create_trustEventReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if($_POST['dateField'] != "" && $_POST['payMode'] == "All") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1";
						$queryString1 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=0 and TET_ACTIVE=1";
					} else {
						$queryString .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1";
						$queryString1 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=0 and TET_ACTIVE=1";
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $_POST['dateField'],'TET_RECEIPT_ACTIVE'=>1);
				$conditionOne= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $_POST['dateField'],'TET_RECEIPT_ACTIVE'=>0);
			}
			$res = $this->obj_trust_report->get_all_field_event_receipt_excel($condition);
			$res1 = $this->obj_trust_report->get_all_field_event_receipt_excel($conditionOne);
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						$queryString1 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=0 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
					} else {
						$queryString .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						$queryString1 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_ACTIVE=1 and TET_RECEIPT_ACTIVE=0 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'TET_RECEIPT_DATE' => $_POST['dateField'],'TET_RECEIPT_ACTIVE'=>1);
				$conditionOne= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => $_POST['payMode'],'TET_RECEIPT_DATE' => $_POST['dateField'],'TET_RECEIPT_ACTIVE'=>0);
			}
			$res = $this->obj_trust_report->get_all_field_event_receipt_excel($condition);
			$res1 = $this->obj_trust_report->get_all_field_event_receipt_excel($conditionOne);
		} 
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();

		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}

		$data['event'] = $this->obj_trust_events->getEvents();
		$_SESSION['event'] = $data['event']['TET_NAME'];
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center><br/>";
		$html .= "<center style='font-size:16px;margin-bottom:.3em;text-align:center;'><strong>".$_SESSION['event']."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Event Receipt Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">RT Date</th><th style="padding:5px;">RT Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Estimated Price</th><th style="padding:5px;">Description</th><th style="padding:5px;">Quantity</th><th style="padding:5px;">Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Total</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Status</th><th style="padding:5px;">Authorized Status</th>
			<th style="padding:5px;">Entered By</th></tr></thead><tbody>';
		
		$total = 0;
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$sum = ($res[$i]->TET_RECEIPT_PRICE) + ($res[$i]->POSTAGE_PRICE);
			$total += $res[$i]->TET_RECEIPT_PRICE;
			$total += $res[$i]->POSTAGE_PRICE;
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_NAME."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_APPRX_AMT."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_DESC."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_QTY." ".$res[$i]->IK_ITEM_UNIT."</td>";						
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_PAYMENT_METHOD."</td>";
			if($res[$i]->TET_RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td style='padding:5px;'></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TET_RECEIPT_PRICE."</td>";	
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->POSTAGE_PRICE."</td>";	
			$html .= "<td style='padding:5px;text-align:right;'>".$sum."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_PAYMENT_METHOD_NOTES."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->PAYMENT_STATUS ."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AUTHORISED_STATUS ."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_ISSUED_BY."</td>";
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;text-align:right;'><b>Total</b></td><td style='padding:5px;'><b>".$total ."</b></td></tr>";
		$html .="</tbody></table><br/>";
		
		$html .= '<br><table><thead><tr><th colspan=9>Cancelled Receipts</th></tr><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Receipt Date</th><th style="padding:5px;">Receipt Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Payment Status</th><th style="padding:5px;">Authorized Status</th><th style="padding:5px;">Entered By</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res1); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_PAYMENT_METHOD."</td>";
			if($res1[$i]->TET_RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td style='padding:5px;'></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->TET_RECEIPT_PRICE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->PAYMENT_STATUS ."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->AUTHORISED_STATUS ."</td>";		
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_ISSUED_BY."</td>";	
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->AddPage('L', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            20, // margin bottom
		            18, // margin header
		            12);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Event Receipt Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else
			$pdf->Output('Event Receipt Report ('.$_POST['dateField'].').pdf','D');
    }
	
  //FOR PRINT EVENT RECEIPT REPORT
  //Above code commented while merging interns code
	public function create_eventReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if($_POST['dateField'] != "" && $_POST['payMode'] == "All") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1";
						$queryString1 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=0 and ET_ACTIVE=1";
					} else {
						$queryString .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1";
						$queryString1 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=0 and ET_ACTIVE=1";
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
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
						$queryString .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						$queryString1 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_ACTIVE=1 and ET_RECEIPT_ACTIVE=0 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
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
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$data['event'] = $this->obj_events->getEvents();
		$_SESSION['event'] = $data['event']['ET_NAME'];
		$html .= "<center style='font-size:16px;margin-bottom:.3em;text-align:center;'><strong>".$_SESSION['event']."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Event Receipt Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">RT Date</th><th style="padding:5px;">RT Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Estimated Price</th><th style="padding:5px;">Description</th><th style="padding:5px;">Quantity</th><th style="padding:5px;">Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Grand Total</th><th style="padding:5px;">Status</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Authorized Status</th><th style="padding:5px;">Entered By</th></tr></thead><tbody>';
		$total = 0;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$sum = ($res[$i]->ET_RECEIPT_PRICE) + ($res[$i]->POSTAGE_PRICE);
			$total += $res[$i]->ET_RECEIPT_PRICE;
			$total += $res[$i]->POSTAGE_PRICE;
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_NAME."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_APPRX_AMT."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_DESC."</td>";	
			// $html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_QTY."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_QTY." ".$res[$i]->IK_ITEM_UNIT."</td>";						

			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_PAYMENT_METHOD."</td>";
			if($res[$i]->ET_RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td style='padding:5px;'></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->ET_RECEIPT_PRICE."</td>";	
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->POSTAGE_PRICE."</td>";	
			$html .= "<td style='padding:5px;text-align:right;'>".$sum."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->PAYMENT_STATUS ."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_PAYMENT_METHOD_NOTES ."</td>";				
			$html .= "<td style='padding:5px;'>".$res[$i]->AUTHORISED_STATUS ."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_ISSUED_BY ."</td>";		
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'><td style='padding:5px;'><td style='padding:5px;'>Total<b></b></td><td style='padding:5px;text-align:right;'><b>".$total."</b></td><td style='padding:5px;'></td></tr>";
		$html .="</tbody></table><br/>";
		
		$html .= '<br><table><thead><tr><th colspan=9>Cancelled Receipts</th></tr><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">RT Date</th><th style="padding:5px;">RT Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Total</th><th style="padding:5px;">Status</th><th style="padding:5px;">Authorized Status</th><th style="padding:5px;">Entered By</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res1); $i++)
		{
			$sum = ($res1[$i]->ET_RECEIPT_PRICE) + ($res1[$i]->POSTAGE_PRICE);
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_PAYMENT_METHOD."</td>";
			if($res1[$i]->ET_RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td style='padding:5px;'></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->ET_RECEIPT_PRICE."</td>";		
			$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->POSTAGE_PRICE."</td>";		
			$html .= "<td style='padding:5px;text-align:right;'>".$sum."</td>";		
			$html .= "<td style='padding:5px;'>".$res1[$i]->PAYMENT_STATUS ."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->AUTHORISED_STATUS ."</td>";	
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_ISSUED_BY ."</td>";			
			$html .= '</tr>';
		}
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Event Receipt Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else
			$pdf->Output('Event Receipt Report ('.$_POST['dateField'].').pdf','D');
    }
	

	public function create_sevaReceiptpdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
				$condition = array('ET_RECEIPT_ACTIVE' =>1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => $this->input->post('dateField'));
				$res = $this->obj_report->get_all_field_event_seva_excel($condition);
			} else {
				$condition = array('ET_RECEIPT_ACTIVE' =>1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => $this->input->post('dateField'), 'EVENT_SEVA_OFFERED.ET_SO_SEVA_ID' => $this->input->post('SId'));
				$res = $this->obj_report->get_all_field_event_seva_excel($condition);
			}
		}
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Event Sevas Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVA</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">RECEIPT NO.</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".$j."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_SO_SEVA_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_NAME."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_PHONE."</td>";				
			//if($res[$i]->ET_RECEIPT_RASHI != "" && $res[$i]->ET_RECEIPT_NAKSHATRA != "") {
				//$html .= '<td>'. $res[$i]->ET_RECEIPT_RASHI . ' ('. $res[$i]->ET_RECEIPT_NAKSHATRA . ") ". "</td>";
			//} else {
				//$html .= '<td></td>';
			//}
			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_NO."</td>";
			$html .= '</tr>';
			$j++;
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Event Sevas Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else
			$pdf->Output('Event Sevas Report ('.$_POST['dateField'].').pdf','D');
    }
	
	//For Print Auction Report
	public function create_auctionSession() { 
		$_SESSION['paymentMethod'] = $_POST['payMode'];
		echo 1;
	}

	public function create_trustAuctionSession() { 
		$_SESSION['paymentMethod'] = $_POST['payMode'];
		echo 1;
	}
	
	//AUCTION REPORT PRINT
	public function create_trustAuctionReportPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		$date = date('d-m-Y');
		
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
			$res = $this->obj_trust_report->get_auction_report_excel($conditionOne);
		} else {
			$conditionOne = array('AR_PAYMENT_MODE' => $paymentMode);
			$res = $this->obj_trust_report->get_auction_report_excel($conditionOne);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();  
		unset($_SESSION['paymentMethod']);
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Auction Report ".$date."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI NO.</th><th style="padding:5px;">BID REF. NO.</th><th style="padding:5px;">ITEM REF NO.</th><th style="padding:5px;">ITEM DETAILS</th><th style="padding:5px;">BIDDER DETAILS</th><th style="padding:5px;">PAYMENT MODE</th><th style="padding:5px;">BID PRICE</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res[$i]->BID_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ITEM_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AR_ITEM_DETAILS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->BIL_ITEM_DETAILS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AR_PAYMENT_MODE."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->AR_BID_PRICE."</td>";					
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		
		//$html .="<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Auction Report ('.$date.').pdf','I');
    }

	//AUCTION REPORT PRINT
	public function create_auctionReportPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		$date = date('d-m-y');
		
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
		unset($_SESSION['paymentMethod']);
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Auction Report ".$date."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI NO.</th><th style="padding:5px;">BID REF. NO.</th><th style="padding:5px;">ITEM REF NO.</th><th style="padding:5px;">ITEM DETAILS</th><th style="padding:5px;">BIDDER DETAILS</th><th style="padding:5px;">PAYMENT MODE</th><th style="padding:5px;">BID PRICE</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res[$i]->BID_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ITEM_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AR_ITEM_DETAILS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->BIL_ITEM_DETAILS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AR_PAYMENT_MODE."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->AR_BID_PRICE."</td>";					
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		
		//$html .="<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Auction Report ('.$date.').pdf','I');
    }
	
	//FOR PRINT
	public function create_eodReceiptSession() { 
		$_SESSION['date'] = $_POST['date'];
		echo 1;
	}
	
	//FOR EVENT PRINT
	public function create_eventEodReceiptSession() { 
		$_SESSION['date'] = $_POST['date'];
		echo 1;
	}
	
	//FOR TRUST EVENT PRINT
	public function create_trustEventEodReceiptSession() { 
		$_SESSION['date'] = $_POST['date'];
		echo 1;
	}
	
	//FOR TRUST PRINT
	public function create_trustEodReceiptSession() { 
		$_SESSION['date'] = $_POST['date'];
		echo 1;
	}

	//TRUST RECEIPT PRINT
	public function create_trustEodReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$today = date("F j, Y, g:i a");  
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$html .= "<center><strong>Trust EOD Report ".$_SESSION['date']."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">User Details</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Direct Credit</th><th style="padding:5px;">Credit/ Debit Card</th><th style="padding:5px;">Grand Total</th></tr></thead><tbody>';
		$sql = "SELECT `RECEIPT_DATE`,`ENTERED_BY_NAME`,`ENTERED_BY`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `FH_AMOUNT` ELSE '' END ) AS Cash , SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `FH_AMOUNT` ELSE '' END ) AS Cheque, SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `FH_AMOUNT` ELSE '' END ) AS 'Card', SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `FH_AMOUNT` ELSE '' END ) AS 'directCredit', SUM(FH_AMOUNT) AS TotalAmount, SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `FH_AMOUNT` ELSE '' END ) AS 'AUTHORISED_STATUS', USER_TYPE FROM TRUST_RECEIPT LEFT JOIN `USERS` ON `TRUST_RECEIPT`.EOD_CONFIRMED_BY_ID = `USERS`.USER_ID where `RECEIPT_DATE`= '".$_SESSION['date']."' and TR_ACTIVE = 1 GROUP BY `ENTERED_BY_NAME`";
		
		$query = $this->db->query($sql);
		$eod_receipt_report = $query->result();

		unset($_SESSION['date']);
		$Cash = 0; $TotalAmount= 0; $Cheque = 0; $directCredit = 0; $Card = 0;

		foreach($eod_receipt_report as $result)
		{
			$Cash += $result->Cash;
			$Cheque += $result->Cheque;
			$directCredit += $result->directCredit;
			$Card += $result->Card;
			$TotalAmount += $result->TotalAmount;

			$html .= '<tr>';   
			$html .= "<td style='padding:5px;'>".$result->ENTERED_BY_NAME."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Cash."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Cheque."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$result->directCredit."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Card."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->TotalAmount ."</td>";				
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'><b>Total</b></td><td style='padding:5px;text-align:right;'><b>$Cash</b></td><td style='padding:5px;text-align:right;'><b>$Cheque</b></td><td style='padding:5px;text-align:right;'><b>$directCredit</b></td><td style='padding:5px;text-align:right;'><b>$Card</b></td><td style='padding:5px;text-align:right;'><b>$TotalAmount</b></td></tr>";
		$html .="</tbody></table><br>";
		$html .= "<b>Entered By: </b><br/><br/>";
		
		foreach($eod_receipt_report as $result) {
			$html.= "<div style='float: left; width: 28%;'>Name: $result->ENTERED_BY_NAME</div>";
			$html.= "<div style='float: right; width: 54%;'>Signature: ____________</div><br/><br/>";
		}
	
		$html .= "<p style='clear:both;'></p>";
		$html .= "<div style='float: left; width: 28%;'><b>Verified By: </b></div><div style='float: right; width: 54%;'><b>Authorized By:</b> </div><br/><br/>";
		
		$html.= "<div style='float: left; width: 28%;'>Signature: ____________</div>";
		$html.= "<div style='float: right; width: 54%;'>Signature: ____________</div><br/><br/>";

		$html.= "<div style='float: left; width: 28%;clear:both;'>Name: $result->EOD_CONFIRMED_BY_NAME</div>";
		$html.= "<div style='float: right; width: 54%;'>Name: ____________</div><br/><br/>";
		
		$html.= "<div style='float: left; width: 28%;clear:both;'>Designation: $result->USER_TYPE</div>";
		$html.= "<div style='float: right; width: 54%;'>Designation: ____________</div><br/><br/>";

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		//$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		//$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
			
			$pdf->Output("Trust Receipt Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else {
			$pdf->Output('Trust Receipt Report ('.$_POST['dateField'].').pdf','I');
		}
    }
	
	//DEITY RECEIPT PRINT
	public function create_eodReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>EOD Report ".$_SESSION['date']."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table width="100%"><thead><tr><th style="padding:5px;">User Details</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Direct Credit</th><th style="padding:5px;">Credit/ Debit Card</th><th style="padding:5px;">Grand Total</th></tr></thead><tbody>';
		$sql = "SELECT `RECEIPT_DATE`,`RECEIPT_ISSUED_BY`,`RECEIPT_ISSUED_BY_ID`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, (SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'Card',(SUM( CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'directCredit',
		(SUM(RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount, SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `RECEIPT_PRICE` ELSE '' END ) AS 'AUTHORISED_STATUS', USER_TYPE FROM DEITY_RECEIPT LEFT JOIN `USERS` ON `DEITY_RECEIPT`.EOD_CONFIRMED_BY_ID = `USERS`.USER_ID where `RECEIPT_DATE`= '".$_SESSION['date']."' and RECEIPT_CATEGORY_ID != 5 and RECEIPT_ACTIVE = 1 GROUP BY `RECEIPT_ISSUED_BY`";
		
		$query = $this->db->query($sql);
		$eod_receipt_report = $query->result();

		unset($_SESSION['date']);
		$Cash = 0; $TotalAmount= 0; $Cheque = 0; $directCredit = 0; $Card = 0;

		foreach($eod_receipt_report as $result)
		{
			$Cash += $result->Cash;
			$Cheque += $result->Cheque;
			$directCredit += $result->directCredit;
			$Card += $result->Card;
			$TotalAmount += $result->TotalAmount;

			$html .= '<tr>';   
			$html .= "<td style='padding:5px;'>".$result->RECEIPT_ISSUED_BY."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Cash."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Cheque."</td>";			
	        $html .= "<td style='padding:5px;text-align:right;'>".$result->directCredit."</td>";	
     		$html .= "<td style='padding:5px;text-align:right;'>".$result->Card."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->TotalAmount ."</td>";				
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'><b>Total</b></td><td style='padding:5px;text-align:right;'><b>$Cash</b></td><td style='padding:5px;text-align:right;'><b>$Cheque</b></td><td style='padding:5px;text-align:right;'><b>$directCredit</b></td><td style='padding:5px;text-align:right;'><b>$Card</b></td><td style='padding:5px;text-align:right;'><b>$TotalAmount</b></td></tr>";
		$html .="</tbody></table><br>";
		$html .= "<b>Entered By: </b><br/><br/>";
		
		foreach($eod_receipt_report as $result) {
			$html.= "<div style='float: left; width: 38%;'>Name: $result->RECEIPT_ISSUED_BY</div>";
			$html.= "<div style='float: right; width: 45%;'>Signature: ____________</div><br/><br/>";
		}
	
		$html .= "<p style='clear:both;'></p>";
		$html .= "<div style='float: left; width: 38%;'><b>Verified By: </b></div><div style='float: right; width: 45%;'><b>Authorized By:</b> </div><br/><br/>";
		
		$html.= "<div style='float: left; width: 38%;'>Signature: ____________</div>";
		$html.= "<div style='float: right; width: 45%;'>Signature: ____________</div><br/><br/>";

		$html.= "<div style='float: left; width: 38%;clear:both;'>Name: $result->EOD_CONFIRMED_BY_NAME</div>";
		$html.= "<div style='float: right; width: 45%;'>Name: ____________</div><br/><br/>";
		
		$html.= "<div style='float: left; width: 38%;clear:both;'>Designation: $result->USER_TYPE</div>";
		$html.= "<div style='float: right; width: 45%;'>Designation: ____________</div><br/><br/>";

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		//$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");

		$pdf->AddPage('L', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            20, // margin bottom
		            18, // margin header
		            12);
		$pdf->WriteHTML($html); // write the HTML into the PDF
		//$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
			
			$pdf->Output("Deity Receipt Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else {
			$pdf->Output('Deity Receipt Report ('.$_POST['dateField'].').pdf','I');
		}
    }

	//TRUST EVENT RECEIPT PRINT
	public function create_trustEventEodReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$today = date("F j, Y, g:i a");
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";  
		$html .= "<center><strong>EOD Report ".$_SESSION['date']."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">User Details</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Direct Credit</th><th style="padding:5px;">Credit/ Debit Card</th><th style="padding:5px;">Grand Total</th></tr></thead><tbody>';
		
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		
		$sql = "SELECT `TET_RECEIPT_DATE`,`TET_RECEIPT_ISSUED_BY`,`TET_RECEIPT_ISSUED_BY_ID`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, (SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash ,(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque,(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'Card',(SUM( CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `TET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `TET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'directCredit',(SUM(TET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount, SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `TET_RECEIPT_PRICE` ELSE '' END ) AS 'AUTHORISED_STATUS' , USER_TYPE FROM TRUST_EVENT_RECEIPT LEFT JOIN `USERS` ON `TRUST_EVENT_RECEIPT`.EOD_CONFIRMED_BY_ID = `USERS`.USER_ID INNER JOIN TRUST_EVENT ON TRUST_EVENT_RECEIPT.RECEIPT_TET_ID = TRUST_EVENT.TET_ID where TET_ACTIVE = 1 and `TET_RECEIPT_DATE`= '".$_SESSION['date']."' and TET_RECEIPT_CATEGORY_ID != 5 and TET_RECEIPT_ACTIVE = 1 and STR_TO_DATE(TET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."' GROUP BY `TET_RECEIPT_ISSUED_BY`";
		
		$query = $this->db->query($sql);
		$eod_receipt_report = $query->result();

		unset($_SESSION['date']);
		$Cash = 0; $TotalAmount= 0; $Cheque = 0; $directCredit = 0; $Card = 0;

		foreach($eod_receipt_report as $result)
		{
			$Cash += $result->Cash;
			$Cheque += $result->Cheque;
			$directCredit += $result->directCredit;
			$Card += $result->Card;
			$TotalAmount += $result->TotalAmount;
			$html .= '<tr>';   
			$html .= "<td style='padding:5px;'>".$result->TET_RECEIPT_ISSUED_BY."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Cash."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Cheque."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->directCredit."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Card."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->TotalAmount ."</td>";				
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'><b>Total</b></td><td style='padding:5px;text-align:right;'><b>$Cash</b></td><td style='padding:5px;text-align:right;'><b>$Cheque</b></td><td style='padding:5px;text-align:right;'><b>$directCredit</b></td><td style='padding:5px;text-align:right;'><b>$Card</b></td><td style='padding:5px;text-align:right;'><b>$TotalAmount</b></td></tr>";
		$html .="</tbody></table><br>";
		$html .= "<b>Entered By: </b><br/><br/>";
		
		foreach($eod_receipt_report as $result) {
			$html.= "<div style='float: left; width: 28%;'>Name: $result->TET_RECEIPT_ISSUED_BY</div>";
			$html.= "<div style='float: right; width: 54%;'>Signature: ____________</div><br/><br/>";
		}
	
		$html .= "<p style='clear:both;'></p>";
		$html .= "<div style='float: left; width: 28%;'><b>Verified By: </b></div><div style='float: right; width: 54%;'><b>Authorized By:</b> </div><br/><br/>";
		
		$html.= "<div style='float: left; width: 28%;'>Signature: ____________</div>";
		$html.= "<div style='float: right; width: 54%;'>Signature: ____________</div><br/><br/>";

		$html.= "<div style='float: left; width: 28%;clear:both;'>Name: $result->EOD_CONFIRMED_BY_NAME</div>";
		$html.= "<div style='float: right; width: 54%;'>Name: ____________</div><br/><br/>";
		
		$html.= "<div style='float: left; width: 28%;clear:both;'>Designation: $result->USER_TYPE</div>";
		$html.= "<div style='float: right; width: 54%;'>Designation: ____________</div><br/><br/>";

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html); // write the HTML into the PDF
		
		if(@$radioOpt == "multiDate") {
			$fromDate = $_SESSION['fromDate'];
			$toDate = $_SESSION['toDate'];
			
			$pdf->Output("Event Receipt Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else {
			$pdf->Output('Event Receipt Report ('.$_POST['dateField'].').pdf','I');
		}
    }
	
	//EVENT RECEIPT PRINT
	public function create_eventEodReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."
		</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>EOD Report ".$_SESSION['date']."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">User Details</th><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Direct Credit</th><th style="padding:5px;">Credit/ Debit Card</th><th style="padding:5px;">Grand Total</th></tr></thead><tbody>';
		$this->db->select()->from('FINANCIAL_YEAR');
		$query = $this->db->get();
		$finYear = $query->first_row();
		$fDate = (($finYear->MONTH_IN_YEAR) - 1).'-04-01';
		$tDate = ($finYear->MONTH_IN_YEAR).'-03-31';
		$sql = "SELECT `ET_RECEIPT_DATE`,`ET_RECEIPT_ISSUED_BY`,`ET_RECEIPT_ISSUED_BY_ID`, EOD_CONFIRMED_DATE_TIME, EOD_CONFIRMED_BY_NAME, (SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cash' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cash , (SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Cheque' THEN `POSTAGE_PRICE` ELSE '' END)) AS Cheque, (SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Credit / Debit Card' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'Card', (SUM( CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `ET_RECEIPT_PRICE` ELSE '' END ) + SUM(CASE WHEN `ET_RECEIPT_PAYMENT_METHOD` = 'Direct Credit' THEN `POSTAGE_PRICE` ELSE '' END)) AS 'directCredit', (SUM(ET_RECEIPT_PRICE) + SUM(POSTAGE_PRICE)) AS TotalAmount, SUM( CASE WHEN `AUTHORISED_STATUS` = 'No' THEN `ET_RECEIPT_PRICE` ELSE '' END ) AS 'AUTHORISED_STATUS', USER_TYPE FROM EVENT_RECEIPT LEFT JOIN `USERS` ON `EVENT_RECEIPT`.EOD_CONFIRMED_BY_ID = `USERS`.USER_ID INNER JOIN EVENT ON EVENT_RECEIPT.RECEIPT_ET_ID = EVENT.ET_ID where ET_ACTIVE = 1 and `ET_RECEIPT_DATE`= '".$_SESSION['date']."' and ET_RECEIPT_CATEGORY_ID != 5 and ET_RECEIPT_ACTIVE = 1 and STR_TO_DATE(ET_RECEIPT_DATE,'%d-%m-%Y') BETWEEN '".$fDate."' AND '".$tDate."' GROUP BY `ET_RECEIPT_ISSUED_BY`";
		$query = $this->db->query($sql);
		$eod_receipt_report = $query->result();
     	unset($_SESSION['date']);
		$Cash = 0; $TotalAmount= 0; $Cheque = 0; $directCredit = 0; $Card = 0;
		foreach($eod_receipt_report as $result)
		{
			$Cash += $result->Cash;
			$Cheque += $result->Cheque;
			$directCredit += $result->directCredit;
			$Card += $result->Card;
			$TotalAmount += $result->TotalAmount;

			$html .= '<tr>';   
			$html .= "<td style='padding:5px;'>".$result->ET_RECEIPT_ISSUED_BY."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Cash."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Cheque."</td>";
            $html .= "<td style='padding:5px;text-align:right;'>".$result->directCredit."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->Card."</td>";			
			$html .= "<td style='padding:5px;text-align:right;'>".$result->TotalAmount ."</td>";				
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'><b>Total</b></td><td style='padding:5px;text-align:right;'><b>$Cash</b></td><td style='padding:5px;text-align:right;'><b>$Cheque</b></td><td style='padding:5px;text-align:right;'><b>$directCredit</b></td><td style='padding:5px;text-align:right;'><b>$Card</b></td><td style='padding:5px;text-align:right;'><b>$TotalAmount</b></td></tr>";
		$html .="</tbody></table><br>";
		$html .= "<b>Entered By: </b><br/><br/>";
		
		foreach($eod_receipt_report as $result) {
			$html.= "<div style='float: left; width: 28%;'>Name: $result->ET_RECEIPT_ISSUED_BY</div>";
			$html.= "<div style='float: right; width: 54%;'>Signature: ____________</div><br/><br/>";
		}
	
    	$html .= "<p style='clear:both;'></p>";
		$html .= "<div style='float: left; width: 28%;'><b>Verified By:</b></div><div style='float: right; width: 54%;'><b>Authorized By:</b> </div><br/><br/>";
		$html.= "<div style='float: left; width: 28%;'>Signature: ____________</div>";
		$html.= "<div style='float: right; width: 54%;'>Signature: ____________</div><br/><br/>";
		$html.= "<div style='float: left; width: 28%;clear:both;'>Name: $result->EOD_CONFIRMED_BY_NAME</div>";
		$html.= "<div style='float: right; width: 54%;'>Name: ____________</div><br/><br/>";
		$html.= "<div style='float: left; width: 28%;clear:both;'>Designation: $result->USER_TYPE</div>";
		$html.= "<div style='float: right; width: 54%;'>Designation: ____________</div><br/><br/>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		//$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		//$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
		$fromDate = $_SESSION['fromDate'];
		$toDate = $_SESSION['toDate'];
		
		$pdf->Output("Event Receipt Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else {
			$pdf->Output('Event Receipt Report ('.$_POST['dateField'].').pdf','I');
		}
    }
	
	//for print
	public function create_eventReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['payMode'] = $_POST['payMode'];
		echo 1;
	}
	
	//FOR PRINT TRUST EVENT RECEIPT REPORT
	public function create_trustEventReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['payMode'] = $_POST['payMode'];
		echo 1;
	}
	
	//Above code commented while merging interns code
	public function create_eventReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if($_SESSION['dateField'] != "" && $_SESSION['payMode'] == "All") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1  and ET_ACTIVE=1";
						$queryString1 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=0  and ET_ACTIVE=1";
					} else {
						$queryString .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1  and ET_ACTIVE=1";
						$queryString1 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=0  and ET_ACTIVE=1";
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $_SESSION['dateField'],'ET_RECEIPT_ACTIVE'=>1);
				$conditionOne= array('ET_ACTIVE' => 1 ,'ET_RECEIPT_DATE' => $_SESSION['dateField'],'ET_RECEIPT_ACTIVE'=>0);
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
						$queryString .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						$queryString1 .= "ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=0 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
					} else {
						$queryString .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=1 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						$queryString1 .= " or ET_RECEIPT_DATE='".$allDates1[$i]."' and ET_RECEIPT_ACTIVE=0 and ET_ACTIVE=1 and ET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => $_SESSION['payMode'],'ET_RECEIPT_DATE' => $_SESSION['dateField'],'ET_RECEIPT_ACTIVE'=>1);
				$conditionOne= array('ET_ACTIVE' => 1 ,'ET_RECEIPT_PAYMENT_METHOD' => $_SESSION['payMode'],'ET_RECEIPT_DATE' => $_SESSION['dateField'],'ET_RECEIPT_ACTIVE'=>0);
			}
			$res = $this->obj_report->get_all_field_event_receipt_excel($condition);
			$res1 = $this->obj_report->get_all_field_event_receipt_excel($conditionOne);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		unset($_SESSION['dateField']);
		unset($_SESSION['payMode']);
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		
		$data['event'] = $this->obj_events->getEvents();
		$_SESSION['event'] = $data['event']['ET_NAME'];
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center><br/>";
		$html .= "<center style='font-size:16px;margin-bottom:.3em;text-align:center;'><strong>".$_SESSION['event']."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Event Receipt Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">RT Date</th><th style="padding:5px;">RT Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Estimated Price</th><th style="padding:5px;">Description</th><th style="padding:5px;">Quantity</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Total</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Status</th><th style="padding:5px;">Authorized Status</th><th style="padding:5px;">Entered By</th></tr></thead><tbody>';
		
		$total = 0;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$sum = ($res[$i]->ET_RECEIPT_PRICE) + ($res[$i]->POSTAGE_PRICE);
			$total += $res[$i]->ET_RECEIPT_PRICE;
			$total += $res[$i]->POSTAGE_PRICE;
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_NAME."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_APPRX_AMT."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_DESC."</td>";
			// $html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_QTY."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_QTY." ".$res[$i]->IK_ITEM_UNIT."</td>";						

			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_PAYMENT_METHOD."</td>";			
			if($res[$i]->ET_RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->ET_RECEIPT_PRICE."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->POSTAGE_PRICE."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$sum."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_PAYMENT_METHOD_NOTES."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->PAYMENT_STATUS ."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AUTHORISED_STATUS ."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_ISSUED_BY ."</td>";			
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'><td style='padding:5px;'><td style='padding:5px;'><b>Total</b></td><td style='padding:5px;text-align:right;'><b>".$total ."</b></td><td style='padding:5px;'></td></tr>";
		$html .="</tbody></table><br/>";
		
		$html .= '<table><thead><tr><th colspan=9>Cancelled Receipts</th></tr><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">RT Date</th><th style="padding:5px;">RT Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Total</th><th style="padding:5px;">Status</th><th style="padding:5px;">Authorized Status</th><th style="padding:5px;">Entered By</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res1); $i++)
		{
			$sum = ($res1[$i]->ET_RECEIPT_PRICE) + ($res1[$i]->POSTAGE_PRICE);
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_PAYMENT_METHOD."</td>";			
			if($res1[$i]->ET_RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->ET_RECEIPT_PRICE."</td>";	
			$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->POSTAGE_PRICE."</td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$sum."</td>";
			$html .= "<td style='padding:5px;'>".$res1[$i]->PAYMENT_STATUS ."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->AUTHORISED_STATUS ."</td>";	
			$html .= "<td style='padding:5px;'>".$res1[$i]->ET_RECEIPT_ISSUED_BY ."</td>";			
			$html .= '</tr>';
		}
		$html .="</tbody></table>";
		
		//$html .="<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Event Receipt Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Event Receipt Report ('.$_POST['dateField'].').pdf','I');
    }
	
	//FOR PRINT EVENT RECEIPT REPORT
    // above code commented while merging interns code 
    public function create_trustEventReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if($_SESSION['dateField'] != "" && $_SESSION['payMode'] == "All") {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1  and TET_ACTIVE=1";
						$queryString1 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=0  and TET_ACTIVE=1";
					} else {
						$queryString .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1  and TET_ACTIVE=1";
						$queryString1 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=0  and TET_ACTIVE=1";
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $_SESSION['dateField'],'TET_RECEIPT_ACTIVE'=>1);
				$conditionOne= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_DATE' => $_SESSION['dateField'],'TET_RECEIPT_ACTIVE'=>0);
			}
			$res = $this->obj_trust_report->get_all_field_event_receipt_excel($condition);
			$res1 = $this->obj_trust_report->get_all_field_event_receipt_excel($conditionOne);
		} else {
			if(@$radioOpt == "multiDate") {
				$allDates1 = explode("|",$allDates);
				$queryString = "";
				$queryString1 = "";
				for($i = 0; $i < count($allDates1); ++$i) {
					if($i == 0) {
						$queryString .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						$queryString1 .= "TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=0 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
					} else {
						$queryString .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=1 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
						$queryString1 .= " or TET_RECEIPT_DATE='".$allDates1[$i]."' and TET_RECEIPT_ACTIVE=0 and TET_ACTIVE=1 and TET_RECEIPT_PAYMENT_METHOD='".$paymentMode."'";
					}
				}
				$condition= $queryString;
				$conditionOne= $queryString1;
			} else {
				$condition= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => $_SESSION['payMode'],'TET_RECEIPT_DATE' => $_SESSION['dateField'],'TET_RECEIPT_ACTIVE'=>1);
				$conditionOne= array('TET_ACTIVE' => 1 ,'TET_RECEIPT_PAYMENT_METHOD' => $_SESSION['payMode'],'TET_RECEIPT_DATE' => $_SESSION['dateField'],'TET_RECEIPT_ACTIVE'=>0);
			}
			$res = $this->obj_trust_report->get_all_field_event_receipt_excel($condition);
			$res1 = $this->obj_trust_report->get_all_field_event_receipt_excel($conditionOne);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		unset($_SESSION['dateField']);
		unset($_SESSION['payMode']);
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		$data['event'] = $this->obj_trust_events->getEvents();
		$_SESSION['event'] = $data['event']['TET_NAME'];
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center><br/>";
		$html .= "<center style='font-size:16px;margin-bottom:.3em;text-align:center;'><strong>".$_SESSION['event']."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Event Receipt Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">RT Date</th><th style="padding:5px;">RT Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Estimated Price</th><th style="padding:5px;">Description</th><th style="padding:5px;">Quantity</th><th style="padding:5px;">Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Total</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;"> Status</th><th style="padding:5px;">Authorized Status</th><th style="padding:5px;">Entered By</th></tr></thead><tbody>';
		$total = 0;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$sum = ($res[$i]->TET_RECEIPT_PRICE) + ($res[$i]->POSTAGE_PRICE);
			$total += $res[$i]->TET_RECEIPT_PRICE;
			$total += $res[$i]->POSTAGE_PRICE;
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_NAME."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_APPRX_AMT."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_DESC."</td>";
			
				
			//$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_QTY."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->IK_ITEM_QTY." ".$res[$i]->IK_ITEM_UNIT."</td>";						

			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_PAYMENT_METHOD."</td>";			
			if($res[$i]->TET_RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->TET_RECEIPT_PRICE."</td>";		
			$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->POSTAGE_PRICE."</td>";		
			$html .= "<td style='padding:5px;text-align:right;'>".$sum."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_PAYMENT_METHOD_NOTES."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->PAYMENT_STATUS ."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AUTHORISED_STATUS ."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_ISSUED_BY ."</td>";		
			$html .= '</tr>';
		}
		$html .= "<tr><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'><td style='padding:5px;'><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'><b>Total</b></td><td style='padding:5px;text-align:right;'><b>".$total ."</b></td><td style='padding:5px;'></td></tr>";
		$html .="</tbody></table><br/>";
		
		$html .= '<table><thead><tr><th colspan=9>Cancelled Receipts</th></tr><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">RT Date</th><th style="padding:5px;">RT Type</th><th style="padding:5px;">Name</th><th style="padding:5px;">Mode</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Payment Status</th><th style="padding:5px;">Authorized Status</th><th style="padding:5px;">Entered By</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res1); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_CATEGORY_TYPE."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_PAYMENT_METHOD."</td>";			
			if($res1[$i]->TET_RECEIPT_CATEGORY_TYPE == "Inkind")
				$html .= "<td></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res1[$i]->TET_RECEIPT_PRICE."</td>";		
			$html .= "<td style='padding:5px;'>".$res1[$i]->PAYMENT_STATUS ."</td>";			
			$html .= "<td style='padding:5px;'>".$res1[$i]->AUTHORISED_STATUS ."</td>";
			$html .= "<td style='padding:5px;'>".$res1[$i]->TET_RECEIPT_ISSUED_BY ."</td>";			
			$html .= '</tr>';
		}
		$html .="</tbody></table>";
		
		//$html .="<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->AddPage('L', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            20, // margin bottom
		            18, // margin header
		            12);
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Event Receipt Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Event Receipt Report ('.$_POST['dateField'].').pdf','I');
    }
	
	//for print
	public function create_auctionItemSession() { 
		$_SESSION['date'] = $_POST['date'];
		echo 1;
	}

	//for print
	public function create_trustAuctionItemSession() { 
		$_SESSION['date'] = $_POST['date'];
		echo 1;
	}
	
	public function create_trustAuctionItemPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		if(isset($_POST['date'])) {
			$date = @$_POST['date'];
		} else {
			$date = $_SESSION['date'];
		}
		
		$conditionOne = array('AIC_SEVA_DATE' => $date);
		$res = $this->obj_trust_report->get_auction_item_reports($conditionOne);
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Auction Item Report ".$date."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SL NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">CATEGORY</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">REFERENCE NO.</th><th style="padding:5px;">SAREE DETAILS</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_AIC_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_NUMBER."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ITEM_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_ITEM_DETAILS."</td>";		
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Saree Outward Report ('.$date.').pdf','I');
	}

	public function create_auctionItemPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		if(isset($_POST['date'])) {
			$date = @$_POST['date'];
		} else {
			$date = $_SESSION['date'];
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$conditionOne = array('AIC_SEVA_DATE' => $date);
		$res = $this->obj_report->get_auction_item_reports($conditionOne);
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Auction Item Report ".$date."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SL NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">CATEGORY</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">REFERENCE NO.</th><th style="padding:5px;">SAREE DETAILS</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_AIC_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_NUMBER."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ITEM_REF_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->AIL_ITEM_DETAILS."</td>";		
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Saree Outward Report ('.$date.').pdf','I');
	}
	
	public function create_JeernodharaPdf() {
	
 		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		//$date=date('d-m-Y');
		
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
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_POST['dateField'].")";
		}
		
		//$res = $this->obj_receipt->get_daily_reportPdf($date);
		$today = date("F j, Y, g:i a");  	
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>Suthu Pauli Jeernodhara Samithi</strong></center>";
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$html .= "<center><strong>Jeernodhara Daily Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">S No.</th><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Receipt Date</th><th style="padding:5px;">Name</th><th style="padding:5px;">Phone</th><th style="padding:5px;">Address</th><th style="padding:5px;">Receipt Category</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Payment method</th><th style="padding:5px;">Payment Notes</th>><th>Cheque No.</th><th>Bank Name</th><th>Cheque Date</th></tr></thead><tbody>';
		
		$totAmount = 0;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_NO."</td>";
$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_DATE."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PHONE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_ADDRESS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_CATEGORY_TYPE."</td>";	
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PRICE."</td>";
			$totAmount = $totAmount + $res[$i]->RECEIPT_PRICE;
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PAYMENT_METHOD."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->RECEIPT_PAYMENT_METHOD_NOTES."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->CHEQUE_NO."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->BANK_NAME."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->CHEQUE_DATE."</td>";			
			$html .= '</tr>'; 
		}
		/* Joel 19-01-2020 line for adding total*/
		$html .= "<tr><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td><td style='padding:5px;'></td>";  
		$html .= "<td style='padding:5px;'>TOTAL</td><td style='padding:5px;'>".$totAmount."</td>";
		$html .= "<td style='padding:5px;'></td><td style='padding:5px;'></td></tr>";			
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$orient = 'L';
		if($orient == 'L') {
			$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>    Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    Authorized By: _______________</span>");

			$pdf->AddPage('L', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            20, // margin bottom
		            18, // margin header
		            12);
		}
		else {
			$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
			$pdf->AddPage('P', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            20, // margin bottom
		            18, // margin header
		            12);
		}
		$pdf->WriteHTML($html); // write the HTML into the PDF
		
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Jeernodhara Period Report from ".$fromDate." to ".$toDate.".pdf","D");
		} else
			$pdf->Output('Jeernodhara Daily Report ('.$_POST['dateField'].').pdf','D');
	}

	
	public function create_ShashwathPdf() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		if(isset($_POST['date'])) {
			$date = @$_POST['date'];
		} else {
			$date = $_SESSION['date'];
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
		$res = $this->obj_shashwath->getMainLossExcelPDFReport($date,$name_phone);
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$today = date("F j, Y, g:i a");  	
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$html .= "<center><strong>Shashwath Loss Report ".$date."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SL NO.</th><th style="padding:5px;">RECEIPT NO</th>
<th style="padding:5px;">NAME (Phone)</th><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Seva Name</th><th style="padding:5px;">ACCUMULATED LOSS</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";  	
			$html .= "<td style='padding:5px;'>".$res[$i]->SS_RECEIPT_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->NAME_PHONE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->DEITY_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SEVA_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ACCUMULATED_LOSS."</td>";		
			$html .= '</tr>';
			$ACCUMULATED_LOSS = explode(' ',$res[$i]->ACCUMULATED_LOSS)[1];
			$totalLoss += explode('/',$ACCUMULATED_LOSS)[0];
		}
		$html .= '<tr>';
		$html .= "<th style='padding:5px;text-align:left;' colspan='5'>Total Loss</th>";
		$html .= "<td style='padding:5px;'>Rs. ".$totalLoss."/- </td>";
		$html .= '</tr>';
		
		$html .="</tbody></table><br/>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Shashwath Loss Report ('.$date.').pdf','I');
	}
	
	
	public function create_sevaReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['SId'] = $_POST['SId'];
		$_SESSION['radioOpt'] = $_POST['radioOpt'];
		$_SESSION['allDates'] = $_POST['allDates'];
		echo 1;	
	}
	
	public function create_trustSevaReceiptSession() { 
		$_SESSION['dateField'] = $_POST['dateField'];
		$_SESSION['SId'] = $_POST['SId'];
		$_SESSION['radioOpt'] = $_POST['radioOpt'];
		$_SESSION['allDates'] = $_POST['allDates'];
		echo 1;	
	}
	
	//FOR TRUST EVENT SEVA REPORT PRINT
	public function create_trustSevaReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate" && $_SESSION['SId'] == "All") {
			$allDates1 = explode("|",$allDates);
			$queryString = "";
			for($i = 0; $i < count($allDates1); ++$i) {
				if($i == 0)
					$queryString .= "TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."'";
				else
					$queryString .= " or TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."'";
			}
			$condition = $queryString;
			$res = $this->obj_trust_report->get_all_field_event_seva_excel($condition);
		} else if(@$radioOpt == "multiDate"){
			$allDates1 = explode("|",$allDates);
			$queryString = "";
			for($i = 0; $i < count($allDates1); ++$i) {
				if($i == 0)
					$queryString .= "TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."' and TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID='".$_SESSION['SId']."'";
				else
					$queryString .= " or TET_RECEIPT_ACTIVE = 1 and TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE='".$allDates1[$i]."' and TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID='".$_SESSION['SId']."'";
			}
			$condition = $queryString;
			$res = $this->obj_trust_report->get_all_field_event_seva_excel($condition);
		} else {
			if($_SESSION['dateField'] != "" && $_SESSION['SId'] == "All") {
				$condition = array('TET_RECEIPT_ACTIVE' =>1,'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => $_SESSION['dateField']);
				$res = $this->obj_trust_report->get_all_field_event_seva_excel($condition);
			} else {
				$condition = array('TET_RECEIPT_ACTIVE' =>1,'TRUST_EVENT_SEVA_OFFERED.TET_SO_DATE' => $_SESSION['dateField'], 'TRUST_EVENT_SEVA_OFFERED.TET_SO_SEVA_ID' => $_SESSION['SId']);
				$res = $this->obj_trust_report->get_all_field_event_seva_excel($condition);
			}
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_SESSION['dateField'].")";
		}
		
		unset($_SESSION['dateField']);
		unset($_SESSION['SId']);
		unset($_SESSION['radioOpt']);
		unset($_SESSION['allDates']);
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Event Sevas Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVA</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">RECEIPT NO.</th></tr></thead><tbody>';
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".$j."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_SO_SEVA_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_PHONE."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->TET_RECEIPT_NO."</td>";
			$html .= '</tr>';
			$j++;
		}
		
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Event Sevas Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Event Sevas Report ('.$_POST['dateField'].').pdf','I');
    }
	
	public function create_sevaReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
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
		
		if(@$radioOpt == "multiDate" && $_SESSION['SId'] == "All") {
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
					$queryString .= "ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."' and EVENT_SEVA_OFFERED.ET_SO_SEVA_ID='".$_SESSION['SId']."'";
				else
					$queryString .= " or ET_RECEIPT_ACTIVE = 1 and EVENT_SEVA_OFFERED.ET_SO_DATE='".$allDates1[$i]."' and EVENT_SEVA_OFFERED.ET_SO_SEVA_ID='".$_SESSION['SId']."'";
			}
			$condition = $queryString;
			$res = $this->obj_report->get_all_field_event_seva_excel($condition);
		} else {
			if($_SESSION['dateField'] != "" && $_SESSION['SId'] == "All") {
				$condition = array('ET_RECEIPT_ACTIVE' =>1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => $_SESSION['dateField']);
				$res = $this->obj_report->get_all_field_event_seva_excel($condition);
			} else {
				$condition = array('ET_RECEIPT_ACTIVE' =>1,'EVENT_SEVA_OFFERED.ET_SO_DATE' => $_SESSION['dateField'], 'EVENT_SEVA_OFFERED.ET_SO_SEVA_ID' => $_SESSION['SId']);
				$res = $this->obj_report->get_all_field_event_seva_excel($condition);
			}
		}
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_SESSION['dateField'].")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		unset($_SESSION['dateField']);
		unset($_SESSION['SId']);
		unset($_SESSION['radioOpt']);
		unset($_SESSION['allDates']);
		
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		$html .= "<center><strong>Event Sevas Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVA</th><th style="padding:5px;">NAME</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">RECEIPT NO.</th></tr></thead><tbody>';
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".$j."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_SO_SEVA_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_NAME."</td>";			
			//if($res[$i]->ET_RECEIPT_CATEGORY_TYPE == "Inkind") {
				//$html .= '<td>'. $res[$i]->ET_RECEIPT_RASHI . ' ('. $res[$i]->ET_RECEIPT_NAKSHATRA . ") ". "</td>";
			//} else {
				//$html .= '<td></td><br/>';
			//}
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_PHONE."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]->ET_RECEIPT_NO."</td>";
			$html .= '</tr>';
			$j++;
		}
		
		$html .="</tbody></table>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			
			$pdf->Output("Event Sevas Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Event Sevas Report ('.$_POST['dateField'].').pdf','I');
    }
	
	function create_deityMisReceiptSession() {
		$_SESSION['radioOptHidden'] = $_POST['radioOptHidden'];
		$_SESSION['dateHidden'] = $_POST['dateHidden'];
		$_SESSION['toDateHidden'] = $_POST['toDateHidden'];
		$_SESSION['fromDateHidden'] = $_POST['fromDateHidden'];
		echo 1;
	}
	function create_financeDayBookSession() {
		$_SESSION['radioOptHidden'] = $_POST['radioOptHidden'];
		$_SESSION['dateHidden'] = $_POST['dateHidden'];
		$_SESSION['toDateHidden'] = $_POST['toDateHidden'];
		$_SESSION['fromDateHidden'] = $_POST['fromDateHidden'];
		$_SESSION['CommitteeId'] = $_POST['CommitteeId'];
		$_SESSION['voucherType'] = $_POST['voucherType'];
		$_SESSION['paymentType'] = $_POST['paymentType'];
		echo 1;
	}
	
	public function create_daybookreport() {	//TS
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		if(@$_SESSION['CommitteeId']){
			$data['compId'] = $compId = @$_SESSION['CommitteeId'];
		} else {
			$data['compId'] = $compId = "";
		}

		if(isset($_POST['voucherType'])){
			$_SESSION['voucherType'] = $this->input->post('voucherType');
			$voucherType = $this->input->post('voucherType');
			$data['voucherType'] = $voucherType;

		} else if(isset($_SESSION['voucherType'])) {
			$voucherType = $_SESSION['voucherType'];
			$data['voucherType'] = $voucherType;
		} else {
			$data['voucherType'] =	$voucherType = '';

		}

		if(isset($_POST['paymentType'])){
			$_SESSION['paymentType'] = $this->input->post('paymentType');
			$paymentType = $this->input->post('paymentType');
			$data['paymentType'] = $paymentType;

		} else if(isset($_SESSION['paymentType'])) {
			$paymentType = $_SESSION['paymentType'];
			$data['paymentType'] = $paymentType;
		} else {
			$data['paymentType'] =	$paymentType = '';

		}
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_SESSION['date'].")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_finance->get_dayBook_report($_SESSION['fromDate'],$_SESSION['toDate'],'','', $compId,$voucherType,$paymentType);
		} else {
			$res = $this->obj_finance->get_dayBook_report1($_SESSION['date'], $compId,$voucherType,$paymentType);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Finance Day Book Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">DATE</th><th style="padding:5px;">PARTICULAR</th><th style="padding:5px;">VOUCHER TYPE</th><th style="padding:5px;">VOUCHER NUMBER</th><th style="padding:5px;">DEBIT AMOUNT</th><th style="padding:5px;">CREDIT AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]['TRANSACTION_STATUS'] != "Cancelled"){
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['FLT_DATE']."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]['FGLH_NAME']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['VOUCHER_TYPE']."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]['VOUCHER_NO']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['FLT_DR']."</td>";
				$html .= "<td style='padding:5px;'>".$res[$i]['FLT_CR']."</td>";
				$html .= '</tr>';
				$j++;
			}
		}
		$html .="</tbody></table><br/>";

		$html .= "<center><strong>Cancelled</strong></center><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">DATE</th><th style="padding:5px;">PARTICULAR</th><th style="padding:5px;">VOUCHER TYPE</th><th style="padding:5px;">VOUCHER NUMBER</th><th style="padding:5px;">DEBIT AMOUNT</th><th style="padding:5px;">CREDIT AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]['TRANSACTION_STATUS'] == "Cancelled"){
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['FLT_DATE']."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]['FGLH_NAME']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['VOUCHER_TYPE']."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]['VOUCHER_NO']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['FLT_DR']."</td>";
				$html .= "<td style='padding:5px;'>".$res[$i]['FLT_CR']."</td>";
				$html .= '</tr>';
				$j++;
			}
		
		}
		$html .="</tbody></table><br/>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Finance Day Book Report from  ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Finance Day Book Report ('.$date.').pdf','D');
		}
	}

	// code for trust added by adithya on 27-12-23 start
public function create_trustdaybookreport() {	//TS
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		if(@$_SESSION['CommitteeId']){
			$data['compId'] = $compId = @$_SESSION['CommitteeId'];
		} else {
			$data['compId'] = $compId = "";
		}

		if(isset($_POST['voucherType'])){
			$_SESSION['voucherType'] = $this->input->post('voucherType');
			$voucherType = $this->input->post('voucherType');
			$data['voucherType'] = $voucherType;

		} else if(isset($_SESSION['voucherType'])) {
			$voucherType = $_SESSION['voucherType'];
			$data['voucherType'] = $voucherType;
		} else {
			$data['voucherType'] =	$voucherType = '';

		}

		if(isset($_POST['paymentType'])){
			$_SESSION['paymentType'] = $this->input->post('paymentType');
			$paymentType = $this->input->post('paymentType');
			$data['paymentType'] = $paymentType;

		} else if(isset($_SESSION['paymentType'])) {
			$paymentType = $_SESSION['paymentType'];
			$data['paymentType'] = $paymentType;
		} else {
			$data['paymentType'] =	$paymentType = '';

		}
		
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
		
		if(@$radioOpt == "multiDate") {
			$hDate = "(".$_SESSION['fromDate']." to ".$_SESSION['toDate'].")";
		} else {
			$hDate = "(".$_SESSION['date'].")";
		}
		
		if(@$radioOpt == "multiDate") {
			$res = $this->obj_trust_finance->get_dayBook_report($_SESSION['fromDate'],$_SESSION['toDate'],'','', $compId,$voucherType,$paymentType);
		} else {
			$res = $this->obj_trust_finance->get_dayBook_report1($_SESSION['date'], $compId,$voucherType,$paymentType);
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Finance Day Book Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">DATE</th><th style="padding:5px;">PARTICULAR</th><th style="padding:5px;">VOUCHER TYPE</th><th style="padding:5px;">VOUCHER NUMBER</th><th style="padding:5px;">DEBIT AMOUNT</th><th style="padding:5px;">CREDIT AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]['T_TRANSACTION_STATUS'] != "Cancelled"){
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['T_FLT_DATE']."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]['T_FGLH_NAME']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['VOUCHER_TYPE']."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]['T_VOUCHER_NO']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['T_FLT_DR']."</td>";
				$html .= "<td style='padding:5px;'>".$res[$i]['T_FLT_CR']."</td>";
				$html .= '</tr>';
				$j++;
			}
		}
		$html .="</tbody></table><br/>";

		$html .= "<center><strong>Cancelled</strong></center><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">DATE</th><th style="padding:5px;">PARTICULAR</th><th style="padding:5px;">VOUCHER TYPE</th><th style="padding:5px;">VOUCHER NUMBER</th><th style="padding:5px;">DEBIT AMOUNT</th><th style="padding:5px;">CREDIT AMOUNT</th></tr></thead><tbody>';
		
		$j = 1;
		for($i = 0; $i < sizeof($res); $i++)
		{
			if($res[$i]['T_TRANSACTION_STATUS'] == "Cancelled"){
				$html .= '<tr>';
				$html .= "<td style='padding:5px;'>".$j."</td>";			
				$html .= "<td style='padding:5px;'>".$res[$i]['T_FLT_DATE']."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]['T_FGLH_NAME']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['VOUCHER_TYPE']."</td>";	
				$html .= "<td style='padding:5px;'>".$res[$i]['T_VOUCHER_NO']."</td>";		
				$html .= "<td style='padding:5px;'>".$res[$i]['T_FLT_DR']."</td>";
				$html .= "<td style='padding:5px;'>".$res[$i]['T_FLT_CR']."</td>";
				$html .= '</tr>';
				$j++;
			}
		
		}
		$html .="</tbody></table><br/>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Trust Finance Day Book Report from  ".$fromDate." to ".$toDate.".pdf","D");
		} else {
			$pdf->Output('Trust Finance Day Book Report ('.$date.').pdf','D');
		}
	}
	// code for trust added by adithya on 27-12-23 end
	
	
	
	/* function create_jeernodharaReport() {
		$hDate = date('d-m-Y');
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>Sri Lakshmi Venkatesh Temple</strong></center>";
		$today = date("F j, Y, g:i a");   
		
		if(isset($_POST['outputType']))
			$html .= "<center><strong>Deity MIS Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		else
			$html .= "<center><strong>Deity MIS Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Sevas Booked</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
	} */
	

	function create_deityMisReceipt() {
		ini_set("memory_limit","2G");		
		$bootstrap = base_url().'css/pdf.css';
				
		if(@$_SESSION['radioOptHidden'] == "multiDate") {
			$hDate = "(".$_SESSION['fromDateHidden']." to ".$_SESSION['toDateHidden'].")";
		} else {
			$hDate = "(".$_SESSION['dateHidden'].")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");   
		
		if(isset($_POST['outputType']))
			$html .= "<center><strong>Deity MIS Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		else
			$html .= "<center><strong>Deity MIS Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		
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

		$totAmt = 0;
		$totAmt1 = 0;
		$totAmt2 = 0;
		$totAmt3 = 0;
		$totalAmt =0;
		$totPostage = 0;
		$totSevaPrice = 0;
		$totSevaPostageAmt=0;

		if(!empty($_SESSION['seva'])) {
			$html .= "<center><strong>Sevas:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Sevas Booked</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';//<th style="padding:5px;">Postage</th><th style="padding:5px;">Total</th>
			foreach($_SESSION['seva'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['SO_DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['SO_SEVA_NAME']."</td>";
				$html .= "<td style='padding:5px;text-align:center;'>".$result['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))']."</td>";
				// $html .= "<td style='padding:5px;text-align:right;'>".($result['POSTAGE_PRICE'] + 0)."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']."</td>";
				// $html .= "<td style='padding:5px;text-align:right;'>".($result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'] + ($result['POSTAGE_PRICE'] + 0))."</td>";
				$html .= "</tr>";
				// $totAmt = $totAmt + ($result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']) + $result['POSTAGE_PRICE'];
				// $totPostage = $totPostage + $result['POSTAGE_PRICE'];
				$totSevaPrice = $totSevaPrice + $result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'];
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			// $html .= "<td style='padding:5px;font-weight:bold;text-align:right;'>".$totPostage."</td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totSevaPrice."</b></td>";
			// $html .= "<td style='padding:5px;text-align:right;'><b>".$totAmt."</b></td>";
			$html .= "</tr>";

			for($i = 0; $i < count($_SESSION['sevaPostage']); $i++) { 
				$totSevaPostageAmt = $totSevaPostageAmt + $_SESSION['sevaPostage'][$i]['POSTAGE_PRICE'] ;
			}

			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Postage Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totSevaPostageAmt."</b></td>";
			$html .= "</tr>";
			
			$html .="</tbody></table><br/><br/>";
		}
		
		if(!empty($_SESSION['revision'])) {
			$html .= "<center><strong>Revision:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Sevas Booked</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th></tr></thead><tbody>';
			foreach($_SESSION['revision'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['SO_DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['SO_SEVA_NAME']."</td>";
				$html .= "<td style='padding:5px;text-align:center;'>".$result['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['POSTAGE_PRICE']."</td>";
				$html .= "</tr>";
				$totAmt1 = $totAmt1 + ($result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']) + $result['POSTAGE_PRICE'];
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;' colspan='3'>".$totAmt1."</td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}

		if(!empty($_SESSION['booking'])) {
			$html .= "<center><strong>Booking:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Sevas Booked</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['booking'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['SO_DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['SO_SEVA_NAME']."</td>";
				$html .= "<td style='padding:5px;text-align:center;'>".$result['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']."</td>";
				$html .= "</tr>";
				$totAmt2 = $totAmt2 + ($result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']);
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'>".$totAmt2."</td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
				
		if($totalDonation != 0) {
			$html .= "<center><strong>Donation:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['donation_details'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['RECEIPT_PRICE']."</td>";
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totalDonation."</b></td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		
		//LAZ
		if($totalKanike != 0) {
			$html .= "<center><strong>Kanike:</strong></center><br/>";
			foreach($_SESSION['allActiveKanike'] as $row) {
				$indTotal = 0;
				foreach($_SESSION['kanike_details'] as $result) {
				if($row['KS_ID']==$result['KANIKE_FOR'])
					$indTotal += ($result['RECEIPT_PRICE'] + $result['POSTAGE_PRICE']);
				}
				if($indTotal > 0) {
					$html .= "<center><strong>".$row['KANIKE_NAME']."</strong></center>";
					$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
					foreach($_SESSION['kanike_details'] as $result) {
						if($row['KS_ID']==$result['KANIKE_FOR']){
							$html .= "<tr>";
							$html .= "<td style='padding:5px;'>".$result['RECEIPT_NO']."</td>";
							$html .= "<td style='padding:5px;'>".$result['RECEIPT_DEITY_NAME']."</td>";
							$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD']."</td>";
							$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							$html .= "<td style='padding:5px;text-align:right;'>".$result['RECEIPT_PRICE']."</td>";
							$html .= "</tr>";
						}
					}
					$html .= "<tr>";
					$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
					$html .= "<td style='padding:5px;font-weight:bold;'></td>";
					$html .= "<td style='padding:5px;font-weight:bold;'></td>";
					$html .= "<td style='padding:5px;font-weight:bold;'></td>";
					//$html .= "<td style='padding:5px;text-align:right;'><b>".$totalKanike."</b></td>";
					$html .= "<td style='padding:5px;text-align:right;'><b>".$indTotal."</b></td>";

					$html .= "</tr>";
					$html .="</tbody></table><br/><br/>";
				}
			}
			$html .= "<h3><center><strong>Total Kanike Amount : ".$totalKanike."</strong></center></h3><br/>";
		}
		//LAZ..
		
		if($totalHundi != 0) {
			$html .= "<center><strong>Hundi:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Payment Method</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['hundiOne'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['RECEIPT_PRICE']."</td>";
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totalHundi."</b></td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		
		if(!empty($_SESSION['inkind'])) {
			$html .= "<center><strong>Inkind:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Item Name</th><th style="padding:5px;">Quantity</th></tr></thead><tbody>';
			foreach($_SESSION['inkind'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['DY_IK_ITEM_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['amount']." ".$result['DY_IK_ITEM_UNIT']."</td>";
				$html .= "</tr>";
			}
			$html .="</tbody></table><br/><br/>";
		}
		
		if($totalSRNS != 0) {
			$html .= "<center><strong>SRNS:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['srns_details'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['RECEIPT_PRICE']."</td>";
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totalSRNS."</b></td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}

		if(!empty($_SESSION['shashwath'])) {
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Sevas Booked</th><th style="padding:5px;">Corpus</th></tr></thead><tbody>';
			foreach($_SESSION['shashwath'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['SEVA_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['QTY']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['TOTAL']."</td>";
				$html .= "</tr>";
				$totalAmt = $totalAmt + $result['TOTAL'];
				//$totalAmt = $totalAmt + ($result['if(RECEIPT_ACTIVE = 1, TOTAL, SUM(QTY * TOTAL))']);
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totalAmt."</b></td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}	

		if($totalJeernoKanike != 0) {
			$html .= "<center><strong>Jeernodhara Kanike:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Name</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['jeernokanike'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['RECEIPT_PRICE']."</td>";
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totalJeernoKanike."</b></td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		
		if($totalJeernoHundi != 0) {
			$html .= "<center><strong>Jeernodhara Hundi:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['jeernohundiOne'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['RECEIPT_PRICE']."</td>";
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totalJeernoHundi."</b></td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		
		if(!empty($_SESSION['jeernoinkind'])) {
			$html .= "<center><strong>Jeernodhara Inkind:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Item Name</th><th style="padding:5px;">Quantity</th></tr></thead><tbody>';
			foreach($_SESSION['jeernoinkind'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['DY_IK_ITEM_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['amount']." ".$result['DY_IK_ITEM_UNIT']."</td>";
				$html .= "</tr>";
			}
			$html .="</tbody></table><br/><br/>";
		}
			
		$html .= "<center><strong>Transaction Summary:</strong></center><br/>"; 
		$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Direct Credit</th><th style="padding:5px;">Credit/Debit Card</th><th style="padding:5px;">Grand Total</th></tr></thead><tbody>';
		$html .= "<tr>";
		if(!empty($_SESSION['PayCash'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayCash']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}	

		if(!empty($_SESSION['PayCheque'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayCheque']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}
		
		if(!empty($_SESSION['PayDirect'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayDirect']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}

		if(!empty($_SESSION['PayCredit'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayCredit']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}
		
		$html .= "<td style='padding:5px;text-align:right;'>".((intVal($_SESSION['PayCash'])) + (intVal($_SESSION['PayCheque'])) + (intVal($_SESSION['PayDirect'])) + (intVal($_SESSION['PayCredit'])))."</td>";
		
		$html .= "</tr>";
		$html .="</tbody></table><br/><br/>";		

		if(!empty($_SESSION['cancelled'])) {
			$html .= "<center><strong>Cancelled Sevas:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Sevas Booked</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['cancelled'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['SO_DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['SO_SEVA_NAME']."</td>";
				$html .= "<td style='padding:5px;text-align:center;'>".$result['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']."</td>";
				$html .= "</tr>";
				$totAmt3 = $totAmt3 + ($result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']);
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;font-weight:bold;'>".$totAmt3."</td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		$totalAmt1 = 0;
		
		if(!empty($_SESSION['bookingCancelled'])) {
			$html .= "<center><strong>Booking Cancellation:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Booking Date (Booking No.)</th><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Cancelled Type</th><th style="padding:5px;">Cancelled By</th></tr></thead><tbody>';
			foreach($_SESSION['bookingCancelled'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['SB_DATE']." (".$result['SB_NO'].")"."</td>";
				$html .= "<td style='padding:5px;'>".$result['SO_DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['SO_SEVA_NAME']."</td>";
				if($result['SB_DEACTIVE_BY'] == "System") {
					$html .= "<td style='padding:5px;text-align:center;'>Auto</td>";
				} else {
					$html .= "<td style='padding:5px;text-align:center;'>Manual</td>";
				}
				$html .= "<td style='padding:5px;text-align:right;'>".$result['SB_DEACTIVE_BY']."</td>";
				$html .= "</tr>";
				$totAmt3 = $totAmt3 + ($result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']);
			}
			$html .="</tbody></table><br/><br/>";
		}
		
		if($cancelledTotalDonation != 0) {
			$html .= "<center><strong>Cancelled Donation:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt Name</th><th style="padding:5px;">Receipt Count</th><th style="padding:5px;">Total</th></tr></thead><tbody>';
			$html .= '<tr><td style="padding:5px;">Donation</td><td style="padding:5px;text-align:center;">'.intval($_SESSION['cancelledDonationCount']).'</td><td style="padding:5px;text-align:right;">'.$cancelledTotalDonation.'</td></tr>';
			$html .="</tbody></table><br/><br/>";
		}
		
		if($cancelledTotalKanike != 0) {
			$html .= "<center><strong>Cancelled Kanike:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt Name</th><th style="padding:5px;">Receipt Count</th><th style="padding:5px;">Total</th></tr></thead><tbody>';
			$html .= '<tr><td style="padding:5px;">Kanike</td><td style="padding:5px;text-align:center;">'.intval($_SESSION['cancelledKanikeCount']).'</td><td style="padding:5px;text-align:right;">'.$cancelledTotalKanike.'</td></tr>';
			$html .="</tbody></table><br/><br/>";
		}
		
		if($cancelledTotalHundi != 0) {
			$html .= "<center><strong>Cancelled Hundi:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt Name</th><th style="padding:5px;">Receipt Count</th><th style="padding:5px;">Total</th></tr></thead><tbody>';
			$html .= '<tr><td style="padding:5px;">Hundi</td><td style="padding:5px;text-align:center;">'.intval($_SESSION['cancelledHundiCount']).'</td><td style="padding:5px;text-align:right;">'.$cancelledTotalHundi.'</td></tr>';
			$html .="</tbody></table><br/><br/>";
		}
		
		if($cancelledTotalSRNS != 0) {
			$html .= "<center><strong>Cancelled SRNS:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt Name</th><th style="padding:5px;">Receipt Count</th><th style="padding:5px;">Total</th></tr></thead><tbody>';
			$html .= '<tr><td style="padding:5px;">SRNS</td><td style="padding:5px;text-align:center;">'.intval($_SESSION['cancelledSRNSCount']).'</td><td style="padding:5px;text-align:right;">'.$cancelledTotalSRNS.'</td></tr>';
			$html .="</tbody></table><br/><br/>";
		}
		
		if(!empty($_SESSION['cancelled_shashwath'])) {
			$html .= "<center><strong>Cancelled Shashwath:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Deity Name</th><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Corpus</th></tr></thead><tbody>';
			foreach($_SESSION['cancelled_shashwath'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['DEITY_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['SEVA_NAME']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['RECEIPT_PRICE']."</td>";
				$html .= "</tr>";
				$totalAmt1 = $totalAmt1 + $result['RECEIPT_PRICE'];
				//$totalAmt = $totalAmt + ($result['if(RECEIPT_ACTIVE = 1, TOTAL, SUM(QTY * TOTAL))']);
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totalAmt1."</b></td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		
		if($cancelledTotalJeernoKanike != 0) {
			$html .= "<center><strong>Cancelled Jeernodhara Kanike:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt Name</th><th style="padding:5px;">Receipt Count</th><th style="padding:5px;">Total</th></tr></thead><tbody>';
			$html .= '<tr><td style="padding:5px;">Jeernodhara Kanike</td><td style="padding:5px;text-align:center;">'.intval($_SESSION['cancelledJeernoKanikeCount']).'</td><td style="padding:5px;text-align:right;">'.$cancelledTotalJeernoKanike.'</td></tr>';
			$html .="</tbody></table><br/><br/>";
		}
		
		if($cancelledTotalJeernoHundi != 0) {
			$html .= "<center><strong>Cancelled Jeernodhara Hundi:</strong></center><br/>";
			$html .= '<table width="100%"><thead><tr><th style="padding:5px;">Receipt Name</th><th style="padding:5px;">Receipt Count</th><th style="padding:5px;">Total</th></tr></thead><tbody>';
			$html .= '<tr><td style="padding:5px;">Jeernodhara Hundi</td><td style="padding:5px;text-align:center;">'.intval($_SESSION['cancelledJeernoHundiCount']).'</td><td style="padding:5px;text-align:right;">'.$cancelledTotalJeernoHundi.'</td></tr>';
			$html .="</tbody></table><br/><br/>";
		}
		
		unset($_SESSION['radioOptHidden']);
		unset($_SESSION['dateHidden']);
		unset($_SESSION['toDateHidden']);
		unset($_SESSION['fromDateHidden']);

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		
		$orient = 'L';
		if($orient == 'L') {
			$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>    Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    Authorized By: _______________</span>");

			$pdf->AddPage('L', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            20, // margin bottom
		            18, // margin header
		            12);
		}
		else {
			$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
			$pdf->AddPage('P', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            20, // margin bottom
		            18, // margin header
		            12);
		}

		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		$radioOptHidden = $_POST['radioOptHidden'];
		$dateHidden= $_POST['dateHidden'];
		$toDateHidden= $_POST['toDateHidden'];
		$fromDateHidden= $_POST['fromDateHidden'];
		
		if($radioOptHidden == "multiDate") {
			if(isset($_POST['outputType']))
				$pdf->Output('Deity MIS Report from '.$fromDateHidden.' to '.$toDateHidden.'.pdf','D');
			else
				$pdf->Output('Deity MIS Report from '.$fromDateHidden.' to '.$toDateHidden.'.pdf','I');
		} else {
			if(isset($_POST['outputType']))
				$pdf->Output('Deity MIS Report ('.$dateHidden.').pdf','D');
			else
				$pdf->Output('Deity MIS Report ('.$dateHidden.').pdf','I');
		}
	}

	//FOR PENDING BOOKING PRINT
	public function create_pendingBookingPDF() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
		
		
	   if($_POST['namephone'] != "") {
			$queryString = " AND (SB_NAME LIKE '%".$_POST['namephone']."%' OR SB_PHONE LIKE '%".$_POST['namephone']."%')"; 
			$condition = $queryString; 
			$res = $this->obj_booking->get_all_pending_booking_report($condition);
		}else {
			$res = $this->obj_booking->get_all_pending_booking_report();
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		  
		$html .= "<center><strong>Booked Pending Seva Report</strong></center><br/>";
		$html .= '<table><thead><tr><th style="padding:5px;">SI No.</th><th style="padding:5px;">SEVA DATE</th><th style="padding:5px;">BOOKING NO.</th><th style="padding:5px;">NAME</th><th style="padding:5px;">ADDRESS</th><th style="padding:5px;">DEITY</th><th style="padding:5px;">SEVA</th><th style="padding:5px;">AMOUNT</th><th style="padding:5px;">DATE</th><th style="padding:5px;">PAYMENT STATUS</th></tr></thead><tbody>';
		
		for($i = 0; $i < sizeof($res); $i++)
		{
			$html .= '<tr>';    
			$html .= "<td style='padding:5px;'>".($i+1)."</td>";    
			$html .= "<td style='padding:5px;'>".$res[$i]->SO_DATE."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SB_NO."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SB_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SB_ADDRESS."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SO_DEITY_NAME."</td>";			
			$html .= "<td style='padding:5px;'>".$res[$i]->SO_SEVA_NAME."</td>";			
			if($res[$i]->SO_PRICE == "0")
				$html .= "<td></td>";	
			else
				$html .= "<td style='padding:5px;text-align:right;'>".$res[$i]->SO_PRICE."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]->SB_DATE ."</td>";	
			if($res[$i]->SB_PAYMENT_STATUS == "0") {
				$html .= "<td style='padding:5px;'>Pending</td>";	
			} else if($res[$i]->SB_PAYMENT_STATUS == "1") {
				$html .= "<td style='padding:5px;'>Completed</td>";	
			} else if($res[$i]->SB_PAYMENT_STATUS == "3") {
				$html .= "<td style='padding:5px;'>Cancelled</td>";	
			}
			$html .= '</tr>';
		}
		
		$html .="</tbody></table><br/>";
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->simpleTables = true;
		$pdf->useSubstitutions = false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		
		$pdf->Output('Seva Booking Report.pdf','D');
	}
	
	function create_misReceiptSession() {
		$_SESSION['misPrint'] = "set";
		echo 1;
	}
	
	function create_misReceiptSessionPrint() {
		$_SESSION['radioOptHidden'] = $_POST['radioOptHidden'];
		$_SESSION['dateHidden'] = $_POST['dateHidden'];
		$_SESSION['toDateHidden'] = $_POST['toDateHidden'];
		$_SESSION['fromDateHidden'] = $_POST['fromDateHidden'];
		echo 1;
	}
	
	//FOR TRUST EVENT MIS REPORT
	function create_trustEventMisReceiptSessionPrint() {
		$_SESSION['radioOptHidden'] = $_POST['radioOptHidden'];
		$_SESSION['dateHidden'] = $_POST['dateHidden'];
		$_SESSION['toDateHidden'] = $_POST['toDateHidden'];
		$_SESSION['fromDateHidden'] = $_POST['fromDateHidden'];
		echo 1;
	}
	
	//EVENT MIS REPORT
	function create_misReceipt() {
		ini_set("memory_limit","2G");		
		$bootstrap = base_url().'css/pdf.css';
		
		if(@$_SESSION['radioOptHidden'] == "multiDate") {
			$hDate = "(".$_SESSION['fromDateHidden']." to ".$_SESSION['toDateHidden'].")";
		} else {
			$hDate = "(".$_SESSION['dateHidden'].")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");
		
		if(isset($_POST['outputType']))
			$html .= "<center><strong>Event MIS Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		else
			$html .= "<center><strong>Event MIS Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$totalDonation = intval($_SESSION['donation']);
		$totalHundi = intval($_SESSION['hundi']);
		$totAmt = 0;
		if(!empty($_SESSION['seva'])) {
			$html .= '<table><thead><tr><th colspan=5 style="padding:5px;">Seva</th></tr><tr><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Sevas Booked</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Total</th></tr></thead><tbody>';
			//Lathish code above <th style="padding:5px;">Total</th>
			foreach($_SESSION['seva'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['ET_SO_SEVA_NAME']."</td>";
				$html .= "<td style='padding:5px;text-align:center;'>".$result['if(ET_SO_IS_SEVA = 1, count(ET_SO_SEVA_NAME), SUM(ET_SO_QUANTITY))']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['POSTAGE_PRICE']."</td>";

				// Lathish code Starts
				$linetotal=0;
				$linetotal=($result['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))']) + $result['POSTAGE_PRICE'];
				$html .= "<td style='padding:5px;text-align:right;'>".$linetotal."</td>";
				// Lathish code Ends

				$html .= "</tr>";
				$totAmt = $totAmt + ($result['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))']) + $result['POSTAGE_PRICE'];

			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;text-align:right;' colspan='4'>".$totAmt."</td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		
		if(!empty($_SESSION['cancelledSeva'])) {
			$html .= '<table><thead><tr><th colspan=3 style="padding:5px;">Cancelled Receipts</th></tr><tr><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Sevas Booked</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Total</th></tr></thead><tbody>';
			//Lathish code above <th style="padding:5px;">Postage</th><th style="padding:5px;">Total</th>
			foreach($_SESSION['cancelledSeva'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['ET_SO_SEVA_NAME']."</td>";
				$html .= "<td style='padding:5px;text-align:center;'>".$result['if(ET_SO_IS_SEVA = 1, count(ET_SO_SEVA_NAME), SUM(ET_SO_QUANTITY))']."</td>";

				$html .= "<td style='padding:5px;text-align:right;'>".$result['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))']."</td>";

				// Lathish code Starts
				$linetotal=0;
				$html .= "<td style='padding:5px;text-align:right;'>".$result['POSTAGE_PRICE']."</td>";
				$linetotal=($result['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))']) + $result['POSTAGE_PRICE'];
				$html .= "<td style='padding:5px;text-align:right;'>".$linetotal."</td>";
				$totCanAmt = $totCanAmt + ($result['if(ET_SO_IS_SEVA = 1, SUM(ET_SO_PRICE), SUM(ET_SO_QUANTITY*ET_SO_PRICE))']) + $result['POSTAGE_PRICE'];
				// Lathish code Ends
				$html .= "</tr>";
			}
			// Lathish code Starts
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;text-align:right;' colspan='4'>".$totCanAmt."</td>";
			$html .= "</tr>";
			// Lathish code Ends

			$html .="</tbody></table><br/><br/>";
		}
		
		if($totalDonation != 0) {
			$html .= '<table><thead><tr><th colspan=4 style="padding:5px;">Donation / Kanike:</th></tr><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['donation_details'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_PRICE']."</td>";
				$totAmtdon = $totAmtdon + ($result['ET_RECEIPT_PRICE']) ;
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;text-align:right;' colspan='3'>".$totAmtdon."</td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		
		if(!empty($_SESSION['cancelled_donation_details'])) {
			$html .= '<table><thead><tr><th colspan=4 style="padding:5px;">Cancelled Donation / Kanike:</th></tr><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['cancelled_donation_details'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_PRICE']."</td>";
				$totAmtCanDon = $totAmtCanDon + ($result['ET_RECEIPT_PRICE']) ;
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;text-align:right;' colspan='3'>".$totAmtCanDon."</td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}

		
		if(!empty($_SESSION['hundicancelled'])) {
			$html .= '<table width="100%"><thead><tr><th colspan=4 style="padding:5px;">Cancelled Hundi:</th></tr><tr><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Payment Method</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['hundicancelled'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['ET_RECEIPT_PRICE']."</td>";
				$totAmtCanHundi = $totAmtCanHundi + ($result['TET_RECEIPT_PRICE']) ;
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totAmtCanHundi."</b></td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		

		if(!empty($_SESSION['inkind'])) {
			//Suraksha Code
			$html .= '<table><thead><tr><th colspan=4 style="padding:5px;">Inkind:</th></tr><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Name</th><th style="padding:5px;">Item Name</th><th style="padding:5px;">Quantity</th></tr></thead><tbody>';
			foreach($_SESSION['inkind'] as $result) {
				$html .= "<tr>";
				// Suraksha Code
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['ET_RECEIPT_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['IK_ITEM_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['amount']." ".$result['IK_ITEM_UNIT']."</td>";
				$html .= "</tr>";
			}
			$html .="</tbody></table><br/><br/><br/><br/>";
		}
		$html .= '<table><thead><tr><th colspan=5 style="padding:5px;">Transaction Summary:</th></tr><tr><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Direct Credit</th><th style="padding:5px;">Credit/Debit Card</th><th style="padding:5px;">Grand Total</th></tr></thead><tbody>';
		$html .= "<tr>";
		if(!empty($_SESSION['PayCash'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayCash']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}	

		if(!empty($_SESSION['PayCheque'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayCheque']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}
		
		if(!empty($_SESSION['PayDirect'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayDirect']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}

		if(!empty($_SESSION['PayCredit'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayCredit']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}
		$html .= "<td style='padding:5px;text-align:right;'>".((intVal($_SESSION['PayCash'])) + (intVal($_SESSION['PayCheque'])) + (intVal($_SESSION['PayDirect'])) + (intVal($_SESSION['PayCredit'])))."</td>";
		$html .= "</tr>";
		$html .="</tbody></table><br/><br/>";	
		
		unset($_SESSION['radioOptHidden']);
		unset($_SESSION['dateHidden']);
		unset($_SESSION['toDateHidden']);
		unset($_SESSION['fromDateHidden']);
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		$radioOptHidden = $_POST['radioOptHidden'];
		$dateHidden= $_POST['dateHidden'];
		$toDateHidden= $_POST['toDateHidden'];
		$fromDateHidden= $_POST['fromDateHidden'];
		
		if($radioOptHidden == "multiDate") {
			if(isset($_POST['outputType']))
				$pdf->Output('Current Event MIS Report from '.$fromDateHidden.' to '.$toDateHidden.'.pdf','D');
			else
				$pdf->Output('Current Event MIS Report ('.$toDateHidden.').pdf','I');
		} else {
			if(isset($_POST['outputType']))
				$pdf->Output('Current Event MIS Report ('.$dateHidden.').pdf','D');
			else
				$pdf->Output('Current Event MIS Report ('.$dateHidden.').pdf','I');
		}
	}

	//FOR SHASWATH SEVA PRINT
	// public function create_shaswathSevaReceiptSession() { 
	// 	$_SESSION['dateField'] = $_POST['dateField'];
	// 	//$_SESSION['allDates'] = @$_POST['allDates'];
	// 	echo 1;	
	// }

	public function create_shaswathSevaReportSession() { 
		$_SESSION['generateDateForPDFReport'] = $_POST['generateDateForPDFReport'];
		$_SESSION['excludeOrInclude'] = @$_POST['excludeOrInclude'];
		echo 1;	
	}

	public function create_deityshaswathSevaReceiptPrint() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';
			if(isset($_POST['generateDate'])) {
			$_SESSION['generateDate'] = $data['date'] = $date = $everyDate = $_POST['generateDate'];
		} else if(isset($_SESSION['generateDate'])) {
			$data['date'] = $date = $everyDate = $_SESSION['generateDate'];
		}
		$selectedSsDate = date($date);
		$oneYrLessSelDate = date("d-m-Y",strtotime($selectedSsDate."-1 year"));
		
		$hDate = "(".$_SESSION['dateField'].")";
		$data['calendarCheck'] = $thithi_codes = $this->obj_shashwath->getThithiCode($date);  //$thithi_codes to be used before the generate button is clicked
		$data['calendarCheckRoi'] = $thithi_codes_roi = $this->obj_shashwath->getThithiCodeROI($date);
		$thithi_where_condition = '';
		
		if($thithi_codes_roi){
				$ROI = $thithi_codes_roi[0]->CAL_ROI;
			}
		foreach($thithi_codes as $result) {
			$thithi_where_condition .= "THITHI_CODE = '".$result->THITHI_SHORT_CODE."' OR ";  
			//$ROI = $result->CAL_ROI;
		}   
		$date2 = explode("-",$date);
		$date = $date2[0].'-'.$date2[1];
		$thithi_where_condition .= "ENG_DATE = '".$date."'";

		// $Timestamp = strtotime($everyDate);
		// $dayOfWeek = date("l", $Timestamp);
		// $weekFirst = date("d-m-Y", strtotime("first ". $dayOfWeek ." of ".date('M',$Timestamp)." ".date('Y',$Timestamp).""));
		// if($weekFirst == $everyDate){
		// 	$firstDOW = "First_".$dayOfWeek;
		// 	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."' OR EVERY_WEEK_MONTH = '".$firstDOW."'"; 
		// }else{
		// 	$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'"; 
		// }

		//EVERY CAL TYPE START
		$Timestamp = strtotime($everyDate);
		$dayOfWeek = date("l", $Timestamp);
		$thisMonth = date("M", $Timestamp);

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

		$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$dayOfWeek."'";
		if ($M_DOW) {
			$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$M_DOW."' OR EVERY_WEEK_MONTH = '".$Y_DOW."'";
		}
		if ($LM_DOW) {
			$thithi_where_condition .= "OR EVERY_WEEK_MONTH = '".$LM_DOW."' OR EVERY_WEEK_MONTH = '".$LY_DOW."'";
		}
		//EVERY CAL TYPE END


		$res =$this->obj_shashwath->getShashwathSevas_print($date,$thithi_where_condition,$ROI,'','',$oneYrLessSelDate);
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		unset($_SESSION['dateField']);
				
		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TEMPLE_NAME"]."</strong></center>";
		$today = date("F j, Y, g:i a");  
		$html .= "<center><strong>Shaswath Sevas:".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";

		$j = 0;
		$name = "";		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html);
		$html = "";	

		for($i=0; $i<sizeof($res);$i++) {	
			if($name != $res[$i]['DEITY_NAME']) {
				if($i != 0) {
					$html .="</tbody></table><br/>";
					$pdf->WriteHTML($html);
					$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
					$j = 0;
				}
				
				if(!@$res[$i]['RECEIPT_NO'])
					$html = "<center><strong>Deity Name: ".$res[$i]['DEITY_NAME']." ".$hDate." (Booking)</strong></center>";
				else
					$html = "<center><strong>Deity Name: ".$res[$i]['DEITY_NAME']." ".$hDate."</strong></center>";
				
				$html .= '<table><thead><tr><th style="padding:5px;">SI.NO</th><th style="padding:5px;">SEVA NAME</th>
                    <th style="padding:5px;">SEVA QTY</th><th style="padding:5px;">NAME</th>
				    <th style="padding:5px;">NAKSHATRA</th><th style="padding:5px;">PHONE</th><th style="padding:5px;">RECEIPT NO. (DATE)</th></tr></thead><tbody>';
			}

			$name = $res[$i]['DEITY_NAME'];
			$html .= '<tr>';
			$html .= "<td style='padding:5px;'>".($j+1)."</td>";				
			$html .= "<td style='padding:5px;'>".$res[$i]['SEVA_NAME']."</td>";	
			$html .= "<td style='padding:5px;'><center>".$res[$i]['SEVA_QTY']."</center></td>";
			$html .= "<td style='padding:5px;'>".$res[$i]['NAME_PHONE']."</td>";
			$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NAKSHATRA']."</td>";		
			$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_PHONE'].$res[$i]['SB_PHONE']."</td>";						
			$html .= "<td style='padding:5px;'>".$res[$i]['RECEIPT_NO']." (". @$res[$i]['RECEIPT_DATE'] .") "."</td>";			
			$html .= '</tr>';
			$j++;
		}

		$html .="</tbody></table><br/>";
		$pdf->WriteHTML($html);
		$pdf->WriteHTML("--------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>");
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		
		if(@$radioOpt == "multiDate") {
			$fromDate=$_SESSION['fromDate'];
			$toDate=$_SESSION['toDate'];
			$pdf->Output("Deity Sevas Report from ".$fromDate." to ".$toDate.".pdf","I");
		} else
			$pdf->Output('Deity Sevas Report ('.$_POST['dateField'].').pdf','I');
    }
	//Above code commented while merging intern Lathesh code
	
	//TRUST EVENT MIS REPORT
	
	//Above code commented while merging intern Lathesh code
	function create_trustEventMisReceipt() {                                   
		ini_set("memory_limit","2G");		
		$bootstrap = base_url().'css/pdf.css';
		//$eventname=echo $event['ET_NAME'];
		if(@$_SESSION['radioOptHidden'] == "multiDate") {
			$hDate = "(".$_SESSION['fromDateHidden']." to ".$_SESSION['toDateHidden'].")";
		} else {
			$hDate = "(".$_SESSION['dateHidden'].")";
		}
		$data['templename'] = $templename =$this->obj_shashwath->getTempleDetails();
		$data['event'] = $this->obj_trust_events->getEvents();
		$_SESSION['event'] = $data['event']['TET_NAME'];
		 $html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>".$templename[0]["TRUST_NAME"]."</strong></center>";
		$html .= "<center style='font-size:16px;margin-bottom:.3em;text-align:center;'><strong>".$_SESSION['event']."</strong></center>";
		$today = date("F j, Y, g:i a");
		
		if(isset($_POST['outputType']))
			$html .= "<center><strong>Event MIS Report ".$hDate."</strong></center><div style='font-size:10px;'>PDF Export Date & Time: ".$today."</div><br/>";
		else
			$html .= "<center><strong>Event MIS Report ".$hDate."</strong></center><div style='font-size:10px;'>Print Date & Time: ".$today."</div><br/>";
		$totalDonation = intval($_SESSION['donation']);
		$totalHundi = intval($_SESSION['hundi']);
		$totAmt = 0;
		if(!empty($_SESSION['seva'])) {
			$html .= '<table><thead><tr><th colspan=5 style="padding:5px;">Seva</th></tr><tr><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Sevas Booked</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Total</th></tr></thead><tbody>';
			foreach($_SESSION['seva'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['TET_SO_SEVA_NAME']."</td>";
				$html .= "<td style='padding:5px;text-align:center;'>".$result['SUM(TET_SO_QUANTITY)']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['POSTAGE_PRICE']."</td>";

				$html .= "<td style='padding:5px;text-align:right;'>".$result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)']."</td>";
				
				$linetotal=0;
				$linetotal=($result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)']) + $result['POSTAGE_PRICE'];
				$html .= "<td style='padding:5px;text-align:right;'>".$linetotal."</td>";
				
				$html .= "</tr>";
				$totAmt = $totAmt + ($result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)']) + $result['POSTAGE_PRICE'];
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;text-align:right;' colspan='4'>".$totAmt."</td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		
		if(!empty($_SESSION['cancelledSeva'])) {  
			$html .= '<table><thead><tr><th colspan=4 style="padding:5px;">Cancelled Seva</th></tr><tr><th style="padding:5px;">Seva Name</th><th style="padding:5px;">Sevas Booked</th><th style="padding:5px;">Amount</th><th style="padding:5px;">Postage</th><th style="padding:5px;">Total</th></tr></thead><tbody>';

			foreach($_SESSION['cancelledSeva'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['TET_SO_SEVA_NAME']."</td>";
				$html .= "<td style='padding:5px;text-align:center;'>".$result['SUM(TET_SO_QUANTITY)']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)']."</td>";
				$linetotal=0;
				$linetotal=($result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)']) + $result['POSTAGE_PRICE'];
				$html .= "<td style='padding:5px;text-align:right;'>".$linetotal."</td>";
				$html .= "</tr>";
				$totAmtCan = $totAmtCan + ($result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)']) + $result['POSTAGE_PRICE'];
				
				$html .= "</tr>";
				$totAmtCan = $totAmtCan + ($result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)']) + $result['POSTAGE_PRICE'];
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;text-align:right;' colspan='3'>".$totAmtCan."</td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		
		if($totalDonation != 0) {
			$html .= '<table><thead><tr><th colspan=4 style="padding:5px;">Donation / Kanike:</th></tr><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['donation_details'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_PRICE']."</td>";
				$totAmtdon = $totAmtdon + ($result['TET_RECEIPT_PRICE']) ;
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;text-align:right;' colspan='3'>".$totAmtdon."</td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		
		if(!empty($_SESSION['cancelled_donation_details'])) {
			$html .= '<table><thead><tr><th colspan=4 style="padding:5px;">Cancelled Donation / Kanike:</th></tr><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Payment Mode</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['cancelled_donation_details'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_PRICE']."</td>";
				$totAmtCanDon = $totAmtCanDon + ($result['TET_RECEIPT_PRICE']) ;
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;text-align:right;' colspan='3'>".$totAmtCanDon."</td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}

		if(!empty($_SESSION['hundinew'])) {
			$html .= '<table width="100%"><thead><tr><th colspan=4 style="padding:5px;">Hundi:</th></tr><tr><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Payment Method</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['hundinew'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['TET_RECEIPT_PRICE']."</td>";
				$totAmtHundi = $totAmtHundi + ($result['TET_RECEIPT_PRICE']) ;
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totAmtHundi."</b></td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}

		if(!empty($_SESSION['hundicancelled'])) {
			$html .= '<table width="100%"><thead><tr><th colspan=4 style="padding:5px;">Cancelled Hundi:</th></tr><tr><th style="padding:5px;">Receipt No.</th><th style="padding:5px;">Payment Method</th><th style="padding:5px;">Payment Notes</th><th style="padding:5px;">Amount</th></tr></thead><tbody>';
			foreach($_SESSION['hundicancelled'] as $result) {
				$html .= "<tr>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_PAYMENT_METHOD']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
				$html .= "<td style='padding:5px;text-align:right;'>".$result['TET_RECEIPT_PRICE']."</td>";
				$totAmtCanHundi = $totAmtCanHundi + ($result['TET_RECEIPT_PRICE']) ;
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "<td style='padding:5px;font-weight:bold;'>Total Amount</td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;font-weight:bold;'></td>";
			$html .= "<td style='padding:5px;text-align:right;'><b>".$totAmtCanHundi."</b></td>";
			$html .= "</tr>";
			$html .="</tbody></table><br/><br/>";
		}
		

		if(!empty($_SESSION['inkind'])) {
			// Suraksha Code
			$html .= '<table width="100%"><thead><tr><th colspan=4 style="padding:5px;">Inkind:</th></tr><tr><th style="padding:5px;">Receipt No</th><th style="padding:5px;">Name</th><th style="padding:5px;">Item Name</th><th style="padding:5px;">Quantity</th></tr></thead><tbody>';
			foreach($_SESSION['inkind'] as $result) {
				$html .= "<tr>";
				// Suraksha Code
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_NO']."</td>";
				$html .= "<td style='padding:5px;'>".$result['TET_RECEIPT_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['IK_ITEM_NAME']."</td>";
				$html .= "<td style='padding:5px;'>".$result['amount']." ".$result['IK_ITEM_UNIT']."</td>";
				$html .= "</tr>";
			}
			$html .="</tbody></table><br/><br/><br/><br/>";
		}
		$html .= '<table width="100%"><thead><tr><th colspan=5 style="padding:5px;">Transaction Summary:</th></tr><tr><th style="padding:5px;">Cash</th><th style="padding:5px;">Cheque</th><th style="padding:5px;">Direct Credit</th><th style="padding:5px;">Credit/Debit Card</th><th style="padding:5px;">Grand Total</th></tr></thead><tbody>';
		$html .= "<tr>";
		if(!empty($_SESSION['PayCash'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayCash']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}	

		if(!empty($_SESSION['PayCheque'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayCheque']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}
		
		if(!empty($_SESSION['PayDirect'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayDirect']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}

		if(!empty($_SESSION['PayCredit'])){		
			$html .= "<td style='padding:5px;text-align:right;'>".$_SESSION['PayCredit']."</td>";
		} else {
			$html .= "<td style='padding:5px;text-align:right;'>0</td>";
		}
		$html .= "<td style='padding:5px;text-align:right;'>".((intVal($_SESSION['PayCash'])) + (intVal($_SESSION['PayCheque'])) + (intVal($_SESSION['PayDirect'])) + (intVal($_SESSION['PayCredit'])))."</td>";
		$html .= "</tr>";
		$html .="</tbody></table><br/><br/>";		
		
		unset($_SESSION['radioOptHidden']);
		unset($_SESSION['dateHidden']);
		unset($_SESSION['toDateHidden']);
		unset($_SESSION['fromDateHidden']);
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle($templename[0]["TEMPLE_ABBR"]);
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->SetHTMLFooter("<span style='font-weight:600;font-size:15px;'>Entered By: _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized By: _______________</span>");
		$pdf->WriteHTML($html); // write the HTML into the PDF
		// $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		$radioOptHidden = $_POST['radioOptHidden'];
		$dateHidden= $_POST['dateHidden'];
		$toDateHidden= $_POST['toDateHidden'];
		$fromDateHidden= $_POST['fromDateHidden'];
		
		if($radioOptHidden == "multiDate") {
			if(isset($_POST['outputType']))
				$pdf->Output('Current Event MIS Report from '.$fromDateHidden.' to '.$toDateHidden.'.pdf','D');
			else
				$pdf->Output('Current Event MIS Report ('.$toDateHidden.').pdf','I');
		} else {
			if(isset($_POST['outputType']))
				$pdf->Output('Current Event MIS Report ('.$dateHidden.').pdf','D');
			else
				$pdf->Output('Current Event MIS Report ('.$dateHidden.').pdf','I');
		}
	}

	public function create_shashwathIndMemReportSession() { 
		$_SESSION['MEM_SM_ID'] = $_POST['MEM_SM_ID'];
		$_SESSION['MEM_TOT_CORPUS'] = $_POST['MEM_TOT_CORPUS'];
		echo 1;
	}

	public function create_shashwathIndividualMemberReport() {
		$MEM_SM_ID = @$_SESSION['MEM_SM_ID'];
		$MEM_TOT_CORPUS = @$_SESSION['MEM_TOT_CORPUS'];


		ini_set("memory_limit","2G");		
		$bootstrap = base_url().'css/pdf.css';

		$html = "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>Sri Lakshmi Venkatesha Temple</strong></center>";
		$today = date("F j, Y, g:i a");

		$html .= '<h3>SHASHWATH MEMBER DETAILS</h3>';
			$sqlMemSeva = "SELECT SM_NAME,SM_ADDR1,SM_ADDR2,SM_CITY,SM_STATE,SM_COUNTRY,SM_PIN, SM_REF, SHASHWATH_SEVA.SS_ID, SS_REF, SHASHWATH_SEVA.SM_ID,  SHASHWATH_SEVA.DEITY_ID, SHASHWATH_SEVA.SEVA_ID, SEVA_QTY, SHASHWATH_SEVA.SEVA_TYPE, CAL_TYPE, THITHI_CODE, ENG_DATE, SHASHWATH_SEVA.SP_ID, SHASHWATH_SEVA.SP_COUNTER, SS_STATUS, MASA, BASED_ON_MOON, THITHI_NAME, SHASHWATH_SEVA.SEVA_NOTES, SHASHWATH_SEVA.SS_VERIFICATION, DEITY.DEITY_ID, DEITY_CODE, DEITY_NAME, DEITY.DATE_TIME, DEITY.DATE, DEITY.USER_ID, DEITY_ACTIVE, DEITY_SEVA.SEVA_ID, SEVA_CODE, SEVA_NAME, DEITY_SEVA.DEITY_ID, SEVA_DESC, DEITY_SEVA.DATE_TIME, DEITY_SEVA.DATE, DEITY_SEVA.USER_ID,DEITY_SEVA.SEVA_TYPE, SEVA_BELONGSTO FROM shashwath_members JOIN SHASHWATH_SEVA ON SHASHWATH_MEMBERS.SM_ID = SHASHWATH_SEVA.SM_ID JOIN DEITY ON DEITY.DEITY_ID = SHASHWATH_SEVA.DEITY_ID JOIN DEITY_SEVA ON DEITY_SEVA.SEVA_ID = SHASHWATH_SEVA.SEVA_ID JOIN SHASHWATH_PERIOD_SETTING ON SHASHWATH_PERIOD_SETTING.SP_ID = SHASHWATH_SEVA.SP_ID WHERE SHASHWATH_SEVA.SM_ID = ".$MEM_SM_ID;

			$queryMemSeva = $this->db->query($sqlMemSeva);
			$countSeva = $queryMemSeva->num_rows();
			$membersSeva = $queryMemSeva->result('array');

			$html .= "<h4><b>NAME</b> : ".$membersSeva[0]['SM_NAME']."</h4>";
			if($membersSeva[0]['SM_PHONE']){
				$html .= "<h4><b>PHONE</b> : ".$membersSeva[0]['SM_PHONE']."</h4>";
			}
			$html .= "<h4><b>ADDRESS</b> : ".$membersSeva[0]['SM_ADDR1']."  ".$membersSeva[0]['SM_ADDR2']." ".$membersSeva[0]['SM_CITY']."  ".$membersSeva[0]['SM_STATE']."  ".$membersSeva[0]['SM_COUNTRY']."  ".$membersSeva[0]['SM_PIN']."</h4>";					
			$html .= "<h4><b>OVERALL CORPUS</b> : ".$MEM_TOT_CORPUS."</h4>";

			$html .= '<h3 style="text-align:center;">SEVA DETAILS</h3>';

			foreach($membersSeva as $sevas) {
				$sqlAllSevas = "SELECT SS_RECEIPT_NO_REF,DEITY_RECEIPT.RECEIPT_ID, RECEIPT_NO,RECEIPT_DATE, RECEIPT_PRICE FROM DEITY_RECEIPT WHERE DEITY_RECEIPT.SS_ID = ".$sevas['SS_ID']." AND DEITY_RECEIPT.RECEIPT_CATEGORY_ID = 7 AND DEITY_RECEIPT.RECEIPT_ACTIVE = 1 ";
				$queryAllSevas = $this->db->query($sqlAllSevas);
				$allSevas = $queryAllSevas->result('array');
				//<tr><th colspan=5 style='padding:5px;'>SEVA DETAILS</th></tr>
				$html .= "<table style='margin-bottom:20px;width:100%' ><tr >";
				$html .= "<td colspan=2 style='padding:5px;'><b>DEITY</b> : ".$sevas['DEITY_NAME']."</td>";
				$html .= "<td colspan=2 style='padding:5px;text-align:right;'><b>SEVA</b> : ".$sevas['SEVA_NAME']."</td>";

				$html .= "</tr>";

				$html .= "<tr>";
				$html .= "<td colspan=2 style='padding:5px;'><b>THITHI/DATE</b> : ".$sevas['ENG_DATE']." ".$sevas['THITHI_CODE']."</td>";

				$html .= "<td colspan=2 style='padding:5px;text-align:right;'><b>SEVA QTY</b> :  ".$sevas['SEVA_QTY']."</td>";					
				$html .= "</tr>";

				$html .= '<tr><th style="padding:5px;width:15%">Book RNo</th><th style="padding:5px;width:35%">Receipt Date</th><th style="padding:5px;width:35%">New RNo.</th><th style="padding:5px;width:15%">Corpus</th></tr>';

				$corpusSum=0;
				foreach($allSevas as $result2) {
					$corpusSum += $result2['RECEIPT_PRICE'];
					$html .= "<tr>";	
					$html .= "<td><center>".$result2['SS_RECEIPT_NO_REF']."</center></td>";
					$html .= "<td><center>".$result2['RECEIPT_DATE']."</center></td>";
					$html .= "<td><center>".$result2['RECEIPT_NO']."</center></td>";
					$html .= "<td><center>".$result2['RECEIPT_PRICE']."</center></td>";
					$html .= "</tr>";
				}
				$html .= "</table>";	
				$html .= "<h4 style='text-align:right;padding-top:-15px;'>Total Seva Corpus : ".$corpusSum."</h4>";

				
			}

			
			$html .= "<h5>Verified By:  _______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>";
		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf->setTitle('SLVT'); //123
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
		
		$pdf->Output('ShashwathIndividualMemberReport.pdf','I');

	}
	public function create_Printdaybook() {
		ini_set("memory_limit","2G");
		$bootstrap = base_url().'css/pdf.css';

		$TONAME = $_SESSION['TONAME'];
		$FROMNAME = $_SESSION['FROMNAME'];
		$VOU_CHER_TYPE = @$_SESSION['VOU_CHER_TYPE'];
		$aid = $_SESSION['aidP'];
		$lidP = str_replace("\'","'",$_SESSION['lidP']);
		$countNoP = $_SESSION['VOUCHER_NUMBER'];
		$transactionDate = $_SESSION['FLT_DATE'];
		//$favouring = $_SESSION['favouring'];
		$naration = $_SESSION['naration'];
		$paymentmethod = $_SESSION['paymentmethod'];
		$chequeDate = $_SESSION['chequedate'];
		$CHEQUE_NO = $_SESSION['CHEQUE_NO'];
		$bankName = str_replace("\'","'",$_SESSION['bankName']);
		$branchName = str_replace("\'","'",$_SESSION['branchName']);
		$FLTDR = $_SESSION['FLTDR'];
		$rupee = explode('.',$FLTDR);
		$amtInWord = $this->financeAmountInWords(floatval($FLTDR));   

		$html = "<center style='font-size:11px;margin-bottom:.3em;text-align:center;'><strong>|| Sri Lakshmi Venkatesh Prasanna ||</strong></center>";
		$html .= "<center style='font-size:18px;margin-bottom:.3em;text-align:center;'><strong>Sri Lakshmi Venkatesh Temple</strong></center>";
		$html .= "<center style='font-size:14px;margin-bottom:.3em;text-align:center;'>V.T. Road , Thenkapete - Udupi</center>";  
		//$html .= "<table><tbody><tr><td>Number : </td><td><div style='font-size:10px;float:right'>Date: ".$today."</div></td></tr>" ;
		$html .= "<div style='padding-top:30px;'><span style='font-weight:600;font-size:15px;'><b>Voucher Number :  </b>".$countNoP."</span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span style='text-align: right;'><b>Date:</b>&nbsp;".$transactionDate."</span></div><br>";
		$html .= "<div><b>Account :  </b>".$FROMNAME."</div><br>";
		$html .= "<div><b>Favouring To :  </b>".$TONAME."</div><br>";
		$html .= "<div><b>Voucher Type :  </b>".$VOU_CHER_TYPE."</div><br>";

		$html .= "<div><b>Purpose :  </b>".$naration."</div><br>";

		$html .= "<div><span style='padding_left:100px;padding_right:100px;'><b>Rs.  </b>".$rupee[0]."</span>";
		if($rupee[1])
			$html .="<span style='width:100px;'>&emsp;<b>Ps.  </b>".$rupee[1]."</span>";
		$html .="<span>&emsp;<b>Rupees:  </b>".$amtInWord."</span></div><br>";
		// if($paymentmethod == "Cheque")
			$html .= "<div><b>Cheque Number :  </b>".$CHEQUE_NO."&emsp;<b>Cheque Date :  </b>".$chequeDate."&emsp;<b></div><br>";
		//$html .= "<div><b>Narration :  </b>".$naration."</div><br>";

		$html .="<div style='top:45%;position: fixed;'><span style='font-weight:600;font-size:14px;'>Managing Trustee: ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Manager :  ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recipient Signature : ________________</span></div>";
		


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->setTitle('SLVT'); //123
		$pdf->simpleTables = true;
		$pdf->useSubstitutions=false;
		$stylesheet = file_get_contents($bootstrap); // external css
		// $pdf->AddPage('P','A4',0);
		
		
		$pdf->WriteHTML($stylesheet,1);
		
		$pdf->AddPage('P', // L - landscape, P - portrait
		            '', '', '', '',
		            10, // margin_left
		            10, // margin right
		            10, // margin top
		            10, // margin bottom
		            12, // margin header
		            12);
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output('Finance Payment ('.$countNoP.').pdf','I');
	}
}
