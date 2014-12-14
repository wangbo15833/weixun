<?php
include 'base.php';
?>
<?php startblock('header_css')?>
	<link rel="stylesheet" href="<?php echo base_url()?>frontend/application/default/css/list.css" />
    <link type="text/css" href="http://i2.dpfile.com/s/c/user/usercenter.min.d071b9a39fd07c627fbea3fc0281a845.css" rel="stylesheet">
<?php endblock() ?>
<?php startblock('content') ?>
<div id="content" class="mainbox mine">
	<div class="dashboard">
		<ul id="tabCot_product-li-currentBtn-">
            <li class="currentBtn">
                <a href="javascript:void(0)">我的设置</a>
            </li>
            <li>
                <a href="javascript:void(0)" id="myshoucang">我的收藏</a>
            </li>
            <li>
                <a href="javascript:void(0)" id="mfind">管理我发现</a>
            </li>
		</ul>
	</div>
	<div class="mainbox mine" id="tabCot_product_1">
        <ul class="filter cf">
            <li id="info_1" class="current">
                <a  href="#"  >基本资料</a>
            </li>
            <li id="info_2">
                <a  href="#"  >详细资料</a>
            </li>
            <li id="info_3">
                <a  href="#"  >个人头像</a>
            </li>
            <li id="info_4">
                <a  href="#" >修改密码</a>
            </li>
        </ul>
        <div id="infos" class="notice">
            <!--基本资料-->
            <div id="infos_base" class="modebox setup-box setup-basic mainbox">
                <div class="hd"><span class="col-exp">(<i class="col-notice">*</i>为必须填写项)</span></div>
                <div class="con"><p class="col-hints">为了让各位DPer了解你，以下信息将显示在个人资料页（工作地和住处不会显示）。</p>
                    <div class="form-box">
                        <form id="basciForm" method="post" action="<?php echo WEB_URL?>lists/edit_user_base">
                            <ul><li>
                                    <div class="tit"><i class="col-notice">*</i><label>昵称：</label></div>
                                    <div class="f-part">
                                        <input type="text" value="<?php echo $list_u['nickname']?>" placeholder="请输入昵称" id="J_nickname" maxlength="24" class="input-plain itxt-s J_ph focus" name="userNickName">
                                    </div>
                                    <div class="f-msg Hide"></div>
                                </li><li>
                                    <div class="tit"><label>性别：</label></div>
                                    <div class="f-part f-iradio">
                                        <input type="radio" value="1" class="radio-plain" <?php if($list_u['sex'] == 1):?> checked="checked" <?php endif;?> name="userSex"><label for="">男</label>
                                        <input type="radio" value="0" class="radio-plain" <?php if($list_u['sex'] == 0):?> checked="checked" <?php endif;?> name="userSex"><label for="">女</label>
                                    </div></li><li>
                                    <div class="tit"><i class="col-notice">*</i><label for="">常居地：</label></div>
                                    <div class="f-part">
                                        <input type="text" value="<?php echo $list_u['address']?>" id="J_user_city" placeholder="请选择您居住的城市" class="input-plain itxt-s J_ph focus" name="userCityName">
                                    </div><div class="f-msg Hide">
                                        <!--<span class="m-err">请填写现居地</span>
                                        -->
                                        </div>
                                </li>
                                <li>
                                    <div class="tit"><label for="">联系电话：</label></div>
                                    <div class="f-part">
                                        <input type="text" value="<?php echo $list_u['tel']?>" id="J_user_phone" placeholder="填写联系电话" class="input-plain itxt-s J_ph focus" name="userTelName">
                                    </div>
                                </li>
                                <li>
                                    <div class="tit"><label for="">邮箱：</label></div>
                                    <div class="f-part">
                                        <input type="text" value="<?php echo $list_u['email']?>" id="J_user_email" placeholder="填写邮箱" class="input-plain itxt-s J_ph focus" name="userEmailName">
                                    </div>
                                </li>
                                <li>
                                    <div class="tit"><label for="">自我介绍：</label></div>
                                    <div class="f-part"><textarea placeholder="简单介绍下自己，让更多Dper了解你吧~~" id="J_sign" class="tar-plain J_ph form-default" rows="5" cols="" name="userSign"><?php echo $list_u['present']?></textarea></div>
                                    <div class="f-msg tar-msg Hide">
                                        <span>最多输入200字</span>  </div> </li> </ul>
                            <div class="btn-box">
                                <span class="medi-btn"><button type="button" id="base_submit" class="btn-txt J_submit form-button">保存</button></span>
                                <input type="hidden" value="<?php echo $list_u['u_uid']?>" id="currentUserSign" name="currentUserSign">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--详细资料-->
            <div id="infos_detail" class="modebox setup-box setup-detail mainbox" style="display: none;">
                <div class="con"><p class="col-hints">为了让各位DPer了解你，以下信息将显示在个人资料页。</p>
                    <div class="form-box">
                        <form method="post" action="#" id="detailInfoForm">
                            <ul><li><div class="tit"><label for="">体型：</label></div>
                                    <div class="f-part">
                                        <select id="J_weight" style="width: 146px;">
                                            <option class="" value="保密" ><?php echo $list_u['weight'] ?></option>
                                            <option class="" value="保密" >保密</option>
                                            <option class="" value="清瘦">清瘦</option>
                                            <option value="匀称" class="">匀称</option>
                                            <option value="健壮" class="">健壮</option>
                                            <option value="球形">球形</option>
                                        </select>
                                    </div><div class="f-msg"></div></li><li>
                                    <div class="tit"><label for="">个人状况：</label></div>
                                    <div class="f-part f-iradio">
                                        <input type="radio" id="love1" <?php if($list_u['loveStatus'] == '单身'):?> checked="checked" <?php endif;?> value="单身" class="radio-plain J_love" name="loveStatus"><label for="love1">单身</label>
                                        <input type="radio" id="love2" <?php if($list_u['loveStatus'] == '热恋'):?> checked="checked" <?php endif;?> value="热恋" class="radio-plain J_love" name="loveStatus"><label for="love2">热恋</label>
                                        <input type="radio" id="love5" <?php if($list_u['loveStatus'] == '备婚'):?> checked="checked" <?php endif;?> value="备婚" class="radio-plain J_love" name="loveStatus"><label for="love5">备婚</label>
                                        <input type="radio" id="love3" <?php if($list_u['loveStatus'] == '已婚'):?> checked="checked" <?php endif;?> value="已婚" class="radio-plain J_love" name="loveStatus"><label for="love3">已婚</label>
                                        <input type="radio" id="love4" <?php if($list_u['loveStatus'] == '保密'):?> checked="checked" <?php endif;?> value="保密" class="radio-plain J_love" name="loveStatus"><label for="love4">保密</label>
                                    </div><div class="f-msg"></div> </li><li>
                                    <div class="tit"><label for="">生日：</label></div>
                                    <div class="f-part slt-box slt-birth">
                                        <input type="text" value="<?php echo $list_u['birthday'] ?>" id="datepicker" class="J_vad input-plain itxt-s"  name="datepicker">
                                    </div>
                                    <div class="f-msg"></div>
                                </li>
                                <li>
                                    <div class="tit"><label for="">星座：</label></div>
                                    <div class="f-part">
                                        <select id="select_Constellation" class="" style="width: 146px;"><option><?php echo $list_u['constellation'] ?></option><option class="">白羊座</option><option class="">金牛座</option><option class="">双子座</option><option class="">巨蟹座</option><option class="">狮子座</option><option class="">处女座</option><option class="">天秤座</option><option class="">天蝎座</option><option class="">射手座</option><option class="">摩羯座</option><option class="">水瓶座</option><option class="">双鱼座</option></select>
                                    </div>
                                    <div class="f-msg"></div>
                                </li>
                                <li>
                                    <div class="tit"><label for="">QQ/MSN：</label></div>
                                    <div class="f-part f-iradio">
                                        <input type="text" value="<?php echo $list_u['userQQ'] ?>" class="J_vad input-plain itxt-s" data-rules="qq" id="userQQ" name="profileBean.userQQ">
                                        <input type="radio" id="qqpub1" <?php if($list_u['isQQPublic'] == 'true'):?> checked="checked" <?php endif;?> value="true" class="radio-plain" name="isQQPublic"><label for="qqpub1">公开</label>
                                        <input type="radio" id="qqpub2" <?php if($list_u['isQQPublic'] == 'false'):?> checked="checked" <?php endif;?> value="false" class="radio-plain" name="isQQPublic"><label for="qqpub2">保密</label>
                                    </div>
                                    <div class="f-msg"></div>
                                </li>
                                <li>
                                    <div class="tit"><label for="">行业/职业：</label></div>
                                    <div class="f-part">
                                        <input type="text" value="<?php echo $list_u['job'] ?>" id="job" class="J_ph J_vad input-plain itxt-s form-default" data-rules="carre" placeholder="输入你所在的行业" name="profileBean.job">
                                    </div>
                                    <div class="f-msg"></div>
                                </li>
                                <li>
                                    <div class="tit"><label for="">大学：</label></div>
                                    <div class="f-part">
                                        <input type="text" value="<?php echo $list_u['university'] ?>" class="J_vad input-plain itxt-s" id="university" data-rules="colle" name="profileBean.university">
                                    </div>
                                    <div class="f-msg"></div>
                                </li>
                                <li>
                                    <div class="tit"><label for="">高中：</label></div>
                                    <div class="f-part">
                                        <input type="text" value="<?php echo $list_u['middleSchool'] ?>" class="J_vad input-plain itxt-s" id="middleSchool" data-rules="high" name="profileBean.middleSchool">
                                    </div>
                                    <div class="f-msg"></div>
                                </li>
                                <li>
                                    <div class="tit"><label for="">个人主页：</label></div>
                                    <div class="f-part">
                                        <input type="text" value="<?php echo $list_u['userHomePage'] ?>" class="J_vad input-plain itxt-l" id="userHomePage" data-rules="www" name="profileBean.userHomePage">
                                    </div>
                                    <div class="f-msg tar-msg"></div>
                                </li>
                                <li>
                                    <div class="tit"><label for="">爱好：<span class="col-exp">0/30</span></label></div>
                                    <div class="f-part"><textarea placeholder="如：睡觉、看书" class="J_ph J_vad tar-plain form-default" rows="2" id="interest" data-rules="favor" cols="" name="profileBean.interest"><?php echo $list_u['interest'] ?></textarea></div>
                                    <div class="f-msg tar-msg"></div>
                                </li>
                            </ul>
                            <div class="btn-box">
                                <span class="medi-btn"><button type="button" id="J_mato" class="btn-txt J_submit form-button">保存</button></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--个人头像-->
                <div id="infos_picture" class="modebox setup-box setup-avatar mainbox" style="display: none;">
                <div class="hd"><h3>个人头像</h3></div>
				<?php //echo $list_u['picture']; ?>
                <!--有头像-->
                <div class="con">
                    <p class="col-hints">
                <span class="medi-btn-shallow">
                    <input type="file" name="Filedata" id="Filedata" multiple="true" />
                </span>
                        <span id="J_err">支持JPG、PNG、GIF、BMP格式的图片文件，文件大小不小于5M</span>
                    </p>
                    <div class="avatar-box">
                        <div class="tit">
                            <h5>当前头像：</h5>
                        </div>
                        <div class="avatar-photo">
                            <ul>
                                <li class="photo-large"><img width="120" height="120" alt="用户头像" src="<?php echo $list_u['picture']; ?>" id="J_bface">大尺寸 120*120 像素</li>
                                <li class="photo-middle"><img width="48" height="48" alt="用户头像" src="<?php echo $list_u['picture']; ?>" id="J_sface">中尺寸 48*48 像素</li>
                            </ul>
                        </div>
                        <form method="post" action="#">
                            <div class="btn-box">
                                <input type="hidden" id="hid_pic" value=""/>
                                <span class="medi-btn-ashdisb"><button type="button" id="J_usave"  class="btn-txt J_submit form-button">保存</button></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--修改密码-->
            <div id="infos_pass" class="mainbox" style="display: none;">
                <h2>重设密码</h2>
                <form method="post" id="reset-form" action="#">
                    <div id="yui_3_8_0_2_1369296685340_17" class="field-group">
                        <label class="f-label" for="reset-password">旧密码</label>
                        <input type="password" class="f-text" name="password" value="" id="password" maxlength="32"/>
                        <div></div>
                       </div>
                    <div id="yui_3_8_0_2_1369296685340_17" class="field-group">
                        <label class="f-label" for="reset-password">新密码</label>
                        <input type="password" class="f-text" name="reset-password" value="" id="reset-password" maxlength="32">
                        <span style="display: none;" class="inline-tip"></span></div>
                    <div id="yui_3_8_0_2_1369296685340_19" class="field-group">
                        <label class="f-label" for="reset-password2">重复密码</label>
                        <input type="password" class="f-text" name="reset-password2" value="" id="reset-password2" maxlength="32">
                        <label></label>
                    </div>
                    <div id="yui_3_8_0_1_1369296685340_119" class="field-group">
                        <input type="hidden" name="code" value="j5XECk5NWue3_7CevQF8fdwN9ZcKoVxW">
                        <input type="button" class="form-button" disabled="false" id="reset_pwd" value="重设密码">
                    </div>
                </form>
            </div>
        </div>
	</div>

	<div class="mainbox mine" id="tabCot_product_2" style="display: none;">
        <div class="table-section" >
            <table id="" cellspacing="0" cellpadding="0" border="0">
                <tbody id="yui_3_8_0_2_1371203090835_10">
                <tr>
                    <th width="200">名称</th>
                    <th width="200">金额</th>
                    <th width="200">状态</th>
                    <th width="350">操作</th>
                </tr>
                </tbody>
            </table>
            <table id="collection-list"></table>
            <div id="" class="page newinte_seepage">
                <a  id ="firstPage_a" rel="" href="javascript:;">首页</a>
                <a id ="upPage_a" rel="" href="javascript:;">上一页</a>
                <a id ="downPage_a" rel="" href="javascript:;">下一页</a>
                <a id ="endPage_a"  rel="" href="javascript:;">尾页</a>
            </div>
        </div>
	</div>

	<div class="mainbox mine" id="tabCot_product_3" style="display: none;">
        <div  class="table-section">
            <table id="" cellspacing="0" cellpadding="0" border="0">
                <tbody id="yui_3_8_0_2_1371203090835_10">
                <tr>
                    <th width="200">名称</th>
                    <th width="200">频道</th>
                    <th width="200">简介</th>
                    <th width="350">操作</th>
                </tr>
                </tbody>
            </table>
            <table id="collection-list1"></table>
            <div id="" class="page newinte_seepage">
                <a  id ="firstPage_a1" rel="" href="javascript:;">首页</a>
                <a id ="upPage_a1" rel="" href="javascript:;">上一页</a>
                <a id ="downPage_a1" rel="" href="javascript:;">下一页</a>
                <a id ="endPage_a1"  rel="" href="javascript:;">尾页</a>
            </div>
        </div>
	</div>
</div>
<?php endblock() ?>
<?php startblock('foot_js')?>
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.datepicker.js"></script>
    <script src="<?php echo base_url() ?>frontend/application/default/js/managerList.js"></script>
<?php endblock() ?>