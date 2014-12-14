/**
 * “行” 模块 地图功能函数 聚集地.
 * User: gefc
 * Date: 13-7-24
 * Time: 上午8:20
 * To change this template use File | Settings | File Templates.
 */
    var timeState =0;
var map = new BMap.Map("allmap");            // 创建Map实例
map.centerAndZoom(new BMap.Point(119.562599, 39.950826), 15);
map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
map.addControl(new BMap.ScaleControl());                    // 添加默认比例尺控件
/* 附件周边查询*/
var local = new BMap.LocalSearch(map, {
    renderOptions:{map: map, autoViewport:true, panel:"r-result" },
    pageCapacity: 9
});
local.search("秦皇岛市政府");
/*
$('#box1_txt').keyup(function(){
    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
        {"input" : "box1_txt"
            ,"location" : map
        });
    $('#hid_box1_txt').val($('#box1_txt').val());
    ac.setInputValue($("#hid_box1_txt").val());
    ac.addEventListener("click", function(e) {    //鼠标点击下拉列表后的事件
        $('#box1_txt').val(e.item.value);
    });
});*/
/*兼容ie、ff 地图自动补全特效 START*/
$(function()
{
    /*本地搜索起点框实时捕捉 start*/
    var jsUserName , jsUserNameStart , jsUserNameEnd = "";
    if($.browser.msie)        // IE浏览器
    {
        var c = $("#selectChange").val();
        if(c ==2){//公交、自驾搜索起点框实时捕捉 start
            $("#box2_start").get(0).onpropertychange = setJsUserNameStart;
            $("#hid_box2_start").get(0).onpropertychange = handleStart;
        }else if(c ==3){//公交、自驾搜索终点框实时捕捉 end
            $("#box2_end").get(0).onpropertychange = setJsUserNameEnd;
            $("#hid_box2_end").get(0).onpropertychange = handleEnd;
        }else{//本地搜索起点框实时捕捉
            $("#box1_txt").get(0).onpropertychange = setJsUserName;
            $("#hid_box1_txt").get(0).onpropertychange = handle;
        }
    }
    else        // 其他浏览器
    {
        var c = $("#selectChange").val();
        if(c ==2){
            var intervalNameStart;        // 定时器句柄
            $("#box2_start").get(0).addEventListener("input",setJsUserNameStart,false);
            // 获得焦点时，启动定时器
            $("#box2_start").focus(function(){
                intervalNameStart = setInterval(handleStart,1000);
            });

            // 失去焦点时，清除定时器
            $("#box2_start").blur(function()
            {
                clearInterval(intervalNameStart);
            });
        } else if(c ==3){
            var intervalNameEnd;        // 定时器句柄
            $("#box2_end").get(0).addEventListener("input",setJsUserNameEnd,false);
            // 获得焦点时，启动定时器
            $("#box2_end").focus(function(){
                intervalNameEnd = setInterval(handleEnd,1000);
            });

            // 失去焦点时，清除定时器
            $("#box2_end").blur(function()
            {
                clearInterval(intervalNameEnd);
            });
        }else{
            var intervalName;        // 定时器句柄
            $("#box1_txt").get(0).addEventListener("input",setJsUserName,false);
            // 获得焦点时，启动定时器
            $("#box1_txt").focus(function(){
                intervalName = setInterval(handle,1000);
            });

            // 失去焦点时，清除定时器
            $("#box1_txt").blur(function()
            {
                clearInterval(intervalName);
            });
        }
    }
    /*本地搜索起点框实时捕捉 end*/
    /* 公交、自驾搜索起点框实时捕捉 start*/

    /* 公交、自驾搜索起点框实时捕捉 end*/
    /* 公交、自驾搜索终点框实时捕捉 start*/

    /* 公交、自驾搜索终点框实时捕捉 end*/

    // 设置jsUserName input的值
    function setJsUserName()
    {
        $("#hid_box1_txt").val($(this).val());
    }
    // jsUserName input的值改变时执行的函数
    function handle()
    {
        if($.browser.msie){
            if('' == jsUserName){
            jsUserName = $("#hid_box1_txt").val();
            var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
                {"input" : "box1_txt"
                    ,"location" : map
                });
            ac.setInputValue($("#hid_box1_txt").val());
            //ac.search("box1_txt");
            ac.addEventListener("click", function(e) {    //鼠标点击下拉列表后的事件
                $('#box1_txt').val(e.item.value);
                //clearInterval(intervalName);
            });
            }
        }else{
        // IE浏览器此处判断没什么意义，但为了统一，且提取公共代码而这样处理。
        if($("#hid_box1_txt").val() != jsUserName )
        {
            jsUserName = $("#hid_box1_txt").val();
            var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
                {"input" : "box1_txt"
                    ,"location" : map
                });
            ac.setInputValue($("#hid_box1_txt").val());
            //ac.search("box1_txt");
            ac.addEventListener("click", function(e) {    //鼠标点击下拉列表后的事件
                $('#box1_txt').val(e.item.value);
                //clearInterval(intervalName);
            });
        }
        }
    }

    // 设置jsUserName input的值
    function setJsUserNameStart()
    {
        $("#hid_box2_start").val($("#box2_start").val());
    }
    // jsUserName input的值改变时执行的函数
    function handleStart()
    {
        // IE浏览器此处判断没什么意义，但为了统一，且提取公共代码而这样处理。
        if($("#hid_box2_start").val() != jsUserNameStart)
        {
            jsUserNameStart = $("#hid_box2_start").val();
            var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
                {"input" : "box2_start"
                    ,"location" : map
                });
            ac.setInputValue($("#hid_box2_start").val());
            ac.addEventListener("click", function(e) {    //鼠标点击下拉列表后的事件
                $('#box2_start').val(e.item.value);
                // clearInterval(intervalNameStart);
            });
        }
    }

    // 设置jsUserName input的值
    function setJsUserNameEnd()
    {
        $("#hid_box2_end").val($("#box2_end").val());
    }
    // jsUserName input的值改变时执行的函数
    function handleEnd()
    {

        // IE浏览器此处判断没什么意义，但为了统一，且提取公共代码而这样处理。
        if($("#hid_box2_end").val() != jsUserNameEnd )
        {

            var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
                {"input" : "box2_end"
                    ,"location" : map
                });
            ac.setInputValue($("#hid_box2_end").val());
            jsUserNameEnd = $("#hid_box2_end").val();
            ac.addEventListener("click", function(e) {    //鼠标点击下拉列表后的事件
                $('#box2_end').val(e.item.value);
            });
        }
    }

});
/*兼容ie、ff 地图自动补全特效 END

$('#box2_start').keyup(function(){
    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
        {"input" : "box2_start"
            ,"location" : map
        });
    ac.addEventListener("click", function(e) {    //鼠标点击下拉列表后的事件
        $('#box2_start').val(e.item.value);
    });
});
$('#box2_end').keyup(function(){
    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
        {"input" : "box2_end"
            ,"location" : map
        });
    ac.addEventListener("click", function(e) {    //鼠标点击下拉列表后的事件
        $('#box2_end').val(e.item.value);
    });
});

$('#btn_search').click(function(){
    $('#selectBox').toggle(1000);
});
*/
$('#selectChange').change(function(){
    var c = $("#selectChange").val();
    $('#hid_select_id').val(c);
    if(c > 1){
        $('#box2').removeClass('Hide');
        $('#box1').addClass('Hide');
    }else{
        $('#box1').removeClass('Hide');
        $('#box2').addClass('Hide');
    }
});

