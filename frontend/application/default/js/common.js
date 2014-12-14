
/**
 *      [品牌空间] (C)2001-2010 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: common.js 5736 2011-08-02 06:48:59Z menglingmin $
 */

var cookiedomain = isUndefined(cookiedomain) ? '' : cookiedomain;
var cookiepath = isUndefined(cookiepath) ? '' : cookiepath;

var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
browserVersion({'ie':'msie','firefox':'','chrome':'','opera':'','safari':'','maxthon':'','mozilla':'','webkit':''});
if(BROWSER.safari) {
	BROWSER.firefox = true;
}
BROWSER.opera = BROWSER.opera ? opera.version() : 0;

var JSMENU = [];
JSMENU['active'] = [];
JSMENU['timer'] = [];
JSMENU['drag'] = [];
JSMENU['layer'] = 0;
JSMENU['zIndex'] = {'win':200,'menu':300,'dialog':400,'prompt':500};
JSMENU['float'] = '';
var AJAX = [];

function brand_search(form){
	mod = $("input[name=mod]:checked").val();
	if ("shop" == mod) {
		form.action = "street.php";
	} else if ("consume" == mod) {
		form.action = "consume.php";
	} else if ("goods" == mod) {
		form.action = "goodsearch.php";
	} else if ("groupbuy" == mod) {
		form.action = "groupbuy.php";
	}
}

function browserVersion(types) {
	var other = 1;
	for(i in types) {
		var v = types[i] ? types[i] : i;
		if (USERAGENT.indexOf(v) != -1) {
			var re = new RegExp(v + '(\\/|\\s)([\\d\\.]+)', 'ig');
			var matches = re.exec(USERAGENT);
			var ver = matches != null ? matches[2] : 0;
			other = ver !== 0 ? 0 : other;
		} else {
			var ver = 0;
		}
		eval('BROWSER.' + i + '= ver');
	}
	BROWSER.other = other;
}

function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
	var expires = new Date();
	if(cookieValue == '' || seconds < 0) {
		cookieValue = '';
		seconds = -2592000;
	}
	if (seconds != 0) expires.setTime(expires.getTime() + seconds * 1000);
	domain = !domain ? cookiedomain : domain;
	path = !path ? cookiepath : path;
	document.cookie = escape(cookiepre + cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '/')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
}

function getcookie(name, nounescape) {
	name = cookiepre + name;
	var cookie_start = document.cookie.indexOf(name);
	var cookie_end = document.cookie.indexOf(";", cookie_start);
	if(cookie_start == -1) {
		return '';
	} else {
		var v = document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length));
		return !nounescape ? unescape(v) : v;
	}
}

/**
 * 发送短消息对话框
 * @param pm_to 要发给用户ID
 */
function pm_send(pm_to) {
	url = 'pm.php?act=sendbox&msgto=' + pm_to + '&inajax=1';
	show_message('<iframe id="iframe_pm" scrolling="no" frameborder=0 width="520" height="260" src="' + url + '"></iframe>', '短消息', 2);
	showMask();
	return false;
}

/**
 * 店铺通知
 */
function pm_view(pm_type) {
	url = 'pm.php?act=list&msgtype=' + pm_type + '&inajax=1&time=' + (new Date().getTime());
	show_message('<iframe id="iframe_pm" scrolling="no" frameborder=0 width="520" height="500" src="' + url + '"></iframe>', '查看系统消息', 2);
	showMask();
	return false;
}

function show_pm_box() {
	dialog_with = "520";
	if (!$("#pm_border")[0]) {
		$("#append_parent").append('<div id="pm_border" class="dialog" style="display:none; width:' + dialog_with + 'px;"></div>');
	}
	$("#pm_border").html('<div onclick="pm_close();" style="margin-left:' + (dialog_with - 40) + 'px;" class="btn_close">关闭</div> '
			+ '<iframe id="iframe_pm" scrolling="no" frameborder=0 width="100%" height="100%"></iframe>');
	$("#pm_border").css({
		"top": ($(document).scrollTop() + 100) + "px",
		"left": ($(document).width() - 520) / 2 + "px"
	});
}

/**
 * 关闭发送消息的层
 */
function pm_close() {
	$("#pm_border").fadeOut("slow");
	hideMask();
}

/**
 * 显示前台报告层
 * @param action 报告类型
 * @param type 报告对象类型
 * @param id 报告对象ID
 */
