<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-9
 * Time: 下午1:49
 * To change this template use File | Settings | File Templates.
 */

/**
 * 管理网站会员
 */
class User extends MY_Controller{
    function __construct() {
        parent :: __construct();
        $this->load->model('admin_model','madmin');
        $this->load->model('user_model','muser');


    }
    function userManager($page = 1, $state = 0){
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $data = $this->muser->userManager($param);
        //获取总数
        $shopCount = $this->muser->userManager_count();
        $pageShow = $this->_mkPage($page, $shopCount,'/user/userManager');
        $this->load->view('default/user_manager',array('usersData'=>$data,'showPage'=>$pageShow,'state'=>$state));
    }

    public function editUser($value='',$status='')
    {
        if(!$value || !$status) show_error(array('传入参数错误！','<a href="'.WEB_URL.'setting/index/userManager">点击返回</a>'));
        $this->muser->editUser($value, $status);
        $this->userManager(1, 1);
    }

}