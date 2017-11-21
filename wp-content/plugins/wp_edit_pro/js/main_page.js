jQuery( document ).ready( function($) {
	
	/*
	****************************************************************
	Click function to update site blog id option to ''
	****************************************************************
	*/
	
	// If clicking an a tag
	$('a').click(function(e) {
		
		if( main_page_localize_vars.blog_id !== '' ) {  // Check if editing a subsite
		
			if( !$(this).closest("#wpbody-content").length ) {  // If outside content area
			
				e.preventDefault();
				
				$.alert({
					title: 'Leaving Page',
					content: 'Please cancel editing the subsite options before leaving the page.',
					columnClass: 'col-md-4 col-md-offset-4',
					confirmButtonClass: 'btn-danger'
				});
			}
		}
	});
	
	
	
	/*
	****************************************************************
	Functions for Buttons tab
	****************************************************************
	*/
	// Document click function to remove active button selection
	$(document).click(function(e) {
		
		if(!$(e.target).parents().hasClass('wpep_act_button_area')) {
			$('#inside_button_hover').children('div').children('div').removeClass('ui-state-active-button');
		}
	});
	
	$( "#created_editor_tabs" ).tabs();
	
	// Button tooltips
	$( ".sortable" ).tooltip({
		items: "div.draggable",
		hide: false
	});
	
	// Buttons draggable/sortable
	$("#toolbar1, #toolbar2, #toolbar3, #toolbar4, #tmce_container").sortable({
		revert: true,
		tolerance: 'pointer',
		cursor: 'move',
		opacity: 0.6,
		distance: 10,
		placeholder: "sortable_placeholder",
		connectWith: "#toolbar1, #toolbar2, #toolbar3, #toolbar4, #tmce_container",
		cursorAt: {
            right: 40,
            bottom: 40
        },
		helper: function(event, item) {
			
			if(!item.hasClass("ui-state-active-button")) {
				item.addClass("ui-state-active-button").siblings().removeClass("ui-state-active-button");
			}
			var helper = $('<div id="sortable_multiselect_container"><div class="sortable_multiselect"></div></div>');
			var selected = item.parent().parent().children().children(".ui-state-active-button");
			var cloned = selected.clone();
			helper.find("div.sortable_multiselect").append(cloned);
			selected.hide();
			
			item.data("multi-sortable", cloned);
			
			return helper;
		},
		start: function() {
		},
		stop: function(e, ui) {
			
			var cloned = ui.item.data("multi-sortable");
			ui.item.removeData("multi-sortable");
			
			ui.item.after(cloned);
			ui.item.parent().parent().children().children(":hidden").remove();
			ui.item.remove();
			
			// Get each sorted string
			sorted_tmce1 = $( "#toolbar1" ).sortable( "toArray" );
			sorted_tmce2 = $( "#toolbar2" ).sortable( "toArray" );
			sorted_tmce3 = $( "#toolbar3" ).sortable( "toArray" );
			sorted_tmce4 = $( "#toolbar4" ).sortable( "toArray" );
			sorted_tmce_cont = $( "#tmce_container" ).sortable( "toArray" );
			
			// Build huge string of all buttons and containers
			sorted_final = '*toolbar1:'+sorted_tmce1+'*toolbar2:'+sorted_tmce2+'*toolbar3:'+sorted_tmce3+'*toolbar4:'+sorted_tmce4+'*tmce_container:'+sorted_tmce_cont;
			
			// Populate hidden input field
			$('.get_sorted_array').val(sorted_final);
			
			// Remove active state from selection
			$(this).parent().children().children().removeClass("ui-state-active-button");
		}
	});
	
	// Populate hidden array div with default values
	sorted_tmce1 = $( "#toolbar1" ).sortable( "toArray" );
	sorted_tmce2 = $( "#toolbar2" ).sortable( "toArray" );
	sorted_tmce3 = $( "#toolbar3" ).sortable( "toArray" );
	sorted_tmce4 = $( "#toolbar4" ).sortable( "toArray" );
	sorted_tmce_cont = $( "#tmce_container" ).sortable( "toArray" );
	
	// Build huge string of all buttons and containers
	sorted_final = '*toolbar1:'+sorted_tmce1+'*toolbar2:'+sorted_tmce2+'*toolbar3:'+sorted_tmce3+'*toolbar4:'+sorted_tmce4+'*tmce_container:'+sorted_tmce_cont;
	
	// Populate hidden input field
	$('.get_sorted_array').val(sorted_final);
	
	
	// Toggle button active class
	$(document).on('click', '.draggable', function() {
		$(this).toggleClass('ui-state-active-button');
	});
	
	// Get tooltip data from html data attribute
	$(document).on('mouseover', 'div.draggable', function() {
		
		get_data = $(this).context.getAttribute('data-tooltip');
		
		if(get_data)
			$( ".sortable" ).tooltip( "option", "content", get_data );
	});
	
	// Buttons help tabs
	$('#button_help_tabs').tabs();
	
	// Sortable capabilities array
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
	$('#sort_capabilities tbody').sortable({
		helper: fixHelper,
		stop: function(e, ui) {
			
			// Get each sorted string
			sorted_caps = $('#sort_capabilities tbody').sortable('toArray');
			
			// Populate hidden input field
			$('#wpep_submit_caps_sort_array').val(sorted_caps);
		}
	}).disableSelection();
	
	
	
	/*
	****************************************************************
	Functions for Advanced Configuration
	****************************************************************
	*/
	var wpep_tmce_defaults = [];

	$('td.names', '#wpep_showhide_tmce_table').each(function(n, el){
		
		wpep_tmce_defaults.push( $(el).text() );
	});

	$('td.names', '#wpep_adv_cfg_set').each(function(n, el){
		
		var text = $('input', el).val();

		if ( text && $.inArray(text, wpep_tmce_defaults) > -1 ) {
			
			$(el).parent().addClass('wpep_config_hilite');
			$('td.names:contains("' + text + '")', '#wpep_showhide_tmce_table').parent().addClass('wpep_config_hilite');
		}
	});
	
	// Show/hide default tmce values
	$('#wpep_show_tmce_button, #wpep_hide_tmce_button').click(function() {
		
		$('#wpep_showhide_tmce_table, #wpep_show_tmce_button, #wpep_hide_tmce_button').toggle();
	});
	
	// Hover change for each default row
	$('.wpep_tmce_change_button').hover(function() {
		
		$(this).parent().parent().parent().toggleClass('change_button_hover');
	});
	
	// "Change" original values button clicks
	$('.wpep_tmce_change_button').click(function() {
		
		// Get this rows id (used for incremental counting)
		this_id = $(this).parent().parent().parent().children().first().attr('id');
		// String replace to get just the number
		this_id = this_id.replace('n', '');
		
		// Populate editable fields with corresponding values
		$('#wpep_tmce_new_name').val( $('#n'+this_id).text() );
		$('#wpep_tmce_new_val').val( $('#v'+this_id).text() );
		
		// Scroll to bottom of page
		$("html, body").animate({ scrollTop: $(document).height() }, 500);
		
		// Highlight custom entry
		setTimeout(function() {
			  $(".wpep_new_values").flash('#A8F2F7', 1500);
		}, 500);
	});
	
	// "Remove" custom entry button clicks
	$('.wpep_tmce_remove_button').click(function() {
		
		// Get this rows name field
		this_field = $(this).parent().parent().children().first().children().first().attr('value');
		
		// Clear corresponding name and value options
		$('#'+this_field).val('');
		$('#wpep_tmce_option_field-'+this_field).val('');
		
		// Remove row highlight
		$(this).parent().parent().removeClass('wpep_config_hilite');
	});
	
	// Highlight helper function
	$.fn.flash = function (color, duration) {
		
		var current = this.css('backgroundColor');
		this.animate({ backgroundColor: 'rgb(' + color + ')' }, duration / 2)
		.animate({ backgroundColor: current }, duration / 2);
	}
	
	
	
	/*
	****************************************************************
	Functions for Posts tab
	****************************************************************
	*/
	
	// Ace editor for styles and scripts
	if( main_page_localize_vars.active_tab == 'posts' ) {
		
		// Styles editor
		var editor_styles = ace.edit("wpep_styles_editor");
		editor_styles.$blockScrolling = Infinity;  // Disable console scrolling message
		editor_styles.getSession().setMode("ace/mode/css");
		editor_styles.getSession().setUseWrapMode( true );
		editor_styles.setShowPrintMargin( false );
		editor_styles.getSession().setValue( $( '#wpep_styles_editor_textarea' ).val() );
		editor_styles.session.setOption("useWorker", false);  // disable syntax checking
		
		// Scripts editor
		var editor_scripts = ace.edit("wpep_scripts_editor");
		editor_scripts.$blockScrolling = Infinity;  // Disable console scrolling message
		editor_scripts.getSession().setMode("ace/mode/javascript");
		editor_scripts.getSession().setUseWrapMode( true );
		editor_scripts.setShowPrintMargin( false );
		editor_scripts.getSession().setValue( $( '#wpep_scripts_editor_textarea' ).val() );
		editor_scripts.session.setOption("useWorker", false);  // disable syntax checking
		
		// Click function for populating hidden textarea with styles and scripts
		$( '#submit_posts' ).click( function() {
			
			$( '#wpep_styles_editor_textarea' ).val( editor_styles.getSession().getValue() );
			$( '#wpep_scripts_editor_textarea' ).val( editor_scripts.getSession().getValue() );
		});
	}
	
	
	
	/*
	****************************************************************
	Functions for Editor tab
	****************************************************************
	*/
	
	// Repeater fields
	$('#custom_color_add_new_row').click(function(e) {
		
		// Check how many fields exist
		get_row_num = $('.editor_custom_colors').length;
		length = (get_row_num / 2) + 1;
		
		append_new_field = '<strong>Hex Value:</strong> <input type="text" class="editor_custom_colors" name="editor_custom_colors['+length+'][]" value="" style="margin-right:20px;" /> ';
		append_new_field += '<strong>Color Name:</strong> <input type="text" class="editor_custom_colors" name="editor_custom_colors['+length+'][]" value="" style="margin-right:20px;" /><br />';
		
		$('.custom_color_repeater_fields').append(append_new_field);
	})
	
	
	
	/*
	****************************************************************
	Functions for Fonts tab
	****************************************************************
	*/
	
	// Google webfonts
	$('#google_dropdown').change(function(){
		
		// Get selected font value
		click_val = $(this).val();
		
		if( click_val == '' ) 
			return false;
		
		// Get current list object
		cur_list = $('#google_fonts_placeholder ul').html();
		
		// Get number of active icons
		cur_list_count = $('#google_fonts_placeholder ul li').length;
		
		// If attempting to add a fifth font; alert user of potential increase in page loading time
		if(cur_list_count == '4') {
				
			$.alert({
				title: 'Google Fonts Suggestion',
				content: 'It is recommended to keep between 3 and 5 fonts; because of their affect on page load speed.<br /><br />It is okay to use more; but each one is additional content which has to be downloaded before the page displays.<br /><br />Keep using more (if desired); and check the page load speed.  If the affect is neglible, then keep the desired fonts.',
				columnClass: 'col-md-4 col-md-offset-4',
				confirmButtonClass: 'btn-info'
			});
		}
		
		// If current list is empty
		if(cur_list == '') {
			
			$('#google_fonts_placeholder ul').append('<li class="active_font"><input type="hidden" name="save_google_fonts[]" value="'+click_val+'" />'+click_val+'</li>').hide().fadeIn(500);
		}
		else {
			
			var items = [];
			$(cur_list).each(function() { items.push($(this).text()) });
			
			// Compare select to container array
			if($.inArray(click_val,items) == -1){
				
				// the element is not in the array
				$('#google_fonts_placeholder ul').append('<li class="active_font"><input type="hidden" name="save_google_fonts[]" value="'+click_val+'" />'+click_val+'</li>').hide().fadeIn(1000);
			}
			else {
				
				$.alert({
					title: 'Font Already Active',
					content: 'This font is already active in the "Active Fonts" container.',
					columnClass: 'col-md-4 col-md-offset-4',
					confirmButtonClass: 'btn-info'
				});
			}
		}
		
		// Must re-call after dom elements are added
		$( "#google_fonts_placeholder ul li" ).draggable({ revert: true });
	});
	
	$( "#google_fonts_placeholder ul li" ).draggable({ revert: true });
	
	$( "#trash_bin_wrapper" ).droppable({
		
		hoverClass: "ui-state-active",
		drop: function( event, ui ) {
			$(ui.draggable).fadeOut(500);
			setTimeout(function() {
				  $(ui.draggable).remove();
			}, 500);
		}
    });
	
	// CUSTOM FONTS
	// Function at bottom of this page for file upload
	
	// Check file extensions
	$('#submit_fonts_custom').click(function(e) {
		
		// Loop each li element and check extension
		elements = $('ul#fileList li input');
		flag = false;
		
		$.each(elements, function(i, v) {
			
			// Get filename
			filename = $(v).val();
			// Split to get extension
			file_split = filename.split('.');
			extension = file_split[1];
			
			// If this font does not have a valid extension
			arr = ['eot', 'svg', 'ttf', 'woff', 'woff2'];
			if($.inArray(extension, arr) == -1) {
				
				flag = true;
			}
		});
		
		if(flag == true) {
			
			e.preventDefault();
			
			$.alert({
				title: 'Invalid File Type',
				content: 'One of the file extensions is not a valid type. Please go back and select files with proper file extensions.',
				columnClass: 'col-md-4 col-md-offset-4',
				confirmButtonClass: 'btn-danger'
			});
			return false;
		}
	});
	
	// Delete custom font
	$('.delete_custom_font').click(function() {
		
		var $this = $(this);
		
		$.confirm({
			title: 'Delete Custom Font',
			content: 'Delete this custom font?',
			columnClass: 'col-md-4 col-md-offset-4',
			confirmButtonClass: 'btn-info',
			cancelButtonClass: 'btn-danger',
			cancelButton: 'Cancel',
			confirmButton: 'Delete Font',
			confirm: function(){
				
				// Get font name
				font_name = $($this).parent().prev().prev().html();
				
				var data = {
					action: 'wp_edit_pro_custom_fonts_delete_row',
					font_name: font_name
				};
			
				$.post(ajaxurl, data, function(response) {
					
					if(response == 'success') {
						
						$.alert({
							title: 'Font Deleted',
							content: 'The font has been successfully deleted.',
							columnClass: 'col-md-4 col-md-offset-4',
							confirmButtonClass: 'btn-info'
						});
				
						// Remove tr element
						$($this).parent().parent().fadeOut('slow');
					}
					else {
						
						$.alert({
							title: 'Error Deleting File',
							content: 'An error was encountered while deleting this custom font. Please contact us for assistance.',
							columnClass: 'col-md-4 col-md-offset-4',
							confirmButtonClass: 'btn-danger'
						});
					}
				});
			}
		});
	});
	
	
	/*
	****************************************************************
	Functions for Styles tab
	****************************************************************
	*/
	// Populate radio values based on TYPE selection
	$('.create_style_type').change(function() {
		
		if($(this).val() == 'inline') {
			
			radios_inline = '<input id="create_style_element_span" type="radio" name="create_style_element" value="span" />span ';
			radios_inline += '<input id="create_style_element_b" type="radio" name="create_style_element" value="b" />b ';
			radios_inline += '<input id="create_style_element_i" type="radio" name="create_style_element" value="i" />i ';
			radios_inline += '<input id="create_style_element_strong" type="radio" name="create_style_element" value="strong" />strong ';
			radios_inline += '<input id="create_style_element_button" type="radio" name="create_style_element" value="button" />button ';
			radios_inline += '<input id="create_style_element_code" type="radio" name="create_style_element" value="code" />code ';
			radios_inline += '<input id="create_style_element_img" type="radio" name="create_style_element" value="img" />img ';
			
			$('#type_element').html(radios_inline);
			
			// Enable wrapper option
			$('#create_style_wrapper_false').removeAttr('disabled');
			$('#create_style_wrapper_true').removeAttr('disabled');
		}
		else if($(this).val() == 'block') {
			
			radios_block = '<input id="create_style_element_div" type="radio" name="create_style_element" value="div" />div ';
			radios_block += '<input id="create_style_element_blockquote" type="radio" name="create_style_element" value="blockquote" />blockquote ';
			radios_block += '<input id="create_style_element_h1" type="radio" name="create_style_element" value="h1" />h1 ';
			radios_block += '<input id="create_style_element_h2" type="radio" name="create_style_element" value="h2" />h2 ';
			radios_block += '<input id="create_style_element_h3" type="radio" name="create_style_element" value="h3" />h3 ';
			radios_block += '<input id="create_style_element_h4" type="radio" name="create_style_element" value="h4" />h4 ';
			radios_block += '<input id="create_style_element_h5" type="radio" name="create_style_element" value="h5" />h5 ';
			radios_block += '<input id="create_style_element_h6" type="radio" name="create_style_element" value="h6" />h6 ';
			radios_block += '<input id="create_style_element_p" type="radio" name="create_style_element" value="p" />p ';
			radios_block += '<input id="create_style_element_pre" type="radio" name="create_style_element" value="pre" />pre ';
			radios_block += '<input id="create_style_element_ol" type="radio" name="create_style_element" value="ol" />ol ';
			radios_block += '<input id="create_style_element_ul" type="radio" name="create_style_element" value="ul" />ul ';
			radios_block += '<input id="create_style_element_table" type="radio" name="create_style_element" value="table" />table ';
			
			$('#type_element').html(radios_block);
			
			// Disable wrapper option
			$('#create_style_wrapper_false').attr('disabled', 'disabled');
			$('#create_style_wrapper_true').attr('disabled', 'disabled');
		}
		else {
			
			input_selector = '<input id="create_style_element_text" type="text" name="create_style_element" value="" /> ';
			$('#type_element').html(input_selector);
			
			// Enable wrapper option
			$('#create_style_wrapper_false').removeAttr('disabled');
			$('#create_style_wrapper_true').removeAttr('disabled');
		}
	});
	
	// Clear form data
	$('#clear_form').click(function() {
		
		$.confirm({
			title: 'Reset form',
			content: 'Clear the custom style form?',
			columnClass: 'col-md-4 col-md-offset-4',
			confirmButtonClass: 'btn-info',
			cancelButtonClass: 'btn-danger',
			cancelButton: 'Cancel',
			confirmButton: 'Clear Form',
			confirm: function(){
				
				// Title
				$('#create_style_title').val('');
				// Type
				$('input[name="create_style_type"]').prop("checked", false);
				// Element 
				$('input[name="create_style_element"]').prop("checked", false);
				$('#type_element').html('');
				// Classes
				$('#create_style_classes').val('');
				// Styles
				$('#create_style_styles').val('');
				// Wrapper
				$('input[name="create_style_wrapper"]').prop("checked", false);
			}
		});
	});
	
	// Check title value to see if already exists
	$('#create_style_title').blur(function() {
		
		// Get input value
		var orig_val = $(this).val();
		
		
		$('table#saved_user_styles > tbody > tr').each(function() {
			
			existing_title = $(this).children('td:first').html();
			
			if(orig_val == existing_title) {
				
				$.alert({
					title: 'Existing Title',
					content: 'This Title already exists as a custom style. Please enter a new Title.',
					columnClass: 'col-md-4 col-md-offset-4',
					confirmButtonClass: 'btn-danger'
				});
				
				$('#create_style_title').val('');
			}
		});
	});
	
	// Click function for editing an already created style
	$('.edit_style').click(function() {
		
		// Get values from data table
		title_value = ($(this).closest('td').siblings().eq(0).text());
		type_value = ($(this).closest('td').siblings().eq(1).text());
		element_value = ($(this).closest('td').siblings().eq(2).text());
		classes_value = ($(this).closest('td').siblings().eq(3).text());
		styles_value = ($(this).closest('td').siblings().eq(4).text());
		wrapper_value = ($(this).closest('td').siblings().eq(5).text());
		
		// Populate values back into page form
		// Title
		$('#create_style_title').val(title_value);
		
		// Type
		if(type_value == '') {
			$('input[name="create_style_type"]').prop("checked", false);
		}
		else {
			$('#create_style_type_'+type_value).prop("checked", true);
		}
		
		// Element
		if(type_value == 'inline') {
			
			radios_inline = '<input id="create_style_element_span" type="radio" name="create_style_element" value="span" />span ';
			radios_inline += '<input id="create_style_element_b" type="radio" name="create_style_element" value="b" />b ';
			radios_inline += '<input id="create_style_element_i" type="radio" name="create_style_element" value="i" />i ';
			radios_inline += '<input id="create_style_element_strong" type="radio" name="create_style_element" value="strong" />strong ';
			radios_inline += '<input id="create_style_element_button" type="radio" name="create_style_element" value="button" />button ';
			radios_inline += '<input id="create_style_element_code" type="radio" name="create_style_element" value="code" />code ';
			radios_inline += '<input id="create_style_element_img" type="radio" name="create_style_element" value="img" />img ';
			$('#type_element').html(radios_inline);
			
			$('#create_style_element_'+element_value).prop("checked", true)
		}
		else if(type_value == 'block') {
			
			radios_block = '<input id="create_style_element_div" type="radio" name="create_style_element" value="div" />div ';
			radios_block += '<input id="create_style_element_blockquote" type="radio" name="create_style_element" value="blockquote" />blockquote ';
			radios_block += '<input id="create_style_element_h1" type="radio" name="create_style_element" value="h1" />h1 ';
			radios_block += '<input id="create_style_element_h2" type="radio" name="create_style_element" value="h2" />h2 ';
			radios_block += '<input id="create_style_element_h3" type="radio" name="create_style_element" value="h3" />h3 ';
			radios_block += '<input id="create_style_element_h4" type="radio" name="create_style_element" value="h4" />h4 ';
			radios_block += '<input id="create_style_element_h5" type="radio" name="create_style_element" value="h5" />h5 ';
			radios_block += '<input id="create_style_element_h6" type="radio" name="create_style_element" value="h6" />h6 ';
			radios_block += '<input id="create_style_element_p" type="radio" name="create_style_element" value="p" />p ';
			radios_block += '<input id="create_style_element_pre" type="radio" name="create_style_element" value="pre" />pre ';
			radios_block += '<input id="create_style_element_ol" type="radio" name="create_style_element" value="ol" />ol ';
			radios_block += '<input id="create_style_element_ul" type="radio" name="create_style_element" value="ul" />ul ';
			radios_block += '<input id="create_style_element_table" type="radio" name="create_style_element" value="table" />table ';
			$('#type_element').html(radios_block);
			
			$('#create_style_element_'+element_value).prop("checked", true)
		}
		else if(type_value == 'selector') {
			
			input_selector = '<input id="create_style_element_text" type="text" name="create_style_element" value="" /> ';
			$('#type_element').html(input_selector);
			
			$('#create_style_element_text').val(element_value);
		}
		else {
			
			$('input[name="create_style_element"]').prop("checked", false);
		}
		
		// Classes
		$('#create_style_classes').val(classes_value);
		
		// Styles
		$('#create_style_styles').val(styles_value);
		
		// Wrapper
		if(wrapper_value == '') {
			$('input[name="create_style_wrapper"]').prop("checked", false);
		}
		else {
			$('#create_style_wrapper_'+wrapper_value).prop("checked", true)
		}
		
		// Scroll to section
		$('body').animate(
			{scrollTop: $("#custom_styles_header").offset().top}, 
			1000, 
			function() {
				
				// Complete
				$("#float_table_left").effect("highlight", {color:'#84F252'}, 1000);
			}
		);
	});
	
	// Delete row data
	$('.delete_style').click(function() {
		
		$(this).closest('td').siblings().css('background-color', '#FFDFDF');
		delete_title = ($(this).closest('td').siblings().eq(0).text());
		var $this = $(this);
		
		$.confirm({
			title: 'Confirm Deletion',
			content: 'The <strong>'+delete_title+'</strong> custom style will be permanently deleted. Continue?',
			columnClass: 'col-md-4 col-md-offset-4',
			confirmButtonClass: 'btn-info',
			cancelButtonClass: 'btn-danger',
			cancelButton: 'Cancel',
			confirmButton: 'Delete Style',
			cancel: function() {
				
				$this.closest('td').siblings().css('background-color', '#FFFFFF');
			},
			confirm: function(){
				
				// Run db ajax request
				var data = {
					action: 'wp_edit_pro_custom_styles_delete_row',
					title: delete_title
				};
			
				$.post(ajaxurl, data, function(response) {
					
					if(response.result == 'success') {
						
						$.alert({
							title: 'Style Deleted',
							content: 'The Style has been successfully deleted.',
							columnClass: 'col-md-4 col-md-offset-4',
							confirmButtonClass: 'btn-info'
						});
						
						// Remove row data
						$this.parent().parent().fadeOut('slow', function() {
							
							$this.remove();
						});
					}
					else if(response.result == 'ajax_error') {
						
						$.alert({
							title: 'No Style Found',
							content: 'No style found to delete; or, there is an issue with WordPress Ajax.',
							columnClass: 'col-md-4 col-md-offset-4',
							confirmButtonClass: 'btn-danger'
						});
					}
				});
			}
		});
	});
	
	// Grab form submission... and validate fields
	$('#save_custom_style').click(function(e) {
		
		e.preventDefault();
		
		// Valide title field
		if($('#create_style_title').val() == '') {
			
			$.alert({
				title: 'Empty Title Field',
				content: 'Please enter a Title.',
				columnClass: 'col-md-4 col-md-offset-4',
				confirmButtonClass: 'btn-danger'
			});
			return;
		}
		
		// Validate type field
		if(!$('input[name="create_style_type"]:checked').val()) {
			
			$.alert({
				title: 'Empty Type Field',
				content: 'Please select a valid Type.',
				columnClass: 'col-md-4 col-md-offset-4',
				confirmButtonClass: 'btn-danger'
			});
			return;
		}
		
		// Validate element field
		if($('input[name="create_style_type"]:checked').val() == 'inline' || $('input[name="create_style_type"]:checked').val() == 'block') {
		
			if(!$('input[name="create_style_element"]:checked').val()) {
				
				$.alert({
					title: 'Empty Element Selection',
					content: 'Please select a valid Element.',
					columnClass: 'col-md-4 col-md-offset-4',
					confirmButtonClass: 'btn-danger'
				});
				return;
			}
		}
		else {
			
			if($('input[name="create_style_element"]').val() == '') {
				
				$.alert({
					title: 'Empty Element Selection',
					content: 'Please select a valid Element.',
					columnClass: 'col-md-4 col-md-offset-4',
					confirmButtonClass: 'btn-danger'
				});
				return;
			}
		}
		
		// Submit Form
		$('#hidden_save_style_submit').click();
	});
	
	
	
	/*
	****************************************************************
	Functions for Snidgets tab
	****************************************************************
	*/
	// Show snidgets table when activated
	if ($('#widget_builder').is(':checked')) {
		
		$('#snidgets_active_message_table').attr('style', 'display:block;');
		$('#snidgets_deactivated_message').attr('style', 'display:none;');
	}
	else {
		
		$('#snidgets_deactivated_message').attr('style', 'display:block;');
		$('#snidgets_active_message_table').attr('style', 'display:none;');
	}
	
	// If network activated; and editing subsite options
	if( main_page_localize_vars.network_activated == 'true' && main_page_localize_vars.blog_id !== '' ) {
		
		$('#submit_all_widgets_helper, #submit_new_widget_helper, #submit_widget_categories_helper, #submit_widget_tags_helper').click(function(e) {
			
			e.preventDefault();
			var this_object = $(this);
			var this_id = $(this).attr('id');
			
			$.confirm({
				title: 'Proceed to Subsite',
				content: 'You will be redirected to the subsite admin panel. It is VERY important to come back to this network page, and cancel editing the subsite options.',
				columnClass: 'col-md-4 col-md-offset-4',
				confirmButtonClass: 'btn-info',
				cancelButtonClass: 'btn-danger',
				cancelButton: 'Cancel',
				confirmButton: 'Proceed',
				confirm: function(){
					
					if( this_id == 'submit_all_widgets_helper' )
						$(this_object).next('#submit_all_widgets').click();
					
					if( this_id == 'submit_new_widget_helper' )
						$(this_object).next('#submit_new_widget').click();
					
					if( this_id == 'submit_widget_categories_helper' )
						$(this_object).next('#submit_widget_categories').click();
					
					if( this_id == 'submit_widget_tags_helper' )
						$(this_object).next('#submit_widget_tags').click();
				}
			});
		});
	}
	
	
	
	/*
	****************************************************************
	Functions for Extras tab
	****************************************************************
	*/
	// Color picker fields
	$('.color_field').wpColorPicker();
	
	
	
	/*
	****************************************************************
	Functions for Database tab
	****************************************************************
	*/
	
	// Reset plugin options
	$('#reset_db_values_helper').click(function(e) {
		
		e.preventDefault();
		
		$.confirm({
			title: 'Reset Plugin Options?',
			content: 'This will reset all plugin options to their original default values.  This action is irreversable.',
			columnClass: 'col-md-4 col-md-offset-4',
			confirmButtonClass: 'btn-info',
			cancelButtonClass: 'btn-danger',
			cancelButton: 'Cancel',
			confirmButton: 'Reset Options',
			confirm: function(){
				
				$('#reset_db_values').click();
			}
		});
	});
	
	// Convert plugin options
	$('#convert_db_values_helper').click(function(e) {
		
		e.preventDefault();
		
		$.confirm({
			title: 'Convert Plugin Options?',
			content: 'This feature will convert the options from WP Edit to WP Edit Pro.',
			columnClass: 'col-md-4 col-md-offset-4',
			confirmButtonClass: 'btn-info',
			cancelButtonClass: 'btn-danger',
			cancelButton: 'Cancel',
			confirmButton: 'Convert Options',
			confirm: function(){
				
				$('#convert_db_values').click();
			}
		});
	});
	
	
	
	/*
	****************************************************************
	Functions for About tab
	****************************************************************
	*/
	
	// Add html version to 'About' tab
	$('.wpep_html_version').html(getHtmlVer());
	
	function getHtmlVer(){
	
		var CName  = navigator.appCodeName;
		var UAgent = navigator.userAgent;
		var HtmlVer= 0.0;
		
		// Remove start of string in UAgent upto CName or end of string if not found.
		UAgent = UAgent.substring((UAgent+CName).toLowerCase().indexOf(CName.toLowerCase()));
		
		// Remove CName from start of string. (Eg. '/5.0 (Windows; U...)
		UAgent = UAgent.substring(CName.length);
		
		// Remove any spaves or '/' from start of string.
		while(UAgent.substring(0,1)==" " || UAgent.substring(0,1)=="/") {
			UAgent = UAgent.substring(1);
		}
		
		// Remove the end of the string from first characrer that is not a number or point etc.
		var pointer = 0;
		while("0123456789.+-".indexOf((UAgent+"?").substring(pointer,pointer+1))>=0) {
			pointer = pointer+1;
		}
		UAgent = UAgent.substring(0,pointer);
		
		if(!isNaN(UAgent)) {
			if(UAgent>0) {
				HtmlVer=UAgent;
			}
		}
		return HtmlVer;
	}
});



