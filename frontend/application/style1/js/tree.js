//树形菜单初始化
/**
 * treeid 树id
 * show：1：保持展开状态 0：关闭所有子菜单
 */
function treeinit(treeid,show)
{
	var treeroot = document.getElementById(treeid);
	if(!treeroot)return;
	treeroot.setAttribute("inittag","1")
	var treerootlis = $(">li",treeroot);
	var subuls = treeroot.getElementsByTagName("ul");//所有ul标签
	var treelis = treeroot.getElementsByTagName("li");//所有li标签

	//初始化样式
	for(var tempul in subuls)
	{
		tempul.className = "";
	}
	for(var templi in treelis)
	{
		templi.className = "";
	}

	treeroot.className = treeroot.className+" treechildborder";//最外层ul添加背景线
	//所有li添加样式
	for(var i=0;i<treelis.length;i++)
	{
		var templi = treelis[i];
		var hasul = templi.getElementsByTagName("ul");
		var tag = templi.getAttribute("tag");
		var tag_name = templi.getAttribute("tag_name");
		var val = templi.getAttribute("nodeid");
		var checked = templi.getAttribute("checked");

		if(hasul.length>0)//有子节点
		{
			templi.className = templi.className.replace(" treelistend ","").replace(" treelist ","").replace(" treezhankai ","")+" treelist treezhankai ";//li添加样式
			$(">a",templi).wrapAll("<div onclick='tree_open(event,this)' class='treediv treecfolder'></div>");
		}
		else//没有子节点
		{
			templi.className = templi.className.replace(" treelistend ","").replace(" treelist ","").replace(" treenode ","")+" treelist treenode ";//li添加样式
			$(">a",templi).wrapAll("<div class='treediv treefile'></div>");
		}

		//添加复选框、单选按钮
		if($(">div>span",templi).length==0 && (tag == "checkbox" || tag == "radio"))
		{
			if(checked == 1){checked="checked"}else{checked = "";}
			$(">div",templi).prepend("<span><input onclick='' name='"+tag_name+"' type='"+tag+"' value='"+val+"' "+checked+"/></span>");
		}
	}

	//为ul里每个ul添加背景线 为最后一个li设置样式
	for(var i=0;i<subuls.length;i++)
	{
		var tempul = subuls[i];
		tempul.className = tempul.className+" treechildborder";//ul添加背景线

		if(show !=1)
		{tempul.style.display = "none";}
		else
		{
			var templi = tempul.parentNode;
			templi = $(templi);
			$(">div",templi).removeClass("treecfolder").addClass("treeofolder");
		}
		tempul.parentNode.className = (" "+tempul.parentNode.className+" ").replace(" treezhankai ","");

		if(tempul.style.display == "block" || tempul.style.display == "")
		{
			tempul.parentNode.className = (" "+tempul.parentNode.className+" ").replace(" treezhankai ","")+" treezhankai ";
		}

		var templis = $(">li",tempul);
		if(templis.length>0)//最后一个li设置样式
		{
			var len = templis.length-1;
			var templi = templis[len];
			templi.className = templi.className.replace(" treelistend ","")+" treelistend ";//li添加样式
		}
	}

	//根节点最后一级添加结束样式
	if(treerootlis.length>0)
	{
		var len = treerootlis.length-1;
		var templi = treerootlis[len];
		templi.className = templi.className+" treelistend ";//li添加样式
	}
}

//打开关闭tree节点
function tree_open(e,obj)
{
	$("div>a",$(".tree")).css("background-color","");
	$("div>a",$(".tree")).css("color","");
	e = e || window.event;
	var ele = e.srcElement || e.target;
	var tagname = ele.tagName;tagname = tagname.toLowerCase();//获取事件tagName
	if(tagname == "input"){return;}//input 不执行

	if(!(obj instanceof jQuery))obj = $(obj);
	var classNm = " "+obj[0].className+" ";
	if(classNm.indexOf("treeofolder")>-1)//目前状态打开
	{
		obj.removeClass("treeofolder").addClass("treecfolder");
		obj.parent("li").removeClass("treezhankai");
		obj.parent("li").children("ul").hide();
	}
	else
	{
		obj.parent("li").addClass("treezhankai");
		obj.parent("li").children("ul").show();
		obj.removeClass("treecfolder").addClass("treeofolder");
	}
	return false;
}

/**
 * 操作树方法
 */
