<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
       <div><br>
           <h1>添加招聘信息</h1><hr/>
        <form id="addGourmet" name="addGourmet"  method="post" action="<?php echo WEB_URL?>work/addwork">
            <table align="center"> 
                <tr>
                  <td height="24">公司名称:</td>
                  <td><input type="text" name="name" id="title" /></td>
                </tr>
                <tr>
                    <td>公司规模:</td>
                    <td><input type="text" name="size" id="title" />
                    人（如1-50）</td>
                </tr>
                <tr>
                    <td>公司性质:</td>
                    <td><select  name="property">
                        <option value="1">国企</option>
						<option value="2">私企</option>
                        <option value="3">股份制</option>
                        </select></td>
                </tr>
                <tr>
                    <td>公司行业:</td>
                    <td><input type="text" name="profession" id="title" /></td>
                </tr>
                <tr>
                    <td>职位类型:</td>
                    <td>
                        <select id="position1" name="position1">
                            <option value="">--请选择--</option>
                        </select>
					    <select id="position2" name="position2">
					        <option value=""></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>职位标题:</td>
                    <td><input type="text" name="title" id="title" /></td>
                </tr>
                <tr>
                    <td>职位描述:</td><td><textarea name="content" style="width:700px;height:300px;visibility:hidden;"></textarea></td>
                </tr>
                
                <tr>
                    <td>薪资待遇:</td><td><input type="text" name="treatment" maxlength="20"/>元</td>
                </tr>
                <tr>
                    <td>学历要求:</td>
                    <td><input type="text" name="education" maxlength="20"/></td>
                </tr>
                <tr>
                    <td>工作年限:</td>
                    <td><input type="text" name="life" maxlength="20"/></td>
                </tr>
                <tr>
                    <td>招聘人数:</td>
                    <td><input type="text" name="number" maxlength="20"/></td>
                </tr>
                <tr>
                    <td>联系方式:</td>
                    <td><input type="text" name="contact" maxlength="20"/></td>
                </tr>
                <tr>
                    <td>所在地区：</td>
                    <td>
                        <select name="province" id="province">
                            <option value="-1">--省--</option>
                        </select>

                        <select name="city" id="city">
                            <option value="-1">--市--</option>
                        </select>

                        <select id="areaid" name="areaid">
                            <option value="">--区、县</option>
                        </select><i>注：请慎重填写，创建后不可更改</i>
                    </td>
                </tr>
                <tr>
                    <td>地址:</td><td><input type="text" id="address" name="address" maxlength=""/></td>
                </tr>
				<tr>
                    <td>具体街道地址:</td><td><input type="text" id="jd" name="jd" maxlength=""/></td>
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
    $.ajax({
        url: web_url +'index.php/work/get_position',
        type:'post',
        dataType:'json',
        data:{param_id:0},
        success:function(data){
            if(data.status == 1){
                data = data.data;
                var count=data.length;
                var _str = '';
                for(j=0;j< count; j++){
                    _str +='<option value="'+data[j].id+'">'+data[j].name+'</option>';
                }
                $('#position1').append(_str);
            }
        }
    })
$('#position1').change(function() {
        var pid = $('#position1').val();
        $.ajax({
            url: web_url +'index.php/work/get_position',
            type:'post',
            dataType:'json',
            data:{param_id:pid},
            success:function(data){
                if(data.status == 1){
                  data = data.data;  
                   var count=data.length;
                    var _str = '';
                  for(j=0;j< count; j++){
                      _str +='<option value="'+data[j].id+'">'+data[j].name+'</option>';
                  }
                  $('#position2').html(_str);
                }
            }
        })
     });
})
</script>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: web_url +'index.php/district/getDistrictByPid',
                type:'post',
                dataType:'json',
                data:{param_id:0},
                success:function(data){
                    if(data.status == 1){
                        data = data.data;
                        var count=data.length;
                        var _str = '';
                        for(j=0;j< count; j++){
                            _str +='<option value="'+data[j].did+'">'+data[j].dname+'</option>';
                        }
                        $('#province').append(_str);
                    }
                }
            })

            $('#province').change(function() {
                var pid = $('#province').val();

                $.ajax({
                    url: web_url +'index.php/district/getDistrictByPid',
                    type:'post',
                    dataType:'json',
                    data:{param_id:pid},
                    success:function(data){
                        if(data.status == 1){
                            data = data.data;
                            var count=data.length;
                            var _str = '';
                            for(j=0;j< count; j++){
                                _str +='<option value="'+data[j].did+'">'+data[j].dname+'</option>';
                            }
                            $('#city').append(_str);
                        }
                    }
                })
            })

            $('#city').change(function() {
                var pid = $('#city').val();

                $.ajax({
                    url: web_url +'index.php/district/getDistrictByPid',
                    type:'post',
                    dataType:'json',
                    data:{param_id:pid},
                    success:function(data){
                        if(data.status == 1){
                            data = data.data;
                            var count=data.length;
                            var _str = '';
                            for(j=0;j< count; j++){
                                _str +='<option value="'+data[j].did+'">'+data[j].dname+'</option>';
                            }
                            $('#areaid').html(_str);
                        }
                    }
                })
            })
        });

    </script>
<?php endblock() ?>