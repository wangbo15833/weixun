<?php
include_once 'base.php';
?>
<?php startblock('header_css')?>
<link rel="stylesheet" href="<?php echo base_url()?>frontend/application/meituan/css/gallery.css" type="text/css" />
<?php endblock() ?>

<?php startblock('content') ?>
<form  name="picUploadForm" id="picUploadForm" method="post" action="<?php echo WEB_URL?>live/do_upload">
    <div class="upload_photo">
        <div class="upload-tit">
            <h6 class="tit">上传图片-<?php echo $h_info['name']?></h6>
        </div>
        <div class="upload_list Hide">
            <ul>
                <li style="z-index: 1000;">
                    <div class="pic"><img src="../../../frontend/application/meituan/ele.me_files/nbg.jpg"></div>
                    <div class="list">
                        <div class="txt">
                            <strong>类型：</strong>
                            <?php foreach($cate as $cItem):?>
                                <label class="sort" for="tag30207533_<?php echo $cItem['id']?>">
                                    <input type="radio" data-suggest="tg<?php echo $cItem['id']?>" name="ta" id="tag30207533_<?php echo $cItem['id']?>" value="<?php echo $cItem['id']?>"><?php echo $cItem['name']?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="txt " id="v_30207533_0">
                            <strong>标题：</strong>
                            <input type="text" autocomplete="off" maxlength="20" placeholder="这张图拍的是什么？" id="defaultPicTitle"  value="" name="defaultPicTitle">
                        </div>
                        <div class="Hide" id="v_30207533_2">
                            <div class="txt" id="g_list">
                                <strong>菜名：</strong>
                                <div class="name" id="name_hide_b" style="overflow: visible;">
                                    <?php if($cate_s){
                                        foreach($cate_s as $sItem):?>
                                            <a class=" c_name" href="#" onclick="c_stype('<?php echo $sItem['id']?>','<?php echo $sItem['name']?>')" ><?php echo $sItem['name']?></a>
                                        <?php endforeach; }?>
                                    <input type="text" id="add_stype" maxlength="10" placeholder="自己写" name="" class="">
                                    <input type="button" class="btn_confirm" id="btn_confirmadd">
                                </div>
                                <div class="name Hide" id="hid_Hide">
                                    <a class="c_name" href="#" id="hid_cname"></a>
                                </div>
                            </div>
                            <div class="txt">
                                <strong>价格：</strong>
                                <div class=""><input type="text" autocomplete="off" maxlength="6" class="input_price" name="price" id="price">元</div>
                            </div>
                        </div>
                    </div>
                    <a title="删除图片" href="javascript:" class="Hide ">删除图片</a>
                </li>
            </ul>
        </div>
        <div class="add_photobox">
            <div title="添加图片" class="btn_add">
                <input type="file" name="gourmetFiledata" id="gourmetFiledata" multiple="true" />
                <span class="tips">按住Ctrl或Shift可以多选图片<br>单张图片不超过5MB，尺寸不小于300*300px，支持jpg、png和bmp</span>
            </div>
            <div class="add_tips">
                <p><span>·请勿盗用他人的图片</span><span>·请勿上传有色情内容的违规图片</span></p>
            </div>
            <div class="photo_end ">
                <input type="hidden" id="hid_title" name="hid_title" value=""> <!--小分类id-->
                <input type="hidden" id="hid_name" name="hid_name" value=""> <!--标题-->
                <input type="hidden" id="hid_price" name="hid_price"/><!--单价-->
                <input type="hidden" id="hid_pics" name="hid_pics"/>    <!--图片str-->
                <input type="hidden" id="state" name="state" value="2">
                <input type="hidden" id="hid_id" name="hid_id">     <!--大分类id-->
                <input type="hidden" id="gourmetid" name="gourmetid" value="<?php echo $gourmetid?>">    <!--店铺id-->
                <input type="hidden" id="cid" name="cid" value="<?php echo $cid?>">
                <a class="btn_disabled " id="btn_disabled" title="保存" href="javascript:">保存</a>
                <a class="btn_cancel_disab" id="btn_cancel_disab" title="取消" onclick="window.history.go(-1);" href="javascript:">取消</a>
            </div>
        </div>
        <div class="aside aside-right"></div>
</form>
<?php endblock() ?>

<?php startblock('foot_js')?>
<script>
    $(document).ready(function(){
        $('#btn_disabled').click(function(){
            $('#picUploadForm').submit();
        });

        $('#defaultPicTitle').change(function(){
            $('#hid_name').val($('#defaultPicTitle').val());
        });
        $('#price').change(function(){
            $('#hid_price').val($('#price').val());
        });

        $('#tag30207533_1').click(function(){
            $('#v_30207533_0').addClass('Hide');
            $('#v_30207533_2').removeClass('Hide');
            $('#hid_id').val($('#tag30207533_1').val());
        });
        $('#tag30207533_2').click(function(){
            $('#v_30207533_0').removeClass('Hide');
            $('#v_30207533_2').addClass('Hide');
            $('#hid_id').val($('#tag30207533_2').val());
        });
        $('#tag30207533_3').click(function(){
            $('#v_30207533_0').removeClass('Hide');
            $('#v_30207533_2').addClass('Hide');
            $('#hid_id').val($('#tag30207533_3').val());
        });
        $('#btn_confirmadd').click(function(){
            var stype = $('#add_stype').val();
            var gid = $('#gourmetid').val();
            var parentid = $('#hid_id').val();
            $.ajax({
                url: base_url +'gourmet/add_types',
                type:'post',
                dataType:'json',
                data:{name:stype,gourmetid:gid,parentid:parentid},
                success:function(data){
                    if(data.status == 1){
                        $('#name_hide_b').addClass('Hide');
                        $('#hid_Hide').removeClass('Hide');
                        $('#hid_cname').html(stype);
                        $('#hid_title').val(data.data);
                    }
                }
            })
        });
    })
    function c_stype(id,name){
        $('#name_hide_b').addClass('Hide');
        $('#hid_Hide').removeClass('Hide');
        $('#hid_cname').html(name);
        $('#hid_title').val(id);
    }
</script>
<?php endblock() ?>
