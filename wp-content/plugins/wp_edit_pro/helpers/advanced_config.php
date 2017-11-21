<?php

/*
****************************************************************
Advanced configuration helper functions
****************************************************************
*/
function wpep_adv_config_init_editor( $orig ) {
	
	$options_config = array();
	
	// If editing a subsite
	$get_site_opt = get_site_option('wp_edit_pro_options_array');
	$get_admin_mode = $get_site_opt['wp_edit_pro_network']['wpep_network_admin_mode'];
	$get_blog_id = get_current_blog_id();
	
	if(isset($get_admin_mode) && $get_admin_mode == 'separate') {
		
		switch_to_blog($get_blog_id);
		$options = get_option('wp_edit_pro_options_array');
		$options_config = $options['wp_edit_pro_configuration'];
		restore_current_blog();
	}
	else {
		
		$options = get_wp_edit_pro_option_normal('wp_edit_pro_options_array');
		$options_config = $options['wp_edit_pro_configuration'];
	}
		
	if ( empty($options_config) || !is_array($options_config) ) {
		return $orig;
	}
	
	$merge_array = array_merge($orig, $options_config);
	return $merge_array;
}
add_filter('tiny_mce_before_init', 'wpep_adv_config_init_editor', 11111);

function wpep_get_tmce_init_defaults($a) {

	global $jwl_advmceconf_show_defaults;
	$jwl_advmceconf_show_defaults = $a;
	
	return array();
}
