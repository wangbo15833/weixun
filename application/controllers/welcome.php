<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
        $this->load->model('welcome_model','wm');
	}

    /**
     * 显示首页
     */
    function index()
	{
        $this->load->view('meituan/wx_show');
	}

    function c_area(){
        $link = mysql_connect('localhost','root','');
        if (!$link) {
            die('Could not connect to MySQL: ' . mysql_error());
        }
        mysql_query("set names utf8");
        mysql_select_db("test");
        $mysql = "SELECT * FROM service_info WHERE photo LIKE '%shopnopic_search.74ec0402f954b1f1088734ef58e593fc%'";
        $result = mysql_query($mysql ,$link);
        $keys = serialize('UpLoadFile/default/shopnopic_default.png');
        while($row=mysql_fetch_array($result)){
            $sql = " update service_info set `photo` ='".$keys."' where id = '".$row['id']."';\r\n";
            //echo $sql ; //exit;
            mysql_query($sql,$link);
        }
    }

    function c_maps(){
        $key_x = $this->input->get_post('x');
        $key_y = $this->input->get_post('y');
        $key_id = $this->input->get_post('id');
        $link = mysql_connect('localhost','root','');
        if (!$link) {
            die('Could not connect to MySQL: ' . mysql_error());
        }
        mysql_query("set names utf8");
        mysql_select_db("test");
        $rels = array();
        if($key_x && $key_y && $key_id){
            $sql = " update house_info set `maps` ='".$key_x.','.$key_y."',`map_x` ='".$key_x."',`map_y` ='".$key_y."' where id = '".$key_id."';\r\n";
            echo $sql ; //exit;
            mysql_query($sql,$link);
        }
        //LIKE '%116.404%'
        $mysql = "SELECT * FROM house_info WHERE maps LIKE '%116.404%'";
        $result = mysql_query($mysql ,$link);
        while($row=mysql_fetch_array($result)){
            $row['addrs'] = $row['addr'];
            $rels[] = $row;
        }
        $rand_keys = array_rand($rels);
        $new_row =$rels[$rand_keys];
        $this->load->view('default/test_map',array('rows'=>$new_row));
    }

    /**
     * 类型转换
     */
    function myshow(){
        $this->load->library('Pinyin');
        $link = mysql_connect('localhost','root','');
        if (!$link) {
            die('Could not connect to MySQL: ' . mysql_error());
        }
        mysql_query("set names utf8");
        mysql_select_db("temp");
        $result = mysql_query("select * from temp where id>4389",$link);
       // $sql='';
        while($row=mysql_fetch_assoc($result))
        {
            //var_dump(explode(';', unserialize($row['maps'])));exit;
            $data['name'] = trim($row['name']);
            $py = new Pinyin();
            $pyValue = $py->convert($row['name']);
            $ls = $py->mb_strrev($row['name']);
            $temp_str = '';
            foreach($ls as $item){
                $temp_str .= strtoupper(mb_substr($py->convert($item), 0, 1));
            }
            $data['quanpin'] = $pyValue;
            $data['jianpin'] = $temp_str;
            $data['price'] = explode('&nbsp;',$row['price'][0]);//元/㎡
            $data['addr'] = $row['addr'];
            $data['tag'] = $row['tmp'];
            $data['href'] = '';
            $data['type'] = 66;
            $data['phone'] ='';
            $data['photo'] = serialize($row['photo']);
            $data['maps'] = '';
            $data['area_id'] = $row['type'];
            $data['s_area'] = $row['s_type'];
            $data['summary'] = '';
            $data['state'] = 1;
            $data['area'] = '';
            $data['map_x'] = '';
            $data['map_y'] = '';
            $data['dateline'] = time();
            $sql = " insert into house_info(`name`,`jianpin`,`quanpin`,`price`,`addr`,`tag`,`href`,`type`,`phone`,`photo`,`maps`,`area_id`,`s_area`,`summary`,`dimensional_code`,`state`,`dateline`,`area`,`map_x`,`map_y`) values ('{$data['name']}','{$data['jianpin']}','{$data['quanpin']}','{$data['price']}','{$data['addr']}','{$data['tag']}','{$data['href']}','{$data['type']}','{$data['phone']}','{$data['photo']}','{$data['maps']}','{$data['area_id']}','{$data['s_area']}','{$data['summary']}','','{$data['state']}','{$data['dateline']}','{$data['area']}','{$data['map_x']}','{$data['map_y']}');\r\n";
            //echo $sql ; exit;
            //mysql_query($sql,$link);
            file_put_contents('house.sql', $sql, FILE_APPEND);
        }

    }

    function c_pic(){
        ini_set('memory_limit','512M');
        $link = mysql_connect('localhost','root','');
        if (!$link) {
            die('Could not connect to MySQL: ' . mysql_error());
        }
        mysql_query("set names utf8");
        set_time_limit(600);//设置超时限制为６分钟
        mysql_select_db("test");
        $this -> load -> library('File_util');
        for($k=71; $k< 92 ; $k++){
            $sql = '';
            $offset = $k * 50;
            $result = mysql_query("select * from house_info limit {$offset},50",$link);
            while($row=mysql_fetch_array($result))
            {
                $p = unserialize($row['photo']);
                if($p == ""){
                    $photoUrl = "UpLoadFile/default/shopnopic_default.png";
                }else{
                    $picname = substr($p,strrpos($p,'/')+1);
                    $photoUrl = self::grabImage($p,$picname);
                }
                //echo memory_get_usage()."\r\n";
                $sql .= " update base_shopping set `photo` ='".serialize($photoUrl)."' where id = '".$row['id']."';\r\n";
                unset($row);
            }
            unset($result);
            file_put_contents('pic_house.sql', $sql, FILE_APPEND);
            //sleep(5);
        }
    }

    function grabImage($url, $filename = '') {
        if($url == '') {
            return false; //如果 $url 为空则返回 false;
        }
        $ext_name = strrchr($url, '.'); //获取图片的扩展名
        if($ext_name != '.gif' && $ext_name != '.jpg' && $ext_name != '.bmp' && $ext_name != '.png') {
            return false; //格式不在允许的范围
        }
        if($filename == '') {
            $filename = time().$ext_name; //以时间戳另起名
        }
        $fileutil = new File_util();
        $time = date('Y/m/d', time());
        $targetFolder = '/weixun/UpLoadFile/';
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder.$time;
        $web_path = 'UpLoadFile/'.$time.'/'.$filename;

        if (!file_exists($targetPath))
            $fileutil -> createDir($targetPath);
        $targetFile = rtrim($targetPath, '/') . '/' . $filename;
        unset($fileutil);
        //开始捕获
        ob_start();
        readfile($url);
        $img_data = ob_get_contents();

        $size = strlen($img_data);
        $local_file = fopen($targetFile , 'a');
        fwrite($local_file, $img_data);
        fclose($local_file);
        ob_end_clean();
        return $web_path;
    }

    function mymap(){
        $this->load->view('default/test_map');
    }

    function getAround(){
        echo json_encode(array('state'=>1));
    }

    function setSolr(){
        $this->load->library('solrPhpClient.php');
        $solr = new Apache_Solr_Service('127.0.0.1', 8983, '/solr/');
        if(! $solr->ping()){
            echo "Solr service not responding";
            exit;
        }

        $parts = array(
            'noby'=>array('id'=>1, 'name'=> '张宴', 'content'=> '北京'),
            'zhangyan'=>array('id'=>2, 'name'=> '张宴', 'content'=> '北京五道口')
        );
        $documents = array();
        foreach($parts as $item => $fields){
            $part = new Apache_Solr_Document();
            foreach($fields as $key => $value){
                if(is_array($value)){
                    foreach($value as $datum){
                        $part->setMultiValue($key, $datum);
                    }
                }else{
                    $part->$key = $value;
                }
            }
            $documents[] = $part;
        }
        /*创建索引*/
        try{
            $document = new Apache_Solr_Document();
            $document->id='1111';
            $document->title='张宴';
            $document->content='北京';
            $document->tag='2123';
            $solr->addDocuments($document);
            //$document->id = uniqid(); //or something else suitably unique
            //$document->title = 'Some Title 张宴';
            //$document->content = 'Some content for this wonderful document. Blah blah blah.北京';
            //$document->tag="";
            //$solr->addDocuments($documents);
            $solr->commit();
            $solr -> optimize(true);
        }catch (Exception $e){
            echo $e-> getMessage();
        }

    }

    function delSolr(){
        $this->load->library('solrPhpClient.php');
        $solr = new Apache_Solr_Service('127.0.0.1', 8983, '/solr/');
        if(! $solr->ping()){
            echo "Solr service not responding";
            exit;
        }
        /*del索引*/
        try{
            //$document = new Apache_Solr_Document();

            //$solr->deleteById(4);//单条
            $solr->deleteByQuery('*:*');
            $solr->commit();
            $solr -> optimize(true);
        }catch (Exception $e){
            echo $e-> getMessage();
        }
    }
    function phpSolr(){
        $this->load->library('solrPhpClient.php');
        $solr = new Apache_Solr_Service('127.0.0.1', 8983, '/solr/');
        if(! $solr->ping()){
            echo "Solr service not responding";
            exit;
        }

        /*查询*/
        $offset = 0; $limit = 9999;
        $queries = array('channelId:2');
        foreach ($queries as $query){
            $response = $solr -> search($query, $offset, $limit);
            var_dump($response-> response->docs);exit;
            if($response -> getHttpStatus() == 200){
                if($response -> response->numFound > 0){
                    foreach($response->response->docs as $doc){
                        //var_dump($doc->getFieldValues());
                        $iterators = $doc->getIterator();
                        //var_dump($iterators);
                        echo $iterators['id'] ."<br/>".
                            $iterators['name']."<br/>".
                            $iterators['addr']."<br/>".
                            $iterators['tag']."<br/>";
                    }
                    echo '<br/>';
                }
            }else{
                echo $response->getHttpStatusMessage();
            }
        }
    }

    function solr(){
        $this->load->library('solrPhpClient.php');
        $solr = new Apache_Solr_Service('127.0.0.1', 8983, '/solr/');
        if(! $solr->ping()){
            echo "Solr service not responding";
            exit;
        }
        $param['data_status'] = 1;
        $ginfo = $this->wm->get_Gourmet_Info($param); //channelid 2   175
        //$param['where'] = " and c.type < 7 ";   //channelid 6     158
         //$param['where'] = " and c.type >= 7 ";  //channelid 3   188
        //$ginfo = $this->wm->get_Happy_Info($param);
        //$param['where'] = '  and c.type != 18';    //channelid 7 180
         //$param['where'] = '  and c.type = 18'; //channelid 5  181
        //$ginfo = $this->wm->get_Live_Info($param);
        //var_dump($ginfo);exit;
        var_dump(count($ginfo));
        $tempList =  $documents = array();
        $k = 0;
        //var_dump(count($ginfo));exit;
        foreach( $ginfo as $item){
            $document = new Apache_Solr_Document();
            $document->id= $item['id'];
            $document->name= $item['name'];
            $document->addr= $item['addr'];
            $document->phone= $item['phone'];
            $document->tag= $item['tag'];
            $document->photo= ($item['photo']);
            $document->channelId= 2;
            $documents[] = $document;
            if($k<55){
                $k++;
            }else{
                $solr->addDocuments($documents);
                $solr->commit();
                $solr -> optimize(true);
                unset($documents);
                $k = 0;
            }
        }
    }

    function test(){
        $t = array(
            1=>
            '
            居民搬家| 空调移机| 公司搬家| 搬家搬场| 长途搬家搬运| 设备搬迁
            起重吊装| 小型搬家',

            2=>'

物业保洁| 开荒保洁| 高空清洗| 灯具清洗| 油烟机清洗| 地毯清洗
空调清洗| 沙发清洗| 地板打蜡| 石材翻新/养护| 玻璃清洗| 壁纸清洗
除虫除蚁| 空气净化| 家庭保洁
',
            3=>
            '
            钟点工| 保姆| 管家| 陪护| 月嫂| 育婴师/育儿嫂| 催乳师
            涉外家政
            ',
            4=>
            '
            手机回收| 电器回收| 家具回收| 办公用品回收| 数码回收| 电脑回收
            电子回收| 礼品回收| 金银回收| 奢侈品回收| 设备回收| 金属回收
            电池回收| 塑料回收| 玻璃回收| 废纸回收| 废橡胶回收|	建筑废料
            库存积压|	纺织皮革|	服装衣帽| 药品回收
            ',
            5=>
            '
            鲜花| 绿植盆栽| 园林/园艺| 仿真花| 卡通花
            ',
            6=>
            '
            跑腿服务| 蔬菜水果|	粮油副食 |	液化气/煤气| 煤炭|	桶装水
            医院挂号| 代排队| 派发传单| 机场接送| 专人专送
            ',
            7=>
            '
            洗衣店| 皮具养护| 衣物鞋包改制
            ',
            8=>
            '
            医院| 银行| 商场| 加油站| 家电卖场| 药店| 书店| 超市便利店
            自来水/电力营业厅| 金融机构| 邮局通讯| 工商税务| 火车票代售点
            飞机票代售点
            ',
            9=>
            '
            服务器维修| 笔记本维修| 台式电脑维修| 数据恢复| 网络维修
            ipad/平板电脑维修
            ',
            10=>
            '
            电视维修| 冰箱维修| 空调维修| 洗衣机维修| 厨房家电维修| 影音家电维修
            小家电维修| 热水器维修
            ',
            11=>
            '
            数码相机维修| 摄像机维修| 单反相机/单反配件| 单电/微单相机| 游戏机
            数码相框| 录音设备| 导航仪维修
            ',
            12=>
            '
            苹果手机维修| 三星手机维修| 诺基亚手机维修| 摩托罗拉手机维修| 联想手机维修| HTC手机维修| 小米手机维修| 华为手机维修| 中兴手机维修
            酷派手机维修| 天语手机维修| 金立手机维修
            ',
            13=>
            '
            卫浴/洁具维修| 灯具维修/安装| 防水补漏| 电路维修/安装| 水管/水龙头维修
            打孔| 粉刷/防腐| 门窗维修/安装| 暖气水管维修/安装
            ',
            14=>
            '
            下水道疏通| 马桶疏通| 化粪池清理| 工业管道安装／改造| 打捞
            市政管道清淤| 隔油池维修/清理
            ',
            15=>
            '
            沙发维修护理| 桌椅柜维修| 地板维修| 办公家具维修| 钟表维修
            ',
            16=>
            '
            墓地| 殡葬用品| 殡葬服务
            ',
            17=>
            '');
            $sql='';
            foreach($t as $k =>$i){
                    $tmp = explode('|',str_replace("\t",'',str_replace("\r\n","|",trim($i))));
                    $aa = array();
                    foreach($tmp as $v){
                        $sql .= "insert into home_category (`channel_id`,`parent_id`,`name`)values (7,".$k.",'".trim($v)."');\r\n";
                    }
            }

        file_put_contents('homeC.txt',$sql);
        var_dump($sql);
        exit;

        $b_channels=array(1=>'搬家',2=>'保洁清洗',3=>'保姆/月嫂',4=>'二手回收',5=>'鲜花绿植',
            6=>'生活配送',7=>'洗衣店/皮具养护',8=>'公共服务',9=>'电脑维修',10=>'家电维修',
            11=>'数码维修',12=>'手机维修',13=>'房屋维修/防水',
            14=>'管道疏通',15=>'家具维修',16=>'殡葬',17=>'开锁/换锁/修锁');

        foreach($b_channels as $kk){
            $sql .= "insert into home_category (`channel_id`,`parent_id`,`name`)values (7,0,'".$kk."');\r\n";
        }
        //file_put_contents('homeC.txt',$sql);
        var_dump($sql);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */