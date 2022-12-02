<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 12/1/2022
 * Time: 11:12 AM
 */
#for wp
#for kvs

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

    public function GetPageList($limit = 50)
    {
        $urls = [];
        for ($i = 0; $i < 3; $i++) {
            $url = "https://thepornleak.com/page/{$i}/";
            $result = func_get_content($url);
            $dom = str_get_html($result);
            // $links = $dom->find('div.row article.post div.post-inner a.post-link');
            $links = $dom->find('div.td_module_1.td_module_wrap.td-animation-stack div.td-module-image div.td-module-thumb a.td-image-wrap');
            foreach ($links as $link) {
                $urls[md5($link->href)] = $link->href;
            }
            if (count($urls) > $limit) {
                break;
            }
        }
        $urls = array_slice($urls, 0, $limit);
        $this->Url_list = $urls;
        return $urls;
    }


    public function GetPageData($url)
    {
        $this->Weburl = $url;
        if ($this->WebData == '') {
            $this->WebData = func_get_content($url);
        }

        /// title
        $dom = str_get_html($this->WebData);

        if (1) {
            $this->Title = $dom->find('title', 0)->innertext;
            $this->Title = str_replace('&#039;', "'", $this->Title);
            $this->Title = str_replace('&#8211;', '-', $this->Title);
            $this->Title = str_replace('&amp;', '&', $this->Title);
            $this->Title = str_replace(' | The Porn Leak', '', $this->Title);

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
        }


        // categorys
        if (1) {
            $mycat = [];
            $mytag = [];
            $catx = $dom->find('div.td-post-header.td-pb-padding-side ul.td-category li.entry-category a');
            //   $catx = $dom->find('div.inside-article footer.entry-meta span.tags-links a');

            foreach ($catx as $cat) {
                if (strpos($cat->href, 'gory') > 3) {
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
        if (0) {

            $catx = $dom->find('div.inside-article footer.entry-meta span.tags-links a');
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
            $contents = $dom->find('div.td-post-content.td-pb-padding-side', 0);

            // remove junks
            if (1) {
                $rconts = $contents->find('ins.adsbygoogle');
                foreach ($rconts as $rcont) {
                    $rcont->outertext = '';
                }
            }

            //

            $this->Content = $contents;

            $images = [];
            if (1) {
                $imgs = $contents->find('img');
                $x = 0;
                foreach ($imgs as $img) {
                    if (strlen($img->src) > 5) {
                        if (strpos($img->src, 'image/svg') > 0) {
                            continue;
                        }
                        // echo $img->src;
                        $images[$x] = ["[img={$x}]", $img->attr['src']];
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

            // remove junks
            if(1)
            {
                $rconts = $contents->find('noscript');
                foreach ($rconts as $rcont)
                {
                    $rcont->outertext = '';
                }
            }
            // remove noscript
            // replace content

            // video finder
            if(1)
            {
                // find all flowplayers




                $flps = $contents->find('div.flowplayer');
                foreach ($flps as $flp)
                {

                   // $vodpatt = '#\<div id="wpfp.+.mp4[^\>]+\>#';
                    $voddpatt = '#data-item="([^"]+)"#';
                    if(preg_match($voddpatt,$flp,$mtcs))
                    {
                        $nc = html_entity_decode($mtcs[1]);
                        $ncx = json_decode($nc,1);
                        //  print_r($ncx);
                        $vidurl = $ncx['sources'][0]['src'];
                        $rnd = rand(777,9999);
                        $this->Videos[] = ["[vid={$rnd}]", $vidurl];
                        $flp->outertext = "<div>[vid={$rnd}]</div>";
                    }
                }

            }







            $mycontent = remove_script($contents);
            $mycontent = strip_tags($mycontent, '<div><span><h2><h3><h4><h5><ul><ol><li><p><b><strong><input><br><table><tbody><tr><td><th>');
            $mycontent = str_replace('Thepornleak.com','',$mycontent);
            $mycontent = str_replace('thepornleak.com','',$mycontent);
            $mycontent = preg_replace('#ThePornLeak.com#','',$mycontent);

            $mycontent = str_replace('CLICK HERE!','',$mycontent);
            $mycontent = str_replace('WATCH HERE','',$mycontent);
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


}