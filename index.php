<?php
/**
 * @package Pinterest Image Pin
 * @version 0.2
 */
/*
Plugin Name: Pinterest Image Pin
Plugin URI: http://www.shanejones.co.uk/wordpress-plugins/pinterest-image-pin-77/
Description: This plugin will enable your sites visitors to pin individual images on Pinterest, the pin button will appear just underneath every image in the main content. It also has the option to add a Pinterest follow button to the bottom of your posts. More features coming soon.
Author: Shane Jones
Version: 0.2
Author URI: http://profiles.wordpress.org/ShaneJones/
*/

include "functions.php";

if (is_admin()){
	
    add_action('admin_menu', 'plugin_admin_add_page');
    add_action('admin_init', 'plugin_admin_init');
	
} else {
	add_action('wp_head'        , "render_css");
    add_action('the_content'    , 'modify_content');
    add_action('wp_footer'      , 'render_footer_script');
}

?>