<?php
// simple page template
class wpusm_mypage{
	public $pagetitle = 'About';
	public $menutitle = 'About';
	public $call = 'display';

	function __construct() {

	}

	public function display()
	{



// update 6.7.22
        $myprojects = [];

        $modules_path = PLUGIN_FILE_PATH_usm.'/projects/core/modules';
        $modules_paths = array_diff(scandir($modules_path), array('.', '..'));
        foreach ($modules_paths as  $module_filename)
        {
            if(strpos($module_filename,'.php')<2)
            {
                continue;
            }
            // echo $module_filename . "<br/>";
            $hstnme = substr($module_filename,0,-4);
            $myprojects[$hstnme] = [$hstnme,'modules/'.$module_filename];
        }

		$working_sitelist = '';
		foreach ($myprojects as  $myproject => $vals)
		{
            $cr_url = PLUGIN_FILE_URL_usm."projects/core/cron.php?project_host={$myproject}&project_post_limit=10";
			//$working_sitelist .= "<li><a href='https://{$myproject}'>{$myproject}</a> <a href='{$cr_url}'>Cron jobs</a></li>";
			$working_sitelist .= "<tr><td><a href='https://{$myproject}'>{$myproject}</a></td><td><a href='{$cr_url}'>Copy link</a></td></tr>";
		}



		$apilink = PLUGIN_FILE_URL_usm . 'projects/core/api.php';
		echo <<<gfdsghfdshglfdhglkfd
<div id="wpbody" role="main">
<div style="background-color: white;width: 100%" class="container">
<div>
<h3>Supported website list</h3>
<table>
<tbody>
<tr><th>Site</th><th>Cron url</th></tr>
{$working_sitelist}
</tbody>
</table>
</div>

<div> <h3>Plugin API</h3> </div>
<p style="padding: 7px;">You can use this plugin from outside </p>
<p><b>URL POST</b> <i>{$apilink}</i></p>
<div>
<b>Example</b> <u>POST request</u>
<ul><li>{$apilink}?url={YOUR_LINK}</li>
<li>{$apilink}?url=https://faylab.com/big-title/</li>
</ul>

<h2>Cron Jobs Setup</h2>
<p><b>Example For 12 hour and 10 post</b> <br> <i style="color: darkgreen">0 	0,12 	* 	* 	* 	wget {$cr_url} >/dev/null 2>&1</i> <b></b></p>
<p><b>Example For 12 hour and 10 post</b> <br> <i style="color: darkgreen">0 	0,12 	* 	* 	* 	curl {$cr_url} > /dev/null 2>&1</i> <b></b></p>
</div>
</div>
	<div>
	<hr>
	<div style="width: 100%; background-color: darkgray"> <p style="padding: 10px">Developer: https://facebook.com/rahul.roktim</p></div>
	<div style="width: 100%; background-color: darkgray"> <p style="padding: 10px">Developer Email: rahulaminroktim@gmail.com</p></div>
	</div>
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