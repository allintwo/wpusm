<?php
// control all api request
// response will be JSON FILE
set_time_limit(0);
ini_set('mbstring.func_overload 0',0);

ini_set('max_execution_time',0);
ini_set('memory_limit','2048M'); // 2GB
ini_set('error_log',1);
error_reporting(1);


include_once 'functions.php';

 $mask2 = 'https://actiontrick.tk/';  // mask - web proxy to avoid ban
 $mask = '';  // default server request (important)
 $masky = '';

$wproot = realpath('../../../../..');
$wproot = realpath('../../../../..');

$author_id = 1;
include_once $wproot.'/wp-config.php';

function find_wordpress_base_path() {
    $dir = dirname(__FILE__);
    do {
        //it is possible to check for other files here
        if( file_exists($dir."/wp-config.php") ) {
            return $dir;
        }
    } while( $dir = realpath("$dir/..") );
    return null;
}
//define( 'BASE_PATH', find_wordpress_base_path()."/" );

$wp_url = wpusm_realpath_to_url($wproot,"https://{$_SERVER['HTTP_HOST']}");
// echo $wp_url;exit();
//$wphttp = 'https://'. $_SERVER['HTTP_HOST'] . '/';
$wphttp = $wp_url;

$upload_folder = $wproot .'/wp-content/uploads/';
$today_uploadfolder = $upload_folder .  date('Y/m/');
$today_uploadhttp = $wphttp . '/wp-content/uploads/' .date('Y/m/');



// update 6.7.22
$myprojects = [];

$modules_path = 'modules';
$modules_paths = array_diff(scandir($modules_path), array('.', '..'));
foreach ($modules_paths as  $module_filename)
{
    // echo $module_filename . "<br/>";
    $hstnme = substr($module_filename,0,-4);
    $myprojects[$hstnme] = [$hstnme,'modules/'.$module_filename];
}

//$myprojects = [
//	'host.com' => ['host','lib/host.com.php'],
//];


