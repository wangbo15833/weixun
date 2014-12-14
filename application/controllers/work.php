<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-2-15
 * Time: 上午8:45
 * To change this template use File | Settings | File Templates.
 */

class Work extends  MY_Controller{

    function __construct(){
        parent :: __construct();
        $this->load->model("work_model","mwork");
        $this->load->model("wposition_model","mwposition");
        $this->load->model("shops_model","mshops");
        $this->load->model('area_model','marea');
    }

    function index($cid){

        /*
         * 定义变量
         */
        $req_url = 'work/index/'.$cid;
        parse_str($_SERVER['QUERY_STRING'], $outArr);

        /*
         * 获取参数get/post参数
         */
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        $search_key = $this->input->get_post('header_search') ? htmlspecialchars($this->input->get_post('header_search')):'';
        $area=$this->input->get_post('area')? htmlspecialchars($this->input->get_post('area')):'';
        $position1=$this->input->get_post('position1')? htmlspecialchars($this->input->get_post('position1')):'';

        /*
         * 获取广告列表
         */
        $picList = self::get_ad(0,1);
        $picList_r = self::get_ad(0,2);

        /*
         * 获取人气商家列表
         */
        $hotShopList=array();
        $param['limit'] = self::PAGESIZE;
        $offset = ($page-1) * self::PAGESIZE;
        $param['offset'] = $offset;
        $param['order']=1;
        $param['channel_id']='';
        unset($param['isMyfind']);
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
        *获取地区列表
        */
        $areas = $this->mdistrict->getDistrictByPid(AREAID);
        $new_areas = array();
        foreach($areas as $item){
            $item['base_url'] = self::web_url($req_url,array_merge($outArr,array('area'=>$item['did'],'page'=>1)));
            $new_areas[] = $item;
        }

        /*
         * 获取职位列表
         */
        $position1s = $this->mwposition->getPositionList();
        $new_position1s = array();
        foreach($position1s as $item){
            $item['base_url'] = self::web_url($req_url,array_merge($outArr,array('position1'=>$item['id'],'page'=>1)));
            $new_position1s[] = $item;
        }

        /*
         * 分页按条件获取工作列表
         */
        $offset = ($page-1) * 20;
        $param['offset'] = $offset;
        $param['limit'] = 20;

        if($position1) $param['position1']=$position1;
        if($area) $param['area_id']=$area;

        $param['order']=1;
        $rel =   $this->mwork-> get_Work_List($param);
        $worklist=array();
        foreach($rel as $item){
            //$oto =  self::show_pic($item['photoid']);
            //$item['photos'] =base_url().$oto[0];
            $item['creattime']=date('Y-m-d', $item['creattime']);
            //$item['title']=utf8substr($item['title'],0,12);
            $worklist[] = $item;
        }
        $counts =  $this->mwork->count_Work_List($param);

        /*
         * 获取分页列表
         */
        $pageShow = self::_mkPage($page, $counts,$req_url,20);


        /*
         * 向视图也传递参数
         */
        $paramData['area_url'] =self::web_url($req_url,array_merge($outArr,array('area'=>'','page'=>1)));
        $paramData['position1_url'] =self::web_url($req_url,array_merge($outArr,array('position1'=>'','page'=>1)));
        $paramData['url_window'] = self::web_url($req_url,array_merge($outArr,array('n'=>'1')));
        $paramData['url_list'] = self::web_url($req_url,array_merge($outArr,array('n'=>'21')));
        $paramData['n']=21;

        $paramData['area'] = $area;
        $paramData['position1'] = $position1;
        $paramData['position1s']=$new_position1s;
        $paramData['areas'] = $new_areas;//地区列表
        $paramData['picList'] = $picList;//图片列表
        $paramData['picList_r'] = $picList_r;//右侧图片列表
        $paramData['list'] = $worklist;//工作列表
        $paramData['pageShow'] = $pageShow;//页码显示
        $paramData['search_key'] = $search_key;//关键词
        $paramData['position1'] = $new_position1s;
        $paramData['cid']=$cid;
        $paramData['hotShopList']=$hotShopList;
        $paramData['shopList_zntg']=$shopList_zntg;//智能推广
        /*
         * 载入视图
         */
        $this->load->view(THEME_STYLE.'/work_list',$paramData);
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
        $work = $this->mwork->getWorkByID($param_id);
        $work['creattime']=date('Y-m-d', $work['creattime']);

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
        $this->load->view(THEME_STYLE.'/work_detail',
            array('work'=>$work,
                'cid'=>$cid,
                'shopList_zntg'=>$shopList_zntg));
    }

    //显示发活页面
    public function workadd(){
        //$data['name'] = get_post('title') ? htmlspecialchars(get_post('title')) : '';

        $this->load->view('manageShop/work_add');
    }

    function userworklist($page=1){
            $page=$this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
            $offset = ($page-1) * self::PAGESIZE;
            $param['limit'] = self::PAGESIZE;
            $param['offset'] = $offset;
            $result=$this->mwork->userworklist($param);
            $numTotle=$this->mwork->userworklist_count();
            $pageShow=self::_mkPage($page, $numTotle, $url = './work/userworklist');
            $this->load->view('manageShop/work_list',array('worklist'=>$result,'j'=>1,'pageShow'=>$pageShow));

    }



