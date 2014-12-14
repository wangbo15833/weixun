/**
 * @author lynx
 */

$(document).ready(function(){

    $.ajax({

        url: web_url +'index.php/manageShop/getMenu',
        type:'post',
        dataType:'json',
        success:function(data){
            data = data.public;
            //newdata = eval("("+data+")");
            var click = $('#hid_clickValue').val();
            // console.log(data.length);
            count = data.length;
            _str = "";
            for(j=0;j< count; j++){
                _str += '<tr>';
                _str +='<td id="'+data[j]['name_param']+'" ';
                if(data[j]['name_param'] == click){
                    _str += ' class="setbackground" ';
                }
                _str +=' height=20>☉ <a href="'+data[j]['url']+'">'+data[j]['name']+'</a> </td>';
                _str += '</tr>';
            }
            //console.log(_str);
            $('#table_str').append(_str);
        }
    });

});