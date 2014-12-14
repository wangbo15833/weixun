<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * req=0101 注册
 * req=0102 登陆
 *
 * req=0201 获取频道列表
 *
 * req=0301 按频道ID获取二级栏目
 *
 * req=0401 获取区县列表
 *
 * req=0501 添加“我发现”店铺
 * req=0502 按条件获取店铺列表
 *
 * req=0601 添加店铺
 * req=0602 店铺编辑保存
 * req=0603 按用户ID获取店铺列表
 * req=0604 按ID获取店铺记录
 *
 * req=0701 添加优惠
 * req=0702 删除优惠信息
 * req=0703 优惠编辑保存
 * req=0704 获取某一店铺所有优惠信息
 * req=0705 获取所有优惠信息
 * req=0706 按ID获取优惠信息
 *
 * req=0801 为会员增加会员卡
 * req=0802 为用户增加积分
 * req=0803 会员获取自己的所有会员卡列表
 * req=0804 店铺认证某一会员卡是否为本店会员
 *
 * req=0901 对商品添加评价
 * req=0902 获取某一店铺评价列表
 * req=0903 按uid获取评价列表
 *
 * req=1001 获取软件推荐信息列表
 *
 * req=1101 添加个人收藏
 * req=1102 删除个人收藏
 * req=1103 获取个人收藏
 *
 * req=1201 添加意见反馈
 *
 */
class Customer extends CI_Controller {

    function __construct(){
        parent :: __construct();
        define('DEFAULT_PIC', 'frontend/Public/images/bj.jpg');
        //$this->load->library('session');
        $this->load->model('user_model','muser');
        //$this->load->model('ordermeal_model','mordermeal');
        //$this->load->model('goods_model','mgoods');
        $this->load->model('types_model','mtypes');
        $this->load->model('channel_model','mchannel');
        $this->load->model('area_model','marea');
        $this->load->model('shops_model','mshops');
        $this->load->model('feedback_model','mfeedback');
        $this->load->model('favorites_model','mfavorites');
        $this->load->model('moreapp_model','mmoreapp');
        $this->load->model('comment_model','mcomment');
        $this->load->model('promotion_model','mpromotion');
        $this->load->model('mcard_model','mmcard');
        $this->load->model('district_model','mdistrict');
        $this->load->model('notice_model','mnotice');
        $this->load->model('luck_model','mluck');
		$this->load->model('consumption_model','mconsumption');
		$this->load->model('coupons_model','mcoupons');
		$this->load->model('guide_model','mguide');

    }

