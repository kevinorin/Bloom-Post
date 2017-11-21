

jQuery(document).ready(function($) {
	
	tinymce.PluginManager.add('dropbox', function(ed, url) {
		
		ed.addButton('dropbox', {
			image: url+'/dropbox.png',
			tooltip: ed.getLang('wpep_langs.dropbox_title'),
			onclick: function() {
				
				dropbox_options = {

					// Required. Called when a user selects an item in the Chooser.
					success: function(files) {
						//alert("Here's the file link: " + files[0].link);
						data = '';
						for(i=0;i<files.length;i++) {
							
							data += '<a target="_blank" href="'+files[i].link+'">'+files[i].name+'</a><br />'
						}
						tinymce.activeEditor.execCommand('mceInsertContent', !1, data);
						tinymce.activeEditor.windowManager.close();
					},
				
					// Optional. Called when the user closes the dialog without selecting a file
					// and does not include any parameters.
					cancel: function() {
				
					},
				
					// Optional. "preview" (default) is a preview link to the document for sharing,
					// "direct" is an expiring link to download the contents of the file. For more
					// information about link types, see Link types below.
					linkType: "preview", // or "direct"
				
					// Optional. A value of false (default) limits selection to a single file, while
					// true enables multiple file selection.
					multiselect: true, // or true
				
					// Optional. This is a list of file extensions. If specified, the user will
					// only be able to select files with these extensions. You may also specify
					// file types, such as "video" or "images" in the list. For more information,
					// see File types below. By default, all extensions are allowed.
					
					// extensions: ['.pdf', '.doc', '.docx'],
					extensions: []
				};
				
				// Check that dropbox exists
				if(typeof Dropbox !== 'undefined') {
					
					Dropbox.choose(dropbox_options);
				}
				// Else dropbox does not exist
				else {
					
					alert(ed.getLang('wpep_langs.dropbox_no_app_key') + '\n\n' + ed.getLang('wpep_langs.dropbox_no_app_key2'));
				}
			}
		});
	});
});