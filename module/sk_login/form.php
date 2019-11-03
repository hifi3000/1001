<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="/css/mystyle.css">
</head>
<body>
<? echo ($message) ?? ''; ?>
<form action="/?logins=1" method="post">
E-Mail:<br>
<input type="email" size="40" maxlength="250" name="email"><br>
Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="passwort"><br>
<input type="submit" value="Abschicken">
</form>
<? die; ?>
</body>
</html>
