<?php

// # ------ Basics

  function consoleLog($object=null) {
    $message = json_encode($object, JSON_PRETTY_PRINT);
    echo "<script>console.log('PHP: ', $message);</script>";
  }

// # ------ HTML Table

  function toggleTable($buttonvalue) {
    return '<p><input type="button" class="button" value="' . $buttonvalue . '" onclick="toggleMe(document.getElementById(\'tableToggle\'));"></p>';
  }

  function build_table1($array, $buttonvalue = "toggle table"){
    $html = toggleTable($buttonvalue);
    $html .= '
      <div id="tableToggle">
      <p>
        <input type="button" class="button" value="select table" onclick="selectElementContents(document.getElementById(\'myTable\'));">
      </p>
    ';
    $html .= '<table id="myTable">';
    $html .= '<thead><tr>';
    $i = "0";
    foreach ($array[0] as $key => $value) {
      $html .= '<th onclick="sortTable('.$i.')">'.htmlspecialchars($key).'</th>';
      $i++;
    }
    $html .= '</tr></thead>';

    foreach ($array as $key => $value) {
      $html .= '<tr>';
      foreach($value as $key2=>$value2){
        $html .= '<td>'.$value2.'</td>';
      }
      $html .= '</tr>';
    }

    $html .= '</table></div>';
    return $html;
  }

  function build_table_swap($array){
    $html = '<p><input type="button" class="button" value="select table" onclick="selectElementContents(document.getElementById(\'myTable\'));"> <input type="button" class="button" value="toggle table" onclick="toggleMe(document.getElementById(\'myTable\'));"></p>';
    $html .= '<table id="myTable">';
    $html .= '<thead><tr>';
    $i = "0";
    foreach($array as $key=>$value){
      $html .= '<th onclick="sortTable('.$i.')">'.htmlspecialchars($key).'</th>';
      $count[$i] = count($value);
      $i++;
    }
    $html .= '</tr></thead>';

    for($i="0";$i<$count[0];$i++){
      $html .= '<tr>';
      foreach($array as $key=>$value){
        $html .= '<td>'.$value[$i].'</td>';
      }
      $html .= '</tr>';
    }

    $html .= '</table>';
    return $html;
  }

  function build_table_no_header($array){
    $html = '<p><input type="button" class="button" value="select table" onclick="selectElementContents(document.getElementById(\'myTable\'));"></p>';
    $html .= '<table id="myTable">';

    foreach($array as $key=>$value){
      $html .= '<tr>';
      foreach($value as $key2=>$value2){
        $html .= '<td>'.$value2.'</td>';
      }
      $html .= '</tr>';
    }

    $html .= '</table>';
    return $html;
  }

  function build_table_swap_no_header($array){
    $html = '<p><input type="button" class="button" value="select table" onclick="selectElementContents(document.getElementById(\'myTable\'));"></p>';
    $html .= '<table id="myTable">';

    $i = "0";
    foreach($array as $key=>$value){
      $count[$i] = count($value);
      $i++;
    }

    for($i="0";$i<$count[0];$i++){
      $html .= '<tr>';
      foreach($array as $key=>$value){
        $html .= '<td>'.$value[$i].'</td>';
      }
      $html .= '</tr>';
    }

    $html .= '</table>';
    return $html;
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

