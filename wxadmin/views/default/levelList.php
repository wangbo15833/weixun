<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>.
<style type="text/css">

</style>
    <div class="commodity_css">
        <h1>管理所有会员信息</h1><hr>
        <table class="shopTable">
            <tr>
                <th>用户名</th>
                <th>email</th>
                <th>创建时间</th>
                <th>最后更新时间</th>
                <th>状态</th>
                <th>身份类型</th>
                <th>操作</th>
            </tr>
            <?php if($shopsData):?>
                <?php foreach($shopsData as $item):?>
                    <tr>
                        <td width="10%"><?php echo $item['aname']?></td>
                        <td width="10%"><?php echo $item['email']?></td>
                        <td width="20%"><?php echo friendlyDate($item['createtime'])?></td>
                        <td width="30%"><?php echo friendlyDate($item['edittime'])?></td>
                        <td width="10%"><?php if($item['is_status'] == 1){ echo '正常';}else{echo '失效';}?></td>
                        <td width="10%"><?php if($item['is_type'] ==1){echo '商铺会员';}elseif($item['is_type'] ==2){echo '管理员';}else{echo 'BOSS';} ?></td>
                        <td width="10%">
                            <a href="javascript:checkspan('spanInfo',<?php echo $item['id']?>);" id="editOAuth<?php echo $item['id']?>" class="" >编辑</a>
                        <span class="Hide " id="spanInfo<?php echo $item['id']?>" >
                                <a href="<?php echo WEB_URL?>admin/editAuth?auth=1&id=<?php echo $item['id']?>" >商铺会员</a>
                                <a href="<?php echo WEB_URL?>admin/editAuth?auth=2&id=<?php echo $item['id']?>" >管理员</a>
                                <a href="<?php echo WEB_URL?>admin/editAuth?auth=3&id=<?php echo $item['id']?>" >BOSS</a>
                            </span>
                     </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr>
                    <td colspan="7"><span>暂时没有可显示的列表！</span></td>
                </tr>
            <?php endif;?>
        </table>

    </div>
    <div class="page , newinte_seepage"><?php echo $showPage?></div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script>
        function checkspan(name,id){
            $('#'+name+id).removeClass('Hide');
            $('#'+ 'editOAuth'+id).addClass('Hide');
        }
        $(document).ready(function(){
            /*
            $.ajax({
                url:getCommodity,
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
                        $('#commodityid').html(_string);
                        //alert('success!');
                    }else{
                        alert('false');
                    }
                }
            });*/
           })
    </script>
<?php endblock() ?>