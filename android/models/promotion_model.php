<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-3-28
 * Time: 下午3:56
 * To change this template use File | Settings | File Templates.
 */

class Promotion_model extends MY_Model{
    const TABLE="shops";
    function __construct(){
        parent::__construct();
    }

    /*
     * 添加优惠活动
     */
    function promotionAdd($param){
        return $this->db->insert('promotion', $param);
    }

    /*
     * 删除优惠活动
     */
    function promotionDel($param){
        return $this->db->where(array('pid'=>$param))->delete('promotion');
    }

    /*
     * 更新优惠活动信息
     */
    function promotionUpdate($pid,$param){
        return $this->db->where(array('pid'=>$pid))->update('promotion',$param);
    }

    /*
     * 获取某一店铺的优惠活动信息
     */

    function getPromotionByShop($shopid){
        return $this->db->where(array('shopid'=>$shopid))->get('promotion')->result_array();
    }

    /*
     * 获取所有优惠信息
     */
    function getAllPromotions(){
        return $this->db->get('promotion')->result_array();
    }

    /*
     * 获取一定数量的优惠信息
     */
    function getPromotionByLimit(){
        return $this->db->get('promotion',5,0)->result_array();
    }

    function detail($pid){
        //$sql="SELECT * from shops WHERE shopid=".$shopid;
        return $this->db->where(array('pid'=>$pid))->get('promotion')->row_array();
    }

}