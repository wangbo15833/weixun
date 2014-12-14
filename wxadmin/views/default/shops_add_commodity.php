<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
       <div class="commodity_css">
           <h1>添加新商品</h1><hr>
        <form id="modify_pwd_table"  class="addNewCommodity" method="post" action="<?php echo WEB_URL?>shops/index/addCommodityInfo">
            <input type="hidden" name="token" value="<?php echo $token?>"/>
            <input type="hidden" name="commodityState" value="1" />
            <table>
                <tr>
                    <td>商品标题:</td><td><input type="text" name="title" id="title" /></td>
                </tr>
                <tr>
                    <td>所属商铺:</td><td>
                        <select id="shops_id" name="shops_id">
                            <option>请选择</option>
                            <?php foreach($shopsinfo as $si):?>
                                <option value="<?php echo $si['id']?>"><?php echo $si['title']?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>商品类型:</td><td><select name="type" id="type" style="float: left;margin-right: 5%;">
                            <option value="0">请选择</option>
                            <?php foreach($category as $item):?>
                                   <option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
                            <?php endforeach;?>
                    </select>
                    <select name="type1" id="type1"><option value="">--暂无分类--</option></select>
                        </td>
                </tr>
                <tr>
                    <td>商品简介:</td><td><textarea name="jianjie" style="width:300px;height:100px;"></textarea></td>
                </tr>
                <tr>
                    <td>商品内容:</td><td><textarea name="content" style="width:700px;height:300px;visibility:hidden;"></textarea></td>
                </tr>
                <tr>
                    <td>商品单价:</td><td><input type="text" name="price" id="price" /></td>
                </tr>
                <tr>
                    <td>商品折扣:</td><td><input type="text" name="discount" id="discount" />%</td>
                </tr>
                <tr>
                    <td colspan="2"><div id="picK"></div><input type="hidden" name="pics" id="pics" value=""></td>
                </tr>
                <tr>
                    <td>上传图片:</td><td><input type="file" name="Filedata" id="Filedata" multiple="true" /><h5 style="color: red;">仅支持jpg, jpeg, gif,png等 图片格式上传</h5></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"><input id="submit" type="submit"  value="提&nbsp;&nbsp;交"/></td>
                </tr>
            </table>
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
       /*     $.ajax({
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
            });*/
           })
    </script>
<?php endblock() ?>