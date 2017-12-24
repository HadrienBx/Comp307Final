<?php

require_once 'db.php'; //goes into db

$username1 = $_REQUEST["q"]; // q = username
$sql= "SELECT u_id FROM users WHERE username='$username1'"; //gets userid 
$result = mysqli_query($link, $sql); 
$userid = mysqli_fetch_row($result);
$uid = $userid[0]; // gets user id
$sql1= "SELECT * FROM projects WHERE p_id = ANY (SELECT p_id FROM project_user WHERE u_id ='$uid')"; //select all from projects where...
$result1 = mysqli_query($link, $sql1);
$projects = mysqli_fetch_all($result1,MYSQLI_ASSOC);
$WBSPROJ = json_encode($projects);
echo $WBSPROJ; //echoes all projects into a JSON string for displayProjectFunction in welcome.php

?>
