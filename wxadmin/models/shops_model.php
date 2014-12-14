<?php
/**
 * @author gefc
 * @version 1.0
 * @desc 店铺相关函数
 */
class Shops_model extends MY_Model
{
    const TABLE = "shops";

    function __construct()
    {
        parent::__construct();
    }

    /*
     * 增
     */

    /*
     * 添加新商铺
     */
    public function addShops($data)
    {
        $this->db->insert(self::TABLE, $data);
    }


    /*
     * 改
     */

    /*
     * 更新商铺信息
     */
    public function editShops($data)
    {

        return $this->db->where('id', $data['id'])->update(self::TABLE, array('title' => $data['title'],
            'summary' => $data['summary'], 'content' => $data['content'], 'phone' => $data['phone'], 'tag' => $data['tag']));
    }


    //审核店铺
    function auditShops($id, $is_status){
        return  $this->db->where('id',$id)->update(self::TABLE, array('is_status'=>$is_status));
    }


    /**
     * 把店铺放入回收站，并没有从数据库中删除
     */
    public function delshops($data)
    {
        return $this->db->where(array('id' => $data['id'], 'uid' => $data['uid'], 'is_status' => $data['is_status']))->update(self::TABLE, array('is_status' => 3));
    }


    /*
     * 查
     */

    /**
     * 分页按审核状态获取自己添加的店铺
     */
    function getShops($data)
    {
        return $this->db->where(array('is_status' => $data['status'], 'uid' => $data['uid']))->order_by('pubdate', 'desc')->get('shops', $data['limit'], $data['offset'])->result_array();
    }

    /**
     * 按审核状态获取自己添加的店铺数量
     */

    function  getShops_count($data)
    {

        return $this->db->where(array('is_status' => $data['status'], 'uid' => $data['uid']))->count_all_results(self::TABLE);
    }

    /**
     * 获取自己状态为2的店铺列表
     */
    function getShopsByUid($uid = '')
    {
        $list = $this->db->where(array('uid' => $uid, 'is_status' => 2))->order_by('pubdate', 'desc')->get('shops')->result_array();
        return $list;
    }


    /*
     * 按ID获取店铺信息
    */
    public function getShopsInfo($id = '')
    {
        $arr = $this->db->where('id', $id)->get(self::TABLE)->result_array();
        return $arr;
    }


    /**
     * 分页按审核状态获取某一状态店铺列表
     */
    function shopManager($data){
        if(array_key_exists('status', $data))
            $this->db->where('is_status',$data['status']);
        return $this->db->order_by('pubdate','desc')->get('shops', $data['limit'], $data['offset'])->result_array();
    }

    /*
     * 获取所有店铺数量
     */

    function shopManager_count(){

        return $this->db->count_all('shops');
    }



    function getShopsIds($uid = '')
    {
        $list = $this->db->where(array('uid' => $uid, 'is_status' => 2))->select('id')->get(self::TABLE)->result_array();
        return $list;
    }

}

?>