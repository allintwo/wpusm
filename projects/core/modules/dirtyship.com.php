<?php
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

    public function GetPageList($limit = 5)
    {
        $urls = [];
        for ($i = 0; $i < 5; $i++) {
            $offnow = 40 *$i;
            $url = "https://dirtyship.com/page/{$i}/";
            $result = func_get_content($url);
           // echo $result;exit();
            $dom = str_get_html($result);
           // $links = $dom->find('div.row article.post div.post-inner a.post-link');
            $links = $dom->find('ul.Thumbnail_List li.thumi div.thumb_bar a.title');
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




    public function GetPageData($url)
    {
        $this->Weburl = $url;
        if ($this->WebData == '') {
            $this->WebData = func_get_content($url);
        }


        file_put_contents('infl.txt',$this->WebData);
       // echo $this->WebData;exit();
        /// title
        $dom = str_get_html($this->WebData);

        if (1) {
            $this->Title = $dom->find('title', 0)->innertext;
            $this->Title = str_replace(' - DirtyShip.com', "", $this->Title);
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
            $catx = $dom->find('div.about-content div.content-data.clearfix div.col.right-col p.data-row a');
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

            $catx = $dom->find('div.about-content div.content-data.clearfix div.col.right-col p.data-row a');
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
            $contents = $dom->find('div#player div.video_player', 0);

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
            if (0) {
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
                            break;
                            $x++;
                        }
                    }
                }
                $this->Videos = $videos;
            }

$models = [];
            if (1) {
                $mods = $contents->find('div.about-content div.content-data.clearfix ul.post_performers li a');
                foreach ($mods as $mod) {
                    if (strlen($mod->href) > 10) {
                        $modelname = basename($mod->href);
                        $models[] = [$modelname,$modelname];
                    }
                }
                $this->Models = $models;
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


}