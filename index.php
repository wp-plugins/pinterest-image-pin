<?php
/**
 * @package Pinterest Image Pin
 * @version 0.6
 */
/*
Plugin Name: Pinterest Image Pin
Plugin URI: http://www.shanejones.co.uk/wordpress-plugins/pinterest-image-pin-77/
Description: This plugin will enable your sites visitors to pin individual images on Pinterest, the pin button will appear just underneath every image in the main content. It also has the option to add a Pinterest follow button to the bottom of your posts. More features and a major bug fix release coming soon.
Author: Shane Jones
Version: 0.6
Author URI: http://profiles.wordpress.org/ShaneJones/
*/

include "functions.php";

if (is_admin()){
	
    add_action('admin_menu'     , 'sdj_pip_admin_add_page');
    add_action('admin_init'     , 'sdj_pip_admin_init');
	
} else {
	add_action('wp_head'        , "sdj_pip_render_css");
    add_action('the_content'    , 'sdj_pip_modify_content');
    add_action('wp_footer'      , 'sdj_pip_render_footer_script');
}

?>