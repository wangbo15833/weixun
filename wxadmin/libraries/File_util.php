<?php
/**
 * 操纵文件函数
 * 
 * 例子：
 * createDir('a/1/2/3');                   测试建立文件夹     建一个a/1/2/3文件夹
 * createFile('b/1/2/3');                  测试建立文件       在b/1/2/文件夹下面建一个3文件
 * createFile('b/1/2/3.exe');              测试建立文件       在b/1/2/文件夹下面建一个3.exe文件
 * copyDir('b','d/e');                     测试复制文件夹     建立一个d/e文件夹，把b文件夹下的内容复制进去
 * copyFile('b/1/2/3.exe','b/b/3.exe');    测试复制文件       建立一个b/b文件夹，并把b/1/2文件夹中的3.exe文件复制进去
 * moveDir('a/','b/c');                    测试移动文件夹     建立一个b/c文件夹,并把a文件夹下的内容移动进去，并删除a文件夹
 * moveFile('b/1/2/3.exe','b/d/3.exe');    测试移动文件       建立一个b/d文件夹，并把b/1/2中的3.exe移动进去                    
 * unlinkFile('b/d/3.exe');                测试删除文件       删除b/d/3.exe文件
 * unlinkDir('d');                         测试删除文件夹     删除d文件夹
 */
 