// $req = $_POST; // real mode
$req = $_REQUEST; // debug mode
// if(isset($_REQUEST['url']))  // Avoid refreshed get request
if(isset($req['url']))
{
	$urlhost  = '';
	$x = '';
	$url = urldecode($req['url']);

	$mytime = time() .'000';
	$timealhtml = '<time datetime="'.$mytime.'" id="myrpflct">run Time</time>';

	if(strlen($url)>14)
	{
		include_once 'config.php';

		include_once 'lib/simple_html_dom.php';

		$app = null;
		$myurl = parse_url($url);
		$urlhost = $myurl['host'];


		$goodurl = 0;
		foreach ($myprojects as $myprojecthost => $project_info)
		{
			if($urlhost == $myprojecthost )
			{
				if(is_file($project_info[1]))
				{
					include_once $project_info[1];
					// $app = new $project_info[0];
					$app = new common_xworker();

					$goodurl = 1;
					$app->Weburl = 'https://'.$urlhost;
				}
			}
		}

		if($goodurl){}else{echo "<div id='myrpfxalert' class='alert alert-danger'>Wrong url !</div>";exit();}


		$app->GetPageData($mask.$url);
        if(isset($_GET['json']))
        {
           echo json_encode($app);exit();
        }

        // 17.11.22
        wpusm_add_request_log($url);

	//	downloadVidfile('https://cdn10.dirtyship.net/dirtyship/cdn2/BDelpbathbv.mp4','test.mp4');
		if(1) // debug
		{
		    echo $app->Title;
		    echo '-title---';
		    echo $app->PostThumb;
		    echo '----';
			echo $app->Content;
			echo '<pre>';
			echo 'cateforys =';
			print_r($app->Categorys);
			echo 'tagas = ';
			print_r($app->Tags);
			echo 'images =';
			print_r($app->Images);
			echo 'videos=';
			print_r($app->Videos);
			echo 'models=';
			print_r($app->Models);
			echo '</pre>';
			exit();
		}
		$tmpthumb = '';

		if(strlen($app->Title) >5)
		{
            $url = $app->Weburl;
			// content build - bbcode to url and download
			// print_r($app->Images);

			if(is_dir($today_uploadfolder)) // create folder if needed
			{

			}else{
				mkdir($today_uploadfolder,777,1);
			}
			$i=0;
			foreach ($app->Images as $imgx)
			{
				// $fname = basename($imgx[1]); // little fix
				$fname= basename(parse_url($imgx[1])['path']);
				if(Is_goodExt($fname,'image'))
				{
				    if(strlen($app->PostThumb)<10)
                    {
                        $app->PostThumb = $mask.$imgx[1];
                    }

				}else{
					$fname = basename($imgx[1]) .'n.jpg';
                    $app->Content = str_replace($imgx[0],'',$app->Content);
					continue;
				}
				$fname = urldecode($fname);
				$savepath = $today_uploadfolder .$fname;
				$imgxurl = $today_uploadhttp . $fname;
				//echo $mask.$imgx[1];

				if(is_file($savepath))
				{

				}else{
					downloadfile($mask.$imgx[1],$savepath);
				}
				$imgdiv = "<div class='myrpf-xph' style='width: 100%'> <img loading='lazy' class='myrpf-xphto' src='{$imgxurl}'/> </div>";
				$app->Content = str_replace($imgx[0],$imgdiv,$app->Content);
			}

			foreach ($app->Videos as $vidx)
			{
				$fname= basename(parse_url($vidx[1])['path']);

				if(Is_goodExt($fname,'video'))
				{

				}else{
					$fname = basename($vidx[1]) . 'n.mp4';
				}

				$fname = urldecode($fname);
				$savepath = $today_uploadfolder .$fname;
				$vidurl = $today_uploadhttp . $fname;
				if(is_file($savepath) and filesize($savepath) > 100)
				{

				}else{

					if($myurl['host'] == 'famousinternetgirls.com')
					{
						downloadfile_fig($masky.$vidx[1],$savepath);
                        $filesize = filesize($savepath);
                        if($filesize <500)
                        {
                            downloadfile_fig($masky.$vidx[1],$savepath);
                        }

					}elseif ($myurl['host'] == 'influencersgonewild.com')
					{

                        downloadfile_fi_finfl($masky.$vidx[1],$savepath);

					}elseif ($myurl['host'] == 'dirtyship.com')
					{
                        downloadfile_fi_dirtyship($masky.$vidx[1],$savepath);

					}elseif ($myurl['host'] == 'prothots.com')
					{
						downloadfile_prothot($masky.$vidx[1],$savepath);
					}elseif ($myurl['host'] =='dirtyship.com')
					{
						downloadBigFile($mask.$vidx[1],$savepath);
					}else{
						downloadVidfile($mask.$vidx[1],$savepath);
					}
                    // check size and download again
                    $filesize = filesize($savepath);
                    if($filesize <1000)
                    {
                        downloadfile_universal_infl1($mask.$vidx[1],$savepath,$app->Weburl);
                       // downloadfile_universal_infl2($mask.$vidx[1],$savepath);
                        $filesize = filesize($savepath);
                        if($filesize <200)
                        {
                            echo 'Video file Not downloading...'.$vidx[1];
                            exit();
                        }
                    }

				}

				$viddiv = ' <div class="myrpf-videos"><video class="myrpf-vdox" style="height: 100%;width: 100%" controls><source class="myrpf-vvddo" src="' . $vidurl . '" type="video/mp4"></video></div>';
				$app->Content = str_replace($vidx[0],$viddiv,$app->Content);
			}
		}

	//	exit();

		$datas = [
			'url'=>$url,
			'title' => $app->Title,
			'thumb' => $app->PostThumb,
			'images' => $app->Images,
			'videos' => $app->Videos,
			'categorys' => $app->Categorys,
			'tags' => $app->Tags,
			'content' => $app->Content
		];

		// echo $app->PostThumb;
			$apidata = "Good";

		//	$apidata = print_r($datas,1);  echo $apidata; exit();
		//	echo $apidata;
// exit();



		if(wpusm_Postwp($app->Title,$mask.$app->PostThumb,$app->Content,$url,$app->Categorys,$app->Tags))
		{
			echo "<div id='myrpfxalert' class='alert alert-success'> {$x} Added !</div><div>$timealhtml<pre>{$apidata}</pre></div>";
		}else{
			echo "<div id='myrpfxalert' class='alert alert-danger'> {$x} Post Exist !</div><div>$timealhtml<pre>{$apidata}</pre></div>";
		}


	}else{
		echo "<div id='myrpfxalert' class='alert alert-danger'> URL ERROR </div>$timealhtml";
	}
}elseif (isset($req['list']))
{
	foreach ($myprojects as $myprojecthost => $project_info)
	{
		echo "{$myprojecthost} == {$project_info[1]} <hr/>";
	}
}

function wpusm_add_dblog($post_id,$title,$sourceurl,$postdata)
{
    global $wpdb;
    $wpdb->insert('wpusm_posts', array(
        'post_id' => $post_id,
        'title' => $title,
        'ctime' => time(), // ... and so on
        'utime' => time(), // ... and so on
        'sourceurl' => $sourceurl, // ... and so on
        'postdata' => $postdata, // ... and so on
    ));
    //   $wpdb->query($query);
}

function wpusm_add_request_log($url)
{
    global $wpdb;
    $host = parse_url($url)['host'];

    $wpdb->insert('wpusm_request_log', array(
        'url' => $url,
        'urlhash' => md5($url),
        'host' => $host, // ... and so on
        'time' => time(), // ... and so on
        'utime' => 0, // ... and so on
    ));
    //   $wpdb->query($query);
}




