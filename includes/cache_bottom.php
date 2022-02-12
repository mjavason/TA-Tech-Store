<?php
// Cache the contents to a cache file
$cached = fopen($cachefile, 'w');
fwrite($cached, ob_get_contents());
//echo "<!-- new cache copy created " . date('H:i', filemtime($cachefile)) . " -->\n";
fclose($cached);
ob_end_flush(); // Send the output to the browser
