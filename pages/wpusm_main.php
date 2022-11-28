<?php
// simple page template
class wpusm_main{
	public $pagetitle = PLUGIN_NAME_usm.'-Dashboard';
	public $menutitle = 'WPusm';
	public $call = 'display';

	public function display()
	{
		$project_name = 'fapfappy';
		$project_folder = PLUGIN_FILE_URL_usm . '/projects/core/';
		$bootstrap_url = PLUGIN_FILE_URL_usm .'/css/bootstrap.min.css';
		$jquery_url = PLUGIN_FILE_URL_usm .'/js/jquery-3.6.0.min.js';
		$project_css = $project_folder.'css/style.css';
		$project_js = $project_folder.'js/sc1.js';

$mytime = time() . '000';
		echo <<<sdfdslfhdgdfhgord
<!-- add css -->
<link rel="stylesheet" href="{$bootstrap_url}">
<link rel="stylesheet" href="{$project_css}">
<div id="wpbody" role="main">
<div class="container-fluid myrpf_body container"></div>
<div id="myrpf_alert"></div>
<main class="card-header col-12" role="main" id="wpbody-content">
<h3 class="col-12 text-center alert-primary alert"> WPUSM Scraper </h3>
<header class="navbar navbar">
<div class="input-group">
  <span class="input-group-text">URL</span>
  <textarea id="myrpfurl" class="col-12 form-control" placeholder="Insert url" rows="4" cols="4"></textarea>
  <button class="btn btn-outline-success" id="myrpfadd">Add</button>
</div>

</header>
<!-- spinner -->
<div class="progress" id="myrpfxproc" style="display: none">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
</div>

<!-- end spiner -->
<div class="clearfix"></div>
<div> <p id="myrpf_debug"><time datetime="$mytime" id="myrpflct">x</time></p></div>
<div id="xprocessing" class="alert alert-success"></div>
</main>
</div>
<div class="clearfix"></div>
<div class="clear"></div>
<!-- add javascript -->
<script src="{$jquery_url}"></script>
<script src="{$project_js}"></script>

<script >

 var lasturl = "";

$(document).ready(function() {
   
    
    
    
    
    $("#myrpfadd").click(function(){
         $("#myrpfxproc").fadeIn(300);
         
        var txt = $("#myrpfurl").val();
        if(lasturl === txt) // Avoid multi click click 
        {
           alert('Please input another url. This url working..');
           console.log("Multi thread disabled for cpu issue");
         txt = ''; // making empty url
         }else{
            lasturl = txt;
          }
  // new system for multi urls 
        var urls = txt
        var expression = /.+/gi;
        var regex = new RegExp(expression);
        var xtheArray = urls.split(/\s+/);
       // alert(xtheArray.length)
  
       // filter array 
       var xfilterArray = [];
        xtheArray.forEach(function(newurl) {
            newurl = newurl.trim()
            if (newurl.match(regex)) {
                if(newurl.indexOf('://')>2)
                    {
                        xfilterArray.push(newurl)
                    }else{
                    // $("#xprocessing").prepend( "<div class='alert alert-danger'>Wrong url: " + newurl + "</div>" );
                    }
            } else {
              //  $("#xprocessing").prepend( "<div class='alert alert-danger'>Fail: " + newurl + "</div>" );
            }
        });
       // alert(xfilterArray[0]);
       // call detonator 
            var nowindex = 0;
       function detonator(indexnum){
           if(indexnum  < xfilterArray.length)
               {
                var   newurl = xfilterArray[indexnum];
                
     var newdateid = Date.now(); 
    $("#xprocessing").prepend( "<div class='alert alert-success'><b id='"+newdateid+"'>Working</b>: " + newurl + "</div>" );                     
	$.post("{$project_folder}api.php", {url: newurl}, function(result){
      setTimeout(function(){
        $("#myrpfxproc").fadeOut(300);
      },500); 
      setTimeout(function(){
        $("#myrpfxalert").fadeOut(300);
      },5000);
            $("#myrpf_debug").html(result);
            $("#"+newdateid).html('Complete');
            // recurc
        indexnum++;
        detonator(indexnum);
        });
	
          }
       } 
       if(xfilterArray.length>0)
         {
           detonator(0);// star from 0
         }
       
 /*       
        $.post("{$project_folder}api.php", {url: txt}, function(result){
      setTimeout(function(){
        $("#myrpfxproc").fadeOut(300);
      },500); 
      setTimeout(function(){
        $("#myrpfxalert").fadeOut(300);
      },5000);
            $("#myrpf_debug").html(result);
           
        });
    */    
        
        
        
    });
   
     setInterval(checktime, 1000);
});
        function checktime()
        {
            var myvar = $('#myrpflct').attr('datetime');
          //  alert(myvar);
            var aDay = 24*60*60*1000;
            var newvar = (Date.now()-myvar) / 1000;
            
           
           if(lasturl === '')
               {
                   
               }else{
            $('#myrpflct').html("Last run " + timeSince(myvar) + " Ago");    
               }
           
            // console.log(timeSince(new Date(Date.now()-aDay*2)));
        }

function timeSince(date) {

            //  var seconds = Math.floor((new Date() - date) );
            var seconds = Math.floor((Date.now() - date) / 1000);

            var interval = seconds / 31536000;

            if (interval > 1) {
                return Math.floor(interval) + " years";
            }
            interval = seconds / 2592000;
            if (interval > 1) {
                return Math.floor(interval) + " months";
            }
            interval = seconds / 86400;
            if (interval > 1) {
                return Math.floor(interval) + " days";
            }
            interval = seconds / 3600;
            if (interval > 1) {
                return Math.floor(interval) + " hours";
            }
            interval = seconds / 60;
            if (interval > 1) {
                return Math.floor(interval) + " minutes";
            }
            return Math.floor(seconds) + " seconds";
        }
</script>

sdfdslfhdgdfhgord;

	}
}