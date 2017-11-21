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
        <title><?php _e('YouTube Search', 'wp_edit_pro'); ?></title>
        
        <!--script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->
        
        <!-- Get jquery from WP -->
        <script type="text/javascript" src="<?php echo includes_url() . 'js/jquery/jquery.js'; ?>"></script>
        
        <script type="text/javascript" src="https://apis.google.com/js/client.js?onload=googleApiClientReady"></script>
        <script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
        <script type="text/javascript" src="includes/youTube.js"></script>
    
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="includes/youTube.css" />
    </head>
    
    <body>
    
        <div id="tabs">
            <ul>
            <li><a href="#search_tab"><?php _e('Search', 'wp_edit_pro'); ?></a></li>
            <li><a href="#options_tab"><?php _e('Options', 'wp_edit_pro'); ?></a></li>
            </ul>
            <div id="search_tab">
            
                <div id="buttons">
                    <?php _e('Enter a Search Term:', 'wp_edit_pro'); ?><br>
                    <input id="query" type="text" class="form-control" /> <button id="search-button" class="button-primary" onClick="keyWordsearch()"><?php _e('Search', 'wp_edit_pro'); ?></button>
                </div>
                
                <div id="left-container">
                    <h3><?php _e('Search Results', 'wp_edit_pro'); ?></h3>
                    <div id="search-container">
                        <?php _e('Results will be displayed here.  Click a video thumbnail to load the video into the Preview area.', 'wp_edit_pro'); ?>
                    </div>
                    <button id="prev_page" class="button-token"><?php _e('Previous Page', 'wp_edit_pro'); ?></button><button id="next_page" class="button-token"><?php _e('Next Page', 'wp_edit_pro'); ?></button>
                </div>
                <div id="right-container">
                    <h3><?php _e('Preview', 'wp_edit_pro'); ?></h3>
                    <div id="preview-container">
                        <?php _e('Once a video is loaded here; the video may be inserted, or additional options may be set.', 'wp_edit_pro'); ?>
                    </div>
                    <div id="insert_video_options">
                    
                    	<table><tbody>
                        	<tr><td>Insert as iFrame</td><td><input type="radio" name="insert_vid_as" value="iframe" /></td></tr>
                            <tr><td>Insert as Object (HTML5)</td><td><input type="radio" name="insert_vid_as" value="object" /></td></tr>
                            <tr><td colspan="2">Note: Inserting as Object may cause some attributes to not function properly.</td></tr>
                        </tbody></table>
                    </div>
                    <div id="insert_or_opts">
                        <p><button id="insert_video_opt" class="button-primary"><?php _e('Insert Video', 'wp_edit_pro'); ?></button></p>
                        <p><button id="set_options_opt" class="button-tabs"><?php _e('Set Video Options', 'wp_edit_pro'); ?></button></p>
                        <p><button id="cancel_opt" class="button-cancel"><?php _e('Cancel', 'wp_edit_pro'); ?></button></p>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
            <div id="options_tab">
            
                <?php _e('Here, additional player options can be configured. Please refer to the <a target="_blank" href="https://developers.google.com/youtube/player_parameters">YouTube API Paramaters List</a> for more information.', 'wp_edit_pro'); ?><br><br>
            
                <strong><?php _e('width', 'wp_edit_pro'); ?></strong>: <input type="text" value="380" id="video_width" class="form-control" style="width:50px;" /> px
                <div id="width_slider"></div><br>
                <strong><?php _e('height', 'wp_edit_pro'); ?></strong>: <input type="text" value="250" id="video_height" class="form-control" style="width:50px;" /> px<br>
                <div id="height_slider"></div><br>
                
                <table cellpadding="5"><tbody>
                    <tr>
                        <td><strong><?php _e('autohide', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="radio" name="autohide" value="0" />0</td>
                        <td><input type="radio" name="autohide" value="1" />1</td>
                        <td><input type="radio" name="autohide" value="2" checked="checked" />2</td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('autoplay', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="radio" name="autoplay" value="0" checked="checked" />no</td>
                        <td><input type="radio" name="autoplay" value="1" />yes</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('cc_load_policy', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="radio" name="cc_load_policy" value="0" checked="checked" />0</td>
                        <td><input type="radio" name="cc_load_policy" value="1" />1</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('color', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="radio" name="color" value="red" checked="checked" />red</td>
                        <td><input type="radio" name="color" value="white" />white</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('disablekb', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="radio" name="disablekb" value="1" />no</td>
                        <td><input type="radio" name="disablekb" value="0" checked="checked" />yes</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('loop', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="radio" name="loop" value="0" checked="checked" />no</td>
                        <td><input type="radio" name="loop" value="1" />yes</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('modestbranding', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="radio" name="modestbranding" value="0" checked="checked" />no</td>
                        <td><input type="radio" name="modestbranding" value="1" />yes</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('rel', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="radio" name="rel" value="0" />no</td>
                        <td><input type="radio" name="rel" value="1" checked="checked" />yes</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('showinfo', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="radio" name="showinfo" value="0" /><?php _e('no', 'wp_edit_pro'); ?></td>
                        <td><input type="radio" name="showinfo" value="1" style="margin-left: 10px;" checked="checked" /><?php _e('yes', 'wp_edit_pro'); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('theme', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="radio" name="theme" value="dark" checked="checked" /><?php _e('dark', 'wp_edit_pro'); ?></td>
                        <td><input type="radio" name="theme" value="light" style="margin-left: 10px;" /><?php _e('light', 'wp_edit_pro'); ?></td>
                        <td></td>
                    </tr>
                </tbody></table>
                
                <table><tbody>
                    <tr>
                        <td><strong><?php _e('start', 'wp_edit_pro'); ?></strong>:</td>
                        <td><input type="text" name="start" title="<?php _e('Enter number of seconds from beginning to start.', 'wp_edit_pro'); ?>" class="numbersOnly form-control" /></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody></table>
                
                <div class="spacer"></div>
                <button id="youTube_insert" class="button-primary"><?php _e('Insert Video', 'wp_edit_pro'); ?></button><span style="margin-left: 10px;"></span>
                <button id="back_to_search" class="button-tabs"><?php _e('Back to Search', 'wp_edit_pro'); ?></button><span style="margin-left: 10px;"></span>
                <button id="youTube_cancel" class="button-cancel"><?php _e('Cancel', 'wp_edit_pro'); ?></button>
            </div>
        </div>
    </body>
</html>