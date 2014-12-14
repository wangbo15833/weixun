<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-28
 * Time: 下午1:37
 * To change this template use File | Settings | File Templates.
 */

class Shops extends  MY_Controller{

    function __construct(){
        parent :: __construct();
        $this->load->model('shops_model','mshops');
        $this->load->model('area_model','marea');
        $this->load->model('types_model','mtypes');
        $this->load->model('appraisal_model','mappraisal');
        $this->load->model('user_model','muser');
        $this->load->model('favorites_model','mfavorites');
        $this->load->model('channel_model','mchannel');
		$this->load->model('comment_model','mcomment');
        $this->load->model('district_model','mdistrict');
    }

    function index(){
        /*
         * 定义变量
         */

        $req_url = 'shops/index';
        parse_str($_SERVER['QUERY_STRING'], $outArr);

        /*
         * 获取get/post参数
         */
        $cid = $this->input->get_post('cid')?htmlspecialchars($this->input->get_post('cid')):'';
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        $search_key = $this->input->get_post('searchkey') ? htmlspecialchars($this->input->get_post('searchkey')):'';
        $area=$this->input->get_post('area')? htmlspecialchars($this->input->get_post('area')):'';
        $type=$this->input->get_post('type')? htmlspecialchars($this->input->get_post('type')):'';

        /*
         * 获取广告列表
         */
        $picList = self::get_ad(0,1);
        $picList_r = self::get_ad(0,2);


        /*
        *获取地区列表
        */

        $areas = $this->mdistrict->getDistrictByPid(AREAID);
        $new_areas = array();
        foreach($areas as $item){
            $item['base_url'] = self::web_url($req_url,array_merge($outArr,array('area'=>$item['did'],'page'=>1)));
            $new_areas[] = $item;
        }



        /*
         * 分页按条件获取店铺列表
         */

        if($type) $param['type_id']=$type;
        if($area) $param['area_id']=$area;

        $param['limit'] = 8;
        $offset = ($page-1) * 8;
        $param['offset'] = $offset;
        $param['channel_id']=$cid;
        $param['order']=1;
        $param['search_key'] = $search_key;
        //如果频道ID=7，则为我发现频道
        if($cid==7){
            $param['isMyfind']=1;
            $param['channel_id']='';
        }

        $rel =   $this->mshops-> get_Shops_List($param);
        $list = array();
        foreach($rel as $item){
            $pho=self::show_pic($item['photoid']);
            $item['photos'] =base_url().$pho['0'];
            $list[] = $item;
        }
        $counts =  $this->mshops->count_Shops_List($param);

        /*
         * 获取人气商家列表
         */
        $hotShopList=array();
        $rel =   $this->mshops-> getShopList($cid,9,"shopid");
        //print_r($rel);exit;
        foreach($rel as $item){
            $pho=self::show_pic($item['photoid']);
            $item['photos'] =base_url().$pho['0'];
            $hotShopList[]=$item;
        }

        /*
         * 获取智能推广商家列表
         */

        $shopList_zntg = array();
        $rel = $this->mshops->getShopList(2,5,"shopid");

        foreach($rel as $item){
            $pho=self::show_pic($item['photoid']);
            $item['photos'] =base_url().$pho['0'];
            $shopList_zntg[]=$item;
        }

        /*
         * 获得最新发现列表
         */

        $shoplist_zxfx=array();
        $rel=$this->mshops->getShopList_find(9,"shopid");
        foreach($rel as $item){
            $oto =  self::show_pic($item['photoid']);
            $item['photos'] =base_url().$oto[0];
            $item['pubdate']=date('Y-m-d', $item['pubdate']);
            $item['title']=utf8substr($item['title'],0,10);
            $shoplist_zxfx[] = $item;
        }




        /*
         * 获取类型列表
         */

        if($cid){
            $types = $this->mtypes->getTypesByChannel($cid);
        }
        else{
            $types= $this->mshops->get_types_list($param);
            //print_r($types);exit;
        }

        $new_types = array();

        foreach($types as $item){
            $item['base_url'] = self::web_url($req_url,array_merge($outArr,array('type'=>$item['typeid'],'page'=>1)));
            $new_types[] = $item;
        }

        /*
         * 获取分页列表
         */
        $pageShow = self::_mkPage($page, $counts,$req_url,8);




        /*
         * 向视图也传递参数
         */


        $paramData['area'] = $area;
        $paramData['area_all'] =self::web_url($req_url,array_merge($outArr,array('area'=>'','page'=>1)));
        $paramData['type'] = $type;
        $paramData['type_all'] =self::web_url($req_url,array_merge($outArr,array('type'=>'','page'=>1)));
        $paramData['areas'] = $new_areas;//筛选条件 地区
        $paramData['picList'] = $picList;//筛选条件 地区
        $paramData['picList_r'] = $picList_r;//筛选条件 地区
        $paramData['list'] = $list;
        $paramData['pageShow'] = $pageShow;
        $paramData['types'] = $new_types;//筛选条件 分类
        $paramData['cid'] = $cid;
        $paramData['hotShopList']=$hotShopList;
        $paramData['shopList_zntg']=$shopList_zntg;
        $paramData['shoplist_zxfx']=$shoplist_zxfx;

        /*
         * 载入视图
         */
        $this->load->view(THEME_STYLE.'/shops_list',$paramData);
    }

