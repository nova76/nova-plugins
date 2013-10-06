/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
  config.language = 'hu';
  config.format_tags = 'p;h2;h3;h4';
  config.entities = false;
  config.height = 500;
  config.disableNativeSpellChecker = false;
  config.scayt_autoStartup = false;
};

CKEDITOR.config.toolbar_Full =
[
    ['Source'],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'Templates'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    '/',
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    '/',
    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],
    ['Format','FontSize'],
    ['TextColor','BGColor']
];