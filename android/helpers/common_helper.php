<?php
	/**
	 * @desc 通用辅助函数
	 * @author gefc
	 * @date 20130410
	 * */
	 
	function passport_encrypt($txt, $key) {
		srand((double)microtime() * 1000000);
		$encrypt_key = md5(rand(0, 32000));
		$ctr = 0;
		$tmp = '';
		for($i = 0;$i < strlen($txt); $i++) {
			$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
			$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
		}
		return base64_encode(passport_key($tmp, $key));
	}

	function passport_decrypt($txt, $key) {
		$txt = passport_key(base64_decode($txt), $key);
		$tmp = '';
		for($i = 0;$i < strlen($txt); $i++) {
			$md5 = $txt[$i];
			$tmp .= $txt[++$i] ^ $md5;
		}
		return $tmp;
	}

	function passport_key($txt, $encrypt_key) {
		$encrypt_key = md5($encrypt_key);
		$ctr = 0;
		$tmp = '';
		for($i = 0; $i < strlen($txt); $i++) {
			$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
			$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
		}
		return $tmp;
	}

	function get_uuid() {
		$chars = md5(uniqid(mt_rand(), true));
		$uuid = substr($chars, 0, 8) . '-';
		$uuid .= substr($chars, 8, 4) . '-';
		$uuid .= substr($chars, 12, 4) . '-';
		$uuid .= substr($chars, 16, 4) . '-';
		$uuid .= substr($chars, 20, 16);
		return $uuid;
	}
	
	/**
	 * @author  wangying
	 * 参数解释 :  视频模块用到的加密解密方法
	 * $string： 明文 或 密文   
	 * $operation：DECODE表示解密,其它表示加密   
	 * $key： 密匙   
	 * $expiry：密文有效期
	 */
	function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0 )
	{
		$ckey_length = 4;
		$key = md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey); 
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) 
							: sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
	
		$result = '';
		$box = range(0, 255);
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}  
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}  
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
	
		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) 
			&& substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
	
	/**
	 * @author vicente
	 * 字符串加密、解密函数
	 * @param	string	$txt		字符串
	 * @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
	 * @param	string	$key		密钥：数字、字母、下划线
	 * @return	string
	 */
	function sysAuthCode($txt, $operation = 'ENCODE', $key = '!@#$%^&*1QAZ2WSX') {
	    $key = $key ? $key : 'HZYEYAOMAI2011';
	    $txt = $operation == 'ENCODE' ? (string) $txt : base64_decode(str_replace(array('*', '-', '.'), array('+', '/', '='), $txt));
	    $len = strlen($key);
	    $code = '';
	    for ($i = 0; $i < strlen($txt); $i++) {
	        $k = $i % $len;
	        $code .= $txt[$i] ^ $key[$k];
	    }
	    $code = $operation == 'DECODE' ? $code : str_replace(array('+', '/', '='), array('*', '-', '.'), base64_encode($code));
	    return $code;
	}
	
	/**
	 * 友好的时间显示
	 *
	 * @param int    $sTime 待显示的时间
	 * @param string $type  类型. mohu | full | ymd | other
	 * @return string
	 */
	function friendlyDate($sTime, $type = 'mohu')
	{
	    //sTime=源时间，cTime=当前时间，dTime=时间差
	    $cTime = time();
	    $todayTime = mktime('0', '0', '0', date('m'), date('d'), date('Y'));
	    $yestodayTime = mktime('0', '0', '0', date('m'), date('d') - 1, date('Y'));
	    $tommrrowTime = mktime('0', '0', '0', date('m'), date('d') + 1, date('Y'));
	    $weekTime = $todayTime - date('w', $cTime) * 86400;
	    $dTime = $cTime - $sTime;
	
	    if ($type == 'mohu') {
	        if ($dTime < 10) {
	            return '刚刚';
	        }
	        if (10 <= $dTime && $dTime < 60) {
	            return (ceil($dTime) + 0) . " 秒前";
	        } elseif ($dTime < 3600) {
	            return intval($dTime / 60) . " 分钟前";
	        }
	        //时间在今天0点到明天0点之间
	        elseif ($sTime < $tommrrowTime && $sTime > $todayTime) {
	            $h = intval($dTime / 3600);
	            if (ceil($dTime % 3600 / 60) > 30) {
	                $h++;
	            }
	            if ($h >= 3) {
	                return "今天  " . date('H:i', intval($sTime));
	            }
	            return $h . " 小时前";
	        }
	        //时间在本周0点到今天0点之间
	        elseif ($sTime < $todayTime && $sTime > $weekTime) {
	            //时间在今天0点到昨天0点之间
	            if ($sTime > $yestodayTime && $sTime < $todayTime) {
	                return "昨天 " . date('H:i', intval($sTime));
	            }
	            //时间在前天0点到昨天0点之间
	            elseif ($sTime > ($yestodayTime - 86400) && $sTime < $yestodayTime) {
	                return "前天 " . date('H:i', intval($sTime));
	            }
	            //其他
	            else {
	                return date("Y年n月j日H:i", intval($sTime));
	            }
	        } else {
	            return date("Y年n月j日H:i", intval($sTime));
	        }
	    } elseif ($type == 'full') {
	        return date("Y-m-d , H:i:s", intval($sTime));
	    } elseif ($type == 'ymd') {
	        return date("Y-m-d", intval($sTime));
	    } else {
	        return date("Y-m-d H:i:s", intval($sTime));
	    }
	}
	
	/**截取中文字符串，超过长度用....代替
	 * @param string $string
	 * @param int $from
	 * @param int $len
	 * @param string $dot
	 * @return mixed|string
	 */
	function utf8substr($string = '', $from = 0, $len = 0, $dot = '...')
	{
	    if (empty($string)) {
	        return $string;
	    }
	    $str_mode = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' 
	    				. '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s';
	    $substr = preg_replace($str_mode, '$1', $string);
	    if (mb_strlen($substr, 'UTF8') < mb_strlen($string, 'UTF8')) {
	        $substr .= $dot;
	    }
	    return $substr;
	}
    
     function get_post($value='')
    {
        $ci = &get_instance();
        return $ci->input->get_post($value);
    }
	
	
?>
