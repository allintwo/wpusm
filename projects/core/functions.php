<?php

function wpusm_realpath_to_url($realpath,$domain_url)
{
    $realpath = str_replace('\\','/',$realpath);
    $hroot = $_SERVER['DOCUMENT_ROOT'];
    // echo $hroot .'////'.$realpath;
    $nurl = str_replace($hroot,'',$realpath);
    return  $domain_url . '/' .$nurl;
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
//todo add weblight
function func_get_content_weblight($myurl, $method = 'get', $posts = [], $headers = [],$encoding=0)
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



function remove_script($_response_body)
{

        $_response_body = preg_replace('#<\s*script[^>]*?>.*?<\s*/\s*script\s*>#si', '', $_response_body);
        $_response_body = preg_replace("#(\bon[a-z]+)\s*=\s*(?:\"([^\"]*)\"?|'([^']*)'?|([^'\"\s>]*))?#i", '', $_response_body);
        $_response_body = preg_replace('#<noscript>(.*?)</noscript>#si', strip_tags("$1"), $_response_body);
 return $_response_body;
}
function remove_image($_response_body)
{
return $_response_body = preg_replace('#<(img|image)[^>]*?>#si', '', $_response_body);
}

function downloadfile($url,$path)
{

	$host = parse_url(urldecode($url))['host'];
	//   /*

		$headers = [
			"Host: ".$host,
			"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.00".rand(0,999999),
			"Accept-Language: en-US,en;q=0.5",
			// "Accept-Encoding: gzip, deflate, br",
			"Referer: https://{$host}"
		];


    set_time_limit(0);
//This is the file where we save the    information
    $fp = fopen ($path, 'w+');
//Here is the file we are downloading, replace spaces with %20
    $ch = curl_init(str_replace(" ","%20",$url));
    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
// write curl response to file
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// get curl response
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}

function downloadVidfile($url,$path)
{

	$host = parse_url(urldecode($url))['host'];
	//   /*

	$headers = [
		 "Host: {$host}",
		"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0",
		"Accept: video/webm,video/ogg,video/*;q=0.9,application/ogg;q=0.7,audio/*;q=0.6,*/*;q=0.5",
		"Accept-Language: en-US,en;q=0.5",
		"Range: bytes=0-",
		"Connection: keep-alive",
		"Referer: https://{$host}/",
		"Pragma: no-cache",
		"Cache-Control: no-cache"
		];


    set_time_limit(0);
//This is the file where we save the    information
    $fp = fopen ($path, 'w+');
//Here is the file we are downloading, replace spaces with %20
    $ch = curl_init(str_replace(" ","%20",$url));
    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
	// curl_setopt($ch, CURLOPT_HEADER, true); // header
	// curl_setopt($ch, CURLOPT_NOBODY, true); // header
// write curl response to file
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// get curl response
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}

function downloadfile_fig($url,$path)
{

	$host = parse_url(urldecode($url))['host'];
	//   /*

	$headers = [
		"Host: {$host}",
		"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0",
		"Accept: video/webm,video/ogg,video/*;q=0.9,application/ogg;q=0.7,audio/*;q=0.6,*/*;q=0.5",
		"Accept-Language: en-US,en;q=0.5",
		"Pragma: no-cache",
		"Cache-Control: no-cache",
		"Range: bytes=0-",
		"Referer: https://famousinternetgirls.com/video/karli-roses-vibrating-her-clit-onlyfans-insta-leaked-videos/",
		"Connection: keep-alive",
		"Cookie: __cfduid=d90afa45f71b357b88f14e10de68a55f91617514769; _ga=GA1.2.1021983108.1617729346; _gid=GA1.2.334785237.1617729346; _gat_gtag_UA_188463090_1=1"
	];


	set_time_limit(0);
//This is the file where we save the    information
	$fp = fopen ($path, 'w+');
//Here is the file we are downloading, replace spaces with %20
	$ch = curl_init(str_replace(" ","%20",$url));
	// curl_setopt($ch, CURLOPT_HEADER, true); // header
	// curl_setopt($ch, CURLOPT_NOBODY, true); // header
	curl_setopt($ch, CURLOPT_TIMEOUT, 50);
// write curl response to file
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// get curl response
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}
function downloadfile_fi_finfl($url,$path)
{

    $filename = basename($url);

    $random_cdn = [
        'https://cdn04.influencersgonewild.net/videos/',
        'https://cdn05.influencersgonewild.net/videos/',
        'https://cdn06.influencersgonewild.net/videos/',
        'https://cdn07.influencersgonewild.net/videos/',
    ];

    $url = $random_cdn[rand(0,3)].$filename;

	$host = parse_url(urldecode($url))['host'];
	//   /*
	$headers = [
		"Host: {$host}",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0",
        "Accept: video/webm,video/ogg,video/*;q=0.9,application/ogg;q=0.7,audio/*;q=0.6,*/*;q=0.5",
        "Accept-Language: en-US,en;q=0.5",
        "Range: bytes=0-",
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


	set_time_limit(0);
//This is the file where we save the    information
	$fp = fopen ($path, 'w+');
//Here is the file we are downloading, replace spaces with %20
	$ch = curl_init(str_replace(" ","%20",$url));
	// curl_setopt($ch, CURLOPT_HEADER, true); // header
	// curl_setopt($ch, CURLOPT_NOBODY, true); // header
	curl_setopt($ch, CURLOPT_TIMEOUT, 50);
// write curl response to file
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// get curl response
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}
function downloadfile_fi_finfl2($url,$path)
{
    $host = parse_url(urldecode($url))['host'];
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

    $myurl = str_replace(" ","%20",$url);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $myurl);
    curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch,CURLOPT_TIMEOUT , 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    file_put_contents($path,$result);
    curl_close($ch);
    return $result;
}
function downloadfile_fi_dirtyship($url,$path)
{

	$host = parse_url(urldecode($url))['host'];
	//   /*

	$headers = [
		"Host: {$host}",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0",
        "Accept: video/webm,video/ogg,video/*;q=0.9,application/ogg;q=0.7,audio/*;q=0.6,*/*;q=0.5",
        "Accept-Language: en-US,en;q=0.5",
        "Range: bytes=0-",
        "DNT: 1",
        "Connection: keep-alive",
        "Referer: https://dirtyship.com/",
        "Sec-Fetch-Dest: video",
        "Sec-Fetch-Mode: no-cors",
        "Sec-Fetch-Site: cross-site",
        "Pragma: no-cache",
        "Cache-Control: no-cache",
        "TE: trailers",
	];


	set_time_limit(0);
//This is the file where we save the    information
	$fp = fopen ($path, 'w+');
//Here is the file we are downloading, replace spaces with %20
	$ch = curl_init(str_replace(" ","%20",$url));
	// curl_setopt($ch, CURLOPT_HEADER, true); // header
	// curl_setopt($ch, CURLOPT_NOBODY, true); // header
	curl_setopt($ch, CURLOPT_TIMEOUT, 50);
// write curl response to file
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// get curl response
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}
function downloadfile_prothot($url,$path)
{

	$host = parse_url(urldecode($url))['host'];
	//   /*

	$headers = [
		"Host: {$host}",
		"User-Agent: Mozilla/5.0 (Windows NT 10.0; rv:78.0) Gecko/20100101 Firefox/78.0",
		"Accept: video/webm,video/ogg,video/*;q=0.9,application/ogg;q=0.7,audio/*;q=0.6,*/*;q=0.5",
		"Accept-Language: en-US,en;q=0.5",
		"Referer: https://prothots.com/",
		"Range: bytes=0-",
		"Connection: keep-alive",
		"Cookie: _ga=GA1.2.1987636676.1617902642; _gid=GA1.2.1196242522.1617902642; _gat_gtag_UA_166029244_1=1",
		"TE: Trailers",
	];


	set_time_limit(0);
//This is the file where we save the    information
	$fp = fopen ($path, 'w+');
//Here is the file we are downloading, replace spaces with %20
	$ch = curl_init(str_replace(" ","%20",$url));
	// curl_setopt($ch, CURLOPT_HEADER, true); // header
	// curl_setopt($ch, CURLOPT_NOBODY, true); // header
	curl_setopt($ch, CURLOPT_TIMEOUT, 50);
// write curl response to file
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// get curl response
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}
function downloadfile_universal_infl1($url,$path,$referer = '')
{


	$host = parse_url(urldecode($url))['host'];
	//   /*

    if($referer =='')
    {
        $referer = 'https://'.$host;
    }

   // echo $referer;exit();

	$headers = [
        "Host: {$host}",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0",
        "Accept: video/webm,video/ogg,video/*;q=0.9,application/ogg;q=0.7,audio/*;q=0.6,*/*;q=0.5",
        "Accept-Language: en-US,en;q=0.5",
        "Range: bytes=0-",
        "DNT: 1",
        "Connection: keep-alive",
        "Referer: {$referer}",
        "Sec-Fetch-Dest: video",
        "Sec-Fetch-Mode: no-cors",
        "Sec-Fetch-Site: cross-site",
        "Pragma: no-cache",
        "Cache-Control: no-cache",
        "TE: trailers",
	];


	set_time_limit(0);
//This is the file where we save the    information
	$fp = fopen ($path, 'w+');
//Here is the file we are downloading, replace spaces with %20
	$ch = curl_init(str_replace(" ","%20",$url));
	// curl_setopt($ch, CURLOPT_HEADER, true); // header
	// curl_setopt($ch, CURLOPT_NOBODY, true); // header
    curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
	curl_setopt($ch, CURLOPT_TIMEOUT, 50);
// write curl response to file
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// get curl response
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}


function downloadBigFile($file_source, $file_target) {
	$n = fopen($file_target,'w+');
	fclose($n);

    $rh = fopen($file_source, 'rb');
    $wh = fopen($file_target, 'w+b');
    if (!$rh || !$wh) {
        return false;
    }

    while (!feof($rh)) {
        if (fwrite($wh, fread($rh, 4096)) === FALSE) {
            return false;
        }
        echo ' ';
        flush();
    }

    fclose($rh);
    fclose($wh);

    return true;
}

function complete_url2($url, $baseurl) // base url = main url . nowbase = dirname()
{

	$url = trim($url);

	if ($url === '')
	{
		return '';
	}

	switch ($url[0])
	{
		case '/':
			if(substr($url, 0, 2) === '//')
			{
				return 'https:'.$url;
			}else{
				return $baseurl.$url;
			}
		case '?':
			return $baseurl . '/'.$url;
		case '#':
			return '';
		case ':':
			return 'https'. $url;
	}
	$urlx = parse_url($url);
	if(isset($urlx['scheme']))
	{
		if(isset($urlx['host']))
		{
			if(isset($urlx['path']))
			{
				return $url;
			}
		}
	}else{
		return $baseurl.'/'.$url;
	}

	return  $url;
}
