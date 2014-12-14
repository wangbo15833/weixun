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
        margin:25px;
        border: 1px #95BCE2 solid;
        padding: 5px;;
    }


</style>

<div class="show_fancybox">
    
    <table>

                <tr>
                    <td>用户名:</td><td><label><?php echo $shopsInfo['uid']?></label></td>
                </tr>
                <tr>
                    <td>标题:</td><td><label><?php echo $shopsInfo['title']?></label></td>
                </tr>
                <tr>
                    <td>简介:</td><td><label><?php echo $shopsInfo['summary']?></label></td>
                </tr>
                <tr>
                    <td>内容:</td><td><label><textarea cols=40 rows=10 name=text style="overflow:auto"><?php echo $shopsInfo['content']?></textarea></label></td>
                </tr>
                <tr>
                    <td>联系电话:</td><td><label><?php echo $shopsInfo['phone']?></label></td>
                </tr>
                <tr>
                    <td>属性标签:</td><td><lable><?php echo $shopsInfo['tag']?></lable></td>
                </tr>
                <tr>
                    <td>发布时间:</td><td><label><?php echo $shopsInfo['pubdate']?></label></td>
                </tr>
                <tr>
                    <td >图片</td><td><div id="picK"></div><?php foreach($shopsInfo['pics'] as $pic): if(!$pic):?>暂时无可显示图片！<?php else:?><img style="width: auto; max-width: 400px;" src="<?php echo $pic?>"/><br/><?php endif; endforeach;?></td>
                </tr>

            </table>
</div>


