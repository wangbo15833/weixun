<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lynx
 * Date: 14-1-28
 * Time: 下午12:21
 * To change this template use File | Settings | File Templates.
 */

class Goods_model extends MY_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_Goods_List($data){
        $sql='SELECT g.id as g_id,g.title as g_title,g.channelid as g_channelid,g.typeid as g_typeid,oprice,discount,cprice,g.tag as g_tag,g.photo as g_photo,sales,g.is_hot as g_is_hot,g.state as g_state,g.description as g_description,g.content as g_content,g.quickmark as g_quickmark,g.pubdate as g_pubdate,g.uid as g_uid,s.* FROM goods as g left join shops as s on g.shopid=s.shopid WHERE g.id > 0 ';
        if(isset($data['channelid'])) $sql .= ' AND g.channelid = '.$data['channelid'];
        if(isset($data['typeid'])) $sql .= ' AND g.typeid = '.$data['typeid'];
        if(isset($data['areaid'])) $sql .= ' AND s.areaid = '.$data['areaid'];
        if(isset($data['sname'])) $sql .= ' AND g.title like "%'.$data['sname'].'%" ';
        //$sql .= ' AND g.state=2 ';
        switch($data['order']){
            case 1:
                $sql .=' order by g.id desc';
                break;
            case 2:
                $sql .=' order by g.cprice desc';
                break;
            case 3:
                $sql .=' order by g.pubdate asc';
                break;
            case 4:
                $sql .=' order by g.pubdate desc';
                break;
        }

        $sql .=' limit '.$data['offset'].','.$data['limit'];
        return $this->db->query($sql)->result_array();

    }

    function count_Goods_List($data){
        $sql='SELECT * FROM goods as g left join shops as s on g.shopid=s.shopid WHERE g.id > 0 ';
        if(isset($data['channelid'])) $sql .= ' AND g.channelid = '.$data['channelid'];
        if(isset($data['typeid'])) $sql .= ' AND g.typeid = '.$data['typeid'];
        if(isset($data['areaid'])) $sql .= ' AND s.areaid = '.$data['areaid'];
        if(isset($data['sname'])) $sql .= ' AND g.title like "%'.$data['sname'].'%" ';
        //$sql .= ' AND g.state=2 ';
        $c_count =  $this->db->query($sql)->num_rows();
        return $c_count;
    }

    function detail($data){
        $sql='SELECT g.id as g_id,g.title as g_title,g.channelid as g_channelid,g.typeid as g_typeid,oprice,discount,cprice,g.tag as g_tag,g.photo as g_photo,sales,g.is_hot as g_is_hot,g.state as g_state,g.description as g_description,g.content as g_content,g.quickmark as g_quickmark,g.pubdate as g_pubdate,g.uid as g_uid,s.* FROM goods as g left join shops as s on g.shopid=s.shopid WHERE g.id = '.$data;
        return $this->db->query($sql)->row_array();
    }

    function update_quickmark($data){
        $myStr = array('quickmark'=> $data['g_quickmark'],'pubdate' => time());
        return  $this->db->where('id',$data['g_id'])->update('goods', $myStr);
    }


    function getG_pic($data){
        $sql = "select gp.*, gc.name as gc_name from base_info_pic as gp left join  gourmet_category as gc  on  gp.s_type = gc.id  where  gp.g_id = ? and gp.b_type = ?  order by dateline desc limit ?";
        return $this->db->query($sql, array( $data['g_id'], $data['b_type'], $data['limit']))->result_array();
        /*
                return $this->db->where(array('b_type'=>$data['b_type'],'g_id'=> $data['g_id']))
                    ->order_by('dateline','desc')->limit($data['limit'])->get(self::GOURMET_PIC)->result_array();
        */
    }

    function getGoodsById($data){
        return $this->db->where(array('id'=>$data))->get('goods')->row_array();
    }


    function  get_search($data){
        $sql = "SELECT * from goods where title like '%".$data['c_title']."%'";
        return $this->db->query($sql)->result_array();
    }

}