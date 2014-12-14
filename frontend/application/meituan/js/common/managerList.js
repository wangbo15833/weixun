/**
 * Created with JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-10-11
 * Time: 上午10:17
 * To change this template use File | Settings | File Templates.
 */

function tab(o, s, cb, ev) {//tab切换类
    var $ = function (o) {
        return document.getElementById(o)
    };
    var css = o.split((s || '_'));
    if (css.length != 4)return;
    this.event = ev || 'onclick';
    o = $(o);
    if (o) {
        this.ITEM = [];
        o.id = css[0];
        var item = o.getElementsByTagName(css[1]);
        var j = 1;
        for (var i = 0; i < item.length; i++) {
            if (item[i].className.indexOf(css[2]) >= 0 || item[i].className.indexOf(css[3]) >= 0) {
                if (item[i].className == css[2])o['cur'] = item[i];
                item[i].callBack = cb || function () {
                };
                item[i]['css'] = css;
                item[i]['link'] = o;
                this.ITEM[j] = item[i];
                item[i]['Index'] = j++;
                item[i][this.event] = this.ACTIVE;
            }
        }
        return o;
    }
}
tab.prototype = {
    ACTIVE: function () {
        var $ = function (o) {
            return document.getElementById(o)
        };
        this['link']['cur'].className = this['css'][3];
        this.className = this['css'][2];
        try {
            $(this['link']['id'] + '_' + this['link']['cur']['Index']).style.display = 'none';
            $(this['link']['id'] + '_' + this['Index']).style.display = 'block';
        } catch (e) {
        }
        this.callBack.call(this);
        this['link']['cur'] = this;
    }
}
new tab('tabCot_product-li-currentBtn-', '-');
//加载日历控件

$.datepicker.regional['zh-CN'] =
{

    clearText: '清除', clearStatus: '清除已选日期',
    closeText: '关闭', closeStatus: '不改变当前选择',
    prevText: '&lt;上月', prevStatus: '显示上月',
    nextText: '下月&gt;', nextStatus: '显示下月',
    currentText: '今天', currentStatus: '显示本月',
    monthNames: ['一月', '二月', '三月', '四月', '五月', '六月',
        '七月', '八月', '九月', '十月', '十一月', '十二月'],
    monthNamesShort: ['一', '二', '三', '四', '五', '六',
        '七', '八', '九', '十', '十一', '十二'],
    monthStatus: '选择月份', yearStatus: '选择年份',
    weekHeader: '周', weekStatus: '年内周次',
    dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
    dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
    dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
    dayStatus: '设置 DD 为一周起始', dateStatus: '选择 m月 d日, DD',
    dateFormat: 'yy-mm-dd', firstDay: 1,
    initStatus: '请选择日期', isRTL: false
};
$.datepicker.setDefaults($.datepicker.regional['zh-CN']);
$("#datepicker").datepicker({
    changeMonth: true,
    changeYear: true, yearRange: 'c-40:c+10'//前30年和后10年
});
//分页
$("#myshoucang").click(function () {
    show_shoucang(1);
});
$("#firstPage_a").click(function () {
    show_shoucang($("#firstPage_a").attr('rel'));
});
$("#upPage_a").click(function () {
    show_shoucang($("#upPage_a").attr('rel'));
});
$("#downPage_a").click(function () {
    show_shoucang($("#downPage_a").attr('rel'));
});
$("#endPage_a").click(function () {
    show_shoucang($("#endPage_a").attr('rel'));
});

$('#info_1').click(function () {
    $('#infos_base').css('display', 'block');
    $('#infos_picture').css('display', 'none');
    $('#infos_detail').css('display', 'none');
    $('#infos_pass').css('display', 'none');
    $('#info_1').addClass('current');
    $('#info_4').removeClass('current');
    $('#info_3').removeClass('current');
    $('#info_2').removeClass('current');
});
$('#info_2').click(function () {
    $('#infos_base').css('display', 'none');
    $('#infos_picture').css('display', 'none');
    $('#infos_detail').css('display', 'block');
    $('#infos_pass').css('display', 'none');
    $('#info_2').addClass('current');
    $('#info_4').removeClass('current');
    $('#info_3').removeClass('current');
    $('#info_1').removeClass('current');
});
$('#info_3').click(function () {
    $('#infos_base').css('display', 'none');
    $('#infos_picture').css('display', 'block');
    $('#infos_detail').css('display', 'none');
    $('#infos_pass').css('display', 'none');
    $('#info_3').addClass('current');
    $('#info_4').removeClass('current');
    $('#info_1').removeClass('current');
    $('#info_2').removeClass('current');
});
$('#info_4').click(function () {
    $('#infos_base').css('display', 'none');
    $('#infos_picture').css('display', 'none');
    $('#infos_detail').css('display', 'none');
    $('#infos_pass').css('display', 'block');
    $('#info_4').addClass('current');
    $('#info_1').removeClass('current');
    $('#info_3').removeClass('current');
    $('#info_2').removeClass('current');
});

