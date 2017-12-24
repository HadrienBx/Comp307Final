<?php

// THIS PHP FILE EXPECTS TO RECEIVE THE PROJECT NAME
require_once 'db.php';

// Get all the variables from the session
$pid = $_GET['a'];
$uname = $_GET['b'];

//Delete all projects with that p_id
$sql_del="DELETE FROM projects WHERE p_id='$pid'";
mysqli_query($link, $sql_del);

//Delete all project_user with that p_id
$sql_del_user="DELETE FROM project_user WHERE p_id='$pid'";
mysqli_query($link, $sql_del_user);

//Delete all tasks with that p_id
$sql_del_tasks="DELETE FROM tasks WHERE p_id='$pid'";
mysqli_query($link, $sql_del_tasks);


?>
