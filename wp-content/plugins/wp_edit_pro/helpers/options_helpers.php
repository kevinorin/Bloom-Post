<?php

function get_wp_edit_pro_option_normal($option_name) {
		
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) { require_once( ABSPATH . '/wp-admin/includes/plugin.php' ); }
	$plugin_network_activated = is_plugin_active_for_network( 'wp_edit_pro/main.php' ) ? true : false;

	if($plugin_network_activated == true) {
		
		$plugin_opts = get_site_option('wp_edit_pro_options_array');
		$blog_id = isset( $plugin_opts['wp_edit_pro_network']['wpep_select_blog_id'] ) ? $plugin_opts['wp_edit_pro_network']['wpep_select_blog_id'] : '';
		
		if($blog_id === '') {
			$get_opt = get_site_option($option_name);
		}
		else {
			switch_to_blog($blog_id);
			$get_opt = get_option($option_name);
			restore_current_blog();
		}
	}
	else {
		$get_opt = get_option($option_name);
	}
	
	return $get_opt;
}


/*
****************************************************************
Create functions to check site or blog id options (if network)
****************************************************************
*/
// Wordpress function 'get_site_option' and 'get_option'
function get_wp_edit_pro_option($option_name) {
	
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) { require_once( ABSPATH . '/wp-admin/includes/plugin.php' ); }
	$plugin_network_activated = is_plugin_active_for_network( 'wp_edit_pro/main.php' ) ? true : false;
	
	if($plugin_network_activated == true) {
		
		$get_opt = get_site_option($option_name);
	}
	else {
		
		$get_opt = get_option($option_name);
	}
	
	return $get_opt;
}
// Wordpress function 'update_site_option' and 'update_option'
function update_wp_edit_pro_option($option_name, $option_value) {
	
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) { require_once( ABSPATH . '/wp-admin/includes/plugin.php' ); }
	$plugin_network_activated = is_plugin_active_for_network( 'wp_edit_pro/main.php' ) ? true : false;
	
	if($plugin_network_activated == true) {
		
		$update_opt = update_site_option($option_name, $option_value);
	}
	else {
		
		$update_opt = update_option($option_name, $option_value);
	}
	
	return $update_opt;
}
// Wordpress function 'delete_site_option' and 'delete_option'
function delete_wp_edit_pro_option($option_name) {
	
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) { require_once( ABSPATH . '/wp-admin/includes/plugin.php' ); }
	$plugin_network_activated = is_plugin_active_for_network( 'wp_edit_pro/main.php' ) ? true : false;
	
	if($plugin_network_activated == true) {
		
		$delete_opt = delete_site_option($option_name);
	}
	else {
		
		$delete_opt = delete_option($option_name);
	}
	
	return $delete_opt;
}
