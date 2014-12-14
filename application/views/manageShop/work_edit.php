<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
       <div><br>
           <h1>编辑招聘信息</h1><hr/>
        <form  method="post" action="<?php echo WEB_URL?>work/editworktj/<?php echo $bj['id'];?>">
            <table align="center"> 
                <tr>
                  <td height="24">公司名称:</td>
                  <td><input type="text" name="name" id="title" value="<?php echo $bj['name'];?>"/></td>
                </tr>
                <tr>
                    <td>公司规模:</td>
                    <td><input type="text" name="size" id="title" value="<?php echo $bj['size'];?>"/>
                    人（如1-50）</td>
                </tr>
                <tr>
                    <td>公司性质:</td>
                    <td><select  name="property">
                        <option value="1" <?php if($bj['property']==1){echo 'selected="selected"';}?>>国企</option>
						<option value="2" <?php if($bj['property']==2){echo 'selected="selected"';}?>>私企</option>
                        <option value="3" <?php if($bj['property']==3){echo 'selected="selected"';}?>>股份制</option>
                        </select></td>
                </tr>
                <tr>
                    <td>公司行业:</td>
                    <td><input type="text" name="profession" id="title" value="<?php echo $bj['profession'];?>"/></td>
                </tr>
                <tr>
                    <td>职位类型:</td>
                    <td>
                        <select id="position1" name="position1">
                            <option value="">--请选择--</option>
                            <?php foreach( $positions as $cItem):?>
                                <option value="<?php echo $cItem['id']?>" <?php if($bj['position1'] == $cItem['id']){?>selected="selected" <?php } ?>><?php echo $cItem['name']?></option>
                            <?php endforeach;?>
                        </select>
					    <select id="position2" name="position2">
					        <option value="">--请选择--</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>职位标题:</td>
                    <td><input type="text" name="title" id="title" value="<?php echo $bj['title'];?>" /></td>
                </tr>
                <tr>
                    <td>职位描述:</td><td><textarea name="content" style="width:700px;height:300px;visibility:hidden;"><?php echo $bj['description'];?></textarea></td>
                </tr>
                
                <tr>
                    <td>薪资待遇:</td><td><input type="text" name="treatment" maxlength="20" value="<?php echo $bj['treatment'];?>"/>元</td>
                </tr>
                <tr>
                    <td>学历要求:</td>
                    <td><input type="text" name="education" maxlength="20" value="<?php echo $bj['education'];?>"/></td>
                </tr>
                <tr>
                    <td>工作年限:</td>
                    <td><input type="text" name="life" maxlength="20" value="<?php echo $bj['life'];?>"/></td>
                </tr>
                <tr>
                    <td>招聘人数:</td>
                    <td><input type="text" name="number" maxlength="20" value="<?php echo $bj['number'];?>"/></td>
                </tr>
                <tr>
                    <td>联系方式:</td>
                    <td><input type="text" name="contact" maxlength="20" value="<?php echo $bj['contact'];?>"/></td>
                </tr>
                <tr>
                    <td>所在区县：</td><td>
                        <select id="area" name="area">
                            <?php foreach( $areas as $cItem):?>
                                <option value="<?php echo $cItem['id']?>" <?php if($bj['area_id'] == $cItem['id']){?>selected="selected" <?php } ?>><?php echo $cItem['name']?></option>
                            <?php endforeach;?>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td>地址:</td><td><input type="text" id="address" name="address" maxlength=""/ value="<?php echo $bj['address'];?>"></td>
                </tr>
				<tr>
                    <td>具体街道地址:</td><td><input type="text" id="jd" name="jd" maxlength="" value="<?php echo $bj['jd'];?>"/></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center">
                        <input id="submit" type="submit"  value="提&nbsp;&nbsp;交"/></td>
                </tr>
            </table>
        </form>
        </div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/kindeditor-all.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/application/manageShop/js/base_addjs.js"></script>
    <script>
$(document).ready(function(){
    var pid=$('#position1').val();
    $.ajax({
        url: web_url +'wxadmin.php/work/get_position',
        type:'post',
        dataType:'json',
        data:{param_id:pid},
        success:function(data){
            if(data.status == 1){
                data = data.data;
                var count=data.length;
                var _str = '';
                for(j=0;j< count; j++){
                    _str +='<option value="'+data[j].id+'"';
					if(data[j]['id'] == <?php echo $bj['position2'];?>){
                        _str += 'selected="selected"';
                    }
					_str +='>'+data[j].name+'</option>';
                }
                $('#position2').append(_str);
            }
        }
    });


$('#position1').change(function() {
        var pid = $('#position1').val();
        $.ajax({
            url: web_url +'wxadmin.php/work/get_position',
            type:'post',
            dataType:'json',
            data:{param_id:pid},
            success:function(data){
                if(data.status == 1){
                  data = data.data;
                   var count=data.length;
                    var _str = '';
                  for(j=0;j< count; j++){
                    _str +='<option value="'+data[j].id+'"';
					if(data[j]['id'] == <?php echo $bj['position2'];?>){
						_str += 'selected="selected"';
					}
					_str +='>'+data[j].name+'</option>';
                  }
                  $('#position2').html(_str);
                }
            }
        })
     });
})
</script>
<?php endblock() ?>