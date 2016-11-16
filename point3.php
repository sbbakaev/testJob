<?php
// needed path
$path = dirname(__FILE__)."/datafiles/";
// pattern mask
$pattern = "/\w.txt/";

$list = array();

// list of the folder contains
$handleList = scandir($path);

foreach ($handleList as $entry) {
    //match all entries
    if(preg_match($pattern, $entry) && is_file($path.$entry)){
        $list[] =  $entry;
    }
}
// sort matched files
asort($list);

// print files list
print_r($list);