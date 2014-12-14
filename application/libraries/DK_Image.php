<?php
/**
 * 图片处理 接口 
 * 
 * @author heyuejan vicente
 * @since 2011-12-12 
 * @description 提供图片的转换、剪切、缩放功能，支持 gif、jpg、png格式
 * set_library()	// 设置使用的类库
 * getImageAttr()	// 获得图片属性
 * resize()			// 生成缩略图
 * crop()			// 图片裁剪
 * rotate()			// 旋转  图片
 * waterMark()		// 图片添加图片水印
 * textMark			// 图片加入文字
 * @version       $Id
 */
class DK_Image{
	
	//支持的类，imagick_class是php扩展方式，imagick是php调用shell方式
	var $library_arr	= array('gd', 'gd2', 'imagick', 'imagick_class', 'gmagick', 'gmagick_class'); 
	
	//GD2/ImageMagick/Gmagick
	var $image_library 	= 'imagick_class';
	
	//水印放置的位置  lt左上  rt右上  rb右下  lb左下
	var $position_arr 	= array('lt', 'rt', 'rb', 'lb');
	
	//表示本类支持处理图片的格式	1 gif  2 jpg  3 png
	var $image_format_arr 	= array('1','2','3');
		
	//imagick_class的配置
	var $magick_cmd_path	= "";
	var $magick_cmd_convert	= "convert";
	var $magick_cmd_composite= "composite";
	
	
	static $is_gd2 		        = null;
	static $is_imagick 	        = null;
	static $is_imagick_class	= null;
	static $is_gmagick	        = null;
	static $is_gmagick_class	= null;	
	
	private static $instance = null;
	
	// 获取对象 ;
	public static function getInstance($name)
	{
		if (empty($name)){
			throw new Exception('请输入初始化参数');
		}

        if (empty(self::$instance[$name]))
        {
            self::$instance[$name] = new DK_Image($name);
        }
        
        return self::$instance[$name];
	}
	
	/**
	 * 初始化
	 **/
	private function __construct($name) 
	{
		$config = get_config_v2c('image_'.$name);

		$this->init($config['image_library']);
		
		if(in_array($this->image_library, array('imagick', 'gmagick')))
		{
			if(!isset($config['cmd_path'])){
				throw new Exception('配置有误');
			}
			
			$this->magick_cmd_path = $config['cmd_path'];
		}
	}
	
	/**
	 * 测试
	 **/
	public function test()
	{
		return $this->image_library;
	}
	
	/**
	 * 初使化
	 **/
	private function init($image_library)
	{
		$this->set_library($image_library);
		
		//windows 要加.exe扩展名   
		if( strtoupper(substr(PHP_OS , 0 , 3)) === 'WIN'){
			$this->magick_cmd_convert = $this->magick_cmd_convert.'.exe';
		}
		
		if(self::$is_gd2===null){
			if(extension_loaded('gd')){
				self::$is_gd2 = true;
			}else{
				self::$is_gd2 = false;
			}
		}
		
		if(class_exists('Imagick')){
			self::$is_imagick = true;
			self::$is_imagick_class = true;
		}else{
			self::$is_imagick = false;
			self::$is_imagick_class = false;				
		}
		self::$is_gmagick = true;
		if(class_exists('Gmagick')){
			self::$is_gmagick_class = true;
		}else{
			//self::$is_gmagick = false;
			self::$is_gmagick_class = false;				
		}
	}

	/**
	 * 设置 使用的类库，默认是imagick_class
	 * @param string $image_library 指定使用的类库	//gd, gd2, imagick, imagick_class, gmagick, gmagick_class
	 **/
	public function set_library($image_library='')
	{
		if(in_array($image_library , $this->library_arr)){
			$this->image_library	= $image_library;
		}else{
			$this->image_library 	= 'imagick_class';
		}
	}
	
	/*******		全局方法，根据不同的库指向对应库的方法，此处只做中转		**********/
	
	/**
	 * 控制指定的fun，默认是imagick_class，imagick的PHP扩展方式
	 * @param  string  $fun		本类的基础fun
	 * @param  array   $args	传递的变量
	 * @return boolean
	 **/
	private function control($fun, $args)
	{
		// 类库或fun是否可用
		if(self::${'is_'.$this->image_library} && method_exists($this, $fun.'_'.$this->image_library)){	
			$run_act = $fun.'_'.$this->image_library;
		}else{
			if(self::$is_imagick_class && method_exists($this , $fun.'_imagick_class')){
				$run_act = $fun.'_imagick_class';
			}else{
				return false;
			}
		}

		
		return $this->$run_act($args);
	}
	
	/**
	 * 获得图片属性
	 * 
	 * @param string $src 原图片地址
	 * @return array | bool 路径不存在返回 false，存在返回 数组
	 * array('width'=>'宽','height'=>'高','type'=>'类型','size'=>'大小')
	 **/
	public function getImageAttr($src)
	{
		$args['src']	= $src;
		
		return $this->control('getImageAttr',$args);
	}
	
	/**
	 * 生成缩略图
	 * 
	 * @param   string      $src            原图片路径
	 * @param   string      $dst            缩略图保存路径
	 * @param   int         $thumb_width    缩略图高度
	 * @param   int         $thumb_height   缩略图高度
	 * @param   int         $quality        缩略图品质 100之内的正整数
	 * @return  boolean     成功返回 true    失败返回 false
	 **/
	public function resize($src, $dst, $thumb_width, $thumb_height , $quality = 85)
	{
	    $args['src']		= $src;
		$args['dst']		= $dst;
		$args['thumb_width']= $thumb_width;
		$args['thumb_height']= $thumb_height;
		$args['quality']	= $quality;
		
		return $this->control("resize", $args);
	}
	
	/**
	 * 图片缩放 (先等比例缩放，在从左上角截取)
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_h		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	public function resize_two($src, $dst, $dst_w, $dst_h, $quality=85, $src_x = 0, $src_y = 0)
	{
	    $args['src']		= $src;
		$args['dst']		= $dst;
		$args['src_x']		= $src_x;
		$args['src_y']		= $src_y;
		$args['dst_w']		= $dst_w;
		$args['dst_h']		= $dst_h;
		$args['quality']	= $quality;
		
		return $this->control("resize_two", $args);
	}
	
	/**
	 * 图片缩放 (先等比例缩放，在从左上角截取，宽高不大于设置的大小)
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_h		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @param   string  $abs_position   标准
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	public function resize_abs($src, $dst, $dst_w, $dst_h, $quality=85, $src_x = 0, $src_y = 0, $abs_position = 'x')
	{
	    $args['src']		= $src;
		$args['dst']		= $dst;
		$args['src_x']		= $src_x;
		$args['src_y']		= $src_y;
		$args['dst_w']		= $dst_w;
		$args['dst_h']		= $dst_h;
		$args['quality']	= $quality;
		$args['abs_position'] = in_array($abs_position, array('x', 'y')) ? $abs_position : 'x';
		
		return $this->control("resize_abs", $args);
	}
	
	/**
	 * 图片缩放 (先等比例缩放，在从左上角截取，宽等于默认值，高按比例随机)
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_h		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @param   string  $abs_position   标准
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	public function resize_water($src, $dst, $dst_w, $dst_h, $quality=85, $abs_position = 'x')
	{
	    $args['src']		= $src;
		$args['dst']		= $dst;
		$args['dst_w']		= $dst_w;
		$args['dst_h']		= $dst_h;
		$args['quality']	= $quality;
		$args['abs_position'] = in_array($abs_position, array('x', 'y')) ? $abs_position : 'x';
		
		return $this->control("resize_water", $args);
	}
	
	/**
	 * 图片等比缩放
	 * 
	 * @param   string    $src            原图片路径		加文件名
	 * @param   int       $dst            截取图保存路径  	加文件名
	 * @param   int       $dst_w		      截取图宽度
	 * @param   int       $dst_h		      截取图高度
	 * @param   int       $quality        截取图品质 100之内的正整数
	 * @return  boolean   成功返回 true 失败返回 false
	 **/
	public function resize_ratio($src, $dst, $dst_w, $dst_h, $quality=85, $src_x = 0, $src_y = 0)
	{
		$args['src']	= $src;
		$args['dst']	= $dst;
		$args['src_x']	= $src_x;
		$args['src_y']	= $src_y;
		$args['dst_w']	= $dst_w;
		$args['dst_h']	= $dst_h;
		$args['quality']= $quality;
		
		return $this->control("resize_ratio" , $args);
	}
	
	/**
	 * 图片裁剪
	 * 
	 * @param   string    $src            原图片路径		加文件名
	 * @param   string    $dst            截取图保存路径  	加文件名
	 * @param   int       $src_x		     从原图的 x 位置开始截取 x
	 * @param   int       $src_y		     从原图的 y 位置开始截取 y
	 * @param   int       $dst_w		     截取图宽度
	 * @param   int       $dst_y		     截取图高度
	 * @param   int       $quality        截取图品质 100之内的正整数
	 * @return  boolean   成功返回 true 失败返回 false
	 **/
	public function crop($src , $dst , $dst_w , $dst_h , $src_x , $src_y ,  $quality=85)
	{
		$args['src']	= $src;
		$args['dst']	= $dst;
		$args['src_x']	= $src_x;
		$args['src_y']	= $src_y;
		$args['dst_w']	= $dst_w;
		$args['dst_h']	= $dst_h;
		$args['quality']= $quality;
		
		return $this->control("crop" , $args);
	}
	
