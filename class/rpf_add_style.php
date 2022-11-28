<?php
// load stylesheet
function rpf_load_stylesheet() {
	if ( is_single() ) {
		wp_enqueue_style( 'rpf_stylesheet', plugin_dir_url( __FILE__ ) . 'rpf-style.css' );
	}
}
add_action('wp_enqueue_scripts','rpf_load_stylesheet');
