<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-21
 * Time: 上午9:41
 * To change this template use File | Settings | File Templates.
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends  MY_Controller {
    /**
     *
     */
	 
    function __construct(){
        parent :: __construct();
        $this->load->model('goods_model','mgoods');
        $this->load->model('ad_model','mad');
        $this->load->model('work_model','mwork');
        $this->load->model('types_model','mtypes');
        $this->load->model('area_model','marea');
        $this->load->model('shops_model','mshops');
        $this->load->model('district_model','mdistrict');
        $this->load->model('promotion_model','mpromotion');
    }

    function changeCity(){
        $city_id = $this->input->get_post('city');
        if(intval($city_id)>0)
            $this->input->set_cookie('cityid',$city_id,3600);
        //self::index();
        redirect('base/index');
    }

    /**
     * 显示地区页面
     */
    function show_district(){
        $this->load->view('meituan/initiative');
    }


/*搜索的时候自动加载数据库中包含搜索的关键字*/
    function get_search(){
        $param['c_title'] = $this->input->get_post('c_title') ? htmlspecialchars($this->input->get_post('c_title')) : '你好';
        $rel  = $this->mgoods->get_search($param);
        echo json_encode(count($rel)>0 ? $rel : false);
    }

    /**
     *
     */
    function index($page = 1){
        define("CGOUWU",1);
        define("CCHIHE",2);
        define("CWANLE",3);
        define("CCHUXING",4);
        define("CZHUSU",5);
        define("CFUWU",6);
        define("CZHAOHUO",8);
        define("CYILIAOBAOJIAN",9);
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        //$search_key = $this->input->get_post('header_search') ? htmlspecialchars($this->input->get_post('header_search')):'';
       // $param['c_title'] = $search_key;
        $pic = $this->mad->get_add_info(0);
        $picList = $picList_r = array();
        $picList = self::get_ad(0,1);
        $picList_r = self::get_ad(0,2);
        $offset = ($page-1) * self::PAGESIZE;

        $param['data_status'] = '';
        $param['limit'] = 3;
        $param['offset'] = $offset;
        $param['order']=1;

        $list1=$list2=$list3=$list4=$list5=$list6=$list7=$list8=$list9 = array();

        //吃喝
        $param['channel_id']=2;
        $rel =   $this->mshops-> getShopList(2,3,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $list2[] = $item;
        }
        $rel =   $this->mshops-> getShopList(2,10,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $phlist_chihe[] = $item;
        }

        $typelist2=$this->mtypes->getTypesByChannel(2);

        //玩乐
        $rel =   $this->mshops-> getShopList(3,3,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $list3[] = $item;
        }

        $rel =   $this->mshops-> getShopList(3,10,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $phlist_wanle[] = $item;
        }
        $typelist3=$this->mtypes->getTypesByChannel(3);

        //住宿

        $rel =   $this->mshops-> getShopList(5,3,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $list5[] = $item;
        }

        $rel =   $this->mshops-> getShopList(5,10,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $phlist_zhusu[] = $item;
        }
        $typelist5=$this->mtypes->getTypesByChannel(5);

        //购物

        $param['channel_id']=1;
        $rel =   $this->mshops-> getShopList(1,3,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $list1[] = $item;
        }

        $rel =   $this->mshops-> getShopList(1,10,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $phlist_gouwu[] = $item;
        }

        $typelist1=$this->mtypes->getTypesByChannel($param['channel_id']);


        //服务

        $param['channel_id']=6;
        $rel =   $this->mshops-> getShopList(8,3,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $list6[] = $item;
        }

        $typelist_fuwu=$this->mtypes->getTypesByChannel($param['channel_id']);

        //找活


        $param['channelid']=9;
        $rel =   $this->mwork->getWorksByLimit(12);
        foreach($rel as $item){
            $item['creattime']=date('Y-m-d', $item['creattime']);
            $list9[] = $item;
        }

        //获得所有区县列表
        $areas=$this->mdistrict->getDistrictByPid(AREAID);

        /*
         * 获取优惠信息列表
         */
        $rel=$this->mpromotion->getPromotionByLimit();
        foreach($rel as $item){
            $item['pubtime']=date('Y-m-d', $item['pubtime']);
            $promotions[] = $item;
        }

        /*
         * 获取人气商家列表
         */
        $hotShopList=array();
        $param['channel_id']='';
        $param['limit'] = 4;

        $rel=$this->mshops-> get_Shops_List($param);

        foreach($rel as $item){
            $pho=self::show_pic($item['photoid']);
            $item['photos'] =base_url().$pho['0'];
            $hotShopList[]=$item;
        }

        /*
         * 获得最新发现列表
         */

        $shoplist_zxfx=array();
        $rel=$this->mshops->getShopList_find(8,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $item['pubdate']=date('Y-m-d', $item['pubdate']);
            $item['title']=utf8substr($item['title'],0,11);
            $shoplist_zxfx[] = $item;
        }

        /*
         * 获取各个行业人工推荐
         */

        $ShopRgtj_gouwu=$this->mshops->getShoplistRgtj(CGOUWU);
        $ShopRgtj_wanle=$this->mshops->getShoplistRgtj(CWANLE);
        $ShopRgtj_zhusu=$this->mshops->getShoplistRgtj(CZHUSU);
        $ShopRgtj_chihe=$this->mshops->getShoplistRgtj(CCHIHE);
        $ShopRgtj_chuxing=$this->mshops->getShoplistRgtj(CCHUXING);
        $ShopRgtj_yiliaobaojian=$this->mshops->getShoplistRgtj(CYILIAOBAOJIAN);


        $this->load->view(THEME_STYLE.'/index',
            array(
                'pic'=>$picList,
                'pic_r'=> $picList_r,
                'list1'=>$list1,
                'list2'=>$list2,
                'list3'=>$list3,
                'list5'=>$list5,
                'list6'=>$list6,
                'list9'=>$list9,
                'phlist_gouwu'=>$phlist_gouwu,
                'phlist_chihe'=>$phlist_chihe,
                'phlist_wanle'=>$phlist_wanle,
                'phlist_zhusu'=>$phlist_zhusu,
                'typelist1'=>$typelist1,
                'typelist2'=>$typelist2,
                'typelist3'=>$typelist3,
                'typelist5'=>$typelist5,
                'typelist_fuwu'=>$typelist_fuwu,
                'areas'=>$areas,
                'hotShopList'=>$hotShopList,
                'promotionList'=>$promotions,
                'shoplist_zxfx'=>$shoplist_zxfx,
                'ShopRgtj_gouwu'=>$ShopRgtj_gouwu,
                'ShopRgtj_chihe'=>$ShopRgtj_chihe,
                'ShopRgtj_wanle'=>$ShopRgtj_wanle,
                'ShopRgtj_zhusu'=>$ShopRgtj_zhusu,
                'ShopRgtj_chuxing'=>$ShopRgtj_chuxing,
                'ShopRgtj_yiliaobaojian'=>$ShopRgtj_yiliaobaojian));
    }


    /**
     *
     */



    function getDistrict(){
        $cid= $this->input->get_post('city');
        $categorys = $this->mindex-> get_goodsCategory_id($cid, 0);
        $arrs = array();
        foreach($categorys as $item){
            $data['name'] = $item['name'];
            $data['value'] = $item['id'];
            $data['needAz'] = 'false';
            $data['cid'] = $cid;
            $arrs[] = $data;
        }
        echo json_encode($arrs);
    }



}