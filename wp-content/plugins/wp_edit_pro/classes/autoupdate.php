<?php

class wpeditpro_auto_update
{
	
	var $steady = false;
	
	
    /**
     * The plugin current version
     * @var string
     */
    public $current_version;
 
    /**
     * The plugin remote update path
     * @var string
     */
    public $update_path;
 
    /**
     * Plugin Slug (plugin_directory/plugin_file.php)
     * @var string
     */
    public $plugin_slug;
 
    /**
     * Plugin name (plugin_file)
     * @var string
     */
    public $slug;
 
    /**
     * Initialize a new instance of the WordPress Auto-Update class
     * @param string $current_version
     * @param string $update_path
     * @param string $plugin_slug
     */
    function __construct($current_version, $update_path, $plugin_slug)
    {
        // Set the class public variables
        $this->current_version = $current_version;
        $this->update_path = $update_path;
        $this->plugin_slug = $plugin_slug;
        list ($t1, $t2) = explode('/', $plugin_slug);
        $this->slug = str_replace('.php', '', $t2);
 
        // Define the alternative API for updating checking
        add_filter('pre_set_site_transient_update_plugins', array($this, 'check_update'));
 
        // Define the alternative response for information checking
        add_filter('plugins_api', array($this, 'check_info'), 10, 3);
    }
 
    /**
     * Add our self-hosted autoupdate plugin to the filter transient
     *
     * @param $transient
     * @return object $ transient
     */
    public function check_update($transient)
    {
		
        if (empty($transient->checked) || !$this->steady) {
			$this->steady = true;
            return $transient;
        }
 
        // Get the remote version
        $remote_version = $this->getRemote_version();
		
		// If a newer version is available, add the update
		if (version_compare($this->current_version, $remote_version, '<')) {
			
			// Get license notice option
			$plugin_opts = get_wp_edit_pro_option('wp_edit_pro_options_array');
			$blog_opts = get_option('wp_edit_pro_options_array');
			
			// Check License Date
			if($this->getRemote_license() === 'true') {
				
				// Set license notice to 'false'
				$plugin_opts['wpep_license_notice'] = 'false';
				$blog_opts['wpep_license_notice'] = 'false';
				update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);
				update_option('wp_edit_pro_options_array', $blog_opts);
			
				$obj = new stdClass();
				$obj->plugin = 'WP Edit Pro';
				$obj->slug = $this->slug;
				$obj->new_version = $remote_version;
				$obj->url = $this->update_path;
				$obj->package = $this->update_path;
				$transient->response[$this->plugin_slug] = $obj;
			}
			else if($this->getRemote_license() === 'false') {
				
				global $current_user;
				$userid = $current_user->ID;
				
				// Set license notice to 'true'.  This is checked from main.php (upgrade notice)
				$plugin_opts['wpep_license_notice'] = 'true';
				$blog_opts['wpep_license_notice'] = 'true';
				update_wp_edit_pro_option('wp_edit_pro_options_array', $plugin_opts);
				update_option('wp_edit_pro_options_array', $blog_opts);
			}
		}
		
		// Else no new version of WP Edit Pro was found - return $transient
		return $transient;
    }
 
    /**
     * Add our self-hosted description to the filter
     *
     * @param boolean $false
     * @param array $action
     * @param object $arg
     * @return bool|object
     */
    public function check_info($false, $action, $arg)
    {
		if(isset($arg->slug)){
			
			if ($arg->slug === $this->slug) {
				$information = $this->getRemote_information();
				return $information;
			}
		}
		
		//return false;
		return $false;
    }
 
    /**
     * Return the remote version
     * @return string $remote_version
     */
    public function getRemote_version()
    {
        $request = wp_remote_post($this->update_path, array('body' => array('action' => 'version')));
        if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
            return $request['body'];
        }
        return false;
    }
 
    /**
     * Get information about the remote version
     * @return bool|object
     */
    public function getRemote_information()
    {
        $request = wp_remote_post($this->update_path, array('body' => array('action' => 'info')));
        if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
            return unserialize($request['body']);
        }
        return false;
    }
 
    /**
     * Return the status of the plugin licensing
     * @return boolean $remote_license
     */
    public function getRemote_license()
    {
		// Get plugin option
		$transid 	= get_wp_edit_pro_option('wp_edit_pro_license_transid');
		
        $request = wp_remote_post($this->update_path, array('body' => array('action' => 'license', 'user_transid' => $transid)));
        if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
            return $request['body'];
        }
        return false;
    }
}
?>