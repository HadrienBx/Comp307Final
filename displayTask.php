<?php
//access DB
require_once 'db.php';
//acces var
$tid = $_REQUEST["q"];
//select row = task info from table tasks
$sql= "SELECT * FROM tasks WHERE t_id='$tid'";
$result = mysqli_query($link, $sql);
$task = mysqli_fetch_row($result);
//return json obj of task info
$taskinfo = json_encode($task);
echo $taskinfo;
?>
