/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/*
 * This file is used/requested by the 'Styles' button.
 * The 'Styles' button is not enabled by default in DrupalFull and DrupalFiltered toolbars.
 */
if(typeof(CKEDITOR) !== 'undefined') {
	CKEDITOR.stylesSet.add( 'drupal',
	[
			{ name : 'Heading 2', element : 'h2'},
			{ name : 'Heading 3', element : 'h3'},
			{ name : 'Heading 4', element : 'h4'},
			{ name : 'No-wrap Text', element : 'span', attributes : { 'class' : 'nobr' } },
			{ name : 'Indented Text', element : 'p', attributes : { 'class' : 'text-indent' } },
			{ name : 'Computer Code', element : 'code', styles : { 'font-size' : '.9em' } }
	]);
}