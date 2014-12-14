<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-8-2
 * Time: 上午8:42
 * To change this template use File | Settings | File Templates.
 */

class Happy_model extends MY_Model{
    const BASECATEGORY = 'base_category';
    const BASEINFO  = 'base_info';
    const BASEINFOPIC = 'base_info_pic';
    const GOURMET_CATEGORY = "gourmet_category";
    function __construct(){
        parent :: __construct();
    }

    function get_category($state =0){
        if($state == 0)
            $sql = "select * from ".self::BASECATEGORY ." WHERE channel_id = 6 order by sort";
        else
            $sql = "select * from ".self::BASECATEGORY ." WHERE channel_id = 3 order by sort";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param $data
     * @return mixed
     */
    function get_Happy_Info($data){
        $sql = 'SELECT *  FROM '.self::BASEINFO.' AS c  WHERE 1=1  ';
        // if(isset($data['channel_id'])) $sql .= ' AND c.channel_id = '.$data['channel_id'];
        if(isset($data['type_id'])) $sql .= ' AND c.type = '.$data['type_id'];
        if(isset($data['area_id'])) $sql .= ' AND c.area_id = '.$data['area_id'];
        if(isset($data['name'])) $sql .= ' AND c.name like "%'.$data['c_title'].'%" ';
        $sql .= ' AND c.state =1 ' . $data['where'];
        switch($data['data_status']){
            case 2://价格从低到高
                $sql .= ' order by c.price asc';
                break;
            case 3://价格从高到低
                $sql .= ' order by c.price desc';
                break;
            case 4://时间从新到旧
                $sql .= ' order by c.dateline desc';
                break;
            default:
                $sql .= ' order by c.dateline asc ';
                break;
        }
        $sql .='  limit '.$data['offset'].','.$data['limit'];
        // var_dump($sql);exit;
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param $data
     * @return mixed
     */
    function get_Happy_Info_Count($data){
        $_sql = 'SELECT id FROM '.self::BASEINFO.' AS c WHERE 1=1 ';
        //if(isset($data['channel_id'])) $_sql .= ' AND c.channel_id = '.$data['channel_id'];
        if(isset($data['type_id'])) $_sql .= ' AND c.type = '.$data['type_id'];
        if(isset($data['area_id'])) $_sql .= ' AND c.area_id = '.$data['area_id'];
        if(isset($data['name'])) $_sql .= ' AND c.name like "%'.$data['c_title'].'%" ';
        $_sql .= '  AND c.state =1';
        $c_count =  $this->db->query($_sql)->num_rows();
        return $c_count;
    }

    /**
     * @param $data
     * @return mixed
     */
    function detail($data){
        return  $this->db->where(array('id'=>$data,'state'=>1))->get(self::BASEINFO)->row_array();
    }

    /**
     * @param $data
     * @return mixed
     * 更新二维码
     */
    

    /**
     * @param $data
     * @return mixed
     */
    function updateHappy($data){
        $myStr = array('name'=> $data['txtName'],'addr'=> $data['txtAddress'],'phone'=> $data['txtPhone'],
            'tag'=> $data['txtTag'],'price'=> $data['txtPrice'],
            'type'=> $data['ddlCategory1'],'area_id'=> $data['ddlArea1'],'summary'=> $data['myContent']);
        return  $this->db->where('id',$data['g_id'])->update(self::BASEINFO, $myStr);
    }

    /**
     * @param $data
     * 添加美食图片
     * @return object
     */


    /**
     * 按条件获取店铺附图数据
     */


    function getG_pic($data){
        $sql = "select gp.*, gc.name as gc_name from base_info_pic as gp left join  gourmet_category as gc  on  gp.s_type = gc.id  where  gp.g_id = ? and gp.b_type = ?  order by dateline desc limit ?";
        return $this->db->query($sql, array( $data['g_id'], $data['b_type'], $data['limit']))->result_array();
        /*
                return $this->db->where(array('b_type'=>$data['b_type'],'g_id'=> $data['g_id']))
                    ->order_by('dateline','desc')->limit($data['limit'])->get(self::GOURMET_PIC)->result_array();
        */
    }

    function addInfo($data){
       return $this->db->insert(self::BASEINFO, $data);
    }
}