    function addwork(){
        $data['name'] = get_post('name') ? htmlspecialchars(get_post('name')) : '';
        $data['size'] = get_post('size') ? htmlspecialchars(get_post('size')) : '';
        $data['property'] = get_post('property') ? htmlspecialchars(get_post('property')) : '';
        $data['profession'] = get_post('profession') ? htmlspecialchars(get_post('profession')) : '';
        $data['position1'] = get_post('position1') ? htmlspecialchars(get_post('position1')) : '';
        $data['position2'] = get_post('position2') ? htmlspecialchars(get_post('position2')) : '';

        $data['title'] = get_post('title') ? htmlspecialchars(get_post('title')) : '';
        $data['treatment'] = get_post('treatment') ? htmlspecialchars(get_post('treatment')) : '';
        $data['education'] = get_post('education') ? htmlspecialchars(get_post('education')) : '';
        $data['life'] = get_post('life') ? htmlspecialchars(get_post('life')) : '';
        $data['number'] = get_post('number') ? htmlspecialchars(get_post('number')) : '';
        $data['content'] = get_post('content') ? htmlspecialchars(get_post('content')) : '';
        $data['areaid'] = get_post('areaid') ? htmlspecialchars(get_post('areaid')) : '';
        $data['address'] = get_post('address') ? htmlspecialchars(get_post('address')) : '';
        $data['contact'] = get_post('contact') ? htmlspecialchars(get_post('contact')) : '';
        $data['jd'] = get_post('jd') ? htmlspecialchars(get_post('jd')) : '';


        $time=date("Y-m-d H:i:s",time());
        $creattime=strtotime($time);
        $param=array(
            'name'=>$data['name'],
            'size'=>$data['size'],
            'property'=>$data['property'],
            'profession'=>$data['profession'],
            'title'=>$data['title'],
            'description'=>$data['content'],
            'treatment'=>$data['treatment'],
            'education'=>$data['education'],
            'life'=>$data['life'],
            'number'=>$data['number'],
            'contact'=>$data['contact'],
            'area_id'=>$data['areaid'],
            'address'=>$data['address'],
            'position1'=>$data['position1'],
            'position2'=>$data['position2'],
            'creattime'=>$creattime,
            'jd'=>$data['jd'],
            'uid'=>USER_ID
        );
        $result=$this->mwork->addwork($param);
        if($result==1){
            self::userworklist();
        }
        else{
            echo "<script>alert('添加信息失败，请重新添加！');</script>";
            echo "<script>window.location.href='".WEB_URL."work/workadd';</script>";
        }
    }

    //查看发活
    function ckwork($id=1){
        $row=$this->mwork->userwork($id);
        $this->load->view('manageShop/work_detail',array('ck'=>$row));
    }

    function get_position(){
        $param = get_post('param_id');
        if($param==0){
            $areas = $this->mwposition->getPositionList();
            echo json_encode(array('status'=>1,'data'=>$areas));

        }

        else{
            $positions=$this->mwposition->getPositionByPid($param);
            echo json_encode(array('status'=>1,'data'=>$positions));
        }

    }

    function delwork($id){
        $result=$this->mwork->delwork($id);
        if($result){
            echo "<script>alert('删除成功！！');</script>";
            self::userworklist();
        }else{
            echo "<script>alert('删除失败！！');</script>";
            self::userworklist();
        }
    }

    function editwork($id){
        $row=$this->mwork->userwork($id);
        $positions=$this->mwposition->getPositionList();
        $areas=$this->marea->get_area_list();
        $this->load->view('manageShop/work_edit',array('bj'=>$row,'positions'=>$positions,'areas'=>$areas));
    }
    function editworktj($id){
        $data['name'] = get_post('name') ? htmlspecialchars(get_post('name')) : '';
        $data['size'] = get_post('size') ? htmlspecialchars(get_post('size')) : '';
        $data['property'] = get_post('property') ? htmlspecialchars(get_post('property')) : '';
        $data['profession'] = get_post('profession') ? htmlspecialchars(get_post('profession')) : '';
        $data['position1'] = get_post('position1') ? htmlspecialchars(get_post('position1')) : '';
        $data['position2'] = get_post('position2') ? htmlspecialchars(get_post('position2')) : '';
        $data['title'] = get_post('title') ? htmlspecialchars(get_post('title')) : '';
        $data['treatment'] = get_post('treatment') ? htmlspecialchars(get_post('treatment')) : '';
        $data['education'] = get_post('education') ? htmlspecialchars(get_post('education')) : '';
        $data['life'] = get_post('life') ? htmlspecialchars(get_post('life')) : '';
        $data['number'] = get_post('number') ? htmlspecialchars(get_post('number')) : '';
        $data['content'] = get_post('content') ? htmlspecialchars(get_post('content')) : '';
        $data['area'] = get_post('area') ? htmlspecialchars(get_post('area')) : '';
        $data['address'] = get_post('address') ? htmlspecialchars(get_post('address')) : '';
        $data['contact'] = get_post('contact') ? htmlspecialchars(get_post('contact')) : '';
        $data['jd'] = get_post('jd') ? htmlspecialchars(get_post('jd')) : '';

        $time=date("Y-m-d H:i:s",time());
        $creattime=strtotime($time);
        $param=array(
            'name'=>$data['name'],
            'size'=>$data['size'],
            'property'=>$data['property'],
            'profession'=>$data['profession'],
            'title'=>$data['title'],
            'description'=>$data['content'],
            'treatment'=>$data['treatment'],
            'education'=>$data['education'],
            'life'=>$data['life'],
            'number'=>$data['number'],
            'contact'=>$data['contact'],
            'area_id'=>$data['area'],
            'address'=>$data['address'],
            'position1'=>$data['position1'],
            'position2'=>$data['position2'],
            'creattime'=>$creattime,
            'jd'=>$data['jd'],
            'uid'=>USER_ID
        );
        $result=$this->mwork->editwork($id,$param);
        if($result==1){
            echo "<script>alert('修改成功！！');</script>";
            self::userworklist();
        }
        else{
            echo "<script>alert('修改失败，请重新修改！！');</script>";
            echo "<script>window.location.href='".WEB_URL."work/editwork/".$id."';</script>";
        }
    }


}