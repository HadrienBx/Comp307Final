<?php

require_once 'db.php';

$tid = $_REQUEST["a"];
$name = $_REQUEST["b"];
$desc = $_REQUEST["c"];
$sql= "UPDATE tasks SET t_name='$name', description='$desc' WHERE t_id='$tid'";
$result = mysqli_query($link, $sql);


?>
