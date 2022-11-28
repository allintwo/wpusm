/* //IGNORE ME PLEASE// GSM Service added to this plugin
Now this plugin is more dynamic then before...
User can connect to GSM Server and download new scrapers automatically
 */

//CONFIG
//var gsm_api_url = "https://faylab.com/GSM/API.php";
var gsm_api_url = "http://localhost/GSM/API.php";
var gsm_api_location = "http://localhost/GSM/";
var gsm_wants = ['url','action','webdata','resarr','api_key'];
var gsm_actions = ['get_status','get_scraper_list','get_url_list_by_url','get_page_data_by_url'];


//Display
//gsmp1 -list available scrapers - download

function gsm_list_of_scrapers(targetaction = '')
{
    var gsmp1 = document.getElementById('gsmp1');
  //  gsmp1.textContent = "added not";
    $.post(gsm_api_url, {url: 'https://dirtyship.com/sometext',action:'get_scraper_list'}, function(result){
        let nulelm = document.createElement('ol');
        nulelm.classList.add('list-group');
for(i=0;i<result.data.scraper_list.length;i++)
{
    let nelem = document.createElement('li');


    let scraperpath = result.data.scraper_list[i][1];
    let dirsep = '\\';
    if(scraperpath.indexOf('/')>0)
    {
        dirsep = '/';
    }


    let nspath = scraperpath.split(dirsep);
    nspath.pop();
    let newstr = '';
    for (j =0;j<nspath.length;j++)
    {
        newstr += '<span class="badge badge-primary badge-pill">'+nspath[j] + '</span>';
    }
    let scrpaernamedl = result.data.scraper_list[i][1];
    let scraepr_name = result.data.scraper_list[i][0];

    nelem.innerHTML = scraepr_name + newstr + '<span class="gsm-download-btn" data-target="'+scrpaernamedl+'" data-tname="'+scraepr_name+'">Download</span>';

    nelem.classList.add('list-group-item');
    nelem.classList.add('bg-secondary');
    nulelm.appendChild(nelem);
}
gsmp1.appendChild(nulelm);
        gsmscrpaer_download();
    });
}

function gsmscrpaer_download()
{
    let scraperdlbtns = document.querySelectorAll('.gsm-download-btn');
    for (i=0;i<scraperdlbtns.length;i++)
    {

        scraperdlbtns[i].addEventListener('click',function (){
            $.post(project_location+'/gsm_scraper_downloader.php', {download_scraper:'download_scraper',scraper_name:btoa(this.getAttribute('data-tname')),scraper_location: btoa(gsm_api_location + '/Scrapers/Modules/'+this.getAttribute('data-target')),scraper_api_url:btoa(gsm_api_url)}, function(result){
               alert(result)
            });

          // alert(this.getAttribute('data-target'));
        });
    }
   // alert('added')
}