    function detail($param_id=0){
        /*
         * 获取get/post参数信息
         */
        if(!$param_id || intval($param_id) == 0) show_error('不要调皮哦，快到碗里来……');

        /*
         * 按ID查询商铺详情
         */
        $shop = $this->mshops->detail($param_id);

        /*
         * 处理商品详情各个字段
         */

        $shop['new_title'] = utf8substr($shop['title'],0,10);
        $shop['content'] = htmlspecialchars_decode($shop['content']);

        $oto = self::show_pic($shop['photoid']);
        $shop['sphoto'] =base_url().$oto[0];


        /*
         * 判断浏览用户是否已经收藏该商品
         */
        $isFavorites =$this->mfavorites->cx_sc(@USER_ID,$shop['shopid'], $shop['channel_id']);


        /*
         * 获取人气商家列表
         */

        $hotShopList=array();
        $param['limit'] = self::PAGESIZE;
        $param['order']=1;
        $param['offset'] = 0;
        $param['channel_id']='';
        $param['search_key']='';
        $rel=$this->mshops-> get_Shops_List($param);
        //print_r($rel);exit;
        foreach($rel as $item){
            $pho=self::show_pic($item['photoid']);
            $item['photos'] =base_url().$pho['0'];
            $hotShopList[]=$item;
        }


        /*
         * 获取智能推广商家列表
         */

        $shopList_zntg = array();
        $rel = $this->mshops->getShopList(2,5,"shopid");

        foreach($rel as $item){
            $pho=self::show_pic($item['photoid']);
            $item['photos'] =base_url().$pho['0'];
            $shopList_zntg[]=$item;
        }


        /*
         * 载入视图
         */
        $this->load->view(THEME_STYLE.'/shops_detail',
            array('shop'=>$shop,
                'cid'=>$shop['channel_id'],
                'channel'=>$shop['name'],
                'isFavorites'=>$isFavorites,
                'hotShopList'=>$hotShopList,
                'shopList_zntg'=>$shopList_zntg));
    }



    function searchList(){
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        $search_key = $this->input->get_post('header_search') ? htmlspecialchars($this->input->get_post('header_search')):'';
        $offset = ($page-1) * self::PAGESIZE;
        $param['c_title'] = $search_key;
        $param['data_status'] = '';
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $param['sname'] = $search_key;
        $param['order']=1;

        //购
        $param['channelid']=1;
        $goods1 =   $this->mgoods->get_Goods_List($param);

        //吃

        $param['channelid']=2;
        $goods2 = $this->mgoods->get_Goods_List($param);
        //玩
        $param['channelid']=3;
        $goods3 = $this->mgoods->get_Goods_List($param);

        //住
        $param['channelid']=5;
        $goods5 = $this->mgoods->get_Goods_List($param);

        //乐
        $param['channelid']=6;
        $goods6 = $this->mgoods->get_Goods_List($param);

        //服务
        $param['channelid']=7;
        $goods7 = $this->mgoods->get_Goods_List($param);

        //$data = array('list'=>$list,'gourmet'=>$sGourmet, 'pageShow'=>$pageShow,'search_key'=>$search_key);
        //$data['play'] = $sPlay; $data['happy'] = $sHappy; $data['live'] = $sLive; $data['service'] = $sService;

        $data['goods1']=$goods1;
        $data['goods2']=$goods2;
        $data['goods3']=$goods3;
        $data['goods5']=$goods5;
        $data['goods6']=$goods6;
        $data['goods7']=$goods7;
        //$data['pageShow']=$pageShow;
        $data['search_key']=$search_key;
        $this->load->view('meituan/search_search',$data);
    }