	public function index()
	{
        //请求码
        if($this->input->get_post('req'))
            $req = $this->input->get_post('req');

        //用户名
        if($this->input->get_post('username'))
            $username = $this->input->get_post('username');

        //密码
        if($this->input->get_post('password'))
            $password = sysAuthCode($this->input->get_post('password'));
        //电话
        if($this->input->get_post('telephone'))
            $tel = $this->input->get_post('telephone');

        //频道ID
        if($this->input->get_post('cid'))
            $channelid = $this->input->get_post('cid');

        //用户ID
        if($this->input->get_post('uid'))
            $userid = $this->input->get_post('uid');

        //通知ID
        if($this->input->get_post('nid'))
            $noticeid = $this->input->get_post('nid');

        //抽奖ID
        if($this->input->get_post('luckid'))
            $luckid = $this->input->get_post('luckid');

        //店铺标题
        if($this->input->get_post('title'))
            $title = $this->input->get_post('title');

        //店铺简介
        if($this->input->get_post('summary'))
            $summary = $this->input->get_post('summary');

        //店铺详情
        if($this->input->get_post('content'))
            $content = $this->input->get_post('content');

        //店铺地址
        if($this->input->get_post('address'))
            $address = $this->input->get_post('address');

        //联系电话
        if($this->input->get_post('phone'))
            $phone = $this->input->get_post('phone');

        //百度地图横坐标
        if($this->input->get_post('map_x'))
            $map_x = $this->input->get_post('map_x');

        //百度地图纵坐标
        if($this->input->get_post('map_y'))
            $map_y = $this->input->get_post('map_y');

        //二级栏目ID
        if ($this->input->get_post('tid'))
            $typeid = $this->input->get_post('tid');

        //区县ID
        if ($this->input->get_post('aid'))
            $areaid = $this->input->get_post('aid');

        //城市ID
        if ($this->input->get_post('cityid'))
            $cityid = $this->input->get_post('cityid');

        //我发现栏目ID
        if($this->input->get_post('fid'))
            $ftypeid = $this->input->get_post('fid');

        //图片url
        if($this->input->get_post('purl'))
            $photourl = $this->input->get_post('purl');

        //排序方式
        if($this->input->get_post('order'))
            $order = $this->input->get_post('order');

        //是否为“我发现”店铺
        if($this->input->get_post('ismyfind'))
            $ismyfind = $this->input->get_post('ismyfind');

        //店铺ID
        if($this->input->get_post('shopid'))
            $shopid = $this->input->get_post('shopid');

        //优惠信息ID
        if($this->input->get_post('pid'))
            $pid = $this->input->get_post('pid');

        //优惠名称
        if($this->input->get_post('pname'))
            $pname = $this->input->get_post('pname');

        //优惠内容
        if($this->input->get_post('pcontent'))
            $pcontent = $this->input->get_post('pcontent');

        //活动开始时间
        $start = $this->input->get_post('start');

        //活动结束时间
        $end = $this->input->get_post('end');

        //会员卡ID
        $mcid = $this->input->get_post('mcid');

        //积分
        $jf = $this->input->get_post('jf');

        //评价内容message
        $message = $this->input->get_post('message');

        //商品分数
        $gscore = $this->input->get_post('gscore');

        //服务分数
        $sscore = $this->input->get_post('sscore');

        //环境分数
        $cscore = $this->input->get_post('cscore');

        //收藏信息ID
        $faid = $this->input->get_post('faid');

        //联系方式
        $contacts = $this->input->get_post('contacts');

        //接收者列表
        $receivers = $this->input->get_post('receivers');

        //时间
        $pubtime = time();
        //经度
        $lontitude=$this->input->get_post('lon');
        //纬度
        $latitude=$this->input->get_post('lat');

		//年
		$myear = date('Y',$pubtime);
		//月
		$mmonth = date('m',$pubtime);

		//日
		$mday = date('d',$pubtime);

		//消费记录ID
		$conid = $this->input->get_post('conid');

		//消费金额
		$amount= $this->input->get_post('amount');

		//消费金额
		$couid= $this->input->get_post('couid');

        //验证码
        $captcha=$this->input->get_post('captcha');

        //uuid
        $uuid=$this->input->get_post('uuid');

        //距离
        $distance=$this->input->get_post('distance');

        //页数
        $page=$this->input->get_post('page');

		


        switch($req){
            /*
             *用户名注册
             */
            case '0101':
                $data['username']=$username;
                $data['password']=$password;
                $data['tel']=$tel;
                $data['captcha']=$captcha;
                $data['uuid']=$uuid;
                $this->register($data);
                break;

            /*
             *用户登录
             */
            case '0102':
                $data['username']=$username;
                $data['password']=$password;
                $this->login($data);
                break;

            case '0103':
                $this->getSms($tel);
                break;

			case '0104':
                //$data['shopid']=$shopid;
                $this->getUserByShopID($shopid);
                break;
			
			case '0105':
				$data['shopid']=$shopid;
				$data['startdate']=mktime(0,0,0,$mmonth,$mday,$myear);
				$data['enddate']=mktime(23,59,59,$mmonth,$mday,$myear);
				$this->getUsers($data);
				break;
			
			case '0106':
				$data['shopid']=$shopid;
				$data['jf']=$jf;
				$this->getUsers($data);
				break;

            /*
             * 获取频道列表
             */
            case '0201':
                $this->getAllChannels();
                break;

            /*
             * 按频道ID获取二级栏目
             */
            case '0301':
                $this->getTypes($channelid);
                break;

            /*
             * 获取区县列表
             */
            case '0401':
                $this->getAllDistrict($cityid);
                break;

            /*
             * 添加“我发现”店铺
             */
            case '0501':
                $data['uid']=$userid;
                $data['title']=$title;
                $data['summary']=$summary;
                $data['content']=$content;
                $data['address']=$address;
                $data['phone']=$phone;
                $data['map_x']=$map_x;
                $data['map_y']=$map_y;
                $data['channel_id']=$channelid;
                $data['type_id']=$typeid;
                $data['area_id']=$areaid;
                $data['ftype_id']=$ftypeid;
                $data['photoid']=$photourl;
                $data['is_myfind']=1;
                $data['pubdate']=$pubtime;
                $this->shopAdd($data);
                break;

            /*
             * 按选择条件获取店铺列表
             */
            case '0502':

                if(isset($channelid)) $data['channel_id']=$channelid;
                if(isset($typeid)) $data['type_id']=$typeid;
                if(isset($areaid)) $data['area_id']=$areaid;
                if(isset($ismyfind)) $data['ismyfind']=$ismyfind;
                if(isset($map_x)) $data['map_x']=$map_x;
                if(isset($map_y)) $data['map_y']=$map_y;
                if(isset($distance)) $data['distance']=$distance;
                if(isset($page)) $data['page']=$page;
                $data['limit']=10;
                $data['offset']=($page-1) * 10;

                $data['order']=isset($order)?$order:1;
                $this->getShopsList1($data);
                break;

            /*
             * 添加店铺
             */
            case '0601':
                $data['uid']=$userid;
                $data['title']=$title;
                $data['summary']=$summary;
                $data['content']=$content;
                $data['address']=$address;
                $data['phone']=$phone;
                $data['map_x']=$map_x;
                $data['map_y']=$map_y;
                $data['channelid']=$channelid;
                $data['typeid']=$typeid;
                $data['areaid']=$areaid;
                $data['ftypeid']=$ftypeid;
                $data['photourl']=$photourl;
                $data['is_myfind']=0;
                $data['pubdate']=$pubtime;
                $this->shopAdd($data);
                break;

            /*
             * 店铺编辑保存
             */
            case '0602':
                $data['title']=$title;
                $data['summary']=$summary;
                $data['content']=$content;
                $data['address']=$address;
                $data['phone']=$phone;
                $data['map_x']=$map_x;
                $data['map_y']=$map_y;
                $data['channel_id']=$channelid;
                $data['type_id']=$typeid;
                $data['area_id']=$areaid;
                $data['photoid']=$photourl;

                $this->shopEditDo($shopid,$data);
                break;

            /*
             * 按用户ID获取店铺列表
             */

            case '0603':
                $this->getShopsListByUid($userid);
                break;


            /*
             * 按用户ID获取店铺记录
             */
            case '0604':
                $this->getShopByID($shopid);
                break;


            /**
             * 添加优惠活动
             */
            case '0701':
                $data['pname']=$pname;
                $data['pcontent']=$pcontent;
                $data['shopid']=$shopid;
                $data['start_time']=$start;
                $data['end_time']=$end;
                $data['uid']=$userid;
                $data['pubtime']=$pubtime;
                $this->promotionAdd($data);
                break;

            /*
             * 删除优惠信息
             */
            case '0702':
                $this->promotionDel($pid);
                break;

            /*
             * 优惠编辑保存
             */
            case '0703':
                $data['pid']=$pid;
                $data['pname']=$pname;
                $data['pcontent']=$pcontent;
                $data['shopid']=$shopid;
                $data['start_time']=$start;
                $data['end_time']=$end;
                $this->promotionEditDo($pid,$data);
                break;

            /*
             * 获取某一店铺所有优惠信息
             */
            case '0704':
                $this->getPromotionByShop($shopid);
                break;

            /*
             * 获取所有优惠信息
             */
            case '0705':
                $this->getAllPromotions();
                break;

            /*
             * 按ID获取优惠信息
             */
            case '0706':
                $this->getPromotionByID($pid);
                break;

            /*
             * 为会员增加会员卡
             */
            case '0801':
                $data['tel']=$tel;
                $data['shopid']=$shopid;
                $data['qrurl']=self::qrGenerate($tel);
                $data['regtime']=$pubtime;
                $data['jf']=0;

                $this->MCardAdd($data);
                break;

            /*
             * 会用户增加积分
             */
            case '0802':
                $this->JFAddByMC($mcid,$jf);
                break;

            /*
             * 会员获取自己的所有会员卡列表
             */
            case '0803':
                $this->getAllMCByUser($tel);
                break;

            /*
             * 店铺认证某一会员卡是否为本店会员
             */
            case '0804':
                $this->authMC($tel,$shopid);
                break;

			//积分兑换
			case '0805':
				$this->jfdh($mcid,$jf);
				break;

            /*
             * 对店铺添加评价
             */
            case '0901':
                $data['conid']=$conid;
                $data['message']=$message;
                $data['goods_score']=$gscore;
                $data['service_score']=$sscore;
                $data['condition_score']=$cscore;
                $data['uid']=$userid;
                $data['pubdate']=$pubtime;
                $this->CommentsAddByShop($data);
                break;

            /*
             * 获取某一店铺评价列表
             */
            case '0902':
                $this->getCommentsListByShop($shopid);
                break;

            /*
             * 按uid获取评价列表
             */
            case '0903':
                $this->getCommentsListByUid($userid);
                break;

            /*
             * 获取软件推荐信息列表
             */
            case '1001':
                $this->getOtherAppList();
                break;

            /*
             * 添加个人收藏
             */
            case '1101':
                $data['uid']=$userid;
                $data['shopid']=$shopid;
                $data['timeline']=$pubtime;
                $this->favoritesAdd($data);
                break;

            /*
             * 删除个人收藏
             */
            case '1102':
                $this->favoritesDel($faid);
                break;

            /*
             * 获取个人收藏
             */
            case '1103':
                $this->getFavoritesListByUid($userid);
                break;

            /*
             * 添加意见反馈
             */
            case '1201':
                $data['message']=$message;
                $data['contacts']=$contacts;
                $data['pubtime']=$pubtime;
                $this->feedbackAdd($data);
                break;

            

            case '1302':
                $data['shopid']=$shopid;
                $data['title']=$title;
                $data['content']=$content;
                $data['uid']=$userid;
                $data['pubtime']=$pubtime;
                $this->sendNotice($data,$receivers);
                break;

            case '1303':
                $this->getMyNotice($userid);
                break;

            case '1304':
                $this->noticedel($noticeid);
                break;

			case '1305':
				$this->getNotice($noticeid);
				break;

            case '1401':
                $data['shopid']=$shopid;
                $data['uid']=$userid;
                $data['content']=$content;
                $data['start']=$start;
                $data['end']=$end;
                $data['isLocked']=0;
                $data['pubtime']=$pubtime;
                $this->luckadd($data);
                break;

            case '1402':
                $this->luck($luckid);
                break;

            case '1403':
                $this->getLuckByShopID($shopid);
                break;

            case '1404':
                $this->getLuckByID($luckid);
                break;
			
			case '1501':
				$data['shopid']=$shopid;
				$data['mcid']=$mcid;
				$data['amount']=$amount;
				$data['pubtime']=$pubtime;
				$this->consumptionAdd($data);
				break;
			
			case '1502':
				$this->getConsumptionByShop($shopid);
				break;

			case '1503':
				$this->getConsumptionByUid($userid);
				break;
			
			case '1601':
				$data['title']=$title;
				$data['amount']=$amount;
				$data['start']=$start;
				$data['end']=$end;
				$data['shopid']=$shopid;
				$data['pubtime']=$pubtime;
				$this->sendCoupons($data,$receivers);
				break;

			case '1602':
				$this->getMyCoupons($userid);
                break;

			case '1603':
				$this->getCoupons($couid);
				break;

			case '1604':
				$this->useCoupons($couid);
				break;
			case '1701':
				$this->getGuides();
				break;
            case '9999':
                $this->test_getShopsList();
                break;

        }
	}


