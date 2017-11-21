<?php

$status = $this->get_wp_edit_pro_option( 'wp_edit_pro_license_status' );
$transid = $this->get_wp_edit_pro_option(' wp_edit_pro_license_transid' );
		
// Get page form values
$post_transid = isset( $_POST['wp_edit_pro_license_transid'] ) ?  sanitize_text_field( $_POST['wp_edit_pro_license_transid'] ) : '';
$user_ip = isset( $_POST['wp_edit_pro_license_ip'] ) ? $_POST['wp_edit_pro_license_ip'] : 'Unknown';


//*********************************************
// If we are saving license details
//*********************************************
if( isset( $_POST['save_license_changes'] ) ) {

	// Temporarily update license status to remove any error notices
	$this->update_wp_edit_pro_option( 'wp_edit_pro_license_status', 'processing' );
	$this->update_wp_edit_pro_option( 'wp_edit_pro_license_transid', $post_transid );
	
	// If a field is empty
	if ( empty( $post_transid ) || $post_transid == false ) {
		
		// Alert user
		function wpep_license_blank_field() {
			
			echo '<div class="error">';
				echo '<h4>';
					_e('Please enter the transaction ID and click "Save License" again.', 'wp_edit_pro');
				echo '</h4>';
			echo '</div>';
		}
		add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_license_blank_field' );
		
		// Update database
		$this->update_wp_edit_pro_option( 'wp_edit_pro_license_status', 'invalid' );
	}
	
	// Alert save successful
	else {
		
		// Call API function to get $response
		$response = $this->wp_edit_pro_api_call( 'activate_license', $user_ip );
		
		// If there was an error communicating
		if ( is_wp_error( $response ) ) {
			
			global $error_code, $error_message;
			$error_code = $response->get_error_code();
			$error_message = $response->get_error_message();
			
			// Alert user
			function wpep_activation_error() {
				
				global $error_code, $error_message;
				
				echo '<div class="error">';
					echo '<h4>';
						_e( 'Error Code:', 'wp_edit_pro' ); echo ' '.$error_code;
						echo '<br />';
						_e( 'Error Message:', 'wp_edit_pro' ); echo ' '.$error_message;
					echo '</h4>';
					echo '<p>';
						_e( 'The server is having trouble communicating with the activation script. Please contact us for assistance.', 'wp_edit_pro' );
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_activation_error' );
		}
		
		// Else if the response is invalid
		else if( ! is_object( json_decode( wp_remote_retrieve_body( $response ) ) ) ) {
		
			// Alert user
			function wpep_activation_error_no_object() {
				
				echo '<div class="error">';
					echo '<p>';
						_e('Error: This activation is not returning a valid object from the script.','wp_edit_pro');
						echo '<br />';
						_e('The server is having trouble communicating with the activation script. Please contact us for assistance.', 'wp_edit_pro');
					echo '</p>';
				echo '</div>';
			}
			add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_activation_error_no_object' );
		}
		
		// Else the response is valid
		else {
			
			// Decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			
			// Update database
			$this->update_wp_edit_pro_option( 'wp_edit_pro_license_status', $license_data->Status );
			
			
			
			//****************************************
			// Perform additional validation checks
			//****************************************
			
			// If invalid transaction id (status message)
			if ( $license_data->Status === 'no_matching_records' ) {
				
				// Update database
				$this->update_wp_edit_pro_option( 'wp_edit_pro_license_status', 'invalid' );
				
				// Alert user
				function wpep_no_matching_records() {
					
					echo '<div class="error">';
						echo '<p>';
							_e('The submitted transaction ID is not valid.', 'wp_edit_pro');
							echo '<br />';
							_e('Please verify the transaction ID; then click "Save License" again.', 'wp_edit_pro');
						echo '</p>';
					echo '</div>';
				}
				add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_no_matching_records');
			}
			
			// If this is a single site license on a network activation
			else if ( ( $license_data->Status === 'single_act' || $license_data->Status === 'single_ext_act' ) && $this->network_activated == true ) {
				
				// Update database
				$this->update_wp_edit_pro_option( 'wp_edit_pro_license_status', 'invalid' );
				
				// Alert user
				function wpep_invalid_sng_act() {
	
					echo '<div class="error">';
						echo '<p>';
							_e('Invalid License. This is a Single Site license; and is attempting to be network activated.', 'wp_edit_pro');
							echo '<br />';
							_e('If you would like to network activate this plugin; an upgrade to a Multi or Developer license will be necessary.', 'wp_edit_pro');
						echo '</p>';
					echo '</div>';
				}
				add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_invalid_sng_act' );
			}
			
			// If this is a single account error
			else if( $license_data->Status === 'single_act_error' ) {
				
				// Update database
				$this->update_wp_edit_pro_option( 'wp_edit_pro_license_status', 'invalid' );
				
				// Alert user
				function wpep_sng_act_err() {
	
					echo '<div class="error">';
						echo '<p>';
							_e('This is a Single Site license; and has been activated the maximum number of times.', 'wp_edit_pro');
							echo '<br />';
							_e('If you would like to use this plugin on more sites; an upgrade to a Multi or Developer license will be necessary.', 'wp_edit_pro');
						echo '</p>';
					echo '</div>';
				}
				add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_sng_act_err' );
			}
			
			// If this is a single extended account error
			else if( $license_data->Status === 'single_ext_act_error' ) {
				
				// Update database
				$this->update_wp_edit_pro_option( 'wp_edit_pro_license_status', 'invalid' );
				
				function wpep_sng_ext_act_err() {
	
					echo '<div class="error">';
						echo '<p>';
							_e('This is a Single Site Extended license; and has been activated the maximum number of times.', 'wp_edit_pro');
							echo '<br />';
							_e('If you would like to use this plugin on more sites; an upgrade to a Multi or Developer license will be necessary.', 'wp_edit_pro');
						echo '</p>';
					echo '</div>';
				}
				add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_sng_ext_act_err' );
			}
			
			// Else plugin was activated successfully
			else {
				
				$this->network_activated == true ? wp_redirect( admin_url( 'network/admin.php?page=wp_edit_pro_license&activation=true' ) ) : wp_redirect( admin_url( 'admin.php?page=wp_edit_pro_license&activation=true' ) );
			}
		}
	}
}

// If we are removing this site activation
if( isset( $_POST['remove_this_activation'] ) ) {
	
	// Call API function to get $response
	$response = $this->wp_edit_pro_api_call( 'uninstall_plugin', $user_ip );
	
	$this->update_wp_edit_pro_option( 'wp_edit_pro_license_status', 'invalid' );
	
	function wpep_remove_activation_success() {
				
		echo '<div class="updated">';
			echo '<p>';
				_e('This site activation has been successfully removed from our activations table.', 'wp_edit_pro');
			echo '</p>';
		echo '</div>';
	}
	add_action( $this->network_activated == true ? 'network_admin_notices' : 'admin_notices', 'wpep_remove_activation_success' );
}