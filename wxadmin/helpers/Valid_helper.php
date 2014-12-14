<?php
/**
 * 字符串验证系列方法
 *
 * @author xuwh 2012-11-01 迁移自helpers/validate_helper.php
 */

//namespace DK\Helper;

class Valid
{
	/**
	 * 检查输入的是否为数字
	 *
	 * @param string $val
	 * @return bool
	 */
	static function isNumber($val)
	{
		if (preg_match("/^[0-9]+$/", $val))
			return true;
		return false;
	}

	/**
	 * 检查输入的是否为电话
	 *
	 * @param string $val
	 * @return bool
	 */
	static function isPhone($val)
	{
		// eg: xxx-xxxxxxxx-xxx | xxxx-xxxxxxx-xxx ...
		if (preg_match("/^((0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/", $val))
			return true;
		return false;
	}

	/**
	 * 检查输入的是否为手机号
	 *
	 * @param string $val
	 * @return bool
	 */
	static function isMobile($val)
	{
	 	// 该表达式可以验证那些不小心把连接符“-”写出“－”的或者下划线“_”的等等
	 	//if (preg_match("/(^(\d{2,4}[-_－—]?)?\d{3,8}([-_－—]?\d{3,8})?([-_－—]?\d{1,7})?$)|(^0?1[35]\d{9}$/)", $val))
		
		if (preg_match("/^(13|15|18)[0-9]{9}$/",$val))
			return true;
		return false;
	}

	/*
	 * 检查输入的是否为邮编
	 *
	 * @param string $val
	 * @return bool
	 */
	static function isPostcode($val)
	{
		if (preg_match("/^[0-9]{4,6}$/", $val))
			return true;
		return false;
	}

	/*
	 * 邮箱地址合法性检查
	 *
	 * @param string $val
	 * @param string $domain
	 * @return bool
	 */
	static function isEmail($val, $domain=null)
	{
		if (!$domain) {
			if (preg_match("/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i", $val)) {
				return true;
			} else {
				return false;
			}
		} else {
			if (preg_match("/^[a-z0-9-_.]+@" . $domain . "$/i", $val)) {
				return true;
			} else {
				return false;
			}
		}
	}

	/*
	 * 姓名昵称合法性检查，只能输入中文英文
	 *
	 * @param string $val
	 * @return bool
	 */
	static function isName($val)
	{
		if (preg_match("/^[\x80-\xffa-zA-Z0-9]{3,60}$/", $val)) {
			return true;
		}

		return false;
	}

	/*
	 * 姓名昵称合法性检查，只能输入中文英文
	 *
	 * @param string $val
	 * @return bool
	 */
	static function isRealName($val)
	{
		if (preg_match("/^[\x80-\xffa-zA-Z]{3,10}$/", $val)) {
			return true;
		}

		return false;
	}

	/*
	 * 检查一个（英文）域名是否合法
	 *
	 * @param string $val
	 * @return bool
	 */
	static function isDomain($val)
	{
		if (preg_match("/^(https?:\/\/)?(((www\.)?[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)?\.([a-zA-Z]+))|(([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5]))(\:\d{0,4})?)(\/[\w- .\/?%&=]*)?$/i", $val)) {
			return true;
		}
		return false;
	}

	/*
	 * 检查数字字符串长度是否符合要求
	 *
	 * @param string $val
	 * @param int    $min 最小长度
	 * @param int    $max 最大长度
	 * @return bool
	 */
	static function isNumLength($val, $min, $max)
	{
		if (preg_match("/^[0-9]{" . $min . "," . $max . "}$/", $val)) {
			return true;
		}

		return false;
	}

	/*
	 * 检查字母字符串长度是否符合要求
	 *
	 * @param string $val
	 * @param int    $min 最小长度
	 * @param int    $max 最大长度
	 * @return bool
	 */
	static function isEngLength($val, $min, $max)
	{
		if (preg_match("/^[a-zA-Z]{" . $min . "," . $max . "}$/", $val)) {
			return true;
		}

		return false;
	}

	/*
	 * 检查输入是否为英文
	 *
	 * @param string $val
	 * @return bool
	 */
	static function isEnglish($val)
	{
		if (preg_match("/[\x80-\xff]./", $val)) {
			return false;
		}

		return true;
	}

	/*
	 * 检查是否输入为汉字
	 *
	 * @param string $sInBuf
	 * @return bool
	 */
	static function isChinese($sInBuf)
	{
		$iLen = strlen($sInBuf);
		for ($i = 0; $i < $iLen; $i++) {
			if (ord($sInBuf{$i}) >= 0x80) {
				if ((ord($sInBuf{$i}) >= 0x81 && ord($sInBuf{$i}) <= 0xFE) && ((ord($sInBuf{$i + 1}) >= 0x40 && ord($sInBuf{$i + 1}) < 0x7E) || (ord($sInBuf{$i + 1}) > 0x7E && ord($sInBuf{$i + 1}) <= 0xFE))) {
					if (ord($sInBuf{$i}) > 0xA0 && ord($sInBuf{$i}) < 0xAA) {
						// 有中文标点
						return false;
					}
				} else {
					// 有日文或其它文字
					return false;
				}
				$i++;
			} else {
				return false;
			}
		}
		return true;
	}

	/*
	 * 检查日期是否符合0000-00-00
	 *
	 * @param string $sDate
	 * @return bool
	 */
	static function isDate($sDate)
	{
		if (preg_match("/^[0-9]{4}\-[][0-9]{2}\-[0-9]{2}$/", $sDate)) {
			Return true;
		} else {
			Return false;
		}
	}

	/*
	 * 检查日期是否符合0000-00-00 00:00:00
	 *
	 * @param string $sTime
	 * @return bool
	 */
	static function isTime($sTime)
	{
		if (preg_match("/^[0-9]{4}\-[][0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $sTime)) {
			Return true;
		} else {
			Return false;
		}
	}

	/*
	 * 检查输入值是否为合法人民币格式
	 *
	 * @param string $val
	 * @return bool
	 */
	static function isMoney($val)
	{
		if (preg_match("/^[0-9]{1,}$/", $val)) {
			return true;
		}

		if (preg_match("/^[0-9]{1,}\.[0-9]{1,2}$/", $val)) {
			return true;
		}

		return false;
	}

	/*
	 * 检查输入IP是否符合要求
	 *
	 * @param string $val
	 * @return bool
	 */
	static function isIp($val)
	{
		return (bool)ip2long($val);
	}
    
    static function pwd_check($pwd1, $pwd2)
    {
        return $pwd1 === $pwd2 ? true : false;
    }
}
