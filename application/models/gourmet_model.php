<?php

/**
 * model
 *
 * @author        gefc
 * @version       1.0
 */
class Gourmet_model extends MY_Model
{
    const GOURMET="gourmet";
    const GOURMET_CATEGORY = "gourmet_category";
    const GOURMET_PIC = "gourmet_pic";
    const APPRAISAL="appraisal";
	function __construct(){
		parent::__construct();
	}

    /**
     * @param $data
     * @return mixed
     */
    function get_Gourmet_Info($data){
        $sql = 'SELECT id,name,addr,phone,tag,price,photo,type_id,area_id,maps,dateline,state  FROM '.self::GOURMET.' AS c  WHERE 1=1  ';
       // if(isset($data['channel_id'])) $sql .= ' AND c.channel_id = '.$data['channel_id'];
        if(isset($data['type_id'])) $sql .= ' AND c.type_id = '.$data['type_id'];
        if(isset($data['area_id'])) $sql .= ' AND c.area_id = '.$data['area_id'];
        if(isset($data['name'])) $sql .= ' AND c.name like "%'.$data['c_title'].'%" ';
        $sql .= ' AND c.state =1 ';
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
    function get_Gourmet_Info_Count($data){
        $_sql = 'SELECT id FROM '.self::GOURMET.' AS c WHERE 1=1 ';
        //if(isset($data['channel_id'])) $_sql .= ' AND c.channel_id = '.$data['channel_id'];
        if(isset($data['type_id'])) $_sql .= ' AND c.type_id = '.$data['type_id'];
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
    function gourmet_detail($data){
       return  $this->db->where(array('id'=>$data,'state'=>1))->get(self::GOURMET)->row_array();
    }

    /**
     * @param $data
     * @return mixed
     */


    /**
     * @param $param
     * @return mixed
     */


    /**
     * @param $data
     * @return mixed
     */
    function updateGourmet($data){
        $myStr = array('name'=> $data['txtName'],'addr'=> $data['txtAddress'],'phone'=> $data['txtPhone'],
            'tag'=> $data['txtTag'],'price'=> $data['txtPrice'],
            'type_id'=> $data['ddlCategory'],'area_id'=> $data['ddlArea'],'summary'=> $data['myContent']);
       return  $this->db->where('id',$data['g_id'])->update(self::GOURMET, $myStr);
    }

    

    /**
     * @param $data
     * 添加美食图片
     * @return object
     */
    function addGourmetPic($data){
        return $this->db->insert(self::GOURMET_PIC, $data);
    }

    /**
     * @param $data
     * 添加图片分类标题
     */
    function addGourmetCategory($data){
         $this->db->insert(self::GOURMET_CATEGORY, $data);
        return $this->db->insert_id();
    }

    /**
     * 获取分类信息
     */
     function getGourmetCategory($data){
         if(isset($data['g_id'])) $this->db->where('g_id',$data['g_id']);
         return $this->db->where('parentid',$data['parentid'])->get(self::GOURMET_CATEGORY)->result_array();

    }

    function get_gc_list($g_id){
        return $this->db->where('g_id',$g_id)->get(self::GOURMET_CATEGORY)->result_array();
    }
    /**
     * 按条件获取店铺附图数据
     */
    function getGourmetPics($data){
      /*  if(($data['b_type']))  $this->db->where('b_type',$data['b_type']);
        else{
            if(($data['s_type']))  $this->db->where('s_type',$data['s_type']);
        }
        return $this->db->where('g_id', $data['g_id'])->get(self::GOURMET_PIC)->result_array();
        */
        $sql = "select gc.name as s_type, gp.id as gp_id, picUrl, dateline,price,uid,title
        from ".self::GOURMET_PIC." as gp, ".self::GOURMET_CATEGORY." as gc  where gp.s_type = gc.id and gp.g_id = ".$data['g_id'];
        if($data['b_type']) $sql .= " and b_type = ".$data['b_type'];
        if($data['s_type']) $sql .= " and s_type = ".$data['s_type'];

        $sql .= " order by gp.dateline desc ";
        return $this->db->query($sql)->result_array();
    }

    function getGourmetIn($data){
       return $this->db->where('state',1)->where_in('id',$data)->get(self::GOURMET)->result_array();
    }

    function getG_pic($data){
        $sql = "select gp.*, gc.name as gc_name from gourmet_pic as gp left join  gourmet_category as gc  on  gp.s_type = gc.id  where  gp.g_id = ? and gp.b_type = ?  order by dateline desc limit ?";
        return $this->db->query($sql, array( $data['g_id'], $data['b_type'], $data['limit']))->result_array();
/*
        return $this->db->where(array('b_type'=>$data['b_type'],'g_id'=> $data['g_id']))
            ->order_by('dateline','desc')->limit($data['limit'])->get(self::GOURMET_PIC)->result_array();
*/
    }

    /**
     * 添加美食数据
     */
    public function addGourmet($data)
    {
        return $this->db->insert(self::GOURMET,$data);
    }
}

?>