/**
 * 本地搜索
 */
$('#box1_btn').click(function(){
    var txt1 = $('#hid_box1_txt').val();
    //console.log(txt1);
    if(Number(txt1) > 0){
        /*公交 站站 查询*/
        var busline = new BMap.BusLineSearch(map,{
            renderOptions:{map:map,panel:"r-result"},
            onGetBusListComplete: function(result){
                if(result) {
                    var fstLine = result.getBusListItem(0);//获取第一个公交列表显示到map上
                    busline.getBusLine(fstLine);
                }
            }
        });
        function busSearch(){
            var busName = txt1;	//公交线路
            busline.getBusList(busName);
        }

        setTimeout(function(){
            busSearch();
        },1500);
    }else{
        var myKeys = [txt1];
        var local = new BMap.LocalSearch(map, {
            renderOptions:{map: map, panel:"r-result"}
        });
        local.setPageCapacity(9);
        local.searchInBounds(myKeys, map.getBounds());
        $('#box1_txt').val('');
    }

});
/**
 * 公交、自驾 搜索
 */
$('#box2_btn').click(function(){
    var selectId = $('#hid_select_id').val();
    var start = $('#box2_start').val();
    var end = $('#box2_end').val();
    if(selectId == 2){ //公交搜索
        var transit = new BMap.TransitRoute(map, {
            renderOptions: {map: map,panel:"r-result"},
            policy:BMAP_TRANSIT_POLICY_AVOID_SUBWAYS   //不乘地铁
            //BMAP_TRANSIT_POLICY_LEAST_TIME	最少时间。
            //BMAP_TRANSIT_POLICY_LEAST_TRANSFER	最少换乘。
            //BMAP_TRANSIT_POLICY_LEAST_WALKING	最少步行。
            //BMAP_TRANSIT_POLICY_AVOID_SUBWAYS	不乘地铁。(自 1.2 新增)
        });
        transit.search(start, end);
    }else{  //自驾搜索
        function search(start,end,route){
            var transit = new BMap.DrivingRoute(map, {
                renderOptions: {map: map,panel:"r-result"},
                policy: route
            });
            transit.search(start,end);
        }
        //三种驾车策略：最少时间，最短距离，避开高速
        var routePolicy = [BMAP_DRIVING_POLICY_LEAST_TIME,BMAP_DRIVING_POLICY_LEAST_DISTANCE,BMAP_DRIVING_POLICY_AVOID_HIGHWAYS];
        search(start,end,routePolicy[0]); //最少时间

    }
    $('#box2_start').val('');
    $('#box2_end').val('');
});
$('#btn_train,#btn_aircraft,#btn_car,#btn_travel,#btn_Stations').click(function(){
    if(timeState==1){
        location.reload();
    }
    $('#trainTime').css('display','none');
    $('#flyTime').css('display','none');
    $('#selectBox').css('display','');

    $('#r-result').css('display','');
    $('#allmap').css('display','');
    $('#showList').css('display','none');

})
/**
 * 火车售票点
 */
