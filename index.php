<?php

require_once './module/sk_error/error.php';

session_start();

$title = '1001 Movies';
$main_cookie = '1001';

require_once './php/__pw.php';

require_once './module/sk_database/database.php';

require_once './module/sk_login/login.php';

require_once './php/_cookie.php';

require_once './php/library.php';

require_once './module/sk_spotify/spotify.php';

require_once './module/sk_xpath/xpath.php';

require_once './module/sk_dbedit/dbedit.php';


if (isset($_POST['updateEntry'])) {
  preprint($_POST);
  die;
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><? echo $title; ?></title>
  <link rel="icon" href="/media/favicon.png">
  <link rel="stylesheet" type="text/css" href="css/mystyle.css">
  <script src="/js/toggleMenu.js"></script>
</head>

<body>

<?php

require_once './module/sk_table/table.php';

require_once './module/sk_warning/warning.php';

require_once './module/sk_header/header.php';

require_once './module/sk_navbar/navbar.php';

?>

<div class="main">


<?php

if (isset($_GET['dbedit'])) {
  $result = queryIdTable($_GET['dbid'], $_GET['dbedit']);
  displayForm($result, 'updateEntry', $_GET['dbedit']);
  die;
}

include_once './php/default.php';

?>


</div>
</body>
</html>