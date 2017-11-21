<?php

/*
****************************************************************
Class for Snidgets WP Table
****************************************************************
*/
if( !class_exists( 'WP_List_Table' ) )
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class wpeditpro_snidgets_table extends WP_List_Table{
	
    public function __construct() {
		
        parent::__construct( array(
            'singular' => 'table example',
            'plural'   => 'table examples',
            'ajax'     => true
        ) );
        $this->prepare_items();
        $this->display();
    }

    function get_columns() {
		
        $columns = array(
            //'cb'        => '<input type="checkbox" />',
            'title' => __('Title','wp_edit_pro'),
            'author'    => __('Author','wp_edit_pro'),
            'date'      => __('Date','wp_edit_pro'),
			'post_id' => __('ID','wp_edit_pro')
        );
        return $columns;
    }

    function column_default( $item, $column_name ) {
		
        switch( $column_name ) {
            case 'title':
            case 'author':
            case 'date':
                return $item[$column_name];
			case 'post_id':
				return $item[$column_name];
            default:
                return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
        }
    }
	
    function column_title($item) {
			
		// Get new class to check if blog id is set
		$class = new WP_EDIT_PRO();
		$blog_id = $class->network_blog_id;
		if($blog_id !== '') {
			
			switch_to_blog($blog_id);
			$admin_url = get_admin_url();
			
			// Take url passed in $item['title'] (which is a link) and parse it for the post id
			// This is needed because the function can't get subsite ID's (returns null)
			$get_params = explode('?', $item['title']);
			$get_all_params = explode('&', $get_params[1]);
			foreach($get_all_params as $key => $value) {
				if (strpos($value,'post=') !== false) {
					$get_post_id_param = explode('=', $value);
					$item['post_id'] = $get_post_id_param[1];
				}
			}
			
			restore_current_blog();
		}
		else {
			
			$admin_url = get_admin_url();
		}
		
		
		$actions = array(
				'edit'      => sprintf('<a href="'.$admin_url.'post.php?post=%s&action=%s" target="_blank">Edit</a>', $item['post_id'], 'edit'),
				'delete'    => sprintf('<a href="'.$admin_url.'post.php?post=%s&action=%s" target="_blank">Delete</a>', $item['post_id'], 'delete'),
		);

		return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions) );
    }

    function prepare_items() {
		
		$args = array(
			'post_type'=> 'jwl-utmce-widget',
			'order'    => 'ASC'
		);
		$loop_array = array(); 
		
		// Get new class to check if blog id is set
		$class = new WP_EDIT_PRO();
		$blog_id = $class->network_blog_id;
		if($blog_id !== '') {
			
			switch_to_blog($blog_id); //switch to main site
			
			$post_types = get_post_types();
			$loop = new WP_Query( $args );
			wp_reset_query();
			
			restore_current_blog();
		}
		else {
			
			$post_types = get_post_types();
			$loop = new WP_Query( $args );
			wp_reset_query();
		}
		
		
		foreach ($loop->posts as $post) {
			
			$base_url = explode('?', $post->guid);
			$link = '<a href="'.$base_url[0].'wp-admin/post.php?post='.$post->ID.'&action=edit'.'" target="_blank">'.$post->post_title.'</a>';
			$author_name = get_the_author_meta('display_name', $post->post_author);
			$loop_array[] = array('title' => $link, 'author' => $author_name, 'date' => $post->post_date, 'post_id' => $post->ID);
		}
		
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $loop_array;
    }
}
