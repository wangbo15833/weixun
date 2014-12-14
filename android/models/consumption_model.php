<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-31
 * Time: 下午8:19
 * To change this template use File | Settings | File Templates.
 */
class Consumption_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    function add_consumption($data){
        return $this->db->insert('consumption', $data);
    }

    function getConsumptionByShopID($param){
		return $this->db->where(array('shopid'=>$param))->get('consumption')->result_array();
        
    }

    function getConsumptionByUid($param){
		$sql="select * from consumption as c left join mcard as m on c.mcid=m.mcid left join user as u on m.tel=u.tel where u.id=".$param;
        return $this->db->query($sql)->result_array();
    }

}