<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 11/21/2022
 * Time: 8:02 PM
 */



function func_get_content($myurl, $method = 'get', $posts = [], $headers = [],$encoding=0)
{
   // global $ROOT;
    // sleep(rand(0,3));
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
   // file_put_contents($ROOT.'/webpage.txt',$result);

    return $result;
    //  return mb_convert_encoding($result, 'UTF-8','auto');
}






// BUG::
// download scraper and save into modules
if(isset($_REQUEST['download_scraper']))
{
    $supported_hosts = ['localhost','faylab.com'];

    $scraper_name = base64_decode($_REQUEST['scraper_name']);
    $scraper_location = base64_decode($_REQUEST['scraper_location']);
    $scraper_host = parse_url($scraper_location)['host'];
    $scraper_api_url = base64_decode($_REQUEST['scraper_api_url']);
    if(in_array($scraper_host,$supported_hosts))
    {

        $scraper_id = basename($scraper_location);
        $post_str = [
            'action'=> 'download_scraper',
            'scraper_id'=> $scraper_name
        ];
        $scraper_data = func_get_content($scraper_api_url,'post',$post_str);
        $scjsn = json_decode($scraper_data,1);
        if(isset($scjsn['data']['scraper_code']))
        {
            file_put_contents('modules/'.$scraper_id,base64_decode($scjsn['data']['scraper_code']));
        }


        echo 'scraper download complete';
    }else{
        echo 'Host Not support';
    }
}else{
    echo "GSM file loaded...";
}
