<?php
/**
 * Plugin Name: WP Edit Pro
 * Plugin URI: https://wpeditpro.com
 * Description: Ultimate WordPress Content Editing.  Professional Edition.
 * Version: 4.4.2
 * Author: Josh Lobe
 * Text Domain: wp_edit_pro
 * Domain Path: /langs 
 * Author URI: https://wpeditpro.com/author/
 * License: This product is licensed to Josh Lobe Plugins. Any reproduction without expressed written consent from the author (Josh Lobe) will be prosecuted to the fullest extent. Contact the developer at the website above to learn more about licensing.
*/

// Set normal (non-class) options handlers
include 'helpers/options_helpers.php';

// Include snidgets table
include 'classes/snidgets_table.php';

// Include snidgets class (register post type, buttons, etc.)
include 'classes/snidgets_class.php';

// Include advanced config helper functions
include 'helpers/advanced_config.php';

// Include qr code
include 'classes/qr_code.php';

class WP_EDIT_PRO {
	
	private static $instance;
	
	public static function get_instance() {
		
		if(!self::$instance) {
			self::$instance == new self();
		}
		return self::$instance;
	}
	
	
	public $options_array = array();
	public $options_default = array();
	public $user_options_default = array();
	
	public $network_activated = '';
	public $network_admin_mode = 'same';
	public $network_blog_id = '';
	
	public $plugin_url = '';
	public $plugin_path = '';
	
	public $wp_version = '';
	
	
	public function __construct() {
		
		include 'helpers/construct.php';
	}
	
	
	/*
	****************************************************************
	Activation Hook
	****************************************************************
	*/
	public function activation_hook( $network_wide ) { 
	
		// If plugin is being network activated in multisite environment
		if ( $network_wide ) {  
		
			global $current_user;
			
			// Version compare (wp_get_sites() deprecated)
			if( $this->wp_version < '4.6.0' ) {
				
				// Use old wp_get_sites() function
				$sites = wp_get_sites();
				$blog_ids = array();
				foreach($sites as $key => $value) {
					$site_ids[] = $value['blog_id'];
				}
			}
			else {
				
				// Use new get_sites() function
				$sites = get_sites();
				$blog_ids = array();
				foreach($sites as $key => $value) {
					$site_ids[] = $value->blog_id;
				}
			}
			
			// Loop each site id and populate options
			foreach ( $site_ids as $site_id ) {
				
				switch_to_blog( $site_id );
				$this->plugin_activate(); // Plugin activation function
				restore_current_blog();
			}
			
			// Get wp_sitemeta database values
			$options = get_site_option( 'wp_edit_pro_options_array' );
			$options = isset( $options ) && !empty( $options ) ? $options : array();
			$options_user_specific = get_user_meta( $current_user->ID, 'aaa_wp_edit_pro_user_meta', true );
			
			// Get plugin defaults
			$default_options = $this->options_default;
			$default_user_specific = $this->user_options_default;
			
			// Check if DB value exists.. if YES, then keep value.. if NO, then replace with plugin defaults
			foreach( $default_options as $key => $value ) {
				
				$options[$key] = isset( $options[$key] ) ? $options[$key] : $value;
			}
			foreach( $default_user_specific as $key => $value ) {
				
				$options_user_specific[$key] = isset( $options_user_specific[$key] ) ? $options_user_specific[$key] : $value;
			}
			
			// Create upload directories
			$upload_dir = wp_upload_dir();
			$upload_custom_fonts = $upload_dir['basedir'].'/wp_edit_pro/custom_fonts';  // Custom Fonts
			$upload_stylesheet = $upload_dir['basedir'].'/wp_edit_pro/custom_fonts/stylesheet';  // Custom Fonts Stylesheet
			$upload_custom_styles = $upload_dir['basedir'].'/wp_edit_pro/custom_styles';  // Custom Styles
			
			if (!is_dir($upload_custom_fonts)) wp_mkdir_p($upload_custom_fonts);
			if (!is_dir($upload_stylesheet)) wp_mkdir_p($upload_stylesheet);
			if (!is_dir($upload_custom_styles)) wp_mkdir_p($upload_custom_styles);
			
			// Set DB values
			update_site_option( 'wp_edit_pro_options_array', $options );
			update_user_meta( $current_user->ID, 'aaa_wp_edit_pro_user_meta', $options_user_specific );
			
			// Add redirect db option (removed after successful redirect)
			update_site_option( 'wp_edit_pro_activation_redirect', true );  
		}
		// Else plugin is being activated on a single blog
		else {
			
			// Plugin activation function
			$this->plugin_activate(); 
			
			// Add redirect option
			add_option( 'wp_edit_pro_activation_redirect', true );  
		}
	}
	
	// Plugin activate
	public function plugin_activate() {
		
		global $current_user;
		
		// Get DB values
		$options = $this->get_wp_edit_pro_option( 'wp_edit_pro_options_array' );
		$options_user_specific = get_user_meta( $current_user->ID, 'aaa_wp_edit_pro_user_meta', true );
		
		// Get plugin defaults
		$default_options = $this->options_default;
		$default_user_specific = $this->user_options_default;
		
		// Check if DB value exists.. if YES, then keep value.. if NO, then replace with plugin defaults
		foreach( $default_options as $key => $value ) {
			
			$options[$key] = isset( $options[$key] ) ? $options[$key] : $value;
		}
		// Do same for user meta
		foreach( $default_user_specific as $key => $value ) {
			
			$options_user_specific[$key] = isset( $options_user_specific[$key] ) ? $options_user_specific[$key] : $value;
		}
		
		// Add capabilities to super admin or admin role
		if( is_super_admin() == true ) {
			
			$role = get_role( 'administrator' );
			$role->add_cap( 'wp_edit_pro_user_administer_snidgets' );
		}
		else {
			
			$role = get_role( 'administrator' );
			$role->add_cap( 'wp_edit_pro_user_administer_snidgets' );
		}
		
		// Create upload directories
		$upload_dir = wp_upload_dir();
		$upload_custom_fonts = $upload_dir['basedir'].'/wp_edit_pro/custom_fonts';  // Custom Fonts
		$upload_stylesheet = $upload_dir['basedir'].'/wp_edit_pro/custom_fonts/stylesheet';  // Custom Fonts Stylesheet
		$upload_custom_styles = $upload_dir['basedir'].'/wp_edit_pro/custom_styles';  // Custom Styles
		
		if (!is_dir($upload_custom_fonts)) wp_mkdir_p($upload_custom_fonts);
		if (!is_dir($upload_stylesheet)) wp_mkdir_p($upload_stylesheet);
		if (!is_dir($upload_custom_styles)) wp_mkdir_p($upload_custom_styles);
		
		// Set DB values
		update_option( 'wp_edit_pro_options_array', $options );
		update_user_meta( $current_user->ID, 'aaa_wp_edit_pro_user_meta', $options_user_specific );
	}
	
	// New blog creation
	public function wpmu_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
		
