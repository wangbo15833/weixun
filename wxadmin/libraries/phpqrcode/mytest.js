/**
 * @author Administrator
 */

$(document).ready(function(){
	//alert("my document!");
	$(".stripe tr").mouseover(function() {
		$this.addClass("over");
	}).mouseout(function() {
		$this.removeClass("over");
	});
	
	$(".stripe tr:even").addClass('alt');
});
