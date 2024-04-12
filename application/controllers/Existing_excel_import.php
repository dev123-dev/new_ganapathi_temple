<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Existing_excel_import extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('existing_excel_import_model');
		$this->load->library('excel');
	}

	function index()
	{
		$this->load->view('existing_excel_import');
	}
	
	function fetch()
	{
		//echo $_POST['calId'];
		$data = $this->existing_excel_import_model->select();

		$output = '
		<h3 align="center">Total Data - '.$data->num_rows().'</h3>
		<table class="table table-bordered table-hover" >
			<thead>
			<tr>
				<th style="width:5%;"><strong>RECEIPT_NO</strong></th>
				<th style="width:5%"><strong>RECEIPT_DATE</strong></th>
				<th style="width:5%"><strong>MEMBER_NAME</strong></th>
				<th style="width:5%;"><strong>ADDRESS_1</strong></th>
				<th style="width:5%"><strong>CITY</strong></th>
				<th width="5%">OPERATION</th>
			</tr>
			</thead>
		';
		foreach($data->result() as $row)
		{
			$output .= "
			<tr>
				<td>$row->sm_reciept_no</td>
				<td>$row->sm_reciept_date</td>
				<td>$row->sm_member_name</td>
				<td>$row->sm_addr1</td>
				<td>$row->sm_city</td>
				<td>
					<a style='border:none; outline: 0;' href='javascript:sendId(".$row->sm_id.");' title='Edit Member Details'><img style='border:none; outline: 0;' src='".base_url()."images/edit_icon.svg'></a>
				</td>
			</tr>
			";
		}
		$output .= '</table>';
		echo $output;
	}
	function import()
	{
		if(isset($_FILES["file"]["name"]))
		{
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{
					$sm_reciept_no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$sm_reciept_date = date('d-m-Y', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(3, $row)->getValue()));
					$sm_member_name = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$sm_addr1 = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$sm_addr2 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$sm_city = $worksheet->getCellByColumnAndRow(8, $row)->getValue();		
					$sm_pincode = $worksheet->getCellByColumnAndRow(9, $row)->getValue();	
					$sm_phone = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
					$sm_purpose = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
					$sm_gotra = $worksheet->getCellByColumnAndRow(23, $row)->getValue();

					$data[] = array(			
						'sm_reciept_no'		=>	$sm_reciept_no,
						'sm_reciept_date'	=>	$sm_reciept_date,						
						'sm_member_name'	=> 	$sm_member_name,
						'sm_addr1'			=>	$sm_addr1,
						'sm_addr2'			=>	$sm_addr2,
						'sm_city' 			=> 	$sm_city,
						'sm_pincode' 		=> 	$sm_pincode,
						'sm_phone' 			=> 	$sm_phone,
						'sm_purpose'		=>  $sm_purpose,
						'sm_gotra'			=>  $sm_gotra,
					);
				}
			}
			$this->existing_excel_import_model->insert($data);
			echo 'Data Imported successfully';
		}
	}
}
?>

