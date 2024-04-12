<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_Amt_Recovery_controller extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_settings/Admin_setting_model', 'obj_admin_settings', TRUE);
		
	}
	public function index($start = 0) {
		$data['result_query'] = $this->get_details(10,$start);

		$data['result_query_count'] = $config['total_rows'] = count($this->get_details(0,0));

		$this->load->library('pagination');
		$config['base_url'] = base_url().'Db_recovery/Db_Amt_Recovery_controller/index';
		$config['per_page'] = 10;
		$config['prev_link'] = '&lt;&lt;';
		$config['next_link'] = '&gt;&gt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['first_link'] = 'First';
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();


		
		$this->load->view('header',$data);
		$this->load->view('Db_recovery/Db_Amt_Recovery');
		$this->load->view('footer_home');

	}
	
	function get_details($num = 10, $start = 0) {
		$sql = 'SELECT shashwath_seva.SS_ID, SS_RECEIPT_NO, RECEIPT_ID,SS_RECEIPT_DATE, RECEIPT_NO, SM_NAME, RECEIPT_PRICE FROM shashwath_seva INNER JOIN shashwath_members ON shashwath_seva.SM_ID = shashwath_members.SM_ID INNER JOIN deity_receipt ON shashwath_seva.SS_ID = deity_receipt.SS_ID WHERE deity_receipt.SS_ID > 975 AND RECEIPT_PRICE = 0 ' .(($num != 0)?'LIMIT '.$start.','.$num:"");

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}  
	}

	function insertPrice() {
	    $ReceiptId = array('RECEIPT_ID' => $this->input->post('ReceiptId'));
		$dataArray = array('RECEIPT_PRICE' => $this->input->post('ReceiptPrice'));

		$this->db->where($ReceiptId);
		$this->db->update('deity_receipt', $dataArray);
		
		echo "success";
	}
	
}
