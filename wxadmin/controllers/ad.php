<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-9
 * Time: 上午8:58
 * To change this template use File | Settings | File Templates.
 */

class Ad extends MY_Controller{
    function __construct() {
        parent :: __construct();
        $this->load->model('ad_model','mad');
        $this->load->model('Channel_model','mchannel');

    }

    function adManager(){
        $ads = $this->mad->getAdInfo();
        $lists = array();
        foreach($ads as $item){
            $item['photoUrl'] = base_url() . unserialize($item['photoUrl']);
            //var_dump($item['type']);
            $lists[] = $item;
        }
        $this->load->view('default/ad_mamager',array('adLists'=>$lists));
    }

    function add_adManager(){
        $userManager_status = get_post('adState') ? htmlspecialchars(get_post('adState')) : '';
        if(!$userManager_status){
            $channels = $this->mchannel->getChannel();
            //添加表单token
            $token = self::grante_token(UID);
            $this->load->view('default/ad_add', array('token'=>$token,'channels'=>$channels));
        }else{
            $picUrl = get_post('pics') ? htmlspecialchars(get_post('pics')) : '';//图片地址
            $pic_type = intval(get_post('type'));//类型
            $pic_site = intval(get_post('site')); //图片显示区域 1 左侧 2 右侧
            $form_token = get_post('token');
            $Data = array('photoUrl'=>serialize($picUrl),'type'=>$pic_type,'site'=>$pic_site,'is_status'=>1);
            if(self::is_token(UID, $form_token)){
                $stste = $this->mad->addAdInfo($Data);
                self::drop_token(UID);
                if(STATUS > 1) $this->adManager(1,1);
                else $this->adManager(1,1);
            }else {
                if(STATUS > 1) $this->adManager(1);
                else $this->adManager(1);
            }
        }
    }

    public function editAd($value='',$status='')
    {
        if(!$value || !$status) show_error(array('传入参数错误！','<a href="'.WEB_URL.'setting/index/shopManager">点击返回</a>'));
        $this->mad->editAd($value, $status);
        $this->adManager();
    }
}