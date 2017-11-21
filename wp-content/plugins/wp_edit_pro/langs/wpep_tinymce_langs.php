<?php

if ( ! defined( 'ABSPATH' ) )
    exit;
 
if ( ! class_exists( '_WP_Editors' ) )
    require( ABSPATH . WPINC . '/class-wp-editor.php' );
 
function wpep_tinymce_translation() {
	
    $strings = array(
		
		/* Abbreviation */
		'abbr_tooltip' => __('Abbreviation', 'wp_edit_pro'),
		'abbr_edit' => __('Edit Abbreviation', 'wp_edit_pro'),
		'abbr_title' => __('Abbreviation Title', 'wp_edit_pro'),
		'abbr_sel' => __('Selection', 'wp_edit_pro'),
		
		/* Accessibility Checker */
		'acheck_tooltip' => __('Accessibility Checker', 'wp_edit_pro'),
		'acheck_message' => __('Submitting Code for Accessibility Checking...', 'wp_edit_pro'),
		
		/* Advanced HR */
		'advhr_tooltip' => __('Advanced Horizontal Line', 'wp_edit_pro'),
		
		/* Advanced Insert/Edit Image */
		'advimg_tooltip' => __('Advanced Insert/Edit Image', 'wp_edit_pro'),
		'advimg_not_number_title' => __('Fields Not Completed', 'wp_edit_pro'),
		'advimg_not_number' => __('The value must be a number.', 'wp_edit_pro'),
		'advimg_not_range' => __('The value must be between 0 and 100.', 'wp_edit_pro'),
		
		/* Advanced Insert/Edit Link */
		'advlink_tooltip' => __('Insert/Edit Advanced Link', 'wp_edit_pro'),
		
		/* Advanced List */
		'advlist_blist' => __('Bulleted list', 'wp_edit_pro'),
		'advlist_nlist' => __('Numbered list', 'wp_edit_pro'),
		'advlist_default' => __('default', 'wp_edit_pro'),
		'advlist_circle' => __('circle', 'wp_edit_pro'),
		'advlist_disc' => __('disc', 'wp_edit_pro'),
		'advlist_square' => __('square', 'wp_edit_pro'),
		'advlist_lalpha' => __('lower-alpha', 'wp_edit_pro'),
		'advlist_lgreek' => __('lower-greek', 'wp_edit_pro'),
		'advlist_lroman' => __('lower-roman', 'wp_edit_pro'),
		'advlist_ualpha' => __('upper-alpha', 'wp_edit_pro'),
		'advlist_uroman' => __('upper-roman', 'wp_edit_pro'),
		
		/* Anchor */
		'anchor_title' => __('Anchor', 'wp_edit_pro'),
		'anchor_label' => __('Name', 'wp_edit_pro'),
		
		/* Classes IDs */
		// TODO....
		
		/* Clear Div */
		'cdiv_tooltip' => __('Clear Div', 'wp_edit_pro'),
		'cdiv_cleft' => __('Clear Left', 'wp_edit_pro'),
		'cdiv_cright' => __('Clear Right', 'wp_edit_pro'),
		'cdiv_cboth' => __('Clear Both', 'wp_edit_pro'),
		
		/* Clickr */
		'clker_tooltip' => __('Clker Images', 'wp_edit_pro'),
		'clker_loading' => __('Loading Images...', 'wp_edit_pro'),
		'clker_loading_t' => __('Loading...', 'wp_edit_pro'),
		'clker_entries' => __('entries found', 'wp_edit_pro'),
		'clker_sml' => __('Sml', 'wp_edit_pro'),
		'clker_med' => __('Med', 'wp_edit_pro'),
		'clker_lrg' => __('Lrg', 'wp_edit_pro'),
		'clker_error_ajax' => __('Error loading youtube video results.', 'wp_edit_pro'),
		
		/* Code */
		'code_title' => __('Source Code', 'wp_edit_pro'),
		
		/* Code Magic */
		'codem_title' => __('Code Magic', 'wp_edit_pro'),
		'codem_no_match' => __('Nothing Found.', 'wp_edit_pro'),
		'codem_no_replace' => __('Nothing to Replace.', 'wp_edit_pro'),
		
		/* Color Picker */
		'cpicker_title' => __('Color', 'wp_edit_pro'),
		
		/* Column Shortcodes */
		'cshort_title' => __('Column Shortcodes', 'wp_edit_pro'),
		'cshort_sel_size' => __('Select column sizes', 'wp_edit_pro'),
		'cshort_select' => __('Select ...', 'wp_edit_pro'),
		'cshort_preview' => __('Preview', 'wp_edit_pro'),
		'cshort_content' => __('Content', 'wp_edit_pro'),
		'cshort_insert' => __('Insert', 'wp_edit_pro'),
		
		/* Context Menu */
		// No strings to translate
		
		/* Directionality */
		'direct_ltr' => __('Left to Right', 'wp_edit_pro'),
		'direct_rtl' => __('Right to Left', 'wp_edit_pro'),
		
		/* Dropbox */
		'dropbox_title' => __('Dropbox', 'wp_edit_pro'),
		'dropbox_no_app_key' => __('Oops. The WP Edit Pro Dropbox App Key has not been saved.', 'wp_edit_pro'),
		'dropbox_no_app_key2' => __('Please visit the WP Edit Pro settings page (Editor tab), and set a Dropbox App Key.', 'wp_edit_pro'),
		
		/* Emoticons */
		'emoticon_tooltip' => __('Emoticons', 'wp_edit_pro'),
		
		/* Flickr Search */
        'flickr_button_label' => __('Flickr Image Search', 'wp_edit_pro'),
		'flickr_search_error' => __('Please enter a search keyword to search Flickr Images.', 'wp_edit_pro'),
		'flickr_first' => __('First', 'wp_edit_pro'),
		'flickr_prev' => __('Previous', 'wp_edit_pro'),
		'flickr_next' => __('Next', 'wp_edit_pro'),
		'flickr_last' => __('Last', 'wp_edit_pro'),
		'flickr_view' => __('View', 'wp_edit_pro'),
		'flickr_insert' => __('Insert', 'wp_edit_pro'),
		'flickr_no_results' => __('No results were found to display. Please check the spelling of the search keywords; or try a more general search keyword.', 'wp_edit_pro'),
		
		/* Format Painter */
		// TODO...
		
		/* HR */
		// TODO...
		
		/* Image Orig */
		// TODO...
		
		/* Image Map */
		// TODO...
		
		/* Insert DateTime */
		// TODO...
		
		/* Line Break */
		// TODO...
		
		/* Lorem Ipsum */
		// TODO...
		
		/* Mail To */
		// TODO...
		
		/* Non Breaking */
		// TODO...
		
		/* Preview */
		// TODO...
		
		/* Print */
		// TODO...
		
		/* P Tag */
		// TODO...
		
		/* Search Replace */
		// TODO...
		
		/* Shortcodes */
		// TODO...
		
		/* Table */
		// TODO...
		
		/* Visual Blocks */
		// TODO...
		
		/* HTML Elements */
		// TODO...
		
		/* NO Wpautop */
		// TODO...
		
		/* YouTube */
		// TODO...
		'youtube_button_label' => __('YouTube Video', 'wp_edit_pro'),
		'youtube_window_label' => __('Select YouTube Video', 'wp_edit_pro')
    );
 
    $locale = _WP_Editors::$mce_locale;
    $translated = 'tinyMCE.addI18n("' . $locale . '.wpep_langs", ' . json_encode( $strings ) . ");\n";
 
    return $translated;
}
 
$strings = wpep_tinymce_translation();