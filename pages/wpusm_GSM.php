<?php
// simple page template
class wpusm_GSM{
	public $pagetitle = 'GSM';
	public $menutitle = 'GSM';
	public $call = 'display';

	function __construct() {

	}

	public function display()
	{
        // options
        $gsm_opt_host = 'https://faylab.com/GSM/';
        $gsm_opt_api_key = 'gsmDefaultAPIkey';

        if(get_option('gsm_opt_host'))
        {
            $gsm_opt_host = get_option('gsm_opt_host');
        }else{
            add_option('gsm_opt_host',$gsm_opt_host);
        }
        if(get_option('gsm_opt_api_key'))
        {
            $gsm_opt_api_key = get_option('gsm_opt_api_key');
        }else{
            add_option('gsm_opt_api_key',$gsm_opt_api_key);
        }
if(isset($_REQUEST['gsm_opt_host']))
{
    $gsm_opt_host = $_REQUEST['gsm_opt_host'];
    $gsm_opt_api_key = $_REQUEST['gsm_opt_api_key'];
    update_option('gsm_opt_host',$gsm_opt_host);
    update_option('gsm_opt_api_key',$gsm_opt_api_key);
}


        if(isset($_REQUEST['downolad_scraper']))
        {
            $scraper_host = '';
            $scraper_name = '';
            $scraper_host = $_REQUEST['scraper_host'];
            $scraper_name = $_REQUEST['scraper_name'];

        }
        $project_folder = PLUGIN_FILE_URL_usm . '/projects/core/';
        $bootstrap_url = PLUGIN_FILE_URL_usm .'/css/bootstrap.min.css';
        $jquery_url = PLUGIN_FILE_URL_usm .'/js/jquery-3.6.0.min.js';
        $project_css = PLUGIN_FILE_URL_usm.'/css/gsm-custom.css';
        $project_gsm_js = PLUGIN_FILE_URL_usm.'/js/GSM.js';
		$apilink = PLUGIN_FILE_URL_usm . 'projects/core/api.php';







		echo <<<gfdsghfdshglfdhglkfd
<script>
var project_location = '{$project_folder}';
</script>

<link rel="stylesheet" href="{$bootstrap_url}">
<link rel="stylesheet" href="{$project_css}">
<div id="wpbody" role="main">
<div style="background-color: white;width: 100%" class="container">
<div>
<h2>GSM Options</h2>
<small><a href="https://faylab.com/GSM/">GSM Website</a> </small>
<div class="card-header">
Settings
</div>
<div class="card-body">
<form class="form" method="post">
<table>
<tr><th><div class="card-footer">GSM Host </div></th><td><input class="form-control" type="text" name="gsm_opt_host" value="{$gsm_opt_host}"></td></tr>
<tr><th><div class="card-footer">GSM API Key </div></th><td><input class="form-control" type="text" name="gsm_opt_api_key" value="{$gsm_opt_api_key}"></td></tr>
</table>
<div>
<input class="form-control btn btn-primary" type="submit" value="Save">
</div>
</form>

</div>
</div>
<div></div>
<div id="gsmjsworks">
<div class="card-header">
Available Scraper List
</div>
<div id="gsmp1"></div>
<div id="gsmp2"></div>
<div id="gsmp3"></div>
<div id="gsmp4"></div>
</div>

<script src="{$jquery_url}"></script>
<script src="{$project_gsm_js}"></script>
<script>
// call JavaScript here
// Lookinto gsm js file
gsm_list_of_scrapers();


</script>

</div>
	<div>
	<hr>
	<div style="width: 100%; background-color: darkgray"> <p style="padding: 10px">Developer: https://facebook.com/rahul.roktim</p></div>
	<div style="width: 100%; background-color: darkgray"> <p style="padding: 10px">Developer Email: rahulaminroktim@gmail.com</p></div>
	</div>
</div>

gfdsghfdshglfdhglkfd;

	}
}