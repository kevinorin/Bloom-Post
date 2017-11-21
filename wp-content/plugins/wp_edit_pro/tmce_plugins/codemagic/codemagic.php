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
<!--
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->

<!-- Get jquery from WP -->
<script type="text/javascript" src="<?php echo includes_url() . 'js/jquery/jquery.js'; ?>"></script>

<script type="text/javascript" src="https://wpeditpro.com/plugin_scripts/js_beautify.js"></script>
<script type="text/javascript" src="includes/codemirror/codemirror.js"></script>
<script type="text/javascript" src="includes/batched_scripts.js"></script>
<script type="text/javascript" src="includes/codemagic.js"></script>

<link rel="stylesheet" href="includes/codemagic.css" />
<link rel="stylesheet" href="includes/codemirror/codemirror.css" />

<div id="body">

	<div id="wrapline">
        <input type="checkbox" name="wraptext" id="wraptext" checked="checked" /> <?php _e('Wrap text', 'wp_edit_pro'); ?> 
        <input type="checkbox" name="autocompletion" id="autocompletion" checked="checked" /> <?php _e('Auto completion', 'wp_edit_pro'); ?> 
        <input type="checkbox" name="highlighting" id="highlighting" checked="checked" /> <?php _e('Highlight Code', 'wp_edit_pro'); ?>
    </div>
    <div style="clear: both;"></div>

	 <div class="editor-buttons">
        <a id="undo" class="disabled" title="<?php _e('Undo', 'wp_edit_pro'); ?>"><img src="images/icons/undo.png" alt="Undo" /> <?php _e('Undo', 'wp_edit_pro'); ?></a>
        <a id="redo" class="disabled" title="<?php _e('Redo', 'wp_edit_pro'); ?>"><img src="images/icons/redo.png" alt="Redo" /> <?php _e('Redo', 'wp_edit_pro'); ?></a>
        <a id="search_replace" title="<?php _e('Search and Replace', 'wp_edit_pro'); ?>"><img src="images/icons/lens.png" alt="Search and Replace" /> <?php _e('Search/Replace', 'wp_edit_pro'); ?></a>
        <a id="re_beautify" title="<?php _e('Format HTML Code', 'wp_edit_pro'); ?>"><img src="images/icons/file.png" alt="Format HTML Code" /> <?php _e('Reformat', 'wp_edit_pro'); ?></a>
    </div>  
    <div style="clear:both;"></div>
    
    <div id="search_panel">
    	<span id="search_query"><label for="query"><?php _e('Search', 'wp_edit_pro'); ?></label>: <input id="query" type="text" class="form-control" /></span>
        <span id="replace_query"><label for="replace"><?php _e('Replace', 'wp_edit_pro'); ?></label>: <input id="replace" type="text"  class="form-control" /></span>
        <span id="search_button"><input id="search_code" type="submit" value="<?php _e('Search', 'wp_edit_pro'); ?>" class="btn-default" /></span>
        <span id="replace_button"><input id="replace_code" type="submit" value="<?php _e('Replace', 'wp_edit_pro'); ?>" class="btn-default" /></span>
    </div>
    <div style="clear:both;"></div>

	<textarea name="htmlSource" id="htmlSource" rows="25" cols="100" class="htmlSource"></textarea>
	
    <div class="mceActionPanel">
        <button id="codemagic_cancel" class="btn-default"><?php _e('Cancel', 'wp_edit_pro'); ?></button> <button id="codemagic_insert" class="btn-primary"><?php _e('Insert and Close', 'wp_edit_pro'); ?></button>
    </div>
</div>