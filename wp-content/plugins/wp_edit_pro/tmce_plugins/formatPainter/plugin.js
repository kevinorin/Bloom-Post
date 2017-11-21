// JavaScript Document


jQuery(document).ready(function($) {
	
	

	tinymce.PluginManager.add( 'formatPainter', function( editor, url ) {
		
		// Register button
		editor.addButton( 'formatPainter', {
			
			//image: url+'/images/formatPainter.png',
			icon: 'format_painter',
			tooltip: 'Format Painter',
			onclick: get_formatPainter
		});
		
		
		
		// Create function for window manager
		function get_formatPainter() {
			
			var state = this.active();  // Is this button active
			
			if(state == false) {  // Button is not active
				
				// Get active node classes and styles
				activeNode_from = top.tinymce.activeEditor.selection.getNode();
				nodeClass_from = $(activeNode_from).attr('class');
				nodeStyle_from = $(activeNode_from).attr('style');
				
				if(nodeClass_from == undefined && nodeStyle_from == undefined) {
					
					alert('No styling is available to copy. Please select an element with class or style attributes.');
				}
				else {
				
					// Open overlay window
					editor.windowManager.open({
					
						title: 'Format Painter',
						body: [
							{
								type: 'container',
								html: 'The styling has been copied.<br /><table cellspacing="10"><tbody><tr><td>Classes:</td><td>'+((nodeClass_from==undefined)?'':nodeClass_from)+'</td></tr><tr><td>Styles:</td><td>'+((nodeStyle_from==undefined)?'':nodeStyle_from)+'</td></tr></tbody></table><br />Please select the area where you would like to apply the styling; and click the "Format Painter" button again.'
							}
						],
						
						// Submit window info back to tinymce editor
						onsubmit: function (t) {
					
							top.tinymce.activeEditor.controlManager.setActive('formatPainter', 'true');  // Set painter button to active
						}
					})
				}
			}
			else {  // Else button is active
			
				activeNode_to = top.tinymce.activeEditor.selection.getNode();
				nodeClass_to = $(activeNode_to).attr('class');
				nodeStyle_to = $(activeNode_to).attr('style');
				
				// Define form variables
				var form_fields_from = [
					{
						type: 'textbox',
						name: 'fp_classes_from',
						size: 40,
						label: 'Adding Classes',
						value: nodeClass_from  // Insert original node classes
					},
					{
						type: 'textbox',
						name: 'fp_styles_from',
						size: 40,
						label: 'Adding Styles',
						value: nodeStyle_from  // Insert original node styles
					}
				];
				
				var form_fields_to = [
					{
						type: 'textbox',
						name: 'fp_classes_to',
						size: 40,
						label: 'Current Classes',
						value: nodeClass_to  // Insert original node classes
					},
					{
						type: 'textbox',
						name: 'fp_styles_to',
						size: 40,
						label: 'Current Styles',
						value: nodeStyle_to  // Insert original node styles
					}
				];
				
				// Open overlay window
				
				editor.windowManager.open({
				
					title: 'Format Painter',
					body: [
						{
							type: 'container',
							html: 'These are the classes and/or styles which existed in the old selection.'
						},
						{
							type: 'form',
							items: form_fields_from  // Populate form fields
						},
						{
							type: 'container',
							html: 'These are the classes and/or styles which exist in the new selection.'
						},
						{
							type: 'form',
							items: form_fields_to
						},
						{
							type: 'container',
							html: 'The information above may be edited, if desired.'
						},
						{
							type: 'container',
							html: 'Select to "replace","combine" or "ignore" the old styles with the new styles.'
						},
						{
							type: 'listbox',
							name: 'insert_classes',
							label: 'Select Insert Method for Classes:',
							values: [
								{
									text: 'Replace',
									value: 'replace_classes'
								},
								{
									text: 'Combine',
									value: 'combine_classes'
								},
								{
									text: 'Ignore',
									value: 'ignore_classes'
								}
							]
						},
						{
							type: 'listbox',
							name: 'insert_styles',
							label: 'Select Insert Method for Styles:',
							values: [
								{
									text: 'Replace',
									value: 'replace_styles'
								},
								{
									text: 'Combine',
									value: 'combine_styles'
								},
								{
									text: 'Ignore',
									value: 'ignore_styles'
								}
							]
						}
					],
					
					// Submit window info back to tinymce editor
					onsubmit: function (t) {
						
						activeNode_to = top.tinymce.activeEditor.selection.getNode();
						insert_classes_val = t.data.insert_classes;
						insert_styles_val = t.data.insert_styles;
						
						// Manipulate final classes
						if(insert_classes_val == 'replace_classes') {
							
							$(activeNode_to).removeClass();  // remove original classes
							$(activeNode_to).addClass(t.data.fp_classes_from);
						}
						else if(insert_classes_val == 'combine_classes') {
							
							$(activeNode_to).addClass(t.data.fp_classes_from);
						}
						else if(insert_classes_val == 'ignore_classes') {
							// Do nothing
						}
						
						// Manipulate final styles
						if(insert_styles_val == 'replace_styles') {
							
							$(activeNode_to).attr('style', '');  // Clear original style
							$(activeNode_to).attr('data-mce-style', '');  // Clear original tinymce style
							
							$(activeNode_to).attr('style', t.data.fp_styles_from);  // Add new styles
							$(activeNode_to).attr('data-mce-style', t.data.fp_styles_from);  // Add new tinymce styles
						}
						else if(insert_styles_val == 'combine_styles') {
							
							get_orig_style = $(activeNode_to).attr('style');  // Get original style
							get_orig_data_style = $(activeNode_to).attr('data-mce-style');  // Get original data style
							
							$(activeNode_to).attr('style', ''); // Clear all style
							$(activeNode_to).attr('data-mce-style', ''); // Clear all data style
							
							$(activeNode_to).attr('style', get_orig_style + t.data.fp_styles_from);  // Send back combined styles
							$(activeNode_to).attr('data-mce-style', get_orig_data_style + t.data.fp_styles_from);  // Send back combined styles
						}
						else if(insert_styles_val == 'ignore_styles') {
							// Do nothing
						}
						
						top.tinymce.activeEditor.controlManager.setActive('formatPainter', false);  // Set painter button to non-active
					},
					onClose: function() {
						
						top.tinymce.activeEditor.controlManager.setActive('formatPainter', false);  // Set painter button to non-active
					}
				})
			}
		}
	});
});