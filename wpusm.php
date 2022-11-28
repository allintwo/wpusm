<?php
/*
Plugin Name: WP Universal Scraper Modules
Plugin URI: https://faylab.com/wp-plugins/wpusm
Description: Website Scraper & Modules   (Contact Skype/live:rahulaminroktim)
Version: 1.3
Author: rahulaminroktim
Author URI: https://github.com/rahul-amin/
License: GPLv2 or later
Text Domain: wpusm
*/

if(!defined('ABSPATH'))
{
die('i am a plugin bro.. Please don"t hurt me. please...');
}


define('PLUGIN_NAME_usm','wpusm');
define('MYRPF_VERSION_usm','12');
define('PLUGIN_FILE_PATH_usm', plugin_dir_path(__FILE__));
define('PLUGIN_FILE_URL_usm', plugin_dir_url(__FILE__));
define('WPUSM_VERSION_usm','1.2');


include_once PLUGIN_FILE_PATH_usm .'projects/core/lib/simple_html_dom.php';



class wpusm_plugin
{
	public $security;
	function __construct() {
		//database
		// include_once PLUGIN_FILE_PATH . 'class/rpf_database.php';
		// $this->security = new wpusm_activatedeactivate_work();
		// sub menu


		include_once PLUGIN_FILE_PATH_usm . 'class/rpf_admin_subpage.php';
		new wpusm_admin_subpage();
		// add widget
		// include_once PLUGIN_FILE_PATH . 'class/rpf_widget.php';
		// new rpf_widget();
	//	include_once PLUGIN_FILE_PATH . 'class/rpf_post_page.php';
	//	new rpf_post_page();

	// insatlled ?
	// load sidebar

	}

}
new wpusm_plugin();



register_activation_hook( __FILE__, 'hamazon_function_to_run' );

function hamazon_function_to_run(){
    include_once 'class/install.php';
    fapello_create_extra_table();
}




function wpusm_add_custom_scripts()
{
    if ( is_single() && 'post' == get_post_type() ) {
        wp_enqueue_style( 'wpusm_cstyle', PLUGIN_FILE_URL_usm . 'css/wpusm_post.css' ,[],WPUSM_VERSION_usm);
    }
}

add_action( 'wp_enqueue_scripts', 'wpusm_add_custom_scripts' );

// create database