<?php

// Define variables
global $options_buttons_tinymce, $current_user;

$plugin_opts = $this->options_array;
$function_opts = $this->get_wp_edit_pro_function_opts();

if ( $this->network_activated === true ) {

	// Check if subsite options should apply
	$site_opts = get_site_option('wp_edit_pro_options_array');
	
	if(isset($site_opts['wp_edit_pro_network']['wpep_network_admin_mode']) && $site_opts['wp_edit_pro_network']['wpep_network_admin_mode'] === 'separate') {
		
		$get_opts = get_option('wp_edit_pro_options_array');
		$options_buttons_tinymce = isset($get_opts['wp_edit_pro_buttons']) ? $get_opts['wp_edit_pro_buttons'] : $this->options_default['wp_edit_pro_buttons'];
	}
	else {
		
		$get_opts = get_site_option('wp_edit_pro_options_array');
		$options_buttons_tinymce = isset($get_opts['wp_edit_pro_buttons']) ? $get_opts['wp_edit_pro_buttons'] : $this->options_default['wp_edit_pro_buttons'];
	}
}
else {
	
	$get_opts = get_option('wp_edit_pro_options_array');
	$options_buttons_tinymce = isset($get_opts['wp_edit_pro_buttons']) ? $get_opts['wp_edit_pro_buttons'] : $this->options_default['wp_edit_pro_buttons'];
}


/*
****************************************************************
Get proper button configuration
****************************************************************
*/
// Check user role for custom editor
if(isset($current_user->roles[0])) {
	$user_role = $current_user->roles[0];
	$role_buttons = isset($function_opts['wp_edit_pro_buttons_wp_role_'.$user_role]) ? $function_opts['wp_edit_pro_buttons_wp_role_'.$user_role] : array();
	if(!empty($role_buttons)) {
		$options_buttons_tinymce = $role_buttons;
	}
}

// Check user capability for custom editor
$caps_array = array();
$plugin_opts = $function_opts;
if(!empty($plugin_opts)) {
	foreach($plugin_opts as $key => $value) {
		if (strpos($key ,'wp_edit_pro_buttons_wp_cap_') !== false) {
			$key = str_replace('wp_edit_pro_buttons_wp_cap_', '', $key);
			$caps_array[$key] = $value;
		}
	}
}
$caps_array = array_reverse($caps_array);  // Reverse array (uses top admin sortable cap item; instead of bottom (last item))
if(!empty($caps_array)) {
	foreach($caps_array as $key => $value) {
		if(current_user_can($key)) {
			$options_buttons_tinymce = $value;
		}
	}
}

// Check user meta for custom editor
$user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
$user_buttons =isset($user_meta['wp_edit_pro_buttons_user_editor']) ? $user_meta['wp_edit_pro_buttons_user_editor'] : '';
if(!empty($user_buttons)) {
	$options_buttons_tinymce = $user_buttons;
}

// If this is a visitor editor
if(!is_user_logged_in()) {
	$visitor_buttons = isset($function_opts['wp_edit_pro_buttons_wp_visitor']) ? $function_opts['wp_edit_pro_buttons_wp_visitor'] : array();
	if(!empty($visitor_buttons)) {
		$options_buttons_tinymce = $visitor_buttons;
	}
}


