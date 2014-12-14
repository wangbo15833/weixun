<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
    <div class="commodity_css">
        <form id="" class="" method="post" action="<?php echo WEB_URL?>shops/editShopsInfo">
            <label style="padding-left: 500px;"><h1>编辑商户信息</h1><hr></label>
            <?php foreach($arr as $i):?>
                <table>
                <tr>
                    <td>标&nbsp;&nbsp;&nbsp;&nbsp;题：</td><td><input type="text" name="title" id="title" class="" value="<?php echo $i['title']?>"/></td>
                </tr>
                <tr>
                    <td>简&nbsp;&nbsp;&nbsp;&nbsp;介：</td><td><textarea name="summary" style="width:400px;height:50px;"><?php echo $i['summary']?></textarea></td>
                </tr>
                <tr>
                    <td>联系方式：</td><td><input type="text" name="phone" id="phone" class="" value="<?php echo $i['phone']?>"/></td>
                </tr>
                
                <tr>
                    <td>内&nbsp;&nbsp;&nbsp;&nbsp;容：</td><td><textarea name="content" style="width:700px;height:300px;visibility:hidden;"><?php echo $i['content']?></textarea></td>
                </tr>
                <tr>
                    <td>标&nbsp;&nbsp;&nbsp;&nbsp;签：</td><td><input type="text" name="tag" id="tag" class="" value="<?php echo $i['tag']?>"/></td>
                </tr>
                
                <tr>
                    <td colspan="2" style="text-align: center"><input type="hidden" name="id" id="id" value="<?php echo $i['id']?>" />
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
            $.ajax({
                url:getshopsInfoById,
                type:'POST',
                dataType:'json',
               // data:values,
                success:function(data){
                   // console.log(data);
                    if(data.status ==1){
                        var data = data.data;
                        var count = data.length;
                        var _string ='';
                        for(var i=0 ; i< count; i++){
                           _string +='<option value="'+data[i]['id']+'">'+data[i]['title']+'</option>';
                        }
                        $('#shops_id').html(_string);
                        //alert('success!');
                    }else{
                        alert('false');
                    }
                }
            });
           })
    </script>
<?php endblock() ?>