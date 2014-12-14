/**
 * Created with JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-8-19
 * Time: 下午2:20
 * To change this template use File | Settings | File Templates.
 */

var editor;
KindEditor.ready(function(K) {
    editor = K.create('textarea[name="content"]', {
        allowFileManager : true
    });
});
$('#county').change(function(){
    $('#hid_areaName').val($("#county  option:selected").text());
})