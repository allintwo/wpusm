<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 7/6/2022
 * Time: 2:17 PM
 */


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

    public function GetPageList($limit = 5)
    {
        exit;
        $urls = [];
        for ($i = 0; $i < 1; $i++) {
            $offnow = 40 *$i;
            $url = "https://www.opensubtitles.org/en/search/sublanguageid-all/offset-{$offnow}";
            $result = func_get_content($url);
           // echo $result;exit();
            $dom = str_get_html($result);
           // $links = $dom->find('div.row article.post div.post-inner a.post-link');
            $links = $dom->find('table#search_results tbody tr td strong a.bnone');
            foreach ($links as $link) {
                $newurl ='https://www.opensubtitles.org'. $link->href;
                $newurl =  $this->deep_layer($newurl);
                $urls[md5($link->href)] = $newurl;
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

    function deep_layer($url)
    {
        $pattarn = '"/en/search/sublanguageid-all/idmovie-\d+"';
        $page = func_get_content($url);
        preg_match($pattarn,$page,$mtc);
        if($mtc[0])
        {
            return 'https://www.opensubtitles.org'. $mtc[0];
        }
       return null;
    }



    public function GetPageData($url)
    {
        exit();
        $this->Weburl = $url;
        if ($this->WebData == '') {
            $this->WebData = func_get_content($url);
        }

       // echo $this->WebData;exit();
        /// title
        $dom = str_get_html($this->WebData);

        if (1) {
            $this->Title = $dom->find('h1', 0)->innertext;
            $this->Title = str_replace('&#039;', "'", $this->Title);
            $this->Title = str_replace('&#8211;', '-', $this->Title);
            $this->Title = str_replace('&amp;', '&', $this->Title);

        }
        // get thumb
        if (0) // no easy image
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
        if (0) {
            $mycat = [];
            $mytag = [];
            $catx = $dom->find('div.inside-article footer.entry-meta span.cat-links a');
         //   $catx = $dom->find('div.inside-article footer.entry-meta span.tags-links a');

            foreach ($catx as $cat) {
                if (strpos($cat->attr['rel'], 'gory') > 3) {
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
            $contents = $dom->find('table#search_results', 0);

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


            $subtitle_table_html = '';

            if(1) // find downloadabledata
            {
                for ($i =0;$i<2;$i++)
                {
                    $trs = $contents->find("//tr");
                    foreach ($trs as $tr)
                    {
                       // echo 1;
                        $tdcounts = $tr->find('td');
                        if(count($tdcounts)< 3)
                        {
                            continue;
                        }

                        $tds = $tr->find('td',0);
                        foreach (@$tds->children as $childNode)
                        {
                            if(strpos($childNode->outertext,'span')>0)
                            {

                            }else{
                                $childNode->outertext = '';
                            }
                        }

                        $language = 'English';
                       $language =  $tdcounts[1]->find('a',0)->attr['title'];


                        $titlename = trim(strip_tags($tds->innertext));
                        $dl_link = "https://www.opensubtitles.org". $tdcounts[4]->find('a',0)->href;
                        $fileid = basename($dl_link);

                        $subtitle_table_html .= "<li>{$titlename} {$fileid} {$language}</li>";
                    }
                }

            }



          //  $this->Content = $subtitle_table_html;


//            foreach ($contents->find('*[style]') as $element) {
//                $element->style = null;
//               // $element->class = null;
//            }


            // a work
            //   $ancrs = $contents->find('a[target="_blank"]');
//            $ancrs = $contents->find('a');
//            foreach ($ancrs as $ancr)
//            {
//
//                $ah = $ancr->href;
//                $ah_txt = $ancr->plaintext;
//                if(strpos($ah,'refid_')>0)
//                {
//
//                }else{
//                    $ancr->outertext = $ah_txt;
//                }
//            }


            // find all images
//            if(1)
//            {
//                $imgsx = $contents->find('img');
//                foreach ($imgsx as $img)
//                {
//                    $link = $img->src;
//                    if(strlen($link)>10)
//                    {
//
//                    }
//                }
//
//            }


         //   $mycontent = remove_script($contents);
        //    $mycontent = strip_tags($mycontent, '<div><span><a><h2><h3><h4><h5><ul><ol><li><p><b><strong><input><br><table><tbody><tr><td><th>');

            $this->Content = $subtitle_table_html;

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