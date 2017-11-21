<?php

// Get active tab (if set in incoming link)
$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'buttons';

// Get options array
$plugin_opts = $this->options_array;


// Display info block if editing sub-site options
if( isset( $this->network_blog_id ) && ( $this->network_blog_id !== '' ) && $this->network_activated === true ) {
	
	?>
    <div class="error wpep_info">
    	<p><?php printf(__('Currently editing options for network site with blog ID %s.', 'wp_edit_pro'), '<strong>'.$this->network_blog_id.'</strong>'); ?><br />
           <?php _e('The plugin settings have adapted based on this option.  Some settings may be different; while other settings may be disabled entirely.', 'wp_edit_pro'); ?><br />
           <?php _e('It is VERY important to cancel editing subsite options when finished; otherwise the plugin may not function properly.', 'wp_edit_pro'); ?></p>
        <p>
        	<form method="post" action="">
        		<input type="submit" id="wpep_submit_cancel_network" class="button-secondary" name="wpep_submit_cancel_network" id="wpep_submit_cancel_network" value="<?php printf(__('Cancel Editing Blog ID %s Options', 'wp_edit_pro'), $this->network_blog_id); ?>" />
        	</form>
        </p>
	</div>
    <?php
}


// Display info block if this is first time install
if(isset($plugin_opts['wpep_first_install']) && ($plugin_opts['wpep_first_install'] === 'true')) {
	
	?>
	<div id="welcome_block">
		<div id="welcome_dialog" class="updated">
        	<p><?php _e('It looks like this may be the first time WP Edit Pro has been installed on this site.', 'wp_edit_pro'); ?></p>
			<p><?php _e('The options from WP Edit (Free) can be converted to WP Edit Pro (if desired).', 'wp_edit_pro'); ?></p>
			<p><?php _e('Otherwise; please click "No Thanks".', 'wp_edit_pro'); ?></p>
            <div style="float:left;margin-right:20px;">
            <form method="post" action="">
            <input type="submit" class="button-primary" value="<?php _e('Convert WP Edit Options', 'wp_edit_pro'); ?>" name="wpep_welcome_submit">
            <input type="hidden" name="convert_db_values_welcome" value="" />
        	</form>
            </div>
            
            <div style="float:left;">
            <form method="post" action="">
            	<input type="submit" class="button-secondary" value="<?php _e('No Thanks', 'wp_edit_pro'); ?>" name="wpep_welcome_cancel">
            </form>
            </div>
            <div style="clear:both;"></div>
            <p><em><?php _e('Converting options can be done anytime via the "Database" tab -> Convert Options.', 'wp_edit_pro'); ?></em></p>
		</div>
	</div>
	<?php 
} 