function showWindow(action, type, id, title) {
	url = 'report.php?action=' + action + '&type=' + type + '&id=' + id;
	if (action == "moreshops") {
		show_message('<iframe id="iframe_pm" scrolling="no" frameborder=0 width="520" height="500" src="' + url + '"></iframe>', '店铺管理', 2);
		showMask();
		$("#" + action + "div").fadeIn("slow");
	} else {
		show_message('', '', 2, url);
		showMask();
		$("#" + action + "div").fadeIn("slow");
	}
	return false;
}

function show_message(message, title, type, url, width, height) {
	message_id = new Date().getTime();
	if(BROWSER.ie && BROWSER.ie < 7) {
		var dialog_position = 'absolute';
	} else {
		var dialog_position = 'fixed';
	}
	win_dialog = "<div style=\"position: "+dialog_position+"; z-index: 1001; left: " + ($(document).width() - 520) / 2 + "px; top: " +
	"200px; display:none;\" class=\"fwinmask\" id=\"fwin_dialog_" + message_id + "\">" +
	"<table cellspacing=\"0\" cellpadding=\"0\" class=\"fwin\">" +
	"<tr><td class=\"t_l\"></td><td class=\"t_c\"></td><td class=\"t_r\"></td></tr>" +
	"<tr><td class=\"m_l\">&nbsp;&nbsp;</td><td class=\"m_c\">" +
	"<h3 class=\"flb\"><em>" +
	((title == undefined || title == "") ? "提示信息" : title) +
	"</em><span><a title=\"关闭\" onclick=\"close_message('" + message_id + "');\" class=\"flbc\" id=\"fwin_dialog_close\" href=\"javascript:;\">关闭</a></span></h3>" +
	"<div class=\"c altw\" id=\"fwin_content_" + message_id + "\">" ;

	win_dialog += "</div>";
	win_dialog += "<p class=\"o pns\" id=\"fwin_pns_" + message_id + "\" style=\"display:none; margin-top:10px;\"><span class=\"z xg1\"></span>" +
		"<button class=\"pn pnc\" value=\"true\" id=\"fwin_dialog_submit\" onclick=\"submit_content('" + message_id + "');\"><strong>确定</strong></button></p>";

	win_dialog += "</td><td class=\"m_r\"></td></tr>" +
		"<tr><td class=\"b_l\"></td><td class=\"b_c\"></td><td class=\"b_r\"></td></tr></table></div>";
	showMask();

	if (!$("#append_dialog")[0]) {
		$("#append_parent").append("<div id=\"append_dialog\"></div>");
	}

	$("#append_dialog").append(win_dialog);

	if (message.indexOf("alert_") == -1 &&  message.indexOf("iframe") == -1) {
		$('#fwin_content_' + message_id).append("<div class=\"alert_info\" style=\"margin:10px;\"><p>" + message + "</p></div>");
	} else {
		$('#fwin_content_' + message_id).append(message);
	}

	if (url) {
		$('#fwin_content_' + message_id).load(url + "&ajaxid=" + message_id, function(){
			$("#fwin_dialog_" + message_id).css({
				"top": (($(window).height() - $("#fwin_dialog_" + message_id).height())/2) + "px",
				"left": ($(window).width() - $("#fwin_dialog_" + message_id).width()) / 2 + "px"
			});
			if($('#fwin_content_' + message_id).html().indexOf("form") == -1) {
				$("#fwin_pns_" + message_id).show();
			}
			$("#fwin_dialog_" + message_id).show();
		});
	} else {
		$("#fwin_dialog_" + message_id).css({
			"top": (($(window).height() - $("#fwin_dialog_" + message_id).height())/2) + "px",
			"left": ($(window).width() - $("#fwin_dialog_" + message_id).width()) / 2 + "px"
		});
		if(message.indexOf("form") == -1 && message.indexOf("iframe") == -1) {
			$("#fwin_pns_" + message_id).show();
		}
		$("#fwin_dialog_" + message_id).show();
	}

	if (BROWSER.ie && BROWSER.ie < 7) {
		$("#fwin_content_" + message_id).find("iframe").each(function() {
				this.contentWindow.location.reload(true);
		});
	}

	// 如果内容中出现了表单绑定 AJAX
	$("#fwin_content_" + message_id).find("form").each(function() {
		bindform(this.id);
	});

	return false;
}

function submit_content(message_id) {
	formid = $(($('#fwin_content_' + message_id).find("form"))[0]).attr("id");

	if (formid == undefined) {
		close_message(message_id);
	}
}

function close_message(message_id) {
	$("#fwin_dialog_" + message_id).remove();
	$("#append_dialog").remove();
	hideMask();
}