// Custom fonts create file list
function makeFileList() {
		
	var input = document.getElementById("filesToUpload");
	var ul = document.getElementById("fileList");
	while (ul.hasChildNodes()) {
		ul.removeChild(ul.firstChild);
	}
	for (var i = 0; i < input.files.length; i++) {
		var li = document.createElement("li");
		li.innerHTML = input.files[i].name + '<input type="hidden" name="save_custom_fonts[' + input.files[i].name + ']" value="' + input.files[i].name + '" />';
		li.className = 'fileListLi';
		ul.appendChild(li);
	}
	if(!ul.hasChildNodes()) {
		var li = document.createElement("li");
		li.innerHTML = 'No Files Selected';
		ul.appendChild(li);
	}
}


/*
****************************************************************
Initialize ACE on tinymce css editor
****************************************************************
*/
if( main_page_localize_vars.active_tab == 'styles' ) {
	
	( function( global, $ ) {
		var editor,
			syncCSS = function() {
				$( '#custom_css_textarea' ).val( editor.getSession().getValue() );
			},
			loadAce = function() {
				editor = ace.edit( 'custom_css' );
				editor.$blockScrolling = Infinity;  // Disable console scrolling message
				global.safecss_editor = editor;
				editor.getSession().setUseWrapMode( true );
				editor.setShowPrintMargin( false );
				editor.getSession().setValue( $( '#custom_css_textarea' ).val() );
				editor.getSession().setMode( "ace/mode/css" );  // set mode to css
				editor.session.setOption("useWorker", false);  // disable syntax checking
				jQuery.fn.spin&&$( '#custom_css_container' ).spin( false );
				$( '#save_custom_css_textarea' ).click( syncCSS );
			};
		$( global ).load( loadAce );
		global.aceSyncCSS = syncCSS;
	} )( this, jQuery );
}
