<?php
class DK_Cookie
{
    // 判断Cookie是否存在
	static function is_set($name)
	{
		$config = get_config_v2c('cookie');
		var_dump($config);exit;
        return isset($_COOKIE[$config['prefix'].$name]);
    }

    // 获取某个Cookie值
	static function get($name)
	{
		$config = get_config_v2c('cookie');

        $value   = $_COOKIE[$config['prefix'].$name];
        $value   =  unserialize(base64_decode($value));
        return $value;
    }

    // 设置某个Cookie值
	static function set($name,$value,$expire='',$path='',$domain='')
	{
		$config = get_config_v2c('cookie');

        if($expire=='') {
            $expire =   $config['expire'];
        }
        if(empty($path)) {
            $path = $config['path'];
        }
        if(empty($domain)) {
            $domain =   $config['domain'];
        }

        $expire =   !empty($expire)?    $expire   :  0;
        $value   =  base64_encode(serialize($value));
        setcookie($config['prefix'].$name, $value,$expire,$path,$domain);
        $_COOKIE[$config['prefix'].$name]  =   $value;
    }

    // 删除某个Cookie值
	static function delete($name)
	{
		$config = get_config_v2c('cookie');

        DK_Cookie::set($name,'',-3600);
        unset($_COOKIE[$config['prefix'].$name]);
    }

    // 清空Cookie值
	static function clear()
	{
        unset($_COOKIE);
    }
}
