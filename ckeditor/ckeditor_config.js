CKEDITOR.plugins.addExternal( 'jsplus_image_editor', '/ckeditor/plugins/btgrid', '' );
CKEDITOR.plugins.addExternal( 'jsplus_image_editor', '/ckeditor/plugins/dialog', '' );
CKEDITOR.plugins.addExternal( 'jsplus_image_editor', '/ckeditor/plugins/widget', '' );
//CKEDITOR.plugins.addExternal( 'jsplus_image_editor', '/ckeditor/plugins/widgetbootstrap', '' );

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.language = 'en';
	// config.uiColor = '#AADC6E';
    config.extraPlugins = 'btgrid';
    config.extraPlugins = 'dialog';
    config.extraPlugins = 'widget';
    /*config.extraPlugins = 'widgetbootstrap';*/

        config.filebrowserBrowseUrl : '../filemanager/elfinder.html';
};
    
    