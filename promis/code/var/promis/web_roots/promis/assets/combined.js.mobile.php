<?php
$last = mktime(0,0,0,1,1,date('Y'));
$cond = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : 0;

if ($cond && $_SERVER['REQUEST_METHOD'] == 'GET' && strtotime($cond) >= $last) {
 header('HTTP/1.0 304 Not Modified');
 exit;
}

// TODO: consider caching the results of combo + minify

include_once('vendor/jsmin-v1.1.1.php');

$output='';

$minify = (array_key_exists('r', $_REQUEST) && 'dev' != substr($_REQUEST['r'],0,3)); // ability to view source unpacked
if ($minify && class_exists('JSMin'))
{
  $output = JSMin::minify($output);
}

// add in already minified libraries
// PHPJS needs to be first
$output .= file_get_contents('mobile/js/jquery-1.8.2-min.js')."\n";
$output .= file_get_contents('mobile/js/ios-orientationchange-fix.min.js');
$output .= file_get_contents('mobile/js/jquery.mobile-1.3.0.min.js');
$output .= file_get_contents('mobile/cordova-2.5.0.js');
$output .= file_get_contents('vendor/backbone.js');
$output .= file_get_contents('vendor/underscore.js');
$output .= file_get_contents('vendor/json2.js');

// we'll never have a release go longer than 90 days. never. ever ever. haha.
$expires = 60 * 60 * 24 * 90;



// send the right headers
session_cache_limiter('public');
//public
header("Content-Type: application/javascript");
header('Pragma: public');
header('Cache-Control: max-age=' . $expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last) . " GMT");
//header("Content-Length: " . strlen($output));

echo $output;
exit;
