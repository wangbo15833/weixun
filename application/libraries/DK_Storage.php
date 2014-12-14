<?php
/**
 * 文件存储类
 * 实现文件存储的统一操作
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/26>
 *
 */
class DK_Storage
{
	private static $instance = array();

	private $fdfs = null;

	private $options;

	protected $tracker;//type:array 客户端连接跟踪器(tracker)返回的tracker服务端相关信息
	protected $storage;//type:array 客户端连接存储节点(storage)返回的storage服务端相关信息
	protected $group;

	public function __construct($config)
	{
		if (!extension_loaded('fastdfs_client')) die('系统未安装FastDFS-PHP扩展!');

		$this->options = get_config_v2c('fastdfs_'.$config);
		$this->group = $this->options['group'];
		$this->fdfs = new FastDFS();
		$res = $this->fdfs->connect_server($this->options['host'],$this->options['port']);
		if ($res){
			$this->tracker = $res;
		}else{
			$this->tracker = $this->fdfs->tracker_get_connection();
		}

		$this->storage = $this->fdfs->tracker_query_storage_store($this->group, $this->tracker);
	}

	/**
	 * 获取存储类的实例
	 * @param $host 存储服务器的IP地址
	 * @param $port 存储服务器的端口
	 * @param $group 存储服务器的分组
	 */
	public static function getInstance($name)
	{
		if(!isset(self::$instance[$name]))
		{
			self::$instance[$name] = new DK_Storage($name);
		}
		return self::$instance[$name];
	}

	/**
	 * 上传文件
	 * @param string $local_filename 本地文件名
	 * @param string $file_ext 文件扩展名,不包括(.)符号
	 * @param array  $meta 文件元数据
	 * @return array|string 成功返回文件信息数组,失败返回错误信息
	 */
	public function uploadFile($local_filename,$file_ext = null, $meta = array())
	{
		$file_info = $this->fdfs->storage_upload_by_filename($local_filename,$file_ext,$meta,$this->group,$this->tracker);
		if(is_array($file_info))
		{
			return $file_info;
		}
		return $this->fdfs->get_last_error_info();
	}
	/**
	 * 上传文件
	 * @author wangying
	 * @param	string $local_filename  (必要的)文件存放位置(若文件为完整文件名+后缀的形式，$file_ext可以为空)
	 * @param	string $group_name	文件组名
	 * @param	array  $file_ext	文件的后缀名,不包含点'.'
	 * @param	array  $meta		文件的附加信息,数组格式,array('hight'=>'350px','author'=>'bobo');
	 * @return	string				返回file_id(文件组名/文件名)
	 */
	public function uploadFile1($local_filename, $group_name = null,$file_ext = null, $meta = array())
	{
		$bool = $this->check_string($local_filename);
		if(!$bool)  return false;
		$file_id = $this->fdfs->storage_upload_by_filename1($local_filename,$file_ext,$meta,$group_name,$this->tracker);
		if($file_id){
			return  $file_id;
		}else{
			return $this->fdfs->get_last_error_info();
		}
	}
	/**
	 * 上传文件,通过文件流
	 * @param string $file_buff	文件流
	 * @param string $file_ext	文件扩展名,不包括(.)符号
	 * @param array  $meta		文件元数据
	 * @return array|string		成功返回文件信息数组,失败返回错误信息
	 */
	public function uploadFileByBuff($file_buff,$file_ext = null, $meta = array())
	{
		$file_info = $this->fdfs->storage_upload_by_filebuff($file_buff,$file_ext,$meta,$this->group,$this->tracker);
		if(is_array($file_info))
		{
			return $file_info;
		}
		return $this->fdfs->get_last_error_info();
	}

