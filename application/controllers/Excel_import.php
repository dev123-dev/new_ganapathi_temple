<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel_import extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('excel_import_model');
		$this->load->library('excel');
	}

	function index()
	{
		$this->load->view('excel_import');
	}
	
	function fetch()
	{
		//echo $_POST['calId'];
		$data = $this->excel_import_model->select($_POST['calId']);
		$output = '
		<h3 align="center">Total Data - '.$data->num_rows().'</h3>
		<table class="table table-bordered table-hover">
			<thead>
			<tr>
				<th style="width:10%"><strong>Date</strong></th>
				<th style="width:10%"><strong>Samvatsara</strong></th>
				<th style="width:10%"><strong>Masa</strong></th>
				<th style="width:10%"><strong>Shuddha/Bahula</strong></th>
				<th style="width:10%"><strong>Thithi Code</strong></th>
				<th style="width:10%"><strong>Thithi</strong></th>
				<th style="width:10%"><strong>Nakshatra</strong></th>
				<th style="width:10%"><strong>Day</strong></th>
				<!--<th style="width:10%"><strong>Operations</strong></th>-->
			</tr>
			</thead>
		';
		foreach($data->result() as $row)
		{
			$output .= '
			<tr>
				<td>'.$row->ENG_DATE.'</td>
				<td>'.$row->SAMVATSARA.'</td>
				<td>'.$row->MASA.'</td>
				<td>'.$row->BASED_ON_MOON.'</td>
				<td>'.$row->THITHI_SHORT_CODE.'</td>
				<td>'.$row->THITHI_NAME.'</td>
				<td>'.$row->STAR.'</td>
				<td>'.$row->DAY.'</td>

			</tr>
			';
		}
		$output .= '</table>';
		echo $output;
	}

	function create_thithi_shortcode($masa,$basedonmoon,$thithi) {

		$this->db->select('MASA_CODE')->from('masa')->where(array('MASA_NAME'=> ucfirst(strtolower($masa))));
		$query = $this->db->get();
		$masacode = $query->row_array();
		$this->db->select('BOM_CODE')->from('based_on_moon')->where(array('BOM_NAME'=> ucfirst(strtolower($basedonmoon))));
		$query1 = $this->db->get();
		$bomcode = $query1->row_array();					
		$this->db->select('THITHI_CODE')->from('thithi')->join('based_on_moon', 'based_on_moon.BOM_ID = thithi.BOM_ID')->where(array('based_on_moon.BOM_NAME'=>  ucfirst(strtolower($basedonmoon))))->where(array('thithi.THITHI_NAME'=> ucfirst(strtolower($thithi))));
		$query2 = $this->db->get();
		$thithicode = $query2->row_array();
		return $masacode['MASA_CODE'].$bomcode['BOM_CODE'].$thithicode['THITHI_CODE'];
	}

	function import(){
		if(isset($_FILES["file"]["name"])){
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			  
			foreach($object->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				echo  $highestRow;
				echo $highestColumn;
				for($row=4; $row<=$highestRow; $row++){

					$ENG_DATE = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$SAMVATSARA = strtoupper($worksheet->getCellByColumnAndRow(1, $row)->getValue());
					$MASA = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$BASED_ON_MOON = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$THITHI_NAME = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					//$ADDL_THITHI_NAME = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$STAR = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					//$ADDL_STAR = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$DAY = $worksheet->getCellByColumnAndRow(7, $row)->getCalculatedValue();
					$DUPLICATE = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
					$DEACTIVE_STATUS = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
					$NAKSHATHRA = (($ADDL_STAR != "")?$STAR.','.$ADDL_STAR:$STAR);

					$THITHI_SHORT_CODE = $this->create_thithi_shortcode($MASA,$BASED_ON_MOON,$THITHI_NAME);
					
					$data[] = array(
						'CAL_ID'			=>	$this->input->post('calId'),
						'ENG_DATE'			=>	$ENG_DATE,
						'SAMVATSARA'		=>	$SAMVATSARA,
						'THITHI_SHORT_CODE' =>	$THITHI_SHORT_CODE,
						'THITHI_NAME'		=> 	$THITHI_NAME,
						'BASED_ON_MOON'		=>	$BASED_ON_MOON,
						'MASA'				=>	$MASA,
						'STAR' 				=> 	$NAKSHATHRA,
						'DAY' 				=> 	$DAY,
						'DUPLICATE' 		=> 	$DUPLICATE,
						'DEACTIVE_STATUS' 	=> 	$DEACTIVE_STATUS
					);
					if($ADDL_THITHI_NAME != "") {
						$THITHI_SHORT_CODE = $this->create_thithi_shortcode($MASA,$BASED_ON_MOON,$ADDL_THITHI_NAME);

						$data[] = array(
							'CAL_ID'			=>	$this->input->post('calId'),
							'ENG_DATE'			=>	$ENG_DATE,
							'SAMVATSARA'		=>	$SAMVATSARA,
							'THITHI_SHORT_CODE' =>	$THITHI_SHORT_CODE,
							'THITHI_NAME'		=> 	$ADDL_THITHI_NAME,
							'BASED_ON_MOON'		=>	$BASED_ON_MOON,
							'MASA'				=>	$MASA,
							'STAR' 				=> 	$NAKSHATHRA,
							'DAY' 				=> 	$DAY,
							'DUPLICATE' 		=> 	$DUPLICATE,
							'DEACTIVE_STATUS' 	=> 	$DEACTIVE_STATUS
						);
					}
				}
				break;
			}
			$calId = $this->input->post('calId');
			$this->excel_import_model->insert($data,$calId);
			echo 'Data Imported successfully';
		}
	}


	// function import()
	// {
	// 	if(isset($_FILES["file"]["name"]))
	// 	{
	// 		$path = $_FILES["file"]["tmp_name"];
	// 		$object = PHPExcel_IOFactory::load($path);
			
	// 		foreach($object->getWorksheetIterator() as $worksheet)
	// 		{
	// 			$highestRow = $worksheet->getHighestRow();
	// 			$highestColumn = $worksheet->getHighestColumn();
	// 			echo  $highestRow;
	// 			echo $highestColumn;
	// 			for($row=2; $row<=$highestRow; $row++)
	// 			{

	// 				$ENG_DATE = date('d-m-Y', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(0, $row)->getValue()));
	// 				$SAMVATSARA = strtoupper($worksheet->getCellByColumnAndRow(1, $row)->getValue());
	// 				$MASA = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
	// 				$BASED_ON_MOON = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$THITHI_NAME = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
	// 				$ADDL_THITHI_NAME = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
	// 				$STAR = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
	// 				$ADDL_STAR = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
	// 				$DAY = $worksheet->getCellByColumnAndRow(8, $row)->getCalculatedValue();
	// 				$NAKSHATHRA = (($ADDL_STAR != "")?$STAR.','.$ADDL_STAR:$STAR);

	// 				$THITHI_SHORT_CODE = $this->create_thithi_shortcode($MASA,$BASED_ON_MOON,$THITHI_NAME);
					
	// 				$data[] = array(
	// 					'CAL_ID'			=>	$this->input->post('calId'),
	// 					'ENG_DATE'			=>	$ENG_DATE,
	// 					'SAMVATSARA'		=>	$SAMVATSARA,
	// 					'THITHI_SHORT_CODE' =>	$THITHI_SHORT_CODE,
	// 					'THITHI_NAME'		=> 	$THITHI_NAME,
	// 					'BASED_ON_MOON'		=>	$BASED_ON_MOON,
	// 					'MASA'				=>	$MASA,
	// 					'STAR' 				=> 	$NAKSHATHRA,
	// 					'DAY' 				=> 	$DAY
	// 				);
	// 				if($ADDL_THITHI_NAME != "") {
	// 					$THITHI_SHORT_CODE = $this->create_thithi_shortcode($MASA,$BASED_ON_MOON,$ADDL_THITHI_NAME);

	// 					$data[] = array(
	// 						'CAL_ID'			=>	$this->input->post('calId'),
	// 						'ENG_DATE'			=>	$ENG_DATE,
	// 						'SAMVATSARA'		=>	$SAMVATSARA,
	// 						'THITHI_SHORT_CODE' =>	$THITHI_SHORT_CODE,
	// 						'THITHI_NAME'		=> 	$ADDL_THITHI_NAME,
	// 						'BASED_ON_MOON'		=>	$BASED_ON_MOON,
	// 						'MASA'				=>	$MASA,
	// 						'STAR' 				=> 	$NAKSHATHRA,
	// 						'DAY' 				=> 	$DAY
	// 					);
	// 				}
	// 			}
	// 			break;
	// 		}
	// 		$this->excel_import_model->insert($data);
	// 		echo 'Data Imported successfully';
	// 	}
		
	// }
}

?>