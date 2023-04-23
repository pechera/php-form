<?php

require_once "./lib/Mobile_Detect.php";
date_default_timezone_set('Europe/Rome');

// SETUP --------------------------
$url = "";
$method = "GET"; // GET or POST

$redirect = '/';
// --------------------------------

$params = array();

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

if (!$ch) {
    echo "Error in curl initialization.";
    exit();
}

curl_setopt_array($ch, array(
    CURLOPT_URL => 'http://ip-api.com/json/'.$params['ip'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
));

$response = trim(curl_exec($ch));

$arr = json_decode($response, true);
  
$params['city'] = $arr['city'];
$params['country'] = $arr['country'];
$params['countryCode'] = $arr['countryCode'];
$params['regionName'] = $arr['regionName'];

// SEND WEBHOOK

$queryString = http_build_query($params);

$webhookUrl = "";
strpos($url, '?') ? $webhookUrl = $url . '&' . $queryString : $webhookUrl = $url . '?' . $queryString;

curl_setopt($ch, CURLOPT_URL, $webhookUrl);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

$response = trim(curl_exec($ch));

$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($status === 200) {
    header('Location: ' . $redirect);
    exit();
} 

echo "Error. Filed to send data.";

curl_close($ch);

?>