/*
****************************************************************
External plugins
****************************************************************
*/
function wp_edit_pro_mce_external_plugins( $plugins ) {
	
	global $options_buttons_tinymce;
	
	// Get plugin url
	$path = plugins_url( '', dirname(__FILE__) );
	$plugin_path = $path . '/';  // Has trailing slash
	
	// Get network activated
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) { require_once( ABSPATH . '/wp-admin/includes/plugin.php' ); }
	$plugin_network_activated = is_plugin_active_for_network( 'wp_edit_pro/main.php' ) ? true : false;
	
	// Build array of all button names found in active toolbars
	$final_options = array();
	$final_options = array_merge(explode(' ', $options_buttons_tinymce['toolbar1']), explode(' ', $options_buttons_tinymce['toolbar2']), explode(' ', $options_buttons_tinymce['toolbar3']), explode(' ', $options_buttons_tinymce['toolbar4']));
	
	// Add default plugins
	if(in_array('ltr', $final_options) || in_array('rtl', $final_options)) {
		$plugins['directionality'] = $plugin_path.'tmce_plugins/directionality/plugin.min.js';
	}
	//if(in_array('table', $final_options)) {
		$plugins['table'] = $plugin_path.'tmce_plugins/table/plugin.min.js';
	//}
	if(in_array('anchor', $final_options)) {
		$plugins['anchor'] = $plugin_path.'tmce_plugins/anchor/plugin.min.js';
	}
	if(in_array('code', $final_options)) {
		$plugins['code'] = $plugin_path.'tmce_plugins/code/plugin.min.js';
	}
	if(in_array('emoticons', $final_options)) {
		$plugins['emoticons'] = $plugin_path.'tmce_plugins/emoticons/plugin.min.js';
	}
	if(in_array('hr', $final_options)) {
		$plugins['hr'] = $plugin_path.'tmce_plugins/hr/plugin.min.js';
	}
	if(in_array('inserttime', $final_options)) {
		$plugins['insertdatetime'] = $plugin_path.'tmce_plugins/insertdatetime/plugin.min.js';
	}
	if(in_array('preview', $final_options)) {
		$plugins['preview'] = $plugin_path.'tmce_plugins/preview/plugin.min.js';
	}
	if(in_array('print', $final_options)) {
		$plugins['print'] = $plugin_path.'tmce_plugins/print/plugin.min.js';
	}
	if(in_array('searchreplace', $final_options)) {
		$plugins['searchreplace'] = $plugin_path.'tmce_plugins/searchreplace/plugin.min.js';
	}
	if(in_array('visualblocks', $final_options)) {
		$plugins['visualblocks'] = $plugin_path.'tmce_plugins/visualblocks/plugin.min.js';
	}
	
	// Add other external plugins
	if(in_array('p_tags_button', $final_options)) {
		$plugins['p_tags'] = $plugin_path.'tmce_plugins/ptags/plugin.js';
	}
	if(in_array('line_break_button', $final_options)) {
		$plugins['line_break'] = $plugin_path.'tmce_plugins/linebreak/plugin.js';
	}
	if(in_array('mailto', $final_options)) {
		$plugins['mailto'] = $plugin_path.'tmce_plugins/mailto/plugin.js';
	}
	if(in_array('loremipsum', $final_options)) {
		$plugins['loremipsum'] = $plugin_path.'tmce_plugins/loremipsum/plugin.js';
	}
	if(in_array('shortcodes', $final_options)) {
		$plugins['shortcodes'] = $plugin_path.'tmce_plugins/shortcodes/plugin.js';
	}
	if(in_array('clker', $final_options)) {
		$plugins['clker'] = $plugin_path.'tmce_plugins/clker/plugin.js';
	}
	if(in_array('cleardiv', $final_options)) {
		$plugins['cleardiv'] = $plugin_path.'tmce_plugins/cleardiv/plugin.js';
	}
	if(in_array('codemagic', $final_options)) {
		$plugins['codemagic'] = $plugin_path.'tmce_plugins/codemagic/plugin.js';
	}
	if(in_array('acheck', $final_options)) {
		$plugins['acheck'] = $plugin_path.'tmce_plugins/acheck/plugin.js';
	}
	if(in_array('image_orig', $final_options)) {
		$plugins['image_orig'] = $plugin_path.'tmce_plugins/image_orig/plugin.min.js';
	}
	if(in_array('advlink', $final_options)) {
		$plugins['advlink'] = $plugin_path.'tmce_plugins/advlink/plugin.js';
	}
	if(in_array('advhr', $final_options)) {
		$plugins['advhr'] = $plugin_path.'tmce_plugins/advhr/plugin.js';
	}
	if(in_array('advimage', $final_options)) {
		$plugins['advimage'] = $plugin_path.'tmce_plugins/advimage/plugin.js';
	}
	if(in_array('formatPainter', $final_options)) {
		$plugins['formatPainter'] = $plugin_path.'tmce_plugins/formatPainter/plugin.js';
	}
	if(in_array('flickrImages', $final_options)) {
		$plugins['flickrImages'] = $plugin_path.'tmce_plugins/flickrImages/plugin.js';
	}
	if(in_array('abbr', $final_options)) {
		$plugins['abbr'] = $plugin_path.'tmce_plugins/abbr/plugin.js';
	}
	if(in_array('imgmap', $final_options)) {
		$plugins['imgmap'] = $plugin_path.'tmce_plugins/imgmap/editor_plugin.js';
	}
	if(in_array('columnShortcodes', $final_options)) {
		$plugins['columnShortcodes'] = $plugin_path.'tmce_plugins/columnShortcodes/plugin.js';
	}
	if(in_array('wpep_html_elements', $final_options)) {
		$plugins['wpep_html_elements'] = $plugin_path.'tmce_plugins/wpep_html_elements/plugin.js';
	}
	if(in_array('dropbox', $final_options)) {
		$plugins['dropbox'] = $plugin_path.'tmce_plugins/dropbox/plugin.js';
	}
	if(in_array('youTube3', $final_options)) {
		$plugins['youTube3'] = $plugin_path.'tmce_plugins/youTube3/plugin.js';
	}
	if(in_array('adv_bullist', $final_options) || in_array('adv_numlist', $final_options)) {
		$plugins['advlist'] = $plugin_path.'tmce_plugins/advlist/plugin.min.js';
	}
	if( in_array('nonbreaking', $final_options)) {
		$plugins['nonbreaking'] = $plugin_path.'tmce_plugins/nonbreaking/plugin.min.js';
	}
	
	
	// Return values
	return $plugins;
}
add_filter('mce_external_plugins', 'wp_edit_pro_mce_external_plugins');


