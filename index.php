<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

require_once 'php/db.php';

require_once './module/sk_login/login.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>1001 Movies</title>
  <link rel="icon" href="/media/favicon.png" />
  <link rel="stylesheet" type="text/css" href="css/mystyle.css" />
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>


<body>

<?php

  setlocale(LC_TIME, "de_DE.utf8");

  include 'php/build_table.php';

  $find = ['\\', "\0", "\n", "\r", "'", '"', "\x1a"];
  $replace = ['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'];
  $today = date("Y-m-d");

?>

<div class="navbar">
  <h2>
    <a href="/">1001 Movies</a>
  </h2>
  <h3>
    <?php echo strftime("%A"); ?> - #<?php echo $today; ?>
  </h3>
</div>


<div class="main">

<?php

function getInsertStatement($db_table, $db_column, $value) {
  $sql = "
    INSERT INTO $db_table ($db_column)
    SELECT *
    FROM (SELECT '$value') AS tmp
    WHERE NOT EXISTS (
      SELECT $db_table.$db_column
      FROM $db_table
      WHERE $db_table.$db_column = '$value'
    )
    LIMIT 1;
  ";
  return $sql;
}

function getSelectIdStatement($db_table, $db_column, $value) {
  $sql = "
    SELECT $db_table.id
    FROM $db_table
    WHERE $db_table.$db_column = '$value'
    LIMIT 1
  ";
  return $sql;
}

  if(isset($_POST['submit'])){

    $date = $_POST['date'];

    $task = $_POST['task'];
    $task = str_replace($find,$replace,$task);

    $subject = $_POST['subject'];
    $subject = str_replace($find,$replace,$subject);

    if (strpos($subject,';')!== false) {
      $subject=(explode("; ",$subject));
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);
    mysqli_set_charset($conn,'utf8');

    // INSERT SUBJECT IN DATABASE
    $db_table = "ej_subject";
    $db_column = "subject";
    if (is_array ($subject)) {
      foreach ($subject as $v) {
        $sql = getInsertStatement($db_table, $db_column, $v);
        if ($conn->query($sql) === TRUE) echo "";
        else die("Error: ".$conn->error);
      }
    }
    else {
      $sql = getInsertStatement($db_table, $db_column, $subject);
      if ($conn->query($sql) === TRUE) echo "";
      else die("Error: ".$conn->error);
    }

    // INSERT TASK IN DATABASE
    $sql = getInsertStatement("ej_task", "task", $task);
    if ($conn->query($sql) === TRUE) echo "";
    else die("Error: ".$conn->error);

    // INSERT TASK & SUBJECT CONNECTION INTO DATABASE
    $task_id = getSelectIdStatement("ej_task", "task", $task);
    if (is_array ($subject)) {
      for ($i=0;$i<count($subject);$i++) {
        $subject_id = getSelectIdStatement("ej_subject", "subject", $subject[$i]);
        $sql = "
          INSERT INTO ej_task_subject (date, task_id, subject_id)
          SELECT *
          FROM (SELECT '$date', ($task_id), ($subject_id)) as tmp
          WHERE NOT EXISTS (
            SELECT ej_task_subject.date, ej_task_subject.task_id, ej_task_subject.subject_id
            FROM ej_task_subject
            INNER JOIN ej_task
              ON ej_task.id = ej_task_subject.task_id
            INNER JOIN ej_subject
              ON ej_subject.id = ej_task_subject.subject_id
            WHERE ej_task_subject.date = '$date'
              AND ej_task_subject.task_id = ($task_id)
              AND ej_task_subject.subject_id = ($subject_id)
          )
          LIMIT 1;
        ";
        if ($conn->query($sql) === TRUE) echo "";
        else die("Error: ".$conn->error);
      }
    }
    else {
      $subject_id = getSelectIdStatement("ej_subject", "subject", $subject);
      $sql="INSERT INTO ej_task_subject (date, task_id, subject_id)
      SELECT * FROM (SELECT '$date',($task_id),($subject_id)) AS tmp
      WHERE NOT EXISTS (
        SELECT ej_task_subject.date, ej_task.id as tt, ej_subject.id as ss FROM ej_task_subject
        INNER JOIN ej_task ON ej_task.id = ej_task_subject.task_id
        INNER JOIN ej_subject ON ej_subject.id = ej_task_subject.subject_id
        WHERE ej_task_subject.date = '$date'
        AND ej_task_subject.task_id = ($task_id)
        AND ej_task_subject.subject_id = ($subject_id)
      ) LIMIT 1;";
      if ($conn->query($sql) === TRUE) echo "";
      else die("Error: ".$conn->error);
    }

    $conn->close();
  }
