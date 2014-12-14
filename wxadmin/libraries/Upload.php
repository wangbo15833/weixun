/*
* @(#)UploadFile.php (beta) 2005/2/19
*
* exBlog上传附件类，可同时处理用户多个上传文件。效验文件有效性后存储至指定目录。
* 可返回上传文件的相关有用信息供其它程序使用。（如文件名、类型、大小、保存路径）
* 使用方法请见本类底部（UploadFile类使用注释）信息。
*/
class CI_Upload {
    
    var $user_post_file = array(); //用户上传的文件
    var $save_file_path;    //存放用户上传文件的路径
    var $max_file_size;     //文件最大尺寸
    var $last_error;     //记录最后一次出错信息
    //默认允许用户上传的文件类型
    var $allow_type = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/x-png');
    var $final_file_path; //最终保存的文件名
    
    var $save_info = array(); //返回一组有用信息，用于提示用户。
    
    /**
    * 构造函数，用与初始化相关信息，用户待上传文件、存储路径等
    *
    * @param Array $file 用户上传的文件
    * @param String $path 存储用户上传文件的路径
    * @param Integer $size 允许用户上传文件的大小(字节)
    * @param Array $type   此数组中存放允计用户上传的文件类型
    */
    function __construct($params) {
        $this->user_post_file = $params['file'];
        $this->save_file_path = $params['path'];
        if($params['size']!='')
        {
            $this->max_file_size = $params['size']; //如果用户不填写文件大小，则默认为2M.
        }
        else
        {
            $this->max_file_size = 2097152;
        }
        
        if ($params['type'] != '')
           $this->allow_type = $params['type'];
    }
    
    /**
    * 存储用户上传文件，检验合法性通过后，存储至指定位置。
    * @access public
    * @return int    值为0时上传失败，非0表示上传成功的个数。
    */
    function upload() {
    
    for ($i = 0; $i < count($this->user_post_file['name']); $i++) {
       //如果当前文件上传功能，则执行下一步。
       if ($this->user_post_file['error'][$i] == 0) {
        //取当前文件名、临时文件名、大小、扩展名，后面将用到。
        $name = $this->user_post_file['name'][$i];
        $tmpname = $this->user_post_file['tmp_name'][$i];
        $size = $this->user_post_file['size'][$i];
        $mime_type = $this->user_post_file['type'][$i];
        $type = $this->getFileExt($this->user_post_file['name'][$i]);
        //检测当前上传文件大小是否合法。
        if (!$this->checkSize($size)) {
         $this->last_error = "The file size is too big. File name is: ".$name;
         $this->halt($this->last_error);
         continue;
        }
        //检测当前上传文件扩展名是否合法。
        if (!$this->checkType($mime_type)) {
         $this->last_error = "Unallowable file type: .".$type." File name is: ".$name;
         $this->halt($this->last_error);
         continue;
        }
        //检测当前上传文件是否非法提交。
        if(!is_uploaded_file($tmpname)) {
         $this->last_error = "Invalid post file method. File name is: ".$name;
         $this->halt($this->last_error);
         continue;
        }
        //移动文件后，重命名文件用。
        $basename = $this->getBaseName($name, ".".$type);
        //移动后的文件名
        $saveas = time().".".$type;
        //组合新文件名再存到指定目录下，格式：存储路径 + 文件名 + 时间 + 扩展名
        $this->final_file_path = $this->save_file_path."/".$saveas;
        if(!move_uploaded_file($tmpname, $this->final_file_path)) {
         $this->last_error = $this->user_post_file['error'][$i];
         $this->halt($this->last_error);
         continue;
        }
        //存储当前文件的有关信息，以便其它程序调用。
        $this->save_info[] = array("name" => $saveas);
       }
    }
    return count($this->save_info); //返回上传成功的文件数目
    }
    
    /**
    * 返回一些有用的信息，以便用于其它地方。
    * @access public
    * @return Array 返回最终保存的路径
    */
    function getSaveInfo() {
    return $this->save_info;
    }
    
    /**
    * 检测用户提交文件大小是否合法
    * @param Integer $size 用户上传文件的大小
    * @access private
    * @return boolean 如果为true说明大小合法，反之不合法
    */
    function checkSize($size) {
    if ($size > $this->max_file_size) {
       return false;
    }
    else {
       return true;
    }
    }
    
    /**
    * 检测用户提交文件类型是否合法
    * @access private
    * @return boolean 如果为true说明类型合法，反之不合法
    */
    function checkType($extension) {
    foreach ($this->allow_type as $type) {
       if (strcasecmp($extension , $type) == 0)
        return true;
    }
    return false;
    }
    
    /**
    * 显示出错信息
    * @param $msg    要显示的出错信息   
    * @access private
    */
    function halt($msg) {
    printf("<b><UploadFile Error:></b> %s <br>\\n", $msg);
    }
    
    /**
    * 取文件扩展名
    * @param String $filename 给定要取扩展名的文件
    * @access private
    * @return String      返回给定文件扩展名
    */
    function getFileExt($filename) {
    $stuff = pathinfo($filename);
    return $stuff['extension'];
    }
    /**
    * 取给定文件文件名，不包括扩展名。
    * eg: getBaseName("j:/hexuzhong.jpg"); //返回 hexuzhong
    *
    * @param String $filename 给定要取文件名的文件
    * @access private
    * @return String 返回文件名
    */
    function getBaseName($filename, $type) {
    $basename = basename($filename, $type);
    return $basename;
    }
}