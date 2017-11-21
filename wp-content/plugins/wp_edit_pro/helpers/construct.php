<?php

// Define plugin network activation
if ( ! function_exists( 'is_plugin_active_for_network' ) ) { require_once( ABSPATH . '/wp-admin/includes/plugin.php' ); }
$plugin_network_activated = is_plugin_active_for_network( 'wp_edit_pro/main.php' ) ? true : false;
$this->network_activated = $plugin_network_activated;

// Define plugin url and path
$path = plugins_url( '', dirname(__FILE__) );
$this->plugin_url = $path . '/';  // Has trailing slash
$this->plugin_path =  plugin_dir_path( dirname( __FILE__ ) );  // Has trailing slash

// Update public varible for site admin network mode and subsite blog id
$get_site_options = get_site_option( 'wp_edit_pro_options_array' );
$this->network_admin_mode = isset( $get_site_options['wp_edit_pro_network']['wpep_network_admin_mode'] ) ? $get_site_options['wp_edit_pro_network']['wpep_network_admin_mode'] : 'same';
$this->network_blog_id = isset( $get_site_options['wp_edit_pro_network']['wpep_select_blog_id'] ) ? $get_site_options['wp_edit_pro_network']['wpep_select_blog_id'] : '';

// Update public variable for WP version
$wp_version = get_bloginfo( 'version' );
$this_version = isset( $wp_version ) ? $wp_version : '1';
$this->wp_version = $this_version;


/*
****************************************************************
// Populate options array
****************************************************************
*/

$this->options_array = $this->get_wp_edit_pro_option( 'wp_edit_pro_options_array' );

/*
****************************************************************
Populate this plugin default values
****************************************************************
*/

$this->options_default = array(

	'wp_edit_pro_buttons' => array(
		'toolbar1' => 'bold italic strikethrough bullist numlist blockquote hr alignleft aligncenter alignright link unlink wp_more', 
		'toolbar2' => 'formatselect underline alignjustify forecolor pastetext removeformat charmap outdent indent undo redo wp_help', 
		'toolbar3' => '', 
		'toolbar4' => '',
		'tmce_container' => 'fontselect fontsizeselect styleselect backcolor media rtl ltr table anchor code emoticons inserttime wp_page preview print searchreplace visualblocks subscript superscript image_orig p_tags_button line_break_button mailto loremipsum shortcodes clker cleardiv codemagic acheck advlink advhr advimage formatPainter flickrImages abbr imgmap nonbreaking columnShortcodes wpep_html_elements dropbox youTube3 adv_bullist adv_numlist',
	),
	
	'wp_edit_pro_buttons_extras' => array( 
	
		'created_editors_view' => 'table'
	),
	
	'wp_edit_pro_network' => array(
		'wpep_network_admin_mode' => 'same',
		'wpep_select_blog_id' => ''
	),
	
	'wp_edit_pro_global' => array(
		'jquery_theme' => 'smoothness',
		'disable_buttons_fancy_tooltips' => '0'
	),
	
	'wp_edit_pro_configuration' => array(),
	
	'wp_edit_pro_general' => array(
		'linebreak_shortcode' => '0',
		'shortcodes_in_widgets' => '0',
		'shortcodes_in_excerpts' => '0',
		'post_excerpt_editor' => '0',
		'page_excerpt_editor' => '0',
		'cpt_excerpt_editor' => array(),
		'profile_editor' => '0'
	),
	
	'wp_edit_pro_posts' => array(
		'wpep_styles_editor_textarea' => '',
		'wpep_scripts_editor_textarea' => '',
		'wpep_ind_styles_scripts' => '0',
		'post_title_field' => 'Enter title here',
		'column_shortcodes' => '0',
		'editor_notes' => '0',
		'max_post_revisions' => '',
		'max_page_revisions' => '',
		'delete_revisions' => '0',
		'hide_admin_posts' => '',
		'hide_admin_pages' => '',
		'enable_comment_editor' => ''
	),
	
	'wp_edit_pro_editor' => array(
		'editor_toggle_toolbar' => '0',
		'editor_menu_bar' => '0',
		'default_editor_fontsize_type' => 'pt',
		'default_editor_fontsize_values' => '',
		'editor_custom_colors' => array(),
		'dropbox_app_key' => '',
		'disable_wpep_posts' => '0',
		'disable_wpep_pages' => '0'
	),
	
	'wp_edit_pro_fonts' => array(
		'enable_google_fonts' => '0',
		'save_google_fonts' => '',
		'save_custom_fonts' => array()
	),
	
	'wp_edit_pro_styles' => array(
		'add_predefined_styles' => '0',
		'custom_styles' => array(),
		'tinymce_custom_css' => '',
		'tinymce_custom_css_parsed' => ''
	),
	
	'wp_edit_pro_widgets' => array(
		'widget_builder' => '0',
		'wpep_select_user_meta_roles_snidgets' => array()
	),
	
	'wp_edit_pro_user' => array(
		'wpep_select_user_meta_roles' => array()
	),
	
	'wp_edit_pro_extras' => array(
		'signoff_text' => 'Please enter text here...',
		'enable_qr' => '0',
		'enable_qr_widget' => '0',
		'qr_colors' => array(
			'background_title' => 'e2e2e2',
			'background_content' => 'dee8e4',
			'text_color' => '000000',
			'qr_foreground_color' => 'c4d7ed',
			'qr_background_color' => '120a23',
			'title_text' => 'Enter title here...',
			'content_text' => 'Enter content here...'
		)
	),
	
	'wpep_dashboard_widget_items' => '',
	'wpep_first_install' => 'true',
	'wpep_license_notice' => 'false'
);

