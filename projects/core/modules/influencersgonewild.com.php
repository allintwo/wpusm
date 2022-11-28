<?php
#for wp
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 7/6/2022
 * Time: 2:17 PM
 */

// not working - cloud flare blocks

class common_xworker
{

    public $Weburl = '';
    public $WebData = '';
    public $PostThumb = '';

    public $Title = '';
    public $Categorys = [];
    public $Tags = [];
    public $Content = '';
    public $Images = [];
    public $Videos = [];
    public $Models = [];
    public $Url_list = [];
    public $app = null;

    // public $mask = 'https://googleweblight.com/i?u=';
    public $mask = 'https://googleweblight.com/sp?hl&u=';

    public function GetPageList($limit = 5) // common
    {

        $urls = [];
        for ($i = 0; $i < 5; $i++) {
            $offnow = 40 *$i;
            $url = "https://influencersgonewild.com/page/{$i}/";
            $result = $this->func_get_content($url);
            // echo $result; echo 'done';exit();
            $dom = str_get_html($result);
            // $links = $dom->find('div.row article.post div.post-inner a.post-link');
            $links = $dom->find('header.entry-header h3.g1-delta.g1-delta-1st.entry-title a');
            foreach ($links as $link) {

                $urls[md5($link->href)] = $link->href;
                //  exit();
            }
            if (count($urls) > $limit) {
                break;
            }
        }
        $urls = array_slice($urls, 0, $limit);
        $this->Url_list = $urls;
        return $urls;
    }
    public function Get_urls_by_Webdata($webdata,$limit = 10) // common
    {
        $urls = [];
            $dom = str_get_html($webdata);
            // $links = $dom->find('div.row article.post div.post-inner a.post-link');
            $links = $dom->find('header.entry-header h3.g1-delta.g1-delta-1st.entry-title a');
            foreach ($links as $link) {
                $urls[md5($link->href)] = $link->href;
                //  exit();
            }

            if($limit == 0)
            {

            }else{
                $urls = array_slice($urls, 0, $limit);
            }

        $this->Url_list = $urls;
        return $urls;
    }




