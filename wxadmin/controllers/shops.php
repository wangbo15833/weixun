<?php
/**
 * @desc 商铺首页
 * @author gefc
 * @dateline 20130422
 *
 */
class Shops extends MY_Controller {
    private $sdata = '';
    const PAGESIZE = 10;
    function __construct() {
        parent :: __construct();
        $this->load->model('Shops_model','mshops');
        $this->load->model('channel_model','mchannel');
        $this->load->model('types_model','mtypes');
        $this -> load -> library('File_util');
    }

    /**
     *
     */
    public function index()
    {

        $this->load->view('default/index');
    }

    /**
     * @param string $id
     */
    public function getedit($id=''){
        if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'shops/getShopsInfo">点击返回</a>'));
        $arr = $this->mshops->getShopsInfo($id);
        $data = $this->mchannel->getChannel();
        //添加表单token
        $token = self::grante_token(UID);
        $this->load->view('default/shops_edit',array('category'=>$data,'arr'=>$arr,'token'=>$token));
    }

    /**
     * 关闭商铺信息
     * @date 20130503
     * @param uid,id
     * @author gefc
     */
    function delshops($id=0){
        $uid = UID;
        if($id==0) return false;
        $data = array('id'=>$id,'uid'=>$uid,'is_status'=>2);
        $rel = $this->mshops->delshops($data);
        redirect("shops/getShopsInfo");
    }



    /**
     * 获得店铺
     */
    public function get_params()
    {
        $uid = UID;
        $title= get_post('title') ? htmlspecialchars(get_post('title')):'';
        $summary= get_post('summary') ? htmlspecialchars(get_post('summary')):'';
        $content= get_post('content')? htmlspecialchars(get_post('content')):'';
        $is_status= 2;
        $phone= get_post('phone')? htmlspecialchars(get_post('phone')):'';
        $tag= get_post('tag')? htmlspecialchars(get_post('tag')):'';
        $is_hot= 1;
        $sort= 1;
        $photoid= get_post('pics')? htmlspecialchars(get_post('pics')):'';
        // $type= get_post('type')? htmlspecialchars(get_post('type')):'';
        // $type1 = get_post('type1')?get_post('type1'):'';
        $id = get_post('id')? htmlspecialchars(get_post('id')):'';
        $data = array('uid' => $uid,
            'title' => $title,
            'summary' => $summary,
            'content' => $content,
            //'is_status' => $is_status,
            'phone' => $phone,
            'tag' => $tag,
            //'is_hot' => $is_hot,
            //'sort' => $sort,
            'dateline'=>time(),
            'photoid' => serialize($photoid),
            //'type' => $type
        );
        //if($type1) $data['type'] = $type1;
        if(!$id){
            $data['is_status']=$is_status;
            $data['is_hot']=$is_hot;
            $data['sort']=$sort;
        }else{
            $data['id']=$id;
        }
        return $data;
    }

    /**
     * 获取参数处理
     */
    function shops_param(){
        //var_dump($_POST);
        $uid = get_post('h_suid') ? htmlspecialchars(get_post('h_suid')) : 0;
        $title = get_post('title') ? htmlspecialchars(get_post('title')) : '';
        $summary = get_post('summary') ? htmlspecialchars(get_post('summary')) : '';
        $content = get_post('content') ? htmlspecialchars(get_post('content')) : '这家伙很懒、什么都没有留下……';
        $is_status2= 2;
        $phone = get_post('phone') ? htmlspecialchars(get_post('phone')) : '';
        $tag = get_post('tag') ? htmlspecialchars(get_post('tag')) : '';
        $is_hot = 1;
        $sort = 1;
        $photoid= get_post('pics') ? htmlspecialchars(get_post('pics')) : '';
        $ctype = get_post('type') ? htmlspecialchars(get_post('type')) : 1;
        $type = get_post('type1') ? htmlspecialchars(get_post('type1')) : 1;
        $district_id = get_post('county');
        $city_id = get_post('city');
        $datetime = time();

        $map_x = get_post('map_x');
        $map_y = get_post('map_y');
        $address = get_post('address')? htmlspecialchars(get_post('address')):'';
        $data = array(
            'uid' => $uid,
            'title' => $title,
            'summary' => $summary,
            'content' => $content,
            'is_status' => $is_status2,
            'phone' => $phone,
            'tag' => $tag,
            'is_hot' => $is_hot,
            'sort' => $sort,
            'photoid' => serialize($photoid),
            'city_id'=>$city_id,
            'district_id'=>$district_id,
            'channel_id' =>$ctype,
            'type' => $type,
            'dateline' => $datetime,
            'maps'=>$map_x.",".$map_y,
            'map_x' => $map_x,
            'map_y' => $map_y,
            'address' => $address
        );
        //var_dump($data);exit;
        return $data;
    }

    /**
     *
     */
    public function getCategory()
    {
        $id = intval(get_post('parentid'));
        $category = $this->mshops->getCategoryById($id);
        echo json_encode(array('status'=>1, 'data'=>$category));
    }

    /**
     * 添加新商铺
     */
    public function addShopManager()
    {
        $shopManager_status = get_post('mstatus') ? htmlspecialchars(get_post('mstatus')) : '';
        if(!$shopManager_status){

            //添加表单token
            $token = self::grante_token(UID);
            $this->load->view('default/shops_add', array('status'=>STATUS,'token'=>$token));
        }else{
            $form_token = get_post('token');
            if(self::is_token(UID, $form_token)){
                $shopsData = $this->shops_param();
                $stste = $this->mshops->addShops($shopsData);
                self::drop_token(UID);
                //if($stste)  $this->shopManager(1, 1);
            }
            //else $this->shopManager(1, 2);
            redirect("shops/getShopsInfo");
        }
    }

    /**
     * 发布新商铺信息
     */
    public function addShopsInfo()
    {
        $page_status = htmlspecialchars(get_post('mstatus'));
        if($page_status){
            $form_token = get_post('token');
            if(self::is_token(UID, $form_token)){
                $data =  $this->get_params();
                $this->mshops->addShops($data);
                self::drop_token(UID);
                $this->getShopsInfo(1,1);
            }else $this->getShopsInfo(1,3);
        }else{
            //$category = $this->shops->getCategory();'category' => $category ,
            //添加表单token
            $token = self::grante_token(UID);
            $this->load->view('default/shops_add', array('token'=>$token,'h_suid'=>UID));
        }
    }

    /**
     * 获取某人店铺信息
     * @author gefc
     *
     */
    function getShopsById(){
        $uid = UID;
        if(!$uid) return false;
        $shopsInfo =  $this->mshops->getShopsById($uid);
        $data = array('status'=>1, 'data' => $shopsInfo);
        echo  json_encode($data);
    }

    /**
     * 获取店铺信息
     */
    public function getShopsInfo($page=1,$state = 0)
    {

        $lists = array();
        $uid= UID;
        $status = 2;
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $param['uid'] = $uid;
        $param['status'] = $status;
        $shops_data = $this->mshops->getShops($param);
        //var_dump($shops_data);exit;
        foreach($shops_data as $item){

            $item['new_summary'] = utf8substr($item['summary'], 0, 10);
            $lists[] = $item;
        }
        //获取总数
        $shopCount = $this->mshops->getShops_count($param);
        $pageShow = self::_mkPage($page, $shopCount,'shops/getShopsInfo');
        $this->load->view('default/shops_list',array('shopsList'=>$lists,'pageData'=>$pageShow,'state'=>$state));
    }

    /**
     * 店主编辑店铺信息
     */
    public function editShopsInfo()
    {
        $form_token = get_post('token');
        if(self::is_token(UID, $form_token)){
            $data = $this->get_params();
            $this->mshops->editShops($data);
            self::drop_token(UID);
            $this->getShopsInfo(1,1);
        }else   $this->getShopsInfo(1,2);
    }

