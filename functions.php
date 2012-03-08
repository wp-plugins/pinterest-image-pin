<?php
define("CREDIT_HEAD"    	, "\n<!---- Pinterest Image Pin included this line ------->\n<!---- Shane Jones - www.shanejones.co.uk -->\n");
define("CREDIT_FOOT"    	, "\n<!---- END Pinterest Image Pin -------------->\n\n");
define("PLUGIN_FOLDER"		, get_bloginfo('wpurl') . "/wp-content/plugins/pinterest_image_pin/");


function sdj_pip_render_css() {
	
    echo CREDIT_HEAD .
		 '<link type="text/css" rel="stylesheet" href="' . PLUGIN_FOLDER . 'sdj_pip_main.css" />' . 
		 CREDIT_FOOT . "\n";
		 
}


function sdj_pip_modify_content($content){
	$options = get_option('sdj_pip_options');
	
	if(is_front_page()||is_category()){
		
		return $content;
		
	} else {

		switch($options['pin_type']){
				case 'a':
					define("TYPE" , "none");
					break;
				case 'b':
					define("TYPE" , "vertical");
					break;
				case 'c':
					define("TYPE" , "horizontal");
					break;
			}

		$content = preg_replace_callback(
					'/(<img([^>]*)>)/i',
					create_function(
						'$matches',
						'return CREDIT_HEAD . 
								"<div class=\"sdj_pinterest_wrap\">$matches[0]<div class=\"linkbox\">" . 
								"<a href=\"http://pinterest.com/pin/create/button/?media=" . urlencode( 
									substr(substr("$matches[0]", strpos("$matches[0]","src=\"")+5), 0,strpos(substr("$matches[0]", strpos("$matches[0]","src=\"")+5),"\""))) .
								"&url=".urlencode(get_permalink())."\" class=\"pin-it-button\" count-layout=\"".TYPE."\">Pin It</a></div></div>" . 
								CREDIT_FOOT;'
					),
					$content);
					
					
		if($options['pin_follow']==1){
			
			$footer =  '<a href="http://pinterest.com/'.$options['pin_username'].'/"><img src="http://passets-cdn.pinterest.com/images/';
			
			switch($options['pin_follow_type']){
				case 'a':
					$footer .=  'follow-on-pinterest-button.png" width="156" height="26"';
					break;
				case 'b':
					$footer .= 'follow-on-pinterest-button.png" width="156" height="26"';
					break;
				case 'c':
					$footer .= 'pinterest-button.png" width="78" height="26"';
					break;
				case 'd':
					$footer .= 'small-p-button.png" width="16" height="16"';
					break;
			}
			
			$footer .= ' alt="Follow Me on Pinterest" /></a>';
			
		}		
		
		return $content . $footer;
	}
   	
   
}


function sdj_pip_render_footer_script(){
    $options = get_option('sdj_pip_options');
	
	if($options['pin_credit']!=1){
		echo '<p class="sdj_footer_link"><a href="http://www.shanejones.co.uk/wordpress-plugins/pinterest-image-pin-77/" target="_blank"> Pinterest Image Pin</a> Courtesy of <a href="http://www.shanejones.co.uk" target="_blank">Shane Jones</a></p>';
	}
	
	echo  CREDIT_HEAD .
		 '<script type="text/javascript">
			(function() {
				window.PinIt = window.PinIt || { loaded:false };
				if (window.PinIt.loaded) return;
				window.PinIt.loaded = true;
				function async_load(){
					var s = document.createElement("script");
					s.type = "text/javascript";
					s.async = true;
					if (window.location.protocol == "https:")
						s.src = "https://assets.pinterest.com/js/pinit.js";
					else
						s.src = "http://assets.pinterest.com/js/pinit.js";
					var x = document.getElementsByTagName("script")[0];
					x.parentNode.insertBefore(s, x);
				}
				if (window.attachEvent)
					window.attachEvent("onload", async_load);
				else
					window.addEventListener("load", async_load, false);
			})();
			</script>' .
         CREDIT_FOOT;
		 
}



/*
 * Admin Settings Related Bits
 *
 */
