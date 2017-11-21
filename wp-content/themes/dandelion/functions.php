<?php
$themename = "Dandelion";
$shortname = "dandelion";

$functions_path= TEMPLATEPATH . '/functions/';
add_action('admin_menu', 'mytheme_add_admin');

if(is_admin() && basename($_SERVER[PHP_SELF]) != 'update-core.php'){
require('update-notifier.php');
}

/* ------------------------------------------------------------------------*
 * DEFINE THE MAIN CONSTANTS THAT WILL BE USED WITHIN THE THEME
 * ------------------------------------------------------------------------*/

define("PEXETO_FUNCTIONS_PATH", TEMPLATEPATH . '/functions/');
define("PEXETO_FUNCTIONS_URL", get_template_directory_uri().'/functions/');
define("PEXETO_TIMTHUMB_URL", PEXETO_FUNCTIONS_URL.'timthumb.php');
define("PEXETO_OPTIONS_URL", get_template_directory_uri().'/functions/options/');
define("PEXETO_OPTIONS_PATH", PEXETO_FUNCTIONS_PATH.'/options/');
define("PEXETO_IMAGES_URL", PEXETO_OPTIONS_URL.'images/');
define("PEXETO_CSS_URL", PEXETO_OPTIONS_URL.'css/');
define("PEXETO_SCRIPT_URL", PEXETO_OPTIONS_URL.'script/');
define("PEXETO_PATTERNS_URL", PEXETO_OPTIONS_URL.'images/pattern_samples/');
define("PEXETO_SEPARATOR", '|*|');

define("PEXETO_SHORTNAME", $shortname);

$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
define("PEXETO_VERSION", $theme_data['Version']);

$uploadsdir=wp_upload_dir();
define("PEXETO_UPLOADS_URL", $uploadsdir['url']);


define("OPTIONS_HEADING", 'This is the '.$themename.' options page where you can do most of the theme settings. Please note
that there is a documentation included where all the theme customization settings are explained. The documentation
is located within the <strong>documentation</strong> folder. <br/><br/>
<strong>If you have any questions, please refer to the Support section of the documentation.</strong>');

/* ------------------------------------------------------------------------*
 * INCLUDE THE FUNCTIONS FILES
 * ------------------------------------------------------------------------*/
require_once (PEXETO_FUNCTIONS_PATH.'general.php');  //some main common functions
require_once (PEXETO_FUNCTIONS_PATH.'sidebars.php');  //the sidebar functionality
require_once (PEXETO_OPTIONS_PATH.'options.php');  //the theme options functionality
require_once (PEXETO_FUNCTIONS_PATH.'portfolio.php');  //portfolio functionality
require_once (PEXETO_FUNCTIONS_PATH.'comments.php');  //the comments functionality
require_once (PEXETO_FUNCTIONS_PATH.'meta.php');  //adds the custom meta fields to the posts and pages
require_once (PEXETO_FUNCTIONS_PATH.'shortcodes.php');  //the shortcodes functionality
require_once (PEXETO_FUNCTIONS_PATH.'contact.php');  //contact form functionality



add_action('admin_enqueue_scripts', 'pexeto_admin_init');

/**
 * Enqueues the JavaScript files needed depending on the current section.
 */
function pexeto_admin_init(){
	global $current_screen;
	
	//enqueue the script and CSS files for the TinyMCE editor formatting buttons
	if($current_screen->base=='post'){
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-dialog');
		
		//set the style files
		add_editor_style('functions/formatting-buttons/custom-editor-style.css');
		wp_enqueue_style('pexeto-page-style',PEXETO_CSS_URL.'page_style.css');
	}
	
	if(isset($_GET['page']) && $_GET['page']=='options'){
		//enqueue the scripts for the Options page
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('pexeto-jquery-co',PEXETO_SCRIPT_URL.'jquery-co.js');
		wp_enqueue_script('pexeto-ajaxupload',PEXETO_SCRIPT_URL.'ajaxupload.js');
		wp_enqueue_script('pexeto-colorpicker',PEXETO_SCRIPT_URL.'colorpicker.js');
		wp_enqueue_script('pexeto-options',PEXETO_SCRIPT_URL.'options.js');

		//enqueue the styles for the Options page
		wp_enqueue_style('pexeto-admin-style',PEXETO_CSS_URL.'admin_style.css');
		wp_enqueue_style('pexeto-colorpicker-style',PEXETO_CSS_URL.'colorpicker.css');
	}
	
	if($current_screen->id=='portfolio'){
		//enqueue the scripts needed for the add/edit portfolio post
		wp_enqueue_script('pexeto-ajaxupload',PEXETO_SCRIPT_URL.'ajaxupload.js');
		wp_enqueue_script('pexeto-options',PEXETO_SCRIPT_URL.'options.js');
	}

	if($current_screen->id=='page'){
		//enqueue the scripts needed for the add/edit page page
		wp_enqueue_script('pexeto-options',PEXETO_SCRIPT_URL.'page-options.js');
	}

	if(isset($_GET['page']) && ($_GET['page']=='theme-update-notifier')){
		//enqueue the scripts for the Update notifier page
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('pexeto-update',PEXETO_SCRIPT_URL.'update-notifier.js');

		//enqueue the styles for the Update notifier page
		wp_enqueue_style('pexeto-update-style',PEXETO_CSS_URL.'update-notifier.css');
		wp_enqueue_style('pexeto-admin-style',PEXETO_CSS_URL.'page_style.css');
	}
}
/**
 * Custom Font Styles
 */

function make_mce_awesome( $init ) {
    // our Options will go here..
$init['theme_advanced_text_colors'] = 'd2700e,0486d3';
    return $init;
}
 
add_filter('tiny_mce_before_init', 'make_mce_awesome');

/**
 * Load all the CSS and JavaScript files needed for the Pexeto Panel.
 */
function admin_head_add()
{
	if(isset($_GET['page']) && $_GET['page']=='options'){
		
		//init the options js functionality
		echo '<script>jQuery(function(){
				pexetoOptions.init({cookie:true});
							
			});</script>
			<!--[if IE 9]>
		<style type="text/css">
		.tab_navigation ul li.ui-tabs-selected a.tab span, .tab_navigation ul li.ui-tabs-selected a.tab span{
		top:-1px;
		position:relative;
		}
		
		.tab_navigation ul li.ui-tabs-selected a.tab{
		position:relative;
		top:1px;
		}
		</style>
		<![endif]-->';
	}
}
 
function bp_do_paypal() {

  $returnme = "<div class='paypal-shortcode' align='center' style='margin-bottom:30px;'>
<form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'><input name='cmd' type='hidden' value='_s-xclick' /> <input name='encrypted' type='hidden' value='-----BEGIN PKCS7-----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-----END PKCS7-----' /> <input alt='PayPal - The safer, easier way to pay online!' name='submit' src='https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif' type='image' /> <img class='aligncenter' src='https://www.paypalobjects.com/en_US/i/scr/pixel.gif' alt='' width='1' height='1' border='0' /></form> 
</div>";

  return $returnme;
 
}
add_shortcode( 'bp_paypal', 'bp_do_paypal' );



?>
