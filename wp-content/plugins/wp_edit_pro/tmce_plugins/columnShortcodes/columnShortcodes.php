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

<!--<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
<!-- Get jquery from WP -->
<script type="text/javascript" src="<?php echo includes_url() . 'js/jquery/jquery.js'; ?>"></script>
    
    
<script type="text/javascript" src="includes/columnShortcodes.js"></script>
<link rel="stylesheet" href="includes/columnShortcodes.css" />

<div id="body" style="padding:0 20px;">
	
    <div>
        <p style="font-size:18px;"><?php _e('Select number of columns', 'wp_edit_pro'); ?>:</p>
        <select id="select_column_number">
            <option value=""><?php _e('Select...', 'wp_edit_pro'); ?></option>
            <option value="two"><?php _e('Two', 'wp_edit_pro'); ?></option>
            <option value="three"><?php _e('Three', 'wp_edit_pro'); ?></option>
            <option value="four"><?php _e('Four', 'wp_edit_pro'); ?></option>
            <option value="five"><?php _e('Five', 'wp_edit_pro'); ?></option>
            <option value="six"><?php _e('Six', 'wp_edit_pro'); ?></option>
        </select>
    </div>
    
    <div style="margin-top:20px;"></div>
    
    <div id="populate_select_sizes">
    </div>
    
    <div style="margin-top:20px;"></div>
    
    <div id="size_preview">
    </div>
</div>