/*
****************************************************************
Populate this plugin user values
****************************************************************
*/

$this->user_options_default = array(

	'id_column' => '0',
	'thumbnail_column' => '0',
	'hide_text_tab' => '0',
	'default_visual_tab' => '0',
	'dashboard_widget' => '0',
	'enable_highlights' => '0',
	
	'draft_highlight' => '#FFFFFF',
	'pending_highlight' => '#FFFFFF',
	'published_highlight' => '#FFFFFF',
	'future_highlight' => '#FFFFFF',
	'private_highlight' => '#FFFFFF',
	
	'ignore_wpeditpro_update_expiry_notice' => 'false'
);


/*
****************************************************************
Register activation hook and new blog hook
****************************************************************
*/

$activate_path = $this->plugin_path . 'main.php';
register_activation_hook( $activate_path, array( $this, 'activation_hook' ) );  // Plugin activation hook (network too) (populate plugin settings)
add_action( 'wpmu_new_blog', array( $this, 'wpmu_new_blog' ), 10, 6 );  // Ran when new blog is created in network (populate plugin settings)


/*
****************************************************************
Admin init
****************************************************************
*/

add_action( 'admin_init', array( $this, 'admin_init' ) );
add_action( 'admin_init', array( $this, 'admin_init_user_specific_functions' ) );


/*
****************************************************************
Add menu pages
****************************************************************
*/

add_action( $this->network_activated === true ? 'network_admin_menu' : 'admin_menu', array( $this, 'main_admin_menu' ) );

// Load subsite admin page if this plugin is network activated
if( $this->network_activated == true ) {
	
	add_action( 'admin_menu', array( $this, 'admin_menu_subsite' ) );
}
// Load user admin page (currently for snidgets and user opts)
else {
	
	add_action( 'admin_menu', array( $this, 'admin_menu_subsite_user' ) );
}


/*
****************************************************************
Language localization
****************************************************************
*/
add_action( 'plugins_loaded', array( $this, 'wp_edit_pro_load_translation' ) ); 


/*
****************************************************************
Plugin action links
****************************************************************
*/

add_filter( $this->network_activated === true ? 'network_admin_plugin_action_links_wp_edit_pro/main.php' : 'plugin_action_links_wp_edit_pro/main.php', array( $this, 'plugin_action_links' ) );
add_filter( 'plugin_row_meta', array( $this, 'plugin_action_links_meta' ), 10, 2 );


/*
****************************************************************
Register ajax calls
****************************************************************
*/

add_action( 'wp_ajax_wp_edit_pro_custom_fonts_delete_row', array( $this, 'wp_edit_pro_custom_fonts_delete_row_callback' ) );  // Delete custom fonts
add_action( 'wp_ajax_wp_edit_pro_custom_styles_delete_row', array( $this, 'wp_edit_pro_custom_styles_delete_row_callback' ) );  // Delete custom styles
add_action( 'wp_ajax_wpeditpro_load_advlink_pages', array( $this, 'wpeditpro_load_advlink_pages_callback' ) );  // Insert/Edit advanced link data


