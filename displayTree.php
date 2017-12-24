<?php
//access DB
require_once 'db.php';
//access vars
$pid = $_REQUEST["q"];
//select all tasks associated to project ordered by increasing depth,width
$sql= "SELECT * FROM tasks WHERE p_id ='$pid' ORDER BY depth, width";
$result = mysqli_query($link, $sql);
$tasks = mysqli_fetch_all($result,MYSQLI_ASSOC);
//return as JSON object
$WBStasks = json_encode($tasks);
echo $WBStasks;
?>