class File_util{
 
/**
 * 建立文件夹
 *
 * @param    string $aimUrl
 * @return    viod
 */
function createDir($aimUrl) 
{
	if (file_exists($aimUrl)) {
		return ;
	}
    $aimUrl = str_replace('\\', '/', $aimUrl);
    $aimDir = '';
    $arr = explode('/', $aimUrl);
    foreach ($arr as $str) 
    {
        $aimDir .= $str . '/';
        if (!file_exists($aimDir)) {
            mkdir($aimDir);
            chmod($aimDir, 0777);
        }
    }
}

/**
 * 建立文件
 *
 * @param    string    $aimUrl 
 * @param    boolean    $overWrite 该参数控制是否覆盖原文件
 * @return    boolean
 */
function createFile($aimUrl, $overWrite = false) 
{
    if (file_exists($aimUrl) && $overWrite == false) {
        return false;
    } 
    elseif (file_exists($aimUrl) && $overWrite == true) {
        unlinkFile($aimUrl);
    }
    $aimDir = dirname($aimUrl);
    createDir($aimDir);
    touch($aimUrl);
    chmod($aimUrl, 0777);
    return true;
}

/**
 * 移动文件夹
 *
 * @param    string    $oldDir
 * @param    string    $aimDir
 * @param    boolean    $overWrite 该参数控制是否覆盖原文件
 * @return    boolean
 */
function moveDir($oldDir, $aimDir, $overWrite = false) 
{
    $aimDir = str_replace('\\', '/', $aimDir);
    $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir . '/';
    $oldDir = str_replace('\\', '/', $oldDir);
    $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir . '/';
    if (!is_dir($oldDir)) {
        return false;
    }
    if (!file_exists($aimDir)) {
        createDir($aimDir);
    }
    @$dirHandle = opendir($oldDir);
    if (!$dirHandle) {
        return false;
    }
    while(false !== ($file = readdir($dirHandle))) 
    {
        if ($file == '.' || $file == '..') {
            continue;
        }
        if (!is_dir($oldDir.$file)) {
            moveFile($oldDir . $file, $aimDir . $file, $overWrite);
        } 
        else {
            moveDir($oldDir . $file, $aimDir . $file, $overWrite);
        }
    }
    closedir($dirHandle);
    return rmdir($oldDir);
}

/**
 * 移动文件
 *
 * @param    string    $fileUrl
 * @param    string    $aimUrl
 * @param    boolean    $overWrite 该参数控制是否覆盖原文件
 * @return    boolean
 */
function moveFile($fileUrl, $aimUrl, $overWrite = false) 
{
    if (!file_exists($fileUrl)) {
        return false;
    }
    if (file_exists($aimUrl) && $overWrite = false) {
        return false;
    }
    elseif (file_exists($aimUrl) && $overWrite = true) {
        unlinkFile($aimUrl);
    }
    $aimDir = dirname($aimUrl);
    createDir($aimDir);
    rename($fileUrl, $aimUrl);
    return true;
}

/**
 * 删除文件夹
 *
 * @param    string    $aimDir
 * @return    boolean
 */
function unlinkDir($aimDir) 
{
    $aimDir = str_replace('\\', '/', $aimDir);
    $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir.'/';
    if (!is_dir($aimDir)) {
        return false;
    }
    $dirHandle = opendir($aimDir);
    while(false !== ($file = readdir($dirHandle))) 
    {
        if ($file == '.' || $file == '..') {
            continue;
        }
        if (!is_dir($aimDir.$file)) {
            unlinkFile($aimDir . $file);
        } else {
            unlinkDir($aimDir . $file);
        }
    }
    closedir($dirHandle);
    return rmdir($aimDir);
}

/**
 * 删除文件
 *
 * @param    string    $aimUrl
 * @return    boolean
 */
function unlinkFile($aimUrl) 
{
    if (file_exists($aimUrl)) {
        unlink($aimUrl);
        return true;
    } 
    else {
        return false;
    }
}

/**
 * 复制文件夹
 *
 * @param    string    $oldDir
 * @param    string    $aimDir
 * @param    boolean    $overWrite 该参数控制是否覆盖原文件
 * @return    boolean
 */
function copyDir($oldDir, $aimDir, $overWrite = false) 
{
    $aimDir = str_replace('\\', '/', $aimDir);
    $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir.'/';
    $oldDir = str_replace('\\', '/', $oldDir);
    $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir.'/';
    if (!is_dir($oldDir)) {
        return false;
    }
    if (!file_exists($aimDir)) {
        createDir($aimDir);
    }
    $dirHandle = opendir($oldDir);
    while(false !== ($file = readdir($dirHandle))) 
    {
        if ($file == '.' || $file == '..') {
            continue;
        }
        if (!is_dir($oldDir . $file)) {
            copyFile($oldDir . $file, $aimDir . $file, $overWrite);
        } 
        else {
            copyDir($oldDir . $file, $aimDir . $file, $overWrite);
        }
    }
    return closedir($dirHandle);
}

/**
 * 复制文件
 *
 * @param    string    $fileUrl
 * @param    string    $aimUrl
 * @param    boolean    $overWrite 该参数控制是否覆盖原文件
 * @return    boolean
 */
function copyFile($fileUrl, $aimUrl, $overWrite = false) 
{
    if (!file_exists($fileUrl)) {
        return false;
    }
    if (file_exists($aimUrl) && $overWrite == false) {
        return false;
    } 
    elseif (file_exists($aimUrl) && $overWrite == true) {
        unlinkFile($aimUrl);
    }
    $aimDir = dirname($aimUrl);
    createDir($aimDir);
    copy($fileUrl, $aimUrl);
    return true;
}

/**
 * 写入日志文件, 可以文件自动分割大小
 *
 * @param string $path 文件的绝对路径
 * @param string $content 写入的内容
 * @param boolean $output 是否输出内容默认 false 不输出
 * @param int $fileMaxSize 文件分割大小 单位(KB) 默认为空则不分个
 * @return boolean
 * 采集数据路径
 * 
 */
function writeLog($path, $content, $fileMaxSize = null, $output = false)
{
	global $_SGLOBAL;
	if(is_int($path)){
		if($path ==1){
			$path ="/log/error.log"; //错误日志
		}else if($path ==2){
			$path = "/log/collect_tuan.log"; //采集日志
		}	
	}
	$path = $_SGLOBAL['webpath'].$path;
	//echo $path;
    if (is_dir(dirname($path))) 
    {
        if (! empty($fileMaxSize) && file_exists($path)) 
        {
            // 文件大小 单位 KB
            $size = intval(filesize($path)/1000);
            if ($size > $fileMaxSize) {
                $newName = str_replace('.'.getFileType($path), date('YmdHis').'.'.getFileType($path), $path);
                moveFile($path, $newName);
            }
        }
        
        $time = date('Y/m/d H:i:s');
        
        if ($output) {
            echo str_repeat(' ',4096); // 确保足够的字符,立即输出
            echo $time. ', ' . $content . '<br><br>';
            ob_flush();
            flush();
        }

        return error_log($time . ', ' . $content . "\n\n", 3, $path);
    }
    else {
        return false;
    }
}

/**
 * 即使输出显示内容
 *
 * @param string $content 输出内容
 */
function outputFlush($content)
{
    // 确保足够的字符, 大于缓冲区容量, 让内容立即输出
    echo str_repeat(' ', 15000);
    echo date('Y/m/d H:i:s'). ', ' . $content . '<br><br>';
}

/**
 * 获取文件类型后缀名
 *
 * @param string $filename
 * @return string
 */
function getFileType($filename) 
{ 
    $type = pathinfo($filename); 
    $type = strtolower($type["extension"]); 
    return $type; 
}

/**
 * 获取远程链接内容
 *
 * @param string $url 远程网址
 * @param string $charset 目标网页的编码格式 默认为 UTF-8 则无须转码
 * @param string $spoofing 是否伪造ip网址来源
 * @return string
 */
function getContents($url, $charset = 'UTF-8', $spoofing = true)
{
    $ch = curl_init();
    $timeout = 10;
    
    // 获取伪造来源ip网址
    if ($spoofing) {
        $header = getSpoofingHeader($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
    $contents = trim(curl_exec($ch));
    curl_close($ch);

    //return ($charset == 'UTF-8') ? $contents : iconv($charset, 'UTF-8', $contents);
    $contents = ($charset == 'UTF-8') ? $contents : mb_convert_encoding($contents, 'UTF-8', $charset);
    return str_replace(array('??','^'), '', $contents);
}

/**
 * 获取伪造来源ip网址 header 信息
 * 
 * @param string $url 来源网址
 * @param string $myIp 来源ip
 * @return array 返回伪造后的 header
 */
function getSpoofingHeader($url, $myIp = null)
{
	
    // 分解url
    $temp = parse_url($url);
    $query = isset($temp['query']) ? $temp['query'] : '';
    // 随机ip
    if (! $myIp) {
        $myIp = randIp();
    }
    
    $cookies= '';
    if(count($_COOKIE)) {
        foreach($_COOKIE as $cookie_name => $cookie_var) {
            $cookies .= $cookies != '' ? '; '.$cookie_name.'='.$cookie_var :$cookie_name.'='.$cookie_var;
        }
    }
    
    $header = array (
        "GET {$temp['path']}?{$query} HTTP/1.1",
        "Host: {$temp['host']}", 
        'Accept: */*', 
        "Referer: http://{$temp['host']}/",
        "Cookie: $cookies",
        'User-Agent: Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1)', 
        'via: 1.1 JEJE1:80 (squid/2.5.STABLE4-NT-CVS)',
        "X-Forwarded-For: $myIp",
        "Connection: Close"
    );

    return $header;
}

/**
 * 上传文件
 *
 * @param array $arrFile 表单 form 提交的文件信息
 * @param int $maxSize 文件最大容量大小
 * @return array
 * <form action="testhtml.php" method="post"  enctype="multipart/form-data">
 *		<input type="file" name="file" />
 * </form>
 * 
 */
function uploadFile($arrFile,$destFile,$isImg = false,$maxSize=524288)
{
	if($isImg){
		$type = $arrFile['type'];
		$arrSecType=array('image/pjpeg'=>'jpg','image/jpeg'=>'jpg','image/x-png'=>'png','image/gif'=>'gif','image/bmp'=>'bmp');
		if (array_key_exists($type,$arrSecType) == false) {
			$arrMsg['error'] = '上传文件格式错误';
			return $arrMsg;
		}
	}
	
	$fileSplitCharIndex = strripos($destFile,'/');
	$aimDir = dirname($destFile);
		if (!file_exists($aimDir)) {
			createDir($aimDir); //创建文件夹
		}
	$aimFileName = substr($destFile,$fileSplitCharIndex+1);
	
	$extName = $arrSecType[$type];
	$size = $arrFile['size'];
	
	if ($size > $maxSize) {
		$arrMsg['error'] = '上传文件太大，不能超过'. ($maxSize/1024) . 'KB';
		return $arrMsg;
	}
	
	if (!file_exists($aimDir)) {
		createDir($aimDir); //创建文件夹
	}
	if (! file_exists($aimDir)) {
		$arrMsg['error'] = '上传文件目录不存在, 或不可写';
		return $arrMsg;
	}
	
	if (is_uploaded_file($arrFile['tmp_name'])) 
	{
	    if (! preg_match('/\/$/', $aimDir)) {
	        $aimDir = $aimDir . '/';
	    }
		if (move_uploaded_file($arrFile['tmp_name'],$aimDir . $aimFileName . '.' . $extName)) {
			$arrMsg['loadSucceed'] = $aimFileName. '.' . $extName;
			return $arrMsg;
		}
		else {
			$arrMsg['error'] = '移动文件出错, 请稍候再试';
			return $arrMsg;
		}
	}
	else {
		$arrMsg['error'] = '上传文件出错, 请稍候再试';
		return $arrMsg;
	}
}

/**
 * 获取随机ip
 *
 * @return string
 */
function randIp()
{
    $ip2id = round(rand(600000, 2550000) / 10000); //第一种方法，直接生成
    $ip3id = round(rand(600000, 2550000) / 10000); 
    $ip4id = round(rand(600000, 2550000) / 10000); 

    //下面是第二种方法，在以下数据中随机抽取
    $arr_1 = array('218','218','66','66','218','218','60','60','202','204','66','66','66','59','61','60','222','221','66','59','60','60','66','218','218','62','63','64','66','66','122','211');
    $randarr = mt_rand(0,count($arr_1)-1);
    $ip1id = $arr_1[$randarr];
    
    $ip = $ip1id . '.' . $ip2id . '.' . $ip3id . '.' . $ip4id;

    return $ip;
}

/**
 * session 安全验证码生成
 *
 * @param string $name session名称
 * @param int $width
 * @param int $height
 * @param int $size
 */
function safeCode($name = 'safeCode', $width = 56, $height = 17, $size = 4)
{
    header('Counter-type:image/gif');
    
    $str = 'ABDEFHJKMNPRTUXY346789';
    $strLength = strlen($str);
    
    $strSafeCode = '';
    for ($i=1; $i<=$size; $i++) {
    	$strSafeCode .= substr($str, rand(0, $strLength-1), 1);
    }
    
    $_SESSION[$name] = $strSafeCode;
    
    $img = imagecreate($width, $height);
    
    $color = imagecolorallocate($img, 255, 255, 255);
    		
    for($i=0; $i<strlen($strSafeCode); $i++) {
    	$fontcolor = imagecolorallocate($img, rand($i+50, $i+20), rand($i+50, $i+20), rand($i+50, $i+20));
    	imagestring($img, 5, 10*$i+8, rand(1, 3), substr($strSafeCode, $i, 1), $fontcolor);
    }
    
    for ($i=1; $i<=100; $i++) {
    	$x = rand(1, 60);
    	$y = rand(1, 60);
    	imagesetpixel($img, $x, $y, 1);
    }
    
    imagegif($img);
    
    imagedestroy($img);
}

function downFile($fileName, $content)
{
    @ob_end_clean();
	header("Content-Encoding: none");
	header("Content-Type: application/force-download;charset=utf-8");
	header("Content-Disposition: attachment; filename=$fileName");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $content;
	$tmp = ob_get_contents();
	@ob_end_clean();
	exit();
}

/********************* image oper start*****************************/

/**
 * 生成缩略图
 * $destfileArr 目标文件数组
 * $wh 目标文件长宽数组
 */
function makeThumb($srcfile,$destfileArr,$whArr,$waterfile='') {
	global $_SGLOBAL;

	//判断文件是否存在
	if (!file_exists($srcfile)) {
		return '';
	}
	
	//检查文件夹是否存在
	foreach($destfileArr as $r){
		$aimDir = dirname($r);
		if (!file_exists($aimDir)) {
			createDir($aimDir); //创建文件夹
		}
	}
	
	//获取图片信息
	$im = getImageSizeInfo($srcfile);
	if(!$im) return '';
	$srcw = imagesx($im);
	$srch = imagesy($im);
	//循环截图
	$i = 0;
	$errorMake = 0;
	foreach($destfileArr as $r){
		if("error" == cutImgFile($srcfile,$im,$srcw,$srch,$whArr[$i][0],$whArr[$i][1],$r,$waterfile)){
			$errorMake += 1;
		}
		$i+=1;
	}
	imagedestroy($im);
	if($errorMake > 0){
		return $errorMake;
	}else{
		return "ok";
	}
}

/**
 * 截取图片
 * $im getImageSizeInfo
 * $srcw 源图宽
 * $tow  目标图宽
 * $dstfile 目标图上文件
 * $waterfile 为空则表示不加水印，只有当图片长宽超过300才加水印
 */
function cutImgFile($srcfile,$im,$srcw,$srch,$tow,$toh,$dstfile,$waterfile){
	global $_SGLOBAL;
	$towh = $tow/$toh;
	$srcwh = $srcw/$srch;
	if($towh <= $srcwh){
		$ftow = $tow;
		$ftoh = $ftow*($srch/$srcw);
	} else {
		$ftoh = $toh;
		$ftow = $ftoh*($srcw/$srch);
	}
	
	if($srcw > $tow || $srch > $toh) {
		if(function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && @$ni = imagecreatetruecolor($ftow, $ftoh)) {
			imagecopyresampled($ni, $im, 0, 0, 0, 0, $ftow, $ftoh, $srcw, $srch);
		} elseif(function_exists("imagecreate") && function_exists("imagecopyresized") && @$ni = imagecreate($ftow, $ftoh)) {
			imagecopyresized($ni, $im, 0, 0, 0, 0, $ftow, $ftoh, $srcw, $srch);
		} else {
			return 'error';
		}
		if(function_exists('imagejpeg')) {
			imagejpeg($ni, $dstfile);
		}elseif(function_exists('imagepng')) {
			imagepng($ni, $dstfile);
		}
		imagedestroy($ni);
		
	}else{
		//当没有裁剪时复制一份
		copyFile($srcfile,$dstfile);
	}
	//检测是加水印
	if(!empty($waterfile)){
		//echo 'use waterfile'.$waterfile;
		makewatermark($dstfile,$waterfile,4);
	}
}

/**
 * 取得图片信息
 */
function getImageSizeInfo($srcfile){
	$im = '';
	if($data = getimagesize($srcfile)) {
		if($data[2] == 1) {
			$make_max = 0;//gif不处理
			if(function_exists("imagecreatefromgif")) {
				$im = imagecreatefromgif($srcfile);
			}
		} elseif($data[2] == 2) {
			if(function_exists("imagecreatefromjpeg")) {
				$im = imagecreatefromjpeg($srcfile);
			}
		} elseif($data[2] == 3) {
			if(function_exists("imagecreatefrompng")) {
				$im = imagecreatefrompng($srcfile);
			}
		}
	}
	return $im;
}

//图片水印
function makewatermark($srcfile,$watermarkfile,$imagePalce) {
	global $_SGLOBAL;
	
	//水印图片
    if(!file_exists($watermarkfile) || !$water_info = getimagesize($watermarkfile)) {
    	echo "waterremarkfile not exist the file path = ".$watermarkfile;
    	return '';
    }
   
    $water_w = $water_info[0];
    $water_h = $water_info[1];
    $water_im = '';
    switch($water_info[2]) {
        case 1:@$water_im = imagecreatefromgif($watermarkfile);break;
        case 2:@$water_im = imagecreatefromjpeg($watermarkfile);break;
        case 3:@$water_im = imagecreatefrompng($watermarkfile);break;
        default:break;
    }
	if(empty($water_im)) {
		 
		return '';
	}

    //原图
    if(!file_exists($srcfile) || !$src_info = getimagesize($srcfile)) {
    	return '';
    }
    $src_w = $src_info[0];
    $src_h = $src_info[1];
    $src_im = '';

    switch($src_info[2]) {
        case 1:
        	//判断是否为动画
        	$fp = fopen($srcfile, 'rb');
			$filecontent = fread($fp, filesize($srcfile));
			fclose($fp);
			if(strpos($filecontent, 'NETSCAPE2.0') === FALSE) {//动画图不加水印
        		@$src_im = imagecreatefromgif($srcfile);
			}
        	break;
        case 2:@$src_im = imagecreatefromjpeg($srcfile);break;
        case 3:@$src_im = imagecreatefrompng($srcfile);break;
        default:break;
    }
    if(empty($src_im)) {
    	return '';
    }

    //加水印的图片的长度或宽度比水印小150px
    if(($src_w < $water_w + 150) || ($src_h < $water_h + 150)) {
    	return '';
    }
	
    //位置
	switch($imagePalce) {
		case 1://顶端居左
			$posx = 0;
			$posy = 0;
			break;
		case 2://顶端居右
			$posx = $src_w - $water_w;
			$posy = 0;
			break;
		case 3://底端居左
			$posx = 0;
			$posy = $src_h - $water_h;
			break;
		case 4://底端居右
			$posx = $src_w - $water_w;
			$posy = $src_h - $water_h;
			break;
		default://随机
			$posx = mt_rand(0, ($src_w - $water_w));
			$posy = mt_rand(0, ($src_h - $water_h));
			break;
	}

    //设定图像的混色模式
	@imagealphablending($src_im, true);
	//拷贝水印到目标文件
	@imagecopy($src_im, $water_im, $posx, $posy, 0, 0, $water_w, $water_h);
    switch($src_info[2]) {
        case 1:@imagegif($src_im, $srcfile);break;
        case 2:@imagejpeg($src_im, $srcfile);break;
        case 3:@imagepng($src_im, $srcfile);break;
        default:return '';
    }
	@imagedestroy($water_im);
	@imagedestroy($src_im);
}

/*********************** image oper end***************************/
}