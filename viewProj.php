<?php

require_once 'db.php'; //goes into db

// Get all the variables from the session
$p_id = $_GET['a'];

$sql1= "SELECT * FROM projects WHERE p_id = '$p_id'"; //select all from projects where...
$result1 = mysqli_query($link, $sql1);
$projects = mysqli_fetch_row($result1);
$WBSPROJ = json_encode($projects);
echo $WBSPROJ; //echoes project as string

?>
