<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-2-15
 * Time: 下午4:26
 * To change this template use File | Settings | File Templates.
 * 本工具用于批量修改数据库中非序列号的photo字段，用完可删
 */
class Xuliehua extends  MY_Controller{
    function __construct(){
        parent :: __construct();
        $this->load->model("xuliehua_model",'m');
    }
    function index(){

        $list=$this->m->getlist();
        foreach($list as $item){
            $item['photo']=serialize($item['photo']);
            $this->m->update($item);
        }

    }
}

?>