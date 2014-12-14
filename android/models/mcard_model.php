<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-31
 * Time: 下午8:19
 * To change this template use File | Settings | File Templates.
 */
class Mcard_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    function add_mcard($data){
        return $this->db->insert('mcard', $data);
    }

    function get_mcard_list($param){
        return $this->db->where(array('shop_id'=>$param))->get('mcard')->result_array();
    }

    function getMcardByTel($param){
        return $this->db->where(array('tel'=>$param))->get('mcard')->result_array();
    }

    function getMcardByTelShop($tel,$shopid){
        return $this->db->where(array('tel'=>$tel,'shopid'=>$shopid))->get('mcard')->row_array();
    }

    function jfAdd($mcid,$jf){
        $sql= "UPDATE mcard set jf=jf+".$jf ." WHERE mcid=".$mcid;
        return $this->db->query($sql);
    }

	function jfdh($mcid,$jf){
		$sql = "UPDATE mcard set jf=jf-".$jf." WHERE mcid=".$mcid;
		return $this->db->query($sql);
	}

}