function showMask() {
	if (!$("#mask_div")[0]) {
		var bh=$("body").height();
		$("#append_parent").append('<div style="height: ' + bh + 'px; display: ;" id="mask_div"></div>');
	}
	$("#mask_div").css({"display" : '',
		"position" : "absolute",
		"left" : "0",
		"z-index" : "999",
		"margin" : "0",
		"padding" : "0",
		"width" : "100%",
		"top" : "0"
	});
}

function hideMask() {
	$("#mask_div").css("display", 'none');
}

/**
 * 关闭报告层
 */
function closereportdiv(action) {
	$("#" + action + "div").fadeOut();
	hideMask();
}

/**
 * 登录验证码
 */
function updateseccode() {
	var img = 'seccode.php?rand=' + Math.random();
	if ($("#img_seccode")) {
		$("#img_seccode").attr('src', img);
	}
}

function showseccode() {
	if ($("#login_authcode_img").css('display') != 'block') {
		$("#login_authcode_img").css('display', 'block');
	}
}

function addseccode() {
	$("#login_authcode_img").show();
}

function updatecomseccode(height) {
	var img = 'seccode.php?rand=' + Math.random() + '&h=' + height;
	if ($("#img_comseccode")) {
		$("#img_comseccode").attr('src', img);
	}
}

function showcomseccode() {
	if ($("#com_authcode_img").css('display') != 'block') {
		$("#com_authcode_img").css('display', 'block');
	}
}

function addcomseccode() {
	if ($("#com_authcode_img").css('display') == 'block') {
		$("#com_authcode_img").css('display', 'none');
	}
}

function submitcheck() {
	obj = $('#seccode')[0];
	if (obj && obj.value == '') {
		showseccode();
		obj.focus();
		return false;
	}
}

function comsubmitcheck() {
	obj = $('#comseccode')[0];
	if (obj && obj.value == '') {
		showcomseccode();
		obj.focus();
		return false;
	}
}

function jump_to_url(url) {
	location = url;
}

function ajaxform_failed(display_area, data) {
	data.find("item").each(function() {
		obj = $(this).attr('name');
		msg = $(this).text();

		input_box = $('#' + obj);

		if (!input_box[0]) {
			if ($(":input[name='" + obj + "']")[0]) {
				input_box = $(":input[name='" + obj + "']");
			}

			if (!input_box[0]) {
				if ($('#input_' + obj)[0]) {
					input_box = $('#input_' + obj);
				}
			}
		}

		if (input_box[0]) {
			input_box.css({
				'background': '#FCD0FF'
			});

			input_box.bind("focus", function() {
				$(this).css({
					'background': ''
				});
				$('#span_' + $(this).attr("name").replace('input_', '')).css('color', '#999999');
				$('#ajax_status_display').html('');
			});

		}

		if ($('#span_' + obj)[0]) {
			$('#span_' + obj).css('color', 'red');
			$('#span_' + obj).html(msg);
		} else {
			alert(msg);
		}
	});
}

function ajaxform_newcomment(display_area, data) {
	msg = $.trim(data.find("message").text());
	content = $.trim(data.find("content").text());
	if (content != '') {
		$('#postlistreply').append(content);
		$('#commentmessage').val('');
	}
}

function ajaxform_newrecomment(display_area, data) {
	url = $.trim(data.find("url").text());
	msg = $.trim(data.find("message").text());
	upcid = $.trim(data.find("upcid").text());
	content = $.trim(data.find("content").text());
	if (content != '') {
		$('#commentdl' + upcid).append(content);
		$('#commentmessage').val('');
		setTimeout("jump_to_url(url)", 2000);
	}
}

function ajaxform_ok(display_area, data) {
	url = $.trim(data.find("url").text());
	msg = $.trim(data.find("message").text());
	if (url != "") {
		setTimeout("jump_to_url(url)", 2000);
	} else {
		if ($("#" + display_area)[0]) {
			$("#" + display_area).html(msg);
		} else {
			alert(msg);
		}
	}
}

/**
 * 绑定模拟AJAX表单提交事件
 *
 */
