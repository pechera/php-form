<?php
// --------------------------------
$to = "{{email}}";
// --------------------------------

$postData = $_POST;
$domain = $_SERVER['SERVER_NAME'];

$message = "";
foreach ($postData as $name => $value) {
  $message .= "$name: $value\n";
}

$headers = "From: order@pagesaver.click\r\n";
$headers .= "Reply-To: order@pagesaver.click\r\n";
$headers .= "X-Mailer: PHP/".phpversion();

mail($to, "New lead from " . $domain, $message, $headers);

header('Location: thankyou.php');

exit; 

?>