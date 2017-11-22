<?php
// Initialize the session
session_start();

require_once 'db.php';

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
$color= "red";
$username1= $_SESSION['username'];
$sql = "SELECT color FROM users WHERE username='$username1'";
$result = mysqli_query($link, $sql);
$color1 = mysqli_fetch_assoc($result);
$color = $color1["color"];

// For displaying projects
$sql_u_query = "SELECT u_id FROM users WHERE username='$username1'"; // query to get u_id
$sql_u_result = mysqli_query($link, $sql_u_query); // parse for query
$userid = mysqli_fetch_row($sql_u_result);
$sql_p_query = "SELECT p_id FROM project_user WHERE u_id='$userid[0]'"; // userid[0] accesses u_id as a string
$sql_p_result = mysqli_query($link, $sql_p_query); // gets all p_id's associated with current user
  while ($pid = mysqli_fetch_array($sql_p_result)){
    // for each p_id
    $sql_pname_query = "SELECT * FROM projects WHERE p_id='$pid[0]'"; // pid[0] accesses p_id as a string
    $sql_pname_result = mysqli_query($link, $sql_pname_query); // gets all projects associated with current p_id
    $aproject = mysqli_fetch_row($sql_pname_result); // echo out data for each project, being $aproject
    
    $json_proj = json_encode($aproject); // makes project a JSON file

    $proj_string = json_decode($json_proj);
    //var_dump($proj_string);

    // printing out JSON String
    echo "<br><br>";
    echo "<br><br>";    
    echo $proj_string[0];
    echo "<br><br>";    
    echo $proj_string[2];
    echo "<br><br>";    
    echo $proj_string[1];
    echo "<br><br>";
    echo "<br><br>";
    

    // printing out in PHP
    /*
    echo "<br>";
    echo "<br>Project ID: ";
    echo $aproject[0];
    echo "<br>Project Name: ";
    echo $aproject[1];
    echo "<br>Project Type: ";
    echo $aproject[2];
    echo "<br>Project Description: ";
    echo $aproject[3];
    */
    // $aproject[5] contains due date
  }

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $sql = "UPDATE users SET login = '0' WHERE username = ?";
  if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username1;
    mysqli_stmt_execute($stmt);
  }else {
    echo "nope.";
  }

  $_SESSION = array();
  session_destroy();
  header("location: login.php");
  exit;
  mysqli_stmt_close($stmt);
}


mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo $_SESSION['username']; ?></b>. Welcome to our site.</h1>
        <!-- <h1>Hi, <b><?php echo $color; ?></b>. Welcome to our site.</h1> -->
    </div>
    <p><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="submit" value="Logout!"></p>
</body>
</html>
