/**
 *
 *
 * @author Josh Lobe
 * http://wpeditpro.com
 */
 

jQuery(document).ready(function($) {
	
	// Add tabbed content to window
	$('#tabbed_content').tabs();
	
	// Declare window variable
	var this_advlink_window = top.tinymce.activeEditor;
	
	// Check if node is an a element.. and if so, populate any exisiting elements into popup window
	// EDIT MODE
	get_nodename = this_advlink_window.selection.getNode().nodeName;
	if(get_nodename == 'A' || get_nodename == 'a') {
		
		// Get active node
		get_node = this_advlink_window.selection.getNode();
		// jQuery-ify it
		jq_node = $(get_node);
		// Extract attributes
		jq_link = jq_node.attr('href');
		jq_id = jq_node.attr('id');
		jq_title = jq_node.attr('title');
		jq_classes = jq_node.attr('class');
		jq_style = jq_node.attr('style');
		jq_target = jq_node.attr('target');
		jq_nofollow = jq_node.attr('rel');
		// Exttract js events
		jq_onclick = jq_node.attr('onclick');
		jq_ondblclick = jq_node.attr('ondblclick');
		jq_onmousedown = jq_node.attr('onmousedown');
		jq_onmouseout = jq_node.attr('onmouseout');
		jq_onmouseover = jq_node.attr('onmouseover');
		jq_onmouseup = jq_node.attr('onmouseup');
		
		// Populate attributes
		if(jq_link != 'undefined') {
			$('#advlink_link').val(jq_link);
		}
		if(jq_id != 'undefined') {
			$('#advlink_id').val(jq_id);
		}
		if(jq_title != 'undefined') {
			$('#advlink_title').val(jq_title);
		}
		if(jq_classes != 'undefined') {
			$('#advlink_classes').val(jq_classes);
		}
		if(jq_style != 'undefined') {
			$('#advlink_style').val(jq_style);
		}
		if(!jq_target) {
			$('#advlink_target').val('select');
		}else{
			$('#advlink_target').val(jq_target);
		}
		if(jq_nofollow == 'nofollow') {
			$('#advlink_nofollow').prop('checked', true);
			$('#advlink_nofollow_label').html('On');
		}
		
		// Populate Events
		if(jq_onclick != 'undefined') {
			$('#advlink_onclick_event').val(jq_onclick);
		}
		if(jq_ondblclick != 'undefined') {
			$('#advlink_ondblclick_event').val(jq_ondblclick);
		}
		if(jq_onmousedown != 'undefined') {
			$('#advlink_onmousedown_event').val(jq_onmousedown);
		}
		if(jq_onmouseout != 'undefined') {
			$('#advlink_onmouseout_event').val(jq_onmouseout);
		}
		if(jq_onmouseover != 'undefined') {
			$('#advlink_onmouseover_event').val(jq_onmouseover);
		}
		if(jq_onmouseup != 'undefined') {
			$('#advlink_onmouseup_event').val(jq_onmouseup);
		}
	}
	
	
	// Action buttons
	$('#advlink_cancel').click(function() {
		
		this_advlink_window.windowManager.close();
	});
	$('#advlink_insert').click(function() {
		
		// Get values from window
		this_link = $('#advlink_link').val();
		this_id = $('#advlink_id').val();
		this_title = $('#advlink_title').val();
		this_classes = $('#advlink_classes').val();
		this_style = $('#advlink_style').val();
		this_target = $('#advlink_target').val();
		
		// Get events from window
		this_onclick = $('#advlink_onclick_event').val();
		this_ondblclick = $('#advlink_ondblclick_event').val();
		this_onmousedown = $('#advlink_onmousedown_event').val();
		this_onmouseout = $('#advlink_onmouseout_event').val();
		this_onmouseover = $('#advlink_onmouseover_event').val();
		this_onmouseup = $('#advlink_onmouseup_event').val();
		
		// Get checkbox values
		this_nofollow = $('#advlink_nofollow').is(':checked');
		
		// Get active selection
		var get_selection = this_advlink_window.selection.getContent({format : 'text'});
		
		// Add appropriate options if user selected
		//if(this_link == '' && this_id == '' && this_classes == '' && this_style == '' && this_target == 'select' && this_nofollow == false) {
			//alert('Nothing has been changed, so nothing will be modified in the content editor.');
			//return false;
		//}
		
		
		// Start link building
		final_link = '<a';
		
		// Check link url
		if(this_link != '') {
			final_link += ' href="'+this_link+'"';
		}
		// Check ID
		if(this_id != '') {
			final_link += ' id="'+this_id+'"';
		}
		// Check Title
		if(this_title != '') {
			final_link += ' title="'+this_title+'"';
		}
		// Check Classes
		if(this_classes != '') {
			final_link += ' class="'+this_classes+'"';
		}
		// Check Style
		if(this_style != '') {
			final_link += ' style="'+this_style+'"';
		}
		// Check target
		if(this_target != 'select' && this_target != null) {
			final_link += ' target="'+this_target+'"';
		}
		// Check NoFollow
		if(this_nofollow == true) {
			final_link += ' rel="nofollow"';
		}
		
		// Check onclick
		if(this_onclick != '') {
			final_link += ' onclick="'+this_onclick+'"';
		}
		// Check ondblclick
		if(this_ondblclick != '') {
			final_link += ' ondblclick="'+this_ondblclick+'"';
		}
		// Check onmousedown
		if(this_onmousedown != '') {
			final_link += ' onmousedown="'+this_onmousedown+'"';
		}
		// Check onmouseout
		if(this_onmouseout != '') {
			final_link += ' onmouseout="'+this_onmouseout+'"';
		}
		// Check onmouseover
		if(this_onmouseover != '') {
			final_link += ' onmouseover="'+this_onmouseover+'"';
		}
		// Check onmouseup
		if(this_onmouseup != '') {
			final_link += ' onmouseup="'+this_onmouseup+'"';
		}
		
		
		// Add closing tag
		final_link += '>';
		
		
		// If selection is empty, we have to get node inner content to pass back to editor
		if(get_selection == '') {
			// Get node html
			get_innerhtml = this_advlink_window.selection.getNode().innerHTML;
			
			orig_node = this_advlink_window.selection.getNode();
			this_advlink_window.dom.remove(orig_node);
		}
		// Else get active selection
		else {
			get_innerhtml = get_selection;
		}
		// Add html to final link
		final_link += get_innerhtml;
		
		// Build link closing tag
		final_link += '</a>';
	
		// Insert content into editor
		this_advlink_window.execCommand('mceInsertContent', !1, final_link); 
		// Close window
		this_advlink_window.windowManager.close(); 
	});
	
	
	// Style checkboxes with jquery UI button
	$( "#advlink_nofollow" ).button();
	
	// Adjust button text based on click state
	$( "#advlink_nofollow" ).click(function() {
		
		isset_advlink = $(this).is(':checked');
		if(isset_advlink == true) {
			$('#advlink_nofollow_label > span').html('On');
		}
		else {
			$('#advlink_nofollow_label > span').html('Off');
		}
	});
	
	// Click function for existing content
	$('#load_results').click(function() {
		
		$('.query_results').remove();
		$('#search_block').toggle();
		
		if ($(this).hasClass('open')) {
			$(this).removeClass('open').addClass('close');
		} else if ($(this).hasClass('close')) {
			$(this).removeClass('close').addClass('open');
		}
		
		var load_data = {
			action: 'wpeditpro_load_advlink_pages',
			sorting: 'select'
		};
		
		// Get passed js vars from main.php
		var editor_params = top.tinymce.activeEditor.windowManager.getParams();
		// Run ajax to get post/page items
		$.post(editor_params.wpeditpro_ajaxurl, load_data, function(response) {
			
			// Loop each array item
			$.each(response.final, function(k, v) {
				
				$('#wp_page_results').append('<div class="query_results"><span class="span_title">' + v.title + '</span><span class="span_type">' + v.post_type + '</span>'+
				'<input type="hidden" id="this_al_link" value="'+v.permalink+'" />'+
				'<div style="clear:both;"></div></div>');
			});
		});
	});
	
	// Each row click
	$(body).on('click', '.query_results', function() {
		
		// Get hidden input values
		this_href = $(this).children().closest('#this_al_link').val();
		this_title = $(this).children().closest('.span_title').html();
		
		// Populate window input boxes
		$('#advlink_link').val(this_href);
		$('#advlink_title').val(this_title);
		
		// Scroll to top of window
		window.scrollTo(0, 0);
	});
	
	// Sort function
	$(body).on('change', '.select_sort', function() {
		
		this_val = $(this).val();
		
		$('.select_sort').val('select');
		$(this).val(this_val);
		
		// Remove current results
		$('.query_results').remove();
		
		// Define ajax vars
		load_data = {
			action: 'wpeditpro_load_advlink_pages',
			sorting: this_val
		};
		
		// Get passed js vars from main.php
		editor_params = top.tinymce.activeEditor.windowManager.getParams();
		
		$.post(editor_params.wpeditpro_ajaxurl, load_data, function(response) {
			
			// Loop each array item
			$.each(response.final, function(k, v) {
				
				$('#wp_page_results').append('<div class="query_results"><span class="span_title">' + v.title + '</span><span class="span_type">' + v.post_type + '</span>'+
				'<input type="hidden" id="this_al_link" value="'+v.permalink+'" />'+
				'<div style="clear:both;"></div></div>');
			});
		});
	});
	
	// Search function
	$('.select_search').blur(function() {
		
		// Remove current results
		$('.query_results').remove();
		
		// Define ajax vars
		load_data = {
			action: 'wpeditpro_load_advlink_pages',
			sorting: 'search_box',
			value: $(this).val()
		};
		
		// Get passed js vars from main.php
		editor_params = top.tinymce.activeEditor.windowManager.getParams();
		
		$.post(editor_params.wpeditpro_ajaxurl, load_data, function(response) {
			
			// Loop each array item
			$.each(response.final, function(k, v) {
				
				$('#wp_page_results').append('<div class="query_results"><span class="span_title">' + v.title + '</span><span class="span_type">' + v.post_type + '</span>'+
				'<input type="hidden" id="this_al_link" value="'+v.permalink+'" />'+
				'<div style="clear:both;"></div></div>');
			});
		});
	});
	
});