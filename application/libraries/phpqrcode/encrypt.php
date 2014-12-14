<?php

class MD5Crypt {
	
	/**
	* Enter description here ...
	* @param unknown_type $str
	* @return string
	*/
	public final static function mdsha($str) {
		$code = substr ( md5 ( $str ), 10 );
		$code .= substr ( sha1 ( $str ), 0, 28 );
		$code .= substr ( md5 ( $str ), 0, 22 );
		$code .= substr ( sha1 ( $str ), 16 ) . md5 ( $str );
		return self::chkToken () ? $code : null;
	}
	
	/**
	* Enter description here ...
	* @param unknown_type $param
	*/
	private final static function chkToken() {
		return true;
	}
	
	/**
	* Enter description here ...
	* @param unknown_type $txt
	* @param unknown_type $encrypt_key
	* @return Ambigous <string, boolean>
	*/
	private final static function keyED($txt, $encrypt_key) {
		$encrypt_key = md5 ( $encrypt_key );
		$ctr = 0;
		$tmp = "";
		for($i = 0; $i < strlen ( $txt ); $i ++) {
			if ($ctr == strlen ( $encrypt_key ))
			$ctr = 0;
			$tmp .= substr ( $txt, $i, 1 ) ^ substr ( $encrypt_key, $ctr, 1 );
			$ctr ++;
		}
		return $tmp;
	}
	
	/**
	* Enter description here ...
	* @param unknown_type $txt
	* @param unknown_type $key
	* @return string
	*/
	public final static function Encrypt($txt, $key) {
		srand ( ( double ) microtime () * 1000000 );
		$encrypt_key = md5 ( rand ( 0, 32000 ) );
		$ctr = 0;
		$tmp = "";
		for($i = 0; $i < strlen ( $txt ); $i ++) {
				if ($ctr == strlen ( $encrypt_key ))
				$ctr = 0;
				$tmp .= substr ( $encrypt_key, $ctr, 1 ) . (substr ( $txt, $i, 1 ) ^ substr ( $encrypt_key, $ctr, 1 ));
				$ctr ++;
			}
		$_code = md5 ( $encrypt_key ) . base64_encode ( self::keyED ( $tmp, $key ) ) . md5 ( $encrypt_key . $key );
		return self::chkToken () ? $_code : null;
		}
	
	/**
	* Enter description here ...
	* @param unknown_type $txt
	* @param unknown_type $key
	* @return Ambigous <string, boolean>
	*/
	public final static function Decrypt($txt, $key) {
		$txt = self::keyED ( base64_decode ( substr ( $txt, 32, - 32 ) ), $key );
		$tmp = "";
		for($i = 0; $i < strlen ( $txt ); $i ++) {
			$md5 = substr ( $txt, $i, 1 );
			$i ++;
			$tmp .= (substr ( $txt, $i, 1 ) ^ $md5);
		}
		return self::chkToken () ? $tmp : null;
	}
	
	/**
	* Enter description here ...
	* @var unknown_type
	*/
	private static $_key = 'lau';
} 
?>


<?php //Code Start
define ( 'WORKSPACE', '.' . DIRECTORY_SEPARATOR );
header ( "Content-Type: text/html; charset=utf-8" );
include_once 'Core/Library/MD5Crypt.class.php';
$a = MD5Crypt::Encrypt ( "A", 100 );
echo "EnCode:" . $a, "<br />";
echo "DeCode:" . MD5Crypt::Decrypt ( $a, 100 );
?> 


<?php
	// $string： 明文 或 密文
// $operation：DECODE表示解密,其它表示加密
// $key： 密匙
// $expiry：密文有效期
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
    $ckey_length = 4;
    
    // 密匙
    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);
    
    // 密匙a会参与加解密
    $keya = md5(substr($key, 0, 16));
    // 密匙b会用来做数据完整性验证
    $keyb = md5(substr($key, 16, 16));
    // 密匙c用于变化生成的密文
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    // 参与运算的密匙
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    // 产生密匙簿
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    // 核心加解密部分
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        // 从密匙簿得出密匙进行异或，再转成字符
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        // substr($result, 0, 10) == 0 验证数据有效性
        // substr($result, 0, 10) - time() > 0 验证数据有效性
        // substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
        // 验证数据有效性，请看未加密明文的格式
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    }
}
?>