		if ( $this->network_activated === true ) {
			
			$current_blog = get_current_blog_id();
			switch_to_blog( $blog_id );
			
			global $current_user;

			// Get DB values
			$options = get_option( 'wp_edit_pro_options_array' );
			$options_user_specific = get_user_meta( $current_user->ID, 'aaa_wp_edit_pro_user_meta', true );
			
			// Get plugin defaults
			$default_options = $this->options_default;
			$default_user_specific = $this->user_options_default;
			
			// Check if DB value exists.. if YES, then keep value.. if NO, then replace with plugin defaults
			foreach( $default_options as $key => $value ) {
				
				$options[$key] = isset( $options[$key] ) ? $options[$key] : $value;
			}
			// Do same for user meta
			foreach( $default_user_specific as $key => $value ) {
				
				$options_user_specific[$key] = isset( $options_user_specific[$key] ) ? $options_user_specific[$key] : $value;
			}
			
			// Create upload directories
			$upload_dir = wp_upload_dir();
			$upload_custom_fonts = $upload_dir['basedir'].'/wp_edit_pro/custom_fonts';  // Custom Fonts
			$upload_stylesheet = $upload_dir['basedir'].'/wp_edit_pro/custom_fonts/stylesheet';  // Custom Fonts Stylesheet
			$upload_custom_styles = $upload_dir['basedir'].'/wp_edit_pro/custom_styles';  // Custom Styles
			
			if (!is_dir($upload_custom_fonts)) wp_mkdir_p($upload_custom_fonts);
			if (!is_dir($upload_stylesheet)) wp_mkdir_p($upload_stylesheet);
			if (!is_dir($upload_custom_styles)) wp_mkdir_p($upload_custom_styles);
			
			// Set DB values
			update_option( 'wp_edit_pro_buttons', $options );
			update_user_meta( $current_user->ID, 'aaa_wp_edit_pro_user_meta', $options_user_specific );
			
			switch_to_blog( $current_blog );
		}
	}
	
	/*
	****************************************************************
	Admin init
	****************************************************************
	*/
	public function admin_init() {
		
		// Get current user and opts
		global $current_user;
		$opts_user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
		
		// Get plugin options
		$plugin_opts = $this->options_array;
		
		/*
		****************************************************************
		Register scripts and styles
		****************************************************************
		*/
		wp_register_script( 'jquery_confirm_script', $this->plugin_url . 'js/jquery-confirm.js' );  // jquery confirm plugin
		wp_register_style( 'jquery_confirm_style', $this->plugin_url . 'css/jquery-confirm.css' );  // jquery confirm styles
		
		wp_register_style('wpep_tmce_icons', includes_url().'js/tinymce/skins/lightgray/skin.min.css');  // Tinymce icons
		wp_register_style('wpep_fontawesome_icons', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');  // Fontawesome icons
		
		// Get jquery theme option
		$select_theme = isset($plugin_opts['wp_edit_pro_global']['jquery_theme']) ? $plugin_opts['wp_edit_pro_global']['jquery_theme'] : 'smoothness';
		wp_register_style('wpep_jquery_theme', '//code.jquery.com/ui/1.11.2/themes/'.$select_theme.'/jquery-ui.css');  // jQuery theme ui
		
		// jQuery tooltipster		
		wp_register_script('wpep_jquery_tooltipster', $this->plugin_url.'js/tooltipster.min.js');  // jquery tooltipster
		wp_register_style('wpep_jquery_tooltipster_styles', $this->plugin_url.'css/tooltipster.css');  // jquery tooltipster styles
		wp_register_style('wpep_jquery_tooltipster_styles_shadow', $this->plugin_url.'css/tooltipster_themes/tooltipster-shadow.css');  // jquery tooltipster styles shadow
		
		wp_register_script( 'main_page_script', $this->plugin_url . 'js/main_page.js' );  // Main page scripts
		wp_register_style( 'main_page_style', $this->plugin_url . 'css/main_page.css' );  // Main page styles
		
		wp_register_style( 'license_page_style', $this->plugin_url . 'css/license_page.css' );  // License page styles
		
		wp_register_script( 'main_page_script_user', $this->plugin_url . 'js/main_page_user.js' );  // User admin page scripts
		
		// Register scripts for ace editor (posts tab)
		wp_register_script( 'wpeditpro_ace_js', '//cdnjs.cloudflare.com/ajax/libs/ace/1.1.9/ace.js', '', '', true );
		wp_register_script( 'wpeditpro_ace_mode_css_js', '//cdnjs.cloudflare.com/ajax/libs/ace/1.1.9/mode-css.js', array('wpeditpro_ace_js'), '', true );
		wp_register_script( 'wpeditpro_ace_worker_css_js', '//cdnjs.cloudflare.com/ajax/libs/ace/1.1.9/worker-css.js', array('jquery', 'wpeditpro_ace_mode_css_js'), '', true );
		wp_register_script( 'wpeditpro_ace_mode_js_js', '//cdnjs.cloudflare.com/ajax/libs/ace/1.1.9/mode-javascript.js', array('wpeditpro_ace_js'), '', true );
		wp_register_script( 'wpeditpro_ace_worker_js_js', '//cdnjs.cloudflare.com/ajax/libs/ace/1.1.9/worker-javascript.js', array('jquery', 'wpeditpro_ace_mode_js_js'), '', true );
		wp_register_script( 'wpeditpro_cssparser', $this->plugin_url . 'js/cssparser.js', array('jquery'), '1.0', true );  // JSON CSS parser
		
		
		/*
		****************************************************************
		Activation redirection
		****************************************************************
		*/
		// Check for redirection option after plugin activation (redirect to license page)
		$status_opt = $this->get_wp_edit_pro_option( 'wp_edit_pro_license_status' );
		$status = isset( $status_opt ) ? $status_opt : 'invalid';
		
		if ( $status === 'single_act' || $status === 'single_ext_act' || $status === 'multi_act' || $status === 'dev_act' ) {
			
			$re_url = ( $this->network_activated == true ) ? admin_url('network/admin.php?page=wp_edit_pro_options') : admin_url('admin.php?page=wp_edit_pro_options');
		}
		else {
			
			$re_url = ( $this->network_activated == true ) ? admin_url('network/admin.php?page=wp_edit_pro_license') : admin_url('admin.php?page=wp_edit_pro_license');
		}
		
		if ( $this->get_wp_edit_pro_option( 'wp_edit_pro_activation_redirect', false ) ) {
			
			$this->delete_wp_edit_pro_option( 'wp_edit_pro_activation_redirect' );
			wp_redirect( $re_url );
		}
	}
	
	
	/*
	****************************************************************
	Admin init - User specific functions
	****************************************************************
	*/
	public function admin_init_user_specific_functions() {
		
		global $current_user;
		$plugin_opts = $this->options_array;
		$opts_user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
		
		// Add ID Column
		if(isset($opts_user_meta['id_column']) && $opts_user_meta['id_column'] === '1') {
				
			function wp_edit_pro_column_id($defaults){
				
				$defaults['wps_post_id'] =__('ID','wp_edit_pro');  
				return $defaults;
			}
			add_filter('manage_posts_columns', 'wp_edit_pro_column_id', 5);
			add_filter('manage_pages_columns', 'wp_edit_pro_column_id', 5);
			
			function wp_edit_pro_custom_column_id($column_name, $id){
				
				if($column_name === 'wps_post_id'){
					echo $id;
				}
			}
			add_action('manage_posts_custom_column', 'wp_edit_pro_custom_column_id', 5, 2);
			add_action('manage_pages_custom_column', 'wp_edit_pro_custom_column_id', 5, 2);
		}
		// Add Thumbnail Column
		if(isset($opts_user_meta['thumbnail_column']) && $opts_user_meta['thumbnail_column'] === '1') {
			
			if ( !function_exists('jwl_AddThumbColumn') && function_exists('add_theme_support') ) {
				  
				// First, check if current theme support post thumbnails
				function wpep_check_theme_support_post_thumbnails() {
					
					// If current theme does not support post thumbnails
					if(!current_theme_supports('post-thumbnails')) {
						
						// Add post thumbnail support
						add_theme_support('post-thumbnails', array( 'post', 'page' ) );
					}
				}
				add_action('after_theme_setup', 'wpep_check_theme_support_post_thumbnails');
				 
				function jwl_AddThumbColumn($cols) {
				 
					$cols['wpep_thumbnail'] = __('Thumbnail','wp_edit_pro');
					return $cols;
				}  
				  
				function jwl_AddThumbValue($column_name, $post_id) {
					
					if ('wpep_thumbnail' == $column_name) {
						
						$thumb = get_the_post_thumbnail($post_id, array(100,70));
						
						if ( isset($thumb) && $thumb ) { echo $thumb; }
						else { echo __('None','wp_edit_pro'); }
					}  
				} 
			  
				// for posts
				add_filter( 'manage_posts_columns', 'jwl_AddThumbColumn' );
				add_action( 'manage_posts_custom_column', 'jwl_AddThumbValue', 10, 2 );
				  
				// for pages
				add_filter( 'manage_pages_columns', 'jwl_AddThumbColumn' );
				add_action( 'manage_pages_custom_column', 'jwl_AddThumbValue', 10, 2 );
			}
		}
		// Hide Text Tab
		if(isset($opts_user_meta['hide_text_tab']) && $opts_user_meta['hide_text_tab'] === '1') {
			
			global $pagenow;
			if ($pagenow=='post.php' || $pagenow == 'post-new.php') {
				function wpep_jwl_user_hide_text_tab() {
					
					?>
					<style type="text/css"> 
						#excerpt-html {display: none !important;}  
						#content-html {display: none !important;} 
					</style>
					<?php
				}
				add_filter('admin_head','wpep_jwl_user_hide_text_tab');
			}
		}
		// Default Visual Tab
		if(isset($opts_user_meta['default_visual_tab']) && $opts_user_meta['default_visual_tab'] === '1') {
			
			add_filter( 'wp_default_editor', create_function('', 'return "tmce";') );
		}
		// Disable Dashboard Widget
		if(isset($opts_user_meta['dashboard_widget']) && $opts_user_meta['dashboard_widget'] != '1') {
			
			//************************************************************
			//  Enable WP Edit Pro Dashboard Widget
			//************************************************************
			add_action('wp_dashboard_setup', 'jwl_user_custom_dashboard_widgets');
			function jwl_user_custom_dashboard_widgets() {
				
				global $wp_meta_boxes;
				wp_add_dashboard_widget('jwl_user_tinymce_dashboard_widget', __('WP Edit PRO RSS Feed','wp_edit_pro'), 'jwl_user_tinymce_widget');
			}	
			function jwl_user_tinymce_widget() {
				
				$plugin_opts = get_wp_edit_pro_option_normal('wp_edit_pro_options_array');
				$jwl_widgets = $plugin_opts['wpep_dashboard_widget_items']; // Get the dashboard widget options
				$jwl_widget_id = 'jwl_user_tinymce_dashboard_widget'; // This must be the same ID we set in wp_add_dashboard_widget
				
				/* Check whether we have set the post count through the controls. If we didn't, set the default to 5 */
				$jwl_total_items = isset( $jwl_widgets[$jwl_widget_id] ) && isset( $jwl_widgets[$jwl_widget_id]['items'] ) ? absint( $jwl_widgets[$jwl_widget_id]['items'] ) : 5;
				
				// Get site ssl
				$protocol = is_ssl() === true ? 'https:' : 'http:';
				
				// Echo the output of the RSS Feed.
				echo '<p style="border-bottom:#000 1px solid;">Showing ('.$jwl_total_items.') Posts</p>';
				echo '<div class="rss-widget">';
					wp_widget_rss_output( $protocol . '//feeds.feedblitz.com/wpeditpro&x=1', array(
						'title' => '',
						'items' => $jwl_total_items,
						'show_summary' => 0,
						'show_author' => 0,
						'show_date' => 1
					));
				echo "</div>";
				echo '<p style="text-align:center;border-top: #000 1px solid;padding:5px;"><a href="https://wpeditpro.com/">WP Edit Pro</a> - Visual Wordpress Editor</p>';
			}
			
			//************************************************************
			//  Enable WP Edit Pro Knowledge Base Dashboard Widget
			//************************************************************
			add_action('wp_dashboard_setup', 'jwl_user_custom_dashboard_widgets_kb');
			function jwl_user_custom_dashboard_widgets_kb() {
				
				global $wp_meta_boxes;
				wp_add_dashboard_widget('jwl_user_tinymce_dashboard_widget_kb', __('WP Edit PRO Knowledge Base RSS Feed','wp_edit_pro'), 'jwl_user_tinymce_widget_kb');
			}	
			function jwl_user_tinymce_widget_kb() {
				
				$plugin_opts = get_wp_edit_pro_option_normal('wp_edit_pro_options_array');
				$jwl_widgets = $plugin_opts['wpep_dashboard_widget_items']; // Get the dashboard widget options
				$jwl_widget_id = 'jwl_user_tinymce_dashboard_widget_kb'; // This must be the same ID we set in wp_add_dashboard_widget
				
				/* Check whether we have set the post count through the controls. If we didn't, set the default to 5 */
				$jwl_total_items = isset( $jwl_widgets[$jwl_widget_id] ) && isset( $jwl_widgets[$jwl_widget_id]['items'] ) ? absint( $jwl_widgets[$jwl_widget_id]['items'] ) : 5;
				
				// Get site ssl
				$protocol = is_ssl() === true ? 'https:' : 'http:';
				
				// Echo the output of the RSS Feed.
				echo '<p style="border-bottom:#000 1px solid;">Showing ('.$jwl_total_items.') Posts</p>';
				echo '<div class="rss-widget">';
					wp_widget_rss_output( $protocol . '//feeds.feedblitz.com/learn&x=1', array(
						'title' => '',
						'items' => $jwl_total_items,
						'show_summary' => 0,
						'show_author' => 0,
						'show_date' => 1
					));
				echo "</div>";
				echo '<p style="text-align:center;border-top: #000 1px solid;padding:5px;"><a href="//learn.wpeditpro.com/">WP Edit Pro Knowledge Base</a> - Tutorials</p>';
			}
		}
		// Enable Post/Page Highlights
		if(isset($opts_user_meta['enable_highlights']) && $opts_user_meta['enable_highlights'] === '1') {
			
			function wpep_jwl_highlight_posts_status_colors(){
				
				global $current_user;
				$opts_user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
				?>
				<style type="text/css">
				.status-draft{background-color: <?php (isset($opts_user_meta['draft_highlight']) ? print $opts_user_meta['draft_highlight'] : print '#FFFFFF'); ?> !important;}
				.status-pending{background-color: <?php (isset($opts_user_meta['pending_highlight']) ? print $opts_user_meta['pending_highlight'] : print '#FFFFFF'); ?> !important;}
				.status-publish{background-color: <?php (isset($opts_user_meta['published_highlight']) ? print $opts_user_meta['published_highlight'] : print '#FFFFFF'); ?> !important;}
				.status-future{background-color: <?php (isset($opts_user_meta['future_highlight']) ? print $opts_user_meta['future_highlight'] : print '#FFFFFF'); ?> !important;}
				.status-private{background-color: <?php (isset($opts_user_meta['private_highlight']) ? print $opts_user_meta['private_highlight'] : print '#FFFFFF'); ?> !important;}
				</style>
				<?php
			}
			add_action('admin_head','wpep_jwl_highlight_posts_status_colors');
		}
	}
	
	
	
	
	/*
	****************************************************************
	Main Admin menu pages, scripts, styles
	****************************************************************
	*/
	public function main_admin_menu() {
		
		$plugin_opts = $this->options_array;
		
		// Check license status
		$status_opt = $this->get_wp_edit_pro_option( 'wp_edit_pro_license_status' );
		$status = isset( $status_opt ) ? $status_opt : 'invalid';
		
		// If we have a valid license
		if ( $status === 'single_act' || $status === 'single_ext_act' || $status === 'multi_act' || $status === 'dev_act' ) {
		
			$wpep_main_page = add_menu_page( 'WP Edit Pro', 'WP Edit Pro', 'manage_options', 'wp_edit_pro_options', array( $this, 'main_admin_menu_callback' ) );
			$wpep_main_page_sub = add_submenu_page( 'wp_edit_pro_options',  'Settings', 'Settings', 'manage_options', 'wp_edit_pro_options' );
			$wpep_license_page = add_submenu_page( 'wp_edit_pro_options', 'WP Edit Pro License', 'License', 'manage_options', 'wp_edit_pro_license', array( $this, 'license_page_callback' ) );
			
			// Get widgets option to see if we enable the widget builder sub-pages (only show if not network activated)
			if( $plugin_opts['wp_edit_pro_widgets']['widget_builder'] === '1' && $this->network_activated == false) {
					
				add_submenu_page('wp_edit_pro_options', __('All Snidgets','wp_edit_pro'), __('All Snidgets','wp_edit_pro'), 'manage_options', 'edit.php?post_type=jwl-utmce-widget');
				add_submenu_page('wp_edit_pro_options', __('Add New Snidget','wp_edit_pro'), __('Add New Snidget','wp_edit_pro'), 'manage_options', 'post-new.php?post_type=jwl-utmce-widget');
				add_submenu_page('wp_edit_pro_options', __('Snidget Categories','wp_edit_pro'), __('Snidget Categories','wp_edit_pro'), 'manage_options', 'edit-tags.php?taxonomy=category&post_type=jwl-utmce-widget');
				add_submenu_page('wp_edit_pro_options', __('Snidget Tags','wp_edit_pro'), __('Snidget Tags','wp_edit_pro'), 'manage_options', 'edit-tags.php?taxonomy=post_tag&post_type=jwl-utmce-widget');
			}
			
			// Add bonus page
			$wpep_bonus_page = add_submenu_page('wp_edit_pro_options', __('Bonus', 'wp_edit_pro'), __('Bonus', 'wp_edit_pro'), 'manage_options', 'wp_edit_pro_bonus', array($this, 'wpep_bonus_page_callback'));
		}
		// Else the license is invalid
		else {
			
			// Load license page
			$wpep_license_page = add_menu_page( __( 'WP Edit Pro','wp_edit_pro' ), __( 'WP Edit Pro','wp_edit_pro' ), 'manage_options', 'wp_edit_pro_license', array( $this, 'license_page_callback' ) );
		}
		
		// Conditionally load scripts and styles
		if( isset( $wpep_main_page ) ) {
			
			add_action( 'admin_print_scripts-' . $wpep_main_page, array( $this, 'main_page_script' ) );
			add_action( 'admin_print_styles-' . $wpep_main_page, array( $this, 'main_page_style' ) );
			add_action( 'load-' . $wpep_main_page, array( $this, 'main_admin_menu_save' ) );
		}
		
		if(isset($wpep_license_page)) {
			
			//add_action( 'admin_print_scripts-' . $wpep_license_page, array( $this, 'wpep_license_page_script' ) );  // Load scripts (Main Page)
			add_action( 'admin_print_styles-' . $wpep_license_page, array( $this, 'license_page_style' ) );  // Load styles (License Page)
			add_action( 'load-' . $wpep_license_page, array( $this, 'license_page_save' ) );  // Save page (License Page)
		}
		if(isset($wpep_bonus_page)) {
			
			add_action('admin_print_styles-'.$wpep_bonus_page, array($this, 'main_page_style'));  // Load styles (Bonus Page)
			add_action('load-'.$wpep_bonus_page, array($this, 'wpep_bonus_page_save'));  // Save page (Bonus Page)
		}
	}
	
	public function main_admin_menu_callback() {
		
		include 'helpers/main_admin_menu_callback.php';
	}
	
	public function main_page_script() {
		
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('jquery-ui-tooltip');
		wp_enqueue_script('jquery-ui-tabs'); 
		wp_enqueue_script('jquery-effects-core');
		wp_enqueue_script('jquery-effects-highlight');
		wp_enqueue_script('wp-color-picker'); 
		
		// Enqueue jquery tooltipster
		wp_enqueue_script('wpep_jquery_tooltipster');
		
		// jQuery confirm plugin
		wp_enqueue_script('jquery_confirm_script');
		
		// Only register these scripts on Posts tab
		$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'buttons';
		if($active_tab == 'styles' || $active_tab == 'posts') {  
				
			wp_enqueue_script( 'wpeditpro_ace_js' );
			wp_enqueue_script( 'wpeditpro_ace_mode_css_js' );
			wp_enqueue_script( 'wpeditpro_ace_worker_css_js' );
			wp_enqueue_script( 'wpeditpro_ace_mode_js_js' );
			wp_enqueue_script( 'wpeditpro_ace_worker_js_js' );
			
			wp_enqueue_script( 'wpeditpro_cssparser' );
		}
		
		// Enqueue, localize and register main page script
		wp_enqueue_script('main_page_script');
		$main_page_localize_vars = array( 
			'active_tab' => isset( $_GET['tab'] ) ? $_GET['tab'] : 'buttons', 
			'network_activated' => $this->network_activated == true ? 'true' : 'false',
			'blog_id' => $this->network_blog_id, 
			'image_url' => $this->plugin_url . 'css/images/' 
		);
		wp_localize_script( 'main_page_script', 'main_page_localize_vars', $main_page_localize_vars);
	}
	
	public function main_page_style() {
		
		wp_enqueue_style( 'jquery_confirm_style' );
		wp_enqueue_style('wp-color-picker');
		
		wp_enqueue_style('wpep_tmce_icons');
		wp_enqueue_style('wpep_fontawesome_icons'); 
		
		// jQuery theme
		wp_enqueue_style('wpep_jquery_theme'); 
		
		// Enqueue jquery tooltipster
		wp_enqueue_style('wpep_jquery_tooltipster_styles');
		wp_enqueue_style('wpep_jquery_tooltipster_styles_shadow');
		
		wp_enqueue_style( 'main_page_style' );
	}
	
	public function main_admin_menu_save() {
		
		include 'helpers/main_admin_menu_save.php';
	}
	
	
	/*
	****************************************************************
	Subsite Admin menu pages, scripts, styles
	****************************************************************
	*/
	public function admin_menu_subsite() {
		
		$wpep_main_page_subsite = add_menu_page( 'WP Edit Pro', 'WP Edit Pro', 'edit_posts', 'wp_edit_pro_options', array( $this, 'admin_menu_subsite_callback' ) );
		
		$plugin_opts = get_option('wp_edit_pro_options_array');
		$function_opts = $this->get_wp_edit_pro_function_opts( 'wp_edit_pro_options_array' );
		$widget_builder = isset( $function_opts['wp_edit_pro_widgets']['widget_builder'] ) ? $function_opts['wp_edit_pro_widgets']['widget_builder'] : '0';
			
		// Get widgets option to see if we enable the widget builder sub-pages
		if( isset( $widget_builder ) && $widget_builder == '1' && ( current_user_can('wp_edit_pro_user_administer_snidgets') || is_super_admin() == true ) ) {
				
			add_submenu_page('wp_edit_pro_options', __('All Snidgets','wp_edit_pro'), __('All Snidgets','wp_edit_pro'), 'wp_edit_pro_user_administer_snidgets', 'edit.php?post_type=jwl-utmce-widget');
			add_submenu_page('wp_edit_pro_options', __('Add New Snidget','wp_edit_pro'), __('Add New Snidget','wp_edit_pro'), 'wp_edit_pro_user_administer_snidgets', 'post-new.php?post_type=jwl-utmce-widget');
			add_submenu_page('wp_edit_pro_options', __('Snidget Categories','wp_edit_pro'), __('Snidget Categories','wp_edit_pro'), 'wp_edit_pro_user_administer_snidgets', 'edit-tags.php?taxonomy=category&post_type=jwl-utmce-widget');
			add_submenu_page('wp_edit_pro_options', __('Snidget Tags','wp_edit_pro'), __('Snidget Tags','wp_edit_pro'), 'wp_edit_pro_user_administer_snidgets', 'edit-tags.php?taxonomy=post_tag&post_type=jwl-utmce-widget');
		}
		
		// Conditionally load scripts and styles
		if( isset( $wpep_main_page_subsite ) ) {
			
			add_action( 'admin_print_styles-' . $wpep_main_page_subsite, array( $this, 'main_page_style' ) );
			add_action( 'admin_print_scripts-' . $wpep_main_page_subsite, array( $this, 'main_page_script_user' ) );
			add_action( 'load-'.$wpep_main_page_subsite, array($this, 'admin_menu_subsite_save') );  // Save page
		}
	}
	
	public function admin_menu_subsite_callback() {
		
		$main_opts = $this->options_array;
		$plugin_opts = get_option( 'wp_edit_pro_options_array' );
		$function_opts = $this->get_wp_edit_pro_function_opts( 'wp_edit_pro_options_array' );
		$widget_builder = isset( $function_opts['wp_edit_pro_widgets']['widget_builder'] ) ? $function_opts['wp_edit_pro_widgets']['widget_builder'] : '0';
		
		?>
        
        <div class="main_container">
				
            <h2><?php _e( 'Plugin is Network Activated', 'wp_edit_pro' ); ?></h2>
            
            <p><?php _e( 'The plugin is currently network activated. This means only the network site administrator has the ability to adjust plugin options.', 'wp_edit_pro' ); ?><br />
            <?php _e( 'If, however, the network administrator has allowed some of these options to be adjusted by sub-site administrators; they will appear below.', 'wp_edit_pro' ); ?></p> 
            
            <div class="metabox-holder">
                <div class="postbox">
                    <div class="inside">
                    
                        <h3><?php _e( 'Snidgets', 'wp_edit_pro' ); ?></h3>
                        
                        <?php
						if( is_super_admin() == true ) {
							
							?><div class="error wpep_info"><p><strong><?php _e( 'Super Administrator Message:', 'wp_edit_pro' ); ?></strong><br />
                            <?php _e( 'Super administrators can see the Snidget sub-menus whenever snidgets are enabled.', 'wp_edit_pro' ); ?><br />
                            <?php _e( 'Normal site administrators (or other roles)  may be allowed access via the appropriate setting in the network plugin administration.', 'wp_edit_pro' ); ?></p></div><?php
						}
						
						// If snidget subsite administration is allowed
						if( isset( $widget_builder ) && $widget_builder == '1' && ( current_user_can('wp_edit_pro_user_administer_snidgets') || is_super_admin() == true ) ) {
							
							?><p><?php _e( 'Snidget administration is allowed.', 'wp_edit_pro' ); ?><br /><?php
							_e( 'Please use the WP Edit Pro sub-menu items to administer snidgets.', 'wp_edit_pro' ); ?></p><?php
						}
						else {
							
							?><p><?php _e( 'Snidget administration is not allowed.', 'wp_edit_pro' ); ?></p><?php
						}
						?>
                    </div>
                </div>
            </div>
            
            <div class="metabox-holder">
                <div class="postbox">
                    <div class="inside">
                    
                    	<h3><?php _e( 'User Specific Options', 'wp_edit_pro' ); ?></h3>
						
                        <?php
						if( is_super_admin() == true ) {
							
							?><div class="error wpep_info"><p><strong><?php _e( 'Super Administrator Message:', 'wp_edit_pro' ); ?></strong><br />
                            <?php _e( 'Super administrators can edit user options anytime.', 'wp_edit_pro' ); ?><br />
                            <?php _e( 'Normal site administrators (or other roles) may be allowed access via the appropriate setting in the network plugin administration.', 'wp_edit_pro' ); ?></p></div><?php
						}
                        
						// If snidget subsite administration is allowed
						if( current_user_can('wp_edit_pro_user_administer_user_settings') ) {
							
							?><p><?php _e( 'User Options Allowed.', 'wp_edit_pro' ); ?></p><hr /><?php
							
							global $current_user;
							$options_user_specific_user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
							
							$id_column = isset($options_user_specific_user_meta['id_column']) && $options_user_specific_user_meta['id_column'] === '1' ? 'checked="checked"' : '';
							$thumbnail_column = isset($options_user_specific_user_meta['thumbnail_column']) && $options_user_specific_user_meta['thumbnail_column'] === '1' ? 'checked="checked"' : '';
							$hide_text_tab = isset($options_user_specific_user_meta['hide_text_tab']) && $options_user_specific_user_meta['hide_text_tab'] === '1' ? 'checked="checked"' : '';
							$default_visual_tab = isset($options_user_specific_user_meta['default_visual_tab']) && $options_user_specific_user_meta['default_visual_tab'] === '1' ? 'checked="checked"' : '';
							$dashboard_widget = isset($options_user_specific_user_meta['dashboard_widget']) && $options_user_specific_user_meta['dashboard_widget'] === '1' ? 'checked="checked"' : '';
							
							$enable_highlights = isset($options_user_specific_user_meta['enable_highlights']) && $options_user_specific_user_meta['enable_highlights'] === '1' ? 'checked="checked"' : '';
							$draft_highlight = isset($options_user_specific_user_meta['draft_highlight']) ? $options_user_specific_user_meta['draft_highlight'] : '#FFFFFF';
							$pending_highlight = isset($options_user_specific_user_meta['pending_highlight'])  ? $options_user_specific_user_meta['pending_highlight'] : '#FFFFFF';
							$published_highlight = isset($options_user_specific_user_meta['published_highlight'])  ? $options_user_specific_user_meta['published_highlight'] : '#FFFFFF';
							$future_highlight = isset($options_user_specific_user_meta['future_highlight'])  ? $options_user_specific_user_meta['future_highlight'] : '#FFFFFF';
							$private_highlight = isset($options_user_specific_user_meta['private_highlight'])  ? $options_user_specific_user_meta['private_highlight'] : '#FFFFFF';
							
							echo '<h3>';
								_e( 'General Options', 'wp_edit_pro' );
							echo '</h3>';
							?>
							
                            <form method="post" action="">
							<table cellpadding="8">
							<tbody>
							<tr><td><?php _e('ID Column','wp_edit_pro'); ?></td>
								<td>
								<input id="id_column" type="checkbox" value="1" name="wp_edit_pro_user_specific[id_column]" <?php echo $id_column; ?> />
								<label for="id_column"><?php _e('Adds a column to post/page list view for displaying the post/page ID.','wp_edit_pro'); ?></label>
								</td>
							</tr>
							<tr><td><?php _e('Thumbnail Column','wp_edit_pro'); ?></td>
								<td>
								<input id="thumbnail_column" type="checkbox" value="1" name="wp_edit_pro_user_specific[thumbnail_column]" <?php echo $thumbnail_column; ?> />
								<label for="thumbnail_column"><?php _e('Adds a column to post/page list view for displaying thumbnails.','wp_edit_pro'); ?></label>
								</td>
							</tr>
							<tr><td><?php _e('Hide TEXT Tab','wp_edit_pro'); ?></td>
								<td>
								<input id="hide_text_tab" type="checkbox" value="1" name="wp_edit_pro_user_specific[hide_text_tab]" <?php echo $hide_text_tab; ?> />
								<label for="hide_text_tab"><?php _e('Hide the editor TEXT tab from view.','wp_edit_pro'); ?></label>
								</td>
							</tr>
							<tr><td><?php _e('Default VISUAL Tab','wp_edit_pro'); ?></td>
								<td>
								<input id="default_visual_tab" type="checkbox" value="1" name="wp_edit_pro_user_specific[default_visual_tab]" <?php echo $default_visual_tab; ?> />
								<label for="default_visual_tab"><?php _e('Always display VISUAL tab when editor loads.','wp_edit_pro'); ?></label>
								</td>
							</tr>
							<tr><td><?php _e('Disable Dashboard Widget','wp_edit_pro'); ?></td>
								<td>
								<input id="dashboard_widget" type="checkbox" value="1" name="wp_edit_pro_user_specific[dashboard_widget]" <?php echo $dashboard_widget; ?> />
								<label for="dashboard_widget"><?php _e('Disables WP Edit Pro News Feed dashboard widget.','wp_edit_pro'); ?></label>
								</td>
							</tr>
                            </tbody>
                            </table>
                            
                            <?php 
							echo '<h3>';
								_e( 'Post/Page Highlight Options', 'wp_edit_pro' );
							echo '</h3>';
							?>
                            
                            <table cellpadding="8">
							<tbody>
                            <tr><td><?php _e('Enable Highlights','wp_edit_pro'); ?></td>
                            <td>
                            <input id="enable_highlights" type="checkbox" value="1" name="wp_edit_pro_user_specific[enable_highlights]" <?php echo $enable_highlights; ?> />
                            <label for="enable_highlights"><?php _e('Enable the Highlight Options below.','wp_edit_pro'); ?></label>
                            </td>
                            </tr>
                            <tr><td><?php _e('Draft Highlight','wp_edit_pro'); ?></td>
                                <td class="jwl_user_cell">
                                <input id="draft_highlight" type="text" name="wp_edit_pro_user_specific[draft_highlight]" class="color_field" value="<?php echo $draft_highlight; ?>" />
                                </td>
                            </tr>
                            <tr><td><?php _e('Pending Highlight','wp_edit_pro'); ?></td>
                                <td class="jwl_user_cell">
                                <input id="pending_highlight" type="text" name="wp_edit_pro_user_specific[pending_highlight]" class="color_field" value="<?php echo $pending_highlight; ?>" />
                                </td>
                            </tr>
                            <tr><td><?php _e('Published Highlight','wp_edit_pro'); ?></td>
                                <td class="jwl_user_cell">
                                <input id="published_highlight" type="text" name="wp_edit_pro_user_specific[published_highlight]" class="color_field" value="<?php echo $published_highlight; ?>" />
                                </td>
                            </tr>
                            <tr><td><?php _e('Future Highlight','wp_edit_pro'); ?></td>
                                <td class="jwl_user_cell">
                                <input id="future_highlight" type="text" name="wp_edit_pro_user_specific[future_highlight]" class="color_field" value="<?php echo $future_highlight; ?>" />
                                </td>
                            </tr>
                            <tr><td><?php _e('Private Highlight','wp_edit_pro'); ?></td>
                                <td class="jwl_user_cell">
                                <input id="private_highlight" type="text" name="wp_edit_pro_user_specific[private_highlight]" class="color_field" value="<?php echo $private_highlight; ?>" />
                                </td>
                            </tr>
							</tbody>
							</table>
                            <br /><br />
                            <input type="submit" value="<?php _e('Save User Options','wp_edit_pro'); ?>" class="button button-primary" id="submit_user_specific" name="submit_user_specific">
                            </form>
							<?php
						}
						else {
							
							?><p><?php _e( 'User Options Not Allowed.', 'wp_edit_pro' ); ?></p><?php
						}
						?>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}
	
	public function main_page_script_user() {
		
		wp_enqueue_script('wp-color-picker'); 
		wp_enqueue_script('main_page_script_user');
	}
	
	public function admin_menu_subsite_save() {
		
		if(isset($_POST['submit_user_specific'])) {
			
			global $current_user; 
			$options_user_specific_user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
			
			// Get page values
			$post_vars = isset($_POST['wp_edit_pro_user_specific']) ? $_POST['wp_edit_pro_user_specific'] : '';
			
			$options_user_specific_user_meta['id_column'] = isset($post_vars['id_column']) ? '1' : '0';
			$options_user_specific_user_meta['thumbnail_column'] = isset($post_vars['thumbnail_column']) ? '1' : '0';
			$options_user_specific_user_meta['hide_text_tab'] = isset($post_vars['hide_text_tab']) ? '1' : '0';
			$options_user_specific_user_meta['default_visual_tab'] = isset($post_vars['default_visual_tab']) ? '1' : '0';
			$options_user_specific_user_meta['dashboard_widget'] = isset($post_vars['dashboard_widget']) ? '1' : '0';
			
			$options_user_specific_user_meta['enable_highlights'] = isset($post_vars['enable_highlights']) ? '1' : '0';
			$options_user_specific_user_meta['draft_highlight'] = isset($post_vars['draft_highlight']) ? $post_vars['draft_highlight'] : '';
			$options_user_specific_user_meta['pending_highlight'] = isset($post_vars['pending_highlight']) ? $post_vars['pending_highlight'] : '';
			$options_user_specific_user_meta['published_highlight'] = isset($post_vars['published_highlight']) ? $post_vars['published_highlight'] : '';
			$options_user_specific_user_meta['future_highlight'] = isset($post_vars['future_highlight']) ? $post_vars['future_highlight'] : '';
			$options_user_specific_user_meta['private_highlight'] = isset($post_vars['private_highlight']) ? $post_vars['private_highlight'] : '';
			
			update_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', $options_user_specific_user_meta);  // Update user meta
			
			function wpep_user_specific_saved_notice_user_page(){
		
				echo '<div class="updated"><p>';
					_e('User options successfully saved.','wp_edit_pro');
				echo '</p></div>';
			}
			add_action('admin_notices', 'wpep_user_specific_saved_notice_user_page');  // Only needed for sub sites
		}
	}
	
	
	/*
	****************************************************************
	Subsite Non-Admin menu pages, scripts, styles
	****************************************************************
	*/
	public function admin_menu_subsite_user() {
		
		if( ! current_user_can('manage_options') ) {
		
			$wpep_main_page_user = add_menu_page( 'WP Edit Pro', 'WP Edit Pro', 'edit_posts', 'wp_edit_pro_options', array( $this, 'main_page_user_callback' ) );
			
			$plugin_opts = get_option('wp_edit_pro_options_array');
			$widget_builder = isset( $plugin_opts['wp_edit_pro_widgets']['widget_builder'] ) ? $plugin_opts['wp_edit_pro_widgets']['widget_builder'] : '0';
				
			// Get widgets option to see if we enable the widget builder sub-pages
			if( isset( $widget_builder ) && $widget_builder == '1' && ( current_user_can('wp_edit_pro_user_administer_snidgets') || is_super_admin() == true ) ) {
					
				add_submenu_page('wp_edit_pro_options', __('All Snidgets','wp_edit_pro'), __('All Snidgets','wp_edit_pro'), 'wp_edit_pro_user_administer_snidgets', 'edit.php?post_type=jwl-utmce-widget');
				add_submenu_page('wp_edit_pro_options', __('Add New Snidget','wp_edit_pro'), __('Add New Snidget','wp_edit_pro'), 'wp_edit_pro_user_administer_snidgets', 'post-new.php?post_type=jwl-utmce-widget');
				add_submenu_page('wp_edit_pro_options', __('Snidget Categories','wp_edit_pro'), __('Snidget Categories','wp_edit_pro'), 'wp_edit_pro_user_administer_snidgets', 'edit-tags.php?taxonomy=category&post_type=jwl-utmce-widget');
				add_submenu_page('wp_edit_pro_options', __('Snidget Tags','wp_edit_pro'), __('Snidget Tags','wp_edit_pro'), 'wp_edit_pro_user_administer_snidgets', 'edit-tags.php?taxonomy=post_tag&post_type=jwl-utmce-widget');
			}
			
			// Conditionally load scripts and styles
			if( isset( $wpep_main_page_user ) ) {
				
				add_action( 'admin_print_styles-' . $wpep_main_page_user, array( $this, 'main_page_style' ) );
				add_action( 'admin_print_scripts-' . $wpep_main_page_user, array( $this, 'main_page_script_user' ) );
				add_action( 'load-'.$wpep_main_page_user, array($this, 'main_page_user_save') );  // Save page
			}
		}
	}
	
	public function main_page_user_callback() { 
			
		$plugin_opts = get_option( 'wp_edit_pro_options_array' );
		$function_opts = $this->get_wp_edit_pro_function_opts( 'wp_edit_pro_options_array' );
		
		$widget_builder = isset( $plugin_opts['wp_edit_pro_widgets']['widget_builder'] ) ? $plugin_opts['wp_edit_pro_widgets']['widget_builder'] : '0';
		
		?>
		<div class="main_container">
				
            <h2><?php _e( 'User Settings Page', 'wp_edit_pro' ); ?></h2>
            
            <p><?php _e( 'The site administrator may have enabled some of the options below.', 'wp_edit_pro' ); ?></p> 
            
            <div class="metabox-holder">
                <div class="postbox">
                    <div class="inside">
                    
                        <h3><?php _e( 'Snidgets', 'wp_edit_pro' ); ?></h3>
                        
                        <?php
						// If snidget subsite administration is allowed
						if( current_user_can('wp_edit_pro_user_administer_snidgets') ) {
							
							?><p><?php _e( 'Snidget administration is allowed.', 'wp_edit_pro' ); ?><br /><?php
							_e( 'Please use the WP Edit Pro sub-menu items to administer snidgets.', 'wp_edit_pro' ); ?></p><?php
						}
						else {
							
							?><p><?php _e( 'Snidget administration is not allowed.', 'wp_edit_pro' ); ?></p><?php
						}
						?>
                    </div>
                </div>
            </div>
            
            <div class="metabox-holder">
                <div class="postbox">
                    <div class="inside">
                    
                    	<h3><?php _e( 'User Specific Options', 'wp_edit_pro' ); ?></h3>
                        
                        <?php
						// If snidget subsite administration is allowed
						if( current_user_can('wp_edit_pro_user_administer_user_settings') || is_super_admin() == true ) {
							
							?><p><?php _e( 'User Options Allowed.', 'wp_edit_pro' ); ?></p><?php
							
							global $current_user;
							$options_user_specific_user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
							
							$id_column = isset($options_user_specific_user_meta['id_column']) && $options_user_specific_user_meta['id_column'] === '1' ? 'checked="checked"' : '';
							$thumbnail_column = isset($options_user_specific_user_meta['thumbnail_column']) && $options_user_specific_user_meta['thumbnail_column'] === '1' ? 'checked="checked"' : '';
							$hide_text_tab = isset($options_user_specific_user_meta['hide_text_tab']) && $options_user_specific_user_meta['hide_text_tab'] === '1' ? 'checked="checked"' : '';
							$default_visual_tab = isset($options_user_specific_user_meta['default_visual_tab']) && $options_user_specific_user_meta['default_visual_tab'] === '1' ? 'checked="checked"' : '';
							$dashboard_widget = isset($options_user_specific_user_meta['dashboard_widget']) && $options_user_specific_user_meta['dashboard_widget'] === '1' ? 'checked="checked"' : '';
							
							$enable_highlights = isset($options_user_specific_user_meta['enable_highlights']) && $options_user_specific_user_meta['enable_highlights'] === '1' ? 'checked="checked"' : '';
							$draft_highlight = isset($options_user_specific_user_meta['draft_highlight']) ? $options_user_specific_user_meta['draft_highlight'] : '#FFFFFF';
							$pending_highlight = isset($options_user_specific_user_meta['pending_highlight'])  ? $options_user_specific_user_meta['pending_highlight'] : '#FFFFFF';
							$published_highlight = isset($options_user_specific_user_meta['published_highlight'])  ? $options_user_specific_user_meta['published_highlight'] : '#FFFFFF';
							$future_highlight = isset($options_user_specific_user_meta['future_highlight'])  ? $options_user_specific_user_meta['future_highlight'] : '#FFFFFF';
							$private_highlight = isset($options_user_specific_user_meta['private_highlight'])  ? $options_user_specific_user_meta['private_highlight'] : '#FFFFFF';
							
							echo '<h3>';
								_e( 'General Options', 'wp_edit_pro' );
							echo '</h3>';
							?>
							
                            <form method="post" action="">
							<table cellpadding="8">
							<tbody>
							<tr><td><?php _e('ID Column','wp_edit_pro'); ?></td>
								<td>
								<input id="id_column" type="checkbox" value="1" name="wp_edit_pro_user_specific[id_column]" <?php echo $id_column; ?> />
								<label for="id_column"><?php _e('Adds a column to post/page list view for displaying the post/page ID.','wp_edit_pro'); ?></label>
								</td>
							</tr>
							<tr><td><?php _e('Thumbnail Column','wp_edit_pro'); ?></td>
								<td>
								<input id="thumbnail_column" type="checkbox" value="1" name="wp_edit_pro_user_specific[thumbnail_column]" <?php echo $thumbnail_column; ?> />
								<label for="thumbnail_column"><?php _e('Adds a column to post/page list view for displaying thumbnails.','wp_edit_pro'); ?></label>
								</td>
							</tr>
							<tr><td><?php _e('Hide TEXT Tab','wp_edit_pro'); ?></td>
								<td>
								<input id="hide_text_tab" type="checkbox" value="1" name="wp_edit_pro_user_specific[hide_text_tab]" <?php echo $hide_text_tab; ?> />
								<label for="hide_text_tab"><?php _e('Hide the editor TEXT tab from view.','wp_edit_pro'); ?></label>
								</td>
							</tr>
							<tr><td><?php _e('Default VISUAL Tab','wp_edit_pro'); ?></td>
								<td>
								<input id="default_visual_tab" type="checkbox" value="1" name="wp_edit_pro_user_specific[default_visual_tab]" <?php echo $default_visual_tab; ?> />
								<label for="default_visual_tab"><?php _e('Always display VISUAL tab when editor loads.','wp_edit_pro'); ?></label>
								</td>
							</tr>
							<tr><td><?php _e('Disable Dashboard Widget','wp_edit_pro'); ?></td>
								<td>
								<input id="dashboard_widget" type="checkbox" value="1" name="wp_edit_pro_user_specific[dashboard_widget]" <?php echo $dashboard_widget; ?> />
								<label for="dashboard_widget"><?php _e('Disables WP Edit Pro News Feed dashboard widget.','wp_edit_pro'); ?></label>
								</td>
							</tr>
                            </tbody>
                            </table>
                            
                            <?php 
							echo '<h3>';
								_e( 'Post/Page Highlight Options', 'wp_edit_pro' );
							echo '</h3>';
							?>
                            
                            <table cellpadding="8">
							<tbody>
                            <tr><td><?php _e('Enable Highlights','wp_edit_pro'); ?></td>
                            <td>
                            <input id="enable_highlights" type="checkbox" value="1" name="wp_edit_pro_user_specific[enable_highlights]" <?php echo $enable_highlights; ?> />
                            <label for="enable_highlights"><?php _e('Enable the Highlight Options below.','wp_edit_pro'); ?></label>
                            </td>
                            </tr>
                            <tr><td><?php _e('Draft Highlight','wp_edit_pro'); ?></td>
                                <td class="jwl_user_cell">
                                <input id="draft_highlight" type="text" name="wp_edit_pro_user_specific[draft_highlight]" class="color_field" value="<?php echo $draft_highlight; ?>" />
                                </td>
                            </tr>
                            <tr><td><?php _e('Pending Highlight','wp_edit_pro'); ?></td>
                                <td class="jwl_user_cell">
                                <input id="pending_highlight" type="text" name="wp_edit_pro_user_specific[pending_highlight]" class="color_field" value="<?php echo $pending_highlight; ?>" />
                                </td>
                            </tr>
                            <tr><td><?php _e('Published Highlight','wp_edit_pro'); ?></td>
                                <td class="jwl_user_cell">
                                <input id="published_highlight" type="text" name="wp_edit_pro_user_specific[published_highlight]" class="color_field" value="<?php echo $published_highlight; ?>" />
                                </td>
                            </tr>
                            <tr><td><?php _e('Future Highlight','wp_edit_pro'); ?></td>
                                <td class="jwl_user_cell">
                                <input id="future_highlight" type="text" name="wp_edit_pro_user_specific[future_highlight]" class="color_field" value="<?php echo $future_highlight; ?>" />
                                </td>
                            </tr>
                            <tr><td><?php _e('Private Highlight','wp_edit_pro'); ?></td>
                                <td class="jwl_user_cell">
                                <input id="private_highlight" type="text" name="wp_edit_pro_user_specific[private_highlight]" class="color_field" value="<?php echo $private_highlight; ?>" />
                                </td>
                            </tr>
							</tbody>
							</table>
                            <br /><br />
                            <input type="submit" value="<?php _e('Save User Options','wp_edit_pro'); ?>" class="button button-primary" id="submit_user_specific" name="submit_user_specific">
                            </form>
							<?php
						}
						else {
							
							?><p><?php _e( 'User Options Not Allowed.', 'wp_edit_pro' ); ?></p><?php
						}
						?>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}
	
	public function main_page_user_save() {
		
		if(isset($_POST['submit_user_specific'])) {
			
			global $current_user; 
			$options_user_specific_user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
			
			// Get page values
			$post_vars = isset($_POST['wp_edit_pro_user_specific']) ? $_POST['wp_edit_pro_user_specific'] : '';
			
			$options_user_specific_user_meta['id_column'] = isset($post_vars['id_column']) ? '1' : '0';
			$options_user_specific_user_meta['thumbnail_column'] = isset($post_vars['thumbnail_column']) ? '1' : '0';
			$options_user_specific_user_meta['hide_text_tab'] = isset($post_vars['hide_text_tab']) ? '1' : '0';
			$options_user_specific_user_meta['default_visual_tab'] = isset($post_vars['default_visual_tab']) ? '1' : '0';
			$options_user_specific_user_meta['dashboard_widget'] = isset($post_vars['dashboard_widget']) ? '1' : '0';
			
			$options_user_specific_user_meta['enable_highlights'] = isset($post_vars['enable_highlights']) ? '1' : '0';
			$options_user_specific_user_meta['draft_highlight'] = isset($post_vars['draft_highlight']) ? $post_vars['draft_highlight'] : '';
			$options_user_specific_user_meta['pending_highlight'] = isset($post_vars['pending_highlight']) ? $post_vars['pending_highlight'] : '';
			$options_user_specific_user_meta['published_highlight'] = isset($post_vars['published_highlight']) ? $post_vars['published_highlight'] : '';
			$options_user_specific_user_meta['future_highlight'] = isset($post_vars['future_highlight']) ? $post_vars['future_highlight'] : '';
			$options_user_specific_user_meta['private_highlight'] = isset($post_vars['private_highlight']) ? $post_vars['private_highlight'] : '';
			
			update_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', $options_user_specific_user_meta);  // Update user meta
			
			function wpep_user_specific_saved_notice_user_page(){
		
				echo '<div class="updated"><p>';
					_e('User options successfully saved.','wp_edit_pro');
				echo '</p></div>';
			}
			add_action('admin_notices', 'wpep_user_specific_saved_notice_user_page');  // Only needed for sub sites
		}
	}
	
	
	//*********************************************
	// Bonus Page
	//*********************************************
	public function wpep_bonus_page_callback() {
		
		// Is File Manager installed?
		$file = plugins_url('/wp_edit_pro_responsive_filemanager/main_fm.php');
		$response = wp_remote_head($file, array('timeout' => 10));
		$accepted_status_codes = array(200, 301, 302);
		
		if (!is_wp_error($response) && in_array(wp_remote_retrieve_response_code($response), $accepted_status_codes)) {
			$is_wpep_fm_installed = true;
		} else {
			$is_wpep_fm_installed = false;
		}
		
		// Is File Manager active?
		if($this->network_activated === true) {
			$is_wpep_fm_active = (is_plugin_active_for_network('wp_edit_pro_responsive_filemanager/main_fm.php')) ? true : false;
		}
		else {
			$is_wpep_fm_active = (is_plugin_active('wp_edit_pro_responsive_filemanager/main_fm.php')) ? true : false;
		}
		
		// Set table values
		$install_button = ($is_wpep_fm_installed === true) ? '<input type="submit" class="button-secondary" name="uninstall_wpep_fm" value="'.__('Uninstall', 'wp_edit_pro').'" />'.wp_nonce_field('uninstall-wpep').'<br /><span class="bonus_installed">'.__('Installed', 'wp_edit_pro').'</span>' : '<input type="submit" class="button-secondary" name="install_wpep_fm" value="'.__('Install', 'wp_edit_pro').'" /><br /><span class="bonus_not_installed">'.__('Not Installed', 'wp_edit_pro').'</span>';
		
		// Render Page
		echo '<div class="main_container" style="margin-top:20px;">';
		
			?><h2><?php _e('Bonus Page','wp_edit_pro'); ?></h2>
			<p><?php _e('What premium plugin would be complete without a Bonus Page?','wp_edit_pro'); ?></p>
					
			<div class="metabox-holder">
			
				<div class="postbox">
					<h3><span><?php _e('Additional Addons', 'wp_edit_pro'); ?></span></h3>
					<div class="inside">
						
						<p><?php _e('The following addons can be installed for WP Edit Pro.', 'wp_edit_pro'); ?><br />
						<?php printf(__('You may manage them here; or from the admin %s page.', 'wp_edit_pro'), '<a href="'.admin_url().'plugins.php">'.__('plugins', 'wp_edit_pro').'</a>'); ?></p>
						<form method="post" action="">
						<div class="bonus_row">
							<div class="bonus_col bonus_col_1"><span class="bonus_row_title"><?php _e('Addon', 'wp_edit_pro'); ?></span></div>
							<div class="bonus_col bonus_col_2"><span class="bonus_row_title"><?php _e('Install', 'wp_edit_pro'); ?></span></div>
							<div style="clear: left;"></div>
						</div>
						<div class="bonus_row">
							<div class="bonus_col bonus_col_1">
								<?php _e('WP Edit Pro File Manager', 'wp_edit_pro'); ?><br />
								<a target="_blank" href="http://learn.wpeditpro.com/wp-edit-pro-file-manager/"><?php _e('Learn More...', 'wp_edit_pro'); ?></a>
							</div>
							<div class="bonus_col bonus_col_2"><?php echo $install_button; ?></div>
							<div style="clear: left;"></div>
						</div>
						</form>
					</div><!-- .inside -->
				</div><!-- .postbox -->
			</div>
		<?php 
		echo '</div>';
	}
	
	public function wpep_bonus_page_save() {
		
		//******************************************
		// Check url paramaters for alert notices
		//******************************************
		
		// If we have installed file manager; alert user
		if(isset($_GET['install_wpep_fm']) && ($_GET['install_wpep_fm'] == 'true')) {
			
			function wpep_fm_installed_notice(){
				
				echo '<div class="updated"><p>';
				_e('WP Edit Pro File Manager has been successfully installed.','wp_edit_pro');
				echo '</p><p>';
				_e('Please visit the "Plugins" admin page to activate.','wp_edit_pro');
				echo '</p></div>';
			}
			add_action($this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_fm_installed_notice');
		}
		
		// If we have uninstalled file manager; alert user
		if(isset($_GET['uninstall_wpep_fm']) && ($_GET['uninstall_wpep_fm'] == 'true')) {
			
			function wpeditpro_fm_uninstall_notice(){
				
				echo '<div class="updated"><p>';
				_e('WP Edit Pro File Manager successfully uninstalled.','wp_edit_pro');
				echo '</p></div>';
			}
			add_action($this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpeditpro_fm_uninstall_notice');
		}
		
		//******************************************
		// Functions for managing downloads
		//******************************************
		// Call this function using an array ($plugins)	
		function wpeditpro_get_plugins($plugins) {
			
			$args = array( 'path' => ABSPATH.'wp-content/plugins/', 'preserve_zip' => false );
			foreach($plugins as $plugin) {
				
				wpeditpro_plugin_download($plugin['path'], $args['path'].$plugin['name'].'.zip');
				wpeditpro_plugin_unpack($args, $args['path'].$plugin['name'].'.zip');
			}
		}
		// Download plugin and create placeholder
		function wpeditpro_plugin_download($url, $path) {
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			$data = curl_exec($ch);
			curl_close($ch);
			if(file_put_contents($path, $data)) {
				return true;
			} else {
				return false;
			}
		}
		// Unpack plugin .zip file
		function wpeditpro_plugin_unpack($args, $target) {
			
			if($zip = zip_open($target)) {
				
				while($entry = zip_read($zip)) {
					
					$is_file = substr(zip_entry_name($entry), -1) == '/' ? false : true;
					$file_path = $args['path'].zip_entry_name($entry);
					
					if($is_file) {
						
						if(zip_entry_open($zip,$entry,"r")) {
							
							$fstream = zip_entry_read($entry, zip_entry_filesize($entry));
							file_put_contents($file_path, $fstream );
							chmod($file_path, 0777);
						}
						zip_entry_close($entry);
					} else {
						
						if(zip_entry_name($entry)) {
							if (!file_exists($file_path)) {  // Added to make sure directory does not exist (file exists error)
							
								mkdir($file_path);
								chmod($file_path, 0777);
							}
						}
					}
				}
				zip_close($zip);
			}
			if($args['preserve_zip'] === false) {
				
				unlink($target);
			}
		}
		// Create function to recursively delete directory contents and remove subdirectories (for uninstalling)
		function wpeditpro_delete_dir($path) {
			
			if (is_dir($path) === true) {
				
				$files = array_diff(scandir($path), array('.', '..'));
		
				foreach ($files as $file) {
					wpeditpro_delete_dir(realpath($path) . '/' . $file);
				}
				return rmdir($path);
			}
			else if (is_file($path) === true) {
				
				return unlink($path);
			}
			return false;
		}
		
		//******************************************
		// Actions for File Manager admin buttons
		//******************************************
		// If we are installing File Manager
		if(isset($_POST['install_wpep_fm'])) {
			
			// Get user IP
			$user_ip = isset($_POST['wp_edit_pro_license_ip']) ? $_POST['wp_edit_pro_license_ip'] : 'Unknown';
			// Call API function to get $response
			$response = $this->wp_edit_pro_api_call('update_check', $user_ip);
			// Decode the license data
			$license_data_update_check = json_decode( wp_remote_retrieve_body( $response ) );
			
			// If the license check is successful
			if ($license_data_update_check->Status === 'true') {
			
				// Create array
				$plugins_wpep_fm = array(array('name' => 'wp_edit_pro_responsive_filemanager', 'path' => 'https://wpeditpro.com/plugin_bonus/wp_edit_pro_responsive_filemanager.zip', 'install' => 'wp_edit_pro_responsive_filemanager/main_fm.php'));
				
				// Call installation function
				wpeditpro_get_plugins($plugins_wpep_fm);
				
				($this->network_activated == true) ?  wp_redirect(admin_url('network/admin.php?page=wp_edit_pro_bonus&install_wpep_fm=true')) : wp_redirect(admin_url('admin.php?page=wp_edit_pro_bonus&install_wpep_fm=true')); 
			}
			// Else license check was unsuccessful
			else {
				
				function wpeditpro_filemanager_invalid_license(){
				
					echo '<div class="error"><p>';
					_e('WP Edit Pro is not licensed correctly.  Please verify your WP Edit Pro license; or contact us for assistance.','wp_edit_pro');
					echo '</p></div>';
				}
				add_action($this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpeditpro_filemanager_invalid_license');
			}
		}
		// If we are uninstalling File Manager
		if(isset($_POST['uninstall_wpep_fm'])) {
			
			// Check nonce to verify we can delete files
			if ( wp_verify_nonce( $_REQUEST['_wpnonce'], 'uninstall-wpep' ) ) {
				
				// First deactivate File Manager
				if(is_plugin_active_for_network('wp_edit_pro_responsive_filemanager/main_fm.php')) {
					deactivate_plugins('/wp_edit_pro_responsive_filemanager/main_fm.php', true); 
				}
				else if(is_plugin_active('wp_edit_pro_responsive_filemanager/main_fm.php')) {
					deactivate_plugins('/wp_edit_pro_responsive_filemanager/main_fm.php', true); 
				}
				
				// Then delete File Manager plugin files
				$wpep_fm_path = ABSPATH.'wp-content/plugins/wp_edit_pro_responsive_filemanager/';
				// If the plugin directory exists
				if(is_dir($wpep_fm_path)) {
					
					// Call function using plugin path
					wpeditpro_delete_dir($wpep_fm_path);
				}
				
				// Then reload wp edit pro bonus page (url paramater)
				($this->network_activated == true) ?  wp_redirect(admin_url('network/admin.php?page=wp_edit_pro_bonus&uninstall_wpep_fm=true')) : wp_redirect(admin_url('admin.php?page=wp_edit_pro_bonus&uninstall_wpep_fm=true'));
			}
		}
	} 
	
	
	
	/*
	****************************************************************
	License page render and save
	****************************************************************
	*/
	public function license_page_callback() {
		
		include 'helpers/license_page_callback.php';
	}
	public function license_page_style() {
		
		wp_enqueue_style( 'license_page_style' );
	}
	public function license_page_save() {
		
		include 'helpers/license_page_save.php';
	}
	
	
	
	/*
	****************************************************************
	Plugin row action links (meta)
	****************************************************************
	*/
	public function plugin_action_links( $links ) {
		
		// Get license status
		$status = $this->get_wp_edit_pro_option( 'wp_edit_pro_license_status' );
		$settings_link = '';
		
		// If license is valid
		if ($status === 'single_act' || $status === 'single_ext_act' || $status === 'multi_act' || $status === 'dev_act') {
			
			$settings_link = '<a href="admin.php?page=wp_edit_pro_options">'.__('Settings', 'wp_edit_pro').'</a>';
		}
		// Else license is invalid
		else {
			
			$settings_link = '<a href="admin.php?page=wp_edit_pro_license">'.__('License', 'wp_edit_pro').'</a>';
		}
		
		$links[] = $settings_link;
		
   		return $links;
	}
	public function plugin_action_links_meta( $links, $file ) {
		
		if ( strpos( $file, 'wp_edit_pro/main.php' ) !== false ) {
			
			$new_links = array(
			
				'<a target="_blank" href="https://wpeditpro.com/support">'.__('Help Desk','wp_edit_pro').'</a>',
				'<a target="_blank" href="https://wpeditpro.com/contact/">'.__('Contact','wp_edit_pro').'</a>'
			);
			$links = array_merge( $links, $new_links );
		}
	
		return $links;
	}
	
	/*
	****************************************************************
	Language localization
	****************************************************************
	*/
	public function wp_edit_pro_load_translation() {
		
		load_plugin_textdomain('wp_edit_pro', false, dirname(plugin_basename(__FILE__)) . '/langs/');
	}
	
	
	
	
	/*
	****************************************************************
	Editor Init
	****************************************************************
	*/
	public function editor_init() {
		
		if ( get_user_option('rich_editing') == 'true' ) {
			
			// Get page type
            global $typenow;
			
            if (empty($typenow) && !empty($_GET['post'])) {
				
                $post = get_post($_GET['post']);
                $typenow = $post->post_type;
            }
			
			// Check user setting and load wpep_init
			$function_opts = $this->get_wp_edit_pro_function_opts();
			$editor_opts = $function_opts['wp_edit_pro_editor'];
			
			// If disabled for posts... return
			if($typenow == 'post' && isset($editor_opts['disable_wpep_posts']) && $editor_opts['disable_wpep_posts'] === '1') 
				return;
			
			// If disabled for pages... return
			if($typenow == 'page' && isset($editor_opts['disable_wpep_pages']) && $editor_opts['disable_wpep_pages'] === '1') 
				return;
		
			include 'helpers/editor_init.php';
		}
	}
	
	/*
	****************************************************************
	Main tiny_mce_before_init filter
	****************************************************************
	*/
	public function editor_tiny_mce_before_init($init) {
		
		//$options = $this->options_array;
		$options = $this->get_wp_edit_pro_function_opts();
		
		
		/*
		****************************************************************
		Editor tab options
		****************************************************************
		*/
		
		// Force "toggle toolbar" button to open position on initialization
		$toggle_toolbar = isset($options['wp_edit_pro_editor']['editor_toggle_toolbar']) && $options['wp_edit_pro_editor']['editor_toggle_toolbar'] == '1' ?  '1' : '0';
		if($toggle_toolbar == '1') {
			
			$init['wordpress_adv_hidden'] = false;
		}
		
		// Enable editor menubar
		$editor_menu_bar = isset($options['wp_edit_pro_editor']['editor_menu_bar']) && $options['wp_edit_pro_editor']['editor_menu_bar'] == '1' ? '1' : '0';
		if($editor_menu_bar == '1') {
			
			$init['menubar'] = "edit insert view format table tools";
		}
		
		// Set editor font type and sizes
		$default_editor_fontsize_type = isset($options['wp_edit_pro_editor']['default_editor_fontsize_type']) ? $options['wp_edit_pro_editor']['default_editor_fontsize_type'] : 'pt';
		
		if($default_editor_fontsize_type === 'px') {
			
			$new_px = isset($options['wp_edit_pro_editor']['default_editor_fontsize_values']) && !empty($options['wp_edit_pro_editor']['default_editor_fontsize_values']) ? $options['wp_edit_pro_editor']['default_editor_fontsize_values'] : '6px 8px 9px 10px 11px 12px 13px 14px 15px 16px 18px 20px 22px 24px 28px 32px 48px 72px';
			empty($init['fontsize_formats']) ? $init['fontsize_formats'] = $new_px : $init['fontsize_formats'] = $init['fontsize_formats'].' '.$new_px;
		}
		else if($default_editor_fontsize_type === 'pt') {
			
			$new_pt = isset($options['wp_edit_pro_editor']['default_editor_fontsize_values']) && !empty($options['wp_edit_pro_editor']['default_editor_fontsize_values']) ? $options['wp_edit_pro_editor']['default_editor_fontsize_values'] : '6pt 8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 30pt 32pt 34pt 36pt 48pt 72pt';
			empty($init['fontsize_formats']) ? $init['fontsize_formats'] = $new_pt : $init['fontsize_formats'] = $init['fontsize_formats'].' '.$new_pt;
		}
		else if($default_editor_fontsize_type === 'em') {
			
			$new_em = isset($options['wp_edit_pro_editor']['default_editor_fontsize_values']) && !empty($options['wp_edit_pro_editor']['default_editor_fontsize_values']) ? $options['wp_edit_pro_editor']['default_editor_fontsize_values'] : '.8em 1em 1.2em 1.4em 1.6em 1.8em 2em';
			empty($init['fontsize_formats']) ? $init['fontsize_formats'] = $new_em : $init['fontsize_formats'] = $init['fontsize_formats'].' '.$new_em;
		}
		else if($default_editor_fontsize_type === 'percent') {
			
			$new_percent = isset($options['wp_edit_pro_editor']['default_editor_fontsize_values']) && !empty($options['wp_edit_pro_editor']['default_editor_fontsize_values']) ? $options['wp_edit_pro_editor']['default_editor_fontsize_values'] : '80% 90% 100% 110% 120%';
			empty($init['fontsize_formats']) ? $init['fontsize_formats'] = $new_percent : $init['fontsize_formats'] = $init['fontsize_formats'].' '.$new_percent;
		}
		
		// Set editor custom colors
		$editor_custom_colors = isset($options['wp_edit_pro_editor']['editor_custom_colors']) && $options['wp_edit_pro_editor']['editor_custom_colors'] !== '' ? $options['wp_edit_pro_editor']['editor_custom_colors'] : '';
		if($editor_custom_colors !== '') {
			
			$default_colours = '"000000", "Black", "993300", "Burnt orange", "333300", "Dark olive", "003300", "Dark green", "003366", "Dark azure", "000080", "Navy Blue", "333399", "Indigo", "333333", "Very dark gray", "800000", "Maroon", "FF6600", "Orange", "808000", "Olive", "008000", "Green", "008080", "Teal", "0000FF", "Blue", "666699", "Grayish blue", "808080", "Gray", "FF0000", "Red", "FF9900", "Amber", "99CC00", "Yellow green", "339966", "Sea green", "33CCCC", "Turquoise", "3366FF", "Royal blue", "800080", "Purple", "999999", "Medium gray", "FF00FF", "Magenta", "FFCC00", "Gold", "FFFF00", "Yellow", "00FF00", "Lime", "00FFFF", "Aqua", "00CCFF", "Sky blue", "993366", "Red violet", "FFFFFF", "White", "FF99CC", "Pink", "FFCC99", "Peach", "FFFF99", "Light yellow", "CCFFCC", "Pale green", "CCFFFF", "Pale cyan", "99CCFF", "Light sky blue", "CC99FF", "Plum"';
			
			$custom_colors = '';
			foreach($editor_custom_colors as $key => $value) {
				
				$custom_colors .= '"'.$value[0].'", "'.$value[1].'",';
			}
			rtrim(',', $custom_colors);
			
			
			$init['textcolor_map'] = '['.$default_colours.','.$custom_colors.']';
			$init['textcolor_rows'] = 6;
		}
		
		/*
		****************************************************************
		Fonts tab options
		****************************************************************
		*/
		// GOOGLE FONTS
		if(isset($options['wp_edit_pro_fonts']['enable_google_fonts']) && $options['wp_edit_pro_fonts']['enable_google_fonts'] == 1) {
			
			$opt_fonts = $options['wp_edit_pro_fonts']['save_google_fonts'];
			$font_list = '';
			
			if($opt_fonts) {
				
				/********
				*********  Add all fonts back to dropdown
				*/
				// Get our saved fonts
				foreach($opt_fonts as $font) {
					$font_list[] = $font.'='.strtolower($font);
				}
				
				// Re-build original fonts
				$default_fonts = isset($init['font_formats']) ? $init['font_formats'] : 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
				
				// Convert default fonts into an array
				$default_fonts_array = explode(';',$default_fonts);
				
				// Merge both arrays and sort the result alphabetically
				$fonts_merged = array_merge($default_fonts_array, $font_list);
				usort($fonts_merged, 'strcasecmp');
				
				// Convert array back to string 
				$fonts_string = implode(';',$fonts_merged);
				
				if (empty($init['font_formats']) || $init['font_formats'] == "") {
					$init['font_formats'] = $fonts_string;
				} 
				else {
					$new_string = $init['font_formats'] .','.$fonts_string;
					$init['font_formats'] = $new_string;
				}
				
				
				/********
				*********  Add css to content editor 
				*/
				// Convert database options to string
				$google_url_fonts = '';
				foreach($opt_fonts as $font_css) {
					$google_url_fonts .= str_replace(' ', '+', $font_css).'|';
				}
				$google_url_fonts = rtrim($google_url_fonts, '|');
				$google_url = '//fonts.googleapis.com/css?family='.$google_url_fonts;
				
				$new_string = $init['content_css'] .','.$google_url;
				$init['content_css'] = $new_string;
			}
		}
		
		// CUSTOM FONTS
		if(isset($options['wp_edit_pro_fonts']['save_custom_fonts']) && !empty($options['wp_edit_pro_fonts']['save_custom_fonts'])) {
			
			$saved_fonts = $options['wp_edit_pro_fonts']['save_custom_fonts'];
			
			// Get our saved fonts
			foreach($saved_fonts as $font) {
				$font_list_custom[] = $font . '=' . $font;
			}
			
			// Re-build original fonts
			$default_fonts_custom = isset($init['font_formats']) ? $init['font_formats'] : 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
			
			// Convert default fonts into an array
			$default_fonts_array_custom = explode(';', $default_fonts_custom);
			
			// Merge both arrays and sort the result alphabetically
			$fonts_merged_custom = array_merge($default_fonts_array_custom, $font_list_custom);
			usort($fonts_merged_custom, 'strcasecmp');
			
			// Convert array back to string 
			$fonts_string_custom = implode( ';', $fonts_merged_custom );
			
			$init['font_formats'] = $fonts_string_custom;
			
			
			
			// Add stylesheet to editor
			$blog_id = get_current_blog_id();
					
			// Have to check which subsite we are on (1 = main site or network site 1)
			if($blog_id !== 1 && $this->network_activated == true && $this->network_admin_mode == 'separate') {
				
				$content_url = content_url();
				$custom_fonts_styles_url = $content_url . '/uploads/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/stylesheet/custom_font_styles.css';
			}
			else {
				
				if( is_multisite() == true && $blog_id !== 1 && $this->network_admin_mode == 'separate' ) {
					
					$content_url = network_site_url();
					$custom_fonts_styles_url = $content_url . 'wp-content/uploads/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/stylesheet/custom_fonts_styles.css';
				}
				else {
					
					$content_url = content_url();
					$custom_fonts_styles_url = $content_url . '/uploads/wp_edit_pro/custom_fonts/stylesheet/custom_fonts_styles.css';
				}
			}
		
			// Append cache buster (use time in seconds since 1970)
			$time = time();
			$custom_fonts_styles_url .= '?time='.$time;
			
			if (empty($init['content_css']) || $init['content_css'] == "") {
				$init['content_css'] = $custom_fonts_styles_url;
			} 
			else {
				$new_string = $init['content_css'] .','.$custom_fonts_styles_url;
				$init['content_css'] = $new_string;
			}
		}
		
		/*
		****************************************************************
		Styles tab options
		****************************************************************
		*/
		// Get current blog id
		$blog_id = get_current_blog_id();
		
		// Have to check which subsite we are on (1 = main site or network site 1)
		// If custom css is found in stylesheet... create css file
		if( $blog_id !== 1 && $this->network_activated == true && $this->network_admin_mode == 'separate' ) {
			
			$file_path = WP_CONTENT_URL.'/uploads/sites/'.$blog_id.'/wp_edit_pro/custom_styles/tinymce_custom_css.css';
		}
		else {
			
			if( is_multisite() == true && $blog_id !== 1 && $this->network_admin_mode == 'separate' ) {
				
				$content_url = network_site_url();
				$file_path = $content_url . 'wp-content/uploads/sites/'.$blog_id.'/wp_edit_pro/custom_styles/tinymce_custom_css.css';	
			}
			else {
				
				$file_path = WP_CONTENT_URL.'/uploads/wp_edit_pro/custom_styles/tinymce_custom_css.css';
			}
		}
		
		// Append cache buster (use time in seconds since 1970)
		$time = time();
		$file_path .= '?time='.$time;
		
		$content = isset($options['wp_edit_pro_styles']['tinymce_custom_css']) ? $options['wp_edit_pro_styles']['tinymce_custom_css'] : '';
		
		if($content && $content !== '') {
			
			if (empty($init['content_css']) || $init['content_css'] == "") {
				$init['content_css'] = $file_path;
			} else {
				$new_string = $init['content_css'] .','.$file_path;
				$init['content_css'] = $new_string;
			}
		}
		
		// Include custom style formats
		include 'helpers/style_formats.php';
		
		// Return values
		return $init;
	}
	
	// Used to sort the custom styles array from (style_formats.php) (lowercase helps sorting upper and lower)
	public function array_compare( $a, $b ) {
		
		return strcmp( strtolower( $a["title"] ), strtolower( $b["title"] ) );
	}
	
	/*
	****************************************************************
	Pass js vars only to wp tinymce pages
	****************************************************************
	*/
	public function editor_before_wp_tiny_mce() {
		
		global $current_user;
		
		// Add WP dashicons css file to editor
		echo '<link rel="stylesheet" type="text/css" href="'.$this->plugin_url.'css/tinymce_dashicons.css" />';
		echo '<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />';
		
		// Get options from subsite function
		$function_opts = $this->get_wp_edit_pro_function_opts();
		$orig_buttons = $function_opts['wp_edit_pro_buttons'];
		$curr_buttons = array();
		
		// Check if this is a user role
		$user_role = $current_user->roles[0];
		$orig_buttons = isset($function_opts['wp_edit_pro_buttons_wp_role_'.$user_role]) ? $function_opts['wp_edit_pro_buttons_wp_role_'.$user_role] : $curr_buttons;
		
		// Check if this is a user capability
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
					$orig_buttons = $value;
				}
			}
		}
		// Check if this is a user
		$user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
		$user_buttons =isset($user_meta['wp_edit_pro_buttons_user_editor']) ? $user_meta['wp_edit_pro_buttons_user_editor'] : '';
		if(!empty($user_buttons)) {
			$orig_buttons = $user_buttons;
		}
		// If this is a visitor editor
		if(!is_user_logged_in()) {
			$visitor_buttons = $function_opts['wp_edit_pro_buttons_wp_visitor'];
			if(!empty($visitor_buttons)) {
				$orig_buttons = $visitor_buttons;
			}
		}
		
		// Check if toolbar array items exist (throwing undefined index notice when clicking pages like "dashboard")
		$orig_buttons['toolbar1'] = isset($orig_buttons['toolbar1']) ? $orig_buttons['toolbar1'] : '';
		$orig_buttons['toolbar2'] = isset($orig_buttons['toolbar2']) ? $orig_buttons['toolbar2'] : '';
		$orig_buttons['toolbar3'] = isset($orig_buttons['toolbar3']) ? $orig_buttons['toolbar3'] : '';
		$orig_buttons['toolbar4'] = isset($orig_buttons['toolbar4']) ? $orig_buttons['toolbar4'] : '';

		// Get current button array
		$curr_buttons = array_merge(explode(' ', $orig_buttons['toolbar1']), explode(' ', $orig_buttons['toolbar2']), explode(' ', $orig_buttons['toolbar3']), explode(' ', $orig_buttons['toolbar4']));
		
		// Add dropbox script (if button is added)
		if(in_array('dropbox', $curr_buttons)) {			
			$editor_opts = $function_opts['wp_edit_pro_editor'];
			$app_key = isset($editor_opts['dropbox_app_key']) ? $editor_opts['dropbox_app_key'] : '';
			if($app_key !== '') {
				echo '<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="'.$app_key.'"></script>';
			}
		}
	}
	
	public function editor_after_wp_tiny_mce() {
		
		// ***********************************************
		// Shortcodes
		// ***********************************************
		
		// Get all registered shortcodes
		global $shortcode_tags;
		$list = array();
		$myVar = '';
		
		// Build array to pass to tinymce
		foreach($shortcode_tags as $tagname => $tag) {
			
			$list[] = array('text' => $tagname, 'value' => $tagname);
		}
		$obj = json_decode(json_encode($list), FALSE);
		
		// Json encode
		$myVar = json_encode($obj);
		
		// Pass shortcodes addon object
		printf('<script type="text/javascript">var wp_edit_pro_shortcodes = '.$myVar.'; var wp_edit_pro_vars = {wpeditpro_ajaxurl: "'.admin_url('admin-ajax.php').'", wpeditpro_tinymce_jquery_url: "'.includes_url('/js/jquery/jquery.js').'"};</script>');
	}
	
	/*
	****************************************************************
	Localize tinymce languages
	****************************************************************
	*/
	public function editor_tinymce_langs($locales) {
		
		$locales['wpep_tmce_langs'] = plugin_dir_path ( __FILE__ ) . 'langs/wpep_tinymce_langs.php';
    	return $locales;
	}
	
	/*
	****************************************************************
	Check html content and enqueue responsive imagemap
	****************************************************************
	*/
	public function editor_include_responsive_imagemap() {
		
		global $post;
		if(isset($post)) {
			
			// If "<map " is found in the post content; enqueue the responsive imagemaps javascript
			if ( strstr( $post->post_content, '<map ' ) ) {
				
				wp_register_script('wpep_responsive_imagemap', plugins_url('wp_edit_pro/js/responsive_imagemaps.js'), array('jquery'), '1.0', true);
				wp_enqueue_script('wpep_responsive_imagemap');
			}
		}
	}
	
	
	
	
	/*
	****************************************************************
	Functions - Global Tab
	****************************************************************
	*/
	
	
	
	/*
	****************************************************************
	Functions - General Tab
	****************************************************************
	*/
	
	// Insert linebreak shortcode
	public function wp_edit_pro_insert_linebreak($atts){
		
 		return '<br clear="none" />';
	}
	
	// Add Editor to Post Excerpts
	public function wp_edit_pro_change_post_excerpt() {
		
		remove_meta_box('postexcerpt', 'post', 'normal');
		add_meta_box('postexcerpt', __('WP Edit Pro Excerpt','wp_edit_pro'), array($this, 'wp_edit_pro_post_excerpt_meta_box'), 'post', 'normal');
	}
	public function wp_edit_pro_post_excerpt_meta_box() {
		
		global $wpdb,$post;
		$tinymce_summary = $wpdb->get_row("SELECT post_excerpt FROM $wpdb->posts WHERE id = '$post->ID'");
		$post_tinymce_excerpt = $tinymce_summary->post_excerpt;
	
		$id = 'excerpt';
		$settings = array('quicktags' => array('buttons' => 'em,strong,link',), 'text_area_name' => 'excerpt', 'quicktags' => true, 'tinymce' => true, 'editor_css' => '<style>#wp-excerpt-editor-container .wp-editor-area{height:250px; width:100%;}</style>');
		
		wp_editor($post_tinymce_excerpt, $id, $settings);
	}
	
	// Add Editor to Page Excerpts
	public function wp_edit_pro_page_excerpts_init() {
		
		add_post_type_support('page', array('excerpt'));
	}
	public function wp_edit_pro_change_page_excerpt() {
		
		remove_meta_box('postexcerpt', 'page', 'normal');
		add_meta_box('postexcerpt', __('Wp Edit Pro Excerpt','wp_edit_pro'), array($this, 'wp_edit_pro_page_excerpt_meta_box'), 'page', 'normal');
	}
	public function wp_edit_pro_page_excerpt_meta_box() {
		
		global $wpdb,$post;
		$tinymce_summary_page = $wpdb->get_row("SELECT post_excerpt FROM $wpdb->posts WHERE id = '$post->ID'");
		$post_tinymce_excerpt_page 	 = $tinymce_summary_page->post_excerpt;
	
		$id = 'excerpt';
		$settings = array('quicktags' => array('buttons' => 'em,strong,link',), 'text_area_name' => 'excerpt', 'quicktags' => true, 'tinymce' => true, 'editor_css'	=> '<style>#wp-excerpt-editor-container .wp-editor-area{height:250px; width:100%;}</style>');
		
		wp_editor($post_tinymce_excerpt_page, $id, $settings);
	}
	
	// Add Editor to CPT's
	public function wp_edit_pro_change_cpt_excerpt() {
		
		$cpt_excerpts = $this->options_array['wp_edit_pro_general']['wpep_cpt_excerpts'];
		foreach($cpt_excerpts as $key => $cpt) {
			
			remove_meta_box('postexcerpt', $cpt, 'normal');
			add_meta_box('postexcerpt', __('Wp Edit Pro Excerpt','wp_edit_pro'), array($this, 'wp_edit_pro_cpt_excerpt_meta_box'), $cpt, 'normal');
		}
	}
	public function wp_edit_pro_cpt_excerpt_meta_box() {
		
		global $wpdb,$post;
		$get_cpt_excerpt = $wpdb->get_row("SELECT post_excerpt FROM $wpdb->posts WHERE id = '$post->ID'");
		$cpt_excerpt = $get_cpt_excerpt->post_excerpt;
		$id = 'excerpt';
		$settings = array('quicktags' => array('buttons' => 'em,strong,link',), 'text_area_name' => 'excerpt', 'quicktags' => true, 'tinymce' => true, 'editor_css'	=> '<style>#wp-excerpt-editor-container .wp-editor-area{height:250px; width:100%;}</style>');
		
		wp_editor($cpt_excerpt, $id, $settings);
	}
	
	// Extend editor to profile biography
	public function wp_edit_pro_visual_editor($user) {
		
		// Contributor level user or higher required
		if ( !current_user_can('edit_posts') )
			return;
		?>
		<table class="form-table">
			<tr id="wp_edit_pro_biographical_editor" class="user-description-wrap">
				<th><label for="description"><?php _e('Biographical Info','wp_edit_pro'); ?></label></th>
				<td>
					<?php 
					$description = get_user_meta( $user->ID, 'description', true);
					$args = array('textarea_rows' => 5);
					wp_editor( $description, 'description', $args ); 
					?>
					<p class="description"><?php _e('Share a little biographical information to fill out your profile. This may be shown publicly.','wp_edit_pro'); ?></p>
				</td>
			</tr>
		</table>
		<?php
	}
	public function wp_edit_pro_editor_biography_js($hook) {
		
		global $current_screen;
		if($current_screen->id === 'profile' || $current_screen->id === 'profile-network') {
			
			?>
            <script type="text/javascript">
			(function($) {
				
				// Remove the textarea before displaying visual editor
				$('.user-description-wrap').first().replaceWith($('#wp_edit_pro_biographical_editor'));
				// Expand text editor width
				$('.wp-editor-area').css('width', '100%');
			}(jQuery));
			</script>
			<?php
		}
	}
	
	
	
	/*
	****************************************************************
	Functions - Posts tab
	****************************************************************
	*/
	// Global stlyes
	public function wp_edit_pro_posts_tab_custom_styles() {
		
		$function_opts = $this->get_wp_edit_pro_function_opts();
		$plugin_options_posts = $function_opts['wp_edit_pro_posts'];
		$wpep_styles_editor_textarea = isset($plugin_options_posts['wpep_styles_editor_textarea']) ? $plugin_options_posts['wpep_styles_editor_textarea'] : '';
		
		echo '<style type="text/css">'."\n";
		echo '/* '; _e('Taken from WP Edit Pro custom css (posts tab)', 'wp_edit_pro'); echo ' */'."\n";
		echo $wpep_styles_editor_textarea."\n";
		echo '</style>'."\n";
	}
	// Global scripts
	public function wp_edit_pro_posts_tab_custom_scripts() {
		
		$function_opts = $this->get_wp_edit_pro_function_opts();
		$plugin_options_posts = $function_opts['wp_edit_pro_posts'];
		$wpep_scripts_editor_textarea = isset($plugin_options_posts['wpep_scripts_editor_textarea']) ? $plugin_options_posts['wpep_scripts_editor_textarea'] : '';
		
		echo '<script type="text/javascript">'."\n";
		echo '/* '; _e('Taken from WP Edit Pro custom scripts (posts tab)', 'wp_edit_pro'); echo ' */'."\n";
		echo $wpep_scripts_editor_textarea."\n";
		echo '</script>'."\n";
	}
	
	// Individual post/page styles and scripts
	// Create custom metabox for posts and pages
	public function wpep_add_styles_scripts_meta_box() {
		
		$screens = array( 'post', 'page' );  // Only apply to posts and pages screens
		foreach ( $screens as $screen ) {
			add_meta_box( 'wpep_styles_scripts_metabox', __( 'WP Edit Pro Styles & Scripts', 'wp_edit_pro' ), array( $this, 'wpep_styles_scripts_metabox_callback' ), $screen );
		}
	}
	
	// Custom metabox callback function
	public function wpep_styles_scripts_metabox_callback($post) {
		
		wp_nonce_field( 'wpep_styles_scripts_metabox', 'wpep_styles_scripts_metabox_nonce' );  // Set nonce
		$wpep_ind_custom_style_editor_textarea = get_post_meta( $post->ID, 'wpep_ind_style', true );  // Get post meta for styles
		$wpep_ind_custom_script_editor_textarea = get_post_meta( $post->ID, 'wpep_ind_script', true );  // Get post meta for scripts
		$wpep_body_classes = get_post_meta( $post->ID, 'wpep_body_classes', true );  // Get post meta for body classes
		$wpep_post_classes = get_post_meta( $post->ID, 'wpep_post_classes', true );  // Get post meta for post classes
		?>
		
		<div id="wpep_styles_scripts_tabs">
		
			<ul class="wpep_tabs_menu">
				<li class="wpep_current_tab"><a href="#wpep_styles"><?php _e('Styles', 'wp_edit_pro'); ?></a></li>
				<li><a href="#wpep_scripts"><?php _e('Scripts', 'wp_edit_pro'); ?></a></li>
				<li><a href="#wpep_classes"><?php _e('Classes', 'wp_edit_pro'); ?></a></li>
			</ul>
			<div class="wpep_tabs">
			
				<div id="wpep_styles" class="wpep_tab_content">
					<div id="wpep_ind_custom_style">
						
						<div name="wpep_ind_custom_style_editor" id="wpep_ind_custom_style_editor" style="height:100px;border:1px solid #CCC;"></div>
						<?php _e('These styles will be wrapped in <code>&#60;style&#62;</code> tags; and inserted just before the closing <code>&#60;/head&#62;</code> tag of this page only.', 'wp_edit_pro'); ?>
						<textarea id="wpep_ind_custom_style_editor_textarea" name="wpep_ind_custom_style_editor_textarea" style="display: none;"><?php echo $wpep_ind_custom_style_editor_textarea; ?></textarea><br />
					</div>
				</div>
				
				<div id="wpep_scripts" class="wpep_tab_content">
					<div id="wpep_ind_custom_script">
						
						<?php 
						if( current_user_can( 'manage_options' ) ) { 
						
							?><div name="wpep_ind_custom_script_editor" id="wpep_ind_custom_script_editor" style="height:100px;border:1px solid #CCC;"></div>
							<?php _e('These scripts will be wrapped in <code>&#60;script&#62;</code> tags; and inserted just before the closing <code>&#60;/body&#62;</code> tag of this page only.', 'wp_edit_pro'); ?>
							<textarea id="wpep_ind_custom_script_editor_textarea" name="wpep_ind_custom_script_editor_textarea" style="display: none;"><?php echo $wpep_ind_custom_script_editor_textarea; ?></textarea><br />
						<?php
						} else {
							
							_e('Only administrators may add scripts to individual posts/pages.', 'wp_edit_pro');
						}
						?>
					</div>
				</div>
			
				<div id="wpep_classes" class="wpep_tab_content">
					<strong><?php _e('Body Classes', 'wp_edit_pro'); ?></strong><br />
					<input type="text" id="wpep_body_classes" name="wpep_body_classes" style="width:50%;" value="<?php echo $wpep_body_classes; ?>" /><br />
					<?php 
					$get_body_classes = get_body_class();
					echo '<em>'; _e('Standard:', 'wp_edit_pro'); echo '</em>';
					echo ' <code>';
					foreach( $get_body_classes as $k => $body_class ) {
						echo $body_class . ' ';
					}
					echo '</code>';
					echo '<br /><br />';
					?>
					
					<strong><?php _e('Post Classes', 'wp_edit_pro'); ?></strong><br />
					<input type="text" id="wpep_post_classes" name="wpep_post_classes" style="width:50%;" value="<?php echo $wpep_post_classes; ?>" /><br />
					<?php 
					$get_post_classes = get_post_class('', $post->ID);
					echo '<em>'; _e('Standard:', 'wp_edit_pro'); echo '</em>';
					echo ' <code>';
					foreach( $get_post_classes as $k => $post_class ) {
						echo $post_class . ' ';
					}
					echo '</code>';
					echo '<br /><br />';
					
					_e('These <strong>space separated</strong> class names will be added to the <code>body_class()</code> or <code>post_class()</code> function (provided your theme uses these functions).', 'wp_edit_pro');
					?>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				
				// jQuery tabs
				$(".wpep_tabs_menu a").click(function(event) {
					event.preventDefault();
					$(this).parent().addClass("wpep_current_tab");
					$(this).parent().siblings().removeClass("wpep_current_tab");
					tab = $(this).attr("href");
					$(".wpep_tab_content").not(tab).css("display", "none");
					$(tab).fadeIn();
				});
				
				// Define ace editor for styles textarea
				var wpep_editor_styles = ace.edit("wpep_ind_custom_style_editor");
				wpep_editor_styles.$blockScrolling = Infinity;  // Disable console scrolling message
				wpep_editor_styles.getSession().setMode("ace/mode/css");
				wpep_editor_styles.getSession().setUseWrapMode( true );
				wpep_editor_styles.setShowPrintMargin( false );
				wpep_editor_styles.getSession().setValue( $( '#wpep_ind_custom_style_editor_textarea' ).val() );
				wpep_editor_styles.session.setOption("useWorker", false);  // disable syntax checking
				// Click function for populating hidden textarea with styles css
				$( '#publish' ).click( function() {
					$( '#wpep_ind_custom_style_editor_textarea' ).val( wpep_editor_styles.getSession().getValue() );
				});
				
				// Define ace editor for scripts textarea
				var wpep_editor_scripts = ace.edit("wpep_ind_custom_script_editor");
				wpep_editor_scripts.$blockScrolling = Infinity;  // Disable console scrolling message
				wpep_editor_scripts.getSession().setMode("ace/mode/javascript");
				wpep_editor_scripts.getSession().setUseWrapMode( true );
				wpep_editor_scripts.setShowPrintMargin( false );
				wpep_editor_scripts.getSession().setValue( $( '#wpep_ind_custom_script_editor_textarea' ).val() );
				wpep_editor_scripts.session.setOption("useWorker", false);  // disable syntax checking
				// Click function for populating hidden textarea with styles css
				$( '#publish' ).click( function() {
					$( '#wpep_ind_custom_script_editor_textarea' ).val( wpep_editor_scripts.getSession().getValue() );
				});
			});
		</script>
		
		<style type="text/css">
			.wpep_tabs_menu {height: 18px; clear: both;}
			.wpep_tabs_menu li {height: 30px; line-height: 30px; float: left; margin-right: 10px; background-color: #ccc; border-top: 1px solid #d4d4d1; border-right: 1px solid #d4d4d1; border-left: 1px solid #d4d4d1;}
			.wpep_tabs_menu li.wpep_current_tab { position: relative; background-color: #fff; border-bottom: 1px solid #fff; z-index: 5; }
			.wpep_tabs_menu li a { padding: 10px; text-transform: uppercase; color: #fff; text-decoration: none; }
			.wpep_tabs_menu .wpep_current_tab a { color: #2e7da3; }
			.wpep_tabs { border: 1px solid #d4d4d1; background-color: #fff; margin-bottom: 20px; width: auto; }
			.wpep_tab_content { padding: 20px; display: none; }
			#wpep_styles { display: block; }
		</style>
		<?php
	}
	
	// Save the custom metabox data
	public function wpep_style_script_save_meta_box_data( $post_id ) {
	
		if ( ! isset( $_POST['wpep_styles_scripts_metabox_nonce'] ) )
			return;
	
		if ( ! wp_verify_nonce( $_POST['wpep_styles_scripts_metabox_nonce'], 'wpep_styles_scripts_metabox' ) )
			return;
	
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
	
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return;
	
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
		}
	
		/* OK, it's safe for us to save the data now. */
		$wpep_styles_data = isset( $_POST['wpep_ind_custom_style_editor_textarea'] ) ? stripslashes( $_POST['wpep_ind_custom_style_editor_textarea'] ) : '';
		$wpep_scripts_data = isset( $_POST['wpep_ind_custom_script_editor_textarea'] ) ? stripslashes( $_POST['wpep_ind_custom_script_editor_textarea'] ) : '';
		$wpep_body_classes = isset( $_POST['wpep_body_classes'] ) ? sanitize_text_field( $_POST['wpep_body_classes'] ) : '';
		$wpep_post_classes = isset( $_POST['wpep_post_classes'] ) ? sanitize_text_field( $_POST['wpep_post_classes'] ) : '';
		
		update_post_meta( $post_id, 'wpep_ind_style', $wpep_styles_data );
		update_post_meta( $post_id, 'wpep_ind_script', $wpep_scripts_data );
		update_post_meta( $post_id, 'wpep_body_classes', $wpep_body_classes );
		update_post_meta( $post_id, 'wpep_post_classes', $wpep_post_classes );
	}
	
	// Add individual styles to header
	public function wpep_ind_style_head() {
		
		// Get post ID
		$id = get_the_ID();
		// Get post meta
		$meta = get_post_meta( $id, 'wpep_ind_style', true );
		
		if(isset($meta) && $meta !== '') {
			
			// Only execute on single posts and pages
			if(is_single() || is_page()) {
			
				echo '<style type="text/css">' . "\n";
				echo '/* '; _e ('Taken from WP Edit Pro individual page styles.', 'wp_edit_pro'); echo ' */' . "\n";
				echo $meta . "\n";
				echo '</style>' . "\n";
			}
		}
	}
	
	// Add individual scripts to footer
	public function wpep_ind_script_footer() {
		
		// Get post ID
		$id = get_the_ID();
		// Get post meta
		$meta = get_post_meta( $id, 'wpep_ind_script', true );
		
		if(isset($meta) && $meta !== '') {
			
			// Only execute on single posts and pages
			if(is_single() || is_page()) {
			
				echo '<script type="text/javascript">' . "\n";
				echo '/* '; _e ('Taken from WP Edit Pro individual page scripts.', 'wp_edit_pro'); echo ' */' . "\n";
				echo $meta . "\n";
				echo '</script>' . "\n";
			}
		}
	}
	
	// Filter body classes
	public function wpep_filter_body_classes($classes) {
			
		// Get post ID
		$id = get_the_ID();
		// Get post meta
		$meta = get_post_meta( $id, 'wpep_body_classes', true );
		
		if(isset($meta) && $meta !== '') {
			
			$meta_classes = explode(' ', $meta);
			foreach( $meta_classes as $class) {
				$classes[] = $class;
			}
		}
		
		return $classes;
	}
	
	// Filter post classes
	public function wpep_filter_post_classes($classes) {
		
		// Get post ID
		$id = get_the_ID();
		// Get post meta
		$meta = get_post_meta( $id, 'wpep_post_classes', true );
		
		if(isset($meta) && $meta !== '') {
			
			$meta_classes = explode(' ', $meta);
			foreach( $meta_classes as $class) {
				$classes[] = $class;
			}
		}
		
		return $classes;
	}
	
	// Enqueue ace for post/page individual styles and scripts metabox
	public function wpep_post_scripts_metabox_script( $hook ) {
	
		if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
			wp_enqueue_script( 'wpeditpro_ace_js' );
			wp_enqueue_script( 'wpeditpro_ace_mode_css_js' );
			wp_enqueue_script( 'wpeditpro_ace_worker_css_js' );
			wp_enqueue_script( 'wpeditpro_ace_mode_js_js' );
			wp_enqueue_script( 'wpeditpro_ace_worker_js_js' );
		}
	}
	
	// Post title filter
	public function wp_edit_pro_title_text_input( $title ){
		
		// Get current screen (returns 'post' or 'page');
		$screen = get_current_screen();
		$post_page = $screen->id;
		
		$function_opts = $this->get_wp_edit_pro_function_opts();
		$plugin_options_posts = $function_opts['wp_edit_pro_posts'];
		
		if( $post_page == 'post' )
			$title = isset( $plugin_options_posts['post_title_field'] ) ? $plugin_options_posts['post_title_field'] : 'Enter title here';
			
		if( $post_page == 'page' )
			$title = isset( $plugin_options_posts['page_title_field'] ) ? $plugin_options_posts['page_title_field'] : 'Enter title here';
			
		return $title;
	}
	
	// Coulumn shortcodes
	public function jwl_one_third( $atts, $content = null ) { return '<div class="jwl_one_third">' . do_shortcode($content) . '</div>'; }
	public function jwl_one_third_last( $atts, $content = null ) { return '<div class="jwl_one_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	public function jwl_two_third( $atts, $content = null ) { return '<div class="jwl_two_third">' . do_shortcode($content) . '</div>'; }
	public function jwl_two_third_last( $atts, $content = null ) { return '<div class="jwl_two_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	public function jwl_one_half( $atts, $content = null ) { return '<div class="jwl_one_half">' . do_shortcode($content) . '</div>'; }
	public function jwl_one_half_last( $atts, $content = null ) { return '<div class="jwl_one_half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	public function jwl_one_fourth( $atts, $content = null ) { return '<div class="jwl_one_fourth">' . do_shortcode($content) . '</div>'; }
	public function jwl_one_fourth_last( $atts, $content = null ) { return '<div class="jwl_one_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	public function jwl_three_fourth( $atts, $content = null ) { return '<div class="jwl_three_fourth">' . do_shortcode($content) . '</div>'; }
	public function jwl_three_fourth_last( $atts, $content = null ) { return '<div class="jwl_three_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	public function jwl_one_fifth( $atts, $content = null ) { return '<div class="jwl_one_fifth">' . do_shortcode($content) . '</div>'; }
	public function jwl_one_fifth_last( $atts, $content = null ) { return '<div class="jwl_one_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	public function jwl_two_fifth( $atts, $content = null ) { return '<div class="jwl_two_fifth">' . do_shortcode($content) . '</div>'; }
	public function jwl_two_fifth_last( $atts, $content = null ) { return '<div class="jwl_two_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	public function jwl_three_fifth( $atts, $content = null ) { return '<div class="jwl_three_fifth">' . do_shortcode($content) . '</div>'; }
	public function jwl_three_fifth_last( $atts, $content = null ) { return '<div class="jwl_three_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	public function jwl_four_fifth( $atts, $content = null ) { return '<div class="jwl_four_fifth">' . do_shortcode($content) . '</div>'; }
	public function jwl_four_fifth_last( $atts, $content = null ) { return '<div class="jwl_four_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	public function jwl_one_sixth( $atts, $content = null ) { return '<div class="jwl_one_sixth">' . do_shortcode($content) . '</div>'; }
	public function jwl_one_sixth_last( $atts, $content = null ) { return '<div class="jwl_one_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	public function jwl_five_sixth( $atts, $content = null ) { return '<div class="jwl_five_sixth">' . do_shortcode($content) . '</div>'; }
	public function jwl_five_sixth_last( $atts, $content = null ) { return '<div class="jwl_five_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>'; }
	
	// Enqueue column shortcodes stylesheet
	public function wp_edit_pro_enqueue_column_stylesheet() {
		
		wp_register_style('column-styles', $this->plugin_url . 'css/column-style.css');
		wp_enqueue_style('column-styles');
	}
	
	// Editor notes
	public function wpep_register_editor_notes_metabox() {
		
		add_meta_box('wpep_post_editor_notes', __( 'WP Edit Pro Editor Notes', 'wp_edit_pro' ), array($this, 'wpep_post_editor_notes_callback'), array('post', 'page'), 'normal');
	}
	public function wpep_post_editor_notes_callback($object) {
		
		wp_nonce_field(basename(__FILE__), 'wpep_post_editor_notes');
		
		$meta_value = get_post_meta($object->ID, '_wpep_editor_notes', true);
		
		$content = $meta_value;
		$editor_id = 'wpep_editor_notes_content';
		
		echo '<p>';
		_e('Use the editor below to store notes for this post/page. This editor is only visible to site admins.', 'wp_edit_pro');
		echo '</p>';

		wp_editor( $content, $editor_id );
	}
	public function save_editor_notes_metabox($post_id, $post, $update) {
		
		if (!isset($_POST['wpep_post_editor_notes']) || !wp_verify_nonce($_POST['wpep_post_editor_notes'], basename(__FILE__)))
			return $post_id;
	
		if(!current_user_can('edit_post', $post_id))
			return $post_id;
	
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;
			
		$meta_box_text_value = '';
		
		if(isset($_POST['wpep_editor_notes_content'])) {
			
			$meta_box_text_value = $_POST['wpep_editor_notes_content'];
		} 
		
		update_post_meta($post_id, '_wpep_editor_notes', $meta_box_text_value);
	}
	
	// Max post revisions
	public function wp_edit_pro_max_post_revisions($num, $post) {
		
		$function_opts = $this->get_wp_edit_pro_function_opts();
		$options_posts = $function_opts['wp_edit_pro_posts'];
		if( 'post' == $post->post_type ) {
			$num = $options_posts['max_post_revisions'] - 1;  // Subtract one because counts do not match otherwise
		}
		return $num;
	}
	
	// Max page revisions
	public function wp_edit_pro_max_page_revisions($num, $post) {  
	 
		$function_opts = $this->get_wp_edit_pro_function_opts();
		$options_posts = $function_opts['wp_edit_pro_posts'];
		if( 'page' == $post->post_type ) {
			$num = $options_posts['max_page_revisions'];
		}
		return $num;
	}
	
	// Max posts/pages revisions admin js
	public function wp_edit_pro_max_revisions_js() {
		
		$function_opts = $this->get_wp_edit_pro_function_opts( 'wp_edit_pro_options_array' );
		global $post_type;
		
		if( isset($function_opts['wp_edit_pro_posts']['max_post_revisions']) && $function_opts['wp_edit_pro_posts']['max_post_revisions'] != '' && $post_type === 'post' ) {
			
			wp_enqueue_script( 'wpep_posts_revisions_js', $this->plugin_url . 'js/post_revisions.js' );
		}
		if( isset($function_opts['wp_edit_pro_posts']['max_page_revisions']) && $function_opts['wp_edit_pro_posts']['max_page_revisions'] != '' && $post_type === 'page' ) {
			
			wp_enqueue_script( 'wpep_posts_revisions_js', $this->plugin_url . 'js/page_revisions.js' );
		}
	}
	
	// Hide admin posts
	public function wp_edit_pro_hide_admin_posts($query) {
		
			if( !is_admin() ) return $query;
			global $pagenow;
			
			
			$function_opts = $this->get_wp_edit_pro_function_opts();
			$plugin_opts = $function_opts['wp_edit_pro_posts'];
			$jwl_hide_posts = $plugin_opts['hide_admin_posts'];
			$jwl_hide_posts_array = explode( ",", $jwl_hide_posts );
			
			if( 'edit.php' == $pagenow && ( get_query_var('post_type') && 'post' == get_query_var('post_type') ) )
				$query->set( 'post__not_in', $jwl_hide_posts_array );
				
			return $query;
	}
	
	// Hide admin pages
	public function wp_edit_pro_hide_admin_pages($query) {
		
			if( !is_admin() ) return $query;
			global $pagenow;
			
			$function_opts = $this->get_wp_edit_pro_function_opts();
			$plugin_opts = $function_opts['wp_edit_pro_posts'];
			$jwl_hide_pages = $plugin_opts['hide_admin_pages'];
			$jwl_hide_pages_array = explode( ",", $jwl_hide_pages );
			
			if( 'edit.php' == $pagenow && ( get_query_var('post_type') && 'page' == get_query_var('post_type') ) )
				$query->set( 'post__not_in', $jwl_hide_pages_array );
					
			return $query;
	}
	
	// Enable comment editor
	public function wpep_comment_form_editor($fields) {
			
		$function_opts = $this->get_wp_edit_pro_function_opts();
		$plugin_options_posts = $function_opts['wp_edit_pro_posts'];
		$media_buttons = $plugin_options_posts['enable_add_media'] === '1' ? true : false;
		
		$args = array(
			'teeny' => true, 
			'textarea_rows' => '3', 
			'media_buttons' => $media_buttons, 
			'tinymce' => array('toolbar1' => 'bold italic underline blockquote strikethrough bullist numlist alignleft aligncenter alignright undo redo link unlink')
			);
		
		ob_start();
		wp_editor('', 'comment', $args);
		$fields['comment_field'] = ob_get_clean();
		return $fields;
	}
	
	public function wpep_comment_form_scripts(){
	 
		wp_deregister_script('comment-reply');
		wp_register_script('comment-reply', $this->plugin_url . 'js/comment-reply.js', array('jquery'), '1.0.0', true);
	}
	
	public function wpep_comment_form_allowed_tags() {
	
		global $allowedtags;
		
		$allowedtags['ul'] = array();
		$allowedtags['ol'] = array();
		$allowedtags['li'] = array();
		$allowedtags['strong'] = array();
		$allowedtags['ins'] = array(
			'datetime' => true
		);
		$allowedtags['del'] = array(
			'datetime' => true
		);
		$allowedtags['pre'] = array(
			'lang' => true,
			'line' => true
		);
		$allowedtags['span'] = array(
			'style' => true
		);
		$allowedtags['img'] = array(
			'width' => true,
			'height' => true,
			'src' => true,
			'alt' => true
		);
		$allowedtags['a'] = array(
			'target' => true,
			'href' => true,
			'title' => true,
		);
	}
	
	
	
		
	/*
	****************************************************************
	Functions - Fonts tab
	****************************************************************
	*/
	// Google fonts
	public function wp_edit_pro_google_load_fonts() {
		
		$function_opts = $this->get_wp_edit_pro_function_opts();
	    
		$get_fonts = $function_opts['wp_edit_pro_fonts'];
		$opt_fonts = $get_fonts['save_google_fonts'];
		$font_list = '';
		
		if($opt_fonts) {
			
			$google_url_fonts = '';
			foreach($opt_fonts as $font_css) {
				$google_url_fonts .= str_replace(' ', '+', $font_css).'|';
			}
			$google_url_fonts = rtrim($google_url_fonts, '|');
			
			$google_url = '<link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family='.$google_url_fonts.'" />';
			
			echo $google_url;
		}
	}
	// Custom fonts
	public function wp_edit_pro_custom_load_fonts() {
		
		$function_opts = $this->get_wp_edit_pro_function_opts();
	    
		$get_fonts = $function_opts['wp_edit_pro_fonts'];
		$opt_fonts = $get_fonts['save_custom_fonts'];
		$font_list = '';
		
		if($opt_fonts) {
			
			$blog_id = get_current_blog_id();
					
			// Have to check which subsite we are on (1 = main site or network site 1)
			if($blog_id !== 1 && $this->network_activated == true && $this->network_admin_mode == 'separate') {
				
				$content_url = content_url();
				$url = $content_url . '/uploads/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/stylesheet/custom_font_styles.css';
			}
			else {
				
				if( is_multisite() == true && $blog_id !== 1 && $this->network_admin_mode == 'separate' ) {
					
					$content_url = network_site_url();
					$url = $content_url . 'wp-content/uploads/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/stylesheet/custom_fonts_styles.css';
				}
				else {
				
					$content_url = content_url();
					$url = $content_url . '/uploads/wp_edit_pro/custom_fonts/stylesheet/custom_fonts_styles.css';
				}
			}
								
			$custom_font_stylesheet_url = '<link type="text/css" rel="stylesheet" href="' . $url . '" />';
			echo $custom_font_stylesheet_url;
		}
	}
	
	
	/*
	****************************************************************
	Functions - Extras Tab
	****************************************************************
	*/
	// Signoff text shortcode
	public function wp_edit_pro_signoff_text() {
		
		$function_opts = $this->get_wp_edit_pro_function_opts();
		$jwl_signoff = isset($function_opts['wp_edit_pro_extras']['signoff_text']) ? $function_opts['wp_edit_pro_extras']['signoff_text'] : 'Please enter text here...';
		
		// Return signoff output (may contain shortcodes - add do_shortcode() filter)
		return do_shortcode($jwl_signoff);
	}
	// QR post metaboxes
	public function wp_edit_pro_add_box() {
		
		global $wpep_qr_metaboxes;
		
		add_meta_box($wpep_qr_metaboxes['id'], $wpep_qr_metaboxes['title'], array($this, 'wp_edit_pro_show_box'), $wpep_qr_metaboxes['page'], $wpep_qr_metaboxes['context'], $wpep_qr_metaboxes['priority']); // For Posts
		add_meta_box($wpep_qr_metaboxes['id'], $wpep_qr_metaboxes['title'], array($this, 'wp_edit_pro_show_box'), 'page', $wpep_qr_metaboxes['context'], $wpep_qr_metaboxes['priority']); // For Pages
	}
	public function wp_edit_pro_show_box() {
		
		global $wpep_qr_metaboxes, $post;
		
		// Use nonce for verification
		echo '<input type="hidden" name="jwl_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		
		echo '<div style="padding:5px;">';
		
			echo '<p>'.__('These options are post/page specific.', 'wp_edit_pro').'<br />';
			echo __('They will override corresponding global options set on the admin WP Edit Pro settings page.', 'wp_edit_pro').'</p>';
			
			$function_opts = $this->get_wp_edit_pro_function_opts();
			$options_qr = $function_opts['wp_edit_pro_extras']['enable_qr'];
			
			if ($options_qr == '1') {
				echo '<table class="form-table">';
			} 
			else {
				echo '<table class="form-table" style="display:none;">';
			}
				
			foreach ($wpep_qr_metaboxes['fields'] as $field) {
				
				// get current post meta data
				$meta = get_post_meta($post->ID, $field['id'], true);
				echo '<tr>',
						'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
						'<td>';
						
					switch ($field['type']) {
						
						case 'input':
							echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="60" />';
							break;
						case 'textarea':
							echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>';
							break;
						case 'checkbox':
							echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta=='on' ? ' checked="checked"' : '', ' /> ' . $field['desc'];
							break;
					}
				echo     '</td></tr>';
			}
			echo '</table>';
			
			if ($options_qr != '1') {
				
				?>
				<p style="color:#999999">
				<?php printf(__('Deactivated. If required, please activate via the <a href="%1$s">admin settings page</a>.', 'wp_edit_pro'), 'admin.php?page=wp_edit_pro_options&tab=extras'); ?>
				</p>
				<?php 
			}
		echo '</div>';
	}
	// Save qr metabox info
	public function wp_edit_pro_save_qr_data($post_id) {
		
		global $wpep_qr_metaboxes;
		// verify nonce
		if (( !isset( $_POST['jwl_meta_box_nonce'] ) || !wp_verify_nonce($_POST['jwl_meta_box_nonce'], basename(__FILE__)))) {
			return $post_id;
		}
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
		// check permissions
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
		
		foreach ($wpep_qr_metaboxes['fields'] as $field) {
			
			$old = get_post_meta($post_id, $field['id'], true);
			$new = isset($_POST[$field['id']]) ? $_POST[$field['id']] : '';
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
	// QR content filter
	public function wp_edit_pro_qr_content( $content ) {
		
		global $post;
		$meta_checkbox = get_post_meta($post->ID, 'jwl_qr_meta_checkbox', true);
		$meta_checkbox_shortcode = get_post_meta($post->ID, 'jwl_qr_meta_checkbox_shortcode', true);
		
		if(is_singular() && is_main_query() && ($meta_checkbox != 'on') && ($meta_checkbox_shortcode != 'on')) {  // Display only on posts, pages, and cpt's
			
			$function_opts = $this->get_wp_edit_pro_function_opts();
			$options_qr_colors = $function_opts['wp_edit_pro_extras']['qr_colors'];
			
			$meta_title = get_post_meta($post->ID, 'jwl_qr_meta_title', true);
			$meta_content = get_post_meta($post->ID, 'jwl_qr_meta_content', true);
			
			$title_text = (isset($meta_title) && ($meta_title != '')) ? $meta_title : $options_qr_colors['title_text'];
			$content_text = (isset($meta_content) && ($meta_content != '')) ? $meta_content : $options_qr_colors['content_text'];
			
			
			
			$content .= '<div class="jwl_qr_box">';
			
				$content .= '<div class="jwl_qr_header" style="padding-left:10px;background:#'.$options_qr_colors['background_title'].';color:#'.$options_qr_colors['text_color'].';">';
				
					$content .= '<span class="jwl_qr_header_text">'.$title_text.'</span>';
				$content .= '</div>';
				
				$content .= '<div class="jwl_qr_main" style="padding:10px;background:#'.$options_qr_colors['background_content'].';color:#'.$options_qr_colors['text_color'].';">';
				
					$content .= '<div class="jwl_qr_image" style="float:left;margin:0px 20px 20px 0;">';
					
						$content .= '<script type="text/javascript">var uri=window.location.href;document.write("<img width=\'75px\' height=\'75px\' style=\'width:75px;height:75px;\' src=\'//api.qrserver.com/v1/create-qr-code/?data="+encodeURI(uri)+"&size=75x75&color='.$options_qr_colors['qr_foreground_color'].'&bgcolor='.$options_qr_colors['qr_background_color'].'\'/>");</script>';
					$content .= '</div>';
					
					$content .= '<div class="jwl_qr_content">'.$content_text;
					$content .= '</div>';
					
					$content .= '<div style="clear:both;">';
					$content .= '</div>';
					
				$content .= '</div>';
			$content .= '</div>';
		}
		return $content;
	}
	// QR shortcode
	public function wp_edit_pro_qr_shortcode($atts) {
		
		global $post;
		$content = '';
		
		$function_opts = $this->get_wp_edit_pro_function_opts();
		$options_qr_colors = $function_opts['wp_edit_pro_extras']['qr_colors'];
		
		$meta_title = get_post_meta($post->ID, 'jwl_qr_meta_title', true);
		$meta_content = get_post_meta($post->ID, 'jwl_qr_meta_content', true);
		
		$title_text = (isset($meta_title) && ($meta_title != '')) ? $meta_title : $options_qr_colors['title_text'];
		$content_text = (isset($meta_content) && ($meta_content != '')) ? $meta_content : $options_qr_colors['content_text'];
		
		$content .= '<div class="jwl_qr_box">';
			
			$content .= '<div class="jwl_qr_header" style="padding-left:10px;background:#'.$options_qr_colors['background_title'].';color:#'.$options_qr_colors['text_color'].';">';
			
				$content .= '<span class="jwl_qr_header_text">'.$title_text.'</span>';
			$content .= '</div>';
			
			$content .= '<div class="jwl_qr_main" style="padding:10px;background:#'.$options_qr_colors['background_content'].';color:#'.$options_qr_colors['text_color'].';">';
			
				$content .= '<div class="jwl_qr_image" style="float:left;margin:0px 20px 20px 0;">';
				
					$content .= '<script type="text/javascript">var uri=window.location.href;document.write("<img width=\'75px\' height=\'75px\' style=\'width:75px;height:75px;\' src=\'//api.qrserver.com/v1/create-qr-code/?data="+encodeURI(uri)+"&size=75x75&color='.$options_qr_colors['qr_foreground_color'].'&bgcolor='.$options_qr_colors['qr_background_color'].'\'/>");</script>';
				$content .= '</div>';
				
				$content .= '<div class="jwl_qr_content">'.$content_text;
				$content .= '</div>';
				
				$content .= '<div style="clear:both;">';
				$content .= '</div>';
				
			$content .= '</div>';
		$content .= '</div>';
		
		return $content;
	}
	// Register QR widget
	public function wp_edit_pro_register_qr_widget() {
		
		register_widget('WpEditProQrWidget');  // Extended class from pre_class functions
	}
	
	
	/*
	****************************************************************
	Functions for update check and notice
	****************************************************************
	*/
	public function wpep_wpeditpro_update_check() {
	
		require_once(plugin_dir_path( __FILE__ ) . 'classes/autoupdate.php');
		
		$wpeditpro_data = get_plugin_data( __FILE__ );
		$wpeditpro_current_version = $wpeditpro_data['Version'];
		
		$wpeditpro_remote_path = 'https://wpeditpro.com/activations/updates/update.php';
		$wpeditpro_slug = plugin_basename(__FILE__);
		
		new wpeditpro_auto_update($wpeditpro_current_version, $wpeditpro_remote_path, $wpeditpro_slug);
	}
	public function wpep_add_upgrade_notice_opt() {
			
		$function_opts = $this->get_wp_edit_pro_option('wp_edit_pro_options_array');
		
		if(current_user_can('manage_options') && isset($function_opts['wpep_license_notice']) && $function_opts['wpep_license_notice'] === 'true') {
			
			global $current_user;
			$userid = $current_user->ID;
			
			if(isset($_GET['wpeditpro_update_expiry_notice']) && 'yes' == $_GET['wpeditpro_update_expiry_notice']) {
				
				// Update user meta
				$user_meta = get_user_meta($userid, 'aaa_wp_edit_pro_user_meta', true);
				$user_meta['ignore_wpeditpro_update_expiry_notice'] = 'true';
				update_user_meta($userid, 'aaa_wp_edit_pro_user_meta', $user_meta);
				
				//$plugin_opts = get_wp_edit_pro_option('wp_edit_pro_options_array');
				$function_opts['wp_edit_pro_license_notice'] = 'false';
				update_wp_edit_pro_option('wp_edit_pro_options_array', $function_opts);
			}
			
			$user_meta = get_user_meta($userid, 'aaa_wp_edit_pro_user_meta', true);
			if(!isset( $user_meta['ignore_wpeditpro_update_expiry_notice'] ) || $user_meta['ignore_wpeditpro_update_expiry_notice'] !== 'true') {
				
				// Admin top of page alert
				function wp_edit_pro_update_notice_expiry() {
					
					global $pagenow;
					$screen = get_current_screen();
					$screens = array();
					
					//if(is_multisite())
						$screens = array_merge(array('plugins-network', 'dashboard-network', 'update-core-network', 'toplevel_page_wp_edit_pro_options-network', 'wp-edit-pro_page_wp_edit_pro_license'), $screens);
					//else
						$screens = array_merge(array('plugins', 'dashboard', 'update-core', 'toplevel_page_wp_edit_pro_options', 'wp-edit-pro_page_wp_edit_pro_license'), $screens);
					
					if(in_array($screen->id, $screens)) {
						
						echo '<div class="error">';
							echo '<p>';
								_e('There is a new version of WP Edit Pro, but it appears the yearly updates have expired.', 'wp_edit_pro');
								echo '<br />';
								_e('Please <a target="_blank" href="https://wpeditpro.com/contact/">Contact Us</a> or visit the <a href="https://wpeditpro.com/buy-now/" target="_blank">Purchase Page</a> if you would like to add another year of plugin updates.', 'wp_edit_pro');
							echo '</p>';
							echo '<p style="float:right;"><a href="'.$pagenow.'?wpeditpro_update_expiry_notice=yes">Dismiss</a></p>';
							echo '<div style="clear:both;"></div>';
						echo '</div>';
					}
				}
				add_action( 'network_admin_notices', 'wp_edit_pro_update_notice_expiry');
				add_action( 'admin_notices', 'wp_edit_pro_update_notice_expiry');
			}
		}
				
		// Plugin row message
		if( isset( $function_opts['wpep_license_notice'] ) && $function_opts['wpep_license_notice'] == 'true' ) {
			
			$path = plugin_basename( __FILE__ );
	
			function wp_edit_pro_after_plugin_row_message( $plugin_file, $plugin_data, $status ) {
				
				echo '<tr class="active"><td>&nbsp;</td><td colspan="2">';
					echo '<span class="dashicons dashicons-warning" style="color:red;"></span> ';
					_e('Plugin Updates Expired. Please renew the license on our <a href="https://wpeditpro.com/buy-now" target="_blank">Website</a>.', 'wp_edit_pro');
				echo '</td></tr>';
			}
			add_action("after_plugin_row_{$path}", 'wp_edit_pro_after_plugin_row_message', 10, 3 );
		}
	}
	
	
	/*
	****************************************************************
	Helper functions for working with plugin options
	****************************************************************
	*/
	public function get_wp_edit_pro_option($option_name) {
		
		if($this->network_activated == true) {
			
			if($this->network_blog_id === '') {
				
				$get_opt = get_site_option($option_name);
			}
			else {
				
				switch_to_blog($this->network_blog_id);
				$get_opt = get_option($option_name);
				restore_current_blog();
			}
		}
		else {
			
			$get_opt = get_option($option_name);
		}
		
		return $get_opt;
	}
	public function update_wp_edit_pro_option($option_name, $option_value) {
		
		if($this->network_activated == true) {
			
			if($this->network_blog_id == '' || $this->network_blog_id == '1') {
				
				$update_opt = update_site_option($option_name, $option_value);
				update_option($option_name, $option_value);
			}
			else {
				
				switch_to_blog($this->network_blog_id);
				$update_opt = update_option($option_name, $option_value);
				restore_current_blog();
			}
		}
		else {
			
			$update_opt = update_option($option_name, $option_value);
			
			if( get_current_blog_id() == 1 ) {
				
				update_site_option($option_name, $option_value);
			}
		}
		
		return $update_opt;
	}
	public function delete_wp_edit_pro_option($option_name) {
		
		if($this->network_activated == true) {
			
			if($this->network_blog_id === '') {
				
				$delete_opt = delete_site_option($option_name);
			}
			else {
				
				switch_to_blog($this->network_blog_id);
				$delete_opt = delete_option($option_name);
				restore_current_blog();
			}
		}
		else {
			
			$delete_opt = delete_option($option_name);
		}
		
		return $delete_opt;
	}
	public function get_wp_edit_pro_function_opts() {
		
		if( $this->network_admin_mode === 'same' ) {
		
			return get_site_option('wp_edit_pro_options_array');
		}
		else {
			
			return get_option('wp_edit_pro_options_array');
		}
	}
	
	
	/*
	****************************************************************
	Delete custom fonts ajax call
	****************************************************************
	*/
	public function wp_edit_pro_custom_fonts_delete_row_callback() {
		
		// Get main options
		global $wpdb;
		$options = $this->get_wp_edit_pro_option('wp_edit_pro_options_array');
		
		// Get file name
		$font_name = isset($_POST['font_name']) ? $_POST['font_name'] : '';
		$result = '';
		
		if($font_name !== '') {
			
			// Delete all fonts with this font name
			//$blog_id = get_current_blog_id();
			$blog_id = $this->network_blog_id;
					
			// Have to check which subsite we are on (1 = main site or network site 1)
			if($blog_id == '' || $blog_id == '1') {
				
				$upload_dir = wp_upload_dir();
				$upload_path = $upload_dir['basedir'];
				$handle = $upload_path . '/wp_edit_pro/custom_fonts/';
			}
			else {
				
				$upload_dir = wp_upload_dir();
				$upload_path = $upload_dir['basedir'];
				$handle = $upload_path . '/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/';
			}
			
			// Delete Files
			if(file_exists($handle . $font_name . '.eot')) 
				unlink($handle . $font_name . '.eot');
			if(file_exists($handle . $font_name . '.svg')) 
				unlink($handle . $font_name . '.svg');
			if(file_exists($handle . $font_name . '.ttf')) 
				unlink($handle . $font_name . '.ttf');
			if(file_exists($handle . $font_name . '.woff')) 
				unlink($handle . $font_name . '.woff');
			if(file_exists($handle . $font_name . '.woff2')) 
				unlink($handle . $font_name . '.woff2');
			
			// Remove name from wpep options
			if(($key = array_search($font_name, $options['wp_edit_pro_fonts']['save_custom_fonts'])) !== false) {
				unset($options['wp_edit_pro_fonts']['save_custom_fonts'][$key]);
			}
			
			$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $options);  // Update plugin option
			$this->options_array = $options;  // Update public variable
			
			$result = 'success';
		
		
			// Write fonts to stylesheet
			
			// Have to check which subsite we are on (1 = main site or network site 1)
			// If custom css is found in stylesheet... create css file
			if($blog_id == '' || $blog_id == '1') {
				
				$upload_dir = wp_upload_dir();
				$upload_path = $upload_dir['basedir'];
				$file_stylesheet = $upload_path . '/wp_edit_pro/custom_fonts/stylesheet/custom_fonts_styles.css';
				
				$content_url = content_url();
				$file_stylesheet_url = $content_url . '/uploads/wp_edit_pro/custom_fonts/';
			}
			else {
				
				$upload_dir = wp_upload_dir();
				$upload_path = $upload_dir['basedir'];
				$file_stylesheet = $upload_path . '/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/stylesheet/custom_fonts_styles.css';
				
				
				$content_url = content_url();
				$file_stylesheet_url = $content_url . '/uploads/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/';
			}
			
			$custom_fonts = $options['wp_edit_pro_fonts']['save_custom_fonts'];
			
			// If custom fonts exist in db
			if(is_array($custom_fonts) && !empty($custom_fonts)) {
			
				$write = '';
				
				foreach($custom_fonts as $key => $value) {
					
					$write .= "@font-face { \n";
						$write .= "\t" . "font-family: '" . $value . "'; \n";
						$write .= "\t" . "src: url('" .$file_stylesheet_url . $value . ".eot'); \n";
						$write .= "\t" . "src: url('" .$file_stylesheet_url . $value . ".eot?#iefix')  format('embedded-opentype'), \n";
						$write .= "\t\t" . "url('" .$file_stylesheet_url . $value . ".woff2')  format('woff2'), \n";
						$write .= "\t\t" . "url('" .$file_stylesheet_url . $value . ".woff')  format('woff'), \n";
						$write .= "\t\t" . "url('" .$file_stylesheet_url . $value . ".ttf')  format('truetype'), \n";
						$write .= "\t\t" . "url('" .$file_stylesheet_url . $value . ".svg#" . $value . "')  format('svg'); \n";
					$write .= "} \n\n";
				}
				
				$handle = fopen($file_stylesheet, 'w') or die('Cannot open file:  '.$file_stylesheet);
				$data = $write;
				fwrite($handle, $data);
				fclose($handle);
			}
			// Else no custom fonts exist
			else {
				
				$write = ' ';
				
				$handle = fopen($file_stylesheet, 'w') or die('Cannot open file:  '.$file_stylesheet);
				$data = $write;
				fwrite($handle, $data);
				fclose($handle);
			}
		}
		
		// Return response
		$response = json_encode($result);
		header( "Content-Type: application/json" );
		echo $response;
	
		die();
	}
	
	
	/*
	****************************************************************
	Delete custom styles ajax call
	****************************************************************
	*/
	public function wp_edit_pro_custom_styles_delete_row_callback() {
	
		// Get main options
		global $wpdb;
		$options = $this->get_wp_edit_pro_option('wp_edit_pro_options_array');
		$options_custom_styles = $options['wp_edit_pro_styles']['custom_styles'];
		$result = 'ajax_error';
	
		// Get ajax value
		$delete_title = $_POST['title'];
		
		// Run Query to remove array
		foreach( $options_custom_styles as $i => $style ) {
			
			foreach( $style as $key => $value ) {
				
				if( $key == 'title' && $value == $delete_title ) {
					
					unset( $options_custom_styles[$i] );
					$result = 'success';
				}
			}
		}
		$options['wp_edit_pro_styles']['custom_styles'] = $options_custom_styles;
		
		// Update custom styles option with updated array
		$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $options);
		$this->options_array = $options;  // Update public variable
		
		// Return response
		$response = json_encode(array('result' => $result));
		header( "Content-Type: application/json" );
		echo $response;
	
		die();
	}
	
	
	/*
	****************************************************************
	Get all posts for insert/edit advanced link button
	****************************************************************
	*/
	public function wpeditpro_load_advlink_pages_callback() { 
	
		// Gt all registered post types
		$post_types = get_post_types( array( "public" => true ) );
		
		// Loop all post type and setup array of get_posts();
		foreach( $post_types as $post_type ) {
			
			$post_args = array(
				'posts_per_page'   => -1,
				'offset'           => 0,
				'category'         => '',
				'orderby'          => 'date',
				'order'            => 'ASC',
				'include'          => '',
				'exclude'          => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'post_type'        => $post_type,
				'post_mime_type'   => '',
				'post_parent'      => '',
				'post_status'      => '',
				'suppress_filters' => true 
			); 
			$results[] = get_posts($post_args);
		}
		
		// Loop array of get_posts()
		foreach( $results as $result ) {
			
			// Loop array of matched items
			foreach( $result as $k => $v ) {
				
				// If post type is not an attachment
				if( $v->post_type != 'attachment' ) {
					
					// Get the post object; to pass relevant info back to js
					$obj = get_post_type_object( $v->post_type );
					
					// Create final array of each post: id|permalink|title|label
					$final[] = array( 'id' => $v->ID, 'permalink' => get_permalink( $v->ID ), 'title' => get_the_title( $v->ID ), 'post_type' => $obj->labels->singular_name, 'post_date' => $v->post_date );
				}
			}
		}
		
		// Get sorting value from js
		$sorting = $_POST['sorting'];
		
		// Begin sorting
		if( $sorting == 'title_asc' ) {
			
			$alpha = array();
			foreach( $final as $key => $row ) { $alpha[$key] = $row['title']; }
			array_multisort( $alpha, SORT_ASC, $final );
		}
		elseif( $sorting == 'title_desc' ) {
			
			$alpha = array();
			foreach( $final as $key => $row ) { $alpha[$key] = $row['title']; }
			array_multisort( $alpha, SORT_DESC, $final );
		}
		elseif( $sorting == 'date_asc' ) {
			
			$alpha = array();
			foreach( $final as $key => $row ) { $alpha[$key] = $row['post_date']; }
			array_multisort( $alpha, SORT_ASC, $final );
		}
		elseif( $sorting == 'date_desc' ) {
			
			$alpha = array();
			foreach( $final as $key => $row ) { $alpha[$key] = $row['post_date']; }
			array_multisort( $alpha, SORT_DESC, $final );
		}
		elseif( $sorting == 'type_asc' ) {
			
			$alpha = array();
			foreach( $final as $key => $row ) { $alpha[$key] = $row['post_type']; }
			array_multisort( $alpha, SORT_ASC, $final );
		}
		elseif( $sorting == 'type_desc' ) {
			
			$alpha = array();
			foreach( $final as $key => $row ) { $alpha[$key] = $row['post_type']; }
			array_multisort( $alpha, SORT_DESC, $final );
		}
		elseif( $sorting == 'search_box' ) {
			
			$value = $_POST['value'];
			$final_search = '';
			
			if( $value != '' ) {
				foreach ( $final as $key => $val ) {
					if( strpos( strtolower( $val['title'] ), strtolower( $value ) ) !== false ) {
						$final_search[] = array( 'id' => $val['id'], 'permalink' => $val['permalink'], 'title' => $val['title'], 'post_type' => $val['post_type'], 'post_date' => $val['post_date'] );
					}
				}
			}
			else { $final_search = $final; }
			
			$alpha = array();
			if( is_array( $final_search ) ) {
				
				foreach ( $final_search as $key => $row ) { $alpha[$key] = $row['title']; }
				array_multisort( $alpha, SORT_ASC, $final_search );
			}
			else {
				
				$final_search = array( array( 'id' => '', 'permalink' => '', 'title' => 'No Results Found', 'post_type' => '', 'post_date' => '' ) );
			}
				
			$final = $final_search;
		}
		else {
			
			$alpha = array();
			foreach( $final as $key => $row ) {
				
				$alpha[$key] = $row['title'];
			}
			array_multisort( $alpha, SORT_ASC, $final );
		}
		
		$response = json_encode( array( 'final' => $final ) );
		header( "Content-Type: application/json" );
		echo $response;
		
		die();	
	}
	
	
	/*
	****************************************************************
	Create API call to plugin external script
	****************************************************************
	*/
	public function wp_edit_pro_api_call($action, $ip) {
		
		// Get db values
		$status = $this->get_wp_edit_pro_option( 'wp_edit_pro_license_status' );
		$transid = $this->get_wp_edit_pro_option( 'wp_edit_pro_license_transid' );
		
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_version = $plugin_data['Version'];
		
		// Define extra data
		$current_user 		= wp_get_current_user();
		$user_email 		= $current_user->user_email;
		$user_firstname 	= $current_user->user_firstname;
		$user_lastname 		= $current_user->user_lastname;
		$user_url 			= get_bloginfo('url');
		$user_admin_email 	= get_bloginfo('admin_email');
 
		// Define array to send in our API request
		$api_params = array( 
		
			'wpeditpro_action'	=> $action,              								// Action -> Activate License
			'transid' 	        => trim($transid),    									// Transaction ID submitted by user
			'user_ip' 	        => $ip,              									// IP submitted by hidden field
			'user_email' 	    => $user_email,           								// Admin - Email
			'user_firstname' 	=> $user_firstname,       								// Admin - First name
			'user_lastname' 	=> $user_lastname,        								// Admin - Last name
			'user_url' 	        => $user_url,             								// Admin - URL
			'user_admin_email' 	=> $user_admin_email,      								// Admin - Email
			'plugin_version'    => $plugin_version                                      // Plugin version
		);

		// Call the custom API
		$encoded_url = add_query_arg( $api_params, 'https://wpeditpro.com/activations/wp_edit_pro_activation_script.php' );
		$response = wp_remote_get( $encoded_url, array( 'timeout' => 30 ) );
		
		return $response;
	}
	
}

$WP_EDIT_PRO = WP_EDIT_PRO::get_instance();
