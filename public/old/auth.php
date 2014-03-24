<?php 

require_once 'Services/Soundcloud.php';

// create client object with app credentials
$client = new Services_Soundcloud(
  'c0e6f729eaa15ec21b6e3626da8a2ed0', '751cbbc5c2510d97562e1f83bc70bdc4', 'http://www.neonjohn.net/auth.php');
	
// redirect user to authorize URL
if(isset($_GET['code'])) {
	$code = $_GET['code'];
	$access_token = $client->accessToken($code);
	var_dump($access_token);	
} else {
	header("Location: " . $client->getAuthorizeUrl(array('scope'=>'non-expiring')));
}
