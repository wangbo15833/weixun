/**
 * Created with JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-21
 * Time: 下午3:25
 * To change this template use File | Settings | File Templates.
 */
/**//**
 * @author ming
 */
$(document).ready(function(){


    $('#reset_pwd').click(function(){
        var password = $('#password').val();
        var resetpassword = $('#reset-password').val();
        var resetpassword2 = $('#reset-password2').val();
        var userid = $('#currentUserSign').val();
        if(resetpassword != resetpassword2){
            art.dialog({
                time: 2,
                width: '20em',
                height: 55,
                content: '两次输入密码不同，请重新输入！'
            });
        }else{
            $.ajax({
                url: base_url +'login/edit_pass',
                type:'post',
                dataType:'json',
                data:{password:password,resetpassword:resetpassword,userid:userid},
                success:function(data){
                    console.log(data.state);
                    if(data.state == 1){
                        art.dialog({
                            time: 2,
                            width: '20em',
                            height: 55,
                            content: '修改成功！'
                        });
                        window.location.href = base_url + 'lists/show_list';
                    }
                }
            })
        }
    });

    $('#J_usave').click(function(){
        var face = $('#hid_pic').val();
        var userid = $('#currentUserSign').val();
        $.ajax({
            url: base_url +'lists/edit_user_face',
            type:'post',
            dataType:'json',
            data:{face:face,currentUserSign:userid},
            success:function(data){
                console.log(data.state);
                if(data.state == 1){
                    art.dialog({
                        time: 2,
                        width: '20em',
                        height: 55,
                        content: '修改成功！'
                    });
                }
            }
        })
    });
    $('#base_submit').click(function(){
        var nickname = $('#J_nickname').val();
        var userSex = $('input[name=userSex][type=radio]:checked').val();
        var addr = $('#J_user_city').val();
        var phone = $('#J_user_phone').val();
        var email = $('#J_user_email').val();
        var sign = $('#J_sign').val();
        var userid = $('#currentUserSign').val();
        $.ajax({
            url: base_url +'lists/edit_user_base',
            type:'post',
            dataType:'json',
            data:{userNickName:nickname,userSex:userSex,userCityName:addr,userTelName:phone,userEmailName:email,userSign:sign,currentUserSign:userid},
            success:function(data){
                console.log(data.state);
                if(data.state == 1){
                    art.dialog({
                        time: 2,
                        width: '20em',
                        height: 55,
                        content: '修改成功！'
                    });
                }
            }
        })
    });

    $('#J_mato').click(function(){
        var weight = $('#J_weight').val();
        var loveStatus = $('input[name=loveStatus][type=radio]:checked').val();
        var datepicker = $('#datepicker').val();
        var select_Constellation = $('#select_Constellation').val();
        var userQQ = $('#userQQ').val();
        var isQQPublic = $('input[name=isQQPublic][type=radio]:checked').val();
        var job = $('#job').val();
        var university = $('#university').val();
        var middleSchool = $('#middleSchool').val();
        var userHomePage = $('#userHomePage').val();
        var interest = $('#interest').val();
        var userid = $('#currentUserSign').val();
        var data_param = {weight:weight, loveStatus:loveStatus,datepicker:datepicker,select_Constellation:select_Constellation,
            userQQ:userQQ,isQQPublic:isQQPublic,job:job,university:university,middleSchool:middleSchool,userHomePage:userHomePage,interest:interest,userid:userid};
        $.ajax({
            url: base_url +'lists/edit_user_detail',
            type:'post',
            dataType:'json',
            data:data_param,
            success:function(data){
                //console.log(data.state);
                if(data.state == 1){
                    art.dialog({
                        time: 2,
                        width: '20em',
                        height: 55,
                        content: '修改成功！'
                    });
                }
            }
        })
    });
    $('#province').change(function() {
        var province_id = $('#province').val();
        $.ajax({
            url: web_url +'index.php/index/get_district_id',
            type:'post',
            dataType:'json',
            data:{param_id:province_id},
            success:function(data){
                if(data.status == 1){
                    data = data.data;
                    var count=data.length;
                    var _str = '<option value="">--市</option>';
                    for(j=0;j< count; j++){
                        _str +='<option value="'+data[j].area_id+'">'+data[j].area_name+'</option>';
                    }
                    $('#city').html(_str);
                    $('#county').html('<option value="">--区、县</option>');
                }
            }
        })
    });

    $('#city').change(function() {
        var city_id = $('#city').val();
        $.ajax({
            url: web_url +'index.php/index/get_district_id',
            type:'post',
            dataType:'json',
            data:{param_id:city_id},
            success:function(data){
                if(data.status == 1){
                    data = data.data;
                    var count=data.length;
                    var _str = '<option value="">--区、县--</option>';
                    for(j=0;j< count; j++){
                        _str +='<option value="'+data[j].area_id+'">'+data[j].area_name+'</option>';
                    }
                    $('#county').html(_str);
                    //$('#county').html('<option value="">--区、县</option>');
                }
            }
        })
    });

    /**//* 设置默认属性 */
    $.validator.setDefaults({
        submitHandler: function(form) {
            form.submit();
        }
    });

// 字符验证
    jQuery.validator.addMethod("stringCheck", function(value, element) {
        return this.optional(element) || /^[\u0391-\uFFE5\w]+$/.test(value);
    }, "只能包括中文字、英文字母、数字和下划线");

// 中文字两个字节
    jQuery.validator.addMethod("byteRangeLength", function(value, element, param) {
        var length = value.length;
        for(var i = 0; i < value.length; i++){
            if(value.charCodeAt(i) > 127){
                length++;
            }
        }
        return this.optional(element) || ( length >= param[0] && length <= param[1] );
    }, "请确保输入的值在3-15个字节之间(一个中文字算2个字节)");

// 身份证号码验证
    jQuery.validator.addMethod("isIdCardNo", function(value, element) {
        return this.optional(element) || isIdCardNo(value);
    }, "请正确输入您的身份证号码");

// 手机号码验证
    jQuery.validator.addMethod("isMobile", function(value, element) {
        var length = value.length;
        var mobile = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请正确填写您的手机号码");

// 电话号码验证
    jQuery.validator.addMethod("isTel", function(value, element) {
        var tel = /^\d{3,4}-?\d{7,9}$/;    //电话号码格式010-12345678
        return this.optional(element) || (tel.test(value));
    }, "请正确填写您的电话号码");

// 联系电话(手机/电话皆可)验证
    jQuery.validator.addMethod("isPhone", function(value,element) {
        var length = value.length;
        var mobile = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;
        var tel = /^\d{3,4}-?\d{7,9}$/;
        return this.optional(element) || (tel.test(value) || mobile.test(value));

    }, "请正确填写您的联系电话");

// 邮政编码验证
    jQuery.validator.addMethod("isZipCode", function(value, element) {
        var tel = /^[0-9]{6}$/;
        return this.optional(element) || (tel.test(value));
    }, "请正确填写您的邮政编码");
    //console.log('dd');
    //开始form验证
    $('#reset-form').validate({
        rules:{
            password:{
                required:true,
                minlength: 6
            },
            'reset-password':{
                required:true,
                minlength: 6
            },
            'reset-password2':{
                equalTo:"#reset-password"
            }
        },
        messages:{
            password:{
                required: "密码不能为空、请输入！",
                minlength:"密码至少6位"
            },
            'reset-password':{
                required: "新密码不能为空、请输入！",
                minlength:"新密码至少6位"
            },
            'reset-password2':{
                equalTo:"请再次输入相同的值"
            }
        },
        focusCleanup: false,
        onfocusout: function(element) { $(element).valid(); }
    });



    $('#login_form_user').validate({
        /**//* 设置验证规则 */
        rules: {
            email: {
                required:true
               // stringCheck:true,
              //  byteRangeLength:[3,15]
            },
            password:{
                required:true,
                minlength: 6
                // email:true
            }
        },

        /**//* 设置错误信息 */
        messages: {
            email: {
                required: "请填写用户名"
               // stringCheck: "用户名只能包括中文字、英文字母、数字和下划线",
               // byteRangeLength: "用户名必须在3-15个字符之间"
            },
            password:{
                required: "密码不能为空、请输入！",
                minlength:"密码至少6位"
                //email: "请输入一个有效的Email地址"
            }
        },

        /**//* 设置验证触发事件 */
        focusInvalid: false,
        onkeyup: false,

        /**//* 设置错误信息提示DOM */
        errorPlacement: function(error, element) {
            //element.val($(error).text());
            error.appendTo( element.parent());
        }
    });


    upload_url = base_url + 'upload/fileUp';
    $('#Filedata').uploadify({
        'swf' : web_url +'frontend/wxadmin/default/swf/uploadify.swf',
        'uploader': upload_url,
        'cancelImg': web_url + 'frontend/wxadmin/default/swf/uploadify-cancel.png',
        'buttonText':'上传文件',
        'buttonImage':'',
        'auto':true,
        'fileSizeLimit': '5MB',
        'method':'get',
        'multi':false,
        'debug':false,
        'fileTypeDesc':'支持的格式：jpeg、jpg、gif、png',
        'fileTypeExts':'*.jpg;*.jpeg;*.gif;*.png',
        'width':60,
        'height':20,
        'onUploadSuccess':function(file,data,response){
            data = eval ('('+data+')');
            if(data['status']=="1"){
                var data = data['data'];
                $('.pic img').attr('src',data['picUrl']);
                $('#hid_pic').val(data['base_pic']);
                $('#Filedata').attr('class','Hide');
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

    $('#gourmetFiledata').uploadify({
        'swf' : web_url +'frontend/wxadmin/default/swf/uploadify.swf',
        'uploader': upload_url,
        'cancelImg': web_url + 'frontend/wxadmin/default/swf/uploadify-cancel.png',
        'buttonText':'上传文件',
        'buttonImage':'',
        'auto':true,
        'fileSizeLimit': '5MB',
        'method':'get',
        'multi':false,
        'debug':false,
        'fileTypeDesc':'支持的格式：jpeg、jpg、gif、png',
        'fileTypeExts':'*.jpg;*.jpeg;*.gif;*.png',
        'width':60,
        'height':20,
        'onUploadSuccess':function(file,data,response){
            data = eval ('('+data+')');
            if(data['status']=="1"){
                    var data = data['data'];
                    $('.pic img').attr('src',data['picUrl']);
                    var pic = $('#hid_pics').val();
                    if(pic!=""){
                        $('#hid_pics').val(pic+';'+data['base_pic']);
                    }else{
                        $('#hid_pics').val(data['base_pic']);
                    }
                $('.upload_list').removeClass('Hide');
            }else{
                art.dialog({
                    time: 2,
                    width: '20em',
                    height: 55,
                    content: '图片尺寸不小于300*300px，支持jpg、png和bmp！'
                });
            }
        },

        'onSelectError':function(file, errorCode, errorMsg){
            alert(file.name);
        },

        'onUploadError':function(file, errorCode, errorMsg){
            alert( 'id: ' + file.id + ' - 索引: ' + file.index + ' - 文件名: ' + file.name + ' - 文件大小: ' + file.size + ' - 类型: ' + file.type + ' - 创建日期: ' + file.creationdate + ' - 修改日期: ' + file.modificationdate + ' - 文件状态: ' + file.filestatus + ' - 错误代码: ' + errorCode + ' - 错误描述: ' + errorMsg + ' - 简要错误描述: ' + errorString);

        }
    });
    /* 总体评价 星星切换*/
    $('#J_review-s1 .one-star').mouseover(function(){
        $('#J_review-s1 .one-star').addClass('active-star');
        $('#J_review-s1 .one-star').bind('mouseout',function(){
            $('#J_review-s1 .one-star').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s1 .one-star').removeClass('active-star');
        }).click(function(){
            $('#J_review-s1 .one-star').unbind('mouseout');
            $('#hid_star').val('1');
        });

    $('#J_review-s1 .two-stars').mouseover(function(){
        $('#J_review-s1 .two-stars').addClass('active-star');
        $('#J_review-s1 .two-stars').bind('mouseout',function(){
            $('#J_review-s1 .two-stars').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s1 .two-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s1 .two-stars').unbind('mouseout');
            $('#hid_star').val('2');
        });

    $('#J_review-s1 .three-stars').mouseover(function(){
        $('#J_review-s1 .three-stars').addClass('active-star');
        $('#J_review-s1 .three-stars').bind('mouseout',function(){
            $('#J_review-s1 .three-stars').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s1 .three-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s1 .three-stars').unbind('mouseout');
            $('#hid_star').val('3');
        });

    $('#J_review-s1 .four-stars').mouseover(function(){
        $('#J_review-s1 .four-stars').addClass('active-star');
        $('#J_review-s1 .four-stars').bind('mouseout',function(){
            $('#J_review-s1 .four-stars').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s1 .four-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s1 .four-stars').unbind('mouseout');
            $('#hid_star').val('4');
        });

    $('#J_review-s1 .five-stars').mouseover(function(){
        $('#J_review-s1 .five-stars').bind('mouseout',function(){
            $('#J_review-s1 .five-stars').removeClass('active-star');
        });
        $('#J_review-s1 .five-stars').addClass('active-star');
    }).mouseout(function(){
            $('#J_review-s1 .five-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s1 .five-stars').unbind('mouseout');
            $('#hid_star').val('5');
        });

    /* 服务态度 星星切换*/
    $('#J_review-s2 .one-star').mouseover(function(){
        $('#J_review-s2 .one-star').addClass('active-star');
        $('#J_review-s2 .one-star').bind('mouseout',function(){
            $('#J_review-s2 .one-star').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s2 .one-star').removeClass('active-star');
        }).click(function(){
            $('#J_review-s2 .one-star').unbind('mouseout');
            $('#hid_star2').val('1');
        });

    $('#J_review-s2 .two-stars').mouseover(function(){
        $('#J_review-s2 .two-stars').addClass('active-star');
        $('#J_review-s2 .two-stars').bind('mouseout',function(){
            $('#J_review-s2 .two-stars').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s2 .two-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s2 .two-stars').unbind('mouseout');
            $('#hid_star2').val('2');
        });

    $('#J_review-s2 .three-stars').mouseover(function(){
        $('#J_review-s2 .three-stars').addClass('active-star');
        $('#J_review-s2 .three-stars').bind('mouseout',function(){
            $('#J_review-s2 .three-stars').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s2 .three-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s2 .three-stars').unbind('mouseout');
            $('#hid_star2').val('3');
        });

    $('#J_review-s2 .four-stars').mouseover(function(){
        $('#J_review-s2 .four-stars').addClass('active-star');
        $('#J_review-s2 .four-stars').bind('mouseout',function(){
            $('#J_review-s2 .four-stars').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s2 .four-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s2 .four-stars').unbind('mouseout');
            $('#hid_star2').val('4');
        });

    $('#J_review-s2 .five-stars').mouseover(function(){
        $('#J_review-s2 .five-stars').bind('mouseout',function(){
            $('#J_review-s2 .five-stars').removeClass('active-star');
        });
        $('#J_review-s2 .five-stars').addClass('active-star');
    }).mouseout(function(){
            $('#J_review-s2 .five-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s2 .five-stars').unbind('mouseout');
            $('#hid_star2').val('5');
        });
    /* 环境 星星切换*/
    $('#J_review-s3 .one-star').mouseover(function(){
        $('#J_review-s3 .one-star').addClass('active-star');
        $('#J_review-s3 .one-star').bind('mouseout',function(){
            $('#J_review-s3 .one-star').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s3 .one-star').removeClass('active-star');
        }).click(function(){
            $('#J_review-s3 .one-star').unbind('mouseout');
            $('#hid_star3').val('1');
        });

    $('#J_review-s3 .two-stars').mouseover(function(){
        $('#J_review-s3 .two-stars').addClass('active-star');
        $('#J_review-s3 .two-stars').bind('mouseout',function(){
            $('#J_review-s3 .two-stars').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s3 .two-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s3 .two-stars').unbind('mouseout');
            $('#hid_star3').val('2');
        });

    $('#J_review-s3 .three-stars').mouseover(function(){
        $('#J_review-s3 .three-stars').addClass('active-star');
        $('#J_review-s3 .three-stars').bind('mouseout',function(){
            $('#J_review-s3 .three-stars').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s3 .three-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s3 .three-stars').unbind('mouseout');
            $('#hid_star3').val('3');
        });

    $('#J_review-s3 .four-stars').mouseover(function(){
        $('#J_review-s3 .four-stars').addClass('active-star');
        $('#J_review-s3 .four-stars').bind('mouseout',function(){
            $('#J_review-s3 .four-stars').removeClass('active-star');
        });
    }).mouseout(function(){
            $('#J_review-s3 .four-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s3 .four-stars').unbind('mouseout');
            $('#hid_star3').val('4');
        });

    $('#J_review-s3 .five-stars').mouseover(function(){
        $('#J_review-s3 .five-stars').bind('mouseout',function(){
            $('#J_review-s3 .five-stars').removeClass('active-star');
        });
        $('#J_review-s3 .five-stars').addClass('active-star');
    }).mouseout(function(){
            $('#J_review-s3 .five-stars').removeClass('active-star');
        }).click(function(){
            $('#J_review-s3 .five-stars').unbind('mouseout');
            $('#hid_star3').val('5');
        });
})

function G(id) {
    return document.getElementById(id);
}