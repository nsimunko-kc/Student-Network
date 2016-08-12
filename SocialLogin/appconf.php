<?php session_start();
/*==========================================*\
|| ##########################################||
|| # SONHLAB.com - SONHlab Social Auth v2 #
|| ##########################################||
\*==========================================*/


if ( $_SESSION['app'] == 'facebook' ) { // Facebook App

	// App ID
	$_SESSION['fb_appid'] = '1598140647171778';
	// App Secret
	$_SESSION['fb_appsecret'] = '5b335187cb2392721d0c5b3a214a71a8';
	
}
elseif ( $_SESSION['app'] == 'twitter' ) { // Twitter App

	// Consumer Key
	$_SESSION['tt_key'] = 'OFAxtFpjzk3P7yoRsPLTqOtsf';
	// Consumer Secret
	$_SESSION['tt_secret'] = 'AHzYSHm0pIdc8GKylpbtcALIjIpZQxzc80bRFVjAhCXRmjwUXW';

}
elseif ( $_SESSION['app'] == 'google' ) { // Google App
	
	// Client ID
	$_SESSION['gg_appid'] = '977480025720-ubfabirbuhu9mb4hqc8l55g0r8lf9qhj.apps.googleusercontent.com';
	// Client Secret
	$_SESSION['gg_appsecret'] = 'NNNQesvLGVqw1s8TzzMn8JbQ';
	
}