<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-4-25
 * Time: 上午11:36
 * To change this template use File | Settings | File Templates.
 */

class Coupons_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    /*
     * 发放优惠劵
     */
    function couponsAdd($param){
        $this->db->insert('coupons', $param);
        return $this->db->insert_id();
    }

    function couponsMapAdd($couponsid,$ownerid){
        $data=array('couid'=>$couponsid,'ownerid'=>$ownerid);
        return $this->db->insert('couponsmap',$data);
    }

    /*
     * 通过Receiver字段获取通知
     */
    function getCouponsByReciver($param){
        return $this->db->from('couponsmap')->join('coupons','coupons.couid=couponsmap.couid')->where(array('ownerid'=>$param))->get()->result_array();
    }


    /*
     * 删除个人通知
     */
    function couponsDel($param){
        return $this->db->where(array('couid'=>$param))->delete('couponsmap');
    }

	function getCouponsByID($couid){
		return $this->db->from('couponsmap')->join('coupons','couponsmap.couid=coupons.couid')->where(array('cmid'=>$couid))->get()->row_array();
	}

	function useCoupons($couid){
		return $this->db->where(array('cmid'=>$couid))->update('couponsmap',array('isused'=>1));
	}


}