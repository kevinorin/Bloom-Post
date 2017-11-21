// JavaScript Document


jQuery(document).ready(function($) {
	
	

	tinymce.PluginManager.add( 'p_tags', function( editor, url ) {
		
		// Register button
		editor.addButton( 'p_tags_button', {
			
			image: url+'/p_tag.png',
			tooltip: 'Paragraph Tag',
			//shortcut: 'Alt+Shift+W',
			onclick: openWindow
		});
		
		
		
		// Create function for window manager
		function openWindow() {
			
			es = editor.selection;
			
			ptag_node = es.getNode().nodeName;
			ptag_id = es.getNode().id;
			ptag_class = es.getNode();
			ptag_class_name = $(ptag_class).attr('class');
			
			//ptag_styles = es.getNode().style;
			ptag_content = es.getContent({format: 'text'});
			
			var form_fields = [
				{
					type: 'textbox',
					name: 'ptag_id',
					size: 40,
					label: 'Tag ID:',
					value: ptag_id
				},
				{
					type: 'textbox',
					name: 'ptag_class',
					size: 40,
					label: 'Tag Class',
					value: ptag_class_name
				},
				{
					type: 'textbox',
					name: 'ptag_styles',
					size: 40,
					label: 'Tag Styles',
					//value: ptag_styles
				},
				{
					type: 'textbox',
					name: 'ptag_content',
					size: 40,
					minHeight: 200,
					multiline: true,
					label: 'Tag Content',
					value: ptag_content
				}
			];
		   
			editor.windowManager.open({
				
				title: 'Add Paragraph Tag',
				body: [
					{
						type: 'form',
						items: form_fields
					}
				],
				
				// Submit window info back to tinymce editor
				onsubmit: function (t) {
					
					editor.execCommand('mceInsertContent', !1, '<p id="'+t.data.ptag_id+'" class="'+t.data.ptag_class+'" style="'+t.data.ptag_styles+'">'+t.data.ptag_content+'</p>')
				}
			})
		}
		
		
		
	});
});