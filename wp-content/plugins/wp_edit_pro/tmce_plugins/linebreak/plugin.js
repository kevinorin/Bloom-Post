// JavaScript Document

jQuery(document).ready(function($) {
	
	tinymce.PluginManager.add( 'line_break', function( editor, url ) {
		
		// Register button
		editor.addButton( 'line_break_button', {
			image: url+'/line_break.png',
			tooltip: 'Insert LineBreak',
			//shortcut: 'Alt+Shift+W',
			onclick: insert_content
		});
		
		function insert_content() {
			
			editor.execCommand('mceInsertContent', !1, '<br class="none" />');
		}
		
		
	});
});