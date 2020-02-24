<?php

function queryIdTable($id, $table) {
  global $mysqli;

  $sql = "
    SELECT *
    FROM `$table`
    WHERE id = '$id' LIMIT 1;
  ";

  $result = $mysqli->query($sql)->fetch_assoc();

  unset($result['created_at']);
  unset($result['updated_at']);

  return $result;
}

function displayForm($array, $inputName) {
  echo "<form method='post' action='/?'>";
    echo "<table>";

    foreach ($array as $k => $v) {
      echo "<tr>";
        echo "<td>";
          echo $k;
        echo "</td>";
        echo "<td>";
          echo "<textarea name=\"$k\" cols=\"50\" rows=\"1\">";
            echo $v;
          echo "</textarea>";
        echo "</td>";
      echo "</tr>";
    }

    echo "</table>";

    echo "<input type='submit' name='$inputName' value='update'>";
  echo "</form>";

  echo "<p><a href=/> BACK </a></p>";
}