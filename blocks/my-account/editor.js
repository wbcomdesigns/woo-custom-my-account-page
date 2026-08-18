/**
 * Custom My Account block - editor script.
 *
 * Plain JS (no build step): server-side preview of the portal.
 */
( function ( wp ) {
	'use strict';

	var el = wp.element.createElement;

	wp.blocks.registerBlockType( 'wcmp/my-account', {
		edit: function () {
			var blockProps = wp.blockEditor.useBlockProps();

			return el(
				'div',
				blockProps,
				el( wp.serverSideRender, {
					block: 'wcmp/my-account'
				} )
			);
		},
		save: function () {
			return null;
		}
	} );
} )( window.wp );
