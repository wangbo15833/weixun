<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-4-1
 * Time: 上午11:43
 * To change this template use File | Settings | File Templates.
 */

class District extends  MY_Controller{

    function __construct(){
        parent :: __construct();
        $this->load->model('district_model','mdistrict');
    }

    function getDistrictByPid(){
        $pid = $this->input->get_post('param_id');
        $districts=$this->mdistrict->getDistrictByPid($pid);
        echo json_encode(array('status'=>1,'data'=>$districts));

    }
}