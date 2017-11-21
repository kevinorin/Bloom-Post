<?php

$plugin_opts = $this->options_array;

/*
****************************************************************
Check welcome dialog
****************************************************************
*/
if(isset($_POST['wpep_welcome_submit'])) {
		
	$plugin_opts['wpep_first_install'] = 'false';  // Set first time install to false
	
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array['wpep_first_install'] = 'false';  // Update public variable
}
if(isset($_POST['wpep_welcome_cancel'])) {
	
	$plugin_opts['wpep_first_install'] = 'false';
	
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array['wpep_first_install'] = 'false';  // Update public variable
}



/*
****************************************************************
Buttons Tab
****************************************************************
*/
// Buttons submission
if(isset($_POST['wpep_save_buttons'])) {
	
	if(isset($_POST['get_sorted_array_results']) && ($_POST['get_sorted_array_results'] != '')) {

		//***************************************************
		// Get buttons from hidden div and update database
		//***************************************************
		$post_buttons = $_POST['get_sorted_array_results'];
		$final_button_array = array();
		
		// Explode first set of containers (breaks into "toolbar1:bold,italic,etc."
		$explode_containers = explode('*', $post_buttons);
		
		// Loop each container
		foreach($explode_containers as $container) {
		
			// Get rid of first container (empty)
			if($container != '') {
				
				// Explode each container
				$explode_each_container = explode(':', $container);
				// Replace commas (from js array) with spaces
				$explode_each_container = str_replace(',', ' ', $explode_each_container);
				
				// Push key (container) and value (buttons) to final array
				$final_button_array[$explode_each_container[0]] = $explode_each_container[1];
			}
		}
		
		/*
		****************************************************************
		Update buttons
		****************************************************************
		*/
		// If creating a wp role editor
		if(isset($_POST['wpep_new_role_editor'])) {
			
			// Get new role name
			global $new_role;
			$new_role = $_POST['wpep_new_role_editor'];
			
			// Create new option array
			$plugin_opts['wp_edit_pro_buttons_wp_role_'.$new_role] = $final_button_array;
			
			// Update options
			$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
			$this->options_array['wp_edit_pro_buttons_wp_role_'.$new_role] = $final_button_array;  // Update public variable
			
			// Alert user
			function wpep_save_buttons_create_wp_editor(){
				
				global $new_role;
				echo '<div class="updated">';
					echo '<p>';
						printf(__('New editor for the %s WordPress role has been created successfully.','wp_edit_pro'), '<strong>'.$new_role.'</strong>');
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_save_buttons_create_wp_editor' );
		}
		// If editing an exsiting wp role editor
		elseif(isset($_POST['wpep_existing_role_editor'])) {
			
			global $existing_role;
			$existing_role = $_POST['wpep_existing_role_editor'];
			
			// Create new option array
			$plugin_opts['wp_edit_pro_buttons_wp_role_'.$existing_role] = $final_button_array;
			
			// Update options
			$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
			$this->options_array['wp_edit_pro_buttons_wp_role_'.$existing_role] = $final_button_array;  // Update public variable
			
			// Alert user
			function wpep_save_buttons_create_wp_existing_editor(){
				
				global $existing_role;
				echo '<div class="updated">';
					echo '<p>';
						printf(__('The %s editor has been saved successfully.','wp_edit_pro'), '<strong>'.$existing_role.'</strong>');
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_save_buttons_create_wp_existing_editor' );
		}
		// If creating a wordpress capability editor
		elseif(isset($_POST['wpep_new_cap_editor'])) {
			
			global $new_cap;
			$new_cap = $_POST['wpep_new_cap_editor'];
			
			// Create new option array
			$plugin_opts['wp_edit_pro_buttons_wp_cap_'.$new_cap] = $final_button_array;
			
			// Update options
			$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
			$this->options_array['wp_edit_pro_buttons_wp_cap_'.$new_cap] = $final_button_array;  // Update public variable
			
			// Alert user
			function wpep_save_buttons_create_wp_cap(){
				
				global $new_cap;
				echo '<div class="updated">';
					echo '<p>';
						printf(__('New editor for the %s WordPress capability has been created successfully.','wp_edit_pro'), '<strong>'.$new_cap.'</strong>');
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_save_buttons_create_wp_cap' );
			
		}
		// If editing an exsiting wp capability editor
		elseif(isset($_POST['wpep_existing_cap_editor'])) {
			
			global $existing_cap;
			$existing_cap = $_POST['wpep_existing_cap_editor'];
			
			// Create new option array
			$plugin_opts['wp_edit_pro_buttons_wp_cap_'.$existing_cap] = $final_button_array;
			
			// Update options
			update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
			$this->options_array['wp_edit_pro_buttons_wp_cap_'.$existing_cap] = $final_button_array;  // Update public variable
			
			// Alert user
			function wpep_save_buttons_create_wp_cap_existing_editor(){
				
				global $existing_cap;
				echo '<div class="updated">';
					echo '<p>';
						printf(__('The %s editor has been saved successfully.','wp_edit_pro'), '<strong>'.$existing_cap.'</strong>');
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_save_buttons_create_wp_cap_existing_editor' );
		}
		// If creating a user specific editor
		elseif(isset($_POST['wpep_new_user_editor'])) {
			
			global $user_name;
			$user_name = $_POST['wpep_new_user_editor'];
			
			// Get user meta (for editor user)
			$user = get_user_by('login', $user_name);
			$user_meta = get_user_meta($user->ID, 'aaa_wp_edit_pro_user_meta', true);
			
			// Create new option array
			$user_meta['wp_edit_pro_buttons_user_editor'] = $final_button_array;
			
			// Update options
			update_user_meta($user->ID, 'aaa_wp_edit_pro_user_meta', $user_meta);
			
			// Alert user
			function wpep_save_buttons_create_user_editor(){
				
				global $user_name;
				echo '<div class="updated">';
					echo '<p>';
						printf(__('The editor for user %s has been saved successfully.','wp_edit_pro'), '<strong>'.$user_name.'</strong>');
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_save_buttons_create_user_editor' );
		}
		// If editing an existing user specific editor
		elseif(isset($_POST['wpep_existing_user_editor'])) {
			
			global $existing_user_name;
			$existing_user_name = $_POST['wpep_existing_user_editor'];
			
			// Get user meta (for editor user)
			$user = get_user_by('login', $existing_user_name);
			$user_meta = get_user_meta($user->ID, 'aaa_wp_edit_pro_user_meta', true);
			
			// Create new option array
			$user_meta['wp_edit_pro_buttons_user_editor'] = $final_button_array;
			
			// Update options
			update_user_meta($user->ID, 'aaa_wp_edit_pro_user_meta', $user_meta);
			
			// Alert user
			function wpep_save_buttons_edit_user_editor(){
				
				global $existing_user_name;
				echo '<div class="updated">';
					echo '<p>';
						printf(__('The editor for user %s has been saved successfully.', 'wp_edit_pro'), '<strong>'.$existing_user_name.'</strong>');
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_save_buttons_edit_user_editor' );
		}
		// If creating a visitor editor
		elseif(isset($_POST['wpep_new_visitor_editor'])) {
			
			// Create new option array
			$plugin_opts['wp_edit_pro_buttons_wp_visitor'] = $final_button_array;
			
			// Update options
			$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
			$this->options_array['wp_edit_pro_buttons_wp_visitor'] = $final_button_array;  // Update public variable
			
			// Alert user
			function wpep_save_buttons_create_wp_visitor(){
				
				global $new_cap;
				echo '<div class="updated">';
					echo '<p>';
						_e('New editor for site visitors has been created successfully.', 'wp_edit_pro');
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_save_buttons_create_wp_visitor' );
		}
		// If editing an existing visitor editor
		elseif(isset($_POST['wpep_existing_visitor_editor'])) {
			
			// Create new option array
			$plugin_opts['wp_edit_pro_buttons_wp_visitor'] = $final_button_array;
			
			// Update options
			$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
			$this->options_array['wp_edit_pro_buttons_wp_visitor'] = $final_button_array;  // Update public variable
			
			// Alert user
			function wpep_save_buttons_edit_visitor_editor(){
				
				global $existing_role;
				echo '<div class="updated">';
					echo '<p>';
						_e('The site visitor editor has been saved successfully.', 'wp_edit_pro');
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_save_buttons_edit_visitor_editor' );
		}
		// Else update the normal buttons array
		else {
		
			$plugin_opts['wp_edit_pro_buttons'] = $final_button_array;
			$this->options_array['wp_edit_pro_buttons'] = $final_button_array;  // Update public variable
			$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
			
			// Alert user
			function wpep_save_buttons_from_input(){
				
				echo '<div class="updated">';
					echo '<p>';
						_e('Buttons have been saved successfully.', 'wp_edit_pro');
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_save_buttons_from_input' );
		}
		
		//***************************************************
		// Check for new buttons
		//***************************************************
		
		/*** Get buttons from current page ***/
		$buttons = '';
		$active_buttons = $_POST['get_sorted_array_results'];  // Get each button container value (string)
		$explode1 = explode('*', $active_buttons);  // Explode into button containers (toolbar1:bold,italic,etc)
		$final_buttons = '';
		
		/*** Loop containers to get buttons ***/
		if(isset($explode1)) {
			foreach($explode1 as $value) {
				
				$explode2 = explode(':', $value);  // Explodes from (toolbar1:bold,italic,link,etc)
				$button_string = isset($explode2[1]) ? $explode2[1] : '';  // Get second array item (buttons (comma separated))
				
				if(!empty($button_string)) {  // If the buttons string is not empty
				
					$final_buttons .= $button_string.',';  // Create long string of comma separated butttons
				}
			}
		}
		// Right trim comma from string
		$final_buttons = rtrim($final_buttons, ',');
		// Create array of all buttons on page ((bold)(italic)(etc))
		$page_array = array_filter(explode(',', $final_buttons));
		
		/*** Get default buttons ***/
		// Get all buttons from initialization code (including any new buttons)
		$options_buttons_defaults = $this->options_default['wp_edit_pro_buttons'];
		$buttons_option = '';
		
		// Loop each container and extract buttons
		foreach($options_buttons_defaults as $option) {
			
			$buttons_option .= ' ' . $option;  // The list of initialization buttons (as string)
		}
		
		// Trim whitespace from left of $buttons_option string (space separated)
		$buttons_option = ltrim($buttons_option);
		// Explode space separated string into array
		$buttons_option_array = array_filter(explode(' ', $buttons_option));
		
		/*** Compare arrays ***/
		$array_diff = array_diff($buttons_option_array, $page_array);
		
		// If new buttons were discovered
		if(!empty($array_diff)) {  
			
			// Get each button name from array difference
			global $each_button_trim;
			$each_button = '';
			foreach($array_diff as $button) {  // Loop array to get each button name
				
				$each_button .= ' '.$button;
			}
			// Remove white space from far left of string
			$each_button_trim = ltrim($each_button);
			
			// Get buttons option and append new buttons to tmce container
			$db_buttons = $this->options_array['wp_edit_pro_buttons'];
			$db_buttons['tmce_container'] = $db_buttons['tmce_container'].$each_button;
			$plugin_opts['wp_edit_pro_buttons']['tmce_container'] = $db_buttons['tmce_container'];
			
			//***************************************************
			// Update editors (role, cap, user, custom, etc.)
			//***************************************************
			// Update normal buttons options
			$this->options_array['wp_edit_pro_buttons'] = $db_buttons;  // Update public variable
			$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
			
			// Update role and capability editors buttons options
			foreach($plugin_opts as $key => $value) {
				if(strpos($key,'wp_edit_pro_buttons_wp_role_') !== false || strpos($key,'wp_edit_pro_buttons_wp_cap_') !== false) {
					$plugin_opts[$key]['tmce_container'] = $plugin_opts[$key]['tmce_container'].$each_button;
					$this->woptions_array[$key]['tmce_container'] = $this->options_array[$key]['tmce_container'].$each_button; // Update public variable
					$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
				}
			}
			
			// Update user meta buttons options
			$users = get_users();
			foreach($users as $key => $value) {
				$user_meta = get_user_meta($value->data->ID, 'aaa_wp_edit_pro_user_meta', true);
				if(!empty($user_meta) && isset($user_meta['wp_edit_pro_buttons_user_editor']['tmce_container'])) {
					$user_meta['wp_edit_pro_buttons_user_editor']['tmce_container'] = $user_meta['wp_edit_pro_buttons_user_editor']['tmce_container'].$each_button;
					// Update user meta
					update_user_meta($value->data->ID, 'aaa_wp_edit_pro_user_meta', $user_meta);
				}
			}
			
			// Alert user
			function wpep_alert_user_new_buttons() {
				
				global $each_button_trim;
				echo '<div id="message" class="updated"><p>';
				_e('New buttons were discovered.  The following buttons have been added to the Button Container:', 'wp_edit_pro');
				echo '<br /><strong>'.$each_button_trim.'</strong>';
				echo '</p>';
				echo '<p>';
				_e('These buttons have also been added to any custom created editors. Enjoy!','wp_edit_pro');
				echo '</p></div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_alert_user_new_buttons' );
		}
		
		//***************************************************
		// Remove deleted buttons
		//***************************************************
		// Get saved buttons
		$options_buttons = $this->options_array['wp_edit_pro_buttons'];
		
		// Get default plugin buttons
		$plugin_buttons = $this->options_default['wp_edit_pro_buttons'];
		
		// Merge all default plugin buttons into single array
		$all_array = '';
		foreach($plugin_buttons as $slot_array) {
			
			if(!empty($slot_array) && $slot_array != '') {  // Skip containter array if empty
				$all_array .= $slot_array.' ';  // Create single string of all default plugin buttons
			}
		}
		$all_array = rtrim($all_array, ' ');  // Remove trailing right space
		$plugin_array = explode(' ', $all_array);  // Explode at spaces to make single array (this is an array of all current plugin buttons)
		
		// Create arrays of user saved buttons
		global $tot_array;
		$val_array = array();
		$tot_array = array();  // Used to display results to user
		$alert_message = 'false';
		
		foreach($options_buttons as $cont => $val) {  // Break down array
		
			if(!empty($val) && $val !='') {  // Skip container if empty
				$val_array = explode(' ', $val);  // Explode at spaces into array (this is multiarray of each container array of user buttons)
				
				$rem_array = array();  // Setup removal array
				foreach($val_array as $item) {
					if(!in_array($item, $plugin_array)) {
						// Removed array items
						$rem_array[] = $item;
						$tot_array = array();  // Clear array so doesn't accumulate other editor buttons (is global option)
						$tot_array[] = $item;
					}
				}
				
				if(!empty($rem_array)) {
					
					$old_opts = $options_buttons[$cont];  // Get option from database values
					$old_opts = explode(' ', $old_opts);  // Explode to array
					$new_opt_array = array_diff($old_opts, $rem_array);  // Compare arrays to remove non-supported buttons
					$new_opt_array = implode(' ', $new_opt_array);  // Implode back to string
					$options_buttons[$cont] = $new_opt_array;  // Set container to new string
					
					$alert_message = 'true';
				}
			}
		}
		
		// Remove any duplicate buttons
		foreach($options_buttons as $opt_name => $opt_value) {
			
			$button_string = $opt_value;
			$button_array = explode(' ', $button_string);
			$array_unique = array_unique($button_array);  // Remove the duplicates
			if(!empty($array_unique)) {
				
				$array_unique = implode(' ' , $array_unique);
				$options_buttons[$opt_name] = $array_unique;
			}
		}
			
		// Update normal buttons options
		$plugin_opts['wp_edit_pro_buttons'] = $options_buttons;
		$this->options_array['wp_edit_pro_buttons'] = $options_buttons;  // Update public variable
		
		// Update role and capability editors
		foreach($plugin_opts as $key => $value) {
			if((strpos($key,'wp_edit_pro_buttons_wp_role_') !== false && strpos($key,'wp_edit_pro_buttons_wp_cap_') == true) || (strpos($key,'wp_edit_pro_buttons_wp_cap_') !== false && strpos($key,'wp_edit_pro_buttons_wp_role_') == true)) {
				
				$options_buttons = $this->options_array[$key];
				foreach($options_buttons as $cont => $val) {  // Break down array
	
					if(!empty($val) && $val !='') {  // Skip container if empty
						$val_array = explode(' ', $val);  // Explode at spaces into array (this is multiarray of each container array of user buttons)
						
						$rem_array = array();  // Setup removal array
						foreach($val_array as $item) {
							if(!in_array($item, $plugin_array)) {
								// Removed array items
								$rem_array[] = $item;
								$tot_array = array();  // Clear array so doesn't accumulate other editor buttons (is global option)
								$tot_array[] = $item;
							}
						}
						
						if(!empty($rem_array)) {
							
							$old_opts = $options_buttons[$cont];  // Get option from database values
							$old_opts = explode(' ', $old_opts);  // Explode to array
							$new_opt_array = array_diff($old_opts, $rem_array);  // Compare arrays to remove non-supported buttons
							$new_opt_array = implode(' ', $new_opt_array);  // Implode back to string
							$options_buttons[$cont] = $new_opt_array;  // Set container to new string
				
							$alert_message = 'true';
						}
					}
				}
		
				// Remove any duplicate buttons
				foreach($options_buttons as $opt_name => $opt_value) {
					
					$button_string = $opt_value;
					$button_array = explode(' ', $button_string);
					$array_unique = array_unique($button_array);  // Remove the duplicates
					if(!empty($array_unique)) {
						
						$array_unique = implode(' ' , $array_unique);
						$options_buttons[$opt_name] = $array_unique;
					}
				}
				
				$plugin_opts[$key] = $options_buttons;
				$this->options_array[$key] =  $options_buttons; // Update public variable
				$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
			}
		}
		
		// Update user editor button options
		$users = get_users();
		foreach($users as $key => $value) {
			$user_meta = get_user_meta($value->data->ID, 'aaa_wp_edit_pro_user_meta', true);
			if(!empty($user_meta) && isset($user_meta['wp_edit_pro_buttons_user_editor'])) {
				
				$options_buttons = $user_meta['wp_edit_pro_buttons_user_editor'];
				foreach($options_buttons as $cont => $val) {  // Break down array
	
					if(!empty($val) && $val !='') {  // Skip container if empty
						$val_array = explode(' ', $val);  // Explode at spaces into array (this is multiarray of each container array of user buttons)
						
						$rem_array = array();  // Setup removal array
						foreach($val_array as $item) {
							if(!in_array($item, $plugin_array)) {
								// Removed array items
								$rem_array[] = $item;
								$tot_array = array();  // Clear array so doesn't accumulate other editor buttons (is global option)
								$tot_array[] = $item;
							}
						}
						
						if(!empty($rem_array)) {
							
							$old_opts = $options_buttons[$cont];  // Get option from database values
							$old_opts = explode(' ', $old_opts);  // Explode to array
							$new_opt_array = array_diff($old_opts, $rem_array);  // Compare arrays to remove non-supported buttons
							$new_opt_array = implode(' ', $new_opt_array);  // Implode back to string
							$options_buttons[$cont] = $new_opt_array;  // Set container to new string
				
							$alert_message = 'true';
						}
					}
				}
		
				// Remove any duplicate buttons
				foreach($options_buttons as $opt_name => $opt_value) {
					
					$button_string = $opt_value;
					$button_array = explode(' ', $button_string);
					$array_unique = array_unique($button_array);  // Remove the duplicates
					if(!empty($array_unique)) {
						
						$array_unique = implode(' ' , $array_unique);
						$options_buttons[$opt_name] = $array_unique;
					}
				}
				
				$user_meta['wp_edit_pro_buttons_user_editor'] = $options_buttons;
				// Update user meta
				update_user_meta($value->data->ID, 'aaa_wp_edit_pro_user_meta', $user_meta);
			}
		}
		
		if($alert_message === 'true') {
			function wpep_remove_buttons_notice() {
		
				global $tot_array;
				echo '<div class="updated"><p>';
					$tot_array = implode(', ', $tot_array);
					_e('The following buttons have been removed from WP Edit Pro:','wp_edit_pro');
					echo '<br />';
					echo '<strong>'.$tot_array.'</strong>';
					echo '</p>';
					echo '<p>';
					_e('These buttons have also been removed from any custom created editors.','wp_edit_pro');
				echo '</p></div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_remove_buttons_notice' );
		}
	}
}
// If deleting a created wp roles editor
if(isset($_POST['wpep_delete_wp_role_editor'])) {
	
	// Get role name (returned in single item array; converted to string)
	global $this_role;
	$role_name = $_POST['wpep_delete_wp_role_editor'];
	reset($role_name);
	$this_role = key($role_name);
	
	// Remove role from options array
	unset($plugin_opts['wp_edit_pro_buttons_wp_role_'.$this_role]);
	
	// Update options
	$this->options_array = $plugin_opts;  // Update public variable
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	
	// Alert user
	function wpep_delete_custom_wp_role_editor(){
		
		global $this_role;
		echo '<div class="updated">';
			echo '<p>';
				printf(__('The %s WordPress role editor has been successfully deleted.','wp_edit_pro'), '<strong>'.$this_role.'</strong>');
			echo '</p>';
		echo '</div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_delete_custom_wp_role_editor' );
}
// If deleting a created wp capabilities editor
if(isset($_POST['wpep_delete_wp_cap_editor'])) {
	
	// Get role name (returned in single item array; converted to string)
	global $this_cap;
	$cap_name = $_POST['wpep_delete_wp_cap_editor'];
	reset($cap_name);
	$this_cap = key($cap_name);
	
	// Remove role from options array
	unset($plugin_opts['wp_edit_pro_buttons_wp_cap_'.$this_cap]);
	
	// Update options
	$this->options_array = $plugin_opts;  // Update public variable
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	
	// Alert user
	function wpep_delete_custom_wp_cap_editor(){
		
		global $this_cap;
		echo '<div class="updated">';
			echo '<p>';
				printf(__('The %s WordPress capability editor has been successfully deleted.','wp_edit_pro'), '<strong>'.$this_cap.'</strong>');
			echo '</p>';
		echo '</div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_delete_custom_wp_cap_editor' );
}
// If deleting a created user specific editor
if(isset($_POST['wpep_delete_user_editor'])) {
	
	// Get user_id (returned in single item array; converted to string)
	global $user_id;
	$user_array = $_POST['wpep_delete_user_editor'];
	reset($user_array);
	$user_id = key($user_array);
	
	// Get user meta
	$user_meta = get_user_meta($user_id, 'aaa_wp_edit_pro_user_meta', true);
	
	// Remove user editor from options array
	unset($user_meta['wp_edit_pro_buttons_user_editor']);
	
	// Update user meta
	update_user_meta($user_id, 'aaa_wp_edit_pro_user_meta', $user_meta);
	
	// Alert user
	function wpep_delete_user_specific_editor(){
		
		global $user_id;
		$user_data = get_userdata($user_id);
		echo '<div class="updated">';
			echo '<p>';
				printf(__('The user editor for %s has been successfully deleted.','wp_edit_pro'), '<strong>'.$user_data->user_login.'</strong>');
			echo '</p>';
		echo '</div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_delete_user_specific_editor' );
}
// If deleting the site visitor editor
if(isset($_POST['wpep_delete_visitor_editor'])) {
	
	// Remove role from options array
	unset($plugin_opts['wp_edit_pro_buttons_wp_visitor']);
	
	// Update options
	$this->options_array = $plugin_opts;  // Update public variable
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	
	// Alert user
	function wpep_delete_custom_wp_visitor_editor(){
		
		global $this_cap;
		echo '<div class="updated">';
			echo '<p>';
				_e('The site visitor editor has been successfully deleted.','wp_edit_pro');
			echo '</p>';
		echo '</div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_delete_custom_wp_visitor_editor' );
}

// If capabilities array has been sorted (and saved)
if(isset($_POST['wpep_submit_caps_sort'])) {
	
	// Get sorted array results
	$hold_opts = array();
	$sorted_array = isset($_POST['wpep_submit_caps_sort_array']) ? $_POST['wpep_submit_caps_sort_array'] : array();
	
	// If array items exist
	if($sorted_array !== '') {
	
		$sorted_array = explode(',', $sorted_array);
		
		foreach($sorted_array as $cap_role) {
			
			$hold_opts[$cap_role] = $this->options_array['wp_edit_pro_buttons_wp_cap_'.$cap_role];
			// Remove role from options array
			unset($plugin_opts['wp_edit_pro_buttons_wp_cap_'.$cap_role]);
			// Remove role from public variable
			unset($this->options_array['wp_edit_pro_buttons_wp_cap_'.$cap_role]);
		}
		
		foreach($hold_opts as $put_name => $put_opt) {
			$plugin_opts['wp_edit_pro_buttons_wp_cap_'.$put_name] = $put_opt;
			$this->options_array['wp_edit_pro_buttons_wp_cap_'.$put_name] = $put_opt;  // Update public variable
		}
		
		// Update options
		$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
		
		// Alert user
		function wpep_sort_capabilities_success(){
			
			echo '<div class="updated">';
				echo '<p>';
					_e('User capability editors have been successfully sorted and saved.','wp_edit_pro');
				echo '</p>';
			echo '</div>';
		}
		add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_sort_capabilities_success' );
	}
	// Else no array items exist
	else {
		
		// Alert user
		function wpep_sort_capabilities_error(){
			
			echo '<div class="error">';
				echo '<p>';
					_e('No user editors have yet been created. Please create at least two user editors before attempting to sort.','wp_edit_pro');
				echo '</p>';
			echo '</div>';
		}
		add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_sort_capabilities_error' );
	}
}

// If reset buttons was submitted
if(isset($_POST['wpep_reset_buttons'])) {
	
	// Alert user
	function wpep_reset_buttons_success(){
		
		echo '<div class="updated">';
			echo '<p>';
				_e('Editor buttons have been reset to default values. Remember to "Save" the changes.','wp_edit_pro');
			echo '</p>';
		echo '</div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_reset_buttons_success' );
}

// If created editor views button was submitted
if( isset( $_POST['created_editors_view'] ) ) {
	
	$view = $_POST['created_editors_view'];
	$plugin_opts['wp_edit_pro_buttons_extras']['created_editors_view'] = $view;
	
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
}


/*
****************************************************************
Network Tab
****************************************************************
*/
// If submitting network options
if( isset( $_POST['submit_network'] ) ) {
	
	$network_admin_mode = isset( $_POST['wpep_network_admin_mode'] ) ? $_POST['wpep_network_admin_mode'] : 'same';
	$plugin_opts['wp_edit_pro_network']['wpep_network_admin_mode'] = $network_admin_mode;
	
	$this->network_admin_mode = $network_admin_mode;
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
	
	function wpep_network_options_saved_notice(){
		
		echo '<div class="updated"><p>';
			_e('Network options successfully saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_network_options_saved_notice' );
}

// If switching to a subsite blog ID
if( isset( $_POST['wpep_submit_blog_id'] ) ) {
	
	$blog_id = isset($_POST['wpep_select_blog_id']) ? $_POST['wpep_select_blog_id'] : '';
	
	$get_id_opts = get_site_option( 'wp_edit_pro_options_array' );
	$get_id_opts['wp_edit_pro_network']['wpep_select_blog_id'] = $blog_id;
	
	$this->network_blog_id = $blog_id;
	update_site_option( 'wp_edit_pro_options_array', $get_id_opts );  // Update plugin option
	
}

// If canceling editing subsite options
if( isset( $_POST['wpep_submit_cancel_network'] ) ) {
	
	$get_site_opts = get_site_option('wp_edit_pro_options_array');
	$get_site_opts['wp_edit_pro_network']['wpep_select_blog_id'] = '';
	
	$this->network_blog_id = '';
	$this->options_array = $this->get_wp_edit_pro_option( 'wp_edit_pro_options_array' );
	update_site_option( 'wp_edit_pro_options_array', $get_site_opts );  // Update plugin option
}


/*
****************************************************************
Global Tab
****************************************************************
*/
if( isset( $_POST['submit_global'] ) ) {
	
	$plugin_opts['wp_edit_pro_global']['jquery_theme'] = isset( $_POST['jquery_theme'] ) ? $_POST['jquery_theme'] : 'smoothness';
	$plugin_opts['wp_edit_pro_global']['disable_buttons_fancy_tooltips'] = isset( $_POST['disable_buttons_fancy_tooltips'] ) ? '1' : '0';
	
	$this->update_wp_edit_pro_option( 'wp_edit_pro_options_array', $plugin_opts );  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
	
	function wpep_global_options_saved_notice(){
		
		echo '<div class="updated"><p>';
			_e('Global options successfully saved.', 'wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_global_options_saved_notice' );
}


/*
****************************************************************
Configuration Tab
****************************************************************
*/
// Get user defaults
global $jwl_advmceconf_show_defaults;

// If we are saving the altered table
if (isset($_POST['wpep_adv_config_save']) ) {
	
	$old_options_configuration = $plugin_opts['wp_edit_pro_configuration'];
	$config_opts = isset($_POST['wpep_adv_cfg_options']) ? $_POST['wpep_adv_cfg_options'] : array();
		
	if ( !is_array($config_opts) )
		$_POST['wpep_adv_cfg_options'] = array();

	if ( !empty($_POST['wpep_tmce_new_name']) && isset($_POST['wpep_tmce_new_val']) )
		$config_opts[$_POST['wpep_tmce_new_name']] = $_POST['wpep_tmce_new_val'];

	foreach ( $config_opts as $key => $val ) {
		
		$key = preg_replace( '/[^a-z0-9_]+/i', '', $key );
		if ( empty($key) )
			continue;

		if ( isset($_POST[$key]) && empty($_POST[$key]) ) {
			unset($plugin_opts['wp_edit_pro_configuration'][$key]);
			continue;
		}

		$val = stripslashes($val);
		if ( 'true' == $val )
			$plugin_opts['wp_edit_pro_configuration'][$key] = true;
		elseif ( 'false' == $val )
			$plugin_opts['wp_edit_pro_configuration'][$key] = false;
		else
			$plugin_opts['wp_edit_pro_configuration'][$key] = $val;
	}

	if ( $plugin_opts['wp_edit_pro_configuration'] != $old_options_configuration ) {
		
		$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
		$this->options_array = $plugin_opts;  // Update public variable
	}
		
	function wp_edit_pro_adv_cfg_save_opts() {
		
		echo '<div id="message" class="updated"><p>';
			_e('Configuration options successfully saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_adv_cfg_save_opts' );

}


/*
****************************************************************
General Tab
****************************************************************
*/
if( isset( $_POST['submit_general'] ) ) {

	$plugin_opts['wp_edit_pro_general']['linebreak_shortcode'] = isset( $_POST['linebreak_shortcode'] ) ? '1' : '0';
	$plugin_opts['wp_edit_pro_general']['shortcodes_in_widgets'] = isset( $_POST['shortcodes_in_widgets'] ) ? '1' : '0';
	$plugin_opts['wp_edit_pro_general']['shortcodes_in_excerpts'] = isset( $_POST['shortcodes_in_excerpts'] ) ? '1' : '0';
	$plugin_opts['wp_edit_pro_general']['post_excerpt_editor'] = isset( $_POST['post_excerpt_editor'] ) ? '1' : '0';
	$plugin_opts['wp_edit_pro_general']['page_excerpt_editor'] = isset( $_POST['page_excerpt_editor'] ) ? '1' : '0';
	$plugin_opts['wp_edit_pro_general']['profile_editor'] = isset( $_POST['profile_editor'] ) ? '1' : '0';
	
	// Save cpt excerpts
	$cpt_excerpts = array();
	$options_general['wpep_cpt_excerpts'] = array();
	
	if( isset( $_POST['wpep_cpt_excerpts'] ) ) {
		
		$cpt_excerpts = $_POST['wpep_cpt_excerpts'];
		
		// Loop checked cpt's and create array
		foreach( $cpt_excerpts as $key => $value ) {
			
			if( $value === 'on' )
				$plugin_opts['wp_edit_pro_general']['wpep_cpt_excerpts'][] = $key;
		}
	}
	else {
		$plugin_opts['wp_edit_pro_general']['wpep_cpt_excerpts'] = array();
	}
	
	$this->update_wp_edit_pro_option( 'wp_edit_pro_options_array', $plugin_opts );  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
	
	// Alert user
	function wpep_general_options_saved_notice(){
		
		echo '<div class="updated"><p>';
			_e( 'General options successfully saved.','wp_edit_pro' );
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_general_options_saved_notice' );
}


/*
****************************************************************
Posts Tab
****************************************************************
*/
if(isset($_POST['submit_posts'])) {

	// Delete database revisions
	if(isset($_POST['submit_posts']) && isset($_POST['delete_revisions'])) {
		
		function wp_edit_pro_delete_revisions_admin_notice( ){	
		
			global $wpdb;
			
			// If editing a subsite
			$revisions_opt = get_site_option('wp_edit_pro_options_array');
			$site_db_revisions = isset($revisions_opt['wp_edit_pro_network']['wpep_select_blog_id']) ? $revisions_opt['wp_edit_pro_network']['wpep_select_blog_id'] : '';
			
			if($site_db_revisions !== '') {
				
				switch_to_blog($site_db_revisions);
				
				// Get pre DB size
				$query = $wpdb->get_results( "SHOW TABLE STATUS", ARRAY_A );
				$size = 0;
				foreach ($query as $row) {
					$size += $row["Data_length"] + $row["Index_length"];
				}
				$mbytes = number_format($size/(1024*1024), 2);
				
				// Delete Post Revisions from DB
				$posts = $wpdb->prefix.'posts';
				$query3_raw = "DELETE FROM ".$posts." WHERE post_type = 'revision'";
				$query3 = $wpdb->query($query3_raw);
				if ($query3) {
					$deleted_rows = "Revisions successfully deleted";
				} else {
					$deleted_rows = "No POST revisions were found to delete";
				}
				
				// Get post DB size
				$query2 = $wpdb->get_results( "SHOW TABLE STATUS", ARRAY_A );
				$size2 = 0;
				foreach ($query2 as $row2) {
					$size2 += $row2["Data_length"] + $row2["Index_length"];
				}
				$mbytes2 = number_format($size2/(1024*1024), 2); 
				
				restore_current_blog();
			}
			else {
				
				// Get pre DB size
				$query = $wpdb->get_results( "SHOW TABLE STATUS", ARRAY_A );
				$size = 0;
				foreach ($query as $row) {
					$size += $row["Data_length"] + $row["Index_length"];
				}
				$mbytes = number_format($size/(1024*1024), 2);
				
				// Delete Post Revisions from DB
				$posts = $wpdb->prefix.'posts';
				$query3_raw = "DELETE FROM ".$posts." WHERE post_type = 'revision'";
				$query3 = $wpdb->query($query3_raw);
				if ($query3) {
					$deleted_rows = "Revisions successfully deleted";
				} else {
					$deleted_rows = "No POST revisions were found to delete";
				}
				
				// Get post DB size
				$query2 = $wpdb->get_results( "SHOW TABLE STATUS", ARRAY_A );
				$size2 = 0;
				foreach ($query2 as $row2) {
					$size2 += $row2["Data_length"] + $row2["Index_length"];
				}
				$mbytes2 = number_format($size2/(1024*1024), 2); 
			}
			
			echo '<div class="updated"><p>Message: <strong>'.$deleted_rows.'</strong>.</p><p>Database size before deletions: <strong>'.$mbytes.'</strong> megabytes.</p><p>Database Size after deletions: <strong>'.$mbytes2.'</strong> megabytes.</p></div>';
		}
		add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_delete_revisions_admin_notice' );
	}
	
	// Set new DB Options
	$plugin_opts['wp_edit_pro_posts']['wpep_styles_editor_textarea'] = isset($_POST['wpep_styles_editor_textarea']) ? stripslashes($_POST['wpep_styles_editor_textarea']) : '';
	$plugin_opts['wp_edit_pro_posts']['wpep_scripts_editor_textarea'] = isset($_POST['wpep_scripts_editor_textarea']) ? stripslashes($_POST['wpep_scripts_editor_textarea']) : '';
	$plugin_opts['wp_edit_pro_posts']['wpep_ind_styles_scripts'] = isset($_POST['wpep_ind_styles_scripts']) ? '1' : '0';

	$plugin_opts['wp_edit_pro_posts']['page_title_field'] = isset($_POST['page_title_field']) ? sanitize_text_field($_POST['page_title_field']) : 'Enter title here';
	$plugin_opts['wp_edit_pro_posts']['post_title_field'] = isset($_POST['post_title_field']) ? sanitize_text_field($_POST['post_title_field']) : 'Enter title here';
	
	$plugin_opts['wp_edit_pro_posts']['column_shortcodes'] = isset($_POST['column_shortcodes']) ? '1' : '0';
	
	$plugin_opts['wp_edit_pro_posts']['editor_notes'] = isset($_POST['editor_notes']) ? '1' : '0';
	
	$plugin_opts['wp_edit_pro_posts']['max_post_revisions'] = isset($_POST['max_post_revisions']) ? sanitize_text_field($_POST['max_post_revisions']) : '';
	$plugin_opts['wp_edit_pro_posts']['max_page_revisions'] = isset($_POST['max_page_revisions']) ? sanitize_text_field($_POST['max_page_revisions']) : '';
	
	$plugin_opts['wp_edit_pro_posts']['hide_admin_posts'] = isset($_POST['hide_admin_posts']) ? sanitize_text_field($_POST['hide_admin_posts']) : '';
	$plugin_opts['wp_edit_pro_posts']['hide_admin_pages'] = isset($_POST['hide_admin_pages']) ? sanitize_text_field($_POST['hide_admin_pages']) : '';
	
	$plugin_opts['wp_edit_pro_posts']['enable_comment_editor'] = isset($_POST['enable_comment_editor']) ? '1' : '0';
	$plugin_opts['wp_edit_pro_posts']['enable_add_media'] = isset($_POST['enable_add_media']) ? '1' : '0';
	
	$this->update_wp_edit_pro_option( 'wp_edit_pro_options_array', $plugin_opts );  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
	
	// Alert User
	function wpep_posts_saved_notice(){
		
		echo '<div class="updated"><p>';
			_e('Posts/Pages options successfully saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_posts_saved_notice' );
}


/*
****************************************************************
Editor Tab
****************************************************************
*/
if(isset($_POST['submit_editor'])) {
	
	$plugin_opts['wp_edit_pro_editor']['editor_toggle_toolbar'] = isset($_POST['editor_toggle_toolbar']) ? '1' : '0';
	
	$plugin_opts['wp_edit_pro_editor']['editor_menu_bar'] = isset($_POST['editor_menu_bar']) ? '1' : '0';
	
	$plugin_opts['wp_edit_pro_editor']['default_editor_fontsize_type'] = isset($_POST['default_editor_fontsize_type']) ? $_POST['default_editor_fontsize_type'] : 'pt';
	$plugin_opts['wp_edit_pro_editor']['default_editor_fontsize_values'] = isset($_POST['default_editor_fontsize_values']) ? sanitize_text_field($_POST['default_editor_fontsize_values']) : '';
	
	// Define custom color selection before updating
	$update_colors = array();
	foreach($_POST['editor_custom_colors'] as $key => $value) {
		if($value[0] !== '' && $value[1] !== '') {
			$update_colors[$key] = array(str_replace('#', '', sanitize_text_field($value[0])), sanitize_text_field($value[1]));
		}
	}
	$plugin_opts['wp_edit_pro_editor']['editor_custom_colors'] = isset($_POST['editor_custom_colors']) ? $update_colors : array();
	
	$plugin_opts['wp_edit_pro_editor']['dropbox_app_key'] = isset($_POST['dropbox_app_key']) ? sanitize_text_field($_POST['dropbox_app_key']) : '';
	
	$plugin_opts['wp_edit_pro_editor']['disable_wpep_posts'] = isset($_POST['disable_wpep_posts']) ? '1' : '0';
	$plugin_opts['wp_edit_pro_editor']['disable_wpep_pages'] = isset($_POST['disable_wpep_pages']) ? '1' : '0';
	
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
		
	function wpep_editor_saved_notice(){
		
		echo '<div class="updated"><p>';
			_e('Editor options successfully saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_editor_saved_notice' );
}


/*
****************************************************************
Fonts Tab
****************************************************************
*/
// Google webfonts
if(isset($_POST['submit_fonts'])) {
	
	$plugin_opts['wp_edit_pro_fonts']['enable_google_fonts'] = isset($_POST['enable_google_fonts']) ? '1' : '0';
	$plugin_opts['wp_edit_pro_fonts']['save_google_fonts'] = isset($_POST['save_google_fonts']) ? $_POST['save_google_fonts'] : '';
	
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
		
	function wp_edit_pro_fonts_saved_notice(){
		
		echo '<div class="updated"><p>';
			_e('Google Font options successfully saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_fonts_saved_notice' );
}

// Custom fonts
if(isset($_POST['submit_fonts_custom'])) {
	
	// Get stored custom fonts
	$old_opts = $plugin_opts['wp_edit_pro_fonts'];
	$old_array = isset($old_opts['save_custom_fonts']) ? $old_opts['save_custom_fonts'] : array();
	
	// Get post input values
	$post_opts = isset($_POST['save_custom_fonts']) ? $_POST['save_custom_fonts'] : array();
	
	// If post values are empty, delete db value
	if(empty($post_opts)) {
		
		$plugin_opts['wp_edit_pro_fonts']['save_custom_fonts'] = array();
	}
	// Else merge old and new options
	else {
	
		// Loop fonts and create array with font name => font values
		$new_array = array();
		foreach($post_opts as $key => $value) {
			
			$explode = explode('.', $value);
			$filename = $explode[0];
			
			if(!in_array($filename, $new_array) && !in_array($filename, $old_array)) {
				array_push($new_array, $filename);
			}
		}
		
		// Merge old and new arrays
		$merge = array_merge($old_array, $new_array);
		
		// Save font names
		$plugin_opts['wp_edit_pro_fonts']['save_custom_fonts'] = $merge;
	}
	
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
	
	$message = 'success';
	
	// If there are files to upload
	if($_FILES['filesToUpload']['name'][0] !== '' && count($_FILES['filesToUpload']['name'])) {
		
		// Reorder the files upload array (http://php.net/manual/en/features.file-upload.multiple.php)
		$file_ary = array();
		$file_count = count($_FILES['filesToUpload']['name']);
		$file_keys = array_keys($_FILES['filesToUpload']);
	
		for ($i=0; $i<$file_count; $i++) {
			foreach ($file_keys as $key) {
				$file_ary[$i][$key] = $_FILES['filesToUpload'][$key][$i];
			}
		}
		
		global $error_array;
		$error_array = array();
		$valid_file = true;
		
		foreach($file_ary as $file) {
			
			// If no errors...
			if(!$file['error']) {
				
				// Now is the time to modify the future file name and validate the file
				$new_file_name = $file['name']; // Rename file
				if($file['size'] > (1024000)) { // Can't be larger than 1 MB
				
					$valid_file = false;
					$message = 'error';
					$upload_errors = array_push($error_array, 'Oops! The file size for ' . $file['name'] . ' is to large.');
				}
				
				// If the file has passed the test
				if($valid_file) {
					
					// Get current blog id
					//$blog_id = get_current_blog_id();
					$blog_id = $this->network_blog_id;
					
					// Have to check which subsite we are on (1 = main site or network site 1)
					// If custom css is found in stylesheet... create css file
					if( $this->network_blog_id !== '' && $this->network_blog_id != '1' ) {
						
						$upload_dir = wp_upload_dir();
						$upload_path = $upload_dir['basedir'];
						$file_path = $upload_path . '/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/';
					}
					else {
						
						$upload_dir = wp_upload_dir();
						$upload_path = $upload_dir['basedir'];
						$file_path = $upload_path . '/wp_edit_pro/custom_fonts/';
					}
		
					// Move it to where we want it to be
					$moved = move_uploaded_file($file['tmp_name'], $file_path . $new_file_name);
					if($moved == false) {
						$message = 'error';
						$upload_errors = array_push($error_array, $file['error']);
					}
					else {
						$message = 'success';
					}
				}
			}
			// If there is an error...
			else {
				
				// Set that to be the returned message
				$valid_file = false;
				$message = 'error';
				$upload_errors = array_push($error_array, $file['error'] . '<br />');
			}
		}
	}
	
	// Write fonts to stylesheet
	$custom_fonts = $plugin_opts['wp_edit_pro_fonts']['save_custom_fonts'];
	if(is_array($custom_fonts) && !empty($custom_fonts)) {
		
		$blog_id = get_current_blog_id();
		
		// Have to check which subsite we are on (1 = main site or network site 1)
		// If custom css is found in stylesheet... create css file
		if( $this->network_blog_id !== '' && $this->network_blog_id != '1' ) {
			
			$upload_dir = wp_upload_dir();
			$upload_path = $upload_dir['basedir'];
			$file_stylesheet = $upload_path . '/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/stylesheet/custom_fonts_styles.css';
			
			
			$content_url = content_url();
			$file_stylesheet_url = $content_url . '/uploads/wp_edit_pro/custom_fonts/';
		}
		else {
			
			if( is_multisite() == true && $blog_id !== 1 ) {
			
				$upload_dir = wp_upload_dir();
				$upload_path = $upload_dir['basedir'];
				$file_stylesheet = $upload_path . '/wp_edit_pro/custom_fonts/stylesheet/custom_fonts_styles.css';
			
				$content_url = network_site_url();
				$file_stylesheet_url = $content_url . 'wp-content/uploads/sites/'.$blog_id.'/wp_edit_pro/custom_fonts/';
			}
			else {
			
				$upload_dir = wp_upload_dir();
				$upload_path = $upload_dir['basedir'];
				$file_stylesheet = $upload_path . '/wp_edit_pro/custom_fonts/stylesheet/custom_fonts_styles.css';
			
				$content_url = content_url();
				$file_stylesheet_url = $content_url . '/uploads/wp_edit_pro/custom_fonts/';
			}
		}
		
		$write = '';
		
		foreach($custom_fonts as $key => $value) {
			
			$write .= "@font-face { \n";
				$write .= "\t" . "font-family: '" . $value . "'; \n";
				$write .= "\t" . "src: url('" .$file_stylesheet_url . $value . ".eot'); \n";
				$write .= "\t" . "src: url('" .$file_stylesheet_url . $value . ".eot?#iefix')  format('embedded-opentype'), \n";
				$write .= "\t\t" . "url('" .$file_stylesheet_url . $value . ".woff2')  format('woff2'), \n";
				$write .= "\t\t" . "url('" .$file_stylesheet_url . $value . ".woff')  format('woff'), \n";
				$write .= "\t\t" . "url('" .$file_stylesheet_url . $value . ".ttf')  format('truetype'), \n";
				$write .= "\t\t" . "url('" .$file_stylesheet_url . $value . ".svg#" . $value . "')  format('svg'); \n";
			$write .= "} \n\n";
		}
		
		$handle = fopen($file_stylesheet, 'w') or die('Cannot open file:  '.$file_stylesheet);
		$data = $write;
		fwrite($handle, $data);
		fclose($handle);
	}
	
	// If files were uploaded successfully
	if( $message === 'success' ) {
		
		function wp_edit_pro_custom_fonts_saved_notice_success(){
			
			echo '<div class="updated"><p>';
				_e('Custom Font options successfully saved.','wp_edit_pro');
			echo '</p></div>';
		}
		add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_custom_fonts_saved_notice_success' );
	}
	// Else files encountered error uploading
	else {
		
		function wp_edit_pro_custom_fonts_saved_notice_failure(){
			
			global $error_array;
		
			echo '<div class="error"><p>';
				_e('There was an error uploading the custom fonts. See below for errors:','wp_edit_pro');
				echo '<br />';
				
				if(isset($error_array) && !empty($error_array)) {
					
					foreach($error_array as $key) {
						
						echo $key . '<br />';
					}
				}
			echo '</p></div>';
		}
		add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_custom_fonts_saved_notice_failure' );
	}
}


/*
****************************************************************
Styles Tab
****************************************************************
*/
// If Predefined Options are being saved
if(isset($_POST['save_predefined_styles_opts'])) {
	
	// Get page options
	$plugin_opts['wp_edit_pro_styles']['add_predefined_styles'] = isset($_POST['add_predefined_styles']) ? '1' : '0';
	
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
		
	function wpep_save_predefined_styles_opts_notice(){
		
		echo '<div class="updated"><p>';
			_e('Options successfully saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_save_predefined_styles_opts_notice' );
}

// If Custom Styles are being saved
if(isset($_POST['hidden_save_style_submit'])) {
	
	// Get page variables
	$custom_title = isset($_POST['create_style_title']) ? sanitize_text_field( stripslashes_deep( $_POST['create_style_title'] ) ) : '';
	$custom_type = isset($_POST['create_style_type']) ? $_POST['create_style_type'] : '';
	$custom_element = isset($_POST['create_style_element']) ? $_POST['create_style_element'] : '';
	$custom_classes = isset($_POST['create_style_classes']) ? sanitize_text_field( $_POST['create_style_classes'] ) : '';
	$custom_styles = isset($_POST['create_style_styles']) ? sanitize_text_field( str_replace( ' ', '', $_POST['create_style_styles'] ) ) : '';
	$custom_wrapper = isset($_POST['create_style_wrapper']) ? $_POST['create_style_wrapper'] : '';
	
	// Build array from user options
	$save_array = array(
		array(
		'title' => $custom_title, 
		'type' => $custom_type, 
		'element' => $custom_element, 
		'classes' => $custom_classes, 
		'styles' => $custom_styles, 
		'wrapper' => $custom_wrapper
		)
	);
	
	// If the database already contains custom styles
	if($plugin_opts['wp_edit_pro_styles']['custom_styles']) {
		
		// If we are updating a style...
		// Loop through array and unset current array... because we will add it back and don't want to duplicate.
		foreach($plugin_opts['wp_edit_pro_styles']['custom_styles'] as $i => $style) {
			foreach($style as $key => $value) {
				if($key == 'title' && $value == $custom_title) {
					unset($plugin_opts['wp_edit_pro_styles']['custom_styles'][$i]);
				}
			}
		}
		
		// Now we can merge the updated array
		$plugin_opts['wp_edit_pro_styles']['custom_styles'] = array_merge($plugin_opts['wp_edit_pro_styles']['custom_styles'], $save_array);
	} else {
		
		$plugin_opts['wp_edit_pro_styles']['custom_styles'] = $save_array;
	}
	
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
	
	function wpeditpro_save_style_success_notice(){
		
		echo '<div class="updated"><p>';
			_e('Style successfully saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpeditpro_save_style_success_notice' );
}

// If Tinymce Editor Stylesheet is being saved
if(isset($_POST['save_custom_css_textarea'])) {
	
	$plugin_opts['wp_edit_pro_styles']['tinymce_custom_css'] = isset($_POST['custom_css']) ? stripslashes($_POST['custom_css']) : '';
	$plugin_opts['wp_edit_pro_styles']['tinymce_custom_css_parsed'] = isset($_POST['css_parser_output']) ? json_decode(stripslashes($_POST['css_parser_output'])) : '';
	
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
	
	$blog_id = get_current_blog_id();
	
	// Write option to file
	if( $this->network_activated == true && $this->network_blog_id !== '' ) {
		
		$file_path = WP_CONTENT_DIR.'/uploads/sites/'.$this->network_blog_id.'/wp_edit_pro/custom_styles/tinymce_custom_css.css';
	}
	else {
		
		if( is_multisite() == true && $blog_id !== 1 ) {
			
			$content_url = get_home_path();
			$file_path = $content_url . 'wp-content/uploads/sites/'.$blog_id.'/wp_edit_pro/custom_styles/tinymce_custom_css.css';
		}
		else {
			
			$file_path = WP_CONTENT_DIR.'/uploads/wp_edit_pro/custom_styles/tinymce_custom_css.css';
		}
	}
	
	// Set content
	$content = $plugin_opts['wp_edit_pro_styles']['tinymce_custom_css'];
		
	// Write content to file (empty file if no content)
	$create_file = fopen($file_path, 'w');
	fwrite($create_file, $content);
	fclose($create_file);
	chmod($file_path, 0644);
	
	function wpeditpro_save_custom_css_success_notice(){
		
		echo '<div class="updated"><p>';
			_e('Stylesheet successfully saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpeditpro_save_custom_css_success_notice' );
}


/*
****************************************************************
Snidgets Tab
****************************************************************
*/
if(isset($_POST['submit_widgets'])) {
	
	$plugin_opts['wp_edit_pro_widgets']['widget_builder'] = isset($_POST['widget_builder']) ? '1' : '0';
	
	// If user access roles exist
	if(isset($_POST['wpep_select_user_meta_roles_snidgets'])) {
		
		if($this->network_blog_id !== '') {
			
			switch_to_blog($this->network_blog_id);
			
			$roles = get_editable_roles();
			$roles_array = array();
			foreach($roles as $key2 => $value2) {
				$roles_array[] = $key2;
			}
			
			restore_current_blog();
		}
		else {
			
			$roles = get_editable_roles();
			$roles_array = array();
			foreach($roles as $key2 => $value2) {
				$roles_array[] = $key2;
			}
		}
		
		foreach($roles_array as $key => $value) {
			
			if($this->network_blog_id !== '') {
				
				switch_to_blog($this->network_blog_id);
				
				if(in_array($value, $_POST['wpep_select_user_meta_roles_snidgets'])) {
					
					$role = get_role($value);
					$role->add_cap('wp_edit_pro_user_administer_snidgets');
				}
				else {
					$role = get_role($value);
					$role->remove_cap('wp_edit_pro_user_administer_snidgets');
				}
				
				restore_current_blog();
			}
			else {
				
				if(in_array($value, $_POST['wpep_select_user_meta_roles_snidgets'])) {
					
					$role = get_role($value);
					$role->add_cap('wp_edit_pro_user_administer_snidgets');
				}
				else {
					$role = get_role($value);
					$role->remove_cap('wp_edit_pro_user_administer_snidgets');
				}
			}
		}
		
		$user_roles = array();
		foreach($_POST['wpep_select_user_meta_roles_snidgets'] as $key => $value) {
			$user_roles[] = $key;
		}
		
		$plugin_opts['wp_edit_pro_widgets']['wpep_select_user_meta_roles_snidgets'] = $user_roles;
	
		$this->options_array['wp_edit_pro_widgets']['wpep_select_user_meta_roles_snidgets'] = $plugin_opts['wp_edit_pro_widgets']['wpep_select_user_meta_roles_snidgets'];  // Update public variable
		$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	}
	// Else remove any saved roles
	else {
		
		// Get all roles and remove unique capability
		if( $this->network_blog_id !== '') {
			
			switch_to_blog( $this->network_blog_id );
			
			$roles = get_editable_roles();
			foreach( $roles as $key => $value ) {
				$role = get_role( $key );
				$role->remove_cap( 'wp_edit_pro_user_administer_snidgets' );
			}
			
			restore_current_blog();
		}
		else {
			
			$roles = get_editable_roles();
			foreach( $roles as $key => $value ) {
				$role = get_role( $key );
				$role->remove_cap( 'wp_edit_pro_user_administer_snidgets' );
			}
		}
		
		
		$plugin_opts['wp_edit_pro_widgets']['wpep_select_user_meta_roles_snidgets'] = array();
		
		$this->options_array['wp_edit_pro_widgets']['wpep_select_user_meta_roles_snidgets'] = array();  // Update public variable
		$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	}
	
	$this->network_activated == true ? wp_redirect(admin_url('/network/admin.php?page=wp_edit_pro_options&tab=widgets&widgets_updated=true')) : wp_redirect(admin_url('/admin.php?page=wp_edit_pro_options&tab=widgets&widgets_updated=true') );
}

// If save snidgets redirect was successful... let's alert a message
if(isset($_GET['widgets_updated']) && $_GET['widgets_updated'] == 'true') {
	
	function wp_edit_pro_snidgets_updated_message() {
		
		echo '<div id="message" class="updated"><p>';
			_e('Snidget options successfully saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_snidgets_updated_message' );
}

// If going to all snidgets
if(isset($_POST['submit_all_widgets'])) {
	
	$blog_id = isset( $_POST['each_blog_id'] ) ? $_POST['each_blog_id'] : '';
	
	if( $blog_id !== '' ) {
		
		switch_to_blog( $blog_id );
		$redirect_url = admin_url().'edit.php?post_type=jwl-utmce-widget';
		restore_current_blog();
	}
	else {
		$redirect_url = admin_url().'edit.php?post_type=jwl-utmce-widget';
	}
	
	wp_safe_redirect( $redirect_url );
	exit;
}

// If going to add new snidget
if(isset($_POST['submit_new_widget'])) {
	
	$blog_id = isset( $_POST['each_blog_id'] ) ? $_POST['each_blog_id'] : '';
	
	if( $blog_id !== '' ) {
		
		switch_to_blog( $blog_id );
		$redirect_url = admin_url().'post-new.php?post_type=jwl-utmce-widget';
		restore_current_blog();
	}
	else {
		$redirect_url = admin_url().'post-new.php?post_type=jwl-utmce-widget';
	}
	
	wp_safe_redirect( $redirect_url );
	exit;
}

// If going to snidget categories
if(isset($_POST['submit_widget_categories'])) {
	
	$blog_id = isset( $_POST['each_blog_id'] ) ? $_POST['each_blog_id'] : '';
	
	if( $blog_id !== '' ) {
		
		switch_to_blog( $blog_id );
		$redirect_url = admin_url().'edit-tags.php?taxonomy=category&post_type=jwl-utmce-widget';
		restore_current_blog();
	}
	else {
		$redirect_url = admin_url().'edit-tags.php?taxonomy=category&post_type=jwl-utmce-widget';
	}
	
	wp_safe_redirect( $redirect_url );
	exit;
}
	
// If going to snidget tags
if(isset($_POST['submit_widget_tags'])) {
	
	$blog_id = isset( $_POST['each_blog_id'] ) ? $_POST['each_blog_id'] : '';
	
	if( $blog_id !== '' ) {
		
		switch_to_blog( $blog_id );
		$redirect_url = admin_url().'edit-tags.php?taxonomy=post_tag&post_type=jwl-utmce-widget';
		restore_current_blog();
	}
	else {
		$redirect_url = admin_url().'edit-tags.php?taxonomy=post_tag&post_type=jwl-utmce-widget';
	}
	
	wp_safe_redirect( $redirect_url );
	exit;
}


/*
****************************************************************
User Specific Tab
****************************************************************
*/
if(isset($_POST['submit_user_specific'])) {

	global $current_user; 
	$options_user_specific_user_meta = get_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', true);
	
	// Check if switched to user meta
	if(isset($_POST['wpep_select_user_meta']) && $_POST['wpep_select_user_meta'] !== '') {
		$options_user_specific_user_meta = get_user_meta($_POST['wpep_select_user_meta'], 'aaa_wp_edit_pro_user_meta', true);
	}
	
	// Get page values
	$post_vars = isset($_POST['wp_edit_pro_user_specific']) ? $_POST['wp_edit_pro_user_specific'] : '';
	
	$options_user_specific_user_meta['id_column'] = isset($post_vars['id_column']) ? '1' : '0';
	$options_user_specific_user_meta['thumbnail_column'] = isset($post_vars['thumbnail_column']) ? '1' : '0';
	$options_user_specific_user_meta['hide_text_tab'] = isset($post_vars['hide_text_tab']) ? '1' : '0';
	$options_user_specific_user_meta['default_visual_tab'] = isset($post_vars['default_visual_tab']) ? '1' : '0';
	$options_user_specific_user_meta['dashboard_widget'] = isset($post_vars['dashboard_widget']) ? '1' : '0';
	
	$options_user_specific_user_meta['enable_highlights'] = isset($post_vars['enable_highlights']) ? '1' : '0';
	$options_user_specific_user_meta['draft_highlight'] = isset($post_vars['draft_highlight']) ? $post_vars['draft_highlight'] : '';
	$options_user_specific_user_meta['pending_highlight'] = isset($post_vars['pending_highlight']) ? $post_vars['pending_highlight'] : '';
	$options_user_specific_user_meta['published_highlight'] = isset($post_vars['published_highlight']) ? $post_vars['published_highlight'] : '';
	$options_user_specific_user_meta['future_highlight'] = isset($post_vars['future_highlight']) ? $post_vars['future_highlight'] : '';
	$options_user_specific_user_meta['private_highlight'] = isset($post_vars['private_highlight']) ? $post_vars['private_highlight'] : '';
	
	// Update user meta
	if(isset($_POST['wpep_select_user_meta']) && $_POST['wpep_select_user_meta'] !== '') {
		update_user_meta($_POST['wpep_select_user_meta'], 'aaa_wp_edit_pro_user_meta', $options_user_specific_user_meta);  // Update user meta
	}
	else {
		update_user_meta($current_user->ID, 'aaa_wp_edit_pro_user_meta', $options_user_specific_user_meta);  // Update user meta
	}
	
	// If user access roles exist
	if(isset($_POST['wpep_select_user_meta_roles'])) {
		
		if($this->network_blog_id !== '') {
			
			switch_to_blog($this->network_blog_id);
			
			$roles = get_editable_roles();
			$roles_array = array();
			foreach($roles as $key2 => $value2) {
				$roles_array[] = $key2;
			}
			
			restore_current_blog();
		}
		else {
			
			$roles = get_editable_roles();
			$roles_array = array();
			foreach($roles as $key2 => $value2) {
				$roles_array[] = $key2;
			}
		}
		
		foreach($roles_array as $key => $value) {
			
			if($this->network_blog_id !== '') {
				
				switch_to_blog($this->network_blog_id);
				
				if(in_array($value, $_POST['wpep_select_user_meta_roles'])) {
					
					$role = get_role($value);
					$role->add_cap('wp_edit_pro_user_administer_user_settings');
				}
				else {
					$role = get_role($value);
					$role->remove_cap('wp_edit_pro_user_administer_user_settings');
				}
				
				restore_current_blog();
			}
			else {
				
				if(in_array($value, $_POST['wpep_select_user_meta_roles'])) {
					
					$role = get_role($value);
					$role->add_cap('wp_edit_pro_user_administer_user_settings');
				}
				else {
					$role = get_role($value);
					$role->remove_cap('wp_edit_pro_user_administer_user_settings');
				}
			}
		}
		
		$user_roles = array();
		foreach($_POST['wpep_select_user_meta_roles'] as $key => $value) {
			$user_roles[] = $key;
		}
		
		$plugin_opts['wp_edit_pro_user']['wpep_select_user_meta_roles'] = $user_roles;
	
		$this->options_array['wp_edit_pro_user']['wpep_select_user_meta_roles'] = $plugin_opts['wp_edit_pro_user']['wpep_select_user_meta_roles'];  // Update public variable
		$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	}
	// Else remove any saved roles
	else {
		
		// Get all roles and remove unique capability
		if($this->network_blog_id !== '') {
			
			switch_to_blog($this->network_blog_id);
			
			$roles = get_editable_roles();
			foreach($roles as $key => $value) {
				$role = get_role($key);
				$role->remove_cap('wp_edit_pro_user_administer_user_settings');
			}
			
			restore_current_blog();
		}
		else {
			
			$roles = get_editable_roles();
			foreach($roles as $key => $value) {
				$role = get_role($key);
				$role->remove_cap('wp_edit_pro_user_administer_user_settings');
			}
		}
		
		
		$plugin_opts['wp_edit_pro_user']['wpep_select_user_meta_roles'] = array();
		
		$this->options_array['wp_edit_pro_user']['wpep_select_user_meta_roles'] = array();  // Update public variable
		$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	}
		
	function wpep_user_specific_saved_notice(){
		
		echo '<div class="updated"><p>';
			_e('User options successfully saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_user_specific_saved_notice' );
}


/*
****************************************************************
Extras Tab
****************************************************************
*/
if(isset($_POST['submit_extras'])) {
	
	$plugin_opts['wp_edit_pro_extras']['signoff_text'] = isset($_POST['wp_edit_pro_signoff']) ? stripslashes($_POST['wp_edit_pro_signoff']) : 'Please enter text here...';
	
	$plugin_opts['wp_edit_pro_extras']['enable_qr'] = isset($_POST['enable_qr']) ? '1' : '0';
	$plugin_opts['wp_edit_pro_extras']['enable_qr_widget'] = isset($_POST['enable_qr_widget']) ? '1' : '0';
	$plugin_opts['wp_edit_pro_extras']['qr_colors']['background_title'] = isset($_POST['qr_colors']['background_title']) ? str_replace('#', '', $_POST['qr_colors']['background_title']) : 'e2e2e2';
	$plugin_opts['wp_edit_pro_extras']['qr_colors']['background_content'] = isset($_POST['qr_colors']['background_content']) ? str_replace('#', '', $_POST['qr_colors']['background_content']) : 'dee8e4';
	$plugin_opts['wp_edit_pro_extras']['qr_colors']['qr_foreground_color'] = isset($_POST['qr_colors']['qr_foreground_color']) ? str_replace('#', '', $_POST['qr_colors']['qr_foreground_color']) : '000000';
	$plugin_opts['wp_edit_pro_extras']['qr_colors']['qr_background_color'] = isset($_POST['qr_colors']['qr_background_color']) ? str_replace('#', '', $_POST['qr_colors']['qr_background_color']) : 'c4d7ed';
	$plugin_opts['wp_edit_pro_extras']['qr_colors']['text_color'] = isset($_POST['qr_colors']['text_color']) ? str_replace('#', '', $_POST['qr_colors']['text_color']) : '120a23';
	$plugin_opts['wp_edit_pro_extras']['qr_colors']['title_text'] = isset($_POST['qr_colors']['title_text']) ? $_POST['qr_colors']['title_text'] : 'Enter title here...';
	$plugin_opts['wp_edit_pro_extras']['qr_colors']['content_text'] = isset($_POST['qr_colors']['content_text']) ? $_POST['qr_colors']['content_text'] : 'Enter content here...';
	
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);  // Update plugin option
	$this->options_array = $plugin_opts;  // Update public variable
		
	function wp_edit_pro_extras_saved_notice(){
		
		echo '<div class="updated"><p>';
			_e('Extra options saved.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_extras_saved_notice' );
}


/*
****************************************************************
Database Tab
****************************************************************
*/

// Reset options
if ( isset( $_POST['reset_db_values'] ) ) {
	
	$reset_nonce = isset( $_POST['database_action_reset_nonce'] ) ? $_POST['database_action_reset_nonce'] : '';
	
	if( ! wp_verify_nonce( $reset_nonce, 'database_action_reset_nonce' ) )
		die( 'This page for reseting options has failed the nonce check. Please ensure you have proper permissions to access this page.' );
	
	// Keep license information
	$plugin_defaults = $this->options_default;
	
	// Update (reset) plugin options
	if( $this->network_blog_id !== '' && $this->network_blog_id !== '1' ) {
		
		switch_to_blog( $this->network_blog_id );
		
		// Reset user meta
		$users = get_users();
		foreach( $users as $key => $value ) {
			
			delete_user_meta( $value->data->ID, 'aaa_wp_edit_pro_user_meta' );
		}
		
		// Remove custom roles
		$roles = get_editable_roles();
		foreach($roles as $key => $value) {
			$role = get_role($key);
			$role->remove_cap('wp_edit_pro_user_administer_snidgets');
			$role->remove_cap('wp_edit_pro_user_administer_user_settings');
		}
		
		// Reset options
		update_option( 'wp_edit_pro_options_array', $plugin_defaults );
		
		// Get base directory
		$upload_dir = wp_upload_dir();
		$upload_path = $upload_dir['basedir'];
		$handle = $upload_path . '/sites/' . $this->network_blog_id . '/wp_edit_pro/';
		
		restore_current_blog();
	}
	else {
		
		// Reset user meta
		$users = get_users();
		foreach( $users as $key => $value ) {
			
			delete_user_meta( $value->data->ID, 'aaa_wp_edit_pro_user_meta', true );
		}
		
		// Remove custom roles
		$roles = get_editable_roles();
		foreach($roles as $key => $value) {
			$role = get_role($key);
			$role->remove_cap('wp_edit_pro_user_administer_snidgets');
			$role->remove_cap('wp_edit_pro_user_administer_user_settings');
		}
		
		// Reset options
		$this->wp_edit_pro_options_array = $plugin_defaults;  // Update public variable
		$this->update_wp_edit_pro_option( 'wp_edit_pro_options_array', $plugin_defaults );  // Update plugin option
		
		// Get base directory
		$upload_dir = wp_upload_dir();
		$upload_path = $upload_dir['basedir'];
		$handle = $upload_path . '/wp_edit_pro/';
	}
		
	// Delete custom stylesheets
	if( file_exists( $handle . 'custom_styles/tinymce_custom_css.css' ) ) 
		unlink( $handle . 'custom_styles/tinymce_custom_css.css' );
		
	if( file_exists( $handle . 'custom_fonts/stylesheet/custom_fonts_styles.css' ) ) 
		unlink( $handle . 'custom_fonts/stylesheet/custom_fonts_styles.css' );
	
	// Delete custom uploaded fonts
	$files = glob( $handle . 'custom_fonts/*' ); // Get all file names
	foreach( $files as $file ){ 
		if( is_file( $file ) )
			unlink( $file ); 
	}
	
	// Alert user
	function wp_edit_pro_settings_restored_notice(){

		echo '<div id="message" class="updated"><p>';
			_e('Plugin settings have been successfully restored to their default values.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_settings_restored_notice' );
}

// Convert options (from database tab OR from welcome message)
if (isset($_POST['convert_db_values']) || isset($_POST['convert_db_values_welcome'])) {
	
	global $wpdb;
	
	// Get old plugin options
	$options_global = $this->get_wp_edit_pro_option('wp_edit_global');	
	$options_general = $this->get_wp_edit_pro_option('wp_edit_general');
	$options_posts = $this->get_wp_edit_pro_option('wp_edit_posts');
	$options_editor = $this->get_wp_edit_pro_option('wp_edit_editor');
	$options_extras = $this->get_wp_edit_pro_option('wp_edit_extras');
	
	// Check old plugin options (if not exist; use new plugin default values)
	$options_global = isset($options_global) && is_array($options_global) ? $options_global : $this->options_default['wp_edit_pro_global'];
	$options_general = isset($options_general) && is_array($options_general) ? $options_general : $this->options_default['wp_edit_pro_general'];
	$options_posts = isset($options_posts) && is_array($options_posts) ? $options_posts : $this->options_default['wp_edit_pro_posts'];
	$options_editor = isset($options_editor) && is_array($options_editor) ? $options_editor : $this->options_default['wp_edit_pro_editor'];
	$options_extras = isset($options_extras) && is_array($options_extras) ? $options_extras : $this->options_default['wp_edit_pro_extras'];
	
	// Get new plugin option
	$new_option = $this->options_array;
	
	// Set new plugin options with old values
	$new_option['wp_edit_pro_global'] = $options_global;
	$new_option['wp_edit_pro_general'] = $options_general;
	$new_option['wp_edit_pro_posts'] = $options_posts;
	$new_option['wp_edit_pro_editor'] = $options_editor;
	$new_option['wp_edit_pro_extras'] = $options_extras;
	
	// Set first install to false
	$new_option['wpep_first_install'] = 'false';
	
	// Update new plugin option
	$this->options_array = $new_option;  // Update public variable
	$this->update_wp_edit_pro_option('wp_edit_pro_options_array', $new_option);  // Update plugin option
	
	// Alert user
	function wp_edit_pro_settings_converted_notice(){

		echo '<div id="message" class="updated"><p>';
		_e('Plugin settings have been successfully converted.','wp_edit_pro');
		echo '</p><p>';
		_e('Delete old WP Edit plugin options?','wp_edit_pro');
		echo '</p>';
		echo '<form action="" method="post">';
		echo '<input type="submit" value="Yes" name="wpep_convert_del_old_yes" class="button-secondary" />';
		echo '<span style="margin-right:20px;"></span>';
		echo '<input type="submit" value="No" name="wpep_covert_del_old_no" class="button-secondary" />';
		echo '</form>';
		echo '<br />';
		echo '</div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_settings_converted_notice' );
}
// Delete old plugin options (during convert process)
if(isset($_POST['wpep_convert_del_old_yes']) && ($_POST['wpep_convert_del_old_yes'] === 'Yes')) {
	
	$this->delete_wp_edit_pro_option('wp_edit_buttons');
	$this->delete_wp_edit_pro_option('wp_edit_global');
	$this->delete_wp_edit_pro_option('wp_edit_general');
	$this->delete_wp_edit_pro_option('wp_edit_posts');
	$this->delete_wp_edit_pro_option('wp_edit_editor');
	$this->delete_wp_edit_pro_option('wp_edit_extras');
	
	// Alert user
	function wp_edit_pro_old_settings_deleted_notice(){

		echo '<div id="message" class="updated"><p>';
		_e('Old WP Edit plugin settings have been successfully deleted.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_old_settings_deleted_notice' );
}
// Keep old plugin options (during convert process)
if(isset($_POST['wpep_covert_del_old_no']) && ($_POST['wpep_covert_del_old_no'] === 'No')) {
	
	// Alert user
	function wp_edit_pro_old_settings_not_deleted_notice(){

		echo '<div id="message" class="updated"><p>';
		_e('Old WP Edit plugin settings have been left untouched in the database.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_old_settings_not_deleted_notice' );
}

// Export options
if(isset($_POST['database_action']) && $_POST['database_action'] == 'export_settings') {
	
	$export_nonce = isset( $_POST['database_action_export_nonce'] ) ? $_POST['database_action_export_nonce'] : '';
	
	if( ! wp_verify_nonce( $export_nonce, 'database_action_export_nonce' ) )
		die( 'This page for exporting options has failed the nonce check. Please ensure you have proper permissions to access this page.' );
		
	$blog_id = '';
	
	// Check if a subsite is being administered
	if( $this->network_blog_id !== '' ) {
		
		switch_to_blog( $this->network_blog_id );
		
		$blog_id = '_blog_id_' . $this->network_blog_id;
		$options_export_array = get_option( 'wp_edit_pro_options_array' );
		
		// Get user meta options
		$users = get_users();
		$user_meta_array = array( 'wpep_user_meta' => array() );
		
		foreach( $users as $key => $value ) {
			
			$user_meta = get_user_meta( $value->data->ID, 'aaa_wp_edit_pro_user_meta', true );
			if( !empty( $user_meta ) ) {
				
				$user_meta_array['wpep_user_meta'][$value->data->ID] = $user_meta;
			}
		}
		
		restore_current_blog();
	}
	else {
	
		// Get plugin options
		$options_export_array = $this->get_wp_edit_pro_option( 'wp_edit_pro_options_array' );
	
		// Get user meta options
		$users = get_users();
		$user_meta_array = array( 'wpep_user_meta' => array() );
		
		foreach( $users as $key => $value ) {
			
			$user_meta = get_user_meta( $value->data->ID, 'aaa_wp_edit_pro_user_meta', true );
			if( !empty( $user_meta ) ) {
				
				$user_meta_array['wpep_user_meta'][$value->data->ID] = $user_meta;
			}
		}
	}
	
	// Merge user meta options with plugin options
	if( !empty( $user_meta_array ) ) {
		
		$options_export_array = array_merge( $options_export_array, $user_meta_array );
	}
		
	// Send file to browser
	ignore_user_abort( true );
	 
	nocache_headers();
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=wp_edit_pro_settings_export' . $blog_id . '_date-' . date( 'm-d-Y' ) . '.json' );
	header( "Expires: 0" );
	
	// Echo array (file) to download
	echo json_encode( $options_export_array );
	exit;
}

// Import plugin options
if( isset( $_POST['database_action'] ) && 'import_settings' == $_POST['database_action'] ) {
 	
	// Check nonce
	if( ! wp_verify_nonce( $_POST['database_action_import_nonce'], 'database_action_import_nonce' ) )
		die( 'This page for importing options has failed the nonce check. Please ensure you have proper permissions to access this page.' );
	
	// Get file extension
	$file = explode( '.', $_FILES['import_file']['name'] );
	$extension = end( $file );
	
	// Check file extension
	if( $extension != 'json' ) {
		
		function wpep_import_failed_invalid_extension_notice(){
			
			echo '<div class="error"><p>';
			_e('Import failed. Please select a file with a valid .json extension.','wp_edit_pro');
			echo '</p></div>';
		}
		add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_import_failed_invalid_extension_notice' );
		return;
	}
	
	// Get file
	$import_file = $_FILES['import_file']['tmp_name'];
	
	// If no file found
	if( empty( $import_file ) ) {
		
		function wpep_import_failed_no_file_notice(){
			
			echo '<div class="error"><p>';
			_e('Import failed. Please select a file to import.','wp_edit_pro');
			echo '</p></div>';
		}
		add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_import_failed_no_file_notice' );
		return;
	}
	
	// Retrieve the settings from the file and convert the json object to an array.
	$settings = (array) json_decode( file_get_contents( $import_file ), true );
	
	// Check if a subsite is being administered
	if( $this->network_blog_id !== '' ) {
		
		switch_to_blog($this->network_blog_id);
	
		// Check for user meta button array (import to user by id)
		if( isset( $settings['wpep_user_meta'] ) ) {
			
			foreach( $settings['wpep_user_meta'] as $user_id => $user_meta_array ) {
				
				// Get current user meta
				update_user_meta( $user_id, 'aaa_wp_edit_pro_user_meta', $user_meta_array );
			}
			
			// Unset user meta array item
			unset( $settings['wpep_user_meta'] );
		}
		
		update_option( 'wp_edit_pro_options_array', $settings );  // Update plugin option
		
		restore_current_blog();
	}
	else {
		
		// Check for user meta button array (import to user by id)
		if( isset( $settings['wpep_user_meta'] ) ) {
			
			foreach( $settings['wpep_user_meta'] as $user_id => $user_meta_array ) {
				
				// Get current user meta
				update_user_meta( $user_id, 'aaa_wp_edit_pro_user_meta', $user_meta_array );
			}
			// Unset user meta array item
			unset( $settings['wpep_user_meta'] );
		}
		
		$this->update_wp_edit_pro_option( 'wp_edit_pro_options_array', $settings );  // Update plugin option
	}
	
	$this->options_array = $settings;
	 
	// Redirect to database page with added parameter = true
	$this->network_activated == true ?  wp_redirect(admin_url('network/admin.php?page=wp_edit_pro_options&tab=database&import=true')) : wp_redirect(admin_url('admin.php?page=wp_edit_pro_options&tab=database&import=true')); 
	
	exit;
}
// If import is successful; let's alert user
if(isset($_GET['import']) && $_GET['import'] === 'true') {

	function wp_edit_pro_import_notice_success() {
		
		echo '<div id="message" class="updated"><p>';
		_e('Plugin settings have been successfully imported.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_import_notice_success' );
}

// Uninstall plugin
if (isset($_POST['uninstall'], $_POST['uninstall_confirm'] ) ) {

	if ( !isset($_POST['wp_edit_pro_uninstall_nonce']) || !wp_verify_nonce($_POST['wp_edit_pro_uninstall_nonce'],'wp_edit_pro_uninstall_nonce_check') ) {  // Verify nonce
			
		print 'Sorry, your nonce did not verify.';
		exit;
	}
	else {
		
		// Call API to remove db activation entry
		$this->wp_edit_pro_api_call('uninstall_plugin', '');
		
		// Delete site options
		$this->delete_wp_edit_pro_option('wp_edit_pro_options_array');
		
		// Delete user meta custom editors (fifth arg deletes all users metadata matching that key)
		delete_metadata( 'user', 0, 'aaa_wp_edit_pro_user_meta', '', true );
		
		
		// Remove custom roles
		$roles = get_editable_roles();
		foreach($roles as $key => $value) {
			$role = get_role($key);
			$role->remove_cap('wp_edit_pro_user_administer_snidgets');
			$role->remove_cap('wp_edit_pro_user_administer_user_settings');
			$role->remove_cap('wp_edit_pro_user_admin_page');
		}
		
		// If deleting subsite data
		if(isset($_POST['uninstall_confirm_subsites'])) {
			
			$site_ids = array();
			
			if( $this->wp_version < '4.6.0' ) {
				
				$get_sites = wp_get_sites();
				foreach ($get_sites as $get_site) {
					$site_ids[] = $get_site['blog_id'];
				}
			}
			else {
			
				$get_sites = get_sites();
				foreach ($get_sites as $get_site) {
					$site_ids[] = $get_site->blog_id;
				}
			}
			
			// Loop each site id and delete options
			foreach ($site_ids as $site_id) {
				
				switch_to_blog($site_id);
				
				delete_option('wp_edit_pro_options_array');
				
				// Delete user meta custom editors (fifth arg deletes all users metadata matching that key)
				delete_metadata( 'user', 0, 'aaa_wp_edit_pro_user_meta', '', true );
		
				// Remove custom roles
				$roles = get_editable_roles();
				foreach($roles as $key => $value) {
					$role = get_role($key);
					$role->remove_cap('wp_edit_pro_user_administer_snidgets');
					$role->remove_cap('wp_edit_pro_user_administer_user_settings');
					$role->remove_cap('wp_edit_pro_user_admin_page');
				}
				
				restore_current_blog();
			}
		}
	 
		// Deactivate the plugin
		$current = ( $this->network_activated == true ) ? get_site_option('active_sitewide_plugins') : get_option('active_plugins');
		array_splice($current, array_search( $_POST['plugin'], $current), 1 );
		$this->network_activated == true ? update_site_option('active_sitewide_plugins', $current)  : update_option('active_plugins', $current);
		
		// Redirect to plugins page with 'plugin deactivated' status message
		$this->network_activated == true ? wp_redirect(admin_url('/network/plugins.php?deactivate=true')) : wp_redirect(admin_url('/plugins.php?deactivate=true'));
		exit;
	}
}
// Display notice if trying to uninstall but forget to check box
if ((isset($_POST['uninstall']) && !isset($_POST['uninstall_confirm'])) || (isset($_POST['uninstall_network']) && !isset($_POST['uninstall_confirm_network']))) {
	
	function wp_edit_pro_uninstall_error_notice() {
		
		echo '<div id="message" class="error"><p>';
		_e('You must also check the confirm box before options will be uninstalled and deleted.','wp_edit_pro');
		echo '</p></div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wp_edit_pro_uninstall_error_notice' );
}
