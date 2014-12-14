<?php
header("Content-Type: text/html;charset=utf-8");
	//引入文件
	include "qrlib.php";
	
	$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
	$PNG_WEB_DIR = 'temp/';
	
	if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    include_once 'helpers.php';
    $key = 'good';
	$data = "http://www.google.com.hk";
	$data = authcode($data,'ENCODE');//passport_encrypt($data, $key);
	$data = authcode($data, 'DECODE');
	$filename = $PNG_TEMP_DIR.'test.png';
	$errorCorrectionLevel = "M";
	$matrixPointSize = "2";
	$margin ="0";
	$tmp = QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, $margin);
	
	echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';

?>