function sdj_pip_admin_add_page() {
    add_options_page('Custom Plugin Page', 'Pinterest Image Pin', 'manage_options', 'sdj_pip_plugin', 'sdj_pip_options_page');
}

function sdj_pip_options_page() {
?>
    
    <h1>Pinterest Image Pin by Shane Jones</h1>
    <div style="float:left; width:420px;">
        <form action="options.php" method="post">
        <?php settings_fields('sdj_pip_options') ?>
        <?php do_settings_sections('sdj_pip_plugin') ?>
    
        <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
    
        </form>
        <h2>Buy Me a Beer?</h2>
        <p>If you'd like to say thanks for this amazing free plugin, you can buy me a beer by using the donate button below. Thanks</p>   
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="TS33GLQZYJ3RA">
                <input style="text-align:center;" type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
            </form>
    </div>
    <div style="float:left; width:260px;">
        <h2>Pin Types</h2>
        <p style="text-align:center;"><img src="http://farm8.staticflickr.com/7066/6809517894_e1392c2428.jpg"></p>
        <h2>Follow Button Types</h2>
        <p style="text-align:center;"><img src="http://farm8.staticflickr.com/7190/6809517936_3c17ce5872_m.jpg"></p>
    </div>

<?
}


function sdj_pip_admin_init(){
    register_setting('sdj_pip_options', 'sdj_pip_options');
	
    add_settings_section('plugin_main', 'Pinterest Follow Buttons', 'plugin_pin_follow_text', 'sdj_pip_plugin');
    

    add_settings_field('pin_username_string', 'Your Pinterest Handle', 'pin_username_string', 'sdj_pip_plugin', 'plugin_main');
	add_settings_field('pin_type_drop', 'Pin Button Type', 'pin_type_drop', 'sdj_pip_plugin', 'plugin_main');
	add_settings_field('pin_follow_type_drop', 'Follow Button Type', 'pin_follow_type_drop', 'sdj_pip_plugin', 'plugin_main');
	
	add_settings_field('pin_follow_optin', 'Show Follow Button', 'pin_follow_optin', 'sdj_pip_plugin', 'plugin_main');
	add_settings_field('pin_credit_optin', 'Hide Credits', 'pin_credit_optin', 'sdj_pip_plugin', 'plugin_main');

}

function plugin_pin_follow_text() {
    echo '<p>Customise your Pinterest button with these few settings here.</p>';
}

function pin_username_string() {
    $options = get_option('sdj_pip_options');
    echo '<input id="pin_username_string" name="sdj_pip_options[pin_username]" size="40" type="text" value="'.$options["pin_username"].'" />';
}


function pin_follow_optin() {
    $options = get_option('sdj_pip_options');
    echo '<input id="pin_follow_optin" name="sdj_pip_options[pin_follow]" size="40" type="checkbox" value="1" '.($options['pin_follow']==1? 'checked':'').' />';
}

function pin_type_drop() {
    $options = get_option('sdj_pip_options');
    echo '<select id="pin_follow_type_drop" name="sdj_pip_options[pin_type]">';
	
		$pin_type = array('a','b','c');
	
		foreach($pin_type as $pin){
			echo '<option value="'.$pin.'"';
			
			if($pin == $options['pin_type']) {
				echo ' selected';
			}	
			
			echo '>Pin '.strtoupper($pin).'</option>';	
		}		
			
	echo '</select>';
}

function pin_follow_type_drop() {
    $options = get_option('sdj_pip_options');
    echo '<select id="pin_follow_type_drop" name="sdj_pip_options[pin_follow_type]">';
	
		$pin_type = array('a','b','c','d');
	
		foreach($pin_type as $pin){
			echo '<option value="'.$pin.'"';
			
			if($pin == $options['pin_follow_type']) {
				echo ' selected';
			}	
			
			echo '>Follow '.strtoupper($pin).'</option>';	
		}		
			
	echo '</select>';
}


function pin_credit_optin() {
    $options = get_option('sdj_pip_options');
    echo '<input id="pin_credit_optin" name="sdj_pip_options[pin_credit]" size="40" type="checkbox" value="1" '.($options['pin_credit']==1? 'checked':'').' />';
}

?>