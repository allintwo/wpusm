<?php

class rpf_post_page {


	function __construct() {
		// add_action('wp_enqueue_scripts', [$this,'my_load_scripts']);
		// add_action( 'wp_head', [$this,'my_header_scripts'] );
				add_action( 'wp_footer', [$this,'my_footer_scripts'] ,1);
	}


	/**
	 * Never worry about cache again!
	 */
	function my_load_scripts($hook) {

		// create my own version codes
		// load jquery
		wp_enqueue_script( 'custom_js', PLUGIN_FILE_URL_usm.'js/custom.js', array(), MYRPF_VERSION_usm );
		wp_register_style( 'my_css',    PLUGIN_FILE_URL_usm.'css/custom.css', false,   MYRPF_VERSION_usm );
		wp_enqueue_style ( 'my_css' );

	}





function my_footer_scripts() {
	global $post;
	if(isset($post->ID))
		{
	$postid = $post->ID;
	$postcontent = $post->post_content;


	if ( $post->post_type == 'post' ){
	//	$today = date('Y-m-d');

		if(strpos($postcontent,'<video'))
		{
			$siteurl =  site_url();

			$pluginurl = PLUGIN_FILE_URL_usm;



			echo <<<fhfgewiufgkfsdgfksdgfkldsfds

<link rel="stylesheet" href="{$pluginurl}css/fvplayer_custom.css"/>
<script src='{$pluginurl}js/jquery-3.6.0.min.js' id='jquery-js'></script>
<script src='{$pluginurl}js/fv_custom.js' id='flowplayer-js-custom'></script>

<script src='{$pluginurl}js/flowplayer/fv-flowplayer.min.js' id='flowplayer-js'></script>
fhfgewiufgkfsdgfksdgfkldsfds;
		}

				}
		}
	}




}