$('#btn_train').click(function(){
    map.clearOverlays();//清除地图上所有覆盖物。
    map.setZoom(11);//重设地图显示级别
    var myKeys = ["火车售票"];
    var local = new BMap.LocalSearch("秦皇岛市", {
        renderOptions:{map: map, panel:"r-result"},
        pageCapacity: 10
    });
    //local.setPageCapacity(9);
    local.searchInBounds(myKeys, map.getBounds());
});
$('#btn_aircraft').click(function(){
    map.clearOverlays();//清除地图上所有覆盖物。
    map.setZoom(11);//重设地图显示级别
    var myKeys = ["机票"];
    var local = new BMap.LocalSearch(map, {
        renderOptions:{map: map, panel:"r-result"}
    });
    local.setPageCapacity(10);
    local.searchInBounds(myKeys, map.getBounds());
});
$('#btn_car').click(function(){
    map.clearOverlays();//清除地图上所有覆盖物。
    map.setZoom(11);//重设地图显示级别
    var myKeys = ["汽车租赁","自行车租赁"];
    var local = new BMap.LocalSearch(map, {
        renderOptions:{map: map, panel:"r-result"}

    });
    local.searchInBounds(myKeys, map.getBounds());
});
$('#btn_travel').click(function(){
    map.clearOverlays();//清除地图上所有覆盖物。
    map.setZoom(11);//重设地图显示级别
    var myKeys = ["旅行社"];
    var local = new BMap.LocalSearch(map, {
        renderOptions:{map: map, panel:"r-result"}
    });
    local.setPageCapacity(10);
    local.searchInBounds(myKeys, map.getBounds());
});
$('#btn_Stations').click(function(){
    map.clearOverlays();//清除地图上所有覆盖物。
    map.setZoom(11);//重设地图显示级别
    var myKeys = ["加油站"];
    var local = new BMap.LocalSearch(map, {
        renderOptions:{map: map, panel:"r-result"},
        pageCapacity: 10
    });
    //local.setPageCapacity(10);
    local.searchInBounds(myKeys, map.getBounds());
});

$('#btn_trainTime').click(function(){
    //window.location.href = base_url + 'lcskb/index';
    $('#trainTime').css('display','');
    $('#flyTime').css('display','none');
    $('#selectBox').css('display','none');

    $('#r-result').css('display','none');
    $('#allmap').css('display','none');
    $('#showList').css('display','');
    timeState =1;
});


$('#btn_flyTime').click(function(){
    //window.location.href = base_url + 'lcskb/flyGet';
    $('#trainTime').css('display','none');
    $('#flyTime').css('display','');
    $('#selectBox').css('display','none');

    $('#r-result').css('display','none');
    $('#allmap').css('display','none');
    $('#showList').css('display','');
    timeState =1;
});