if ($('#reset-form').valid()) {
    $('#reset_pwd').removeAttr("disabled");
}

$('#mfind').click(function () {
    getFinds(1);
})
$("#firstPage_a1").click(function () {
    getFinds($("#firstPage_a1").attr('rel'));
});
$("#upPage_a1").click(function () {
    getFinds($("#upPage_a1").attr('rel'));
});
$("#downPage_a1").click(function () {
    getFinds($("#downPage_a1").attr('rel'));
});
$("#endPage_a1").click(function () {
    getFinds($("#endPage_a1").attr('rel'));
});

//获取分页数据
function show_shoucang(page) {
    //alert("111");
    $.ajax({
        url: base_url + "lists/show_coll",
        type: 'post',
        dataType: 'json',
        data: {'page': page},
        success: function (data) {
            var _str = '';
            if (data.status == 1) {
                var pages = data.count;
                var infos = data.sclist;
                var i_length = infos.length;
                var i = 0;
                if (i_length > 0) {
                    for (i; i < i_length; i++) {
                        _str += '<tr class="alt">\
                            <td width="200">\
                            <table class="deal-info">\
                            <tbody>\
                            <tr>\
                            <td>\
                            <a title="' + infos[i].title + '"  target="_blank" href="' + infos[i].url + '">\
                            <img width="75" height="46" src="' + infos[i].photos + '">\
                            </a>\
                            </td>\
                            <td>\
                            <a class="deal-title" target="_blank" title="' + infos[i].title + '"  href="' + infos[i].url + '">' + infos[i].sub_title + '</a>\
                            </td>\
                            </tr>\
                            </tbody>\
                            </table>\
                            </td>\
                            <td width="200">\
                            <span>￥</span>' + infos[i].new_price + '\
                            </td><td width="200">';
                        if (infos[i].is_status == 2) {
                            _str += '进行中'
                        } else {
                            _str += '已关闭'
                        }
                        _str += '</td>\
<td width="350">\
    <a class="small-link-button" target="_blank"  href="' + infos[i].url + '">查看</a>\
    <a  class="inline-link remove-collection"  href="' + infos[i].durl + '">移除</a>\
</td>\
</tr>';
                    }
                } else {
                    _str += '<tr class="alt">\
                            <td collspan="4">暂无可显示数据\
							</td>\
                            </tr>';
                }

            } else {
                //暂无可显示数据
            }
            $("#firstPage_a").attr('rel', pages.startPage);
            $("#upPage_a").attr('rel', pages.upPage);
            $("#downPage_a").attr('rel', pages.downPage);
            $("#endPage_a").attr('rel', pages.endPage);
            $('#collection-list').html(_str);
        },
        error: function (a, b, c) {
            alert(c);
        }
    });
}

function getFinds(page) {
    $.ajax({
        url: base_url + "find/getFind",
        type: 'post',
        dataType: 'json',
        data: {'page': page},
        success: function (data) {
            var _str = '';
            if (data.status == 1) {
                var pages = data.data.count;
                var infos = data.data.list;
                var i_length = infos.length;
                var i = 0;
                if (i_length > 0) {
                    for (i; i < i_length; i++) {
                        _str += '<tr class="alt">\
                            <td width="200">\
                            <table class="deal-info">\
                            <tbody>\
                            <tr>\
                            <td class="pic">\
                            <a title="' + infos[i].title + '"  target="_blank" href="' + infos[i].url + '">\
                            <img width="75" height="46" src="' + infos[i].photos + '">\
                            </a>\
                            </td>\
                            <td class="text">\
                            <a class="deal-title" target="_blank" title="' + infos[i].title + '"  href="' + infos[i].url + '">' + infos[i].sub_title + '</a>\
                            </td>\
                            </tr>\
                            </tbody>\
                            </table>\
                            </td>\
                            <td width="200">\
                            <span class="money"></span>' + infos[i].channel + '\
                            </td><td width="200">' + infos[i].content + '</td>\
                            <td width="350">\
                            <a class="small-link-button" target="_blank"  href="' + infos[i].url + '">查看</a>\
                            <a  class="inline-link remove-collection"  href="' + infos[i].durl + '">移除</a>\
                            </td>\
                            </tr>';
                    }
                } else {
                    _str += '<tr class="alt">\
                            <td collspan="4">暂无可显示数据\
							</td>\
                            </tr>';
                }

            } else {
                //暂无可显示数据
            }
            $("#firstPage_a1").attr('rel', pages.startPage);
            $("#upPage_a1").attr('rel', pages.upPage);
            $("#downPage_a1").attr('rel', pages.downPage);
            $("#endPage_a1").attr('rel', pages.endPage);
            $('#collection-list1').html(_str);
        }
    })
}