/*
****************************************************************
Editor initialization
****************************************************************
*/
add_action( 'init', array( $this, 'editor_init' ) );

/*
****************************************************************
Register main tiny_mce_before_init filter
****************************************************************
*/
add_filter( 'tiny_mce_before_init', array( $this, 'editor_tiny_mce_before_init' ) );

/*
****************************************************************
Pass js vars only to wp tinymce pages
****************************************************************
*/
add_action( 'before_wp_tiny_mce', array( $this, 'editor_before_wp_tiny_mce' ) );
add_action( 'after_wp_tiny_mce', array( $this, 'editor_after_wp_tiny_mce' ) );

/*
****************************************************************
Localize plugin languages
****************************************************************
*/
add_filter( 'mce_external_languages', array( $this, 'editor_tinymce_langs' ) );

/*
****************************************************************
Check html content and enqueue responsive imagemap
****************************************************************
*/
add_action( 'wp_print_styles', array( $this, 'editor_include_responsive_imagemap' ) );
		
		


/*
****************************************************************
Set options for running front-end page functions
****************************************************************
*/

$function_opts = $this->get_wp_edit_pro_function_opts( 'wp_edit_pro_options_array' );

		
/*
****************************************************************
Functions - Global tab
****************************************************************
*/


		
/*
****************************************************************
Functions - General tab
****************************************************************
*/