function bindform(formname, display_area) {
	$(document).ready(function() {
		var ajaxframeid = '_FSS_' + (new Date().getTime());
		var ajaxframe;
		var io;
		var formaction = $('#' + formname)[0].action;
		var __form = $('#' + formname);
		if (display_area == undefined) {
			display_area = '' + formname + ' #ajax_status_display';
		}

		try {
			__test_frame = $('<iframe id="__test_' + ajaxframeid + '" name="__test_' + ajaxframeid + '"  width="100" height="100" />');
			__test_frame.appendTo('body');
			__test_io = __test_frame[0];
			__test_doc = __test_io.contentWindow ? __test_io.contentWindow.document: __test_io.contentDocument ? __test_io.contentDocument: __test_io.document;
			data = $(__test_doc.XMLDocument ? __test_doc.XMLDocument: __test_doc);
			__test_frame.remove();
		}catch(err) { __test_frame.remove(); return;}
		
		$('#' + formname).submit(function() {
			ajaxframe = $('<iframe id="' + ajaxframeid + '" name="' + ajaxframeid + '"  onload="(jQuery(this).data(\'ajaxform-onload\'))()" />');
			ajaxframe.appendTo('body');
			ajaxframe.data('ajaxform-onload', hanlde_data);

			ajaxframe.css({
				position: 'absolute',
				top: '-1000px',
				left: '-1000px'
			});
			io = ajaxframe[0];
			document.getElementById(formname).target = ajaxframeid;
			document.getElementById(formname).action = formaction + ((formaction.indexOf('?') == -1) ? '?' : '&') + 'inajax=1&submit_time=' + (new Date().getTime());

			function hanlde_data() {
				var data, doc;
				doc = io.contentWindow ? io.contentWindow.document: io.contentDocument ? io.contentDocument: io.document;
				if (doc.XMLDocument || $.isXMLDoc(doc)) {
					data = $(doc.XMLDocument ? doc.XMLDocument: doc);
					message = data.find("message").text();

					if (message != '') {
						if (!$('#' + formname + ' #ajax_status_display')[0]) {
							show_message(message, '提示信息', 0);
							ajaxframe.removeData('ajaxform-onload');
							ajaxframe.remove();
							data = null;
							return;
							return;
						} else {
							$('#' + formname + ' #ajax_status_display').html('<span style="color:red;font-weight:bold;">' + message + '</span>');
						}
					}

					if (data.find("status").text().toUpperCase() == 'OK') {
						ajaxform_ok(display_area, data);
					} else if (data.find("status").text().toUpperCase() == 'FAILED') {
						ajaxform_failed(display_area, data);
					} else if (data.find("status").text().toUpperCase() == 'NEWCOMMENT') {
						ajaxform_newcomment(display_area, data);
					} else if (data.find("status").text().toUpperCase() == 'NEWRECOMMENT') {
						ajaxform_newrecomment(display_area, data);
					} else {
						error_trace(display_area, data[0].innerHTML);
					}
				} else {
					try {
						data = doc.body ? doc.body.innerHTML: null;
						if (data == "") {
							error_trace(display_area, '服务器没有任何返回结果。');
						} else {
							error_trace(display_area, data);
						}
					} catch(err) {
						error_trace(display_area, "服务器内部错误！");
					}
				}
				setTimeout(function() {
					ajaxframe.removeData('ajaxform-onload');
					ajaxframe.remove();
					data = null;
				},
				100);
			}
		});
		return false;
	});
}

/**
 * 模拟AJAX提交后，如果出现错误，则显示错误信息
 * @param data
 */
function error_trace(display_area, data) {
	 $('#' + display_area).html("<div id=\"div_error_trace\" style=\"background:#E1E1E1; padding:5px; width:600px; z-index:10000;\"><div style=\"background:#fff; border:#A7A6A6 1px solid; text-align:left; padding:10px;\">"+data+"</div></div>");
}

/**
 * 多级联动菜单
 *
 */
function createmultiselect(select_id, select_name, select_content, select_parent, select_init_val) {
	var selector = 1;
	$('#' + select_id).attr('name', select_name);
	$('#' + select_id).bind('change', function() {
		creat(this.id);
	});
	function creat(id) {
		var originalrid = $('#' + id + '').val();
		var csid = id.split("_")[1];
		var newinnercontent = '';
		for (var i in select_content) {
			if (select_content[i].upid == originalrid) {
				newinnercontent += "<option value=\"" + select_content[i].catid + "\"" + ((typeof(upid) != "undefined" && select_content[i].catid == upid) || (typeof(value) != "undefined" && select_content[i].catid == value) ? " selected=\"selected\"": "") + ">" + select_content[i].name + "</option>";
			}
		}
		var selectlength = $('#' + select_parent + ' select').length;
		if (selectlength > 1) {
			for (var i = selectlength; i > 0; i--) {
				var cid = $('#' + select_parent + ' select:nth-child(' + i + ')').attr('id');
				if (cid.split("_")[1] > csid) {
					$('#' + select_parent + ' select:nth-child(' + i + ')').remove();
				}
			}

		}
		if (newinnercontent != '') {
			$("#" + id + "").after('<select><option value="-1">' + select_init_val + '</option>' + newinnercontent + '</select>');
			$("#" + id + "").removeAttr("name");
			$("#" + id + " + select").attr('name', select_name);
			$("#" + id + " + select").attr('id', 'selector' + select_name + '_' + selector);
			$("#" + id + " + select").bind('change', function() {
				creat(this.id);
			});
		} else {
			$("#" + id).attr('name', select_name);
		}
		selector = $('#' + select_parent + ' select').length;
		if (selector == 1) {
			$('#' + select_id).attr('name', select_name);
		}
	}
}
function groupbuy_userdel(itemid) {
	return;
}

