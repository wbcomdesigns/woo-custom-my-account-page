jQuery(document).ready(function( $ ) {
	'use strict';

	//Support Tab
	var acc = document.getElementsByClassName("wccma-accordion");
	var i;
	for (i = 0; i < acc.length; i++) {
		acc[i].onclick = function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.maxHeight){
				panel.style.maxHeight = null;
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
			} 
		}
	}

	$(document).on('click', '.wccma-accordion', function(){
		return false;
	});
	
	//Open the modal
	var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");
	$('input[data-modal-id]').click(function(e) {
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
	});

	$(window).resize(function() {
		$(".modal-box").css({
			top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
			left: ($(window).width() - $(".modal-box").outerWidth()) / 2
		});
	});

	$(window).resize();

	//Open the menu item
	$(document).on('click', '.wccma-my-account-menu-item', function(){
		var menu = $(this).data('menu');
		$('#wccma-menu-item-detail-'+menu).slideToggle();
		var element_height = $('#wccma-menu-item-detail-'+menu).css('height').match(/\d+/);
		if( element_height[0] > 5 ) {
			$('#span-menu-'+menu+' i').attr('class', 'fa fa-angle-down');
			$('#menu-'+menu+' label').css('color', '#000');
		} else {
			$('#span-menu-'+menu+' i').attr('class', 'fa fa-angle-up');
			$('#menu-'+menu+' label').css('color', '#0073aa');
		}
	});
});