/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
CKEDITOR.editorConfig = function(config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.skin = "office2013";
    config.height = "360";
    config.font_names = "宋体/宋体;黑体/黑体;仿宋/仿宋;楷体/楷体;微软雅黑/微软雅黑;隶书/隶书;幼圆/幼圆;华文行楷/华文行楷;华文楷体/华文楷体;方正舒体/;方正姚体/方正姚体;华文彩云/华文彩云;" + config.font_names;
    config.filebrowserUploadUrl = "/ckeditor/upload.php?type=attachment";
    config.filebrowserImageUploadUrl = "/ckeditor/upload.php?type=image";
    config.filebrowserFlashUploadUrl = "/ckeditor/upload.php?type=flash";
    config.removeButtons = 'Save,NewPage,About';
};