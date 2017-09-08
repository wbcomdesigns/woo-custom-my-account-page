jQuery( document ).ready( function ( $ ) {
    'use strict';

    //Support Tab
    var acc = document.getElementsByClassName( "wccma-accordion" );
    var i;
    for ( i = 0; i < acc.length; i++ ) {
        acc[i].onclick = function () {
            this.classList.toggle( "active" );
            var panel = this.nextElementSibling;
            if ( panel.style.maxHeight ) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        }
    }

    $( document ).on( 'click', '.wccma-accordion', function () {
        return false;
    } );

    //Open the modal
    var appendthis = ( "<div class='modal-overlay js-modal-close'></div>" );
    $( 'input[data-modal-id]' ).click( function ( e ) {
        e.preventDefault();
        $( "body" ).append( appendthis );
        $( ".modal-overlay" ).fadeTo( 500, 0.7 );
        var modalBox = $( this ).attr( 'data-modal-id' );
        $( '#' + modalBox ).fadeIn( $( this ).data() );
    } );
    $( ".js-modal-close, .modal-overlay" ).click( function () {
        $( ".modal-box, .modal-overlay" ).fadeOut( 500, function () {
            $( ".modal-overlay" ).remove();
        } );
    } );

    $( window ).resize( function () {
        $( ".modal-box" ).css( {
            top: ( $( window ).height() - $( ".modal-box" ).outerHeight() ) / 2,
            left: ( $( window ).width() - $( ".modal-box" ).outerWidth() ) / 2
        } );
    } );

    $( window ).resize();

    //Open the menu item
    $( document ).on( 'click', '.wccma-my-account-menu-item', function () {
        var menu = $( this ).data( 'menu' );
        $( '#wccma-menu-item-detail-' + menu ).slideToggle();
        var element_height = $( '#wccma-menu-item-detail-' + menu ).css( 'height' ).match( /\d+/ );
        if ( element_height[0] > 5 ) {
            $( '#span-menu-' + menu + ' i' ).attr( 'class', 'fa fa-angle-down' );
            $( '#menu-' + menu + ' label' ).css( 'color', '#000' );
            $( '#' + menu + '-power-icon' ).css( 'color', '#000' );
        } else {
            $( '#span-menu-' + menu + ' i' ).attr( 'class', 'fa fa-angle-up' );
            $( '#menu-' + menu + ' label' ).css( 'color', '#0073aa' );
            $( '#' + menu + '-power-icon' ).css( 'color', '#0073aa' );
        }
    } );

    $( document ).on( 'keyup', '#wccma-add-endpoint-input', function () {
        var val = $( this ).val();
        if ( val != '' ) {
            var slug = val.toLowerCase().replace( / /g, "-" );
            $( '#wccma-endpoint-slug' ).val( slug );
            $( '#wccma-save-endpoint' ).prop( "disabled", false );
        } else {
            $( '#wccma-save-endpoint' ).prop( "disabled", true );
        }
    } );

    $( '.wccma-font-awesome-icons' ).selectize( {
        placeholder: "Select Icon",
        plugins: [ 'remove_button' ],
    } );
    $( '.wccma-user-roles' ).selectize( {
        placeholder: "Select User Role",
        plugins: [ 'remove_button' ],
    } );

    $( '.wccma-user-roles' ).selectize( {
        placeholder: "Select User Role",
        plugins: [ 'remove_button' ],
    } );

    $( '.wccma-default-tab' ).selectize( {
        placeholder: "Select woocommerce endpoint"
    } );

    $( '.wccma-menu-style-tab' ).selectize( {
        placeholder: "Select menu style"
    } );

    //Add endpoint
    $( document ).on( 'click', '#wccma-save-endpoint', function () {
        var endpoint = $( '#wccma-add-endpoint-input' ).val();
        var endpoint_slug = $( '#wccma-endpoint-slug' ).val();
        var woo_endpoints = $( '#wccma-woo-endpoints' ).val();
        var btn_txt = $( this ).html();
        $( this ).html( '<i class="fa fa-refresh fa-spin"></i>  Saving...' );
        var data = {
            'action': 'wccma_add_endpoint',
            'endpoint': endpoint,
            'endpoint_slug': endpoint_slug,
            'woo_endpoints': woo_endpoints
        }
        $.ajax( {
            dataType: "JSON",
            url: wccma_admin_js_object.ajaxurl,
            type: 'POST',
            data: data,
            success: function ( response ) {
                $( '#wccma-woo-endpoints' ).val( response['data']['woo_endpoints'] );
                $( '#wccma-add-endpoint-input' ).val( '' );
                $( '#wccma-save-endpoint' ).html( btn_txt );
                $( ".js-modal-close, .modal-overlay" ).click();
                $( '.wccma-all-endpoints' ).append( response['data']['html'] );
                $( '.wccma-font-awesome-icons' ).selectize( {
                    placeholder: "Select Icon",
                    plugins: [ 'remove_button' ]
                } );
                $( '.wccma-user-roles' ).selectize( {
                    placeholder: "Select User Role",
                    plugins: [ 'remove_button' ]
                } );
            }
        } );
    } );
} );
function wccma_remove_endpoints( ins ) {
    var id = ins.getAttribute( 'data-remenu' );
    var data = {
        'action': 'wccma_remove_endpoints',
        'del_ins': id
    };
    jQuery.post( ajaxurl, data, function ( response ) {
        jQuery( '#wccma-menu-item-detail-' + id ).remove();
        jQuery( '#menu-' + id ).remove();
    } );
}