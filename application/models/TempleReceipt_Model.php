<?php
	class TempleReceipt_Model extends CI_Model{
		public function __Construct()
		{
			parent::__Construct();
			$this->load -> database();
		}
		
		public function GetDeityDetail()
		{
			$sql = $this -> db -> query("SELECT * FROM `DEITY` inner join `DEITY_SEVA` on `DEITY`.`DEITY_ID` = `DEITY_SEVA`.`DEITY_ID`");
			$result = $sql -> result();
			return $result;
		}
		
		public function GetInkindDetail()
		{
			$sql = $this -> db -> query("SELECT * FROM `inkind_items`");
			$result = $sql -> result();
			return $result;
		}
		
		public function getDeitySeva($val)
		{
			$sql = $this -> db -> query("SELECT * FROM `DEITY_SEVA` WHERE DEITY_ID = '".$val . "'");
			$result = $sql -> result();
			return $result;
		}
	}
?>