<?php
/* Plugin Name: Toonimo
Plugin URI: http://toonimo.com/
Version: 1.0
Description: Boost your website revenue with Toonimo animated characters. Businesses around the world are using Toonimo to increase their conversion rates and revenues!
Author: Toonimo
Author URI: http://toonimo.com
*/


//just variables
$pluginVersion = '1.0';
$plugin = plugin_basename(__FILE__); 
$toon = stripslashes(get_option("toon_code"));

//wanna debug ? next line is for you
// print_r($toon);

// // SOME COOL HOOKS, ACTIONS, AND FILTERS
register_activation_hook(__FILE__, 'toon_activation');
register_deactivation_hook(__FILE__, 'toon_deactivation');
add_filter("plugin_action_links_$plugin", 'toon_plugin_settings_link' );
add_action('admin_menu', 'toon_settings');
add_action( 'wp_footer', 'toon_output' ); 



//activate/de-activate hooks, dont change it, its required... after all its a plugin
function toon_activation() {}
function toon_deactivation() {}


// Add settings link on plugins page filter  //copied from codex.wordpress.org
function toon_plugin_settings_link($links) {

	// create html for link to settings page
	$settings_link = '<a href="options-general.php?page=toonimo">Settings</a>';

	// add the link as a array element to the plugins page links array
	array_unshift($links, $settings_link);

	//time to return back with the updated links array
	return $links;

}



/// this is a wordpress action which adds a page link in the wordpress admin panel by calling my function toon_settings
//adding a page link in admin panel
function toon_settings()
{
	add_options_page( "Toonimo", "Toonimo", 'administrator', 'toonimo', 'toon_admin_function');
	//this adds the page: parameters are: "page title", "link title", "role", "slug","function that shows the result"
}


// providing the html for admin page and also saving settings if the form gets submitted
function toon_admin_function()
{
	// preventing un-authorized access !!
	if(!current_user_can('manage_options')){ wp_die('You do not have sufficient permissions to access this page.');}

	// if form is submitted save the code in database
    if (isset($_POST["update_settings_toonimo"]))
    {
        $toon_settings = $_POST["toonimocode"];
        update_option("toon_code", $toon_settings);

        // and show the "saved" message
        echo'<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Settings saved.</strong></p></div>';
    } 

    // get the updated value from database to show it in textarea 
	$toon = stripslashes(get_option("toon_code")); 

	//here starts the html of form, cant provide the document of  the html (Do you really need this ? do you!)
	?>
		<div class="wrap">
			<h2>Toonimo</h2>
			<h3>Embed your code</h3>
			<form method="post" >
				<p> New User? Get Started <a href="https://live.toonimo.com/client_n/#signup" target="_blank">Here</a> </p>
				<p> Existing User? <a href="https://live.toonimo.com/client_n/#signin" target="_blank">SignIn Here</a> </p>
				<p> Boost your website revenue with Toonimo animated characters. </p>
				<p>Code Line:<!-- (<a target="_blank" href="#">How to get my codeline?</a>) --> <br />
				<textarea style="width: 77%;height: 200px;" name="toonimocode" class="regular-text"><?php echo $toon;?></textarea></p>
				<p class="submit">
					<input name="update_settings_toonimo"  type="submit" class="button-primary" value="Update Embedded Code" />
				</p>
<p>
If you have any feedback or question,<br />
You can chat with us on <a href="http://toonimo.com" target="_blank">Toonimo Website </a>
</p>
			</form> 

		</div>
	<?php
}



//main function, returns the output in footer of frontend...will work only AND ONLY if the wp_footer function is called in footer.php of theme .. .
function toon_output()
{

    //get the settings from database
  	$toon =  stripslashes(get_option("toon_code"));

  	//finally showing it to users on page
    echo $toon; 
} 
 
 
