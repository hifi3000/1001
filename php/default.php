<?


$sql = "SELECT * FROM m_movie LIMIT 10;";

$result = queryFetch($sql);

// preprint($result);

foreach ($result as $k => $v) {
  $result[$k]['edit'] = "<a href='/?dbedit=m_movie&dbid=" . $v['id'] . "'>edit</a>";
}

echo build_table($result);

echo "<p />";
echo "

";