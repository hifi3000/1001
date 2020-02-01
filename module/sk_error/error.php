<?

error_reporting(E_ALL);
ini_set("display_errors", 1);


function preprint($name) {
  echo "<pre>";
  print_r ($name);
  echo "</pre>";
}