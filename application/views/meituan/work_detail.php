<?php
include_once 'base.php';
?>
<?php startblock('header_css')?>
    <link rel="stylesheet" href="<?php echo base_url()?>frontend/application/meituan/css/deal.vbefd55b3.css" />

<?php endblock() ?>

<?php startblock('content') ?>

    <div id="content">
        <input type="hidden" id="hid_cid" name="hid_cid" value="<?php echo $cid?>"/>

        <div class="coms_info">
            <div class="tit">企业名称:秦皇岛智隆网络科技有限公司</div>
            <div class="con"><div class="cominfo">
                    <li><b>所属行业：</b><?php echo $work['profession']?></li>
                    <li><b>所在地区：</b><?php echo $work['area_name']?></li>
                    <li><b>公司性质：</b><?php echo $work['property']?></li>
                    <li><b>成立日期：</b></li>
                    <li><b>注册资金：</b>0万元</li>
                    <li><b>公司规模：</b><?php echo $work['size']?></li>
                </div>
            </div>
        </div>
        <div class="hire_info">
            <div class="tit">职位名称:php开发工程师</div>
            <div class="con">
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="hiretab">
                    <tbody><tr>
                        <td width="70" align="right">招聘类别：</td>
                        <td> 全职</td>
                        <td width="70" align="right">招聘部门：</td>
                        <td> 无</td>
                        <td width="70" align="right">发布日期：</td>
                        <td><?php echo $work['creattime']?></td>
                        <td align="right">截止日期：</td>
                        <td>2014-03-17</td>
                    </tr>
                    <tr>
                        <td align="right">工作经验：</td>
                        <td><?php echo $work['life']?></td>
                        <td align="right">学历要求：</td>
                        <td><?php echo $work['education']?></td>
                        <td align="right">性别要求：</td>
                        <td>不限</td>
                        <td align="right">年龄要求：</td>
                        <td>						</td>
                    </tr>
                    <tr>
                        <td align="right">招聘人数：</td>
                        <td><?php echo $work['number']?></td>
                        <td align="right">薪资待遇：</td>
                        <td colspan="5"><?php echo $work['treatment']?></td>
                    </tr>
                    <tr>
                        <td align="right">专业要求：</td>
                        <td colspan="7">未填写</td>
                    </tr>
                    <tr>
                        <td align="right">工作地点：</td>
                        <td colspan="7"><?php echo $work['address']?></td>
                    </tr>
                    </tbody></table>

                <dl>
                    <dt>职位描述：</dt>
                    <dd>
                        <?php echo $work['description']?>
                    </dd>
                    <dt class="hirecontact">联系方式：</dt>
                    <dd>
                           <span id="hirecontact">
                           		<li><?php echo $work['address']?></li>
                                <li>联 系 人：林女士</li>
                                <li>联系电话：<?php echo $work['contact']?></li>
                                <li>电子邮件：linxiaoqing@zealnet.cn</li>
                                <li>注：请在邮件中注明应聘职位的名称或编号，并注明该招聘信息来源于发现网。</li>
							</span>
                        <script language="javascript">{Contact(52420,99833,0);}</script>
                    </dd>
                </dl>
                <li class="membercz"><input name="Submit4" type="button" class="inputcl" value="发送应聘意向" onclick="window.location='#'">　　<input name="Submit22" type="button" class="inputcl" value="放入收藏夹" onclick="window.location='#'"></li>
                <li><strong><font color="#ff0000" style="font-size:14px" face="黑体">注：</font></strong>如果您对以上职位感兴趣，请直接在该职位下进行"<font color="#ff6600"><strong>发送应聘意向</strong></font>"、"<font color="#ff6600"><strong>放入收藏夹</strong></font>"等操作。</li>

            </div>
        </div>

    </div>
    <div id="sidebar">
        <div id="c_shops_info" style="width: 240px; background-color: #ffffff; margin-bottom: 5px;"></div>
        <!----start map--->
        <input type="hidden" name="hid_map_x" id="hid_map_x" value="<?php echo $work['map_x'] ?>"/>
        <input type="hidden" name="hid_map_y" id="hid_map_y" value="<?php echo $work['map_y'] ?>"/>
        <div id="container" style="height: 200px;"></div>
    </div>
    <!--**************************************************right  start************************************************************************************************-->
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=D95ab8521dabc49243d995d83217505d"></script>
    <script type="text/javascript" src="<?php echo base_url()?>frontend/application/meituan/js/common/goods.js"></script>
    <script>//点击完善资料、路径
        $('.btn_bg').click(function () {
            if (parseInt($('#hid_id').val()) > 0)
                window.location.href = base_url + 'happy/happyEdit?g_id=' + $('#hid_id').val();
        });
    </script>
<?php endblock() ?>