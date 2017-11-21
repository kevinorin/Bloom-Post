<?php

$no_tooltips = false;
if(isset($plugin_opts['wp_edit_pro_global']['disable_buttons_fancy_tooltips']) && $plugin_opts['wp_edit_pro_global']['disable_buttons_fancy_tooltips'] === '1') { $no_tooltips = true; }

// Ensure buttons will appear in button container... else alert user to convert or reset plugin options
if(!empty($show_buttons)) {
	
	// Loop all buttons and create sortable divs
	foreach ($show_buttons as $toolbar => $icons) {
		
		if($toolbar === 'tmce_container') {
			?><h3><?php _e('Button Container', 'wp_edit_pro'); ?></h3><?php
		}
	
		echo '<div id="'.$toolbar.'" class="ui-state-default sortable">';
			
			// Create array of icons
			if(!empty($icons)) {
				$icons = explode(' ', $icons);
			}
			
			// Loop icons (if is array)
			if(is_array($icons)) {
				foreach ($icons as $icon) {
	
					$class = ''; $title = ''; $text = ''; $style = ''; $tooltip = array('title' => '', 'content' => '');
																			
					// WP Buttons included by default
					if($icon === 'bold') { 
						$class = 'dashicons dashicons-editor-bold'; 
						$title = __('Bold', 'wp_edit_pro'); 
						$tooltip['title'] = __('Bold', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Apply <strong>bold</strong> to editor text.</p>', 'wp_edit_pro');
					}
					if($icon === 'italic') { 
						$class = 'dashicons dashicons-editor-italic'; 
						$title = __('Italic', 'wp_edit_pro'); 
						$tooltip['title'] = __('Italic', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Apply <em>italic</em> to editor text.</p>', 'wp_edit_pro');
					}
					if($icon === 'strikethrough') { 
						$class = 'dashicons dashicons-editor-strikethrough'; 
						$title = __('Strikethrough', 'wp_edit_pro'); 
						$tooltip['title'] = __('Strikethrough', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Apply <strike>strikethrough</strike> to editor text.</p>', 'wp_edit_pro');
					}
					if($icon === 'bullist') { 
						$class = 'dashicons dashicons-editor-ul'; 
						$title = __('Bullet List', 'wp_edit_pro'); 
						$tooltip['title'] = __('Bullet List', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Create a list of bulleted items.</p>', 'wp_edit_pro'); 
					}
					if($icon === 'numlist') { 
						$class = 'dashicons dashicons-editor-ol'; 
						$title = __('Numbered List', 'wp_edit_pro');
						$tooltip['title'] = __('Numbered List', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Create a list of numbered items.</p>', 'wp_edit_pro');
					}
					if($icon === 'blockquote') { 
						$class = 'dashicons dashicons-editor-quote'; 
						$title = __('Blockquote', 'wp_edit_pro');
						$tooltip['title'] = __('Blockquote', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Insert a block level quotation.</p>', 'wp_edit_pro');
					}
					if($icon === 'hr') { 
						$class = 'dashicons dashicons-minus'; 
						$title = __('Horizontal Rule', 'wp_edit_pro');
						$tooltip['title'] = __('Horizontal Rule', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Insert a horizontal rule.</p>', 'wp_edit_pro');
					}
					if($icon === 'alignleft') { 
						$class = 'dashicons dashicons-editor-alignleft'; 
						$title = __('Align Left', 'wp_edit_pro');
						$tooltip['title'] = __('Align Left', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Align editor content to the left side of the editor.</p>', 'wp_edit_pro');
					}
					if($icon === 'aligncenter') { 
						$class = 'dashicons dashicons-editor-aligncenter'; 
						$title = __('Align Center', 'wp_edit_pro');
						$tooltip['title'] = __('Align Center', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Align editor content to the center of the editor.</p>', 'wp_edit_pro');
					}
					if($icon === 'alignright') { 
						$class = 'dashicons dashicons-editor-alignright'; 
						$title = __('Align Right', 'wp_edit_pro');
						$tooltip['title'] = __('Align Right', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Align editor content to the right side of the editor.</p>', 'wp_edit_pro');
					}
					if($icon === 'link') { 
						$class = 'dashicons dashicons-admin-links'; 
						$title = __('Link', 'wp_edit_pro');
						$tooltip['title'] = __('Link', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Insert a link around currently selected content.</p>', 'wp_edit_pro');
					}
					if($icon === 'unlink') { 
						$class = 'dashicons dashicons-editor-unlink'; 
						$title = __('Unlink', 'wp_edit_pro');
						$tooltip['title'] = __('Unlink', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Remove the link around currently selected content.</p>', 'wp_edit_pro');
					}
					if($icon === 'wp_more') { 
						$class = 'dashicons dashicons-editor-insertmore'; 
						$title = __('More', 'wp_edit_pro');
						$tooltip['title'] = __('More', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Inserts the read_more() WordPress function; commonly used for excerpts.</p>', 'wp_edit_pro');
					}
					
					if($icon === 'formatselect') { 
						$title = 'Format Select';
						$text = __('Paragraph', 'wp_edit_pro');
						$tooltip['title'] = __('Paragraph', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Adds the Format Select dropdown button; used to select different styles.</p>', 'wp_edit_pro');
					}
					if($icon === 'underline') { 
						$class = 'dashicons dashicons-editor-underline';
						$title = __('Underline', 'wp_edit_pro');
						$tooltip['title'] = __('Underline', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Apply <u>underline</u> to editor text.</p>', 'wp_edit_pro');
					}
					if($icon === 'alignjustify') { 
						$class = 'dashicons dashicons-editor-justify';
						$title = __('Align Full', 'wp_edit_pro');
						$tooltip['title'] = __('Align Full', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Align selected content to full width of the page.</p>', 'wp_edit_pro');
					}
					if($icon === 'forecolor') { 
						$class = 'dashicons dashicons-editor-textcolor';
						$title = __('Foreground Color', 'wp_edit_pro');
						$tooltip['title'] = __('Foreground Color', 'wp_edit_pro');
						$tooltip['content'] = __('<p>Change the foreground color of selected content; commonly used to change text color.</p>', 'wp_edit_pro');
					}
					if($icon === 'pastetext') { 
						$class = 'dashicons dashicons-editor-paste-text';
						$title = __('Paste Text', 'wp_edit_pro');
						$tooltip['title'] = __('Paste Text', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Paste content as plain text.</p>', 'wp_edit_pro');
					}
					if($icon === 'removeformat') { 
						$class = 'dashicons dashicons-editor-removeformatting';
						$title = __('Remove Format', 'wp_edit_pro');
						$tooltip['title'] = __('Remove Format', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Remove all current formatting from selected content.</p>', 'wp_edit_pro');
					}
					if($icon === 'charmap') { 
						$class = 'dashicons dashicons-editor-customchar';
						$title = __('Character Map', 'wp_edit_pro');
						$tooltip['title'] = __('Character Map', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Display a characted map used for inserting special characters.</p>', 'wp_edit_pro');
					}
					if($icon === 'outdent') { 
						$class = 'dashicons dashicons-editor-outdent';
						$title = __('Outdent', 'wp_edit_pro');
						$tooltip['title'] = __('Outdent', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Outdent selected content; primary used for paragraph elements.</p>', 'wp_edit_pro');
					}
					if($icon === 'indent') { 
						$class = 'dashicons dashicons-editor-indent';
						$title = __('Indent', 'wp_edit_pro');
						$tooltip['title'] = __('Indent', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Indent selected content; primary used for paragraph elements.</p>', 'wp_edit_pro');
					}
					if($icon === 'undo') { 
						$class = 'dashicons dashicons-undo';
						$title = __('Undo', 'wp_edit_pro');
						$tooltip['title'] = __('Undo', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Undo last editor action.</p>', 'wp_edit_pro');
					}
					if($icon === 'redo') { 
						$class = 'dashicons dashicons-redo';
						$title = __('Redo', 'wp_edit_pro');
						$tooltip['title'] = __('Redo', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Redo last editor action.</p>', 'wp_edit_pro');
					}
					if($icon === 'wp_help') { 
						$class = 'dashicons dashicons-editor-help';
						$title = __('Help', 'wp_edit_pro');
						$tooltip['title'] = __('Help', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Displays helpful information such as editor information and keyboard shortcuts.</p>', 'wp_edit_pro');
					}
					
					// WP Buttons not included by default
					if($icon === 'fontselect') { 
						$title = __('Font Select', 'wp_edit_pro'); 
						$text = __('Font Family', 'wp_edit_pro'); 
						$tooltip['title'] = __('Font Select', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Apply various fonts to the editor selection.</p><p>Also displays fonts from Google Fonts options (if activated).</p>', 'wp_edit_pro');
					}
					if($icon === 'fontsizeselect') { 
						$title = __('Font Size Select', 'wp_edit_pro'); 
						$text = __('Font Sizes', 'wp_edit_pro'); 
						$tooltip['title'] = __('Font Size Select', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Apply various font sizes to the editor selection.</p><p>Default values can be switched from "pt" to "px" via the Editor tab.</p>', 'wp_edit_pro');
					}
					if($icon === 'styleselect') { 
						$title = __('Formats', 'wp_edit_pro'); 
						$text = __('Formats', 'wp_edit_pro'); 
						$tooltip['title'] = __('Formats', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Displays quick access to formats like "Headings", "Inline", "Blocks" and "Alignment".</p><p>Any custom styles created (Styles Tab) will also be shown here.</p>', 'wp_edit_pro');
					}
					if($icon === 'backcolor') { 
						$title = __('Background Color Picker', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-backcolor"></i>'; 
						$tooltip['title'] = __('Background Color Picker', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Change the background color of selected content; commonly used for high-lighting text.</p>', 'wp_edit_pro');
					}
					if($icon === 'media') { 
						$class = 'dashicons dashicons-format-video'; 
						$title = __('Media', 'wp_edit_pro'); 
						$tooltip['title'] = __('Media', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Insert media from an external resource (by link); or embed media content into editor.</p>', 'wp_edit_pro');
					}
					if($icon === 'rtl') { 
						$title = __('Text Direction Right to Left', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-rtl"></i>'; 
						$tooltip['title'] = __('Text Direction Right to Left', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Forces the text direction from right to left on selected block element.</p>', 'wp_edit_pro');
					}
					if($icon === 'ltr') { 
						$title = __('Text Direction Left to Right', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-ltr"></i>'; 
						$tooltip['title'] = __('Text Direction Left to Right', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Forces the text direction from left to right on selected block element.</p>', 'wp_edit_pro');
					}
					if($icon === 'table') { 
						$title = __('Tables', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-table"></i>';
						$tooltip['title'] = __('Tables', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Insert, edit and modify html tables.</p>', 'wp_edit_pro');
					}
					if($icon === 'anchor') { 
						$title = __('Anchor', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-anchor"></i>'; 
						$tooltip['title'] = __('Anchor', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Create an anchor link on the page.</p>', 'wp_edit_pro');
					}
					if($icon === 'code') { 
						$title = __('HTML Code', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-code"></i>';
						$tooltip['title'] = __('HTML Code', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Displays the html code of the editor content; in a popup window.</p><p>This can be helpful when editing code is necessary, but switching editor views is undesirable.</p><p>Also, the "Code Magic" button provides a much better interface.</p>', 'wp_edit_pro');
					}
					if($icon === 'emoticons') { 
						$title = __('Emoticons', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-emoticons"></i>'; 
						$tooltip['title'] = __('Emoticons', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Opens an overlay window with access to common emoticons.</p>', 'wp_edit_pro');
					}
					if($icon === 'inserttime') { 
						$title = __('Insert Date Time', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-insertdatetime"></i>'; 
						$tooltip['title'] = __('Insert Date Time', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Inserts the current date and time into the content editor.</p><p>The date format can be adjusted using the "Configuration" tab.</p>', 'wp_edit_pro');
					}
					if($icon === 'wp_page') { 
						$class = 'dashicons dashicons-admin-page'; 
						$title = __('Page Break', 'wp_edit_pro'); 
						$tooltip['title'] = __('Page Break', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Inserts a page break; which can created "paged" sections of the content.</p>', 'wp_edit_pro');
					}
					if($icon === 'preview') { 
						$title = __('Preview', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-preview"></i>'; 
						$tooltip['title'] = __('Preview', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>A quick preview of the editor content.</p>', 'wp_edit_pro');
					}
					if($icon === 'print') { 
						$title = __('Print', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-print"></i>'; 
						$tooltip['title'] = __('Print', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Print the editor content directly to a printer.</p>', 'wp_edit_pro');
					}
					if($icon === 'searchreplace') { 
						$title = __('Search and Replace', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-searchreplace"></i>'; 
						$tooltip['title'] = __('Search and Replace', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Search and/or replace the editor content with specific characters.</p>', 'wp_edit_pro');
					}
					if($icon === 'visualblocks') { 
						$title = __('Show Blocks', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-visualblocks"></i>'; 
						$tooltip['title'] = __('Show Blocks', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Shows all block level editor elements with a light border.</p>', 'wp_edit_pro');
					}
					if($icon === 'subscript') { 
						$title = __('Subscript', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-subscript"></i>'; 
						$tooltip['title'] = __('Subscript', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Adds a <sub>subscript</sub> to selected editor content (mainly used with text).</p>', 'wp_edit_pro');
					}
					if($icon === 'superscript') { 
						$title = __('Superscript', 'wp_edit_pro'); 
						$text = '<i class="mce-ico mce-i-superscript"></i>';
						$tooltip['title'] = __('Superscript', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Adds a <sup>superscript</sup> to selected editor content (mainly used with text).</p>', 'wp_edit_pro');
					}
					if($icon === 'image_orig') { 
						$class = 'dashicons dashicons-format-image'; 
						$title = __('Image', 'wp_edit_pro'); 
						$tooltip['title'] = __('Image', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Insert images (by link).</p>', 'wp_edit_pro');
					}
					if($icon === 'p_tags_button') { 
						$title = __('Paragraph Tag', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/ptags/p_tag.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Paragraph Tag', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Insert paragraph tags (along with attributes); which will not be removed from the editor.</p>', 'wp_edit_pro');
					}
					if($icon === 'line_break_button') { 
						$title = __('Line Break', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/linebreak/line_break.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Line Break', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Insert line breaks; which will not be removed from the editor.</p><p>This is done by adding a class of "none" to the tag.</p>', 'wp_edit_pro');
					}
					if($icon === 'mailto') { 
						$title = __('MailTo Link', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/mailto/mailto.gif);width:20px;height:20px;'; 
						$tooltip['title'] = __('MailTo Link', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Turns an email address into an active mail link.</p><p>When clicked, it will open the users default mail client to send a message.</p>', 'wp_edit_pro');
					}
					if($icon === 'loremipsum') { 
						$title = __('Lorem Ipsum', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/loremipsum/loremipsum.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Lorem Ipsum', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Esaily insert placeholder text into the editor.</p><p>Select from multiple languages; and choose the number of elements to add.</p>', 'wp_edit_pro');
					}
					if($icon === 'shortcodes') { 
						$title = __('Shortcodes', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/shortcodes/shortcodes.gif);width:20px;height:20px;'; 
						$tooltip['title'] = __('Shortcodes', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Gathers all available shortcodes and adds them to a dropdown list; for easy editor insertion.</p><p>Note: The shortcodes gathered here do not include any shortcode attributes.</p><p>If shortcode attributes are necessary, they will need to be entered into the shortcode manually.</p>', 'wp_edit_pro');
					}
					if($icon === 'clker') { 
						$title = __('Clker Images', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/clker/img/clker.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Clker Images', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Browse and insert images from the Clker.com website.</p>', 'wp_edit_pro');
					}
					if($icon === 'cleardiv') { 
						$title = __('Clear Div', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/cleardiv/images/cleardiv.png);width:20px;height:20px;';  
						$tooltip['title'] = __('Clear Div', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Clear editor divs. Selections include "left", "right" and "both".</p>', 'wp_edit_pro');
					}
					if($icon === 'codemagic') { 
						$title = __('Code Magic', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/codemagic/images/codemagic.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Code Magic', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>An advanced html code editor; view and edit the html code from an overlay window.</p><p>Includes syntax highlighting; search and replace; and proper element spacing.</p><p>This is a great option when editing html code is necessary; but swtiching editor views is undesirable.</p>', 'wp_edit_pro');
					}
					if($icon === 'acheck') { 
						$title = __('Accessibility Checker', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/acheck/img/acheck.png);width:20px;height:20px;';
						$tooltip['title'] = __('Accessibility Checker', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Checks the editor content for accessibility by other devices.</p>', 'wp_edit_pro');
					}
					if($icon === 'advlink') { 
						$title = __('Insert/Edit Advanced Link', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/advlink/images/advlink.png);width:20px;height:20px;';
						$tooltip['title'] = __('Insert/Edit Advanced Link', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Insert and edit links; along with various atttributes.</p><p>Populates with all posts and pages; so linking to current content is a one-click process.</p><p>Also includes javascript attributes (onclick, onmouseover, etc.); which can be used for executing javascript functions.</p>', 'wp_edit_pro');
					}
					if($icon === 'advhr') { 
						$title = __('Advanced Horizontal Line', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/advhr/images/advhr.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Advanced Horizontal Line', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Modify various options of the horizontal line; like shadow and width.</p>', 'wp_edit_pro');
					}
					if($icon === 'advimage') { 
						$title = __('Advanced Insert/Edit Image', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/advimage/images/advimage.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Advanced Insert/Edit Image', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Insert/Edit images with more control.</p><p>Define image attributes, image margin, image padding and image border.</p><p>Also includes javascript attributes (onclick, onmouseover, etc.); which can be used for executing javascript functions.</p>', 'wp_edit_pro');
					}
					if($icon === 'formatPainter') { 
						$class = 'dashicons dashicons-admin-appearance';
						$title = __('Format Painter', 'wp_edit_pro'); 
						$tooltip['title'] = __('Format Painter', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Copies styling from one element; and applies the same styling to another element.</p>', 'wp_edit_pro');
					}
					if($icon === 'flickrImages') { 
						$title = __('Flickr Images', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/flickrImages/images/flickrImages.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Flickr Images', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Browse and insert Flickr images without ever leaving the content editor.</p>', 'wp_edit_pro');
					}
					if($icon === 'abbr') { 
						$title = __('Abbreviation', 'wp_edit_pro');
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/abbr/abbr.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Abbreviation', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Add an abbreviation to selected editor content.</p>', 'wp_edit_pro');
					}
					if($icon === 'imgmap') {
						$title = __('Image Map', 'wp_edit_pro'); 
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/imgmap/images/imgmap.png);width:20px;height:20px;';  
						$tooltip['title'] = __('Image Map', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Create an image map from an image.</p><p>Allows multiple "hot spots" on a single image.  Each "hot spot" can link to a different url.</p>', 'wp_edit_pro');
					}
					if($icon === 'nonbreaking') { 
						$title = __('Nonbreaking Space', 'wp_edit_pro');
						$style='background-image:url('.$this->plugin_url.'tmce_plugins/nonbreaking/nonbreaking.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Nonbreaking Space', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Insert a nonbreaking space; which will not be removed from the editor.</p>', 'wp_edit_pro');
					}
					if($icon === 'columnShortcodes') { 
						$class = 'dashicons dashicons-schedule';
						$title = __('Column Shortcodes', 'wp_edit_pro');
						$tooltip['title'] = __('Column Shortcodes', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>A tool for easily inserting column shortcode templates.</p>', 'wp_edit_pro');
					}
					if($icon === 'wpep_html_elements') { 
						$title = __('HTML Tags', 'wp_edit_pro');
						$style = 'background-image:url('.$this->plugin_url.'tmce_plugins/wpep_html_elements/html_tags.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('HTML Tags', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Select and insert an HTML tag with user-defined attributes (id, class, etc.).</p>', 'wp_edit_pro');
					}
					if($icon === 'dropbox') { 
						$title = __('Dropbox', 'wp_edit_pro');
						$style = 'background-image:url('.$this->plugin_url.'tmce_plugins/dropbox/dropbox.png);width:20px;height:20px;'; 
						$tooltip['title'] = __('Dropbox', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>Link to files contained in a DropBox account.</p><p>Do not forget to set additional Dropbox settings under the Editor tab.</p>', 'wp_edit_pro');
					}
					if($icon === 'youTube3') { 
						$title = 'YouTube';
						$style = 'background-image:url('.$this->plugin_url.'tmce_plugins/youTube3/images/youtube.png);width:20px;height:20px;'; 
						$tooltip['title'] = 'YouTube'; 
						$tooltip['content'] = '<p>Updated YouTube application for searching and inserting videos.</p>';
					}
					
					if($icon === 'adv_bullist') { 
						$title = __('Advanced Bullet List', 'wp_edit_pro');
						$class = 'dashicons dashicons-editor-ul';
						$tooltip['title'] = __('Advanced Bullet List', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>More options for inserting bulleted lists.</p>', 'wp_edit_pro');
					}
					if($icon === 'adv_numlist') { 
						$title = __('Advanced Number List', 'wp_edit_pro');
						$class = 'dashicons dashicons-editor-ol';
						$tooltip['title'] = __('Advanced Number List', 'wp_edit_pro'); 
						$tooltip['content'] = __('<p>More options for inserting numbered lists.</p>', 'wp_edit_pro');
					}
					
					// Process tooltips
					$tooltip_title = isset($tooltip['title']) ? $tooltip['title'] : __('Title not found', 'wp_edit_pro');
					$tooltip_content = isset($tooltip['content']) ? $tooltip['content'] : __('<p>Content not found. Please report to the plugin developer.</p>', 'wp_edit_pro');
					
					// Are we displaying fancy tooltips?
					$tooltip_att = ($no_tooltips === false) ? 'data-tooltip="<h4 class=\'data_tooltip_title\'>'.htmlspecialchars($tooltip_title).'</h4><hr />'.htmlspecialchars($tooltip_content).'" ' : '';
					
					// Display button
					echo '<div '.$tooltip_att.' id="'.$icon.'" class="ui-state-default draggable '.$class.'" title="'.$title.'"><span style="'.esc_attr($style).'">'.$text.'</span></div>';
				}
			}
		echo '</div>';
	}
}  // End if $show_buttons is set
// Else alert user to convert or reset plugin options.
else {
	_e('There appears to be an error with the plugin options. Please either convert or reset the plugin options via the "Database" tab.', 'wp_edit_pro');
}