<?php header('Access-Control-Allow-Origin: *'); ?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model {
	
	public function __construct() { 
		parent::__construct();
			
	}
	
	function login($username, $password) {
		$where = array(
			'USER_EMAIL'=>$username,
			'USER_ACTIVE'=>"1",
			'USER_PASSWORD'=>$password
		); 
		
		$where2 = array(
			'USER_ACTIVE'=>"1",
			'USER_PASSWORD'=>$password
		);
		
		$or_where = array(
			'USER_LOGIN_NAME'=>$username
		);
		 
		

		$this->db->select()->from('USERS')->where($where)->or_where($or_where)->where($where2);
		$query = $this->db->get();
		
		
		return $query->first_row('array');
	}
}