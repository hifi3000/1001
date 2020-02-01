<?php

// # ------ Basics

  function consoleLog($object=null) {
    $message = json_encode($object, JSON_PRETTY_PRINT);
    echo "<script>console.log('PHP: ', $message);</script>";
  }


// ----- SQL Helper

  function getSelectIdStatement($db_table, $db_column, $value) {
    $sql = "
      SELECT $db_table.id
      FROM $db_table
      WHERE $db_table.$db_column = '$value'
      LIMIT 1
    ";
    return $sql;
  }


// ----- Helper

  function writeValuesToFile($array, $file, $appendUser) {
    global $user;

    foreach ($array as $v) {
      $write = $v."\n";
      file_put_contents($file, $write, FILE_APPEND);
    }

    if ($appendUser) {
      file_put_contents($file, $user."\n", FILE_APPEND);
    }
  }

  function row_trim($array) {
    foreach ($array as $k => $v) {
      $array[$k] = rtrim($v, "\r\n");
    }
    return $array;
  }

