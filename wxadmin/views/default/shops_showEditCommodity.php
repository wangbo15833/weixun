<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
    <div class="commodity_css">
        <form id="" class="" method="post" action="<?php echo WEB_URL?>shops/index/editCommodityInfo">
            <label style="padding-left: 500px;"><h1>编辑商品信息</h1><hr></label>
            <?php foreach($dlist as $i):?>
                <table>
                <tr>
                    <td>标&nbsp;&nbsp;&nbsp;&nbsp;题：</td><td><input type="text" name="title" id="title" class="" value="<?php echo $i['title'] ?>"/></td>
                </tr>
                <tr>
                    <td>所属商铺：</td><td><select style="width: 150px;text-align: center" class="" name="shops_id" id="shops_id">
                                    <?php foreach($shopsInof as $item):?>
                                        
                                        <option value="<?php echo $item['id']?>" <?php if($i['shops_id'] == $item['id']):?>checked<?php endif;?>><?php echo $item['title']?></option><?php endforeach;?>
                                    </select></td>
                </tr>
                <tr>
                    <td>简&nbsp;&nbsp;&nbsp;&nbsp;介：</td><td><textarea name="jianjie" style="width:300px;height:100px;"><?php echo $i['jianjie']?></textarea></td>
                </tr>
                <tr>
                    <td>商品内容：</td><td><textarea name="content" style="width:700px;height:300px;visibility:hidden;"><?php echo $i['content']?></textarea></td>
                </tr>
                <tr>
                    <td>单&nbsp;&nbsp;&nbsp;&nbsp;价：</td><td><input type="text" name="price" id="price" class="" value="<?php echo $i['price'] ?>"/></td>
                </tr>
                <tr>
                    <td>折&nbsp;&nbsp;&nbsp;&nbsp;扣：</td><td><input type="text" name="discount" id="discount" class="" value="<?php echo $i['Discount'] ?>"/></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"><input type="hidden" name="commodityid" value="<?php echo $i['id']?>"/>
                        <input type="hidden" name="token" value="<?php echo $token?>"/>
                   <input type="submit" value="提交" style="margin-bottom: 5px;"/></td>
                </tr>
            </table>
            <?php endforeach;?>
        </form>
    </div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/kindeditor-all.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/lang/zh_CN.js"></script>
    <script>
            var editor;
            KindEditor.ready(function(K) {
                editor = K.create('textarea[name="content"]', {
                    allowFileManager : true
                });
            });
        </script>
    <script>
        $(document).ready(function(){
        })
    </script>
<?php endblock() ?>