// Enable linebreak shortcode
if(isset($function_opts['wp_edit_pro_general']['linebreak_shortcode']) && $function_opts['wp_edit_pro_general']['linebreak_shortcode'] == 1) {
	add_shortcode('break', array($this, 'wp_edit_pro_insert_linebreak'));
}	
// Enable Shortcodes in Widgets
if(isset($function_opts['wp_edit_pro_general']['shortcodes_in_widgets']) && $function_opts['wp_edit_pro_general']['shortcodes_in_widgets'] == 1) {
	add_filter('widget_text', 'do_shortcode');
}
// Enable Shortcodes in Excerpts
if(isset($function_opts['wp_edit_pro_general']['shortcodes_in_excerpts']) && $function_opts['wp_edit_pro_general']['shortcodes_in_excerpts'] == 1) {
	add_filter('the_excerpt', 'do_shortcode');
}
// Add Editor to Post Excerpts
if(isset($function_opts['wp_edit_pro_general']['post_excerpt_editor']) && $function_opts['wp_edit_pro_general']['post_excerpt_editor'] == 1) {
	add_action('admin_init', array($this, 'wp_edit_pro_change_post_excerpt'));
}
// Add Editor to Page Excerpts
if(isset($function_opts['wp_edit_pro_general']['page_excerpt_editor']) && $function_opts['wp_edit_pro_general']['page_excerpt_editor'] == 1) {
	add_action('init', array($this, 'wp_edit_pro_page_excerpts_init'));
	add_action('admin_init', array($this, 'wp_edit_pro_change_page_excerpt'));
}
// Add Editor to CPT's
if(isset($function_opts['wp_edit_pro_general']['wpep_cpt_excerpts']) && !empty($function_opts['wp_edit_pro_general']['wpep_cpt_excerpts'])) {
	add_action('admin_init', array($this, 'wp_edit_pro_change_cpt_excerpt'));
}
// Extend editor to profile biography
if(isset($function_opts['wp_edit_pro_general']['profile_editor']) && $function_opts['wp_edit_pro_general']['profile_editor'] == 1) {
	add_action('show_user_profile', array($this, 'wp_edit_pro_visual_editor'));
	add_action('edit_user_profile', array($this, 'wp_edit_pro_visual_editor'));
	add_action('admin_footer', array($this, 'wp_edit_pro_editor_biography_js'));
}
		
		
/*
****************************************************************
Functions - Posts tab
****************************************************************
*/
// Global styles
if(isset($function_opts['wp_edit_pro_posts']['wpep_styles_editor_textarea']) && $function_opts['wp_edit_pro_posts']['wpep_styles_editor_textarea'] != '') {
	add_action('wp_head', array($this, 'wp_edit_pro_posts_tab_custom_styles'));
}
// Global scripts
if(isset($function_opts['wp_edit_pro_posts']['wpep_scripts_editor_textarea']) && $function_opts['wp_edit_pro_posts']['wpep_scripts_editor_textarea'] != '') {
	add_action('wp_footer', array($this, 'wp_edit_pro_posts_tab_custom_scripts'));
}
// Individual page styles and scripts
if(isset($function_opts['wp_edit_pro_posts']['wpep_ind_styles_scripts']) && $function_opts['wp_edit_pro_posts']['wpep_ind_styles_scripts'] == 1) {
	
	add_action( 'add_meta_boxes', array( $this, 'wpep_add_styles_scripts_meta_box' ) );
	add_action( 'save_post', array( $this, 'wpep_style_script_save_meta_box_data' ) );
	add_action( 'wp_head', array( $this, 'wpep_ind_style_head' ) );
	add_action( 'wp_footer', array( $this, 'wpep_ind_script_footer' ) );
	add_filter( 'body_class', array( $this, 'wpep_filter_body_classes' ) );
	add_filter( 'post_class', array( $this, 'wpep_filter_post_classes' ) );
	add_action( 'admin_enqueue_scripts', array( $this, 'wpep_post_scripts_metabox_script') );
}
// Post title field
if(isset($function_opts['wp_edit_pro_posts']['post_title_field']) && $function_opts['wp_edit_pro_posts']['post_title_field'] != 'Enter title here') {
	add_filter('enter_title_here', array($this, 'wp_edit_pro_title_text_input'));
}
// Column Shortcodes
if(isset($function_opts['wp_edit_pro_posts']['column_shortcodes']) && $function_opts['wp_edit_pro_posts']['column_shortcodes'] == 1) {
	
	add_shortcode('one_third', array($this, 'jwl_one_third'));
	add_shortcode('one_third_last', array($this, 'jwl_one_third_last'));
	add_shortcode('two_third', array($this, 'jwl_two_third'));
	add_shortcode('two_third_last', array($this, 'jwl_two_third_last'));
	add_shortcode('one_half', array($this, 'jwl_one_half'));
	add_shortcode('one_half_last', array($this, 'jwl_one_half_last'));
	add_shortcode('one_fourth', array($this, 'jwl_one_fourth'));
	add_shortcode('one_fourth_last', array($this, 'jwl_one_fourth_last'));
	add_shortcode('three_fourth', array($this, 'jwl_three_fourth'));
	add_shortcode('three_fourth_last', array($this, 'jwl_three_fourth_last'));
	add_shortcode('one_fifth', array($this, 'jwl_one_fifth'));
	add_shortcode('one_fifth_last', array($this, 'jwl_one_fifth_last'));
	add_shortcode('two_fifth', array($this, 'jwl_two_fifth'));
	add_shortcode('two_fifth_last', array($this, 'jwl_two_fifth_last'));
	add_shortcode('three_fifth', array($this, 'jwl_three_fifth'));
	add_shortcode('three_fifth_last', array($this, 'jwl_three_fifth_last'));
	add_shortcode('four_fifth', array($this, 'jwl_four_fifth'));
	add_shortcode('four_fifth_last', array($this, 'jwl_four_fifth_last'));
	add_shortcode('one_sixth', array($this, 'jwl_one_sixth'));
	add_shortcode('one_sixth_last', array($this, 'jwl_one_sixth_last'));
	add_shortcode('five_sixth', array($this, 'jwl_five_sixth'));
	add_shortcode('five_sixth_last', array($this, 'jwl_five_sixth_last'));
	
	add_action('wp_print_styles', array($this, 'wp_edit_pro_enqueue_column_stylesheet'));
}
// Editor notes
if(isset($function_opts['wp_edit_pro_posts']['editor_notes']) && $function_opts['wp_edit_pro_posts']['editor_notes'] == 1) {
	
	// Only admins can see
	if(is_admin()) {
		
		add_action('add_meta_boxes', array($this, 'wpep_register_editor_notes_metabox'));
		add_action('save_post', array($this, 'save_editor_notes_metabox'), 10, 3);
	}
}
// Max post revisions
if(isset($function_opts['wp_edit_pro_posts']['max_post_revisions']) && $function_opts['wp_edit_pro_posts']['max_post_revisions'] != '') {
	
	add_filter( 'wp_revisions_to_keep', array($this, 'wp_edit_pro_max_post_revisions'), 10, 2 );
	add_action( 'admin_print_scripts-post.php', array($this, 'wp_edit_pro_max_revisions_js') );
	add_action( 'admin_print_scripts-post-new.php', array($this, 'wp_edit_pro_max_revisions_js') );
}
// Max page revisions
if(isset($function_opts['wp_edit_pro_posts']['max_page_revisions']) && $function_opts['wp_edit_pro_posts']['max_page_revisions'] != '') {
	
	add_filter( 'wp_revisions_to_keep', array($this, 'wp_edit_pro_max_page_revisions'), 10, 2 );
	add_action( 'admin_print_scripts-post.php', array($this, 'wp_edit_pro_max_revisions_js') );
	add_action( 'admin_print_scripts-post-new.php', array($this, 'wp_edit_pro_max_revisions_js') );
}
// Hide admin posts
if(isset($function_opts['wp_edit_pro_posts']['hide_admin_posts']) && $function_opts['wp_edit_pro_posts']['hide_admin_posts'] != '') {
	add_action('pre_get_posts', array($this, 'wp_edit_pro_hide_admin_posts'));
}
// Hide admin pages
if(isset($function_opts['wp_edit_pro_posts']['hide_admin_pages']) && $function_opts['wp_edit_pro_posts']['hide_admin_pages'] != '') {
	add_action('pre_get_posts', array($this, 'wp_edit_pro_hide_admin_pages'));
}
// Enable comment editor
if(isset($function_opts['wp_edit_pro_posts']['enable_comment_editor']) && $function_opts['wp_edit_pro_posts']['enable_comment_editor'] == 1) {
	
	add_filter('comment_form_defaults', array($this, 'wpep_comment_form_editor'));
	add_action('wp_enqueue_scripts', array($this, 'wpep_comment_form_scripts'));
	add_action('init', array($this, 'wpep_comment_form_allowed_tags'));
}