	/**
	 * 图片等比裁剪
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_y		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	public function crop_ratio($src, $dst, $dst_w, $dst_h, $quality=80, $src_x = 0, $src_y = 0){
		$args['src']	= $src;
		$args['dst']	= $dst;
		$args['src_x']	= $src_x;
		$args['src_y']	= $src_y;
		$args['dst_w']	= $dst_w;
		$args['dst_h']	= $dst_h;
		$args['quality']= $quality;
		
		return $this->control("crop_ratio" , $args);
	}

	/**
	 * 旋转图片
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst			截取图保存路径  	加文件名
	 * @param   int     $angle			旋转角度		逆时针转
	 * $param   int     quality			截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	public function rotate($src , $dst , $angle , $quality=85 )
	{
		$args['src']	= $src;
		$args['dst']	= $dst;
		$args['angle']	= $angle;
		$args['quality']= $quality;
		
		return $this->control('rotate', $args);
	}
	
	/**
	 * 图片添加图片水印
	 * 
	 * @param   string  $src		原图片路径		加文件名
	 * @param   string  $mark		水印图片路径  	加文件名
	 * @param   string  $dst		图保存路径  	加文件名
	 * @param   string | array  $position = 'rb' or array('width'=>20,'height'=>20)	水印图片放置的位置	lt左上  rt右上  rb右下  lb左下 其余取指定位置
	 * @param   int     $quality 	图片质量，仅对jpg有效 默认85 取值 0-100之间整数
	 * @param   int     $pct 		水印图片融合度(透明度)
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	public function waterMark($src , $mark , $dst , $position='rb' , $quality=85 , $pct=80 )
	{
		$args['src']	= $src;
		$args['mark']	= $mark;
		$args['dst']	= $dst;
		$args['position']	= $position;
		$args['quality']	= intval($quality);
		$args['pct']		= intval($pct);
		
		if(is_array($position)){
			if(! isset($position['width'])){
				 list($args['position']['width'] , $args['position']['height']) = $position;
			}
			$args['position']['width'] 	= @intval($args['position']['width']);
			$args['position']['height'] = @intval($args['position']['height']);
		}else{
			if(! in_array($position ,$this->position_arr) ){	
				prev( $this->position_arr);
				$args['position'] 	=current($this->position_arr);
			}
		}
		
		return $this->control('watermark' , $args );
	}
	
	/**
	 * 图片加入文字
	 * 
	 * @param   string  $src  	原图片路径		加文件名
	 * @param   string  $dst    保存图片的路径
	 * @param   string  $str 	加入的文字
	 * @param   string | array $position = 'rb' or array('width'=>20,'height'=>20)	水印图片放置的位置	lt左上  rt右上  rb右下  lb左下 其余取指定位置
	 * @param   string | array $color 字体颜色	可以是 十六进制的颜色值  #ffffff 或 ffffff  或  array('r'=>10,'g'=>10,'b'=>10)
	 * @param   string  $font_size		字体颜色
	 * @param   int 	$quality 图片的质量
	 * @param	int 	$pct	   透明度
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	public function textMark($src , $dst , $str , $position='rb' ,$font_size=12,$color='FFFFFF' , $quality = 85, $pct = 100)
	{
		$args['src']	= $src;
		$args['dst']	= $dst;
		$args['str']	= $str;
		$args['font_size']	= $font_size;
		$args['quality']	= $quality;
		$args['pct']		= $pct;
		$args['position']	= $position;
		
		// $position 数据验证
		if(is_array($position)){
			if(! isset($position['width'])){
				 list($args['position']['width'] , $args['position']['height']) = $position;
			}
			$args['position']['width'] 	= @intval($args['position']['width']);
			$args['position']['height'] = @intval($args['position']['height']);
		}else{
			if(! in_array($position ,$this->position_arr) ){	
				prev( $this->position_arr);
				$args['position'] 	=current($this->position_arr);
			}
		}
		
		// 颜色
		if(is_array($color)){
			if(! isset($color['r'])){
				list($args['color']['r'],$args['color']['g'],$args['color']['b'])	= $color;
			}
		}else{
			$args['color'] 	= $this->hex_rgb($color);
		}
		
		return $this->control('textmark', $args);
	}
	
	/**
	 * 转图片格式返回图片流
	 * @param   string  $src  	原图片路径		加文件名
	 * @param   string  $dst    保存图片的路径
	 * @return Imagick
	 */
	public function convert($src, $dst)
	{
		$args['src']	= $src;
		$args['dst']	= $dst;
		return $this->control("convert", $args);
	}
	
	/**
	 * 图片源
	 * @param string $src
	 * @return Imagick
	 */
	public function image_info($src)
	{
		return $this->control("image_info", $src);
	}
	
	/*******		全局方法结束		**********/
	
	/*******		  辅助函数		**********/
	
	/**
	 * 判断路径是否存在，不存再就创建
	 * @param  string  $path  路径
	 * @return boolean
	 **/
	public function mdir($dir)
	{
		if(is_dir($dir))	return true;
		$mode 		= 0777;
		$root_path 	= realpath('./');
		
		$relative_path  = str_replace($root_path, '', $dir);
	    $each_path      = explode('/', $relative_path);
	    $cur_path       = $root_path; // 当前循环处理的路径
	    foreach ($each_path as $path){
	        if ($path){
	            $cur_path = $cur_path . '/' . $path;
	            if (!is_dir($cur_path)){
	                if (@mkdir($cur_path, $mode)){
	                    fclose(fopen($cur_path . '/index.htm', 'w'));
	                    
	                }else{
	                    if($mode!=0664){
		                	$mode = 0664;
		                    if (@mkdir($cur_path, $mode)){
		                    	fclose(fopen($cur_path . '/index.htm', 'w'));
		                    }else{
		                    	return false;
		                    }
	                    }else{
	                		return false;
	                    }
	                }
	            }
	        }
	    }
	}
	
	/**
	 * 查看图片是否是gif动画
	 * 
	 * @$filename            原图片路径		加文件名
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	public function isAnimatedGif($filename)
	{
	    $fp = fopen($filename, 'rb');
	    $filecontent = fread($fp, 1024);
	    fclose($fp);
	    return strpos($filecontent,chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0') === FALSE ? false : true;
	}
	
	/**
	 * 十六进制color 转换成 RGB 值	
	 * @param   string $str 如#DFDFDF或#FFCCDD
	 * @return  array('r'=>10,'g'=>10,'b'=>10)
	 **/
	public function hex_rgb($str)
	{
		if($str[0]=='#'){
			$str = substr($str, 1);
		}
		if( strlen($str) >=6 ){
			list($r,$g,$b) = array($str[0].$str[1] , $str[2].$str[3] , $str[4].$str[5]); 
		}else if( strlen($str) >=3 ){
			list($r,$g,$b) = array($str[0].$str[0] , $str[1].$str[1] , $str[3].$str[3] );
		}else{
			return false;
		}
		
		return array('r'=>hexdec($r),'g'=>hexdec($g),'b'=>hexdec($b));
	}
	
	/**
	 * RGB 颜色转为十六进制
	 * @param array $color 	颜色  array('r'=>'20','g'=>'255','b'=>'50');
	 * return string #ffccff	
	 **/
	public function rgb_hex($color)
	{
		if(isset($color['r'])){
			$r	= $color['r'];
			$g	= $color['g'];
			$b 	= $color['b'];
		}else{
			list($r,$g,$b) = $color;
		}
		
		return '#'.dechex($r).dechex($g).dechex($b);
	}
	
	/**
	 * 获得字符中所占的宽度
	 * 
	 * @param string  $str 	字符串
	 * @param int     $font	字体大小
	 * return int  	     返回字符串所占用的像素
	 * ***/
	public function text_width($str , $font=12)
	{
		$count	= strlen($str);
		$n		= 0;		// 字符数
		$v		= 0;
		while($v<$count){
			$c	= substr($str,0,1);
			if(strlen($str)<=0) break;
			if( ord($c)>=128 ){
				$one_str= mb_substr($str,0,1,'utf-8');
				$jc		= strlen($one_str);
				$str	= substr($str,$jc);
				$n++;
				$n++;
				$v = $v + $jc;
			}else{
				$str = substr($str, 1);
				$n++;
				$v++;
			}
		}
		
		return $n * ($font +3);
	}
	
	/**
	 * 路径的转换	 (相对路径转换成绝对路径)
	 * @param  string $path	路径	加文件名 ，如传 	ss/11.txt 
	 * @return string 路径的转换，返回  D:\EasyPHP3.0\www\dk
	 **/
	public function get_realpath($path)
	{
		if( strrpos($path,'\\')===false ){
			return realpath($path);
		}else{
			return $path;
		}
	}

	/*******		  辅助函数结束		**********/
	
	/*******		  GD库对应的方法		**********/
	
	/**
	 * @param  array $args	图片信息
	 * @return array | bool			
	 * array('width'=>'宽','height'=>'高','type'=>'类型','size'=>'大小(bit)')
	 **/
	private function getImageAttr_gd2($args)
	{
		$src	= $args['src'];
		
		if(!is_file($src) ){
			return false;
		}
			
		$data = @getimagesize($src);
		if($data==false){
			return false;
		}
		
		$image_type = array(1=>'gif', 2=>'jpg', 3=>'png', 4=>'swf', 5=>'psd', 6=>'bmp', 7=>'tiff', 8=>'tiff', 9=>'jpc',
						10=>'jp2', 11=>'jpx', 12=>'jb2', 13=>'swc', 14=>'iff', 15=>'wbmp', 16=>'xbm' );
		
		$arr['width']	= $data[0];
		$arr['height']	= $data[1];
		$arr['type']	= @$image_type[$data[2]];
		$arr['image_type']= $data[2];
		$arr['size']	= filesize($src);
		
		unset($data);
		
		return $arr;
	}
	
