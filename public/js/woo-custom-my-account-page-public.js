jQuery(document).ready(function( $ ) {
	'use strict';
	var default_woo_tab = wccma_public_js_obj.default_woo_tab;

	//Open the modal
	var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");
	$('a[data-modal-id]').click(function(e) {
		e.preventDefault();
		$("body").append(appendthis);
		$(".modal-overlay").fadeTo(500, 0.7);
		var modalBox = $(this).attr('data-modal-id');
		$('#'+modalBox).fadeIn($(this).data());
	});
	$(".js-modal-close, .modal-overlay").click(function() {
		$(".modal-box, .modal-overlay").fadeOut(500, function() {
			$(".modal-overlay").remove();
		});
		$('#wccma-user-avatar').val('').clone( true );
		$('.wccma-update-avatar-error p').html('');
	});

	$(window).resize(function() {
		$(".modal-box").css({
			top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
			left: ($(window).width() - $(".modal-box").outerWidth()) / 2
		});
	});

	$(window).resize();

	$(document).on('change', '#wccma-user-avatar', function(){
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
		if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
			$('#wccma-user-avatar').val('').clone( true );
			$('.wccma-update-avatar-error p').html( "Only formats are allowed : "+fileExtension.join(', ') );
		} else {
			$('.wccma-update-avatar-error p').html('');
		}
	});

});