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
<script type="text/javascript" src="colpick/js/colpick.js"></script>
<script type="text/javascript" src="includes/advimage.js"></script>

<!-- jQuery Confirm -->
<script src="<?php echo plugins_url(); ?>/wp_edit_pro/js/jquery-confirm.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/wp_edit_pro/css/jquery-confirm.css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="colpick/css/colpick.css" type="text/css" />
<link rel="stylesheet" href="includes/advimage.css" type="text/css" />
        
<style type="text/css">
	/* jQuery alerts css (bootstrap) */
	.col-md-4 {
		float:left;
		width:33.33333333%;
		position:relative;
		min-height:1px;
		padding-right:15px;
		padding-left:15px;
	}
	.col-md-offset-4 {
		margin-left:33.33333333%;
	}
	.btn-info{color:#fff;background-color:#5bc0de;border-color:#46b8da;padding:5px 10px;}
	.btn-info.focus, .btn-info:focus{color:#fff;background-color:#31b0d5;border-color:#1b6d85;}
	.btn-info:hover{color:#fff;background-color:#31b0d5;border-color:#269abc;cursor:pointer;}
	
	.btn-danger{color:#fff;background-color:#d9534f;border-color:#d43f3a;padding:5px 10px;}
	.btn-danger.focus,.btn-danger:focus{color:#fff;background-color:#c9302c;border-color:#761c19;}
	.btn-danger:hover{color:#fff;background-color:#c9302c;border-color:#ac2925;cursor:pointer;}
	
</style>

<div id="body">
    
    <div id="options_block">
    
        <div id="advimage_tabs">
        
            <ul>
            <li><a href="#attributes"><?php _e('Attributes', 'wp_edit_pro'); ?></a></li>
            <li><a href="#margin"><?php _e('Margin', 'wp_edit_pro'); ?></a></li>
            <li><a href="#padding"><?php _e('Padding', 'wp_edit_pro'); ?></a></li>
            <li><a href="#border"><?php _e('Border', 'wp_edit_pro'); ?></a></li>
            <li><a href="#events"><?php _e('Events', 'wp_edit_pro'); ?></a></li>
            </ul>
            
            <div id="attributes">
            	<table cellpadding="5" style="border-collapse:collapse;font-size:14px;width:100%;" width="100%">
                <tbody>
                    <tr>
                        <td><span title="Specifies the image source"><?php _e('Image Source', 'wp_edit_pro'); ?>:</span></td>
                        <td><input id="attributes-image-source" type="text" style="width:100%;" /></td>
                    </tr>
                    <tr>
                        <td><span title="Specifies a unique id for an element"><?php _e('Image ID', 'wp_edit_pro'); ?>:</span></td>
                        <td><input id="attributes-image-id" type="text" style="width:300px;" /></td>
                    </tr>
                    <tr>
                        <td><span title="Specifies one or more classnames for an element (refers to a class in a style sheet)"><?php _e('Image Class', 'wp_edit_pro'); ?>:</span></td>
                        <td><input id="attributes-image-class" type="text" style="width:300px;" /></td>
                    </tr>
                    <tr>
                        <td><span title="Specifies extra information about an element"><?php _e('Image Title', 'wp_edit_pro'); ?>:</span></td>
                        <td><input id="attributes-image-title" type="text" style="width:300px;" /></td>
                    </tr>
                    <tr>
                        <td><span title="Specifies an alternate text for an image"><?php _e('Image Alt', 'wp_edit_pro'); ?>:</span></td>
                        <td><input id="attributes-image-alt" type="text" style="width:300px;" /></td>
                    </tr>
                    <tr>
                        <td><span title="Specifies the width of an image"><?php _e('Image Width', 'wp_edit_pro'); ?>:</span></td>
                        <td><input id="attributes-image-width" type="text" style="width:40px;" /> px <span class="orig_dimen" id="orig_image_width"><?php _e('Original Width', 'wp_edit_pro'); ?>: <span id="orig_width_val"></span></span></td>
                    </tr>
                    <tr>
                        <td><span title="Specifies the height of an image"><?php _e('Image Height', 'wp_edit_pro'); ?>:</span></td>
                        <td><input id="attributes-image-height" type="text" style="width:40px;" /> px <span class="orig_dimen" id="orig_image_height"><?php _e('Original Height', 'wp_edit_pro'); ?>: <span id="orig_height_val"></span></span></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td><input type="checkbox" id="maintain_proportions" name="maintain_proportions" checked="checked" /> <?php _e('Maintain Proportions', 'wp_edit_pro'); ?></td>
                    </tr>
                </tbody>
                </table>
            </div>
            
            <div id="margin">
                <table cellpadding="5" style="border-collapse:collapse;font-size:14px;">
                <tbody>
                    <tr>
                        <td><?php _e('Margin Top', 'wp_edit_pro'); ?>:</td>
                        <td><div id="margin-top-slider" style="width:300px;"></div></td>
                        <td><input id="margin-top-slider-value" class="slider_value" type="text" value="0" style="width:40px;" /> px</td>
                    </tr>
                    <tr>
                        <td><?php _e('Margin Right', 'wp_edit_pro'); ?>:</td>
                        <td><div id="margin-right-slider" style="width:300px;"></div></td>
                        <td><input id="margin-right-slider-value" class="slider_value" type="text" value="0" style="width:40px;" /> px</td>
                    </tr>
                    <tr>
                        <td><?php _e('Margin Bottom', 'wp_edit_pro'); ?>:</td>
                        <td><div id="margin-bottom-slider" style="width:300px;"></div></td>
                        <td><input id="margin-bottom-slider-value" class="slider_value" type="text" value="0" style="width:40px;" /> px</td>
                    </tr>
                    <tr>
                        <td><?php _e('Margin Left', 'wp_edit_pro'); ?>:</td>
                        <td><div id="margin-left-slider" style="width:300px;"></div></td>
                        <td><input id="margin-left-slider-value" class="slider_value" type="text" value="0" style="width:40px;" /> px</td>
                    </tr>
                </tbody>
                </table>
            </div>
            
            <div id="padding">
                <table cellpadding="5" style="border-collapse:collapse;font-size:14px;">
                <tbody>
                    <tr>
                        <td><?php _e('Padding Top', 'wp_edit_pro'); ?>:</td>
                        <td><div id="padding-top-slider" style="width:300px;"></div></td>
                        <td><input id="padding-top-slider-value" class="slider_value" type="text" value="0" style="width:40px;" /> px</td>
                    </tr>
                    <tr>
                        <td><?php _e('Padding Right', 'wp_edit_pro'); ?>:</td>
                        <td><div id="padding-right-slider" style="width:300px;"></div></td>
                        <td><input id="padding-right-slider-value" class="slider_value" type="text" value="0" style="width:40px;" /> px</td>
                    </tr>
                    <tr>
                        <td><?php _e('Padding Bottom', 'wp_edit_pro'); ?>:</td>
                        <td><div id="padding-bottom-slider" style="width:300px;"></div></td>
                        <td><input id="padding-bottom-slider-value" class="slider_value" type="text" value="0" style="width:40px;" /> px</td>
                    </tr>
                    <tr>
                        <td><?php _e('Padding Left', 'wp_edit_pro'); ?>:</td>
                        <td><div id="padding-left-slider" style="width:300px;"></div></td>
                        <td><input id="padding-left-slider-value" class="slider_value" type="text" value="0" style="width:40px;" /> px</td>
                    </tr>
                </tbody>
                </table>
            </div>
            
            <div id="border">
            	<table cellpadding="5" style="border-collapse:collapse;font-size:14px;">
                <tbody>
                    <tr>
                        <td>Border:</td>
                        <td><select id="border-value-number" class="border_value_number">
                        		<option value="0" title="0">0</option>
                        		<option value="1" title="1">1</option>
                                <option value="2" title="2">2</option>
                                <option value="3" title="3">3</option>
                                <option value="4" title="4">4</option>
                                <option value="5" title="5">5</option>
                            </select> px
                        </td>
                        <td><select id="border-value-style" class="border_value_style">
                        		<option value="solid" title="Solid"><?php _e('Solid', 'wp_edit_pro'); ?></option>
                                <option value="dotted" title="Dotted"><?php _e('Dotted', 'wp_edit_pro'); ?></option>
                                <option value="dashed" title="Dashed"><?php _e('Dashed', 'wp_edit_pro'); ?></option>
                                <option value="double" title="Double"><?php _e('Double', 'wp_edit_pro'); ?></option>
                            </select>
                        </td>
                        <td>
                        	<input type="text" id="border-picker" value="#000000" />
                        </td>
                    </tr>
                </tbody>
                </table>
                <br />
                <?php _e('Settting the border to <strong>0px</strong> will remove the border from the image.', 'wp_edit_pro'); ?>
            </div>
            
            <div id="events">
            
            	<div style="float:left;width:30%;">
                    <table cellpadding="5" style="border-collapse:collapse;font-size:14px;">
                    <tbody>
                        <tr>
                            <td>onclick:</td>
                            <td><input id="jscript-onclick" type="text" style="width:200px;" /></td>
                        </tr>
                        <tr>
                            <td>ondblclick:</td>
                            <td><input id="jscript-ondblclick" type="text" style="width:200px;" /></td>
                        </tr>
                        <tr>
                            <td>onkeydown:</td>
                            <td><input id="jscript-onkeydown" type="text" style="width:200px;" /></td>
                        </tr>
                        <tr>
                            <td>onkeypress:</td>
                            <td><input id="jscript-onkeypress" type="text" style="width:200px;" /></td>
                        </tr>
                        <tr>
                            <td>onkeyup:</td>
                            <td><input id="jscript-onkeyup" type="text" style="width:200px;" /></td>
                        </tr>
                        <tr>
                            <td>onmousedown:</td>
                            <td><input id="jscript-onmousedown" type="text" style="width:200px;" /></td>
                        </tr>
                        <tr>
                            <td>onmousemove:</td>
                            <td><input id="jscript-onmousemove" type="text" style="width:200px;" /></td>
                        </tr>
                        <tr>
                            <td>onmouseout:</td>
                            <td><input id="jscript-onmouseout" type="text" style="width:200px;" /></td>
                        </tr>
                        <tr>
                            <td>onmouseover:</td>
                            <td><input id="jscript-onmouseover" type="text" style="width:200px;" /></td>
                        </tr>
                        <tr>
                            <td>onmouseup:</td>
                            <td><input id="jscript-onmouseup" type="text" style="width:200px;" /></td>
                        </tr>
                        <tr>
                            <td>onmousewheel:</td>
                            <td><input id="jscript-onmousewheel" type="text" style="width:200px;" /></td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <div style="float:left;margin-left:30px;padding:10px;width:60%;">
                
                	<?php _e('HTML 4 added the ability to let events trigger actions in a browser, like starting a JavaScript when a user clicks on an element.', 'wp_edit_pro'); ?>
					<br /><br />
                    
                    <?php echo sprintf( __( 'To learn more about programming events, please visit this <a href="%s" target="_blank">JavaScript</a> tutorial.', 'wp_edit_pro' ), 'http://www.w3schools.com/js/default.asp' ) ?>
                    <br /><br />
                    
                    <?php echo sprintf( __( 'There is also a great <a href="%s" target="_blank">Reference</a> describing each javascript event..', 'wp_edit_pro' ), 'http://www.w3schools.com/tags/ref_eventattributes.asp' ) ?>
                    <br /><br />
                    
                    <?php echo sprintf( __( '<a href="%s" target="_blank">Practice</a> with a DEMO using the onclick event.', 'wp_edit_pro' ), 'http://www.w3schools.com/js/tryit.asp?filename=tryjs_myfirst' ) ?>
                    <br /><br />
                    
                    <?php _e('Note: The javascript events are wrapped with double quotation marks. This means single quotes must be used in the input fields to the left; or the double quote (if used) must be properly escaped.', 'wp_edit_pro'); ?>
                    <br /><br />
                    
                    <?php echo sprintf( __( 'Note: If using external scripts, and calling the function names from these events, it is recommended to add the additional scripts using a WordPress plugin such as <a href="%s" target="_blank">Scripts and Styles</a>.', 'wp_edit_pro' ), 'https://wordpress.org/plugins/scripts-n-styles/' ) ?>
                    
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
</div>
<br />
<button id="advimage_cancel" class="btn-default"><?php _e('Cancel', 'wp_edit_pro'); ?></button> <button id="advimage_insert" class="btn-primary"><?php _e('Insert / Update', 'wp_edit_pro'); ?></button>
<br /><br />