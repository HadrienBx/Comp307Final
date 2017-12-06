<?php

require_once 'db.php';

$pid = $_REQUEST["q"];
$sql= "SELECT * FROM tasks WHERE p_id ='$pid' ORDER BY depth, width";
$result = mysqli_query($link, $sql);
$tasks = mysqli_fetch_all($result,MYSQLI_ASSOC);
$WBStasks = json_encode($tasks);
echo $WBStasks;

?>
