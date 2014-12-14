<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-7
 * Time: 上午8:46
 * To change this template use File | Settings | File Templates.
 */


class Goods_model extends MY_Model {
    const BASEINFO = 'base_info';
    const CATEGORY = 'base_category';
    function __construct(){
        parent ::__construct();
    }

    /*
     * 增
     */

    /*
     * 添加商品信息
     */
    function add_goods($data){
        return $this->db->insert('goods', $data);
    }

    /*
     * 删
     */
    /*
    * 按ID删除商品信息
    */
    function del_goods($id){
        return $this->db->where('id', $id)->delete('goods');
    }


    /*
     * 改
     */
    /*
     * 更新商品信息
    */

    function updateGoods($data){
        $params = array();
        if(''!=$data['title']) $params['title'] = $data['title'];
        if(''!=$data['jianpin']) $params['jianpin'] = $data['jianpin'];
        if(''!=$data['quanpin']) $params['quanpin'] = $data['quanpin'];
        if(''!=$data['channelid']) $params['channelid'] = $data['channelid'];
        if(''!=$data['typeid']) $params['typeid'] = $data['typeid'];
        if(''!=$data['oprice']) $params['oprice'] = $data['oprice'];
        if(''!=$data['discount']) $params['discount'] = $data['discount'];
        if(''!=$data['cprice']) $params['cprice'] = $data['cprice'];
        if(''!=$data['tag']) $params['tag'] = $data['tag'];
        if(''!=$data['photo']) $params['photo'] = $data['photo'];
        if(''!=$data['sales']) $params['sales'] = $data['sales'];
        if(''!=$data['is_hot']) $params['is_hot'] = $data['is_hot'];
        if(''!=$data['state']) $params['state'] = $data['state'];
        if(''!=$data['description']) $params['description'] = $data['description'];
        if(''!=$data['content']) $params['content'] = $data['content'];
        if(''!=$data['quickmark']) $params['quickmark'] = $data['quickmark'];
        if(''!=$data['pubdate']) $params['pubdate'] = $data['pubdate'];
        if(''!=$data['uid']) $params['uid'] = $data['uid'];
        if(''!=$data['shopid']) $params['shopid'] = $data['shopid'];
        return $this->db->where('id',$data['id'])->update('goods', $params);
    }

    /*
     * 审核商品信息
     */
    function editCommodity($id, $is_status){
        echo  $this->db->where('id',$id)->update('goods', array('state'=>$is_status));
        //exit;
    }



    /*
     * 查
     */

    /*
     * 分页获取自己添加的商品列表
     */
    function get_goods_list($data){

        $sql ="SELECT * FROM goods WHERE uid=".UID ." order by pubdate desc limit ? , ?";
        return $this->db->query($sql,array($data['offset'],$data['limit']))->result_array();
    }

    /*
     * 获取自己添加的商品数量
     */

    function get_goods_list_count($data){
        $sql ="SELECT * FROM goods WHERE uid=".UID ;
        return $this->db->query($sql)->num_rows();
    }


    /*
     * 分页获取所有商品列表
     */
    function goods_list($data){

        return $this->db->order_by('pubdate','desc')->get('goods', $data['limit'], $data['offset'])->result_array();
    }

    /*
     * 获取所有商品数量
    */

    function goods_list_count(){
        return $this->db->count_all('goods');
    }

    /*
     * 按ID获取商品信息
     */
    function getGoodsById($id){
        return $this->db->where('id', $id)->get('goods')->row_array();
    }

}