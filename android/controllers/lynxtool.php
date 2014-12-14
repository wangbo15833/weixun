<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-4-1
 * Time: 上午9:44
 * To change this template use File | Settings | File Templates.
 */

class Lynxtool extends CI_Controller {
    function __construct(){
        parent :: __construct();
        $this->load->model("district_model","mdistrict");
        $this->load->model("promotion_model","mpromotion");
    }
    function districtAdd(){
        $data['dname']=$this->input->get_post('dname');
        $data['did']=$this->input->get_post('did');
        $data['parentid']=$this->input->get_post('parentid');
        $result=$this->mdistrict->districtAdd($data);
        echo json_encode(array('status'=>1));
    }

    function getPromotion(){
        $promotions=$this->mpromotion->getPromotionByLimit();
        print_r($promotions);
    }
}