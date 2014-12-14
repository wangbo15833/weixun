<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-2
 * Time: 下午6:36
 * To change this template use File | Settings | File Templates.
 */

class Goodspic_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    function getGoodsPics($data){
        /*  if(($data['b_type']))  $this->db->where('b_type',$data['b_type']);
          else{
              if(($data['s_type']))  $this->db->where('s_type',$data['s_type']);
          }
          return $this->db->where('g_id', $data['g_id'])->get(self::GOURMET_PIC)->result_array();
          */
        //$sql = "select gc.name as s_type, gp.id as gp_id, picUrl, dateline,price,uid,title
        //from ".self::BASEINFOPIC." as gp, ".self::GOURMET_CATEGORY." as gc  where gp.s_type = gc.id and gp.g_id = ".$data['g_id'];
        //if($data['b_type']) $sql .= " and b_type = ".$data['b_type'];
        //if($data['s_type']) $sql .= " and s_type = ".$data['s_type'];

        $sql= "select * from goods_pic where gid=".$data['g_id'] ." order by dateline desc";

        //$sql .= " order by gp.dateline desc ";
        return $this->db->query($sql)->result_array();
    }


    function addGoodsPic($data){
        return $this->db->insert("goods_pic", $data);
    }

}