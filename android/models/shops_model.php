<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-3-28
 * Time: 上午9:51
 * To change this template use File | Settings | File Templates.
 */

class Shops_model extends MY_Model{
    const TABLE="shops";
    function __construct(){
        parent::__construct();
    }

    /*
     * 添加店铺
     */
    function shopAdd($param){
        return $this->db->insert('shops', $param);
    }

    /**
     * 按规则获取商铺信息
     *
     */
    function getShopsByUid($uid){
        return $this->db->where(array('uid'=>$uid))->get(self::TABLE)->result_array();
    }

    /**
     * @param $data
     * @return mixed
     * 按ID查询商铺详情
     */
    function detail($shopid){
        $sql="SELECT * from shops WHERE shopid=".$shopid;
        return $this->db->query($sql)->row_array();
    }

    function shopUpdate($shopid,$param){
        return $this->db->where(array('shopid'=>$shopid))->update('shops',$param);
    }

    function get_Shops_List($data){
        $sql='SELECT *,t.id as tid from shops s left join types t on s.type_id=t.id WHERE shopid>0';
        if($data['channel_id'])     $sql .= ' AND channel_id = '.$data['channel_id'];
        if(isset($data['type_id'])) $sql .= ' AND type_id = '.$data['type_id'];
        if(isset($data['area_id'])) $sql .= ' AND area_id = '.$data['area_id'];
        if(isset($data['isMyfind'])) $sql .= ' AND is_myfind = '.$data['isMyfind'];
        if(isset($data['search_key']))     $sql .= ' AND title like "%'.$data['search_key'].'%" ';
        if(isset($data['map_x'])) $sql .=' AND GetDistance('.$data['map_y'].','.$data['map_x'].',map_y,map_x)<'.$data['distance'];
        //$sql .= ' AND g.state=2 ';
        switch($data['order']){
            case 1:
                $sql .=' order by shopid desc';
                break;
            case 2:
                $sql .=' order by pubdate asc';
                break;
        }

        $sql .=' limit '.$data['offset'].','.$data['limit'];
        //print_r($sql);exit;
        return $this->db->query($sql)->result_array();

    }

    function test_getShop(){
        $sql="SELECT * from shops where GetDistance(40.0329,119.713616,map_y,map_x)<1";
        return $this->db->query($sql)->result_array();

    }

}