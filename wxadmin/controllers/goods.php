<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-7
 * Time: 上午8:43
 * To change this template use File | Settings | File Templates.
 */
class Goods extends MY_Controller{
    function __construct(){
        parent :: __construct();
        $this->load->model('goods_model','mgoods');
		$this->load->model('channel_model','mchannel');
        $this->load->model('shops_model','mshops');
        $this->load->library('Pinyin');
    }
    /**
     * 按分页获取美食店铺数据
     */
    public function getGoodsList()
    {
        $page = $this->input->get_post('page') ? intval($this->input->get_post('page')):1;
        //$m_uid = get_post('mm')?get_post('mm') : 0;
        //if($m_uid == 0 && $mm > 0) $m_uid =1;
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        //$param['type'] = 7;
        //$param['m_uid'] = $m_uid;
        $newData  = array();
        $goods = $this->mgoods->get_goods_list($param);
        //var_dump($goods);exit;
        foreach($goods as $item){
            $item['new_summary'] = utf8substr($item['description'], 0, 16);
            $item['new_title'] = utf8substr($item['title'],0,6);
            $item['dateline'] = friendlyDate($item['pubdate']);
            $newData[] = $item;
        }
        $count = $this->mgoods->get_goods_list_count($param);
        //var_dump($count);exit;
        $pageShow = self::mkPage($page, $count,'/goods/getGoodsList');
        $this->load->view('default/goods_list', array('info'=> $newData, 'pageShow'=> $pageShow));
    }

    /**
     * 处理美食数据   删除
     */
    public function handle($id = 0,$m=0)
    {
        if($id == 0) show_error('、参数错误');
        $this->mgoods->del_goods($id);
        redirect("goods/getGoodsList");
    }

    function params (){
        $data['title'] = get_post('title') ? htmlspecialchars(get_post('title')) : '';
        $data['channelid'] = get_post('channelid') ? htmlspecialchars(get_post('channelid')) : '';
        $data['typeid'] = get_post('typeid') ? htmlspecialchars(get_post('typeid')) : '';
        $data['oprice'] = get_post('oprice') ? htmlspecialchars(get_post('oprice')) : '';
        $data['discount'] = get_post('discount') ? htmlspecialchars(get_post('discount')) : '';
        $data['cprice'] = get_post('cprice') ? htmlspecialchars(get_post('cprice')) : '';
        $data['tag'] = get_post('tag') ? htmlspecialchars(get_post('tag')) : '';
        $data['photo'] = get_post('pics') ? serialize(htmlspecialchars(get_post('pics'))) : '';
        $data['pubdate'] = time();
        $data['description'] = get_post('description') ? htmlspecialchars(get_post('description')) : '';
        $data['content'] = get_post('content') ? htmlspecialchars(get_post('content')) : '';
        $data['shopid'] = get_post('shopid') ? htmlspecialchars(get_post('shopid')) : '';
        $data['uid'] = UID;
        $py = new Pinyin();
        $pyValue = $py->convert($data['title']);
        $ls = $py->mb_strrev($data['title']);
        $temp_str = '';
        foreach($ls as $item){
            $temp_str .= strtoupper(mb_substr($py->convert($item), 0, 1));
        }
        $data['quanpin'] = $pyValue;
        $data['jianpin'] = $temp_str;

        return $data;
    }
    /**
     * 添加美食数据
     */
    public function addGoods()
    {
        $form_name = 'addGoods';
        $typeState = $this->input->get_post('typeState') ? $this->input->get_post('typeState'): 1;
        if($typeState == 1) {

            $channels = $this->mchannel->getChannel();
            $shops = $this->mshops->getShopsByUid(UID);
            $token = self::grante_token($form_name);
            $this->load->view('default/goods_add',array('token'=>$token, 'channels'=> $channels,'shops'=>$shops));
            return;
        }

        $data = self::params();
        $token = get_post('token') ? htmlspecialchars(get_post('token')) : '';
        if(self::is_token($form_name, $token)){
            $this->mgoods->add_goods($data);
            self::drop_token($form_name);
        }
        redirect("goods/getGoodsList");
    }

    function editGoods(){
        $form_name = 'addGoods';
        $id = get_post('id')?get_post('id'):'';
        if('' == $id)show_error('传入参数不能为空！');
        $token = self::grante_token($form_name);
        $goods = $this->mgoods->getGoodsById($id);

        $pho=self::show_pic($goods['photo']);
        //var_dump($pho);
        $goods['photos'] =$pho['0'];

        $channels = $this->mchannel->getChannel();
        $shops = $this->mshops->getShopsByUid(UID);
        $this->load->view('default/goods_edit',array('token'=>$token,'channels'=> $channels, 'goods'=> $goods,'shops'=>$shops));
    }

    function updateGoods(){
        $data = self::params();
        $data['id'] = get_post('id');
        if('' == $data['id'])show_error('传入参数不能为空！');
        $this->mgoods->updateGoods($data);
        redirect("goods/getGoodsList");
    }


    public function editCommodity($value='',$status='')
    {
        if(!$value || !$status) show_error(array('传入参数错误！','<a href="'.WEB_URL.'setting/index/commodityManager">点击返回</a>'));
        //echo $value."<br>".$status;
        //exit;
        $this->mgoods->editCommodity($value, $status);
        $this->commodityManager(1,1);
    }


    /**
     * 管理商品信息
     */
    function commodityManager($page = 1, $state =0){
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $newData = array();
        $data = $this->mgoods->goods_list($param);
        /*暂不做任何数据处理
         * foreach($data as $item){
            $item['title1'] = utf8substr($item['title'],0,10);
            $item['jianjie1'] = utf8substr($item['jianjie'], 0, 18);
            $shopsinfo = $this->manager->getShopById($item['shops_id']);
            $item['shops_id'] = isset($shopsinfo[0]['title']) ? $shopsinfo[0]['title'] : '';
            $users = self::getUserinfoById($item['uid']);
            $item['uid']= count($users) > 0 ? $users[0]['username'] : '保密';
            $newData[] = $item;
        }*/
        //获取总数
        $shopCount = $this->mgoods->goods_list_count();
        $pageShow = self::_mkPage($page, $shopCount,'/goods/commodityManager');
        $this->load->view('default/goods_managerCommodity',array('shopsData'=>$data,'showPage'=>$pageShow,'state'=>$state));
    }


}