    public function GetPageData($url)
    {
        $this->Weburl = $url;
        if ($this->WebData == '') {
            $this->WebData = func_get_content($url);
        }


      //  file_put_contents('infl.txt',$this->WebData);
        // echo $this->WebData;exit();
        /// title
        $dom = str_get_html($this->WebData);

        if (1) {
            $this->Title = $dom->find('title', 0)->innertext;
            $this->Title = str_replace(' - Influencers Gonewild', "", $this->Title);
            $this->Title = str_replace('&#039;', "'", $this->Title);
            $this->Title = str_replace('&#8211;', '-', $this->Title);
            $this->Title = str_replace('&amp;', '&', $this->Title);

        }
        // get thumb
        if (1) // no easy image
        {
            $metas = $dom->find('meta');
            foreach ($metas as $meta) {
                if (isset($meta->attr['property'])) {
                    if ($meta->attr['property'] == 'og:image') {
                        $thumb = $meta->attr['content'];
                        $this->PostThumb = $thumb;

                    }
                }
            }
        }else{
            $thumbs = $dom->find('div.content div.msg div img',0)->src;
            $this->PostThumb = $thumbs;
        }


        // categorys
        if (1) {
            $mycat = [];
            $mytag = [];
            $catx = $dom->find('span.entry-categories.entry-categories-l span.entry-categories-inner a.entry-category');
            //   $catx = $dom->find('div.inside-article footer.entry-meta span.tags-links a');

            foreach ($catx as $cat) {
                if (strpos($cat->href, 'gory/') > 3) {
                    $mycat[] = [basename($cat->href), trim($cat->innertext)];
                } elseif (strpos($cat->href, '/tag/') > 3) {
                    $mytag[] = [basename($cat->href), trim($cat->innertext)];
                }
            }
            $this->Categorys = $mycat;
            $this->Tags = $mytag;
            //  $this->Tags = $mytag;
        }
        // Tags
        if (1) {

            $catx = $dom->find('p.entry-tags span.entry-tags-inner a.entry-tag');
            $mytag = [];
            foreach ($catx as $cat) {
                if (strpos($cat->href, '/tag/') > 3) {
                    $mytag[] = [basename($cat->href), trim($cat->innertext)];
                }
            }
            $this->Tags = $mytag;
            //  $this->Tags = $mytag;
        }
        // content




        $refer_list_data = [];
        if (1) {
            $contents = $dom->find('div.entry-inner.g1-card.g1-card-solid div.g1-content-narrow.g1-typography-xl.entry-content', 0);

            // remove junks
            if(0)
            {
                $rconts = $contents->find('ins.adsbygoogle');
                foreach ($rconts as $rcont)
                {
                    $rcont->outertext = '';
                }
            }

            //


            $images = [];
            if (1) {
                $imgs = $contents->find('img');
                $x = 0;
                foreach ($imgs as $img) {
                    if (strlen($img->src) > 5) {
                        $imglink = $img->src;
                        if (strpos($img->src, 'image/svg') > 0) {
                            if(isset($img->attr['data-src']))
                            {
                                // $img->src = $img->attr['data-src'];
                                $imglink =  $img->attr['data-src'];
                            }else{
                                continue;
                            }
                        }
                        // echo $img->src;
                        $images[$x] = ["[img={$x}]", $imglink];
                        //  $img->innertext = "[img={$x}]";
                        $img->innertext = "[img={$x}]";
                        $x++;
                    }
                }
                $this->Images = $images;
            }
            $videos = [];
            if ($_SERVER['HTTP_HOST'] == 'xyz.com') {

            } else {
                if (1) {
                    $vids = $contents->find('source');
                    $x = 0;
                    foreach ($vids as $vid) {
                        if (strlen($vid->src) > 10) {
                            $videos[] = ["[vid={$x}]", $vid->src];
                            $vid->innertext = "[vid={$x}]";
                            $x++;
                        }
                    }
                }
                $this->Videos = $videos;
            }


            $mycontent = remove_script($contents);
            $mycontent = strip_tags($mycontent, '<div><span><h2><h3><h4><h5><ul><ol><li><p><b><strong><input><br><table><tbody><tr><td><th>');

            $this->Content = $mycontent;

            //  $this->PostFix($contents);
        }
        $this->appbuild(); // easy call for api
    }

    function appbuild()
    {
        $this->app = new stdClass();
        $this->app->Title = $this->Title;
        $this->app->PostThumb = $this->PostThumb;
        $this->app->Content = $this->Content;
        $this->app->Categorys = $this->Categorys;
        $this->app->Tags = $this->Tags;
        $this->app->Images = $this->Images;
        $this->app->Videos = $this->Videos;
        $this->app->Models = $this->Models;
        $this->app->Weburl = $this->Weburl;
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
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:104.0) Gecko/20100101 Firefox/104.0",
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
                "Accept-Language: en-US,en;q=0.5",
                //"Accept-Encoding: gzip, deflate, br",
                "DNT: 1",
                "Connection: keep-alive",
                "Cookie: cf_clearance=oyyUo.DFy2K1RY8NMmSUxyv4L2f5WgIXXHivRgrELnY-1661989165-0-150; __cf_bm=tMZAbB_tjCkUCw0PaAEDM6jVIBDaOW6RrhOhe0cdTKA-1661989171-0-AawtBog9cH8AbEwF8c9Yf7lde/EDhZzw62kdjPY4R2mL4HLiSZ1jKigC6MJlBax00m3jgW8NU4z0/Wcv+Bg7liUr3rfh5+1ainOSnGJWzyit9kiXKbMCMyyU8S11veghFA==",
                "Upgrade-Insecure-Requests: 1",
                "Sec-Fetch-Dest: document",
                "Sec-Fetch-Mode: navigate",
                "Sec-Fetch-Site: none",
                "Sec-Fetch-User: ?1",
                "Pragma: no-cache",
                "Cache-Control: no-cache",
                "TE: trailers",
                //  "X-Requested-With: XMLHttpRequest"
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

        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/infgw_cookie.txt');
        curl_setopt( $ch, CURLOPT_COOKIEFILE,dirname(__FILE__) . '/infgw_cookie.txt');
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


}