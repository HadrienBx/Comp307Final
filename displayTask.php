<?php

require_once 'db.php';

$tid = $_REQUEST["q"];
$sql= "SELECT * FROM tasks WHERE t_id='$tid'";
$result = mysqli_query($link, $sql);
$task = mysqli_fetch_row($result);
$taskinfo = json_encode($task);
echo $taskinfo;



?>
