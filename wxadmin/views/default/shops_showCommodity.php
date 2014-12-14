<div>
    
    <table>
        <?php foreach($commodifyInfo as $item):?>
                <tr>
                    <td>标题:</td><td><label><?php echo $item['title']?></label></td>
                </tr>
                <tr>
                    <td>简介:</td><td><label><?php echo $item['jianjie']?></label></td>
                </tr>
                <tr>
                    <td>所属店铺:</td><td><label><?php echo $item['shops_id']?></label></td>
                </tr>
                <tr>
                    <td>所属人:</td><td><label><?php echo $item['uid']?></label></td>
                </tr>
                <tr>
                    <td>单价:</td><td><label><?php echo $item['price']?></label></td>
                </tr>
                <tr>
                    <td>发布时间:</td><td><label><?php echo $item['dateline']?></label></td>
                </tr>
                <tr>
                    <td >图片</td><td><div id="picK"></div><?php foreach($item['pics'] as $pic): if(!$pic):?>暂时无可显示图片！<?php else:?><img style="width: auto; max-width: 400px;" src="<?php echo $pic?>"/><br/><?php endif; endforeach;?></td>
                </tr>
                
            <?php endforeach;?>
            </table>
</div>

<style>
    table{
        width: 500px;
        height: auto;
        min-height:300px;
        border:#000033 solid 0px;
        margin-left: 10%;
        margin-top: 5%
    }
    tr{
        margin-top:25px;
        
    }
    
    
</style>