	/**
	 * 上传从属文件
	 * @param string $local_filename	本地文件名
	 * @param string $master_filename	主文件名
	 * @param string $prefix	从文件后缀
	 * @param string $file_ext	文件扩展名
	 * @param array meta 文件元数据
	 *
	 * @return array|string 成功返回文件信息数组,失败返回错误信息
	 */
	public function uploadSlaveFile($local_filename,$master_filename,$prefix,$file_ext = null, $meta = array(), $group_name = '')
	{
		if (empty($group_name)) {
			$group_name = $this->group;
		}
		if(empty($local_filename) || empty($master_filename) || empty($prefix)) {
			return false;
		}
		$res = $this->fdfs->storage_upload_slave_by_filename($local_filename, $group_name, $master_filename, $prefix, $file_ext, $meta, $this->tracker);
		if($res){
			return $res;
		}else{
		 $error = $this->fdfs->get_last_error_info();
		 return $error;
			// log
		 // return false;
		}
	}
	/**
	 * 上传从文件
	 * @author wangying
	 * @param	$local_filename  从文件名
	 * @param	$masterfile_id   主文件file_id
	 * @param	$prefix		  从文件的标识符; 例如,主文件为abc.jpg,从文件需要大图,添加'_b',则$prefixname = '_b',生成从文件为abc_b.jpg;
	 * @param	$file_ext		从文件后缀名
	 * @param	$meta			文件的附加信息,数组格式,array('hight'=>'350px','author'=>'bobo');
	 * @return	string		  返回file_id(文件组名/文件名)
	 */
	public function uploadSlaveFile1($local_filename,$masterfile_id,$prefix,$file_ext=null,$meta=array())
	{
		$bool = $this->check_string($local_filename,$masterfile_id,$prefix);
		if(!$bool)  return false;
		$file_id = $this->fdfs->storage_upload_slave_by_filename1($local_filename,$masterfile_id,$prefix,$file_ext,$meta,$this->tracker);
		if($file_id){
			return $file_id;
		}else{
			return $this->fdfs->get_last_error_info();
		}
	}
	/**
	 * 上传从属文件,通过文件流
	 * @param string $master_filename 主文件名
	 * @param string $prefix 从文件后缀
	 * @param string $file_ext 文件扩展名
	 * @param array meta 文件元数据
	 *
	 * @return array|string 成功返回文件信息数组,失败返回错误信息
	 */
	public function uploadSlaveFileByBuff($file_buff,$master_filename,$prefix,$file_ext = null, $meta = array(), $group_name = '')
	{
		if (empty($group_name)) {
			$group_name = $this->group;
		}
		$file_info = $this->fdfs->storage_upload_slave_by_filebuff($file_buff,$group_name,$master_filename,$prefix,$file_ext,$meta,$this->tracker);
		if(is_array($file_info))
		{
			return $file_info;
		}
		return $this->fdfs->get_last_error_info();
	}

	/**
	 * 获取FastDFS中可访问的URL路径
	 *
	 * @param string $filename 文件名
	 * @param string $group 组名
	 * @param string $prefix 从文件后缀
	 */
	public function get_file_url($filename, $group = '',$prefix='')
	{
		if (empty($filename))
		return false;

		if (empty ($group)) {
			$group = $this->options['group'];
		}
		if(!empty($prefix)){
			$filename = $this->getSlaveFilename($filename,$prefix);
		}

		return 'http://' . config_item('fastdfs_domain'). '/' . $group . '/' . $filename . '?v=' . time();
	}

	/**
	 * 下载文件
	 * @param string $remote_filename 远程文件名
	 * @param string $local_filename 本地文件名
	 * @param string $prefix 从文件后缀
	 *
	 * @return bool 成功返回true失败返回false
	 */
	public function downloadFile($remote_filename,$local_filename = null, $group_name = '',$prefix='')
	{
		if (empty($group_name)) {
			$group_name = $this->group;
		}

		$remote_filename = $this->getSlaveFilename($remote_filename,$prefix);

		$res = $this->fdfs->storage_download_file_to_file($group_name,$remote_filename,$local_filename,0,0,$this->tracker);
		if ($res) {
			return $res;
		} else {
			return 'Error NO: '. fastdfs_get_last_error_no() . ', Error Info: ' . fastdfs_get_last_error_info();
		}
	}

	/**
	 * 下载文件到本地服务器
	 * @author wangying
	 * @param	string $file_id	文件id
	 * @param	string $local_filename		本地文件名
	 * @param	string prefix		从文件的标识符
	 * @param	string $file_ext	文件后缀名(这个后缀名替换掉原有文件后缀名)
	 * @param	$file_offset		//file start offset, default value is 0
	 * @param	$download_bytes	 //0 (default value) means from the file offset to the file end
	 * @return	bool	成功返回true,失败返回false
	 */
	public function downloadFile1($file_id,$local_filename,$prefix=null,$file_ext=null,$file_offset=0,$download_bytes=0)
	{
		$bool = $this->check_string($file_id,$local_filename);
		if(!$bool)  return false;
		if($prefix) {
			$file_id = $this->get_slave_filename($file_id,$prefix,$file_ext);
		}
		$bool = $this->fdfs->storage_download_file_to_file1($file_id, $local_filename,$file_offset,$download_bytes, $this->tracker);
		if($bool){
			return true;
		}else{
			return $this->fdfs->get_last_error_info();
		}
	}
	/**
	 * 下载文件到文件流
	 * @param string $remote_filename 远程文件名
	 *
	 * @param string $prefix 从文件后缀
	 *
	 * @return string|false 成功返回文件流,失败返回false
	 */
	public function downloadFileBuff($remote_filename, $group_name = '',$prefix='')
	{
		if (empty($group_name)) {
			$group_name = $this->group;
		}

		$remote_filename = $this->getSlaveFilename($remote_filename,$prefix);

		$buff = $this->fdfs->storage_download_file_to_buff($group_name,$remote_filename,0,0,$this->tracker);
		if($buff !== false)
		{
			return $buff;
		} else {
			return 'Error NO: '. fastdfs_get_last_error_no() . ', Error Info: ' . fastdfs_get_last_error_info();
		}
	}

