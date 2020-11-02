/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	/* Complete List of Toolbar Items for CKEditor */
	/*
		"Source","Save","NewPage","DocProps","Preview","Print","Templates","document"
		"Cut","Copy","Paste","PasteText","PasteFromWord","Undo","Redo"
		"Find","Replace","SelectAll","Scayt",items
		"Form","Checkbox","Radio","TextField","Textarea","Select","Button","ImageButton","HiddenField"
		"Bold","Italic","Underline","Strike","Subscript","Superscript","RemoveFormat"
		"NumberedList","BulletedList","Outdent","Indent","Blockquote","CreateDiv","JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock","BidiLtr","BidiRtl"
		"Link","Unlink","Anchor"
		,"CreatePlaceholder","Image","Flash","Table","HorizontalRule","Smiley","SpecialChar","PageBreak","Iframe","InsertPre"
		"Styles","Format","Font","FontSize"
		"TextColor","BGColor"
		"UIColor","Maximize","ShowBlocks"
		"button1","button2","button3","oembed","MediaEmbed"
		"About"
	*/

	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Save,NewPage,Preview,Print,Templates,PasteFromWord,PasteText,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Language,About,ShowBlocks,Maximize';

    /* toolbar Basic. 
    How to integrate:  CKEDITOR.replace('descr', { toolbar : 'Basic' });*/
	config.toolbar_Basic =
   	[
       /*['Source'],['Cut','Copy','Paste','PasteText'],*/
       ['Bold','Italic','Underline'],
   	];

    /* toolbar General. 
    How to integrate:  CKEDITOR.replace('descr', { toolbar : 'General' });*/
	config.toolbar_General =
   	[
       ['Source'],['Cut','Copy','Paste','PasteText','Undo','Redo'],
       ['Bold','Italic','Underline'],
       ['Strike','Subscript','Superscript','RemoveFormat'],
       '/',
       ['NumberedList','BulletedList','Outdent','Indent'],
       ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','BidiLtr','BidiRtl'],
       ['Link','Unlink','Anchor'],
       ['Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
       ['TextColor','BGColor'],
       ['Styles','Format','Font','FontSize'],
   	];

};