function show_comment_score_area() {
	show = $("#comment_score_area").css('display');
	if(show == 'none') {
		$("#comment_score_area").show();
		$("#ico_opt").attr('src','static/image/ico_dec.png');
		$("#ico_opt").attr('title','收起');
	} else {
		$("#comment_score_area").hide();
		$("#ico_opt").attr('src','static/image/ico_add.png');
		$("#ico_opt").attr('title','展开');
	}
}


function resize_image(img, w, h) {
	if (img.width <= w && img.height <= h) return;

	img_wh = img.width/img.height;

	if (img_wh < (w/h)) {
		if (img.width > w) {
			img.width = w;
			img.height = w / img_wh;
		} else {
			img.width = img_wh * h;
			img.height = h;
		}
	}
}

function showMenu(v) {
	var ctrlid = isUndefined(v['ctrlid']) ? v : v['ctrlid'];
	var showid = isUndefined(v['showid']) ? ctrlid : v['showid'];
	var menuid = isUndefined(v['menuid']) ? showid + '_menu' : v['menuid'];
	var ctrlObj = $("#" + ctrlid)[0];
	var menuObj = $("#" + menuid)[0];
	if(!menuObj) return;
	var mtype = isUndefined(v['mtype']) ? 'menu' : v['mtype'];
	var evt = isUndefined(v['evt']) ? 'mouseover' : v['evt'];
	var pos = isUndefined(v['pos']) ? '43' : v['pos'];
	var layer = isUndefined(v['layer']) ? 1 : v['layer'];
	var duration = isUndefined(v['duration']) ? 2 : v['duration'];
	var timeout = isUndefined(v['timeout']) ? 250 : v['timeout'];
	var maxh = isUndefined(v['maxh']) ? 600 : v['maxh'];
	var cache = isUndefined(v['cache']) ? 1 : v['cache'];
	var drag = isUndefined(v['drag']) ? '' : v['drag'];
	var dragobj = drag && $(drag) ? $(drag) : menuObj;
	var fade = 0; //isUndefined(v['fade']) ? 0 : v['fade'];
	var cover = isUndefined(v['cover']) ? 0 : v['cover'];
	var zindex = isUndefined(v['zindex']) ? JSMENU['zIndex']['menu'] : v['zindex'];
	zindex = cover ? zindex + 200 : zindex;
	if(typeof JSMENU['active'][layer] == 'undefined') {
		JSMENU['active'][layer] = [];
	}

	if(evt == 'click' && in_array(menuid, JSMENU['active'][layer]) && mtype != 'win') {
		hideMenu(menuid, mtype);
		return;
	}
	if(mtype == 'menu') {
		hideMenu(layer, mtype);
	}

	if(ctrlObj) {
		if(!ctrlObj.initialized) {
			ctrlObj.initialized = true;
			ctrlObj.unselectable = true;

			ctrlObj.outfunc = typeof ctrlObj.onmouseout == 'function' ? ctrlObj.onmouseout : null;
			ctrlObj.onmouseout = function() {
				if(this.outfunc) this.outfunc();
				if(duration < 3 && !JSMENU['timer'][menuid]) JSMENU['timer'][menuid] = setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
			};

			ctrlObj.overfunc = typeof ctrlObj.onmouseover == 'function' ? ctrlObj.onmouseover : null;
			ctrlObj.onmouseover = function(e) {
				doane(e);
				if(this.overfunc) this.overfunc();
				if(evt == 'click') {
					clearTimeout(JSMENU['timer'][menuid]);
					JSMENU['timer'][menuid] = null;
				} else {
					for(var i in JSMENU['timer']) {
						if(JSMENU['timer'][i]) {
							clearTimeout(JSMENU['timer'][i]);
							JSMENU['timer'][i] = null;
						}
					}
				}
			};
		}
	}

	var dragMenu = function(menuObj, e, op) {
		e = e ? e : window.event;
		if(op == 1) {
			if(in_array(BROWSER.ie ? e.srcElement.tagName : e.target.tagName, ['TEXTAREA', 'INPUT', 'BUTTON', 'SELECT'])) {
				return;
			}
			JSMENU['drag'] = [e.clientX, e.clientY];
			JSMENU['drag'][2] = parseInt(menuObj.style.left);
			JSMENU['drag'][3] = parseInt(menuObj.style.top);
			document.onmousemove = function(e) {try{dragMenu(menuObj, e, 2);}catch(err){}};
			document.onmouseup = function(e) {try{dragMenu(menuObj, e, 3);}catch(err){}};
			doane(e);
		}else if(op == 2 && JSMENU['drag'][0]) {
			var menudragnow = [e.clientX, e.clientY];
			menuObj.style.left = (JSMENU['drag'][2] + menudragnow[0] - JSMENU['drag'][0]) + 'px';
			menuObj.style.top = (JSMENU['drag'][3] + menudragnow[1] - JSMENU['drag'][1]) + 'px';
			doane(e);
		}else if(op == 3) {
			JSMENU['drag'] = [];
			document.onmousemove = null;
			document.onmouseup = null;
		}
	};

	if(!menuObj.initialized) {
		menuObj.initialized = true;
		menuObj.ctrlkey = ctrlid;
		menuObj.mtype = mtype;
		menuObj.layer = layer;
		menuObj.cover = cover;
		if(ctrlObj && ctrlObj.getAttribute('fwin')) {menuObj.scrolly = true;}
		menuObj.style.position = 'absolute';
		menuObj.style.zIndex = zindex + layer;
		menuObj.onclick = function(e) {
			if(!e || BROWSER.ie) {
				window.event.cancelBubble = true;
				return window.event;
			} else {
				e.stopPropagation();
				return e;
			}
		};
		if(duration < 3) {
			if(duration > 1) {
				menuObj.onmouseover = function() {
					clearTimeout(JSMENU['timer'][menuid]);
					JSMENU['timer'][menuid] = null;
				};
			}
			if(duration != 1) {
				menuObj.onmouseout = function() {
					JSMENU['timer'][menuid] = setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
				};
			}
		}
		if(cover) {
			var coverObj = document.createElement('div');
			coverObj.id = menuid + '_cover';
			coverObj.style.position = 'absolute';
			coverObj.style.zIndex = menuObj.style.zIndex - 1;
			coverObj.style.left = coverObj.style.top = '0px';
			coverObj.style.width = '100%';
			coverObj.style.height = document.body.offsetHeight + 'px';
			coverObj.style.backgroundColor = '#000';
			coverObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=50)';
			coverObj.style.opacity = 0.5;
			$('#append_parent')[0].appendChild(coverObj);
			_attachEvent(window, 'load', function () {
				coverObj.style.height = document.body.offsetHeight + 'px';
			}, document);
		}
	}
	if(drag) {
		dragobj.style.cursor = 'move';
		dragobj.onmousedown = function(event) {try{dragMenu(menuObj, event, 1);}catch(e){}};
	}
	$(menuObj).show();
	if(cover) $("#" + menuid + '_cover')[0].style.display = '';
	if(fade) {
		var O = 0;
		var fadeIn = function(O) {
			if(O == 100) {
				clearTimeout(fadeInTimer);
				return;
			}
			menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + O + ')';
			menuObj.style.opacity = O / 100;
			O += 10;
			var fadeInTimer = setTimeout(function () {
				fadeIn(O);
			}, 50);
		};
		fadeIn(O);
		menuObj.fade = true;
	} else {
		menuObj.fade = false;
	}
	setMenuPosition(showid, menuid, pos);
	if(maxh && menuObj.scrollHeight > maxh) {
		menuObj.style.height = maxh + 'px';
		if(BROWSER.opera) {
			menuObj.style.overflow = 'auto';
		} else {
			menuObj.style.overflowY = 'auto';
		}
	}

	if(!duration) {
		setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
	}

	if(!in_array(menuid, JSMENU['active'][layer])) JSMENU['active'][layer].push(menuid);
	menuObj.cache = cache;
	if(layer > JSMENU['layer']) {
		JSMENU['layer'] = layer;
	}
}

