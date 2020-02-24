<?

$mysqli = new mysqli(
  $servername,
  $username,
  $password,
  $dbname
);

if ($mysqli->connect_error)
  die("Connection failed: " . $mysqli->connect_error);

mysqli_set_charset($mysqli,'utf8');


function queryFetch($sql) {
  global $mysqli;
  $query = $mysqli->query($sql);
  return fetchResult($query);
}


function fetchResult($query) {
  $result = [];
  if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc())
      $result[] = $row;
  }
  return $result;
}


function setQuery($sql) {
  global $mysqli;
  if ($mysqli->query($sql) === TRUE) {}
  else queryError($sql);
}


function queryError($sql) {
  global $mysqli;
  try {
    throw new Exception("MySQL error: <br /> $mysqli->error <br /><br /> Query:<br /> $sql", $mysqli->errno);
  }
  catch (Exception $e) {
    echo "Error No: "
      . $e->getCode() . "<br /><br />"
      . $e->getMessage() . "<br /><br />"
      . nl2br($e->getTraceAsString()); }
  die;
}


function escapeStrings($value) {
  global $mysqli;

  if (is_array($value)) {
    foreach ($value as $k => $v) {
      $value[$k] = escapeStrings($v);
    }
    return $value;
  }
  else {
    return mysqli_real_escape_string($mysqli, trim($value));
  }
}


function getInsertStmt($table, $insert) {
  foreach ($insert as $k => $v) {
    $columns[] = $k;
    $values[] = "'" . $v  . "'" . " as " . $k;
    $wheres[] = "`" . $table . "`." . $k . " = " . "'" . $v . "'";
  }

  $sql = "
  INSERT INTO `" . $table . "` (" . implode(', ', $columns) . ")
  SELECT *
  FROM (SELECT " . implode(', ', $values) . ") AS tmp
  WHERE NOT EXISTS (SELECT * FROM `" . $table . "` WHERE " . implode(' AND ', $wheres) . ")
  LIMIT 1;";

  return $sql;
}