<?php

/*
****************************************************************
QR post/page metabox global variable
****************************************************************
*/
$wpep_qr_metaboxes = array(  // Build metabox

	'id' => 'jwl-meta-box',
	'title' => __('WP Edit Pro QR Code', 'wp_edit_pro'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array( // Set fields for saving
		array(
			'name' => __('QR Title:', 'wp_edit_pro'),
			'id' => 'jwl_' . 'qr_meta_title',
			'type' => 'input'
		),
		array(
			'name' => __('QR Content:', 'wp_edit_pro'),
			'id' => 'jwl_' . 'qr_meta_content',
			'type' => 'textarea'
		),
		array(
			'name' => __('Disable QR for this post/page:', 'wp_edit_pro'),
			'id' => 'jwl_' . 'qr_meta_checkbox',
			'type' => 'checkbox',
			'desc' => __('Disables QR only for this post/page.', 'wp_edit_pro')
		),
		array(
			'name' => __('Use Shortcode Instead', 'wp_edit_pro'),
			'id' => 'jwl_' . 'qr_meta_checkbox_shortcode',
			'type' => 'checkbox',
			'desc' => __('Insert QR Code with a Shortcode. (Disables auto-insertion)', 'wp_edit_pro').'<br /><span style="margin-right:25px;"></span><em>'.__('Use Shortcode: [wpeditpro_qr_shortcode]', 'wp_edit_pro').'</em>'
		)
	)
);
/*
****************************************************************
QR widget class extension
****************************************************************
*/
	
class WpEditProQrWidget extends WP_Widget {
	
	function WpEditProQrWidget() {
		
		parent::__construct(
			'WpEditProQrWidget', // Base ID
			__('WP Edit QR Code','wp_edit_pro'), // Name
			array( 'description' => __('Use WP Edit QR Codes in a widget area.', 'wp_edit_pro') ) // Args
		);
	}
	
	function form( $instance ) {
		
		// Output admin widget options form
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'qr_title' => '', 'qr_content' => '' ) );
		
		$title = esc_attr($instance['title']);
		$qr_title = esc_attr($instance['qr_title']);
		$qr_content = esc_attr($instance['qr_content']);
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title:','wp_edit_pro' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'qr_title' ); ?>"><?php _e( 'QR Title:','wp_edit_pro' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'qr_title' ); ?>" name="<?php echo $this->get_field_name( 'qr_title' ); ?>" type="text" value="<?php echo esc_attr( $qr_title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'qr_content' ); ?>"><?php _e( 'QR Content Text:','wp_edit_pro' ); ?></label><br />
		<textarea class="widefat" style="width:100%;height:40px;" id="<?php echo $this->get_field_id( 'qr_content' ); ?>" name="<?php echo $this->get_field_name( 'qr_content' ); ?>"><?php echo esc_attr( $qr_content ); ?></textarea>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		
		// Save widget options
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['qr_title'] = $new_instance['qr_title'];
		$instance['qr_content'] = $new_instance['qr_content'];
		
		return $instance;
	}	

	function widget( $args, $instance ) {
		
		// Get plugin default values
		$plugin_options = get_wp_edit_pro_option_normal('wp_edit_pro_options_array');
		
		// Widget output
		extract($args);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$qr_title = empty($instance['qr_title']) ? $plugin_options['wp_edit_pro_extras']['qr_colors']['title_text'] : $instance['qr_title'];
		$qr_content = empty($instance['qr_content']) ? $plugin_options['wp_edit_pro_extras']['qr_colors']['content_text'] : $instance['qr_content'];
		
		$options_qr_colors = $plugin_options['wp_edit_pro_extras']['qr_colors'];
		
		echo $before_widget;
		if (!empty($title)) { 
			echo $before_title . $title . $after_title; 
		};
		
		echo '<div class="jwl_qr_box">';
			echo '<div class="jwl_qr_header" style="background:#'.$options_qr_colors['background_title'].';color:#'.$options_qr_colors['text_color'].';padding:5px;">';
			
					echo '<span class="jwl_qr_header_text">'.$qr_title.'</span>';
			echo '</div>';
			
			echo '<div class="jwl_qr_main" style="background:#'.$options_qr_colors['background_content'].';color:#'.$options_qr_colors['text_color'].';padding:5px;">';
			
				echo '<div class="jwl_qr_image" style="float:left;margin-right:10px;">';
					echo '<script type="text/javascript">var uri=window.location.href;document.write("<img width=\'75px\' height=\'75px\' style=\'width:75px;height:75px;\' src=\'//api.qrserver.com/v1/create-qr-code/?data="+encodeURI(uri)+"&size=75x75&color='.$options_qr_colors['qr_foreground_color'].'&bgcolor='.$options_qr_colors['qr_background_color'].'\'/>");</script>';
				echo '</div>';
				
					echo '<div class="jwl_qr_content">'.$qr_content;
				echo'</div>';
				
				echo '<div style="clear:both;">';
				echo '</div>';
				
			echo '</div>';
		echo '</div>';
		
		echo $after_widget;
	}	
}