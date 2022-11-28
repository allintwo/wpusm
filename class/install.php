<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 5/28/2022
 * Time: 2:15 PM
 */

global $jal_db_version;
$jal_db_version = '1.0';

function fapello_create_extra_table() {
    global $wpdb;
    global $jal_db_version;

    $table_prefix = $wpdb->prefix;

    $charset_collate = $wpdb->get_charset_collate();


    $sqls = [
        "CREATE TABLE IF NOT EXISTS `wpusm_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `title` varchar(512) NOT NULL,
  `host` varchar(32) NOT NULL,
  `ctime` int(12) NOT NULL,
  `utime` int(12) NOT NULL,
  `sourceurl` varchar(512) NOT NULL,
  `postdata` text NOT NULL,
  PRIMARY KEY (`id`)
) $charset_collate;",
        "CREATE TABLE IF NOT EXISTS `wpusm_request_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(512) NOT NULL,
  `urlhash` varchar(64) NOT NULL,
  `host` varchar(128) NOT NULL,
  `time` int(12) NOT NULL,
  `utime` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) $charset_collate;",
        "CREATE TABLE IF NOT EXISTS `wpusm_posts_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `utime` int(12) NOT NULL,
  `sourceurl` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) $charset_collate;",
    ];
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    foreach ($sqls as  $sql)
    {
        dbDelta( $sql );
    }

    add_option( 'jal_db_version', $jal_db_version );
}