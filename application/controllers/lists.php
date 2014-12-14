<?php
	/**
	 * 用户登陆后，设置相关 、及收藏
     * gefc
     *
	 */
	class Lists extends MY_Controller {
        const PAGESIZE = 5;
		function __construct() {
			parent:: __construct();
            if(!defined('USER_ID')) self::is_login();
			$this->load->model('favorites_model','mfavorites');
            $this->load->model('goods_model','mgoods');
            $this->load->model('user_model','muser');
            $this->load->model('shops_model','mshops');
		}

        /**
         * 修改头像
         */
        function edit_user_face(){
            $param['face'] = $this->input->get_post('face') ? serialize(htmlspecialchars($this->input->get_post('face'))) :'';
            $param['currentUserSign'] = $this->input->get_post('currentUserSign') ? htmlspecialchars($this->input->get_post('currentUserSign')) :'';
            $myusers = $this->muser->edit_user_face($param);
            echo json_encode(array('state'=>1));
        }

        function delcoll($id=''){
            $this->mfavorites->del_sc($id);
            self::show_list();
        }

        /**
         *
         */
        function show_coll(){
            //$this->load->model('Gourmet_model','gourmet');
            //$this->load->model('happy_model','happy');
            //$this->load->model('live_model','live');


            $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')) : 1;
            $offset = ($page-1) * self::PAGESIZE;
            $limit = self::PAGESIZE;
            $data = array('limit' => $limit ,'offset' => $offset ,'uid' => USER_ID);
			$jgjs=array();
			$rel_count = $this->mfavorites->get_sc_count($data);
            $startPage = 1;
            $endPage = ceil($rel_count/self::PAGESIZE);
            $upPage = $page-1 > 0 ? $page -1 : 1;
            $downPage = $page+1 <= $endPage ? $page +1 : $endPage;
			if($endPage >= $page){
				$rel = $this->mfavorites->get_sc_info($data);
                //var_dump($rel);exit;
				foreach ($rel as $row)
				{
                        $rows = $this->mshops->detail($row['shopid']);

                        $j=self::show_pic($rows['photoid']);
                        $jg['photos']=base_url() . $j[0];
                        $jg['title']=$rows['title'];
                        //$jg['new_price']=$rows['cprice'];
                        $jg['is_status'] = 2;
                        $jg['sub_title'] = utf8substr($rows['title'], 0, 18);
                        $jg['url'] = WEB_URL . "shops/detail/".$row['shopid']."?cid=".$row['channelid'];
                        $jg['durl'] = WEB_URL . 'lists/delcoll/'.$row['id'];
                        $jgjs[]=$jg;
                    }


            }

            echo json_encode(array('status'=>1,'count'=>array('startPage'=>$startPage,'endPage'=>$endPage,'upPage'=>$upPage,'downPage'=>$downPage),'sclist'=> $jgjs));

        }


        /**
         *
         */
        function show_list(){
            //获取用户资料
            $u_i = $this->muser->get_user_info(USER_ID);
            $u_i['nickname'] = isset($u_i['nickname']) ? $u_i['nickname'] : $u_i['username'] ;
            $u_i['picture'] = self::facePic($u_i['picture'] );
			//echo "<pre>";
			//print_r($u_i);
			$this->load->view('default/person',array('list_u' => $u_i));
		}

        /**
         * 更新用户基本信息
         */
        function  edit_user_base(){
            $param['userNickName'] = $this->input->get_post('userNickName') ? htmlspecialchars($this->input->get_post('userNickName')) :'';
            $param['userSex'] = $this->input->get_post('userSex') ? htmlspecialchars($this->input->get_post('userSex')) :'';
            $param['userCityName'] = $this->input->get_post('userCityName') ? htmlspecialchars($this->input->get_post('userCityName')) :'';
            $param['userTelName'] = $this->input->get_post('userTelName') ? htmlspecialchars($this->input->get_post('userTelName')) :'';
            $param['userEmailName'] = $this->input->get_post('userEmailName') ? htmlspecialchars($this->input->get_post('userEmailName')) :'';
            $param['userSign'] = $this->input->get_post('userSign') ? htmlspecialchars($this->input->get_post('userSign')) :'';
            $param['currentUserSign'] = $this->input->get_post('currentUserSign') ? htmlspecialchars($this->input->get_post('currentUserSign')) :'';
            $myusers = $this->muser->edit_user_base($param);
           echo json_encode(array('state'=>1));
        }

        /**
         * 更新用户详细信息
         */
        function edit_user_detail(){
            $param['weight'] = $this->input->get_post('weight') ? htmlspecialchars($this->input->get_post('weight')) :'';
            $param['loveStatus'] = $this->input->get_post('loveStatus') ? htmlspecialchars($this->input->get_post('loveStatus')) :'';
            $param['datepicker'] = $this->input->get_post('datepicker') ? htmlspecialchars($this->input->get_post('datepicker')) :'';
            $param['select_Constellation'] = $this->input->get_post('select_Constellation') ? htmlspecialchars($this->input->get_post('select_Constellation')) :'';
            $param['userQQ'] = $this->input->get_post('userQQ') ? htmlspecialchars($this->input->get_post('userQQ')) :'';
            $param['isQQPublic'] = $this->input->get_post('isQQPublic') ? htmlspecialchars($this->input->get_post('isQQPublic')) :'';
            $param['job'] = $this->input->get_post('job') ? htmlspecialchars($this->input->get_post('job')) :'';
            $param['university'] = $this->input->get_post('university') ? htmlspecialchars($this->input->get_post('university')) :'';
            $param['middleSchool'] = $this->input->get_post('middleSchool') ? htmlspecialchars($this->input->get_post('middleSchool')) :'';
            $param['userHomePage'] = $this->input->get_post('userHomePage') ? htmlspecialchars($this->input->get_post('userHomePage')) :'';
            $param['interest'] = $this->input->get_post('interest') ? htmlspecialchars($this->input->get_post('interest')) :'';
            $param['userid'] = $this->input->get_post('userid') ? htmlspecialchars($this->input->get_post('userid')) :'';
            //var_dump($param);
            $myusers = $this->muser->edit_user_detail($param);
            echo json_encode(array('state'=>1));
        }

        /**
         * 获取用户信息
         */
        function get_user_info(){
            $myusers = $this->muser->get_user_info(USER_ID);
            var_dump($myusers);
        }

        /**
         * 上传头像
         */
        public function uploads() {
            $this -> load -> library('File_util');
            //$sdata = $this->session->all_cserdata();
            //var_dump($sdata);exit;
            // $this->load->view('shops/index');
            $fileutil = new File_util();
            $time = date('Y/m/d', time());
            $targetFolder = '/weixun/UpLoadFile/';
            $file = $_FILES['Filedata'];
            $tempFile = $file['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder.$time;
            $web_path = base_url().'UpLoadFile/'.$time.'/'.$file['name'];
            if (!file_exists($targetPath))
                $fileutil -> createDir($targetPath);
            $targetFile = rtrim($targetPath, '/') . '/' . $file['name'];
            $dataList = array('name' => $file['name'], 'size' => $file['size'], 'picUrl' => $web_path,'base_pic'=>'UpLoadFile/'.$time.'/'.$file['name']);
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png');
            // File extensions
            $fileParts = pathinfo($file['name']);

            if (in_array($fileParts['extension'], $fileTypes)) {
                move_uploaded_file($tempFile, $targetFile);
                echo json_encode(array('status'=>1,'data'=>$dataList));
            } else {
                echo json_encode(array('status'=>0,'data'=>'Invalid file type.'));
            }
        }
	}
?>