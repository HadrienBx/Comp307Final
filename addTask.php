<?php
//acces db > $link
require_once 'db.php';
//obtain variables
$pidChi = $_REQUEST["a"];
$tidParent = $_REQUEST["b"];
$depthChi = $_REQUEST["c"];
$nameChi = $_REQUEST["d"];
$widthChi;
$widthSib;
$tidSib;
//select all tasks in project with depth of task to be added
$sql= "SELECT * FROM tasks WHERE p_id ='$pidChi' AND depth = '$depthChi' ORDER BY width DESC";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) == 0){
  //if no nodes, width = 0;
  $widthChi = 0;
}else {
  //else exist tasks at that depth
  //select all siblings of task to be added
  $sql1= "SELECT * FROM tasks WHERE parent_id ='$tidParent'";
  $result1 = mysqli_query($link, $sql1);
  if (mysqli_num_rows($result1) != 0){
    //if have siblings, select max width for them (right most child)
    $sql1= "SELECT MAX(width) FROM tasks WHERE parent_id = '$tidParent'";
    $result1 = mysqli_query($link, $sql1);
    $result2 = mysqli_fetch_row($result1);
    //set width to right most child +1 because we add child to the right by default
    $widthChi = $result2[0] + 1;
  }else{
    //otherwise task to be added is only child, width=0
    $widthChi = 0;
  }
}
//insert into DB
$sql= "INSERT INTO tasks (p_id, parent_id, depth, width, t_name) VALUES ('$pidChi','$tidParent','$depthChi','$widthChi','$nameChi')";
mysqli_query($link, $sql);

?>
