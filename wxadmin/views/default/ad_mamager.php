<?php
include_once 'base.php';
?> 
<?php startblock('article') ?>
<div class="commodity_css">
    <h1>管理广告信息</h1><a href="<?php echo WEB_URL?>ad/add_adManager">添加广告</a><hr>
    <table class="shopTable">
        <tr>
            <th>图片展示</th>
            <th>位置</th>
            <th>类型</th>
            <th>操作</th>
        </tr>
        <?php if($adLists):?>
            <?php foreach($adLists as $item):?>
                <tr>
                    <td width="30%"><img style="width:60px;height:60px;" src="<?php echo $item['photoUrl']?>"/></td>
                    <td width="30%"><?php echo $item['site']?></td>
                    <td width="30%"><?php echo $item['type']?></td>
                    <td width="10%">
                        <?php if($item['is_status'] >1):?>
                            <a href="<?php echo WEB_URL?>ad/editAd/<?php echo $item['id']?>/1">通过</a>
                        <?php else: ?><a onClick="return confirm('确定删除:确认后将会删除类别时将删除所属类别下的所有产品数据?\n\n此操作无法恢复!')?true:false;" href="<?php echo WEB_URL?>ad/editAd/<?php echo $item['id']?>/2">关闭</a><?php endif;?></td>
                </tr>
            <?php endforeach;?>
        <?php else:?>
            <tr>
                <td colspan="7"><span>暂时没有可显示的列表！</span></td>
            </tr>
        <?php endif;?>
    </table>
</div>

<?php endblock() ?>
<?php startblock('foot_js')?>
<script>
    function delcfm(){
        if (!confirm("确定删除:确认后将会删除类别时将删除所属类别下的所有产品数据?\n\n此操作无法恢复!")){
            // window.event.returnValue = false;
            return true;
        }
        return false;
    }
    $(document).ready(function(){
    })
</script>
<?php endblock() ?>
