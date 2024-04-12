<?php
	class UserLogin extends CI_Model{
		
		public function __Construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		public function getLoginDetails($id="", $user="")
		{
			//echo $user."user";
			$sql = $this->db->query("SELECT * FROM user WHERE USER_ID =".$id." AND USER_NAME='".$user."'");
			$result = $sql-> result();
			return $result;
		}
	}
?>