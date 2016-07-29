'use strict';

$(function () {
  console.log('JS TEST MESSAGE!');
});
//# sourceMappingURL=app.js.map

function orderForm()
{
	$.fancybox('/ajax.php?order',{
		type:'ajax',
		autoSize: true,
		fitToView: false,
		maxWidth: "100%",
		helpers:{
			overlay:{
				locked:true
			}
		}
	});
	return false;
}

function ajaxFormTry(ajaxForm){
	$.post(
		ajaxForm.attr('action'),
		ajaxForm.serialize(),
		function(data){
			$.fancybox.open(data);
	});
	return false;
}