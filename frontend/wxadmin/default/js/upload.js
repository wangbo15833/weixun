/**
 * @author gefc
 */
/**url**/
var upload_url = b_base_url + 'shops/uploads';
var getshopsInfoById = web_url + 'wxadmin.php/shops/index/getShopsById';
var getCommodityInfo = web_url + 'wxadmin.php/shops/index/commodityList';
var getCommodity = web_url + 'wxadmin.php/shops/index/getCommodity';
var getCategory = web_url + 'wxadmin.php/shops/index/getCategory';

$(document).ready(function(){
    
    $('#g_Filedata').uploadify({
        'swf' : web_url +'frontend/wxadmin/default/swf/uploadify.swf',
        'uploader': upload_url,
        'cancelImg': web_url + 'frontend/wxadmin/default/swf/uploadify-cancel.png',
        'buttonText':'上传文件',
        'buttonImage':'',
        'auto':true,
        'fileSizeLimit': '5MB',
       //'method':'post',
        'debug':false,
       'fileTypeDesc':'支持的格式：jpeg、jpg、gif、png',
        'fileTypeExts':'*.jpg;*.jpeg;*.gif;*.png',
        'width':60,
        'height':20,
       'onUploadSuccess':function(file,data,response){

            data = eval ('('+data+')');
            if(data['status']=="1"){
                var data = data['data'];
               $('#picK').append('<img src="'+data['picUrl']+'" name="'+data['name']+'" />');
               var pic = $('#pics').val();
               if(pic!=""){
                   $('#pics').val(pic+';'+data['hid_pics']);
               }else{
               $('#pics').val(data['hid_pics']);
               }
            }else{
               console.log(data['data']);
            }
        },

        'onSelectError':function(file, errorCode, errorMsg){

            alert(file.name);
        },

        'onUploadError':function(file, errorCode, errorMsg){

          //  alert( 'id: ' + file.id + ' - 索引: ' + file.index + ' - 文件名: ' + file.name + ' - 文件大小: ' + file.size + ' - 类型: ' + file.type + ' - 创建日期: ' + file.creationdate + ' - 修改日期: ' + file.modificationdate + ' - 文件状态: ' + file.filestatus + ' - 错误代码: ' + errorCode + ' - 错误描述: ' + errorMsg + ' - 简要错误描述: ' + errorString);
        }
    });
    
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
               $('#picK').append('<img src="'+data['picUrl']+'" name="'+data['name']+'" />');
               var pic = $('#pics').val();
               if(pic!=""){
                   $('#pics').val(pic+';'+data['hid_pics']);
               }else{
               $('#pics').val(data['hid_pics']);
               }
            }else{
               console.log(data['data']);
            }
        },

        'onSelectError':function(file, errorCode, errorMsg){
            alert(file.name);
        },

        'onUploadError':function(file, errorCode, errorMsg){

            alert( 'id: ' + file.id + ' - 索引: ' + file.index + ' - 文件名: ' + file.name + ' - 文件大小: ' + file.size + ' - 类型: ' + file.type + ' - 创建日期: ' + file.creationdate + ' - 修改日期: ' + file.modificationdate + ' - 文件状态: ' + file.filestatus + ' - 错误代码: ' + errorCode + ' - 错误描述: ' + errorMsg + ' - 简要错误描述: ' + errorString);

        }
    });

    $.ajax({

        url: web_url +'wxadmin.php/index/getMenu',
        type:'post',
        dataType:'json',
        success:function(data){
            data = data.public;
            //newdata = eval("("+data+")");
            var click = $('#hid_clickValue').val();
           // console.log(data.length);
            count = data.length;
            _str = "";
            for(j=0;j< count; j++){
                _str += '<tr>';
                _str +='<td id="'+data[j]['name_param']+'" ';
                if(data[j]['name_param'] == click){
                    _str += ' class="setbackground" ';
                }
                _str +=' height=20>☉ <a href="'+data[j]['url']+'">'+data[j]['name']+'</a> </td>';
                _str += '</tr>';
            }
            //console.log(_str);
            $('#table_str').append(_str);
        }
    });

  }); 