<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
       <div class="commodity_css">
           <h1>审核商铺信息</h1>
           <hr>
           <table class="shopTable">
               <tr>
                   <th>名称</th>
                   <th>所有者</th>
                   <th>简介</th>
                   <th>内容</th>
                   <th>店铺类型</th>
                   <th>操作</th>
               </tr>
               <?php foreach($shopsData as $item):?>
                <tr>
                   <td width="10%"><?php echo $item['title']?></td>
                   <td width="10%"><?php echo $item['uid']?></td>
                   <td width="20%" title="<?php echo $item['summary']?>"><?php echo $item['summary1']?></td>
                   <td width="35%" title="<?php echo $item['content']?>"><?php echo $item['content1']?></td>
                   <td width="10%"><?php echo $item['type']?></td>
                   <td width="15%"><?php if($item['is_status'] >2):?>
                                    <a href="<?php echo WEB_URL?>shops/editShops/<?php echo $item['id']?>/2">通过</a>
                                <?php else: ?><a href="<?php echo WEB_URL?>shops/editShops/<?php echo $item['id']?>/3">关闭</a><?php endif;?></td>
                </tr>
            <?php endforeach;?>
           </table>
       </div>
       <input type="hidden" id="state" value="<?php echo $state?>"/>
       <div class="page newinte_seepage"><?php echo $showPage?></div>
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
           /* var a = $('#shops_id').val();
            var values = {shopsid:a};
           $.ajax({
                url:getCommodityInfo,
                type:'POST',
                dataType:'json',
                data:values,
                success:function(data){
                   // console.log(data);
                   var _string ='';
                    if(data.status ==1){
                        var data = data.data;
                        var count = data.length;
                        for(var i=0 ; i< count; i++){
                           _string +='<li><span>'+ data[i]['title'] +'</span><span title="'+data[i]['jianjie']+'">'+data[i]['sub_jianjie']+'</span><span>'+data[i]['price']+'</span><span><a href="'+web_url+'wxadmin.php/shops/index/show_edit_commodity/'+data[i]['id']+'"><img src="'+web_url+'frontend/wxadmin/default/images/edit.gif"></a><a href="'+web_url+'wxadmin.php/shops/index/delCommodityInfo/'+data[i]['id']+'"><img onClick="javascript:delcfm();" src="'+web_url+'frontend/wxadmin/default/images/del.jpg"></a></span></li>';
                        }
                        //alert('success!');
                    }else{
                        _string +='<li style="clear: none; width: 400px;text-align: center ;"><h2>暂时无可显示记录！</h2></li>';
                    }
                    $('#ul_commodity').append(_string);
                }
            });*/
        })
    </script>
    <?php endblock() ?>
