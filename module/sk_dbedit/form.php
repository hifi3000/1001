<?php

$table = $_GET['dbedit'];
$id = $_GET['dbid'];

$sql = "SELECT * FROM `" . $table . "` WHERE id='" . $id . "';";

$result = queryFetch($sql);

// preprint($result);

foreach ($result as $k => $v) {
  unset($result[$k]['created_at']);
  unset($result[$k]['updated_at']);
}

echo displayForm($result[0], 'title');

die;


function displayForm($array, $field) {
  $inputName = 'set' . $field;
  echo "<form method='post' action='/?'>";
  foreach ($array as $k => $v) {
    echo "<p>" . $k . ": <textarea name=\"" . $k . "\" cols=\"50\" rows=\"1\">" . $v . "</textarea></p>";
  }
  echo "<input type='submit' name='$inputName' value='update'></form>";
  echo "<p><a href=/> BACK </a></p>";
}