?>

<div class="side">
SUBJECT
<br>
<?php

  $sql = "SELECT * FROM ej_subject ORDER BY ej_subject.subject ASC;";
  $conn = new mysqli($servername, $username, $password, $dbname);
  mysqli_set_charset($conn,'utf8');
  if ($conn->connect_error) die ("Connection failed: ".$conn->connect_error);
  $result2 = $conn->query($sql);
  if ($conn->error) {
    try { throw new Exception("MySQL error $mysqli->error <br> Query:<br> $query", $conn->errno); }
    catch(Exception $e) { echo "Error No: ".$e->getCode()." - ".$e->getMessage()."<br>".nl2br($e->getTraceAsString()); }
  }
  $conn->close();

  $result=[];
  if($result2->num_rows > 0) { while($row = $result2->fetch_assoc()) array_push($result,$row); }

  for($i=0;$i<count($result);$i++){
    echo "<a href='?go02=go&subject=".$result[$i]['subject']."'>".$result[$i]['subject']."</a><br>";
  }

?>
</div>


<div class="main_row">
<?php
  if(isset($_GET['go02'])){
    $subject=$_GET['subject'];
    echo "<h2>Subject: ".$subject."</h2>";
    $sql = "SELECT * FROM ej_task_subject
    INNER JOIN ej_task ON ej_task_subject.task_id = ej_task.id
    INNER JOIN ej_subject ON ej_task_subject.subject_id = ej_subject.id
    WHERE ej_subject.subject = '$subject'
    ORDER BY ej_task_subject.date DESC;";

    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn,'utf8');
    if ($conn->connect_error) die ("Connection failed: ".$conn->connect_error);

    $result2 = $conn->query($sql);
    if ($conn->error) {
      try { throw new Exception("MySQL error $mysqli->error <br> Query:<br> $query", $conn->errno); }
      catch(Exception $e) { echo "Error No: ".$e->getCode()." - ".$e->getMessage()."<br>".nl2br($e->getTraceAsString()); }
    }

    $conn->close();

    $result=[];
    if($result2->num_rows > 0) { while($row = $result2->fetch_assoc()) array_push($result,$row); }

    // EXPORT THE DATE AND COUNT
    for($i=0;$i<count($result);$i++){
      $array_date[]=$result[$i]['date'];
    }
    $array_count=array_count_values($array_date);
    $array_date=array_keys($array_count);
    for($i=0;$i<count($array_date);$i++){
      $array_date[$i]=strtotime($array_date[$i]);
    }
    $array_count=array_values($array_count);

    $k=count($result);
    $k--;

    $startdate = $result[$k]['date'];
    $datetime1 = date_create($startdate);
    $tomorrow = date('Y-m-d', strtotime("+1 day"));
    $datetime2 = date_create($tomorrow);
    $interval = date_diff($datetime1, $datetime2);
    $days=$interval->format("%a");

    echo "<h4>".$days.". Tag (".$interval->format('%m Monat(e), %d Tag(e)').")</h4>";

    for($i=0;$i<count($result);$i++){
      $table[$i]['date']=$result[$i]['date'];
      $table[$i]['task']=$result[$i]['task'];
    }

?>
<script type="text/javascript">
  google.charts.load("current", {packages:["calendar"]});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'date', id: 'Date' });
    dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
    dataTable.addRows([
      <?php
      for($i=0;$i<count($array_date);$i++){
        $month=date("n", $array_date[$i]);
        $month=$month-1;
        echo "[ new Date(".date("Y", $array_date[$i]).", ".$month.", ".date("d", $array_date[$i])."), ".$array_count[$i]." ], ";
      }
      ?>
      [ new Date(<?php $month=date("n", strtotime('tomorrow'));
      $month=$month-1;
      echo date("Y, ", strtotime('tomorrow')).$month.date(", d", strtotime('tomorrow')); ?>), 0 ]
    ]);

    var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

    var options = {
     title: "<?php echo $subject; ?>",
    };

    chart.draw(dataTable, options);
    }
    </script>
  <div id="calendar_basic" style="width: 1000px;"></div>
