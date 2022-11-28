<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 9/8/2022
 * Time: 10:40 PM
 */
// create a folder opensubtitles


if(isset($_REQUEST['h']) && $_REQUEST['h'] == 'opensubtitles')
{
    $fileid = $_REQUEST['fileid'];

    $dl_link2 = "https://files.englishsubtitles.co/download.php?h=opensubtitles&fileid={$fileid}";
    $maindomain = 'https://files.englishsubtitles.co/';
    $go_download = $dl_link2;

}




// load module
function opensubtitles_download($fileid)
{
    $url = "https://www.opensubtitles.org/en/subtitleserve/sub/".$fileid;
  //  header('location: '.$url);exit();
    $filedata = '';
    $op_folder = 'opensubtitles';
    $filename = $op_folder.'/'.$fileid .'.zip';
    if(is_file($filename))
    {
       // $filedata = file_get_contents($filename);
    }else{

        $filedata = func_get_content($url);
        if(strlen($filedata)>1000)
        {
            file_put_contents($filename,$filedata);
        }
    }
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length: ".filesize($filename));
    header("Content-Disposition: attachment; filename=\"".basename($filename)."\"");
    readfile($filename);
    exit;
}


if(isset($_REQUEST['h']))
{
    if($_REQUEST['h'] =='opensubtitles')
    {
        $fileid = $_REQUEST['fileid'];
        opensubtitles_download($fileid);exit();
    }
}



function func_get_content($myurl, $method = 'get', $posts = [], $headers = [],$encoding=0)
{
    global $ROOT;
    sleep(rand(0,3));
    $host = parse_url(urldecode($myurl))['host'];
    //   /*
    if($headers == [])
    {
        $headers = [
            "Host: ".$host,
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.00",
            "Accept-Language: en-US,en;q=0.5",
            // "Accept-Encoding: gzip, deflate, br",
            "Connection: keep-alive",
            "Upgrade-Insecure-Requests: 1",
            "Cookie: __cfduid=d90afa45f71b357b88f14e10de68a55f91617514769; _ga=GA1.2.1021983108.1617729346; _gid=GA1.2.334785237.1617729346; _gat_gtag_UA_188463090_1=1",
            "TE: Trailers",];
    }
    // */

    $myurl = str_replace(" ","%20",$myurl);
    // global $range;
    $ch = curl_init();

    //  $agent = 'tab mobile';
    // curl_setopt($ch, CURLOPT_PROXY, '85.26.146.169:80');
    curl_setopt($ch, CURLOPT_URL, $myurl);
    // curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

    //  curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
    //  curl_setopt( $ch, CURLOPT_COOKIEFILE,dirname(__FILE__) . '/cookie.txt');
    //  curl_setopt($ch, CURLOPT_HEADER, true); // header
    // curl_setopt($ch, CURLOPT_NOBODY, true); // header
    curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
    //  curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_RANGE, $range);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch,CURLOPT_TIMEOUT , 60);
    # sending manually set cookie
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if($method != 'get')
    {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($posts));
    }

    //  curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"serialno\":\"$code\"}");


    //   $error = curl_error($ch);
    $result = curl_exec($ch);
    curl_close($ch);
    if($encoding)
    {
        return mb_convert_encoding($result, 'utf-8','auto');
    }

    // debug
    file_put_contents($ROOT.'/webpage.txt',$result);

    return $result;
    //  return mb_convert_encoding($result, 'UTF-8','auto');
}