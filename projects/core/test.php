<?php


$cont = "{&quot;sources&quot;:[{&quot;src&quot;:&quot;https:\/\/v.thepornleak.com\/Caroline%20Ellison%20and%20Sam%20Bankman-theslutbay.com.mp4&quot;,&quot;type&quot;:&quot;video\/mp4&quot;}]}";

$nc = html_entity_decode($cont);
$ncx = json_decode($nc,1);
print_r($ncx);
echo $ncx['sources'][0]['src'];