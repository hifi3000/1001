<?

if (isset($_GET[$main_cookie])) {
  setcookie($main_cookie, $_GET[$main_cookie], time() + (86400 * 30), "/"); // 86400 = 1 day
  $_COOKIE[$main_cookie] = $_GET[$main_cookie];
}

if (isset($_GET['user'])) {
  setcookie('user', $_GET['user'], time() + (86400 * 30), "/"); // 86400 = 1 day
  $_COOKIE['user'] = $_GET['user'];
}

$user = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'all';