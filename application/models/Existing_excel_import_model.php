<?php
class Existing_excel_import_model extends CI_Model
{
	function select()
	{
		$this->db->order_by('sm_id', 'asc');
		$this->db->where('sm_status',0);
		$query = $this->db->get('shashwath_member_import');
		
		
		return $query;
	}

	function insert($data)
	{
		$this->db->insert_batch('shashwath_member_import', $data);

	}
}
