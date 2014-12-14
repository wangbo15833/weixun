<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-22
 * Time: 上午8:33
 * To change this template use File | Settings | File Templates.
 */
 
class Index_model extends MY_Model {
    /**
     *
     */
    const USER = 'user';
    const USERMATERIAL = 'user_material';
    /**
     *
     */
    const COMMODITY = 'commodity';
    /**
     *
     */
    const SHOPS = 'shops';
    /**
     *
     */
    const AREA = 'area';
    /**
     *
     */
    const AD = 'ad';
    /**
     *
     */
    const DISTRICT ='district';
    /**
     *
     */
    const GOODS_CATEGORY = 'goods_category';
    /**
     *
     */


    /**
     *
     */
	 
	const COLLECTION='collection';
    function __construct(){
        parent :: __construct();
    }


    /**
     * 获取搜索结果
     * @return mixed
     */


    /**
     * @param $data
     * @return mixed
     */

    /*接口pShop用到了这个方法，要改成别的，暂时不删*/
    function get_c_info($data){
        $sql = 'SELECT c.*,s.title as s_title,s.summary as s_summary , s.address as addr , s.phone as phone
        ,s.tag as tag
        FROM commodity AS c , shops AS s WHERE c.shops_id = s.id ';
        if(isset($data['channel_id'])) $sql .= ' AND c.channel_id = '.$data['channel_id'];
        if(isset($data['type'])) $sql .= ' AND c.type = '.$data['type'];
        if(isset($data['district_id'])) $sql .= ' AND s.district_id = '.$data['district_id'];
        if(isset($data['c_title'])) $sql .= ' AND c.title like "%'.$data['c_title'].'%" ';
        $sql .= ' and s.city_id = '.$data['city_id'].' AND c.is_status =2 ';
        switch($data['data_status']){
            case 2://销量从高到低
                $sql .= ' order by c.num desc';
                break;
            case 3://价格从低到高
                $sql .= ' order by c.price asc';
                break;
            case 4://价格从高到低
                $sql .= ' order by c.price desc';
                break;
            case 5://时间从新到旧
                $sql .= ' order by c.dateline desc';
                break;
            default:
                $sql .= ' order by c.dateline desc ';
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

    /*接口pShop用到了这个方法，要改成别的，暂时不删*/
    function count_c_info($data){
        $_sql = 'SELECT count(*) as count FROM commodity AS c , shops AS s WHERE c.shops_id = s.id';
        if(isset($data['channel_id'])) $_sql .= ' AND c.channel_id = '.$data['channel_id'];
        if(isset($data['type'])) $_sql .= ' AND c.type = '.$data['type'];
        if(isset($data['district_id'])) $_sql .= ' AND s.district_id = '.$data['district_id'];
        if(isset($data['c_title'])) $_sql .= ' AND c.title like "%'.$data['c_title'].'%" ';
        $_sql .= ' and s.city_id = '.$data['city_id'].'  AND c.is_status =2';
        $c_count =  $this->db->query($_sql)->result_array();
        return $c_count[0]['count'];
    }







}