/*系统管理员审核店铺*/
    public function editShops($value='',$status='')
    {
        if(!$value || !$status) show_error(array('传入参数错误！','<a href="'.WEB_URL.'shops/shopManager">点击返回</a>'));
        $this->mshops->auditShops($value, $status);
        $this->shopManager(1, 1);
    }

    /**
     * 系统管理员获取管理商铺信息
     */
    function shopManager($page=1, $status=0){
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        //$param['status'] = ($status > 0) ? $status : 2;
        $data = $this->mshops->shopManager($param);
        $newData = array();
        foreach($data as $item){
            $item['summary1'] = utf8substr($item['summary'], 0, 10);
            $item['content1'] = utf8substr($item['content'], 0, 18);
            //var_dump($users);
            $types = $this->mtypes->getCategoryById($item['type']);
            $item['type']= isset($types[0]['name']) ? $types[0]['name'] : '';
            $users = self::getUserinfoById($item['uid']);
            $item['uid']= count($users) > 0 ? $users[0]['legalname'] : '保密';
            $newData[] = $item;
        }
        //获取总数
        $shopCount = $this->mshops->shopManager_count();
        $pageShow = self::_mkPage($page, $shopCount,'/shops/shopManager');
        $this->load->view('default/shops_manager',array('shopsData'=>$newData,'showPage'=>$pageShow,'state'=>$status));
    }

    /*********==================================以上为店铺相关操作函数=============================================***********/
    function get_commodityParams(){
        //var_dump($_POST);exit;
        $shops_id = get_post('shops_id') ? htmlspecialchars(get_post('shops_id')) : '';
        $title = get_post('title') ? htmlspecialchars(get_post('title')) : '';
        $jianjie = get_post('jianjie') ? htmlspecialchars(get_post('jianjie')) : '';
        $content = get_post('content') ? htmlspecialchars(get_post('content')) : '';
        $price = get_post('price') ? floatval(get_post('price')) : '';
        $discount = get_post('discount') ? floatval(get_post('discount')) : '';
        $new_price = $price * ($discount/100);
        $is_hot = 1;
        $is_status = 1;
        $photos = get_post('pics')? htmlspecialchars(get_post('pics')) : '';
        $type= get_post('type')? htmlspecialchars(get_post('type')):'';
        $type1 = get_post('type1')?get_post('type1'):'';

        $data = array(
            'uid'=>UID,
            'shops_id' => $shops_id,
            'title' => $title,
            'jianjie' => $jianjie,
            'content'=>$content,
            'price' => $price,
            'discount' => $discount,
            'new_price' => $new_price,
            'channel_id' => $type,
            'type' => $type1 ? $type1 : $type,
            'is_hot' => $is_hot,
            'is_status' => $is_status,
            'photos'=> serialize($photos),
            'dateline'=>time()
        );
        return $data;
    }

    /**
     * 店铺发布新商品信息
     */
    public function addCommodityInfo()
    {
        $commodityState = get_post('commodityState');
        if(!$commodityState){
            $shops = $this->shops->getShopsById(UID);
            $category = $this->shops->getCategory();
            //添加表单token
            $token = self::grante_token(UID);
            $this->load->view('default/shops_add_commodity',array('shopsinfo'=>@$shops,'category'=>array($category[0]), 'token'=>$token));
        }else{
            $form_token = get_post('token');
            if(self::is_token(UID, $form_token)){
                $data = $this->get_commodityParams();
                // var_dump($data);exit;
                $this->shops->addCommodityInfo($data);
                self::drop_token(UID);
                $this->show_commodity(1,1);
            }else $this->show_commodity(1,3);
        }
    }


    /**
     * @param string $id
     */
    public function show_edit_commodity($id='')
    {
        if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'shops/show_commodity">点击返回</a>'));
        //获取商品详细信息
        $dlist = $this->shops->getCommodityById($id);
        $shopsInfo =  $this->shops->getShopsById(UID);
        //添加表单token
        $token = self::grante_token(UID);
        $this->load->view('default/shops_showEditCommodity', array('dlist'=>$dlist,'shopsInof'=>$shopsInfo,'token'=>$token));
    }

    /**
     * 店铺更新商品信息
     */
    public function editCommodityInfo()
    {
        $form_token = get_post('token');
        if(self::is_token(UID, $form_token)){
            $id = get_post('commodityid')?htmlspecialchars(get_post('commodityid')):'';
            if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'shops/show_commodity">点击返回</a>'));
            $data = $this->get_commodityParams();
            $data['id'] = $id;
            $this->shops->editCommodityInfo($data);
            self::drop_token(UID);
            $this->show_commodity(1,1);
        }else $this->show_commodity(1,2);
    }

    /**
     * 店铺删除商品信息
     */
    public function delCommodityInfo($id ='')
    {
        if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'shops/show_commodity">点击返回</a>'));
        $this->shops->delCommodityInfo($id);
        $this->show_commodity();
    }

    /**
     * 显示已发布商品列表页
     */
    public function show_commodity($page =1, $state=0)
    {
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $shopsInfo =  $this->shops->getShopsIds(UID);

        $str = '';
        foreach($shopsInfo as $i){
            $str[] = $i['id'];
        }
        $datas = array();
        $param['shops_id'] = $str;
        $list = $this->shops->getCommodityInfo($param);
        foreach ($list as $key => $value) {
            $value['sub_jianjie']=utf8substr($value['jianjie'],0,10);
            $value['sub_title']=utf8substr($value['title'],0,10);
            $datas[] = $value;
        }
        $list_count = $this->shops->getCommodityInfo_count($param);
        $pageShow = self::_mkPage($page, $list_count,'/shops/show_commodity');
        //utf8substr()
        $this->load->view('/shops/show_commodity',array('shops'=>$shopsInfo,'list'=>$datas,'pageShow'=>$pageShow,'state'=>$state));
    }

    /**
     * 获取某店铺商品信息
     * @author gefc
     */
    function commodityList(){
        $this->load->helper('common');
        $page_param = $this->input->get_post('page');
        $page = $page_param ? htmlspecialchars($page_param) : '';
        $pages = (!$page) ? self::PAGESIZE * 0 : self::PAGESIZE*$page;
        $shops_id = get_post('shopsid') ? htmlspecialchars(get_post('shopsid')) : '';
        if(!$shops_id){ echo json_encode(array('status'=>0));return;}
        $data = array('shops_id' => $shops_id, 'limit' => self::PAGESIZE, 'offset' => $pages);
        $list = $this->shops->getCommodityInfo($data);
        $state = count($list)>0?1:0;
        $datas = array();
        foreach ($list as $key => $value) {
            $value['sub_jianjie']=utf8substr($value['jianjie'],0,10);
            $datas[] = $value;
        }
        echo json_encode(array('status'=>$state,'data'=>$datas));
    }

    /**
     * 获取当前用户发布商品
     */
    public function getCommodity()
    {
        $rel = $this->shops->getCommodity(UID);
        echo json_encode(array('status'=>1,'data'=>$rel));
    }
    /*********==================================以上为店铺商品相关操作函数  end=============================================***********/
    public function preferential_params()
    {
        $commodity = get_post('commodityid') ? htmlspecialchars(get_post('commodityid')) : '';
        $jianjie = get_post('jianjie') ? htmlspecialchars(get_post('jianjie')) : '';
        $zhekou = get_post('zhekou') ? htmlspecialchars(get_post('zhekou')) : '';
        $pics = get_post('pics') ? htmlspecialchars(get_post('pics')) : '';
        $is_status = 1;
        $id = get_post('id') ? htmlspecialchars(get_post('id')) : '';
        $datetime = time();

        $data = array('commodity' => $commodity,
            'uid'=>UID,
            'datetime'=>$datetime,
            'jianjie'=>$jianjie,
            'zhekou' => $zhekou,
            'pics'=>serialize($pics),
            //'is_status' => $is_status
        );
        if(!$id)$data['is_status']=$is_status;
        else $data['id']=$id;
        return $data;
    }

    /**
     * 发布打折信息
     */
    public function addPreferentialInfo()
    {
        $preferentialState = get_post('preferentialState');
        if(!$preferentialState){
            $rel = $this->shops->getCommodity(UID);
            //添加表单token
            $token = self::grante_token(UID);
            $this->load->view('default/shops_addPreferential',array('clist'=>$rel,'token'=>$token));
        }else{
            $ids = get_post('hid_commodityid');
            $new_ids =  explode(',', $ids);
            $form_token = get_post('token');
            if(self::is_token(UID, $form_token)){
                //                     var_dump($new_ids);exit;
                foreach ($new_ids as $key => $value) {
                    $data =  $this->preferential_params();
                    $data['commodity'] = $value;
                    // var_dump($data);
                    $state = $this->shops->addPreferentialInfo($data);
                }
                self::drop_token(UID);
                $this->getPreferentialInfo(1,1);
            }else
                //重新加载打折列表
            $this->getPreferentialInfo(1,2);

        }
    }

    /**
     * 关闭打折信息
     */
    public function delPreferentialInfo($id='')
    {
        if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'shops/getPreferentialInfo">点击返回</a>'));
        $state = $this->shops->delPreferentialInfo($id);
        if(!$state) show_error(array('删除操作失败！','<a href="'.WEB_URL.'shops/getPreferentialInfo">点击返回</a>'));
        else $this->getPreferentialInfo(1,1);
    }

    /**
     * 已发布打折信息列表
     */
    public function getPreferentialInfo($page =1, $state = 0)
    {
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $param['uid'] = UID;
        $pInfo =  $this->shops->getPreferentialInfo($param);
        $new_pInfo = array();
        foreach($pInfo as $item){
            $item['new_jianjie'] =utf8substr($item['jianjie'],0,10);
            $new_pInfo[] = $item;
        }
        $list_count = $this->shops->getPreferentialInfo_count($param);
        $pageShow = self::_mkPage($page, $list_count,'/shops/getPreferentialInfo');
        //utf8substr()
        $this->load->view('/shops/preferentialInfo',array('PreferentialInfo'=>$new_pInfo,'pageShow'=>$pageShow, 'state'=>$state));
    }

    /**
     * @param string $id
     */
    public function editPreferential($id='')
    {
        if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'shops/getPreferentialInfo">点击返回</a>'));
        $infos = $this->shops->editPreferential($id);
        $rel = $this->shops->getCommodity(UID);
        //添加表单token
        $token = self::grante_token(UID);
        $this->load->view('/shops/showEditPreferential',array('Predata'=>$infos,'commodity'=>$rel,'token'=>$token));
    }

    /**
     *
     */
    public function updatePreferential()
    {
        $form_token = get_post('token');
        if(self::is_token(UID, $form_token)){
            $data = $this->preferential_params();
            $this->shops->updatePreferential($data);
            self::drop_token(UID);
            $this->getPreferentialInfo(1,1);
        }else{
            $this->getPreferentialInfo(1,2);
        }

    }

    /**-----------------------------各种展示---------------------------------------**/
    public function showShops($id='')
    {
        $lists = array();
        if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'shops/getShopsInfo">点击返回</a>'));
        $arr = $this->mshops->getShopsInfo($id);
        foreach($arr as $item){
            $item['pics'] = explode(';', unserialize($item['photoid']));
            $item['dateline'] = date('Y-m-d',$item['dateline']);
            $lists[] = $item;
        }

        $this->load->view('default/shops_show',array('shopsInfo'=>$lists));
    }

    /**
     * @param string $id
     */
    public function showCommodity($id='')
    {

        $lists = array();
        if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'shops/getShopsInfo">点击返回</a>'));
        $arr = $this->shops->getCommodityById($id);
        foreach($arr as $item){
            $item['pics'] = explode(';', unserialize($item['photos']));
            $item['dateline'] = date('Y-m-d',$item['dateline']);
            $lists[] = $item;
        }
        $this->load->view('default/shops_showCommodity',array('commodifyInfo'=>$lists));
    }

    /**
     * @param string $id
     */
    public function showPreferential($id='')
    {
        $lists = array();
        if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'shops/getShopsInfo">点击返回</a>'));
        $arr = $this->shops->editPreferential($id);
        foreach($arr as $item){
            $item['pics'] = explode(';', unserialize($item['pics']));
            $item['dateline'] = date('Y-m-d',$item['datetime']);
            $lists[] = $item;
        }
        $this->load->view('default/shops_showPreferential',array('preferentialInfo'=>$lists));
    }


    public function uploads() {
        //$sdata = $this->session->all_cserdata();
        //var_dump($sdata);exit;
        // $this->load->view('shops/index');
        $fileutil = new File_util();
        $time = date('Y/m/d', time());
        $targetFolder = 'UpLoadFile/'.$time;
        $file = $_FILES['Filedata'];
        $tempFile = $file['tmp_name'];
        $targetPath = FWPHP_PATH . $targetFolder;
        $web_path = $targetFolder .'/'.$file['name'];
        if (!file_exists($targetFolder))
            $fileutil -> createDir($targetFolder);
        $targetFile = rtrim($targetPath, '/') . '/' . $file['name'];
        $dataList = array('name' => $file['name'], 'size' => $file['size'], 'picUrl' => base_url().$web_path,'hid_pics'=>$web_path);
        // Validate the file type
        $fileTypes = array('jpg', 'jpeg', 'gif', 'png');
        // File extensions
        $fileParts = pathinfo($file['name']);

        if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
            move_uploaded_file($tempFile, $targetFile);
            echo json_encode(array('status'=>1,'data'=>$dataList));
        } else {
            echo json_encode(array('status'=>0,'data'=>'Invalid file type.'));
        }
    }

    public function gourmetUpload() {
        //$sdata = $this->session->all_cserdata();
        //var_dump($sdata);exit;
        // $this->load->view('shops/index');
        $fileutil = new File_util();
        $time = date('Y/m/d', time());
        $targetFolder = 'UpLoadFile/'.$time;
        $file = $_FILES['Filedata'];
        $tempFile = $file['tmp_name'];
        $targetPath = FWPHP_PATH . $targetFolder;
        $web_path = 'UpLoadFile/'.$time.'/'.$file['name'];
        if (!file_exists($targetFolder))
            $fileutil -> createDir($targetFolder);
        $targetFile = rtrim($targetPath, '/') . '/' . $file['name'];
        $dataList = array('name' => $file['name'], 'size' => $file['size'], 'picUrl' => base_url().$web_path,'hid_pics'=>$web_path);
        // Validate the file type
        $fileTypes = array('jpg', 'jpeg', 'gif', 'png');
        // File extensions
        $fileParts = pathinfo($file['name']);

        if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
            move_uploaded_file($tempFile, $targetFile);
            echo json_encode(array('status'=>1,'data'=>$dataList));
        } else {
            echo json_encode(array('status'=>0,'data'=>'Invalid file type.'));
        }
    }
}
?>