	/**
	 * 图片的缩放
	 * 
	 * gif , jpg , png 
	 * @param   string      $src            原图片路径
	 * @param   string      $dst            缩略图保存路径
	 * @param   int         $thumb_width    缩略图宽度
	 * @param   int         $thumb_height   缩略图高度
	 * @param   int         $quality        缩略图品质 100之内的正整数
	 * @return  boolean     成功返回 true 失败返回 false
	 **/
	private function resize_gd2($args)
	{
		$src		= $args['src'];
		$dst		= $args['dst'];
		$thumb_width= $args['thumb_width'];
		$thumb_height= $args['thumb_height'];
		$quality	= $args['quality'];
		        
        $dirpath = dirname($dst);
        if (!$this->mdir($dirpath )){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
		
        $data = @getimagesize($src);
        $src_width = $data[0];
        $src_height = $data[1];
		if( (!($src_height>0)) || (!($src_width>0))  ){
			return false;
		}
		if( !in_array($data[2], $this->image_format_arr) ){
			return false;
		}
		
        if ($thumb_height == 0){
            if ($src_width > $src_height){
                $thumb_height = $src_height * $thumb_width / $src_width;
            }else{
                $thumb_height = $thumb_width;
                $thumb_width = $src_width * $thumb_height / $src_height;
            }
            $dst_x = 0;
            $dst_y = 0;
            $dst_w = $thumb_width;
            $dst_h = $thumb_height;
        }else{
            $css_w	= $src_height>0 ? $src_width / $src_height : $src_width;
			$css_h	= $thumb_height>0 ? $thumb_width / $thumb_height : $thumb_width;
        	if(($src_width > $thumb_width) || ($src_height > $thumb_height)){
				if ( $css_w > $css_h ){
	                $dst_w = $thumb_width;
	                $dst_h = ($dst_w * $src_height) / $src_width;
	                $dst_x = 0;
	                $dst_y = ($thumb_height - $dst_h) / 2;
	            }else{
	                $dst_h = $thumb_height;
	                $dst_w = $src_height >0 ?  ($src_width * $dst_h) / $src_height : $src_width * $dst_h;
	                $dst_y = 0;
	                $dst_x = ($thumb_width - $dst_w) / 2;
	            }
			}else{
				$dst_w = $src_width;
                $dst_h = $src_height;
                $dst_x = floor(($thumb_width/2)-($src_width/2));
                $dst_y = floor(($thumb_height/2)-($src_height/2));
			}
        }

        switch ($data[2]){
            case 1:
                $im = imagecreatefromgif($src);
                break;
            case 2:
                $im = imagecreatefromjpeg($src);
                break;
            case 3:
                $im = imagecreatefrompng($src);
                break;
            default:
                return false;
                break;
        }
        
        //  使用的函数
        $func_imagecreate = function_exists('imagecreatetruecolor') ? 'imagecreatetruecolor' : 'imagecreate';
        $func_imagecopy = function_exists('imagecopyresampled') ? 'imagecopyresampled' : 'imagecopyresized';
        $ni = $func_imagecreate($thumb_width, $thumb_height);
        if ($func_imagecreate == 'imagecreatetruecolor')
        {
            imagefill($ni, 0, 0, imagecolorallocate($ni, 255, 255, 255));
        }else{
            imagecolorallocate($ni, 255, 255, 255);
        }
        $func_imagecopy($ni, $im, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $src_width, $src_height);

        switch($data[2]){
        	case 1:
        		imagegif($ni, $dst );
        	case 2:
        		imagejpeg($ni, $dst, $quality);
        	case 3:
        		imagepng($ni, $dst);
        }
        
		// 释放内存
        imagedestroy($ni);
		unset($data);
        
        return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片缩放  (先等比例缩放，在左上角开始截图)
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_y		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function resize_two_gd2($args){
		//$src, $dst, $dst_w, $dst_y, $quality=80
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dst_w	= intval($args['dst_w']);
		$dst_y	= intval($args['dst_y']);
		$quality= intval($args['quality']);
		
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_y/$src_height;
		$resize_y   = 0;
		$resize_x   = 0;
		$is_rotio	= false;
		if($ratio_w>=1 || $ratio_h>=1){
			if($ratio_w>=1 && $ratio_h<=1){
				$resize_width 	= $src_width;
				$resize_height 	= $dst_y;
				$resize_y       = floor( ($src_height/2)-($dst_y/2) );
			}else if($ratio_h>=1 && $ratio_w<=1){
				$resize_width 	= $dst_w;
				$resize_height 	= $src_height;
				$resize_x       = floor( ($src_width/2)-($dst_w/2) );
			}else{
				$resize_width 	= $src_width;
				$resize_height 	= $src_height;
			}
			$is_rotio = true;
		}else if($ratio_w>=$ratio_h){
			$is_rotio = false;
			$resize_width	= ceil($src_width * $ratio_w);
			$resize_height	= ceil($src_height * $ratio_w);
			$resize_y       = floor( ($resize_height/2)-($dst_y/2) );
		}else if($ratio_w<=$ratio_h){
			$is_rotio = false;
			$resize_width	= ceil($src_width * $ratio_h);
			$resize_height	= ceil($src_height * $ratio_h);
			$resize_x       = floor( ($resize_width/2)-($dst_w/2) );
		}	
		

        switch ($data[2]){
            case 1:
                $im = imagecreatefromgif($src);
                break;
            case 2:
                $im = imagecreatefromjpeg($src);
                break;
            case 3:
                $im = imagecreatefrompng($src);
                break;
            default:
                return false;
                break;
        }
        
	    //  使用的函数
        $func_imagecreate = function_exists('imagecreatetruecolor') ? 'imagecreatetruecolor' : 'imagecreate';
        $func_imagecopy = function_exists('imagecopyresampled') ? 'imagecopyresampled' : 'imagecopyresized';
        $ni = $func_imagecreate($resize_width, $resize_height);
        if ($func_imagecreate == 'imagecreatetruecolor')
        {
            imagefill($ni, 0, 0, imagecolorallocate($ni, 255, 255, 255));
        }else{
            imagecolorallocate($ni, 255, 255, 255);
        }
		if($is_rotio==false){
			$ni2 = $func_imagecreate($dst_w, $dst_y);
			if ($func_imagecreate == 'imagecreatetruecolor')
			{
				imagefill($ni2, 0, 0, imagecolorallocate($ni2, 255, 255, 255));
			}else{
				imagecolorallocate($ni2, 255, 255, 255);
			}
			$func_imagecopy($ni, $im, 0, 0, $resize_x,  $resize_y, $resize_width, $resize_height, $src_width, $src_height);
			$func_imagecopy($ni2, $ni, 0, 0, $resize_x,  $resize_y, $dst_w, $dst_y, $dst_w, $dst_y);
			$ni = $ni2;
        }else{
			$func_imagecopy($ni, $im, 0, 0, $resize_x,  $resize_y, $resize_width, $resize_height, $resize_width, $resize_height);
		}
		
        switch($data[2]){
        	case 1:
        		imagegif($ni, $dst );
        	case 2:
        		imagejpeg($ni, $dst, $quality);
        	case 3:
        		imagepng($ni, $dst);
        }
        
		// 释放内存
        imagedestroy($ni);
		unset($data);
        
        return is_file($dst) ? true : false;
	}
	
	/**
	 * 生成截图
	 * crop_gd2($i , $p , 15 , 20 , 80 , 35 , 90);
	 *
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $src_x			从原图的 x 位置开始截取 x
	 * @param   int     $src_y			从原图的	y 位置开始截取 y
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_y		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function crop_gd2($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$src_x	= intval($args['src_x']);
		$src_y	= intval($args['src_y']);
		$dst_w	= intval($args['dst_w']);
		$dst_y	= intval($args['dst_y']);
		$quality= intval($args['quality']);
		
		$dirpath = dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		
		if(!is_file($src) ){
			return false;
		}
		
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];
		if( (!($src_height>0)) || (!($src_width>0))  ){
			return false;
		}
		if( !in_array($data[2], $this->image_format_arr) ){
			return false;
		}
		
		if( $src_width < ($src_x + $dst_w) ){//w
			$dst_w	= $src_width - $src_x;
		}
		
		if( $src_height < ($src_y + $dst_y) ){//y
			$dst_y	= $src_height - $dst_y;
		}
		
		switch ($data[2]){
			case 1:
				$im = imagecreatefromgif($src);
				break;
			case 2:
				$im = imagecreatefromjpeg($src);
				break;
			case 3:
				$im = imagecreatefrompng($src);
				break;
			default:
				return false;
				break;
		}
		
		$func_imagecopy 	= function_exists('imagecopyresampled') ? 'imagecopyresampled' : 'imagecopyresized';// 创建目标图gd2  	或 gd1
		$func_imagecreate 	= function_exists('imagecreatetruecolor') ? 'imagecreatetruecolor' : 'imagecreate';// 创建目标图gd2  	或 gd1	
		
		$dim 	= $func_imagecreate($dst_w, $dst_y); //创建图
		if ($func_imagecreate == 'imagecreatetruecolor'){
			imagefill($dim, 0, 0, imagecolorallocate($dim, 255, 255, 255));	// 白色
		}else{
			imagecolorallocate($dim, 255, 255, 255);
		}
		
		$func_imagecopy( $dim , $im , 0 , 0 , $src_x , $src_y , $dst_w , $dst_y , $dst_w , $dst_y);
		
		switch($data[2]){
        	case 1:
        		imagegif($dim, $dst );
        	case 2:
        		imagejpeg($dim, $dst, $quality);
        	case 3:
        		imagepng($dim, $dst);
        }
		
		// 释放内存
        imagedestroy($dim);
		unset($data);
        
		return is_file($dst) ? true : false;
	}

	/**
	 * 图片等比缩放
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_y		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function resize_ratio_gd2($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dst_w	= intval($args['dst_w']);
		$dst_y	= intval($args['dst_y']);
		$quality= intval($args['quality']);

		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];
		
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_y/$src_height;
	    if($dst_w >= $src_width && $dst_y >= $src_height){
		    $resize_width	= $src_width;
			$resize_height	= $src_height;
		}else if($ratio_w>=$ratio_h){
			$resize_width	= $src_width * $ratio_h;
			$resize_height	= $src_height * $ratio_h;
		}else if($ratio_w<=$ratio_h){
			$resize_width	= $src_width * $ratio_w;
			$resize_height	= $src_height * $ratio_w;
		}		

        switch ($data[2]){
            case 1:
                $im = imagecreatefromgif($src);
                break;
            case 2:
                $im = imagecreatefromjpeg($src);
                break;
            case 3:
                $im = imagecreatefrompng($src);
                break;
            default:
                return false;
                break;
        }
        
        //  使用的函数
        $func_imagecreate = function_exists('imagecreatetruecolor') ? 'imagecreatetruecolor' : 'imagecreate';
        $func_imagecopy = function_exists('imagecopyresampled') ? 'imagecopyresampled' : 'imagecopyresized';
        $ni = $func_imagecreate($resize_width, $resize_height);
        if ($func_imagecreate == 'imagecreatetruecolor')
        {
            imagefill($ni, 0, 0, imagecolorallocate($ni, 255, 255, 255));
        }else{
            imagecolorallocate($ni, 255, 255, 255);
        }
        $func_imagecopy($ni, $im, 0, 0, 0, 0, $resize_width, $resize_height, $src_width, $src_height);
        
		
        switch($data[2]){
        	case 1:
        		imagegif($ni, $dst );
        	case 2:
        		imagejpeg($ni, $dst, $quality);
        	case 3:
        		imagepng($ni, $dst);
        }
        
		// 释放内存
        imagedestroy($ni);
		unset($data);
        
        return is_file($dst) ? true : false;
	}	
	
	/**
	 * 图片等比裁剪
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_y		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function crop_ratio_gd2($args)
	{
		$src	= $args['src'];
		$dst	= $args['dst'];
		$dst_w	= $args['dst_w'];
		$dst_y	= $args['dst_y'];
		$quality= $args['quality'];
		if(!$quality) $quality = 80;
		
		if(!is_file($src) ){
			return false;
		}
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];
        
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_y/$src_height;

		if($ratio_w>=$ratio_h){
			$resize_width	= $src_width * $ratio_w;
			$resize_height	= $src_height * $ratio_w;
		}else if($ratio_w<=$ratio_h){
			$resize_width	= $src_width * $ratio_h;
			$resize_height	= $src_height * $ratio_h;
		}

        switch ($data[2]){
            case 1:
                $im = imagecreatefromgif($src);
				$im2 = imagecreatefromgif($src);
                break;
            case 2:
                $im = imagecreatefromjpeg($src);
				$im2 = imagecreatefromjpeg($src);
                break;
            case 3:
                $im = imagecreatefrompng($src);
				$im2 = imagecreatefrompng($src);
                break;
            default:
                return false;
                break;
        }
        
        //  使用的函数
        $func_imagecreate = function_exists('imagecreatetruecolor') ? 'imagecreatetruecolor' : 'imagecreate';
        $func_imagecopy = function_exists('imagecopyresampled') ? 'imagecopyresampled' : 'imagecopyresized';
        $ni = $func_imagecreate($resize_width, $resize_height);
        if ($func_imagecreate == 'imagecreatetruecolor')
        {
            imagefill($ni, 0, 0, imagecolorallocate($ni, 255, 255, 255));
        }else{
            imagecolorallocate($ni, 255, 255, 255);
        }
        $func_imagecopy($ni, $im, 0, 0, 0, 0, $resize_width, $resize_height, $src_width, $src_height);
        
		
		$dim 	= $func_imagecreate($dst_w, $dst_y); //创建图
		if ($func_imagecreate == 'imagecreatetruecolor'){
			imagefill($dim, 0, 0, imagecolorallocate($dim, 255, 255, 255));	// 白色
		}else{
			imagecolorallocate($dim, 255, 255, 255);
		}
		$func_imagecopy( $dim , $ni , 0 , 0 , 0 , 0 , $dst_w , $dst_y , $dst_w , $dst_y);
		switch($data[2]){
        	case 1:
        		imagegif($dim, $dst );
        	case 2:
        		imagejpeg($dim, $dst, $quality);
        	case 3:
        		imagepng($dim, $dst);
        }
		// 释放内存
        imagedestroy($dim);
		unset($data);
        
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片的旋转
	 * 
	 * @param   string  $src		原图像路径
	 * @param   string  $dst 	          新图像路径
	 * @param   int     $angle		旋转角度		逆时针转    	正北  0度		正西 90度
	 * @param   int     quality		截取图品质 100之内的正整数
	 * @return  boolean
	 **/
	private function rotate_gd2($args)
	{
		$src	= $args['src'];
		$dst	= $args['dst'];
		$angle	= $args['angle'];
		$quality= $args['quality'];
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		
		if(!is_file($src) ){
			return false;
		}
		
		$data 		= @getimagesize($src);
		$src_width 	= $data[0];
		$src_height = $data[1];
		if( (!($src_height>0)) || (!($src_width>0))  ){
			return false;
		}
		if( !in_array($data[2], $this->image_format_arr) ){
			return false;
		}
		
		switch ($data[2]){
			case 1:
				$im = imagecreatefromgif($src);
				break;
			case 2:
				$im = imagecreatefromjpeg($src);
				break;
			case 3:
				$im = imagecreatefrompng($src);
				break;
			default:
				return false;
				break;
		}
		
		$dim 	= imagerotate($im, $angle , imagecolorallocate($im, 0, 0, 0));	// 背景为白色
		switch($data[2]){
        	case 1:
        		imagegif($dim, $dst );
        	case 2:
        		imagejpeg($dim, $dst, $quality);
        	case 3:
        		imagepng($dim, $dst);
        }
		
		// 释放内存
        imagedestroy($dim);		
		unset($data);
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片加水印
	 * 
	 * @param    string  $src		原图片路径		加文件名
	 * @param    string  $mark		水印图片路径  	加文件名
	 * @param    string  $dst		图保存路径  	加文件名
	 * @param    string|array $position = 'rb' or array('width'=>20,'height'=>20)	水印图片放置的位置	lt左上  rt右上  rb右下  lb左下 其余取指定位置
	 * @param    int     $quality 	图片质量，仅对jpg有效 默认85 取值 0-100之间整数
	 * @param    int     $pct 		水印图片融合度(透明度)
	 * @return   boolean
	 **/
	private function watermark_gd2($args)
	{
		$src	= $args['src'];
		$mark	= $args['mark'];
		$dst	= $args['dst'];
		$position= $args['position'];
		$quality= intval($args['quality']);
		$pct	= intval($args['pct']);
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
		if(!is_file($mark)){
			return false;
		}
		
		$data = getimagesize($src);
		$src_width 	= $data[0];
		$src_height = $data[1];
		$src_type = $data[2];
		if( (!($src_height>0)) || (!($src_width>0))  ){
			return false;
		}
		if( !in_array($data[2], $this->image_format_arr) ){
			return false;
		}
        
        $data = getimagesize($mark);
        $mark_width = $data[0];
        $mark_height = $data[1];
        $mark_type = $data[2];
		
	    switch ($src_type)
        {
            case 1:
                $src_im = imagecreatefromgif($src);
                $imagefunc = function_exists('imagegif') ? 'imagejpeg' : '';
                break;
            case 2:
                $src_im = imagecreatefromjpeg($src);
                $imagefunc = function_exists('imagejpeg') ? 'imagejpeg' : '';
                break;
            case 3:
                $src_im = imagecreatefrompng($src);
                $imagefunc = function_exists('imagepng') ? 'imagejpeg' : '';
                break;
        }
        switch ($mark_type)
        {
            case 1:
                $mark_im = imagecreatefromgif($mark);
                break;
            case 2:
                $mark_im = imagecreatefromjpeg($mark);
                break;
            case 3:
                $mark_im = imagecreatefrompng($mark);
                break;
        }
		
        /*** 	水印放置的位置	***/
	    if( is_array($position) ){
	    	$x 	= $position['width'];
	    	$y 	= $position['height'];;
	    }else{
	        switch ($position)
	        {
	            case 'lt':
	                $x = 0;
	                $y = 0;
	                break;
	            case 'rt':
	                $x = $src_width - $mark_width;
	                $y = 0;
	                break;
	            case 'rb':
	                $x = $src_width - $mark_width;
	                $y = $src_height - $mark_height;
	                break;
	            case 'lb':
	                $x = 0;
	                $y = $src_height - $mark_height;
	                break;
	            default:
	                $x = ($src_width - $mark_width) / 2;
	                $y = ($src_height - $mark_height) / 2;
	                break;
	        }
	    }
        
	    if (function_exists('imagealphablending')) imageAlphaBlending($mark_im, true);
        imageCopyMerge($src_im, $mark_im, $x, $y, 0, 0, $mark_width, $mark_height, $pct);

        if ($src_type == 2){
            $imagefunc($src_im, $dst, $quality);
        }else{
            $imagefunc($src_im, $dst);
        }
		// 释放内存
        imagedestroy($src_im);		
		unset($data);
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片加入文字
	 * 
	 * @$src 	原图片路径		加文件名
	 * @$dst 	保存图片的路径
	 * @$str	加入的文字
	 * @$quality	图片的质量	只对 jpg 有效
	 * @$pct		透明度
	 **/
	private function textmark_gd2($args)
	{
		$src	= $args['src'];
		$dst	= $args['dst'];
		$str	= $args['str'];
		$quality= $args['quality'];
		$pct	= $args['pct'];
		$color	= $args['color'];
		$position= $args['position'];
		$font_size= $args['font_size'];
		
		if(!is_file($src) ){
			return false;
		}
		$data = getimagesize($src);
		
		if(! ($data[0]>0 && $data[1]>0) ){
			return false;
		}
		if(! in_array($data[2], $this->image_format_arr)){
			return false;
		}
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
        
	    /*** 	文字放置的位置	***/
	    if( is_array($position) ){
	    	$x 	= $position['width'];
	    	$y 	= $position['height'];;
	    }else{
	    	$text_width = $this->text_width($str,$font_size);
	        switch ($position)
	        {
	            case 'lt':
	                $x = 0 + 12;
	                $y = 0 + 12;
	                break;
	            case 'rt':
	                $x = $data[0] - $text_width - 12;
	                $y = 0 + 12;
	                break;
	            case 'rb':
	                $x = $data[0] - $text_width - 12;
	                $y = $data[1] - $text_width - 12;
	                break;
	            case 'lb':
	                $x = 0 + 12;
	                $y = $data[1] - $text_width - 12;
	                break;
	            default:
	                $x = ($data[0] - $text_width) / 2 + 12;
	                $y = ($data[1] - $text_width) / 2 + 12;
	                break;
	        }
	    }
        $nimage	= imagecreatetruecolor($data[0],$data[1]);
        $white	= imagecolorallocate($nimage,255,255,255);				// 白色
        $font_color		= imagecolorallocate($nimage,$color['r'],$color['g'],$color['b']);	// 字体颜色
        $red	= imagecolorallocate($nimage,255,0,0);					// 红
        imagefill($nimage,0,0,$white);
        switch ($data[2]){
            case 1:
	            $simage =imagecreatefromgif($src);
	            break;
            case 2:
	            $simage =imagecreatefromjpeg($src);
	            break;
            case 3:
	            $simage =imagecreatefrompng($src);
	            break;
            case 6:
	            $simage =imagecreatefromwbmp($src);
	            break;
        }
		imagecopy($nimage,$simage,0,0,0,0,$data[0],$data[1]);
		imagestring($nimage,$font_size,$x,$y,$str,$font_color);
		
		// 生成
        switch ($data[2]){
            case 1:
				imagegif($nimage, $dst);
				// imagejpeg($nimage, $destination , $quality ) ;
				break;
            case 2:
				imagejpeg($nimage, $dst , $quality);
				break;
            case 3:
				imagepng($nimage, $dst );
				break;
            case 6:
				imagewbmp($nimage, $dst );
            break;
        }
        
		return is_file($dst) ? true : false;
	}
	
	/*******		  GD库对应的方法结束		**********/
	
	/*******		  php通过shell方式调用imagick库方法		**********/
	
	/**
	 * 图片的缩放
	 * 
	 * gif , jpg , png 
	 * @param   string      $src            原图片路径
	 * @param   string      $dst            缩略图保存路径
	 * @param   int         $thumb_width    缩略图高度
	 * @param   int         $thumb_height   缩略图高度 可选
	 * @param   int         $quality        缩略图品质 100之内的正整数
	 * @return  boolean     成功返回 true 失败返回 false
	 * 
	 * convert.exe -resize 64x64 e:\11.jpg e:\222.jpg
	 * **/
	private function resize_imagick($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		
		$thumb_width 	= $args['thumb_width'];
		$thumb_height 	= $args['thumb_height'];
		$quality 		= $args['quality'];
		
		if(! @is_file($src)){
			return false;
		}
		if($dst==''){
			return false;
		}
		
		$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' -resize '.$thumb_width.'x'.$thumb_height.' '.$src.' '.$dst;
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片裁剪
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   stirng  $dst            截取图保存路径  	加文件名
	 * @param   int     $src_x			从原图的 x 位置开始截取 x
	 * @param   int     $src_y			从原图的	y 位置开始截取 y
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_y		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 * convert.exe -crop 75x75+10+20 repage e:\11.jpg e:\22.jpg
	 **/
	public function crop_imagick($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		$src_x	= intval($args['src_x']);
		$src_y	= intval($args['src_y']);
		$dst_w	= intval($args['dst_w']);
		$dst_y	= intval($args['dst_y']);
		$quality= intval($args['quality']);
		
		if(! @is_file($src)){
			return false;
		}
		if($dst==''){
			return false;
		}
		
		$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert." -crop {$dst_w}x{$src_y}+{$src_x}+{$src_y} +repage {$src} {$dst}";
		
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}

	/**
	 * 旋转  图片
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst			截取图保存路径  	加文件名
	 * @param   int     $angle			旋转角度		逆时针转    	正北  0度		正西 90度
	 * @param   int     $quality		截取图品质 100之内的正整数
	 * @return  boolean
	 * convert.exe -rotate -30 e:\11.jpg e:\223.jpg
	 **/
	public function rotate_imagick($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
        
		$angle 	= $args['angle'];
		$quality= $args['quality'];
		
		// 这里是顺时针转的		改为   逆时针转
		$angle 	= - $angle;
		
		if(! @is_file($src)){
			return false;
		}
		if($dst==''){
			return false;
		}
		
		$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' -rotate '.$angle.' '.$src.' '.$dst;
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片添加图片水印
	 * 
	 * @param  string  $src		原图片路径		加文件名
	 * @param  string  $mark	水印图片路径  	加文件名
	 * @param  string  $dst		图保存路径  	加文件名
	 * @param  string|array $position = 'rb' or array('width'=>20,'height'=>20)	水印图片放置的位置	lt左上  rt右上  rb右下  lb左下 其余取指定位置
	 * @param  int     $quality 图片质量，仅对jpg有效 默认85 取值 0-100之间整数
	 * @param  int     $pct 	水印图片融合度(透明度)
	 * @return boolean
	 * composite.exe -geometry -0-0 e:\22.jpg e:\11.jpg e:\1232.jpg
	 * **/
	public function watermark_imagick($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$mark	= $args['mark'];
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		$pct		= $args['pct'];
		$position	= $args['position'];
		
		if(! @is_file($src)){
			return false;
		}
		if(! @is_file($mark) ){
			return false;
		}

        /*** 	水印放置的位置	***/
	    if( is_array($position) ){
	    	$x 	= $position['width'];
	    	$y 	= $position['height'];;
	    }else{
			$data 		= getimagesize($src);
			$src_width 	= $data[0];
			$src_height = $data[1];
			$mark_data	= getimagesize($mark);
	    	$mark_width = $mark_data[0];
	    	$mark_height= $mark_data[1];
			
	    	switch ($position)
	        {
	            case 'lt':
	                $x = 0;
	                $y = 0;
	                break;
	            case 'rt':
	                $x = $src_width - $mark_width;
	                $y = 0;
	                break;
	            case 'rb':
	                $x = $src_width - $mark_width;
	                $y = $src_height - $mark_height;
	                break;
	            case 'lb':
	                $x = 0;
	                $y = $src_height - $mark_height;
	                break;
	            default:
	                $x = ($src_width - $mark_width) / 2;
	                $y = ($src_height - $mark_height) / 2;
	                break;
	        }
	    }
        
		$cmd = $this->magick_cmd_path.''.$this->magick_cmd_composite." -geometry -{$x}-{$y} {$mark} {$src} {$dst}";
		
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片加入文字
	 * 
	 * @param  string  $src  	原图片路径		加文件名
	 * @param  string  $dst  	保存图片的路径
	 * @param  string  $str  	加入的文字
	 * @param  string|array $position = 'rb' or array('width'=>20,'height'=>20)	水印图片放置的位置	lt左上  rt右上  rb右下  lb左下 其余取指定位置
	 * @param  string  $color string  	字体颜色		可以是  十六进制的颜色值  #ffffff 或 ffffff  或  array('r'=>10,'g'=>10,'b'=>10)
	 * @param  string  $font_size		字体颜色
	 * @param  int     $quality 图片的质量	只对 jpg 有效
	 * @param  int     $pct		透明度
	 * 
	 * convert.exe -font helvetica -fill '#00ff00' -pointsize 40 -draw 'text 10,20 "selkjfjd"' e:\11.jpg e:\sssee.jpg
	 **/
	public function textmark_imagick($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		$str		= $args['str'];
		$position	= $args['position'];
		$color 		= $this->rgb_hex($args['color']);
		$font_size 	= $args['font_size'];
		
	    /*** 	文字放置的位置	***/
	    if( is_array($position) ){
	    	$x 	= $position['width'];
	    	$y 	= $position['height'];;
	    }else{
			$data 		= getimagesize($src);
			$src_width 	= $data[0];
			$src_height = $data[1];
	    	$text_width = $this->text_width($str,$font_size);
	        switch ($position)
	        {
	            case 'lt':
	                $x = 0 + 12;
	                $y = 0 + 12;
	                break;
	            case 'rt':
	                $x = $data[0] - $text_width - 12;
	                $y = 0 + 12;
	                break;
	            case 'rb':
	                $x = $data[0] - $text_width - 12;
	                $y = $data[1] - $text_width - 12;
	                break;
	            case 'lb':
	                $x = 0 + 12;
	                $y = $data[1] - $text_width - 12;
	                break;
	            default:
	                $x = ($data[0] - $text_width) / 2 + 12;
	                $y = ($data[1] - $text_width) / 2 + 12;
	                break;
	        }
	    }
	    
	    $cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert." -font helvetica -fill \"".$color."\" -pointsize {$font_size} -draw 'text {$x},{$y} \"{$str}\"' {$src} {$dst}";
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片等比缩放(先等比例缩放在从左上角截取)
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $thumb_width	截取图宽度
	 * @param   int     $thumb_height	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	private function resize_two_imagick($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);

        if (! $this->mdir($dirpath)){
            return false;
        }

		$dst_w	= intval($args['dst_w']);
		$dst_y	= intval($args['dst_y']);
		$quality= intval($args['quality']);
		
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];

        $resize_y   = 0;
		$resize_x   = 0;
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_y/$src_height;
		
		$flag = $this->isAnimatedGif($src);
            
		//如果是动画
		if($flag === true){
			if($ratio_w>=1 || $ratio_h>=1){
				if($ratio_w>1 && $ratio_h<=1){
					$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -strip -coalesce -resize "'.$src_width.'x'.$dst_h.'" -layers optimize "'.$dst.'"';
				}else if($ratio_h>1 && $ratio_w<=1){
                	$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -strip -coalesce -resize "'.$dst_w.'x'.$src_height.'" -layers optimize "'.$dst.'"';
				}else{
                	$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -strip -coalesce -resize "'.$dst_w.'x'.$dst_h.'>" -layers optimize "'.$dst.'"';
                }
			}else if($ratio_w>=$ratio_h){
            	$resize_width	= ceil($src_width * $ratio_w);
				$resize_height	= ceil($src_height * $ratio_w);
                $cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -strip -coalesce -resize "'.$dst_w.'x'.$dst_h.'>" -layers optimize "'.$dst.'"';
			}else if($ratio_w<=$ratio_h){
            	$resize_width	= ceil($src_width * $ratio_h);
                $resize_height	= ceil($src_height * $ratio_h);
                $cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -strip -coalesce -resize "'.$dst_w.'x'.$dst_h.'>" -layers optimize "'.$dst.'"';
            }
		}else{
			$this->magick_cmd_path = '/usr/local/GraphicsMagick/bin/gm ';
            if($ratio_w>=1 || $ratio_h>=1){
            	if($ratio_w>1 && $ratio_h<=1){
                	$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -strip -crop "'.$src_width.'x'.$dst_h.'+0+0" "'.$dst.'"';
                }else if($ratio_h>1 && $ratio_w<=1){
					$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -strip -crop "'.$dst_w.'x'.$src_height.'+0+0" "'.$dst.'"';
				}else{
                	$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -strip -crop "'.$dst_w.'x'.$dst_h.'+0+0" "'.$dst.'"';
                }
			}else if($ratio_w>=$ratio_h){
            	$resize_width	= ceil($src_width * $ratio_w);
                $resize_height	= ceil($src_height * $ratio_w);
                $cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -strip -resize "'.$resize_width.'x'.$resize_height.'" -crop "'.$dst_w.'x'.$dst_h.'+0+0" "'.$dst.'"';
			}else if($ratio_w<=$ratio_h){
            	$resize_width	= ceil($src_width * $ratio_h);
                $resize_height	= ceil($src_height * $ratio_h);
                $cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -strip -resize "'.$resize_width.'x'.$resize_height.'" -crop "'.$dst_w.'x'.$dst_h.'+0+0" "'.$dst.'"';
            }
		}

		//$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'"  -coalesce -thumbnail '.$thumb_width.'x'.$thumb_height.' -layers optimize "'.$dst.'"';
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片等比缩放(先等比例缩放在从左上角截取)
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $thumb_width	截取图宽度
	 * @param   int     $thumb_height	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	private function resize_two_imagick_old($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);

        if (! $this->mdir($dirpath)){
            return false;
        }

		$dst_w	= intval($args['dst_w']);
		$dst_y	= intval($args['dst_y']);
		$quality= intval($args['quality']);
		
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];

        $resize_y   = 0;
		$resize_x   = 0;
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_y/$src_height;
		
		if($dst_w >= $src_width && $dst_h >= $src_height){
			$resize_width	= $src_width;
            $resize_height	= $src_height;
		}else if($ratio_w>=$ratio_h){
			$resize_width	= ceil($src_width * $ratio_h);
            $resize_height	= ceil($src_height * $ratio_h);
		}else if($ratio_w<=$ratio_h){
        	$resize_width	= ceil($src_width * $ratio_w);
            $resize_height	= ceil($src_height * $ratio_w);
		}

		$thumb_width 	= $resize_width;
        $thumb_height 	= $resize_height;
        $quality 		= $quality;
        $flag = $this->isAnimatedGif($src);
        //如果是动画
        if($flag === true){
        	$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -coalesce -resize "'.$thumb_width.'x'.$thumb_height.'>" -layers optimize "'.$dst.'"';
		}else{
        	$this->magick_cmd_path = '/usr/local/GraphicsMagick/bin/gm ';
            $cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -resize "'.$thumb_width.'x'.$thumb_height.'>" "'.$dst.'"';
		}

		//$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'"  -coalesce -thumbnail '.$thumb_width.'x'.$thumb_height.' -layers optimize "'.$dst.'"';
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片等比缩放
	 * 
	 * @param   stirng  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $thumb_width	截取图宽度
	 * @param   int     $thumb_height	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function resize_ratio_imagick_old($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		$dst_w	= intval($args['dst_w']);
		$dst_y	= intval($args['dst_y']);
		$quality= intval($args['quality']);
		
		
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];
		
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_y/$src_height;
		if($dst_w >= $src_width && $dst_y >= $src_height){
		    $resize_width	= $src_width;
			$resize_height	= $src_height;
		}else if($ratio_w>=$ratio_h){
			$resize_width	= ceil($src_width * $ratio_h);
			$resize_height	= ceil($src_height * $ratio_h);
		}else if($ratio_w<=$ratio_h){
			$resize_width	= ceil($src_width * $ratio_w);
			$resize_height	= ceil($src_height * $ratio_w);
		}
		
		$thumb_width 	= $resize_width;
		$thumb_height 	= $resize_height;
		$quality 		= $quality;
		$flag = $this->isAnimatedGif($src);
		//如果是动画
		if($flag === true){
			$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -coalesce -resize "'.$thumb_width.'x'.$thumb_height.'>" -layers optimize "'.$dst.'"';
		}else{
			$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -resize "'.$thumb_width.'x'.$thumb_height.'>" "'.$dst.'"';
		}
		
		// $cmd = 'convert.exe "D:\EasyPHP3.0\www\mount\11.gif" -coalesce -thumbnail  200x200 -layers optimize "D:\EasyPHP3.0\www\mount\26.gif"';
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片等比缩放
	 * 
	 * @param   stirng  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $thumb_width	截取图宽度
	 * @param   int     $thumb_height	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function resize_ratio_imagick($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		$dst_w	= intval($args['dst_w']);
		$dst_y	= intval($args['dst_y']);
		$quality= intval($args['quality']);
		
		
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];
		
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_y/$src_height;
		if($dst_w >= $src_width && $dst_y >= $src_height){
		    $resize_width	= $src_width;
			$resize_height	= $src_height;
		}else if($ratio_w>=$ratio_h){
			$resize_width	= ceil($src_width * $ratio_h);
			$resize_height	= ceil($src_height * $ratio_h);
		}else if($ratio_w<=$ratio_h){
			$resize_width	= ceil($src_width * $ratio_w);
			$resize_height	= ceil($src_height * $ratio_w);
		}
		
		$thumb_width 	= $resize_width;
		$thumb_height 	= $resize_height;
		$quality 		= $quality;
		$flag = $this->isAnimatedGif($src);
		//如果是动画
		if($flag === true){
			$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -coalesce -resize "'.$thumb_width.'x'.$thumb_height.'>" -layers optimize "'.$dst.'"';
		}else{
			$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'" -resize "'.$thumb_width.'x'.$thumb_height.'>" "'.$dst.'"';
		}
		
		// $cmd = 'convert.exe "D:\EasyPHP3.0\www\mount\11.gif" -coalesce -thumbnail  200x200 -layers optimize "D:\EasyPHP3.0\www\mount\26.gif"';
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}
	
	/*******		  php通过shell方式调用imagick库方法结束		**********/
	
	/*******		  php通过shell方式调用gmagick库方法开始		**********/
	/**
	 * 转图片格式返回图片流
	 * @param array $args
	 * @return Imagick
	 */
	private function convert_gmagick($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);

        if (! $this->mdir($dirpath)){
            return false;
        }
        
        $cmd = $this->magick_cmd_path." ".$this->magick_cmd_convert." ".$src." ".$dst;
        
        @exec($cmd, $output, $retval);
		
		return is_file($dst) ? true : false;
	}
	
	
	/**
	 * 图片等比缩放(先等比例缩放在从左上角截取)
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $thumb_width	截取图宽度
	 * @param   int     $thumb_height	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	private function resize_two_gmagick($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);

        if (! $this->mdir($dirpath)){
            return false;
        }

		$dst_w	= intval($args['dst_w']);
		$dst_h	= intval($args['dst_h']);
		$quality= intval($args['quality']);
		
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];

        $resize_y   = 0;
		$resize_x   = 0;
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_h/$src_height;
		$flag = $this->isAnimatedGif($src);

		//如果是动画
		if($flag === true){
			if($ratio_w>=1 || $ratio_h>=1){
				if($ratio_w>1 && $ratio_h<=1){
                	$cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -strip -coalesce -resize "'.$src_width.'x'.$dst_h.'" -layers optimize "'.$dst.'"';
				}else if($ratio_h>1 && $ratio_w<=1){
                	$cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -strip -coalesce -resize "'.$dst_w.'x'.$src_height.'" -layers optimize "'.$dst.'"';
				}else{
                	$cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -strip -coalesce -resize "'.$dst_w.'x'.$dst_h.'>" -layers optimize "'.$dst.'"';
				}
			}else if($ratio_w>=$ratio_h){
            	$resize_width	= ceil($src_width * $ratio_w);
                $resize_height	= ceil($src_height * $ratio_w);
                $cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -strip -coalesce -resize "'.$dst_w.'x'.$dst_h.'>" -layers optimize "'.$dst.'"';
			}else if($ratio_w<=$ratio_h){
            	$resize_width	= ceil($src_width * $ratio_h);
                $resize_height	= ceil($src_height * $ratio_h);
                $cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -strip -coalesce -resize "'.$dst_w.'x'.$dst_h.'>" -layers optimize "'.$dst.'"';
			}
		}else{
			if($ratio_w>=1 || $ratio_h>=1){
				if($ratio_w>1 && $ratio_h<=1){
	            	$cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -strip -crop "'.$src_width.'x'.$dst_h.'+0+0" "'.$dst.'"';
				}else if($ratio_h>1 && $ratio_w<=1){
	            	$cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -strip -crop "'.$dst_w.'x'.$src_height.'+0+0" "'.$dst.'"';
				}else{
	            	$cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -strip -crop "'.$dst_w.'x'.$dst_h.'+0+0" "'.$dst.'"';
				}
			}else if($ratio_w>=$ratio_h){
	        	$resize_width	= ceil($src_width * $ratio_w);
	            $resize_height	= ceil($src_height * $ratio_w);
	            $cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -strip -resize "'.$resize_width.'x'.$resize_height.'" -crop "'.$dst_w.'x'.$dst_h.'+0+0" "'.$dst.'"';
			}else if($ratio_w<=$ratio_h){
	        	$resize_width	= ceil($src_width * $ratio_h);
	            $resize_height	= ceil($src_height * $ratio_h);
	            $cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -strip -resize "'.$resize_width.'x'.$resize_height.'" -crop "'.$dst_w.'x'.$dst_h.'+0+0" "'.$dst.'"';
			}	
		}

		//$cmd = $this->magick_cmd_path.''.$this->magick_cmd_convert.' "'.$src.'"  -coalesce -thumbnail '.$thumb_width.'x'.$thumb_height.' -layers optimize "'.$dst.'"';
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片等比缩放
	 * 
	 * @param   stirng  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $thumb_width	截取图宽度
	 * @param   int     $thumb_height	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function resize_ratio_gmagick($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		$dst_w	= intval($args['dst_w']);
		$dst_h	= intval($args['dst_h']);
		$quality= intval($args['quality']);
		
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];
		
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_h/$src_height;
		if($dst_w >= $src_width && $dst_h >= $src_height){
		    $resize_width	= $src_width;
			$resize_height	= $src_height;
		}else if($ratio_w>=$ratio_h){
			$resize_width	= ceil($src_width * $ratio_h);
			$resize_height	= ceil($src_height * $ratio_h);
		}else if($ratio_w<=$ratio_h){
			$resize_width	= ceil($src_width * $ratio_w);
			$resize_height	= ceil($src_height * $ratio_w);
		}
		
		$thumb_width 	= $resize_width;
		$thumb_height 	= $resize_height;
		$quality 		= $quality;
		$flag = $this->isAnimatedGif($src);
		//如果是动画
		if($flag === true){
        	$cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -coalesce -resize "'.$thumb_width.'x'.$thumb_height.'>" -layers optimize "'.$dst.'"';
		}else{
        	$cmd = $this->magick_cmd_path.' '.$this->magick_cmd_convert.' "'.$src.'" -resize "'.$thumb_width.'x'.$thumb_height.'>" "'.$dst.'"';
		}
		
		// $cmd = 'convert.exe "D:\EasyPHP3.0\www\mount\11.gif" -coalesce -thumbnail  200x200 -layers optimize "D:\EasyPHP3.0\www\mount\26.gif"';
		@exec($cmd, $output, $retval);		// $output 返回值 	 $retval 命令状态
		
		return is_file($dst) ? true : false;
	}
	
	/*******		  php通过shell方式调用gmagick库方法结束		**********/
	
	/*******		  gmagick的PHP扩展方式		**********/
	
	/**
	 * 图片缩放  (当原使图片小于截取图时 不会截取   )
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_y		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function resize_two_gmagick_class($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dst_w	= intval($args['dst_w']);
		$dst_y	= intval($args['dst_y']);
		$quality= intval($args['quality']);
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];
		
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_y/$src_height;
		$resize_y   = 0;
		$resize_x   = 0;
		
		$image 	= new Gmagick($src);
		if($ratio_w>=1 || $ratio_h>=1){
			if($ratio_w>1 && $ratio_h<=1){
				$resize_y       = floor(($src_height/2)-($dst_y/2));
				$image->cropimage($src_width, $dst_y, 0, $resize_y);
				$resize_x = floor(($dst_w/2)-($src_width/2));
				$image->borderimage('white', $resize_x, 0);
				$image->resizeImage($dst_w, $dst_y, null, 1);
			}else if($ratio_h>1 && $ratio_w<=1){
				$resize_x = floor(($src_width/2)-($dst_w/2));
				$image->cropimage($dst_w, $src_height, $resize_x, 0);
				$resize_y       = floor(($dst_y/2)-($src_height/2));
				$image->borderimage('white', 0, $resize_y);
				$image->resizeImage($dst_w, $dst_y, null, 1);
			}
		}else if($ratio_w>=$ratio_h){
			$resize_width	= ceil($src_width * $ratio_w);
			$resize_height	= ceil($src_height * $ratio_w);
			$resize_y       = floor(($resize_height/2)-($dst_y/2));
			
			$image->resizeimage($resize_width, $resize_height, null, 1);
			$image->cropimage($dst_w, $dst_y, $resize_x, $resize_y);
		}else if($ratio_w<=$ratio_h){
			$resize_width	= ceil($src_width * $ratio_h);
			$resize_height	= ceil($src_height * $ratio_h);
			$resize_x       = floor(($resize_width/2)-($dst_w/2));
			
			$image->resizeimage($resize_width, $resize_height, null, 1);
			$image->cropimage($dst_w, $dst_y, $resize_x, $resize_y);
		}
		
		$image->despeckleimage();
		$image->enhanceimage();
		$image->write($dst);
		$sign = is_file($dst) ? true : false;
		$image->destroy();
		return $sign;
	}
	
	/**
	 * 图片等比缩放
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_y		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function resize_ratio_gmagick_class($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dst_w	= intval($args['dst_w']);
		$dst_y	= intval($args['dst_y']);
		$quality= intval($args['quality']);	
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
        $data 	= @getimagesize($src);
        $src_width 	= $data[0];
        $src_height = $data[1];
		
		$ratio_w	= $dst_w/$src_width;
		$ratio_h	= $dst_y/$src_height;
		if($ratio_w>=$ratio_h){
			$resize_width	= $src_width * $ratio_w;
			$resize_height	= $src_height * $ratio_w;
		}else if($ratio_w<=$ratio_h){
			$resize_width	= $src_width * $ratio_h;
			$resize_height	= $src_height * $ratio_h;
		}
		
		$image 	= new Gmagick($src);
		// 参数依次为切割的  宽 ， 高 ， x , y
		$image->scaleimage($resize_width,$resize_height);
		$image->write($dst);
		return is_file($dst) ? true : false;
	}
	
	/*******		  gmagick的PHP扩展方式结束		**********/
	
	/*******		   imagick的PHP扩展方式		**********/
	
	/**
	 * 旋转图片
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst			截取图保存路径  	加文件名
	 * @param   int     $angle			旋转角度		逆时针转    	正北  0度		正西 90度
	 * @param   int     $quality		截取图品质 100之内的正整数
	 * @return  boolean
	 **/
	private function rotate_imagick_class($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(! @is_file($src)){
			return false;
		}
		
		$angle 	= $args['angle'];
		$quality= $args['quality'];
		
		$image 	= new Imagick($src);
		$type = strtoupper($image->getImageFormat());
		$image->stripimage();
		$color_transparent = new ImagickPixel("transparent"); //透明色
		//如果是动画
		if($type == 'GIF'){
			$dest = new Imagick();
			foreach($image as $frame){
				$page = $frame->getImagePage();
	            $tmp = new Imagick(); 
	            $tmp->newImage($page['width'], $page['height'], $color_transparent, 'gif');
	            $tmp->compositeImage($frame, Imagick::COMPOSITE_OVER, $page['x'], $page['y']);
	                
	            $tmp->rotateImage($color_transparent,$angle);
	            $dest->addImage($tmp);
	            $dest->setImagePage($tmp->getImageWidth(), $tmp->getImageHeight(), 0, 0);
	            $dest->setImageDelay($frame->getImageDelay());
	            $dest->setImageDispose($frame->getImageDispose());
			}
			$dest->coalesceImages();
            $image = $dest;
			$image->writeimages($dst, true);
		}else{
			$image->rotateimage($color_transparent, $angle);
			$image->writeimage($dst);
		}
		$image->clear();
		$image->destroy();
		
		return is_file($dst) ? true : false;
	}
	
	private function image_info_imagick_class($src)
	{
		$image 	= new Imagick($src);
		$src_width = $image->getImageWidth();
        $src_height = $image->getImageHeight();
        $type = strtoupper($image->getImageFormat());
        
        return array(
        	'width'  => $src_width,
        	'height' => $src_height,
        	'type'   => $type
        );
	}
	
	/**
	 * 转图片格式返回图片流
	 * @param array $args
	 * @return Imagick
	 */
	private function convert_imagick_class($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dirpath 	= dirname($dst);

        if (! $this->mdir($dirpath)){
            return false;
        }
        
        $image 	= new Imagick($src);
        $src_width = $image->getImageWidth();
        $src_height = $image->getImageHeight();
        $image->setimageformat('jpg');
        $image->resizeimage($src_width, $src_height, imagick::FILTER_LANCZOS, 1);
        $image->writeimage($dst);
		$image->clear();
		$image->destroy();
		
		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片等比缩放(先等比例缩放，在左上角截取)
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $thumb_width	截取图宽度
	 * @param   int     $thumb_height	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function resize_two_imagick_class($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$resize_x	= intval($args['src_x']);
		$resize_y	= intval($args['src_y']);
		$dst_w	= intval($args['dst_w']);
		$dst_h	= intval($args['dst_h']);
		$quality= intval($args['quality']);
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src)){
			return false;
		}
		
		$image 	= new Imagick($src);
		$src_width = $image->getImageWidth();
        $src_height = $image->getImageHeight();
        $type = strtoupper($image->getImageFormat());

		$image->stripimage();
		
		//如果是动画
		if($type == 'GIF'){
			$color_transparent = new ImagickPixel("transparent"); //透明色
            $dest = new Imagick();
            //imagick本身有出入
            $data = getimagesize($src);
            $src_width = $data[0];
        	$src_height = $data[1];
        	
        	$ratio_w	= $dst_w/$src_width;
			$ratio_h	= $dst_h/$src_height;
        	
			foreach ($image as $frame){
				$page = $frame->getImagePage();
                $tmp = new Imagick(); 
                $tmp->newImage($page['width'], $page['height'], $color_transparent, 'gif');
                $tmp->compositeImage($frame, Imagick::COMPOSITE_OVER, $page['x'], $page['y']);

				if($ratio_w>1 || $ratio_h>1){
					if($ratio_w>1 && $ratio_h<1){
						$tmp->cropthumbnailimage($src_width, $dst_h);
					}else if($ratio_h>1 && $ratio_w<1){
						$tmp->cropthumbnailimage($dst_w, $src_height);
					}else{
						$tmp->cropimage($src_width, $src_height, $resize_x, $resize_y);
					}
				}else if($ratio_w>=$ratio_h){
					$resize_width	= ceil($src_width * $ratio_w);
					$resize_height	= ceil($src_height * $ratio_w);
					$resize_y       = floor(($resize_height/2)-($dst_h/2));
					
					$tmp->cropthumbnailimage($resize_width, $resize_height);
					//$tmp->cropimage($dst_w, $dst_h, 0, 0);
					$tmp->cropimage($dst_w, $dst_h, $resize_x, $resize_y);
				}else if($ratio_w<=$ratio_h){
					$resize_width	= ceil($src_width * $ratio_h);
					$resize_height	= ceil($src_height * $ratio_h);
					$resize_x       = floor(($resize_width/2)-($dst_w/2));
					
					$tmp->cropthumbnailimage($resize_width, $resize_height);
					//$tmp->cropimage($dst_w, $dst_h, 0, 0);
					$tmp->cropimage($dst_w, $dst_h, $resize_x, $resize_y);
				}
				
				$dest->addImage($tmp);
                $dest->setImagePage($tmp->getImageWidth(), $tmp->getImageHeight(), 0, 0);
                $dest->setImageDelay($frame->getImageDelay());
                $dest->setImageDispose($frame->getImageDispose());
			}
			$dest->coalesceImages();
            $image = $dest;
			$image->writeimages($dst, true);
		}else{
			
			$ratio_w	= $dst_w/$src_width;
			$ratio_h	= $dst_h/$src_height;
			
			if($ratio_w>1 || $ratio_h>1){
				if($ratio_w>1 && $ratio_h<1){
					$resize_y       = floor(($src_height/2)-($dst_h/2));
					//$image->cropimage($src_width, $dst_h, $resize_x, 0);
					$image->cropimage($src_width, $dst_h, $resize_x, $resize_y);
				}else if($ratio_h>1 && $ratio_w<1){
					$resize_x = floor(($src_width/2)-($dst_w/2));
					//$image->cropimage($dst_w, $src_height, 0, $resize_y);
					$image->cropimage($dst_w, $src_height, $resize_x, $resize_y);
				}else{
					$image->cropimage($src_width, $src_height, $resize_x, $resize_y);
				}
			}else if($ratio_w>=$ratio_h){
				$resize_width	= ceil($src_width * $ratio_w);
				$resize_height	= ceil($src_height * $ratio_w);
				$resize_y       = floor(($resize_height/2)-($dst_h/2));
				
				$image->cropthumbnailimage($resize_width, $resize_height);
				//$image->cropimage($dst_w, $dst_h, 0, 0);
				$image->cropimage($dst_w, $dst_h, $resize_x, $resize_y);
			}else if($ratio_w<=$ratio_h){
				$resize_width	= ceil($src_width * $ratio_h);
				$resize_height	= ceil($src_height * $ratio_h);
				$resize_x       = floor(($resize_width/2)-($dst_w/2));
				
				$image->cropthumbnailimage($resize_width, $resize_height);
				//$image->cropimage($dst_w, $dst_h, 0, 0);
				$image->cropimage($dst_w, $dst_h, $resize_x, $resize_y);
			}
			$image->writeimage($dst);
		}
		$image->clear();
		$image->destroy();

		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片等比缩放
	 * 
	 * @$src            原图片路径		加文件名
	 * @$dst            截取图保存路径  	加文件名
	 * @$thumb_width	截取图宽度
	 * @$thumb_height	截取图高度
	 * @$quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function resize_ratio_imagick_class($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$resize_x	= intval($args['src_x']);
		$resize_y	= intval($args['src_y']);
		$dst_w	= intval($args['dst_w']);
		$dst_h	= intval($args['dst_h']);
		$quality= intval($args['quality']);
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
		
		$image 	= new Imagick($src);

		$type = strtoupper($image->getImageFormat());
		$image->stripimage();

		//如果是动画
		if($type == 'GIF'){
			$color_transparent = new ImagickPixel("transparent"); //透明色
            $dest = new Imagick();
            //imagick本身有出入
            $data = getimagesize($src);
            $src_width = $data[0];
        	$src_height = $data[1];
        	
        	$ratio_w	= $dst_w/$src_width;
			$ratio_h	= $dst_h/$src_height;     

			if($dst_w >= $src_width && $dst_h >= $src_height){
			    $resize_width	= $src_width;
				$resize_height	= $src_height;
			}else if($ratio_w>=$ratio_h){
				$resize_width	= ceil($src_width * $ratio_h);
				$resize_height	= ceil($src_height * $ratio_h);
			}else if($ratio_w<=$ratio_h){
				$resize_width	= ceil($src_width * $ratio_w);
				$resize_height	= ceil($src_height * $ratio_w);
			}
            
			foreach ($image as $frame){
				$page = $frame->getImagePage();
                $tmp = new Imagick(); 
                $tmp->newImage($page['width'], $page['height'], $color_transparent, 'gif');
                $tmp->compositeImage($frame, Imagick::COMPOSITE_OVER, $page['x'], $page['y']);
                $tmp->cropthumbnailimage($resize_width, $resize_height);
                $dest->addImage($tmp);
                $dest->setImagePage($tmp->getImageWidth(), $tmp->getImageHeight(), 0, 0);
                $dest->setImageDelay($frame->getImageDelay());
                $dest->setImageDispose($frame->getImageDispose());
			}
			
			$dest->coalesceImages();
			$image = $dest;
			$image->writeimages($dst, true);
		}else{
			$src_width = $image->getImageWidth();
	        $src_height = $image->getImageHeight();
	        
			$ratio_w	= $dst_w/$src_width;
			$ratio_h	= $dst_h/$src_height;
			
			if($dst_w >= $src_width && $dst_h >= $src_height){
			    $resize_width	= $src_width;
				$resize_height	= $src_height;
			}else if($ratio_w>=$ratio_h){
				$resize_width	= ceil($src_width * $ratio_h);
				$resize_height	= ceil($src_height * $ratio_h);
			}else if($ratio_w<=$ratio_h){
				$resize_width	= ceil($src_width * $ratio_w);
				$resize_height	= ceil($src_height * $ratio_w);
			}
			
			$image->cropthumbnailimage($resize_width, $resize_height);
			$image->writeimage($dst);
		}
		
		$image->clear();
		$image->destroy();

		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片缩放 (先等比例缩放，在从左上角截取，宽高不大于设置的大小)
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_h		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @param   string  $abs_position   标准
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	private function resize_abs_imagick_class($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$resize_x	= intval($args['src_x']);
		$resize_y	= intval($args['src_y']);
		$dst_w	= intval($args['dst_w']);
		$dst_h	= intval($args['dst_h']);
		$quality= intval($args['quality']);
		$abs_position = $args['abs_position'];
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
		
		$image 	= new Imagick($src);

		$type = strtoupper($image->getImageFormat());
		$image->stripimage();

		//如果是动画
		if($type == 'GIF'){
			$color_transparent = new ImagickPixel("transparent");
            $dest = new Imagick();
            //imagick本身有出入
            $data = getimagesize($src);
            $src_width = $data[0];
        	$src_height = $data[1];
        	
        	if($abs_position == 'x'){
        		$resize_width	= $dst_w;
        		if($src_width >= $dst_w){
        			$ratio_w = $dst_w/$src_width;
        		}else{
        			$ratio_w = $src_width/$dst_w;
        		}
        		$resize_height	= $ratio_w * $src_height > $dst_h ? $ratio_w * $src_height : $dst_h;
        	}else{
        		$resize_height	= $dst_h;
        		if($src_height >= $dst_h){
        			$ratio_h = $dst_h/$src_height;
        		}else{
        			$ratio_h = $src_height/$dst_h;
        		}
        		$resize_width	= $ratio_h * $src_width > $dst_w ? $ratio_h * $src_width : $dst_w;
        	}

			foreach ($image as $frame){
				$page = $frame->getImagePage();
                $tmp = new Imagick(); 
                $tmp->newImage($page['width'], $page['height'], $color_transparent, 'gif');
                $tmp->compositeImage($frame, Imagick::COMPOSITE_OVER, $page['x'], $page['y']);
                $tmp->cropthumbnailimage($resize_width, $resize_height);
                $dest->addImage($tmp);
                $dest->setImagePage($tmp->getImageWidth(), $tmp->getImageHeight(), 0, 0);
                $dest->setImageDelay($frame->getImageDelay());
                $dest->setImageDispose($frame->getImageDispose());
			}
			
			$dest->coalesceImages();
			$image = $dest;
			$image->writeimages($dst, true);
		}else{
			$src_width = $image->getImageWidth();
	        $src_height = $image->getImageHeight();
	        
			if($abs_position == 'x'){
        		$resize_width	= $dst_w;
        		if($src_width >= $dst_w){
        			$ratio_w = $dst_w/$src_width;
        		}else{
        			$ratio_w = $src_width/$dst_w;
        		}
        		$resize_height	= $ratio_w * $src_height > $dst_h ? $ratio_w * $src_height : $dst_h;
        	}else{
        		$resize_height	= $dst_h;
        		if($src_height >= $dst_h){
        			$ratio_h = $dst_h/$src_height;
        		}else{
        			$ratio_h = $src_height/$dst_h;
        		}
        		$resize_width	= $ratio_h * $src_width > $dst_w ? $ratio_h * $src_width : $dst_w;
        	}
			
			$image->cropthumbnailimage($resize_width, $resize_height);
			$image->writeimage($dst);
		}
		
		$image->clear();
		$image->destroy();

		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片缩放 (先等比例缩放，在从左上角截取，宽等于默认值，高按比例随机)
	 * 
	 * @param   string  $src            原图片路径		加文件名
	 * @param   string  $dst            截取图保存路径  	加文件名
	 * @param   int     $dst_w		          截取图宽度
	 * @param   int     $dst_h		   	截取图高度
	 * @param   int     $quality        截取图品质 100之内的正整数
	 * @param   string  $abs_position   标准
	 * @return  boolean 成功返回 true 失败返回 false
	 **/
	private function resize_water_imagick_class($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$dst_w	= intval($args['dst_w']);
		$dst_h	= intval($args['dst_h']);
		$quality= intval($args['quality']);
		$abs_position = $args['abs_position'];
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
		
		$image 	= new Imagick($src);

		$type = strtoupper($image->getImageFormat());
		$image->stripimage();

		//如果是动画
		if($type == 'GIF'){
			$color_transparent = new ImagickPixel("transparent");
            $dest = new Imagick();
            //imagick本身有出入
            $data = getimagesize($src);
            $src_width = $data[0];
        	$src_height = $data[1];
        	
        	if($abs_position == 'x'){
        		$resize_width	= $dst_w;
        		if($src_width >= $dst_w){
        			$ratio_w = $dst_w/$src_width;
        		}else{
        			$resize_width = $src_width;
        			$ratio_w = 1;
        		}
        		$resize_height	= $ratio_w * $src_height;
        	}else{
        		$resize_height	= $dst_h;
        		if($src_height >= $dst_h){
        			$ratio_h = $dst_h/$src_height;
        		}else{
        			$resize_height = $src_height;
        			$ratio_h = 1;
        		}
        		$resize_width	= $ratio_h * $src_width;
        	}

			foreach ($image as $frame){
				$page = $frame->getImagePage();
                $tmp = new Imagick(); 
                $tmp->newImage($page['width'], $page['height'], $color_transparent, 'gif');
                $tmp->compositeImage($frame, Imagick::COMPOSITE_OVER, $page['x'], $page['y']);
                $tmp->cropthumbnailimage($resize_width, $resize_height);
                $dest->addImage($tmp);
                $dest->setImagePage($tmp->getImageWidth(), $tmp->getImageHeight(), 0, 0);
                $dest->setImageDelay($frame->getImageDelay());
                $dest->setImageDispose($frame->getImageDispose());
			}
			
			$dest->coalesceImages();
			$image = $dest;
			$image->writeimages($dst, true);
		}else{
			$src_width = $image->getImageWidth();
	        $src_height = $image->getImageHeight();
	        
			if($abs_position == 'x'){
        		$resize_width	= $dst_w;
        		if($src_width >= $dst_w){
        			$ratio_w = $dst_w/$src_width;
        		}else{
        			$resize_width = $src_width;
        			$ratio_w = 1;
        		}
        		$resize_height	= $ratio_w * $src_height;
        	}else{
        		$resize_height	= $dst_h;
        		if($src_height >= $dst_h){
        			$ratio_h = $dst_h/$src_height;
        		}else{
        			$resize_height = $src_height;
        			$ratio_h = 1;
        		}
        		$resize_width	= $ratio_h * $src_width;
        	}
			
			$image->cropthumbnailimage($resize_width, $resize_height);
			$image->writeimage($dst);
		}
		
		$image->clear();
		$image->destroy();

		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片等比缩放，与resize区分之处，宽高最小为规定的缩略图
	 * 
	 * @$src            原图片路径		加文件名
	 * @$dst            截取图保存路径  	加文件名
	 * @$thumb_width	截取图宽度
	 * @$thumb_height	截取图高度
	 * @$quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function crop_imagick_class($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$resize_x	= intval($args['src_x']);
		$resize_y	= intval($args['src_y']);
		$dst_w	= intval($args['dst_w']);
		$dst_h	= intval($args['dst_h']);
		$quality= intval($args['quality']);
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
		
		$image 	= new Imagick($src);

		$type = strtoupper($image->getImageFormat());
		$image->stripimage();

		//如果是动画
		if($type == 'GIF'){
			$color_transparent = new ImagickPixel("transparent"); //透明色
            $dest = new Imagick();
            //imagick本身有出入
            $data = getimagesize($src);
            $src_width = $data[0];
        	$src_height = $data[1];  
        	
        	$resize_width = $src_width - $resize_x > $dst_w ? $dst_w : $src_width - $resize_x;
        	$resize_height = $src_height - $resize_y > $dst_h ? $dst_h : $src_height - $resize_y;
            
			foreach ($image as $frame){
				$page = $frame->getImagePage();
                $tmp = new Imagick(); 
                $tmp->newImage($page['width'], $page['height'], $color_transparent, 'gif');
                $tmp->compositeImage($frame, Imagick::COMPOSITE_OVER, $page['x'], $page['y']);
                $tmp->cropimage($resize_width, $resize_height, $resize_x, $resize_y);
                $dest->addImage($tmp);
                $dest->setImagePage($tmp->getImageWidth(), $tmp->getImageHeight(), 0, 0);
                $dest->setImageDelay($frame->getImageDelay());
                $dest->setImageDispose($frame->getImageDispose());
			}
			
			$dest->coalesceImages();
			$image = $dest;
			$image->writeimages($dst, true);
		}else{
			$src_width = $image->getImageWidth();
	        $src_height = $image->getImageHeight();
	        
			$resize_width = $src_width - $resize_x > $dst_w ? $dst_w : $src_width - $resize_x;
        	$resize_height = $src_height - $resize_y > $dst_h ? $dst_h : $src_height - $resize_y;
			
			$image->cropimage($resize_width, $resize_height, $resize_x, $resize_y);
			$image->writeimage($dst);
		}
		
		$image->clear();
		$image->destroy();

		return is_file($dst) ? true : false;
	}
	
	/**
	 * 图片等比缩放，与resize区分之处，宽高最小为规定的缩略图
	 * 
	 * @$src            原图片路径		加文件名
	 * @$dst            截取图保存路径  	加文件名
	 * @$thumb_width	截取图宽度
	 * @$thumb_height	截取图高度
	 * @$quality        截取图品质 100之内的正整数
	 * @return  boolean 成功返回 true 失败返回 false
	 */
	private function crop_ratio_imagick_class($args)
	{
		$src 	= $args['src'];
		$dst	= $args['dst'];
		$resize_x	= intval($args['src_x']);
		$resize_y	= intval($args['src_y']);
		$dst_w	= intval($args['dst_w']);
		$dst_h	= intval($args['dst_h']);
		$quality= intval($args['quality']);
		
		$dirpath 	= dirname($dst);
        if (! $this->mdir($dirpath)){
            return false;
        }
		if(!is_file($src) ){
			return false;
		}
		
		$image 	= new Imagick($src);

		$type = strtoupper($image->getImageFormat());
		$image->stripimage();

		//如果是动画
		if($type == 'GIF'){
			$color_transparent = new ImagickPixel("transparent"); //透明色
            $dest = new Imagick();
            //imagick本身有出入
            $data = getimagesize($src);
            $src_width = $data[0];
        	$src_height = $data[1];
        	
        	$ratio_w	= $dst_w/$src_width;
			$ratio_h	= $dst_h/$src_height;     

			if($dst_w >= $src_width && $dst_h >= $src_height){
			    $resize_width	= $src_width;
				$resize_height	= $src_height;
			}elseif($ratio_w>=$ratio_h){
				$resize_width	= ceil($src_width * $ratio_w);
				$resize_height	= ceil($src_height * $ratio_w);
			}else if($ratio_w<=$ratio_h){
				$resize_width	= ceil($src_width * $ratio_h);
				$resize_height	= ceil($src_height * $ratio_h);
			}
            
			foreach ($image as $frame){
				$page = $frame->getImagePage();
                $tmp = new Imagick(); 
                $tmp->newImage($page['width'], $page['height'], $color_transparent, 'gif');
                $tmp->compositeImage($frame, Imagick::COMPOSITE_OVER, $page['x'], $page['y']);
                $tmp->cropthumbnailimage($resize_width, $resize_height);
                $dest->addImage($tmp);
                $dest->setImagePage($tmp->getImageWidth(), $tmp->getImageHeight(), 0, 0);
                $dest->setImageDelay($frame->getImageDelay());
                $dest->setImageDispose($frame->getImageDispose());
			}
			
			$dest->coalesceImages();
			$image = $dest;
			$image->writeimages($dst, true);
		}else{
			$src_width = $image->getImageWidth();
	        $src_height = $image->getImageHeight();
	        
			$ratio_w	= $dst_w/$src_width;
			$ratio_h	= $dst_h/$src_height;
			
			if($dst_w >= $src_width && $dst_h >= $src_height){
			    $resize_width	= $src_width;
				$resize_height	= $src_height;
			}elseif($ratio_w>=$ratio_h){
				$resize_width	= ceil($src_width * $ratio_w);
				$resize_height	= ceil($src_height * $ratio_w);
			}else if($ratio_w<=$ratio_h){
				$resize_width	= ceil($src_width * $ratio_h);
				$resize_height	= ceil($src_height * $ratio_h);
			}
			
			$image->cropthumbnailimage($resize_width, $resize_height);
			$image->writeimage($dst);
		}
		
		$image->clear();
		$image->destroy();

		return is_file($dst) ? true : false;
	}
	/*******		   imagick的PHP扩展方式		**********/
}
