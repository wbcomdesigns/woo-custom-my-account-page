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

jQuery(document).ready(function($) {
    "use strict";
    $( '.wcmp-admin-color-picker' ).wpColorPicker();
    var endpoints_container = $( ".endpoints-container" );
    var general_container   = $( ".wcmp_general_settings" );

    /*################################
         SORT AND SAVE ENDPOINTS
     #################################*/

    if( typeof $.fn.nestable != 'undefined' ) {
        endpoints_container.nestable({
            'expandBtnHTML' : '',
            'collapseBtnHTML' : ''
        });
    }

    $( 'form#wbwcmp_endpoints_settings' ).on( 'submit', function ( ev ) {
        ev.preventDefault();
        if( typeof $.fn.nestable == 'undefined' ) {
            return;
        }

        var j = $('.dd').nestable('serialize'),
            v = JSON.stringify(j);
        $( 'input.endpoints-order' ).val( v );
        $(this).unbind(ev);
    });
    
    /*################################
        OPEN ENDPOINT OPTIONS
    #################################*/

    $(document).on('click', '.open-options', function() {

        var item = $(this).closest('.endpoint');

        $(this).find('i').toggleClass( 'fa-chevron-down' ).toggleClass( 'fa-chevron-up' );

        item.find( '.endpoint-content' ).first().toggleClass('dd-nodrag');
        item.find( '.endpoint-options' ).first().slideToggle();
        item.find( '.wp-switch-editor.switch-html').click();
    });

    /*##############################
        ADD ENDPOINTS
    ###############################*/

    $(document).on('click', '.add_new_field', function(ev){
        ev.stopPropagation();

        var t           = $(this),
            target      = t.data( 'target' ),
            title       = t.html(),
            new_field   = $(document).find( '.new-field-form' ).clone();

        // first init and open dialog
        init_dialog_form( new_field, target, title );

        // then open
        new_field.dialog('open');
    });

    var xhr = false,
        init_dialog_form = function ( content, target, title ) {

            content.dialog({
                title: title,
                modal: true,
                width: 500,
                resizable: false,
                autoOpen: false,
                buttons: [{
                    text: "Save",
                    click: function () {

                        $(this).find('.loader').css( 'display', 'inline-block' );

                        // class add field handler
                        $(this).add_new_field_handler( target );

                        $(document).one( 'yith_wcmap_field_added', function() {
                            content.dialog("close");
                        });
                    }
                }],
                close: function (event, ui) {
                    content.dialog("destroy");
                    content.remove();
                }
            });

        };

    $.fn.add_new_field_handler = function( target ){

        var t        = $(this),
            value    = t.find( '#yith-wcmap-new-field' ).val(),
            error    = t.find( '.error-msg' );

        // abort prev ajax request
        if( xhr ) {
            xhr.abort();
        }

        // else check ajax
        xhr = $.ajax({
            url: ywcmap.ajaxurl,
            data: {
                target: target,
                field_name: value,
                action: ywcmap.action_add
            },
            dataType: 'json',
            beforeSend: function(){},
            success: function( res ){

                t.find('.loader').hide();

                // check for error or if field already exists
                if( res.error || endpoints_container.find( '[data-id="' + res.field + '"]').length ) {
                    error.html( res.error );
                    return;
                }

                var new_content = $(res.html);

                $( '.endpoints-container > ol.endpoints > li.endpoint' ).last().after( new_content );

                // reinit select
                applySelect2( new_content.find( 'select' ) );
               // init_tinyMCE( new_content.find('textarea').attr('id' ) );

                $(document).trigger( 'yith_wcmap_field_added' );
            }
        });
    };

    /*##############################
        HIDE / SHOW ENDPOINT
     ##############################*/

    var onoff_field = function( trigger, elem ) {
        var item        = elem.closest('.endpoint'),
            all_check   = item.find( '.hide-show-check' ),
            check       = ( trigger == 'checkbox' ) ? elem : all_check.first(),
            all_link    = item.find( '.hide-show-trigger' ),
            label, checked;

        // set checkbox status
        checked = ( ( check.is(':checked') && trigger == 'checkbox' ) || ( ! check.is(':checked') && trigger == 'link' ) ) ? true : false;
        all_check.prop( 'checked', checked );
        // set label
        label = ( check.is(':checked') ) ? ywcmap.hide_lbl : ywcmap.show_lbl;
        all_link.html( label );
    };

    // event listener
    $(document).on( 'change', '.hide-show-check', function(){
        onoff_field( 'checkbox', $(this) );
    });

    $(document).on( 'click', '.hide-show-trigger', function(){
        onoff_field( 'link', $(this) );
    });

    /*##############################
        REMOVE ENDPOINT
     ##############################*/

    $(document).on('click', '.remove-trigger', function(){
        
        var t = $(this),
            endpoint = t.data('endpoint'),
            to_remove = $( 'input.endpoint-to-remove' );

        if( typeof endpoint == 'undefined' || ! to_remove.length ) {
            return false;
        }

        var r = confirm( ywcmap.remove_alert );
        if ( r == true ) {
            var item = t.closest( '.dd-item' ),
                is_group = item.find( 'ol.endpoints' ),
                val_to_remove = to_remove.val(),
                to_remove_array = val_to_remove.length ? val_to_remove.split(',') : [];

            to_remove_array.push( endpoint );
            // first set value
            to_remove.val( to_remove_array.join(',') );

            // if group move child
            if( is_group.length ) {
                var child_items = is_group.find( 'li.dd-item' );
                // move!
                item.after( child_items );
            }
            // then remove field
            item.remove();
        } else {
            return false;
        }
    });

    /*###########################
        SELECT
    #############################*/

    function format(icon) {
        return $( '<span><i class="fa fa-' + icon.text + '"></i>   ' + icon.text + '</span>' );
    }
    function applySelect2( select, is_endpoint ) {
        if( typeof $.fn.select2 != 'undefined' ) {
            var data;
            $.each( select, function () {
                // build data
                if( $(this).hasClass('icon-select') ) {
                    data = {
                        templateResult: format,
                        templateSelection: format,
                        width: '100%',
                        tags: true
                    };
                } else if( is_endpoint ) {
                    data = {
                        width: '100%'
                    };
                } else {
                    data = {
                        minimumResultsForSearch: 10
                    };
                }

                $(this).select2(data);
            });
        }
    }

    applySelect2( endpoints_container.find( 'select' ), true );
    applySelect2( general_container.find( 'select' ), true );
    applySelect2( $( '#yith_wcmap_panel_general' ).find( 'select' ), false );
});