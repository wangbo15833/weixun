<?php
include_once 'base.php';
?>
<?php startblock('article') ?>
<div class="commodity_css">
    <h1>信息管理</h1><hr/>
    <table class="shopTable">
        <tr>
            <td>标题</td>
            <td>简介</td>
            <td>店铺</td>
            <td>标签</td>
            <td>单价</td>
            <td>操作</td>
        </tr>
        <?php if(count($info) >0){?>
            <?php foreach($info as $item):?>
                <tr>
                    <td width="15%" title="<?php echo $item['title']?>"><?php echo $item['title']?></td>
                    <td width="35%" title="<?php echo $item['new_summary']?>"><?php if($item['new_summary']){echo $item['new_summary'];}else{ echo '暂无';}?></td>
                    <td width="10%" ><?php if($item['shopid']){echo $item['shopid'];}else{ echo '暂无';}?></td>
                    <td width="10%"><?php echo $item['tag']?></td>
                    <td width="10%"><?php echo $item['cprice']?>元</td>
                    <td width="18%">
                        <!-- <a class="showMessage" href="<?php echo WEB_URL ?>shops/index/showShops/<?php echo $item['id']?>">
                            <img src="<?php echo base_url()?>frontend/wxadmin/default/images/icon_view.gif"/></a>
                        --><a href="<?php echo WEB_URL ?>goods/editGoods?id=<?php echo $item['id']?>">
                            <img src="<?php echo base_url()?>frontend/wxadmin/default/images/edit.gif" /></a>

                        <a href="<?php echo WEB_URL ?>goods/handle/<?php echo $item['id'];?>">
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
<div class="page newinte_seepage"><?php echo $pageShow?></div>
<?php endblock() ?>

<?php startblock('foot_js')?>
<script>
    $(document).ready(function(){
    })
</script>
<?php endblock() ?>