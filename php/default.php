<?


$sql = "SELECT * FROM m_movie;";

$result = queryFetch($sql);

// preprint($result);

echo build_table1($result);

echo "<p />";
echo "

";