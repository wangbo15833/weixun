/**
 * Created with JetBrains PhpStorm.
 * User: Administrator
 * Date: 14-4-2
 * Time: 上午9:59
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function(){

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

//标题重复检测
    jQuery.validator.addMethod("repetitionCheck", function(value, element) {
        var obj =$.ajax({
            url: web_url +'index.php/manageShop/repetitionCheck',
            type:'post',
            dataType:'json',
            data:{param:value},
            async:false,
            cache:false,
            success:function(data){}
        }).responseText;
        var jsonobj=eval('('+obj+')');
        return jsonobj;

    }, "店铺名重复");


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

//开始验证-添加新用户
    $('.addAdminUser').validate({
        /**//* 设置验证规则 */
        rules: {
            aname: {
                required:true,
                stringCheck:true,
                byteRangeLength:[3,15]
            },
            apwd:{
                required:true
                // email:true
            },
            legalname:{
                required:true
            },
            phone:{
                required:true,
                isPhone:true
            },
            address:{
                required:true,
                stringCheck:true,
                byteRangeLength:[3,100]
            }
        },

        /**//* 设置错误信息 */
        messages: {
            aname: {
                required: "请填写用户名",
                stringCheck: "用户名只能包括中文字、英文字母、数字和下划线",
                byteRangeLength: "用户名必须在3-15个字符之间(一个中文字算2个字符)"
            },
            apwd:{
                required: "密码不能为空、请输入！"
                //email: "请输入一个有效的Email地址"
            },
            legalname:{
                required : "法人姓名不能为空！"

            },
            phone:{
                required: "请输入您的联系电话",
                isPhone: "请输入一个有效的联系电话"
            },
            address:{
                required: "请输入您的联系地址",
                stringCheck: "请正确输入您的联系地址",
                byteRangeLength: "请详实您的联系地址以便于我们联系您"
            }
        },

        /**//* 设置验证触发事件 */
        focusInvalid: false,
        onkeyup: false,

        /**//* 设置错误信息提示DOM */
        errorPlacement: function(error, element) {
            error.appendTo( element.parent());
        }

    });

    //开始验证-添加新商铺
    $('.addNewShops').validate({
        /**//* 设置验证规则 */
        rules: {
            suid: {
                required:true
                // stringCheck:true,
                // byteRangeLength:[3,15]
            },
            title:{
                required:true,
                repetitionCheck:true
//                stringCheck:true
                // email:true
            },
//            summary:{
//                required:true
//            },
            phone:{
                required:true,
                isPhone:true
            }
        },

        /**//* 设置错误信息 */
        messages: {
            suid: {
                required: "店铺掌柜不能为空！"
                //stringCheck: "用户名只能包括中文字、英文字母、数字和下划线",
                // byteRangeLength: "用户名必须在3-15个字符之间(一个中文字算2个字符)"
            },
            title:{
                required: "标题不能为空、请输入！"
                //email: "请输入一个有效的Email地址"
            },
//            summary:{
//                required : "商品简介不能为空！"

//            },
            phone:{
                required: "请输入您的联系电话",
                isPhone: "请输入一个有效的联系电话"
            }
        },

        /**//* 设置验证触发事件 */
        focusInvalid: false,
        onkeyup: false,

        /**//* 设置错误信息提示DOM */
        errorPlacement: function(error, element) {
            error.appendTo( element.parent());
        }

    });

    //开始验证-添加新商铺商品
    $('.addNewCommodity').validate({
        /**//* 设置验证规则 */
        rules: {
            title:{
                required:true,
                stringCheck:true
                // email:true
            },
            price:{
                required:true,
                number:true
            }
        },

        /**//* 设置错误信息 */
        messages: {
            title:{
                required: "标题不能为空、请输入！"
                //email: "请输入一个有效的Email地址"
            },
            price:{
                required: "请输入单价",
                number: "只能输入数字"
            }
        },

        /**//* 设置验证触发事件 */
        focusInvalid: false,
        onkeyup: false,

        /**//* 设置错误信息提示DOM */
        errorPlacement: function(error, element) {
            error.appendTo( element.parent());
        }
    });

    //开始验证-添加新商铺商品
    $('.addNewPreferential').validate({
        /**//* 设置验证规则 */
        rules: {
            zhekou:{
                required:true,
                number:true
                // email:true
            }
        },

        /**//* 设置错误信息 */
        messages: {
            zhekou:{
                required: "商品折扣不能为空、请输入！",
                number:"商品折扣只能输入数字"
                //email: "请输入一个有效的Email地址"
            }
        },

        /**//* 设置验证触发事件 */
        focusInvalid: false,
        onkeyup: false,

        /**//* 设置错误信息提示DOM */
        errorPlacement: function(error, element) {
            error.appendTo( element.parent());
        }
    });

    //开始验证-修改用户密码
    $('.editUserPwd').validate({
        /**//* 设置验证规则 */
        rules: {
            lname:{
                required:true,
                stringCheck:true,
                byteRangeLength:[3,15]
                // email:true
            },
            lpwd:{
                required:true
                //number:true,
                //minlength: 6
                // email:true
            },
            npwd:{
                required:true
                //number:true,
                //minlength: 6
                // email:true
            },
            qpwd:{
                required:true,
                //minlength: 6,
                equalTo:"#npwd"
                // email:true
            }
        },

        /**//* 设置错误信息 */
        messages: {
            lname:{
                required: "请填写用户名",
                stringCheck: "用户名只能包括中文字、英文字母、数字和下划线",
                byteRangeLength: "用户名必须在3-15个字符之间(一个中文字算2个字符)"
                //email: "请输入一个有效的Email地址"
            },
            lpwd:{
                required:"密码不能为空"
                //number:"密码只能是数字",
                //minlength: "密码至少6位"
            },
            npwd:{
                required:"新密码不能为空"
                //number:"新密码只能是数字",
                //minlength: "密码至少6位"
            },
            qpwd:{
                required:"重复不能为空",
                equalTo:"两次输入不一致"
                //minlength: "密码至少6位"
            }
        },

        /**//* 设置验证触发事件 */
        focusInvalid: false,
        onkeyup: false,

        /**//* 设置错误信息提示DOM */
        errorPlacement: function(error, element) {
            error.appendTo( element.parent());
        }
    });
    $('.addNewGourmet').validate({
        /**//* 设置验证规则 */
        rules: {
            title:{
                required:true
//                stringCheck:true
                //byteRangeLength:[3,15]
                // email:true
            },
            typeId:{
                required:true
                //number:true,
                //minlength: 6
                // email:true
            },
            content:{
                required:true
                // email:true
            },
            phone:{
                required:true,
                number:true,
                minlength: 7
                // email:true
            },
            address:{
                required:true
            }
        },

        /**//* 设置错误信息 */
        messages: {
            title:{
                required: "请填写标题"
//                stringCheck: "标题只能包括中文字、英文字母、数字和下划线"
                //byteRangeLength: "标题必须在3-15个字符之间(一个中文字算2个字符)"
                //email: "请输入一个有效的Email地址"
            },
            typeId:{
                required:"类型不能为空"
                //number:"密码只能是数字",
                //minlength: "密码至少6位"
            },
            content:{
                required:"内容不能为空"
            },
            phone:{
                required:"联系电话不能为空",
                number:"联系电话只能是数字",
                minlength: "联系电话至少7位"
            },
            address:{
                required:"联系地址不能为空"
            }
        },

        /**//* 设置验证触发事件 */
        focusInvalid: false,
        onkeyup: false,

        /**//* 设置错误信息提示DOM */
        errorPlacement: function(error, element) {
            error.appendTo( element.parent());
        }
    });

});