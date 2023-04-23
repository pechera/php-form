<?php

// --------------------------------
$url = "{{url}}";
// --------------------------------

$data = $_POST;
$queryString = http_build_query($data);

$webhookUrl = "";
if (strpos($string, '?') !== false) {
    $webhookUrl = $url . $queryString;
} else {
    $webhookUrl = $url . '?' . $queryString;
}

$response = file_get_contents($webhookUrl);

$status = http_response_code();

if ($status == 200) {
    header('Location: thankyou.php');
} else {
    echo "Error. Try again!";
}

exit; 

?>