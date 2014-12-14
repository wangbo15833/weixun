/**
 * Created with JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-7-26
 * Time: 下午4:03
 * To change this template use File | Settings | File Templates.
 */
var add_message_url = base_url + "goods/add_appraisal";
var add_sc_url = base_url + "index/add_sc";

var map = new BMap.Map("container");          // 创建地图实例
var point = new BMap.Point($('#hid_map_x').val(), $('#hid_map_y').val());  // 创建点坐标
map.centerAndZoom(point, 16);                 // 初始化地图，设置中心点坐标和地图级别
// window.setTimeout(function(){       //2秒后平移地图
//     map.panTo(new BMap.Point(116.409, 39.918));
//  }, 2000);
map.addControl(new BMap.NavigationControl());//标准地图控件
map.addControl(new BMap.ScaleControl()); //比例尺控件
map.addControl(new BMap.OverviewMapControl());
//map.addControl(new BMap.MapTypeControl());//地图显示类型控件 ：普通、卫星、三维 地图

var marker = new BMap.Marker(point);        // 创建标注
map.addOverlay(marker);                     // 将标注添加到地图中



show_message();
$('#messBtn').click(function () {
    var star1 = $('#hid_star').val();
    var star2 = $('#hid_star2').val();
    var star3 = $('#hid_star3').val();
    if (star1 == '') {
        art.dialog({
            time: 2,
            width: '20em',
            height: 55,
            content: '请给总体评价打分！'
        });
        return false;
    }
    if (star2 == '') {
        art.dialog({
            time: 2,
            width: '20em',
            height: 55,
            content: '请给服务打分！'
        });
        return false;
    }
    if (star3 == '') {
        art.dialog({
            time: 2,
            width: '20em',
            height: 55,
            content: '请给环境打分！'
        });
        return false;
    }
    $.ajax({
        url: add_message_url,
        type: 'post',
        dataType: 'json',
        data: {message: $('#messText').val(), hid_id: $('#hid_id').val(),hid_cid:$('#hid_cid').val(), star1: star1, star2: star2, star3: star3},
        success: function (data) {
            if (data.status == 0) {
                art.dialog({
                    time: 2,
                    width: '20em',
                    height: 55,
                    content: '请登录以后评论！'
                });
            } else {
                art.dialog({
                    time: 2,
                    width: '20em',
                    height: 55,
                    content: '评论成功！'
                });
                show_message();
            }
            $('#messText').val('');
        }
    })
})
    function show_message() {
        $.ajax({
            url: base_url + "goods/get_appraisal_list",
            type: 'post',
            dataType: 'json',
            data: {hid_id: $('#hid_id').val(), hid_cid:$('#hid_cid').val()},
            success: function (data) {
                if (data.status == 1) {
                    data = data.data;
                    var _str = '';
                    //console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        //<span class="common-rating"><span style="width:100%" class="rate-stars"></span></span>
                        _str += '<li>\
                                        <div class="info cf">\
                                        <div class="rate-status"></div>\
                                        <span  class="name">' + data[i].username + '</span>\
                                        <span class="growth-info"><i title="等级VIP1" class="level-icon level-icon-1"></i></span>\
                                        <span class="time">' + data[i].dateline + '</span>\
                                        </div>\
                                        <p class="content">' + data[i].commented_info + '</p>\
                                    </li>';
                    }
                    if (_str.length == 0) _str = '<li class="no-review-tip">暂无该类型评价</li>';
                    $('.review-list').html(_str);
                }
            }
        })
    }

$('#shoucang').click(function () {
    //alert(111);
    $.ajax({
        url: add_sc_url,
        type: 'post',
        dataType: 'json',
        data: {hid_id: $('#hid_id').val(), channel_id: $('#hid_cid').val()},
        success: function (data) {
            //eval('('+data+')');
            if (data.status == 0) {
                art.dialog({
                    time: 2,
                    width: '20em',
                    height: 55,
                    content: '请登录以后收藏!'
                });
            } else {
                art.dialog(
                    //content: '收藏成功！'
                    //follow: document.getElementById('btn2'),
                    {
                        time: 2,
                        width: '20em',
                        height: 55,
                        content: '收藏成功！',
                        lock: true,
                        style: 'succeed noClose'
                    },

                    function () {
                        // alert('你点了确定');
                    });
                $('#shoucang').html('已收藏本单').unbind('click');
            }
            //$('#sho ucang').addClass('in-favorite');
        }
    })
});

