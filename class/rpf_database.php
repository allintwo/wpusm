<?php
// common table: MYRPF_options
// Create database as  project need
// project table: MYRPF_projectname_work





// check system
class wpusm_activatedeactivate_work{

	public function __construct() {
		if (is_admin()) {
			register_activation_hook(PLUGIN_FILE_PATH_usm, array( $this, 'activate'));
			register_deactivation_hook( PLUGIN_FILE_PATH_usm, array( $this, 'my_plugin_remove_database' ) );
		}
	}

	public function activate() {
		global $wpdb;
		$table = $wpdb->prefix . 'md_things';
		$charset = $wpdb->get_charset_collate();
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name tinytext NOT NULL,
        text text NOT NULL,
        url varchar(55) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	public function my_plugin_remove_database() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'md_things';
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query($sql);
		//delete_option("jal_db_version");
	}
//
}
