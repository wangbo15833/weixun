<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-28
 * Time: 下午1:37
 * To change this template use File | Settings | File Templates.
 */

class Goods extends  MY_Controller{

    function __construct(){
        parent :: __construct();
        $this->load->model('goods_model','mgoods');
        $this->load->model('goodspic_model','mgoodspic');
        $this->load->model('area_model','marea');
        $this->load->model('types_model','mtypes');
        $this->load->model('appraisal_model','mappraisal');
        $this->load->model('user_model','muser');
        $this->load->model('favorites_model','mfavorites');
    }

    function index($cid){
        /*
         * 定义变量
         */

        $req_url = 'goods/index/'.$cid;
        parse_str($_SERVER['QUERY_STRING'], $outArr);

        /*
         * 获取get/post参数
         */

        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        $search_key = $this->input->get_post('header_search') ? htmlspecialchars($this->input->get_post('header_search')):'';
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

        $areas = $this->marea->get_area_list();
        $new_areas = array();
        foreach($areas as $item){
            $item['base_url'] = self::web_url($req_url,array_merge($outArr,array('area'=>$item['id'],'page'=>1)));
            $new_areas[] = $item;
        }

        /*
         * 获取类型列表
         */

        $types = $this->mtypes->get_types($cid, 0);
        $new_types = array();

        foreach($types as $item){
            $item['base_url'] = self::web_url($req_url,array_merge($outArr,array('type'=>$item['id'],'page'=>1)));
            $new_types[] = $item;
        }

        /*
         * 分页按条件获取商品列表
         */

        if($type) $param['typeid']=$type;
        if($area) $param['areaid']=$area;

        $param['limit'] = self::PAGESIZE;
        $offset = ($page-1) * self::PAGESIZE;
        $param['offset'] = $offset;
        $param['channelid']=$cid;
        $param['order']=1;
        $rel =   $this->mgoods-> get_Goods_List($param);
        $list = array();
        foreach($rel as $item){
            $pho=self::show_pic($item['g_photo']);
            $item['photos'] =base_url().$pho['0'];
            $list[] = $item;
        }
        $counts =  $this->mgoods->count_Goods_List($param);




        /*
         * 获取分页列表
         */
        $pageShow = self::_mkPage($page, $counts,$req_url);


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
        $paramData['search_key'] = $search_key;
        $paramData['types'] = $new_types;//筛选条件 分类
        $paramData['cid'] = $cid;

        /*
         * 载入视图
         */
        $this->load->view('meituan/goods_list',$paramData);
    }

    function detail($param_id=0){
        /*
         * 获取get/post参数信息
         */
        $cid = $this->input->get_post('cid') ? htmlspecialchars($this->input->get_post('cid')):'';
        if(!$param_id || intval($param_id) == 0) show_error('不要调皮哦，快到碗里来……');


        /*
         * 按ID查询商品详情
         */
        $lists = $this->mgoods->detail($param_id);

        /*
         * 处理商品详情各个字段
         */

        $lists['new_title'] = utf8substr($lists['g_title'],0,10);
        $lists['description'] = htmlspecialchars_decode($lists['g_description']);

        //根据时间生成二维码
        $oto = self::show_pic($lists['g_photo']);
        $lists['gphoto'] = base_url() . $oto[0];
        $days = ceil((time()-$lists['g_pubdate'])/86400);
        if(!$lists['g_quickmark'] || $days>7){
            $show_code =  self::show_qrcode_img('扫一扫，有惊喜！',$lists['photos']);
            $lists['show_code'] = base_url() . $show_code;
            $this->mgoods->update_quickmark(array('g_id'=>$param_id, 'g_quickmark'=>$show_code));
        }else{
            $lists['show_code'] = base_url() . $lists['g_quickmark'];
        }


        /*
         * 判断浏览用户是否已经收藏该商品
         */
        $isFavorites =$this->mfavorites->cx_sc(@USER_ID,$lists['g_id'], $cid);


        /**
         * 添加附件图片展示
         */
        $rel_new = '';
        $data = array('b_type'=> 1,'g_id'=> $param_id,'limit' => 4);
        $relList = $this->mgoods->getG_pic($data);
        foreach($relList as  $item){
            $item['picUrl'] = base_url() . unserialize($item['picUrl']);
            $rel_new[] = $item;
        }

        /*
         * 载入视图
         */
        $this->load->view('meituan/goods_detail',array('commoditys'=>$lists,'relList'=>$rel_new,'cid'=>$cid,'isFavorites'=>$isFavorites));
    }



    function searchList(){
        //$this->load->model('gourmet_model','gourmet');
        //$this->load->model('happy_model', 'happy');
        //$this->load->model('live_model', 'live');
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        $search_key = $this->input->get_post('header_search') ? htmlspecialchars($this->input->get_post('header_search')):'';
        $offset = ($page-1) * self::PAGESIZE;
        $param['c_title'] = $search_key;
        $param['data_status'] = '';
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $param['sname'] = $search_key;
        $param['order']=1;
        //$param['city_id'] = CITYID;
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

    function add_appraisal(){

        if(! defined('USER_ID')){ echo json_encode(array('status'=>0));
            //show_error("请登录以后评论！");
            return;
        }
        $param['c_id'] = $this->input->get_post('hid_cid');
        $param['commented_id'] = $this->input->get_post('hid_id');
        $param['commented_info'] = $this->input->get_post('message');
        $param['total_appraisal'] = $this->input->get_post('star1');
        $param['service_appraisal'] = $this->input->get_post('star2');
        $param['condition_appraisal'] = $this->input->get_post('star3');
        $param['uid_appraisal'] = USER_ID;
        $param['dateline'] = time();
        $this->mappraisal->add_appraisal($param);
        echo json_encode(array('status'=>1));
    }


    function get_appraisal_list(){
        $param['id'] = $this->input->get_post('hid_id');
        $param['cid'] = $this->input->get_post('hid_cid');
        $data = $this->mappraisal->get_appraisal_list($param);
        $newData = array();
        if(count($data) > 0){
            foreach($data as $i){
                $users =  $this->muser->get_user_id($i['uid_appraisal']);
                $i['username'] = $users['username'];
                $i['dateline'] = friendlyDate($i['dateline']);
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

}