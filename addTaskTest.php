<?php

require_once 'db.php';

$pidChi = $_REQUEST["a"];
$tidParent = $_REQUEST["b"];
$depthChi = $_REQUEST["c"];
$nameChi = $_REQUEST["d"];
$widthChi;
$widthSib;
$tidSib;
$sql= "SELECT * FROM tasks WHERE p_id ='$pidChi' AND depth = '$depthChi' ORDER BY width DESC";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) == 0){       //row empty
  $widthChi = 0;
}else {
  $sql1= "SELECT * FROM tasks WHERE parent_id ='$tidParent'";
  $result1 = mysqli_query($link, $sql1);
  if (mysqli_num_rows($result1) != 0){                  //!empty, have sibling
    $sql1= "SELECT MAX(width) FROM tasks WHERE parent_id = '$tidParent'";
    $result1 = mysqli_query($link, $sql1);
    $result2 = mysqli_fetch_row($result1);
    $widthChi = $result2[0] + 1;
  }else{
    $widthChi = 0;
  }
}

$sql= "INSERT INTO tasks (p_id, parent_id, depth, width, t_name) VALUES ('$pidChi','$tidParent','$depthChi','$widthChi','$nameChi')";
mysqli_query($link, $sql);

?>
