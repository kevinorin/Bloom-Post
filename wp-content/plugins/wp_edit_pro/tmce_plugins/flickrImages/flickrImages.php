<?php

/*
 * @author Josh Lobe
 * https://wpeditpro.com
*/

$wp_include = "../wp-load.php";
 
$i = 0;
while(!file_exists($wp_include) && $i++ < 10){ 
  $wp_include = "../$wp_include";
}
 
require($wp_include);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title><?php _e('Flickr Image Search', 'wp_edit_pro'); ?></title>
        
        <!-- Get jquery from WP -->
        <!--<script type="text/javascript" src="//code.jquery.com/jquery-2.2.0.min.js"></script>-->
        <script type="text/javascript" src="<?php echo includes_url() . 'js/jquery/jquery.js'; ?>"></script>
        
        <!-- Get bootsrap css and js -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script type="text/javascript" src="includes/bootstrap-paginator.js"></script>
        
        <link rel="stylesheet" type="text/css" href="includes/featherlight.css" />
        <script type="text/javascript" src="includes/featherlight.js"></script>
        
        <!-- Load this plugin css and js -->
        <link rel="stylesheet"  type="text/css" href="includes/flickrImages.css" />
        <script type="text/javascript" src="includes/flickrImages.js"></script>
    </head>
    <body>
    
    	<div id="container_div">
        
        	<div id="search_div">
            	
                <?php _e('Enter search keywords.', 'wp_edit_pro'); ?>
                <p><input type="text" id="search_text" class="form-control" name="search_text" /></p>
                <p id="search_term_error"></p>
                <button type="button" id="search_text_submit" class="btn btn-primary" name="search_text_submit"><?php _e('Search', 'wp_edit_pro'); ?></button>
            </div>
            
            <div id="search_results_div"></div>
            
            <div id="pagination_div"></div>
            <div id="preloader_div"><img src="images/loading.gif" id="loading-indicator" style="display:none" /></div>
            <div id="pagination_count_div"><?php _e('Page', 'wp_edit_pro'); ?> <span class="page_number">1</span> <?php _e('of', 'wp_edit_pro'); ?> <span class="results_number">1</span></div>
        </div>
    </body>
</html>