<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
    <div class="commodity_css">
        <h1>商户信息</h1><hr/>
        <table class="shopTable">
            <tr>
                <th>标题</th>
                <th>简介</th>
                <th>联系方式</th>
                <th>操作</th>
            </tr>
            <?php if(count($shopsList) >0):?>
            <?php foreach($shopsList as $item):?>
                    <tr>
                        <td width="30%"><?php echo $item['title']?></td>
                        <td width="30%" title="<?php echo $item['summary']?>"><?php echo $item['new_summary']?></td>
                        <td width="20%"><?php echo $item['phone']?></td>
                        <td width="20%">
                            <a class="showMessage" title="查看" href="<?php echo WEB_URL ?>manageShop/showShops/<?php echo $item['shopid']?>"><img src="<?php echo base_url()?>frontend/application/manageShop/images/icon_view.gif"/></a>
                            <a title="编辑" href="<?php echo WEB_URL ?>manageShop/getedit/<?php echo $item['shopid']?>"><img src="<?php echo base_url()?>frontend/application/manageShop/images/edit.gif" /></a>
                            <a title="删除" href="<?php echo WEB_URL ?>manageShop/delshops/<?php echo $item['shopid']?>">
                                <img onClick="return confirm('确定删除:确认后将会删除类别时将删除所属类别下的所有产品数据?\n\n此操作无法恢复!')?true:false;" style="border: 0px;"
                                     src="<?php echo base_url()?>frontend/application/manageShop/images/del.jpg" /></a>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr>
                    <td colspan="4"><span>暂时没有可显示的列表！</span></td>
                </tr>
            <?php endif;?>
        </table>
    </div>
    <input type="hidden" id="state" value="<?php echo $state?>"/>
    <div class="page newinte_seepage"><?php echo $pageData?></div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script>
        $(document).ready(function(){
        })
        
    </script>
<?php endblock() ?>