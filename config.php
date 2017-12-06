<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'iw3htp');
define('DB_PASSWORD', 'aJzB_918220');
define('DB_NAME', '307_proj');

// connect
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// check connection
if ($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>