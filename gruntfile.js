'use strict';
module.exports = function ( grunt ) {

	// load all grunt tasks matching the `grunt-*` pattern
	// Ref. https://npmjs.org/package/load-grunt-tasks
	require( 'load-grunt-tasks' )( grunt );

	// Get plugin info
	const pluginSlug = 'woo-custom-my-account-page';

	grunt.initConfig(
		{
			// Package info
			pkg: grunt.file.readJSON('package.json'),

				// Clean dist folder
			clean: {
				dist: {
					src: [ 'dist/**' ]
				}
			},

				// Copy files to dist folder
			copy: {
				dist: {
					files: [
						{
							expand: true,
							src: [
								'**',
								'!node_modules/**',
								'!dist/**',
								'!.git/**',
								'!.github/**',
								'!tests/**',
								'!bin/**',
								'!.gitignore',
								'!.gitattributes',
								'!Gruntfile.js',
								'!package.json',
								'!package-lock.json',
								'!composer.json',
								'!composer.lock',
								'!phpcs.xml',
								'!phpunit.xml',
								'!README.md',
								'!claude.md',
								'!.DS_Store'
							],
							dest: 'dist/<%= pkg.name %>/'
						}
					]
				}
			},

				// Compress to zip
			compress: {
				dist: {
					options: {
						archive: 'dist/<%= pkg.name %>-<%= pkg.version %>.zip',
						mode: 'zip'
					},
					files: [
						{
							expand: true,
							cwd: 'dist/',
							src: [ '<%= pkg.name %>/**' ],
							dest: '/'
						}
					]
				}
			},

				// Check text domain
			checktextdomain: {
				options: {
					text_domain: [ 'woo-custom-my-account-page' ], // Specify allowed domain(s)
					keywords: [ // List keyword specifications
						'__:1,2d',
						'_e:1,2d',
						'_x:1,2c,3d',
						'esc_html__:1,2d',
						'esc_html_e:1,2d',
						'esc_html_x:1,2c,3d',
						'esc_attr__:1,2d',
						'esc_attr_e:1,2d',
						'esc_attr_x:1,2c,3d',
						'_ex:1,2c,3d',
						'_n:1,2,4d',
						'_nx:1,2,4c,5d',
						'_n_noop:1,2,3d',
						'_nx_noop:1,2,3c,4d'
					]
				},
				target: {
					files: [ {
						src: [
						'*.php',
						'**/*.php',
						'!node_modules/**',
						'!options/framework/**',
						'!plugin-update-checker/**',
						'!tests/**'
							], // all php
						expand: true
					} ]
				}
			},
				// make po files
			makepot: {
				target: {
					options: {
						cwd: '.', // Directory of files to internationalize.
						domainPath: 'languages/', // Where to save the POT file.
						exclude: [ 'node_modules/*', 'options/framework/*'], // List of files or directories to ignore.
						mainFile: 'index.php', // Main project file.
						potFilename: 'woo-custom-my-account-page.pot', // Name of the POT file.
						potHeaders: { // Headers to add to the generated POT file.
							poedit: true, // Includes common Poedit headers.
							'Last-Translator': 'Varun Dubey',
							'Language-Team': 'Wbcom Designs',
							'report-msgid-bugs-to': '',
							'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
						},
						type: 'wp-plugin', // Type of project (wp-plugin or wp-theme).
						updateTimestamp: true // Whether the POT-Creation-Date should be updated without other changes.
					}
				}
			}
		}
	);

	// Register tasks
	grunt.registerTask( 'default', [ 'checktextdomain', 'makepot' ] );
	grunt.registerTask( 'build', [ 'clean:dist', 'copy:dist', 'compress:dist' ] );
	grunt.registerTask( 'zip', [ 'clean:dist', 'copy:dist', 'compress:dist' ] );
	grunt.registerTask( 'i18n', [ 'checktextdomain', 'makepot' ] );
};
