<?php
/*
authored by Josh Fraser (www.joshfraser.com)
released under Apache License 2.0

Maintained by Alexander Makarov, http://rmcreative.ru/

$Id$
*/

// a little example that fetches a bunch of sites in parallel and echos the page title and response info for each request

function request_callback($response, $info) {
	// parse the page title out of the returned HTML
	if (preg_match("~<title>(.*?)</title>~i", $response, $out)) {
		$title = $out[1];
	}
	echo (isset($title)) ? "<b>$title</b><br />" : "NO TITLE<br />";
	print_r($info); echo "<br />";
    echo $info['http_code']."<br />";
	echo "<hr>";
}

require("RollingCurl.php");

// single curl request
echo "Single Request<br />";
$rc = new RollingCurl("request_callback");
$rc->request("http://www.msn.com/myspecialpageformeonly");
$rc->execute();
exit;

// another single curl request
echo "Another Single Request<br />";
$rc = new RollingCurl("request_callback");
$rc->request("http://www.google.com");
$rc->execute();

echo "<hr>";


$urls = array("https://www.google.com",
              "http://www.facebook.com",
              "http://www.yahoo.com",
              "http://www.youtube.com",
              "http://www.live.com",
              "http://www.wikipedia.com",
              "http://www.blogger.com",
              "http://www.msn.com",
              "http://www.baidu.com",
              "http://www.yahoo.co.jp",
              "http://www.myspace.com",
              "http://www.qq.com",
              "http://www.google.co.in",
              "http://www.twitter.com",
              "http://www.google.de",
              "http://www.microsoft.com",
              "http://www.google.cn",
              "http://www.sina.com.cn",
              "http://www.wordpress.com",
              "http://www.google.co.uk");

$rc = new RollingCurl("request_callback");
$rc->window_size = 20;
foreach ($urls as $url) {
    $request = new RollingCurlRequest($url);
    $rc->add($request);
}
$rc->execute();
