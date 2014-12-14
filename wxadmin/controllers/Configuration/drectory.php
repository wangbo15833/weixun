<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-8-21
 * Time: 上午9:24
 * To change this template use File | Settings | File Templates.
 */

class Drectory extends MY_Controller {
    function __construct(){
        parent :: __construct();
        $this->load->model('sysmenu_model','msysmenu');
    }

    function getD(){
        $list = $this->msysmenu->getD();
        $a = array();
        foreach($list as $item){
            if($item['is_type'] == 1) $item['is_type'] = '普通会员';
            elseif($item['is_type'] == 10) $item['is_type'] = '管理员';
            elseif($item['is_type'] == 100) $item['is_type'] = '超级管理员';
            $item['state'] = $item['is_state'] == 1 ? '正常' : '禁用';
            $a[] = $item;
        }
        $this->load->view('default/drectory', array('info'=> $a));
    }

    function delD($id = 0, $state = 0){
        $i = 0;
        if($id == 0) $i = 1; //重新加载
        if($i != 1)
        $this->msysmenu->delD($id, $state);
        redirect('Configuration/drectory/getD');
        //self::getD();
    }

    function addD(){
        $typeState = $this->input->get_post('typeState') ? $this->input->get_post('typeState') : 1;
        if($typeState == 1){
            //redirect('config/d_add');
            $this->load->view('default/drectory_add');
            return;
        }
        $name = $this->input->get_post('name') ? htmlspecialchars($this->input->get_post('name')) : '';
        $name_param = $this->input->get_post('name_param') ? htmlspecialchars($this->input->get_post('name_param')) : '';
        $url = $this->input->get_post('url') ? htmlspecialchars($this->input->get_post('url')) : '';
        $is_type = $this->input->get_post('is_type') ? htmlspecialchars($this->input->get_post('is_type')) : 1;
        $data = array('name' => $name,'name_param' => $name_param,'url' => $url,'is_type' => $is_type, 'is_state' => 1);
        //var_dump($data);exit;
        $this->msysmenu->addD($data);
        redirect('Configuration/drectory/getD');
    }
}