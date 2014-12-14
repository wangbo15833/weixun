$(document).ready(function(){
    var auserUrl = web_url +'index.php/shops/get_search';
    $('#header_search').autocomplete({
    // appendTo:'#',
    source:function(request, response){
    $.ajax({
    url:auserUrl,
    type:'POST',
    dateType:'json',
    data:{'c_title':request.term},
    success:function(data, textStatus,jqSHR){
    data = eval("("+data+")");
    response($.map(data, function(item, index){
    return {
    label: item.title,
    value: item.title,
    id:item.id
    }
}
));
},
error:function(){
    return "暂无可匹配信息";
    }
})
},
select: function( event, ui ) {
    // $('#hid_search_key').val(ui.item.id);
    }
});
})

