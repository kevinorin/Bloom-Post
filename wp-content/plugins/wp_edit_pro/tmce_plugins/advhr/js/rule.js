
jQuery(document).ready(function($) {
	
	// Declare window variable
	var ed = top.tinymce.activeEditor;
	
	this_node = ed.selection.getNode();
	
	if(this_node.nodeName == 'HR') {
		
		get_num = '';
		num_val = '';
		
		node_width = $(this_node).attr('width');
		node_size = $(this_node).attr('size');
		node_shade = $(this_node).attr('noshade');
		console.log(node_shade);
		
		if (node_width.indexOf('px') >= 0) {
			
			get_num = node_width.replace('px', '');
			num_val = 'px';
		}
		if (node_width.indexOf('%') >= 0) {
			
			get_num = node_width.replace('%','');
			num_val = '%';
		}
		if (node_shade != undefined) {
			
			$('#noshade').prop('checked', 'checked');
		}
		
		$('#width').val(get_num);
		$('#width_unit').val(num_val);
		$('#height').val(node_size);
	}
	
	$('#advhr_insert').click(function() {
		
		this_node = ed.selection.getNode();
		if(this_node.nodeName == 'HR') {
			
			ed.windowManager.close();
			ed.selection.setContent(wpeditpro_insertHR());
		}
		else {
		
			wpeditpro_insertHR();
		}
	});
	
	$('#advhr_cancel').click(function($) {
		
		ed.windowManager.close();
	});
	
	function wpeditpro_insertHR() {
		
		width = $('#width').val();
		widthUnit = $('#width_unit').val();
		height = $('#height').val();
		output = '';
		style = '';
		
		output = '<hr ';
		
		if(width) {
			output += ' width="' + width + widthUnit + '"';
			style += ' width:' + width + widthUnit + ';';
		}
		if(height) {
			output += ' size="' + height + '"';
			style += ' height:' + height + 'px;';
		}
		if($('#noshade').is(':checked')) {
			output += ' noshade="noshade"';
			style += ' border-width: 1px; border-style: solid; border-color: #CCCCCC; color: #ffffff;';
		}
		
		output += ' style="' + $.trim(style) + '"';
		output += ' />';
		
		
		ed.execCommand("mceInsertContent", false, output);
		ed.windowManager.close();
	}
	
});