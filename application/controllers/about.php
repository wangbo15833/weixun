<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-10-8
 * Time: 下午2:48
 * To change this template use File | Settings | File Templates.
 */

class About extends MY_Controller {

    function __construct(){
        parent :: __construct();
    }

    function question(){
        $this->load->view('meituan/about_question');
    }

    function common(){
        $this->load->view('meituan/about_common');
    }

    function law(){
        $this->load->view('meituan/about_law');
    }

    function pact(){
        $this->load->view('meituan/about_pact');
    }

    function assured(){
        $this->load->view('meituan/about_assured');
    }

    function teamwork(){
        $this->load->view('meituan/about_teamwork');
    }

    function abouts(){
        $this->load->view('meituan/about_about');
    }

    function commit(){
        $this->load->view('meituan/about_commit');
    }
    function lisence(){
        $this->load->view('meituan/about_lisence');
    }

    function user_pact(){
        $this->load->view('default/about_user_pact');
    }
}