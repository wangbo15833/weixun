var add_message_url = base_url + "shops/add_comment";

show_message();


$(document).ready(function(){
	
	$('#submitMsgForm').click(function () {
	    
	
	    var star1 = $('#commentscorestr').indexOf("11");
	    var star2 = $('#commentscorestr').indexOf("12");
	    var star3 = $('#commentscorestr').indexOf("13");
	    if (star1 < 0 ) {
	        art.dialog({
	            time: 2,
	            width: '20em',
	            height: 55,
	            content: '请给总体评价打分！'
	        });
	        return false;
	    }
	    if (star2 < 0) {
	        art.dialog({
	            time: 2,
	            width: '20em',
	            height: 55,
	            content: '请给服务打分！'
	        });
	        return false;
	    }
	    if (star3 < 0) {
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
	        data: {
	            message: $('#commentmessage').val(),
	            shopid: $('#shopid').val()
	        },
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
	            $('#commentmessage').val('');
	        }
	    })
	})

});

function show_message() {
    $.ajax({
        url: base_url + "shops/get_comment_list",
        type: 'post',
        dataType: 'json',
        data: {shopid: $('#shopid').val()},
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
                                        <span class="time">' + data[i].pubdate + '</span>\
                                        </div>\
                                        <p class="content">' + data[i].message + '</p>\
                                    </li>';
                }
                if (_str.length == 0) _str = '<li class="no-review-tip">暂无该类型评价</li>';
                $('.comment').html(_str);
            }
        }
    })
}