<?php

/**
 * model
 *
 * @author        gefc
 * @version       1.0
 */
class Shoucang_model extends MY_Model
{
   const COLLECTION='collection';
   
   const COMMODITY= 'commodity';
    const USER_MATERIAL= 'user_material';
    const USER ='user';
   
	function __construct(){
		parent::__construct();
	}


	

	
	function wdscsp($a){
        if(!is_array($a))return false;
		foreach ($a as $value)
		{
		   $query[]=$this->db->where(array('id'=>$value))->get(self::COMMODITY)->row_array();
		}
		return $query;
	}



    /**
     * 获取用户收藏总数
     * @param $data
     * @return mixed
     */






    /**
     * 获取用户信息
     */

}
?>