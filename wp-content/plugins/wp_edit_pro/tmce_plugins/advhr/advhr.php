<?php
$wp_include = "../wp-load.php";
 
$i = 0;
while(!file_exists($wp_include) && $i++ < 10){ 
  $wp_include = "../$wp_include";
}
 
require($wp_include);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!--<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
    
    <!-- Get jquery from WP -->
    <script type="text/javascript" src="<?php echo includes_url() . 'js/jquery/jquery.js'; ?>"></script>
        
    <script type="text/javascript" src="js/rule.js"></script>
    <link type="text/css" rel="stylesheet" href="css/advhr.css" />
</head>

<body>
<form>

        <table role="presentation" border="0" cellpadding="4" cellspacing="0">
                <tr role="group" aria-labelledby="width_label">
                    <td><label id="width_label" for="width"><?php _e('Width', 'wp_edit_pro'); ?></label></td>
                    <td class="nowrap">
                        <input id="width" name="width" type="text" value="" />
                        <select name="width_unit" id="width_unit">
                            <option value="px">px</option>
                            <option value="%">%</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="height"><?php _e('Height', 'wp_edit_pro'); ?></label></td>
                    <td><select id="height" name="height">
                        <option value=""><?php _e('Normal', 'wp_edit_pro'); ?></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select></td>
                </tr>
                <tr>
                    <td><label for="noshade"><?php _e('No Shade', 'wp_edit_pro'); ?></label></td>
                    <td><input type="checkbox" name="noshade" id="noshade" /></td>
                </tr>
        </table>
    <br /><br />
    <button id="advhr_cancel" class="btn-default"><?php _e('Cancel', 'wp_edit_pro'); ?></button> <button id="advhr_insert" class="btn-primary"><?php _e('Insert and Close', 'wp_edit_pro'); ?></button>
</form>
</body>
</html>