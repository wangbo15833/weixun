<?php

/**
 * model
 *
 * @author        gefc
 * @version       1.0
 */
class Welcome_model extends MY_Model
{
	function __construct(){
		parent::__construct();
	}

	function getinfo(){
		$list = array();
		$query = $this->db->get('login_attempts');
		foreach($query->result() as $row){
			$list[] = $row;
		}
		return $list;
	}

    function get_Live_Info($data){
        $sql = 'SELECT *  FROM service_info AS c  WHERE 1=1  ';
        // if(isset($data['channel_id'])) $sql .= ' AND c.channel_id = '.$data['channel_id'];
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
        //$sql .='  limit '.$data['offset'].','.$data['limit'];
        //var_dump($sql);
        return $this->db->query($sql)->result_array();
    }


    function get_Happy_Info($data){
        $sql = 'SELECT *  FROM base_info AS c  WHERE 1=1  ';
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
        //$sql .='  limit '.$data['offset'].','.$data['limit'];
        // var_dump($sql);exit;
        return $this->db->query($sql)->result_array();
    }



    function get_Gourmet_Info($data){
        //var_dump($data);
        $sql = 'SELECT id,name,addr,phone,tag,price,photo,type_id,area_id,maps,dateline,state  FROM gourmet AS c  WHERE 1=1  ';
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
        //$sql .='  limit '.$data['offset'].','.$data['limit'];
         //var_dump($sql);exit;
        return $this->db->query($sql)->result_array();
    }
}

?>