<?php

    echo build_table ($table);
    die;
  }
?>
<p>ENTRY</p>
  <form method="post" action="index.php?">
    Date: <input type="text" name="date" id="datepicker" autocomplete="off">
    <p />
    Task: <textarea name="task" rows="5" cols="40"></textarea><br><br>
    Subject: <input type="text" name="subject" ><br><br>
    <input type="submit" name="submit" value="go">
    </form>
  <hr>
<p>JOURNAL</p>
<?php
  $sql = "SELECT ej_task_subject.date, ej_task.task, ej_subject.subject FROM ej_task_subject
  INNER JOIN ej_task ON ej_task_subject.task_id = ej_task.id
  INNER JOIN ej_subject ON ej_task_subject.subject_id = ej_subject.id
  ORDER BY ej_task_subject.date DESC, ej_subject.subject ASC, ej_task.task ASC LIMIT 50;";

  $conn = new mysqli($servername, $username, $password, $dbname);
  mysqli_set_charset($conn,'utf8');
  if ($conn->connect_error) die ("Connection failed: ".$conn->connect_error);

  $result2 = $conn->query($sql);
  if ($conn->error) {
    try { throw new Exception("MySQL error $mysqli->error <br> Query:<br> $query", $conn->errno); }
    catch(Exception $e) { echo "Error No: ".$e->getCode()." - ".$e->getMessage()."<br>".nl2br($e->getTraceAsString()); }
  }
  $conn->close();

  $result=[];
  if($result2->num_rows > 0) { while($row = $result2->fetch_assoc()) array_push($result,$row); }

  for ($i=0; $i < count($result); $i++) {
    $j = $i+1;
    if (isset($result[$j]) && ($result[$i]['date'] == $result[$j]['date']) && ($result[$i]['task'] == $result[$j]['task'])) {
      $table[$i]['date']=$result[$i]['date'];
      $table[$i]['subject']=$result[$i]['subject']."; ".$result[$j]['subject'];
      $table[$i]['task']=$result[$i]['task'];
      $i++;
    }
    else {
      $table[$i]['date']=$result[$i]['date'];
      $table[$i]['subject']=$result[$i]['subject'];
      $table[$i]['task']=$result[$i]['task'];
    }
  }

  for($i=0;$i<count($result);$i++){
    $array_date[]=$result[$i]['date'];
  }
  $array_count=array_count_values($array_date);
  $array_date=array_keys($array_count);
  for($i=0;$i<count($array_date);$i++){
    $array_date[$i]=strtotime($array_date[$i]);
  }
  $array_count=array_values($array_count);

?>

<script type="text/javascript">
  google.charts.load("current", {packages:["calendar"]});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'date', id: 'Date' });
    dataTable.addColumn({ type: 'number', id: 'Number' });
    dataTable.addRows([
      <?php
      for($i=0;$i<count($array_date);$i++){
        $month=date("n", $array_date[$i]);
        $month=$month-1;
        echo "[ new Date(".date("Y", $array_date[$i]).", ".$month.", ".date("d", $array_date[$i])."), ".$array_count[$i]." ], ";
      }
      ?>
      [ new Date(<?php $month=date("n", strtotime('tomorrow'));
      $month=$month-1;
      echo date("Y, ", strtotime('tomorrow')).$month.date(", d", strtotime('tomorrow')); ?>), 0 ]
    ]);

    var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

    var options = {
     title: "<?php echo $subject; ?>",
    };

    chart.draw(dataTable, options);
    }
    </script>
  <div id="calendar_basic" style="width: 1000px;"></div>

<?php

  echo build_table ($table);
?>
</div>
</div>
  <script src="js/selecttable.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
      dateFormat: "yy-mm-dd",
      firstDay: 1,
    });
  } );
  </script>
</body>
</html>