function hideMenu(attr, mtype) {
	attr = isUndefined(attr) ? '' : attr;
	mtype = isUndefined(mtype) ? 'menu' : mtype;
	if(attr == '') {
		for(var i = 1; i <= JSMENU['layer']; i++) {
			hideMenu(i, mtype);
		}
		return;
	} else if(typeof attr == 'number') {
		for(var j in JSMENU['active'][attr]) {
			hideMenu(JSMENU['active'][attr][j], mtype);
		}
		return;
	}else if(typeof attr == 'string') {
		var menuObj = $("#" + attr)[0];
		if(!menuObj || (mtype && menuObj.mtype != mtype)) return;
		clearTimeout(JSMENU['timer'][attr]);
		var hide = function() {
			if(menuObj.cache) {
				menuObj.style.display = 'none';
				if(menuObj.cover) $("#" + attr + '_cover')[0].style.display = 'none';
			}else {
				menuObj.parentNode.removeChild(menuObj);
				if(menuObj.cover) $("#" + attr + '_cover')[0].parentNode.removeChild($(attr + '_cover'));
			}
			var tmp = [];
			for(var k in JSMENU['active'][menuObj.layer]) {
				if(attr != JSMENU['active'][menuObj.layer][k]) tmp.push(JSMENU['active'][menuObj.layer][k]);
			}
			JSMENU['active'][menuObj.layer] = tmp;
		};
		if(menuObj.fade) {
			var O = 100;
			var fadeOut = function(O) {
				if(O == 0) {
					clearTimeout(fadeOutTimer);
					hide();
					return;
				}
				menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + O + ')';
				menuObj.style.opacity = O / 100;
				O -= 30;
				var fadeOutTimer = setTimeout(function () {
					fadeOut(O);
				}, 50);
			};
			fadeOut(O);
		} else {
			hide();
		}
	}
}

