<?

echo "<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'></script>";

echo "<script src='./module/sk_table/table.js'></script>";


function toggleTable($buttonvalue) {
  return '<p><input type="button" class="button" value="' . $buttonvalue . '" onclick="toggleMe(document.getElementById(\'tableToggle\'));"></p>';
}

function build_table($array, $buttonvalue = 'toggle table'){
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