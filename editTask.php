<?php
//access DB
require_once 'db.php';
//access vars
$tid = $_REQUEST["a"];
$name = $_REQUEST["b"];
$desc = $_REQUEST["c"];
//edit task in DB
$sql= "UPDATE tasks SET t_name='$name', description='$desc' WHERE t_id='$tid'";
$result = mysqli_query($link, $sql);
?>
