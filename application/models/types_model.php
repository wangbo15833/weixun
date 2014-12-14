<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-29
 * Time: 下午9:42
 * To change this template use File | Settings | File Templates.
 */

class Types_model extends MY_Model{

    /**
     * @param $channel_id
     * @return mixed
     * 按频道获取类型列表
     */
    function getTypesByChannel($data){
        return $this->db->where(array('channelid'=>$data))->limit(9)->get('types')->result_array();
    }
}