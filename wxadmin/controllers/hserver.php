<?php
	class Hserver extends CI_Controller{
		function __construct(){
			parent :: __construct();
			$this->load->library('HessianPHP_lib');
		}

		function add($a, $b){
			return "This is a first hessianPHP!".$a."+".$b;
		}

		function index(){
			$server = new HessianService(new Hserver(), array('displayInfo' => true));
			$server -> handle();
		}
	}
?>