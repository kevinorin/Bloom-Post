<?php

/**
 * @author Josh Lobe
 * http://wpeditpro.com
 */

$wp_include = "../wp-load.php";
 
$i = 0;
while(!file_exists($wp_include) && $i++ < 10){ 
  $wp_include = "../$wp_include";
}
 
require($wp_include);
?>
<!-- Get jquery from WP -->
<script type="text/javascript" src="<?php echo includes_url() . 'js/jquery/jquery.js'; ?>"></script>
<!--<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->

<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="includes/advlink.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="includes/advlink.css" />

<div id="body">
    	
    <div id="tabbed_content">
    	<ul>
        	<li><a href="#tabbed_content_main"><?php _e('Main', 'wp_edit_pro'); ?></a></li>
            <li><a href="#tabbed_content_js"><?php _e('Events', 'wp_edit_pro'); ?></a></li>
        </ul>
        
        <div id="tabbed_content_main">
        
            <div id="options_block">
                
                <table cellpadding="3" id="adv_link_table">
                <tbody>
                <tr>
                    <td>
                    <label id="advlink_link_label" for="advlink_link" title="<?php _e('Enter a URL for this link.', 'wp_edit_pro'); ?>"><?php _e('Link Url', 'wp_edit_pro'); ?></label>
                    </td><td>
                    <input type="text" id="advlink_link" placeholder="http://example.com" />
                    </td>
                </tr>
                <tr>
                    <td>
                    <label id="advlink_link_title" for="advlink_title" title="<?php _e('Enter a Title for this link.', 'wp_edit_pro'); ?>"><?php _e('Link Title', 'wp_edit_pro'); ?></label>
                    </td><td>
                    <input type="text" id="advlink_title" />
                    </td>
                </tr>
                <tr>
                    <td>
                    <label id="advlink_id_label" for="advlink_id" title="<?php _e('Enter an ID for this link.', 'wp_edit_pro'); ?>"><?php _e('ID', 'wp_edit_pro'); ?></label>
                    </td><td>
                    <input type="text" id="advlink_id" />
                    </td>
                </tr>
                <tr>
                    <td>
                    <label id="advlink_classes_label" for="advlink_classes" title="<?php _e('Enter space separated class names for this link.', 'wp_edit_pro'); ?>"><?php _e('Classes', 'wp_edit_pro'); ?></label>
                    </td><td>
                    <input type="text" id="advlink_classes" />
                    </td>
                </tr>
                <tr>
                    <td>
                    <label id="advlink_style_label" for="advlink_style" title="<?php _e('Enter custom css for this link.', 'wp_edit_pro'); ?>"><?php _e('Style', 'wp_edit_pro'); ?></label>
                    </td><td>
                    <input type="text" id="advlink_style" />
                    </td>
                </tr>
                <tr>
                    <td>
                    <?php _e('Target', 'wp_edit_pro'); ?>
                    </td><td>
                    <select id="advlink_target">
                        <option value="select"><?php _e('Select...', 'wp_edit_pro'); ?></option>
                        <option value="_blank">_blank</option>
                        <option value="_self">_self</option>
                        <option value="_parent">_parent</option>
                        <option value="_top">_top</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td>
                    <?php _e('NoFollow', 'wp_edit_pro'); ?>
                    </td><td>
                    <input type="checkbox" id="advlink_nofollow" /><label id="advlink_nofollow_label" for="advlink_nofollow"><?php _e('Off', 'wp_edit_pro'); ?></label>
                    </td>
                </tr>
                </tbody>
                </table>
                
            </div>
            <br />
            <span id="load_results" class="close"><?php _e('Or link to existing content', 'wp_edit_pro'); ?> </span><br />
            
            <div id="search_block">
            
                <div id="page_controls">
                    <span style="font-weight:bold;"><?php _e('Sorting', 'wp_edit_pro'); ?></span>
                    <table>
                    <tbody>
                    <tr>
                        <td><?php _e('Title', 'wp_edit_pro'); ?>: </td>
                        <td> <select class="select_sort"><option value="select"><?php _e('Select', 'wp_edit_pro'); ?></option><option value="title_asc"><?php _e('ASC', 'wp_edit_pro'); ?></option><option value="title_desc"><?php _e('DESC', 'wp_edit_pro'); ?></option></select> </td>
                        <td> <?php _e('Date', 'wp_edit_pro'); ?>: </td>
                        <td> <select class="select_sort"><option value="select"><?php _e('Select', 'wp_edit_pro'); ?></option><option value="date_asc"><?php _e('ASC', 'wp_edit_pro'); ?></option><option value="date_desc"><?php _e('DESC', 'wp_edit_pro'); ?></option></select> </td>
                        <td> <?php _e('Type', 'wp_edit_pro'); ?>: </td>
                        <td> <select class="select_sort"><option value="select"><?php _e('Select', 'wp_edit_pro'); ?></option><option value="type_asc"><?php _e('ASC', 'wp_edit_pro'); ?></option><option value="type_desc"><?php _e('DESC', 'wp_edit_pro'); ?></option></select> </td>
                    </tr>
                    </tbody>
                    </table>
                    <span style="font-weight:bold;"><?php _e('Search', 'wp_edit_pro'); ?></span>
                    <table>
                    <tbody>
                    <tr>
                        <td><input type="text" class="select_search" /></td>
                    </tr>
                    </tbody>
                    </table>
                    <br />
                </div>
                <span style="font-weight:bold;"><?php _e('Results', 'wp_edit_pro'); ?></span>
                <div id="wp_page_results">
                </div>
                
            </div>
        </div>
        
        <div id="tabbed_content_js">
        
        	<p><?php _e('Events can be used to perform a javascript function at a specified time (or event). This may include when a viewer clicks a link; or when a viewer hovers over the link with the mouse.', 'wp_edit_pro'); ?></p>
            <p><?php _e('For more on javascript events; please visit the following resources:', 'wp_edit_pro'); ?><br />
            <a target="_blank" href="http://www.w3schools.com/js/js_events.asp"><?php _e('Javascript Events', 'wp_edit_pro'); ?></a><br />
            <a target="_blank" href="http://www.javascriptkit.com/javatutors/event1.shtml"><?php _e('Understanding Javascript Event Handlers', 'wp_edit_pro'); ?></a>
            </p>
        
        	<table cellpadding="3" id="adv_link_table">
            <tbody>
            <tr>
                <td>
                <label id="advlink_onclick_label" for="advlink_onclick_event" title="<?php _e('Fires on a mouse click on the element.', 'wp_edit_pro'); ?>">onclick</label>
                </td><td>
                <input type="text" id="advlink_onclick_event" placeholder="" />
                </td>
            </tr>
            <tr>
                <td>
                <label id="advlink_ondblclick_label" for="advlink_ondblclick_event" title="<?php _e('Fires on a mouse double-click on the element.', 'wp_edit_pro'); ?>">ondblclick</label>
                </td><td>
                <input type="text" id="advlink_ondblclick_event" placeholder="" />
                </td>
            </tr>
            <tr>
                <td>
                <label id="advlink_onmousedown_label" for="advlink_onmousedown_event" title="<?php _e('Fires when a mouse button is pressed down on an element.', 'wp_edit_pro'); ?>">onmousedown</label>
                </td><td>
                <input type="text" id="advlink_onmousedown_event" placeholder="" />
                </td>
            </tr>
            <tr>
                <td>
                <label id="advlink_onmouseout_label" for="advlink_onmouseout_event" title="<?php _e('Fires when the mouse pointer moves out of an element.', 'wp_edit_pro'); ?>">onmouseout</label>
                </td><td>
                <input type="text" id="advlink_onmouseout_event" placeholder="" />
                </td>
            </tr>
            <tr>
                <td>
                <label id="advlink_onmouseover_label" for="advlink_onmouseover_event" title="<?php _e('Fires when the mouse pointer moves over an element.', 'wp_edit_pro'); ?>">onmouseover</label>
                </td><td>
                <input type="text" id="advlink_onmouseover_event" placeholder="" />
                </td>
            </tr>
            <tr>
                <td>
                <label id="advlink_onmouseup_label" for="advlink_onmouseup_event" title="<?php _e('Fires when a mouse button is released over an element.', 'wp_edit_pro'); ?>">onmouseup</label>
                </td><td>
                <input type="text" id="advlink_onmouseup_event" placeholder="" />
                </td>
            </tr>
            </tbody>
            </table>
            
            <br /><br />
            <p><?php _e('<strong>NOTE:</strong> It may be necessary to use the WP Edit Pro "Configuration" tab to set the <strong>valid_elements</strong> setting to <strong>*[*]</strong>; which will allow the events to be preserved in the editor when switching views and saving.', 'wp_edit_pro'); ?></p>
        </div>
    </div>
</div>
<br />
<button id="advlink_cancel" class="btn-default"><?php _e('Cancel', 'wp_edit_pro'); ?></button> <button id="advlink_insert" class="btn-primary"><?php _e('Insert and Close', 'wp_edit_pro'); ?></button>
<br /><br />