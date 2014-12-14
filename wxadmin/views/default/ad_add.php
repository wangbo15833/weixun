
<?php
include_once 'base.php';
?>
<?php startblock('article') ?>
<div class="commodity_css">
    <h1>添加广告图片</h1><hr>
    <form id="modify_pwd_table"  class="addNewCommodity" method="post" action="<?php echo WEB_URL?>ad/add_adManager">
        <input type="hidden" name="token" value="<?php echo $token?>"/>
        <input type="hidden" name="adState" value="1" />
        <table>
            <tr>
                <td>显示区域:</td>
                <td><input type="radio" name="site" checked="" value="1">左侧
                    <input type="radio" name="site" value="2">右侧
                </td>
            </tr>
            <tr>
                <td>商品简介:</td><td><select name="type" id="type" style="float: left;margin-right: 5%;">
                        <option value="0">首页</option>
                        <?php foreach($channels as $item):?>
                            <option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
                        <?php endforeach;?>
                    </select></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="picK"></div>
                    <input type="hidden" name="pics" id="pics" value="">
                </td>
            </tr>
            <tr>
                <td>上传图片:</td>
                <td>
                    <input type="file" name="Filedata" id="Filedata" multiple="true" />
                    <h5 style="color: red;">仅支持jpg, jpeg, gif,png等 图片格式上传</h5>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                    <input id="submit" type="submit"  value="提&nbsp;&nbsp;交"/>
                </td>
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