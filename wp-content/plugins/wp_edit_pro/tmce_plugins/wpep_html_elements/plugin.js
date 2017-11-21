
(function($) {
	
	tinymce.PluginManager.add('wpep_html_elements', function( editor, url ) {
		
		editor.addButton('wpep_html_elements', {
			
			image: url+'/html_tags.png',
			tooltip: 'Select HTML Tag',
			onclick: function() {
				
				editor.windowManager.open( {
					
					title: 'Select Tag',
					width: 400,
					height: 200,
					body: [
						{
							type: 'listbox',
							name: 'block_levels',
							label: 'Select Block Level Element:',
							'values': [
								{text: 'Select...', value: ''},
								{text: 'div', value: 'div'},
								{text: 'p', value: 'p'},
								{text: 'h1', value: 'h1'},
								{text: 'h2', value: 'h2'},
								{text: 'h3', value: 'h3'},
								{text: 'h4', value: 'h4'},
								{text: 'h5', value: 'h5'},
								{text: 'h6', value: 'h6'},
								{text: 'blockquote', value: 'blockquote'},
								{text: 'pre', value: 'pre'}
							]
						},
						{
							type: 'container',
							html: '<div style="text-align:center;">Or...</div>'
						},
						{
							type: 'listbox',
							name: 'inline',
							label: 'Select Inline Element:',
							'values': [
								{text: 'Select...', value: ''},
								{text: 'span', value: 'span'},
								{text: 'code', value: 'code'}
							]
						}
					],
					onsubmit: function(e) {
						
						// If two selections are made... alert user
						if(e.data.block_levels != '' && e.data.inline != '') {
							
							alert('Only one selection can be made at a time. Please select either a block level element OR an inline element.');
							e.preventDefault();
						}
						// Else if no selection is made... alert user
						else if(e.data.block_levels === '' && e.data.inline === '') {
							
							alert('One selection must be made. Please make a selection.');
							e.preventDefault();
						}
						// Else continue
						else {
							
							// Get selection from previous window
							if(e.data.block_levels != '')
								element = e.data.block_levels;
							if(e.data.inline != '')
								element = e.data.inline;
							
							// Close previous window
							editor.windowManager.close();
							
							// Open new window
							editor.windowManager.open({
								
								title: element+' element',
								body: [
									{
										type: 'container',
										html: 'You are creating a(n) <span style="font-weight:bold;">'+element+'</span> element.'
									},
									{
										type: 'textbox',
										name: 'id',
										label: 'ID: '
									},
									{
										type: 'textbox',
										name: 'class',
										label: 'Class: '
									},
									{
										type: 'textbox',
										name: 'styles',
										label: 'Style: '
									}
								],
								onsubmit: function(e) {
									
									// Get editor selection
									selected = editor.selection.getContent();
									
									// Begin building content to send back to editor
									send_to_editor = '<'+element+' ';
									
									if(e.data.id != '')
										send_to_editor += 'id="'+e.data.id+'" ';
										
									if(e.data.class != '')
										send_to_editor += 'class="'+e.data.class+'" ';
										
									if(e.data.styles != '')
										send_to_editor += 'style="'+e.data.styles+'" ';
										
									send_to_editor += '>'+selected+'</'+element+'>';
									
									// Send content back to editor
									editor.insertContent(send_to_editor);
									
									// Close window
									editor.windowManager.close();
								}
							});
						}
					}
				});
			}
		});
	});
})(jQuery);