<?php
$database_table_name = 'wpusm_posts';
$database_log_table_name = 'wpusm_posts_log';

$ROOT = dirname($_SERVER['SCRIPT_FILENAME']) .'/';
$HTTP = 'http://localhost/upwork/work/';

// $mask = 'https://actiontrick.tk/';





function wpusm_post_log_check($url)
{
    global $wpdb;
    $time = time() - 300; // last run
    $sql = "SELECT * FROM `wpusm_posts_log` WHERE sourceurl = '{$url}'";
    $results = $wpdb->get_results($sql);
    foreach( $results as $result ) {
        $utime = $result->utime;

        if($time < $utime)
        {
            return 2;
        }
        wpusm_post_log_update($result->id);
        return  1;
    }
    return  0;

}
function wpusm_post_log_create($url)
{
    global $wpdb;

    $chkval = wpusm_post_log_check($url);
   if($chkval)
   {
       return $chkval;
   }else{
       $wpdb->insert('wpusm_posts_log', array(
           'post_id' => 0,
           'utime' => time(), // ... and so on
           'sourceurl' => $url, // ... and so on
       ));
   }
}
function wpusm_post_log_update($id)
{
    global $wpdb;
    $wpdb->update( 'wpusm_posts_log', [
        'utime'=>time()
    ],array('id'=>$id));
}