?>
<div id="wpep_tabbed_content">
	<h3 class="nav-tab-wrapper">  
		<a href="?page=wp_edit_pro_options&tab=buttons" class="nav-tab <?php echo $active_tab == 'buttons' ? 'nav-tab-active' : ''; ?>"><?php _e('Buttons', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=network" class="nav-tab <?php echo $active_tab == 'network' ? 'nav-tab-active' : ''; ?>"><?php _e('Network', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=global" class="nav-tab <?php echo $active_tab == 'global' ? 'nav-tab-active' : ''; ?>"><?php _e('Global', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=configuration" class="nav-tab <?php echo $active_tab == 'configuration' ? 'nav-tab-active' : ''; ?>"><?php _e('Configuration', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=posts" class="nav-tab <?php echo $active_tab == 'posts' ? 'nav-tab-active' : ''; ?>"><?php _e('Posts/Pages', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=editor" class="nav-tab <?php echo $active_tab == 'editor' ? 'nav-tab-active' : ''; ?>"><?php _e('Editor', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=fonts" class="nav-tab <?php echo $active_tab == 'fonts' ? 'nav-tab-active' : ''; ?>"><?php _e('Fonts', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=styles" class="nav-tab <?php echo $active_tab == 'styles' ? 'nav-tab-active' : ''; ?>"><?php _e('Styles', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=widgets" class="nav-tab <?php echo $active_tab == 'widgets' ? 'nav-tab-active' : ''; ?>"><?php _e('Snidgets', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=user_specific" class="nav-tab <?php echo $active_tab == 'user_specific' ? 'nav-tab-active' : ''; ?>"><?php _e('User', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=extras" class="nav-tab <?php echo $active_tab == 'extras' ? 'nav-tab-active' : ''; ?>"><?php _e('Extras', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=database" class="nav-tab <?php echo $active_tab == 'database' ? 'nav-tab-active' : ''; ?>"><?php _e('Database', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=about" class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>"><?php _e('About', 'wp_edit_pro'); ?></a>
		<a href="?page=wp_edit_pro_options&tab=notes" class="nav-tab <?php echo $active_tab == 'notes' ? 'nav-tab-active' : ''; ?>"><?php _e('Notes', 'wp_edit_pro'); ?></a>
	</h3>
</div>
<?php


/*
****************************************************************
Buttons Tab
****************************************************************
*/
if($active_tab == 'buttons'){
	
	// Get wordpress roles for dropdown selector
	global $wp_roles;
	$capslist = array();
	
	// Get wp capabilities for dropdown selector
	$get_role = get_role('administrator');
	$capslist = $get_role->capabilities;
	ksort($capslist);
	
	/*
	****************************************************************
	Get buttons to display on page (create, edit, save, etc.)
	****************************************************************
	*/ 
	$show_buttons = $plugin_opts['wp_edit_pro_buttons'];
	
	// Set variables for displaying various page options
	$is_normal_buttons = 'true';
	$is_new_role = 'false';
	$is_existing_role = 'false';
	$is_new_cap = 'false';
	$is_existing_cap = 'false';
	$is_new_user = 'false';
	$is_existing_user = 'false';
	$is_new_visitor = 'false';
	$is_existing_visitor = 'false';
	
	
	// If creating a new editor wordpress role
	if(isset($_POST['wpep_create_editor_role_value'])) {
		
		// Set new role varible
		$new_role = $_POST['wpep_create_editor_role_value'];
		$is_new_role = 'true';
		$is_normal_buttons = 'false';
		
		$show_buttons = $this->options_default['wp_edit_pro_buttons'];
	}
	// If editing an existing wordpress role
	if(isset($_POST['wpep_edit_wp_role_editor'])) {
		
		// Get wordpress role name
		$role_name = $_POST['wpep_edit_wp_role_editor'];
		reset($role_name);
		$existing_role = key($role_name);
		
		// Set new exisiting role varible
		$is_existing_role = 'true';
		$is_normal_buttons = 'false';
		
		// Switch to blog for subsite options
		if(isset($this->network_blog_id) && $this->network_blog_id !== '') {
			
			switch_to_blog($this->network_blog_id);
			$get_opts = get_option('wp_edit_pro_options_array');
			$show_buttons = $get_opts['wp_edit_pro_buttons_wp_role_'.$existing_role];
			restore_current_blog();
		}
		else {
			$show_buttons = $this->options_array['wp_edit_pro_buttons_wp_role_'.$existing_role];
		}
	}
	// If redisplaying a created role editor
	if(isset($_POST['wpep_new_role_editor'])) {
		
		$existing_role = $_POST['wpep_new_role_editor'];
		
		// Set new exisiting role varible
		$is_existing_role = 'true';
		$is_normal_buttons = 'false';
		
		// Switch to blog for subsite options
		if(isset($this->network_blog_id) && $this->network_blog_id !== '') {
			
			switch_to_blog($this->network_blog_id);
			$get_opts = get_option('wp_edit_pro_options_array');
			$show_buttons = $get_opts['wp_edit_pro_buttons_wp_role_'.$existing_role];
			restore_current_blog();
		}
		else {
			$show_buttons = $this->options_array['wp_edit_pro_buttons_wp_role_'.$existing_role];
		}
	}
	// If redisplaying an edited role editor
	if(isset($_POST['wpep_existing_role_editor'])) {
		
		$existing_role = $_POST['wpep_existing_role_editor'];
		
		// Set new exisiting role varible
		$is_existing_role = 'true';
		$is_normal_buttons = 'false';
		
		// Switch to blog for subsite options
		if(isset($this->network_blog_id) && $this->network_blog_id !== '') {
			
			switch_to_blog($this->network_blog_id);
			$get_opts = get_option('wp_edit_pro_options_array');
			$show_buttons = $get_opts['wp_edit_pro_buttons_wp_role_'.$existing_role];
			restore_current_blog();
		}
		else {
			$show_buttons = $this->options_array['wp_edit_pro_buttons_wp_role_'.$existing_role];
		}
	}
	// If creating a new wordpress capability
	if(isset($_POST['wpep_create_capability_editor'])) {
		
		// Get wordpress cap name
		$new_cap = $_POST['wpep_create_editor_cap_value'];
		
		// Set new exisiting cap varible
		$is_new_cap = 'true';
		$is_normal_buttons = 'false';
		
		$show_buttons = $this->options_default['wp_edit_pro_buttons'];
	}
	// If editing an existing wordpress capability
	if(isset($_POST['wpep_edit_wp_cap_editor'])) {
		
		// Get wordpress cap name
		$new_cap = $_POST['wpep_edit_wp_cap_editor'];
		reset($new_cap);
		$existing_cap = key($new_cap);
		
		// Set new exisiting role varible
		$is_existing_cap = 'true';
		$is_normal_buttons = 'false';
		
		// Switch to blog for subsite options
		if(isset($this->network_blog_id) && $this->network_blog_id !== '') {
			
			switch_to_blog($this->network_blog_id);
			$get_opts = get_option('wp_edit_pro_options_array');
			$show_buttons = $get_opts['wp_edit_pro_buttons_wp_cap_'.$existing_cap];
			restore_current_blog();
		}
		else {
			$show_buttons = $this->options_array['wp_edit_pro_buttons_wp_cap_'.$existing_cap];
		}
	}
	// If redisplaying a created cap editor
	if(isset($_POST['wpep_new_cap_editor'])) {
		
		// Get wordpress cap name
		$existing_cap = $_POST['wpep_new_cap_editor'];
		
		// Set new exisiting role varible
		$is_existing_cap = 'true';
		$is_normal_buttons = 'false';
		
		$show_buttons = $this->options_array['wp_edit_pro_buttons_wp_cap_'.$existing_cap];
	}
	// If redisplaying an edited cap editor
	if(isset($_POST['wpep_existing_cap_editor'])) {
		
		$existing_cap = $_POST['wpep_existing_cap_editor'];
		
		// Set new exisiting role varible
		$is_existing_cap = 'true';
		$is_normal_buttons = 'false';
		
		$show_buttons = $this->options_array['wp_edit_pro_buttons_wp_cap_'.$existing_cap];
	}
	// If creating a new user specific editor
	if(isset($_POST['wpep_create_user_editor'])) {
		
		// Get username (from ID)
		$user_id = $_POST['wpep_create_editor_user_value'];
		$user_info = get_userdata($user_id);
		$user_name = $user_info->user_login;
		
		// Set new user editor varible
		$is_new_user = 'true';
		$is_normal_buttons = 'false';
		
		$show_buttons = $this->options_default['wp_edit_pro_buttons'];
	}
	// If editing an existing user editor
	if(isset($_POST['wpep_edit_user_editor'])) {
		
		// Get user id
		$user_id = $_POST['wpep_edit_user_editor'];
		reset($user_id);
		$user_id = key($user_id);
		
		$existing_user_info = get_userdata($user_id);
		$existing_user_name = $existing_user_info->user_login;
		
		$is_existing_user = 'true';
		$is_normal_buttons = 'false';
		
		// Get user meta
		$user_meta = get_user_meta($user_id, 'aaa_wp_edit_pro_user_meta', true);
		$show_buttons = $user_meta['wp_edit_pro_buttons_user_editor'];
	}
	// If redisplaying a created user editor
	if(isset($_POST['wpep_new_user_editor'])) {
		
		// Get user id
		$existing_user_name = $_POST['wpep_new_user_editor'];
		$user = get_user_by('login', $existing_user_name);
		$user_id = $user->ID;
		
		// Set new exisiting role varible
		$is_existing_user = 'true';
		$is_normal_buttons = 'false';
		
		// Get user meta
		$user_meta = get_user_meta($user_id, 'aaa_wp_edit_pro_user_meta', true);
		$show_buttons = isset($user_meta['wp_edit_pro_buttons_user_editor']) ? $user_meta['wp_edit_pro_buttons_user_editor'] : $this->options_default['wp_edit_pro_buttons'];
	}
	// If redisplaying an edited user editor
	if(isset($_POST['wpep_existing_user_editor'])) {
		
		// Get user id
		$existing_user_name = $_POST['wpep_existing_user_editor'];
		$user = get_user_by('login', $existing_user_name);
		$user_id = $user->ID;
		
		// Set new exisiting role varible
		$is_existing_user = 'true';
		$is_normal_buttons = 'false';
		
		// Get user meta
		$user_meta = get_user_meta($user_id, 'aaa_wp_edit_pro_user_meta', true);
		$show_buttons = $user_meta['wp_edit_pro_buttons_user_editor'];
	}
	// If creating a new visitor editor
	if(isset($_POST['wpep_create_visitor_editor'])) {
		
		// Set new role varible
		$is_new_visitor = 'true';
		$is_normal_buttons = 'false';
		
		$show_buttons = $this->options_default['wp_edit_pro_buttons'];
	}
	// If editing an exisiting visitor editor
	if(isset($_POST['wpep_edit_visitor_editor'])) {
		
		// Set new exisiting role varible
		$is_existing_visitor = 'true';
		$is_normal_buttons = 'false';
		
		// Switch to blog for subsite options
		if(isset($this->network_blog_id) && $this->network_blog_id !== '') {
			
			switch_to_blog($this->network_blog_id);
			$get_opts = get_option('wp_edit_pro_options_array');
			$show_buttons = $get_opts['wp_edit_pro_buttons_wp_visitor'];
			restore_current_blog();
		}
		else {
			$show_buttons = $this->options_array['wp_edit_pro_buttons_wp_visitor'];
		}
	
	}
	// If redisplaying a created visitor editor
	if(isset($_POST['wpep_new_visitor_editor'])) {
		
		// Set new exisiting role varible
		$is_existing_visitor = 'true';
		$is_normal_buttons = 'false';
		
		$show_buttons = $this->options_array['wp_edit_pro_buttons_wp_visitor'];
	}
	// If redisplaying an edited visitor editor
	if(isset($_POST['wpep_existing_visitor_editor'])) {
		
		// Set new exisiting role varible
		$is_existing_visitor = 'true';
		$is_normal_buttons = 'false';
		
		$show_buttons = $this->options_array['wp_edit_pro_buttons_wp_visitor'];
	}
	// If an editor has been quick selected (from dropdown list)
	if(isset($_POST['wpep_select_editor_submit'])) {
		if(isset($_POST['wpep_select_editor'])) {
			
			$post_name = $_POST['wpep_select_editor'];
			
			// If this is a role editor
			if(strpos($post_name, '_wp_role_') !== false) {
				
				// Set new exisiting role varibles
				$is_existing_role = 'true';
				$is_normal_buttons = 'false';
				$existing_role = str_replace('wp_edit_pro_buttons_wp_role_', '', $post_name);
				
				$show_buttons = $this->options_array[$post_name];
			}
			// Else if this is a capability editor
			elseif(strpos($post_name, '_wp_cap_') !== false) {
				
				// Set new exisiting role varibles
				$is_existing_cap = 'true';
				$is_normal_buttons = 'false';
				$existing_cap = str_replace('wp_edit_pro_buttons_wp_cap_', '', $post_name);
				
				$show_buttons = $this->options_array[$post_name];
			}
			// Else is a visitor editor
			elseif(strpos($post_name, 'wpep_visitor_editor_table') !== false) {
				
				// Set new exisiting role varibles
				$is_existing_visitor = 'true';
				$is_normal_buttons = 'false';
				
				$show_buttons = $this->options_array['wp_edit_pro_buttons_wp_visitor'];
			}
			// Else is a user role editor
			elseif($post_name !== '') {
				
				// Get user id
				$user = get_user_by('login', $post_name);
				$user_id = $user->ID;
				
				$existing_user_name = $post_name;
				
				$is_existing_user = 'true';
				$is_normal_buttons = 'false';
				
				// Get user meta
				$user_meta = get_user_meta($user_id, 'aaa_wp_edit_pro_user_meta', true);
				$show_buttons = $user_meta['wp_edit_pro_buttons_user_editor'];
			}
		}
	}
	// Reset all buttons
	if(isset($_POST['wpep_reset_buttons'])) {
		$show_buttons = $this->options_default['wp_edit_pro_buttons'];
	}
	
	/*
	****************************************************************
	Begin page container
	****************************************************************
	*/ 
	?>
    
	<div class="main_container">
		<div id="main_buttons_container" class="main_buttons_container_float">
		
			<h2> <?php _e('WP Edit Pro Buttons', 'wp_edit_pro'); ?> </h2>
			<div class="metabox-holder"> 
			
				<?php
				/*
				****************************************************************
				Top editor status messages
				****************************************************************
				*/ 
				echo '<div class="wpep_main_editor_message"><p>';
				
				if( $is_new_role === 'true' ) {
					printf(__('New editor for the %s WordPress user role.', 'wp_edit_pro'), '<strong>'.$new_role.'</strong>');
				}
				elseif( $is_existing_role === 'true' ) {
					printf(__('Editing the %s WordPress user role.', 'wp_edit_pro'), '<strong>'.$existing_role.'</strong>');
				}
				elseif( $is_new_cap === 'true' ) {
					printf(__('New editor for the %s WordPress user capability.', 'wp_edit_pro'), '<strong>'.$new_cap.'</strong>');
				}
				elseif( $is_existing_cap === 'true' ) {
					printf(__('Editing the %s WordPress user capability.', 'wp_edit_pro'), '<strong>'.$existing_cap.'</strong>');
				}
				elseif( $is_new_user === 'true' ) {
					printf(__('New editor for user %s.', 'wp_edit_pro'), '<strong>'.$user_name.'</strong>');
				}
				elseif( $is_existing_user === 'true' ) {
					printf(__('Editing the user editor for %s.', 'wp_edit_pro'), '<strong>'.$existing_user_name.'</strong>');
				}
				elseif( $is_new_visitor === 'true' ) {
					_e('New editor for site visitors.', 'wp_edit_pro');
				}
				elseif( $is_existing_visitor === 'true' ) {
					_e('Editing the site visitor editor.', 'wp_edit_pro');
				}
				else {
					_e('This is the main button configuration. This button configuration will be used if no other custom editor is applicable to the user.', 'wp_edit_pro');
				}
				
				echo '</p></div>';
				
				
				/*
				****************************************************************
				Begin button container
				****************************************************************
				*/ 
				?>
				<div class="postbox">
					<div class="inside wpep_act_button_area" id="inside_button_hover">
                    
						<h3><?php _e('Button Rows', 'wp_edit_pro'); ?></h3>
						
						<?php 
						// Include buttons icons and tooltips
						include 'buttons_tab_icons.php'; 
						?>
					</div>
				</div>
			</div>
            
			<?php 
			/*
			****************************************************************
			Build form for saving buttons
			****************************************************************
			*/ 
			?>
            
            <div style="float:left;margin-right:20px;">
                <form method="post" action="">
                <input type="hidden" class="get_sorted_array" name="get_sorted_array_results" value="" />
                
                <?php
                $save_message = __('Save Buttons', 'wp_edit_pro');
                $cancel_message = __('Cancel', 'wp_edit_pro');
                // If creating a new wp role; add hidden input to pass role name
                if($is_new_role === 'true') {
                    
                    $save_message = sprintf(__('Save Role Buttons (%s)', 'wp_edit_pro'), $new_role);
                    $cancel_message = sprintf(__('Cancel Editing Role (%s)', 'wp_edit_pro'), $new_role);
                    ?><input type="hidden" name="wpep_new_role_editor" value="<?php echo $new_role; ?>" /><?php
                }
                // If editing an existing wp role; add hidden input to pass role name
                elseif($is_existing_role === 'true') {
                    
                    $save_message = sprintf(__('Save Role Buttons (%s)', 'wp_edit_pro'), $existing_role);
                    $cancel_message = sprintf(__('Cancel Editing Role (%s)', 'wp_edit_pro'), $existing_role);
                    ?><input type="hidden" name="wpep_existing_role_editor" value="<?php echo $existing_role; ?>" /><?php
                }
                // If creating a new wp cap; add hidden input to pass cap name
                if($is_new_cap === 'true') {
                    
                    $save_message = sprintf(__('Save Capability Buttons (%s)', 'wp_edit_pro'), $new_cap);
                    $cancel_message = sprintf(__('Cancel Editing Capability (%s)', 'wp_edit_pro'), $new_cap);
                    ?><input type="hidden" name="wpep_new_cap_editor" value="<?php echo $new_cap; ?>" /><?php
                }
                // If editing an existing wp cap; add hidden input to pass cap name
                elseif($is_existing_cap === 'true') {
                    
                    $save_message = sprintf(__('Save Capability Buttons (%s)', 'wp_edit_pro'), $existing_cap);
                    $cancel_message = sprintf(__('Cancel Editing Capability (%s)', 'wp_edit_pro'), $existing_cap);
                    ?><input type="hidden" name="wpep_existing_cap_editor" value="<?php echo $existing_cap; ?>" /><?php
                }
                // If creating a new user editor; add hidden input to pass user name
                elseif($is_new_user === 'true') {
                    
                    $save_message = sprintf(__('Save User Buttons (%s)', 'wp_edit_pro'), $user_name);
                    $cancel_message = sprintf(__('Cancel Editing User (%s)', 'wp_edit_pro'), $user_name);
                    ?><input type="hidden" name="wpep_new_user_editor" value="<?php echo $user_name; ?>" /><?php
                }
                // If editing an existing user editor; add hidden input to user role name
                elseif($is_existing_user === 'true') {
                    
                    $save_message = sprintf(__('Save User Buttons (%s)', 'wp_edit_pro'), $existing_user_name);
                    $cancel_message = sprintf(__('Cancel Editing User (%s)', 'wp_edit_pro'), $existing_user_name);
                    ?><input type="hidden" name="wpep_existing_user_editor" value="<?php echo $existing_user_name; ?>" /><?php
                }
                // If creating a new visitor editor; add hidden input to pass user name
                elseif($is_new_visitor === 'true') {
                    
                    $save_message = __('Save Visitor Buttons', 'wp_edit_pro');
                    $cancel_message = __('Cancel Editing Visitor', 'wp_edit_pro');
                    ?><input type="hidden" name="wpep_new_visitor_editor" value="<?php echo $user_name; ?>" /><?php
                }
                // If editing an existing visitor editor; add hidden input to pass user name
                elseif($is_existing_visitor === 'true') {
                    
                    $save_message = __('Save Visitor Buttons', 'wp_edit_pro');
                    $cancel_message = __('Cancel Editing Visitor', 'wp_edit_pro');
                    ?><input type="hidden" name="wpep_existing_visitor_editor" value="<?php echo $user_name; ?>" /><?php
                }
                ?>
                
                <?php // Submit save button ?>
                <input type="submit" value="<?php echo $save_message; ?>" name="wpep_save_buttons" class="button-primary" />
                </form>
            </div>
            <div style="float:left;">
				<?php // Cancel button is in new form; to prevent $_POST variables from re-populating ?>
                <form method="post" action="">
                    <input type="submit" value="<?php echo $cancel_message; ?>" class="button-secondary" />
                </form>
            </div>
            <div style="clear:both;"></div>
            <br />
            
            <p><?php _e('Quick select a saved custom editor to load for editing.', 'wp_edit_pro'); ?><br />
			<em><?php _e('(These are the same editors as in the "Created Editors" section below)', 'wp_edit_pro'); ?></em></p>
            <form method="post" action="">
            
				<?php
				/*
				****************************************************************
				Build quick select editor dropdown box
				****************************************************************
				*/ 
                // Get all options array editors for roles
                $roles_editors = array();
                foreach($plugin_opts as $opt_name => $opt_value) {
                    if(strpos($opt_name,'wp_edit_pro_buttons_wp_role_') !== false) {
                        
                        $roles_editors[] = $opt_name;
                    }
                }
                // Get all options array editors for capabilities
                $caps_editors = array();
                foreach($plugin_opts as $opt_name => $opt_value) {
                    if(strpos($opt_name,'wp_edit_pro_buttons_wp_cap_') !== false) {
                        
                        $caps_editors[] = $opt_name;
                    }
                }
                // Get all options array editors for user meta
                $users_editors = array();
				// Check if editing a subsite ID
				if($this->network_blog_id !== '') {
					
					switch_to_blog($this->network_blog_id);
					$users = get_users();
					restore_current_blog();
				}
				else {
					$users = get_users();
				}
                
                foreach($users as $key => $value) {
                    $user_meta = get_user_meta($value->data->ID, 'aaa_wp_edit_pro_user_meta', true);
                    if(isset($user_meta['wp_edit_pro_buttons_user_editor'])) {
                        $users_editors[] = $value->data->user_login;
                    }
                }
                
                ?>
            	<select name="wpep_select_editor" />
                	<option value=""><?php _e('Select Editor...', 'wp_edit_pro'); ?></option>
                	<optgroup label="<?php _e('Role Editors', 'wp_edit_pro'); ?>">
                        <?php 
						if(!empty($roles_editors)) {
							foreach($roles_editors as $name) {
								$name_trimed = str_replace('wp_edit_pro_buttons_wp_role_', '', $name);
								echo '<option value="'.$name.'">'.$name_trimed.'</option>';
							}
						}
						else {
							echo '<option disabled="disabled">'.__('No role editors found.', 'wp_edit_pro').'</option>';
						}
						?>
                    </optgroup>
                	<optgroup label="<?php _e('Capability Editors', 'wp_edit_pro'); ?>">
                        <?php 
						if(!empty($caps_editors)) {
							foreach($caps_editors as $name) {
								$name_trimed = str_replace('wp_edit_pro_buttons_wp_cap_', '', $name);
								echo '<option value="'.$name.'">'.$name_trimed.'</option>';
							}
						}
						else {
							echo '<option disabled="disabled">'.__('No capability editors found.', 'wp_edit_pro').'</option>';
						}
						?>
                    </optgroup>
                	<optgroup label="<?php _e('User Editors', 'wp_edit_pro'); ?>">
                        <?php 
						if(!empty($users_editors)) {
							foreach($users_editors as $name) {
								echo '<option value="'.$name.'">'.$name.'</option>';
							}
						}
						else {
							echo '<option disabled="disabled">'.__('No user role editors found.', 'wp_edit_pro').'</option>';
						}
						?>
                    </optgroup>
                    <optgroup label="<?php _e('Visitor Editor', 'wp_edit_pro'); ?>">
                    	<?php
					    $get_visitor_array = isset($this->options_array['wp_edit_pro_buttons_wp_visitor']) ? $this->options_array['wp_edit_pro_buttons_wp_visitor'] : '';
						if(is_array($get_visitor_array)) {
							echo '<option value="wpep_visitor_editor_table">';
							_e('Visitor Editor', 'wp_edit_pro');
							echo '</option>';
						}
						else{
							echo '<option disabled="disabled">'.__('No visitor editor found.', 'wp_edit_pro').'</option>';
						}
						?>
                    </optgroup>
                </select>
                <input type="submit" class="button-secondary" name="wpep_select_editor_submit" value="<?php _e('Load Editor', 'wp_edit_pro'); ?>" />
            </form>
            <br />
            
            <?php
			/*
			****************************************************************
			Reset buttons form
			****************************************************************
			*/
			_e('Reset Plugin Buttons.', 'wp_edit_pro'); 
			?>
            
            <form method="post" action="">
				<?php
                // If this is a new role
                if($is_new_role === 'true') {
                    echo '<input type="hidden" name="wpep_new_role_editor" value="'.$new_role.'" />';
                }
                // If this is an exisiting role
                if($is_existing_role === 'true') {
                    echo '<input type="hidden" name="wpep_existing_role_editor" value="'.$existing_role.'" />';
                }
                // If this is a new capability
                if($is_new_cap === 'true') {
                    echo '<input type="hidden" name="wpep_new_cap_editor" value="'.$new_cap.'" />';
                }
                // If this is an exisiting capability
                if($is_existing_cap === 'true') {
                    echo '<input type="hidden" name="wpep_existing_cap_editor" value="'.$existing_cap.'" />';
                }
                // If this is a new user
                if($is_new_user === 'true') {
                    echo '<input type="hidden" name="wpep_new_user_editor" value="'.$user_name.'" />';
                    echo '<input type="hidden" name="wpep_new_user_editor_load_buttons_helper" value="'.$user_name.'" />';
                }
                // If this is an exisiting user
                if($is_existing_user === 'true') {
                    echo '<input type="hidden" name="wpep_existing_user_editor" value="'.$existing_user_name.'" />';
                    echo '<input type="hidden" name="wpep_existing_user_editor_reset_buttons_helper" value="'.$existing_user_name.'" />';
                }
                // If this is a new visitor
                if($is_new_visitor === 'true') {
                    echo '<input type="hidden" name="wpep_new_visitor_editor" value="visitor" />';
                }
                // If this is an existing visitor
                if($is_existing_visitor === 'true') {
                    echo '<input type="hidden" name="wpep_existing_visitor_editor" value="visitor" />';
                }
				// If editing a subsite ID
				if(isset($plugin_opts['wp_edit_pro_network']['wpep_select_blog_id']) && $plugin_opts['wp_edit_pro_network']['wpep_select_blog_id'] !== '') {
					echo '<input type="hidden" name="wpep_editing_blog_id" value="'.$plugin_opts['wp_edit_pro_network']['wpep_select_blog_id'].'" />';
				}
                ?>
                <input type="submit" value="<?php _e('Reset Buttons', 'wp_edit_pro'); ?>" name="wpep_reset_buttons" class="button-secondary" />
            </form>
		</div>
		
		<?php
		/*
		****************************************************************
		Sidebar containers
		****************************************************************
		*/ 
		?>
		<div class="side_buttons_options">
		
			<div class="metabox-holder">
				<div class="postbox" style="border-left:3px solid green;">
					<h3><?php _e( 'Current Editor', 'wp_edit_pro' ); ?></h3>
					<div class="inside">
					
						<?php
						/*
						****************************************************************
						Sidebar status messages
						****************************************************************
						*/ 
						if($is_new_role === 'true') {
							
							?><p><?php printf(__('A new editor is being created for the %s WordPress role.', 'wp_edit_pro'), '<strong>'.$new_role.'</strong>'); ?></p><?php
							?><p><?php _e('Once the buttons are saved; the editor will be added to the table below (where it can be edited or deleted).', 'wp_edit_pro'); ?></p><?php
                        	?><p><?php _e('Click "Cancel" at anytime to return to the normal button configuration.', 'wp_edit_pro'); ?></p><?php
						}
						if($is_existing_role === 'true') {
							
							?><p><?php printf(__('The %s WordPress role editor is currently being edited.', 'wp_edit_pro'), '<strong>'.$existing_role.'</strong>'); ?></p><?php
							?><p><?php _e('Once the buttons are saved; the editor will be added to the table below (where it can be edited or deleted).', 'wp_edit_pro'); ?></p><?php
                        	?><p><?php _e('Click "Cancel" at anytime to return to the normal button configuration.', 'wp_edit_pro'); ?></p><?php
						}
						if($is_new_cap === 'true') {
							
							?><p><?php printf(__('A new editor is being created for the %s WordPress capability.', 'wp_edit_pro'), '<strong>'.$new_cap.'</strong>'); ?></p><?php
							?><p><?php _e('Once the buttons are saved; the editor will be added to the table below (where it can be edited or deleted).', 'wp_edit_pro'); ?></p><?php
                        	?><p><?php _e('Click "Cancel" at anytime to return to the normal button configuration.', 'wp_edit_pro'); ?></p><?php
						}
						if($is_existing_cap === 'true') {
							
							?><p><?php printf(__('The %s WordPress capability editor is currently being edited.', 'wp_edit_pro'), '<strong>'.$existing_cap.'</strong>'); ?></p><?php
							?><p><?php _e('Once the buttons are saved; the editor will be added to the table below (where it can be edited or deleted).', 'wp_edit_pro'); ?></p><?php
                        	?><p><?php _e('Click "Cancel" at anytime to return to the normal button configuration.', 'wp_edit_pro'); ?></p><?php
						}
						if($is_new_user === 'true') {
							
							?><p><?php printf(__('New editor for user %s.', 'wp_edit_pro'), '<strong>'.$user_name.'</strong>'); ?></p><?php
							?><p><?php _e('Once the buttons are saved; the editor will be added to the table below (where it can be edited or deleted).', 'wp_edit_pro'); ?></p><?php
                        	?><p><?php _e('Click "Cancel" at anytime to return to the normal button configuration.', 'wp_edit_pro'); ?></p><?php
						}
						if($is_existing_user === 'true') {
							
							?><p><?php printf(__('The editor for %s is currently being edited.', 'wp_edit_pro'), '<strong>'.$existing_user_name.'</strong>'); ?></p><?php
							?><p><?php _e('Once the buttons are saved; the editor will be added to the table below (where it can be edited or deleted).', 'wp_edit_pro'); ?></p><?php
                        	?><p><?php _e('Click "Cancel" at anytime to return to the normal button configuration.', 'wp_edit_pro'); ?></p><?php
						}
						if($is_normal_buttons === 'true') {
							
							_e('The current editor shown to the left is used for all users; if no WordPress Role, WordPress Capability or User Specific editor has been created.', 'wp_edit_pro');
						}
						if($is_new_visitor === 'true') {
							
							?><p><?php _e('New editor for site visitors.', 'wp_edit_pro'); ?></p><?php
							?><p><?php _e('Once the buttons are saved; the editor will be added to the table below (where it can be edited or deleted).', 'wp_edit_pro'); ?></p><?php
                        	?><p><?php _e('Click "Cancel" at anytime to return to the normal button configuration.', 'wp_edit_pro'); ?></p><?php
						}
						if($is_existing_visitor === 'true') {
							
							?><p><?php _e('The site visitor editor is currently being edited.', 'wp_edit_pro'); ?></p><?php
							?><p><?php _e('Once the buttons are saved; the editor will be added to the table below (where it can be edited or deleted).', 'wp_edit_pro'); ?></p><?php
                        	?><p><?php _e('Click "Cancel" at anytime to return to the normal button configuration.', 'wp_edit_pro'); ?></p><?php
						}
						?>
                        
					</div>
				</div>
			</div>
		
			<div class="metabox-holder">
				<div class="postbox">
					<h3><?php _e( 'Create WordPress Role Editor', 'wp_edit_pro' ); ?></h3>
					<div class="inside">
						<p><?php _e('Use this option to create an editor which will be assigned to the selected WordPress user role.', 'wp_edit_pro'); ?></p>
						<form method="post" action="">
						<select name="wpep_create_editor_role_value">
							<?php foreach ( $wp_roles->roles as $key=>$value ): ?>
							<option value="<?php echo $key; ?>"><?php echo $value['name']; ?></option>
							<?php endforeach; ?>
						</select>
						<span style="margin-right:10px;"></span>
						<input type="submit" class="button-secondary" id="wpep_create_role_editor" name="wpep_create_role_editor" value="<?php _e('Create Editor for Role', 'wp_edit_pro'); ?>" />
						</form>
					</div>
				</div>
			</div>
		
			<div class="metabox-holder">
				<div class="postbox">
					<h3><?php _e( 'Create WordPress Capability Editor', 'wp_edit_pro' ); ?></h3>
					<div class="inside">
						<p><?php _e('Use this option to create an editor which will be assigned to the selected WordPress user capability.', 'wp_edit_pro'); ?></p>
						<form method="post" action="">
                        <select name="wpep_create_editor_cap_value">
							<?php
							foreach($capslist as $cap => $caps) {
								echo '<option value="'.$cap.'">'.$cap.'</option>';
							}
                            ?>
                        </select>
						<span style="margin-right:10px;"></span>
						<input type="submit" class="button-secondary" id="wpep_create_capability_editor" name="wpep_create_capability_editor" value="<?php _e('Create Editor for Capability', 'wp_edit_pro'); ?>" />
						</form>
					</div>
				</div>
			</div>
		
			<div class="metabox-holder">
				<div class="postbox">
					<h3><?php _e( 'Create User Specific Editor', 'wp_edit_pro' ); ?></h3>
					<div class="inside">
						<p><?php _e('Use this option to create an editor which will be assigned to the selected WordPress user.', 'wp_edit_pro'); ?></p>
                        <form action="" method="post">
					    <?php 
						if($this->network_blog_id !== '') {
							switch_to_blog($this->network_blog_id);
							wp_dropdown_users(array('name' => 'wpep_create_editor_user_value', 'show' => 'user_login'));
							restore_current_blog();
						}
						else {
							wp_dropdown_users(array('name' => 'wpep_create_editor_user_value', 'show' => 'user_login')); 
						}
						
						?>
						<span style="margin-right:10px;"></span>
						<input type="submit" class="button-secondary" id="wpep_create_user_editor" name="wpep_create_user_editor" value="<?php _e('Create Editor for User', 'wp_edit_pro'); ?>" />
                        </form>
					</div>
				</div>
			</div>
		
			<div class="metabox-holder">
				<div class="postbox">
					<h3><?php _e( 'Create Visitor Editor', 'wp_edit_pro' ); ?></h3>
					<div class="inside">
						<p><?php _e('Use this option to create an editor which will be assigned to site visitors; non site users.', 'wp_edit_pro'); ?></p>
                        <form action="" method="post">
							<input type="submit" class="button-secondary" id="wpep_create_visitor_editor" name="wpep_create_visitor_editor" value="<?php _e('Create Visitor Editor', 'wp_edit_pro'); ?>" />
                        </form>
					</div>
				</div>
			</div>
			
		</div>
		<div style="clear:both;"></div>
	</div>
    
    <?php
	/*
	****************************************************************
	Created editors container
	****************************************************************
	*/ 
	?>
	
	<div class="main_container">
    
        <form method="post" action="">
        
            <h2 style="display:inline-block;"><?php _e('Created Editors', 'wp_edit_pro'); ?></h2>
            
            <span style="margin-left:20px;"></span>
            
            <button type="submit" title="<?php _e('Table View', 'wp_edit_pro'); ?>" class="buttons_view_type" name="created_editors_view" value="table">
            
            	<img src="<?php echo $this->plugin_url . 'css/images/table.png'; ?>" />
            </button>
            <button type="submit" title="<?php _e('Tab View', 'wp_edit_pro'); ?>" class="buttons_view_type" name="created_editors_view" value="tabs">
            
            	<img src="<?php echo $this->plugin_url . 'css/images/tabs.png'; ?>" />
            </button>
        </form>
        
        <?php
		// Get created editors view type
		$ce_view = isset( $plugin_opts['wp_edit_pro_buttons_extras']['created_editors_view'] ) ? $plugin_opts['wp_edit_pro_buttons_extras']['created_editors_view'] : 'table';
		?>
        
        <?php if( $ce_view == 'tabs' ) { ?>
        
            <div id="created_editor_tabs">
            
                <ul>
                    <li><a href="#role_editors"><?php _e('Role Editors', 'wp_edit_pro'); ?></a></li>
                    <li><a href="#caps_editors"><?php _e('Capability Editors', 'wp_edit_pro'); ?></a></li>
                    <li><a href="#user_editors"><?php _e('User Editors', 'wp_edit_pro'); ?></a></li>
                    <li><a href="#visitor_editor"><?php _e('Visitor Editor', 'wp_edit_pro'); ?></a></li>
                </ul>
                
                <?php } ?>
          
          	<?php if( $ce_view == 'table' ) { ?>
            
            <div class="metabox-holder">
				<div class="postbox">
					<div class="inside">
                    <?php } ?>
                    
                        <div id="role_editors">
                        
                            <h3><?php _e('WordPress Roles Editors', 'wp_edit_pro'); ?></h3>
                                    
                            <?php
                            /*
                            ****************************************************************
                            Created wp role editors table
                            ****************************************************************
                            */ 
                            // Get all created wp role editors
                            $wp_roles_array = array();
                            foreach($plugin_opts as $key => $value) {
                                if (strpos($key ,'wp_edit_pro_buttons_wp_role_') !== false) {
                                    $wp_roles_array[$key] = $value;
                                }
                            }
                            // Loop editors and display in table
                            if(!empty($wp_roles_array)) {
                                
                                echo '<form action="" method="post">';
                                echo '<table class="table_aligned" rules="rows" cellpadding="10">';
                                ?><thead><tr><th><?php _e('Role', 'wp_edit_pro'); ?></th><th><?php _e('Action', 'wp_edit_pro'); ?></th></tr></thead><tbody><?php
                                foreach($wp_roles_array as $key => $value) {
                                    
                                    $key = str_replace('wp_edit_pro_buttons_wp_role_', '', $key);
                                    echo '<tr>';
                                        echo '<td>'.$key.'</td>';
                                        echo '<td><input type="submit" class="button-secondary" name="wpep_edit_wp_role_editor['.$key.']" value="Edit" />';
                                        echo '<span style="margin-right:10px;"></span>';
                                        echo '<input type="submit" class="button-secondary" name="wpep_delete_wp_role_editor['.$key.']" value="Delete" /></td></tr>';
                                }
                                echo '</tbody></table>';
                                echo '</form>';
                                echo '<br />';
                            }
                            else {
                                _e('No editors for WordPress roles have yet been created.', 'wp_edit_pro');
                                echo '<br /><br />';
                            }
                            ?>
                            <div class="error wpep_info">
                            <p><?php _e('WordPress roles are the bottom tier of how buttons are displayed for users in the editor.', 'wp_edit_pro'); ?><br />
                            <?php _e('If a WordPress capability or user specific editor has been created and is applicable to the user; it will be used instead of the role (even if the role is also applicable).', 'wp_edit_pro'); ?>
                            </p>
                            </div>
                        </div>
                        
						<?php if( $ce_view == 'table' ) { ?>
                
                		</div>
                 	</div>
                </div>
                
                <div class="metabox-holder">
					<div class="postbox">
						<div class="inside">
                <?php } ?>
          
                        <div id="caps_editors">
                        
                            <h3><?php _e('WordPress Capabilities Editors', 'wp_edit_pro'); ?></h3>
                                    
                            <?php
                            _e('WordPress capabilities are sortable because a user can have multiple user capabilities.', 'wp_edit_pro');
                            echo '<br />';
                            _e('If a user has multiple applicable capabilities; the capability highest on this list will be used for that user.', 'wp_edit_pro');
                            echo '<br /><br />';
                            
                            /*
                            ****************************************************************
                            Created wp capabilities editors table
                            ****************************************************************
                            */ 
                            // Get all capabilities
                            $wp_caps_array = array();
                            foreach($plugin_opts as $key => $value) {
                                if (strpos($key ,'wp_edit_pro_buttons_wp_cap_') !== false) {
                                    $wp_caps_array[$key] = $value;
                                }
                            }
                            
                            // Loop editors and display in table
                            if(!empty($wp_caps_array)) {
                                
                                echo '<form action="" method="post">';
                                ?>
                                <table id="sort_capabilities" class="table_aligned" rules="rows" cellpadding="10">
                                    <thead><tr><th><?php _e('Capability', 'wp_edit_pro'); ?></th><th><?php _e('Action', 'wp_edit_pro'); ?></th></tr></thead>
                                    <tbody>
                                        <?php
                                        foreach($wp_caps_array as $key => $value) {
                                            $key = str_replace('wp_edit_pro_buttons_wp_cap_', '', $key);
                                            echo '<tr id="'.$key.'">';
                                                echo '<td><span title="Sort" class="dashicons dashicons-sort"></span>'.$key.'</td>';
                                                echo '<td><input type="submit" class="button-secondary" name="wpep_edit_wp_cap_editor['.$key.']" value="Edit" />';
                                                echo '<span style="margin-right:10px;"></span>';
                                                echo '<input type="submit" class="button-secondary" name="wpep_delete_wp_cap_editor['.$key.']" value="Delete" /></td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                            }
                            else {
                                _e('No editors for WordPress capabilties have yet been created.', 'wp_edit_pro');
                                echo '<br /><br />';
                            }
                            echo '</form>';
                            echo '<br />';
                            ?>
                            
                            <form method="post" action="">
                                <input type="hidden" name="wpep_submit_caps_sort_array" id="wpep_submit_caps_sort_array" value="" />
                                <input type="submit" name="wpep_submit_caps_sort" class="button-secondary" value="<?php _e('Save Sorted Capabilities', 'wp_edit_pro'); ?>" />
                            </form>
                            <br />
                            <div class="error wpep_info">
                                <p><?php _e('WordPress capabilities are the middle tier of how buttons are displayed for users in the editor.', 'wp_edit_pro'); ?><br />
                                    <?php _e('A created WordPress capabilities editor will override a created WordPress roles editor.', 'wp_edit_pro'); ?><br />
                                    <?php _e('However; a user specific editor will override a WordPress capabilities editor (when applicable).', 'wp_edit_pro'); ?>
                                </p>
                            </div>
                        </div>
                        
						<?php if( $ce_view == 'table' ) { ?>
                
                		</div>
                 	</div>
                </div>
                
                <div class="metabox-holder">
					<div class="postbox">
						<div class="inside">
                <?php } ?>
          
                        <div id="user_editors">
                        
                            <h3><?php _e('User Specific Editors', 'wp_edit_pro'); ?></h3>
                                    
                            <?php
                            /*
                            ****************************************************************
                            Created user specific editors table
                            ****************************************************************
                            */ 
                            // Get all users
                            if($this->network_blog_id !== '') {
                                switch_to_blog($this->network_blog_id);
                                $users = get_users();
                                restore_current_blog();
                            }
                            else {
                                $users = get_users(); 
                            }
                            
                            $users_exist = 'false';
                            
                            // Check if table will be empty
                            foreach ($users as $user) {
                                $user_meta = get_user_meta($user->ID, 'aaa_wp_edit_pro_user_meta', true);
                                if(!empty($user_meta) && array_key_exists('wp_edit_pro_buttons_user_editor', $user_meta)) {
                                    $users_exist = 'true';
                                }
                            }
                            
                            // Loop users to search user meta
                            if($users_exist === 'true') {
                                
                                echo '<form action="" method="post">';
                                echo '<table class="table_aligned" rules="rows" cellpadding="10">';
                                ?><thead><tr><th><?php _e('User', 'wp_edit_pro'); ?></th><th><?php _e('Action', 'wp_edit_pro'); ?></th></tr></thead><tbody><?php
                                foreach ($users as $user) {
                                    
                                    // Get user meta
                                    $user_meta = get_user_meta($user->ID, 'aaa_wp_edit_pro_user_meta', true);
                                    
                                    // Check that user has custom editor
                                    if(!empty($user_meta) && array_key_exists('wp_edit_pro_buttons_user_editor', $user_meta)) {
                                        echo '<tr>';
                                            echo '<td>'.$user->user_login.'</td>';
                                            echo '<td><input type="submit" class="button-secondary" name="wpep_edit_user_editor['.$user->ID.']" value="Edit" />';
                                            echo '<span style="margin-right:10px;"></span>';
                                            echo '<input type="submit" class="button-secondary" name="wpep_delete_user_editor['.$user->ID.']" value="Delete" /></td></tr>';
                                        echo '</tr>';
                                    }
                                }
                                echo '</tbody></table>';
                                echo '</form>';
                                echo '<br />';
                            }
                            else {
                                _e('No editors for specific users have yet been created.', 'wp_edit_pro');
                                echo '<br /><br />';
                            }
                            ?>
                            <div class="error wpep_info">
                                <p>
                                    <?php _e('User specific editors are the top tier of how buttons are displayed for users in the editor.', 'wp_edit_pro'); ?><br />
                                    <?php _e('These editors will override both a roles editor and a capabilities editor; because these editors are most specific to the user.', 'wp_edit_pro'); ?>
                                </p>
                            </div>
                        </div>
                        
						<?php if( $ce_view == 'table' ) { ?>
                
                		</div>
                 	</div>
                </div>
                
                <div class="metabox-holder">
					<div class="postbox">
						<div class="inside">
                <?php } ?>
          
                        <div id="visitor_editor">
                        
                            <h3><?php _e('Visitor Editor', 'wp_edit_pro'); ?></h3>
                                    
                            <?php
                            /*
                            ****************************************************************
                            Created visitor editor table
                            ****************************************************************
                            */
                            
                            if(isset($plugin_opts['wp_edit_pro_buttons_wp_visitor'])) {
                                echo '<form action="" method="post">';
                                echo '<table class="table_aligned" rules="rows" cellpadding="10">';
                                ?><thead><tr><th><?php _e('Name', 'wp_edit_pro'); ?></th><th><?php _e('Action', 'wp_edit_pro'); ?></th></tr></thead><tbody><tr><?php
                                    echo '<td>Visitor</td>';
                                    echo '<td><input type="submit" class="button-secondary" name="wpep_edit_visitor_editor" value="Edit" />';
                                    echo '<span style="margin-right:10px;"></span>';
                                    echo '<input type="submit" class="button-secondary" name="wpep_delete_visitor_editor" value="Delete" /></td></tr>';
                                echo '</tbody></table>';
                                echo '</form>';
                                echo '<br />';
                            }
                            else {
                                _e('No visitor editor has yet been created.', 'wp_edit_pro');
                                echo '<br /><br />';
                            }
                            ?>
                            <div class="error wpep_info">
                                <p>
                                    <?php _e('This is the editor used for site visitors.', 'wp_edit_pro'); ?><br />
                                    <?php _e('Site visitors would not have any role, capability, or user editor; so this will be used instead.', 'wp_edit_pro'); ?>
                                </p>
                            </div>
                        </div>
                        
						<?php if( $ce_view == 'table' ) { ?>
                
                		</div>
                 	</div>
                </div>
                <?php } ?>
            
        	<?php if( $ce_view == 'tabs' ) { ?>
        </div> <!-- End #created_editor_tabs -->   
        <?php } ?>
	</div> <!-- End .main_container -->
	<?php
}


/*
****************************************************************
Network Tab
****************************************************************
*/
if($active_tab == 'network'){

	?>
	<div class="main_container">
		<h2><?php _e('Network Options','wp_edit_pro'); ?></h2>
		<p><?php _e('These options are only available when the plugin is network activated.','wp_edit_pro'); ?></p>
        
		<form method="post" action="">
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
					
                    <?php
					$network_mode = isset($plugin_opts['wp_edit_pro_network']['wpep_network_admin_mode']) ? $plugin_opts['wp_edit_pro_network']['wpep_network_admin_mode'] : 'same';
					
					$network_mode_same = $network_mode === 'same' ? 'checked="checked"' : '';
					$network_mode_separate = $network_mode === 'separate' ? 'checked="checked"' : '';
					$network_mode_dropdown_selected = isset($this->network_blog_id) ? $this->network_blog_id : '';
					
					// Set disabled options if plugin is not network activated
					$network_mode_same = $this->network_activated === false ? 'disabled="disabled"' : $network_mode_same;
					$network_mode_separate = $this->network_activated === false ? 'disabled="disabled"' : $network_mode_separate;
					$network_mode_dropdown = $this->network_activated === false ? 'disabled="disabled"' : '';
					$network_mode_save = $this->network_activated === false ? 'disabled="disabled"' : '';
					
					// Set disabled option if plugin is network activated
					$network_mode_dropdown = (isset($this->network_admin_mode) && $this->network_admin_mode !== 'same') ? $network_mode_dropdown : 'disabled="disabled"';
					$network_mode_same = (isset($this->network_blog_id) && $this->network_blog_id === '') ? $network_mode_same : 'disabled="disabled"';
					$network_mode_separate = (isset($this->network_blog_id) && $this->network_blog_id === '') ? $network_mode_separate : 'disabled="disabled"';
					$network_mode_save = (isset($this->network_blog_id) && $this->network_blog_id === '') ? $network_mode_save : 'disabled="disabled"';
					?>
                    
                    <h3><?php _e('Network Settings', 'wp_edit_pro'); ?></h3>
                    <p><?php _e( 'When network activated; you may select if all sub-sites should use identical settings, or you can administer different settings for each sub-site.', 'wp_edit_pro' ); ?></p>
                    <input type="radio" name="wpep_network_admin_mode" value="same" <?php echo $network_mode_same; ?> /> <?php _e('Use the same settings for every site in the network.','wp_edit_pro'); ?><br />
                    <input type="radio" name="wpep_network_admin_mode" value="separate" <?php echo $network_mode_separate; ?> /> <?php _e('Use separate settings for each site in the network.','wp_edit_pro'); ?>
                </div>
            </div>
            
            <div class="postbox">
            	<div class="inside">
                    
                    <h3><?php _e('Switch to Network Site', 'wp_edit_pro'); ?></h3>
                    
                    <?php
					// Create network sites dropdown
					$blog_ids = array();
					if($this->network_activated === true) {
						
						// Version compare (wp_get_sites() deprecated)
						if( $this->wp_version < '4.6.0' ) {
							
							// Use old wp_get_sites() function
							$sites = wp_get_sites();
							foreach($sites as $key => $value) {
								
								array_push($blog_ids, $value['blog_id']);
							}
						}
						else {
							
							// Use new get_sites() function
							$get_sites = get_sites();
							foreach($get_sites as $key => $value) {
								
								array_push($blog_ids, $value->blog_id);
							}
						}
					}
					?>
                    
                    <p><?php _e('Switch to a network site to administer settings for that site.','wp_edit_pro'); ?><br />
                    <em><?php _e( '(Network settings option above must be set to use "separate settings" for each site.)', 'wp_edit_pro' ); ?></em></p>
                    <?php _e('Select network site','wp_edit_pro'); ?><span style="margin-right:20px;"></span>
                    <select name="wpep_select_blog_id" <?php echo $network_mode_dropdown; ?> >
                        <?php
                        if($this->network_activated === true) {
                                
                            foreach($blog_ids as $key => $value) {
                                $blog_details = get_blog_details($value);
                                $blog_name = $blog_details->blogname;
                                echo '<option value="'.$value.'" '.($network_mode_dropdown_selected == $value ? 'selected="selected"' : '').' />'.$value.' - '.$blog_name.'</option>';
                            }
                        }
                        else {
                            $blog_info = get_bloginfo('name');
                            echo '<option value="1">1 - '.$blog_info.'</option>';
                        }
                        ?>
                    </select><span style="margin-right:20px;"></span>
                    <input type="submit" name="wpep_submit_blog_id" value="<?php _e('Switch to Site','wp_edit_pro'); ?>" class="button-secondary" <?php echo $network_mode_dropdown; ?> />
				</div>
			</div>
		</div>
        <input type="submit" value="<?php _e('Save Network Options','wp_edit_pro'); ?>" class="button button-primary" id="submit_network" name="submit_network" <?php echo $network_mode_save; ?> />
        </form>
	</div>
	<?php
}    



/*
****************************************************************
Global Tab
****************************************************************
*/
if($active_tab == 'global'){

	echo '<div class="main_container">';
		?>
		<h2><?php _e('Global Options','wp_edit_pro'); ?></h2>
		<p><?php _e('These options control various items used throughout the plugin.','wp_edit_pro'); ?></p>
		<form method="post" action="">
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
				
					<?php
					$jquery_theme_set = isset($plugin_opts['wp_edit_pro_global']['jquery_theme']) ? $plugin_opts['wp_edit_pro_global']['jquery_theme'] : 'smoothness';
					$disable_buttons_fancy_tooltips = isset($plugin_opts['wp_edit_pro_global']['disable_buttons_fancy_tooltips']) && $plugin_opts['wp_edit_pro_global']['disable_buttons_fancy_tooltips'] === '1' ? 'checked="checked"' : '';
					?>
                    
                    <table cellpadding="10">
                    <tbody>
                    <tr><td><?php _e('jQuery Theme','wp_edit_pro'); ?></td>
                        <td>
                        <select id="jquery_theme" name="jquery_theme"/>
                        <?php
                        $jquery_themes = array('base','black-tie','blitzer','cupertino','dark-hive','dot-luv','eggplant','excite-bike','flick','hot-sneaks','humanity','le-frog','mint-choc','overcast','pepper-grinder','redmond','smoothness','south-street','start','sunny','swanky-purse','trontastic','ui-darkness','ui-lightness','vader');
                                                        
                        foreach($jquery_themes as $jquery_theme) {
                            $selected = ($jquery_theme_set === $jquery_theme) ? 'selected="selected"' : '';
                            echo "<option value='$jquery_theme' $selected>$jquery_theme</option>";
                        }
                        ?>
                        </select>
                        <label for="jquery_theme"> <?php _e('Selects the jQuery theme for buttons rows (Buttons tab).', 'wp_edit_pro'); ?></label>
                        </td>
                    </tr>
                    <tr><td><?php _e('Disable Buttons Fancy Tooltips','wp_edit_pro'); ?></span></td>
                        <td>
                        <input id="disable_buttons_fancy_tooltips" type="checkbox" value="1" name="disable_buttons_fancy_tooltips" <?php echo $disable_buttons_fancy_tooltips; ?> />
                        <label for="disable_buttons_fancy_tooltips"><?php _e('Disables the fancy tooltips when hovering over buttons.', 'wp_edit_pro'); ?></label>
                        </td>
                    </tr>
                    </tbody>
                    </table> 
				</div>
			</div>
		</div>      
        <input type="submit" value="<?php _e('Save Global Options','wp_edit_pro'); ?>" class="button button-primary" id="submit_global" name="submit_global">
        </form>
		<?php
	echo '</div>';
}


/*
****************************************************************
Configuration Tab
****************************************************************
*/
if($active_tab == 'configuration'){

	global $jwl_advmceconf_show_defaults;
	$jwl_advmceconf_show_defaults = array();
	
	//$options_configuration = $this->wp_edit_pro_options_array['wp_edit_pro_configuration'];
	$options_configuration = isset($plugin_opts['wp_edit_pro_configuration']) ? $plugin_opts['wp_edit_pro_configuration'] : array();
	
	echo '<div class="main_container">';
		?>
		<h2><?php _e('Advanced Configuration Page','wp_edit_pro'); ?></h2>
		<p><?php _e('This page allows modification of the values used in the tinymce initialization process.', 'wp_edit_pro'); ?></p>
		
		<div class="metabox-holder"> 
			<div class="postbox">
			
				<div class="inside">
				
					<p><?php _e('Several of the more commonly used settings are:', 'wp_edit_pro'); ?></p>
					
					<div>
						<ul class="ul-disc">
						<li><a href="//tinymce.moxiecode.com/wiki.php/Configuration:invalid_elements" target="_blank">invalid_elements</a></li>
						<li><a href="//tinymce.moxiecode.com/wiki.php/Configuration:extended_valid_elements" target="_blank">extended_valid_elements</a></li>
						</ul>
					</div>
					
					<p class="">
						<?php _e('Descriptions of all settings are available in the', 'jwl_utmce_advanced'); ?> <a href="http://tinymce.moxiecode.com/wiki.php/Configuration" target="_blank"><?php _e('TinyMCE documentation.', 'wp_edit_pro'); ?></a><br />
					
						<?php
						$url = 'http://learn.wpeditpro.com/configuration/';
						$link = sprintf( __( 'Examples can be found on the <a href="%s" target="_blank">WP Edit Pro Knowledge Base</a>.', 'wp_edit_pro' ), esc_url( $url ) );
						echo $link;
						?>
					</p>
				</div>
			</div>
		</div>
		<hr />
		
		<h3><span><?php _e('Default Initialization Settings','wp_edit_pro'); ?></span></h3>
		<p><?php _e('Display and adjust the default editor initialization values.','wp_edit_pro'); ?></p>
		
		<table class="jwl_advmceconf-defaults wpep_config_table table table-bordered" id="wpep_showhide_tmce_table" style="display:none;">
			<thead>
			<tr>
				<th class="names"><?php _e('Option Name', 'wp_edit_pro'); ?></th>
				<th class="sep">&nbsp;</th>
				<th><?php _e('Option Value', 'wp_edit_pro'); ?></th>
				<th class="actions"><?php _e('Action', 'wp_edit_pro'); ?></th>
			</tr>
			</thead>
		<tbody>
		
		<?php
		
		
		remove_filter('tiny_mce_before_init', 'wpep_adv_config_init_editor' );  // Remove custom filter
		add_filter('tiny_mce_before_init', 'wpep_get_tmce_init_defaults', 1001 );  // Add filter to get init defaults
		
		ob_start();
		wp_editor( '', 'content', array( 'media_buttons' => false, 'quicktags' => false ) );
		ob_end_clean();
		
		unset($GLOBALS['merged_filters']['tiny_mce_before_init']);  // Destroy init filter (added again next page load)
		
		$n = 1;
		if($jwl_advmceconf_show_defaults) {
			
			foreach ($jwl_advmceconf_show_defaults as $dfield => $dvalue) {
				
				if ( is_bool($dvalue) )
				$dvalue = $dvalue ? 'true' : 'false';
				?>
				
				<tr>
					<td id="n<?php echo $n; ?>" class="names"><?php echo $dfield; ?></td>
					<td class="sep">:</td>
					<td id="v<?php echo $n; ?>"><?php echo htmlspecialchars($dvalue, ENT_QUOTES); ?></td>
					<td class="actions">
					
					<span class="tooltip" title="<p><?php _e('Click to edit the option value.','wp_edit_pro'); ?></p><p><?php _e('Once clicked, the page will scroll to the bottom and the new option name and option value will become editable.','wp_edit_pro'); ?></p>">
						<input type="button" class="button-secondary wpep_tmce_change_button" value="<?php _e('Change', 'wp_edit_pro'); ?>" />
					</span>
					
					</td>
				</tr>
				<?php 
				$n++;
			} 
		}
		?>
		</tbody>
		</table>
		
		<p>
		<button type="button" class="button-secondary" id="wpep_show_tmce_button"><?php _e('Show the default TinyMCE settings', 'wp_edit_pro'); ?></button>
		<button type="button" class="button-secondary" id="wpep_hide_tmce_button" style="display: none;"><?php _e('Hide the default TinyMCE settings', 'wp_edit_pro'); ?></button>
		</p>
		<hr />
		
		<h3><span><?php _e('Custom Initialization Settings','wp_edit_pro'); ?></span></h3>
		
		<p><?php _e('To add an option to TinyMCE type the name on the left and the value on the right. <strong>Do not</strong> type quotes around the option name or value.', 'wp_edit_pro'); ?><br />
		<?php _e('To add boolean values type the word <strong>true</strong> or <strong>false</strong>.', 'wp_edit_pro'); ?></p>
        
        <p><?php _e( 'NOTE: Any options added below will take priority over any exisiting option of the same name above.', 'wp_edit_pro' ); ?></p>
		
		<form method="post" action="" style="padding:10px 0">
			<table class="wpep_config_table table table-bordered" id="wpep_adv_cfg_set">
				<thead>
				<tr>
					<th class="names"><?php _e('Option name', 'wp_edit_pro'); ?></th>
					<th><?php _e('Option Value', 'wp_edit_pro'); ?></th>
					<th class="actions"><?php _e('Action', 'wp_edit_pro'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php
				
				if(!empty($options_configuration)) {
					
					foreach ($options_configuration as $field => $value) {
						
						$id = "wpep_tmce_option_field-{$field}";
						$name = "wpep_adv_cfg_options[{$field}]";
					
						if ( is_bool($value) )
							$value = $value ? 'true' : 'false'; ?>
					
						<tr>
						<td class="names"><input class="wpep_option_names" type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo $field; ?>" /></td>
						<td class="values"><textarea name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="added_value" spellcheck="false"><?php echo htmlspecialchars($value, ENT_NOQUOTES); ?></textarea></td>
						<td class="actions"><input type="button" class="button-secondary wpep_tmce_remove_button" value="<?php _e('Remove', 'wp_edit_pro'); ?>" /></td>
						</tr>
						<?php 
					} 
				}
				?>
				
				<tr class="wpep_new_values">
					<td class="names"><input type="text" name="wpep_tmce_new_name" id="wpep_tmce_new_name" value="" /></td>
					<td><textarea name="wpep_tmce_new_val" id="wpep_tmce_new_val" class="added_value" spellcheck="false"></textarea></td>
					<td>&nbsp;</td>
				</tr>
				</tbody>
			</table>
			
			<p class="submit">
				<input type="submit" value="<?php _e('Save Configuration Options', 'wp_edit_pro'); ?>" class="button-primary" name="wpep_adv_config_save" />
			</p>
		</form>

		<?php
	echo '</div>';
}


/*
****************************************************************
General Tab
****************************************************************
*/
if($active_tab == 'general'){
	
	// Get all cpt's (_builtin will exclude default post types)
	if($this->network_blog_id !== '') {
		
		switch_to_blog( $this->network_blog_id );
		global $wpdb;
		$get_db_types = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "posts" );
		$post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'names' );
		restore_current_blog();
		
		// Remove default wp post types
		$rem_array = array( 'post', 'page', 'attachment', 'revision' );
		
		foreach( $get_db_types as $key => $value ) {
			
			if( ! in_array( $value->post_type, $rem_array ) ) {
				
				//$post_types[] = $value->post_type;
			}
		}
	}
	else {
		
		$post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'names' );
	}
	
	// Begin page container
	echo '<div class="main_container">';
	
		?>
        <h2><?php _e('General Options', 'wp_edit_pro'); ?></h2>
		<p><?php _e('General plugin options.', 'wp_edit_pro'); ?></p>
        
		<form method="post" action="">
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
				
					<?php
					$linebreak_shortcode = isset($plugin_opts['wp_edit_pro_general']['linebreak_shortcode']) && $plugin_opts['wp_edit_pro_general']['linebreak_shortcode'] === '1' ? 'checked="checked"' : '';
					$shortcodes_in_widgets = isset($plugin_opts['wp_edit_pro_general']['shortcodes_in_widgets']) && $plugin_opts['wp_edit_pro_general']['shortcodes_in_widgets'] === '1' ? 'checked="checked"' : '';
					$shortcodes_in_excerpts = isset($plugin_opts['wp_edit_pro_general']['shortcodes_in_excerpts']) && $plugin_opts['wp_edit_pro_general']['shortcodes_in_excerpts'] === '1' ? 'checked="checked"' : '';
					$post_excerpt_editor = isset($plugin_opts['wp_edit_pro_general']['post_excerpt_editor']) && $plugin_opts['wp_edit_pro_general']['post_excerpt_editor'] === '1' ? 'checked="checked"' : '';
					$page_excerpt_editor = isset($plugin_opts['wp_edit_pro_general']['page_excerpt_editor']) && $plugin_opts['wp_edit_pro_general']['page_excerpt_editor'] === '1' ? 'checked="checked"' : '';
					$profile_editor = isset($plugin_opts['wp_edit_pro_general']['profile_editor']) && $plugin_opts['wp_edit_pro_general']['profile_editor'] === '1' ? 'checked="checked"' : '';
					$cpt_excerpts = isset($plugin_opts['wp_edit_pro_general']['wpep_cpt_excerpts']) ? $plugin_opts['wp_edit_pro_general']['wpep_cpt_excerpts'] : array();
					?>
					
					<h3><?php _e('Shortcodes', 'wp_edit_pro'); ?></h3>
                    
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('Linebreak Shortcode', 'wp_edit_pro'); ?></td>
						<td>
						<input id="linebreak_shortcode" type="checkbox" value="1" name="linebreak_shortcode" <?php echo $linebreak_shortcode; ?> />
						<label for="linebreak_shortcode"><?php _e('Use the [break] shortcode to insert linebreaks in the editor.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					<tr><td><?php _e('Shortcodes in Widgets', 'wp_edit_pro'); ?></td>
						<td>
						<input id="shortcodes_in_widgets" type="checkbox" value="1" name="shortcodes_in_widgets" <?php echo $shortcodes_in_widgets; ?> />
						<label for="shortcodes_in_widgets"><?php _e('Use shortcodes in widget areas.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					<tr><td><?php _e('Shortcodes in Excerpts', 'wp_edit_pro'); ?></td>
						<td>
						<input id="shortcodes_in_excerpts" type="checkbox" value="1" name="shortcodes_in_excerpts" <?php echo $shortcodes_in_excerpts; ?> />
						<label for="shortcodes_in_excerpts"><?php _e('Use shortcodes in excerpt areas.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">  
                          
					<h3><?php _e('Excerpts', 'wp_edit_pro'); ?></h3>
                    
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('WP Edit Pro Post Excerpt', 'wp_edit_pro'); ?></td>
						<td>
						<input id="post_excerpt_editor" type="checkbox" value="1" name="post_excerpt_editor" <?php echo $post_excerpt_editor; ?> />
						<label for="post_excerpt_editor"><?php _e('Add the WP Edit Pro editor to the Post Excerpt area.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					<tr><td><?php _e('WP Edit Pro Page Excerpt', 'wp_edit_pro'); ?></td>
						<td>
						<input id="page_excerpt_editor" type="checkbox" value="1" name="page_excerpt_editor" <?php echo $page_excerpt_editor; ?> />
						<label for="page_excerpt_editor"><?php _e('Add the WP Edit Pro editor to the Page Excerpt area.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					</tbody>
					</table>
					
					<h3><?php _e('Custom Post Type Excerpts', 'wp_edit_pro'); ?></h3>
                    
					<table cellpadding="3" style="margin-left:7px;">
					<tbody>
					<?php
					if( !empty( $post_types) ) {
						
						foreach ( $post_types as $post_type ) {
							
							$selected = in_array($post_type, $cpt_excerpts) ? 'checked="checked"' : ''; 
								
							echo '<tr><td><input type="checkbox" name="wpep_cpt_excerpts['.$post_type.']" '.$selected.'> '.$post_type.'</td></tr>';
						}
					}
					else {
						
						echo '<tr><td>';
						_e( 'No registered custom post types were found.', 'wp_edit_pro' );
						echo '</td></tr>';
					}
					?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">  
					
					<h3><?php _e( 'Miscellaneous', 'wp_edit_pro' ); ?></h3>
                    
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e( 'Profile Editor', 'wp_edit_pro' ); ?></td>
						<td class="jwl_user_cell">
							<input id="profile_editor" type="checkbox" value="1" name="profile_editor" <?php echo $profile_editor; ?> />
							<label for="profile_editor"><?php _e( 'Use modified editor in profile biography field.', 'wp_edit_pro' ); ?></label>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<input type="submit" value="<?php _e('Save General Options', 'wp_edit_pro'); ?>" class="button button-primary" id="submit_general" name="submit_general">
		</form>
		<?php
	echo '</div>';
}


/*
****************************************************************
Posts Tab
****************************************************************
*/
if( $active_tab == 'posts' ){
	
	$wpep_styles_editor_textarea 	= isset($plugin_opts['wp_edit_pro_posts']['wpep_styles_editor_textarea']) ? $plugin_opts['wp_edit_pro_posts']['wpep_styles_editor_textarea'] : '';
	$wpep_scripts_editor_textarea 	= isset($plugin_opts['wp_edit_pro_posts']['wpep_scripts_editor_textarea']) ? $plugin_opts['wp_edit_pro_posts']['wpep_scripts_editor_textarea'] : '';
	$wpep_ind_styles_scripts 		= isset($plugin_opts['wp_edit_pro_posts']['wpep_ind_styles_scripts']) && $plugin_opts['wp_edit_pro_posts']['wpep_ind_styles_scripts'] === '1' ? 'checked="checked"' : '';
	
	$page_title_field = isset($plugin_opts['wp_edit_pro_posts']['page_title_field']) ? $plugin_opts['wp_edit_pro_posts']['page_title_field'] : 'Enter title here';
	$post_title_field = isset($plugin_opts['wp_edit_pro_posts']['post_title_field']) ? $plugin_opts['wp_edit_pro_posts']['post_title_field'] : 'Enter title here';
	
	$column_shortcodes = isset($plugin_opts['wp_edit_pro_posts']['column_shortcodes']) && $plugin_opts['wp_edit_pro_posts']['column_shortcodes'] === '1' ? 'checked="checked"' : '';
	
	$editor_notes = isset($plugin_opts['wp_edit_pro_posts']['editor_notes']) && $plugin_opts['wp_edit_pro_posts']['editor_notes'] === '1' ? 'checked="checked"' : '';
	
	$max_post_revisions = isset($plugin_opts['wp_edit_pro_posts']['max_post_revisions']) ? $plugin_opts['wp_edit_pro_posts']['max_post_revisions'] : '';
	$max_page_revisions = isset($plugin_opts['wp_edit_pro_posts']['max_page_revisions']) ? $plugin_opts['wp_edit_pro_posts']['max_page_revisions'] : '';
	
	$hide_admin_posts = isset($plugin_opts['wp_edit_pro_posts']['hide_admin_posts']) ? $plugin_opts['wp_edit_pro_posts']['hide_admin_posts'] : '';
	$hide_admin_pages = isset($plugin_opts['wp_edit_pro_posts']['hide_admin_pages']) ? $plugin_opts['wp_edit_pro_posts']['hide_admin_pages'] : '';
	
	$enable_comment_editor = isset($plugin_opts['wp_edit_pro_posts']['enable_comment_editor']) && $plugin_opts['wp_edit_pro_posts']['enable_comment_editor'] === '1' ? 'checked="checked"' : '';
	$enable_add_media = isset($plugin_opts['wp_edit_pro_posts']['enable_add_media']) && $plugin_opts['wp_edit_pro_posts']['enable_add_media'] === '1' ? 'checked="checked"' : '';
	?>
    
    <div class="main_container">
    
		<h2><?php _e('Posts/Pages Options', 'wp_edit_pro'); ?></h2>
		<p><?php _e('These options apply specifically to posts and pages.', 'wp_edit_pro'); ?></p>
        
		<form method="post" action="">
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><span><?php _e('Styles & Scripts','wp_edit_pro'); ?></span></h3>
			
					<p><strong><?php _e('Global Styles', 'wp_edit_pro'); ?></strong><br />
					<?php _e('These styles will be added to every front-end post and page.', 'wp_edit_pro');?><br />
					<?php _e ('They will be wrapped in <code>&#60;style&#62;</code> tags; and inserted just before the closing <code>&#60;/head&#62;</code> tag.', 'wp_edit_pro'); ?></p>
                    
					<div id="wpep_styles_ace_editor">
						<div name="wpep_styles_editor" id="wpep_styles_editor"></div>
						<textarea id="wpep_styles_editor_textarea" name="wpep_styles_editor_textarea" style="display: none;"><?php echo $wpep_styles_editor_textarea; ?></textarea><br />
					</div>
				
					<p><strong><?php _e('Global Scripts', 'wp_edit_pro'); ?></strong><br />
					<?php _e('These scripts will be added to every front-end post and page.', 'wp_edit_pro'); ?><br />
					<?php _e('They will be wrapped in <code>&#60;script&#62;</code> tags; and inserted just before the closing <code>&#60;/body&#62;</code> tag.', 'wp_edit_pro'); ?></p>
                    
					<div id="wpep_scripts_ace_editor">
						<div name="wpep_scripts_editor" id="wpep_scripts_editor"></div>
						<textarea id="wpep_scripts_editor_textarea" name="wpep_scripts_editor_textarea" style="display: none;"><?php echo $wpep_scripts_editor_textarea; ?></textarea><br />
						<input type="hidden" id="wpep_scripts_editor_textarea_output" name="wpep_scripts_editor_textarea_output" value="" /><br />
					</div>
					
					<p><strong><?php _e('Individual post/page styles and scripts.', 'wp_edit_pro'); ?></strong><br />
					<?php _e('This setting will allow writing separate styles and scripts for separate posts and pages.', 'wp_edit_pro'); ?><br />
					<?php _e('A new metabox will be added to each post/page; allowing input of new styles and scripts.', 'wp_edit_pro'); ?></p>
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('Enable individual post/page styles and scripts', 'wp_edit_pro'); ?></td>
						<td class="jwl_user_cell">
							<input id="wpep_ind_styles_scripts" type="checkbox" value="1" name="wpep_ind_styles_scripts" <?php echo $wpep_ind_styles_scripts; ?> />
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><span><?php _e('Page/Post Default Titles','wp_edit_pro'); ?></span></h3>
                    <p><?php _e( 'Adjust the default title shown when creating a new post/page.', 'wp_edit_pro' ); ?></p>
			
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('Page Default Title', 'wp_edit_pro'); ?></td>
						<td>
						<input type="text" name="page_title_field" value="<?php echo $page_title_field ?>" />
						<label for="page_title_field"><?php _e('Change the default "add new" page title field.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					<tr><td><?php _e('Post Default Title', 'wp_edit_pro'); ?></td>
						<td>
						<input type="text" name="post_title_field" value="<?php echo $post_title_field ?>" />
						<label for="post_title_field"><?php _e('Change the default "add new" post title field.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
                    </tbody>
                    </table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">  
                	
                    <h3><span><?php _e('Column Shortcodes','wp_edit_pro'); ?></span></h3>
                    
                	<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('Column Shortcodes', 'wp_edit_pro'); ?></td>
						<td>
						<input id="column_shortcodes" type="checkbox" value="1" name="column_shortcodes" <?php echo $column_shortcodes; ?> />
						<label for="column_shortcodes"><?php _e('Enable the column shortcodes functionality.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">  
					
					<h3><?php _e('Editor Notes', 'wp_edit_pro'); ?></h3>
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('Enable Editor Notes', 'wp_edit_pro'); ?></td>
						<td class="jwl_user_cell">
							<input id="editor_notes" type="checkbox" value="1" name="editor_notes" <?php echo $editor_notes; ?> />
							<label for="editor_notes"><?php _e('Add an admin editor to posts and pages for notekeeping (only visible to admins).', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><span><?php _e('Page Revisions','wp_edit_pro'); ?></span></h3>
                    <p><?php _e( 'Page revisions are stored in the database, and can grow quite large when dealing with extreme amounts of content.', 'wp_edit_pro' ); ?><br />
                    <?php _e( 'Use these options to limit (or delete) the number of revisions.', 'wp_edit_pro' ); ?></p>
			
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('Max Post Revisions', 'wp_edit_pro'); ?></td>
						<td>
						<input type="text" name="max_post_revisions" value="<?php echo $max_post_revisions ?>" />
						<label for="max_post_revisions"><?php _e('Set max number of Post Revisions to store in database.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					<tr><td><?php _e('Max Page Revisions', 'wp_edit_pro'); ?></td>
						<td>
						<input type="text" name="max_page_revisions" value="<?php echo $max_page_revisions ?>" />
						<label for="max_page_revisions"><?php _e('Set max number of Page Revisions to store in database.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					<tr><td><?php _e('Delete Revisions', 'wp_edit_pro'); ?></td>
						<td>
						<input id="delete_revisions" type="checkbox" value="1" name="delete_revisions" />
						<label for="delete_revisions"><?php _e('Delete all database revisions.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					<tr><td><?php _e('Revisions DB Size', 'wp_edit_pro'); ?></td>
						<td>
							<?php
							global $wpdb;
							
							if($this->network_blog_id !== '') {
								
								switch_to_blog($this->network_blog_id);
								$posts = $wpdb->prefix.'posts';
								$query = $wpdb->get_results( "SELECT * FROM ".$posts." WHERE post_type = 'revision'", ARRAY_A );
								restore_current_blog();
							}
							else {
								$posts = $wpdb->prefix.'posts';
								$query = $wpdb->get_results( "SELECT * FROM ".$posts." WHERE post_type = 'revision'", ARRAY_A );
							}
							$lengths = 0;
							foreach ($query as $row) {
								$lengths += strlen( $row['post_content'] );
							}
							
							echo 'Current size of revisions stored in database:'.' <strong>'.number_format( $lengths / ( 1024 * 1024 ), 3 ).' mb</strong>';
							?>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><?php _e('Hide Posts and Pages', 'wp_edit_pro'); ?></h3>
			
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('Hide Admin Posts', 'wp_edit_pro'); ?></td>
						<td>
						<input type="text" name="hide_admin_posts" value="<?php echo $hide_admin_posts ?>" />
						<label for="hide_admin_posts"><?php _e('Hide selected posts from admin view. (comma separated post ids: 2,4,67,etc.)', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					<tr><td><?php _e('Hide Admin Pages', 'wp_edit_pro'); ?></td>
						<td>
						<input type="text" name="hide_admin_pages" value="<?php echo $hide_admin_pages ?>" />
						<label for="hide_admin_pages"><?php _e('Hide selected pages from admin view. (comma separated page ids: 2,4,67,etc.)', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><?php _e('Comment Editor', 'wp_edit_pro'); ?></h3>
			
					<p><?php _e('Replaces the standard comment textarea with a WP Edit Pro rich text editor.', 'wp_edit_pro'); ?></p>
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('Enable Comment Editor', 'wp_edit_pro'); ?></td>
						<td>
						<input id="enable_comment_editor" type="checkbox" value="1" name="enable_comment_editor" <?php echo $enable_comment_editor; ?> />
						<label for="enable_comment_editor"><?php _e('Enables comment editor replacement.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					<tr><td><?php _e('Enable "Add Media" Button', 'wp_edit_pro'); ?></td>
						<td>
						<input id="enable_add_media" type="checkbox" value="1" name="enable_add_media" <?php echo $enable_add_media; ?> />
						<label for="enable_add_media"><?php _e('Enables the "Add Media" button just above comment editor.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<input type="submit" value="<?php _e('Save Posts/Pages Options', 'wp_edit_pro'); ?>" class="button button-primary" id="submit_posts" name="submit_posts">
		</form>
        
    </div>
    <?php
}


/*
****************************************************************
Editor Tab
****************************************************************
*/
if($active_tab == 'editor'){
	
	$editor_toggle_toolbar = isset($plugin_opts['wp_edit_pro_editor']['editor_toggle_toolbar']) && $plugin_opts['wp_edit_pro_editor']['editor_toggle_toolbar'] === '1' ? 'checked="checked"' : '';
	$editor_menu_bar = isset($plugin_opts['wp_edit_pro_editor']['editor_menu_bar']) && $plugin_opts['wp_edit_pro_editor']['editor_menu_bar'] === '1' ? 'checked="checked"' : '';
	$default_editor_fontsize_type = isset($plugin_opts['wp_edit_pro_editor']['default_editor_fontsize_type']) ? $plugin_opts['wp_edit_pro_editor']['default_editor_fontsize_type'] : 'pt';
	$default_editor_fontsize_values = isset($plugin_opts['wp_edit_pro_editor']['default_editor_fontsize_values']) ? $plugin_opts['wp_edit_pro_editor']['default_editor_fontsize_values'] : '';
	$editor_custom_colors = isset($plugin_opts['wp_edit_pro_editor']['editor_custom_colors']) ? $plugin_opts['wp_edit_pro_editor']['editor_custom_colors'] : array();
	
	$dropbox_app_key = isset($plugin_opts['wp_edit_pro_editor']['dropbox_app_key']) ? $plugin_opts['wp_edit_pro_editor']['dropbox_app_key'] : '';
	
	
	$disable_wpep_posts = isset($plugin_opts['wp_edit_pro_editor']['disable_wpep_posts']) && $plugin_opts['wp_edit_pro_editor']['disable_wpep_posts'] === '1' ? 'checked="checked"' : '';
	$disable_wpep_pages = isset($plugin_opts['wp_edit_pro_editor']['disable_wpep_pages']) && $plugin_opts['wp_edit_pro_editor']['disable_wpep_pages'] === '1' ? 'checked="checked"' : '';
	?>
	
	<div class="main_container">
		
		<h2><?php _e('Editor Options', 'wp_edit_pro'); ?></h2>
		<p><?php _e('These options will adjust various aspects of the TinyMCE editor.', 'wp_edit_pro'); ?></p>
		
		<form method="post" action="">
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><span><?php _e('Toggle Toolbar','wp_edit_pro'); ?></span></h3>
			
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('Force Toggle Toolbar', 'wp_edit_pro'); ?></td>
						<td>
						<input id="editor_toggle_toolbar" type="checkbox" value="1" name="editor_toggle_toolbar" <?php echo $editor_toggle_toolbar; ?> />
						<label for="editor_toggle_toolbar"><?php _e('Force the Toggle Toolbar button to "enabled" on page load.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
                    </tbody>
                    </table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
                	<h3><span><?php _e('Menu Bar and Context Menu','wp_edit_pro'); ?></span></h3>
                	
                    <table cellpadding="8">
                    <tbody>
					<tr><td><?php _e('Enable Menu Bar', 'wp_edit_pro'); ?></td>
						<td>
						<input type="checkbox" id="menu_bar" name="editor_menu_bar" <?php echo $editor_menu_bar; ?> />
						<label for="editor_menu_bar"><?php _e('Adds a menubar to the editor; providing shortcuts to commonly used buttons.', 'wp_edit_pro'); ?></label>
						</td>
					</tr>
                    </tbody>
                    </table>
				</div>
			</div>
		</div> 
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
                	<h3><span><?php _e('Font Types and Sizes','wp_edit_pro'); ?></span></h3>
                	
                    <table cellpadding="8">
                    <tbody>
					<tr><td><?php _e('Dropdown Editor Font-Size Type', 'wp_edit_langs'); ?></td>
						<td>
						<input type="radio" name="default_editor_fontsize_type" value="px" <?php if($default_editor_fontsize_type === 'px') echo 'checked="checked"'; ?> /> <?php _e('px', 'wp_edit_langs'); ?><span style="margin-left:10px;"></span>
						<input type="radio" name="default_editor_fontsize_type" value="pt" <?php if($default_editor_fontsize_type === 'pt') echo 'checked="checked"'; ?> /> <?php _e('pt', 'wp_edit_langs'); ?><span style="margin-left:10px;"></span>
						<input type="radio" name="default_editor_fontsize_type" value="em" <?php if($default_editor_fontsize_type === 'em') echo 'checked="checked"'; ?> /> <?php _e('em', 'wp_edit_langs'); ?><span style="margin-left:10px;"></span>
						<input type="radio" name="default_editor_fontsize_type" value="percent" <?php if($default_editor_fontsize_type === 'percent') echo 'checked="checked"'; ?> /> <?php _e('%', 'wp_edit_langs'); ?><br />
							
						<?php _e('Select the editor font size type displayed in the "Font Size" button dropdown menu.', 'wp_edit_langs'); ?>
						</td>
					</tr>
					<tr><td style="vertical-align:top;"><?php _e('Dropdown Editor Font-Size Type Values', 'wp_edit_langs'); ?></td>
						<td>
						<input type="text" name="default_editor_fontsize_values" value="<?php echo $default_editor_fontsize_values; ?>" /><br />
						<?php _e('Define available font-size values for Font Size dropdown box.', 'wp_edit_langs'); ?><br />
						<?php _e('Values should be space separated; and end with the chosen font size type (selected above).', 'wp_edit_langs'); ?><br />
						<?php _e('For Example: If <strong>em</strong> is selected; possible values could be <strong>1em 1.1em 1.2em</strong> etc.', 'wp_edit_langs'); ?>
						</td>
					</tr>
                    </tbody>
                    </table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
                	<h3><span><?php _e('Custom Colors','wp_edit_pro'); ?></span></h3>
                	
                    <table cellpadding="8">
                    <tbody>
					<tr><td><?php _e('Editor Custom Colors', 'wp_edit_pro'); ?></td>
						<td>
                        <div class="custom_color_repeater_fields">
                        	<?php
							if(!empty($editor_custom_colors)) {
								$count = 0;
								foreach($editor_custom_colors as $key => $value) {
									$count = $count + 1;
									?>
									<strong><?php _e('Hex Value:', 'wp_edit_pro'); ?></strong> 
                                    <input type="text" class="editor_custom_colors" name="editor_custom_colors[<?php echo $count; ?>][]" value="<?php echo $value[0]; ?>" style="margin-right:20px;" />
                                    
									<strong><?php _e('Color Name:', 'wp_edit_pro'); ?></strong> 
                                    <input type="text" class="editor_custom_colors" name="editor_custom_colors[<?php echo $count; ?>][]" value="<?php echo $value[1]; ?>" style="margin-right:20px;" />
                                    
									<?php
									if($count === 1) {
										?><input type="button" class="button-secondary" name="custom_color_add_new_row" id="custom_color_add_new_row" value="<?php _e('Add New Row', 'wp_edit_pro'); ?>" /><br /><?php
									}
									else {
										echo '<br />';
									}
								}
							}
							else {
								?>
                            	<strong><?php _e('Hex Value:', 'wp_edit_pro'); ?></strong> <input type="text" class="editor_custom_colors" name="editor_custom_colors[1][]" value="" style="margin-right:20px;" />
                            	<strong><?php _e('Color Name:', 'wp_edit_pro'); ?></strong> <input type="text" class="editor_custom_colors" name="editor_custom_colors[1][]" value="" style="margin-right:20px;" />
                            	<input type="button" class="button-secondary" name="custom_color_add_new_row" id="custom_color_add_new_row" value="<?php _e('Add New Row', 'wp_edit_pro'); ?>" /><br />
                                <?php
							}
							?>
                        </div>
						<?php _e('A valid hex number (no hash sign) and color name must be entered for each custom color.', 'wp_edit_langs'); ?><br />
						<?php _e('Note: These colors only apply to the palette used in foreground and background selections.', 'wp_edit_langs'); ?><br />
						<em>(<?php _e('To delete a custom color; just leave the values blank, and save.', 'wp_edit_langs'); ?>)</em><br />
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><span><?php _e('Dropbox Settings','wp_edit_pro'); ?></span></h3>
			
					<p><?php _e('To use Dropbox, an app will first need to be created.  This is a very easy process, and should only take a few minutes.','wp_edit_pro'); ?><br />
					<?php _e('The app will be used to link the Dropbox account to the website; and allow the two to communicate.','wp_edit_pro'); ?></p>
					<table cellpadding="8">
					<tbody>
					<tr><td style="vertical-align:top;"><?php _e('Dropbox App Key', 'wp_edit_pro'); ?></td>
						<td><input type="text" name="dropbox_app_key" value="<?php echo $dropbox_app_key; ?>" /><br />
						<?php _e('The app key from the Dropbox app screen.', 'wp_edit_pro'); ?><br />
						<a target="_blank" href="http://learn.wpeditpro.com/dropbox-create-web-application/"><?php _e('Create Dropbox App Tutorial', 'wp_edit_pro'); ?></a></td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><span><?php _e('Disable Editor','wp_edit_pro'); ?></span></h3>
			
					<p><?php _e('The following options will disable the WP Edit Pro editor; resulting in the standard editor being displayed.','wp_edit_pro'); ?></p>
					<table cellpadding="8">
					<tbody>
					<tr>
                    	<td>
                    	<input type="checkbox" id="disable_wpep_posts" name="disable_wpep_posts" <?php echo $disable_wpep_posts; ?> />
						<label for="disable_wpep_posts"><?php _e('Disable WP Edit Pro on posts.', 'wp_edit_pro'); ?></label>
                    	</td>
					</tr>
					<tr>
                    	<td>
                    	<input type="checkbox" id="disable_wpep_pages" name="disable_wpep_pages" <?php echo $disable_wpep_pages; ?> />
						<label for="disable_wpep_pages"><?php _e('Disable WP Edit Pro on pages.', 'wp_edit_pro'); ?></label>
                    	</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<input type="submit" value="<?php _e('Save Editor Options', 'wp_edit_pro'); ?>" class="button button-primary" id="submit_editor" name="submit_editor">
		</form>
    </div>
	<?php
}


/*
****************************************************************
Fonts Tab
****************************************************************
*/
if($active_tab == 'fonts') {
	
	$enable_google_fonts = isset($plugin_opts['wp_edit_pro_fonts']['enable_google_fonts']) && $plugin_opts['wp_edit_pro_fonts']['enable_google_fonts'] === '1' ? 'checked="checked"' : '';
	$save_google_fonts = isset($plugin_opts['wp_edit_pro_fonts']['save_google_fonts'])  ? $plugin_opts['wp_edit_pro_fonts']['save_google_fonts'] : '';
	
	echo '<div class="main_container">';
		?>
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
			
					<h2><?php _e('Google Fonts', 'wp_edit_pro'); ?></h2>
					<p><?php _e('Use any Google font(s) in the editor.  Be sure the "Font Family" button is added to the editor.', 'wp_edit_pro'); ?></p>
					
					<form method="post" action="">
					<?php _e('Activate Google Fonts', 'wp_edit_pro'); ?> <input id="enable_google_fonts" type="checkbox" value="1" name="enable_google_fonts" <?php echo $enable_google_fonts; ?> />
					<span style="margin-left:10px;"></span>
					<?php _e('Turns on/off Google Webfonts.', 'wp_edit_pro'); ?>
					
					<br /><br />
					<div class="metabox-holder"> 
						<div class="postbox">
							<div class="inside">
                            
								<h3><span><?php _e('Build Font List','wp_edit_pro'); ?></span></h3>
						
								<?php
								_e('<strong>Step 1:</strong> Visit <a target="_blank" href="http://www.google.com/fonts">Google Webfonts</a> to see how fonts are displayed in the browser.','wp_edit_pro'); 
								echo '<br />';
								_e('<strong>Step 2:</strong> Once desired fonts are selected, choose them (one at a time) from the dropdown list below (sorted alphabetically).','wp_edit_pro'); 
								echo '<br /><br />';
								
								
								// Get full font list from google api
								$google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDFQ7lednDw4HDGay68VSctbHg9HuFLo9U';
								$response = wp_remote_get($google_api_url);
							 	
								$data = array();
								if (is_wp_error($response)) {
									
									$error_string = $response->get_error_message();
   									echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
								}
								else {
									
									$json_fonts = json_decode($response['body'], true);
									
									$items = $json_fonts['items'];
									$str = '';
									
									//Build font dropdown list
									echo '<select id="google_dropdown">';
									_e( '<option value="">Select font...</option>', 'wp_edit_pro' );
									foreach ($items as $item) {
										
										$str = $item['family'];
										echo '<option value="'.$str.'">'.$str.'</option>';
									}
									echo '</select>';
								}	
								echo '<br /><br />';
								
								_e('<strong>Note:</strong> As fonts are selected, they will appear in the "Active Fonts" section below.','wp_edit_pro'); 
								?>
							</div>
						</div>
					</div>
					
					<div class="metabox-holder"> 
						<div class="postbox">
							<div class="inside">
                            
								<h3><span><?php _e('Active Fonts','wp_edit_pro'); ?></span></h3>
						
								<?php
								echo '<div id="google_fonts">';
									
									echo '<div id="active_font_list">';
									
										echo '<span class="google_active_font_title">';
										_e('Current Font List','wp_edit_pro');
										echo '</span>';
										echo '<div id="google_fonts_placeholder"><ul>';
										
											// This is our hidden li element area
											if(is_array($save_google_fonts)) {
												
												foreach ($save_google_fonts as $font) {
													
													echo '<li class="active_font"><input type="hidden" name="save_google_fonts['.$font.']" value="'.$font.'" />'.$font.'</li>';
												}
											}
										echo '</ul></div>';
									echo '</div>';
									
									
									echo '<div id="google_fonts_trashbin">';
										
										echo '<span class="google_active_font_title">';
										_e('Trash Bin','wp_edit_pro');
										echo '</span>';
										echo '<div id="trash_bin_wrapper">';
											echo '<div><span id="google_font_trash"></span><br />';
											_e('Drag fonts here to delete...','wp_edit_pro');
											echo '</div>';
										echo '</div>';
									echo '</div>';
									
									echo '<div style="clear:both;"></div><br /><br />';
									
								echo '</div>';
								echo '<br />';
								_e('Remember to save the options when finished.','wp_edit_pro'); 
							?>
							</div>
						</div>
					</div>
					<?php echo '<input type="submit" value="Save Google Font Options" class="button button-primary" id="submit_fonts_new" name="submit_fonts">'; ?>
					</form>
				</div>
			</div>
		</div>
        
        <div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
                	<h2><?php _e('Custom Fonts', 'wp_edit_pro'); ?></h2>
					<p>
						<?php _e('Upload custom fonts for use in the editor.', 'wp_edit_pro'); ?><br />
                        <?php _e('To ensure maximum browser compatibility, please first convert the font before uploading.', 'wp_edit_pro'); ?>
                    </p>
                    <p>
						<strong><?php _e('1. Convert the font.', 'wp_edit_pro'); ?></strong><br />
                        <?php _e('Use a service like <a href="http://www.fontsquirrel.com/tools/webfont-generator" target="_blank">Font Squirrel</a> to convert the font for the web.', 'wp_edit_pro'); ?>
                        <br /><br />
                        
						<strong><?php _e('2. Upload the files.', 'wp_edit_pro'); ?></strong><br />
                        <?php _e('Take the new files created by Font Squirel; and upload them below.', 'wp_edit_pro'); ?><br />
                        <?php _e('For each font; five files will be needed. Upload the files ending in .eot, .svg, .ttf, .woff, and .woff2.', 'wp_edit_pro'); ?><br />
                        <?php _e('NOTE: It is suggested to rename the font files to easy-to-understand names (e.g. "PrettyFont.ttf") without any spaces.', 'wp_edit_pro'); ?><br /><br />
                    </p>
                    
                    <div class="metabox-holder"> 
						<div class="postbox">
							<div class="inside">
                            
								<h3><span><?php _e('Upload Fonts','wp_edit_pro'); ?></span></h3>
						
                            	<form method="post" action="" enctype="multipart/form-data">
                                	Upload Files: <input name="filesToUpload[]" id="filesToUpload" type="file" multiple="" onChange="makeFileList();" /><br />
                                	<ul id="fileList"><li>No Files Selected</li></ul>
                                    <br /><br />
                                    <input type="submit" value="Save Custom Font Options" class="button button-primary" id="submit_fonts_custom" name="submit_fonts_custom">
                                </form>
                            </div>
                        </div>
                        
                        <div class="postbox">
							<div class="inside">
                            
								<h3><span><?php _e('Uploaded Fonts','wp_edit_pro'); ?></span></h3>
								<p><?php _e('A list of all currently uploaded and active fonts.', 'wp_edit_pro'); ?></p>
                                
                                <?php
								//$blog_id = get_current_blog_id();
								$blog_id = $this->network_blog_id ? $this->network_blog_id : '';
					
								// Have to check which subsite we are on (1 = main site or network site 1)
								if( $blog_id == '' || $blog_id == '1' ) {
									
									$upload_dir = wp_upload_dir();
									$upload_path = $upload_dir['basedir'];
									$handle = $upload_path . '/wp_edit_pro/custom_fonts/';
								}
								else {
									
									$upload_dir = wp_upload_dir();
									$upload_path = $upload_dir['basedir'];
									$handle = $upload_path . '/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/';
								}
								
								// Build array of all font filenames
								$font_array = array();
								$chk_array = array('.', '..', 'stylesheet');
								if (is_dir($handle)) {
									if ($dh = opendir($handle)) {
										while (($file = readdir($dh)) !== false) {
											
											if(!in_array($file, $chk_array)) 
												array_push($font_array, $file);
										}
										closedir($dh);
									}
								}
								
								// Loop fonts and create array with font name values
								$new_array = array();
								foreach($font_array as $key => $value) {
									
									$explode = explode('.', $value);
									$filename = $explode[0];
									
									if(!array_key_exists($filename, $new_array)) {
										$new_array[$filename] = (array)$value;
									}
									else {
										array_push($new_array[$filename], $value);
									}
								}
								
								// Display fonts to user
								echo '<table class="table table-bordered">';
								echo '<thead';
									echo '<th>';
										echo '<td><strong>Font Name</strong></td>';
										echo '<td><strong>Font Types</strong></td>';
										echo '<td><strong>Action</strong></td>';
									echo '</th>';
								echo '</thead>';
								echo '<tbody>';
									
									// If there are fonts to display
									if(isset($new_array) && !empty($new_array)) {
										
										// Create check array for font extensions
										$chk_array = array('eot', 'svg', 'ttf', 'woff', 'woff2');
										
										// Loop each font
										foreach($new_array as $name => $fonts) {
											
											// Create hold array for later comparison
											$hold_array = array();
											
											echo '<tr>';
											echo '<td>' . $name . '</td>';
											echo '<td>';
											
											foreach($fonts as $key => $font) {
												
												// Create hold array
												$explode = explode('.', $font);
												$ext = $explode[1];
												array_push($hold_array, $ext);
												
												// Print font name
												echo $font . '<br />';
											}
											
											// Check if there is an array difference
											$array_diff = array_diff($chk_array, $hold_array);
											
											// If difference, build string
											$string = '';
											if(!empty($array_diff)) {
												
												// Build string from array
												foreach($array_diff as $key => $value) {
													
													$string .= '.' . $value . ', ';
												}
												$trimmed = rtrim($string, ', ');
											}
											
											// If missing extensions (string found from array diff)
											if($string !== '') {
												
												echo '<p class="custom_style_all_error">';
													_e('The following font types are missing for this font: ','wp_edit_pro');
													echo '<strong>' . $trimmed . '</strong><br /><br />';
													_e('This font may not display properly in all browsers until the additional font types are uploaded.','wp_edit_pro');
													echo '<br />';
													_e('Please use a webservice like <a href="http://www.fontsquirrel.com/tools/webfont-generator" target="_blank">Font Squirrel</a> to generate the necessary font files; and upload them above.','wp_edit_pro');
												echo '</p>';
											}
											else {
												
												echo '<p class="custom_style_all_success">';
													_e('All required font types for this font have been uploaded and located.','wp_edit_pro');
												echo '</p>';
											}
											
											echo '</td>';
											echo '<td><span class="action_edit delete_custom_font">Delete</span></td>';
											echo '</tr>';
										}
									}
								echo '</tbody>';
								echo '</table>';
								?>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
          </div>
		<?php
	echo '</div>';
}


/*
****************************************************************
Styles Tab
****************************************************************
*/
if($active_tab == 'styles') {
				
	$add_predefined_styles = isset($plugin_opts['wp_edit_pro_styles']['add_predefined_styles']) && $plugin_opts['wp_edit_pro_styles']['add_predefined_styles'] === '1' ? 'checked="checked"' : '';
	$tinymce_custom_css = isset($plugin_opts['wp_edit_pro_styles']['tinymce_custom_css']) ? $plugin_opts['wp_edit_pro_styles']['tinymce_custom_css'] : '';
	$add_class_id_buttons = isset($plugin_opts['wp_edit_pro_styles']['add_class_id_buttons']) && $plugin_opts['wp_edit_pro_styles']['add_class_id_buttons'] === '1' ? 'checked="checked"' : '';
	$add_class_id_buttons_row = isset($plugin_opts['wp_edit_pro_styles']['add_class_id_buttons_row']) ? $plugin_opts['wp_edit_pro_styles']['add_class_id_buttons_row'] : 'row 1';
	?>
	
	<div class="main_container">
    
		<h2><?php _e('Styles','wp_edit_pro'); ?></h2>
		
		<form method="post" action="">
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><span><?php _e('Predefined Styles','wp_edit_pro'); ?></span></h3>
					<p><?php _e('Easily add over 80 pre-written styles. Please ensure the "Formats" button has been added to the toolbar.','wp_edit_pro'); ?></p>
			
					<table cellpadding="8">
					<tbody>
					<tr><td><?php _e('Add Pre-Defined Styles','wp_edit_pro'); ?></td>
						<td>
						<input id="add_predefined_styles" type="checkbox" value="1" name="add_predefined_styles" <?php echo $add_predefined_styles; ?> />
						<label for="add_predefined_styles"><?php _e('Adds styles to the "Formats" dropdown editor button.','wp_edit_pro'); ?></label>
						</td>
					</tr>
					</tbody>
					</table>
					<br />
					<input type="submit" value="<?php _e('Save Predefined Styles','wp_edit_pro'); ?>" class="button button-primary" id="save_predefined_styles_opts" name="save_predefined_styles_opts" />
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
            	<div class="inside">
                
            	<h3 id="custom_styles_header"><?php _e('Custom Styles','wp_edit_pro'); ?></h3>
            	<p><?php _e('Read our <a target="_blank" href="http://learn.wpeditpro.com/custom-styles/">Custom Styles Knowledge Base Article</a> for assistance creating custom styles.','wp_edit_pro'); ?></p>
                
				<h4><?php _e('Create or Edit a custom style.','wp_edit_pro'); ?></h4>
			
				<div id="new_style_form" class="inside">
				
					<div id="float_table_left">
					
						<span<?php _e('>Use the form below to create unique custom styles.','wp_edit_pro'); ?></span>
						<br /><br />
						
						<strong><?php _e('Title:','wp_edit_pro'); ?></strong><br />
						<em><?php _e('Title which appears in dropdown box.','wp_edit_pro'); ?></em><br />
						<input id="create_style_title" type="text" value="" name="create_style_title" /><br /><br />
						<strong><?php _e('Type:','wp_edit_pro'); ?></strong><br />
						<em><?php _e('Choose which type of style to create.','wp_edit_pro'); ?></em><br />
						<input id="create_style_type_inline" class="create_style_type" type="radio" name="create_style_type" value="inline" /><?php _e('inline','wp_edit_pro'); ?>
						<input id="create_style_type_block" class="create_style_type" type="radio" name="create_style_type" value="block" /><?php _e('block','wp_edit_pro'); ?>
						<input id="create_style_type_selector" class="create_style_type" type="radio" name="create_style_type" value="selector" /><?php _e('selector','wp_edit_pro'); ?><br /><br />
						<strong><?php _e('Element:','wp_edit_pro'); ?></strong><br />
						<em><?php _e('Choose which type of element this style applies to.','wp_edit_pro'); ?></em><br />
						<span id="type_element"></span><br /><br />
						<strong><?php _e('Classes:','wp_edit_pro'); ?></strong><br />
						<em><?php _e('Space separated list of class names (optional).','wp_edit_pro'); ?></em><br />
						<input id="create_style_classes" type="text" value="" name="create_style_classes" /><br /><br />
						<strong><?php _e('Styles:','wp_edit_pro'); ?></strong><br />
						<em><?php _e('CSS style items to apply (optional).','wp_edit_pro'); ?></em><br />
						<input id="create_style_styles" type="text" value="" name="create_style_styles" /><br /><br />
						<strong><?php _e('Wrapper:','wp_edit_pro'); ?></strong><br />
						<em><?php _e('Wrap selection in a block element.','wp_edit_pro'); ?></em><br />
						<input id="create_style_wrapper_false" type="radio" name="create_style_wrapper" value="false" /><?php _e('false','wp_edit_pro'); ?>
						<input id="create_style_wrapper_true" type="radio" name="create_style_wrapper" value="true" /><?php _e('true','wp_edit_pro'); ?>
					</div>
					
					<div id="float_table_info_left">
					
						<span><strong><?php _e('Custom Styles Instructions:','wp_edit_pro'); ?></strong></span>
						<br /><br />
						<strong><?php _e('Step 1:','wp_edit_pro'); ?></strong> <?php _e('Enter a title for the new style.  The title will appear in the "Formats" dropdown editor button.','wp_edit_pro'); ?><br /><br />
						<strong><?php _e('Step 2:','wp_edit_pro'); ?></strong> <?php _e('Select a type.  The type of element which will contain the custom style.','wp_edit_pro'); ?><br /><br />
						<strong><?php _e('Step 3:','wp_edit_pro'); ?></strong> <?php _e('Select an element.  The specific element which will contain the custom style.','wp_edit_pro'); ?><br /><br />
						<strong><?php _e('Step 4:','wp_edit_pro'); ?></strong> <?php _e('Enter a spaced separated list of class names.  These can be class names available in any tinymce editor stylesheet.','wp_edit_pro'); ?><br /><br />
						<strong><?php _e('Step 5:','wp_edit_pro'); ?></strong> <?php _e('Enter styles. Should be entered as <strong><em>name: value; name: value;</em></strong> <em>etc...</em>','wp_edit_pro'); ?><br /><br />
						<strong><?php _e('Step 6:','wp_edit_pro'); ?></strong> <?php _e('Wrapper. If true, will wrap the element in a block level div element.','wp_edit_pro'); ?>
						<br /><br />
						
						<strong><?php _e('Notes:','wp_edit_pro'); ?></strong>
						<br /><br />
						<?php _e('If "Styles" are entered into the option... then the styles will be applied "inline" inside the editor content.  This means the styles will appear correctly when viewed from the front-end of the website.','wp_edit_pro'); ?>
						<br /><br />
						<?php _e('However, if "Classes" are used instead.. then these class names must be available BOTH in the editor stylesheet AND on the front-end stylesheet (either in the theme, or a custom css plugin).','wp_edit_pro'); ?>
						<br /><br />
						<?php _e('More help can be found at the <a target="_blank" href="http://www.tinymce.com/wiki.php/Configuration:formats">TinyMCE Formats</a> webpage.','wp_edit_pro'); ?>
					</div>
					
					<div style="clear:both"></div>
					<br /><br />
				  
					<input type="submit" value="<?php _e('Save Custom Style','wp_edit_pro'); ?>" class="button button-primary" id="save_custom_style" name="save_custom_style" />
					<input type="button" value="<?php _e('Cancel/Clear Form','wp_edit_pro'); ?>" class="button button-secondary" id="clear_form" name="clear_form" />
					<input type="submit" id="hidden_save_style_submit" name="hidden_save_style_submit" style="display:none;" />
				</div>
			</div>
		</div>
					  
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><span><?php _e('Created Styles','wp_edit_pro'); ?></span></h3>
					<p><?php _e('These styles will appear in the "Formats" editor dropdown in the "Custom Styles" sub-menu.','wp_edit_pro'); ?></p>
			
					<table class="widefat" id="saved_user_styles">
					<thead>
						<tr>
							<th><?php _e('Title','wp_edit_pro'); ?></th>
							<th><?php _e('Type','wp_edit_pro'); ?></th>   
							<th><?php _e('Element','wp_edit_pro'); ?></th>    
							<th><?php _e('Classes','wp_edit_pro'); ?></th> 
							<th><?php _e('Styles','wp_edit_pro'); ?></th>
							<th><?php _e('Wrapper','wp_edit_pro'); ?></th>
							<th><?php _e('Action','wp_edit_pro'); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><?php _e('Title','wp_edit_pro'); ?></th>
							<th><?php _e('Type','wp_edit_pro'); ?></th>
							<th><?php _e('Element','wp_edit_pro'); ?></th> 
							<th><?php _e('Classes','wp_edit_pro'); ?></th>
							<th><?php _e('Styles','wp_edit_pro'); ?></th>
							<th><?php _e('Wrapper','wp_edit_pro'); ?></th>
							<th><?php _e('Action','wp_edit_pro'); ?></th>
						</tr>
					</tfoot>
					<tbody>
					
						<?php
						if($plugin_opts['wp_edit_pro_styles']['custom_styles']) {
							
							asort($plugin_opts['wp_edit_pro_styles']['custom_styles']);
							foreach ($plugin_opts['wp_edit_pro_styles']['custom_styles'] as $style) {
								
								echo '<tr>';
								foreach ($style as $key => $value) {
									
									echo '<td>'.$value.'</td>';
								}
								echo '<td><span class="action_edit edit_style">';
								_e('Edit','wp_edit_pro');
								echo '</span><span class="action_edit delete_style">';
								_e('Delete','wp_edit_pro');
								echo '</span></td></tr>';
							}
						}
						
						?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder"> 
			<div class="postbox">
				<div class="inside">
                
					<h3><?php _e('Editor Stylesheet','wp_edit_pro'); ?></h3>
					<p><?php _e('Any custom css added to the stylesheet below will be used inside the content editor. (Be sure to empty browser cache after changes)','wp_edit_pro'); ?><br />
					<em><?php _e('Hint: Target the entire editor with "body { ... }"','wp_edit_pro'); ?></em></p>
			
                    <div id="custom_css_container">
                        <div name="custom_css" id="custom_css" style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 100%; height: 400px; position: relative;"></div>
                    </div>
         
                    <textarea id="custom_css_textarea" name="custom_css" style="display: none;"><?php echo $tinymce_custom_css; ?></textarea><br />
                    <input type="hidden" id="css_parser_output" name="css_parser_output" value="" /><br />
                    <input id="save_custom_css_textarea" name="save_custom_css_textarea" type="submit" class="button-primary" value="<?php _e('Save Editor Stylesheet','wp_edit_pro') ?>" />
				
				</div>
			</div>
		</div>
		</form>
    </div>
	<?php
}


/*
****************************************************************
Snidgets Tab
****************************************************************
*/
if($active_tab == 'widgets') {
	
	echo '<div class="main_container">';
		?>
		<h3><?php _e('Snidget Options','wp_edit_pro'); ?></h3>
		
		<?php
		
		$disabled = '';
		$widget_builder = isset( $plugin_opts['wp_edit_pro_widgets']['widget_builder']) && $plugin_opts['wp_edit_pro_widgets']['widget_builder'] === '1' ? 'checked="checked"' : '';
		
		echo '<p>';
			_e('These options specifically affect how snidgets are handled.','wp_edit_pro');
		echo '</p>';
		?>
		
		<div class="metabox-holder"> 
			<div class="postbox">
			<h3><span><?php _e('Snidgets','wp_edit_pro'); ?></span></h3>
			
				<div class="inside">
					<form method="post" action="">
					<table cellpadding="8">
					<tbody>
					
					<tr><td><?php _e('Snidget Builder','wp_edit_pro'); ?></td>
						<td>
						<input id="widget_builder" type="checkbox" value="1" name="widget_builder" <?php echo $widget_builder.' '.$disabled; ?> />
						<label for="widget_builder"><?php _e('Enables the powerful snidget builder.','wp_edit_pro'); ?></label>
						</td>
					</tr>
					</tbody>
					</table>
					
					<hr />
					<p><?php _e('Allow other user roles to access snidgets administration.', 'wp_edit_pro'); ?></p>
					<div class="grid_row">
					
						<?php
						if($this->network_blog_id !== '') {
							switch_to_blog($this->network_blog_id);
							$roles = get_editable_roles();
							restore_current_blog();
						}
						else {
							$roles = get_editable_roles();
						}
						
						// Remove administrator role if not network activated
						if( $this->network_activated == false )
							unset( $roles['administrator'] );
						
						// Build array of selected roles
						$selected_roles = array();
						if(!empty($plugin_opts['wp_edit_pro_widgets']['wpep_select_user_meta_roles_snidgets'])) {
							foreach($plugin_opts['wp_edit_pro_widgets']['wpep_select_user_meta_roles_snidgets'] as $this_key => $this_value) {
								$selected_roles[] = $this_value;
							}
						}
							
						foreach($roles as $key => $value) {
							$selected = in_array($key, $selected_roles) ? 'checked="checked"' : '';
							echo '<div class="col-1-4"><input type="checkbox" name="wpep_select_user_meta_roles_snidgets['.$key.']" value="'.$key.'" '.$selected.'> '.$key.'</div>';
						}
						
						echo '<div class="clear"></div>';
						?>
					</div><!-- /.row -->
					
					<input type="submit" value="<?php _e('Save Snidget Options','wp_edit_pro'); ?>" class="button button-primary" id="submit_widgets" name="submit_widgets">
					</form>
				</div>
			</div>
		</div>
		
		<h3><?php _e('Current Snidgets','wp_edit_pro'); ?></h3>
		
		<div id="snidgets_deactivated_message" style="display:none;">
        
			<p><?php _e('Snidgets are currently deactivated. Please enable snidgets using the checkbox above.','wp_edit_pro'); ?></p>
		</div>
		
		<div id="snidgets_active_message_table" style="display:none;">
        
			<p><?php _e('This table will list all current snidgets. Use the links for quick access to edit a snidget.','wp_edit_pro'); ?><br />
			<?php _e('You may also visit any subsite to administer snidgets; new menu items will be added.','wp_edit_pro'); ?></p>
			
			<?php
			
			if( $this->network_activated == true && $this->network_blog_id == '' ) {
				
				$blog_ids = array();
				
				// Version compare (wp_get_sites() deprecated)
				if( $this->wp_version < '4.6.0' ) {
					
					// Use old wp_get_sites() function
					$get_sites = wp_get_sites();
					foreach( $get_sites as $key => $value ) {
						
						$blog_details = get_blog_details( $value['blog_id'] );
						$site_name = $blog_details->blogname;
						
						array_push($blog_ids, array( 'id' => $value['blog_id'], 'site_name' => $site_name ) );
					}
				}
				else {
					
					// Use new get_sites() function
					$get_sites = get_sites();
					foreach( $get_sites as $key => $value ) {
						
						$blog_details = get_blog_details( $value->blog_id );
						$site_name = $blog_details->blogname;
						
						array_push($blog_ids, array( 'id' => $value->blog_id, 'site_name' => $site_name ) );
					}
				}
				
				
				foreach( $blog_ids as $key => $value ) {
					
					switch_to_blog( $value['id'] );
					
					?>
					<div class="metabox-holder"> 
						<div class="postbox">
							<div class="inside">
					
                    			<?php
								echo '<h4 class="snidget_blog_heading">Site Name: ' . $value['site_name'] . '</h4>';
								new wpeditpro_snidgets_table();
								
								?>
								<form method="post" action="">
								
									<input type="submit" class="button-secondary" value="All Snidgets" name="submit_all_widgets" id="submit_all_widgets_helper" />
									<input type="submit" class="button-secondary" value="All Snidgets" name="submit_all_widgets" id="submit_all_widgets" style="display:none;" />
									
									<input type="submit" class="button-secondary" value="Add New Snidget" name="submit_new_widget" id="submit_new_widget_helper" />
									<input type="submit" class="button-secondary" value="Add New Snidget" name="submit_new_widget" id="submit_new_widget" style="display:none;" />
									
									<input type="submit" class="button-secondary" value="Snidget Categories" name="submit_widget_categories" id="submit_widget_categories_helper" />
									<input type="submit" class="button-secondary" value="Snidget Categories" name="submit_widget_categories" id="submit_widget_categories" style="display:none;" />
									
									<input type="submit" class="button-secondary" value="Snidget Tags" name="submit_widget_tags" id="submit_widget_tags_helper" />
									<input type="submit" class="button-secondary" value="Snidget Tags" name="submit_widget_tags" id="submit_widget_tags" style="display:none;" />
                                    
                                    <input type="hidden" name="each_blog_id" value="<?php echo $value['id']; ?>" />
								</form>
                                
                            </div>
                        </div>
                    </div>
                    <?php
				}
				
				restore_current_blog();
			}
			else {
			
				// Create table
				new wpeditpro_snidgets_table();
				
				?>
                
                <form method="post" action="">
                
                    <input type="submit" class="button-secondary" value="All Snidgets" name="submit_all_widgets" id="submit_all_widgets_helper" />
                    <input type="submit" class="button-secondary" value="All Snidgets" name="submit_all_widgets" id="submit_all_widgets" style="display:none;" />
                    
                    <input type="submit" class="button-secondary" value="Add New Snidget" name="submit_new_widget" id="submit_new_widget_helper" />
                    <input type="submit" class="button-secondary" value="Add New Snidget" name="submit_new_widget" id="submit_new_widget" style="display:none;" />
                    
                    <input type="submit" class="button-secondary" value="Snidget Categories" name="submit_widget_categories" id="submit_widget_categories_helper" />
                    <input type="submit" class="button-secondary" value="Snidget Categories" name="submit_widget_categories" id="submit_widget_categories" style="display:none;" />
                    
                    <input type="submit" class="button-secondary" value="Snidget Tags" name="submit_widget_tags" id="submit_widget_tags_helper" />
                    <input type="submit" class="button-secondary" value="Snidget Tags" name="submit_widget_tags" id="submit_widget_tags" style="display:none;" />
                </form>
                <?php
			}
			?>
		</div>
		<?php
			
	echo '</div>';
}


/*
****************************************************************
User Specific Tab
****************************************************************
*/
if($active_tab == 'user_specific') {

	// Get current user meta
	global $current_user; 
	$options_user_specific_user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
	
	// If selecting a user from dropdown list; get their meta
	if(isset($_POST['wpep_select_user_meta']) && $_POST['wpep_select_user_meta'] !== '') {  // Contains user ID
		$options_user_specific_user_meta = get_user_meta($_POST['wpep_select_user_meta'], 'aaa_wp_edit_pro_user_meta', true);
	}
	
	// If canceling editing a user meta... get current user meta
	if(isset($_POST['wpep_select_user_meta_cancel'])) {
		$options_user_specific_user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
	}
	
	echo '<div class="main_container">';
	
		?>
		
		<h3><?php _e('User Options','wp_edit_pro'); ?></h3>
		<p><?php _e('These options are saved in the user meta table; each admin can set unique options on this page.', ''); ?></p>
        
        <?php 
		if(current_user_can('manage_options')) {
			
			?>
			<form method="post" action="">
            <div class="metabox-holder">
                <div class="postbox">
                    <h3><?php _e('Network User Options', 'wp_edit_pro'); ?></h3>
                    <div class="inside">
                    
                    	<p><?php _e('Switch to a user to edit their settings.', 'wp_edit_pro'); ?></p>
                    	<?php
						if(!isset($_POST['wpep_select_user_meta_cancel']) && isset($_POST['wpep_select_user_meta']) && $_POST['wpep_select_user_meta'] !== '') {
							
							$user = get_user_by('id', $_POST['wpep_select_user_meta']);
							
							echo '<div class="error wpep_info"><p>';
							printf(__('Currently editing user meta for %s.  Cancel editing to return to current user meta.', 'wp_edit_pro'), '<strong>'.$user->data->user_login.'</strong>');
							echo '</p></div>';
						}
						?>
                        <table cellpadding="8">
                        <tbody>
                        <tr><td><?php _e('Select User','wp_edit_pro'); ?></td>
                            <td>
                            <select name="wpep_select_user_meta">
                            <option value=""><?php _e('Select User...','wp_edit_pro'); ?></option>
                            	<?php
								if($this->network_blog_id !== '') {
									switch_to_blog($this->network_blog_id);
									$users = get_users();
									restore_current_blog();
								}
								else {
									$users = get_users();
								}
								foreach($users as $key => $value) {
									$selected = !isset($_POST['wpep_select_user_meta_cancel']) && isset($_POST['wpep_select_user_meta']) && $_POST['wpep_select_user_meta'] === $value->data->ID ? 'selected="selected"' : '';
									echo '<option value="'.$value->data->ID.'" '.$selected.'>'.$value->data->user_login.'</option>';
								}
								?>
                            </select>
                            <span style="margin-right:20px;"></span>
                            <input type="submit" class="button-secondary" name="wpep_select_user_meta_submit" value="<?php _e('Switch to User','wp_edit_pro'); ?>" />
                            <span style="margin-right:20px;"></span>
                            <input type="submit" class="button-secondary" name="wpep_select_user_meta_cancel" value="<?php _e('Cancel Editing User','wp_edit_pro'); ?>" />
                            </td>
                        </tr>
                        </tbody>
                        </table>
                        
                        <hr />
                        <p><?php _e('Allow other user roles to access this user settings page.', 'wp_edit_pro'); ?></p>
                        <div class="grid_row">
                        
							<?php
                            if($this->network_blog_id !== '') {
                                switch_to_blog($this->network_blog_id);
                                $roles = get_editable_roles();
                                restore_current_blog();
                            }
                            else {
                                $roles = get_editable_roles();
                            }
						
							// Remove administrator role if not network activated
							if( $this->network_activated == false )
								unset( $roles['administrator'] );
							
							// Build array of selected roles
							$selected_roles = array();
							if(!empty($plugin_opts['wp_edit_pro_user']['wpep_select_user_meta_roles'])) {
								foreach($plugin_opts['wp_edit_pro_user']['wpep_select_user_meta_roles'] as $this_key => $this_value) {
									$selected_roles[] = $this_value;
								}
							}
								
                            foreach($roles as $key => $value) {
								$selected = in_array($key, $selected_roles) ? 'checked="checked"' : '';
                                echo '<div class="col-1-4"><input type="checkbox" name="wpep_select_user_meta_roles['.$key.']" value="'.$key.'" '.$selected.'> '.$key.'</div>';
                            }
							
							echo '<div class="clear"></div>';
                            ?>
                        </div><!-- /.row -->
                    </div>
                </div>
            </div>
            <?php
		}
		?>
		
		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e('General User Options', 'wp_edit_pro'); ?></h3>
				<div class="inside">
				
					<?php
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
					?>
					
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
				</div>
			</div>
		</div>
		
		
		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e('Post/Page Highlight Colors', 'wp_edit_pro'); ?></h3>
				<div class="inside">	
						
					<p><?php _e('These options will allow each admin to customize highlight colors for each post/page status.','wp_edit_pro'); ?><br />
					<?php _e('Meaning.. saved posts can be yellow, published posts can be blue, etc.','wp_edit_pro'); ?></p>
					
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
				</div>
			</div>
					
			<input type="submit" value="<?php _e('Save User Options','wp_edit_pro'); ?>" class="button button-primary" id="submit_user_specific" name="submit_user_specific">
		</div>
		</form>
	<?php
	echo '</div>';
}


/*
****************************************************************
Extras Tab
****************************************************************
*/
if($active_tab == 'extras')  {
	
	$enable_qr = isset($plugin_opts['wp_edit_pro_extras']['enable_qr']) && $plugin_opts['wp_edit_pro_extras']['enable_qr'] === '1' ? 'checked="checked"' : '';
	$enable_qr_widget = isset($plugin_opts['wp_edit_pro_extras']['enable_qr_widget']) && $plugin_opts['wp_edit_pro_extras']['enable_qr_widget'] === '1' ? 'checked="checked"' : '';
	
	$background_title = isset($plugin_opts['wp_edit_pro_extras']['qr_colors']['background_title']) ? $plugin_opts['wp_edit_pro_extras']['qr_colors']['background_title'] : 'e2e2e2';
	$background_content = isset($plugin_opts['wp_edit_pro_extras']['qr_colors']['background_content'])  ? $plugin_opts['wp_edit_pro_extras']['qr_colors']['background_content'] : 'dee8e4';
	$text_color = isset($plugin_opts['wp_edit_pro_extras']['qr_colors']['text_color'])  ? $plugin_opts['wp_edit_pro_extras']['qr_colors']['text_color'] : '000000';
	$qr_foreground_color = isset($plugin_opts['wp_edit_pro_extras']['qr_colors']['qr_foreground_color'])  ? $plugin_opts['wp_edit_pro_extras']['qr_colors']['qr_foreground_color'] : 'c4d7ed';
	$qr_background_color = isset($plugin_opts['wp_edit_pro_extras']['qr_colors']['qr_background_color'])  ? $plugin_opts['wp_edit_pro_extras']['qr_colors']['qr_background_color'] : '120a23';
	$title_text = isset($plugin_opts['wp_edit_pro_extras']['qr_colors']['title_text'])  ? $plugin_opts['wp_edit_pro_extras']['qr_colors']['title_text'] : 'Enter title here...';
	$content_text = isset($plugin_opts['wp_edit_pro_extras']['qr_colors']['content_text'])  ? $plugin_opts['wp_edit_pro_extras']['qr_colors']['content_text'] : 'Enter content here...';
	?>
    
	<div class="main_container">
		<h2><?php _e('Extra Options','wp_edit_pro'); ?></h2>
		<form method="post" action="">
		
		<div class="metabox-holder">
			<div class="postbox">
				<div class="inside">
			
					<h3><?php _e('Signoff Text', 'wp_edit_pro'); ?></h3>
					<p><?php _e('Use the editor below to create a content chunk that can be inserted anywhere using the <strong>[signoff]</strong> shortcode.','wp_edit_pro'); ?></p>
                    
					<table cellpadding="8" width="100%">
					<tbody>
					<tr><td>
						<?php
						$content = isset($plugin_opts['wp_edit_pro_extras']['signoff_text']) ? $plugin_opts['wp_edit_pro_extras']['signoff_text'] : 'Please enter text here...';
						$editor_id = 'wp_edit_pro_signoff';
						$args = array('textarea_rows' => 5);
						wp_editor( $content, $editor_id, $args );
						?>
					</td></tr>
					</tbody>
					</table>
				</div> <!-- end .inside -->
			</div> <!-- end .postbox -->
		</div> <!-- end .metabox-holder -->
			
		
			
		<div id="block_container_qr_codes" class="metabox-holder">
			<div class="postbox">
				
				<h3><?php _e('QR Codes','wp_edit_pro'); ?></h3>
				<div class="inside">
				
					<p>
						<?php _e('QR Codes will be displayed on each post and page; or in a widget.','wp_edit_pro'); ?><br />
						<?php _e('The image will link back to the post or page where it is displayed.','wp_edit_pro'); ?>
					</p>
					<h3><span><?php _e('Enable QR Code','wp_edit_pro'); ?></span></h3>
					<table cellpadding="8">
						<tbody>
						<tr><td><?php _e('Enable QR Codes','wp_edit_pro'); ?></td>
							<td class="jwl_user_cell">
								<input id="enable_qr" type="checkbox" value="1" name="enable_qr" <?php echo $enable_qr; ?> />
								<label for="enable_qr"><?php _e('A global option which enables all QR Code functionality.','wp_edit_pro'); ?></label>
							</td>
						</tr>
						<tr><td><?php _e('Enable QR Widgets','wp_edit_pro'); ?></td>
							<td class="jwl_user_cell">
								<input id="enable_qr_widget" type="checkbox" value="1" name="enable_qr_widget" <?php echo $enable_qr_widget; ?> />
								<label for="enable_qr_widget"><?php _e('Adds new widget for creating QR codes.','wp_edit_pro'); ?></label>
							</td>
						</tr>
						</tbody>
					</table>
					<br /><br />
						
					<h3><span><?php _e('Design QR Code','wp_edit_pro'); ?></span></h3>
					<div style="width:100%;">
						
						<div>
							<table cellpadding="8">
								<tbody>
								<tr><td><?php _e('Title Background','wp_edit_pro'); ?></td>
									<td class="jwl_user_cell">
									<input id="background_title" type="text" name="qr_colors[background_title]" class="color_field" value="#<?php echo $background_title; ?>" />
									</td>
								</tr>
								<tr><td><?php _e('Content Background','wp_edit_pro'); ?></td>
									<td class="jwl_user_cell">
									<input id="background_content" type="text" name="qr_colors[background_content]" class="color_field" value="#<?php echo $background_content; ?>" />
									</td>
								</tr>
								<tr><td><?php _e('Text Color','wp_edit_pro'); ?></td>
									<td class="jwl_user_cell">
									<input id="text_color" type="text" name="qr_colors[text_color]" class="color_field" value="#<?php echo $text_color; ?>" />
									</td>
								</tr>
								<tr><td><?php _e('QR Foreground Color','wp_edit_pro'); ?></td>
									<td class="jwl_user_cell">
									<input id="qr_foreground_color" type="text" name="qr_colors[qr_foreground_color]" class="color_field" value="#<?php echo $qr_foreground_color; ?>" />
									</td>
								</tr>
								<tr><td><?php _e('QR Background Color','wp_edit_pro'); ?></td>
									<td class="jwl_user_cell">
									<input id="qr_background_color" type="text" name="qr_colors[qr_background_color]" class="color_field" value="#<?php echo $qr_background_color; ?>" />
									</td>
								</tr>
								</tbody>
							</table>
						</div>
							
						<br /><br />
						<div>
							<table cellpadding="3">
								<tbody>
								<tr><td><?php _e('Title Text','wp_edit_pro'); ?></td>
									<td class="jwl_user_cell" style="width:90%;">
									<input id="title_text" type="text" name="qr_colors[title_text]" value="<?php echo $title_text; ?>" />
									</td>
								</tr>
								<tr><td><?php _e('Content','wp_edit_pro'); ?></td>
									<td class="jwl_user_cell" style="width:90%;">
									<textarea id="content_text" type="text" name="qr_colors[content_text]" value="<?php echo $content_text; ?>" style="width:100%;"><?php echo $content_text; ?></textarea>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
							
						<br /><br />
						<h3><span><?php _e('Preview QR Code','wp_edit_pro'); ?></span></h3>
						<p style="margin-left:15px;"><?php _e('This is a preview area. Changes will not be written to the database until the "Save Extras Options" button is clicked.','wp_edit_pro'); ?></p>
						<div id="qr_container" style="max-width:800px;margin-left:15px;">
						
							<div style="border:1px solid #ddd;padding:5px;background-color:#<?php echo $background_title; ?>;">
								<?php _e('Preview! (<em>Click "Save Changes" to update</em>)','wp_edit_pro'); ?>
							</div>
								 
							<div style="display:block;padding:5px;border:1px solid #ddd;background-color:#<?php echo $background_content; ?>;">
								<div style="display:inline-block;">
									<div style="float:left;margin:3px 10px 0 10px;">
										<script type="text/javascript">
										var uri=window.location.href;document.write("<img src=\'//api.qrserver.com/v1/create-qr-code/?data="+encodeURI(uri)+"&size=75x75&color=<?php echo $qr_background_color; ?>&bgcolor=<?php echo $qr_foreground_color; ?>\'/>");
										</script>
									</div>
									<div style="margin-left:10px;color:#<?php echo $text_color; ?>;">
										<?php _e('This is preview text. Use the editor below to create custom text for your posts/pages.','wp_edit_pro'); ?><br /><br />
										<?php _e('It is strongly suggested to use highly contrasting colors for the background and foreground QR colors.','wp_edit_pro'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
			
		<input type="submit" value="<?php _e('Save Extras Options','wp_edit_pro'); ?>" class="button button-primary" id="submit_extras" name="submit_extras">
		</form>
	</div>
	<?php
}


/*
****************************************************************
Database Tab
****************************************************************
*/
if($active_tab == 'database'){
	
	echo '<div class="main_container">';
		?>
		<h2><?php _e('Database Options','wp_edit_pro'); ?></h2>
		
		<div class="metabox-holder">
			<div class="postbox">
				<div class="inside">
                
					<h3><?php _e( 'Reset Options', 'wp_edit_pro' ); ?></h3>
					<p><?php _e( 'Reset all plugin options to their original default values.', 'wp_edit_pro' ); ?></p>
					
					<?php
					$reset_message = __('Reset Options', 'wp_edit_pro');
					
					if( $this->network_activated === true ) {
						
						$reset_message = __( 'Reset Site Options', 'wp_edit_pro' );
					}
					if( $this->network_blog_id !== '' && $this->network_activated === true ) {
						
						$reset_message = sprintf( __( 'Reset Blog ID %s Options', 'wp_edit_pro' ), $this->network_blog_id );
					}
                    ?>
					
					<form method="post" action="">
						<input id="reset_db_values_helper" class="button-secondary" name="reset_db_values_helper" type="submit" value="<?php echo $reset_message; ?>" />
						<input type="submit" name="reset_db_values" id="reset_db_values" style="display:none;" />
                        <?php wp_nonce_field( 'database_action_reset_nonce', 'database_action_reset_nonce' ); ?>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div>
		
		<div class="metabox-holder">
			<div class="postbox">
				<div class="inside">
                
					<h3><?php _e( 'Convert Options', 'wp_edit_pro' ); ?></h3>
					<p><?php _e( 'Convert options from WP Edit to WP Edit Pro.', 'wp_edit_pro' ); ?><br />
					<?php _e( 'Note: Not all options may convert properly. Please double-check options after conversion.', 'wp_edit_pro' ); ?></p>
					
					<?php
					$convert_message = __('Convert Options', 'wp_edit_pro');
					
					if( $this->network_activated === true ) {
						
						$convert_message = __( 'Convert Site Options', 'wp_edit_pro' );
					}
					if( $this->network_blog_id !== '' && $this->network_activated === true ) {
						
						$convert_message = sprintf( __( 'Convert Blog ID %s Options', 'wp_edit_pro' ), $this->network_blog_id );
					}
					?>
					
					<form method="post" action="">
						<input id="convert_db_values_helper" class="button-secondary" name="convert_db_values_helper" type="submit" value="<?php echo $convert_message; ?>" />
						<input type="submit" name="convert_db_values" id="convert_db_values" style="display:none;" />
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div>
		
		<div class="metabox-holder">
			<div class="postbox">
				<div class="inside">
                
					<h3><?php _e('Export Options', 'wp_edit_pro'); ?></h3>
					<p><?php  _e( 'Export the plugin settings for this site as a .json file.', 'wp_edit_pro' ); ?></p>
                    
					 
					<form method="post">
						<p><input type="hidden" name="database_action" value="export_settings" /></p>
						<p>
						<?php 
						$export_message = __('Export Options', 'wp_edit_pro');
						
						if( $this->network_activated === true ) {
							
							$export_message = __( 'Export Site Options', 'wp_edit_pro' );
						}
						if($this->network_blog_id !== '' && $this->network_activated === true ) {
							
							$export_message = sprintf( __( 'Export Blog ID %s Options', 'wp_edit_pro' ), $this->network_blog_id );
						}
						
						wp_nonce_field( 'database_action_export_nonce', 'database_action_export_nonce' ); 
						submit_button( $export_message, 'secondary', 'submit', false ); 
						?>
						</p>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div>
		
		<div class="metabox-holder">
			<div class="postbox">
				<div class="inside">
                
					<h3><?php _e( 'Import Options', 'wp_edit_pro' ); ?></h3>
					<p><?php _e( 'Import the plugin settings from a .json file.', 'wp_edit_pro' ); ?></p>
					 
					<form method="post" enctype="multipart/form-data">
						<p><input type="file" name="import_file"/></p>
						<p>
						<input type="hidden" name="database_action" value="import_settings" />
						<?php 
						$import_message = __('Import Options', 'wp_edit_pro');
						
						if( $this->network_activated === true ) {
							
							$import_message = __( 'Import Site Options', 'wp_edit_pro' );
						}
						if( $this->network_blog_id !== '' && $this->network_activated === true ) {
							
							$import_message = sprintf( __( 'Import Options to Blog ID %s', 'wp_edit_pro' ), $this->network_blog_id );
						}
						wp_nonce_field( 'database_action_import_nonce', 'database_action_import_nonce' );
						submit_button( $import_message, 'secondary', 'submit', false ); 
						?>
						</p>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div>

		<div class="metabox-holder">
			<div class="postbox">
				<div class="inside">
                
					<h3><span><?php _e( 'Uninstall Plugin', 'wp_edit_pro' ); ?></span></h3>
					<p><?php _e( 'Designed by intention, this plugin will not delete the associated database tables when activating and deactivating.', 'wp_edit_pro' ); ?><br />
					   <?php _e( 'This ensures the data is kept safe when troubleshooting other WordPress conflicts.', 'wp_edit_pro' ); ?><br />
					   <?php _e( 'In order to completely uninstall the plugin, AND remove all associated database tables, please use the option below.', 'wp_edit_pro' ); ?><br />
					</p>
					<h4><?php _e('Uninstall and delete all associated database options.', 'wp_edit_pro'); ?></h4>
					
					<?php 
					$uninstall_message = __('Uninstall Plugin', 'wp_edit_pro');
					
					if( $this->network_activated === true ) {
						
						$uninstall_message = __('Uninstall Network Plugin', 'wp_edit_pro');
					}
					?>
					
					<form method="post" action="">
                    
						<?php wp_nonce_field('wp_edit_pro_uninstall_nonce_check','wp_edit_pro_uninstall_nonce'); ?>
						<input id="plugin" name="plugin" type="hidden" value="wp_edit_pro/main.php" />
						<input name="uninstall_confirm" id="uninstall_confirm" type="checkbox" value="1" /><label for="uninstall_confirm"></label> <?php _e('Please confirm before uninstalling plugin.','wp_edit_pro'); ?><br /><br />
                        <?php
						if( $this->network_activated === true ) {
							
							?><h4><?php _e('This plugin is currently network activated.', 'wp_edit_pro'); ?></h4>
                            <input name="uninstall_confirm_subsites" id="uninstall_confirm_subsites" type="checkbox" value="1" /><label for="uninstall_confirm_subsites"></label> 
							<?php _e('Delete plugin options for all network sites?','wp_edit_pro'); ?><br /><br /><?php
						}
						?>
						<input class="button-secondary" name="uninstall" type="submit" value="<?php echo $uninstall_message; ?>" />
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
		</div>
		<?php
	echo '</div>';
}


/*
****************************************************************
About Tab
****************************************************************
*/
if($active_tab == 'about'){
	
	// Get mysql version number (scrape php_info module)
	ob_start();
	phpinfo(INFO_MODULES);
	$info = ob_get_contents();
	ob_end_clean();
	$info = stristr($info, 'Client API version');
	preg_match('/[1-9].[0-9].[1-9][0-9]/', $info, $match);
	$sql_version = $match[0]; 
	
	// Get plugin info
	$url = $this->plugin_path . 'main.php';
	$plugin_data = get_plugin_data( $url );
	
	global $wp_version;
	
	echo '<div class="main_container">';
		
		?>
		<h2><?php _e('Information','wp_edit_pro'); ?></h2>
		
		<div class="metabox-holder">
			<div class="postbox">
				<div class="inside">
				
					<p><?php _e('Plugin and server version information.', 'wp_edit_pro'); ?></p>
				
					<table class="table table-bordered" cellpadding="3" style="width:30%;">
					<tbody>
					<tr><td><?php _e('WP Edit Pro Version:','wp_edit_pro'); ?></td>
						<td>
						<?php echo $plugin_data['Version']; ?>
						</td>
					</tr>
					<tr><td><?php _e('WordPress Version:','wp_edit_pro'); ?></td>
						<td>
						<?php echo $wp_version; ?>
						</td>
					</tr>
					<tr><td><?php _e('PHP Version:','wp_edit_pro'); ?></td>
						<td>
						<?php echo phpversion(); ?>
						</td>
					</tr>
					<tr><td><?php _e('HTML Version:','wp_edit_pro'); ?></td>
						<td>
						<span class="wpep_html_version"></span>
						</td>
					</tr>
					<tr><td><?php _e('MySql Version:','wp_edit_pro'); ?></td>
						<td>
						<?php echo $sql_version; ?>
						</td>
					</tr>
					<tr><td><?php _e('jQuery Version:','wp_edit_pro'); ?></td>
						<td>
						<?php echo $GLOBALS['wp_scripts']->registered['jquery-core']->ver; ?>
						</td>
					</tr>
					<tr><td><?php _e('Network Activated:','wp_edit_pro'); ?></td>
						<td>
						<?php echo $this->network_activated == true ? __( 'Yes', 'wp_edit_pro' ) : __( 'No', 'wp_edit_pro' ); ?>
						</td>
					</tr>
					<tr><td><?php _e('Multisite Activated:','wp_edit_pro'); ?></td>
						<td>
						<?php 
						$is_multisite = is_multisite();
						$is_multisite == true && $this->network_activated == false ? _e( 'Yes', 'wp_edit_pro' ) : _e( 'No', 'wp_edit_pro' );
						?>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<h2><?php _e('Support','wp_edit_pro'); ?></h2>
		<div class="metabox-holder">
			<div class="postbox">
				<div class="inside">
				
					<p><?php _e('Please use the following helpful links for plugin support.', 'wp_edit_pro'); ?></p>
				
					<table class="table table-bordered" cellpadding="3" style="width:30%;">
					<tbody>
					<tr><td><?php _e('Help Desk:','wp_edit_pro'); ?></td>
						<td>
						<?php echo '<a target="_blank" href="https://wpeditpro.com/support">Help Desk</a>'; ?><br />
                        <?php _e('Create or Manage support tickets.','wp_edit_pro'); ?>
						</td>
					</tr>
					<tr><td><?php _e('Knowledge Base:','wp_edit_pro'); ?></td>
						<td>
						<?php echo '<a target="_blank" href="http://learn.wpeditpro.com">Knowledge Base</a>'; ?><br />
                        <?php _e('Complete plugin documentation.','wp_edit_pro'); ?>
						</td>
					</tr>
					<tr><td><?php _e('Contact Us:','wp_edit_pro'); ?></td>
						<td>
						<?php echo '<a target="_blank" href="https://wpeditpro.com/contact">Contact WP Edit Pro</a>'; ?>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<h2><?php _e('Documentation','wp_edit_pro'); ?></h2>
		<div class="metabox-holder">
			<div class="postbox">
				<div class="inside">
				
					<p><?php _e('Remember, complete plugin documentation can be found on our <a target="_blank" href="http://learn.wpeditpro.com">Knowledge Base</a>.', 'wp_edit_pro'); ?></p>
					<p><?php _e('Visit the <a target="_blank" href="http://learn.wpeditpro.com/category/plugin-options/">Knowledge Base Plugin Options</a> page to get started.','wp_edit_pro'); ?></p>
				</div>
			</div>
		</div>
		<?php
	echo '</div>';
}


/*
****************************************************************
Notes Tab
****************************************************************
*/
if($active_tab == 'notes'){
	
	?>
	<div class="main_container">
    
		<h2><?php _e('Developer Notes','wp_edit_pro'); ?></h2>
		<p><?php _e('Dynamically generated content... straight from the developer.','wp_edit_pro'); ?></p>
        
		<div class="metabox-holder">
				
			<?php 
			$notes_header = '';
			$notes_body = '';
			$notes_response = wp_remote_get( 'https://wpeditpro.com/plugin_scripts/wpep_dev_notes.php' );
			
			if( is_array($notes_response) ) {
				
			  $notes_header = $notes_response['headers']; // array of http header lines
			  $notes_body = $notes_response['body']; // use the content
			}
			
			echo $notes_body;
			?>
		</div>
	</div>
	<?php
}
