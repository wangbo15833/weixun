<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-27
 * Time: 下午2:36
 * To change this template use File | Settings | File Templates.
 */
       // parent :: __construct();
    include_once '/Phpqrcode_lib';
    include_once 'File_util';
    function index(){
        $PNG_TEMP_DIR = FWPHP_PATH.CODE_PATH;
        //var_dump($PNG_TEMP_DIR);exit;
        $PNG_WEB_DIR = WEB_ROOT . WEB_CODE_PATH;
        if (!file_exists($PNG_TEMP_DIR))
            mkdir($PNG_TEMP_DIR);
        //include_once 'helpers.php';
        $key = 'good';
        $data = "http://www.google.com.hk";
        //$data = authcode($data,'ENCODE');//passport_encrypt($data, $key);
       // $data = authcode($data, 'DECODE');
        $filename = $PNG_TEMP_DIR.'test.png';
        $errorCorrectionLevel = "M";
        $matrixPointSize = "2";
        $margin ="0";
        $tmp = QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, $margin);

        echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';

        //echo memory_get_usage()."<br>";
        //echo memory_get_peak_usage()."<br>";
        //echo uniqid()."<br>";
        //echo microtime(true);
        self::showimg();
    }

    function showimg(){
        $file = new File_util();
        $time = date('Y/m/d',time());
        $fileUrl = FILEBASE.$time;
        if(!file_exists($fileUrl))
            $file->createDir($fileUrl);

        $PNG_TEMP_DIR = FWPHP_PATH.CODE_PATH.$time;
        $PNG_WEB_DIR = WEB_ROOT . WEB_CODE_PATH.$time.'/';

        $PNG_TEMP_DIR_T = WEB_ROOT . WEB_CODE_PATH. 'temp/';
        // var_dump($PNG_TEMP_DIR_T.'xiao.gif');exit;
        $get_uuid = get_uuid();
        $filename = $PNG_TEMP_DIR.'/'.$get_uuid.'.png';
        $output = $PNG_TEMP_DIR . '/'.$get_uuid.'.png';
        $value = $PNG_WEB_DIR.basename($output);//'1234567890';
        $errorCorrectionLevel ='Q';
        $matrixPointSize = 5;
        QRcode::png($value,$filename,$errorCorrectionLevel,$matrixPointSize);
        echo "QR code generated"."<br/>";
        $logo = $PNG_TEMP_DIR_T. 'xiao.gif';
        $QR = $filename;
        if($logo != FALSE){
            $QR = imagecreatefromstring(file_get_contents($QR));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);
            $QR_height = imagesx($QR);
            $logo_width = imagesx($logo);
            $logo_height = imagesx($logo);
            $logo_qr_width = $QR_width/5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width)/2;
            echo imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
        }
        imagepng($QR,$output);

        echo '<img src="'.$PNG_WEB_DIR.basename($output).'" /><hr/>';

    }
?>