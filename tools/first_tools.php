<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 8/29/2022
 * Time: 7:47 AM
 */


$query = $wpdb->prepare(
    'SELECT * FROM ' . $wpdb->posts . '
        WHERE post_title = %s',
    'Aubree Rene Nude Dildo Masturbation Onlyfans Video Leaked'
);
$results =$wpdb->get_results( $query );
foreach ($results as  $result)
{
    $post_id = $result->ID;
    $post_content = $result->post_content;
    echo $result->post_name;
}