var treeOption = {
		/**
		 * 添加节点
		 * option:{
		 * treeid:树id,[必须]
		 * parentNodeId：父节点id 0表示根接点,[添加]
		 * nodeText：先是文字,[添加、修改]
		 * nodeId：节点id,[添加、修改]
		 * nodeLink：节点连接,[添加、修改]
		 * tabid:tab标签id [添加]
		 * index 插入位置 [添加]
		 * iframe:是否在iframe打开[添加、修改]
		 * }
		 */
		addNode:function(option)
		{
			var treeid = option.treeid;
			var parentNodeId = option.parentNodeId;parentNodeId = parentNodeId?parentNodeId:0;
			var nodeText = option.nodeText;
			var nodeId = option.nodeId;
			var nodeLink = option.nodeLink;
			var tabid = option.tabid;
			var index = option.index;
			var iframe = option.iframe;
			var tree = $("#"+treeid);
			var panretnode = $("li[nodeid="+parentNodeId+"]>ul",tree);
			panretnode = parentNodeId == 0?tree:panretnode;
			if(panretnode.length>0)
			{
				var li = document.createElement("li");
				var a = document.createElement("a");
				li.setAttribute("nodeid",nodeId);
				a.setAttribute("href", nodeLink);
				a.setAttribute("tabid",tabid);
				a.setAttribute("iframe",iframe);
			//	a.setAttribute("",);
				a.innerHTML = nodeText;
				li.appendChild(a);
				panretnode.append(li);
				treeinit(treeid,1)
				return true;
			}
			else{return false;}
		},
		/**
		 * 修改节点
		 */
		modifyNode:function(option)
		{
			var treeid = option.treeid;
			var parentNodeId = option.parentNodeId;parentNodeId = parentNodeId?parentNodeId:0;
			var nodeText = option.nodeText;
			var nodeId = option.nodeId;
			var nodeLink = option.nodeLink;
			var tree = $("#"+treeid);
			var node = $("li[nodeid="+nodeId+"]",tree);
			if(node.length>0)
			{
				var nowparentnode = node.parent("ul").parent("li");//当前父节点
				var nowparentnodeid = nowparentnode?nowparentnode.attr("nodeid"):0;//当前父节点nodeid
				var nodediv = $(">div",node);
				var a = $(">a",nodediv);
				a.attr("href",nodeLink);
				a.html(nodeText);
				if(parentNodeId != nowparentnodeid && nodeId!=parentNodeId)//父节点不同移动节点
				{
					var newparent = $("li[nodeid="+parentNodeId+"]",tree);
					newparent = parentNodeId==0?tree:newparent;
					node.clone().appendTo(newparent);
					node.remove();
				}
				treeinit(treeid,1);
				return true;
			}
			else{return false}
		},
		/**
		 * 删除节点
		 * option{
		 *  treeid 树id
		 *  nodeId 要删除节点id
		 *  }
		 */
		delNode:function(option)
		{
			var treeid = option.treeid;
			var nodeId = option.nodeId;
			var tree = $("#"+treeid);
			var node = $("li[nodeid="+nodeId+"]",tree);
			if(node.length>0)
			{
				node.remove();
				treeinit(treeid,1)
				return true;
			}
			else{return false}
		},
		getNodeById:function(treeid,nodeid)
		{

		},
		/**
		 * 获取树所有选中值
		 * treeid 树id
		 */
		getAllSelected:function(treeid)
		{
			var tree = document.getElementById(treeid);
			var inputs = tree.getElementsByTagName("input");
			var val = "";var tag = "";
			for(var i=0;i<inputs.length;i++)
			{
				if(inputs[i].checked){val += tag+inputs[i].value;tag=","}
			}
			return val;
		},
		/**
		 * 全选取消
		 * treeid：树id
		 * tag：1：全选 0：全部取消
		 */
		selectAll:function(treeid,tag)
		{
			tag = tag==1?true:false;
			var tree = document.getElementById(treeid);
			var inputs = tree.getElementsByTagName("input");
			for(var i=0;i<inputs.length;i++)
			{
				inputs[i].checked = tag;
			}
		},
		/**
		 * 查找节点
		 * treeid：树id
		 * text：要查找的文本
		 * return 对象数组 name：文字  value：值
		 */
		find:function(treeid,text)
		{
			text = text || "";
			var res = new Array();
			var tree = $("#"+treeid);
			$("li",tree).each(function(){
				var a = $(">.treediv>a",this);
				var t = a.html();
				if(t.indexOf(text)>=0)
				{
					var v = $(this).attr("nodeid");
					res[res.length] = {name:t,value:v}
				}
			});
			return res;
		},
		/**
		 * 展开指定value节点
		 * treeid：树id
		 * value：节点值
		 */
		openTree:function(treeid,value)
		{
			var tree = $("#"+treeid);
			var li = $("li[nodeid="+value+"]",tree);
			if(li.length>0)
			{
				var ul = li.parent("ul");
				while(ul.length>0)
				{
					ul.show();
					ul = ul.parent("li").parent("ul");
				}
				treeinit(treeid,1);
				$("div>a",$(".tree")).css("background-color","");
				$("div>a",$(".tree")).css("color","");
				$(">div>a",li).css("background-color","#316ac5");
				$(">div>a",li).css("color","#ffffff");
				return true;
			}
			return false;
		}
	}