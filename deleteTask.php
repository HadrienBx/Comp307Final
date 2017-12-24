<?php
//acces DB
require_once 'db.php';
//acces vars
$tidDel = $_REQUEST["a"];
$parentDel = $_REQUEST["b"];
$depthDel = $_REQUEST["c"];
$widthDel = $_REQUEST["d"];
$pidDel = $_REQUEST["e"];
$delAll = $_REQUEST["f"];

//recursive delete subtree for delete all subtree
function delChild($tid3){
  global $link;
  $sql= "DELETE FROM tasks WHERE t_id ='$tid3'";
  mysqli_query($link, $sql);
  $sql= "SELECT * FROM tasks WHERE parent_id ='$tid3'";
  $result = mysqli_query($link, $sql);
  if (mysqli_num_rows($result) != 0){
    //have children, so delete them and call function on children to delete their children
    while($task = mysqli_fetch_row($result)){
      $tid3 = $task[1];
      delChild($tid3);
    }
  }
}
//recursive update depth of nodes under single node to be deleted
function updateChild($tid2){
  global $link;
  $sql= "SELECT * FROM tasks WHERE parent_id ='$tid2'";
  $result = mysqli_query($link, $sql);
  if (mysqli_num_rows($result) != 0){
    //have children > update child depth
    while($task = mysqli_fetch_row($result)){
      $tid3 = $task[1];
      //decrease depth by 1
      $dep3 = $task[3] - 1;
      $sql= "UPDATE tasks SET depth='$dep3' WHERE t_id='$tid3'";
      mysqli_query($link, $sql);
      //update children of children
      updateChild($tid3);
    }
  }
}
//main
if ($delAll == 1){
//delete all subtree
  //select all sibling to the right of task to be deleted
  $sql= "SELECT * FROM tasks WHERE parent_id ='$parentDel' AND width > '$widthDel'";
  $result = mysqli_query($link, $sql);
  if (mysqli_num_rows($result) != 0){
    while($task = mysqli_fetch_row($result)){
      $tid1 = $task[1];
      //decrease siblings width by 1
      $wid1 = $task[4] - 1;
      $sql= "UPDATE tasks SET width='$wid1' WHERE t_id='$tid1'";
      mysqli_query($link, $sql);
    }
  }
  //delete all children and chilren of children.....
  delChild($tidDel);
}else{
//delete only node
  //calculate #children of node to be deleted
  $sql= "SELECT * FROM tasks WHERE parent_id ='$tidDel' ORDER BY width";
  $result = mysqli_query($link, $sql);
  $sibs = mysqli_num_rows($result);
  //edit width of siblings to the right of node to be deleted to += #children of deleted node -1
  $sql= "SELECT * FROM tasks WHERE parent_id ='$parentDel' AND width > '$widthDel'";
  $result1 = mysqli_query($link, $sql);
  while($task = mysqli_fetch_row($result1)){
      $wid3= $task[4] + $sibs - 1;
      $tid3 = $task[1];
      $sql= "UPDATE tasks SET width='$wid3' WHERE t_id='$tid3'";
      mysqli_query($link, $sql);
  }
  if ($sibs != 0){
    //if node to be deleted has children
    $i = 0;
    //update depth width and parentID of immidiate children
    while($task = mysqli_fetch_row($result)){
      $tid2 = $task[1];
      $wid2 = $widthDel + $i;
      $par2 = $parentDel;
      $dep2 = $depthDel;
      $sql= "UPDATE tasks SET parent_id='$par2', depth='$dep2', width='$wid2' WHERE t_id='$tid2'";
      mysqli_query($link, $sql);
      //recursively update depth subtree
      updateChild($tid2);
      $i = $i + 1;
    }
  } else {
  //have no children
    //edit width right siblings -= 1
    $sql= "SELECT * FROM tasks WHERE parent_id ='$parentDel' AND width >= '$widthDel'";
    $result = mysqli_query($link, $sql);
    while($task = mysqli_fetch_row($result)){
      $wid3= $task[4] - 1;
      $tid3 = $task[1];
      $sql= "UPDATE tasks SET width='$wid3' WHERE t_id='$tid3'";
      mysqli_query($link, $sql);
    }
  }
  //delete task
  $sql= "DELETE FROM tasks WHERE t_id ='$tidDel'";
  $result = mysqli_query($link, $sql);
}
?>
