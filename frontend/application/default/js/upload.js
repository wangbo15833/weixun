/**
 * @author lynx
 */
/**url**/
var upload_url = base_url + 'upload/do_upload';

$(document).ready(function(){

    $('#Filedata').uploadify({
        swf : web_url +'frontend/wxadmin/default/swf/uploadify.swf',
        'uploader': upload_url,
        'cancelImg': web_url + 'frontend/wxadmin/default/swf/uploadify-cancel.png',
        'buttonText':'上传文件',
        'buttonImage':'',
        'auto':true,
        'fileSizeLimit': '5MB',
       'method':'get',
        'debug':false,
       'fileTypeDesc':'支持的格式：jpeg、jpg、gif、png',
        'fileTypeExts':'*.jpg;*.jpeg;*.gif;*.png',
        'width':60,
        'height':20,
       'onUploadSuccess':function(file,data,response){
            data = eval ('('+data+')');
            if(data['status']=="1"){
                var data = data['data'];
               $('#picK').append('<img src="'+web_url +data['base_pic']+'" name="'+data['name']+'" />');
               var pic = $('#pics').val();
               if(pic!=""){
                   $('#pics').val(pic+';'+data['base_pic']);
               }
               else{
               $('#pics').val(data['base_pic']);
            }
            }else{
               console.log(data['data']);
            }
        },

        'onSelectError':function(file, errorCode, errorMsg){
            alert(file.name);
        },

        'onUploadError':function(file, errorCode, errorMsg){

            alert( 'id: ' + file.id + ' - 索引: ' + file.index + ' - 文件名: ' + file.name + ' - 文件大小: ' + file.size + ' - 类型: ' + file.type + ' - 创建日期: ' + file.creationdate + ' - 修改日期: ' + file.modificationdate + ' - 文件状态: ' + file.filestatus + ' - 错误代码: ' + errorCode + ' - 错误描述: ' + errorMsg);

        }
    });

  }); 