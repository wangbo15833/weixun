
<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
<div class="commodity_css" >
       <h1>添加管理员</h1><hr>
    <form id="addAdmin" class="addAdmin" method="post" action="<?php echo base_url()?>wxadmin.php/admin/addadmin">
        <table style=" margin-left: 100px ;">
            <tr>
                <td style="">用户名：</td>
                <td>
                    <input name="name" id="name" value="" type="text"  />
                </td>
            </tr>

            <tr>
                <td>密      码：</td>
                <td>
                    <input name="pwd" id="pwd" value="" type="password" />
                </td>
            </tr>
            <tr>
                <td>确认密码：</td>
                <td>
                    <input name="qpwd" id="qpwd" value="" type="password" />
                </td>
            </tr>
            <tr>
                <td>姓名：</td>
                <td>
                    <input name="legalname" id="legalname" value="" type="text" />
                </td>
            </tr>
            <tr>
                <td>邮箱：</td>
                <td>
                    <input name="email" id="email" value="" type="text" />
                </td>
            </tr>
            <tr>
                <td>电话：</td>
                <td>
                    <input name="phone" id="phone" value="" type="text" />
                </td>
            </tr>

            <tr>
                <td>地址：</td>
                <td>
                    <input name="address" id="address" value="" type="text" />
                </td>
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