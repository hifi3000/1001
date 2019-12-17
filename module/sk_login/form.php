<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="icon" href="/media/favicon.png">
    <link rel="stylesheet" type="text/css" href="/css/mystyle.css">
    <link rel="stylesheet" type="text/css" href="/module/sk_login/sk_login.css">
  </head>
  <body id="login" OnLoad="document.loginform.email.focus();">
    <img class="login_favicon" src='/media/favicon.png'></img>
    <h4><?php echo ($message) ?? ''; ?></h4>
    <form action="/" method="post" name="loginform">E-Mail:<br>
      <input type="email" size="40" maxlength="250" name="email">
      <br>Dein Passwort:<br>
      <input type="password" size="40"  maxlength="250" name="passwort"><br>
      <input type="submit" value="Abschicken">
    </form>
  </body>
</html>
<?php die; ?>
