<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-2-28
 * Time: 下午4:28
 * To change this template use File | Settings | File Templates.
 */

class Ordermeal extends  CI_Controller{

    function __construct(){
        parent :: __construct();
        $this->load->model('ordermeal_model','mordermeal');

    }

    function addOrderMeal(){
        $userid = $this->input->get_post('userid');
        $goodsid= $this->input->get_post('goodsid');
        $pubtime=time();
        $num= $this->input->get_post('num');
        $data=array('userid'=>$userid,'goodsid'=>$goodsid,'pubtime'=>$pubtime,'num'=>$num);
        $result=$this->mordermeal->add_ordermeal($data);
        print_r($result);
    }

    function getOrderByUser(){
        $userid = $this->input->get_post('userid');
        $list = $this->mordermeal->getOrderByUser($userid);
        $status=1;
        echo json_encode(array('status'=>$status,'list'=>$list));
    }


}