    /**
     * 用户注册函数
     * @param $param
     */
    public function register($param)
    {
		session_start();

        $data['username']=$param['username'];
        $data['password']=$param['password'];
        $data['tel']=$param['tel'];
        $captcha=$param['captcha'];
        $uuid=$param['uuid'];

        if($captcha==$_SESSION[$uuid]){

            if(!$data['tel'] || !$data['username'] || !$data['password'])
            {
                echo json_encode(array('status'=>0));
            }
            else{
                $this->muser->add_user($data);
                echo json_encode(array('status'=>1));

            }
        }
        else{
            echo json_encode(array('status'=>0,'msg'=>'验证码不正确'));
        }

    }

    /**
     * 用户登录函数
     * @param $param
     */

    function login($param){
        $data['username'] = $param['username'];
        $data['password']= $param['password'];
        $user=$this->muser->check_user($data);
        if($user){
            echo json_encode(array('status'=>1,'user'=>$user));
        }
        else{
            echo json_encode(array('status'=>0,'msg'=>'用户名不存在'));
        }

    }

    function Post($curlPost,$url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }
    function xml_to_array($xml){
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
                $subxml= $matches[2][$i];
                $key = $matches[1][$i];
                if(preg_match( $reg, $subxml )){
                    $arr[$key] = $this->xml_to_array( $subxml );
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }
    function random($length = 6 , $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }

    /**
     * 获取短信验证码
     */
    function getSms($tel){
		session_start();

        $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
//替换成自己的测试账号,参数顺序和wenservice对应

        //$mobile_code = $this->random(4,1); //临时删除
        $mobile_code=1234;
        if(empty($tel)){
            exit('手机号码不能为空');
        }
        $post_data = "account=cf_wangbo158&password=Iovemumy&mobile=".$tel."&content=".rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。");
//密码可以使用明文密码或使用32位MD5加密

        $uuid = get_uuid();
        //$this->session->set_userdata($uuid,$mobile_code);
		$_SESSION[$uuid]=$mobile_code;

        //$gets =  $this->xml_to_array($this->Post($post_data, $target));  测试阶段不要用验证码
        $gets=array('SubmitResult'=>array('code'=>"2"));//临时语句

        if($gets['SubmitResult']['code']=="2")
        {
            echo json_encode(array('status'=>1,'sessionid'=>session_id(),'uuid'=>$uuid));
        }
        else{
            echo json_encode(array('status'=>0));
        }


    }


    /**
     * 获取频道列表
     */

    function getAllChannels(){
        $channels=$this->mchannel->getChannel();
        if($channels){
            echo json_encode(array('status'=>1,'channels'=>$channels));
        }
        else{
            echo json_encode(array('status'=>0));
        }
    }

    /**
     * 按频道ID获取二级栏目
     */

    function getTypes($cid){
        $types=$this->mtypes->getTypes($cid);
        if($types){
            echo json_encode(array('status'=>1,'types'=>$types));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    /**
     * 获取区县列表
     */

    function getAllDistrict($pid){
        $areas=$this->mdistrict->getDistrictByPid($pid);
        if($areas){
            echo json_encode(array('status'=>1,'areas'=>$areas));
        }
        else{
            echo json_encode(array('status'=>0));
        }


    }

    /**
     * 添加“我发现”店铺
     */

    function myfindAdd($param){


    }

    /**
     * 按条件获取店铺列表
     */

    function getShopsList($param){
        $shops=$this->mshops->get_Shops_List($param);
        if($shops){
            $list = array();
            foreach($shops as $item){
                $pho=self::show_pic($item['photoid']);
                $image_file =$pho['0'];
                $image_info = getimagesize($image_file);
                //$item['photoid'] = "data:{$image_info['mime']};base64," . chunk_split(base64_encode(file_get_contents($image_file)));
                $item['photoid'] = chunk_split(base64_encode(file_get_contents($image_file)));
                $list[] = $item;
            }

            echo json_encode(array('status'=>1,'shops'=>$list));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

	function getShopsList1($param){
        $shops=$this->mshops->get_Shops_List($param);
        if($shops){
            $list = array();
            foreach($shops as $item){
                $pho=self::show_pic($item['photoid']);
                $image_file =$pho['0'];
                $souce_data=file_get_contents($image_file);
                $source_im = imagecreatefromstring($souce_data);

                $image_info = getimagesize($image_file);
                list($width, $height) = getimagesize($image_file);
                $newwidth=96;
                $newheight=96;
                $thumb = imagecreatetruecolor($newwidth, $newheight);
                imagecopyresized($thumb, $source_im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                ob_start();
                imagejpeg($thumb);
                $contents =  ob_get_contents();
                ob_end_clean();

                //$dest_im=file_get_contents($thumb);
                //$item['photoid'] = "data:{$image_info['mime']};base64," . chunk_split(base64_encode(file_get_contents($image_file)));
                $item['photoid'] = chunk_split(base64_encode($contents));
                $list[] = $item;
            }

            echo json_encode(array('status'=>1,'shops'=>$list));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    function test_getShopsList(){
        $shops=$this->mshops->test_getShop();
        var_dump($shops);

    }

    /**
     * 添加店铺
     */

    function shopAdd($param){
        $result=$this->mshops->shopAdd($param);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));

    }

    /**
     * 店铺编辑保存
     */
    function shopEditDo($shopid,$param){
        $result=$this->mshops->shopUpdate($shopid,$param);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));

    }

    /**
     * 按用户ID获取店铺列表
     */

    function getShopsListByUid($uid){
        $shops=$this->mshops->getShopsByUid($uid);
        if($shops){
            echo json_encode(array('status'=>1,'shops'=>$shops));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    /**
     * 按店铺ID获取店铺
     */

    function getShopByID($shopid){
        $shop=$this->mshops->detail($shopid);
        if($shop){
            echo json_encode(array('status'=>1,'shop'=>$shop));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    /**
     * 添加优惠
     */

    function promotionAdd($param){
        $result=$this->mpromotion->promotionAdd($param);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));

    }

    /**
     * 删除优惠信息
     */
    function promotionDel($pid){
        $result=$this->mpromotion->promotionDel($pid);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
    }

    /**
     * 优惠信息编辑保存
     */
    function promotionEditDo($pid,$param){
        $result=$this->mpromotion->promotionUpdate($pid,$param);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));

    }

    /**
     * 获取某一店铺所有优惠信息
     */

    function getPromotionByShop($shopid){
        $promotions=$this->mpromotion->getPromotionByShop($shopid);
        if($promotions){
            echo json_encode(array('status'=>1,'promotions'=>$promotions));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    /**
     * 获取所有优惠信息
     */

    function getAllPromotions(){
        $promotions=$this->mpromotion->getAllPromotions();
        if($promotions){
            echo json_encode(array('status'=>1,'promotions'=>$promotions));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    /**
     * 按ID获取优惠信息
     */

    function getPromotionByID($pid){
        $promotion=$this->mpromotion->detail($pid);
        if($promotion){
            echo json_encode(array('status'=>1,'promotion'=>$promotion));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    /**
     * 为会员增加会员卡
     */

    function MCardAdd($param){
        $mcard=$this->mmcard->getMcardByTelShop($param['tel'],$param['shopid']);
        if($mcard){
            echo json_encode(array('status'=>2,'errorcode'=>'会员已经存在！'));
        }
        else{
            $result=$this->mmcard->add_mcard($param);
            echo json_encode(array('status'=>1));
        }



    }

    /**
     * 为某一会员卡增加积分
     */
    function JFAddByMC($mcid,$jf){
        $result=$this->mmcard->jfAdd($mcid,$jf);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
    }

    /**
     * 会员获取自己的所有会员卡列表
     */

    function getAllMCByUser($tel){
        $mcards=$this->mmcard->getMcardByTel($tel);
        if($mcards){
            echo json_encode(array('status'=>1,'mcards'=>$mcards));
        }
        else{
            echo json_encode(array('status'=>0));
        }
    }

    /**
     * 店铺认证某一会员卡是否为本店会员
     */

    function authMC($tel,$shopid){
        $mcard=$this->mmcard->getMcardByTelShop($tel,$shopid);
        if($mcard){
            echo json_encode(array('status'=>1,'mcard'=>$mcard));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

	//为会员兑换积分

	function jfdh($mcid,$jf){
		$result=$this->mmcard->jfdh($mcid,$jf);
		if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
		
	}

    /**
     * 对店铺添加评价
     */

    function CommentsAddByShop($param){
        $result=$this->mcomment->add_comment($param);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));

    }

    /**
     * 获取某一店铺评价列表
     */

    function getCommentsListByShop($shopid){
        $comments=$this->mcomment->get_comment_list($shopid);
        if($comments){
            echo json_encode(array('status'=>1,'comments'=>$comments));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    /**
     * 按uid获取评价列表
     */

    function getCommentsListByUid($uid){
        $comments=$this->mcomment->getCommentsByUid($uid);
        if($comments){
            echo json_encode(array('status'=>1,'shops'=>$comments));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    /**
     * 获取软件推荐信息列表
     */
    function getOtherAppList(){
        $moreapps=$this->mmoreapp->getMoreApp();
        if($moreapps){
            echo json_encode(array('status'=>1,'moreapps'=>$moreapps));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    /**
     * 添加个人收藏
     */
    function favoritesAdd($param){
        $result=$this->mfavorites->add_sc($param);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
    }

    /**
     * 删除个人收藏
     */

    function favoritesDel($faid){
        $result=$this->mfavorites->del_sc($faid);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
    }

    /**
     * 获取个人收藏列表
     */

    function getFavoritesListByUid($uid){
        $favorites=$this->mfavorites->wdsc($uid);
        if($favorites){
            echo json_encode(array('status'=>1,'favorites'=>$favorites));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

    /**
     * 添加意见反馈
     */

    function feedbackAdd($param){
        $result=$this->mfeedback->feedbackAdd($param);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
    }

    /*
     * 生成二维码函数
     */
    function qrGenerate($value){
        $this->load->library('Phpqrcode_lib');
        $QRCODE_DIR='quickmark/';
        $errorCorrectionLevel = 'L';
        $matrixPointSize = 5;
        $filename = $QRCODE_DIR .md5($value.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';

        QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize);
        return $filename;

    }

    /*
     * 选出本店铺所有会员
     */
    function getUserByShopID($param){
        $users=$this->muser->getUserByShopID($param);
        if($users){
            echo json_encode(array('status'=>1,'users'=>$users));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

	function getUsers($param){
		$users=$this->muser->getUserList($param);
		if($users){
            echo json_encode(array('status'=>1,'users'=>$users));
        }
        else{
            echo json_encode(array('status'=>0));
        }

	}

    function sendNotice($param,$receivers){
        $result=$this->mnotice->noticeAdd($param);

        $receivers=explode(",",$receivers);
        foreach($receivers as $Item){
            $this->mnotice->noticeMapAdd($result,$Item);
        }

        echo json_encode(array('status'=>1));

    }

    function getMyNotice($param){
        $notices=$this->mnotice->getNoticeByReciver($param);
        if($notices){
            echo json_encode(array('status'=>1,'notices'=>$notices));
        }
        else{
            echo json_encode(array('status'=>0));
        }
    }

    function noticedel($param){
        $result=$this->mnotice->noticeDel($param);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
    }

	function getNotice($nid){
		
		$notice=$this->mnotice->detail($nid);
		if($notice){
            echo json_encode(array('status'=>1,'notice'=>$notice));
        }
        else{
            echo json_encode(array('status'=>0));
		}
			

	}


    function luckadd($param){
        $result=$this->mluck->luckAdd($param);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));

    }

    /*
     * 对某一抽奖项目进行抽奖
     */
    function luck($param){
        //获取抽奖所属店铺
        $luck=$this->mluck->detail($param);

        //获取店铺所有会员信息
        $users=$this->muser->getUserByShopID($luck['shopid']);

        //把本店铺所有会员ID另存为一个数组
        foreach($users as $Item){
            $list[]=$Item['id'];
        }

        //随机选取三个会员ID
        $randindex=array_rand($list,3);
        foreach($randindex as $Item){
            $luckers[]=$list[$Item];
        }

        //把抽取出的会员ID数组合并成字符串
        $luckerlist=implode(',',$luckers);

        //把获奖会员ID字符串存入数据库
        $result=$this->mluck->saveLuckers($param,$luckerlist);
        if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
    }

    function getLuckByShopID($param){
        $lucks=$this->mluck->getLuckByShopID($param);
        if($lucks){
            echo json_encode(array('status'=>1,'lucks'=>$lucks));
        }
        else{
            echo json_encode(array('status'=>0));
        }
    }


    function getLuckByID($luckid){
        $luck=$this->mluck->detail($luckid);
        if($luck){
            echo json_encode(array('status'=>1,'luck'=>$luck));
        }
        else{
            echo json_encode(array('status'=>0));
        }

    }

	function consumptionAdd($param){
		$result=$this->mconsumption->add_consumption($param);
		if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));

	}

	function getConsumptionByShop($shopid){
		$consumptions=$this->mconsumption->getConsumptionByShopID($shopid);
		if($consumptions){
            echo json_encode(array('status'=>1,'consumptions'=>$consumptions));
        }
        else{
            echo json_encode(array('status'=>0));
        }
	}

	function getConsumptionByUid($uid){
		$consumptions=$this->mconsumption->getConsumptionByUid($uid);
		if($consumptions){
            echo json_encode(array('status'=>1,'consumptions'=>$consumptions));
        }
        else{
            echo json_encode(array('status'=>0));
        }
	}

	function sendCoupons($data,$receivers){
		$result=$this->mcoupons->couponsAdd($data);
        $receivers=explode(",",$receivers);
        foreach($receivers as $Item){
            $this->mcoupons->couponsMapAdd($result,$Item);
        }

        echo json_encode(array('status'=>1));


	}

	function getMyCoupons($userid){
		$coupons=$this->mcoupons->getCouponsByReciver($userid);
        if($coupons){
            echo json_encode(array('status'=>1,'coupons'=>$coupons));
        }
        else{
            echo json_encode(array('status'=>0));
        }

	}

	function getCoupons($couid){
		$coupons=$this->mcoupons->getCouponsByID($couid);
		if($coupons){
            echo json_encode(array('status'=>1,'coupons'=>$coupons));
        }
        else{
            echo json_encode(array('status'=>0));
        }
	}

	function useCoupons($couid){
		$result=$this->mcoupons->useCoupons($couid);
		if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
	}

	function getGuides(){
		$guides=$this->mguide->get_guide_list();
		if($guides){
            echo json_encode(array('status'=>1,'guides'=>$guides));
        }
        else{
            echo json_encode(array('status'=>0));
        }

	}


    /**
     * @param $pics 序列号过的图片字符串
     * @return array 二维数组
     */
    //$j=self::show_pic($rows['photos']);
    // $jg['photos']=$j[0];

    function show_pic($pics)
    {

        $new_pics = unserialize($pics);

        if (!$new_pics)
            return array(DEFAULT_PIC);
        else {
            $l_pics = explode(';', $new_pics);
            return  $l_pics;
            //return $new_pics;
        }
    }




}
