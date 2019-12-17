<?

if (isset($_POST['passwort']) && !empty($_POST['passwort'])) {
  $email = $_POST['email'];
  $passwort = $_POST['passwort'];

  $sql = "SELECT * FROM users WHERE email = '$email';";

  $result = queryFetch($sql);
  $user = (!empty($result)) ? $result[0] : false;

  if (!$user || !password_verify($passwort, $user['passwort'])) {
    $message = "E-Mail oder Passwort war ungültig.<p />";
    include './module/sk_login/form.php';
  }

  $_SESSION['userid'] = $sha1;
  setcookie('login', $sha1, time() + (86400 * 30), "/");
  $_COOKIE['login'] = $sha1;

  if (file_exists('./php/_default_cookie.php')) {
    include './php/_default_cookie.php';
  }

  header("Location: /");
}

if (!isset($_COOKIE['login']) || ($_COOKIE['login'] !== $sha1)) {
  if (!isset($_SESSION['userid']) || ($_SESSION['userid'] !== $sha1)) {
    $message = "Bitte zuerst einloggen.<p />";
    include './module/sk_login/form.php';
  }
}