<?

$users = [
  'all' => '',
  'hifi' => 'Hifi',
  'colin' => 'Colin',
];

$navbar = [
  [
    'href' => '/?user=all',
    'name' => '[X]',
  ],
  [
    'href' => '/?user=hifi',
    'name' => 'Hifi',
  ],
  [
    'href' => '/?user=colin',
    'name' => 'Colin',
  ],
];


echo '<link rel="stylesheet" type="text/css" href="./module/sk_navbar/navbar.css">';

$account = (isset($_COOKIE['user'])) ? $users[$_COOKIE['user']] : '';

?>


<div class="sk_navbar">
  <div class="sk_navbar--section--padding">
    <? echo (!empty($account)) ? "User: $account" : '' ?>
  </div>
  <div class="sk_navbar--section">
    <a class="sk_navbar--icon" href="javascript:void(0);" onclick="toggleFlexMenu('navbarMenu')">
      Accounts
    </a>
  </div>
</div>

<div class="sk_navbarMenu" id="navbarMenu">
  <?
    foreach ($navbar as $v) {
      $href = $v['href'];
      $name = $v['name'];
      echo "<a href='$href'>$name</a>";
    }
  ?>
</div>

