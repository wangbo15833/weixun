<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * 
     */
    class Index extends MY_Controller {
        
        function __construct() {
            parent :: __construct();
            $this->load->model('sysmenu_model','msysmenu');
            $this->load->model('area_model','marea');
        }
        
        public function index()
        {
            if (parent::is_login()) {
                $this->load->view("default/index");
            }
            else{
                redirect("login/index");
            }
        }

        function getMenu(){
            $ci = &get_instance();
            $ci->load->model('sysmenu_model','msysmenu');
            if(STATUS ==3) $is_state = 100;
            else if(STATUS == 2) $is_state = 10;
            else $is_state = 1;
            //var_dump($is_state);exit;
            $public_str = $ci->msysmenu->get_wdPublic($is_state);
            foreach($public_str as $i){
                $i['url'] = WEB_URL . $i['url'];
                // $i['url'] = WEB_URL . $i['url'];
                $newList[] = $i;
            }
            echo json_encode(array('public'=>$newList));
        }

        function getAreaList(){
            $areas= $this->marea->get_area_list();
            echo json_encode(array('status'=>1,'data'=>$areas));

        }

        function getAreaByid(){
            $param = get_post('param_id');
            $areas = $this->manager->get_district_id($param);
            echo json_encode(array('status'=>1,'data'=>$areas));
        }
    }
    
?>