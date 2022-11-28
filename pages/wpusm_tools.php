<?php
// simple page template
class wpusm_tools{
	public $pagetitle = 'Tools';
	public $menutitle = 'Tools';
	public $call = 'display';

	function __construct() {

	}

	public function display()
	{
        global $wpdb;




        $possible_fixurl = "";

// update 6.7.22
        $myprojects = [];

        $toolname = '';
        if(isset($_REQUEST['toolname']))
        {
            $toolname = $_REQUEST['toolname'];
        }

        $modules_path = PLUGIN_FILE_PATH_usm.'/tools';
        $modules_paths = array_diff(scandir($modules_path), array('.', '..'));
        foreach ($modules_paths as  $module_filename)
        {
            if(strpos($module_filename,'.php')<2)
            {
                continue;
            }

            // echo $module_filename . "<br/>";
            $hstnme = $module_filename;
            $myprojects[$hstnme] = [$hstnme,$module_filename];
            if($toolname == $module_filename)
            {
                include_once PLUGIN_FILE_PATH_usm.'/tools/'.$toolname;
            }
        }
        $working_sitelist = '';
        foreach ($myprojects as  $myproject => $vals)
        {
            $working_sitelist .= "<tr><td class='wp-menu-name'>{$myproject}</td></tr>";
        }

        $postnames = [];
        $list_html = '';
        $results = $wpdb->get_results("SELECT * FROM $wpdb->posts where post_type='post' AND post_status='publish' 
ORDER BY ID desc limit 1000");
        foreach ($results as  $result)
        {
           // print_r($result);
            $content = $result->post_content;
            if(strpos($content,'myrpf-vdox')>0)
            {
                if(strpos($content,'myrpf-vvddo')>0)
                {

                }else{
                    $postnames[] = [$result->post_name,$result->guid];
                    $list_html .= "<tr><td><a href='{$result->guid}'>{$result->post_name}</a></td> </tr>";
                }
            }
        }

        $project_folder = PLUGIN_FILE_URL_usm . '/projects/core/';
        $bootstrap_url = PLUGIN_FILE_URL_usm .'/css/bootstrap.min.css';


		$apilink = PLUGIN_FILE_URL_usm . 'projects/core/api.php';
		echo <<<gfdsghfdshglfdhglkfd
<link rel="stylesheet" href="{$bootstrap_url}">
<div id="wpbody" role="main">
<div style="background-color: white;width: 100%" class="container">
<div>
<h3>Tools List</h3>
<table class="table">
<tbody class="">
<tr><th>Site</th></tr>
{$working_sitelist}
</tbody>
</table>
</div>
</div>
<table>$list_html</table>
</div>

<style>

th , td{
border: 1px solid grey;
padding: 10px;
}



</style>


gfdsghfdshglfdhglkfd;

	}
}