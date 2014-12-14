<?php include_once 'base.php';?>
<?php startblock('header_css')?>

<?php endblock() ?>

<?php startblock('content') ?>
<div id="content" style="width: 100%">
    <div class="mainbox">
        <h2>找回密码</h2>
        <form class="common-form" action="<?php echo WEB_URL?>login/sendEmail" method="post" id="resetreq-form">
            <div class="field-group" id="yui_3_8_0_2_1369296928451_20">
                <label for="reset-email">邮箱/手机号</label>
                <input type="text" value="" placeholder="" id="reset-email" class="f-text" name="email">
            </div>
            <div class="field-group captcha" id="yui_3_8_0_2_1369296928451_32">
                <label for="captcha">验证码</label>
                <input type="text" autocomplete="off" name="captcha" class="f-text" id="captcha">
                <span name="show_captcha" id="show_captcha"></span>
                <a href="javascript:void(0)" class="captcha-refresh inline-link" tabindex="-1" id="change_captcha">看不清楚？换一张</a>
                <input type="hidden" id="hid_uuid" name="hid_uuid">
            </div>            <div class="field-group">
                <input type="submit" value="找回密码" class="form-button">
            </div>
        </form>
    </div>
</div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script>
        $(document).ready(function() {
            get_captcha();
            $('#change_captcha').click(function(){
                console.log('change');
                get_captcha();
            })
            function get_captcha(){
                $.ajax({
                    url:web_url + 'index.php/login/captcha',
                    type:'POST',
                    dataType:'json',
                    //data:values,
                    success:function(data){
                        if(data.status ==1){
                            $("#show_captcha").html(data.data);
                            $('#hid_uuid').val(data.uuid);
                        }else{
                            console.log('false');
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown){
                        console.log(textStatus);
                    }
                });
            }
        });
    </script>
<?php endblock() ?>