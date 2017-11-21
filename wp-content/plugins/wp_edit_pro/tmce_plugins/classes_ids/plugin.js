
jQuery(function($) {
	
	tinymce.PluginManager.add( 'classes_ids', function( editor, url ) {
		
		// Declare global variables
		var self = this, button_classes, button_ids;
		tinyMCE.activeEditor.settings.wpeditproKeyValueList = new Object();
		
		
		// Get values from global tinymce setting
		function getValues(type) {
			
			if(type == 'classes') {
				
				return editor.settings.wpeditproKeyValueList.final_classes;
			}
			if(type == 'ids') {
				return editor.settings.wpeditproKeyValueList.final_ids;
			}
		}
		
		// Add Classes button
		editor.addButton('wpeditpro_classes', {
			
			type: 'listbox',
			text: 'Classes',
			tooltip: 'WP Edit Pro Classes',
			style: 'width:105px;',
			classes: 'btn fixed-width wpeditpro_classes',
			disabled: true,
			values: getValues('classes'),
			onselect: function(e) {
				
				// Get selected node
				sel_node = tinyMCE.activeEditor.selection.getNode();
				// Get node class name(s)
				sel_node_class = $(sel_node).attr('class');
				
				// If selected node class is not undefined
				if(sel_node_class != undefined) {
					$(sel_node).removeAttr('class');  // remove orig classes
				}
				$(sel_node).addClass(e.target.value());  // add new class
				
				// Reset selected value
				e.target.value(null);
				
				// Add editor undo event
				editor.undoManager.add();
			},
			onPostRender: function() {
				
				// Hack to get button reference
				button_classes = this;
			}
		});
		// Add IDs button
		editor.addButton('wpeditpro_ids', {
			
			type: 'listbox',
			text: 'IDs',
			tooltip: 'WP Edit Pro IDs',
			style: 'width:105px;',
			classes: 'btn fixed-width wpeditpro_ids',
			disabled: true,
			values: getValues('ids'),
			onselect: function(e) {
				
				var cur_val = e.target.value();
				
				// Get selected node
				var sel_node = tinyMCE.activeEditor.selection.getNode();
				// Get node id name(s)
				sel_node_id = $(sel_node).attr('id');
				
				// If selected node has an ID value, remove
				if(sel_node_id != undefined) {
					$(sel_node).removeAttr('id');  // remove orig ids
				}
				
				// Check editor for another element with same ID
				matching_ed_id = tinyMCE.activeEditor.dom.get(cur_val);
				// If another matching element (by ID) is found
				if(matching_ed_id) {
					
					// Get all matching elements (by ID) in the content area
					get_match_elms = tinymce.activeEditor.dom.select('*#'+cur_val);
					// Stringify results
					stringify_elms = $('<div>').append($(get_match_elms).clone()).html();
					
					// Alert user and ask for permission to remove matching ID attributes
					if(confirm('This ID already exists '+Object.keys(get_match_elms).length+' time(s) elsewhere in the content area.\n\n'+stringify_elms+'\n\nDo you wish to remove these matching elements ID attribute?')) {
						
						// Each element - remove ID attribute
						$.each(get_match_elms, function(i) {
							
							// Remove ID attribute
							$(this).removeAttr('id');
				
							// Add editor undo event
							editor.undoManager.add();
						});
					}
				}
						
				// Add new id to selected node
				$(sel_node).attr('id', cur_val);
				
				// Add editor undo event
				editor.undoManager.add();
			},
			onPostRender: function() {
				
				// Hack to get button reference
				button_ids = this;
			}
		});
		
		// Refresh self so buttons get repopulated
		self.refresh = function(e) {
			
			// If we have clicked outside of the editor; reset buttons
			if(e == 'reset') {
				
				button_classes.disabled(true);  // Set button disabled
				button_classes.text('Classes');  // Set button name to 'Classes'
				button_classes.settings.tooltip = 'WP Edit Pro Classes';  // Set tooltip
				
				button_ids.disabled(true);  // Set button disabled
				button_ids.text('IDs');  // Set button name to 'IDs'
				button_ids.settings.tooltip = 'WP Edit Pro IDs';  // Set tooltip
				
				return;
			}
			
			//remove existing menus if already rendered
			if(button_classes.menu){
				button_classes.menu.remove();
				button_classes.menu = null;
			}
			if(button_ids.menu){
				button_ids.menu.remove();
				button_ids.menu = null;
			}
			
			// Create new menu objects
			button_classes.settings.values = button_classes.settings.menu = getValues('classes');
			button_ids.settings.values = button_ids.settings.menu = getValues('ids');
			
			// Check if objects are empty
			if($.isEmptyObject(button_classes.settings.values)) {
				
				button_classes.disabled(true);  // Set button disabled
				button_classes.text('Classes');  // Set button name to 'Classes'
			}
			else {
				
				button_classes.disabled(false);  // Set button enabled
				
				sel_node = tinyMCE.activeEditor.selection.getNode();  // Get selected node
				sel_node_class = $(sel_node).attr('class');  // Get selected class
				
				if(sel_node_class != undefined) {  // If class exists
				
					button_classes.text('.'+sel_node_class);  // Set button name to current selected node class
					button_classes.settings.tooltip = '.'+sel_node_class;
				}
				else {  // Else class does not exist
				
					button_classes.text('Classes');  // Set button name to 'Classes'
					button_classes.settings.tooltip = 'WP Edit Pro Classes';
				}
			}
			if($.isEmptyObject(button_ids.settings.values)) {
				
				button_ids.disabled(true);  // Set button disabled
				button_ids.text('IDs');  // Set button name to 'IDs'
			}
			else {
				
				button_ids.disabled(false);  // Set button enabled
				
				sel_node = tinyMCE.activeEditor.selection.getNode();  // Get selected node
				sel_node_id = $(sel_node).attr('id');  // Get selected id
				
				if(sel_node_id != undefined) {  // If id exists
				
					button_ids.text('#'+sel_node_id);  // Set button name to current selected node id
					button_ids.settings.tooltip = '#'+sel_node_id;
				}
				else {  // Else class does not exist
				
					button_ids.text('IDs');  // Set button name to 'IDs'
					button_ids.settings.tooltip = 'WP Edit Pro IDs';
				}
			}
		};
		
		// Editor on click function; to check node and populate dropdown menus
		editor.on('click', function(e) {
			
			// Declare variables
			var final_class_buttons = [];
			var final_id_buttons = [];
			var class_array = [];
			var id_array = [];
			
			// If the wp_edit_pro_classes_ids var is successfully passed from main.php
			if(wp_edit_pro_classes_ids) {
				
				// Get rulelist object from css parser
				rulelist = wp_edit_pro_classes_ids.rulelist;
			
				// Loop each element in rulelist
				$.each(rulelist, function(i) {
					
					// If the type is a style
					if(this.type === 'style') {
						
						// Deine variables
						selector_class = '';
						selector_type_class = '';
						selector_node_class = '';
						selector_name_class = '';
						
						selector_id = '';
						selector_type_id = '';
						selector_node_id = '';
						selector_name_id = '';
						
						// Split classes
						split_class = this.selector.split('.');
						if(split_class[0] != '' && split_class[0].indexOf('#') == -1 && split_class[0] != 'undefined') {
							
							selector_class = this.selector.split('.');
							selector_type_class = '.';
							selector_node_class = selector_class[0];  // Node name
							selector_name_class = selector_class[1];  // Class name
							
							if(selector_node_class) {
								
								// Build classes array
								class_array[i] = {type: selector_type_class, node: selector_node_class, name: selector_name_class, buttons: {text: '.'+selector_name_class, value: selector_name_class}};
							}
						}
						
						// Split ids
						split_id = this.selector.split('#');
						if(split_id[0] != '' && split_id[0].indexOf('.') == -1) {
							
							selector_id = this.selector.split('#');
							selector_type_id = '#';
							selector_node_id = selector_id[0];  // Node name
							selector_name_id = selector_id[1];  // ID name
							
							if(selector_node_id != '') {
								
								// Build IDs array
								id_array[i] = {type: selector_type_id, node: selector_node_id, name: selector_name_id, buttons: {text: '#'+selector_name_id, value: selector_name_id}};
							}
						}
					}
				});
			}
			
			// If the current tinymce selection exists
			if(tinyMCE.activeEditor.selection != undefined) {
				
				// Get selected node name
				sel_node = tinyMCE.activeEditor.selection.getNode().nodeName.toLowerCase();
				
				// Run each function to create array of class items
				$.each(class_array, function(i) {
					if(this.node == sel_node) {
						final_class_buttons[i] = this.buttons;
					}
				});
				var final_class_buttons = final_class_buttons.filter(function(n){ return n != undefined });  // Check for empty array items and remove
				
				// Run each function to create array of id items
				$.each(id_array, function(i) {
					if(this.node == sel_node) {
						final_id_buttons[i] = this.buttons;
					}
				});
				var final_id_buttons = final_id_buttons.filter(function(n){ return n != undefined });  // Check for empty array items and remove
			}
			
			// Set new values to wpeditproKeyValueList tinymce global setting
			tinyMCE.activeEditor.settings.wpeditproKeyValueList = {final_classes: final_class_buttons, final_ids: final_id_buttons};
			console.log(tinyMCE.activeEditor.settings.wpeditproKeyValueList);
			
			// Call plugin method to reload the dropdowns
			tinyMCE.activeEditor.plugins.classes_ids.refresh();
		});
	});
	
	// Reset buttons if clicked outside content editor
	$('body').on('click', function(e) {
		
		if($(e.target).parent().hasClass('mce-wpeditpro_classes') || $(e.target).parent().hasClass('mce-wpeditpro_ids')) {
			
			return;
		}
		else {
			
			tinyMCE.activeEditor.plugins.classes_ids.refresh('reset');
		}
	});
});