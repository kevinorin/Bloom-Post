<?php
if ( ! function_exists( 'is_plugin_active_for_network' ) ) { require_once( ABSPATH . '/wp-admin/includes/plugin.php' ); }
$plugin_network_activated = is_plugin_active_for_network( 'wp_edit_pro/main.php' ) ? true : false;

$site_opts = get_site_option( 'wp_edit_pro_options_array' );
$network_mode = isset( $site_opts['wp_edit_pro_network']['wpep_network_admin_mode'] ) ? $site_opts['wp_edit_pro_network']['wpep_network_admin_mode'] : 'same';

if( $plugin_network_activated == true && $network_mode = 'same' ) {
	
	$plugin_opts = $site_opts;
}
else {
	
	$plugin_opts = get_option('wp_edit_pro_options_array');
}

if(isset($plugin_opts['wp_edit_pro_widgets']['widget_builder']) && $plugin_opts['wp_edit_pro_widgets']['widget_builder'] == 1) {
	
	/*
	****************************************************************
	Snidget Widget extension
	****************************************************************
	*/
		
	// Register class for widget page in admin panel
	class JWL_UTMCE_Widgets_Widget extends WP_Widget
	{
		public function __construct() {
			
			parent::__construct(
				'jwl_utmce_widgets_widget', // Base ID
				__('WP Edit Snidget','wp_edit_pro'), // Name
				array( 'description' => __('Select one of your "WP Edit Snidgets" and display in a widget area.', 'wp_edit_pro') ) // Args
			);
		}
	
		/**
		 * Front-end display of widget.
		 * @see WP_Widget::widget()
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			
			extract( $args );
			$id = $instance['jwl-utmce-widget-id'];
			$apply_filters = isset($instance['apply_filters']) ? $instance['apply_filters'] : 'off';
	
			$title = apply_filters( 'widget_title', $instance['title_front'] );
			$post = get_post($id);
	
			echo $before_widget;
			if(!empty($title)) { echo $before_title . $title . $after_title; }
	
			if($post && !empty($id)) {
				
				if(isset($apply_filters) && ($apply_filters == 'on')) {
					$content = apply_filters('the_content', $post->post_content);  // This will allow other plugins to add content to the 'the_content' filter.
				} else {
					$content = $post->post_content;  // This will ONLY display the text created in the widget CPT.
				}
				
				echo $content;		
			} else {
				if(current_user_can('manage_options')) { ?>
					<p style="color:red;">
						<strong><?php _e('ADMINS ONLY NOTICE:', 'wp_edit_pro'); ?></strong>
						<?php if(empty($id)) {
							printf (__('Please select a <a href="%s">WP Edit Snidget</a> to show in this area.', 'wp_edit_pro'), admin_url ('edit.php?post_type=jwl-utmce-widget'));
						 } else { 
							_e('No post found with ID ', 'wp_edit_pro'); echo $id; printf (__(', please select an existing <a href="%s">WP Edit Snidget</a>.', 'wp_edit_pro'), admin_url ('edit.php?post_type=jwl-utmce-widget'));
						 } ?>
					</p>
					<?php }
			}
	
			echo $after_widget;
			
		}
	
		/**
		 * Sanitize widget form values as they are saved.
		 * @see WP_Widget::update()
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['title_front'] = strip_tags( $new_instance['title_front'] );
			$instance['jwl-utmce-widget-id'] = $new_instance['jwl-utmce-widget-id'];
			if(isset($new_instance['apply_filters'])) $instance['apply_filters'] = $new_instance['apply_filters'];
	
			return $instance;
		}
	
		/**
		 * Back-end widget form.
		 * @see WP_Widget::form()
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			
			$posts = get_posts(array(
				'post_type' => 'jwl-utmce-widget',
				'numberposts' => -1,
				'orderby' => 'title',
				'order' => 'ASC'
			));
	
			$title = isset($instance['title']) ? $instance['title'] : __('Admin Snidget Title', 'wp_edit_pro');
			$title_front = isset($instance['title_front']) ? $instance['title_front'] : __('Front-End Snidget Title', 'wp_edit_pro');
			$selected_widget_id = isset($instance['jwl-utmce-widget-id']) ? $instance['jwl-utmce-widget-id'] : 0;
			$apply_filters = isset($instance['apply_filters']);
	
			if(empty($posts)) { ?>
	
				<p><?php _e('You should first create at least 1 WP Edit Snidget', 'wp_edit_pro'); ?> <a href="<?php echo admin_url('edit.php?post_type=jwl-utmce-widget'); ?>"> <?php _e('here', 'wp_edit_pro'); ?></a>.</p>
	
			<?php
			} else { ?>
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Admin Snidget Title:', 'wp_edit_pro' ); ?></label> 
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'title_front' ); ?>"><?php _e( 'Front-End Snidget Title: (empty for no title)', 'wp_edit_pro' ); ?></label> 
					<input class="widefat" id="<?php echo $this->get_field_id( 'title_front' ); ?>" name="<?php echo $this->get_field_name( 'title_front' ); ?>" type="text" value="<?php echo esc_attr( $title_front ); ?>" />
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'jwl-utmce-widget-id' ); ?>"><?php _e( 'Snidget Content: (select post title)', 'wp_edit_pro' ); ?></label> 
					<select id="<?php echo $this->get_field_id('jwl-utmce-widget-id'); ?>" name="<?php echo $this->get_field_name( 'jwl-utmce-widget-id' ); ?>" class="jwl_utmce_widget">
						<option value="0"><?php _e('Select a WP Edit Snidget..', 'wp_edit_pro'); ?></option>
						<?php foreach($posts as $p) { ?>
							<option value="<?php echo $p->ID; ?>" <?php if($p->ID == $selected_widget_id) echo 'selected="selected"'; ?>><?php echo $p->post_title; ?></option>
						<?php } ?>
					</select>
				</p>
				<p> 
					<input id="<?php echo $this->get_field_id( 'apply_filters' ); ?>" name="<?php echo $this->get_field_name( 'apply_filters' ); ?>" type="checkbox" <?php if ($apply_filters == 1) echo 'checked="checked"' ?>/>
					<label for="<?php echo $this->get_field_id( 'apply_filters' ); ?>"><?php _e( 'Apply Content Filters: (such as shortcodes)', 'wp_edit_pro' ); ?></label>
				</p>
			<?php 
			}
			?>
			<p style="border: 1px solid green; background: #CFC; padding:5px;"><?php printf (__('Create additional snidgets <a href="%s">HERE</a>.', 'wp_edit_pro'), admin_url('edit.php?post_type=jwl-utmce-widget')); ?></p>  
			<?php
		}
	}
	
	class WPEP_snidgets_class {
		
		public function __construct() {
			
			add_action('init', array($this, 'wpep_snidget_jwl_on_init_action'));  // Register custom post type
			add_action('widgets_init', array($this, 'wpep_snidget_jwl_register_widget'));  // Register widget
			add_action('add_meta_boxes', array($this, 'wpep_snidget_jwl_add_meta_box'));  // Add metabox linking to admin widget page (user helper)
			add_filter('post_updated_messages', array($this, 'wpep_snidget_jwl_content_block_messages'));  // Snidget messages
			add_shortcode('jwl-utmce-widget', array($this, 'wpep_snidget_jwl_utmce_shortcode'));  // Shortcode for snidget (without title)
			add_shortcode('jwl-utmce-widget-title', array($this, 'wpep_snidget_jwl_utmce_shortcode_title'));  // Shortcode for snidget (with title)
			add_action('admin_head', array($this, 'wpep_add_snidget_button_to_editor'));  // Add snidget button above editor
			add_action('after_wp_tiny_mce', array($this, 'wpep_snidget_jwl_add_utmce_widget_popup'));  // Add popup info to snidget editor button
			add_filter('parent_file', array($this, 'wpep_snidget_jwl_set_admin_menu_class')); // Set active admin menu classes
			add_filter('dashboard_glance_items', array($this, 'wpep_snidget_custom_glance_items'));  // Adds link to "at a glance" dashboard items
		}
		
		// Set labels and args.. and registers custom post type
		public function wpep_snidget_jwl_on_init_action() {
			
			$labels = array(
				'name' => __('WP Edit Snidget', 'wp_edit_pro'),
				'singular_name' => __('WP Edit Snidget', 'wp_edit_pro'),
				'add_new' => __('Add New Snidget', 'wp_edit_pro'),
				'add_new_item' => __('Add New Snidget', 'wp_edit_pro'),
				'edit_item' => __('Edit Snidget', 'wp_edit_pro'),
				'new_item' => __('New Snidget', 'wp_edit_pro'),
				'all_items' => __('All Snidgets', 'wp_edit_pro'),
				'view_item' => __('View  Snidget', 'wp_edit_pro'),
				'search_items' => __('Search Snidgets', 'wp_edit_pro'),
				'not_found' =>  __('No snidgets found', 'wp_edit_pro'),
				'not_found_in_trash' => __('No snidgets found in Trash', 'wp_edit_pro'),
				'parent_item_colon' => '',
				'menu_name' => __('WP Edit Snidgets', 'wp_edit_pro')
			);
			$args = array(
				'public' => true,
				'publicly_queryable' => true,
				'show_in_nav_menus' => true,
				'exclude_from_search' => true,
				'labels' => $labels,
				'show_in_menu' => false,
				'menu_position' => '',
				'has_archive' => true,
				'supports' => array('title', 'editor', 'revisions', 'author'),
				'taxonomies' => array('category', 'post_tag')
			);
			
			if (!post_type_exists('jwl-utmce-widget')) {
				
				register_post_type('jwl-utmce-widget', $args);
			}
		}
		
		// Regsiter our widget in the admin area
		public function wpep_snidget_jwl_register_widget() {
			
			register_widget('JWL_UTMCE_Widgets_Widget');  
		}
		
		// Add metabox to edit custom post type
		public function wpep_snidget_jwl_add_meta_box() {
			
			add_meta_box( 
			'jwl-utmce-widget-box',
				__('WP Edit Snidgets', 'wp_edit_pro'),
				array($this, 'wpep_snidget_jwl_meta_widget_box'),
				'jwl-utmce-widget',
				'side',
				'low'
			);
		}
		
		// Add metabox under ultimate tinymce widget area in admin panel
		public function wpep_snidget_jwl_meta_widget_box($post) {
			
			printf (__('Build your snidgets here. Then, go to <a href="%s">Appearance > Snidgets</a> and add them by snidget title.', 'wp_edit_pro'), admin_url ('widgets.php'));
		}
		
		// Post udpated messages
		public function wpep_snidget_jwl_content_block_messages( $messages ) {
			
			$messages['jwl-utmce-widget'] = array(
				0 => '', 
				1 => current_user_can( 'edit_theme_options' ) ? sprintf( __('WP Edit Snidget updated. <a href="%s">Manage Snidgets</a>', 'wp_edit_pro'), esc_url( 'widgets.php' ) ) : sprintf( __('WP Edit Snidget updated.', 'wp_edit_pro'), esc_url( 'widgets.php' ) ),
				2 => __('Custom field updated.', 'wp_edit_pro'),
				3 => __('Custom field deleted.', 'wp_edit_pro'),
				4 => __('WP Edit Snidget updated.', 'wp_edit_pro'),
				5 => isset($_GET['revision']) ? sprintf( __('WP Edit Snidget restored to revision from %s', 'wp_edit_pro'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => current_user_can( 'edit_theme_options' ) ? sprintf( __('WP Edit Snidget published. <a href="%s">Manage Widgets</a>', 'wp_edit_pro'), esc_url( 'widgets.php' ) ) : sprintf( __('WP Edit Snidget published.', 'wp_edit_pro'), esc_url( 'widgets.php' ) ),
				7 => __('WP Edit Snidget saved.', 'wp_edit_pro'),
				8 => current_user_can( 'edit_theme_options' ) ? sprintf( __('WP Edit Snidget submitted. <a href="%s">Manage Snidgets</a>', 'wp_edit_pro'), esc_url( 'widgets.php' ) ) : sprintf( __('WP Edit Snidget submitted.', 'wp_edit_pro'), esc_url( 'widgets.php' ) ),
				9 => sprintf( __('WP Edit Snidget scheduled for: <strong>%1$s</strong>.', 'wp_edit_pro'), date_i18n( __( 'M j, Y @ G:i' , 'wp_edit_pro'), strtotime(isset($post->post_date) ? $post->post_date : null) ), esc_url( 'widgets.php' ) ),
				10 => current_user_can( 'edit_theme_options' ) ? sprintf( __('WP Edit Snidget draft updated. <a href="%s">Manage Snidgets</a>', 'wp_edit_pro'), esc_url( 'widgets.php' ) ) : sprintf( __('WP Edit Snidget draft updated.', 'wp_edit_pro'), esc_url( 'widgets.php' ) ),
			);
			
			return $messages;
		}
		
		// Add snidget shortcodes
		// For content only
		public function wpep_snidget_jwl_utmce_shortcode($atts) {
			
			extract(shortcode_atts(array('id' => '', 'class' => 'jwl-utmce-widget'), $atts));
			$content2 = "";
			
			if($id != "") {
				
				$args = array('post__in' => array($id), 'post_type' => 'jwl-utmce-widget',);
				$content_post = get_posts($args);
				
				foreach( $content_post as $post ) :
					$content2 .= '<div class="'. esc_attr($class) .'">';
					$content2 .= apply_filters('the_content', $post->post_content);
					$content2 .= '</div>';
				endforeach;
			}
			
			return $content2;
		}
		// For content and title only
		public function wpep_snidget_jwl_utmce_shortcode_title($atts) {
			
			extract(shortcode_atts(array('id' => '', 'class' => 'jwl-utmce-widget'), $atts));
			$content2 = "";
			
			if($id != "") {
				
				$args = array('post__in' => array($id), 'post_type' => 'jwl-utmce-widget');
				$content_post = get_posts($args);
				
				foreach( $content_post as $post ) :
					$content2 .= '<div class="'. esc_attr($class) .'">';
					$content2 .= apply_filters('the_content', '<strong>'.$post->post_title.'</strong>');
					$content2 .= apply_filters('the_content', $post->post_content);
					$content2 .= '</div>';
				endforeach;
			}
			
			return $content2;
		}
		
		// Add "add snidget" button above editor
		public function wpep_add_snidget_button_to_editor() {
			
			global $current_screen;
			if('jwl-utmce-widget' != $current_screen->post_type ) add_filter('media_buttons', array($this, 'jwl_add_content_block_icon'));
		}
		public function jwl_add_content_block_icon() {
			
			if(!defined('JWL_UTMCE_WIDGET_URL'))
				define( 'JWL_UTMCE_WIDGET_URL', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__), '', plugin_basename(__FILE__) ) );
				
			echo '<style>
			#jwl-add-utmce-widget .wp-media-buttons-icon:before {
				 content: "\f132";
				 font: 18px/1 "dashicons";
			}
			#jwl-add-utmce-widget {
				padding-left: 0.4em;
			}
			#TB_ajaxContent {
				width:600px !important;
				height:700px !important;
			}
			</style>
			<a id="jwl-add-utmce-widget" class="button thickbox" title="' . __("Add WP Edit Widget", 'wp_edit_pro') . '" href="' . JWL_UTMCE_WIDGET_URL . 'popup.php?type=jwl_add_utmce_widget_popup&amp;TB_inline=true&amp;inlineId=jwl_utmce_widget_form"><span class="wp-media-buttons-icon"></span>' . __('Add Snidget', 'wp_edit_pro') . '</a>';
		}
		// Snidget footer script
		public function wpep_snidget_jwl_add_utmce_widget_popup() { ?>
		
			<script type="text/javascript">
			
				function wpep_InsertContentBlockForm() {
					
					get_content = jQuery("#add-utmce-widget-id").val(); // Gets the id and the content in the format id|content
					
					if(get_content == "") { // If our content is empty, it means no widget was selected
					
						alert("<?php _e( 'Please select a WP Edit Snidget', 'wp_edit_pro' ); ?>");
						return;
					}
					
					win = window.dialogArguments || opener || parent || top;
					
					shortcode_id = get_content.split('|')[0];  // Used when inserting shortcode
					//alert(shortcode_id);
					
					content_id = get_content.split('|')[1];  // Used when inserting content
					//alert(content_id);
					
					insert_type = "";
					
					// Let's grab the value of the radio option; shortcode or content
					selected = jQuery("input[type='radio'][name='jwl_insert_widget_type']:checked");
					
					if (selected.length > 0)
						insert_type = selected.val();
					
					// If we are inserting a shortcode
					if (insert_type == 'shortcode') { 
					
						if (document.getElementById('jwl_check_post_title_preview').checked){ // We gotta check if the user wants to include the title
						
							win.send_to_editor("[jwl-utmce-widget-title id=" + shortcode_id + "]"); // Insert widget title and content
						}
						else{
							
							win.send_to_editor("[jwl-utmce-widget id=" + shortcode_id + "]"); // Insert widget content without title
						}
					}
					// Else we are inserting content
					else { 
					
						if (document.getElementById('jwl_check_post_title_preview').checked){ // We gotta check if the user wants to include the title
						
							var post_title = jQuery("#add-utmce-widget-id option:selected").html(); // Grab widget title
							win.send_to_editor('<strong>'+post_title+'</strong>'+'\n\n'+content_id); // Insert widget title and content
						}
						else{
							
							win.send_to_editor(content_id); // Insert widget content without title
						}
					}
				}
				
				function wpep_pop_preview() {
					
					// Get the post content from the value attribute of each select option
					post_content = jQuery("#add-utmce-widget-id").val();
					post_content = post_content.split('|')[1];
					
					jQuery('#utmce_widget_preview_content').html('<div id="utmce_widget_preview_content">'+post_content+'</div>'); // Load content into preview div
					
					// If the popup option is checked to include the title.. we grab the title from the select option
					if (document.getElementById('jwl_check_post_title_preview').checked){
						
						// Populate title AND content
						post_title = jQuery("#add-utmce-widget-id option:selected").html();
						jQuery('#utmce_widget_preview_title').html('<div id="utmce_widget_preview_title"><h3>'+post_title+'<h3></div>'); // Load title into preview div
					} 
					else {
						
						// Populate ONLY content
						jQuery('#utmce_widget_preview_title').html('<div id="utmce_widget_preview_title"></div>'); // Clear title from preview div
					}				
				}
			</script>
			
			<div id="jwl_utmce_widget_form" style="display: none;">
            
				<h3><?php _e( 'Insert WP Edit Snidget', 'wp_edit_pro' ); ?></h3>
				<p><?php _e( 'Select a WP Edit Snidget below to add it to your post or page. Yes, they can be used in content areas too!', 'wp_edit_pro' ); ?></p>
				<p>
					<select id="add-utmce-widget-id" onChange="wpep_pop_preview();" >
						<option id="select_option" value="">
							<?php _e( 'Select a WP Edit Snidget', 'wp_edit_pro' ); ?>
						</option>
						<?php 
							
							global $wpdb;
							global $post;
							$str = "SELECT $wpdb->posts.* FROM $wpdb->posts WHERE post_type = 'jwl-utmce-widget' AND post_status = 'publish'";
							$result = $wpdb->get_results($str);
							
							if ($result) {
								foreach( $result as $post ) {
								
									setup_postdata( $post );
								
									$post->post_content = str_replace('"', "'", $post->post_content);
									echo '<option id="'.$post->ID.'" value="'.$post->ID.'|'.wpautop($post->post_content).'">'.$post->post_title.'</option>';
								}
								wp_reset_postdata();
							} 
							else {
								
								echo '<option id="none_available" value="">' . __( 'No WP Edit Snidgets available', 'wp_edit_pro' ) . '</option>';
							};
						?>
					</select>
				</p>
				<p><input id="jwl_check_post_title_preview" type="checkbox" onChange="wpep_pop_preview();" /> <?php _e( 'Include Snidget Title when inserting widget into content?', 'wp_edit_pro' ); ?></p>
				<p><input name="jwl_insert_widget_type" type="radio" value="shortcode" /> <?php _e( 'Insert as Shortcode', 'wp_edit_pro' ); ?><input name="jwl_insert_widget_type" type="radio" value="content" style="margin-left:10px;" checked /> <?php _e( 'Insert as Content', 'wp_edit_pro' ); ?></p>
				<p><input type="button" class="button-primary" value="<?php _e( 'Insert WP Edit Snidget', 'wp_edit_pro' ) ?>" onclick="wpep_InsertContentBlockForm();"/></p>
				<h3><?php _e( 'Preview:', 'wp_edit_pro' ); ?></h3>
				<hr />
				<div id="jwl_widget_preview">
					<div id="utmce_widget_preview_title"></div>
					<div id="utmce_widget_preview_content"></div>
				</div>
			</div>
			
		<?php 
		}
		
		// Add active classes
		public function wpep_snidget_jwl_set_admin_menu_class($parent_file){
			
			global $submenu_file;
			$screen = get_current_screen();
			
			// Set active menu for widget categories
			if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'category' && isset($_GET['post_type']) && $_GET['post_type'] == 'jwl-utmce-widget') {
				
				$submenu_file = 'edit-tags.php?taxonomy=category&post_type=jwl-utmce-widget';
				$parent_file = 'wp_edit_pro_options';
			}
			// Set active menu for widget tags
			if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'post_tag' && isset($_GET['post_type']) && $_GET['post_type'] == 'jwl-utmce-widget') {
				
				$submenu_file = 'edit-tags.php?taxonomy=post_tag&post_type=jwl-utmce-widget';
				$parent_file = 'wp_edit_pro_options';
			}
			// Set active menu for edit widget
			if (isset($screen->post_type) && $screen->post_type === 'jwl-utmce-widget') {
				
				$parent_file = 'wp_edit_pro_options';
			}
			
			return $parent_file;
		}
		
		// Dashboard "at a glance" item
		function wpep_snidget_custom_glance_items( $items = array() ) {
			
			$post_types = array('jwl-utmce-widget');
			foreach( $post_types as $type ) {
				
				if( ! post_type_exists( $type ) ) continue;
				$num_posts = wp_count_posts( $type );
				if( $num_posts ) {
					
					$published = intval( $num_posts->publish );
					$post_type = get_post_type_object( $type );
					$text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, 'wp_edit_pro' );
					$text = sprintf( $text, number_format_i18n( $published ) );
					
					if ( current_user_can( $post_type->cap->edit_posts ) ) {
						$items[] = sprintf( '%2$s', $type, '<a href="' . admin_url() . 'edit.php?post_type=' . $type . '">' . $text . '</a>' ) . "\n";
					} else {
						$items[] = sprintf( '%2$s', $type, '<a href="' . admin_url() . 'edit.php?post_type=' . $type . '">' . $text . '</a>' ) . "\n";
					}
				}
			}
			return $items;
		}
	}
	
	$WPEP_snidgets_class = new WPEP_snidgets_class();
}
