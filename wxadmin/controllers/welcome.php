<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
       
		$this->load->helper('url');
		//$this->load->library('tank_auth');
		$this->load->model('welcome_model','welcome');
        $this->load->model('common_model','common');
	} 
    
    function showpage(){
        $this->load->view('service/index');
    }
	function index()
	{
		//判断是否登录
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$this->load->view('welcome', $data);
		}
	}
	
	function getinfo(){
		$rels = $this->welcome->getinfo();
		var_dump($rels);
		
	}
	
	function show(){
	    $data = array(1,2,3,4,5);
		$this->load->view('index.html');
	}
    
    function showfor(){
        $data = 'lll';//array(1,2,3,4,5);
        $this->load->view('default/index', $data,true);
        
    }
    
    function addType(){
        $this->load->library('Pinyin');
        $py = new Pinyin();
        $link = mysql_connect('localhost','root','');
        if (!$link) {
            die('Could not connect to MySQL: ' . mysql_error());
        }
        mysql_query("set names utf8");
        mysql_select_db("test");
        $mysql = "SELECT * FROM base_info ";
        $result = mysql_query($mysql ,$link);
        $tempSql = '';
        while($row=mysql_fetch_array($result)){
            $pyValue = $py->convert($row['name']);
            $ls = $py->mb_strrev($row['name']);
            $temp_str = '';
            foreach($ls as $item){
               $temp_str .= strtoupper(mb_substr($py->convert($item), 0, 1));
            }
            $tempSql .= "update base_info set `jianpin`= '{$temp_str}', `quanpin`='{$pyValue}' where id='{$row['id']}';\r\n";
        }
        file_put_contents('py_base_shopping.sql', $tempSql, FILE_APPEND);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */