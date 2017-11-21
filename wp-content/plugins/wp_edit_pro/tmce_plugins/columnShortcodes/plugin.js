// JavaScript Document


jQuery(document).ready(function($) {
	
	tinymce.PluginManager.add( 'columnShortcodes', function( editor, url ) {
		
		// Register button
		editor.addButton( 'columnShortcodes', {
			
			icon: 'schedule',
			tooltip: editor.getLang('wpep_langs.cshort_title'),
			onclick: columnShortcodeWindow
		});
		
		
		
		// Create function for window manager
		function columnShortcodeWindow() {
			
			editor.windowManager.open({
					
				title: editor.getLang('wpep_langs.cshort_title'),
				width: 900,
				height: 400,
				url: url+'/columnShortcodes.php'
			})
		}
	});
});