/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	// ...
   config.filebrowserBrowseUrl = '/lib/kcfinder-master/browse.php?opener=ckeditor&type=files';
   config.filebrowserFlashBrowseUrl = '/lib/kcfinder-master/browse.php?opener=ckeditor&type=flash';
   config.filebrowserImageBrowseUrl = '/lib/kcfinder-master/browse.php?opener=ckeditor&type=images';
   config.filebrowserUploadUrl = '/lib/kcfinder-master/upload.php?opener=ckeditor&type=files';
   config.filebrowserFlashUploadUrl = '/lib/kcfinder-master/upload.php?opener=ckeditor&type=flash';
   config.filebrowserImageUploadUrl = '/lib/kcfinder-master/upload.php?opener=ckeditor&type=images';
// ...
};
