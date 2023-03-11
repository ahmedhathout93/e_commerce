$(function(){
'use strict';
$('[placeholder]').focus(function(){
    $(this).attr('data-text',$(this).attr('placeholder'));
    $(this).attr('placeholder','');

}).blur(function(){
    $(this).attr('placeholder',$(this).attr('data-text'));


// Add Asterisk On Required Field

});
// convert password field to text field on hover

var passField = $('.password');

	$('.show-pass').hover(function () {

		passField.attr('type', 'text');

	}, function () {

		passField.attr('type', 'password');

	});
// delete confirmation message 
$('.confirm').click(function(){
	return confirm('Are you sure');
});
// category view
$('.cat h3').click(function(){
	$(this).next('.full-view').fadeToggle(200);
});

// full and classic view

$('.ord span').click(function(){
$(this).addClass('active').siblings('span').removeClass('active');
if($(this).data('view')==='full'){
	$('.cat .full-view').fadeIn(200);
}else {
	$('.cat .full-view').fadeOut(200);

}
});

});

