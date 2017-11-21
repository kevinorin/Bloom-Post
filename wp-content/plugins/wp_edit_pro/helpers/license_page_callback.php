<?php

$status = $this->get_wp_edit_pro_option('wp_edit_pro_license_status');
$transid = $this->get_wp_edit_pro_option('wp_edit_pro_license_transid');

// Get user ip
if (isset($_SERVER['REMOTE_ADDR'])) {
	$user_ip 	= $_SERVER['REMOTE_ADDR'];
}

// Check activation message (from page save function below)
if (isset($_GET['activation'])) {
	
	if($_GET['activation'] === 'true') {
		
		echo '<div class="updated">';
			echo '<h4>';
				_e('Activation successful.', 'wp_edit_pro');
			echo '</h4>';
		echo '</div>';
	}
}

// Begin License Page
echo '<div class="metabox">';
	echo '<h2>';
		_e('Welcome to WP Edit Pro', 'wp_edit_pro');
	echo '</h2>';
	echo '<p>';
		_e('Please enter the transaction ID below; then click "Save License" to continue.', 'wp_edit_pro');
		echo '<br />';
		_e('The transaction ID can be found in the "Welcome Email", sent after purchase.', 'wp_edit_pro');
	echo '</p>';
	
	echo '<p>';
		_e('Trouble Activating? We can help! <a target="_blank" href="https://wpeditpro.com/contact/">Contact Us</a> for assistance.','wp_edit_pro');
	echo '</p>';
echo '</div>';


echo '<div class="metabox">';
	echo '<h2>';
		_e('License Information', 'wp_edit_pro');
	echo '</h2>';
	?>
	<form method="post" action="">
	<div class="metabox-holder"> 
		<div class="postbox">
			<div class="inside">
					
				<table class="form-table">
				<tbody>
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Transaction ID','wp_edit_pro'); ?>
					</th>
					<td>
						<input style="width:400px;" id="wp_edit_pro_license_transid" name="wp_edit_pro_license_transid" class="regular-text" value="<?php echo $transid; ?>" /><br />
						<?php _e('Example:','wp_edit_pro'); ?><span style="margin-left:5px;color:#666;font-weight:bold;"><em><?php _e('5252331315781000C','wp_edit_pro'); ?></em></span>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<input id="wp_edit_pro_license_ip" name="wp_edit_pro_license_ip" type="hidden" class="regular-text" value="<?php echo $user_ip; ?>" />
					</td>
				</tr>
				</tbody>
				</table>
				
				<input type="submit" value="<?php _e('Save License', 'wp_edit_pro'); ?>" class="button button-primary" id="save_license_changes" name="save_license_changes" title="<?php _e('Save license information and display Activation button.', 'wp_edit_pro'); ?>" />
				<span style="margin-left: 20px;"></span>
				<input type="button" class="button button-secondary" onclick="window.open('https://wpeditpro.com/license_activations/', '_blank');" value="<?php _e('Manage License','wp_edit_pro'); ?>" title="<?php _e('Manage all site activations.', 'wp_edit_pro'); ?>" />
				<span style="margin-left: 20px;"></span>
				<input type="submit" value="<?php _e('Remove This Activation', 'wp_edit_pro'); ?>" class="button button-secondary" id="remove_this_activation" name="remove_this_activation" title="<?php _e('Remove this site activation.', 'wp_edit_pro'); ?>" />
			</div>
		</div>
	</div>
	
	<h2><?php _e('License Status', 'wp_edit_pro'); ?></h2>              
	<div class="metabox-holder"> 
		<div class="postbox">
			
			<div class="inside">       
					
				<table class="form-table">
				<tbody>
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Plugin Status',''); ?>
					</th>
					<td>
						<?php
						if(isset($status) && $status == 'single_act' || $status == 'single_ext_act' || $status == 'multi_act' || $status == 'dev_act') {
							
							echo '<span class="plugin_status_active">';
							_e('Active','wp_edit_pro');
						} 
						else {
							
							echo '<span class="plugin_status_inactive">';
							_e('Not Activated', 'wp_edit_pro');
						}
						
						if ($status == 'single_act') { _e(' - Single Site License', 'wp_edit_pro'); }
						if ($status == 'single_ext_act') { _e(' - Single Extended Site License', 'wp_edit_pro'); }
						if ($status == 'multi_act') { _e(' - Multi Site License', 'wp_edit_pro'); }
						if ($status == 'dev_act') { _e(' - Developer Site License', 'wp_edit_pro'); }
						
						echo '</span>';
						?>
					</td>
				</tr>
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Purchase','wp_edit_pro'); ?>
					</th>
					<td>
						<a target="_blank" href="https://wpeditpro.com/"><?php _e('Purchase WP Edit Pro', 'wp_edit_pro'); ?></a>
					</td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
	
	</form>
	<?php
echo '</div>';