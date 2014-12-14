<?php
    class Upload extends CI_Controller{
    	function __construct(){
    		parent :: __construct();
    	}

        function fileUp(){
            $this -> load -> library('File_util');
            $fileutil = new File_util();
            $time = date('Y/m/d', time());
            $targetFolder = 'UpLoadFile/' .$time;
            $file = $_FILES['Filedata'];
            $tempFile = $file['tmp_name'];
            $isIma = false;
            $imaState = getimagesize($tempFile);
            if($imaState[0]>=300 && $imaState[1] >= 300){
                $isIma = true;
            }

            $targetPath = FWPHP_PATH . $targetFolder;
            $web_path = base_url().$targetFolder.'/'.$file['name'];
            if (!file_exists($targetFolder))
                $fileutil -> createDir($targetFolder);
            $targetFile = rtrim($targetPath, '/') . '/' . $file['name'];
            $dataList = array('name' => $file['name'], 'size' => $file['size'], 'picUrl' => $web_path,'base_pic'=>$targetFolder.'/'.$file['name']);
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png');
            // File extensions
            $fileParts = pathinfo($file['name']);

            if (in_array(strtolower($fileParts['extension']), $fileTypes) && $isIma) {
                move_uploaded_file($tempFile, $targetFile);
                echo json_encode(array('status'=>1,'data'=>$dataList));
            } else {
                echo json_encode(array('status'=>0,'data'=>'Invalid file type.'));
            }
        }

        function do_upload()
        {
            $config['upload_path'] = 'UpLoadFile/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '10000';
            $config['max_width']  = '1024';
            $config['max_height']  = '768';
            $config['encrypt_name']=TRUE;


            $this->load->library('upload', $config);

            $field_name = "Filedata";
            if ( ! $this->upload->do_upload($field_name))
            {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode(array('status'=>0,'data'=>$error));
            }
            else
            {
                $data = $this->upload->data();
                $web_path=base_url().$config['upload_path'].$data['file_name'];
                $dataList = array(
                    'name' => $data['file_name'],
                    'size' => $data['file_size'],
                    'picUrl' => $web_path,
                    'base_pic'=>$config['upload_path'].$data['file_name']
                );
                echo json_encode(array('status'=>1,'data'=>$dataList));
            }
        }

    }
?>