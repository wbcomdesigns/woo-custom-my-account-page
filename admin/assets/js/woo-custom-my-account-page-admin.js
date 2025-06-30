(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

jQuery( document ).ready(
	function($) {
		"use strict";		
		$( '.wcmp-admin-color-picker' ).wpColorPicker();
		var endpoints_container = $( ".endpoints-container" );
		var general_container   = $( ".wcmp_general_settings" );

		/*################################
		 SORT AND SAVE ENDPOINTS
		#################################*/

		if ( typeof $.fn.nestable != 'undefined' ) {
			endpoints_container.nestable(
				{
					'expandBtnHTML' : '',
					'collapseBtnHTML' : ''
				}
			);
		}

		/*################################
		OPEN ENDPOINT OPTIONS
		#################################*/

		$( document ).on(
			'click',
			'.open-options',
			function() {

				var item = $( this ).closest( '.endpoint' );

				$( this ).find( 'i' ).toggleClass( 'fa-chevron-down' ).toggleClass( 'fa-chevron-up' );

				item.find( '.endpoint-content' ).first().toggleClass( 'dd-nodrag' );
				item.find( '.endpoint-options' ).first().slideToggle();
				item.find( '.wp-switch-editor.switch-html' ).click();
			}
		);

		/*##############################
		ADD ENDPOINTS
		###############################*/

		$( document ).on(
			'click',
			'.add_new_field',
			function(ev){
				ev.stopPropagation();
				$( document ).find( '.error-msg' ).empty();				
				var t     = $( this ),				
				target    = t.data( 'target' ),
				title     = t.html(),
				new_field = $( document ).find( '.new-field-form' ).clone();
				
				// first init and open dialog
				init_dialog_form( new_field, target, title );

				// then open
				new_field.dialog( 'open' );
			}
		);

		var xhr          = false,
		init_dialog_form = function ( content, target, title ) {

			content.dialog(
				{
					title: title,
					modal: true,
					width: 500,
					resizable: false,
					autoOpen: false,
					buttons: [{
						text: "Save",
						click: function () {

							$( this ).find( '.wcmp-loader' ).css( 'display', 'inline-block' );

							// class add field handler.
							$( this ).add_new_field_handler( target );

							$( document ).one(
								'wcmp_field_added',
								function() {
									content.dialog( "close" );
								}
							);
						}
					}],
					close: function (event, ui) {
						content.dialog( "destroy" );
						content.remove();
					}
				}
			);

		};

		$.fn.add_new_field_handler = function( target ){

			var t = $( this ),
			value = t.find( '#wcmp-new-field' ).val(),
			error = t.find( '.error-msg' );
			t.find('.error-msg').empty();
			if ( '' !== $.trim( value ) ) {
				// abort prev ajax request
				if ( xhr ) {
					xhr.abort();
				}

				// else check ajax
				xhr = $.ajax(
					{
						url: wcmp.ajaxurl,
						data: {
							target: target,
							field_name: value,
							nonce: wcmp.nonce,
							action: wcmp.action_add
						},
						dataType: 'json',
						beforeSend: function(){},
						success: function( res ){

							t.find( '.wcmp-loader' ).hide();

							// check for error or if field already exists
							if ( res.error || endpoints_container.find( '[data-id="' + res.field + '"]' ).length ) {
								error.text( res.error );
								return;
							}

							var new_content = $( res.html );
							$( '.endpoints-container > ol.endpoints > li.endpoint' ).last().after( new_content );

							// reinit select
							applySelect2( new_content.find( 'select' ), true );
							// init_tinyMCE( new_content.find('textarea').attr('id' ) );

							$( document ).trigger( 'wcmp_field_added' );
							$( document ).trigger( 'wcmp_field_order' );
						}
					}
				);
			} else {
				t.find( '.wcmp-loader' ).hide();
				$( '.error-msg' ).html( wcmp.empty_field );
			}
		};

		/*##############################
		HIDE / SHOW ENDPOINT
		##############################*/

		var onoff_field = function( trigger, elem ) {
			var item  = elem.closest( '.endpoint' ),
			all_check = item.find( '.hide-show-check' ),
			check     = ( trigger == 'checkbox' ) ? elem : all_check.first(),
			all_link  = item.find( '.hide-show-trigger' ),
			label, checked;

			// set checkbox status
			checked = ( ( check.is( ':checked' ) && trigger == 'checkbox' ) || ( ! check.is( ':checked' ) && trigger == 'link' ) ) ? true : false;
			all_check.prop( 'checked', checked );
			// set label
			label = ( check.is( ':checked' ) ) ? wcmp.hide_lbl : wcmp.show_lbl;
			all_link.html( label );
		};

		$( document ).on(
			'keyup',
			'#wcmp-new-field',
			function(){
				$( this ).parents('.new-field-form').find('.error-msg').empty();
			}
		);

		var selected = $( ".wcmp_menu_style" );
	    selected.change(function(){
	    	if( 'tab' == this.value ) {
	    		$( '.wcmp_sidebar_position_wrapper' ).addClass( 'wcmp_option_hide' );
	    	} else {
	    		$( '.wcmp_sidebar_position_wrapper' ).removeClass( 'wcmp_option_hide' );	    		
	    	}
	    });

		// event listener
		$( document ).on(
			'change',
			'.hide-show-check',
			function(){
				onoff_field( 'checkbox', $( this ) );
			}
		);

		$( document ).on(
			'click',
			'.hide-show-trigger',
			function(){
				onoff_field( 'link', $( this ) );
			}
		);

		/*##############################
		REMOVE ENDPOINT
		##############################*/

		$( document ).on(
			'click',
			'.remove-trigger',
			function(){
				var t     = $( this ),
				endpoint  = t.data( 'endpoint' ),
				to_remove = $( 'input.endpoint-to-remove' );

				if ( typeof endpoint == 'undefined' || ! to_remove.length ) {
					return false;
				}

				var r = confirm( wcmp.remove_alert );
				if ( r == true ) {
					var item        = t.closest( '.dd-item' ),
					is_group        = item.find( 'ol.endpoints' ),
					val_to_remove   = to_remove.val(),
					to_remove_array = val_to_remove.length ? val_to_remove.split( ',' ) : [];

					to_remove_array.push( endpoint );
					// first set value
					to_remove.val( to_remove_array.join( ',' ) );

					// if group move child
					if ( is_group.length ) {
						var child_items = is_group.find( 'li.dd-item' );
						// move!
						item.after( child_items );
					}
					// then remove field
					item.remove();
					$( document ).trigger( 'wcmp_field_order' );
				} else {
					return false;
				}
			}
		);

		/*###########################
		SELECT
		#############################*/

		function format(icon) {
			return $( '<span><i class="fa fa-' + icon.text + '"></i>   ' + icon.text + '</span>' );
		}
		function applySelect2( select, is_endpoint ) {
			if ( typeof $.fn.select2 != 'undefined' ) {
				var data;
				$.each(
					select,
					function () {
						// Build data.
						if ( $( this ).hasClass( 'icon-select' ) ) {
							data = {
								templateResult: format,
								templateSelection: format,
								width: '100%',
								tags: true
							};
						} else if ( is_endpoint ) {
							data = {
								width: '100%'
							};
						} else {
							data = {
								minimumResultsForSearch: 10
							};
						}
						$( this ).select2( data );
					}
				);
			}
		}

		applySelect2( endpoints_container.find( 'select' ), true );
		applySelect2( general_container.find( 'select' ), true );
		applySelect2( $( '#yith_wcmap_panel_general' ).find( 'select' ), false );

		$( document ).on(
			'wcmp_field_order',
			function(ev) {
				if ( typeof $.fn.nestable != 'undefined' ) {
					var j = $( '.dd' ).nestable( 'serialize' ),
					v     = JSON.stringify( j );
					$( 'input.endpoints-order' ).val( v );
				}
			}
		);

		$( '.dd' ).nestable().on(
			'change',
			function() {
				$( document ).trigger( 'wcmp_field_order' );
			}
		);
	}
);