	/**
	 * 判断文件是否存在
	 *
	 * @param	$group		文件组名
	 * @param	$name		文件名
	 *
	 * @return	bool		文件存在返回true,不存在返回false;
	 */
	function file_exist($group = null, $name = null)
	{
		if(empty($name)) return false;
		if(empty($group)) $group = $this->group;

		$res = $this->fdfs->storage_file_exist($group, $name, $this->tracker);
		if($res) {
			return $res;
		}
		return false;
	}

	/**
	 * 判断文件是否存在
	 * @author  wangying
	 * @param	string $file_id	文件id
	 * @param	string $prefix		从文件的标识符
	 * @param	string $file_ext	文件后缀名(这个后缀名替换掉原有文件后缀名)
	 * @return	Bool	文件存在返回true,不存在返回false;
	 */
	public function fileExist1($file_id,$prefix=null,$file_ext=null)
	{
		$bool = $this->check_string($file_id);
		if(!$bool)  return false;
		if($prefix) $file_id = $this->get_slave_filename($file_id,$prefix,$file_ext);
		$bool = $this->fdfs->storage_file_exist1($file_id,$this->tracker);
		if($bool){
			return true;
		}else{
			//return $this->fdfs->get_last_error_info();
			return false;
		}
	}

	/**
	 * 删除上传的文件
	 * @param string $filename 远程文件名
	 * @param string $prefix 从文件后缀
	 * @return bool 成功返回true失败返回false
	 *
	 */
	public function deleteFile($group = null, $filename,$prefix='')
	{
		if(empty($filename)) return false;
		if(empty($group)) $group = $this->group;

		if(!empty($prefix)){
			$filename = $this->getSlaveFilename($filename,$prefix);
		}
		$res = $this->fdfs->storage_delete_file($group, $filename, $this->tracker);
		if($res) {
			return $res;
		} else {
			// $error = $this->fdfs->get_last_error_info();
			// log
			return false;
		}
	}

	/**
	 * 删除文件
	 * @author wangying
	 * @param	$file_id	文件id
	 * @param	$prefix		从文件的标识符
	 * @param	$file_ext	文件后缀名(这个后缀名替换掉原有文件后缀名)
	 * @return  bool		成功返回true,失败返回false;
	 */
	public function deleteFile1($file_id,$prefix=null,$file_ext=null)
	{
		$bool = $this->check_string($file_id);
		if(!$bool)  return false;
		if($prefix) $file_id = $this->get_slave_filename($file_id,$prefix,$file_ext);
		$bool = $this->fdfs->storage_delete_file1($file_id, $this->tracker);
		if($bool){
			return true;
		}else{
			 return $this->fdfs->get_last_error_info();
		}
	}

	/**
	 * 根据扩展后缀获取从文件名
	 */
	protected function getSlaveFilename($filename,$prefix='')
	{
		if(!empty($prefix))
		{
			$ext = '.' . strtolower(pathinfo($filename,PATHINFO_EXTENSION));
			$slave = $prefix . $ext;
			$filename = str_replace($ext, $slave, $filename);
		}

		return $filename;
	}

	/**
	 * 根据扩展后缀获取从文件名(masterfile或file_id 两种形式)
	 * @author  wangying
	 * @param	string $filename	主文件名(masterfile或file_id 两种形式)
	 * @param	string $prefix	(必要的)从文件的标识符
	 * @param	string $file_ext	文件后缀名(这个后缀名替换掉原有文件后缀名)
	 * @return	string
	 */
    public function get_slave_filename($filename,$prefix,$file_ext=null)
	{
		$bool = $this->check_string($filename,$prefix);
		if(!$bool)  return false;
		if(!$file_ext) $file_ext=null;
        $filename = $this->fdfs->gen_slave_filename($filename,$prefix,$file_ext);
        if($filename){
            return $filename;
        }else{
            return $this->fdfs->get_last_error_info();
        }
    }

	/**
	 * 判断是否是有值的字符串
	 * @param	 array $arr_str
	 * @return	bool
	 */
	 public function check_string()
	 {
		$arr_str = func_get_args();
		foreach ($arr_str as $value)
		{
			if(empty($value))
			{
				return false;
			}
		}
		return true;
	 }

	function __destruct()
	{
		$this->fdfs->disconnect_server($this->tracker);
	}
}
