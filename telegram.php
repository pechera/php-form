<?php

// --------------------------------
$botToken = '{{token}}';
$chatId = '{{chatId}}';
// --------------------------------

$postData = $_POST;
$domain = $_SERVER['SERVER_NAME'];

$message = "<b>New lead from</b> " . $domain . "\n\n";
foreach ($postData as $name => $value) {
  $message .= "<b>$name:</b> $value\n";
}

$message = urlencode($message);

$url = "https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$chatId}&parse_mode=HTML&text={$message}";

$response = file_get_contents($url);

$status = http_response_code();

if ($status == 200) {
    header('Location: thankyou.php');
} else {
    echo "Error. Try again!";
}

exit; 

?>