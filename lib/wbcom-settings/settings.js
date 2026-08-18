/**
 * Settings shell behaviour - shared by Audio Preview and Audio Preview Pro.
 *
 * Tabs are real links with a ?tab= URL, so they work without this file. All this adds is
 * switching sections without a page load, while keeping the URL honest so a refresh, a save
 * redirect or a shared link all land on the same tab.
 */
( function () {
	'use strict';

	var NAV     = '.wbcom-settings-nav-item[data-section]';
	var SECTION = '.wbcom-settings-section';
	var ACTIVE  = 'is-active';

	function activate( id ) {
		var nav = document.querySelector( NAV + '[data-section="' + id + '"]' );
		var sec = document.getElementById( 'section-' + id );

		if ( ! nav || ! sec ) {
			return false;
		}

		document.querySelectorAll( NAV ).forEach( function ( el ) {
			el.classList.remove( ACTIVE );
			el.removeAttribute( 'aria-current' );
		} );
		document.querySelectorAll( SECTION ).forEach( function ( el ) {
			el.classList.remove( ACTIVE );
		} );

		nav.classList.add( ACTIVE );
		nav.setAttribute( 'aria-current', 'page' );
		sec.classList.add( ACTIVE );

		return true;
	}

	document.querySelectorAll( NAV ).forEach( function ( item ) {
		item.addEventListener( 'click', function ( e ) {
			var id = this.dataset.section;

			if ( ! activate( id ) ) {
				return; // Let the link navigate normally.
			}

			e.preventDefault();
			window.history.replaceState( null, '', this.getAttribute( 'href' ) );
		} );
	} );

	/*
	 * Settings API posts to options.php and redirects back to whatever it was told, so the tab
	 * has to travel with the form or every save dumps the owner on the first tab.
	 */
	document.querySelectorAll( SECTION + ' form' ).forEach( function ( form ) {
		form.addEventListener( 'submit', function () {
			var section = form.closest( SECTION );
			var ref     = form.querySelector( 'input[name="_wp_http_referer"]' );

			if ( section && ref ) {
				ref.value = ref.value.split( '&tab=' )[ 0 ] + '&tab=' + encodeURIComponent( section.id.replace( 'section-', '' ) );
			}
		} );
	} );

	if ( window.lucide ) {
		window.lucide.createIcons();
	}
}() );
