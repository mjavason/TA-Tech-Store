<?php
//The first five lines create the cached file name according to the current PHP file. So, if you’re using a file named list.php, the web page created by the page caching will be named cached-list.html.
$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];

//if the page has a unique id, make the filename unique as well
if(isset($_GET['id'])){
$cachefile = 'cached-' . substr_replace($file, "", -4) .'-'.$_GET['id'].'.html';
}else{
    $cachefile = 'cached-' . substr_replace($file, "", -4) .'.html';
}

$cachetime = 24 * 60 * 60; //85400 seconds(1 day)

//Line six creates a $cachetime variable in seconds, which determines the life of our simple cache (Cachefile time).
// Serve from the cache if it is younger than $cachetime
//if 'recache' is set to true, refresh the cache manually
if (isset($_GET['recache'])) {
    unlink($cachefile);
}

    if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
        echo "<!-- Cached copy, generated " . date('H:i', filemtime($cachefile)) . " -->\n";
        readfile($cachefile);
        exit;
    }
ob_start(); // Start the output buffer