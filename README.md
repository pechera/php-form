## PHP scripts allow you to send form data to email / telegram / webhook or save it locally

### Description

**email.php** - Send form data to email. Enter your email in setup section.

**telegram.php** - Send form data to telegram Bot. Enter Bot API Token and your user id in setup section (check your user id in @userinfobot bot).

**webhook.php** - Send form data in url query params to webhook.

**local.php** - Save form data locally in txt file.

### How to setup

1. Rename one of files to order.php
2. Change your html with form page:

```
<form action="order.php" method="POST">
    ...
</form>
```

3. Run website on server with installed PHP
