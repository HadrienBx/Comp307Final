<?php

require_once 'db.php';

// Get all the variables from the session
$name = $_GET['q'];
$type = $_GET['y'];
$user = $_GET['z'];
$description = $_GET['x'];
$image = $_GET['a'];
$due = $_GET['b'];
//$image = $_GET['b'];

// Insert into the sql table
$sql= "INSERT INTO projects (p_name, type, description, due_date, img) VALUES ('$name','$type','$description', '$due','$image')";
mysqli_query($link, $sql);

// We also have to add into the "project_user" table so the it can get displayed
// in the brower by fethching the p_id

// So here we get the p_id
$sql_pid= "SELECT p_id FROM projects where p_name = '$name'";
$result_pid=mysqli_query($link, $sql_pid);
$p_id = mysqli_fetch_row($result_pid);
$pid = $p_id[0];

// GET user ID
$sql_uid= "SELECT u_id FROM users WHERE username='$user'";
$result_uid = mysqli_query($link, $sql_uid);
$userid = mysqli_fetch_row($result_uid);
$uid = $userid[0];

//insert in the project_user table with p_id and u_id
$sql_proj= "INSERT INTO project_user (p_id, u_id) VALUES ('$pid','$uid')";
mysqli_query($link, $sql_proj);

//create root task
$sql_task= "INSERT INTO tasks (p_id, parent_id, depth, width, t_name) VALUES ('$pid','0','0','0','$name')";
mysqli_query($link, $sql_task);

?>
