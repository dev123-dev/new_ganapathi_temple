<?php
class Excel_import_model extends CI_Model
{
	function select($calId){
		$this->db->order_by('CAL_YEAR_ID', 'asc');
		$this->db->where('CAL_ID',$calId);
		$query = $this->db->get('calendar_year_breakup');
		return $query;
	}

	function insert($data,$calId){
		$sql = "Delete from calendar_year_breakup where CAL_ID='$calId'";
		$this->db->query($sql);
		$this->db->insert_batch('calendar_year_breakup', $data);

	}
}
