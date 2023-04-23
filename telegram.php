<?php

require_once "./lib/Mobile_Detect.php";
date_default_timezone_set('Europe/Rome');

// SETUP --------------------------
$botToken = '';
$chatId = '';

$redirect = '/';
// --------------------------------

$params = array();

// GET DATA

foreach ($_POST as $name => $value) {
  $params[$name] = $value;
}

function get_client_ip() {
  $ip = getenv('REMOTE_ADDR') ? getenv('REMOTE_ADDR') : '8.8.8.8';
  return $ip;
}

$detect = new Mobile_Detect;
$detect->isMobile() ? $params['isMobile'] = 'MobileDevice' : $params['isMobile'] = 'DesktopPC';

$params['ip'] = get_client_ip();
$params['curr_date_time'] = date('Y-m-d H:i:s', time());
$params['referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

$ch = curl_init();
$content = '';
if ($ch) {
	curl_setopt_array($ch, array(
	    CURLOPT_URL => 'http://ip-api.com/json/'.$params['ip'],
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_ENCODING => "",
	    CURLOPT_MAXREDIRS => 10,
	    CURLOPT_TIMEOUT => 30,
	    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    CURLOPT_CUSTOMREQUEST => "GET",
	));
    $content = trim(curl_exec($ch));
    curl_close($ch);
}

$arr = json_decode($content, true);

$params['city'] = $arr['city'];
$params['country'] = $arr['country'];
$params['countryCode'] = $arr['countryCode'];
$params['regionName'] = $arr['regionName'];

// SEND TELEGRAM MESSAGE

$message = "<b>New lead</b>\n\n";
foreach ($params as $name => $value) {
  $message .= "<b>$name:</b> $value\n";
}

$message = urlencode($message);

$url = "https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$chatId}&parse_mode=HTML&text={$message}";

$response = file_get_contents($url);

$status = http_response_code();

if ($status == 200) {
    header('Location: ' . $redirect);
} else {
    echo "Error. Try again!";
}

?>