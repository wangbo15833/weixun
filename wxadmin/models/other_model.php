<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-6
 * Time: 下午4:29
 * To change this template use File | Settings | File Templates.
 */

/*把shop_model中与shop无关的函数暂时转存到这里*/
class Other_model extends MY_Model{
    const COMMODITY="commodity";
    const CATEGORY = "category";
    const G_CATEGORY = "goods_category";
    const PREFERENTIAL = "preferential";
    function __construct(){
        parent::__construct();
    }

    /********************商品相关 start*********************/
    /**
     * 添加新商品
     */
    public function addCommodityInfo($data = '')
    {
        if (!$data) return false;
        $state = $this->db->insert(self::COMMODITY, $data);
        return $state;
    }

    /**
     * 获取发布商品信息
     */
    public function getCommodityInfo($data = '')
    {
        if (!$data) return false;
        $list = $this->db->where_in('shops_id', $data['shops_id'])->order_by('dateline', 'desc')->get(self::COMMODITY, $data['limit'], $data['offset'])->result_array();
        return $list;
    }

    public function getCommodityInfo_count($data = '')
    {
        if (!$data) return false;
        $list = $this->db->where_in('shops_id', $data['shops_id'])->count_all_results(self::COMMODITY);
        return $list;
    }

    /**
     * 标记删除记录
     */
    public function delCommodityInfo($value = '')
    {
        $this->db->where(array('id' => $value))->delete(self::COMMODITY);
    }

    /**
     * 获取一条商品信息
     */
    function getCommodityById($id)
    {
        $list = array();
        if (!$id) return $list;
        $list = $this->db->where('id', $id)->get(self::COMMODITY)->result_array();
        return $list;
    }

    function getCommodity($uid)
    {
        $this->db->where('is_status', 2);
        $list = $this->db->where('uid', $uid)->order_by('dateline', 'desc')->get(self::COMMODITY)->result_array();
        return $list;
    }

    /**
     *
     */
    function editCommodityInfo($data)
    {
        $arr = array('shops_id' => $data['shops_id'], 'title' => $data['title'], 'jianjie' => $data['jianjie'], 'content' => $data['content'],
            'price' => $data['price'], 'discount' => $data['discount'], 'new_price' => $data['new_price'], 'dateline' => time());
        return $this->db->where(array('id' => $data['id']))->update(self::COMMODITY, $arr);
    }

    /********************商品相关 end*********************/


    /**
     * 获取分类信息
     * @author gefc
     */



    public function getCategoryById($id = '')
    {
        $list = $this->db->where(array('channel_id' => $id, 'is_display' => 1, 'parent_id' => 0))->get(self::G_CATEGORY)->result_array();
        return $list;
    }



    /**
     *
     */
    public function addPreferentialInfo($data)
    {
        return $this->db->insert(self::PREFERENTIAL, $data);
    }

    /**
     *
     */
    public function getPreferentialInfo($data = '')
    {
        $data = $this->db->where(array('uid' => $data['uid'], 'is_status' => 1))->order_by('datetime', 'desc')->get(self::PREFERENTIAL, $data['limit'], $data['offset'])->result_array();
        return $data;
    }

    public function getPreferentialInfo_count($data = '')
    {
        $data = $this->db->where(array('uid' => $data['uid'], 'is_status' => 1))->count_all_results(self::PREFERENTIAL);
        return $data;
    }

    /**
     *
     */
    public function delPreferentialInfo($value = '')
    {
        return $this->db->where(array('id' => $value))->update(self::PREFERENTIAL, array('is_status' => 2));
    }

    /**
     *
     */
    public function editPreferential($id = '')
    {
        return $this->db->where('id', $id)->get(self::PREFERENTIAL)->result_array();
    }

    public function updatePreferential($data = '')
    {
        return $this->db->where('id', $data['id'])->update(self::PREFERENTIAL, array('commodity' => $data['commodity'],
            'zhekou' => $data['zhekou'], 'jianjie' => $data['jianjie'], 'datetime' => time()));
    }



}