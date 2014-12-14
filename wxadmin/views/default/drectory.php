
<?php
include_once 'base.php';
?>
<?php startblock('article') ?>
<div class="commodity_css">
    <h1>目录访问配置信息</h1><a href="<?php echo WEB_URL ?>Configuration/drectory/addD">添加配置信息</a><hr/>
    <table class="shopTable">
        <tr>
            <td>标题</td>
            <td>标题属性</td>
            <td>访问路径</td>
            <td>访问权限</td>
            <td>状态</td>
            <td>操作</td>
        </tr>
        <?php if(count($info) >0){?>
            <?php foreach($info as $item):?>
                <tr>
                    <td width="15%" title="<?php echo $item['name']?>"><?php echo $item['name']?></td>
                    <td width="15%" title="<?php echo $item['name_param']?>"><?php echo $item['name_param'];?></td>
                    <td width="30%" ><?php echo $item['url'];?></td>
                    <td width="10%"><?php echo $item['is_type']?></td>
                    <td width="10%"><?php echo $item['state']?></td>
                    <td width="18%">
                        <!-- <a class="showMessage" href="<?php echo WEB_URL ?>shops/index/showShops/<?php echo $item['id']?>">
                            <img src="<?php echo base_url()?>frontend/wxadmin/default/images/icon_view.gif"/></a>
                        <a href="<?php echo WEB_URL ?>shops/index/getedit/<?php echo $item['id']?>">
                            <img src="<?php echo base_url()?>frontend/wxadmin/default/images/edit.gif" /></a>
                        -->
                        <a href="<?php echo WEB_URL ?>Configuration/drectory/delD/<?php echo $item['id']?>/<?php echo $item['is_state']?>">
                            <img onClick="return confirm('确定删除:确认后将会删除类别时将删除所属类别下的所有产品数据?\n\n此操作无法恢复!')?true:false;"
                                 style="border: 0px;" src="<?php echo base_url()?>frontend/wxadmin/default/images/del.jpg" /></a>
                    </td>
                </tr>
            <?php endforeach;?>
        <?php }else{ ?>
            <tr><td colspan="5"><h2>暂时无可显示记录！</h2></td></tr>
        <?php } ?>
    </table>
</div>

<?php endblock() ?>

<?php startblock('foot_js')?>

<?php endblock() ?>