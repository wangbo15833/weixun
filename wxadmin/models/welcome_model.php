<?php

/**
 * model
 *
 * @author        gefc
 * @version       1.0
 */
class Welcome_model extends MY_Model
{
	function __construct(){
		parent::__construct();
	}

	function getinfo(){
		$list = array();
		$query = $this->db->get('login_attempts');
		foreach($query->result() as $row){
			$list[] = $row;
		}
		return $list;
	}
}

?>