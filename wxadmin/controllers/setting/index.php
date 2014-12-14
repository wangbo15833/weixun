<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * 管理员各种管理函数
     * @author gefc
     * @data 20130507
     */
    class Index extends MY_Controller {
        const PAGESIZE = 10;
        function __construct() {
            parent :: __construct();
            $this->load->model('Manager_model','manager');
            $this->load->model('shops_model','mshops');
            $this->load->model('goods_model','mgoods');
            $this->load->model('types_model','mtypes');
            $this->load->model('wposition_model','mwposition');
            $this->load->helper('common');
        }


         
         /**
         * 管理打折信息
         */
         function perferentialManager($page = 1, $state = 0){
             $offset = ($page-1) * self::PAGESIZE;
             $param['limit'] = self::PAGESIZE;
             $param['offset'] = $offset;
             $data = $this->manager->perferentialManager($param);
             $newData = array();
             foreach($data as $item){
                 $item['jianjie1'] = utf8substr($item['jianjie'], 0, 18);
                 //var_dump($users);
                 $commodityinfo = $this->manager->getCommodityById($item['commodity']);
                 //var_dump($item['shops_id']);exit;
                 $item['commodity'] = isset($commodityinfo[0]['title']) ? $commodityinfo[0]['title'] : '';
                 $users = self::getUserinfoById($item['uid']);
                 $item['uid']= count($users) > 0 ? $users[0]['username'] : '保密';
                 $newData[] = $item;
             }
             //获取总数
             $shopCount = $this->manager->perferentialManager_count();
             $pageShow = $this->_mkPage($page, $shopCount,'/setting/index/perferentialManager');
             $this->load->view('default/shops_managerPerferential',array('shopsData'=>$newData,'showPage'=>$pageShow, 'state'=>$state));
         }
         
         public function editperferential($value='',$status='')
         {
             if(!$value || !$status) show_error(array('传入参数错误！','<a href="'.WEB_URL.'setting/index/perferentialManager">点击返回</a>'));
             $this->manager->editperferential($value, $status);
             $this->perferentialManager(1,1);
         }
        

         /*****===================以上 获取各种待操作列表   END  以下操作动作 START========================**/

    }
    
?>