<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-3-20
 * Time: 下午3:40
 * To change this template use File | Settings | File Templates.
 */
class Uploadtest extends MY_Controller {
    function __construct() {
        parent :: __construct();

    }

    function index(){
        $this->load->view("uploadtest");
    }
}