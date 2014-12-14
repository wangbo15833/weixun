
<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
<div class="commodity_css" >
       <h1>修改密码</h1><hr>
    <form id="modify_pwd_table" class="editUserPwd" method="post" action="<?php echo base_url()?>wxadmin.php/admin/update">
        
        <input type="hidden" name="hid_id" value="<?php echo $uid ?>" />
        <table style=" margin-left: 100px ;">
            <tr>
                <td style="">用户名：</td><td><input name="lname" id="lname" value="" type="text"  /></td>
            </tr>
            <tr>
                <td>原密码：</td><td><input name="lpwd" id="lpwd" value="" type="password" /></td>
            </tr>
            <tr>
                <td>密      码：</td><td><input name="npwd" id="npwd" value="" type="password" /></td>
            </tr>
            <tr>
                <td>确认密码：</td><td><input name="qpwd" id="qpwd" value="" type="password" /></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left: 100px;"><input id="submit" type="submit"  value="登      录"/></td>
            </tr>
        </table>
    </form>
    </div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script>
        $(document).ready(function(){
        })
    </script>
<?php endblock() ?>