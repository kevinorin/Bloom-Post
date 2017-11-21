/**
 *
 *
 * @author Josh Lobe
 * http://wpeditpro.com
 */


jQuery(document).ready(function($) {
		
	// Populate original image size
	var orig_image = top.tinymce.activeEditor.selection.getNode();
	var orig_width = orig_image.naturalWidth;
	var orig_height = orig_image.naturalHeight;
	orig_width_final = (orig_width != undefined) ? orig_width+'px' : '';
	orig_height_final = (orig_height != undefined) ? orig_height+'px' : '';
	$('#orig_width_val').html(orig_width_final);
	$('#orig_height_val').html(orig_height_final);
	
	// If the image width input box gets blurred
	$('#attributes-image-width').on('keyup', function() {
		
		// Check if we are maintaining proportions
		if($('#maintain_proportions').prop('checked')== true) {
			
			// Get original width
			this_orig_width = orig_width_final.replace('px', '');
			// Get original height
			this_orig_height = orig_height_final.replace('px', '');
			// Get new input width
			this_new_width = $('#attributes-image-width').val();
			
			// Calculate percent between new width and old width
			get_percent_width = this_new_width / this_orig_width;
			// Multiply old height by percent
			this_new_height = this_orig_height * get_percent_width;
			
			// Populate new height
			$('#attributes-image-height').val((Math.round(this_new_height)));
		}
	});
	
	// If the image height input box gets blurred
	$('#attributes-image-height').on('keyup', function() {
		
		// Check if we are maintaining proportions
		if($('#maintain_proportions').prop('checked')== true) {
			
			// Get original height
			this_orig_height = orig_height_final.replace('px', '');
			// Get original width
			this_orig_width = orig_width_final.replace('px', '');
			// Get new input height
			this_new_height = $('#attributes-image-height').val();
			
			// Calculate percent between new height and old height
			get_percent_height = this_new_height / this_orig_height;
			// Multiply old width by percent
			this_new_width = this_orig_width * get_percent_height;
			
			// Populate new width
			$('#attributes-image-width').val((Math.round(this_new_width)));
		}
	});
	
	
	// Activate jQuery tabs
	$('#advimage_tabs').tabs();
	
	// Activate jQuery sliders
	$('#margin-top-slider, #margin-right-slider, #margin-bottom-slider, #margin-left-slider, #padding-top-slider, #padding-right-slider, #padding-bottom-slider, #padding-left-slider').slider({
		
		min: 0,
		max: 100,
		step: 1,
		slide: function(e, ui) {
			
			// Update value in input field
			$(this).parent().next().children('input').val(ui.value);
		}
	});
	
	// Activate color picker
	$('#border-picker').colpick({
		
		submit:false,
		onChange:function(hsb,hex,rgb,el,bySetColor) {
			
			$(el).css('border-color','#'+hex);
			// Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
			if(!bySetColor) $(el).val('#'+hex);
		}
	}).keyup(function(){
		
		$(this).colpickSetColor(this.value);
	});
	
	
	// Declare window variable
	var this_advimage_window = top.tinymce.activeEditor;
	var node = this_advimage_window.selection.getNode();
	var node_element = this_advimage_window.selection.getNode().nodeName;
	var parent_node_element = this_advimage_window.selection.getNode().parentNode.nodeName;
	
	// If this node is an image, get node margin and padding attributes
	if(node_element === 'IMG' || node_element == 'img') {
		
		// Get attributes from content editor and populate assocated options	
		this_margin_top = $(node).css('margin-top');
		this_margin_top_value = Math.round(this_margin_top.replace(/[^0-9]/g, ''));  // get numerical value from string
		
		this_margin_right = $(node).css('margin-right');
		this_margin_right_value = Math.round(this_margin_right.replace(/[^0-9]/g, ''));  // get numerical value from string
		
		this_margin_bottom = $(node).css('margin-bottom');
		this_margin_bottom_value = Math.round(this_margin_bottom.replace(/[^0-9]/g, ''));  // get numerical value from string
		
		this_margin_left = $(node).css('margin-left');
		this_margin_left_value = Math.round(this_margin_left.replace(/[^0-9]/g, ''));  // get numerical value from string
		
		
		this_padding_top = $(node).css('padding-top');
		this_padding_top_value = Math.round(this_padding_top.replace(/[^0-9]/g, ''));  // get numerical value from string
		
		this_padding_right = $(node).css('padding-right');
		this_padding_right_value = Math.round(this_padding_right.replace(/[^0-9]/g, ''));  // get numerical value from string
		
		this_padding_bottom = $(node).css('padding-bottom');
		this_padding_bottom_value = Math.round(this_padding_bottom.replace(/[^0-9]/g, ''));  // get numerical value from string
		
		this_padding_left = $(node).css('padding-left');
		this_padding_left_value = Math.round(this_padding_left.replace(/[^0-9]/g, ''));  // get numerical value from string
	}
	// Else set margin and padding attributes to '0'
	else {
		
		this_margin_top_value = '0';
		this_margin_right_value = '0';
		this_margin_bottom_value = '0';
		this_margin_left_value = '0';
		this_padding_top_value = '0';
		this_padding_right_value = '0';
		this_padding_bottom_value = '0';
		this_padding_left_value = '0';
	}
		
	
	this_border_value_number = Math.round($(node).css('border-left-width').replace(/[^0-9]/g, ''));
	this_border_value_style = $(node).css('border-left-style');
	this_border_picker = advimage_rgb2hex($(node).css('border-right-color'));  // filter rgb color to return hex value
	
	
	this_jscript_onclick = $(node).attr('onclick');
	this_jscript_ondblclick = $(node).attr('ondblclick');
	this_jscript_onkeydown = $(node).attr('onkeydown');
	this_jscript_onkeypress = $(node).attr('onkeypress');
	this_jscript_onkeyup = $(node).attr('onkeyup');
	this_jscript_onmousedown = $(node).attr('onmousedown');
	this_jscript_onmousemove = $(node).attr('onmousemove');
	this_jscript_onmouseout = $(node).attr('onmouseout');
	this_jscript_onmouseover = $(node).attr('onmouseover');
	this_jscript_onmouseup = $(node).attr('onmouseup');
	this_jscript_onmousewheel = $(node).attr('onmousewheel');
	
	
	var this_src = node.src;
	var this_id = $(node).attr('id');
	var this_class = $(node).attr('class');
	var this_title = $(node).attr('title');
	var this_alt = $(node).attr('alt');
	var this_width = $(node).attr('width');
	var this_height = $(node).attr('height');
	
	
	// Set overlay values from editor
	$('#margin-top-slider-value').val(this_margin_top_value);
	$('#margin-top-slider').slider('option', 'value', this_margin_top_value);
	
	$('#margin-right-slider-value').val(this_margin_right_value);
	$('#margin-right-slider').slider('option', 'value', this_margin_right_value);
	
	$('#margin-bottom-slider-value').val(this_margin_bottom_value);
	$('#margin-bottom-slider').slider('option', 'value', this_margin_bottom_value);
	
	$('#margin-left-slider-value').val(this_margin_left_value);
	$('#margin-left-slider').slider('option', 'value', this_margin_left_value);
		
	
	$('#padding-top-slider-value').val(this_padding_top_value);
	$('#padding-top-slider').slider('option', 'value', this_padding_top_value);
	
	$('#padding-right-slider-value').val(this_padding_right_value);
	$('#padding-right-slider').slider('option', 'value', this_padding_right_value);
	
	$('#padding-bottom-slider-value').val(this_padding_bottom_value);
	$('#padding-bottom-slider').slider('option', 'value', this_padding_bottom_value);
	
	$('#padding-left-slider-value').val(this_padding_left_value);
	$('#padding-left-slider').slider('option', 'value', this_padding_left_value);
		
		
	$('#border-value-number').val(this_border_value_number);
	$('#border-value-style').val(this_border_value_style);
	$('#border-picker').val(this_border_picker);
	$('#border-picker').colpickSetColor(this_border_picker, true)
		
	
	$('#attributes-image-source').val(this_src);
	$('#attributes-image-id').val(this_id);
	$('#attributes-image-class').val(this_class);
	$('#attributes-image-title').val(this_title);
	$('#attributes-image-alt').val(this_alt);
	$('#attributes-image-width').val(this_width);
	$('#attributes-image-height').val(this_height);
	
	
	$('#jscript-onclick').val(this_jscript_onclick);
	$('#jscript-ondblclick').val(this_jscript_ondblclick);
	$('#jscript-onkeydown').val(this_jscript_onkeydown);
	$('#jscript-onkeypress').val(this_jscript_onkeypress);
	$('#jscript-onkeyup').val(this_jscript_onkeyup);
	$('#jscript-onmousedown').val(this_jscript_onmousedown);
	$('#jscript-onmousemove').val(this_jscript_onmousemove);
	$('#jscript-onmouseout').val(this_jscript_onmouseout);
	$('#jscript-onmouseover').val(this_jscript_onmouseover);
	$('#jscript-onmouseup').val(this_jscript_onmouseup);
	$('#jscript-onmousewheel').val(this_jscript_onmousewheel);
	
	
	// Update slider value when input is manually entered
	$('.slider_value').on('blur', function() {
		
		// Get this value and remove id attribute to use in slider setter
		this_value = $(this).attr('id');
		selector = this_value.replace('-value', '');
		
		// Get value from input box
		this_input = $(this).val();
		
		// If value is not numerical
		if(!isFinite(String(this_input))) {
			
			$.alert({
				title: top.tinyMCE.activeEditor.getLang('wpep_langs.advimg_not_number_title'),
				content: top.tinyMCE.activeEditor.getLang('wpep_langs.advimg_not_number'),
				columnClass: 'col-md-4 col-md-offset-4',
				confirmButtonClass: 'btn-danger'
			});
				
			$(this).val('0');
			$('#'+selector).slider('option', 'value', 0);
		}
		else if(this_input > 100 || this_input < 0) {
			
			$.alert({
				title: top.tinyMCE.activeEditor.getLang('wpep_langs.advimg_not_number_title'),
				content: top.tinyMCE.activeEditor.getLang('wpep_langs.advimg_not_range'),
				columnClass: 'col-md-4 col-md-offset-4',
				confirmButtonClass: 'btn-danger'
			});
			
			$(this).val('0');
			$('#'+selector).slider('option', 'value', 0);
		}
		else {
		
			// Update slider
			$('#'+selector).slider('option', 'value', this_input);
		}
	});
	
	// Action buttons
	$('#advimage_cancel').click(function() {
		
		this_advimage_window.windowManager.close();
	});
	
	$('#advimage_insert').click(function() {
		
		margin_output = '';
		padding_output = '';
		border_output = '';
		attributes_output = '';
		events_output = '';
		
		// Get page variables
		margin_top_slider_value = $('#margin-top-slider-value').val();
		margin_right_slider_value = $('#margin-right-slider-value').val();
		margin_bottom_slider_value = $('#margin-bottom-slider-value').val();
		margin_left_slider_value = $('#margin-left-slider-value').val();
		
		padding_top_slider_value = $('#padding-top-slider-value').val();
		padding_right_slider_value = $('#padding-right-slider-value').val();
		padding_bottom_slider_value = $('#padding-bottom-slider-value').val();
		padding_left_slider_value = $('#padding-left-slider-value').val();
		
		border_value_number = $('#border-value-number').val();
		border_value_style = $('#border-value-style').val();
		border_picker = $('#border-picker').val();
		
		attributes_image_source = $('#attributes-image-source').val();
		attributes_image_id = $('#attributes-image-id').val();
		attributes_image_class = $('#attributes-image-class').val();
		attributes_image_title = $('#attributes-image-title').val();
		attributes_image_alt = $('#attributes-image-alt').val();
		attributes_image_width = $('#attributes-image-width').val();
		attributes_image_height = $('#attributes-image-height').val();
		
		events_jscript_onclick = $('#jscript-onclick').val();
		events_jscript_ondblclick = $('#jscript-ondblclick').val();
		events_jscript_onkeydown = $('#jscript-onkeydown').val();
		events_jscript_onkeypress = $('#jscript-onkeypress').val();
		events_jscript_onkeyup = $('#jscript-onkeyup').val();
		events_jscript_onmousedown = $('#jscript-onmousedown').val();
		events_jscript_onmousemove = $('#jscript-onmousemove').val();
		events_jscript_onmouseout = $('#jscript-onmouseout').val();
		events_jscript_onmouseover = $('#jscript-onmouseover').val();
		events_jscript_onmouseup = $('#jscript-onmouseup').val();
		events_jscript_onmousewheel = $('#jscript-onmousewheel').val();
		
		
		// Build margins
		margin_output += 'margin:' + margin_top_slider_value + 'px ' + margin_right_slider_value + 'px ' + margin_bottom_slider_value +  'px ' + margin_left_slider_value + 'px;';
		
		// Build paddings
		padding_output += 'padding:' + padding_top_slider_value + 'px ' + padding_right_slider_value + 'px ' + padding_bottom_slider_value + 'px ' + padding_left_slider_value + 'px;';
		
		// Build border
		if(border_value_number != '0') {
			border_output += 'border:' + border_value_number + 'px ' + border_value_style + ' ' + border_picker + ';';
		}
		
		// Build attributes
		if(attributes_image_source != '') {
			attributes_output += ' src="' + attributes_image_source + '"';
		}
		if(attributes_image_id != '') {
			attributes_output += ' id="' + attributes_image_id + '"';
		}
		if(attributes_image_class != '') {
			attributes_output += ' class="' + attributes_image_class + '"';
		}
		if(attributes_image_title != '') {
			attributes_output += ' title="' + attributes_image_title + '"';
		}
		if(attributes_image_alt != '') {
			attributes_output += ' alt="' + attributes_image_alt + '"';
		}
		if(attributes_image_width != '') {
			attributes_output += ' width="' + attributes_image_width + '"';
		}
		if(attributes_image_height != '') {
			attributes_output += ' height="' + attributes_image_height + '"';
		}
		
		// Build events
		if(events_jscript_onclick != '') {
				events_output += ' onclick="' + events_jscript_onclick + '"';
		}
		if(events_jscript_ondblclick != '') {
				events_output += ' ondblclick="' + events_jscript_ondblclick + '"';
		}
		if(events_jscript_onkeydown != '') {
				events_output += ' onkeydown="' + events_jscript_onkeydown + '"';
		}
		if(events_jscript_onkeypress != '') {
				events_output += ' onkeypress="' + events_jscript_onkeypress + '"';
		}
		if(events_jscript_onkeyup != '') {
				events_output += ' onkeyup="' + events_jscript_onkeyup + '"';
		}
		if(events_jscript_onmousedown != '') {
				events_output += ' onmousedown="' + events_jscript_onmousedown + '"';
		}
		if(events_jscript_onmousemove != '') {
				events_output += ' onmousemove="' + events_jscript_onmousemove + '"';
		}
		if(events_jscript_onmouseout != '') {
				events_output += ' onmouseout="' + events_jscript_onmouseout + '"';
		}
		if(events_jscript_onmouseover != '') {
				events_output += ' onmouseover="' + events_jscript_onmouseover + '"';
		}
		if(events_jscript_onmouseup != '') {
				events_output += ' onmouseup="' + events_jscript_onmouseup + '"';
		}
		if(events_jscript_onmousewheel != '') {
				events_output += ' onmousewheel="' + events_jscript_onmousewheel + '"';
		}
		
		
		// Check if parent node is an <a> element
		if(parent_node_element === 'A' || parent_node_element === 'a') {
			
			// Create new image element
			var newNode = this_advimage_window.getDoc().createElement('img');
			
			// Replace current image node with newNode
			node.parentNode.replaceChild(newNode, node);
			
			// Populate image attributes
			$(newNode).attr('src', attributes_image_source);
			$(newNode).attr('id', attributes_image_id);
			$(newNode).attr('class', attributes_image_class);
			$(newNode).attr('title', attributes_image_title);
			$(newNode).attr('alt', attributes_image_alt);
			$(newNode).attr('width', attributes_image_width);
			$(newNode).attr('height', attributes_image_height);
			$(newNode).attr('style', margin_output + padding_output + border_output);
			
			if(events_jscript_onclick != '') {
				$(newNode).attr('onclick', events_jscript_onclick);
			}
			if(events_jscript_ondblclick != '') {
				$(newNode).attr('ondblclick', events_jscript_ondblclick);
			}
			if(events_jscript_onkeydown != '') {
				$(newNode).attr('onkeydown', events_jscript_onkeydown);
			}
			if(events_jscript_onkeypress != '') {
				$(newNode).attr('onkeypress', events_jscript_onkeypress);
			}
			if(events_jscript_onkeyup != '') {
				$(newNode).attr('onkeyup', events_jscript_onkeyup);
			}
			if(events_jscript_onmousedown != '') {
				$(newNode).attr('onmousedown', events_jscript_onmousedown);
			}
			if(events_jscript_onmousemove != '') {
				$(newNode).attr('onmousemove', events_jscript_onmousemove);
			}
			if(events_jscript_onmouseout != '') {
				$(newNode).attr('onmouseout', events_jscript_onmouseout);
			}
			if(events_jscript_onmouseover != '') {
				$(newNode).attr('onmouseover', events_jscript_onmouseover);
			}
			if(events_jscript_onmouseup != '') {
				$(newNode).attr('onmouseup', events_jscript_onmouseup);
			}
			if(events_jscript_onmousewheel != '') {
				$(newNode).attr('onmousewheel', events_jscript_onmousewheel);
			}
		}
		// Else image is not wrapped in an <a> wrapper
		else {
			
			// Insert content into editor
			this_advimage_window.execCommand('mceReplaceContent', !1, '<img' + attributes_output + ' style="' + margin_output + padding_output + border_output + events_output + '" />');
		}
		
		// Close window
		this_advimage_window.windowManager.close(); 
	});
	
});


// Convert RGB to Hex color
function advimage_rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}