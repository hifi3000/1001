<?php

function buildSet($post) {
  $post = escapeStrings($post);

  foreach ($post as $k => $v) {
    $set[] = "`" . $k . "` = '" . $v . "'";
  }
  return implode(", ", $set);
}

function updateTable($table, $fields) {
  $id = $fields['id'];
  unset($fields['id']);

  $set = buildSet($fields);
  $sql = "UPDATE `$table` SET $set WHERE id = '$id';";

  setQuery($sql);
}


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

function displayForm($array, $inputName, $table) {
  echo "<form method='post' action='/?'>";
    echo "<table>";

    foreach ($array as $k => $v) {
      echo "<tr>";
        echo "<th>";
          echo $k;
        echo "</th>";
        echo "<td data-th='" . $k . "'>";
          echo "<textarea name=\"$k\">";
            echo $v;
          echo "</textarea>";
        echo "</td>";
      echo "</tr>";
    }

    echo "</table>";

    echo "<input type='hidden' name='table' value='$table'>";
    echo "<input type='submit' name='$inputName' value='update'>";
  echo "</form>";

  echo "<p><a href=/> BACK </a></p>";
}