/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	config.uiColor = "#F0F0F0";    // UI색상변경
	config.width = '600px';
	config.height = '200px';          // CKEditor 높이
	config.skin = 'office2013';       // CKEditor 스킨
	config.youtube_width = '350';
	config.youtube_height = '200';


	/*config.extraPlugins = 'dragdrop';*/
	config.extraPlugins = 'dropler';
	config.extraPlugins = 'tableresize'; //table Resize

	config.font_names = 'TAKUMIYFONTMINI;Hooncat; 맑은 고딕; 돋움; 바탕; 돋음; 궁서; Nanum Gothic Coding; Quattrocento Sans;' + CKEDITOR.config.font_names;


	config.extraPlugins = 'wordcount';
	config.wordcount = {

		// Whether or not you want to show the Word Count
		showWordCount: true,

		// Whether or not you want to show the Char Count
		showCharCount: true,

		// Maximum allowed Word Count
		maxWordCount: 100,

		// Maximum allowed Char Count
		maxCharCount: 110
	};
	//config.extraPlugins = 'imagepaste';
	// CKFinder 설정

	config.filebrowserBrowseUrl = '/public/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '/public/ckfinder/ckfinder.html?Type=Images';
	config.filebrowserFlashBrowseUrl = '/public/ckfinder/ckfinder.html?Type=Flash';
	config.filebrowserUploadUrl = '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl ='/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl ='/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

	//config.uploadUrl = '/htdocs/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json';

	// The toolbar groups arrangement, optimized for two toolbar rows.
	/*config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];*/

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