/*
****************************************************************
Filter editor button rows
****************************************************************
*/
// If there are options to modify the toolbars
if($options_buttons_tinymce) {
	
	foreach ($options_buttons_tinymce as $key => $value) {
		
		// Magic is happening right here...
		if($key == 'tmce_container') { return; }
		if($key == 'toolbar1') { add_filter( 'mce_buttons', 'wp_edit_pro_add_mce' ); }
		if($key == 'toolbar2') { add_filter( 'mce_buttons_2', 'wp_edit_pro_add_mce_2' ); }
		if($key == 'toolbar3') { add_filter( 'mce_buttons_3', 'wp_edit_pro_add_mce_3' ); }
		if($key == 'toolbar4') { add_filter( 'mce_buttons_4', 'wp_edit_pro_add_mce_4' ); }
	}
}
function wp_edit_pro_add_mce($buttons) {
	
	// Get buttons options
	global $options_buttons_tinymce;
	
	// Define arrays
	$options_toolbar1 = $options_buttons_tinymce['toolbar1'];
	$default_wp_array_toolbar1 = array('bold','italic','strikethrough','bullist','numlist','blockquote','hr','alignleft','aligncenter','alignright','image','link','unlink','wp_more');
	$array_back = array();
	
	// First, we explode the toolbar in the database
	$options_toolbar1 = explode(' ', $options_toolbar1);
	
	// Next, we get the difference between ($options['toolbar1']) and ($buttons)
	$array_diff = array_diff($buttons, $options_toolbar1);
	
	// Now, we take the array and loop it to find original buttons
	if($array_diff) {
		
		foreach($array_diff as $array) {
			
			// If the button is NOT in the original array (WP buttons), we know it is another plugin or theme button..
			if(!in_array($array, $default_wp_array_toolbar1)) {
				
				// Create the new array of additional buttons to pass back to end of toolbar
				$array_back[] = $array;
			}
		}
	}
	
	// Merge the difference onto the end of our saved buttons
	$merge_buttons = array_merge($options_toolbar1, $array_back);
	
	// Return the final array
	return $merge_buttons;
}
function wp_edit_pro_add_mce_2($buttons) {
	
	// Get buttons options
	global $options_buttons_tinymce;
	
	// Define arrays
	$options_toolbar2 = $options_buttons_tinymce['toolbar2'];
	$default_wp_array_toolbar2 = array('formatselect','underline','alignjustify','forecolor','pastetext','removeformat','charmap','outdent','indent','undo','redo','wp_help');
	$array_back = array();
	
	// First, we explode the toolbar in the database
	$options_toolbar2 = explode(' ', $options_toolbar2);
	
	// Next, we get the difference between ($options['toolbar2']) and ($buttons)
	$array_diff = array_diff($buttons, $options_toolbar2);
	
	// Now, we take the array and loop it to find original buttons
	if($array_diff) {
		
		foreach($array_diff as $array) {
			
			// If the button is NOT in the original array (WP buttons), we know it is another plugin or theme button..
			if(!in_array($array, $default_wp_array_toolbar2)) {
				
				// Create the new array of additional buttons to pass back to end of toolbar
				$array_back[] = $array;
			}
		}
	}
	
	// Merge the difference onto the end of our saved buttons
	$merge_buttons = array_merge($options_toolbar2, $array_back);
	
	return $merge_buttons;
}
function wp_edit_pro_add_mce_3($buttons) {
	
	// Get buttons options
	global $options_buttons_tinymce;
	
	// Define arrays
	$options_toolbar3 = $options_buttons_tinymce['toolbar3'];
	$default_wp_array_toolbar3 = array();
	$array_back = array();
	
	// First, we explode the toolbar in the database
	$options_toolbar3 = explode(' ', $options_toolbar3);
	
	// Next, we get the difference between ($options['toolbar3']) and ($buttons)
	$array_diff = array_diff($buttons, $options_toolbar3);
	
	// Now, we take the array and loop it to find original buttons
	if($array_diff) {
		
		foreach($array_diff as $array) {
			
			// If the button is NOT in the original array (WP buttons), we know it is another plugin or theme button..
			if(!in_array($array, $default_wp_array_toolbar3)) {
				
				// Create the new array of additional buttons to pass back to end of toolbar
				$array_back[] = $array;
			}
		}
	}
	
	// Merge the difference onto the end of our saved buttons
	$merge_buttons = array_merge($options_toolbar3, $array_back);
	
	return $merge_buttons;
}
function wp_edit_pro_add_mce_4($buttons) {
	
	// Get buttons options
	global $options_buttons_tinymce;
	
	// Define arrays
	$options_toolbar4 = $options_buttons_tinymce['toolbar4'];
	$default_wp_array_toolbar4 = array();
	$array_back = array();
	
	// First, we explode the toolbar in the database
	$options_toolbar4 = explode(' ', $options_toolbar4);
	
	// Next, we get the difference between ($options['toolbar4']) and ($buttons)
	$array_diff = array_diff($buttons, $options_toolbar4);
	
	// Now, we take the array and loop it to find original buttons
	if($array_diff) {
		
		foreach($array_diff as $array) {
			
			// If the button is NOT in the original array (WP buttons), we know it is another plugin or theme button..
			if(!in_array($array, $default_wp_array_toolbar4)) {
				
				// Create the new array of additional buttons to pass back to end of toolbar
				$array_back[] = $array;
			}
		}
	}
	
	// Merge the difference onto the end of our saved buttons
	$merge_buttons = array_merge($options_toolbar4, $array_back);
	
	return $merge_buttons;
}