function wpusm_Postwp($title,$thumb,$content,$url,$cats = [],$tags = [])
{
    $paramlink = basename($url);

	$wproot = realpath('../../../../..');

	$author_id = 1;
	include_once $wproot.'/wp-config.php';
	require_once($wproot . '/wp-admin/includes/media.php');
	require_once($wproot . '/wp-admin/includes/file.php');
	require_once($wproot . '/wp-admin/includes/image.php');
	require_once( $wproot . '/wp-admin/includes/taxonomy.php');

	$query = $wpdb->prepare(
		'SELECT ID FROM ' . $wpdb->posts . '
        WHERE post_title = %s',
		$title
	);
	$wpdb->query( $query );

	if ( $wpdb->num_rows ) {
	//	echo "post exits";

        $results =$wpdb->get_results( $query );
        foreach ($results as  $result)
        {
            $post_id = $result->ID;
            $post_content = $result->post_content;
          //  echo $result->post_name;

            $post = get_post( $post_id );
            $post->post_content = $content;
            wp_update_post( $post );
        }





		return false;

	}

// category and tags system
	$cat_ids = [];
	$tag_ids = [];


foreach ($cats as $cat)
{
	$cat_ID = get_cat_ID($cat[1]);
	if($cat_ID)
	{
	}else {
		$cat_data = array( 'cat_name' => $cat[1], 'category_nicename' => $cat[1] );
		wp_insert_category( $cat_data );

	}
	// try again . sometime category insert take time
	$cat_ID = get_cat_ID($cat[1]);
	if($cat_ID)
	{
	}else{
		$cat_data = array('cat_name' => $cat[1],'category_nicename'=>$cat[1]);
		wp_insert_category($cat_data);

	}

	$new_cat_ID = get_cat_ID($cat[1]);
	if($cat_ID)
	{
		$cat_ids[] = $new_cat_ID;
	}
}



// print_r($cats);
if(count($cat_ids)<1)
{
	$cat_ids = [1]; // uncategorys
}

// print_r($cat_ids);exit();

// print_r($tags);
if(1)
{
	foreach ($tags as $tag)
	{
		$tag_found = get_term_by('name',$tag[1],'post_tag');
		if($tag_found)
		{
			// $new_tag_id = $tag_found->term_id;
		}else{
			$tagdata = wp_insert_term($tag[1],'post_tag',['slug'=> $tag[0]]);
		}
		$tag_found = get_term_by('name',$tag[1],'post_tag');
		if($tag_found)
		{
			$tag_ids[] = $tag_found->term_id;
		}
	}
}
if(count($tag_ids)<1)
{
	$tag_ids = [];
}

//print_r($cats);
//print_r($cat_ids);
//exit();

    $postdate = '2010-02-23 18:57:33';
// Gather post data.
	$my_post = array(
		'post_title'    => $title,
		'post_name'    => $paramlink,
		'post_content'  => $content,
		// 'post_status'   => 'pending',
        //'post_date'     =>   $postdate,
		 'post_status'   => 'Publish',
		'post_author'   => $author_id,
	'post_category' => $cat_ids,
		'tags_input' => $tag_ids
	);
// echo '--dd--';
// exit();
// Insert the post into the database.
	$post_id = wp_insert_post($my_post);

	// example image
	$image = $thumb;
	if(strlen($image)>10)
	{
// magic sideload image returns an HTML image, not an ID
		$media = media_sideload_image($image, $post_id);

// therefore we must find it so we can set it as featured ID
		if(!empty($media) && !is_wp_error($media)){
			$args = array(
				'post_type' => 'attachment',
				'posts_per_page' => -1,
				'post_status' => 'any',
				'post_parent' => $post_id
			);

			// reference new image to set as featured
			$attachments = get_posts($args);

			if(isset($attachments) && is_array($attachments)){
				foreach($attachments as $attachment){
					// grab source of full size images (so no 300x150 nonsense in path)
					$image = wp_get_attachment_image_src($attachment->ID, 'full');
					// determine if in the $media image we created, the string of the URL exists
					if(strpos($media, $image[0]) !== false){
						// if so, we found our image. set it as thumbnail
						set_post_thumbnail($post_id, $attachment->ID);
						// only want one image
						break;
					}
				}
			}
		}

	}

	return true;
}

function Is_goodExt($filename,$need  = 'video')
{
$ext = pathinfo(strtolower($filename), PATHINFO_EXTENSION);

 $vidoext = [
	 "3g2","3gp","aaf","asf","avchd","avi","drc","flv","m2v","m4p","m4v","mkv","mng","mov","mp2","mp4","mpe","mpeg","mpg","mpv","mxf","nsv","ogg","ogv","ogm","qt","rm","rmvb","roq","srt","svi","vob","webm","wmv","yuv"
 ];
$iamgeext = [
	"3dm","3ds","max","bmp","dds","gif","jpg","jpeg","png","psd","xcf","tga","thm","tif","tiff","yuv","ai","eps","ps","svg","dwg","dxf","gpx","kml","kmz","webp"
];

if($need =='video')
{
	foreach ($vidoext as $item)
	{
		if($ext == $item)
		{
			return true;
		}
	}
}elseif ($need =='image')
{
	foreach ($iamgeext as $item)
	{
		if($ext == $item)
		{
			return true;
		}
	}
}
return  false;
}

?>