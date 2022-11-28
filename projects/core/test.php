<?php

$v8 = new V8Js();

/* basic.js */
$JS = <<< EOT
len = print('Hello' + ' ' + 'World!' + "\\n");
len;
EOT;

try {
    var_dump($v8->executeString($JS, 'basic.js'));
} catch (V8JsException $e) {
    var_dump($e);
}




// update 6.7.22


function func_get_content($myurl, $method = 'get', $posts = [], $headers = [],$encoding=0)
{
    global $ROOT;
    sleep(rand(0,3));
    $host = parse_url(urldecode($myurl))['host'];

        $referer = 'https://'.$host;


    //   /*
    if($headers == [])
    {
        $headers = [
            "Host: {$host}",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0",
            "Accept: video/webm,video/ogg,video/*;q=0.9,application/ogg;q=0.7,audio/*;q=0.6,*/*;q=0.5",
            "Accept-Language: en-US,en;q=0.5",
            "Range: bytes=32768-",
            "DNT: 1",
            "Connection: keep-alive",
            "Referer: https://influencersgonewild.com/",
            "Sec-Fetch-Dest: video",
            "Sec-Fetch-Mode: no-cors",
            "Sec-Fetch-Site: cross-site",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            "TE: trailers",
            ];
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

//$content = func_get_content('https://cdn05.influencersgonewild.net/videos/aubree_rene_nude_dildo_masturbation_onlyfans_video_leaked-OUOZMV.mp4');

//file_put_contents('test.mp4',$content);