    function add_comment(){

        if(! defined('USER_ID')){ echo json_encode(array('status'=>0));
            //show_error("请登录以后评论！");
            return;
        }
        $param['shop_id'] = $this->input->get_post('shopid');
        $param['message'] = $this->input->get_post('message');
        //$param['goods_score'] = $this->input->get_post('star1');
        //$param['service_score'] = $this->input->get_post('star2');
        //$param['condition_score'] = $this->input->get_post('star3');
        $param['uid'] = USER_ID;
        $param['pubdate'] = time();
        $this->mcomment->add_comment($param);
        echo json_encode(array('status'=>1));
    }


    function get_comment_list(){
        $param['shopid'] = $this->input->get_post('shopid');
        $param['channelid'] = $this->input->get_post('channelid');
        $comments = $this->mcomment->get_comment_list($param);
        $newData = array();
        if(count($comments) > 0){
            foreach($comments as $i){
                $users =  $this->muser->get_user_id($i['uid']);
                $i['username'] = $users['username'];
                $i['pubdate'] = friendlyDate($i['pubdate']);
                $newData[] = $i;
            }}
        echo json_encode(array('status'=>1,'data'=>$newData));
    }

    /**
     *图片展示列表
     */
    function do_load(){
        //$this->load->model('Gourmet_model','gourmet');
        $newList = $cs = array();
        $params['c_id'] = $this->input->get_post('cid')?$this->input->get_post('cid'):'';
        $params['g_id'] = $this->input->get_post('gid')?$this->input->get_post('gid'):'';

        $g_info = $this->mgoods->detail($params['g_id']);
        $lists = $this->mgoodspic->getGoodsPics($params);
        foreach( $lists as $item){
            $item['picUrl'] = base_url() . unserialize($item['picUrl']);
            $item['dateline'] = friendlyDate($item['dateline']);
            $users = $this->muser->get_user_id($item['uid']);
            $item['username'] = $users['username'];
            $newList[] = $item;
        }
        /*$pgc = $this->gourmet->getGourmetCategory(array('parentid'=>0));
        foreach($pgc as $pi){
            $pi['childs'] = $this->gourmet->getGourmetCategory(array('parentid'=> $pi['id'],'g_id'=>$params['g_id'] ));
            $cs[] = $pi;
        }*/
        $this->load->view('meituan/goods_showpic',array('g_info'=>$g_info,'gourmetid'=> $params['g_id'], 'lists' => $newList, 'pgc' => $cs,'cid'=>$params['c_id']));
    }

    /**
     * 转到上传图片页面
     */
    function do_upload(){
        $this->load->model('Gourmet_model','gourmet');
        if(!defined('USER_ID')) self::is_login();
        $state = $this->input->get_post('state')?$this->input->get_post('state'):1;
        $c_id = $this->input->get_post('cid')?$this->input->get_post('cid'):1;
        $gid = $this->input->get_post('gid')?$this->input->get_post('gid'):1;
        $hid_id = $this->input->get_post('hid_id')?$this->input->get_post('hid_id'):1;
        if($state == 1){
            $h_info = $this->mgoods->detail($gid);
            //$cate = $this->gourmet->getGourmetCategory(array('parentid'=>0));
            //$cate_s = $this->gourmet->getGourmetCategory(array('parentid'=>$hid_id,'g_id'=>$gourmetid));
            //$datas = count($cate_s)>0? $cate_s : false;
            //跳转至上传页面
            $this->load->view('meituan/goods_addpic',array('gid'=>$gid,'h_info'=>$h_info,'cid'=>$c_id));
            return;
        }
        $hid['name'] = $this->input->get_post('hid_name')?$this->input->get_post('hid_name'):'';
        $hid['picUrl'] = $this->input->get_post('hid_pics')?serialize($this->input->get_post('hid_pics')):'';
        //var_dump($hid['picUrl']);exit;
        $hid['dateline'] = time();
        $hid['uid'] = USER_ID;
        $hid['gid'] = $gid;
        $this->mgoodspic->addGoodsPic($hid);
        self::do_load($gid);
        //获取数据存档
    }


    function add_sc(){
        if(! defined('USER_ID')){ echo json_encode(array('status'=>0));//show_error("请登录以后收藏！");
            return;
        }
        $param['channelid'] = $this->input->get_post('cid') ? (int)$this->input->get_post('cid') : 0;
        $param['gid'] = $this->input->get_post('gid');
        $param['uid'] = USER_ID;
        $param['timeline'] = time();
        $this->mfavorites->add_sc($param);
        echo json_encode(array('status'=>1));
    }

    /*搜索的时候自动加载数据库中包含搜索的关键字*/
    function get_search(){
        $param['c_title'] = $this->input->get_post('c_title') ? htmlspecialchars($this->input->get_post('c_title')) : '你好';
        $rel  = $this->mshops->get_search($param);
        echo json_encode(count($rel)>0 ? $rel : false);
    }

}