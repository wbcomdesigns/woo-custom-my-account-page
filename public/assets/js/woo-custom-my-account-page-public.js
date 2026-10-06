jQuery(document).ready(function($) {
    "use strict";

    function preload_popup() {
        $('body').append( '<div id="wcmp-avatar-form-overlay" class="loading"></div>' );
    }

    // The dialog is centred in CSS; JS only handles focus, Escape and the file check.
    var popup_opener = null;

    function close_popup() {
        $( document ).off( 'keydown.wcmpAvatar' );
        $( '#wcmp-avatar-form, #wcmp-avatar-form-overlay' ).fadeOut( 'fast', function(){
            $( this ).remove();
        });
        if ( popup_opener ) {
            popup_opener.focus();
        }
    }

    function focusables( dialog ) {
        return dialog.find( 'button, [href], input:not([type="hidden"]), select, textarea' ).filter( ':visible:not(:disabled)' );
    }

    function check_file( form, file ) {
        var error   = form.find( '.wcmp-field-error' ),
            submit  = $( 'button[form="wcmp-avatar-upload"]' ),
            types   = String( form.data( 'types' ) || '' ).split( ',' ),
            message = '';

        if ( file && -1 === types.indexOf( file.type ) ) {
            message = form.data( 'type-error' );
        } else if ( file && file.size > Number( form.data( 'max-bytes' ) ) ) {
            message = form.data( 'size-error' );
        }

        error.text( message ).prop( 'hidden', ! message );
        form.find( '.wcmp-file-drop' ).toggleClass( 'has-error', !! message );
        submit.prop( 'disabled', ! file || !! message );
        return ! message;
    }

    $( document ).on( 'change', '#wcmp-avatar-form .wcmp-file-input', function() {
        var form    = $( this ).closest( 'form' ),
            file    = this.files && this.files[0],
            preview = form.find( '.wcmp-avatar-new' );

        form.find( '.wcmp-file-drop__name' ).text( file ? file.name : '' );

        if ( preview.attr( 'src' ) ) {
            URL.revokeObjectURL( preview.attr( 'src' ) );
        }
        if ( check_file( form, file ) ) {
            preview.attr( 'src', URL.createObjectURL( file ) ).prop( 'hidden', false );
        } else {
            preview.removeAttr( 'src' ).prop( 'hidden', true );
        }
    });

    $( document ).on( 'dragenter dragover', '#wcmp-avatar-form .wcmp-file-drop', function() {
        $( this ).addClass( 'is-dragover' );
    }).on( 'dragleave drop', '#wcmp-avatar-form .wcmp-file-drop', function() {
        $( this ).removeClass( 'is-dragover' );
    });

    $('#load-avatar').click( function (ev) {
        
        ev.preventDefault();
        popup_opener = this;
        preload_popup();

        $.ajax({
            url: wcmp.ajaxurl.toString().replace( '%%endpoint%%', wcmp.actionPrint ),
            type: 'POST',
            data: {},
            dataType: 'html',
            success: function( res ) {

                if ( ! $.trim( res ) ) {
                    $( '#wcmp-avatar-form-overlay' ).remove();
                    return;
                }

                $('body').append( res ).find('#wcmp-avatar-form-overlay').removeClass('loading');

                var dialog = $( '#wcmp-avatar-form' );
                dialog.find( '.wcmp-file-input' ).trigger( 'focus' );

                $('#wcmp-avatar-form-overlay, #wcmp-avatar-form .close-form').click(function(){
                    close_popup();
                });

                // Escape closes; Tab stays inside the dialog.
                $( document ).on( 'keydown.wcmpAvatar', function( e ) {
                    if ( 'Escape' === e.key ) {
                        close_popup();
                        return;
                    }
                    if ( 'Tab' !== e.key ) {
                        return;
                    }
                    var items = focusables( dialog ),
                        first = items.first()[0],
                        last  = items.last()[0];
                    if ( e.shiftKey && document.activeElement === first ) {
                        e.preventDefault();
                        last.focus();
                    } else if ( ! e.shiftKey && document.activeElement === last ) {
                        e.preventDefault();
                        first.focus();
                    }
                });
            },
            error: function() {
                $( '#wcmp-avatar-form-overlay' ).remove();
            }
        })
        
    });

    $(document).on( "click", ".group-opener", function(ev){
        ev.preventDefault();

        var t         = $(this),
            container = t.closest('li'),
            expanded  = t.attr('aria-expanded') === 'true';

        if( container.hasClass( 'is-tab' ) && $(window).width() >= 480 ) {
            container.toggleClass( 'is-hover' );
            t.attr( 'aria-expanded', container.hasClass('is-hover') ? 'true' : 'false' );
            return;
        }

        t.attr( 'aria-expanded', expanded ? 'false' : 'true' );
        t.find('i.opener').toggleClass( 'fa-chevron-down' ).toggleClass( 'fa-chevron-up' );
        t.next('.myaccount-submenu').slideToggle();
    });

    // Mobile: the account menu collapses behind a disclosure button.
    $(document).on( 'click', '.wcmp-nav-toggle', function(){
        var t        = $(this),
            expanded = t.attr('aria-expanded') === 'true',
            menu     = $( '#' + t.attr('aria-controls') );

        t.attr( 'aria-expanded', expanded ? 'false' : 'true' );
        menu.toggleClass( 'is-open' );
    });
});