<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-8-3
 * Time: 上午9:33
 * To change this template use File | Settings | File Templates.
 */

class Live_model extends MY_Model {
    const BASECATEGORY = 'base_category';
    const SERVICEINFO  = 'service_info';
    const SERVICEINFOPIC = 'service_info_pic';
    const GOURMET_CATEGORY = "gourmet_category";
    const HOMECATEGORY = 'home_category';
    const HOUSEINFO = 'house_info';
    function __construct(){
        parent :: __construct();
    }

    function getHome_c($param){
        return $this->db->where('parent_id',$param)->get(self::HOMECATEGORY)->result_array();
    }


    function get_category($state =0){
        if($state == 0)
            $sql = "select * from ".self::BASECATEGORY ." WHERE channel_id = 5 order by sort";
        else
            $sql = "select * from ".self::BASECATEGORY ." WHERE channel_id = 7 order by sort";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param $data
     * @return mixed
     */
    function get_Live_Info($data){
        if(isset($data['type_id']) && $data['type_id'] == 55 && ($data['home_b'])){
            $sql = 'SELECT *  FROM '.self::SERVICEINFO.' AS c ,home_service_info as s WHERE c.id=s.serviceid  ';
        }else{
           $table =  (isset($data['type_id']) &&$data['type_id'] == 66)? self::HOUSEINFO : self::SERVICEINFO;
        $sql = 'SELECT *  FROM '.$table.' AS c  WHERE 1=1  ';
        }
        // if(isset($data['channel_id'])) $sql .= ' AND c.channel_id = '.$data['channel_id'];
        if(isset($data['home_b']) && $data['home_b'])$sql .= ' AND s.home_b = '.$data['home_b'];
        if(isset($data['type_id'])) $sql .= ' AND c.type = '.$data['type_id'];
        if(isset($data['area_id'])) $sql .= ' AND c.area_id = '.$data['area_id'];
        if(isset($data['name'])) $sql .= ' AND c.name like "%'.$data['c_title'].'%" ';
        $sql .= ' AND c.state =1 '. $data['where'];
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
        //var_dump($sql);
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param $data
     * @return mixed
     */
    function get_Live_Info_Count($data){
        $table =  (isset($data['type_id']) &&$data['type_id'] == 66)? self::HOUSEINFO : self::SERVICEINFO;
        $_sql = 'SELECT id FROM '. $table .' AS c WHERE 1=1 ';
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
    function detail($data, $type){
        $table = $type == 66 ? self::HOUSEINFO : self::SERVICEINFO;
        return  $this->db->where(array('id'=>$data,'state'=>1))->get($table)->row_array();
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
    function updateLive($data){
        $myStr = array('name'=> $data['txtName'],'addr'=> $data['txtAddress'],'phone'=> $data['txtPhone'],
            'tag'=> $data['txtTag'],'price'=> $data['txtPrice'],
            'type'=> $data['ddlCategory1'],'area_id'=> $data['ddlArea1'],'summary'=> $data['myContent']);
        return  $this->db->where('id',$data['g_id'])->update(self::SERVICEINFO, $myStr);
    }

    /**
     * @param $data
     * 添加美食图片
     * @return object
     */
    function addLivePic($data){
        return $this->db->insert(self::SERVICEINFOPIC, $data);
    }

    /**
     * 按条件获取店铺附图数据
     */
    function getLivePics($data){
        /*  if(($data['b_type']))  $this->db->where('b_type',$data['b_type']);
          else{
              if(($data['s_type']))  $this->db->where('s_type',$data['s_type']);
          }
          return $this->db->where('g_id', $data['g_id'])->get(self::GOURMET_PIC)->result_array();
          */
        $sql = "select gc.name as s_type, gp.id as gp_id, picUrl, dateline,price,uid,title
        from ".self::SERVICEINFOPIC." as gp, ".self::GOURMET_CATEGORY." as gc  where gp.s_type = gc.id and gp.g_id = ".$data['g_id'];
        if($data['b_type']) $sql .= " and b_type = ".$data['b_type'];
        if($data['s_type']) $sql .= " and s_type = ".$data['s_type'];

        $sql .= " order by gp.dateline desc ";
        return $this->db->query($sql)->result_array();
    }

    function getG_pic($data){
        $sql = "select gp.*, gc.name as gc_name from service_info_pic as gp left join  gourmet_category as gc  on  gp.s_type = gc.id  where  gp.g_id = ? and gp.b_type = ?  order by dateline desc limit ?";
        return $this->db->query($sql, array( $data['g_id'], $data['b_type'], $data['limit']))->result_array();
        /*
                return $this->db->where(array('b_type'=>$data['b_type'],'g_id'=> $data['g_id']))
                    ->order_by('dateline','desc')->limit($data['limit'])->get(self::GOURMET_PIC)->result_array();
        */
    }

    function addInfo($data){
        return $this->db->insert(self::SERVICEINFO, $data);
    }

}