function setMenuPosition(showid, menuid, pos) {
	function checkmenuobj(menuObj) {
		while((menuObj = menuObj.offsetParent) != null) {
			if(menuObj.style.position == 'absolute') {
				return 2;
			}
		}
		return 1;
	}
	var showObj = $("#" + showid)[0];
	var menuObj = menuid ? $("#" + menuid)[0] : $("#" + showid + '_menu')[0];
	if(isUndefined(pos)) pos = '43';
	var basePoint = parseInt(pos.substr(0, 1));
	var direction = parseInt(pos.substr(1, 1));
	var sxy = 0, sx = 0, sy = 0, sw = 0, sh = 0, ml = 0, mt = 0, mw = 0, mcw = 0, mh = 0, mch = 0, bpl = 0, bpt = 0;

	if(!menuObj || (basePoint > 0 && !showObj)) return;
	if(showObj) {
		sxy = fetchOffset(showObj, BROWSER.ie && BROWSER.ie < 7 ? checkmenuobj(menuObj) : 0);

		sx = sxy['left'];
		sy = sxy['top'];
		sw = showObj.offsetWidth;
		sh = showObj.offsetHeight;
	}

	mw = menuObj.offsetWidth;
	mcw = menuObj.clientWidth;
	mh = menuObj.offsetHeight;
	mch = menuObj.clientHeight;

	switch(basePoint) {
		case 1:
			bpl = sx;
			bpt = sy;
			break;
		case 2:
			bpl = sx + sw;
			bpt = sy;
			break;
		case 3:
			bpl = sx + sw;
			bpt = sy + sh;
			break;
		case 4:
			bpl = sx;
			bpt = sy + sh;
			break;
	}
	switch(direction) {
		case 0:
			menuObj.style.left = (document.body.clientWidth - menuObj.clientWidth) / 2 + 'px';
			mt = (document.documentElement.clientHeight - menuObj.clientHeight) / 2;
			break;
		case 1:
			ml = bpl - mw;
			mt = bpt - mh;
			break;
		case 2:
			ml = bpl;
			mt = bpt - mh;
			break;
		case 3:
			ml = bpl;
			mt = bpt;
			break;
		case 4:
			ml = bpl - mw;
			mt = bpt;
			break;
	}
	var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
	var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
	if(in_array(direction, [1, 4]) && ml < 0) {
		ml = bpl;
		if(in_array(basePoint, [1, 4])) ml += sw;
	} else if(ml + mw > scrollLeft + document.body.clientWidth && sx >= mw) {
		ml = bpl - mw;
		if(in_array(basePoint, [2, 3])) ml -= sw;
	}
	if(in_array(direction, [1, 2]) && mt < 0) {
		mt = bpt;
		if(in_array(basePoint, [1, 2])) mt += sh;
	} else if(mt + mh > scrollTop + document.documentElement.clientHeight && sy >= mh) {
		mt = bpt - mh;
		if(in_array(basePoint, [3, 4])) mt -= sh;
	}
	if(pos == '210') {
		ml += 69 - sw / 2;
		mt -= 5;
		if(showObj.tagName == 'TEXTAREA') {
			ml -= sw / 2;
			mt += sh / 2;
		}
	}
	if(direction == 0 || menuObj.scrolly) {
		if(BROWSER.ie && BROWSER.ie < 7) {
			if(direction == 0) mt += scrollTop;
		} else {
			if(menuObj.scrolly) mt -= scrollTop;
			menuObj.style.position = 'fixed';
		}
	}
	if(ml) menuObj.style.left = ml + 'px';
	if(mt) menuObj.style.top = mt + 'px';
	if(direction == 0 && BROWSER.ie && !document.documentElement.clientHeight) {
		menuObj.style.position = 'absolute';
		menuObj.style.top = (document.body.clientHeight - menuObj.clientHeight) / 2 + 'px';
	}
	if(menuObj.style.clip && !BROWSER.opera) {
		menuObj.style.clip = 'rect(auto, auto, auto, auto)';
	}
}

