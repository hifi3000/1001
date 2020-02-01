<?

$home = $title;

if (isset($_COOKIE[$main_cookie]) && ($_COOKIE[$main_cookie] !== 'default')) {
  $home = $_COOKIE[$main_cookie] . " " . $title;
}


$header = [
  [
    'href' => '/?' . $main_cookie . '=default',
    'name' => '[X]',
  ],
  [
    'href' => '/?' . $main_cookie . '=2020',
    'name' => '2020',
  ],
  [
    'href' => '/?' . $main_cookie . '=2019',
    'name' => '2019',
  ],
  [
    'href' => '/?' . $main_cookie . '=2018',
    'name' => '2018',
  ],
];


echo '<link rel="stylesheet" type="text/css" href="./module/sk_header/header.css">';

?>

<div class="sk_header">
  <a href="/" class="sk_header--home"><?php echo $home; ?></a>
  <div id="headerMenu">
    <?
      foreach ($header as $v) {
        $href = $v['href'];
        $name = $v['name'];
        echo "<a href='$href'>$name</a>";
      }
    ?>
  </div>
  <a href="javascript:void(0);" class="sk_header--icon" onclick="toggleMenu('headerMenu')">
    <i class="fa fa-bars"></i>
  </a>
</div>