### PHP scripts allow you to send form data to email / telegram / webhook or locally

email.php - Send form data to email. Enter your email in setup section.
telegram.php - Send form data to telegram Bot. Enter Bot API Token and your user id in setup section.
webhook.php - Send form data in url query params to webhook with GET method.

#### How to setup

1. Rename one of files to order.php
2. Change your html with form page:

```
<form action="order.php" method="POST">
    ...
</form>
```

3. Run website on server with installed PHP