$('#dy, #btn_flyTime').click(function(){
    var startCiy = $('#startCity').val();
    var lastCity = $('#lastCity').val();
    var theDate=$('#theDate').val();
    $.ajax({
        url:base_url + 'lcskb/fly',
        type:'post',
        dataType:'json',
        data:{departureAirport:startCiy,arrivalAirport:lastCity,date:theDate},
        success:function(data){
            data = data.data;
            var m = 0; c = data.count;
            var _str = '<table>\
                    <tr><td colspan="15" style="text-align: center">'+data.mytitle+'</td></tr>\
                    <tr><td style="width: 80px;padding: 5px 0 0 5px;">航班号</td>\
                        <td style="width: 100px;">航空公司</td>\
                        <td style="width: 120px;">机型</td>\
                        <td style="width: 80px;">起飞时间</td>\
                        <td style="width: 80px;">降落时间</td>\
                        <td style="width: 100px;">飞行时间</td>\
                        <td style="width: 100px;">起飞机场</td>\
                        <td style="width: 100px;">降落机场</td>\
                        <td style="width: 100px;">准点率</td>\
                        <td style="width: 80px;">平均延时</td>\
                    </tr>';
                if(c > 0){
                for(;m<c;m++){
                    //console.log(data.myitems[m]['flightCode']);
                    _str += '<tr><td>'+data.myitems[m]['flightCode']+'</td><td>'
                        +data.myitems[m]['carrierCom']+'</td><td>'+data.myitems[m]['planeType']+'</td><td>'
                        +data.myitems[m]['departureTime']+'</td><td>'+data.myitems[m]['arrivalTime']+'</td><td>'
                        +data.myitems[m]['costTime']+'</td><td>'+data.myitems[m]['departureAirport']+'</td><td>'
                        +data.myitems[m]['arrivalAirport']+'</td><td>'+data.myitems[m]['correctness']+'</td><td>'
                        +data.myitems[m]['delay']+'</td></tr>';
                }}else{
                    _str += '<tr><td colspan="10" style="text-align: center">暂无可显示数据！</td></tr>';
                }
            _str += '</table>';
            $('#showList').html(_str);
        }
    })
});

$('#t_btn, #btn_trainTime').click(function(){
    var startCiy = $('#t_startCity').val();
    var lastCity = $('#t_lastCity').val();
    var theDate=$('#t_theDate').val();
    $.ajax({
        url:base_url + 'lcskb',
        type:'post',
        dataType:'json',
        data:{departureAirport:startCiy,arrivalAirport:lastCity,date:theDate},
        success:function(data){
            var m = 0; c = data.count;
            data = data.data;
            var _str = '<table>\
                    <tr><td style="width: 50px;padding: 5px 0 0 5px;">车次</td>\
                        <td style="width: 60px;">发站</td>\
                        <td style="width: 60px;">到站</td>\
                        <td style="width: 60px;">历时</td>\
                        <td style="width: 70px;">商务座</td>\
                        <td style="width: 70px;">特等座</td>\
                        <td style="width: 70px;">一等座</td>\
                        <td style="width: 70px;">二等座</td>\
                        <td style="width: 80px;">高级软卧</td>\
                        <td style="width: 60px;">软卧</td>\
                        <td style="width: 60px;">硬卧</td>\
                        <td style="width: 60px;">软座</td>\
                        <td style="width: 60px;">硬座</td>\
                        <td style="width: 60px;">无座</td>\
                        <td style="width: 60px;">其他</td>\
                    </tr>';
            if(c>0){
            for(;m<c;m++){
                _str += '<tr><td>'+data[m][1]+'</td><td>'
                    +data[m][2]+'</td><td>'+data[m][3]+'</td><td>'
                    +data[m][4]+'</td><td>'+data[m][5]+'</td><td>'
                    +data[m][6]+'</td><td>'+data[m][7]+'</td><td>'
                    +data[m][8]+'</td><td>'+data[m][9]+'</td><td>'
                    +data[m][10]+'</td><td>'+data[m][11]+'</td><td>'
                    +data[m][12]+'</td><td>'+data[m][13]+'</td><td>'
                    +data[m][14]+'</td><td>'+data[m][15]+
                    '</td></tr>';
            }}else{
            _str += '<tr><td colspan="15" style="text-align: center">暂无可显示数据！</td></tr>';
            }
            _str += '</table>';
            $('#showList').html(_str);
        }
    })
});

$.datepicker.regional['zh-CN'] =
{

    clearText: '清除', clearStatus: '清除已选日期',
    closeText: '关闭', closeStatus: '不改变当前选择',
    prevText: '&lt;上月', prevStatus: '显示上月',
    nextText: '下月&gt;', nextStatus: '显示下月',
    currentText: '今天', currentStatus: '显示本月',
    monthNames: ['一月','二月','三月','四月','五月','六月',
        '七月','八月','九月','十月','十一月','十二月'],
    monthNamesShort: ['一','二','三','四','五','六',
        '七','八','九','十','十一','十二'],
    monthStatus: '选择月份', yearStatus: '选择年份',
    weekHeader: '周', weekStatus: '年内周次',
    dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
    dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
    dayNamesMin: ['日','一','二','三','四','五','六'],
    dayStatus: '设置 DD 为一周起始', dateStatus: '选择 m月 d日, DD',
    dateFormat: 'yy-mm-dd', firstDay: 1,
    initStatus: '请选择日期', isRTL: false
};


$.datepicker.setDefaults($.datepicker.regional['zh-CN']);

$("#theDate, #t_theDate").datepicker({
    changeMonth: true,
    changeYear: true
    ,yearRange:'c-40:c+10'//前30年和后10年
});