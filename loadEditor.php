<?php

require_once 'db.php';

// Get all the variables from the session
$pid = $_GET['a'];
$uname = $_GET['b'];


session_start();
$_SESSION['user'] = $uname;
$_SESSION['pid'] = $pid;

header("location: editor.php");
?>