function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}

function trim(str) {
	return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
}

function strlen(str) {
	return (BROWSER.ie && str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
}

function mb_strlen(str) {
	var len = 0;
	for(var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
	}
	return len;
}

function mb_cutstr(str, maxlen, dot) {
	var len = 0;
	var ret = '';
	var dot = !dot ? '...' : '';
	maxlen = maxlen - dot.length;
	for(var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
		if(len > maxlen) {
			ret += dot;
			break;
		}
		ret += str.substr(i, 1);
	}
	return ret;
}

function fetchOffset(obj, mode) {
	var left_offset = 0, top_offset = 0, mode = !mode ? 0 : mode;

	if(obj.getBoundingClientRect && !mode) {
		var rect = obj.getBoundingClientRect();
		var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
		var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
		if(document.documentElement.dir == 'rtl') {
			scrollLeft = scrollLeft + document.documentElement.clientWidth - document.documentElement.scrollWidth;
		}
		left_offset = rect.left + scrollLeft - document.documentElement.clientLeft;
		top_offset = rect.top + scrollTop - document.documentElement.clientTop;
	}
	if(left_offset <= 0 || top_offset <= 0) {
		left_offset = obj.offsetLeft;
		top_offset = obj.offsetTop;
		while((obj = obj.offsetParent) != null) {
			if(mode == 2 && obj.style.position == 'absolute') {
				continue;
			}
			left_offset += obj.offsetLeft;
			top_offset += obj.offsetTop;
		}
	}
	return {'left' : left_offset, 'top' : top_offset};
}

function doane(event) {
	e = event ? event : window.event;
	if(!e) e = getEvent();
	if(e && BROWSER.ie) {
		e.returnValue = false;
		e.cancelBubble = true;
	} else if(e) {
		e.stopPropagation();
		e.preventDefault();
	}
}

function showMap(p, title, showid) {
	p = /\s*\((.+?)\s*,\s*(.+?)\)\s*/.exec(p);
	var latlng = new google.ma
		ps.LatLng(p[1], p[2]);
	var myOptions = {
	zoom: 14,
	center: latlng,
	navigationControl: false,
	mapTypeControl: false,
	scaleControl: false,
	mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById(showid), myOptions);
	var marker = new google.maps.Marker({position: latlng, map: map, title: title});
}

function updateListView(mname, viewmod, viewBy) {
	setcookie('list_' + mname + '_' + viewmod, viewBy, 259200, "/");
	var regurl = /\/[\w-]*\.((html)|(php))/i;
	var a = location.href.match(regurl);
	if (location.href.indexOf("?") == -1 && a[1] == 'html' ) {
		var url = location.href.replace(/([a-z]+?)(-(\d+?)(-(\d+?)*))*\.html/, "$1.php?catid=$3&tagid=$5&orderby=1");
		location.href = url;
	} else if( location.href.indexOf("php") != -1 && a[1] == 'php'){
		if(location.href.indexOf("?") == -1) {
			location.href = location.href  + "?orderby=1";
		} else if(location.href.indexOf("?") != -1 && location.href.indexOf("orderby=1") == -1) {
			location.href = location.href + "&orderby=1";
		} else if(location.href.indexOf("&orderby=1") != -1) {
			location.href = location.href;
		} else if (location.href.indexOf("?orderby=1") != -1) {
			location.href = location.href;
		}
	}else{
		location.reload(true);
	}
}