/*
****************************************************************
Functions - Fonts tab
****************************************************************
*/
// Google fonts
if(isset($function_opts['wp_edit_pro_fonts']['enable_google_fonts']) && $function_opts['wp_edit_pro_fonts']['enable_google_fonts'] == 1) {
	
	add_action( 'wp_head', array( $this, 'wp_edit_pro_google_load_fonts' ) );
	add_action( 'admin_head', array( $this, 'wp_edit_pro_google_load_fonts' ) );
}
// Custom fonts
if(isset($function_opts['wp_edit_pro_fonts']['save_custom_fonts']) && !empty($function_opts['wp_edit_pro_fonts']['save_custom_fonts'])) {
	
	add_action( 'wp_head', array( $this, 'wp_edit_pro_custom_load_fonts' ) );
	add_action( 'admin_head', array( $this, 'wp_edit_pro_custom_load_fonts' ) );
}

		
/*
****************************************************************
Functions - Extras tab
****************************************************************
*/
// Signoff text shortcode
if( isset( $function_opts['wp_edit_pro_extras']['signoff_text'] ) && $function_opts['wp_edit_pro_extras']['signoff_text'] != '' ) {
	
	add_shortcode('signoff', array($this, 'wp_edit_pro_signoff_text'));
}
// QR codes in posts/pages
if( isset( $function_opts['wp_edit_pro_extras']['enable_qr'] ) && $function_opts['wp_edit_pro_extras']['enable_qr'] == 1 ) {
	
	add_action( 'admin_menu', array($this, 'wp_edit_pro_add_box') );
	add_action( 'save_post', array($this, 'wp_edit_pro_save_qr_data') );
	add_filter( 'the_content', array($this, 'wp_edit_pro_qr_content') );
	add_shortcode( 'wpeditpro_qr_shortcode', array($this, 'wp_edit_pro_qr_shortcode') );
}
// QR codes in widgets
if(isset($function_opts['wp_edit_pro_extras']['enable_qr_widget']) && $function_opts['wp_edit_pro_extras']['enable_qr_widget'] == 1) {
	
	add_action( 'widgets_init', array($this, 'wp_edit_pro_register_qr_widget') );
}



		
/*
****************************************************************
Register update check and notice
****************************************************************
*/
add_action( 'init', array($this, 'wpep_wpeditpro_update_check') );
add_action( 'init', array($this, 'wpep_add_upgrade_notice_opt') );
		